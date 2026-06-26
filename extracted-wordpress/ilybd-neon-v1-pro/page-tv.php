<?php
/* Template Name: CyberX Pro M3U Logo Player */
get_header(); 

// ১. .m3u ফাইলটির পাথ (ফাইলটি থিম ফোল্ডারে থাকতে হবে)
$m3u_file = get_template_directory() . '/playlist (1).m3u';
$m3u_channels = [];

if (file_exists($m3u_file)) {
    $m3u_content = file_get_contents($m3u_file);
    if (!empty($m3u_content)) {
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
                $m3u_channels[] = [
                    'name' => trim($current_name),
                    'logo' => trim($current_logo),
                    'url'  => trim($line)
                ];
            }
        }
    }
}

// ২. Channels_data.json ফাইলটির পাথ
$json_file = get_template_directory() . '/Channels_data.json';
$json_channels = [];

if (file_exists($json_file)) {
    $json_content = file_get_contents($json_file);
    if (!empty($json_content)) {
        $json_data = json_decode($json_content, true);
        if (isset($json_data['channels'])) {
            foreach ($json_data['channels'] as $chan) {
                if (!empty($chan['name']) && !empty($chan['url']) && trim($chan['name']) !== "") {
                    $json_channels[] = [
                        'name' => trim($chan['name']),
                        'url' => trim($chan['url'])
                    ];
                }
            }
        }
    }
}

