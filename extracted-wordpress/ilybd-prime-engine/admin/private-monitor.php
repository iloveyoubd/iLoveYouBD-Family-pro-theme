<?php
function ibd_private_monitor_page() {
    if (!current_user_can('manage_options')) return;

    $g_idx = get_option('ibd_gemini_active_index', 1);
    $o_idx = get_option('ibd_openai_active_index', 1);
    $logs = get_option('ibd_ai_logs', []);
    ?>
    <div class="wrap" style="background: #000; color: #00ff41; padding: 20px; font-family: monospace; border: 2px solid #00ff41;">
        <h1>[#] IBD CYBER MONITOR V1.0</h1>
        <div style="display: flex; gap: 20px; margin: 20px 0;">
            <div style="border: 1px solid #00ff41; padding: 10px; flex: 1;">
                STATUS: GEMINI KEY #<?php echo $g_idx; ?> ACTIVE
            </div>
            <div style="border: 1px solid #00ff41; padding: 10px; flex: 1;">
                STATUS: OPENAI KEY #<?php echo $o_idx; ?> ACTIVE
            </div>
        </div>
        <h3>SYSTEM LOGS:</h3>
        <div style="height: 400px; overflow-y: auto; background: #080808; padding: 10px; border: 1px dashed #00ff41;">
            <?php foreach($logs as $log): ?>
                <p style="border-bottom: 1px solid #111; padding: 5px 0;">
                    <span style="color: #888;">[<?php echo $log['time']; ?>]</span> <?php echo $log['msg']; ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
