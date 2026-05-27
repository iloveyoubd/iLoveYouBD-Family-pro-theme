<?php
/**
 * Includes: AJAX Actions
 * Path: includes/ajax-actions.php
 * Description: Securely handles Download and Reward requests.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ডাউনলোড শুরু করার হ্যান্ডলার
add_action('wp_ajax_ilybd_start_download', 'ilybd_process_download_ajax');
add_action('wp_ajax_nopriv_ilybd_start_download', 'ilybd_process_download_ajax');

function ilybd_process_download_ajax() {
    // সিকিউরিটি চেক (Nonce)
    check_ajax_referer('ilybd_secure_nonce', 'security');

    $video_url = isset($_POST['video_url']) ? esc_url_raw($_POST['video_url']) : '';
    
    if ( empty($video_url) ) {
        wp_send_json_error(array('message' => 'ইউআরএল খুঁজে পাওয়া যায়নি!'));
    }

    // এখানে এপিআই ব্যালেন্সার লজিক কল হবে
    // আপাতত একটি স্যাম্পল রেসপন্স
    $download_link = "https://server.ilybd.com/dl/4k-video-id-123";

    wp_send_json_success(array(
        'download_link' => $download_link,
        'message'       => 'আপনার লিঙ্কটি রেডি!'
    ));
}
