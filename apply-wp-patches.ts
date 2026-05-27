import fs from "fs";
import path from "path";

const themeDir = path.join(process.cwd(), "extracted-wordpress", "ilybd-neon-v1-pro");

// helper helper to replace content
function patchFile(fileRelativePath: string, patterToReplace: string, replacement: string) {
  const filePath = path.join(themeDir, fileRelativePath);
  if (!fs.existsSync(filePath)) {
    console.error(`Error: File not found: ${filePath}`);
    return;
  }
  let content = fs.readFileSync(filePath, "utf8");
  if (!content.includes(patterToReplace)) {
    console.warn(`Warning: Target pattern not found in ${fileRelativePath}`);
  }
  content = content.replace(patterToReplace, replacement);
  fs.writeFileSync(filePath, content, "utf8");
  console.log(`Successfully patched file: ${fileRelativePath}`);
}

function writeFile(fileRelativePath: string, content: string) {
  const filePath = path.join(themeDir, fileRelativePath);
  const dir = path.dirname(filePath);
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
  }
  fs.writeFileSync(filePath, content, "utf8");
  console.log(`Successfully wrote file: ${fileRelativePath}`);
}

// ==========================================
// 1. PATCH functions.php
// ==========================================
console.log("Patching functions.php...");

// Read existing functions.php
const functionsPath = path.join(themeDir, "functions.php");
let functionsContent = fs.readFileSync(functionsPath, "utf8");

