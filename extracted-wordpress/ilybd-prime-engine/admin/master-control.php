<?php
/**
 * Admin: Master Control Panel
 * Path: admin/master-control.php
 * Description: API Pool Management and Revenue Settings for ILYBD Engine.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class ILYBD_Master_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'ilybd_add_menu'));
        add_action('admin_init', array($this, 'ilybd_settings_init'));
    }

    public function ilybd_add_menu() {
        add_menu_page(
            'ILYBD Control',
            'ILYBD Master',
            'manage_options',
            'ilybd-engine-settings',
            array($this, 'ilybd_render_admin_page'),
            'dashicons-chart-pie',
            25
        );
    }

    public function ilybd_settings_init() {
        register_setting('ilybd_settings_group', 'ilybd_api_keys');
        register_setting('ilybd_settings_group', 'ilybd_rev_share_percent');
        register_setting('ilybd_settings_group', 'ilybd_ad_timer');
    }

    public function ilybd_render_admin_page() {
        if (isset($_POST['ilybd_prime_clear_cache_submit'])) {
            check_admin_referer('ilybd_prime_action_nonce');
            if (function_exists('ilybd_prime_purge_all_cache')) {
                ilybd_prime_purge_all_cache();
                echo '<div class="notice notice-success is-dismissible" style="background:#161b22; color:#00ff41; border:1px solid #00ff41; padding:15px; margin:20px 0; border-radius:6px;"><p style="margin:0; font-weight:bold;">⚡ সকল ক্যাশড স্ট্যাটিক ফাইল সফলভাবে ক্লিয়ার হয়েছে!</p></div>';
            }
        }

        if (isset($_POST['ilybd_prime_optimize_db_submit'])) {
            check_admin_referer('ilybd_prime_action_nonce');
            if (function_exists('ilybd_prime_optimize_database')) {
                ilybd_prime_optimize_database();
                echo '<div class="notice notice-success is-dismissible" style="background:#161b22; color:#00d4ff; border:1px solid #00d4ff; padding:15px; margin:20px 0; border-radius:6px;"><p style="margin:0; font-weight:bold;">⚙️ ডাটাবেস অপ্টিমাইজেশন সম্পন্ন হয়েছে এবং ট্র্যাশ কমেন্ট/রিভিশন ক্লিন করা হয়েছে!</p></div>';
            }
        }

        $cache_stats = array('count' => 0, 'size' => 0);
        if (function_exists('ilybd_prime_get_cache_stats')) {
            $cache_stats = ilybd_prime_get_cache_stats();
        }
        ?>
        <div class="wrap" style="background:#0d1117; padding:25px; border-radius:12px; border:1px solid #30363d; color:#fff; max-width:950px; margin-top:20px; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,sans-serif;">
            <h1 style="color: #00ff41; font-weight: 800; font-size: 26px; margin-bottom:10px; display:flex; align-items:center;">
                <span class="dashicons dashicons-dashboard" style="font-size:32px; width:32px; height:32px; margin-right:10px; color:#00ff41;"></span> 
                ILYBD Prime Engine - Master Control
            </h1>
            <p style="color:#8b949e; font-size:13.5px; margin-bottom:25px; margin-top:0;">
                গ্লোবাল ওয়ালেট ডিস্ট্রিবিউশন, প্রফেশনাল স্পিড অপ্টিমাইজার এবং ক্যাশে ম্যানেজমেন্ট কন্ট্রোল প্যানেল।
            </p>
            <hr style="border-color:#30363d;">
            
            <form method="post" action="options.php">
                <?php
                settings_fields('ilybd_settings_group');
                do_settings_sections('ilybd-engine-settings');
                ?>
                <table class="form-table" style="color:#e6edf3;">
                    <tr valign="top">
                        <th scope="row" style="color:#00ff41; font-weight:600; width:220px;">API Keys Pool (Comma Separated)</th>
                        <td>
                            <textarea name="ilybd_api_keys" rows="6" cols="50" style="background:#161b22; border:1px solid #30363d; color:#fff; border-radius:6px; padding:10px; font-family:monospace; width:100%; max-width:600px;" placeholder="key1, key2, key3..."><?php echo esc_attr(get_option('ilybd_api_keys')); ?></textarea>
                            <p class="description" style="color:#8b949e; margin-top:5px;">এখানে আপনার ৫০টি বা তার বেশি এপিআই কি কমা (,) দিয়ে বসান।</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" style="color:#00ff41; font-weight:600;">User Revenue Share (%)</th>
                        <td>
                            <input type="number" name="ilybd_rev_share_percent" value="<?php echo esc_attr(get_option('ilybd_rev_share_percent', '20')); ?>" min="1" max="100" style="background:#161b22; border:1px solid #30363d; color:#fff; border-radius:6px; padding:8px 12px; width:100px;" />
                            <p class="description" style="color:#8b949e; margin-top:5px;">ইউজারদের কত শতাংশ ইনকাম শেয়ার করবেন (ডিফল্ট ২০%)।</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" style="color:#00ff41; font-weight:600;">Ad Gate Timer (Seconds)</th>
                        <td>
                            <input type="number" name="ilybd_ad_timer" value="<?php echo esc_attr(get_option('ilybd_ad_timer', '15')); ?>" style="background:#161b22; border:1px solid #30363d; color:#fff; border-radius:6px; padding:8px 12px; width:100px;" />
                            <p class="description" style="color:#8b949e; margin-top:5px;">ডাউনলোড বাটন আসার আগে কত সেকেন্ড অ্যাড লোড হবে।</p>
                        </td>
                    </tr>
                </table>
                <div style="margin-top:20px;">
                    <?php submit_button('Save All Settings', 'primary', 'submit', false, array('style' => 'background:#00ff41; border:none; text-shadow:none; color:#0d1117; font-weight:bold; height:auto; padding:10px 24px; border-radius:6px; cursor:pointer;')); ?>
                </div>
            </form>

            <!-- ILYBD Premium Static Cache & DB Optimizer Center -->
            <div style="margin-top:45px; border-top:1px solid #30363d; padding-top:30px;">
                <h3 style="color:#00ff41; font-weight:700; font-size:18px; display:flex; align-items:center; margin-top:0; margin-bottom:8px;">
                    <span class="dashicons dashicons-performance" style="margin-right:8px; font-size:24px; width:24px; height:24px; color:#00ff41; display:inline-block;"></span> 
                    ILYBD Pro Speed Optimization & Cache Engine
                </h3>
                <p style="color:#8b949e; font-size:13px; line-height:1.6; margin-bottom:25px; max-width:800px;">
                    LiteSpeed Cache প্লাগিন ছাড়াই এখন আপনার কাস্টম স্পিড ইঞ্জিন পুরো ওয়েবসাইটের ডাইনামিক পেজগুলোকে সুপার-কম্প্রেসড স্ট্যাটিক এইচটিএমএল (HTML) ক্যাশ ফাইলে পরিণত করছে। ভিজিটিং ইউজাররা কোনো কুয়েরি ছাড়াই <strong style="color:#00ff41;">৫ মিলি-সেকেন্ডের নিচে</strong> রেন্ডারড পেজ পাচ্ছেন, যার ফলে TTFB এবং mobile PageSpeed স্কোর সর্বোচ্চ লেভেলে উঠে যাবে।
                </p>

                <div style="display:flex; gap:20px; margin-bottom:25px; max-width:800px;">
                    <!-- Stat 1 -->
                    <div style="background:#161b22; border:1px solid #30363d; padding:20px; border-radius:8px; flex:1; text-align:center;">
                        <div style="font-size:11px; color:#8b949e; text-transform:uppercase; font-weight:600; letter-spacing:1px; margin-bottom:5px;">ক্যাশড পেজসমূহ</div>
                        <div style="font-size:32px; font-weight:bold; color:#00ff41; font-family:monospace;"><?php echo intval($cache_stats['count']); ?> টি</div>
                    </div>
                    <!-- Stat 2 -->
                    <div style="background:#161b22; border:1px solid #30363d; padding:20px; border-radius:8px; flex:1; text-align:center;">
                        <div style="font-size:11px; color:#8b949e; text-transform:uppercase; font-weight:600; letter-spacing:1px; margin-bottom:5px;">মেমোরি স্টোরেজ বুকড</div>
                        <div style="font-size:32px; font-weight:bold; color:#00d4ff; font-family:monospace;"><?php echo esc_html($cache_stats['size']); ?> MB</div>
                    </div>
                </div>

                <!-- Control actions -->
                <form method="post" action="">
                    <?php wp_nonce_field('ilybd_prime_action_nonce'); ?>
                    <div style="display:flex; flex-wrap:wrap; gap:15px; align-items:center;">
                        <!-- Purge Cache Button -->
                        <button type="submit" name="ilybd_prime_clear_cache_submit" style="background:#ff3e3e; border:none; color:#fff; font-weight:bold; padding:12px 22px; border-radius:6px; cursor:pointer; display:inline-flex; align-items:center; font-size:13.5px;">
                            <span class="dashicons dashicons-trash" style="margin-right:6px; font-size:18px; width:18px; height:18px;"></span> 
                            ম্যানুয়ালি ক্যাশে ক্লিয়ার করুন
                        </button>

                        <!-- DB Optimizer Button -->
                        <button type="submit" name="ilybd_prime_optimize_db_submit" style="background:#00d4ff; border:none; color:#0d1117; font-weight:bold; padding:12px 22px; border-radius:6px; cursor:pointer; display:inline-flex; align-items:center; font-size:13.5px;">
                            <span class="dashicons dashicons-admin-generic" style="margin-right:6px; font-size:18px; width:18px; height:18px;"></span> 
                            ডাটাবেজ আবর্জনা ও রিভিশন ক্লিন করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }
}
new ILYBD_Master_Admin();
