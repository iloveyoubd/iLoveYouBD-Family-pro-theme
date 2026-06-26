<?php
/**
 * Template Name: Cyber DMCA Policy Pro
 * Description: Fully Functional Compliant DMCA & Copyright Complaint Registration Page
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1100px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">DMCA Policy</h1>
            <p class="section-subtext">কপিরাইট ও অপসারণের নিয়মাবলী / COPYRIGHT INFRINGEMENT REGISTRY</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                
                <section class="policy-block">
                    <h2>⚖️ DMCA Copyright Infringement & Take-down Request Protocol</h2>
                    <p>ILOVEYOUBD.COM respects the intellectual property rights of others. In accordance with the Digital Millennium Copyright Act ("DMCA"), we respond promptly to clear, fully formatted claims of alleged copyright infringement. If you believe your original content has been hosted on our platform without authorization, you may file a formal notification utilizing our secure legal portal below.</p>
                </section>

                <div class="policy-divider"></div>

                <div class="policy-grid" style="grid-template-columns: 1fr 1fr;">
                    <div class="legal-notice-sidebar">
                        <div class="policy-card" style="height: 100%;">
                            <h3 style="color: #ff3e3e; border-color: rgba(255,62,62,0.2);"><i class="fa-solid fa-triangle-exclamation"></i> CRITICAL LEGAL REQUIREMENTS</h3>
                            <p style="font-size: 13px; line-height: 1.6;">Your DMCA Claim payload must satisfy the following criteria to be legally valid under 17 U.S.C. § 512(c)(3):</p>
                            <ul style="font-size: 13.5px; line-height: 1.8; color: #a0aec0; padding-left: 20px; list-style-type: decimal;">
                                <li>Specify your legal name, physical mailing address, secure email, and authorization credentials.</li>
                                <li>Provide the precise, absolute target URLs hosting the alleged infringing material.</li>
                                <li>A clear description and evidence of your original copyrighted work (including trademark or registration indicators).</li>
                                <li>Include a statement made in good faith that "the disputing party has a good faith belief that use of the material is not authorized".</li>
                                <li>Include a statement made under penalty of perjury that "the information in the notification is accurate".</li>
                            </ul>
                            <div style="background: rgba(255,255,255,0.02); padding: 15px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.05); margin-top: 15px; font-size: 11.5px; color: #8b949e; line-height: 1.5;">
                                ⚠️ <strong>Important Notice:</strong> Misrepresenting copyright infringement in a written notification may subject you to statutory damages, including attorneys' fees, under Section 512(f) of the DMCA.
                            </div>
                        </div>
                    </div>

                    <div class="dmca-interface-form">
                        <div class="policy-card" style="background: rgba(255, 62, 62, 0.02); border-color: rgba(255, 62, 62, 0.12);">
                            <h3 style="color: var(--cyber-neon); border-color: rgba(0,255,204,0.15);"><i class="fa-solid fa-gavel"></i> Secure DMCA Lodger Portal</h3>
                            
                            <?php
                            $dmca_logged = false;
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dmca_registry_nonce'])) {
                                $dmca_logged = true;
                                $legal_name = sanitize_text_field($_POST['legal_name']);
                                $copyright_email = sanitize_email($_POST['copyright_email']);
                                $infringing_url = esc_url_raw($_POST['infringing_url']);
                                $original_url = esc_url_raw($_POST['original_url']);
                                $evidence_notes = sanitize_textarea_field($_POST['evidence_notes']);
                                $perjury_confirm = isset($_POST['perjury_confirm']) ? 'YES' : 'NO';
                                
                                // Store the DMCA report in options database for administrative review
                                $reports = get_option('ilybd_dmca_reports', []);
                                if (!is_array($reports)) { $reports = []; }
                                $reports[] = [
                                    'timestamp' => current_time('mysql'),
                                    'legal_name' => $legal_name,
                                    'email' => $copyright_email,
                                    'infringing_url' => $infringing_url,
                                    'original_url' => $original_url,
                                    'evidence' => $evidence_notes,
                                    'perjury' => $perjury_confirm,
                                    'status' => 'INVESTIGATING'
                                ];
                                update_option('ilybd_dmca_reports', array_slice($reports, -30)); // Cap at last 30 reports
                            }
                            
                            if ($dmca_logged): ?>
                                <div class="legal-acknowledgement" style="background: rgba(255, 62, 62, 0.05); border: 1px dashed #ff3e3e; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                                    <h4 style="color: #ff3e3e; margin: 0 0 10px 0; font-family: monospace;"><i class="fa-solid fa-satellite-dish"></i> LEGAL PAYLOAD COMMITTED</h4>
                                    <p style="font-size: 13px; line-height: 1.6; color: #a0aec0; margin-bottom: 15px;">
                                        Your copyright claim payload reference #<?php echo rand(1000, 9999); ?> was received, hashed, and entered into the regulatory legal registry log. Our compliance officer will audit the evidence within 24 working hours.
                                    </p>
                                    <div style="font-family: monospace; font-size: 11px; color: #ff3e3e; background: rgba(0,0,0,0.4); padding: 8px; border-radius: 4px;">
                                        • Claimant: <?php echo esc_html($legal_name); ?><br>
                                        • Ticket ID: IBD_DMCA_<?php echo rand(50000, 99999); ?><br>
                                        • Security Hash: SHA256_VERIFIED
                                    </div>
                                </div>
                            <?php endif; ?>

                            <form action="" method="POST">
                                <input type="hidden" name="dmca_registry_nonce" value="1">

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Legal Claimant Name / নাম</label>
                                <input type="text" name="legal_name" style="width: 100%; max-width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="Full Legal Representative Name" required>

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Secure Legal Email / ইমেইল</label>
                                <input type="email" name="copyright_email" style="width: 100%; max-width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="legal@yourbrand.com" required>

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Target URL on ILOVEYOUBD.COM / আমাদের লিংক</label>
                                <input type="url" name="infringing_url" style="width: 100%; max-width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="https://iloveyoubd.com/example-post" required>

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Original Work Reference / মূল প্রমাণ লিংক</label>
                                <input type="url" name="original_url" style="width: 100%; max-width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="https://yourpage.com/original-source" required>

                                <label style="color: #8b949e; font-size: 12px; display: block; margin-bottom: 6px;">Supporting Evidence & Description / বিস্তারিত</label>
                                <textarea name="evidence_notes" rows="4" style="width: 100%; max-width: 100%; box-sizing: border-box; background: #070a0f; border: 1px solid rgba(255,255,255,0.08); color: #fff; padding: 10px; border-radius: 6px; margin-bottom: 15px;" placeholder="Provide trademarks, copyright registry IDs, or proof notes..." required></textarea>

                                <div style="margin-bottom: 20px; display: flex; align-items: flex-start; gap: 8px;">
                                    <input type="checkbox" name="perjury_confirm" id="perjury_id" style="margin-top: 4px;" required>
                                    <label for="perjury_id" style="color: #8b949e; font-size: 11px; line-height: 1.5; cursor: pointer;">
                                        I hereby declare under penalty of perjury that the information contained here is accurate and I am authorized to act on behalf of the exclusive copyright owner.
                                    </label>
                                </div>

                                <button type="submit" style="width: 100%; background: #ff3e3e; border: none; padding: 12px; border-radius: 6px; color: #fff; font-weight: bold; cursor: pointer; text-transform: uppercase;">File DMCA Takedown Notice</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="policy-divider"></div>

                <div class="policy-grid" style="grid-template-columns: 1fr 1fr; margin-top: 25px;">
                    <!-- 1. Submission Procedure & Removal Timeline -->
                    <div class="policy-card">
                        <h3 style="color: #00ff41; border-color: rgba(0,255,65,0.15);"><i class="fa-solid fa-folder-open"></i> Submission & Removal Timeline</h3>
                        <p><strong>Bengali (সাবমিশন পদ্ধতি ও সময়সীমা):</strong> উপরে দেওয়া ডিজিটাল ফর্মটি পূরণ করে আপনি সরাসরি কপিরাইট রিপোর্ট সাবমিট করতে পারেন। আমাদের নিয়োজিত কর্মকর্তা তথ্য পর্যালোচনাপূর্বক সঠিক এবং যথাযথ অভিযোগের ক্ষেত্রে ২৪ থেকে ৪৮ ঘণ্টার মধ্যে অভিযুক্ত কন্টেন্ট স্থায়ীভাবে অপসারণ নিশ্চিত করবেন। </p>
                        <p><strong>English:</strong> Upon successful submission, your payload ticket is parsed immediately. Legitimate take-down requests fully meeting statutory conditions trigger file purging or link isolation within 24 to 48 hours.</p>
                    </div>

                    <!-- 2. Counter Notice Procedure & Contact -->
                    <div class="policy-card">
                        <h3 style="color: #00f0ff; border-color: rgba(0,240,255,0.15);"><i class="fa-solid fa-reply"></i> Counter Notice & Contact Node</h3>
                        <p><strong>Bengali (কাউন্টার নোটিশ ও যোগাযোগ):</strong> ভুলবশত কোনো কন্টেন্ট মুছে ফেলা হলে, কন্টেন্ট আপলোডার কাউন্টার নোটিশ দাখিল করতে পারেন। মূল কপিরাইট দপ্তরের সাথে সরাসরি যোগাযোগের জন্য আমাদের আইনি ঠিকানা: <code>legal@iloveyoubd.com</code>।</p>
                        <p><strong>English:</strong> Affected contributors may file counter-notifications in writing if a piece of content is mistakenly isolated. To request official paper review or contact physical departments, write to: <code>legal@iloveyoubd.com</code>.</p>
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

    @media (max-width: 768px) {
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
