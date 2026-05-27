<?php
/**
 * Master Plan: Brand Mail Engine & Global Identity
 * Project: iLoveYouBD. Com | IBD Cyber Platform
 */

// 1. Sender Branding
add_filter('wp_mail_from_name', function($old) {
    return 'iLoveYouBD. Com';
});

add_filter('wp_mail_from', function($old) {
    return 'support@iloveyoubd.com';
});

// 2. Pro Login Branding
add_action('login_enqueue_scripts', function() {
    $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('<?php echo $logo_url; ?>') !important;
            height: 100px;
            width: 100%;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        body.login { background: #0d1117 !important; color: #fff; }
        .login form { background: #161b22 !important; border: 1px solid #30363d !important; }
    </style>
    <?php
});

add_filter('login_headerurl', function() { return home_url(); });
add_filter('login_headertext', function() { return 'Powered by IBD Cyber Platform'; });

// 3. SMTP Engine (No Plugin)
add_action('phpmailer_init', 'ibd_cyber_smtp_config');
function ibd_cyber_smtp_config($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'mail.iloveyoubd.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 465;
    $phpmailer->Username   = 'support@iloveyoubd.com';
    $phpmailer->Password   = 'support@74'; 
    $phpmailer->SMTPSecure = 'ssl';
}

// 4. Custom Password Reset Template (Global English)
add_filter('retrieve_password_message', 'ibd_cyber_custom_password_reset_mail', 10, 4);
function ibd_cyber_custom_password_reset_mail($message, $key, $user_login, $user_data) {
    $reset_link = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
    
    $content = '
    <h2 style="color: #00ffcc; text-align: center;">Password Reset Request</h2>
    <p>Hi <strong>' . $user_login . '</strong>,</p>
    <p>We received a request to reset the password for your account. Click the secure button below to proceed:</p>
    <center>
        <a href="' . $reset_link . '" style="background-color: #00ffcc; color: #000; padding: 14px 30px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block; margin: 25px 0; text-transform: uppercase; font-size: 14px;">Reset My Password</a>
    </center>
    <p style="font-size: 13px; color: #888;">If you did not request this, please ignore this email. Your account remains secure.</p>';

    return $content;
}

/**
 * 5. Global Pro Template with Platform Features
 * Your Master Plan: Content Sharing, Earning & Verified Status
 */
add_filter('wp_mail', 'ibd_cyber_global_email_template');
function ibd_cyber_global_email_template($args) {
    $logo_url = get_template_directory_uri() . '/assets/images/logo.png';
    $site_name = 'iLoveYouBD. Com';
    
    $header = '
    <div style="background-color: #0d1117; color: #ffffff; padding: 30px; font-family: \'Segoe UI\', Tahoma, sans-serif; border: 1px solid #30363d; max-width: 600px; margin: auto; border-radius: 8px;">
        <center>
            <img src="' . $logo_url . '" alt="' . $site_name . '" style="width: 140px; margin-bottom: 20px;">
            <div style="height: 1px; background: linear-gradient(to right, transparent, #00ffcc, transparent); margin-bottom: 30px;"></div>
        </center>
        <div style="line-height: 1.6; font-size: 15px;">';
    
    $footer = '
        </div>
        <div style="margin-top: 40px; padding: 20px; background-color: #161b22; border-radius: 6px; border: 1px dashed #00ffcc; text-align: center;">
            <h4 style="color: #00ffcc; margin: 0 0 15px 0; text-transform: uppercase; letter-spacing: 1px;">IBD Cyber Platform Features</h4>
            <table width="100%" cellspacing="0" cellpadding="5" style="color: #ccc; font-size: 12px; text-align: center;">
                <tr>
                    <td>⚡ <strong>Content Sharing</strong><br>Viral Loop System</td>
                    <td>💰 <strong>Earning Module</strong><br>Like, Comment & Earn</td>
                    <td>✅ <strong>Verified Access</strong><br>SEO-First Secure Identity</td>
                </tr>
            </table>
        </div>
        <div style="margin-top: 30px; text-align: center; border-top: 1px solid #333; padding-top: 20px;">
            <p style="font-size: 11px; color: #666; margin: 5px 0;">
                &copy; ' . date("Y") . ' ' . $site_name . ' | The Ultimate Cyber Ecosystem.
            </p>
            <a href="' . home_url() . '" style="color: #00ffcc; text-decoration: none; font-size: 12px;">Official Website</a>
        </div>
    </div>';

    $args['message'] = $header . $args['message'] . $footer;
    return $args;
}

add_filter('wp_mail_content_type', function() { return 'text/html'; });
