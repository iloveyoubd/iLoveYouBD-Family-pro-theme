<?php
ob_start();

/**
 * Plugin Name: ILYBD Prime Engine
 * Description: The Core Engine for iloveyoubd.com. Connects 4K tools, AI systems, and Revenue Share.
 * Version: 1.6.0
 * Author: ILYBD Master
 * Text Domain: ilybd-prime
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * সেকশন ১: গ্লোবাল কনস্ট্যান্টস
 */
define( 'ILYBD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ILYBD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ILYBD_PLUGIN_FILE', __FILE__ ); 

/**
 * সেকশন ২: মাস্টার লোডার (কোর ও মডিউল)
 */
function ilybd_prime_init() {
    
    // ১. কোর ইনক্লুডস লোড
    $includes = [
        'includes/db-setup.php',
        'includes/ajax-actions.php',
        'includes/helpers.php'
    ];

    foreach ( $includes as $inc ) {
        if ( file_exists( ILYBD_PLUGIN_DIR . $inc ) ) {
            require_once ILYBD_PLUGIN_DIR . $inc;
        }
    }

    // ২. মডিউল লোড (সরাসরি আউটপুট দেওয়া ফাইলগুলো এখান থেকে বাদ দেওয়া হয়েছে নিরাপদ থাকার জন্য)
    $modules = [
        'api-balancer/balancer.php',
        'wallet-system/wallet-logic.php',
        'monetization/rev-share.php',
        'ai-assistant/ai-logic.php',
        'seo-factory/ghost-seo.php',
        'seo-factory/Auto-content.php',
        'seo-factory/seo-intent-analyzer.php',
        'user-stats/tracker.php',
        'ad-gate/locker.php',
        'daily-rewards/bonus.php',
        'layout-engine/cpt-logic.php',
        'layout-engine/infinite-scroll.php',
        'site-structure/interlinking.php',
        'security/shield.php',
        'speed-cache/speed-cache.php'
    ];

    foreach ( $modules as $module ) {
        $file_path = ILYBD_PLUGIN_DIR . 'modules/' . $module;
        if ( file_exists( $file_path ) ) {
            require_once $file_path;
        }
    }

    // ৩. অ্যাডমিন ফাইলস এবং স্টাইল লোড
    if ( is_admin() ) {
        if ( file_exists( ILYBD_PLUGIN_DIR . 'admin/master-control.php' ) ) {
            require_once ILYBD_PLUGIN_DIR . 'admin/master-control.php';
        }
        if ( file_exists( ILYBD_PLUGIN_DIR . 'admin/payout-handler.php' ) ) {
            require_once ILYBD_PLUGIN_DIR . 'admin/payout-handler.php';
        }
        
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_style('ibd-admin-style', ILYBD_PLUGIN_URL . 'assets/css/admin-style.css');
            wp_enqueue_style('ilybd-admin-custom', ILYBD_PLUGIN_URL . 'admin/admin-style.css');
        });
    }
}
add_action( 'plugins_loaded', 'ilybd_prime_init' );

/**
 * সেকশন ৩: এক্সটার্নাল লাইব্রেরি ও কোর ক্লাস (The theme natively handles Gemini, OpenAI, Publisher)
 * Removed duplicate class inclusion to prevent duplication with ilybd-neon-v1-pro theme
 */
// Core engine is inside theme, loading only plugin-specific admin control panels.
require_once ILYBD_PLUGIN_DIR . 'inc/class-ibd-key-rotator.php';
require_once ILYBD_PLUGIN_DIR . 'admin/settings-panel.php';
require_once ILYBD_PLUGIN_DIR . 'admin/private-monitor.php';
require_once ILYBD_PLUGIN_DIR . 'admin/super-assistant-gui.php';
require_once ILYBD_PLUGIN_DIR . 'admin/live-sync.php';

/**
 * সেকশন ৪: এসেট ম্যানেজমেন্ট (CSS/JS)
 */
