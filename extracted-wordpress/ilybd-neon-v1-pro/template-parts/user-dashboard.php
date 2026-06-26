<?php
/**
 * Master ILYBD Cyber User Dashboard - Highly Professional Edition
 * Full Posting + Category Select + Withdrawal Request Gateway (Bkash / Nagad)
 */
if (!is_user_logged_in()) {
    echo '
    <div style="background:#0d1117; max-width:550px; margin:40px auto; border:1px solid #ff3e3e; border-radius:12px; padding:30px; text-align:center; color:#fff; box-shadow:0 0 20px rgba(255,62,62,0.15);">
        <h2 style="color:#ff3e3e; margin-top:0;">🔒 Access Restrained</h2>
        <p style="color:#8b949e; line-height:1.6;">দয়া করে আপনার অ্যাকাউন্টে লগইন করুন আপনার ড্যাশবোর্ড ও ওয়ালেট এক্সেস করতে।</p>
        <a href="' . wp_login_url(get_permalink()) . '" style="display:inline-block; margin-top:15px; padding:12px 25px; background:#ff3e3e; color:#fff; text-decoration:none; font-weight:bold; border-radius:6px; box-shadow:0 0 10px rgba(255,62,62,0.3);">Login Portal</a>
    </div>';
    return;
}

$u_id = get_current_user_id();
$user = wp_get_current_user();

// ১.১ অপ্টিমাইজড মেটা ডাটা লোডিং (Backwards compatible fallback / SQL synchronizer)
global $wpdb;
$table_wallet = $wpdb->prefix . 'ilybd_wallet';
$db_wallet = null;
if ($wpdb->get_var("SHOW TABLES LIKE '$table_wallet'") == $table_wallet) {
    $db_wallet = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_wallet WHERE user_id = %d", $u_id));
}

if (function_exists('ilybd_ensure_user_wallet_initialized')) {
    $db_wallet = ilybd_ensure_user_wallet_initialized($u_id);
}

if ($db_wallet) {
    $balance = (float) $db_wallet->balance;
    $points  = (int) $db_wallet->points;
    $u_level = (int) $db_wallet->user_level;
    
    update_user_meta($u_id, 'user_balance', $balance);
    update_user_meta($u_id, 'ilybd_total_points', $points);
} else {
    $points  = (int) get_user_meta($u_id, 'ilybd_total_points', true);
    if (!$points) {
        $points = (int) get_user_meta($u_id, 'ilybd_points', true);
    }
    if (!$points) {
        $points = (int) get_user_meta($u_id, 'user_points', true);
    }
    $balance = get_user_meta($u_id, 'user_balance', true);
    if ($balance === '') {
        $balance = (float)($points * 0.01);
        update_user_meta($u_id, 'user_balance', $balance);
    } else {
        $balance = (float) $balance;
    }
    
    // Register the missing wallet entry so SQL commands on single post view succeed!
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_wallet'") == $table_wallet) {
        $wpdb->insert($table_wallet, array(
            'user_id' => $u_id,
            'points' => $points,
            'balance' => $balance,
            'user_level' => floor($points / 500) + 1,
            'total_earned' => $balance
        ));
    }
}

$tier = ilybd_get_user_tier($u_id);

// ১.২ নোটিফিকেশন এগ্রেশন লোডার
$notifications = get_user_meta($u_id, 'notifications', true);
$notifications = is_array($notifications) ? array_reverse($notifications) : [];
$unread_count = 0;
foreach ($notifications as $n) {
    if (!isset($n['read']) || $n['read'] == 0) {
        $unread_count++;
    }
}

// ১.৩ উইথড্রয়ালস হিস্টোরি এগ্রেগেটর
$withdrawals = get_user_meta($u_id, 'ilybd_withdrawals', true);
$withdrawals = is_array($withdrawals) ? $withdrawals : [];

$message_box = '';

/* =========================================
   ২. পোস্ট ক্রিয়েশন ও এডিটিং হ্যান্ডলার
   ========================================= */
if (isset($_POST['cyber_frontend_post'])) {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'cyber_dashboard_post_nonce')) {
        $message_box = '<div class="alert error">❌ Security Verification failed. Try again.</div>';
    } else {
        $title    = sanitize_text_field($_POST['post_title']);
        $content  = wp_kses_post($_POST['post_content']);
        $category = intval($_POST['post_cat']);
        $post_id  = isset($_POST['edit_post_id']) ? intval($_POST['edit_post_id']) : 0;
        
        $requested_status = sanitize_text_field($_POST['post_status']);
        $allowed_status = ['draft', 'pending'];
        if (current_user_can('publish_posts')) {
            $allowed_status[] = 'publish';
        }
        $final_status = in_array($requested_status, $allowed_status) ? $requested_status : 'pending';
        
        if (empty($title) || empty($content)) {
            $message_box = '<div class="alert error">❌ দয়া করে টাইটেল এবং মূল কন্টেন্ট সঠিকভাবে পূরণ করুন।</div>';
        } else {
            if ($post_id > 0) {
                // পোস্ট এডিট রিকোয়েস্ট (নিরাপত্তা চেক - শুধু অথরই এডিট করতে পারে)
                $existing_post = get_post($post_id);
                if ($existing_post && $existing_post->post_author == $u_id) {
                    $update_post = [
                        'ID'           => $post_id,
                        'post_title'   => $title,
                        'post_content' => $content,
                        'post_status'  => $final_status,
                        'post_category'=> [$category]
                    ];
                    wp_update_post($update_post);
                    
                    // Handle featured image upload
                    if (!empty($_FILES['featured_image']['name'])) {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        require_once(ABSPATH . 'wp-admin/includes/file.php');
                        require_once(ABSPATH . 'wp-admin/includes/media.php');
                        $attachment_id = media_handle_upload('featured_image', $post_id);
                        if (!is_wp_error($attachment_id)) {
                            set_post_thumbnail($post_id, $attachment_id);
                        }
                    }
                    
                    $message_box = '<div class="alert success">✅ আপনার পোস্টটির এডিট সফলভাবে আপডেট হয়েছে!</div>';
                } else {
                    $message_box = '<div class="alert error">❌ আপনার এই পোস্টটি এডিট করার অনুমতি নেই।</div>';
                }
            } else {
                // নতুন পোস্ট মেকার
                $new_post = [
                    'post_title'    => $title,
                    'post_content'  => $content,
                    'post_status'   => $final_status,
                    'post_author'   => $u_id,
                    'post_category' => [$category]
                ];
                $inserted_id = wp_insert_post($new_post);
                if ($inserted_id) {
                    // Handle featured image upload
                    if (!empty($_FILES['featured_image']['name'])) {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        require_once(ABSPATH . 'wp-admin/includes/file.php');
                        require_once(ABSPATH . 'wp-admin/includes/media.php');
                        $attachment_id = media_handle_upload('featured_image', $inserted_id);
                        if (!is_wp_error($attachment_id)) {
                            set_post_thumbnail($inserted_id, $attachment_id);
                        }
                    }
                    
                    // নোটিফিকেশন পাঠান
                    if ($final_status === 'publish') {
                        ilybd_add_user_notification($u_id, "🚀 অভিনন্দন! আপনার নতুন পোস্টটি সফলভাবে সরাসরি সাইটে লাইভ করা হয়েছে।");
                    } elseif ($final_status === 'draft') {
                        ilybd_add_user_notification($u_id, "📁 আপনার পোস্টটি সফলভাবে ব্যক্তিগত ড্রাফট লাইব্রেরিতে সেভ করা হয়েছে।");
                    } else {
                        ilybd_add_user_notification($u_id, "📝 নতুন পোস্ট জমা দেওয়া হয়েছে! এডমিন মেম্বারদের রিভিউ শেষে এটি পাবলিশ হবে।");
                    }
                    $message_box = '<div class="alert success">✅ পোস্ট সফলভাবে সম্পন্ন হয়েছে!</div>';
                }
            }
        }
    }
}

/* =========================================
   ৩. ওয়ালেট উইথড্রয়ালস ক্যাশআউট রিকোয়েস্ট হ্যান্ডলার
   ========================================= */
if (isset($_POST['cyber_frontend_withdraw'])) {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'cyber_dashboard_withdraw_nonce')) {
        $message_box = '<div class="alert error">❌ Security Verification failed.</div>';
    } else {
        $method = sanitize_text_field($_POST['withdraw_method']);
        $number = sanitize_text_field($_POST['withdraw_number']);
        $amount = (float) $_POST['withdraw_amount'];
        
        if ($amount < 100) {
            $message_box = '<div class="alert error">❌ সর্বনিম্ন ক্যাশআউট লিমিট ১০০ টাকা!</div>';
        } elseif ($amount > $balance) {
            $message_box = '<div class="alert error">❌ আপনার ওয়ালেটে পর্যাপ্ত ব্যালেন্স নেই!</div>';
        } elseif (empty($number)) {
            $message_box = '<div class="alert error">❌ দয়া করে আপনার পেমেন্ট নম্বর প্রবেশ করুন।</div>';
        } else {
            // ব্যালেন্স ডিডাকশন ও রিকোয়েস্ট তৈরি
            $balance -= $amount;
            update_user_meta($u_id, 'user_balance', $balance);
            
            $req_id = 'w_' . time() . '_' . rand(100, 999);
            $withdrawals[] = [
                'id'     => $req_id,
                'method' => $method,
                'number' => $number,
                'amount' => $amount,
                'date'   => current_time('mysql'),
                'status' => 'pending'
            ];
            update_user_meta($u_id, 'ilybd_withdrawals', $withdrawals);
            
            // নোটিফিকেশন যুক্ত
            $n_msg = sprintf("💸 ৳%s টাকার উইথড্রয়াল রিকোয়েস্ট (%s) পেন্ডিং এ সাবমিট করা হয়েছে।", number_format($amount, 2), $method);
            ilybd_add_user_notification($u_id, $n_msg);
            
            $message_box = '<div class="alert success">💸 পেমেন্ট রিকোয়েস্ট সফল হয়েছে! এডমিন দ্রুত আপনার নাম্বারে পেমেন্ট সম্পন্ন করবে।</div>';
        }
    }
}

/* =========================================
   ৩.১ প্রোফাইল সেটিংস আপডেট হ্যান্ডলার
   ========================================= */
if (isset($_POST['ilybd_update_profile_settings'])) {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'ilybd_profile_settings_nonce')) {
        $message_box = '<div class="alert error">❌ নিরাপত্তা ভেরিফিকেশন ব্যর্থ হয়েছে!</div>';
    } else {
        // ১. আপডেট বায়ো
        $bio_text = sanitize_textarea_field($_POST['user_bio']);
        wp_update_user([
            'ID' => $u_id,
            'description' => $bio_text
        ]);
        
        // ২. আপডেট সোশ্যাল নেটওয়ার্ক লিঙ্ক সমূহ
        update_user_meta($u_id, 'user_facebook', esc_url_raw($_POST['user_facebook']));
        update_user_meta($u_id, 'user_twitter', esc_url_raw($_POST['user_twitter']));
        update_user_meta($u_id, 'user_linkedin', esc_url_raw($_POST['user_linkedin']));
        update_user_meta($u_id, 'user_youtube', esc_url_raw($_POST['user_youtube']));
        update_user_meta($u_id, 'user_instagram', esc_url_raw($_POST['user_instagram']));
        update_user_meta($u_id, 'user_tiktok', esc_url_raw($_POST['user_tiktok']));
        
        // ৩. আপডেট ফোন ও ঠিকানা
        update_user_meta($u_id, 'user_phone', sanitize_text_field($_POST['user_phone']));
        update_user_meta($u_id, 'user_address', sanitize_text_field($_POST['user_address']));
        
        // ৪. আপডেট ভয়েস প্রিফারেন্স (tts)
        $voice_pref = sanitize_text_field($_POST['ilybd_voice_pref']);
        if (in_array($voice_pref, ['male', 'female'])) {
            update_user_meta($u_id, 'ilybd_voice_pref', $voice_pref);
        }
        
        // ৫. আপডেট ম্যারিটাল / রিলেশনশিপ স্ট্যাটাস
        $rel_status = sanitize_text_field($_POST['ilybd_relationship_status']);
        update_user_meta($u_id, 'ilybd_relationship_status', $rel_status);
        
        // ৬. আপডেট অ্যাক্টিভিটি ইন্ডিকেটর প্রাইভেসী (অনলাইন/অফলাইন)
        $privacy_status = sanitize_text_field($_POST['ilybd_active_status_privacy']);
        update_user_meta($u_id, 'ilybd_active_status_privacy', $privacy_status);

        // ৭. আপডেট বিস্তারিত ঠিকানা ও গোপনীয়তা (গোপনীয়তা সেটিংস সহ)
        update_user_meta($u_id, 'ilybd_email_privacy', sanitize_text_field($_POST['ilybd_email_privacy']));
        update_user_meta($u_id, 'ilybd_phone_privacy', sanitize_text_field($_POST['ilybd_phone_privacy']));
        update_user_meta($u_id, 'ilybd_address_privacy', sanitize_text_field($_POST['ilybd_address_privacy']));
        update_user_meta($u_id, 'ilybd_country', sanitize_text_field($_POST['ilybd_country']));
        update_user_meta($u_id, 'ilybd_division', sanitize_text_field($_POST['ilybd_division']));
        update_user_meta($u_id, 'ilybd_district', sanitize_text_field($_POST['ilybd_district']));
        update_user_meta($u_id, 'ilybd_upazila', sanitize_text_field($_POST['ilybd_upazila']));
        update_user_meta($u_id, 'ilybd_union', sanitize_text_field($_POST['ilybd_union']));

        // ৮. আপডেট সোশ্যাল কানেকশন ফ্ল্যাগস
        update_user_meta($u_id, 'social_google_connected', isset($_POST['social_google_connected']) ? '1' : '0');
        update_user_meta($u_id, 'social_facebook_connected', isset($_POST['social_facebook_connected']) ? '1' : '0');
        
        // ৯. ফাইল আপলোড এর মাধ্যমে কাস্টম প্রোফাইল অভাতার
        if (isset($_FILES['avatar_file']) && $_FILES['avatar_file']['size'] > 0) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $attachment_id = media_handle_upload('avatar_file', 0);
            if (!is_wp_error($attachment_id)) {
                $avatar_url = wp_get_attachment_url($attachment_id);
                update_user_meta($u_id, 'ilybd_custom_avatar', $avatar_url);
            } else {
                $message_box .= '<div class="alert error">❌ অভাতার আপলোড ব্যর্থ হয়েছে: ' . $attachment_id->get_error_message() . '</div>';
            }
        }
        
        // বোনাস চেক এবং রিওয়ার্ড প্রদান (যদি সকল ডাটা কমপ্লিট করে)
        $rewarded = false;
        if (function_exists('ilybd_check_and_reward_profile_completion')) {
            $rewarded = ilybd_check_and_reward_profile_completion($u_id);
        }
        
        $message_box = '<div class="alert success">✅ আপনার সাইবার প্রোফাইলের সকল তথ্য ও সেটিংস সফলভাবে আপডেট করা হয়েছে!</div>';
        if ($rewarded) {
            $message_box .= '<div class="alert success">🎁 অভিনন্দন! ফার্স্ট টাইম প্রোফাইল সম্পূর্ণ করায় আপনি ৩০ XP রিওয়ার্ড পেয়েছেন!</div>';
        }
    }
}

