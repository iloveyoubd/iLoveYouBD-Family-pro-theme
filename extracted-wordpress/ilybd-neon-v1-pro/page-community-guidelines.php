<?php
/**
 * Template Name: Cyber Guidelines Pro
 * Description: Fully Professional SEO-Optimized Cyberpunk Community Guidelines Page
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">Community Guidelines</h1>
            <p class="section-subtext">ILYBD SYSTEM / FORUM CIVIC CODE</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                <div class="guidelines-intro">
                    <p>Welcome to the <strong>ILYBD Community Node (iloveyoubd.com/forum)</strong>. To keep our interactive channels (Q&A forums, comment sections, like loops) productive, fast, and intellectually empowering for technology developers, we expect all registered users to follow these community codes.</p>
                </div>

                <div class="policy-grid">
                    <div class="policy-card">
                        <h3>🔑 1. Mutual Respect & Support</h3>
                        <p>We are a community comprising students, professionals, and engineering enthusiasts. Act with humility, respect one another, and offer clear answers when responding to active questions. Harsh comments, personal attacks, or aggressive language on profiles are not permitted.</p>
                    </div>

                    <div class="policy-card">
                        <h3>⚡ 2. Code Sharing & Intellectual Integrity</h3>
                        <p>When sharing custom WordPress codes, scripts, or application links, please document them accurately. Keep source codes clear, specify modifications made, and avoid publishing backdoor-loaded archives, deceptive redirects, or unauthorized software cracks.</p>
                    </div>

                    <div class="policy-card">
                        <h3>🛡️ 3. No Spam or Automated Floods</h3>
                        <p>In order to maintain Lightning-Fast Database Speeds, automated script submissions, copy-pasting the same answers repeatedly, link spamming, advertising unrelated platforms, or creating auxiliary accounts to execute voting manipulation is strictly prohibited.</p>
                    </div>

                    <div class="policy-card">
                        <h3>📜 4. Moderation & Enforcement</h3>
                        <p>Our engineering coordinators and volunteer moderators possess full control to flag spam, edit inaccurate code tags, or permanently suspend user nodes that breach these terms. To dispute moderation decisions, please contact support via formal encrypted channels.</p>
                    </div>

                    <div class="policy-card" style="grid-column: span 2; border-color: <?php echo $neon; ?>44; background: rgba(0, 255, 65, 0.02);">
                        <h3 style="color: <?php echo $neon; ?>;"><i class="fa-solid fa-hand-holding-dollar"></i> 💸 ৫. কন্টেন্ট পাবলিশ এবং উইথড্র গাইডলাইন (Publishing & Withdrawal Protocol)</h3>
                        <p style="margin-bottom: 15px; color: #fff;">আমাদের প্ল্যাটফর্মে প্রযুক্তিভিত্তিক অরিজিনাল কন্টেন্ট বা পোস্ট পাবলিশ করার বিনিময়ে লেখকদের অ্যাকাউন্টে রিয়েল-টাইম টাকা জমা হয়। এই প্রক্রিয়ার জন্য নিম্নলিখিত নিয়মাবলী অনুসরণ করতে হবে:</p>
                        <ul style="color: #a0aec0; font-size: 13.5px; line-height: 1.8; padding-left: 20px; list-style-type: decimal;">
                            <li><strong style="color: #fff;">অরিজিনাল কন্টেন্ট প্রকাশ:</strong> প্রতিটি পোস্ট অবশ্যই শিক্ষামূলক এবং ইউনিক হতে হবে। কপি-পেস্ট কন্টেন্টের জন্য কোনো রিওয়ার্ড যোগ হবে না এবং অ্যাকাউন্ট বাতিল হতে পারে।</li>
                            <li><strong style="color: #fff;">পেমেন্ট জমা:</strong> কন্টেন্ট মডারেশন পার করে সফলভাবে পাবলিশ হওয়ার সাথে সাথে আপনার ওয়ালেট নোডে স্বয়ংক্রিয়ভাবে টাকা জমা হয়।</li>
                            <li><strong style="color: #fff;">উইথড্র সিস্টেম:</strong> ইউজার প্যানেল থেকে অর্জিত ব্যালেন্স মোবাইল ব্যাংকিং (বিকাশ, রকেট, নগদ) এর মাধ্যমে উত্তোলন করা যাবে।</li>
                            <li><strong style="color: #fff;">প্রসেসিং টাইম:</strong> উইথড্রয়াল রিকোয়েস্ট সাবমিট করার ২৪ থেকে ৭২ ঘণ্টার মধ্যে যথাযথ ভেরিফিকেশন সাপেক্ষে পেমেন্ট সম্পূর্ণ করা হয়।</li>
                        </ul>
                    </div>
                </div>

                <div class="policy-footer-note">
                    <p>Spotted a violation thread or need to report suspicious account nodes code? Get in touch with our security moderators at <strong>support@iloveyoubd.com</strong>.</p>
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

    .guidelines-intro {
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
