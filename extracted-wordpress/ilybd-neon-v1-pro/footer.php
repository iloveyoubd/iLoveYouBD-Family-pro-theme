<?php
/**
 * ILYBD CYBER FUTURE FOOTER v9.0 - FINAL SLIM MASTER
 * Included: Slim Mobile Nav (45px), Left Icons, Swiper Fix, AJAX Like, Page Grid
 * Fix: Smart Scroll Header Hide/Show logic added.
 */
$neon = get_option('ilybd_main_color', '#00ff41');
$enable_rgb = get_option('ilybd_enable_rgb', 'yes');
$rgb_style = get_option('ilybd_rgb_style', 'classic_neo');
?>

<?php if ($enable_rgb === 'yes') : ?>
<div class="cyber-rgb-frame <?php echo esc_attr($rgb_style); ?>"></div>
<?php endif; ?>

<footer class="cyber-footer">
    <div class="footer-bg-glow"></div>
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="brand-title">ILYBD SYSTEM</div>
            <div class="brand-sub">FUTURE • NEON • CONNECTED</div>
        </div>

        <!-- 🔥 CYBER NEWSLETTER SUBSCRIPTION MODULE -->
        <div class="cyber-newsletter-section" style="max-width: 580px; margin: 35px auto 40px auto; padding: 25px; background: rgba(9, 13, 19, 0.7); border: 1.5px dashed <?php echo $neon; ?>44; border-radius: 16px; position: relative; z-index: 50; box-shadow: 0 0 20px rgba(0, 255, 65, 0.05);">
            <div style="font-size: 18px; font-weight: 800; color: #fff; text-shadow: 0 0 10px <?php echo $neon; ?>55; letter-spacing: 1px; margin-bottom: 8px;">
                <i class="fa-solid fa-paper-plane" style="color: <?php echo $neon; ?>; margin-right: 6px;"></i> সাবস্ক্রাইব নিউজলেটার (Subscribe by Newsletter)
            </div>
            <p style="font-size: 12px; color: #8b949e; margin-bottom: 18px; line-height: 1.5; padding: 0 10px;">আমাদের প্ল্যাটফর্মের লেটেস্ট টেকনোলজি আপডেট, প্রোগ্রামিং টিউটোরিয়াল এবং ক্যারিয়ার সম্পর্কিত টিপস সরাসরি ইমেইলে পেতে সাবস্ক্রাইব করে রাখুন।</p>
            
            <form id="ilybd-newsletter-form" style="display: flex; gap: 8px; width: 100%; max-width: 500px; margin: 0 auto; flex-wrap: wrap;">
                <input type="email" name="sub_email" required placeholder="আপনার ইমেইল এড্রেস লিখুন..." style="background: #11161d; color: #fff; border: 1px solid #30363d; padding: 12px 16px; border-radius: 8px; flex: 1; min-width: 240px; outline: none; font-size: 13.5px; transition: all 0.3s; font-weight: bold; text-align: left;" onfocus="this.style.borderColor='<?php echo $neon; ?>'; this.style.boxShadow='0 0 10px <?php echo $neon; ?>33';">
                <button type="submit" style="background: <?php echo $neon; ?>; color: #000; font-weight: 900; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px; transition: all 0.3s; display: flex; align-items: center; justify-content: center; font-size: 13px;" onmouseover="this.style.boxShadow='0 0 15px <?php echo $neon; ?>'; this.style.transform='translateY(-1px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                    <span>Subscribe</span>
                </button>
            </form>
            <div id="newsletter-message" style="margin-top: 15px; font-size: 12.5px; font-weight: bold; display: none; text-align: center; padding: 5px; border-radius: 6px;"></div>
        </div>
        
        <div class="footer-grid">
            <a href="/about" class="f-link">About Us</a>
            <a href="/contact" class="f-link">Contact Us</a>
            <a href="/privacy-policy" class="f-link">Privacy Policy</a>
            <a href="/terms" class="f-link">Terms & Conditions</a>
            <a href="/support" class="f-link">Support Us</a>
            <a href="/faq" class="f-link">FAQ</a>
            <a href="/copyrights" class="f-link">Copyrights</a>
            <a href="/disclaimer" class="f-link">Disclaimer</a>
            <a href="/user-rights" class="f-link">User Rights</a>
            <a href="/advisement" class="f-link">Advisements</a>
            <a href="/community-guidelines" class="f-link">Community Guidelines</a>
            <a href="/safety" class="f-link">Safety & Control</a>
            <a href="/ai-content-policy" class="f-link" style="color: #60a5fa; font-weight: bold;">AI Content Policy</a>
            <a href="/cookie-policy" class="f-link" style="color: #60a5fa; font-weight: bold;">Cookie Policy</a>
            <a href="/corrections-policy" class="f-link" style="color: #60a5fa; font-weight: bold;">Corrections Policy</a>
            <a href="/dmca" class="f-link" style="color: #60a5fa; font-weight: bold;">DMCA Policy</a>
            <a href="/editorial-policy" class="f-link" style="color: #60a5fa; font-weight: bold;">Editorial Policy</a>
            <a href="/authors" class="f-link" style="color: #22c55e; font-weight: bold;">Our Authors Hub</a>
            <a href="/how-to-earn-money" class="f-link" style="color: #00ff41; font-weight: bold;">Earn Online Rewards</a>
            <a href="/make-money-online" class="f-link" style="color: #00f0ff; font-weight: bold;">Earning Guides Hub</a>
            <a href="/refer-and-earn" class="f-link" style="color: #ffaa00; font-weight: bold;">Referral Hub</a>
            <a href="/sitemap" class="f-link" style="color: #ec4899; font-weight: bold;">HTML Sitemap Index</a>
        </div>
        
        <div class="footer-copy-big">
            © 2026 ILYBD • Developed By 
            <a href="https://iloveyoubd.com/team" target="_blank" class="team-link-pro">iLoveYouBD Team</a>
        </div>
    </div>
