<?php
/**
 * Custom Stories & Novels Archive Shelf Template (2040 Literary Hub)
 * Theme: ilybd-neon-v1-pro
 */
get_header(); 

// Current genre/category taxonomy info
$current_term = is_tax('story_category') ? get_queried_object() : null;
$title_prefix = $current_term ? 'গল্পের জঁনরা: ' : 'গল্পের আসর';
$title_text = $current_term ? $current_term->name : 'Cyber Story Shelf';
$desc_text = $current_term ? $current_term->description : 'কল্পনা ও রোমাঞ্চের এক অপরূপ মেলবন্ধন। রোমান্টিক গল্প, থ্রিলার উপন্যাস এবং রহস্যময় ভৌতিক কাহিনীর এআই-কিউরেটেড ডিজিটাল সংগ্রহশালা।';
if (empty($desc_text)) {
    $desc_text = 'সেরা সব রোমাঞ্চকর সাইবার থ্রিলার, রোমান্টিক উপন্যাস এবং শিক্ষণীয় রূপকথা।';
}
?>

<div class="nextgen-archive-viewport story-hub-viewport" style="background: #070b13; color: #c9d1d9; min-height: 100vh; padding: 40px 15px 80px; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1100px; margin: 0 auto; width: 100%;">

        <!-- 1. BREADCRUMB / ACCESSIBILITY NAV -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 25px; font-size: 13px; font-family: monospace;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
            <span style="color: #475569; margin: 0 8px;">/</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_story')); ?>" style="color: #9d4edd; text-decoration: none; font-weight: bold;">STORY SHELF</a>
            <?php if ($current_term) : ?>
                <span style="color: #475569; margin: 0 8px;">/</span>
                <span style="color: #94a3b8; text-transform: uppercase;"><?php echo esc_html($current_term->name); ?></span>
            <?php endif; ?>
        </nav>

        <!-- 2. COMPACT HEADER TITLE -->
        <div class="compact-archive-header" style="margin-bottom: 30px; border-left: 3.5px solid #c77dff; padding-left: 15px;">
            <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0 0 5px 0; font-family: 'Space Grotesk', sans-serif;">
                <span style="color: #c77dff;"><?php echo esc_html($title_prefix); ?></span><?php echo esc_html($title_text); ?>
            </h1>
            <p style="color: #8b949e; font-size: 14.5px; margin: 0; line-height: 1.4;"><?php echo esc_html($desc_text); ?></p>
        </div>

        <!-- 3. ADSENSE SAFE ZONE CONTAINER -->
        <?php if (get_option('ily_enable_adsense_placeholders', 0) == 1) : ?>
        <div class="adsense-safe-container" style="margin-bottom: 35px; min-height: 90px; background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.05); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 11px; font-family: monospace;">
            <span>[ ADVERTISING PORTAL - GOOGLE ADSENSE FRIENDLY SPACING AREA ]</span>
        </div>
        <?php endif; ?>

        <!-- 4. STORY CATEGORIES FILTER SELECTOR -->
        <section aria-label="Story Categories" style="margin-bottom: 35px;">
            <h2 style="font-size: 13px; font-family: monospace; color: #a29bfe; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">STORY GENRES (গল্পের ধরন)</h2>
            <div class="story-archive-filters" style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none;">
                <style>
                    .story-archive-filters::-webkit-scrollbar { display: none; }
                    .story-filter-btn {
                        background: rgba(13, 21, 39, 0.6);
                        border: 1.5px solid rgba(255, 255, 255, 0.05);
                        color: #a29bfe;
                        padding: 10px 20px;
                        border-radius: 10px;
                        font-weight: bold;
                        font-size: 13px;
                        text-decoration: none;
                        white-space: nowrap;
                        transition: all 0.25s;
                    }
                    .story-filter-btn:hover {
                        border-color: #9d4edd;
                        color: #fff;
                        background: rgba(157, 78, 221, 0.08);
                    }
                    .story-filter-btn.active {
                        background: rgba(157, 78, 221, 0.15);
                        border-color: #9d4edd;
                        color: #fff;
                        box-shadow: 0 0 15px rgba(157, 78, 221, 0.15);
                    }
                </style>
                <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_story')); ?>" class="story-filter-btn <?php echo !$current_term ? 'active' : ''; ?>">
                    <i class="fa-solid fa-book-atlas"></i> সকল গল্প
                </a>
                <?php 
                $terms = get_terms(['taxonomy' => 'story_category', 'hide_empty' => false]);
                if (!is_wp_error($terms) && !empty($terms)) :
                    foreach ($terms as $term) :
                        $is_active = ($current_term && $current_term->slug === $term->slug);
                        $term_link = get_term_link($term);
                        ?>
                        <a href="<?php echo esc_url($term_link); ?>" class="story-filter-btn <?php echo $is_active ? 'active' : ''; ?>">
                            <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                        </a>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </section>

        <!-- 5. STORY SHELF CARD GRID -->
        <main class="story-shelf-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 24px; margin-bottom: 50px; perspective: 1000px;">
            <?php if (have_posts()) : while (have_posts()) : the_post(); 
                $post_id = get_the_ID();
                $post_terms = wp_get_post_terms($post_id, 'story_category');
                $term_slug = !empty($post_terms) ? $post_terms[0]->slug : 'all';
                $term_name = !empty($post_terms) ? $post_terms[0]->name : 'গল্প';
                $permalink = get_permalink();
                $excerpt = wp_trim_words(get_the_excerpt(), 25, '...');

                $story_themes = [
                    'romantic-stories' => ['color' => '#f72585', 'gradient' => 'linear-gradient(135deg, #f72585 0%, #7209b7 100%)', 'bg' => 'rgba(247, 37, 133, 0.08)'],
                    'cyber-thrillers'  => ['color' => '#00ff41', 'gradient' => 'linear-gradient(135deg, #00ff41 0%, #0d5c1b 100%)', 'bg' => 'rgba(0, 255, 65, 0.08)'],
                    'moral-legends'    => ['color' => '#ffb703', 'gradient' => 'linear-gradient(135deg, #ffb703 0%, #fb8500 100%)', 'bg' => 'rgba(255, 183, 3, 0.08)'],
                    'ghost-mysteries'  => ['color' => '#9d4edd', 'gradient' => 'linear-gradient(135deg, #9d4edd 0%, #3a0ca3 100%)', 'bg' => 'rgba(157, 78, 221, 0.08)'],
                ];
                $theme = isset($story_themes[$term_slug]) ? $story_themes[$term_slug] : ['color' => '#9d4edd', 'gradient' => 'linear-gradient(135deg, #9d4edd 0%, #3a0ca3 100%)', 'bg' => 'rgba(157, 78, 221, 0.08)'];
            ?>
                
                <article class="story-book-card" style="background: #0d1527; border-radius: 8px 14px 14px 8px; border: 1.5px solid rgba(255, 255, 255, 0.05); min-height: 280px; position: relative; display: flex; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.3); transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                    <style>
                        .story-book-card:hover {
                            transform: rotateY(-6deg) translateY(-4px);
                            border-color: <?php echo $theme['color']; ?>;
                            box-shadow: 10px 12px 30px <?php echo $theme['bg']; ?>;
                        }
                    </style>
                    <div class="story-book-spine" style="width: 14px; flex-shrink: 0; border-radius: 4px 0 0 4px; box-shadow: inset -2px 0 6px rgba(0,0,0,0.4); background: <?php echo $theme['gradient']; ?>;"></div>
                    <div class="story-book-cover-mesh" style="position: absolute; top: 0; left: 14px; right: 0; bottom: 0; background: linear-gradient(90deg, rgba(255,255,255,0.01) 0%, rgba(255,255,255,0) 5%, rgba(0,0,0,0.15) 6%, rgba(255,255,255,0.03) 8%, transparent 15%); pointer-events: none;"></div>
                    
                    <div class="story-book-content" style="padding: 16px 16px 16px 12px; display: flex; flex-direction: column; justify-content: space-between; width: 100%;">
                        
                        <div>
                            <div class="story-meta-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <span class="genre-badge" style="font-size: 9px; font-weight: 800; color: <?php echo $theme['color']; ?>; background: <?php echo $theme['bg']; ?>; border: 1px solid rgba(255, 255, 255, 0.05); padding: 3px 6px; border-radius: 4px; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <i class="fa-solid fa-bookmark"></i> <?php echo esc_html($term_name); ?>
                                </span>
                                <span style="font-size: 9.5px; color: #8b949e;"><i class="fa-regular fa-clock"></i> ৫ মিনিট পড়া</span>
                            </div>
                            
                            <h3 style="font-size: 14.5px; font-weight: 800; margin: 0 0 10px 0; line-height: 1.4;">
                                <a href="<?php echo esc_url($permalink); ?>" style="color: #fff; text-decoration: none;" onmouseover="this.style.color='<?php echo $theme['color']; ?>'" onmouseout="this.style.color='#fff'">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            
                            <p style="font-size: 12px; color: #cbd5e0; line-height: 1.5; margin: 0 0 12px 0;">
                                <?php echo esc_html($excerpt); ?>
                            </p>
                        </div>
                        
                        <!-- Read More Button (Green) -->
                        <div style="border-top: 1px solid rgba(255,255,255,0.04); padding-top: 12px; margin-top: 10px;">
                            <a href="<?php echo esc_url($permalink); ?>" aria-label="Read more about <?php echo esc_attr($post->post_title); ?>" style="width: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(0, 255, 136, 0.08) 0%, rgba(0, 180, 100, 0.15) 100%); border: 1.5px solid #00ff88; color: #00ff88; padding: 10px 15px; border-radius: 8px; font-weight: bold; font-size: 13px; text-shadow: 0 0 10px rgba(0,255,136,0.2); transition: all 0.25s; gap: 6px; text-decoration: none;">
                                বিস্তারিত পড়ুন / Read Story <span style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">about <?php the_title(); ?></span> <i class="fa-solid fa-book-open"></i>
                            </a>
                        </div>

                    </div>
                </article>

            <?php endwhile; else : ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #0d1527; border-radius: 15px; border: 1px dashed rgba(255,255,255,0.05);">
                    <p style="color: #8b949e; font-size: 15px;">দুঃখিত, এই ক্যাটাগরিতে এখনো কোনো গল্প পোস্ট করা হয়নি।</p>
                </div>
            <?php endif; ?>
        </main>

        <!-- 6. PAGINATION SYSTEM -->
        <div class="cyber-pagination-container" style="display: flex; justify-content: center; margin-bottom: 60px;">
            <style>
                .cyber-pagination-container .navigation { display: flex; gap: 8px; }
                .cyber-pagination-container .page-numbers {
                    background: #0d1527;
                    border: 1px solid rgba(157, 78, 221, 0.15);
                    color: #a29bfe;
                    padding: 8px 16px;
                    border-radius: 8px;
                    text-decoration: none;
                    font-weight: bold;
                    font-size: 14px;
                    transition: all 0.2s;
                }
                .cyber-pagination-container .page-numbers:hover {
                    border-color: #9d4edd;
                    color: #fff;
                    background: rgba(157, 78, 221, 0.05);
                }
                .cyber-pagination-container .page-numbers.current {
                    background: rgba(157, 78, 221, 0.15);
                    border-color: #9d4edd;
                    color: #fff;
                    box-shadow: 0 0 10px rgba(157,78,221,0.2);
                }
            </style>
            <?php 
            the_posts_pagination([
                'mid_size'  => 3,
                'prev_text' => '<i class="fa-solid fa-chevron-left"></i> পূর্ববর্তী',
                'next_text' => 'পরবর্তী <i class="fa-solid fa-chevron-right"></i>',
            ]); 
            ?>
        </div>

        <!-- 7. ORGANIC SHIELD: INTERLINKING WITH OTHER CORES -->
        <section class="archive-recommendations" style="border-top: 1.5px solid rgba(255,255,255,0.04); padding-top: 40px; margin-top: 50px;">
            <h2 style="font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-cubes-stacked" style="color: #9d4edd;"></i> অন্যান্য অনুষঙ্গ সমূহ (Ecosystem Hubs)
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                
                <!-- SMS Center recommendation -->
                <div style="background: rgba(13, 21, 39, 0.5); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 20px; transition: all 0.25s;">
                    <div style="font-size: 10px; color: #00f0ff; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; font-family: monospace;">💬 SMS & STATUS</div>
                    <h3 style="font-size: 15px; margin: 0 0 10px 0; color: #fff;">এসএমএস ও স্ট্যাটাস হাব</h3>
                    <p style="font-size: 12px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">আপনার সামাজিক ভাব বিনিময়ের জন্য সর্বাধুনিক বাংলা স্ট্যাটাস কালেকশন।</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_sms')); ?>" style="display: inline-flex; align-items: center; gap: 5px; color: #00f0ff; text-decoration: none; font-size: 12px; font-weight: bold;">
                        এসএমএস সেন্টারে যান <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Device Review recommendation -->
                <div style="background: rgba(13, 21, 39, 0.5); border: 1px solid rgba(0, 255, 65, 0.15); border-radius: 12px; padding: 20px; transition: all 0.25s;">
                    <div style="font-size: 10px; color: #00ff41; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; font-family: monospace;">📱 GADGET INTEL</div>
                    <h3 style="font-size: 15px; margin: 0 0 10px 0; color: #fff;">ডিভাইস রিভিউ (Tech Reviews)</h3>
                    <p style="font-size: 12px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">স্মার্টফোনের পুঙ্খানুপুঙ্খ বিবরণ, স্পেসিফিকেশন এবং মূল্য পর্যালোচনা।</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_phone_review')); ?>" style="display: inline-flex; align-items: center; gap: 5px; color: #00ff41; text-decoration: none; font-size: 12px; font-weight: bold;">
                        রিভিউ হাব ভিজিট করুন <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Main Portal Home page back -->
                <div style="background: rgba(13, 21, 39, 0.5); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 20px; transition: all 0.25s;">
                    <div style="font-size: 10px; color: #00f0ff; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; font-family: monospace;">🏠 PORTAL DASHBOARD</div>
                    <h3 style="font-size: 15px; margin: 0 0 10px 0; color: #fff;">হোম ড্যাশবোর্ড</h3>
                    <p style="font-size: 12px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">প্রশ্নোওর, ফ্রি টুলস এবং আধুনিক কনটেন্ট ইকোসিস্টেমের হোম এভিনিউ।</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" style="display: inline-flex; align-items: center; gap: 5px; color: #00f0ff; text-decoration: none; font-size: 12px; font-weight: bold;">
                        হোমপেজে ফিরে যান <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </section>

    </div>
</div>

<?php get_footer(); ?>
