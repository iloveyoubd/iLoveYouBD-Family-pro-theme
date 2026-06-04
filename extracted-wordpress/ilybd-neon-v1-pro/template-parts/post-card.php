<?php
/**
 * ILYBD Master Post Card - Final Pro Version
 * Fix: Author Name Alignment (Perfectly Centered with Avatar)
 */

// কনফিগারেশন ভেরিয়েবল
$neon         = esc_attr(get_option('ilybd_main_color', '#00ff41'));
$post_link    = esc_url(get_permalink());
$author_id    = get_the_author_meta('ID');
$comment_link = get_comments_link();
$view_count   = get_post_meta(get_the_ID(), 'ilybd_post_views_count', true) ?: '0';
$like_count   = get_post_meta(get_the_ID(), '_likes', true) ?: '0';
?>

<article class="pro-post-card">

    <div class="post-media">
        <a href="<?php echo $post_link; ?>" aria-label="<?php the_title(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', ['alt' => esc_attr(get_the_title())]); ?>
            <?php else : ?>
                <div class="no-thumb">ILYBD PRO</div>
            <?php endif; ?>

            <span class="cat-badge">
                <?php
                $categories = get_the_category();
                echo !empty($categories) ? esc_html($categories[0]->name) : 'Tech';
                ?>
            </span>
        </a>
        
        <!-- High Tech Cognitive TTS Card Button (2040 Cyber style) -->
        <button class="card-tts-trigger" 
                data-title="<?php echo esc_attr(get_the_title()); ?>" 
                data-excerpt="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt() ?: get_the_content())); ?>" 
                title="পোস্টটি শুনুন (Listen to summary)" 
                onclick="toggleCardPlayback(this, event)"
                style="position: absolute; top: 12px; right: 12px; width: 34px; height: 34px; border-radius: 50%; background: rgba(4, 7, 12, 0.85); border: 1.5px solid <?php echo $neon; ?>; display: flex; align-items: center; justify-content: center; color: <?php echo $neon; ?>; font-size: 14px; cursor: pointer; transition: all 0.3s; z-index: 55; box-shadow: 0 0 12px <?php echo $neon; ?>55; backdrop-filter: blur(4px);"
                onmouseover="this.style.background='<?php echo $neon; ?>'; this.style.color='#000'; this.style.boxShadow='0 0 18px <?php echo $neon; ?>';" 
                onmouseout="if(!this.classList.contains('playing')){ this.style.background='rgba(4, 7, 12, 0.85)'; this.style.color='<?php echo $neon; ?>'; this.style.boxShadow='0 0 12px <?php echo $neon; ?>55'; }">
            <i class="fa-solid fa-volume-high"></i>
        </button>
    </div>

    <div class="post-info">
        <h2 class="post-title">
            <a href="<?php echo $post_link; ?>">
                <?php echo esc_html(wp_trim_words(get_the_title(), 11, '...')); ?>
            </a>
        </h2>

        <p class="post-excerpt">
            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 16, '...')); ?>
        </p>

        <div class="rgb-divider"></div>

        <div class="meta-footer">
            <div class="meta-wrapper">
                
                <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="meta-link author-group">
                    <?php echo get_avatar($author_id, 22, '', 'Author Avatar', array('class' => 'round-avatar')); ?>
                    <span class="author-name"><?php the_author(); ?></span>
                </a>

                <div class="stats-group">
                    <a href="<?php echo $post_link; ?>" class="meta-link" title="Published Time">
                        <i class="fa-regular fa-clock"></i> 
                        <span><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</span>
                    </a>
                    
                    <a href="<?php echo $comment_link; ?>" class="meta-link" title="Comments">
                        <i class="fa-regular fa-comment"></i> 
                        <span><?php echo get_comments_number(); ?></span>
                    </a>
                    
                    <div class="meta-link no-click" title="Total Views">
                        <i class="fa-regular fa-eye"></i> 
                        <span><?php echo esc_html($view_count); ?></span>
                    </div>
                    
                    <a href="<?php echo $post_link; ?>#ilybd-like-container" class="meta-link like-btn" title="Total Likes">
                        <i class="fa-regular fa-heart"></i> 
                        <span><?php echo esc_html($like_count); ?></span>
                    </a>

                    <!-- Share Button Trigger with interactive Dropdown Option -->
                    <div class="meta-link share-wrapper" style="position: relative; display: inline-block;">
                        <button class="meta-link share-btn-trigger" title="Share Post" aria-label="Share Post" style="background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; gap: 4px; color: #8b949e; transition: 0.3s;" onclick="togglePostCardShare(this, event)">
                            <i class="fa-solid fa-share-nodes" style="color: <?php echo $neon; ?>;"></i> 
                            <span>শেয়ার</span>
                        </button>
                        <div class="postcard-share-dropdown" style="display: none; position: absolute; bottom: 30px; right: 0; background: #1c2128; border: 1.5px solid <?php echo $neon; ?>; box-shadow: 0 5px 15px rgba(0,0,0,0.8), 0 0 10px <?php echo $neon; ?>44; border-radius: 8px; padding: 8px; z-index: 999; width: 156px;">
                            <div style="font-size: 10px; color: #8b949e; text-transform: uppercase; font-weight: 800; margin-bottom: 6px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 4px; text-align: center;">Share options</div>
                            <div class="dropdown-share-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_link; ?>" target="_blank" style="width: 28px; height: 28px; border-radius: 50%; background: #1877f2; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; text-decoration: none;" title="Facebook" aria-label="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title()) . ' ' . $post_link; ?>" target="_blank" style="width: 28px; height: 28px; border-radius: 50%; background: #25d366; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; text-decoration: none;" title="WhatsApp" aria-label="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://t.me/share/url?url=<?php echo $post_link; ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" style="width: 28px; height: 28px; border-radius: 50%; background: #0088cc; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 12px; text-decoration: none;" title="Telegram" aria-label="Share on Telegram">
                                    <i class="fab fa-telegram-plane"></i>
                                </a>
                                <button onclick="copyPostCardLink('<?php echo esc_js(get_permalink()); ?>', this, event)" style="width: 28px; height: 28px; border-radius: 50%; background: <?php echo $neon; ?>; display: flex; align-items: center; justify-content: center; color: #000; font-size: 12px; border: none; cursor: pointer;" title="Copy Link" aria-label="Copy post link">
                                    <i class="fa-solid fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</article>

