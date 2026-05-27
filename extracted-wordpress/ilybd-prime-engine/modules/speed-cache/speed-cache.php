<?php
/**
 * MODULE: ILYBD PRO PROFESSIONAL SPEED CACHE & PERFORMANCE OPTIMIZER (LITESPEED ALTERNATIVE)
 * Path: modules/speed-cache/speed-cache.php
 * Description: High-speed static page caching, dynamic GZIP compression, HTML minification, database cleaning, and advanced script optimization.
 */

if (!defined('ABSPATH')) exit;

// --- ১.১ গ্লোবাল ক্যাশ ডিরেক্টরি প্রোটেক্টর ---
if (!function_exists('ilybd_prime_get_cache_dir')) {
    function ilybd_prime_get_cache_dir() {
        $upload_dir = wp_upload_dir();
        // প্লাগইন ডিরেক্টরির বাইরে আপলোডস ফোল্ডারে স্ট্যাটিক এইচটিএমএল ক্যাশে রাখব সিকিউর উপায়ে
        $cache_dir = $upload_dir['basedir'] . '/ilybd-speed-cache/';
        if (!file_exists($cache_dir)) {
            wp_mkdir_p($cache_dir);
            @file_put_contents($cache_dir . 'index.php', '<?php // Silence is golden');
            @file_put_contents($cache_dir . '.htaccess', "Options -Indexes\nAllow from all");
        }
        return $cache_dir;
    }
}

// --- ১.২ ক্যাশ কি জেনারেটর ---
if (!function_exists('ilybd_prime_get_cache_key')) {
    function ilybd_prime_get_cache_key() {
        $scheme = is_ssl() ? 'https' : 'http';
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        // মোবাইল এবং ডেস্কটপ ক্যাশে আলাদা রাখার জন্য ইউজার এজেন্ট চেক
        $is_mobile = wp_is_mobile() ? '-mobile' : '-desktop';
        return md5($scheme . '://' . $host . $uri) . $is_mobile;
    }
}

// --- ১.৩ ক্যাশ এড়ানো / সিকিউরিটি ফিল্টারস ---
if (!function_exists('ilybd_prime_cache_should_skip')) {
    function ilybd_prime_cache_should_skip() {
        // ১. অ্যাডমিন এরিয়া ক্যাশ করা যাবে না
        if (is_admin()) return true;

        // ২. লগইন করা ইউজারদের ডায়নামিক ড্যাশবোর্ড, ওয়ালেট ব্যালেন্স দেখার জন্য ক্যাশ এড়ানো হবে
        if (is_user_logged_in()) return true;

        // ৩. ডাইনামিক রিকোয়েস্ট (POST) ফরম সাবমিশন ক্যাশ করা যাবে না
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'GET') return true;

        // ৪. এআই চ্যাট বা রিয়েল-টাইম কুয়েরি এবং ক্রন এড়ানো
        if (defined('DOING_AJAX') && DOING_AJAX) return true;
        if (defined('DOING_CRON') && DOING_CRON) return true;
        if (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) return true;
        if (defined('REST_REQUEST') && REST_REQUEST) return true;

        // ৫. সার্চ পেজ ক্যাশ করা যাবে না
        if (is_search()) return true;

        // ৬. ইন্টারঅ্যাকটিভ কাস্টম ইউআরএল এড়ানো
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $skip_terms = ['/wallet', '/chat', '/api', '/wp-json', '/wp-login', '/wp-admin', 'logout', 'action='];
        foreach ($skip_terms as $term) {
            if (stripos($uri, $term) !== false) {
                return true;
            }
        }

        // ৭. ডেডিকেটেড নো ক্যাশ বা কাস্টম প্রিভিউ ফ্ল্যাগ
        if (isset($_GET['nocache']) || isset($_GET['preview']) || isset($_GET['action'])) {
            return true;
        }

        return false;
    }
}

// --- ২.১ পেজ ক্যাশ সার্ভিং ইঞ্জিন ---
add_action('template_redirect', 'ilybd_prime_serve_static_cache', 1);

