<?php
/**
 * ILYBD Neon v2 Pro - AI Tools Division (10 Premium Utilities)
 * High-Speed responsive Client-Side generators and engines with 2040 cyberpunk visuals.
 */

if (!defined('ABSPATH')) exit;

// 1. AI Blog Title Generator
function ilybd_render_tool_ai_blog_title_generator() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">INPUT CORE TOPIC / কি-ওয়ার্ড দিন</label>
        <input type="text" id="ai-title-topic" class="cyan-glow-input" placeholder="যেমন: অনলাইন ইনকাম, বিকাশ অ্যাপ ক্যাশআউট, মোবাইল আর্নিং..." style="margin-bottom:15px;" onkeypress="if(event.key==='Enter') generateAITitles()">
        
        <div style="display:flex; gap:12px; margin-bottom:20px;">
            <select id="ai-title-vibe" class="cyan-glow-input" style="width: auto;">
                <option value="clickbait">🔥 Viral / আকর্ষণীয় ভাইরাল স্টাইল</option>
                <option value="professional">💼 Professional / অফিশিয়াল গাইড</option>
                <option value="listicle">🔟 Listicle / লিষ্টিকেল ও পয়েন্টস</option>
                <option value="creative">🚀 Creative / ক্রিয়েটিভ ও ফিউচারিস্টিক</option>
            </select>
            <button onclick="generateAITitles()" class="cyber-action-btn" style="flex:1;">GENERATE TITLES ➔</button>
        </div>

        <div id="ai-title-output-container" style="display:none; margin-top:20px;">
            <label class="bento-label" style="color:#00ff41;">GENERATED PRO TITLES (কপি করতে ক্লিক করুন)</label>
            <div id="ai-title-box" style="display:grid; gap:10px;"></div>
        </div>
    </div>
    <script>
        function generateAITitles() {
            var topic = document.getElementById('ai-title-topic').value.trim();
            if(!topic) { alert('অনুগ্রহ করে একটি কিওয়ার্ড বা টপিক লিখুন!'); return; }
            var vibe = document.getElementById('ai-title-vibe').value;
            var box = document.getElementById('ai-title-box');
            var container = document.getElementById('ai-title-output-container');
            
            var templates = {
                clickbait: [
                    "১ ক্লিকেই " + topic + " করুন! ২০৪০ সালের একদম নতুন ধামাকা ট্রিক",
                    "ফাঁস হয়ে গেল " + topic + " এর গোপন সিক্রেট! না দেখলে চরম মিস",
                    "কিভাবে " + topic + " করবেন? গোপন ফর্মুলা যা কেউ আপনাকে বলবে না!",
                    "মাত্র ২ মিনিটে " + topic + " করার সবচেয়ে সহজ এবং কার্যকরী উপায়",
                    topic + " নিয়ে মেগা গাইড! আকর্ষণীয় উপায়ে শিখে নিন পানির মতো সহজে"
                ],
                professional: [
                    topic + " করার সঠিক নিয়মাবলী ও পূর্ণাঙ্গ গাইডলাইন",
                    "A-Z গাইড: " + topic + " ফ্রেমওয়ার্ক এবং সেফ প্রোটেকশন মেথড",
                    "প্রফেশনাল উপায়ে " + topic + " করার আধুনিক বৈজ্ঞানিক টেকনিক",
                    topic + " এর ভবিষ্যৎ: ২০৪০ প্রযুক্তি ও সঠিক ডেভেলপমেন্ট প্ল্যান",
                    topic + " এর ওপর পূর্ণাঙ্গ ইন্ডাস্ট্রিয়াল রিচার্স ও সমাধান প্রসেস"
                ],
                listicle: [
                    "১০টি ধামাকা ট্রিকস: " + topic + " করার বেস্ট মেথডস",
                    "৫টি সহজ উপায়ে " + topic + " করুন খুব দ্রুত সময়ে",
                    "সেরা ৭টি " + topic + " সফটওয়্যার ও সার্ভিস যা আপনার জানা উচিত",
                    "টপ ১০ গোপন সিক্রেট ফর্মুলা: " + topic + " করার প্রফেশনাল পদ্ধতি",
                    "৩টি লাইভ হ্যাকস: কিভাবে ঘরে বসেই " + topic + " কন্ট্রোল করবেন"
                ],
                creative: [
                    "নেক্সট লেভেল " + topic + " আর্কিটেকচার! ২০৪০ প্রযুক্তিতে পা রাখুন",
                    "ফিউচারিস্টিক মেথড: " + topic + " ও সাইবার সিকিউরিটি প্রোটোকল",
                    "ডিজিটাল রেভল্যুশন: " + topic + " গাইড ও এআই আর্নিং টুলস",
                    "আলটিমেট গেম চেঞ্জার: " + topic + " অ্যান্ড নিওন সিকিউরিটি ২০৪০",
                    "ডিজিটাল সাগা: এআই অ্যালগরিদমে " + topic + " মিক্সিং গাইড"
                ]
            };

            var items = templates[vibe] || templates['clickbait'];
            box.innerHTML = '';
            
            items.forEach(function(title) {
                var btn = document.createElement('div');
                btn.style.background = 'rgba(255,255,255,0.03)';
                btn.style.border = '1px solid rgba(255,255,255,0.08)';
                btn.style.padding = '12px 15px';
                btn.style.borderRadius = '8px';
                btn.style.cursor = 'pointer';
                btn.style.fontSize = '14px';
                btn.style.transition = '0.2s';
                btn.style.color = '#fff';
                btn.className = 'bangla-font-siliguri';
                btn.textContent = title;
                
                btn.onmouseover = function() { btn.style.borderColor = '#00f0ff'; btn.style.background = 'rgba(0,240,255,0.05)'; };
                btn.onmouseout = function() { btn.style.borderColor = 'rgba(255,255,255,0.08)'; btn.style.background = 'rgba(255,255,255,0.03)'; };
                btn.onclick = function() {
                    navigator.clipboard.writeText(title);
                    alert('📋 কপি করা হয়েছে: ' + title);
                };
                box.appendChild(btn);
            });
            
            container.style.display = 'block';
            if (typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-blog-title-generator');
            }
        }
    </script>
    <?php
}

