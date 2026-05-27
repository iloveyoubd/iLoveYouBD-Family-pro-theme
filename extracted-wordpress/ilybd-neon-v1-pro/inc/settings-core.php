<?php
/**
 * ILYBD Neon Pro - Master Control Core v2
 * Full System Admin Brain (Social + Earning + SEO + App Control)
 */

if (!defined('ABSPATH')) exit;


/* =========================
   MASTER MENU SYSTEM
========================= */
add_action('admin_menu', function () {

    add_menu_page(
        'ILYBD Master Panel',
        'ILYBD Master',
        'manage_options',
        'ilybd-master-panel',
        'ilybd_master_dashboard',
        'dashicons-admin-generic',
        2
    );

    add_submenu_page(
        'ilybd-master-panel',
        'System Overview',
        'Dashboard',
        'manage_options',
        'ilybd-master-panel',
        'ilybd_master_dashboard'
    );

    add_submenu_page(
        'ilybd-master-panel',
        'Earning Engine',
        'Earning System',
        'manage_options',
        'ilybd-earning',
        'ilybd_earning_panel'
    );

    add_submenu_page(
        'ilybd-master-panel',
        'User Control',
        'Users & Roles',
        'manage_options',
        'ilybd-users',
        'ilybd_user_panel'
    );

    add_submenu_page(
        'ilybd-master-panel',
        'Content System',
        'Posts & Feed',
        'manage_options',
        'ilybd-content',
        'ilybd_content_panel'
    );

    add_submenu_page(
        'ilybd-master-panel',
        'SEO Engine',
        'SEO Settings',
        'manage_options',
        'ilybd-seo',
        'ilybd_seo_panel'
    );
});


/* =========================
   DASHBOARD (SYSTEM OVERVIEW)
========================= */
function ilybd_master_dashboard() {

    $users = count_users();
    $posts = wp_count_posts('post')->publish;

    ?>
    <div class="wrap">
        <h1>🚀 ILYBD SYSTEM CONTROL</h1>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;margin-top:20px;">

            <div style="background:#111;padding:20px;border-radius:10px;color:#fff;">
                <h3>Users</h3>
                <p style="font-size:22px;"><?php echo $users['total_users']; ?></p>
            </div>

            <div style="background:#111;padding:20px;border-radius:10px;color:#fff;">
                <h3>Posts</h3>
                <p style="font-size:22px;"><?php echo $posts; ?></p>
            </div>

            <div style="background:#111;padding:20px;border-radius:10px;color:#00ff41;">
                <h3>System Status</h3>
                <p>ACTIVE 🔥</p>
            </div>

        </div>

    </div>
    <?php
}


/* =========================
   EARNING PANEL
========================= */
function ilybd_earning_panel() {
    ?>
    <div class="wrap">
        <h1>💰 Earning Engine Control</h1>
        <p>Views, Likes, Comments → Revenue System</p>

        <form method="post">
            <table class="form-table">
                <tr>
                    <th>1 View Value</th>
                    <td><input type="text" name="view_rate" value="<?php echo get_option('ily_view_rate', '0.01'); ?>"></td>
                </tr>
                <tr>
                    <th>1 Like Value</th>
                    <td><input type="text" name="like_rate" value="<?php echo get_option('ily_like_rate', '0.05'); ?>"></td>
                </tr>
            </table>

            <?php submit_button('Save Earning Settings'); ?>
        </form>
    </div>
    <?php
}


/* =========================
   USER CONTROL PANEL
========================= */
function ilybd_user_panel() {
    ?>
    <div class="wrap">
        <h1>👥 User Management</h1>
        <p>Role, Level, Points Control System</p>

        <ul>
            <li>✔ User Levels</li>
            <li>✔ Verification System</li>
            <li>✔ Ban / Unban Control</li>
            <li>✔ Points System</li>
        </ul>
    </div>
    <?php
}


/* =========================
   CONTENT CONTROL
========================= */
function ilybd_content_panel() {
    ?>
    <div class="wrap">
        <h1>📰 Content Control Engine</h1>
        <p>Post moderation + feed control system</p>

        <ul>
            <li>✔ Featured posts</li>
            <li>✔ Auto approval system</li>
            <li>✔ Spam filter ready</li>
        </ul>
    </div>
    <?php
}


/* =========================
   SEO PANEL LINK
========================= */
function ilybd_seo_panel() {
    ?>
    <div class="wrap">
        <h1>📈 SEO Engine Panel</h1>
        <p>Meta, Schema, Social optimization control</p>
    </div>
    <?php
}