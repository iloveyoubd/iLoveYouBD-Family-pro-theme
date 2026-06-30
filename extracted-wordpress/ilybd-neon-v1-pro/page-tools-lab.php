<?php
/**
 * Template Name: Cyber Tools Lab Pro
 * Description: Fully Professional SEO-Optimized Interactive Cyberpunk Tools Lab Page
 */

get_header();
$neon = get_option('ilybd_main_color', '#00ff41');
?>

<div class="cyber-page-wrapper">
    <div class="container-fluid" style="max-width: 1200px; margin: 0 auto; padding: 10px 20px 100px;">
        
        <header class="cyber-section-header" style="text-align: center; margin-bottom: 45px;">
            <h1 class="rgb-text-lighting" style="font-size: 1.8rem; font-weight: 900; text-transform: uppercase; letter-spacing: 3px; margin: 0 0 10px 0; background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000); background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; animation: rgb_flow 4s linear infinite;">Future Tools Lab</h1>
            <script>
                // Dynamic responsive title sizing for Tools Lab page
                if (window.innerWidth >= 768) {
                    var el = document.querySelector('.rgb-text-lighting');
                    if(el) el.style.fontSize = '2.8rem';
                }
            </script>
            <p class="section-subtext" style="color: <?php echo esc_attr($neon); ?>; font-size: 11px; letter-spacing: 5px; text-transform: uppercase; margin-bottom: 20px; font-weight: 700;">ILYBD SYSTEM / DIGITAL INNOVATION LABORATORY / ২০৪০ সংস্করণ</p>
            <div class="sticky-rgb-line" style="height: 2px; width: 100%; background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000); background-size: 200% auto; animation: rgb_flow 4s linear infinite; box-shadow: 0 0 15px <?php echo esc_attr($neon); ?>dd;"></div>
        </header>

        <!-- Dynamic Main Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; margin-bottom: 40px;">
            
            <!-- Tool 3: AI Assistant (Interacts with Floating Chatbot) -->
            <div class="tool-deck-card" style="background: rgba(13, 21, 37, 0.75); border: 1.5px solid rgba(251, 191, 36, 0.15); border-radius: 16px; padding: 25px; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between;" onmouseover="this.style.borderColor='#fbbf24'; this.style.boxShadow='0 0 20px rgba(251,191,36,0.2)';" onmouseout="this.style.borderColor='rgba(251, 191, 36, 0.15)'; this.style.boxShadow='none';">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-size: 20px;">✨</span>
                        <span style="background: rgba(251, 191, 36, 0.1) !important; color: #fbbf24; border: 1px solid rgba(251,191,36,0.3); font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; font-family: monospace;">ONLINE 24/7</span>
                    </div>
                    <h3 style="color: #fff; font-size: 18px; font-weight: 850; margin: 0 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">এআই মায়া ক্লাউড অ্যাসিস্ট্যান্ট</h3>
                    <p style="color: #cbd5e0; font-size: 13px; line-height: 1.5; margin: 0 0 15px 0; font-family: 'Hind Siliguri', sans-serif;">২৪/৭ অনর্গল চমৎকার খাঁটি বাংলায় কথা বলতে সক্ষম অত্যন্ত উচ্চ মেধার এআই অ্যাসিস্ট্যান্ট। যেকোনো কোডিং বাগ বা আইটি সমস্যার ইনস্ট্যান্ট সমাধান নিন।</p>
                </div>
                <button onclick="jQuery('.cyber-chat-window').addClass('active'); alert('মায়া চ্যাট স্ক্রিনের নিচে ডানে ওপেন হয়েছে! কথা বলুন।');" class="util-action-btn" style="background: #fbbf24 !important; color: #000; display: block; width: 100%; border: none; text-align: center; font-weight: 850; font-size: 12px; text-transform: uppercase; padding: 12px; border-radius: 8px; cursor: pointer; transition: 0.3s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#fff'" onmouseout="this.style.background='#fbbf24'">মায়ার সাথে চ্যাট করুন ✨</button>
            </div>

            <!-- Tool 4: QR Code Creator (Interactive) -->
            <div class="tool-deck-card" style="background: rgba(13, 21, 37, 0.75); border: 1.5px solid rgba(168, 85, 247, 0.15); border-radius: 16px; padding: 25px; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between;" onmouseover="this.style.borderColor='#a855f7'; this.style.boxShadow='0 0 20px rgba(168,85,247,0.2)';" onmouseout="this.style.borderColor='rgba(168, 85, 247, 0.15)'; this.style.boxShadow='none';">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-size: 20px;">🧬</span>
                        <span style="background: rgba(168, 85, 247, 0.1) !important; color: #a855f7; border: 1px solid rgba(168,85,247,0.3); font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; font-family: monospace;">SEAMLESS API</span>
                    </div>
                    <h3 style="color: #fff; font-size: 18px; font-weight: 850; margin: 0 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">নিওন কিউআর কোড মেকার ল্যাব</h3>
                    <p style="color: #cbd5e0; font-size: 13px; line-height: 1.5; margin: 0 0 15px 0; font-family: 'Hind Siliguri', sans-serif;">যেকোনো ওয়েবসাইট লিংক, লেখা বা মোবাইল নাম্বার দিয়ে ব্র্যান্ড নিউ মাল্টি-পারপাস হাই ফিজিক্যাল কিউআর কোড জেনারেট এবং ফ্রি ডাউনলোড সুবিধা।</p>
                </div>
                <button onclick="openQrModal();" class="util-action-btn" style="background: #a855f7 !important; color: #fff; display: block; width: 100%; border: none; text-align: center; font-weight: 850; font-size: 12px; text-transform: uppercase; padding: 12px; border-radius: 8px; cursor: pointer; transition: 0.3s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#fff'; this.style.color='#000';" onmouseout="this.style.background='#a855f7'; this.style.color='#fff';">কোড জেনারেটর চালু করুন ➔</button>
            </div>

            <!-- Tool 5: SEO & CSS Glow Factory (Interactive) -->
            <div class="tool-deck-card" style="background: rgba(13, 21, 37, 0.75); border: 1.5px solid rgba(244, 63, 94, 0.15); border-radius: 16px; padding: 25px; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between;" onmouseover="this.style.borderColor='#f43f5e'; this.style.boxShadow='0 0 20px rgba(244,63,94,0.2)';" onmouseout="this.style.borderColor='rgba(244, 63, 94, 0.15)'; this.style.boxShadow='none';">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-size: 20px;">🏭</span>
                        <span style="background: rgba(244, 63, 94, 0.1) !important; color: #f43f5e; border: 1px solid rgba(244,63,94,0.3); font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; font-family: monospace;">WEBMASTER SEO</span>
                    </div>
                    <h3 style="color: #fff; font-size: 18px; font-weight: 850; margin: 0 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">সার্চ ইঞ্জিন মেটাডাটা ও সিএসএস গ্লো ফ্যাক্টরি</h3>
                    <p style="color: #cbd5e0; font-size: 13px; line-height: 1.5; margin: 0 0 15px 0; font-family: 'Hind Siliguri', sans-serif;">গুগলে ফার্স্ট পেজে ইনডেক্সিং এর জন্য মেটা ট্যাগ জেনারেট করুন এবং আপনার সাইটের জন্য আকর্ষণীয় নিওন সিএসএস গ্লো ইফেক্ট কোড তৈরি করুন।</p>
                </div>
                <button onclick="openSeoSuitModal();" class="util-action-btn" style="background: #f43f5e !important; color: #fff; display: block; width: 100%; border: none; text-align: center; font-weight: 850; font-size: 12px; text-transform: uppercase; padding: 12px; border-radius: 8px; cursor: pointer; transition: 0.3s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#fff'; this.style.color='#000';" onmouseout="this.style.background='#f43f5e'; this.style.color='#fff';">কোড জেনারেটর স্পেস 🏭</button>
            </div>

            <!-- Tool 6: Neon Music Synth (Interactive Web Audio API) -->
            <div class="tool-deck-card" style="background: rgba(13, 21, 37, 0.75); border: 1.5px solid rgba(34, 197, 94, 0.15); border-radius: 16px; padding: 25px; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between;" onmouseover="this.style.borderColor='#22c55e'; this.style.boxShadow='0 0 20px rgba(34,197,94,0.2)';" onmouseout="this.style.borderColor='rgba(34, 197, 94, 0.15)'; this.style.boxShadow='none';">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-size: 20px;">🎵</span>
                        <span style="background: rgba(34, 197, 94, 0.1) !important; color: #22c55e; border: 1px solid rgba(34,197,94,0.3); font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; font-family: monospace;">WEB AUDIO</span>
                    </div>
                    <h3 style="color: #fff; font-size: 18px; font-weight: 850; margin: 0 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">নিয়েন মিউজিক সিন্থেসাইজার ২০৪০</h3>
                    <p style="color: #cbd5e0; font-size: 13px; line-height: 1.5; margin: 0 0 15px 0; font-family: 'Hind Siliguri', sans-serif;">ব্রাউজার উইন্ডোর ভেতর সরাসরি এআই জেনারেটেড ডিজিটাল সাউন্ড ওয়েব ফ্রিকোয়েন্সি প্লে করার জন্য সর্বকালের আধুনিকতম সাইবার অডিও মেকার।</p>
                </div>
                <button onclick="openAudioSynthModal();" class="util-action-btn" style="background: #22c55e !important; color: #000; display: block; width: 100%; border: none; text-align: center; font-weight: 850; font-size: 12px; text-transform: uppercase; padding: 12px; border-radius: 8px; cursor: pointer; transition: 0.3s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#fff'" onmouseout="this.style.background='#22c55e'">মিউজিক ল্যাব প্লে করুন 🎵</button>
            </div>

            <!-- Tool 7: Cyber Cat Video Game (Interactive) -->
            <div class="tool-deck-card" style="background: rgba(13, 21, 37, 0.75); border: 1.5px solid rgba(236, 72, 153, 0.15); border-radius: 16px; padding: 25px; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between;" onmouseover="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 20px rgba(ec4899,0.2)';" onmouseout="this.style.borderColor='rgba(236, 72, 153, 0.15)'; this.style.boxShadow='none';">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-size: 20px;">🐈</span>
                        <span style="background: rgba(236, 72, 153, 0.1) !important; color: #ec4899; border: 1px solid rgba(236,72,153,0.3); font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; font-family: monospace;">CYBER GAME</span>
                    </div>
                    <h3 style="color: #fff; font-size: 18px; font-weight: 850; margin: 0 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">সাইবার টকিং পেট ক্যাট গেম</h3>
                    <p style="color: #cbd5e0; font-size: 13px; line-height: 1.5; margin: 0 0 15px 0; font-family: 'Hind Siliguri', sans-serif;">ভবিষ্যতের রোবোটিক কিউট বিড়াল CYBER_CAT_9000 এর সাথে খেলুন, খাওয়ান বা মিষ্টি আলাপ করুন সম্পূর্ণ থ্রিডি সাউন্ড প্রতিক্রিয়া সহ।</p>
                </div>
                <button onclick="openCyberCatModal();" class="util-action-btn" style="background: #ec4899 !important; color: #fff; display: block; width: 100%; border: none; text-align: center; font-weight: 850; font-size: 12px; text-transform: uppercase; padding: 12px; border-radius: 8px; cursor: pointer; transition: 0.3s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#fff'; this.style.color='#000';" onmouseout="this.style.background='#ec4899'; this.style.color='#fff';">পেট প্লে গ্রাউন্ড 🐈</button>
            </div>

            <!-- Tool 8: Ask Question Hub -->
            <div class="tool-deck-card" style="background: rgba(13, 21, 37, 0.75); border: 1.5px solid rgba(139, 92, 246, 0.15); border-radius: 16px; padding: 25px; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between;" onmouseover="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 20px rgba(139,92,246,0.2)';" onmouseout="this.style.borderColor='rgba(139, 92, 246, 0.15)'; this.style.boxShadow='none';">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-size: 20px;">💬</span>
                        <span style="background: rgba(139, 92, 246, 0.1) !important; color: #8b5cf6; border: 1px solid rgba(139,92,246,0.3); font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 4px; font-family: monospace;">Q&A COIN</span>
                    </div>
                    <h3 style="color: #fff; font-size: 18px; font-weight: 850; margin: 0 0 10px 0; font-family: 'Hind Siliguri', sans-serif;">প্রশ্ন-উত্তর ফোরাম ও ক্যাশ গেটওয়ে</h3>
                    <p style="color: #cbd5e0; font-size: 13px; line-height: 1.5; margin: 0 0 15px 0; font-family: 'Hind Siliguri', sans-serif;">নতুন প্রযুক্তি টিউটোরিয়াল বা উবুন্টু প্রক্সি বাগ নিয়ে প্রশ্ন করে ফ্রিতে রিওয়ার্ড পয়েন্ট ইনকাম ও সরাসরি বিকাশ/নগদে ক্যাশআউট করার প্লাটফর্ম।</p>
                </div>
                <a href="<?php echo esc_url(home_url('/ask-question')); ?>" class="util-action-btn" style="background: #8b5cf6 !important; color: #fff; display: block; text-align: center; font-weight: 850; font-size: 12px; text-transform: uppercase; padding: 12px; border-radius: 8px; text-decoration: none; transition: 0.3s; font-family: 'Hind Siliguri', sans-serif;" onmouseover="this.style.background='#fff'; this.style.color='#000';" onmouseout="this.style.background='#8b5cf6'; this.style.color='#fff';">ফোরামে প্রশ্ন করুন ➔</a>
            </div>

        </div>

    </div>
