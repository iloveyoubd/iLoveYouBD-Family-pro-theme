/**
 * ILYBD Neon v1 Pro - Futuristic Comment Engine
 * Enhances standard comment sections with micro-interactions, character counts, and real-time keyboard helpers.
 */

jQuery(document).ready(function($) {
    "use strict";

    const commentTextArea = $('textarea#comment');
    if (!commentTextArea.length) return;

    // 1. Create a sleek, glowing real-time character counter
    const counterHtml = $('<div id="ilybd-comment-counter" class="text-xs mt-2 text-right opacity-60 font-mono tracking-wider transition-all duration-300">0 characters</div>');
    commentTextArea.after(counterHtml);

    commentTextArea.on('input propertychange', function() {
        const textLength = $(this).val().length;
        counterHtml.text(`${textLength} characters`);
        
        if (textLength > 1000) {
            counterHtml.addClass('text-red-500 font-bold glow-red');
        } else {
            counterHtml.removeClass('text-red-500 font-bold glow-red');
        }
    });

    // 2. Neon-Glow Focus effect on Comment Input
    commentTextArea.on('focus', function() {
        $(this).addClass('active-cyber-glow');
        counterHtml.css('opacity', '1');
    }).on('blur', function() {
        $(this).removeClass('active-cyber-glow');
        counterHtml.css('opacity', '0.6');
    });

    // 3. Command + Enter / Ctrl + Enter keyboard submit helper
    commentTextArea.on('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.keyCode === 13 || e.key === 'Enter')) {
            const form = $(this).closest('form');
            if (form.length) {
                e.preventDefault();
                form.submit();
            }
        }
    });

    // 4. Smooth reply button helper
    $('.comment-reply-link').on('click', function() {
        $('html, body').animate({
            scrollTop: $("#respond").offset().top - 100
        }, 500);
    });
});
