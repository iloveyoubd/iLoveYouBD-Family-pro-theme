<?php
/**
 * ILYBD Neon Pro - Cyber Security, Content Locking & Traffic Autopilot Safeguard v1
 * 
 * 1. Google AdSense Safe Interaction Systems
 * 2. Search Engine Crawler Friendly White-List check (SEO-First Smart Protection)
 * 3. Traffic Hijacking Defense & Advanced Scraper Block Core
 * 4. User Behavior Tracking & Predictive Homepage suggestion reordering
 * 5. Dynamic Power Tier mappings for Front-End AI Chatbots
 */

if (!defined('ABSPATH')) exit;

/* =========================================================================
   1. SEARCH ENGINE CRAWLER LOGIC (SEO-First White-List)
   ========================================================================= */
function ilybd_is_search_engine_crawler() {
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
    if (empty($ua)) {
        return false;
    }
    
    // Core indexing bots that must always bypass scraping gates for Google Top 10 indexing
    $search_bots = [
        'googlebot',
        'bingbot',
        'slurp',
        'duckduckbot',
        'baiduspider',
        'yandexbot',
        'sogou',
        'exabot',
        'facebot',
        'facebookexternalhit',
        'ia_archive',
        'google-co-op',
        'adsbot-google',
        'mediapartners-google',
        'google-inspectiontool',
        'google-other',
        'google-read-aloud',
        'apis-google',
        'adsbot'
    ];
    
    foreach ($search_bots as $bot) {
        if (strpos($ua, $bot) !== false) {
            return true;
        }
    }
    
    return false;
}

/* =========================================================================
   2. TRAFFIC HIJACKING & BAD SCRAPER DETECTION MODULE
   ========================================================================= */
function ilybd_is_malicious_scraper() {
    // If it's a whitelisted engine, it's not a malicious rogue bot
    if (ilybd_is_search_engine_crawler()) {
        return false;
    }

    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
    if (empty($ua)) {
        return true; // block blank user agents to secure assets
    }

    // AI Scraping Agents & Scraping libraries that drain server compute & steal content
    $bad_agents = [
        'gptbot', 'chatgpt-user', 'claudebot', 'cohere-ai', 'anthropic-ai', 
        'perplexitybot', 'imagesiftbot', 'omgili', 'bytespider', 'python-requests', 
        'guzzlehttp', 'curl', 'wget', 'scrapy', 'headlesschrome', 'selenium', 
        'puppeteer', 'postmanruntime', 'httpclient', 'node-fetch', 'java/'
    ];

    foreach ($bad_agents as $agent) {
        if (strpos($ua, $agent) !== false) {
            return true;
        }
    }

    return false;
}

// Intercept rogue scraper requests before executing expensive SQL queries (AdSense & SEO Booster)
add_action('send_headers', function() {
    if (ilybd_is_malicious_scraper()) {
        status_header(403);
        header('Content-Type: text/plain; charset=UTF-8');
        echo "💻 SYSTEM DETECTED UNAUTHORIZED AUTOMATION / BOT SCRAPING GATES ACTIVE\n\n";
        echo "[ERROR]: Your system signature matches an AI crawler, automated crawler, or rogue proxy, which drains community server resources.\n";
        echo "[RESOLUTION]: For API/Partners integration, contact developers on iloveyoubd.com directly. Search engine indexing bots are bypass authorized.\n";
        exit;
    }
});


/* =========================================================================
   3. SMART CONTENT LOCKING ENGINE (SPAM & ROBOT FREE ACCELERATORS)
   ========================================================================= */