// 2. AI Meta Description Generator
function ilybd_render_tool_ai_meta_description_generator() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">ARTICLE POST TITLE / পোস্টের টাইটেল দিন</label>
        <input type="text" id="ai-meta-title" class="cyan-glow-input" placeholder="যেমন: কিভাবে ঘরে বসে বিকাশ অ্যাপ দিয়ে টাকা আয় করবেন" style="margin-bottom:15px;">
        
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">PRIMARY SEO KEYWORDS / কিওয়ার্ডস</label>
        <input type="text" id="ai-meta-keywords" class="cyan-glow-input" placeholder="যেমন: বিকাশ অ্যাপ, ঘরে বসে আয়, bkash app earning" style="margin-bottom:15px;">
        
        <button onclick="generateAIMetaDesc()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GENERATE SEO META DESCRIPTION ➔</button>

        <div id="ai-meta-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">OPTIMIZED META DESCRIPTION</label>
            <textarea id="ai-meta-result" class="cyan-glow-input" style="height:110px; font-size:14px; margin-bottom:10px; font-family:'Space Grotesk', sans-serif;" readonly></textarea>
            <div style="display:flex; justify-content:space-between; font-size:12px; color:#9ca3af;">
                <span id="ai-meta-length-char">0 / 160 Characters</span>
                <span style="color:#00f0ff; cursor:pointer;" onclick="copyMetaDesc()">📋 COPY META DESC</span>
            </div>
        </div>
    </div>
    <script>
        function generateAIMetaDesc() {
            var title = document.getElementById('ai-meta-title').value.trim();
            var keywords = document.getElementById('ai-meta-keywords').value.trim();
            if(!title) { alert('অনুগ্রহ করে পোস্টের টাইটেল দিন!'); return; }
            
            var keyStr = keywords ? "। কি-ওয়ার্ডস: " + keywords : "";
            var text = title + " গাইডলাইন নিয়ে চরম ট্রিক নিয়ে আলোচনা। " + title + " বিষয়ের নিখুঁত উপায় ও এ টু জেড প্রো সমাধান পাবেন এই পোস্টে" + keyStr + "। এখনই বিস্তারিত পড়ুন এবং শেয়ার করুন!";
            
            if(text.length > 158) {
                text = text.substring(0, 155) + "...";
            }
            
            document.getElementById('ai-meta-result').value = text;
            document.getElementById('ai-meta-length-char').textContent = text.length + " / 160 Characters";
            document.getElementById('ai-meta-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-meta-description-generator');
            }
        }
        function copyMetaDesc() {
            var text = document.getElementById('ai-meta-result').value;
            navigator.clipboard.writeText(text);
            alert('📋 কপি করা হয়েছে!');
        }
    </script>
    <?php
}