</div>

<!-- ====================================================
     INTERACTIVE LAB OVERLAY MODALS (HTML + CSS + JAVASCRIPT)
     ==================================================== -->

<!-- 2. QR Code Creator Modal -->
<div id="qrModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(4,7,12,0.9); z-index:1000000; align-items:center; justify-content:center; padding:15px; font-family:-apple-system, sans-serif;">
    <div style="background:#090d16; border:2px solid #a855f7; width:100%; max-width:450px; border-radius:16px; padding:25px; box-shadow:0 0 40px rgba(168, 85, 247, 0.3); position:relative; text-align:left;">
        <button onclick="closeQrModal();" style="position:absolute; top:12px; right:15px; background:none; border:none; color:#ff004c; font-size:24px; cursor:pointer;">&times;</button>
        <h3 style="color:#a855f7; margin-top:0; font-size:18px; font-weight:800; font-family:'Hind Siliguri', sans-serif;"><i class="fa-solid fa-qrcode"></i> নিওন কিউআর কোড মেকার ল্যাব</h3>
        
        <div style="margin-bottom:15px; margin-top:15px;">
            <label style="color:#fff; display:block; font-size:11.5px; margin-bottom:6px; font-weight:700; font-family:'Hind Siliguri', sans-serif;">আপনার ওয়েবসাইট লিংক বা যেকোনো লেখা টাইপ করুন</label>
            <input type="text" id="qrTextIn" value="https://iloveyoubd.com" style="width:100%; padding:10px; background:#04070c; border:1px solid #30363d; border-radius:8px; color:#fff; outline:none;" onfocus="this.style.borderColor='#a855f7'">
        </div>

        <button onclick="makeQrCode();" style="width:100%; padding:11px; background:#a855f7; color:#fff; border:none; border-radius:8px; font-weight:800; cursor:pointer;" id="qrBtn">জেনারেল কিউআর কোড ⚡</button>
        
        <div id="qrResultArea" style="display:none; text-align:center; margin-top:20px; border-top:1px solid rgba(255,255,255,0.06); padding-top:15px;">
            <img id="qrImgOut" src="" alt="QR Code" style="background:#fff; padding:10px; border-radius:8px; width:150px; height:150px; display:inline-block; border: 3px solid #a855f7;">
            <p style="color:#a855f7; font-size:11.5px; margin-top:8px; font-weight:600; font-family:'Hind Siliguri', sans-serif;">ডাউনলোড করতে কিউআর ছবির ওপর লং-প্রেস করুন অথবা রাইট ক্লিক করে সেভ করুন।</p>
        </div>
    </div>
