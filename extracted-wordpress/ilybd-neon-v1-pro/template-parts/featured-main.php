<?php
/**
 * Cinematic Featured Showcase - Bento Grid 2040 Edition
 * Features asymmetrical bento grids, custom-colored glowing sapphire-violet architecture, and complete device responsiveness.
 */

$f_count = get_option('ilybd_featured_count', 4);
$f_source = get_option('featured_source', 'manual');
$neon = esc_attr(get_option('ilybd_main_color', '#00ff41'));

$f_args = [
    'posts_per_page' => $f_count,
    'post_status'    => 'publish'
];

if ($f_source === 'manual') {
    $f_ids = get_option('ilybd_featured_ids', '');
    if (!empty($f_ids)) {
        $f_args['post__in'] = array_map('intval', explode(',', $f_ids));
        $f_args['orderby'] = 'post__in';
    } else {
        $f_args['orderby'] = 'date';
        $f_args['order'] = 'DESC';
    }
} elseif ($f_source === 'views') {
    $f_args['meta_key'] = 'ilybd_post_views_count';
    $f_args['orderby'] = 'meta_value_num';
    $f_args['order'] = 'DESC';
} elseif ($f_source === 'likes') {
    $f_args['meta_key'] = '_likes';
    $f_args['orderby'] = 'meta_value_num';
    $f_args['order'] = 'DESC';
} elseif ($f_source === 'category') {
    $f_cat = get_option('featured_category', '');
    if (!empty($f_cat)) {
        $f_args['cat'] = intval($f_cat);
    }
    $f_args['orderby'] = 'date';
    $f_args['order'] = 'DESC';
} else {
    $f_args['orderby'] = 'date';
    $f_args['order'] = 'DESC';
}

$query = new WP_Query($f_args);

// Fallback if no posts returned
if (!$query->have_posts() && ($f_source === 'views' || $f_source === 'likes' || $f_source === 'manual')) {
    $fallback_args = [
        'posts_per_page' => $f_count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];
    $query = new WP_Query($fallback_args);
}

// Adaptive Backfilling Logic: only backfills to exactly 4 slots if featured source is of dynamic filter type
$posts_to_show = [];
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $posts_to_show[] = get_post();
    }
    wp_reset_postdata();
}

$count_fetched = count($posts_to_show);
$target_count = max(4, intval($f_count));

// Stop backfilling entirely for 'manual' selection source so other posts from bottom loops do not duplicate under featured posts area
if ($f_source !== 'manual' && $count_fetched > 0 && $count_fetched < $target_count) {
    $exclude_ids = array_map(function($p) { return $p->ID; }, $posts_to_show);
    $backfill_args = [
        'posts_per_page' => $target_count - $count_fetched,
        'post_status'    => 'publish',
        'post__not_in'   => $exclude_ids,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ];
    $backfetch = new WP_Query($backfill_args);
    if ($backfetch->have_posts()) {
        while ($backfetch->have_posts()) {
            $backfetch->the_post();
            $posts_to_show[] = get_post();
        }
        wp_reset_postdata();
    }
}

