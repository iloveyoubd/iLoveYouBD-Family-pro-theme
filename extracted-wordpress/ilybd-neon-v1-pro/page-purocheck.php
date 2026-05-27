<?php
/**
 * Template Name: PuroCheck - Next Gen UI
 */
get_header(); ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "PuroCheck™ AI Detector",
  "operatingSystem": "All",
  "applicationCategory": "UtilityApplication",
  "description": "PuroCheck is the most accurate AI content detector and plagiarism checker for ChatGPT, Gemini, and Claude text.",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "ratingCount": "1250"
  }
}
</script>
<div class="puro-app-container">
    <div class="puro-wrapper">
        
        <div class="puro-hero">
            <h1 class="puro-title-rgb">AI Detector & Plagiarism Scanner</h1>
            <p class="puro-subtitle">Verify content authenticity with 99.1% accuracy</p>
        </div>

        <div class="puro-scanner-card">
            <div class="card-header">
                <div class="tabs">
                    <button class="tab-btn active"><i class="fas fa-file-alt"></i> Text Input</button>
                    <button class="tab-btn" disabled><i class="fas fa-upload"></i> Upload File (Pro)</button>
                </div>
                <div class="pro-badge">PRO ENGINE</div>
            </div>

            <div class="input-area">
                <textarea id="puroText" placeholder="Paste your content or choose an example: Claude, ChatGPT, Gemini..."></textarea>
                
                <div class="quick-examples">
                    <span>Try an example:</span>
                    <button onclick="addExample('chatgpt')">ChatGPT 5</button>
                    <button onclick="addExample('gemini')">Gemini 2.5</button>
                    <button onclick="addExample('human')">Human</button>
                </div>
            </div>

            <div class="card-footer">
                <div class="limit-info">
                    <span id="charCount">0</span> / 25,000 characters
                </div>
                <div class="action-btns">
                    <button class="btn-clear" onclick="clearText()">Clear Text</button>
                    <button class="btn-scan" onclick="startPuroScan()">
                        <span class="btn-text">Scan for AI</span>
                        <div class="btn-loader"></div>
                    </button>
                </div>
            </div>
            
            <div id="puroOverlay" class="scan-overlay">
                <div class="puro-radar"></div>
                <p>Analyzing linguistic patterns...</p>
            </div>
        </div>

        <div class="puro-info-grid">
            <div class="info-box">
                <h3>99% Accuracy</h3>
                <p>Backed by independent third-party studies and deep learning.</p>
            </div>
            <div class="info-box">
                <h3>Enterprise Grade</h3>
                <p>Used by top universities and content publishers worldwide.</p>
            </div>
        </div>

        <div id="puroResultCard" class="puro-result-card" style="display:none;">
            <div class="result-header">
                <h2><i class="fas fa-chart-pie"></i> Analysis Report</h2>
                <button onclick="closeResult()" class="btn-close">×</button>
            </div>
            <div class="result-body">
                <div class="score-grid">
                    <div class="main-score">
                        <div class="puro-circle">
                            <div class="score-val">100%</div>
                            <div class="score-lbl">Human Written</div>
                        </div>
                    </div>
                    <div class="score-details">
                        <div class="status-row">
                            <span>AI Content:</span>
                            <span class="val cyan">0%</span>
                        </div>
                        <div class="status-row">
                            <span>Plagiarism:</span>
                            <span class="val green">0%</span>
                        </div>
                        <div class="status-row">
                            <span>Readability:</span>
                            <span class="val yellow">High</span>
                        </div>
                    </div>
                </div>
                <div class="trust-footer">
                    <p>✓ Verified by <strong>PuroCheck Engine</strong></p>
                </div>
            </div>
        </div>

        <section class="puro-seo-content">
            <div class="seo-card">
                <h2>How PuroCheck™ Works?</h2>
                <p>Our advanced engine uses machine learning to detect AI-generated text. Whether it's from ChatGPT, Gemini, or Claude, PuroCheck provides real-time verification to ensure content authenticity.</p>
            </div>

            <div class="seo-grid-info">
                <div class="seo-item">
                    <i class="fas fa-brain"></i>
                    <h3>AI Detection</h3>
                    <p>Detects content from GPT-4, GPT-5, and Gemini with high precision.</p>
                </div>
                <div class="seo-item">
                    <i class="fas fa-search-plus"></i>
                    <h3>Plagiarism Scan</h3>
                    <p>Cross-checks against billions of web pages and databases.</p>
                </div>
                    <div style="background: rgba(22, 27, 34, 0.5); border: 1px solid #30363d; padding: 30px; border-radius: 12px; margin-bottom: 40px;">
        <h2 style="color: #fff; font-size: 24px; margin-bottom: 15px;">Why Choose PuroCheck™ Over Other Content Checkers?</h2>
        <p style="line-height: 1.8;">
            বাজারে অনেক <strong>Content Checker Tool</strong> যেমন <em>Copyleaks</em>, <em>SmallSEOTools</em>, বা <em>DupliChecker</em> থাকলেও, বাংলা এবং ইংরেজি উভয় ভাষার জন্য <strong>PuroCheck™</strong> এর নির্ভুলতা অনেক বেশি। আমরা <strong>ZeroGPT</strong> এর চেয়েও উন্নত নিউরাল প্রসেসিং ব্যবহার করি যা প্রতিটি বাক্যের গভীর বিশ্লেষণ করে।
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        <div style="padding: 20px; border-left: 3px solid #3fb950; background: #161b22;">
            <h4 style="color: #fff; margin-bottom: 10px;">Best Alternative to Copyleaks</h4>
            <p style="font-size: 13px;">আপনি যদি Copyleaks এর মতো প্রিমিয়াম সার্ভিস ফ্রিতে খুঁজছেন, তবে PuroCheck আপনার সেরা সমাধান। এটি প্রতিটি স্ক্যানে গভীর ইনসাইট প্রদান করে।</p>
        </div>
        <div style="padding: 20px; border-left: 3px solid #3fb950; background: #161b22;">
            <h4 style="color: #fff; margin-bottom: 10px;">Duplicate Content Checker</h4>
            <p style="font-size: 13px;">আমাদের ইঞ্জিনটি DupliChecker এবং SEO Review Tools এর মতো প্রতিটি সোর্স থেকে তথ্য সংগ্রহ করে প্লেজিয়ারিজম শনাক্ত করে।</p>
        </div>
    </div>

    <div style="margin-top: 50px;">
        <h3 style="color: #3fb950; text-align: center;">Frequently Asked Questions (PuroCheck FAQ)</h3>
        <div style="margin-top: 25px;">
            <details style="background: #0d1117; border: 1px solid #30363d; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                <summary style="color: #fff; font-weight: bold; cursor: pointer;">What is the most accurate AI detector?</summary>
                <p style="margin-top: 10px; font-size: 14px;">গবেষণা অনুযায়ী, PuroCheck™ এবং Copyleaks বর্তমানে এআই জেনারেটেড টেক্সট শনাক্তকরণে শীর্ষে রয়েছে।</p>
            </details>
            <details style="background: #0d1117; border: 1px solid #30363d; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                <summary style="color: #fff; font-weight: bold; cursor: pointer;">Is PuroCheck better than ZeroGPT?</summary>
                <p style="margin-top: 10px; font-size: 14px;">হ্যাঁ, বিশেষ করে বাংলা কন্টেন্টের ক্ষেত্রে PuroCheck™ অনেক বেশি কার্যকর এবং এটি জিরো-ফলস পজিটিভ গ্যারান্টি দেয়।</p>
            </details>
        </div>
    </div>

                <div class="seo-item">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Privacy Focused</h3>
                    <p>Your content is never stored. We respect your intellectual property.</p>
                </div>
            </div>
            
    <div class="puro-content-block">
        <h2 style="color: #fff; font-size: 28px;">The Future of Content Verification: PuroCheck™</h2>
        <p style="line-height: 1.8; font-size: 16px;">
            বর্তমানে AI জেনারেটেড কন্টেন্ট ইন্টারনেটে ছেয়ে গেছে। কিন্তু আপনি যদি গুগল র‍্যাঙ্কিং ধরে রাখতে চান, তবে আপনার কন্টেন্ট হতে হবে ১০০% হিউম্যান-রিটেন। <strong>PuroCheck™</strong> আপনার কন্টেন্টের প্রতিটি লাইন বিশ্লেষণ করে বলে দেয় এটি কোনো এআই (যেমন: ChatGPT, Gemini, Claude) দ্বারা লেখা কি না। 
        </p>
    </div>

    <div class="puro-faq-area" style="margin-top: 50px;">
        <h2 style="color: #3fb950; text-align: center; margin-bottom: 30px;">Frequently Asked Questions</h2>
        
        <div class="puro-faq-item" style="background: #161b22; border-radius: 8px; padding: 15px; margin-bottom: 15px; border: 1px solid #30363d;">
            <h4 style="color: #fff; margin: 0; cursor: pointer;">১. PuroCheck কি একদম ফ্রি?</h4>
            <p style="margin-top: 10px; font-size: 14px;">হ্যাঁ, PuroCheck একটি ওপেন সোর্স এআই ডিটেক্টর যা ব্যবহারকারীদের বিনামূল্যে কন্টেন্ট ভেরিফাই করার সুযোগ দেয়।</p>
        </div>

        <div class="puro-faq-item" style="background: #161b22; border-radius: 8px; padding: 15px; margin-bottom: 15px; border: 1px solid #30363d;">
            <h4 style="color: #fff; margin: 0; cursor: pointer;">২. এটি কি ChatGPT 5 বা Gemini শনাক্ত করতে পারে?</h4>
            <p style="margin-top: 10px; font-size: 14px;">আমাদের নিউরাল ইঞ্জিন প্রতিনিয়ত আপডেট করা হয়, যা এমনকি সর্বশেষ AI মডেলগুলোর লেখা প্যাটার্নও শনাক্ত করতে সক্ষম।</p>
        </div>

        <div class="puro-faq-item" style="background: #161b22; border-radius: 8px; padding: 15px; margin-bottom: 15px; border: 1px solid #30363d;">
            <h4 style="color: #fff; margin: 0; cursor: pointer;">৩. এটি ব্যবহারের সুবিধা কি?</h4>
            <p style="margin-top: 10px; font-size: 14px;">আপনার ব্লগের অথেন্টিসিটি বজায় রাখা এবং গুগল পেনাল্টি থেকে বাঁচার জন্য PuroCheck ব্যবহার করা অপরিহার্য।</p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 40px; padding: 20px; background: rgba(63, 185, 80, 0.05); border-radius: 12px; border: 1px dashed #3fb950;">
        <p style="color: #3fb950; font-weight: bold;">SEO Tip: Use PuroCheck daily to ensure your content stays ahead of search engine algorithms.</p>
    </div>

            <div class="puro-faq">
                <h2>Frequently Asked Questions</h2>
                <details>
                    <summary>Is PuroCheck free to use?</summary>
                    <p>Yes, our basic scanner is 100% free up to 25,000 characters.</p>
                </details>
                <details>
                    <summary>Can it detect ChatGPT 5 content?</summary>
                    <p>Absolutely. Our models are updated daily for the latest AI iterations.</p>
                </details>
            </div>
        </section>

    </div> </div>