add_filter('the_content', 'ilybd_secure_content_lock_filter', 98);
function ilybd_secure_content_lock_filter($content) {
    if (is_admin() || !is_single()) {
        return $content;
    }

    // Whitelist search engine crawling so Google can crawl and index downloadable resources and score high on core EEAT rankings
    if (ilybd_is_search_engine_crawler()) {
         return $content; 
    }

    // Registered users are fully authorized
    if (is_user_logged_in()) {
        return $content;
    }

    // Find and lock specifically restricted download links, download buttons, or zip/rar extensions
    // Matches anchors with target lock fields or pointing directly to zip, archive, app downloading resources
    $pattern = '/<a\s[^>]*href=["\']([^"\']+\.(?:zip|rar|exe|apk|dmg|pdf|tgz))["\'][^>]*>(.*?)<\/a>/is';
    
    $content = preg_replace_callback($pattern, function($matches) {
        $raw_url = $matches[1];
        $anchor_text = strip_tags($matches[2]);
        $login_url = wp_login_url(get_permalink());
        
        $lock_card = '
        <div class="ilybd-cyber-content-lock" style="margin: 25px auto; padding: 22px; background: #0b0f17; border: 1.5px dashed #ff3e3e; border-radius: 14px; position: relative; text-align: center; max-width: 580px; box-shadow: 0 0 20px rgba(255, 62, 62, 0.15); overflow: hidden;">
            <div style="font-size: 32px; color: #ff3e3e; margin-bottom: 12px; animation: cyberLockPulse 2s infinite ease-in-out;">
                <i class="fa-solid fa-lock" style="filter: drop-shadow(0 0 8px #ff3e3e);"></i>
            </div>
            <h4 style="font-family: \'Space Grotesk\', sans-serif; font-size: 16px; font-weight: 800; color: #fff; margin: 0 0 8px 0; letter-spacing: 0.5px; text-transform: uppercase;">
                🔒 Content Locked / কন্টেন্ট লক করা রয়েছে
            </h4>
            <p style="font-family: system-ui; font-size: 13px; color: #8b949e; line-height: 1.6; margin: 0 0 16px 0;">
                এই ডাইনামিক ডাউনলোড সোর্স বা প্রিমিয়াম ফাইলটি লক করা আছে। সম্পূর্ণ নিরাপদ এবং ঝামেলাহীন ডাইরেক্ট ডাউনলোড করতে অনুগ্রহ করে আমাদের সাইটে লগইন বা রেজিস্ট্রেশন করুন।
            </p>
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <a href="' . esc_url($login_url) . '" class="ilybd-lock-btn" style="background: #ff3e3e; color: #fff; font-family: \'Space Grotesk\', sans-serif; font-weight: 900; font-size: 12.5px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 22px; border-radius: 8px; text-decoration: none; box-shadow: 0 0 15px rgba(255, 62, 62, 0.3); transition: 0.3s; display: inline-flex; align-items: center; gap: 6px;" onmouseover="this.style.boxShadow=\'0 0 20px #ff3e3e\'; this.style.background=\'#ff5555\';" onmouseout="this.style.boxShadow=\'0 0 15px rgba(255,62,62,0.3)\'; this.style.background=\'#ff3e3e\';">
                    <i class="fa-solid fa-right-to-bracket"></i> লগইন করে আনলক করুন
                </a>
                <a href="' . esc_url(wp_registration_url() ?: home_url('/wp-login.php?action=register')) . '" class="ilybd-lock-btn" style="background: #0f172a; border: 1px solid #00f0ff; color: #00f0ff; font-family: \'Space Grotesk\', sans-serif; font-weight: 900; font-size: 12.5px; text-transform: uppercase; letter-spacing: 0.5px; padding: 10px 22px; border-radius: 8px; text-decoration: none; transition: 0.3s; display: inline-flex; align-items: center; gap: 6px;" onmouseover="this.style.boxShadow=\'0 0 15px #00f0ff\'; this.style.background=\'rgba(0, 240, 255, 0.05)\';" onmouseout="this.style.boxShadow=\'none\'; this.style.background=\'#0f172a\';">
                    <i class="fa-solid fa-user-plus"></i> ফ্রি রেজিস্ট্রেশন node
                </a>
            </div>
            <span style="display: block; font-family: \'JetBrains Mono\', monospace; font-size: 9px; color: #4e5661; margin-top: 14px; text-transform: uppercase; letter-spacing: 1px;">
                Secured via IBD Cyber Crypt Autopilot v3
            </span>
        </div>
        ';
        return $lock_card;
    }, $content);

    return $content;
}