if (!empty($posts_to_show)) :
?>
<section class="featured-wrapper">
    <h2 class="section-head-featured" style="margin:0; padding:0; border:none; font-weight:normal;">
        <div class="featured-indicator">
            <span class="pulse-dot"></span>
            <span class="label">⭐ FEATURED SHOWCASE</span>
        </div>
        <span class="line-featured"></span>
    </h2>

    <?php if (count($posts_to_show) === 1) : 
        $single_post = $posts_to_show[0];
        setup_postdata($single_post);
        $f_link = get_permalink($single_post->ID);
        $f_author_id = $single_post->post_author;
        $f_views = get_post_meta($single_post->ID, 'ilybd_post_views_count', true) ?: '0';
        $f_likes = get_post_meta($single_post->ID, '_likes', true) ?: '0';
        $f_comments = get_comments_number($single_post->ID);
        $f_cats = get_the_category($single_post->ID);
        $f_cat_name = !empty($f_cats) ? esc_html($f_cats[0]->name) : 'Tech';
        
        // Calculate actual dynamic reading time
        $content = get_post_field('post_content', $single_post->ID);
        $word_count = mb_strlen(strip_tags($content), 'UTF-8');
        $r_time = ceil($word_count / 350);
        if ($r_time < 1) $r_time = 1;
    ?>
        <div class="featured-single-container">
            <article class="bento-card featured-single-card">
                <div class="bento-media">
                    <a href="<?php echo $f_link; ?>">
                        <?php if (has_post_thumbnail($single_post->ID)) : ?>
                            <?php echo get_the_post_thumbnail($single_post->ID, 'large', ['alt' => get_the_title($single_post->ID)]); ?>
                        <?php else : ?>
                            <div class="bento-no-thumb">ILYBD PRO</div>
                        <?php endif; ?>
                    </a>
                    <span class="bento-cat-badge"><?php echo $f_cat_name; ?></span>
                    <div class="bento-accent-pill"><i class="fa-solid fa-crown"></i> TOP FEATURE</div>
                </div>
                <div class="bento-info">
                    <h2 class="bento-title">
                        <a href="<?php echo $f_link; ?>">
                            <?php echo esc_html(wp_trim_words(get_the_title($single_post->ID), 13, '...')); ?>
                        </a>
                    </h2>
                    <p class="bento-excerpt">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt($single_post->ID), 22, '...')); ?>
                    </p>
                    
                    <div class="featured-glass-divider"></div>
                    
                    <div class="bento-footer">
                        <a href="<?php echo esc_url(get_author_posts_url($f_author_id)); ?>" class="bento-author">
                            <?php echo get_avatar($f_author_id, 24, '', '', array('class' => 'bento-avatar')); ?>
                            <span class="bento-author-name"><?php the_author_meta('display_name', $f_author_id); ?></span>
                        </a>
                        <div class="bento-stats">
                            <span class="bento-stat-badge"><i class="fa-regular fa-clock"></i> <?php echo $r_time; ?> Min</span>
                            <span class="bento-stat-badge"><i class="fa-regular fa-eye"></i> <?php echo $f_views; ?></span>
                            <span class="bento-stat-badge"><i class="fa-regular fa-heart"></i> <?php echo $f_likes; ?></span>
                            <span class="bento-stat-badge"><i class="fa-regular fa-comment"></i> <?php echo $f_comments; ?></span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Cyber Ecosystem Dashboard Widget Panel -->
            <div class="cyber-dashboard-widget">
                <div class="cyber-widget-glow-bar"></div>
                
                <div class="cyber-head">
                    <div class="cyber-title-row">
                        <span class="pulse-dot-cyan"></span>
                        <span class="cyber-panel-title"><i class="fa-solid fa-microchip text-cyan-glow"></i> IBD CYBER REALTIME</span>
                    </div>
                    <span class="cyber-status-text">ONLINE</span>
                </div>
                
                <!-- Dhaka Ticking Clock -->
                <div class="cyber-clock-box">
                    <div class="clock-display-row">
                        <div class="clock-icon-neon"><i class="fa-regular fa-clock"></i></div>
                        <div class="clock-time-vals" id="live-cyber-clock">00:00:00 AM</div>
                    </div>
                    <div class="clock-date-vals" id="live-cyber-date">Friday, 18 June 2026</div>
                </div>

                <!-- Ecosystem Diagnostic Stats -->
                <div class="cyber-diagnostics">
                    <div class="diag-item">
                        <span class="diag-icon-wrapper cyan-bg-glow"><i class="fa-solid fa-server"></i></span>
                        <div class="diag-meta-desc">
                            <span class="diag-title">HOST SYSTEM</span>
                            <span class="diag-value">CLOUD RUN CONTAINER</span>
                        </div>
                    </div>
                    <div class="diag-item">
                        <span class="diag-icon-wrapper violet-bg-glow"><i class="fa-solid fa-shield-halved"></i></span>
                        <div class="diag-meta-desc">
                            <span class="diag-title">COMMN CENTRAL FLOW</span>
                            <span class="diag-value">ACTIVE (SECURED SSL)</span>
                        </div>
                    </div>
                    <div class="diag-item">
                        <span class="diag-icon-wrapper emerald-bg-glow"><i class="fa-solid fa-circle-check"></i></span>
                        <div class="diag-meta-desc">
                            <span class="diag-title">GOOGLE ADSENSE SAFETY</span>
                            <span class="diag-value font-emerald">SAFE & AD-FRIENDLY ✔️</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Tech Tags to Drive Search Traffic -->
                <div class="cyber-tag-index">
                    <div class="tag-title-label"><i class="fa-solid fa-magnifying-glass"></i> QUICK SECURE ACCESS</div>
                    <div class="tag-capsules">
                        <a href="<?php echo home_url('/?s=Android'); ?>" class="tag-cap cap-cyan">#Android</a>
                        <a href="<?php echo home_url('/?s=WordPress'); ?>" class="tag-cap cap-violet">#WordPress</a>
                        <a href="<?php echo home_url('/?s=SEO'); ?>" class="tag-cap cap-gold">#SEO</a>
                        <a href="<?php echo home_url('/?s=Blogging'); ?>" class="tag-cap cap-emerald">#Blogging</a>
                    </div>
                </div>

                <!-- Eco-Notice greeting with pristine Bengali -->
                <div class="cyber-sys-notice">
                    <div class="notice-meta">
                        <span class="notice-sender"><i class="fa-solid fa-user-shield"></i> SYSTEM STATUS</span>
                        <p class="notice-text">আইবিডি সাইবার নেক্সট-জেন ইকোসিস্টেমে স্বাগতম! নিরাপদ জ্ঞান প্রবাহ ও আর্নিং থ্রেশহোল্ড সেশন এখানে সচল রয়েছে।</p>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            function initLiveDashboardClock() {
                var clockEl = document.getElementById('live-cyber-clock');
                var dateEl = document.getElementById('live-cyber-date');
                if (!clockEl || !dateEl) return;
                
                function tick() {
                    var now = new Date();
                    
                    // Format English Dhaka Time
                    var options = { timeZone: 'Asia/Dhaka', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
                    var timeString = now.toLocaleTimeString('en-US', options);
                    
                    var dateOptions = { timeZone: 'Asia/Dhaka', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    var dateString = now.toLocaleDateString('en-US', dateOptions);
                    
                    // Format Bengali Dhaka Time
                    var numbersBn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
                    var amPmBn = {'AM':'পূর্বাহ্ণ','PM':'অপরাহ্ণ'};
                    
                    var timeBn = timeString.replace(/[0-9]/g, function(w){ return numbersBn[w]; });
                    timeBn = timeBn.replace(/AM|PM/g, function(w){ return amPmBn[w] || w; });
                    
                    var dateBn = now.toLocaleDateString('bn-BD', { timeZone: 'Asia/Dhaka', weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    
                    clockEl.innerHTML = timeString + ' | ' + timeBn;
                    dateEl.innerHTML = dateString + ' • ' + dateBn;
                }
                
                tick();
                setInterval(tick, 1000);
            }
            initLiveDashboardClock();
        });
        </script>
    <?php else : ?>
        <div class="featured-bento-grid">
            <?php 
            $post_index = 0;
            global $post;
            foreach ($posts_to_show as $post) :
                setup_postdata($post);
                $post_index++;
                $f_link = get_permalink();
                $f_author_id = get_the_author_meta('ID');
                $f_views = get_post_meta(get_the_ID(), 'ilybd_post_views_count', true) ?: '0';
                $f_likes = get_post_meta(get_the_ID(), '_likes', true) ?: '0';
                $f_cats = get_the_category();
                $f_cat_name = !empty($f_cats) ? esc_html($f_cats[0]->name) : 'Tech';
                
                // Calculate actual dynamic reading time
                $content = get_post_field('post_content', get_the_ID());
                $word_count = mb_strlen(strip_tags($content), 'UTF-8');
                $r_time = ceil($word_count / 350);
                if ($r_time < 1) $r_time = 1;

                if ($post_index === 1) : 
                    // HERO BENTO CARD
                ?>
                    <article class="bento-card bento-hero">
                        <div class="bento-media">
                            <a href="<?php echo $f_link; ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                                <?php else : ?>
                                    <div class="bento-no-thumb">ILYBD PRO</div>
                                <?php endif; ?>
                            </a>
                            <span class="bento-cat-badge"><?php echo $f_cat_name; ?></span>
                            <div class="bento-accent-pill"><i class="fa-solid fa-crown"></i> TOP FEATURE</div>
                        </div>
                        <div class="bento-info">
                            <h2 class="bento-title">
                                <a href="<?php echo $f_link; ?>">
                                    <?php echo esc_html(wp_trim_words(get_the_title(), 13, '...')); ?>
                                </a>
                            </h2>
                            <p class="bento-excerpt">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 22, '...')); ?>
                            </p>
                            
                            <div class="featured-glass-divider"></div>
                            
                            <div class="bento-footer">
                                <a href="<?php echo esc_url(get_author_posts_url($f_author_id)); ?>" class="bento-author">
                                    <?php echo get_avatar($f_author_id, 24, '', '', array('class' => 'bento-avatar')); ?>
                                    <span class="bento-author-name"><?php the_author(); ?></span>
                                </a>
                                <div class="bento-stats">
                                    <span class="bento-stat-badge"><i class="fa-regular fa-clock"></i> <?php echo $r_time; ?> Min</span>
                                    <span class="bento-stat-badge"><i class="fa-regular fa-eye"></i> <?php echo $f_views; ?></span>
                                    <span class="bento-stat-badge"><i class="fa-regular fa-heart"></i> <?php echo $f_likes; ?></span>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php else : 
                    // COMPANION ROW/CARD
                ?>
                    <article class="bento-card bento-item">
                        <div class="bento-media">
                            <a href="<?php echo $f_link; ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                                <?php else : ?>
                                    <div class="bento-no-thumb">ILYBD PRO</div>
                                <?php endif; ?>
                            </a>
                            <span class="bento-cat-badge"><?php echo $f_cat_name; ?></span>
                        </div>
                        <div class="bento-info">
                            <h3 class="bento-title-small">
                                <a href="<?php echo $f_link; ?>">
                                    <?php echo esc_html(wp_trim_words(get_the_title(), 11, '...')); ?>
                                </a>
                            </h3>
                            
                            <div class="bento-footer">
                                <a href="<?php echo esc_url(get_author_posts_url($f_author_id)); ?>" class="bento-author">
                                    <?php echo get_avatar($f_author_id, 18, '', '', array('class' => 'bento-avatar')); ?>
                                    <span class="bento-author-name-small"><?php the_author(); ?></span>
                                </a>
                                <div class="bento-stats">
                                    <span class="bento-stat-badge-mini"><i class="fa-regular fa-eye"></i> <?php echo $f_views; ?></span>
                                    <span class="bento-stat-badge-mini"><i class="fa-regular fa-heart"></i> <?php echo $f_likes; ?></span>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    <?php endif; ?>
