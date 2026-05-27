<?php get_header(); ?>

<div class="ilybd-container">
    <div class="cat-archive-header">
        <h1 class="archive-title">
            <span class="glitch-text">CATEGORY:</span> 
            <?php single_cat_title(); ?>
        </h1>
        <div class="archive-description">
            <?php echo category_description(); ?>
        </div>
    </div>

    <div class="post-grid">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
            <article class="cyber-post-card">
                <div class="post-thumb">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                    <?php else: ?>
                        <div class="no-thumb">NO IMAGE</div>
                    <?php endif; ?>
                </div>

                <div class="post-details">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="post-meta">
                        <span>BY: <?php the_author(); ?></span> | 
                        <span><?php echo get_the_date(); ?></span>
                    </div>
                    <div class="post-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more-btn">READ MORE</a>
                </div>
            </article>

        <?php endwhile; else : ?>
            <div class="no-posts">
                <p>দুঃখিত, এই ক্যাটাগরিতে এখনো কোনো পোস্ট করা হয়নি।</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="cyber-pagination">
        <?php the_posts_pagination(); ?>
    </div>
</div>

<style>
.ilybd-container {
    max-width: 1100px;
    margin: 30px auto;
    padding: 0 15px;
    color: #fff;
}

.cat-archive-header {
    background: rgba(0, 255, 136, 0.05);
    padding: 30px;
    border-left: 5px solid #00ff88;
    margin-bottom: 40px;
    border-radius: 0 15px 15px 0;
}

.archive-title {
    font-size: 28px;
    margin: 0;
    color: #00ff88;
}

.glitch-text { color: #fff; opacity: 0.7; }

.post-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.cyber-post-card {
    background: #0d1117;
    border: 1px solid rgba(0, 255, 136, 0.1);
    border-radius: 15px;
    overflow: hidden;
    transition: 0.3s;
}

.cyber-post-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0, 255, 136, 0.2);
    border-color: #00ff88;
}

.post-thumb img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.post-details { padding: 20px; }

.post-title a {
    color: #fff;
    text-decoration: none;
    font-size: 20px;
    font-weight: 700;
}

.post-title a:hover { color: #00ff88; }

.post-meta {
    font-size: 12px;
    color: #888;
    margin: 10px 0;
}

.post-excerpt {
    font-size: 14px;
    line-height: 1.6;
    color: #ccc;
    margin-bottom: 20px;
}

.read-more-btn {
    display: inline-block;
    padding: 8px 20px;
    background: #00ff88;
    color: #000;
    font-weight: 700;
    border-radius: 5px;
    text-decoration: none;
}

.no-posts {
    text-align: center;
    padding: 50px;
    background: #1a1f26;
    border-radius: 15px;
}
</style>

<?php get_footer(); ?>
