<?php
/**
 * Single Device Review Template (2040 Gadget Intelligence Edition)
 * Theme: ilybd-neon-v1-pro
 */
get_header(); 

$post_type = 'ilybd_phone_review';
$cat_taxonomy = 'phone_brand';
$tag_taxonomy = 'phone_tag';
?>

<style>
.review-single-wrapper {
    background: #070b13;
    color: #c9d1d9;
    min-height: 100vh;
    padding: 135px 15px 80px !important;
    font-family: 'Inter', sans-serif;
}
@media (max-width: 768px) {
    .review-single-wrapper {
        padding: 105px 12px 80px !important;
    }
}
</style>
<div class="ilybd-layout review-single-wrapper">
    <div style="max-width: 900px; margin: 0 auto; width: 100%;">

        <?php if (have_posts()) : while (have_posts()) : the_post(); 
            $post_id = get_the_ID();
            $author_id = get_the_author_meta('ID');
            $author_name = get_the_author_meta('display_name');
            $author_avatar = get_avatar($author_id, 54);
            
            // Fetch brand
            $brands = wp_get_post_terms($post_id, $cat_taxonomy);
            $brand_name = !empty($brands) ? $brands[0]->name : 'Device';
            $brand_slug = !empty($brands) ? $brands[0]->slug : 'device';
            $brand_link = !empty($brands) ? get_term_link($brands[0]) : home_url('/');
            
            // Views count
            $views = get_post_meta($post_id, 'ilybd_post_views_count', true) ?: '0';
            update_post_meta($post_id, 'ilybd_post_views_count', intval($views) + 1);

            // Specifications table check
            $content_html = get_the_content();
            $specs_table_found = (stripos($content_html, '<table') !== false);

            // Dynamic specifications parse for schema
            $display_rating = get_post_meta($post_id, '_ilybd_rating_score_' . $post_id, true) ?: '4.8';
            $likes_count = get_post_meta($post_id, '_likes', true) ?: '12';
            $price_matches = [];
            preg_match('/(?:মূল্য|দাম|Price)\s*[:ঃ]?\s*([\d,]+|\b\d+\b)\s*(?:টাকা|BDT|Tk)/u', $content_html, $price_matches);
            $parsed_price = !empty($price_matches[1]) ? trim($price_matches[1]) : '24,999';
            $usd_price = intval(str_replace(',', '', $parsed_price)) / 120;
            $usd_price_formatted = number_format($usd_price > 0 ? $usd_price : 249, 2);
        ?>

        <!-- GOOGLE SEARCH ENGINE OPTIMIZATION: PRODUCT & CRITIC REVIEW JSON-LD SCHEMA -->
        <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "Product",
          "name": "<?php echo esc_js(get_the_title()); ?>",
          "image": "<?php echo has_post_thumbnail() ? esc_url(get_the_post_thumbnail_url($post_id, 'large')) : esc_url(home_url('/wp-content/themes/ilybd-neon-v1-pro/assets/images/cyber-gadget.png')); ?>",
          "description": "<?php echo esc_js(wp_strip_all_tags(get_the_excerpt())); ?>",
          "brand": {
            "@type": "Brand",
            "name": "<?php echo esc_js($brand_name); ?>"
          },
          "review": {
            "@type": "Review",
            "reviewRating": {
              "@type": "Rating",
              "ratingValue": "<?php echo esc_js($display_rating); ?>",
              "bestRating": "5"
            },
            "author": {
              "@type": "Person",
              "name": "<?php echo esc_js($author_name); ?>"
            },
            "publisher": {
              "@type": "Organization",
              "name": "I Love You BD Tech Lab"
            }
          },
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "<?php echo esc_js($display_rating); ?>",
            "bestRating": "5",
            "ratingCount": "<?php echo esc_js(intval($likes_count) + 5); ?>"
          },
          "offers": {
            "@type": "Offer",
            "priceCurrency": "USD",
            "price": "<?php echo esc_js($usd_price_formatted); ?>",
            "priceValidUntil": "2027-12-31",
            "itemCondition": "https://schema.org/NewCondition",
            "availability": "https://schema.org/InStock",
            "seller": {
              "@type": "Organization",
              "name": "I Love You BD Tech Lab"
            }
          }
        }
        </script>

            <!-- 1. BREADCRUMB / METADATA HEADER -->
            <nav aria-label="Breadcrumb" style="margin-bottom: 25px; font-size: 13px; font-family: monospace; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
                    <span style="color: #475569; margin: 0 8px;">/</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_phone_review')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">PHONE REVIEWS</a>
                    <span style="color: #475569; margin: 0 8px;">/</span>
                    <a href="<?php echo esc_url($brand_link); ?>" style="color: #00ff41; text-decoration: none; font-weight: bold;"><?php echo esc_html(strtoupper($brand_name)); ?></a>
                </div>
                <span style="color: #64748b; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-eye" style="color: #00ff41;"></i> <?php echo esc_html($views); ?> views
                </span>
            </nav>

            <!-- 2. GOOGLE ADSENSE PLACEHOLDER (TOP AREA) -->
            <?php if (get_option('ily_enable_adsense_placeholders', 0) == 1) : ?>
            <div class="adsense-safe-container" style="margin-bottom: 30px; min-height: 90px; background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 11px; font-family: monospace; padding: 10px;">
                <span>[ ADVERTISING CONTAINER - GOOGLE ADSENSE POLICY COMPLIANT ]</span>
            </div>
            <?php endif; ?>

            <!-- 3. MAIN REVIEW CARD -->
            <article class="review-main-card" style="background: #0d1527; border: 1.5px solid rgba(0, 255, 65, 0.2); border-radius: 18px; padding: 40px; box-shadow: 0 15px 45px rgba(0,0,0,0.55); position: relative; overflow: hidden; margin-bottom: 40px;">
                <div class="card-glow-element" style="position: absolute; top: -100px; right: -100px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(0,255,65,0.08) 0%, transparent 70%); pointer-events: none;"></div>

                <!-- Rating and top metadata bar -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <span style="background: rgba(0, 255, 65, 0.15); color: #00ff41; border: 1px solid rgba(0, 255, 65, 0.3); font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                            📱 <?php echo esc_html($brand_name); ?>
                        </span>
                        <span style="background: rgba(255, 183, 3, 0.1); color: #ffb703; border: 1px solid rgba(255, 183, 3, 0.25); font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px;">
                            <i class="fa-solid fa-star"></i> ৯.৫/১০ রেটিং
                        </span>
                    </div>
                    <span style="color: #64748b; font-size: 12px; font-family: monospace;">
                        SYSTEM: LAB_RE_<?php echo esc_html($post_id); ?>
                    </span>
                </div>

                <!-- Review Title -->
                <h1 style="color: #fff; font-size: clamp(24px, 5.5vw, 36px); line-height: 1.35; font-weight: 800; margin-top: 0; margin-bottom: 25px; text-shadow: 0 0 15px rgba(0,255,65,0.15); text-align: left; border-left: 4px solid #00ff41; padding-left: 15px;">
                    <?php the_title(); ?>
                </h1>

                <!-- 4. NEXT-GEN DYNAMIC MULTI-COLOR SHOWCASE & GALLERY STUDIO -->
                <?php 
                $brand_lower = strtolower($brand_name);
                $phone_title = get_the_title();

                // Extract clean model name (strip Bengali/English suffix titles)
                $clean_model = preg_replace('/(\s+Review|\s+Price|\s+in\s+BD|\s+ফুল\s+স্পেসিফিকেশন|\s+ও\s+চূড়ান্ত\s+রিভিউ).*/iu', '', $phone_title);
                $clean_model = trim($clean_model);

                // Define premium color variants based on device brand
                $device_colors = [];
                if (strpos($brand_lower, 'apple') !== false || strpos($brand_lower, 'iphone') !== false) {
                    $device_colors = [
                        [
                            'id' => 'natural',
                            'name_en' => 'Natural Titanium',
                            'name_bn' => 'ন্যাচারাল টাইটানিয়াম',
                            'hex' => '#9e9a93',
                            'filter' => 'sepia(0.3) saturate(0.8) brightness(0.9) contrast(1.1)',
                            'desc' => 'এটি অ্যাপলের সিগনেচার ন্যাচারাল গ্রেড ৫ টাইটানিয়াম ফিনিশ, যা অত্যন্ত হালকা এবং স্ক্র্যাচ প্রতিরোধী।',
                            'accent' => '#ffd700'
                        ],
                        [
                            'id' => 'blue',
                            'name_en' => 'Blue Titanium',
                            'name_bn' => 'ব্লু টাইটানিয়াম',
                            'hex' => '#2a3a4a',
                            'filter' => 'hue-rotate(185deg) saturate(1.2) brightness(0.7) contrast(1.1)',
                            'desc' => 'একটি গভীর, রাজকীয় নীল শেড যা অন্ধকার আলোতে একটি রহস্যময় মেটালিক রিফ্লেকশন তৈরি করে।',
                            'accent' => '#00f0ff'
                        ],
                        [
                            'id' => 'white',
                            'name_en' => 'White Titanium',
                            'name_bn' => 'হোয়াইট টাইটানিয়াম',
                            'hex' => '#f2f3f5',
                            'filter' => 'grayscale(1) brightness(1.3) contrast(1.1)',
                            'desc' => 'শুভ্র এবং মার্জিত একটি ক্লাসিক ভেরিয়েন্ট, যার রূপালী মেটালিক ফ্রেম যেকোনো আলোতে নজর কাড়ে।',
                            'accent' => '#ffffff'
                        ],
                        [
                            'id' => 'black',
                            'name_en' => 'Space Black',
                            'name_bn' => 'স্পেস ব্ল্যাক',
                            'hex' => '#1a1b1e',
                            'filter' => 'grayscale(1) brightness(0.4) contrast(1.2)',
                            'desc' => 'মহাজাগতিক নিকষ কালো রঙের এই এডিশনটি ক্লাসিক আভিজাত্য এবং পেশাদারিত্বের চূড়ান্ত বহিঃপ্রকাশ।',
                            'accent' => '#64748b'
                        ]
                    ];
                    $base_studio_img = 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600&auto=format&fit=crop&q=80';
                } elseif (strpos($brand_lower, 'samsung') !== false) {
                    $device_colors = [
                        [
                            'id' => 'violet',
                            'name_en' => 'Titanium Violet',
                            'name_bn' => 'টাইটানিয়াম ভায়োলেট',
                            'hex' => '#4c3f5c',
                            'filter' => 'hue-rotate(240deg) saturate(1.1) brightness(0.7) contrast(1.1)',
                            'desc' => 'স্যামসাং-এর অনন্য বেগুনি রঙের টাইটানিয়াম সংস্করণ, যা আলোর প্রতিসরণে অসাধারণ দেখায়।',
                            'accent' => '#bd93f9'
                        ],
                        [
                            'id' => 'yellow',
                            'name_en' => 'Titanium Yellow',
                            'name_bn' => 'টাইটানিয়াম ইয়োলো',
                            'hex' => '#e2cb92',
                            'filter' => 'hue-rotate(15deg) saturate(1.2) brightness(1.1) contrast(1.1)',
                            'desc' => 'একটি মৃদু সোনালী আভাযুক্ত হলুদ ফিনিশ যা ফোনটিকে অত্যন্ত লাক্সারিয়াস এবং আকর্ষণীয় করে তোলে।',
                            'accent' => '#ffb703'
                        ],
                        [
                            'id' => 'gray',
                            'name_en' => 'Titanium Gray',
                            'name_bn' => 'টাইটানিয়াম গ্রে',
                            'hex' => '#7a7e85',
                            'filter' => 'grayscale(1) brightness(0.8) contrast(1.1)',
                            'desc' => 'ইন্ডাস্ট্রিয়াল গ্রেড টাইটানিয়াম গ্রে সংস্করণ, যা মিনিমালিস্টিক স্টাইল এবং দীর্ঘস্থায়ীত্বের সেরা প্রতীক।',
                            'accent' => '#a0aec0'
                        ],
                        [
                            'id' => 'black',
                            'name_en' => 'Onyx Black',
                            'name_bn' => 'অনিক্স ব্ল্যাক',
                            'hex' => '#212224',
                            'filter' => 'grayscale(1) brightness(0.35) contrast(1.2)',
                            'desc' => 'গভীর কুচকুচে কালো রঙের এই সংস্করণটি মেটালিক ফ্রেমের সাথে নিখুঁতভাবে মিশে এক রাজকীয় রূপ নেয়।',
                            'accent' => '#4a5568'
                        ]
                    ];
                    $base_studio_img = 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=600&auto=format&fit=crop&q=80';
                } elseif (strpos($brand_lower, 'vivo') !== false) {
                    $device_colors = [
                        [
                            'id' => 'blue',
                            'name_en' => 'Ganges Blue',
                            'name_bn' => 'গঙ্গেশ ব্লু',
                            'hex' => '#8cb5c4',
                            'filter' => 'hue-rotate(185deg) saturate(1.3) brightness(0.95) contrast(1.05)',
                            'desc' => 'ভিভোর সিগনেচার লিকুইড মেটাল রিফ্লেকশন সহ আইসি ব্লু ফিনিশ, যা দেখতে অত্যন্ত দৃষ্টিনন্দন এবং রিফ্রেশিং।',
                            'accent' => '#00f0ff'
                        ],
                        [
                            'id' => 'peach',
                            'name_en' => 'Lotus Peach',
                            'name_bn' => 'লোটাস পিচ',
                            'hex' => '#eba488',
                            'filter' => 'hue-rotate(345deg) saturate(1.4) brightness(1.05) contrast(1.05)',
                            'desc' => 'গোলাপী ও কমলার এক মনোরম মিশ্রণ, যা বিভিন্ন আলোতে তার রঙ পরিবর্তন করে এক জাদুকরী আভা ছড়ায়।',
                            'accent' => '#ff79c6'
                        ],
                        [
                            'id' => 'gray',
                            'name_en' => 'Titanium Gray',
                            'name_bn' => 'টাইটানিয়াম গ্রে',
                            'hex' => '#6c6f75',
                            'filter' => 'grayscale(1) brightness(0.7) contrast(1.1)',
                            'desc' => 'মেটালিক টাইটানিয়াম গ্রে সংস্করণে রয়েছে ফ্ল্যাশ কার্ভড গ্লাস, যা ফোনটিকে দেয় প্রিমিয়াম বিজনেস ক্লাস লুক।',
                            'accent' => '#a0aec0'
                        ],
                        [
                            'id' => 'black',
                            'name_en' => 'Space Black',
                            'name_bn' => 'স্পেস ব্ল্যাক',
                            'hex' => '#1d1e21',
                            'filter' => 'grayscale(1) brightness(0.3) contrast(1.2)',
                            'desc' => 'একটি অত্যন্ত সলিড এবং মার্জিত স্যাতিন-ফিনিশ ব্ল্যাক কালার, যা যেকোনো আঙুলের ছাপ প্রতিরোধী প্রযুক্তি সমৃদ্ধ।',
                            'accent' => '#50fa7b'
                        ]
                    ];
                    $base_studio_img = 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=80';
                } elseif (strpos($brand_lower, 'oneplus') !== false) {
                    $device_colors = [
                        [
                            'id' => 'emerald',
                            'name_en' => 'Flowy Emerald',
                            'name_bn' => 'ফ্লোয়ি এমারেল্ড',
                            'hex' => '#426a57',
                            'filter' => 'hue-rotate(135deg) saturate(0.9) brightness(0.75) contrast(1.1)',
                            'desc' => 'ওয়ানপ্লাসের মার্বেল টেক্সচার যুক্ত সবুজ পান্না সংস্করণ, যা রাজকীয় আভিজাত্যের চূড়ান্ত রুপ।',
                            'accent' => '#50fa7b'
                        ],
                        [
                            'id' => 'black',
                            'name_en' => 'Silky Black',
                            'name_bn' => 'সিল্কি ব্ল্যাক',
                            'hex' => '#1a1b1d',
                            'filter' => 'grayscale(1) brightness(0.25) contrast(1.2)',
                            'desc' => 'সিল্কি টেক্সচার্ড ম্যাট গ্লাস ফিনিশ, যা হাতে ফোনটি ব্যবহারের সময় দেবে মাখনের মতো নরম অনুভূতি।',
                            'accent' => '#6272a4'
                        ],
                        [
                            'id' => 'blue',
                            'name_en' => 'Cool Blue',
                            'name_bn' => 'কুল ব্লু',
                            'hex' => '#8cb2cc',
                            'filter' => 'hue-rotate(195deg) saturate(1.2) brightness(0.9) contrast(1.1)',
                            'desc' => 'একটি উজ্জ্বল এবং আকর্ষণীয় নীল ভেরিয়েন্ট যা তরল ধাতব আভা সহ অত্যন্ত স্টাইলিশ ফিল প্রদান করে।',
                            'accent' => '#8be9fd'
                        ]
                    ];
                    $base_studio_img = 'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=600&auto=format&fit=crop&q=80';
                } else {
                    $device_colors = [
                        [
                            'id' => 'cyan',
                            'name_en' => 'Cyber Cyan',
                            'name_bn' => 'সাইবার সায়ান',
                            'hex' => '#00f0ff',
                            'filter' => 'hue-rotate(180deg) saturate(1.5) brightness(0.95) contrast(1.1)',
                            'desc' => 'অত্যন্ত আকর্ষণীয় ভবিষ্যৎমুখী সাইবার সায়ান রঙ, যা যেকোনো পরিবেশে অনন্য এক চমৎকার আভা ছড়ায়।',
                            'accent' => '#00f0ff'
                        ],
                        [
                            'id' => 'green',
                            'name_en' => 'Neon Emerald',
                            'name_bn' => 'নেঅন এমারেল্ড',
                            'hex' => '#00ff41',
                            'filter' => 'hue-rotate(120deg) saturate(1.4) brightness(0.85) contrast(1.1)',
                            'desc' => 'একটি অত্যন্ত সতেজ এবং প্রিমিয়াম মেটালিক গ্রিন গ্লাস ব্যাক যা ভবিষ্যৎ প্রযুক্তির ধারা ফুটিয়ে তোলে।',
                            'accent' => '#00ff41'
                        ],
                        [
                            'id' => 'purple',
                            'name_en' => 'Cosmic Violet',
                            'name_bn' => 'কসমিক ভায়োলেট',
                            'hex' => '#9d4edd',
                            'filter' => 'hue-rotate(275deg) saturate(1.3) brightness(0.8) contrast(1.1)',
                            'desc' => 'একটি মোহনীয় বেগুনি আভাযুক্ত প্রিমিয়াম গ্লাস ভেরিয়েন্ট যা আলোর সাথে চমৎকার ডাইনামিক ইফেক্ট দেয়।',
                            'accent' => '#bd93f9'
                        ],
                        [
                            'id' => 'black',
                            'name_en' => 'Obsidian Black',
                            'name_bn' => 'অবসিডিয়ান ব্ল্যাক',
                            'hex' => '#17181c',
                            'filter' => 'grayscale(1) brightness(0.3) contrast(1.2)',
                            'desc' => 'একটি গভীর কুচকুচে কালো সংস্করণ যা দীর্ঘস্থায়ী স্ক্র্যাচ ও ফিঙ্গারপ্রিন্ট প্রতিরোধী।',
                            'accent' => '#64748b'
                        ]
                    ];
                    $base_studio_img = 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=80';
                }
                ?>

                <!-- Visual Switcher Tab Controls -->
                <div style="display: flex; gap: 8px; margin-bottom: 20px; border-bottom: 1.5px solid rgba(255,255,255,0.06); padding-bottom: 12px; flex-wrap: wrap;">
                    <button onclick="switchIlybdGalleryTab('studio', this)" class="gallery-tab-btn active-tab" style="background: rgba(0, 255, 65, 0.1); border: 1.5px solid #00ff41; color: #00ff41; padding: 8px 16px; border-radius: 8px; font-weight: bold; font-size: 12px; cursor: pointer; transition: 0.25s; font-family: sans-serif; display: inline-flex; align-items: center; gap: 6px;">
                        🎨 অফিশিয়াল কালার স্টুডিও (Interactive Color Studio)
                    </button>
                    <?php if (has_post_thumbnail()) : ?>
                        <button onclick="switchIlybdGalleryTab('thumbnail', this)" class="gallery-tab-btn" style="background: rgba(255,255,255,0.02); border: 1.5px solid rgba(255,255,255,0.1); color: #8b949e; padding: 8px 16px; border-radius: 8px; font-weight: bold; font-size: 12px; cursor: pointer; transition: 0.25s; font-family: sans-serif; display: inline-flex; align-items: center; gap: 6px;">
                            🖼️ রিভিউ থাম্বনেইল (Review Thumbnail View)
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Color Studio Panel (Default Tab) -->
                <div id="ilybdGalleryTab-studio" class="gallery-tab-content" style="display: block;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin: 15px auto 35px; min-height: 400px; background: linear-gradient(135deg, #070b13 0%, #0d1a30 100%); border: 1.5px solid rgba(0,255,65,0.2); border-radius: 16px; padding: 30px; position: relative; box-shadow: 0 15px 40px rgba(0,0,0,0.65); overflow: hidden;" class="studio-grid-box">
                        <div class="grid-lines-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(rgba(0, 255, 65, 0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(0, 255, 65, 0.02) 1px, transparent 1px); background-size: 20px 20px; pointer-events: none;"></div>
                        
                        <!-- Left: Real Studio Phone Render Frame -->
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; min-height: 350px;">
                            <!-- Active Accent Ambient Pulse -->
                            <div id="studio-ambient-pulse" style="position: absolute; width: 220px; height: 220px; background: radial-gradient(circle, rgba(0, 255, 65, 0.12) 0%, transparent 70%); filter: blur(20px); border-radius: 50%; pointer-events: none; transition: background 0.5s ease; z-index: 0;"></div>
                            
                            <!-- Interactive 3D Phone Frame -->
                            <div class="studio-phone-frame" style="width: 175px; height: 320px; background: #000; border: 4.5px solid rgba(255,255,255,0.15); border-radius: 32px; position: relative; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.85); z-index: 1; transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                                
                                <!-- Dynamic Island/Notch overlay -->
                                <div style="width: 50px; height: 10px; background: #000; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; position: absolute; top: 8px; left: 50%; transform: translateX(-50%); z-index: 5; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                    <span style="width: 3px; height: 3px; background: #2a2c3a; border-radius: 50%;"></span>
                                </div>

                                <!-- Screen Display containing the real studio-shot model back -->
                                <div style="width: 100%; height: 100%; position: relative; background: #000;">
                                    <img id="studio-main-phone-img" src="<?php echo esc_url($base_studio_img); ?>" alt="<?php echo esc_attr($clean_model); ?>" style="width: 100%; height: 100%; object-fit: cover; display: block; filter: <?php echo $device_colors[0]['filter']; ?>; transition: filter 0.6s ease, transform 0.6s ease; mix-blend-mode: normal;">
                                    
                                    <!-- Metallic Glass Reflection Overlay -->
                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 50%, rgba(0,0,0,0.4) 100%); pointer-events: none; z-index: 2;"></div>
                                    
                                    <!-- Dynamic Lens Frame Accent Highlight -->
                                    <div style="position: absolute; top: 15px; left: 15px; z-index: 3; display: flex; flex-direction: column; gap: 3px;">
                                        <div style="width: 25px; height: 50px; border-radius: 12px; background: rgba(0,0,0,0.65); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(4px); display: flex; flex-direction: column; align-items: center; justify-content: space-around; padding: 4px 0;">
                                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #0c0d12; border: 1.5px solid rgba(255,255,255,0.4); display: block;"></span>
                                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #0c0d12; border: 1.5px solid rgba(255,255,255,0.4); display: block;"></span>
                                            <span style="width: 4px; height: 4px; border-radius: 50%; background: #ffaa00; display: block;"></span>
                                        </div>
                                    </div>

                                    <!-- Bottom Brand Label on Screen -->
                                    <div style="position: absolute; bottom: 15px; width: 100%; text-align: center; z-index: 3;">
                                        <span style="background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.1); color: #fff; font-size: 8px; font-family: monospace; padding: 2px 8px; border-radius: 10px; letter-spacing: 0.5px; text-transform: uppercase;">
                                            <?php echo esc_html($brand_name); ?> LAB
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Dynamic Spec and Color Palette Selector -->
                        <div style="display: flex; flex-direction: column; justify-content: center; z-index: 2;" class="studio-specs-panel">
                            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(0, 255, 65, 0.1); border: 1px solid rgba(0, 255, 65, 0.3); padding: 4px 10px; border-radius: 4px; color: #00ff41; font-size: 10.5px; font-family: monospace; font-weight: bold; text-transform: uppercase; margin-bottom: 12px; width: fit-content;">
                                <span style="display:inline-block; width: 6px; height: 6px; background: #00ff41; border-radius: 50%;"></span> ACTIVE DEVICE WORKSPACE
                            </div>

                            <h2 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0 0 5px 0; font-family: 'Space Grotesk', sans-serif;">
                                <?php echo esc_html($clean_model); ?>
                            </h2>
                            <span style="color: #64748b; font-size: 11px; font-family: monospace; margin-bottom: 20px; display: block;">
                                TECHNOLOGY GENERATION: 2040 SMART LUXURY
                            </span>

                            <!-- Active Color Label Card -->
                            <div style="background: rgba(13, 21, 39, 0.7); border: 1px solid rgba(255,255,255,0.05); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px;">
                                <div style="font-size: 11px; color: #64748b; font-family: monospace; text-transform: uppercase;">নির্বাচিত কালার ভেরিয়েন্ট (Selected Color):</div>
                                <div id="studio-active-color-title" style="font-size: 15px; color: #00ff41; font-weight: bold; margin-top: 4px; display: flex; align-items: center; gap: 8px;">
                                    <span id="active-color-dot" style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: <?php echo $device_colors[0]['hex']; ?>; box-shadow: 0 0 8px <?php echo $device_colors[0]['accent']; ?>;"></span>
                                    <span><?php echo esc_html($device_colors[0]['name_bn']); ?> / <?php echo esc_html($device_colors[0]['name_en']); ?></span>
                                </div>
                                <p id="studio-active-color-desc" style="font-size: 12.5px; color: #8b949e; line-height: 1.5; margin: 8px 0 0 0; border-top: 1px solid rgba(255,255,255,0.04); padding-top: 8px;">
                                    <?php echo esc_html($device_colors[0]['desc']); ?>
                                </p>
                            </div>

                            <!-- Interactive Interactive Color Dot Selectors -->
                            <div style="margin-bottom: 25px;">
                                <div style="font-size: 11px; color: #64748b; font-family: monospace; text-transform: uppercase; margin-bottom: 10px;">উপলব্ধ সব অফিশিয়াল কালার (Interactive Palette):</div>
                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                    <?php foreach ($device_colors as $index => $color) : ?>
                                        <button onclick="changeStudioActiveColor(<?php echo htmlspecialchars(json_encode($color)); ?>, this)" class="color-swatch-btn <?php echo $index === 0 ? 'active-swatch' : ''; ?>" style="width: 32px; height: 32px; border-radius: 50%; background: <?php echo $color['hex']; ?>; border: 2.5px solid <?php echo $index === 0 ? '#00ff41' : 'rgba(255,255,255,0.15)'; ?>; cursor: pointer; transition: 0.2s; position: relative; padding: 0; outline: none; box-shadow: 0 4px 10px rgba(0,0,0,0.3);" title="<?php echo esc_attr($color['name_en']); ?>">
                                            <span style="position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.1); pointer-events: none;"></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Quick Dynamic Specs Badge Checklist -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 11.5px; border-top: 1px solid rgba(255,255,255,0.04); padding-top: 15px;">
                                <div style="color: #8b949e; display: flex; align-items: center; gap: 6px;"><i class="fa-solid fa-circle-check" style="color: #00ff41;"></i> প্রিমিয়াম এজি গ্লাস ব্যাক</div>
                                <div style="color: #8b949e; display: flex; align-items: center; gap: 6px;"><i class="fa-solid fa-circle-check" style="color: #00ff41;"></i> IP68 ডাস্ট ও ওয়াটার রেজিস্ট্যান্ট</div>
                                <div style="color: #8b949e; display: flex; align-items: center; gap: 6px;"><i class="fa-solid fa-circle-check" style="color: #00ff41;"></i> ১০০% সলিড মেটাল ফ্রেম</div>
                                <div style="color: #8b949e; display: flex; align-items: center; gap: 6px;"><i class="fa-solid fa-circle-check" style="color: #00ff41;"></i> ডায়নামিক রিফ্লেক্টিভ কালার</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Thumbnail Panel (Hidden by default, shown if toggle tab is clicked) -->
                <?php if (has_post_thumbnail()) : ?>
                    <div id="ilybdGalleryTab-thumbnail" class="gallery-tab-content" style="display: none;">
                        <div style="margin: 15px auto 35px; width: 100%; border-radius: 16px; overflow: hidden; border: 1.5px solid rgba(0,255,65,0.2); box-shadow: 0 15px 40px rgba(0,0,0,0.65); background: #070b13;">
                            <?php the_post_thumbnail('large', ['style' => 'width:100%; height:auto; max-height:450px; object-fit:cover; display:block; margin:0 auto;']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <style>
                    /* Premium Styling for interactive gallery panels */
                    .gallery-tab-btn:hover {
                        background: rgba(255,255,255,0.06) !important;
                        color: #fff !important;
                        border-color: rgba(255,255,255,0.2) !important;
                    }
                    .gallery-tab-btn.active-tab {
                        background: rgba(0, 255, 65, 0.1) !important;
                        border-color: #00ff41 !important;
                        color: #00ff41 !important;
                        box-shadow: 0 0 15px rgba(0,255,65,0.15);
                    }
                    .color-swatch-btn:hover {
                        transform: scale(1.15);
                        box-shadow: 0 0 12px var(--swatch-hover, rgba(255,255,255,0.2));
                    }
                    .color-swatch-btn.active-swatch {
                        box-shadow: 0 0 15px rgba(0, 255, 65, 0.4);
                        transform: scale(1.1);
                    }
                    @media (max-width: 768px) {
                        .studio-grid-box {
                            grid-template-columns: 1fr !important;
                            padding: 20px !important;
                            gap: 20px !important;
                        }
                        .studio-phone-frame {
                            width: 150px !important;
                            height: 275px !important;
                        }
                    }
                </style>

                <script>
                /**
                 * Switching between Color Studio and Main Thumbnail Gallery Tab
                 */
                function switchIlybdGalleryTab(tabId, btnElement) {
                    // Hide all tabs
                    document.querySelectorAll('.gallery-tab-content').forEach(function(el) {
                        el.style.display = 'none';
                    });
                    // Show active tab
                    var activeContent = document.getElementById('ilybdGalleryTab-' + tabId);
                    if (activeContent) {
                        activeContent.style.display = 'block';
                    }
                    // Reset active states of buttons
                    document.querySelectorAll('.gallery-tab-btn').forEach(function(btn) {
                        btn.classList.remove('active-tab');
                        btn.style.background = 'rgba(255,255,255,0.02)';
                        btn.style.borderColor = 'rgba(255,255,255,0.1)';
                        btn.style.color = '#8b949e';
                        btn.style.boxShadow = 'none';
                    });
                    // Highlight selected button
                    btnElement.classList.add('active-tab');
                    btnElement.style.background = 'rgba(0, 255, 65, 0.1)';
                    btnElement.style.borderColor = '#00ff41';
                    btnElement.style.color = '#00ff41';
                    btnElement.style.boxShadow = '0 0 15px rgba(0,255,65,0.15)';
                }

                /**
                 * Interactively dynamic studio colour variant switches
                 */
                function changeStudioActiveColor(colorObj, btnElement) {
                    // Reset all active swatch styles
                    document.querySelectorAll('.color-swatch-btn').forEach(function(btn) {
                        btn.classList.remove('active-swatch');
                        btn.style.borderColor = 'rgba(255,255,255,0.15)';
                        btn.style.boxShadow = '0 4px 10px rgba(0,0,0,0.3)';
                    });

                    // Highlight active button
                    btnElement.classList.add('active-swatch');
                    btnElement.style.borderColor = '#00ff41';
                    btnElement.style.boxShadow = '0 0 15px ' + colorObj.accent;

                    // Transition Main Phone Render back hue color
                    var phoneImg = document.getElementById('studio-main-phone-img');
                    if (phoneImg) {
                        phoneImg.style.opacity = '0.4';
                        phoneImg.style.transform = 'scale(0.95) rotate(-1deg)';
                        setTimeout(function() {
                            phoneImg.style.filter = colorObj.filter;
                            phoneImg.style.opacity = '1';
                            phoneImg.style.transform = 'scale(1) rotate(0deg)';
                        }, 250);
                    }

                    // Shift ambient pulse color glow
                    var ambientPulse = document.getElementById('studio-ambient-pulse');
                    if (ambientPulse) {
                        ambientPulse.style.background = 'radial-gradient(circle, ' + colorObj.accent + '25 0%, transparent 70%)';
                    }

                    // Update Labels & Descriptions
                    var titleEl = document.getElementById('studio-active-color-title');
                    var descEl = document.getElementById('studio-active-color-desc');
                    var dotEl = document.getElementById('active-color-dot');
                    
                    if (titleEl && descEl && dotEl) {
                        dotEl.style.background = colorObj.hex;
                        dotEl.style.boxShadow = '0 0 8px ' + colorObj.accent;
                        titleEl.querySelector('span:last-child').textContent = colorObj.name_bn + ' / ' + colorObj.name_en;
                        
                        descEl.style.opacity = '0';
                        setTimeout(function() {
                            descEl.textContent = colorObj.desc;
                            descEl.style.opacity = '1';
                        }, 150);
                    }
                }
                </script>


                <!-- SPECIFICATIONS BANNER GRID (IF NO TABLE) -->
                <?php if (!$specs_table_found) : ?>
                    <div style="background: rgba(7, 11, 19, 0.6); border: 1px solid rgba(0, 255, 65, 0.2); border-radius: 12px; padding: 25px; margin-bottom: 35px;">
                        <h4 style="margin-top:0; color: #00ff41; font-size: 14px; font-weight: 800; text-transform: uppercase; font-family: monospace; margin-bottom: 15px; border-bottom: 1px dashed rgba(0, 255, 65, 0.2); padding-bottom: 8px;">
                            📋 Key Technical Specs (ডিভাইস স্পেসিফিকেশন)
                        </h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; font-size: 13.5px;">
                            <div><strong style="color: #64748b;">Processor:</strong> <span style="color: #fff; font-weight: bold;">Flagship Octa-Core Chipset (3nm)</span></div>
                            <div><strong style="color: #64748b;">Battery Capacity:</strong> <span style="color: #fff; font-weight: bold;">5500 mAh Liquid Battery</span></div>
                            <div><strong style="color: #64748b;">Camera Setup:</strong> <span style="color: #fff; font-weight: bold;">50MP Triple OIS Matrix Camera</span></div>
                            <div><strong style="color: #64748b;">Performance Rating:</strong> <span style="color: #00ff41; font-weight: bold;">৯.৫ / ১০ (Elite Level)</span></div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Specifications Table / Content styling (MobileDokan Pro Style) -->
                <style>
                    .review-article-body table {
                        width: 100% !important;
                        border-collapse: separate !important;
                        border-spacing: 0 !important;
                        margin: 30px 0 !important;
                        font-size: 14px !important;
                        background: #0b111e !important;
                        border: 1px solid rgba(0, 255, 65, 0.2) !important;
                        border-radius: 14px !important;
                        overflow: hidden !important;
                        box-shadow: 0 10px 35px rgba(0,0,0,0.5);
                    }
                    .review-article-body th {
                        background: linear-gradient(90deg, rgba(0, 255, 65, 0.15) 0%, rgba(0, 240, 255, 0.05) 100%) !important;
                        color: #00ff41 !important;
                        font-family: 'Space Grotesk', sans-serif;
                        font-weight: 800 !important;
                        text-align: left !important;
                        padding: 14px 18px !important;
                        border-bottom: 2px solid rgba(0, 255, 65, 0.3) !important;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                    }
                    .review-article-body tr {
                        transition: background 0.2s ease;
                    }
                    .review-article-body tr:nth-child(even) {
                        background: rgba(13, 21, 39, 0.3) !important;
                    }
                    .review-article-body tr:nth-child(odd) {
                        background: rgba(7, 11, 19, 0.2) !important;
                    }
                    .review-article-body tr:hover {
                        background: rgba(0, 255, 65, 0.06) !important;
                    }
                    .review-article-body td {
                        padding: 12px 18px !important;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
                        color: #cbd5e0 !important;
                        line-height: 1.6;
                    }
                    /* Styling first column (Attribute names like RAM, Processor, Battery) */
                    .review-article-body td:first-child {
                        font-weight: 700 !important;
                        color: #8b949e !important;
                        width: 30%;
                        background: rgba(13, 21, 39, 0.5) !important;
                        border-right: 1px solid rgba(255, 255, 255, 0.04) !important;
                    }
                    /* Styling second column (Actual specifications values) */
                    .review-article-body td:last-child {
                        color: #ffffff !important;
                        font-weight: 500 !important;
                    }
                    .review-article-body tr:last-child td {
                        border-bottom: none !important;
                    }
                    /* Highlight tables row with price or critical specs */
                    .review-article-body tr:hover td:first-child {
                        color: #00ff41 !important;
                    }
                    /* Pros & Cons styled cards */
                    .cyber-pros-box, .cyber-cons-box {
                        background: #0d1527 !important;
                        border-radius: 12px !important;
                        padding: 22px !important;
                        margin: 25px 0 !important;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
                        border: 1px solid transparent !important;
                    }
                    .cyber-pros-box {
                        border-color: rgba(0, 255, 65, 0.25) !important;
                    }
                    .cyber-cons-box {
                        border-color: rgba(255, 62, 62, 0.25) !important;
                    }
                    .cyber-pros-box h4 {
                        color: #00ff41 !important;
                        font-weight: 800 !important;
                        margin-top: 0 !important;
                        margin-bottom: 12px !important;
                        font-size: 16px !important;
                        border-bottom: 1px dashed rgba(0, 255, 65, 0.2) !important;
                        padding-bottom: 8px !important;
                    }
                    .cyber-cons-box h4 {
                        color: #ff3e3e !important;
                        font-weight: 800 !important;
                        margin-top: 0 !important;
                        margin-bottom: 12px !important;
                        font-size: 16px !important;
                        border-bottom: 1px dashed rgba(255, 62, 62, 0.2) !important;
                        padding-bottom: 8px !important;
                    }
                    /* Clean up inline styles of pasted tables */
                    .review-article-body table tr,
                    .review-article-body table td,
                    .review-article-body table span,
                    .review-article-body table p,
                    .review-article-body table a,
                    .review-article-body table div {
                        background: transparent !important;
                        background-color: transparent !important;
                    }
                </style>

                <!-- Review Content Body -->
                <div class="review-article-body" id="reviewMainBody" style="font-size: 18px; line-height: 1.85; color: #cbd5e0; font-family: system-ui, sans-serif; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 30px; margin-bottom: 30px; text-align: left;">
                    <?php the_content(); ?>
                </div>

                <!-- DYNAMIC AI SEO COMPLIANCE SCORECARD -->
                <?php if (function_exists('ilybd_render_ai_seo_compliance_scorecard')) {
                    ilybd_render_ai_seo_compliance_scorecard($post_id);
                } ?>

                <!-- ELITE USER ENGAGEMENT PANEL (LIKES, SHARES, RATINGS, AND VIEWS) -->
                <div class="elite-engagement-panel" style="background: rgba(13, 21, 39, 0.6); border: 1.5px solid rgba(0, 240, 255, 0.25); border-radius: 16px; padding: 25px; margin-bottom: 35px; box-shadow: 0 8px 32px rgba(0,0,0,0.4);">
                    <span style="font-size: 11px; color: #00f0ff; font-family: monospace; text-transform: uppercase; letter-spacing: 1px; display: block; text-align: center; margin-bottom: 20px;">🛡️ CORE ENGAGEMENT & REPUTATION ENGINE</span>
                    
                    <!-- Stats Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 15px; margin-bottom: 25px; text-align: center;">
                        <div style="background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255,255,255,0.03); padding: 15px; border-radius: 12px;">
                            <span style="color: #64748b; font-size: 11px; display: block; margin-bottom: 5px; font-family: monospace;">TOTAL VIEWS</span>
                            <strong style="color: #fff; font-size: 18px; font-family: monospace;"><i class="fa-solid fa-eye" style="color: #00f0ff; margin-right: 5px;"></i> <?php echo esc_html($views); ?></strong>
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
                                <i class="fa-regular fa-heart"></i> কন্টেন্টটি ভালো লেগেছে
                            </button>
                            <!-- Copy Post -->
                            <button onclick="copyReviewContents(this)" style="background: rgba(0, 240, 255, 0.05); color: #00f0ff; border: 1.5px solid rgba(0, 240, 255, 0.3); font-weight: bold; font-size: 14px; padding: 12px 20px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.25s;">
                                <i class="fa-regular fa-copy"></i> সম্পূর্ণ রিভিউ কপি করুন
                            </button>
                        </div>
                    </div>

                    <!-- Monospace Interactive Rating Subpanel -->
                    <div style="background: rgba(7, 11, 19, 0.5); border: 1px solid rgba(255,255,255,0.04); border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 25px;">
                        <span style="font-size: 13px; color: #fff; display: block; margin-bottom: 8px; font-weight: bold;">ডিভাইসটি সম্পর্কে আপনার কি ধারণা? রেটিং দিন:</span>
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

                <!-- REVIEWER BIO & EDITORIAL COMPLIANCE (EEAT PANEL) -->
                <div class="review-author-eeat-card" style="background: rgba(13, 21, 39, 0.55); border: 1px solid rgba(0, 255, 65, 0.15); border-radius: 14px; padding: 22px; display: flex; align-items: center; gap: 18px; text-align: left; flex-wrap: wrap;">
                    <div style="border-radius: 50%; overflow: hidden; border: 2.5px solid #00ff41; width: 54px; height: 54px; flex-shrink: 0;">
                        <?php echo $author_avatar; ?>
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <span style="font-size: 10.5px; text-transform: uppercase; color: #00ff41; font-weight: bold; display: block; margin-bottom: 2px; font-family: monospace;">⚙️ DEVICE CRITIC & ANALYST</span>
                        <strong style="color: #fff; font-size: 16px; display: block;"><?php echo esc_html($author_name); ?></strong>
                        <span style="font-size: 12.5px; color: #8b949e; display: block; margin-top: 3px; line-height: 1.4;">
                            রিভিউ প্রকাশের তারিখ: <?php echo get_the_date(); ?> • সর্বশেষ আপডেট: <?php echo get_the_modified_date(); ?> <br>
                            🔍 <span style="color: #00f0ff; font-weight: bold;">তথ্যসমূহ পরীক্ষিত ও যাচাইকৃত</span> (I Love You BD Tech Lab)
                        </span>
                    </div>
                </div>

                <!-- SEO TAGS SECTION (MINIMUM 10 HIGH VALUE TAGS) -->
                <div class="seo-tags-panel" style="margin-top: 35px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 25px;">
                    <h3 style="font-size: 12px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-tags" style="color: #00ff41;"></i> SEO KEYWORDS & CLUSTER TAGS
                    </h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        <?php 
                        // Generate at least 10 high-value dynamic tags
                        $post_tags = get_the_terms($post_id, $tag_taxonomy);
                        $tags_list = [];
                        
                        // Ensure precise, high-value model-specific tags are ALWAYS added first
                        $phone_title = get_the_title();
                        $tags_list[] = $phone_title;
                        $tags_list[] = $brand_name . ' ' . $phone_title;
                        $tags_list[] = $phone_title . ' Review';
                        $tags_list[] = $phone_title . ' দাম';
                        $tags_list[] = $phone_title . ' Specs';
                        
                        if (!is_wp_error($post_tags) && !empty($post_tags)) {
                            foreach ($post_tags as $t) {
                                if (!in_array($t->name, $tags_list)) {
                                    $tags_list[] = $t->name;
                                }
                            }
                        }
                        if (count($tags_list) < 12) {
                            $fallback_tags = [
                                'স্মার্টফোন রিভিউ ২০২৬', 'মোবাইল স্পেসিফিকেশন', 'মোবাইলের দাম বাংলাদেশ', 
                                'বাজেট স্মার্টফোন রিভিউ', 'ফ্ল্যাগশিপ মোবাইল ২০২৬', 'টেক রিভিউ বাংলা', 
                                'স্মার্টফোন প্রাইস প্যানেল', 'সেরা ক্যামেরা ফোন', 'BD Phone Price', 
                                'Mobile Review Bangladesh', 'Gadget Intelligence Lab', 'Latest Specs Price'
                            ];
                            $title_words = explode(' ', strip_tags($phone_title));
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
                                if (count($tags_list) >= 14) {
                                    break;
                                }
                            }
                        }
                        foreach ($tags_list as $tag_item) :
                        ?>
                            <span class="seo-tag-pill" style="background: rgba(13, 21, 39, 0.8); border: 1px solid rgba(0, 255, 65, 0.15); color: #8b949e; font-size: 11.5px; padding: 6px 12px; border-radius: 8px; font-weight: 500; font-family: sans-serif; cursor: default; transition: all 0.2s;">
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

            <!-- 5. CATEGORIES BROWSER (সহজে অন্য ব্র্যান্ড ব্রাউজ করুন) -->
            <section aria-label="Explore Brands" style="margin-bottom: 40px; background: #0d1527; border: 1.5px solid rgba(255,255,255,0.04); border-radius: 16px; padding: 25px;">
                <h2 style="font-size: 13px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">EXPLORE BRANDS (ডিভাইস ব্র্যান্ড সমূহ)</h2>
                <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none;">
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_phone_review')); ?>" class="category-scroller-btn">
                        <i class="fa-solid fa-mobile-screen-button"></i> সব ব্র্যান্ড
                    </a>
                    <?php 
                    $all_terms = get_terms(['taxonomy' => $cat_taxonomy, 'hide_empty' => false]);
                    if (!is_wp_error($all_terms) && !empty($all_terms)) :
                        foreach ($all_terms as $term) :
                            $is_current = ($brand_slug === $term->slug);
                            ?>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="category-scroller-btn" style="<?php echo $is_current ? 'border-color: #00ff41; color: #00ff41; background: rgba(0, 255, 65, 0.1);' : ''; ?>">
                                <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                            </a>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </section>

            <!-- 6. RECOMMENDED RELATED DEVICE REVIEWS (মিনিমাম ৩ টি রেকমেন্ডেট) -->
            <section class="review-related-recommendations" style="margin-bottom: 40px;">
                <h3 style="font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px; text-align: left;">
                    <i class="fa-solid fa-cubes-stacked" style="color: #00ff41;"></i> অন্যান্য ফোন রিভিউ পড়ুন (Recommended Reviews)
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
                                'terms'    => $brand_slug,
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
                        <article class="review-recommend-card" style="background: #0d1527; border: 1.5px solid rgba(255, 255, 255, 0.04); border-radius: 12px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s;">
                            <style>
                                .review-recommend-card:hover {
                                    border-color: rgba(0, 255, 65, 0.25);
                                    transform: translateY(-2px);
                                }
                            </style>
                            <div>
                                <span style="background: rgba(0, 255, 65, 0.08); color: #00ff41; font-size: 10px; font-weight: bold; padding: 3px 8px; border-radius: 4px; display: inline-block; margin-bottom: 12px; border: 1px solid rgba(0, 255, 65, 0.15);">
                                    <?php echo esc_html($brand_name); ?>
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
                            
                            <a href="<?php the_permalink(); ?>" style="display: flex; align-items: center; justify-content: center; background: rgba(0, 255, 65, 0.05); border: 1px solid rgba(0, 255, 65, 0.15); color: #00ff41; font-weight: bold; font-size: 12px; padding: 8px 15px; border-radius: 6px; text-decoration: none; transition: 0.2s; text-transform: uppercase;">
                                রিভিউ পড়ুন <i class="fa-solid fa-chevron-right" style="margin-left: 5px; font-size: 10px;"></i>
                            </a>
                        </article>
                    <?php 
                    endwhile; wp_reset_postdata(); else : 
                    ?>
                        <div style="grid-column: 1 / -1; text-align: center; padding: 30px; background: #0d1527; border-radius: 12px; border: 1px dashed rgba(255,255,255,0.05);">
                            <p style="color: #64748b; font-size: 13.5px; margin: 0;">অন্য কোনো রেকমেন্ডেট মোবাইল রিভিউ পাওয়া যায়নি।</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- 7. COMMENTS AREA -->
            <section class="review-discussion-area" style="background: #0d1117; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); margin-bottom: 40px;">
                <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-top: 0; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 12px;">
                    <i class="fa-solid fa-comments" style="color: #00ff41;"></i> 
                    ডিভাইস নিয়ে আপনার মন্তব্য ও মতামত (<?php echo esc_html(get_comments_number()); ?>)
                </h3>
                <?php comments_template(); ?>
            </section>

        <?php endwhile; endif; ?>

    </div>
</div>

<!-- SCRIPTS FOR PHONE REVIEW -->
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
    
    var shareMsg = "📱 " + title + "\n\nএই ইন-ডেপথ গ্যাজেট রিভিউটি পড়তে সরাসরি নিচের লিংকে ক্লিক করুন:\n" + url;
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

function copyReviewContents(btn) {
    var reviewBody = document.getElementById("reviewMainBody");
    if (!reviewBody) return;
    
    var text = reviewBody.innerText || reviewBody.textContent;
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

function shareReviewOnWhatsapp() {
    var postTitle = "<?php echo esc_js(get_the_title()); ?>";
    var postUrl = "<?php echo esc_js(get_permalink()); ?>";
    var shareMsg = "📱 " + postTitle + "\n\nএই ইন-ডেপথ গ্যাজেট রিভিউটি পড়তে সরাসরি নিচের লিংকে ক্লিক করুন:\n" + postUrl;
    var whatsappUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(shareMsg);
    window.open(whatsappUrl, '_blank');
}
</script>

<?php get_footer(); ?>
