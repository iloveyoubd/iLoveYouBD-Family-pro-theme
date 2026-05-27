<?php
/**
 * Module: Wallet & Economy System
 * Description: Handles Points, BDT Conversion, Level-up, and 10-20% Ad Revenue Share.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_Wallet_System {

    private static $instance = null;
    private $table_wallet;
    private $table_stats;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        global $wpdb;
        $this->table_wallet = $wpdb->prefix . 'ilybd_wallet';
        $this->table_stats  = $wpdb->prefix . 'ilybd_stats';

        // ইউজারের অ্যাকশনের ওপর ভিত্তি করে পয়েন্ট যোগ করার হুকস
        add_action( 'ilybd_add_points', array( $this, 'add_points' ), 10, 3 );
        add_action( 'ilybd_track_ad_revenue', array( $this, 'process_ad_revenue_share' ), 10, 3 );
    }

    /**
     * ইউজারের লেভেল ক্যালকুলেশন লজিক
     * ১-১০ লেভেল: ১০% কমিশন
     * ১১-৫০ লেভেল: ১৫% কমিশন
     * ৫০+ লেভেল: ২০% কমিশন (ILYBD Legend)
     */
    public function get_user_commission_rate( $user_id ) {
        $data = $this->get_user_wallet_data( $user_id );
        $level = $data ? $data->user_level : 1;

        if ( $level >= 50 ) {
            return 0.20; // ২০%
        } elseif ( $level >= 11 ) {
            return 0.15; // ১৫%
        } else {
            return 0.10; // ১০%
        }
    }

    /**
     * মাস্টার লজিক: অ্যাড রেভিনিউ শেয়ারিং
     * $original_revenue: ওই পোস্ট থেকে আপনার মোট এডসেন্স ইনকাম (আনুমানিক)
     */
    public function process_ad_revenue_share( $user_id, $post_id, $original_revenue ) {
        global $wpdb;

        $commission_rate = $this->get_user_commission_rate( $user_id );
        $user_share = $original_revenue * $commission_rate;

        // ইউজারের ব্যালেন্সে টাকা যোগ করা
        $wpdb->query( $wpdb->prepare(
            "UPDATE {$this->table_wallet} 
             SET balance = balance + %f, total_earned = total_earned + %f 
             WHERE user_id = %d",
            $user_share, $user_share, $user_id
        ));

        // স্ট্যাটাস টেবিলে রেকর্ড রাখা
        $wpdb->insert( $this->table_stats, array(
            'post_id' => $post_id,
            'user_id' => $user_id,
            'revenue' => $user_share,
            'timestamp' => current_time( 'mysql' )
        ));

        // --- SYNCHRONIZATION WITH USER META ---
        $current_bd_data = $this->get_user_wallet_data( $user_id );
        if ( $current_bd_data ) {
            update_user_meta( $user_id, 'user_balance', (float) $current_bd_data->balance );
            
            // নোটিফিকেশন যুক্ত করুন
            if ( function_exists( 'ilybd_add_user_notification' ) ) {
                $n_msg = sprintf("💰 পোস্ট আইডি %d এর এড রেভিনিউ শেয়ার থেকে ৳%s আর্ন করেছেন!", $post_id, number_format($user_share, 2));
                ilybd_add_user_notification($user_id, $n_msg);
            }
        }
    }

    /**
     * পয়েন্ট যোগ করা এবং অটো লেভেল-আপ
     */
    public function add_points( $user_id, $points_to_add, $reason = '' ) {
        global $wpdb;

        // চেক করা ইউজার আগে থেকে টেবিলে আছে কি না
        $exists = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$this->table_wallet} WHERE user_id = %d", $user_id ) );

        if ( ! $exists ) {
            $wpdb->insert( $this->table_wallet, array( 'user_id' => $user_id, 'points' => 0, 'balance' => 0 ) );
        }

        // পয়েন্ট আপডেট
        $wpdb->query( $wpdb->prepare(
            "UPDATE {$this->table_wallet} SET points = points + %d WHERE user_id = %d",
            $points_to_add, $user_id
        ));

        // লেভেল আপ লজিক: প্রতি ৫০০ পয়েন্টে ১ লেভেল বাড়বে
        $current_points = $wpdb->get_var( $wpdb->prepare( "SELECT points FROM {$this->table_wallet} WHERE user_id = %d", $user_id ) );
        $new_level = floor( $current_points / 500 ) + 1;

        $wpdb->update( $this->table_wallet, array( 'user_level' => $new_level ), array( 'user_id' => $user_id ) );

        // --- SYNCHRONIZATION WITH USER META ---
        update_user_meta( $user_id, 'ilybd_total_points', $current_points );
        update_user_meta( $user_id, 'user_points', $current_points );
        update_user_meta( $user_id, 'ilybd_points', $current_points );

        if ( function_exists( 'ilybd_add_user_notification' ) && !empty($reason) ) {
            $reason_text = __($reason, 'ilybd-prime');
            ilybd_add_user_notification($user_id, sprintf("🎯 আপনি পেয়েছেন %d XP! (কারণ: %s)", $points_to_add, $reason_text));
        }
    }

    /**
     * ইউজারের কারেন্ট ব্যালেন্স ও ডাটা গেট করা
     */
    public function get_user_wallet_data( $user_id ) {
        global $wpdb;
        return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$this->table_wallet} WHERE user_id = %d", $user_id ) );
    }

    /**
     * টাকা উইথড্রয়াল রিকোয়েস্ট (বিকাশ/নগদ)
     */
    public function request_withdrawal( $user_id, $amount, $method, $account_no ) {
        global $wpdb;
        $data = $this->get_user_wallet_data( $user_id );

        if ( $data && $data->balance >= $amount ) {
            // ব্যালেন্স হোল্ড করা
            $wpdb->query( $wpdb->prepare(
                "UPDATE {$this->table_wallet} SET balance = balance - %f WHERE user_id = %d",
                $amount, $user_id
            ));
            
            // --- SYNCHRONIZATION WITH USER META ---
            update_user_meta( $user_id, 'user_balance', (float) ($data->balance - $amount) );
            
            // থিম এর মেটা ওয়ালেটে রিকোয়েস্ট তৈরি
            $withdrawals = get_user_meta($user_id, 'ilybd_withdrawals', true);
            $withdrawals = is_array($withdrawals) ? $withdrawals : [];
            $req_id = 'w_' . time() . '_' . rand(100, 999);
            $withdrawals[] = [
                'id'     => $req_id,
                'method' => $method,
                'number' => $account_no,
                'amount' => $amount,
                'date'   => current_time('mysql'),
                'status' => 'pending'
            ];
            update_user_meta($user_id, 'ilybd_withdrawals', $withdrawals);

            if ( function_exists( 'ilybd_add_user_notification' ) ) {
                $n_msg = sprintf("💸 ৳%s টাকার উইথড্রয়াল রিকোয়েস্ট (%s) পেন্ডিং এ সাবমিট করা হয়েছে।", number_format($amount, 2), $method);
                ilybd_add_user_notification($user_id, $n_msg);
            }

            return true;
        }
        return false;
    }
}

// ইঞ্জিন ইনিশিয়ালাইজেশন
function ILYBD_Wallet() {
    return ILYBD_Wallet_System::get_instance();
}
