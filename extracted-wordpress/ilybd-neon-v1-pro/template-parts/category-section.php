<?php
/**
 * ILYBD CATEGORY SECTION - REPAIRED UTF-8 VERSION
 */
$categories = get_categories(['hide_empty' => false]);

if (!function_exists('ilybd_get_category_icon')) {
    function ilybd_get_category_icon($slug){
        $map = [
            'news' => '📰', 'tech' => '💻', 'gaming' => '🎮',
            'cyber-security' => '🛡️', 'web-development' => '🌐',
            'ai' => '🤖', 'freelancing' => '🚀', 'smartphone' => '📱',
            'wordpress' => '📝', 'default' => '📂'
        ];
        return $map[$slug] ?? $map['default'];
    }
}
?>

<section class="ilybd-ultra-wrapper">
    <div class="ilybd-cyber-inner">
        <div class="cat-header-wrap">
            <div class="cat-header-main">
                <span class="fire-glow">🔥</span>
                <h2 class="cat-main-title">CATEGORIES</h2>
            </div>
            <div class="cyber-line"></div>
        </div>

        <div class="cat-container">
            <?php foreach($categories as $cat): 
                $icon  = ilybd_get_category_icon($cat->slug);
                $link  = get_category_link($cat->term_id);
            ?>
            <a href="<?php echo esc_url($link); ?>" class="cat-neon-card">
                <div class="cat-content-left">
                    <div class="cat-icon-frame"><?php echo $icon; ?></div>
                    <span class="cat-label-text"><?php echo esc_html($cat->name); ?></span>
                </div>
                <div class="cat-count-pill">
                    <span class="count-val"><?php echo $cat->count; ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.ilybd-ultra-wrapper {
    position: relative;
    padding: 1px; /* সুপার স্লিম ১ পিক্সেল আরজিবি বর্ডার */
    border-radius: 16px;
    background: linear-gradient(90deg, #00ff88, #00bdff, #7000ff, #00ff88);
    background-size: 300% auto;
    animation: rgb-move 4s linear infinite;
    margin: 20px 0;
    overflow: hidden;
}
@keyframes rgb-move { 0% { background-position: 0% 50%; } 100% { background-position: 300% 50%; } }
.ilybd-cyber-inner { background: #0d1117; padding: 20px 15px; border-radius: 15px; position: relative; z-index: 2; }
.cat-header-wrap { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.cat-main-title { color: #00ff88; font-size: 19px; font-weight: 800; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
.cyber-line { flex-grow: 1; height: 1px; background: linear-gradient(90deg, #00ff88, transparent); }
.fire-glow { font-size: 22px; filter: drop-shadow(0 0 5px #00ff88); }
.cat-container { display: flex; flex-direction: column; gap: 10px; }
.cat-neon-card { display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.03); padding: 14px 18px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.05); text-decoration: none !important; transition: 0.3s; }
.cat-neon-card:hover { background: rgba(0, 255, 136, 0.08); border-color: #00ff88; transform: translateX(6px); }
.cat-content-left { display: flex; align-items: center; gap: 12px; }
.cat-label-text { color: #ffffff; font-size: 17px; font-weight: 600; }
.cat-count-pill { background: #00ff88; color: #000; padding: 2px 10px; border-radius: 20px; font-weight: 800; font-size: 12px; box-shadow: 0 0 10px rgba(0, 255, 136, 0.2); }
</style>
