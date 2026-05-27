<?php
/**
 * Template Name: Cyber About Pro
 * Description: Fully Professional SEO-Optimized Cyberpunk About Page
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">About Us</h1>
            <p class="section-subtext">ILYBD SYSTEM / ENGINEERING SCIENCE & TECHNOLOGIES</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                <div class="about-grid">
                    <div class="about-card hero-card">
                        <h2>🤖 ILYBD System Manifesto</h2>
                        <p>We are a high-fidelity laboratory of technology, software science, and community development. Born in the heart of Bangladesh (Singair, Manikganj), we design high-speed digital architectures, educational setups, and optimization frameworks designed to bring lightning-fast experiences to the open internet.</p>
                        <p>Our commitment is centered around raw performance, user empowerment, and accessibility. We believe that technology should be responsive, secure, and visually breathtaking.</p>
                    </div>

                    <div class="about-card stats-card">
                        <h2>📊 Laboratory Telemetry</h2>
                        <div class="telemetry-grid">
                            <div class="telemetry-item">
                                <span class="tel-val">19K+</span>
                                <span class="tel-label">YouTube Matrix</span>
                            </div>
                            <div class="telemetry-item">
                                <span class="tel-val">11K+</span>
                                <span class="tel-label">Facebook Nodes</span>
                            </div>
                            <div class="telemetry-item">
                                <span class="tel-val">99.9%</span>
                                <span class="tel-label">Speed Target</span>
                            </div>
                            <div class="telemetry-item">
                                <span class="tel-val">24/7</span>
                                <span class="tel-label">Active Uplink</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="about-sections">
                    <div class="vision-mission">
                        <div class="about-card half-card">
                            <h3>👁️ Our Vision</h3>
                            <p>To establish a decentralized, high-speed educational database of templates, resources, and live interfaces designed for engineers, students, and tech enthusiasts. We push the absolute limit of web speed, Core Web Vitals, and user-centric visual science.</p>
                        </div>
                        <div class="about-card half-card">
                            <h3>🚀 Our Mission</h3>
                            <p>To craft beautifully responsive solutions, debug slow-running elements on existing infrastructures, and offer free-tier tools to empower local developers to showcase their talent globally.</p>
                        </div>
                    </div>
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

    /* Grid Layouts */
    .about-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }

    .about-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 14px;
        padding: 30px;
        transition: all 0.3s ease;
    }

    .about-card:hover {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 20px <?php echo $neon; ?>33;
        transform: translateY(-2px);
    }

    .about-card h2 {
        color: #fff;
        font-size: 22px;
        margin-top: 0;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        padding-bottom: 10px;
    }

    .about-card h3 {
        color: <?php echo $neon; ?>;
        font-size: 18px;
        margin-top: 0;
        margin-bottom: 15px;
    }

    .about-card p {
        line-height: 1.8;
        color: #a0aec0;
        font-size: 15px;
        margin-bottom: 15px;
    }

    .telemetry-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .telemetry-item {
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255,255,255,0.03);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }

    .tel-val {
        display: block;
        font-size: 28px;
        font-weight: 900;
        color: <?php echo $neon; ?>;
        text-shadow: 0 0 10px <?php echo $neon; ?>aa;
    }

    .tel-label {
        font-size: 11px;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 5px;
    }

    .vision-mission {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    @keyframes rgb_flow {
        to { background-position: 200% center; }
    }

    /* Responsive scaling */
    @media (max-width: 900px) {
        .about-grid { grid-template-columns: 1fr; }
        .vision-mission { grid-template-columns: 1fr; }
    }

    @media (max-width: 480px) {
        .inner-page-content { padding: 20px; }
        .rgb-text-lighting { font-size: 2rem; }
        .about-card { padding: 20px; }
    }
</style>

<?php
get_footer();
?>
