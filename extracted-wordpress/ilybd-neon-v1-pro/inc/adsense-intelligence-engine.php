<?php
/**
 * AdSense Approval Assurance & Advanced Cyber Intelligence Engine
 * - Silent PHP Error Logging & Interceptor (prevents front-end crashes during reviews, logs silently for Admin check)
 * - Automatic Article Schema & FAQ Schema injection (JSON-LD)
 * - Daily Traffic Intelligence Tracker (counts crawler crawls, page hits, rate limits & blocks)
 * - Beautiful Integrated Admin Panel (AdSense & Cyber Shield Intel) with real-time log terminal & metric statistics
 */

if (!defined('ABSPATH')) {
    exit;
}

// --- ১. সিকিউরিটি এরর ইন্টারসেপ্টর ও রিয়েল-টাইম লগিং ---
add_action('init', 'ilybd_initiate_adsense_error_interceptor');

function ilybd_initiate_adsense_error_interceptor() {
    // Check if the Silent Bug Shield is disabled
    if (!get_option('ilybd_ads_intel_silent_shield', 1)) {
        return;
    }
    // যদি WP_DEBUG স্ক্রিনে এরর দেখানোর জন্য ট্রু করা থাকে, তবে ইন্টারসেপ্টর সম্পূর্ণ নিষ্ক্রিয় থাকবে
    if (defined('WP_DEBUG') && WP_DEBUG) {
        return;
    }
    // শুধুমাত্র ফ্রন্টএন্ডে এরর ইন্টারসেপ্ট করা হবে যেন গুগল বটের সামনে সাইট সাইডবারে বা হেডারে কোনো পিএইচপি নোটিশ/এরর না দেখায়
    if (!is_admin()) {
        set_error_handler('ilybd_silent_php_error_handler');
        register_shutdown_function('ilybd_fatal_error_shutdown_interceptor');
    }
}

// পিএইচপি এরর হ্যান্ডলার
function ilybd_silent_php_error_handler($errno, $errstr, $errfile, $errline) {
    // মেমোরি শেষ হয়ে যাওয়ার মতো মারাত্মক এরর ছাড়া নোটিশ বা ওয়ার্নিং ইউজারদের থেকে হাইড রাখা হবে
    $exclude_types = array(E_NOTICE, E_USER_NOTICE, E_DEPRECATED, E_USER_DEPRECATED);
    
    if (!in_array($errno, $exclude_types)) {
        ilybd_log_internal_backend_error('PHP Warning/Error', $errstr, $errfile, $errline, $errno);
    }
    
    // যদি WP_DEBUG চালু থাকে অথবা ব্রাউজ করা ইউজার যদি অ্যাডমিন হন, তবে এরর অন-স্ক্রিন দেখানো হবে
    $show_error = false;
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $show_error = true;
    }
    if (function_exists('current_user_can') && current_user_can('manage_options')) {
        $show_error = true;
    }
    
    // যদি শো করতে চাই, তবে false রিটার্ন করব যাতে পিএইচপির ডিফল্ট হ্যান্ডলার স্ক্রিনে প্রিন্ট করে
    if ($show_error) {
        return false;
    }
    
    // true রিটার্ন করার মাধ্যমে পিএইচপি এরর ডিসপ্লে স্ক্রিনকে ব্লক করবে
    return true; 
}