function ilybd_enqueue_engine_assets() {
    wp_enqueue_style( 'ilybd-neon-css', ILYBD_PLUGIN_URL . 'assets/css/neon-effects.css' );
    wp_enqueue_style( 'ibd-rich-style', ILYBD_PLUGIN_URL . 'assets/css/rich-content.css' );
    
    wp_enqueue_script( 'ilybd-core-js', ILYBD_PLUGIN_URL . 'assets/js/core-logic.js', array('jquery'), '1.0', true );
    
    wp_localize_script( 'ilybd-core-js', 'ilybd_vars', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'ilybd_secure_nonce' )
    ));
}
add_action( 'wp_enqueue_scripts', 'ilybd_enqueue_engine_assets' );

/**
 * সেকশন ৫: শর্টকোড ইঞ্জিন (নিরাপদ আউটপুট)
 */

/**
 * সেকশন ৬: অ্যাডমিন মেনু ও ড্যাশবোর্ড
 */
add_action('admin_menu', function() {
    // মেনু পেজ
    add_menu_page('IBD Engine', 'IBD Engine', 'manage_options', 'ibd-api-settings', 'ibd_master_settings_page', 'dashicons-rest-api');
    
    // সাব-মেনুসমূহ
    add_submenu_page('ibd-api-settings', 'Private Monitor', 'Private Monitor', 'manage_options', 'ibd-monitor', 'ibd_private_monitor_page');
    
    add_submenu_page(
        'ibd-api-settings',
        'Super Assistant',
        'Super Assistant',
        'manage_options',
        'ibd-super-assistant',
        'ibd_super_assistant_dashboard'
    );

    add_submenu_page(
        'ibd-api-settings',
        'Live Sync & Update',
        'Live Sync & Update',
        'manage_options',
        'ilybd-live-sync',
        'ilybd_live_sync_page'
    );
});

/**
 * সেকশন ৭: ক্রন জব ও অটো-পাইলট (Background Tasks)
 */

// ১. সুপার অ্যাসিস্ট্যান্ট ডেইলি ক্রন
if ( ! wp_next_scheduled( 'ilybd_super_admin_daily_cron' ) ) {
    wp_schedule_event( time(), 'daily', 'ilybd_super_admin_daily_cron' );
}
add_action( 'ilybd_super_admin_daily_cron', array( 'ILYBD_Super_Assistant', 'run_daily_maintenance' ) );

// ২. হার্টবিট অটো-পাইলট
if ( ! wp_next_scheduled( 'ilybd_auto_pilot_event' ) ) {
    wp_schedule_event( time(), 'daily', 'ilybd_auto_pilot_event' );
}
add_action( 'ilybd_auto_pilot_event', ['ILYBD_Heartbeat', 'run_auto_pilot'] );

/**
 * সেকশন ৮: Ajax ও টার্মিনাল লজিক
 */
add_action('wp_ajax_ibd_process_terminal_cmd', function() {
    if (class_exists('ILYBD_Heartbeat')) {
        $cmd = sanitize_text_field($_POST['command']);
        $response = ILYBD_Heartbeat::process_command($cmd);
        wp_send_json_success($response);
    }
});

add_action('admin_footer', function() {
    $screen = get_current_screen();
    if(isset($screen->id) && strpos($screen->id, 'ibd-super-assistant') !== false) {
        if (function_exists('ibd_shadow_terminal_html')) {
            ibd_shadow_terminal_html();
        }
    }
});

/**
 * সেকশন ৯: অ্যাক্টিভেশন হুক
 */
register_activation_hook( __FILE__, function() {
    if ( file_exists( ILYBD_PLUGIN_DIR . 'includes/db-setup.php' ) ) {
        require_once ILYBD_PLUGIN_DIR . 'includes/db-setup.php';
        if ( function_exists( 'ilybd_initialize_db_tables' ) ) {
            ilybd_initialize_db_tables();
        }
    }
    flush_rewrite_rules();
});

/**
 * সেকশন ১০: UI/UX & Dynamic 2040 Styles Front-End Injector (গ্লো ও থিম কালার ইন্টিগ্রেশন)
 */
