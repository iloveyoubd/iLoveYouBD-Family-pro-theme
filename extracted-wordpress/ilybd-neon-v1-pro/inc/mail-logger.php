/**
 * Master Plan: IBD Mail Logger
 * এই কোডটি আপনার পাঠানো প্রতিটি মেইল ডেটাবেসে সেভ করে রাখবে
 */
add_action('phpmailer_init', function($phpmailer) {
    add_action('wp_mail_failed', function($error) {
        error_log('Mail Error: ' . $error->get_error_message());
    });
});

// মেইল পাঠানোর হিস্ট্রি ডেটাবেস টেবিল তৈরি (প্রয়োজনে একবার রান করুন)
function create_mail_log_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ibd_mail_logs';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        recipient varchar(100) NOT NULL,
        subject text NOT NULL,
        message longtext NOT NULL,
        sent_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
