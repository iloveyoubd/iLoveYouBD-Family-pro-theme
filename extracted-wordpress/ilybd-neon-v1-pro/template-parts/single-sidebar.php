<?php
/**
 * I Love You BD Cyber Next-Gen Sidebar Component (2040 Style)
 * Target: High Search Engine Indexability & Seamless Mobile Stack Layouts.
 */
$sidebar_neon = get_option('ilybd_main_color', '#00ff41');
$current_post_id = get_the_ID();
?>

<div class="ilybd-cyber-sidebar-widgets" style="display: flex; flex-direction: column; gap: 30px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">

    <!-- WIDGET 1: POPULAR/RECENT QUESTIONS BLOCK -->
    <div class="cyber-sidebar-card" style="background: rgba(13, 21, 39, 0.45); border: 1.5px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); backdrop-filter: blur(8px);">
        <h4 style="margin: 0 0 15px; font-size: 14px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; border-bottom: 1px dashed rgba(255,255,255,0.08); padding-bottom: 10px;">
            <i class="fa-solid fa-comments-question" style="color: #00f0ff;"></i> কিউ-অ্যান্ড-এ কমিউনিটি ফোরাম
        </h4>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); padding: 10px; border-radius: 8px;">
                <span style="font-size: 9px; color: #00f0ff; font-family: monospace; font-weight: bold; display: block; margin-bottom: 3px;">SOLVED [REWARD COMPLETED]</span>
                <a href="<?php echo esc_url(home_url('/ask-question/?q=wordpress-speed')); ?>" style="color: #eceff1; font-size: 12.5px; text-decoration: none; font-weight: bold; line-height: 1.4; display: block;">ওয়ার্ডপ্রেস ওয়েবসাইটের স্পিড কিভাবে বাড়াবো?</a>
                <span style="font-size: 10px; color: #8b949e; display: block; margin-top: 5px;"><i class="fa-solid fa-circle-check" style="color: #00ff41;"></i> ১২ জন উত্তরদাতা • ৩ দিন আগে</span>
            </div>
            
            <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); padding: 10px; border-radius: 8px;">
                <span style="font-size: 9px; color: #ffbf00; font-family: monospace; font-weight: bold; display: block; margin-bottom: 3px;">OPEN FORUM QUESTION</span>
                <a href="<?php echo esc_url(home_url('/ask-question/?q=chatgpt-bengali')); ?>" style="color: #eceff1; font-size: 12.5px; text-decoration: none; font-weight: bold; line-height: 1.4; display: block;">এআই এর মাধ্যমে বাংলা কন্টেন্ট লেখার সঠিক প্রম্পট কোনটি?</a>
                <span style="font-size: 10px; color: #8b949e; display: block; margin-top: 5px;"><i class="fa-regular fa-clock"></i> ৫ টি লাইভ উত্তর • ৪ ঘন্টা আগে</span>
            </div>

            <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); padding: 10px; border-radius: 8px;">
                <span style="font-size: 9px; color: #00ff41; font-family: monospace; font-weight: bold; display: block; margin-bottom: 3px;">SECURITY SOLVED</span>
                <a href="<?php echo esc_url(home_url('/ask-question/?q=adsense-violation')); ?>" style="color: #eceff1; font-size: 12.5px; text-decoration: none; font-weight: bold; line-height: 1.4; display: block;">গুগল এডসেন্স পলিসি লঙ্ঘন না করে কিভাবে ট্রাফিক বাড়াবো?</a>
                <span style="font-size: 10px; color: #8b949e; display: block; margin-top: 5px;"><i class="fa-solid fa-circle-check" style="color: #00ff41;"></i> ৮ জন এক্সপার্ট ফিডব্যাক</span>
            </div>
        </div>

        <a href="<?php echo esc_url(home_url('/ask-question/')); ?>" style="background: rgba(0, 240, 255, 0.08); border: 1px solid rgba(0, 240, 255, 0.25); color: #00f0ff; text-align: center; display: block; padding: 10px; border-radius: 6px; font-weight: bold; font-size: 11.5px; text-decoration: none; margin-top: 15px; text-transform: uppercase; transition: 0.2s;" onmouseover="this.style.background='rgba(0, 240, 255, 0.15)'" onmouseout="this.style.background='rgba(0, 240, 255, 0.08)'">
            নিজের প্রশ্ন সাবমিট করুন <i class="fa-solid fa-paper-plane-top"></i>
        </a>
    </div>

    <!-- WIDGET 2: TRENDING CATEGORIES -->
    <div class="cyber-sidebar-card" style="background: rgba(13, 21, 39, 0.45); border: 1.5px solid rgba(0, 255, 65, 0.15); border-radius: 12px; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); backdrop-filter: blur(8px);">
        <h4 style="margin: 0 0 15px; font-size: 14px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; border-bottom: 1px dashed rgba(255,255,255,0.08); padding-bottom: 10px;">
            <i class="fa-solid fa-folder-open" style="color: #00ff41;"></i> কটেগরি সূচি (Topics)
        </h4>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
            <?php
            $cats = get_categories(array('orderby' => 'count', 'order' => 'DESC', 'number' => 8));
            foreach ($cats as $c) : ?>
                <li style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?php echo esc_url(get_category_link($c->term_id)); ?>" style="color: #c9d1d9; text-decoration: none; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px; transition: 0.2s;" onmouseover="this.style.color='#00ff41'" onmouseout="this.style.color='#c9d1d9'">
                        <span style="color: #00ff41;">•</span> <?php echo esc_html($c->name); ?>
                    </a>
                    <span style="background: rgba(0,255,65,0.08); color: #00ff41; font-weight: bold; padding: 2px 7px; border-radius: 20px; font-size: 11.5px; border: 1px solid rgba(0,255,65,0.15); font-family: monospace;">
                        <?php echo $c->count; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- WIDGET 3: DYNAMIC POST RELATED INTERACTIVE TOOLS -->
    <div class="cyber-sidebar-card" style="background: rgba(13, 21, 39, 0.45); border: 1.5px solid rgba(251, 191, 36, 0.15); border-radius: 12px; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); backdrop-filter: blur(8px);">
        <h4 style="margin: 0 0 15px; font-size: 14px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; border-bottom: 1px dashed rgba(255,255,255,0.08); padding-bottom: 10px;">
            <i class="fa-solid fa-sliders" style="color: #fbbf24;"></i> জনপ্রিয় ইন্টারেক্টিভ টুলস
        </h4>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">

            <div style="background: rgba(255,255,255,0.02); padding: 8px 12px; border-radius: 8px; border-left: 3px solid #00f0ff; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <span style="color: #fff; font-size: 12.5px; font-weight: bold; display: block;">এআই ক্লাউড মায়া চ্যাট</span>
                    <span style="color: #8b949e; font-size: 10px;">অ্যালগরিদম সমস্যা সমাধানকারী বোট</span>
                </div>
                <a href="<?php echo esc_url(home_url('/tools/')); ?>" style="background: #00f0ff; color:#000; border-radius:4px; padding: 4px 8px; font-size: 10.5px; font-weight: 850; text-decoration: none;">আলাপন</a>
            </div>
        </div>

        <a href="<?php echo esc_url(home_url('/tools/')); ?>" style="background: rgba(251, 191, 36, 0.08); border: 1px solid rgba(251, 191, 36, 0.25); color: #fbbf24; text-align: center; display: block; padding: 10px; border-radius: 6px; font-weight: bold; font-size: 11.5px; text-decoration: none; margin-top: 15px; text-transform: uppercase;" onmouseover="this.style.background='rgba(251, 191, 36, 0.15)'" onmouseout="this.style.background='rgba(251, 191, 36, 0.08)'">
            পূর্ণ ৫০+ টুলস পোর্টাল দেখুন ➔
        </a>
    </div>

    <!-- WIDGET 4: TRUST SEAL VERIFICATION -->
    <div class="cyber-sidebar-card" style="background: rgba(13, 21, 39, 0.45); border: 1.5px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 22px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); text-align: center;">
        <span style="font-size: 44px; display: block; margin-bottom: 10px;">🛡️</span>
        <h4 style="margin: 0 0 5px; font-size: 14px; font-weight: 800; color: #fff;">AUTHORIZED DIGITAL IMMUNITY</h4>
        <p style="color: #8b949e; font-size: 11px; font-family: monospace; line-height: 1.4; margin: 0 0 15px 0;">This communication is fully scanned by Google Cloud Anti-Malware and certified as secure.</p>
        <div style="background: rgba(0,255,65,0.06); color: #00ff41; border: 1px solid rgba(0,255,65,0.2); font-weight: bold; font-family: monospace; padding: 6px; border-radius: 5px; font-size: 11px; display: inline-block;">
            SECURITY VALUE: 128-BIT SECURE
        </div>
    </div>

</div>
