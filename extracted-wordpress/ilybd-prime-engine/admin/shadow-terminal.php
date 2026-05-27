<?php
function ibd_shadow_terminal_html() {
    ?>
    <div id="ibd-terminal-container" style="background: #000; border: 1px solid #00ff41; padding: 15px; margin-top: 20px;">
        <div id="terminal-output" style="height: 150px; overflow-y: auto; color: #00ff41; font-size: 13px; margin-bottom: 10px;">
            <p>> ILYBD Shadow Terminal Initialized...</p>
            <p>> Awaiting Command (Type /help for options)...</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <span style="color: #00ff41;">root@ilybd:~#</span>
            <input type="text" id="terminal-input" style="background: transparent; border: none; color: #00ff41; outline: none; width: 80%;" autofocus>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#terminal-input').on('keypress', function(e) {
            if(e.which == 13) {
                let cmd = $(this).val();
                $('#terminal-output').append('<p>> ' + cmd + '</p>');
                $(this).val('');
                
                // Ajax Call to process command
                $.post(ajaxurl, {
                    action: 'ibd_process_terminal_cmd',
                    command: cmd
                }, function(res) {
                    $('#terminal-output').append('<p style="color: #fff;">>> ' + res.data + '</p>');
                    $('#terminal-output').scrollTop($('#terminal-output')[0].scrollHeight);
                });
            }
        });
    });
    </script>
    <?php
}
