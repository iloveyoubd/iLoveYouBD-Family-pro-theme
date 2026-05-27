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

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
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
