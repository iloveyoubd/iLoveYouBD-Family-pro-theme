<?php
/**
 * The Sidebar containing the main widget area and the gorgeous Cyber Leaderboard & Online Users panel.
 */

$neon = get_option('ilybd_main_color', '#00ff41');

// 1. LEADERBOARD QUERY (Top 10 Users by XP Points)
$leaderboard_users = get_users(array(
    'meta_key'     => 'ilybd_total_points',
    'orderby'      => 'meta_value_num',
    'order'        => 'DESC',
    'number'       => 10,
));

// Fallback in case there are no users with 'ilybd_total_points' yet
if (empty($leaderboard_users)) {
    $leaderboard_users = get_users(array(
        'number'  => 10,
        'orderby' => 'display_name',
    ));
}

// 2. ONLINE USERS QUERY (Last active within 5 minutes)
$active_threshold = time() - 300; // 5 minutes
$raw_online_users = get_users(array(
    'meta_query' => array(
        array(
            'key'     => 'ilybd_last_active',
            'value'   => $active_threshold,
            'compare' => '>=',
            'type'    => 'NUMERIC'
        )
    ),
    'number' => 25
));

$online_users = array();
if (!empty($raw_online_users)) {
    foreach ($raw_online_users as $ou) {
        $p_vis = get_user_meta($ou->ID, 'ilybd_active_status_privacy', true);
        if ($p_vis !== 'private') {
            $online_users[] = $ou;
        }
    }
}
$online_users = array_slice($online_users, 0, 15);

$total_online_count = count($online_users);
$system_nodes_online = ($total_online_count === 0);
?>

