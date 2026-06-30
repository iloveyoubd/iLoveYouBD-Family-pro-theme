<?php
/**
 * ILYBD Neon v2 Pro - Developer Tools Division (10 Premium Utilities)
 * High-performance browser-side compilation engines, minifiers, and translators.
 */

if (!defined('ABSPATH')) exit;

// 1. Base64 Encoder / Decoder
function ilybd_render_tool_base64_encoder_decoder() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">INPUT STRING / ডাটা টেক্সট</label>
        <textarea id="b64-raw" class="cyan-glow-input" style="height:80px; margin-bottom:15px;" placeholder="আপনার কাঙ্ক্ষিত লেখা বা কোড দিন..."></textarea>

        <div style="display:flex; gap:12px; margin-bottom:20px;">
            <button onclick="b64Encode()" class="cyber-action-btn" style="flex:1;">ENCODE TO BASE64 ➔</button>
            <button onclick="b64Decode()" class="cyber-action-btn" style="flex:1; background:#10b981;">DECODE BASE64 ➔</button>
        </div>

        <div id="b64-dev-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">OUTPUT RESULTS</label>
            <textarea id="b64-result" class="cyan-glow-input" style="height:100px; font-family:monospace;" readonly></textarea>
            <button onclick="navigator.clipboard.writeText(document.getElementById('b64-result').value); alert('📋 কপি করা হয়েছে!');" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY OUTPUT</button>
        </div>
    </div>
    <script>
        function b64Encode() {
            var raw = document.getElementById('b64-raw').value;
            if(!raw) { alert('লেখা দিন!'); return; }
            try {
                var enc = btoa(unescape(encodeURIComponent(raw)));
                document.getElementById('b64-result').value = enc;
                document.getElementById('b64-dev-output-con').style.display = 'block';
                if(typeof incrementToolUsage === 'function') incrementToolUsage('base64-encoder-decoder');
            } catch(e) { alert('ত্রুটি: ' + e.message); }
        }
        function b64Decode() {
            var b64 = document.getElementById('b64-raw').value.trim();
            if(!b64) { alert('বেস-৬৪ কন্টেন্ট দিন!'); return; }
            try {
                var dec = decodeURIComponent(escape(atob(b64)));
                document.getElementById('b64-result').value = dec;
                document.getElementById('b64-dev-output-con').style.display = 'block';
                if(typeof incrementToolUsage === 'function') incrementToolUsage('base64-encoder-decoder');
            } catch(e) { alert('ত্রুটি: এটি সঠিক বেস-৬৪ ডাটা নয়!'); }
        }
    </script>
    <?php
}

// 2. JSON Formatter & Validator
function ilybd_render_tool_json_formatter_validator() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">PASTE RAW JSON STRING</label>
        <textarea id="json-raw-in" class="cyan-glow-input" style="height:120px; font-family:monospace; font-size:12px; margin-bottom:15px;" placeholder='{"name":"iLoveYouBD","status":"active"}'></textarea>

        <div style="display:flex; gap:12px; margin-bottom:20px;">
            <button onclick="formatJSONCode(2)" class="cyber-action-btn" style="flex:1;">BEAUTIFY JSON (2 SPACES) ➔</button>
            <button onclick="validateJSONOnly()" class="cyber-action-btn" style="flex:1; background:#ff007c;">VALIDATE JSON ➔</button>
        </div>

        <div id="json-dev-output-con" style="display:none;">
            <label class="bento-label" id="json-output-lbl" style="color:#00ff41;">BEAUTIFIED RESULTS</label>
            <textarea id="json-result" class="cyan-glow-input" style="height:180px; font-family:monospace; font-size:12px; color:#00ff41; line-height:1.4;" readonly></textarea>
            <button onclick="navigator.clipboard.writeText(document.getElementById('json-result').value); alert('📋 কপিড!');" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY CODE</button>
        </div>
    </div>
    <script>
        function formatJSONCode(spaces) {
            var raw = document.getElementById('json-raw-in').value.trim();
            if(!raw) { alert('JSON লিখুন!'); return; }
            try {
                var parsed = JSON.parse(raw);
                var formatted = JSON.stringify(parsed, null, spaces);
                document.getElementById('json-result').value = formatted;
                document.getElementById('json-output-lbl').textContent = "BEAUTIFIED JSON RESULTS";
                document.getElementById('json-output-lbl').style.color = "#00ff41";
                document.getElementById('json-result').style.color = "#00ff41";
                document.getElementById('json-dev-output-con').style.display = 'block';
                if(typeof incrementToolUsage === 'function') incrementToolUsage('json-formatter-validator');
            } catch(e) {
                alert('❌ ইনব্যালিড JSON ডাটা! ত্রুটি: ' + e.message);
            }
        }
        function validateJSONOnly() {
            var raw = document.getElementById('json-raw-in').value.trim();
            if(!raw) { alert('JSON লিখুন!'); return; }
            try {
                JSON.parse(raw);
                document.getElementById('json-result').value = "✅ Success! Selected JSON string matches absolute standards schema specifications.";
                document.getElementById('json-output-lbl').textContent = "VALIDATION STATUS";
                document.getElementById('json-output-lbl').style.color = "#10b981";
                document.getElementById('json-result').style.color = "#10b981";
                document.getElementById('json-dev-output-con').style.display = 'block';
                if(typeof incrementToolUsage === 'function') incrementToolUsage('json-formatter-validator');
            } catch(e) {
                document.getElementById('json-result').value = "❌ Error! Invalid json syntax: " + e.message;
                document.getElementById('json-output-lbl').textContent = "VALIDATION STATUS";
                document.getElementById('json-output-lbl').style.color = "#ff4d4d";
                document.getElementById('json-result').style.color = "#ff4d4d";
                document.getElementById('json-dev-output-con').style.display = 'block';
            }
        }
    </script>
    <?php
}

