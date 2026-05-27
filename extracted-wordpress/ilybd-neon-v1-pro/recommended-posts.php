<?php
/**
 * ILYBD Recommended Posts - Professional Master Edition V3
 * Solves all alignment breaks using Flexbox height anchors and webkit clamps.
 */

$neon = esc_attr(get_option('ilybd_main_color', '#00ff41'));

$args = array(
    'posts_per_page' => 3,
    'post__not_in'   => array(get_the_ID()),
    'orderby'        => 'rand',
    'post_status'    => 'publish'
);

$recommended_query = new WP_Query($args);

if ($recommended_query->have_posts()) : ?>

    <div class="rec-section-wrap" style="margin: 50px 0 20px 0;">
        <h3 style="color: #fff; font-size: 22px; font-weight: 800; margin-bottom: 25px; border-left: 5px solid <?php echo $neon; ?>; padding-left: 15px; text-transform: uppercase; letter-spacing: 0.5px;">
            আপনার জন্য রিকমেন্ডেড টিউনস
        </h3>

        <div class="rec-grid">
            <?php while ($recommended_query->have_posts()) : $recommended_query->the_post(); 
                $post_link    = esc_url(get_permalink());
                $author_id    = get_the_author_meta('ID');
                $view_count   = get_post_meta(get_the_ID(), 'ilybd_post_views_count', true) ?: '0';
                $like_count   = get_post_meta(get_the_ID(), '_likes', true) ?: '0';
            ?>

            <article class="pro-post-card">
                <div class="post-media">
                    <a href="<?php echo $post_link; ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php else : ?>
                            <div class="no-thumb" style="display:flex; justify-content:center; align-items:center; background:#161b22; height:180px; color:#8b949e; font-weight:bold; font-size:14px; border-bottom:1px solid rgba(255,255,255,0.05); text-shadow:0 0 10px rgba(0,255,65,0.2);">
                                <i class="fa-solid fa-wand-magic-sparkles" style="margin-right:8px; color:<?php echo $neon; ?>;"></i> ILYBD SPECIAL
                            </div>
                        <?php endif; ?>

                        <span class="cat-badge" style="background: <?php echo $neon; ?>;">
                            <?php
                            $categories = get_the_category();
                            echo !empty($categories) ? esc_html($categories[0]->name) : 'Tech';
                            ?>
                        </span>
                    </a>
                </div>

                <div class="post-info">
                    <h2 class="post-title">
                        <a href="<?php echo $post_link; ?>" title="<?php the_title_attribute(); ?>">
                            <?php echo esc_html(wp_trim_words(get_the_title(), 11, '...')); ?>
                        </a>
                    </h2>

                    <p class="post-excerpt">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 14, '...')); ?>
                    </p>

                    <div class="rgb-divider"></div>

                    <div class="meta-footer">
                        <div class="meta-wrapper">
                            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="meta-link author-group">
                                <?php echo get_avatar($author_id, 24, '', '', array('class' => 'round-avatar')); ?>
                                <span class="author-name"><?php the_author(); ?></span>
                            </a>

                            <div class="stats-group">
                                <div class="meta-link" title="সময়">
                                    <i class="fa-regular fa-clock"></i> 
                                    <span><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?></span>
                                </div>
                                
                                <div class="meta-link" title="মন্তব্য">
                                    <i class="fa-regular fa-comment"></i> 
                                    <span><?php echo get_comments_number(); ?></span>
                                </div>
                                
                                <div class="meta-link" title="ভিউস">
                                    <i class="fa-regular fa-eye"></i> 
                                    <span><?php echo $view_count; ?></span>
                                </div>
                                
                                <div class="meta-link heart-icon" title="লাইক">
                                    <i class="fa-regular fa-heart"></i> 
                                    <span><?php echo $like_count; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>

<?php endif; ?>

<style>
/* Grid Container */
.rec-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
    gap: 25px;
    align-items: stretch; /* Forces equal heights on sibling grid tracks */
}

