<?php
/**
 * Single Story & Novel Template (2040 Cyber Library Edition)
 * Theme: ilybd-neon-v1-pro
 */
get_header(); 

$post_type = 'ilybd_story';
$cat_taxonomy = 'story_category';
$tag_taxonomy = 'story_tag';
?>

<!-- Reading Progress Bar -->
<div id="cyber-story-reading-progress" style="position: fixed; top: 0; left: 0; width: 0%; height: 4px; background: linear-gradient(90deg, #9d4edd, #00f0ff); z-index: 999999; box-shadow: 0 0 10px rgba(157, 78, 221, 0.8);"></div>

<div class="ilybd-layout story-single-wrapper" style="background: #070b13; color: #c9d1d9; min-height: 100vh; padding: 40px 15px 80px; font-family: 'Inter', sans-serif;">
    <div style="max-width: 900px; margin: 0 auto; width: 100%;">

        <?php if (have_posts()) : while (have_posts()) : the_post(); 
            $post_id = get_the_ID();
            $author_id = get_the_author_meta('ID');
            $author_name = get_the_author_meta('display_name');
            $author_avatar = get_avatar($author_id, 54);
            
            // Get category/genres
            $categories = wp_get_post_terms($post_id, $cat_taxonomy);
            $cat_name = !empty($categories) ? $categories[0]->name : 'Cyber Stories';
            $cat_slug = !empty($categories) ? $categories[0]->slug : 'story';
            $cat_link = !empty($categories) ? get_term_link($categories[0]) : home_url('/');
            
            // Views count
            $views = get_post_meta($post_id, 'ilybd_post_views_count', true) ?: '0';
            update_post_meta($post_id, 'ilybd_post_views_count', intval($views) + 1);
        ?>

            <!-- 1. BREADCRUMB / NAVIGATION -->
            <nav aria-label="Breadcrumb" style="margin-bottom: 25px; font-size: 13px; font-family: monospace; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
                    <span style="color: #475569; margin: 0 8px;">/</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_story')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">STORY ARCHIVE</a>
                    <span style="color: #475569; margin: 0 8px;">/</span>
                    <a href="<?php echo esc_url($cat_link); ?>" style="color: #9d4edd; text-decoration: none; font-weight: bold;"><?php echo esc_html(strtoupper($cat_name)); ?></a>
                </div>
                <span style="color: #64748b; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-clock" style="color: #9d4edd;"></i> ৫ মিনিট পড়া • <i class="fa-solid fa-eye" style="color: #9d4edd;"></i> <?php echo esc_html($views); ?> বার পঠিত
                </span>
            </nav>

            <!-- 2. GOOGLE ADSENSE PLACEHOLDER (TOP AREA) -->
            <?php if (get_option('ily_enable_adsense_placeholders', 0) == 1) : ?>
            <div class="adsense-safe-container" style="margin-bottom: 30px; min-height: 90px; background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 11px; font-family: monospace; padding: 10px;">
                <span>[ ADVERTISING CONTAINER - GOOGLE ADSENSE POLICY COMPLIANT ]</span>
            </div>
            <?php endif; ?>

            <!-- 3. MAIN STORY CARD -->
            <article class="story-main-card" style="background: #0d1527; border: 1.5px solid rgba(157, 78, 221, 0.2); border-radius: 18px; padding: 40px; box-shadow: 0 15px 45px rgba(0,0,0,0.55); position: relative; overflow: hidden; margin-bottom: 40px;">
                <div class="card-glow-element" style="position: absolute; top: -100px; right: -100px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(157,78,221,0.08) 0%, transparent 70%); pointer-events: none;"></div>

                <!-- Category badge & metadata -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <span style="background: rgba(157, 78, 221, 0.15); color: #c77dff; border: 1px solid rgba(157, 78, 221, 0.3); font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                        📚 <?php echo esc_html($cat_name); ?>
                    </span>
                    <span style="color: #64748b; font-size: 12px; font-family: monospace;">
                        ID: STORY-<?php echo esc_html($post_id); ?>
                    </span>
                </div>

                <!-- Story Title -->
                <h1 style="color: #fff; font-size: clamp(24px, 5.5vw, 36px); line-height: 1.35; font-weight: 800; margin-top: 0; margin-bottom: 25px; text-shadow: 0 0 15px rgba(157,78,221,0.2); text-align: left; border-left: 4px solid #9d4edd; padding-left: 15px;">
                    <?php the_title(); ?>
                </h1>

                <!-- Optional Featured Image with Premium Category Fallback -->
                <div style="margin: 25px auto 35px; width: 100%; border-radius: 12px; overflow: hidden; border: 1.5px solid rgba(255,255,255,0.06); position: relative; height: 380px;">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', ['style' => 'width:100%; height:100%; object-fit:cover; display:block;']); ?>
                    <?php else : 
                        // Beautiful category fallback images (cyberpunk styled, premium, royalty-free)
                        $cover_images = [
                            'romantic-love'       => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?auto=format&fit=crop&w=1200&q=80',
                            'romantic-stories'    => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?auto=format&fit=crop&w=1200&q=80',
                            'cyber-thriller'      => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1200&q=80',
                            'cyber-thrillers'     => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1200&q=80',
                            'sci-fi'              => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80',
                            'horror-mystery'      => 'https://images.unsplash.com/photo-1509248961158-e54f6934749c?auto=format&fit=crop&w=1200&q=80',
                            'ghost-mysteries'     => 'https://images.unsplash.com/photo-1509248961158-e54f6934749c?auto=format&fit=crop&w=1200&q=80',
                            'inspirational-story' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                            'moral-legends'       => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80'
                        ];
                        $fallback_url = isset($cover_images[$cat_slug]) ? $cover_images[$cat_slug] : 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80';
                        ?>
                        <img src="<?php echo esc_url($fallback_url); ?>" style="width:100%; height:100%; object-fit:cover; display:block;" alt="<?php the_title_attribute(); ?>" />
                    <?php endif; ?>
                    <!-- Glassmorphic premium tag overlay -->
                    <div style="position: absolute; bottom: 0; left: 0; width: 100%; background: linear-gradient(to top, rgba(7,11,19,0.9) 0%, rgba(7,11,19,0) 100%); padding: 30px 20px 15px; pointer-events: none;">
                        <span style="background: rgba(157, 78, 221, 0.85); color: #fff; font-size: 11px; font-weight: bold; font-family: 'JetBrains Mono', monospace; padding: 4px 10px; border-radius: 4px; text-transform: uppercase; border: 1px solid rgba(255,255,255,0.25); box-shadow: 0 0 10px rgba(157, 78, 221, 0.5);">PREMIUM ORIGINAL LITERATURE</span>
                    </div>
                </div>

                <!-- Story Text Content Body (Majestic Readable Typography) -->
                <div class="story-article-body" id="storyMainBody" style="font-size: 19px; line-height: 1.95; color: #cbd5e0; font-family: 'Segoe UI', system-ui, sans-serif; text-align: justify; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 30px; margin-bottom: 30px;">
                    <?php the_content(); ?>
                </div>

                <!-- DYNAMIC AI SEO COMPLIANCE SCORECARD -->
                <?php if (function_exists('ilybd_render_ai_seo_compliance_scorecard')) {
                    ilybd_render_ai_seo_compliance_scorecard($post_id);
                } ?>

                <!-- ELITE USER ENGAGEMENT PANEL (LIKES, SHARES, RATINGS, AND VIEWS) -->
                <div class="elite-engagement-panel" style="background: rgba(13, 21, 39, 0.6); border: 1.5px solid rgba(157, 78, 221, 0.25); border-radius: 16px; padding: 25px; margin-bottom: 35px; box-shadow: 0 8px 32px rgba(0,0,0,0.4);">
                    <span style="font-size: 11px; color: #c77dff; font-family: monospace; text-transform: uppercase; letter-spacing: 1px; display: block; text-align: center; margin-bottom: 20px;">🛡️ CORE ENGAGEMENT & REPUTATION ENGINE</span>
                    
                    <!-- Stats Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 15px; margin-bottom: 25px; text-align: center;">
                        <div style="background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255,255,255,0.03); padding: 15px; border-radius: 12px;">
                            <span style="color: #64748b; font-size: 11px; display: block; margin-bottom: 5px; font-family: monospace;">TOTAL VIEWS</span>
                            <strong style="color: #fff; font-size: 18px; font-family: monospace;"><i class="fa-solid fa-eye" style="color: #c77dff; margin-right: 5px;"></i> <?php echo esc_html($views); ?></strong>
                        </div>
                        <div style="background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255,255,255,0.03); padding: 15px; border-radius: 12px;">
                            <span style="color: #64748b; font-size: 11px; display: block; margin-bottom: 5px; font-family: monospace;">COMMUNITY LIKES</span>
                            <strong style="color: #fff; font-size: 18px; font-family: monospace;" id="like-counter-val"><i class="fa-solid fa-heart" style="color: #ff3e3e; margin-right: 5px;"></i> <span class="like-count-num"><?php echo esc_html(get_post_meta($post_id, '_likes', true) ?: '0'); ?></span></strong>
                        </div>
                        <div style="background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255,255,255,0.03); padding: 15px; border-radius: 12px;">
                            <span style="color: #64748b; font-size: 11px; display: block; margin-bottom: 5px; font-family: monospace;">AVERAGE RATING</span>
                            <strong style="color: #fff; font-size: 18px; font-family: monospace;" id="rating-average-val"><i class="fa-solid fa-star" style="color: #ffb703; margin-right: 5px;"></i> <span class="rating-score-num"><?php echo esc_html(get_post_meta($post_id, '_ilybd_rating_score_' . $post_id, true) ?: '4.8'); ?></span>/৫</strong>
                        </div>
                    </div>

                    <!-- Interactions Row -->
                    <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 25px;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                            <!-- AJAX Like Button -->
                            <button id="ilybd-like-btn" onclick="ilybdLikePost(<?php echo $post_id; ?>, this)" style="background: rgba(255, 62, 62, 0.05); color: #ff3e3e; border: 1.5px solid rgba(255, 62, 62, 0.3); font-weight: bold; font-size: 14px; padding: 12px 20px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.25s;">
                                <i class="fa-regular fa-heart"></i> গল্পটি ভালো লেগেছে
                            </button>
                            <!-- Copy Post -->
                            <button onclick="copyStoryContents(this)" style="background: rgba(157, 78, 221, 0.05); color: #c77dff; border: 1.5px solid rgba(157, 78, 221, 0.3); font-weight: bold; font-size: 14px; padding: 12px 20px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.25s;">
                                <i class="fa-regular fa-copy"></i> সম্পূর্ণ গল্প কপি করুন
                            </button>
                        </div>
                    </div>

                    <!-- Monospace Interactive Rating Subpanel -->
                    <div style="background: rgba(7, 11, 19, 0.5); border: 1px solid rgba(255,255,255,0.04); border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 25px;">
                        <span style="font-size: 13px; color: #fff; display: block; margin-bottom: 8px; font-weight: bold;">গল্পটি আপনার কেমন লেগেছে? রেটিং দিন:</span>
                        <div class="interactive-star-rating" style="display: inline-flex; gap: 8px; font-size: 24px; direction: ltr; cursor: pointer;">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fa-regular fa-star star-rating-item" data-val="<?php echo $i; ?>" onclick="submitIlybdRating(<?php echo $post_id; ?>, <?php echo $i; ?>, this)" style="color: #ffb703; transition: transform 0.15s;"></i>
                            <?php endfor; ?>
                        </div>
                        <span id="rating-status-text" style="display: block; font-size: 11px; color: #8b949e; margin-top: 8px; font-family: monospace;">মতামত জানাতে উপরে স্টার সিলেক্ট করুন (Rating is saved permanently)</span>
                    </div>

                    <!-- Social Media Sharing Hub -->
                    <div>
                        <span style="font-size: 12px; color: #64748b; font-family: monospace; display: block; text-align: center; margin-bottom: 12px; text-transform: uppercase;">⚡ বন্ধুদের সাথে সোশ্যাল মিডিয়ায় শেয়ার করুন (XP/পয়েন্ট পাবেন)</span>
                        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">
                            <a href="#" onclick="triggerIlybdShare(<?php echo $post_id; ?>, 'whatsapp')" style="background: #25d366; color: #fff; font-size: 13px; font-weight: bold; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                            <a href="#" onclick="triggerIlybdShare(<?php echo $post_id; ?>, 'facebook')" style="background: #1877f2; color: #fff; font-size: 13px; font-weight: bold; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;"><i class="fa-brands fa-facebook"></i> Facebook</a>
                            <a href="#" onclick="triggerIlybdShare(<?php echo $post_id; ?>, 'messenger')" style="background: #0084ff; color: #fff; font-size: 13px; font-weight: bold; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;"><i class="fa-solid fa-message"></i> Messenger</a>
                            <a href="#" onclick="triggerIlybdShare(<?php echo $post_id; ?>, 'telegram')" style="background: #0088cc; color: #fff; font-size: 13px; font-weight: bold; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;"><i class="fa-brands fa-telegram"></i> Telegram</a>
                        </div>
                    </div>
                </div>

                <!-- DETAILED AUTHOR BIO PANEL (EEAT COMPLIANT) -->
                <div class="story-author-eeat-card" style="background: rgba(13, 21, 39, 0.55); border: 1px solid rgba(157, 78, 221, 0.15); border-radius: 14px; padding: 22px; display: flex; align-items: center; gap: 18px; text-align: left; flex-wrap: wrap;">
                    <div style="border-radius: 50%; overflow: hidden; border: 2.5px solid #9d4edd; width: 54px; height: 54px; flex-shrink: 0;">
                        <?php echo $author_avatar; ?>
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <span style="font-size: 10.5px; text-transform: uppercase; color: #a29bfe; font-weight: bold; display: block; margin-bottom: 2px; font-family: monospace;">✍️ CYBER LITERARY WRITER</span>
                        <strong style="color: #fff; font-size: 16px; display: block;"><?php echo esc_html($author_name); ?></strong>
                        <span style="font-size: 12.5px; color: #8b949e; display: block; margin-top: 3px; line-height: 1.4;">
                            পাবলিশের তারিখ: <?php echo get_the_date(); ?> • রিভিশন ও আপডেট: <?php echo get_the_modified_date(); ?> <br>
                            🛡️ <span style="color: #00ff41; font-weight: bold;">ফ্যাক্ট চেকড এবং সার্টিফাইড কন্টেন্ট</span> (I Love You BD Editorial Board)
                        </span>
                    </div>
                </div>

                <!-- SEO TAGS SECTION (MINIMUM 10 HIGH VALUE TAGS) -->
                <div class="seo-tags-panel" style="margin-top: 35px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 25px;">
                    <h3 style="font-size: 12px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-tags" style="color: #9d4edd;"></i> SEO KEYWORDS & STORY META TAGS
                    </h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        <?php 
                        // Generate at least 10 high-value dynamic tags
                        $post_tags = get_the_terms($post_id, $tag_taxonomy);
                        $tags_list = [];
                        if (!is_wp_error($post_tags) && !empty($post_tags)) {
                            foreach ($post_tags as $t) {
                                $tags_list[] = $t->name;
                            }
                        }
                        if (count($tags_list) < 10) {
                            $fallback_tags = [
                                'বাংলা নতুন গল্প', 'সাইবার থ্রিলার উপন্যাস', 'রোমান্টিক প্রেমের গল্প', 
                                'ভৌতিক রহস্য কাহিনী', 'শিক্ষণীয় ছোটগল্প', 'জনপ্রিয় বাংলা উপন্যাস', 
                                'এআই স্টোরি সেলফ', 'অনলাইন লাইব্রেরি বাংলা', 'সেরা গল্প সমগ্র', 
                                'Bangla Cyber Stories', 'Bengali Novels 2040', 'Interactive Books'
                            ];
                            $title_words = explode(' ', strip_tags(get_the_title()));
                            foreach ($title_words as $word) {
                                $word = trim(preg_replace('/[^\p{L}\p{N}\s]/u', '', $word));
                                if (mb_strlen($word) > 3 && !in_array($word, $tags_list)) {
                                    $tags_list[] = $word;
                                }
                            }
                            foreach ($fallback_tags as $ft) {
                                if (!in_array($ft, $tags_list)) {
                                    $tags_list[] = $ft;
                                }
                                if (count($tags_list) >= 12) {
                                    break;
                                }
                            }
                        }
                        foreach ($tags_list as $tag_item) :
                        ?>
                            <span class="seo-tag-pill" style="background: rgba(13, 21, 39, 0.8); border: 1px solid rgba(157, 78, 221, 0.15); color: #8b949e; font-size: 11.5px; padding: 6px 12px; border-radius: 8px; font-weight: 500; font-family: sans-serif; cursor: default; transition: all 0.2s;">
                                # <?php echo esc_html($tag_item); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </article>

            <!-- 4. GOOGLE ADSENSE PLACEHOLDER (MIDDLE ZONE) -->
            <?php if (get_option('ily_enable_adsense_placeholders', 0) == 1) : ?>
            <div class="adsense-safe-container" style="margin-bottom: 40px; min-height: 90px; background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 11px; font-family: monospace; padding: 10px;">
                <span>[ SPONSORED AD CONSOLE - ADSENSE SECURED ZONE ]</span>
            </div>
            <?php endif; ?>

            <!-- 5. CATEGORIES BROWSER (সহজে অন্য গল্প ব্রাউজ করুন) -->
            <section aria-label="Explore Categories" style="margin-bottom: 40px; background: #0d1527; border: 1.5px solid rgba(255,255,255,0.04); border-radius: 16px; padding: 25px;">
                <h2 style="font-size: 13px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">STORY CATEGORIES (গল্পের ধরণ সমূহ)</h2>
                <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none;">
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_story')); ?>" class="category-scroller-btn">
                        <i class="fa-solid fa-book-open"></i> সব গল্প
                    </a>
                    <?php 
                    $all_terms = get_terms(['taxonomy' => $cat_taxonomy, 'hide_empty' => false]);
                    if (!is_wp_error($all_terms) && !empty($all_terms)) :
                        foreach ($all_terms as $term) :
                            $is_current = ($cat_slug === $term->slug);
                            ?>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="category-scroller-btn" style="<?php echo $is_current ? 'border-color: #9d4edd; color: #c77dff; background: rgba(157, 78, 221, 0.1);' : ''; ?>">
                                <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                            </a>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </section>

            <!-- 6. RECOMMENDED RELATED STORIES (মিনিমাম ৩ টি রেকমেন্ডেট) -->
            <section class="story-related-recommendations" style="margin-bottom: 40px;">
                <h3 style="font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px; text-align: left;">
                    <i class="fa-solid fa-cubes-stacked" style="color: #9d4edd;"></i> আরও গল্প পড়ুন (Recommended Stories)
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px;">
                    <?php 
                    $related_query = new WP_Query([
                        'post_type'      => $post_type,
                        'posts_per_page' => 3,
                        'post__not_in'   => [$post_id],
                        'tax_query'      => [
                            [
                                'taxonomy' => $cat_taxonomy,
                                'field'    => 'slug',
                                'terms'    => $cat_slug,
                            ]
                        ]
                    ]);

                    if (!$related_query->have_posts()) {
                        $related_query = new WP_Query([
                            'post_type'      => $post_type,
                            'posts_per_page' => 3,
                            'post__not_in'   => [$post_id]
                        ]);
                    }

                    if ($related_query->have_posts()) : while ($related_query->have_posts()) : $related_query->the_post();
                        $rel_id = get_the_ID();
                        $rel_content_plain = strip_tags(get_the_content());
                        $rel_excerpt = mb_strimwidth(trim(preg_replace('/\s+/', ' ', $rel_content_plain)), 0, 110, '...');
                        if (empty($rel_excerpt)) {
                            $rel_excerpt = get_the_title();
                        }
                    ?>
                        <article class="story-recommend-card" style="background: #0d1527; border: 1.5px solid rgba(255, 255, 255, 0.04); border-radius: 12px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s;">
                            <style>
                                .story-recommend-card:hover {
                                    border-color: rgba(157, 78, 221, 0.25);
                                    transform: translateY(-2px);
                                }
                            </style>
                            <div>
                                <span style="background: rgba(157, 78, 221, 0.08); color: #c77dff; font-size: 10px; font-weight: bold; padding: 3px 8px; border-radius: 4px; display: inline-block; margin-bottom: 12px; border: 1px solid rgba(157, 78, 221, 0.15);">
                                    <?php echo esc_html($cat_name); ?>
                                </span>
                                <h4 style="font-size: 14.5px; font-weight: bold; color: #fff; margin: 0 0 10px 0; line-height: 1.4;">
                                    <a href="<?php the_permalink(); ?>" style="color: #fff; text-decoration: none; transition: color 0.2s;">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                                <p style="font-size: 12.5px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">
                                    <?php echo esc_html($rel_excerpt); ?>
                                </p>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" style="display: flex; align-items: center; justify-content: center; background: rgba(157, 78, 221, 0.05); border: 1px solid rgba(157, 78, 221, 0.15); color: #c77dff; font-weight: bold; font-size: 12px; padding: 8px 15px; border-radius: 6px; text-decoration: none; transition: 0.2s; text-transform: uppercase;">
                                গল্পটি পড়ুন <i class="fa-solid fa-chevron-right" style="margin-left: 5px; font-size: 10px;"></i>
                            </a>
                        </article>
                    <?php 
                    endwhile; wp_reset_postdata(); else : 
                    ?>
                        <div style="grid-column: 1 / -1; text-align: center; padding: 30px; background: #0d1527; border-radius: 12px; border: 1px dashed rgba(255,255,255,0.05);">
                            <p style="color: #64748b; font-size: 13.5px; margin: 0;">অন্য কোনো রেকমেন্ডেট রোমাঞ্চকর গল্প পাওয়া যায়নি।</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- 7. COMMENTS & DISCUSSION AREA -->
            <section class="story-discussion-area" style="background: #0d1117; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); margin-bottom: 40px;">
                <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-top: 0; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 12px;">
                    <i class="fa-solid fa-feather-pointed" style="color: #9d4edd;"></i> 
                    গল্পের প্রতি প্রতিক্রিয়া ও কমেন্টস (<?php echo esc_html(get_comments_number()); ?>)
                </h3>
                <?php comments_template(); ?>
            </section>

        <?php endwhile; endif; ?>

    </div>
