<?php
/* Template Name: CyberX Pro M3U Logo Player */
get_header(); 

// ১. .m3u ফাইলটির পাথ (ফাইলটি থিম ফোল্ডারে থাকতে হবে)
$m3u_file = get_template_directory() . '/playlist (1).m3u';
$m3u_content = file_get_contents($m3u_file);

// ২. ম্যাপ তৈরি করা (লোগো এবং ইউআরএল বের করা)
$channels = [];
$lines = explode("\n", $m3u_content);
$current_logo = '';
$current_name = '';

foreach ($lines as $line) {
    if (strpos($line, '#EXTINF') !== false) {
        // লোগো লিঙ্ক বের করা
        preg_match('/tvg-logo="([^"]+)"/', $line, $logo_match);
        $current_logo = isset($logo_match[1]) ? $logo_match[1] : '';
        
        // চ্যানেলের নাম বের করা
        $name_parts = explode(',', $line);
        $current_name = end($name_parts);
    } elseif (strpos($line, 'http') === 0) {
        // চ্যানেলের ইউআরএল পাওয়া গেলে অ্যারেতে রাখা
        $channels[] = [
            'name' => trim($current_name),
            'logo' => trim($current_logo),
            'url'  => trim($line)
        ];
    }
}
?>

<div id="cyber-tv-pro" style="background: #000; min-height: 100vh; color: #00ffcc; font-family: 'Segoe UI', sans-serif; padding: 10px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h2 style="text-align: center; text-shadow: 0 0 10px #00ffcc;">[ CYBERX SATELLITE HUB - LIVE ]</h2>

        <div style="width: 100%; border: 2px solid #333; background: #0a0a0a; margin-bottom: 20px; position: sticky; top: 0; z-index: 100;">
            <video id="main-video-player" controls style="width: 100%; aspect-ratio: 16/9;"></video>
            <div style="padding: 15px; background: #111; border-top: 2px solid #00ffcc; display: flex; align-items: center; gap: 15px;">
                <img id="now-playing-logo" src="" style="width: 45px; height: 45px; display: none; object-fit: contain; border-radius: 5px; background: #000;">
                <span id="playing-now" style="font-weight: bold; font-size: 18px;">চ্যানেল সিলেক্ট করুন...</span>
            </div>
        </div>

        <div id="channel-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 12px; padding: 10px;">
            <?php foreach($channels as $chan): 
                if(empty($chan['name'])) continue;
                $display_logo = !empty($chan['logo']) ? $chan['logo'] : "https://ui-avatars.com/api/?name=" . urlencode($chan['name']) . "&background=00ffcc&color=000&bold=true";
            ?>
            <div class="tv-card" onclick="playThis('<?php echo $chan['url']; ?>', '<?php echo addslashes($chan['name']); ?>', '<?php echo $display_logo; ?>')" style="background: #0d0d0d; border: 1px solid #222; padding: 10px; text-align: center; cursor: pointer; border-radius: 10px; transition: 0.3s;">
                <div style="width: 100%; height: 60px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; background: #000; border-radius: 5px;">
                    <img src="<?php echo $display_logo; ?>" 
                         onerror="this.src='https://img.icons8.com/color/96/television.png';" 
                         alt="Logo" 
                         style="max-width: 90%; max-height: 90%; object-fit: contain;">
                </div>
                <div style="font-size: 11px; color: #fff; font-weight: 500; height: 30px; overflow: hidden; line-height: 1.2;">
                    <?php echo $chan['name']; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    const player = document.getElementById('main-video-player');
    const label = document.getElementById('playing-now');
    const miniLogo = document.getElementById('now-playing-logo');

    function playThis(url, name, logo) {
        label.innerText = "Connecting: " + name;
        miniLogo.src = logo;
        miniLogo.style.display = "block";
        
        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(url);
            hls.attachMedia(player);
            hls.on(Hls.Events.MANIFEST_PARSED, () => {
                player.play();
                label.innerText = name;
            });
            hls.on(Hls.Events.ERROR, () => {
                label.innerText = "Error: " + name + " (Link Down)";
            });
        }
    }
</script>

<style>
    .tv-card:hover {
        background: #1a1a1a !important;
        border-color: #00ffcc !important;
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 255, 204, 0.3);
    }
    #channel-grid::-webkit-scrollbar { width: 5px; }
    #channel-grid::-webkit-scrollbar-thumb { background: #00ffcc; border-radius: 10px; }
    body { scroll-behavior: smooth; }
</style>

<?php get_footer(); ?>