</section>

<style>
/* 2040 Cinematic Featured Bento Grid Styling */
.featured-wrapper {
    margin: 40px auto; 
    padding: 0 15px;
    max-width: 100%;
    box-sizing: border-box;
}

.section-head-featured { 
    display: flex; 
    align-items: center; 
    gap: 16px; 
    margin-bottom: 24px; 
}

.featured-indicator {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(189, 0, 255, 0.12);
    border: 1px solid rgba(189, 0, 255, 0.35);
    padding: 6px 14px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(189,0,255,0.15);
}

.section-head-featured .label { 
    color: #df80ff; 
    font-weight: 850; 
    font-size: 13.5px; 
    letter-spacing: 0.8px;
    text-transform: uppercase;
    font-family: 'Space Grotesk', sans-serif;
    text-shadow: 0 0 10px rgba(189,0,255,0.4);
}

.pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #bd00ff;
    box-shadow: 0 0 8px #bd00ff;
    animation: featuredPulse 1.6s infinite ease-in-out;
}

@keyframes featuredPulse {
    0%, 100% { transform: scale(1); opacity: 1; box-shadow: 0 0 8px #bd00ff; }
    50% { transform: scale(1.3); opacity: 0.6; box-shadow: 0 0 14px #bd00ff; }
}

.section-head-featured .line-featured { 
    flex: 1; 
    height: 1.5px; 
    background: linear-gradient(90deg, #bd00ff, rgba(189, 0, 255, 0.05)); 
}

/* Bento Grid Setup */
.featured-bento-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 20px;
}

/* Asymmetric Span on Widescreen */
.bento-hero {
    grid-column: span 2;
    grid-row: span 2;
    display: flex;
    flex-direction: column;
}

.bento-card {
    background: #081021 !important; /* Sapphire Deep blue, totally different from black latest-posts */
    border: 1px solid rgba(189, 0, 255, 0.2) !important; /* Elegant Neon Purple gradient glow border */
    border-radius: 16px !important;
    overflow: hidden !important;
    box-shadow: 0 12px 30px rgba(0,0,0,0.65), inset 0 0 20px rgba(189,0,255,0.06);
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
    display: flex;
    flex-direction: column;
}

.bento-card:hover {
    transform: translateY(-5px) !important;
    border-color: #bd00ff !important;
    box-shadow: 0 16px 35px rgba(189, 0, 255, 0.25), inset 0 0 30px rgba(189,0,255,0.1) !important;
}

/* Media layout */
.bento-media {
    position: relative;
    overflow: hidden;
    background: #040712;
}

/* Maintain distinct aspect ratios */
.bento-hero .bento-media {
    height: 280px;
}

.bento-item .bento-media {
    height: 160px;
}

.bento-media img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
}

.bento-card:hover .bento-media img {
    transform: scale(1.08) !important;
}

.bento-cat-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    background: rgba(8, 16, 33, 0.8);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border: 1px solid rgba(189, 0, 255, 0.4);
    color: #df80ff !important;
    font-size: 10px;
    font-weight: 850;
    padding: 3px 10px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bento-accent-pill {
    position: absolute;
    top: 14px;
    right: 14px;
    background: linear-gradient(135deg, #bd00ff 0%, #ff007c 100%) !important;
    color: #fff !important;
    font-size: 9.5px;
    font-weight: 900;
    padding: 4px 10px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 4px 10px rgba(189,0,255,0.4);
}

/* Info structure */
.bento-info {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.bento-item .bento-info {
    padding: 14px;
}

/* Title system */
.bento-title {
    font-size: 20px !important;
    font-weight: 900 !important;
    line-height: 1.4 !important;
    margin: 0 0 10px 0 !important;
    font-family: 'Space Grotesk', sans-serif !important;
}

.bento-title a, .bento-title-small a {
    color: #ffffff !important;
    text-decoration: none !important;
    transition: color 0.25s ease;
}

.bento-title a:hover, .bento-title-small a:hover {
    color: #df80ff !important;
    text-shadow: 0 0 8px rgba(189,0,255,0.4);
}

.bento-title-small {
    font-size: 14.5px !important;
    font-weight: 800 !important;
    line-height: 1.4 !important;
    margin: 0 0 10px 0 !important;
    overflow: hidden !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
}

.bento-excerpt {
    font-size: 13.5px !important;
    line-height: 1.55 !important;
    color: #94a3b8 !important;
    margin: 0 0 16px 0 !important;
    font-family: 'Hind Siliguri', sans-serif !important;
}

.featured-glass-divider {
    height: 1px;
    width: 100%;
    background: linear-gradient(90deg, transparent, rgba(189, 0, 255, 0.2) 20%, rgba(189, 0, 255, 0.2) 80%, transparent);
    margin-bottom: 16px;
}

/* Footer components */
.bento-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-top: auto;
}

.bento-author {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    min-width: 0;
}

.bento-avatar {
    border-radius: 50% !important;
    border: 1px solid rgba(189, 0, 255, 0.4) !important;
}

.bento-author-name {
    font-size: 11.5px;
    font-weight: 800;
    color: #cbd5e1;
    white-space: normal; /* wrap instead of truncate */
}

.bento-author-name-small {
    font-size: 10px;
    font-weight: 800;
    color: #94a3b8;
    white-space: normal; /* wrap instead of truncate */
}

.bento-stats {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.bento-stat-badge {
    background: rgba(255, 255, 255, 0.03) !important;
    border: 1px solid rgba(255, 255, 255, 0.06) !important;
    font-family: 'JetBrains Mono', monospace !important;
    font-size: 9px !important;
    font-weight: 700;
    color: #94a3b8 !important;
    padding: 3px 6px !important;
    border-radius: 4px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 3px;
}

.bento-stat-badge-mini {
    font-family: 'JetBrains Mono', monospace !important;
    font-size: 9px !important;
    font-weight: 700;
    color: #64748b;
    display: inline-flex !important;
    align-items: center !important;
    gap: 2.5px;
}

/* Single Featured Layout (62% Left, 35% Right) styling */
.featured-single-container {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    width: 100%;
    align-items: stretch;
}

.featured-single-card {
    flex: 1 1 60%;
    min-width: 320px;
    background: #081021 !important;
    border: 1.5px solid rgba(189, 0, 255, 0.25) !important;
    border-radius: 16px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.65), inset 0 0 20px rgba(189, 0, 255, 0.05);
}

.featured-single-card .bento-media {
    height: 280px;
}

.cyber-dashboard-widget {
    flex: 1 1 35%;
    min-width: 290px;
    background: linear-gradient(135deg, #070b13 0%, #0d1527 100%) !important;
    border: 1.5px solid rgba(0, 240, 255, 0.25) !important;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.65), inset 0 0 24px rgba(0, 240, 255, 0.05) !important;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.cyber-dashboard-widget:hover {
    border-color: #00f0ff !important;
    box-shadow: 0 16px 40px rgba(0, 240, 255, 0.2), inset 0 0 30px rgba(0, 240, 255, 0.08) !important;
}

/* Accent neon bar at the top of the widget */
.cyber-widget-glow-bar {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #00f0ff, #bd00ff);
}

.cyber-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    padding-bottom: 12px;
    margin-bottom: 12px;
}

.cyber-title-row {
    display: flex;
    align-items: center;
    gap: 8px;
}

.pulse-dot-cyan {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #00f0ff;
    box-shadow: 0 0 10px #00f0ff;
    animation: cyanPulse 1.8s infinite ease-in-out;
}

@keyframes cyanPulse {
    0%, 100% { transform: scale(1); opacity: 1; box-shadow: 0 0 8px #00f0ff; }
    50% { transform: scale(1.3); opacity: 0.5; box-shadow: 0 0 16px #00f0ff; }
}

.cyber-panel-title {
    font-size: 12.5px;
    font-weight: 850;
    font-family: 'Space Grotesk', sans-serif;
    color: #e2e8f0;
    letter-spacing: 0.5px;
}

.text-cyan-glow {
    color: #00f0ff !important;
    text-shadow: 0 0 8px rgba(0, 240, 255, 0.4);
}

.cyber-status-text {
    font-family: 'JetBrains Mono', monospace;
    font-size: 9px;
    font-weight: 800;
    background: rgba(0, 240, 255, 0.1);
    color: #00f0ff;
    border: 1px solid rgba(0, 240, 255, 0.3);
    padding: 2.5px 6px;
    border-radius: 4px;
}

/* Digital clock stylings */
.cyber-clock-box {
    background: rgba(4, 7, 18, 0.6) !important;
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 14px;
    text-align: center;
}

.clock-display-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 4px;
}

.clock-icon-neon {
    font-size: 14px;
    color: #00f0ff;
    animation: rotateHourglass 4s infinite linear;
}

@keyframes rotateHourglass {
    0%, 90% { transform: rotate(0deg); }
    100% { transform: rotate(180deg); }
}

.clock-time-vals {
    font-family: 'JetBrains Mono', monospace;
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 0 0 10px rgba(0, 240, 255, 0.4);
    letter-spacing: 0.5px;
}

.clock-date-vals {
    font-size: 10px;
    color: #94a3b8;
    font-weight: 600;
}

/* System diagnostics indicators row */
.cyber-diagnostics {
    display: flex;
    flex-direction: column;
    gap: 8.5px;
    margin-bottom: 14px;
}

.diag-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.04);
    padding: 8px 12px;
    border-radius: 10px;
}

.diag-icon-wrapper {
    width: 25px;
    height: 25px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
}

.cyan-bg-glow {
    background: rgba(0, 240, 255, 0.1);
    color: #00f0ff;
    border: 1px solid rgba(0, 240, 255, 0.2);
}

.violet-bg-glow {
    background: rgba(189, 0, 255, 0.1);
    color: #df80ff;
    border: 1px solid rgba(189, 0, 255, 0.2);
}

.emerald-bg-glow {
    background: rgba(16, 185, 129, 0.1);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.diag-meta-desc {
    display: flex;
    flex-direction: column;
}

.diag-title {
    font-size: 8.5px;
    color: #64748b;
    font-weight: 800;
    letter-spacing: 0.5px;
    font-family: 'Space Grotesk', sans-serif;
}

.diag-value {
    font-size: 11px;
    font-weight: 800;
    color: #cbd5e1;
    font-family: 'JetBrains Mono', monospace;
}

.font-emerald {
    color: #34d399 !important;
}

/* Cyber Tag Capsules */
.cyber-tag-index {
    margin-bottom: 14px;
}

.tag-title-label {
    font-size: 9.5px;
    color: #94a3b8;
    font-weight: 850;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
    font-family: 'Space Grotesk', sans-serif;
}

.tag-capsules {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.tag-cap {
    font-family: 'JetBrains Mono', monospace;
    font-size: 10px;
    font-weight: 700;
    padding: 3.5px 8px;
    border-radius: 6px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.cap-cyan { background: rgba(0, 240, 255, 0.05); border: 1px solid rgba(0, 240, 255, 0.15); color: #00f0ff !important; }
.cap-cyan:hover { background: rgba(0, 240, 255, 0.15); border-color: #00f0ff; box-shadow: 0 0 8px rgba(0,240,255,0.3); }

.cap-violet { background: rgba(189, 0, 255, 0.05); border: 1px solid rgba(189, 0, 255, 0.15); color: #df80ff !important; }
.cap-violet:hover { background: rgba(189, 0, 255, 0.15); border-color: #bd00ff; box-shadow: 0 0 8px rgba(189,0,255,0.3); }

.cap-gold { background: rgba(251, 191, 36, 0.05); border: 1px solid rgba(251, 191, 36, 0.15); color: #fbbf24 !important; }
.cap-gold:hover { background: rgba(251, 191, 36, 0.15); border-color: #fbbf24; box-shadow: 0 0 8px rgba(251,191,36,0.3); }

.cap-emerald { background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.15); color: #34d399 !important; }
.cap-emerald:hover { background: rgba(16, 185, 129, 0.15); border-color: #34d399; box-shadow: 0 0 8px rgba(16,185,129,0.3); }

/* Greeting custom box */
.cyber-sys-notice {
    background: rgba(18, 24, 38, 0.5) !important;
    border-left: 3px solid #00f0ff;
    border-radius: 0 10px 10px 0;
    padding: 10px 12px;
}

.notice-sender {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 8.5px;
    color: #00f0ff;
    font-weight: 850;
    margin-bottom: 3.5px;
    letter-spacing: 0.5px;
}

.notice-text {
    font-size: 11px !important;
    line-height: 1.45 !important;
    color: #94a3b8 !important;
    margin: 0 !important;
    font-family: 'Hind Siliguri', sans-serif !important;
}

/* RESPONSIVE DESIGN BREAKPOINTS */
@media (max-width: 1024px) {
    .featured-bento-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .bento-hero {
        grid-column: span 2;
        grid-row: span 1;
    }
}

@media (max-width: 900px) {
    .featured-single-card {
        flex: 1 1 100%;
    }
    .cyber-dashboard-widget {
        flex: 1 1 100%;
    }
}

@media (max-width: 768px) {
    .featured-single-card .bento-media {
        height: 185px;
    }
    .featured-bento-grid {
        grid-template-columns: 1fr;
        grid-gap: 16px;
    }
    .bento-hero {
        grid-column: span 1;
    }
    .bento-hero .bento-media {
        height: 180px;
    }
    .bento-title {
        font-size: 16px !important;
    }
    .bento-excerpt {
        font-size: 12.5px !important;
    }
    .bento-item .bento-media {
        height: 140px;
    }
}
</style>
<?php endif; ?>
