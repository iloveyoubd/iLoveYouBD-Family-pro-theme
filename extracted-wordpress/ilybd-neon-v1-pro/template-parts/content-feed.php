<?php
/**
 * Template Part: Content Feed Card (CyberX Pro - Final Force Fix)
 */
$u_id = get_the_author_meta('ID');
$post_id = get_the_ID();
?>

<div class="ilybd-feed-card" style="background:#0d1117; border:1px solid #30363d; border-radius:12px; padding:15px; margin-bottom:20px; overflow:hidden;">

    <div style="margin-bottom:12px;">
        <a href="<?php the_permalink(); ?>" style="font-size:18px; color:#fff; text-decoration:none; font-weight:600; display:block;">
            <?php the_title(); ?>
        </a>
    </div>

    <div style="display:flex; gap:12px; margin-bottom:15px;">
        <a href="<?php the_permalink(); ?>" style="flex-shrink:0;">
            <?php if (has_post_thumbnail()) : the_post_thumbnail('thumbnail', ['style' => 'width:100px; height:75px; border-radius:8px; object-fit:cover; border:1px solid #333;']); endif; ?>
        </a>
        <div style="font-size:13px; color:#8b949e; line-height:1.4;">
            <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
        </div>
    </div>

    <div style="display: flex !important; align-items: center !important; flex-wrap: nowrap !important; border-top: 1px solid #1c2128; padding-top: 12px; gap: 15px;">
        
        <a href="<?php echo get_author_posts_url($u_id); ?>" style="display:flex !important; align-items:center !important; text-decoration:none !important; flex-shrink:0 !important;">
            <div style="margin-right:8px; line-height:0;">
                <?php echo get_avatar($u_id, 26, '', '', array('style' => 'border-radius:50%; border:1.5px solid #00ff41; width:26px; height:26px;')); ?>
            </div>
            <span style="color:#fff !important; font-size:14px !important; font-weight:600 !important; white-space:nowrap !important; display:inline-block !important; line-height:1 !important;">
                <?php the_author(); ?> <i class="dashicons dashicons-yes" style="color:#00ff41; font-size:14px; vertical-align:middle; width:auto; height:auto;"></i>
            </span>
        </a>

        <div style="display:flex !important; align-items:center !important; gap:12px !important; color:#8b949e !important; font-size:11px !important;">
            <span style="display:flex; align-items:center; gap:3px;">
                <i class="dashicons dashicons-clock" style="font-size:14px; color:#00ff41;"></i> 
                <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?>
            </span>
            <span style="display:flex; align-items:center; gap:3px;">
                <i class="dashicons dashicons-visibility" style="font-size:14px; color:#00ff41;"></i> 
                <?php echo (int) get_post_meta($post_id, 'ilybd_post_views_count', true); ?>
            </span>
            <span style="display:flex; align-items:center; gap:3px;">
                <i class="dashicons dashicons-admin-comments" style="font-size:14px; color:#00ff41;"></i> 
                <?php echo get_comments_number($post_id); ?>
            </span>
        </div>

    </div>

</div>
