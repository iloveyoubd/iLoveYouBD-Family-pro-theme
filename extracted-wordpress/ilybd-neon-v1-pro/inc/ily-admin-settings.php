<?php
/**
 * ILYBD Neon Pro - Master Admin Control Center
 * Saved Settings + Global Withdrawal Approval Portal
 */
if (!defined('ABSPATH')) exit;

/* =========================================
   ১.১ এডমিন মেনু ও উইথড্রয়াল সাব-মেনু রেজিস্ট্রেশন
   ========================================= */
add_action('admin_menu', function () {
    // Submenu linked directly under the unified Neon Master control center (ilybd-settings)
    add_submenu_page(
        'ilybd-settings',
        'Earning Withdrawals Manager',
        'Payout Requests 💰',
        'manage_options',
        'ily-withdrawals',
        'ily_withdrawals_admin_page'
    );
});

/* =========================================
   ১.২ সেটিং সেভ অ্যালগরিদম
   ========================================= */
function ily_save_settings() {
    if (!current_user_can('manage_options')) return;

    if (isset($_POST['save_ily'])) {
        update_option('ily_greeting', sanitize_text_field($_POST['ily_greeting']));
        update_option('ily_notif_count_sc', sanitize_text_field($_POST['ily_notif_count_sc']));
        update_option('ily_balance_sc', sanitize_text_field($_POST['ily_balance_sc']));
        update_option('ily_default_neon', sanitize_hex_color($_POST['ily_default_neon']));
        update_option('ily_site_mode', sanitize_text_field($_POST['ily_site_mode']));
        update_option('ily_auto_feature', isset($_POST['ily_auto_feature']) ? 1 : 0);
        update_option('ily_enable_slider', isset($_POST['ily_enable_slider']) ? 1 : 0);
        update_option('ily_enable_featured_posts', isset($_POST['ily_enable_featured_posts']) ? 1 : 0);
        update_option('ily_enable_popular_posts', isset($_POST['ily_enable_popular_posts']) ? 1 : 0);
        update_option('ily_enable_community_qa', isset($_POST['ily_enable_community_qa']) ? 1 : 0);
        update_option('ily_enable_ai_qa_autopilot', isset($_POST['ily_enable_ai_qa_autopilot']) ? 1 : 0);
        update_option('ily_ai_qa_frequency', isset($_POST['ily_ai_qa_frequency']) ? sanitize_text_field($_POST['ily_ai_qa_frequency']) : 'daily');
        update_option('ily_ai_qa_daily_limit', isset($_POST['ily_ai_qa_daily_limit']) ? intval($_POST['ily_ai_qa_daily_limit']) : 5);
        update_option('ily_enable_categories', isset($_POST['ily_enable_categories']) ? 1 : 0);
        update_option('ilybd_show_app_section', isset($_POST['ilybd_show_app_section']) ? 1 : 0);
        update_option('ily_enable_brand_manifesto', isset($_POST['ily_enable_brand_manifesto']) ? 1 : 0);
        update_option('ily_enable_predictive_suggestions', isset($_POST['ily_enable_predictive_suggestions']) ? 1 : 0);
        update_option('ily_enable_adsense_placeholders', isset($_POST['ily_enable_adsense_placeholders']) ? 1 : 0);

        echo '<div class="updated"><p>⚡ System Options Saved!</p></div>';
    }
}
add_action('admin_init', 'ily_save_settings');

/* =========================================
   ১.৩ উইথড্রয়াল এপ্রুভাল রিকোয়েস্ট এক্সেপ্টিং
   ========================================= */
