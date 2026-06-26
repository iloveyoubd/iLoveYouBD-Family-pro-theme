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

        // Handle user registration for referral bonus
        add_action( 'user_register', array( $this, 'handle_referral_registration' ), 10, 1 );

        // Add referral field to default WordPress registration form
        add_action( 'register_form', array( $this, 'add_referral_field' ) );
        add_filter( 'registration_errors', array( $this, 'validate_referral_field' ), 10, 3 );
    }

    /**
     * Add Referral ID input field to the standard registration form
     */
    public function add_referral_field() {
        $ref_val = isset( $_GET['ref'] ) ? intval( $_GET['ref'] ) : '';
        if ( empty( $ref_val ) && isset( $_COOKIE['ilybd_referrer'] ) ) {
            $ref_val = intval( $_COOKIE['ilybd_referrer'] );
        }
        ?>
        <p>
            <label for="ilybd_referrer_id"><?php _e( 'Referral ID / রেফারেল আইডি (ঐচ্ছিক)', 'ilybd-prime' ); ?><br />
            <input type="number" name="ilybd_referrer_id" id="ilybd_referrer_id" class="input" value="<?php echo esc_attr( $ref_val ); ?>" style="background:#161b22; color:#fff; border:1px solid #30363d; border-radius:6px; padding:10px; width:100%; box-sizing:border-box;" />
            </label>
        </p>
        <?php
    }

    /**
     * Validate the provided Referral ID
     */
    public function validate_referral_field( $errors, $sanitized_user_login, $user_email ) {
        if ( ! empty( $_POST['ilybd_referrer_id'] ) ) {
            $referrer_id = intval( $_POST['ilybd_referrer_id'] );
            $referrer = get_userdata( $referrer_id );
            if ( ! $referrer ) {
                $errors->add( 'invalid_referrer_id', __( '<strong>ERROR</strong>: প্রবেশ করানো রেফারেল আইডিটি সঠিক নয় বা ইউজার পাওয়া যায়নি।', 'ilybd-prime' ) );
            }
        }
        return $errors;
    }

    /**
     * Handle referral bonus upon successful user registration
     */
    public function handle_referral_registration( $user_id ) {
        $referrer_id = 0;
        
        if ( isset( $_COOKIE['ilybd_referrer'] ) ) {
            $referrer_id = intval( $_COOKIE['ilybd_referrer'] );
        } elseif ( ! empty( $_POST['ilybd_referrer_id'] ) ) {
            $referrer_id = intval( $_POST['ilybd_referrer_id'] );
        }

        if ( $referrer_id > 0 ) {
            // Validate referrer still exists
            $referrer = get_userdata($referrer_id);
            if( $referrer ) {
                
                // Get Admin Settings for Rewards
                $ref_points_referrer = intval(get_option('ilybd_ref_points_referrer', 50));
                $ref_cash_referrer = floatval(get_option('ilybd_ref_cash_referrer', 0.50));
                
                $ref_points_referee = intval(get_option('ilybd_ref_points_referee', 100));
                $ref_cash_referee = floatval(get_option('ilybd_ref_cash_referee', 1.00));
                
                // Reward Referrer
                if ( function_exists('ilybd_add_user_balance_or_points') ) {
                    ilybd_add_user_balance_or_points(
                        $referrer_id, 
                        $ref_cash_referrer, 
                        $ref_points_referrer, 
                        sprintf("রেফারেল বোনাস (নতুন ইউজার ID %d কে যুক্ত করার জন্য)", $user_id),
                        (string)$user_id,
                        'referral'
                    );
                } else {
                    $curr_points_referrer = (int)get_user_meta($referrer_id, 'ilybd_total_points', true);
                    $curr_balance_referrer = (float)get_user_meta($referrer_id, 'user_balance', true);
                    update_user_meta( $referrer_id, 'ilybd_total_points', $curr_points_referrer + $ref_points_referrer );
                    update_user_meta( $referrer_id, 'user_balance', $curr_balance_referrer + $ref_cash_referrer );
                }
                
                // Reward New User (Referee)
                if ( function_exists('ilybd_add_user_balance_or_points') ) {
                    ilybd_add_user_balance_or_points(
                        $user_id, 
                        $ref_cash_referee, 
                        $ref_points_referee, 
                        sprintf("রেফারেল জয়েনিং বোনাস (লিংক দাতা ID %d এর মাধ্যমে)", $referrer_id),
                        (string)$referrer_id,
                        'referral'
                    );
                } else {
                    $curr_points_referee = (int)get_user_meta($user_id, 'ilybd_total_points', true);
                    $curr_balance_referee = (float)get_user_meta($user_id, 'user_balance', true);
                    update_user_meta( $user_id, 'ilybd_total_points', $curr_points_referee + $ref_points_referee );
                    update_user_meta( $user_id, 'user_balance', $curr_balance_referee + $ref_cash_referee );
                }

                // Store relationship for record
                update_user_meta( $user_id, 'ilybd_referred_by', $referrer_id );
                
                // Track total referrals for the referrer
                $total_refs = (int)get_user_meta($referrer_id, 'ilybd_total_referrals_count', true);
                update_user_meta($referrer_id, 'ilybd_total_referrals_count', $total_refs + 1);
            }
        }
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
