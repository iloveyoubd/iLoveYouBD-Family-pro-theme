<?php
/**
 * ILYBD Neon Pro - Cyber Author Profile Card V3 (Fully Interactive follow & likes & chats)
 * Location: template-parts/single-down-profile-card.php
 */

$auth_id = get_the_author_meta('ID');
$author_link = get_author_posts_url($auth_id);
$author_name = get_the_author();
$author_bio = get_the_author_meta('description') ?: 'আমি একজন প্রযুক্তিপ্রেমী কন্টেন্ট ক্রিয়েটর। নতুন নতুন প্রযুক্তি, প্রোগ্রামিং এবং সাইবার সিকিউরিটি নিয়ে গবেষণা করতে আমার ভালো লাগে।';
$neon = esc_attr(get_option('ilybd_main_color', '#00ff41'));

$user_data = get_userdata($auth_id);
$joining_date = 'অজানা';
if ($user_data) {
    $joining_date = date_i18n('j F, Y', strtotime($user_data->user_registered));
}

$status = ilybd_get_user_active_status($auth_id);
$tiktok_profile = get_user_meta($auth_id, 'user_tiktok', true);
$phone_contact = get_user_meta($auth_id, 'user_phone', true);

// 👥 followers and Likes Data Load
$followers = get_user_meta($auth_id, 'ilybd_author_followers', true);
$followers = is_array($followers) ? $followers : array();
$followers_count = count($followers);

$profile_likes = get_user_meta($auth_id, 'ilybd_author_profile_likes', true);
$profile_likes = is_array($profile_likes) ? $profile_likes : array();
$profile_likes_count = count($profile_likes);

$curr_uid = get_current_user_id();
$is_following = in_array($curr_uid, $followers);
$has_liked_profile = in_array(is_user_logged_in() ? $curr_uid : $_SERVER['REMOTE_ADDR'], $profile_likes);

// Count Author Posts
$posts_count = count_user_posts($auth_id);
$author_pts = (int)get_user_meta($auth_id, 'ilybd_total_points', true);
?>

