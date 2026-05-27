<?php
/**
 * ILYBD Post Actions - PRO V3 (Enhanced Styling & Animations)
 * Fully functional Like, Report, and Social share grids
 */
$post_id    = get_the_ID();
$post_url   = urlencode(get_permalink());
$post_title = urlencode(get_the_title());
$like_count = get_post_meta($post_id, '_likes', true) ?: '0'; 
$neon_color = esc_attr(get_option('ilybd_main_color', '#00ff41'));
?>

<div class="ilybd-post-actions-panel" id="ilybd-like-container">
    <div class="actions-neon-glow"></div>
    <div class="actions-inner-wrap">
        
        <!-- Primary Actions: Thumbs-Up and Report Shield -->
        <div class="actions-primary-row">
            <button class="v3-action-btn like-btn" id="ilybd-like-btn" data-id="<?php echo $post_id; ?>">
                <div class="btn-shine"></div>
                <i class="fa-solid fa-thumbs-up"></i>
                <span class="v3-btn-txt">ভালো লেগেছে (Like)</span>
                <span class="v3-btn-counter" id="like-number-count"><?php echo $like_count; ?></span>
            </button>

            <button class="v3-action-btn report-btn" id="ilybd-report-btn">
                <div class="btn-shine"></div>
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span class="v3-btn-txt">রিপোর্ট করুন (Report)</span>
            </button>
        </div>

        <div class="actions-divider-rule">
            <span>বন্ধুদের সাথে শেয়ার করুন</span>
        </div>

        <!-- Social GRID Sharing -->
        <div class="actions-shares-grid">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" target="_blank" class="share-icon-circle facebook" title="Share on Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text=<?php echo $post_title . ' ' . $post_url; ?>" target="_blank" class="share-icon-circle whatsapp" title="Share on WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://t.me/share/url?url=<?php echo $post_url; ?>&text=<?php echo $post_title; ?>" target="_blank" class="share-icon-circle telegram" title="Share on Telegram">
                <i class="fab fa-telegram-plane"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?text=<?php echo $post_title; ?>&url=<?php echo $post_url; ?>" target="_blank" class="share-icon-circle twitter" title="Share on X (Twitter)">
                <i class="fa-brands fa-x-twitter"></i>
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $post_url; ?>" target="_blank" class="share-icon-circle linkedin" title="Share on LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="https://reddit.com/submit?url=<?php echo $post_url; ?>&title=<?php echo $post_title; ?>" target="_blank" class="share-icon-circle reddit" title="Share on Reddit">
                <i class="fab fa-reddit-alien"></i>
            </a>
            <button class="share-icon-circle copy-btn" id="copy-link-btn" title="Copy URL">
                <i class="fa-solid fa-link"></i>
            </button>
        </div>

    </div>
</div>

