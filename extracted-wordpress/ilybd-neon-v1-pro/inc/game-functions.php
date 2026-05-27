<?php
// গেমের ফাইলগুলো লোড করার ফাংশন
function register_cyber_game_assets() {
    // শুধুমাত্র নির্দিষ্ট পেজ বা শর্টকোড থাকলে লোড হবে (সাইট ফাস্ট রাখার জন্য)
    wp_register_style('cyber-game-style', get_template_directory_uri() . '/assets/cyber-game/css/game-style.css');
    wp_register_script('cyber-game-script', get_template_directory_uri() . '/assets/cyber-game/js/main-game.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'register_cyber_game_assets');

// শর্টকোড তৈরি: [cyber_talking_cat]
add_shortcode('cyber_talking_cat', function() {
    wp_enqueue_style('cyber-game-style');
    wp_enqueue_script('cyber-game-script');
    
    return '<div id="cyber-game-container">
                <canvas id="gameCanvas"></canvas>
                <div id="controls">
                    <button id="micBtn">🎤 কথা বলো</button>
                </div>
            </div>';
});
