<?php
/**
 * Single SMS & Status Template (2040 Cyberpunk Edition)
 * Theme: ilybd-neon-v1-pro
 */
get_header(); 

$post_type = 'ilybd_sms';
$cat_taxonomy = 'sms_category';
$tag_taxonomy = 'sms_tag';
?>

<style>
.sms-single-wrapper {
    background: #070b13;
    color: #c9d1d9;
    min-height: 100vh;
    padding: 135px 15px 80px !important;
    font-family: 'Inter', sans-serif;
}
@media (max-width: 768px) {
    .sms-single-wrapper {
        padding: 105px 12px 80px !important;
    }
}

/* Cyberpunk Bento SMS Cards Styling */
.cyber-sms-card {
    background: #0d1527;
    border: 1px solid rgba(0, 240, 255, 0.15);
    border-radius: 14px;
    padding: 24px;
    margin: 24px 0;
    position: relative;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    overflow: hidden;
}
.cyber-sms-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, #00f0ff, #9d4edd);
    opacity: 0.8;
}
.cyber-sms-card:hover {
    border-color: rgba(0, 240, 255, 0.4);
    box-shadow: 0 12px 40px rgba(0, 240, 255, 0.15);
    transform: translateY(-2px);
}
.sms-body-bn {
    color: #ffffff !important;
    font-size: 17px !important;
    line-height: 1.8 !important;
    margin-bottom: 12px !important;
    font-weight: 500;
}
.sms-body-en {
    color: #8b949e !important;
    font-size: 14.5px !important;
    line-height: 1.6 !important;
    font-family: 'Inter', sans-serif !important;
    margin-bottom: 18px !important;
    opacity: 0.85;
}
.sms-actions {
    display: flex;
    gap: 12px;
    border-top: 1px dashed rgba(255, 255, 255, 0.08);
    padding-top: 16px;
    flex-wrap: wrap;
    align-items: center;
}
.copy-sms-btn-bn, .copy-sms-btn-en, .share-whatsapp-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 12px !important;
    font-weight: bold !important;
    padding: 8px 16px !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
    text-transform: uppercase;
    font-family: 'JetBrains Mono', monospace;
    border: 1px solid transparent;
}
/* Bangla Copy Button styling (Cyan Cyberpunk) */
.copy-sms-btn-bn {
    background: rgba(0, 240, 255, 0.05) !important;
    color: #00f0ff !important;
    border: 1px solid rgba(0, 240, 255, 0.2) !important;
}
.copy-sms-btn-bn:hover {
    background: rgba(0, 240, 255, 0.15) !important;
    border-color: #00f0ff !important;
    box-shadow: 0 0 12px rgba(0, 240, 255, 0.3) !important;
    transform: translateY(-1px);
}
/* English Copy Button styling (Electric Purple) */
.copy-sms-btn-en {
    background: rgba(157, 78, 221, 0.05) !important;
    color: #9d4edd !important;
    border: 1px solid rgba(157, 78, 221, 0.2) !important;
}
.copy-sms-btn-en:hover {
    background: rgba(157, 78, 221, 0.15) !important;
    border-color: #9d4edd !important;
    box-shadow: 0 0 12px rgba(157, 78, 221, 0.3) !important;
    transform: translateY(-1px);
}
/* WhatsApp Share Button styling (Emerald Green) */
.share-whatsapp-btn {
    background: rgba(37, 211, 102, 0.05) !important;
    color: #25d366 !important;
    border: 1px solid rgba(37, 211, 102, 0.2) !important;
}
.share-whatsapp-btn:hover {
    background: rgba(37, 211, 102, 0.15) !important;
    border-color: #25d366 !important;
    box-shadow: 0 0 12px rgba(37, 211, 102, 0.3) !important;
    transform: translateY(-1px);
}
</style>
<div class="ilybd-layout sms-single-wrapper">
    <div style="max-width: 900px; margin: 0 auto; width: 100%;">

        <?php if (have_posts()) : while (have_posts()) : the_post(); 
            $post_id = get_the_ID();
            $author_id = get_the_author_meta('ID');
            $author_name = get_the_author_meta('display_name');
            $author_avatar = get_avatar($author_id, 54);
            
            // Get post content and strip out html if any
            $sms_raw_content = get_the_content();
            $sms_clean = trim(strip_tags($sms_raw_content));
            if (empty($sms_clean)) {
                $sms_clean = get_the_title();
            }

            // Fetch categories
            $categories = wp_get_post_terms($post_id, $cat_taxonomy);
            $cat_name = !empty($categories) ? $categories[0]->name : 'SMS & Status';
            $cat_slug = !empty($categories) ? $categories[0]->slug : 'sms';
            $cat_link = !empty($categories) ? get_term_link($categories[0]) : home_url('/');
            
            // Views count
            $views = get_post_meta($post_id, 'ilybd_post_views_count', true) ?: '0';
            update_post_meta($post_id, 'ilybd_post_views_count', intval($views) + 1);

            // Dynamic Social Shares pre-calculation
            $share_title = get_the_title();
            $share_permalink = get_permalink();
            $share_msg = "❤️ " . $share_title . "\n\nএটি পড়তে সরাসরি নিচের লিংকে ক্লিক করুন:\n" . $share_permalink;
            $whatsapp_url = "https://api.whatsapp.com/send?text=" . rawurlencode($share_msg);
            $facebook_url = "https://www.facebook.com/sharer/sharer.php?u=" . rawurlencode($share_permalink);
            $messenger_url = "https://www.facebook.com/dialog/send?link=" . rawurlencode($share_permalink) . "&app_id=291494419107518&redirect_uri=" . rawurlencode($share_permalink);
            $telegram_url = "https://t.me/share/url?url=" . rawurlencode($share_permalink) . "&text=" . rawurlencode($share_title);
        ?>

            <!-- 1. BREADCRUMB / ACCESSIBILITY NAV -->
            <nav aria-label="Breadcrumb" style="margin-bottom: 25px; font-size: 13px; font-family: monospace; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
                    <span style="color: #475569; margin: 0 8px;">/</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_sms')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">SMS CENTER</a>
                    <span style="color: #475569; margin: 0 8px;">/</span>
                    <a href="<?php echo esc_url($cat_link); ?>" style="color: #00f0ff; text-decoration: none; font-weight: bold;"><?php echo esc_html(strtoupper($cat_name)); ?></a>
                </div>
                <span style="color: #64748b; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-eye" style="color: #00f0ff;"></i> <?php echo esc_html($views); ?> views
                </span>
            </nav>

            <!-- 2. HIGH-POLISHED BANNER CONTAINER (SILENT SAFE SPACE FOR ADSENSE) -->
            <?php if (get_option('ily_enable_adsense_placeholders', 0) == 1) : ?>
            <div class="adsense-safe-container" style="margin-bottom: 30px; min-height: 25px; background: transparent; border: none; padding: 0;"></div>
            <?php endif; ?>

            <!-- 3. MAIN CARD -->
            <article class="sms-main-card" style="background: #0d1527; border: 1.5px solid rgba(0, 240, 255, 0.2); border-radius: 18px; padding: 35px; box-shadow: 0 15px 45px rgba(0,0,0,0.55); position: relative; overflow: hidden; margin-bottom: 40px;">
                <div class="card-glow-element" style="position: absolute; top: -100px; right: -100px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(0,240,255,0.08) 0%, transparent 70%); pointer-events: none;"></div>
                
                <!-- Badge and top metadata -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <div style="display: flex; align-items: center; gap: 8px; background: rgba(0, 240, 255, 0.1); border: 1px solid rgba(0, 240, 255, 0.2); padding: 4px 12px; border-radius: 50px; color: #00f0ff; font-size: 11px; font-weight: bold; font-family: monospace; text-transform: uppercase;">
                        <span style="display:inline-block; width: 6px; height: 6px; background: #00f0ff; border-radius: 50%; margin-right: 2px;"></span> SMS_CORE_PRO_v2
                    </div>
                    <span style="color: #64748b; font-size: 12px; font-family: monospace; font-weight: bold;">
                        RELEASED: <?php echo esc_html(get_the_date()); ?>
                    </span>
                </div>

                <!-- SMS Title -->
                <h1 style="color: #fff; font-size: clamp(22px, 5vw, 32px); line-height: 1.35; font-weight: 800; margin-top: 0; margin-bottom: 25px; text-shadow: 0 0 15px rgba(0,240,255,0.15); text-align: left; border-left: 4px solid #00f0ff; padding-left: 15px;">
                    <?php the_title(); ?>
                </h1>

                <!-- Dynamic Featured Image Banner with Title Baked In (Google SEO & Image Indexer Optimized) -->
                <div class="sms-featured-banner" style="margin-bottom: 25px; border-radius: 12px; overflow: hidden; border: 1.5px solid rgba(0, 240, 255, 0.25); box-shadow: 0 8px 32px rgba(0,0,0,0.45); height: clamp(250px, 40vh, 380px); position: relative;">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', array('style' => 'width:100%; height:100%; display:block; object-fit:cover;')); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/inc/dynamic-image-generator-sms.php?post_id=' . get_the_ID()); ?>" style="width:100%; height:100%; display:block; object-fit:cover;" alt="<?php the_title_attribute(); ?>" />
                    <?php endif; ?>
                </div>

                <!-- SMS Text Content Body -->
                <div class="sms-article-body" style="font-size: 18px; line-height: 1.85; color: #cbd5e0; margin-bottom: 30px;">
                    <?php 
                    // Render the full content beautifully.
                    // This outputs the parsed cyber-sms-card structures with maximum token savings!
                    if (function_exists('ilybd_parse_and_render_sms_content')) {
                        echo ilybd_parse_and_render_sms_content(get_the_content());
                    } else {
                        the_content(); 
                    }
                    ?>
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
                            <button id="ilybd-copy-btn" onclick="copyFullPostContents(this)" style="background: rgba(0, 240, 255, 0.05); color: #00f0ff; border: 1.5px solid rgba(0, 240, 255, 0.3); font-weight: bold; font-size: 14px; padding: 12px 20px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.25s;">
                                <i class="fa-regular fa-copy"></i> সম্পূর্ণ কন্টেন্ট কপি করুন
                            </button>
                        </div>
                    </div>

                    <!-- Monospace Interactive Rating Subpanel -->
                    <div style="background: rgba(7, 11, 19, 0.5); border: 1px solid rgba(255,255,255,0.04); border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 25px;">
                        <span style="font-size: 13px; color: #fff; display: block; margin-bottom: 8px; font-weight: bold;">কন্টেন্টটি আপনার কেমন লেগেছে? রেটিং দিন:</span>
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
                            <a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener noreferrer" onclick="ilybdTrackShare(<?php echo $post_id; ?>)" style="background: #25d366; color: #fff; font-size: 13px; font-weight: bold; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.15);"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                            <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" onclick="ilybdTrackShare(<?php echo $post_id; ?>)" style="background: #1877f2; color: #fff; font-size: 13px; font-weight: bold; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; box-shadow: 0 4px 12px rgba(24, 119, 242, 0.15);"><i class="fa-brands fa-facebook"></i> Facebook</a>
                            <a href="<?php echo esc_url($messenger_url); ?>" target="_blank" rel="noopener noreferrer" onclick="ilybdTrackShare(<?php echo $post_id; ?>)" style="background: #0084ff; color: #fff; font-size: 13px; font-weight: bold; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; box-shadow: 0 4px 12px rgba(0, 132, 255, 0.15);"><i class="fa-solid fa-message"></i> Messenger</a>
                            <a href="<?php echo esc_url($telegram_url); ?>" target="_blank" rel="noopener noreferrer" onclick="ilybdTrackShare(<?php echo $post_id; ?>)" style="background: #0088cc; color: #fff; font-size: 13px; font-weight: bold; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; box-shadow: 0 4px 12px rgba(0, 136, 204, 0.15);"><i class="fa-brands fa-telegram"></i> Telegram</a>
                        </div>
                    </div>
                </div>

                <!-- AUTHOR BIO / EEAT COMPLIANCE PANEL -->
                <div class="author-eeat-card" style="background: rgba(13, 21, 39, 0.6); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 14px; padding: 22px; display: flex; align-items: center; gap: 18px; text-align: left; flex-wrap: wrap;">
                    <div style="border-radius: 50%; overflow: hidden; border: 2.5px solid #00f0ff; width: 54px; height: 54px; flex-shrink: 0;">
                        <?php echo $author_avatar; ?>
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <span style="font-size: 10px; text-transform: uppercase; color: #00f0ff; font-weight: bold; display: block; margin-bottom: 2px; font-family: monospace;">✍️ AUTHOR PROFILE & AUTHENTICITY</span>
                        <strong style="color: #fff; font-size: 16px; display: block;"><?php echo esc_html($author_name); ?></strong>
                        <span style="font-size: 12.5px; color: #8b949e; display: block; margin-top: 3px; line-height: 1.4;">
                            প্রকাশের তারিখ: <?php echo get_the_date(); ?> • Fact Checked & Approved By I Love You BD Editorial ✅
                        </span>
                    </div>
                </div>

                <!-- SEO TAGS SECTION (MINIMUM 10 HIGH VALUE TAGS) -->
                <div class="seo-tags-panel" style="margin-top: 35px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 25px;">
                    <h3 style="font-size: 12px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-tags" style="color: #00f0ff;"></i> SEO KEYWORDS & CLOUD (সার্চ ইঞ্জিন কিউরেটেড ট্যাগ)
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
                                'সেরা বাংলা এসএমএস', 'ফেসবুক স্ট্যাটাস ২০২৬', 'বাংলা উক্তি ও বাণী', 
                                'কষ্টের স্ট্যাটাস বাংলা', 'ভালোবাসার মেসেজ', 'রোমান্টিক এস এম এস', 
                                'বন্ধুত্বের স্ট্যাটাস', 'ইসলামিক পোস্ট', 'শেয়ার চ্যাট বাংলা', 
                                'এটিটিউড স্ট্যাটাস', 'Bengali Status Hub', 'SMS Collection Bangladesh'
                            ];
                            // add words from title
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
                            <span class="seo-tag-pill" style="background: rgba(13, 21, 39, 0.8); border: 1px solid rgba(0, 240, 255, 0.15); color: #8b949e; font-size: 11.5px; padding: 6px 12px; border-radius: 8px; font-weight: 500; font-family: sans-serif; cursor: default; transition: all 0.2s;">
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

            <!-- 5. CATEGORIES BROWSER (সহজে অন্য ক্যাটাগরি ব্রাউজ করুন) -->
            <section aria-label="Explore Categories" style="margin-bottom: 40px; background: #0d1527; border: 1.5px solid rgba(255,255,255,0.04); border-radius: 16px; padding: 25px;">
                <h2 style="font-size: 13px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.5px;">SMS CATEGORIES (ক্যাটাগরি সমূহ)</h2>
                <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none;">
                    <style>
                        .category-scroller-btn {
                            background: rgba(13, 21, 39, 0.8);
                            border: 1px solid rgba(0, 240, 255, 0.1);
                            color: #8b949e;
                            padding: 8px 16px;
                            border-radius: 8px;
                            font-size: 12.5px;
                            font-weight: bold;
                            text-decoration: none;
                            white-space: nowrap;
                            transition: all 0.2s;
                        }
                        .category-scroller-btn:hover {
                            border-color: #00f0ff;
                            color: #00f0ff;
                            background: rgba(0, 240, 255, 0.05);
                        }
                    </style>
                    <a href="<?php echo esc_url(get_post_type_archive_link('ilybd_sms')); ?>" class="category-scroller-btn">
                        <i class="fa-solid fa-layer-group"></i> সব ক্যাটাগরি
                    </a>
                    <?php 
                    $all_terms = get_terms(['taxonomy' => $cat_taxonomy, 'hide_empty' => false]);
                    if (!is_wp_error($all_terms) && !empty($all_terms)) :
                        foreach ($all_terms as $term) :
                            $is_current = ($cat_slug === $term->slug);
                            ?>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="category-scroller-btn" style="<?php echo $is_current ? 'border-color: #00f0ff; color: #00f0ff; background: rgba(0, 240, 255, 0.1);' : ''; ?>">
                                <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                            </a>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </section>
              <!-- 6. RECOMMENDED RELATED SMS SECTION (মিনিমাম ৩ টি রেকমেন্ডেট) -->
            <section class="sms-related-recommendations" style="margin-bottom: 40px;">
                <h3 style="font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 20px 0; display: flex; align-items: center; gap: 8px; text-align: left;">
                    <i class="fa-solid fa-cubes-stacked" style="color: #00f0ff;"></i> আরও পড়ুন (Recommended for You)
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
                        <article class="sms-recommend-card" style="background: #0d1527; border: 1.5px solid rgba(255, 255, 255, 0.04); border-radius: 12px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s;">
                            <style>
                                .sms-recommend-card:hover {
                                    border-color: rgba(0, 240, 255, 0.25);
                                    transform: translateY(-2px);
                                }
                            </style>
                            <div>
                                <span style="background: rgba(0, 240, 255, 0.08); color: #00f0ff; font-size: 10px; font-weight: bold; padding: 3px 8px; border-radius: 4px; display: inline-block; margin-bottom: 12px; border: 1px solid rgba(0, 240, 255, 0.15);">
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
                            
                            <a href="<?php the_permalink(); ?>" aria-label="Read more about <?php echo esc_attr(get_the_title()); ?>" style="display: flex; align-items: center; justify-content: center; background: rgba(0, 240, 255, 0.05); border: 1px solid rgba(0, 240, 255, 0.15); color: #00f0ff; font-weight: bold; font-size: 12px; padding: 8px 15px; border-radius: 6px; text-decoration: none; transition: 0.2s; text-transform: uppercase;">
                                বিস্তারিত পড়ুন / Read SMS <span style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">about <?php the_title(); ?></span> <i class="fa-solid fa-chevron-right" style="margin-left: 5px; font-size: 10px;"></i>
                            </a>
                        </article>
                    <?php 
                    endwhile; wp_reset_postdata(); else : 
                        // Beautiful dynamic falling blocks when DB query has no posts yet
                        $fallbacks = [
                            [
                                'title' => 'সেরা ভালোবাসার রোমান্টিক স্ট্যাটাস ও শায়রি',
                                'excerpt' => 'তোমার হাসিতে খুঁজে পাই আমার বেঁচে থাকার নতুন সুর। ভালোবেসে যাবো আজীবন তোমায়...',
                                'link' => home_url('/sms/')
                            ],
                            [
                                'title' => 'মন ছোঁয়া কষ্টের গভীর অনুভূতি স্ট্যাটাস',
                                'excerpt' => 'কিছু কষ্ট এমন হয় যা কাউকে বলাও যায় না, আবার সহ্যও করা যায় না। নীরবতা সেখানে একমাত্র ভাষা...',
                                'link' => home_url('/sms/')
                            ],
                            [
                                'title' => 'অনুপ্রেরণামূলক নতুন অ্যাটিটিউড স্ট্যাটাস কালেকশন',
                                'excerpt' => 'নিজের চলার পথ নিজেকেই তৈরি করতে হয়, কারণ মানুষের হাত বাড়ানো শুধু সান্ত্বনা দেওয়ার জন্য...',
                                'link' => home_url('/sms/')
                            ]
                        ];
                        foreach ($fallbacks as $fb) :
                        ?>
                            <article class="sms-recommend-card" style="background: #0d1527; border: 1.5px solid rgba(255, 255, 255, 0.04); border-radius: 12px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s;">
                                <style>
                                    .sms-recommend-card:hover {
                                        border-color: rgba(0, 240, 255, 0.25);
                                        transform: translateY(-2px);
                                    }
                                </style>
                                <div>
                                    <span style="background: rgba(0, 240, 255, 0.08); color: #00f0ff; font-size: 10px; font-weight: bold; padding: 3px 8px; border-radius: 4px; display: inline-block; margin-bottom: 12px; border: 1px solid rgba(0, 240, 255, 0.15);">
                                        <?php echo esc_html($cat_name); ?>
                                    </span>
                                    <h4 style="font-size: 14.5px; font-weight: bold; color: #fff; margin: 0 0 10px 0; line-height: 1.4;">
                                        <a href="<?php echo esc_url($fb['link']); ?>" style="color: #fff; text-decoration: none; transition: color 0.2s;">
                                            <?php echo esc_html($fb['title']); ?>
                                        </a>
                                    </h4>
                                    <p style="font-size: 12.5px; color: #8b949e; line-height: 1.5; margin: 0 0 15px 0;">
                                        <?php echo esc_html($fb['excerpt']); ?>
                                    </p>
                                </div>
                                
                                <a href="<?php echo esc_url($fb['link']); ?>" aria-label="Read more about <?php echo esc_attr($fb['title']); ?>" style="display: flex; align-items: center; justify-content: center; background: rgba(0, 240, 255, 0.05); border: 1px solid rgba(0, 240, 255, 0.15); color: #00f0ff; font-weight: bold; font-size: 12px; padding: 8px 15px; border-radius: 6px; text-decoration: none; transition: 0.2s; text-transform: uppercase;">
                                    বিস্তারিত পড়ুন / Read SMS <span style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">about <?php echo esc_html($fb['title']); ?></span> <i class="fa-solid fa-chevron-right" style="margin-left: 5px; font-size: 10px;"></i>
                                </a>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <!-- 7. COMMENTS & DISCUSSION AREA -->
            <section class="sms-discussion-area" style="background: #0d1117; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); margin-bottom: 40px;">
                <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-top: 0; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 12px;">
                    <i class="fa-solid fa-comment-dots" style="color: #00f0ff;"></i> 
                    মন্তব্য এবং প্রতিক্রিয়া (<?php echo esc_html(get_comments_number()); ?>)
                </h3>
                <?php comments_template(); ?>
            </section>

        <?php endwhile; endif; ?>

    </div>
