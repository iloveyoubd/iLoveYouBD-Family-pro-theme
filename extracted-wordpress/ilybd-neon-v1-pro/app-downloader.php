<?php
/*
Template Name: App Downloader Tunnel Pro
*/

// ================= SECURITY GATE =================
if (!isset($_GET['app_id'])) {
    wp_die("Invalid Request ❌");
}

$post_id = intval($_GET['app_id']);

// Validate post
if (get_post_type($post_id) !== 'apps') {
    wp_die("Invalid App ID ❌");
}

// Get download URL (your custom meta)
$original_url = get_post_meta($post_id, '_app_download_link', true);

// Fallback safety (optional)
if (!$original_url) {
    wp_die("Download link not found ⚠️");
}

// File name
$file_name = sanitize_title(get_the_title($post_id)) . ".apk";

// ================= OPTIONAL: DOWNLOAD LOG (future analytics) =================
update_post_meta($post_id, '_app_download_count', (int)get_post_meta($post_id, '_app_download_count', true) + 1);

// ================= CLEAN OUTPUT BUFFER =================
if (ob_get_level()) {
    ob_end_clean();
}

// ================= DOWNLOAD HEADERS =================
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.android.package-archive');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: public');
header('Content-Length: 0');

// ================= STREAM FILE =================
readfile($original_url);
exit;