<?php
/**
 * Admin: 2040 Live Staging Sync & One-Click Updater
 * Path: admin/live-sync.php
 * Description: Allows one-click update of theme/plugin files directly from AI Studio staging server.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function ilybd_live_sync_page() {
    if (!current_user_can('manage_options')) return;

    $staging_url = get_option('ilybd_staging_url', '');
    if (empty($staging_url)) {
        // Pre-populate with developer sandbox server URL to make it incredibly friendly to sync
        $staging_url = 'https://ais-dev-kj7sbotbfspb77im7cw3wt-262755331586.asia-southeast1.run.app';
    }

    $theme_sync_success = false;
    $plugin_sync_success = false;
    $error_message = '';

    if (isset($_POST['sync_action'])) {
        check_admin_referer('ilybd_sync_nonce');
        $action = sanitize_text_field($_POST['sync_action']);
        $staging_url = esc_url_raw(trim($_POST['staging_url']));
        update_option('ilybd_staging_url', $staging_url);

        // Include WordPress files needed for unzipping
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/screen.php');
        require_once(ABSPATH . 'wp-admin/includes/template.php');
        
        // Setup filesystem API
        WP_Filesystem();
        global $wp_filesystem;

        if ($action === 'theme') {
            $download_url = rtrim($staging_url, '/') . '/api/wordpress/download-fixed-theme';
            
            // Download the zip package
            $temp_file = download_url($download_url, 300); // 5 minute timeout

            if (is_wp_error($temp_file)) {
                $error_message = 'থিম ডাউনলোড করতে ব্যর্থ হয়েছে: ' . $temp_file->get_error_message();
            } else {
                $theme_dir = WP_CONTENT_DIR . '/themes';
                
                // Unzip and overwrite
                $result = unzip_file($temp_file, $theme_dir);
                unlink($temp_file); // clean up the temporary zip

                if (is_wp_error($result)) {
                    $error_message = 'থিম জিপ আনজিপ করতে ব্যর্থ হয়েছে: ' . $result->get_error_message();
                } else {
                    $theme_sync_success = true;
                }
            }
        } elseif ($action === 'plugin') {
            $download_url = rtrim($staging_url, '/') . '/api/wordpress/download-fixed-plugin';
            
            // Download the zip package
            $temp_file = download_url($download_url, 300); // 5 minute timeout

            if (is_wp_error($temp_file)) {
                $error_message = 'প্লাগিন ডাউনলোড করতে ব্যর্থ হয়েছে: ' . $temp_file->get_error_message();
            } else {
                $plugin_dir = WP_CONTENT_DIR . '/plugins';
                
                // Unzip and overwrite
                $result = unzip_file($temp_file, $plugin_dir);
                unlink($temp_file); // clean up the temporary zip

                if (is_wp_error($result)) {
                    $error_message = 'প্লাগিন জিপ আনজিপ করতে ব্যর্থ হয়েছে: ' . $result->get_error_message();
                } else {
                    $plugin_sync_success = true;
                }
            }
        }
    }
    ?>
    <div class="wrap" style="background:#070b13; padding:25px; border-radius:12px; border:1px solid #1f2a44; color:#fff; max-width:950px; margin-top:20px; font-family:'Segoe UI',system-ui,sans-serif; box-shadow:0 10px 30px rgba(0,0,0,0.5);">
        
        <div style="background: radial-gradient(circle at top right, rgba(0, 240, 255, 0.08), transparent); border-radius:10px; padding:20px 25px; border: 1px solid rgba(0, 240, 255, 0.15);">
            <h1 style="color: #00f0ff; font-weight: 800; font-size: 28px; margin:0 0 10px 0; display:flex; align-items:center; letter-spacing:-0.5px; text-shadow:0 0 15px rgba(0, 240, 255, 0.3);">
                <span class="dashicons dashicons-cloud-saved" style="font-size:36px; width:36px; height:36px; margin-right:12px; color:#00f0ff;"></span> 
                IBD Cyber Next-Gen Live Staging Sync
            </h1>
            <p style="color:#8ba3c7; font-size:14px; margin:0; line-height:1.6;">
                এখান থেকে আপনি আপনার মায়া এআই স্টুডিও (AI Studio Developer Environment) এর সাথে আপনার লাইভ ওয়েবসাইটের থিম এবং প্লাগইন সিঙ্ক করতে পারবেন। আপনি এআই স্টুডিওতে যখনই কোনো বাগ ফিক্স, মডিউল আপডেট বা কোড চেঞ্জ করবেন, তা একটি ক্লিকের মাধ্যমে আপনার লাইভ সাইটের রাইট ফোল্ডারে রি-রাইট এবং আপডেট হয়ে যাবে!
            </p>
        </div>

        <?php if ($theme_sync_success): ?>
            <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-top: 20px; font-weight: bold;">
                🎉 চমৎকার! ILYBD Neon v1 Pro থিম সফলভাবে এআই স্টুডিও ডেভেলপমেন্ট কানেকশন থেকে ডাইরেক্ট আপডেট ও সিঙ্ক হয়েছে! (Zero-Latency Transfer Completed)
            </div>
        <?php endif; ?>

        <?php if ($plugin_sync_success): ?>
            <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 8px; margin-top: 20px; font-weight: bold;">
                🎉 চমৎকার! ILYBD Prime Engine প্লাগিন সফলভাবে এআই স্টুডিও ডেভেলপমেন্ট কানেকশন থেকে ডাইরেক্ট আপডেট ও সিঙ্ক হয়েছে! (Engine Refreshed V2)
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 8px; margin-top: 20px;">
                ⚠️ <strong>ত্রুটি (Error):</strong> <?php echo esc_html($error_message); ?><br>
                <span style="font-size:12px; opacity:0.8;">সাহায্য: আপনার টাইপ করা এআই স্টুডিওর ইউআরএল-টি লাইভ এবং সঠিক কি না তা পুনরায় চেক করে দেখুন।</span>
            </div>
        <?php endif; ?>

        <div style="margin-top:30px;">
            <form method="post" action="">
                <?php wp_nonce_field('ilybd_sync_nonce'); ?>
                
                <table class="form-table" style="color:#e2e8f0; margin-bottom: 20px;">
                    <tr valign="top">
                        <th scope="row" style="color:#00f0ff; font-weight:600; width:250px; font-size:15px;">AI Studio Applet Dev URL</th>
                        <td>
                            <input type="url" name="staging_url" value="<?php echo esc_url($staging_url); ?>" placeholder="https://ais-dev-xxxx.asia-southeast1.run.app" required style="background:#0d1527; border:1px solid #1f2a44; color:#fff; border-radius:6px; padding:10px 15px; width:100%; max-width:550px; font-family:monospace; box-shadow:inset 0 0 10px rgba(0,0,0,0.5); font-size:13.5px;" />
                            <p class="description" style="color:#718096; margin-top:8px;">এখানে আপনার রানিং এআই স্টুডিও অ্যাপলেট বিল্ড ইউজার ডেভেলপমেন্ট ইউআরএলটি প্রদান করুন। এটি আপনার লাইভ সাইটের ডাটা সোর্স লিংক হিসেবে কাজ করবে।</p>
                        </td>
                    </tr>
                </table>

                <!-- Action Cards Grid -->
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:20px; margin-top:35px;">
                    
                    <!-- Card 1: Theme Sync -->
                    <div style="background:#0d1527; border: 1px solid #1f2a44; border-radius:10px; padding:25px; transition:all 0.3s ease; box-shadow:0 4px 20px rgba(0,0,0,0.25); display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                <h3 style="color:#00f0ff; font-size:18px; font-weight:700; margin:0;">🎨 ILYBD Neon Theme Sync</h3>
                                <span style="background:rgba(0, 240, 255, 0.1); color:#00f0ff; padding:3px 8px; border-radius:10px; font-size:11px; font-family:monospace;">THEME</span>
                            </div>
                            <p style="color:#a0aec0; font-size:13px; line-height:1.6; margin:0 0 25px 0;">
                                আপনার সাইটের প্রধান হাই-টেক ২০৪০ নেওন উইজার্ড থিম ফাইলগুলো এআই স্টুডিওর কোডে কোনো কারেকশন বা সিএসএস ইম্প্রুভমেন্ট করা থাকলে একদম লেটেস্ট ভার্সনে ওভাররাইট করে আপগ্রেড করবে।
                            </p>
                        </div>
                        <button type="submit" name="sync_action" value="theme" style="background:#00f0ff; border:none; text-shadow:none; color:#070b13; font-weight:800; padding:12px 20px; border-radius:6px; cursor:pointer; width:100%; font-size:14px; transition:all 0.2s ease; box-shadow:0 0 15px rgba(0,240,255,0.4); text-transform:uppercase; letter-spacing:0.5px;">
                            🔄 Update Theme (এক ক্লিকে আপডেট)
                        </button>
                    </div>

                    <!-- Card 2: Plugin Sync -->
                    <div style="background:#0d1527; border: 1px solid #1f2a44; border-radius:10px; padding:25px; transition:all 0.3s ease; box-shadow:0 4px 20px rgba(0,0,0,0.25); display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                <h3 style="color:#bf55ec; font-size:18px; font-weight:700; margin:0;">⚙️ ILYBD Prime Engine Sync</h3>
                                <span style="background:rgba(191, 85, 236, 0.1); color:#bf55ec; padding:3px 8px; border-radius:10px; font-size:11px; font-family:monospace;">PLUGIN</span>
                            </div>
                            <p style="color:#a0aec0; font-size:13px; line-height:1.6; margin:0 0 25px 0;">
                                আপনার প্রধান আর্নিং ক্যালকুলেশন মেকানিজম, মেটা-ডাটা হিলার, এবং ব্যালেন্স-পয়েন্ট ইন্টিগ্রেশন সোর্স ফাইল সম্বলিত প্লাগিন ফাইলগুলোকে ইনস্ট্যান্ট আপডেট এবং ডাইরেক্ট রিলোড করবে।
                            </p>
                        </div>
                        <button type="submit" name="sync_action" value="plugin" style="background:#bf55ec; border:none; text-shadow:none; color:#fff; font-weight:800; padding:12px 20px; border-radius:6px; cursor:pointer; width:100%; font-size:14px; transition:all 0.2s ease; box-shadow:0 0 15px rgba(191,85,236,0.4); text-transform:uppercase; letter-spacing:0.5px;">
                            🔄 Update Plugin (এক ক্লিকে আপডেট)
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <!-- 🚀 2040 Build Sync Status Bulletin -->
        <div style="margin-top:40px; border-top:1px solid #1f2a44; padding-top:25px; display:flex; justify-content:space-between; font-family:monospace; font-size:11px; color:#5a6e85;">
            <div>GATEWAY: ILYBD CRYPTO CONNECT SECURE v4.0</div>
            <div>STATUS: STANDBY READY</div>
            <div>DEVELOPMENT SOURCE: AIS_BUILD_PRO_GATE</div>
        </div>

    </div>
    <?php
}
