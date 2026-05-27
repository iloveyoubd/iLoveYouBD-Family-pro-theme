<?php
/**
 * Module: Daily Rewards & Bonus System
 * Description: Gives daily login points and handles special offers for iloveyoubd.com users.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_Rewards_Engine {

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // ইউজার লগইন করার সময় বা সাইট ভিজিট করার সময় ডেইলি বোনাস চেক
        add_action( 'wp_login', array( $this, 'check_daily_bonus' ), 10, 2 );
        add_action( 'wp_head', array( $this, 'auto_check_loyalty' ) );
    }

    /**
     * ডেইলি বোনাস লজিক
     */
    public function check_daily_bonus( $user_login, $user ) {
        $user_id = $user->ID;
        $this->process_reward( $user_id );
    }

    /**
     * যারা লগইন অবস্থায় সাইট ব্রাউজ করছে তাদের জন্য অটো চেক
     */
    public function auto_check_loyalty() {
        if ( is_user_logged_in() ) {
            $this->process_reward( get_current_user_id() );
        }
    }

    /**
     * বোনাস প্রসেসিং (প্রতি ২৪ ঘণ্টায় একবার)
     */
    private function process_reward( $user_id ) {
        $last_bonus_date = get_user_meta( $user_id, '_ilybd_last_bonus_date', true );
        $today = date( 'Y-m-d' );

        if ( $last_bonus_date !== $today ) {
            // প্রতিদিন লগইন বোনাস হিসেবে ১০০ পয়েন্ট
            $bonus_points = 100;
            
            if ( function_exists( 'ILYBD_Wallet' ) ) {
                do_action( 'ilybd_add_points', $user_id, $bonus_points, 'Daily Login Bonus' );
                
                // লাস্ট বোনাস ডেট আপডেট করা
                update_user_meta( $user_id, '_ilybd_last_bonus_date', $today );
                
                // ইউজারের জন্য একটি ডাইনামিক নোটিফিকেশন ফ্লাগ (থিম থেকে শো করার জন্য)
                set_transient( 'ilybd_bonus_notif_' . $user_id, 'অভিনন্দন! আপনি ১০০ পয়েন্ট ডেইলি বোনাস পেয়েছেন।', 30 );
            }
        }
    }

    /**
     * অফার ওয়াল (টেলিকম বা স্পেশাল অফার ডিসপ্লে করার জন্য)
     */
    public static function get_special_offers() {
        // বস্, এখানে আপনি আপনার টেলিকম অফার বা স্পেশাল ড্রাইভের লিস্ট রাখতে পারেন
        return array(
            array(
                'title' => '৫০ জিবি ধামাকা অফার',
                'desc'  => 'জিপি সিমে ৫৯৯ টাকায় ৫০ জিবি পান সাথে ২০০ পয়েন্ট বোনাস।',
                'link'  => 'https://iloveyoubd.com/offers'
            ),
            array(
                'title' => 'প্রিমিয়াম মেম্বারশিপ',
                'desc'  => 'সরাসরি ২০% কমিশন রেট আনলক করুন।',
                'link'  => '#'
            )
        );
    }
}

// ইঞ্জিন অ্যাক্টিভেট করা
ILYBD_Rewards_Engine::get_instance();
