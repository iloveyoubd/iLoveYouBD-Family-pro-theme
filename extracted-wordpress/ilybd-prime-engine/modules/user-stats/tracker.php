<?php
/**
 * Module: Complete Engagement Tracker (View, Like, Share, Comment)
 * Description: Precision tracking for iloveyoubd.com with automated rewards.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_Stats_Tracker {

    private static $instance = null;
    private $table_stats;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        global $wpdb;
        $this->table_stats = $wpdb->prefix . 'ilybd_stats';

        // ১. নিখুঁত ভিউ ট্র্যাকিং (পেজ লোড হওয়ার সাথে সাথে)
        add_action( 'wp_head', array( $this, 'track_pure_view' ) );

        // ২. কমেন্ট ট্র্যাকিং (কমেন্ট এপ্রুভ হলে পয়েন্ট পাবে)
        add_action( 'comment_post', array( $this, 'track_comment_action' ), 10, 3 );

        // ৩. লাইক ও শেয়ার ট্র্যাকিং (AJAX এর মাধ্যমে)
        add_action( 'wp_ajax_ilybd_social_action', array( $this, 'process_social_ajax' ) );
        add_action( 'wp_ajax_nopriv_ilybd_social_action', array( $this, 'process_social_ajax' ) );
    }

    /**
     * ভিউ ট্র্যাকিং লজিক: ডুপ্লিকেট ভিউ ফিল্টার করবে
     */
    public function track_pure_view() {
        if ( ! is_singular() ) return;

        global $post, $wpdb;
        $post_id = $post->ID;
        $user_id = get_current_user_id() ?: 0;
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // ট্রানজিয়েন্ট ব্যবহার করে একই আইপি থেকে ১০ মিনিটে একবারই ভিউ কাউন্ট হবে (Precision)
        $view_lock = get_transient( 'ilybd_view_lock_' . $post_id . '_' . str_replace('.', '_', $ip_address) );
        
        if ( ! $view_lock ) {
            $wpdb->query( $wpdb->prepare(
                "INSERT INTO {$this->table_stats} (post_id, user_id, views, timestamp) 
                 VALUES (%d, %d, 1, %s) 
                 ON DUPLICATE KEY UPDATE views = views + 1",
                $post_id, $user_id, current_time( 'mysql' )
            ));

            // ভিউর জন্য ০.৫ পয়েন্ট রিওয়ার্ড
            if ( $user_id > 0 ) {
                do_action( 'ilybd_add_points', $user_id, 0.5, 'Content View' );
            }

            // ১০ মিনিটের জন্য ভিউ লক করা যাতে ফেক ভিউ না বাড়ে
            set_transient( 'ilybd_view_lock_' . $post_id . '_' . str_replace('.', '_', $ip_address), true, 600 );
        }
    }

    /**
     * কমেন্ট ট্র্যাকিং ও রিওয়ার্ড
     */
    public function track_comment_action( $comment_ID, $comment_approved, $commentdata ) {
        $user_id = $commentdata['user_ID'];
        
        if ( $user_id > 0 ) {
            // কমেন্ট করার জন্য ১৫ পয়েন্ট রিওয়ার্ড (Engagement Booster)
            do_action( 'ilybd_add_points', $user_id, 15, 'Comment on Post' );
        }
    }

    /**
     * লাইক ও শেয়ার ট্র্যাকিং (নিখুঁত AJAX লজিক)
     */
    public function process_social_ajax() {
        global $wpdb;
        
        $post_id = intval( $_POST['post_id'] );
        $type    = sanitize_text_field( $_POST['action_type'] ); // 'like' or 'share'
        $user_id = get_current_user_id() ?: 0;

        if ( $type === 'like' ) {
            // লাইক কাউন্ট বাড়ানো (মেটা ডাটা হিসেবে স্টোর করা ভালো দ্রুত দেখানোর জন্য)
            $current_likes = get_post_meta( $post_id, '_ilybd_likes', true ) ?: 0;
            update_post_meta( $post_id, '_ilybd_likes', $current_likes + 1 );
            
            // লাইকের জন্য ১০ পয়েন্ট
            if ( $user_id > 0 ) do_action( 'ilybd_add_points', $user_id, 10, 'Post Like' );

        } elseif ( $type === 'share' ) {
            // শেয়ার কাউন্ট আপডেট
            $wpdb->query( $wpdb->prepare(
                "UPDATE {$this->table_stats} SET shares = shares + 1 WHERE post_id = %d",
                $post_id
            ));
            
            // শেয়ারের জন্য ২৫ পয়েন্ট (সবচেয়ে বেশি ইনকাম এর সুযোগ শেয়ারে)
            if ( $user_id > 0 ) do_action( 'ilybd_add_points', $user_id, 25, 'Social Share' );
        }

        wp_send_json_success( array( 'status' => 'success', 'site' => 'iloveyoubd.com' ) );
    }

    /**
     * ফ্রন্টএন্ডে স্ট্যাটাস দেখানোর জন্য হেল্পার ফাংশন
     */
    public static function get_engagement_count( $post_id ) {
        global $wpdb;
        $table = $wpdb->prefix . 'ilybd_stats';
        
        $views = $wpdb->get_var( $wpdb->prepare( "SELECT SUM(views) FROM $table WHERE post_id = %d", $post_id ) ) ?: 0;
        $shares = $wpdb->get_var( $wpdb->prepare( "SELECT SUM(shares) FROM $table WHERE post_id = %d", $post_id ) ) ?: 0;
        $likes = get_post_meta( $post_id, '_ilybd_likes', true ) ?: 0;
        $comments = get_comments_number( $post_id );

        return array(
            'views'    => $views,
            'likes'    => $likes,
            'shares'   => $shares,
            'comments' => $comments
        );
    }
}

// লোড মডিউল
ILYBD_Stats_Tracker::get_instance();
