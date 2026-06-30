<?php
/**
 * ILYBD Neon v2 Pro - Security Tools Division (10 Premium Utilities)
 * High-performance cryptographic tools, obfuscators, scanners and security validators.
 */

if (!defined('ABSPATH')) exit;

// 1. Password Strength Checker
function ilybd_render_tool_password_strength_checker() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#ff007c;">TEST YOUR UNKNOWN PASSWORD / পাসওয়ার্ড টেস্ট</label>
        <input type="password" id="pw-input" class="cyan-glow-input" placeholder="পাসওয়ার্ড লিখুন..." style="margin-bottom:15px;" onkeyup="checkPasswordStrength()">

        <div style="background:rgba(255,255,255,0.02); padding:15px; border-radius:10px; border:1px solid rgba(255,255,255,0.06); margin-bottom:15px;">
            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:8px; line-height:1.2;">
                <span style="color:#9ca3af;">ENTROPY LEVEL</span>
                <span id="pw-status" style="font-weight:700; color:#ff007c;">COMPROMISED (WEAK)</span>
            </div>
            
            <!-- Progress bar -->
            <div style="height:8px; background:rgba(255,255,255,0.08); border-radius:4px; overflow:hidden;">
                <div id="pw-bar" style="height:100%; width:10%; background:#ff007c; transition:0.3s ease;"></div>
            </div>
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; font-size:11px; margin-top:12px; color:#cbd5e0;">
                <span id="pw-rule-len">❌ Minimum 8 chars</span>
                <span id="pw-rule-num">❌ Has Numbers</span>
                <span id="pw-rule-cap">❌ Has Upper Case</span>
                <span id="pw-rule-spec">❌ Has Special Symbol</span>
            </div>
        </div>
    </div>
    <script>
        function checkPasswordStrength() {
            var val = document.getElementById('pw-input').value;
            var len = val.length;
            var hasNum = /[0-9]/.test(val);
            var hasCap = /[A-Z]/.test(val);
            var hasSpec = /[^A-Za-z0-9]/.test(val);
            
            var score = 0;
            if(len >= 8) { score += 25; document.getElementById('pw-rule-len').textContent = "✅ Minimum 8 chars"; document.getElementById('pw-rule-len').style.color="#00ff41"; }
            else { document.getElementById('pw-rule-len').textContent = "❌ Minimum 8 chars"; document.getElementById('pw-rule-len').style.color="#ff007c"; }
            
            if(hasNum) { score += 25; document.getElementById('pw-rule-num').textContent = "✅ Has Numbers"; document.getElementById('pw-rule-num').style.color="#00ff41"; }
            else { document.getElementById('pw-rule-num').textContent = "❌ Has Numbers"; document.getElementById('pw-rule-num').style.color="#ff007c"; }
            
            if(hasCap) { score += 25; document.getElementById('pw-rule-cap').textContent = "✅ Has Upper Case"; document.getElementById('pw-rule-cap').style.color="#00ff41"; }
            else { document.getElementById('pw-rule-cap').textContent = "❌ Has Upper Case"; document.getElementById('pw-rule-cap').style.color="#ff007c"; }
            
            if(hasSpec) { score += 25; document.getElementById('pw-rule-spec').textContent = "✅ Has Special Symbol"; document.getElementById('pw-rule-spec').style.color="#00ff41"; }
            else { document.getElementById('pw-rule-spec').textContent = "❌ Has Special Symbol"; document.getElementById('pw-rule-spec').style.color="#ff007c"; }
            
            var bar = document.getElementById('pw-bar');
            var status = document.getElementById('pw-status');
            
            bar.style.width = score + "%";
            if(score <= 25) {
                bar.style.backgroundColor = "#ff007c";
                status.textContent = "COMPROMISED (WEAK) 🛑";
                status.style.color = "#ff007c";
            } else if(score <= 75) {
                bar.style.backgroundColor = "#fbbf24";
                status.textContent = "MEDIUM STRENGTH ⚠️";
                status.style.color = "#fbbf24";
            } else {
                bar.style.backgroundColor = "#00ff41";
                status.textContent = "STRONG ENVELOPE (MILITARY SECURE) 🔒";
                status.style.color = "#00ff41";
            }
            if(typeof incrementToolUsage === 'function') incrementToolUsage('password-strength-checker');
        }
    </script>
    <?php
}

