<?php
/**
 * Template Name: Cyber Support Pro
 * Description: Fully Professional SEO-Optimized Cyberpunk Support Page
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">Support Us</h1>
            <p class="section-subtext">ILYBD SYSTEM / DONATION COGNITIVE UPLINK</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                <div class="support-intro">
                    <p>At <strong>ILYBD System (iloveyoubd.com)</strong>, we actively build and maintain free laboratory tools, optimization codebases, and templates for our global tech community. Managing secure, high-speed servers and performing research on new technologies requires serious computing power. If you find value in our development, consider supporting our mission nodes.</p>
                </div>

                <div class="support-grid">
                    <div class="support-card block-card">
                        <h2>☕ Buy Us A Coffee</h2>
                        <p>Support our day-to-day coding activities. A minor contribution can keep our developers awake to design more stunning features and provide high-speed optimization filters.</p>
                        <div class="contribution-action">
                            <a href="https://iloveyoubd.com/donate" target="_blank" class="cyber-btn-accent">CONTRIBUTE COFFEE ⚡</a>
                        </div>
                    </div>

                    <div class="support-card block-card">
                        <h2>🔗 Local Channels (Bangladesh)</h2>
                        <p>If you're supporting from Bangladesh, you can securely proceed with our automated mobile banking links using bKash, Nagad, or Rocket networks.</p>
                        <div class="contribution-action">
                            <a href="https://iloveyoubd.com/b_payment" target="_blank" class="cyber-btn-accent">MOBILE PAYMENTS 💳</a>
                        </div>
                    </div>

                    <div class="support-card block-card wide-card">
                        <h2>🪙 Crypto Node Address (Global)</h2>
                        <p>For decentralized support, you can send stablecoins directly to our secure ledger nodes:</p>
                        <div class="crypto-addr-box">
                            <div class="crypto-row">
                                <span class="crypto-type">USDT (TRC-20):</span>
                                <code class="crypto-code">TAmjDYyR3dD8123G7XkPsnzQpYg4... (Click to consult on dashboard)</code>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-footer-note">
                    <p>Submitting a donation of any size grants you a custom <strong>Donor Node Badge</strong> inside our user community dashboard and unlocks high-priority support tags on our forums. Thank you for empowering local open-source technology development.</p>
                </div>
            </div>
        </div>

    </div>
</div>

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

    .support-intro {
        margin-bottom: 35px;
        border-left: 3px solid <?php echo $neon; ?>;
        padding-left: 20px;
        font-size: 16px;
        line-height: 1.8;
        color: #a0aec0;
    }

    .support-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .support-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px;
        padding: 30px;
        transition: all 0.3s ease;
    }

    .support-card:hover {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 20px <?php echo $neon; ?>33;
        transform: translateY(-2px);
    }

    .wide-card {
        grid-column: span 2;
    }

    .support-card h2 {
        color: #fff;
        font-size: 20px;
        margin-top: 0;
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        padding-bottom: 8px;
    }

    .support-card p {
        line-height: 1.7;
        color: #a0aec0;
        font-size: 14.5px;
        margin-bottom: 20px;
    }

    .contribution-action {
        text-align: right;
    }

    .cyber-btn-accent {
        display: inline-block;
        background: <?php echo $neon; ?>;
        color: #000;
        text-decoration: none;
        padding: 12px 24px;
        font-weight: 800;
        font-size: 13px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 15px <?php echo $neon; ?>44;
        transition: all 0.3s;
    }

    .cyber-btn-accent:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px <?php echo $neon; ?>88;
    }

    .crypto-addr-box {
        background: rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.04);
        border-radius: 8px;
        padding: 15px;
    }

    .crypto-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .crypto-type {
        font-weight: bold;
        color: <?php echo $neon; ?>;
        font-size: 14px;
    }

    .crypto-code {
        font-family: 'Courier New', Courier, monospace;
        color: #e2e8f0;
        background: #1a202c;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 13px;
    }

    .policy-footer-note {
        background: rgba(0, 255, 65, 0.04);
        border: 1px dashed <?php echo $neon; ?>44;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        color: #a0aec0;
        font-size: 15px;
    }

    @keyframes rgb_flow {
        to { background-position: 200% center; }
    }

    @media (max-width: 768px) {
        .support-grid { grid-template-columns: 1fr; }
        .wide-card { grid-column: span 1; }
        .contribution-action { text-align: left; }
    }

    @media (max-width: 480px) {
        .inner-page-content { padding: 20px; }
        .rgb-text-lighting { font-size: 2rem; }
    }
</style>

<?php
get_footer();
?>
