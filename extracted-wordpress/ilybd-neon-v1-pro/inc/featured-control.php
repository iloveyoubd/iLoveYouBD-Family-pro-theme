<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function() {
    add_submenu_page(
        'ilybd-settings', 
        'Featured Control',
        'Featured Control',
        'manage_options',
        'featured-control-panel', // একদম ইউনিক স্লাগ
        'ilybd_featured_selection_ui'
    );
}, 999);

// AJAX Save Logic
add_action('wp_ajax_ilybd_save_featured', function () {
    if (!current_user_can('manage_options')) wp_send_json_error();
    $ids = isset($_POST['featured']) ? array_map('intval', $_POST['featured']) : [];
    update_option('ilybd_featured_ids', implode(',', $ids));
    wp_send_json_success(['message' => 'Updated!']);
});

function ilybd_featured_selection_ui() {
    $neon = get_option('ilybd_main_color', '#00ff41');
    $saved = array_filter(explode(',', get_option('ilybd_featured_ids', '')));
    $posts = get_posts(['posts_per_page' => 100, 'post_status' => 'publish']);
    ?>
    <div class="wrap" style="background:#0d1117; color:#fff; padding:20px; border-radius:10px;">
        <h1 style="color:<?php echo $neon; ?>;">⚡ Featured Post Selection</h1>
        <div id="postGrid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:15px; margin-top:20px;">
            <?php foreach ($posts as $post): ?>
                <div style="background:#161b22; padding:15px; border:1px solid #333; border-radius:8px;">
                    <input type="checkbox" class="f-check" value="<?php echo $post->ID; ?>" <?php checked(in_array($post->ID, $saved)); ?>>
                    <span style="font-size:13px;"><?php echo esc_html($post->post_title); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <button id="saveF" style="margin-top:20px; background:<?php echo $neon; ?>; border:none; padding:10px 30px; font-weight:bold; cursor:pointer;">SAVE SELECTION</button>
    </div>
    <script>
    jQuery('#saveF').on('click', function(){
        let ids = [];
        jQuery('.f-check:checked').each(function(){ ids.push(this.value); });
        jQuery.post(ajaxurl, {action:'ilybd_save_featured', featured:ids}, function(){ alert('Saved!'); });
    });
    </script>
    <?php
}