<aside class="site-sidebar">

    <!-- WIDGET 1: COMMUNITY LEADERBOARD -->
    <div class="cyber-widget leaderboard-widget">
        <div class="cyber-widget-header">
            <span class="widget-icon">🏆</span>
            <div class="widget-header-text">
                <h3>কমিউনিটি লিডারবোর্ড</h3>
                <span class="header-sub">TOP 10 XP CONSOLE</span>
            </div>
            <div class="widget-header-glow"></div>
        </div>

        <div class="widget-divider bg-rgb-flow"></div>

        <div class="leaderboard-list">
            <?php 
            $rank = 1;
            foreach ($leaderboard_users as $user):
                $u_id = $user->ID;
                $points = (int) get_user_meta($u_id, 'ilybd_total_points', true);
                $display_name = $user->display_name;
                $profile_url = get_author_posts_url($u_id);

                // Determine dynamic rank class & symbol
                $rank_class = '';
                $rank_badge = $rank;
                if ($rank === 1) {
                    $rank_class = 'rank-gold';
                    $rank_badge = '👑';
                } elseif ($rank === 2) {
                    $rank_class = 'rank-silver';
                    $rank_badge = '🥈';
                } elseif ($rank === 3) {
                    $rank_class = 'rank-bronze';
                    $rank_badge = '🥉';
                }

                // Level designation & color configuration
                if ($points < 100) {
                    $lvl_title = 'নবিশ (Level 1)';
                    $lvl_color = '#a0aec0';
                    $bar_pct = min(100, max(15, $points));
                } elseif ($points < 1000) {
                    $lvl_title = 'কন্ট্রিবিউটর (Level 2)';
                    $lvl_color = $neon;
                    $bar_pct = min(100, max(15, ($points / 1000) * 100));
                } elseif ($points < 5000) {
                    $lvl_title = 'সিনিয়র কড (Level 3)';
                    $lvl_color = '#00f0ff';
                    $bar_pct = min(100, max(15, ($points / 5000) * 100));
                } else {
                    $lvl_title = 'কিং কোডার (Max)';
                    $lvl_color = '#ff0055';
                    $bar_pct = 100;
                }
            ?>
                <div class="leader-item <?php echo $rank_class; ?>">
                    <div class="rank-tag"><?php echo $rank_badge; ?></div>
                    
                    <div class="leader-avatar">
                        <a href="<?php echo esc_url($profile_url); ?>" aria-label="<?php echo esc_attr($display_name); ?> profile">
                            <?php echo get_avatar($u_id, 32); ?>
                        </a>
                    </div>

                    <div class="leader-details">
                        <h4 class="leader-name">
                            <a href="<?php echo esc_url($profile_url); ?>" class="profile-link-hover">
                                <?php echo esc_html($display_name); ?>
                            </a>
                        </h4>
                        <span class="leader-rank-title" style="color: <?php echo $lvl_color; ?>;">
                            <?php echo esc_html($lvl_title); ?>
                        </span>
                        
                        <!-- XP progress line -->
                        <div class="xp-mini-track">
                            <div class="xp-mini-bar" style="width: <?php echo $bar_pct; ?>%; background: <?php echo $lvl_color; ?>;"></div>
                        </div>
                    </div>

                    <div class="leader-score">
                        <span class="score-num"><?php echo number_format($points); ?></span>
                        <span class="score-unit">XP</span>
                    </div>
                </div>
            <?php 
                $rank++;
            endforeach; 
            ?>
        </div>
    </div>

    <!-- WIDGET 2: REAL-TIME ONLINE USERS -->
    <div class="cyber-widget online-users-widget">
        <div class="cyber-widget-header">
            <span class="widget-icon sys-online-pulse">●</span>
            <div class="widget-header-text">
                <h3>বর্তমানে সক্রিয় নোড</h3>
                <span class="header-sub">REAL-TIME ACTIVE UPLINKS</span>
            </div>
            <div class="online-indicator-container">
                <span class="online-count-badge">
                    <?php 
                    $displayed_count = $system_nodes_online ? 4 : $total_online_count;
                    echo $displayed_count; 
                    ?>
                </span>
            </div>
        </div>

        <div class="widget-divider-pulse bg-neon-cyan"></div>

        <div class="online-list">
            <?php if (!$system_nodes_online): ?>
                <?php foreach ($online_users as $user): 
                    $u_id = $user->ID;
                    $display_name = $user->display_name;
                    $profile_url = get_author_posts_url($u_id);
                    $points = (int) get_user_meta($u_id, 'ilybd_total_points', true);

                    // Custom role labeling
                    if (user_can($u_id, 'administrator')) {
                        $role_label = 'ফাউন্ডার';
                        $role_class = 'tag-founder';
                    } elseif (user_can($u_id, 'editor') || user_can($u_id, 'author')) {
                        $role_label = 'ডেভেলপার';
                        $role_class = 'tag-developer';
                    } else {
                        $role_label = 'মেম্বার';
                        $role_class = 'tag-member';
                    }
                ?>
                    <div class="online-item">
                        <div class="online-avatar-wrapper">
                            <a href="<?php echo esc_url($profile_url); ?>" aria-label="<?php echo esc_attr($display_name); ?> profile">
                                <?php echo get_avatar($u_id, 36); ?>
                            </a>
                            <span class="live-status-dot"></span>
                        </div>
                        
                        <div class="online-details">
                            <h4 class="online-name">
                                <a href="<?php echo esc_url($profile_url); ?>" class="profile-link-hover">
                                    <?php echo esc_html($display_name); ?>
                                </a>
                            </h4>
                            <div class="online-meta">
                                <span class="role-badge <?php echo $role_class; ?>"><?php echo esc_html($role_label); ?></span>
                                <span class="online-xp-meta">⚡ <?php echo $points; ?> XP</span>
                            </div>
                        </div>

                        <div class="connection-signal">
                            <span class="sig-bar full"></span>
                            <span class="sig-bar full"></span>
                            <span class="sig-bar"></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- FALLBACK / EXQUISITE DEFAULT CYBERNETIC COGNITIVE NODES ONLINE -->
                
                <!-- 1. Asraf Bin Asiya -->
                <div class="online-item system-priority">
                    <div class="online-avatar-wrapper">
                        <span class="mock-avatar avatar-asraf">AA</span>
                        <span class="live-status-dot"></span>
                    </div>
                    <div class="online-details">
                        <h4 class="online-name">
                            <a href="<?php echo esc_url(home_url('/author/asraf-bin-asiya')); ?>" class="profile-link-hover">Asraf Bin Asiya</a>
                        </h4>
                        <div class="online-meta">
                            <span class="role-badge tag-founder">CEO & FOUNDER</span>
                            <span class="online-xp-meta">👑 Core Node</span>
                        </div>
                    </div>
                    <div class="connection-signal secure-glow"><span style="color: #00ff41; font-size: 11px;">🔒 Secure</span></div>
                </div>

                <!-- 2. Asraful Islam Raaz -->
                <div class="online-item system-priority">
                    <div class="online-avatar-wrapper">
                        <span class="mock-avatar avatar-raaz">AR</span>
                        <span class="live-status-dot"></span>
                    </div>
                    <div class="online-details">
                        <h4 class="online-name">
                            <a href="<?php echo esc_url(home_url('/author/asraful-islam-raaz')); ?>" class="profile-link-hover">Asraful Islam Raaz</a>
                        </h4>
                        <div class="online-meta">
                            <span class="role-badge tag-developer">DEV ENGINEER</span>
                            <span class="online-xp-meta">⚡ 4,890 XP</span>
                        </div>
                    </div>
                    <div class="connection-signal secure-glow"><span style="color: #00f0ff; font-size: 11.5px;">💻 SysDev</span></div>
                </div>

                <!-- 3. Google AI Gateway -->
                <div class="online-item system-ai">
                    <div class="online-avatar-wrapper">
                        <span class="mock-avatar avatar-gemini">G</span>
                        <span class="live-status-dot ai-pulse"></span>
                    </div>
                    <div class="online-details">
                        <h4 class="online-name">
                            <a href="<?php echo esc_url(home_url('/team')); ?>" class="profile-link-hover">Google AI (Gemini)</a>
                        </h4>
                        <div class="online-meta">
                            <span class="role-badge tag-ai">AI AUTOMATION</span>
                            <span class="online-xp-meta text-emerald-400">● 24H ACTIVE SUPPORT</span>
                        </div>
                    </div>
                    <div class="connection-signal heartbeat-glow">⚡</div>
                </div>

                <!-- 4. ChatGPT Gateway -->
                <div class="online-item system-ai">
                    <div class="online-avatar-wrapper">
                        <span class="mock-avatar avatar-gpt">O</span>
                        <span class="live-status-dot ai-pulse"></span>
                    </div>
                    <div class="online-details">
                        <h4 class="online-name">
                            <a href="<?php echo esc_url(home_url('/team')); ?>" class="profile-link-hover">ChatGPT (OpenAI)</a>
                        </h4>
                        <div class="online-meta">
                            <span class="role-badge tag-ai-gpt">REASONING CORE</span>
                            <span class="online-xp-meta text-cyan-400">● 24H ACTIVE CONSOLE</span>
                        </div>
                    </div>
                    <div class="connection-signal heartbeat-glow">⚡</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- WIDGET 2.5: LIVE TRAFFIC HEATMAP MONITOR -->
    <div class="cyber-widget traffic-heatmap-widget" style="margin-top:20px;">
        <div class="cyber-widget-header">
            <span class="widget-icon">📡</span>
            <div class="widget-header-text">
                <h3>লাইভ গেটওয়ে ট্রাফিক হিটম্যাপ</h3>
                <span class="header-sub">REAL-TIME TRAFFIC NODAL MATRIX</span>
            </div>
            <div class="widget-header-glow" style="background:radial-gradient(circle, rgba(0,255,65,0.08) 0%, transparent 70%);"></div>
        </div>

        <div class="widget-divider bg-rgb-flow"></div>

        <div style="padding: 15px; background: rgba(0,0,0,0.3); border-radius: 12px; border: 1px solid rgba(0, 240, 255, 0.08); margin-top: 10px;">
            <!-- Simple Bangladesh Map Division Grid Heat Nodes -->
            <div class="heatmap-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 12px;">
                <div class="heat-tile active-ping" style="padding: 6px; background: rgba(0, 255, 65, 0.12); border: 1px solid #00ff41; border-radius: 6px; text-align: center;">
                    <span style="font-size: 8px; font-family: monospace; color:#00ff41; display:block; font-weight:bold;">DHAKA</span>
                    <span style="font-size: 10px; color:#fff; font-family: monospace;" class="random-pps" data-city="dhaka">24 pps</span>
                </div>
                <div class="heat-tile active-ping" style="padding: 6px; background: rgba(0, 240, 255, 0.12); border: 1px solid #00f0ff; border-radius: 6px; text-align: center;">
                    <span style="font-size: 8px; font-family: monospace; color:#00f0ff; display:block; font-weight:bold;">CTG</span>
                    <span style="font-size: 10px; color:#fff; font-family: monospace;" class="random-pps" data-city="ctg">18 pps</span>
                </div>
                <div class="heat-tile active-ping" style="padding: 6px; background: rgba(177, 0, 255, 0.12); border: 1px solid #b100ff; border-radius: 6px; text-align: center;">
                    <span style="font-size: 8px; font-family: monospace; color:#d884ff; display:block; font-weight:bold;">SYL</span>
                    <span style="font-size: 10px; color:#fff; font-family: monospace;" class="random-pps" data-city="syl">9 pps</span>
                </div>
                <div class="heat-tile active-ping" style="padding: 6px; background: rgba(255, 183, 0, 0.12); border: 1px solid #ffb700; border-radius: 6px; text-align: center;">
                    <span style="font-size: 8px; font-family: monospace; color:#ffb700; display:block; font-weight:bold;">RAJ</span>
                    <span style="font-size: 10px; color:#fff; font-family: monospace;" class="random-pps" data-city="raj">12 pps</span>
                </div>
            </div>
            
            <div class="heatmap-log-terminal" id="live-terminal-traffic-logs" style="font-family: monospace; font-size: 9px; color:#00ff41; height: 95px; overflow-y: hidden; background:#020502; border:1px solid rgba(0,255,65,0.15); border-radius: 6px; padding: 8px; line-height: 1.4;">
                <div class="log-line-item">> SHIELD SECURITY WALLS ACTIVATED ON INGRESS</div>
                <div class="log-line-item">> SYSTEM NODE_DHAKA_1 STREAMING STABLE PACKETS</div>
                <div class="log-line-item">> UPLINK CTG NODE SIGNALS SECURE...</div>
            </div>

            <script>
            jQuery(document).ready(function($) {
                // Update packet rates randomly to simulate live heavy load traffic
                setInterval(function() {
                    $('.random-pps').each(function() {
                        var base = $(this).data('city') === 'dhaka' ? 25 : ($(this).data('city') === 'ctg' ? 18 : 10);
                        var delta = Math.floor(Math.random() * 8) - 4;
                        var finalVal = Math.max(1, base + delta);
                        $(this).text(finalVal + ' pps');
                    });
                }, 2000);

                // Add random live logs simulation in real-time
                var logTerminal = $('#live-terminal-traffic-logs');
                var sampleRoutes = ['DHAKA_SUB_2', 'CTG_PORT_ROUTE', 'SYLHET_GATEWAY', 'RAJ_BORDER_LINK', 'BARISAL_OUTFLOW', 'KHULNA_HUB'];
                var sampleActions = ['SECURED', 'PACKET_FORWARD', 'INTEGRITY_COMPLIANT', 'GET_TUNS_REQ', 'SHIELD_BYPASS_ATTEMPT_BLOCKED'];
                
                setInterval(function() {
                    if (logTerminal.length) {
                        var route = sampleRoutes[Math.floor(Math.random() * sampleRoutes.length)];
                        var action = sampleActions[Math.floor(Math.random() * sampleActions.length)];
                        var time = new Date().toLocaleTimeString();
                        var hex = Math.floor(Math.random()*16777215).toString(16).toUpperCase();
                        var style = action.indexOf('BLOCKED') !== -1 ? 'color: #ff3914; font-weight: bold;' : '';
                        
                        var newLine = $('<div class="log-line-item" style="' + style + '">[' + time + '] ' + route + ' - #' + hex + ': ' + action + '</div>');
                        logTerminal.append(newLine);
                        
                        // Keep only last 12 items to prevent overflow
                        var items = logTerminal.find('.log-line-item');
                        if (items.length > 12) {
                            items.first().remove();
                        }
                        
                        // Scroll to bottom
                        logTerminal.scrollTop(logTerminal[0].scrollHeight);
                    }
                }, 3500);
            });
            </script>
        </div>
    </div>

    <!-- DYNAMIC SIDEBAR (BACKWARDS COMPATIBILITY) -->
    <?php if (is_active_sidebar('main-sidebar')): ?>
        <div class="cyber-dynamic-widgets">
            <?php dynamic_sidebar('main-sidebar'); ?>
        </div>
    <?php endif; ?>

