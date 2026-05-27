<?php
/**
 * Module: API Balancer & Rotator
 * Description: Handles 50+ API keys for ILYBD.COM with auto-failover and rotation.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_API_Balancer {

    private static $instance = null;
    private $api_keys = array();
    private $current_key_index = 0;
    private $option_name = 'ilybd_api_keys_pool';

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->load_keys();
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    /**
     * এডমিন প্যানেল থেকে এপিআই কি সেভ করার অপশন
     */
    public function register_settings() {
        register_setting( 'ilybd_settings_group', $this->option_name );
    }

    /**
     * ডাটাবেস থেকে সব এপিআই কি লোড করা
     */
    private function load_keys() {
        $saved_keys = get_option( $this->option_name );
        if ( ! empty( $saved_keys ) ) {
            // এক্সপ্লোড করে এরি তৈরি করা (কমা দিয়ে আলাদা করা কি-সমূহ)
            $this->api_keys = array_map( 'trim', explode( ',', $saved_keys ) );
        }
        
        // কারেন্ট ইনডেক্স ট্র্যাক করা
        $this->current_key_index = get_transient( 'ilybd_current_api_index' ) ?: 0;
    }

    /**
     * মাস্টার ফাংশন: রোটেটিং এপিআই কি রিটার্ন করবে
     */
    public function get_active_key() {
        if ( empty( $this->api_keys ) ) {
            return false;
        }

        $total_keys = count( $this->api_keys );
        
        // যদি ইনডেক্স লিমিট ক্রস করে, তবে ০ থেকে শুরু হবে
        if ( $this->current_key_index >= $total_keys ) {
            $this->current_key_index = 0;
        }

        $active_key = $this->api_keys[ $this->current_key_index ];

        return $active_key;
    }

    /**
     * যদি কোনো কি এর লিমিট শেষ হয়, তবে এটি কল করে পরের কি-তে সুইচ করা হবে
     */
    public function switch_to_next_key() {
        $total_keys = count( $this->api_keys );
        $this->current_key_index++;

        if ( $this->current_key_index >= $total_keys ) {
            $this->current_key_index = 0;
        }

        set_transient( 'ilybd_current_api_index', $this->current_key_index, DAY_IN_SECONDS );
        return $this->get_active_key();
    }

    /**
     * এআই রিকোয়েস্ট হ্যান্ডলার (জেমিনি বা অন্যান্য এপিআই এর জন্য)
     * এটি অটোমেটিক রোটেশন মেইনটেইন করে রিকোয়েস্ট পাঠাবে
     */
    public function call_ai_api( $endpoint, $post_data ) {
        $api_key = $this->get_active_key();
        
        if ( ! $api_key ) {
            return array( 'error' => 'No API Keys configured for iloveyoubd.com' );
        }

        // এপিআই এন্ডপয়েন্টে কি যুক্ত করা
        $url = add_query_arg( 'key', $api_key, $endpoint );

        $response = wp_remote_post( $url, array(
            'body'    => json_encode( $post_data ),
            'headers' => array( 'Content-Type' => 'application/json' ),
            'timeout' => 60,
        ));

        // যদি কি এর লিমিট শেষ হয় (সাধারণত ৪২৯ এরর) তবে কি পাল্টে আবার ট্রাই করবে
        $response_code = wp_remote_retrieve_response_code( $response );
        
        if ( $response_code == 429 || $response_code == 401 ) {
            $this->switch_to_next_key();
            return $this->call_ai_api( $endpoint, $post_data ); // রিকার্সিভ কল নতুন কি দিয়ে
        }

        return json_decode( wp_remote_retrieve_body( $response ), true );
    }
}

// গ্লোবাল ফাংশন যাতে অন্য মডিউল সহজে ব্যবহার করতে পারে
function ILYBD_API() {
    return ILYBD_API_Balancer::get_instance();
}