// ৩. প্রি-ইনস্টল করা আল্ট্রা-স্ট্যাবল ও ভেরিফাইড চ্যানেলের তালিকা (বিশ্বকাপ ফুটবল ও ক্রিকেট সহ)
$stable_categories = [
    [
        'category_en' => '🏆 Live Sports & World Cup (বিশ্বকাপ ও খেলাধুলা সরাসরি)',
        'category_id' => 'sports',
        'channels' => [
            [
                'name' => '🏆 FIFA World Cup Live (টি স্পোর্টস)',
                'logo' => 'https://img.icons8.com/color/96/trophy.png',
                'url'  => 'http://live.matribhumitv.com/tsports/index.m3u8',
                'url_backup' => 'https://byphdgllyk.gpcdn.net/hls/tsports/master.m3u8',
                'desc' => 'ফিফা বিশ্বকাপ ফুটবল, ক্রিকেট এবং সরাসরি খেলাধুলার প্রিমিয়াম স্ট্রিমিং।'
            ],
            [
                'name' => '🏆 Live Football & Cricket (জিটিভি)',
                'logo' => 'https://static.wikia.nocookie.net/logopedia/images/4/4c/Gazi_TV_Logo_2016.png',
                'url'  => 'http://live.matribhumitv.com/gtv/index.m3u8',
                'url_backup' => 'http://live.matribhumitv.com/gazi/index.m3u8',
                'desc' => 'বাংলা লাইভ স্পোর্টস সম্প্রচার ও বিশেষ টুর্নামেন্ট।'
            ],
            [
                'name' => '🏆 Live Sports Channel (মাছরাঙা)',
                'logo' => 'https://static.wikia.nocookie.net/etv-gspn-bangla/images/a/a3/Maasranga_TV_HD_logo.png',
                'url'  => 'http://live.matribhumitv.com/maasranga/index.m3u8',
                'url_backup' => 'http://mtv.sunplex.live/MAASRANGA-TV/index.m3u8',
                'desc' => 'স্পোর্টস লাইভ ইভেন্ট, বাংলা নাটক ও বিনোদন।'
            ],
            [
                'name' => '⚽ Sony Sports Ten 1 HD',
                'logo' => 'https://img.icons8.com/color/96/sports.png',
                'url'  => 'https://bldcmprod-cdn.toffeelive.com/cdn/live/sony_sports_1_hd/playlist.m3u8',
                'url_backup' => 'https://byphdgllyk.gpcdn.net/hls/sony_sports_1/master.m3u8',
                'desc' => 'আন্তর্জাতিক ফুটবল চ্যাম্পিয়নশিপ সরাসরি সম্প্রচার।'
            ],
            [
                'name' => '⚽ Sony Sports Ten 2 HD',
                'logo' => 'https://img.icons8.com/color/96/sports2.png',
                'url'  => 'https://bldcmprod-cdn.toffeelive.com/cdn/live/sony_sports_2_hd/playlist.m3u8',
                'url_backup' => 'https://byphdgllyk.gpcdn.net/hls/sony_sports_2/master.m3u8',
                'desc' => 'ইউরোপিয়ান ফুটবল কাপ ও ইন্টারন্যাশনাল ফুটবল লিগ।'
            ]
        ]
    ],
    [
        'category_en' => '📰 Live News Channels (লাইভ খবর)',
        'category_id' => 'news',
        'channels' => [
            [
                'name' => 'Somoy TV (সময় টিভি)',
                'logo' => 'https://img.icons8.com/color/96/news.png',
                'url'  => 'http://live.matribhumitv.com/somoy/index.m3u8',
                'url_backup' => 'https://owrcovcrpy.gpcdn.net/bpk-tv/1702/output/index.m3u8',
                'desc' => 'বাংলাদেশের এক নম্বর লাইভ সময় সংবাদ ২৪ ঘন্টা।'
            ],
            [
                'name' => 'Independent TV (ইনডিপেনডেন্ট)',
                'logo' => 'https://img.icons8.com/color/96/live-video.png',
                'url'  => 'http://live.matribhumitv.com/independent/index.m3u8',
                'url_backup' => 'https://owrcovcrpy.gpcdn.net/bpk-tv/1704/output/index.m3u8',
                'desc' => 'তাৎক্ষনিক লাইভ বুলেটিন, টকশো ও দেশীয় খবর।'
            ],
            [
                'name' => 'Jamuna TV (যমুনা টিভি)',
                'logo' => 'https://img.icons8.com/color/96/television.png',
                'url'  => 'http://live.matribhumitv.com/jamuna/index.m3u8',
                'url_backup' => 'https://owrcovcrpy.gpcdn.net/bpk-tv/1701/output/index.m3u8',
                'desc' => 'নিরপেক্ষ এবং ব্রেক-ফ্রি লাইভ যমুনা সংবাদ।'
            ],
            [
                'name' => 'Channel 24 (চ্যানেল ২৪)',
                'logo' => 'https://img.icons8.com/color/96/broadcast.png',
                'url'  => 'http://live.matribhumitv.com/channel24/index.m3u8',
                'url_backup' => 'https://owrcovcrpy.gpcdn.net/bpk-tv/1703/output/index.m3u8',
                'desc' => 'চ্যানেল ২৪ লাইভ নিউজ এবং বিনোদনমূলক অনুষ্ঠান।'
            ],
            [
                'name' => 'Ekattor TV (একাত্তর টিভি)',
                'logo' => 'https://img.icons8.com/color/96/microphone.png',
                'url'  => 'http://live.matribhumitv.com/ekattor/index.m3u8',
                'url_backup' => 'https://owrcovcrpy.gpcdn.net/bpk-tv/1705/output/index.m3u8',
                'desc' => 'একাত্তর জার্নাল এবং জনপ্রিয় লাইভ পলিটিক্যাল টকশো।'
            ]
        ]
    ],
    [
        'category_en' => '🎭 National & Entertainment (জাতীয় ও নাটক)',
        'category_id' => 'entertainment',
        'channels' => [
            [
                'name' => 'BTV World (বিটিভি ওয়ার্ল্ড)',
                'logo' => 'https://ssl.com.bd/sites/default/files/BTV%20Logo%20Gallery.png',
                'url'  => 'https://btvworld.samit.co/hls/stream.m3u8',
                'url_backup' => 'http://103.4.144.137:8080/btv/BTVWorld_360p/index.m3u8',
                'desc' => 'বাংলাদেশ টেলিভিশনের আন্তর্জাতিক স্যাটেলাইট সংস্করণ।'
            ],
            [
                'name' => 'BTV National (বিটিভি জাতীয়)',
                'logo' => 'https://ssl.com.bd/sites/default/files/BTV%20Logo%20Gallery.png',
                'url'  => 'http://live.matribhumitv.com/btv/index.m3u8',
                'url_backup' => 'https://owrcovcrpy.gpcdn.net/bpk-tv/1709/output/index.m3u8',
                'desc' => 'বাংলাদেশ টেলিভিশন (BTV) রাষ্ট্রীয় মূল চ্যানেল।'
            ],
            [
                'name' => 'Zee Bangla (জি বাংলা)',
                'logo' => 'https://img.icons8.com/color/96/video.png',
                'url'  => 'http://live.matribhumitv.com/zee-bangla/index.m3u8',
                'url_backup' => 'https://bldcmprod-cdn.toffeelive.com/cdn/live/zee_bangla/playlist.m3u8',
                'desc' => 'জি বাংলা লাইভ ড্রামা এবং মেগা সিরিয়াল।'
            ],
            [
                'name' => 'NTV (এনটিভি)',
                'logo' => 'https://www.ntvbd.com/sites/default/files/aggregator/2020/02/17/ntv-channel_0.jpg',
                'url'  => 'http://live.matribhumitv.com/ntv/index.m3u8',
                'url_backup' => 'https://owrcovcrpy.gpcdn.net/bpk-tv/1716/output/index.m3u8',
                'desc' => 'এনটিভি লাইভ এন্টারটেইনমেন্ট ও মেগা প্রজেক্ট।'
            ],
            [
                'name' => 'RTV (আরটিভি)',
                'logo' => 'https://img.icons8.com/color/96/cinema.png',
                'url'  => 'http://live.matribhumitv.com/rtv/index.m3u8',
                'url_backup' => 'https://bldcmprod-cdn.toffeelive.com/cdn/live/rtv/playlist.m3u8',
                'desc' => 'আরটিভি লাইভ বাংলা নাটক, সিনেমা ও টকশো।'
            ],
            [
                'name' => 'Duronto TV (দুরন্ত টিভি)',
                'logo' => 'https://img.icons8.com/color/96/toy-car.png',
                'url'  => 'http://live.matribhumitv.com/duronto/index.m3u8',
                'url_backup' => '',
                'desc' => 'শিশুদের শিক্ষামূলক ও বিনোদনমূলক কার্টুন টিভি।'
            ]
        ]
    ]
];
?>