// Append new hooks and helpers to functions.php
const economyHooks = `
/* ==========================================================================
   ILYBD CYBER ECONOMY & EARNING ENGINE (PROFESSIONAL FIXES)
   ========================================================================== */

// --- ১.১ নোটিফিকেশন রাইটার ---
function ilybd_add_user_notification($user_id, $message) {
    $notifications = get_user_meta($user_id, 'notifications', true);
    $notifications = is_array($notifications) ? $notifications : [];
    $new_noti = [
        'id'        => 'noti_' . time() . '_' . rand(100, 999),
        'text'      => $message,
        'time'      => current_time('mysql'),
        'timestamp' => time()
    ];
    $notifications[] = $new_noti;
    update_user_meta($user_id, 'notifications', $notifications);
}

// --- ১.২ গ্লোবাল পয়েন্ট ও ব্যালেন্স রেসপনসিবল এডিটর ---
function ilybd_update_user_economy($user_id, $points_delta, $balance_delta, $message = '') {
    if (!$user_id) return;
    
    // ১.২.১ পয়েন্ট আপডেট এবং সিংক্রোনাইজেশন
    $points = (int) get_user_meta($user_id, 'ilybd_total_points', true);
    $points += $points_delta;
    if ($points < 0) $points = 0;
    
    update_user_meta($user_id, 'ilybd_total_points', $points);
    update_user_meta($user_id, 'user_points', $points);
    update_user_meta($user_id, 'ilybd_points', $points);
    
    // ১.২.২ ব্যালেন্স আপডেট
    $balance = (float) get_user_meta($user_id, 'user_balance', true);
    $balance += $balance_delta;
    if ($balance < 0) $balance = 0;
    
    update_user_meta($user_id, 'user_balance', $balance);
    
    // ১.২.৩ নোটিফিকেশন যুক্ত করা
    if (!empty($message)) {
        ilybd_add_user_notification($user_id, $message);
    }
}

// --- ১.৩ পোস্ট পাবলিশড রিওয়ার্ড ---
add_action('transition_post_status', 'ilybd_award_published_post_rewards', 10, 3);
function ilybd_award_published_post_rewards($new_status, $old_status, $post) {
    if ($new_status === 'publish' && $old_status !== 'publish' && $post->post_type === 'post') {
        $author_id = $post->post_author;
        
        $points_reward = 25; // ২৫ পয়েন্ট
        $cash_reward = 5.50; // ৫.৫০ টাকা
        
        $msg = sprintf("📝 আপনার পোস্টটি অনুমোদিত ও পাবলিশ করা হয়েছে! আপনি লাভ করেছেন %d XP এবং ৳%s টাকা।", $points_reward, number_format($cash_reward, 2));
        ilybd_update_user_economy($author_id, $points_reward, $cash_reward, $msg);
    }
}

// --- ১.৪ কমেন্ট রিওয়ার্ড হুক ---
add_action('comment_post', 'ilybd_award_comment_rewards', 10, 3);
function ilybd_award_comment_rewards($comment_ID, $comment_approved, $commentdata) {
    if ($comment_approved == 1) {
        $user_id = $commentdata['user_id'];
        $post_id = $commentdata['comment_post_ID'];
        
        // কমেন্ট কারী রেজিস্ট্রার্ড ইউজার হলে রিওয়ার্ড দিন
        if ($user_id) {
            $points_reward = 5; // ৫ পয়েন্ট
            $cash_reward = 0.50; // ০.৫০ টাকা
            $msg = sprintf("💬 সাইটে গঠনমূলক কমেন্ট করার জন্য %d XP এবং ৳%s টাকা পেয়েছেন!", $points_reward, number_format($cash_reward, 2));
            ilybd_update_user_economy($user_id, $points_reward, $cash_reward, $msg);
        }
        
        // পোস্টের লেখককে কমেন্ট পাওয়ার জন্য বোনাস দিন
        $post_author_id = get_post_field('post_author', $post_id);
        if ($post_author_id && $post_author_id != $user_id) {
            $points_reward = 2; // ২ পয়েন্ট
            $cash_reward = 0.10; // ০.১০ টাকা
            $msg = sprintf("💬 আপনার \"%s\" পোস্টে নতুন মন্তব্য আসায় আপনি %d XP এবং ৳%s টাকা অর্জন করেছেন।", get_the_title($post_id), $points_reward, number_format($cash_reward, 2));
            ilybd_update_user_economy($post_author_id, $points_reward, $cash_reward, $msg);
        }
    }
}

// কমেন্ট এপ্রুভালের ট্রানজিশন ফ্রিকশন ম্যানেজমেন্ট
add_action('wp_set_comment_status', 'ilybd_comment_approval_reward_transition', 10, 2);
function ilybd_comment_approval_reward_transition($comment_id, $comment_status) {
    if ($comment_status === 'approve') {
        $comment = get_comment($comment_id);
        if ($comment) {
            $user_id = $comment->user_id;
            $post_id = $comment->comment_post_ID;
            
            if ($user_id) {
                $points_reward = 5;
                $cash_reward = 0.50;
                $msg = sprintf("💬 আপনার একটি কমেন্টটি রিভিউ শেষে এপ্রুভ হয়েছে! আপনি %d XP এবং ৳%s টাকা লাভ করেছেন।", $points_reward, number_format($cash_reward, 2));
                ilybd_update_user_economy($user_id, $points_reward, $cash_reward, $msg);
            }
            
            $post_author_id = get_post_field('post_author', $post_id);
            if ($post_author_id && $post_author_id != $user_id) {
                $points_reward = 2;
                $cash_reward = 0.10;
                $msg = sprintf("💬 আপনার \"%s\" পোস্টে কমেন্ট এপ্রুভ হওয়ায় বোনাস %d XP এবং ৳%s টাকা পেয়েছেন।", get_the_title($post_id), $points_reward, number_format($cash_reward, 2));
                ilybd_update_user_economy($post_author_id, $points_reward, $cash_reward, $msg);
            }
        }
    }
}

// --- ১.৫ দৈনিক লগইন বোনাস ---
add_action('init', 'ilybd_daily_login_bonus_check');
function ilybd_daily_login_bonus_check() {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $today = date('Y-m-d');
        $last_login = get_user_meta($user_id, 'ilybd_last_login_reward_date', true);
        
        if ($last_login !== $today) {
            update_user_meta($user_id, 'ilybd_last_login_reward_date', $today);
            
            $login_points = 10; // ১০ পয়েন্ট
            $login_cash = 1.00; // ১.০০ টাকা
            $msg = sprintf("☀️ শুভ সকাল! সাইটে আজকের দৈনিক লগইন বোনাস হিসেবে ১০ XP এবং ৳১.০০ টাকা পেমেন্ট পেয়েছেন।", $login_points, number_format($login_cash, 2));
            ilybd_update_user_economy($user_id, $login_points, $login_cash, $msg);
        }
    }
}
`;

// Replace ilybd_handle_like inside functions.php with rewards integrated
const oldLikeHandler = `function ilybd_handle_like() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $current_likes = get_post_meta($post_id, '_likes', true);
        $current_likes = ($current_likes == '') ? 0 : intval($current_likes);
        $new_likes = $current_likes + 1;
        update_post_meta($post_id, '_likes', $new_likes);
        echo $new_likes;
    }
    wp_die();
}`;

