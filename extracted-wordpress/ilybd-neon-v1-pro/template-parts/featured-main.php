<?php
$f_ids = get_option('ilybd_featured_ids', '');
if (!empty($f_ids)) :
    $query = new WP_Query(['post__in' => explode(',', $f_ids), 'orderby' => 'post__in']);
?>
<section class="featured-wrapper" style="margin:30px 0;">
    <div class="section-head" style="display:flex; align-items:center; gap:15px; margin-bottom:20px; padding:0 10px;">
        <span class="label" style="color:#00ff41; font-weight:800; font-size:15px;">⭐ FEATURED POSTS</span>
        <span class="line" style="flex:1; height:1px; background:rgba(0,255,65,0.2);"></span>
    </div>
    <div class="featured-grid ilybd-post-grid-system" style="padding:0 10px; margin-top:0;">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php get_template_part('template-parts/post-card'); ?>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</section>
<?php endif; ?>
