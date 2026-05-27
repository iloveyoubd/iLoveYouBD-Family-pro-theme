<?php
/**
 * Template Part: Cyber Social Media Hub
 * Fully custom design featuring integrated YouTube, Facebook Page, Facebook Group, and TikTok components.
 */

$neon = get_option('ilybd_main_color', '#00ff41');

// Fetch dynamic links from database options with sleek defaults
$yt_link  = get_option('ilybd_social_youtube', 'https://youtube.com/@iloveyoubd');
$yt_video = get_option('ilybd_social_yt_video', 'dQw4w9WgXcQ'); // default fallback video ID
$fb_page  = get_option('ilybd_social_facebook', 'https://facebook.com/iloveyoubd');
$fb_group = get_option('ilybd_social_fb_group', 'https://facebook.com/groups/iloveyoubd');
$tt_link  = get_option('ilybd_social_tiktok', 'https://tiktok.com/@iloveyoubd');

// Parse video ID if user pasted full YouTube URL
if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/||user/[^/]+/)|youtu\.be/)([^"&?/\s]{11})%i', $yt_video, $match)) {
    $video_id = $match[1];
} else {
    $video_id = sanitize_text_field($yt_video);
}
?>

<div class="cyber-social-hub-section">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <!-- SECTION TITLE -->
        <div class="hub-header">
            <span class="hub-icon-live">📡</span>
            <div class="hub-header-titles">
                <h2 class="rgb-gradient-text"> Ilybd System Social Hub </h2>
                <p class="hub-subtitle">আমাদের অফিশিয়াল সোশ্যাল নেটওয়ার্ক নোডগুলির সাথে ইনডেক্স করুন</p>
            </div>
            <div class="hub-status-bar">
                <span class="status-indicator-dot anim-pulse"></span>
                <span class="status-indicator-text">SYSLINK ACTIVE</span>
            </div>
        </div>

        <div class="sticky-slide-line bg-hub-sliding"></div>

        <div class="hub-grid">
            
            <!-- LEFT WIDGET: YOUTUBE FEATURED VIDEO & SUBSCRIBE CONTAINER -->
            <div class="hub-card yt-cyber-glow">
                <div class="hub-card-accent red-accent"></div>
                
                <div class="yt-header">
                    <div class="yt-logo-box">
                        <span class="yt-icon">🔴</span>
                        <div>
                            <h3>ইউটিউব অফিশিয়াল চ্যানেল</h3>
                            <span class="sub-meta-count">DAILY TECH GUIDES & CRACKING FILES</span>
                        </div>
                    </div>
                    <a href="<?php echo esc_url($yt_link); ?>" target="_blank" class="yt-badge">SUBSCRIBE</a>
                </div>

                <!-- Featured Responsive Video Embed Player -->
                <div class="yt-player-container">
                    <?php if (!empty($video_id)): ?>
                        <iframe 
                            src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?rel=0&amp;showinfo=0" 
                            title="Ilybd Featured Video" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    <?php else: ?>
                        <div class="yt-player-fallback">
                            <span>No featured video configured in control panel.</span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="yt-actions-footer">
                    <div class="yt-stats">
                        <div class="stat-unit">
                            <span class="stat-num">100K+</span>
                            <span class="stat-lbl">সদস্য</span>
                        </div>
                        <div class="stat-unit">
                            <span class="stat-num">Daily</span>
                            <span class="stat-lbl font-mono">Uplinks</span>
                        </div>
                    </div>
                    
                    <!-- EXQUISITE DIRECT SUBSCRIBE TRIGGER WITH CONSOLE GLOW -->
                    <a href="<?php echo esc_url($yt_link . '?sub_confirmation=1'); ?>" target="_blank" class="cyber-btn-social btn-yt">
                        <span class="btn-ripple"></span>
                        <span class="btn-text">🔔 চ্যানেলটি সাবস্ক্রাইব করুন</span>
                    </a>
                </div>
            </div>

            <!-- RIGHT MODULE: FACEBOOK & TIKTOK MULTI-CARD PANEL -->
            <div class="hub-right-column">
                
                <!-- FB PAGE CARD -->
                <div class="hub-card fb-cyber-glow">
                    <div class="hub-card-accent blue-accent"></div>
                    <div class="card-body-flex">
                        <div class="card-icon-avatar font-fb">f</div>
                        <div class="card-details-main">
                            <h3>আই লাভ ইউ বিডি ফেসবুক পেজ</h3>
                            <p class="card-desc">প্রতিদিনের গুরুত্বপূর্ণ টেক টিউন, ফ্রী-নেট আপডেট ও নোটিফিকেশন পেতে সরাসরি আমাদের পেজে লাইক দিয়ে যুক্ত থাকুন।</p>
                            
                            <!-- ACTIONS -->
                            <div class="card-actions-row">
                                <a href="<?php echo esc_url($fb_page); ?>" target="_blank" class="cyber-btn-social btn-fb">
                                    <span class="btn-text">👍 পেজে লাইক দিন</span>
                                </a>
                                <a href="<?php echo esc_url($fb_page); ?>" target="_blank" class="social-outline-btn">
                                    <span>ভিজিট পেজ</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FB GROUP CARD -->
                <div class="hub-card group-cyber-glow">
                    <div class="hub-card-accent cyan-accent"></div>
                    <div class="card-body-flex">
                        <div class="card-icon-avatar font-group">👥</div>
                        <div class="card-details-main">
                            <h3>অফিশিয়াল হেল্পডেস্ক ফেসবুক গ্রুপ</h3>
                            <p class="card-desc">আপনার যেকোনো সমস্যা বা প্রশ্নের তাৎক্ষনিক সমাধানের জন্য বাংলাদেশসেরা ৫ লক্ষ+ টেক লাভারদের হেল্পিং গ্রুপে পোস্ট করুন।</p>
                            
                            <!-- ACTIONS -->
                            <div class="card-actions-row">
                                <a href="<?php echo esc_url($fb_group); ?>" target="_blank" class="cyber-btn-social btn-group">
                                    <span class="btn-text">🚀 গ্রুপে জয়েন করুন</span>
                                </a>
                                <a href="<?php echo esc_url($fb_group); ?>" target="_blank" class="social-outline-btn">
                                    <span>হেল্প ফোরাম</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TIKTOK CARD -->
                <div class="hub-card tt-cyber-glow">
                    <div class="hub-card-accent tt-accent"></div>
                    <div class="card-body-flex">
                        <div class="card-icon-avatar font-tt">🎵</div>
                        <div class="card-details-main">
                            <h3>টিকটক শর্ট ভিডিও কালেকশন</h3>
                            <p class="card-desc">সংক্ষিপ্ত ভিডিও মেকিং, ট্রিকস ক্যাটাগরি এবং স্পিড টিউটোরিয়ালগুলোর লাইভ আপডেট পেতে আমাদের টিকটক প্রোফাইল নোড ফলো রাখুন।</p>
                            
                            <!-- ACTIONS -->
                            <div class="card-actions-row">
                                <a href="<?php echo esc_url($tt_link); ?>" target="_blank" class="cyber-btn-social btn-tt">
                                    <span class="btn-text">🔥 ফলো করুন</span>
                                </a>
                                <a href="<?php echo esc_url($tt_link); ?>" target="_blank" class="social-outline-btn">
                                    <span>শর্ট টিউনস</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<style>
/* CYBER SOCIAL MEDIA HUB STYLES */
.cyber-social-hub-section {
    background: #06090d;
    border-top: 1px solid rgba(255, 255, 255, 0.04);
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    position: relative;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #e2e8f0;
}

/* SECTION HEADER */
.hub-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.hub-icon-live {
    font-size: 28px;
    animation: signal-beacon 2s infinite ease-in-out;
}

.hub-header-titles {
    flex: 1;
}

.rgb-gradient-text {
    font-size: 22px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin: 0;
    background: linear-gradient(to right, #ff0055, #00f0ff, #00ff41, #ff0055);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: rgb-slide-sliding 6s linear infinite;
}

.hub-subtitle {
    font-size: 13px;
    color: #718096;
    margin: 4px 0 0 0;
    font-weight: 600;
}

.hub-status-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 255, 65, 0.05);
    border: 1px solid rgba(0, 255, 65, 0.15);
    padding: 6px 14px;
    border-radius: 4px;
}