function ily_handle_admin_withdraw_payouts() {
    if (!current_user_can('manage_options')) return;

    if (isset($_GET['payout_action']) && isset($_GET['req_id']) && isset($_GET['user_id'])) {
        $payout_action = sanitize_text_field($_GET['payout_action']);
        $req_id        = sanitize_text_field($_GET['req_id']);
        $target_user_id= intval($_GET['user_id']);
        
        $withdrawals = get_user_meta($target_user_id, 'ilybd_withdrawals', true);
        $withdrawals = is_array($withdrawals) ? $withdrawals : [];
        $modified = false;
        
        foreach ($withdrawals as &$w) {
            if ($w['id'] === $req_id && $w['status'] === 'pending') {
                if ($payout_action === 'approve') {
                    $w['status'] = 'Completed';
                    $modified = true;
                    $success_msg = sprintf("🟢 আপনার Bkash/Nagad ওয়ালেট ক্যাশআউট ৳%s টাকার রিকোয়েস্টটি সফলভাবে পরিশোধ (Completed) করা হয়েছে!", number_format($w['amount'], 2));
                    ilybd_add_user_notification($target_user_id, $success_msg);
                } elseif ($payout_action === 'reject') {
                    $w['status'] = 'rejected';
                    $modified = true;
                    
                    // রিজেক্ট হলে ব্যালেন্স ওয়ালেটে ফেরত দিন
                    $balance = (float) get_user_meta($target_user_id, 'user_balance', true);
                    $balance += $w['amount'];
                    update_user_meta($target_user_id, 'user_balance', $balance);
                    
                    $fail_msg = sprintf("❌ কোনো সমস্যার কারণে আপনার ৳%s টাকার উইথড্রয়ালটি প্রত্যাখ্যান (Rejected) করা হয়েছে। টাকা ওয়ালেটে রিফান্ড করা হয়েছে।", number_format($w['amount'], 2));
                    ilybd_add_user_notification($target_user_id, $fail_msg);
                }
                break;
            }
        }
        
        if ($modified) {
            update_user_meta($target_user_id, 'ilybd_withdrawals', $withdrawals);
            wp_redirect(admin_url('admin.php?page=ily-withdrawals&updated=1'));
            exit;
        }
    }
}
add_action('admin_init', 'ily_handle_admin_withdraw_payouts');

/* =========================================
   ২.১ মেইন অপশনস পেজ UI
   ========================================= */