// কন্ট্রিবিউটর মেকার সেলф আপগ্রেডার (সবাই কন্ট্রিবিউটর হতে পারবেন)
if (isset($_POST['ilybd_self_become_contributor'])) {
    $user_role_slug = !empty($user->roles) ? $user->roles[0] : 'subscriber';
    if ($user_role_slug === 'subscriber') {
        wp_update_user(array('ID' => $u_id, 'role' => 'contributor'));
        $user = wp_get_current_user(); // reload values
        $user_role_slug = 'contributor';
        ilybd_add_user_notification($u_id, '🎉 অভিনন্দন! আপনি সফলভাবে নিজেকে কন্ট্রিবিউটর (Contributor) পদে উন্নীত করেছেন। এখন আপনি ৫টি কন্টেন্ট সাবমিট করতে পারবেন!');
        $message_box = '<div class="alert success">🎉 অভিনন্দন! আপনি কন্ট্রিবিউটর (Contributor) পদে যুক্ত হয়েছেন। আপনার জন্য নতুন টিউন অপশন উন্মুক্ত করা হয়েছে।</div>';
    }
}

// অথর প্রমোশন রিকোয়েস্ট সাবমিট হ্যান্ডলার
if (isset($_POST['ilybd_submit_author_promotion'])) {
    $user_role_slug = !empty($user->roles) ? $user->roles[0] : 'subscriber';
    $posts_count = count_user_posts($u_id);
    if ($user_role_slug === 'contributor' && $posts_count >= 5) {
        update_user_meta($u_id, 'ilybd_author_request', 'pending_approval');
        ilybd_add_user_notification($u_id, '🚀 আপনার অথর প্রমোশন রিকোয়েস্ট অ্যাডমিনের কাছে সফলভাবে পাঠানো হয়েছে!');
        ilybd_add_user_notification(1, '📢 কন্ট্রিবিউটর ' . esc_html($user->display_name) . ' অথর পদের জন্য রিভিউ ও প্রোমোশন রিকোয়েস্ট পাঠিয়েছেন!');
        $message_box = '<div class="alert success">🚀 আপনার প্রমোশন রিকোয়েস্ট সফলভাবে পাঠানো হয়েছে! এডমিন দ্রুত রিভিউ সম্পন্ন করে আপনাকে অথর হিসেবে প্রোমোট করবে।</div>';
    }
}

// অ্যাডমিন কন্ট্রোল প্রোফাইল মডিফায়ার হ্যান্ডলার
$user_role_slug = !empty($user->roles) ? $user->roles[0] : 'subscriber';
if ($user_role_slug === 'administrator' && isset($_POST['ilybd_admin_update_user'])) {
    $target_user_id = intval($_POST['target_user_id']);
    if ($target_user_id > 0) {
        $new_balance = (float)$_POST['new_balance'];
        $new_points  = (int)$_POST['new_points'];
        $new_level   = (int)$_POST['new_level'];
        $new_role    = sanitize_text_field($_POST['new_role']);
        $new_display_name = sanitize_text_field($_POST['new_display_name']);
        
        global $wpdb;
        $table_wallet = $wpdb->prefix . 'ilybd_wallet';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_wallet'") == $table_wallet) {
            $wpdb->update($table_wallet, array(
                'balance' => $new_balance,
                'points' => $new_points,
                'user_level' => $new_level
            ), array('user_id' => $target_user_id));
        }
        
        update_user_meta($target_user_id, 'user_balance', $new_balance);
        update_user_meta($target_user_id, 'ilybd_total_points', $new_points);
        
        wp_update_user(array(
            'ID' => $target_user_id,
            'display_name' => $new_display_name,
            'role' => $new_role
        ));
        
        if (isset($_POST['author_promotion_action'])) {
            $action = sanitize_text_field($_POST['author_promotion_action']);
            if ($action === 'approve') {
                wp_update_user(array('ID' => $target_user_id, 'role' => 'author'));
                update_user_meta($target_user_id, 'ilybd_author_request', 'approved');
                ilybd_add_user_notification($target_user_id, '🎉 অভিনন্দন! অ্যাডমিন আপনার অথর রিকোয়েস্টটি রিভিউ করে আপনাকে অথর হিসেবে প্রোমোট করেছেন!');
            } elseif ($action === 'reject') {
                update_user_meta($target_user_id, 'ilybd_author_request', 'rejected');
                ilybd_add_user_notification($target_user_id, '❌ দুঃখিত, আপনার অথর রিকোয়েস্টটি অ্যাডমিন কর্তৃক বাতিল করা হয়েছে।');
            }
        }
        
        $message_box = '<div class="alert success">🛡️ অ্যাডমিন একশন সফল হয়েছে! টার্গেট ইউজারের ইনফরমেশন সফলভাবে মডিফাই করা হয়েছে।</div>';
    }
}

// কন্টেন্ট কমেন্ট ও ইনস্ট্যান্ট রিপ্লাই ড্যাশবোর্ড হ্যান্ডলার
if (isset($_POST['ilybd_submit_dashboard_comment_reply'])) {
    $parent_id = intval($_POST['comment_parent_id']);
    $post_id   = intval($_POST['comment_post_id']);
    $reply_text= sanitize_textarea_field($_POST['comment_reply_text']);
    
    if ($post_id > 0 && !empty($reply_text)) {
        $comment_data = array(
            'comment_post_ID'      => $post_id,
            'comment_author'       => $user->display_name,
            'comment_author_email' => $user->user_email,
            'comment_content'      => $reply_text,
            'comment_parent'       => $parent_id,
            'user_id'              => $u_id,
            'comment_approved'     => 1,
        );
        $comment_id = wp_insert_comment($comment_data);
        if ($comment_id) {
            $parent_comment = get_comment($parent_id);
            if ($parent_comment && $parent_comment->user_id) {
                ilybd_add_user_notification($parent_comment->user_id, "💬 '" . esc_html($user->display_name) . "' আপনার কমেন্টের একটি রিপ্লাই দিয়েছেন আপনার কন্টেন্টে!");
            }
            if (function_exists('ilybd_update_user_economy')) {
                ilybd_update_user_economy($u_id, 2, 0.10, '💬 আপনার পোস্টে কমেন্টের রিপ্লাই দেওয়ায় আপনি ২ XP এবং ৳০.১০ টাকা বোনাস পেয়েছেন!');
            }
            $message_box = '<div class="alert success">✅ কমেন্টটির রিপ্লাই সফলভাবে সাবমিট ও পাবলিশড হয়েছে!</div>';
        }
    }
}

/* =========================================
   ৩.২ ইনস্ট্যান্ট স্টোরি পাবলিশার হ্যান্ডলার
   ========================================= */
if (isset($_POST['ilybd_submit_frontend_story'])) {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'ilybd_story_nonce')) {
        $message_box = '<div class="alert error">❌ নিরাপত্তা কোড মেলেনি।</div>';
    } else {
        $media_type  = sanitize_text_field($_POST['story_media_type']); // text, image, video
        $caption     = sanitize_textarea_field($_POST['story_caption']);
        $background  = sanitize_text_field($_POST['story_bg_gradient'] ?? '');
        $media_url   = '';
        
        if (isset($_FILES['story_file']) && $_FILES['story_file']['size'] > 0) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $attachment_id = media_handle_upload('story_file', 0);
            if (!is_wp_error($attachment_id)) {
                $media_url = wp_get_attachment_url($attachment_id);
            }
        }
        
        if ($media_type !== 'text' && empty($media_url)) {
            $message_box = '<div class="alert error">❌ দয়া করে একটি ফাইল আপলোড করুন।</div>';
        } else {
            $stories = get_option('ilybd_cyber_stories', []);
            if (!is_array($stories)) $stories = [];
            
            $new_story = [
                'id'          => uniqid('story_'),
                'user_id'     => $u_id,
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
            
            // ইকোনমি রেপ্লিকেট (৫ XP + ০.২০ টাকা বোনাস)
            if (function_exists('ilybd_update_user_economy')) {
                ilybd_update_user_economy($u_id, 5, 0.20, '📝 আপনার স্টোরি সফলভাবে আপলোড হয়েছে! আপনি লাভ করেছেন ৫ XP এবং ৳০.২০ বোনাস।');
            } else {
                ilybd_add_user_notification($u_id, '📝 আপনার স্টোরি আপলোড হওয়ায় ৫ XP এবং ৳০.২০ বোনাস যোগ হয়েছে।');
            }
            
            $message_box = '<div class="alert success">🚀 অভিনন্দন! আপনার ইনস্ট্যান্ট স্টোরি সফলভাবে পাবলিশ হয়েছে এবং বোনাস ব্যালেন্স যোগ হয়েছে!</div>';
        }
    }
}

// ৪. স্ট্যাটিস্টিকস
$posts_count = count_user_posts($u_id);
global $wpdb;
$comments_count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $wpdb->comments WHERE user_id = %d AND comment_approved = 1",
    $u_id
));

// মোট রিডিং কাউন্টার (লাইক ও ভিউ ট্র্যাকিং)
$author_posts = get_posts(['author' => $u_id, 'post_type' => 'post', 'posts_per_page' => 100]);
$total_views = 0;
$total_likes = 0;
foreach ($author_posts as $p) {
    $total_views += (int) get_post_meta($p->ID, 'ilybd_post_views_count', true);
    $total_likes += (int) get_post_meta($p->ID, '_likes', true);
}
?>

