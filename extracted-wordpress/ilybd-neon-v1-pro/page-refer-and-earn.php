<?php
/**
 * Template Name: Cyber Referral Hub & Guide
 * Description: Dedicated Referral Program Dashboard, Sharing Portal, and Policy Guard.
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
$is_logged_in = is_user_logged_in();
$current_user_id = get_current_user_id();
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1250px; margin: 0 auto; padding: 40px 20px;">
        
        <header class="cyber-section-header">
            <h1 class="rgb-text-lighting">Refer & Earn Program</h1>
            <p class="section-subtext">ইউনিক রেফারাল সিস্টেম ও ইনভাইট পোর্টাল / SECURE AFFILIATE NETWORK</p>
            <div class="sticky-rgb-line"></div>
        </header>

        <div class="slim-rgb-container">
            <div class="inner-page-content">
                
                <div class="referral-dashboard-grid">
                    
                    <!-- Main Affiliate Panel -->
                    <div class="referral-main-card">
                        <h2>👥 Secure Referral Network: Invite & Level Up Together</h2>
                        <p style="font-size: 14.5px; line-height: 1.8; color: #a0aec0; margin-bottom: 25px;">
                            আপনার বন্ধু ও পরিচিত প্রযুক্তিপ্রেমীদের আই লাভ ইউ বিডি (ILOVEYOUBD.COM) ডট কম-এ যোগদানের আমন্ত্রণ জানান। আপনার রেফারেল লিংক ব্যবহার করে যখনই কেউ নতুন অ্যাকাউন্ট তৈরি করে প্রোফাইল তথ্য এবং প্রথম কন্ট্রিবিউশন সম্পূর্ণ করবেন, আপনার অ্যাকাউন্টে সাথে সাথে <b>৫০ XP পয়েন্ট এবং ৳৫.০০ নগদ অর্থ</b> যোগ হবে। আমাদের এই প্রোগ্রামে আয়ের কোনো নির্দিষ্ট সীমা নেই!
                        </p>

                        <?php if ($is_logged_in): 
                            $raw_key = base64_encode("ref_" . $current_user_id);
                            $ref_url = home_url('/?ref=' . $raw_key);
                            ?>
                            <div class="invite-generator-box">
                                <span class="box-tag">YOUR UNIQUE RETRO REF-KEY ACTIVE</span>
                                <div class="copy-input-group">
                                    <input type="text" id="ref_link_input" value="<?php echo esc_url($ref_url); ?>" readonly>
                                    <button onclick="copyRefLink()" class="copy-link-btn" id="copy_btn">Copy Link Node</button>
                                </div>
                                <span class="copy-success-note" id="copy_success_txt" style="display: none;"><i class="fa-solid fa-circle-check"></i> Link successfully copied to secure system clipboard!</span>
                            </div>
                        <?php else: ?>
                            <div class="referral-login-notice" style="background: rgba(255, 62, 62, 0.03); border: 1px solid rgba(255, 62, 62, 0.15); border-radius: 8px; padding: 20px; text-align: center;">
                                <h4 style="color: #ff3e3e; margin: 0 0 8px 0;"><i class="fa-solid fa-lock"></i> Your Personalized Referral Link is Locked</h4>
                                <p style="font-size: 13px; color: #a0aec0; margin: 0 0 15px 0;">আপনার ইউনিক রেফারেল ট্র্যাকার লিঙ্ক তৈরি করতে এবং রেফার আয়ের পরিমাপ করতে অনুগ্রহ করে অ্যাকাউন্টে লগইন করুন।</p>
                                <a href="<?php echo wp_login_url(get_permalink()); ?>" class="action-btn" style="background: #00f0ff; color: #000; font-weight: bold; font-size: 12px; padding: 10px 20px; border-radius: 6px; text-decoration: none; text-transform: uppercase; display: inline-block;">Secure Login Node</a>
                            </div>
                        <?php endif; ?>

                        <div style="width: 100%; height: 1px; background: rgba(255,255,255,0.06); margin: 30px 0;"></div>

                        <h3>💡 How To Maximize Invites (পদক্ষেপসমূহ)</h3>
                        <div class="steps-container-grid">
                            <div class="st-box">
                                <span class="st-num">01</span>
                                <h5>Copy Your Tracker</h5>
                                <p>আপনার ড্যাশবোর্ডের ইউনিক আমন্ত্রণ লিংক এক ক্লিকে কপি বা সুরক্ষার সাথে সেভ করুন।</p>
                            </div>
                            <div class="st-box">
                                <span class="st-num">02</span>
                                <h5>Share on Tech Groups</h5>
                                <p>ফেসবুক, হোয়াটসঅ্যাপ বা টেলিগ্রামের মতো সাইবার ও প্রোগ্রামিং শিক্ষানবিস গ্রুপে লিঙ্ক শেয়ার করুন।</p>
                            </div>
                            <div class="st-box">
                                <span class="st-num">03</span>
                                <h5>Unlock Lifetime Bonus</h5>
                                <p>আমন্ত্রিত ইউজাররা কন্ট্রিবিউট বা নিয়মিত কমেন্ট করামাত্র আপনার ওয়ালেট আপডেট হতে থাকবে।</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Stats / Warnings -->
                    <div class="referral-side-panel">
                        <div class="side-card info-glow">
                            <h3>🛡️ Reward Distribution Metrics</h3>
                            <div class="metrics-list">
                                <div class="m-row">
                                    <span>XP Bonus Value</span>
                                    <span style="color: #ffaa00; font-weight: bold; font-family: monospace;">+50 XP</span>
                                </div>
                                <div class="m-row">
                                    <span>Wallet Cash Value</span>
                                    <span style="color: #00ff41; font-weight: bold; font-family: monospace;">+৳5.00</span>
                                </div>
                                <div class="m-row">
                                    <span>Verification Lag</span>
                                    <span style="color: #00f0ff; font-weight: bold; font-family: monospace;">Realtime</span>
                                </div>
                                <div class="m-row">
                                    <span>Min Withdrawal</span>
                                    <span style="color: #fff; font-weight: bold; font-family: monospace;">৳300.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="side-card alert-glow" style="margin-top: 25px;">
                            <h3 style="color: #ff3e3e;"><i class="fa-solid fa-triangle-exclamation"></i> Anti-Cheat Protection Shield</h3>
                            <p style="font-size: 12.5px; color: #a0aec0; line-height: 1.6; margin: 0 0 12px 0;">
                                আমাদের প্ল্যাটফর্ম পলিসি চরমভাবে কঠোর। যেকোনো প্রক্সি সার্ভার, ভিপিএন (VPN), এক রাউটার থেকে একাধিক ফেক রেফারেল বা একই ডিভাইসে বারবার রেজিস্ট্রেশন ট্র্যাকার দ্বারা স্বয়ংক্রিয়ভাবে অডিট হয়ে লক হয়ে যাবে।
                            </p>
                            <p style="font-size: 12.5px; color: #a0aec0; line-height: 1.6; margin: 0;">
                                স্প্যাম রেফারেল তৈরি করার চেষ্টা করা হলে আপনার সম্পূর্ণ উপার্জিত পূর্ববর্তী ওয়ালেট ব্যালেন্স বাতিল সহ অ্যাকাউন্ট স্থায়ীভাবে সাসপেন্ড করা হবে।
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<script>
    function copyRefLink() {
        // Select Text Input Node
        const linkInput = document.getElementById('ref_link_input');
        linkInput.select();
        linkInput.setSelectionRange(0, 99999); // Mobile compatibility

        // Execute Clipboard write
        navigator.clipboard.writeText(linkInput.value).then(() => {
            // UI visual feedback
            const btn = document.getElementById('copy_btn');
            const successTxt = document.getElementById('copy_success_txt');
            
            btn.innerText = "COPIED!";
            btn.style.background = "#00ff41";
            successTxt.style.display = "block";
            
            setTimeout(() => {
                btn.innerText = "Copy Link Node";
                btn.style.background = "#00f0ff";
            }, 3000);
        });
    }
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

    /* Rotating gradient border wrapper */
    .slim-rgb-container {
        position: relative;
        padding: 1px;
        background: linear-gradient(var(--angle), #ff00ff, #00f0ff, #00ff41, #ff00ff);
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

    /* Referral Layout */
    .referral-dashboard-grid {
        display: grid;
        grid-template-columns: 1.3fr 0.7fr;
        gap: 30px;
    }

    .referral-main-card {
        background: rgba(255,255,255,0.01);
        border: 1px solid rgba(255,255,255,0.04);
        border-radius: 14px;
        padding: 30px;
    }

    .referral-main-card h2 {
        color: #fff;
        font-size: 20px;
        margin-top: 0;
        margin-bottom: 12px;
        font-family: 'Space Grotesk', sans-serif;
    }

    .invite-generator-box {
        background: rgba(0,0,0,0.4);
        border: 1px solid rgba(255,255,255,0.03);
        border-radius: 10px;
        padding: 24px;
    }

    .box-tag {
        font-family: monospace;
        font-size: 10.5px;
        color: <?php echo $neon; ?>;
        letter-spacing: 1.5px;
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .copy-input-group {
        display: flex;
        gap: 15px;
    }

    .copy-input-group input {
        flex: 1;
        background: #05070a;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 6px;
        color: #00f0ff;
        font-family: monospace;
        font-size: 13.5px;
        padding: 12px 15px;
        outline: none;
    }

    .copy-link-btn {
        background: #00f0ff;
        color: #000;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        padding: 0 25px;
        cursor: pointer;
        text-transform: uppercase;
        font-size: 11.5px;
        letter-spacing: 0.5px;
        transition: 0.2s;
        outline: none;
    }

    .copy-link-btn:hover {
        box-shadow: 0 0 15px #00f0ffaa;
    }

    .copy-success-note {
        display: block;
        margin-top: 10px;
        font-size: 11.5px;
        color: #00ff41;
        font-family: monospace;
    }

    /* Steps Layout */
    .steps-container-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .st-box {
        background: rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.02);
        border-radius: 8px;
        padding: 18px;
    }

    .st-num {
        display: block;
        font-family: 'Space Grotesk', sans-serif;
        font-size: 22px;
        font-weight: 900;
        color: rgba(255,255,255,0.06);
        border-bottom: 1px solid rgba(255,255,255,0.04);
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .st-box h5 {
        margin: 0 0 8px 0;
        font-size: 13px;
        color: #fff;
    }

    .st-box p {
        margin: 0;
        font-size: 11.5px;
        color: #8b949e;
        line-height: 1.5;
    }

    /* Side Cards */
    .side-card {
        background: rgba(255,255,255,0.01);
        border: 1px solid rgba(255,255,255,0.04);
        border-radius: 14px;
        padding: 25px;
    }

    .side-card.info-glow {
        border-color: rgba(0, 255, 65, 0.15);
    }

    .side-card.alert-glow {
        border-color: rgba(255, 62, 62, 0.15);
    }

    .side-card h3 {
        color: #fff;
        font-size: 15.5px;
        margin-top: 0;
        margin-bottom: 15px;
        font-family: 'Space Grotesk', sans-serif;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        padding-bottom: 8px;
    }

    .metrics-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .m-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        border-bottom: 1px dashed rgba(255,255,255,0.03);
        padding-bottom: 8px;
    }

    .m-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    @media (max-width: 900px) {
        .referral-dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .steps-container-grid {
            grid-template-columns: 1fr;
        }
    }

    @keyframes rgb_flow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<?php get_footer(); ?>
