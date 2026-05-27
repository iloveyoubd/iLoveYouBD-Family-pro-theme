<?php
/**
 * CYBER SPEED & PAGESPEED INSIGHTS COGNITIVE BOOSTER (MOBILE ENHANCED)
 * A clean, robust engine optimizing LCP, FCP, CLS, TBT, and Speed Index safely.
 */

if (!defined('ABSPATH')) exit;

/* -------------------------------------------------------------
   1. EARLY CONNECT AND DNS-PREFETCH ACCELERATOR (FCP & Speed Index)
   ------------------------------------------------------------- */
add_action('wp_head', function() {
    echo "\n<!-- [CYBER SPEED CORES] - DNS-PREFETCH & PRECONNECTS -->\n";
    echo '<style>
        /* Modern fast-loading image property */
        img { decoding: async !important; }
    </style>' . "\n";
    
    // Core external CDN API Pre-establishing connections
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
    echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />' . "\n";
    
    echo '<link rel="dns-prefetch" href="https://fonts.googleapis.com" />' . "\n";
    echo '<link rel="dns-prefetch" href="https://fonts.gstatic.com" />' . "\n";
    echo '<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com" />' . "\n";
    echo '<link rel="dns-prefetch" href="https://pagead2.googlesyndication.com" />' . "\n";

    // Dynamic High-Fidelity Preloading of LCP Hero Image
    if (is_singular() && has_post_thumbnail()) {
        $img_src = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        if ($img_src) {
            echo '<link rel="preload" href="' . esc_url($img_src) . '" as="image" fetchpriority="high" />' . "\n";
        }
    } else if (is_home() || is_front_page()) {
        // Preloads the first sticky or latest post thumbnail image if it exists on homepage
        $latest = get_posts(array('numberposts' => 1));
        if (!empty($latest)) {
            $img_src = get_the_post_thumbnail_url($latest[0]->ID, 'medium');
            if ($img_src) {
                echo '<link rel="preload" href="' . esc_url($img_src) . '" as="image" fetchpriority="high" />' . "\n";
            }
        }
    }
}, 1);

/* -------------------------------------------------------------
   2. ELIMINATE ONLY NON-CRITICAL RENDERING BLOCKED JS (TBT & FID)
   ------------------------------------------------------------- */
add_filter('script_loader_tag', function($tag, $handle) {
    if (is_admin()) {
        return $tag;
    }

    // List of non-critical backgrounds scripts to defer securely.
    // jQuery, Swiper, and core cyber UI logic are loaded normally in footer 
    // to prevent any timing issues that stall content painting!
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
        'swiper-bundle'
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
add_filter('wp_get_attachment_image_attributes', function($attr, $attachment, $size) {
    if (is_admin()) {
        return $attr;
    }

    // Set async rendering decoder globally
    $attr['decoding'] = 'async';

    global $wp_query;

    // Fast priority rendering for the topmost (LCP) element
    if (isset($wp_query->current_post) && $wp_query->current_post === 0 && !is_paged()) {
        $attr['fetchpriority'] = 'high';
        if (isset($attr['loading'])) {
            unset($attr['loading']); // Fetch LCP instantly, no delay
        }
    } else {
        // All below fold elements are lazy loaded
        $attr['loading'] = 'lazy';
    }

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
   6. HIGH-FIDELITY INTELLIGENT GOOGLE ADSENSE & ANALYTICS LAZY-LOADER (REMOVED)
   ------------------------------------------------------------- */