<!-- GOOGLE ADSENSE FRIENDLY SPACER -->
<div class="adsense-safety-header" style="height: 20px; display: block; clear: both;"></div>

<div id="cyber-tv-pro">
    <div style="max-width: 1280px; margin: 0 auto;">
        
        <!-- HEADER STATUS MODULE -->
        <header style="background: rgba(13, 21, 39, 0.6); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 25px; box-shadow: 0 0 20px rgba(0, 240, 255, 0.05);">
            <div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span class="pulse-beacon" style="display: inline-block; width: 10px; height: 10px; background: #00f0ff; border-radius: 50%; box-shadow: 0 0 8px #00f0ff; animation: pulse-neon 1.5s infinite;"></span>
                <font style="font-family: 'JetBrains Mono', monospace; font-size: 13px; color: #00f0ff; letter-spacing: 2px;">STATION COORD: 2040.LIVE.STATION</font>
            </div>
            <h1 class="main-title-tv" style="margin: 0; color: #fff; font-size: 28px; font-weight: 700; text-shadow: 0 0 15px rgba(0,240,255,0.4); font-family: 'Space Grotesk', sans-serif;">
                📡 IBD CYBER TV NET-GEN MATRIX
            </h1>
            <p style="color: #a0aec0; font-size: 14.5px; margin: 8px 0 0 0; font-family: 'Hind Siliguri', sans-serif;">
                কোনো কুকি ট্র্যাকিং বা পপআপ বিজ্ঞাপন ছাড়া শতভাগ গুগল অ্যাডসেন্স নিয়মনীতি সম্মত উন্মুক্ত টেলিভিশন ব্রডকাস্টার হাব।
            </p>
        </header>

        <!-- LAYOUT GRID -->
        <div class="tv-layout">
            
            <!-- LEFT LAYER: PLAYER & TELEMETRY -->
            <div class="player-column" style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- STICKY DRIVEN PLAYER CARD -->
                <div class="sticky-player-card" style="background: #0d1527; border: 2px solid #00f0ff; border-radius: 12px; overflow: hidden; box-shadow: 0 0 25px rgba(0, 240, 255, 0.15);">
                    <!-- 16:9 BULLETPROOF ASPECT RATIO CONTAINER -->
                    <div style="position: relative; width: 100%; padding-top: 56.25%; background: #000; overflow: hidden; -webkit-backface-visibility: hidden; backface-visibility: hidden;">
                        <video id="main-video-player" controls autoplay style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: block; object-fit: contain; background: #000; border: none; outline: none;"></video>
                    </div>
                    
                    <!-- TELEMETRY FEED -->
                    <div class="telemetry-block" style="padding: 15px; background: #0d1527; border-top: 2px solid #00f0ff; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                        <div class="now-playing-info" style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0;">
                            <img id="now-playing-logo" src="https://img.icons8.com/color/96/trophy.png" style="width: 45px; height: 45px; flex-shrink: 0; object-fit: contain; border-radius: 6px; background: rgba(0,0,0,0.3); border: 1px solid rgba(0,240,255,0.2); padding: 5px;">
                            <div style="min-width: 0; flex: 1;">
                                <div id="playing-now" style="font-weight: 600; font-size: 16px; color: #fff; transform: translateZ(0); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">🏆 FIFA World Cup Live (টি স্পোর্টস)</div>
                                <div id="playing-now-desc" style="font-size: 12px; color: #cbd5e0; font-family: 'Hind Siliguri', sans-serif; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">ফিফা বিশ্বকাপ ফুটবল, ক্রিকেট এবং সরাসরি খেলাধুলার প্রিমিয়াম স্ট্রিমিং।</div>
                            </div>
                        </div>
                        
                        <!-- SIGNAL GATE INDICATORS -->
                        <div style="display: flex; gap: 10px; align-items: center; flex-shrink: 0;">
                            <div style="text-align: right; font-family: 'JetBrains Mono', monospace; font-size: 11px; color: #a0aec0;">
                                <div style="color: #00ff41;">● SIGNAL: SECURE</div>
                                <div id="server-label">SERVER: PRIMARY (BDIX)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SIGNAL CONTROL PANEL (UPLINK SWITCHER) -->
                <div style="background: rgba(13, 21, 39, 0.6); border: 1px solid rgba(0, 240, 255, 0.1); border-radius: 12px; padding: 20px;">
                    <h3 style="color: #ffaa00; margin: 0 0 10px 0; font-size: 16px; font-family: 'Space Grotesk', sans-serif;"><i class="fa-solid fa-server"></i> 📡 SIGNAL UPLINK SERVER SHIFTER</h3>
                    <p style="font-size: 13px; color: #cbd5e0; margin: 0 0 15px 0; font-family: 'Hind Siliguri', sans-serif; line-height: 1.5;">
                        লিংক বাফার করলে অথবা অফলাইন দেখালে নিচের বোতামগুলো চেপে সার্ভার পরিবর্তন করুন। এছাড়া যেকোনো বাইরের <strong>Custom .m3u8</strong> এড্রেস দিয়ে সরাসরি এই উন্নত প্লেয়ারে প্লে করতে পারেন।
                    </p>
                    
                    <div class="switcher-btn-group" style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <button onclick="switchServer('primary')" style="flex: 1; min-width: 140px; background: #00f0ff; color: #070b13; border: none; padding: 10px 15px; font-weight: bold; font-size: 13px; border-radius: 6px; cursor: pointer; transition: 0.2s; font-family: 'JetBrains Mono', sans-serif; text-transform: uppercase;">
                            Primary Stream (Server 1)
                        </button>
                        <button id="backup-btn" onclick="switchServer('backup')" style="flex: 1; min-width: 140px; background: rgba(0,240,255,0.08); border: 1px solid #00f0ff; color: #00f0ff; padding: 10px 15px; font-weight: bold; font-size: 13px; border-radius: 6px; cursor: pointer; transition: 0.2s; font-family: 'JetBrains Mono', sans-serif; text-transform: uppercase;">
                            Fallback Stream (Server 2)
                        </button>
                    </div>

                    <!-- CUSTOM STREAM INJECT MODULE -->
                    <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed rgba(0, 240, 255, 0.15);">
                        <label style="display: block; font-size: 13px; color: #fff; margin-bottom: 8px; font-family: 'Hind Siliguri', sans-serif;"><i class="fa-solid fa-cloud-arrow-up"></i> কাস্টম .m3u8 স্ট্রিমিং লিঙ্ক প্লে করুন:</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="custom-hls-url" placeholder="https://example.com/live/stream.m3u8" style="flex: 1; min-width: 0; padding: 10px; background: #070b13; border: 1px solid rgba(0, 240, 255, 0.3); color: #00f0ff; border-radius: 6px; font-size: 13px; font-family: 'JetBrains Mono', monospace;">
                            <button onclick="injectCustomStream()" style="background: #ffaa00; color: #070b13; border: none; font-weight: bold; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 12.5px; font-family: 'Hind Siliguri', sans-serif;">ইউপি লিঙ্ক করুন</button>
                        </div>
                    </div>
                </div>

                <!-- DETAILED USER MANUAL & POLICY NOTICE -->
                <div style="background: rgba(13, 21, 39, 0.4); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 20px; font-family: 'Hind Siliguri', sans-serif; line-height: 1.6; font-size: 13px;">
                    <h4 style="color: #fff; margin: 0 0 10px 0; font-size: 15px;" id="how-to-watch">💡 ফ্রিকোয়েন্টলি আস্কড কোয়েশ্চেন এবং ট্রাবলশুট গাইড:</h4>
                    <p style="color: #cbd5e0; margin-bottom: 10px;">
                        ১. <strong>কোনো চ্যানেল বাফার করলে বা না চললে কি করবেন?</strong><br>
                        আমাদের সিস্টেমে প্রতি চ্যানেলে দুটি ভিন্ন সোর্স ইনজেক্ট করা আছে। ভিডিও প্লেয়ারের নিচ থেকে <strong>Backup Stream (Server 2)</strong> বোতামে চাপ দিলে অল্টারনেট সার্ভার রানিং হবে।
                    </p>
                    <p style="color: #cbd5e0; margin-bottom: 10px;">
                        ২. <strong>আইওএস (iOS) ব্যাকআপ কেমন?</strong><br>
                        আমরা এই নেক্সট লেভেল প্লেয়ার স্ক্রিপ্টে সাফারি এবং অ্যাপল ডিভাইসের নেটিভ .m3u8 ডিরেক্ট প্লেব্যাক ইন্টিগ্রেট করেছি। আইফোন, আইপ্যাড বা ম্যাকবুক থেকেও এখন ওয়ান-ক্লিকে যেকোনো চ্যানেল স্মুথলি দেখতে পারবেন।
                    </p>
                    <p style="color: #cbd5e0; margin: 0;">
                        ৩. <strong>গুগল অ্যাডসেন্স নিয়মনীতি তথ্য:</strong><br>
                        এই প্লে টুলটি কোনো মিডিয়া ব্রডকাস্ট বা স্ট্রিমিং নিজের সার্ভারে হোস্ট করে না। এটি ইন্টারনেটে উন্মুক্ত থাকা এবং থার্ড-পার্টি সার্ভিস প্রোভাইডারদের ফ্রি-টু-এয়ার আইপিটিভি চ্যানেলের উন্মুক্ত লিংকগুলো এক জায়গায় সংকলন করেছে মাত্র।
                    </p>
                </div>

            </div>

            <!-- RIGHT LAYER: BEAUTIFUL BENTO CHANNELS LIST -->
            <div class="channels-column" style="display: flex; flex-direction: column; gap: 20px;">
                
                <!-- CHANNEL SEARCH & PRESETS -->
                <div style="background: rgba(13, 21, 39, 0.6); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 20px;">
                    <h3 style="color: #00f0ff; margin: 0 0 15px 0; font-size: 17px;"><i class="fa-solid fa-tv"></i> CHANNELS SELECTOR</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 15px;">
                        <!-- Category Buttons Navigation -->
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <button onclick="filterTv('all')" class="cat-btn active-cat" id="btn-all" style="padding: 6px 12px; font-size: 11px; background: #00f0ff; color: #070b13; border: none; border-radius: 4px; cursor: pointer; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; font-weight: bold;">ALL</button>
                            <button onclick="filterTv('sports')" class="cat-btn" id="btn-sports" style="padding: 6px 12px; font-size: 11px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; cursor: pointer; font-family: 'JetBrains Mono', monospace; text-transform: uppercase;">SPORTS</button>
                            <button onclick="filterTv('news')" class="cat-btn" id="btn-news" style="padding: 6px 12px; font-size: 11px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; cursor: pointer; font-family: 'JetBrains Mono', monospace; text-transform: uppercase;">NEWS</button>
                            <button onclick="filterTv('entertainment')" class="cat-btn" id="btn-entertainment" style="padding: 6px 12px; font-size: 11px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; cursor: pointer; font-family: 'JetBrains Mono', monospace; text-transform: uppercase;">ENTERTAINMENT</button>
                            
                            <?php if(!empty($m3u_channels)): ?>
                            <button onclick="filterTv('playlist')" class="cat-btn" id="btn-playlist" style="padding: 6px 12px; font-size: 11px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; cursor: pointer; font-family: 'JetBrains Mono', monospace; text-transform: uppercase;">M3U PLAYLIST</button>
                            <?php endif; ?>

                            <?php if(!empty($json_channels)): ?>
                            <button onclick="filterTv('json_db')" class="cat-btn" id="btn-json_db" style="padding: 6px 12px; font-size: 11px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; cursor: pointer; font-family: 'JetBrains Mono', monospace; text-transform: uppercase;">CYBER PRO PLAYLIST (137 CH)</button>
                            <?php endif; ?>
                        </div>
                        <input type="text" id="tv-filter-input" onkeyup="searchTvLocal()" placeholder="চ্যানেলের নাম খুঁজুন..." style="width: 100%; padding: 10px; background: #070b13; border: 1px solid rgba(0, 240, 255, 0.15); color: #00f0ff; border-radius: 6px; font-size: 13px; font-family: 'Hind Siliguri', sans-serif;">
                    </div>

                    <!-- SCROLLABLE CHANNELS LIST -->
                    <div id="unified-tv-container" style="max-height: 580px; overflow-y: auto; padding-right: 5px;">
                        
                        <!-- HIGH PERFORMANCE DEFAULT CHANNELS -->
                        <?php foreach($stable_categories as $cat): ?>
                        <div class="cat-section" data-cat="<?php echo $cat['category_id']; ?>" style="margin-bottom: 20px;">
                            <div style="font-size: 12px; color: #ffaa00; text-transform: uppercase; font-family: 'JetBrains Mono', monospace; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px dashed rgba(255, 170, 0, 0.2); font-weight: bold; display: flex; align-items: center; justify-content: space-between;">
                                <span><?php echo $cat['category_en']; ?></span>
                                <span style="background: rgba(255, 170, 0, 0.1); padding: 2px 6px; border-radius: 3px; font-size: 9px; color: #ffaa00;">STA LI_V</span>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <?php foreach($cat['channels'] as $chan): ?>
                                <div class="unified-tv-card" 
                                     data-name="<?php echo strtolower($chan['name']); ?>" 
                                     onclick="playTarget('<?php echo $chan['url']; ?>', '<?php echo addslashes($chan['name']); ?>', '<?php echo $chan['logo']; ?>', '<?php echo addslashes($chan['desc']); ?>', '<?php echo $chan['url_backup']; ?>')"
                                     style="background: rgba(13, 21, 39, 0.4); border: 1px solid rgba(0, 240, 255, 0.1); border-radius: 8px; padding: 12px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: 0.2s;">
                                    
                                    <div style="width: 45px; height: 45px; flex-shrink: 0; background: #000; border-radius: 6px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid rgba(255,255,255,0.05);">
                                        <img src="<?php echo $chan['logo']; ?>" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                                    </div>

                                    <div style="flex: 1; min-width: 0;">
                                        <div style="font-size: 13.5px; font-weight: bold; color: #fff; margin-bottom: 2px;"><?php echo $chan['name']; ?></div>
                                        <div style="font-size: 11px; color: #cbd5e0; font-family: 'Hind Siliguri', sans-serif; height: 16px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $chan['desc']; ?></div>
                                    </div>
                                    
                                    <span style="font-size: 10px; color: #00ff41; background: rgba(0, 255, 65, 0.08); padding: 3px 6px; border-radius: 3px; font-family: 'JetBrains Mono', monospace; font-weight: bold; flex-shrink: 0;">LIVE</span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- UPLOADED M3U PLAYLIST CHANNELS -->
                        <?php if(!empty($m3u_channels)): ?>
                        <div class="cat-section" data-cat="playlist" style="margin-bottom: 20px;">
                            <div style="font-size: 12px; color: #00f0ff; text-transform: uppercase; font-family: 'JetBrains Mono', monospace; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px dashed rgba(0, 240, 255, 0.2); font-weight: bold;">
                                📁 Playlist (1).m3u Loaded Channels (প্লেলিস্টের চ্যানেল)
                            </div>

                            <div class="m3u-grid">
                                <?php foreach($m3u_channels as $chan2): 
                                    if(empty($chan2['name'])) continue;
                                    $display_logo2 = !empty($chan2['logo']) ? $chan2['logo'] : "https://ui-avatars.com/api/?name=" . urlencode($chan2['name']) . "&background=00f0ff&color=070b13&bold=true";
                                ?>
                                <div class="unified-tv-card-grid unified-tv-card" 
                                     data-name="<?php echo strtolower($chan2['name']); ?>" 
                                     onclick="playTarget('<?php echo $chan2['url']; ?>', '<?php echo addslashes($chan2['name']); ?>', '<?php echo $display_logo2; ?>', 'Playlist (1).m3u - External URL Stream Link Content', '')"
                                     style="background: rgba(13, 21, 39, 0.3); border: 1px solid rgba(255, 255, 255, 0.04); border-radius: 8px; padding: 10px; text-align: center; cursor: pointer; transition: 0.2s;">
                                    <div style="width: 100%; height: 50px; display: flex; align-items: center; justify-content: center; background: #000; border-radius: 5px; margin-bottom: 6px; overflow: hidden;">
                                        <img src="<?php echo $display_logo2; ?>" onerror="this.src='https://img.icons8.com/color/96/television.png';" style="max-height: 85%; max-width: 85%; object-fit: contain;">
                                    </div>
                                    <div style="font-size: 11px; font-weight: 500; height: 28px; overflow: hidden; line-height: 1.2; color: #fff; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo $chan2['name']; ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- UPLOADED JSON CHANNELS (Channels_data.json) -->
                        <?php if(!empty($json_channels)): ?>
                        <div class="cat-section" data-cat="json_db" style="margin-bottom: 20px;">
                            <div style="font-size: 12px; color: #00f0ff; text-transform: uppercase; font-family: 'JetBrains Mono', monospace; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px dashed rgba(0, 240, 255, 0.2); font-weight: bold;">
                                📁 Premium Cyber Pro Playlist (137 Live channels)
                            </div>

                            <div class="m3u-grid">
                                <?php foreach($json_channels as $json_chan): 
                                    $display_logo3 = "https://ui-avatars.com/api/?name=" . urlencode($json_chan['name']) . "&background=00f0ff&color=070b13&bold=true";
                                ?>
                                <div class="unified-tv-card-grid unified-tv-card" 
                                     data-name="<?php echo strtolower($json_chan['name']); ?>" 
                                     onclick="playTarget('<?php echo $json_chan['url']; ?>', '<?php echo addslashes($json_chan['name']); ?>', '<?php echo $display_logo3; ?>', 'Verified High-Speed Streaming stream link from Cyber Pro playlist database.', '')"
                                     style="background: rgba(13, 21, 39, 0.3); border: 1px solid rgba(255, 255, 255, 0.04); border-radius: 8px; padding: 10px; text-align: center; cursor: pointer; transition: 0.2s;">
                                    <div style="width: 100%; height: 50px; display: flex; align-items: center; justify-content: center; background: #000; border-radius: 5px; margin-bottom: 6px; overflow: hidden;">
                                        <img src="<?php echo $display_logo3; ?>" onerror="this.src='https://img.icons8.com/color/96/television.png';" style="max-height: 85%; max-width: 85%; object-fit: contain;">
                                    </div>
                                    <div style="font-size: 11px; font-weight: 500; height: 28px; overflow: hidden; line-height: 1.2; color: #fff; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo $json_chan['name']; ?></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
        
    </div>
