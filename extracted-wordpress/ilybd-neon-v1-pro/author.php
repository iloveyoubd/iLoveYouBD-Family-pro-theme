<?php 
get_header(); 

$curauth = (isset($_GET['author_name'])) 
    ? get_user_by('slug', $author_name) 
    : get_userdata(intval($author));

$author_id = $curauth->ID;
$neon = get_option('ilybd_main_color', '#00ff41');

$post_count = count_user_posts($author_id);

global $wpdb;
$comment_count = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $wpdb->comments 
    WHERE user_id = $author_id 
    AND comment_approved = '1'
");
?>

<div class="cyber-author-page">

    <!-- ================= HERO PROFILE ================= -->
    <section class="cyber-hero" style="text-align:center; padding: 30px 15px; background: rgba(22, 27, 34, 0.4); border-radius: 16px; border: 1px solid #30363d; margin-bottom: 25px;">

        <?php
        $status = ilybd_get_user_active_status($author_id);
        $tiktok = get_user_meta($author_id, 'user_tiktok', true);
        $phone = get_user_meta($author_id, 'user_phone', true);
        ?>
        <div class="avatar-wrap" style="display:inline-block; position:relative;">
            <?php echo get_avatar($author_id, 110, '', 'Author image', array('style' => 'border-radius: 50%; border: 3px solid ' . esc_attr($status['dot_color']) . '; width: 110px; height: 110px; object-fit: cover;')); ?>
            <span class="status-dot" style="position:absolute; bottom:5px; right:5px; width:15px; height:15px; background:<?php echo esc_attr($status['dot_color']); ?>; border-radius:50%; border:2px solid #0d1117; box-shadow: 0 0 10px <?php echo esc_attr($status['dot_color']); ?>;"></span>
        </div>

        <h1 class="author-name" style="margin: 15px 0 3px 0; font-size: 24px; color: #fff; font-weight: bold;"><?php echo esc_html($curauth->display_name); ?></h1>

        <div style="font-size: 13px; font-weight: bold; color: <?php echo esc_attr($status['is_online'] ? '#00ff41' : '#8b949e'); ?>; display: flex; align-items: center; justify-content: center; gap: 6px; margin: 3px 0 15px 0;">
            <span style="display:inline-block; width:9px; height:9px; border-radius:50%; background:<?php echo esc_attr($status['dot_color']); ?>; box-shadow:0 0 6px <?php echo esc_attr($status['dot_color']); ?>;"></span>
            <?php echo esc_html($status['text']); ?>
        </div>

        <?php
        // Fetch customized roles safely
        $user_roles = (isset($curauth->roles) && is_array($curauth->roles)) ? $curauth->roles : [];
        $role_name = 'মেম্বার (Subscriber)';
        $role_color = '#8b949e';
        $role_icon = 'fa-solid fa-user';
        
        if (in_array('administrator', $user_roles)) {
            $role_name = 'এডমিন (Administrator)';
            $role_color = '#ff3e3e';
            $role_icon = 'fa-solid fa-crown';
        } elseif (in_array('editor', $user_roles)) {
            $role_name = 'সম্পাদক (Editor)';
            $role_color = '#ff2df2';
            $role_icon = 'fa-solid fa-pen-fancy';
        } elseif (in_array('moderator', $user_roles)) {
            $role_name = 'মডারেটর (Moderator)';
            $role_color = '#00e5ff';
            $role_icon = 'fa-solid fa-shield-halved';
        } elseif (in_array('author', $user_roles)) {
            $role_name = 'লেখক (Author)';
            $role_color = '#00ff41';
            $role_icon = 'fa-solid fa-feather-pointed';
        } elseif (in_array('contributor', $user_roles)) {
            $role_name = 'কন্ট্রিবিউটর (Contributor)';
            $role_color = '#ffb347';
            $role_icon = 'fa-solid fa-handshake';
        }
        ?>
        <div style="margin-bottom: 15px;">
            <span class="role-badge" style="display:inline-block; font-size:11px; font-weight:bold; background:rgba(255,255,255,0.03); border:1px solid <?php echo $role_color; ?>; color:<?php echo $role_color; ?>; padding:4px 14px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px;">
                <i class="<?php echo $role_icon; ?>" style="margin-right:5px;"></i> <?php echo esc_html($role_name); ?>
            </span>
        </div>

        <?php 
        $address = get_user_meta($author_id, 'user_address', true);
        if ($address): ?>
            <p class="author-address" style="color: #c9d1d9; font-size: 13.5px; margin: 5px 0 10px 0;">
                <i class="fa-solid fa-location-dot" style="color:<?php echo esc_attr($neon); ?>; margin-right:5px;"></i> <?php echo esc_html($address); ?>
            </p>
        <?php endif; ?>

        <p class="author-bio" style="color: #8b949e; font-size: 14px; max-width: 600px; margin: 10px auto; line-height: 1.6;">
            <?php echo esc_html($curauth->description ?: 'Cyber Member • Active Contributor'); ?>
        </p>

        <?php
        $fb = get_user_meta($author_id, 'user_facebook', true);
        $tw = get_user_meta($author_id, 'user_twitter', true);
        $li = get_user_meta($author_id, 'user_linkedin', true);
        $yt = get_user_meta($author_id, 'user_youtube', true);
        $ig = get_user_meta($author_id, 'user_instagram', true);
        $tiktok = get_user_meta($author_id, 'user_tiktok', true);
        $phone = get_user_meta($author_id, 'user_phone', true);
        
        if ($fb || $tw || $li || $yt || $ig || $tiktok): ?>
            <div class="author-socials" style="display:flex; justify-content:center; gap:18px; margin-top:20px; margin-bottom: 10px; align-items: center; flex-wrap: wrap;">
                <?php if ($fb): ?><a href="<?php echo esc_url($fb); ?>" target="_blank" style="color:#1877f2; font-size:20px; transition: 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1"><i class="fa-brands fa-facebook"></i></a><?php endif; ?>
                <?php if ($tw): ?><a href="<?php echo esc_url($tw); ?>" target="_blank" style="color:#1da1f2; font-size:20px; transition: 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1"><i class="fa-brands fa-x-twitter"></i></a><?php endif; ?>
                <?php if ($li): ?><a href="<?php echo esc_url($li); ?>" target="_blank" style="color:#0a66c2; font-size:20px; transition: 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1"><i class="fa-brands fa-linkedin"></i></a><?php endif; ?>
                <?php if ($yt): ?><a href="<?php echo esc_url($yt); ?>" target="_blank" style="color:#ff0000; font-size:20px; transition: 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1"><i class="fa-brands fa-youtube"></i></a><?php endif; ?>
                <?php if ($ig): ?><a href="<?php echo esc_url($ig); ?>" target="_blank" style="color:#e1306c; font-size:20px; transition: 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1"><i class="fa-brands fa-instagram"></i></a><?php endif; ?>
                <?php if ($tiktok): ?><a href="<?php echo esc_url($tiktok); ?>" target="_blank" style="color:#ffffff; text-shadow: 1px 1px 0px #03e9f4, -1px -1px 0px #ff007f; font-size:20px; transition: 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1"><i class="fa-brands fa-tiktok"></i></a><?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($phone): ?>
            <div style="margin-top:10px; margin-bottom:5px;">
                <span style="font-size: 12px; font-weight: bold; background: rgba(0, 255, 65, 0.05); border: 1px solid rgba(0, 255, 65, 0.25); color: #00ff41; padding: 4px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 0 10px rgba(0,255,65,0.08);">
                    <i class="fa-solid fa-phone"></i> <?php echo esc_html($phone); ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- STATS -->
        <div class="stats-grid" style="display:flex; justify-content:center; align-items:center; gap:15px; margin-top:20px;">
            <div class="stat">
                <b><?php echo $post_count; ?></b>
                <span>Posts</span>
            </div>

            <div class="divider" style="width:1px; height:15px; background:#30363d;"></div>

            <div class="stat">
                <b><?php echo $comment_count; ?></b>
                <span>Comments</span>
            </div>
        </div>

    </section>

    <!-- ================= CONTENT ================= -->
    <section class="cyber-content">

        <!-- LEVEL CARD (DYNAMICALLY LOADED XP & RANK VALUES) -->
        <?php
        $author_points = (int) get_user_meta($author_id, 'ilybd_total_points', true);
        $author_tier = ilybd_get_user_tier($author_id);
        
        $rank = $author_tier['rank'];
        $color = $author_tier['color'];
        
        if ($author_points < 100) {
            $next_level = 100;
            $prev_level = 0;
        } elseif ($author_points < 1000) {
            $next_level = 1000;
            $prev_level = 100;
        } elseif ($author_points < 5000) {
            $next_level = 5000;
            $prev_level = 1000;
        } else {
            $next_level = $author_points;
            $prev_level = 0;
        }
        
        $range = $next_level - $prev_level;
        $percent = ($range > 0) ? min(100, max(0, (($author_points - $prev_level) / $range) * 100)) : 100;
        ?>
        <div class="level-card" style="border: 1px solid <?php echo esc_attr($color); ?>; background:rgba(0,0,0,0.3); padding:20px; border-radius:12px; margin-bottom:20px;">
            <div class="level-top" style="display:flex; justify-content:space-between; align-items:center;">
                <span style="color: <?php echo esc_attr($color); ?>; font-weight:bold; font-size:15px;">🏆 <?php echo esc_html($rank); ?></span>
                <small style="color:#8b949e;"><?php echo $author_points; ?> / <?php echo $next_level; ?> XP</small>
            </div>

            <div class="progress-bar" style="background:#21262d; height:8px; border-radius:4px; overflow:hidden; margin-top:12px;">
                <div class="fill" style="background:<?php echo esc_attr($color); ?>; width:<?php echo $percent; ?>%; height:100%; border-radius:4px; transition:width 0.4s ease-on-out;"></div>
            </div>

            <p class="hint" style="margin:8px 0 0 0; font-size:11px; color:#8b949e;">
                <?php if ($author_points < 5000): ?>
                    পরবর্তী লেভেলের জন্য আরও <?php echo ($next_level - $author_points); ?> XP প্রয়োজন।
                <?php else: ?>
                    আপনি সর্বোচ্চ সাইবার কিং স্তরে উপনীত হয়েছেন!
                <?php endif; ?>
            </p>
        </div>

        <!-- POSTS -->
        <h2 class="section-title" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 19px; color: #fff; margin-bottom: 25px; font-weight: bold; border-left: 4px solid <?php echo esc_attr($neon); ?>; padding-left: 12px; text-transform: uppercase; letter-spacing: 0.5px;">⭐ Recent Posts</h2>

        <div class="cyber-author-posts-container" style="display: flex; flex-direction: column; gap: 20px;">

            <?php if (have_posts()) : while (have_posts()) : the_post(); 
                $post_id      = get_the_ID();
                $post_link    = esc_url(get_permalink());
                $author_name_str = get_the_author();
                $avatar_url   = get_avatar_url($author_id);
                $view_count   = get_post_meta($post_id, 'ilybd_post_views_count', true) ?: '0';
                $like_count   = get_post_meta($post_id, '_likes', true) ?: '0';
                $comments_num = get_comments_number($post_id);
                $excerpt      = wp_trim_words(get_the_excerpt(), 22, '...');
            ?>

                <div class="cyber-horizontal-post-card" style="display: flex; background: rgba(13, 21, 39, 0.45); border: 1.5px solid rgba(255, 255, 255, 0.05); border-radius: 14px; overflow: hidden; transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); box-shadow: 0 4px 15px rgba(0,0,0,0.34); max-width: 100%; position: relative;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='<?php echo esc_attr($neon); ?>cc'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.5), 0 0 12px <?php echo esc_attr($neon); ?>33';" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(255, 255, 255, 0.05)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.34)';">
                    
                    <!-- Left Column: Media Thumbnail -->
                    <div class="post-media-column" style="width: 250px; min-width: 250px; position: relative; overflow: hidden; background: #070b13; border-right: 1px solid rgba(255,255,255,0.05);">
                        <a href="<?php echo $post_link; ?>" style="display: block; width: 100%; height: 100%; min-height: 154px;">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', [
                                    'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;',
                                    'alt' => esc_attr(get_the_title()),
                                    'onmouseover' => "this.style.transform='scale(1.08)'",
                                    'onmouseout' => "this.style.transform='scale(1.0)'"
                                ]); ?>
                            <?php else : ?>
                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#161b22; color:<?php echo esc_attr($neon); ?>; font-family:monospace; font-size:12px; font-weight:bold; min-height: 154px;">ILYBD TECH</div>
                            <?php endif; ?>
                        </a>
                    </div>

                    <!-- Right Column: Info & Content Excerpt -->
                    <div class="post-info-column" style="flex-grow: 1; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden;">
                        <div>
                            <h3 style="margin: 0 0 10px 0 !important; font-size: 17.5px !important; line-height: 1.4 !important; font-weight: 700 !important; font-family: inherit;">
                                <a href="<?php echo $post_link; ?>" style="color: #fff !important; text-decoration: none !important; transition: color 0.2s;" onmouseover="this.style.color='<?php echo esc_attr($neon); ?>'" onmouseout="this.style.color='#fff'">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            
                            <p style="color: #8b949e !important; font-size: 13px !important; line-height: 1.6 !important; margin: 0 0 15px 0 !important;">
                                <?php echo esc_html($excerpt); ?>
                            </p>
                        </div>

                        <!-- Footer Meta Icons Section -->
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; border-top: 1px dashed rgba(255,255,255,0.06); padding-top: 12px; margin-top: auto;">
                            <!-- Author Link group info -->
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <img src="<?php echo esc_url($avatar_url); ?>" style="width: 22px; height: 22px; border-radius: 50%; border: 1.2px solid <?php echo esc_attr($neon); ?>;" alt="">
                                <span style="font-size: 12px; color: #c9d1d9; font-weight: 600;"><?php echo esc_html($author_name_str); ?></span>
                            </div>

                            <!-- Views, Likes, Comments Meta icons -->
                            <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: #8b949e; font-family: monospace;">
                                <div style="display: flex; align-items: center; gap: 4px; background: rgba(255,255,255,0.02); padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.03);" title="Views">
                                    <i class="fa-regular fa-eye" style="color: <?php echo esc_attr($neon); ?>;"></i>
                                    <span><?php echo esc_html($view_count); ?></span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 4px; background: rgba(255,255,255,0.02); padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.03);" title="Comments">
                                    <i class="fa-regular fa-comment" style="color: <?php echo esc_attr($neon); ?>;"></i>
                                    <span><?php echo esc_html($comments_num); ?></span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 4px; background: rgba(255,255,255,0.02); padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.03);" title="Likes">
                                    <i class="fa-regular fa-heart" style="color: <?php echo esc_attr($neon); ?>;"></i>
                                    <span><?php echo esc_html($like_count); ?></span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 4px; background: rgba(255,255,255,0.02); padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.03);" title="Published Date">
                                    <i class="fa-regular fa-calendar-days" style="color: #8b949e;"></i>
                                    <span><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            <?php endwhile; else: ?>
                <div style="text-align: center; padding: 40px; background: rgba(22,27,34,0.3); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                    <p style="color: #8b949e; margin: 0; font-size: 14px;">এই লেখকের কোনো পোস্ট পাওয়া যায়নি।</p>
                </div>
            <?php endif; ?>

        </div>

        <style>
        @media (max-width: 680px) {
            .cyber-horizontal-post-card {
                flex-direction: column !important;
            }
            .post-media-column {
                width: 100% !important;
                min-width: 100% !important;
                border-right: none !important;
                border-bottom: 1px solid rgba(255,255,255,0.05) !important;
            }
            .post-media-column a {
                height: 180px !important;
            }
        }
        </style>

    </section>

</div>

<?php get_footer(); ?>