/* =========================================================================
   4. CORE REWARDS THROTTLING (100% ADSENSE SAFETY / ZERO INVALID CLICKS)
   ========================================================================= */
// Intercept ilybd_update_user_economy to apply throttling of likes / comments tasks
// Users earn real balance, but we prevent bot loops trying to hit reward endpoints repeatedly
add_filter('ilybd_update_user_economy_auth', 'ilybd_safeguard_economy_throttling', 10, 4);
function ilybd_safeguard_economy_throttling($authorized, $user_id, $points_delta, $balance_delta) {
    if (!$user_id) return false;
    
    // Admins always bypass throttling checks
    if (user_can($user_id, 'manage_options')) {
        return true;
    }
    
    // Fetch last interactions timestamps to construct an anti-spam gate
    $now = time();
    $hourly_meta_key = '_ily_hourly_earning_hits_' . date('Y-m-d_H');
    $daily_meta_key  = '_ily_daily_earning_hits_' . date('Y-m-d');
    
    $hourly_hits = intval(get_user_meta($user_id, $hourly_meta_key, true));
    $daily_hits  = intval(get_user_meta($user_id, $daily_meta_key, true));
    
    // MAX 4 rewarded actions per hour (likes, comments, message posts)
    if ($hourly_hits >= 4) {
        return false; 
    }
    
    // MAX 15 rewarded actions per day (Prevents any potential suspicious traffic activity detected by automated AdSense Bots)
    if ($daily_hits >= 15) {
        return false;
    }
    
    // Update count metrics
    update_user_meta($user_id, $hourly_meta_key, $hourly_hits + 1);
    update_user_meta($user_id, $daily_meta_key, $daily_hits + 1);
    
    return true;
}


/* =========================================================================
   5. BEHAVIOR TRACKING & PREDICTIVE HOMEPAGE SUGGESTION REORDERING
   ========================================================================= */
