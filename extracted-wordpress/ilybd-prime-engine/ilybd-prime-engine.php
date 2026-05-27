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
        'user-stats/tracker.php',
        'downloader/downloader-core.php',
        'downloader/rebrander.php',
        'ad-gate/locker.php',
        'daily-rewards/bonus.php',
        'layout-engine/cpt-logic.php',
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
        if ( file_exists( ILYBD_PLUGIN_DIR . 'admin/nid-control.php' ) ) {
            require_once ILYBD_PLUGIN_DIR . 'admin/nid-control.php';
        }
        
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_style('ibd-admin-style', ILYBD_PLUGIN_URL . 'assets/css/admin-style.css');
            wp_enqueue_style('ilybd-admin-custom', ILYBD_PLUGIN_URL . 'admin/admin-style.css');
        });
    }
}
add_action( 'plugins_loaded', 'ilybd_prime_init' );

/**
 * সেকশন ৩: এক্সটার্নাল লাইব্রেরি ও কোর ক্লাস (Gemini, OpenAI, Publisher)
 */
require_once ILYBD_PLUGIN_DIR . 'inc/class-ibd-key-rotator.php';
require_once ILYBD_PLUGIN_DIR . 'inc/class-ibd-gemini.php';
require_once ILYBD_PLUGIN_DIR . 'inc/class-ibd-openai.php';
require_once ILYBD_PLUGIN_DIR . 'inc/class-ibd-publisher.php';
require_once ILYBD_PLUGIN_DIR . 'admin/settings-panel.php';
require_once ILYBD_PLUGIN_DIR . 'admin/private-monitor.php';
require_once ILYBD_PLUGIN_DIR . 'admin/super-assistant-gui.php';

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

// এনআইডি জেনারেটর V2 শর্টকোড [ibd_nid_v2]
add_shortcode('ibd_nid_v2', function() {
    ob_start();
    $v2_path = ILYBD_PLUGIN_DIR . 'modules/nid-pro-v2/index.php';
    if ( file_exists( $v2_path ) ) {
        include $v2_path;
    } else {
        return "NID V2 Module Not Found!";
    }
    return ob_get_clean();
});

// কি (Key) জেনারেটর শর্টকোড [ibd_nid_key_gen]
add_shortcode('ibd_nid_key_gen', function() {
    $master_key = get_option('ibd_nid_unlock_key', 'IBD71');
    ob_start();
    ?>
    <div style="text-align: center; padding: 40px; background: #fff; border: 2px solid #006b3c; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
        <h2 style="color: #006b3c;">আপনার ভেরিফিকেশন কি (Key)</h2>
        <div style="font-size: 35px; font-weight: bold; color: #da291c; margin: 20px 0; border: 2px dashed #da291c; display: inline-block; padding: 15px 40px; background: #fff5f5;">
            <?php echo esc_html($master_key); ?>
        </div>
        <p style="color: #666;">এটি কপি করে এনআইডি পেজে বসিয়ে আনলক করুন।</p>
    </div>
    <?php
    return ob_get_clean();
});

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
        'NID Control',
        'NID Security',
        'manage_options',
        'ilybd-nid-control',
        (class_exists('ILYBD_NID_Control') ? [new ILYBD_NID_Control(), 'render_nid_control_page'] : null)
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
