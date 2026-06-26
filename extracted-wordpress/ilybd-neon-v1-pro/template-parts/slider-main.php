<?php
/**
 * ILYBD NEON SLIDER - HORIZONTAL COMPACT LANDSCAPE SLIDES WITH TRENDING CORNER MARKS
 * বামে থাম্বনেইল, ডানে টাইটেল, ক্যাটাগরি, ১-২ লাইন ডেসক্রিপশন, আথার ও লাইভ ইকোনমি স্ট্যাটস।
 */

$count  = get_option('slider_post_count', 9); // ডেক্সটপে ৩টি করে দেখালে মোট ৯টি পোস্ট রাখা ভালো
$source = get_option('slider_source', 'latest');
$neon   = get_option('ilybd_main_color', '#00ff41');

$args = array(
    'posts_per_page' => $count,
    'post_status'    => 'publish',
    'order'          => 'DESC'
);

if ($source == 'popular') {
    $args['meta_key'] = 'ilybd_post_views_count';
    $args['orderby']  = 'meta_value_num';
} elseif ($source == 'likes') {
    $args['meta_key'] = '_likes';
    $args['orderby']  = 'meta_value_num';
} elseif ($source == 'comments') {
    $args['orderby']  = 'comment_count';
} elseif ($source == 'trending') {
    $args['meta_key'] = 'ilybd_post_views_count';
    $args['orderby']  = 'meta_value_num';
    $args['date_query'] = array(
        array(
            'column' => 'post_date_gmt',
            'after'  => '30 days ago',
        ),
    );
} elseif ($source == 'featured') {
    $featured_ids = get_option('ilybd_featured_ids', '');
    $args['post__in'] = !empty($featured_ids) ? array_map('intval', explode(',', $featured_ids)) : array(0);
    $args['orderby']  = 'post__in';
} else {
    // default: latest
    $args['orderby']  = 'date';
}

$query = new WP_Query($args);

// Fallback if trending has no posts in 30 days
if ($source == 'trending' && !$query->have_posts()) {
    unset($args['date_query']);
    $query = new WP_Query($args);
}

