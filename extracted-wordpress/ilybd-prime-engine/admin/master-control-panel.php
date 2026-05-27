<?php
function ilybd_master_control_page() {
    // সেটিংস সেভ করা
    if (isset($_POST['update_ilybd'])) {
        update_option('ilybd_ux_mode', $_POST['ux_mode']); // বয়স্ক নাকি তরুণ
        update_option('ilybd_yt_sync', $_POST['yt_sync']); // ইউটিউব কানেকশন
        update_option('ilybd_traffic_hijack', $_POST['traffic_hijack']);
        echo '<div class="updated"><p>ILYBD Master Config Updated Successfully!</p></div>';
    }

    $ux_mode = get_option('ilybd_ux_mode', 'young');
    $yt_sync = get_option('ilybd_yt_sync', 'off');
    ?>
    <div class="wrap" style="background: #000; color: #00ff41; padding: 30px; border: 2px solid #00ff41; box-shadow: 0 0 15px #00ff41; font-family: 'Courier New', monospace;">
        <h1 style="color:#fff;">[🛰️] ILYBD SYSTEM CONTROL CENTER</h1>
        <form method="post">
            <table class="form-table" style="color:#fff;">
                
                <tr>
                    <th>Target Audience UX:</th>
                    <td>
                        <select name="ux_mode" style="width:300px; background:#111; color:#00ff41; border:1px solid #00ff41;">
                            <option value="young" <?php selected($ux_mode, 'young'); ?>>Young Generation (Vibrant & Neon)</option>
                            <option value="senior" <?php selected($ux_mode, 'senior'); ?>>Senior Citizens (Clean & Large Fonts)</option>
                        </select>
                        <p style="font-size:11px; color:#888;">* Seniors mode increases font size and simplifies navigation.</p>
                    </td>
                </tr>

                <tr>
                    <th>YouTube Channel Sync:</th>
                    <td>
                        <label class="switch">
                            <input type="checkbox" name="yt_sync" value="on" <?php checked($yt_sync, 'on'); ?>>
                            <span style="color:#00ff41;">Auto-suggest Videos in Posts</span>
                        </label>
                    </td>
                </tr>

                <tr>
                    <th>Traffic Hijacking:</th>
                    <td>
                        <select name="traffic_hijack" style="width:300px; background:#111; color:#00ff41; border:1px solid #00ff41;">
                            <option value="on">ACTIVE (Trap Users on Exit)</option>
                            <option value="off">DISABLED</option>
                        </select>
                    </td>
                </tr>

            </table>
            <br>
            <input type="submit" name="update_ilybd" class="button button-primary" value="EXECUTE CHANGES" style="background:#00ff41; color:#000; border:none; font-weight:bold; padding:10px 40px;">
        </form>
    </div>
    <?php
}
