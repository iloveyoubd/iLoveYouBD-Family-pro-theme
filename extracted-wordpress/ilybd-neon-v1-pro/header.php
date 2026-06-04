<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />
<link rel="dns-prefetch" href="https://fonts.googleapis.com" />
<link rel="dns-prefetch" href="https://fonts.gstatic.com" />
<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com" />
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;800;900&family=Space+Grotesk:wght@600;800;900&family=Rajdhani:wght@600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>

<style>
:root{
    --neon:#00ff41;
    --dark:#121822; /* Brighter dark */
    --border:rgba(255,255,255,0.12); /* Brighter border */
    --red:#ff4d4d; /* Brighter red */
}

/* PAGE OFFSET & BRIGHTNESS */
body{
    background:#0b0f15;
    color: #e2e8f0; /* Brighter default text */
}

/* HEADER FIXED */
header{
    position:fixed !important;
    top:0 !important;
    left:0 !important;
    width:100% !important;
    z-index:10000000 !important;
    background:var(--dark) !important;
}

/* ================= RGB LINES ================= */
.rgb-line,
.rgb-bottom{
    height:1px;
    width:100%;
    background:linear-gradient(90deg,transparent,#ff004c,#00ff41,#00e5ff,#ff004c,transparent);
    background-size:200%;
    animation:rgbMove 3s linear infinite;
    opacity:.9;
}

@keyframes rgbMove{
    0%{background-position:0%;}
    100%{background-position:200%;}
}

/* HEADER TOP */
.header-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:5px 14px;
    background:#11161d;
}

/* USER TEXT */
.user-hi{
    font-size:16px;
    color:#c9d1d9;
}
.user-hi b{
    font-size:18px;
    color:var(--neon);
    text-shadow:0 0 10px rgba(0,255,65,0.5);
}

/* LOGO BIG + CYBER STYLE UPGRADED */
.logo-text{
    font-size: 28px !important;
    font-weight: 900 !important;
    font-style: italic !important;
    text-align: center;
    flex: 1;
    letter-spacing: 2.5px !important;
    text-transform: uppercase !important;
    font-family: 'Space Grotesk', 'Orbitron', 'Rajdhani', sans-serif !important;
    background: linear-gradient(90deg, #00ff41, #00e5ff, #ff004c, #00ff41) !important;
    background-size: 300% !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    animation: logoAnim 4s linear infinite !important;
    filter: drop-shadow(0 0 8px rgba(0, 255, 65, 0.45)) !important;
    transition: 0.3s ease;
}
.logo-text:hover {
    filter: drop-shadow(0 0 15px rgba(0, 229, 255, 0.85)) !important;
}

@keyframes logoAnim{
    0%{background-position:0%;}
    100%{background-position:300%;}
}

/* ================= CYBER DROPDOWN SYSTEM ================= */
.tool-icon-wrapper {
    position: relative;
    display: inline-block;
}

/* ⚡ HIGH-TECH COGNITIVE PROFESSIONAL HEADER TTS SPEAKER BUTTON ⚡ */
.header-tts-btn {
    background: rgba(0, 240, 255, 0.08) !important;
    border: 1.2px solid #00f0ff !important;
    color: #00f0ff !important;
    width: 29px !important;
    height: 29px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
    position: relative !important;
    font-size: 11px !important;
    padding: 0 !important;
    margin: 0 !important;
    text-shadow: 0 0 8px rgba(0, 240, 255, 0.5) !important;
    box-shadow: 0 0 8px rgba(0, 240, 255, 0.15) !important;
    z-index: 999999 !important;
}
.header-tts-btn:hover {
    background: #00f0ff !important;
    color: #000 !important;
    box-shadow: 0 0 15px #00f0ff, 0 0 8px #00ff41 !important;
    transform: scale(1.08) !important;
}
.header-tts-btn.playing {
    background: #ff3b30 !important;
    border-color: #ff3b30 !important;
    color: #fff !important;
    box-shadow: 0 0 15px rgba(255, 59, 48, 0.6) !important;
    animation: headerTtsPulse 1.2s infinite ease-in-out !important;
}
@keyframes headerTtsPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.08); box-shadow: 0 0 15px rgba(255, 59, 48, 0.7); }
    100% { transform: scale(1); }
}

