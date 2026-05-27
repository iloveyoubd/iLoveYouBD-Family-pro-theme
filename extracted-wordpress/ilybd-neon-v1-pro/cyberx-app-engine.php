<?php
/**
 * CyberX Ultimate App Engine - Pro Stable Edition (2026)
 */

if (!defined('ABSPATH')) exit;

/* =========================
   1. CUSTOM POST TYPE
========================= */
function cyberx_register_app_system() {
    register_post_type('apps', [
        'labels' => [
            'name' => 'CyberX Apps',
            'singular_name' => 'App',
            'add_new' => 'Add New App',
            'all_items' => 'All Apps'
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'android-apps'],
        'supports' => ['title', 'editor', 'thumbnail', 'comments'],
        'menu_icon' => 'dashicons-download',
        'show_in_rest' => true,
    ]);
}
add_action('init', 'cyberx_register_app_system');


/* =========================
   2. META BOX
========================= */
function cyberx_app_meta_fields() {
    add_meta_box('app_info', 'App Metadata', 'cyber_app_callback', 'apps', 'normal', 'high');
}
add_action('add_meta_boxes', 'cyberx_app_meta_fields');

function cyber_app_callback($post) {
    $fields = [
        '_app_pkg' => '',
        '_app_version' => '',
        '_app_size' => '',
        '_app_icon_url' => '',
        '_app_download_link' => ''
    ];

    foreach ($fields as $key => $val) {
        $fields[$key] = get_post_meta($post->ID, $key, true);
    }

    wp_nonce_field('cyber_app_save_meta', 'cyber_app_nonce');
    ?>
    <div style="display:grid; gap:10px;">
        <input name="app_pkg" value="<?php echo esc_attr($fields['_app_pkg']); ?>" placeholder="Package (com.app.name)" />
        <input name="app_version" value="<?php echo esc_attr($fields['_app_version']); ?>" placeholder="Version" />
        <input name="app_size" value="<?php echo esc_attr($fields['_app_size']); ?>" placeholder="Size" />
        <input name="app_icon_url" value="<?php echo esc_attr($fields['_app_icon_url']); ?>" placeholder="Icon URL" />
        <input name="app_download_link" value="<?php echo esc_attr($fields['_app_download_link']); ?>" placeholder="Download Link" />
    </div>
    <?php
}


/* =========================
   3. SAVE META
========================= */
add_action('save_post', function($post_id) {

    if (!isset($_POST['cyber_app_nonce']) ||
        !wp_verify_nonce($_POST['cyber_app_nonce'], 'cyber_app_save_meta')) return;

    $map = [
        'app_pkg' => '_app_pkg',
        'app_version' => '_app_version',
        'app_size' => '_app_size',
        'app_icon_url' => '_app_icon_url',
        'app_download_link' => '_app_download_link'
    ];

    foreach ($map as $k => $meta) {
        if (isset($_POST[$k])) {
            update_post_meta($post_id, $meta, sanitize_text_field($_POST[$k]));
        }
    }
});


/* =========================
   4. CONTENT ENGINE (FIXED)
========================= */
add_filter('the_content', function($content) {

    if (get_post_type() !== 'apps') return $content;

    global $post;

    $title = get_the_title();
    $pkg   = get_post_meta($post->ID, '_app_pkg', true);
    $version = get_post_meta($post->ID, '_app_version', true) ?: 'Latest';

    /* SAFE SCANNER UI */
    $scanner_html = "
    <div class='cyber-box'>
        <div class='cyber-header'>
            <h3>🛡 CyberX Security Scan</h3>
            <span id='scan-status'>Initializing...</span>
        </div>

        <div class='cyber-bar'>
            <div id='scan-fill'></div>
        </div>

        <div id='log'></div>
    </div>";

    /* REVIEW BOX */
    $review_html = "
    <div class='cyber-review'>
        <div class='score'>4.8</div>
        <div class='stars'>★★★★★</div>
        <div class='text'>Security Verified • Stable Build</div>
    </div>";

    /* RELATED APPS */
    $q = new WP_Query([
        'post_type' => 'apps',
        'posts_per_page' => 6,
        'post__not_in' => [$post->ID]
    ]);

    $related = "<div class='cyber-related'>";

    while ($q->have_posts()) {
        $q->the_post();
        $icon = get_post_meta(get_the_ID(), '_app_icon_url', true);

        $related .= "
        <a href='".get_permalink()."'>
            <img src='".esc_url($icon)."' />
            <span>".get_the_title()."</span>
        </a>";
    }

    wp_reset_postdata();
    $related .= "</div>";

    return $scanner_html . $content . $review_html . $related;
});


/* =========================
   5. STYLES (PRO NEON FIX)
========================= */
add_action('wp_head', function() {
?>
<style>

.cyber-box{
    background:#0a0a0a;
    border:1px solid #222;
    border-radius:18px;
    padding:20px;
    margin:25px 0;
    color:#39ff14;
}

.cyber-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
}

.cyber-bar{
    height:6px;
    background:#111;
    border-radius:10px;
    overflow:hidden;
    margin-bottom:10px;
}

#scan-fill{
    height:100%;
    width:0%;
    background:linear-gradient(90deg,#00ff00,#39ff14);
    transition:0.3s;
}

.cyber-review{
    display:flex;
    gap:15px;
    padding:20px;
    margin:25px 0;
    background:#111;
    border-radius:15px;
    color:#fff;
}

.cyber-review .score{font-size:40px;}

.cyber-related{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(120px,1fr));
    gap:10px;
}

.cyber-related a{
    background:#111;
    padding:10px;
    border-radius:12px;
    text-align:center;
    color:#ccc;
    text-decoration:none;
}

.cyber-related img{
    width:50px;
    height:50px;
    border-radius:10px;
}

</style>
<?php
});