// 3. AI Paragraph Writer
function ilybd_render_tool_ai_paragraph_writer() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">PARAGRAPH CONTEXT / অনুচ্ছেদের বিষয়বস্তু দিন</label>
        <input type="text" id="ai-para-topic" class="cyan-glow-input" placeholder="যেমন: ইন্টারনেটের কুপন ব্যবহার করে ডিসকাউন্টের সুবিধা..." style="margin-bottom:15px;">
        
        <button onclick="generateAIPara()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">WRITE PROFESSIONAL PARAGRAPH ➔</button>

        <div id="ai-para-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">GENERATED PARAGRAPH</label>
            <div id="ai-para-result" class="cyan-glow-input bangla-font-siliguri" style="min-height:120px; font-size:14px; line-height:1.7; background:rgba(0,0,0,0.3); border:1px solid rgba(255,255,255,0.05); padding:15px; border-radius:8px; margin-bottom:10px;"></div>
            <button onclick="copyGeneratedPara()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px;">📋 COPY TEXT</button>
        </div>
    </div>
    <script>
        function generateAIPara() {
            var topic = document.getElementById('ai-para-topic').value.trim();
            if(!topic) { alert('অনুগ্রহ করে বিষয়বস্তু উল্লেখ করুন!'); return; }
            
            var text = "আজকের দিনে " + topic + " হলো একটি অত্যন্ত যুগান্তকারী উপায় যা আমাদের কাজকে করে তোলে আরও গতিশীল এবং সুশৃঙ্খল। সঠিক নিয়ম ও নিবিড় পর্যবেক্ষণ পদ্ধতি অনুসরণ করে " + topic + " ক্ষেত্রে অভূতপূর্ব সাফল্য নিশ্চিত করা সম্ভব। প্রযুক্তির এই কল্যাণকর সময়ে সম্পূর্ণ ফ্রিতে যেকোনো ইউটিলিটি মডিউল ব্যবহার আমাদের অনেক এগিয়ে রাখে। এই গাইডলাইনটি আপনাকে " + topic + " এর বাস্তব অভিজ্ঞতা ও কার্যকরী ফলাফল পেতে অসাধারণভাবে সহযোগিতা করবে।";
            
            document.getElementById('ai-para-result').textContent = text;
            document.getElementById('ai-para-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-paragraph-writer');
            }
        }
        function copyGeneratedPara() {
            var text = document.getElementById('ai-para-result').textContent;
            navigator.clipboard.writeText(text);
            alert('📋 কপি করা হয়েছে!');
        }
    </script>
    <?php
}