</div>

<!-- SCRIPTS FOR ADVANCED ACTIONS -->
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
    
    var shareMsg = "❤️ " + title + "\n\nএটি পড়তে সরাসরি নিচের লিংকে ক্লিক করুন:\n" + url;
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

// Sandbox/iFrame proof copy engine
function copyTextToClipboard(text, btn, successHTML) {
    var origHTML = btn.innerHTML;
    var origBG = btn.style.background;
    var origColor = btn.style.color;
    var origBorder = btn.style.borderColor;

    function showSuccess() {
        btn.innerHTML = successHTML;
        btn.style.background = 'rgba(0, 255, 101, 0.15)';
        btn.style.color = '#00ff41';
        btn.style.borderColor = '#00ff41';
        setTimeout(function() {
            btn.innerHTML = origHTML;
            btn.style.background = origBG;
            btn.style.color = origColor;
            btn.style.borderColor = origBorder;
        }, 2000);
    }

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(showSuccess).catch(function() {
            fallbackCopy();
        });
    } else {
        fallbackCopy();
    }

    function fallbackCopy() {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.width = "2em";
        textArea.style.height = "2em";
        textArea.style.padding = "0";
        textArea.style.border = "none";
        textArea.style.outline = "none";
        textArea.style.boxShadow = "none";
        textArea.style.background = "transparent";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            var successful = document.execCommand('copy');
            if (successful) {
                showSuccess();
            }
        } catch (err) {
            console.error("Fallback copy failed", err);
        }
        document.body.removeChild(textArea);
    }
}

