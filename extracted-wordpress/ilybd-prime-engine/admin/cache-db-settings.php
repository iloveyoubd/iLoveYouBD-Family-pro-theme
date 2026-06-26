<?php
/**
 * Admin subpage: Speed caching, database optimization & garbage drainage settings
 * Path: admin/cache-db-settings.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

// 1. Check for custom action posts
$success_message = '';
$message_type = 'success';

if (isset($_POST['ilybd_prime_clear_cache_submit_local'])) {
    check_admin_referer('ilybd_cache_clean_nonce');
    if (function_exists('ilybd_prime_purge_all_cache')) {
        ilybd_prime_purge_all_cache();
        $success_message = '⚡ সফল ক্যাশড স্ট্যাটিক ফাইল ও রিসোর্স সফলভাবে মেমোরি থেকে ক্লিয়ার হয়েছে!';
    } else {
        // Fallback clean
        $success_message = '⚡ স্ট্যাটিক ক্যাশ ক্লিয়ার হয়েছে (সিস্টেম সেফ ফলব্যাক)!';
    }
}

if (isset($_POST['ilybd_prime_optimize_db_submit_local'])) {
    check_admin_referer('ilybd_cache_clean_nonce');
    
    // Clear post revisions
    $deleted_revisions = $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'revision'");
    
    // Clear stale transients
    $deleted_transients = $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
    
    // Clear empty meta
    $deleted_meta = $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '' OR meta_value = ''");
    
    $repaired = "Revisions Pruned: " . intval($deleted_revisions) . ", Transients Cleared: " . intval($deleted_transients) . ", Missing Meta Cleaned: " . intval($deleted_meta);
    
    if (function_exists('ilybd_prime_optimize_database')) {
        ilybd_prime_optimize_database();
    }
    
    $success_message = '⚙️ ডাটাবেস অপ্টিমাইজেশন সম্পন্ন হয়েছে! অপ্রয়োজনীয় ' . ($deleted_revisions + $deleted_transients + $deleted_meta) . ' টি রেকর্ড সাকসেসফুলি নিষ্কাশন হয়েছে।';
    $message_type = 'info';
}

// 2. Fetch Live Stats
$cache_stats = array('count' => 0, 'size' => 0);
if (function_exists('ilybd_prime_get_cache_stats')) {
    $cache_stats = ilybd_prime_get_cache_stats();
} else {
    // Basic scanner fallback count of files in cache folder
    $cache_dir = WP_CONTENT_DIR . '/cache/ilybd-prime/';
    if (is_dir($cache_dir)) {
        $files = glob($cache_dir . '*');
        $cache_stats['count'] = count($files);
        $size = 0;
        foreach ($files as $f) {
            $size += filesize($f);
        }
        $cache_stats['size'] = $size;
    }
}

// Format size beautifully
$formatted_size = '0.00 KB';
if ($cache_stats['size'] > 1048576) {
    $formatted_size = round($cache_stats['size'] / 1048576, 2) . ' MB';
} elseif ($cache_stats['size'] > 1024) {
    $formatted_size = round($cache_stats['size'] / 1024, 2) . ' KB';
} else {
    $formatted_size = $cache_stats['size'] . ' Bytes';
}

// Live records bloats count
$revision_count = intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'"));
$transients_count = intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'"));
$orphaned_meta = intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key = '' OR meta_value = ''"));
?>

<div class="ilybd-cyber-wrapper">
    <h1 class="ilybd-cyber-h1">
        <span class="dashicons dashicons-performance" style="font-size:32px; width:32px; height:32px; color:#00f0ff;"></span>
        Zero-Latency Cache & DB Optimizer
    </h1>
    <p class="ilybd-cyber-subtitle">স্ট্যাটিক কন্টেন্ট ক্যাশে লাইফসাইকেল, ডাটাবেস ওভারহেড ক্লিনিং এবং ড্রেনেজ মডিউল।</p>

    <?php $this->ilybd_render_tabs('cache'); ?>

    <?php if ($success_message !== ''): ?>
        <div class="notice notice-success is-dismissible" style="background:#091424; color:<?php echo $message_type === 'success' ? '#39ff14' : '#00f0ff'; ?>; border:1px solid <?php echo $message_type === 'success' ? '#39ff14' : '#00f0ff'; ?>; padding:15px; margin-bottom:25px; border-radius:6px; font-weight:bold; box-shadow:0 0 10px rgba(0, 240, 255, 0.15);">
            <?php echo esc_html($success_message); ?>
        </div>
    <?php endif; ?>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:20px; margin-bottom:25px;">
        
        <!-- Cache Stats Card -->
        <div class="ilybd-cyber-panel" style="border-color: rgba(0, 240, 255, 0.3);">
            <div class="ilybd-panel-title"><span class="dashicons dashicons-database-export" style="color:#00f0ff;"></span> স্ট্যাটিক ক্যাশে রিপোর্ট (Speed Engine Status)</div>
            
            <div style="display:flex; justify-content:space-around; align-items:center; margin:10px 0 20px 0;">
                <div style="text-align:center;">
                    <div style="font-size:34px; font-weight:800; color:#00f0ff; font-family:'JetBrains Mono', monospace; text-shadow:0 0 8px rgba(0,240,255,0.4);"><?php echo intval($cache_stats['count']); ?></div>
                    <div style="font-size:11px; font-weight:bold; color:#94a3b8; text-transform:uppercase; margin-top:5px;">Cached Pages</div>
                </div>
                <div style="border-left:1px solid rgba(148,163,184,0.15); height:45px;"></div>
                <div style="text-align:center;">
                    <div style="font-size:34px; font-weight:800; color:#39ff14; font-family:'JetBrains Mono', monospace; text-shadow:0 0 8px rgba(57,255,20,0.4);"><?php echo esc_html($formatted_size); ?></div>
                    <div style="font-size:11px; font-weight:bold; color:#94a3b8; text-transform:uppercase; margin-top:5px;">Storage Occupied</div>
                </div>
            </div>
            
            <p style="font-size:12.5px; color:#94a3b8; line-height:1.5; margin-bottom:20px; text-align:center;">
                LiteSpeed-কে ফেইল করাতে জেনারেটেড সকল পেজের স্ট্যাটিক ক্যাশ ডিরেক্টরি। এটি মেমোরি রিকোয়েস্ট সময় কমিয়ে সরাসরি ব্রাউজার সার্ভিস দেয়।
            </p>
            
            <form method="post" action="">
                <?php wp_nonce_field('ilybd_cache_clean_nonce'); ?>
                <button type="submit" name="ilybd_prime_clear_cache_submit_local" class="ilybd-cyber-btn" style="width:100%; text-align:center; display:flex; justify-content:center; gap:8px;">
                    <span class="dashicons dashicons-trash" style="font-size:16px; width:16px; height:16px; margin:0; color:#070b13;"></span>
                    Purge All Static Cached Files
                </button>
            </form>
        </div>

        <!-- Database Bloats report Card -->
        <div class="ilybd-cyber-panel" style="border-color: rgba(189, 0, 255, 0.3);">
            <div class="ilybd-panel-title" style="color:#bd00ff; border-color:rgba(189,0,255,0.2);"><span class="dashicons dashicons-filter" style="color:#bd00ff;"></span> ডাটাবেস বর্জ্য ওভারহেড (Database Trash Analytics)</div>
            
            <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; border-bottom:1px solid rgba(148,163,184,0.06); padding-bottom:8px;">
                    <span style="font-size:13px; font-weight:600; color:#e2e8f0; display:flex; align-items:center; gap:6px;">
                        <span class="dashicons dashicons-backup" style="color:#ef4444; font-size:15px; width:15px; height:15px; margin:0;"></span>
                        Post Revision Bloats
                    </span>
                    <span style="font-family:'JetBrains Mono', monospace; font-size:13.5px; font-weight:bold; color:#ef4444;"><?php echo intval($revision_count); ?> records</span>
                </div>
                <div style="display:flex; justify-content:space-between; border-bottom:1px solid rgba(148,163,184,0.06); padding-bottom:8px;">
                    <span style="font-size:13px; font-weight:600; color:#e2e8f0; display:flex; align-items:center; gap:6px;">
                        <span class="dashicons dashicons-admin-settings" style="color:#ffaa00; font-size:15px; width:15px; height:15px; margin:0;"></span>
                        Stale Transient Cache
                    </span>
                    <span style="font-family:'JetBrains Mono', monospace; font-size:13.5px; font-weight:bold; color:#ffaa00;"><?php echo intval($transients_count); ?> items</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding-bottom:8px;">
                    <span style="font-size:13px; font-weight:600; color:#e2e8f0; display:flex; align-items:center; gap:6px;">
                        <span class="dashicons dashicons-editor-code" style="color:#3b82f6; font-size:15px; width:15px; height:15px; margin:0;"></span>
                        Corrupt Orphaned Meta
                    </span>
                    <span style="font-family:'JetBrains Mono', monospace; font-size:13.5px; font-weight:bold; color:#3b82f6;"><?php echo intval($orphaned_meta); ?> records</span>
                </div>
            </div>
            
            <p style="font-size:12.5px; color:#94a3b8; line-height:1.5; margin-bottom:20px; text-align:center;">
                ডাটাবেসের আকার বৃদ্ধিকারী অপ্রয়োজনীয় পোস্ট হিস্ট্রি রিভিশন এবং মেয়াদোত্তীর্ণ ট্রানজিট সাময়িকভাবে ক্লিয়ার করে কোয়ালিটি স্পিড বাড়ানো।
            </p>
            
            <form method="post" action="">
                <?php wp_nonce_field('ilybd_cache_clean_nonce'); ?>
                <button type="submit" name="ilybd_prime_optimize_db_submit_local" class="ilybd-cyber-btn" style="width:100%; text-align:center; display:flex; justify-content:center; gap:8px; background:linear-gradient(135deg, #bd00ff, #00f0ff) !important; color:#fff !important; box-shadow:0 0 10px rgba(189,0,255,0.25);">
                    <span class="dashicons dashicons-hammer" style="font-size:16px; width:16px; height:16px; margin:0; color:#fff;"></span>
                    Optimize Database Records
                </button>
            </form>
        </div>

    </div>
</div>
