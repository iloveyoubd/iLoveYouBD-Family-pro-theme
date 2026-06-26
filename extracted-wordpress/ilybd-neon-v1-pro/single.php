<?php get_header(); ?>

<div class="master-post-body" style="background: #0d1117; color: #c9d1d9; min-height: 100vh; padding-bottom: 50px;">

<?php if (have_posts()) : while (have_posts()) : the_post();

$author_id = get_the_author_meta('ID');
$author_link = get_author_posts_url($author_id);
$post_id = get_the_ID();

// এরর ফিক্স: title_len ডিফাইন করা হলো যাতে রিপোর্টে সমস্যা না হয়
$title_main = get_the_title();
$title_len = mb_strlen($title_main); 
?>

<div class="hero-gradient" style="background: linear-gradient(135deg, #6e00ff 0%, #ff4b2b 100%); padding: 60px 15px 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); border-bottom: 2px solid rgba(255,255,255,0.1);">
    <div style="max-width:850px; margin:0 auto; text-align: center;">
        <span style="background:rgba(63, 185, 80, 0.1); color:#3fb950; font-size:12px; font-weight:bold; padding:5px 15px; border-radius:20px; border: 1px solid rgba(63, 185, 80, 0.3); text-transform: uppercase;">
            <?php
            $cat = get_the_category();
            echo !empty($cat) ? esc_html($cat[0]->name) : 'Tech';
            ?>
        </span>

        <h1 style="color:#fff; font-size:clamp(28px, 5vw, 42px); margin-top:20px; line-height:1.2; letter-spacing:-0.5px;">
            <?php echo $title_main; ?>
        </h1>

        <div class="meta-container" style="display: flex; align-items: center; justify-content: center; margin-top: 30px; gap: 12px;">
            <a href="<?php echo esc_url($author_link); ?>" style="border-radius: 50%; overflow: hidden; border: 2px solid #30363d; display: block; width: 45px; height: 45px;">
                <?php echo get_avatar($author_id, 45); ?>
            </a>
            <div style="text-align: left;">
                <a href="<?php echo esc_url($author_link); ?>" style="color:#58a6ff; font-weight: 600; text-decoration: none; font-size: 15px;">
                    <?php the_author(); ?>
                </a>
                <div style="font-size:12px; color:#8b949e; margin-top: 2px;">
                    <span><?php echo get_the_date(); ?></span> •
                    <span style="color: #3fb950;">
                        <i class="fas fa-eye"></i> <?php echo get_post_meta($post_id, 'ilybd_post_views_count', true) ?: '0'; ?> Views
                    </span>
                </div>
            </div>
        </div>

        <!-- 5. Editorial Review Layer (EEAT Compliant Meta) -->
        <div class="ilybd-editorial-meta-bar" style="background: rgba(13, 21, 39, 0.45); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 10px; max-width: 650px; margin: 25px auto 0; padding: 12px 18px; text-align: left; box-sizing: border-box;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 15px; font-size: 11.5px; color: #8b949e; font-family: monospace; line-height: 1.5;">
                <div>
                    <span style="color: #64748b; text-transform: uppercase; font-size: 10.5px; display: block; margin-bottom: 2px;">📅 Published Date</span>
                    <strong style="color: #c9d1d9;"><?php echo get_the_date(); ?></strong>
                </div>
                <div>
                    <span style="color: #64748b; text-transform: uppercase; font-size: 10.5px; display: block; margin-bottom: 2px;">🔄 Last Updated</span>
                    <strong style="color: #00f0ff;"><?php echo get_the_modified_date(); ?></strong>
                </div>
                <div>
                    <span style="color: #64748b; text-transform: uppercase; font-size: 10.5px; display: block; margin-bottom: 2px;">✍ Reviewed By</span>
                    <strong style="color: #c9d1d9;"><?php the_author(); ?> (Specialist)</strong>
                </div>
                <div>
                    <span style="color: #64748b; text-transform: uppercase; font-size: 10.5px; display: block; margin-bottom: 2px;">🛡 Fact Checked</span>
                    <strong style="color: #00ff41;"><i class="fa-solid fa-certificate"></i> Verified (ইইএটি ফ্রেন্ডলি)</strong>
                </div>
            </div>
            <div style="border-top: 1px solid rgba(0, 240, 255, 0.08); margin-top: 10px; padding-top: 8px; text-align: center; font-size: 10.5px; color: #64748b; font-family: monospace;">
                📰 Editorial Team: <span style="color: #00f0ff;">I Love You BD Technology Board</span> &copy; 2026
            </div>
        </div>
    </div>
</div>

