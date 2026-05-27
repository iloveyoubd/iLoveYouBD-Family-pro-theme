<?php
/**
 * Template Name: Cyber User Rights Pro
 * Description: Fully Professional SEO-Optimized Cyberpunk User Rights & GDPR Page
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">User Rights</h1>
            <p class="section-subtext">ILYBD SYSTEM / DIGITAL CITIZEN FREEDOMS</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                <div class="rights-intro">
                    <p>At <strong>ILYBD System (iloveyoubd.com)</strong>, we believe you should maintain complete authority over your personal metadata and digital traces. This page acts as our User Rights Declaration under general GDPR (General Data Protection Regulation) and digital citizen sovereignty protocols.</p>
                </div>

                <div class="policy-grid">
                    <div class="policy-card">
                        <h3>🔑 1. Right to Access & Transparency</h3>
                        <p>You have the absolute right to know what personal records are held inside our SQL databases. This includes registration emails, IP routing traces, forum post counts, and liked comments. You can view this metadata mapped directly inside your secure user dashboard at any time.</p>
                    </div>

                    <div class="policy-card">
                        <h3>⚡ 2. Right of Rectification & Customization</h3>
                        <p>If any info published on your profile is incorrect, outdated, or misaligned, you possess complete access rights to correct, rewrite, or reset it. This includes altering your display names, community passwords, bio details, and system profile avatar graphics safely from your console.</p>
                    </div>

                    <div class="policy-card">
                        <h3>🛡️ 3. Right to Complete Erasure (De-registration)</h3>
                        <p>You have the absolute right to delete your active profile records from our databases permanently. Using the self-erasure buttons inside your profile panel, you can erase your email coordinates, custom avatars, password cookies, and active notification settings in real-time, leaving zero trace.</p>
                    </div>

                    <div class="policy-card">
                        <h3>📜 4. Right to Data Portability & Isolation</h3>
                        <p>Upon official request, we can extract and format your community dashboard details into standard CSV files and transmit them to your verified address. We guarantee never selling, marketing, or leaking your compiled diagnostic reports to third-party advert groups.</p>
                    </div>
                </div>

                <div class="policy-footer-note">
                    <p>To request a physical copy of all logged records, execute manual database erasures, or invoke specific CCPA/GDPR flags, contact our security officer at <strong>support@iloveyoubd.com</strong>.</p>
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

    .rights-intro {
        margin-bottom: 35px;
        border-left: 3px solid <?php echo $neon; ?>;
        padding-left: 20px;
        font-size: 16px;
        line-height: 1.8;
        color: #a0aec0;
    }

    .policy-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .policy-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 12px;
        padding: 25px;
        transition: all 0.3s ease;
    }

    .policy-card:hover {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 20px <?php echo $neon; ?>33;
        transform: translateY(-2px);
    }

    .policy-card h3 {
        color: #fff;
        font-size: 18px;
        margin-top: 0;
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        padding-bottom: 8px;
    }

    .policy-card p {
        line-height: 1.7;
        color: #a0aec0;
        font-size: 14.5px;
        margin: 0;
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
        .policy-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 480px) {
        .inner-page-content { padding: 20px; }
        .rgb-text-lighting { font-size: 2rem; }
    }
</style>

<?php
get_footer();
?>