<div class="cyber-real-dashboard" style="background:#0d1117; max-width:1100px; margin:20px auto; border-radius:16px; border:1px solid #30363d; overflow:hidden; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color:#ffffff; box-shadow:0 15px 50px rgba(0,0,0,0.6);">
    
    <!-- HEADER ALERT BOX -->
    <?php if(!empty($message_box)) echo $message_box; ?>

    <!-- PART 1: TOP PROFILE CARD -->
    <div style="background:linear-gradient(135deg, #161b22 0%, #0d1117 100%); border-bottom:1px solid #30363d; padding:30px; display:flex; flex-wrap:wrap; align-items:center; gap:25px;">
        <div style="position:relative; width:90px; height:90px; border-radius:50%; overflow:hidden; border:3px solid <?php echo esc_attr($tier['color']); ?>; box-shadow:0 0 15px rgba(0,255,65,0.1);">
            <?php echo get_avatar($u_id, 90); ?>
        </div>
        <div style="flex:1;">
            <div style="display:flex; align-items:center; gap:10px;">
                <h2 style="margin:0; font-size:24px; color:#fff; font-weight:700;"><?php echo esc_html($user->display_name); ?></h2>
                <span style="background:rgba(0, 255, 65, 0.1); color:#00ff41; border:1px solid rgba(0, 255, 65, 0.3); padding:2px 8px; border-radius:12px; font-size:11px; font-weight:900;">✔ VERIFIED</span>
            </div>
            <p style="margin:6px 0 0 0; color:#8b949e; font-size:14px;"><?php echo esc_html($user->user_email); ?></p>
            
            <div style="display:flex; flex-wrap:wrap; gap:8px; align-items:center; margin-top:10px;">
                <div style="display:inline-block; font-size:12px; font-weight:bold; background:<?php echo esc_attr($tier['color']); ?>; color:#000; padding:4px 14px; border-radius:20px; text-transform:uppercase;">
                    Level: <?php echo esc_html($tier['rank']); ?>
                </div>

                <?php
                $role_names = array(
                    'administrator' => 'অ্যাডমিন (Admin)',
                    'editor'        => 'এডিটর (Editor)',
                    'author'        => 'অথর (Author)',
                    'contributor'   => 'কন্ট্রিবিউটর (Contributor)',
                    'subscriber'    => 'সাধারণ সদস্য (Subscriber)',
                );
                $formatted_role = isset($role_names[$user_role_slug]) ? $role_names[$user_role_slug] : ucfirst($user_role_slug);
                ?>
                <div style="display:inline-block; font-size:12px; font-weight:bold; background:#00e5ff; color:#000; padding:4px 14px; border-radius:20px;">
                    রোলঃ <?php echo esc_html($formatted_role); ?>
                </div>

                <!-- কন্ট্রিবিউটর বা অথর পদের পদোন্নতি প্যানেল -->
                <?php if ($user_role_slug === 'subscriber'): ?>
                    <form method="post" style="display:inline-block; margin: 0;">
                        <button type="submit" name="ilybd_self_become_contributor" style="background:#ff9800; color:#fff; border:none; padding:4px 14px; border-radius:20px; font-size:11px; font-weight:bold; cursor:pointer;" class="bouncers-btn-glow">
                            🚀 কন্ট্রিবিউটর হোন (Start Earning)
                        </button>
                    </form>
                <?php elseif ($user_role_slug === 'contributor'): ?>
                    <?php
                    $req_status = get_user_meta($u_id, 'ilybd_author_request', true);
                    if ($posts_count >= 5):
                        if (empty($req_status) || $req_status === 'rejected'): ?>
                            <form method="post" style="display:inline-block; margin: 0;">
                                <button type="submit" name="ilybd_submit_author_promotion" style="background:#ffeb3b; color:#121212; border:none; padding:4px 14px; border-radius:20px; font-size:11px; font-weight:bold; cursor:pointer;" class="bouncers-btn-glow">
                                    👑 Author হোন (Apply Promotion)
                                </button>
                            </form>
                        <?php elseif ($req_status === 'pending_approval'): ?>
                            <span style="background:rgba(255,235,59,0.15); color:#ffeb3b; border:1px solid rgba(255,235,59,0.3); padding:4px 14px; border-radius:20px; font-size:11px; font-weight:bold;">
                                ⏳ Author রিকোয়েস্ট পেন্ডিং স্পেস
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span style="background:rgba(255,255,255,0.05); color:#8b949e; padding:4px 14px; border-radius:20px; font-size:11px;" title="Author হতে কমপক্ষে ৫টি কন্টেন্ট সাবমিট করতে হবে">
                            📝 অথর হতে কন্টেন্ট সাবমিটঃ <?php echo $posts_count; ?>/৫টি
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- COMPACT QUICK WALLET BAR -->
        <div style="background:#161b22; border:1px solid #30363d; padding:20px 25px; border-radius:12px; text-align:right;">
            <small style="color:#8b949e; display:block; text-transform:uppercase; font-size:10px; font-weight:bold; letter-spacing:1px;">Available Cashout</small>
            <strong style="font-size:26px; color:#00ff41; display:block; margin-top:4px;">৳<?php echo number_format($balance, 2); ?> Taka</strong>
        </div>
    </div>

    <!-- PART 2: CORE COUNTERS GRID -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:15px; padding:25px; background:#090d13;">
        <div class="db-stat-box">
            <span style="font-size:12px; color:#cfd8dc; font-weight:bold;">PUBLISHED POSTS</span>
            <h3><?php echo $posts_count; ?></h3>
            <p style="color:#8b949e; font-size:12px;">Active on platforms</p>
        </div>
        <div class="db-stat-box">
            <span style="font-size:12px; color:#cfd8dc; font-weight:bold;">ENGAGEMENT COMMS</span>
            <h3><?php echo $comments_count; ?></h3>
            <p style="color:#8b949e; font-size:12px;">Constructive comments</p>
        </div>
        <div class="db-stat-box">
            <span style="font-size:12px; color:#cfd8dc; font-weight:bold;">TOTAL POST VIEWS</span>
            <h3><?php echo $total_views; ?></h3>
            <p style="color:#00ff41; font-size:12px;">+৳<?php echo number_format($total_views * 0.05, 2); ?> Taka earned</p>
        </div>
        <div class="db-stat-box">
            <span style="font-size:12px; color:#cfd8dc; font-weight:bold;">COMMUNITY XP POINTS</span>
            <h3><?php echo $points; ?> XP</h3>
            <p style="color:#2196f3; font-size:12px;"><?php echo esc_html($tier['level']); ?></p>
        </div>
    </div>

    <!-- PART 3: NAVIGATIONAL FUNCTIONAL TABS -->
    <div style="display:flex; flex-wrap:wrap; background:#161b22; border-top:1px solid #30363d; border-bottom:1px solid #30363d; padding:5px 20px;">
        <button class="db-tab-btn <?php echo ($edit_requested_id > 0) ? '' : 'active'; ?>" onclick="switchTab(this, 'tab-manage-posts')"><i class="fa-solid fa-list-check"></i> আমার টিউনস</button>
        <button class="db-tab-btn <?php echo ($edit_requested_id > 0) ? 'active' : ''; ?>" onclick="switchTab(this, 'tab-add-post')"><i class="fa-solid fa-pen-nib"></i> <?php echo ($edit_requested_id > 0) ? 'টিউনটি এডিট করুন' : 'নতুন টিউন করুন'; ?></button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-wallet')"><i class="fa-solid fa-wallet"></i> ইনকাম ওয়ালেট</button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-notifs')">
            <i class="fa-solid fa-bell"></i> নোটিফিকেশনস 
            <?php if ($unread_count > 0): ?>
                <span class="badge" style="background:#ff0055; color:#fff; border-radius:10px; padding:2px 8px; font-size:11px; margin-left:5px; font-weight:bold; animation: pulse 1s infinite;" id="db-notif-badge"><?php echo $unread_count; ?></span>
            <?php endif; ?>
        </button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-referral')"><i class="fa-solid fa-users"></i> এফিলিয়েট বা রেফারেল</button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-chat-inbox')"><i class="fa-solid fa-comments"></i> ইনবক্স চ্যাট</button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-profile-settings')"><i class="fa-solid fa-user-gear"></i> প্রোফাইল সেটিংস</button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-stories')"><i class="fa-solid fa-cloud-arrow-up"></i> স্টোরি প্লাস</button>
        <?php if ($user_role_slug === 'administrator'): ?>
            <button class="db-tab-btn" onclick="switchTab(this, 'tab-admin-control-room')" style="background:rgba(0, 240, 255, 0.1); border:1.5px solid rgba(0, 240, 255, 0.25); color:#00f0ff; margin-left: auto;"><i class="fa-solid fa-user-shield"></i> অ্যাডমিন কন্ট্রোল</button>
        <?php endif; ?>
    </div>

    <!-- TAB CONTENTS VIEWPORT -->
    <div style="padding:25px; background:#0d1117;">
        
        <!-- ======================= TAB 1: MANAGE POSTS ======================= -->
        <div id="tab-manage-posts" class="db-tab-content active">
            <h3 style="margin-top:0; color:#fff; border-bottom:1px solid #222; padding-bottom:10px;">📊 My Content Repository</h3>
            
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; text-align:left; font-size:14px;">
                    <thead>
                        <tr style="border-bottom:2px solid #30363d; color:#8b949e;">
                            <th style="padding:12px 10px;">Tune Title</th>
                            <th style="padding:12px 10px;">Date Submitted</th>
                            <th style="padding:12px 10px;">Status</th>
                            <th style="padding:12px 10px; text-align:center;">Engagement</th>
                            <th style="padding:12px 10px; text-align:right;">Control Panel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $user_posts_query = new WP_Query([
                            'author'         => $u_id,
                            'post_type'      => 'post',
                            'post_status'    => ['publish', 'pending', 'draft'],
                            'posts_per_page' => 20
                        ]);
                        
                        if ($user_posts_query->have_posts()):
                            while ($user_posts_query->have_posts()): $user_posts_query->the_post();
                                $p_id = get_the_ID();
                                $status = get_post_status($p_id);
                                $status_badge = '<span class="post-status draft">Draft</span>';
                                if ($status === 'publish') {
                                    $status_badge = '<span class="post-status publish">Approved</span>';
                                } elseif ($status === 'pending') {
                                    $status_badge = '<span class="post-status pending">Pending Review</span>';
                                }
                                
                                $views = (int) get_post_meta($p_id, 'ilybd_post_views_count', true);
                                $likes = (int) get_post_meta($p_id, '_likes', true);
                                ?>
                                <tr style="border-bottom:1px solid #1f242c; hover:background:#161b22;">
                                    <td style="padding:15px 10px; font-weight:600;">
                                        <a href="<?php the_permalink(); ?>" target="_blank" style="color:#58a6ff; text-decoration:none;" id="title-text-<?php echo $p_id; ?>"><?php the_title(); ?></a>
                                    </td>
                                    <td style="padding:15px 10px; color:#8b949e;"><?php echo get_the_date(); ?></td>
                                    <td style="padding:15px 10px;"><?php echo $status_badge; ?></td>
                                    <td style="padding:15px 10px; text-align:center;">
                                        <span style="color:#00ff41; margin-right:8px;" title="Total Views">👁 <?php echo $views; ?></span>
                                        <span style="color:#ff3e3e;" title="Total Likes">❤️ <?php echo $likes; ?></span>
                                    </td>
                                    <td style="padding:15px 10px; text-align:right; display:flex; justify-content:flex-end; gap:6px; flex-wrap:wrap;">
                                        <button class="small-edit-btn" onclick="toggleCommentsDrawer(<?php echo $p_id; ?>)" style="background:#21262d; border-color:#30363d; color:#c9d1d9;">
                                            <i class="fa-solid fa-comments"></i> কমেন্ট ও রিপ্লাই (<?php echo get_comments_number($p_id); ?>)
                                        </button>
                                        <button class="small-edit-btn" 
                                                onclick="triggerEditPost(<?php echo $p_id; ?>, <?php echo esc_attr(json_encode(get_the_title())); ?>, <?php echo esc_attr(json_encode(get_the_content())); ?>, <?php echo esc_attr(get_the_category()[0]->term_id ?: 0); ?>)">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Collapsible Comments & Reply Engagement Drawer Row -->
                                <tr id="comments-drawer-<?php echo $p_id; ?>" style="display:none; background:#0d1117;">
                                    <td colspan="5" style="padding:20px; border:1px solid #30363d; border-radius:8px;">
                                        <div style="border-left:3px solid #00f0ff; padding-left:15px;">
                                            <h4 style="margin:0 0 15px 0; color:#fff; font-size:14px; text-transform:uppercase; letter-spacing:0.5px;">
                                                <i class="fa-solid fa-comments" style="color:#00f0ff;"></i> কন্টেন্ট কমেন্ট ও ইনস্ট্যান্ট রিপ্লাই ড্যাশবোর্ড
                                            </h4>
                                            
                                            <?php
                                            $post_comments = get_comments(array('post_id' => $p_id, 'status' => 'approve'));
                                            if (!empty($post_comments)): ?>
                                                <div style="display:flex; flex-direction:column; gap:12px; max-height:350px; overflow-y:auto; padding-right:5px; margin-bottom:15px;">
                                                    <?php foreach ($post_comments as $cmt): ?>
                                                        <div style="background:#161b22; border:1px solid #21262d; border-radius:8px; padding:12px 15px;">
                                                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; flex-wrap:wrap; gap:10px;">
                                                                <div style="display:flex; align-items:center; gap:8px;">
                                                                    <div style="width:26px; height:26px; border-radius:50%; overflow:hidden; border:1px solid #30363d;">
                                                                        <?php echo get_avatar($cmt->user_id ?: $cmt->comment_author_email, 26); ?>
                                                                    </div>
                                                                    <div>
                                                                        <strong style="color:#58a6ff; font-size:12.5px;"><?php echo esc_html($cmt->comment_author); ?></strong>
                                                                        <span style="color:#8b949e; font-size:11px; margin-left:6px;"><?php echo esc_html(human_time_diff(strtotime($cmt->comment_date), current_time('timestamp'))); ?> আগে</span>
                                                                    </div>
                                                                </div>
                                                                <span style="font-family:monospace; font-size:10px; color:#8b949e; background:#0d1117; padding:2px 6px; border-radius:4px;">ID: #<?php echo $cmt->comment_ID; ?></span>
                                                            </div>
                                                            <p style="margin:5px 0 8px 0; color:#c9d1d9; font-size:12.5px; line-height:1.5;"><?php echo esc_html($cmt->comment_content); ?></p>
                                                            
                                                            <!-- Instant Reply Box inside My Tunes -->
                                                            <form method="post" style="display:flex; gap:8px; margin-top:10px; border-top:1px dashed rgba(255,255,255,0.05); padding-top:8px;">
                                                                <input type="hidden" name="comment_parent_id" value="<?php echo $cmt->comment_ID; ?>">
                                                                <input type="hidden" name="comment_post_id" value="<?php echo $p_id; ?>">
                                                                <input type="text" name="comment_reply_text" placeholder="এই মেম্বারের কমেন্টের সরাসরি উত্তর দিন..." required style="flex:1; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px 12px; color:#fff; font-size:12px; outline:none; font-family:inherit;">
                                                                <button type="submit" name="ilybd_submit_dashboard_comment_reply" style="background:#00ff41; color:#000; border:none; padding:8px 16px; border-radius:6px; font-size:11px; font-weight:bold; cursor:pointer;" class="bouncers-btn-glow">
                                                                    উত্তর দিন (Reply)
                                                                </button>
                                                            </form>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <p style="color:#8b949e; font-size:12.5px; padding:15px 5px; margin:0;"><i class="fa-solid fa-face-meh"></i> এইটিউনে এখনও কোনো কমেন্ট করা হয়নি।</p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; wp_reset_postdata(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="padding:30px; text-align:center; color:#8b949e;">আপনি এখনও কোনো পোস্ট বা কন্টেন্ট প্রকাশ করেননি!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======================= TAB 2: ADD / EDIT POST FORM ======================= -->
        <div id="tab-add-post" class="db-tab-content">
            <h3 id="form-header-title" style="margin-top:0; color:#fff; border-bottom:1px solid #222; padding-bottom:10px;"><i class="fa-solid fa-pen-nib"></i> Compose or Edit Your Tune</h3>
            
            <div style="display:grid; grid-template-columns: 2fr 1fr; gap:25px; align-items: flex-start; margin-top:15px;" class="cyber-editor-split-grid">
                
                <!-- LHS Form Column -->
                <div>
                    <form method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field('cyber_dashboard_post_nonce'); ?>
                        <input type="hidden" name="edit_post_id" id="form_edit_post_id" value="0">
                        <input type="hidden" name="cyber_frontend_post" value="1">
                        
                        <div class="form-row">
                            <label>Tune Title (টাইটেল)</label>
                            <input type="text" name="post_title" id="form_post_title" placeholder="একটি চমৎকার কৌতূহলপূর্ণ টাইটেল দিন..." required>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
                            <div class="form-row" style="margin-bottom:0;">
                                <label>Tune Category (ক্যাটাগরি)</label>
                                <select name="post_cat" id="form_post_cat" required style="width:100%; height:40px; background:#161b22; border:1px solid #30363d; border-radius:6px; color:#fff; padding:0 10; outline:none;">
                                    <?php
                                    $cats = get_categories(['hide_empty' => false]);
                                    foreach ($cats as $cat) {
                                        echo '<option value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-row" style="margin-bottom:0;">
                                <label>Post Status (পোস্টের প্রকাশ অবস্থা)</label>
                                <select name="post_status" id="form_post_status" style="width:100%; height:40px; background:#161b22; border:1px solid #30363d; border-radius:6px; padding:0 10px; color:#fff; font-size:13px; outline:none; font-weight:bold;">
                                    <option value="pending">📤 পর্যালোচনার জন্য জমা দিন (Pending Review)</option>
                                    <option value="draft">📁 ড্রাফট হিসেবে সেভ করে রাখুন (Save as Draft)</option>
                                    <?php if (current_user_can('publish_posts')): ?>
                                        <option value="publish">🚀 সরাসরি পাবলিশ করুন (Direct Publish)</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- FEATURED IMAGE THUMBNAIL UPLOADER -->
                        <div class="form-row">
                            <label>Feature Image / Thumbnail (ফিচার ছবি বা থাম্বনেইল)</label>
                            <div style="background:#161b22; border:2px dashed #30363d; border-radius:8px; padding:20px; text-align:center; position:relative; cursor:pointer;" onclick="document.getElementById('post_featured_image').click();" class="cyber-file-zone">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size:24px; color:#58a6ff; margin-bottom:10px;"></i>
                                <span style="display:block; color:#8b949e; font-size:12.5px;">কন্টেন্টের আকর্ষনীয় ফিচার থাম্বন্যাল ইমেজ সিলেক্ট করুন (PNG, JPG)</span>
                                <span id="post-img-filename-txt" style="color:#00ff41; font-size:12.5px; font-weight:bold; display:block; margin-top:8px;"></span>
                                <input type="file" name="featured_image" id="post_featured_image" accept="image/*" style="display:none;" onchange="previewPostFeaturedImageName(this)">
                            </div>
                        </div>

                        <div class="form-row">
                            <label>Main Body Content (মূল সুর বা কন্টেন্ট)</label>
                            <p style="font-size:11px; color:#8b949e; margin:0 0 10px 0;">যেকোনো ধরণের কপি-পেস্ট বা এআই তৈরি করা প্লাজিয়ার্ড কন্টেন্ট গ্রহণযোগ্য নয় এবং বাতিল বলে গণ্য হবে।</p>
                            <div style="background: #161b22; border: 1px solid #30363d; border-radius: 8px; overflow: hidden; padding: 5px;" class="cyber-classic-editor-wrapper">
                                <?php 
                                $settings = array(
                                    'textarea_name' => 'post_content',
                                    'textarea_rows' => 15,
                                    'media_buttons' => true,
                                    'teeny'         => false,
                                    'quicktags'     => true,
                                    'tinymce'       => array(
                                        'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,link,unlink,|,forecolor,backcolor',
                                        'theme_advanced_buttons2' => 'formatselect,fontselect,fontsizeselect,outdent,indent,blockquote,undo,redo,removeformat,code'
                                    )
                                );
                                wp_editor('', 'form_post_content', $settings); 
                                ?>
                            </div>
                        </div>

                        <div style="display:flex; gap:10px; margin-top:20px;">
                            <button type="submit" class="submit-action-btn" style="background:#00ff41; color:#000; font-weight:bold;"><i class="fa-solid fa-rocket"></i> Submit/Update Tune</button>
                            <button type="button" class="cancel-edit-btn" id="cancel_edit_post_btn" onclick="cancelEditPost()" style="display:none;">Cancel Edit</button>
                        </div>
                    </form>
                </div>

                <!-- RHS Guidelines Sidebar Column -->
                <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                    <h4 style="color:#00f0ff; margin-top:0; border-bottom:1px solid #222; padding-bottom:12px; font-size:15px; text-transform:uppercase;">
                        <i class="fa-solid fa-circle-question"></i> কন্টেন্ট লেখার স্পষ্ট গাইডলাইন
                    </h4>
                    <p style="color:#c9d1d9; font-size:13px; line-height:1.7; margin-bottom:15px;">
                        iloveyoubd.com-এ মানসম্মত কন্টেন্ট প্রকাশ করে আকর্ষণীয় আর্নিং নিশ্চিত করতে নিচের নিয়মাবলী অত্যন্ত সতর্কতার সাথে অনুসরন করুনঃ
                    </p>
                    <ul style="color:#8b949e; font-size:12.5px; line-height:1.8; padding-left:18px; margin:0 0 20px 0;">
                        <li><strong style="color:#ff3b30;">এআই কপিরাইট সম্পূর্ণ নিষিদ্ধঃ</strong> চ্যাটজিপিটি বা গুগল জেমিনি দ্বারা কপি-পেস্ট এআই লেখা কন্টেন্ট আমাদের সিস্টেমে প্রকাশযোগ্য নয়। নিজের ভাষায় এবং সৃজনশীল উপায়ে সুর বা টিউন সাজান।</li>
                        <li><strong>থাম্বনেইল বা ফিচার ইমেজঃ</strong> আকর্ষনীয় ফিচার ইমেজ সংযুক্ত করলে কন্টেন্টের রিচ এবং ভিউ বৃদ্ধি পায় বহুগুণে!</li>
                        <li><strong>সবচেয়ে সঠিক ক্যাটাগরিঃ</strong> সুরের মূল বিষয়বস্তুর সাথে সামঞ্জস্যপূর্ণ সঠিক ক্যাটাগরি নির্বাচন করুন।</li>
                        <li><strong>নীতিমালা মেনে চলুনঃ</strong> বিভ্রান্তিকর কন্টেন্ট, অশ্লীল সুর বা উস্কানিমূলক আলোচনা থেকে বিরত থাকুন।</li>
                    </ul>
                    <a href="/copyright-policy/" target="_blank" style="display:inline-block; width:100%; text-align:center; background:rgba(0, 240, 255, 0.1); border:1px solid rgba(0, 240, 255, 0.4); color:#00f0ff; padding:10px; border-radius:6px; font-size:12.5px; font-weight:bold; text-decoration:none; transition: all 0.2s;" onmouseover="this.style.background='rgba(0,240,255,0.2)'" onmouseout="this.style.background='rgba(0,240,255,0.1)'">
                        📖 আমাদের কপিরাইট পলিসি পড়ুন
                    </a>
                </div>
            </div>
        </div>

        <!-- ======================= TAB 3: MONEY WALLET & PAYOUT SYSTEM ======================= -->
        <div id="tab-wallet" class="db-tab-content">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:25px;">
                
                <!-- WALLET DETAILS AND PAYOUT GATEWAY -->
                <div style="background:#161b22; padding:25px; border-radius:12px; border:1px solid #30363d;">
                    <h3 style="margin-top:0; color:#ffb347;"><i class="fa-solid fa-wallet"></i> Earning Balance Withdrawal</h3>
                    
                    <div style="margin:15px 0; background:#0d1117; padding:15px; border-radius:8px; border-left:4px solid #00ff41;">
                        <span style="font-size:12px; color:#8b949e;">Your wallet holds:</span>
                        <h2 style="margin:5px 0 0 0; color:#00ff41;">৳<?php echo number_format($balance, 2); ?> Taka</h2>
                        <small style="color:#8b949e; margin-top:5px; display:block;">কমেন্ট প্রতি বোনাস: ০.৫০ টাকা, পোস্ট ভিউ বোনাস: ০.০৫ টাকা, পোস্ট পাবলিশড বোনাস: ৫.৫০ টাকা!</small>
                    </div>

                    <form method="post">
                        <?php wp_nonce_field('cyber_dashboard_withdraw_nonce'); ?>
                        <input type="hidden" name="cyber_frontend_withdraw" value="1">
                        
                        <div class="form-row">
                            <label>Withdrawal Channel (পেমেন্ট পদ্ধতি)</label>
                            <select name="withdraw_method" required>
                                <option value="Bkash (Personal)">Bkash (Personal)</option>
                                <option value="Nagad (Personal)">Nagad (Personal)</option>
                                <option value="Bkash (Agent)">Bkash (Agent)</option>
                                <option value="Nagad (Agent)">Nagad (Agent)</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <label>Bkash/Nagad Number (মোবাইল নম্বর)</label>
                            <input type="text" name="withdraw_number" placeholder="017xxxxxxxx" required>
                        </div>

                        <div class="form-row">
                            <label>Cashout Amount (টাকার পরিমাণ)</label>
                            <input type="number" name="withdraw_amount" min="100" step="1" placeholder="Minimum: ১০০ টাকা" required>
                        </div>

                        <button type="submit" class="submit-action-btn" style="background:#ffb347; color:#000;"><i class="fa-solid fa-paper-plane"></i> Request Money Withdrawal</button>
                    </form>
                </div>

                <!-- PAYOUT REQUEST LOG -->
                <div style="background:#161b22; padding:25px; border-radius:12px; border:1px solid #30363d;">
                    <h3 style="margin-top:0; color:#fff; border-bottom:1px solid #222; padding-bottom:10px;"><i class="fa-solid fa-clock-rotate-left"></i> Payout History</h3>
                    
                    <div style="max-height:350px; overflow-y:auto;">
                        <?php if(!empty($withdrawals)): ?>
                            <?php foreach(array_reverse($withdrawals) as $w): 
                                $w_status = esc_html($w['status']);
                                $status_lbl = '<span class="status-box-lbl pending">Pending</span>';
                                if($w_status === 'paid' || $w_status === 'Completed') {
                                    $status_lbl = '<span class="status-box-lbl paid">Paid</span>';
                                } elseif($w_status === 'rejected') {
                                    $status_lbl = '<span class="status-box-lbl rejected">Cancelled</span>';
                                }
                                ?>
                                <div style="border-bottom:1px solid #30363d; padding:12px 5px; display:flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <h4 style="margin:0; color:#fff; font-size:14px;"><?php echo esc_html($w['method']); ?></h4>
                                        <small style="color:#8b949e; display:block; margin-top:2px;"><?php echo esc_html($w['number']); ?> • <?php echo esc_html($w['date']); ?></small>
                                    </div>
                                    <div style="text-align:right;">
                                        <strong style="color:#ffb347; display:block;">৳<?php echo number_format($w['amount'], 2); ?></strong>
                                        <div style="margin-top:4px;"><?php echo $status_lbl; ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="padding:15px; color:#8b949e; text-align:center;">এখন পর্যন্ত আপনার কোনো ক্যাশআউট ট্রানজেকশন নেই।</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- FULL-WIDTH TRANSACTIONS LEDGER (2040 DEEP BLUE / SPACE NEON GRID STYLE) -->
                <div style="grid-column: 1 / -1; margin-top:25px; background:#161b22; padding:25px; border-radius:12px; border:1px solid #30363d;">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #30363d; padding-bottom:15px; margin-bottom:15px;">
                        <h3 style="margin:0; color:#00f0ff; font-family:'Space Grotesk', sans-serif;"><i class="fa-solid fa-network-wired" style="color:#00ff41;"></i> রিয়েল-টাইম ওয়ালেট ও এক্সপি লেজার বুক (Full Ledger Audit)</h3>
                        <span style="font-family:monospace; font-size:11px; background:rgba(0,240,255,0.06); border:1px solid rgba(0,240,255,0.2); color:#00f0ff; padding:3px 10px; border-radius:20px;">🛡️ SECURED DIGITAL REGISTRY</span>
                    </div>

                    <?php
                    global $wpdb;
                    $table_ledger = $wpdb->prefix . 'ilybd_ledger';
                    $ledger_entries = [];
                    if ($wpdb->get_var("SHOW TABLES LIKE '$table_ledger'") == $table_ledger) {
                        $ledger_entries = $wpdb->get_results($wpdb->prepare(
                            "SELECT * FROM $table_ledger WHERE user_id = %d ORDER BY timestamp DESC LIMIT 20", $u_id
                        ));
                    }
                    ?>

                    <div style="overflow-x:auto;">
                        <?php if(!empty($ledger_entries)): ?>
                            <table style="width:100%; border-collapse:collapse; text-align:left; font-size:13px; font-family:'JetBrains Mono', monospace;">
                                <thead>
                                    <tr style="border-bottom:2px solid #30363d; color:#8b949e;">
                                        <th style="padding:10px 5px;">TRN ID</th>
                                        <th style="padding:10px 5px;">পদ্ধতি / কারণ</th>
                                        <th style="padding:10px 5px; text-align:center;">কারেন্সি</th>
                                        <th style="padding:10px 5px; text-align:right;">পরিমাণ</th>
                                        <th style="padding:10px 5px; text-align:right;">তারিখ ও সময়</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($ledger_entries as $entry): 
                                        $amt = (float) $entry->amount;
                                        $cur = esc_html($entry->currency);
                                        $reason = esc_html($entry->reason);
                                        $time_formatted = date('d M Y, h:i A', strtotime($entry->timestamp));
                                        
                                        $amt_color = $amt >= 0 ? '#00ff41' : '#ff3e3e';
                                        $amt_prefix = $amt >= 0 ? '+' : '';
                                        
                                        $cur_badge = '<span style="background:rgba(33,150,243,0.1); color:#2196f3; border:1px solid rgba(33,150,243,0.2); padding:2px 8px; border-radius:12px; font-size:10px; font-weight:bold;">XP (Points)</span>';
                                        if ($cur === 'BDT') {
                                            $cur_badge = '<span style="background:rgba(0,255,65,0.1); color:#00ff41; border:1px solid rgba(0,255,65,0.2); padding:2px 8px; border-radius:12px; font-size:10px; font-weight:bold;">৳ Taka</span>';
                                        }
                                    ?>
                                        <tr style="border-bottom:1px solid #1f242c;">
                                            <td style="padding:12px 5px; color:#c9d1d9;">#<?php echo esc_html($entry->id); ?></td>
                                            <td style="padding:12px 5px; color:#fff;" class="bengali-font-align-fix"><?php echo $reason; ?></td>
                                            <td style="padding:12px 5px; text-align:center;"><?php echo $cur_badge; ?></td>
                                            <td style="padding:12px 5px; text-align:right; color:<?php echo $amt_color; ?>; font-weight:bold;">
                                                <?php echo $amt_prefix . number_format($amt, ($cur === 'BDT' ? 2 : 0)); ?>
                                            </td>
                                            <td style="padding:12px 5px; text-align:right; color:#8b949e; font-size:11px;"><?php echo $time_formatted; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div style="padding:40px; text-align:center; color:#8b949e;">
                                <i class="fa-solid fa-folder-open" style="font-size:24px; color:#30363d; display:block; margin-bottom:10px;"></i>
                                কোনো লাইভ ট্রানজেকশন লেজার এন্ট্রি পাওয়া যায়নি। কন্ট্রিবিউশন শুরু করে প্রথম আর্নিং করুন!
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- ======================= TAB 4: SYSTEM NOTIFICATIONS ======================= -->
        <div id="tab-notifs" class="db-tab-content">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom:1px solid #222; padding-bottom:10px; margin-bottom: 20px;">
                <h3 style="margin:0; color:#fff;"><i class="fa-solid fa-bell"></i> System Alert logs</h3>
                <?php if(!empty($notifications)): ?>
                    <button id="clear-notifs-btn" style="background:#ff3333; color:#white; border:none; padding:6px 12px; border-radius:4px; cursor:pointer; font-size:12px; font-weight:bold;"><i class="fa-solid fa-trash-can"></i> মুছে ফেলুন (Clear All)</button>
                <?php endif; ?>
            </div>
            
            <div id="notifs-list-container" style="max-height:400px; overflow-y:auto; padding-right:5px;">
                <?php if(!empty($notifications)): ?>
                    <?php foreach($notifications as $n): ?>
                        <div style="background:#161b22; border:1px solid #30363d; margin-bottom:10px; padding:15px; border-radius:8px; border-left:4px solid #00ff41; position:relative;">
                            <span style="font-size:12px; color:#c9d1d9; line-height:1.5; display:block;"><?php echo esc_html($n['text']); ?></span>
                            <small style="font-size:10px; color:#8b949e; display:block; margin-top:6px; text-align:right;">⏰ <?php echo esc_html($n['time']); ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="padding:30px; text-align:center; color:#8b949e;">কোনো নতুন নোটিফিকেশন নেই।</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- ======================= TAB 5: AFFILIATE / REFERRAL ======================= -->
        <div id="tab-referral" class="db-tab-content">
            <h3 style="margin-top:0; color:#fff; border-bottom:1px solid #222; padding-bottom:10px;"><i class="fa-solid fa-users"></i> আপনার অ্যাফিলিয়েট/রেফারেল নেটওয়ার্ক</h3>
            <div style="background:linear-gradient(135deg, rgba(0,240,255,0.05), rgba(0,0,0,0)); border:1px solid rgba(0,240,255,0.2); border-radius:12px; padding:25px; text-align:center; box-shadow:0 10px 30px rgba(0,240,255,0.02)">
                <h4 style="color:#00f0ff; margin-top:0; font-size:18px;">আপনার ইউনিক রেফারেল লিংক</h4>
                <p style="color:#8b949e; font-size:14px; line-height:1.6; margin-bottom:20px;">এই লিংকটি আপনার বন্ধুদের সাথে শেয়ার করুন। তারা আপনার লিংকের মাধ্যমে ওয়েবসাইট ভিজিট করলে আপনি অ্যাফিলিয়েট বোনাস এবং ক্যাশব্যাক শেয়ার পাবেন।</p>
                <?php
                   $home_url = home_url('/');
                   $ref_link = $home_url . '?ref=' . $u_id;
                ?>
                <div style="background:#0d1117; display:inline-block; border:1px dashed #00f0ff; padding:15px; border-radius:8px; width:100%; max-width:500px; color:#fff; font-family:monospace; font-size:15px;">
                    <?php echo esc_url($ref_link); ?>
                </div>
                <div style="margin-top:15px;">
                    <p style="color:#00ff41; font-weight:bold; font-size:13px;">✔ আপনার লিংকটি কপি করতে উপরের বক্সে ট্যাপ করুন</p>
                </div>
            </div>
            
            <div style="margin-top:30px; background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                <h4 style="margin:0 0 10px 0; color:#fff;">কিভাবে এটি কাজ করে?</h4>
                <ul style="color:#8b949e; font-size:13px; line-height:1.8; padding-left:20px;">
                    <li>উপরে দেওয়া আপনার ইউনিক লিংকটি কপি করে ব্যবহারকারীদের আমন্ত্রণ জানান।</li>
                    <li>তারা আপনার লিংকের মাধ্যমে আসলে সিস্টেম ২ সেকেন্ডের মাঝে ট্র্যাকিং কুঁকি সেট করবে।</li>
                    <li>আপনার লিংকের মাধ্যমে কেউ অ্যাকাউন্ট খুললে আপনি পাবেন <strong style="color:#00ff41;"><?php echo intval(get_option('ilybd_ref_points_referrer', 50)); ?> XP Point</strong> এবং <strong style="color:#ffb347;">৳<?php echo floatval(get_option('ilybd_ref_cash_referrer', 0.50)); ?> Taka</strong>.</li>
                    <li>যে অ্যাকাউন্ট খুলবে সেও ওয়েলকাম বোনাস হিসেবে পাবে <strong style="color:#00ff41;"><?php echo intval(get_option('ilybd_ref_points_referee', 100)); ?> XP Point</strong> এবং <strong style="color:#ffb347;">৳<?php echo floatval(get_option('ilybd_ref_cash_referee', 1.00)); ?> Taka</strong>.</li>
                    <li>নতুন ব্যবহারকারীদের অ্যাক্টিভিটিতে পেজ ভিউ এবং অ্যাডসেন্স রেভিনিউ থেকেও আপনি বোনাস পাবেন।</li>
                </ul>
            </div>
        </div>

        <!-- ======================= TAB 6: 💬 MESSENGER CHAT INBOX ======================= -->
        <div id="tab-chat-inbox" class="db-tab-content">
            <h3 style="margin-top:0; color:#fff; border-bottom:1px solid #30363d; padding-bottom:10px; text-shadow: 0 0 10px rgba(0,240,255,0.4);">
                <i class="fa-solid fa-comments"></i> 💬 লাইভ সাইবার চ্যাট ইনবক্স (Live Messenger Room)
            </h3>
            
            <div class="messenger-container" style="display:grid; grid-template-columns:300px 1fr; gap:20px; background:#161b22; border:1px solid #30363d; border-radius:12px; height:600px; overflow:hidden;">
                <!-- Left panel: Inbox & Thread Search -->
                <div class="messenger-sidebar" style="border-right:1px solid #30363d; display:flex; flex-direction:column; height:100%; background:#0d1117;">
                    <!-- User Search to Start a new chat -->
                    <div style="padding:15px; border-bottom:1px solid #30363d;">
                        <input type="text" id="chat-user-search" placeholder="🔍 ইউজার খুঁজুন (Search Members)..." style="width:100%; background:#161b22; border:1px solid #30363d; padding:10px; border-radius:8px; color:#fff; font-size:13px; outline:none;" onkeyup="searchChatUsers()">
                        <div id="search-results-dropdown" style="display:none; position:absolute; background:#161b22; border:1px solid #30363d; border-radius:8px; width:270px; max-height:220px; overflow-y:auto; z-index:900; box-shadow:0 10px 20px rgba(0,0,0,0.5); margin-top:5px;"></div>
                    </div>
                    
                    <!-- Thread List -->
                    <div id="chat-thread-list" style="flex:1; overflow-y:auto; padding:10px 5px;">
                        <?php
                        $threads = ilybd_get_user_chat_threads($u_id);
                        if (!empty($threads)):
                            foreach ($threads as $th):
                                $unread_dot = $th['unread'] ? '<span class="unread-dot" style="width:10px; height:10px; background:#00ff41; border-radius:50%; display:inline-block; margin-left:auto; box-shadow: 0 0 8px #00ff41;"></span>' : '';
                        ?>
                                <div class="chat-thread-item" onclick="loadChatThread(<?php echo $th['partner_id']; ?>)" data-partner="<?php echo $th['partner_id']; ?>" style="display:flex; align-items:center; gap:12px; padding:12px 10px; margin-bottom:5px; border-radius:8px; cursor:pointer; hover:background:#161b22; transition:all 0.2s;">
                                    <div style="position:relative;">
                                        <img src="<?php echo esc_url($th['avatar']); ?>" style="width:40px; height:40px; border-radius:50%; border:1px solid #30363d;">
                                        <span class="user-status-dot" style="position:absolute; bottom:2px; right:2px; width:10px; height:10px; border-radius:50%; background:#00ff41; border:2px solid #0d1117;"></span>
                                    </div>
                                    <div style="flex:1; min-width:0;">
                                        <div style="font-weight:600; color:#fff; font-size:13.5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo esc_html($th['name']); ?></div>
                                        <div style="font-size:11.5px; color:#c9d1d9; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-top:1px;"><?php echo esc_html($th['latest'] ?: 'মেসেজ করুন...'); ?></div>
                                    </div>
                                    <?php echo $unread_dot; ?>
                                </div>
                        <?php
                            endforeach;
                        else:
                        ?>
                            <div style="padding:40px 15px; text-align:center; color:#8b949e; font-size:12.5px;">
                                <i class="fa-solid fa-comments" style="display:block; font-size:24px; margin-bottom:8px; color:#222;"></i>
                                কোন চ্যাট হিস্ট্রি নেই। মেম্বারদের সার্চ করে লাইভ চ্যাট শুরু করুন!
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Right panel: Active Message Box -->
                <div class="messenger-box" style="display:flex; flex-direction:column; height:100%; background:#161b22; position:relative;">
                    <div id="chat-welcome-placeholder" style="display:flex; flex-direction:column; align-items:center; justify-content:center; flex:1; padding:30px; text-align:center;">
                        <i class="fa-solid fa-fingerprint" style="font-size:50px; color:rgba(0, 240, 255, 0.15); margin-bottom:15px; animation: pulse 2s infinite;"></i>
                        <h4 style="color:#00f0ff; margin:0 0 5px 0;">সিকিউর সাইবার কানেকশন (End-to-End Encrypted)</h4>
                        <p style="color:#8b949e; font-size:12px; max-width:320px; line-height:1.6; margin:0;">বায়ে যেকোনো সচল চ্যাট থ্রেডে ক্লিক করুন অথবা ইউজার সার্চ করুন এবং চ্যাট করার সাথে প্রতি মেসেজে এক্সপি আর্ন করুন!</p>
                    </div>
                    
                    <!-- Real Message Thread Screen (hidden by default) -->
                    <div id="chat-active-box" style="display:none; flex-direction:column; height:100%;">
                        <!-- Partner header bar -->
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:15px 20px; border-bottom:1px solid #30363d; background:#0d1117;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <img id="chat-partner-avatar" src="" style="width:38px; height:38px; border-radius:50%; border:1px solid #30363d;">
                                <div>
                                    <div id="chat-partner-name" style="font-weight:bold; color:#fff; font-size:14px;">...</div>
                                    <span style="font-size:11px; color:#00ff41;"><i class="fa-solid fa-circle" style="font-size:8px;"></i> অনলাইনে আছেন</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Messages Body -->
                        <div id="chat-messages-body" style="flex:1; overflow-y:auto; padding:20px; display:flex; flex-direction:column; gap:15px; background:#0d1117;">
                            <!-- Messages bubbles loaded here dynamically -->
                        </div>
                        
                        <!-- Messenger Input Bar -->
                        <div style="padding:15px 20px; border-top:1px solid #30363d; background:#0d1117; display:flex; align-items:center; gap:10px;">
                            <textarea id="chat-text-input" placeholder="আপনার বার্তাটি বাংলায় লিখুন (Type secure message)..." style="flex:1; background:#161b22; border:1px solid #30363d; border-radius:10px; padding:10px 15px; color:#fff; font-size:13px; outline:none; resize:none; height:42px; line-height:1.4; max-height:100px; overflow-y:auto;" onkeydown="handleChatKeyPress(event)"></textarea>
                            <button onclick="sendChatMessage()" style="background:#00f0ff; color:#0d1117; border:none; width:42px; height:42px; border-radius:10px; display:flex; align-items:center; justify-content:center; cursor:pointer;" class="bouncers-btn-glow">
                                <i class="fa-solid fa-paper-plane" style="font-size:16px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================= TAB 7: ⚙ PROFILE SETTINGS ======================= -->
        <div id="tab-profile-settings" class="db-tab-content">
            <h3 style="margin-top:0; color:#fff; border-bottom:1px solid #30363d; padding-bottom:10px; text-shadow: 0 0 10px rgba(0,240,255,0.4);">
                <i class="fa-solid fa-user-gear"></i> গ্লোবাল প্রোফাইল কনফিগারেশন ও বায়োমেট্রিক সেটিংস
            </h3>
            
            <form method="post" enctype="multipart/form-data" action="">
                <?php wp_nonce_field('ilybd_update_profile_nonce', 'ilybd_profile_nonce'); ?>
                
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:25px; margin-top:20px; margin-bottom:25px;">
                    
                    <!-- COLUMN 1: SECURITY, AVATAR & BIOMETRIC -->
                    <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                        <h4 style="color:#00f0ff; margin-top:0; border-bottom:1px solid #222; padding-bottom:8px; font-size:16px;">
                            <i class="fa-solid fa-fingerprint"></i> সিকিউরড আইডেন্টিটি এবং বায়োমেট্রিক্স
                        </h4>
                        
                        <!-- AVATAR UPLOAD -->
                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">কাস্টম প্রোফাইল অবতার আপলোড করুন</label>
                            <div style="display:flex; align-items:center; gap:12px; background:#0d1117; padding:10px; border-radius:8px; border:1px solid #30363d;">
                                <?php echo get_avatar($u_id, 45, '', '', ['class' => 'profile-upload-avatar-img', 'style' => 'border-radius:50%; border:1.5px solid #00f0ff;']); ?>
                                <div>
                                    <input type="file" name="avatar_file" id="avatar_file" style="display:none;" onchange="updateSelectedAvatarText()">
                                    <button type="button" onclick="document.getElementById('avatar_file').click()" style="background:#21262d; border:1px solid #30363d; color:#c9d1d9; border-radius:6px; padding:5px 10px; font-size:12px; font-weight:bold; cursor:pointer;" class="bouncers-btn">
                                        <i class="fa-solid fa-image"></i> ছবি সিলেক্ট করুন
                                    </button>
                                    <span id="avatar-filename-txt" style="display:block; font-size:10px; color:#8b949e; margin-top:5px;">কোনো ফাইল সিলেক্টেড নাই</span>
                                </div>
                            </div>
                        </div>

                        <!-- PHONE AND ADDRESS -->
                        <div style="margin-bottom:15px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">পার্সোনাল মোবাইল নম্বর</label>
                            <input type="text" name="user_phone" value="<?php echo esc_attr($user_phone); ?>" placeholder="017xxxxxxxx" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none;">
                        </div>
                        <div style="margin-bottom:15px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">বর্তমান ঠিকানা</label>
                            <input type="text" name="user_address" value="<?php echo esc_attr($user_address); ?>" placeholder="Dhaka, Bangladesh" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none;">
                        </div>

                        <!-- BIOMETRIC CONFIG DEVICE -->
                        <div style="margin-top:20px; padding:15px; background:#0d1117; border:1.5px dashed #30363d; border-radius:8px;">
                            <label style="display:block; font-size:12px; color:#c9d1d9; margin-bottom:6px; font-weight:bold;">
                                <i class="fa-solid fa-fingerprint" style="color:#00ff41;"></i> বায়োমেট্রিক ফিঙ্গারপ্রিন্ট কানেকশন
                            </label>
                            <?php if ($is_bio_connected): ?>
                                <div style="display:flex; align-items:center; justify-content:space-between; background:rgba(0,128,0,0.1); border:1px solid rgba(0,128,0,0.3); padding:8px 12px; border-radius:6px; color:#00ff41; font-size:12px;">
                                    <span>✔ সিকিউর ফিঙ্গারপ্রিন্ট অ্যাক্টিভেটেড!</span>
                                    <button type="submit" name="ilybd_disconnect_biometric" value="1" style="background:#ff3b30; color:#fff; border:none; padding:4px 8px; border-radius:4px; font-size:10px; font-weight:bold; cursor:pointer;" class="bouncers-btn">রিমুভ</button>
                                </div>
                            <?php else: ?>
                                <div style="background:rgba(255,255,255,0.02); border:1px solid #222; padding:10px 12px; border-radius:6px; text-align:center;">
                                    <p style="color:#8b949e; font-size:11.5px; margin:0 0 10px 0;">ওয়ান-ট্যাপে ইনস্ট্যান্ট লগইন নিরাপদ করতে আপনার ফিঙ্গার বা ফেস সেন্সর লিংক করুন</p>
                                    <button type="button" onclick="startBiometricRegistry()" style="background:#00ff41; color:#0e1117; border:none; padding:6px 14px; border-radius:4px; font-size:11.5px; font-weight:bold; cursor:pointer; width:100%;" class="bouncers-btn-glow">
                                        📟 ফিঙ্গারপ্রিন্ট ডিভাইস কানেক্ট করুন
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- VOICE PREFERENCE -->
                        <div style="margin-top:15px; margin-bottom:15px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">ভয়েস চেঞ্জ সেটিংস (TTS Gender Preference)</label>
                            <select name="ilybd_voice_pref" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none;">
                                <option value="female" <?php selected($user_voice, 'female'); ?>>♀ স্ত্রী কণ্ঠ (Female Accent AI Voice)</option>
                                <option value="male" <?php selected($user_voice, 'male'); ?>>♂ পুরুষ কণ্ঠ (Male Accent AI Voice)</option>
                            </select>
                        </div>

                        <!-- RELATIONSHIP STATUS -->
                        <div style="margin-bottom:15px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">রিলেশনシップ স্ট্যাটাস (Single / Friend Connect)</label>
                            <select name="ilybd_relationship_status" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none;">
                                <option value="single" <?php selected($user_rel, 'single'); ?>>সিঙ্গেল আছি (Single)</option>
                                <option value="friend" <?php selected($user_rel, 'friend'); ?>>বন্ধু খুঁজছি (Looking for Friend)</option>
                                <option value="relation" <?php selected($user_rel, 'relation'); ?>>সম্পর্কে জড়িয়ে আছি (In a Relationship)</option>
                                <option value="married" <?php selected($user_rel, 'married'); ?>>বিবাহিত (Married)</option>
                            </select>
                        </div>

                        <!-- ACTIVE STATE PRIVACY -->
                        <div style="margin-bottom:15px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">অনলাইন/অфলাইন অ্যাক্টিভিটি ইন্ডিকেটর</label>
                            <select name="ilybd_active_status_privacy" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none;">
                                <option value="public" <?php selected($user_privacy, 'public'); ?>>অনলাইন দেখাবে (Online Active Display)</option>
                                <option value="private" <?php selected($user_privacy, 'private'); ?>>অফলাইন দেখাবে (Invisible Offline Mode)</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- COLUMN 2: BIO AND SOCIALS -->
                    <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                        <h4 style="color:#00f0ff; margin-top:0; border-bottom:1px solid #222; padding-bottom:8px; font-size:16px;">
                            <i class="fa-solid fa-address-card"></i> বায়োডাটা এবং সোশ্যাল লিঙ্ক সমূহ
                        </h4>
                        
                        <!-- BIO -->
                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">আপনার সংক্ষিপ্ত বায়ো (Profile Bio)</label>
                            <textarea name="user_bio" style="width:100%; height:80px; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none; resize:none;" placeholder="আপনার নিজের সম্পর্কে ২টি লাইন লিখুন..."><?php echo esc_textarea($user_bio); ?></textarea>
                        </div>
                        
                        <!-- SOCIAL LINKS -->
                        <div style="margin-bottom:12px;">
                            <label style="display:flex; justify-content:space-between; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">
                                <span><i class="fa-brands fa-facebook" style="color:#3b5998;"></i> ফেসবুক অ্যাকাউন্ট URL</span>
                            </label>
                            <input type="url" name="user_facebook" value="<?php echo esc_attr($user_fb); ?>" placeholder="https://facebook.com/username" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px 12px; color:#fff; font-size:13px; outline:none;">
                        </div>
                        
                        <div style="margin-bottom:12px;">
                            <label style="display:flex; justify-content:space-between; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">
                                <span><i class="fa-brands fa-tiktok" style="color:#ff007f;"></i> লিঙ্কডইন / টিকток URL</span>
                            </label>
                            <input type="url" name="user_tiktok" value="<?php echo esc_attr($user_tiktok); ?>" placeholder="https://tiktok.com/@username" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px 12px; color:#fff; font-size:13px; outline:none;">
                        </div>

                        <div style="margin-bottom:12px;">
                            <label style="display:flex; justify-content:space-between; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">
                                <span><i class="fa-brands fa-twitter" style="color:#1da1f2;"></i> টুইটার (X) URL</span>
                            </label>
                            <input type="url" name="user_twitter" value="<?php echo esc_attr($user_tw); ?>" placeholder="https://twitter.com/username" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px 12px; color:#fff; font-size:13px; outline:none;">
                        </div>
                        
                        <div style="margin-bottom:12px;">
                            <label style="display:flex; justify-content:space-between; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">
                                <span><i class="fa-brands fa-youtube" style="color:#ff0000;"></i> ইউটিউব চ্যানেল URL</span>
                            </label>
                            <input type="url" name="user_youtube" value="<?php echo esc_attr($user_yt); ?>" placeholder="https://youtube.com/c/channel" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px 12px; color:#fff; font-size:13px; outline:none;">
                        </div>

                        <div style="margin-bottom:12px;">
                            <label style="display:flex; justify-content:space-between; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">
                                <span><i class="fa-brands fa-instagram" style="color:#e1306c;"></i> ইনস্টাগ্রাম URL</span>
                            </label>
                            <input type="url" name="user_instagram" value="<?php echo esc_attr($user_ig); ?>" placeholder="https://instagram.com/username" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px 12px; color:#fff; font-size:13px; outline:none;">
                        </div>

                        <div style="margin-bottom:12px;">
                            <label style="display:flex; justify-content:space-between; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">
                                <span><i class="fa-brands fa-linkedin" style="color:#0077b5;"></i> লিঙ্কডইন URL</span>
                            </label>
                            <input type="url" name="user_linkedin" value="<?php echo esc_attr($user_li); ?>" placeholder="https://linkedin.com/in/username" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px 12px; color:#fff; font-size:13px; outline:none;">
                        </div>
                    </div>

                    <!-- COLUMN 3: REGIONAL ADDRESS & PRIVACY ENGINE -->
                    <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                        <h4 style="color:#00f0ff; margin-top:0; border-bottom:1px solid #222; padding-bottom:8px; font-size:16px;">
                            <i class="fa-solid fa-map-location-dot"></i> ঠিকানা ও গোপনীয়তা সেটিংস
                        </h4>
                        
                        <!-- Country, Division, District, Upazila, Union -->
                        <div style="margin-bottom:15px; display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <div>
                                <label style="display:block; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">দেশের নাম (Country)</label>
                                <input type="text" name="ilybd_country" value="<?php echo esc_attr($user_country); ?>" placeholder="Bangladesh" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px; color:#fff; font-size:12px; outline:none;">
                            </div>
                            <div>
                                <label style="display:block; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">বিভাগ/স্টেট (Division)</label>
                                <input type="text" name="ilybd_division" value="<?php echo esc_attr($user_division); ?>" placeholder="Dhaka" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px; color:#fff; font-size:12px; outline:none;">
                            </div>
                        </div>

                        <div style="margin-bottom:15px; display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <div>
                                <label style="display:block; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">জেলা (District)</label>
                                <input type="text" name="ilybd_district" value="<?php echo esc_attr($user_district); ?>" placeholder="Gazipur" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px; color:#fff; font-size:12px; outline:none;">
                            </div>
                            <div>
                                <label style="display:block; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">উপজেলা (Upazila)</label>
                                <input type="text" name="ilybd_upazila" value="<?php echo esc_attr($user_upazila); ?>" placeholder="Sreepur" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px; color:#fff; font-size:12px; outline:none;">
                            </div>
                        </div>

                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:11px; color:#8b949e; margin-bottom:4px; font-weight:bold;">ইউনিয়ন (Union)</label>
                            <input type="text" name="ilybd_union" value="<?php echo esc_attr($user_union); ?>" placeholder="Telihati" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:8px; color:#fff; font-size:12px; outline:none;">
                        </div>

                        <!-- PRIVACY CONTROLS (EMAIL, PHONE, ADDRESS) -->
                        <h5 style="color:#ffb347; margin:15px 0 8px 0; font-size:13px; font-weight:bold;">গোপনীয়তা ফিল্টার (Contact Privacy)</h5>
                        
                        <div style="margin-bottom:10px; display:flex; align-items:center; justify-content:space-between; background:#0d1117; padding:8px; border-radius:6px; border:1px solid #222;">
                            <span style="font-size:12px; color:#c9d1d9;"><i class="fa-solid fa-envelope"></i> ইমেইল গোপনীয়তা</span>
                            <select name="ilybd_email_privacy" style="background:#161b22; border:1px solid #30363d; color:#fff; font-size:11.5px; padding:4px; border-radius:4px; outline:none;">
                                <option value="public" <?php selected($email_privacy, 'public'); ?>>সবার জন্য উম্মুক্ত</option>
                                <option value="friends" <?php selected($email_privacy, 'friends'); ?>>শুধু মেম্বাররা দেখবে</option>
                                <option value="private" <?php selected($email_privacy, 'private'); ?>>সম্পূর্ণ গোপন রাখুন</option>
                            </select>
                        </div>

                        <div style="margin-bottom:10px; display:flex; align-items:center; justify-content:space-between; background:#0d1117; padding:8px; border-radius:6px; border:1px solid #222;">
                            <span style="font-size:12px; color:#c9d1d9;"><i class="fa-solid fa-phone"></i> মোবাইল নম্বর গোপনীয়তা</span>
                            <select name="ilybd_phone_privacy" style="background:#161b22; border:1px solid #30363d; color:#fff; font-size:11.5px; padding:4px; border-radius:4px; outline:none;">
                                <option value="public" <?php selected($phone_privacy, 'public'); ?>>সবার জন্য উম্মুক্ত</option>
                                <option value="friends" <?php selected($phone_privacy, 'friends'); ?>>শুধু মেম্বাররা দেখবে</option>
                                <option value="private" <?php selected($phone_privacy, 'private'); ?>>সম্পূর্ণ গোপন রাখুন</option>
                            </select>
                        </div>

                        <div style="margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; background:#0d1117; padding:8px; border-radius:6px; border:1px solid #222;">
                            <span style="font-size:12px; color:#c9d1d9;"><i class="fa-solid fa-house"></i> বর্তমান ঠিকানা গোপনীয়তা</span>
                            <select name="ilybd_address_privacy" style="background:#161b22; border:1px solid #30363d; color:#fff; font-size:11.5px; padding:4px; border-radius:4px; outline:none;">
                                <option value="public" <?php selected($address_privacy, 'public'); ?>>সবার জন্য উম্মুক্ত</option>
                                <option value="friends" <?php selected($address_privacy, 'friends'); ?>>শুধু মেম্বাররা দেখবে</option>
                                <option value="private" <?php selected($address_privacy, 'private'); ?>>সম্পূর্ণ গোপন রাখুন</option>
                            </select>
                        </div>

                        <!-- SOCIAL IDENTITY LINKS CONNECTIONS -->
                        <h5 style="color:#58a6ff; margin:15px 0 8px 0; font-size:13px; font-weight:bold;">সোশ্যাল পাসওয়ার্ডলেস লগইন লিংকুন</h5>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <label style="display:flex; align-items:center; justify-content:space-between; background:#0d1117; padding:8px 12px; border-radius:6px; border:1px solid #222; cursor:pointer;">
                                <span style="font-size:12px; color:#fff;"><i class="fa-brands fa-google" style="color:#ea4335; margin-right:6px;"></i> Google অ্যাকাউন্ট লিংক করুন</span>
                                <input type="checkbox" name="social_google_connected" value="1" <?php checked($google_connected, '1'); ?> style="width:16px; height:16px; accent-color:#00ff41;">
                            </label>
                            
                            <label style="display:flex; align-items:center; justify-content:space-between; background:#0d1117; padding:8px 12px; border-radius:6px; border:1px solid #222; cursor:pointer;">
                                <span style="font-size:12px; color:#fff;"><i class="fa-brands fa-facebook" style="color:#1877f2; margin-right:6px;"></i> Facebook অ্যাকাউন্ট লিঙ্ক করুন</span>
                                <input type="checkbox" name="social_facebook_connected" value="1" <?php checked($facebook_connected, '1'); ?> style="width:16px; height:16px; accent-color:#00ff41;">
                            </label>
                        </div>
                    </div>

                </div>

                <div style="text-align:right;">
                    <button type="submit" name="ilybd_update_profile_settings" style="background:#00ff41; color:#0d1117; border:none; padding:12px 35px; border-radius:8px; font-weight:bold; cursor:pointer;" class="bouncers-btn-glow">
                        <i class="fa-solid fa-floppy-disk"></i> সেভ প্রোফাইল সেটিংস (Apply Changes)
                    </button>
                </div>
            </form>
        </div>

        <!-- ======================= TAB 8: 🚀 STOREY PLUS (Add status / story) ======================= -->
        <div id="tab-stories" class="db-tab-content">
            <h3 style="margin-top:0; color:#fff; border-bottom:1px solid #30363d; padding-bottom:10px; text-shadow: 0 0 10px rgba(0,240,255,0.4);">
                <i class="fa-solid fa-cloud-arrow-up"></i> 🚀 সাইবার ইনস্ট্যান্ট স্টোরি (Story Publisher)
            </h3>
            
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:25px; margin-top:20px;">
                
                <!-- STORY SUBMIT FORM -->
                <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                    <h4 style="color:#00f0ff; margin-top:0; border-bottom:1px solid #222; padding-bottom:15px; font-size:16px;">
                        <i class="fa-solid fa-plus-circle"></i> নতুন স্টোরি পাবলিশ করুন
                    </h4>
                    
                    <form method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field('ilybd_story_nonce'); ?>
                        
                        <!-- SELECT TYPE -->
                        <div style="margin-bottom:15px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">স্টোরি ক্যাটাগরি / টাইপ</label>
                            <select name="story_media_type" id="story_media_type_select" onchange="toggleStoryTypeFields(this.value)" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none;">
                                <option value="text">✍ শুধু টেক্সট স্টোরি (Glow Text Status)</option>
                                <option value="image">🖼️ পিকচার স্টোরি (Photo Slide Story)</option>
                                <option value="video">🎥 ভিডিও স্টোরি (Motion Video Story)</option>
                            </select>
                        </div>
                        
                        <!-- TEXT STORIES BG CHOOSER -->
                        <div style="margin-bottom:15px;" id="story_bg_gradient_group">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">ব্যাকগ্রাউন্ড গ্লো ইফেক্ট (Glow Gradient Pattern)</label>
                            <select name="story_bg_gradient" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none;">
                                <option value="linear-gradient(135deg, #070b13 0%, #0d1527 100%)">Cosmic Abyss (Default)</option>
                                <option value="linear-gradient(135deg, #FF3366 0%, #00f0ff 100%)">Cyber Plasma</option>
                                <option value="linear-gradient(135deg, #120c1f 0%, #8b5cf6 100%)">Electric Purple</option>
                                <option value="linear-gradient(135deg, #115e59 0%, #10b981 100%)">Emerald Grid</option>
                            </select>
                        </div>

                        <!-- UPLOAD FILE (images and videos) -->
                        <div style="margin-bottom:15px; display:none;" id="story_file_uploader_group">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">ছবি অথবা ভিডিও ফাইল আপলোড করুন</label>
                            <input type="file" name="story_file" accept="image/*,video/*" style="width:100%; background:#0d1117; border:1px solid #30363d; padding:8px; border-radius:6px; color:#fff; font-size:12px;">
                        </div>

                        <!-- CAPTION/TEXT CONTENT -->
                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">স্টোরি টেক্সট / ক্যাপশন</label>
                            <textarea name="story_caption" required style="width:100%; height:80px; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none; resize:none;" placeholder="এখানে স্টোরি কন্টেন্ট অথবা ক্যাপশন লিখুন..."></textarea>
                        </div>

                        <div>
                            <button type="submit" name="ilybd_submit_frontend_story" style="width:100%; background:linear-gradient(135deg, #00ff41 0%, #00f0ff 100%); color:#000; border:none; padding:12px; border-radius:8px; font-weight:bold; cursor:pointer;" class="bouncers-btn-glow">
                                <i class="fa-solid fa-paper-plane"></i> পাবলিশ স্টোরি (Earn 5 XP & ৳0.20)
                            </button>
                        </div>
                    </form>
                </div>

                <!-- RULES & GRAPH INFO -->
                <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                    <h4 style="color:#00ff41; margin-top:0; border-bottom:1px solid #222; padding-bottom:15px; font-size:16px;">
                        <i class="fa-solid fa-circle-info"></i> স্টোরি পাবলিশ রুলস এবং আর্নিং গাইড
                    </h4>
                    <p style="color:#8b949e; font-size: 13px; line-height:1.7;">
                        সাইবার স্টোরি হলো ২৪ ঘন্টার জন্য চমৎকার মেসেঞ্জার স্টোরি স্লাইড প্রদর্শন করার ডাইনামিক উপায়।
                    </p>
                    <ul style="color:#c9d1d9; font-size:13px; line-height:2.0; padding-left:20px; margin-top:15px;">
                        <li>প্রতিটি নতুন স্টোরি সাবমিশনে আপনি পাবেন <strong style="color:#00f0ff;">৫ XP</strong> এবং <strong style="color:#00ff41;">৳০.২০ টাকা বোনাস</strong>।</li>
                        <li>আপনার দেওয়া স্টোরিতে যত বেশি ইউজার রিয়েল-টাইম কন্টাক্ট করবে এবং ভিউ করবে, তত বেশি <strong style="color:#ffb347;">৳০.০৫</strong> বোনাস আপনার মূল স্প্রিং ব্যালেন্সে যোগ হবে!</li>
                        <li>স্টোরিতে অশ্লীল, নীতিহীন বা কপিরাইট লঙ্ঘিত কনটেন্ট আপলোড সম্পূর্ণ নিষিদ্ধ এবং এডমিন বাতিল করার অধিকার রাখে।</li>
                    </ul>
                </div>

            </div>
        </div>

        <?php if ($user_role_slug === 'administrator'): ?>
        <!-- ======================= TAB 9: 🛡️ ADMINISTRATOR CONTROL ROOM ======================= -->
        <div id="tab-admin-control-room" class="db-tab-content">
            <h3 style="margin-top:0; color:#00f0ff; border-bottom:1px solid #30363d; padding-bottom:10px; font-weight:800; text-transform:uppercase; letter-spacing:0.5px; text-shadow:0 0 10px rgba(0,240,255,0.3);">
                <i class="fa-solid fa-user-shield"></i> অ্যাডমিন কন্ট্রোল রুম (Cyber Security Control Room)
            </h3>
            
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:25px; margin-top:20px;">
                
                <!-- 1. BROADCAST NOTICE PANEL -->
                <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                    <h4 style="color:#00ff41; margin-top:0; border-bottom:1px solid #222; padding-bottom:12px; font-size:15px; text-transform:uppercase;">
                        <i class="fa-solid fa-bullhorn"></i> ব্রডকাস্ট বা নোটিশ প্রেরণ (Send Direct Notification)
                    </h4>
                    
                    <?php
                    if (isset($_POST['ilybd_admin_broadcast'])) {
                        $target_id = sanitize_text_field($_POST['notice_target_user_id']); // 'all' or specific user ID
                        $notice_text = sanitize_textarea_field($_POST['notice_content']);
                        
                        if (!empty($notice_text)) {
                            if ($target_id === 'all') {
                                // Broadcast to all users
                                $users_list = get_users(array('fields' => array('ID')));
                                foreach ($users_list as $u_item) {
                                    ilybd_add_user_notification($u_item->ID, "📢 [এডমিন নোটিশ]: " . $notice_text);
                                }
                                echo '<div style="background:rgba(0,255,65,0.1); border:1px solid #00ff41; color:#00ff41; padding:10px; border-radius:6px; font-size:12.5px; margin-bottom:15px;">✅ সকল ইউজারদের কাছে নোটিশটি সফলভাবে পাঠানো হয়েছে!</div>';
                            } else {
                                $target_id_int = intval($target_id);
                                if ($target_id_int > 0) {
                                    ilybd_add_user_notification($target_id_int, "🔔 [এডমিন নোটিশ]: " . $notice_text);
                                    echo '<div style="background:rgba(0,255,65,0.1); border:1px solid #00ff41; color:#00ff41; padding:10px; border-radius:6px; font-size:12.5px; margin-bottom:15px;">✅ ইউজার #' . $target_id_int . ' এর কাছে নোটিশটি সফলভাবে পাঠানো হয়েছে!</div>';
                                }
                            }
                        }
                    }
                    ?>
                    
                    <form method="post">
                        <div style="margin-bottom:15px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">টার্গেট ইউজার (Target List)</label>
                            <select name="notice_target_user_id" style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none; font-weight:bold; cursor:pointer;">
                                <option value="all">📢 সমস্ত নিবন্ধিত মেম্বার্স (Broadcast to All Users)</option>
                                <?php
                                $all_users_sel = get_users(array('number' => 200, 'fields' => array('ID', 'display_name')));
                                foreach ($all_users_sel as $usr_item): ?>
                                    <option value="<?php echo $usr_item->ID; ?>">👤 #<?php echo $usr_item->ID; ?> - <?php echo esc_html($usr_item->display_name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div style="margin-bottom:15px;">
                            <label style="display:block; font-size:12px; color:#8b949e; margin-bottom:6px; font-weight:bold;">নোটিসের বিষয়বস্তু (Short Alert message)</label>
                            <textarea name="notice_content" placeholder="এখানে আপনার গুরুত্বপূর্ণ নোটিশটি টাইপ করুন যা সরাসরি ইউজারের নোটিফিকেশন বক্সে শো করবে..." rows="4" required style="width:100%; background:#0d1117; border:1px solid #30363d; border-radius:6px; padding:10px; color:#fff; font-size:13px; outline:none; resize:none;"></textarea>
                        </div>
                        
                        <button type="submit" name="ilybd_admin_broadcast" style="width:100%; background:#00ff41; color:#000; border:none; padding:11px 20px; border-radius:6px; font-size:12.5px; font-weight:bold; cursor:pointer;" class="bouncers-btn-glow">
                            <i class="fa-solid fa-paper-plane"></i> নোটিশ সেন্ড করুন (Broadcast Now)
                        </button>
                    </form>
                </div>
                
                <!-- 2. AUTHOR PROMOTION REQUESTS LIST -->
                <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px;">
                    <h4 style="color:#ffeb3b; margin-top:0; border-bottom:1px solid #222; padding-bottom:12px; font-size:15px; text-transform:uppercase;">
                        <i class="fa-solid fa-crown"></i> অথর পদোন্নতির রিকোয়েস্ট সমুহ (Author Request Reviews)
                    </h4>
                    
                    <div style="max-height:280px; overflow-y:auto; display:flex; flex-direction:column; gap:10px;">
                        <?php
                        $rq_users = get_users(array(
                            'meta_key' => 'ilybd_author_request',
                            'meta_value' => 'pending_approval'
                        ));
                        if (!empty($rq_users)):
                            foreach ($rq_users as $rq_u):
                                $rq_posts = count_user_posts($rq_u->ID); ?>
                                <div style="background:#0d1117; border:1px solid #30363d; border-radius:8px; padding:12px;">
                                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:5px;">
                                        <div style="width:28px; height:28px; border-radius:50%; overflow:hidden;">
                                            <?php echo get_avatar($rq_u->ID, 28); ?>
                                        </div>
                                        <div>
                                            <strong style="color:#fff; font-size:13px;"><?php echo esc_html($rq_u->display_name); ?></strong>
                                            <span style="color:#ffea75; font-size:11px; display:block;">পোস্ট সংখ্যাঃ <?php echo $rq_posts; ?>টি</span>
                                        </div>
                                    </div>
                                    <form method="post" style="display:flex; gap:6px; margin-top:8px;">
                                        <input type="hidden" name="target_user_id" value="<?php echo $rq_u->ID; ?>">
                                        
                                        <!-- Keep simple compatibility inputs -->
                                        <input type="hidden" name="new_balance" value="<?php echo (float)get_user_meta($rq_u->ID, 'user_balance', true); ?>">
                                        <input type="hidden" name="new_points" value="<?php echo (int)get_user_meta($rq_u->ID, 'ilybd_total_points', true); ?>">
                                        <input type="hidden" name="new_level" value="<?php echo floor(intval(get_user_meta($rq_u->ID, 'ilybd_total_points', true)) / 500) + 1; ?>">
                                        <input type="hidden" name="new_role" value="author">
                                        <input type="hidden" name="new_display_name" value="<?php echo esc_attr($rq_u->display_name); ?>">

                                        <button type="submit" name="ilybd_admin_update_user" value="update" onclick="document.getElementById('author-promotion-action-<?php echo $rq_u->ID; ?>').value='approve';" style="flex:1; background:#00ff41; color:#000; border:none; padding:6px; border-radius:4px; font-size:11.5px; font-weight:bold; cursor:pointer;">
                                            অনুমোদন দিন
                                        </button>
                                        <button type="submit" name="ilybd_admin_update_user" value="update" onclick="document.getElementById('author-promotion-action-<?php echo $rq_u->ID; ?>').value='reject';" style="flex:1; background:rgba(255,59,48,0.15); color:#ff3b30; border:1px solid rgba(255,59,48,0.22); padding:5px; border-radius:4px; font-size:11.5px; font-weight:bold; cursor:pointer;">
                                            নাকচ করুন
                                        </button>
                                        <input type="hidden" name="author_promotion_action" id="author-promotion-action-<?php echo $rq_u->ID; ?>" value="">
                                    </form>
                                division</div>
                            <?php endforeach;
                        else: ?>
                            <p style="color:#8b949e; font-size:12.5px; text-align:center; padding:30px 10px;">কোন পেন্ডিং রিকোয়েস্ট পাওয়া যায়নি।</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- 3. DETAILED USERS EDITING & BALANCES LIST -->
            <div style="background:#161b22; border:1px solid #30363d; border-radius:12px; padding:20px; margin-top:25px;">
                <h4 style="color:#00f0ff; margin-top:0; border-bottom:1px solid #222; padding-bottom:12px; font-size:15px; text-transform:uppercase;">
                    <i class="fa-solid fa-users-gear"></i> মেম্বার ডাটাবেজ মডিফায়ার (Balance, Points, and Level Controller)
                </h4>
                
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; text-align:left; font-size:13.5px; color:#c9d1d9;">
                        <thead>
                            <tr style="border-bottom:1px solid #30363d; color:#8b949e; font-family:monospace;">
                                <th style="padding:10px;">মেম্বার প্রোফাইল</th>
                                <th style="padding:10px;">বর্তমান রোল (Role)</th>
                                <th style="padding:10px;">টাকা ব্যালেন্স (Balance)</th>
                                <th style="padding:10px;">পয়েন্টস (XP)</th>
                                <th style="padding:10px;">লেভেল (Level)</th>
                                <th style="padding:10px; text-align:right;">আপডেট বা বাটন</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $all_m_users = get_users(array('number' => 25));
                            foreach ($all_m_users as $m_u):
                                $m_u_role = !empty($m_u->roles) ? $m_u->roles[0] : 'subscriber';
                                
                                // Fetch wallet row directly inside PHP block to ensure updated data
                                $m_u_db_wallet = null;
                                if ($wpdb->get_var("SHOW TABLES LIKE '$table_wallet'") == $table_wallet) {
                                    $m_u_db_wallet = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_wallet WHERE user_id = %d", $m_u->ID));
                                }
                                if ($m_u_db_wallet) {
                                    $m_balance = (float)$m_u_db_wallet->balance;
                                    $m_points  = (int)$m_u_db_wallet->points;
                                    $m_level   = (int)$m_u_db_wallet->user_level;
                                } else {
                                    $m_balance = (float)get_user_meta($m_u->ID, 'user_balance', true);
                                    $m_points  = (int)get_user_meta($m_u->ID, 'ilybd_total_points', true);
                                    $m_level   = floor($m_points / 500) + 1;
                                }
                                ?>
                                <tr style="border-bottom:1px solid #21262d; hover:background:#161b22;">
                                    <form method="post">
                                        <input type="hidden" name="target_user_id" value="<?php echo $m_u->ID; ?>">
                                        <td style="padding:12px 10px; display:flex; align-items:center; gap:8px;">
                                            <div style="width:30px; height:30px; border-radius:50%; overflow:hidden;">
                                                <?php echo get_avatar($m_u->ID, 30); ?>
                                            </div>
                                            <div>
                                                <input type="text" name="new_display_name" value="<?php echo esc_attr($m_u->display_name); ?>" required style="background:transparent; border:none; border-bottom:1px dashed #30363d; color:#fff; font-size:13.5px; font-weight:bold; width:120px; outline:none; padding:2px;">
                                                <span style="color:#8b949e; font-size:11px; display:block; font-family:monospace;">ID: #<?php echo $m_u->ID; ?> • @<?php echo esc_html($m_u->user_login); ?></span>
                                            </div>
                                        </td>
                                        <td style="padding:12px 10px;">
                                            <select name="new_role" style="background:#0d1117; border:1px solid #30363d; color:#fff; border-radius:4px; padding:4px 6px; font-size:12px; outline:none; cursor:pointer;">
                                                <option value="subscriber" <?php selected($m_u_role, 'subscriber'); ?>>Subscriber</option>
                                                <option value="contributor" <?php selected($m_u_role, 'contributor'); ?>>Contributor</option>
                                                <option value="author" <?php selected($m_u_role, 'author'); ?>>Author</option>
                                                <option value="editor" <?php selected($m_u_role, 'editor'); ?>>Editor</option>
                                                <option value="administrator" <?php selected($m_u_role, 'administrator'); ?>>Admin</option>
                                            </select>
                                        </td>
                                        <td style="padding:12px 10px;">
                                            <span style="font-size:11px; color:#8b949e; display:block;">৳ Taka (৳)</span>
                                            <input type="number" step="0.01" name="new_balance" value="<?php echo $m_balance; ?>" required style="width:85px; background:#0d1117; border:1px solid #30363d; color:#00ff41; padding:4px 6px; border-radius:4px; font-weight:bold; text-align:center; outline:none;">
                                        </td>
                                        <td style="padding:12px 10px;">
                                            <span style="font-size:11px; color:#8b949e; display:block;">XP (Points)</span>
                                            <input type="number" name="new_points" value="<?php echo $m_points; ?>" required style="width:75px; background:#0d1117; border:1px solid #30363d; color:#2196f3; padding:4px 6px; border-radius:4px; font-weight:bold; text-align:center; outline:none;">
                                        </td>
                                        <td style="padding:12px 10px;">
                                            <span style="font-size:11px; color:#8b949e; display:block;">User Level</span>
                                            <input type="number" name="new_level" value="<?php echo $m_level; ?>" required style="width:55px; background:#0d1117; border:1px solid #30363d; color:#ff9800; padding:4px 6px; border-radius:4px; font-weight:bold; text-align:center; outline:none;">
                                        </td>
                                        <td style="padding:12px 10px; text-align:right;">
                                            <button type="submit" name="ilybd_admin_update_user" value="update" style="background:#00f0ff; color:#000; border:none; padding:6px 12px; border-radius:4px; font-size:11.5px; font-weight:bold; cursor:pointer;" class="bouncers-btn-glow">
                                                <i class="fa-solid fa-save"></i> সেভ করুন
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        <?php endif; ?>

        <script>
        function toggleStoryTypeFields(type) {
            var bgGroup = document.getElementById('story_bg_gradient_group');
            var fileGroup = document.getElementById('story_file_uploader_group');
            if (bgGroup && fileGroup) {
                if (type === 'text') {
                    bgGroup.style.display = 'block';
                    fileGroup.style.display = 'none';
                } else {
                    bgGroup.style.display = 'none';
                    fileGroup.style.display = 'block';
                }
            }
        }
        function previewAvatarName(input) {
            var txt = document.getElementById('avatar-filename-txt');
            if (txt && input.files && input.files[0]) {
                txt.innerHTML = "✔ নির্বাচিত ফাইল: " + input.files[0].name;
            }
        }
        function triggerOpenGlobalMessenger(e) {
            if (e) e.preventDefault();
            var panel = document.getElementById('messenger-sliding-panel');
            if (panel) {
                panel.style.display = 'flex';
            } else {
                alert('মেসেঞ্জার লোড হচ্ছে... অনুগ্রহ করে পেজটি একবার রিফ্রেশ করুন!');
            }
        }
        function toggleCommentsDrawer(postId) {
            var drawer = document.getElementById('comments-drawer-' + postId);
            if (drawer) {
                if (drawer.style.display === 'none') {
                    drawer.style.display = 'table-row';
                } else {
                    drawer.style.display = 'none';
                }
            }
        }
        function previewPostFeaturedImageName(input) {
            var txt = document.getElementById('post-img-filename-txt');
            if (txt && input.files && input.files[0]) {
                txt.innerHTML = "✔ নির্বাচিত ফিচার ছবি: " + input.files[0].name;
            }
        }
        </script>

    </div>

</div>

<!-- INTERACTIVE FRONTEND TAB & EDIT POST ACTIONS -->
<script>
function switchTab(btn, tabId) {
    // Buttons toggling
    var buttons = btn.parentNode.children;
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('active');
    }
    btn.classList.add('active');
    
    // Contents toggling
    var contents = document.getElementsByClassName('db-tab-content');
    for (var i = 0; i < contents.length; i++) {
        contents[i].classList.remove('active');
    }
    document.getElementById(tabId).classList.add('active');

    // 2040 Dynamic Mark Notifications as Read Sync
    if (tabId === 'tab-notifs') {
        var formData = new FormData();
        formData.append('action', 'ilybd_mark_notifications_read');
        fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
            method: 'POST',
            body: formData
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  var navbarBadge = document.querySelector('.nav-link .badge, .badge');
                  if (navbarBadge) {
                      navbarBadge.style.display = 'none';
                  }
                  var tabBadge = document.getElementById('db-notif-badge');
                  if (tabBadge) {
                      tabBadge.style.display = 'none';
                  }
              }
          }).catch(err => console.log("Read sync error: ", err));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // 2040 Dynamic URL Tab Routing Integration
    var urlParams = new URLSearchParams(window.location.search);
    var urlAction = urlParams.get('action');
    if (urlAction) {
        var actionToTab = {
            'notifications': 'tab-notifs',
            'wallet': 'tab-wallet',
            'add-post': 'tab-add-post',
            'referral': 'tab-referral',
            'referrals': 'tab-referral',
            'chat': 'tab-chat-inbox',
            'settings': 'tab-profile-settings',
            'stories': 'tab-stories'
        };
        var targetTabId = actionToTab[urlAction];
        if (targetTabId) {
            var tabs = document.getElementsByClassName('db-tab-btn');
            for (var i = 0; i < tabs.length; i++) {
                var clickAttr = tabs[i].getAttribute('onclick');
                if (clickAttr && clickAttr.indexOf("'" + targetTabId + "'") !== -1) {
                    switchTab(tabs[i], targetTabId);
                    break;
                }
            }
        }
    }
    var clearBtn = document.getElementById('clear-notifs-btn');
    if(clearBtn) {
        clearBtn.addEventListener('click', function() {
            clearBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Clearing...';
            // Send AJAX request
            var formData = new FormData();
            formData.append('action', 'ilybd_clear_notifications');
            
            var formAjaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";
            fetch(formAjaxUrl, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      document.getElementById('notifs-list-container').innerHTML = '<p style="padding:30px; text-align:center; color:#8b949e;">কোনো নতুন নোটিফিকেশন নেই।</p>';
                      clearBtn.style.display = 'none';
                      
                      // Also clear notifications count in navbar
                      var badge = document.querySelector('.nav-link .badge');
                      if(badge) {
                          badge.style.display = 'none';
                      }
                      
                      // Clear in tab button
                      var tabBtn = document.querySelector('button[onclick="switchTab(this, \'tab-notifs\')"]');
                      if(tabBtn) {
                          tabBtn.innerHTML = '<i class="fa-solid fa-bell"></i> নোটিফিকেশনস (0)';
                      }
                  } else {
                      clearBtn.innerHTML = '<i class="fa-solid fa-trash-can"></i> মুছে ফেলুন (Clear All)';
                      alert('Error clearing notifications!');
                  }
              }).catch(err => {
                  clearBtn.innerHTML = '<i class="fa-solid fa-trash-can"></i> মুছে ফেলুন (Clear All)';
                  alert('Network Error!');
              });
        });
    }
});

