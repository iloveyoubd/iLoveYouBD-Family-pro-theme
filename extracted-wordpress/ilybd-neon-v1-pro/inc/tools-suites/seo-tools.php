<?php
/**
 * ILYBD Neon v2 Pro - SEO Tools Division (10 Premium Utilities)
 * Fully interactive client-side analyzing engines and code output consoles.
 */

if (!defined('ABSPATH')) exit;

// 1. Keyword Density Checker
function ilybd_render_tool_keyword_density_checker() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">PASTE YOUR FULL ARTICLE / সম্পূর্ণ আর্টিকেল দিন</label>
        <textarea id="seo-density-text" class="cyan-glow-input" style="height:150px; margin-bottom:15px;" placeholder="আপনার আর্টিকেলের পুরো টেক্সট এখানে পেস্ট করুন..."></textarea>
        
        <button onclick="checkDensity()" class="cyber-action-btn" style="width:100%; margin-bottom:20px; background:linear-gradient(45deg, #00ff41, #10b981);">ANALYZE KEYWORD DENSITY ➔</button>

        <div id="seo-density-output" style="display:none;">
            <div style="display:grid; grid-template-columns:1fr 1.5fr; gap:20px;">
                <div>
                    <label class="bento-label" style="color:#00ff41;">TOTAL STATS</label>
                    <div style="background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:10px; padding:15px; font-size:14px; display:flex; flex-direction:column; gap:8px;">
                        <span>Words Count: <strong id="density-wc" style="color:#00ff41;">0</strong></span>
                        <span>Unique Words: <strong id="density-uw" style="color:#00f0ff;">0</strong></span>
                    </div>
                </div>
                <div>
                    <label class="bento-label" style="color:#ff007c;">TOP REPEATED KEYWORDS (FREQUENCY > 1%)</label>
                    <div id="density-keyword-table" style="max-height:150px; overflow-y:auto; background:rgba(0,0,0,0.3); padding:10px; border-radius:10px; display:flex; flex-direction:column; gap:6px; font-family:monospace; font-size:12px;"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkDensity() {
            var text = document.getElementById('seo-density-text').value.trim();
            if(!text) { alert('অনুগ্রহ করে লেখা পেস্ট করুন!'); return; }
            
            // Clean punctuation
            var words = text.toLowerCase()
                .replace(/[.,\/#!$%\^&\*;:{}=\-_`~()?"'৳।\n]/g, " ")
                .split(/\s+/);
            
            words = words.filter(function(w) { return w.length > 2; }); // Skip short words
            var totalCount = words.length;
            if(totalCount === 0) { alert('পর্যাপ্ত শব্দ নেই!'); return; }
            
            var counts = {};
            words.forEach(function(w) {
                counts[w] = (counts[w] || 0) + 1;
            });
            
            var sorted = [];
            for(var key in counts) {
                sorted.push([key, counts[key]]);
            }
            sorted.sort(function(a, b) { return b[1] - a[1]; });
            
            document.getElementById('density-wc').textContent = totalCount;
            document.getElementById('density-uw').textContent = sorted.length;
            
            var table = document.getElementById('density-keyword-table');
            table.innerHTML = '';
            
            var showed = 0;
            sorted.forEach(function(item) {
                var keyword = item[0];
                var freq = item[1];
                var pct = ((freq / totalCount) * 100).toFixed(2);
                
                if (pct >= 0.50 && showed < 15) {
                    showed++;
                    var div = document.createElement('div');
                    div.style.display = 'flex';
                    div.style.justify = 'space-between';
                    div.style.padding = '4px 8px';
                    div.style.borderBottom = '1px solid rgba(255,255,255,0.03)';
                    div.style.color = pct > 3.0 ? '#ff4d4d' : '#cbd5e0';
                    
                    var warn = pct > 3.0 ? ' ⚠️ STUFFING!' : '';
                    div.innerHTML = '<span>🗝️ ' + keyword + ' (' + freq + ')</span> <span>' + pct + '%' + warn + '</span>';
                    table.appendChild(div);
                }
            });
            
            document.getElementById('seo-density-output').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('keyword-density-checker');
        }
    </script>
    <?php
}

// 2. Meta Tag Generator
function ilybd_render_tool_meta_tag_generator() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:<?php echo $neon_color; ?>;">SITE TITLE / সাইটের নাম</label>
                <input type="text" id="meta-site-title" class="cyan-glow-input" placeholder="e.g. iLoveYouBD">
            </div>
            <div>
                <label class="bento-label" style="color:<?php echo $neon_color; ?>;">SITE AUTHOR / লেখক</label>
                <input type="text" id="meta-site-author" class="cyan-glow-input" placeholder="e.g. Admin Team">
            </div>
        </div>
        
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">SITE DESCRIPTION / বিবরণ</label>
        <textarea id="meta-site-desc" class="cyan-glow-input" style="height:60px; margin-bottom:15px;" placeholder="যেমন: বাংলাদেশের নির্ভরযোগ্য প্রযুক্তি ও ওয়েব প্রোগ্রামিং টিউটোরিয়াল পোর্টাল..."></textarea>
        
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">KEYWORDS / কিওয়ার্ডস</label>
        <input type="text" id="meta-site-keywords" class="cyan-glow-input" placeholder="যেমন: tech, programming, tutorials, ai, software..." style="margin-bottom:15px;">

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:<?php echo $neon_color; ?>;">ROBOTS CRAWL CONTROL</label>
                <select id="meta-robots" class="cyan-glow-input">
                    <option value="index, follow">Index, Follow (সাজেস্টেড)</option>
                    <option value="noindex, nofollow">Noindex, Nofollow (ফর প্রাইভেট পেজ)</option>
                </select>
            </div>
            <div>
                <label class="bento-label" style="color:<?php echo $neon_color; ?>;">CONTENT LANGUAGE</label>
                <select id="meta-lang" class="cyan-glow-input">
                    <option value="Bengali">Bengali / বাংলা</option>
                    <option value="English">English / ইংরেজি</option>
                </select>
            </div>
        </div>

        <button onclick="generateMetaTags()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">BUILD HEAD META BLOCK ➔</button>

        <div id="meta-tags-output" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">READY META CODE BLOCK</label>
            <textarea id="meta-plain-output" class="cyan-glow-input" style="height:170px; font-family:monospace; font-size:12px; line-height:1.5; color:#00ff41;" readonly></textarea>
            <button onclick="copyMetaCode()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY CODE BLOCK</button>
        </div>
    </div>
    <script>
        function generateMetaTags() {
            var title = document.getElementById('meta-site-title').value.trim() || 'Untitled Site';
            var author = document.getElementById('meta-site-author').value.trim() || 'Admin Team';
            var desc = document.getElementById('meta-site-desc').value.trim() || 'Default site description';
            var keys = document.getElementById('meta-site-keywords').value.trim() || 'general, tools';
            var robots = document.getElementById('meta-robots').value;
            var lang = document.getElementById('meta-lang').value;
            
            var code = '<!-- Primary Meta Tags -->\n' +
                       '<title>' + title + '</title>\n' +
                       '<meta name="title" content="' + title + '">\n' +
                       '<meta name="description" content="' + desc + '">\n' +
                       '<meta name="keywords" content="' + keys + '">\n' +
                       '<meta name="author" content="' + author + '">\n' +
                       '<meta name="robots" content="' + robots + '">\n' +
                       '<meta name="language" content="' + lang + '">\n' +
                       '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
            
            document.getElementById('meta-plain-output').value = code;
            document.getElementById('meta-tags-output').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('meta-tag-generator');
        }
        function copyMetaCode() {
            var text = document.getElementById('meta-plain-output').value;
            navigator.clipboard.writeText(text);
            alert('📋 মেটা ট্যাগ কোড কপি করা হয়েছে!');
        }
    </script>
    <?php
}

