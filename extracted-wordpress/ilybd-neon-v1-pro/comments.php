<?php
if (post_password_required()) return;
?>

<div id="comments" class="ilybd-cyber-comments" style="margin-top: 50px; text-align: left;">

    <?php if (have_comments()) : ?>
        <!-- Section Header with Neon Counters -->
        <div class="comments-vfx-header" style="display: flex; align-items: center; justify-between; margin-bottom: 30px; border-bottom: 2px solid rgba(0, 255, 65, 0.15); padding-bottom: 12px;">
            <h3 class="comments-title" style="color: #fff; font-size: 19px; margin: 0; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 10px; font-family: 'Rajdhani', sans-serif;">
                <span style="background: rgba(0, 255, 65, 0.12); color: #00ff41; border: 1.2px solid #00ff41; padding: 2px 10px; border-radius: 20px; font-size: 13px; font-weight: bold; box-shadow: 0 0 10px rgba(0,255,65,0.2);">
                    <i class="fa-solid fa-comments"></i> FEEDBACK
                </span>
                <?php echo get_comments_number(); ?> টি কন্টেন্ট মন্তব্য ও আলোচনা
            </h3>
        </div>

        <ul class="comment-list" style="list-style: none; padding: 0; margin: 0;">
            <?php
            wp_list_comments(array(
                'callback'     => 'ilybd_custom_comment_format',
                'style'        => 'ul',
                'short_ping'   => true,
                'avatar_size'  => 48,
            ));
            ?>
        </ul>
        
        <!-- Comment Pagination -->
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation" style="margin-top: 25px; margin-bottom: 25px; display: flex; justify-content: center; gap: 8px;">
                <div class="nav-links">
                    <?php 
                    paginate_comments_links(array(
                        'prev_text' => '<i class="fa-solid fa-arrow-left"></i> আগের মন্তব্য',
                        'next_text' => 'পরের মন্তব্য <i class="fa-solid fa-arrow-right"></i>'
                    )); 
                    ?>
                </div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Gorgeous Futuristic Comment Responder Form -->
    <div class="comment-respond-outer-glow" style="border-radius: 16px; background: linear-gradient(145deg, #0d1222 0%, #060a12 100%); border: 1.5px solid rgba(0, 255, 65, 0.12); padding: 28px; margin-top: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.8); position: relative; overflow: hidden;">
        <!-- Neon decorative background pattern -->
        <div style="position: absolute; top: -150px; right: -150px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(0,255,65,0.03) 0%, transparent 75%); pointer-events: none;"></div>

        <?php
        $commenter = wp_get_current_commenter();
        $args = array(
            'title_reply'          => '<span class="response-accent-title"><i class="fa-solid fa-feather-pointed" style="color: #00ff41;"></i> আলোচনা ও মন্তব্যে অংশ নিন</span>',
            'title_reply_to'       => '<span class="response-accent-title"><i class="fa-solid fa-reply" style="color: #00ff41;"></i> %s কে উত্তর দিন</span>',
            'cancel_reply_link'    => '<i class="fa-solid fa-circle-xmark"></i> বাতিল করুন',
            'label_submit'         => 'মন্তব্য প্রকাশ করুন 🎉',
            'class_submit'         => 'ilybd-btn-cyber-submit',
            'submit_field'         => '<div class="submit-cyber-wrapper" style="margin-top: 15px; display: flex; justify-content: flex-end;">%1$s %2$s</div>',
            'comment_field'        => '<div class="input-cyber-wrapper" style="margin-bottom: 15px;">
                                        <textarea id="comment" name="comment" placeholder="গঠনমূলক আলোচনা করুন এবং স্প্যামিং এড়িয়ে চলুন... (ইউটিউব এর মতো কোডব্লক এম্বেড, সাইফার ট্যাগ ও ইমোজি সাপোর্ট করে)" rows="5" required style="width: 100%; background: #070a0f; border: 1.5px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 15px; color: #fff; outline: none; font-size: 14.5px; line-height: 1.7; transition: 0.3s; box-shadow: inset 0 2px 8px rgba(0,0,0,0.7); resize: vertical;"></textarea>
                                      </div>',
            'fields' => array(
                'author' => '<div class="flex-inputs-cyber" style="display: flex; gap: 15px; margin-bottom: 15px;">
                                <div style="flex: 1;">
                                    <input name="author" type="text" placeholder="আপনার ডাকনাম বা হ্যান্ডেল*" required style="width: 100%; background: #070a0f; border: 1.5px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 12px 16px; color: #fff; outline: none; font-size: 13.5px; transition: 0.3s; box-shadow: inset 0 2px 8px rgba(0,0,0,0.7);">
                                </div>',
                'email'  => '   <div style="flex: 1;">
                                    <input name="email" type="email" placeholder="ইমেইল এড্রেস (গোপন থাকবে)*" required style="width: 100%; background: #070a0f; border: 1.5px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 12px 16px; color: #fff; outline: none; font-size: 13.5px; transition: 0.3s; box-shadow: inset 0 2px 8px rgba(0,0,0,0.7);">
                                </div>
                             </div>',
            ),
        );
        comment_form($args);
        ?>
    </div>