</div>

<!-- SCRIPTS FOR STORY PAGE -->
<script>
// AJAX Love/Like system
function ilybdLikePost(postId, btn) {
    if (btn.classList.contains('liked')) return;
    
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'ilybd_handle_like',
            post_id: postId
        },
        success: function(response) {
            var likeNum = parseInt(response);
            if (!isNaN(likeNum)) {
                var countEls = document.querySelectorAll('.like-count-num');
                countEls.forEach(function(el) { el.innerText = likeNum; });
                btn.innerHTML = '<i class="fa-solid fa-heart" style="color: #ff3e3e;"></i> পছন্দ হয়েছে!';
                btn.classList.add('liked');
                btn.style.background = 'rgba(255, 62, 62, 0.1)';
                btn.style.color = '#ff3e3e';
                btn.style.borderColor = 'rgba(255, 62, 62, 0.3)';
                
                // Save locally to prevent multi-clicks
                localStorage.setItem('ilybd_liked_' + postId, 'true');
            }
        }
    });
}

// AJAX Rating system
function submitIlybdRating(postId, ratingValue, starEl) {
    if (localStorage.getItem('ilybd_rated_' + postId)) {
        var statusText = document.getElementById('rating-status-text');
        if (statusText) statusText.innerHTML = '❌ আপনি ইতিমধ্যে রেটিং দিয়েছেন! ধন্যবাদ।';
        return;
    }
    
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'ilybd_handle_rating',
            post_id: postId,
            rating: ratingValue
        },
        success: function(response) {
            if (response.success) {
                var data = response.data;
                var scoreEls = document.querySelectorAll('.rating-score-num');
                scoreEls.forEach(function(el) { el.innerText = data.rating; });
                
                // Highlight stars
                highlightStarRating(ratingValue);
                
                var statusText = document.getElementById('rating-status-text');
                if (statusText) statusText.innerHTML = '🟢 ধন্যবাদ! আপনার ' + ratingValue + '★ রেটিং সফলভাবে সংরক্ষিত হয়েছে।';
                
                // Save locally to prevent multi-rating
                localStorage.setItem('ilybd_rated_' + postId, ratingValue);
            }
        }
    });
}

