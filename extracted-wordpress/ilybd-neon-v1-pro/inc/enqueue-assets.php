<?php
/**
 * ILYBD Neon v1 Pro - Asset Loader (Advanced Cyber Engine)
 * Fixed: Added Swiper JS & CSS for Slider Engine
 */

if (!defined('ABSPATH')) exit;

function ilybd_neon_assets() {

    /* =========================
       1. GOOGLE FONTS
    ========================= */
    wp_enqueue_style(
        'ilybd-google-fonts',
        'https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@300;500;700&display=swap',
        [],
        null
    );

    /* Enqueue WordPress Dashicons natively */
    wp_enqueue_style('dashicons');

    /* Enqueue premium Font Awesome vector icon packs */
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css',
        [],
        '6.4.2'
    );

    /* =========================
       2. SWIPER JS & CSS (NEW: SLIDER ENGINE)
       এটি স্লাইডার সচল করার জন্য ইন্টারনেট থেকে অটোমেটিক লোড হবে।
    ========================= */
    wp_enqueue_style(
        'swiper-bundle',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );

    wp_enqueue_script(
        'swiper-bundle',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0.0',
        true
    );

    /* =========================
       3. MAIN THEME STYLE
    ========================= */
    wp_enqueue_style(
        'ilybd-main-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );

    wp_enqueue_style(
        'cyber-core',
        get_template_directory_uri() . '/assets/css/cyber-core.css',
        [],
        '1.0.0'
    );

    wp_enqueue_script(
        'ilybd-realtime',
        get_template_directory_uri() . '/assets/js/realtime.js',
        ['jquery'],
        '1.0.0',
        true
    );

    /* =========================
       4. CYBER UI CORE STYLES
    ========================= */
    wp_enqueue_style(
        'ilybd-neon-ui',
        get_template_directory_uri() . '/assets/css/main-neon.css',
        ['ilybd-main-style'],
        '1.0.0'
    );

    wp_enqueue_style(
        'ilybd-animations',
        get_template_directory_uri() . '/assets/css/animations.css',
        ['ilybd-neon-ui'],
        '1.0.0'
    );

    /* =========================
       5. CORE CYBER JS ENGINE
    ========================= */
    wp_enqueue_script(
        'ilybd-cyber-logic',
        get_template_directory_uri() . '/assets/js/cyber-logic.js',
        ['jquery', 'swiper-bundle'], // Swiper load হওয়ার পর এটি লোড হবে
        '1.0.0',
        true
    );

    /* =========================
       6. DYNAMIC UI CONFIG (PHP → JS)
    ========================= */
    $user_id = get_current_user_id();
    $neon_color = get_option('ilybd_main_color', '#00ff41');

    if ($user_id) {
        $user_color = get_user_meta($user_id, 'user_accent_color', true);
        if (!empty($user_color)) {
            $neon_color = $user_color;
        }
    }

    $user_xp = 0;
    if ($user_id) {
        $user_xp = (int)get_user_meta($user_id, 'ilybd_total_points', true);
    }
    $tier = 'Guest';
    $tier_color = '#00ff41';
    $speed = 12;
    if ($user_xp >= 50 && $user_xp < 200) {
        $tier = 'Member';
        $tier_color = '#00f0ff';
        $speed = 7;
    } elseif ($user_xp >= 200) {
        $tier = 'Elite';
        $tier_color = '#b100ff';
        $speed = 2;
    }

    wp_localize_script('ilybd-cyber-logic', 'ilybd_vfx', [
        'ajax_url'   => admin_url('admin-ajax.php'),
        'neon_color' => $neon_color,
        'user_id'    => $user_id,
        'site_url'   => home_url(),
        'user_xp'    => $user_xp,
        'tier'       => $tier,
        'tier_color' => $tier_color,
        'type_speed' => $speed,
    ]);

    /* =========================
       7. OPTIONAL: COMMENT SCRIPT
    ========================= */
    if (is_singular()) {
        wp_enqueue_script(
            'ilybd-comment-engine',
            get_template_directory_uri() . '/assets/js/comment-engine.js',
            ['jquery', 'ilybd-cyber-logic'],
            '1.0.0',
            true
        );
    }

    /* =========================
       7.1 FRONTEND WORDPRESS CLASSIC EDITOR ENQUEUER
    ========================= */
    if (is_page_template('page-dashboard.php')) {
        wp_enqueue_editor();
    }
}
add_action('wp_enqueue_scripts', 'ilybd_neon_assets');

/* =========================
   8. ADMIN SAFE HOOK
========================= */
function ilybd_admin_assets() {
    wp_enqueue_style(
        'ilybd-admin-ui',
        get_template_directory_uri() . '/assets/css/admin.css',
        [],
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'ilybd_admin_assets');

/* =========================================================
   9. PERFORMANCE OPTIMIZATION: DEFER / ASYNC SCRIPT LOADER
   ========================================================= */
function ilybd_defer_scripts($tag, $handle, $src) {
    if (is_admin()) {
        return $tag;
    }
    $defer_handles = array('swiper-bundle', 'ilybd-comment-engine', 'ilybd-realtime', 'ilybd-cyber-logic');
    if (in_array($handle, $defer_handles)) {
        return str_replace(' src=', ' defer="defer" src=', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'ilybd_defer_scripts', 10, 3);