function triggerEditPost(id, title, content, catId) {
    document.getElementById('form_edit_post_id').value = id;
    document.getElementById('form_post_title').value = title;
    
    if (typeof tinymce !== 'undefined' && tinymce.get('form_post_content')) {
        tinymce.get('form_post_content').setContent(content);
    } else {
        document.getElementById('form_post_content').value = content;
    }
    
    var select = document.getElementById('form_post_cat');
    for (var i = 0; i < select.options.length; i++) {
        if (select.options[i].value == catId) {
            select.selectedIndex = i;
            break;
        }
    }
    
    document.getElementById('form-header-title').innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Edit Tune ID: #' + id;
    document.getElementById('cancel_edit_post_btn').style.display = 'inline-block';
    
    // Switch over to composition tab
    var tabs = document.getElementsByClassName('db-tab-btn');
    for(var i=0; i<tabs.length; i++){
        if(tabs[i].innerHTML.indexOf("নতুন টিউন") !== -1){
            switchTab(tabs[i], 'tab-add-post');
            break;
        }
    }
}

function cancelEditPost() {
    document.getElementById('form_edit_post_id').value = 0;
    document.getElementById('form_post_title').value = '';
    
    if (typeof tinymce !== 'undefined' && tinymce.get('form_post_content')) {
        tinymce.get('form_post_content').setContent('');
    } else {
        document.getElementById('form_post_content').value = '';
    }
    
    document.getElementById('form_post_cat').selectedIndex = 0;
    
    document.getElementById('form-header-title').innerHTML = '<i class="fa-solid fa-pen-nib"></i> Compose or Edit Your Tune';
    document.getElementById('cancel_edit_post_btn').style.display = 'none';
    
    // Switch over back to manage listing tab
    var tabs = document.getElementsByClassName('db-tab-btn');
    for(var i=0; i<tabs.length; i++){
        if(tabs[i].innerHTML.indexOf("আমার টিউনস") !== -1){
            switchTab(tabs[i], 'tab-manage-posts');
            break;
        }
    }
}
</script>

