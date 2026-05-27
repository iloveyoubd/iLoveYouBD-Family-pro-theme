<?php
if (!defined('ABSPATH')) exit;

/* =========================
   SLIDER HOOK
========================= */
add_action('ilybd_slider', function () {
    get_template_part('template-parts/slider');
});

/* =========================
   FEATURED HOOK
========================= */
add_action('ilybd_featured', function () {
    get_template_part('template-parts/featured');
});

/* =========================
   POPULAR HOOK
========================= */
add_action('ilybd_popular', function () {
    get_template_part('template-parts/popular');
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
    get_template_part('template-parts/category');
});

/* =========================
   Q&A HOOK
========================= */
add_action('ilybd_qa', function () {
    get_template_part('template-parts/qa');
});