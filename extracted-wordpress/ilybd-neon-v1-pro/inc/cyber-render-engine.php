<?php
if (!defined('ABSPATH')) exit;

/* =========================
   SLIDER
========================= */
add_action('ilybd_slider', function () {
    get_template_part('template-parts/slider-main');
});

/* =========================
   FEATURED
========================= */
add_action('ilybd_featured', function () {
    get_template_part('template-parts/featured-main');
});

/* =========================
   POPULAR
========================= */
add_action('ilybd_popular', function () {
    get_template_part('template-parts/popular-main');
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
    // optional fallback
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