</div>

<style>
/* Hierarchical Thread Styling (Dynamic & Reddit Style Connectors) */
.comment-list .children {
    list-style: none;
    margin-left: 45px;
    border-left: 2px dashed rgba(0, 255, 65, 0.15);
    padding-left: 20px;
    margin-top: 15px;
    position: relative;
    transition: border-color 0.3s;
}

.comment-list .children:hover {
    border-left-color: rgba(0, 255, 65, 0.4);
}

/* Branch L-connector curve graphic line */
.comment-list .children > li::before {
    content: "";
    position: absolute;
    left: -20px;
    top: 30px;
    width: 20px;
    height: 2px;
    border-top: 2px dashed rgba(0, 255, 65, 0.15);
}

.comment-list .children > li:hover::before {
    border-top-color: rgba(0, 255, 65, 0.4);
}

/* Comment Form Design Override */
#reply-title {
    color: #fff !important;
    font-size: 20px !important;
    font-weight: bold !important;
    margin-top: 0 !important;
    margin-bottom: 25px !important;
    display: inline-block;
    font-family: inherit;
    text-shadow: 0 0 12px rgba(255,255,255,0.05);
}

#cancel-comment-reply-link {
    background: rgba(255, 0, 60, 0.1);
    color: #ff003c;
    border: 1px solid rgba(255, 0, 60, 0.3);
    padding: 3px 10px;
    font-size: 11px;
    border-radius: 5px;
    text-decoration: none;
    margin-left: 15px;
    font-weight: 500;
    transition: 0.2s;
}

#cancel-comment-reply-link:hover {
    background: #ff003c;
    color: #fff;
    box-shadow: 0 0 10px rgba(255,0,60,0.4);
}

/* Input Hover & Focus VFX */
.input-cyber-wrapper textarea:focus,
.flex-inputs-cyber input:focus {
    border-color: #00ff41 !important;
    box-shadow: 0 0 12px rgba(0, 255, 65, 0.15), inset 0 2px 8px rgba(0,0,0,0.8) !important;
    background: #090d15 !important;
}

/* Submit Button VFX */
.ilybd-btn-cyber-submit {
    background: #00ff41 !important;
    color: #000 !important;
    border: none !important;
    padding: 12px 30px !important;
    font-size: 14px !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    font-weight: 800 !important;
    letter-spacing: 0.5px;
    box-shadow: 0 0 15px rgba(0,255,65,0.3) !important;
    transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    transform: translateY(0);
}

.ilybd-btn-cyber-submit:hover {
    background: #fff !important;
    color: #000 !important;
    box-shadow: 0 0 25px #fff !important;
    transform: translateY(-2px);
}

/* Comment Reply Link badge overriding styling */
.comment-reply-link {
    background: rgba(30, 41, 59, 0.55);
    color: #c9d1d9;
    padding: 5px 14px;
    border-radius: 6px;
    font-size: 11.5px;
    text-decoration: none;
    border: 1.2px solid rgba(255, 255, 255, 0.08);
    transition: 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-weight: 600;
}

