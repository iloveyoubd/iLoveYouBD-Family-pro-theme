<?php
if (!defined('ABSPATH')) exit;

// ১. গেম কোড সেভ এবং কম্পাইল
add_action('wp_ajax_cyber_studio_save', 'cyber_master_save');
function cyber_master_save() {
    $u_id = get_current_user_id();
    if (!$u_id) wp_send_json_error('Unauthorized');

    $code = stripslashes($_POST['code']);
    $g_name = sanitize_title($_POST['game_name']);
    $rel_path = 'cyber-studio/projects/user_' . $u_id . '/' . $g_name;
    $abs_path = ABSPATH . $rel_path;

    if (!file_exists($abs_path)) wp_mkdir_p($abs_path);

    $phaser = 'https://cdn.jsdelivr.net/npm/phaser@3.60.0/dist/phaser.min.js';
    $html = "<!DOCTYPE html><html><head><script src='{$phaser}'></script><style>body{margin:0;background:#000;display:flex;justify-content:center;align-items:center;height:100vh;}</style></head><body><script>{$code}</script></body></html>";

    if(file_put_contents($abs_path . '/index.html', $html)) {
        wp_send_json_success(['url' => home_url($rel_path . '/index.html')]);
    }
    wp_send_json_error('Save Failed');
}

// ২. এসেট আপলোড সিস্টেম
add_action('wp_ajax_cyber_asset_upload', 'cyber_master_upload');
function cyber_master_upload() {
    $u_id = get_current_user_id();
    if (!$u_id || empty($_FILES['asset_file'])) wp_send_json_error('Error');

    $file = $_FILES['asset_file'];
    $name = sanitize_file_name($file['name']);
    $rel_up = 'cyber-studio/uploads/user_' . $u_id . '/';
    if (!file_exists(ABSPATH . $rel_up)) wp_mkdir_p(ABSPATH . $rel_up);

    if (move_uploaded_file($file['tmp_name'], ABSPATH . $rel_up . $name)) {
        $url = home_url($rel_up . $name);
        wp_send_json_success(['url' => $url, 'snippet' => "this.load.image('asset_".time()."', '{$url}');"]);
    }
    wp_die();
}

// ৩. ZIP প্যাকেজ তৈরি (পাওয়ার লেভেল চেক ছাড়া)
add_action('wp_ajax_cyber_build_apk', 'cyber_master_build');
function cyber_master_build() {
    $u_id = get_current_user_id();
    $g_name = sanitize_title($_POST['game_name']);
    $g_path = ABSPATH . 'cyber-studio/projects/user_' . $u_id . '/' . $g_name . '/';
    $zip_p = $g_path . $g_name . '.zip';

    if (!file_exists($g_path)) wp_send_json_error('Run game first');

    $zip = new ZipArchive();
    if ($zip->open($zip_p, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($g_path));
        foreach ($files as $f) { 
            if (!$f->isDir() && strpos($f->getFilename(), '.zip') === false) {
                $zip->addFile($f->getRealPath(), substr($f->getRealPath(), strlen($g_path))); 
            }
        }
        $zip->close();
        wp_send_json_success(['message' => 'ZIP Package Ready!', 'download_url' => home_url('cyber-studio/projects/user_' . $u_id . '/' . $g_name . '/' . $g_name . '.zip')]);
    }
    wp_die();
}
