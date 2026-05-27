<?php
/**
 * Master Plan: IBD Cyber Mail Center (Deep Decoder Pro)
 * Features: Multi-part Parsing, Automatic Base64/QP Decoding, SSL Bypass
 */

add_action('admin_menu', 'ibd_cyber_full_mail_center');
function ibd_cyber_full_mail_center() {
    add_menu_page('Mail Center', 'Mail Center', 'manage_options', 'ibd-mail-center', 'ibd_mail_center_dashboard', 'dashicons-email-alt2', 25);
}

// ফাংশন: ইমেইল বডি ডিকোড করার জন্য
function get_imap_body_decoded($mbox, $msg_id) {
    $structure = imap_fetchstructure($mbox, $msg_id);
    
    // ইমেইল যদি মাল্টি-পার্ট হয় তবে টেক্সট পার্ট খুঁজে বের করা
    if (isset($structure->parts) && count($structure->parts)) {
        $part_number = 1; 
        foreach ($structure->parts as $index => $part) {
            if ($part->type == 0) { // 0 মানে টেক্সট
                $part_number = $index + 1;
                $encoding = $part->encoding;
                break;
            }
        }
        $raw_body = imap_fetchbody($mbox, $msg_id, $part_number);
    } else {
        $raw_body = imap_fetchbody($mbox, $msg_id, 1);
        $encoding = $structure->encoding;
    }

    // এনকোডিং অনুযায়ী ডিকোড করা
    if ($encoding == 3) return base64_decode($raw_body);
    if ($encoding == 4) return quoted_printable_decode($raw_body);
    return $raw_body;
}

function ibd_mail_center_dashboard() {
    $server = "{mail.iloveyoubd.com:993/imap/ssl/novalidate-cert}INBOX";
    $username = "support@iloveyoubd.com";
    $password = "support@74";
    $selected_msg_body = "";
    $selected_sender = "";
    $selected_subject = "";

    if (isset($_GET['view_msg'])) {
        $mbox = @imap_open($server, $username, $password);
        if ($mbox) {
            $msg_id = intval($_GET['view_msg']);
            $selected_msg_body = get_imap_body_decoded($mbox, $msg_id);
            
            $header = imap_headerinfo($mbox, $msg_id);
            $selected_sender = $header->from[0]->mailbox . "@" . $header->from[0]->host;
            $selected_subject = "Re: " . $header->subject;
            imap_close($mbox);
        }
    }

    if (isset($_POST['send_custom_mail'])) {
        wp_mail(sanitize_email($_POST['recipient']), sanitize_text_field($_POST['subject']), wp_kses_post($_POST['body']));
        echo '<div class="updated"><p>Response Sent Successfully!</p></div>';
    }

    ?>
    <style>
        .ibd-mail-container { background: #0d1117; color: #fff; padding: 25px; border-radius: 12px; border: 1px solid #00ffcc; margin-top: 20px; font-family: sans-serif; }
        .ibd-flex { display: flex; gap: 20px; margin-top: 20px; }
        .ibd-box { flex: 1; background: #161b22; padding: 15px; border-radius: 10px; border: 1px solid #333; height: 750px; overflow-y: auto; }
        .mail-link { text-decoration: none; color: inherit; display: block; border-bottom: 1px solid #222; padding: 12px; transition: 0.2s; }
        .mail-link:hover, .active-mail { background: #1c2128; border-left: 4px solid #00ffcc; }
        .msg-viewer { background: #000; border: 1px solid #00ffcc; padding: 20px; border-radius: 5px; margin-bottom: 20px; min-height: 250px; color: #fff; font-family: 'Courier New', monospace; font-size: 16px; line-height: 1.5; white-space: pre-wrap; word-break: break-word; }
        input, textarea { width: 100%; background: #0d1117; color: #00ffcc; border: 1px solid #333; padding: 10px; margin-bottom: 10px; }
        .send-btn { background: #00ffcc; color: #000; font-weight: bold; border: none; padding: 12px; cursor: pointer; width: 100%; }
    </style>

    <div class="wrap">
        <div class="ibd-mail-container">
            <h1 style="color: #00ffcc;">IBD Cyber Mail Center</h1>
            <div class="ibd-flex">
                <!-- Inbox -->
                <div class="ibd-box">
                    <h3 style="color: #00ffcc; border-bottom: 1px solid #00ffcc;">Inbox</h3>
                    <?php
                    $mbox = @imap_open($server, $username, $password);
                    if ($mbox) {
                        $emails = imap_search($mbox, 'ALL');
                        if ($emails) {
                            rsort($emails);
                            foreach (array_slice($emails, 0, 10) as $num) {
                                $ov = imap_fetch_overview($mbox, $num, 0);
                                $active = (isset($_GET['view_msg']) && $_GET['view_msg'] == $num) ? 'active-mail' : '';
                                echo '<a href="?page=ibd-mail-center&view_msg='.$num.'" class="mail-link '.$active.'">';
                                echo '<div style="color:#00ffcc;font-weight:bold;">'.esc_html($ov[0]->from).'</div>';
                                echo '<div style="font-size:12px;">'.esc_html($ov[0]->subject).'</div>';
                                echo '</a>';
                            }
                        }
                        imap_close($mbox);
                    }
                    ?>
                </div>

                <!-- Reader -->
                <div class="ibd-box" style="flex: 1.5;">
                    <h3 style="color: #00ffcc; border-bottom: 1px solid #00ffcc;">Message Decoded</h3>
                    <?php if ($selected_msg_body): ?>
                        <div class="msg-viewer">
                            <?php echo $selected_msg_body; ?>
                        </div>
                    <?php else: ?>
                        <p style="text-align:center; color:#666;">Select mail to extract code.</p>
                    <?php endif; ?>

                    <form method="post">
                        <input name="recipient" type="email" value="<?php echo esc_attr($selected_sender); ?>" placeholder="To">
                        <input name="subject" type="text" value="<?php echo esc_attr($selected_subject); ?>" placeholder="Subject">
                        <?php wp_editor('', 'body', array('textarea_rows' => 5)); ?>
                        <button type="submit" name="send_custom_mail" class="send-btn">REPLY NOW</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
