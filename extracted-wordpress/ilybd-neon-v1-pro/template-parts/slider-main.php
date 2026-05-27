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
    'orderby'        => ($source == 'popular') ? 'meta_value_num' : 'date',
    'order'          => 'DESC'
);

if ($source == 'popular') { $args['meta_key'] = 'post_views_count'; }

$query = new WP_Query($args);
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
            ?>
                <div class="swiper-slide hero-slide">
                    <article class="pro-post-card slider-card-mode">
                        
                        <!-- Left Side: Compact Thumbnail Image Area -->
                        <div class="slider-left-thumb">
                            <a href="<?php echo $post_link; ?>" class="slider-thumb-link">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                                <?php else : ?>
                                    <div class="no-thumb">ILYBD PRO</div>
                                <?php endif; ?>
                            </a>
                        </div>

                        <!-- Right Side: Full Text Cover Details -->
                        <div class="slider-right-content">
                            
                            <!-- Badges row: Category + Corner Trending Mark -->
                            <div class="cat-trending-row">
                                <span class="cat-badge" style="background: <?php echo $neon; ?>; box-shadow: 0 0 10px <?php echo $neon; ?>55;">
                                    <?php echo !empty($cats) ? esc_html($cats[0]->name) : 'Tech'; ?>
                                </span>
                                
                                <span class="trending-badge" style="border: 1px solid <?php echo $neon; ?>; color: <?php echo $neon; ?>; box-shadow: 0 0 8px <?php echo $neon; ?>44;">
                                    <i class="fa-solid fa-fire animate-pulseFast"></i> TRENDING
                                </span>
                            </div>

                            <!-- Post Title -->
                            <h2 class="post-title slider-horizontal-title">
                                <a href="<?php echo $post_link; ?>">
                                    <?php echo wp_trim_words(get_the_title(), 8, '...'); ?>
                                </a>
                            </h2>

                            <!-- Post Short One or Two lines description text as requested -->
                            <div class="slider-excerpt">
                                <?php 
                                    $excerpt = get_the_excerpt();
                                    if (empty($excerpt)) {
                                        $excerpt = get_the_content();
                                    }
                                    echo esc_html(wp_trim_words($excerpt, 22, '...')); 
                                ?>
                            </div>

                            <div class="rgb-divider"></div>

                            <!-- Author profile and statistics footer matching requested design -->
                            <div class="meta-footer">
                                <div class="meta-wrapper">
                                    <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="meta-link author-group">
                                        <?php echo get_avatar($author_id, 18, '', '', array('class' => 'round-avatar')); ?>
                                        <b class="author-name" style="color: <?php echo $neon; ?>;"><?php the_author(); ?></b>
                                    </a>

                                    <div class="stats-group">
                                        <div class="meta-link" title="Views">
                                            <i class="fa-regular fa-eye" style="color:<?php echo $neon; ?>;"></i>
                                            <span><?php echo $views; ?></span>
                                        </div>
                                        <a href="<?php echo $comment_lnk; ?>" class="meta-link" title="Comments">
                                            <i class="fa-regular fa-comment" style="color:<?php echo $neon; ?>;"></i>
                                            <span><?php echo get_comments_number(); ?></span>
                                        </a>
                                        <a href="<?php echo $post_link; ?>#ilybd-like-container" class="meta-link" title="Likes">
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
                $query = new WP_Query($args);
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
                                <span class="thumb-title-text"><?php echo wp_trim_words(get_the_title(), 5, '...'); ?></span>
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
/* Slider card and layout overrides */
.hero-slider-wrapper {
    max-width: 1100px;
    width: 100%;
    margin: 0 auto 20px;
    background: #0d1117;
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    border-radius: 12px;
    overflow: hidden;
    box-sizing: border-box;
}
.hero-slide {
    height: auto !important;
}

