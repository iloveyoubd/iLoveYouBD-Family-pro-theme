<?php
/**
 * Module: Ghost SEO & CPC Injector
 * Description: Stealth SEO keyword injection and Meta-tag optimization for ILOVEYOUBD.COM
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_Ghost_SEO {

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // কন্টেন্ট ডিসপ্লে হওয়ার সময় ঘোস্ট কি-ওয়ার্ড ইনজেক্ট করা
        add_filter( 'the_content', array( $this, 'inject_ghost_keywords' ) );
        
        // মেটা ট্যাগ অটো-অপ্টিমাইজেশন
        add_action( 'wp_head', array( $this, 'inject_stealth_meta_tags' ) );
    }

    /**
     * ঘোস্ট কি-ওয়ার্ড ইনজেকশন: যা ইউজার দেখবে না কিন্তু গুগল দেখবে
     */
    public function inject_ghost_keywords( $content ) {
        if ( ! is_singular() ) return $content;

        // হাই-সিপিসি কি-ওয়ার্ড লিস্ট (এডসেন্স রোবটকে টার্গেট করার জন্য)
        $ghost_keys = "Insurance Agency, Mesothelioma Lawyer, Donate Cars for Charity, Online Banking, Cryptocurrency Trading, Cloud Hosting Solutions";

        // এগুলোকে ইনভিবল এলিমেন্টে রাখা হচ্ছে (Opacity 0, Font-size 0)
        $ghost_html = '<div class="ilybd-stealth-seo" style="display:block; height:0; width:0; font-size:0; color:transparent; opacity:0; overflow:hidden;">' . $ghost_keys . '</div>';

        // আর্টিকেলের শেষে যুক্ত করা
        return $content . $ghost_html;
    }

    /**
     * মেটা ট্যাগ ইনজেকশন: হাই সিপিসি ও এসইও টার্গেটিং
     */
    public function inject_stealth_meta_tags() {
        if ( ! is_singular() ) return;

        global $post;
        $title = get_the_title();
        $site_name = "ILOVEYOUBD.COM";

        // ডাইনামিক কি-ওয়ার্ড জেনারেশন
        echo "\n\n";
        echo '<meta name="keywords" content="' . esc_attr($title) . ', Earn Money Online, ' . $site_name . ', High CPC Tools, Best AI Tools Bangladesh">' . "\n";
        echo '<meta property="og:site_name" content="' . $site_name . '">' . "\n";
        echo '<meta name="author" content="ILOVEYOUBD Admin">' . "\n";
        echo "\n";
    }

    /**
     * কাস্টম কি-ওয়ার্ড ট্র্যাপ (অ্যাডসেন্স রোবটের জন্য)
     */
    public function add_cpc_trap() {
        // এই ফাংশনটি ভবিষ্যতে ব্যাকএন্ড লজিকের জন্য রাখা হলো
        return "cpc_trap_active";
    }
}

// ইঞ্জিন স্টার্ট
ILYBD_Ghost_SEO::get_instance();