</footer>

<nav class="cyber-mobile-nav" aria-label="Mobile Navigation">
    <div class="nav-container-inner">
        
        <div class="nav-group-side">
            <a href="<?php echo home_url(); ?>" class="nav-item" aria-label="Home Link">
                <span class="n-icon">🏠</span><span class="n-text">Home</span>
            </a>
            <a href="<?php echo home_url('/tv'); ?>" class="nav-item" aria-label="Live TV Channel">
                <span class="n-icon">📺</span><span class="n-text">Live TV</span>
            </a>
        </div>

        <div class="nav-center-bridge">
            <div class="nav-ai-btn" onclick="jQuery('.cyber-chat-window').toggleClass('active');" title="AI Chat" role="button" aria-label="Toggle AI Assist Chatbot" tabindex="0">
                <div class="ai-symbol">
                    <svg class="gemini-star" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: <?php echo $neon; ?>; filter: drop-shadow(0 0 8px <?php echo $neon; ?>); animation: pulseStar 1.8s infinite ease-in-out;">
                        <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                    </svg>
                </div>
                <div class="ai-glow-ring"></div>
            </div>
        </div>

        <div class="nav-group-side">
            <a href="<?php echo home_url('/tools-lab'); ?>" class="nav-item" aria-label="System Tools Lab">
                <span class="n-icon">🧪</span><span class="n-text">Tools Lab</span>
            </a>
            <a href="<?php echo home_url('/dashboard?action=profile'); ?>" class="nav-item" aria-label="User Account Profile">
                <span class="n-icon">👤</span><span class="n-text">Profile</span>
            </a>
        </div>

    </div>
</nav>

<style>
@keyframes pulseStar {
    0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.9; }
    50% { transform: scale(1.22) rotate(15deg); opacity: 1; filter: drop-shadow(0 0 12px <?php echo $neon; ?>); }
}
/* --- Header Scroll Animation CSS --- */
header, .main-header, #masthead {
    position: fixed !important;
    top: 0;
    width: 100%;
    z-index: 10000000 !important;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

/* এই ক্লাসটি স্ক্রল করার সময় JS দিয়ে যুক্ত হবে */
.header-hidden {
    transform: translateY(-110%);
}

