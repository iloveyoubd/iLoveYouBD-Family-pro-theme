<?php
/**
 * ILYBD Neon Pro - Ultimate User Dashboard Core
 * Fixed Version (Safe + Controlled Load)
 */

if (!defined('ABSPATH')) exit;

// Removed early load-time checks (now handled inside template redirect or template render routines)

// ✅ If not logged in, show nothing (no UI break)
// Safe logged-in checks handled dynamically during rendering

$user_id = get_current_user_id();
$user = wp_get_current_user();

// ✅ Safe fallback for tier function
if (!function_exists('ilybd_get_user_tier')) {
    function ilybd_get_user_tier($user_id) {
        return [
            'rank'  => 'Newbie',
            'color' => '#8b949e',
            'level' => '1',
            'level_name' => 'Newbie'
        ];
    }
}

add_shortcode('ilybd_user_economy', function() {
    if (!is_user_logged_in()) {
        return '';
    }
    $user_id = get_current_user_id();
    $user = wp_get_current_user();
    
    $balance = (float)get_user_meta($user_id, 'user_balance', true);
    $points  = (int)get_user_meta($user_id, 'ilybd_total_points', true);
    $tier    = ilybd_get_user_tier($user_id);

    $bio     = get_user_meta($user_id, 'description', true);
    $address = get_user_meta($user_id, 'user_address', true);
    $website = get_user_meta($user_id, 'user_website', true);
    $twitter = get_user_meta($user_id, 'user_twitter', true);

    $post_count = count_user_posts($user_id);
    $comment_count = get_comments([
        'user_id' => $user_id,
        'count'   => true
    ]);
    
    ob_start();
    ?>


<div class="cyber-dashboard">

    <!-- PROFILE -->
    <div class="dash-profile neon-card">

        <div class="avatar-box">
            <?php echo get_avatar($user_id, 90); ?>
        </div>

        <div class="profile-info">
            <h2><?php echo esc_html($user->display_name); ?> ✔</h2>

            <div class="tier" style="color:<?php echo esc_attr($tier['color']); ?>">
                ● <?php echo esc_html($tier['rank']); ?> ●
            </div>

            <p class="bio"><?php echo esc_html($bio ?: 'No bio set yet'); ?></p>

            <div class="meta-links">
                <?php if($website) echo '<a href="'.esc_url($website).'" target="_blank">🌐 Website</a>'; ?>
                <?php if($twitter) echo '<a href="'.esc_url($twitter).'" target="_blank">🐦 Social</a>'; ?>
            </div>

            <div class="address">
                📍 <?php echo esc_html($address ?: 'No location added'); ?>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">

        <div class="stat-box">
            <h3><?php echo (int)$post_count; ?></h3>
            <p>Posts</p>
        </div>

        <div class="stat-box">
            <h3><?php echo (int)$comment_count; ?></h3>
            <p>Comments</p>
        </div>

        <div class="stat-box">
            <h3><?php echo (int)$points; ?></h3>
            <p>Points</p>
        </div>

        <div class="stat-box">
            <h3>$<?php echo number_format($balance, 2); ?></h3>
            <p>Wallet</p>
        </div>

    </div>

    <!-- MODULES -->
    <div class="dashboard-grid">

        <div class="dash-box">
            <h3>📝 My Posts</h3>
            <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>">View Posts →</a>
        </div>

        <div class="dash-box">
            <h3>💬 My Comments</h3>
            <a href="#">View Activity →</a>
        </div>

        <div class="dash-box">
            <h3>❓ Q&A Hub</h3>
            <a href="#">Ask / Answer →</a>
        </div>

        <div class="dash-box">
            <h3>💰 Earnings</h3>
            <a href="#">Wallet Details →</a>
        </div>

        <div class="dash-box">
            <h3>🔔 Notifications</h3>
            <a href="#">View Alerts →</a>
        </div>

        <div class="dash-box">
            <h3>⚙ Settings</h3>
            <a href="<?php echo esc_url(get_edit_user_link()); ?>">Edit Profile →</a>
        </div>

    </div>

    <!-- LOGOUT -->
    <div class="quick-actions">
        <button onclick="location.href='<?php echo esc_url(wp_logout_url(home_url())); ?>'">Logout</button>
    </div>

</div>

<style>
.cyber-dashboard{
    max-width:900px;
    margin:20px auto;
    color:#fff;
}
.neon-card{
    background:#0d1117;
    border:1px solid #00ff41;
    border-radius:15px;
    padding:20px;
    margin-bottom:20px;
}
.dash-profile{
    display:flex;
    gap:20px;
    align-items:center;
}
.avatar-box img{
    border-radius:50%;
    border:2px solid #00ff41;
}
.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
}
.stat-box{
    background:#161b22;
    padding:15px;
    text-align:center;
    border-radius:10px;
    border:1px solid #30363d;
}
.dashboard-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
}
.dash-box{
    background:#0d1117;
    border:1px solid #30363d;
    padding:15px;
    border-radius:12px;
}
.dash-box a{
    color:#00ff41;
    text-decoration:none;
}
@media(max-width:768px){
    .stats-grid{grid-template-columns:repeat(2,1fr);}
    .dashboard-grid{grid-template-columns:repeat(1,1fr);}
    .dash-profile{flex-direction:column;text-align:center;}
}
</style>
<?php
    return ob_get_clean();
});
