<?php
/**
 * Module: Cyber Social Action Hub
 * Description: Zero-code ultra-optimized cyber social media engagement center with caching, mobile app intent routing, automated hook injection, widgets, and settings API.
 * Version: 2.0.40
 * Author: Elite WordPress AI Developer
 */

if (!defined('ABSPATH')) exit;

/* ==========================================================================
   1. REGISTRATION OF THE SETTINGS API & CONTROL PANEL
   ========================================================================== */
add_action('admin_menu', function () {
    add_options_page(
        'Cyber Social Hub Settings',
        '🔌 Cyber Social Hub',
        'manage_options',
        'cyber-social-hub',
        'cyber_social_hub_page'
    );
});

add_action('admin_init', function () {
    register_setting('cyber_social_hub_group', 'cyber_social_hub_enabled', 'intval');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_inject_single', 'intval');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_inject_footer', 'intval');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_inject_archive', 'intval');
    
    register_setting('cyber_social_hub_group', 'cyber_social_hub_yt_api_key', 'sanitize_text_field');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_yt_channel_id', 'sanitize_text_field');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_fb_token', 'sanitize_text_field');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_fb_page_id', 'sanitize_text_field');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_fb_group_id', 'sanitize_text_field');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_tt_username', 'sanitize_text_field');
    register_setting('cyber_social_hub_group', 'cyber_social_hub_personal_fb_url', 'esc_url_raw');
});