// Fallback if popular/likes has zero meta metrics recorded yet
if (!$query->have_posts() && ($source == 'popular' || $source == 'likes' || $source == 'featured')) {
    $fallback_args = array(
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    $args = $fallback_args;
    $query = new WP_Query($fallback_args);
}
$final_slider_args = $args;
?>

<section class="hero-slider-wrapper">
    <div class="swiper hero-slider">
        <div class="swiper-wrapper">
            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); 
                $author_id   = get_the_author_meta('ID');
                $views       = get_post_meta(get_the_ID(), 'ilybd_post_views_count', true) ?: '0';
                $likes       = get_post_meta(get_the_ID(), '_likes', true) ?: '0';
                $cats        = get_the_category();
                $post_link   = get_permalink();
                $comment_lnk = get_comments_link();
                
                // Calculate actual dynamic reading time
                $content = get_post_field('post_content', get_the_ID());
                $word_count = mb_strlen(strip_tags($content), 'UTF-8');
                $reading_time = ceil($word_count / 350); // Bengali character/word speed ratio
                if ($reading_time < 1) $reading_time = 1;
            ?>
                <div class="swiper-slide hero-slide">
                    <article class="pro-post-card slider-card-mode">
                        
                        <!-- LEFT SIDE: Ken Burns High Resolution Backdrop/Thumbnail -->
                        <div class="slider-left-thumb">
                            <a href="<?php echo $post_link; ?>" class="slider-thumb-link">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', ['alt' => get_the_title(), 'class' => 'ken-burns-img']); ?>
                                <?php else : ?>
                                    <div class="no-thumb">ILYBD PRO</div>
                                <?php endif; ?>
                            </a>
                            <div class="slider-img-overlay-shader"></div>
                        </div>

                        <!-- RIGHT SIDE OR METADATA CONTENT WRAPPER -->
                        <div class="slider-right-content">
                            
                            <!-- Badges row: Category + Corner Trending Mark -->
                            <div class="cat-trending-row">
                                <span class="cat-badge" style="background: <?php echo $neon; ?>; box-shadow: 0 0 12px <?php echo $neon; ?>77;">
                                    <?php echo !empty($cats) ? esc_html($cats[0]->name) : 'Tech'; ?>
                                </span>
                                
                                <span class="trending-badge" style="border: 1px solid <?php echo $neon; ?>; color: <?php echo $neon; ?>; box-shadow: 0 0 10px <?php echo $neon; ?>44;">
                                    <i class="fa-solid fa-fire animate-pulseFast"></i> TRENDING
                                </span>
                            </div>

                            <!-- Post Title with premium glass glow shadow -->
                            <h2 class="post-title slider-horizontal-title">
                                <a href="<?php echo $post_link; ?>">
                                    <?php echo esc_html(wp_trim_words(get_the_title(), 14, '...')); ?>
                                </a>
                            </h2>

                            <!-- Post Short One or Two lines description text as requested -->
                            <p class="slider-excerpt">
                                <?php 
                                    $excerpt = get_the_excerpt();
                                    if (empty($excerpt)) {
                                        $excerpt = get_the_content();
                                    }
                                    echo esc_html(wp_trim_words($excerpt, 22, '...')); 
                                ?>
                            </p>

                            <div class="rgb-divider-neon" style="background: linear-gradient(90deg, transparent, <?php echo $neon; ?> 15%, <?php echo $neon; ?> 85%, transparent);"></div>

                            <!-- Author profile and statistics footer matching requested design -->
                            <div class="meta-footer">
                                <div class="meta-wrapper">
                                    <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="meta-link author-group">
                                        <?php echo get_avatar($author_id, 22, '', '', array('class' => 'round-avatar-neon', 'style' => "border-color: {$neon}")); ?>
                                        <b class="author-name" style="color: <?php echo $neon; ?>;"><?php the_author(); ?></b>
                                    </a>

                                    <div class="stats-group">
                                        <div class="meta-link-badge" title="Reading Time">
                                            <i class="fa-regular fa-clock" style="color:<?php echo $neon; ?>;"></i>
                                            <span><?php echo $reading_time; ?> Min Read</span>
                                        </div>
                                        <div class="meta-link-badge" title="Views">
                                            <i class="fa-regular fa-eye" style="color:<?php echo $neon; ?>;"></i>
                                            <span><?php echo $views; ?></span>
                                        </div>
                                        <a href="<?php echo $comment_lnk; ?>" class="meta-link-badge" title="Comments">
                                            <i class="fa-regular fa-comment" style="color:<?php echo $neon; ?>;"></i>
                                            <span><?php echo get_comments_number(); ?></span>
                                        </a>
                                        <a href="<?php echo $post_link; ?>#ilybd-like-container" class="meta-link-badge" title="Likes">
                                            <i class="fa-regular fa-heart" style="color:<?php echo $neon; ?>;"></i>
                                            <span><?php echo $likes; ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </article>
                </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </div>

    <!-- Small Thumbnails Grid Navigation Area (with layout requested) -->
    <div class="thumbs-container">
        <div class="swiper hero-thumbs">
            <div class="swiper-wrapper">
                <?php 
                $query = new WP_Query($final_slider_args);
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); 
                    $author_id   = get_the_author_meta('ID');
                    $views       = get_post_meta(get_the_ID(), 'ilybd_post_views_count', true) ?: '0';
                    $likes       = get_post_meta(get_the_ID(), '_likes', true) ?: '0';
                ?>
                    <div class="swiper-slide thumb-item">
                        <div class="thumb-flex-box">
                            <!-- Left panel: small thumbnail image -->
                            <div class="thumb-img-area">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                <?php else : ?>
                                    <div class="no-thumb-small">IBD</div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Right panel: Post title & stats (Author, views, comment, likes) -->
                            <div class="thumb-text-area">
                                <span class="thumb-title-text"><?php echo wp_trim_words(get_the_title(), 6, '...'); ?></span>
                                <div class="thumb-meta-info">
                                    <span class="thumb-author"><?php the_author(); ?></span>
                                    <span class="thumb-stat"><i class="fa-regular fa-eye"></i> <?php echo $views; ?></span>
                                    <span class="thumb-stat"><i class="fa-regular fa-comment"></i> <?php echo get_comments_number(); ?></span>
                                    <span class="thumb-stat"><i class="fa-regular fa-heart"></i> <?php echo $likes; ?></span>
                                </div>
                            </div>
                            
                            <!-- Sleeter, Thinner Progress/loading bar inside each thumb -->
                            <div class="thumb-progress-bg">
                                <div class="thumb-progress-fill" style="background: <?php echo esc_attr($neon); ?>;"></div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