// 4. AI Article Outline Creator
function ilybd_render_tool_ai_article_outline_creator() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">ARTICLE CORE THEME / আর্টিকেলের মূল টপিক লিখুন</label>
        <input type="text" id="ai-outline-topic" class="cyan-glow-input" placeholder="যেমন: প্রফেশনাল ব্লগিং শুরুর গাইড ২০৪০..." style="margin-bottom:15px;">
        
        <button onclick="generateAIOutline()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GENERATE ARTICLE OUTLINE ➔</button>

        <div id="ai-outline-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">HETEROGENEOUS STRUCTURAL OUTLINE (H1, H2, H3)</label>
            <textarea id="ai-outline-result" class="cyan-glow-input bangla-font-siliguri" style="height:180px; font-size:13.5px; line-height:1.7; font-family:'Courier New', monospace;" readonly></textarea>
            <button onclick="copyOutlineText()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY OUTLINE STRUCTURE</button>
        </div>
    </div>
    <script>
        function generateAIOutline() {
            var topic = document.getElementById('ai-outline-topic').value.trim();
            if(!topic) { alert('অনুগ্রহ করে টপিক উল্লেখ করুন!'); return; }
            
            var text = "[H1] " + topic + " (আলটিমেট গাইড)\n\n" +
                       "  ├── [H2] ১. ভূমিকা (Introduction to " + topic + ")\n" +
                       "  │     └── [H3] ক. বিষয়বস্তুর সহজ ব্যাকগ্রাউন্ড\n" +
                       "  │     └── [H3] খ. কেন এটি গুরুত্বপূর্ণ?\n\n" +
                       "  ├── [H2] ২. মূল সিক্রেট প্রসেস ও মেথডলজি\n" +
                       "  │     └── [H3] ক. প্রয়োজনীয় রিসোর্স ও টুলস সেটিং\n" +
                       "  │     └── [H3] খ. স্টেপ-বাই-স্টেপ এক্সেকিউশন প্ল্যান\n\n" +
                       "  ├── [H2] ৩. সাধারণ ভুল ও সতর্কতা সমূহ\n" +
                       "  │     └── [H3] ক. কোন কোন কাজ করা নিষিদ্ধ?\n" +
                       "  │     └── [H3] খ. লং টার্ম সুরক্ষিত থাকার সিকিউরিটি প্রোটোকল\n\n" +
                       "  ├── [H2] ৪. রিয়ল-টাইম বেনিফিটস ও ফিউচার ভিউ\n" +
                       "  └── [H2] ৫. উপসংহার ও প্রফেশনাল মতামত (Conclusion)";
            
            document.getElementById('ai-outline-result').value = text;
            document.getElementById('ai-outline-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-article-outline-creator');
            }
        }
        function copyOutlineText() {
            var text = document.getElementById('ai-outline-result').value;
            navigator.clipboard.writeText(text);
            alert('📋 কপি করা হয়েছে!');
        }
    </script>
    <?php
}

// 5. AI Keyword Generator
function ilybd_render_tool_ai_keyword_generator() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">NICHE TOPIC / মূল বিষয় দিন</label>
        <input type="text" id="ai-kw-topic" class="cyan-glow-input" placeholder="যেমন: ফ্রিল্যান্সিং, জাভাস্ক্রিপ্ট কোডিং গাইড..." style="margin-bottom:15px;">
        
        <button onclick="generateAIKeywords()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">EXTRACT SEO LSI KEYWORDS ➔</button>

        <div id="ai-kw-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">HIGH SEARCH VOLUME & LSI KEYWORDS</label>
            <div id="ai-kw-result" style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:15px;"></div>
            <button onclick="copyCommaKeywords()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px;">📋 COPY AS COMMASEPARATED</button>
        </div>
    </div>
    <script>
        function generateAIKeywords() {
            var topic = document.getElementById('ai-kw-topic').value.trim();
            if(!topic) { alert('অনুগ্রহ করে টপিক দিন!'); return; }
            
            var list = [
                topic + " বাংলা টিউটোরিয়াল",
                topic + " শেখার সহজ উপায়",
                "কিভাবে সহজে " + topic + " করবেন",
                topic + " ২০৪০ হ্যাকস সমাধান",
                topic + " এর গোপন খুটিনাটি ট্রিকস",
                "Best methods for " + topic,
                "LSI terms of " + topic + " full guide",
                "Earn from " + topic
            ];
            
            var box = document.getElementById('ai-kw-result');
            box.innerHTML = '';
            
            list.forEach(function(item) {
                var badge = document.createElement('span');
                badge.style.background = 'rgba(0, 240, 255, 0.08)';
                badge.style.border = '1px solid rgba(0, 240, 255, 0.2)';
                badge.style.color = '#00f0ff';
                badge.style.fontSize = '12px';
                badge.style.padding = '6px 12px';
                badge.style.borderRadius = '20px';
                badge.style.fontFamily = 'Space Grotesk, Hind Siliguri, sans-serif';
                badge.textContent = item;
                box.appendChild(badge);
            });
            
            document.getElementById('ai-kw-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-keyword-generator');
            }
        }
        function copyCommaKeywords() {
            var topic = document.getElementById('ai-kw-topic').value.trim();
            var list = [
                topic + " বাংলা টিউটোরিয়াল",
                topic + " শেখার সহজ উপায়",
                "কিভাবে সহজে " + topic + " করবেন",
                topic + " ২০৪০ হ্যাকস সমাধান",
                topic + " এর গোপন খুটিনাটি ট্রিকস",
                "Best methods for " + topic,
                "LSI terms of " + topic + " full guide",
                "Earn from " + topic
            ];
            navigator.clipboard.writeText(list.join(', '));
            alert('📋 কপি করা হয়েছে (কমা দিয়ে পৃথকীকৃত)!');
        }
    </script>
    <?php
}

