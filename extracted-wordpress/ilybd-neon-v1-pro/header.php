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
header#ilybd-main-header{
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
    color:var(--neon) !important;
    background: transparent !important;
    background-image: none !important;
    -webkit-text-fill-color: var(--neon) !important;
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
    background: linear-gradient(180deg, #070b13 0%, #0d1527 100%);
    border-top: 1px solid rgba(0, 240, 255, 0.15);
    border-bottom: 1.5px solid rgba(0, 255, 65, 0.15);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.05);
    padding: 2px 10px;
    align-items: center;
    position: relative;
    z-index: 999;
}

/* NAV ITEM */
.nav-link{
    position:relative;
    display:flex;
    flex-direction:row;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:12px 10px;
    font-size:13px;
    font-weight:600;
    color:#cbd5e0;
    text-decoration:none;
    transition:all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    font-family: 'Space Grotesk', sans-serif;
    border-radius:8px;
    margin:4px;
}

/* ICON */
.nav-link i, .nav-link svg{
    font-size:16px;
    color:#00f0ff;
    transition:all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    filter:drop-shadow(0 0 4px rgba(0, 240, 255, 0.4));
}

/* HOVER EFFECT */
.nav-link:hover{
    color:#fff;
    background:rgba(0, 240, 255, 0.06);
    box-shadow:0 0 10px rgba(0, 240, 255, 0.1);
}
.nav-link:hover i, .nav-link:hover svg{
    color:#00ff41;
    transform:translateY(-1px);
    filter:drop-shadow(0 0 8px #00ff41);
}

/* ================= FIXED BADGE ================= */
.badge{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ff004c;
    color: #fff;
    font-size: 9px;
    font-weight: 900;
    min-width: 15px;
    height: 15px;
    border-radius: 50%;
    box-shadow: 0 0 8px #ff004c;
    position: absolute;
    top: 6px;
    right: 6px;
    padding: 2px;
}

/* WALLET STYLE */
.wallet{
    padding:6px 14px;
    background:linear-gradient(135deg, rgba(0, 255, 65, 0.12) 0%, rgba(0, 240, 255, 0.12) 100%);
    border:1.5px solid #00ff41;
    border-radius:20px;
    color:#00ff41;
    font-weight:800;
    font-size:11.5px;
    font-family:'JetBrains Mono', monospace;
    display:flex;
    align-items:center;
    gap:6px;
    box-shadow:0 0 10px rgba(0, 255, 65, 0.15);
    transition:all 0.3s ease;
}

.nav-link:hover .wallet{
    border-color:#00f0ff;
    color:#00f0ff;
    box-shadow:0 0 15px rgba(0, 240, 255, 0.25);
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
    .logo-text{font-size:20px !important;}
    .custom-svg-logo-wrapper svg { max-height: 32px !important; }
    
    /* Elegant bento-row for mobile instead of hiding */
    .nav-grid {
        display: grid !important; 
        grid-template-columns: repeat(5, 1fr) !important;
        gap: clamp(2px, 1vw, 4px) !important;
        padding: 4px clamp(2px, 1vw, 6px) !important;
        background: linear-gradient(180deg, #070b13 0%, #0d1527 100%) !important;
        border-bottom: 2px solid #00ff41 !important;
        border-top: 1px solid rgba(0, 255, 65, 0.1) !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.7) !important;
    }
    
    .nav-link {
        flex-direction: row !important;
        align-items: center !important;
        justify-content: center !important;
        gap: clamp(2px, 1vw, 5px) !important;
        padding: 6px clamp(1px, 0.8vw, 4px) !important;
        margin: 0 !important;
        font-size: clamp(8.5px, 2.5vw, 11px) !important;
        font-weight: 700 !important;
        color: #cbd5e0 !important;
        border-radius: 6px !important;
        text-align: center !important;
        white-space: nowrap !important;
        letter-spacing: -0.2px !important;
    }
    
    .nav-link i, .nav-link svg {
        font-size: clamp(10px, 3vw, 13px) !important;
        margin-right: 0 !important;
        width: auto !important;
        height: auto !important;
    }
    
    .badge {
        position: absolute !important;
        top: 2px !important;
        right: 2px !important;
        font-size: 8px !important;
        min-width: 12px !important;
        height: 12px !important;
        line-height: 12px !important;
        padding: 0 !important;
    }
    
    .wallet {
        padding: 3px clamp(4px, 1.2vw, 8px) !important;
        font-size: clamp(8.5px, 2.5vw, 11px) !important;
        border-radius: 12px !important;
        border-width: 1px !important;
        text-align: center !important;
        justify-content: center !important;
        width: auto !important;
        white-space: nowrap !important;
        display: inline-flex !important;
        animation: pulse 1.8s infinite !important;
    }
    
    .header-top { padding: 4px 10px !important; }
    .user-hi { font-size: 13px !important; }
    .user-hi b { font-size: 14px !important; }
}
@keyframes pulse-shield {
    0% { transform: scale(1); filter: drop-shadow(0 0 3px #00f0ff); }
    50% { transform: scale(1.08); filter: drop-shadow(0 0 10px #8b5cf6); }
    100% { transform: scale(1); filter: drop-shadow(0 0 3px #00f0ff); }
}
.cyber-shield-header-badge {
    animation: pulse-shield 2.2s infinite ease-in-out;
}
</style>
</head>

<body <?php body_class(); ?>>

<header id="ilybd-main-header">

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
        <a href="<?php echo home_url(); ?>" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:10px;justify-content:center;">
            <?php 
            $logo_type  = get_option('ilybd_logo_type', 'text');
            $logo_text  = get_option('ilybd_logo_text', 'ILOVEYOUBD');
            $logo_url   = get_option('ilybd_logo_img_url', '');
            $logo_width = intval(get_option('ilybd_logo_width', 180));
            $logo_glow_hover = get_option('ilybd_logo_glow_hover', 'yes');
            $enable_cyber_shield = get_option('ilybd_enable_cyber_shield', 'yes');
            
            // Set up hover animation attributes
            $logo_attr = '';
            if ($logo_glow_hover === 'yes') {
                $logo_attr = 'style="transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), filter 0.3s ease; filter: drop-shadow(0 0 10px rgba(0, 240, 255, 0.45));" onmouseover="this.style.transform=\'scale(1.03)\'; this.style.filter=\'drop-shadow(0 0 18px rgba(0, 240, 255, 0.8))\';" onmouseout="this.style.transform=\'scale(1)\'; this.style.filter=\'drop-shadow(0 0 10px rgba(0, 240, 255, 0.45))\';"';
            }

            if (($logo_type === 'cosmic' || $logo_type === 'glitch')) {
                $filename = ($logo_type === 'cosmic') ? 'logo-cosmic-cyber.svg' : 'logo-minimal-glitch.svg';
                $file_path = get_template_directory() . '/assets/images/' . $filename;
                if (file_exists($file_path)) {
                    $svg_content = file_get_contents($file_path);
                    if ($enable_cyber_shield === 'yes') {
                        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/icon-cyber-shield.svg') . '" alt="Certified" class="cyber-shield-header-badge" style="width: 20px; height: 20px; margin-right: 2px; flex-shrink: 0;" referrerPolicy="no-referrer">';
                    }
                    echo '<div class="custom-svg-logo-wrapper" ' . $logo_attr . ' style="display: flex; align-items: center; justify-content: center; max-height: 42px; width: auto; overflow: hidden; max-width: 100%;">';
                    echo $svg_content;
                    echo '</div>';
                } else {
                    $logo_type = 'text'; // Fallback
                }
            }

            if ($logo_type === 'image' && !empty($logo_url)): 
                if ($enable_cyber_shield === 'yes') {
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/icon-cyber-shield.svg') . '" alt="Certified" class="cyber-shield-header-badge" style="width: 20px; height: 20px; margin-right: 4px; flex-shrink: 0;" referrerPolicy="no-referrer">';
                }
                ?>
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_text); ?>" style="max-width: 100%; width: <?php echo $logo_width; ?>px; height: auto; display: block; filter: drop-shadow(0 0 10px rgba(0, 240, 255, 0.45)); transition: transform 0.3s ease;" class="custom-header-logo-img" onmouseover="this.style.transform='scale(1.03)';" onmouseout="this.style.transform='scale(1)';" referrerPolicy="no-referrer">
            <?php elseif ($logo_type === 'both' && !empty($logo_url)): 
                if ($enable_cyber_shield === 'yes') {
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/icon-cyber-shield.svg') . '" alt="Certified" class="cyber-shield-header-badge" style="width: 20px; height: 20px; margin-right: 4px; flex-shrink: 0;" referrerPolicy="no-referrer">';
                }
                ?>
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_text); ?>" style="max-width: 100%; width: <?php echo $logo_width; ?>px; height: auto; display: block; filter: drop-shadow(0 0 10px rgba(0, 240, 255, 0.45)); transition: transform 0.3s ease; max-height: 42px;" class="custom-header-logo-img" onmouseover="this.style.transform='scale(1.03)';" onmouseout="this.style.transform='scale(1)';" referrerPolicy="no-referrer">
                <span class="custom-header-logo-text" style="font-family: 'Space Grotesk', sans-serif; font-weight: 900; letter-spacing: 1px; background: linear-gradient(to right, #00f0ff, #00ff41); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 12px rgba(0,255,65,0.25); font-size: 18px;"><?php echo esc_html($logo_text); ?></span>
            <?php elseif ($logo_type === 'text'): 
                if ($enable_cyber_shield === 'yes') {
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/icon-cyber-shield.svg') . '" alt="Certified" class="cyber-shield-header-badge" style="width: 20px; height: 20px; margin-right: 4px; flex-shrink: 0;" referrerPolicy="no-referrer">';
                }
                ?>
                <span class="custom-header-logo-text" <?php echo $logo_attr; ?> style="font-family: 'Space Grotesk', sans-serif; font-weight: 900; letter-spacing: 1.5px; background: linear-gradient(to right, #00f0ff, #00ff41); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 15px rgba(0, 240, 255, 0.35); text-transform: uppercase;; font-size: 20px;"><?php echo esc_html($logo_text); ?></span>
            <?php endif; ?>
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
                <a class="dropdown-item" href="<?php echo home_url('/how-to-earn-money'); ?>" style="color: #00ff41 !important; font-weight: bold;"><i class="fa-solid fa-coins" style="margin-right:8px; color: #00ff41; width: 16px;"></i> Earn & Rewards</a>
                <a class="dropdown-item" href="<?php echo home_url('/dashboard'); ?>"><i class="fa-solid fa-chart-line" style="margin-right:8px; color: var(--neon); width: 16px;"></i> ড্যাশবোর্ড</a>
                <a class="dropdown-item" href="<?php echo admin_url(); ?>"><i class="fa-brands fa-wordpress" style="margin-right:8px; color: var(--neon); width: 16px;"></i> এডমিন প্যানেল</a>
                <a class="dropdown-item" href="<?php echo home_url('/tools'); ?>"><i class="fa-solid fa-toolbox" style="margin-right:8px; color: var(--neon); width: 16px;"></i> টুলস</a>
                <a class="dropdown-item logout" href="<?php echo esc_url($logout_url); ?>" style="color: #ff2d2d !important;"><i class="fa-solid fa-right-from-bracket" style="margin-right:8px; color: #ff2d2d; width: 16px;"></i> লগ আউট</a>
            <?php else: ?>
                <div style="font-size: 10px; color: #8b949e; text-transform: uppercase; font-weight: 800; padding: 6px 12px; border-bottom: 1px solid rgba(255,255,255,0.06); margin-bottom: 4px; font-family: 'Space Grotesk', sans-serif;">Join Us</div>
                <a class="dropdown-item" href="<?php echo home_url('/how-to-earn-money'); ?>" style="color: #00ff41 !important; font-weight: bold;"><i class="fa-solid fa-coins" style="margin-right:8px; color: #00ff41; width: 16px;"></i> Earn & Rewards</a>
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
    $noti_count = 0;
    if (is_array($notis)) {
        foreach ($notis as $n) {
            if (!isset($n['read']) || $n['read'] == 0) {
                $noti_count++;
            }
        }
    }
    
    global $wpdb;
    $table_wallet = $wpdb->prefix . 'ilybd_wallet';
    $db_balance = null;
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_wallet'") == $table_wallet) {
        $db_balance = $wpdb->get_var($wpdb->prepare("SELECT balance FROM $table_wallet WHERE user_id = %d", $u_id));
    }
    
    if ($db_balance !== null) {
        $balance = (float) $db_balance;
    } else {
        $balance = (float) get_user_meta($u_id, 'user_balance', true);
    }
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
        <?php if ($noti_count > 0): ?>
            <div style="position: relative; display: inline-flex; align-items: center; justify-content: center; margin-right: 2px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #00f0ff; filter: drop-shadow(0 0 4px rgba(0,240,255,0.6)); animation: pulse-shield 2s infinite;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span style="position: absolute; top: -6px; right: -8px; background: #ff004c; color: #fff; font-size: 8.5px; font-weight: 900; min-width: 14px; height: 14px; border-radius: 50%; border: 1.5px solid #0d1527; box-shadow: 0 0 8px #ff004c; display: flex; align-items: center; justify-content: center; padding: 0; margin: 0; z-index: 2;"><?php echo $noti_count; ?></span>
            </div>
        <?php endif; ?>
        Alerts
    </a>

    <a class="nav-link" href="<?php echo home_url('/dashboard?action=wallet'); ?>">
        <span class="wallet">৳ <?php echo number_format($balance, 2); ?></span>
    </a>

</div>

<?php endif; ?>

<div class="rgb-bottom"></div>

</header>