// 3. Robots.txt Generator
function ilybd_render_tool_robots_txt_generator() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">XML SITEMAP LINK / সাইটম্যাপ লিংক দিন</label>
        <input type="text" id="robots-sitemap" class="cyan-glow-input" placeholder="e.g. https://iloveyoubd.com/sitemap_index.xml" style="margin-bottom:15px;">

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:<?php echo $neon_color; ?>;">CRAWL DELAY (SECONDS)</label>
                <select id="robots-delay" class="cyan-glow-input">
                    <option value="">No Delay (ডিফল্ট)</option>
                    <option value="5">5 Seconds</option>
                    <option value="10">10 Seconds</option>
                </select>
            </div>
            <div>
                <label class="bento-label" style="color:<?php echo $neon_color; ?>;">RESTRICT BLOCK DIRECTORY</label>
                <input type="text" id="robots-block-dir" class="cyan-glow-input" placeholder="e.g. /wp-admin/ or /private/">
            </div>
        </div>

        <button onclick="generateRobotsTXT()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">BUILD ROBOTS.TXT FILE➔</button>

        <div id="robots-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">ROBOTS.TXT FILE TEXT</label>
            <textarea id="robots-plain-output" class="cyan-glow-input" style="height:150px; font-family:monospace; font-size:13px; color:#00ff41;" readonly></textarea>
            <button onclick="copyRobotsTXT()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY FILE CONTENTS</button>
        </div>
    </div>
    <script>
        function generateRobotsTXT() {
            var sm = document.getElementById('robots-sitemap').value.trim();
            var delay = document.getElementById('robots-delay').value;
            var block = document.getElementById('robots-block-dir').value.trim() || '/wp-admin/';
            
            var text = 'User-agent: *\n';
            text += 'Disallow: ' + block + '\n';
            text += 'Disallow: /wp-includes/\n';
            text += 'Disallow: /search/\n';
            text += 'Allow: /wp-admin/admin-ajax.php\n';
            
            if(delay) {
                text += 'Crawl-delay: ' + delay + '\n';
            }
            if(sm) {
                text += '\nSitemap: ' + sm;
            }
            
            document.getElementById('robots-plain-output').value = text;
            document.getElementById('robots-output-container').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('robots-txt-generator');
        }
        function copyRobotsTXT() {
            var text = document.getElementById('robots-plain-output').value;
            navigator.clipboard.writeText(text);
            alert('📋 Robots.txt কোড কপি হয়েছে!');
        }
    </script>
    <?php
}

