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
        $level = $data ? (int)$data->user_level : 1;

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
        $commission_rate = $this->get_user_commission_rate( $user_id );
        $user_share = $original_revenue * $commission_rate;

        if ( function_exists('ilybd_add_user_balance_or_points') ) {
            $rev_reason = sprintf( "পোস্ট আইডি %d এর প্রিমিয়াম অ্যাড রেভিনিউ শেয়ার বোনাস", $post_id );
            ilybd_add_user_balance_or_points($user_id, $user_share, 0, $rev_reason, (string)$post_id, 'post');

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
        if ( function_exists('ilybd_add_user_balance_or_points') && $points_to_add != 0 ) {
            $log_reason = !empty($reason) ? $reason : "কমিউনিটি সাদা টুপি কন্ট্রিবিউটর অ্যাক্টিভিটি বুস্ট";
            ilybd_add_user_balance_or_points($user_id, 0, $points_to_add, $log_reason);
        }
    }

    /**
     * ইউজারের কারেন্ট ব্যালেন্স ও ডাটা গেট করা
     */
    public function get_user_wallet_data( $user_id ) {
        if ( function_exists( 'ilybd_ensure_user_wallet_initialized' ) ) {
            return ilybd_ensure_user_wallet_initialized( $user_id );
        }
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

            // লেজার ট্রানজেকশন বিয়োগ রাইট করা
            if ( function_exists( 'ilybd_add_ledger_transaction' ) ) {
                $withdraw_log_reason = sprintf( "উইথড্রল ক্যাশআউট রিকোয়েস্ট (%s নম্বর: %s)", strtoupper($method), $account_no );
                ilybd_add_ledger_transaction( $user_id, -$amount, 'BDT', $withdraw_log_reason, $req_id, 'admin' );
            }

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