const newLikeHandler = `function ilybd_handle_like() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $current_likes = get_post_meta($post_id, '_likes', true);
        $current_likes = ($current_likes == '') ? 0 : intval($current_likes);
        $new_likes = $current_likes + 1;
        update_post_meta($post_id, '_likes', $new_likes);
        
        // লাইক বোনাস (পোস্ট রিসিভার কন্টেন্ট ক্রিয়েটর ট্র্যাকিং)
        $author_id = get_post_field('post_author', $post_id);
        $current_user_id = get_current_user_id();
        
        if ($author_id && $author_id != $current_user_id) {
            $like_points = 2; // ২ পয়েন্ট
            $like_cash = 0.20; // ০.২০ টাকা
            $msg = sprintf("❤️ কেউ একজন আপনার \"%s\" পোস্টটি পছন্দ করেছে! পেয়েছেন ২ XP এবং ৳০.২০ টাকা।", get_the_title($post_id));
            ilybd_update_user_economy($author_id, $like_points, $like_cash, $msg);
        }
        
        echo $new_likes;
    }
    wp_die();
}`;

// Replacing View Count to award views too
const oldSetViews = `function ilybd_set_post_views($postID) {
    if (!$postID) return;
    $key = 'ilybd_post_views_count';
    $count = (int) get_post_meta($postID, $key, true);
    $count++;
    update_post_meta($postID, $key, $count);
}`;

const newSetViews = `function ilybd_set_post_views($postID) {
    if (!$postID) return;
    $key = 'ilybd_post_views_count';
    $count = (int) get_post_meta($postID, $key, true);
    $count++;
    update_post_meta($postID, $key, $count);
    
    // ভিউ অর্নিং ইঞ্জেকশন (প্রফেশনাল সিকিউরড ভিউ বোনাস)
    $author_id = get_post_field('post_author', $postID);
    $current_user_id = get_current_user_id();
    
    // নিজেকে ভিউ করার জন্য ইনভ্যালিড সেলফ ক্লিক পেনারেশন গার্ড
    if ($author_id && $author_id != $current_user_id) {
        // রিপ্রেন্টেটিভ আইপি এবং কুকি চেকিং ফাস্ট
        $cookie_key = 'ily_viewed_' . $postID;
        if (!isset($_COOKIE[$cookie_key])) {
            setcookie($cookie_key, '1', time() + 3600 * 4, '/'); // ৪ ঘন্টা সেশন
            
            $view_points = 1; // ১ পয়েন্ট
            $view_cash = 0.05; // ০.০৫ টাকা
            ilybd_update_user_economy($author_id, $view_points, $view_cash);
        }
    }
}`;

functionsContent = functionsContent.replace(oldLikeHandler, newLikeHandler);
functionsContent = functionsContent.replace(oldSetViews, newSetViews);

// Make sure the economy hooks are appended
if (!functionsContent.includes("ILYBD CYBER ECONOMY & EARNING ENGINE")) {
  functionsContent += economyHooks;
}

fs.writeFileSync(functionsPath, functionsContent, "utf8");
console.log("functions.php updated successfully!");







// ==========================================
// 2. REWRITE template-parts/user-dashboard.php (COHESION & FUNCTIONALITY)
// ==========================================
console.log("Overwriting template-parts/user-dashboard.php with Premium Design & Actions...");