.status-indicator-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #00ff41;
    box-shadow: 0 0 8px #00ff41cc;
}

.status-indicator-text {
    font-size: 10px;
    font-family: monospace;
    font-weight: 800;
    color: #00ff41;
    letter-spacing: 1px;
}

/* Sliding border accent */
.sticky-slide-line {
    height: 2px;
    width: 100%;
    margin-bottom: 30px;
}

.bg-hub-sliding {
    background: linear-gradient(to right, #ff0055, #00f0ff, #0a0e14, #00ff41, #ff0055);
    background-size: 200% auto;
    animation: rgb-slide-sliding 10s linear infinite;
}

/* HUBS GRID */
.hub-grid {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 25px;
}

.hub-right-column {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* INTERACTIVE CARDS Structure */
.hub-card {
    background: #0a0e14;
    border: 1.5px solid rgba(255, 255, 255, 0.04);
    border-radius: 16px;
    padding: 24px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.hub-card-accent {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    transition: all 0.3s;
}

.red-accent { background: #ff0055; }
.blue-accent { background: #1877f2; }
.cyan-accent { background: #00f0ff; }
.tt-accent { background: linear-gradient(90deg, #ff0055, #00f0ff); }

/* GLOWS PRESET */
.yt-cyber-glow:hover {
    border-color: rgba(255, 0, 85, 0.25);
    box-shadow: 0 12px 30px rgba(255, 0, 85, 0.08);
    transform: translateY(-2px);
}
.fb-cyber-glow:hover {
    border-color: rgba(24, 119, 242, 0.25);
    box-shadow: 0 12px 30px rgba(24, 119, 242, 0.08);
    transform: translateY(-2px);
}
.group-cyber-glow:hover {
    border-color: rgba(0, 240, 255, 0.25);
    box-shadow: 0 12px 30px rgba(0, 240, 255, 0.08);
    transform: translateY(-2px);
}
.tt-cyber-glow:hover {
    border-color: rgba(255, 255, 255, 0.15);
    box-shadow: 0 12px 30px rgba(255, 0, 85, 0.05), 0 12px 30px rgba(0, 240, 255, 0.05);
    transform: translateY(-2px);
}

/* 1. YOUTUBE MODULE SPECIFICS */
.yt-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.yt-logo-box {
    display: flex;
    align-items: center;
    gap: 12px;
}

.yt-icon {
    font-size: 24px;
    animation: signal-beacon 1.5s infinite;
}

.yt-logo-box h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
}

.sub-meta-count {
    font-size: 10px;
    font-weight: 700;
    color: #4a5568;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.yt-badge {
    text-decoration: none;
    background: #ff0055;
    color: #fff;
    font-size: 9px;
    font-weight: 950;
    padding: 4px 10px;
    border-radius: 4px;
    letter-spacing: 1px;
    box-shadow: 0 0 10px rgba(255,0,85,0.4);
}

/* Responsve YouTube Embed Container with smart ratio aspect */
.yt-player-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 ratio */
    height: 0;
    overflow: hidden;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.05);
    box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    margin-bottom: 20px;
}

.yt-player-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.yt-player-fallback {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: #06090d;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4a5568;
    font-size: 14px;
}

.yt-actions-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.yt-stats {
    display: flex;
    gap: 15px;
}

.stat-unit {
    display: flex;
    flex-direction: column;
}

.stat-num {
    font-size: 16px;
    font-weight: 900;
    color: #fff;
    font-family: monospace;
    line-height: 1.1;
}

.stat-lbl {
    font-size: 9px;
    font-weight: 800;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* 2. CARD CONTENT FLEX */
.card-body-flex {
    display: flex;
    gap: 18px;
    align-items: flex-start;
}

.card-icon-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    box-shadow: 0 3px 12px rgba(0,0,0,0.4);
    font-weight: 900;
}

.font-fb { background: #1877f2; color: #fff; font-family: 'Inter', system-ui, sans-serif; font-size: 24px; line-height: 1; }
.font-group { background: #00f0ff; color: #000; }
.font-tt { background: radial-gradient(circle at 100% 0%, #00f0ff 0%, #ff0055 100%); color: #fff; }

.card-details-main {
    flex: 1;
}

.card-details-main h3 {
    margin: 0 0 6px 0;
    font-size: 15px;
    font-weight: 800;
    color: #fff;
}

.card-desc {
    font-size: 13px;
    line-height: 1.6;
    color: #a0aec0;
    margin: 0 0 15px 0;
}

.card-actions-row {
    display: flex;
    gap: 10px;
    align-items: center;
}

/* 3. SOLID CYBER SOCIAL BUTTONS */
.cyber-btn-social {
    background: transparent;
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    font-size: 12.5px;
    font-weight: 800;
    color: #fff;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.35);
}

.btn-yt { background: #ff0055; box-shadow: 0 4px 15px rgba(255,0,85,0.3); }
.btn-yt:hover { background: #e6004c; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(255,0,85,0.45); }

.btn-fb { background: #1877f2; box-shadow: 0 4px 15px rgba(24,119,242,0.3); }
.btn-fb:hover { background: #156bec; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(24,119,242,0.45); }

.btn-group { background: #00f0ff; color: #000; box-shadow: 0 4px 15px rgba(0,240,255,0.25); }
.btn-group:hover { background: #00d7e6; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,240,255,0.4); }

.btn-tt { background: #ff0055; box-shadow: 0 4px 15px rgba(255,0,85,0.2); }
.btn-tt:hover { background: #e6004c; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(255,0,85,0.35); }

/* OUTLINE SECONDARY BUTTONS */
.social-outline-btn {
    text-decoration: none;
    color: #cbd5e0;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.01);
    font-size: 11px;
    font-weight: 700;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s;
    text-transform: uppercase;
}

.social-outline-btn:hover {
    color: #fff;
    border-color: rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.04);
}

/* KEYFRAMES & RESPONSIVE DESIGN */
@keyframes signal-beacon {
    0%, 100% { opacity: 0.8; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.08); filter: drop-shadow(0 0 5px currentColor); }
}

@keyframes rgb-slide-sliding {
    to { background-position: 200% center; }
}

@keyframes anim-pulse {
    0% { transform: scale(0.9); opacity: 0.6; }
    100% { transform: scale(1.1); opacity: 1; }
}

@media (max-width: 900px) {
    .hub-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 500px) {
    .yt-actions-footer {
        flex-direction: column;
        align-items: stretch;
    }
    .yt-stats {
        justify-content: space-around;
        margin-bottom: 5px;
    }
    .card-body-flex {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .card-actions-row {
        justify-content: center;
    }
    .rgb-gradient-text {
        font-size: 18px;
    }
    .hub-header {
        flex-direction: column;
        text-align: center;
    }
}
</style>