// Admin Panel Layout
function cyber_social_hub_page() {
    $neon_main = esc_attr(get_option('ilybd_main_color', '#00ff41'));
    
    // Clear Transient Button Handler
    if (isset($_POST['cyber_hub_clear_cache'])) {
        delete_transient('cyber_social_hub_cached_metrics');
        echo '<div class="notice notice-info is-dismissible" style="border-left-color:#00f0ff; background:#111; color:#fff;"><p><b>Cyber Cache Flushed Successfully!</b> Fresh data will compile on the next frontend request.</p></div>';
    }
    
    $enabled        = get_option('cyber_social_hub_enabled', 1);
    $inject_single  = get_option('cyber_social_hub_inject_single', 1);
    $inject_footer  = get_option('cyber_social_hub_inject_footer', 0);
    $inject_archive = get_option('cyber_social_hub_inject_archive', 0);
    
    $yt_key     = get_option('cyber_social_hub_yt_api_key', '');
    $yt_chan    = get_option('cyber_social_hub_yt_channel_id', '');
    $fb_token   = get_option('cyber_social_hub_fb_token', '');
    $fb_page    = get_option('cyber_social_hub_fb_page_id', '');
    $fb_group   = get_option('cyber_social_hub_fb_group_id', '');
    $tt_user    = get_option('cyber_social_hub_tt_username', '');
    $fb_profile = get_option('cyber_social_hub_personal_fb_url', '');
    ?>
    <style>
        .cyber-admin-wrap {
            background: #070b13; color: #cbd5e1; padding: 40px;
            border-radius: 16px; border: 1.5px solid rgba(0, 240, 255, 0.2);
            max-width: 900px; margin-top: 25px; box-shadow: 0 15px 45px rgba(0,0,0,0.8);
            font-family: 'Space Grotesk', -apple-system, sans-serif;
        }
        .cyber-admin-header {
            border-bottom: 2px solid rgba(0, 240, 255, 0.15);
            padding-bottom: 20px; margin-bottom: 30px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .cyber-admin-title {
            margin: 0; font-size: 26px; font-weight: 900; letter-spacing: 1px;
            background: linear-gradient(135deg, #00f0ff, #bd00ff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .cyber-admin-status {
            background: rgba(0, 255, 65, 0.1); color: #00ff41;
            border: 1px solid rgba(0, 255, 65, 0.3); padding: 5px 12px;
            border-radius: 6px; font-size: 11px; font-weight: 800; font-family: monospace;
        }
        .cyber-section-card {
            background: rgba(13, 21, 39, 0.6); border: 1.5px solid rgba(255,255,255,0.05);
            border-radius: 12px; padding: 25px; margin-bottom: 25px;
            transition: all 0.3s ease;
        }
        .cyber-section-card:hover {
            border-color: rgba(0, 240, 255, 0.15);
            box-shadow: 0 5x 20px rgba(0,240,255,0.04);
        }
        .cyber-section-card h2 {
            margin-top: 0; font-size: 18px; font-weight: 800; color: #fff;
            display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.06);
            padding-bottom: 10px; margin-bottom: 20px;
        }
        .form-table th { color: #f0f6fc; font-weight: 700; width: 230px; }
        .cyber-input {
            width: 100%; max-width: 450px;
            background: #02060f !important; color: #00f0ff !important;
            border: 1.5px solid rgba(255, 255, 255, 0.08) !important; border-radius: 8px !important;
            padding: 10px 14px !important; font-family: 'JetBrains Mono', monospace; font-size: 13px;
            transition: all 0.3s;
        }
        .cyber-input:focus {
            border-color: #00f0ff !important;
            box-shadow: 0 0 12px rgba(0, 240, 255, 0.3) !important;
        }
        .cyber-description {
            color: #64748b; font-size: 12px; display: block; margin-top: 6px;
            line-height: 1.4;
        }
        .submit-btn-cyan {
            background: linear-gradient(135deg, #00f0ff 0%, #0099ff 100%) !important;
            color: #02060f !important; border: none !important;
            padding: 14px 35px !important; border-radius: 8px !important;
            font-weight: 950 !important; text-transform: uppercase; cursor: pointer;
            box-shadow: 0 8px 24px rgba(0, 240, 255, 0.25) !important;
            transition: all 0.3s ease !important;
        }
        .submit-btn-cyan:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 240, 255, 0.4) !important;
        }
        .btn-secondary-flush {
            background: rgba(239, 68, 68, 0.1) !important; border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #ef4444 !important; font-size: 11px !important; font-weight: 800 !important;
            padding: 6px 14px !important; border-radius: 6px !important; cursor: pointer;
        }
        .btn-secondary-flush:hover {
            background: #ef4444 !important; color: #fff !important;
        }
        .glow-accent-dot {
            width: 8px; height: 8px; border-radius: 50%; display: inline-block;
        }
    </style>

    <div class="wrap">
        <div class="cyber-admin-wrap">
            <div class="cyber-admin-header">
                <div>
                    <h1 class="cyber-admin-title">⚡ Cyber Social Action Hub</h1>
                    <p style="color:#64748b; margin: 4px 0 0 0; font-size: 13px;">নিখুঁত এপিআই অর্কেস্ট্রেশন, ট্রানজিয়েন্ট ক্যাশিং এবং মোবাইল ডিপ-লিঙ্কিং টেকনোলজি মডিউল।</p>
                </div>
                <div class="cyber-admin-status">COUPLED ACTIVE</div>
            </div>

            <form method="post" action="options.php">
                <?php settings_fields('cyber_social_hub_group'); ?>
                
                <!-- 📡 SECTION 1: GLOBAL CONTROL & INJECTIONS -->
                <div class="cyber-section-card">
                    <h2><span class="glow-accent-dot" style="background:#00f0ff; box-shadow:0 0 8px #00f0ff;"></span> গ্লোবাল হুক ইনজেকশন কন্ট্রোল (Hooks Activation)</h2>
                    <table class="form-table">
                        <tr>
                            <th>Master Switch Toggle</th>
                            <td>
                                <input type="checkbox" name="cyber_social_hub_enabled" value="1" <?php checked($enabled, 1); ?> style="accent-color:#00f0ff; transform: scale(1.3);" />
                                <b style="color: #fff; margin-left: 10px;">সম্পূর্ণ সোশ্যাল হাব চালু রাখুন (Activate Hub Site-Wide)</b>
                                <span class="cyber-description">টিক মার্ক তুলে দিলে সমস্ত প্রকার অটো-ইনজেকশন ও উইজেট প্যানেল ব্যাকগ্রাউন্ডে বন্ধ হয়ে যাবে।</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Auto-inject Single Posts</th>
                            <td>
                                <input type="checkbox" name="cyber_social_hub_inject_single" value="1" <?php checked($inject_single, 1); ?> style="accent-color:#bd00ff; transform: scale(1.3);" />
                                <b style="color: #fff; margin-left: 10px;">পোস্ট শেষে অটো-ইনজেক্ট করুন (Single Posts Content End)</b>
                                <span class="cyber-description">সিঙ্গেল আর্টিকেলগুলোর (`single.php`) বিষয়বস্তু শেষ হবার সাথে সাথে চমৎকার গ্লাস ডক হাবটি সংযুক্ত হবে।</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Auto-inject Global Footer</th>
                            <td>
                                <input type="checkbox" name="cyber_social_hub_inject_footer" value="1" <?php checked($inject_footer, 1); ?> style="accent-color:#00ff41; transform: scale(1.3);" />
                                <b style="color: #fff; margin-left: 10px;">বৈশ্বিক ফুটারে অটো-ইনজেক্ট করুন (wp_footer Injection Hook)</b>
                                <span class="cyber-description">সমস্ত পেজের একদম ফুটারে সাইড-বাই-সাইড গ্লাস এডিটর প্যানেল শো করাবে।</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Auto-inject Archive Loop</th>
                            <td>
                                <input type="checkbox" name="cyber_social_hub_inject_archive" value="1" <?php checked($inject_archive, 1); ?> style="accent-color:#ff9e00; transform: scale(1.3);" />
                                <b style="color: #fff; margin-left: 10px;">আর্কাইভ বা ক্যাটাগরি লুপ শেষে (Grid Loop End Hook)</b>
                                <span class="cyber-description">হোমপেজ বা ক্যাটাগরি পেজে পোস্ট গ্রিড শেষের সংলগ্ন এরিয়ায় উইজেট রেন্ডার করাবে।</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- 🔑 SECTION 2: API CREDENTIALS CENTRAL -->
                <div class="cyber-section-card">
                    <h2><span class="glow-accent-dot" style="background:#ff0055; box-shadow:0 0 8px #ff0055;"></span> এপিআই ক্রেডেনশিয়াল হাব (Dynamic API Credentials)</h2>
                    <p style="font-size: 12.5px; color:#94a3b8; margin-top:-10px; margin-bottom: 20px;">বাস্তব স্ট্যাটিস্টিক্স (Real-time stats) প্রদর্শন করার জন্য এপিআই কী-সমূহ যুক্ত করুন। কী অনুপস্থিত থাকলে স্মার্ট ডেমো ডাটা প্রদর্শিত হবে।</p>
                    
                    <table class="form-table">
                        <tr>
                            <th>YouTube API Key (v3)</th>
                            <td>
                                <input type="password" name="cyber_social_hub_yt_api_key" class="cyber-input" value="<?php echo esc_attr($yt_key); ?>" placeholder="AIzaSy..." />
                                <span class="cyber-description">গুগল ক্লাউড কনসোল থেকে জেনারেট করা YouTube Data API v3 কী।</span>
                            </td>
                        </tr>
                        <tr>
                            <th>YouTube Channel ID</th>
                            <td>
                                <input type="text" name="cyber_social_hub_yt_channel_id" class="cyber-input" value="<?php echo esc_attr($yt_chan); ?>" placeholder="UC..." />
                                <span class="cyber-description">আপনার অফিশিয়াল চ্যানেলের ইউনিক ২১ সংখ্যার আইডি।</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Facebook Graphics API Token</th>
                            <td>
                                <input type="password" name="cyber_social_hub_fb_token" class="cyber-input" value="<?php echo esc_attr($fb_token); ?>" placeholder="EAAb..." />
                                <span class="cyber-description">পেইজ ডাটা রিড করার পার্মানেন্ট পেইজ এক্সেস টোকেন (Page Access Token).</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Facebook Page ID</th>
                            <td>
                                <input type="text" name="cyber_social_hub_fb_page_id" class="cyber-input" value="<?php echo esc_attr($fb_page); ?>" placeholder="10008..." />
                                <span class="cyber-description">আপনার ফেসবুক ফ্যান পেজের নিউমেরিক আইডি বা ইউনিভার্সাল স্লাগ।</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Facebook Group ID</th>
                            <td>
                                <input type="text" name="cyber_social_hub_fb_group_id" class="cyber-input" value="<?php echo esc_attr($fb_group); ?>" placeholder="1742..." />
                                <span class="cyber-description">মেম্বার সংখ্যা ট্র্যাক করতে ফেসবুক কমিউনিটি বা হেল্পডেস্ক গ্রুপের আইডি।</span>
                            </td>
                        </tr>
                        <tr>
                            <th>TikTok Profile Username</th>
                            <td>
                                <input type="text" name="cyber_social_hub_tt_username" class="cyber-input" value="<?php echo esc_attr($tt_user); ?>" placeholder="iloveyoubd" />
                                <span class="cyber-description">টিকটক হ্যান্ডেল ইউজারনেম (অ্যাট-চিহ্ন `@` ব্যতীত)।</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Personal Facebook Profile URL</th>
                            <td>
                                <input type="url" name="cyber_social_hub_personal_fb_url" class="cyber-input" value="<?php echo esc_attr($fb_profile); ?>" placeholder="https://facebook.com/..." />
                                <span class="cyber-description">আপনার ব্যহতিগত বা এডমিন প্রোফাইলের ডিরেক্ট ওয়েব লিঙ্ক।</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="margin-top: 30px; display: flex; align-items: center; justify-content: space-between;">
                    <input type="submit" name="submit" class="submit-btn-cyan" value="⚡ Save Cyber configurations" />
                    
                    <!-- Flush Cache Button -->
                    <button type="submit" name="cyber_hub_clear_cache" class="btn-secondary-flush" formnovalidate>⚡ Flush API Transients Cache</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}

/* ==========================================================================
   2. DYNAMIC API COUPLING & TRANSITIONAL PERFORMANCE CACHING (12 HOURS)
   ========================================================================== */
function cyber_social_hub_format_metrics($num) {
    if (!is_numeric($num)) return $num;
    if ($num >= 1000000) {
        return round($num / 1000000, 1) . 'M+';
    }
    if ($num >= 100000) {
        return round($num / 100000, 1) . 'L+'; // Lakh
    }
    if ($num >= 1000) {
        return round($num / 1000, 1) . 'K+';
    }
    return $num . '+';
}

function cyber_social_hub_get_cached_data() {
    $cache_key = 'cyber_social_hub_cached_metrics';
    $cached = get_transient($cache_key);
    
    if ($cached !== false) {
        return $cached;
    }

    // High quality SEO-centric fallback metrics to respect Google AdSense policy & look highly professional
    $metrics = [
        'yt_title'       => 'I Love You BD Official',
        'yt_avatar'      => '',
        'yt_subs'        => '142K+',
        'yt_views'       => '3.5M+',
        'fb_page_title'  => 'I Love You BD Facebook Page',
        'fb_page_avatar' => '',
        'fb_page_likes'  => '151K+ Followers',
        'fb_group_title' => 'আই লাভ ইউ বিডি হেল্পডেস্ক',
        'fb_group_m_num' => '5.6L+ Members',
        'tt_followers'   => '210K+ Fans',
    ];

    $yt_key     = get_option('cyber_social_hub_yt_api_key', '');
    $yt_chan    = get_option('cyber_social_hub_yt_channel_id', '');
    $fb_token   = get_option('cyber_social_hub_fb_token', '');
    $fb_page    = get_option('cyber_social_hub_fb_page_id', '');
    $fb_group   = get_option('cyber_social_hub_fb_group_id', '');
    $tt_user    = get_option('cyber_social_hub_tt_username', '');

    // YouTube Live Metrics
    if ($yt_key && $yt_chan) {
        $yt_url = "https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=" . urlencode($yt_chan) . "&key=" . urlencode($yt_key);
        $yt_response = wp_remote_get($yt_url, ['timeout' => 4]);
        
        if (!is_wp_error($yt_response) && wp_remote_retrieve_response_code($yt_response) === 200) {
            $data = json_decode(wp_remote_retrieve_body($yt_response), true);
            if (!empty($data['items'][0])) {
                $chan_info = $data['items'][0];
                if (!empty($chan_info['snippet']['title'])) {
                    $metrics['yt_title'] = sanitize_text_field($chan_info['snippet']['title']);
                }
                if (!empty($chan_info['snippet']['thumbnails']['default']['url'])) {
                    $metrics['yt_avatar'] = esc_url_raw($chan_info['snippet']['thumbnails']['default']['url']);
                }
                if (!empty($chan_info['statistics']['subscriberCount'])) {
                    $metrics['yt_subs'] = cyber_social_hub_format_metrics(intval($chan_info['statistics']['subscriberCount']));
                }
                if (!empty($chan_info['statistics']['viewCount'])) {
                    $metrics['yt_views'] = cyber_social_hub_format_metrics(intval($chan_info['statistics']['viewCount'])) . ' Views';
                }
            }
        }
    }

    // Facebook Page Live Metrics
    if ($fb_token && $fb_page) {
        $fb_url = "https://graph.facebook.com/v18.0/" . urlencode($fb_page) . "?fields=fan_count,name,picture{url}&access_token=" . urlencode($fb_token);
        $fb_response = wp_remote_get($fb_url, ['timeout' => 4]);
        
        if (!is_wp_error($fb_response) && wp_remote_retrieve_response_code($fb_response) === 200) {
            $data = json_decode(wp_remote_retrieve_body($fb_response), true);
            if (!empty($data['name'])) {
                $metrics['fb_page_title'] = sanitize_text_field($data['name']);
            }
            if (!empty($data['picture']['data']['url'])) {
                $metrics['fb_page_avatar'] = esc_url_raw($data['picture']['data']['url']);
            }
            if (!empty($data['fan_count'])) {
                $metrics['fb_page_likes'] = cyber_social_hub_format_metrics(intval($data['fan_count'])) . ' Followers';
            }
        }
    }

    // Facebook Group Live Metrics
    if ($fb_token && $fb_group) {
        $fb_g_url = "https://graph.facebook.com/v18.0/" . urlencode($fb_group) . "?fields=member_count,name&access_token=" . urlencode($fb_token);
        $fb_g_response = wp_remote_get($fb_g_url, ['timeout' => 4]);
        
        if (!is_wp_error($fb_g_response) && wp_remote_retrieve_response_code($fb_g_response) === 200) {
            $data = json_decode(wp_remote_retrieve_body($fb_g_response), true);
            if (!empty($data['name'])) {
                $metrics['fb_group_title'] = sanitize_text_field($data['name']);
            }
            if (!empty($data['member_count'])) {
                $metrics['fb_group_m_num'] = cyber_social_hub_format_metrics(intval($data['member_count'])) . ' Members';
            }
        }
    }

    // Transient Cache structured data for exactly 12 hours
    set_transient($cache_key, $metrics, 12 * HOUR_IN_SECONDS);
    return $metrics;
}

/* ==========================================================================
   3. RESPONSIVE RENDER ENGINE (BENTO LAYOUT WITH TRANSPECT GLASS DESIGN)
   ========================================================================== */
function cyber_social_hub_render_html() {
    if (!get_option('cyber_social_hub_enabled', 1)) return '';
    
    $m = cyber_social_hub_get_cached_data();
    
    // Links & Defaults
    $yt_link  = get_option('ilybd_social_youtube', 'https://youtube.com/@iloveyoubd');
    $fb_page  = get_option('ilybd_social_facebook', 'https://facebook.com/iloveyoubd');
    $fb_group = get_option('ilybd_social_fb_group', 'https://facebook.com/groups/iloveyoubd');
    $tt_user  = get_option('cyber_social_hub_tt_username', 'iloveyoubd');
    $tt_link  = 'https://tiktok.com/@' . esc_attr($tt_user);
    $personal_fb = get_option('cyber_social_hub_personal_fb_url', 'https://facebook.com/iloveyoubd');
    
    $yt_chan_id = get_option('cyber_social_hub_yt_channel_id', '');
    $fb_page_id  = get_option('cyber_social_hub_fb_page_id', '');
    $fb_group_id = get_option('cyber_social_hub_fb_group_id', '');
    
    // Core Mobile Intent Deep Links
    $yt_intent = !empty($yt_chan_id) ? "vnd.youtube://www.youtube.com/channel/" . esc_attr($yt_chan_id) : "vnd.youtube://www.youtube.com/user/iloveyoubd";
    $fb_page_intent = !empty($fb_page_id) ? "fb://page/" . esc_attr($fb_page_id) : "fb://facewebmodal/f?href=" . urlencode($fb_page);
    $fb_group_intent = !empty($fb_group_id) ? "fb://group/" . esc_attr($fb_group_id) : "fb://facewebmodal/f?href=" . urlencode($fb_group);
    $tt_intent = "snssdk1128://user/profile/" . esc_attr($tt_user);
    
    ob_start();
    ?>
    <div class="cyber-hub-outer-box">
        <div class="cyber-hub-inner-grid">
            
            <!-- LEFT CARD: ACTIVE BROADCAST YOUTUBE MASTER MODULE -->
            <div class="cyber-hub-tile yt-glow-border">
                <div class="cyber-tile-header">
                    <div class="cyber-tile-title-row">
                        <span class="cyber-logo-icon yt-red-pulse"><i class="fa-brands fa-youtube"></i></span>
                        <div class="title-meta">
                            <h3><?php echo esc_html($m['yt_title']); ?></h3>
                            <span class="title-sub">ইউটিউব অফিশিয়াল ব্রডকাস্ট স্টেশন</span>
                        </div>
                    </div>
                    <div class="cyber-badge-live">LIVE NODES</div>
                </div>
                
                <div class="cyber-tile-body">
                    <!-- Elegant Channel Stats Box -->
                    <div class="yt-status-showcase">
                        <div class="yt-stats-radial">
                            <?php if (!empty($m['yt_avatar'])): ?>
                                <img src="<?php echo esc_url($m['yt_avatar']); ?>" alt="YouTube Avatar" class="yt-img-avatar" referrerPolicy="no-referrer" />
                            <?php else: ?>
                                <div class="yt-fallback-avatar"><i class="fa-solid fa-bell"></i></div>
                            <?php endif; ?>
                            <div class="yt-numerical-info">
                                <span class="radial-count text-yt-pink"><?php echo esc_html($m['yt_subs']); ?></span>
                                <span class="radial-desc">ACTIVE SUBSCRIBERS</span>
                            </div>
                        </div>
                        <div class="channel-utility-grid">
                            <span class="utility-metric-label"><i class="fa-solid fa-play"></i> <?php echo esc_html($m['yt_views']); ?></span>
                            <span class="utility-metric-label"><i class="fa-solid fa-server font-emerald"></i> SYSTEM VERIFIED</span>
                        </div>
                    </div>
                </div>
                
                <div class="cyber-tile-footer">
                    <a href="<?php echo esc_url($yt_link . '?sub_confirmation=1'); ?>" 
                       data-app-uri="<?php echo esc_attr($yt_intent); ?>" 
                       target="_blank" 
                       class="cyber-action-button button-yt intent-btn">
                        <span class="button-edge"></span>
                        <span class="button-label-text"><i class="fa-solid fa-bell"></i> চ্যানেলটি সাবস্ক্রাইব করুন</span>
                    </a>
                </div>
            </div>
            
            <!-- RIGHT VERTICAL FLEX MODULE: FACEBOOK PAGES, GROUP, TIKTOK -->
            <div class="cyber-hub-secondary-col">
                
                <!-- FB PAGE NODE -->
                <div class="cyber-mini-item fb-glow-border">
                    <div class="mini-icon-box bg-fb"><i class="fa-brands fa-facebook-f"></i></div>
                    <div class="mini-info-main">
                        <div class="mini-title-bar">
                            <div class="title-wrapper">
                                <h3><?php echo esc_html($m['fb_page_title']); ?></h3>
                                <span class="mini-count-pill"><?php echo esc_html($m['fb_page_likes']); ?></span>
                            </div>
                        </div>
                        <p class="mini-desc-bn">সরাসরি আপডেট টিপস, টেকনিক্যাল ফাইল ও ফ্রী নেট লিংক মেম্বার সোর্স দেখতে ফলো করুন অল্টারনেটিভ মোড।</p>
                        <div class="mini-actions-row">
                            <a href="<?php echo esc_url($fb_page); ?>" 
                               data-app-uri="<?php echo esc_attr($fb_page_intent); ?>" 
                               target="_blank" 
                               class="mini-solid-btn btn-fb-cyan intent-btn"><i class="fa-solid fa-thumbs-up"></i> পেজে যুক্ত থাকুন</a>
                        </div>
                    </div>
                </div>

                <!-- FB GROUP NODE -->
                <div class="cyber-mini-item group-glow-border">
                    <div class="mini-icon-box bg-group"><i class="fa-solid fa-users"></i></div>
                    <div class="mini-info-main">
                        <div class="mini-title-bar">
                            <div class="title-wrapper">
                                <h3><?php echo esc_html($m['fb_group_title']); ?></h3>
                                <span class="mini-count-pill cap-emerald"><?php echo esc_html($m['fb_group_m_num']); ?></span>
                            </div>
                        </div>
                        <p class="mini-desc-bn">যেকোনো টেক সমস্যায় তাৎক্ষনিক ৫ লক্ষ প্লাস বাংলাদেশী প্রফেশনাল মেম্বার ও অ্যাডমিন মডারেটরদের হেল্পিং সাপোর্ট গ্রুপ।</p>
                        <div class="mini-actions-row">
                            <a href="<?php echo esc_url($fb_group); ?>" 
                               data-app-uri="<?php echo esc_attr($fb_group_intent); ?>" 
                               target="_blank" 
                               class="mini-solid-btn btn-group-emerald intent-btn"><i class="fa-solid fa-circle-nodes"></i> হেল্পডেস্কে জয়েন করুন</a>
                        </div>
                    </div>
                </div>

                <!-- TIKTOK QUICK NODE -->
                <div class="cyber-mini-item tt-glow-border">
                    <div class="mini-icon-box bg-tt"><i class="fa-brands fa-tiktok"></i></div>
                    <div class="mini-info-main">
                        <div class="mini-title-bar">
                            <div class="title-wrapper">
                                <h3>টিকটক শর্ট ভিডিও কালেকশন</h3>
                                <span class="mini-count-pill cap-tt"><?php echo esc_html($m['tt_followers']); ?></span>
                            </div>
                        </div>
                        <p class="mini-desc-bn">দ্রুত ও সংক্ষিপ্ত শিক্ষনীয় ভিডিও টিউটোরিয়াল ও চমৎকার ট্রিকস সিক্রেট সোর্স অ্যাক্সেস ফলো রাখুন।</p>
                        <div class="mini-actions-row">
                            <a href="<?php echo esc_url($tt_link); ?>" 
                               data-app-uri="<?php echo esc_attr($tt_intent); ?>" 
                               target="_blank" 
                               class="mini-solid-btn btn-tt-pink intent-btn"><i class="fa-solid fa-bolt"></i> প্রোফাইল সাবস্ক্রিপশন</a>
                            <?php if (!empty($personal_fb)): ?>
                                <a href="<?php echo esc_url($personal_fb); ?>" target="_blank" class="mini-outline-btn"><i class="fa-solid fa-user-shield"></i> অ্যাডমিন আইডি</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
    
    <!-- EXQUISITE 2040 TRANSPECT STYLINGS -->
    <style>
        .cyber-hub-outer-box {
            width: 100%;
            margin: 30px auto;
            border-radius: 20px;
            background: rgba(8, 12, 23, 0.72) !important;
            border: 1.5px solid rgba(0, 240, 255, 0.16) !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            padding: 24px;
            box-shadow: 0 16px 45px rgba(0,0,0,0.7), inset 0 0 20px rgba(0, 240, 255, 0.04);
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }
        
        .cyber-hub-inner-grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 24px;
        }
        
        /* Bento Tiles Custom Glass */
        .cyber-hub-tile {
            background: linear-gradient(135deg, rgba(10, 15, 30, 0.6) 0%, rgba(5, 7, 15, 0.8) 100%) !important;
            border: 1.5px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }
        
        .yt-glow-border:hover {
            border-color: rgba(255, 0, 51, 0.35);
            box-shadow: 0 10px 30px rgba(255, 0, 51, 0.12), inset 0 0 15px rgba(255, 0, 51, 0.05) !important;
            transform: translateY(-2px);
        }
        
        .cyber-tile-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .cyber-tile-title-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .cyber-logo-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .yt-red-pulse {
            background: rgba(255, 0, 51, 0.1);
            border: 1px solid rgba(255,0,51,0.25);
            color: #ff0033;
            animation: pulseYTRed 2s infinite ease-in-out;
        }
        
        @keyframes pulseYTRed {
            0%, 100% { box-shadow: 0 0 5px rgba(255,0,51,0.2); }
            50% { box-shadow: 0 0 15px rgba(255,0,51,0.6); }
        }
        
        .title-meta h3 {
            margin: 0;
            font-size: 15.5px;
            font-weight: 850;
            color: #ffffff;
            font-family: 'Space Grotesk', sans-serif;
        }
        
        .title-sub {
            font-size: 10px;
            color: #64748b;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .cyber-badge-live {
            background: rgba(0, 240, 255, 0.08);
            border: 1px solid rgba(0,240,255,0.25);
            color: #00f0ff;
            font-size: 8.5px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 900;
            padding: 3px 8px;
            border-radius: 4px;
        }
        
        .yt-status-showcase {
            background: rgba(4, 7, 18, 0.5);
            border: 1px solid rgba(255,255,255,0.04);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }
        
        .yt-stats-radial {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
        }
        
        .yt-img-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 2px solid rgba(255, 0, 51, 0.4);
            box-shadow: 0 0 10px rgba(255,0,51,0.2);
            object-fit: cover;
        }
        
        .yt-fallback-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #ff0033;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .yt-numerical-info {
            display: flex;
            flex-direction: column;
        }
        
        .radial-count {
            font-size: 24px;
            font-weight: 950;
            font-family: 'JetBrains Mono', monospace;
        }
        
        .text-yt-pink {
            color: #ff0055;
            text-shadow: 0 0 12px rgba(255, 0, 85, 0.4);
        }
        
        .radial-desc {
            font-size: 9px;
            color: #64748b;
            font-weight: 800;
            letter-spacing: 0.8px;
        }
        
        .channel-utility-grid {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            border-top: 1px solid rgba(255,255,255,0.05);
            padding-top: 12px;
        }
        
        .utility-metric-label {
            background: rgba(30, 41, 59, 0.4);
            border: 1.5px solid rgba(255,255,255,0.06);
            color: #cbd5e1;
            font-size: 10px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-family: 'JetBrains Mono', monospace;
        }
        
        /* Right Secondary Column Mini items */
        .cyber-hub-secondary-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .cyber-mini-item {
            display: flex;
            gap: 16px;
            background: linear-gradient(135deg, rgba(8, 12, 23, 0.5) 0%, rgba(4, 6, 12, 0.7) 100%) !important;
            border: 1.5px solid rgba(255,255,255,0.04);
            border-radius: 14px;
            padding: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        .fb-glow-border:hover { border-color: rgba(24, 119, 242, 0.3); box-shadow: 0 8px 24px rgba(24, 119, 242, 0.08); transform: translateY(-1px); }
        .group-glow-border:hover { border-color: rgba(16, 185, 129, 0.3); box-shadow: 0 8px 24px rgba(16, 185, 129, 0.08); transform: translateY(-1px); }
        .tt-glow-border:hover { border-color: rgba(0, 240, 255, 0.25); box-shadow: 0 8px 24px rgba(0, 240, 255, 0.08); transform: translateY(-1px); }
        
        .mini-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4);
        }
        
        .bg-fb { background: #1877f2; }
        .bg-group { background: #10b981; }
        .bg-tt { background: radial-gradient(circle at 100% 0%, #00f0ff 0%, #ff0550 100%); }
        
        .mini-info-main {
            flex: 1;
        }
        
        .mini-title-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        
        .title-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .mini-title-bar h3 {
            margin: 0;
            font-size: 14px;
            font-weight: 850;
            color: #ffffff;
            font-family: 'Space Grotesk', sans-serif;
        }
        
        .mini-count-pill {
            background: rgba(24, 119, 242, 0.08);
            border: 1.5px solid rgba(24, 119, 242, 0.25);
            color: #00ccff;
            font-size: 9.5px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            padding: 2.5px 7px;
            border-radius: 6px;
        }
        
        .mini-count-pill.cap-emerald {
            background: rgba(16, 185, 129, 0.08);
            border-color: rgba(16, 185, 129, 0.25);
            color: #34d399;
        }
        
        .mini-count-pill.cap-tt {
            background: rgba(0, 240, 255, 0.08);
            border-color: rgba(0, 240, 255, 0.2);
            color: #00f0ff;
        }
        
        .mini-desc-bn {
            font-family: 'Hind Siliguri', sans-serif;
            font-size: 11.5px !important;
            line-height: 1.55 !important;
            color: #94a3b8 !important;
            margin: 0 0 10px 0 !important;
        }
        
        .mini-actions-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        /* Fast Cyber Buttons */
        .cyber-action-button {
            width: 100%;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 13px;
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .button-yt {
            background: linear-gradient(135deg, #ff0055 0%, #cc0000 100%);
            box-shadow: 0 4px 15px rgba(255, 0, 85, 0.35);
        }
        
        .button-yt:hover {
            opacity: 0.95;
            background: #ff0033;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(255, 0, 51, 0.5);
        }
        
        .mini-solid-btn {
            text-decoration: none !important;
            font-size: 11px;
            font-weight: 900;
            padding: 6.5px 14px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #ffffff !important;
            transition: all 0.2s ease;
        }
        
        .btn-fb-cyan {
            background: #1877f2;
            box-shadow: 0 3px 12px rgba(24, 119, 242, 0.25);
        }
        .btn-fb-cyan:hover { background: #1263d2; box-shadow: 0 6px 18px rgba(24, 119, 242, 0.4); }
        
        .btn-group-emerald {
            background: #10b981;
            box-shadow: 0 3px 12px rgba(16, 185, 129, 0.25);
        }
        .btn-group-emerald:hover { background: #0c9c6d; box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4); }
        
        .btn-tt-pink {
            background: #ff0055;
            box-shadow: 0 3px 12px rgba(255, 0, 85, 0.25);
        }
        .btn-tt-pink:hover { background: #d60047; box-shadow: 0 6px 18px rgba(255, 0, 85, 0.4); }
        
        .mini-outline-btn {
            text-decoration: none !important;
            color: #94a3b8 !important;
            background: rgba(255,255,255,0.01);
            border: 1px solid rgba(255,255,255,0.08);
            font-size: 10px;
            font-weight: 800;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .mini-outline-btn:hover {
            color: #ffffff !important;
            border-color: rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.04);
        }
        
        /* DEVICES RESPONSIVENESS OVERRIDES */
        @media (max-width: 900px) {
            .cyber-hub-inner-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .cyber-hub-outer-box {
                padding: 16px;
                border: 1px solid rgba(0, 240, 255, 0.1) !important;
            }
            .cyber-tile-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .cyber-mini-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .mini-icon-box {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }
            .mini-title-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }
    </style>
    
    <!-- Mobile intent redirect layer fallbacks -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
        if (isMobile) {
            var intentBtns = document.querySelectorAll(".intent-btn");
            intentBtns.forEach(function(btn) {
                btn.addEventListener("click", function(e) {
                    var appUri = btn.getAttribute("data-app-uri");
                    var webUrl = btn.getAttribute("href");
                    if (appUri) {
                        e.preventDefault();
                        var start = Date.now();
                        window.location.href = appUri;
                        setTimeout(function() {
                            if (Date.now() - start < 1500) {
                                window.location.href = webUrl;
                            }
                        }, 1000);
                    }
                });
            });
        }
    });
    </script>
    <?php
    return ob_get_clean();
}

/* ==========================================================================
   4. WORDPRESS CORE HOOKS AUTO-INJECTION ENGINE
   ========================================================================== */

// 1. Hook cleanly into 'the_content' filter (Single Posts)
add_filter('the_content', function ($content) {
    if (is_single() && is_main_query() && get_option('cyber_social_hub_inject_single', 1)) {
        static $injected = false;
        if (!$injected) {
            $injected = true;
            $hub_html = cyber_social_hub_render_html();
            $content .= $hub_html;
        }
    }
    return $content;
});

// 2. Hook cleanly into 'wp_footer' (Global Footer)
add_action('wp_footer', function () {
    if (get_option('cyber_social_hub_inject_footer', 0)) {
        static $injected_footer = false;
        if (!$injected_footer) {
            $injected_footer = true;
            echo '<div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">';
            echo cyber_social_hub_render_html();
            echo '</div>';
        }
    }
});

// 3. Hook cleanly into loop end (Archived/Categories Grid View)
add_action('loop_end', function ($query) {
    if ($query->is_main_query() && !is_single() && get_option('cyber_social_hub_inject_archive', 0)) {
        static $injected_archive = false;
        if (!$injected_archive) {
            $injected_archive = true;
            echo cyber_social_hub_render_html();
        }
    }
});

/* ==========================================================================
   5. NATIVE WORDPRESS WIDGET SYSTEM
   ========================================================================== */
class Cyber_Social_Action_Hub_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'cyber_social_action_hub_widget',
            __('📡 Cyber Social Action Hub', 'ilybd-neon'),
            array('description' => __('পছন্দসই সাইডবারে এপিআই-ডিরেক্টেড এবং মোবাইল ইন্টেন্ট ইন্টিগ্রেটেড সোশ্যাল হাব শো করানোর জন্য।', 'ilybd-neon'))
        );
    }
    
    public function widget($args, $instance) {
        $enabled = get_option('cyber_social_hub_enabled', 1);
        if (!$enabled) return;
        
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        // Output social hub
        echo cyber_social_hub_render_html();
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('📡 Social Ecosystem', 'ilybd-neon');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Widget Title:', 'ilybd-neon'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p style="color:#64748b; font-size:12px; font-style:italic;">
            উইজেটের তথ্য এবং লিঙ্ক পরিবর্তন করতে "Settings > Cyber Social Hub" পেইজ থেকে পরিবর্তন করুন।
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

// Register Widget within widgets_init action
add_action('widgets_init', function() {
    register_widget('Cyber_Social_Action_Hub_Widget');
});

// Regsiter direct shortcode [cyber_social_hub] to load our module instantly on any block or custom place
add_shortcode('cyber_social_hub', function() {
    return cyber_social_hub_render_html();
});