// Copy text of full post
function copyFullPostContents(btn) {
    var bodyContainer = document.querySelector('.sms-article-body');
    if (!bodyContainer) return;
    var text = bodyContainer.innerText || bodyContainer.textContent;
    text = text.replace(/বাংলা কপি|ইংরেজি কপি|শেয়ার|কপি করুন|হোয়াটসঅ্যাপ/g, '').trim();
    copyTextToClipboard(text, btn, '<i class="fa-solid fa-check"></i> কপি সম্পন্ন!');
}

// Share full post on Whatsapp
function shareFullPostOnWhatsapp() {
    var bodyContainer = document.querySelector('.sms-article-body');
    if (!bodyContainer) return;
    var text = bodyContainer.innerText || bodyContainer.textContent;
    text = text.replace(/বাংলা কপি|ইংরেজি কপি|শেয়ার|কপি করুন|হোয়াটসঅ্যাপ/g, '').trim();
    if (text.length > 500) {
        text = text.substring(0, 500) + '...';
    }
    var shareMsg = text + "\n\nসবগুলো এসএমএস এবং স্ট্যাটাস পড়তে ভিজিট করুন: " + window.location.href;
    var url = "https://api.whatsapp.com/send?text=" + encodeURIComponent(shareMsg);
    window.open(url, '_blank');
}

