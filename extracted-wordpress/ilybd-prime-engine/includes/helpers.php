<?php
/**
 * Includes: Global Helpers
 * Path: includes/helpers.php
 * Description: Reusable functions for the entire plugin.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ইউজারের কারেন্ট ব্যালেন্স চেক করা
function ilybd_get_user_balance($user_id) {
    global $wpdb;
    $table = $wpdb->prefix . 'ilybd_wallet';
    $balance = $wpdb->get_var($wpdb->prepare("SELECT balance FROM $table WHERE user_id = %d", $user_id));
    return $balance ? $balance : 0;
}

// ইনকাম অ্যাড করা (রেভিনিউ শেয়ার মডিউলের জন্য দরকার)
function ilybd_add_user_earnings($user_id, $amount) {
    global $wpdb;
    $table = $wpdb->prefix . 'ilybd_wallet';
    $wpdb->query($wpdb->prepare(
        "INSERT INTO $table (user_id, balance) VALUES (%d, %f) 
         ON DUPLICATE KEY UPDATE balance = balance + %f",
        $user_id, $amount, $amount
    ));
}
