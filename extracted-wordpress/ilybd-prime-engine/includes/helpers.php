<?php
/**
 * Includes: Global Helpers
 * Path: includes/helpers.php
 * Description: Reusable functions for the entire plugin.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ইউজারের ওয়ালেট টেবিল ইনিশিয়ালাইজ ও সেলফ-হিলিং সিংক্রোনাইজ নিশ্চিত করা (Legacy Meta Fallback Engine)
function ilybd_ensure_user_wallet_initialized($user_id) {
    if (!$user_id) return null;
    global $wpdb;
    $table_wallet = $wpdb->prefix . 'ilybd_wallet';
    
    // চেক করা টেবিল ডাটাবেজে সঠিক আছে কি না
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_wallet'") !== $table_wallet) {
        return null;
    }
    
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_wallet WHERE user_id = %d", $user_id));
    
    if (!$row) {
        // ডাটাবেস রো নেই! ইউজার মেটা থেকে হিস্টোরি পয়েন্ট ও ব্যালেন্স রি-স্টোর করা হচ্ছে
        $meta_pts = (int) get_user_meta($user_id, 'ilybd_total_points', true);
        if (!$meta_pts) $meta_pts = (int) get_user_meta($user_id, 'ilybd_points', true);
        if (!$meta_pts) $meta_pts = (int) get_user_meta($user_id, 'user_points', true);
        
        $meta_bal = get_user_meta($user_id, 'user_balance', true);
        if ($meta_bal === '' || $meta_bal === false) {
            $meta_bal = (float)($meta_pts * 0.01);
        } else {
            $meta_bal = (float) $meta_bal;
        }
        $u_level = floor($meta_pts / 500) + 1;
        if ($u_level < 1) $u_level = 1;
        
        $wpdb->insert($table_wallet, array(
            'user_id'      => $user_id,
            'points'       => $meta_pts,
            'balance'      => $meta_bal,
            'user_level'   => $u_level,
            'total_earned' => $meta_bal
        ));
        
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_wallet WHERE user_id = %d", $user_id));
    } else {
        // রো আছে, ব্যালেন্স ০.০ এবং/অথবা পয়েন্ট ০ হলে ব্যাক আপ থেকে এবং ট্রানজেকশন লেজার থেকে সিঙ্ক ট্র্যাকিং করুন
        $needs_update = false;
        $update_data = array();

        // ১. পয়েন্ট রিস্টোর ট্র্যাকিং
        if ($row->points == 0) {
            $meta_pts = (int) get_user_meta($user_id, 'ilybd_total_points', true);
            if (!$meta_pts) $meta_pts = (int) get_user_meta($user_id, 'ilybd_points', true);
            if (!$meta_pts) $meta_pts = (int) get_user_meta($user_id, 'user_points', true);
            if ($meta_pts > 0) {
                $update_data['points'] = $meta_pts;
                $update_data['user_level'] = max(1, floor($meta_pts / 500) + 1);
                $needs_update = true;
            }
        }

        // ২. ব্যালেন্স সেলফ-হিলিং এবং ক্র্যাশ সিঙ্ক রিস্টোর
        if ($row->balance == 0.0) {
            $meta_bal = get_user_meta($user_id, 'user_balance', true);
            if ($meta_bal !== '' && $meta_bal !== false && (float)$meta_bal > 0.0) {
                $meta_bal = (float) $meta_bal;
            } else {
                $meta_bal = 0.0;
            }

            // যদি মেটা-ব্যালেন্স জিরো থাকে, তবে আমরা লেজার ট্রানজেকশন সাম থেকে ব্যালেন্স রিকনস্ট্রাক্ট করব
            if ($meta_bal <= 0.0) {
                $table_ledger = $wpdb->prefix . 'ilybd_ledger';
                if ($wpdb->get_var("SHOW TABLES LIKE '$table_ledger'") == $table_ledger) {
                    $ledger_sum = (float) $wpdb->get_var($wpdb->prepare(
                        "SELECT SUM(amount) FROM $table_ledger WHERE user_id = %d AND currency = 'BDT'", $user_id
                    ));
                    if ($ledger_sum > 0.0) {
                        $meta_bal = $ledger_sum;
                    }
                }
            }

            // তাও যদি জিরো থাকে এবং ইউজারের পয়েন্ট থাকে, তবে ১ পয়েন্ট = ০.০১ টাকা হিসেবে কনভার্ট করে ব্যালেন্স পুনরুদ্ধার করব
            if ($meta_bal <= 0.0) {
                $check_pts = isset($update_data['points']) ? $update_data['points'] : (int) $row->points;
                if ($check_pts > 0) {
                    $meta_bal = (float) ($check_pts * 0.01);
                }
            }

            if ($meta_bal > 0.0) {
                $update_data['balance'] = $meta_bal;
                if (!isset($row->total_earned) || $row->total_earned <= 0.0) {
                    $update_data['total_earned'] = $meta_bal;
                }
                $needs_update = true;
            }
        }

        if ($needs_update && !empty($update_data)) {
            $wpdb->update($table_wallet, $update_data, array('user_id' => $user_id));
            $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_wallet WHERE user_id = %d", $user_id));
        }
    }
    
    // থিম ও উইজেটের সাথে সম্পূর্ণ সিঙ্ক ব্যাক
    if ($row) {
        update_user_meta($user_id, 'user_balance', (float) $row->balance);
        update_user_meta($user_id, 'ilybd_total_points', (int) $row->points);
        update_user_meta($user_id, 'ilybd_points', (int) $row->points);
        update_user_meta($user_id, 'user_points', (int) $row->points);
        update_user_meta($user_id, 'ilybd_user_level', (int) $row->user_level);
    }
    
    return $row;
}

// ইউজারের কারেন্ট ব্যালেন্স চেক করা
function ilybd_get_user_balance($user_id) {
    $row = ilybd_ensure_user_wallet_initialized($user_id);
    return $row ? (float)$row->balance : 0.0;
}

// ইনকাম অ্যাড করা (রেভিনিউ শেয়ার মডিউলের জন্য দরকার)
function ilybd_add_user_earnings($user_id, $amount) {
    ilybd_add_user_balance_or_points($user_id, $amount, 0, "প্রিমিয়াম অ্যাড রেভিনিউ কন্ট্রিবিউশন বোনাস");
}

// লেনদেন রেকর্ড বুক (লেজার রেজিস্ট্রি)
function ilybd_add_ledger_transaction($user_id, $amount, $currency, $reason, $link_id = '', $link_type = 'other') {
    global $wpdb;
    $table = $wpdb->prefix . 'ilybd_ledger';
    $wpdb->insert($table, array(
        'user_id' => $user_id,
        'amount' => $amount,
        'currency' => $currency,
        'reason' => $reason,
        'link_id' => $link_id,
        'link_type' => $link_type,
        'timestamp' => current_time('mysql')
    ));
}

// ব্যালেন্স বা পয়েন্ট যোগ/বিয়োগ মেথড এবং অটোমেটিক লেজার রেকর্ডিং (২০৪০ হাই-টেক কোএলাইন্ড)
function ilybd_add_user_balance_or_points($user_id, $balance_diff, $points_diff, $reason, $link_id = '', $link_type = 'other') {
    global $wpdb;
    $table_wallet = $wpdb->prefix . 'ilybd_wallet';
    
    // নিশ্চিত করুন ইউজার অবজেক্ট তৈরি এবং হিলিং সম্পন্ন হয়েছে
    $row = ilybd_ensure_user_wallet_initialized($user_id);
    if (!$row) return;
    
    // ব্যালেন্স আপডেট করা
    if ($balance_diff != 0) {
        $wpdb->query($wpdb->prepare(
            "UPDATE $table_wallet SET balance = balance + %f, total_earned = total_earned + %f WHERE user_id = %d",
            $balance_diff, $balance_diff > 0 ? $balance_diff : 0, $user_id
        ));
        $current_b = $wpdb->get_var($wpdb->prepare("SELECT balance FROM $table_wallet WHERE user_id = %d", $user_id));
        update_user_meta($user_id, 'user_balance', (float) $current_b);
        ilybd_add_ledger_transaction($user_id, $balance_diff, 'BDT', $reason, $link_id, $link_type);
    }
    
    // পয়েন্ট আপডেট করা
    if ($points_diff != 0) {
        $wpdb->query($wpdb->prepare(
            "UPDATE $table_wallet SET points = points + %d WHERE user_id = %d",
            $points_diff, $user_id
        ));
        
        $current_pts = $wpdb->get_var($wpdb->prepare("SELECT points FROM $table_wallet WHERE user_id = %d", $user_id));
        $new_level = floor($current_pts / 500) + 1;
        if ($new_level < 1) $new_level = 1;
        $wpdb->update($table_wallet, array('user_level' => $new_level), array('user_id' => $user_id));
        
        update_user_meta($user_id, 'user_points', $current_pts);
        update_user_meta($user_id, 'ilybd_points', $current_pts);
        update_user_meta($user_id, 'ilybd_total_points', $current_pts);
        update_user_meta($user_id, 'ilybd_user_level', $new_level);
        ilybd_add_ledger_transaction($user_id, $points_diff, 'XP', $reason, $link_id, $link_type);
    }
}