function ily_options_page() {
    $neon = get_option('ily_default_neon', '#00ff41');
    ?>
    <div class="wrap" style="background:#0d1117; padding:25px; border-radius:12px; border:1px solid #30363d; color:#fff; max-width:900px; margin-top:20px;">
        <h1 style="color:#00ff41; font-weight:800; font-size:24px; margin-bottom:20px;">⚡ ILYBD Mastery Panel Control</h1>
        <form method="post">
            <table class="form-table" style="color:#c9d1d9;">
                <tr>
                    <th style="color:#fff;">Greeting Text</th>
                    <td><input type="text" name="ily_greeting" value="<?php echo esc_attr(get_option('ily_greeting', 'হাই')); ?>" style="width:300px; padding:6px; background:#161b22; color:#fff; border:1px solid #30363d; border-radius:4px;"></td>
                </tr>
                <tr>
                    <th style="color:#fff;">Notification Shortcode</th>
                    <td><input type="text" name="ily_notif_count_sc" value="<?php echo esc_attr(get_option('ily_notif_count_sc', '[notif_count]')); ?>" style="width:300px; padding:6px; background:#161b22; color:#fff; border:1px solid #30363d; border-radius:4px;"></td>
                </tr>
                <tr>
                    <th style="color:#fff;">Wallet Balance Shortcode</th>
                    <td><input type="text" name="ily_balance_sc" value="<?php echo esc_attr(get_option('ily_balance_sc', '[my_balance]')); ?>" style="width:300px; padding:6px; background:#161b22; color:#fff; border:1px solid #30363d; border-radius:4px;"></td>
                </tr>
                <tr>
                    <th style="color:#fff;">Primary Neon Theme Color</th>
                    <td><input type="color" name="ily_default_neon" value="<?php echo esc_attr($neon); ?>" style="width:60px; height:35px; border:1px solid #30363d; border-radius:4px; background:none;"></td>
                </tr>
                <tr>
                    <th style="color:#fff;">Site Operation Mode</th>
                    <td>
                        <select name="ily_site_mode" style="width:300px; padding:6px; background:#161b22; color:#fff; border:1px solid #30363d; border-radius:4px;">
                            <option value="normal" <?php selected(get_option('ily_site_mode'), 'normal'); ?>>Normal Mode</option>
                            <option value="cyber" <?php selected(get_option('ily_site_mode'), 'cyber'); ?>>Cyber Mode</option>
                            <option value="social" <?php selected(get_option('ily_site_mode'), 'social'); ?>>Social Feed Mode</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Featured System Algorithm</th>
                    <td>
                        <label>
                            <input type="checkbox" name="ily_auto_feature" value="1" <?php checked(get_option('ily_auto_feature'), 1); ?>>
                            Enable AI Featured Selection (views + likes threshold control)
                        </label>
                    </td>
                </tr>
                <tr style="border-top:1px solid #30363d;">
                    <th colspan="2" style="color:#00ff41; font-size:16px; font-weight:800; padding-top:20px; padding-bottom:10px;">📊 Homepage Layout & Module Control (ওয়ান-ক্লিক অন/অফ ফিল্টার)</th>
                </tr>
                <tr>
                    <th style="color:#fff;">Sliding New Posts (স্লাইডিং পোস্ট সিস্টেম)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ily_enable_slider" value="1" <?php checked(get_option('ily_enable_slider', 1), 1); ?>>
                            সচল বা অন রাখুন (বন্ধ করতে চাইলে টিক চিহ্ণ উঠিয়ে দিন)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">এটি অফ করে দিলে আমাদের পেজের স্লাইডিং পোস্ট অপশনটি সম্পূর্ণ হাইড হয়ে যাবে।</p>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Featured Posts Module (ফিউচারড পোস্ট)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ily_enable_featured_posts" value="1" <?php checked(get_option('ily_enable_featured_posts', 1), 1); ?>>
                            সচল বা অন রাখুন (বন্ধ করতে চাইলে টিক চিহ্ণ উঠিয়ে দিন)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">হোমপেজের ফিউচারড পোস্ট মডিউলটি অন/অফ করতে এটি ব্যবহার করুন।</p>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Popular Posts Module (পপুলার পোস্ট)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ily_enable_popular_posts" value="1" <?php checked(get_option('ily_enable_popular_posts', 1), 1); ?>>
                            সচল বা অন রাখুন (বন্ধ করতে চাইলে টিক চিহ্ণ উঠিয়ে দিন)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">হোমপেজের পপুলার পোস্ট মডিউলটি অন/অফ করতে এটি ব্যবহার করুন।</p>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Community Q&A Panel (প্রশ্ন ও উত্তর সেন্টার)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ily_enable_community_qa" value="1" <?php checked(get_option('ily_enable_community_qa', 1), 1); ?>>
                            সচল বা অন রাখুন (বন্ধ করতে চাইলে টিক চিহ্ণ উঠিয়ে দিন)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">কমিউনিটি প্রশ্ন-উত্তর সেকশনটি হোমপেজে প্রদর্শন বা হাইড করতে সাহায্য করবে।</p>
                    </td>
                </tr>
                <tr>
                    <th style="color:#00f0ff; text-shadow: 0 0 8px rgba(0,240,255,0.4);">AI Autopilot Q&A Engine (অটোপাইলট প্রশ্ন-উত্তর)</th>
                    <td>
                        <label style="color:#00ff41; font-weight:bold;">
                            <input type="checkbox" name="ily_enable_ai_qa_autopilot" value="1" <?php checked(get_option('ily_enable_ai_qa_autopilot', 0), 1); ?>>
                            অটোপাইলট ইঞ্জিন চালু করুন (AI സ്വয়ংক্রিয়ভাবে প্রশ্ন ও উত্তর জেনারেট করবে)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">এটি চালু করলে AI প্রতিদিন নিজে থেকেই ফেক প্রোফাইল ক্রিয়েট করে প্রশ্ন করবে এবং অন্যান্য প্রোফাইল থেকে উত্তর দেবে। এটি সম্পূর্ণ আলাদা একটি সিস্টেম যা আগের কোনো কিছুর সাথে সাংঘর্ষিক হবে না।</p>
                        <?php if(get_option('ily_enable_ai_qa_autopilot', 0) == 1): ?>
                            <div style="margin-top:15px; padding: 15px; background: rgba(0, 240, 255, 0.05); border: 1px solid rgba(0, 240, 255, 0.2); border-radius: 8px;">
                                <h4 style="color:#00f0ff; margin-top:0; font-family: monospace;">⚙️ Autopilot Configuration</h4>
                                
                                <div style="margin-bottom: 12px;">
                                    <label style="color:#e2e8f0; display:block; margin-bottom:5px; font-weight:bold;">Frequency (কতক্ষণ পর পর প্রশ্ন পাবলিক হবে?):</label>
                                    <select name="ily_ai_qa_frequency" style="background:#0d1527; color:#fff; border:1px solid #30363d; border-radius:4px; padding: 4px; width: 100%; max-width: 400px;">
                                        <option value="hourly" <?php selected(get_option('ily_ai_qa_frequency', 'every_4_hours'), 'hourly'); ?>>প্রতি ১ ঘণ্টা পর পর (দ্রুত)</option>
                                        <option value="every_4_hours" <?php selected(get_option('ily_ai_qa_frequency', 'every_4_hours'), 'every_4_hours'); ?>>প্রতি ৪ ঘণ্টা পর পর (Recommended)</option>
                                        <option value="every_6_hours" <?php selected(get_option('ily_ai_qa_frequency', 'every_4_hours'), 'every_6_hours'); ?>>প্রতি ৬ ঘণ্টা পর পর (Standard)</option>
                                        <option value="twicedaily" <?php selected(get_option('ily_ai_qa_frequency', 'every_4_hours'), 'twicedaily'); ?>>প্রতি ১২ ঘণ্টা পর পর (দিনে ২ বার)</option>
                                        <option value="daily" <?php selected(get_option('ily_ai_qa_frequency', 'every_4_hours'), 'daily'); ?>>প্রতি ২৪ ঘণ্টা পর পর (দিনে ১ বার)</option>
                                    </select>
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <label style="color:#e2e8f0; display:block; margin-bottom:5px; font-weight:bold;">Daily Limit (দিনে সর্বোচ্চ কয়টি প্রশ্ন হবে?):</label>
                                    <input type="number" name="ily_ai_qa_daily_limit" value="<?php echo esc_attr(get_option('ily_ai_qa_daily_limit', 5)); ?>" min="1" max="24" style="background:#0d1527; color:#fff; border:1px solid #30363d; border-radius:4px; width: 80px; padding: 4px;">
                                </div>
                                
                                <p style="color:#cfd8dc; font-size:11.5px; margin-bottom: 15px; line-height: 1.4;">
                                    <span style="color:#ffcc00; font-weight:bold;">⚠️ SEO Warning:</span> দিনে <strong>৪-৬টি</strong>-এর বেশি প্রশ্ন অটো-পাবলিক না হওয়াই ভালো, কারণ অতিরিক্ত অটো-কন্টেন্ট Google Spam Update এ পেনাল্টি খেতে পারে। <br>"প্রতি ৪ ঘণ্টা পর পর" এবং "সর্বোচ্চ ৫টি" সেট করা সবচেয়ে নিরাপদ।
                                </p>

                                <a href="<?php echo esc_url(admin_url('admin-post.php?action=trigger_qa_autopilot')); ?>" class="button button-secondary" style="background:#0d1527; color:#00f0ff; border-color:#00f0ff; box-shadow: 0 0 5px rgba(0,240,255,0.2);">🚀 Test Run Autopilot Now</a>
                                <?php if(isset($_GET['autopilot_fired'])): ?>
                                    <span style="color:#00ff41; font-size:12px; margin-left:10px; font-weight: bold;">✅ AI generated new Q&A successfully!</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Brand Manifesto (ব্র্যান্ড ম্যানিফেস্টো ব্যানার)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ily_enable_brand_manifesto" value="1" <?php checked(get_option('ily_enable_brand_manifesto', 0), 1); ?>>
                            হোমপেজে সচল বা অন রাখুন (অফ করতে চাইলে টিক চিহ্ণ উঠিয়ে দিন - স্পেস বাঁচাতে ডিফল্টভাবে অফ থাকে)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">হোমপেজে ব্র্যান্ড ম্যানিফেস্টো (স্বাগতম ব্যানার ফাইল) সেকশনটি প্রদর্শন বা হাইড করতে এটি ব্যবহার করুন।</p>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Categories Showcase (ক্যাটাগরি সেকশন)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ily_enable_categories" value="1" <?php checked(get_option('ily_enable_categories', 1), 1); ?>>
                            সচল বা অন রাখুন (বন্ধ করতে চাইলে টিক চিহ্ণ উঠিয়ে দিন)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">হোমপেজ এবং পোস্ট পেজের ক্যাটাগরি প্যানেলটি প্রদর্শন বা হাইড করতে সাহায্য করবে।</p>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Play Store GPLAY App Hub (ডাউনলোড সেন্টার)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ilybd_show_app_section" value="1" <?php checked(get_option('ilybd_show_app_section', 1), 1); ?>>
                            সচল বা অন রাখুন (বন্ধ করতে চাইলে টিক চিহ্ণ উঠিয়ে দিন)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">গুগল প্লে সেফ অ্যাপ ডিসকভারি পোর্টালটি প্রদর্শন বা হাইড করতে সাহায্য করবে।</p>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Predictive Suggestion Engine (অনুকূল পূর্বানুমান ক্যাটাগরি ফিল্টার)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ily_enable_predictive_suggestions" value="1" <?php checked(get_option('ily_enable_predictive_suggestions', 0), 1); ?>>
                            সচল বা অন রাখুন (ডিফল্টভাবে বন্ধ থাকে যাতে সেটিংসের ১০টি লেটেস্ট পোস্ট সবসময় শো করে)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">এটি অন থাকলে ইউজার শেষ যে ক্যাটাগরি ভিজিট করেছে হোমপেজে অগ্রাধিকার ভিত্তিতে সেই ক্যাটাগরির পোস্টগুলো মিক্সড করে রেন্ডার করবে। অফ থাকলে সেটিংসের নির্ধারিত লেটেস্ট পোস্টগুলো সাধারণ ক্রমানুসারে শো করবে।</p>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">AdSense Placeholders (বিজ্ঞাপন কন্টেইনার সমূহ)</th>
                    <td>
                        <label style="color:#e2e8f0;">
                            <input type="checkbox" name="ily_enable_adsense_placeholders" value="1" <?php checked(get_option('ily_enable_adsense_placeholders', 0), 1); ?>>
                            গুগল এডসেন্স বিজ্ঞাপন স্পেসসমূহ অন রাখুন (ডিফল্টভাবে বন্ধ রাখা হলো যাতে এডসেন্স পাওয়ার আগে কোনো খালি বিজ্ঞাপন কন্টেইনার শো না করে)
                        </label>
                        <p style="color:#8b949e; font-size:11.5px; margin:4px 0 0 0;">এটি চালু করলে বিভিন্ন পোস্টের ভেতরে বা উপরে [ ADVERTISING CONTAINER ] নামক গুগল এডসেন্স অনুগত বিজ্ঞাপন কন্টেইনার স্পেস প্রদর্শন করবে। বন্ধ থাকলে এগুলো অটো হাইড থাকবে।</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save System Settings', 'primary', 'save_ily'); ?>
        </form>
    </div>
    <?php
}