// 4. XML Sitemap Generator
function ilybd_render_tool_xml_sitemap_generator() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">YOUR WEBSITE DOMAIN URL / ডোমেইন অ্যাড্রেস দিন</label>
        <input type="text" id="sm-domain" class="cyan-glow-input" placeholder="e.g. https://iloveyoubd.com" style="margin-bottom:15px;">

        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">PASTE YOUR WEB PAGES PATHS (ONE PER LINE) / পাতাগুলোর লিংক দিন</label>
        <textarea id="sm-paths" class="cyan-glow-input" style="height:80px; margin-bottom:15px;" placeholder="/&#10;/category/hacking/&#10;/about/&#10;/contact/"></textarea>

        <button onclick="generateXMLSitemap()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GENERATE VALID XML SITEMAP ➔</button>

        <div id="sm-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">VALID XML SITEMAP SCHEMA</label>
            <textarea id="sm-plain-output" class="cyan-glow-input" style="height:180px; font-family:monospace; font-size:12px; color:#00ff41; line-height:1.4;" readonly></textarea>
            <button onclick="copySitemapXML()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY SITEMAP XML</button>
        </div>
    </div>
    <script>
        function generateXMLSitemap() {
            var dom = document.getElementById('sm-domain').value.trim();
            if(!dom) { alert('ডোমেইন দিন!'); return; }
            if(dom.endsWith('/')) { dom = dom.slice(0, -1); }
            
            var paths = document.getElementById('sm-paths').value.trim().split('\n');
            var now = new Date().toISOString().split('T')[0];
            
            var xml = '<?xml version="1.0" encoding="UTF-8"?>\n' +
                      '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n';
                      
            paths.forEach(function(path) {
                path = path.trim();
                if(path) {
                    if(!path.startsWith('/')) { path = '/' + path; }
                    xml += '  <url>\n' +
                           '    <loc>' + dom + path + '</loc>\n' +
                           '    <lastmod>' + now + '</lastmod>\n' +
                           '    <changefreq>daily</changefreq>\n' +
                           '    <priority>0.80</priority>\n' +
                           '  </url>\n';
                }
            });
            
            xml += '</urlset>';
            document.getElementById('sm-plain-output').value = xml;
            document.getElementById('sm-output-container').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('xml-sitemap-generator');
        }
        function copySitemapXML() {
            var text = document.getElementById('sm-plain-output').value;
            navigator.clipboard.writeText(text);
            alert('📋 সাইটম্যাপ এক্সএমএল কপিড!');
        }
    </script>
    <?php
}