</aside>

<style>
    /* COMPREHENSIVE HIGH-END CYBERPUNK THEMING FOR SIDEBAR.PHP */
    .site-sidebar {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* CYBER WIDGET CORE LAYOUT */
    .cyber-widget {
        background: #0a0e14;
        border: 1.5px solid rgba(255, 255, 255, 0.04);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
        position: relative;
        overflow: hidden;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .cyber-widget:hover {
        border-color: rgba(0, 255, 65, 0.15);
        box-shadow: 0 15px 35px rgba(0, 255, 65, 0.04), 0 0 15px rgba(0, 255, 65, 0.02);
    }

    /* WIDGET HEADER */
    .cyber-widget-header {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        margin-bottom: 12px;
    }

    .widget-icon {
        font-size: 20px;
        color: <?php echo $neon; ?>;
    }

    .sys-online-pulse {
        color: <?php echo $neon; ?>;
        animation: pulse_bullet 1.5s infinite alternate;
    }

    .widget-header-text h3 {
        font-size: 15px;
        font-weight: 800;
        color: #fff;
        margin: 0;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .header-sub {
        font-size: 10px;
        font-weight: 700;
        color: #cbd5e1; /* Increased contrast */
        letter-spacing: 1px;
    }

    /* WIDGET DIVIDER WITH GRADIENTS */
    .widget-divider {
        height: 2px;
        width: 100%;
        margin-bottom: 15px;
    }

    .bg-rgb-flow {
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        animation: rgb-line-sliding 5s linear infinite;
    }

    .widget-divider-pulse {
        height: 2px;
        width: 100%;
        margin-bottom: 15px;
        background: #00f0ff;
        box-shadow: 0 0 10px #00f0ff8c;
    }

    /* ONLINE COUNTER BADGE */
    .online-indicator-container {
        margin-left: auto;
    }

    .online-count-badge {
        font-size: 11px;
        font-weight: 900;
        background: rgba(0, 255, 65, 0.1);
        border: 1px solid <?php echo $neon; ?>44;
        color: <?php echo $neon; ?>;
        padding: 4px 10px;
        border-radius: 20px;
        box-shadow: 0 0 8px rgba(0, 255, 65, 0.15);
        font-family: monospace;
    }

    /* 1. LEADERBOARD LIST STYLINGS */
    .leaderboard-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .leader-item {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-radius: 10px;
        padding: 8px 12px;
        transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
    }

    .leader-item:hover {
        background: rgba(255, 255, 255, 0.02);
        transform: translateX(4px);
    }

    /* Rank Accents & Badges */
    .rank-tag {
        font-size: 14px;
        font-weight: 900;
        width: 24px;
        text-align: center;
        color: #718096;
        font-family: monospace;
    }

    .rank-gold {
        border-color: rgba(255, 215, 0, 0.15);
        background: linear-gradient(135deg, rgba(255, 215, 0, 0.02) 0%, rgba(0,0,0,0) 100%);
    }
    .rank-gold:hover {
        border-color: rgba(255, 215, 0, 0.4);
        box-shadow: 0 0 15px rgba(255, 215, 0, 0.08);
    }
    .rank-gold .rank-tag {
        font-size: 17px;
    }

    .rank-silver {
        border-color: rgba(192, 192, 192, 0.15);
        background: linear-gradient(135deg, rgba(192, 192, 192, 0.02) 0%, rgba(0,0,0,0) 100%);
    }
    .rank-silver:hover {
        border-color: rgba(192, 192, 192, 0.4);
        box-shadow: 0 0 15px rgba(192, 192, 192, 0.08);
    }

    .rank-bronze {
        border-color: rgba(205, 127, 50, 0.15);
        background: linear-gradient(135deg, rgba(205, 127, 50, 0.02) 0%, rgba(0,0,0,0) 100%);
    }
    .rank-bronze:hover {
        border-color: rgba(205, 127, 50, 0.4);
        box-shadow: 0 0 15px rgba(205, 127, 50, 0.08);
    }

    .leader-avatar {
        margin: 0 10px;
        flex-shrink: 0;
    }

    .leader-avatar img, .leader-avatar .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1.5px solid rgba(255,255,255,0.08);
        box-shadow: 0 2px 8px rgba(0,0,0,0.4);
        object-fit: cover;
    }

    .leader-item:hover .leader-avatar img, .leader-item:hover .leader-avatar .avatar {
        border-color: inherit;
    }

    .leader-details {
        flex: 1;
        min-width: 0; /* truncate boundaries */
    }

    .leader-name {
        margin: 0;
        font-size: 13.5px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-link-hover {
        color: #e2e8f0;
        text-decoration: none;
        transition: color 0.15s ease-in-out;
    }

    .profile-link-hover:hover {
        color: <?php echo $neon; ?> !important;
        text-shadow: 0 0 8px <?php echo $neon; ?>33;
    }

    .leader-rank-title {
        display: block;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 1px;
    }

    /* Progress tracks under leaderboard rows */
    .xp-mini-track {
        height: 2px;
        background: rgba(255, 255, 255, 0.03);
        width: 100%;
        margin-top: 5px;
        border-radius: 1px;
        overflow: hidden;
    }

    .xp-mini-bar {
        height: 100%;
        transition: width 0.4s ease;
    }

    .leader-score {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: center;
        margin-left: 8px;
        flex-shrink: 0;
    }

    .score-num {
        font-size: 14px;
        font-weight: 900;
        color: #fff;
        line-height: 1;
        font-family: monospace;
    }

    .score-unit {
        font-size: 8px;
        font-weight: 800;
        color: #cbd5e1; /* Increased contrast */
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    /* 2. ONLINE USERS LIST */
    .online-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .online-item {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        padding: 10px 14px;
        position: relative;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .online-item:hover {
        background: rgba(255,255,255,0.02);
        border-color: rgba(0, 240, 255, 0.25);
        transform: translateY(-2px);
    }

    /* Avatars with status lights inside them */
    .online-avatar-wrapper {
        position: relative;
        flex-shrink: 0;
        margin-right: 12px;
    }

    .online-avatar-wrapper img, .online-avatar-wrapper .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1.5px solid rgba(255,255,255,0.08);
        object-fit: cover;
        display: block;
    }

    .live-status-dot {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #00ff41;
        border: 2px solid #0a0e14;
        box-shadow: 0 0 8px #00ff41cc;
    }

    .ai-pulse {
        background: #ff0055 !important;
        box-shadow: 0 0 10px #ff0055ff !important;
        animation: pulse_dot 1s infinite alternate;
    }

    .online-details {
        flex: 1;
        min-width: 0;
    }

    .online-name {
        margin: 0;
        font-size: 13.5px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .online-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 3px;
    }

    /* Custom Roles Tags */
    .role-badge {
        font-size: 8px;
        font-weight: 900;
        padding: 1px 6px;
        border-radius: 4px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .tag-founder {
        background: rgba(255, 0, 85, 0.1);
        color: #ff3b79;
        border: 0.5px solid rgba(255, 0, 85, 0.2);
    }

    .tag-developer {
        background: rgba(0, 255, 65, 0.1);
        color: #00ff41;
        border: 0.5px solid rgba(0, 255, 65, 0.2);
    }

    .tag-member {
        background: rgba(0, 150, 255, 0.1);
        color: #4cb2ff;
        border: 0.5px solid rgba(0, 150, 255, 0.2);
    }

    .tag-ai {
        background: rgba(108, 92, 231, 0.15);
        color: #a29bfe;
        border: 0.5px solid rgba(108, 92, 231, 0.3);
    }

    .tag-ai-gpt {
        background: rgba(16, 163, 127, 0.15);
        color: #3bf1a9;
        border: 0.5px solid rgba(16, 163, 127, 0.3);
    }

    .online-xp-meta {
        font-size: 9px;
        font-weight: 700;
        color: #cbd5e1; /* Increased contrast */
    }

    /* Connection Bars */
    .connection-signal {
        display: flex;
        gap: 2.5px;
        align-items: flex-end;
        height: 12px;
        margin-left: 8px;
        flex-shrink: 0;
    }

    .sig-bar {
        width: 2px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 1px;
    }

    .sig-bar.full {
        background: <?php echo $neon; ?>;
    }

    .sig-bar:nth-child(1) { height: 4px; }
    .sig-bar:nth-child(2) { height: 7px; }
    .sig-bar:nth-child(3) { height: 11px; }

    .secure-glow {
        color: #00ff41;
        text-shadow: 0 0 10px rgba(0,255,65,0.4);
        font-size: 13px;
    }

    .heartbeat-glow {
        color: #00f0ff;
        animation: pulse_bullet 1.5s infinite alternate;
        font-weight: 800;
        font-size: 13px;
    }

    /* Fallback customized inline Avatars for system mock status */
    .mock-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13.5px;
        font-weight: 900;
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.08);
        box-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }

    .avatar-asraf {
        background: radial-gradient(circle, #ff0055 0%, #3a0011 100%);
        border-color: #ff005577;
    }

    .avatar-raaz {
        background: radial-gradient(circle, <?php echo $neon; ?> 0%, #002e08 100%);
        border-color: <?php echo $neon; ?>77;
    }

    .avatar-gemini {
        background: radial-gradient(circle, #0a40ff 0%, #000c3a 100%);
        border-color: #0055ffff;
    }

    .avatar-gpt {
        background: radial-gradient(circle, #10a37f 0%, #002213 100%);
        border-color: #10a37f77;
    }

    /* KEYFRAMES Animation Definitions */
    @keyframes rgb-line-sliding {
        to { background-position: 200% center; }
    }

    @keyframes pulse_bullet {
        from {
            opacity: 0.6;
            text-shadow: 0 0 4px currentColor;
        }
        to {
            opacity: 1;
            text-shadow: 0 0 12px currentColor, 0 0 20px currentColor;
        }
    }

    @keyframes pulse_dot {
        from {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(255, 0, 85, 0.7);
        }
        to {
            transform: scale(1.05);
            box-shadow: 0 0 10px 4px rgba(255, 0, 85, 0);
        }
    }

    /* STYLING DYNAMIC CLASSIC WIDGET PANELS OUTSIDE CYBER SYSTEMS */
    .cyber-dynamic-widgets .widget,
    .cyber-dynamic-widgets .widget-box {
        background: #0a0e14;
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 20px;
        color: #fff;
    }

    .cyber-dynamic-widgets .widget-title {
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        padding-bottom: 8px;
        margin-top: 0;
        margin-bottom: 12px;
        color: <?php echo $neon; ?>;
    }
</style>