function highlightStarRating(val) {
    var stars = document.querySelectorAll('.star-rating-item');
    stars.forEach(function(star) {
        var starVal = parseInt(star.getAttribute('data-val'));
        if (starVal <= val) {
            star.classList.remove('fa-regular');
            star.classList.add('fa-solid');
            star.style.transform = 'scale(1.15)';
        } else {
            star.classList.remove('fa-solid');
            star.classList.add('fa-regular');
            star.style.transform = 'scale(1)';
        }
    });
}

// AJAX Share tracking & redirect
function triggerIlybdShare(postId, platform) {
    var title = "<?php echo esc_js(get_the_title()); ?>";
    var url = "<?php echo esc_js(get_permalink()); ?>";
    
    var shareMsg = "📖 " + title + "\n\nএই রোমাঞ্চকর গল্পটি সম্পূর্ণ পড়তে সরাসরি নিচের লিংকে ক্লিক করুন:\n" + url;
    var shareUrl = "";
    
    if (platform === 'whatsapp') {
        shareUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(shareMsg);
    } else if (platform === 'facebook') {
        shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url);
    } else if (platform === 'messenger') {
        shareUrl = "fb-messenger://share/?link=" + encodeURIComponent(url);
        // FB Messenger fallback
        if (!shareUrl) shareUrl = "https://www.facebook.com/dialog/send?link=" + encodeURIComponent(url) + "&app_id=291494419107518&redirect_uri=" + encodeURIComponent(url);
    } else if (platform === 'telegram') {
        shareUrl = "https://t.me/share/url?url=" + encodeURIComponent(url) + "&text=" + encodeURIComponent(title);
    }
    
    // Register the share action via AJAX to award rewards
    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'POST',
        data: {
            action: 'ilybd_handle_share',
            post_id: postId
        },
        success: function(res) {
            // Success registration
        }
    });
    
    window.open(shareUrl, '_blank');
}

