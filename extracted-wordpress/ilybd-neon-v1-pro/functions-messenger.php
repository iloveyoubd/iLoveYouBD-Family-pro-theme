<?php
/**
 * --- REVOLUTIONARY CYBER MESSENGER & STORIES SYSTEM ---
 * Fully custom modern chat engine + active stories row exactly like Facebook Messenger.
 */

if (!defined('ABSPATH')) exit;

/**
 * Clean & Prune old stories (Active for 24 hours)
 */
function ilybd_get_active_stories() {
    $stories = get_option('ilybd_cyber_stories', []);
    if (!is_array($stories)) $stories = [];
    
    $changed = false;
    $now = time();
    $active_stories = [];
    
    foreach ($stories as $story) {
        // Keeps stories for 24 hours
        if (($now - (int)$story['created_at']) < 86400) {
            $active_stories[] = $story;
        } else {
            // Deleted / Expired story - if it has custom file upload, we can clean up if desired
            $changed = true;
        }
    }
    
    if ($changed) {
        update_option('ilybd_cyber_stories', $active_stories);
    }
    
    return $active_stories;
}

/**
 * Get active threads / inbox list for a logged in user
 */
function ilybd_get_user_chat_threads($user_id) {
    $threads = get_user_meta($user_id, 'ilybd_chat_inbox_threads', true);
    if (!is_array($threads)) {
        $threads = [];
    }
    
    // Enrich with latest message to show in inbox
    $enriched = [];
    foreach ($threads as $partner_id => $timestamp) {
        $partner = get_userdata($partner_id);
        if (!$partner) continue;
        
        $u1 = min($user_id, $partner_id);
        $u2 = max($user_id, $partner_id);
        $messages = get_option("ilybd_chat_messages_{$u1}_{$u2}", []);
        $latest_msg = '';
        $latest_sender = 0;
        $is_unread = false;
        
        if (!empty($messages)) {
            $last = end($messages);
            $latest_msg = $last['message'];
            $latest_sender = $last['sender_id'];
            if ($last['sender_id'] != $user_id && empty($last['read'])) {
                $is_unread = true;
            }
        }
        
        $enriched[] = [
            'partner_id' => $partner_id,
            'name'       => $partner->display_name,
            'avatar'     => get_avatar_url($partner_id, ['size' => 64]),
            'latest'     => $latest_msg,
            'sender'     => $latest_sender,
            'unread'     => $is_unread,
            'time'       => $timestamp
        ];
    }
    
    // Sort threads by latest activity timestamp descending
    usort($enriched, function($a, $b) {
        return $b['time'] - $a['time'];
    });
    
    return $enriched;
}

/**
 * =====================================
 * AJAX ACTIONS: STORIES SYSTEM
 * =====================================
 */

// 1. UPLOAD STORY
add_action('wp_ajax_ilybd_upload_story', 'ilybd_ajax_upload_story');
function ilybd_ajax_upload_story() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'অনুমতি নেই! দয়া করে লগইন করুন।']);
    }
    
    $user_id = get_current_user_id();
    $media_type = sanitize_text_field($_POST['media_type']); // text, image, video, gif
    $caption    = sanitize_textarea_field($_POST['caption']);
    $media_url  = '';
    $background = sanitize_text_field($_POST['bg_gradient'] ?? '');
    
    // Handle File Upload if selected
    if (!empty($_FILES['story_file']) && $_FILES['story_file']['error'] == 0) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $attachment_id = media_handle_upload('story_file', 0);
        if (!is_wp_error($attachment_id)) {
            $media_url = wp_get_attachment_url($attachment_id);
        } else {
            wp_send_json_error(['message' => 'ফাইল আপলোড ব্যর্থ হয়েছে! error: ' . $attachment_id->get_error_message()]);
        }
    } else if (!empty($_POST['media_url'])) {
        $media_url = esc_url_raw($_POST['media_url']);
    }
    
    if ($media_type !== 'text' && empty($media_url)) {
        wp_send_json_error(['message' => 'দয়া করে একটি ফাইল আপলোড করুন অথবা মিডিয়া লিঙ্ক দিন।']);
    }
    
    $stories = get_option('ilybd_cyber_stories', []);
    if (!is_array($stories)) $stories = [];
    
    $new_story = [
        'id'          => uniqid('story_'),
        'user_id'     => $user_id,
        'media_type'  => $media_type,
        'media_url'   => $media_url,
        'bg_gradient' => $background,
        'caption'     => $caption,
        'created_at'  => time(),
        'views'       => [],
        'reacts'      => [],
        'comments'    => []
    ];
    
    $stories[] = $new_story;
    update_option('ilybd_cyber_stories', $stories);
    
    // Reward uploading user
    if (function_exists('ilybd_update_user_economy')) {
        ilybd_update_user_economy($user_id, 5, 0.20, '📝 আপনার স্টোরি সফলভাবে আপলোড হয়েছে! আপনি লাভ করেছেন ৫ XP এবং ৳০.২০ বোনাস।');
    }
    
    wp_send_json_success(['message' => 'আপনার স্টোরি সফলভাবে পাবলিশ হয়েছে!']);
}