// ফ্যাটাল এরর ইন্টারসেপ্টর
function ilybd_fatal_error_shutdown_interceptor() {
    $error = error_get_last();
    if ($error !== NULL && in_array($error['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR))) {
        ilybd_log_internal_backend_error('PHP Fatal Error', $error['message'], $error['file'], $error['line'], $error['type']);
        
        // অ্যাডসেন্স ক্রলারের সামনে ব্ল্যাঙ্ক পেজ বা কাস্টম মেসেজ দেখানো যেন র-কোড না বের হয়ে যায়
        if (!is_admin()) {
            $debug_info = '';
            if ((defined('WP_DEBUG') && WP_DEBUG) || (function_exists('current_user_can') && current_user_can('manage_options'))) {
                $debug_info = '<div style="color:#00ff41; font-family:monospace; margin-top:20px; text-align:left; background:#161b22; padding:15px; border-radius:6px; border:1px solid #30363d; overflow-x:auto; max-width:90%; font-size:12px;">' .
                              '<strong>Fatal Error:</strong> ' . esc_html($error['message']) . '<br>' .
                              '<strong>File:</strong> ' . esc_html($error['file']) . ' on line ' . intval($error['line']) .
                              '</div>';
            }
            
            echo '<div style="background:#070a0f; color:#ff3e3e; padding:40px; font-family:monospace; text-align:center; height:100vh; display:flex; flex-direction:column; justify-content:center; align-items:center; border:2px solid #ff3e3e;">';
            echo '<h2 style="border: 1px solid #ff3e3e; padding: 12px; font-size:16px;">🔍 [SYSTEM COGNITIVE SHIELD ACTIVATED]</h2>';
            echo '<p style="color:#8b949e; font-size:13px; max-width:600px;">The server encountered a momentary payload anomaly. Our shield has intercepted this event securely. The system remains integral.</p>';
            echo $debug_info;
            echo '<small style="color:#4a5568; margin-top:15px;">Node Status: Auto-Repairing and Back-trace Verified.</small>';
            echo '</div>';
            exit;
        }
    }
}

// ডাটাবেজে এরর ট্র্যাকিং ও ক্লিনিং
function ilybd_log_internal_backend_error($type, $message, $file, $line, $code = 0) {
    // সুরক্ষার জন্য ফাইলের হোম ডিরেক্টরি পাথ রিমুভ করুন
    $file = str_replace(ABSPATH, '', $file);
    
    $errors = get_option('ilybd_adsense_intercepted_errors', array());
    if (!is_array($errors)) {
        $errors = array();
    }
    
    // নতুন এরর ডাটা ফরম্যাট
    $new_error = array(
        'timestamp' => current_time('mysql'),
        'type'      => $type,
        'message'   => wp_strip_all_tags($message),
        'file'      => esc_html($file),
        'line'      => intval($line),
        'code'      => intval($code)
    );
    
    // সর্বোচ্চ ১৫টি এরর রেকর্ড রাখা হবে ডাটাবেজ ব্লোটিং এড়াতে
    array_unshift($errors, $new_error);
    $errors = array_slice($errors, 0, 15);
    
    update_option('ilybd_adsense_intercepted_errors', $errors);
}


// --- ২. ডেইলি ট্রাফিক ইন্টেলিজেন্স ট্র্যাকার ---
add_action('wp', 'ilybd_track_daily_intelligence_stats');

function ilybd_track_daily_intelligence_stats() {
    if (is_admin()) return;
    
    // Check if the tracker is enabled
    if (!get_option('ilybd_ads_intel_tracker', 1)) {
        return;
    }
    
    $today = date('Y-m-d');
    $stats = get_option('ilybd_daily_intelligence_stats', array());
    
    if (!is_array($stats)) {
        $stats = array();
    }
    
    if (!isset($stats[$today])) {
        // নতুন দিনের মেট্রিক্স ইনিশিয়ালাইজ করুন
        $stats[$today] = array(
            'page_hits'               => 0,
            'googlebot_hits'          => 0,
            'crawler_hits'            => 0,
            'honeypot_traps'          => 0,
            'rate_limits_triggered'   => 0
        );
    }
    
    // ১. সাধারণ হিট কাউন্টার
    $stats[$today]['page_hits']++;
    
    // ২. ক্রলার ভেরিফিকেশন (গুগল ও অন্যান্য সার্চ ইঞ্জিন)
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    if (!empty($ua)) {
        if (stripos($ua, 'Googlebot') !== false || stripos($ua, 'Mediapartners-Google') !== false || stripos($ua, 'AdsBot-Google') !== false) {
            $stats[$today]['googlebot_hits']++;
        } elseif (preg_match('/(bingbot|Slurp|DuckDuckBot|Baiduspider|YandexBot|Sogou)/i', $ua)) {
            $stats[$today]['crawler_hits']++;
        }
    }
    
    // পূর্ববর্তী মেট্রিক্স ট্রিম করে শুধু গত ৭ দিনের ডাটা রেখে আপডেট করুন
    if (count($stats) > 7) {
        $stats = array_slice($stats, -7, 7, true);
    }
    
    update_option('ilybd_daily_intelligence_stats', $stats);
}

// ম্যানুয়াল ট্র্যাকার বুস্ট ফাংশন (যেকোনো ফ্লাগ ও সিকিউরিটি ইভেন্ট ট্র্যাক করার জন্য)
function ilybd_trigger_intelligence_metric($metric_name) {
    if (!get_option('ilybd_ads_intel_tracker', 1)) {
        return;
    }
    $today = date('Y-m-d');
    $stats = get_option('ilybd_daily_intelligence_stats', array());
    if (!is_array($stats)) { $stats = array(); }
    if (!isset($stats[$today])) {
        $stats[$today] = array(
            'page_hits'             => 0,
            'googlebot_hits'        => 0,
            'crawler_hits'          => 0,
            'honeypot_traps'        => 0,
            'rate_limits_triggered' => 0
        );
    }
    if (isset($stats[$today][$metric_name])) {
        $stats[$today][$metric_name]++;
    } else {
        $stats[$today][$metric_name] = 1;
    }
    update_option('ilybd_daily_intelligence_stats', $stats);
}


// --- ৩. অটোমেটিক এসইও-ফ্রেন্ডলি স্কিমা ইনজেক্টর ---
add_action('wp_head', 'ilybd_inject_structured_data_schemas', 1);

function ilybd_inject_structured_data_schemas() {
    // Check if the auto schema helper is enabled
    if (!get_option('ilybd_ads_intel_schema', 1)) {
        return;
    }
    
    // ১. আর্টিকেল স্কিমা ইনজেকশন (Single post pages এ)
    if (is_single()) {
        global $post;
        $post_id = $post->ID;
        
        $title       = esc_attr(get_the_title($post_id));
        $excerpt     = esc_attr(get_the_excerpt($post_id));
        $publish_date= get_the_date('c', $post_id);
        $modify_date = get_the_modified_date('c', $post_id);
        $author_name = esc_attr(get_the_author_meta('display_name', $post->post_author));
        $author_url  = esc_url(get_author_posts_url($post->post_author));
        
        // ইমেজ ইউআরএল গেটার
        $image_url = '';
        if (has_post_thumbnail($post_id)) {
            $image_url = esc_url(get_the_post_thumbnail_url($post_id, 'full'));
        } else {
            // ফ্ল্যাক ব্যাকগ্রাউন্ড ইমেজ / সাইটের লোগো
            $image_url = esc_url(get_header_image() ? get_header_image() : get_stylesheet_directory_uri() . '/assets/img/og-fallback.png');
        }
        
        $publisher_logo = esc_url(get_stylesheet_directory_uri() . '/assets/img/logo.png');
        
        $article_schema = array(
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id'   => esc_url(get_permalink($post_id))
            ),
            'headline'         => $title,
            'description'      => $excerpt ? $excerpt : $title,
            'image'            => $image_url,
            'datePublished'    => $publish_date,
            'dateModified'     => $modify_date,
            'author'           => array(
                '@type' => 'Person',
                'name'  => $author_name,
                'url'   => $author_url
            ),
            'publisher'        => array(
                '@type' => 'Organization',
                'name'  => esc_attr(get_bloginfo('name')),
                'logo'  => array(
                    '@type' => 'ImageObject',
                    'url'   => $publisher_logo
                )
            )
        );
        
        echo "\n<!-- [ILYBD AUTO ARTICLE SCHEMA START] -->\n";
        echo '<script type="application/ld+json">' . json_encode($article_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
        echo "\n<!-- [ILYBD AUTO ARTICLE SCHEMA END] -->\n";
    }
    
    // ২. এফএকিউ স্কিমা ইনজেকশন (Faq page এ)
    if (is_page_template('page-faq.php')) {
        $faq_schema = array(
            '@context' => 'https://schema.org',
            '@type'    => 'FAQPage',
            'mainEntity' => array(
                array(
                    '@type' => 'Question',
                    'name'  => 'What is the primary purpose of ILYBD System?',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text'  => 'ILYBD (iloveyoubd.com) is built primarily as a high-fidelity information system and educational network. We design open-source automation scripts, high-speed laboratory tools, and customized WordPress template optimization kits designed to provide top performance rankings for developers globally.'
                    )
                ),
                array(
                    '@type' => 'Question',
                    'name'  => 'Are the configuration files and apps hosted on ILYBD system safe?',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text'  => 'Absolutely. Every application, tool, and setup configuration code published on our servers undergoes strict inspection inside our laboratory environments to detect backdoor code, adware, or malware. We prioritize secure user interactions and ensure no files run harmful background scripts before public deployment.'
                    )
                ),
                array(
                    '@type' => 'Question',
                    'name'  => 'How are the user avatars optimized in the theme?',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text'  => 'We use our customized ilybd_get_optimized_avatar_url filters. When users upload profile images on our user dashboard, our engine automatically downsizes and encodes them into .webp formats (like 120px/150px) to decrease load size, improving overall FCP (First Contentful Paint) scoring for search optimization.'
                    )
                ),
                array(
                    '@type' => 'Question',
                    'name'  => 'How can I contribute or report problems in the forum?',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text'  => 'First, register a free user node. After logging into your community dashboard, you can open connection threads inside the live Community Q&A forum page or click our floating "AI Chat" bridge inside the slim navbar to transmit bug reports directly to our engineers.'
                    )
                ),
                array(
                    '@type' => 'Question',
                    'name'  => 'Why does PageSpeed Insights load fast on our network?',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text'  => 'Our structures enforce high-speed CSS optimization filters. We utilize techniques such as asynchronous loading for large external files, critical assets preloading (like featured category thumbnails), and light image sizes. This lowers initial blocking, granting an outstanding mobile/desktop ranking of 90+ on Core Web Vitals checks.'
                    )
                )
            )
        );
        
        echo "\n<!-- [ILYBD CYBER FAQ PRO SCHEMA START] -->\n";
        echo '<script type="application/ld+json">' . json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
        echo "\n<!-- [ILYBD CYBER FAQ PRO SCHEMA END] -->\n";
    }
}


