<?php
/**
 * IBD Cyber - Community Q&A List Template
 * Pro Level Layout
 */

// WordPress Loop শুরু
if ( have_posts() ) : 
    echo '<div class="cyber-qa-container">';
    while ( have_posts() ) : the_post(); 
        $votes = get_post_meta(get_the_ID(), 'qa_votes', true) ?: 0;
        $views = get_post_meta(get_the_ID(), 'qa_views_count', true) ?: 0;
        $answers = get_comments_number();
    ?>

    <article class="cyber-qa-card">
        <div class="qa-header">
            <h2 class="qa-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
        </div>

        <div class="qa-stats-row">
            <div class="stat-box vote"><i class="fa-solid fa-fire"></i> <?php echo $votes; ?> ভোট</div>
            <div class="stat-box answer"><i class="fa-solid fa-comment-dots"></i> <?php echo $answers; ?> উত্তর</div>
            <div class="stat-box view"><i class="fa-solid fa-eye"></i> <?php echo $views; ?> ভিউ</div>
        </div>

        <div class="qa-footer">
            <div class="qa-author">
                <?php echo get_avatar(get_the_author_meta('ID'), 28); ?>
                <span class="author-name"><?php the_author(); ?></span>
            </div>
            <div class="qa-time">
                <i class="fa-regular fa-clock"></i> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> আগে
            </div>
        </div>
    </article>

    <?php 
    endwhile; 
    echo '</div>';
else :
    echo '<p style="color:#8b949e; padding:20px;">কোনো প্রশ্ন পাওয়া যায়নি।</p>';
endif; 
?>