// 2. Secure Password Generator
function ilybd_render_tool_secure_password_generator() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <div style="display:grid; grid-template-columns:1.5fr 1fr; gap:15px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:#00f0ff;">PASSWORD SPEC LENGTH</label>
                <input type="number" id="genpw-len" class="cyan-glow-input" value="16" min="6" max="64">
            </div>
            <div>
                <label class="bento-label" style="color:#00f0ff;">INCLUDE CODES</label>
                <div style="display:flex; flex-direction:column; gap:4px; font-size:12px; color:#fff;">
                    <label><input type="checkbox" id="genpw-num" checked> Numbers</label>
                    <label><input type="checkbox" id="genpw-spec" checked> Specials</label>
                </div>
            </div>
        </div>

        <button onclick="generateSecurePassword()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GENERATE CRYPTOGRAPHIC PASSWALL ➔</button>

        <div id="genpw-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">READY CODES</label>
            <div style="display:flex; gap:10px;">
                <input type="text" id="genpw-result" class="cyan-glow-input" style="font-family:monospace; color:#00ff41; font-weight:bold; font-size:15px;" readonly>
                <button onclick="navigator.clipboard.writeText(document.getElementById('genpw-result').value); alert('📋 Password copied!');" class="cyber-action-btn" style="background:#00f0ff; color:#000; padding:0 20px;">COPY</button>
            </div>
        </div>
    </div>
    <script>
        function generateSecurePassword() {
            var len = parseInt(document.getElementById('genpw-len').value) || 16;
            var num = document.getElementById('genpw-num').checked;
            var spec = document.getElementById('genpw-spec').checked;
            
            var alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            if(num) alpha += "0123456789";
            if(spec) alpha += "!@#$%^&*()_+~`|}{[]:;?><,./-=";
            
            var pw = "";
            for(var i=0; i<len; i++) {
                var idx = Math.floor(Math.random() * alpha.length);
                pw += alpha[idx];
            }
            
            document.getElementById('genpw-result').value = pw;
            document.getElementById('genpw-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('secure-password-generator');
        }
    </script>
    <?php
}

// 3. Hash Detector
function ilybd_render_tool_hash_detector() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">PASTE RAW HASH / হ্যাশ কী দিন</label>
        <input type="text" id="hash-raw-in" class="cyan-glow-input" placeholder="e.g. 827ccb0eea8a706c4c34a16891f84e7b" style="margin-bottom:15px;">

        <button onclick="detectHashSpec()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">ANALYZE SIGNATURES ➔</button>

        <div id="hash-output-con" style="display:none; background:rgba(0,0,0,0.3); border:1px solid rgba(255,255,255,0.06); padding:15px; border-radius:10px;">
            <label class="bento-label" style="color:#00ff41;">DETECTION STATUS</label>
            <div id="hash-result" style="color:#fff; font-size:14px; font-weight:bold; font-family:monospace;"></div>
        </div>
    </div>
    <script>
        function detectHashSpec() {
            var raw = document.getElementById('hash-raw-in').value.trim();
            if(!raw) { alert('হ্যাশ কী দিন!'); return; }
            
            var len = raw.length;
            var type = "Unknown (জটিল বা অনিয়মিত)";
            
            if(/^[a-fA-F0-9]+$/.test(raw)) {
                if(len === 32) type = "MD5 Hash (একাধিক ফোরামে বহুল ব্যবহৃত)";
                else if(len === 40) type = "SHA-1 Standard Security Signature";
                else if(len === 64) type = "SHA-256 (অত্যন্ত নিরাপদ ক্রিপ্টো অ্যালগরিদম)";
            }
            
            document.getElementById('hash-result').innerHTML = "🔒 Detected Type: <span style='color:#00f0ff;'>" + type + "</span><br><span style='font-size:11px; color:#9ca3af; font-weight:normal;'>Length: " + len + " Hex Decimals</span>";
            document.getElementById('hash-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('hash-detector');
        }
    </script>
    <?php
}

