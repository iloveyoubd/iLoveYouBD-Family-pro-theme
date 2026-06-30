/**
 * ILYBD Neon v1 Pro - Core Logic & VFX (Updated)
 * Full Social Engine: Like, Report, Mention, & Advanced Commenting
 */

jQuery(document).ready(function($) {
    "use strict";

    // 🎨 Neon Config
    const neonPrimary = (typeof ilybd_vfx !== 'undefined' && ilybd_vfx.neon_color) 
        ? ilybd_vfx.neon_color 
        : '#00ff41';

    // =========================
    // 📌 1. QR CODE (Desktop + Mobile)
    // =========================
    $('.qr-trigger').on({
        'mouseenter': function() { $(this).find('.qr-code-popup').stop(true, true).fadeIn(200); },
        'mouseleave': function() { $(this).find('.qr-code-popup').stop(true, true).fadeOut(200); },
        'click': function(e) { e.preventDefault(); $(this).find('.qr-code-popup').stop(true, true).fadeToggle(200); }
    });

    // =========================
    // ❤️ 2. POST & COMMENT LIKE SYSTEM (FIXED)
    // =========================
    $(document).on('click', '.ilybd-like-btn, .comment-like-btn', function(e) {
        e.preventDefault();
        let btn = $(this);
        let post_id = btn.data('id') || btn.data('post-id');

        if (!post_id) return;

        btn.css('opacity', '0.5'); // Loading effect

        $.post(ilybd_vfx.ajax_url, {
            action: 'ilybd_handle_like', // functions.php এর সাথে মিল রেখে ফিক্সড
            post_id: post_id
        }, function(response) {
            if (response) {
                // বাটনের ভেতর থাকা কাউন্ট আপডেট করবে
                btn.find('.like-count, span').text(response);
                btn.addClass('active-glow').css({'color': neonPrimary, 'opacity': '1'});
                showNotification("❤️ পছন্দ হয়েছে!");
            }
        });
    });

    // =========================
    // 🚩 3. REPORT SYSTEM
    // =========================
    $(document).on('click', '.report-btn', function(e) {
        e.preventDefault();
        let post_id = $(this).data('id');
        let reason = prompt("রিপোর্ট করার কারণ লিখুন:");

        if (reason) {
            $.post(ilybd_vfx.ajax_url, {
                action: 'ilybd_handle_report',
                post_id: post_id,
                reason: reason
            }, function(res) {
                if(res === 'success') showNotification("🚩 রিপোর্ট পাঠানো হয়েছে");
            });
        }
    });

    // =========================
    // 💬 4. MENTION SYSTEM (@USER)
    // =========================
    if ($.isFunction($.fn.atwho)) {
        $('textarea#comment').atwho({
            at: "@",
            data: [], // এখানে PHP থেকে ইউজার লিস্ট পাস করা যায়
            limit: 5,
            displayTpl: '<li>${display_name}</li>',
            insertTpl: '@${user_nicename}'
        });
    }

    // =========================
    // ⚡ 5. VFX & ANIMATION ENGINE
    // =========================
    const observerOptions = { threshold: 0.15 };
    const vfxObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('combat-border', 'chase-effect');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    $('.ilybd-pro-card, .cyber-post-item').each(function() {
        vfxObserver.observe(this);
    });

    // =========================
    // 🔊 6. NOTIFICATION SYSTEM
    // =========================
    function showNotification(msg, link) {
        let box = $('#noti-box');
        if (!box.length) {
            $('body').append('<div id="noti-box" style="position:fixed; bottom:20px; right:20px; z-index:9999;"></div>');
            box = $('#noti-box');
        }

        let cursorStyle = link ? 'cursor:pointer;' : '';
        let item = $(`
            <div class="noti-item" style="background:#090e1a; color:#00ff99; padding:12px 20px; margin-top:10px; border:1px solid #00f0ff; border-radius:8px; box-shadow:0 0 15px rgba(0,240,255,0.3); font-size:13px; font-weight:bold; animation: slideIn 0.3s ease-out; transition: transform 0.2s; ${cursorStyle}" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                🔔 ${msg}
                ${link ? '<div style="font-size:11px; color:#00f0ff; margin-top:5px; text-decoration:underline; font-weight: normal;"><i class="fa-solid fa-arrow-up-right-from-square"></i> নির্দিষ্ট পেজে যেতে ক্লিক করুন (View Content)</div>' : ''}
            </div>
        `);

        if (link) {
            item.on('click', function() {
                window.location.href = link;
            });
        }

        box.append(item);
        setTimeout(() => { item.fadeOut(500, function() { $(this).remove(); }); }, 6000);
    }

    // =========================
    // 🔁 7. REALTIME POLLING (NOTIFICATIONS)
    // =========================
    let lastNotiCount = 0;
    function checkNotifications() {
        if (typeof ilybd_vfx === 'undefined') return;
        $.post(ilybd_vfx.ajax_url, { action: 'ilybd_get_notifications' }, function(res) {
            if (res.success && res.data.count > lastNotiCount) {
                res.data.items.forEach(n => showNotification(n.text || n.message, n.link));
                if (typeof playNotiSound === 'function') {
                    playNotiSound();
                }
                lastNotiCount = res.data.count;
            }
        });
    }
    setInterval(checkNotifications, 10000); // 10 সেকেন্ড পর পর চেক করবে

    console.log("%c ILYBD Cyber Engine: Operational 🚀", "color:" + neonPrimary + "; font-weight:bold;");
});
