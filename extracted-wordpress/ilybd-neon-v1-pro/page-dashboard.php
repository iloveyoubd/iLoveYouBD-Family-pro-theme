<?php
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
