<?php
/* Template Name: CyberX Sports Hub (Pro Stable Edition) */
get_header();

/* =====================================
   1. API CONFIG
===================================== */
$apiKey = 'eea7ff66-f3e3-49a5-82a8-748f1de19ab5';
$cache_key = 'ilybd_cricket_matches_cache';
$cache_time = 60 * 3; // 3 minutes cache

$matches = get_transient($cache_key);


/* =====================================
   2. FETCH API (SAFE + CACHED)
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

<link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>


<div class="cyber-sports-hub">

    <!-- HEADER -->
    <div class="top-bar">
        <div>
            <h1>CYBERX SPORTS HUB</h1>
            <span>LIVE DATA STREAM</span>
        </div>

        <a href="<?php echo site_url('/live-tv'); ?>" class="tv-btn">
            📺 Live TV
        </a>
    </div>


    <div class="layout">

        <!-- LEFT SIDE -->
        <div class="left">

            <!-- LIVE PLAYER -->
            <div class="card">
                <div class="card-head">
                    <span class="live-dot">● LIVE</span>
                    <span>Global Stream</span>
                </div>

                <video id="live-player" class="video-js vjs-fluid" controls>
                    <source src="https://YOUR_STREAM_URL_HERE/playlist.m3u8" type="application/x-mpegURL">
                </video>
            </div>


            <!-- MATCH LIST -->
            <h3 class="section-title">Live Matches</h3>

            <?php if (!empty($matches)) : ?>

                <?php foreach (array_slice($matches, 0, 5) as $match) :

                    $name   = $match['name'] ?? 'Unknown Match';
                    $status = $match['status'] ?? 'No Status';
                    $type   = $match['matchType'] ?? '';

                    $scoreText = '';

                    if (!empty($match['score']) && is_array($match['score'])) {
                        $firstScore = $match['score'][0] ?? null;

                        if ($firstScore) {
                            $scoreText = ($firstScore['inning'] ?? '') .
                                " : " .
                                ($firstScore['r'] ?? 0) .
                                "/" .
                                ($firstScore['w'] ?? 0);
                        }
                    }
                ?>

                <div class="match-card">
                    <div class="type"><?php echo esc_html($type); ?></div>
                    <div class="title"><?php echo esc_html($name); ?></div>
                    <div class="status"><?php echo esc_html($status); ?></div>

                    <?php if ($scoreText): ?>
                        <div class="score"><?php echo esc_html($scoreText); ?></div>
                    <?php endif; ?>
                </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty">
                    Live data temporarily unavailable
                </div>

            <?php endif; ?>

        </div>


        <!-- RIGHT SIDE -->
        <div class="right">

            <div class="fixture-box">
                <h4>Official Fixtures</h4>

                <script src="https://cdorgapi.b-cdn.net/widgets/matchlist.js"></script>
                <div id="cricket-match-list"
                     data-apikey="<?php echo esc_attr($apiKey); ?>"
                     data-theme="dark"
                     data-limit="10"></div>
            </div>

            <button class="refresh-btn" onclick="location.reload()">
                ↻ Refresh Data
            </button>

        </div>

    </div>
</div>


<style>
.cyber-sports-hub{
    background:#000;
    color:#fff;
    min-height:100vh;
    padding:20px;
    font-family:Rajdhani, sans-serif;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.top-bar h1{
    color:#00ffcc;
    margin:0;
}

.tv-btn{
    background:#ff0044;
    padding:10px 15px;
    border-radius:6px;
    color:#fff;
    text-decoration:none;
}

.layout{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.left{flex:2; min-width:320px;}
.right{flex:1; min-width:280px;}

.card{
    background:#111;
    border:1px solid #222;
    border-radius:10px;
    overflow:hidden;
    margin-bottom:20px;
}

.card-head{
    padding:10px;
    font-size:12px;
    color:#aaa;
    display:flex;
    justify-content:space-between;
}

.live-dot{
    color:red;
    animation:blink 1s infinite;
}

.section-title{
    color:#00ffcc;
    margin:15px 0;
}

.match-card{
    background:#0a0a0a;
    border:1px solid #222;
    padding:12px;
    margin-bottom:10px;
    border-radius:8px;
}

.match-card .title{
    font-weight:bold;
    margin:5px 0;
}

.match-card .status{
    color:#00ffcc;
    font-size:12px;
}

.score{
    margin-top:8px;
    color:#fff;
    background:#111;
    padding:6px;
    border-radius:5px;
}

.fixture-box{
    background:#111;
    padding:15px;
    border-radius:10px;
}

.refresh-btn{
    width:100%;
    margin-top:15px;
    padding:10px;
    background:#00ffcc;
    border:none;
    font-weight:bold;
    cursor:pointer;
}

.empty{
    padding:15px;
    color:#666;
}

@keyframes blink{
    50%{opacity:0.3;}
}
</style>


<script>
document.addEventListener("DOMContentLoaded", function () {
    if (typeof videojs !== "undefined") {
        videojs('live-player');
    }
});
</script>

<?php get_footer(); ?>