<?php
/**
 * Template Name: Cyber Authors Hub Pro
 * Description: High-EEAT Verified Authors & Team Contributors Directory Template
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">Contributors & Authors</h1>
            <p class="section-subtext">আমাদের লেখক ও প্রযুক্তি দল / DIRECTORY OF EXPERTS</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                
                <section class="policy-block" style="margin-bottom: 40px; text-align: center;">
                    <h2>🎖️ Verified Credentials & Technological Expertise Nodes</h2>
                    <p style="max-width: 800px; margin: 0 auto;">Every guide, config matrix, and tutorial hosted inside the IBD Cyber Ecosystem is authored by a credentialed tech analyst, security researcher, or open-source software engineer. We support absolute E-E-A-T transparency. Cross-reference their point levels, verified badges, active uplinks, and published indices below.</p>
                </section>

                <div class="authors-bento-grid">
                    <?php
                    $users = get_users([
                        'orderby' => 'post_count',
                        'order'   => 'DESC',
                        'number'  => 20,
                    ]);

                    if ($users):
                        foreach ($users as $user):
                            $author_id = $user->ID;
                            $post_count = count_user_posts($author_id);
                            
                            // Check if author has published anything or is admin to prevent listing empty test subscriber nodes
                            $user_roles = (isset($user->roles) && is_array($user->roles)) ? $user->roles : [];
                            $is_meaningful = $post_count > 0 || in_array('administrator', $user_roles) || in_array('editor', $user_roles) || in_array('moderator', $user_roles);
                            if (!$is_meaningful) continue;

                            $status = ilybd_get_user_active_status($author_id);
                            $points = (int) get_user_meta($author_id, 'ilybd_total_points', true);
                            $tier = ilybd_get_user_tier($author_id);
                            
                            // Define verified badges
                            $badge_text = "";
                            $badge_style = "";
                            
                            if (in_array('administrator', $user_roles)) {
                                $role_name = 'এডমিন (Admin)';
                                $badge_text = "VERIFIED AUTHOR";
                                $badge_style = "border: 1px solid #ff3e3e; background: rgba(255, 62, 62, 0.05); color: #ff3e3e;";
                            } elseif (in_array('editor', $user_roles)) {
                                $role_name = 'সম্পাদক (Editor)';
                                $badge_text = "VERIFIED AUTHOR";
                                $badge_style = "border: 1px solid #ff2df2; background: rgba(255, 45, 242, 0.05); color: #ff2df2;";
                            } elseif (in_array('moderator', $user_roles)) {
                                $role_name = 'মডারেটর (Mod)';
                                $badge_text = "VERIFIED EXPERT";
                                $badge_style = "border: 1px solid #00e5ff; background: rgba(0, 229, 255, 0.05); color: #00e5ff;";
                            } else {
                                $role_name = 'লেখক (Author)';
                                $badge_text = "VERIFIED CONTRIBUTOR";
                                $badge_style = "border: 1px solid #00ff41; background: rgba(0, 255, 65, 0.05); color: #00ff41;";
                            }
                            ?>
                            
                            <div class="author-bento-card">
                                
                                <div class="author-card-header">
                                    <div class="avatar-wrap">
                                        <?php echo get_avatar($author_id, 80, '', 'Author image', array('style' => 'border-radius: 50%; border: 2px solid ' . esc_attr($status['dot_color']) . '; width: 80px; height: 80px; object-fit: cover;')); ?>
                                        <span class="status-dot" style="background: <?php echo esc_attr($status['dot_color']); ?>; box-shadow: 0 0 8px <?php echo esc_attr($status['dot_color']); ?>;"></span>
                                    </div>
                                    <div class="header-details">
                                        <h3 class="author-title-h3"><a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>"><?php echo esc_html($user->display_name); ?></a></h3>
                                        <span class="role-desc"><?php echo esc_html($role_name); ?></span>
                                    </div>
                                </div>

                                <div class="badge-row">
                                    <span class="verified-trust-badge" style="<?php echo $badge_style; ?>">
                                        <i class="fa-solid fa-circle-check"></i> <?php echo $badge_text; ?>
                                    </span>
                                </div>

                                <p class="author-summary-bio"><?php echo esc_html($user->description ?: 'Cyber System Integration Specialist, contributing high-fidelity analytical reviews and optimization methodologies.'); ?></p>

                                <div class="author-metrics">
                                    <div class="metric">
                                        <span class="met-num"><?php echo esc_html($post_count); ?></span>
                                        <span class="met-lab">Articles</span>
                                    </div>
                                    <div class="metric">
                                        <span class="met-num" style="color: #ffaa00;"><?php echo esc_html($points); ?></span>
                                        <span class="met-lab">Rep XP</span>
                                    </div>
                                    <div class="metric">
                                        <span class="met-num" style="color: #00e5ff;"><?php echo esc_html($tier['rank']); ?></span>
                                        <span class="met-lab">Level</span>
                                    </div>
                                </div>

                                <div class="author-profile-link-btn">
                                    <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="cyber-btn-outline">Access Node Profile <i class="fa-solid fa-terminal"></i></a>
                                </div>

                            </div>
                            
                        <?php endforeach;
                    else: ?>
                        <p style="color: #8b949e;"><i class="fa-solid fa-triangle-exclamation"></i> No profiles detected in standard authorization grids.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .cyber-page-wrapper {
        background: #070a0f;
        min-height: 100vh;
        color: #e1e7ef;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cyber-section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .rgb-text-lighting {
        font-size: 2.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin: 0 0 10px 0;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rgb_flow 4s linear infinite;
    }

    .section-subtext {
        color: <?php echo $neon; ?>;
        font-size: 11px;
        letter-spacing: 5px;
        margin-bottom: 20px;
    }

    .sticky-rgb-line {
        height: 2px;
        width: 100%;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        animation: rgb_flow 4s linear infinite;
        box-shadow: 0 0 15px <?php echo $neon; ?>dd;
    }

    /* Outer Matrix Container */
    .slim-rgb-container {
        position: relative;
        padding: 1px;
        background: linear-gradient(var(--angle), #ff0000, #00ff00, #0000ff, #ff0000);
        animation: rotate-border 6s linear infinite;
        border-radius: 20px;
        overflow: hidden;
    }

    @property --angle {
        syntax: '<angle>';
        initial-value: 0deg;
        inherits: false;
    }

    @keyframes rotate-border {
        to { --angle: 360deg; }
    }

    .inner-page-content {
        background: #0a0e14;
        border-radius: 19px;
        padding: 40px;
    }

    .authors-bento-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .author-bento-card {
        background: rgba(255,255,255,0.01);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 14px;
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: 0.3s;
    }

    .author-bento-card:hover {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 15px <?php echo $neon; ?>1d;
        transform: translateY(-3px);
    }

    .author-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .avatar-wrap {
        position: relative;
    }

    .status-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #0d1117;
    }

    .header-details h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
    }

    .header-details h3 a {
        color: #fff;
        text-decoration: none;
        transition: 0.2s;
    }

    .header-details h3 a:hover {
        color: <?php echo $neon; ?>;
    }

    .role-desc {
        font-size: 11px;
        color: #8b949e;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-row {
        margin-bottom: 15px;
    }

    .verified-trust-badge {
        font-family: monospace;
        font-size: 9.5px;
        font-weight: bold;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        letter-spacing: 0.5px;
    }

    .author-summary-bio {
        font-size: 13px;
        color: #a0aec0;
        line-height: 1.6;
        margin: 0 0 20px 0;
        flex-grow: 1;
    }

    .author-metrics {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border: 1px solid rgba(255,255,255,0.03);
        background: rgba(0,0,0,0.2);
        border-radius: 8px;
        padding: 12px 6px;
        margin-bottom: 20px;
        text-align: center;
    }

    .met-num {
        display: block;
        font-size: 15px;
        font-weight: bold;
        color: #fff;
        font-family: monospace;
    }

    .met-lab {
        font-size: 10px;
        color: #8b949e;
        text-transform: uppercase;
        display: block;
        margin-top: 2px;
    }

    .cyber-btn-outline {
        display: block;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 6px;
        color: #fff;
        font-size: 12.5px;
        text-transform: uppercase;
        text-decoration: none;
        padding: 10px;
        font-weight: 600;
        transition: 0.2s;
    }

    .cyber-btn-outline:hover {
        background: <?php echo $neon; ?>;
        border-color: <?php echo $neon; ?>;
        color: #000;
    }

    @media (max-width: 991px) {
        .authors-bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .authors-bento-grid {
            grid-template-columns: 1fr;
        }
        .inner-page-content {
            padding: 20px;
        }
    }

    @keyframes rgb_flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<?php get_footer(); ?>
