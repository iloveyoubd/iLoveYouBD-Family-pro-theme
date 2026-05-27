/**
 * Assets: Core Logic JS
 * Path: assets/js/core-logic.js
 * Description: Handles 4K Downloads, Ad-Gate timers, and Real-time stats updates.
 */

jQuery(document).ready(function($) {
    "use strict";

    console.log("ILYBD Prime Engine Core Logic Loaded... 🚀");

    // ১. ৪কে ডাউনলোডার সাবমিট হ্যান্ডলার
    $('#ilybd-download-form').on('submit', function(e) {
        e.preventDefault();
        
        let videoUrl = $('#ilybd-video-url').val();
        let resultArea = $('#ilybd-result-area');

        if (!videoUrl) {
            alert('বস্, ভিডিও ইউআরএল তো দিলেন না!');
            return;
        }

        // বাটন লোডিং স্টেট
        $('.ilybd-submit-btn').addClass('loading').prop('disabled', true);
        resultArea.fadeOut().html('<div class="neon-loader">সার্ভার কানেক্ট হচ্ছে...</div>').fadeIn();

        // AJAX কল - এপিআই ব্যালেন্সার হয়ে ডাটা আনবে
        $.ajax({
            url: ilybd_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'ilybd_start_download',
                video_url: videoUrl,
                nonce: ilybd_vars.nonce
            },
            success: function(response) {
                if (response.success) {
                    startAdGateTimer(response.data.download_link);
                } else {
                    resultArea.html('<p class="error-msg">' + response.data.message + '</p>');
                    $('.ilybd-submit-btn').removeClass('loading').prop('disabled', false);
                }
            },
            error: function() {
                resultArea.html('<p class="error-msg">সার্ভার ইরর! আবার চেষ্টা করুন।</p>');
                $('.ilybd-submit-btn').removeClass('loading').prop('disabled', false);
            }
        });
    });

    // ২. অ্যাড-গেট টাইমার লজিক (আপনার আর্কিটেকচার অনুযায়ী ১৫ সেকেন্ড)
    function startAdGateTimer(link) {
        let resultArea = $('#ilybd-result-area');
        let timeLeft = 15; // এডমিন প্যানেল থেকে আসা ভ্যালু অনুযায়ী হবে

        let timerInterval = setInterval(function() {
            resultArea.html(`
                <div class="timer-box">
                    <p>আপনার ৪কে ভিডিওটি প্রসেস হচ্ছে...</p>
                    <h2 class="neon-text-pink">${timeLeft}s</h2>
                    <p class="small">অ্যাডটি লোড হতে দিন, এরপর ডাউনলোড বাটন আসবে।</p>
                </div>
            `);
            
            timeLeft--;

            if (timeLeft < 0) {
                clearInterval(timerInterval);
                resultArea.html(`
                    <div class="download-box bounce-in">
                        <h3 class="neon-text-blue">ভিডিও রেডি! ✅</h3>
                        <a href="${link}" class="ilybd-btn-neon-large" target="_blank" rel="nofollow">Download 4K Now</a>
                    </div>
                `);
                $('.ilybd-submit-btn').removeClass('loading').prop('disabled', false);
            }
        }, 1000);
    }
});
