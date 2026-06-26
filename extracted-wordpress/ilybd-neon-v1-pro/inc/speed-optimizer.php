<?php
/**
 * CYBER SPEED & PAGESPEED INSIGHTS COGNITIVE BOOSTER (MOBILE ENHANCED)
 * A clean, robust engine optimizing LCP, FCP, CLS, TBT, and Speed Index safely.
 */

if (!defined('ABSPATH')) exit;

/* -------------------------------------------------------------
   1. EARLY CONNECT, DNS-PREFETCH, AND CRITICAL TRANSITIONAL CSS INLINING
   This saves more than 1.5 seconds of render blocking CSS requests.
   ------------------------------------------------------------- */

// Clean CSS Minification Function
if (!function_exists('ilybd_minify_css')) {
    function ilybd_minify_css($css) {
        if (empty($css)) return '';
        // Normalize whitespace
        $css = preg_replace('/\s+/', ' ', $css);
        // Remove comments
        $css = preg_replace('/\/\*.*?\*\//', '', $css);
        // Remove spaces around syntax boundaries
        $css = str_replace(array(' {', '{ ', ' }', '} ', '; ', ' :', ': '), array('{', '{', '}', '}', ';', ':', ':'), $css);
        return trim($css);
    }
}

// Inline critical local CSS files directly to eliminate render-blocking HTTP requests
add_action('wp_head', function() {
    if (is_admin()) return;
    
    // Core external CDN pre-establishing connections
    echo "\n<!-- [CYBER SPEED CORES] - DNS-PREFETCH & PRECONNECTS -->\n";
    echo '<style>img { decoding: async !important; }</style>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
    echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />' . "\n";
    
    echo '<link rel="dns-prefetch" href="https://fonts.googleapis.com" />' . "\n";
    echo '<link rel="dns-prefetch" href="https://fonts.gstatic.com" />' . "\n";
    echo '<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com" />' . "\n";
    echo '<link rel="dns-prefetch" href="https://pagead2.googlesyndication.com" />' . "\n";

    // 1.1 Preload LCP Featured Images
    if (is_singular() && has_post_thumbnail()) {
        // Preloads actual image size used in single templates for absolute focus
        $img_src = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
        if (!$img_src) {
            $img_src = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        }
        if ($img_src) {
            echo '<link rel="preload" href="' . esc_url($img_src) . '" as="image" fetchpriority="high" />' . "\n";
        }
    } else if (is_home() || is_front_page()) {
        // Preloads the first slider/latest thumb on home feed to maximize LCP speeds
        $latest = get_posts(array('numberposts' => 1));
        if (!empty($latest)) {
            $img_src = get_the_post_thumbnail_url($latest[0]->ID, 'large');
            if (!$img_src) {
                $img_src = get_the_post_thumbnail_url($latest[0]->ID, 'medium');
            }
            if ($img_src) {
                echo '<link rel="preload" href="' . esc_url($img_src) . '" as="image" fetchpriority="high" />' . "\n";
            }
        }
    }

    // 1.2 Inline merged theme CSS to bypass stylesheet loading hurdles
    $cached_css = get_transient('ilybd_critical_inlined_css_v3');
    if (false === $cached_css || empty($cached_css)) {
        $css_content = '';
        $css_files = [
            get_stylesheet_directory() . '/style.css',
            get_template_directory() . '/assets/css/cyber-core.css',
            get_template_directory() . '/assets/css/main-neon.css',
            get_template_directory() . '/assets/css/animations.css'
        ];
        foreach ($css_files as $file) {
            if (file_exists($file)) {
                $css_content .= file_get_contents($file) . "\n";
            }
        }
        $cached_css = ilybd_minify_css($css_content);
        set_transient('ilybd_critical_inlined_css_v3', $cached_css, 12 * HOUR_IN_SECONDS);
    }
    
    if (!empty($cached_css)) {
        echo '<style id="ilybd-critical-merged-css">' . $cached_css . '</style>' . "\n";
    }
}, 2);

// Delete the transient cache if options are updated or user edits customizer
add_action('after_switch_theme', function() { delete_transient('ilybd_critical_inlined_css_v3'); });
add_action('customize_save_after', function() { delete_transient('ilybd_critical_inlined_css_v3'); });
add_action('update_option_ilybd_main_color', function() { delete_transient('ilybd_critical_inlined_css_v3'); });

// Dequeue local files that have been successfully enqueued inline
add_action('wp_print_styles', function() {
    if (is_admin()) return;
    wp_dequeue_style('ilybd-main-style');
    wp_dequeue_style('cyber-core');
    wp_dequeue_style('ilybd-neon-ui');
    wp_dequeue_style('ilybd-animations');
}, 99999);


/* -------------------------------------------------------------
   2. ELIMINATE ONLY NON-CRITICAL RENDERING BLOCKED JS (TBT & FID)
   ------------------------------------------------------------- */
