<?php
/**
 * Admin subpage: Dashboard & Compliance Board Auditor
 * Path: admin/dashboard-auditor.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$cache_stats = array('count' => 0, 'size' => 0);
if (function_exists('ilybd_prime_get_cache_stats')) {
    $cache_stats = ilybd_prime_get_cache_stats();
}
?>
<div class="ilybd-cyber-wrapper">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <h1 class="ilybd-cyber-h1">
            <span class="dashicons dashicons-shield-alt" style="font-size:32px; width:32px; height:32px; color:#00f0ff;"></span>
            ILYBD Prime Ecosystem - AdSense Board Auditor
        </h1>
        <div style="background:rgba(57, 255, 20, 0.1); border:1px solid #39ff14; color:#39ff14; padding:5px 12px; border-radius:15px; font-size:11px; font-family:'JetBrains Mono', monospace; font-weight:bold; letter-spacing:1px; animation: pulse 2s infinite;" id="terminal-pulse">
            ● ONLINE SYSTEM
        </div>
    </div>
    <p class="ilybd-cyber-subtitle">গ্লোবাল ক্যাশে সার্ভিস, স্পিড মেট্রিক্স, এবং স্বয়ংক্রিয় গুগল এডসেন্স বোর্ড পলিসি কমপ্লায়েন্স অডিটর।</p>

    <?php $this->ilybd_render_tabs('dashboard'); ?>

    <!-- 1. Top Core Web Vitals Lighthouse Ring Dashboard -->
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:25px;">
        
        <!-- Score Circular Panel (Compliance Meter) -->
        <div class="ilybd-cyber-panel" style="display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; position:relative; min-height:220px; border-color: rgba(189, 0, 255, 0.35);">
            <div id="compliance-grade-circle" style="font-size:62px; font-weight:800; color:#cbd5e1; border:5px solid #30363d; border-radius:50%; width:110px; height:110px; display:flex; align-items:center; justify-content:center; margin-bottom:15px; transition:all 0.4s ease; font-family:'JetBrains Mono', monospace;">-</div>
            <div style="font-weight:700; font-size:14px; text-transform:uppercase; letter-spacing:1px; color:#fff;" id="compliance-score-title">SCORE: --%</div>
            <div style="font-size:12px; margin-top:5px; color:#94a3b8;" id="compliance-status-desc">কমপ্লায়েন্স কোয়ালিটি গ্রেড</div>
        </div>

        <!-- Metric Speedometer Panel -->
        <div class="ilybd-cyber-panel" style="grid-column: span 3; display:flex; flex-direction:column; justify-content:center;">
            <div class="ilybd-panel-title" style="margin-bottom:15px;"><span class="dashicons dashicons-performance" style="color:#00f0ff;"></span> Real-Time Lighthouse Core Compliance</div>
            
            <div style="display:flex; justify-content:space-around; align-items:center; flex-wrap:wrap; gap:15px;">
                <!-- Performance -->
                <div style="text-align:center;">
                    <div style="position:relative; width:70px; height:70px; margin:0 auto 8px auto;">
                        <svg viewBox="0 0 36 36" style="width:70px; height:70px; transform: rotate(-90deg);">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#10172a" stroke-width="3" />
                            <path id="perf-svg-circle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#39ff14" stroke-width="3" stroke-dasharray="0, 100" style="transition: stroke-dasharray 0.8s ease;" />
                        </svg>
                        <div id="perf-score-val" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:15px; font-weight:700; font-family:'JetBrains Mono', monospace; color:#39ff14;">-</div>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:#e2e8f0; display:block;">PERFORMANCE</span>
                    <span id="perf-verdict" style="font-size:10px; color:#94a3b8;">--</span>
                </div>

                <!-- Accessibility -->
                <div style="text-align:center;">
                    <div style="position:relative; width:70px; height:70px; margin:0 auto 8px auto;">
                        <svg viewBox="0 0 36 36" style="width:70px; height:70px; transform: rotate(-90deg);">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#10172a" stroke-width="3" />
                            <path id="a11y-svg-circle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#39ff14" stroke-width="3" stroke-dasharray="0, 100" style="transition: stroke-dasharray 0.8s ease;" />
                        </svg>
                        <div id="a11y-score-val" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:15px; font-weight:700; font-family:'JetBrains Mono', monospace; color:#39ff14;">-</div>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:#e2e8f0; display:block;">ACCESSIBILITY</span>
                    <span id="a11y-verdict" style="font-size:10px; color:#94a3b8;">--</span>
                </div>

                <!-- Best Practices -->
                <div style="text-align:center;">
                    <div style="position:relative; width:70px; height:70px; margin:0 auto 8px auto;">
                        <svg viewBox="0 0 36 36" style="width:70px; height:70px; transform: rotate(-90deg);">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#10172a" stroke-width="3" />
                            <path id="best-svg-circle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#39ff14" stroke-width="3" stroke-dasharray="0, 100" style="transition: stroke-dasharray 0.8s ease;" />
                        </svg>
                        <div id="best-score-val" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:15px; font-weight:700; font-family:'JetBrains Mono', monospace; color:#39ff14;">-</div>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:#e2e8f0; display:block;">BEST PRACTICES</span>
                    <span id="best-verdict" style="font-size:10px; color:#94a3b8;">--</span>
                </div>

                <!-- SEO Index -->
                <div style="text-align:center;">
                    <div style="position:relative; width:70px; height:70px; margin:0 auto 8px auto;">
                        <svg viewBox="0 0 36 36" style="width:70px; height:70px; transform: rotate(-90deg);">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#10172a" stroke-width="3" />
                            <path id="seo-svg-circle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#39ff14" stroke-width="3" stroke-dasharray="0, 100" style="transition: stroke-dasharray 0.8s ease;" />
                        </svg>
                        <div id="seo-score-val" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:15px; font-weight:700; font-family:'JetBrains Mono', monospace; color:#39ff14;">-</div>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:#e2e8f0; display:block;">SEO COMPLIANCE</span>
                    <span id="seo-verdict" style="font-size:10px; color:#94a3b8;">--</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Speeches/Advice Bubble (Bengali Speaking Assistant Board) -->
    <div style="display:flex; gap:15px; align-items:flex-start; background:rgba(0, 240, 255, 0.05); border:1px solid rgba(0, 240, 255, 0.25); border-radius:10px; padding:20px; margin-bottom:25px; box-shadow: 0 0 15px rgba(0,240,255,0.05);">
        <div style="background:#091122; border:2px solid #00f0ff; border-radius:50%; min-width:48px; width:48px; height:48px; display:flex; align-items:center; justify-content:center; color:#00f0ff; font-weight:bold; font-size:22px; font-family:'Space Grotesk', sans-serif;">
            AI
        </div>
        <div>
            <div style="color:#00f0ff; font-weight:700; font-size:14px; margin-bottom:4px; font-family:'Space Grotesk', sans-serif; text-transform:uppercase;">AdSense QA Board Representative Speech:</div>
            <div style="font-size:13.5px; line-height:1.6; color:#e2e8f0; font-weight:500;" id="adsense-bot-advice">
                কমপ্লায়েন্স ডাটাবেস লোড করা হচ্ছে। চেক করতে নিচে "Run Compliance Scan Now" বাটনে ক্লিক করুন।
            </div>
        </div>
    </div>

    <!-- 3. Terminal Diagnostics Console & Action Panels -->
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px; margin-bottom:25px;">
        
        <!-- Terminal Output -->
        <div style="background:#03070d; border:1px solid rgba(0, 240, 255, 0.15); border-radius:8px; padding:20px; box-shadow:inset 0 0 20px rgba(0,0,0,0.8);">
            <div style="display:flex; justify-content:space-between; border-bottom:1px solid rgba(148,163,184,0.1); padding-bottom:8px; margin-bottom:12px;">
                <span style="font-family:'JetBrains Mono', monospace; font-size:11px; color:#8b949e; display:flex; align-items:center; gap:6px;">
                    <span style="width:7px; height:7px; background:#ff3e3e; border-radius:50%; display:inline-block;"></span>
                    <span style="width:7px; height:7px; background:#ffaa00; border-radius:50%; display:inline-block;"></span>
                    <span style="width:7px; height:7px; background:#39ff14; border-radius:50%; display:inline-block;"></span>
                    system_compliance_telemetry.log
                </span>
                <span style="font-family:'JetBrains Mono', monospace; font-size:11px; color:#00f0ff; cursor:pointer;" onclick="jQuery('#cyber-tel-console').empty(); writeTerminal('[CONSOLE] Cleaned logs. Re-run scan to stream telemetry data.', '#00f0ff');">Clear Logs</span>
            </div>
            <pre id="cyber-tel-console" style="margin:0; height:240px; overflow-y:auto; font-family:'JetBrains Mono', monospace; font-size:12px; line-height:1.6; color:#888; white-space:pre-wrap; word-wrap:break-word;">[INFO] System analyzer loaded in 2040 Cyber Space.
[SYSTEM] Ready for compliance validation diagnostics logs telemetry.
Click [Run Compliance Scan Now] to initiate testing sequence...</pre>
        </div>

        <!-- Metrics Side Info Panel -->
        <div class="ilybd-cyber-panel" style="margin-bottom:0; display:flex; flex-direction:column; justify-content:space-between;">
            <div>
                <div style="font-size:12px; text-transform:uppercase; color:#94a3b8; font-weight:700; margin-bottom:10px; font-family:'JetBrains Mono', monospace; border-bottom:1px solid rgba(148,163,184,0.1); padding-bottom:5px;">System Diagnostics</div>
                
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:15px;">
                    <div style="background:rgba(148,163,184,0.03); border:1px solid rgba(148,163,184,0.1); border-radius:6px; padding:10px; text-align:center;">
                        <div id="cwv-scanned-posts" style="font-size:20px; font-weight:bold; color:#00f0ff; font-family:'JetBrains Mono', monospace;">-</div>
                        <div style="font-size:9.5px; color:#94a3b8; font-weight:bold;">POSTS SCANNED</div>
                    </div>
                    <div style="background:rgba(148,163,184,0.03); border:1px solid rgba(148,163,184,0.1); border-radius:6px; padding:10px; text-align:center;">
                        <div id="cwv-double-funcs" style="font-size:20px; font-weight:bold; color:#ff3e3e; font-family:'JetBrains Mono', monospace;">-</div>
                        <div style="font-size:9.5px; color:#94a3b8; font-weight:bold;">SIGNATURE CLASH</div>
                    </div>
                    <div style="background:rgba(148,163,184,0.03); border:1px solid rgba(148,163,184,0.1); border-radius:6px; padding:10px; text-align:center;">
                        <div id="cwv-corrupt-meta" style="font-size:20px; font-weight:bold; color:#ffaa00; font-family:'JetBrains Mono', monospace;">-</div>
                        <div style="font-size:9.5px; color:#94a3b8; font-weight:bold;">CORRUPT META</div>
                    </div>
                    <div style="background:rgba(148,163,184,0.03); border:1px solid rgba(148,163,184,0.1); border-radius:6px; padding:10px; text-align:center;">
                        <div id="cwv-vitals-ttfb" style="font-size:20px; font-weight:bold; color:#39ff14; font-family:'JetBrains Mono', monospace;">-</div>
                        <div style="font-size:9.5px; color:#94a3b8; font-weight:bold;">SYSTEM TTFB</div>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div style="display:flex; flex-direction:column; gap:8px;">
                <button type="button" id="ilybd-scan-btn" class="ilybd-cyber-btn" style="width:100%; text-align:center; display:flex; justify-content:center; align-items:center; gap:8px;">
                    <span class="dashicons dashicons-search" style="font-size:16px; width:16px; height:16px; margin:0;"></span>
                    Run Compliance Scan Now
                </button>
                
                <button type="button" id="ilybd-fix-btn" class="ilybd-cyber-btn" style="width:100%; text-align:center; display:flex; justify-content:center; align-items:center; gap:8px; background:linear-gradient(90deg, #bd00ff, #00f0ff) !important; color:#fff !important;" disabled>
                    <span class="dashicons dashicons-admin-tools" style="font-size:16px; width:16px; height:16px; margin:0; color:#fff;"></span>
                    AI Auto-Fix & Purify (Safe)
                </button>
            </div>
        </div>
    </div>

    <!-- 4. Core Web Vitals Details Table -->
    <div class="ilybd-cyber-panel" id="cwv-details" style="display:none;">
        <div class="ilybd-panel-title" style="margin-bottom:15px;">📊 Core Web Vitals (CWV) Speed Mechanics Detail</div>
        <table class="ilybd-cyber-form-table" style="font-size:13px;">
            <thead>
                <tr style="border-bottom:1px solid rgba(148,163,184,0.1);">
                    <th style="padding:10px 5px; color:#00f0ff;">SPEED VITALS METRIC</th>
                    <th style="padding:10px 5px; color:#00f0ff;">DETERMINED MEASURE VALUE</th>
                    <th style="padding:10px 5px; color:#00f0ff;">GOOGLE RECOMMENDED CAP</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom:1px solid rgba(148,163,184,0.05);">
                    <td style="padding:12px 5px; font-weight:bold;">Time to First Byte (TTFB)</td>
                    <td style="padding:12px 5px; font-family:'JetBrains Mono', monospace; color:#39ff14;" id="cwv-ttfb">-</td>
                    <td style="padding:12px 5px; color:#94a3b8;">&lt; 200ms (High Speed)</td>
                </tr>
                <tr style="border-bottom:1px solid rgba(148,163,184,0.05);">
                    <td style="padding:12px 5px; font-weight:bold;">First Contentful Paint (FCP)</td>
                    <td style="padding:12px 5px; font-family:'JetBrains Mono', monospace; color:#39ff14;" id="cwv-fcp">-</td>
                    <td style="padding:12px 5px; color:#94a3b8;">&lt; 1.8s (Zero-Latency)</td>
                </tr>
                <tr>
                    <td style="padding:12px 5px; font-weight:bold;">Cumulative Layout Shift (CLS)</td>
                    <td style="padding:12px 5px; font-family:'JetBrains Mono', monospace; color:#39ff14;" id="cwv-cls">-</td>
                    <td style="padding:12px 5px; color:#94a3b8;">&lt; 0.10 (AdSense Shield Lock)</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Loader Icon Overlay overlay -->
<div id="ilybd-loader-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(7, 11, 19, 0.85); z-index:99999; display:flex; align-items:center; justify-content:center; flex-direction:column;">
    <div style="border: 4px solid rgba(0, 240, 255, 0.1); border-top: 4px solid #00f0ff; border-radius: 50%; width: 50px; height: 50px; animation: ilybd-spin 1s linear infinite;"></div>
    <div style="color:#00f0ff; margin-top:20px; font-family:'Space Grotesk', sans-serif; font-weight:bold; letter-spacing:1.5px; text-transform:uppercase; text-shadow:0 0 8px rgba(0,240,255,0.4);" id="loader-overlay-desc">AI Compliance Scan Running...</div>
</div>

<style>
@keyframes ilybd-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes pulse {
    0% { opacity: 0.6; }
    50% { opacity: 1; }
    100% { opacity: 0.6; }
}
</style>

<script>
jQuery(document).ready(function($) {
    var scanBtn = $('#ilybd-scan-btn');
    var fixBtn = $('#ilybd-fix-btn');
    var loader = $('#ilybd-loader-overlay');
    loader.hide(); // safety

    function writeTerminal(text, color) {
        var consoleLog = $('#cyber-tel-console');
        var span = $('<span>').css('color', color || '#888').text(text + '\n');
        consoleLog.append(span);
        consoleLog.scrollTop(consoleLog[0].scrollHeight);
    }

    function getColorForScore(score) {
        if (score >= 90) return '#39ff14'; // Green
        if (score >= 75) return '#00f0ff'; // Cyan
        if (score >= 50) return '#ffaa00'; // Yellow
        return '#ff3e3e'; // Red
    }

    function getVerdictForScore(score) {
        if (score >= 90) return 'EXCELLENT';
        if (score >= 75) return 'GOOD';
        if (score >= 50) return 'NEUTRAL';
        return 'CRITICAL';
    }

    scanBtn.on('click', function() {
        scanBtn.prop('disabled', true);
        loader.show();
        $('#loader-overlay-desc').text('AI Compliance Scan Running...');
        $('#terminal-pulse').text('● DIAGNOSTICS SCANNING');
        $('#cyber-tel-console').empty();

        writeTerminal('[SYSTEM] INITIALIZING TELEMETRY SCAN PIPELINE...', '#00f0ff');
        writeTerminal('[SYSTEM] Running WordPress Core check...', '#fff');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'ilybd_adsense_bot_scan'
            },
            success: function(response) {
                scanBtn.prop('disabled', false);
                loader.hide();
                $('#terminal-pulse').text('● SYSTEM STABLE');

                if (response.success) {
                    var data = response.data;
                    var clean = true;

                    writeTerminal('✅ Scan successfully linked. Processing compliance metrics...\n', '#39ff14');
                    
                    writeTerminal('--- 1. ESSENTIAL COMPLIANCE PAGES ---', '#00f0ff');
                    $.each(data.pages_status, function(key, page) {
                        if (page.status === 'FOUND') {
                            writeTerminal('✔ [' + page.status + '] Legal Page ' + page.label + ' detected (ID: ' + page.id + ').', '#39ff14');
                        } else {
                            clean = false;
                            writeTerminal('⚠ [MISSING] Legal page ' + page.label + ' NOT found!', '#ffaa00');
                        }
                    });

                    writeTerminal('\n--- 2. DETECTED BLACKLIST & POLICY VIOLATIONS ---', '#00f0ff');
                    $('#cwv-scanned-posts').text(data.posts_scanned);
                    writeTerminal('📈 Checked total of ' + data.posts_scanned + ' standard published posts.', '#fff');

                    if (data.violations.length === 0) {
                        writeTerminal('✅ No blacklisted keywords detected in active post titles or bodies.', '#39ff14');
                    } else {
                        clean = false;
                        writeTerminal('⚠ Policy Violation Found! Dangerous key terms found in ' + data.violations.length + ' posts:', '#ff3e3e');
                        $.each(data.violations, function(i, post) {
                            writeTerminal('   • Post ID ' + post.id + ': "' + post.title + '" contains terms: ' + post.words.join(', '), '#ffaa00');
                        });
                    }

                    writeTerminal('\n--- 3. THIN CONTENT & QUALITY REDUCE SCANS ---', '#00f0ff');
                    if (data.thin_content.length === 0) {
                        writeTerminal('✅ All scanned posts meet the required min-length guidelines of 550 words.', '#39ff14');
                    } else {
                        clean = false;
                        writeTerminal('⚠ Thin Content Found! ' + data.thin_content.length + ' posts fail min-length guideline:', '#ffaa00');
                        $.each(data.thin_content, function(i, post) {
                            writeTerminal('   • "' + post.title + '" contains only ' + post.count + ' words. SEO indexing risk.', '#ffaa00');
                        });
                    }

                    writeTerminal('\n--- 4. IMAGE ALT ATTRIBUTE & A11Y SCAN ---', '#00f0ff');
                    writeTerminal('📈 Total elements: ' + data.total_images + ' image assets analyzed.', '#fff');
                    if (data.missing_alt === 0) {
                        writeTerminal('✅ All attachment elements have alternate alt labels.', '#39ff14');
                    } else {
                        clean = false;
                        writeTerminal('⚠ Found ' + data.missing_alt + ' images with missing Alternate Alt labels.', '#ffaa00');
                    }

                    writeTerminal('\n--- 5. MICRO-SERVICE CODE INTEGRITY (AUTO-DEBUG) ---', '#00f0ff');
                    var doubleFuncs = Object.keys(data.duplicated_functions).length;
                    var doubleHooks = data.duplicated_hooks ? Object.keys(data.duplicated_hooks).length : 0;
                    $('#cwv-double-funcs').text(doubleFuncs + doubleHooks);
                    $('#cwv-corrupt-meta').text(data.corrupted_meta_count);

                    if (doubleFuncs === 0) {
                        writeTerminal('✅ No PHP functional name signature collisions found in plugin files.', '#39ff14');
                    } else {
                        clean = false;
                        writeTerminal('⚠ Collision Warning! Found duplicated PHP function signatures:', '#ff3e3e');
                        $.each(data.duplicated_functions, function(func, files) {
                            writeTerminal('   • Function ' + func + ' duplicated in: ' + files.join(', '), '#ffaa00');
                        });
                    }

                    writeTerminal('\n--- 6. DATABASE OVERHEAD ANALYTICS ---', '#00f0ff');
                    writeTerminal('📈 Database revision overhead count: ' + data.revisions + ' records.', '#fff');
                    writeTerminal('📈 Stale transients cache: ' + data.transients_count + ' transient items.', '#fff');
                    if (data.corrupted_meta_count > 0 || data.corrupted_posts_count > 0) {
                        writeTerminal('⚠ Detected ' + data.corrupted_meta_count + ' empty meta entries & ' + data.corrupted_posts_count + ' empty draft elements.', '#ffaa00');
                    } else {
                        writeTerminal('✅ No corrupted metakeys or hollow post bodies detected.', '#39ff14');
                    }

                    writeTerminal('\n--- BOARD REPRESENTATIVE CORRESPONDENCE Advice ---', '#39ff14');
                    writeTerminal(data.advice, '#ffaa00');
                    $('#adsense-bot-advice').text(data.advice);

                    // Update main Compliance Grade Ring
                    var circle = $('#compliance-grade-circle');
                    circle.text(data.grade);
                    $('#compliance-score-title').text('SCORE: ' + data.score + '%');
                    
                    if(data.grade === 'A') {
                        circle.css({'border-color': '#39ff14', 'color': '#39ff14', 'box-shadow': '0 0 15px rgba(57,255,20,0.25)'});
                        $('#compliance-status-desc').text('আপনার সাইট সম্পূর্ণ সুরক্ষিত!').css('color', '#39ff14');
                    } else if(data.grade === 'B') {
                        circle.css({'border-color': '#00f0ff', 'color': '#00f0ff', 'box-shadow': '0 0 15px rgba(0,240,255,0.2)'});
                        $('#compliance-status-desc').text('স্বল্পমাত্রার ঝুঁকি, সংশোধন করুন।').css('color', '#00f0ff');
                    } else {
                        circle.css({'border-color': '#ff3e3e', 'color': '#ff3e3e', 'box-shadow': '0 0 15px rgba(255,62,62,0.2)'});
                        $('#compliance-status-desc').text('গুরুতর ঝুঁকি! এখনই ফিক্স বাটনে চাপুন।').css('color', '#ff3e3e');
                    }

                    // Update Lighthouse progress rings
                    $('#perf-svg-circle').attr('stroke-dasharray', data.perf_score + ', 100').css('stroke', getColorForScore(data.perf_score));
                    $('#perf-score-val').text(data.perf_score).css('color', getColorForScore(data.perf_score));
                    $('#perf-verdict').text(getVerdictForScore(data.perf_score)).css('color', getColorForScore(data.perf_score));

                    $('#a11y-svg-circle').attr('stroke-dasharray', data.a11y_score + ', 100').css('stroke', getColorForScore(data.a11y_score));
                    $('#a11y-score-val').text(data.a11y_score).css('color', getColorForScore(data.a11y_score));
                    $('#a11y-verdict').text(getVerdictForScore(data.a11y_score)).css('color', getColorForScore(data.a11y_score));

                    $('#best-svg-circle').attr('stroke-dasharray', data.best_score + ', 100').css('stroke', getColorForScore(data.best_score));
                    $('#best-score-val').text(data.best_score).css('color', getColorForScore(data.best_score));
                    $('#best-verdict').text(getVerdictForScore(data.best_score)).css('color', getColorForScore(data.best_score));

                    $('#seo-svg-circle').attr('stroke-dasharray', data.seo_score + ', 100').css('stroke', getColorForScore(data.seo_score));
                    $('#seo-score-val').text(data.seo_score).css('color', getColorForScore(data.seo_score));
                    $('#seo-verdict').text(getVerdictForScore(data.seo_score)).css('color', getColorForScore(data.seo_score));

                    // Detailed speeds table
                    $('#cwv-ttfb').text(data.ttfb);
                    $('#cwv-vitals-ttfb').text(data.ttfb);
                    $('#cwv-fcp').text(data.fcp);
                    $('#cwv-cls').text(data.cls);
                    $('#cwv-details').slideDown(300);

                    writeTerminal('-------------------------------------------', '#39ff14');
                    writeTerminal('[SYSTEM] Scan complete and stable. Click "AI Auto-Fix" to repair warnings.', '#00f0ff');
                    
                    fixBtn.prop('disabled', false).css({'opacity':'1', 'cursor':'pointer'});
                } else {
                    writeTerminal('❌ Scan failed: ' + response.data.message, '#ff3e3e');
                }
            },
            error: function() {
                scanBtn.prop('disabled', false);
                loader.hide();
                writeTerminal('❌ Critical failure accessing AJAX scan endpoint.', '#ff3e3e');
            }
        });
    });

    fixBtn.on('click', function() {
        if (!confirm('আপনি কি নিশ্চিত যে আপনি এআই পলিসি এডিটরকে সাইটের কমপ্লায়েন্স ও ডিবাগিং ত্রুটিগুলো নিরাময় করতে পারমিশন দিতে চান? এটি স্বয়ংক্রিয়ভাবে সর্বমোট ৪টি গুরুত্বপূর্ণ ফিল্ড (Performance, Accessibility, Best Practices, SEO) ১০০% পিউরিফাই করবে।')) {
            return;
        }
        scanBtn.prop('disabled', true);
        fixBtn.prop('disabled', true);
        loader.show();
        $('#loader-overlay-desc').text('AI Purge & Auto-Fix Pipeline Executing...');
        $('#terminal-pulse').text('● CORE PURGING / FIXING');
        writeTerminal('\n[REPAIR PIPELINE] Launching next-gen core repair bot...', '#00f0ff');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'ilybd_adsense_bot_autofix'
            },
            success: function(response) {
                scanBtn.prop('disabled', false);
                loader.hide();
                if(response.success) {
                    $('#terminal-pulse').text('● AUTO-FIX COMPLETE');
                    writeTerminal('-------------------------------------------', '#39ff14');
                    $.each(response.data.logs, function(i, log) {
                        writeTerminal(log, '#39ff14');
                    });
                    writeTerminal('-------------------------------------------', '#39ff14');
                    writeTerminal('[SUCCESS] ' + response.data.message, '#39ff14');
                    writeTerminal('[SYSTEM] Running verification scan... Standby.', '#00f0ff');
                    
                    setTimeout(function() {
                        scanBtn.trigger('click');
                    }, 2500);
                } else {
                    writeTerminal('❌ Repair failed: ' + response.data.message, '#ff3e3e');
                }
            },
            error: function() {
                scanBtn.prop('disabled', false);
                loader.hide();
                writeTerminal('❌ Critical failure accessing AJAX repair endpoint.', '#ff3e3e');
            }
        });
    });
});
</script>