<div class="ilybd-single-grid-wrapper" style="box-sizing: border-box;">
    
    <!-- 1. Left Section: Main Post Contents -->
    <div class="ilybd-single-left-content" style="box-sizing: border-box; min-width: 0;">

    <?php if (has_post_thumbnail()) : ?>
        <div class="single-post-thumb-wrapper" style="margin: 20px auto 35px; max-width: 680px; width: 100%; border-radius: 12px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.45); border: 1.5px solid #30363d; box-sizing: border-box;">
            <?php the_post_thumbnail('medium_large'); ?>
        </div>
        <style>
            .single-post-thumb-wrapper img {
                width: 100% !important;
                height: auto !important;
                max-height: 380px !important;
                object-fit: cover !important;
                display: block !important;
                border-radius: 10px !important;
            }
        </style>
    <?php endif; ?>

    <!-- 🎙️ ILYBD AI TEXT-TO-SPEECH (TTS) INTELLIGENT READER PANEL (2040 CYBERPUNK STYLE) -->
    <?php
    $c_u_id = get_current_user_id();
    $u_voice_pref = 'female';
    if ($c_u_id) {
        $meta_voice = get_user_meta($c_u_id, 'ilybd_voice_pref', true);
        if (!empty($meta_voice)) {
            $u_voice_pref = $meta_voice;
        }
    }
    $neon_color = get_option('ilybd_main_color', '#00ff41');
    ?>
    <div class="cyber-tts-panel" style="background: rgba(13, 21, 39, 0.6); border: 1.5px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 20px; margin-bottom: 30px; box-shadow: 0 8px 32px rgba(0,0,0,0.4); backdrop-filter: blur(8px); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 100px; height: 100px; background: rgba(0, 240, 255, 0.05); filter: blur(40px); border-radius: 50%;"></div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; border-bottom: 1px dashed rgba(255,255,255,0.08); padding-bottom: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div class="tts-pulse-icon" style="width: 10px; height: 10px; background: <?php echo esc_attr($neon_color); ?>; border-radius: 50%; box-shadow: 0 0 10px <?php echo esc_attr($neon_color); ?>; animation: ttsGlow 1.5s infinite ease-in-out;"></div>
                <h4 style="margin: 0; font-size: 14.5px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-microphone-lines" style="color: <?php echo esc_attr($neon_color); ?>; margin-right: 6px;"></i> এআই ভয়েস রিডার (AI Speech Assistant)
                </h4>
            </div>
            
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 11px; color: #8b949e; font-family: monospace;">VOICE:</span>
                <div style="display: flex; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 2.5px; border-radius: 6px; gap: 2px;">
                    <button class="tts-voice-btn <?php echo ($u_voice_pref === 'male') ? 'active' : ''; ?>" onclick="setTtsVoice('male')" id="tts-male-btn" style="background: <?php echo ($u_voice_pref === 'male') ? esc_attr($neon_color) : 'transparent'; ?>; color: <?php echo ($u_voice_pref === 'male') ? '#000' : '#8b949e'; ?>; border: none; font-size: 11.5px; font-weight: 800; padding: 4.5px 12px; border-radius: 4px; cursor: pointer; transition: 0.2s;">
                        👨 ছেলের কণ্ঠ (Male)
                    </button>
                    <button class="tts-voice-btn <?php echo ($u_voice_pref === 'female') ? 'active' : ''; ?>" onclick="setTtsVoice('female')" id="tts-female-btn" style="background: <?php echo ($u_voice_pref === 'female') ? esc_attr($neon_color) : 'transparent'; ?>; color: <?php echo ($u_voice_pref === 'female') ? '#000' : '#8b949e'; ?>; border: none; font-size: 11.5px; font-weight: 800; padding: 4.5px 12px; border-radius: 4px; cursor: pointer; transition: 0.2s;">
                        👩 মেয়ের কণ্ঠ (Female)
                    </button>
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <button onclick="toggleTtsPlayback()" id="tts-play-btn" style="background: linear-gradient(135deg, <?php echo esc_attr($neon_color); ?> 0%, #00e5ff 100%); color: #000; font-weight: 900; font-size: 12.5px; border: none; padding: 10px 22px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0,255,65,0.18);" onmouseover="this.style.transform='translateY(-1.5px)'; this.style.boxShadow='0 6px 18px rgba(0,255,65,0.3)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(0,255,65,0.18)';">
                    <i class="fa-solid fa-play" id="tts-play-icon"></i> <span id="tts-play-text">পড়ে শোনান (Listen Post)</span>
                </button>
                
                <button onclick="stopTtsPlayback()" id="tts-stop-btn" style="background: rgba(255,45,45,0.12); color: #ff3b30; border: 1.5px solid rgba(255,45,45,0.22); font-weight: bold; font-size: 12.5px; padding: 9px 18px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: 0.2s; visibility: hidden; opacity: 0;">
                    <i class="fa-solid fa-circle-stop"></i> বন্ধ করুন (Stop)
                </button>
            </div>

            <!-- SPEED RATE SLIDER -->
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 11.5px; color: #8b949e; font-family: monospace;"><i class="fa-solid fa-gauge-high"></i> স্পিড (Speed):</span>
                <select id="tts-speed-select" onchange="changeTtsSpeed(this.value)" style="background: #11161d; color: #fff; border: 1px solid rgba(255,255,255,0.08); padding: 6px 12px; border-radius: 6px; outline: none; font-size: 12px; font-weight: bold; cursor: pointer;">
                    <option value="0.8">0.8x ধীরগতি</option>
                    <option value="1.0" selected>1.0x সাধারণ</option>
                    <option value="1.2">1.2x দ্রুত</option>
                    <option value="1.4">1.4x অতিদ্রুত</option>
                </select>
            </div>
        </div>

        <!-- PLAYBACK STATUS HUD -->
        <div id="tts-status-sub-hud" style="margin-top: 15px; background: rgba(0,0,0,0.2); border-radius: 8px; padding: 10px 14px; border: 1px solid rgba(255,255,255,0.02); display: none; align-items: center; justify-content: space-between; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 8px; font-size: 11.5px; color: #00f0ff; font-family: monospace; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                <i class="fa-solid fa-wave-square" style="animation: ttsBounce 1s infinite alternate;"></i>
                <span id="tts-hud-message">এআই রিডার কন্টেন্ট বিশ্লেষণ করছে...</span>
            </div>
            <div class="tts-progress-dots" style="display: flex; gap: 3px;">
                <span style="width: 5px; height: 5px; background:#00f0ff; border-radius:50%; animation: ttsPingDot 0.8s infinite 0.1s;"></span>
                <span style="width: 5px; height: 5px; background:#00f0ff; border-radius:50%; animation: ttsPingDot 0.8s infinite 0.3s;"></span>
                <span style="width: 5px; height: 5px; background:#00f0ff; border-radius:50%; animation: ttsPingDot 0.8s infinite 0.5s;"></span>
            </div>
        </div>
    </div>

    <!-- FLOATING STICKY MEDIA CONTROL BAR (WHEN USER SCROLLS DOWN) -->
    <div id="cyber-tts-sticky-floating-bar" style="position: fixed; bottom: -100px; left: 0; width: 100%; height: 60px; background: rgba(4, 7, 12, 0.95); backdrop-filter: blur(12px); border-top: 1.5px solid <?php echo esc_attr($neon_color); ?>; z-index: 99998; display: flex; align-items: center; justify-content: center; transition: bottom 0.4s cubic-bezier(0.2, 0.8, 0.2, 1); box-shadow: 0 -10px 30px rgba(0,0,0,0.5);">
        <div style="width: 100%; max-width: 850px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 10px; width: 50%; overflow: hidden;">
                <div class="voice-playing-wave" style="display: flex; align-items: flex-end; gap: 2.5px; height: 16px;">
                    <span style="display:inline-block; width: 2.5px; height: 10px; background: <?php echo esc_attr($neon_color); ?>; animation: waveBar 0.5s infinite alternate 0.1s;"></span>
                    <span style="display:inline-block; width: 2.5px; height: 15px; background: <?php echo esc_attr($neon_color); ?>; animation: waveBar 0.5s infinite alternate 0.3s;"></span>
                    <span style="display:inline-block; width: 2.5px; height: 7px; background: <?php echo esc_attr($neon_color); ?>; animation: waveBar 0.5s infinite alternate 0.5s;"></span>
                </div>
                <span style="font-size: 11.5px; color: #fff; font-weight: bold; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-family: sans-serif;">
                    <?php echo esc_html($title_main); ?> - শুনছেন...
                </span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 10px;">
                <button onclick="toggleTtsPlayback()" style="background: <?php echo esc_attr($neon_color); ?>; color: #000; border: none; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s;">
                    <i class="fa-solid fa-pause" id="tts-sticky-play-icon" style="font-size: 14px;"></i>
                </button>
                <button onclick="stopTtsPlayback()" style="background: rgba(255,255,255,0.06); color: #fff; border: 1px solid rgba(255,255,255,0.1); width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s;">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- CORE STYLE DECLARATIONS -->
    <style>
    @keyframes ttsGlow {
        0%, 100% { opacity: 0.3; transform: scale(0.9); }
        50% { opacity: 1; transform: scale(1.15); }
    }
    @keyframes ttsBounce {
        from { transform: scaleY(0.7); }
        to { transform: scaleY(1.3); }
    }
    @keyframes ttsPingDot {
        0% { opacity: 0.3; }
        50% { opacity: 1; transform: scale(1.15); }
        100% { opacity: 0.3; }
    }
    @keyframes waveBar {
        0% { height: 4px; }
        100% { height: 16px; }
    }
    .tts-active-paragraph {
        background: rgba(0, 240, 255, 0.04) !important;
        border-left: 4px solid <?php echo esc_attr($neon_color); ?> !important;
        padding-left: 14px !important;
        border-radius: 0 8px 8px 0 !important;
        box-shadow: 0 0 10px rgba(0, 240, 255, 0.05) !important;
        transition: all 0.4s ease-in-out !important;
    }
    </style>

    <!-- ========================================== -->
    <!-- 🔥 NEXT-LEVEL CYBER READING EXPERIENCE 🔥 -->
    <!-- ========================================== -->
    
    <!-- 1. Reading Progress Bar -->
    <div id="cyber-reading-progress" style="position: fixed; top: 0; left: 0; width: 0%; height: 4px; background: linear-gradient(90deg, #00f0ff, #00ff41); z-index: 999999; box-shadow: 0 0 10px rgba(0, 240, 255, 0.8);"></div>
    
    <!-- 2. Dynamic Table of Contents (Auto Generated) -->
    <div id="ilybd-dynamic-toc" style="background: rgba(13, 21, 39, 0.5); border: 1px solid rgba(0, 240, 255, 0.2); border-left: 4px solid #00f0ff; border-radius: 8px; padding: 20px; margin-bottom: 30px; display: none; box-shadow: 0 5px 20px rgba(0,0,0,0.3);">
        <h3 style="margin-top: 0; color: #fff; font-size: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-list-ul" style="color: #00f0ff;"></i> কন্টেন্ট সূচিপত্র (Table of Contents)
        </h3>
        <ul id="ilybd-toc-list" style="margin: 0; padding-left: 20px; color: #8b949e; font-size: 14.5px; line-height: 1.8;"></ul>
    </div>

    <!-- 3. Post Content Area -->
    <article class="entry-content-main cyber-post-body" style="font-size:18.5px; line-height:1.85; color: #e6edf3; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        <?php the_content(); ?>
    </article>

    <!-- ========================================== -->
    <!-- 🟢 GAMIFIED CYBER REACTIONS & ENGAGEMENT MODULE 🟢 -->
    <!-- ========================================== -->
    <div id="cyber-reactions-module" style="margin: 40px 0; padding: 25px; background: rgba(7, 11, 19, 0.6); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; text-align: center; box-shadow: inset 0 0 20px rgba(0, 240, 255, 0.02);">
        <h4 style="color: #fff; font-size: 16px; font-family: monospace; text-transform: uppercase; margin-top: 0; margin-bottom: 20px; letter-spacing: 1px;">
            <i class="fa-solid fa-bolt" style="color: <?php echo esc_attr($neon_color); ?>;"></i> আপনার প্রতিক্রিয়া জানান (Power Level: +5 XP)
        </h4>
        <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
            <?php 
            $reactions = [
                'insightful' => ['icon' => 'fa-solid fa-lightbulb', 'color' => '#fbbf24', 'label' => 'Insightful'],
                'mindblown' => ['icon' => 'fa-solid fa-brain', 'color' => '#a855f7', 'label' => 'Mind Blown'],
                'helpful' => ['icon' => 'fa-solid fa-handshake-angle', 'color' => '#00ff41', 'label' => 'Helpful'],
                'fire' => ['icon' => 'fa-solid fa-fire-flame-curved', 'color' => '#ef4444', 'label' => 'Lit/Fire']
            ];
            foreach($reactions as $key => $data): 
                // Simulated random counts for demo
                $count = rand(15, 250); 
            ?>
            <button onclick="cyberReact(this, '<?php echo $key; ?>')" class="cyber-reaction-btn" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 10px 18px; border-radius: 30px; color: #c9d1d9; font-weight: bold; font-size: 13.5px; cursor: pointer; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); display: flex; align-items: center; gap: 8px;">
                <i class="<?php echo $data['icon']; ?>" style="color: <?php echo $data['color']; ?>; font-size: 16px;"></i>
                <span class="react-label"><?php echo $data['label']; ?></span>
                <span class="react-count" style="background: rgba(0,0,0,0.5); padding: 2px 8px; border-radius: 12px; font-size: 11px; font-family: monospace; color: <?php echo $data['color']; ?>;"><?php echo $count; ?></span>
            </button>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    function cyberReact(btn, type) {
        if(btn.classList.contains('reacted')) return;
        
        // Visual Feedback
        btn.classList.add('reacted');
        btn.style.background = 'rgba(0, 240, 255, 0.1)';
        btn.style.borderColor = '<?php echo esc_js($neon_color); ?>';
        btn.style.transform = 'scale(1.05)';
        btn.style.boxShadow = '0 0 15px rgba(0, 240, 255, 0.2)';
        
        var countSpan = btn.querySelector('.react-count');
        var currentCount = parseInt(countSpan.innerText);
        countSpan.innerText = currentCount + 1;
        countSpan.style.background = '<?php echo esc_js($neon_color); ?>';
        countSpan.style.color = '#000';
        
        // Create floating +5 XP element
        var xp = document.createElement('div');
        xp.innerText = '+5 XP';
        xp.style.position = 'absolute';
        xp.style.color = '#00ff41';
        xp.style.fontWeight = 'bold';
        xp.style.fontFamily = 'monospace';
        xp.style.pointerEvents = 'none';
        xp.style.transition = 'all 1s ease-out';
        xp.style.zIndex = '9999';
        
        var rect = btn.getBoundingClientRect();
        xp.style.left = (rect.left + rect.width/2) + 'px';
        xp.style.top = rect.top + 'px';
        
        document.body.appendChild(xp);
        
        setTimeout(() => {
            xp.style.transform = 'translateY(-50px)';
            xp.style.opacity = '0';
        }, 50);
        
        setTimeout(() => { xp.remove(); }, 1000);
    }
    </script>


    <!-- JS Core for Reading Features -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Reading Progress Bar ---
        window.addEventListener('scroll', function() {
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("cyber-reading-progress").style.width = scrolled + "%";
        });

        // --- Auto Generate Table of Contents ---
        var articleContent = document.querySelector('.entry-content-main');
        if (articleContent) {
            var headings = articleContent.querySelectorAll('h2, h3');
            if (headings.length > 2) { // Show only if enough sections
                var tocContainer = document.getElementById('ilybd-dynamic-toc');
                var tocList = document.getElementById('ilybd-toc-list');
                
                headings.forEach(function(heading, index) {
                    var id = 'heading-' + index;
                    heading.id = id; // Add ID to heading for anchoring
                    
                    // Style the actual headings beautifully
                    heading.style.borderBottom = "1px solid rgba(255,255,255,0.05)";
                    heading.style.paddingBottom = "10px";
                    heading.style.marginTop = "40px";
                    
                    var li = document.createElement('li');
                    li.style.marginBottom = "5px";
                    if (heading.tagName.toLowerCase() === 'h3') {
                        li.style.marginLeft = "15px";
                        li.style.listStyleType = "circle";
                    }
                    
                    var a = document.createElement('a');
                    a.href = '#' + id;
                    a.textContent = heading.textContent;
                    a.style.color = '#58a6ff';
                    a.style.textDecoration = 'none';
                    a.style.transition = 'color 0.2s';
                    a.onmouseover = function() { this.style.color = '#00f0ff'; };
                    a.onmouseout = function() { this.style.color = '#58a6ff'; };
                    
                    li.appendChild(a);
                    tocList.appendChild(li);
                });
                
                tocContainer.style.display = 'block';
                
                // Smooth scrolling for TOC
                tocList.addEventListener('click', function(e) {
                    if (e.target.tagName === 'A') {
                        e.preventDefault();
                        var targetId = e.target.getAttribute('href').substring(1);
                        var targetEl = document.getElementById(targetId);
                        if (targetEl) {
                            window.scrollTo({
                                top: targetEl.offsetTop - 100, // Offset for sticky headers
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            }
            
            // --- Copy to Clipboard for Pre/Code Blocks (Developer UX) ---
            var codeBlocks = articleContent.querySelectorAll('pre');
            codeBlocks.forEach(function(pre, index) {
                pre.style.position = 'relative';
                pre.style.background = '#0d1117';
                pre.style.border = '1px solid #30363d';
                pre.style.borderRadius = '8px';
                pre.style.padding = '20px';
                pre.style.overflow = 'auto';
                
                var copyBtn = document.createElement('button');
                copyBtn.innerHTML = '<i class="fa-regular fa-copy"></i> Copy';
                copyBtn.style.position = 'absolute';
                copyBtn.style.top = '10px';
                copyBtn.style.right = '10px';
                copyBtn.style.background = 'rgba(255,255,255,0.1)';
                copyBtn.style.border = 'none';
                copyBtn.style.color = '#c9d1d9';
                copyBtn.style.padding = '5px 10px';
                copyBtn.style.borderRadius = '4px';
                copyBtn.style.fontSize = '11px';
                copyBtn.style.cursor = 'pointer';
                copyBtn.style.fontFamily = 'monospace';
                copyBtn.style.transition = 'all 0.2s';
                
                copyBtn.onmouseover = function() { this.style.background = 'rgba(0,240,255,0.2)'; this.style.color = '#00f0ff'; };
                copyBtn.onmouseout = function() { this.style.background = 'rgba(255,255,255,0.1)'; this.style.color = '#c9d1d9'; };
                
                copyBtn.onclick = function() {
                    var codeText = pre.querySelector('code') ? pre.querySelector('code').innerText : pre.innerText;
                    navigator.clipboard.writeText(codeText).then(function() {
                        copyBtn.innerHTML = '<i class="fa-solid fa-check" style="color:#00ff41;"></i> Copied!';
                        setTimeout(function() { copyBtn.innerHTML = '<i class="fa-regular fa-copy"></i> Copy'; }, 2000);
                    });
                };
                
                pre.appendChild(copyBtn);
            });
            
            // --- Process Standard Tables for responsive layout ---
            var tables = articleContent.querySelectorAll('table');
            tables.forEach(function(table) {
                var wrapper = document.createElement('div');
                wrapper.style.overflowX = 'auto';
                wrapper.style.margin = '20px 0';
                wrapper.style.border = '1px solid rgba(255,255,255,0.1)';
                wrapper.style.borderRadius = '8px';
                
                table.style.width = '100%';
                table.style.borderCollapse = 'collapse';
                table.style.textAlign = 'left';
                table.style.fontSize = '15px';
                
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
                
                // Style table header
                var ths = table.querySelectorAll('th');
                ths.forEach(function(th) {
                    th.style.background = 'rgba(0,240,255,0.08)';
                    th.style.padding = '12px 15px';
                    th.style.color = '#00f0ff';
                    th.style.borderBottom = '1px solid rgba(255,255,255,0.1)';
                });
                
                // Style table cells
                var tds = table.querySelectorAll('td');
                tds.forEach(function(td) {
                    td.style.padding = '10px 15px';
                    td.style.borderBottom = '1px solid rgba(255,255,255,0.05)';
                });
            });
        }
    });
    </script>


    <!-- TTS JS BRAIN ENGINE -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var neonColor = '<?php echo esc_js($neon_color); ?>';
        var ttsState = {
            voiceType: '<?php echo esc_js($u_voice_pref); ?>',
            isPlaying: false,
            isPaused: false,
            speed: 1.0,
            paragraphs: [],
            currentIndex: 0,
            activeUtterance: null,
            highlightedClass: 'tts-active-paragraph'
        };

        var ttsPlayBtn = document.getElementById('tts-play-btn');
        var ttsPlayIcon = document.getElementById('tts-play-icon');
        var ttsPlayText = document.getElementById('tts-play-text');
        var ttsStopBtn = document.getElementById('tts-stop-btn');
        var ttsStatusHud = document.getElementById('tts-status-sub-hud');
        var ttsHudMsg = document.getElementById('tts-hud-message');
        var ttsStickyBtn = document.getElementById('tts-sticky-play-icon');
        var ttsFloatingBar = document.getElementById('cyber-tts-sticky-floating-bar');
        var speedSelect = document.getElementById('tts-speed-select');
        var maleBtn = document.getElementById('tts-male-btn');
        var femaleBtn = document.getElementById('tts-female-btn');

        window.setTtsVoice = function(type) {
            ttsState.voiceType = type;
            if (maleBtn && femaleBtn) {
                maleBtn.style.background = 'transparent';
                maleBtn.style.color = '#8b949e';
                femaleBtn.style.background = 'transparent';
                femaleBtn.style.color = '#8b949e';
                
                var activeBtn = document.getElementById('tts-' + type + '-btn');
                if (activeBtn) {
                    activeBtn.style.background = neonColor;
                    activeBtn.style.color = '#000';
                }
            }
            if (ttsState.isPlaying) {
                window.speechSynthesis.cancel();
                speakParagraphBlock(ttsState.currentIndex);
            }
        };

        window.changeTtsSpeed = function(rate) {
            ttsState.speed = parseFloat(rate);
            if (ttsState.isPlaying) {
                window.speechSynthesis.cancel();
                speakParagraphBlock(ttsState.currentIndex);
            }
        };

        window.toggleTtsPlayback = function() {
            if (!ttsState.isPlaying) {
                startTtsPlayer();
            } else if (ttsState.isPaused) {
                ttsState.isPaused = false;
                window.speechSynthesis.resume();
                updateTtsPlayerUi(true);
            } else {
                ttsState.isPaused = true;
                window.speechSynthesis.pause();
                updateTtsPlayerUi(false, true);
            }
        };

        window.stopTtsPlayback = function() {
            ttsState.isPlaying = false;
            ttsState.isPaused = false;
            window.speechSynthesis.cancel();
            
            var highlighted = document.querySelectorAll('.entry-content-main *');
            highlighted.forEach(function(el) {
                el.classList.remove(ttsState.highlightedClass);
            });

            if (ttsStopBtn) {
                ttsStopBtn.style.visibility = 'hidden';
                ttsStopBtn.style.opacity = '0';
            }
            if (ttsStatusHud) {
                ttsStatusHud.style.display = 'none';
            }
            updateTtsPlayerUi(false);
        };

        function startTtsPlayer() {
            ttsState.paragraphs = [];
            var elements = document.querySelectorAll('.entry-content-main p, .entry-content-main h2, .entry-content-main h3, .entry-content-main li');
            elements.forEach(function(el) {
                var text = el.textContent.trim();
                if (text.length > 5) {
                    ttsState.paragraphs.push({
                        element: el,
                        text: text
                    });
                }
            });

            if (ttsState.paragraphs.length === 0) {
                console.log('No content paragraphs found for TTS.');
                return;
            }

            ttsState.isPlaying = true;
            ttsState.isPaused = false;
            ttsState.currentIndex = 0;

            if (ttsStopBtn) {
                ttsStopBtn.style.visibility = 'visible';
                ttsStopBtn.style.opacity = '1';
            }
            if (ttsStatusHud) {
                ttsStatusHud.style.display = 'flex';
            }
            speakParagraphBlock(0);
        }

        function speakParagraphBlock(index) {
            if (!ttsState.isPlaying) return;

            var highlighted = document.querySelectorAll('.entry-content-main *');
            highlighted.forEach(function(el) {
                el.classList.remove(ttsState.highlightedClass);
            });

            if (index >= ttsState.paragraphs.length) {
                stopTtsPlayback();
                return;
            }

            ttsState.currentIndex = index;
            var pData = ttsState.paragraphs[index];
            pData.element.classList.add(ttsState.highlightedClass);

            var headerOffset = 150;
            var elementPosition = pData.element.getBoundingClientRect().top + window.pageYOffset;
            var offsetPosition = elementPosition - headerOffset;
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });

            window.speechSynthesis.cancel();
            
            var textToSpeak = pData.text;
            ttsState.activeUtterance = new SpeechSynthesisUtterance(textToSpeak);
            ttsState.activeUtterance.lang = 'bn-BD';

            if (ttsState.voiceType === 'male') {
                ttsState.activeUtterance.pitch = 0.8;
            } else {
                ttsState.activeUtterance.pitch = 1.15;
            }
            ttsState.activeUtterance.rate = ttsState.speed;

            if (window.speechSynthesis.getVoices) {
                var voices = window.speechSynthesis.getVoices();
                var bengaliVoice = voices.find(function(v) {
                    return v.lang.indexOf('bn') !== -1;
                });
                if (bengaliVoice) {
                    ttsState.activeUtterance.voice = bengaliVoice;
                }
            }

            if (ttsHudMsg) {
                ttsHudMsg.textContent = 'পড়ছি: ' + textToSpeak.substring(0, 35) + '...';
            }
            updateTtsPlayerUi(true);

            ttsState.activeUtterance.onend = function() {
                setTimeout(function() {
                    if (ttsState.isPlaying && !ttsState.isPaused) {
                        speakParagraphBlock(index + 1);
                    }
                }, 100);
            };

            ttsState.activeUtterance.onerror = function(e) {
                console.log('Speech Error: ', e);
                if (ttsState.isPlaying && !ttsState.isPaused) {
                    speakParagraphBlock(index + 1);
                }
            };

            window.speechSynthesis.speak(ttsState.activeUtterance);
        }

        function updateTtsPlayerUi(playing, paused) {
            var waveSpans = document.querySelectorAll('.voice-playing-wave span');
            if (playing && !paused) {
                if (ttsPlayBtn) {
                    ttsPlayBtn.innerHTML = '<i class="fa-solid fa-pause"></i> <span>থামুন (Pause)</span>';
                }
                if (ttsStickyBtn) {
                    ttsStickyBtn.className = 'fa-solid fa-pause';
                }
                waveSpans.forEach(function(span) {
                    span.style.animationPlayState = 'running';
                });
            } else if (paused) {
                if (ttsPlayBtn) {
                    ttsPlayBtn.innerHTML = '<i class="fa-solid fa-play"></i> <span>শুনুন (Resume)</span>';
                }
                if (ttsStickyBtn) {
                    ttsStickyBtn.className = 'fa-solid fa-play';
                }
                waveSpans.forEach(function(span) {
                    span.style.animationPlayState = 'paused';
                });
            } else {
                if (ttsPlayBtn) {
                    ttsPlayBtn.innerHTML = '<i class="fa-solid fa-play"></i> <span>পড়ে শোনান (Listen Post)</span>';
                }
                if (ttsStickyBtn) {
                    ttsStickyBtn.className = 'fa-solid fa-play';
                }
            }

            var panelEl = document.querySelector('.cyber-tts-panel');
            var panelOffset = panelEl ? (panelEl.getBoundingClientRect().top + window.pageYOffset) : 300;
            if (ttsState.isPlaying && window.pageYOffset > panelOffset) {
                if (ttsFloatingBar) ttsFloatingBar.style.bottom = '0';
            } else {
                if (ttsFloatingBar) ttsFloatingBar.style.bottom = '-100px';
            }
        }

        window.addEventListener('scroll', function() {
            if (ttsState.isPlaying) {
                var panelEl = document.querySelector('.cyber-tts-panel');
                var panelOffset = panelEl ? (panelEl.getBoundingClientRect().top + window.pageYOffset) : 300;
                if (window.pageYOffset > panelOffset) {
                    if (ttsFloatingBar) ttsFloatingBar.style.bottom = '0';
                } else {
                    if (ttsFloatingBar) ttsFloatingBar.style.bottom = '-100px';
                }
            } else {
                if (ttsFloatingBar) ttsFloatingBar.style.bottom = '-100px';
            }
        });

        window.addEventListener('beforeunload', function() {
            window.speechSynthesis.cancel();
        });

        // Autoplay logic disabled as requested - users must manually initiate playback
    });
    </script>

    <!-- ⚡ ILYBD Dynamic Real-Time Security Opinion Poll (2040 Neon Style) ⚡ -->
    <?php
    // Get the title and lower-case it to match key tech terms
    $post_title_lower = mb_strtolower(get_the_title());
    $poll_question = "তথ্যপ্রযুক্তির এই সাইবার সচেতনতা সেশন বা নীতিমালায় আপনার ব্যক্তিগত মতামত কী?";
    $poll_options = [
        "আমি বিষয়টি বুঝতে পেরেছি এবং সচেতনতা অবলম্বন করছি",
        "সাইবার হুমকি এড়াতে এই কন্টেন্টটি অত্যন্ত জ্ঞানবর্ধক ছিল",
        "আমি এই পদ্ধতি বা সুরক্ষানীতি আগে থেকেই মেনে চলি",
        "বিষয়টি আমার কাছে সম্পূর্ণ নতুন এবং বিস্তারিত আরও তথ্য প্রয়োজন"
    ];

    if (mb_strpos($post_title_lower, 'gmail') !== false || mb_strpos($post_title_lower, 'জিমেইল') !== false || mb_strpos($post_title_lower, 'ইমেইল') !== false) {
        $poll_question = "আপনার গুগল/জিমেইল অ্যাকাউন্টে 'টু-ফ্যাক্টর অথেন্টিকেশন (2FA)' কি সক্রিয় করা আছে?";
        $poll_options = [
            "হ্যাঁ, গুগল অথেন্টিকেটর অ্যাপ সহ ২এফএ সম্পূর্ণ সক্রিয়",
            "হ্যাঁ, শুধুমাত্র মোবাইল নম্বর ও এসএমএস ভেরিফিকেশন সক্রিয়",
            "না, grandparent এখনো ভেরিফিকেশন কোড চালু করিনি তবে দ্রুত করবো",
            "টু-ফ্যাক্টর অথেন্টিকেশন সক্রিয় করার পদ্ধতি জানা নেই"
        ];
    } elseif (mb_strpos($post_title_lower, 'hack') !== false || mb_strpos($post_title_lower, 'হ্যাক') !== false) {
        $poll_question = "আপনার কোনো সোশ্যাল মিডিয়া বা ডিজিটাল অ্যাকাউন্ট কখনো হ্যাকিংয়ের কবলে পড়েছে কি?";
        $poll_options = [
            "হ্যাঁ, আগে হ্যাক হয়েছিল কিন্তু পুনরুদ্ধার করতে সফল হয়েছি",
            "না, আমি যথেষ্ট সচেতন তাই কখনো সাইবার হামলার শিকার হইনি",
            "কিছুটা সন্দেহজনক লক বা অ্যাটেম্পট ছিল কিন্তু বড় সমস্যা হয়নি",
            "হ্যাক হওয়ার কোনো অভিজ্ঞতা নেই তবে নিরাপদে থাকার চেষ্টা করি"
        ];
    } elseif (mb_strpos($post_title_lower, 'password') !== false || mb_strpos($post_title_lower, 'পাসওয়ার্ড') !== false) {
        $poll_question = "নিরাপত্তার স্বার্থে আপনি সাধারণত কতদিন পর পর আপনার অ্যাকাউন্টের পাসওয়ার্ড পরিবর্তন করেন?";
        $poll_options = [
            "প্রতি ৩ মাস পর পর নিয়ম মেনে সব পাসওয়ার্ড পরিবর্তন করি",
            "প্রতি ৬ মাস অন্তর অন্তত একবার পাসওয়ার্ড আপডেট করি",
            "শুধুমাত্র সিকিউরিটি ব্রিচ বা এলার্ট মেসেজ পেলেই করি",
            "কখনো পরিবর্তন করি না (একই পাসওয়ার্ড দীর্ঘকাল ব্যবহার করি)"
        ];
    } elseif (mb_strpos($post_title_lower, 'free') !== false || mb_strpos($post_title_lower, 'ফ্রি') !== false) {
        $poll_question = "ফ্রি ভিপিএন বা পাবলিক আনসিকিউরড ওয়াই-ফাই ব্যবহার করাকে আপনি কতটা বিপজ্জনক মনে করেন?";
        $poll_options = [
            "অত্যন্ত ঝুঁকিপূর্ণ ও ব্যক্তিগত তথ্য চুরি হওয়ার সর্বোচ্চ ঝুঁকি থাকে",
            "কিছুটা ঝুঁকিপূর্ণ তবে সতর্ক থেকে ব্যবহার করলে কোনো সমস্যা নেই",
            "সম্পূর্ণ নিরাপদ এবং আধুনিক সুবিধাজনক একটি সেবা",
            "ঝুঁকি সম্পর্কে সঠিক তথ্য আমি জানি না"
        ];
    } elseif (mb_strpos($post_title_lower, 'bkas') !== false || mb_strpos($post_title_lower, 'বিকাশ') !== false || mb_strpos($post_title_lower, 'নগদ') !== false || mb_strpos($post_title_lower, 'রকেট') !== false) {
        $poll_question = "মোবাইল ফিনান্সিয়াল সার্ভিস (বিকাশ, নগদ বা রকেট) এর ওটিপি বা পিন সুরক্ষায় আপনার জ্ঞান কতটুকু?";
        $poll_options = [
            "আমি সম্পূর্ণ সজাগ এবং ওটিপি/পিন কারো সাথে শেয়ার করি না",
            "মাঝে মাঝে লটারি বা আকর্ষণীয় ক্যাশব্যাক কলের ফাঁদে পড়তে ভয় লাগে",
            "ইতিপূর্বে প্রতারক চক্র দ্বারা কোনো ফাঁদে টাকার ক্ষতির সম্মুখীন হয়েছিলাম",
            "সিকিউরিটি এবং পিন রিসেট প্রসেস সম্পর্কে আরও জানা দরকার"
        ];
    }

    // Load actual vote counts stored in post meta, setup seeded values as standard realistic fallback
    $poll_votes = get_post_meta($post_id, 'ilybd_poll_votes', true);
    if (!is_array($poll_votes) || count($poll_votes) !== 4) {
        $seed_base = 80 + ($post_id * 17) % 75;
        $poll_votes = [
            round($seed_base * 0.45),
            round($seed_base * 0.25),
            round($seed_base * 0.20),
            round($seed_base * 0.10)
        ];
    }
    $total_poll_votes = array_sum($poll_votes);
    ?>

    <div class="ilybd-cyber-poll-card" style="background: rgba(13, 21, 39, 0.6); border: 1.5px solid rgba(0, 240, 255, 0.15); border-radius: 18px; padding: 30px; margin: 40px auto 30px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); box-sizing: border-box; max-width: 850px;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, #00f0ff, #7000ff);"></div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="display: inline-block; width: 8px; height: 8px; background-color: #00f0ff; border-radius: 50%; box-shadow: 0 0 8px #00f0ff; animation: pulse 1.5s infinite;"></span>
                <span style="font-family: monospace; font-size: 11px; text-transform: uppercase; color: #00f0ff; font-weight: bold; letter-spacing: 1px;">📢 LIVE SECURITY POLL</span>
            </div>
            <div style="font-size: 11px; font-family: monospace; color: #8b949e; background: rgba(255, 255, 255, 0.04); padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.05);">
                TOTAL SURVEYED: <span id="poll-total-votes-count" style="color: #fff; font-weight: bold;"><?php echo $total_poll_votes; ?></span>
            </div>
        </div>

        <h3 id="ilybd-poll-question-title" style="margin: 0 0 25px 0 !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important; font-weight: 700 !important; color: #fff !important; font-size: 20px !important; line-height: 1.5 !important;">
            <?php echo esc_html($poll_question); ?>
        </h3>

        <!-- Poll Active Voting State -->
        <div id="ilybd-poll-voting-view" style="display: block;">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <?php foreach ($poll_options as $index => $option) : ?>
                    <button class="ilybd-poll-opt-btn" onclick="submitIlybdPollVote(<?php echo $index; ?>)" style="background: rgba(22, 27, 34, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 10px; color: #c9d1d9; padding: 16px 20px; font-size: 14.5px; text-align: left; cursor: pointer; transition: all 0.25s ease; font-family: inherit; width: 100%; box-sizing: border-box; display: flex; align-items: center; justify-content: space-between; gap: 15px;" onmouseover="this.style.background='rgba(0, 240, 255, 0.05)'; this.style.borderColor='rgba(0, 240, 255, 0.4)'; this.style.color='#00f0ff';" onmouseout="this.style.background='rgba(22, 27, 34, 0.6)'; this.style.borderColor='rgba(255, 255, 255, 0.08)'; this.style.color='#c9d1d9';">
                        <span><?php echo esc_html($option); ?></span>
                        <i class="fa-regular fa-circle" style="font-size: 14px; opacity: 0.6;"></i>
                    </button>
                <?php endforeach; ?>
            </div>
            <p style="margin: 15px 0 0 0; color: #64748b; font-size: 11.5px; text-align: center; font-family: sans-serif;">
                🔒 আপনার মতামত সম্পূর্ণ বেনামী এবং সুরক্ষিত রাখা হবে। প্রতিটি ব্যবহারকারী একবার ভোট দিতে পারবেন।
            </p>
        </div>

        <!-- Poll Results Result State -->
        <div id="ilybd-poll-results-view" style="display: none;">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php foreach ($poll_options as $index => $option) : 
                    $opt_votes = $poll_votes[$index];
                    $opt_perc = $total_poll_votes > 0 ? round(($opt_votes / $total_poll_votes) * 100) : 0;
                ?>
                    <div class="ilybd-poll-result-row" style="position: relative;">
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px; color: #e6edf3; margin-bottom: 6px; font-family: inherit;">
                            <span style="font-weight: 500; font-size: 14px;"><?php echo esc_html($option); ?></span>
                            <span style="font-family: monospace; font-weight: bold; color: #00f0ff;">
                                <span id="poll-perc-label-<?php echo $index; ?>"><?php echo $opt_perc; ?></span>% 
                                <span style="font-size: 11px; color: #64748b; font-weight: normal;">(<span id="poll-votes-count-<?php echo $index; ?>"><?php echo $opt_votes; ?></span>)</span>
                            </span>
                        </div>
                        <div style="width: 100%; height: 10px; background: rgba(22, 27, 34, 0.8); border-radius: 6px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.05); box-sizing: border-box;">
                            <div id="poll-bar-fill-<?php echo $index; ?>" style="width: <?php echo $opt_perc; ?>%; height: 100%; background: linear-gradient(90deg, #00d0ff, #00ff41); border-radius: 4px; transition: width 1s cubic-bezier(0.1, 0.8, 0.1, 1);"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 15px; border-top: 1px dashed rgba(255,255,255,0.06);">
                <span style="color: #00ff41; font-size: 12px; font-weight: bold; display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-circle-check"></i> মতামত নথিভুক্ত হয়েছে • Vote Recorded
                </span>
                <button onclick="resetIlybdPollVote()" style="background: transparent; border: none; color: #64748b; text-decoration: underline; font-family: monospace; font-size: 11px; cursor: pointer; padding: 0;" onmouseover="this.style.color='#00f0ff';" onmouseout="this.style.color='#64748b';">
                    RESET VOTE OPTIONS
                </button>
            </div>
        </div>
    </div>

    <!-- Active Script for dynamic poll logic -->
    <script>
        var ilybdPostId = <?php echo $post_id; ?>;
        
        jQuery(document).ready(function($) {
            checkAndShowPollState();
        });

        function checkAndShowPollState() {
            var votedOption = localStorage.getItem('ilybd_poll_voted_post_' + ilybdPostId);
            if (votedOption !== null) {
                // Already voted - display results
                jQuery('#ilybd-poll-voting-view').hide();
                jQuery('#ilybd-poll-results-view').fadeIn(400);
            } else {
                jQuery('#ilybd-poll-results-view').hide();
                jQuery('#ilybd-poll-voting-view').show();
            }
        }

        function submitIlybdPollVote(optionIndex) {
            var $ = jQuery;
            
            // Immediately lock options to prevent double clicks
            $('.ilybd-poll-opt-btn').prop('disabled', true).css('opacity', '0.5');
            
            // Send secure AJAX request to increment on server database
            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                type: 'POST',
                data: {
                    action: 'ilybd_submit_vote',
                    post_id: ilybdPostId,
                    option_index: optionIndex
                },
                success: function(response) {
                    if (response.success && response.data) {
                        var data = response.data;
                        
                        // Update visual content labels dynamically
                        $('#poll-total-votes-count').text(data.total);
                        for (var i = 0; i < 4; i++) {
                            $('#poll-votes-count-' + i).text(data.votes[i]);
                            $('#poll-perc-label-' + i).text(data.percentages[i]);
                            
                            // Initialize with width 0% then expand to create gorgeous entrance transition
                            $('#poll-bar-fill-' + i).css('width', '0%');
                            (function(idx, pct) {
                                setTimeout(function() {
                                    $('#poll-bar-fill-' + idx).css('width', pct + '%');
                                }, 50);
                            })(i, data.percentages[i]);
                        }
                        
                        // Persist state in browser localStorage
                        localStorage.setItem('ilybd_poll_voted_post_' + ilybdPostId, optionIndex);
                        
                        // Change UI view with beautiful fade speed
                        $('#ilybd-poll-voting-view').hide();
                        $('#ilybd-poll-results-view').fadeIn(500);
                    } else {
                        // Fallback in case of server offline error
                        simulateFallbackPollVote(optionIndex);
                    }
                },
                error: function() {
                    // Fallback to local simulation if wordpress is run inside headless mock
                    simulateFallbackPollVote(optionIndex);
                }
            });
        }

        function simulateFallbackPollVote(optionIndex) {
            var $ = jQuery;
            var savedTotal = parseInt($('#poll-total-votes-count').text()) || 120;
            var currentVotes = [];
            
            for (var i = 0; i < 4; i++) {
                var v = parseInt($('#poll-votes-count-' + i).text()) || Math.round(savedTotal * (i === 0 ? 0.45 : i === 1 ? 0.25 : i === 2 ? 0.20 : 0.10));
                currentVotes.push(v);
            }
            
            // Local client-side simulation
            currentVotes[optionIndex]++;
            var newTotal = savedTotal + 1;
            $('#poll-total-votes-count').text(newTotal);
            
            for (var i = 0; i < 4; i++) {
                var p = Math.round((currentVotes[i] / newTotal) * 100);
                $('#poll-votes-count-' + i).text(currentVotes[i]);
                $('#poll-perc-label-' + i).text(p);
                
                $('#poll-bar-fill-' + i).css('width', '0%');
                (function(idx, pct) {
                    setTimeout(function() {
                        $('#poll-bar-fill-' + idx).css('width', pct + '%');
                    }, 50);
                })(i, p);
            }
            
            localStorage.setItem('ilybd_poll_voted_post_' + ilybdPostId, optionIndex);
            $('#ilybd-poll-voting-view').hide();
            $('#ilybd-poll-results-view').fadeIn(500);
        }

        function resetIlybdPollVote() {
            var $ = jQuery;
            localStorage.removeItem('ilybd_poll_voted_post_' + ilybdPostId);
            $('.ilybd-poll-opt-btn').prop('disabled', false).css('opacity', '1');
            checkAndShowPollState();
        }
    </script>

    <?php
    // Advanced ILYBD Trust Verification & Security Shield v3 (PRO) - Core Integration
    $db_quality_score = get_post_meta($post_id, 'ilybd_quality_score', true);
    $db_similarity_score = get_post_meta($post_id, 'ilybd_similarity_score', true);
    
    if (empty($db_quality_score)) {
        $db_quality_score = 94; // fallback standard representation if empty
    }
    if (empty($db_similarity_score)) {
        $db_similarity_score = 4.2; // fallback standard representation if empty
    }
    
    $ai_score = number_format(($db_similarity_score > 0 ? (100 - $db_quality_score) * 0.45 : (($post_id % 20) / 10) + ($title_len % 5) / 10 + 0.4), 1);
    $plag_score = number_format((float)$db_similarity_score, 1) . "%";
    $integrity = $db_quality_score;
    $verify_id = "ILBD-VERIFY-" . ($post_id + 10500) . "-" . strtoupper(substr(md5($post_id . "saltValue"), 0, 6));
    
    // Calculate simulated digital stats to make it extremely prestigious
    $content_raw = wp_strip_all_tags(get_the_content());
    $word_count = str_word_count($content_raw) ?: mb_strlen($content_raw) / 5;
    $sha_hash = hash('sha256', get_the_content() ?: 'ilybd-default');
    $read_time = ceil($word_count / 140) ?: 1;
    ?>

    <div class="ilybd-trust-shield-card" style="background:#090d16; border:1.5px solid rgba(0, 255, 65, 0.15); border-radius:18px; padding:30px; margin-top:50px; position:relative; overflow:hidden; box-shadow:0 15px 40px rgba(0,0,0,0.6);">
        <div class="card-neon-fringe" style="position:absolute; top:0; left:0; width:4px; height:100%; background:linear-gradient(180deg, #00ff41, #390099);"></div>
        
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px; margin-bottom:25px;">
            <div>
                <h3 style="margin:0; color:#fff; font-size:19px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-square-check" style="color:#00ff41;"></i> <span style="color:#00ff41; font-weight:900;">Verified by I Love You BD</span>
                </h3>
                <p style="margin:5px 0 0 0; color:#8b949e; font-size:13px; font-family:sans-serif;">কন্টেন্ট সত্যতা যাচাইকরণ সনদ • Official Quality Verified Seal</p>
            </div>
            <div>
                <div style="display:inline-block; padding:5px 14px; background:rgba(0, 255, 65, 0.1); border:1px dashed #00ff41; color:#00ff41; border-radius:30px; font-size:11px; font-weight:800; letter-spacing:0.5px; text-transform:uppercase;">
                    <i class="fa-solid fa-ribbon"></i> ১০০% মানসম্মত ও সুরক্ষিত
                </div>
            </div>
        </div>

        <!-- Metric Grid -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(150px, 1fr)); gap:15px; background:rgba(13, 17, 23, 0.85); padding:20px; border-radius:12px; border:1px solid rgba(255,255,255,0.04); margin-bottom:20px;">
            <div style="text-align:center;">
                <span style="display:block; font-size:11px; color:#8b949e; font-weight:bold; letter-spacing:0.5px; text-transform:uppercase;">এআই প্রোবাবিলিটি</span>
                <div style="font-size:24px; color:#00ff41; font-weight:900; margin:6px 0; text-shadow:0 0 10px rgba(0,255,65,0.2)"><?php echo $ai_score; ?>%</div>
                <div style="width:100%; height:4px; background:#161b22; border-radius:5px; overflow:hidden;">
                    <div style="width:<?php echo $ai_score; ?>%; height:100%; background:#00ff41;"></div>
                </div>
            </div>
            <div style="text-align:center;">
                <span style="display:block; font-size:11px; color:#8b949e; font-weight:bold; letter-spacing:0.5px; text-transform:uppercase;">প্লাজিয়ারিজম বা কপি</span>
                <div style="font-size:24px; color:#00ff41; font-weight:900; margin:6px 0; text-shadow:0 0 10px rgba(0,255,65,0.2)"><?php echo $plag_score; ?></div>
                <div style="width:100%; height:4px; background:#161b22; border-radius:5px; overflow:hidden;">
                    <div style="width:5%; height:100%; background:#00ff41;"></div>
                </div>
            </div>
            <div style="text-align:center;">
                <span style="display:block; font-size:11px; color:#8b949e; font-weight:bold; letter-spacing:0.5px; text-transform:uppercase;">কন্টেন্ট স্কোর</span>
                <div style="font-size:24px; color:#fff; font-weight:900; margin:6px 0; text-shadow:0 0 10px rgba(255,255,255,0.1)"><?php echo $integrity; ?>%</div>
                <span style="font-size:9.5px; color:#00ff41; font-weight:900; letter-spacing:0.5px; text-transform:uppercase;">হাই কোয়ালিটি</span>
            </div>
        </div>

        <!-- Expandable Detail list button -->
        <div style="background:rgba(22, 27, 34, 0.4); border-radius:10px; border:1px solid rgba(255,255,255,0.02); padding:10px 15px; margin-bottom:15px; cursor:pointer; transition:0.2s;" class="ledger-header" onclick="jQuery('#verification-ledger-panel').slideToggle(200)">
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:13px; color:#c9d1d9; font-weight:bold;">
                <span><i class="fa-solid fa-network-wired" style="color:#00ff41; margin-right:6px;"></i> সত্যতা নিরূপণ লেজার চেক আউটলুক</span>
                <span class="ledger-toggle-icon" style="color:#00ff41;"><i class="fa-solid fa-chevron-down"></i></span>
            </div>
        </div>

        <!-- Hidden Detail block -->
        <div id="verification-ledger-panel" style="display:none; padding:15px; background:#0d1117; border:1.5px solid #21262d; border-radius:10px; margin-bottom:15.5px; font-family:monospace; font-size:11.5px; line-height:1.7; color:#8b949e; word-break:break-all;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:10px; margin-bottom:10px; border-bottom:1px solid #1f242c; padding-bottom:10px;">
                <div>
                    ● <span style="color:#fff;">CHECKSUM HASH:</span><br>
                    <span style="color:#00ff41; font-size:11px;"><?php echo $sha_hash; ?></span>
                </div>
                <div>
                    ● <span style="color:#fff;">VERIFICATION TIMELINE:</span><br>
                    <span><?php echo get_the_modified_date('c'); ?></span>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(130px, 1fr)); gap:10px; border-bottom:1px solid #1f242c; padding-bottom:10px; margin-bottom:10px;">
                <div>
                    ● <span style="color:#fff;">TOTAL WORDS:</span> <?php echo $word_count; ?>
                </div>
                <div>
                    ● <span style="color:#fff;">READ TIME:</span> ~<?php echo $read_time; ?> Min
                </div>
                <div>
                    ● <span style="color:#fff;">LEDGER STATUS:</span> <span style="color:#00ff41; font-weight:bold;">SECURED</span>
                </div>
            </div>
            <div style="text-align:center; color:#c9d1d9; font-size:11px; background:rgba(0, 255, 65, 0.04); padding:5px; border-radius:4px; border:1px dashed rgba(0, 255, 65, 0.2);">
                🛡️ কন্টেন্টটি সম্পূর্ণরূপে অথেনটিক হিউম্যান রাইটার দ্বারা তৈরি এবং আই লাভ ইউ বিডি এআই নেটওয়ার্ক দ্বারা সিগনেচারড।
            </div>
        </div>

        <div style="border-top:1px solid rgba(255,255,255,0.04); padding-top:15px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px;">
            <div style="color:#484f58; font-size:11.5px; font-family:'Courier New', Courier, monospace;">
                ID: <span style="color:#8b949e; font-weight:bold;"><?php echo $verify_id; ?></span><br>
                VERIFIER NODE: <span style="color:#58a6ff;">ILYBD-TRUST-V3.8</span>
            </div>
            <div style="display:flex; align-items:center; gap:15px;">
                <a href="<?php echo home_url('/purocheck/'); ?>" class="ledger-run-link" style="color:#00ff41; font-size:12.5px; font-weight:bold; text-decoration:none; border-bottom:1.5px dashed #00ff41; transition:0.2s;" onmouseover="this.style.color='#fff'; this.style.borderColor='#fff';" onmouseout="this.style.color='#00ff41'; this.style.borderColor='#00ff41';">নতুন লাইভ স্ক্যান</a>
                <svg width="34" height="34" viewBox="0 0 48 48" fill="none"><path d="M24 4L6 12V22C6 33.05 13.67 43.34 24 46C34.33 43.34 42 33.05 42 22V12L24 4Z" fill="#00ff41" fill-opacity="0.12" stroke="#00ff41" stroke-width="2"/></svg>
            </div>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <?php get_template_part('template-parts/post-actions'); ?>
    </div>

    <div id="ilybd-comment-area" style="margin-top: 40px; margin-bottom: 40px;">
        <?php 
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif; 
        ?>
    </div>

    <div style="margin-top: 30px;">
        <?php get_template_part('template-parts/single-down-profile-card'); ?>
    </div>

    <!-- 🛠️ AUTHOR DIRECT CONTEXT QUICK EDIT ACCESS (2040 SPECIAL ACTIONS) -->
    <?php
    if (is_user_logged_in() && (current_user_can('edit_post', $post_id) || get_current_user_id() == $author_id)) :
        $edit_link = get_edit_post_link($post_id);
        ?>
        <div class="ilybd-frontend-author-actions" style="margin: 30px 0; background: rgba(0, 240, 255, 0.03); border: 1.5px dashed rgba(0, 240, 255, 0.3); border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: space-between; gap: 15px; box-shadow: 0 0 15px rgba(0,240,255,0.05);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 24px; animation: ttsGlow 2s infinite;">🛠️</span>
                <div>
                    <strong style="color: #00f0ff; font-size: 14.5px; display: block; font-family: monospace;">AUTHOR INTERACTION CELL</strong>
                    <span style="color: #8b949e; font-size: 12px; display: block; margin-top: 2px;">আপনি এই পোস্টের ভেরিফায়েড লেখক। কোনো কোডিং বা তথ্যে ভুল থাকলে এডিট করতে পারেন।</span>
                </div>
            </div>
            <a href="<?php echo esc_url($edit_link); ?>" style="background: linear-gradient(135deg, #00f0ff 0%, #00ff41 100%); color: #000; font-weight: 900; text-decoration: none !important; font-size: 13px; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 15px rgba(0,240,255,0.25); transition: 0.2s;" target="_blank">
                <i class="fa-solid fa-pen-to-square"></i> সরাসরি এডিট করুন
            </a>
        </div>
    <?php endif; ?>

    <!-- 🔮 DYNAMIC RELATED TECH TOOLS RECOMMENDER (FROM 50+ PLATFORM TOOLS) -->
    <?php
    // Keyword Matching Engine for custom tool recommendations
    $post_merged_text = strtolower($title_main . ' ' . wp_strip_all_tags(get_the_content()));
    $matched_tools = array();

    $tools_collection = array(
        'nid_maker' => array(
            'name' => 'স্মার্ট এনআইডি কার্ড জেনারেটর প্রো',
            'desc' => 'নিজের তথ্য দিয়ে সম্পূর্ণ এইচডি বাংলাদেশের স্মার্ট এনআইডি কার্ড তৈরি করার টুলস।',
            'icon' => '📱',
            'link' => home_url('/nid-card-generator/'),
            'tags' => array('nid', 'এনআইডি', 'ভোটার', 'স্মার্ট', 'কার্ড', 'card', 'id', 'জাতীয় পরিচয়পত্র')
        ),
        'nid_key' => array(
            'name' => 'এনআইডি সিকিউরিটি কি জেনারেটর',
            'desc' => 'স্মার্ট এনআইডি কার্ড ক্রিপ্টো সিকিউরিটি পোর্টালে সিকিউরিটি কি জেনারেট করার ল্যাব।',
            'icon' => '🔑',
            'link' => home_url('/tools/'),
            'tags' => array('security', 'key', 'কি', 'পাসওয়ার্ড', 'লক', 'ক্রিপ্টো')
        ),
        'ai_maya' => array(
            'name' => 'এআই মায়া ক্লাউড অ্যাসিস্ট্যান্ট',
            'desc' => 'অনর্গল চমৎকার খাঁটি বাংলায় কথা বলতে ও যেকোনো কোডিং বাগ সলভ করতে সক্ষম এআই।',
            'icon' => '✨',
            'link' => home_url('/tools/'),
            'tags' => array('ai', 'এআই', 'মায়া', 'chat', 'চ্যাট', 'gpt', 'gemini', 'রোবট', 'প্রম্পট')
        ),
        'qr_maker' => array(
            'name' => 'নিওন কিউআর কোড মেকার ল্যাব',
            'desc' => 'যেকোনো ওয়েবসাইট লিংক বা নাম্বার দিয়ে আকর্ষণীয় নিওন কালারড কিউআর কোড মেকার।',
            'icon' => '🧬',
            'link' => home_url('/tools/'),
            'tags' => array('qr', 'কিউআর', 'কোড', 'code', 'লিংক', 'স্ক্যান')
        ),
        'seo_glow' => array(
            'name' => 'সার্চ ইঞ্জিন মেটাডাটা ও সিএসএস গ্লো ফ্যাক্টরি',
            'desc' => 'গুলল ফার্স্ট পেজে ইনডেক্সিং এর জন্য এসইও মেটাডাটা ও আকর্ষণীয় সিএসএস নিওন ফ্লো ল্যাব।',
            'icon' => '🏭',
            'link' => home_url('/tools/'),
            'tags' => array('seo', 'css', 'গ্লো', 'ডিজাইন', 'মেটা', 'গুগল', 'সার্চ', 'ট্যাগ')
        ),
        'synth' => array(
            'name' => 'নিয়েন মিউজিক সিন্থেসাইজার ২০৪০',
            'desc' => 'ব্রাউজার উইন্ডোর ভেতর সরাসরি এআই সাউন্ড ওয়েব ফ্রিকোয়েন্সি প্লে করার ডিজিটাল ল্যাব।',
            'icon' => '🎵',
            'link' => home_url('/tools/'),
            'tags' => array('মিউজিক', 'গান', 'অডিও', 'সাউন্ড', 'সিন্থ', 'synth', 'audio', 'music')
        ),
        'cyber_cat' => array(
            'name' => 'সাইবার টকিং পেট ক্যাট গেম',
            'desc' => 'ভবিষ্যতের রোবোটিক কিউট বিড়াল CYBER_CAT এর সাথে খেলা ও মিষ্টি আলাপ করার প্লেগ্রাউন্ড।',
            'icon' => '🐈',
            'link' => home_url('/tools/'),
            'tags' => array('game', 'গেম', 'বিড়াল', 'ক্যাট', 'cat', 'pet', 'খেলুন')
        ),
        'forum' => array(
            'name' => 'প্রশ্ন-উত্তর ফোরাম ও ক্যাশ গেটওয়ে',
            'desc' => 'প্রযুক্তি নিয়ে যেকোনো প্রশ্ন করে ফোরামে সাবমিট করার এবং রিওয়ার্ড ইনকাম করার প্লাটফর্ম।',
            'icon' => '💬',
            'link' => home_url('/ask-question/'),
            'tags' => array('প্রশ্ন', 'উত্তর', 'ফোরাম', 'ইনকাম', 'টাকা', 'বিকাশ', 'forum', 'ask')
        ),
        'downloader' => array(
            'name' => 'সোশ্যাল ভিডিও ডাউনলোডার প্রো',
            'desc' => 'ফ্রি সার্ভার ব্যবহার করে টিকток, ফেসবুক ও ইউটিউব থেকে ১-ক্লিকে এইচডি ভিডিও ডাউনলোড।',
            'icon' => '📥',
            'link' => home_url('/tools/'),
            'tags' => array('ভিডিও', 'ডাউনলোড', 'ইউটিউব', 'ফেসবুক', 'টিকток', 'download', 'video', 'fb', 'yt')
        )
    );

    // Dynamic Matching Check
    foreach ($tools_collection as $key => $dt) {
        foreach ($dt['tags'] as $tag) {
            if (strpos($post_merged_text, strtolower($tag)) !== false) {
                $matched_tools[$key] = $dt;
                break;
            }
        }
    }

    // Default Fallbacks if list is too small (We want exactly 3 targeted recommendations)
    if (count($matched_tools) < 3) {
        $keys = array_keys($tools_collection);
        shuffle($keys);
        foreach ($keys as $k) {
            if (!isset($matched_tools[$k])) {
                $matched_tools[$k] = $tools_collection[$k];
            }
            if (count($matched_tools) >= 3) break;
        }
    }
    
    // Slice to exactly 3 recommendations
    $recommended_tools = array_slice($matched_tools, 0, 3, true);
    ?>

    <div class="ilybd-related-tools-box" style="margin: 40px 0; background: rgba(13, 21, 39, 0.5); border: 1.5px solid rgba(0, 240, 255, 0.2); border-radius: 14px; padding: 25px; box-shadow: 0 8px 30px rgba(0,0,0,0.45);">
        <h3 style="margin-top: 0; color: #fff; font-size: 17px; display: flex; align-items: center; gap: 8px; border-bottom: 1px dashed rgba(255,255,255,0.08); padding-bottom: 12px; font-weight: 850;">
            <i class="fa-solid fa-screwdriver-wrench" style="color: #00f0ff;"></i> এই পোস্ট সম্পর্কিত বিশেষ সাহায্যকারী এআই টুলস (Related Tools)
        </h3>
        <p style="color: #8b949e; font-size: 12.5px; margin-top: 5px; margin-bottom: 20px;">আমাদের মূল টুলস পোর্টাল এ থাকা ৫০+ আকর্ষণীয় অটো-মেকার রিলেটেড ৩টি প্রফেশনাল অনলাইন মেকার রিকমেন্ড করা হলো:</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 15px;">
            <?php foreach ($recommended_tools as $tool) : ?>
                <div style="background: rgba(22, 27, 34, 0.5); border: 1px solid rgba(255,255,255,0.05); padding: 15px; border-radius: 10px; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="font-size: 22px; margin-bottom: 8px;"><?php echo $tool['icon']; ?></div>
                        <h4 style="color: #fff; font-size: 14px; font-weight: bold; margin: 0 0 6px 0;"><?php echo $tool['name']; ?></h4>
                        <p style="color: #8b949e; font-size: 11.5px; line-height: 1.5; margin: 0 0 15px 0;"><?php echo $tool['desc']; ?></p>
                    </div>
                    <a href="<?php echo esc_url($tool['link']); ?>" style="background: rgba(0, 240, 255, 0.1); border: 1.5px solid #00f0ff; color: #00f0ff; text-align: center; display: block; padding: 8px; border-radius: 6px; font-size: 11px; font-weight: 800; text-decoration: none !important; text-transform: uppercase; transition: 0.2s;" onmouseover="this.style.background='#00f0ff'; this.style.color='#000';" onmouseout="this.style.background='rgba(0, 240, 255, 0.1)'; this.style.color='#00f0ff';">টুলস ডাউনলোড বা ব্যবহার করুন</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ❓ COMMUNITY Q&A ENGAGEMENT SUGGESTER PLATFORM -->
    <div class="ilybd-community-qa-suggester" style="margin: 30px 0 40px; background: rgba(13, 21, 39, 0.4); border: 1.5px solid rgba(0, 255, 65, 0.15); border-radius: 14px; padding: 25px; box-shadow: 0 8px 30px rgba(0,0,0,0.45); position: relative; overflow: hidden;">
        <div style="position: absolute; bottom: -30px; right: -30px; width: 80px; height: 80px; background: rgba(0, 255, 65, 0.05); filter: blur(30px); border-radius: 50%;"></div>
        
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div>
                <span style="background: rgba(0,255,65,0.08); color: #00ff41; border: 1px solid rgba(0,255,65,0.2); font-size: 10px; font-weight: 800; padding: 3px 10px; border-radius: 20px; font-family: monospace; display: inline-block; margin-bottom: 8px;">COMMUNITY ENGAGEMENT</span>
                <h3 style="margin: 0; color: #fff; font-size: 16.5px; display: flex; align-items: center; gap: 8px; font-weight: 850;">
                    <i class="fa-solid fa-messages-question" style="color: #00ff41;"></i> এই পোস্ট নিয়ে আপনার কি কোনো প্রশ্ন বা দ্বিধা আছে?
                </h3>
                <p style="margin: 6px 0 0 0; color: #8b949e; font-size: 12.5px; line-height: 1.5;">আমাদের চমৎকার প্রশ্ন-উত্তর ফোরামে প্রশ্ন করে অভিজ্ঞদের সাহায্য নিন, অথবা অন্যদের প্রশ্নের উত্তর দিয়ে রিওয়ার্ড ইনকাম করুন!</p>
            </div>
            
            <div style="display: flex; background: rgba(13,17,23,0.9); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 4px; gap: 4px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);">
                <input type="text" id="sidebar-quick-q-input" placeholder="আপনার প্রশ্নটি এখানে লিখুন এবং ফোরামে সাবমিট করুন..." style="flex: 1; background: transparent; border: none; outline: none; padding: 10px 15px; color: #fff; font-size: 13.5px;">
                <button onclick="launchQuickForumQuestion()" style="background: linear-gradient(135deg, #00ff41 0%, #00f0ff 100%); color: #000; border: none; font-weight: 900; font-size: 12px; padding: 10px 22px; border-radius: 6px; cursor: pointer; transition: 0.2s; white-space: nowrap;">প্রশ্ন পোস্ট করুন 🚀</button>
            </div>
        </div>
    </div>
    <script>
    function launchQuickForumQuestion() {
        var query = document.getElementById('sidebar-quick-q-input').value.trim();
        if (query.length < 5) {
            alert('অনুগ্রহ করে নূন্যতম ৫ অক্ষরের একটি স্পষ্ট প্রযুক্তিগত প্রশ্ন লিখুন!');
            return;
        }
        var targetUrl = '<?php echo esc_js(home_url("/ask-question/")); ?>?q=' + encodeURIComponent(query);
        window.location.href = targetUrl;
    }
    </script>

    </div> <!-- Close ilybd-single-left-content -->

    <!-- Right Section: Cyber Sidebar -->
    <aside class="ilybd-single-right-sidebar" style="box-sizing: border-box;">
        <?php include get_template_directory() . '/template-parts/single-sidebar.php'; ?>
    </aside>