</div>

<!-- 3. Webmaster SEO Metatag Generator Modal -->
<div id="seoSuitModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(4,7,12,0.9); z-index:1000000; align-items:center; justify-content:center; padding:15px; font-family:-apple-system, sans-serif;">
    <div style="background:#090d16; border:2px solid #f43f5e; width:100%; max-width:600px; border-radius:16px; padding:25px; box-shadow:0 0 40px rgba(244, 63, 94, 0.3); position:relative; text-align:left;">
        <button onclick="closeSeoSuitModal();" style="position:absolute; top:12px; right:15px; background:none; border:none; color:#ff004c; font-size:24px; cursor:pointer;">&times;</button>
        <h3 style="color:#f43f5e; margin-top:0; font-size:17px; font-weight:800; font-family:'Hind Siliguri', sans-serif;"><i class="fa-solid fa-code"></i> সার্চ ইঞ্জিন মেটাডাটা ও সিএসএস গ্লো ফ্যাক্টরি</h3>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:15px;">
            <div>
                <label style="color:#fff; display:block; font-size:11px; margin-bottom:4px; font-weight:700;">অ্যাপ বা সাইটের শিরোনাম (Title)</label>
                <input type="text" id="seoTitle" value="bKash APK" style="width:100%; padding:8px; background:#04070c; border:1px solid #30363d; border-radius:6px; color:#fff; font-size:12.5px;">
            </div>
            <div>
                <label style="color:#fff; display:block; font-size:11px; margin-bottom:4px; font-weight:700;">প্যাকেজ আইডি বা লিঙ্ক (Slug)</label>
                <input type="text" id="seoSlug" value="com.bKash.customerapp" style="width:100%; padding:8px; background:#04070c; border:1px solid #30363d; border-radius:6px; color:#fff; font-size:12.5px;">
            </div>
        </div>
        <div style="margin-top:10px; margin-bottom:15px;">
            <label style="color:#fff; display:block; font-size:11px; margin-bottom:4px; font-weight:700;">ধামাকা বিবরণ (Description)</label>
            <input type="text" id="seoDesc" value="নিরাপদে ও দ্রুত ডাউনলোড করুন বিকাশের অফিসিয়াল এপিকে সবচেয়ে সুরক্ষিত সার্ভার থেকে।" style="width:100%; padding:8px; background:#04070c; border:1px solid #30363d; border-radius:6px; color:#fff; font-size:12.5px;">
        </div>

        <button onclick="generateSeoCode();" style="width:100%; padding:10px; background:#f43f5e; color:#fff; border:none; border-radius:8px; font-weight:800; cursor:pointer;">মেটা কোড ও গ্লো স্ক্রিপ্ট তৈরি করুন ⚡</button>
        
        <div id="seoResultArea" style="display:none; margin-top:15px; border-top:1px solid rgba(255,255,255,0.06); padding-top:12px;">
            <label style="color:#00ff41; display:block; font-size:11px; margin-bottom:4px; font-weight:700; font-family:'JetBrains Mono', monospace;">📋 GOOGLE CRITICAL HEAD METATAGS:</label>
            <textarea id="seoOutMeta" readonly rows="5" style="width:100%; background:#04070c; border:1px solid rgba(244,63,94,0.3); border-radius:6px; color:#00ff41; padding:8px; font-family:monospace; font-size:10.5px; outline:none; resize:none;" onclick="this.select();"></textarea>
            
            <button onclick="navigator.clipboard.writeText(document.getElementById('seoOutMeta').value); alert('মেটা ট্যাগ ক্লিপবোর্ডে কপি হয়েছে!');" style="margin-top:10px; width:100%; padding:8px; background:rgba(0,255,65,0.12); color:#00ff41; border:1px solid #00ff41; border-radius:6px; font-weight:700; cursor:pointer;">কপি কোড প্যাচ 📋</button>
        </div>
    </div>
