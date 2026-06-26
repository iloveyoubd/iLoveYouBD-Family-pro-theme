<?php
/**
 * Includes: DB Setup
 * Path: includes/db-setup.php
 * Description: Creates and updates Wallet and Stats tables in DB.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function ilybd_initialize_db_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // ১. ওয়ালেট টেবিল (ব্যালেন্স ও পয়েন্টের জন্য)
    $table_wallet = $wpdb->prefix . 'ilybd_wallet';
    $sql_wallet = "CREATE TABLE IF NOT EXISTS $table_wallet (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        balance float DEFAULT 0,
        points bigint(20) DEFAULT 0,
        user_level bigint(20) DEFAULT 1,
        total_earned float DEFAULT 0,
        last_update datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        UNIQUE KEY user_id (user_id)
    ) $charset_collate;";

    // ২. আর্নিং স্ট্যাটাস টেবিল (প্রতিটি ডাউনলোডের ইনকাম ট্র্যাকিং)
    $table_stats = $wpdb->prefix . 'ilybd_stats';
    $sql_stats = "CREATE TABLE IF NOT EXISTS $table_stats (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        post_id bigint(20) NOT NULL,
        amount float DEFAULT 0,
        ip_address varchar(50) DEFAULT '',
        timestamp datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    // ৩. রিয়াল-টাইম রেভিনিউ ও এক্সপি লেনদেন লেজার টেবিল (২০৪০ অন-চেইন স্টাইল)
    $table_ledger = $wpdb->prefix . 'ilybd_ledger';
    $sql_ledger = "CREATE TABLE IF NOT EXISTS $table_ledger (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        amount float DEFAULT 0,
        currency varchar(10) DEFAULT 'BDT',
        reason text NOT NULL,
        link_id varchar(100) DEFAULT '',
        link_type varchar(50) DEFAULT 'other',
        timestamp datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_wallet );
    dbDelta( $sql_stats );
    dbDelta( $sql_ledger );

    // Manual DB Patch to ensure columns user_level and total_earned exist on existing installs
    $columns = $wpdb->get_col("DESC $table_wallet");
    if ( ! empty( $columns ) ) {
        if ( ! in_array( 'user_level', $columns ) ) {
            $wpdb->query( "ALTER TABLE $table_wallet ADD COLUMN user_level bigint(20) DEFAULT 1 AFTER points" );
        }
        if ( ! in_array( 'total_earned', $columns ) ) {
            $wpdb->query( "ALTER TABLE $table_wallet ADD COLUMN total_earned float DEFAULT 0 AFTER user_level" );
        }
    }
}

// প্লাগিন যখনই রান হবে এই সেটআপ চেক করবে
add_action('init', 'ilybd_initialize_db_tables');