// 2. VIEW STORY (Add user view & award points)
add_action('wp_ajax_ilybd_view_story', 'ilybd_ajax_view_story');
function ilybd_ajax_view_story() {
    if (!is_user_logged_in()) {
        wp_send_json_error();
    }
    
    $user_id = get_current_user_id();
    $story_id = sanitize_text_field($_POST['story_id']);
    
    $stories = get_option('ilybd_cyber_stories', []);
    if (!is_array($stories)) $stories = [];
    
    $found = false;
    foreach ($stories as &$story) {
        if ($story['id'] === $story_id) {
            $found = true;
            if (!in_array($user_id, $story['views'])) {
                $story['views'][] = $user_id;
                
                // Award points to creator & viewer!
                $creator_id = $story['user_id'];
                if (function_exists('ilybd_update_user_economy')) {
                    if ($creator_id != $user_id) {
                        ilybd_update_user_economy($user_id, 1, 0, '👀 নতুন কারও ডাইনামিক স্টোরি দেখার জন্য ১ XP পেয়েছেন!');
                        ilybd_update_user_economy($creator_id, 1, 0.05, '🔥 আপনার স্টোরিতে নতুন একটি ভিউ আসার জন্য ১ XP এবং ৳০.০৫ পেয়েছেন!');
                    }
                }
            }
            break;
        }
    }
    
    if ($found) {
        update_option('ilybd_cyber_stories', $stories);
        wp_send_json_success();
    }
    wp_send_json_error();
}

// 3. REACT STORY (Heart, Like etc.)
add_action('wp_ajax_ilybd_react_story', 'ilybd_ajax_react_story');
function ilybd_ajax_react_story() {
    if (!is_user_logged_in()) wp_send_json_error();
    
    $user_id = get_current_user_id();
    $story_id = sanitize_text_field($_POST['story_id']);
    $react_type = sanitize_text_field($_POST['react_type']); // heart, like, care, haha, wow, sad, angry
    
    $stories = get_option('ilybd_cyber_stories', []);
    if (!is_array($stories)) $stories = [];
    
    $reacted_user_name = wp_get_current_user()->display_name;
    
    $found = false;
    foreach ($stories as &$story) {
        if ($story['id'] === $story_id) {
            $found = true;
            
            // Remove previous react from this user if any
            $reacts = is_array($story['reacts']) ? $story['reacts'] : [];
            $new_reacts = [];
            foreach ($reacts as $r) {
                if ($r['user_id'] != $user_id) {
                    $new_reacts[] = $r;
                }
            }
            
            // Add new react
            $new_reacts[] = [
                'user_id' => $user_id,
                'type'    => $react_type
            ];
            
            $story['reacts'] = $new_reacts;
            $creator_id = $story['user_id'];
            
            // Award economy XP / cash
            if (function_exists('ilybd_update_user_economy') && $creator_id != $user_id) {
                ilybd_update_user_economy($user_id, 1, 0, '👍 স্টোরিতে রিঅ্যাকশন সাবমিট করার জন্য ১ XP অর্জন করেছেন!');
                ilybd_update_user_economy($creator_id, 1, 0.05, sprintf('🎉 আপনার স্টোরিতে %s রিঅ্যাক্ট করেছেন! ১ XP এবং ৳০.০৫ টাকা অ্যাড হয়েছে।', $reacted_user_name));
            }
            break;
        }
    }
    
    if ($found) {
        update_option('ilybd_cyber_stories', $stories);
        wp_send_json_success(['reacts' => $stories]);
    }
    wp_send_json_error();
}