</div>

<!-- GOOGLE ADSENSE FRIENDLY SPACER -->
<div class="adsense-safety-footer" style="height: 30px; display: block; clear: both;"></div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    const player = document.getElementById('main-video-player');
    const label = document.getElementById('playing-now');
    const descLabel = document.getElementById('playing-now-desc');
    const miniLogo = document.getElementById('now-playing-logo');
    const serverLabel = document.getElementById('server-label');
    const backupBtn = document.getElementById('backup-btn');

    let currentUrlPrimary = '';
    let currentUrlBackup = '';
    let currentStreamName = '';
    let currentLogo = '';
    let currentDesc = '';
    let selectedServer = 'primary';

    // ১. প্লেব্যাক ইন্টিগ্রেশন মেকানিজম
    function playTarget(url, name, logo, desc, backupUrl) {
        currentUrlPrimary = url;
        currentUrlBackup = backupUrl ? backupUrl : url;
        currentStreamName = name;
        currentLogo = logo;
        currentDesc = desc ? desc : "Live stream broadcasting link from secure server.";
        
        // বাটন কন্ট্রোল সচল রাখা
        if (backupUrl && backupUrl !== url) {
            backupBtn.style.display = "inline-block";
        } else {
            backupBtn.style.display = "none";
        }

        // রানিং সার্ভার সিঙ্ক
        selectedServer = 'primary';
        serverLabel.innerText = "SERVER: PRIMARY (BDIX)";
        serverLabel.style.color = "#00ff41";

        loadAndPlay(currentUrlPrimary);
    }

    function loadAndPlay(streamUrl) {
        label.innerText = "Uplinking: " + currentStreamName;
        descLabel.innerText = currentDesc;
        miniLogo.src = currentLogo;
        
        // Hls.js initialization
        if (Hls.isSupported()) {
            if (window.hls) {
                window.hls.destroy();
            }
            const hls = new Hls({
                maxMaxBufferLength: 10,
                enableWorker: true
            });
            window.hls = hls;
            hls.loadSource(streamUrl);
            hls.attachMedia(player);
            hls.on(Hls.Events.MANIFEST_PARSED, () => {
                player.play().catch(() => {});
                label.innerText = currentStreamName;
            });
            hls.on(Hls.Events.ERROR, function (event, data) {
                if (data.fatal) {
                    label.innerText = "⚠️ Network Congested (সার্ভার লোড হচ্ছে বা অফলাইন)";
                }
            });
        } 
        // iOS/Safari Native HLS Support
        else if (player.canPlayType('application/vnd.apple.mpegurl')) {
            player.src = streamUrl;
            player.addEventListener('loadedmetadata', function() {
                player.play().catch(() => {});
                label.innerText = currentStreamName;
            });
            player.onerror = function() {
                label.innerText = "⚠️ Error playing: " + currentStreamName;
            };
        } else {
            label.innerText = "❌ HLS unsupported by browser.";
        }
    }

    // ২. সার্ভার সুইচার মেকানিজম
    function switchServer(server) {
        if (server === 'primary') {
            selectedServer = 'primary';
            serverLabel.innerText = "SERVER: PRIMARY (BDIX)";
            serverLabel.style.color = "#00ff41";
            loadAndPlay(currentUrlPrimary);
        } else {
            selectedServer = 'backup';
            serverLabel.innerText = "SERVER: FALLBACK (CDN)";
            serverLabel.style.color = "#ffaa00";
            loadAndPlay(currentUrlBackup);
        }
    }

    // ৩. কাস্টম স্ট্রিম ইনজেক্টর
    function injectCustomStream() {
        const urlInput = document.getElementById('custom-hls-url').value.trim();
        if (!urlInput) {
            alert('দয়া করে একটি সঠিক .m3u8 লিংক প্রদান করুন!');
            return;
        }
        currentUrlPrimary = urlInput;
        currentUrlBackup = urlInput;
        currentStreamName = "📡 [CUSTOM INJECTED PLY]";
        currentLogo = "https://img.icons8.com/color/96/transmission-tower.png";
        currentDesc = "ব্যবহারকারী দ্বারা ইনজেক্ট করা কাস্টম ডাটা প্রটোকল লিঙ্ক।";
        backupBtn.style.display = "none";
        
        loadAndPlay(urlInput);
    }

    // ৪. ক্যাটাগরি ফিল্টার
    function filterTv(cat) {
        // Active buttons state toggle
        document.querySelectorAll('.cat-btn').forEach(btn => {
            btn.classList.remove('active-cat');
            btn.style.background = 'rgba(255,255,255,0.05)';
            btn.style.color = '#fff';
            btn.style.border = '1px solid rgba(255,255,255,0.1)';
        });
        
        const activeBtn = document.getElementById('btn-' + cat);
        if (activeBtn) {
            activeBtn.classList.add('active-cat');
            activeBtn.style.background = '#00f0ff';
            activeBtn.style.color = '#070b13';
            activeBtn.style.border = 'none';
        }

        // Sections filter toggling
        const sections = document.querySelectorAll('.cat-section');
        sections.forEach(sec => {
            if (cat === 'all') {
                sec.style.display = 'block';
            } else {
                if (sec.getAttribute('data-cat') === cat) {
                    sec.style.display = 'block';
                } else {
                    sec.style.display = 'none';
                }
            }
        });
    }

    // ৫. লোকাল চ্যানেল সার্চ
    function searchTvLocal() {
        const query = document.getElementById('tv-filter-input').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.unified-tv-card');
        
        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            if (name.includes(query)) {
                card.style.display = 'flex';
                if(card.classList.contains('unified-tv-card-grid')) {
                    card.style.display = 'block';
                }
            } else {
                card.style.display = 'none';
            }
        });
    }

    // ৬. অটোমেটিক ফার্স্ট বুকিং প্লে
    document.addEventListener("DOMContentLoaded", function() {
        playTarget(
            'http://live.matribhumitv.com/tsports/index.m3u8', 
            '🏆 FIFA World Cup Live (টি স্পোর্টস)', 
            'https://img.icons8.com/color/96/trophy.png', 
            'ফিফা বিশ্বকাপ ফুটবল, ক্রিকেট এবং সরাসরি খেলাধুলার প্রিমিয়াম স্ট্রিমিং।', 
            'https://byphdgllyk.gpcdn.net/hls/tsports/master.m3u8'
        );
    });
