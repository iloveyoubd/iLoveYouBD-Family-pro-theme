<?php
/**
 * Popular Posts Grid - ILYBD Pro Style (Full Stats Fix)
 */

$p_count = get_option('popular_post_count', 4);
$neon    = esc_attr(get_option('ilybd_main_color', '#00ff41'));
$p_title_section = get_option('popular_title', '🔥 POPULAR NOW');

$p_meta  = get_option('popular_meta_key', 'ilybd_post_views_count');
if ($p_meta === 'post_views_count' || empty($p_meta)) {
    $p_meta = 'ilybd_post_views_count';
}

$p_query = new WP_Query([
    'posts_per_page' => $p_count,
    'meta_key'       => $p_meta,
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC'
]);
?>

<section class="popular-wrapper">

    <div class="section-head">
        <span class="label"><?php echo esc_html($p_title_section); ?></span>
        <span class="line"></span>
    </div>

    <div class="popular-grid">

        <?php if ($p_query->have_posts()) : ?>
            <?php while ($p_query->have_posts()) : $p_query->the_post(); 
                $p_link    = get_permalink();
                $p_author  = get_the_author_meta('ID');
                $p_views   = get_post_meta(get_the_ID(), $p_meta, true) ?: '0';
                $p_likes   = get_post_meta(get_the_ID(), '_likes', true) ?: '0';
                $p_comments = get_comments_number(); // কমেন্ট সংখ্যা
            ?>

                <article class="pro-post-card popular-style">

                    <div class="post-media">
                        <a href="<?php echo $p_link; ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <div class="no-thumb">ILYBD PRO</div>
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
                            <a href="<?php echo $p_link; ?>">
                                <?php echo esc_html(wp_trim_words(get_the_title(), 11, '...')); ?>
                            </a>
                        </h2>

                        <p class="post-excerpt">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 16, '...')); ?>
                        </p>

                        <div class="rgb-divider"></div>

                        <div class="meta-footer">
                            <div class="meta-wrapper">
                                
                                <a href="<?php echo esc_url(get_author_posts_url($p_author)); ?>" class="meta-link author-group">
                                    <?php echo get_avatar($p_author, 22, '', 'Author', array('class' => 'round-avatar')); ?>
                                    <span class="author-name"><?php the_author(); ?></span>
                                </a>

                                <div class="stats-group">
                                    <div class="meta-link no-click" title="Time">
                                        <i class="fa-regular fa-clock"></i> 
                                        <span><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?></span>
                                    </div>

                                    <div class="meta-link no-click" title="Comments">
                                        <i class="fa-regular fa-comment"></i> 
                                        <span><?php echo $p_comments; ?></span>
                                    </div>

                                    <div class="meta-link no-click" title="Views">
                                        <i class="fa-regular fa-eye"></i> 
                                        <span><?php echo esc_html($p_views); ?></span>
                                    </div>
                                    
                                    <div class="meta-link no-click" title="Likes">
                                        <i class="fa-regular fa-heart"></i> 
                                        <span><?php echo esc_html($p_likes); ?></span>
                                    </div>

                                    <!-- Share Button Trigger with Dropdown Option -->
                                    <div class="meta-link share-wrapper" style="position: relative; display: inline-block;">
                                        <button class="meta-link share-btn-trigger" title="Share Post" style="background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; gap: 4px; color: #8b949e; transition: 0.3s;" onclick="togglePostCardShare(this, event)">
                                            <i class="fa-solid fa-share-nodes" style="color: <?php echo $neon; ?>;"></i> 
                                            <span>শেয়ার</span>
                                        </button>
                                        <div class="postcard-share-dropdown" style="display: none; position: absolute; bottom: 30px; right: 0; background: #1c2128; border: 1.5px solid <?php echo $neon; ?>; box-shadow: 0 5px 15px rgba(0,0,0,0.8), 0 0 10px <?php echo $neon; ?>44; border-radius: 8px; padding: 8px; z-index: 999; width: 156px;">
                                            <div style="font-size: 10px; color: #8b949e; text-transform: uppercase; font-weight: 800; margin-bottom: 6px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 4px; text-align: center;">Share options</div>
                                            <div class="dropdown-share-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px;">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($p_link); ?>" target="_blank" style="width: 28px; height: 28px; border-radius: 50%; background: #1877f2; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; text-decoration: none;" title="Facebook">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title()) . ' ' . esc_url($p_link); ?>" target="_blank" style="width: 28px; height: 28px; border-radius: 50%; background: #25d366; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; text-decoration: none;" title="WhatsApp">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                                <a href="https://t.me/share/url?url=<?php echo esc_url($p_link); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" style="width: 28px; height: 28px; border-radius: 50%; background: #0088cc; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; text-decoration: none;" title="Telegram">
                                                    <i class="fab fa-telegram-plane"></i>
                                                </a>
                                                <button onclick="copyPostCardLink('<?php echo esc_js($p_link); ?>', this, event)" style="width: 28px; height: 28px; border-radius: 50%; background: <?php echo $neon; ?>; display: flex; align-items: center; justify-content: center; color: #000; font-size: 12px; border: none; cursor: pointer;" title="Copy Link">
                                                    <i class="fa-solid fa-link"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </article>

            <?php endwhile; wp_reset_postdata(); ?>
        <?php endif; ?>

    </div>