<div class="ilybd-author-v3-card" id="author-card-<?php echo $auth_id; ?>">
    <div class="card-glow-borders"></div>
    <div class="card-inner-box">
        
        <div class="author-v3-flex">
            <!-- Left Side: Avatar Display -->
            <div class="v3-avatar-wrapper">
                <div class="avatar-shimmer-ring" style="border-color: <?php echo $is_following ? '#3fb950' : $neon; ?>;">
                    <a href="<?php echo esc_url($author_link); ?>" class="avatar-clicker">
                        <?php echo get_avatar($auth_id, 100, '', $author_name, array('class' => 'v3-avatar-img')); ?>
                    </a>
                    <span class="v3-indicator-dot" style="background: <?php echo esc_attr($status['dot_color']); ?>; box-shadow: 0 0 12px <?php echo esc_attr($status['dot_color']); ?>;"></span>
                </div>
                <div class="v3-online-status-text" style="color: <?php echo ($status['is_online'] ? '#00ff41' : '#8b949e'); ?>;">
                    <?php echo esc_html($status['text']); ?>
                </div>
            </div>

            <!-- Middle: Author Details and Stats Grid -->
            <div class="v3-details-wrapper">
                <div class="v3-author-title-row">
                    <h3 class="v3-author-name">
                        <a href="<?php echo esc_url($author_link); ?>"><?php echo esc_html($author_name); ?></a>
                    </h3>
                    <span class="v3-badge-verified">
                        <i class="fa-solid fa-shield-halved"></i> VERIFIED AUTHOR
                    </span>
                    <?php if ($curr_uid && $curr_uid == $auth_id) : ?>
                        <span class="v3-badge-self">আপনার প্রোফাইল</span>
                    <?php endif; ?>
                </div>

                <!-- 📆 Beautiful Joining Date Badge -->
                <div class="v3-author-meta-row" style="margin-bottom: 15px; display: inline-flex; align-items: center; gap: 8px; font-size: 11.5px; font-family: monospace; color: #8b949e;">
                    <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 255, 255, 0.03); padding: 5px 12px; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.05);">
                        <i class="fa-regular fa-calendar-alt" style="color: <?php echo esc_attr($neon); ?>;"></i> 
                        যুক্ত হয়েছেন (Joined): <span style="color: #fff; font-weight: bold;"><?php echo esc_html($joining_date); ?></span>
                    </span>
                </div>

                <div class="v3-author-bio-field">
                    <p><?php echo esc_html($author_bio); ?></p>
                </div>

                <!-- Bento Stat Grid -->
                <div class="v3-bento-grid">
                    <div class="v3-bento-item">
                        <span class="bento-lbl"><i class="fa-solid fa-bookmark"></i> টিউন সংখ্যা</span>
                        <strong class="bento-val"><?php echo $posts_count; ?></strong>
                    </div>
                    <div class="v3-bento-item interactive-stat" id="followers-container-<?php echo $auth_id; ?>">
                        <span class="bento-lbl"><i class="fa-solid fa-users"></i> অনুসারী (Followers)</span>
                        <strong class="bento-val" id="followers-number-count"><?php echo $followers_count; ?></strong>
                    </div>
                    <div class="v3-bento-item interactive-stat" id="profile-likes-container-<?php echo $auth_id; ?>">
                        <span class="bento-lbl"><i class="fa-solid fa-heart"></i> প্রোফাইল লাইক</span>
                        <strong class="bento-val text-red" id="profile-likes-number-count"><?php echo $profile_likes_count; ?></strong>
                    </div>
                    <div class="v3-bento-item">
                        <span class="bento-lbl"><i class="fa-solid fa-bolt"></i> মেম্বার এক্সপি (XP)</span>
                        <strong class="bento-val text-neon" style="color: <?php echo $neon; ?>;"><?php echo $author_pts; ?> XP</strong>
                    </div>
                </div>

                <!-- Socials phone section -->
                <?php if (!empty($tiktok_profile) || !empty($phone_contact)): ?>
                    <div class="v3-socials-list">
                        <?php if (!empty($tiktok_profile)): ?>
                            <a href="<?php echo esc_url($tiktok_profile); ?>" target="_blank" class="v3-social-btn tiktok">
                                <i class="fa-brands fa-tiktok"></i> <span>TikTok ID</span>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($phone_contact)): ?>
                            <div class="v3-social-btn phone">
                                <i class="fa-solid fa-phone"></i> <span><?php echo esc_html($phone_contact); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Interactive Control Buttons -->
            <div class="v3-controls-wrapper">
                
                <!-- Follow button -->
                <button class="v3-btn v3-btn-follow <?php echo $is_following ? 'active' : ''; ?>" 
                        id="follow-author-btn" 
                        data-id="<?php echo $auth_id; ?>"
                        <?php echo ($curr_uid == $auth_id) ? 'disabled title="আপনার নিজের প্রোফাইল ফলো করতে পারবেন না"' : ''; ?>>
                    <?php if ($is_following): ?>
                        <i class="fa-solid fa-user-check"></i> <span>আনফলো করুন</span>
                    <?php else: ?>
                        <i class="fa-solid fa-user-plus"></i> <span>ফলো করুন (Follow)</span>
                    <?php endif; ?>
                </button>

                <!-- Profile Like button -->
                <button class="v3-btn v3-btn-like <?php echo $has_liked_profile ? 'active' : ''; ?>" 
                        id="like-author-btn" 
                        data-id="<?php echo $auth_id; ?>">
                    <i class="fa-solid fa-heart-circle-bolt"></i> 
                    <span><?php echo $has_liked_profile ? 'প্রোফাইল লাইকড' : 'প্রোফাইল লাইক'; ?></span>
                </button>

                <!-- Messaging Link -->
                <?php if ($curr_uid && $curr_uid != $auth_id) : ?>
                    <button class="v3-btn v3-btn-msg" onclick="openDirectChatWithAuthor(<?php echo $auth_id; ?>, '<?php echo esc_js($author_name); ?>', '<?php echo esc_js(get_avatar_url($auth_id)); ?>')">
                        <i class="fa-solid fa-paper-plane animate-bounce"></i> <span>মেসেজ পাঠান (Message)</span>
                    </button>
                <?php elseif (!$curr_uid) : ?>
                    <a href="<?php echo wp_login_url(get_permalink()); ?>" class="v3-btn v3-btn-msg guest-trigger" title="মেসেজ করতে অনুগ্রহ করে লগইন করুন">
                        <i class="fa-solid fa-lock"></i> <span>লগইন করে মেসেজ দিন</span>
                    </a>
                <?php else : ?>
                    <span class="v3-btn v3-btn-disabled"><i class="fa-solid fa-face-smile"></i> এটি আপনার নিজের টিউন</span>
                <?php endif; ?>

                <a href="<?php echo esc_url($author_link); ?>" class="v3-btn v3-btn-profile">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> <span>প্রোফাইল ভিজিট</span>
                </a>

            </div>
        </div>

    </div>
