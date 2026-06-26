<?php
/* Template Name: CyberX Sports Hub (Pro Stable Edition) */
get_header();

/* =====================================
   1. API CONFIG FOR CRICKET DATA
   ===================================== */
$apiKey = 'eea7ff66-f3e3-49a5-82a8-748f1de19ab5';
$cache_key = 'ilybd_cricket_matches_cache';
$cache_time = 60 * 3; // 3 minutes cache

$matches = get_transient($cache_key);

/* =====================================
   2. FETCH API (SAFE + CACHED BDIX RETRIEVAL)
   ===================================== */
if ($matches === false) {
    $apiUrl = "https://api.cricapi.com/v1/currentMatches?apikey={$apiKey}&offset=0";
    $response = wp_remote_get($apiUrl, [
        'timeout' => 10
    ]);

    if (!is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response);
        $decoded = json_decode($body, true);

        if (!empty($decoded['data'])) {
            $matches = $decoded['data'];
            set_transient($cache_key, $matches, $cache_time);
        }
    }

    if (!isset($matches)) {
        $matches = [];
    }
}
?>

<!-- GOOGLE ADSENSE SPACE -->
<div style="height: 20px; display: block; clear: both;"></div>

<div class="cyber-sports-hub-v2" style="background: #070b13; min-height: 100vh; color: #00f0ff; font-family: 'Space Grotesk', 'Hind Siliguri', sans-serif; padding: 25px 15px;">
    <div style="max-width: 1280px; margin: 0 auto;">

        <!-- TOP NAVIGATION BAR -->
        <div class="sports-top-bar" style="display: flex; justify-content: space-between; align-items: center; background: rgba(13, 21, 39, 0.6); border: 1px solid rgba(0,240,255,0.15); border-radius: 12px; padding: 15px 20px; margin-bottom: 25px;">
            <div>
                <h1 style="margin: 0; color: #fff; font-size: 22px; font-weight: 700; text-shadow: 0 0 10px rgba(0, 240, 255, 0.3);">🎮 CYBERX Live Sports Terminal</h1>
                <span style="font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #a0aec0;">UPLINK STATUS: INTERSTELLAR SATELLITE HUB</span>
            </div>
            <a href="<?php echo site_url('/live-tv'); ?>" style="background: #ff0044; color: #fff; padding: 10px 18px; border-radius: 6px; font-weight: bold; text-decoration: none; font-size: 13px; font-family: 'Hind Siliguri', sans-serif; display: flex; align-items: center; gap: 8px; box-shadow: 0 0 10px rgba(255,0,68,0.25);">
                📺 মূল লাইভ টিভি প্লেয়ার
            </a>
        </div>

        <!-- MAIN LAYOUT GRAPH -->
        <div class="sports-grid" style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 25px;">
            
            <!-- LEFT LAYER: LIVE STREAMING MODULE -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- ADVANCED SPORTS VIDEO CONTAINER -->
                <div style="background: #0d1527; border: 2px solid #00f0ff; border-radius: 12px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 240, 255, 0.15);">
                    
                    <div style="padding: 12px 18px; background: rgba(13, 21, 39, 0.8); border-bottom: 1px solid rgba(0, 240, 255, 0.2); display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="width: 8px; height: 8px; background: #ff0044; border-radius: 50%; box-shadow: 0 0 8px #ff0044; display: inline-block;"></span>
                            <span id="video-stream-title" style="font-weight: 700; color: #fff; font-size: 15px;">🏆 FIFA World Cup Live - T Sports (সরাসরি বিশ্বকাপ ফুটবল)</span>
                        </div>
                        <span id="sports-stream-label" style="font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #00ff41; background: rgba(0, 255, 65, 0.08); padding: 3px 8px; border-radius: 4px; font-weight: bold;">SERVER 1 ACTIVE</span>
                    </div>

                    <!-- RAW PLAYER TARGET -->
                    <video id="sports-video-player" controls autoplay style="width: 100%; aspect-ratio: 16/9; display: block; background: #000;"></video>

                    <!-- CONTROL DESK -->
                    <div style="padding: 15px 20px; background: #0d1527; border-top: 1px solid rgba(0, 240, 255, 0.15);">
                        <h4 style="margin: 0 0 10px 0; font-size: 13.5px; color: #ffaa00; font-family: 'Hind Siliguri', sans-serif;"><i class="fa-solid fa-satellite-dish"></i> চ্যানেল ও লাইভ খেলাধুলার সার্ভার বেছে নিন:</h4>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <button class="sports-switch-btn active-sports-server" onclick="playSportsStream('http://live.matribhumitv.com/tsports/index.m3u8', '🏆 FIFA World Cup Live - T Sports (সরাসরি বিশ্বকাপ ফুটবল)', 'SERVER 1 ACTIVE', this)" 
                                    style="padding: 8px 14px; font-size: 12.5px; background: #00f0ff; color: #070b13; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">
                                T Sports (সার্ভার ১)
                            </button>
                            <button class="sports-switch-btn" onclick="playSportsStream('http://live.matribhumitv.com/gtv/index.m3u8', '🏆 Live Football & Cricket - GTV (জিটিভি গাজি সরাসরি)', 'SERVER 2 ACTIVE', this)" 
                                    style="padding: 8px 14px; font-size: 12.5px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 5px; font-weight: bold; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">
                                GTV Sports (সার্ভার ২)
                            </button>
                            <button class="sports-switch-btn" onclick="playSportsStream('http://live.matribhumitv.com/maasranga/index.m3u8', '🏆 LIVE Match Stream - Maasranga (মাছরাঙা টিভি)', 'SERVER 3 ACTIVE', this)" 
                                    style="padding: 8px 14px; font-size: 12.5px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 5px; font-weight: bold; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">
                                Maasranga TV (সার্ভার ৩)
                            </button>
                            <button class="sports-switch-btn" onclick="playSportsStream('https://bldcmprod-cdn.toffeelive.com/cdn/live/sony_sports_1_hd/playlist.m3u8', '⚽ Sony Sports Ten 1 HD Live (আমেরিকান ফুটবল)', 'SERVER 4 ACTIVE', this)" 
                                    style="padding: 8px 14px; font-size: 12.5px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 5px; font-weight: bold; cursor: pointer; font-family: 'Hind Siliguri', sans-serif;">
                                Sony Ten 1 (সার্ভার ৪)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- CRICKET MATCH API METRICS -->
                <h3 style="font-size: 18px; color: #ffaa00; margin: 10px 0 5px 0; border-bottom: 2px solid rgba(0, 240, 255, 0.15); padding-bottom: 8px; font-family: 'Space Grotesk', 'Hind Siliguri', sans-serif;"><i class="fa-solid fa-gamepad"></i> রিয়েল-টাইম লাইভ ম্যাচ স্কোরবোর্ড (Live Scores)</h3>
                
                <?php if (!empty($matches)) : ?>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php foreach (array_slice($matches, 0, 5) as $match) :
                            $name   = $match['name'] ?? 'Unknown Match';
                            $status = $match['status'] ?? 'No Status';
                            $type   = $match['matchType'] ?? 'Unknown Type';
                            $scoreText = '';

                            if (!empty($match['score']) && is_array($match['score'])) {
                                $firstScore = $match['score'][0] ?? null;
                                if ($firstScore) {
                                    $scoreText = ($firstScore['inning'] ?? '') . " : " . ($firstScore['r'] ?? 0) . "/" . ($firstScore['w'] ?? 0);
                                }
                            }
                        ?>
                        <div style="background: rgba(13, 21, 39, 0.4); border: 1px solid rgba(0, 240, 255, 0.1); border-radius: 8px; padding: 15px; display: flex; flex-direction: column; gap: 6px; transition: 0.2s;" onmouseover="this.style.borderColor='#00f0ff'" onmouseout="this.style.borderColor='rgba(0, 240, 255, 0.1)'">
                            <div style="display: flex; justify-content: space-between; font-size: 11px; font-family: 'JetBrains Mono', monospace; text-transform: uppercase;">
                                <span style="color: #ffaa00;"><?php echo esc_html($type); ?></span>
                                <span style="color: #00ff41; font-weight: bold;">● LIVE IN PLAY</span>
                            </div>
                            <div style="font-weight: bold; font-size: 15px; color: #fff;"><?php echo esc_html($name); ?></div>
                            <div style="font-size: 13px; color: #cbd5e0; font-family: 'Hind Siliguri', sans-serif;"><?php echo esc_html($status); ?></div>
                            
                            <?php if ($scoreText): ?>
                                <div style="margin-top: 5px; font-family: 'JetBrains Mono', monospace; background: #070b13; padding: 8px; border-radius: 4px; border: 1px solid rgba(0,240,255,0.15); color: #00f0ff; font-weight: bold; font-size: 13.5px;"><?php echo esc_html($scoreText); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="background: rgba(13, 21, 39, 0.2); border: 1px dashed rgba(255,255,255,0.05); padding: 25px; border-radius: 8px; text-align: center; color: #cbd5e0; font-family: 'Hind Siliguri', sans-serif; font-size: 14px;">
                        বর্তমানে রানিং কোনো অফিসিয়াল ইন্টারন্যাশনাল ম্যাচ পাওয়া যায়নি। আপডেট রিকোয়েস্ট করতে নিচের রিফ্রেশ বোতামে চাপ দিন।
                    </div>
                <?php endif; ?>

            </div>

            <!-- RIGHT LAYER: FIXTURES AND WIDGETS -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                
                <div style="background: rgba(13, 21, 39, 0.6); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 20px;">
                    <h4 style="color: #fff; margin: 0 0 15px 0; font-size: 16px; font-family: 'Space Grotesk', sans-serif;"><i class="fa-solid fa-list-check"></i> Upcoming Official Fixtures</h4>
                    
                    <script src="https://cdorgapi.b-cdn.net/widgets/matchlist.js"></script>
                    <div id="cricket-match-list"
                         data-apikey="<?php echo esc_attr($apiKey); ?>"
                         data-theme="dark"
                         data-limit="10"></div>
                </div>

                <button onclick="location.reload()" style="background: linear-gradient(135deg, #00f0ff 0%, #00bcff 100%); color: #070b13; border: none; font-weight: bold; width: 100%; border-radius: 6px; padding: 12px; cursor: pointer; transition: 0.2s; font-family: 'JetBrains Mono', monospace; font-size: 13px;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    ↻ REFRESH DATA UPLINK
                </button>

            </div>

        </div>

    </div>
