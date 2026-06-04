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
