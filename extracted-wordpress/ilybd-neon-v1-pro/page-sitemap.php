<?php
/**
 * Template Name: Cyber HTML sitemap Pro
 * Description: Fully Dynamic Professional HTML Sitemap for SEO Crawling & Indexation
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">HTML Sitemap</h1>
            <p class="section-subtext">সাইটম্যাপ / COMPREHENSIVE INDEXATION CORE</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                
                <section class="policy-block" style="margin-bottom: 30px;">
                    <h2>🌐 Autonomous Dynamic Crawling Index</h2>
                    <p>We believe in perfect crawlability. This HTML sitemap provides an extensive, real-time index of the entire ILOVEYOUBD.COM database. Search crawler bots and visitors can use this centralized index to seamlessly access any directory node, active tool utility, discussion board category, or technical guide publication compiled on our servers.</p>
                </section>

                <div class="sitemap-bento-grid">
                    
                    <!-- 1. Categories Grid -->
                    <div class="sitemap-card">
                        <h3><i class="fa-solid fa-folder-tree"></i> Content Categories / শ্রেণীসমূহ</h3>
                        <ul class="sitemap-links">
                            <?php
                            $categories = get_categories();
                            if ($categories):
                                foreach ($categories as $cat): ?>
                                    <li><a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><i class="fa-solid fa-angle-right"></i> <?php echo esc_html($cat->name); ?> <span class="tag-count">(<?php echo $cat->count; ?>)</span></a></li>
                                <?php endforeach;
                            else: ?>
                                <li><i class="fa-solid fa-triangle-exclamation"></i> No active directories discovered</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- 2. Static Resources Grid -->
                    <div class="sitemap-card">
                        <h3><i class="fa-solid fa-scale-balanced"></i> Corporate & Legal Nodes</h3>
                        <ul class="sitemap-links">
                            <li><a href="<?php echo home_url('/about/'); ?>"><i class="fa-solid fa-arrow-right"></i> About Our Company (আমাদের সম্পর্কে)</a></li>
                            <li><a href="<?php echo home_url('/contact/'); ?>"><i class="fa-solid fa-arrow-right"></i> Secure Contact Uplink (যোগাযোগ)</a></li>
                            <li><a href="<?php echo home_url('/team/'); ?>"><i class="fa-solid fa-arrow-right"></i> Experts & Contributors (টিম মেম্বার)</a></li>
                            <li><a href="<?php echo home_url('/editorial-policy/'); ?>"><i class="fa-solid fa-auth"></i> Editorial Policy (সম্পাদকীয় নীতিমালা)</a></li>
                            <li><a href="<?php echo home_url('/ai-content-policy/'); ?>"><i class="fa-solid fa-robot"></i> AI content Guidelines (এআই কন্টেন্ট নীতি)</a></li>
                            <li><a href="<?php echo home_url('/dmca/'); ?>"><i class="fa-solid fa-gavel"></i> DMCA Takedown Form (কপিরাইট ক্লেইম)</a></li>
                            <li><a href="<?php echo home_url('/corrections-policy/'); ?>"><i class="fa-solid fa-wrench"></i> Accuracy Corrections (তথ্য সংশোধন লগ)</a></li>
                            <li><a href="<?php echo home_url('/cookie-policy/'); ?>"><i class="fa-solid fa-cookie"></i> Cookie Preferences (কুকি নিয়ন্ত্রণ সেন্টার)</a></li>
                            <li><a href="<?php echo home_url('/privacy-policy/'); ?>"><i class="fa-solid fa-shield-halved"></i> Privacy Defense Policy (প্রাইভেসি পলিসি)</a></li>
                            <li><a href="<?php echo home_url('/terms/'); ?>"><i class="fa-solid fa-file-contract"></i> Terms of Execution (টার্মস এন্ড কন্ডিশন)</a></li>
                        </ul>
                    </div>

                    <!-- 3. Dynamic Tools Grid -->
                    <div class="sitemap-card">
                        <h3><i class="fa-solid fa-toolbox"></i> Engineering Tools Lab</h3>
                        <ul class="sitemap-links">
                            <li><a href="<?php echo home_url('/tools-lab/'); ?>"><i class="fa-solid fa-flask"></i> Interactive Coding Playground (টুলস ল্যাব)</a></li>
                        </ul>
                    </div>

                    <!-- 4. Community QA Grid -->
                    <div class="sitemap-card">
                        <h3><i class="fa-solid fa-users"></i> Reputation & Communities</h3>
                        <ul class="sitemap-links">
                            <li><a href="<?php echo home_url('/community/'); ?>"><i class="fa-solid fa-comments"></i> Cyber Q&A Discussion Forum (প্রশ্নোত্তম ফোরাম)</a></li>
                            <li><a href="<?php echo home_url('/authors/'); ?>"><i class="fa-solid fa-feather"></i> Verified Authors Directory (আমাদের লেখকবৃন্দ)</a></li>
                            <li><a href="<?php echo home_url('/dashboard/'); ?>"><i class="fa-solid fa-user-gear"></i> Member Console Dashboard (ইউজার ড্যাশবোর্ড)</a></li>
                            <li><a href="<?php echo home_url('/support/'); ?>"><i class="fa-solid fa-circle-dollar-to-slot"></i> Support Our Laboratory (আমাদের ডোনেট করুন)</a></li>
                        </ul>
                    </div>

                    <!-- 4.1 Cyber SMS & Status Categories -->
                    <div class="sitemap-card">
                        <h3><i class="fa-solid fa-comments"></i> Cyber SMS & Status Categories</h3>
                        <ul class="sitemap-links">
                            <?php
                            $sms_cats = get_terms([
                                'taxonomy'   => 'sms_category',
                                'hide_empty' => false,
                            ]);
                            if (!is_wp_error($sms_cats) && !empty($sms_cats)):
                                foreach ($sms_cats as $term): ?>
                                    <li><a href="<?php echo esc_url(get_term_link($term)); ?>"><i class="fa-solid fa-angle-right"></i> <?php echo esc_html($term->name); ?> <span class="tag-count">(<?php echo $term->count; ?>)</span></a></li>
                                <?php endforeach;
                            else: ?>
                                <li><i class="fa-solid fa-circle-nodes"></i> Waiting for SMS directories...</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- 4.2 Cyber Stories Categories -->
                    <div class="sitemap-card">
                        <h3><i class="fa-solid fa-book"></i> Cyber Story Directories</h3>
                        <ul class="sitemap-links">
                            <?php
                            $story_cats = get_terms([
                                'taxonomy'   => 'story_category',
                                'hide_empty' => false,
                            ]);
                            if (!is_wp_error($story_cats) && !empty($story_cats)):
                                foreach ($story_cats as $term): ?>
                                    <li><a href="<?php echo esc_url(get_term_link($term)); ?>"><i class="fa-solid fa-angle-right"></i> <?php echo esc_html($term->name); ?> <span class="tag-count">(<?php echo $term->count; ?>)</span></a></li>
                                <?php endforeach;
                            else: ?>
                                <li><i class="fa-solid fa-circle-nodes"></i> Waiting for Story nodes...</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- 4.3 Device Brands & Reviews -->
                    <div class="sitemap-card">
                        <h3><i class="fa-solid fa-mobile-screen-button"></i> Next-Gen Device Brands</h3>
                        <ul class="sitemap-links">
                            <?php
                            $brands = get_terms([
                                'taxonomy'   => 'phone_brand',
                                'hide_empty' => false,
                            ]);
                            if (!is_wp_error($brands) && !empty($brands)):
                                foreach ($brands as $term): ?>
                                    <li><a href="<?php echo esc_url(get_term_link($term)); ?>"><i class="fa-solid fa-angle-right"></i> <?php echo esc_html($term->name); ?> <span class="tag-count">(<?php echo $term->count; ?>)</span></a></li>
                                <?php endforeach;
                            else: ?>
                                <li><i class="fa-solid fa-circle-nodes"></i> Waiting for brand directory tags...</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- 5. Latest 15 Posts Grid -->
                    <div class="sitemap-card" style="grid-column: span 2;">
                        <h3><i class="fa-solid fa-file-invoice"></i> Newly Published Technical Publications</h3>
                        <div class="posts-links-grid">
                            <?php
                            $latest_posts = get_posts([
                                'numberposts' => 15,
                                'post_status' => 'publish'
                            ]);
                            if ($latest_posts):
                                foreach ($latest_posts as $p): ?>
                                    <div class="sitemap-post-item">
                                        <a href="<?php echo esc_url(get_permalink($p->ID)); ?>">
                                            <i class="fa-solid fa-file-code" style="color: var(--cyber-neon); margin-right: 8px;"></i>
                                            <?php echo esc_html($p->post_title); ?>
                                        </a>
                                        <span class="sitemap-post-date"><?php echo get_the_date('', $p->ID); ?></span>
                                    </div>
                                <?php endforeach;
                            else: ?>
                                <p style="color: #8b949e; grid-column: span 2;"><i class="fa-solid fa-spinner"></i> Waiting for dynamic content scheduler...</p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .cyber-page-wrapper {
        background: #070a0f;
        min-height: 100vh;
        color: #e1e7ef;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cyber-section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .rgb-text-lighting {
        font-size: 2.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin: 0 0 10px 0;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rgb_flow 4s linear infinite;
    }

    .section-subtext {
        color: <?php echo $neon; ?>;
        font-size: 11px;
        letter-spacing: 5px;
        margin-bottom: 20px;
    }

    .sticky-rgb-line {
        height: 2px;
        width: 100%;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        animation: rgb_flow 4s linear infinite;
        box-shadow: 0 0 15px <?php echo $neon; ?>dd;
    }

    /* Outer Matrix Container */
    .slim-rgb-container {
        position: relative;
        padding: 1px;
        background: linear-gradient(var(--angle), #ff0000, #00ff00, #0000ff, #ff0000);
        animation: rotate-border 6s linear infinite;
        border-radius: 20px;
        overflow: hidden;
    }

    @property --angle {
        syntax: '<angle>';
        initial-value: 0deg;
        inherits: false;
    }

    @keyframes rotate-border {
        to { --angle: 360deg; }
    }

    .inner-page-content {
        background: #0a0e14;
        border-radius: 19px;
        padding: 40px;
    }

    .sitemap-bento-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .sitemap-card {
        background: rgba(255,255,255,0.01);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 14px;
        padding: 25px;
        transition: 0.3s;
    }

    .sitemap-card:hover {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 15px <?php echo $neon; ?>2d;
        transform: translateY(-2px);
    }

    .sitemap-card h3 {
        color: #fff;
        font-size: 17px;
        margin-top: 0;
        margin-bottom: 20px;
        border-bottom: 2px solid rgba(255,255,255,0.05);
        padding-bottom: 10px;
        text-transform: uppercase;
        font-family: monospace;
    }

    .sitemap-card h3 i {
        color: <?php echo $neon; ?>;
        margin-right: 8px;
    }

    .sitemap-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sitemap-links li {
        margin-bottom: 12px;
    }

    .sitemap-links a {
        color: #a0aec0;
        text-decoration: none;
        font-size: 14px;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .sitemap-links a:hover {
        color: <?php echo $neon; ?>;
        padding-left: 5px;
    }

    .tag-count {
        font-size: 11px;
        background: rgba(0,255,65,0.08);
        border: 1px solid rgba(0,255,65,0.2);
        color: <?php echo $neon; ?>;
        padding: 1px 6px;
        border-radius: 10px;
        margin-left: 5px;
    }

    /* Post Layout */
    .posts-links-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .sitemap-post-item {
        background: rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.02);
        border-radius: 8px;
        padding: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 6px;
    }

    .sitemap-post-item a {
        color: #fff;
        text-decoration: none;
        font-size: 13.5px;
        line-height: 1.5;
        font-weight: 500;
        transition: 0.2s;
    }

    .sitemap-post-item a:hover {
        color: <?php echo $neon; ?>;
    }

    .sitemap-post-date {
        font-family: monospace;
        font-size: 11px;
        color: #8b949e;
    }

    @media (max-width: 991px) {
        .sitemap-bento-grid {
            grid-template-columns: 1fr;
        }
        .sitemap-card {
            grid-column: span 1 !important;
        }
    }

    @media (max-width: 600px) {
        .posts-links-grid {
            grid-template-columns: 1fr;
        }
        .inner-page-content {
            padding: 20px;
        }
    }

    @keyframes rgb_flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<?php get_footer(); ?>