// 5. Schema Generator
function ilybd_render_tool_schema_generator() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">SCHEMA TYPE</label>
        <select id="schema-type" class="cyan-glow-input" style="margin-bottom:15px;" onchange="toggleSchemaFields()">
            <option value="faq">FAQ Schema / এফএকিউ স্কিমা</option>
            <option value="article">Article Schema / ব্লগ আর্টিকেল</option>
        </select>

        <div id="schema-faq-fields">
            <label class="bento-label" style="color:<?php echo $neon_color; ?>;">QUESTION 1</label>
            <input type="text" id="sch-fq1" class="cyan-glow-input" placeholder="e.g. বিকাশ অ্যাপ আয় করা কি রিয়েল?" style="margin-bottom:10px;">
            <label class="bento-label" style="color:<?php echo $neon_color; ?>;">ANSWER 1</label>
            <input type="text" id="sch-fa1" class="cyan-glow-input" placeholder="e.g. হ্যাঁ, এটি একদম ১০০% ট্রাস্টেড ও রিয়েল মেথড।" style="margin-bottom:15px;">
        </div>

        <div id="schema-art-fields" style="display:none;">
            <label class="bento-label" style="color:<?php echo $neon_color; ?>;">HEADLINE</label>
            <input type="text" id="sch-ah" class="cyan-glow-input" placeholder="e.g. ১০০ টাকা বিকাশ ফ্রি অফার" style="margin-bottom:15px;">
        </div>

        <button onclick="generateJSONLDSchema()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">BUILD JSON-LD CODE ➔</button>

        <div id="sch-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">READY FOR INJECTION (JSON-LD)</label>
            <textarea id="sch-plain-output" class="cyan-glow-input" style="height:170px; font-family:monospace; font-size:12px; color:#00ff41; line-height:1.4;" readonly></textarea>
            <button onclick="copySchemaJSON()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY SCHEMA CODE</button>
        </div>
    </div>
    <script>
        function toggleSchemaFields() {
            var t = document.getElementById('schema-type').value;
            if(t === 'faq') {
                document.getElementById('schema-faq-fields').style.display = 'block';
                document.getElementById('schema-art-fields').style.display = 'none';
            } else {
                document.getElementById('schema-faq-fields').style.display = 'none';
                document.getElementById('schema-art-fields').style.display = 'block';
            }
        }
        function generateJSONLDSchema() {
            var t = document.getElementById('schema-type').value;
            var json = {};
            
            if(t === 'faq') {
                var q1 = document.getElementById('sch-fq1').value.trim() || 'প্রশ্ন কি?';
                var a1 = document.getElementById('sch-fa1').value.trim() || 'উত্তর কি?';
                json = {
                    "@context": "https://schema.org",
                    "@type": "FAQPage",
                    "mainEntity": [{
                        "@type": "Question",
                        "name": q1,
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": a1
                        }
                    }]
                };
            } else {
                var head = document.getElementById('sch-ah').value.trim() || 'Untitled Headline';
                json = {
                    "@context": "https://schema.org",
                    "@type": "NewsArticle",
                    "headline": head,
                    "datePublished": new Date().toISOString(),
                    "author": {
                        "@type": "Person",
                        "name": "Admin Pro"
                    }
                };
            }
            
            document.getElementById('sch-plain-output').value = JSON.stringify(json, null, 2);
            document.getElementById('sch-output-container').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('schema-generator');
        }
        function copySchemaJSON() {
            var text = document.getElementById('sch-plain-output').value;
            navigator.clipboard.writeText(text);
            alert('📋 স্কিমা কোড সফলভাবে কপি করা হয়েছে!');
        }
    </script>
    <?php
}