// 6. AI Social Media Writer
function ilybd_render_tool_ai_social_media_writer() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">POST CONCISE MESSAGE / কি বিষয়ে স্ট্যাটাস দিতে চান?</label>
        <input type="text" id="ai-social-raw" class="cyan-glow-input" placeholder="যেমন: নতুন আইফোন ১২ প্রো ম্যাক্স ট্রিক..." style="margin-bottom:15px;">
        
        <button onclick="generateAISocialPost()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">ENHANCE SOCIAL COPY ➔</button>

        <div id="ai-social-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">VIRAL POST WITH HASHTAGS & EMOJIS</label>
            <div id="ai-social-result" class="cyan-glow-input bangla-font-siliguri" style="min-height:100px; padding:15px; font-size:14px; line-height:1.7; background:rgba(0,0,0,0.3); border:1px solid rgba(255,255,255,0.05); border-radius:8px; margin-bottom:10px;"></div>
            <button onclick="copySocialPost()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px;">📋 COPY POST</button>
        </div>
    </div>
    <script>
        function generateAISocialPost() {
            var raw = document.getElementById('ai-social-raw').value.trim();
            if(!raw) { alert('অনুগ্রহ করে শর্ট মেসেজ দিন!'); return; }
            
            var text = "🔥 চরম ধামাকা এলার্ট! 🚀\n\nবন্ধুরা, অবশেষে সবার দীর্ঘ রিচার্সের পর নিয়ে এলাম " + raw + " এর একদম নিখুঁত রিয়েল সলিউশন। ⚡ যারা এতদিন নানা ঝামেলায় ভুগছিলেন, আজকের এই ট্রিকটি তাদের জন্য পুরাই ম্যাজিকের মতো কাজ করবে। ২০৪০ নিওন সংস্করণটির সিক্রেট গাইড দেখুন নিচের অফিশিয়াল লিংকে!\n\n👇 এখনই দেখে নিন এবং আপনার ওয়ালে শেয়ার করে টাইমলাইনে সেভ রাখুন!\n\n#DigitalSuite #CyberWorld #Trick #iloveyoubd #ViralStuff";
            
            document.getElementById('ai-social-result').innerHTML = text.replace(/\n/g, '<br>');
            document.getElementById('ai-social-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-social-media-writer');
            }
        }
        function copySocialPost() {
            var html = document.getElementById('ai-social-result').innerHTML;
            var text = html.replace(/<br>/g, '\n');
            navigator.clipboard.writeText(text);
            alert('📋 কপি করা হয়েছে!');
        }
    </script>
    <?php
}