.tool-icon-btn {
    background: none;
    border: none;
    padding: 0;
    margin: 0;
    cursor: pointer;
    color: var(--neon);
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
    text-shadow: 0 0 10px rgba(0,255,65,0.4);
}
.tool-icon-btn:hover {
    color: #00e5ff;
    text-shadow: 0 0 15px rgba(0,229,255,0.8);
    transform: rotate(45deg);
}
.cyber-dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 12px;
    background: #090d13 !important;
    border: 1.5px solid var(--neon) !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.95), 0 0 15px rgba(0,255,65,0.3) !important;
    border-radius: 12px !important;
    z-index: 9999999 !important;
    width: 200px !important;
    padding: 8px !important;
    overflow: hidden;
    animation: fadeInDropdown 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.cyber-dropdown-menu .dropdown-item {
    display: flex !important;
    align-items: center !important;
    padding: 10px 14px !important;
    font-size: 13.5px !important;
    font-weight: 700 !important;
    color: #c9d1d9 !important;
    text-decoration: none !important;
    border-radius: 8px !important;
    transition: all 0.2s ease !important;
    border-bottom: none !important;
}
.cyber-dropdown-menu .dropdown-item:hover {
    background: rgba(0, 255, 65, 0.12) !important;
    color: #ffffff !important;
    text-shadow: 0 0 5px rgba(0, 255, 65, 0.6) !important;
    padding-left: 18px !important;
}
.cyber-dropdown-menu .dropdown-item.logout:hover {
    background: rgba(255, 45, 45, 0.12) !important;
    color: #ffffff !important;
    text-shadow: 0 0 5px rgba(255, 45, 45, 0.6) !important;
}
@keyframes fadeInDropdown {
    from { opacity: 0; transform: translateY(-10px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

/* TOOL ICON */
.tool-icon a{
    color:var(--neon);
    font-size:22px;
    text-decoration:none;
}

/* NAV GRID */
.nav-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    background:#0c1118;
}

/* NAV ITEM */
.nav-link{
    position:relative;
    display:flex;
    flex-direction:row;
    align-items:center;
    justify-content:center;
    gap:6px;
    padding:10px 5px;
    font-size:12px;
    color:#c9d1d9;
    text-decoration:none;
    transition:.2s;
}

/* ICON */
.nav-link i{
    font-size:16px;
    color:var(--neon);
    text-shadow:0 0 6px rgba(0,255,65,0.4);
}

/* HOVER EFFECT */
.nav-link:hover{
    color:#fff;
}
.nav-link:hover i{
    color:var(--red);
    text-shadow:0 0 10px var(--red);
}

/* ================= FIXED BADGE ================= */
.badge{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--red);
    color: #fff;
    font-size: 10px;
    font-weight: bold;
    min-width: 16px;
    height: 16px;
    border-radius: 50%;
    box-shadow: 0 0 10px var(--red);
    margin-left: 5px;
    padding: 2px;
    vertical-align: middle;
}

/* WALLET STYLE */
.wallet{
    padding:6px 14px;
    border:1px solid var(--neon);
    border-radius:22px;
    color:var(--neon);
    font-weight:bold;
    font-size:12px;
    animation:pulse 2s infinite;
}

@keyframes pulse{
    0%{box-shadow:0 0 5px var(--neon);}
    50%{box-shadow:0 0 18px var(--neon);}
    100%{box-shadow:0 0 5px var(--neon);}
}

/* ================= RGB SEPARATOR (MAIN FIX) ================= */
.rgb-separator{
    height:2px;
    width:100%;
    background:linear-gradient(90deg,transparent,#ff004c,#00ff41,#00e5ff,#ff004c,transparent);
    background-size:200%;
    animation:rgbMove 2.5s linear infinite;
    box-shadow:0 0 10px rgba(0,255,65,0.3);
}

/* LOGIN */
.login-box{
    text-align:center;
    padding:10px;
}
.login-box a{
    color:var(--neon);
    margin:0 6px;
    font-size:13px;
    text-decoration:none;
}

/* MOBILE */
@media(max-width:768px){
    .logo-text{font-size:22px;}
}
</style>
</head>

<body <?php body_class(); ?>>

<header>

<div class="rgb-line"></div>

<div class="header-top">

    <div class="user-hi">
        <?php if(is_user_logged_in()):
            $u = wp_get_current_user();
            ?>
            Hi, <b><?php echo esc_html($u->display_name); ?></b>
        <?php else: ?>
            Welcome
        <?php endif; ?>
    </div>

    <div class="logo-text">
        <a href="<?php echo home_url(); ?>" style="text-decoration:none;color:inherit;">
            ILOVEYOUBD
        </a>
    </div>

    <div style="display: flex; align-items: center; gap: 14px;">
        <!-- ⚡ GLOBAL COGNITIVE HIGH-TECH HEADER SPEECH SYSTEM (2040 Style) ⚡ -->
        <button id="header-global-tts-btn" class="header-tts-btn" onclick="toggleHeaderTts(event)" title="পুরো পেজ শুনুন (Listen Page)" aria-label="Listen Page Content">
            <i id="header-global-tts-icon" class="fa-solid fa-volume-high"></i>
            <span id="header-tts-active-dot" style="display: none; position: absolute; top: -1px; right: -1px; width: 6px; height: 6px; background: #00ff41; border-radius: 50%; box-shadow: 0 0 6px #00ff41;"></span>
        </button>

        <div class="tool-icon-wrapper" style="position: relative; display: inline-block;">
            <button id="header-tools-toggle" class="tool-icon-btn" onclick="toggleHeaderTools(event)" title="Tools & Account" aria-label="Tools and Account" aria-expanded="false" aria-haspopup="true">
                <i class="dashicons dashicons-admin-tools"></i>
            </button>
        <div id="header-tools-dropdown" class="cyber-dropdown-menu">
            <?php if(is_user_logged_in()): 
                $logout_url = wp_logout_url(home_url()); ?>
                <div style="font-size: 10px; color: #8b949e; text-transform: uppercase; font-weight: 800; padding: 6px 12px; border-bottom: 1px solid rgba(255,255,255,0.06); margin-bottom: 4px; font-family: 'Space Grotesk', sans-serif;">Account</div>
                <a class="dropdown-item" href="<?php echo home_url('/dashboard'); ?>"><i class="fa-solid fa-chart-line" style="margin-right:8px; color: var(--neon); width: 16px;"></i> ড্যাশবোর্ড</a>
                <a class="dropdown-item" href="<?php echo admin_url(); ?>"><i class="fa-brands fa-wordpress" style="margin-right:8px; color: var(--neon); width: 16px;"></i> এডমিন প্যানেল</a>
                <a class="dropdown-item" href="<?php echo home_url('/tools'); ?>"><i class="fa-solid fa-toolbox" style="margin-right:8px; color: var(--neon); width: 16px;"></i> টুলস</a>
                <a class="dropdown-item logout" href="<?php echo esc_url($logout_url); ?>" style="color: #ff2d2d !important;"><i class="fa-solid fa-right-from-bracket" style="margin-right:8px; color: #ff2d2d; width: 16px;"></i> লগ আউট</a>
            <?php else: ?>
                <div style="font-size: 10px; color: #8b949e; text-transform: uppercase; font-weight: 800; padding: 6px 12px; border-bottom: 1px solid rgba(255,255,255,0.06); margin-bottom: 4px; font-family: 'Space Grotesk', sans-serif;">Join Us</div>
                <a class="dropdown-item" href="<?php echo wp_login_url(); ?>"><i class="fa-solid fa-right-to-bracket" style="margin-right:8px; color: var(--neon); width: 16px;"></i> লগইন করুন</a>
                <a class="dropdown-item" href="<?php echo wp_registration_url(); ?>"><i class="fa-solid fa-user-plus" style="margin-right:8px; color: var(--neon); width: 16px;"></i> রেজিস্ট্রেশন</a>
                <a class="dropdown-item" href="<?php echo home_url('/tools'); ?>"><i class="fa-solid fa-toolbox" style="margin-right:8px; color: var(--neon); width: 16px;"></i> টুলস</a>
            <?php endif; ?>
        </div>
    </div>
</div>

</div>

<script>
function toggleHeaderTools(event) {
    event.preventDefault();
    event.stopPropagation();
    var dd = document.getElementById('header-tools-dropdown');
    var btn = document.getElementById('header-tools-toggle');
    if (dd.style.display === 'none' || dd.style.display === '') {
        dd.style.display = 'block';
        if (btn) { btn.setAttribute('aria-expanded', 'true'); }
    } else {
        dd.style.display = 'none';
        if (btn) { btn.setAttribute('aria-expanded', 'false'); }
    }
}
document.addEventListener('click', function() {
    var dd = document.getElementById('header-tools-dropdown');
    var btn = document.getElementById('header-tools-toggle');
    if (dd) { 
        dd.style.display = 'none'; 
        if (btn) { btn.setAttribute('aria-expanded', 'false'); }
    }
});
</script>

<?php if(is_user_logged_in()): 
    $u_id = get_current_user_id();
    $notis = get_user_meta($u_id, 'notifications', true);
    $noti_count = is_array($notis) ? count($notis) : 0;
    $balance = (float) get_user_meta($u_id, 'user_balance', true);
?>

<div class="rgb-line"></div>
<div class="nav-grid">

    <a class="nav-link" href="<?php echo home_url(); ?>">
        <i class="fa-solid fa-house"></i> Home
    </a>

    <a class="nav-link" href="<?php echo home_url('/dashboard?action=add-post'); ?>">
        <i class="fa-solid fa-pen-to-square"></i> Post
    </a>

    <a class="nav-link" href="<?php echo home_url('/dashboard'); ?>">
        <i class="fa-solid fa-chart-line"></i> Dashboard
    </a>

    <a class="nav-link" href="<?php echo home_url('/dashboard?action=notifications'); ?>">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--neon); vertical-align: middle; filter: drop-shadow(0 0 4px rgba(0,255,65,0.4)); margin-right: 2px;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        Alerts
        <?php if ($noti_count > 0): ?>
            <span class="badge"><?php echo $noti_count; ?></span>
        <?php endif; ?>
    </a>

    <a class="nav-link" href="<?php echo home_url('/dashboard?action=wallet'); ?>">
        <span class="wallet">৳ <?php echo number_format($balance, 2); ?></span>
    </a>

</div>

<?php endif; ?>

<div class="rgb-bottom"></div>

</header>