<?php
/**
 * Module: AI Assistant Logic
 * Description: Powers the floating 3D AI Robot for real-time user guidance.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_AI_Assistant {

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // AJAX হুকস যাতে ইউজার মেসেজ পাঠালে পেজ রিলোড ছাড়াই উত্তর পায়
        add_action( 'wp_ajax_ilybd_ai_chat', array( $this, 'process_ai_chat' ) );
        add_action( 'wp_ajax_nopriv_ilybd_ai_chat', array( $this, 'process_ai_chat' ) );
        
        // ফ্রন্টএন্ডে প্রয়োজনীয় স্ক্রিপ্ট লোড করা
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_ai_assets' ) );
    }

    /**
     * এআই অ্যাসিস্ট্যান্টের জন্য ফ্রন্টএন্ড ডাইনামিক ডেটা লোড
     */
    public function enqueue_ai_assets() {
        wp_localize_script( 'jquery', 'ilybd_ai_vars', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'ilybd_ai_nonce' ),
            'bot_name' => 'ILYBD Assistant'
        ));
    }

    /**
     * মূল চ্যাট প্রসেসিং ফাংশন
     */
    public function process_ai_chat() {
        check_ajax_referer( 'ilybd_ai_nonce', 'nonce' );

        $user_message = sanitize_text_field( $_POST['message'] );
        $user_id = get_current_user_id();
        
        // ইউজারের বর্তমান স্ট্যাটাস আনা (Wallet মডিউল থেকে)
        $user_data = "Guest User";
        if ( $user_id && function_exists( 'ILYBD_Wallet' ) ) {
            $data = ILYBD_Wallet()->get_user_wallet_data( $user_id );
            $user_data = "User Level: " . $data->user_level . ", Balance: " . $data->balance . " BDT";
        }

        // এআই-এর জন্য প্রম্পট সেট করা
        $system_prompt = "You are the AI Assistant of ILOVEYOUBD.COM. Your tone is helpful, witty, and supportive. 
                          You guide users on how to use tools and earn more money through our 10-20% ad share system. 
                          User Status: $user_data. Website Name: iloveyoubd.com. 
                          Keep answers concise and prioritize user success.";

        // এপিআই রোটেশন ইঞ্জিন ব্যবহার করে এআই কল করা
        if ( class_exists( 'ILYBD_API_Balancer' ) ) {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent";
            $post_data = array(
                'contents' => array(
                    array(
                        'parts' => array(
                            array( 'text' => $system_prompt . "\nUser: " . $user_message )
                        )
                    )
                )
            );

            $ai_response = ILYBD_API()->call_ai_api( $endpoint, $post_data );

            if ( isset( $ai_response['candidates'][0]['content']['parts'][0]['text'] ) ) {
                $reply = $ai_response['candidates'][0]['content']['parts'][0]['text'];
            } else {
                $reply = "বস্, নেটওয়ার্কে একটু জ্যাম আছে। আমি আপনার জন্য আবার চেষ্টা করছি!";
            }
        } else {
            $reply = "Sorry, AI Engine is not connected.";
        }

        wp_send_json_success( array( 'reply' => $reply ) );
    }
}

// ইনিশিয়ালাইজেশন
ILYBD_AI_Assistant::get_instance();
