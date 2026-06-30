<?php
/**
 * ILYBD Neon v2 - Rounded RGB Design with Sticky RGB Line
 */

get_header(); ?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 0;">
        
        <?php while ( have_posts() ) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <header class="ultra-sticky-header">
                    <h1 class="rgb-text-lighting">
                        <?php the_title(); ?>
                    </h1>
                    <div class="sticky-rgb-line"></div>
                </header>

                <div class="slim-rgb-container">
                    <div class="inner-page-content">
                        <?php the_content(); ?>
                    </div>
                </div>

            </article>

        <?php endwhile; ?>

    </div>
</div>

<style>
    /* মেইন ব্যাকগ্রাউন্ড */
    .cyber-page-wrapper {
        background: #0a0a0c;
        min-height: 100vh;
    }

    /* ১. পেজ টাইটেল (নন-স্টিকি ও ন্যাচারাল স্ক্রলিং) */
    .ultra-sticky-header {
        position: relative;
        z-index: 10;
        background: transparent;
        padding: 10px 0 0 0;
        margin-bottom: 25px;
        text-align: center;
    }

    /* টাইটেল টেক্সট আরজিবি */
    .rgb-text-lighting {
        font-size: 1.6rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 0 0 8px 0;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rgb_flow 3s linear infinite;
    }

    /* টাইটেলের নিচের আরজিবি লাইটিং লাইন */
    .sticky-rgb-line {
        height: 2px; /* লাইনের পুরুত্ব */
        width: 100%;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        animation: rgb_flow 3s linear infinite;
        box-shadow: 0 2px 10px rgba(0, 255, 65, 0.3); /* হালকা গ্লো */
    }

    /* ২. স্লিম আরজিবি বর্ডার বক্স */
    .slim-rgb-container {
        position: relative;
        margin: 5px;
        padding: 1px;
        background: linear-gradient(var(--angle), #ff0000, #00ff00, #0000ff, #ff0000);
        animation: 4s rotate-border linear infinite;
        border-radius: 25px;
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

    /* ভেতরের কন্টেন্ট এরিয়া */
    .inner-page-content {
        background: #0f0f12;
        border-radius: 24px;
        padding: 10px;
        color: #ffffff;
    }

    @keyframes rgb_flow {
        to { background-position: 200% center; }
    }

    /* মোবাইলের জন্য ঠিক করা */
    @media (max-width: 768px) {
        .ultra-sticky-header { padding-top: 8px; margin-bottom: 15px; }
        .rgb-text-lighting { font-size: 1.2rem; }
        .slim-rgb-container { margin: 5px; border-radius: 20px; } 
        .inner-page-content { border-radius: 19px; padding: 5px; }
    }
</style>

<?php
get_footer();
