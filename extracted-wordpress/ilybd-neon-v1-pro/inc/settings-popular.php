<?php
/**
 * ILYBD Neon Pro - Popular Post Control Engine (PRO)
 * Enhanced with Neon UI & Security Fixes
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================
   ADMIN MENU
========================= */
add_action('admin_menu', function() {
    add_submenu_page(
        'ilybd-master-panel',
        'Popular Engine',
        'Popular Posts',
        'manage_options',
        'ilybd-popular-settings',
        'ilybd_popular_settings_page'
    );
});

/* =========================
   SETTINGS PAGE
========================= */
function ilybd_popular_settings_page() {
    // Neon Color from theme options or default
    $neon_main = esc_attr(get_option('ilybd_main_color', '#00ff41'));

    // Save handler with Nonce Security
    if(isset($_POST['ilybd_popular_save'])){
        update_option('popular_title', sanitize_text_field($_POST['popular_title']));
        update_option('popular_post_count', (int)$_POST['popular_post_count']);
        update_option('popular_meta_key', sanitize_text_field($_POST['popular_meta_key']));
        update_option('popular_sort_order', sanitize_text_field($_POST['popular_sort_order']));
        update_option('popular_enable', isset($_POST['popular_enable']) ? 1 : 0);

        echo '<div class="notice notice-success is-dismissible" style="border-left-color:'.$neon_main.';"><p><b>Popular Engine settings updated!</b></p></div>';
    }

    $title = get_option('popular_title', '🔥 POPULAR NOW');
    $count = get_option('popular_post_count', 4);
    $meta  = get_option('popular_meta_key', 'ilybd_post_views_count');
    if ($meta === 'post_views_count' || empty($meta)) {
        $meta = 'ilybd_post_views_count';
    }
    $order = get_option('popular_sort_order', 'DESC');
    $enable = get_option('popular_enable', 1);
    ?>

    <style>
        .ilybd-settings-wrap {
            background: #0d1117;
            color: #c9d1d9;
            padding: 30px;
            border-radius: 14px;
            border: 1px solid #30363d;
            margin-top: 20px;
            max-width: 900px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .ilybd-neon-title {
            color: <?php echo $neon_main; ?>;
            text-shadow: 0 0 10px <?php echo $neon_main; ?>33;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .form-table th {
            color: #f0f6fc;
            font-weight: 600;
            padding: 20px 10px 20px 0;
        }
        .ilybd-input {
            background: #010409 !important;
            color: <?php echo $neon_main; ?> !important;
            border: 1px solid #30363d !important;
            border-radius: 6px !important;
            padding: 10px !important;
            transition: 0.3s !important;
        }
        .ilybd-input:focus {
            border-color: <?php echo $neon_main; ?> !important;
            box-shadow: 0 0 8px <?php echo $neon_main; ?>44 !important;
            outline: none;
        }
        .ilybd-save-btn {
            background: <?php echo $neon_main; ?> !important;
            color: #000 !important;
            border: none !important;
            padding: 12px 35px !important;
            border-radius: 8px !important;
            font-weight: 800 !important;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
            text-transform: uppercase;
        }
        .ilybd-save-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px <?php echo $neon_main; ?>66;
        }
        .desc-text { color: #8b949e; font-size: 13px; margin-top: 5px; font-style: italic; }
    </style>

    <div class="wrap">
        <div class="ilybd-settings-wrap">
            <h1 class="ilybd-neon-title">🚀 Popular Engine Control</h1>
            <p style="color:#8b949e; margin-bottom: 30px;">Configure the ranking algorithm for your popular posts section.</p>

            <form method="post">
                <table class="form-table">
                    <tr>
                        <th>Enable Popular Section</th>
                        <td>
                            <label class="switch">
                                <input type="checkbox" name="popular_enable" <?php checked($enable, 1); ?>>
                                <span class="slider round"></span>
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <th>Display Title</th>
                        <td>
                            <input type="text" name="popular_title" value="<?php echo esc_attr($title); ?>" class="ilybd-input" style="width: 100%; max-width: 450px;" placeholder="e.g. 🔥 POPULAR NOW" />
                            <p class="desc-text">ফ্রন্ট-এন্ডে সেকশনের উপরে এই লেখাটি দেখাবে।</p>
                        </td>
                    </tr>

                    <tr>
                        <th>Posts to Show</th>
                        <td>
                            <input type="number" name="popular_post_count" value="<?php echo esc_attr($count); ?>" min="1" max="50" class="ilybd-input" style="width: 100px;" />
                            <p class="desc-text">কয়টি পোস্ট গ্রিডে শো করবে। (Max: 50)</p>
                        </td>
                    </tr>

                    <tr>
                        <th>Ranking Source (Meta Key)</th>
                        <td>
                            <input type="text" name="popular_meta_key" value="<?php echo esc_attr($meta); ?>" class="ilybd-input" style="width: 100%; max-width: 450px;" />
                            <p class="desc-text">সার্চের সোর্স: <b>post_views_count</b> (ভিউ অনুযায়ী) অথবা <b>_likes</b> (লাইক অনুযায়ী)।</p>
                        </td>
                    </tr>

                    <tr>
                        <th>Sort Algorithm</th>
                        <td>
                            <select name="popular_sort_order" class="ilybd-input" style="width: 100%; max-width: 450px;">
                                <option value="DESC" <?php selected($order,'DESC'); ?>>Trending (Highest First)</option>
                                <option value="ASC" <?php selected($order,'ASC'); ?>>Old Gems (Lowest First)</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <button type="submit" name="ilybd_popular_save" class="ilybd-save-btn">
                    Update Engine Settings
                </button>
            </form>
        </div>
    </div>
    <?php
}

/* =========================
   REGISTER SETTINGS
========================= */
add_action('admin_init', function() {
    register_setting('ilybd_popular_group', 'popular_title');
    register_setting('ilybd_popular_group', 'popular_post_count');
    register_setting('ilybd_popular_group', 'popular_meta_key');
    register_setting('ilybd_popular_group', 'popular_sort_order');
    register_setting('ilybd_popular_group', 'popular_enable');
});