</div>

<!-- 4. Retro Music Synthesizer Modal -->
<div id="audioSynthModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(4,7,12,0.9); z-index:1000000; align-items:center; justify-content:center; padding:15px; font-family:-apple-system, sans-serif;">
    <div style="background:#090d16; border:2px solid #22c55e; width:100%; max-width:440px; border-radius:16px; padding:25px; box-shadow:0 0 40px rgba(34, 197, 94, 0.3); position:relative; text-align:center;">
        <button onclick="closeAudioSynthModal();" style="position:absolute; top:12px; right:15px; background:none; border:none; color:#ff004c; font-size:24px; cursor:pointer;">&times;</button>
        <h3 style="color:#22c55e; margin-top:0; font-size:18px; font-weight:800; font-family:'Hind Siliguri', sans-serif;"><i class="fa-solid fa-guitar"></i> নিওন অডিও সিন্থেসাইজার ২০৪০</h3>
        <p style="color:#8b949e; font-size:11.5px; margin-bottom:15px; font-family:'Hind Siliguri', sans-serif;">নিচের নিওন কিগুলোতে টাচ করে ব্রাউজার থেকে সরাসরি হাই ফ্রিকোয়েন্সি সাইবার টিউন বাজান।</p>
        
        <div style="display:flex; justify-content:center; gap:8px; margin:20px 0;">
            <button onclick="playSynthFrequency(261.63);" style="flex:1; height:60px; background:#04070c; border:1.5px solid #22c55e; border-radius:8px; color:#22c55e; font-weight:900; font-size:13px; cursor:pointer; font-family:monospace;" onmousedown="this.style.background='#22c55e'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#22c55e';" onmouseleave="this.style.background='#04070c'; this.style.color='#22c55e';">C4</button>
            <button onclick="playSynthFrequency(293.66);" style="flex:1; height:60px; background:#04070c; border:1.5px solid #00f0ff; border-radius:8px; color:#00f0ff; font-weight:900; font-size:13px; cursor:pointer; font-family:monospace;" onmousedown="this.style.background='#00f0ff'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#00f0ff';" onmouseleave="this.style.background='#04070c'; this.style.color='#00f0ff';">D4</button>
            <button onclick="playSynthFrequency(329.63);" style="flex:1; height:60px; background:#04070c; border:1.5px solid #ec4899; border-radius:8px; color:#ec4899; font-weight:900; font-size:13px; cursor:pointer; font-family:monospace;" onmousedown="this.style.background='#ec4899'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#ec4899';" onmouseleave="this.style.background='#04070c'; this.style.color='#ec4899';">E4</button>
            <button onclick="playSynthFrequency(349.23);" style="flex:1; height:60px; background:#04070c; border:1.5px solid #fbbf24; border-radius:8px; color:#fbbf24; font-weight:900; font-size:13px; cursor:pointer; font-family:monospace;" onmousedown="this.style.background='#fbbf24'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#fbbf24';" onmouseleave="this.style.background='#04070c'; this.style.color='#fbbf24';">F4</button>
            <button onclick="playSynthFrequency(392.00);" style="flex:1; height:60px; background:#04070c; border:1.5px solid #a855f7; border-radius:8px; color:#a855f7; font-weight:900; font-size:13px; cursor:pointer; font-family:monospace;" onmousedown="this.style.background='#a855f7'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#a855f7';" onmouseleave="this.style.background='#04070c'; this.style.color='#a855f7';">G4</button>
        </div>
        <p style="color:#e2e8f0; font-size:11px; font-family:'JetBrains Mono', monospace;">WEB AUDIO API SYNCH PORT ACTIVE (PURE SINE WAVE)</p>
    </div>
