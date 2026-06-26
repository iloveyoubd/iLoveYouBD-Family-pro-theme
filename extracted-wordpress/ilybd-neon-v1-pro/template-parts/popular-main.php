<?php
/**
 * Popular Posts - Electro-Gold Horizon Layout (Premium 2040 Edition)
 * Completely distinct design utilizing landscape grid layouts, and deep amber-orange vector border glows.
 */

$p_count = get_option('popular_post_count', 4);
$neon    = esc_attr(get_option('ilybd_main_color', '#00ff41'));
$p_title_section = get_option('popular_title', '🔥 POPULAR NOW');

$p_source = get_option('popular_source', 'views');
$p_order  = get_option('popular_sort_order', 'DESC');

$p_args = [
    'posts_per_page' => $p_count,
    'post_status'    => 'publish',
    'order'          => $p_order,
];

if ($p_source === 'views') {
    $p_args['meta_key'] = 'ilybd_post_views_count';
    $p_args['orderby']  = 'meta_value_num';
} elseif ($p_source === 'likes') {
    $p_args['meta_key'] = '_likes';
    $p_args['orderby']  = 'meta_value_num';
} elseif ($p_source === 'comments') {
    $p_args['orderby']  = 'comment_count';
} else {
    $p_args['orderby']  = 'date';
}

$p_query = new WP_Query($p_args);

// Foolproof Fallback
if (!$p_query->have_posts() && ($p_source === 'views' || $p_source === 'likes')) {
    unset($p_args['meta_key']);
    $p_args['orderby'] = 'date';
    $p_query = new WP_Query($p_args);
}
?>

<section class="popular-wrapper-gold">

    <h2 class="section-head-popular" style="margin:0; padding:0; border:none; font-weight:normal;">
        <div class="popular-indicator">
            <i class="fa-solid fa-fire animate-popular-flame"></i>
            <span class="label"><?php echo esc_html($p_title_section); ?></span>
        </div>
        <span class="line-popular"></span>
    </h2>

    <!-- Horizontal Grid Container -->
    <div class="popular-grid-horizon">

        <?php if ($p_query->have_posts()) : ?>
            <?php while ($p_query->have_posts()) : $p_query->the_post(); 
                $p_link    = get_permalink();
                $p_author  = get_the_author_meta('ID');
                $p_views   = get_post_meta(get_the_ID(), 'ilybd_post_views_count', true) ?: '0';
                $p_likes   = get_post_meta(get_the_ID(), '_likes', true) ?: '0';
                $p_comments = get_comments_number();
                $p_cats    = get_the_category();
                $p_cat_name = !empty($p_cats) ? esc_html($p_cats[0]->name) : 'Tech';
                
                // Calculate dynamic reading time
                $content = get_post_field('post_content', get_the_ID());
                $word_count = mb_strlen(strip_tags($content), 'UTF-8');
                $p_r_time = ceil($word_count / 350);
                if ($p_r_time < 1) $p_r_time = 1;
            ?>

                <article class="popular-horizon-card">

                    <!-- Left: Curved Thumbnail Area -->
                    <div class="popular-media">
                        <a href="<?php echo $p_link; ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                            <?php else : ?>
                                <div class="gold-no-thumb">ILYBD PRO</div>
                            <?php endif; ?>
                        </a>
                        <span class="gold-cat-badge"><?php echo $p_cat_name; ?></span>
                    </div>

                    <!-- Right: Dense Landscape Metadata & Info -->
                    <div class="popular-info">
                        <div class="popular-meta-top">
                            <span class="popular-read-time"><i class="fa-regular fa-clock"></i> <?php echo $p_r_time; ?> Min Read</span>
                            <span class="popular-views-badge"><i class="fa-regular fa-eye"></i> <?php echo $p_views; ?> Views</span>
                        </div>

                        <h3 class="popular-title">
                            <a href="<?php echo $p_link; ?>">
                                <?php echo esc_html(wp_trim_words(get_the_title(), 11, '...')); ?>
                            </a>
                        </h3>

                        <p class="popular-excerpt">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?>
                        </p>

                        <div class="popular-card-divider"></div>

                        <div class="popular-footer">
                            <a href="<?php echo esc_url(get_author_posts_url($p_author)); ?>" class="popular-author">
                                <?php echo get_avatar($p_author, 20, '', 'Author', array('class' => 'gold-avatar')); ?>
                                <span class="popular-author-name"><?php the_author(); ?></span>
                            </a>

                            <div class="popular-actions">
                                <div class="popular-stat"><i class="fa-regular fa-heart"></i> <?php echo $p_likes; ?></div>
                                <div class="popular-stat"><i class="fa-regular fa-comment"></i> <?php echo $p_comments; ?></div>
                            </div>
                        </div>
                    </div>

                </article>

            <?php endwhile; wp_reset_postdata(); ?>
        <?php endif; ?>

    </div>

