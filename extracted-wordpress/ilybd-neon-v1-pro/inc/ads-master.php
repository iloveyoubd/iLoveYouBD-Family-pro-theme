<?php
/**
 * ILYBD Neon v1 Pro - Revenue Engine v3
 * Smart Ad Placement System (AdSense Safe + Optimized + Multi-Slot Options)
 */

if (!defined('ABSPATH')) exit;

/* =========================================================
   1. ADMIN SETTINGS MENU REGISTER
   ========================================================= */
add_action('admin_menu', function() {
    add_submenu_page(
        'ilybd-settings',                     // Parent Slug (Neon Master)
        'AdSense Security & Ad Placement Config',  // Page Title
        '💰 Multi Ad & AdSense Panel',        // Menu Title
        'manage_options',                     // Capability
        'ilybd-ads-hub',                      // Menu Slug
        'ilybd_ads_hub_settings_page'         // Rendering Callback
    );
});

/* =========================================================
   2. RENDER THE ADVANCED NEON ADS OPTION PANEL
   ========================================================= */
function ilybd_ads_hub_settings_page() {
    // 🛡️ Security Option Authorization check
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'ilybd'));
    }

    $slots = ['header', 'top', 'middle', 'bottom', 'footer', 'sidebar'];

    // ⚡ Process Save Action
    if (isset($_POST['ilybd_ads_save_nonce']) && wp_verify_nonce($_POST['ilybd_ads_save_nonce'], 'ilybd_save_ads_action')) {
        
        foreach ($slots as $slot) {
            $code_field = "ilybd_ads_code_{$slot}";
            $enabled_field = "ilybd_ads_enabled_{$slot}";
            $auto_field = "ilybd_ads_auto_{$slot}";
            
            // Raw text textarea update (allows script tags, HTML and iframe units)
            if (isset($_POST[$code_field])) {
                update_option($code_field, $_POST[$code_field]);
            }
            
            update_option($enabled_field, isset($_POST[$enabled_field]) ? '1' : '0');
            update_option($auto_field, isset($_POST[$auto_field]) ? '1' : '0');
        }
        
        // Save middle content paragraph offset spacing
        if (isset($_POST['ilybd_ads_middle_paragraph'])) {
            update_option('ilybd_ads_middle_paragraph', max(1, intval($_POST['ilybd_ads_middle_paragraph'])));
        }
        
        // Update global monetization core options for backward compatibility
        if (isset($_POST['ilybd_ad_status'])) {
            update_option('ilybd_ad_status', sanitize_text_field($_POST['ilybd_ad_status']));
        }
        
        if (isset($_POST['ilybd_hacker_mode'])) {
            update_option('ilybd_hacker_mode', sanitize_text_field($_POST['ilybd_hacker_mode']));
        }

        echo '<div style="background: rgba(0, 255, 65, 0.08); border: 2px solid #00ff41; color: #fff; padding: 18px; border-radius: 12px; margin: 20px 0; font-family: system-ui; box-shadow: 0 0 20px rgba(0, 255, 65, 0.15);">
                <span style="color:#00ff41; font-weight:900; font-size:16px;"><i class="dashicons dashicons-yes-alt" style="color:#00ff41; vertical-align: middle;"></i> 💻 SUCCESS:</span> 
                স্বর্ণালী পরিবর্তন সফলভাবে ডেটাবেজে সংরক্ষিত হয়েছে! অবাঞ্ছিত ফাকা স্পেস রিমুভ করা হয়েছে এবং অ্যাডসেন্স হাব সক্রিয় করা হয়েছে।
              </div>';
    }

    // 🔋 Retrieve DB states
    $data = [];
    foreach ($slots as $slot) {
        $data[$slot] = [
            'code' => get_option("ilybd_ads_code_{$slot}", ''),
            'enabled' => get_option("ilybd_ads_enabled_{$slot}", '0') === '1',
            'auto' => get_option("ilybd_ads_auto_{$slot}", '0') === '1',
        ];
    }
    
    $middle_paragraph = intval(get_option('ilybd_ads_middle_paragraph', 3));
    $global_status = get_option('ilybd_ad_status', 'active');
    $hacker_mode = get_option('ilybd_hacker_mode', 'no');

    // Human-friendly labels for translating purposes
    $friendly_labels = [
        'header'  => ['title' => 'Header Ad Code & Scripts', 'desc' => 'AdSense হেডার স্ক্রিপ্ট/Auto Ads কোড এখানে রাখুন (সাধারণত <head> ট্যাগের ভেতরে রান হয়)।'],
        'top'     => ['title' => 'Top Banner Ad Code', 'desc' => 'আর্টিকেল বা মূল কনটেন্টের ঠিক উপরে এই অ্যাডভারটাইজমেন্ট শো করবে।'],
        'middle'  => ['title' => 'Article Middle Ad Code', 'desc' => 'প্যারাগ্রাফের মাঝখানে শো করবে। নিচে কত নম্বর প্যারাগ্রাফে বসবে তা সেট করতে পারবেন।'],
        'bottom'  => ['title' => 'Bottom Banner Ad Code', 'desc' => 'আর্টিকেল বা মূল কনটেন্টের একেবারে নিচে এই অ্যাডভারটাইজমেন্ট শো করবে।'],
        'footer'  => ['title' => 'Footer Overlay/Ad Code', 'desc' => 'ফুটার স্ক্রিপ্ট বা ফুটার সেকশনে শো করার জন্য অ্যাড কোড এখানে রাখুন।'],
        'sidebar' => ['title' => 'Sidebar Widget Ad Code', 'desc' => 'সাইডবার ব্লক বা উইজেটের ভেতরে কাস্টম অ্যাড কোড রেন্ডার করার জন্য ব্যবহার করুন।']
    ];
    ?>

    <div class="wrap" style="background:#070a0f; color:#c9d1d9; padding:35px; border-radius:18px; border:1px solid #1e293b; font-family:system-ui, -apple-system, sans-serif; max-width:1100px; margin: 30px auto; box-shadow:0 12px 40px rgba(0,0,0,0.6);">
        
        <!-- HEADER HEADER -->
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #1e293b; padding-bottom: 25px; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
            <div>
                <h1 style="color:#00ff41; font-size:28px; font-weight:900; margin:0; letter-spacing:1px; text-shadow:0 0 15px rgba(0,255,65,0.15);">
                    💰 ILYBD ADVANCED MULTI-AD HUB
                </h1>
                <p style="color:#8b949e; margin:6px 0 0 0; font-size:14px;">
                    স্মার্ট অ্যাডসেন্স ও ব্যানার কন্ট্রোল প্যানেল (যেকোনো জায়গায় অ্যাড বসান কোনো ফাকা জায়গা ছাড়াই!)
                </p>
            </div>
            <div style="background:#0f172a; border: 1.5px solid #00f0ff; padding: 10px 20px; border-radius: 12px; font-size:13px; font-weight:bold; box-shadow:0 0 10px rgba(0,240,255,0.1);">
                <i class="dashicons dashicons-admin-network" style="color:#00f0ff; vertical-align: middle; margin-right:5px;"></i> SYSTEM STATUS: ONLINE
            </div>
        </div>

        <div style="background:rgba(0, 229, 255, 0.05); border:1.5px solid rgba(0, 229, 255, 0.3); padding:20px; border-radius:14px; margin-bottom:30px; line-height: 1.6; font-size:13.5px;">
            <p style="margin:0; color:#00e5ff; font-weight:800; font-size:15px; margin-bottom:10px;">
                💡 এই সিস্টেমটি কিভাবে কাজ করে? (How the system works?)
            </p>
            <ol style="margin:0; padding-left:20px; color:#c9d1d9; gap: 8px; display: flex; flex-direction: column;">
                <li><strong>কোনো ফাকা বা ফাঁকা জায়গা থাকবে না:</strong> কোনো অ্যাড স্লট নিষ্ক্রিয় বা খালি রাখলে, সেই জায়গায় রেন্ডার ফাইল সম্পূর্ণ ট্রিমড শূন্য থাকবে। ফলে সাইটে কোনো ফাকা ঘর বা ব্যাকগ্রাউন্ড গ্যাপ থাকবে না।</li>
                <li><strong>স্বয়ংক্রিয় ইনজেকশন বন্ধ রাখা বা চালু করার সুযোগ:</strong> প্রতিটি স্লটে আপনি নিজেই ড্রপডাউন সিলেক্ট করতে পারবেন যে আপনি কনটেন্টের ভেতরে স্বয়ংক্রিয়ভাবে অ্যাড ঢুকাতে চান নাকি ম্যানুয়ালি শর্টকোড বসিয়ে শো করাতে চান।</li>
                <li><strong>শর্টকোড পাওয়ার:</strong> প্রতি স্লটের জন্য নিচে শর্টকোড জেনারেটর দেওয়া আছে। ক্লিক করলেই কপি হয়ে যাবে। এটি পোস্টের ভেতর যেকোনো স্থানে লিখলে সেখানে অ্যাড শো করবে।</li>
            </ol>
        </div>

        <form method="post" action="">
            <?php wp_nonce_field('ilybd_save_ads_action', 'ilybd_ads_save_nonce'); ?>

            <!-- GLOBAL SETTINGS GRID -->
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:20px; margin-bottom:35px; background:#0f172a; padding:22px; border-radius:14px; border:1px solid #1e293b;">
                <div>
                    <label style="display:block; color:#fff; font-weight:bold; margin-bottom:8px; font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">
                        🕹️ Global Ads Core Status
                    </label>
                    <select name="ilybd_ad_status" style="width:100%; background:#070a0f; color:#00ff41; border:1px solid #334155; padding:10px 14px; border-radius:8px; font-weight:bold; outline:none;">
                        <option value="active" <?php selected($global_status, 'active'); ?>>ACTIVE (বিজ্ঞাপন সচল আছে)</option>
                        <option value="inactive" <?php selected($global_status, 'inactive'); ?>>GLOBAL OFF (সকল বিজ্ঞাপন বন্ধ করুন)</option>
                    </select>
                    <small style="color:#8b949e; display:block; margin-top:5px; font-size:11.5px;">সরাসরি সম্পূর্ণ সাইটের বিজ্ঞাপন এক-ক্লিকে অন বা অফ করার মাস্টার চাবি।</small>
                </div>

                <div>
                    <label style="display:block; color:#fff; font-weight:bold; margin-bottom:8px; font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">
                        🕵️ Admin Preview Border Mode
                    </label>
                    <select name="ilybd_hacker_mode" style="width:100%; background:#070a0f; color:#00e5ff; border:1px solid #334155; padding:10px 14px; border-radius:8px; font-weight:bold; outline:none;">
                        <option value="yes" <?php selected($hacker_mode, 'yes'); ?>>ON (অ্যাডমিনদের জন্য ডট বর্ডার দিয়ে বিজ্ঞাপন স্লট পজিশন মার্ক করুন)</option>
                        <option value="no" <?php selected($hacker_mode, 'no'); ?>>OFF (ভিজিটরদের মতো স্বাভাবিক ক্লিয়ার প্যানেল রাখুন)</option>
                    </select>
                    <small style="color:#8b949e; display:block; margin-top:5px; font-size:11.5px;">চালু থাকলে অ্যাডমিন হিসেবে লগইন করা অবস্থায় বর্ডারসহ বিজ্ঞাপনের স্থান চিহ্নিত হবে।</small>
                </div>

                <div>
                    <label style="display:block; color:#fff; font-weight:bold; margin-bottom:8px; font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">
                        📖 Middle Ad Paragraph Location
                    </label>
                    <input type="number" min="1" max="25" name="ilybd_ads_middle_paragraph" value="<?php echo esc_attr($middle_paragraph); ?>" style="width:100%; background:#070a0f; color:#fff; border:1px solid #334155; padding:9px 14px; border-radius:8px; font-weight:bold; outline:none;">
                    <small style="color:#8b949e; display:block; margin-top:5px; font-size:11.5px;">কনটেন্ট মিডল অ্যান্ড অটো-ইঞ্জিন সক্রিয় থাকলে প্রতিটি আর্টিকেলের কত নম্বর প্যারাগ্রাফের পর অ্যাড বসবে।</small>
                </div>
            </div>

            <h2 style="color:#00ff41; font-size:19px; border-left:4px solid #00ff41; padding-left:12px; margin-bottom:20px; font-weight:bold;">
                📋 বিজ্ঞাপন স্লটসমূহ কাস্টমাইজ করুন (Configure Individual Ad Slots)
            </h2>

            <!-- ADVANCED AD SLOTS GRID -->
            <div style="display: flex; flex-direction: column; gap: 25px;">
                <?php foreach ($slots as $slot): 
                    $label_info = $friendly_labels[$slot];
                    $slot_data = $data[$slot];
                    $shortcode_formula = '[ilybd_ad slot="' . $slot . '"]';
                ?>
                    <div style="background:#111827; border: 1.5px solid #1e293b; border-radius:14px; padding:22px; transition: 0.3s; position: relative;" onmouseover="this.style.borderColor='#00ff41'; this.style.boxShadow='0 0 15px rgba(0,255,100,0.03)';" onmouseout="this.style.borderColor='#1e293b'; this.style.boxShadow='none';">
                        
                        <!-- Slot Title Section -->
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:15px; border-bottom:1px solid #1f2937; padding-bottom:12px;">
                            <div>
                                <h3 style="color:#fff; margin:0; font-size:16px; font-weight:800; display:flex; align-items:center; gap:8px;">
                                    <span style="background: rgba(0,255,65,0.08); color:#00ff41; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; font-size:12px; border:1px solid rgba(0,255,65,0.3)">
                                        <?php echo strtoupper(substr($slot, 0, 1)); ?>
                                    </span>
                                    <?php echo esc_html($label_info['title']); ?>
                                </h3>
                                <p style="color:#8b949e; font-size:12px; margin:4px 0 0 0;"><?php echo esc_html($label_info['desc']); ?></p>
                            </div>
                            
                            <!-- Checkbox Panel -->
                            <div style="display:flex; gap:15px; align-items:center; flex-wrap:wrap;">
                                <label style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:bold; color:#fff; background:#1f2937; padding:6px 14px; border-radius:20px; cursor:pointer;">
                                    <input type="checkbox" name="ilybd_ads_enabled_<?php echo $slot; ?>" value="1" <?php checked($slot_data['enabled']); ?> style="accent-color:#00ff41;">
                                    সক্রিয় করুন (Enable)
                                </label>
                                
                                <?php if (in_array($slot, ['header', 'top', 'middle', 'bottom', 'footer'])): ?>
                                    <label style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:bold; color:#fff; background:#1e1b4b; padding:6px 14px; border-radius:20px; cursor:pointer;" title="আর্টিকেল পেজ বা হডার/ফুটারে স্বয়ংক্রিয়ভাবে ইনজেক্ট করতে টিক দিন।">
                                        <input type="checkbox" name="ilybd_ads_auto_<?php echo $slot; ?>" value="1" <?php checked($slot_data['auto']); ?> style="accent-color:#00f0ff;">
                                        স্বয়ংক্রিয় ইনজেকশন (Auto Inject)
                                    </label>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Code Content Box -->
                        <div style="margin-bottom:15px;">
                            <label style="display:block; color:#c9d1d9; font-size:12.5px; font-weight:bold; margin-bottom:6px;">বিজ্ঞাপন কোড বসান (HTML, JavaScript, Iframe or Google AdSense Responsive Tag):</label>
                            <textarea name="ilybd_ads_code_<?php echo $slot; ?>" rows="5" placeholder="ನಿಮ್ಮ Ad Placement Code অথবা Google AdSense Code এখানে পেস্ট করুন..." style="width:100%; background:#070a0f; color:#00ff41; border:1px solid #1e293b; border-radius:10px; padding:12px; font-family:Courier, monospace; font-size:12px; font-weight:bold; outline:none; transition:0.3s;" onfocus="this.style.borderColor='#00ff41'; this.style.boxShadow='0 0 10px rgba(0,255,65,0.1)';"><?php echo esc_textarea($slot_data['code']); ?></textarea>
                        </div>

                        <!-- Mini Copy Shortcode Bar -->
                        <div style="display:flex; align-items:center; justify-content:space-between; background:#0d1117; border: 1px dashed #30363d; border-radius:8px; padding:8px 15px; flex-wrap:wrap; gap:10px;">
                            <div style="font-size:12px; color:#8b949e;">
                                🚀 <span style="font-weight:bold; color:#fff;">ম্যানুয়াল শর্টকোড:</span> এই কোডটি কপি করে পোস্ট বা উইজেটের যেকোনো জায়গায় লিখলে বিজ্ঞাপন লোড হবে:
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <code style="background:#161b22; color:#00e5ff; font-weight:bold; padding:4px 10px; border-radius:5px; font-size:11.5px; border: 1px solid #30363d;"><?php echo esc_html($shortcode_formula); ?></code>
                                <button type="button" onclick="copyShortcode('<?php echo esc_attr($shortcode_formula); ?>')" style="background:#1f2937; border:none; color:#fff; cursor:pointer; font-size:11px; font-weight:bold; padding:4px 10px; border-radius:5px; transition:0.2s;" onmouseover="this.style.background='#00ff41'; this.style.color='#000';" onmouseout="this.style.background='#1f2937'; this.style.color='#fff';">Copy</button>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <!-- SUBMIT ACTION BANNER -->
            <div style="margin-top:40px; padding-top:20px; border-top:1px solid #1e293b; display:flex; justify-content:flex-end;">
                <button type="submit" style="background: linear-gradient(135deg, #00ff41, #00cb33); color:#000; font-weight:900; border:none; font-size:15px; text-transform:uppercase; letter-spacing:1px; cursor:pointer; border-radius:10px; padding:15px 35px; transition:0.3s; display:inline-flex; align-items:center; gap:10px; box-shadow:0 0 15px rgba(0,255,65,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 0 25px rgba(0,255,65,0.45)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 0 15px rgba(0,255,65,0.2)';">
                    <span style="font-size:18px;">💾</span> সংরক্ষণ করুন (Save All Ad Rules)
                </button>
            </div>
        </form>

    </div>

    <!-- Clipboard JS Helper -->
    <script>
    function copyShortcode(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('সফলভাবে ক্লিপবোর্ডে কপি করা হয়েছে: ' + text);
        }, function() {
            var temp = document.createElement('input');
            document.body.appendChild(temp);
            temp.value = text;
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            alert('সফলভাবে ক্লিপবোর্ডে কপি করা হয়েছে: ' + text);
        });
    }
    </script>
    <?php
}