<!-- Safe Report Modal -->
<div id="ilybdReportModal" class="ilybd-post-modal">
    <div class="modal-window">
        <div class="modal-header">
            <h3>🛡️ পোস্ট রিপোর্ট করুন</h3>
            <button class="modal-close-trigger" id="closeReportBtnModal">&times;</button>
        </div>
        <div class="modal-body">
            <p>আপনার রিপোর্টটি পর্যালোচনার জন্য পাঠানো হবে। অনুগ্রহ করে রিপোর্ট করার যথার্থ কারণ লিখুন:</p>
            <textarea id="reportReasonInput" placeholder="আপনার কারণ এখানে বিস্তার করুন..."></textarea>
        </div>
        <div class="modal-footer">
            <button id="closeReportBtn" class="modal-action-btn cancel">বাতিল করুন</button>
            <button id="submitReportBtn" data-id="<?php echo $post_id; ?>" class="modal-action-btn submit">রিপোর্ট পাঠান</button>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";

    // ১. লাইক সিস্টেম
    $('#ilybd-like-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var post_id = btn.data('id');

        if(btn.hasClass('already-liked')) return; 

        btn.css('opacity', '0.6').find('.v3-btn-txt').text('অপেক্ষা করুন...');

        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: { action: 'ilybd_handle_like', post_id: post_id },
            success: function(response) {
                btn.html('<i class="fa-solid fa-circle-check"></i> <span class="v3-btn-txt">পছন্দ হয়েছে!</span> <span class="v3-btn-counter">' + response + '</span>');
                btn.css({'background': '<?php echo $neon_color; ?>', 'color': '#000', 'opacity': '1', 'borderColor': '<?php echo $neon_color; ?>'}).addClass('already-liked');
                triggerConfettiHearts(btn);
            }
        });
    });

    // ২. রিপোর্ট মডাল
    $('#ilybd-report-btn').on('click', function(e) {
        e.preventDefault();
        $('#ilybdReportModal').fadeIn(250);
    });

    $('#closeReportBtn, #closeReportBtnModal').on('click', function() {
        $('#ilybdReportModal').fadeOut(200);
    });

    // ৩. রিপোর্ট সাবমিট
    $('#submitReportBtn').on('click', function() {
        var post_id = $(this).data('id');
        var reason = $('#reportReasonInput').val();
        var btn = $(this);
        
        if(!reason.trim()) { alert('দয়া করে কারণ লিখুন!'); return; }

        btn.text('পাঠানো হচ্ছে...').prop('disabled', true);

        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: { action: 'ilybd_handle_report', post_id: post_id, reason: reason },
            success: function(response) {
                alert('আপনার রিপোর্ট সার্থকতার সাথে পাঠানো হয়েছে। ধন্যবাদ!');
                $('#ilybdReportModal').fadeOut(200);
                $('#reportReasonInput').val('');
                btn.text('রিপোর্ট পাঠান').prop('disabled', false);
            }
        });
    });

    // ৪. লিঙ্ক কপি
    $('#copy-link-btn').on('click', function(e) {
        e.preventDefault();
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert("লিঙ্ক ক্লিপবোর্ডে কপি করা হয়েছে!");
        }, function() {
            var dummy = document.createElement('input');
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            alert("লিঙ্ক কপি করা হয়েছে!");
        });
    });

    function triggerConfettiHearts(element) {
        for(var i=0; i<10; i++) {
            var dot = $('<span class="v3-pulse-heart"><i class="fa-solid fa-thumbs-up"></i></span>');
            var pos = element.offset();
            var x = pos.left + element.width()/2 + (Math.random() - 0.5) * 50;
            var y = pos.top;
            dot.css({ left: x + 'px', top: y + 'px' });
            $('body').append(dot);
            
            dot.animate({
                top: '-=80',
                left: '+=' + (Math.random() - 0.5) * 60,
                opacity: 0
            }, 800, function() {
                $(this).remove();
            });
        }
    }
});
</script>

<style>
/* 🚀 Post Actions Body Styling */
.ilybd-post-actions-panel {
    position: relative;
    background: #090c10;
    border-radius: 16px;
    padding: 1.5px;
    overflow: hidden;
    margin: 35px auto;
}

.actions-neon-glow {
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: conic-gradient(
        from 90deg, #1f2937, <?php echo $neon_color; ?>, #1f2937, <?php echo $neon_color; ?>
    );
    animation: rotateActions 8s linear infinite;
    z-index: 1;
}

@keyframes rotateActions {
    100% { transform: rotate(360deg); }
}

.actions-inner-wrap {
    position: relative;
    z-index: 2;
    background: #0d1117;
    border-radius: 15px;
    padding: 24px;
}

.actions-primary-row {
    display: flex;
    gap: 16px;
}

/* Metallic Cyber Buttons */
.v3-action-btn {
    flex: 1;
    position: relative;
    height: 52px;
    border: 1px solid #30363d;
    background: linear-gradient(180deg, #161b22 0%, #0d1117 100%);
    border-radius: 10px;
    color: #fff;
    cursor: pointer;
    font-size: 15px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    overflow: hidden;
    transition: 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.like-btn {
    border-color: rgba(0, 255, 65, 0.2);
}

.like-btn:hover {
    border-color: <?php echo $neon_color; ?>;
    background: rgba(0, 255, 65, 0.04);
    box-shadow: 0 0 15px rgba(0, 255, 65, 0.2);
    transform: translateY(-2px);
}

.like-btn:hover i {
    color: <?php echo $neon_color; ?>;
    animation: bounceThumb 0.6s infinite alternate;
}

@keyframes bounceThumb {
    100% { transform: scale(1.2) translateY(-2px); }
}

.report-btn {
    border-color: rgba(239, 68, 68, 0.2);
}

.report-btn:hover {
    border-color: #ef4444;
    background: rgba(239, 68, 68, 0.04);
    box-shadow: 0 0 15px rgba(239, 68, 68, 0.2);
    transform: translateY(-2px);
}

.report-btn:hover i {
    color: #ef4444;
    animation: shakeAlert 0.4s infinite;
}

@keyframes shakeAlert {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-8deg); }
    75% { transform: rotate(8deg); }
}

