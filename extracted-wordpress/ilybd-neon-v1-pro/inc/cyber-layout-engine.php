<?php
if (!defined('ABSPATH')) exit;

/* =========================
   LAYOUT POSITIONS
========================= */
function ilybd_get_layout_positions() {
    return [
        'after_header'   => 'After Header',
        'after_slider'   => 'After Slider',
        'after_featured' => 'After Featured',
        'after_popular'  => 'After Popular',
        'after_latest'   => 'After Latest',
        'sidebar'        => 'Sidebar',
        'footer'         => 'Footer'
    ];
}

/* =========================
   GET POSITION
========================= */
function ilybd_get_section_position($section) {
    return get_option("ilybd_pos_{$section}", 'after_slider');
}

/* =========================
   SAFE SECTION RENDERER
========================= */
function ilybd_render_section($section, $callback) {
    echo "<div class='ilybd-section ilybd-{$section}'>";
    call_user_func($callback);
    echo "</div>";
}

/* =========================
   HOOK SYSTEM (IMPORTANT FIX)
========================= */
function ilybd_should_render($section, $current_hook) {
    return ilybd_get_section_position($section) === $current_hook;
}