<style>
.db-tab-btn {
    background: transparent;
    border: none;
    padding: 15px 20px;
    color: #8b949e;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}
.db-tab-btn:hover {
    color: #fff;
    border-bottom-color: #30363d;
}
.db-tab-btn.active {
    color: #00ff41;
    border-bottom-color: #00ff41;
}
.db-tab-content {
    display: none;
}
.db-tab-content.active {
    display: block;
}
.db-stat-box {
    background: #161b22;
    border: 1px solid #30363d;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.db-stat-box h3 {
    margin: 10px 0 5px 0;
    font-size: 26px;
    color: #fff;
    font-weight: 800;
}
.db-stat-box p {
    margin: 0;
}

.form-row {
    margin-bottom: 20px;
}
.form-row label {
    display: block;
    font-weight: bold;
    font-size: 13px;
    color: #c9d1d9;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-row input, .form-row select, .form-row textarea {
    width: 100%;
    background: #161b22;
    border: 1px solid #30363d;
    border-radius: 8px;
    padding: 12px 15px;
    color: #fff;
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
}
.form-row input:focus, .form-row select:focus, .form-row textarea:focus {
    border-color: #00ff41;
    box-shadow: 0 0 5px rgba(0,255,65,0.2);
}
.submit-action-btn {
    background: #00ff41;
    color: #000;
    border: none;
    padding: 12px 25px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
}
.submit-action-btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}
.cancel-edit-btn {
    background: #30363d;
    color: #fff;
    border: none;
    padding: 12px 25px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
}
.alert {
    padding: 15px;
    margin: 15px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: bold;
}
.alert.success {
    background: rgba(0, 255, 65, 0.1);
    border: 1px solid #00ff41;
    color: #00ff41;
}
.alert.error {
    background: rgba(255, 62, 62, 0.1);
    border: 1px solid #ff3e3e;
    color: #ff3e3e;
}
.post-status {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: bold;
    display: inline-block;
}
.post-status.publish {
    background: rgba(0, 255, 65, 0.1);
    border: 1px solid #00ff41;
    color: #00ff41;
}
.post-status.pending {
    background: rgba(255, 179, 71, 0.1);
    border: 1px solid #ffb347;
    color: #ffb347;
}
.post-status.draft {
    background: rgba(139, 148, 158, 0.1);
    border: 1px solid #8b949e;
    color: #8b949e;
}
.small-edit-btn {
    background: #21262d;
    border: 1px solid #30363d;
    color: #c9d1d9;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
}
.small-edit-btn:hover {
    border-color: #8b949e;
    color: #fff;
}
.status-box-lbl {
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: bold;
    display: inline-block;
}
.status-box-lbl.pending {
    background: rgba(255, 179, 71, 0.1);
    color: #ffb347;
    border: 1px solid rgba(255, 179, 71, 0.3);
}
.status-box-lbl.paid {
    background: rgba(0, 255, 65, 0.1);
    color: #00ff41;
    border: 1px solid rgba(0, 255, 65, 0.3);
}
.status-box-lbl.rejected {
    background: rgba(255, 62, 62, 0.1);
    color: #ff3e3e;
    border: 1px solid rgba(255, 62, 62, 0.3);
}
</style>

<?php 
// Ensure floating messenger popups and messaging networks are loaded natively on the dashboard
if (is_user_logged_in()) {
    get_template_part('template-parts/messenger-box');
}
?>
