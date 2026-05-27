<?php
/**
 * ILYBD Neon v1 Pro - Master Control Engine v3
 * Production Grade CMS Control Panel
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   ADMIN MENU
========================================================= */
add_action('admin_menu', function() {

    add_menu_page(
        'Neon Control Center',
        'Neon Master',
        'manage_options',
        'ilybd-settings',
        'ilybd_settings_page',
        'dashicons-shield-alt',
        2
    );
});

/* =========================================================
   SETTINGS PAGE UI
========================================================= */
function ilybd_settings_page() {
    ?>
    <div class="wrap" style="background:#0b0f14;color:#c9d1d9;padding:25px;border-radius:14px;border:1px solid #30363d;font-family:system-ui;">

        <h1 style="color:#00ff41;text-align:center;letter-spacing:2px;">
            🧠 ILYBD MASTER CONTROL ENGINE v3
        </h1>

        <p style="text-align:center;color:#8b949e;">
            Full CMS Brain System – Titles, Posts, Ads, UX & Behavior Control
        </p>

        <?php ilybd_render_titles_panel(); ?>
        <?php ilybd_render_content_panel(); ?>
        <?php ilybd_render_ads_panel(); ?>

    </div>
    <?php
}

/* =========================================================
   PANEL 1: TITLES + UI ENGINE
========================================================= */
function ilybd_render_titles_panel() {
?>
<div style="margin-top:20px;background:#161b22;padding:20px;border-radius:12px;border:1px solid #30363d;">
    <h2 style="color:#00ff41;">🎨 UI TEXT ENGINE</h2>

    <form method="post" action="options.php">
        <?php settings_fields('ilybd_titles_group'); ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">

            <?php
            $fields = [
                'ilybd_trending_name' => 'Trending',
                'ilybd_featured_name' => 'Featured',
                'ilybd_latest_name' => 'Latest',
                'ilybd_community_name' => 'Community',
                'ilybd_cat_name' => 'Categories',
                'ilybd_title_px' => 'Title Size (px)'
            ];

            foreach($fields as $key=>$label){ ?>
                <div>
                    <label style="color:#fff;"><?php echo $label; ?></label>
                    <input type="text" name="<?php echo $key; ?>"
                        value="<?php echo esc_attr(get_option($key)); ?>"
                        style="width:100%;background:#0b0f14;color:#00ff41;border:1px solid #30363d;padding:8px;">
                </div>
            <?php } ?>

        </div>

        <?php submit_button('Save UI Settings'); ?>
    </form>
</div>
<?php
}

/* =========================================================
   PANEL 2: CONTENT ENGINE
========================================================= */
function ilybd_render_content_panel() {
?>
<div style="margin-top:20px;background:#161b22;padding:20px;border-radius:12px;border:1px solid #30363d;">
    <h2 style="color:#00ff41;">📊 CONTENT ENGINE</h2>

    <form method="post" action="options.php">
        <?php settings_fields('ilybd_content_group'); ?>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">

            <div>
                <label>Latest Posts</label>
                <input type="number" name="ilybd_latest_count"
                    value="<?php echo esc_attr(get_option('ilybd_latest_count',10)); ?>"
                    style="width:100%;">
            </div>

            <div>
                <label>Trending Posts</label>
                <input type="number" name="ilybd_trending_count"
                    value="<?php echo esc_attr(get_option('ilybd_trending_count',5)); ?>"
                    style="width:100%;">
            </div>

            <div>
                <label>Featured Posts</label>
                <input type="number" name="ilybd_featured_count"
                    value="<?php echo esc_attr(get_option('ilybd_featured_count',5)); ?>"
                    style="width:100%;">
            </div>

        </div>

        <div style="margin-top:10px;">
            <label>Featured IDs</label>
            <input type="text" name="ilybd_featured_ids"
                value="<?php echo esc_attr(get_option('ilybd_featured_ids')); ?>"
                style="width:100%;background:#0b0f14;color:#00ff41;border:1px solid #30363d;padding:8px;">
        </div>

        <?php submit_button('Save Content Engine'); ?>
    </form>
</div>
<?php
}