</div>

<!-- 5. Cyber Cat Virtual Pet Modal -->
<div id="cyberCatModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(4,7,12,0.9); z-index:1000000; align-items:center; justify-content:center; padding:15px; font-family:-apple-system, sans-serif;">
    <div style="background:#090d16; border:2px solid #ec4899; width:100%; max-width:400px; border-radius:16px; padding:25px; box-shadow:0 0 40px rgba(236, 72, 153, 0.3); position:relative; text-align:center;">
        <button onclick="closeCyberCatModal();" style="position:absolute; top:12px; right:15px; background:none; border:none; color:#ff004c; font-size:24px; cursor:pointer;">&times;</button>
        <h3 style="color:#ec4899; margin-top:0; font-size:18px; font-weight:800; font-family:'Hind Siliguri', sans-serif;"><i class="fa-solid fa-cat"></i> সাইবার টকিং ক্যাট ২০৪০</h3>
        
        <div style="font-size:48px; margin:20px 0; animation: bounce_cat 1.5s infinite;" id="catVisual">🐈</div>
        
        <div id="catBubble" style="background:#04070c; border:1px solid #ec4899; padding:10px; border-radius:8px; color:#fff; font-size:13px; margin-bottom:15px; min-height:45px; display:flex; align-items:center; justify-content:center; font-family:'Hind Siliguri', sans-serif;">মিয়াও! আমি আপনার সাইবার ক্যাট। আমাকে আদর করুন বা খাওয়ান।</div>
        
        <div style="display:flex; gap:10px;">
            <button onclick="petCyberCat();" style="flex:1; padding:10px; background:#ec4899; color:#fff; border:none; border-radius:8px; font-weight:800; cursor:pointer;">আদর করুন 👋</button>
            <button onclick="feedCyberCat();" style="flex:1; padding:10px; background:#00f0ff; color:#000; border:none; border-radius:8px; font-weight:800; cursor:pointer;">খাদ্য দিন 🐟</button>
        </div>
    </div>