</script>

<style>
    /* 2040 Cyber Core Typography Styles */
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');
    
    /* Global layout safety resets for cyber-tv to override WordPress theme bugs */
    #cyber-tv-pro, #cyber-tv-pro * {
        box-sizing: border-box !important;
    }
    
    #cyber-tv-pro {
        overflow-x: hidden !important;
        position: relative !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* Move inline grid template to CSS class to avoid inline specificity issues */
    .tv-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 25px;
    }

    @keyframes pulse-neon {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(1.2); }
    }
    
    .unified-tv-card:hover {
        background: rgba(0, 240, 255, 0.08) !important;
        border-color: #00f0ff !important;
        box-shadow: 0 0 15px rgba(0, 240, 255, 0.25);
        transform: translateY(-2px);
    }
    .active-tv {
        background: rgba(0, 240, 255, 0.12) !important;
        border-color: #00f0ff !important;
    }

    /* Sticky Player Styling for Screen Widths > 820px */
    .sticky-player-card {
        position: sticky;
        top: 20px;
        z-index: 10;
        transition: all 0.3s ease;
        width: 100% !important;
        max-width: 100% !important;
    }

    /* Default Grid for Loaded channels */
    .m3u-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(115px, 1fr));
        gap: 10px;
    }
    
    /* Responsive Styling Custom Controls */
    @media (max-width: 820px) {
        .tv-layout {
            grid-template-columns: 1fr !important;
            gap: 15px !important;
        }
        .main-title-tv {
            font-size: 20px !important;
        }
        .sticky-player-card {
            position: relative !important;
            top: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
    }

    @media (max-width: 480px) {
        #cyber-tv-pro {
            padding: 10px 12px !important;
        }
        .telemetry-block {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
            padding: 10px !important;
        }
        .now-playing-info {
            max-width: 100% !important;
            width: 100% !important;
            gap: 8px !important;
        }
        #now-playing-logo {
            width: 38px !important;
            height: 38px !important;
            padding: 2px !important;
        }
        #playing-now {
            font-size: 13.5px !important;
        }
        #playing-now-desc {
            font-size: 10.5px !important;
            white-space: normal !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }
        
        /* 2-Column Symmetric Grid on Mobile for Switcher */
        .switcher-btn-group {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 8px !important;
        }
        .switcher-btn-group button {
            padding: 8px 10px !important;
            font-size: 11.5px !important;
            min-width: unset !important;
            text-align: center !important;
        }

        /* 3-Column Compact Grid on Mobile for Playlist Channels */
        .m3u-grid {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 6px !important;
        }
        .unified-tv-card-grid {
            padding: 6px !important;
            border-radius: 6px !important;
        }
        .unified-tv-card-grid div:first-child {
            height: 40px !important;
            margin-bottom: 4px !important;
        }
        .unified-tv-card-grid div:last-child {
            font-size: 9.5px !important;
            height: 24px !important;
        }

        /* Tighter standard card list items on Mobile */
        .unified-tv-card {
            padding: 8px 10px !important;
            gap: 8px !important;
        }
        .unified-tv-card img {
            width: 35px !important;
            height: 35px !important;
        }
        .unified-tv-card div div:first-child {
            font-size: 12.5px !important;
        }
        .unified-tv-card div div:last-child {
            font-size: 10px !important;
        }
    }
    
    /* Hide default scrollbars visually but keep responsive behavior */
    #unified-tv-container::-webkit-scrollbar {
        width: 4px;
    }
    #unified-tv-container::-webkit-scrollbar-thumb {
        background: #00f0ff;
        border-radius: 10px;
    }
    #unified-tv-container::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.2);
    }
</style>

<?php get_footer(); ?>
