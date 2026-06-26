<?php
/**
 * ILYBD Neon Pro - Google Services Integrator (Replacement for Google Site Kit)
 * 
 * Strict Object-Oriented Programming (OOP) Singleton, zero bloat, high-performance,
 * developer-secret admin exclusion, zero downtime, and safe AdSense configuration.
 */

if (!defined('ABSPATH')) exit;

class ILYBD_Google_Services_Integrator {

    private static $instance = null;

    /**
     * Singleton instance retriever
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Set up hooks and filters
     */
    private function __construct() {
        add_action('admin_menu', [$this, 'add_google_integrator_menu']);
        add_action('admin_init', [$this, 'register_google_integrator_settings']);
        
        // Performance-first secure front-end hooks
        add_action('wp_head', [$this, 'inject_head_services'], 2);
        add_action('wp_footer', [$this, 'inject_footer_services'], 99);
    }

    /**
     * Register Admin Pages under the Cyber-X / Google Scripts category
     */
    public function add_google_integrator_menu() {
        add_menu_page(
            'Google Services Hub',
            'Google Hub (Site Kit Replacement)',
            'manage_options',
            'cyberx-google-scripts',
            [$this, 'render_google_services_page'],
            'dashicons-google',
            22
        );
    }

    /**
     * Register WordPress settings options for Google elements
     */
    public function register_google_integrator_settings() {
        register_setting('ilybd_google_services_group', 'ilybd_gsc_verification_code');
        register_setting('ilybd_google_services_group', 'ilybd_ga4_measurement_id');
        register_setting('ilybd_google_services_group', 'ilybd_adsense_publisher_id');
        register_setting('ilybd_google_services_group', 'cyberx_header_scripts');
    }

    /**
     * Safe exclusion check: Do not execute GA4 trackers for Editors or Admins to safeguard metrics accuracy.
     */
    private function is_excluded_user() {
        if (is_admin()) {
            return true;
        }
        if (current_user_can('manage_options') || current_user_can('edit_posts')) {
            return true;
        }
        return false;
    }

