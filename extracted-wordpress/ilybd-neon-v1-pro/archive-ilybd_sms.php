<?php
/**
 * Custom SMS & Status Archive Hub Template (2040 Cyber Ecosystem)
 * Theme: ilybd-neon-v1-pro
 */
get_header(); 

// Current taxonomy info if in category
$current_term = is_tax('sms_category') ? get_queried_object() : null;
$title_prefix = $current_term ? 'ক্যাটাগরি: ' : 'এসএমএস সেন্ট্রাল হাব';
$title_text = $current_term ? $current_term->name : 'SMS & Status Hub';
$desc_text = $current_term ? $current_term->description : 'আপনার অনুভূতি প্রকাশের জন্য এআই-চালিত সর্বাধুনিক বাংলা এসএমএস ও স্ট্যাটাস কালেকশন।';
if (empty($desc_text)) {
    $desc_text = 'সেরা সব রোমান্টিক, ইসলামিক, অ্যাটিটিউড এবং বন্ধুত্বের এসএমএস ও ফেসবুক স্ট্যাটাস।';
}
?>

<div class="nextgen-archive-viewport sms-hub-viewport" style="background: #070b13; color: #c9d1d9; min-height: 100vh; padding: 40px 15px 80px; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1100px; margin: 0 auto; width: 100%;">

        <!-- 1. BREADCRUMB / ACCESSIBILITY NAV -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 25px; font-size: 13px; font-family: monospace;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
            <span style="color: #475569; margin: 0 8px;">/</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_sms')); ?>" style="color: #00f0ff; text-decoration: none; font-weight: bold;">SMS CENTER</a>
            <?php if ($current_term) : ?>
                <span style="color: #475569; margin: 0 8px;">/</span>
                <span style="color: #94a3b8; text-transform: uppercase;"><?php echo esc_html($current_term->name); ?></span>
            <?php endif; ?>
        </nav>

        <!-- 2. COMPACT HEADER TITLE -->
        <div class="compact-archive-header" style="margin-bottom: 30px; border-left: 3.5px solid #00f0ff; padding-left: 15px;">
            <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0 0 5px 0; font-family: 'Space Grotesk', sans-serif;">
                <span style="color: #00f0ff;"><?php echo esc_html($title_prefix); ?></span><?php echo esc_html($title_text); ?>
            </h1>
            <p style="color: #8b949e; font-size: 14.5px; margin: 0; line-height: 1.4;"><?php echo esc_html($desc_text); ?></p>
        </div>

        <!-- 3. GOOGLE ADSENSE FRIENDLY SAFE ZONE (TOP PLACEHOLDER) -->
        <?php if (get_option('ily_enable_adsense_placeholders', 0) == 1) : ?>
        <div class="adsense-safe-container" style="margin-bottom: 35px; min-height: 90px; background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.05); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 11px; font-family: monospace;">
            <span>[ ADVERTISING CONTAINER - GOOGLE ADSENSE POLICY COMPLIANT ]</span>
        </div>
        <?php endif; ?>

        <!-- 4. TAXONOMY INTERACTIVE CATEGORY SELECTOR -->
        <section aria-label="SMS Categories Selector" style="margin-bottom: 35px;">
            <h2 style="font-size: 13px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">SMS CATEGORIES (ক্যাটাগরি সমূহ)</h2>
            <div class="sms-archive-filters" style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none;">
                <style>
                    .sms-archive-filters::-webkit-scrollbar { display: none; }
                    .filter-btn {
                        background: rgba(13, 21, 39, 0.6);
                        border: 1.5px solid rgba(255, 255, 255, 0.05);
                        color: #8b949e;
                        padding: 10px 20px;
                        border-radius: 10px;
                        font-weight: bold;
                        font-size: 13px;
                        text-decoration: none;
                        white-space: nowrap;
                        transition: all 0.25s;
                    }
                    .filter-btn:hover {
                        border-color: #00f0ff;
                        color: #00f0ff;
                        background: rgba(0, 240, 255, 0.05);
                    }
                    .filter-btn.active {
                        background: rgba(0, 240, 255, 0.1);
                        border-color: #00f0ff;
                        color: #00f0ff;
                        box-shadow: 0 0 15px rgba(0, 240, 255, 0.1);
                    }
                </style>
                <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_sms')); ?>" class="filter-btn <?php echo !$current_term ? 'active' : ''; ?>">
                    <i class="fa-solid fa-layer-group"></i> সব ক্যাটাগরি
                </a>
                <?php 
                $terms = get_terms(['taxonomy' => 'sms_category', 'hide_empty' => false]);
                if (!is_wp_error($terms) && !empty($terms)) :
                    foreach ($terms as $term) :
                        $is_active = ($current_term && $current_term->slug === $term->slug);
                        $term_link = get_term_link($term);
                        ?>
                        <a href="<?php echo esc_url($term_link); ?>" class="filter-btn <?php echo $is_active ? 'active' : ''; ?>">
                            <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                        </a>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </section>

        <!-- 5. MAIN ARCHIVE LOOP GRID -->
        <main class="sms-bento-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; margin-bottom: 50px;">
            <?php if (have_posts()) : while (have_posts()) : the_post(); 
                $post_id = get_the_ID();
                $post_terms = wp_get_post_terms($post_id, 'sms_category');
                $term_slug = !empty($post_terms) ? $post_terms[0]->slug : 'all';
                $term_name = !empty($post_terms) ? $post_terms[0]->name : 'SMS';
                $permalink = get_permalink();

                // Theme color based on category slug
                $sms_themes = [
                    'love-sms'        => ['color' => '#ff2e93', 'bg' => 'rgba(255, 46, 147, 0.1)', 'border' => 'rgba(255, 46, 147, 0.2)'],
                    'sad-sms'         => ['color' => '#00f0ff', 'bg' => 'rgba(0, 240, 255, 0.1)', 'border' => 'rgba(0, 240, 255, 0.2)'],
                    'islamic-status'  => ['color' => '#00ff66', 'bg' => 'rgba(0, 255, 102, 0.1)', 'border' => 'rgba(0, 255, 102, 0.2)'],
                    'attitude-status' => ['color' => '#9d4edd', 'bg' => 'rgba(157, 78, 221, 0.1)', 'border' => 'rgba(157, 78, 221, 0.2)'],
                    'friendship-sms'  => ['color' => '#ffb703', 'bg' => 'rgba(255, 183, 3, 0.1)', 'border' => 'rgba(255, 183, 3, 0.2)'],
                ];
                $theme = isset($sms_themes[$term_slug]) ? $sms_themes[$term_slug] : ['color' => '#00f0ff', 'bg' => 'rgba(0, 240, 255, 0.1)', 'border' => 'rgba(0, 240, 255, 0.2)'];

                $plain_content = strip_tags(get_the_content());
                $sms_text = mb_strimwidth(trim(preg_replace('/\s+/', ' ', $plain_content)), 0, 160, '...');
                if (empty($sms_text)) {
                    $sms_text = get_the_title();
                }
            ?>
                <article class="sms-collection-card" style="background: #0d1527; border: 1.5px solid <?php echo $theme['border']; ?>; border-radius: 14px; padding: 22px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s; box-shadow: 0 4px 20px rgba(0,0,0,0.25);">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at top right, <?php echo $theme['bg']; ?> 0%, transparent 60%); pointer-events: none;"></div>
                    
                    <div>
                        <!-- Header metadata -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 11px;">
                            <span style="background: <?php echo $theme['bg']; ?>; color: <?php echo $theme['color']; ?>; border: 1px solid <?php echo $theme['border']; ?>; padding: 3px 8px; border-radius: 4px; font-weight: bold; text-transform: uppercase;">
                                <?php echo esc_html($term_name); ?>
                            </span>
                            <span style="color: #64748b; font-family: monospace;">
                                <?php echo esc_html(get_the_date()); ?>
                            </span>
                        </div>

                        <!-- Card Title -->
                        <h3 style="font-size: 16px; font-weight: 800; margin: 0 0 12px 0; line-height: 1.4;">
                            <a href="<?php echo esc_url($permalink); ?>" style="color: #fff; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='<?php echo $theme['color']; ?>'" onmouseout="this.style.color='#fff'">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <!-- Excerpt Container -->
                        <div style="background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255,255,255,0.02); border-radius: 8px; padding: 12px; margin-bottom: 15px; min-height: 80px; display: flex; align-items: center;">
                            <p style="color: #cbd5e0; font-size: 13.5px; line-height: 1.5; margin: 0; word-break: break-word;">
                                <?php echo esc_html($sms_text); ?>
                            </p>
                        </div>

                        <!-- Stats & Share Bar -->
                        <?php
                        $views_count = intval(get_post_meta($post_id, 'ilybd_post_views_count', true));
                        if ($views_count <= 0) { $views_count = ($post_id % 117) + 24; }
                        $likes_count = intval(get_post_meta($post_id, '_likes', true));
                        if ($likes_count <= 0) { $likes_count = ($post_id % 23) + 5; }
                        ?>
                        <div class="sms-card-action-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 6px 12px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid rgba(255,255,255,0.04); font-size: 11px; color: #718096; font-family: monospace;">
                            <div style="display: flex; gap: 10px; align-items: center;">
                                <span><i class="fa-solid fa-eye" style="color: <?php echo $theme['color']; ?>; margin-right: 3px;"></i><?php echo number_format($views_count); ?></span>
                                <span><i class="fa-solid fa-heart" style="color: #ff2e93; margin-right: 3px;"></i><?php echo number_format($likes_count); ?></span>
                            </div>
                            <button class="sms-quick-share-btn" data-url="<?php echo esc_url($permalink); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>" style="background: none; border: none; color: <?php echo $theme['color']; ?>; cursor: pointer; display: flex; align-items: center; gap: 4px; font-size: 11px; font-family: inherit; font-weight: bold; padding: 0;" onclick="event.preventDefault(); event.stopPropagation(); ilybdCopySmsLink(this);">
                                <i class="fa-solid fa-share-nodes"></i> লিঙ্ক কপি
                            </button>
                        </div>
                    </div>

                    <!-- Actions Button Row (Green "Read More" Button) -->
                    <div style="border-top: 1px solid rgba(255,255,255,0.04); padding-top: 12px; margin-top: 10px; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                        <button onclick="copyCardSmsText('<?php echo esc_js($sms_text); ?>', this)" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); color: #8b949e; border-radius: 6px; font-size: 11px; padding: 8px 12px; font-weight: bold; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: 0.2s;">
                            <i class="fa-regular fa-copy"></i> কপি করুন
                        </button>
                        
                        <a href="<?php echo esc_url($permalink); ?>" aria-label="Read more about <?php echo esc_attr($title); ?>" style="flex: 1; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(0, 255, 136, 0.08) 0%, rgba(0, 180, 100, 0.15) 100%); border: 1.5px solid #00ff88; color: #00ff88; padding: 8px 15px; border-radius: 8px; font-weight: bold; font-size: 12px; text-shadow: 0 0 8px rgba(0,255,136,0.2); text-decoration: none; transition: all 0.25s; gap: 6px;">
                            বিস্তারিত পড়ুন / Read SMS <span style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">about <?php the_title(); ?></span> <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            <?php endwhile; else : ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #0d1527; border-radius: 15px; border: 1px dashed rgba(255,255,255,0.05);">
                    <p style="color: #64748b; font-size: 15px;">দুঃখিত, এই ক্যাটাগরিতে এখনো কোনো এসএমএস বা স্ট্যাটাস পোস্ট তৈরি করা হয়নি।</p>
                </div>
            <?php endif; ?>
        </main>

        <!-- 6. HIGH-END CYBER PAGINATION -->
        <div class="cyber-pagination-container" style="display: flex; justify-content: center; margin-bottom: 60px;">
            <style>
                .cyber-pagination-container .navigation { display: flex; gap: 8px; }
                .cyber-pagination-container .page-numbers {
                    background: #0d1527;
                    border: 1px solid rgba(0, 240, 255, 0.1);
                    color: #8b949e;
                    padding: 8px 16px;
                    border-radius: 8px;
                    text-decoration: none;
                    font-weight: bold;
                    font-size: 14px;
                    transition: all 0.2s;
                }
                .cyber-pagination-container .page-numbers:hover {
                    border-color: #00f0ff;
                    color: #00f0ff;
                    background: rgba(0,240,255,0.05);
                }
                .cyber-pagination-container .page-numbers.current {
                    background: rgba(0, 240, 255, 0.15);
                    border-color: #00f0ff;
                    color: #00f0ff;
                    box-shadow: 0 0 10px rgba(0,240,255,0.2);
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

        <!-- 7. SECURE INTERLINKING: RELATED HIGH-ENGAGEMENT SECTIONS (ORGANIC SHIELD) -->
        <section class="archive-recommendations" style="border-top: 1.5px solid rgba(255,255,255,0.04); padding-top: 40px; margin-top: 50px;">
            <h2 style="font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-cubes-stacked" style="color: #00f0ff;"></i> অন্যান্য অনুষঙ্গ সমূহ (Next-Gen Hubs)
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                
                <!-- Story Shelf recommendation -->
                <div style="background: rgba(13, 21, 39, 0.5); border: 1px solid rgba(157, 78, 221, 0.15); border-radius: 12px; padding: 20px; transition: all 0.25s;">
                    <div style="font-size: 10px; color: #c77dff; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; font-family: monospace;">📚 STORIES & NOVELS</div>
                    <h3 style="font-size: 15px; margin: 0 0 10px 0; color: #fff;">গল্পের আসর (Story Shelf)</h3>
                    <p style="font-size: 12px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">রোমাঞ্চকর রোমান্টিক, সাইবার থ্রিলার এবং রহস্যময় গল্পের এক অভাবনীয় ভান্ডার।</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_story')); ?>" style="display: inline-flex; align-items: center; gap: 5px; color: #c77dff; text-decoration: none; font-size: 12px; font-weight: bold;">
                        লাইব্রেরী ভিজিট করুন <i class="fa-solid fa-arrow-right"></i>
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
                    <h3 style="font-size: 15px; margin: 0 0 10px 0; color: #fff;">আই লাভ ইউ বিডি হোম</h3>
                    <p style="font-size: 12px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">প্রশ্নোওর, ফ্রি টুলস এবং আধুনিক কনটেন্ট ইকোসিস্টেমের হোম এভিনিউ।</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" style="display: inline-flex; align-items: center; gap: 5px; color: #00f0ff; text-decoration: none; font-size: 12px; font-weight: bold;">
                        হোমপেজে ফিরে যান <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </section>

    </div>
</div>

<!-- JS COPY ACTION METHOD -->
<script>
function copyCardSmsText(text, btn) {
    if (!text) return;
    navigator.clipboard.writeText(text).then(function() {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-check" style="color: #00ff88;"></i> কপিড!';
        btn.style.borderColor = '#00ff88';
        btn.style.color = '#00ff88';
        setTimeout(function() {
            btn.innerHTML = original;
            btn.style.borderColor = 'rgba(255,255,255,0.06)';
            btn.style.color = '#8b949e';
        }, 1800);
    });
}
</script>

<?php get_footer(); ?>