/* =========================================================
   PANEL 3: ADS + SYSTEM CONTROL
========================================================= */
function ilybd_render_ads_panel() {
?>
<div style="margin-top:20px;background:#161b22;padding:26px;border-radius:14px;border:1.5px solid #ff3e3e;box-shadow: 0 0 15px rgba(255, 62, 62, 0.05);">
    <h2 style="color:#ff3e3e; margin-top:0; font-size:20px; font-weight:800; display:flex; align-items:center; gap:8px;">
        <span>💰</span> MONETIZATION CORE & SMART AD HUB
    </h2>
    
    <div style="background:rgba(0, 255, 65, 0.05); border:1.5px dashed #00ff41; padding:20px; border-radius:12px; margin:18px 0; font-family:system-ui; line-height:1.6;">
        <h4 style="color:#00ff41; margin:0 0 8px 0; font-size:15px; font-weight:bold;"><i class="dashicons dashicons-money-alt" style="color:#00ff41; vertical-align:middle; margin-right:5px;"></i> আরও উন্নত মাল্টি-স্লট বিজ্ঞাপন সমাধান (Dynamic AdSense Slots Live!)</h4>
        <p style="color:#c9d1d9; font-size:12.5px; margin:0 0 14px 0;">
            আমরা ৪-জিপিটির তৈরি করা ত্রুটিপূর্ণ ও ফাঁকা স্থান তৈরি করা বিজ্ঞাপনের কোড পরিবর্তন করে একটি সম্পূর্ণ নতুন ড্যাশবোর্ড তৈরি করেছি। এখন থেকে আপনি হেডার, ফুটার, কন্টেন্ট টপ, কন্টেন্ট মিডল, কন্টেন্ট বটম এবং সাইডবার- সবগুলোর বিজ্ঞাপন আলাদাভাবে নিয়ন্ত্রণ করতে পারবেন। <strong>কোনো ফাঁকা ঘর বা বিজ্ঞাপন ছাড়া খালি স্পেস তৈরি হবে না!</strong>
        </p>
        <a href="<?php echo admin_url('admin.php?page=ilybd-ads-hub'); ?>" class="button button-primary" style="background:#00ff41 !important; color:#000 !important; font-weight:900 !important; border:none !important; padding:4px 18px !important; height:auto !important; border-radius:6px !important; text-shadow:none !important; text-transform:uppercase; letter-spacing:0.5px; display:inline-block; font-size:12px; text-decoration:none; box-shadow:0 0 10px rgba(0,255,65,0.2);">
            👉 প্রবেশ করুন অল-ইন-ওয়ান বিজ্ঞাপন ড্যাশবোর্ডে
        </a>
    </div>

    <form method="post" action="options.php">
        <?php settings_fields('ilybd_ads_group'); ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">

            <div>
                <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:5px;">Global Ads Status</label>
                <select name="ilybd_ad_status" style="width:100%; background:#0b0f14; color:#00ff41; border:1px solid #30363d; padding:8px; border-radius:6px; font-weight:bold; height:auto;">
                    <option value="active" <?php selected(get_option('ilybd_ad_status'),'active'); ?>>Active (বিজ্ঞাপন সচল)</option>
                    <option value="inactive" <?php selected(get_option('ilybd_ad_status'),'inactive'); ?>>Inactive (সকল বিজ্ঞাপন বন্ধ)</option>
                </select>
            </div>

            <div>
                <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:5px;">Hacker/Admin Preview mode</label>
                <select name="ilybd_hacker_mode" style="width:100%; background:#0b0f14; color:#00e5ff; border:1px solid #30363d; padding:8px; border-radius:6px; font-weight:bold; height:auto;">
                    <option value="yes" <?php selected(get_option('ilybd_hacker_mode'),'yes'); ?>>ON (প্রিভিউ বর্ডার দেখান)</option>
                    <option value="no" <?php selected(get_option('ilybd_hacker_mode'),'no'); ?>>OFF (ভিজিটর মোড)</option>
                </select>
            </div>

        </div>

        <p style="color:#8b949e; font-size:11.5px; margin-top:15px; border-top:1px solid #2d3139; padding-top:10px;">
            ⚠️ কাস্টম অ্যাড স্লট ও শর্টকোড কনফিগার করতে বাম পাশের <strong>"Multi Ad & AdSense Panel"</strong> সাবমেনুর বোতামটিতে চাপ দিন।
        </p>
    </form>
</div>
<?php
}

/* =========================================================
   REGISTER SETTINGS
========================================================= */
add_action('admin_init', function() {

    /* UI */
    register_setting('ilybd_titles_group', 'ilybd_trending_name');
    register_setting('ilybd_titles_group', 'ilybd_featured_name');
    register_setting('ilybd_titles_group', 'ilybd_latest_name');
    register_setting('ilybd_titles_group', 'ilybd_community_name');
    register_setting('ilybd_titles_group', 'ilybd_cat_name');
    register_setting('ilybd_titles_group', 'ilybd_title_px');

    /* CONTENT */
    register_setting('ilybd_content_group', 'ilybd_latest_count');
    register_setting('ilybd_content_group', 'ilybd_trending_count');
    register_setting('ilybd_content_group', 'ilybd_featured_count');
    register_setting('ilybd_content_group', 'ilybd_featured_ids');

    /* ADS */
    register_setting('ilybd_ads_group', 'ilybd_ad_status');
    register_setting('ilybd_ads_group', 'ilybd_hacker_mode');
    register_setting('ilybd_ads_group', 'ilybd_ad_header');
    register_setting('ilybd_ads_group', 'ilybd_ad_body');
});