</div>

<script>
jQuery(document).ready(function($) {
    var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
    var current_user_id = <?php echo json_encode($curr_uid); ?>;

    // --- ১. ফলো সিস্টেম ট্রিগার ---
    $('#follow-author-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var author_id = btn.data('id');

        if (!current_user_id) {
            alert('অনুগ্রহ করে ফলো করতে বাটনটি ব্যবহারের পূর্বে লগইন করুন!');
            window.location.href = "<?php echo wp_login_url(get_permalink()); ?>";
            return;
        }

        btn.prop('disabled', true).css('opacity', '0.7');

        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: {
                action: 'ilybd_follow_author',
                author_id: author_id
            },
            success: function(response) {
                btn.prop('disabled', false).css('opacity', '1');
                if (response.success) {
                    var count = response.data.count;
                    var status = response.data.status;
                    
                    $('#followers-number-count').html(count);
                    
                    if (status === 'followed') {
                        btn.addClass('active').html('<i class="fa-solid fa-user-check"></i> <span>আনফলো করুন</span>');
                    } else {
                        btn.removeClass('active').html('<i class="fa-solid fa-user-plus"></i> <span>ফলো করুন (Follow)</span>');
                    }
                    triggerMiniHeartBurst(btn);
                } else {
                    alert(response.data.message || 'অনাকাঙ্ক্ষিত ত্রুটি!');
                }
            },
            error: function() {
                btn.prop('disabled', false).css('opacity', '1');
                alert('সার্ভার রেসপন্স করতে পারছে না।');
            }
        });
    });

    // --- ২. প্রোফাইল লাইক সিস্টেম ট্রিগার ---
    $('#like-author-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var author_id = btn.data('id');

        btn.prop('disabled', true).addClass('pulse-active');

        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: {
                action: 'ilybd_like_author_profile',
                author_id: author_id
            },
            success: function(response) {
                btn.prop('disabled', false).removeClass('pulse-active');
                if (response.success) {
                    var count = response.data.count;
                    var status = response.data.status;

                    $('#profile-likes-number-count').html(count);

                    if (status === 'liked') {
                        btn.addClass('active').find('span').text('প্রোফাইল লাইকড');
                        confettiExplosion(btn);
                    } else {
                        btn.removeClass('active').find('span').text('প্রোফাইল লাইক');
                    }
                } else {
                    alert('লাইক দিতে ব্যর্থ হয়েছে!');
                }
            },
            error: function() {
                btn.prop('disabled', false).removeClass('pulse-active');
            }
        });
    });

    // --- ৩. কনফেটি ও বার্স্ট ইফেক্ট হেল্পারস ---
    function triggerMiniHeartBurst(element) {
        element.addClass('pulse-scale');
        setTimeout(function() {
            element.removeClass('pulse-scale');
        }, 300);
    }

    function confettiExplosion(el) {
        for(var i=0; i<12; i++) {
            var dot = $('<div class="mini-love-dot"><i class="fa-solid fa-heart"></i></div>');
            var pos = el.offset();
            var x = pos.left + el.width()/2 + (Math.random() - 0.5) * 40;
            var y = pos.top + (Math.random() - 0.5) * 20;

            dot.css({
                left: x + 'px',
                top: y + 'px',
                borderColor: '#ff0055'
            });

            $('body').append(dot);
            animateDot(dot);
        }
    }

    function animateDot(dot) {
        var tx = (Math.random() - 0.5) * 160;
        var ty = -Math.random() * 120 - 40;
        var rot = (Math.random() - 0.5) * 360;

        dot.animate({
            left: '+=' + tx,
            top: '+=' + ty,
            opacity: 0
        }, 900, 'swing', function() {
            dot.remove();
        });
    }
});