// 6. Canonical Tag Generator
function ilybd_render_tool_canonical_tag_generator() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">IDEAL REAL LINK / পেজের অরিজিনাল ইউআরএল</label>
        <input type="text" id="can-link" class="cyan-glow-input" placeholder="e.g. https://iloveyoubd.com/tools/" style="margin-bottom:15px;">

        <button onclick="generateCanonical()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GENERATE CANONICAL TAG ➔</button>

        <div id="can-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">HTML CANONICAL TAG LINE</label>
            <textarea id="can-plain-output" class="cyan-glow-input" style="height:60px; font-family:monospace; font-size:13px; color:#00ff41;" readonly></textarea>
            <button onclick="copyCanonicalCode()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY ELEMENT LINE</button>
        </div>
    </div>
    <script>
        function generateCanonical() {
            var url = document.getElementById('can-link').value.trim();
            if(!url) { alert('লিংক দিন!'); return; }
            var tag = '<link rel="canonical" href="' + url + '" />';
            document.getElementById('can-plain-output').value = tag;
            document.getElementById('can-output-container').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('canonical-tag-generator');
        }
        function copyCanonicalCode() {
            var text = document.getElementById('can-plain-output').value;
            navigator.clipboard.writeText(text);
            alert('📋 কপিড!');
        }
    </script>
    <?php
}

// 7. Open Graph Generator
function ilybd_render_tool_open_graph_generator() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:<?php echo $neon_color; ?>;">OG TITLE / টাইটেল</label>
                <input type="text" id="og-title-in" class="cyan-glow-input" placeholder="যেমন: বিকাশ সিকিউরিটি নির্দেশিকা">
            </div>
            <div>
                <label class="bento-label" style="color:<?php echo $neon_color; ?>;">OG TYPE</label>
                <select id="og-type-in" class="cyan-glow-input">
                    <option value="website">Website</option>
                    <option value="article">Article</option>
                </select>
            </div>
        </div>

        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">OG IMAGE URL / থাম্বনেল ছবির লিংক</label>
        <input type="text" id="og-img-in" class="cyan-glow-input" placeholder="e.g. https://iloveyoubd.com/thumb.png" style="margin-bottom:15px;">

        <button onclick="generateOG()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GENERATE SOCIAL META TAGS ➔</button>

        <div id="og-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">OPEN GRAPH META CODE</label>
            <textarea id="og-plain-output" class="cyan-glow-input" style="height:140px; font-family:monospace; font-size:12px; color:#00ff41; line-height:1.4;" readonly></textarea>
            <button onclick="copyOGCode()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY OG CODE</button>
        </div>
    </div>
    <script>
        function generateOG() {
            var title = document.getElementById('og-title-in').value.trim() || 'Default OG Title';
            var type = document.getElementById('og-type-in').value;
            var img = document.getElementById('og-img-in').value.trim() || 'https://iloveyoubd.com/og-default.png';
            
            var code = '<!-- Open Graph / Facebook -->\n' +
                       '<meta property="og:type" content="' + type + '">\n' +
                       '<meta property="og:title" content="' + title + '">\n' +
                       '<meta property="og:image" content="' + img + '">\n' +
                       '\n<!-- Twitter Card tags -->\n' +
                       '<meta name="twitter:card" content="summary_large_image">\n' +
                       '<meta name="twitter:title" content="' + title + '">\n' +
                       '<meta name="twitter:image" content="' + img + '">';
            
            document.getElementById('og-plain-output').value = code;
            document.getElementById('og-output-container').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('open-graph-generator');
        }
        function copyOGCode() {
            var text = document.getElementById('og-plain-output').value;
            navigator.clipboard.writeText(text);
            alert('📋 সোস্যাল মেটা কোড কপি হয়েছে!');
        }
    </script>
    <?php
}

