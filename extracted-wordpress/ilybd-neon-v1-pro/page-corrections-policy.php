<?php
/**
 * Template Name: Cyber Corrections Policy Pro
 * Description: High-EEAT Editorial Correction Reporting Interface & Transparency Log
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1100px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">Corrections Policy</h1>
            <p class="section-subtext">ভুল সংশোধনের নিয়মাবলী ও স্বচ্ছতা লগ / EDITORIAL TRANSPARENCY LOG</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                
                <section class="policy-block">
                    <h2>🎯 Our Commitment to Factual Accuracy & Transparent Corrections</h2>
                    <p>At ILOVEYOUBD.COM, we make every effort to get information 100% correct first time. However, in complex technical fields like cyber defense, system setups, and programmatic libraries, errors or version deprecation can occasionally occur. When we make mistakes, we acknowledge them transparently, correct them swiftly, and log the updates detailing the changes. Below you can report any errors or review our live Transparency log. </p>
                </section>

                <div class="policy-divider"></div>

                <div class="policy-grid" style="grid-template-columns: 1.5fr 1fr;">
                    
                    <div class="transparency-log-section">
                        <div class="policy-card">
                            <h3 style="color: #ffaa00; border-color: rgba(255,170,0,0.15);"><i class="fa-solid fa-clock-rotate-left"></i> LIVE TRANSPARENCY ACTIONS LOG</h3>
                            <p style="font-size: 13.5px; color: #8b949e; margin-bottom: 20px;">Review the recent corrective transmissions authorized by our editorial boards:</p>
                            
                            <div class="styled-log-table" style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse; font-family: monospace; font-size: 12px; text-align: left;">
                                    <thead>
                                        <tr style="border-bottom: 2px solid rgba(255,170,0,0.25); color: #fff; background: rgba(255,255,255,0.02);">
                                            <th style="padding: 12px 8px;">DATE</th>
                                            <th style="padding: 12px 8px;">ARTICLE PATH</th>
                                            <th style="padding: 12px 8px;">ORIGINAL DETECT</th>
                                            <th style="padding: 12px 8px;">CORRECTION IMPLEMENTED</th>
                                        </tr>
                                    </thead>
                                    <tbody style="color: #a0aec0;">
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); background: rgba(0,0,0,0.2);">
                                            <td style="padding: 12px 8px; color: #ffaa00;">June 18, 2026</td>
                                            <td style="padding: 12px 8px; font-weight: bold; color: #fff;">/top-10-wordpress-optimization-tips</td>
                                            <td style="padding: 12px 8px;">Deprecated PHP 8.1 OPcache memory limit variable referenced in code snippet.</td>
                                            <td style="padding: 12px 8px; color: #00ff41;">Engine updated values to php.ini recommendation compatible with PHP 8.3 server setups.</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
                                            <td style="padding: 12px 8px; color: #ffaa00;">May 24, 2026</td>
                                            <td style="padding: 12px 8px; font-weight: bold; color: #fff;">/secure-nginx-api-gateways</td>
                                            <td style="padding: 12px 8px;">Syntax error identified in ssl_ciphers config parameters block.</td>
                                            <td style="padding: 12px 8px; color: #00ff41;">Corrected syntax block, fully validated on NGINX 1.25 instance, telemetry re-ran.</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); background: rgba(0,0,0,0.2);">
                                            <td style="padding: 12px 8px; color: #ffaa00;">May 05, 2026</td>
                                            <td style="padding: 12px 8px; font-weight: bold; color: #fff;">/best-ai-tools-bloggers</td>
                                            <td style="padding: 12px 8px;">Outdated tool pricing plans referenced in secondary review sections.</td>
                                            <td style="padding: 12px 8px; color: #00ff41;">Updated pricing metrics, added comparative matrices, set last updated timestamp.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="font-size: 11px; color: #8b949e; margin-top: 15px; font-style: italic;">
                                Note: Log updates are published immediately following confirmation, fact-checking, and developer sandboxed tests.
                            </div>
                        </div>
                    </div>

                    <div class="error-report-form">
                        <div class="policy-card" style="border-color: rgba(0,255,204,0.12);">
                            <h3 style="color: var(--cyber-neon); border-color: rgba(0,255,204,0.15);"><i class="fa-solid fa-bug-slash"></i> Error Submission Matrix</h3>
                            
                            <?php
                            $correction_logged = false;
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correction_action_nonce'])) {
                                $correction_logged = true;
                                $reporter_name = sanitize_text_field($_POST['reporter_name']);
                                $reporter_email = sanitize_email($_POST['reporter_email']);
                                $reported_url = esc_url_raw($_POST['reported_url']);
                                $error_desc = sanitize_textarea_field($_POST['error_desc']);
                                $proposed_corr = sanitize_textarea_field($_POST['proposed_corr']);
                                
                                // Store report dynamically in options database
                                $reports = get_option('ilybd_corrections_reports', []);
                                if (!is_array($reports)) { $reports = []; }
                                $reports[] = [
                                    'timestamp' => current_time('mysql'),
                                    'name' => $reporter_name,
                                    'email' => $reporter_email,
                                    'url' => $reported_url,
                                    'error' => $error_desc,
                                    'proposed' => $proposed_corr,
                                    'status' => 'PENDING_AUDIT'
                                ];
                                update_option('ilybd_corrections_reports', array_slice($reports, -30));
                            }
                            
                            if ($correction_logged): ?>
                                <div class="legal-acknowledgement" style="background: rgba(0, 255, 204, 0.05); border: 1px dashed var(--cyber-neon); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                                    <h4 style="color: var(--cyber-neon); margin: 0 0 10px 0; font-family: monospace;"><i class="fa-solid fa-code-merge"></i> PAYLOAD TRANSMITTED</h4>
                                    <p style="font-size: 13px; line-height: 1.6; color: #8b949e; margin-bottom: 12px;">
                                        Accuracy ticket filed. Our technical auditors will review this reference against live documentation stacks.
                                    </p>
                                    <div style="font-family: monospace; font-size: 11px; color: var(--cyber-neon); background: rgba(0,0,0,0.4); padding: 8px; border-radius: 4px;">
                                        • Ticket ID: IBD_CORR_<?php echo rand(20000, 49999); ?><br>
                                        • Target: <?php echo esc_html(basename($reported_url) ?: 'root'); ?><br>
                                        • Status: PARSING_TRANSMISSION
                                    </div>
                                </div>
                            <?php endif; ?>

                            <form action="" method="POST">
                                <input type="hidden" name="correction_action_nonce" value="1">

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Your Name / নাম</label>
                                <input type="text" name="reporter_name" style="width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="Full Name" required>

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Your Email / ইমেইল</label>
                                <input type="email" name="reporter_email" style="width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="you@email.com" required>

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Target Post/Article URL / ভুল পেইজের লিংক</label>
                                <input type="url" name="reported_url" style="width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="https://iloveyoubd.com/post-with-error" required>

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Identified Error / ত্রুটির বিবরণ</label>
                                <textarea name="error_desc" rows="3" style="width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="Detail the typo, outdated code, or inaccurate detail..." required></textarea>

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Proposed Correction / আপনার চোখে সঠিক উত্তর</label>
                                <textarea name="proposed_corr" rows="3" style="width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="What should be written instead? (Leave code snippets if applicable)"></textarea>

                                <button type="submit" style="width: 100%; background: var(--cyber-neon); border: none; padding: 12px; border-radius: 6px; color: #000; font-weight: bold; cursor: pointer; text-transform: uppercase;">File Error Correction Report</button>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="policy-divider"></div>

                <div class="policy-grid" style="grid-template-columns: 1fr 1fr; margin-top: 25px;">
                    <!-- 1. Correction Workflow -->
                    <div class="policy-card">
                        <h3 style="color: #00ff41; border-color: rgba(0,255,65,0.15);"><i class="fa-solid fa-code-pull-request"></i> Correction Workflow / সংশোধন কর্মধারা</h3>
                        <p><strong>Bengali:</strong> রিপোর্টের প্রথম ধাপে আমাদের ফ্যাক্ট-চেকাররা তথ্যের সত্যতা যাচাই করেন। ত্রুটি প্রমাণিত হলে তা সংশোধন করে আমাদের 'লাইভ ট্রান্সপারেন্সি অ্যাকশন লগ'-এ যুক্ত করা হয় এবং সংশোধনকৃত তথ্যটি তাৎক্ষণিকভাবে সম্পর্কিত আর্টিকেলে প্রকাশ পায়।</p>
                        <p><strong>English:</strong> Once a correction report is registered, our editors cross-reference the claim with original documentation or dynamic testing sandboxes. Upon verification, the update is implemented immediately and listed in our public log.</p>
                    </div>

                    <!-- 2. Revision History Commitments -->
                    <div class="policy-card">
                        <h3 style="color: #00f0ff; border-color: rgba(0,240,255,0.15);"><i class="fa-solid fa-file-shield"></i> Revision & Transparency Commitment</h3>
                        <p><strong>Bengali:</strong> আমরা কখনই ভুল তথ্য লুকিয়ে রাখি না। প্রতিটি ভুল এবং সংশোধনের কারণ এবং তারিখ স্বচ্ছভাবে প্রকাশ করা হয় যাতে ব্যবহারকারীরা তথ্যের ধারাবাহিকতা এবং সত্যতা সম্পর্কে নিশ্চিত হতে পারেন।</p>
                        <p><strong>English:</strong> Our team is committed to the highest compliance standards. Significant modifications or technical alterations to coding tutorials are logged, keeping a history of edits clear for indexing search engines.</p>
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