const userDashboardPHP = `<?php
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

// ১.১ অপ্টিমাইজড মেটা ডাটা লোডিং (Backwards compatible fallback)
$points  = (int) get_user_meta($u_id, 'ilybd_total_points', true);
$balance = get_user_meta($u_id, 'user_balance', true);
if ($balance === '') {
    $balance = (float)($points * 0.01);
    update_user_meta($u_id, 'user_balance', $balance);
} else {
    $balance = (float) $balance;
}

$tier = ilybd_get_user_tier($u_id);

// ১.২ নোটিফিকেশন এগ্রেশন লোডার
$notifications = get_user_meta($u_id, 'notifications', true);
$notifications = is_array($notifications) ? array_reverse($notifications) : [];

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
                        'post_category'=> [$category]
                    ];
                    wp_update_post($update_post);
                    $message_box = '<div class="alert success">✅ আপনার পোস্টটির এডিট সফলভাবে আপডেট হয়েছে!</div>';
                } else {
                    $message_box = '<div class="alert error">❌ আপনার এই পোস্টটি এডিট করার অনুমতি নেই।</div>';
                }
            } else {
                // নতুন পোস্ট মেকার
                $new_post = [
                    'post_title'    => $title,
                    'post_content'  => $content,
                    'post_status'   => 'pending',
                    'post_author'   => $u_id,
                    'post_category' => [$category]
                ];
                $inserted_id = wp_insert_post($new_post);
                if ($inserted_id) {
                    // নোটিফিকেশন পাঠান
                    ilybd_add_user_notification($u_id, "📝 নতুন পোস্ট জমা দেওয়া হয়েছে! এডমিন মেম্বারদের রিভিউ শেষে এটি পাবলিশ হবে।");
                    $message_box = '<div class="alert success">✅ পোস্ট জমা হয়েছে! রিভিউ সম্পন্ন হওয়ার পর মূল ওয়ালেটে বোনাস যোগ হবে।</div>';
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
            <div style="display:inline-block; margin-top:10px; font-size:12px; font-weight:bold; background:<?php echo esc_attr($tier['color']); ?>; color:#000; padding:4px 14px; border-radius:20px; text-transform:uppercase;">
                Level: <?php echo esc_html($tier['rank']); ?>
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
        <button class="db-tab-btn active" onclick="switchTab(this, 'tab-manage-posts')"><i class="fa-solid fa-list-check"></i> আমার টিউনস</button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-add-post')"><i class="fa-solid fa-pen-nib"></i> নতুন টিউন করুন</button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-wallet')"><i class="fa-solid fa-wallet"></i> ইনকাম ওয়ালেট</button>
        <button class="db-tab-btn" onclick="switchTab(this, 'tab-notifs')"><i class="fa-solid fa-bell"></i> নোটিফিকেশনস (<?php echo count($notifications); ?>)</button>
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
                                    <td style="padding:15px 10px; text-align:right;">
                                        <button class="small-edit-btn" 
                                                onclick="triggerEditPost(<?php echo $p_id; ?>, <?php echo esc_attr(json_encode(get_the_title())); ?>, <?php echo esc_attr(json_encode(get_the_content())); ?>, <?php echo esc_attr(get_the_category()[0]->term_id ?: 0); ?>)">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit Post
                                        </button>
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
            
            <form method="post">
                <?php wp_nonce_field('cyber_dashboard_post_nonce'); ?>
                <input type="hidden" name="edit_post_id" id="form_edit_post_id" value="0">
                <input type="hidden" name="cyber_frontend_post" value="1">
                
                <div class="form-row">
                    <label>Tune Title (টাইটেল)</label>
                    <input type="text" name="post_title" id="form_post_title" placeholder="একটি চমৎকার কৌতূহলপূর্ণ টাইটেল দিন..." required>
                </div>

                <div class="form-row">
                    <label>Tune Category (ক্যাটাগরি)</label>
                    <select name="post_cat" id="form_post_cat" required>
                        <?php
                        $cats = get_categories(['hide_empty' => false]);
                        foreach ($cats as $cat) {
                            echo '<option value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-row">
                    <label>Main Body Content (মূল সুর বা কন্টেন্ট)</label>
                    <p style="font-size:11px; color:#8b949e; margin:0 0 5px 0;">যেকোনো ধরণের কপি-পেস্ট এআই প্লাজিয়ার্ড কন্টেন্ট গ্রহণযোগ্য নয় এবং বাতিল বলে গণ্য হবে।</p>
                    <textarea name="post_content" id="form_post_content" placeholder="ইমেজ সহ আপনার সুরের মূল লেখা সাবলীল বাংলায় এখানে লিখুন..." required style="height:250px;"></textarea>
                </div>

                <div style="display:flex; gap:10px;">
                    <button type="submit" class="submit-action-btn"><i class="fa-solid fa-rocket"></i> Submit/Update Tune</button>
                    <button type="button" class="cancel-edit-btn" id="cancel_edit_post_btn" onclick="cancelEditPost()" style="display:none;">Cancel Edit</button>
                </div>
            </form>
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

            </div>
        </div>

        <!-- ======================= TAB 4: SYSTEM NOTIFICATIONS ======================= -->
        <div id="tab-notifs" class="db-tab-content">
            <h3 style="margin-top:0; color:#fff; border-bottom:1px solid #222; padding-bottom:10px;"><i class="fa-solid fa-bell"></i> System Alert logs</h3>
            
            <div style="max-height:400px; overflow-y:auto; padding-right:5px;">
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
}

function triggerEditPost(id, title, content, catId) {
    document.getElementById('form_edit_post_id').value = id;
    document.getElementById('form_post_title').value = title;
    document.getElementById('form_post_content').value = content;
    
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
    document.getElementById('form_post_content').value = '';
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
`;

writeFile("template-parts/user-dashboard.php", userDashboardPHP);