/* =========================================================
   3. GET SMART AD INTELLIGENTLY
   ========================================================= */
function ilybd_get_smart_ad_code($slot, $wrapped = true) {
    // Check global toggle
    if (get_option('ilybd_ad_status', 'active') !== 'active') {
        return '';
    }
    
    // Check if slot enabled
    $enabled = get_option("ilybd_ads_enabled_{$slot}", '0') === '1';
    if (!$enabled) {
        return '';
    }
    
    // Get slot code content
    $code = get_option("ilybd_ads_code_{$slot}", '');
    if (empty(trim($code))) {
        return '';
    }
    
    // Check if user is administrator and has Debug Mode Active
    if (is_user_logged_in() && current_user_can('manage_options') && get_option('ilybd_hacker_mode', 'no') === 'yes') {
        if ($wrapped) {
            return '<div class="ilybd-ad-admin-preview" style="border: 2px dashed #00ff41; padding: 12px; margin: 18px auto; text-align: center; background: rgba(0, 255, 65, 0.03); border-radius: 10px; overflow:hidden; position:relative; clear:both; min-height: 40px;">
                        <span style="position:absolute; top:0; left:0; background:#00ff41; color:#000; font-size:9.5px; font-weight:900; padding:1px 8px; border-radius:0 0 6px 0; text-transform:uppercase; font-family:monospace; z-index:99;">ADMIN AD HUB: ' . esc_html($slot) . '</span>
                        <div style="min-height:20px; clear:both; margin-top:10px;">' . $code . '</div>
                    </div>';
        }
        return $code;
    }
    
    // Output standard visitor wrap ONLY IF non-empty
    if ($wrapped) {
        // Reserve an elegant, non-shifting minimum space depending on the slot type
        $min_height = '100px';
        if (in_array($slot, ['top', 'bottom', 'middle'])) {
            $min_height = '280px'; // standard banner space pre-reservation
        } elseif ($slot === 'sidebar') {
            $min_height = '300px';
        }
        
        return '<div class="ilybd-ad-pub-container ilybd-ad-slot-' . esc_attr($slot) . '" style="margin: 28px auto; text-align: center; width:100%; clear: both; display: block; overflow:hidden; min-height: ' . $min_height . '; background: #070a0f; border: 1px solid rgba(255,255,255,0.03); border-radius: 12px; padding: 16px 0; box-shadow: inset 0 0 10px rgba(0,0,0,0.5); position: relative;">
                    <div style="font-family: \'Space Grotesk\', sans-serif; font-size: 9px; text-transform: uppercase; letter-spacing: 1.5px; color: #505c6d; margin-bottom: 12px; font-weight: bold; width: 100%; text-align: center; display: block;">ADVERTISEMENT / বিজ্ঞাপন</div>
                    <div style="display: inline-block; width: 100%; text-align: center; margin-top: 5px;">' . $code . '</div>
                </div>';
    }
    
    return $code;
}