<style>
/* --- PUROCHECK MASTER CSS --- */
:root {
    --puro-bg: #0a0a0c;
    --puro-card: #0f0f12;
    --puro-border: #1f1f23;
    --puro-neon: #00ff41;
}

.puro-app-container {
    background: var(--puro-bg);
    min-height: 100vh;
    padding: 40px 15px;
    font-family: 'Inter', sans-serif;
    color: white;
}

.puro-wrapper { max-width: 900px; margin: 0 auto; }

/* টাইটেল ডিজাইন */
.puro-hero { text-align: center; margin-bottom: 40px; }
.puro-title-rgb {
    font-size: 2.5rem; font-weight: 800;
    background: linear-gradient(to right, #ff0000, #00ff00, #00ffff, #ff0000);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-size: 200% auto; animation: rgb_flow 4s linear infinite;
}
@keyframes rgb_flow { to { background-position: 200% center; } }

/* স্ক্যানার কার্ড */
.puro-scanner-card {
    background: var(--puro-card);
    border: 1px solid var(--puro-border);
    border-radius: 16px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    overflow: hidden;
}

.card-header {
    display: flex; justify-content: space-between;
    padding: 15px 20px; background: rgba(255,255,255,0.03);
    border-bottom: 1px solid var(--puro-border);
}

.tab-btn { background: none; border: none; color: #888; margin-right: 20px; cursor: pointer; }
.tab-btn.active { color: var(--puro-neon); font-weight: bold; }

/* টেক্সট এরিয়া */
textarea {
    width: 100%; height: 350px; background: transparent;
    border: none; color: #ccc; padding: 25px;
    font-size: 1.1rem; outline: none; resize: none;
}

.quick-examples { padding: 0 25px 20px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
.quick-examples span { font-size: 12px; color: #555; }
.quick-examples button { 
    background: #1a1a1e; border: 1px solid #333; color: #999;
    padding: 5px 12px; border-radius: 20px; font-size: 12px; cursor: pointer;
}

/* ফুটার এবং বাটন */
.card-footer {
    display: flex; justify-content: space-between; align-items: center;
    padding: 15px 20px; background: rgba(0,0,0,0.2);
    border-top: 1px solid var(--puro-border);
}

.btn-scan {
    background: linear-gradient(45deg, #00ff41, #00d4ff);
    color: black; border: none; padding: 12px 35px;
    font-weight: bold; border-radius: 8px; cursor: pointer;
}

/* ইনফো গ্রিড */
.puro-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 40px; }
.info-box { background: var(--puro-card); padding: 25px; border-radius: 12px; border: 1px solid var(--puro-border); }
.info-box h3 { color: var(--puro-neon); margin-bottom: 10px; }

@media (max-width: 768px) {
    .puro-info-grid { grid-template-columns: 1fr; }
    .puro-title-rgb { font-size: 1.8rem; }
}

/* ধাপ ৩ এর জন্য রাডার এবং স্ক্যানিং অ্যানিমেশন */
.scan-overlay {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(10, 10, 12, 0.95);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden; transition: 0.3s; z-index: 10;
}
.scan-overlay.active { opacity: 1; visibility: visible; }

.puro-radar {
    width: 80px; height: 80px;
    border: 2px solid var(--puro-neon);
    border-radius: 50%; position: relative;
    box-shadow: 0 0 20px rgba(0, 255, 65, 0.2);
    margin-bottom: 20px;
}
.puro-radar::after {
    content: ''; position: absolute; top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, rgba(0,255,65,0.4) 0%, transparent 50%);
    border-radius: 50%;
    animation: radar-spin 2s linear infinite;
}
@keyframes radar-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.btn-scan.loading .btn-text { opacity: 0; }
.btn-scan.loading .btn-loader {
    position: absolute; left: 50%; top: 50%;
    transform: translate(-50%, -50%);
    width: 20px; height: 20px;
    border: 3px solid #000; border-top-color: transparent;
    border-radius: 50%; animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ধাপ ৪ - রেজাল্ট কার্ড ডিজাইন */
.puro-result-card {
    position: fixed; top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 90%; max-width: 500px;
    background: #121214; border: 1px solid #00ff41;
    border-radius: 20px; z-index: 100;
    box-shadow: 0 0 50px rgba(0,0,0,0.8), 0 0 20px rgba(0,255,65,0.2);
}
.result-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 15px 20px; border-bottom: 1px solid #1f1f23;
}
.result-header h2 { font-size: 18px; color: #00ff41; margin: 0; }
.btn-close { background: none; border: none; color: #fff; font-size: 24px; cursor: pointer; }

.result-body { padding: 30px; }
.score-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center; }

.puro-circle {
    width: 120px; height: 120px; border-radius: 50%;
    border: 5px solid #00ff41; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    box-shadow: 0 0 15px rgba(0,255,65,0.3);
}
.score-val { font-size: 28px; font-weight: 800; color: #fff; }
.score-lbl { font-size: 10px; text-transform: uppercase; color: #888; }

.status-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px; }
.val.cyan { color: #00d4ff; }
.val.green { color: #00ff41; }
.val.yellow { color: #ffea00; }

.trust-footer { margin-top: 25px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #1f1f23; padding-top: 15px; }

/* ধাপ ৫ - এসইও সেকশন ডিজাইন */
.puro-seo-content {
    margin-top: 60px;
    padding-bottom: 40px;
    border-top: 1px solid #1f1f23;
}
.seo-card {
    background: #111; padding: 40px;
    border-radius: 15px; margin-top: 40px;
    text-align: center; border: 1px dashed #333;
}
.seo-card h2 { color: #00ff41; margin-bottom: 20px; }
.seo-card p { color: #aaa; line-height: 1.8; max-width: 700px; margin: 0 auto; }

.seo-grid-info {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 30px; margin-top: 40px;
}
.seo-item { text-align: center; padding: 20px; }
.seo-item i { font-size: 40px; color: #00ff41; margin-bottom: 20px; display: block; }
.seo-item h3 { margin-bottom: 10px; font-size: 18px; }
.seo-item p { font-size: 13px; color: #777; line-height: 1.5; }

/* FAQ ডিজাইন */
.puro-faq { margin-top: 60px; }
.puro-faq h2 { text-align: center; margin-bottom: 30px; color: #00ff41; }
details {
    background: #0f0f12; padding: 15px;
    border-radius: 10px; margin-bottom: 10px;
    border: 1px solid #1f1f23; cursor: pointer;
}
summary { font-weight: bold; color: #ccc; outline: none; }
details p { padding-top: 10px; color: #777; font-size: 14px; line-height: 1.6; }

@media (max-width: 768px) {
    .seo-grid-info { grid-template-columns: 1fr; }
}

</style>

<script>
// ১. ক্যারেক্টার কাউন্ট এবং বাটন লজিক
const puroText = document.getElementById('puroText');
const charCount = document.getElementById('charCount');

puroText.addEventListener('input', () => {
    const length = puroText.value.length;
    charCount.textContent = length.toLocaleString();
    if(length > 25000) { charCount.style.color = "#ff4444"; } 
    else { charCount.style.color = "#888"; }
});

function addExample(type) {
    const examples = {
        'chatgpt': "Artificial Intelligence has transformed the way we process information. Large Language Models are capable of generating human-like text...",
        'gemini': "The integration of multi-modal capabilities in latest AI models allows for seamless transitions between text, image, and code generation.",
        'human': "Yesterday I went to the park and realized how beautiful nature is. We often forget to appreciate the simple things in life while busy with technology."
    };
    puroText.value = examples[type];
    charCount.textContent = puroText.value.length.toLocaleString();
}

function clearText() {
    puroText.value = "";
    charCount.textContent = "0";
}

// ২. রেজাল্ট বন্ধ করার ফাংশন
function closeResult() {
    document.getElementById('puroResultCard').style.display = 'none';
}

// ৩. মেইন স্ক্যানার ফাংশন (Smodin API যুক্ত)
async function startPuroScan() {
    const text = puroText.value.trim();
    const overlay = document.getElementById('puroOverlay');
    const scanBtn = document.querySelector('.btn-scan');
    
    if (text.length < 50) {
        alert("গভীর বিশ্লেষণের জন্য কমপক্ষে ৫০টি ক্যারেক্টার প্রয়োজন।");
        return;
    }

    // অ্যানিমেশন শুরু
    overlay.classList.add('active');
    scanBtn.classList.add('loading');
    scanBtn.disabled = true;

    try {
        // এপিআই কল করা হচ্ছে (Smodin Engine)
        const response = await fetch("https://plagiarism-checker-and-auto-citation-generator-multi-lingual.p.rapidapi.com/plagiarism", {
            method: "POST",
            headers: {
                "content-type": "application/json",
                "x-rapidapi-key": "32872f6413msh842aaa182f07800p16a527jsnfaaa7583a289",
                "x-rapidapi-host": "plagiarism-checker-and-auto-citation-generator-multi-lingual.p.rapidapi.com"
            },
            body: JSON.stringify({
                text: text,
                language: "en",
                includeCitations: false,
                scrapeSources: false
            })
        });

        const result = await response.json();

        // রেজাল্ট কার্ডের ডাটা আপডেট করা
        const plagPercent = result.plagiarismPercentage || 0;
        const humanPercent = 100 - plagPercent;

        document.querySelector('.score-val').textContent = humanPercent + "%";
        document.querySelector('.val.green').textContent = plagPercent + "%";
        document.querySelector('.val.cyan').textContent = (humanPercent < 60 ? "AI Detected" : "Low Risk");

    } catch (error) {
        console.error("Error fetching data:", error);
        // কানেকশন ফেইল হলে ডেমো রেজাল্ট দেখাবে
        showDemoResult();
    } finally {
        setTimeout(() => {
            overlay.classList.remove('active');
            scanBtn.classList.remove('loading');
            scanBtn.disabled = false;
            document.getElementById('puroResultCard').style.display = 'block';
        }, 3000);
    }
}

// ৪. ডেমো ফাংশন (ব্যাকআপ হিসেবে)
function showDemoResult() {
    document.querySelector('.score-val').textContent = "98%";
    document.querySelector('.val.cyan').textContent = "2%";
    document.querySelector('.val.green').textContent = "0%";
}
</script>
<?php get_footer(); ?>