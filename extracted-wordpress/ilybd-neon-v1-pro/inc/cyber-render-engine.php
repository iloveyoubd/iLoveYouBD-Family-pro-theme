<?php
if (!defined('ABSPATH')) exit;

/* =========================
   SLIDER
========================= */
add_action('ilybd_slider', function () {
    if (get_option('ily_enable_slider', 1)) {
        get_template_part('template-parts/slider-main');
    }
});

/* =========================
   FEATURED
========================= */
add_action('ilybd_featured', function () {
    if (get_option('ily_enable_featured_posts', 1)) {
        get_template_part('template-parts/featured-main');
    }
});

/* =========================
   POPULAR
========================= */
add_action('ilybd_popular', function () {
    if (get_option('ily_enable_popular_posts', 1)) {
        get_template_part('template-parts/popular-main');
    }
});

/* =========================
   LATEST POSTS (DEFAULT LOOP)
========================= */
add_action('ilybd_latest', function () {
    get_template_part('template-parts/content-fed');
});

/* =========================
   CATEGORY
========================= */
add_action('ilybd_category', function () {
    if (get_option('ily_enable_categories', 1)) {
        // optional fallback
    }
});

/* =========================
   Q&A
========================= */
add_action('ilybd_qa', function () {
    get_template_part('template-parts/community-qa');
});

/* =========================
   HEADER + NAV
========================= */
add_action('ilybd_after_header', function () {
    // get_template_part('template-parts/fb-header'); // Removed as requested
});