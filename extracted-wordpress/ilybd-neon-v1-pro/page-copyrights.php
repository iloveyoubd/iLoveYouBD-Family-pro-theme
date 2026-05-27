<?php
/**
 * Template Name: Cyber Copyrights Pro
 * Description: Fully Professional SEO-Optimized Cyberpunk Copyrights Protection Page
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">Copyright Protection</h1>
            <p class="section-subtext">ILYBD SYSTEM / CORE INTELLECTUAL SAFETY</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                <div class="copyrights-intro">
                    <p>All assets, intellectual properties, design frameworks, stylesheets, server codes, and text structures running inside the <strong>ILYBD System (iloveyoubd.com)</strong> are protected by national copyright laws and international treaty provisions. Unauthorized deployment or duplication of our software layouts is strictly monitored.</p>
                </div>

                <div class="policy-grid">
                    <div class="policy-card">
                        <h3>🔑 1. Original Layout Ownership</h3>
                        <p>The layout files including the customized cyberpunk WordPress template assets (CSS structures, PHP filters, smart image downscalers, and navigation configurations) are the exclusive creative property of ILYBD. Clones, structural mirrors, or selling modified forks of this theme is prohibited unless explicitly authorized under a commercial license.</p>
                    </div>

                    <div class="policy-card">
                        <h3>⚡ 2. User Generated Content Rights</h3>
                        <p>When you publish questions, answers, codes, or files inside our Q&A community forums, you grant ILYBD a perpetual, non-exclusive, royalty-free license to parse, show, format, and translate that text across our networks for public research and educational purposes.</p>
                    </div>

                    <div class="policy-card">
                        <h3>🛡️ 3. Safe Harbor & Community Uploads</h3>
                        <p>Our platform enables community nodes to share information and configurations. If any user uploads content that violates your copyrighted intellectual assets, please follow our DMCA enforcement protocol to execute immediate removal processes.</p>
                    </div>

                    <div class="policy-card">
                        <h3>📜 4. DMCA File Notification Center</h3>
                        <p>To declare a copyright violation, submit an official digital notice containing: (a) Identification of the copyrighted work infringed; (b) Direct URLs of the infringing files; (c) Your full agency license details. We resolve legitimate safe-harbor files complaints within 48-72 operational hours.</p>
                    </div>
                </div>

                <div class="policy-footer-note">
                    <p>Submit copyright violation claims, take-down forms, or licensing inquiries directly to our security coordinator at <strong>support@iloveyoubd.com</strong>.</p>
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

    .copyrights-intro {
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