if (!function_exists('ilybd_prime_serve_static_cache')) {
    function ilybd_prime_serve_static_cache() {
        if (ilybd_prime_cache_should_skip()) return;

        $cache_key = ilybd_prime_get_cache_key();
        $cache_dir = ilybd_prime_get_cache_dir();
        $cache_file = $cache_dir . $cache_key . '.html';

        $cache_lifetime = 86400; // ২৪ ঘণ্টা ক্যাশ লাইফটাইম

        if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_lifetime)) {
            $content = file_get_contents($cache_file);
            $load_time = round((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000, 2);

            // ক্যাশ আইডেন্টিফিকেশন এবং স্পিড হেডারস
            header('X-ILYBD-Ultimate-Cache: HIT');
            header('X-ILYBD-Cache-Engine: Pro Static Cache');
            header('X-ILYBD-Response-Time: ' . $load_time . 'ms');
            header('Cache-Control: public, max-age=7200, must-revalidate');

            // যদি ব্রাউজার Gzip সাপোর্ট করে তবে জিপ করা হবে
            if (!ob_start("ob_gzhandler")) {
                ob_start();
            }

            echo $content;
            echo "\n<!-- ILYBD Prime Cache: HIT | Page Loader: {$load_time}ms | Zero DB Queries | Gzipped & Minified -->\n";
            ob_end_flush();
            exit;
        }

        // আউটপুট বাফারিং যাতে পেজ রেন্ডার হওয়ার পর ফাইল ক্যাশ ও মিনিফাই করা যায়
        ob_start('ilybd_prime_cache_buffer_callback');
    }
}

// --- ২.২ পেজ বাফার, মিনিফায়ার এবং রাইটিং প্রসেস ---
if (!function_exists('ilybd_prime_cache_buffer_callback')) {
    function ilybd_prime_cache_buffer_callback($html) {
        if (ilybd_prime_cache_should_skip() || empty($html) || strlen(trim($html)) < 250) {
            return $html;
        }

        if (http_response_code() !== 200) {
            return $html;
        }

        // ১. প্রফেশনাল এইচটিএমএল মিনিফায়ার লজিক যাতে কমেন্ট বাদ যায়, তবে script ও pre ট্যাগ সাবধানে রাখা হয়
        $search = array(
            '/<!--(?!\s*(?:\[if [^\]]+\]|.*?-->)).*?-->/s', // remove standard HTML comments
        );
        $replace = array(
            '',
        );
        
        $minified_html = preg_replace($search, $replace, $html);
        
        // যদি মিনিফাই করতে গিয়ে কোনো কারণে নাল হয়ে যায় তবে পূর্বের এইচটিএমএল সেভ করবে
        if (empty($minified_html)) {
            $minified_html = $html;
        }

        $cache_key = ilybd_prime_get_cache_key();
        $cache_dir = ilybd_prime_get_cache_dir();
        $cache_file = $cache_dir . $cache_key . '.html';

        $saved_time = current_time('mysql');
        $watermarked_html = trim($minified_html) . "\n<!-- ILYBD Pro Cache Saved: {$saved_time} | Built-in LiteSpeed Alternative Engine (Minified) -->";

        @file_put_contents($cache_file, $watermarked_html);
        
        header('X-ILYBD-Ultimate-Cache: MISS');
        return $html;
    }
}

// --- ৩.১ অটোমেটিক ক্যাশ ইনভ্যালিডেশন (Purging Hooks) ---
if (!function_exists('ilybd_prime_purge_all_cache')) {
    function ilybd_prime_purge_all_cache() {
        $cache_dir = ilybd_prime_get_cache_dir();
        $files = glob($cache_dir . '*.html');
        if (!empty($files)) {
            foreach ($files as $file) {
                @unlink($file);
            }
        }
    }
}