</div>

<script>
// QR Code functions
function openQrModal() {
    document.getElementById('qrModal').style.display = 'flex';
}
function closeQrModal() {
    document.getElementById('qrModal').style.display = 'none';
}
function makeQrCode() {
    const text = document.getElementById('qrTextIn').value.trim();
    if (!text) {
        alert("অনুগ্রহ করে কিছু লিখুন!");
        return;
    }
    document.getElementById('qrBtn').innerText = 'তৈরি হচ্ছে...';
    const cleanTxt = encodeURIComponent(text);
    const api = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${cleanTxt}`;
    
    setTimeout(() => {
        document.getElementById('qrImgOut').src = api;
        document.getElementById('qrResultArea').style.display = 'block';
        document.getElementById('qrBtn').innerText = 'জেনারেল কিউআর কোড ⚡';
    }, 400);
}

// SEO Factory
function openSeoSuitModal() {
    document.getElementById('seoSuitModal').style.display = 'flex';
}
function closeSeoSuitModal() {
    document.getElementById('seoSuitModal').style.display = 'none';
}
function generateSeoCode() {
    const t = document.getElementById('seoTitle').value.trim();
    const s = document.getElementById('seoSlug').value.trim();
    const d = document.getElementById('seoDesc').value.trim();
    
    const metatags = `<!-- Google Index Tags for ${t} by iloveyoubd.com -->
<title>${t} APK Download Free for Android - iloveyoubd.com</title>
<meta name="description" content="নিরাপদে ডাউনলোড করুন ${t} সরাসরি গুগল প্লে স্টোর থেকে। ${d.substring(0, 150)}...">
<meta name="keywords" content="${t} apk, ${t} free download, ${s}, download ${t} play store, iloveyoubd">
<meta property="og:title" content="${t} APK Free Download - iloveyoubd">
<meta property="og:image" content="https://iloveyoubd.com/fav.png">
<meta property="og:url" content="https://iloveyoubd.com/tools-lab">`;
    
    document.getElementById('seoOutMeta').value = metatags;
    document.getElementById('seoResultArea').style.display = 'block';
}

// Audio Synth (Sine wave Web Audio API)
let audioCtx = null;
function openAudioSynthModal() {
    document.getElementById('audioSynthModal').style.display = 'flex';
    if (!audioCtx) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
}
function closeAudioSynthModal() {
    document.getElementById('audioSynthModal').style.display = 'none';
}
function playSynthFrequency(freq) {
    if (!audioCtx) return;
    try {
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.frequency.value = freq;
        osc.type = 'sine';
        
        gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
        
        osc.start();
        osc.stop(audioCtx.currentTime + 0.3);
    } catch(e) {}
}

// Cyber Cat functions
function openCyberCatModal() {
    document.getElementById('cyberCatModal').style.display = 'flex';
}
function closeCyberCatModal() {
    document.getElementById('cyberCatModal').style.display = 'none';
}
function petCyberCat() {
    const bubble = document.getElementById('catBubble');
    bubble.innerText = 'পুরররর! আপনার উষ্ণ স্পর্শে আমার ন্যানো চিপসেট হ্যাপি হয়েছে! 💖';
    document.getElementById('catVisual').innerText = '😻';
    setTimeout(() => {
        document.getElementById('catVisual').innerText = '🐈';
    }, 1200);
}
function feedCyberCat() {
    const bubble = document.getElementById('catBubble');
    bubble.innerText = 'ক্রাঞ্চ ক্রাঞ্চ! এআই ফিশ ক্র্যাকার অনেক সুস্বাদু ছিল! চার্জ ১০০%! 🔋⚡';
    document.getElementById('catVisual').innerText = '😸';
    setTimeout(() => {
        document.getElementById('catVisual').innerText = '🐈';
    }, 1200);
}
</script>

<style>
.cyber-page-wrapper {
    padding-top: 100px !important; /* Perfect offset below fixed cyber header on mobile */
}
@media screen and (min-width: 1024px) {
    .cyber-page-wrapper {
        padding-top: 110px !important; /* Elegant offset on desktop */
    }
}
/* Theme utilities */
.rgb-text-lighting {
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
}
.tool-deck-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.tool-deck-card:hover {
    transform: translateY(-5px);
}
@keyframes bounce_cat {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-8px) scale(1.05); }
}
@keyframes rgb_flow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>

<?php
get_footer();
?>
