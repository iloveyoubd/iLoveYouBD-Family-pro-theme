<?php
/**
 * ILYBD Neon Pro - User Dashboard Stats Engine (PRO)
 * Social + Earning + Level System Core
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================
   SHORTCODE: USER DASHBOARD
========================= */
add_shortcode('user_stats', 'ilybd_user_dashboard_stats');

function ilybd_user_dashboard_stats() {

    if ( ! is_user_logged_in() ) {
        return '<div style="padding:15px;background:#111;border:1px solid #333;color:#ff3e3e;border-radius:10px;">
        ⚠ Please login to access your Cyber Dashboard
        </div>';
    }

    $user_id = get_current_user_id();

    /* =========================
       META DATA SAFE FETCH
    ========================= */
    $balance = (float) get_user_meta($user_id, 'user_balance', true);
    $points  = (int) get_user_meta($user_id, 'user_points', true);

    /* =========================
       ENGAGEMENT STATS (AUTO)
    ========================= */
    $posts   = count_user_posts($user_id);

    global $wpdb;

    $comments = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM $wpdb->comments WHERE user_id = %d AND comment_approved = 1",
            $user_id
        )
    );

    /* =========================
       SIMPLE LEVEL SYSTEM
    ========================= */
    $level = "Newbie";
    if ($points > 1000) $level = "Contributor";
    if ($points > 5000) $level = "Elite Member";
    if ($points > 15000) $level = "Cyber Legend";

    $next_level = 5000 - $points;
    if ($next_level < 0) $next_level = 0;

    /* =========================
       EARNING SIMULATION (OPTIONAL ENGINE)
    ========================= */
    $estimated_earning = ($posts * 2) + ($comments * 1) + ($points * 0.01);

    ob_start();
    ?>

    <div style="
        background:#0b0f14;
        border:1px solid #30363d;
        padding:20px;
        border-radius:14px;
        color:#c9d1d9;
        max-width:420px;
        margin:auto;
        box-shadow:0 0 20px rgba(0,255,65,0.05);
    ">

        <!-- HEADER -->
        <div style="text-align:center;margin-bottom:15px;">
            <?php echo get_avatar($user_id, 70); ?>
            <h3 style="margin:10px 0 5px;color:#fff;">
                <?php echo wp_get_current_user()->display_name; ?>
            </h3>
            <div style="color:#00ff41;font-size:12px;">
                ● <?php echo esc_html($level); ?> ●
            </div>
        </div>

        <!-- WALLET -->
        <div style="display:flex;justify-content:space-between;padding:10px;background:#161b22;border-radius:10px;margin-bottom:10px;">
            <span>💰 Wallet</span>
            <strong style="color:#ffb347;">৳<?php echo number_format($balance,2); ?></strong>
        </div>

        <!-- POINTS -->
        <div style="display:flex;justify-content:space-between;padding:10px;background:#161b22;border-radius:10px;margin-bottom:10px;">
            <span>⚡ Points</span>
            <strong style="color:#00ff41;"><?php echo $points; ?> XP</strong>
        </div>

        <!-- ACTIVITY -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">

            <div style="background:#161b22;padding:10px;border-radius:10px;text-align:center;">
                <div style="color:#fff;font-size:18px;"><?php echo $posts; ?></div>
                <small>Posts</small>
            </div>

            <div style="background:#161b22;padding:10px;border-radius:10px;text-align:center;">
                <div style="color:#fff;font-size:18px;"><?php echo $comments; ?></div>
                <small>Comments</small>
            </div>

        </div>

        <!-- EARNING -->
        <div style="background:#161b22;padding:10px;border-radius:10px;margin-bottom:10px;">
            <small style="color:#8b949e;">Estimated Earnings</small>
            <div style="color:#00ff41;font-size:18px;font-weight:bold;">
                $<?php echo number_format($estimated_earning,2); ?>
            </div>
        </div>

        <!-- PROGRESS -->
        <div>
            <small style="color:#8b949e;">Next Level Progress</small>
            <div style="height:6px;background:#30363d;border-radius:10px;overflow:hidden;margin-top:5px;">
                <div style="width:60%;height:100%;background:#00ff41;"></div>
            </div>
            <small style="color:#8b949e;">
                <?php echo $next_level; ?> XP to next level
            </small>
        </div>

    </div>

    <?php
    return ob_get_clean();
}