// 4. COMMENT ON STORY
add_action('wp_ajax_ilybd_comment_story', 'ilybd_ajax_comment_story');
function ilybd_ajax_comment_story() {
    if (!is_user_logged_in()) wp_send_json_error();
    
    $user_id = get_current_user_id();
    $story_id = sanitize_text_field($_POST['story_id']);
    $comment_text = sanitize_text_field($_POST['comment_text']);
    
    if (empty($comment_text)) {
        wp_send_json_error(['message' => 'মন্তব্য খালি হতে পারে না!']);
    }
    
    $stories = get_option('ilybd_cyber_stories', []);
    if (!is_array($stories)) $stories = [];
    
    $commenter_name = wp_get_current_user()->display_name;
    $comment_id = uniqid('comm_');
    
    $found = false;
    $updated_comments = [];
    foreach ($stories as &$story) {
        if ($story['id'] === $story_id) {
            $found = true;
            
            $comments = is_array($story['comments']) ? $story['comments'] : [];
            $new_comment = [
                'id'         => $comment_id,
                'user_id'    => $user_id,
                'user_name'  => $commenter_name,
                'user_avatar'=> get_avatar_url($user_id, ['size' => 32]),
                'text'       => $comment_text,
                'created_at' => time()
            ];
            
            $comments[] = $new_comment;
            $story['comments'] = $comments;
            $updated_comments = $comments;
            
            $creator_id = $story['user_id'];
            
            // XP updates
            if (function_exists('ilybd_update_user_economy') && $creator_id != $user_id) {
                ilybd_update_user_economy($user_id, 2, 0.05, '💬 অন্য কারও স্টোরিতে সুন্দর কমেন্ট করার জন্য ২ XP এবং ৳০.০৫ টাকা বোনাস পেয়েছেন!');
                ilybd_update_user_economy($creator_id, 1, 0.10, sprintf('🗣️ আপনার স্টোরিতে %s নতুন মন্তব্য জমা দিয়েছেন! ১ XP এবং ৳০.১০ টাকা প্লাস হয়েছে।', $commenter_name));
            }
            break;
        }
    }
    
    if ($found) {
        update_option('ilybd_cyber_stories', $stories);
        wp_send_json_success(['comments' => $updated_comments]);
    }
    wp_send_json_error();
}


/**
 * =====================================
 * AJAX ACTIONS: MESSENGER / CHAT SYSTEM
 * =====================================
 */

// 1. GET MESSAGES IN THREAD
add_action('wp_ajax_ilybd_get_messages', 'ilybd_ajax_get_messages');
function ilybd_ajax_get_messages() {
    if (!is_user_logged_in()) wp_send_json_error();
    
    $user_id = get_current_user_id();
    $partner_id = intval($_POST['partner_id']);
    
    if (!$partner_id || $partner_id === $user_id) {
        wp_send_json_error(['message' => 'অবৈধ ইউজার আইডি।']);
    }
    
    $u1 = min($user_id, $partner_id);
    $u2 = max($user_id, $partner_id);
    
    $messages = get_option("ilybd_chat_messages_{$u1}_{$u2}", []);
    if (!is_array($messages)) $messages = [];
    
    // Mark incoming messages as read!
    $changed = false;
    foreach ($messages as &$msg) {
        if ($msg['sender_id'] == $partner_id && empty($msg['read'])) {
            $msg['read'] = 1;
            $changed = true;
        }
    }
    if ($changed) {
        update_option("ilybd_chat_messages_{$u1}_{$u2}", $messages);
    }
    
    // Format response nicely with date-times
    $response = [];
    foreach ($messages as $m) {
        $response[] = [
            'sender_id' => intval($m['sender_id']),
            'message'   => esc_html($m['message']),
            'time'      => date('h:i A', $m['timestamp']),
            'read'      => !empty($m['read'])
        ];
    }
    
    wp_send_json_success([
        'messages' => $response,
        'partner'  => [
            'id'     => $partner_id,
            'name'   => get_userdata($partner_id)->display_name,
            'avatar' => get_avatar_url($partner_id, ['size' => 64])
        ]
    ]);
}