/* =========================================================
   4. SHORTCODE IMPLEMENTATION
   ========================================================= */
add_shortcode('ilybd_ad', 'ilybd_render_ad_shortcode');
function ilybd_render_ad_shortcode($atts) {
    $a = shortcode_atts(array(
        'slot' => 'middle', // Default fallback
    ), $atts);
    
    $slot = sanitize_key($a['slot']);
    return ilybd_get_smart_ad_code($slot);
}

/* =========================================================
   5. AUTO CONTENT AD INJECTION (Safe & Fully Optional)
   ========================================================= */
add_filter('the_content', 'ilybd_smart_ad_engine', 99); // Safe priority
function ilybd_smart_ad_engine($content) {
    if (is_admin() || !is_single() || is_singular('ilybd_sms')) {
        return $content;
    }
    
    $top_ad = ilybd_get_smart_ad_code('top');
    $middle_ad = ilybd_get_smart_ad_code('middle');
    $bottom_ad = ilybd_get_smart_ad_code('bottom');
    
    $out_content = '';
    
    // Top Ad injection (Auto top)
    if (get_option('ilybd_ads_auto_top', '0') === '1' && !empty($top_ad)) {
        $out_content .= $top_ad;
    }
    
    // Middle Paragraph injection (Auto middle)
    if (get_option('ilybd_ads_auto_middle', '0') === '1' && !empty($middle_ad)) {
        $paragraph_index = max(1, intval(get_option('ilybd_ads_middle_paragraph', 3)));
        $parts = explode("</p>", $content);
        $new_content = '';
        $count = 0;
        
        foreach ($parts as $p) {
            if (trim($p)) {
                $new_content .= $p . "</p>";
                $count++;
            } else {
                $new_content .= $p;
            }
            if ($count === $paragraph_index) {
                // Insert Middle Ad
                $new_content .= $middle_ad;
            }
        }
        $out_content .= $new_content;
    } else {
        $out_content .= $content;
    }
    
    // Bottom Ad injection (Auto bottom)
    if (get_option('ilybd_ads_auto_bottom', '0') === '1' && !empty($bottom_ad)) {
        $out_content .= $bottom_ad;
    }
    
    return $out_content;
}

/* =========================================================
   6. AUTO HEADER & FOOTER HOOKS (Fully Clean scripts placement)
   ========================================================= */
// Auto Head script injector (Prints inside <head> element. Zero visible layout nodes)
add_action('wp_head', function() {
    if (get_option('ilybd_ads_auto_header', '0') === '1') {
        echo ilybd_get_smart_ad_code('header', false); 
    }
}, 99);

// Auto Foot script injector (Prints inside footer before </body> tag)
add_action('wp_footer', function() {
    if (get_option('ilybd_ads_auto_footer', '0') === '1') {
        echo ilybd_get_smart_ad_code('footer', false);
    }
}, 99);

/* =========================================================
   7. BACKWARD COMPATIBLE SIDEBAR CALLS
   ========================================================= */
function ilybd_sidebar_ad() {
    echo ilybd_get_smart_ad_code('sidebar');
}

function ilybd_get_ad_code() {
    // Backward compatibility for third-party functions getting default middle code
    return ilybd_get_smart_ad_code('middle', false);
}

function ilybd_ad_wrapper($html) {
    if (empty(trim($html))) {
        return '';
    }
    return '<div class="ad-wrap-secure" style="display:inline-block; max-width:100%; text-align:center;">' . $html . '</div>';
}
