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

// 11. AI Maya Cloud Assistant
function ilybd_render_tool_ai_maya_cloud_assistant() {
    $neon_color = '#fbbf24';
    $ajax_url = admin_url('admin-ajax.php');
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif; background: #070b13; border: 1px solid rgba(251, 191, 36, 0.2); border-radius: 16px; overflow: hidden; box-shadow: 0 0 30px rgba(251, 191, 36, 0.05);">
        <!-- Chat Console Header -->
        <div style="background: rgba(251, 191, 36, 0.05); padding: 15px 20px; border-bottom: 1px solid rgba(251, 191, 36, 0.15); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 20px;">🤖</span>
                <div>
                    <h4 style="color: #fff; font-size: 14px; font-weight: 800; margin: 0; text-transform: uppercase; tracking-wider: 1px;">MAYA QUANTUM v2.5</h4>
                    <span style="color: #fbbf24; font-size: 11px; font-family: 'JetBrains Mono', monospace; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                        <span style="display: inline-block; width: 6px; height: 6px; background: #00ff41; border-radius: 50%; box-shadow: 0 0 8px #00ff41; animation: pulse 1.5s infinite;"></span>
                        SECURE SYNCED // ONLINE
                    </span>
                </div>
            </div>
            <!-- Audio Indicator & Controls -->
            <div style="display: flex; align-items: center; gap: 10px;">
                <button onclick="toggleMayaSound()" id="maya-sound-btn" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: #fbbf24; padding: 6px 10px; border-radius: 20px; font-size: 11px; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: 0.3s;" onmouseover="this.style.background='rgba(251,191,36,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
                    🔊 SOUND ON
                </button>
                <button onclick="clearMayaChat()" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; padding: 6px 10px; border-radius: 20px; font-size: 11px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                    🧹 RESET
                </button>
            </div>
        </div>

        <!-- Chat Area Panel -->
        <div id="maya-inline-chat-box" style="height: 380px; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 15px; background: #04070c; scroll-behavior: smooth;">
            <!-- Maya initial welcome card -->
            <div class="maya-msg-wrapper" style="align-self: flex-start; max-width: 85%; display: flex; gap: 10px;">
                <div style="width: 32px; height: 32px; background: rgba(251, 191, 36, 0.15); border: 1px solid #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; color: #fbbf24; font-weight: bold;">M</div>
                <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 0 16px 16px 16px; padding: 14px 16px; color: #cbd5e0; font-size: 13.5px; line-height: 1.6;" class="bangla-font-siliguri">
                    আসসালামু আলাইকুম! আমি <strong>মায়া</strong>, iloveyoubd.com-এর অফিসিয়াল কৃত্রিম বুদ্ধিমত্তা সম্পন্ন অ্যাসিস্ট্যান্ট। 💖 <br><br>
                    আমি আপনাকে যেকোনো <strong>কোডিং সমস্যা সমাধান, এসইও গাইডলাইন, কন্টেন্ট রাইটিং, আইটি ট্রাবলশুটিং বা চমৎকার বাংলা আলোচনায়</strong> সাহায্য করতে পারি। নিচে কিছু সাজেস্টেড প্রম্পট দেওয়া হলো, অথবা সরাসরি আপনার মনের প্রশ্ন লিখে সেন্ড করুন!
                </div>
            </div>
        </div>

        <!-- Quick suggestion pills container -->
        <div style="padding: 12px 16px; background: rgba(15, 23, 42, 0.6); border-top: 1px solid rgba(255, 255, 255, 0.04); display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
            <span style="color: #9ca3af; font-size: 11px; font-weight: bold; font-family: 'Hind Siliguri', sans-serif;">পরামর্শ:</span>
            <div onclick="selectSuggestedPrompt('বিকাশ অ্যাপ ক্লোন কোড')" class="maya-preset-chip">📱 বিকাশ অ্যাপ ক্লোন</div>
            <div onclick="selectSuggestedPrompt('কিভাবে এসইও শিখে ফ্রিল্যান্সিং শুরু করব?')" class="maya-preset-chip">🚀 এসইও গাইড</div>
            <div onclick="selectSuggestedPrompt('একটি সুন্দর এইচটিএমএল (HTML) নিওন পেজ বানিয়ে দাও')" class="maya-preset-chip">💻 নিওন সাইট মেকার</div>
            <div onclick="selectSuggestedPrompt('পাইথন দিয়ে ইমেইল ভ্যালিডিটি চেক করার স্ক্রিপ্ট')" class="maya-preset-chip">🐍 পাইথন স্ক্রিপ্ট</div>
            <div onclick="selectSuggestedPrompt('একটি আকর্ষণীয় ফেসবুক পোস্ট লিখে দাও')" class="maya-preset-chip">✍️ পোস্ট রাইটার</div>
        </div>

        <!-- Keyboard input & Send actions console -->
        <div style="background: rgba(15, 23, 42, 0.8); padding: 15px; border-top: 1px solid rgba(251, 191, 36, 0.15); display: flex; gap: 10px; align-items: center;">
            <input type="text" id="maya-inline-user-input" class="cyan-glow-input" placeholder="মায়াকে যেকোনো প্রশ্ন করুন (যেমন: Meta tag, Java code, SEO)..." style="flex: 1; border-color: rgba(251, 191, 36, 0.25); background: #070b13; margin-bottom: 0;" onkeypress="if(event.key==='Enter') sendMayaInlineMessage()">
            <button onclick="sendMayaInlineMessage()" id="maya-inline-send-btn" class="cyber-action-btn" style="background: #fbbf24; color: #000; font-weight: 850; padding: 12px 24px; min-width: 100px; height: 100%;">
                SEND ➔
            </button>
        </div>
    </div>

    <!-- Styles & Audio files -->
    <audio id="maya-tick-sound" src="https://assets.mixkit.co/active_storage/sfx/2568/2568-84.wav" preload="auto" volume="0.2"></audio>
    <audio id="maya-reply-sound" src="https://assets.mixkit.co/active_storage/sfx/2019/2019-84.wav" preload="auto" volume="0.3"></audio>

    <style>
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; filter: brightness(1.2); }
        }
        .maya-preset-chip {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            padding: 5px 12px;
            border-radius: 20px;
            color: #cbd5e0;
            font-size: 11px;
            cursor: pointer;
            font-family: 'Hind Siliguri', sans-serif;
            transition: 0.2s;
        }
        .maya-preset-chip:hover {
            border-color: #fbbf24;
            color: #fff;
            background: rgba(251, 191, 36, 0.08);
        }
        .copy-code-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fbbf24;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-family: sans-serif;
            transition: 0.2s;
        }
        .copy-code-btn:hover {
            background: #fbbf24;
            color: #000;
        }
    </style>

    <script>
        var mayaSoundEnabled = true;

        function toggleMayaSound() {
            mayaSoundEnabled = !mayaSoundEnabled;
            var btn = document.getElementById('maya-sound-btn');
            if (btn) {
                if (mayaSoundEnabled) {
                    btn.innerHTML = '🔊 SOUND ON';
                    btn.style.color = '#fbbf24';
                    playAudioSafely('maya-tick-sound');
                } else {
                    btn.innerHTML = '🔇 SOUND MUTED';
                    btn.style.color = '#9ca3af';
                }
            }
        }

        function playAudioSafely(id) {
            if (!mayaSoundEnabled) return;
            var audio = document.getElementById(id);
            if (audio) {
                audio.currentTime = 0;
                audio.play().catch(function(e){});
            }
        }

        function clearMayaChat() {
            var box = document.getElementById('maya-inline-chat-box');
            box.innerHTML = `
                <div class="maya-msg-wrapper" style="align-self: flex-start; max-width: 85%; display: flex; gap: 10px;">
                    <div style="width: 32px; height: 32px; background: rgba(251, 191, 36, 0.15); border: 1px solid #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; color: #fbbf24; font-weight: bold;">M</div>
                    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 0 16px 16px 16px; padding: 14px 16px; color: #cbd5e0; font-size: 13.5px; line-height: 1.6;" class="bangla-font-siliguri">
                        কনসোল মেমোরি রিসেট করা হয়েছে। মায়া পুনরায় আপনার প্রশ্নের উত্তর দেওয়ার জন্য প্রস্তুত! ✨
                    </div>
                </div>
            `;
            playAudioSafely('maya-tick-sound');
        }

        function selectSuggestedPrompt(txt) {
            var inp = document.getElementById('maya-inline-user-input');
            if (inp) {
                inp.value = txt;
                inp.focus();
                playAudioSafely('maya-tick-sound');
            }
        }

        function parseMayaMarkdown(text) {
            if (!text) return '';
            
            // Format HTML tags escaping to prevent injection
            let escaped = text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");

            // Format Code Blocks ```lang ... ```
            escaped = escaped.replace(/```(?:[a-zA-Z0-9]+)?\n([\s\S]*?)```/g, function(match, code) {
                return '<div style="position:relative; margin: 15px 0;"><pre style="background:#070b13; padding:15px; border-radius:8px; border:1px solid rgba(251,191,36,0.2); font-family:\'JetBrains Mono\', monospace; font-size:12px; color:#fbbf24; overflow-x:auto; line-height:1.5;"><button class="copy-code-btn" onclick="copyCodePayload(this)">COPY CODE</button><code>' + code.trim() + '</code></pre></div>';
            });

            // Inline codes `code`
            escaped = escaped.replace(/`([^`]+)`/g, '<code style="background:rgba(251,191,36,0.1); border:1px solid rgba(251,191,36,0.25); color:#fbbf24; padding:2px 6px; border-radius:4px; font-family:\'JetBrains Mono\', monospace; font-size:12px;">$1</code>');

            // Bold **text**
            escaped = escaped.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');

            // Bullet lists
            escaped = escaped.replace(/^\s*-\s+([^\n]+)/gm, '<li style="margin-left:15px; list-style-type:square; color:#cbd5e0;">$1</li>');
            escaped = escaped.replace(/^\s*\*\s+([^\n]+)/gm, '<li style="margin-left:15px; list-style-type:circle; color:#cbd5e0;">$1</li>');

            // Double line breaks
            escaped = escaped.replace(/\n\n/g, '<br><br>');
            // Single line breaks
            escaped = escaped.replace(/\n/g, '<br>');

            return escaped;
        }

        function copyCodePayload(btn) {
            var code = btn.nextElementSibling.innerText;
            navigator.clipboard.writeText(code);
            var prevText = btn.innerHTML;
            btn.innerHTML = '📋 COPIED!';
            btn.style.background = '#00ff41';
            btn.style.color = '#000';
            btn.style.borderColor = '#00ff41';
            setTimeout(function() {
                btn.innerHTML = prevText;
                btn.style.background = 'rgba(255, 255, 255, 0.1)';
                btn.style.color = '#fbbf24';
                btn.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            }, 1500);
        }

        function sendMayaInlineMessage() {
            var inp = document.getElementById('maya-inline-user-input');
            var val = inp.value.trim();
            if (!val) return;

            inp.value = '';
            playAudioSafely('maya-tick-sound');

            var box = document.getElementById('maya-inline-chat-box');

            // 1. Append User Message
            var userMsg = document.createElement('div');
            userMsg.style.alignSelf = 'flex-end';
            userMsg.style.maxWidth = '80%';
            userMsg.style.background = 'linear-gradient(135deg, #1e293b, #0f172a)';
            userMsg.style.border = '1px solid rgba(251, 191, 36, 0.1)';
            userMsg.style.borderRadius = '16px 16px 0 16px';
            userMsg.style.padding = '12px 16px';
            userMsg.style.color = '#fff';
            userMsg.style.fontSize = '13.5px';
            userMsg.style.lineHeight = '1.6';
            userMsg.className = 'bangla-font-siliguri';
            userMsg.textContent = val;
            box.appendChild(userMsg);

            // Scroll Box
            box.scrollTop = box.scrollHeight;

            // 2. Append Typing Indicator
            var typingIndicator = document.createElement('div');
            typingIndicator.className = 'maya-msg-wrapper typing-container';
            typingIndicator.style.alignSelf = 'flex-start';
            typingIndicator.style.maxWidth = '85%';
            typingIndicator.style.display = 'flex';
            typingIndicator.style.gap = '10px';
            typingIndicator.innerHTML = `
                <div style="width: 32px; height: 32px; background: rgba(251, 191, 36, 0.15); border: 1px solid #fbbf24; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; color: #fbbf24; font-weight: bold;">M</div>
                <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 0 16px 16px 16px; padding: 14px 16px; color: #9ca3af; font-size: 13.5px; font-family: 'JetBrains Mono', monospace;" class="bangla-font-siliguri">
                    ⚡ Connecting Maya Quantum Network... <span style="display:inline-block; width:15px; overflow:hidden; vertical-align:bottom; animation: loading-dots 1.5s infinite;">...</span>
                </div>
            `;
            box.appendChild(typingIndicator);
            box.scrollTop = box.scrollHeight;

            // Trigger Usage Stats Count
            if (typeof incrementToolUsage === 'function') {
                incrementToolUsage('ai-maya-cloud-assistant');
            }

            // Fire AJAX request to WP
            jQuery.ajax({
                url: '<?php echo esc_url($ajax_url); ?>',
                type: 'POST',
                data: {
                    action: 'cyber_bot_request',
                    user_query: val,
                    model: 'gemini-3.5-flash',
                    temperature: 0.7
                },
                success: function(response) {
                    // Remove Typing Indicator
                    if (typingIndicator.parentNode) {
                        typingIndicator.parentNode.removeChild(typingIndicator);
                    }

                    var replyText = (response && response.success) ? response.data : "দুঃখিত, সংযোগ স্থাপন করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।";
                    
                    // Create Response element
                    var replyMsg = document.createElement('div');
                    replyMsg.style.alignSelf = 'flex-start';
                    replyMsg.style.maxWidth = '85%';
                    replyMsg.style.display = 'flex';
                    replyMsg.style.gap = '10px';

                    var avatar = document.createElement('div');
                    avatar.style.width = '32px';
                    avatar.style.height = '32px';
                    avatar.style.background = 'rgba(251, 191, 36, 0.15)';
                    avatar.style.border = '1px solid #fbbf24';
                    avatar.style.borderRadius = '50%';
                    avatar.style.display = 'flex';
                    avatar.style.alignItems = 'center';
                    avatar.style.justifyContent = 'center';
                    avatar.style.fontSize = '14px';
                    avatar.style.flexShrink = '0';
                    avatar.style.color = '#fbbf24';
                    avatar.style.fontWeight = 'bold';
                    avatar.textContent = 'M';
                    replyMsg.appendChild(avatar);

                    var body = document.createElement('div');
                    body.style.background = 'rgba(30, 41, 59, 0.4)';
                    body.style.border = '1px solid rgba(255, 255, 255, 0.05)';
                    body.style.borderRadius = '0 16px 16px 16px';
                    body.style.padding = '14px 16px';
                    body.style.color = '#cbd5e0';
                    body.style.fontSize = '13.5px';
                    body.style.lineHeight = '1.6';
                    body.className = 'bangla-font-siliguri';
                    
                    replyMsg.appendChild(body);
                    box.appendChild(replyMsg);

                    // Typing effect
                    playAudioSafely('maya-reply-sound');
                    
                    var htmlFormatted = parseMayaMarkdown(replyText);
                    body.innerHTML = htmlFormatted;
                    
                    box.scrollTop = box.scrollHeight;
                },
                error: function() {
                    if (typingIndicator.parentNode) {
                        typingIndicator.parentNode.removeChild(typingIndicator);
                    }
                    alert('সার্ভার সংযোগ ব্যাহত হয়েছে। দয়া করে ইন্টারনেট কানেকশন চেক করুন।');
                }
            });
        }
    </script>

    <style>
        @keyframes loading-dots {
            0% { width: 0; }
            100% { width: 15px; }
        }
    </style>
    <?php
}

function ilybd_render_tool_ai_maya_assistant() {
    ilybd_render_tool_ai_maya_cloud_assistant();
}

// 12. Cyber Talking Pet Cat Game
function ilybd_render_tool_cyber_cat_game() {
    ?>
    <style>
    @keyframes bounce_cat {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-8px) scale(1.05); }
    }
    </style>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif; text-align:center;">
        <div style="font-size:64px; margin:20px 0; animation: bounce_cat 1.5s infinite; display: inline-block;" id="catVisual">🐈</div>
        
        <div id="catBubble" style="background:#04070c; border:1px solid #ec4899; padding:15px; border-radius:12px; color:#fff; font-size:14px; margin:20px auto; max-width:400px; min-height:55px; display:flex; align-items:center; justify-content:center;" class="bangla-font-siliguri">মিয়াও! আমি আপনার সাইবার ক্যাট। আমাকে আদর করুন বা খাওয়ান।</div>
        
        <div style="display:flex; gap:12px; max-width:400px; margin:0 auto 20px;">
            <button onclick="petCyberCat();" style="flex:1; padding:12px; background:#ec4899; color:#fff; border:none; border-radius:8px; font-weight:800; cursor:pointer;" class="bangla-font-siliguri">আদর করুন 👋</button>
            <button onclick="feedCyberCat();" style="flex:1; padding:12px; background:#00f0ff; color:#000; border:none; border-radius:8px; font-weight:800; cursor:pointer;" class="bangla-font-siliguri">খাদ্য দিন 🐟</button>
        </div>
    </div>
    <script>
    function petCyberCat() {
        const bubble = document.getElementById('catBubble');
        bubble.innerText = 'পুরররর! আপনার উষ্ণ স্পর্শে আমার ন্যানো চিপসেট হ্যাপি হয়েছে! 💖';
        document.getElementById('catVisual').innerText = '😻';
        setTimeout(() => {
            document.getElementById('catVisual').innerText = '🐈';
        }, 1200);
        if (typeof incrementToolUsage === 'function') {
            incrementToolUsage('cyber-cat-game');
        }
    }
    function feedCyberCat() {
        const bubble = document.getElementById('catBubble');
        bubble.innerText = 'ক্রাঞ্চ ক্রাঞ্চ! এআই ফিশ ক্র্যাকার অনেক সুস্বাদু ছিল! চার্জ ১০০%! 🔋⚡';
        document.getElementById('catVisual').innerText = '😸';
        setTimeout(() => {
            document.getElementById('catVisual').innerText = '🐈';
        }, 1200);
        if (typeof incrementToolUsage === 'function') {
            incrementToolUsage('cyber-cat-game');
        }
    }
    </script>
    <?php
}
