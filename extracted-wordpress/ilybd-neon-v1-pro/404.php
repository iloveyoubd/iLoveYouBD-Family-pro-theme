<?php
/**
 * The template for displaying 404 pages (Not Found) - Premium Cyber Glitch Edition
 */

get_header(); ?>

<div class="cyber-404-container">
    <div class="hacker-matrix-bg"></div>

    <div class="error-box-wrapper animate-glow">
        <div class="cyber-alert-header">
            <span class="pulse-dot"></span>
            <span class="terminal-tag"><i class="fa-solid fa-circle-exclamation text-rose-500"></i> SECURITY_GUARD: RESOURCE_NOT_FOUND</span>
            <span class="system-port">PORT: 404</span>
        </div>

        <div class="cyber-error-content">
            <!-- Glitchy Error Display -->
            <div class="glitch-wrapper">
                <h1 class="glitch-text" data-text="404">404</h1>
            </div>

            <h2 class="alert-title font-mono"><i class="fa-solid fa-terminal text-[#00ff41]"></i> সিস্টেম ডিরেক্টরি এরর!</h2>
            
            <p class="error-msg">
                দুঃখিত! আপনি সাইবার পোর্টালের এমন একটি ডিরেক্টরিতে প্রবশে করেছেন যার কোনো ফাইল আমাদের সার্ভারে মজুদ নেই। হয়ত ইউআরএল টাইপ করতে ভুল হয়েছে, অথবা আপনার কাঙ্ক্ষিত পোস্টটি ডিলিট বা রিমুভ করা হয়েছে।
            </p>

            <!-- Embedded Holographic Command Bar Search -->
            <div class="hologram-search-area">
                <p class="font-mono text-cyan-400 text-xs mb-3"><i class="fa-solid fa-square-terminal"></i> EXECUTE HELPER QUERY:</p>
                <form role="search" method="get" class="cyber-error-search" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-input-group">
                        <i class="fa-solid fa-terminal search-icon"></i>
                        <input type="search" class="search-field font-mono" placeholder="সার্চ দিয়ে কাঙ্ক্ষিত কন্টেন্ট বের করুন..." value="" name="s" required />
                        <button type="submit" class="search-btn"><i class="fa-solid fa-share-nodes"></i> রান</button>
                    </div>
                </form>
            </div>

            <!-- Operational Navigation Links Map -->
            <div class="portal-redirect-matrix">
                <p class="font-mono text-slate-500 text-[10.5px] uppercase tracking-wider mb-3">নিচের ব্যাকআপ গেটওয়েগুলো ব্যবহার করুন:</p>
                <div class="portal-grid">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="portal-btn neon-green-btn">
                        <i class="fa-solid fa-house-chimney"></i> হোমপেজে যান
                    </a>
                    <a href="<?php echo esc_url(home_url('/custom-qa')); ?>" class="portal-btn neon-blue-btn">
                        <i class="fa-solid fa-comments"></i> কমিউনিটি ফোরাম
                    </a>
                    <a href="<?php echo esc_url(home_url('/cricket')); ?>" class="portal-btn neon-purple-btn">
                        <i class="fa-solid fa-tv"></i> লাইভ খেলাধুলা
                    </a>
                </div>
            </div>
        </div>

        <div class="cyber-alert-footer font-mono">
            <span>[SYS_STATUS: READY]</span>
            <span>SYSTEM MONITOR v2.4.0</span>
        </div>
    </div>
</div>

<style>
.cyber-404-container {
    background: #06080e;
    min-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    position: relative;
    overflow: hidden;
}

/* Simulated Holographic Backdrop Lines */
.cyber-404-container::before {
    content: "";
    position: absolute;
    width: 200%;
    height: 200%;
    background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
    background-size: 100% 4px, 3px 100%;
    pointer-events: none;
    z-index: 5;
}