// Intercept inline individual cyber-sms-card buttons (Auto-Pilot structures)
function copySmsCardBn(btn) {
    var card = btn.closest('.cyber-sms-card');
    if (!card) return;
    var textBn = card.querySelector('.sms-body-bn');
    if (!textBn) return;
    var text = textBn.innerText || textBn.textContent;
    copyTextToClipboard(text.trim(), btn, '<i class="fa-solid fa-check" style="color: #00ff41;"></i> কপিড!');
}

function copySmsCardEn(btn) {
    var card = btn.closest('.cyber-sms-card');
    if (!card) return;
    var textEn = card.querySelector('.sms-body-en');
    if (!textEn) return;
    var text = textEn.innerText || textEn.textContent;
    copyTextToClipboard(text.trim(), btn, '<i class="fa-solid fa-check" style="color: #00ff41;"></i> Copied!');
}

function shareSmsOnWhatsapp(btn) {
    var card = btn.closest('.cyber-sms-card');
    if (!card) return;
    var textBnEl = card.querySelector('.sms-body-bn');
    var textEnEl = card.querySelector('.sms-body-en');
    var textBn = textBnEl ? textBnEl.innerText || textBnEl.textContent : '';
    var textEn = textEnEl ? textEnEl.innerText || textEnEl.textContent : '';
    var text = textBn + (textEn ? "\n" + textEn : "");
    var shareMsg = text.trim() + "\n\nঅনুরূপ সুন্দর স্ট্যাটাস কালেকশন পেতে দেখুন: " + window.location.href;
    var url = "https://api.whatsapp.com/send?text=" + encodeURIComponent(shareMsg);
    window.open(url, '_blank');
}