// 8. SERP Preview Tool
function ilybd_render_tool_serp_preview_tool() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">SERP PREVIEW TITLE</label>
        <input type="text" id="serp-title" class="cyan-glow-input" placeholder="e.g. ফ্রিতে ১০ জিবি ইন্টারনেট ট্রিক - ২০৪০ এডিশন" style="margin-bottom:15px;" onkeyup="updateSerpPreview()">

        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">SERP DESCRIPTION</label>
        <textarea id="serp-desc" class="cyan-glow-input" style="height:60px; margin-bottom:15px;" placeholder="অনুগ্রহ করে পেজ ডিসক্রিপশন লিখুন..." onkeyup="updateSerpPreview()"></textarea>

        <label class="bento-label" style="color:#00f0ff;">GOOGLE LIVE PREVIEW (MOBILE MODE)</label>
        <div style="background:#fff; color:#000; border-radius:12px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.5); font-family:Arial, sans-serif; text-align:left;">
            <div style="font-size:12px; color:#202124; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                <img src="<?php echo get_site_icon_url() ?: 'https://www.google.com/s2/favicons?sz=64&domain=iloveyoubd.com'; ?>" style="width:18px; height:18px; border-radius:50%;" referrerPolicy="no-referrer">
                <div>
                    <span style="font-weight:bold; display:block; line-height:1.2;">iloveyoubd.com</span>
                    <span style="font-size:10px; color:#5f6368; display:block; line-height:1.2;">https://iloveyoubd.com › tools</span>
                </div>
            </div>
            <h3 id="serp-preview-h3" style="color:#1a0dab; font-size:18px; margin:4px 0; font-weight:normal; cursor:pointer;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">আইডিয়াল টাইটেল প্রিভিউ এখানে দেখাবে</h3>
            <p id="serp-preview-p" style="color:#4d5156; font-size:13px; line-height:1.4; margin:0;">আপনার লেখার মেটা ডেসক্রিপশন গুগলে ঠিক এই মডেলে শো হবে। লাইভ চেক করুন যেকোনো সময়...</p>
        </div>
    </div>
    <script>
        function updateSerpPreview() {
            var t = document.getElementById('serp-title').value.trim() || 'আইডিয়াল টাইটেল প্রিভিউ এখানে দেখাবে';
            var d = document.getElementById('serp-desc').value.trim() || 'আপনার লেখার মেটা ডেসক্রিপশন গুগলে ঠিক এই মডেলে শো হবে। লাইভ চেক করুন যেকোনো সময়...';
            
            document.getElementById('serp-preview-h3').textContent = t;
            document.getElementById('serp-preview-p').textContent = d;
            
            if(typeof incrementToolUsage === 'function') incrementToolUsage('serp-preview-tool');
        }
    </script>
    <?php
}

