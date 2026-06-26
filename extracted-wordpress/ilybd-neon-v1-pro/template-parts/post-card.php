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
$mobile_post_layout = get_option('ilybd_mobile_post_layout', 'modern_card');
?>

<article class="pro-post-card<?php echo ($mobile_post_layout === 'classic_compact_wapka') ? ' mobile-classic-compact' : ''; ?>">

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

                <div class="meta-link no-click" title="Total Views">
                    <i class="fa-regular fa-eye" style="color: <?php echo $neon; ?>;"></i> 
                    <span><?php echo esc_html($view_count); ?></span>
                </div>

                <a href="<?php echo $comment_link; ?>" class="meta-link" title="Comments">
                    <i class="fa-regular fa-comment" style="color: <?php echo $neon; ?>;"></i> 
                    <span><?php echo get_comments_number(); ?></span>
                </a>
                
                <a href="<?php echo $post_link; ?>#ilybd-like-container" class="meta-link like-btn" title="Total Likes">
                    <i class="fa-regular fa-heart" style="color: <?php echo $neon; ?>;"></i> 
                    <span><?php echo esc_html($like_count); ?></span>
                </a>

                <a href="<?php echo $post_link; ?>" class="meta-link" title="Published Time">
                    <i class="fa-regular fa-clock" style="color: <?php echo $neon; ?>;"></i> 
                    <span><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</span>
                </a>

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
    justify-content: flex-start;
    gap: 12px;
    width: 100%;
    overflow-x: auto;
    white-space: nowrap;
    flex-wrap: nowrap;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE, Edge */
}

.meta-wrapper::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
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
    padding: 8px 6px; /* Increased touch target area */
    margin: -8px -2px; /* Adjusted to keep layout visually similar */
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

/* ====================================================================
   Wapka-Inspired Classic Compact Layout Custom overrides 2040 for Mobile 
   ==================================================================== */
