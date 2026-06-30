<?php get_header(); ?>

<div class="ilybd-layout qna-single-wrapper" style="background: #070a10; color: #c9d1d9; min-height: 100vh; padding: 30px 15px 60px; font-family: 'Inter', sans-serif;">
    <main class="ilybd-feed-container" style="max-width: 900px; margin: 0 auto; width: 100%;">

        <!-- STYLISH COMMUNITY FORUM NAVIGATION HEADER -->
        <div class="qna-header-cyber" style="background: linear-gradient(90deg, #0d1424 0%, #060b13 100%); border: 1px solid rgba(0, 255, 65, 0.2); border-radius: 14px; padding: 20px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 5px 25px rgba(0,255,65,0.04);">
            <div style="text-align: left;">
                <span style="background: rgba(0, 255, 65, 0.15); color: #00ff41; font-size: 11px; font-weight: bold; border: 1px solid #00ff41; padding: 3px 10px; border-radius: 20px; font-family: monospace; letter-spacing: 1px;">💬 COMMUNITY DISCUSSION</span>
                <h2 style="color: #fff; font-size: 20px; font-weight: bold; margin-top: 8px; margin-bottom: 0;">কমিউনিটি প্রযুক্তি প্রশ্নোত্তর ফোরাম</h2>
            </div>
            <div>
                <a href="<?php echo home_url('/ask-question'); ?>" style="background: #00ff41; color: #000; padding: 8px 18px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 12px; transition: 0.3s; display: inline-block; box-shadow: 0 0 15px rgba(0,255,65,0.3);" onmouseover="this.style.background='#fff'; this.style.boxShadow='0 0 20px #fff';" onmouseout="this.style.background='#00ff41'; this.style.boxShadow='0 0 15px rgba(0,255,65,0.3)';">
                    <i class="fa-solid fa-plus"></i> প্রশ্ন করুন
                </a>
            </div>
        </div>

        <?php if (have_posts()) : while (have_posts()) : the_post(); 
            $post_id = get_the_ID();
            $views = get_post_meta($post_id, 'qa_views_count', true) ?: '0';
            update_post_meta($post_id, 'qa_views_count', intval($views) + 1);
        ?>
            <article class="qna-main-card" style="background: #0d1117; border: 1px solid rgba(0, 240, 255, 0.1); border-radius: 16px; padding: 25px; margin-bottom: 35px; box-shadow: 0 10px 40px rgba(0,0,0,0.6); position: relative; overflow: hidden;">
                <!-- Corner glow element -->
                <div style="position: absolute; top: -100px; right: -100px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(0,240,255,0.06) 0%, transparent 70%); pointer-events: none;"></div>

                <h1 class="qna-title-neon" style="color: #fff; font-size: clamp(20px, 4.5vw, 28px); font-weight: 700; line-height: 1.35; margin-top: 0; margin-bottom: 15px; text-shadow: 0 0 12px rgba(0, 240, 255, 0.15); font-family: system-ui, sans-serif; text-align: left;">
                    <?php the_title(); ?>
                </h1>
                
                <div class="qna-meta-box" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px; margin-bottom: 25px; font-size: 12px; color: #8b949e;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-user-astronaut" style="color: #00f0ff;"></i> Asked by: 
                        <b style="color: #00f0ff;"><?php the_author(); ?></b>
                    </div>
                    <?php 
                    $categories = get_the_category();
                    if (!empty($categories)) : ?>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-folder-open" style="color: #00ff41;"></i> Category: 
                            <span style="color: #00ff41; font-weight: 600;"><?php echo esc_html($categories[0]->name); ?></span>
                        </div>
                    <?php endif; ?>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-eye" style="color: #3fb950;"></i> Views: 
                        <span style="color: #fff; font-weight: 600;"><?php echo get_post_meta(get_the_ID(), 'qa_views_count', true) ?: 0; ?></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-clock" style="color: #ffae00;"></i> Posted: 
                        <span style="color: #c9d1d9;"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> আগে</span>
                    </div>
                </div>

                <div class="qna-body-flex" style="display: flex; align-items: flex-start; gap: 25px; margin-top: 20px;">
                    <!-- Vote column -->
                    <div class="qna-vote-bar" style="display: flex; flex-direction: column; align-items: center; background: #070a0f; border: 1.5px solid rgba(0, 255, 65, 0.15); border-radius: 12px; padding: 12px; min-width: 65px; box-shadow: inset 0 2px 10px rgba(0,0,0,0.5);">
                        <button class="v-btn qa-vote-btn" data-id="<?php echo get_the_ID(); ?>" data-type="up" style="background: transparent; color: #00ff41; border: none; font-size: 24px; cursor: pointer; transition: transform 0.2s, text-shadow 0.2s; outline: none; line-height: 1;" onmouseover="this.style.transform='scale(1.25)'; this.style.textShadow='0 0 10px #00ff41';" onmouseout="this.style.transform='scale(1)'; this.style.textShadow='none';">▲</button>
                        <span class="v-count" style="font-size: 22px; font-weight: 800; color: #fff; margin: 6px 0; font-family: 'Rajdhani', monospace; text-shadow: 0 0 5px rgba(255,255,255,0.2);"><?php echo get_post_meta(get_the_ID(), 'qa_votes', true) ?: 0; ?></span>
                        <button class="v-btn qa-vote-btn" data-id="<?php echo get_the_ID(); ?>" data-type="down" style="background: transparent; color: #ff003c; border: none; font-size: 24px; cursor: pointer; transition: transform 0.2s, text-shadow 0.2s; outline: none; line-height: 1;" onmouseover="this.style.transform='scale(1.25)'; this.style.textShadow='0 0 10px #ff003c';" onmouseout="this.style.transform='scale(1)'; this.style.textShadow='none';">▼</button>
                    </div>

                    <!-- Question Content Area -->
                    <div class="qna-content" style="flex: 1; font-size: 16px; line-height: 1.8; color: #e6edf3; text-align: left; font-family: system-ui, sans-serif;">
                        <?php the_content(); ?>

                        <!-- Tags List (Kept in HTML DOM for Google Crawl Indexing, Hidden from Visual View) -->
                        <?php 
                        $tags = get_the_tags();
                        if (!empty($tags)) : ?>
                            <div class="qna-tags-container" style="display: none !important; flex-wrap: wrap; gap: 8px; margin-top: 25px; border-top: 1px dashed rgba(255,255,255,0.05); padding-top: 15px;">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" style="background: rgba(0, 240, 255, 0.05); color: #00f0ff; border: 1.1px solid rgba(0, 240, 255, 0.2); border-radius: 6px; padding: 4px 10px; font-size: 11px; text-decoration: none; font-family: monospace; transition: all 0.2s;" onmouseover="this.style.background='rgba(0,240,255,0.15)'; this.style.borderColor='#00f0ff'; this.style.boxShadow='0 0 8px rgba(0,240,255,0.3)';" onmouseout="this.style.background='rgba(0,240,255,0.05)'; this.style.borderColor='rgba(0,240,255,0.2)'; this.style.boxShadow='none';">
                                        # <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="qna-footer" style="margin-top: 25px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: #8b949e;">
                    <div>
                        <span style="margin-right: 8px;"><i class="fa-solid fa-share-nodes"></i> Share on:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" style="color: #58a6ff; text-decoration: none; font-weight: 600; margin-right: 12px; transition: 0.2s;" onmouseover="this.style.color='#fff';" onmouseout="this.style.color='#58a6ff';">Facebook</a>
                    </div>
                    <div style="font-family: monospace; font-size: 11px; background: rgba(57, 255, 20, 0.05); color: rgba(57, 255, 20, 0.75); border: 1px dashed rgba(57, 255, 20, 0.2); padding: 2px 8px; border-radius: 4px;">
                        STATION ID: Q-<?php echo get_the_ID(); ?>
                    </div>
                </div>
            </article>

            <!-- ANSWERS FEED CONTAINER -->
            <section class="qna-answers-area" style="background: #0d1117; border: 1.5px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 25px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
                <h3 class="res-title" style="color: #fff; font-size: 18px; font-weight: 700; margin-top: 0; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; text-align: left; border-b: 1px solid rgba(255,255,255,0.04); padding-bottom: 12px;">
                    <i class="fa-solid fa-comment-dots" style="color: #00ff41;"></i> 
                    <?php echo get_comments_number(); ?> টি উত্তর এবং সমাধান বিশ্লেষণ
                </h3>
                
                <?php comments_template(); ?>
            </section>

            <!-- RECOMMENDED QUESTIONS HUB (সংশ্লিষ্ট প্রশ্নোত্তর) -->
            <?php
            $current_categories = wp_get_post_categories($post_id);
            $recommended_args = array(
                'post_type'      => 'ilybd_question',
                'posts_per_page' => 4,
                'post__not_in'   => array($post_id),
                'post_status'    => 'publish',
                'orderby'        => 'rand',
            );
            if (!empty($current_categories)) {
                $recommended_args['category__in'] = $current_categories;
            }
            $recommended_query = new WP_Query($recommended_args);
            if ($recommended_query->have_posts()) :
            ?>
            <section class="qna-recommended-section" style="background: #0d1527; border: 1.5px solid rgba(0, 255, 65, 0.15); border-radius: 16px; padding: 22px; margin-top: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.3); margin-bottom: 30px;">
                <h3 style="color: #fff; font-size: 17px; font-weight: 700; margin-top: 0; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">
                    <span style="color: #00ff41;"><i class="fa-solid fa-lightbulb"></i></span>
                    সংশ্লিষ্ট ও রিকমেন্ডেড প্রশ্নসমূহ (Related Discussions)
                </h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <?php while ($recommended_query->have_posts()) : $recommended_query->the_post(); 
                        $rec_id = get_the_ID();
                        $rec_votes = get_post_meta($rec_id, 'qa_votes', true) ?: 0;
                        $rec_answers = get_comments_number($rec_id);
                        $rec_views = get_post_meta($rec_id, 'qa_views_count', true) ?: 0;
                        ?>
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 15px; padding: 12px; background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255, 255, 255, 0.03); border-radius: 10px; transition: all 0.2s;" onmouseover="this.style.borderColor='rgba(0,255,65,0.2)'; this.style.background='rgba(7,11,19,0.7)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.03)'; this.style.background='rgba(7, 11, 19, 0.4)';">
                            <div style="flex: 1; text-align: left;">
                                <h4 style="margin: 0 0 6px 0; font-size: 14.5px; font-weight: 600;">
                                    <a href="<?php the_permalink(); ?>" style="color: #e2e8f0; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#00ff41';" onmouseout="this.style.color='#e2e8f0';">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                                <div style="font-size: 11px; color: #64748b; font-family: monospace;">
                                    Asked by: <?php the_author(); ?> - <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> আগে
                                </div>
                            </div>
                            <div style="display: flex; gap: 8px; align-items: center; font-size: 11px; font-family: monospace;">
                                <span style="background: rgba(0,255,65,0.06); color: #00ff41; padding: 3px 6px; border-radius: 4px; border: 1px solid rgba(0,255,65,0.1);"><i class="fa-solid fa-fire"></i> <?php echo $rec_votes; ?></span>
                                <span style="background: rgba(0,229,255,0.06); color: #00e5ff; padding: 3px 6px; border-radius: 4px; border: 1px solid rgba(0,229,255,0.1);"><i class="fa-solid fa-comment-dots"></i> <?php echo $rec_answers; ?></span>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- QUICK ASK QUESTION FOOTER PROMPT -->
            <div class="qna-footer-ask-promo" style="background: linear-gradient(135deg, #0d1527 0%, #070b13 100%); border: 1.5px dashed rgba(0, 255, 65, 0.3); border-radius: 16px; padding: 25px; text-align: center; margin-top: 30px; box-shadow: 0 8px 32px rgba(0,0,0,0.4); margin-bottom: 30px;">
                <h4 style="color:#fff; font-size: 17px; margin-top:0; margin-bottom:8px; font-weight: 700;">আপনার কি কোনো বিশেষ টেকনিক্যাল সমস্যা রয়েছে?</h4>
                <p style="color:#8b949e; font-size:13px; margin:0 0 18px 0; line-height: 1.5;">আমাদের ফোরামে প্রশ্ন করে অভিজ্ঞ মডারেটর এবং আইবিডি এআই এসিস্ট্যান্টের কাছ থেকে কয়েক মিনিটের মধ্যে নিখুঁত সমাধান পান।</p>
                
                <button id="toggle-single-ask-btn" onclick="toggleSingleAskForm()" style="background: #00ff41; border: none; color: #000; padding: 10px 24px; border-radius: 30px; font-weight: 800; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 15px rgba(0,255,65,0.25);">
                    <i class="fa-solid fa-circle-question"></i>
                    <span>প্রশ্ন করুন / Ask a Question</span>
                </button>

                <div id="single-ask-form-wrapper" style="display: none; opacity: 0; transition: all 0.4s ease; transform: translateY(-10px); margin-top: 20px; text-align: left;">
                    <div style="background: #0d1117; border: 1.5px solid #00ff41; border-radius: 16px; padding: 2px; box-shadow: 0 0 25px rgba(0, 255, 65, 0.12);">
                        <?php echo do_shortcode('[ilybd_ask_question_form]'); ?>
                    </div>
                </div>
            </div>

            <script>
            function toggleSingleAskForm() {
                const wrapper = document.getElementById('single-ask-form-wrapper');
                const btn = document.getElementById('toggle-single-ask-btn');
                if (!wrapper) return;

                if (wrapper.style.display === 'none' || wrapper.style.display === '') {
                    wrapper.style.display = 'block';
                    // Force reflow
                    wrapper.offsetHeight;
                    wrapper.style.opacity = '1';
                    wrapper.style.transform = 'translateY(0)';
                    btn.innerHTML = '<i class="fa-solid fa-xmark"></i> <span>ফরম বন্ধ করুন / Close</span>';
                    btn.style.background = '#ff3e3e';
                    btn.style.color = '#fff';
                } else {
                    wrapper.style.opacity = '0';
                    wrapper.style.transform = 'translateY(-10px)';
                    btn.innerHTML = '<i class="fa-solid fa-circle-question"></i> <span>প্রশ্ন করুন / Ask a Question</span>';
                    btn.style.background = '#00ff41';
                    btn.style.color = '#000';
                    setTimeout(() => {
                        wrapper.style.display = 'none';
                    }, 400);
                }
            }
            </script>

        <?php endwhile; endif; ?>

    </main>
    
    <!-- Sidebar template inclusion -->
    <?php get_sidebar(); ?>
</div>

<script>
jQuery(document).ready(function($) {
    $('.qa-vote-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var postId = btn.data('id');
        var type = btn.data('type');
        
        btn.css('opacity', '0.5');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'ilybd_vote_question',
                post_id: postId,
                vote_type: type
            },
            success: function(response) {
                btn.css('opacity', '1');
                if (response.success) {
                    btn.siblings('.v-count').text(response.data);
                    
                    // micro-glow visual punch animation
                    btn.siblings('.v-count').css('color', type === 'up' ? '#00ff41' : '#ff003c');
                    setTimeout(function() {
                        btn.siblings('.v-count').css('color', '#fff');
                    }, 500);
                } else if (response.data) {
                    alert(response.data);
                }
            },
            error: function() {
                btn.css('opacity', '1');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