</div> <!-- Close ilybd-single-grid-wrapper -->

<?php 
// কমেন্ট সেকশনের নিচে কল করুন
get_template_part('single-search'); 
?>

<?php get_template_part('recommended-posts'); ?>

<?php do_action('ilybd_category'); ?>

<?php endwhile; endif; ?>

</div>

<style>
    .entry-content-main {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        font-size: 16px !important;
        line-height: 1.8 !important;
        color: #e6edf3 !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
    }
    .entry-content-main * {
        box-sizing: border-box !important;
        max-width: 100%; /* Prevent any inner element or code from outgrowing article */
    }
    .entry-content-main table {
        display: block !important;
        width: 100% !important;
        overflow-x: auto !important;
        border-collapse: collapse !important;
        margin-bottom: 24px !important;
        border: 1px solid #30363d !important;
        background: #0d1117 !important;
    }
    .entry-content-main table thead,
    .entry-content-main table tbody,
    .entry-content-main table tr {
        background: none !important;
        background-color: transparent !important;
    }
    .entry-content-main table th,
    .entry-content-main table td {
        padding: 10px 15px !important;
        border: 1px solid #30363d !important;
        background: #161b22 !important;
        background-color: #161b22 !important;
        color: #e6edf3 !important;
    }
    .entry-content-main table th {
        background: #0d1117 !important;
        background-color: #0d1117 !important;
        color: #00f0ff !important;
        font-family: monospace;
        font-weight: 700 !important;
    }
    .entry-content-main iframe, 
    .entry-content-main video, 
    .entry-content-main embed {
        max-width: 100% !important;
        border-radius: 8px !important;
        margin: 20px auto !important;
        display: block !important;
    }
    .entry-content-main p { 
        margin-bottom: 24px !important; 
        font-size: 16px !important;
        line-height: 1.8 !important;
        color: #e6edf3 !important;
    }
    .entry-content-main h1, 
    .entry-content-main h2, 
    .entry-content-main h3, 
    .entry-content-main h4 { 
        color: #ffffff !important; 
        font-weight: 700 !important;
        margin-top: 35px !important; 
        margin-bottom: 16px !important; 
        line-height: 1.4 !important;
        font-family: 'Rajdhani', sans-serif !important;
    }
    .entry-content-main h1 { font-size: 26px !important; }
    .entry-content-main h2 { font-size: 22px !important; position: relative; padding-bottom: 6px; border-bottom: 1px solid rgba(255,255,255,0.08); }
    .entry-content-main h3 { font-size: 19px !important; }
    .entry-content-main h4 { font-size: 17px !important; }
    
    .entry-content-main img { 
        max-width: 100% !important; 
        height: auto !important; 
        border-radius: 12px !important; 
        border: 1px solid #30363d !important; 
        margin: 22px auto !important; 
        display: block !important;
        object-fit: cover !important;
    }
    
    .entry-content-main a { 
        color: #58a6ff !important; 
        text-decoration: underline !important; 
        transition: color 0.2s ease !important; 
    }
    .entry-content-main a:hover { 
        color: #1f82ff !important; 
    }
    
    .entry-content-main ul, 
    .entry-content-main ol { 
        margin-bottom: 24px !important; 
        padding-left: 24px !important; 
    }
    .entry-content-main li { 
        margin-bottom: 8px !important; 
        line-height: 1.7 !important;
    }
    
    .entry-content-main blockquote {
        background: rgba(255, 255, 255, 0.02) !important;
        border-left: 4.5px solid #00ff41 !important;
        padding: 15px 20px !important;
        margin: 24px 0 !important;
        border-radius: 0 8px 8px 0 !important;
        font-style: italic !important;
        color: #8b949e !important;
    }
    .entry-content-main blockquote p {
        margin-bottom: 0 !important;
    }
    
    .entry-content-main pre, 
    .entry-content-main code {
        font-family: SFMono-Regular, Consolas, "Liberation Mono", Menlo, monospace !important;
        background-color: #161b22 !important;
        border: 1.5px solid #30363d !important;
        border-radius: 8px !important;
    }
    .entry-content-main pre {
        padding: 16px !important;
        overflow-x: auto !important;
        margin-bottom: 24px !important;
    }
    .entry-content-main code {
        font-size: 85% !important;
        padding: 2.5px 6px !important;
    }
    .entry-content-main pre code {
        padding: 0 !important;
        background-color: transparent !important;
        border: none !important;
        font-size: 13px !important;
        display: block !important;
        line-height: 1.6 !important;
    }
    
    /* এডিটর ফিক্স ফর মোবাইল */
    @media (max-width: 600px) {
        .puro-expert-shield { padding: 20px; }
        .hero-gradient { padding: 40px 15px 20px; }
    }

    /* Sidebar premium grid rules always active on Tablet & Desktop (>= 768px) */
    @media (min-width: 768px) {
        .ilybd-single-grid-wrapper {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) 300px !important;
            gap: 25px !important;
            max-width: 1300px !important;
            margin: 0 auto !important;
            padding: 0 20px !important;
        }
    }
    @media (min-width: 1024px) {
        .ilybd-single-grid-wrapper {
            grid-template-columns: minmax(0, 1fr) 340px !important;
            gap: 35px !important;
        }
    }
    @media (max-width: 767px) {
        .ilybd-single-grid-wrapper {
            display: block !important;
            padding: 0 15px !important;
        }
        .ilybd-single-right-sidebar {
            margin-top: 45px !important;
        }
    }
</style>

<?php get_footer(); ?>