// --- ৪. ডিরেক্ট মেসেজ রাউটার ---
function openDirectChatWithAuthor(partnerId, name, avatar) {
    const bubble = document.getElementById('chat-trigger-bubble');
    const panel = document.getElementById('messenger-sliding-panel');
    
    if (panel) {
        panel.style.display = 'flex';
    }
    
    if (typeof openChatBoxWithUser === 'function') {
        openChatBoxWithUser(partnerId, name, avatar);
    } else {
        alert('মেসেঞ্জার সিস্টেম লোড হচ্ছে, দয়া করে ১ সেকেন্ড পরে আবার প্রেশ করুন!');
    }
}
</script>

<style>
/* 🌐 Cyber Card Elements */
.ilybd-author-v3-card {
    position: relative;
    background: #090c10;
    border-radius: 18px;
    padding: 1.5px;
    overflow: hidden;
    margin: 40px 0;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7);
}

.card-glow-borders {
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: conic-gradient(
        from 180deg, #1f2937, <?php echo $neon; ?>, #1f2937, #a855f7, #1f2937, <?php echo $neon; ?>
    );
    animation: rotateBorders 6s linear infinite;
    z-index: 1;
}

@keyframes rotateBorders {
    100% { transform: rotate(360deg); }
}

.card-inner-box {
    position: relative;
    z-index: 2;
    background: rgba(13, 17, 23, 0.96);
    border-radius: 17px;
    padding: 30px;
}

.author-v3-flex {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}

/* Avatar display */
.v3-avatar-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.avatar-shimmer-ring {
    position: relative;
    width: 104px;
    height: 104px;
    border-radius: 50%;
    padding: 3.5px;
    border: 2px solid <?php echo $neon; ?>;
    box-shadow: 0 0 15px rgba(0, 255, 65, 0.2);
}

.avatar-clicker {
    display: block;
    width: 100%; height: 100%;
    border-radius: 50%;
    overflow: hidden;
}

.v3-avatar-img {
    width: 100% !important;
    height: 100% !important;
    border-radius: 50% !important;
    object-fit: cover;
    border: 3px solid #0d1117;
}

.v3-indicator-dot {
    position: absolute;
    bottom: 4px; right: 4px;
    width: 15px; height: 15px;
    border-radius: 50%;
    border: 3px solid #0d1117;
    z-index: 5;
}

.v3-online-status-text {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Details and content */
.v3-details-wrapper {
    flex: 1;
}

.v3-author-title-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 8px;
}

.v3-author-name {
    margin: 0;
    font-size: 21px;
    font-weight: 800;
}

.v3-author-name a {
    color: #fff;
    text-decoration: none;
}

.v3-author-name a:hover {
    color: <?php echo $neon; ?>;
}

.v3-badge-verified {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: rgba(0, 255, 65, 0.08);
    border: 1px solid rgba(0, 255, 65, 0.3);
    color: <?php echo $neon; ?>;
    font-size: 9.5px;
    font-weight: 900;
    padding: 3px 10px;
    border-radius: 4px;
}

.v3-badge-self {
    background: rgba(168, 85, 247, 0.15);
    border: 1px solid rgba(168, 85, 247, 0.4);
    color: #c084fc;
    font-size: 9.5px;
    font-weight: 900;
    padding: 3px 10px;
    border-radius: 4px;
}

.v3-author-bio-field {
    background: rgba(255, 255, 255, 0.02);
    border-left: 3px solid <?php echo $neon; ?>;
    padding: 8px 15px;
    border-radius: 0 10px 10px 0;
    margin-bottom: 18px;
}

.v3-author-bio-field p {
    margin: 0;
    font-size: 14.5px;
    line-height: 1.6;
    color: #8b949e;
}

/* Bento grid values */
.v3-bento-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.v3-bento-item {
    background: rgba(22, 27, 34, 0.7);
    border: 1px solid #21262d;
    padding: 10px 14px;
    border-radius: 10px;
}