.comment-reply-link:hover {
    background: rgba(0, 255, 65, 0.1);
    color: #00ff41;
    border-color: #00ff41;
    box-shadow: 0 0 8px rgba(0,255,65,0.2);
}

/* Pagination Links Styling */
.comment-navigation .page-numbers {
    background: #0d1117;
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: #c9d1d9;
    padding: 6px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-family: monospace;
    font-weight: bold;
    transition: 0.2s;
}

.comment-navigation .page-numbers:hover,
.comment-navigation .page-numbers.current {
    background: rgba(0, 240, 255, 0.1);
    color: #00f0ff;
    border-color: #00f0ff;
    box-shadow: 0 0 8px rgba(0,240,255,0.25);
}

/* Animation Keyframes */
@keyframes slideInNotif {
    0% { transform: translateY(40px) scale(0.85); opacity: 0; }
    50% { transform: translateY(-4px) scale(1.02); opacity: 0.95; }
    100% { transform: translateY(0) scale(1); opacity: 1; }
}

@keyframes slideOutNotif {
    0% { transform: translateY(0) scale(1); opacity: 1; }
    100% { transform: translateY(30px) scale(0.9); opacity: 0; }
}
</style>

<script>
jQuery(document).ready(function($) {
    // 1. Comment Like Button Handler
    $(document).on('click', '.comment-like-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var commentId = btn.data('comment-id');
        if (!commentId) return;

        btn.css('opacity', '0.5');

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'ilybd_like_comment',
                comment_id: commentId
            },
            success: function(response) {
                btn.css('opacity', '1');
                if (response.success) {
                    btn.find('.like-count').text(response.data.likes);
                    btn.addClass('liked-glow');
                    // Spark pulse animation
                    btn.css('color', '#00ff41');
                    // Notification helper
                    showCyberNotif("❤️ মন্তব্যটি পছন্দ হয়েছে!");
                } else {
                    showCyberNotif("⚠️ লাইক দিতে সমস্যা হয়েছে।");
                }
            },
            error: function() {
                btn.css('opacity', '1');
                showCyberNotif("⚠️ নেটওয়ার্ক ত্রুটি!");
            }
        });
    });

    // 2. Share / Copy Comment Link Handler (Zero default alerts!)
    $(document).on('click', '.comment-share-trigger', function(e) {
        e.preventDefault();
        var link = $(this).data('link');
        if (!link) return;

        navigator.clipboard.writeText(link).then(function() {
            showCyberNotif("📋 মন্তব্য লিঙ্ক ক্লিপবোর্ডে কপি করা হয়েছে!");
        }, function() {
            // fallback
            var temp = $("<input>");
            $("body").append(temp);
            temp.val(link).select();
            document.execCommand("copy");
            temp.remove();
            showCyberNotif("📋 মন্তব্য লিঙ্ক কপি করা হয়েছে!");
        });
    });

    // 3. Cyber Inline Comment Editing System (Saves raw reload waiting!)
    window.openCommentEdit = function(commentId, event) {
        if(event) event.preventDefault();
        var parentContainer = $("#comment-text-container-" + commentId);
        
        // If already editing, ignore
        if (parentContainer.find('.inline-edit-form').length) return;

        var originalText = parentContainer.html().trim();
        // Extract raw text accurately
        var cleanedText = parentContainer.clone().find('.inline-edit-form').remove().end().text().trim();

        // Create sleek editor card
        var editForm = $(`
            <div class="inline-edit-form" style="margin-top: 12px; background: #070a0f; border: 1.5px solid rgba(0,255,65,0.25); border-radius: 10px; padding: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.8); animation: slideInNotif 0.25s ease-out;">
                <h5 style="color: #fff; font-size: 13px; font-weight: bold; margin: 0 0 10px 0; display: flex; align-items: center; gap: 6px; font-family: sans-serif;">
                    <i class="fa-solid fa-pen-to-square" style="color: #00ff41;"></i> মন্তব্য এডিট করুন
                </h5>
                <textarea class="edit-textarea" style="width: 100%; height: 110px; background: #161b22; border: 1px solid rgba(0,255,65,0.15); border-radius: 8px; padding: 12px; color: #fff; font-size: 13.5px; outline: none; line-height: 1.6; resize: vertical; transition: border-color 0.2s;" placeholder="মন্তব্যটি পরিবর্তন করুন..."></textarea>
                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 10px;">
                    <button class="edit-cancel-btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #8b949e; padding: 5px 12px; border-radius: 6px; font-size: 11.5px; cursor: pointer; font-weight: bold; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)';" onmouseout="this.style.background='rgba(255,255,255,0.05)';">বাতিল</button>
                    <button class="edit-save-btn" style="background: #00ff41; border: none; color: #000; padding: 5px 15px; border-radius: 6px; font-size: 11.5px; cursor: pointer; font-weight: bold; transition: 0.2s; box-shadow: 0 0 10px rgba(0,255,65,0.25);" onmouseover="this.style.background='#fff'; this.style.boxShadow='0 0 15px #fff';" onmouseout="this.style.background='#00ff41'; this.style.boxShadow='0 0 10px rgba(0,255,65,0.25)';">সংরক্ষণ</button>
                </div>
            </div>
        `);

        // Hide original text and inject editForm
        var originalDisplay = parentContainer.children().not('.inline-edit-form').detach();
        parentContainer.append(editForm);
        // Clean textarea string
        editForm.find('.edit-textarea').val(cleanedText).focus();

        // Cancel click action
        editForm.find('.edit-cancel-btn').on('click', function() {
            editForm.remove();
            parentContainer.append(originalDisplay);
        });

        // Save click action
        editForm.find('.edit-save-btn').on('click', function() {
            var updatedContent = editForm.find('.edit-textarea').val().trim();
            if(!updatedContent) {
                showCyberNotif("⚠️ মন্তব্যটি খালি রাখা সম্ভব নয়!");
                return;
            }

            editForm.css('opacity', '0.6');

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'ilybd_edit_comment',
                    comment_id: commentId,
                    comment_content: updatedContent
                },
                success: function(response) {
                    if (response.success) {
                        editForm.remove();
                        parentContainer.html(response.data.content);
                        showCyberNotif("✅ মন্তব্যটি সফলভাবে ড্রাফট থেকে আপডেট হয়েছে!");
                    } else {
                        editForm.css('opacity', '1');
                        showCyberNotif("⚠️ " + (response.data.message || "সংরক্ষণ করতে ব্যর্থ হয়েছে।"));
                    }
                },
                error: function() {
                    editForm.css('opacity', '1');
                    showCyberNotif("⚠️ নেটওয়ার্ক সংযোগ বিঘ্নিত হয়েছে!");
                }
            });
        });
    };

    // 4. Cyber Notification popup box
    function showCyberNotif(msg) {
        var notiBox = $('#cyber-comment-noti-box');
        if (!notiBox.length) {
            $('body').append('<div id="cyber-comment-noti-box" style="position:fixed; bottom:30px; right:30px; z-index:99999; display: flex; flex-direction: column; gap: 10px;"></div>');
            notiBox = $('#cyber-comment-noti-box');
        }

        var notiItem = $(`
            <div style="background: rgba(13, 17, 23, 0.96); backdrop-filter: blur(10px); border: 1.5px solid #00ff41; color: #fff; padding: 12px 22px; border-radius: 10px; font-weight: 600; font-size: 13px; font-family: sans-serif; box-shadow: 0 10px 30px rgba(0,255,65,0.25); display: flex; align-items: center; gap: 8px; animation: slideInNotif 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;">
                <i class="fa-solid fa-circle-check" style="color: #00ff41; font-size: 16px;"></i> \${msg}
            </div>
        `);

        notiBox.append(notiItem);
        setTimeout(function() {
            notiItem.css('animation', 'slideOutNotif 0.35s ease forwards');
            setTimeout(function() {
                notiItem.remove();
            }, 400);
        }, 4500);
    }
});
</script>