/* Base Reset */
body { background: #0b0f15; padding-bottom: 60px !important; }

/* RGB Frame Effect */
.cyber-rgb-frame {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    pointer-events: none; z-index: 99999; opacity: 0.15;
    background-size: 400%;
}

/* 1. Classic Neon Multi-Color RGB */
.cyber-rgb-frame.classic_neo {
    background: linear-gradient(90deg, #ff004c, #00ffcc, #3b82f6, #ff004c);
    animation: rgbMove_classic 8s linear infinite;
    opacity: 0.15;
}
@keyframes rgbMove_classic { 0%{filter:hue-rotate(0deg);} 100%{filter:hue-rotate(360deg);} }

/* 2. Cosmic Cyber Aurora */
.cyber-rgb-frame.aurora_glow {
    background: linear-gradient(135deg, #059669, #06b6d4, #10b981, #0891b2);
    animation: rgbMove_aurora 6s ease infinite alternate;
    opacity: 0.16;
}
@keyframes rgbMove_aurora {
    0% { background-position: 0% 50%; opacity: 0.12; }
    100% { background-position: 100% 50%; opacity: 0.22; }
}

/* 3. Toxic Matrix Neon */
.cyber-rgb-frame.toxic_matrix {
    background: linear-gradient(180deg, #22c55e, #15803d, #22c55e);
    animation: rgbMove_toxic 0.4s steps(6) infinite;
    opacity: 0.08;
}
@keyframes rgbMove_toxic {
    0% { opacity: 0.06; }
    50% { opacity: 0.12; }
    100% { opacity: 0.06; }
}

/* 4. Electric Sunset Glow */
.cyber-rgb-frame.electric_sunset {
    background: linear-gradient(45deg, #f43f5e, #d946ef, #7c3aed, #f43f5e);
    animation: rgbMove_sunset 10s ease infinite;
    opacity: 0.15;
}
@keyframes rgbMove_sunset {
    0% { background-position: 0% 20%; opacity: 0.12; }
    50% { background-position: 100% 80%; opacity: 0.22; }
    100% { background-position: 0% 20%; opacity: 0.12; }
}

/* 5. Cyber Golden Amber */
.cyber-rgb-frame.cyber_amber {
    background: linear-gradient(90deg, #f59e0b, #ea580c, #f59e0b);
    animation: rgbMove_amber 5s ease-in-out infinite alternate;
    opacity: 0.14;
}
@keyframes rgbMove_amber {
    0% { opacity: 0.10; }
    100% { opacity: 0.20; filter: hue-rotate(15deg); }
}

/* 6. Mono Neon Ice Blue */
.cyber-rgb-frame.neon_blue_mono {
    background: linear-gradient(90deg, #0284c7, #06b6d4, #0284c7);
    animation: rgbMove_blue_mono 6s linear infinite;
    opacity: 0.16;
}
@keyframes rgbMove_blue_mono {
    0% { opacity: 0.10; }
    50% { opacity: 0.20; }
    100% { opacity: 0.10; }
}

/* Footer Design */
.cyber-footer {
    position: relative; background: #04070c; margin-top: 50px;
    padding: 60px 15px 120px; border-top: 1px solid <?php echo $neon; ?>33;
    overflow: hidden; z-index: 10; text-align: center;
}
.footer-bg-glow {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: radial-gradient(circle at 50% 100%, <?php echo $neon; ?>1d 0%, transparent 70%);
    animation: glowPulse 5s ease-in-out infinite; z-index: -1;
}
@keyframes glowPulse { 0%, 100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.7; transform: scale(1.1); } }

.footer-brand .brand-title { font-size: 26px; font-weight: 900; color: #fff; text-shadow: 0 0 15px <?php echo $neon; ?>77; letter-spacing: 2px; }
.footer-brand .brand-sub { font-size: 11px; color: #94a3b8; letter-spacing: 4px; text-transform: uppercase; margin-top: 5px; }

/* Grid for Links with increased size and sleek animations */
.footer-grid { 
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; 
    margin: 45px auto; max-width: 1050px; 
}
@media (max-width: 768px) { .footer-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; } }
@media (max-width: 480px) { .footer-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; } }

.f-link { 
    color: #aaa; text-decoration: none; font-size: 14.5px; padding: 13.5px 15px; 
    background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); 
    border-radius: 8px; transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1); font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    display: inline-block;
}
.f-link:hover { 
    border-color: <?php echo $neon; ?>; 
    color: #fff; 
    background: rgba(255,255,255,0.06);
    transform: translateY(-4px) scale(1.03); 
    box-shadow: 0 6px 20px rgba(0, 255, 65, 0.18), inset 0 1px 0 rgba(255,255,255,0.08);
}

/* SLIM MOBILE NAV */
.cyber-mobile-nav {
    position: fixed; bottom: 0; left: 0; width: 100%; height: 55px;
    background: rgba(4, 6, 11, 0.60); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border-top: 1px solid <?php echo $neon; ?>33; z-index: 99999;
}
.nav-container-inner {
    display: flex; height: 100%; align-items: center; justify-content: space-between;
    max-width: 600px; margin: 0 auto; padding: 0 10px;
}
.nav-group-side { display: flex; flex: 2; justify-content: space-around; align-items: center; }

.nav-item { 
    display: flex; flex-direction: row; align-items: center; justify-content: center;
    text-decoration: none; gap: 6px; transition: 0.3s;
    padding: 14px 10px; min-width: 44px; min-height: 44px;
}
.n-icon { font-size: 16px; text-shadow: 0 0 5px rgba(255,255,255,0.2); }
.n-text { font-size: 11px; color: #cbd5e1; font-weight: 700; text-transform: uppercase; }
.nav-item:hover .n-text { color: <?php echo $neon; ?>; }
.nav-item:hover .n-icon { text-shadow: 0 0 10px <?php echo $neon; ?>; transform: scale(1.1); }

/* Slim Center AI Button */
.nav-center-bridge { flex: 1; display: flex; justify-content: center; position: relative; }
.nav-ai-btn {
    width: 48px; height: 48px; background: rgba(0,0,0,0.8); border: 2px solid <?php echo $neon; ?>;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    position: absolute; bottom: 15px; box-shadow: 0 0 15px <?php echo $neon; ?>88;
    cursor: pointer; transition: 0.3s ease; z-index: 100;
}
.ai-symbol { font-size: 20px; color: <?php echo $neon; ?>; text-shadow: 0 0 10px <?php echo $neon; ?>; display: flex; align-items: center; justify-content: center; }
.ai-glow-ring {
    position: absolute; width: 100%; height: 100%; border-radius: 50%;
    border: 1px solid <?php echo $neon; ?>44; animation: ping 2s infinite;
}
@keyframes ping { 75%, 100% { transform: scale(1.4); opacity: 0; } }

.footer-copy-big { margin-top: 35px; font-size: 14px; color: #94a3b8; }
.team-link-pro { color: <?php echo $neon; ?>; text-decoration: none; }
</style>

<script>
jQuery(document).ready(function($) {
    /* 1. Swiper Slider Logic */
    if (typeof Swiper !== 'undefined') {
        const swiperThumbs = new Swiper(".hero-thumbs", {
            spaceBetween: 8, slidesPerView: 2.5, freeMode: true, watchSlidesProgress: true,
            breakpoints: { 
                768: { slidesPerView: 4.5 },
                1024: { slidesPerView: 5.5 }
            }
        });
        const swiperMain = new Swiper(".hero-slider", {
            loop: true, 
            speed: 850, 
            autoplay: { delay: 5000, disableOnInteraction: false },
            spaceBetween: 20,
            slidesPerView: 1,
            thumbs: { swiper: swiperThumbs },
            on: {
                init: function () {
                    jQuery('.thumb-progress-fill').css('width', '0%');
                    jQuery('.hero-thumbs .swiper-slide-thumb-active .thumb-progress-fill').stop().animate({ width: '100%' }, 5000, 'linear');
                },
                slideChange: function () {
                    jQuery('.thumb-progress-fill').stop().css('width', '0%');
                    setTimeout(() => {
                        jQuery('.hero-thumbs .swiper-slide-thumb-active .thumb-progress-fill').stop().animate({ width: '100%' }, 5000, 'linear');
                    }, 50);
                }
            }
        });
    }

    /* 2. AJAX Like System */
    $(document).on('click', '.comment-like-btn', function(e) {
        e.preventDefault();
        var button = $(this);
        var commentId = button.data('comment-id');
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: { action: 'ilybd_like_comment', comment_id: commentId },
            success: function(response) {
                if (response.success) {
                    button.find('.like-count').text(response.data.likes);
                    button.css('color', '<?php echo $neon; ?>');
                }
            }
        });
    });

    /* 3. Smart Scroll Header Logic - FIXED & IMPROVED */
    let lastScroll = 0;
    const header = document.querySelector('header') || document.querySelector('.main-header') || document.querySelector('#masthead');
    
    window.addEventListener('scroll', function(){
        let current = window.pageYOffset || document.documentElement.scrollTop;
        
        // যদি একদম উপরে থাকে তবে সবসময় দেখাবে
        if (current <= 0) {
            header?.classList.remove('header-hidden');
            return;
        }

        // নিচের দিকে স্ক্রল করলে হাইড হবে, উপরের দিকে করলে দেখা যাবে
        if(current > lastScroll && current > 100){
            // Scrolling Down
            header?.classList.add('header-hidden');
        } else {
            // Scrolling Up
            header?.classList.remove('header-hidden');
        }
        lastScroll = current;
    });

    // 4. Dynamic Header Height Padding Adjustment
    function adjustHeaderPadding() {
        const headerElem = document.querySelector('header') || document.querySelector('.main-header') || document.querySelector('#masthead');
        if (headerElem) {
            document.body.style.paddingTop = (headerElem.offsetHeight - 15) + 'px';
        }
    }
    adjustHeaderPadding();
    window.addEventListener('resize', adjustHeaderPadding);
    window.addEventListener('load', adjustHeaderPadding);
    setTimeout(adjustHeaderPadding, 300);
    setTimeout(adjustHeaderPadding, 1000); // Fail-safe fallback for delayed font rendering

    /* 5. Newsletter AJAX Submission */
    $('#ilybd-newsletter-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var emailInput = form.find('input[name="sub_email"]');
        var email = emailInput.val();
        var msgWrap = $('#newsletter-message');
        
        form.css('opacity', '0.6');
        msgWrap.hide();
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'ilybd_subscribe_newsletter',
                email: email
            },
            success: function(res) {
                form.css('opacity', '1');
                if (res.success) {
                    msgWrap.css({
                        'color': '#fff',
                        'background': 'rgba(0, 255, 65, 0.15)',
                        'border': '1px solid rgba(0, 255, 65, 0.3)'
                    }).html('<i class="fa-solid fa-circle-check" style="color:#00ff41; margin-right:5px;"></i> ' + res.data.message).fadeIn();
                    emailInput.val('');
                } else {
                    msgWrap.css({
                        'color': '#fff',
                        'background': 'rgba(255, 45, 45, 0.15)',
                        'border': '1px solid rgba(255, 45, 45, 0.3)'
                    }).html('<i class="fa-solid fa-triangle-exclamation" style="color:#ff3333; margin-right:5px;"></i> ' + res.data.message).fadeIn();
                }
            },
            error: function() {
                form.css('opacity', '1');
                msgWrap.css({
                    'color': '#fff',
                    'background': 'rgba(255, 45, 45, 0.15)',
                    'border': '1px solid rgba(255, 45, 45, 0.3)'
                }).html('<i class="fa-solid fa-triangle-exclamation" style="color:#ff3333; margin-right:5px;"></i> সার্ভার কানেকশন ত্রুটি! পুনরায় চেষ্টা করুন।').fadeIn();
            }
        });
    });
});
</script>

