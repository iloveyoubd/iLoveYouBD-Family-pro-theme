<?php
/**
 * ILYBD Neon Pro - Slider Engine Control Panel (PRO)
 * Enhanced Neon UI & Logic
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================
   ADMIN MENU
========================= */
add_action('admin_menu', function() {
    add_submenu_page(
        'ilybd-settings',
        'Slider Engine',
        'Slider Settings',
        'manage_options',
        'ilybd-slider-config',
        'ilybd_slider_settings_page'
    );
});

/* =========================
   SETTINGS PAGE UI
========================= */
function ilybd_slider_settings_page() {
    $neon_main = esc_attr(get_option('ilybd_main_color', '#00ff41'));

    if(isset($_POST['ilybd_slider_save'])) {
        $slider_enabled = isset($_POST['ily_enable_slider']) ? 1 : 0;
        update_option('ily_enable_slider', $slider_enabled);
        update_option('slider_auto_play', isset($_POST['slider_auto_play']) ? 1 : 0);
        update_option('slider_post_count', (int)$_POST['slider_post_count']);
        update_option('slider_animation_speed', (int)$_POST['slider_animation_speed']);
        update_option('slider_delay', (int)$_POST['slider_delay']);
        update_option('slider_source', sanitize_text_field($_POST['slider_source']));

        echo '<div class="updated" style="border-left-color:'.$neon_main.'; background:#161b22; color:#fff;"><p>🚀 Slider Engine updated successfully.</p></div>';
    }

    $enable = get_option('ily_enable_slider', 1);
    $auto   = get_option('slider_auto_play', 1);
    $count  = get_option('slider_post_count', 9); // Default to 9 as requested: 3 items in desktop
    $speed  = get_option('slider_animation_speed', 850);
    $delay  = get_option('slider_delay', 5000);
    $source = get_option('slider_source', 'latest');
    ?>

    <style>
        .ilybd-settings-card {
            background: #0d1117; color: #c9d1d9; padding: 30px;
            border-radius: 14px; border: 1px solid #30363d;
            max-width: 800px; margin-top: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .neon-title { color: <?php echo $neon_main; ?>; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; }
        .form-table th { color: #f0f6fc; font-weight: 600; width: 220px; }
        
        .ilybd-input {
            background: #010409 !important; color: <?php echo $neon_main; ?> !important;
            border: 1px solid #30363d !important; border-radius: 6px !important;
            padding: 8px 12px !important; outline: none; transition: 0.3s;
        }
        .ilybd-input:focus { border-color: <?php echo $neon_main; ?> !important; box-shadow: 0 0 10px <?php echo $neon_main; ?>44; }
        
        .ilybd-btn-save {
            background: <?php echo $neon_main; ?> !important; color: #000 !important;
            border: none; padding: 12px 35px; border-radius: 8px;
            font-weight: 800; cursor: pointer; text-transform: uppercase;
            box-shadow: 0 4px 14px <?php echo $neon_main; ?>66; transition: 0.3s;
        }
        .ilybd-btn-save:hover { transform: translateY(-2px); opacity: 0.9; }
        
        .hint { color: #8b949e; font-size: 12px; display: block; margin-top: 5px; }
    </style>

    <div class="wrap">
        <div class="ilybd-settings-card">
            <h1 class="neon-title">🎬 Slider Engine Control</h1>
            <p style="color:#8b949e;">হোমপেজ স্লাইডারের বিহেভিয়ার এবং ডেটা সোর্স এখান থেকে নিয়ন্ত্রণ করুন।</p>

            <form method="post">
                <table class="form-table">
                    <tr>
                        <th>Enable Slider Section</th>
                        <td>
                            <input type="checkbox" name="ily_enable_slider" <?php checked($enable, 1); ?> style="accent-color:<?php echo $neon_main; ?>; transform: scale(1.3);" />
                            <b style="color: #fff; margin-left:10px;">হোমপেজে হিরো স্লাইডার সেকশনটি সচল রাখুন (Enable Slider Showcase)</b>
                        </td>
                    </tr>

                    <tr>
                        <th>Auto Play</th>
                        <td>
                            <input type="checkbox" name="slider_auto_play" <?php checked($auto,1); ?> style="accent-color:<?php echo $neon_main; ?>; transform: scale(1.3);" />
                            <span style="margin-left:10px;">স্লাইডার কি অটোমেটিক চলবে? (Enable Slide Autoplay Loop)</span>
                        </td>
                    </tr>

                    <tr>
                        <th>Total Slides</th>
                        <td>
                            <input type="number" name="slider_post_count" value="<?php echo esc_attr($count); ?>" min="1" max="20" class="ilybd-input" />
                            <span class="hint">স্লাইডারে সর্বোচ্চ কয়টি পোস্ট দেখাবে (১-২০)।</span>
                        </td>
                    </tr>

                    <tr>
                        <th>Transition Speed (ms)</th>
                        <td>
                            <input type="number" name="slider_animation_speed" value="<?php echo esc_attr($speed); ?>" class="ilybd-input" />
                            <span class="hint">এক স্লাইড থেকে অন্য স্লাইডে যাওয়ার গতি (৮০০-১৫০০ আদর্শ)।</span>
                        </td>
                    </tr>

                    <tr>
                        <th>Slide Delay (ms)</th>
                        <td>
                            <input type="number" name="slider_delay" value="<?php echo esc_attr($delay); ?>" class="ilybd-input" />
                            <span class="hint">একটি স্লাইড কতক্ষণ স্থির থাকবে (৩০০০ = ৩ সেকেন্ড)।</span>
                        </td>
                    </tr>

                    <tr>
                        <th>Content Source</th>
                        <td>
                            <select name="slider_source" class="ilybd-input" style="width: 200px;">
                                <option value="popular" <?php selected($source,'popular'); ?>>🔥 Popular Posts</option>
                                <option value="latest" <?php selected($source,'latest'); ?>>🕒 Latest Posts</option>
                                <option value="featured" <?php selected($source,'featured'); ?>>⭐ Featured Selection</option>
                                <option value="trending" <?php selected($source,'trending'); ?>>📈 Trending (Most Views)</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <div style="margin-top: 30px;">
                    <button type="submit" name="ilybd_slider_save" class="ilybd-btn-save">
                        Update Slider Engine
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php
}