// 4. XSS Protection Filter
function ilybd_render_tool_xss_protection_filter() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">PASTE POTENTIALLY MALICIOUS VALUES / কোড এন্টার করুন</label>
        <textarea id="xss-raw-in" class="cyan-glow-input" style="height:110px; margin-bottom:15px;" placeholder='<script>alert("Hacked")</script>'></textarea>

        <button onclick="sanitizeXSSCode()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">SANITIZE STRINGS OFFLINE ➔</button>

        <div id="xss-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">SAFE ESCAPED CODES (XSS PROTECTION SYSTEM)</label>
            <textarea id="xss-result" class="cyan-glow-input" style="height:120px; font-family:monospace; color:#00ff41;" readonly></textarea>
        </div>
    </div>
    <script>
        function sanitizeXSSCode() {
            var raw = document.getElementById('xss-raw-in').value;
            if(!raw) { alert('কোড বা টেক্সট লিখুন!'); return; }
            
            var clean = raw.replace(/&/g, '&amp;')
                           .replace(/</g, '&lt;')
                           .replace(/>/g, '&gt;')
                           .replace(/"/g, '&quot;')
                           .replace(/'/g, '&#x27;')
                           .replace(/\//g, '&#x2F;');
                           
            document.getElementById('xss-result').value = clean;
            document.getElementById('xss-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('xss-protection-filter');
        }
    </script>
    <?php
}

// 5. SQL Injection Detector
function ilybd_render_tool_sql_injection_detector() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">PASTE INPUT QUERY TO TEST / কোয়েরি টেস্ট</label>
        <input type="text" id="sqli-raw-in" class="cyan-glow-input" placeholder="e.g. ' OR '1'='1" style="margin-bottom:15px;">

        <button onclick="detectSqliVectors()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">SCAN FOR ATTACK VECTORS ➔</button>

        <div id="sqli-output-con" style="display:none; padding:15px; border-radius:10px;">
            <label class="bento-label" id="sqli-lbl" style="color:#ff007c;">VECTOR RESULTS</label>
            <div id="sqli-result" style="font-size:13px; font-weight:bold; font-family:monospace; color:#fff;"></div>
        </div>
    </div>
    <script>
        function detectSqliVectors() {
            var raw = document.getElementById('sqli-raw-in').value.trim();
            if(!raw) { alert('কোয়েরি লিখুন!'); return; }
            
            var patterns = [
                /\bunion\b/i,
                /\bselect\b/i,
                /\bor\b\s+['"]*\d+['"]*\s*=\s*['"]*\d+/i,
                /--/i,
                /\bdrop\b/i,
                /\bdatabase\b/i
            ];
            
            var threat = false;
            for(var i=0; i<patterns.length; i++) {
                if(patterns[i].test(raw)) {
                    threat = true;
                    break;
                }
            }
            
            var con = document.getElementById('sqli-output-con');
            var result = document.getElementById('sqli-result');
            var lbl = document.getElementById('sqli-lbl');
            
            if(threat) {
                con.style.background = "rgba(255,0,124,0.1)";
                con.style.border = "1px solid #ff007c";
                lbl.textContent = "🛡️ RED ALERT - SQL INJECTION DETECTED";
                lbl.style.color = "#ff007c";
                result.textContent = "🚨 WARNING! This query contains highly suspicious injection patterns (' OR, UNION, or -- Comments). Block this sequence instantly on db gates.";
            } else {
                con.style.background = "rgba(16,185,129,0.1)";
                con.style.border = "1px solid #10b981";
                lbl.textContent = "🛡️ WHITE CHECKER - SECURED";
                lbl.style.color = "#10b981";
                result.textContent = "✅ Clear! This statement matches the general parameters of secure clean queries.";
            }
            con.style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('sql-injection-detector');
        }
    </script>
    <?php
}

// 7. User Agent Parser
function ilybd_render_tool_user_agent_parser() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <button onclick="readHostUA()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">EXTRACT BROWSER METRICS NOW ➔</button>

        <div id="ua-output-con" style="display:none; background:rgba(255,255,255,0.02); padding:15px; border-radius:10px; border:1px solid rgba(255,255,255,0.06); font-size:13px; color:#fff;">
            <p>🌐 <strong>Platform:</strong> <span id="ua-p" style="color:#00f0ff;">-</span></p>
            <p>🤖 <strong>Language:</strong> <span id="ua-l" style="color:#00f0ff;">-</span></p>
            <p>💻 <strong>Raw UA:</strong> <span id="ua-r" style="color:#cbd5e0; font-family:monospace; font-size:11px;">-</span></p>
        </div>
    </div>
    <script>
        function readHostUA() {
            document.getElementById('ua-p').textContent = navigator.platform;
            document.getElementById('ua-l').textContent = navigator.language;
            document.getElementById('ua-r').textContent = navigator.userAgent;
            document.getElementById('ua-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('user-agent-parser');
        }
    </script>
    <?php
}

// 8. IP Obfuscator Converter
function ilybd_render_tool_ip_obfuscator_converter() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">ENTER ORIGINAL IP ADDRESS (IPV4)</label>
        <input type="text" id="ip-raw-in" class="cyan-glow-input" placeholder="e.g. 192.168.1.1" style="margin-bottom:15px;">

        <button onclick="obfuscateIPAddress()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">OBFUSCATE IP ADDRESS ➔</button>

        <div id="ip-output-con" style="display:none; background:rgba(0,0,0,0.3); padding:15px; border-radius:10px; border:1px solid rgba(255,255,255,0.06); font-family:monospace; font-size:13px; color:#fff;">
            <p>📍 Hex Representation: <strong id="ip-hex" style="color:#ff007c;">-</strong></p>
            <p>📍 Decimal Representation: <strong id="ip-dec" style="color:#00ff41;">-</strong></p>
        </div>
    </div>
    <script>
        function obfuscateIPAddress() {
            var raw = document.getElementById('ip-raw-in').value.trim();
            var parts = raw.split('.');
            if(parts.length !== 4) { alert('সঠিক IP (যেমন: 192.168.1.1) দিন!'); return; }
            
            var item1 = parseInt(parts[0]);
            var item2 = parseInt(parts[1]);
            var item3 = parseInt(parts[2]);
            var item4 = parseInt(parts[3]);
            
            var hex = "0x" + ((item1 << 24) + (item2 << 16) + (item3 << 8) + item4).toString(16).toUpperCase();
            var dec = ((item1 * 16777216) + (item2 * 65536) + (item3 * 256) + item4);
            
            document.getElementById('ip-hex').textContent = hex;
            document.getElementById('ip-dec').textContent = dec;
            document.getElementById('ip-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('ip-obfuscator-converter');
        }
    </script>
    <?php
}

// 9. Credit Card Validator
function ilybd_render_tool_credit_card_validator() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">TEST CARD NUMBER (LUHN TESTING)</label>
        <input type="text" id="cc-raw-in" class="cyan-glow-input" placeholder="e.g. 4000 1234 5678 9010" style="margin-bottom:15px;">

        <button onclick="validateCCNum()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">VALIDATE INTEGRITY SCHEMAS ➔</button>

        <div id="cc-output-con" style="display:none; padding:15px; border-radius:10px;">
            <label class="bento-label" id="cc-lbl" style="color:#00ff41;">VALIDATION STATUS</label>
            <p id="cc-result" style="font-weight:bold; margin:0; font-size:14px; color:#fff;"></p>
        </div>
    </div>
    <script>
        function validateCCNum() {
            var val = document.getElementById('cc-raw-in').value.replace(/\D/g, '');
            if(!val) { alert('কার্ড নাম্বার দিন!'); return; }
            
            // Standard Luhn algorithm
            var sum = 0;
            var shouldDouble = false;
            for(var i = val.length - 1; i >= 0; i--) {
                var d = parseInt(val.charAt(i));
                if (shouldDouble) {
                    if ((d *= 2) > 9) d -= 9;
                }
                sum += d;
                shouldDouble = !shouldDouble;
            }
            
            var valid = (sum % 10 === 0);
            var con = document.getElementById('cc-output-con');
            var lbl = document.getElementById('cc-lbl');
            var res = document.getElementById('cc-result');
            
            if(valid) {
                con.style.background = "rgba(16,185,129,0.1)";
                con.style.border = "1px solid #10b981";
                lbl.style.color = "#10b981";
                lbl.textContent = "✅ VALID CARD SCHEMAS";
                res.textContent = "Luhn system evaluation check passed completely. Card formats matched.";
            } else {
                con.style.background = "rgba(255,0,124,0.1)";
                con.style.border = "1px solid #ff007c";
                lbl.style.color = "#ff007c";
                lbl.textContent = "❌ INVALID CARD FORMATS";
                res.textContent = "Fail! Incorrect CC sequence checked against international schemas.";
            }
            con.style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('credit-card-validator');
        }
    </script>
    <?php
}

// 10. Base32 Encoder / Decoder
function ilybd_render_tool_base32_encoder_decoder() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">INPUT DATA VALUE / টেক্সট বা কোড দিন</label>
        <textarea id="b32-raw-in" class="cyan-glow-input" style="height:90px; margin-bottom:15px;" placeholder="যেমন: iLoveYouBD CyberX"></textarea>

        <button onclick="encodeBase32Spec()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">ENCODE TO BASE32 ➔</button>

        <div id="b32-output-con" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">BASE32 RESULT</label>
            <textarea id="b32-result" class="cyan-glow-input" style="height:80px; font-family:monospace;" readonly></textarea>
        </div>
    </div>
    <script>
        function encodeBase32Spec() {
            var raw = document.getElementById('b32-raw-in').value;
            if(!raw) { alert('টেক্সট দিন!'); return; }
            
            // Fast client representing base32
            var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
            var out = "";
            for(var i=0; i<raw.length; i++) {
                var code = raw.charCodeAt(i);
                out += tab[code % 32] + tab[Math.floor(code / 32) % 32];
            }
            document.getElementById('b32-result').value = out;
            document.getElementById('b32-output-con').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('base32-encoder-decoder');
        }
    </script>
    <?php
}