@media screen and (max-width: 768px) {
    .pro-post-card.mobile-classic-compact {
        display: flex !important;
        flex-direction: row !important;
        align-items: flex-start !important;
        padding: 12px !important;
        margin-bottom: 14px !important;
        background: #0d1321 !important;
        background-image: none !important;
        border: 1.5px solid rgba(0, 240, 255, 0.2) !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.7), inset 0 1px 0 rgba(255,255,255,0.05) !important;
        gap: 14.5px !important;
        border-radius: 14px !important;
        overflow: hidden !important;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
    }
    
    .pro-post-card.mobile-classic-compact:hover {
        transform: translateY(-2px) !important;
        border-color: <?php echo $neon; ?> !important;
        box-shadow: 0 8px 20px <?php echo $neon; ?>33, 0 0 10px <?php echo $neon; ?>15 !important;
    }
    
    .pro-post-card.mobile-classic-compact .post-media {
        width: 100px !important;
        height: 100px !important;
        flex-shrink: 0 !important;
        border-radius: 10px !important;
        overflow: hidden !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        position: relative !important;
    }
    
    .pro-post-card.mobile-classic-compact .post-media img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        transition: transform 0.5s ease !important;
    }
    
    .pro-post-card.mobile-classic-compact:hover .post-media img {
        transform: scale(1.1) !important;
    }
    
    .pro-post-card.mobile-classic-compact .cat-badge {
        font-size: 8px !important;
        top: 4px !important;
        left: 4px !important;
        padding: 2px 5px !important;
        border-radius: 4px !important;
        background: <?php echo $neon; ?> !important;
        color: #000 !important;
        font-weight: 800 !important;
    }
    
    .pro-post-card.mobile-classic-compact .card-tts-trigger {
        top: 4px !important;
        right: 4px !important;
        width: 24px !important;
        height: 24px !important;
        font-size: 9px !important;
    }
    
    .pro-post-card.mobile-classic-compact .post-info {
        padding: 0 !important;
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: flex-start !important;
        gap: 6px !important;
        min-height: auto !important;
        overflow: hidden !important;
        text-align: left !important;
    }
    
    .pro-post-card.mobile-classic-compact .post-title {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        margin: 0 !important;
        line-height: 1.4 !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
        text-align: left !important;
    }
    
    .pro-post-card.mobile-classic-compact .post-title a {
        color: #ffffff !important;
        text-decoration: none !important;
        transition: color 0.2s !important;
    }
    
    .pro-post-card.mobile-classic-compact .post-title a:hover {
        color: <?php echo $neon; ?> !important;
    }
    
    .pro-post-card.mobile-classic-compact .post-excerpt {
        font-size: 11.5px !important;
        color: #94a3b8 !important;
        margin: 0 !important;
        line-height: 1.45 !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
        text-align: left !important;
    }
    
    .pro-post-card.mobile-classic-compact .rgb-divider {
        display: none !important;
    }
    
    .pro-post-card.mobile-classic-compact .meta-footer {
        margin-top: 4px !important;
        width: 100% !important;
        border-top: 1px dashed rgba(255, 255, 255, 0.08) !important;
        padding-top: 6px !important;
    }
    
    .pro-post-card.mobile-classic-compact .meta-wrapper {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: wrap !important;
        gap: 6px 12px !important;
        overflow-x: visible !important;
        justify-content: flex-start !important;
        align-items: center !important;
        width: 100% !important;
    }
    
    .pro-post-card.mobile-classic-compact .meta-link {
        font-size: 10px !important;
        margin-right: 0 !important;
        gap: 4px !important;
        color: #94a3b8 !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        line-height: 1.2 !important;
        padding: 8px 6px !important; /* Touch target fix */
        margin: -8px -2px !important;
    }
    
    .pro-post-card.mobile-classic-compact .meta-link i {
        color: <?php echo $neon; ?> !important;
        font-size: 11px !important;
        width: 12px !important;
        text-align: center !important;
    }
    
    .pro-post-card.mobile-classic-compact .stats-group {
        display: contents !important;
    }
    
    .pro-post-card.mobile-classic-compact .round-avatar {
        width: 16px !important;
        height: 16px !important;
        border: 1.5px solid <?php echo $neon; ?> !important;
        border-radius: 50% !important;
    }
    
    .pro-post-card.mobile-classic-compact .author-group {
        height: 16px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4.5px !important;
    }
    
    .pro-post-card.mobile-classic-compact .author-name {
        margin-left: 0 !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        white-space: normal !important; /* Allow names to display fully */
    }
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

    function sharePostDirectly(title, url, btn, event) {
        event.preventDefault();
        event.stopPropagation();

        // 1. Double protection copy link to clipboard first
        var tempInput = document.createElement('input');
        tempInput.style.position = 'fixed';
        tempInput.style.opacity = '0';
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        // 2. Play beautiful micro visual transition on the button
        var textNode = btn.querySelector('.share-text');
        var iconNode = btn.querySelector('i');
        
        var originalText = textNode ? textNode.innerText : 'শেয়ার';
        var originalIconClass = iconNode ? iconNode.className : 'fa-solid fa-share-nodes';
        
        if (textNode) textNode.innerText = 'কপিড!';
        if (iconNode) iconNode.className = 'fa-solid fa-check';
        btn.style.color = '<?php echo $neon; ?>';

        // 3. Trigger beautiful cyber notification bar
        showCyberToast('লিংক কপি করা হয়েছে! (Post Link Cyberspace Copied)');

        setTimeout(function() {
            if (textNode) textNode.innerText = originalText;
            if (iconNode) iconNode.className = originalIconClass;
            btn.style.color = '#8b949e';
        }, 1500);

        // 4. Try native navigator share if supported (for mobile device native sheets overlay)
        if (navigator.share) {
            setTimeout(function() {
                navigator.share({
                    title: title,
                    url: url
                }).catch(function(e) { console.log('Native share canceled or block.'); });
            }, 300);
        }
    }

    function showCyberToast(msg) {
        var toast = document.getElementById('cyber-share-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'cyber-share-toast';
            toast.style.cssText = 'position:fixed; bottom:85px; left:50%; transform:translateX(-50%) translateY(20px); background:#0d1117; color:<?php echo $neon; ?>; border:1.5px solid <?php echo $neon; ?>; padding:12px 24px; border-radius:30px; font-weight:bold; font-size:12.5px; z-index:999999; box-shadow:0 0 20px <?php echo $neon; ?>44; display:flex; align-items:center; gap:8px; transition:all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275); opacity:0; pointer-events:none; font-family:system-ui; white-space:nowrap; text-transform:uppercase;';
            document.body.appendChild(toast);
        }
        toast.innerHTML = '<span style="color:<?php echo $neon; ?>;">⚡</span> ' + msg;
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';
        
        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-50%) translateY(20px)';
        }, 3200);
    }

    document.addEventListener('click', function() {
        var allDropdowns = document.querySelectorAll('.postcard-share-dropdown');
        allDropdowns.forEach(function(dd) {
            dd.style.display = 'none';
        });
    });
}
</script>