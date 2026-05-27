<?php
/**
 * Module: Security Shield
 * Path: modules/security/shield.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function ilybd_security_headers() {
    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
}
add_action('send_headers', 'ilybd_security_headers');

// এপিআই রিকোয়েস্ট সিকিউরিটি চেক
function ilybd_verify_api_request($request_token) {
    $secret = get_option('ilybd_security_key', 'ILYBD_SECURE_786');
    if ($request_token !== hash('sha256', $secret)) {
        wp_die('Unauthorized API Access!');
    }
}