add_action('wp_head', 'ilybd_inject_dynamic_styles', 99);
function ilybd_inject_dynamic_styles() {
    $respect_device = get_option('ilybd_respect_device_theme', 'no');
    $enable_loop = get_option('ilybd_enable_rgb_loop', 'no');
    $safe_mode = get_option('ilybd_adsense_safe_mode', 'no');
    
    $color_post = get_option('ilybd_color_post_card', '#00f0ff');
    $color_comment = get_option('ilybd_color_comment_box', '#ff003c');
    $color_profile = get_option('ilybd_color_user_profile', '#bd00ff');
    $color_chatbot = get_option('ilybd_color_chatbot', '#00f0ff');
    $color_qa = get_option('ilybd_color_qa_forum', '#39ff14');
    $color_story = get_option('ilybd_color_story_shelf', '#bd00ff');
    $color_wallet = get_option('ilybd_color_wallet', '#39ff14');
    $color_search = get_option('ilybd_color_search_index', '#eab308');

    echo "\n" . '<!-- ILYBD Dynamic 2040 Styles Customizer Engine -->' . "\n";
    echo '<style id="ilybd-dynamic-customizer-variables">';
    
    if ($safe_mode === 'yes') {
        // Safe mode reduces glow dramatically, stops loops, very raw and solid for AdSense inspectors
        echo '
        :root {
            --neon: #00ff41 !important;
            --custom-post-glow: rgba(0, 0, 0, 0.2) !important;
            --custom-comment-glow: rgba(0, 0, 0, 0.2) !important;
            --custom-profile-glow: rgba(0, 0, 0, 0.2) !important;
            --custom-chatbot-glow: rgba(0, 0, 0, 0.2) !important;
            --custom-qa-glow: rgba(0, 0, 0, 0.2) !important;
            --custom-story-glow: rgba(0, 0, 0, 0.2) !important;
            --custom-wallet-glow: rgba(0, 0, 0, 0.2) !important;
            --custom-search-glow: rgba(0, 0, 0, 0.2) !important;
            --box-shadow-multiplier: 0 !important;
        }
        /* Revoke heavy text shadows and intense box glows for AdSense compliance */
        *, *::before, *::after {
            box-shadow: none !important;
            text-shadow: none !important;
            animation-duration: 0s !important;
            transition-duration: 0.15s !important;
        }
        .logo-text {
            background: none !important;
            -webkit-text-fill-color: #00ff41 !important;
            color: #00ff41 !important;
            text-shadow: none !important;
            filter: none !important;
        }
        .user-hi b {
            background: transparent !important;
            color: #00ff41 !important;
            text-shadow: none !important;
            filter: none !important;
        }
        .rgb-line, .rgb-bottom {
            background: #30363d !important;
            animation: none !important;
            opacity: 0.5 !important;
        }
        ';
    } else {
        // Normal Mode / High-End Cyber Mode
        echo '
        :root {
            --custom-post-glow: ' . esc_attr($color_post) . ';
            --custom-comment-glow: ' . esc_attr($color_comment) . ';
            --custom-profile-glow: ' . esc_attr($color_profile) . ';
            --custom-chatbot-glow: ' . esc_attr($color_chatbot) . ';
            --custom-qa-glow: ' . esc_attr($color_qa) . ';
            --custom-story-glow: ' . esc_attr($color_story) . ';
            --custom-wallet-glow: ' . esc_attr($color_wallet) . ';
            --custom-search-glow: ' . esc_attr($color_search) . ';
        }
        ';

        if ($enable_loop === 'yes') {
            // Animating CSS variables rotation loop every 16s
            echo '
            @keyframes ilybdRgbGlowLoop {
                0% {
                    --custom-post-glow: ' . esc_attr($color_post) . ';
                    --custom-comment-glow: ' . esc_attr($color_comment) . ';
                    --custom-profile-glow: ' . esc_attr($color_profile) . ';
                    --custom-chatbot-glow: ' . esc_attr($color_chatbot) . ';
                }
                25% {
                    --custom-post-glow: ' . esc_attr($color_comment) . ';
                    --custom-comment-glow: ' . esc_attr($color_profile) . ';
                    --custom-profile-glow: ' . esc_attr($color_chatbot) . ';
                    --custom-chatbot-glow: ' . esc_attr($color_qa) . ';
                }
                50% {
                    --custom-post-glow: ' . esc_attr($color_profile) . ';
                    --custom-comment-glow: ' . esc_attr($color_chatbot) . ';
                    --custom-profile-glow: ' . esc_attr($color_qa) . ';
                    --custom-chatbot-glow: ' . esc_attr($color_post) . ';
                }
                75% {
                    --custom-post-glow: ' . esc_attr($color_chatbot) . ';
                    --custom-comment-glow: ' . esc_attr($color_qa) . ';
                    --custom-profile-glow: ' . esc_attr($color_post) . ';
                    --custom-chatbot-glow: ' . esc_attr($color_comment) . ';
                }
                100% {
                    --custom-post-glow: ' . esc_attr($color_post) . ';
                    --custom-comment-glow: ' . esc_attr($color_comment) . ';
                    --custom-profile-glow: ' . esc_attr($color_profile) . ';
                    --custom-chatbot-glow: ' . esc_attr($color_chatbot) . ';
                }
            }
            :root {
                animation: ilybdRgbGlowLoop 16s linear infinite !important;
            }
            ';
        }

        // Apply custom glow styles on elements in WordPress pages!
        $post_rgb = ilybd_hex_to_rgb_helper($color_post);
        $comment_rgb = ilybd_hex_to_rgb_helper($color_comment);
        $profile_rgb = ilybd_hex_to_rgb_helper($color_profile);
        $chatbot_rgb = ilybd_hex_to_rgb_helper($color_chatbot);
        $qa_rgb = ilybd_hex_to_rgb_helper($color_qa);
        $story_rgb = ilybd_hex_to_rgb_helper($color_story);
        $wallet_rgb = ilybd_hex_to_rgb_helper($color_wallet);
        $search_rgb = ilybd_hex_to_rgb_helper($color_search);

        echo "
        /* Dynamic Shadow and Borders Integration based on Admin choices */
        .single-post-card, .post-card, .card-post {
            border-color: var(--custom-post-glow) !important;
            box-shadow: 0 0 20px rgba(" . esc_attr($post_rgb) . ", 0.12) !important;
            transition: all 0.3s ease;
        }
        .comment-respond, .comment-box, .section-comments, .comment-list li {
            border-color: var(--custom-comment-glow) !important;
            box-shadow: 0 0 20px rgba(" . esc_attr($comment_rgb) . ", 0.12) !important;
        }
        .user-profile-card, .dashboard-user-card, .member-card, .profile-card-glow {
            border-color: var(--custom-profile-glow) !important;
            box-shadow: 0 0 25px rgba(" . esc_attr($profile_rgb) . ", 0.15) !important;
        }
        .maya-chatbot-wrapper, .chatbot-container, .interactive-assistant {
            border-color: var(--custom-chatbot-glow) !important;
            box-shadow: 0 0 25px rgba(" . esc_attr($chatbot_rgb) . ", 0.15) !important;
        }
        .community-qa-card, .qa-post, .forum-card {
            border-color: var(--custom-qa-glow) !important;
            box-shadow: 0 0 18px rgba(" . esc_attr($qa_rgb) . ", 0.12) !important;
        }
        .story-shelf-wrapper, .stories-grid, .story-card {
            border-color: var(--custom-story-glow) !important;
            box-shadow: 0 0 20px rgba(" . esc_attr($story_rgb) . ", 0.12) !important;
        }
        .wallet-balance-card, .balance-retract-widget, .payout-widget {
            border-color: var(--custom-wallet-glow) !important;
            box-shadow: 0 0 25px rgba(" . esc_attr($wallet_rgb) . ", 0.15) !important;
        }
        .search-container, .search-index-card, .search-box-field {
            border-color: var(--custom-search-glow) !important;
            box-shadow: 0 0 20px rgba(" . esc_attr($search_rgb) . ", 0.12) !important;
        }
        ";
    }

    if ($respect_device === 'yes') {
        echo '
        @media (prefers-color-scheme: light) {
            body {
                background: #f8fafc !important;
                color: #0f172a !important;
            }
            .wrap, .sidebar, .card, .post-card, header, .cyber-dropdown-menu, .single-post-card {
                background: #ffffff !important;
                color: #0f172a !important;
                border-color: rgba(15, 23, 42, 0.08) !important;
            }
            .logo-text {
                filter: none !important;
            }
        }
        ';
    }

    echo '</style>' . "\n";
}

// Helper to convert hex to rgb
function ilybd_hex_to_rgb_helper($hex) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    return "$r, $g, $b";
}