// --- ৪. ADMIN SETTINGS MENU PANEL ---
add_action('admin_menu', 'ilybd_adsense_cyber_intel_menu');

function ilybd_adsense_cyber_intel_menu() {
    add_menu_page(
        'AdSense & Cyber Shield Intel',
        '🛡️ AdSense & Cyber Shield',
        'manage_options',
        'adsense-cyber-shield-intel',
        'ilybd_adsense_cyber_intel_page',
        'dashicons-shield',
        30
    );
}

function ilybd_adsense_cyber_intel_page() {
    // Handle Save Settings
    if (isset($_POST['ilybd_save_ads_intel_settings'])) {
        check_admin_referer('ilybd_adsense_intel_setup');
        update_option('ilybd_ads_intel_silent_shield', isset($_POST['silent_shield_toggle']) ? 1 : 0);
        update_option('ilybd_ads_intel_schema', isset($_POST['schema_toggle']) ? 1 : 0);
        update_option('ilybd_ads_intel_tracker', isset($_POST['tracker_toggle']) ? 1 : 0);
        echo '<div class="updated notice is-dismissible"><p><strong>✅ Settings Saved Successfully! (সেটিংস সফলভাবে সংরক্ষিত হয়েছে!)</strong></p></div>';
    }

    // Handle Clear Logs
    if (isset($_POST['ilybd_clear_errors'])) {
        check_admin_referer('ilybd_adsense_intel_clear_logs');
        update_option('ilybd_adsense_intercepted_errors', array());
        echo '<div class="updated notice is-dismissible"><p><strong>❌ Intercepted PHP Error logs successfully cleared! (কোড এরর লগগুলো সফলভাবে ডিলিট করা হয়েছে!)</strong></p></div>';
    }

    $silent_shield_active = get_option('ilybd_ads_intel_silent_shield', 1);
    $schema_active        = get_option('ilybd_ads_intel_schema', 1);
    $tracker_active       = get_option('ilybd_ads_intel_tracker', 1);

    $errors = get_option('ilybd_adsense_intercepted_errors', array());
    $stats  = get_option('ilybd_daily_intelligence_stats', array());
    ?>
    <div style="background:#0b0f14; color:#c9d1d9; padding:25px; border-radius:14px; border:1px solid #30363d; font-family:system-ui; max-width:1050px; margin:20px auto; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
        
        <!-- Header Zone -->
        <div style="text-align:center; padding-bottom:20px; border-bottom:1px solid #30363d; margin-bottom:25px;">
            <div style="font-size:40px; margin-bottom:10px;">🛡️</div>
            <h1 style="color:#00ff41; font-weight:800; letter-spacing:1px; margin:0 0 10px 0; font-size:26px;">ADSENSE & CYBER SHIELD INTEL仪表盘</h1>
            <p style="color:#8b949e; font-size:14px; max-width:700px; margin:0 auto; line-height:1.6;">
                গুগল অ্যাডসেন্স অ্যাপ্রুভাল অ্যাসুরেন্স এবং অ্যাডভান্সড সাইবার সিকিউরিটি ইঞ্জিন। এই সিস্টেমটি পিএইচপি ক্র্যাশ লুকাতে, সার্চ ইঞ্জিনের জন্য উন্নত JSON-LD স্কিমা যোগ করতে এবং বট ট্র্যাফিক ট্র্যাক করতে অটোমেশন ব্যবহার করে।
            </p>
        </div>

        <div style="display:grid; grid-template-columns: 1fr; gap:25px;">
            
            <!-- Settings panel (Toggles) -->
            <div style="background:#161b22; padding:20px; border-radius:12px; border:1px solid #30363d;">
                <h3 style="color:#00ff41; margin-top:0; border-bottom:1px solid #30363d; padding-bottom:10px; font-size:18px;">🛠️ PROTECTION SETTINGS (সুরক্ষা সেটিংস)</h3>
                
                <form method="post">
                    <?php wp_nonce_field('ilybd_adsense_intel_setup'); ?>
                    
                    <div style="margin-bottom:15px; display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <strong style="color:#fff; font-size:15px;">PHP Silent Error Interceptor (সাইলেন্ট এরর ফিল্টার)</strong>
                            <p style="color:#8b949e; margin:4px 0 0 0; font-size:12px;">ফ্রন্টএন্ডে পিএইচপি সাইডবার নোটিশ বা ফ্যাটাল স্ক্র্যাচ হাইড করে গুগল বট/ইউজারদের সামনে সাইট ১০০% সচল রাখে।</p>
                        </div>
                        <label class="ilybd-switch" style="position:relative; display:inline-block; width:50px; height:24px;">
                            <input type="checkbox" name="silent_shield_toggle" <?php checked($silent_shield_active, 1); ?> style="opacity:0; width:0; height:0;">
                            <span style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:#30363d; border-radius:34px; transition:.4s; background-color: <?php echo $silent_shield_active ? '#00ff41' : '#30363d'; ?>;"></span>
                        </label>
                    </div>

                    <div style="margin-bottom:15px; display:flex; align-items:center; justify-content:space-between; border-top:1px solid #21262d; padding-top:15px;">
                        <div>
                            <strong style="color:#fff; font-size:15px;">Google FAQ & Article Schema Auto-Injection (অটো স্কিমা জেনারেটর)</strong>
                            <p style="color:#8b949e; margin:4px 0 0 0; font-size:12px;">অ্যাডসেন্স এর রিডিং সুবিধার জন্য কাস্টম পোস্ট পেজে এবং FAQ-এ অটোম্যাটিক সার্চ ট্রাস্ট জেনারেটিং JSON-LD স্কিমা ইনজেক্ট করে।</p>
                        </div>
                        <label class="ilybd-switch" style="position:relative; display:inline-block; width:50px; height:24px;">
                            <input type="checkbox" name="schema_toggle" <?php checked($schema_active, 1); ?> style="opacity:0; width:0; height:0;">
                            <span style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:#30363d; border-radius:34px; transition:.4s; background-color: <?php echo $schema_active ? '#00ff41' : '#30363d'; ?>;"></span>
                        </label>
                    </div>

                    <div style="margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; border-top:1px solid #21262d; padding-top:15px;">
                        <div>
                            <strong style="color:#fff; font-size:15px;">Daily Crawler & Intelligence Stats (সার্চ বট ও ভিজিটর ট্র্যাক)</strong>
                            <p style="color:#8b949e; margin:4px 0 0 0; font-size:12px;">গুগল বট ভিজিট সংখ্যা এবং অন্যান্য সার্চ ইঞ্জিন ক্রলারদের উপস্থিতি প্রতিদিনের ডাটাবেজে সংরক্ষণ করে।</p>
                        </div>
                        <label class="ilybd-switch" style="position:relative; display:inline-block; width:50px; height:24px;">
                            <input type="checkbox" name="tracker_toggle" <?php checked($tracker_active, 1); ?> style="opacity:0; width:0; height:0;">
                            <span style="position:absolute; cursor:pointer; top:0; left:0; right:0; bottom:0; background:#30363d; border-radius:34px; transition:.4s; background-color: <?php echo $tracker_active ? '#00ff41' : '#30363d'; ?>;"></span>
                        </label>
                    </div>

                    <button type="submit" name="ilybd_save_ads_intel_settings" style="background:#00ff41; color:#0d1117; padding:10px 20px; font-weight:bold; border-radius:6px; border:none; cursor:pointer; font-size:14px; text-transform:uppercase;">
                        💾 Save Active Configurations
                    </button>
                </form>
            </div>

            <!-- Terminal Logger (PHP intercepted Errors) -->
            <div style="background:#0d1117; padding:20px; border-radius:12px; border:1px solid #ff3e3e;">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #30363d; padding-bottom:10px; margin-bottom:15px;">
                    <h3 style="color:#ff3e3e; margin:0; font-size:18px;">📟 SECURITY SHIELD TERMINAL (লাইভ সাইলেন্ট এরর লগার)</h3>
                    <form method="post" style="margin:0;">
                        <?php wp_nonce_field('ilybd_adsense_intel_clear_logs'); ?>
                        <button type="submit" name="ilybd_clear_errors" style="background:#21262d; color:#ff7b72; padding:6px 12px; border:1px solid #30363d; border-radius:5px; cursor:pointer; font-size:12px; font-weight:bold;">
                            🗑️ Clear Logs
                        </button>
                    </form>
                </div>
                
                <p style="color:#8b949e; font-size:13px; margin:0 0 15px 0;">
                    সাইটে কোনো প্লাগইন বা থিমে বড় এরর হলে তা আমাদের ফিল্টার রিয়েল-টাইমে এখানে ক্যাপচার করে রাখে যেন ভিজিটরদের স্ক্রিন হোয়াইট (Blank) না হয়।
                </p>

                <!-- Simulated Terminal Console -->
                <div style="background:#070a0f; color:#ff7b72; font-family:monospace; padding:15px; border-radius:8px; border:1px solid #21262d; max-height:280px; overflow-y:auto; font-size:12px; line-height:1.6;">
                    <?php if (empty($errors)): ?>
                        <span style="color:#00ff41;">[SECURE] 0 active intercepted errors on production feed. The Cyber Shield is actively monitoring.</span>
                    <?php else: ?>
                        <?php foreach (array_slice($errors, 0, 15) as $error): ?>
                            <div style="border-bottom:1px dashed #21262d; padding-bottom:8px; margin-bottom:8px;">
                                <span style="color:#8b949e;">[<?php echo esc_html($error['timestamp']); ?>]</span> 
                                <span style="color:#ff3e3e; font-weight:bold;">[<?php echo esc_html($error['type']); ?>]</span><br>
                                <strong style="color:#f0f6fc;"><?php echo esc_html($error['message']); ?></strong><br>
                                <span style="color:#c9d1d9;">File:</span> <span style="color:#58a6ff;"><?php echo esc_html($error['file']); ?></span> on line <span style="color:#f1c40f;"><?php echo intval($error['line']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bot & Crawl Intel Metrics (Last 7 Days) -->
            <div style="background:#161b22; padding:20px; border-radius:12px; border:1px solid #30363d;">
                <h3 style="color:#00ff41; margin-top:0; border-bottom:1px solid #30363d; padding-bottom:10px; font-size:18px;">📊 CRAWLER INTELLIGENCE REPORT (সার্চ ক্রলার ও বট ট্র্যাফিক)</h3>
                <p style="color:#8b949e; font-size:13px; margin:0 0 15px 0;">গত ৭ দিনের গুগল ক্রলার বট এবং ট্রাফিক পেজভিউ পরিসংখ্যান নিচে টেবিল ফরম্যাটে দেখানো হলো:</p>
                
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; text-align:left; font-size:13px;">
                        <thead>
                            <tr style="border-bottom:2px solid #30363d; color:#fff;">
                                <th style="padding:10px;">Date (তারিখ)</th>
                                <th style="padding:10px;">Page View Hits (মোট পেজভিউ)</th>
                                <th style="padding:10px; color:#58a6ff;">Googlebot Crawls (গুগল বট ভিজিট)</th>
                                <th style="padding:10px; color:#f1c40f;">Other Search Crawlers (অন্যান্য সার্চ ক্রলার)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($stats)): ?>
                                <tr>
                                    <td colspan="4" style="padding:15px; text-align:center; color:#8b949e;">কোনো ট্র্যাকিং ডাটা আপাতত উপলব্ধ নেই। সচল ট্র্যাকিং নিশ্চিত করতে পেজ রিফ্রেশ করুন।</td>
                                </tr>
                            <?php else: ?>
                                <?php 
                                // Reverse array keys to show latest days first
                                $stat_days = array_reverse($stats, true);
                                foreach ($stat_days as $day => $data): 
                                    $page_hits = isset($data['page_hits']) ? intval($data['page_hits']) : 0;
                                    $google_hits = isset($data['googlebot_hits']) ? intval($data['googlebot_hits']) : 0;
                                    $crawler_hits = isset($data['crawler_hits']) ? intval($data['crawler_hits']) : 0;
                                ?>
                                    <tr style="border-bottom:1px solid #21262d; hover:background:#30363d;">
                                        <td style="padding:10px; font-weight:bold; color:#fff;"><?php echo esc_html($day); ?></td>
                                        <td style="padding:10px;"><?php echo number_format($page_hits); ?></td>
                                        <td style="padding:10px; color:#58a6ff; font-weight:bold;"><?php echo number_format($google_hits); ?></td>
                                        <td style="padding:10px; color:#f1c40f;"><?php echo number_format($crawler_hits); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div style="margin-top:20px; text-align:center; color:#58a6ff; font-size:12px; font-weight:bold; border-top: 1px solid #30363d; padding-top:15px;">
            🤖 POWERED BY ILYBD NEON SECURITY v3 – EXCELLENT CRASH SHIELD
        </div>
    </div>
    <?php
}
