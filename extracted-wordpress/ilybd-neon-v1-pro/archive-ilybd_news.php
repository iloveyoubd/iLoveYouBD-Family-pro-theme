<?php
/**
 * Custom Independent AI News Center Portal Archive Template (2040 Next-Gen Vibe)
 * Theme: ilybd-neon-v1-pro
 * Fully compatible with Google AdSense, Core Web Vitals, and SEO requirements.
 */
get_header();

$current_category = is_tax('news_category') ? get_queried_object() : null;
$title_prefix = $current_category ? 'সংবাদ বিভাগ: ' : 'এআই নিউজ সেন্টার';
$title_text = $current_category ? $current_category->name : 'IBD Cyber News Hub';
$desc_text = $current_category ? $current_category->description : 'রিয়েল-টাইম এআই দ্বারা পরিচালিত এবং ভেরিফাইড সত্য সংবাদ সংগ্রহশালা। সাইবার সিকিউরিটি, গ্লোবাল টেকনোলজি, বাংলাদেশ ও আন্তর্জাতিক ঘটনার ২৪/৭ অটোমেটেড কাভারেজ।';
if (empty($desc_text)) {
    $desc_text = 'বিশ্বস্ত এআই নেটওয়ার্ক এবং আধুনিক ক্রলার দ্বারা সংগৃহীত বস্তুনিষ্ঠ ও নিরপেক্ষ সাইবার সংবাদ।';
}

// Fetch general news settings
$show_thumb = get_option('ilybd_news_show_thumbnail', '1') !== '0';
$show_time  = get_option('ilybd_news_show_publish_time', '1') !== '0';
$show_cat   = get_option('ilybd_news_show_category', '1') !== '0';
$show_sum   = get_option('ilybd_news_show_summary', '1') !== '0';
$show_more  = get_option('ilybd_news_show_read_more', '1') !== '0';
$btn_text   = get_option('ilybd_news_button_text', 'সম্পূর্ণ খবর পড়ুন');

// Search and filter inputs
$search_query = isset($_GET['news_search']) ? sanitize_text_field($_GET['news_search']) : '';
$filter_date  = isset($_GET['news_date']) ? sanitize_text_field($_GET['news_date']) : '';
?>

