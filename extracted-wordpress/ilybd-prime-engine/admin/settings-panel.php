<?php
function ibd_master_settings_page() {
    if (isset($_POST['save_ibd_keys'])) {
        for($i=1; $i<=10; $i++) {
            update_option('ibd_gemini_key_'.$i, $_POST['gemini_key_'.$i]);
            update_option('ibd_openai_key_'.$i, $_POST['openai_key_'.$i]);
        }
        echo '<div class="updated"><p>All 20 Keys Saved Successfully!</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>IBD Master AI API Config</h1>
        <form method="post">
            <div style="display:flex; gap:20px;">
                <div style="flex:1;">
                    <h3>Gemini Keys (1-10)</h3>
                    <?php for($i=1; $i<=10; $i++): ?>
                        <input type="password" name="gemini_key_<?php echo $i; ?>" value="<?php echo get_option('ibd_gemini_key_'.$i); ?>" style="width:100%; margin-bottom:5px;" placeholder="Gemini Key <?php echo $i; ?>">
                    <?php endfor; ?>
                </div>
                <div style="flex:1;">
                    <h3>OpenAI Keys (1-10)</h3>
                    <?php for($i=1; $i<=10; $i++): ?>
                        <input type="password" name="openai_key_<?php echo $i; ?>" value="<?php echo get_option('ibd_openai_key_'.$i); ?>" style="width:100%; margin-bottom:5px;" placeholder="OpenAI Key <?php echo $i; ?>">
                    <?php endfor; ?>
                </div>
            </div>
            <input type="submit" name="save_ibd_keys" class="button-primary" value="Save Keys">
        </form>
    </div>
    <?php
}