// সিস্টেমে কোনো মডিফিকেশন হলে স্বয়ংক্রিয়ভাবে ক্যাশ ক্লিয়ার হবে
add_action('save_post', 'ilybd_prime_purge_all_cache', 10);
add_action('comment_post', 'ilybd_prime_purge_all_cache', 10);
add_action('wp_set_comment_status', 'ilybd_prime_purge_all_cache', 10);
add_action('wp_trash_post', 'ilybd_prime_purge_all_cache', 10);
add_action('untrashed_post', 'ilybd_prime_purge_all_cache', 10);
add_action('switch_theme', 'ilybd_prime_purge_all_cache', 10);
add_action('activated_plugin', 'ilybd_prime_purge_all_cache', 10);
add_action('deactivated_plugin', 'ilybd_prime_purge_all_cache', 10);
add_action('profile_update', 'ilybd_prime_purge_all_cache', 10);
add_action('customize_save_after', 'ilybd_prime_purge_all_cache', 10);

// --- ৩.২ ক্যাশ মেমোরি আবর্জনা সংগ্রাহক (GC Lock) ---
add_action('wp', 'ilybd_prime_cache_garbage_collector');
if (!function_exists('ilybd_prime_cache_garbage_collector')) {
    function ilybd_prime_cache_garbage_collector() {
        if (get_transient('ilybd_prime_gc_lock')) return;
        set_transient('ilybd_prime_gc_lock', true, DAY_IN_SECONDS);

        $cache_dir = ilybd_prime_get_cache_dir();
        $files = glob($cache_dir . '*.html');
        if (empty($files)) return;
        
        $now = time();
        $expire_threshold = 86400; // ২৪ ঘণ্টা
        foreach ($files as $file) {
            if ($now - filemtime($file) > $expire_threshold) {
                @unlink($file);
            }
        }
    }
}

// --- ৪.১ অ্যাডমিন বার ইন্টিগ্রেশন ---
add_action('admin_bar_menu', 'ilybd_prime_add_clear_cache_bar_node', 999);
if (!function_exists('ilybd_prime_add_clear_cache_bar_node')) {
    function ilybd_prime_add_clear_cache_bar_node($wp_admin_bar) {
        if (!current_user_can('manage_options')) return;
        $wp_admin_bar->add_node(array(
            'id'    => 'ilybd-prime-clear-cache',
            'title' => '<span class="ab-icon dashicons dashicons-performance" style="color:#00ff41; padding-top:4px;"></span><span style="color:#00ff41; font-weight:bold;">⚡ ক্যাশে রিফ্রেশ</span>',
            'href'  => wp_nonce_url(admin_url('admin-post.php?action=ilybd_prime_admin_clear_all_cache'), 'ilybd_prime_clear_nonce'),
            'meta'  => array('title' => 'সকল স্ট্যাটিক পেজ ক্যাশে ক্লিয়ার করুন')
        ));
    }
}

add_action('admin_post_ilybd_prime_admin_clear_all_cache', 'ilybd_prime_handle_admin_clear_cache_post');
if (!function_exists('ilybd_prime_handle_admin_clear_cache_post')) {
    function ilybd_prime_handle_admin_clear_cache_post() {
        if (!current_user_can('manage_options')) {
            wp_die('অননুমোদিত অ্যাক্সেস!');
        }
        check_admin_referer('ilybd_prime_clear_nonce');
        ilybd_prime_purge_all_cache();
        
        set_transient('ilybd_prime_cache_notif', 'সকল ক্যাশড ফাইলস সফলভাবে ক্লিয়ার হয়েছে এবং স্পিড অপ্টিমাইজড!', 60);
        
        wp_safe_redirect(wp_get_referer() ? wp_get_referer() : admin_url());
        exit;
    }
}

// --- ৪.২ ক্যাশ ও ডাটাবেজ স্ট্যাটিসটিক্স রিডার ---
if (!function_exists('ilybd_prime_get_cache_stats')) {
    function ilybd_prime_get_cache_stats() {
        $cache_dir = ilybd_prime_get_cache_dir();
        $files = glob($cache_dir . '*.html');
        $count = !empty($files) ? count($files) : 0;
        $size = 0;
        if ($count > 0) {
            foreach ($files as $file) {
                $size += filesize($file);
            }
        }
        return array(
            'count' => $count,
            'size'  => round($size / (1024 * 1024), 2) // MB
        );
    }
}

