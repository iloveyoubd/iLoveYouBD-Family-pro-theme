<?php
/**
 * Admin: Payout Handler
 * Path: admin/payout-handler.php
 * Description: Manages Bkash/Nagad withdrawal requests for users.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class ILYBD_Payout_Manager {

    public function __construct() {
        add_action('admin_menu', array($this, 'ilybd_add_payout_menu'));
    }

    public function ilybd_add_payout_menu() {
        add_submenu_page(
            'ilybd-engine-settings', // মেইন মেনুর স্লাগ
            'Withdrawal Requests',
            'Withdrawals',
            'manage_options',
            'ilybd-payouts',
            array($this, 'ilybd_render_payout_page')
        );
    }

    public function ilybd_render_payout_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ilybd_wallet';
        
        // শুধু যাদের ব্যালেন্স ৫০০ টাকার উপরে তাদের রিকোয়েস্ট দেখাবে (লিমিট অনুযায়ী)
        $requests = $wpdb->get_results("SELECT * FROM $table_name WHERE balance >= 500 ORDER BY last_update DESC");

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">💸 Withdrawal Requests (Bkash/Nagad/Rocket)</h1>
            <p>ইউজারদের পেমেন্ট রিকোয়েস্ট এখানে জমা হবে। পেমেন্ট করার পর ডাটাবেস আপডেট করুন।</p>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Requested Balance</th>
                        <th>Method Info</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( $requests ) : ?>
                        <?php foreach ( $requests as $request ) : 
                            $user_info = get_userdata($request->user_id);
                            ?>
                            <tr>
                                <td><?php echo esc_html($request->user_id); ?></td>
                                <td><?php echo esc_html($user_info->display_name); ?></td>
                                <td><strong><?php echo esc_html($request->balance); ?> BDT</strong></td>
                                <td><?php echo 'Bkash/Nagad: 01xxxxxxxxx'; // এই ডাটা মেটা থেকে আসবে ?></td>
                                <td><span class="badge" style="background: #ffc107; padding: 3px 8px; border-radius: 4px;">Pending</span></td>
                                <td>
                                    <button class="button button-primary">Approve & Paid</button>
                                    <button class="button button-secondary">Reject</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">এখনো কোনো পেমেন্ট রিকোয়েস্ট নেই বস্।</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
new ILYBD_Payout_Manager();
