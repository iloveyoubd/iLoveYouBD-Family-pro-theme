<?php
/**
 * Template Name: Cyber FAQ Pro
 * Description: Fully Professional SEO-Optimized Cyberpunk FAQ Page with CSS Accordions
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">FAQ Center</h1>
            <p class="section-subtext">ILYBD SYSTEM / KNOWLEDGE DATABANK</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                <div class="faq-intro">
                    <p>Have questions about how to interact with the ILYBD System, optimizing your account nodes, or downloading files from our server channels? We have compiled the answers to the most frequent inquiries below.</p>
                </div>

                <div class="faq-accordion-group">
                    
                    <details class="faq-item" open>
                        <summary class="faq-question">🌟 What is the primary purpose of ILYBD System?</summary>
                        <div class="faq-answer">
                            <p>ILYBD (iloveyoubd.com) is built primarily as a high-fidelity information system and educational network. We design open-source automation scripts, high-speed laboratory tools, and customized WordPress template optimization kits designed to provide top performance rankings for developers globally.</p>
                        </div>
                    </details>

                    <details class="faq-item">
                        <summary class="faq-question">🛡️ Are the configuration files and apps hosted on ILYBD system safe?</summary>
                        <div class="faq-answer">
                            <p>Absolutely. Every application, tool, and setup configuration code published on our servers undergoes strict inspection inside our laboratory environments to detect backdoor code, adware, or malware. We prioritize secure user interactions and ensure no files run harmful background scripts before public deployment.</p>
                        </div>
                    </details>

                    <details class="faq-item">
                        <summary class="faq-question">⚡ How are the user avatars optimized in the theme?</summary>
                        <div class="faq-answer">
                            <p>We use our customized <code>ilybd_get_optimized_avatar_url</code> filters. When users upload profile images on our user dashboard, our engine automatically downsizes and encodes them into .webp formats (like 120px/150px) to decrease load size, improving overall FCP (First Contentful Paint) scoring for search optimization.</p>
                        </div>
                    </details>

                    <details class="faq-item">
                        <summary class="faq-question">💬 How can I contribute or report problems in the forum?</summary>
                        <div class="faq-answer">
                            <p>First, register a free user node. After logging into your community dashboard, you can open connection threads inside the live Community Q&A forum page or click our floating "AI Chat" bridge inside the slim navbar to transmit bug reports directly to our engineers.</p>
                        </div>
                    </details>

                    <details class="faq-item">
                        <summary class="faq-question">🌐 Why does PageSpeed Insights load fast on our network?</summary>
                        <div class="faq-answer">
                            <p>Our structures enforce high-speed CSS optimization filters. We utilize techniques such as asynchronous loading for large external files, critical assets preloading (like featured category thumbnails), and light image sizes. This lowers initial blocking, granting an outstanding mobile/desktop ranking of 90+ on Core Web Vitals checks.</p>
                        </div>
                    </details>

                </div>

                <div class="policy-footer-note" style="margin-top: 40px;">
                    <p>Unable to find specifications for your issue? Reach out to our system operators via <strong>support@iloveyoubd.com</strong> or launch a chat session on the main console.</p>
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

    .faq-intro {
        margin-bottom: 35px;
        border-left: 3px solid <?php echo $neon; ?>;
        padding-left: 20px;
        font-size: 16px;
        line-height: 1.8;
        color: #a0aec0;
    }

    .faq-accordion-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .faq-item {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        border-color: <?php echo $neon; ?>55;
    }

    .faq-item[open] {
        border-color: <?php echo $neon; ?>;
        box-shadow: 0 0 15px <?php echo $neon; ?>22;
    }

    .faq-question {
        padding: 20px;
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        list-style: none;
        outline: none;
        user-select: none;
    }

    .faq-question::-webkit-details-marker {
        display: none;
    }

    .faq-question::after {
        content: "➕";
        font-size: 13px;
        color: <?php echo $neon; ?>;
        transition: transform 0.3s ease;
    }

    .faq-item[open] .faq-question::after {
        content: "➖";
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 20px 20px 20px;
        border-top: 1px solid rgba(255,255,255,0.03);
        color: #a0aec0;
        font-size: 14.5px;
        line-height: 1.7;
    }

    .faq-answer p {
        margin: 10px 0 0 0;
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

    @media (max-width: 480px) {
        .inner-page-content { padding: 20px; }
        .rgb-text-lighting { font-size: 2rem; }
        .faq-question { font-size: 14.5px; padding: 15px; }
        .faq-answer { padding: 0 15px 15px 15px; }
    }
</style>

<?php
get_footer();
?>