/* Horizontal card design to resemble landscape layout */
.slider-card-mode {
    border: none !important;
    background: linear-gradient(135deg, #6e00ff 0%, #ff4b2b 100%) !important;
    height: 200px !important; /* Beautiful height to prevent title/excerpt overlap */
    position: relative !important;
    overflow: hidden !important;
    display: flex !important;
    flex-direction: row !important; /* Left-to-right alignment */
    align-items: center !important;
    gap: 12px !important;
    padding: 10px !important;
    border-radius: 10px !important;
    box-sizing: border-box !important;
    box-shadow: 0 10px 20px rgba(0,0,0,0.3), inset 0 0 40px rgba(0,0,0,0.2) !important;
    transition: all 0.3s ease !important;
}
.slider-card-mode:hover {
    box-shadow: 0 12px 25px rgba(0,0,0,0.4), inset 0 0 50px rgba(0,0,0,0.3) !important;
    transform: translateY(-2px) !important;
}

/* Left side picture alignment style matching thumbs */
.slider-left-thumb {
    width: 50% !important; /* Exactly 50/50 split as requested */
    height: 100% !important;
    flex-shrink: 0 !important;
    border-radius: 8px !important;
    overflow: hidden !important;
    position: relative !important;
    border: 1.5px solid rgba(255, 255, 255, 0.15);
}
.slider-thumb-link {
    display: block !important;
    width: 100% !important;
    height: 100% !important;
}
.slider-left-thumb img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
}
.slider-card-mode:hover .slider-left-thumb img {
    transform: scale(1.06) !important;
}

/* Right side content detail list */
.slider-right-content {
    width: 50% !important; /* Exactly 50/50 split as requested */
    flex-shrink: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
    height: 100% !important;
    min-width: 0 !important;
    padding: 4px 6px 4px 4px !important;
    box-sizing: border-box !important;
}

/* Badges row: Category combined with Trending icon */
.cat-trending-row {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 8px !important;
    margin-bottom: 4px !important;
    flex-wrap: nowrap !important;
}
.cat-badge {
    display: inline-block !important;
    font-size: 9px !important;
    padding: 2.5px 7px !important;
    border-radius: 4px !important;
    font-weight: 800 !important;
    text-transform: uppercase !important;
    color: #000 !important;
    letter-spacing: 0.3px !important;
}
.trending-badge {
    font-size: 8.5px !important;
    font-weight: 800 !important;
    padding: 2.5px 7px !important;
    border-radius: 4px !important;
    background: rgba(0,0,0,0.6) !important;
    letter-spacing: 0.4px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 3px !important;
    text-transform: uppercase !important;
}
@keyframes pulseFast {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.1); }
}
.animate-pulseFast {
    animation: pulseFast 1.2s infinite ease-in-out;
}

/* Landscape Style Title configuration */
.slider-horizontal-title {
    font-size: 14px !important;
    font-weight: 700 !important;
    line-height: 1.35 !important;
    margin: 4px 0 !important;
    overflow: hidden !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5) !important;
}
.slider-horizontal-title a {
    color: #ffffff !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
}
.slider-card-mode:hover .slider-horizontal-title a {
    color: #ffffff !important;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.8) !important;
}

/* Custom Excerpt / 1-2 lines of content as requested */
.slider-excerpt {
    font-size: 11px !important;
    color: rgba(255, 255, 255, 0.9) !important;
    font-weight: 500 !important;
    line-height: 1.4 !important;
    margin-bottom: 6px !important;
    overflow: hidden !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.4) !important;
}

.hero-slider-wrapper .rgb-divider {
    height: 1px !important;
    background: rgba(255, 255, 255, 0.25) !important;
    margin: 4px 0 !important;
}

/* Footer details: Author, Stats inside the hero-slider container */
.hero-slider-wrapper .meta-footer {
    width: 100% !important;
}
.hero-slider-wrapper .meta-wrapper {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 6px !important;
    box-sizing: border-box !important;
}
.hero-slider-wrapper .author-group {
    display: flex !important;
    align-items: center !important;
    gap: 5px !important;
    text-decoration: none !important;
    min-width: 0 !important;
}
.hero-slider-wrapper .author-group .round-avatar {
    width: 16px !important;
    height: 16px !important;
    border-radius: 50% !important;
    border: 1.5px solid #ffffff !important;
    box-shadow: 0 0 5px rgba(255,255,255,0.5) !important;
    flex-shrink: 0 !important;
}
.hero-slider-wrapper .author-name {
    font-size: 10.5px !important;
    font-weight: 800 !important;
    color: #ffffff !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.4) !important;
    text-overflow: ellipsis !important;
}
.hero-slider-wrapper .stats-group {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    flex-shrink: 0 !important;
}
.hero-slider-wrapper .stats-group .meta-link {
    color: #ffffff !important;
    font-weight: 700 !important;
    font-size: 9.5px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 2.5px !important;
    text-decoration: none !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.4) !important;
}
.hero-slider-wrapper .stats-group .meta-link i {
    font-size: 9px !important;
    color: #ffffff !important;
}

