<?php
/**
 * ILYBD Neon v1 Pro - Cyber UI Settings Panel (Advanced)
 * User Personal UI Customization Engine
 */

if (!defined('ABSPATH')) exit;

/* =========================
   1. USER PROFILE SETTINGS UI
========================= */

add_action('show_user_profile', 'cyber_ui_settings_panel');
add_action('edit_user_profile', 'cyber_ui_settings_panel');

function cyber_ui_settings_panel($user) {

    $theme_mode = get_user_meta($user->ID, 'user_theme_mode', true);
    $accent = get_user_meta($user->ID, 'user_accent_color', true);
    $accent = $accent ?: '#00ff41';

    ?>

    <h2 style="margin-top:30px; color:#00ff41; text-shadow:0 0 10px #00ff41;">
        ⚡ Cyber Interface Personalization
    </h2>

    <table class="form-table" style="background:#0d1117; padding:15px; border-radius:10px; border:1px solid #222;">

        <!-- THEME MODE -->
        <tr>
            <th><label>Interface Mode</label></th>
            <td>
                <select name="user_theme_mode" style="width:250px;">
                    <option value="default" <?php selected($theme_mode, 'default'); ?>>🌑 Dark Default</option>
                    <option value="hacker-green" <?php selected($theme_mode, 'hacker-green'); ?>>💚 Hacker Neon Green</option>
                    <option value="cyber-violet" <?php selected($theme_mode, 'cyber-violet'); ?>>💜 Cyber Violet Pro</option>
                    <option value="glass-matrix" <?php selected($theme_mode, 'glass-matrix'); ?>>🧊 Glass Matrix UI</option>
                </select>
                <p style="color:#888; font-size:12px;">Choose your UI personality layer.</p>
            </td>
        </tr>

        <!-- ACCENT COLOR -->
        <tr>
            <th><label>Accent Color</label></th>
            <td>
                <input type="color" name="user_accent_color" value="<?php echo esc_attr($accent); ?>">
                <p style="color:#888; font-size:12px;">Used for buttons, highlights & glow effects.</p>
            </td>
        </tr>

        <!-- LIVE PREVIEW BOX -->
        <tr>
            <th>Preview</th>
            <td>
                <div style="
                    padding:15px;
                    border-radius:12px;
                    background:#000;
                    border:1px solid <?php echo esc_attr($accent); ?>;
                    box-shadow:0 0 15px <?php echo esc_attr($accent); ?>;
                    color:#fff;
                    width:260px;
                ">
                    <b style="color:<?php echo esc_attr($accent); ?>;">Cyber Preview</b>
                    <p style="font-size:12px; color:#aaa; margin-top:8px;">
                        This is how your interface glow will feel.
                    </p>
                    <button style="
                        margin-top:10px;
                        background:<?php echo esc_attr($accent); ?>;
                        border:none;
                        padding:6px 10px;
                        border-radius:6px;
                        font-weight:bold;
                    ">Action</button>
                </div>
            </td>
        </tr>

    </table>

    <?php
}

/* =========================
   2. SAVE SETTINGS
========================= */

add_action('personal_options_update', 'save_cyber_ui_settings');
add_action('edit_user_profile_update', 'save_cyber_ui_settings');

function save_cyber_ui_settings($user_id) {

    if (!current_user_can('edit_user', $user_id)) return false;

    if (isset($_POST['user_theme_mode'])) {
        update_user_meta($user_id, 'user_theme_mode', sanitize_text_field($_POST['user_theme_mode']));
    }

    if (isset($_POST['user_accent_color'])) {
        update_user_meta($user_id, 'user_accent_color', sanitize_hex_color($_POST['user_accent_color']));
    }
}