// 9. Internal Link Suggestion Tool
function ilybd_render_tool_internal_link_suggestion_tool() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">PASTE YOUR PARAGRAPH TEXT / লেখা দিন</label>
        <textarea id="int-link-text" class="cyan-glow-input" style="height:110px; margin-bottom:15px;" placeholder="যেমন: আপনি টাকা আয় করতে চাইলে বিকাশ অ্যাপ নিয়ে সঠিক নিয়ম জানতে হবে।"></textarea>

        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">TARGET KEYWORD TO SEED LINKS / লিংক বসানোর কিওয়ার্ড স্লট</label>
        <input type="text" id="int-link-keyword" class="cyan-glow-input" placeholder="e.g. বিকাশ অ্যাপ, টাকা আয়" style="margin-bottom:15px;">

        <button onclick="suggestInternalLinks()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">SCAN FOR LINK PLACEMENTS ➔</button>

        <div id="int-link-output" style="display:none; background:rgba(0,0,0,0.3); border:1px solid rgba(255,255,255,0.06); padding:15px; border-radius:10px;">
            <label class="bento-label" style="color:#00ff41;">LINK INJECTPREVIEW</label>
            <div id="int-link-preview" class="bangla-font-siliguri" style="line-height:1.7; font-size:14px; color:#fff;"></div>
        </div>
    </div>
    <script>
        function suggestInternalLinks() {
            var text = document.getElementById('int-link-text').value;
            var kw = document.getElementById('int-link-keyword').value.trim();
            if(!text || !kw) { alert('অনুগ্রহ করে লেখা এবং কিওয়ার্ড দিন!'); return; }
            
            var regex = new RegExp(kw, 'g');
            var highlighted = text.replace(regex, '<a href="/tools/" style="color:#00ff41; text-decoration:underline; font-weight:bold;">' + kw + '</a>');
            
            document.getElementById('int-link-preview').innerHTML = highlighted;
            document.getElementById('int-link-output').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('internal-link-suggestion-tool');
        }
    </script>
    <?php
}

// 10. Keyword Clustering Tool
function ilybd_render_tool_keyword_clustering_tool() {
    $neon_color = '#00ff41';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">PASTE KEYWORDS (ONE PER LINE) / কিওয়ার্ড লিস্ট দিন</label>
        <textarea id="cluster-raw" class="cyan-glow-input" style="height:120px; margin-bottom:15px;" placeholder="যেমন: বিকাশ কুপন কোড&#10;বিকাশ সিকিউরিটি টিপস&#10;ইন্টারনেট স্পিড টেস্ট..."></textarea>

        <button onclick="groupClusterKeywords()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GROUP INTENT CLUSTERS ➔</button>

        <div id="cluster-output" style="display:none; background:rgba(15,23,42,0.8); border:1px solid rgba(255,255,255,0.06); padding:20px; border-radius:12px;">
            <label class="bento-label" style="color:#00ff41;">SEMANTIC CLUSTERS</label>
            <div id="cluster-groups" style="display:grid; grid-template-columns:1fr 1fr; gap:15px;"></div>
        </div>
    </div>
    <script>
        function groupClusterKeywords() {
            var text = document.getElementById('cluster-raw').value.trim();
            if(!text) { alert('কিওয়ার্ড লিখুন!'); return; }
            
            var lines = text.split('\n');
            var clusters = {
                'Earning/Payment (বিকাশ ও লেনদেন)': [],
                'Hacking/Tips (ট্রিকস ও নিরাপত্তা)': [],
                'Telecom/Internet (ইন্টারনেট ডাটা пакет)': [],
                'General Intent (অন্যান্য বিষয়)': []
            };
            
            lines.forEach(function(line) {
                line = line.trim();
                if(line) {
                    if (line.includes('বিকাশ') || line.includes('earn') || line.includes('টাকা') || line.includes('pay')) {
                        clusters['Earning/Payment (বিকাশ ও লেনদেন)'].push(line);
                    } else if (line.includes('হ্যাকিং') || line.includes('hack') || line.includes('ট্রিক') || line.includes('trick')) {
                        clusters['Hacking/Tips (ট্রিকস ও নিরাপত্তা)'].push(line);
                    } else if (line.includes('ইন্টারনেট') || line.includes('রবি') || line.includes('নেট') || line.includes('mb') || line.includes('internet')) {
                        clusters['Telecom/Internet (ইন্টারনেট ডাটা пакет)'].push(line);
                    } else {
                        clusters['General Intent (অন্যান্য বিষয়)'].push(line);
                    }
                }
            });
            
            var wrapper = document.getElementById('cluster-groups');
            wrapper.innerHTML = '';
            
            for(var cat in clusters) {
                var list = clusters[cat];
                if(list.length > 0) {
                    var box = document.createElement('div');
                    box.style.background = 'rgba(255,255,255,0.02)';
                    box.style.padding = '12px';
                    box.style.borderRadius = '8px';
                    box.style.border = '1px solid rgba(255,255,255,0.05)';
                    
                    var h4 = document.createElement('h4');
                    h4.style.color = '#00f0ff';
                    h4.style.fontSize = '13px';
                    h4.style.margin = '0 0 8px 0';
                    h4.textContent = cat;
                    box.appendChild(h4);
                    
                    var ul = document.createElement('ul');
                    ul.style.listStyle = 'none';
                    ul.style.padding = '0';
                    ul.style.margin = '0';
                    ul.style.fontSize = '12.5px';
                    ul.style.color = '#cbd5e0';
                    
                    list.forEach(function(item) {
                        var li = document.createElement('li');
                        li.style.padding = '3px 0';
                        li.textContent = '📍 ' + item;
                        ul.appendChild(li);
                    });
                    
                    box.appendChild(ul);
                    wrapper.appendChild(box);
                }
            }
            
            document.getElementById('cluster-output').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('keyword-clustering-tool');
        }
    </script>
    <?php
}

