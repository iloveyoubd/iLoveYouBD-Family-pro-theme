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
        <h2 class="section-title">Recent Posts</h2>

        <div class="post-list">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <a class="post-card" href="<?php the_permalink(); ?>">

                    <div class="thumb">
                        <?php if(has_post_thumbnail()) the_post_thumbnail('thumbnail'); ?>
                    </div>

                    <div class="meta">
                        <h3><?php the_title(); ?></h3>

                        <div class="info">
                            <span>📅 <?php echo get_the_date(); ?></span>
                            <span>👁 <?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?></span>
                        </div>
                    </div>

                </a>

            <?php endwhile; else: ?>
                <p class="empty">No posts yet.</p>
            <?php endif; ?>

        </div>

    </section>

</div>

<?php get_footer(); ?>