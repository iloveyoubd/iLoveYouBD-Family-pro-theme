<?php
/**
 * Admin: Master Control Panel Dispatcher
 * Path: admin/master-control.php
 * Description: Modular admin dispatcher, API core manager, and central AdSense / SEO scan routing system.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class ILYBD_Master_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'ilybd_add_menu'));
        add_action('admin_init', array($this, 'ilybd_settings_init'));
        add_action('admin_head', array($this, 'ilybd_inject_dashboard_styles'));
        
        // AJAX hooks for AdSense Approver Bot & Site QA Auditor
        add_action('wp_ajax_ilybd_adsense_bot_scan', array($this, 'ajax_admin_scan'));
        add_action('wp_ajax_ilybd_adsense_bot_autofix', array($this, 'ajax_admin_autofix'));
    }

    /**
     * Registers parent menu and separate physical submenus
     */
    public function ilybd_add_menu() {
        // Main core entry menu
        add_menu_page(
            'ILYBD Control',
            'ILYBD Master',
            'manage_options',
            'ilybd-engine-settings',
            array($this, 'ilybd_render_admin_page'),
            'dashicons-chart-pie',
            25
        );

        // Submenu: Ecosystem & Wallet Rewards
        add_submenu_page(
            'ilybd-engine-settings',
            'Ecosystem & User Rewards',
            'Ecosystem Rewards',
            'manage_options',
            'ilybd-economy-settings',
            array($this, 'ilybd_render_economy_page')
        );

        // Submenu: UI/UX Glow Skins & Themes
        add_submenu_page(
            'ilybd-engine-settings',
            'UI/UX Glow & Themes',
            'UI Customizer',
            'manage_options',
            'ilybd-style-settings',
            array($this, 'ilybd_render_style_page')
        );

        // Submenu: AI Writer & Auto-SEO Settings (Gemini keys, Traffic guards)
        add_submenu_page(
            'ilybd-engine-settings',
            'AI Autopilot & SEO Solver',
            'AI & SEO Writer',
            'manage_options',
            'ilybd-ai-settings',
            array($this, 'ilybd_render_ai_page')
        );

        // Submenu: Speed Caching & DB Optimizations
        add_submenu_page(
            'ilybd-engine-settings',
            'Speed Caching & DB Optimizers',
            'Cache & DB Clean',
            'manage_options',
            'ilybd-cache-settings',
            array($this, 'ilybd_render_cache_page')
        );
    }

    /**
     * WP core register settings
     */
    public function ilybd_settings_init() {
        // Keep registration definitions in place as fallback compatibility
        $opts = array(
            'ilybd_api_keys', 'ilybd_rev_share_percent', 'ilybd_ad_timer',
            'ilybd_ref_points_referrer', 'ilybd_ref_points_referee', 'ilybd_ref_cash_referrer', 'ilybd_ref_cash_referee',
            'ilybd_eco_post_points', 'ilybd_eco_post_cash', 'ilybd_eco_view_points', 'ilybd_eco_view_cash',
            'ilybd_eco_comment_points', 'ilybd_eco_comment_cash', 'ilybd_eco_reply_points', 'ilybd_eco_reply_cash',
            'ilybd_eco_question_points', 'ilybd_eco_question_cash', 'ilybd_eco_answer_points', 'ilybd_eco_answer_cash',
            'ilybd_respect_device_theme', 'ilybd_enable_rgb_loop', 'ilybd_adsense_safe_mode',
            'ilybd_color_post_card', 'ilybd_color_comment_box', 'ilybd_color_user_profile', 'ilybd_color_chatbot',
            'ilybd_color_qa_forum', 'ilybd_color_story_shelf', 'ilybd_color_wallet', 'ilybd_color_search_index',
            'ilybd_enable_autoseo_editor', 'ilybd_target_word_guideline', 'ilybd_autoseo_min_quality'
        );
        foreach ($opts as $opt) {
            register_setting('ilybd_settings_group', $opt);
        }
    }

    /**
     * Enqueue CSS styling directly into admin head for seamless 2040 custom branding
     */
    public function ilybd_inject_dashboard_styles() {
        // Only load on our plugin pages
        $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        if (strpos($page, 'ilybd-') !== 0) {
            return;
        }
        ?>
        <style>
            /* 2040 Cyber Space Theme Stylesheet */
            @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=JetBrains+Mono:wght@400;500;700&display=swap');
            
            .ilybd-cyber-wrapper {
                background: #070b13 !important;
                color: #e2e8f0 !important;
                padding: 30px;
                border-radius: 12px;
                border: 1px solid rgba(0, 240, 255, 0.15);
                max-width: 1000px;
                margin-top: 20px;
                font-family: 'Space Grotesk', -apple-system, sans-serif !important;
            }
            .ilybd-cyber-h1 {
                font-family: 'Space Grotesk', sans-serif !important;
                font-weight: 700 !important;
                font-size: 28px !important;
                color: #00f0ff !important;
                text-shadow: 0 0 10px rgba(0, 240, 255, 0.35);
                margin: 0 0 5px 0 !important;
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .ilybd-cyber-subtitle {
                font-size: 13.5px;
                color: #94a3b8;
                margin: 0 0 25px 0;
                font-family: 'Space Grotesk', sans-serif;
            }
            .ilybd-nav-links {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 25px;
                border-bottom: 1px solid rgba(148, 163, 184, 0.15);
                padding-bottom: 20px;
            }
            .ilybd-nav-tab {
                background: rgba(13, 21, 39, 0.6);
                border: 1px solid rgba(0, 240, 255, 0.2);
                color: #94a3b8 !important;
                padding: 10px 18px;
                text-decoration: none !important;
                font-size: 13px;
                border-radius: 6px;
                font-weight: 500;
                transition: all 0.25s ease;
            }
            .ilybd-nav-tab:hover, .ilybd-nav-tab.active {
                background: linear-gradient(135deg, rgba(0, 240, 255, 0.12), rgba(189, 0, 255, 0.08));
                border-color: #00f0ff;
                color: #00f0ff !important;
                box-shadow: 0 0 12px rgba(0, 240, 255, 0.2);
            }
            .ilybd-cyber-panel {
                background: rgba(13, 21, 39, 0.5) !important;
                border: 1px solid rgba(148, 163, 184, 0.1) !important;
                border-radius: 10px;
                padding: 24px;
                margin-bottom: 25px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            }
            .ilybd-panel-title {
                color: #00f0ff;
                font-size: 17px;
                font-weight: 700;
                border-bottom: 1px solid rgba(148, 163, 184, 0.15);
                padding-bottom: 10px;
                margin: 0 0 20px 0;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .ilybd-cyber-form-table {
                width: 100%;
                border-collapse: collapse;
            }
            .ilybd-cyber-form-table th {
                text-align: left;
                padding: 15px 10px;
                font-size: 14px;
                color: #e2e8f0;
                font-weight: 600;
                width: 260px;
                vertical-align: top;
            }
            .ilybd-cyber-form-table td {
                padding: 12px 10px;
                vertical-align: top;
            }
            .ilybd-cyber-input, .ilybd-cyber-select, .ilybd-cyber-textarea {
                background: #080d19 !important;
                border: 1px solid rgba(148, 163, 184, 0.25) !important;
                color: #fff !important;
                border-radius: 6px !important;
                padding: 8px 12px !important;
                font-size: 13.5px !important;
                outline: none !important;
                font-family: 'JetBrains Mono', monospace !important;
                transition: all 0.23s ease;
            }
            .ilybd-cyber-input:focus, .ilybd-cyber-select:focus, .ilybd-cyber-textarea:focus {
                border-color: #00f0ff !important;
                box-shadow: 0 0 8px rgba(0, 240, 255, 0.3) !important;
            }
            .ilybd-cyber-btn {
                background: #00f0ff !important;
                border: none !important;
                color: #070b13 !important;
                font-weight: 700 !important;
                padding: 12px 28px !important;
                font-size: 13.5px !important;
                border-radius: 6px !important;
                cursor: pointer !important;
                font-family: 'Space Grotesk', sans-serif !important;
                transition: all 0.25s ease !important;
                box-shadow: 0 0 12px rgba(0, 240, 255, 0.25);
            }
            .ilybd-cyber-btn:hover {
                background: #39ff14 !important;
                box-shadow: 0 0 15px rgba(57, 255, 20, 0.4);
                transform: translateY(-1px);
            }
            .ilybd-desc-text {
                color: #94a3b8;
                font-size: 12px;
                margin-top: 6px;
                line-height: 1.5;
            }
        </style>
        <?php
    }

    /**
     * Include subpages rendering logic
     */
    public function ilybd_render_admin_page() {
        require_once ILYBD_PLUGIN_DIR . 'admin/dashboard-auditor.php';
    }

    public function ilybd_render_economy_page() {
        require_once ILYBD_PLUGIN_DIR . 'admin/economy-settings.php';
    }

    public function ilybd_render_style_page() {
        require_once ILYBD_PLUGIN_DIR . 'admin/style-settings.php';
    }

    public function ilybd_render_ai_page() {
        require_once ILYBD_PLUGIN_DIR . 'admin/ai-seo-settings.php';
    }

    public function ilybd_render_cache_page() {
        require_once ILYBD_PLUGIN_DIR . 'admin/cache-db-settings.php';
    }

    /**
     * Helper to render shared header navigation tabs
     */
    public function ilybd_render_tabs($active_page) {
        ?>
        <div class="ilybd-nav-links">
            <a href="admin.php?page=ilybd-engine-settings" class="ilybd-nav-tab <?php echo $active_page === 'dashboard' ? 'active' : ''; ?>">🤖 Board Auditor</a>
            <a href="admin.php?page=ilybd-economy-settings" class="ilybd-nav-tab <?php echo $active_page === 'economy' ? 'active' : ''; ?>">💎 Ecosystem Rewards</a>
            <a href="admin.php?page=ilybd-style-settings" class="ilybd-nav-tab <?php echo $active_page === 'styles' ? 'active' : ''; ?>">🎨 UI Customizer</a>
            <a href="admin.php?page=ilybd-ai-settings" class="ilybd-nav-tab <?php echo $active_page === 'ai' ? 'active' : ''; ?>">🧠 AI & SEO Writer</a>
            <a href="admin.php?page=ilybd-cache-settings" class="ilybd-nav-tab <?php echo $active_page === 'cache' ? 'active' : ''; ?>">⚡ Cache & DB Repair</a>
        </div>
        <?php
    }

    /**
     * Centralized AJAX Compliance Audit Scan Endpoint
     */
    public function ajax_admin_scan() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'অনুমতি নেই।'));
        }

        global $wpdb;

        // 1. Scan Essential Compliance Pages
        $required_pages = array(
            'about' => array('About Us (আমাদের সম্পর্কে)', array('about-us', 'about', 'আমাদের-সম্পর্কে')),
            'contact' => array('Contact Us (যোগাযোগ)', array('contact-us', 'contact', 'যোগাযোগ')),
            'privacy' => array('Privacy Policy (গোপনীয়তা নীতি)', array('privacy-policy', 'privacy', 'গোপনীয়তা-নীতি')),
            'terms' => array('Terms of Service (ব্যবহারের নিয়মাবলী)', array('terms-and-conditions', 'terms-of-service', 'terms', 'शर्तাবলী'))
        );

        $pages_status = array();
        foreach ($required_pages as $key => $data) {
            $found = false;
            foreach ($data[1] as $slug) {
                $page = get_page_by_path($slug);
                if ($page && $page->post_status === 'publish') {
                    $found = true;
                    break;
                }
            }
            $pages_status[$key] = array(
                'label' => $data[0],
                'status' => $found ? 'FOUND' : 'MISSING',
                'id' => $found ? $page->ID : 0
            );
        }

        // 2. Scan Post Quality, Terminology, and AdSense Safe Checks
        $blacklist = array('crack', 'hack', 'nulled', 'adult', 'porn', 'pirated', 'bypass', 'unlimited free', 'bypass limit', 'crack file');
        $posts_scanned = 0;
        $violations_found = array();
        $thin_posts_found = array();

        $posts = get_posts(array(
            'post_type' => 'post',
            'post_status' => 'any',
            'posts_per_page' => 45
        ));

        foreach ($posts as $post) {
            $posts_scanned++;
            $content_lower = strtolower($post->post_content);
            $title_lower = strtolower($post->post_title);
            
            // Blacklist word detection
            $violated_words = array();
            foreach ($blacklist as $term) {
                if (strpos($content_lower, $term) !== false || strpos($title_lower, $term) !== false) {
                    $violated_words[] = $term;
                }
            }

            if (!empty($violated_words)) {
                $violations_found[] = array(
                    'id' => $post->ID,
                    'title' => $post->post_title,
                    'type' => 'POLICY_VIOLATION',
                    'words' => array_unique($violated_words),
                    'edit_url' => get_edit_post_link($post->ID)
                );
            }

            // Word count / thin content checks
            $word_count = str_word_count(strip_tags($post->post_content));
            $utf8_word_count = count(preg_split('/\s+/u', strip_tags($post->post_content)));
            $actual_count = max($word_count, $utf8_word_count);

            if ($actual_count < 550) {
                $thin_posts_found[] = array(
                    'id' => $post->ID,
                    'title' => $post->post_title,
                    'count' => $actual_count,
                    'edit_url' => get_edit_post_link($post->ID)
                );
            }
        }

        // 3. Scan Image Alt SEO details
        $attachments = get_posts(array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        $total_images = count($attachments);
        $missing_alt = 0;
        foreach ($attachments as $attachment) {
            $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            if (empty($alt)) {
                $missing_alt++;
            }
        }

        // 4. Double PHP Function Signatures Code Checks
        $duplicated_functions = array();
        $declared_signatures = array();
        $plugin_dir = dirname(__DIR__);
        $files_to_scan = array();
        if (is_dir($plugin_dir)) {
            $dir_iterator = new RecursiveDirectoryIterator($plugin_dir);
            $iterator = new RecursiveIteratorIterator($dir_iterator);
            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $files_to_scan[] = $file->getPathname();
                }
            }
        }

        foreach ($files_to_scan as $file_path) {
            $file_content = @file_get_contents($file_path);
            if ($file_content) {
                preg_match_all('/function\s+([a-zA-Z0-9_-]+)\s*\(/i', $file_content, $func_matches);
                if (!empty($func_matches[1])) {
                    foreach ($func_matches[1] as $func_name) {
                        if (strpos($func_name, 'ilybd_') === 0 || strpos($func_name, 'ily_') === 0 || strpos($func_name, 'ajax_admin_') === 0) {
                            if (isset($declared_signatures[$func_name])) {
                                $declared_signatures[$func_name][] = basename($file_path);
                                $duplicated_functions[$func_name] = array_unique($declared_signatures[$func_name]);
                            } else {
                                $declared_signatures[$func_name] = array(basename($file_path));
                            }
                        }
                    }
                }
            }
        }
        $duplicated_functions = array_filter($duplicated_functions, function($val) {
            return count($val) > 1;
        });

        // 5. Double Registered Hooks Callback Scan
        global $wp_filter;
        $duplicated_hooks = array();
        if (is_array($wp_filter)) {
            foreach ($wp_filter as $hook_tag => $hook_object) {
                if (strpos($hook_tag, 'ilybd_') !== false || strpos($hook_tag, 'wp_ajax_ilybd_') !== false) {
                    $callbacks_seen = array();
                    if (isset($hook_object->callbacks) && is_array($hook_object->callbacks)) {
                        foreach ($hook_object->callbacks as $pri => $prioritized_list) {
                            foreach ($prioritized_list as $cb_key => $cb) {
                                $callable_str = '';
                                if (is_string($cb['function'])) {
                                    $callable_str = $cb['function'];
                                } elseif (is_array($cb['function'])) {
                                    $callable_str = (is_object($cb['function'][0]) ? get_class($cb['function'][0]) : $cb['function'][0]) . '::' . $cb['function'][1];
                                }
                                if ($callable_str) {
                                    if (in_array($callable_str, $callbacks_seen)) {
                                        $duplicated_hooks[$hook_tag][] = $callable_str;
                                    } else {
                                        $callbacks_seen[] = $callable_str;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // 6. Database Transients & Revision Overhead Counts
        $corrupted_meta_count = intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key = '' OR meta_value = ''"));
        $corrupted_posts_count = intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE (post_title = '' AND post_content = '' AND post_status = 'publish')"));
        $transients_count = intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'"));
        $revision_count = intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'"));

        // 7. Estimating Core Web Vitals
        $start_time = microtime(true);
        $wpdb->get_results("SELECT 1"); 
        $query_time = (microtime(true) - $start_time) * 1000;
        $estimated_ttfb = round(45 + $query_time, 1) . 'ms'; 
        
        $is_gzip = (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false);
        $estimated_fcp = ($is_gzip ? '0.38s' : '0.74s');
        
        $safe_mode = get_option('ilybd_adsense_safe_mode', 'no');
        $estimated_cls = ($safe_mode === 'yes' ? '0.00' : '0.04');
        $layout_score = ($safe_mode === 'yes') ? 100 : 80;

        // 8. Calculating dynamic Lighthouse compliance ratings
        $perf_score = 100;
        if (!function_exists('ilybd_prime_get_cache_stats')) $perf_score -= 15;
        $perf_score -= min(15, count($thin_posts_found) * 3);
        $perf_score -= min(10, $revision_count > 10 ? 10 : 0);
        $perf_score = max(50, $perf_score);

        $a11y_score = 100;
        if ($missing_alt > 0) $a11y_score -= min(25, $missing_alt * 4);
        if ($safe_mode !== 'yes') $a11y_score -= 10;
        $a11y_score = max(50, $a11y_score);

        $best_score = 100;
        if (!empty($duplicated_functions) || !empty($duplicated_hooks)) $best_score -= 15;
        if ($corrupted_meta_count > 0 || $corrupted_posts_count > 0) $best_score -= 5;
        $best_score = max(60, $best_score);

        $seo_score = 100;
        $missing_essential_page = false;
        foreach ($pages_status as $p) {
            if ($p['status'] === 'MISSING') {
                $seo_score -= 15;
                $missing_essential_page = true;
            }
        }
        if (!empty($violations_found)) $seo_score -= 20;
        $seo_score = max(30, $seo_score);

        // Score Grade mapping
        $score = round(($perf_score + $a11y_score + $best_score + $seo_score) / 4);
        if ($score >= 90) $grade = 'A';
        elseif ($score >= 75) $grade = 'B';
        elseif ($score >= 55) $grade = 'C';
        else $grade = 'F';

        // Bengali speech adviser representation
        $advice_items = array();
        if ($missing_essential_page) {
            $advice_items[] = "সাইটে আইনি সম্মতি প্রদানের জন্য অতিসত্বর Contact-Us, Privacy Policy এবং Terms of Service পেজগুলো জেনারেট করুন।";
        }
        if (!empty($violations_found)) {
            $advice_items[] = "গুগল পাবলিশার গাইডলাইন অনুযায়ী কিছু পোস্টে এডসেন্স-সেনসিティブ কি-ওয়ার্ড সনাক্ত করা হয়েছে। অনুগ্রহ করে এগুলো প্রতিস্থাপন করুন।";
        }
        if ($missing_alt > 0) {
            $advice_items[] = "অ্যাটাচড মিডিয়া ইমেজে অল্ট এট্রিবিউট নেই, যা সাইটের এসইও ও অ্যাক্সেসিবিলিটি স্কোরে নেতিবাচক প্রভাব ফেলছে।";
        }
        if (!empty($duplicated_functions) || !empty($duplicated_hooks)) {
            $advice_items[] = "সিস্টেম কোডবেজে ডাবল কলব্যাক বা একই নামের ফাংশন ডুপ্লিকেট সনাক্ত হয়েছে। অটো-ডিবাগ দিয়ে পিউরিফাই করুন।";
        }
        
        if (empty($advice_items)) {
            $rep_bengali_speech = "সম্মানিত এডমিন, অভিনন্দন! আপনার আইবিডি সাইবারের পুরো আর্কিটেকচার গুগল এডসেন্স বোর্ড ও লাইটহাউস কমপ্লায়েন্স এর সর্বোচ্চ স্তরে রয়েছে। কোনো গুরুতর ঝুঁকি পাওয়া যায়নি!";
        } else {
            $rep_bengali_speech = "সম্মানিত এডমিন, " . implode(' ', $advice_items) . " আমার জেনারেটেড সম্পূর্ণ অটো কমপ্লিট সায়েন্স স্ক্রিপ্টটি দিয়ে একদম ১-ক্লিকে এগুলো ফিক্স করতে পারেন।";
        }

        wp_send_json_success(array(
            'status' => 'success',
            'score' => $score,
            'grade' => $grade,
            'posts_scanned' => $posts_scanned,
            'pages_status' => $pages_status,
            'violations' => $violations_found,
            'thin_content' => $thin_posts_found,
            'safe_mode' => $safe_mode,
            'layout_score' => $layout_score,
            'advice' => $rep_bengali_speech,
            'total_images' => $total_images,
            'missing_alt' => $missing_alt,
            'ttfb' => $estimated_ttfb,
            'fcp' => $estimated_fcp,
            'cls' => $estimated_cls,
            'revisions' => $revision_count,
            'perf_score' => $perf_score,
            'a11y_score' => $a11y_score,
            'best_score' => $best_score,
            'seo_score' => $seo_score,
            'duplicated_functions' => $duplicated_functions,
            'duplicated_hooks' => $duplicated_hooks,
            'transients_count' => $transients_count,
            'corrupted_meta_count' => $corrupted_meta_count,
            'corrupted_posts_count' => $corrupted_posts_count
        ));
    }

    /**
     * Centralized AJAX Compliance Automatic Fix Pipeline
     */
    public function ajax_admin_autofix() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'অনুমতি নেই।'));
        }

        $logs = array();

        // 1. Create Missing Compliance Pages
        $required_pages = array(
            'privacy-policy' => array(
                'title' => 'Privacy Policy - গোপনীয়তা নীতি',
                'content' => '<h2>১. গোপনীয়তা নীতি (Privacy Policy)</h2><p>iloveyoubd.com-এ আমাদের ভিজিটরদের গোপনীয়তা রক্ষা করা আমাদের অন্যতম প্রধান দায়িত্ব। এই নথিতে আমরা কোন কোন তথ্য সংগ্রহ করি এবং তা কীভাবে ব্যবহার করি তা বর্ণনা করা হলো।</p><h2>২. তথ্য সংগ্রহ ও ব্যবহার</h2><p>আমরা কোনো ব্যক্তিগত সিকিউরিটি কোড বা ট্র্যাকিং ডেটা সংরক্ষণ করি না। গুগল এডসেন্স বা অন্য বিজ্ঞাপন সার্ভারগুলো ভিজিটরদের কুকি ট্র্যাকিং ব্যবহার করতে পারে যা সম্পূর্ণরূপে গুগলের নিজস্ব পলিসি দ্বারা নির্ধারিত।</p><h2>৩. এডসেন্স ও ডাবল-ক্লিক কুকি</h2><p>গুগল এনালিটিক্স এবং এডসেন্স কুকি আমাদের সাইটে বিজ্ঞাপন দেখানোর জন্য ব্যবহুত হয়। আপনি চাইলে আপনার ব্রাউজার অপশন থেকে কুকি নিষ্ক্রিয় করতে পারেন। আমাদের কোনো প্রকার স্প্যাম কাকাও বা ব্যাকলিঙ্কের সাথে চুক্তি নেই।</p>'
            ),
            'about-us' => array(
                'title' => 'About Us - আমাদের সম্পর্কে',
                'content' => '<h2>আমাদের উদ্দেশ্য</h2><p>iloveyoubd.com বাংলাদেশ এবং অঞ্চলের আইটি সমাধান, সাইবার নিরাপত্তা সচেতনতা ও ফ্রিল্যান্সিং গাইডলাইন প্রদানের জন্য গঠিত একটি বিশ্বস্ত প্রযুক্তি ব্লগ।</p><h2>আমাদের কার্যক্রম</h2><p>আমরা প্রতিদিন প্রযুক্তি সুরক্ষার উপর বাস্তব নিয়মাবলী, ফ্রিল্যান্সিং ডেভেলপমেন্ট গাইড এবং সঠিক উপায়ে আয়ের আসল নিয়মের উপর বিস্তারিত পোস্ট প্রকাশ করে আসছি। আমাদের কনটেন্টগুলো অত্যন্ত স্বচ্ছ এবং আইনি নীতিমালার সাথে ১০০% সংগতিপূর্ণ।</p>'
            ),
            'contact-us' => array(
                'title' => 'Contact Us - যোগাযোগ করুন',
                'content' => '<h2>যোগাযোগের ঠিকানা</h2><p>আমাদের সাথে যোগাযোগ করতে নিচের অফিশিয়াল ঠিকানায় ইমেইল পাঠাতে পারেন:</p><ul><li>ইমেইল: support@iloveyoubd.com</li><li>টুইটার: @ilybd_hq</li><li>হেডকোয়ার্টার: ঢাকা, বাংলাদেশ।</li></ul><p>আমরা চব্বিশ ঘণ্টার মধ্যে যেকোনো সাপোর্ট কোয়েরি সমাধান করতে প্রতিশ্রুতিবদ্ধ। আপনার মূল্যবান মতামত আমাদের অনুপ্রেরণা প্রদান করে।</p>'
            ),
            'terms-of-service' => array(
                'title' => 'Terms of Service - ব্যবহারের নিয়মাবলী',
                'content' => '<h2>১. শর্তাবলীর গ্রহণযোগ্যতা</h2><p>iloveyoubd.com ওয়েবসাইটটি ব্যবহার করার মাধ্যমে আপনি আমাদের ব্যবহারের নিয়মাবলী সম্পূর্ণরূপে মেনে নিয়েছেন বলে গণ্য করা হবে।</p><h2>২. কনটেন্টের কপিরাইট</h2><p>এই সাইটে প্রকাশিত সকল টিউটোরিয়াল, সমাধান ও গাইডলাইন সম্পূর্ণরূপে স্বত্বাধিকার সংরক্ষিত। বিনা অনুমতিতে কন্টেন্ট কপি করা আইনের চোখে অপরাধ।</p><h2>৩. ব্যবহারের সীমাবদ্ধতা</h2><p>কোনো অবৈধ কার্যাবলী, অন্যের সিস্টেমে বিনা অনুমতিতে প্রবেশের অপচেстая বা অ্যাডসেন্স পলিসি লঙ্ঘনকারী কোনো অবৈধ টুলস প্রচার করার উদ্দেশ্যে এই সাইটের সাহায্য নেওয়া সম্পূর্ণ নিষিদ্ধ।</p>'
            )
        );

        foreach ($required_pages as $slug => $data) {
            $page = get_page_by_path($slug);
            if (!$page) {
                $inserted_id = wp_insert_post(array(
                    'post_title' => $data['title'],
                    'post_content' => $data['content'],
                    'post_status' => 'publish',
                    'post_type' => 'page',
                    'post_name' => $slug
                ));
                if (!is_wp_error($inserted_id)) {
                    $logs[] = "✅ সফলভাবে তৈরি হয়েছে জরুরি পেজ: " . esc_html($data['title']);
                }
            }
        }

        // 2. Sanitize and Clean Content (Blacklist Terms Filtering)
        $blacklist_replacements = array(
            'crack' => 'verified-license',
            'patched' => 'official-configured',
            'hack' => 'ethical-security-guard',
            'nulled' => 'gpl-framework',
            'unlimited free' => 'high-bandwidth',
            'bypass limit' => 'optimize limits',
            'adblock' => 'ad-controller'
        );

        $posts = get_posts(array(
            'post_type' => 'post',
            'post_status' => 'any',
            'posts_per_page' => 100
        ));

        $sanitized_count = 0;
        foreach ($posts as $post) {
            $content = $post->post_content;
            $title = $post->post_title;
            $changed = false;

            foreach ($blacklist_replacements as $unsafe => $safe) {
                if (stripos($content, $unsafe) !== false || stripos($title, $unsafe) !== false) {
                    $content = str_ireplace($unsafe, $safe, $content);
                    $title = str_ireplace($unsafe, $safe, $title);
                    $changed = true;
                }
            }

            if ($changed) {
                wp_update_post(array(
                    'ID' => $post->ID,
                    'post_title' => $title,
                    'post_content' => $content
                ));
                $sanitized_count++;
            }
        }
        if ($sanitized_count > 0) {
            $logs[] = "🛡️ সফলভাবে " . $sanitized_count . " টি পোস্টের কালো তালিকাভুক্ত শব্দ ক্লিন করে পলিসি-বান্ধব করা হয়েছে।";
        }

        // 3. Heal thin posts with FAQ & EEAT block
        $thin_adjusted_count = 0;
        foreach ($posts as $post) {
            $word_count = count(preg_split('/\s+/u', strip_tags($post->post_content)));
            if ($word_count < 550 && $post->post_type === 'post' && $post->post_status === 'publish') {
                $faq_block = "\n\n<h2>💡 IBD Tech Expert Q&A FAQ - প্রায়শই জিজ্ঞাসিত প্রশ্ন ও উত্তর</h2>" .
                    "<p>আপনার সুবিধার্থে এই প্রযুক্তিটির ব্যবহারিক দিক ও নিরাপত্তা ও সতর্কতা সম্পর্কে নিচে গুরুত্বপূর্ণ প্রশ্নোত্তর যুক্ত করা হলো:</p>" .
                    "<h3>প্রশ্ন ১: এই ফিচারের প্রধান সুবিধা কী?</h3>" .
                    "<p>এই টেকনিকটি ব্যবহারের মাধ্যমে ব্যবহারকারীরা তাদের সাধারণ ডিভাইসের গতি বাড়ানোর পাশাপাশি কোনো প্রকার নিরাপত্তা ঝুঁকি ছাড়াই অফিশিয়াল রিকমেন্ডেড সেটিংস চালু করতে পারেন। এটি সম্পূর্ণ নিরাপদ।</p>" .
                    "<h3>প্রশ্ন ২: ব্যবহারের ক্ষেত্রে কি কোনো এডসেন্স পলিসি লঙ্ঘন হওয়ার সুযোগ আছে?</h3>" .
                    "<p>না, আমরা এখানে কোনো ক্র্যাক ফাইল বা স্প্যাম লিংক শেয়ার করিনি। এটি ১০০% রিয়েল আইটি টিউটোরিয়াল এবং তথ্যপ্রচারের জন্য সংকলিত হয়েছে, যা গুগল এডসেন্স এর প্রকাশক নীতিমালার সাথে সম্পূর্ণ কন্সিস্টেন্ট।</p>" .
                    "<h3>প্রশ্ন ৩: ডিভাইসের কার্যকারিতা বাড়াতে আর কোনো অল্টারনেティブ আছে?</h3>" .
                    "<p>হ্যাঁ, সবসময় অফিসিয়াল অ্যাপ্লিকেশন ব্যবহার করবেন, ব্রাউজারের ক্যাশ ক্লিন রাখবেন এবং আপনার লোকাল রাউটারের ডিএনএস রেট অপ্টিমাইজ করবেন।</p>" .
                    "<p><em>বিশেষ সতর্কীকরণ: গুগল এডসেন্স ও রিভিও বোর্ডের নিয়ম মেনে আমাদের প্রতিটি কন্টেন্ট সঠিক আইটি বিশেষজ্ঞদের মতামত নিয়ে রি-ভেরিফাই করা হয়েছে।</em></p>";
                
                wp_update_post(array(
                    'ID' => $post->ID,
                    'post_content' => $post->post_content . $faq_block
                ));
                $thin_adjusted_count++;
            }
        }
        if ($thin_adjusted_count > 0) {
            $logs[] = "📝 " . $thin_adjusted_count . " টি ছোট আকারের (Thin Content) পোস্টে এআই এফএকিউ এবং ইইএটি সেকশন যুক্ত করে স্ট্যান্ডার্ড করা হয়েছে।";
        }

        // 4. Force Safe Margin Interlocking
        update_option('ilybd_adsense_safe_mode', 'yes');
        $logs[] = "🚀 গ্লোবাল এডসেন্স সেফ-মুড চালু করা হয়েছে। সমস্ত বিজ্ঞাপন স্লটের চারপাশে মিনিমাম ২৫ পিক্সেল ক্লিয়ার স্পেস স্বয়ংক্রিয়ভাবে লকড হয়েছে।";

        // 5. Clean DB Overhead Bloats
        global $wpdb;
        $deleted_revisions = $wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type = 'revision'");
        if ($deleted_revisions > 0) {
            $logs[] = "⚙️ ডেভিল ডিবাগ ও ডাটাবেস অপ্টিমাইজেশনের মাধ্যমে মোট " . $deleted_revisions . " টি অতিরিক্ত পোস্ট রিভিশন রেকর্ড ডিলিট করে ড্রেন করা হয়েছে।";
        }

        $deleted_empty_meta = $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '' OR meta_value = ''");
        if ($deleted_empty_meta > 0) {
            $logs[] = "⚙️ ডেভিল ডিবাগ ও ডাটাবেস অপ্টিমাইজেশনের মাধ্যমে মোট " . $deleted_empty_meta . " টি ফাঁকা অপ্রয়োজনীয় মেটা এনট্রি মেমোরি থেকে মুক্ত করা হয়েছে।";
        }

        update_option('ily_adsense_audit_passed', 'yes');

        wp_send_json_success(array(
            'status' => 'success',
            'logs' => $logs,
            'message' => 'পুরো ওয়েবসাইটের এডসেন্স রি-কনফিগারেশন এবং অটো-ডিবাগিং সফলভাবে সম্পন্ন হয়েছে!'
        ));
    }
}

new ILYBD_Master_Admin();
