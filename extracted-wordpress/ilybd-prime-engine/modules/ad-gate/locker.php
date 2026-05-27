<?php
/**
 * Module: Ad-Gate & Content Locker
 * Description: Forces users to engage with ads before accessing premium tools or downloads.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_Ad_Gate {

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // ফ্রন্টএন্ডে লকিং স্ক্রিপ্ট লোড করা
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_locker_assets' ) );
        
        // শর্টকোড তৈরি করা [ilybd_lock] কন্টেন্ট [/ilybd_lock]
        add_shortcode( 'ilybd_lock', array( $this, 'render_locked_content' ) );
    }

    /**
     * লকিং লজিক স্ক্রিপ্ট
     */
    public function enqueue_locker_assets() {
        wp_add_inline_script( 'jquery', "
            function unlockContent(postId) {
                // এখানে ভিডিও অ্যাড পপআপ বা টাইমার লজিক কাজ করবে
                alert('অ্যাড দেখার জন্য ধন্যবাদ! আপনার ডাউনলোড শুরু হচ্ছে...');
                jQuery('#ilybd-locked-' + postId).fadeOut();
                jQuery('#ilybd-content-' + postId).fadeIn();
                
                // এপিআই-তে জানানো যে ইউজার অ্যাড দেখেছে (পয়েন্ট রিওয়ার্ড)
                jQuery.post(ilybd_ai_vars.ajax_url, {
                    action: 'ilybd_track_social',
                    post_id: postId,
                    social_action: 'ad_view',
                    nonce: ilybd_ai_vars.nonce
                });
            }
        " );
    }

    /**
     * লকার রেন্ডারিং (শর্টকোড লজিক)
     */
    public function render_locked_content( $atts, $content = null ) {
        $post_id = get_the_ID();
        
        $html = '<div class="ilybd-locker-wrapper" style="position:relative; border:2px dashed #ff0000; padding:20px; text-align:center;">';
        
        // লকার মেসেজ ও বাটন
        $html .= '<div id="ilybd-locked-' . $post_id . '" class="ilybd-gate-overlay">';
        $html .= '<h3>🔒 কন্টেন্টটি লক করা আছে!</h3>';
        $html .= '<p>সম্পূর্ণ ভিডিও অ্যাডটি দেখুন অথবা ১৫ সেকেন্ড অপেক্ষা করুন ডাউনলোড লিঙ্ক পেতে।</p>';
        $html .= '<button onclick="unlockContent(' . $post_id . ')" style="background:#28a745; color:#fff; padding:10px 20px; border:none; cursor:pointer; border-radius:5px;">Unlock Now (Watch Ad)</button>';
        $html .= '</div>';

        // আসল কন্টেন্ট (শুরুতে হাইড থাকবে)
        $html .= '<div id="ilybd-content-' . $post_id . '" style="display:none;">' . do_shortcode($content) . '</div>';
        
        $html .= '</div>';

        return $html;
    }
}

// ইঞ্জিন অ্যাক্টিভেট করা
ILYBD_Ad_Gate::get_instance();