<div class="nextgen-news-portal-viewport" style="background: #070b13; color: #c9d1d9; min-height: 100vh; padding: 40px 15px 80px; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1200px; margin: 0 auto; width: 100%;">

        <!-- 1. BREADCRUMBS -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 25px; font-size: 13px; font-family: monospace; letter-spacing: 0.5px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
            <span style="color: #475569; margin: 0 8px;">/</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_news')); ?>" style="color: #00f0ff; text-decoration: none; font-weight: bold;">NEWS CENTER</a>
            <?php if ($current_category) : ?>
                <span style="color: #475569; margin: 0 8px;">/</span>
                <span style="color: #94a3b8; text-transform: uppercase;"><?php echo esc_html($current_category->name); ?></span>
            <?php endif; ?>
        </nav>

        <!-- 2. BREAKING NEWS TICKER -->
        <div class="breaking-news-container" style="background: rgba(255, 75, 43, 0.08); border: 1.5px solid rgba(255, 75, 43, 0.25); border-radius: 12px; padding: 12px 20px; margin-bottom: 30px; display: flex; align-items: center; gap: 15px; overflow: hidden; box-shadow: 0 0 15px rgba(255, 75, 43, 0.05);">
            <div class="breaking-badge" style="background: #ff4b2b; color: #fff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; font-family: 'Space Grotesk', sans-serif; text-transform: uppercase; letter-spacing: 1px; white-space: nowrap; animation: pulse 2s infinite;">
                🔴 BREAKING NEWS
            </div>
            <div class="breaking-scroll-wrap" style="flex: 1; overflow: hidden; white-space: nowrap; position: relative;">
                <div class="breaking-ticker-text" style="display: inline-block; padding-left: 100%; animation: ticker 25s linear infinite; color: #f8fafc; font-size: 14px; font-weight: 500;">
                    <?php 
                    $breaking_query = new WP_Query([
                        'post_type' => 'ilybd_news',
                        'posts_per_page' => 5,
                        'tax_query' => [
                            [
                                'taxonomy' => 'news_category',
                                'field' => 'slug',
                                'terms' => 'breaking-news',
                                'operator' => 'IN'
                            ]
                        ]
                    ]);
                    if ($breaking_query->have_posts()) {
                        $breaking_titles = [];
                        while ($breaking_query->have_posts()) {
                            $breaking_query->the_post();
                            $breaking_titles[] = get_the_title() . ' • ' . get_the_time('h:i A');
                        }
                        echo esc_html(implode('   |   ', $breaking_titles));
                        wp_reset_postdata();
                    } else {
                        echo 'এআই পরিচালিত আইবিডি নিউজ সেন্টার ২৪/৭ একটিভ রয়েছে • রিয়েল-টাইম ডেটা ভেরিফিকেশন চালু আছে • গুগল এডসেন্স ফ্রেন্ডলি লেআউট';
                    }
                    ?>
                </div>
            </div>
            <style>
                @keyframes ticker {
                    0% { transform: translate3d(0, 0, 0); }
                    100% { transform: translate3d(-100%, 0, 0); }
                }
                @keyframes pulse {
                    0% { opacity: 1; }
                    50% { opacity: 0.7; }
                    100% { opacity: 1; }
                }
            </style>
        </div>

        <!-- 3. COMPACT HEADER PORTAL TITLE -->
        <div class="news-portal-header" style="margin-bottom: 35px; border-left: 4px solid #00f0ff; padding-left: 20px; position: relative;">
            <div style="position: absolute; right: 0; top: 0; font-family: monospace; font-size: 11px; color: #00f0ff; background: rgba(0,240,255,0.07); padding: 5px 12px; border: 1px solid rgba(0,240,255,0.15); border-radius: 20px;">
                STATUS: LIVE_FEED_ONLINE
            </div>
            <h1 style="color: #fff; font-size: 28px; font-weight: 800; margin: 0 0 8px 0; font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.5px;">
                <span style="color: #00f0ff;"><?php echo esc_html($title_prefix); ?></span><?php echo esc_html($title_text); ?>
            </h1>
            <p style="color: #94a3b8; font-size: 15px; margin: 0; max-width: 800px; line-height: 1.6;"><?php echo esc_html($desc_text); ?></p>
        </div>

        <!-- 4. GOOGLE ADSENSE FRIENDLY SPACING INTERSTITIAL -->
        <?php if (get_option('ily_enable_adsense_placeholders', 1) == 1) : ?>
        <div class="adsense-banner-wrapper" style="margin-bottom: 35px; min-height: 100px; background: rgba(13, 21, 39, 0.4); border: 1.5px dashed rgba(0, 240, 255, 0.15); border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #475569; font-size: 11px; font-family: monospace; text-align: center; padding: 20px 10px; gap: 5px;">
            <div style="color: #64748b; font-weight: bold; letter-spacing: 1px;">SPONSORED ADV-PORTAL (GOOGLE ADSENSE SAFE PLACEHOLDER)</div>
            <div style="color: #475569; font-size: 10px;">Separated by 20px+ from clickable elements to avoid invalid click penalties</div>
        </div>
        <?php endif; ?>

        <!-- 5. SEARCH & ADVANCED FILTERS SYSTEM -->
        <section aria-label="Search and Filter News" style="background: rgba(13, 21, 39, 0.35); border: 1.5px solid rgba(255, 255, 255, 0.04); border-radius: 14px; padding: 22px; margin-bottom: 40px;">
            <form method="get" action="<?php echo esc_url(get_post_type_archive_link('ilybd_news')); ?>" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) 120px; gap: 15px; align-items: end;">
                
                <div>
                    <label style="display: block; font-size: 12px; font-family: monospace; color: #94a3b8; margin-bottom: 8px; text-transform: uppercase;">Search News (অনুসন্ধান)</label>
                    <input type="text" name="news_search" value="<?php echo esc_attr($search_query); ?>" placeholder="কীওয়ার্ড লিখুন..." style="width: 100%; background: #0d1527; border: 1.5px solid rgba(0,240,255,0.15); border-radius: 8px; padding: 10px 15px; color: #fff; font-size: 14px;" />
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-family: monospace; color: #94a3b8; margin-bottom: 8px; text-transform: uppercase;">Filter by Date (আর্কাইভ)</label>
                    <input type="date" name="news_date" value="<?php echo esc_attr($filter_date); ?>" style="width: 100%; background: #0d1527; border: 1.5px solid rgba(0,240,255,0.15); border-radius: 8px; padding: 10px 15px; color: #fff; font-size: 14px;" />
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-family: monospace; color: #94a3b8; margin-bottom: 8px; text-transform: uppercase;">News Categories</label>
                    <select name="news_cat_select" onchange="location = this.value;" style="width: 100%; background: #0d1527; border: 1.5px solid rgba(0,240,255,0.15); border-radius: 8px; padding: 10px 15px; color: #fff; font-size: 14px;">
                        <option value="<?php echo esc_url(get_post_type_archive_link('ilybd_news')); ?>">সকল ক্যাটাগরি</option>
                        <?php 
                        $cats = get_terms(['taxonomy' => 'news_category', 'hide_empty' => false]);
                        if (!is_wp_error($cats) && !empty($cats)) {
                            foreach ($cats as $cat) {
                                $selected = ($current_category && $current_category->slug === $cat->slug) ? 'selected' : '';
                                echo '<option value="' . esc_url(get_term_link($cat)) . '" ' . $selected . '>' . esc_html($cat->name) . ' (' . $cat->count . ')</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" style="background: #00f0ff; color: #070b13; border: none; border-radius: 8px; padding: 11px; font-weight: bold; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; font-size: 14px;" onmouseover="this.style.boxShadow='0 0 15px #00f0ff'; this.style.transform='scale(1.02)';" onmouseout="this.style.boxShadow='none'; this.style.transform='scale(1)';">
                    SEARCH
                </button>
            </form>
        </section>

        <!-- 6. CATEGORY FAST FILTERS BAR -->
        <section aria-label="Category Navigation Links" style="margin-bottom: 35px;">
            <div class="news-archive-filters" style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 12px; scrollbar-width: none;">
                <style>
                    .news-archive-filters::-webkit-scrollbar { display: none; }
                    .news-filter-btn {
                        background: rgba(13, 21, 39, 0.6);
                        border: 1.5px solid rgba(255, 255, 255, 0.05);
                        color: #00f0ff;
                        padding: 10px 20px;
                        border-radius: 10px;
                        font-weight: bold;
                        font-size: 13.5px;
                        text-decoration: none;
                        white-space: nowrap;
                        transition: all 0.25s;
                    }
                    .news-filter-btn:hover {
                        border-color: #00f0ff;
                        color: #fff;
                        background: rgba(0, 240, 255, 0.08);
                    }
                    .news-filter-btn.active {
                        background: rgba(0, 240, 255, 0.15);
                        border-color: #00f0ff;
                        color: #fff;
                        box-shadow: 0 0 15px rgba(0, 240, 255, 0.15);
                    }
                </style>
                <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_news')); ?>" class="news-filter-btn <?php echo !$current_category ? 'active' : ''; ?>">
                    ⚡ সকল খবর (All News)
                </a>
                <?php 
                if (!is_wp_error($cats) && !empty($cats)) :
                    foreach ($cats as $cat) :
                        if ($cat->slug === 'breaking-news') continue; // hide breaking news category from tab bar
                        $is_active = ($current_category && $current_category->slug === $cat->slug);
                        $cat_link = get_term_link($cat);
                        ?>
                        <a href="<?php echo esc_url($cat_link); ?>" class="news-filter-btn <?php echo $is_active ? 'active' : ''; ?>">
                            <?php echo esc_html($cat->name); ?> (<?php echo $cat->count; ?>)
                        </a>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </section>

        <!-- 7. TWO-COLUMN DYNAMIC MAIN GRID (NEWS SHELF & SIDEBARS) -->
        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 35px;" class="news-main-layout-grid">
            
            <!-- LEFT MAIN CONTENT FEED -->
            <main class="news-shelf-grid" style="display: flex; flex-direction: column; gap: 28px;">
                <?php
                // Build specific Query args if dates/search is set
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = [
                    'post_type' => 'ilybd_news',
                    'posts_per_page' => 12,
                    'paged' => $paged,
                    's' => $search_query
                ];

                if ($current_category) {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'news_category',
                            'field' => 'slug',
                            'terms' => $current_category->slug
                        ]
                    ];
                }

                if (!empty($filter_date)) {
                    $date_parts = explode('-', $filter_date);
                    if (count($date_parts) == 3) {
                        $args['date_query'] = [
                            [
                                'year'  => $date_parts[0],
                                'month' => $date_parts[1],
                                'day'   => $date_parts[2],
                            ]
                        ];
                    }
                }

                $news_query = new WP_Query($args);
                if ($news_query->have_posts()) : while ($news_query->have_posts()) : $news_query->the_post(); 
                    $post_id = get_the_ID();
                    $news_cats = wp_get_object_terms($post_id, 'news_category');
                    $primary_cat_name = !empty($news_cats) && !is_wp_error($news_cats) ? $news_cats[0]->name : 'সংবাদ';
                    $has_thumbnail = has_post_thumbnail();
                    $read_time = round(str_word_count(strip_tags(get_the_content())) / 180);
                    if ($read_time < 1) $read_time = 1;
                    ?>
                    
                    <article class="news-bento-card" style="background: rgba(13, 21, 39, 0.45); border: 1.5px solid rgba(0, 240, 255, 0.1); border-radius: 16px; padding: 24px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; display: grid; grid-template-columns: <?php echo ($has_thumbnail && $show_thumb) ? '240px 1fr' : '1fr'; ?>; gap: 24px;" onmouseover="this.style.borderColor='rgba(0, 240, 255, 0.4)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(0, 240, 255, 0.1)'; this.style.transform='none';">
                        
                        <?php if ($has_thumbnail && $show_thumb) : ?>
                            <div class="news-thumb-wrapper" style="border-radius: 10px; overflow: hidden; position: relative; aspect-ratio: 16/10; background: #070b13; border: 1px solid rgba(255,255,255,0.05);">
                                <a href="<?php the_permalink(); ?>" style="display: block; width: 100%; height: 100%;">
                                    <?php the_post_thumbnail('medium_large', ['style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s;', 'onmouseover' => "this.style.transform='scale(1.045)';", 'onmouseout' => "this.style.transform='scale(1)';", 'loading' => 'lazy']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="news-details-wrapper" style="display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <!-- Top Badges metadata -->
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px; font-family: monospace; font-size: 12px;">
                                    <?php if ($show_cat) : ?>
                                        <span style="background: rgba(0, 240, 255, 0.08); color: #00f0ff; padding: 3px 10px; border-radius: 4px; font-weight: bold; border: 1px solid rgba(0,240,255,0.15);">
                                            <?php echo esc_html($primary_cat_name); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($show_time) : ?>
                                        <span style="color: #64748b;">
                                            🕒 <?php echo esc_html(get_the_time('d M, Y')); ?>
                                        </span>
                                    <?php endif; ?>

                                    <span style="color: #475569;">|</span>
                                    <span style="color: #8b949e;">⏱ <?php echo $read_time; ?> Min Read</span>
                                </div>

                                <!-- News Title -->
                                <h2 style="font-size: 19px; line-height: 1.45; font-weight: 700; color: #fff; margin: 0 0 12px 0;">
                                    <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#00f0ff';" onmouseout="this.style.color='#fff';">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <!-- News excerpt/summary -->
                                <?php if ($show_sum) : ?>
                                    <p style="color: #8b949e; font-size: 14.5px; line-height: 1.6; margin: 0 0 18px 0;">
                                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 28, '...')); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.03); padding-top: 15px; margin-top: 5px;">
                                <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-family: monospace; color: #64748b;">
                                    <span style="background: rgba(0, 255, 102, 0.08); color: #00ff66; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">✓ VERIFIED BY IBD AI</span>
                                </div>

                                <?php if ($show_more) : ?>
                                    <a href="<?php the_permalink(); ?>" style="color: #00f0ff; text-decoration: none; font-size: 13.5px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; transition: color 0.2s;" onmouseover="this.style.color='#fff';" onmouseout="this.style.color='#00f0ff';">
                                        <?php echo esc_html($btn_text); ?> ➡
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>

                <?php endwhile; ?>

                    <!-- Pagination Links -->
                    <div class="nextgen-pagination" style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
                        <?php 
                        echo paginate_links([
                            'total' => $news_query->max_num_pages,
                            'current' => $paged,
                            'prev_text' => '◀ PREV',
                            'next_text' => 'NEXT ▶',
                            'type' => 'plain'
                        ]);
                        ?>
                    </div>

                <?php else : ?>
                    <div style="text-align: center; padding: 80px 20px; background: rgba(13, 21, 39, 0.35); border-radius: 16px; border: 1.5px dashed rgba(255,255,255,0.06);">
                        <div style="font-size: 40px; margin-bottom: 20px;">🔍</div>
                        <h2 style="color: #fff; font-size: 20px; margin-bottom: 10px;">কোনো সংবাদ পাওয়া যায়নি!</h2>
                        <p style="color: #64748b;">অনুগ্রহ করে ভিন্ন কোনো কীওয়ার্ড দিয়ে অনুসন্ধান করুন অথবা পরে আবার চেষ্টা করুন।</p>
                    </div>
                <?php endif; wp_reset_postdata(); ?>
            </main>

            <!-- RIGHT DEDICATED NEWS SIDEBAR -->
            <aside class="news-sidebar-wrapper" style="display: flex; flex-direction: column; gap: 30px;">
                
                <!-- EDITOR'S CHOICE / TOP NEWS MODULE -->
                <div style="background: rgba(13, 21, 39, 0.45); border: 1.5px solid rgba(0, 240, 255, 0.08); border-radius: 14px; padding: 22px;">
                    <h3 style="color: #fff; font-size: 15px; font-family: 'Space Grotesk', sans-serif; text-transform: uppercase; margin: 0 0 18px 0; border-bottom: 1.5px solid rgba(0,240,255,0.15); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                        👨 Editor's Choice (সেরা খবর)
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <?php 
                        $editor_query = new WP_Query([
                            'post_type' => 'ilybd_news',
                            'posts_per_page' => 4,
                            'meta_key' => 'ilybd_news_editors_choice',
                            'meta_value' => '1'
                        ]);
                        // Fallback query if no custom meta is assigned
                        if (!$editor_query->have_posts()) {
                            $editor_query = new WP_Query([
                                'post_type' => 'ilybd_news',
                                'posts_per_page' => 4
                            ]);
                        }
                        if ($editor_query->have_posts()) : while ($editor_query->have_posts()) : $editor_query->the_post();
                        ?>
                            <div style="border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 12px; margin-bottom: 3px;">
                                <a href="<?php the_permalink(); ?>" style="color: #f1f5f9; text-decoration: none; font-size: 13.5px; font-weight: 500; line-height: 1.4; display: block;" onmouseover="this.style.color='#00f0ff';" onmouseout="this.style.color='#f1f5f9';">
                                    <?php the_title(); ?>
                                </a>
                                <span style="font-size: 11px; font-family: monospace; color: #64748b; margin-top: 5px; display: block;">
                                    🕒 <?php echo esc_html(get_the_time('d M, Y')); ?>
                                </span>
                            </div>
                        <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div>
                </div>

                <!-- MOST READ NEWS MODULE (24 HOURS / 7 DAYS) -->
                <div style="background: rgba(13, 21, 39, 0.45); border: 1.5px solid rgba(0, 240, 255, 0.08); border-radius: 14px; padding: 22px;">
                    <h3 style="color: #fff; font-size: 15px; font-family: 'Space Grotesk', sans-serif; text-transform: uppercase; margin: 0 0 18px 0; border-bottom: 1.5px solid rgba(0,240,255,0.15); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                        📈 Most Read (জনপ্রিয় খবর)
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <?php 
                        $popular_news_query = new WP_Query([
                            'post_type' => 'ilybd_news',
                            'posts_per_page' => 5,
                            'meta_key' => 'post_views_count',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC'
                        ]);
                        if (!$popular_news_query->have_posts()) {
                            $popular_news_query = new WP_Query([
                                'post_type' => 'ilybd_news',
                                'posts_per_page' => 5,
                                'orderby' => 'comment_count',
                                'order' => 'DESC'
                            ]);
                        }
                        if ($popular_news_query->have_posts()) : while ($popular_news_query->have_posts()) : $popular_news_query->the_post();
                        ?>
                            <div style="display: flex; gap: 12px; align-items: flex-start; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 12px; margin-bottom: 3px;">
                                <div style="font-size: 18px; font-family: 'Space Grotesk', sans-serif; color: rgba(0, 240, 255, 0.4); font-weight: 800; min-width: 20px;">
                                    #<?php echo $popular_news_query->current_post + 1; ?>
                                </div>
                                <div>
                                    <a href="<?php the_permalink(); ?>" style="color: #e2e8f0; text-decoration: none; font-size: 13.5px; font-weight: 500; line-height: 1.4; display: block;" onmouseover="this.style.color='#00f0ff';" onmouseout="this.style.color='#e2e8f0';">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div>
                </div>

                <!-- SIDEBAR SPONSOR BANNER (GOOGLE ADSENSE SECONDARY ZONE) -->
                <?php if (get_option('ily_enable_adsense_placeholders', 1) == 1) : ?>
                <div class="adsense-sidebar-placeholder" style="background: rgba(13, 21, 39, 0.4); border: 1.5px dashed rgba(0, 240, 255, 0.12); border-radius: 12px; padding: 25px 15px; text-align: center; color: #475569; font-family: monospace; font-size: 11px; display: flex; flex-direction: column; gap: 8px;">
                    <div style="color: #00f0ff; font-weight: bold; letter-spacing: 0.5px;">RECOMMENDED FOR YOU</div>
                    <div style="color: #64748b; font-size: 9.5px; line-height: 1.4;">Clean Safe Ad Container<br/>[ 300x250 Banner Area ]</div>
                </div>
                <?php endif; ?>

            </aside>
        </div>

    </div>
</div>

<style>
@media (max-width: 768px) {
    .news-main-layout-grid {
        grid-template-columns: 1fr !important;
    }
    .news-bento-card {
        grid-template-columns: 1fr !important;
        padding: 18px !important;
    }
}
</style>

<?php get_footer(); ?>