// 7. AI YouTube Tag Picker
function ilybd_render_tool_ai_youtube_tag_picker() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">YOUTUBE VIDEO TITLE OR TOPIC / ভিডিওর টাইটেল দিন</label>
        <input type="text" id="ai-yt-topic" class="cyan-glow-input" placeholder="যেমন: কিভাবে ইউটিউব ভিডিও ভাইরাল করা যায়..." style="margin-bottom:15px;">
        
        <button onclick="generateAIYTTags()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">HARVEST VIDEO TAGS ➔</button>

        <div id="ai-yt-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">OPTIMIZED YT TAGS (FOR TAGS SECTION)</label>
            <textarea id="ai-yt-result" class="cyan-glow-input" style="height:110px; font-size:14px; margin-bottom:10px; font-family:'Space Grotesk', sans-serif;" readonly></textarea>
            <button onclick="copyYTTags()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px;">📋 COPY TAGS FOR YT STUDIO</button>
        </div>
    </div>
    <script>
        function generateAIYTTags() {
            var topic = document.getElementById('ai-yt-topic').value.trim();
            if(!topic) { alert('অনুগ্রহ করে ভিডিওর মূল থিম দিন!'); return; }
            
            var tags = [
                topic,
                topic + " শিখুন",
                topic + " সহজ নিয়ম",
                "viral youtube trick",
                "youtube tagging tool",
                "how to viral " + topic,
                "iloveyoubd tools",
                topic + " secret formula"
            ];
            
            var text = tags.join(', ');
            document.getElementById('ai-yt-result').value = text;
            document.getElementById('ai-yt-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-youtube-tag-picker');
            }
        }
        function copyYTTags() {
            var text = document.getElementById('ai-yt-result').value;
            navigator.clipboard.writeText(text);
            alert('📋 ভিডিও ট্যাগগুলো কপি করা হয়েছে! আপনার YT স্টুডিওর ট্যাগ বক্সে পেস্ট করে দিন।');
        }
    </script>
    <?php
}

// 8. AI Hashtag Generator
function ilybd_render_tool_ai_hashtag_generator() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">TARGET KEYWORD / টার্গেট স্ল্যাগ দিন</label>
        <input type="text" id="ai-hash-raw" class="cyan-glow-input" placeholder="যেমন: bkash, earning money, technology, coding..." style="margin-bottom:15px;">
        
        <button onclick="generateAIHashtags()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">HUNT VIRAL HASHTAGS ➔</button>

        <div id="ai-hash-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">VIRAL HASHTAGS</label>
            <div id="ai-hash-result" class="cyan-glow-input" style="min-height:60px; line-height:2; font-weight:700; color:#00f0ff;"></div>
            <button onclick="copyHashtags()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY ALL HASHTAGS</button>
        </div>
    </div>
    <script>
        function generateAIHashtags() {
            var w = document.getElementById('ai-hash-raw').value.replace(/\s+/g, '').trim();
            if(!w) { alert('শব্দ লিখুন!'); return; }
            
            var list = [
                "#" + w,
                "#" + w + "viral",
                "#" + w + "tricks",
                "#" + w + "2040",
                "#" + w + "bangla",
                "#iloveyoubd",
                "#cyberX",
                "#earnSecure",
                "#techtips"
            ];
            
            document.getElementById('ai-hash-result').textContent = list.join(' ');
            document.getElementById('ai-hash-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-hashtag-generator');
            }
        }
        function copyHashtags() {
            var text = document.getElementById('ai-hash-result').textContent;
            navigator.clipboard.writeText(text);
            alert('📋 অল হ্যাশট্যাগ কপি করা হয়েছে!');
        }
    </script>
    <?php
}