/* Matrix Binary Background Rain */
.hacker-matrix-bg {
    position: absolute;
    inset: 0;
    opacity: 0.03;
    background-image: radial-gradient(#00ff41 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none;
}

/* The Main Cyber Card container */
.error-box-wrapper {
    width: 100%;
    max-width: 680px;
    background: rgba(8, 12, 21, 0.95);
    border: 2px solid rgba(0, 255, 65, 0.25);
    border-radius: 16px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.85), 0 0 30px rgba(0, 255, 65, 0.07);
    z-index: 10;
    position: relative;
    backdrop-filter: blur(12px);
    overflow: hidden;
    animation: border_flicker 6s infinite alternate;
}

/* Terminal Header */
.cyber-alert-header {
    background: #0a0f1b;
    border-bottom: 1.5px solid rgba(0, 255, 65, 0.2);
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.pulse-dot {
    width: 9px;
    height: 9px;
    background: #ff0055;
    border-radius: 50%;
    box-shadow: 0 0 10px #ff0055;
    animation: dot_pulse 1.5s infinite;
}

.terminal-tag {
    color: #e2e8f0;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    font-family: monospace;
}

.system-port {
    margin-left: auto;
    color: #8b949e;
    font-size: 11px;
    font-weight: bold;
    background: rgba(255, 255, 255, 0.05);
    padding: 2px 8px;
    border-radius: 4px;
    border: 1px solid rgba(255,255,255,0.08);
}

/* Body Content */
.cyber-error-content {
    padding: 35px 30px;
    text-align: center;
}

/* Glitch Typography for 404 count */
.glitch-wrapper {
    display: inline-block;
    position: relative;
    margin-bottom: 15px;
}

.glitch-text {
    font-size: 110px;
    font-weight: 950;
    line-height: 1;
    color: #fff;
    margin: 0;
    font-family: 'Rajdhani', sans-serif;
    letter-spacing: -3px;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.1), 0 0 40px rgba(0,255,65,0.2);
    position: relative;
}

.glitch-text::before,
.glitch-text::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
}

.glitch-text::before {
    left: 2.5px;
    text-shadow: -2px 0 #ff0055;
    clip: rect(44px, 450px, 56px, 0);
    animation: glitch_anim 5s infinite linear alternate-reverse;
}

.glitch-text::after {
    left: -2.5px;
    text-shadow: -2px 0 #00f0ff, 0 2px #00ff41;
    clip: rect(85px, 450px, 140px, 0);
    animation: glitch_anim2 5s infinite linear alternate-reverse;
}

.alert-title {
    color: #fff;
    font-size: 21px;
    font-weight: 700;
    margin-bottom: 15px;
}

.error-msg {
    color: #94a3b8;
    font-size: 13.5px;
    line-height: 1.7;
    max-width: 530px;
    margin: 0 auto 30px auto;
}

/* Cyber Command Line Input */
.hologram-search-area {
    background: #090d16;
    border: 1px solid rgba(0, 240, 255, 0.15);
    border-radius: 12px;
    padding: 18px;
    margin-bottom: 30px;
    text-align: left;
    box-shadow: inset 0 2px 10px rgba(0,0,0,0.8);
}

.search-input-group {
    display: flex;
    background: #03060a;
    border: 1.5px solid rgba(255, 255, 255, 0.06);
    border-radius: 8px;
    padding: 4px;
    align-items: center;
    transition: 0.3s;
}

.search-icon {
    color: #00ff41;
    padding-left: 14px;
    padding-right: 8px;
    font-size: 14px;
}

.search-field {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    font-size: 13.5px;
    padding: 10px 4px;
}

.search-field:focus {
    box-shadow: none;
}

.search-input-group:focus-within {
    border-color: #00f0ff;
    box-shadow: 0 0 12px rgba(0, 240, 255, 0.2);
}

.search-btn {
    background: #00f0ff;
    color: #000;
    border: none;
    padding: 8px 18px;
    font-size: 12.5px;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
}

.search-btn:hover {
    background: #fff;
    box-shadow: 0 0 12px #fff;
}

/* Portals redirection maps block */
.portal-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.portal-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 10px;
    font-size: 12.5px;
    font-weight: 700;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.portal-btn i {
    font-size: 14px;
}

