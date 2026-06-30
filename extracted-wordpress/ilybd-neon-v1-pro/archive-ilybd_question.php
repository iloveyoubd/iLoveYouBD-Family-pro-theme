<?php
/**
 * Custom Q&A Forum Archive Hub Template (2040 Next-Gen Cyber Ecosystem)
 * Theme: ilybd-neon-v1-pro
 */
get_header(); 

// Fetch pagination limit configured via Admin or default to 10
$limit = intval(get_option('ilybd_questions_per_page', 10));
?>

<style>
/* Q&A Glassmorphic Item box */
.qna-item-box {
    display: flex !important;
    flex-direction: row !important;
    justify-content: space-between !important;
    align-items: center !important;
    background: rgba(13, 17, 23, 0.7) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
    padding: 15px 18px !important;
    border-radius: 12px !important;
    border: 1.5px solid rgba(0, 255, 65, 0.15) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
    transition: all 0.25s ease-in-out !important;
}

.qna-item-box:hover {
    background: rgba(13, 17, 23, 0.82) !important;
    border-color: rgba(0, 255, 65, 0.4) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 22px rgba(0, 255, 65, 0.15) !important;
}

/* Stats Section as Badges */
.qna-stats-left {
    display: flex !important;
    gap: 8px !important;
    align-items: center !important;
    flex-shrink: 0 !important;
}

.qna-stat-item {
    text-align: center !important;
    padding: 6px 10px !important;
    border-radius: 8px !important;
    min-width: 62px !important;
    font-size: 11px !important;
    font-weight: 500 !important;
    line-height: 1.2 !important;
}

.qna-stat-item.votes-item {
    background: rgba(0, 255, 65, 0.08) !important;
    border: 1px solid rgba(0, 255, 65, 0.2) !important;
    color: #00ff41 !important;
}

.qna-stat-item.answers-item {
    background: rgba(0, 229, 255, 0.08) !important;
    border: 1px solid rgba(0, 229, 255, 0.2) !important;
    color: #00e5ff !important;
}

.qna-stat-item.views-item {
    background: rgba(255, 255, 255, 0.04) !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    color: #e2e8f0 !important;
}

.qna-stat-item b {
    display: block !important;
    font-size: 15px !important;
    font-weight: 800 !important;
    line-height: 1.1 !important;
    margin-bottom: 2px !important;
}

/* Middle content details */
.qna-details-mid {
    flex: 1 !important;
    margin: 0 16px !important;
    text-align: left !important;
}

.qna-q-title {
    margin: 0 0 6px 0 !important;
    font-size: 15.5px !important;
    font-weight: 700 !important;
    line-height: 1.4 !important;
    font-family: 'Space Grotesk', sans-serif !important;
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
    font-size: 11.5px !important;
    color: #8b949e !important;
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
    flex-shrink: 0 !important;
}

.qna-action-right a {
    background: linear-gradient(135deg, #00ff41 0%, #00b32d 100%) !important;
    color: #000000 !important;
    padding: 10px 20px !important;
    border-radius: 30px !important;
    font-size: 12.5px !important;
    font-weight: 800 !important;
    border: none !important;
    text-decoration: none !important;
    display: inline-block !important;
    box-shadow: 0 4px 12px rgba(0, 255, 65, 0.2) !important;
    transition: all 0.2s ease !important;
}

.qna-action-right a:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 18px rgba(0, 255, 65, 0.4) !important;
}

/* Mobile Responsive Optimization Mode */
@media (max-width: 600px) {
    .qna-item-box {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 14px !important;
        padding: 15px !important;
        border-radius: 12px !important;
    }
    .qna-stats-left {
        order: 2 !important;
        justify-content: flex-start !important;
        gap: 8px !important;
    }
    .qna-stat-item {
        flex: 1 !important;
        min-width: auto !important;
        padding: 6px 8px !important;
        border-radius: 8px !important;
    }
    .qna-details-mid {
        order: 1 !important;
        margin: 0 !important;
    }
    .qna-q-title {
        font-size: 14.5px !important;
    }
    .qna-action-right {
        order: 3 !important;
        width: 100% !important;
        text-align: right !important;
    }
    .qna-action-right a {
        display: block !important;
        text-align: center !important;
        padding: 10px !important;
        border-radius: 30px !important;
    }
}
</style>