<style>
/* কার্ডের মূল কাঠামো */
.pro-post-card {
    background: #0d1117;
    border-radius: 12px;
    margin-bottom: 22px;
    overflow: hidden;
    position: relative;
    border: 1px solid transparent;
    background-image: linear-gradient(#0d1117, #0d1117), 
                      linear-gradient(90deg, #ff0000, #00ff41, #0000ff, #ff0000);
    background-origin: border-box;
    background-clip: content-box, border-box;
    box-shadow: 0 4px 15px rgba(0,0,0,0.5);
    transition: transform 0.3s ease;
}

.pro-post-card:hover {
    transform: translateY(-5px);
}

.post-media { height: 180px; position: relative; overflow: hidden; }
.post-media img { 
    width: 100%; height: 100%; object-fit: cover; 
    transition: scale 0.5s ease;
}
.pro-post-card:hover .post-media img {
    scale: 1.1;
}

.no-thumb {
    height: 100%; background: #161b22; color: #8b949e;
    display: flex; align-items: center; justify-content: center;
    font-weight: bold; letter-spacing: 2px;
}

.rgb-divider {
    height: 1px; width: 100%; margin: 12px 0;
    background: linear-gradient(90deg, #ff0000, #00ff41, #0000ff, #ff0000);
    background-size: 300% 100%;
    animation: rgb-move 4s linear infinite;
    opacity: 0.4;
}

@keyframes rgb-move { 0%{background-position:0% 50%} 100%{background-position:100% 50%} }

.post-info { padding: 15px; }
.post-title { font-size: 17px; margin-bottom: 8px; line-height: 1.4; font-weight: 600; }
.post-title a { color: #ffffff; text-decoration: none; transition: 0.2s; }
.post-title a:hover { color: <?php echo $neon; ?>; }

.post-excerpt { color: #8b949e; font-size: 13.5px; margin-bottom: 15px; line-height: 1.5; }

/* Meta Footer Styling */
.meta-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.meta-link {
    display: flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    color: #8b949e;
    font-size: 11.5px;
    white-space: nowrap;
    transition: 0.3s;
}

.meta-link:hover { color: <?php echo $neon; ?>; }
.no-click { cursor: default; }

/* Author Group Alignment Fix */
.author-group { 
    display: flex; 
    align-items: center; /* এটি ইমেজ এবং টেক্সটকে ভার্টিক্যালি মাঝখানে রাখবে */
    height: 22px; /* ইমেজের হাইটের সমান */
}

.author-name { 
    font-size: 12px; 
    font-weight: 600; 
    margin-left: 8px; 
    display: inline-block;
    line-height: 1; /* টেক্সটকে উপরে তোলার জন্য লাইন হাইট কমানো হয়েছে */
    margin-top: -1px; /* আরও নিখুঁতভাবে উপরে তোলার জন্য */
}

.round-avatar {
    border-radius: 50% !important;
    border: 1px solid <?php echo $neon; ?>;
    width: 22px;
    height: 22px;
    display: block; /* এক্সট্রা স্পেস দূর করার জন্য */
}

.stats-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.cat-badge {
    position: absolute; top: 12px; left: 12px;
    color: #ffffff !important; font-size: 11px; padding: 4.5px 12px;
    border-radius: 6px; font-weight: 800;
    z-index: 2; text-transform: uppercase;
    letter-spacing: 0.5px;
    background: linear-gradient(135deg, <?php echo $neon; ?> 0%, rgba(13, 17, 23, 0.85) 100%) !important;
    border: 1px solid <?php echo $neon; ?>ea;
    box-shadow: 0 0 10px <?php echo $neon; ?>55;
    text-shadow: 0 1px 2px rgba(0,0,0,0.8);
    transition: all 0.3s ease;
}
.pro-post-card:hover .cat-badge {
    transform: scale(1.05) translate(2px, -1px);
    box-shadow: 0 0 15px <?php echo $neon; ?>aa;
    border-color: #ffffff;
}

/* মোবাইলের জন্য মেটা স্ক্রলিং */
@media (max-width: 480px) {
    .meta-wrapper {
        overflow-x: auto;
        scrollbar-width: none;
        justify-content: flex-start;
    }
    .meta-wrapper::-webkit-scrollbar { display: none; }
}
</style>

<script>
if (typeof togglePostCardShare === 'undefined') {
    function togglePostCardShare(btn, event) {
        event.preventDefault();
        event.stopPropagation();
        var dropdown = btn.nextElementSibling;
        var allDropdowns = document.querySelectorAll('.postcard-share-dropdown');
        allDropdowns.forEach(function(dd) {
            if (dd !== dropdown) { dd.style.display = 'none'; }
        });
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    }

    function copyPostCardLink(url, btn, event) {
        event.preventDefault();
        event.stopPropagation();
        var tempInput = document.createElement('input');
        document.body.appendChild(tempInput);
        tempInput.value = url;
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        var originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-check" style="color: #000;"></i>';
        btn.style.background = '#00ff41';
        setTimeout(function() {
            btn.innerHTML = originalHTML;
            btn.style.background = '<?php echo $neon; ?>';
        }, 1200);
    }

    document.addEventListener('click', function() {
        var allDropdowns = document.querySelectorAll('.postcard-share-dropdown');
        allDropdowns.forEach(function(dd) {
            dd.style.display = 'none';
        });
    });
}
</script>