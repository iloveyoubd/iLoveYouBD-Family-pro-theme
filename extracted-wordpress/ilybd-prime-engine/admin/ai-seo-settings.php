<?php
/**
 * Admin subpage: AI Autopilot writer, keys pool & SEO settings
 * Path: admin/ai-seo-settings.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Native Settings Form Saving Handler
$saved = false;
if (isset($_POST['ilybd_save_ai_submit'])) {
    check_admin_referer('ilybd_ai_nonce_action', 'ilybd_ai_nonce_action');

    // Save individual options
    $single_fields = array(
        'ilybd_api_keys',
        'ilybd_rev_share_percent',
        'ilybd_ad_timer',
        'ilybd_enable_autoseo_editor',
        'ilybd_target_word_guideline',
        'ilybd_autoseo_min_quality',
        'ilybd_traffic_hijacker',
        'ilybd_seo_engine_status'
    );
    foreach ($single_fields as $f) {
        if (isset($_POST[$f])) {
            update_option($f, sanitize_text_field($_POST[$f]));
        }
    }

    // Save Vault Keys (1-10)
    for($i=1; $i<=10; $i++) {
        if (isset($_POST['gemini_key_'.$i])) {
            update_option('ibd_gemini_key_'.$i, sanitize_text_field($_POST['gemini_key_'.$i]));
        }
        if (isset($_POST['openai_key_'.$i])) {
            update_option('ibd_openai_key_'.$i, sanitize_text_field($_POST['openai_key_'.$i]));
        }
    }

    $saved = true;
}

// Retrieve values
$api_keys = get_option('ilybd_api_keys', '');
$rev_share = get_option('ilybd_rev_share_percent', '20');
$ad_timer = get_option('ilybd_ad_timer', '15');
$enable_autoseo_editor = get_option('ilybd_enable_autoseo_editor', 'no');
$word_guideline = get_option('ilybd_target_word_guideline', '2000');
$min_quality = get_option('ilybd_autoseo_min_quality', '80');

$traffic_hijacker = get_option('ilybd_traffic_hijacker', 'off');
$seo_engine_status = get_option('ilybd_seo_engine_status', 'off');
?>

<div class="ilybd-cyber-wrapper">
    <h1 class="ilybd-cyber-h1">
        <span class="dashicons dashicons-brain" style="font-size:32px; width:32px; height:32px; color:#00f0ff;"></span>
        AI Autopilot & SEO Factory
    </h1>
    <p class="ilybd-cyber-subtitle">Gemini API কি-পুল ডিস্ট্রিবিউটর, রেভিনিউ শেয়ার নীতি, এবং ট্রাফিক ডিফেন্ডার প্রটেকশন।</p>

    <?php $this->ilybd_render_tabs('ai'); ?>

    <?php if ($saved): ?>
        <div class="notice notice-success is-dismissible" style="background:#13231c; color:#39ff14; border:1px solid #33a152; padding:15px; margin-bottom:25px; border-radius:6px; font-weight:bold; box-shadow:0 0 10px rgba(57, 255, 20, 0.15);">
            ⚡ এআই অটোপাইলট ও এসইও সেটিংস সফলভাবে সংরক্ষিত হয়েছে!
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <?php wp_nonce_field('ilybd_ai_nonce_action', 'ilybd_ai_nonce_action'); ?>

        <!-- Panel 1: Core Gemini load balancer API pool -->
        <div class="ilybd-cyber-panel">
            <div class="ilybd-panel-title"><span class="dashicons dashicons-database"></span> আইবিডি গ্লোবাল এপিআই লোড-ব্যালেন্সার (API Keys Pool Coordinator)</div>
            <table class="ilybd-cyber-form-table">
                <tr>
                    <th>Gemini API Keys Pool<br/><span style="font-size:11px; color:#64748b; font-weight:normal;">(কমা দিয়ে পৃথক করুন)</span></th>
                    <td>
                        <textarea name="ilybd_api_keys" rows="6" class="ilybd-cyber-textarea" style="width:100%; max-width:600px;" placeholder="key_1, key_2, key_3, key_4..."><?php echo esc_textarea($api_keys); ?></textarea>
                        <p class="ilybd-desc-text">আপনার ৫০+ বা ততোধিক এপিআই কিগুলো এখানে কমা (,) দিয়ে বসান। আমাদের এআই ইঞ্জিন প্রতিটি কনটেন্ট তৈরির সময় স্বয়ংক্রিয়ভাবে একটি করে কি চুজ করবে, যা কোটা লিমিট এড়াতে সাহায্য করে।</p>
                    </td>
                </tr>
                <tr>
                    <th>User Revenue Share (%)</th>
                    <td>
                        <input type="number" name="ilybd_rev_share_percent" value="<?php echo esc_attr($rev_share); ?>" min="1" max="100" class="ilybd-cyber-input" style="width:120px;" />
                        <p class="ilybd-desc-text">কনটেন্ট ক্রিয়েটর ও সাধারণ মেম্বারদের মোট আয়ের কত অংশ বণ্টন করা হবে (ডিফল্ট ২০ সংস্করণ)।</p>
                    </td>
                </tr>
                <tr>
                    <th>Ad Gate Waiting Timer (Seconds)</th>
                    <td>
                        <input type="number" name="ilybd_ad_timer" value="<?php echo esc_attr($ad_timer); ?>" class="ilybd-cyber-input" style="width:120px;" />
                        <p class="ilybd-desc-text">ডাউনলোড ট্রেইল বাটন আসার আগে বিজ্ঞাপন লোডিং থাকার সিকিউরিটি ডিলে সেকেন্ড।</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Panel 2: Collapsible Backup Vault (20 Key Slots) -->
        <div class="ilybd-cyber-panel" style="border-color: rgba(189, 0, 255, 0.25);">
            <div class="ilybd-panel-title" style="cursor:pointer; display:flex; justify-content:space-between; align-items:center;" onclick="jQuery('#api-vault-drawer').slideToggle(300); jQuery('#vault-arrow').toggleClass('rotate');">
                <span style="color:#bd00ff;"><span class="dashicons dashicons-lock" style="color:#bd00ff;"></span> 🔐 প্রাইভেট এপিআই ব্যাকআপ ভল্ট (20 Slots Vault)</span>
                <span id="vault-arrow" style="font-size:16px; color:#bd00ff; transition:transform 0.3s;">▼</span>
            </div>
            
            <div id="api-vault-drawer" style="display:none; padding-top:15px; border-top:1px dashed rgba(189, 0, 255, 0.2);">
                <p style="font-size:12px; color:#94a3b8; margin-bottom:15px;">ব্যাকআপ লোড সাপোর্টের জন্য আপনার ১০টি Gemini এবং ১০টি OpenAI সিক্রেট কি এখানে আলাদাভাবে সংকুচিত রাখতে পারেন:</p>
                <div style="display:flex; gap:20px; flex-wrap:wrap;">
                    <div style="flex:1; min-width:280px; background:rgba(0,0,0,0.15); padding:15px; border-radius:6px; border:1px solid rgba(148,163,184,0.06);">
                        <h4 style="margin:0 0 12px 0; color:#00f0ff; font-size:13px; font-family:'JetBrains Mono', monospace;">Gemini Primary Slots (1-10)</h4>
                        <?php for($i=1; $i<=10; $i++): $val = get_option('ibd_gemini_key_'.$i); ?>
                            <div style="margin-bottom:8px;">
                                <label style="font-size:10.5px; color:#94a3b8; display:block; margin-bottom:3px;">Gemini Vault Slot #<?php echo $i; ?>:</label>
                                <input type="password" name="gemini_key_<?php echo $i; ?>" value="<?php echo esc_attr($val); ?>" class="ilybd-cyber-input" style="width:100%; font-size:11px !important;" placeholder="AI-Vault Active State" />
                            </div>
                        <?php endfor; ?>
                    </div>
                    
                    <div style="flex:1; min-width:280px; background:rgba(0,0,0,0.15); padding:15px; border-radius:6px; border:1px solid rgba(148,163,184,0.06);">
                        <h4 style="margin:0 0 12px 0; color:#00f0ff; font-size:13px; font-family:'JetBrains Mono', monospace;">OpenAI Primary Slots (1-10)</h4>
                        <?php for($i=1; $i<=10; $i++): $val = get_option('ibd_openai_key_'.$i); ?>
                            <div style="margin-bottom:8px;">
                                <label style="font-size:10.5px; color:#94a3b8; display:block; margin-bottom:3px;">OpenAI Vault Slot #<?php echo $i; ?>:</label>
                                <input type="password" name="openai_key_<?php echo $i; ?>" value="<?php echo esc_attr($val); ?>" class="ilybd-cyber-input" style="width:100%; font-size:11px !important;" placeholder="AI-Vault Active State" />
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel 3: Auto-SEO Publishing Policies -->
        <div class="ilybd-cyber-panel">
            <div class="ilybd-panel-title"><span class="dashicons dashicons-text"></span> এআই এডিটর ও প্রকাশনা গাইডলাইন (Auto-Publish Policies)</div>
            <table class="ilybd-cyber-form-table">
                <tr>
                    <th>পাবলিশ করার পূর্বে এআই এসইও এডিট</th>
                    <td>
                        <select name="ilybd_enable_autoseo_editor" class="ilybd-cyber-select" style="min-width:260px;">
                            <option value="no" <?php selected($enable_autoseo_editor, 'no'); ?>>বন্ধ (পাবলিশ উইদাউট এডিটর রিভিউ)</option>
                            <option value="yes" <?php selected($enable_autoseo_editor, 'yes'); ?>>চালু (কনটেন্ট ক্রাউলার এডিটর ভেরিফিকেশন)</option>
                        </select>
                        <p class="ilybd-desc-text">চালু থাকলে প্রতিটি এআই দ্বারা উৎপাদিত পোস্ট সরাসরি পাবলিশ না হয়ে ড্রাফট থাকবে এবং এডিটর কর্তৃক সর্বোচ্চ এসইও চেক স্ক্রিনিং করার পরেই নিশ্চিত হবে।</p>
                    </td>
                </tr>
                <tr>
                    <th>SEO Optimization Filter Engine</th>
                    <td>
                        <select name="ilybd_seo_engine_status" class="ilybd-cyber-select" style="min-width:260px;">
                            <option value="off" <?php selected($seo_engine_status, 'off'); ?>>বন্ধ (Native Article Content)</option>
                            <option value="on" <?php selected($seo_engine_status, 'on'); ?>>চালু (Auto Inject Metadata, Semantic Schema, Header Keywords)</option>
                        </select>
                        <p class="ilybd-desc-text">চালু থাকলে ব্যবহারকারীদের সাবমিট করা কনটেন্টের নিচে স্বয়ংক্রিয়ভাবে এসইও ফ্রেন্ডলি মেটা ও ইইএটি স্কিমা ইনজেক্ট হবে।</p>
                    </td>
                </tr>
                <tr>
                    <th>নির্ণিত শব্দ সংখ্যা গাইডলাইন (Target Words)</th>
                    <td>
                        <select name="ilybd_target_word_guideline" class="ilybd-cyber-select" style="min-width:260px;">
                            <option value="500" <?php selected($word_guideline, '500'); ?>>৫০০+ শব্দ (সংক্ষিপ্ত সমাধান)</option>
                            <option value="1000" <?php selected($word_guideline, '1000'); ?>>১০০০+ শব্দ (সাধারণ ব্লগ কভার)</option>
                            <option value="2000" <?php selected($word_guideline, '2000'); ?>>২০০০+ শব্দ (তথ্যবহুল প্রযুক্তি সহায়িকা)</option>
                            <option value="4000" <?php selected($word_guideline, '4000'); ?>>৪০০০+ শব্দ (সম্পূর্ণ হাই-কোয়ালিটি গাইড বুক)</option>
                        </select>
                        <p class="ilybd-desc-text">এআই রাইটার বা অটোপাইলট জেনারেটরের সর্বনিম্ন শব্দ আউটপুটের সীমানা নির্দেশক। এটি থিন কনটেন্ট পেনাল্টি থেকে গুগলে সাইটকে বাচাবে।</p>
                    </td>
                </tr>
                <tr>
                    <th>Min Quality Passing Scores</th>
                    <td>
                        <input type="number" name="ilybd_autoseo_min_quality" value="<?php echo esc_attr($min_quality); ?>" class="ilybd-cyber-input" style="width:120px;" />
                        <p class="ilybd-desc-text">এআই ইন্টিগ্রিটি এডিটর পাস কোয়ালিটি স্কোর (ডিফল্ট ৮০%)। এর কম হলে কনটেন্ট স্বয়ংক্রিয়ভাবে ড্রাফট তালিকায় বাতিল হিসেবে জমা থাকবে।</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Panel 4: Traffic Guard Exit Intent Hijacker Defender -->
        <div class="ilybd-cyber-panel" style="border-color: rgba(57, 255, 20, 0.25);">
            <div class="ilybd-panel-title" style="color:#39ff14;"><span class="dashicons dashicons-shield"></span> ট্রাফিক সিকিউরিটি ও বট প্রতিরোধক (Traffic Guard & Scraper Defender)</div>
            <table class="ilybd-cyber-form-table">
                <tr>
                    <th>Exit-Intent Traffic Defense</th>
                    <td>
                        <select name="ilybd_traffic_hijacker" class="ilybd-cyber-select" style="min-width:260px; border-color:#39ff14 !important;">
                            <option value="off" <?php selected($traffic_hijacker, 'off'); ?>>বন্ধ (Normal User Exit Behavior)</option>
                            <option value="on" <?php selected($traffic_hijacker, 'on'); ?>>চালু (Interactive Trap exit intent & Random Redirect loop on leave)</option>
                        </select>
                        <p class="ilybd-desc-text">এটি চালু থাকলে যখন কোনো গ্রাহক মাউস কার্সার স্ক্রিনের উপরে নিয়ে চলে যাওয়ার চেষ্টা করবে, আমাদের এআই সিকিউরিটি ডিফেন্স তাদের একটি সতর্কবার্তা প্রদর্শন করে অন্য একটি সাইবার সিক্রেট পোস্টে রিডিরেক্ট করবে। এটি স্ক্র্যাপার বটদের কন্টেন্ট ছিয়াশানো নিষ্ক্রিয় করতে এবং ট্রাফিক বাউন্স রেট রুখতে অতুলনীয়!</p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top:20px;">
            <button type="submit" name="ilybd_save_ai_submit" class="ilybd-cyber-btn">
                <span class="dashicons dashicons-saved" style="font-size:16px; width:16px; height:16px; margin:0 5px 0 0; color:#070b13;"></span>
                Save Autopilot AI & SEO Rules
            </button>
        </div>

    </form>
</div>

<style>
.rotate {
    transform: rotate(180deg) !important;
}
</style>