/* Cinematic Sliders Layout 2040 Standard */
.hero-slider-wrapper {
    max-width: 100%;
    width: 100%;
    margin: 0 auto 24px;
    background: #070b13;
    border: 1.5px solid rgba(255, 255, 255, 0.05);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75), 0 0 15px rgba(0, 0, 0, 0.5);
    border-radius: 16px;
    overflow: hidden;
    box-sizing: border-box;
}

.hero-slide {
    height: auto !important;
}

/* Master Slide Layout */
.slider-card-mode {
    border: none !important;
    background: #0b111e !important;
    height: 400px !important; /* Cinematic heightened view */
    position: relative !important;
    overflow: hidden !important;
    display: flex !important;
    flex-direction: row !important; /* Side-by-side splits on desktop */
    align-items: center !important;
    padding: 0 !important;
    border-radius: 0 !important;
    box-sizing: border-box !important;
}

/* Image container takes 55% area with zoom effect */
.slider-left-thumb {
    width: 55% !important;
    height: 100% !important;
    flex-shrink: 0 !important;
    overflow: hidden !important;
    position: relative !important;
}

.slider-thumb-link {
    display: block !important;
    width: 100% !important;
    height: 100% !important;
}

.ken-burns-img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 12s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
}

.slider-card-mode:hover .ken-burns-img {
    transform: scale(1.12) !important;
}

.slider-img-overlay-shader {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(90deg, transparent 50%, #0b111e 100%);
    pointer-events: none;
    z-index: 2;
}

/* Text Detail Content Container takes 45% */
.slider-right-content {
    width: 45% !important;
    height: 100% !important;
    flex-shrink: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: flex-start !important;
    padding: 30px 40px !important;
    background: #0b111e !important;
    z-index: 3;
    position: relative;
    min-width: 0 !important;
    box-sizing: border-box !important;
}

/* Badges row formatting */
.cat-trending-row {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    margin-bottom: 20px !important;
    flex-wrap: nowrap !important;
}

.cat-badge {
    display: inline-block !important;
    font-size: 10px !important;
    padding: 4px 12px !important;
    border-radius: 6px !important;
    font-weight: 850 !important;
    text-transform: uppercase !important;
    color: #000 !important;
    letter-spacing: 0.8px !important;
}

.trending-badge {
    font-size: 10px !important;
    font-weight: 850 !important;
    padding: 4px 12px !important;
    border-radius: 6px !important;
    background: rgba(4, 7, 12, 0.75) !important;
    letter-spacing: 0.8px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    text-transform: uppercase !important;
}

/* Landscape Title config */
.slider-horizontal-title {
    font-size: 24px !important;
    font-weight: 950 !important;
    line-height: 1.35 !important;
    margin: 0 0 16px 0 !important;
    font-family: 'Space Grotesk', sans-serif !important;
    overflow: hidden !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
}

.slider-horizontal-title a {
    color: #ffffff !important;
    text-decoration: none !important;
    transition: all 0.3s ease !important;
}

.slider-horizontal-title a:hover {
    color: <?php echo $neon; ?> !important;
    text-shadow: 0 0 15px <?php echo $neon; ?>77 !important;
}

/* Excerpt style */
.slider-excerpt {
    font-size: 14px !important;
    color: #8b949e !important;
    line-height: 1.6 !important;
    margin: 0 0 24px 0 !important;
    overflow: hidden !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    font-family: 'Hind Siliguri', sans-serif !important;
}

.rgb-divider-neon {
    height: 1.5px !important;
    width: 100% !important;
    margin-bottom: 24px !important;
    opacity: 0.65 !important;
}

/* Footer elements */
.meta-footer {
    width: 100% !important;
}

.meta-wrapper {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px !important;
    width: 100% !important;
}

.author-group {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    text-decoration: none !important;
    min-width: 0 !important;
}

.round-avatar-neon {
    width: 24px !important;
    height: 24px !important;
    border-radius: 50% !important;
    border: 1.5px solid !important;
    flex-shrink: 0 !important;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.1) !important;
}

