<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class ILYBD_NID_Control {
    public function __construct() {
        add_action('admin_menu', array($this, 'nid_add_menu'));
    }

    public function nid_add_menu() {
        add_submenu_page(
            'ilybd-engine-settings', // ILYBD Master এর আন্ডারে থাকবে
            'NID Security Control',
            'NID Control',
            'manage_options',
            'ilybd-nid-control',
            array($this, 'render_nid_control_page')
        );
    }

    public function render_nid_control_page() {
        if (isset($_POST['save_nid_settings'])) {
            update_option('ibd_nid_unlock_key', $_POST['nid_unlock_key']);
            update_option('ibd_nid_gen_link', $_POST['nid_gen_link']);
            echo '<div class="updated"><p>NID Settings Saved!</p></div>';
        }
        ?>
        <div class="wrap" style="background: #f0f0f0; padding: 20px; border-left: 4px solid #006b3c;">
            <h1>🛡️ NID Security & Legal Control</h1>
            <form method="post">
                <table class="form-table">
                    <tr>
                        <th>Master Security Key</th>
                        <td><input type="text" name="nid_unlock_key" value="<?php echo get_option('ibd_nid_unlock_key', 'IBD71'); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>Key Generator URL</th>
                        <td><input type="text" name="nid_gen_link" value="<?php echo get_option('ibd_nid_gen_link', site_url('/verify-key')); ?>" class="regular-text"></td>
                    </tr>
                </table>
                <?php submit_button('Save NID Control', 'primary', 'save_nid_settings'); ?>
            </form>
        </div>
        <?php
    }
}
new ILYBD_NID_Control();
