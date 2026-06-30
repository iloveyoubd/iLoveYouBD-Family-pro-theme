<?php
/**
 * Next-Gen Cyber Search Results Template (2040 Ecosystem)
 * Theme: ilybd-neon-v1-pro
 */
get_header(); 

global $wp_query;
$query_time = timer_stop(0, 3); // Get exact query execution speed
$found_posts_count = $wp_query->found_posts;
$search_query = get_search_query();
?>

<div class="nextgen-archive-viewport search-viewport" style="background: #070b13; color: #c9d1d9; min-height: 100vh; padding: 30px 12px 80px; font-family: 'Inter', sans-serif;">
    <div style="max-width: 900px; margin: 0 auto; width: 100%;">

        <!-- 1. BREADCRUMB -->
        <nav aria-label="Breadcrumb" style="margin-bottom: 20px; font-size: 12px; font-family: monospace; opacity: 0.85;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #64748b; text-decoration: none; transition: color 0.2s;">HOME</a>
            <span style="color: #475569; margin: 0 8px;">/</span>
            <span style="color: #00f0ff; text-decoration: none; font-weight: bold; text-transform: uppercase;">SEARCH SYSTEM / অনুসন্ধান ইঞ্জিন</span>
        </nav>

        <!-- 2. COMPACT SEARCH METRIC DASHBOARD -->
        <header class="search-status-panel" style="background: rgba(13, 21, 39, 0.4); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 15px;">
            <h1 style="color: #fff; font-size: 16px; font-weight: 700; margin: 0; font-family: 'Space Grotesk', sans-serif;">
                🔍 ফলাফল: <span style="color: #00f0ff;">&ldquo;<?php echo esc_html($search_query); ?>&rdquo;</span>
            </h1>
            <div style="display: flex; gap: 10px; font-family: monospace; font-size: 11px;">
                <div style="background: rgba(0, 255, 65, 0.05); border: 1px solid rgba(0, 255, 65, 0.15); color: #00ff41; padding: 4px 10px; border-radius: 6px;">
                    🎯 FOUND: <b><?php echo $found_posts_count; ?></b>
                </div>
            </div>
        </header>

        <!-- 3. SECONDARY SEARCH BOX ENGINE FOR QUICK RE-SEARCH -->
        <div class="search-refined-box-wrapper" style="max-width: 100%; margin-bottom: 30px;">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="position: relative; display: flex; align-items: center; width: 100%;">
                <input type="search" placeholder="নতুন কিছু লিখে আবার খুঁজুন..." value="<?php echo esc_attr($search_query); ?>" name="s" style="width: 100%; padding: 10px 45px 10px 15px; font-size: 14px; background: #0c1118; border: 1.5px solid rgba(0, 240, 255, 0.25); border-radius: 8px; color: #fff; outline: none; transition: all 0.3s ease; font-family: sans-serif;" required onfocus="this.style.borderColor='#00f0ff';">
                <button type="submit" style="position: absolute; right: 6px; top: 50%; transform: translateY(-50%); background: linear-gradient(135deg, #00f0ff 0%, #00ff66 100%); border: none; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #000; font-size: 12px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <!-- 4. GOOGLE ADSENSE FRIENDLY SAFE ZONE (POLICY COMPLIANT) -->
        <?php if (get_option('ily_enable_adsense_placeholders', 1) == 1) : ?>
        <div class="search-adsense-safe-zone" style="margin-bottom: 25px; display:none;"></div>
        <?php endif; ?>

        <!-- 5. SEARCH RESULTS LIST GRID -->
        <h2 style="font-size: 11px; font-family: monospace; color: #64748b; text-transform: uppercase; margin: 0 0 15px 0; letter-spacing: 0.8px; display: flex; align-items: center; gap: 6px;">
            <span style="display:inline-block; width: 5px; height: 5px; background:#00f0ff; border-radius:50%;"></span>
            MATCHING DATABASE ENTRIES
        </h2>

        <div class="search-results-stack" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 40px;">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); 
                    $post_id = get_the_ID();
                    $post_type = get_post_type();
                    $permalink = get_permalink();
                    
                    // Categorize type dynamically with gorgeous next-level labels
                    $type_badge = array('text' => 'ARTICLE', 'color' => '#00e5ff', 'bg' => 'rgba(0, 229, 255, 0.06)', 'border' => 'rgba(0, 229, 255, 0.25)');
                    
                    if ($post_type === 'ilybd_question') {
                        $type_badge = array('text' => 'Q&A', 'color' => '#00ff41', 'bg' => 'rgba(0, 255, 65, 0.06)', 'border' => 'rgba(0, 255, 65, 0.25)');
                    } elseif ($post_type === 'ilybd_sms') {
                        $type_badge = array('text' => 'SMS', 'color' => '#ff2e93', 'bg' => 'rgba(255, 46, 147, 0.06)', 'border' => 'rgba(255, 46, 147, 0.25)');
                    } elseif ($post_type === 'ilybd_story') {
                        $type_badge = array('text' => 'STORY', 'color' => '#ffb703', 'bg' => 'rgba(255, 183, 3, 0.06)', 'border' => 'rgba(255, 183, 3, 0.25)');
                    } elseif ($post_type === 'ilybd_phone_review') {
                        $type_badge = array('text' => 'REVIEW', 'color' => '#9d4edd', 'bg' => 'rgba(157, 78, 221, 0.06)', 'border' => 'rgba(157, 78, 221, 0.25)');
                    } elseif ($post_type === 'apps') {
                        $type_badge = array('text' => 'APP', 'color' => '#00ffcc', 'bg' => 'rgba(0, 255, 204, 0.06)', 'border' => 'rgba(0, 255, 204, 0.25)');
                    }
                ?>
                    
                    <a href="<?php echo esc_url($permalink); ?>" class="search-result-compact-item" style="text-decoration: none; display: block;">
                        <article style="background: #0d1527; border: 1px solid rgba(255, 255, 255, 0.04); border-radius: 10px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; transition: all 0.2s; box-shadow: 0 2px 10px rgba(0,0,0,0.15);" onmouseover="this.style.borderColor='<?php echo $type_badge['color']; ?>4d'; this.style.background='rgba(13,21,39,0.8)';" onmouseout="this.style.borderColor='rgba(255, 255, 255, 0.04)'; this.style.background='#0d1527';">
                            <!-- Left Edge Marker -->
                            <div style="width: 4px; height: 30px; border-radius: 4px; background: <?php echo $type_badge['color']; ?>; flex-shrink: 0;"></div>
                            
                            <!-- Main Title Area -->
                            <div style="flex: 1;">
                                <h3 style="font-size: 15px; font-weight: 600; margin: 0; line-height: 1.4; color: #fff; font-family: 'Inter', sans-serif;">
                                    <?php the_title(); ?>
                                </h3>
                            </div>
                            
                            <!-- Badge Right -->
                            <div style="flex-shrink: 0;">
                                <span style="background: <?php echo $type_badge['bg']; ?>; color: <?php echo $type_badge['color']; ?>; border: 1px solid <?php echo $type_badge['border']; ?>; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; font-family: monospace; letter-spacing: 0.5px;">
                                    <?php echo esc_html($type_badge['text']); ?>
                                </span>
                            </div>
                        </article>
                    </a>

                <?php endwhile; ?>

                <!-- Pagination for search results -->
                <?php 
                $search_pagination = get_the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('« পূর্ববর্তী', 'ilybd-neon'),
                    'next_text' => __('পরবর্তী »', 'ilybd-neon'),
                )); 
                if (!empty($search_pagination)) :
                ?>
                <div class="search-pagination-wrapper" style="margin-top: 30px; display: flex; justify-content: center;">
                    <?php echo $search_pagination; ?>
                </div>
                <?php endif; ?>

            <?php else : ?>
                <div style="background: #0d1527; border: 1px dashed rgba(255,255,255,0.08); border-radius: 14px; padding: 60px 20px; text-align: center; color: #8b949e; margin-bottom: 30px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 32px; color: #ff3e3e; margin-bottom: 15px; filter: drop-shadow(0 0 10px rgba(255,62,62,0.3));"></i>
                    <h3 style="color:#fff; font-size:18px; margin-top:0; margin-bottom:8px;">কোনো মিল পাওয়া যায়নি!</h3>
                    <p style="margin: 0; font-size: 13.5px; color: #8b949e; max-width:500px; margin: 0 auto; line-height: 1.5;">দুঃখিত! আপনার জিজ্ঞাসিত <b>&ldquo;<?php echo esc_html($search_query); ?>&rdquo;</b> কিওয়ার্ডটির সাথে সম্পর্কিত কোনো নিবন্ধ বা প্রশ্নোত্তর পাওয়া যায়নি। দয়া করে ভিন্ন কিওয়ার্ড ব্যবহার করে পুনরায় অনুসন্ধান করুন।</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
/* Custom styled search pagination matching Neon ecosystem */
.search-pagination-wrapper .nav-links {
    display: inline-flex;
    gap: 8px;
    align-items: center;
}
.search-pagination-wrapper .page-numbers {
    background: #0d1527;
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #8b949e;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
    transition: all 0.2s;
}
.search-pagination-wrapper .page-numbers.current,
.search-pagination-wrapper .page-numbers:hover {
    background: rgba(0, 240, 255, 0.1);
    border-color: #00f0ff;
    color: #00f0ff;
    box-shadow: 0 0 10px rgba(0, 240, 255, 0.15);
}
</style>

<?php 
get_footer();
