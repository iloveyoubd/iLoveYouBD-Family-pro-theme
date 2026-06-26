<?php
/**
 * Custom Device Reviews Archive Template (2040 Gadget Intelligence Portal)
 * Theme: ilybd-neon-v1-pro
 */
get_header(); 

// Current brand taxonomy info
$current_term = is_tax('phone_brand') ? get_queried_object() : null;
$title_prefix = $current_term ? 'ব্র্যান্ড রিভিউ: ' : 'ডিভাইস রিভিউ হাব';
$title_text = $current_term ? $current_term->name : 'Gadget Intelligence';
$desc_text = $current_term ? $current_term->description : 'স্মার্টফোন এবং গ্যাজেটসমূহের প্রফেশনাল রিভিউ, নিখুঁত স্পেসিফিকেশন এবং বর্তমান বাংলাদেশী প্রাইস প্যানেল ইন্টেলিজেন্স।';
if (empty($desc_text)) {
    $desc_text = 'সেরা সব ফ্ল্যাগশিপ এবং বাজেট স্মার্টফোনের ইন-ডেপথ টেকনিক্যাল স্পেসিফিকেশন এবং রিভিউ।';
}
?>

<div class="nextgen-archive-viewport review-hub-viewport" style="background: #070b13; color: #c9d1d9; min-height: 100vh; padding: 40px 15px 80px; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1100px; margin: 0 auto; width: 100%;">

        <!-- 1. BREADCRUMB / ACCESSIBILITY NAV -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 25px; font-size: 13px; font-family: monospace;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
            <span style="color: #475569; margin: 0 8px;">/</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_phone_review')); ?>" style="color: #00ff41; text-decoration: none; font-weight: bold;">GADGET LAB</a>
            <?php if ($current_term) : ?>
                <span style="color: #475569; margin: 0 8px;">/</span>
                <span style="color: #94a3b8; text-transform: uppercase;"><?php echo esc_html($current_term->name); ?></span>
            <?php endif; ?>
        </nav>

        <!-- 2. COMPACT HEADER TITLE -->
        <div class="compact-archive-header" style="margin-bottom: 30px; border-left: 3.5px solid #00ff41; padding-left: 15px;">
            <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0 0 5px 0; font-family: 'Space Grotesk', sans-serif;">
                <span style="color: #00ff41;"><?php echo esc_html($title_prefix); ?></span><?php echo esc_html($title_text); ?>
            </h1>
            <p style="color: #8b949e; font-size: 14.5px; margin: 0; line-height: 1.4;"><?php echo esc_html($desc_text); ?></p>
        </div>

        <!-- 3. ADSENSE SAFE ZONE -->
        <?php if (get_option('ily_enable_adsense_placeholders', 0) == 1) : ?>
        <div class="adsense-safe-container" style="margin-bottom: 35px; min-height: 90px; background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.05); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 11px; font-family: monospace;">
            <span>[ ADVERTISING SPACE - GOOGLE ADSENSE POLICY COMPLIANT CONTAINER ]</span>
        </div>
        <?php endif; ?>

        <!-- 4. BRAND SELECTION FILTERS -->
        <section aria-label="Brand Selector" style="margin-bottom: 35px;">
            <h2 style="font-size: 13px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">DEVICE BRANDS (স্মার্টফোন ব্র্যান্ড সমূহ)</h2>
            <div class="brand-archive-filters" style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none;">
                <style>
                    .brand-archive-filters::-webkit-scrollbar { display: none; }
                    .brand-filter-btn {
                        background: rgba(13, 21, 39, 0.6);
                        border: 1.5px solid rgba(255, 255, 255, 0.05);
                        color: #00ff41;
                        padding: 10px 20px;
                        border-radius: 10px;
                        font-weight: bold;
                        font-size: 13px;
                        text-decoration: none;
                        white-space: nowrap;
                        transition: all 0.25s;
                    }
                    .brand-filter-btn:hover {
                        border-color: #00ff41;
                        color: #fff;
                        background: rgba(0, 255, 65, 0.08);
                    }
                    .brand-filter-btn.active {
                        background: rgba(0, 255, 65, 0.15);
                        border-color: #00ff41;
                        color: #fff;
                        box-shadow: 0 0 15px rgba(0, 255, 65, 0.15);
                    }
                </style>
                <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_phone_review')); ?>" class="brand-filter-btn <?php echo !$current_term ? 'active' : ''; ?>">
                    <i class="fa-solid fa-microchip"></i> সকল ব্র্যান্ড
                </a>
                <?php 
                $terms = get_terms(['taxonomy' => 'phone_brand', 'hide_empty' => false]);
                if (!is_wp_error($terms) && !empty($terms)) :
                    foreach ($terms as $term) :
                        $is_active = ($current_term && $current_term->slug === $term->slug);
                        $term_link = get_term_link($term);
                        ?>
                        <a href="<?php echo esc_url($term_link); ?>" class="brand-filter-btn <?php echo $is_active ? 'active' : ''; ?>">
                            <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                        </a>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </section>

        <!-- 5. MAIN REVIEW GRID -->
        <main class="review-bento-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 20px; margin-bottom: 50px;">
            <?php if (have_posts()) : while (have_posts()) : the_post(); 
                $post_id = get_the_ID();
                $permalink = get_permalink();
                $title = get_the_title();
                $content_html = get_the_content();

                // Get specs
                $specs_preview = [];
                preg_match_all('/<tr>(.*?)<\/tr>/is', $content_html, $matches);
                if (!empty($matches[1])) {
                    $cnt = 0;
                    foreach ($matches[1] as $row) {
                        if (preg_match_all('/<td>(.*?)<\/td>/is', $row, $cells)) {
                            if (count($cells[1]) >= 2 && $cnt < 3) {
                                $key = trim(strip_tags($cells[1][0]));
                                $val = trim(strip_tags($cells[1][1]));
                                if (!empty($key) && !empty($val) && strlen($key) < 20 && strlen($val) < 35) {
                                    $specs_preview[] = ['key' => $key, 'val' => $val];
                                    $cnt++;
                                }
                            }
                        }
                    }
                }

                if (empty($specs_preview)) {
                    $specs_preview[] = ['key' => 'Processor', 'val' => 'Flagship Octa-Core Chipset'];
                    $specs_preview[] = ['key' => 'Battery', 'val' => '5500 mAh Liquid Battery'];
                    $specs_preview[] = ['key' => 'Status', 'val' => 'Reviewed & Certified'];
                }

                // Extract price tag
                $price_text = 'BDT Price Live';
                foreach ($specs_preview as $spec) {
                    if (stripos($spec['key'], 'price') !== false || stripos($spec['key'], 'মূল্য') !== false || stripos($spec['key'], 'BDT') !== false) {
                        $price_text = $spec['val'];
                    }
                }

                // Get Brand Term
                $post_brands = wp_get_post_terms($post_id, 'phone_brand');
                $brand_slug = !empty($post_brands) ? $post_brands[0]->slug : 'generic';
                $brand_name = !empty($post_brands) ? $post_brands[0]->name : 'REVIEW';

                // Brand theme color
                $brand_themes = [
                    'apple'   => ['color' => '#e2e8f0', 'bg' => 'rgba(226, 232, 240, 0.08)', 'border' => 'rgba(226, 232, 240, 0.2)'],
                    'samsung' => ['color' => '#c084fc', 'bg' => 'rgba(192, 132, 252, 0.08)', 'border' => 'rgba(192, 132, 252, 0.2)'],
                    'xiaomi'  => ['color' => '#ff6b35', 'bg' => 'rgba(255, 107, 53, 0.08)', 'border' => 'rgba(255, 107, 53, 0.2)'],
                    'oneplus' => ['color' => '#ff003c', 'bg' => 'rgba(255, 0, 60, 0.08)', 'border' => 'rgba(255, 0, 60, 0.2)'],
                ];
                $theme = isset($brand_themes[$brand_slug]) ? $brand_themes[$brand_slug] : ['color' => '#00ff41', 'bg' => 'rgba(0, 255, 65, 0.08)', 'border' => 'rgba(0, 255, 65, 0.2)'];
            ?>
                
                <article class="gadget-review-card" style="background: #0d1527; border: 1.5px solid <?php echo $theme['border']; ?>; border-radius: 14px; padding: 20px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;">
                    <style>
                        .gadget-review-card:hover {
                            border-color: <?php echo $theme['color']; ?>;
                            box-shadow: 0 8px 25px <?php echo $theme['bg']; ?>;
                            transform: translateY(-2px);
                        }
                    </style>
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at top right, <?php echo $theme['bg']; ?> 0%, transparent 60%); pointer-events: none;"></div>

                    <div>
                        <!-- Header metadata -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span style="font-size: 9px; font-weight: 800; color: <?php echo $theme['color']; ?>; background: <?php echo $theme['bg']; ?>; border: 1px solid <?php echo $theme['border']; ?>; padding: 3px 6px; border-radius: 4px; text-transform: uppercase;">
                                <i class="fa-solid fa-mobile-screen-button"></i> <?php echo esc_html($brand_name); ?>
                            </span>
                            <span style="font-size: 10px; font-weight: bold; color: #cbd5e0;">
                                <i class="fa-solid fa-star" style="color: #ffb703;"></i> ৯.৫/১০
                            </span>
                        </div>

                        <!-- Card Title -->
                        <h3 style="font-size: 14.5px; font-weight: 800; margin: 0 0 12px 0; line-height: 1.4;">
                            <a href="<?php echo esc_url($permalink); ?>" style="color: #fff; text-decoration: none;" onmouseover="this.style.color='<?php echo $theme['color']; ?>'" onmouseout="this.style.color='#fff'">
                                <?php echo esc_html($title); ?>
                            </a>
                        </h3>

                        <!-- Specifications panel -->
                        <div style="background: rgba(7, 11, 19, 0.6); border: 1px solid rgba(255,255,255,0.03); border-radius: 8px; padding: 12px; margin-bottom: 15px; display: flex; flex-direction: column; gap: 6px;">
                            <?php foreach ($specs_preview as $spec) : ?>
                                <div style="display: flex; justify-content: space-between; font-size: 11.5px; border-bottom: 1px dashed rgba(255,255,255,0.04); padding-bottom: 4px;">
                                    <span style="color: #8b949e; font-weight: 500;"><?php echo esc_html($spec['key']); ?>:</span>
                                    <span style="color: #ffffff; font-weight: bold; max-width: 150px; text-align: right; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo esc_html($spec['val']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Footer / BDT Price / Read More Button (Green) -->
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 12px; margin-top: 10px; gap: 10px;">
                        <span style="font-size: 12.5px; font-weight: 800; color: <?php echo $theme['color']; ?>; text-shadow: 0 0 6px <?php echo $theme['bg']; ?>;">
                            <?php echo esc_html($price_text); ?>
                        </span>
                        
                        <a href="<?php echo esc_url($permalink); ?>" aria-label="Read more about <?php echo esc_attr($title); ?>" style="background: linear-gradient(135deg, rgba(0, 255, 136, 0.08) 0%, rgba(0, 180, 100, 0.15) 100%); border: 1.5px solid #00ff88; color: #00ff88 !important; padding: 8px 16px; border-radius: 6px; font-weight: bold; font-size: 12px; text-shadow: 0 0 10px rgba(0,255,136,0.2); transition: all 0.25s; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                            বিস্তারিত পড়ুন / Read Review <span style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">about <?php the_title(); ?></span> <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>

                </article>

            <?php endwhile; else : ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background: #0d1527; border-radius: 15px; border: 1px dashed rgba(255,255,255,0.05);">
                    <p style="color: #8b949e; font-size: 15px;">দুঃখিত, এই ক্যাটাগরিতে এখনো কোনো ডিভাইস রিভিউ করা হয়নি।</p>
                </div>
            <?php endif; ?>
        </main>

        <!-- 6. CYBER PAGINATION CONTAINER -->
        <div class="cyber-pagination-container" style="display: flex; justify-content: center; margin-bottom: 60px;">
            <style>
                .cyber-pagination-container .navigation { display: flex; gap: 8px; }
                .cyber-pagination-container .page-numbers {
                    background: #0d1527;
                    border: 1px solid rgba(0, 255, 65, 0.15);
                    color: #00ff41;
                    padding: 8px 16px;
                    border-radius: 8px;
                    text-decoration: none;
                    font-weight: bold;
                    font-size: 14px;
                    transition: all 0.2s;
                }
                .cyber-pagination-container .page-numbers:hover {
                    border-color: #00ff41;
                    color: #fff;
                    background: rgba(0, 255, 65, 0.05);
                }
                .cyber-pagination-container .page-numbers.current {
                    background: rgba(0, 255, 65, 0.15);
                    border-color: #00ff41;
                    color: #fff;
                    box-shadow: 0 0 10px rgba(0,255,65,0.2);
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

        <!-- 7. ORGANIC SHIELD: RELEVANT NAVIGATION INTERLINKS -->
        <section class="archive-recommendations" style="border-top: 1.5px solid rgba(255,255,255,0.04); padding-top: 40px; margin-top: 50px;">
            <h2 style="font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-cubes-stacked" style="color: #00ff41;"></i> অন্যান্য অনুষঙ্গ সমূহ (Core Portals)
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                
                <!-- Story recommendation -->
                <div style="background: rgba(13, 21, 39, 0.5); border: 1px solid rgba(157, 78, 221, 0.15); border-radius: 12px; padding: 20px; transition: all 0.25s;">
                    <div style="font-size: 10px; color: #c77dff; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; font-family: monospace;">📚 STORIES & NOVELS</div>
                    <h3 style="font-size: 15px; margin: 0 0 10px 0; color: #fff;">গল্পের আসর (Story Shelf)</h3>
                    <p style="font-size: 12px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">রোমাঞ্চকর রোমান্টিক, সাইবার থ্রিলার এবং রহস্যময় গল্পের এক অভাবনীয় ভান্ডার।</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_story')); ?>" style="display: inline-flex; align-items: center; gap: 5px; color: #c77dff; text-decoration: none; font-size: 12px; font-weight: bold;">
                        লাইব্রেরী ভিজিট করুন <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- SMS Center recommendation -->
                <div style="background: rgba(13, 21, 39, 0.5); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 20px; transition: all 0.25s;">
                    <div style="font-size: 10px; color: #00f0ff; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; font-family: monospace;">💬 SMS & STATUS</div>
                    <h3 style="font-size: 15px; margin: 0 0 10px 0; color: #fff;">এসএমএস ও স্ট্যাটাস হাব</h3>
                    <p style="font-size: 12px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">আপনার সামাজিক ভাব বিনিময়ের জন্য সর্বাধুনিক বাংলা স্ট্যাটাস কালেকশন।</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_sms')); ?>" style="display: inline-flex; align-items: center; gap: 5px; color: #00f0ff; text-decoration: none; font-size: 12px; font-weight: bold;">
                        এসএমএস সেন্টারে যান <i class="fa-solid fa-arrow-right"></i>
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