/* Card Design - High Precision Equal Heights */
.pro-post-card {
    background: #0d1117;
    border-radius: 14px;
    overflow: hidden;
    position: relative;
    border: 1.5px solid rgba(0, 255, 65, 0.12);
    box-shadow: 0 8px 25px rgba(0,0,0,0.5);
    display: flex;
    flex-direction: column; /* Force flex child alignments */
    height: 100%;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.pro-post-card:hover { 
    transform: translateY(-5px); 
    border-color: <?php echo $neon; ?>; 
    box-shadow: 0 10px 25px rgba(0, 255, 65, 0.18); 
}

.post-media { 
    height: 180px; 
    position: relative; 
    overflow: hidden; 
    background: #07090e;
}
.post-media img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    transition: transform 0.5s ease; 
}
.pro-post-card:hover .post-media img { 
    transform: scale(1.08); 
}

.cat-badge {
    position: absolute; 
    top: 12px; 
    left: 12px;
    color: #000; 
    font-size: 10px; 
    padding: 3.5px 10.5px;
    border-radius: 5px; 
    font-weight: 900; 
    z-index: 5; 
    text-transform: uppercase;
    font-family: monospace;
    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
}

.post-info { 
    padding: 20px; 
    display: flex; 
    flex-direction: column; 
    flex-grow: 1; /* Instructs info to swell and fill remaining space */
}

/* Strict clamp fields to prevent misalignment */
.post-title { 
    font-size: 16px; 
    margin: 0 0 8px 0; 
    line-height: 1.45; 
    font-weight: 700; 
    height: 46px; /* Exactly 2 lines height scale */
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.post-title a { 
    color: #fff; 
    text-decoration: none; 
    transition: 0.2s;
}
.post-title a:hover {
    color: <?php echo $neon; ?>;
}

.post-excerpt { 
    color: #8b949e; 
    font-size: 13px; 
    line-height: 1.5; 
    margin: 0 0 15px 0; 
    height: 58px; /* Safe 3-line excerpt height scale */
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.rgb-divider {
    height: 1.5px; 
    width: 100%; 
    margin: auto 0 14px 0; /* Align helper to push dividers exactly down */
    background: linear-gradient(90deg, #ff0055, <?php echo $neon; ?>, #00f0ff, #ff0055);
    background-size: 300% 100%;
    animation: rgb-move-slow 6s linear infinite;
    opacity: 0.25;
}
@keyframes rgb-move-slow { 
    0%{background-position:0% 50%} 
    100%{background-position:100% 50%} 
}

/* Footer Group layout styling */
.meta-footer {
    width: 100%;
    margin-top: auto; /* Solidify position anchors exactly at bottom space */
}

.meta-wrapper { 
    display: flex; 
    align-items: center; 
    justify-content: space-between; 
    gap: 8px; 
    flex-wrap: wrap;
}

.meta-link { 
    display: flex; 
    align-items: center; 
    gap: 5px; 
    color: #8b949e; 
    font-size: 11px; 
    text-decoration: none; 
    transition: color 0.2s;
}
.meta-link:hover {
    color: #fff;
}

.author-group { 
    display: flex; 
    align-items: center; 
    height: 24px; 
    text-shadow: 0 1px 3px rgba(0,0,0,0.6);
}
.round-avatar { 
    border-radius: 50% !important; 
    border: 1px solid <?php echo $neon; ?>; 
    width: 24px; 
    height: 24px; 
    object-fit: cover;
}
.author-name { 
    margin-left: 6px; 
    color: #c9d1d9; 
    font-weight: 600; 
    font-size: 11.5px; 
}
.author-group:hover .author-name {
    color: <?php echo $neon; ?>;
}

.stats-group { 
    display: flex; 
    align-items: center; 
    gap: 8px; 
}
.stats-group i { 
    color: <?php echo $neon; ?>; 
}
.heart-icon i { 
    color: #ff4b4b; 
}

@media (max-width: 768px) {
    .rec-grid { grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); }
}

@media (max-width: 480px) {
    .rec-grid { grid-template-columns: 1fr; }
    .meta-wrapper { flex-direction: row; align-items: center; justify-content: space-between; }
}
</style>