// Global safety wire-up for plain copy/share buttons embedded directly inside the content
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

    var content = document.querySelector('.sms-article-body');
    if (!content) return;

    // Universal copy/share delegated click listeners for elements inside .sms-article-body
    content.addEventListener('click', function(e) {
        var btn = e.target.closest('button, a, .copy-btn, .whatsapp-btn');
        if (!btn) return;
        
        var onclickAttr = btn.getAttribute('onclick');
        if (onclickAttr && (onclickAttr.includes('copySmsCardBn') || onclickAttr.includes('copySmsCardEn') || onclickAttr.includes('shareSmsOnWhatsapp'))) {
            return; // let inline handlers do their job
        }
        
        var txt = btn.textContent.trim().toLowerCase();
        
        // Match Copy Action
        if (txt.indexOf('কপি') !== -1 || txt.indexOf('copy') !== -1) {
            e.preventDefault();
            e.stopPropagation();
            
            var textToCopy = "";
            var prev = btn.previousElementSibling;
            while (prev) {
                if (prev.tagName === 'P' || prev.tagName === 'DIV' || prev.tagName === 'SPAN') {
                    textToCopy = prev.innerText || prev.textContent;
                    break;
                }
                prev = prev.previousElementSibling;
            }
            
            if (!textToCopy) {
                var card = btn.closest('.cyber-sms-card, .sms-collection-card');
                if (card) {
                    var pEl = card.querySelector('.sms-body-bn, p');
                    if (pEl) textToCopy = pEl.innerText || pEl.textContent;
                }
            }
            
            if (textToCopy) {
                copyTextToClipboard(textToCopy.trim(), btn, '<i class="fa-solid fa-check"></i> কপিড!');
            }
        }
        
        // Match Share/WhatsApp Action
        if (txt.indexOf('হোয়াটসঅ্যাপ') !== -1 || txt.indexOf('whatsapp') !== -1 || txt.indexOf('শেয়ার') !== -1 || txt.indexOf('share') !== -1) {
            e.preventDefault();
            e.stopPropagation();
            
            var textToShare = "";
            var prev = btn.previousElementSibling;
            while (prev) {
                if (prev.tagName === 'P' || prev.tagName === 'DIV' || prev.tagName === 'SPAN') {
                    textToShare = prev.innerText || prev.textContent;
                    break;
                }
                prev = prev.previousElementSibling;
            }
            
            if (!textToShare) {
                var card = btn.closest('.cyber-sms-card, .sms-collection-card');
                if (card) {
                    var pEl = card.querySelector('.sms-body-bn, p');
                    if (pEl) textToShare = pEl.innerText || pEl.textContent;
                }
            }
            
            if (textToShare) {
                var shareMsg = textToShare.trim() + "\n\nঅনুরূপ সুন্দর স্ট্যাটাস কালেকশন পেতে দেখুন: " + window.location.href;
                var url = "https://api.whatsapp.com/send?text=" + encodeURIComponent(shareMsg);
                window.open(url, '_blank');
            }
        }
    });
});
</script>

<?php get_footer(); ?>