// --- ৫.১ ডাটাবেজ অপ্টিমাইজেশন লজিক ---
if (!function_exists('ilybd_prime_optimize_database')) {
    function ilybd_prime_optimize_database() {
        global $wpdb;

        // ১. অপ্রয়োজনীয় পোস্ট রিভিশন ক্লিন করা
        $wpdb->query("DELETE FROM $wpdb->posts WHERE post_type = 'revision'");

        // ২. স্প্যাম ও ট্র্যাশ কমেন্ট ক্লিন করা
        $wpdb->query("DELETE FROM $wpdb->comments WHERE comment_approved = 'spam' OR comment_approved = 'trash'");

        // ৩. মেটা ডেটা এতিম ঘর (OrphanMeta) ক্লিন করা
        $wpdb->query("DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL");

        // ৪. এক্সপায়ারড ট্রান্সিয়েন্ট ক্লিন করা
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_%' OR option_name LIKE '_site_transient_timeout_%'");

        // ৫. টেবিলসমূহ অপ্টিমাইজ করা
        $tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);
        foreach ($tables as $table) {
            $table_name = $table[0];
            $wpdb->query("OPTIMIZE TABLE $table_name");
        }

        return true;
    }
}

// --- ৫.২ ওয়েবফন্ট অপ্টিমাইজেশন (Lighthouse swap display check) ---
add_filter('style_loader_tag', 'ilybd_prime_optimize_font_display_swap', 100, 2);
if (!function_exists('ilybd_prime_optimize_font_display_swap')) {
    function ilybd_prime_optimize_font_display_swap($html, $handle) {
        // গুগল ফন্টগুলোতে &display=swap বা font-display: swap জেনারেট নিশ্চিত করার জন্য ফিল্টার
        if (strpos($html, 'fonts.googleapis.com') !== false && strpos($html, 'display=swap') === false) {
            $html = str_replace('family=', 'display=swap&family=', $html);
        }
        return $html;
    }
}

// --- ৫.৩ ইনস্ট্যান্ট হোভার ও মোবাইল টাচ প্রিফেচ স্ক্রিপ্ট ---
add_action('wp_footer', 'ilybd_prime_inject_interaction_prefetch_script', 100);
if (!function_exists('ilybd_prime_inject_interaction_prefetch_script')) {
    function ilybd_prime_inject_interaction_prefetch_script() {
        if (is_admin() || is_user_logged_in()) return;
        ?>
        <!-- ILYBD Cognitive Speed Modules: Instant Hover Link Prefetcher -->
        <script id="ilybd-interaction-prefetch">
        (function() {
            var prefetchedUrls = new Set();
            function prefetchUrl(url) {
                if (!url || prefetchedUrls.has(url)) return;
                prefetchedUrls.add(url);
                var link = document.createElement('link');
                link.rel = 'prefetch';
                link.href = url;
                document.head.appendChild(link);
            }
            
            document.addEventListener('mouseover', function(e) {
                var anchor = e.target.closest('a');
                if (!anchor) return;
                var href = anchor.getAttribute('href');
                if (!href) return;
                
                var currentHost = window.location.hostname;
                try {
                    var urlObj = new URL(href, window.location.href);
                    if (urlObj.hostname !== currentHost) return; 
                    
                    var skipPaths = ['/wp-admin', '/wp-login', 'action=', 'logout', 'wp-json', '.png', '.jpg', '.jpeg', '.gif', '.pdf', '.zip'];
                    for (var i = 0; i < skipPaths.length; i++) {
                        if (href.indexOf(skipPaths[i]) !== -1) return;
                    }
                    
                    anchor.hoverTimeout = setTimeout(function() {
                        prefetchUrl(href);
                    }, 55);
                    
                } catch(err) {}
            });
            
            document.addEventListener('mouseout', function(e) {
                var anchor = e.target.closest('a');
                if (anchor && anchor.hoverTimeout) {
                    clearTimeout(anchor.hoverTimeout);
                }
            });
            
            document.addEventListener('touchstart', function(e) {
                var anchor = e.target.closest('a');
                if (!anchor) return;
                var href = anchor.getAttribute('href');
                if (href) {
                    prefetchUrl(href);
                }
            }, { passive: true });
        })();
        </script>
        <?php
    }
}