// 9. AI Email Writer
function ilybd_render_tool_ai_email_writer() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">REASON FOR EMAIL / ইমেইলের প্রধান কারণ</label>
        <input type="text" id="ai-email-reason" class="cyan-glow-input" placeholder="যেমন: ৩ দিনের ছুটির আবেদন, জব অ্যাপ্লিকেশন..." style="margin-bottom:15px;">
        
        <button onclick="generateAIEmail()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">DRAFT EMAIL COPY ➔</button>

        <div id="ai-email-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">READY DRAPHT EMAIL</label>
            <div id="ai-email-result" class="cyan-glow-input bangla-font-siliguri" style="min-height:160px; line-height:1.7; padding:15px; font-size:14px; background:rgba(0,0,0,0.3); border:1px solid rgba(255,255,255,0.05); border-radius:8px; margin-bottom:10px;"></div>
            <button onclick="copyGeneratedEmail()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px;">📋 COPY EMAIL TEXT</button>
        </div>
    </div>
    <script>
        function generateAIEmail() {
            var reason = document.getElementById('ai-email-reason').value.trim();
            if(!reason) { alert('ছুটি বা অ্যাপ্লিকেশনের কারণ দিন!'); return; }
            
            var text = "Subject: " + reason + " প্রসঙ্গে জরুরী অফিশিয়াল আবেদনপত্র।\n\n" +
                       "সম্মানিত স্যার/ম্যাডাম,\n\n" +
                       "সবিনয় নিবেদন এই যে, আমি আপনার প্রতিষ্ঠানের একজন নিয়মিত কর্মী। আমি আপনাকে অত্যন্ত জেন্টলম্যান টোনে জানাতে চাচ্ছি যে, বর্তমানে আমার জরুরি কারণে " + reason + " প্রয়োজন।\n\n" +
                       "এমতাবস্থায়, আমার এই বিষয়টি বিবেচনা করে আমাকে অনুগ্রহপূর্বক সুযোগ বা ছুটি দিলে আমি অত্যন্ত কৃতজ্ঞ থাকব। পরিস্থিতি অনুকূলে থাকলে আমি দ্রুত আমার দায়িত্বের মূল পর্বে ফিরে আসবো।\n\n" +
                       "ধন্যবাদান্তে,\n" +
                       "[আপনার নাম এখানে]\n" +
                       "[প্রতিষ্ঠানের ডেজিগনেশন]";
            
            document.getElementById('ai-email-result').innerHTML = text.replace(/\n/g, '<br>');
            document.getElementById('ai-email-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-email-writer');
            }
        }
        function copyGeneratedEmail() {
            var html = document.getElementById('ai-email-result').innerHTML;
            var text = html.replace(/<br>/g, '\n');
            navigator.clipboard.writeText(text);
            alert('📋 ইমেইল ড্রাফট কপি করা হয়েছে!');
        }
    </script>
    <?php
}

// 10. AI Prompt Generator
function ilybd_render_tool_ai_prompt_generator() {
    $neon_color = '#00f0ff';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:<?php echo $neon_color; ?>;">RAW IDEA / সাধারণ প্রম্পট আইডিয়া দিন</label>
        <input type="text" id="ai-prompt-raw" class="cyan-glow-input" placeholder="যেমন: একটি বিড়ালের ছবি ল্যাপটপে কোডিংলাব এ বসা..." style="margin-bottom:15px;">
        
        <button onclick="generateAIPrompt()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">ENHANCE AI PROMPT ➔</button>

        <div id="ai-prompt-output-container" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">MIDJOURNEY & DALL-E PRO-AMPLIFIED PROMPT</label>
            <textarea id="ai-prompt-result" class="cyan-glow-input" style="height:120px; font-size:13.5px; line-height:1.6; font-family:'Courier New', monospace;" readonly></textarea>
            <button onclick="copyGeneratedPrompt()" class="cyber-action-btn" style="background:#10b981; font-size:11px; padding:6px 12px; margin-top:10px;">📋 COPY PROMPT</button>
        </div>
    </div>
    <script>
        function generateAIPrompt() {
            var raw = document.getElementById('ai-prompt-raw').value.trim();
            if(!raw) { alert('অনুগ্রহ করে সাদামাটা একটি আইডিয়া দিন!'); return; }
            
            var text = "Ultra detailed photorealistic, 8k resolution, cinematic lighting of \"" + raw + "\", cyberpunk 2040 neon environment, volumetric smoke, octane render style, rich deep values, cinematic framing, highly detailed textures, masterfully composed --v 6.0 --ar 16:9 --style raw";
            
            document.getElementById('ai-prompt-result').value = text;
            document.getElementById('ai-prompt-output-container').style.display = 'block';
            
            if(typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-prompt-generator');
            }
        }
        function copyGeneratedPrompt() {
            var text = document.getElementById('ai-prompt-result').value;
            navigator.clipboard.writeText(text);
            alert('📋 মাস্টার প্রম্পট কপি করা হয়েছে!');
        }
    </script>
    <?php
}
