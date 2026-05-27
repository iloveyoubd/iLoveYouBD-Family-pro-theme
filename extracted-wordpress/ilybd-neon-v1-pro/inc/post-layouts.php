<?php
/**
 * ILYBD Neon Pro - Social Post Layout Engine
 * Facebook + StackOverflow Hybrid Feed System
 */

if (!defined('ABSPATH')) exit;

/* =========================
   MAIN POST CARD
========================= */
function cyber_post_card() {

    $post_id = get_the_ID();

    $views = (int) get_post_meta($post_id, 'ilybd_post_views_count', true);
    $likes = (int) get_post_meta($post_id, '_likes', true);

    $author_id = get_the_author_meta('ID');

    ?>
    
    <div class="cyber-feed-card">

        <!-- CATEGORY -->
        <div class="feed-category">
            <?php
            $cats = get_the_category();
            if (!empty($cats)) {
                echo '<a href="'.esc_url(get_category_link($cats[0]->term_id)).'">'.$cats[0]->name.'</a>';
            }
            ?>
        </div>

        <!-- HEADER (AUTHOR INFO) -->
        <div class="feed-header">

            <a href="<?php echo get_author_posts_url($author_id); ?>" class="author-link">
                <?php echo get_avatar($author_id, 40); ?>
            </a>

            <div class="author-meta">
                <a href="<?php echo get_author_posts_url($author_id); ?>">
                    <strong><?php the_author(); ?></strong>
                </a>

                <div class="meta-time">
                    <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
                </div>
            </div>

        </div>

        <!-- TITLE -->
        <h2 class="feed-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>

        <!-- THUMB -->
        <div class="feed-thumb">
            <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                } else { ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default.jpg">
                <?php } ?>
            </a>
        </div>

        <!-- ACTION BAR -->
        <div class="feed-actions">

            <button class="like-btn" data-id="<?php echo $post_id; ?>">
                ❤️ <span><?php echo $likes; ?></span>
            </button>

            <span>👁 <?php echo $views; ?></span>

            <span>💬 <?php comments_number('0','1','%'); ?></span>

            <a href="<?php the_permalink(); ?>">↗ Open</a>

        </div>

    </div>

    <?php
}


/* =========================
   AUTHOR BOX (PROFILE CARD)
========================= */
function cyber_author_box() {

    $author_id = get_the_author_meta('ID');

    $stats = ilybd_get_user_stats($author_id);
    $tier  = ilybd_get_user_tier($author_id);

    ?>

    <div class="cyber-author-profile">

        <a href="<?php echo get_author_posts_url($author_id); ?>">
            <?php echo get_avatar($author_id, 70); ?>
        </a>

        <h3>
            <a href="<?php echo get_author_posts_url($author_id); ?>">
                <?php the_author(); ?>
            </a>
            <span class="verified">✔</span>
        </h3>

        <div class="rank">
            <?php echo $tier['rank'] ?? 'Member'; ?>
        </div>

        <div class="author-stats">

            <div>
                <b><?php echo $stats['post_count']; ?></b>
                <small>Posts</small>
            </div>

            <div>
                <b><?php echo $stats['total_likes']; ?></b>
                <small>Likes</small>
            </div>

            <div>
                <b><?php echo $stats['followers'] ?? 0; ?></b>
                <small>Followers</small>
            </div>

        </div>

        <a class="profile-btn" href="<?php echo get_author_posts_url($author_id); ?>">
            View Profile
        </a>

    </div>

    <?php
}