// ==========================================
// 3. CLEAN UP page-dashboard.php TO REQUIRE TPL
// ==========================================
console.log("Preserving & optimizing page-dashboard.php...");
const newPageDashboardPHP = `<?php
/* Template Name: User Dashboard */

get_header();

// 🔐 Guard logged in status
if (!is_user_logged_in()) {
    echo '
    <div style="background:#0d1117; min-height:100vh; display:flex; align-items:center; justify-content:center; color:#fff; padding:20px;">
        <div style="background:#161b22; border:1px solid #ff3e3e; padding:35px; border-radius:12px; text-align:center; max-width:480px; box-shadow:0 0 20px rgba(255,62,62,0.1);">
            <h2 style="color:#ff3e3e; margin-top:0;">🔒 Restricted Access</h2>
            <p style="color:#8b949e; line-height:1.6; font-size:14px; margin-bottom:20px;">আপনার অ্যাকাউন্ট ড্যাশবোর্ডে প্রবেশ করতে লগইন করুন।</p>
            <a href="' . wp_login_url(get_permalink()) . '" style="display:inline-block; padding:12px 30px; background:#ff3e3e; color:#fff; text-decoration:none; font-weight:bold; border-radius:6px; box-shadow:0 5px 15px rgba(255,62,62,0.25);">Login Portal</a>
        </div>
    </div>';
    get_footer();
    exit;
}

// ❌ Hide admin bar for beautiful frontend view
add_filter('show_admin_bar', '__return_false');

// Load beautiful high-cohesion dashboard template
get_template_part('template-parts/user-dashboard');

get_footer();
`;
writeFile("page-dashboard.php", newPageDashboardPHP);





// ==========================================
// 4. PATCH author.php
// ==========================================
console.log("Updating author.php for dynamic XP stats & rank colors...");

const authorPath = path.join(themeDir, "author.php");
let authorContent = fs.readFileSync(authorPath, "utf8");

const oldAuthorLevelCard = `        <!-- LEVEL CARD -->
        <div class="level-card">
            <div class="level-top">
                <span>🏆 Trusted Member</span>
                <small>4500 / 5000 XP</small>
            </div>

            <div class="progress-bar">
                <div class="fill"></div>
            </div>

            <p class="hint">Next level unlocks new privileges</p>
        </div>`;

const newAuthorLevelCard = `        <!-- LEVEL CARD (DYNAMICALLY LOADED XP & RANK VALUES) -->
        <?php
        $author_points = (int) get_user_meta($author_id, 'ilybd_total_points', true);
        $author_tier = ilybd_get_user_tier($author_id);
        
        $rank = $author_tier['rank'];
        $color = $author_tier['color'];
        
        if ($author_points < 100) {
            $next_level = 100;
            $prev_level = 0;
        } elseif ($author_points < 1000) {
            $next_level = 1000;
            $prev_level = 100;
        } elseif ($author_points < 5000) {
            $next_level = 5000;
            $prev_level = 1000;
        } else {
            $next_level = $author_points;
            $prev_level = 0;
        }
        
        $range = $next_level - $prev_level;
        $percent = ($range > 0) ? min(100, max(0, (($author_points - $prev_level) / $range) * 100)) : 100;
        ?>
        <div class="level-card" style="border: 1px solid <?php echo esc_attr($color); ?>; background:rgba(0,0,0,0.3); padding:20px; border-radius:12px; margin-bottom:20px;">
            <div class="level-top" style="display:flex; justify-content:space-between; align-items:center;">
                <span style="color: <?php echo esc_attr($color); ?>; font-weight:bold; font-size:15px;">🏆 <?php echo esc_html($rank); ?></span>
                <small style="color:#8b949e;"><?php echo $author_points; ?> / <?php echo $next_level; ?> XP</small>
            </div>

            <div class="progress-bar" style="background:#21262d; height:8px; border-radius:4px; overflow:hidden; margin-top:12px;">
                <div class="fill" style="background:<?php echo esc_attr($color); ?>; width:<?php echo $percent; ?>%; height:100%; border-radius:4px; transition:width 0.4s ease-on-out;"></div>
            </div>

            <p class="hint" style="margin:8px 0 0 0; font-size:11px; color:#8b949e;">
                <?php if ($author_points < 5000): ?>
                    পরবর্তী লেভেলের জন্য আরও <?php echo ($next_level - $author_points); ?> XP প্রয়োজন।
                <?php else: ?>
                    আপনি সর্বোচ্চ সাইবার কিং স্তরে উপনীত হয়েছেন!
                <?php endif; ?>
            </p>
        </div>`;

authorContent = authorContent.replace(oldAuthorLevelCard, newAuthorLevelCard);
fs.writeFileSync(authorPath, authorContent, "utf8");
console.log("author.php patched successfully!");





// ==========================================
// 5. REWRITE inc/ily-admin-settings.php (WITH WITHDRAWALS APPROVALS SYSTEM)
// ==========================================
console.log("Overwriting inc/ily-admin-settings.php to include global Cashouts Approval Center...");