</div>

<!-- GOOGLE ADSENSE SPACE -->
<div style="height: 30px; display: block; clear: both;"></div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    const player = document.getElementById('sports-video-player');
    const titleLabel = document.getElementById('video-stream-title');
    const serverLabel = document.getElementById('sports-stream-label');

    function playSportsStream(streamUrl, title, serverText, btnElement) {
        titleLabel.innerText = title;
        serverLabel.innerText = serverText;

        // Toggle Active state style on sports stream selector buttons
        document.querySelectorAll('.sports-switch-btn').forEach(btn => {
            btn.style.background = 'rgba(255,255,255,0.05)';
            btn.style.color = '#fff';
            btn.style.border = '1px solid rgba(255,255,255,0.1)';
        });

        if (btnElement) {
            btnElement.style.background = '#00f0ff';
            btnElement.style.color = '#070b13';
            btnElement.style.border = 'none';
        }

        // Initialize streams safely
        if (Hls.isSupported()) {
            if (window.hlsSports) {
                window.hlsSports.destroy();
            }
            const hls = new Hls({
                maxMaxBufferLength: 8,
                enableWorker: true
            });
            window.hlsSports = hls;
            hls.loadSource(streamUrl);
            hls.attachMedia(player);
            hls.on(Hls.Events.MANIFEST_PARSED, () => {
                player.play().catch(() => {});
            });
            hls.on(Hls.Events.ERROR, function(event, data) {
                if (data.fatal) {
                    titleLabel.innerText = "⚠️ সার্ভার অফলাইন, অন্য সার্ভার বা চ্যানেল বোতাম ট্রাই করুন।";
                }
            });
        } 
        // fallback Safari
        else if (player.canPlayType('application/vnd.apple.mpegurl')) {
            player.src = streamUrl;
            player.addEventListener('loadedmetadata', function() {
                player.play().catch(() => {});
            });
        }
    }

    // Load initial streams
    document.addEventListener("DOMContentLoaded", function() {
        playSportsStream(
            'http://live.matribhumitv.com/tsports/index.m3u8', 
            '🏆 FIFA World Cup Live - T Sports (সরাসরি বিশ্বকাপ ফুটবল)', 
            'SERVER 1 ACTIVE', 
            null
        );
    });
</script>

<style>
    @media (max-width: 820px) {
        .sports-grid {
            grid-template-columns: 1fr !important;
        }
        .sports-top-bar {
            flex-direction: column !important;
            gap: 15px !important;
            text-align: center !important;
        }
    }
</style>

<?php get_footer(); ?>
