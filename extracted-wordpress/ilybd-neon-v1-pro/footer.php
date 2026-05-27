<?php
/**
 * ILYBD CYBER FUTURE FOOTER v9.0 - FINAL SLIM MASTER
 * Included: Slim Mobile Nav (45px), Left Icons, Swiper Fix, AJAX Like, Page Grid
 * Fix: Smart Scroll Header Hide/Show logic added.
 */
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-rgb-frame"></div>

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
            <p style="font-size: 12px; color: #8b949e; margin-bottom: 18px; line-height: 1.5; padding: 0 10px;">আমাদের প্ল্যাটফর্মের লেটেস্ট টেকনোলজি আপডেট, ফ্রি ইন্টারনেট এবং হ্যাকিং ট্রিকস সরাসরি ইমেইলে পেতে সাবস্ক্রাইব করে রাখুন।</p>
            
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
            <a href="/desclimer" class="f-link">Desclimer</a>
            <a href="/user-rights" class="f-link">User Rights</a>
            <a href="/advisement" class="f-link">Advisements</a>
            <a href="/community-guidelines" class="f-link">Community Guidelines</a>
            <a href="/safety" class="f-link">Safety & Control</a>
        </div>
        
        <div class="footer-copy-big">
            © 2026 ILYBD • Developed By 
            <a href="https://iloveyoubd.com/team" target="_blank" class="team-link-pro">iLoveYouBD Team</a>
        </div>
    </div>
</footer>

<nav class="cyber-mobile-nav">
    <div class="nav-container-inner">
        
        <div class="nav-group-side">
            <a href="<?php echo home_url(); ?>" class="nav-item">
                <span class="n-icon">🏠</span><span class="n-text">Home</span>
            </a>
            <a href="<?php echo home_url('/tv'); ?>" class="nav-item">
                <span class="n-icon">📺</span><span class="n-text">Live TV</span>
            </a>
        </div>

        <div class="nav-center-bridge">
            <div class="nav-ai-btn" onclick="jQuery('.cyber-chat-window').toggleClass('active');" title="AI Chat">
                <div class="ai-symbol">
                    <svg class="gemini-star" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: <?php echo $neon; ?>; filter: drop-shadow(0 0 8px <?php echo $neon; ?>); animation: pulseStar 1.8s infinite ease-in-out;">
                        <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                    </svg>
                </div>
                <div class="ai-glow-ring"></div>
            </div>
        </div>

        <div class="nav-group-side">
            <a href="<?php echo home_url('/forum'); ?>" class="nav-item">
                <span class="n-icon">💬</span><span class="n-text">Forum</span>
            </a>
            <a href="<?php echo home_url('/dashboard?action=profile'); ?>" class="nav-item">
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
    background: linear-gradient(90deg, #ff004c, #00ffcc, #3b82f6, #ff004c);
    background-size: 400%; animation: rgbMove 8s linear infinite;
}
@keyframes rgbMove { 0%{filter:hue-rotate(0deg);} 100%{filter:hue-rotate(360deg);} }

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
.footer-brand .brand-sub { font-size: 11px; color: #555; letter-spacing: 4px; text-transform: uppercase; margin-top: 5px; }

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
}
.n-icon { font-size: 16px; text-shadow: 0 0 5px rgba(255,255,255,0.2); }
.n-text { font-size: 11px; color: #999; font-weight: 700; text-transform: uppercase; }
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

.footer-copy-big { margin-top: 35px; font-size: 14px; color: #555; }
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
            spaceBetween: 16,
            slidesPerView: 1,
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            },
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

<?php get_template_part('template-parts/messenger-box'); ?>

<?php wp_footer(); ?>
</body>
</html>