.author-name {
    font-size: 13px !important;
    font-weight: 850 !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

.stats-group {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    flex-shrink: 0 !important;
}

.meta-link-badge {
    background: rgba(255, 255, 255, 0.03) !important;
    border: 1px solid rgba(255, 255, 255, 0.06) !important;
    border-radius: 6px !important;
    padding: 4px 8px !important;
    font-family: 'JetBrains Mono', monospace !important;
    font-weight: 700 !important;
    font-size: 10px !important;
    color: #e2e8f0 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    text-decoration: none !important;
}

.meta-link-badge i {
    font-size: 10.5px !important;
}

/* Thumbs Area directory */
.thumbs-container {
    background: #080c14 !important;
    padding: 12px !important;
    border-top: 1.5px solid rgba(255, 255, 255, 0.04) !important;
}

.thumb-item {
    height: 58px !important;
    background: #04070c !important;
    border: 1.5px solid rgba(255,255,255,0.03) !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    position: relative !important;
    cursor: pointer !important;
    opacity: 0.55 !important;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
}

.thumb-item.swiper-slide-thumb-active {
    opacity: 1 !important;
    border-color: <?php echo esc_attr($neon); ?> !important;
    box-shadow: 0 0 12px <?php echo esc_attr($neon); ?>44 !important;
}

.thumb-flex-box {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    padding: 6px 10px !important;
    height: 100% !important;
    position: relative !important;
    box-sizing: border-box !important;
}

.thumb-img-area {
    width: 48px !important;
    height: 38px !important;
    flex-shrink: 0 !important;
    border-radius: 6px !important;
    overflow: hidden !important;
    border: 1.5px solid rgba(255,255,255,0.05) !important;
}

.thumb-img-area img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

.thumb-text-area {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    min-width: 0 !important;
}

.thumb-title-text {
    font-size: 12px !important;
    font-weight: 700 !important;
    color: #f0f6fc !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    line-height: 1.3 !important;
}

.thumb-item.swiper-slide-thumb-active .thumb-title-text {
    color: <?php echo esc_attr($neon); ?> !important;
}

.thumb-meta-info {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    margin-top: 4px !important;
    font-size: 9.5px !important;
    color: #8b949e !important;
}

.thumb-author {
    color: <?php echo esc_attr($neon); ?> !important;
    font-weight: 700 !important;
    max-width: 60px !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
}

.thumb-stat {
    display: inline-flex !important;
    align-items: center !important;
    gap: 2.5px !important;
}

.thumb-stat i {
    font-size: 8.5px !important;
    color: <?php echo esc_attr($neon); ?> !important;
}

.thumb-progress-bg {
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 2.5px !important;
    background: rgba(255, 255, 255, 0.04) !important;
    z-index: 5 !important;
}

.thumb-progress-fill {
    height: 100% !important;
    width: 0% !important;
    box-shadow: 0 0 10px <?php echo esc_attr($neon); ?> !important;
}

/* MOBILE RESPONSIVE ADAPTATIONS */
@media (max-width: 991px) {
    .slider-card-mode {
        height: 380px !important;
    }
    .slider-horizontal-title {
        font-size: 20px !important;
    }
    .slider-right-content {
        padding: 24px !important;
    }
}

@media (max-width: 767px) {
    /* Stack overlay mode on mobile */
    .slider-card-mode {
        height: 330px !important;
        position: relative !important;
        flex-direction: column !important;
        border-radius: 12px !important;
        border: 1px solid rgba(0, 240, 255, 0.15) !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.8), inset 0 0 20px rgba(0, 240, 255, 0.05) !important;
    }
    
    .slider-left-thumb {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        z-index: 1 !important;
    }
    
    .slider-img-overlay-shader {
        background: linear-gradient(to top, #070b13 0%, rgba(7, 11, 19, 0.88) 55%, rgba(7, 11, 19, 0.2) 100%) !important;
    }
    
    .slider-right-content {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: auto !important;
        background: transparent !important;
        z-index: 3 !important;
        padding: 18px !important;
        justify-content: flex-end !important;
        box-sizing: border-box !important;
    }
    
    .cat-trending-row {
        margin-bottom: 10px !important;
        gap: 8px !important;
    }
    
    .cat-badge, .trending-badge {
        font-size: 9px !important;
        padding: 3.5px 10px !important;
        border-radius: 5px !important;
        box-shadow: 0 0 10px rgba(0, 240, 255, 0.25) !important;
    }
    
    .slider-horizontal-title {
        font-size: 16.5px !important;
        margin-bottom: 8px !important;
        line-height: 1.35 !important;
        font-weight: 800 !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.95) !important;
    }
    
    .slider-excerpt {
        display: none !important; /* Hide excerpt on mobile for clean aesthetic */
    }
    
    .rgb-divider-neon {
        margin-bottom: 14px !important;
        height: 1px !important;
        opacity: 0.8 !important;
    }
    
    .meta-wrapper {
        gap: 8px !important;
        justify-content: flex-start !important;
        flex-wrap: wrap !important;
    }
    
    .author-name {
        font-size: 11.5px !important;
        max-width: none !important; /* Allow author name to display fully */
        overflow: visible !important;
        text-overflow: clip !important;
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.8) !important;
    }
    
    .round-avatar-neon {
        width: 20px !important;
        height: 20px !important;
        border: 1.5px solid <?php echo $neon; ?> !important;
    }
    
    .meta-link-badge {
        padding: 3px 6px !important;
        font-size: 9px !important;
        background: rgba(13, 17, 23, 0.85) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
        backdrop-filter: blur(4px) !important;
    }
    
    /* Elegant thumb panel formatting for mobile */
    .thumbs-container {
        padding: 8px !important;
    }
    
    .thumb-item {
        height: 48px !important;
    }
    
    .thumb-flex-box {
        padding: 4px 6px !important;
        gap: 8px !important;
    }
    
    .thumb-img-area {
        width: 38px !important;
        height: 30px !important;
    }
    
    .thumb-title-text {
        font-size: 10px !important;
    }
    
    .thumb-meta-info {
        gap: 5px !important;
        margin-top: 2px !important;
        font-size: 8px !important;
    }
    
    .thumb-author {
        max-width: 45px !important;
    }
}

.hero-slider {
    padding: 0 !important;
    overflow: hidden;
    position: relative;
}

.hero-slider:not(.swiper-initialized) .swiper-wrapper {
    display: flex;
    flex-wrap: nowrap;
    flex-direction: row;
}

.hero-slider:not(.swiper-initialized) .swiper-slide {
    flex-shrink: 0;
    width: 100%;
    height: auto;
}

.hero-thumbs:not(.swiper-initialized) .swiper-wrapper {
    display: flex;
    flex-wrap: nowrap;
    flex-direction: row;
    overflow-x: auto;
}

.hero-thumbs:not(.swiper-initialized) .swiper-slide {
    flex-shrink: 0;
    width: auto;
}
</style>
