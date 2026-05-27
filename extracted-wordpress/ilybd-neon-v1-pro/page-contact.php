<?php
/**
 * Template Name: Cyber Contact Pro
 * Description: Fully Professional SEO-Optimized Cyberpunk Contact Page
 */

// ১. SEO & Schema Markup Engine (গুগল ইনডেক্সিং এর জন্য)
function ibd_cyber_contact_seo_engine() {
    ?>
    <title>Contact Us | IBD Cyber Lab - Engineering Science & Technologies</title>
    <meta name="description" content="Connect with IBD Cyber Lab for expert laboratory equipment and technology solutions in Singair, Manikganj. Secure and SEO-first communication.">
    <meta name="keywords" content="IBD Cyber Lab, Engineering Science and Technologies, Laboratory Equipment Bangladesh, Singair Manikganj Tech">
    
    <!-- Local Business Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "IBD Cyber Lab (EST)",
      "url": "https://iloveyoubd.com",
      "logo": "https://iloveyoubd.com/logo.png",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Singair",
        "addressLocality": "Manikganj",
        "addressCountry": "BD"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "email": "support@iloveyoubd.com",
        "contactType": "Customer Support"
      }
    }
    </script>
    <?php
}
add_action('wp_head', 'ibd_cyber_contact_seo_engine');

get_header(); ?>

<style>
    :root {
        --cyber-neon: #00ffcc;
        --cyber-bg: #0d1117;
        --cyber-box: #161b22;
        --cyber-text: #8b949e;
        --cyber-glow: 0 0 15px rgba(0, 255, 204, 0.3);
    }

    .cyber-contact-wrapper {
        background: var(--cyber-bg);
        color: #fff;
        padding: 60px 20px;
        font-family: 'Segoe UI', Tahoma, sans-serif;
        min-height: 80vh;
    }

    .cyber-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 40px;
    }

    /* Left Panel: Info Cards */
    .info-card {
        background: var(--cyber-box);
        padding: 25px;
        border-radius: 12px;
        border: 1px solid #30363d;
        margin-bottom: 20px;
        transition: 0.4s;
    }

    .info-card:hover {
        border-color: var(--cyber-neon);
        box-shadow: var(--cyber-glow);
    }

    .info-card h3 {
        color: var(--cyber-neon);
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-top: 0;
    }

    .info-card p {
        color: #fff;
        margin: 10px 0 0;
        font-size: 16px;
    }

    /* Right Panel: Form Box */
    .cyber-form-box {
        background: var(--cyber-box);
        padding: 40px;
        border-radius: 15px;
        border: 1px solid #30363d;
        position: relative;
    }

    .cyber-form-box::before {
        content: "SECURE CHANNEL";
        position: absolute;
        top: -10px;
        right: 20px;
        background: var(--cyber-neon);
        color: #000;
        padding: 2px 10px;
        font-size: 10px;
        font-weight: bold;
        border-radius: 4px;
    }

    .cyber-field {
        width: 100%;
        background: var(--cyber-bg) !important;
        border: 1px solid #30363d !important;
        color: var(--cyber-neon) !important;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 6px;
        outline: none;
    }

    .cyber-field:focus {
        border-color: var(--cyber-neon) !important;
        box-shadow: 0 0 10px rgba(0, 255, 204, 0.1);
    }

    .execute-btn {
        background: var(--cyber-neon);
        color: #000;
        border: none;
        padding: 15px;
        width: 100%;
        font-weight: bold;
        text-transform: uppercase;
        cursor: pointer;
        border-radius: 5px;
        transition: 0.3s;
    }

    .execute-btn:hover {
        box-shadow: 0 0 25px var(--cyber-neon);
        transform: translateY(-2px);
    }

    .social-links a {
        color: var(--cyber-text);
        text-decoration: none;
        margin-right: 15px;
        font-size: 13px;
        transition: 0.3s;
    }

    .social-links a:hover {
        color: var(--cyber-neon);
    }

    @media (max-width: 768px) {
        .cyber-container { grid-template-columns: 1fr; }
    }
</style>

<div class="cyber-contact-wrapper">
    <div class="cyber-container">
        
        <!-- Left Side: Identity & Location -->
        <div class="contact-sidebar">
            <h1 style="color: var(--cyber-neon); font-size: 38px; margin-bottom: 5px;">IBD Cyber Lab</h1>
            <p style="color: var(--cyber-text); margin-bottom: 30px;">Engineering Science & Technologies (EST)</p>

            <div class="info-card">
                <h3>Location (Base)</h3>
                <p>Singair, Manikganj, Bangladesh</p>
            </div>

            <div class="info-card">
                <h3>Communication</h3>
                <p>support@iloveyoubd.com</p>
            </div>

            <div class="info-card">
                <h3>Social Presence</h3>
                <div class="social-links" style="margin-top: 10px;">
                    <a href="#">YouTube (19K+)</a>
                    <a href="#">Facebook (11K+)</a>
                </div>
            </div>
        </div>

        <!-- Right Side: Interaction Form -->
        <div class="cyber-form-box">
            <h2 style="color: var(--cyber-neon); margin-bottom: 25px;">Establish Connection</h2>
            <form action="#" method="POST">
                <label style="color: var(--cyber-text); font-size: 12px;">Full Identity</label>
                <input type="text" name="name" class="cyber-field" placeholder="Full Name" required>

                <label style="color: var(--cyber-text); font-size: 12px;">Secure Email</label>
                <input type="email" name="email" class="cyber-field" placeholder="yourname@email.com" required>

                <label style="color: var(--cyber-text); font-size: 12px;">Transmission Subject</label>
                <input type="text" name="subject" class="cyber-field" placeholder="Inquiry Type">

                <label style="color: var(--cyber-text); font-size: 12px;">Message Content</label>
                <textarea name="message" class="cyber-field" rows="5" placeholder="Write your message here..." required></textarea>

                <button type="submit" class="execute-btn">Execute Transmission</button>
            </form>
        </div>

    </div>
</div>

<?php get_footer(); ?>