.neon-green-btn {
    background: rgba(0, 255, 65, 0.08);
    border: 1.5px solid rgba(0, 255, 65, 0.35);
    color: #00ff41;
}

.neon-green-btn:hover {
    background: #00ff41;
    color: #000;
    box-shadow: 0 0 15px rgba(0, 255, 65, 0.4);
    transform: translateY(-2px);
}

.neon-blue-btn {
    background: rgba(0, 240, 255, 0.08);
    border: 1.5px solid rgba(0, 240, 255, 0.35);
    color: #00f0ff;
}

.neon-blue-btn:hover {
    background: #00f0ff;
    color: #000;
    box-shadow: 0 0 15px rgba(0, 240, 255, 0.4);
    transform: translateY(-2px);
}

.neon-purple-btn {
    background: rgba(162, 28, 175, 0.1);
    border: 1.5px solid rgba(162, 28, 175, 0.4);
    color: #f472b6;
}

.neon-purple-btn:hover {
    background: #d946ef;
    color: #fff;
    box-shadow: 0 0 15px rgba(217, 70, 239, 0.45);
    transform: translateY(-2px);
}

/* Terminal alert footer */
.cyber-alert-footer {
    background: #0a0f1b;
    border-top: 1px solid rgba(255,255,255,0.03);
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    color: #475569;
}

/* ANIMATION FRAMES */
@keyframes dot_pulse {
    0% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(255, 0, 85, 0.6); }
    70% { transform: scale(1.1); box-shadow: 0 0 0 6px rgba(255, 0, 85, 0); }
    100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(255, 0, 85, 0); }
}

@keyframes border_flicker {
    0% { border-color: rgba(0, 255, 65, 0.2); }
    40% { border-color: rgba(0, 255, 65, 0.25); }
    45% { border-color: rgba(0, 255, 65, 0.1); }
    50% { border-color: rgba(0, 255, 65, 0.4); }
    55% { border-color: rgba(0, 255, 65, 0.15); }
    100% { border-color: rgba(0, 255, 65, 0.3); }
}

@keyframes glitch_anim {
    0% { clip: rect(24px, 9999px, 86px, 0); }
    5% { clip: rect(85px, 9999px, 5px, 0); }
    10% { clip: rect(62px, 9999px, 12px, 0); }
    15% { clip: rect(102px, 9999px, 64px, 0); }
    20% { clip: rect(6px, 9999px, 140px, 0); }
    25% { clip: rect(110px, 9999px, 32px, 0); }
    30% { clip: rect(34px, 9999px, 120px, 0); }
    35% { clip: rect(72px, 9999px, 90px, 0); }
    40% { clip: rect(98px, 9999px, 16px, 0); }
    45% { clip: rect(12px, 9999px, 110px, 0); }
    50% { clip: rect(130px, 9999px, 5px, 0); }
    100% { clip: rect(2px, 9999px, 140px, 0); }
}

@keyframes glitch_anim2 {
    0% { clip: rect(12px, 999px, 45px, 0); }
    10% { clip: rect(130px, 999px, 20px, 0); }
    20% { clip: rect(85px, 999px, 115px, 0); }
    30% { clip: rect(5px, 999px, 40px, 0); }
    40% { clip: rect(74px, 999px, 102px, 0); }
    50% { clip: rect(110px, 999px, 15px, 0); }
    100% { clip: rect(30px, 999px, 125px, 0); }
}

@media (max-width: 600px) {
    .cyber-error-content { padding: 25px 15px; }
    .glitch-text { font-size: 80px; }
    .portal-grid { grid-template-columns: 1fr; gap: 10px; }
    .search-input-group { flex-direction: column; background: transparent; border: none; }
    .search-input-group:focus-within { box-shadow: none; }
    .search-field { width: 100%; background: #03060a; border: 1.5px solid rgba(255,255,255,0.06); border-radius: 8px; margin-bottom: 8px; padding-left: 12px; }
    .search-btn { width: 100%; padding: 10px; }
    .search-icon { display: none; }
}
</style>

<?php get_footer(); ?>