<!-- ⚡ ILYBD GLOBAL SYSTEM Speech Synthesis (TTS Player v2.10 - 2040 Neon Style) ⚡ -->
<style>
@keyframes globalTtsPulse {
    0% { transform: scale(1); box-shadow: 0 0 10px #00f0ff; }
    50% { transform: scale(1.08); box-shadow: 0 0 20px #00ff41, 0 0 10px #00f0ff; }
    100% { transform: scale(1); box-shadow: 0 0 10px #00f0ff; }
}
.card-tts-trigger.playing {
    animation: globalTtsPulse 1.2s infinite ease-in-out !important;
    background: #00f0ff !important;
    color: #000 !important;
    border-color: #00ff41 !important;
}
@keyframes pulseGlow {
    from { filter: drop-shadow(0 0 2px #00f0ff); opacity: 0.8; }
    to { filter: drop-shadow(0 0 10px #00ff41); opacity: 1; }
}
@keyframes ttsBounce {
    0% { transform: scaleY(0.7); }
    100% { transform: scaleY(1.3); }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Dynamic Injection of Page TTS Panel (Only if (.inner-page-content) exists and not single post)
    var pageContent = document.querySelector('.inner-page-content');
    if (pageContent && !document.body.classList.contains('single-post')) {
        var panelHtml = `
            <div class="cyber-global-page-tts-panel" style="background: rgba(9, 13, 19, 0.95); border: 1.5px solid #00f0ff; border-radius: 12px; padding: 15px; margin-bottom: 25px; box-shadow: 0 4px 20px rgba(0, 240, 255, 0.15); display: flex; flex-direction: column; gap: 12px; font-family: sans-serif; position: relative; z-index: 99;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <h4 style="margin: 0; font-size: 13.5px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-microphone-lines" style="color: #00f0ff; animation: pulseGlow 1.5s infinite alternate;"></i> এআই ভয়েস রিডার (AI Page Reader)
                    </h4>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-size: 10px; color: #8b949e; font-family: monospace;">VOICE:</span>
                        <select id="global-page-tts-voice" style="background: #11161d; color: #fff; border: 1px solid rgba(255,255,255,0.08); padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; cursor: pointer;">
                            <option value="female" selected>👩 মেয়ের কণ্ঠ (Female)</option>
                            <option value="male">👨 ছেলের কণ্ঠ (Male)</option>
                        </select>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button id="global-page-tts-play-btn" onclick="togglePageAudioSpeak()" style="background: linear-gradient(135deg, #00f0ff 0%, #00ff41 100%); color: #000; font-weight: 900; font-size: 11.5px; border: none; padding: 8px 18px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" onmouseover="this.style.boxShadow='0 0 10px #00f0ff'; this.style.transform='translateY(-1px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='none';">
                            <i class="fa-solid fa-play"></i> পড়ে শোনান (Listen Page)
                        </button>
                        <button id="global-page-tts-stop-btn" onclick="stopGlobalTts()" style="background: rgba(255,45,45,0.12); color: #ff3b30; border: 1.5px solid rgba(255,45,45,0.22); font-weight: bold; font-size: 11px; padding: 7px 14px; border-radius: 6px; cursor: pointer; display: none; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-circle-stop"></i> বন্ধ করুন
                        </button>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 11px; color: #8b949e; font-family: monospace;">SPEED:</span>
                        <select id="global-page-tts-speed" style="background: #11161d; color: #fff; border: 1px solid rgba(255,255,255,0.08); padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; cursor: pointer;">
                            <option value="0.8">0.8x ধীর</option>
                            <option value="1.0" selected>1.0x সাধারণ</option>
                            <option value="1.2">1.2x দ্রুত</option>
                        </select>
                    </div>
                </div>
                
                <div id="global-page-tts-hud" style="background: rgba(0,0,0,0.3); border-radius: 6px; padding: 8px 12px; border: 1px solid rgba(255,255,255,0.02); display: none; align-items: center; justify-content: space-between;">
                    <span id="global-page-tts-msg" style="font-size: 11.5px; color: #00f0ff; font-family: sans-serif; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 80%;">রিডার কন্টেন্ট বিশ্লেষণ করছে...</span>
                    <div class="voice-playing-wave" style="display: flex; align-items: flex-end; gap: 1.5px; height: 10px;">
                        <span style="display:inline-block; width: 1.5px; height: 6px; background: #00f0ff; animation: waveBar 0.5s infinite alternate 0.1s;"></span>
                        <span style="display:inline-block; width: 1.5px; height: 10px; background: #00f0ff; animation: waveBar 0.5s infinite alternate 0.3s;"></span>
                        <span style="display:inline-block; width: 1.5px; height: 4px; background: #00f0ff; animation: waveBar 0.5s infinite alternate 0.5s;"></span>
                    </div>
                </div>
            </div>
        `;
        pageContent.insertAdjacentHTML('afterbegin', panelHtml);
    }

    // 2. Global TTS Engine State
    var globalTtsState = {
        isPlaying: false,
        activeUtterance: null,
        currentBtn: null,
        voiceType: 'female'
    };

    var pageParagraphs = [];
    var pageParagraphIndex = 0;

    // Triggered by card speaker buttons
    window.toggleCardPlayback = function(btn, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        var title = btn.getAttribute('data-title') || '';
        var excerpt = btn.getAttribute('data-excerpt') || '';
        var fullText = title + "। " + excerpt;

        if (globalTtsState.isPlaying && globalTtsState.currentBtn === btn) {
            window.stopGlobalTts();
            return;
        }

        if (globalTtsState.isPlaying) {
            window.stopGlobalTts();
        }

        // Play card audio
        globalTtsState.isPlaying = true;
        globalTtsState.currentBtn = btn;
        btn.classList.add('playing');
        btn.innerHTML = '<i class="fa-solid fa-volume-high" style="animation: ttsBounce 0.5s infinite alternate;"></i>';
        
        window.speechSynthesis.cancel();
        
        var utterance = new SpeechSynthesisUtterance(fullText);
        utterance.lang = 'bn-BD';
        utterance.rate = 1.0;
        utterance.pitch = (globalTtsState.voiceType === 'male') ? 0.8 : 1.15;

        if (window.speechSynthesis.getVoices) {
            var voices = window.speechSynthesis.getVoices();
            var bengaliVoice = voices.find(function(v) { return v.lang.indexOf('bn') !== -1; });
            if (bengaliVoice) utterance.voice = bengaliVoice;
        }

        utterance.onend = function() {
            window.stopGlobalTts();
        };

        utterance.onerror = function() {
            window.stopGlobalTts();
        };

        globalTtsState.activeUtterance = utterance;
        window.speechSynthesis.speak(utterance);
    };

    // ⚡ NEW TRIGGERED BY HEADER PLAY BUTTON ⚡
    window.toggleHeaderTts = function(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        var headerBtn = document.getElementById('header-global-tts-btn');
        var headerIcon = document.getElementById('header-global-tts-icon');
        var activeDot = document.getElementById('header-tts-active-dot');

        if (globalTtsState.isPlaying && globalTtsState.currentBtn === headerBtn) {
            window.stopGlobalTts();
            return;
        }

        if (globalTtsState.isPlaying) {
            window.stopGlobalTts();
        }

        pageParagraphs = [];
        // Scan standard containers hierarchically to find speakable content
        var containers = document.querySelectorAll('.entry-content-main, .inner-page-content, main, article, #main, .main-content, .post-grid, .dashboard-container, body');
        for (var i = 0; i < containers.length; i++) {
            var elList = containers[i].querySelectorAll('p, h2, h3, h4, li');
            elList.forEach(function(pEl) {
                if (pEl.closest('header, footer, nav, .cyber-dropdown-menu, .cyber-global-page-tts-panel, .card-tts-trigger, button, #header-tools-dropdown, .messenger-box, .widget-title, .widget, .nav-grid')) {
                    return;
                }
                var text = pEl.textContent.trim();
                if (text.length > 8) {
                    pageParagraphs.push({
                        element: pEl,
                        text: text
                    });
                }
            });
            if (pageParagraphs.length > 0) {
                break;
            }
        }

        if (pageParagraphs.length === 0) {
            console.log('No speakable text found.');
            return;
        }

        globalTtsState.isPlaying = true;
        globalTtsState.currentBtn = headerBtn;
        pageParagraphIndex = 0;

        if (headerIcon) {
            headerIcon.className = 'fa-solid fa-circle-stop';
        }
        if (activeDot) {
            activeDot.style.display = 'block';
        }
        if (headerBtn) {
            headerBtn.classList.add('playing');
        }

        speakPageParagraph(0);
    };

    // Triggered by Page AI voice reader button
    window.togglePageAudioSpeak = function() {
        var playBtn = document.getElementById('global-page-tts-play-btn');
        if (!playBtn) return;

        if (globalTtsState.isPlaying && globalTtsState.currentBtn === playBtn) {
            if (window.speechSynthesis.paused) {
                window.speechSynthesis.resume();
                playBtn.innerHTML = '<i class="fa-solid fa-pause"></i> থামুন (Pause)';
                document.getElementById('global-page-tts-msg').textContent = 'পড়ছি: ' + pageParagraphs[pageParagraphIndex].text.substring(0, 35) + '...';
            } else {
                window.speechSynthesis.pause();
                playBtn.innerHTML = '<i class="fa-solid fa-play"></i> শুনুন (Resume)';
                document.getElementById('global-page-tts-msg').textContent = 'থামানো হয়েছে (Paused)';
            }
            return;
        }

        if (globalTtsState.isPlaying) {
            window.stopGlobalTts();
        }

        pageParagraphs = [];
        var parentContainer = document.querySelector('.inner-page-content');
        if (!parentContainer) return;

        var textElements = parentContainer.querySelectorAll('p, h2, h3, li');
        textElements.forEach(function(el) {
            if (el.closest('.cyber-global-page-tts-panel')) return;
            var txt = el.textContent.trim();
            if (txt.length > 5) {
                pageParagraphs.push({
                    element: el,
                    text: txt
                });
            }
        });

        if (pageParagraphs.length === 0) {
            console.log('No legible content paragraphs found.');
            return;
        }

        globalTtsState.isPlaying = true;
        globalTtsState.currentBtn = playBtn;
        pageParagraphIndex = 0;

        playBtn.innerHTML = '<i class="fa-solid fa-pause"></i> থামুন (Pause)';
        
        var stopBtn = document.getElementById('global-page-tts-stop-btn');
        if (stopBtn) stopBtn.style.display = 'inline-flex';
        
        var hud = document.getElementById('global-page-tts-hud');
        if (hud) hud.style.display = 'flex';

        speakPageParagraph(0);
    };

    function speakPageParagraph(index) {
        if (!globalTtsState.isPlaying) return;

        // Reset all styles
        document.querySelectorAll('p, h2, h3, h4, li').forEach(function(el) {
            el.style.background = '';
            el.style.borderLeft = '';
            el.style.paddingLeft = '';
        });

        if (index >= pageParagraphs.length) {
            window.stopGlobalTts();
            return;
        }

        pageParagraphIndex = index;
        var pData = pageParagraphs[index];

        // Highlight with dynamic cool cyber gradient neon borders
        pData.element.style.background = 'rgba(0, 240, 255, 0.05)';
        pData.element.style.borderLeft = '4px solid #00f0ff';
        pData.element.style.paddingLeft = '14px';
        pData.element.style.borderRadius = '0 8px 8px 0';
        pData.element.style.transition = 'all 0.3s ease';

        var scrollPos = pData.element.getBoundingClientRect().top + window.pageYOffset;
        window.scrollTo({
            top: scrollPos - 130,
            behavior: 'smooth'
        });

        window.speechSynthesis.cancel();

        var utterance = new SpeechSynthesisUtterance(pData.text);
        utterance.lang = 'bn-BD';
        
        var speedRateEl = document.getElementById('global-page-tts-speed');
        var speedRate = speedRateEl ? parseFloat(speedRateEl.value || '1.0') : 1.0;
        utterance.rate = speedRate;

        var voiceTypeSelEl = document.getElementById('global-page-tts-voice');
        var voiceTypeSel = voiceTypeSelEl ? voiceTypeSelEl.value : 'female';
        globalTtsState.voiceType = voiceTypeSel;
        utterance.pitch = (voiceTypeSel === 'male') ? 0.8 : 1.15;

        if (window.speechSynthesis.getVoices) {
            var voices = window.speechSynthesis.getVoices();
            var bengaliVoice = voices.find(function(v) { return v.lang.indexOf('bn') !== -1; });
            if (bengaliVoice) utterance.voice = bengaliVoice;
        }

        var msgEl = document.getElementById('global-page-tts-msg');
        if (msgEl) msgEl.textContent = 'পড়ছি: ' + pData.text.substring(0, 35) + '...';

        utterance.onend = function() {
            setTimeout(function() {
                if (globalTtsState.isPlaying && !window.speechSynthesis.paused) {
                    speakPageParagraph(index + 1);
                }
            }, 800);
        };

        utterance.onerror = function() {
            if (globalTtsState.isPlaying && !window.speechSynthesis.paused) {
                speakPageParagraph(index + 1);
            }
        };

        globalTtsState.activeUtterance = utterance;
        window.speechSynthesis.speak(utterance);
    }

    window.stopGlobalTts = function() {
        window.speechSynthesis.cancel();
        
        // Reset Header Button state
        var headerBtn = document.getElementById('header-global-tts-btn');
        var headerIcon = document.getElementById('header-global-tts-icon');
        var activeDot = document.getElementById('header-tts-active-dot');
        if (headerBtn) {
            headerBtn.classList.remove('playing');
        }
        if (headerIcon) {
            headerIcon.className = 'fa-solid fa-volume-high';
        }
        if (activeDot) {
            activeDot.style.display = 'none';
        }

        if (globalTtsState.currentBtn) {
            var btn = globalTtsState.currentBtn;
            btn.classList.remove('playing');
            if (btn.classList.contains('card-tts-trigger')) {
                btn.innerHTML = '<i class="fa-solid fa-volume-high"></i>';
                btn.style.background = 'rgba(4, 7, 12, 0.85)';
                btn.style.color = '#00f0ff';
                btn.style.boxShadow = '0 0 12px rgba(0, 240, 255, 0.35)';
            }
        }

        globalTtsState.isPlaying = false;
        globalTtsState.currentBtn = null;
        globalTtsState.activeUtterance = null;

        // Reset page controls
        var playBtn = document.getElementById('global-page-tts-play-btn');
        if (playBtn) playBtn.innerHTML = '<i class="fa-solid fa-play"></i> পড়ে শোনান (Listen Page)';
        
        var stopBtn = document.getElementById('global-page-tts-stop-btn');
        if (stopBtn) stopBtn.style.display = 'none';

        var hud = document.getElementById('global-page-tts-hud');
        if (hud) hud.style.display = 'none';

        document.querySelectorAll('p, h2, h3, h4, li').forEach(function(el) {
            el.style.background = '';
            el.style.borderLeft = '';
            el.style.paddingLeft = '';
            el.style.borderRadius = '';
        });
    };

    window.addEventListener('beforeunload', function() {
        window.speechSynthesis.cancel();
    });
});
</script>

<!-- 🛡️ GOOGLE ADSENSE COMPLIANCE & CYBER COOKIE CONSENT BANNER (2040 STYLING) -->
<div id="ilybd-cyber-cookie-banner" class="cookie-banner-hidden" style="position: fixed; bottom: 25px; left: 50%; transform: translateX(-50%) translateY(120px); width: 92%; max-width: 680px; background: rgba(7, 11, 19, 0.96); border: 2.2px solid <?php echo $neon; ?>; border-radius: 16px; padding: 22px 28px; box-shadow: 0 10px 40px rgba(0,255,65,0.15), inset 0 0 15px rgba(0,255,65,0.05); z-index: 999999; font-family: system-ui, -apple-system, sans-serif; transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); display: none;">
    <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap; text-align: left;">
        <div style="flex: 1; min-width: 280px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="font-size: 20px;">🛡️</span>
                <strong style="color: #fff; font-size: 15px; letter-spacing: 0.5px; text-transform: uppercase; font-family: 'Space Grotesk', monospace;">Cookie Consent & Safeguard Panel</strong>
            </div>
            <p style="font-size: 11.5px; color: #a0aec0; margin: 0; line-height: 1.6; font-family: system-ui, sans-serif;">
                আমরা কুকি ব্যবহার করি: <strong>iloveyoubd.com</strong> ভিজিটরদের ব্রাউজিং অভিজ্ঞতা উন্নত করতে, এআই ও এসইও সেশন ট্র্যাকিং এবং গুগল অ্যাডসেন্স পলিসি অনুযায়ী সেফ কুকি ব্যবহার করে থাকে। সাইটটি ব্যবহার অব্যাহত রাখলে আপনি এতে সম্মত আছেন।
            </p>
        </div>
        <div style="display: flex; gap: 14px; align-items: center; margin-top: 5px;">
            <a href="<?php echo home_url('/privacy-policy/'); ?>" style="color: #a0aec0; text-decoration: underline; font-size: 12px; font-weight: bold; transition: 0.2s;" onmouseover="this.style.color='<?php echo $neon; ?>';" onmouseout="this.style.color='#a0aec0';">প্রাইভেসি পলিসি</a>
            <button id="ilybd-accept-cookie-btn" style="background: <?php echo $neon; ?>; color: #000; border: none; font-weight: 900; font-size: 12.5px; padding: 10px 22px; border-radius: 8px; cursor: pointer; text-transform: uppercase; transition: all 0.3s; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 0 12px <?php echo $neon; ?>44;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 0 20px <?php echo $neon; ?>';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 0 12px <?php echo $neon; ?>44';">
                <span>Accept (সম্মতি দিন)</span>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var banner = document.getElementById("ilybd-cyber-cookie-banner");
    var acceptBtn = document.getElementById("ilybd-accept-cookie-btn");
    
    if (!banner || !acceptBtn) return;
    
    // Quick helper to read browser cookie
    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
        return null;
    }
    
    // Check if consent has already been granted
    var consent = getCookie("ily_cookie_consent");
    if (!consent) {
        banner.style.display = "block";
        setTimeout(function() {
            banner.style.transform = "translateX(-50%) translateY(0)";
        }, 1500);
    }
    
    acceptBtn.addEventListener("click", function() {
        // Set cookie consent valid for 365 days
        var expiry = new Date();
        expiry.setTime(expiry.getTime() + (365 * 24 * 60 * 60 * 1000));
        document.cookie = "ily_cookie_consent=accepted; expires=" + expiry.toUTCString() + "; path=/; SameSite=Lax; Secure";
        
        banner.style.transform = "translateX(-50%) translateY(120px)";
        setTimeout(function() {
            banner.style.display = "none";
        }, 600);
    });
});
</script>

<?php get_template_part('template-parts/messenger-box'); ?>

<?php wp_footer(); ?>
</body>
</html>
