<?php
/**
 * Admin subpage: UI/UX & Glow color customizer settings
 * Path: admin/style-settings.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Native Settings Form Saving Handler
$saved = false;
if (isset($_POST['ilybd_save_style_submit'])) {
    check_admin_referer('ilybd_style_nonce_action', 'ilybd_style_nonce_action');
    
    $selectors = array(
        'ilybd_respect_device_theme',
        'ilybd_enable_rgb_loop',
        'ilybd_adsense_safe_mode',
        'ilybd_mobile_post_layout',
        'ilybd_color_post_card',
        'ilybd_color_comment_box',
        'ilybd_color_user_profile',
        'ilybd_color_chatbot',
        'ilybd_color_qa_forum',
        'ilybd_color_story_shelf',
        'ilybd_color_wallet',
        'ilybd_color_search_index'
    );
    
    foreach ($selectors as $sel) {
        if (isset($_POST[$sel])) {
            update_option($sel, sanitize_text_field($_POST[$sel]));
        }
    }
    $saved = true;
}

// Retrieve values
$respect_device = get_option('ilybd_respect_device_theme', 'no');
$enable_rgb = get_option('ilybd_enable_rgb_loop', 'no');
$adsense_safe = get_option('ilybd_adsense_safe_mode', 'no');
$mobile_post_layout = get_option('ilybd_mobile_post_layout', 'modern_card');

$c_post = get_option('ilybd_color_post_card', '#00f0ff');
$c_comm = get_option('ilybd_color_comment_box', '#ff003c');
$c_prof = get_option('ilybd_color_user_profile', '#bd00ff');
$c_chat = get_option('ilybd_color_chatbot', '#00f0ff');
$c_foru = get_option('ilybd_color_qa_forum', '#39ff14');
$c_stor = get_option('ilybd_color_story_shelf', '#bd00ff');
$c_wall = get_option('ilybd_color_wallet', '#00f0ff');
$c_sear = get_option('ilybd_color_search_index', '#00f0ff');
?>

<div class="ilybd-cyber-wrapper">
    <h1 class="ilybd-cyber-h1">
        <span class="dashicons dashicons-art" style="font-size:32px; width:32px; height:32px; color:#00f0ff;"></span>
        UI/UX Skins & Glow Customizer
    </h1>
    <p class="ilybd-cyber-subtitle">গ্লো ও থিম কালার সেটিংস, ঘূর্ণায়মান আরজিবি এফেক্টস এবং এডসেন্স সেইফ মোড টগল।</p>

    <?php $this->ilybd_render_tabs('styles'); ?>

    <?php if ($saved): ?>
        <div class="notice notice-success is-dismissible" style="background:#13231c; color:#39ff14; border:1px solid #33a152; padding:15px; margin-bottom:25px; border-radius:6px; font-weight:bold; box-shadow:0 0 10px rgba(57, 255, 20, 0.15);">
            ⚡ ডিজাইন ও থিম গ্লো সেটিংস সফলভাবে সেভ হয়েছে!
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <?php wp_nonce_field('ilybd_style_nonce_action', 'ilybd_style_nonce_action'); ?>

        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px;">
            
            <div style="display:flex; flex-direction:column; gap:20px;">
                
                <!-- Core Layout Customization Configuration Card -->
                <div class="ilybd-cyber-panel" style="margin-bottom:0;">
                    <div class="ilybd-panel-title"><span class="dashicons dashicons-admin-generic"></span> গ্লোবাল সাইট কালারিং মেকানিক্স (Global Palette Parameters)</div>
                    <table class="ilybd-cyber-form-table">
                        <tr>
                            <th>মোবাইল/ব্রাউজার ডিফল্ট মোড সিঙ্ক</th>
                            <td>
                                <select name="ilybd_respect_device_theme" class="ilybd-cyber-select" style="min-width:280px;">
                                    <option value="no" <?php selected($respect_device, 'no'); ?>>বন্ধ (Strict Admin Preset - Strict Dark)</option>
                                    <option value="yes" <?php selected($respect_device, 'yes'); ?>>চালু (Auto Device Dark/Light)</option>
                                </select>
                                <p class="ilybd-desc-text">চালু করলে ইউজারের মোবাইলের বা ব্রাউজার লাইট/ডার্ক সেটিংসের সাথে কালার স্কিম অটোমেটিক খাপ খাইয়ে নেবে।</p>
                            </td>
                        </tr>
                        <tr>
                            <th>ঘূর্ণায়মান আরজিবি কালার লুপ</th>
                            <td>
                                <select name="ilybd_enable_rgb_loop" class="ilybd-cyber-select" style="min-width:280px;">
                                    <option value="no" <?php selected($enable_rgb, 'no'); ?>>বন্ধ (Static Preset Mood Colors)</option>
                                    <option value="yes" <?php selected($enable_rgb, 'yes'); ?>>চালু (Rotating Colors loop every 4 seconds)</option>
                                </select>
                                <p class="ilybd-desc-text">চালু থাকলে সাইটের বর্ডার এবং গ্লোর উজ্জ্বলতা প্রতি ৪ সেকেন্ড পর পর মনোরমভাবে রঙ পরিবর্তন করবে।</p>
                            </td>
                        </tr>
                        <tr>
                            <th>মোবাইল পোস্ট ইনডেক্স লেআউট</th>
                            <td>
                                <select name="ilybd_mobile_post_layout" class="ilybd-cyber-select" style="min-width:280px;">
                                    <option value="modern_card" <?php selected($mobile_post_layout, 'modern_card'); ?>>মডার্ন গ্লোয়িং কার্ড (Modern Glowing Card)</option>
                                    <option value="classic_compact_wapka" <?php selected($mobile_post_layout, 'classic_compact_wapka'); ?>>ক্ল্যাসিক কম্প্যাক্ট ওয়াপকা (Classic Compact - Left Thumb, Right Content)</option>
                                </select>
                                <p class="ilybd-desc-text">মোবাইল স্ক্রিনে পোস্টগুলো কিভাবে প্রদর্শিত হবে তা নির্ধারণ করে। ক্ল্যাসিক কম্প্যাক্ট ওয়াপকা মোডে বাম পাশে ছোট থাম্বনেইল এবং ডান পাশে টাইটেল, অতিরিক্ত বিবরণ ও ইউজার মেটা লিনিয়ারভাবে দেখায়।</p>
                            </td>
                        </tr>
                        <tr style="border-top:1px dashed rgba(148,163,184,0.15);">
                            <th style="color:#39ff14;">🛡️ এডসেন্স সেফ রিভিও মুড</th>
                            <td>
                                <select name="ilybd_adsense_safe_mode" class="ilybd-cyber-select" style="min-width:280px; border-color:#39ff14 !important;">
                                    <option value="no" <?php selected($adsense_safe, 'no'); ?>>বন্ধ (Cyber Future Pro Layout & Glowing Panels)</option>
                                    <option value="yes" <?php selected($adsense_safe, 'yes'); ?>>চালু (Ultra Safe Neutral Focus - No Aggressive Effects)</option>
                                </select>
                                <p class="ilybd-desc-text"><strong>গুগল এডসেন্স এডিটর প্যানেল রিভিউ-র সময় এটি চালু রাখার পরামর্শ দেওয়া হচ্ছে।</strong> চরম এনিমেশন বা অতিরিক্ত উজ্জ্বলতা নিরুৎসাহিত করে সাইটকে ক্ল্যাসিক রিডার মোডে লকড করবে।</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Glowing Accents Settings Card -->
                <div class="ilybd-cyber-panel" style="margin-bottom:0;">
                    <div class="ilybd-panel-title"><span class="dashicons dashicons-admin-appearance"></span> খাতভিত্তিক স্পেস কালারিং গ্লো (Modular Glowing Accents)</div>
                    <p style="font-size:12.5px; color:#94a3b8; margin: -10px 0 20px 0;">নিচের সেকশনগুলোর জন্য আপনার পছন্দের উজ্জ্বল নিয়ন কালার নির্বাচন করুন:</p>
                    
                    <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:20px; background:rgba(0,0,0,0.2); padding:20px; border-radius:8px; border:1px solid rgba(148,163,184,0.1);">
                        <div>
                            <label style="color:#e2e8f0; font-size:12.5px; font-weight:600; display:block; margin-bottom:6px;">পোস্ট কার্ড গ্লো কালার:</label>
                            <input type="color" name="ilybd_color_post_card" id="color-post" value="<?php echo esc_attr($c_post); ?>" style="background:none; border:none; height:34px; width:100%; cursor:pointer;" />
                        </div>
                        <div>
                            <label style="color:#e2e8f0; font-size:12.5px; font-weight:600; display:block; margin-bottom:6px;">কমেন্ট বক্স গ্লো কালার:</label>
                            <input type="color" name="ilybd_color_comment_box" id="color-comm" value="<?php echo esc_attr($c_comm); ?>" style="background:none; border:none; height:34px; width:100%; cursor:pointer;" />
                        </div>
                        <div>
                            <label style="color:#e2e8f0; font-size:12.5px; font-weight:600; display:block; margin-bottom:6px;">প্রোফাইল কার্ড গ্লো কালার:</label>
                            <input type="color" name="ilybd_color_user_profile" id="color-prof" value="<?php echo esc_attr($c_prof); ?>" style="background:none; border:none; height:34px; width:100%; cursor:pointer;" />
                        </div>
                        <div>
                            <label style="color:#e2e8f0; font-size:12.5px; font-weight:600; display:block; margin-bottom:6px;">মায়া চ্যাটবট গ্লো কালার:</label>
                            <input type="color" name="ilybd_color_chatbot" id="color-chat" value="<?php echo esc_attr($c_chat); ?>" style="background:none; border:none; height:34px; width:100%; cursor:pointer;" />
                        </div>
                        <div>
                            <label style="color:#e2e8f0; font-size:12.5px; font-weight:600; display:block; margin-bottom:6px;">প্রশ্ন ফোরাম গ্লো কালার:</label>
                            <input type="color" name="ilybd_color_qa_forum" id="color-foru" value="<?php echo esc_attr($c_foru); ?>" style="background:none; border:none; height:34px; width:100%; cursor:pointer;" />
                        </div>
                        <div>
                            <label style="color:#e2e8f0; font-size:12.5px; font-weight:600; display:block; margin-bottom:6px;">স্টোরি শেলফ গ্লো কালার:</label>
                            <input type="color" name="ilybd_color_story_shelf" id="color-stor" value="<?php echo esc_attr($c_stor); ?>" style="background:none; border:none; height:34px; width:100%; cursor:pointer;" />
                        </div>
                        <div>
                            <label style="color:#e2e8f0; font-size:12.5px; font-weight:600; display:block; margin-bottom:6px;">ওয়ালেট ফ্রেম গ্লো কালার:</label>
                            <input type="color" name="ilybd_color_wallet" id="color-wall" value="<?php echo esc_attr($c_wall); ?>" style="background:none; border:none; height:34px; width:100%; cursor:pointer;" />
                        </div>
                        <div>
                            <label style="color:#e2e8f0; font-size:12.5px; font-weight:600; display:block; margin-bottom:6px;">সার্চ ইনডেক্স গ্লো কালার:</label>
                            <input type="color" name="ilybd_color_search_index" id="color-sear" value="<?php echo esc_attr($c_sear); ?>" style="background:none; border:none; height:34px; width:100%; cursor:pointer;" />
                        </div>
                    </div>
                </div>

                <div style="margin-top:10px;">
                    <button type="submit" name="ilybd_save_style_submit" class="ilybd-cyber-btn">
                        <span class="dashicons dashicons-saved" style="font-size:16px; width:16px; height:16px; margin:0 5px 0 0; color:#070b13;"></span>
                        Save Custom Skins
                    </button>
                </div>
            </div>

            <!-- Dynamic Demo Card preview -->
            <div>
                <div class="ilybd-cyber-panel" style="border-color:#00f0ff; position:sticky; top:20px; display:flex; flex-direction:column; align-items:center; text-align:center;">
                    <div class="ilybd-panel-title" style="width:100%;"><span class="dashicons dashicons-visibility"></span> Live Glow Preview</div>
                    <p style="font-size:12px; color:#94a3b8; margin-bottom:20px;">আপনার সেট করা পোস্ট-কালার ও গ্লোর লাইভ ডেমো ফিডব্যাক দেখুন:</p>
                    
                    <!-- Simulating Glowing Card -->
                    <div id="glow-preview-box" style="background:#0c111c; border: 1px solid #00f0ff; border-radius:10px; padding:20px; width:100%; max-width:260px; text-align:left; box-shadow: 0 0 15px rgba(0, 240, 255, 0.25); transition:all 0.3s ease;">
                        <span style="font-family:'JetBrains Mono', monospace; font-size:10px; color:#00f0ff; background:rgba(0, 240, 255, 0.1); padding:3px 7px; border-radius:10px; font-weight:bold;" id="preview-badge-cat">TECH EXCLUSIVE</span>
                        <h4 style="font-size:15px; font-weight:700; color:#fff; margin:10px 0 8px 0; font-family:'Space Grotesk', sans-serif;">Next-Gen Client Security Shield Config 2040</h4>
                        <p style="font-size:11.5px; color:#94a3b8; line-height:1.5; margin:0;">আইবিডি সিস্টেমে ইউএক্স সিলেকশন স্কিন পরিবর্তন করা হয়েছে এবং এটি লাইভ সিঙ্ক ডেমো শো করছে।</p>
                        
                        <div style="border-top:1px solid rgba(148,163,184,0.1); margin-top:12px; padding-top:8px; display:flex; justify-content:space-between; align-items:center;">
                            <span id="preview-comment-glow" style="font-size:11px; font-weight:bold; color:#ff003c;">💬 ৫ কমেন্ট</span>
                            <span style="font-size:11px; color:#64748b; font-family:'JetBrains Mono', monospace;">২ মিনিট আগে</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    function refreshPreviewGlow() {
        var postColor = $('#color-post').val();
        var commColor = $('#color-comm').val();

        // Apply dynamically
        var box = $('#glow-preview-box');
        box.css('border-color', postColor);
        box.css('box-shadow', '0 0 18px ' + hexToRgbA(postColor, 0.3));
        $('#preview-badge-cat').css({'color': postColor, 'background': hexToRgbA(postColor, 0.08)});
        $('#preview-comment-glow').css('color', commColor);
    }

    // Helper for Alpha hex conversion
    function hexToRgbA(hex, alpha){
        var c;
        if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
            c= hex.substring(1).split('');
            if(c.length== 3){
                c= [c[0], c[0], c[1], c[1], c[2], c[2]];
            }
            c= '0x' + c.join('');
            return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+alpha+')';
        }
        return 'rgba(0, 240, 255, ' + alpha + ')'; // fallback
    }

    // Bind inputs to dynamic preview change
    $('input[type=color]').on('input change', function() {
        refreshPreviewGlow();
    });

    refreshPreviewGlow();
});
</script>