</section>

<style>
/* Section Header */
.popular-wrapper { margin: 30px 0; padding: 0 10px; }
.section-head { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
.section-head .label { color: <?php echo $neon; ?>; font-weight: 800; font-size: 15px; text-transform: uppercase; }
.section-head .line { flex: 1; height: 1px; background: rgba(0,255,65,0.2); }

/* Grid Setup */
.popular-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 20px;
}

/* Card Style */
.popular-style.pro-post-card {
    background: #0d1117;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid transparent;
    background-image: linear-gradient(#0d1117, #0d1117), 
                      linear-gradient(90deg, #ff0000, <?php echo $neon; ?>, #0000ff, #ff0000);
    background-origin: border-box;
    background-clip: content-box, border-box;
    box-shadow: 0 4px 15px rgba(0,0,0,0.5);
    transition: 0.3s ease;
}

.popular-style.pro-post-card:hover { transform: translateY(-5px); }

.post-media { height: 180px; position: relative; overflow: hidden; }
.post-media img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s ease; }
.popular-style.pro-post-card:hover .post-media img { transform: scale(1.1); }

.cat-badge {
    position: absolute; top: 12px; left: 12px;
    color: #000; font-size: 10px; padding: 4px 10px;
    border-radius: 4px; font-weight: bold; z-index: 2;
}

.post-info { padding: 15px; }
.post-title { font-size: 17px; margin-bottom: 8px; line-height: 1.4; font-weight: 600; }
.post-title a { color: #ffffff; text-decoration: none; transition: 0.2s; }
.post-title a:hover { color: <?php echo $neon; ?>; }

.post-excerpt { 
    color: #8b949e; font-size: 13px; margin-bottom: 12px; 
    line-height: 1.5; height: 40px; overflow: hidden; 
}

.rgb-divider {
    height: 1px; width: 100%; margin: 12px 0;
    background: linear-gradient(90deg, #ff0000, <?php echo $neon; ?>, #0000ff, #ff0000);
    opacity: 0.2;
}

/* Meta Footer Alignment */
.meta-wrapper { display: flex; align-items: center; justify-content: space-between; gap: 8px; }

.author-group { display: flex; align-items: center; text-decoration: none; min-width: 80px; }
.round-avatar { border-radius: 50% !important; border: 1px solid <?php echo $neon; ?>; width: 22px; height: 22px; }
.author-name { font-size: 11px; font-weight: 600; color: #e0e0e0; margin-left: 6px; white-space: nowrap; }

.stats-group { display: flex; align-items: center; gap: 8px; }
.meta-link { display: flex; align-items: center; gap: 4px; color: #8b949e; font-size: 10px; }
.meta-link i { font-size: 12px; color: <?php echo $neon; ?>; }
.no-click { cursor: default; }

/* Mobile Only */
@media (max-width: 480px) {
    .popular-grid { grid-template-columns: 1fr; }
    .meta-wrapper { flex-wrap: wrap; justify-content: center; gap: 10px; }
    .stats-group { flex-wrap: wrap; justify-content: center; }
}
</style>
