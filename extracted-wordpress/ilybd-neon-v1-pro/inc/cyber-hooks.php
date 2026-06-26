<?php
if (!defined('ABSPATH')) exit;

/* =========================
   SLIDER HOOK
========================= */
add_action('ilybd_slider', function () {
    if (get_option('ily_enable_slider', 1)) {
        get_template_part('template-parts/slider');
    }
});

/* =========================
   FEATURED HOOK
========================= */
add_action('ilybd_featured', function () {
    if (get_option('ily_enable_featured_posts', 1)) {
        get_template_part('template-parts/featured');
    }
});

/* =========================
   POPULAR HOOK
========================= */
add_action('ilybd_popular', function () {
    if (get_option('ily_enable_popular_posts', 1)) {
        get_template_part('template-parts/popular');
    }
});

/* =========================
   LATEST HOOK
========================= */
add_action('ilybd_latest', function () {
    get_template_part('template-parts/latest');
});

/* =========================
   CATEGORY HOOK
========================= */
add_action('ilybd_category', function () {
    if (get_option('ily_enable_categories', 1)) {
        get_template_part('template-parts/category');
    }
});

/* =========================
   Q&A HOOK
========================= */
add_action('ilybd_qa', function () {
    get_template_part('template-parts/qa');
});