/* Thumbs Layout & Mobile Safeguards */
.thumbs-container {
    background: rgba(13, 17, 23, 0.95) !important;
    padding: 8px !important;
    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
}
.thumb-item {
    height: 52px !important; /* Perfect height for dual text rows + image */
    background: #07090e !important;
    border: 1px solid rgba(255,255,255,0.05) !important;
    border-radius: 6px !important;
    overflow: hidden !important;
    position: relative !important;
    cursor: pointer !important;
    opacity: 0.6 !important;
    transition: all 0.2s ease !important;
}
.thumb-item.swiper-slide-thumb-active {
    opacity: 1 !important;
    border-color: <?php echo esc_attr($neon); ?> !important;
    box-shadow: 0 0 8px <?php echo esc_attr($neon); ?>55 !important;
}
.thumb-flex-box {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    padding: 4px 6px !important;
    height: 100% !important;
    position: relative !important;
    box-sizing: border-box !important;
}
.thumb-img-area {
    width: 44px !important; /* Elegant compact thumbnail style */
    height: 36px !important;
    flex-shrink: 0 !important;
    border-radius: 4px !important;
    overflow: hidden !important;
    border: 1px solid rgba(255,255,255,0.08) !important;
    display: block !important;
}
.thumb-img-area img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
.no-thumb-small {
    background: #222;
    color: #666;
    font-size: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}
.thumb-text-area {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    min-width: 0 !important;
}
.thumb-title-text {
    font-size: 10.5px !important;
    font-weight: 500 !important;
    color: #f0f6fc !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    line-height: 1.25 !important;
    display: block !important;
}
.thumb-item.swiper-slide-thumb-active .thumb-title-text {
    color: <?php echo esc_attr($neon); ?> !important;
}
.thumb-meta-info {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    margin-top: 3px !important;
    font-size: 8.5px !important;
    color: #c9d1d9 !important;
}
.thumb-author {
    color: <?php echo esc_attr($neon); ?> !important;
    font-weight: 600 !important;
    max-width: 55px !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
}
.thumb-stat {
    display: inline-flex !important;
    align-items: center !important;
    gap: 2px !important;
}
.thumb-stat i {
    font-size: 8px !important;
    color: <?php echo esc_attr($neon); ?> !important;
}

/* Thinner Progress loading bar as requested */
.thumb-progress-bg {
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 2px !important; /* Thinner Loading bar size as requested */
    background: rgba(255, 255, 255, 0.05) !important;
    z-index: 5 !important;
}
.thumb-progress-fill {
    height: 100% !important;
    width: 0% !important;
    box-shadow: 0 0 6px <?php echo esc_attr($neon); ?> !important;
}

/* Mobile responsive resets */
@media (max-width: 767px) {
    .slider-card-mode {
        height: 185px !important; /* Proper height to fit title, excerpt and meta on mobile split */
        gap: 8px !important;
        padding: 8px !important;
    }
    .slider-left-thumb {
        width: 50% !important; /* Preserved 50/50 layout as requested */
    }
    .slider-right-content {
        width: 50% !important; /* Preserved 50/50 layout as requested */
        padding: 2px !important;
    }
    .slider-excerpt {
        display: -webkit-box !important; /* Excerpt kept visible on mobile as requested */
        -webkit-line-clamp: 1 !important; /* Show 1 clean line on mobile to fit perfectly */
        font-size: 10px !important;
        margin-bottom: 2px !important;
    }
    .trending-badge {
        font-size: 7.5px !important;
        padding: 1.5px 4px !important;
    }
    .cat-badge {
        font-size: 8px !important;
        padding: 1.5px 5px !important;
    }
    .hero-slider-wrapper .author-name {
        max-width: 50px !important;
    }
}

@media (max-width: 991px) {
    .thumb-text-area {
        display: flex !important; /* Prevent display: none on smaller screens */
    }
    .thumb-img-area {
        width: 44px !important; /* Guarantee tiny size on mobile too */
    }
}

/* Pre-Swiper layout configurations */
.hero-slider {
    padding: 12px !important;
    overflow: hidden;
    position: relative;
    max-height: 480px;
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
@media (min-width: 768px) {
    .hero-slider:not(.swiper-initialized) .swiper-slide {
        width: calc(50% - 8px);
    }
}
@media (min-width: 1024px) {
    .hero-slider:not(.swiper-initialized) .swiper-slide {
        width: calc(33.333% - 11px);
    }
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