<div class="nextgen-archive-viewport qna-hub-viewport" style="background: #070b13; color: #c9d1d9; min-height: 100vh; padding: 30px 12px 80px; font-family: 'Inter', sans-serif;">
    <div style="max-width: 900px; margin: 0 auto; width: 100%;">

        <!-- 1. BREADCRUMB -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 20px; font-size: 12px; font-family: monospace; opacity: 0.85;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
            <span style="color: #475569; margin: 0 8px;">/</span>
            <span style="color: #00ff41; text-decoration: none; font-weight: bold; text-transform: uppercase;">Q&A CENTER / ফোরাম সেন্টার</span>
        </nav>

        <!-- 2. HIGH-TECH TITLE SECTION & ACTION TRIGGER -->
        <div class="qna-hub-header" style="background: linear-gradient(135deg, #0d1527 0%, #070b13 100%); border: 1.5px solid rgba(0, 255, 65, 0.15); border-radius: 16px; padding: 25px 20px; margin-bottom: 30px; position: relative; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.4);">
            <div style="position: absolute; top:0; right:0; width: 120px; height: 120px; background: rgba(0, 255, 65, 0.03); filter: blur(50px); border-radius: 50%;"></div>
            
            <div style="display: flex; flex-direction: column; md:flex-row; justify-content: space-between; gap: 15px; align-items: flex-start;">
                <div>
                    <span style="display: inline-block; font-family: monospace; font-size: 9px; font-weight: bold; background: rgba(0, 255, 65, 0.08); border: 1px solid rgba(0, 255, 65, 0.2); color: #00ff41; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;"><i class="fa-solid fa-comments"></i> Community Knowledge Hub</span>
                    <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0 0 8px 0; font-family: 'Space Grotesk', sans-serif; letter-spacing: 0.3px;">
                        💬 ফোরাম সেন্টার ও প্রশ্নোত্তর হাব
                    </h1>
                    <p style="color: #8b949e; font-size: 13px; margin: 0; line-height: 1.5;">
                        আপনার যেকোনো জটিল কারিগরি বা প্রযুক্তিগত সমস্যার প্রশ্ন করুন এবং আমাদের অভিজ্ঞ মডারেটর ও এআই সিস্টেম থেকে দ্রুত সঠিক সমাধান পান।
                    </p>
                </div>
            </div>

            <!-- Expandable Ask Question Trigger Button -->
            <div style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 10px;">
                <button id="toggle-ask-form-btn" onclick="toggleAskQuestionForm()" style="background: linear-gradient(135deg, #00ff41 0%, #00e5ff 100%); border: none; color: #000; padding: 12px 24px; border-radius: 30px; font-weight: 800; font-size: 13.5px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 255, 65, 0.25);">
                    <i class="fa-solid fa-circle-question" style="font-size: 15px;"></i>
                    <span>প্রশ্ন করুন / Ask a Question</span>
                </button>
            </div>
        </div>

        <!-- 3. EXPANDABLE CHANNELS FOR SUBMITTING QUESTIONS -->
        <div id="ask-question-form-container" style="display: none; opacity: 0; transition: all 0.4s ease; transform: translateY(-10px); margin-bottom: 30px;">
            <div style="background: #0d1527; border: 1.5px solid #00ff41; border-radius: 16px; padding: 2px; box-shadow: 0 0 25px rgba(0, 255, 65, 0.12);">
                <?php echo do_shortcode('[ilybd_ask_question_form]'); ?>
            </div>
        </div>

        <!-- 4. GOOGLE ADSENSE BANNER PLACEHOLDER (DEACTIVATED FOR COMPLIANCE) -->

        <!-- 5. MAIN ARCHIVE LOOP -->
        <h2 style="font-size: 12px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.8px; display: flex; align-items: center; gap: 6px;">
            <span style="display:inline-block; width: 6px; height: 6px; background:#00ff41; border-radius:50%;"></span>
            ALL TOPICS & DISCUSSIONS (সকল প্রশ্নসমূহ)
        </h2>

        <div class="qna-list-container" style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 40px;">
            <?php 
            if (have_posts()) : 
                while (have_posts()) : the_post(); 
                    $q_id = get_the_ID();
                    $votes = get_post_meta($q_id, 'qa_votes', true) ?: 0;
                    $views = get_post_meta($q_id, 'qa_views_count', true) ?: 0;
                    $answers_count = get_comments_number($q_id);
                    $author_name = get_the_author();
                    $author_url = get_author_posts_url(get_the_author_meta('ID'));
                    $time_diff = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' আগে';
                    ?>
                    
                    <div class="qna-item-box">
                        <!-- বাম দিক: ভোট এবং সংখ্যা -->
                        <div class="qna-stats-left">
                            <div class="qna-stat-item votes-item"><b><?php echo esc_html($votes); ?></b>ভোট</div>
                            <div class="qna-stat-item answers-item"><b><?php echo esc_html($answers_count); ?></b>উত্তর</div>
                            <div class="qna-stat-item views-item"><b><?php echo esc_html($views); ?></b>ভিউস</div>
                        </div>

                        <!-- মাঝের কন্টেন্ট -->
                        <div class="qna-details-mid">
                            <h4 class="qna-q-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <div class="qna-q-meta">
                                Asked by <a href="<?php echo esc_url($author_url); ?>"><b><?php echo esc_html($author_name); ?></b></a> - <?php echo esc_html($time_diff); ?>
                            </div>
                        </div>

                        <!-- ডান দিকের বাটন -->
                        <div class="qna-action-right">
                            <a href="<?php the_permalink(); ?>">সমাধান দেখুন</a>
                        </div>
                    </div>
                    
                <?php 
                endwhile;

                // 6. PAGINATION
                $qna_pagination = get_the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('« পূর্ববর্তী', 'ilybd-neon'),
                    'next_text' => __('পরবর্তী »', 'ilybd-neon'),
                )); 
                if (!empty($qna_pagination)) :
                ?>
                <div class="ilybd-pagination" style="margin-top: 30px; display: flex; justify-content: center;">
                    <?php echo $qna_pagination; ?>
                </div>
                <?php endif; ?>

            <?php else : ?>
                <div style="background: #0d1527; border: 1px dashed rgba(255,255,255,0.08); border-radius: 14px; padding: 50px 20px; text-align: center; color: #8b949e;">
                    <i class="fa-solid fa-circle-info" style="font-size: 24px; color: #64748b; margin-bottom: 12px;"></i>
                    <p style="margin: 0; font-size: 14.5px;">দুঃখিত! এই ক্যাটাগরিতে কোনো প্রশ্ন পাওয়া যায়নি। প্রথম প্রশ্নটি আপনি করুন!</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Scripts and Styles for the Interactive Form Collapse and Cards -->