// Cookie tracking: Stores category views of readers to rearrange the homepage
add_action('wp', 'ilybd_track_user_behavior_categories');
function ilybd_track_user_behavior_categories() {
    if (!is_single()) return;
    
    $categories = get_the_category();
    if (empty($categories)) return;
    
    $cat_slug = $categories[0]->slug;
    
    // Retrieve tracker from cookie, default is empty array
    $tracker = isset($_COOKIE['ilybd_interests_tracker']) ? json_decode(stripslashes($_COOKIE['ilybd_interests_tracker']), true) : [];
    if (!is_array($tracker)) {
        $tracker = [];
    }
    
    if (!isset($tracker[$cat_slug])) {
        $tracker[$cat_slug] = 0;
    }
    $tracker[$cat_slug]++;
    
    // Write cookie back with 30 days persistent life
    setcookie('ilybd_interests_tracker', json_encode($tracker), time() + (30 * 86400), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
}

// Hook into pre_get_posts on frontpage to reorder priority list to match customer favorite niche!
add_action('pre_get_posts', 'ilybd_predictive_suggestion_reorder');
function ilybd_predictive_suggestion_reorder($query) {
    if (is_admin() || !$query->is_main_query() || !is_home()) {
        return;
    }
    
    // Always enforce clean, robust posts count based on system Settings > Reading (default 10)
    $query->set('posts_per_page', get_option('posts_per_page', 10));
    
    // Only filter if predictive user suggestion toggle is ON (default is 0 / OFF to show standard 10 latest posts list)
    if (!get_option('ily_enable_predictive_suggestions', 0)) {
        return;
    }
    
    // Look up category interest from tracker cookie
    $tracker = isset($_COOKIE['ilybd_interests_tracker']) ? json_decode(stripslashes($_COOKIE['ilybd_interests_tracker']), true) : [];
    if (empty($tracker) || !is_array($tracker)) {
        return; // normal static catalog fallback
    }
    
    // Find the category slug with the highest view hit count
    arsort($tracker);
    $favorite_category_slug = key($tracker);
    
    if ($favorite_category_slug) {
        $query->set('category_name', $favorite_category_slug);
        // Boost post count to ensure users find everything they wanted on the homepage
        $query->set('posts_per_page', 12);
    }
}


/* =========================================================================
   6. USER STATUS CHATBOT POWER LEVELS & INTERFACES (Step 4)
   ========================================================================= */
/**
 * Renders user power capabilities mapped to structural levels and dynamic neon tones
 */
function ilybd_get_chatbot_power_tier($user_id = null) {
    // Check if Biometric God-Mode elevated transient is active for current session
    $session_id = md5($_SERVER['REMOTE_ADDR'] . (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''));
    $godmode_enabled = (get_option('ilybd_godmode_unfold', 'yes') === 'yes');
    if ($godmode_enabled && get_transient('ilybd_human_godmode_' . $session_id) === 'authorized') {
        return [
            'level' => 4,
            'name' => 'Sentinel Core Creator (Biometric God-Mode)',
            'power_limit' => 9999,
            'color' => '#00ff66', // Rich Green Neon
            'border' => '2px solid rgba(0, 255, 102, 0.85)',
            'glow' => 'rgba(0, 255, 102, 0.65)',
            'badge' => '👁️ BIOMETRIC GOD-MODE'
        ];
    }

    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    
    if (!$user_id) {
        // Guest user fallback level
        return [
            'level' => 1,
            'name' => 'Eco Spark',
            'power_limit' => 10, // Max queries per hour
            'color' => '#10b981', // Lime green
            'border' => '1.5px solid rgba(16, 185, 129, 0.4)',
            'glow' => 'rgba(16, 185, 129, 0.25)',
            'badge' => '🔋 GUEST NODE'
        ];
    }
    
    // Admin / Mod super power status
    if (user_can($user_id, 'manage_options')) {
        return [
            'level' => 4,
            'name' => 'Sentinel Core Creator',
            'power_limit' => 9999,
            'color' => '#fbbf24', // Rich Amber Gold
            'border' => '2px solid rgba(251, 191, 36, 0.85)',
            'glow' => 'rgba(251, 191, 36, 0.65)',
            'badge' => '👑 CREATOR GOD-MODE'
        ];
    }
    
    // Loyal logged in users get stats mapping points to high level powers
    $points = (int) get_user_meta($user_id, 'ilybd_total_points', true);
    
    if ($points >= 1000) {
        return [
            'level' => 3,
            'name' => 'Neural Vortex Master',
            'power_limit' => 150,
            'color' => '#c084fc', // Rich Electro Purple
            'border' => '2.0px solid rgba(192, 132, 252, 0.75)',
            'glow' => 'rgba(192, 132, 252, 0.5)',
            'badge' => '⚡ NEURAL MASTER'
        ];
    } elseif ($points >= 200) {
        return [
            'level' => 2,
            'name' => 'Cyber Shield Operator',
            'power_limit' => 50,
            'color' => '#00f0ff', // Vivid Neon Cyan
            'border' => '1.5px solid rgba(0, 240, 255, 0.6)',
            'glow' => 'rgba(0, 240, 255, 0.45)',
            'badge' => '🛡️ INFLUENCER PRO'
        ];
    } else {
        return [
            'level' => 1,
            'name' => 'Member Node Spark',
            'power_limit' => 20,
            'color' => '#10b981', // green
            'border' => '1.5px solid rgba(16, 185, 129, 0.45)',
            'glow' => 'rgba(16, 185, 129, 0.3)',
            'badge' => '🔑 MEMBER SPARK'
        ];
    }
}
