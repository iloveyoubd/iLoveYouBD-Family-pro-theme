jQuery(document).ready(function($) {
    
    // লাইক বাটন ক্লিক লজিক
    $('#ilybd-like-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var post_id = btn.data('id');

        // ক্লিক করার পর বাটন ডিজেবল করা
        btn.prop('disabled', true).css('opacity', '0.6');

        $.ajax({
            url: ilybd_ajax_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'ilybd_handle_like',
                post_id: post_id
            },
            success: function(response) {
                if(response) {
                    $('#like-number').text(response);
                    btn.css({'background': '#00ff41', 'color': '#000'}); // Neon Green Success
                    console.log('Liked Successfully');
                }
            }
        });
    });

    // রিপোর্ট বাটন লজিক
    window.openReportModal = function() { $('#reportModal').fadeIn(); }
    window.closeReportModal = function() { $('#reportModal').fadeOut(); }

    $('#submitReport').on('click', function() {
        var post_id = $(this).data('id');
        var reason = $('#reportReason').val();
        
        if(!reason.trim()) { alert('কারণ লিখুন!'); return; }

        $.ajax({
            url: ilybd_ajax_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'ilybd_handle_report',
                post_id: post_id,
                reason: reason
            },
            success: function(response) {
                alert('রিপোর্ট সফলভাবে পাঠানো হয়েছে!');
                closeReportModal();
            }
        });
    });
});