document.addEventListener('DOMContentLoaded', function() {
    var postId = "<?php echo get_the_ID(); ?>";
    
    // Scroll Reading Progress Indicator
    window.addEventListener('scroll', function() {
        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        var progressEl = document.getElementById("cyber-story-reading-progress");
        if (progressEl) {
            progressEl.style.width = scrolled + "%";
        }
    });

    // Sync Like Status on Page Load
    if (localStorage.getItem('ilybd_liked_' + postId) === 'true') {
        var likeBtn = document.getElementById('ilybd-like-btn');
        if (likeBtn) {
            likeBtn.innerHTML = '<i class="fa-solid fa-heart" style="color: #ff3e3e;"></i> পছন্দ হয়েছে!';
            likeBtn.classList.add('liked');
            likeBtn.style.background = 'rgba(255, 62, 62, 0.1)';
            likeBtn.style.color = '#ff3e3e';
            likeBtn.style.borderColor = 'rgba(255, 62, 62, 0.3)';
        }
    }
    
    // Sync Star Rating Status on Page Load
    var ratedVal = localStorage.getItem('ilybd_rated_' + postId);
    if (ratedVal) {
        highlightStarRating(parseInt(ratedVal));
        var statusText = document.getElementById('rating-status-text');
        if (statusText) statusText.innerHTML = '🟢 ধন্যবাদ! আপনার ' + ratedVal + '★ রেটিং সফলভাবে সংরক্ষিত হয়েছে।';
    }
});

function copyStoryContents(btn) {
    var storyBody = document.getElementById("storyMainBody");
    if (!storyBody) return;
    
    var text = storyBody.innerText || storyBody.textContent;
    // Strip out typical buttons text if any
    text = text.replace(/বাংলা কপি|ইংরেজি কপি|শেয়ার|কপি করুন|হোয়াটসঅ্যাপ/g, '').trim();
    
    navigator.clipboard.writeText(text).then(function() {
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-check" style="color:#00ff41;"></i> কপি সম্পন্ন!';
        btn.style.borderColor = "#00ff41";
        btn.style.color = "#00ff41";
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.style.borderColor = "";
            btn.style.color = "";
        }, 2000);
    });
}

function shareStoryOnWhatsapp() {
    var postTitle = "<?php echo esc_js(get_the_title()); ?>";
    var postUrl = "<?php echo esc_js(get_permalink()); ?>";
    var shareMsg = "📚 " + postTitle + "\n\nএই অসামান্য গল্পটি সম্পূর্ণ পড়তে নিচের লিংকে ভিজিট করুন:\n" + postUrl;
    var whatsappUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(shareMsg);
    window.open(whatsappUrl, '_blank');
}
</script>

<?php get_footer(); ?>
