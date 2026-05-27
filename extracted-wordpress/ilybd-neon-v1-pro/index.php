<?php get_header(); ?>

<div class="ilybd-layout">

    <main class="ilybd-feed-container">

        <?php 
        /**
         * টপ সেকশন মডিউল
         */
        do_action('ilybd_after_header'); 
        get_template_part('template-parts/messenger-stories');
        ?>
        <!-- 🔥 ULTRAPRO NEON SEARCH SYSTEM -->
        <div class="search-section-wrapper" style="max-width: 650px; margin: 10px auto 10px auto; padding: 0 15px; text-align: center;">
            <form role="search" method="get" class="cyber-search-form" action="<?php echo esc_url(home_url('/')); ?>" style="position: relative; display: flex; align-items: center; justify-content: center; width: 100%;">
                <div style="position: relative; width: 100%; display: flex; align-items: center;">
                    <input type="search" class="cyber-search-input" placeholder="পছন্দের টিউটোরিয়াল বা কোড খুঁজুন..." value="<?php echo get_search_query(); ?>" name="s" style="width: 100%; padding: 10px 45px 10px 18px; font-size: 14px; background: #0c1118; border: 1.5px solid rgba(0, 255, 65, 0.25); border-radius: 30px; color: #fff; outline: none; transition: all 0.3s ease; box-shadow: 0 0 10px rgba(0,0,0,0.5), inset 0 1px 3px rgba(0,0,0,0.8); font-family: 'Rajdhani', sans-serif;" required onfocus="this.style.borderColor='#00ff41'; this.style.boxShadow='0 0 15px rgba(0, 255, 65, 0.45), inset 0 1px 3px rgba(0,0,0,0.8)';" onblur="this.style.borderColor='rgba(0, 255, 65, 0.25)'; this.style.boxShadow='0 0 10px rgba(0,0,0,0.5), inset 0 1px 3px rgba(0,0,0,0.8)';">
                    <button type="submit" class="cyber-search-submit" aria-label="Search" style="position: absolute; right: 6px; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, #00ff41 0%, #00e5ff 100%); border: none; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #000; font-size: 14px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,255,65,0.4);" onmouseover="this.style.transform='translateY(-50%) scale(1.08)'; this.style.boxShadow='0 0 15px #00ff41';" onmouseout="this.style.transform='translateY(-50%) scale(1.00)'; this.style.boxShadow='0 2px 8px rgba(0,255,65,0.4)';">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>
        <?php
        do_action('ilybd_slider'); 
        do_action('ilybd_featured'); 
        do_action('ilybd_popular'); 
        ?>

        <section class="latest-posts-wrapper">
            <div class="section-head latest-head">
                <span class="label">⚡ LATEST POSTS</span>
                <span class="line"></span>
            </div>

            <?php do_action('ilybd_latest'); ?>

            <?php if (have_posts()) : ?>
                <div class="ilybd-feed ilybd-post-grid-system">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/post-card'); ?>
                    <?php endwhile; ?>
                </div>

                <div class="ilybd-pagination">
                    <?php the_posts_pagination(); ?>
                </div>
            <?php else : ?>
                <div class="no-posts" style="color: #8b949e; padding: 40px; text-align: center;">No posts found.</div>
            <?php endif; ?>
        </section>

        <section class="community-qa-wrapper">
            <div class="section-head qa-head">
                <span class="label">💬 COMMUNITY Q&A</span>
                <span class="line"></span>
            </div>

            <div class="qa-content-box">
                <?php echo do_shortcode('[recent_questions count="5"]'); ?>

                <div class="qa-footer-action">
                    <p class="qa-helper-text">আপনার কোনো প্রযুক্তিগত সমস্যা আছে? আমাদের বিশেষজ্ঞদের জানান।</p>
                    <a href="<?php echo home_url('/ask-question'); ?>" class="ask-btn-main">
                        প্রশ্ন করুন
                    </a>
                </div>
            </div>
        </section>

        <style>
        /* Community Q&A Design Upgrades */
        .community-qa-wrapper {
            margin-top: 40px;
            margin-bottom: 45px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        }

        /* Premium Header Styling */
        .qa-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .qa-head .label {
            background: linear-gradient(135deg, #00ff41 0%, #00e5ff 100%) !important;
            color: #000000 !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            padding: 6px 14px !important;
            border-radius: 8px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            font-size: 12px !important;
            box-shadow: 0 4px 12px rgba(0, 255, 65, 0.25) !important;
        }

        .qa-head .line {
            flex-grow: 1;
            height: 1px;
            background: linear-gradient(90deg, #00ff41, transparent) !important;
        }

        /* Reddish-Purple Gradient Card Background */
        .qa-content-box {
            background: linear-gradient(135deg, #6e00ff 0%, #ff4b2b 100%) !important; /* Matches single post profile card perfectly */
            border: 1.5px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
            padding: 24px !important;
            border-radius: 16px !important;
            position: relative;
            overflow: hidden;
        }

        /* List Container spacing */
        .qna-list-container {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* Q&A Glassmorphic Item box */
        .qna-item-box {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background: rgba(13, 17, 23, 0.7) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            padding: 15px 18px !important;
            border-radius: 12px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
            transition: all 0.25s ease-in-out !important;
        }

        .qna-item-box:hover {
            background: rgba(13, 17, 23, 0.82) !important;
            border-color: rgba(255, 255, 255, 0.3) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.35) !important;
        }

        /* Stats Section as Badges */
        .qna-stats-left {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
        }

        .qna-stat-item {
            text-align: center !important;
            padding: 4px 8px !important;
            border-radius: 8px !important;
            min-width: 58px !important;
            font-size: 10px !important;
            font-weight: 500 !important;
            line-height: 1.2 !important;
        }

        .qna-stat-item.votes-item {
            background: rgba(0, 255, 65, 0.12) !important;
            border: 1px solid rgba(0, 255, 65, 0.25) !important;
            color: #00ff41 !important;
        }

        .qna-stat-item.answers-item {
            background: rgba(0, 229, 255, 0.12) !important;
            border: 1px solid rgba(0, 229, 255, 0.25) !important;
            color: #00e5ff !important;
        }

        .qna-stat-item.views-item {
            background: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #e2e8f0 !important;
        }

        .qna-stat-item b {
            display: block !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            line-height: 1.1 !important;
            margin-bottom: 2px !important;
        }

        /* Middle content details */
        .qna-details-mid {
            flex: 1;
            margin: 0 16px !important;
            text-align: left !important;
        }

        .qna-q-title {
            margin: 0 0 5px 0 !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            line-height: 1.4 !important;
        }

        .qna-q-title a {
            color: #ffffff !important;
            text-decoration: none !important;
            transition: color 0.15s ease !important;
        }

        .qna-q-title a:hover {
            color: #00ff41 !important;
        }

        .qna-q-meta {
            font-size: 11px !important;
            color: #cbd5e0 !important;
        }

        .qna-q-meta a {
            color: #00ff41 !important;
            text-decoration: none !important;
            font-weight: 700 !important;
        }

        .qna-q-meta a:hover {
            text-decoration: underline !important;
        }

        /* Action button style */
        .qna-action-right {
            flex-shrink: 0;
        }

        .qna-action-right a {
            background: linear-gradient(135deg, #00ff41 0%, #00b32d 100%) !important;
            color: #000000 !important;
            padding: 6px 12px !important;
            border-radius: 6px !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            border: none !important;
            text-decoration: none !important;
            display: inline-block !important;
            box-shadow: 0 3px 10px rgba(0, 255, 65, 0.2) !important;
            transition: all 0.2s ease !important;
        }

        .qna-action-right a:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(0, 255, 65, 0.4) !important;
        }

        /* Footer elements */
        .qa-footer-action {
            position: relative;
            z-index: 2;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .qa-helper-text {
            font-size: 12px !important;
            color: #ffffff !important;
            font-weight: 500 !important;
            margin: 0 !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
        }

        .ask-btn-main {
            background: #ffffff !important;
            color: #000000 !important;
            padding: 8px 20px !important;
            border-radius: 6px !important;
            font-weight: 800 !important;
            font-size: 13px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-block !important;
            border: none !important;
        }

        .ask-btn-main:hover {
            background: #00ff41 !important;
            color: #000000 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 16px rgba(0, 255, 65, 0.4) !important;
        }

        /* Mobile Responsive Optimization Mode */
        @media (max-width: 600px) {
            .qa-content-box {
                padding: 16px !important;
                border-radius: 12px !important;
            }
            .qna-item-box {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
                padding: 12px !important;
                border-radius: 10px !important;
            }
            .qna-stats-left {
                order: 2 !important;
                justify-content: flex-start !important;
                gap: 6px !important;
            }
            .qna-stat-item {
                flex: 1 !important;
                min-width: auto !important;
                padding: 4px 6px !important;
                border-radius: 6px !important;
            }
            .qna-details-mid {
                order: 1 !important;
                margin: 0 !important;
            }
            .qna-q-title {
                font-size: 14px !important;
            }
            .qna-action-right {
                order: 3 !important;
                width: 100% !important;
                text-align: right !important;
            }
            .qna-action-right a {
                display: block !important;
                text-align: center !important;
                padding: 8px !important;
                border-radius: 6px !important;
            }
            .qa-footer-action {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 10px !important;
                text-align: center !important;
                padding-top: 12px !important;
            }
            .qa-helper-text {
                margin-bottom: 2px !important;
            }
            .ask-btn-main {
                width: 100% !important;
                text-align: center !important;
            }
        }
        </style>

        <?php 
        /**
         * বটম সেকশন মডিউল
         */
        do_action('ilybd_category'); 
        ?>

    </main>

    <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