.v3-btn-counter {
    background: rgba(0, 0, 0, 0.4);
    color: <?php echo $neon_color; ?>;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 13px;
    border: 1px solid rgba(0, 255, 65, 0.15);
    font-family: monospace;
    font-weight: bold;
}

/* Shiny Hover Overlay */
.btn-shine {
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
    transform: skewX(-20deg);
}
.v3-action-btn:hover .btn-shine {
    left: 140%;
    transition: 0.8s;
}

/* Sharing Divider */
.actions-divider-rule {
    text-align: center;
    border-bottom: 1px solid #21262d;
    margin: 25px 0;
    line-height: 0.1em;
}

.actions-divider-rule span {
    background: #0d1117;
    padding: 0 15px;
    color: #8b949e;
    font-size: 12px;
    font-weight: 700;
}

/* Sharing Icons */
.actions-shares-grid {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}

.share-icon-circle {
    width: 44px; height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-decoration: none;
    font-size: 17px;
    border: 1px solid rgba(255, 255, 255, 0.04);
    cursor: pointer;
    transition: 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.share-icon-circle:hover {
    transform: translateY(-4px) scale(1.1);
    box-shadow: 0 8px 15px rgba(0,0,0,0.3);
}

.facebook { background: #1877f2; }
.whatsapp { background: #25d366; }
.telegram { background: #0088cc; }
.twitter { background: #09090b; border-color: rgba(255,255,255,0.12); }
.linkedin { background: #0a66c2; }
.reddit { background: #ff4500; }
.copy-btn { background: <?php echo $neon_color; ?>; color: #000; border-color: <?php echo $neon_color; ?>; }
.copy-btn:hover { box-shadow: 0 0 15px <?php echo $neon_color; ?>; }

/* 🛡️ Modals View styling */
.ilybd-post-modal {
    display: none;
    position: fixed;
    z-index: 999999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background: rgba(4, 6, 9, 0.85);
    backdrop-filter: blur(10px);
}

.modal-window {
    background: #0d1117;
    margin: 12% auto;
    border-radius: 16px;
    width: 90%;
    max-width: 460px;
    border: 1px solid #30363d;
    box-shadow: 0 15px 40px rgba(0,0,0,0.8);
    overflow: hidden;
    animation: scaleInModal 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes scaleInModal {
    from { transform: scale(0.9) translateY(20px); opacity: 0; }
    to { transform: scale(1) translateY(0); opacity: 1; }
}

.modal-header {
    background: #161b22;
    padding: 16px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #30363d;
}

.modal-header h3 {
    margin: 0;
    font-size: 17px;
    color: #fff;
    font-weight: 800;
}

.modal-close-trigger {
    background: none; border: none;
    color: #8b949e; font-size: 24px;
    cursor: pointer;line-height: 1;
}
.modal-close-trigger:hover { color: #fff; }

.modal-body { padding: 22px; }
.modal-body p { margin: 0 0 14px 0; color: #8b949e; font-size: 13.5px; line-height: 1.5; }

#reportReasonInput {
    width: 100%; height: 110px;
    background: #161b22;
    border: 1px solid #30363d;
    color: #fff;
    padding: 12px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 14px;
    resize: none;
    outline: none;
    box-sizing: border-box;
}

#reportReasonInput:focus {
    border-color: #ef4444;
    box-shadow: 0 0 10px rgba(239, 68, 68, 0.15);
}

.modal-footer {
    background: #161b22;
    padding: 16px 22px;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    border-top: 1px solid #30363d;
}

.modal-action-btn {
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    border: none;
}
.modal-action-btn.submit { background: #ef4444; color: #fff; }
.modal-action-btn.submit:hover { background: #dc2626; }
.modal-action-btn.cancel { background: #30363d; color: #c9d1d9; }
.modal-action-btn.cancel:hover { background: #21262d; color: #fff; }

/* Pulse animation likes helper */
.v3-pulse-heart {
    position: absolute;
    color: <?php echo $neon_color; ?>;
    font-size: 20px;
    pointer-events: none;
    z-index: 999999;
}

@media (max-width: 500px) {
    .actions-primary-row { flex-direction: column; }
    .v3-action-btn { width: 100%; }
}
</style>
