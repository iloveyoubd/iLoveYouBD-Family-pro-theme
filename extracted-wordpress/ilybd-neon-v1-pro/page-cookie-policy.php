<?php
/**
 * Template Name: Cyber Cookie Policy Pro
 * Description: Interactive Compliant Cookie Consent & Detailed Usage Guidelines Page
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1100px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">Cookie Policy</h1>
            <p class="section-subtext">কুকি ব্যবহার বিধিমালা / GDPR & COOKIE REWRITE SHIELD</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                
                <section class="policy-block">
                    <h2>🍪 Automated Cookie Policy, Analytics, and Tracker Settings</h2>
                    <p>At ILOVEYOUBD.COM, we use standard cookies, browser storage sessions, and telemetry tokens to track user experience, measure Core Web Vitals, remember localized language configurations, and deliver relevant advertisements via Google AdSense. In compliance with European Union GDPR, California CCPA, and global internet privacy treaties, we provide full granular control over which background protocols are permitted to run in your session.</p>
                </section>

                <div class="policy-divider"></div>

                <div class="policy-grid" style="grid-template-columns: 1.2fr 1.8fr;">
                    
                    <div class="cookie-simulator-control">
                        <div class="policy-card" style="border-color: var(--cyber-neon); background: rgba(0,255,204,0.01);">
                            <h3 style="color: var(--cyber-neon); border-color: rgba(0,255,204,0.15);"><i class="fa-solid fa-gears"></i> Cookie Preference Centre</h3>
                            <p style="font-size: 13px; line-height: 1.6; color: #8b949e; margin-bottom: 20px;">Toggle and save your preferred transmission parameters for this profile session:</p>
                            
                            <div class="cookie-pref-item" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 15px; margin-bottom: 15px;">
                                <div>
                                    <span style="display: block; font-size: 13.5px; font-weight: bold; color: #fff;">1. Necessary System Keys</span>
                                    <span style="font-size: 11px; color: #8b949e;">Handles logins, dark mode and user state.</span>
                                </div>
                                <span style="font-family: monospace; font-size: 11px; background: rgba(0,255,65,0.1); border: 1px solid #00ff41; color: #00ff41; padding: 4px 10px; border-radius: 4px; font-weight: bold;">LOCKED</span>
                            </div>

                            <div class="cookie-pref-item" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.04); padding-bottom: 15px; margin-bottom: 15px;">
                                <div>
                                    <span style="display: block; font-size: 13.5px; font-weight: bold; color: #fff;">2. AdSense Marketing Engine</span>
                                    <span style="font-size: 11px; color: #8b949e;">Personalized non-intrusive target ads.</span>
                                </div>
                                <input type="checkbox" id="marketing_cookie_toggle" checked style="width: 20px; height: 20px; cursor: pointer;">
                            </div>

                            <div class="cookie-pref-item" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 15px; margin-bottom: 15px;">
                                <div>
                                    <span style="display: block; font-size: 13.5px; font-weight: bold; color: #fff;">3. Performance Analytics</span>
                                    <span style="font-size: 11px; color: #8b949e;">Logs page loading speed & web vitals.</span>
                                </div>
                                <input type="checkbox" id="analytics_cookie_toggle" checked style="width: 20px; height: 20px; cursor: pointer;">
                            </div>

                            <button onclick="savePref()" style="width: 100%; border: none; padding: 12px; background: var(--cyber-neon); border-radius: 6px; font-weight: bold; color: #000; text-transform: uppercase; cursor: pointer; transition: 0.3s;" onmouseover="this.style.boxShadow='0 0 15px var(--cyber-neon)'" onmouseout="this.style.boxShadow='none'">Commit Selection</button>
                            
                            <div id="pref_feedback" style="display: none; margin-top: 15px; text-align: center; text-transform: uppercase; font-family: monospace; font-size: 11px; color: #00ff41;"></div>
                        </div>
                    </div>

                    <div class="cookie-descriptions">
                        <div class="policy-card">
                            <h3>🔍 Categorical Usage of Browser Files</h3>
                            
                            <h4 style="color: #fff; font-size: 14px; margin: 15px 0 5px 0;"><i class="fa-solid fa-shield"></i> Essential Core Storage</h4>
                            <p style="font-size: 13px; line-height: 1.6; color: #a0aec0; margin-bottom: 15px;">WordPress uses cookies such as <code>wordpress_logged_in_</code> to retain secure administration login state. These credentials do not contains tracking details and fail automatically upon closing browser windows.</p>

                            <h4 style="color: #fff; font-size: 14px; margin: 15px 0 5px 0;"><i class="fa-solid fa-rectangle-ad"></i> Google AdSense Cookies</h4>
                            <p style="font-size: 13px; line-height: 1.6; color: #a0aec0; margin-bottom: 15px;">We monetize our high-fidelity technical articles through Google AdSense. To keep this layout running cleanly, non-deceptive, third-party cookies (DoubleClick cookies or programmatic identifiers) register reader navigation patterns to serve target interests. They prevent ad-bombardments and ensure standard compliance guidelines are met.</p>

                            <h4 style="color: #fff; font-size: 14px; margin: 15px 0 5px 0;"><i class="fa-solid fa-chart-line"></i> Performance & Core Web Vitals</h4>
                            <p style="font-size: 13px; line-height: 1.6; color: #a0aec0; margin-bottom: 15px;">Analytics engines register anonymized variables (user countries, screen layout bounds, routing paths) using tracking mechanisms. These records are 100% anonymous, stored securely in database logs, and referenced only during infrastructure load optimizations.</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<script>
    function savePref(){
        const marketing = document.getElementById('marketing_cookie_toggle').checked;
        const analytics = document.getElementById('analytics_cookie_toggle').checked;
        localStorage.setItem('ibd_cookie_marketing', marketing);
        localStorage.setItem('ibd_cookie_analytics', analytics);
        
        const feedback = document.getElementById('pref_feedback');
        feedback.innerText = "✓ Config saved: Handshake update completed!";
        feedback.style.display = "block";
        setTimeout(() => {
            feedback.style.display = "none";
        }, 3000);
    }
    
    // Load state
    document.addEventListener("DOMContentLoaded", function() {
        if (localStorage.getItem('ibd_cookie_marketing') !== null) {
            document.getElementById('marketing_cookie_toggle').checked = localStorage.getItem('ibd_cookie_marketing') === 'true';
        }
        if (localStorage.getItem('ibd_cookie_analytics') !== null) {
            document.getElementById('analytics_cookie_toggle').checked = localStorage.getItem('ibd_cookie_analytics') === 'true';
        }
    });
</script>

<style>
    .cyber-page-wrapper {
        background: #070a0f;
        min-height: 100vh;
        color: #e1e7ef;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cyber-section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .rgb-text-lighting {
        font-size: 2.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin: 0 0 10px 0;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rgb_flow 4s linear infinite;
    }

    .section-subtext {
        color: <?php echo $neon; ?>;
        font-size: 11px;
        letter-spacing: 5px;
        margin-bottom: 20px;
    }

    .sticky-rgb-line {
        height: 2px;
        width: 100%;
        background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);
        background-size: 200% auto;
        animation: rgb_flow 4s linear infinite;
        box-shadow: 0 0 15px <?php echo $neon; ?>dd;
    }

    /* Outer Matrix Container */
    .slim-rgb-container {
        position: relative;
        padding: 1px;
        background: linear-gradient(var(--angle), #ff0000, #00ff00, #0000ff, #ff0000);
        animation: rotate-border 6s linear infinite;
        border-radius: 20px;
        overflow: hidden;
    }

    @property --angle {
        syntax: '<angle>';
        initial-value: 0deg;
        inherits: false;
    }

    @keyframes rotate-border {
        to { --angle: 360deg; }
    }

    .inner-page-content {
        background: #0a0e14;
        border-radius: 19px;
        padding: 40px;
    }

    .policy-block h2 {
        color: #fff;
        font-size: 22px;
        margin-top: 0;
        margin-bottom: 15px;
    }

    .policy-block p {
        line-height: 1.8;
        color: #a0aec0;
        font-size: 15px;
    }

    .policy-divider {
        height: 1px;
        background: rgba(255,255,255,0.08);
        margin: 30px 0;
    }

    .policy-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .policy-card {
        background: rgba(255,255,255,0.01);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 25px;
        transition: 0.3s;
    }

    .policy-card:hover {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 15px <?php echo $neon; ?>1d;
    }

    .policy-card h3 {
        color: <?php echo $neon; ?>;
        font-size: 16px;
        margin-top: 0;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 8px;
    }

    .policy-card p {
        font-size: 13.5px;
        line-height: 1.7;
        color: #a0aec0;
        margin-bottom: 12px;
    }

    @media (max-width: 991px) {
        .policy-grid {
            grid-template-columns: 1fr;
        }
        .inner-page-content {
            padding: 20px;
        }
    }

    @keyframes rgb_flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<?php get_footer(); ?>