</section>

<style>
/* 2040 Electro-Gold Popular Grid Styles */
.popular-wrapper-gold { 
    margin: 35px auto; 
    padding: 0 15px; 
    max-width: 100%;
    box-sizing: border-box;
}

.section-head-popular { 
    display: flex; 
    align-items: center; 
    gap: 16px; 
    margin-bottom: 24px; 
}

.popular-indicator {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 184, 0, 0.12);
    border: 1px solid rgba(255, 184, 0, 0.35);
    padding: 6px 14px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(255, 184, 0, 0.15);
}

.section-head-popular .label { 
    color: #ffcc00; 
    font-weight: 850; 
    font-size: 13.5px; 
    letter-spacing: 0.8px;
    text-transform: uppercase;
    font-family: 'Space Grotesk', sans-serif;
    text-shadow: 0 0 10px rgba(255, 184, 0, 0.4);
}

.animate-popular-flame {
    color: #ff7c00;
    text-shadow: 0 0 8px #ffb800;
    animation: popularFlamePulse 1.2s infinite ease-in-out;
}

@keyframes popularFlamePulse {
    0%, 100% { transform: scale(1); opacity: 1; filter: drop-shadow(0 0 2px #ff7c00); }
    50% { transform: scale(1.15); opacity: 0.8; filter: drop-shadow(0 0 8px #ffb800); }
}

.section-head-popular .line-popular { 
    flex: 1; 
    height: 1.5px; 
    background: linear-gradient(90deg, #ffb800, rgba(255, 184, 0, 0.05)); 
}

/* Horizontal Card Grid Setup */
.popular-grid-horizon {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 High-Professional cards side-by-side on desktop */
    grid-gap: 24px;
}

/* Landscape Card Structure */
.popular-horizon-card {
    background: linear-gradient(135deg, #0e0d07 0%, #17150d 100%) !important; /* Elegant black gold metal */
    border: 1.5px solid rgba(255, 184, 0, 0.18) !important; /* Gold border glow */
    border-radius: 16px !important;
    position: relative;
    overflow: hidden !important;
    box-shadow: 0 12px 30px rgba(0,0,0,0.65), inset 0 0 20px rgba(255, 184, 0, 0.03);
    display: flex !important;
    flex-direction: row !important; /* Always side-by-side split on desktop */
    height: 220px !important; /* Prevent text collisions */
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
}

.popular-horizon-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, transparent 40%, rgba(255, 184, 0, 0.04) 50%, transparent 60%);
    background-size: 200% 200%;
    transition: all 0.6s ease;
    pointer-events: none;
}

.popular-horizon-card:hover::before {
    background-position: 100% 100%;
}

.popular-horizon-card:hover {
    transform: translateY(-5px) scale(1.01) !important;
    border-color: rgba(255, 184, 0, 0.6) !important;
    box-shadow: 0 16px 35px rgba(255, 184, 0, 0.18), inset 0 0 30px rgba(255, 184, 0, 0.06) !important;
}

/* Media Panel (Left, 40%) */
.popular-media {
    width: 40% !important;
    height: 100% !important;
    flex-shrink: 0 !important;
    position: relative;
    overflow: hidden;
}

.popular-media img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
}

.popular-horizon-card:hover .popular-media img {
    transform: scale(1.08) !important;
}

.gold-no-thumb {
    height: 100%;
    background: #151108;
    color: #6d5b31;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 11px;
}

.gold-cat-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(13, 12, 7, 0.82);
    border: 1px solid rgba(255, 184, 0, 0.35);
    color: #ffd000 !important;
    font-size: 10px;
    font-weight: 850;
    padding: 2.5px 8px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Content Panel (Right, 60%) */
.popular-info {
    width: 60% !important;
    flex-shrink: 0 !important;
    padding: 16px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
    min-width: 0 !important;
    box-sizing: border-box !important;
}

.popular-meta-top {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 6px;
}

.popular-read-time, .popular-views-badge {
    font-family: 'JetBrains Mono', monospace;
    font-size: 9.5px;
    font-weight: 700;
    color: #ffcc00 !important;
    background: rgba(255, 184, 0, 0.06) !important;
    border: 1px solid rgba(255, 184, 0, 0.15) !important;
    padding: 3px 8px !important;
    border-radius: 6px !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.3s ease;
}

.popular-horizon-card:hover .popular-read-time,
.popular-horizon-card:hover .popular-views-badge {
    background: rgba(255, 184, 0, 0.12) !important;
    border-color: rgba(255, 184, 0, 0.4) !important;
    color: #ffffff !important;
}

.popular-title {
    font-size: 15px !important;
    font-weight: 850 !important;
    line-height: 1.4 !important;
    margin: 0 0 6px 0 !important;
    overflow: hidden !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
}

.popular-title a {
    color: #ffffff !important;
    text-decoration: none !important;
    transition: color 0.2s ease;
}

.popular-title a:hover {
    color: #ffcc00 !important;
    text-shadow: 0 0 8px rgba(255,184,0,0.3);
}

.popular-excerpt {
    font-size: 12.5px !important;
    line-height: 1.55 !important;
    color: #a0a5b0 !important;
    margin: 4px 0 10px 0 !important;
    overflow: hidden !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important; /* up to 2 lines of details under the title */
    -webkit-box-orient: vertical !important;
    font-family: 'Hind Siliguri', sans-serif !important;
}

.popular-card-divider {
    height: 1px;
    width: 100%;
    background: rgba(255, 184, 0, 0.12);
    margin: 4px 0 8px 0;
}

.popular-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-top: auto;
}

.popular-author {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    min-width: 0;
}

.gold-avatar {
    border-radius: 50% !important;
    border: 2px solid rgba(255, 184, 0, 0.45) !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 0 8px rgba(255, 184, 0, 0.1);
}

.popular-horizon-card:hover .gold-avatar {
    border-color: #ffd700 !important;
    box-shadow: 0 0 12px rgba(255, 184, 0, 0.45);
    transform: rotate(10deg);
}

.popular-author-name {
    font-size: 10.5px;
    font-weight: 850;
    color: #cbd5e1;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.06);
    padding: 3px 8px;
    border-radius: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: all 0.3s ease;
}

.popular-horizon-card:hover .popular-author-name {
    color: #ffcc00;
    background: rgba(255, 184, 0, 0.05);
    border-color: rgba(255, 184, 0, 0.2);
}

.popular-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.popular-stat {
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    font-weight: 750;
    color: #a0a5b0;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 4px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.3s ease;
}

.popular-stat i {
    color: #ff9e00;
    font-size: 10px;
    transition: transform 0.3s ease;
}

.popular-horizon-card:hover .popular-stat {
    background: rgba(255, 184, 0, 0.05);
    border-color: rgba(255, 184, 0, 0.15);
    color: #ffffff;
}

.popular-horizon-card:hover .popular-stat i {
    transform: scale(1.2);
}

/* DEVICES RESPONDING OVERRIDES */
@media (max-width: 991px) {
    .popular-horizon-card {
        height: 180px !important;
    }
    .popular-info {
        padding: 12px !important;
    }
}

@media (max-width: 768px) {
    .popular-grid-horizon {
        grid-template-columns: 1fr;
        grid-gap: 16px;
    }
    
    /* Compact tactile mobile mode to look pristine on devices */
    .popular-horizon-card {
        height: 135px !important;
        border-radius: 12px !important;
        background: linear-gradient(135deg, #0b0a05 0%, #121008 100%) !important;
    }
    
    .popular-media {
        width: 115px !important;
    }
    
    .gold-cat-badge {
        font-size: 8px !important;
        top: 6px !important;
        left: 6px !important;
        padding: 1.5px 5px !important;
    }
    
    .popular-info {
        width: calc(100% - 115px) !important;
        padding: 10px !important;
    }
    
    .popular-meta-top {
        display: flex !important; /* Enable details (reading time and views) on mobile underneath/above title */
        gap: 6px !important;
        margin-bottom: 2px !important;
    }
    
    .popular-read-time, .popular-views-badge {
        font-size: 8px !important;
        padding: 2px 5px !important;
    }
    
    .popular-title {
        font-size: 12px !important;
        margin-bottom: 2px !important;
        line-height: 1.4 !important;
        font-weight: 850 !important;
    }
    
    .popular-excerpt {
        display: none !important;
    }
    
    .popular-card-divider {
        margin: 3px 0 !important;
    }
    
    .popular-author-name {
        font-size: 9px !important;
        padding: 2px 5px !important;
        max-width: none !important; /* Allow profile names to show fully without truncation */
        white-space: nowrap !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }

    .popular-stat {
        font-size: 8.5px !important;
        padding: 2.5px 5px !important;
    }
}
</style>
