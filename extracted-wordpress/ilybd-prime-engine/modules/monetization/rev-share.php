<?php
/**
 * Module: Monetization & Ad Revenue Distribution
 * Description: Tracks visits and distributes 10-20% share to the referrers.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_Monetization_Engine {

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // ভিজিটর ট্র্যাকিং শুরু করা যখন কোনো পেজ লোড হয়
        add_action( 'wp_head', array( $this, 'track_visitor_activity' ) );
        
        // শর্টকোড তৈরি করা যাতে ইউজার তার রেফারেল লিঙ্ক দেখতে পারে
        add_shortcode( 'ilybd_referral_link', array( $this, 'generate_referral_link' ) );
    }

    /**
     * ভিজিটর ট্র্যাকিং লজিক
     * ইউজার যখন কোনো লিঙ্ক শেয়ার করে (যেমন: iloveyoubd.com/?ref=1)
     */
    public function track_visitor_activity() {
        if ( is_admin() ) return;

        // যদি ইউআরএল-এ 'ref' প্যারামিটার থাকে (রেফারেল আইডি)
        if ( isset( $_GET['ref'] ) ) {
            $referrer_id = intval( $_GET['ref'] );
            $post_id = get_the_ID();

            // নিজের লিঙ্কে নিজে ঢুকলে ইনকাম হবে না (স্প্যাম প্রোটেকশন)
            if ( is_user_logged_in() && get_current_user_id() == $referrer_id ) {
                return;
            }

            // কুকি সেট করা যাতে ওই ভিজিটর ২৪ ঘণ্টা যা করবে তার কমিশন ইউজার পায়
            if ( ! isset( $_COOKIE['ilybd_referrer'] ) ) {
                setcookie( 'ilybd_referrer', $referrer_id, time() + ( 86400 ), "/" ); // ২৪ ঘণ্টা
            }
        }

        // যদি কুকি থাকে এবং পেজটি একটি টুল বা পোস্ট হয়, তবে রেভিনিউ ক্যালকুলেট হবে
        if ( is_singular() && isset( $_COOKIE['ilybd_referrer'] ) ) {
            $this->distribute_share_to_user( $_COOKIE['ilybd_referrer'], get_the_ID() );
        }
    }

    /**
     * রেভিনিউ ডিস্ট্রিবিউশন লজিক
     */
    private function distribute_share_to_user( $user_id, $post_id ) {
        // বস্, এখানে আমরা একটি 'বেস রেভিনিউ' ধরছি (যেমন: প্রতি ১০০০ ভিউতে ১ ডলার বা ১০০ টাকা)
        // আপনি এডমিন প্যানেল থেকে এই ভ্যালুটা পরে চেঞ্জ করতে পারবেন।
        $base_cpm = 0.10; // আমরা ধরে নিচ্ছি প্রতিটি ভিউতে ০.১০ টাকা ইনকাম হয় (এডসেন্স থেকে)

        // এই ভ্যালুটা আমরা Wallet মডিউলে পাঠিয়ে দেব
        // সেখানে ইউজারের লেভেল অনুযায়ী ১০%, ১৫% বা ২০% ক্যালকুলেট হয়ে ব্যালেন্সে যোগ হবে
        if ( function_exists( 'ILYBD_Wallet' ) ) {
            do_action( 'ilybd_track_ad_revenue', $user_id, $post_id, $base_cpm );
            
            // সাথে বোনাস হিসেবে ১ পয়েন্ট যোগ করা এনগেজমেন্টের জন্য
            do_action( 'ilybd_add_points', $user_id, 1, 'Visitor Tracked' );
        }
    }

    /**
     * রেফারেল লিঙ্ক জেনারেটর শর্টকোড
     * ইউজার তার ড্যাশবোর্ডে [ilybd_referral_link] ইউজ করলে তার লিঙ্ক দেখবে
     */
    public function generate_referral_link() {
        if ( ! is_user_logged_in() ) return "Please login to see your referral link.";

        $user_id = get_current_user_id();
        $base_url = home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
        $ref_url = add_query_arg( 'ref', $user_id, $base_url );

        return '<div class="ilybd-ref-box">
                    <input type="text" value="' . esc_url( $ref_url ) . '" id="ilybdRefLink" readonly>
                    <button onclick="copyIlybdRef()">Copy Link</button>
                </div>
                <script>
                    function copyIlybdRef() {
                        var copyText = document.getElementById("ilybdRefLink");
                        copyText.select();
                        document.execCommand("copy");
                        alert("Link Copied to Clipboard!");
                    }
                </script>';
    }
}

// ইনিশিয়ালাইজেশন
ILYBD_Monetization_Engine::get_instance();
