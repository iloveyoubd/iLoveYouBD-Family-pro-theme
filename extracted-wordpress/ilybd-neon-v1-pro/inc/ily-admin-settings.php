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
    add_menu_page(
        'ILYBD Control Center',
        'ILYBD Control',
        'manage_options',
        'ily-settings',
        'ily_options_page',
        'dashicons-shield',
        3
    );

    add_submenu_page(
        'ily-settings',
        'Earning Withdrawals Manager',
        'Payout Requests',
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