// 2. SEND CHAT MESSAGE
add_action('wp_ajax_ilybd_send_message', 'ilybd_ajax_send_message');
function ilybd_ajax_send_message() {
    if (!is_user_logged_in()) wp_send_json_error();
    
    $user_id = get_current_user_id();
    $partner_id = intval($_POST['partner_id']);
    $message_text = sanitize_textarea_field($_POST['message']);
    
    if (!$partner_id || empty($message_text) || $partner_id === $user_id) {
        wp_send_json_error(['message' => 'মেসেজ বডি বা ইউজার আইডি সম্পন্ন নয়!']);
    }
    
    $u1 = min($user_id, $partner_id);
    $u2 = max($user_id, $partner_id);
    
    $messages = get_option("ilybd_chat_messages_{$u1}_{$u2}", []);
    if (!is_array($messages)) $messages = [];
    
    $new_msg = [
        'id'         => uniqid('msg_'),
        'sender_id'  => $user_id,
        'message'    => $message_text,
        'timestamp'  => time(),
        'read'       => 0
    ];
    
    // Limit message archive to 150 entries to guarantee performance and clean database
    if (count($messages) > 150) {
        array_shift($messages);
    }
    $messages[] = $new_msg;
    update_option("ilybd_chat_messages_{$u1}_{$u2}", $messages);
    
    // Update active threads lists for both users
    $now = time();
    $u1_threads = get_user_meta($user_id, 'ilybd_chat_inbox_threads', true);
    if (!is_array($u1_threads)) $u1_threads = [];
    $u1_threads[$partner_id] = $now;
    update_user_meta($user_id, 'ilybd_chat_inbox_threads', $u1_threads);
    
    $u2_threads = get_user_meta($partner_id, 'ilybd_chat_inbox_threads', true);
    if (!is_array($u2_threads)) $u2_threads = [];
    $u2_threads[$user_id] = $now;
    update_user_meta($partner_id, 'ilybd_chat_inbox_threads', $u2_threads);
    
    // Add User Notification & System Economy XP points
    $sender_name = wp_get_current_user()->display_name;
    if (function_exists('ilybd_add_user_notification')) {
        // Prune text so it doesn't leak super long strings in alerts
        $notif_text = mb_strlen($message_text) > 30 ? mb_substr($message_text, 0, 30) . '...' : $message_text;
        ilybd_add_user_notification($partner_id, sprintf('💬 <b>%s</b> আপনাকে মেসেজ পাঠিয়েছেন: "%s"', $sender_name, $notif_text));
    }
    
    // Anti-spam points regulation: Maximum 1 reward per 15 seconds to prevent point mining
    $last_awarded = (int) get_user_meta($user_id, 'ilybd_last_chat_award', true);
    if (time() - $last_awarded > 15) {
        if (function_exists('ilybd_update_user_economy')) {
            ilybd_update_user_economy($user_id, 1, 0.01, '💬 একটি সফল চ্যাট মেসেজ প্রেরণের জন্য ১ XP প্লাস হয়েছে!');
        }
        update_user_meta($user_id, 'ilybd_last_chat_award', time());
    }
    
    wp_send_json_success([
        'message' => $message_text,
        'time'    => date('h:i A', $now)
    ]);
}

// 3. SEARCH USERS TO DIRECT MESSAGE
add_action('wp_ajax_ilybd_search_users', 'ilybd_ajax_search_users');
function ilybd_ajax_search_users() {
    if (!is_user_logged_in()) wp_send_json_error();
    
    $search = sanitize_text_field($_POST['search']);
    $user_id = get_current_user_id();
    
    if (empty($search)) {
        wp_send_json_success([]);
    }
    
    $users = get_users([
        'search'         => '*' . $search . '*',
        'search_columns' => ['display_name', 'user_email', 'user_nicename'],
        'number'         => 10,
        'exclude'        => [$user_id]
    ]);
    
    $response = [];
    foreach ($users as $u) {
        $response[] = [
            'id'     => $u->ID,
            'name'   => $u->display_name,
            'avatar' => get_avatar_url($u->ID, ['size' => 48])
        ];
    }
    
    wp_send_json_success(['users' => $response]);
}