<script>
function toggleAskQuestionForm() {
    const container = document.getElementById('ask-question-form-container');
    const btn = document.getElementById('toggle-ask-form-btn');
    if (!container) return;

    if (container.style.display === 'none' || container.style.display === '') {
        container.style.display = 'block';
        // Force reflow
        container.offsetHeight;
        container.style.opacity = '1';
        container.style.transform = 'translateY(0)';
        btn.innerHTML = '<i class="fa-solid fa-xmark"></i> <span>ফরম বন্ধ করুন / Close</span>';
        btn.style.background = 'linear-gradient(135deg, #ff3e3e 0%, #ff8a00 100%)';
    } else {
        container.style.opacity = '0';
        container.style.transform = 'translateY(-10px)';
        btn.innerHTML = '<i class="fa-solid fa-circle-question"></i> <span>প্রশ্ন করুন / Ask a Question</span>';
        btn.style.background = 'linear-gradient(135deg, #00ff41 0%, #00e5ff 100%)';
        setTimeout(() => {
            container.style.display = 'none';
        }, 400);
    }
}
</script>

<style>
/* Custom styled WordPress pagination to match Neon theme */
.ilybd-pagination {
    margin-top: 30px;
}
.ilybd-pagination .nav-links {
    display: inline-flex;
    gap: 8px;
    align-items: center;
}
.ilybd-pagination .page-numbers {
    background: #0d1527;
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #8b949e;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 13.5px;
    transition: all 0.2s;
}
.ilybd-pagination .page-numbers.current,
.ilybd-pagination .page-numbers:hover {
    background: rgba(0, 255, 65, 0.1);
    border-color: #00ff41;
    color: #00ff41;
    box-shadow: 0 0 10px rgba(0, 255, 65, 0.15);
}
@media (max-width: 600px) {
    .qna-card-footer-layout {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 12px !important;
    }
}
</style>

<?php 
get_footer();