.bento-lbl {
    display: block;
    font-size: 10px;
    font-weight: bold;
    color: #8b949e;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.bento-val {
    display: block;
    font-size: 18px;
    color: #fff;
    font-weight: 800;
}

.bento-lbl i {
    color: <?php echo $neon; ?>;
    margin-right: 4px;
}

.v3-bento-item.interactive-stat {
    border-color: rgba(0, 255, 65, 0.15);
}

.text-red { color: #ff5555; }
.text-neon { text-shadow: 0 0 10px rgba(0, 255, 65, 0.2); }

/* Control panel sidebar */
.v3-controls-wrapper {
    width: 250px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255,255,255,0.04);
    padding: 15px;
    border-radius: 12px;
}

.v3-btn {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    height: 40px;
    font-size: 12.5px;
    font-weight: 800;
    text-transform: uppercase;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s cubic-bezier(0.165, 0.84, 0.44, 1);
    text-decoration: none;
    border: none;
    box-sizing: border-box;
}

.v3-btn-follow {
    background: #00ff41;
    color: #000;
}

.v3-btn-follow:hover {
    box-shadow: 0 0 15px <?php echo $neon; ?>;
}

.v3-btn-follow.active {
    background: #1f2937;
    color: #e5e7eb;
    border: 1px solid #374151;
}

.v3-btn-follow.active:hover {
    background: #ef4444;
    color: #fff;
    border-color: #ef4444;
    box-shadow: 0 0 15px rgba(239, 68, 68, 0.35);
}

.v3-btn-like {
    background: rgba(255, 85, 85, 0.08);
    border: 1.5px solid rgba(255, 85, 85, 0.3);
    color: #ff5555;
}

.v3-btn-like:hover, .v3-btn-like.active {
    background: #ff5555;
    color: #fff;
    border-color: #ff5555;
    box-shadow: 0 0 15px rgba(255, 85, 85, 0.4);
}

.v3-btn-msg {
    background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
    color: #fff;
}

.v3-btn-msg:hover {
    box-shadow: 0 0 15px rgba(168, 85, 247, 0.5);
    transform: translateY(-1.5px);
}

.v3-btn-profile {
    background: rgba(0, 240, 255, 0.08);
    border: 1px solid rgba(0, 240, 255, 0.3);
    color: #00f0ff;
}

.v3-btn-profile:hover {
    background: #00f0ff;
    color: #000;
}

.v3-btn-disabled {
    background: rgba(22, 27, 34, 0.7);
    color: #8b949e;
    cursor: default;
    border: 1px solid #21262d;
}

/* Social indicators */
.v3-socials-list {
    margin-top: 15px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.v3-social-btn {
    background: rgba(255, 255, 255, 0.02);
    border: 1.5px solid #21262d;
    color: #c9d1d9;
    font-size: 11px;
    font-weight: bold;
    padding: 6px 12px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: 0.2s;
}

.v3-social-btn.tiktok {
    border-color: rgba(254, 9, 121, 0.3);
}

.v3-social-btn.tiktok:hover {
    background: rgba(254, 9, 121, 0.1);
    color: #ff007f;
    border-color: #ff007f;
}

.v3-social-btn.phone {
    border-color: rgba(0, 255, 65, 0.2);
}

/* Animations FX */
.pulse-active {
    animation: simplePulse 0.4s infinite alternate;
}

@keyframes simplePulse {
    100% { scale: 1.05; }
}

.pulse-scale {
    transform: scale(1.1);
}

.mini-love-dot {
    position: absolute;
    width: 25px; height: 25px;
    color: #ff0055;
    font-size: 16px;
    pointer-events: none;
    z-index: 99999;
}

/* 📱 Responsive view */
@media (max-width: 850px) {
    .author-v3-flex {
        flex-direction: column;
        align-items: center;
    }
    .v3-details-wrapper {
        width: 100%;
        text-align: center;
    }
    .v3-author-title-row {
        justify-content: center;
    }
    .v3-author-bio-field {
        border-left: none;
        border-top: 2px solid <?php echo $neon; ?>;
        border-radius: 8px;
    }
    .v3-controls-wrapper {
        width: 100%;
    }
}
</style>