/* =========================================
   ২.২ এডমিন পেমেন্ট উইথড্রয়ালস কাস্টম লিস্ট UI
   ========================================= */
function ily_withdrawals_admin_page() {
    if (isset($_GET['updated'])) {
        echo '<div class="updated"><p>✅ Withdrawal payout processed successfully.</p></div>';
    }
    
    // উইথড্র করা সমস্ত ইউজারদের খুঁজে বের করুন
    $users = get_users([
        'meta_key' => 'ilybd_withdrawals',
    ]);
    
    $all_withdraws = [];
    foreach ($users as $u) {
        $w_list = get_user_meta($u->ID, 'ilybd_withdrawals', true);
        if (is_array($w_list)) {
            foreach ($w_list as $w) {
                $w['user_id']      = $u->ID;
                $w['display_name'] = $u->display_name;
                $w['user_email']   = $u->user_email;
                $all_withdraws[]   = $w;
            }
        }
    }
    
    // Sort withdrawals by date latest first
    usort($all_withdraws, function($a, $b) {
        return strcmp($b['date'], $a['date']);
    });
    ?>
    <div class="wrap" style="background:#0d1117; padding:25px; border-radius:12px; border:1px solid #30363d; color:#fff; max-width:980px; margin-top:20px;">
        <h1 style="color:#00ff41; font-weight:800; font-size:24px; margin-bottom:20px;"><span class="dashicons dashicons-money"></span> Dynamic Earning Withdrawals Manager</h1>
        <p style="color:#8b949e; line-height:1.6; max-width:800px;">ইউজাররা তাদের ড্যাশবোর্ড ওয়ালেট থেকে ক্যাশআউট রিকোয়েস্ট জমা দিলে তা এখানে দেখতে পাবেন। আপনি Bkash বা Nagad এ পেমেন্ট সম্পন্ন করে নিচের অ্যাকশন বাটন চেপে পেমেন্ট সচল করতে পারবেন।</p>
        
        <table class="wp-list-table widefat fixed striped tables" style="background:#161b22; color:#fff; border:1px solid #30363d; border-collapse:collapse; margin-top:20px; text-align:left;">
            <thead>
                <tr style="background:#090d13; color:#fff;">
                    <th style="padding:12px; font-weight:bold; width:15%; border-bottom:1.5px solid #30363d;">ইউজার নেম</th>
                    <th style="padding:12px; font-weight:bold; width:15%; border-bottom:1.5px solid #30363d;">পদ্ধতি</th>
                    <th style="padding:12px; font-weight:bold; width:20%; border-bottom:1.5px solid #30363d;">পেমেন্ট মোবাইল নম্বর</th>
                    <th style="padding:12px; font-weight:bold; width:15%; border-bottom:1.5px solid #30363d;">টাকা</th>
                    <th style="padding:12px; font-weight:bold; width:15%; border-bottom:1.5px solid #30363d;">তারিখ</th>
                    <th style="padding:12px; font-weight:bold; width:10%; border-bottom:1.5px solid #30363d;">স্ট্যাটাস</th>
                    <th style="padding:12px; font-weight:bold; width:10%; border-bottom:1.5px solid #30363d; text-align:right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($all_withdraws)): ?>
                    <?php foreach ($all_withdraws as $w): 
                        $status_str = esc_html($w['status']);
                        $status_tag = '<span style="color:#ffb347; font-weight:bold;">Pending</span>';
                        if ($status_str === 'Completed' || $status_str === 'paid') {
                            $status_tag = '<span style="color:#00ff41; font-weight:bold;">🟢 Paid</span>';
                        } elseif ($status_str === 'rejected') {
                            $status_tag = '<span style="color:#ff3e3e; font-weight:bold;">❌ Refunded</span>';
                        }
                        ?>
                        <tr style="border-bottom:1px solid #30363d;">
                            <td style="padding:12px; font-weight:600;"><?php echo esc_html($w['display_name']); ?><br><span style="font-size:10px; color:#8b949e;"><?php echo esc_html($w['user_email']); ?></span></td>
                            <td style="padding:12px;"><?php echo esc_html($w['method']); ?></td>
                            <td style="padding:12px; font-weight:bold; color:#00d4ff; user-select:all;"><?php echo esc_html($w['number']); ?></td>
                            <td style="padding:12px; font-weight:bold; color:#ffb347;">৳<?php echo number_format($w['amount'], 2); ?></td>
                            <td style="padding:12px; color:#8b949e;"><?php echo esc_html($w['date']); ?></td>
                            <td style="padding:12px;"><?php echo $status_tag; ?></td>
                            <td style="padding:12px; text-align:right;">
                                <?php if ($status_str === 'pending'): ?>
                                    <a class="button button-primary" style="background:#238636; border:none; margin-right:5px;" href="<?php echo esc_url(admin_url('admin.php?page=ily-withdrawals&payout_action=approve&req_id='.$w['id'].'&user_id='.$w['user_id'])); ?>">পেইড</a>
                                    <a class="button" style="background:#dc3545; color:#fff; border:none;" href="<?php echo esc_url(admin_url('admin.php?page=ily-withdrawals&payout_action=reject&req_id='.$w['id'].'&user_id='.$w['user_id'])); ?>">রিজেক্ট</a>
                                <?php else: ?>
                                    <span style="color:#8b949e;">N/A</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="padding:30px; text-align:center; color:#8b949e;">কোনো উইথড্রয়াল ক্যাশআউট রিকোয়েস্ট পাওয়া যাইনি।</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