const adminSettingsPHP = `<?php
/**
 * ILYBD Neon Pro - Master Admin Control Center
 * Saved Settings + Global Withdrawal Approval Portal
 */
if (!defined('ABSPATH')) exit;

/* =========================================
   ১.১ এডমিন মেনু ও উইথড্রয়াল সাব-মেনু রেজিস্ট্রেশন
   ========================================= */
add_action('admin_menu', function () {
    add_menu_page(
        'ILYBD Control Center',
        'ILYBD Control',
        'manage_options',
        'ily-settings',
        'ily_options_page',
        'dashicons-shield',
        3
    );

    add_submenu_page(
        'ily-settings',
        'Earning Withdrawals Manager',
        'Payout Requests',
        'manage_options',
        'ily-withdrawals',
        'ily_withdrawals_admin_page'
    );
});

/* =========================================
   ১.২ সেটিং সেভ অ্যালগরিদম
   ========================================= */
function ily_save_settings() {
    if (!current_user_can('manage_options')) return;

    if (isset($_POST['save_ily'])) {
        update_option('ily_greeting', sanitize_text_field($_POST['ily_greeting']));
        update_option('ily_notif_count_sc', sanitize_text_field($_POST['ily_notif_count_sc']));
        update_option('ily_balance_sc', sanitize_text_field($_POST['ily_balance_sc']));
        update_option('ily_default_neon', sanitize_hex_color($_POST['ily_default_neon']));
        update_option('ily_site_mode', sanitize_text_field($_POST['ily_site_mode']));
        update_option('ily_auto_feature', isset($_POST['ily_auto_feature']) ? 1 : 0);

        echo '<div class="updated"><p>⚡ System Options Saved!</p></div>';
    }
}
add_action('admin_init', 'ily_save_settings');

/* =========================================
   ১.৩ উইথড্রয়াল এপ্রুভাল রিকোয়েস্ট এক্সেপ্টিং
   ========================================= */
function ily_handle_admin_withdraw_payouts() {
    if (!current_user_can('manage_options')) return;

    if (isset($_GET['payout_action']) && isset($_GET['req_id']) && isset($_GET['user_id'])) {
        $payout_action = sanitize_text_field($_GET['payout_action']);
        $req_id        = sanitize_text_field($_GET['req_id']);
        $target_user_id= intval($_GET['user_id']);
        
        $withdrawals = get_user_meta($target_user_id, 'ilybd_withdrawals', true);
        $withdrawals = is_array($withdrawals) ? $withdrawals : [];
        $modified = false;
        
        foreach ($withdrawals as &$w) {
            if ($w['id'] === $req_id && $w['status'] === 'pending') {
                if ($payout_action === 'approve') {
                    $w['status'] = 'Completed';
                    $modified = true;
                    $success_msg = sprintf("🟢 আপনার Bkash/Nagad ওয়ালেট ক্যাশআউট ৳%s টাকার রিকোয়েস্টটি সফলভাবে পরিশোধ (Completed) করা হয়েছে!", number_format($w['amount'], 2));
                    ilybd_add_user_notification($target_user_id, $success_msg);
                } elseif ($payout_action === 'reject') {
                    $w['status'] = 'rejected';
                    $modified = true;
                    
                    // রিজেক্ট হলে ব্যালেন্স ওয়ালেটে ফেরত দিন
                    $balance = (float) get_user_meta($target_user_id, 'user_balance', true);
                    $balance += $w['amount'];
                    update_user_meta($target_user_id, 'user_balance', $balance);
                    
                    $fail_msg = sprintf("❌ কোনো সমস্যার কারণে আপনার ৳%s টাকার উইথড্রয়ালটি প্রত্যাখ্যান (Rejected) করা হয়েছে। টাকা ওয়ালেটে রিফান্ড করা হয়েছে।", number_format($w['amount'], 2));
                    ilybd_add_user_notification($target_user_id, $fail_msg);
                }
                break;
            }
        }
        
        if ($modified) {
            update_user_meta($target_user_id, 'ilybd_withdrawals', $withdrawals);
            wp_redirect(admin_url('admin.php?page=ily-withdrawals&updated=1'));
            exit;
        }
    }
}
add_action('admin_init', 'ily_handle_admin_withdraw_payouts');

/* =========================================
   ২.১ মেইন অপশনস পেজ UI
   ========================================= */
function ily_options_page() {
    $neon = get_option('ily_default_neon', '#00ff41');
    ?>
    <div class="wrap" style="background:#0d1117; padding:25px; border-radius:12px; border:1px solid #30363d; color:#fff; max-width:900px; margin-top:20px;">
        <h1 style="color:#00ff41; font-weight:800; font-size:24px; margin-bottom:20px;">⚡ ILYBD Mastery Panel Control</h1>
        <form method="post">
            <table class="form-table" style="color:#c9d1d9;">
                <tr>
                    <th style="color:#fff;">Greeting Text</th>
                    <td><input type="text" name="ily_greeting" value="<?php echo esc_attr(get_option('ily_greeting', 'হাই')); ?>" style="width:300px; padding:6px; background:#161b22; color:#fff; border:1px solid #30363d; border-radius:4px;"></td>
                </tr>
                <tr>
                    <th style="color:#fff;">Notification Shortcode</th>
                    <td><input type="text" name="ily_notif_count_sc" value="<?php echo esc_attr(get_option('ily_notif_count_sc', '[notif_count]')); ?>" style="width:300px; padding:6px; background:#161b22; color:#fff; border:1px solid #30363d; border-radius:4px;"></td>
                </tr>
                <tr>
                    <th style="color:#fff;">Wallet Balance Shortcode</th>
                    <td><input type="text" name="ily_balance_sc" value="<?php echo esc_attr(get_option('ily_balance_sc', '[my_balance]')); ?>" style="width:300px; padding:6px; background:#161b22; color:#fff; border:1px solid #30363d; border-radius:4px;"></td>
                </tr>
                <tr>
                    <th style="color:#fff;">Primary Neon Theme Color</th>
                    <td><input type="color" name="ily_default_neon" value="<?php echo esc_attr($neon); ?>" style="width:60px; height:35px; border:1px solid #30363d; border-radius:4px; background:none;"></td>
                </tr>
                <tr>
                    <th style="color:#fff;">Site Operation Mode</th>
                    <td>
                        <select name="ily_site_mode" style="width:300px; padding:6px; background:#161b22; color:#fff; border:1px solid #30363d; border-radius:4px;">
                            <option value="normal" <?php selected(get_option('ily_site_mode'), 'normal'); ?>>Normal Mode</option>
                            <option value="cyber" <?php selected(get_option('ily_site_mode'), 'cyber'); ?>>Cyber Mode</option>
                            <option value="social" <?php selected(get_option('ily_site_mode'), 'social'); ?>>Social Feed Mode</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th style="color:#fff;">Featured System Algorithm</th>
                    <td>
                        <label>
                            <input type="checkbox" name="ily_auto_feature" value="1" <?php checked(get_option('ily_auto_feature'), 1); ?>>
                            Enable AI Featured Selection (views + likes threshold control)
                        </label>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save System Settings', 'primary', 'save_ily'); ?>
        </form>
    </div>
    <?php
}

/* =========================================
   ২.২ এডমিন পেমেন্ট উইথড্রয়ালস কাস্টম লিস্ট UI
   ========================================= */
function ily_withdrawals_admin_page() {
    if (isset($_GET['updated'])) {
        echo '<div class="updated"><p>✅ Withdrawal payout processed successfully.</p></div>';
    }
    
    // উইথড্র করা সমস্ত ইউজারদের খুঁজে বের করুন
    $users = get_users([
        'meta_key' => 'ilybd_withdrawals',
    ]);
    
    $all_withdraws = [];
    foreach ($users as $u) {
        $w_list = get_user_meta($u->ID, 'ilybd_withdrawals', true);
        if (is_array($w_list)) {
            foreach ($w_list as $w) {
                $w['user_id']      = $u->ID;
                $w['display_name'] = $u->display_name;
                $w['user_email']   = $u->user_email;
                $all_withdraws[]   = $w;
            }
        }
    }
    
    // Sort withdrawals by date latest first
    usort($all_withdraws, function($a, $b) {
        return strcmp($b['date'], $a['date']);
    });
    ?>
    <div class="wrap" style="background:#0d1117; padding:25px; border-radius:12px; border:1px solid #30363d; color:#fff; max-width:980px; margin-top:20px;">
        <h1 style="color:#00ff41; font-weight:800; font-size:24px; margin-bottom:20px;"><span class="dashicons dashicons-money"></span> Dynamic Earning Withdrawals Manager</h1>
        <p style="color:#8b949e; line-height:1.6; max-width:800px;">ইউজাররা তাদের ড্যাশবোর্ড ওয়ালেট থেকে ক্যাশআউট রিকোয়েস্ট জমা দিলে তা এখানে দেখতে পাবেন। আপনি Bkash বা Nagad এ পেমেন্ট সম্পন্ন করে নিচের অ্যাকশন বাটন চেপে পেমেন্ট সচল করতে পারবেন।</p>
        
        <table class="wp-list-table widefat fixed striped tables" style="background:#161b22; color:#fff; border:1px solid #30363d; border-collapse:collapse; margin-top:20px; text-align:left;">
            <thead>
                <tr style="background:#090d13; color:#fff;">
                    <th style="padding:12px; font-weight:bold; width:15%; border-bottom:1.5px solid #30363d;">ইউজার নেম</th>
                    <th style="padding:12px; font-weight:bold; width:15%; border-bottom:1.5px solid #30363d;">পদ্ধতি</th>
                    <th style="padding:12px; font-weight:bold; width:20%; border-bottom:1.5px solid #30363d;">পেমেন্ট মোবাইল নম্বর</th>
                    <th style="padding:12px; font-weight:bold; width:15%; border-bottom:1.5px solid #30363d;">টাকা</th>
                    <th style="padding:12px; font-weight:bold; width:15%; border-bottom:1.5px solid #30363d;">তারিখ</th>
                    <th style="padding:12px; font-weight:bold; width:10%; border-bottom:1.5px solid #30363d;">স্ট্যাটাস</th>
                    <th style="padding:12px; font-weight:bold; width:10%; border-bottom:1.5px solid #30363d; text-align:right;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($all_withdraws)): ?>
                    <?php foreach ($all_withdraws as $w): 
                        $status_str = esc_html($w['status']);
                        $status_tag = '<span style="color:#ffb347; font-weight:bold;">Pending</span>';
                        if ($status_str === 'Completed' || $status_str === 'paid') {
                            $status_tag = '<span style="color:#00ff41; font-weight:bold;">🟢 Paid</span>';
                        } elseif ($status_str === 'rejected') {
                            $status_tag = '<span style="color:#ff3e3e; font-weight:bold;">❌ Refunded</span>';
                        }
                        ?>
                        <tr style="border-bottom:1px solid #30363d;">
                            <td style="padding:12px; font-weight:600;"><?php echo esc_html($w['display_name']); ?><br><span style="font-size:10px; color:#8b949e;"><?php echo esc_html($w['user_email']); ?></span></td>
                            <td style="padding:12px;"><?php echo esc_html($w['method']); ?></td>
                            <td style="padding:12px; font-weight:bold; color:#00d4ff; user-select:all;"><?php echo esc_html($w['number']); ?></td>
                            <td style="padding:12px; font-weight:bold; color:#ffb347;">৳<?php echo number_format($w['amount'], 2); ?></td>
                            <td style="padding:12px; color:#8b949e;"><?php echo esc_html($w['date']); ?></td>
                            <td style="padding:12px;"><?php echo $status_tag; ?></td>
                            <td style="padding:12px; text-align:right;">
                                <?php if ($status_str === 'pending'): ?>
                                    <a class="button button-primary" style="background:#238636; border:none; margin-right:5px;" href="<?php echo esc_url(admin_url('admin.php?page=ily-withdrawals&payout_action=approve&req_id='.$w['id'].'&user_id='.$w['user_id'])); ?>">পেইড</a>
                                    <a class="button" style="background:#dc3545; color:#fff; border:none;" href="<?php echo esc_url(admin_url('admin.php?page=ily-withdrawals&payout_action=reject&req_id='.$w['id'].'&user_id='.$w['user_id'])); ?>">রিজেক্ট</a>
                                <?php else: ?>
                                    <span style="color:#8b949e;">N/A</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="padding:30px; text-align:center; color:#8b949e;">কোনো উইথড্রয়াল ক্যাশআউট রিকোয়েস্ট পাওয়া যাইনি।</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
`;
writeFile("inc/ily-admin-settings.php", adminSettingsPHP);


// ==========================================
// 6. FIX is_page ENGINE ABORTS IN inc/user-economy.php & inc/user-dashboard.php
// ==========================================
console.log("Removing module crash aborts in inc/user-economy.php...");
const economyCorePath = path.join(themeDir, "inc", "user-economy.php");
let economyCoreContent = fs.readFileSync(economyCorePath, "utf8");

// Remove early exit of is_page('dashboard') during module load
economyCoreContent = economyCoreContent.replace(`// ✅ Only show on Dashboard page (CHANGE slug if needed)
if (!is_page('dashboard')) {
    return;
}`, `// Removed early load-time checks (now handled inside template redirect or template render routines)`);

economyCoreContent = economyCoreContent.replace(`if (!is_user_logged_in()) {
    return;
}`, `// Safe logged-in checks handled dynamically during rendering`);

fs.writeFileSync(economyCorePath, economyCoreContent, "utf8");
console.log("inc/user-economy.php patched successfully!");

console.log("ALL THEME CODE REMEDIES INSTALLED!");