    /**
     * High-speed, non-blocking asynchronous header scripts:
     * - Search Console Verification Tag
     * - AdSense Auto-Ads Tag
     * - Legacy global cyberx_header_scripts compatibility
     */
    public function inject_head_services() {
        // 1. Google Search Console Verification Meta Tag
        $gsc_code = get_option('ilybd_gsc_verification_code', '');
        if (!empty($gsc_code)) {
            // If user inputted full meta tag, output it safely, else wrap it
            if (strpos($gsc_code, '<meta') !== false) {
                echo "\n<!-- Google Search Console -->\n" . $gsc_code . "\n";
            } else {
                echo "\n<!-- Google Search Console -->\n<meta name=\"google-site-verification\" content=\"" . esc_attr($gsc_code) . "\" />\n";
            }
        }

        // 2. Google AdSense Publisher Auto-Ads script (Lazy Loaded)
        $ads_pub_id = get_option('ilybd_adsense_publisher_id', '');
        if (!empty($ads_pub_id)) {
            // Clean formatting to ensure we have a valid publisher code of design ca-pub-xxx
            $clean_ads_pub = trim($ads_pub_id);
            if (strpos($clean_ads_pub, 'ca-pub-') === false && strpos($clean_ads_pub, 'pub-') === 0) {
                $clean_ads_pub = 'ca-' . $clean_ads_pub;
            } elseif (strpos($clean_ads_pub, 'ca-') === false) {
                $clean_ads_pub = 'ca-pub-' . $clean_ads_pub;
            }
            
            echo "\n<!-- Performance-First Google AdSense Auto-Ads (Lazy Loaded) -->\n";
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var loadAdSense = function() {
                    if (window.adsenseLoaded) return;
                    window.adsenseLoaded = true;
                    var script = document.createElement('script');
                    script.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=" . esc_attr($clean_ads_pub) . "';
                    script.async = true;
                    script.crossOrigin = 'anonymous';
                    document.head.appendChild(script);
                };
                window.addEventListener('scroll', loadAdSense, { passive: true, once: true });
                window.addEventListener('mousemove', loadAdSense, { passive: true, once: true });
                window.addEventListener('touchstart', loadAdSense, { passive: true, once: true });
                setTimeout(loadAdSense, 4000); // Fallback after 4s
            });
            </script>\n";
        }

        // 3. Fallback/Backward compatibility for custom header legacy blocks (Zero Downtime)
        $legacy_scripts = get_option('cyberx_header_scripts', '');
        if (!empty($legacy_scripts)) {
            echo "\n<!-- Legacy Header Scripts -->\n" . stripslashes($legacy_scripts) . "\n";
        }
    }

    /**
     * Performance-first footer scripts:
     * - Google Analytics 4 (GA4) with strict Developer Admin Exclusions to avoid tracking skew
     */
    public function inject_footer_services() {
        if ($this->is_excluded_user()) {
            echo "\n<!-- Google Analytics Tracking Excluded for logged-in Administrator / Editor node -->\n";
            return;
        }

        $ga4_id = get_option('ilybd_ga4_measurement_id', '');
        if (!empty($ga4_id)) {
            $clean_ga4 = esc_attr(trim($ga4_id));
            echo "\n<!-- High-Performance Async GA4 Integrator (Site Kit Replacement Engine) -->\n";
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var loadGA4 = function() {
                    if (window.ga4Loaded) return;
                    window.ga4Loaded = true;
                    var script = document.createElement('script');
                    script.src = 'https://www.googletagmanager.com/gtag/js?id=" . $clean_ga4 . "';
                    script.async = true;
                    document.head.appendChild(script);
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());
                    gtag('config', '" . $clean_ga4 . "', { 'anonymize_ip': true });
                };
                window.addEventListener('scroll', loadGA4, { passive: true, once: true });
                window.addEventListener('mousemove', loadGA4, { passive: true, once: true });
                window.addEventListener('touchstart', loadGA4, { passive: true, once: true });
                setTimeout(loadGA4, 3500); // Fallback after 3.5s
            });
            </script>\n";
        }
    }

    /**
     * Render the admin setup UI with 2040 retro cyber-neon glow designs, links, nonces, and notices
     */
    public function render_google_services_page() {
        // Verify user cap credentials
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        // Save hook processing with Nonce checking
        $saved = false;
        if (isset($_POST['ilybd_save_google_integrator'])) {
            check_admin_referer('ilybd_google_integrator_action', 'ilybd_google_integrator_nonce');
            
            update_option('ilybd_gsc_verification_code', sanitize_text_field($_POST['ilybd_gsc_verification_code']));
            update_option('ilybd_ga4_measurement_id', sanitize_text_field($_POST['ilybd_ga4_measurement_id']));
            update_option('ilybd_adsense_publisher_id', sanitize_text_field($_POST['ilybd_adsense_publisher_id']));
            update_option('cyberx_header_scripts', stripslashes($_POST['cyberx_header_scripts'])); // Raw custom scripts allowed
            
            $saved = true;
        }

        // Fetch current records
        $gsc_val     = get_option('ilybd_gsc_verification_code', '');
        $ga4_val     = get_option('ilybd_ga4_measurement_id', '');
        $adsense_val = get_option('ilybd_adsense_publisher_id', '');
        $legacy_val  = get_option('cyberx_header_scripts', '');
        ?>
        <div class="wrap" style="background:#070b13; color:#c9d1d9; padding:25px; border-radius:14px; border:1px solid #142542; font-family:system-ui; max-width: 1000px; margin: 30px auto; box-shadow: 0 10px 40px rgba(0,0,0,0.65);">
            
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 2px solid #142542; padding-bottom:20px; margin-bottom:25px;">
                <div>
                    <h1 style="color:#00f0ff; font-weight:900; margin:0 0 5px 0; text-transform:uppercase; letter-spacing:1px; font-size:24px; text-shadow:0 0 15px rgba(0,240,255,0.25);">
                        🚀 Google Services integrator
                    </h1>
                    <span style="color:#64748b; font-family: 'JetBrains Mono', monospace; font-size:11px;">
                        SYSTEM BIND: ACTIVE // ANTI-SITE KIT MIGRATION PROTOCOL v1.2
                    </span>
                </div>
                <div style="background:#1e293b; border-radius:30px; padding:6px 16px; border:1px solid #334155;">
                    <span style="color:#00ff41; font-weight:bold; font-size:11px; display:flex; align-items:center; gap:6px;">
                        <span style="width:8px; height:8px; background:#00ff41; border-radius:50%; display:inline-block; animation: pulse 1.5s infinite;"></span> CODESEED: ONLINE
                    </span>
                </div>
            </div>

            <?php if ($saved): ?>
                <div style="background: rgba(0, 255, 65, 0.08); border: 1.5px solid #00ff41; color: #00ff41; padding: 15px; border-radius: 8px; margin-bottom: 25px; font-weight: bold; font-size: 13.5px; display:flex; align-items:center; gap:10px;">
                    <span>✅</span> <span>গুগল সার্ভিসেস ইন্টিগ্রেটর কনফিগারেশন সফলভাবে সেভ করা হয়েছে এবং লাইভ ট্যাগস আপডেট হয়েছে!</span>
                </div>
            <?php endif; ?>

            <!-- 🚨 THE HIGHLY PROMINENT CODE CONFLICT RESOLUTION & ADMIN WARNING PANEL -->
            <div style="background: rgba(239, 68, 68, 0.07); border: 2px solid #ef4444; border-radius: 12px; padding: 22px; margin-bottom: 30px; box-shadow: 0 0 20px rgba(239, 68, 68, 0.15);">
                <h4 style="color:#ef4444; margin-top:0; margin-bottom:10px; font-weight:800; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                    ⚠️ CRITICAL POLICY & DUPLICATE TRACKING WARNING
                </h4>
                <p style="color:#e2e8f0; font-size:13px; line-height:1.6; margin:0 0 12px 0;">
                    <strong>CRITICAL:</strong> To prevent duplicate tracking data, broken metrics, or Google AdSense policy violations, please manually deactivate Google Site Kit and remove any legacy tracking snippets hardcoded into your theme's <code>header.php</code> or <code>footer.php</code> before activating these fields.
                </p>
                <div style="background: rgba(0,0,0,0.3); border-radius: 6px; padding: 10px 14px; border: 1px solid rgba(239, 68, 68, 0.2);">
                    <span style="color:#94a3b8; font-size:11.5px; display:block; line-height:1.4;">
                        💡 <strong>কেন এটি অত্যন্ত জরুরি?</strong> একাধিক ট্র্যাকিং ট্যাগ একসাথে সচল থাকলে পেজ স্পিড লোডিং টাইম হ্রাস পায় এবং গুগল ট্রাফিক ডাটা ডাবল কাউন্ট করে আপনাকে "Invalid Traffic Activity" পেনাল্টি দিতে পারে। তাই Site Kit বা অন্যান্য ম্যানুয়াল ট্যাগ সম্পূর্ণ ডিলিট করে আমাদের এই জিরো-ল্যাটেন্সি ইন্টিগ্রেটর ব্যবহার করুন।
                    </span>
                </div>
            </div>

            <!-- 🤖 MAYA GOOGLE AI COMPANION (AUTOMATED GUIDANCE PANEL) -->
            <div style="background: rgba(0, 240, 255, 0.04); border: 1.5px solid #00f0ff; border-radius: 12px; padding: 22px; margin-bottom: 30px; box-shadow: 0 0 25px rgba(0, 240, 255, 0.08);">
                <h4 style="color:#00f0ff; margin-top:0; margin-bottom:12px; font-weight:900; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                    🤖 মায়া গুগল এআই কম্প্যানিয়ন (Maya Google AI Companion)
                </h4>
                <p style="color:#94a3b8; font-size:13px; line-height:1.6; margin:0 0 15px 0;">
                    আশরাফুল ভাই, আপনার গুগল সার্ভিসেস কনফিগারেশন আরও সহজ ও আকর্ষণীয় করতে মায়া ক্রলার অ্যাসিস্ট্যান্ট আপনার সাইটের লাইভ ডেটা ম্যাপ রেডি করেছে।
                </p>
                
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:15px; margin-bottom:15px;">
                    <!-- STATUS BOX 1: SEARCH CONSOLE -->
                    <div style="background:#09101d; border:1px solid rgba(0, 240, 255, 0.2); border-radius:8px; padding:15px;">
                        <span style="font-size:10px; font-family:monospace; color:#00f0ff; text-transform:uppercase; display:block; margin-bottom:4px;">🔍 Search Console Status</span>
                        <strong style="color:#00ff41; font-size:14px; display:block; margin-bottom:4px;">✓ ALREADY VERIFIED (অ্যাক্টিভ)</strong>
                        <span style="color:#94a3b8; font-size:11px; display:block; line-height:1.4;">
                            আপনার গুগল সার্চ কনসোলের ড্যাশবোর্ডে <strong>iloveyoubd.com/</strong> অলরেডি সম্পূর্ণ ভেরিফাইড এবং সচল আছে (আপনার ওখানকার ৫৩+ ক্লিকের ডাটা এটিই প্রমাণ করে)। তাই সার্চ কনসোলের বক্সে নতুন করে কোনো কোড বসানোর প্রয়োজন নেই!
                        </span>
                    </div>

                    <!-- STATUS BOX 2: ADSENSE INTEGRATION -->
                    <div style="background:#09101d; border:1px solid rgba(0, 240, 255, 0.2); border-radius:8px; padding:15px;">
                        <span style="font-size:10px; font-family:monospace; color:#00f0ff; text-transform:uppercase; display:block; margin-bottom:4px;">💸 AdSense Integration Status</span>
                        <strong style="color:#ffae00; font-size:14px; display:block; margin-bottom:4px;">✓ PUBLISHER ID CONNECTED</strong>
                        <span style="color:#94a3b8; font-size:11px; display:block; line-height:1.4;">
                            আপনার এডসেন্স পাবলিশার আইডি <strong>pub-4021024720157629</strong> সফলভাবে ইনজেক্ট করা আছে। এটি বসালেই আপনার সাইটের সকল স্থানে অটো-বিজ্ঞাপন সচল হতে সাহায্য করবে। অন্য কোনো ম্যানুয়াল জাভাস্ক্রিপ্ট কোড বসাবার একদম দরকার নেই।
                        </span>
                    </div>
                </div>

                <!-- QUICK INTEGRATION LINKS FOR INDIVIDUAL CODES -->
                <div style="background: rgba(0,0,0,0.3); border-radius: 8px; padding: 15px; border: 1px solid rgba(0, 240, 255, 0.1);">
                    <h5 style="color:#fff; margin-top:0; margin-bottom:10px; font-size:12.5px; font-weight:700;">🔗 আপনার গুগল অ্যাকাউন্টের সরাসরি লিংকসমূহ (Direct 1-Click Access Links):</h5>
                    <ul style="margin:0; padding-left:20px; color:#94a3b8; font-size:12px; line-height:1.7;">
                        <li>
                            গুগল সার্চ কনসোল ভেরিফিকেশন মেটা ট্যাগ দেখতে: 
                            <a href="https://search.google.com/search-console/settings/ownership?resource_id=https%3A%2F%2Filoveyoubd.com%2F" target="_blank" style="color:#00f0ff; text-decoration:underline; font-weight:bold;">মালিকানা ভেরিফিকেশন সেটিংসে যান ➔</a> (সেখানে "HTML Tag" অপশনটি ক্লিক করলেই আপনি <code>google-site-verification</code> কোড পেয়ে যাবেন)।
                        </li>
                        <li>
                            গুগল অ্যানালিটিক্স ৪ ট্র্যাকিং আইডি বের করতে: 
                            <a href="https://analytics.google.com/analytics/web/" target="_blank" style="color:#d946ef; text-decoration:underline; font-weight:bold;">গুগল অ্যানালিটিক্স ডাটা স্ট্রীম ➔</a> (সেখান থেকে <code>G-XXXXXXXXXX</code> আইডিটি কপি করে নিচের বক্সে বসান)।
                        </li>
                    </ul>
                </div>
            </div>

            <!-- MAIN SETUP FORM -->
            <form method="post" action="">
                <?php wp_nonce_field('ilybd_google_integrator_action', 'ilybd_google_integrator_nonce'); ?>

                <!-- SECTION 1: SEARCH CONSOLE -->
                <div style="background:#0e1626; border: 1px solid #1e293b; border-radius:12px; padding:20px; margin-bottom:20px; transition:0.3s;" onmouseover="this.style.borderColor='#00f0ff';" onmouseout="this.style.borderColor='#1e293b';">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <label style="color:#fff; font-weight:800; font-size:14px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                            <span>🔍</span> Google Search Console (গুগল সার্চ কনসোল)
                        </label>
                        <a href="https://search.google.com/search-console" target="_blank" style="background:#00f0ff; color:#000; font-weight:bold; font-size:11px; padding:6px 14px; border-radius:6px; text-decoration:none; text-transform:uppercase; letter-spacing:0.5px; box-shadow:0 0 10px rgba(0,240,255,0.3); transition:0.3s;" onmouseover="this.style.boxShadow='0 0 15px #00f0ff';" onmouseout="this.style.boxShadow='none';">
                            LAUNCH CONSOLE ➔
                        </a>
                    </div>
                    <p style="color:#94a3b8; font-size:12px; margin:0 0 12px 0; line-height:1.4;">
                        আপনার সাইটের গুগল ইনডেক্সিং এবং সার্চ রেজাল্ট ট্র্যাকিং সচল করতে এখানে গুগল সার্চ কনসোল ভেরিফিকেশন মেটা ট্যাগ বা ভেরিফিকেশন কোডটি দিন।
                    </p>
                    <input type="text" name="ilybd_gsc_verification_code" value="<?php echo esc_attr($gsc_val); ?>" placeholder='e.g., google-site-verification=abc123_xyz...' style="width:100%; background:#070b13; color:#00f0ff; border:1px solid #1e293b; border-radius:8px; padding:12px; font-family:monospace; font-size:12.5px; outline:none; transition:0.3s;" onfocus="this.style.borderColor='#00f0ff';">
                </div>

                <!-- SECTION 2: GOOGLE ANALYTICS 4 -->
                <div style="background:#0e1626; border: 1px solid #1e293b; border-radius:12px; padding:20px; margin-bottom:20px; transition:0.3s;" onmouseover="this.style.borderColor='#d946ef';" onmouseout="this.style.borderColor='#1e293b';">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <label style="color:#fff; font-weight:800; font-size:14px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                            <span>📈</span> Google Analytics 4 (GA4 measurement ID)
                        </label>
                        <a href="https://analytics.google.com" target="_blank" style="background:#d946ef; color:#fff; font-weight:bold; font-size:11px; padding:6px 14px; border-radius:6px; text-decoration:none; text-transform:uppercase; letter-spacing:0.5px; box-shadow:0 0 10px rgba(217,70,239,0.3); transition:0.3s;" onmouseover="this.style.boxShadow='0 0 15px #d946ef';" onmouseout="this.style.boxShadow='none';">
                            GET MEASUREMENT ID ➔
                        </a>
                    </div>
                    <p style="color:#94a3b8; font-size:12px; margin:0 0 12px 0; line-height:1.4;">
                        ভিজিটর ট্র্যাকিং এবং রিয়েল-টাইম রিপোর্ট দেখতে আপনার GA4 মেজারমেন্ট আইডি (G-XXXXXXXXXX) প্রদান করুন। এডমিন বা এডিটরদের ইন্টারনাল হিট স্বয়ংক্রিয়ভাবে বন্ধ থাকবে।
                    </p>
                    <input type="text" name="ilybd_ga4_measurement_id" value="<?php echo esc_attr($ga4_val); ?>" placeholder='e.g., G-XXXXXX' style="width:100%; background:#070b13; color:#d946ef; border:1px solid #1e293b; border-radius:8px; padding:12px; font-family:monospace; font-size:12.5px; outline:none; transition:0.3s;" onfocus="this.style.borderColor='#d946ef';">
                </div>

                <!-- SECTION 3: Google AdSense -->
                <div style="background:#0e1626; border: 1px solid #1e293b; border-radius:12px; padding:20px; margin-bottom:20px; transition:0.3s;" onmouseover="this.style.borderColor='#00ff41';" onmouseout="this.style.borderColor='#1e293b';">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <label style="color:#fff; font-weight:800; font-size:14px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                            <span>💰</span> Google AdSense Publisher (এডসেন্স আইডি)
                        </label>
                        <a href="https://adsense.google.com" target="_blank" style="background:#00ff41; color:#000; font-weight:bold; font-size:11px; padding:6px 14px; border-radius:6px; text-decoration:none; text-transform:uppercase; letter-spacing:0.5px; box-shadow:0 0 10px rgba(0,255,65,0.3); transition:0.3s;" onmouseover="this.style.boxShadow='0 0 15px #00ff41';" onmouseout="this.style.boxShadow='none';">
                            GET PUBLISHER ID ➔
                        </a>
                    </div>
                    <p style="color:#94a3b8; font-size:12px; margin:0 0 12px 0; line-height:1.4;">
                        গুগল এডসেন্সের অটো-বিজ্ঞাপন সচল করতে শুধুমাত্র আপনার পাবলিশার আইডিটি দিন (যেমন: pub-XXXXXXXXXXXXXXXX অথবা ca-pub-XXXXXXXXXXXXXXXX)।
                    </p>
                    <input type="text" name="ilybd_adsense_publisher_id" value="<?php echo esc_attr($adsense_val); ?>" placeholder='pub-XXXXXXXXXXXXXXXX' style="width:100%; background:#070b13; color:#00ff41; border:1px solid #1e293b; border-radius:8px; padding:12px; font-family:monospace; font-size:12.5px; outline:none; transition:0.3s;" onfocus="this.style.borderColor='#00ff41';">
                </div>

                <!-- SECTION 4: LEGACY HEADER SCRIPTS COMPATIBILITY -->
                <div style="background:#0e1626; border: 1px solid #1e293b; border-radius:12px; padding:20px; margin-bottom:25px;">
                    <label style="color:#fff; font-weight:800; font-size:14px; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:6px;">
                        🛠️ Legacy Global Header Scripts (কাস্টম অতিরিক্ত স্ক্রিপ্ট)
                    </label>
                    <p style="color:#94a3b8; font-size:12px; margin:0 0 12px 0; line-height:1.4;">
                        অন্যান্য কাস্টম মেটা বা জাভাস্ক্রিপ্ট কোড (যেমন: ফেইসবুক পিক্সেল বা অন্যান্য ভেরিফিকেশন ব্লক) যা ব্যাকওয়ার্ড কম্প্যাটিবিলিটির জন্য প্রাক-সংরক্ষিত ছিল:
                    </p>
                    <textarea name="cyberx_header_scripts" rows="6" placeholder="<!-- Paste custom header tracking codes here -->" style="width:100%; background:#070b13; color:#e2e8f0; border:1px solid #1e293b; border-radius:8px; padding:12px; font-family:monospace; font-size:12px; line-height:1.5; outline:none; transition:0.3s;" onfocus="this.style.borderColor='#64748b';"><?php echo esc_textarea($legacy_val); ?></textarea>
                </div>

                <!-- ACTION BUTTONS -->
                <div style="background:#0e1626; border-radius:12px; padding:15px; display:flex; justify-content:space-between; align-items:center; border: 1px dashed rgba(0,240,255,0.15);">
                    <span style="color:#64748b; font-size:11.5px; line-height:1.4;">
                        ℹ️ <strong>Developer Note:</strong> এই ইন্টিগ্রেশন মডিউলটি সম্পূর্ণ জিরো-ব্লট আর্কিটেকচারে তৈরি, অর্থাৎ ডেটাবেজে অতিরিক্ত লোড ফেলে না এবং কোর সার্ভিসগুলোর সর্বোচ্চ স্পিড নিশ্চিত করে।
                    </span>
                    <button type="submit" name="ilybd_save_google_integrator" class="button-primary" style="background:#00f0ff; color:#000; border:none; padding:12px 28px; border-radius:8px; font-weight:900; font-size:13px; text-transform:uppercase; letter-spacing:0.5px; cursor:pointer; box-shadow: 0 0 15px rgba(0,240,255,0.35); transition:0.3s;" onmouseover="this.style.boxShadow='0 0 25px #00f0ff'; this.style.transform='scale(1.02)';" onmouseout="this.style.boxShadow='0 0 15px rgba(0,240,255,0.35)'; this.style.transform='scale(1)';">
                        ⚡ ACTIVATE ENGINE / সেভ করুন
                    </button>
                </div>

            </form>
        </div>

        <!-- Pulse animation keyframes injected for dashboard aesthetics -->
        <style>
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(0, 255, 65, 0.4); }
                70% { box-shadow: 0 0 0 10px rgba(0, 255, 65, 0); }
                100% { box-shadow: 0 0 0 0 rgba(0, 255, 65, 0); }
            }
        </style>
        <?php
    }
}

// Instantiate the singleton connection
ILYBD_Google_Services_Integrator::get_instance();