// 11. Search Engine Metadata & CSS Glow Factory
function ilybd_render_tool_meta_css_glow_factory() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:#f43f5e;">APP OR SITE TITLE / সাইট শিরোনাম</label>
                <input type="text" id="seoTitle" value="bKash APK" class="cyan-glow-input" style="border-color:#f43f5e33;">
            </div>
            <div>
                <label class="bento-label" style="color:#f43f5e;">PACKAGE ID OR SLUG / স্ল্যাগ বা লিঙ্ক</label>
                <input type="text" id="seoSlug" value="com.bKash.customerapp" class="cyan-glow-input" style="border-color:#f43f5e33;">
            </div>
        </div>
        <div style="margin-bottom:20px;">
            <label class="bento-label" style="color:#f43f5e;">DESCRIPTION / সাইট বিবরণ</label>
            <input type="text" id="seoDesc" value="নিরাপদে ও দ্রুত ডাউনলোড করুন বিকাশের অফিসিয়াল এপিকে সবচেয়ে সুরক্ষিত সার্ভার থেকে।" class="cyan-glow-input" style="border-color:#f43f5e33;">
        </div>

        <button onclick="generateSeoCode();" class="cyber-action-btn" style="background:#f43f5e; color:#fff; width:100%; margin-bottom:20px;">GENERATE META & GLOW CODE ⚡</button>
        
        <div id="seoResultArea" style="display:none; margin-top:15px; border-top:1px solid rgba(255,255,255,0.06); padding-top:12px;">
            <label class="bento-label" style="color:#00ff41;">📋 GOOGLE CRITICAL HEAD METATAGS</label>
            <textarea id="seoOutMeta" readonly rows="6" class="cyan-glow-input" style="border-color:rgba(244,63,94,0.3); color:#00ff41; font-family:monospace; font-size:12px; outline:none; resize:none; margin-bottom:15px;" onclick="this.select();"></textarea>
            
            <button onclick="navigator.clipboard.writeText(document.getElementById('seoOutMeta').value); alert('মেটা ট্যাগ ক্লিপবোর্ডে কপি হয়েছে!');" class="cyber-action-btn" style="background:rgba(0,255,65,0.12); color:#00ff41; border:1px solid #00ff41; width:100%;">কপি কোড প্যাচ 📋</button>
        </div>
    </div>
    <script>
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
        if (typeof incrementToolUsage === 'function') {
            incrementToolUsage('meta-css-glow-factory');
        }
    }
    </script>
    <?php
}