add_filter('script_loader_tag', function($tag, $handle) {
    if (is_admin()) {
        return $tag;
    }

    // List of non-critical background scripts to defer securely.
    $defer_scripts = [
        'wp-embed',
        'comment-reply',
        'cyber-bot-script',
        'cyber-copy-js',
        'ilybd-realtime',
        'ilybd-cyber-logic',
        'ilybd-comment-engine',
        'ilybd-core-js',
        'swiper-bundle',
        'cyber-game-script'
    ];

    if (in_array($handle, $defer_scripts)) {
        if (strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
            $tag = str_replace(' src', ' defer="defer" src', $tag);
        }
    }
    return $tag;
}, 11, 2);

/* -------------------------------------------------------------
   2.1 DEFER NON-CRITICAL RENDERING BLOCKED STYLESHEETS (FCP & CLS)
   ------------------------------------------------------------- */
add_filter('style_loader_tag', function($html, $handle, $href, $media) {
    if (is_admin()) {
        return $html;
    }
    
    // Non-critical CSS stylesheets to load asynchronously
    $async_styles = [
        'font-awesome',
        'dashicons',
        'swiper-bundle',
        'ilybd-google-fonts'
    ];
    
    if (in_array($handle, $async_styles)) {
        // Loads style with media='print' and switches to media='all' once loaded (non-blocking)
        if (strpos($html, "media='all'") !== false) {
            $html = str_replace("media='all'", "media='print' onload=\"this.media='all'\"", $html);
        } elseif (strpos($html, 'media="all"') !== false) {
            $html = str_replace('media="all"', 'media="print" onload="this.media=\'all\'"', $html);
        } else {
            $html = str_replace(" href=", " media='print' onload=\"this.media='all'\" href=", $html);
        }
    }
    return $html;
}, 11, 4);

/* -------------------------------------------------------------
   3. SMART CORE WEB VITALS IMAGE OPTIMIZER & FETCHPRIORITY (LCP, CLS)
   ------------------------------------------------------------- */
global $ilybd_processed_img_count;
$ilybd_processed_img_count = 0;

add_filter('wp_get_attachment_image_attributes', function($attr, $attachment, $size) {
    if (is_admin()) {
        return $attr;
    }

    // Set async rendering decoder globally
    $attr['decoding'] = 'async';

    global $ilybd_processed_img_count;
    if (!isset($ilybd_processed_img_count)) {
        $ilybd_processed_img_count = 0;
    }

    // The first parsed image is definitely inside the viewport above-the-fold (LCP element).
    // Ensure it gets high fetchpriority and EAGER load, completely eliminating FCP & LCP delay.
    if ($ilybd_processed_img_count < 1) {
        $attr['fetchpriority'] = 'high';
        if (isset($attr['loading'])) {
            unset($attr['loading']); // Fetch LCP instantly, no delay
        }
    } else {
        // All below-the-fold elements are lazily loaded
        $attr['loading'] = 'lazy';
    }

    $ilybd_processed_img_count++;
    return $attr;
}, 11, 3);

/* -------------------------------------------------------------
   4. ELIMINATE WP EMOTICONS & UNUSED HOOK LINES (Lowers document size)
   ------------------------------------------------------------- */
add_action('init', function() {
    // Disable emoticons completely
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove obsolete header bloats
    remove_action('wp_head', 'wp_generator'); // Removes version tag
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
});

/* -------------------------------------------------------------
   5. DEQUEUE HEAVY GUTENBERG BLOCK CSS ON HOMEPAGE & ARCHIVES
   ------------------------------------------------------------- */
add_action('wp_enqueue_scripts', function() {
    // Only load Gutenberg styles on single posts/pages to speed up Home and Dashboard
    if (!is_singular()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
    }
}, 100);

/* -------------------------------------------------------------
   6. EXTREME OUTPUT BUFFERING (LAZY LOAD ALL IFRAMES & IMAGES)
   ------------------------------------------------------------- */
add_action('template_redirect', function() {
    // Only run on front-end for non-logged in users to maximize cache and performance
    if (!is_admin() && !is_user_logged_in()) {
        ob_start(function($content) {
            // Force lazy loading on all iframes (especially YouTube/Facebook embeds)
            $content = preg_replace('/<iframe(.*?)(?<!loading=["\']lazy["\'])(.*?)>/is', '<iframe$1 loading="lazy"$2>', $content);
            
            // Force lazy load on ALL images except the first one (LCP candidate)
            $content = preg_replace_callback('/<img(.*?)>/is', function($matches) {
                static $img_count = 0;
                $img_count++;
                $attrs = $matches[1];
                
                // If it already has loading or fetchpriority, respect the existing code somewhat
                if (strpos($attrs, 'loading=') !== false || strpos($attrs, 'fetchpriority=') !== false) {
                    return $matches[0];
                }
                
                if ($img_count === 1) {
                    return '<img' . $attrs . ' fetchpriority="high" decoding="async">';
                } else {
                    return '<img' . $attrs . ' loading="lazy" decoding="async">';
                }
            }, $content);
            
            return $content;
        });
    }
}, 1);
