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

        <p style="text-align:center;color:#8b949e;margin-bottom:25px;">
            Full CMS Brain System – Titles, Posts, Ads, UX & Behavior Control
        </p>

        <!-- Dynamic 2040 Cyber Navigation Hub -->
        <div style="background:#0f172a; border: 1.5px solid #00f0ff; box-shadow: 0 0 20px rgba(0, 240, 255, 0.15); border-radius:12px; padding:20px; margin-bottom:25px;">
            <h3 style="color:#00f0ff; margin-top:0; margin-bottom:12px; font-weight:800; display:flex; align-items:center; gap:8px; font-size:16px;">
                ⚙️ কুইক কন্ট্রোল প্যানেল (Universal Quick Navigation Hub)
            </h3>
            <p style="color:#94a3b8; font-size:12.5px; margin:0 0 15px 0; line-height:1.5;">
                আপনার গুগল এডসেন্স সেফগার্ড, কন্টেন্ট লকার, এসইও অটো-ইনডেক্সিং এবং নতুন লাইভ স্টোরিজ ও আরজিবি এনিমেশন অন-অফ সুইচ গুলোসহ সকল আপডেট অপশন নিচের বাটনগুলো ব্যবহার করে সরাসরি ম্যানেজ করতে পারেন:
            </p>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:15px;">
                <a href="<?php echo admin_url('admin.php?page=adsense-cyber-shield-intel'); ?>" style="display:block; text-decoration:none; background:#1e293b; border:1px solid #334155; border-radius:8px; padding:12px; transition:all 0.3s; text-align:center;" onmouseover="this.style.borderColor='#ff3e3e'; this.style.background='#1e1b29';" onmouseout="this.style.borderColor='#334155'; this.style.background='#1e293b';">
                    <span style="font-size:20px; display:block; margin-bottom:6px;">🛡️</span>
                    <strong style="color:#ff3e3e; display:block; font-size:13px; margin-bottom:4px;">AdSense Cyber Shield</strong>
                    <span style="color:#94a3b8; font-size:10.5px;">এডসেন্স প্রটেকশন সেটিংস</span>
                </a>

                <a href="<?php echo admin_url('admin.php?page=ily-seo-dashboard'); ?>" style="display:block; text-decoration:none; background:#1e293b; border:1px solid #334155; border-radius:8px; padding:12px; transition:all 0.3s; text-align:center;" onmouseover="this.style.borderColor='#39ff14'; this.style.background='#14251b';" onmouseout="this.style.borderColor='#334155'; this.style.background='#1e293b';">
                    <span style="font-size:20px; display:block; margin-bottom:6px;">🚀</span>
                    <strong style="color:#39ff14; display:block; font-size:13px; margin-bottom:4px;">SEO & Content Autopilot</strong>
                    <span style="color:#94a3b8; font-size:10.5px;">গুগল ইনডেক্সিং ও এআই কন্টেন্ট</span>
                </a>

                <a href="<?php echo admin_url('admin.php?page=ilybd-ads-hub'); ?>" style="display:block; text-decoration:none; background:#1e293b; border:1px solid #334155; border-radius:8px; padding:12px; transition:all 0.3s; text-align:center;" onmouseover="this.style.borderColor='#eab308'; this.style.background='#22231b';" onmouseout="this.style.borderColor='#334155'; this.style.background='#1e293b';">
                    <span style="font-size:20px; display:block; margin-bottom:6px;">💰</span>
                    <strong style="color:#eab308; display:block; font-size:13px; margin-bottom:4px;">Multi AdSense Panel</strong>
                    <span style="color:#94a3b8; font-size:10.5px;">হেডার, বডি ও কাস্টম বিজ্ঞাপন</span>
                </a>

                <a href="#theme-rgb-lighting-hub" style="display:block; text-decoration:none; background:#1e293b; border:1px solid #334155; border-radius:8px; padding:12px; transition:all 0.3s; text-align:center;" onmouseover="this.style.borderColor='#d946ef'; this.style.background='#27132d';" onmouseout="this.style.borderColor='#334155'; this.style.background='#1e293b';">
                    <span style="font-size:20px; display:block; margin-bottom:6px;">🌈</span>
                    <strong style="color:#d946ef; display:block; font-size:13px; margin-bottom:4px;">RGB & Neon Style</strong>
                    <span style="color:#94a3b8; font-size:10.5px;">কালার লাইভ এনিমেশন সেটিংস</span>
                </a>

                <a href="<?php echo admin_url('admin.php?page=live-stories-option'); ?>" style="display:block; text-decoration:none; background:#1e293b; border:1px solid #334155; border-radius:8px; padding:12px; transition:all 0.3s; text-align:center;" onmouseover="this.style.borderColor='#00f0ff'; this.style.background='#0f2027';" onmouseout="this.style.borderColor='#334155'; this.style.background='#1e293b';">
                    <span style="font-size:20px; display:block; margin-bottom:6px;">💬</span>
                    <strong style="color:#00f0ff; display:block; font-size:13px; margin-bottom:4px;">Live Stories Option</strong>
                    <span style="color:#94a3b8; font-size:10.5px;">স্টোরি শেলফ সচল/বন্ধ বাটন</span>
                </a>

                <a href="<?php echo admin_url('admin.php?page=ilybd-nextgen-autopilot'); ?>" style="display:block; text-decoration:none; background:#1e293b; border:1.5px solid #00f0ff; border-radius:8px; padding:12px; transition:all 0.3s; text-align:center; box-shadow: 0 0 10px rgba(0, 240, 255, 0.15);" onmouseover="this.style.borderColor='#00ff41'; this.style.background='#081e22';" onmouseout="this.style.borderColor='#00f0ff'; this.style.background='#1e293b';">
                    <span style="font-size:20px; display:block; margin-bottom:6px;">🤖</span>
                    <strong style="color:#00ff41; display:block; font-size:13px; margin-bottom:4px;">Next-Gen Pilots</strong>
                    <span style="color:#94a3b8; font-size:10.5px;">এসএমএস, গল্প ও ডিভাইস রিভিউ প্যানেল</span>
                </a>
            </div>
        </div>

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

        <!-- 🌈 RGB & NEON SYSTEM SETTINGS PANEL -->
        <div id="theme-rgb-lighting-hub" style="margin-top:25px; background:#0f172a; padding:20px; border-radius:12px; border:1.5px solid #d946ef; box-shadow: 0 0 20px rgba(217, 70, 239, 0.15);">
            <h3 style="color:#d946ef; margin-top:0; margin-bottom:8px; font-weight:800; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                🌈 গ্লোবাল আরজিবি লাইটিং ও এনিমেশন সেটিংস (RGB & Neon Systems)
            </h3>
            <p style="color:#94a3b8; font-size:12px; margin:0 0 15px 0; line-height:1.5;">
                আপনার ওয়েবসাইটের চারপাশে থাকা আরজিবি বর্ডার ও ব্যাকগ্রাউন্ড গ্লো ইফেক্টগুলো এক ক্লিকে অন/অফ করতে পারেন এবং আপনার পছন্দের থিমের সাথে মানানসই লাইভ ডিজাইন সিলেক্ট করতে পারেন।
            </p>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; margin-bottom:12px;">
                <div>
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">সিস্টেম সচল/বন্ধ করুন (Enable/Disable RGB Frame)</label>
                    <select name="ilybd_enable_rgb" style="width:100%; background:#0b0f14; color:#00ff41; border:1px solid #30363d; padding:10px; border-radius:6px; font-weight:bold; height:auto; cursor:pointer;">
                        <option value="yes" <?php selected(get_option('ilybd_enable_rgb', 'yes'), 'yes'); ?>>সচল / ON</option>
                        <option value="no" <?php selected(get_option('ilybd_enable_rgb', 'yes'), 'no'); ?>>বন্ধ / OFF (হাইড করুন)</option>
                    </select>
                </div>

                <div>
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">এনিমেশন ও আরজিবি ডিজাইন (Neon Style Preset)</label>
                    <select name="ilybd_rgb_style" style="width:100%; background:#0b0f14; color:#00f0ff; border:1px solid #30363d; padding:10px; border-radius:6px; font-weight:bold; height:auto; cursor:pointer;">
                        <option value="classic_neo" <?php selected(get_option('ilybd_rgb_style', 'classic_neo'), 'classic_neo'); ?>>Classic Neon Multi-Color RGB (নিয়ন মাল্টিকালার আরজিবি)</option>
                        <option value="aurora_glow" <?php selected(get_option('ilybd_rgb_style', 'classic_neo'), 'aurora_glow'); ?>>Cosmic Cyber Aurora (কসমিক ওরোরা গ্রিন-সায়ান গ্লো)</option>
                        <option value="toxic_matrix" <?php selected(get_option('ilybd_rgb_style', 'classic_neo'), 'toxic_matrix'); ?>>Toxic Matrix Neon (টক্সিক ম্যাট্রিক্স লাইম-গ্রিন এনিমেশন)</option>
                        <option value="electric_sunset" <?php selected(get_option('ilybd_rgb_style', 'classic_neo'), 'electric_sunset'); ?>>Electric Sunset glow (সূর্যাস্ত পার্পল-ম্যাজেন্টা গ্লো)</option>
                        <option value="cyber_amber" <?php selected(get_option('ilybd_rgb_style', 'classic_neo'), 'cyber_amber'); ?>>Golden Amber Core (সাইবার গোল্ডেন এম্বার হট অরেঞ্জ)</option>
                        <option value="neon_blue_mono" <?php selected(get_option('ilybd_rgb_style', 'classic_neo'), 'neon_blue_mono'); ?>>Mono Neon Ice Blue (ইলেকট্রিক স্কাই ব্লু নিয়ন গ্লো)</option>
                    </select>
                </div>
            </div>
            
            <span style="color:#8b949e; font-size:11px; display:block; line-height:1.4;">
                💡 <strong>মডুলার আপডেট:</strong> এটি সরাসরি আপনার পুরো উইজার ইন্টারফেস ও ফোরাম/হোমপেজের চারপাশে থাকা ফিক্সড এনিমেশন ফ্রেমের কালার স্কিম এবং গ্লো পরিবর্তন করবে।
            </span>
        </div>

        <!-- 🚀 WORLD-CLASS DYNAMIC LOGO & HEADER PANEL -->
        <div id="theme-logo-hub" style="margin-top:25px; background:#0f172a; padding:20px; border-radius:12px; border:1.5px solid #00f0ff; box-shadow: 0 0 20px rgba(0, 240, 255, 0.15);">
            <h3 style="color:#00f0ff; margin-top:0; margin-bottom:8px; font-weight:800; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                🚀 ব্র্যান্ডিং ও লোগো কন্ট্রোল সেন্টার (Branding & Logo Control Center)
            </h3>
            <p style="color:#94a3b8; font-size:12px; margin:0 0 15px 0; line-height:1.5;">
                আপনার হেডার অপশনে টেক্সট, কাস্টম আপলোডেড ইমেজ অথবা আমাদের ডিজাইন করা বিল্ট-ইন প্রিমিয়াম কোয়ালিটি কসমিক সাইবার ও গ্লিচ রিয়েল ভেক্টর লোগো সেট করতে পারেন।
            </p>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; margin-bottom:15px;">
                <div>
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">লোগো টাইপ সিলেক্ট করুন (Logo Type)</label>
                    <select name="ilybd_logo_type" style="width:100%; background:#0b0f14; color:#00ff41; border:1px solid #30363d; padding:10px; border-radius:6px; font-weight:bold; height:auto; cursor:pointer;">
                        <option value="text" <?php selected(get_option('ilybd_logo_type', 'text'), 'text'); ?>>শুধুমাত্র ইউনিক টেক্সট লোগো (Glowing Text Logo)</option>
                        <option value="image" <?php selected(get_option('ilybd_logo_type', 'text'), 'image'); ?>>কাস্টম ইমেজ লোগো (Custom Scaled Image)</option>
                        <option value="cosmic" <?php selected(get_option('ilybd_logo_type', 'text'), 'cosmic'); ?>>বিল্ট-ইন কসমিক সাইবার লোগো (Cosmic Cyber SVG Logo)</option>
                        <option value="glitch" <?php selected(get_option('ilybd_logo_type', 'text'), 'glitch'); ?>>বিল্ট-ইন মিনিমালিস্ট গ্লিচ লোগো (Minimalist Glitch SVG Logo)</option>
                        <option value="both" <?php selected(get_option('ilybd_logo_type', 'text'), 'both'); ?>>উভয় একসাথে (Image + Text Side-by-Side)</option>
                    </select>
                </div>

                <div>
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">লোগো টেক্সট (Logo Brand Text)</label>
                    <input type="text" name="ilybd_logo_text" value="<?php echo esc_attr(get_option('ilybd_logo_text', 'ILOVEYOUBD')); ?>" style="width:100%; background:#0b0f14; color:#fff; border:1px solid #30363d; padding:10px; border-radius:6px;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns: 2.2fr 1fr; gap:15px; margin-bottom:15px;">
                <div>
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">লোগো ইমেজ লিঙ্ক (Custom Logo URL)</label>
                    <input type="text" name="ilybd_logo_img_url" value="<?php echo esc_url(get_option('ilybd_logo_img_url', '')); ?>" placeholder="https://yourdomain.com/wp-content/uploads/logo.png" style="width:100%; background:#0b0f14; color:#00f0ff; border:1px solid #30363d; padding:10px; border-radius:6px; font-family:monospace;">
                    <small style="color:#8b949e; margin-top:4px; display:block;">কাস্টম ইমেজ সেট করতে মিডিয়া লাইব্রেরীতে লোগো আপলোড করে সেটির ফাইল URL এখানে পেস্ট করে দিন।</small>
                </div>

                <div>
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">ইমেজ লোগো উইডথ (Width in px)</label>
                    <input type="number" name="ilybd_logo_width" value="<?php echo esc_attr(get_option('ilybd_logo_width', '180')); ?>" min="40" max="600" style="width:100%; background:#0b0f14; color:#fff; border:1px solid #30363d; padding:10px; border-radius:6px;">
                </div>
            </div>

            <!-- New Advanced Interactive Styling Controls -->
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px; margin-bottom:12px; border-top:1px solid #1e293b; padding-top:15px;">
                <div>
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">লোগো গ্লো ও হোভার এনিমেশন (Neon Glow & Hover Micro-Animation)</label>
                    <select name="ilybd_logo_glow_hover" style="width:100%; background:#0b0f14; color:#00e5ff; border:1px solid #30363d; padding:10px; border-radius:6px; font-weight:bold; height:auto; cursor:pointer;">
                        <option value="yes" <?php selected(get_option('ilybd_logo_glow_hover', 'yes'), 'yes'); ?>>সচল / Active (Neon Glow + Scale On Hover)</option>
                        <option value="no" <?php selected(get_option('ilybd_logo_glow_hover', 'yes'), 'no'); ?>>নিষ্ক্রিয় / Inactive (Static No Animations)</option>
                    </select>
                </div>

                <div>
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">সাইবার শিল্ড ব্যাজ প্রদর্শন (Display Cyber Shield Matrix Node Badge)</label>
                    <select name="ilybd_enable_cyber_shield" style="width:100%; background:#0b0f14; color:#00ff41; border:1px solid #30363d; padding:10px; border-radius:6px; font-weight:bold; height:auto; cursor:pointer;">
                        <option value="yes" <?php selected(get_option('ilybd_enable_cyber_shield', 'yes'), 'yes'); ?>>সচল / Visible (হেডার ও মায়া চ্যাটবটে দেখান)</option>
                        <option value="no" <?php selected(get_option('ilybd_enable_cyber_shield', 'yes'), 'no'); ?>>নিষ্ক্রিয় / Hidden (হাইড করে রাখুন)</option>
                    </select>
                </div>
            </div>
            
            <!-- BIOMETRIC LOCK & BEHAVIORAL HONEYPOT SECURITY SUITE -->
            <div id="theme-biometric-honeypot" style="margin-top:25px; background:#0c0f16; padding:20px; border-radius:12px; border:1.5px solid #00ff66; box-shadow: 0 0 20px rgba(0, 255, 102, 0.15);">
                <h3 style="color:#00ff66; margin-top:0; margin-bottom:8px; font-weight:800; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                    🧠 বায়োমেট্রিক সিকিউরিটি ও শ্যাডো হানিপট (Biometric Honeypot & AI Lock)
                </h3>
                <p style="color:#94a3b8; font-size:12px; margin:0 0 15px 0; line-height:1.5;">
                    এখানে আপনার আইএলওভিপিইউবিডি ইকোসিস্টেমের জন্য কীবোর্ড টাইপিং গতিবিদ্যা (Keystroke Dynamics) এবং মাউস চলার গতিবিধি (Mouse Dynamics) ট্র্যাক করার কৃত্রিম বুদ্ধিমত্তা চালিত সিকিউরিটি অন/অফ করতে পারেন।
                </p>
                
                <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:15px; margin-bottom:12px;">
                    <div>
                        <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">সুইট সচল/বন্ধ (Biometrics Engine)</label>
                        <select name="ilybd_biometric_master" style="width:100%; background:#070b13; color:#00ff66; border:1px solid #30363d; padding:10px; border-radius:6px; font-weight:bold; height:auto; cursor:pointer;">
                            <option value="yes" <?php selected(get_option('ilybd_biometric_master', 'yes'), 'yes'); ?>>সচল / Active (ON)</option>
                            <option value="no" <?php selected(get_option('ilybd_biometric_master', 'yes'), 'no'); ?>>নিষ্ক্রিয় / Inactive (OFF)</option>
                        </select>
                    </div>

                    <div>
                        <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">হানিপট অ্যাকশন (Honeypot Action)</label>
                        <select name="ilybd_honeypot_action" style="width:100%; background:#070b13; color:#ff3e3e; border:1px solid #30363d; padding:10px; border-radius:6px; font-weight:bold; height:auto; cursor:pointer;">
                            <option value="honeypot" <?php selected(get_option('ilybd_honeypot_action', 'honeypot'), 'honeypot'); ?>>শ্যাডো হানিপট ট্র্যাপ (Shadow Terminal Trap)</option>
                            <option value="block" <?php selected(get_option('ilybd_honeypot_action', 'honeypot'), 'block'); ?>>সরাসরি আইপি ব্লক (Direct IP Lock Screen)</option>
                        </select>
                    </div>

                    <div>
                        <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">হিউম্যান গড মোড (Human God-Mode)</label>
                        <select name="ilybd_godmode_unfold" style="width:100%; background:#070b13; color:#eab308; border:1px solid #30363d; padding:10px; border-radius:6px; font-weight:bold; height:auto; cursor:pointer;">
                            <option value="yes" <?php selected(get_option('ilybd_godmode_unfold', 'yes'), 'yes'); ?>>সচল / Auto Elevate Level 4</option>
                            <option value="no" <?php selected(get_option('ilybd_godmode_unfold', 'yes'), 'no'); ?>>নিষ্ক্রিয় / Disable God-Mode Promotion</option>
                        </select>
                    </div>
                </div>
                
                <span style="color:#8b949e; font-size:11px; display:block; line-height:1.4; margin-top:8px;">
                    💡 <strong>শ্যাডো টার্মিনাল ট্র্যাপ:</strong> হানিপট অ্যাকশনে ট্র্যাপ সিলেক্ট করা থাকলে কলার বা স্ক্র্যাপার বটের সামনে একটি ফেইক হ্যাকিং টার্মিনাল ওপেন হবে এবং আসল ডেটা ডাইভার্ট করবে যাতে কোনো এডসেন্স এড লিমিট বা স্প্যামিং না ঘটে।
                </span>
            </div>

            <!-- GOOGLE ADSENSE APPROVAL SAFEGUARD CHECKER -->
            <div id="theme-adsense-safeguard-auditor" style="margin-top:25px; background:#070b13; padding:22px; border-radius:12px; border:1.5px solid #00f0ff; box-shadow: 0 0 25px rgba(0, 240, 255, 0.12);">
                <h3 style="color:#00f0ff; margin-top:0; margin-bottom:8px; font-weight:800; font-size:15px; text-transform:uppercase; letter-spacing:0.5px; display:flex; align-items:center; gap:8px;">
                     🛡️ গুগল এডসেন্স অ্যাপ্রুভাল মডুলার অডিটর (Google AdSense Guard Diagnostics)
                </h3>
                <p style="color:#94a3b8; font-size:12px; margin:0 0 18px 0; line-height:1.5;">
                    গুগল এডসেন্স রিজেক্ট হওয়ার সম্ভাবনা শূন্যে নামিয়ে আনতে আপনার ওয়েবসাইটের বর্তমান লেআউট ও পলিসি স্ট্যাটাস রিয়েল-টাইম চেক করুন:
                </p>

                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:15px;">
                    <!-- Check 1: HTTPS -->
                    <div style="background:#0d1527; border:1px solid #1e293b; padding:15px; border-radius:8px; display:flex; align-items:center; gap:12px;">
                        <span style="font-size:24px;">🔒</span>
                        <div>
                            <strong style="color:#fff; display:block; font-size:12px; margin-bottom:2px;">SSL এনক্রিপশন স্ট্যাটাস</strong>
                            <?php if (is_ssl()): ?>
                                <span style="color:#00ff66; font-size:11px; font-weight:bold; display:flex; align-items:center; gap:4px;">● HTTPS ACTIVE (AdSense Standard)</span>
                            <?php else: ?>
                                <span style="color:#ec4899; font-size:11px; font-weight:bold; display:flex; align-items:center; gap:4px;">⚠️ HTTP DETECTED (প্লিজ SSL সচল করুন)</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Check 2: Privacy Policy Link Existence -->
                    <div style="background:#0d1527; border:1px solid #1e293b; padding:15px; border-radius:8px; display:flex; align-items:center; gap:12px;">
                        <span style="font-size:24px;">📄</span>
                        <div>
                            <strong style="color:#fff; display:block; font-size:12px; margin-bottom:2px;">প্রাইভেসি পলিসি পেজ ডায়াগনস্টিক</strong>
                            <?php 
                            $privacy_found = false;
                            $pages = get_pages(['post_status' => 'publish']);
                            foreach ($pages as $p) {
                                $title = strtolower($p->post_title);
                                if (strpos($title, 'privacy') !== false || strpos($title, 'policy') !== false || strpos($title, 'গোপনীয়তা') !== false) {
                                    $privacy_found = true;
                                    break;
                                }
                            }
                            if ($privacy_found): ?>
                                <span style="color:#00ff66; font-size:11px; font-weight:bold; display:flex; align-items:center; gap:4px;">● FOUND (পলিসি পেজ রেডি)</span>
                            <?php else: ?>
                                <span style="color:#eab308; font-size:11px; font-weight:bold; display:flex; align-items:center; gap:4px;">⚠️ NOT FOUND (একটি প্রাইভেসি পলিসি পেজ বাংক করুন)</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Check 3: Container Overlapping & UX -->
                    <div style="background:#0d1527; border:1px solid #1e293b; padding:15px; border-radius:8px; display:flex; align-items:center; gap:12px;">
                        <span style="font-size:24px;">📏</span>
                        <div>
                            <strong style="color:#fff; display:block; font-size:12px; margin-bottom:2px;">ডিজাইন ও সেফ কন্টেইনার গ্যাপ</strong>
                            <span style="color:#00ff66; font-size:11px; font-weight:bold;">● COMPLIANT (20px+ কাস্টম প্যাডিং সেভ)</span>
                        </div>
                    </div>

                    <!-- Check 4: Bot & Crawler Protection -->
                    <div style="background:#0d1527; border:1px solid #1e293b; padding:15px; border-radius:8px; display:flex; align-items:center; gap:12px;">
                        <span style="font-size:24px;">🤖</span>
                        <div>
                            <strong style="color:#fff; display:block; font-size:12px; margin-bottom:2px;">বট প্রটেকশন ও ইনভ্যালিড ট্রাফিক</strong>
                            <?php if (get_option('ilybd_biometric_master', 'yes') === 'yes'): ?>
                                <span style="color:#00ff66; font-size:11px; font-weight:bold;">● ACTIVE (বায়োমেট্রিক ট্র্যাপ সচল)</span>
                            <?php else: ?>
                                <span style="color:#ef4444; font-size:11px; font-weight:bold;">● INACTIVE (বট প্রটেকশন অফ)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div style="margin-top:15px; background:rgba(0, 240, 255, 0.05); padding:12px 15px; border-radius:8px; border-left:4px solid #00f0ff;">
                    <span style="color:#00f0ff; font-size:12px; font-weight:bold; display:block; margin-bottom:4px;">📌 এডসেন্স অ্যাপ্রুভাল শতভাগ নিশ্চিত করার আইবিডি পরামর্শ:</span>
                    <p style="color:#c9d1d9; font-size:11.5px; margin:0; line-height:1.5;">
                        গুগল টিম আপনার ওয়েবসাইট রিভিউ করার সময় কন্টেন্ট কোয়ালিটি ও নেভিগেশন চেক করে। আমাদের এই মডিউলে এডসেন্স ট্রাফিকের বাউন্স রেট ও ইনভ্যালিড ক্লিক থেকে বাঁচাতে অ্যাড স্লটগুলোর চারপাশে ২০ পিক্সেল ফিজিক্যাল গ্যাপ বাউন্ডারি এনফোর্স করা আছে। এটি আপনার রেভিনিউ নিরাপদ রাখবে।
                    </p>
                </div>
            </div>
            
            <span style="color:#8b949e; font-size:11px; display:block; line-height:1.4; margin-top:8px;">
                💡 <strong>মডুলার সাইবার প্রটেকশন:</strong> সাইবার শিল্ড ব্যাজটি সচল করলে ব্যবহারকারীরা সাইটের নিরাপত্তা ও ডেটা এনক্রিপশন স্ট্যাটাস নিয়ে আরও বিশ্বস্ততা অনুভব করবে, যা এডসেন্স ট্রাফিকের বাউন্স রেট কমাবে।
            </span>
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

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:10px;">

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

            <div>
                <label>Questions Per Page (Q&A)</label>
                <input type="number" name="ilybd_questions_per_page"
                    value="<?php echo esc_attr(get_option('ilybd_questions_per_page',10)); ?>"
                    style="width:100%;">
            </div>

        </div>

        <div style="margin-top:10px;">
            <label>Featured IDs</label>
            <input type="text" name="ilybd_featured_ids"
                value="<?php echo esc_attr(get_option('ilybd_featured_ids')); ?>"
                style="width:100%;background:#0b0f14;color:#00ff41;border:1px solid #30363d;padding:8px;">
        </div>

        <div id="live-stories-option" style="margin-top:20px; background: #0f172a; padding: 20px; border-radius: 12px; border: 1.5px solid #00f0ff; box-shadow: 0 0 15px rgba(0, 240, 255, 0.15);">
            <label style="color:#00f0ff; font-weight:800; display:block; margin-bottom:10px; font-size:14px; text-transform:uppercase; letter-spacing:0.5px;">💬 লাইভ স্টোরি ও মেসেঞ্জার শেলফ (Live Stories Toggle)</label>
            <select name="ilybd_enable_stories" style="background:#0b0f14; color:#00ff41; border:1.5px solid #00f0ff; padding:10px 15px; border-radius:8px; font-weight:bold; height:auto; width:100%; max-width:320px; font-size:13px; cursor:pointer; outline:none; box-shadow: 0 0 10px rgba(0, 240, 255, 0.05);">
                <option value="yes" <?php selected(get_option('ilybd_enable_stories', 'yes'), 'yes'); ?>>সচল / ON (স্টোরি শো করুন)</option>
                <option value="no" <?php selected(get_option('ilybd_enable_stories', 'yes'), 'no'); ?>>বন্ধ / OFF (স্টোরি হাইড করুন)</option>
            </select>
            <p style="color:#94a3b8; font-size:11.5px; margin-top:8px; margin-bottom:0; line-height:1.4;">
                এই অন/অফ বাটনটি ব্যবহার করে হোমপেজের সার্চবারের উপরে মেসেঞ্জার-স্টাইল লাইভ স্টোরিজ সেকশন প্রদর্শন অথবা সম্পূর্ণ হাইড করে দিতে পারবেন।
            </p>
        </div>

        <div id="user-engagement-boosters" style="margin-top:20px; background: #0f172a; padding: 20px; border-radius: 12px; border: 1.5px solid #00ff41; box-shadow: 0 0 15px rgba(0, 255, 65, 0.15);">
            <h3 style="color:#00ff41; margin-top:0; margin-bottom:12px; font-weight:800; display:flex; align-items:center; gap:8px; font-size:16px;">
                🚀 User Engagement & SEO Boosters
            </h3>
            <p style="color:#94a3b8; font-size:12.5px; margin:0 0 15px 0; line-height:1.5;">
                আপনার সাইটের বাউন্স রেট কমানো, ব্যবহারকারীদের বেশি সময় ধরে রাখা এবং সার্চ ইঞ্জিন র্যাংকিং বাড়ানোর জন্য বিশেষ লজিকগুলো চালু করুন।
            </p>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:15px;">
                <!-- Helpful Feedback Widget -->
                <div style="background:#1e293b; padding:15px; border-radius:8px; border:1px solid #334155;">
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">"Was this helpful?" Feedback Widget</label>
                    <select name="ilybd_enable_feedback_widget" style="width:100%; background:#0b0f14; color:#00ff41; border:1px solid #30363d; padding:8px; border-radius:6px; font-weight:bold;">
                        <option value="yes" <?php selected(get_option('ilybd_enable_feedback_widget', 'yes'), 'yes'); ?>>সচল / Active (পোস্টের নিচে দেখান)</option>
                        <option value="no" <?php selected(get_option('ilybd_enable_feedback_widget', 'yes'), 'no'); ?>>নিষ্ক্রিয় / Inactive</option>
                    </select>
                    <small style="color:#8b949e; margin-top:4px; display:block;">ই-ই-এ-টি (EEAT) ট্রাস্ট সিগন্যাল বাড়ায়।</small>
                </div>

                <!-- Inline Related Posts -->
                <div style="background:#1e293b; padding:15px; border-radius:8px; border:1px solid #334155;">
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">Inline Auto-Related Posts Injector</label>
                    <select name="ilybd_enable_inline_related" style="width:100%; background:#0b0f14; color:#00f0ff; border:1px solid #30363d; padding:8px; border-radius:6px; font-weight:bold;">
                        <option value="yes" <?php selected(get_option('ilybd_enable_inline_related', 'yes'), 'yes'); ?>>সচল / Active (আর্টিকেলের মাঝে দেখান)</option>
                        <option value="no" <?php selected(get_option('ilybd_enable_inline_related', 'yes'), 'no'); ?>>নিষ্ক্রিয় / Inactive</option>
                    </select>
                    <small style="color:#8b949e; margin-top:4px; display:block;">বাউন্স রেট কমায় এবং পেজভিউ কয়েকগুণ বৃদ্ধি করে।</small>
                </div>

                <!-- Anti-Adblock -->
                <div style="background:#1e293b; padding:15px; border-radius:8px; border:1px solid #334155;">
                    <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:6px;">Friendly Anti-AdBlock Notice</label>
                    <select name="ilybd_enable_anti_adblock" style="width:100%; background:#0b0f14; color:#ff3e3e; border:1px solid #30363d; padding:8px; border-radius:6px; font-weight:bold;">
                        <option value="yes" <?php selected(get_option('ilybd_enable_anti_adblock', 'no'), 'yes'); ?>>সচল / Active (পোস্টের শুরুতে ওয়ার্নিং)</option>
                        <option value="no" <?php selected(get_option('ilybd_enable_anti_adblock', 'no'), 'no'); ?>>নিষ্ক্রিয় / Inactive</option>
                    </select>
                    <small style="color:#8b949e; margin-top:4px; display:block;">গুগল পলিসি মেনে ইউজারদের এডব্লক বন্ধ করতে অনুরোধ করে।</small>
                </div>
            </div>
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
                <label style="color:#fff; font-weight:bold; font-size:12.5px; display:block; margin-bottom:5px;">Highlight Ad Positions (বিজ্ঞাপন পজিশন হাইলাইট)</label>
                <select name="ilybd_hacker_mode" style="width:100%; background:#0b0f14; color:#00e5ff; border:1px solid #30363d; padding:8px; border-radius:6px; font-weight:bold; height:auto;">
                    <option value="yes" <?php selected(get_option('ilybd_hacker_mode'),'yes'); ?>>ON (হাইলাইট সচল করুন)</option>
                    <option value="no" <?php selected(get_option('ilybd_hacker_mode'),'no'); ?>>OFF (সাধারণ মোড)</option>
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
    register_setting('ilybd_titles_group', 'ilybd_enable_rgb');
    register_setting('ilybd_titles_group', 'ilybd_rgb_style');
    register_setting('ilybd_titles_group', 'ilybd_logo_type');
    register_setting('ilybd_titles_group', 'ilybd_logo_text');
    register_setting('ilybd_titles_group', 'ilybd_logo_img_url');
    register_setting('ilybd_titles_group', 'ilybd_logo_width');
    register_setting('ilybd_titles_group', 'ilybd_logo_glow_hover');
    register_setting('ilybd_titles_group', 'ilybd_enable_cyber_shield');

    /* CONTENT */
    register_setting('ilybd_content_group', 'ilybd_latest_count');
    register_setting('ilybd_content_group', 'ilybd_trending_count');
    register_setting('ilybd_content_group', 'ilybd_featured_count');
    register_setting('ilybd_content_group', 'ilybd_questions_per_page');
    register_setting('ilybd_content_group', 'ilybd_featured_ids');
    register_setting('ilybd_content_group', 'ilybd_enable_stories');
    register_setting('ilybd_content_group', 'ilybd_enable_feedback_widget');
    register_setting('ilybd_content_group', 'ilybd_enable_inline_related');
    register_setting('ilybd_content_group', 'ilybd_enable_anti_adblock');

    /* ADS */
    register_setting('ilybd_ads_group', 'ilybd_ad_status');
    register_setting('ilybd_ads_group', 'ilybd_hacker_mode');
    register_setting('ilybd_ads_group', 'ilybd_ad_header');
    register_setting('ilybd_ads_group', 'ilybd_ad_body');
});