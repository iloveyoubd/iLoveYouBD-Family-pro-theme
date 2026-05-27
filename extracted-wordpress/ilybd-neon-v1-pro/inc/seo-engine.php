<?php
/**
 * ILYBD Neon Pro - SEO Engine v3 (Autopilot Rank System)
 * Full Optimization Layer for Google + Social + Crawlers
 */

if (!defined('ABSPATH')) exit;


/* =========================
   GLOBAL SEO CONTROL
========================= */
function ilybd_get_seo_data() {
    global $post;

    return array(
        'title' => get_the_title(),
        'desc'  => wp_trim_words(strip_tags($post->post_content ?? ''), 30),
        'url'   => get_permalink(),
        'img'   => get_the_post_thumbnail_url($post->ID ?? 0, 'full'),
        'author'=> get_the_author(),
        'date'  => get_the_date('c'),
        'modified' => get_the_modified_date('c')
    );
}


/* =========================
   META + SOCIAL TAGS
========================= */
add_action('wp_head', function () {

    if (!is_single()) return;

    $seo = ilybd_get_seo_data();

    ?>

    <!-- BASIC SEO -->
    <meta name="description" content="<?php echo esc_attr($seo['desc']); ?>">
    <meta name="author" content="<?php echo esc_attr($seo['author']); ?>">
    <link rel="canonical" href="<?php echo esc_url($seo['url']); ?>">

    <!-- OPEN GRAPH -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?php echo esc_attr($seo['title']); ?>">
    <meta property="og:description" content="<?php echo esc_attr($seo['desc']); ?>">
    <meta property="og:url" content="<?php echo esc_url($seo['url']); ?>">
    <meta property="og:image" content="<?php echo esc_url($seo['img']); ?>">

    <!-- TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($seo['title']); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($seo['desc']); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($seo['img']); ?>">

    <!-- ROBOTS CONTROL -->
    <meta name="robots" content="index, follow, max-image-preview:large">

    <?php
});


/* =========================
   ADVANCED JSON-LD SCHEMA (ARTICLE + WEBPAGE)
========================= */
add_action('wp_head', function () {

    if (!is_single()) return;

    $seo = ilybd_get_seo_data();

    $schema = array(
        "@context" => "https://schema.org",
        "@graph" => array(

            // ARTICLE
            array(
                "@type" => "Article",
                "headline" => $seo['title'],
                "description" => $seo['desc'],
                "image" => $seo['img'],
                "author" => array(
                    "@type" => "Person",
                    "name" => $seo['author']
                ),
                "datePublished" => $seo['date'],
                "dateModified" => $seo['modified']
            ),

            // WEBPAGE ENTITY
            array(
                "@type" => "WebPage",
                "@id" => $seo['url'],
                "url" => $seo['url'],
                "name" => $seo['title']
            )
        )
    );

    echo '<script type="application/ld+json">' .
        wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) .
    '</script>';
});


/* =========================
   AUTO INTERNAL SEO BOOST SIGNALS
========================= */
add_action('wp_head', function () {

    if (!is_single()) return;

    global $post;

    // Post engagement signals (future ranking logic support)
    $views = (int) get_post_meta($post->ID, 'ilybd_post_views_count', true);
    $likes = (int) get_post_meta($post->ID, '_likes', true);

    echo "\n<!-- SEO SIGNAL DATA -->\n";
    echo "<meta name='post-views' content='{$views}'>\n";
    echo "<meta name='post-likes' content='{$likes}'>\n";
});


/* =========================
   INDEX CONTROL SMART RULE
========================= */
add_action('wp_head', function () {

    if (is_search() || is_404()) {
        echo '<meta name="robots" content="noindex, nofollow">';
    }
});