// 3. HTML Entities Coder
function ilybd_render_tool_html_entities_coder() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">INPUT STRING OR CODE</label>
        <textarea id="html-ent-raw" class="cyan-glow-input" style="height:110px; margin-bottom:15px;" placeholder="<div class='cyber'>HTML Element</div>"></textarea>

        <div style="display:flex; gap:12px; margin-bottom:20px;">
            <button onclick="encodeHTMLEntities()" class="cyber-action-btn" style="flex:1;">ENCODE SYMBOLS ➔</button>
            <button onclick="decodeHTMLEntities()" class="cyber-action-btn" style="flex:1; background:#10b981;">DECODE ENTITIES ➔</button>
        </div>

        <div id="html-ent-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">PROCESSED RESULTS</label>
            <textarea id="html-ent-result" class="cyan-glow-input" style="height:120px; font-family:monospace;" readonly></textarea>
        </div>
    </div>
    <script>
        function encodeHTMLEntities() {
            var raw = document.getElementById('html-ent-raw').value;
            if(!raw) { alert('টুলস ডাটা দিন!'); return; }
            var esc = raw.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
            document.getElementById('html-ent-result').value = esc;
            document.getElementById('html-ent-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('html-entities-coder');
        }
        function decodeHTMLEntities() {
            var raw = document.getElementById('html-ent-raw').value;
            if(!raw) { alert('টুলস ডাটা দিন!'); return; }
            var doc = new DOMParser().parseFromString(raw, "text/html");
            document.getElementById('html-ent-result').value = doc.documentElement.textContent;
            document.getElementById('html-ent-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('html-entities-coder');
        }
    </script>
    <?php
}

// 4. URL Encoder / Decoder
function ilybd_render_tool_url_encoder_decoder() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">INPUT STRING / ইউআরএল লিংক দিন</label>
        <textarea id="url-raw-in" class="cyan-glow-input" style="height:90px; margin-bottom:15px;" placeholder="https://iloveyoubd.com/tools/category-slug/"></textarea>

        <div style="display:flex; gap:12px; margin-bottom:20px;">
            <button onclick="encodeUrlNow()" class="cyber-action-btn" style="flex:1;">URL ENCODE ➔</button>
            <button onclick="decodeUrlNow()" class="cyber-action-btn" style="flex:1; background:#10b981;">URL DECODE ➔</button>
        </div>

        <div id="url-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">CONVERTED LINK</label>
            <textarea id="url-result" class="cyan-glow-input" style="height:90px;" readonly></textarea>
        </div>
    </div>
    <script>
        function encodeUrlNow() {
            var raw = document.getElementById('url-raw-in').value;
            if(!raw) { alert('লিংক লিখুন!'); return; }
            document.getElementById('url-result').value = encodeURIComponent(raw);
            document.getElementById('url-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('url-encoder-decoder');
        }
        function decodeUrlNow() {
            var raw = document.getElementById('url-raw-in').value;
            if(!raw) { alert('লিংক লিখুন!'); return; }
            try {
                document.getElementById('url-result').value = decodeURIComponent(raw);
                document.getElementById('url-output-con').style.display = 'block';
                if(typeof incrementToolUsage === 'function') incrementToolUsage('url-encoder-decoder');
            } catch(e) { alert('ভুল লিংক বা ডাটা!'); }
        }
    </script>
    <?php
}

// 5. CSS Minifier & Beautifier
function ilybd_render_tool_css_minifier_beautifier() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">PASTE STYLESHEET CODE / সিএসএস কোড দিন</label>
        <textarea id="css-raw-codes" class="cyan-glow-input" style="height:120px; font-family:monospace; font-size:12px; margin-bottom:15px;" placeholder="body { background-color: #070b13; margin: 0px; }"></textarea>

        <button onclick="minifyCSSCode()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">MINIFY CSS OFFLINE ➔</button>

        <div id="css-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">MINIFIED STYLES</label>
            <textarea id="css-result" class="cyan-glow-input" style="height:130px; font-family:monospace; font-size:12px; color:#00ff41;" readonly></textarea>
            <button onclick="navigator.clipboard.writeText(document.getElementById('css-result').value); alert('📋 কপিড!');" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY CODE</button>
        </div>
    </div>
    <script>
        function minifyCSSCode() {
            var raw = document.getElementById('css-raw-codes').value;
            if(!raw) { alert('কোড লিখুন!'); return; }
            
            // Clean tabs, spacing, carriage flows
            var mini = raw.replace(/\/\*[\s\S]*?\*\//g, "") // Comments
                          .replace(/\s+/g, " ")
                          .replace(/;\s*/g, ";")
                          .replace(/,\s*/g, ",")
                          .replace(/{\s*/g, "{")
                          .replace(/}\s*/g, "}")
                          .trim();
                          
            document.getElementById('css-result').value = mini;
            document.getElementById('css-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('css-minifier-beautifier');
        }
    </script>
    <?php
}

// 6. JS Minifier & Beautifier
function ilybd_render_tool_js_minifier_beautifier() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">PASTE JAVASCRIPT CODE / স্ক্রিপ্ট কোড</label>
        <textarea id="js-raw-codes" class="cyan-glow-input" style="height:120px; font-family:monospace; font-size:12px; margin-bottom:15px;" placeholder="function hello() { console.log('Welcome'); }"></textarea>

        <button onclick="minifyJSCode()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">MINIFY JAVASCRIPT ➔</button>

        <div id="js-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">MINIFIED JAVASCRIPT COMPRESSION</label>
            <textarea id="js-result" class="cyan-glow-input" style="height:130px; font-family:monospace; font-size:12px; color:#00ff41;" readonly></textarea>
            <button onclick="navigator.clipboard.writeText(document.getElementById('js-result').value); alert('📋 কপিড!');" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY SCRIPTS</button>
        </div>
    </div>
    <script>
        function minifyJSCode() {
            var raw = document.getElementById('js-raw-codes').value;
            if(!raw) { alert('জাভাস্ক্রিপ্ট কোড দিন!'); return; }
            
            // Fast client-side whitespace and comment remover
            var mini = raw.replace(/\/\*[\s\S]*?\*\//g, "") // comments
                          .replace(/\/\/.*/g, "") // line comments
                          .replace(/\s+/g, " ")
                          .trim();
                          
            document.getElementById('js-result').value = mini;
            document.getElementById('js-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('js-minifier-beautifier');
        }
    </script>
    <?php
}

// 7. SHA-256 Hash Generator (Safe, Modern Replacement)
function ilybd_render_tool_md5_generator() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">INPUT RAW STRING / টেক্সট দিন</label>
        <input type="text" id="md5-raw" class="cyan-glow-input" placeholder="e.g. MyPassword123" style="margin-bottom:15px;">

        <button onclick="generateHash()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GENERATE CRYPTOGRAPHIC SHA-256 HASH ➔</button>

        <div id="md5-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">SHA-256 HASH RESULT</label>
            <input type="text" id="md5-result" class="cyan-glow-input" style="font-family:monospace; color:#00ff41;" readonly>
        </div>
    </div>
    <script>
        async function generateHash() {
            var raw = document.getElementById('md5-raw').value;
            if(!raw) { alert('টেক্সট দিন!'); return; }
            
            const msgBuffer = new TextEncoder().encode(raw);
            const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
            
            document.getElementById('md5-result').value = hashHex;
            document.getElementById('md5-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('md5-generator');
        }
    </script>
    <?php
}

// 8. Unix Timestamp Converter
function ilybd_render_tool_unix_timestamp_converter() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">UNIX EPOC TIMESTAMP (SECONDS)</label>
        <input type="number" id="unix-in" class="cyan-glow-input" placeholder="e.g. 1700000000" style="margin-bottom:15px;">

        <div style="display:flex; gap:12px; margin-bottom:20px;">
            <button onclick="convertUnixToGMT()" class="cyber-action-btn" style="flex:1;">GET ISO DATE-TIME ➔</button>
            <button onclick="getTimestampNow()" class="cyber-action-btn" style="flex:1; background:#10b981;">GET TIMESTAMP NOW ⚡</button>
        </div>

        <div id="unix-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">GMT RECONSTRUCTED STANDARD TIMING</label>
            <input type="text" id="unix-result" class="cyan-glow-input" style="font-family:monospace; color:#00ff41;" readonly>
        </div>
    </div>
    <script>
        function convertUnixToGMT() {
            var val = parseInt(document.getElementById('unix-in').value);
            if(!val) { alert('টাইমস্ট্যাম্প দিন!'); return; }
            var date = new Date(val * 1000);
            document.getElementById('unix-result').value = date.toUTCString();
            document.getElementById('unix-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('unix-timestamp-converter');
        }
        function getTimestampNow() {
            var s = Math.floor(Date.now() / 1000);
            document.getElementById('unix-in').value = s;
            var date = new Date(s * 1000);
            document.getElementById('unix-result').value = date.toUTCString();
            document.getElementById('unix-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('unix-timestamp-converter');
        }
    </script>
    <?php
}

// 9. Regex Tester
function ilybd_render_tool_regex_tester() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">REGEX EXPRESSION STRIP / এক্সপ্রেশন (REGEX)</label>
        <input type="text" id="reg-exp" class="cyan-glow-input" placeholder="e.g. /[a-z]+/gi" style="margin-bottom:10px;">

        <label class="bento-label" style="color:#00f0ff;">TEST STRING LAB / পরীক্ষা করার প্যারাগ্রাম</label>
        <textarea id="reg-str" class="cyan-glow-input" style="height:60px; margin-bottom:15px;" placeholder="Hello 2040 Developers!"></textarea>

        <button onclick="testRegExpMatches()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">VALIDATE PATTERN SCHEMAS ➔</button>

        <div id="reg-output-con" style="display:none; background:rgba(0,0,0,0.3); padding:15px; border-radius:10px; border:1px solid rgba(255,255,255,0.06);">
            <label class="bento-label" style="color:#00ff41;">MATCH COORDS STATUS</label>
            <div id="reg-result" style="font-size:13px; font-family:monospace; line-height:1.6; color:#fff;"></div>
        </div>
    </div>
    <script>
        function testRegExpMatches() {
            var pat = document.getElementById('reg-exp').value.trim();
            var str = document.getElementById('reg-str').value;
            if(!pat || !str) { alert('অনুগ্রহ করে এক্সপ্রেশন এবং সাবজেক্ট ফিল্ড ফিলাপ করুন!'); return; }
            
            try {
                // Strip starting/ending slashes for constructor
                var match = pat.match(/^\/(.*?)\/([gimy]*)$/);
                var rx;
                if (match) {
                    rx = new RegExp(match[1], match[2]);
                } else {
                    rx = new RegExp(pat);
                }
                
                var res = str.match(rx);
                if(res) {
                    document.getElementById('reg-result').textContent = "🎯 Matches Found: " + JSON.stringify(res);
                } else {
                    document.getElementById('reg-result').textContent = "⚠️ Match failure! No matching targets mapped coordinates.";
                }
                document.getElementById('reg-output-con').style.display = 'block';
                if(typeof incrementToolUsage === 'function') incrementToolUsage('regex-tester');
            } catch(e) { alert('❌ ইনভ্যালিড রেগুলার এক্সপ্রেশন! ' + e.message); }
        }
    </script>
    <?php
}

// 10. Binary Translator
function ilybd_render_tool_binary_translator() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">INPUT SOURCE TEXT / ডাটা টেক্সট</label>
        <textarea id="bin-raw" class="cyan-glow-input" style="height:80px; margin-bottom:15px;" placeholder="e.g. CyberX"></textarea>

        <div style="display:flex; gap:12px; margin-bottom:20px;">
            <button onclick="textToBinary()" class="cyber-action-btn" style="flex:1;">TEXT TO BINARY ➔</button>
            <button onclick="binaryToText()" class="cyber-action-btn" style="flex:1; background:#10b981;">BINARY TO TEXT ➔</button>
        </div>

        <div id="bin-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">CONVERTED TRANSLATION RESULT</label>
            <textarea id="bin-result" class="cyan-glow-input" style="height:100px; font-family:monospace;" readonly></textarea>
        </div>
    </div>
    <script>
        function textToBinary() {
            var raw = document.getElementById('bin-raw').value;
            if(!raw) { alert('লেখা দিন!'); return; }
            var out = "";
            for (var i = 0; i < raw.length; i++) {
                var bin = raw[i].charCodeAt(0).toString(2);
                out += ("00000000" + bin).slice(-8) + " ";
            }
            document.getElementById('bin-result').value = out.trim();
            document.getElementById('bin-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('binary-translator');
        }
        function binaryToText() {
            var bins = document.getElementById('bin-raw').value.trim().split(/\s+/);
            if(!bins[0]) { alert('বাইনারি কোড (শব্দ বা জিরো ওয়ান গ্রিড) দিন!'); return; }
            try {
                var out = "";
                bins.forEach(function(b) {
                    out += String.fromCharCode(parseInt(b, 2));
                });
                document.getElementById('bin-result').value = out;
                document.getElementById('bin-output-con').style.display = 'block';
                if(typeof incrementToolUsage === 'function') incrementToolUsage('binary-translator');
            } catch(e) { alert('❌ ভুল বাইনারি বিন্যাস!'); }
        }
    </script>
    <?php
}

// 11. Neon Music Synthesizer 2040
function ilybd_render_tool_neon_music_synthesizer_2040() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif; text-align:center;">
        <p style="color:#8b949e; font-size:13px; margin-bottom:20px;" class="bangla-font-siliguri">নিচের নিওন কিগুলোতে টাচ করে ব্রাউজার থেকে সরাসরি হাই ফ্রিকোয়েন্সি সাইবার টিউন বাজান।</p>
        
        <div style="display:flex; justify-content:center; gap:8px; margin:20px 0; max-width:400px; margin-left:auto; margin-right:auto;">
            <button onclick="playSynthFrequency(261.63);" style="flex:1; height:80px; background:#04070c; border:1.5px solid #22c55e; border-radius:8px; color:#22c55e; font-weight:900; font-size:14px; cursor:pointer; font-family:monospace; transition:0.1s;" onmousedown="this.style.background='#22c55e'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#22c55e';" onmouseleave="this.style.background='#04070c'; this.style.color='#22c55e';">C4</button>
            <button onclick="playSynthFrequency(293.66);" style="flex:1; height:80px; background:#04070c; border:1.5px solid #00f0ff; border-radius:8px; color:#00f0ff; font-weight:900; font-size:14px; cursor:pointer; font-family:monospace; transition:0.1s;" onmousedown="this.style.background='#00f0ff'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#00f0ff';" onmouseleave="this.style.background='#04070c'; this.style.color='#00f0ff';">D4</button>
            <button onclick="playSynthFrequency(329.63);" style="flex:1; height:80px; background:#04070c; border:1.5px solid #ec4899; border-radius:8px; color:#ec4899; font-weight:900; font-size:14px; cursor:pointer; font-family:monospace; transition:0.1s;" onmousedown="this.style.background='#ec4899'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#ec4899';" onmouseleave="this.style.background='#04070c'; this.style.color='#ec4899';">E4</button>
            <button onclick="playSynthFrequency(349.23);" style="flex:1; height:80px; background:#04070c; border:1.5px solid #fbbf24; border-radius:8px; color:#fbbf24; font-weight:900; font-size:14px; cursor:pointer; font-family:monospace; transition:0.1s;" onmousedown="this.style.background='#fbbf24'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#fbbf24';" onmouseleave="this.style.background='#04070c'; this.style.color='#fbbf24';">F4</button>
            <button onclick="playSynthFrequency(392.00);" style="flex:1; height:80px; background:#04070c; border:1.5px solid #a855f7; border-radius:8px; color:#a855f7; font-weight:900; font-size:14px; cursor:pointer; font-family:monospace; transition:0.1s;" onmousedown="this.style.background='#a855f7'; this.style.color='#000';" onmouseup="this.style.background='#04070c'; this.style.color='#a855f7';" onmouseleave="this.style.background='#04070c'; this.style.color='#a855f7';">G4</button>
        </div>
        <p style="color:#e2e8f0; font-size:11px; font-family:'JetBrains Mono', monospace; margin-top:20px; letter-spacing:1px;">WEB AUDIO API SYNCH PORT ACTIVE (PURE SINE WAVE)</p>
    </div>
    <script>
    let audioCtx = null;
    function playSynthFrequency(freq) {
        if (!audioCtx) {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
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
            if (typeof incrementToolUsage === 'function') {
                incrementToolUsage('neon-music-synthesizer-2040');
            }
        } catch(e) {}
    }
    </script>
    <?php
}
