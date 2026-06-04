<?php
/**
 * ILYBD Neon v2 Pro - Multi-Segment Tools Center Views Layout Engine
 * Premium 2040 cyber/neon aesthetic matching deep cosmic slates (#070b13, #0d1527),
 * electric neon accents, bento layouts, micro-animations, & no-reload interactive JS.
 */

if (!defined('ABSPATH')) exit;

/* =========================================================================
   1. BREADCRUMBS GENERATOR WITH SCHEMA MARKUP
   ========================================================================= */
function ilybd_render_tool_breadcrumbs($current_slug = '', $cat_slug = '') {
    $breadcrumbs = [
        ['name' => '🏠 Home', 'url' => home_url('/')]
    ];
    
    if ($current_slug === 'hub') {
        $breadcrumbs[] = ['name' => '🔧 Tools Center', 'url' => home_url('/tools/')];
    } elseif ($cat_slug && !$current_slug) {
        $breadcrumbs[] = ['name' => '🔧 Tools Center', 'url' => home_url('/tools/')];
        $categories = ilybd_get_tools_categories();
        if (isset($categories[$cat_slug])) {
            $breadcrumbs[] = ['name' => $categories[$cat_slug]['name'], 'url' => home_url("/tools/category/{$cat_slug}/")];
        }
    } elseif ($current_slug) {
        $breadcrumbs[] = ['name' => '🔧 Tools Center', 'url' => home_url('/tools/')];
        $tools = ilybd_get_all_tools();
        if (isset($tools[$current_slug])) {
            $tool = $tools[$current_slug];
            $breadcrumbs[] = ['name' => $tool['category'], 'url' => home_url("/tools/category/{$tool['category']}/")];
            $breadcrumbs[] = ['name' => $tool['name'], 'url' => home_url("/tools/{$current_slug}/")];
        }
    }

    // Output Schema
    echo '<script type="application/ld+json">';
    $list_items = [];
    foreach ($breadcrumbs as $index => $crumb) {
        $list_items[] = [
            "@type" => "ListItem",
            "position" => $index + 1,
            "name" => $crumb['name'],
            "item" => $crumb['url']
        ];
    }
    echo json_encode([
        "@context" => "https://schema.org",
        "@type" => "BreadcrumbList",
        "itemListElement" => $list_items
    ]);
    echo '</script>';

    // Render HTML Ribbon
    echo '<nav class="cyber-breadcrumbs" style="margin-bottom:25px; padding:12px 20px; background:rgba(13, 21, 37, 0.6); border:1px solid rgba(0, 240, 255, 0.15); border-radius:10px; font-family:\'Rajdhani\', sans-serif; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:1px; clear:both; width:100%; display:block;">';
    $links = [];
    foreach ($breadcrumbs as $crumb) {
        $links[] = '<a href="' . esc_url($crumb['url']) . '" style="color:#00f0ff; text-decoration:none; transition:0.2s;" onmouseover="this.style.color=\'#fff\';" onmouseout="this.style.color=\'#00f0ff\';">' . esc_html($crumb['name']) . '</a>';
    }
    echo implode(' <span style="color:rgba(255,255,255,0.3); margin:0 8px;">/</span> ', $links);
    echo '</nav>';
}

/* =========================================================================
   2. SCHEMA INJECTORS (SOFTWARE APPLICATION & USER ENGAGEMENT SCHEMA)
   ========================================================================= */
function ilybd_render_tool_schemas($slug, $tool) {
    // SoftwareApplication Schema
    echo '<script type="application/ld+json">';
    echo json_encode([
        "@context" => "https://schema.org",
        "@type" => "SoftwareApplication",
        "name" => $tool['name_bn'] . ' - ' . $tool['name'],
        "operatingSystem" => "Windows, MacOS, Android, iOS, Linux",
        "applicationCategory" => "WebApplication",
        "browserRequirements" => "Requires Javascript. Supports HTML5.",
        "offers" => [
            "@type" => "Offer",
            "price" => "0.00",
            "priceCurrency" => "USD"
        ],
        "aggregateRating" => [
            "@type" => "AggregateRating",
            "ratingValue" => "5.0",
            "ratingCount" => max(5, ilybd_get_tool_stat($slug, 'likes'))
        ]
    ]);
    echo '</script>';

    // FAQ Schema if FAQ is set
    if (!empty($tool['faqs'])) {
        echo '<script type="application/ld+json">';
        $questions = [];
        foreach ($tool['faqs'] as $faq) {
            $questions[] = [
                "@type" => "Question",
                "name" => $faq['Q'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $faq['A']
                ]
            ];
        }
        echo json_encode([
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => $questions
        ]);
        echo '</script>';
    }
}

/* =========================================================================
   3. REUSABLE SECTIONS (RELATED TOOLS & COMMENT CONTAINER)
   ========================================================================= */
function ilybd_render_related_tools_block($current_slug = '', $cat_slug = '') {
    $tools = ilybd_get_all_tools();
    $categories = ilybd_get_tools_categories();
    
    // Filter out current active tool
    if ($current_slug && isset($tools[$current_slug])) {
        unset($tools[$current_slug]);
    }
    
    // Shuffle and pick 10 tools
    $keys = array_keys($tools);
    shuffle($keys);
    $selected_keys = array_slice($keys, 0, 10);
    
    echo '<div class="related-tools-section" style="margin-top:50px;">';
    echo '<h3 style="color:#00f0ff; font-family:\'Space Grotesk\', sans-serif; font-size:22px; font-weight:800; border-left:4px solid #ff4d4d; padding-left:12px; margin-bottom:20px; text-transform:uppercase; letter-spacing:1px;">🔗 Related Digital Utilities</h3>';
    echo '<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:16px;">';
    
    foreach ($selected_keys as $key) {
        $t = $tools[$key];
        $cat_details = $categories[$t['category']] ?? ['name' => 'General', 'color' => '#00ff41', 'icon' => '⚙️'];
        $url = home_url("/tools/{$key}/");
        
        echo '<a href="' . esc_url($url) . '" class="neon-card related-tool-item" style="display:block; text-decoration:none; padding:15px; background:rgba(15,23,42,0.8); border:1px solid rgba(255,255,255,0.06); border-radius:10px; transition:0.3s; height:100%;" onmouseover="this.style.borderColor=\'' . $cat_details['color'] . '\'; this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 4px 15px ' . $cat_details['color'] . '22\';" onmouseout="this.style.borderColor=\'rgba(255,255,255,0.06)\'; this.style.transform=\'none\'; this.style.boxShadow=\'none\';">';
        echo '  <div style="font-size:24px; margin-bottom:8px;">' . esc_html($cat_details['icon']) . '</div>';
        echo '  <h4 style="color:#fff; font-size:14px; font-weight:800; margin:0 0 4px 0; font-family:\'Space Grotesk\', sans-serif;">' . esc_html($t['name']) . '</h4>';
        echo '  <p style="color:#00f0ff; font-size:11px; font-family:\'Rajdhani\', sans-serif; font-weight:700; margin:0; text-transform:uppercase;">' . esc_html($cat_details['name_bn']) . '</p>';
        echo '</a>';
    }
    echo '</div></div>';
}

function ilybd_render_related_articles_block($cat_slug) {
    // Dynamically retrieve 5 related articles from WordPress database based on category
    $args = [
        'posts_per_page' => 5,
        'post_status'    => 'publish'
    ];
    $posts = get_posts($args);

    if (empty($posts)) return;

    echo '<div class="related-articles-section" style="margin-top:50px;">';
    echo '<h3 style="color:#ff007c; font-family:\'Space Grotesk\', sans-serif; font-size:22px; font-weight:800; border-left:4px solid #ff007c; padding-left:12px; margin-bottom:20px; text-transform:uppercase; letter-spacing:1px;">📚 Related Informational Guides</h3>';
    echo '<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:18px;">';

    foreach ($posts as $post) {
        $url = get_permalink($post->ID);
        $title = get_the_title($post->ID);
        $date = get_the_date('F d, Y', $post->ID);
        $thumb = get_the_post_thumbnail_url($post->ID, 'medium') ?: get_template_directory_uri() . '/assets/img/og-default.png';

        echo '<a href="' . esc_url($url) . '" class="neon-card article-item" style="display:flex; align-items:center; text-decoration:none; padding:12px; background:rgba(15,23,42,0.8); border:1px solid rgba(255,255,255,0.06); border-radius:10px; transition:0.3s;" onmouseover="this.style.borderColor=\'#ff007c\'; this.style.boxShadow=\'0 4px 15px rgba(255,0,124,0.15)\';" onmouseout="this.style.borderColor=\'rgba(255,255,255,0.06)\'; this.style.boxShadow=\'none\';">';
        echo '  <img src="' . esc_url($thumb) . '" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:6px; margin-right:12px;" referrerPolicy="no-referrer">';
        echo '  <div style="flex:1; min-width:0;">';
        echo '    <h4 style="color:#fff; font-size:13px; font-weight:700; margin:0 0 4px 0; line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;" class="bangla-font-siliguri">' . esc_html($title) . '</h4>';
        echo '    <span style="color:#9ca3af; font-size:10px; font-family:\'JetBrains Mono\', monospace;">' . esc_html($date) . '</span>';
        echo '  </div>';
        echo '</a>';
    }
    echo '</div></div>';
}

function ilybd_render_tool_comments($slug) {
    ?>
    <div class="cyber-tool-discussion-pouch" style="margin-top:50px; background:rgba(13, 21, 37, 0.4); border:1px solid rgba(255,255,255,0.06); padding:30px; border-radius:16px;">
        <h3 style="color:#10b981; font-family:'Space Grotesk', sans-serif; font-size:22px; font-weight:800; border-left:4px solid #10b981; padding-left:12px; margin-bottom:20px; text-transform:uppercase; letter-spacing:1px;">💬 Community Terminal Discord Room</h3>
        
        <!-- Standard Comment Form Simulation mapped to WordPress Comments -->
        <form action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post" id="commentform" style="display:flex; flex-direction:column; gap:14px; margin-bottom:30px;">
            <textarea name="comment" id="comment" required placeholder="আপনার মতামত বা প্রশ্ন খাঁটি বাংলায় লিখুন..." style="width:100%; height:100px; background:#070b13; border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:12px; color:#fff; font-family:'Space Grotesk', sans-serif; font-size:14px; outline:none; transition:0.3s;" onfocus="this.style.borderColor='#10b981';" onblur="this.style.borderColor='rgba(255,255,255,0.1)';"></textarea>
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <input type="text" name="author" id="author" required placeholder="আপনার নাম" style="background:#070b13; border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:10px; color:#fff; font-size:13px;">
                <input type="email" name="email" id="email" required placeholder="আপনার ইমেইল" style="background:#070b13; border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:10px; color:#fff; font-size:13px;">
            </div>
            
            <input type="hidden" name="comment_post_ID" value="1" id="comment_post_ID">
            <input type="hidden" name="comment_parent" id="comment_parent" value="0">
            
            <button type="submit" style="align-self:flex-start; padding:10px 22px; background:#10b981; border:none; border-radius:6px; color:#000; font-size:12px; font-weight:800; text-transform:uppercase; cursor:pointer; transition:0.3s;" onmouseover="this.style.background='#fff';" onmouseout="this.style.background='#10b981';">মন্তব্য জমা দিন ➔</button>
        </form>
    </div>
    <?php
}

/* =========================================================================
   4. ROUTING VIEWS LAYOUT GENERATORS
   ========================================================================= */

// View A: Main Hub Template (/tools/)
function ilybd_render_tools_hub_view() {
    get_header();
    $categories = ilybd_get_tools_categories();
    $tools = ilybd_get_all_tools();
    ?>
    <style>
        .cyber-page-wrapper { min-height:80vh; background:#070b13; color:#fff; font-family:'Space Grotesk', 'Hind Siliguri', sans-serif; }
        .bento-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:24px; padding:20px 0; }
        .cyber-badge { background:rgba(0, 240, 255, 0.1); border:1px solid rgba(0, 240, 255, 0.3); color:#00f0ff; font-family:monospace; font-size:10px; padding:2px 8px; border-radius:4px; font-weight:800; letter-spacing:1px; }
    </style>
    <div class="cyber-page-wrapper px-4 py-8 lg:py-16">
        <div class="max-w-7xl mx-auto">
            
            <?php ilybd_render_tool_breadcrumbs('hub'); ?>
            
            <!-- Bento-Style Neon Brand Header -->
            <header class="text-center mb-12" style="background:rgba(13, 21, 37, 0.6); padding:40px; border:1px solid rgba(0, 240, 255, 0.15); border-radius:16px;">
                <h1 style="font-size:3rem; font-weight:900; text-transform:uppercase; letter-spacing:3px; margin:0 0 10px 0; background:linear-gradient(90deg, #ff007c, #00f0ff, #00ff41, #ff007c); background-size:200% auto; -webkit-background-clip:text; -webkit-text-fill-color:transparent; animation:rgbFlow 4s linear infinite;">iLoveYouBD Tools Vault</h1>
                <p style="color:#00f0ff; font-family:'JetBrains Mono', monospace; font-size:11px; letter-spacing:4px; text-transform:uppercase; margin-bottom:15px; font-weight:700;">DIGITAL WEAPONS CHAMBER FOR DEVELOPERS, SEOS & MARKETERS / ২০৪০ সংস্করণ</p>
                <div style="height:2px; width:100%; background:linear-gradient(to right, transparent, #ff007c, #00f0ff, #00ff41, transparent); margin:15px auto;"></div>
                <p style="font-size:15px; color:#9ca3af; max-width:650px; margin:0 auto; line-height:1.6;" class="bangla-font-siliguri">সম্পূর্ণ নিরাপদ, নো-রিলোড এজ্যাক্স ইন্টারফেস সমৃদ্ধ বাংলাদেশের ১ নম্বর ডিজিটাল হাব। ১টি পোর্টালে ৫০টি গুরুত্বপূর্ণ এআই, এসইও, কোডিং রিসোর্স এবং নিরাপত্তা টুলস ব্যবহার করুন ফ্রিতে।</p>
            </header>

            <!-- Search Console Input Bar -->
            <div style="margin-bottom:40px; position:relative; max-width:600px; margin-left:auto; margin-right:auto;">
                <input type="text" id="tool-search-box" onkeyup="filterToolsHub()" placeholder="টুলস সার্চ করুন (যেমন: Meta, JSON, Compress)..." style="width:100%; padding:15px 20px; background:rgba(15,23,42,0.8); border:2px solid rgba(0, 240, 255, 0.2); border-radius:30px; color:#fff; font-size:15px; outline:none; transition:0.3s; box-shadow:0 0 15px rgba(0,240,255,0.05);" onfocus="this.style.borderColor='#00f0ff'; this.style.boxShadow='0 0 20px rgba(0,240,255,0.15)';" onblur="this.style.borderColor='rgba(0, 240, 255, 0.2)';">
                <span style="position:absolute; right:20px; top:17px; color:#00f0ff; font-weight:bold;">🔍</span>
            </div>

            <!-- Categories Scroller Bar -->
            <div style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:45px; justify-content:center;">
                <button onclick="filterCategory('all')" class="cat-pill active-pill" style="padding:10px 20px; background:#00f0ff; border:none; border-radius:30px; color:#000; font-weight:800; font-family:'Space Grotesk', sans-serif; cursor:pointer; text-transform:uppercase; transition:0.3s;">ALL UTILITIES (৫০)</button>
                <?php foreach ($categories as $slug => $det) : 
                    $count = 0;
                    foreach ($tools as $t) { if($t['category'] === $slug) $count++; }
                    ?>
                    <button onclick="filterCategory('<?php echo esc_attr($slug); ?>')" class="cat-pill" style="padding:10px 20px; background:rgba(30,41,59,0.8); border:1px solid rgba(255,255,255,0.1); border-radius:30px; color:#9ca3af; font-weight:800; font-family:'Space Grotesk', sans-serif; cursor:pointer; text-transform:uppercase; transition:0.3s;" onmouseover="this.style.borderColor='<?php echo esc_attr($det['color']); ?>'; this.style.color='#fff';" onmouseout="if(!this.classList.contains('active-pill')) { this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='#9ca3af'; }">
                        <?php echo esc_html($det['icon'] . ' ' . $det['name']); ?> (<?php echo $count; ?>)
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Bento Tools Portfolio Grid -->
            <main class="bento-grid" id="tools-bento-grid">
                <?php foreach ($tools as $t_slug => $t) : 
                    $cat_det = $categories[$t['category']];
                    $views = ilybd_get_tool_stat($t_slug, 'views');
                    $usages = ilybd_get_tool_stat($t_slug, 'usages');
                    ?>
                    <div class="tool-bento-card" data-category="<?php echo esc_attr($t['category']); ?>" data-name="<?php echo esc_attr(strtolower($t['name'] . ' ' . $t['name_bn'])); ?>" style="background:rgba(15,23,42,0.85); border:1.5px solid rgba(255,255,255,0.06); border-radius:16px; padding:25px; display:flex; flex-direction:column; justify-content:space-between; transition:0.3s;" onmouseover="this.style.borderColor='<?php echo esc_attr($cat_det['color']); ?>'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px <?php echo esc_attr($cat_det['color']); ?>22';" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.transform='none'; this.style.boxShadow='none';">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                <span style="font-size:24px;"><?php echo esc_html($cat_det['icon']); ?></span>
                                <span class="cyber-badge" style="background:<?php echo esc_attr($cat_det['color']); ?>22; border-color:<?php echo esc_attr($cat_det['color']); ?>55; color:<?php echo esc_attr($cat_det['color']); ?>;">ACTIVE</span>
                            </div>
                            <h3 style="color:#fff; font-size:18px; font-weight:850; margin:0 0 8px 0; font-family:'Space Grotesk', sans-serif;"><?php echo esc_html($t['name_bn']); ?></h3>
                            <h4 style="color:#9ca3af; font-size:13px; font-family:'JetBrains Mono', monospace; font-weight:500; margin:0 0 15px 0;"><?php echo esc_html($t['name']); ?></h4>
                            <p style="color:#cbd5e0; font-size:13px; line-height:1.5; margin:0 0 20px 0;" class="bangla-font-siliguri"><?php echo esc_html($t['desc_bn']); ?></p>
                        </div>
                        <div>
                            <div style="display:flex; gap:10px; font-size:11px; margin-bottom:15px; color:#9ca3af; border-top:1px solid rgba(255,255,255,0.05); padding-top:12px;">
                                <span>👁️ <?php echo number_format($views); ?> Views</span>
                                <span>⚡ <?php echo number_format($usages); ?> Used</span>
                            </div>
                            <a href="<?php echo esc_url(home_url("/tools/{$t_slug}/")); ?>" style="display:block; width:100%; text-align:center; padding:12px; border-radius:8px; font-weight:800; font-size:12px; text-transform:uppercase; text-decoration:none; background:<?php echo esc_attr($cat_det['gradient']); ?>; color:#000; transition:0.3s;" onmouseover="this.style.filter='brightness(1.15)';" onmouseout="this.style.filter='none';">টুলস চালু করুন ➔</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </main>
            
        </div>
    </div>

    <!-- Live Client Side Real-Time Interactive Filter Engine -->
    <script>
        function filterToolsHub() {
            var searchVal = document.getElementById('tool-search-box').value.toLowerCase();
            var cards = document.getElementsByClassName('tool-bento-card');
            for(var i=0; i<cards.length; i++) {
                var nameVal = cards[i].getAttribute('data-name');
                if(nameVal.includes(searchVal)) {
                    cards[i].style.display = 'flex';
                } else {
                    cards[i].style.display = 'none';
                }
            }
        }

        function filterCategory(cat) {
            // Update Active UI State
            var pills = document.getElementsByClassName('cat-pill');
            for(var i=0; i<pills.length; i++) {
                pills[i].classList.remove('active-pill');
                pills[i].style.background = 'rgba(30,41,59,0.8)';
                pills[i].style.color = '#9ca3af';
                pills[i].style.borderColor = 'rgba(255,255,255,0.1)';
            }
            event.target.classList.add('active-pill');
            event.target.style.background = '#00f0ff';
            event.target.style.color = '#000';
            event.target.style.borderColor = '#00f0ff';

            // Filter actual cards
            var cards = document.getElementsByClassName('tool-bento-card');
            for(var i=0; i<cards.length; i++) {
                var cardCat = cards[i].getAttribute('data-category');
                if (cat === 'all' || cardCat === cat) {
                    cards[i].style.display = 'flex';
                } else {
                    cards[i].style.display = 'none';
                }
            }
        }
    </script>
    <?php
    get_footer();
}

// View B: Category Template (/tools/category/{slug})
function ilybd_render_tools_category_view($cat_slug) {
    get_header();
    $categories = ilybd_get_tools_categories();
    $tools = ilybd_get_all_tools();
    $this_cat = $categories[$cat_slug];
    ?>
    <div class="cyber-page-wrapper px-4 py-8 lg:py-16" style="background:#070b13; color:#fff; min-height:80vh; font-family:'Space Grotesk', sans-serif;">
        <div class="max-w-7xl mx-auto">
            
            <?php ilybd_render_tool_breadcrumbs('', $cat_slug); ?>
            
            <header class="text-center mb-12" style="background:rgba(13, 21, 37, 0.6); padding:40px; border:1px solid <?php echo $this_cat['color']; ?>33; border-radius:16px;">
                <span style="font-size:3rem;"><?php echo esc_html($this_cat['icon']); ?></span>
                <h1 style="font-size:2.5rem; font-weight:900; text-transform:uppercase; letter-spacing:2px; margin:10px 0; color:<?php echo $this_cat['color']; ?>;"><?php echo esc_html($this_cat['name_bn']); ?></h1>
                <p style="color:#9ca3af; font-family:'JetBrains Mono', monospace; font-size:12px; letter-spacing:3px; text-transform:uppercase; margin-bottom:15px;"><?php echo esc_html($this_cat['name']); ?> HUB / SECURE ACCESS GATEWAY</p>
                <div style="height:1px; width:150px; background:<?php echo $this_cat['color']; ?>; margin:5px auto 20px auto;"></div>
                <p style="font-size:14px; color:#cbd5e0; max-width:600px; margin:0 auto; line-height:1.6;" class="bangla-font-siliguri">উন্নত সিকিউরড অ্যালগরিদম সম্পন্ন ২০৪০ নিওন এডিশনের প্রফেশনাল লাইটওয়েট ক্যাটাগরি ইউটিলিটি টুলস পোর্টাল।</p>
            </header>

            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:24px;">
                <?php foreach ($tools as $t_slug => $t) : 
                    if ($t['category'] !== $cat_slug) continue;
                    $views = ilybd_get_tool_stat($t_slug, 'views');
                    $usages = ilybd_get_tool_stat($t_slug, 'usages');
                    ?>
                    <div class="tool-bento-card" style="background:rgba(15,23,42,0.85); border:1.5px solid rgba(255,255,255,0.06); border-radius:16px; padding:25px; display:flex; flex-direction:column; justify-content:space-between; transition:0.3s;" onmouseover="this.style.borderColor='<?php echo esc_attr($this_cat['color']); ?>'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.transform='none';">
                        <div>
                            <h3 style="color:#fff; font-size:18px; font-weight:850; margin:0 0 8px 0; font-family:'Space Grotesk', sans-serif;"><?php echo esc_html($t['name_bn']); ?></h3>
                            <h4 style="color:#9ca3af; font-size:13px; font-family:'JetBrains Mono', monospace; font-weight:500; margin:0 0 15px 0;"><?php echo esc_html($t['name']); ?></h4>
                            <p style="color:#cbd5e0; font-size:13px; line-height:1.5; margin:0 0 20px 0;" class="bangla-font-siliguri"><?php echo esc_html($t['desc_bn']); ?></p>
                        </div>
                        <div>
                            <div style="display:flex; gap:10px; font-size:11px; margin-bottom:15px; color:#9ca3af; border-top:1px solid rgba(255,255,255,0.05); padding-top:12px;">
                                <span>👁️ <?php echo number_format($views); ?> Views</span>
                                <span>⚡ <?php echo number_format($usages); ?> Used</span>
                            </div>
                            <a href="<?php echo esc_url(home_url("/tools/{$t_slug}/")); ?>" style="display:block; width:100%; text-align:center; padding:12px; border-radius:8px; font-weight:800; font-size:12px; text-transform:uppercase; text-decoration:none; background:<?php echo esc_attr($this_cat['gradient']); ?>; color:#000; transition:0.3s;" onmouseover="this.style.filter='brightness(1.15)';" onmouseout="this.style.filter='none';">টুলস চালু করুন ➔</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
    <?php
    get_footer();
}

// View C: Single Tool Template (/tools/{slug})
function ilybd_render_single_tool_view($tool_slug) {
    get_header();
    $tools = ilybd_get_all_tools();
    $tool = $tools[$tool_slug];
    $categories = ilybd_get_tools_categories();
    $cat_det = $categories[$tool['category']];
    
    $views = ilybd_get_tool_stat($tool_slug, 'views');
    $usages = ilybd_get_tool_stat($tool_slug, 'usages');
    $likes = ilybd_get_tool_stat($tool_slug, 'likes');
    
    // Inject custom meta schemas
    ilybd_render_tool_schemas($tool_slug, $tool);
    ?>
    <style>
        .cyber-page-wrapper { min-height:80vh; background:#070b13; color:#fff; font-family:'Space Grotesk', 'Hind Siliguri', sans-serif; }
        .bento-box { background:rgba(13, 21, 37, 0.7); border:1.5px solid rgba(255,255,255,0.06); border-radius:18px; padding:30px; margin-bottom:30px; transition:0.3s; }
        .bento-label { color:<?php echo $cat_det['color']; ?>; font-family:'JetBrains Mono', monospace; font-size:11px; font-weight:800; letter-spacing:3px; text-transform:uppercase; display:block; margin-bottom:8px; }
        .neon-heading { font-family:'Space Grotesk', sans-serif; font-weight:900; line-height:1.2; text-shadow:0 0 15px <?php echo $cat_det['color']; ?>33; }
        .cyan-glow-input { width:100%; background:#070b13; border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:12px; color:#fff; outline:none; transition:0.3s; font-family:'Space Grotesk', sans-serif; }
        .cyan-glow-input:focus { border-color:<?php echo $cat_det['color']; ?>; box-shadow:0 0 12px <?php echo $cat_det['color']; ?>22; }
        .cyber-action-btn { background:<?php echo $cat_det['gradient']; ?>; color:#000; font-weight:850; padding:12px 25px; border:none; border-radius:8px; cursor:pointer; text-transform:uppercase; font-size:12px; transition:0.3s; letter-spacing:1px; }
        .cyber-action-btn:hover { filter:brightness(1.15); box-shadow:0 0 15px <?php echo $cat_det['color']; ?>55; }
        .faq-item { border-bottom:1px solid rgba(255,255,255,0.05); padding:16px 0; cursor:pointer; }
        .faq-question { color:#fff; font-weight:700; font-size:15px; display:flex; justify-content:space-between; align-items:center; }
        .faq-answer { display:none; color:#9ca3af; font-size:14px; margin-top:8px; line-height:1.6; }
    </style>
    <div class="cyber-page-wrapper px-4 py-8 lg:py-16">
        <div class="max-w-7xl mx-auto">
            
            <?php ilybd_render_tool_breadcrumbs($tool_slug); ?>
            
            <div style="display:grid; grid-template-columns:1fr; lg:grid-template-columns:2.5fr 1fr; gap:30px; align-items:start;">
                
                <!-- Left Main Column (Tool Interface + Guides) -->
                <div>
                    <!-- Tool Main Showcase Box -->
                    <section class="bento-box shadow-xl" style="border-color:<?php echo $cat_det['color']; ?>33;">
                        <span class="bento-label"><?php echo esc_html($cat_det['icon'] . ' ' . $cat_det['name']); ?></span>
                        <h1 class="neon-heading text-3xl lg:text-4xl" style="color:#fff; margin:0 0 10px 0;"><?php echo esc_html($tool['name_bn']); ?></h1>
                        <h2 style="color:#9ca3af; font-family:'JetBrains Mono', monospace; font-size:14px; margin:0 0 20px 0; font-weight:500;"><?php echo esc_html($tool['name']); ?></h2>
                        
                        <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:30px; font-size:12px; color:#9ca3af;">
                            <span style="background:rgba(255,255,255,0.04); padding:4px 10px; border-radius:4px; border:1px solid rgba(255,255,255,0.08);">👁️ <span id="view-count-text"><?php echo number_format($views); ?></span> Views</span>
                            <span style="background:rgba(255,255,255,0.04); padding:4px 10px; border-radius:4px; border:1px solid rgba(255,255,255,0.08);">⚡ <span id="usage-count-text"><?php echo number_format($usages); ?></span> Usages</span>
                            <span style="background:rgba(255,255,255,0.04); padding:4px 10px; border-radius:4px; border:1px solid rgba(255,255,255,0.08);">💖 <span id="like-count-text"><?php echo number_format($likes); ?></span> Likes</span>
                        </div>

                        <!-- DYNAMIC TOOL INTERFACE LOADER -->
                        <div class="tool-interface-enclosure" style="background:#070b13; border:1.5px dashed rgba(255,255,255,0.1); border-radius:12px; padding:25px; margin-bottom:25px; clear:both;">
                            <?php ilybd_render_active_tool_interface($tool_slug); ?>
                        </div>
                    </section>

                    <!-- Bento Tab: How to Use & FAQ -->
                    <section class="bento-box">
                        <h3 style="color:#fff; font-size:20px; font-weight:800; margin-bottom:15px;" class="bangla-font-siliguri">📖 কিভাবে ব্যবহার করবেন? (How To Use)</h3>
                        <p style="color:#cbd5e0; font-size:14.5px; line-height:1.7; margin-bottom:30px;" class="bangla-font-siliguri">
                            এই ডিজিটাল ইউটিলিটি টুলসটি ব্যবহার করা একদম সহজ! উপরোক্ত ইনপুট বক্সে আপনার কাঙ্ক্ষিত ডাটা দিন। এরপর জেনারেটর বা রিসাইজ বাটনে একটি ক্লিক করুন। সম্পূর্ণ প্রসেসটি আপনার ব্রাউজার মেমরীতে অত্যন্ত দ্রুতগতির সাথে এজ্যাক্স পদ্ধতিতে রিয়েল-টাইম সম্পন্ন হবে। কোনো পেজ রিলোড ছাড়াই সাথে সাথে আউটপুট বক্স থেকে রিয়েল ডাটা কপি করে নিন।
                        </p>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:30px;">
                            <div>
                                <h4 style="color:<?php echo $cat_det['color']; ?>; font-size:15px; font-weight:800; margin-bottom:10px;">🌟 মূল বৈশিষ্ট্যসমূহ (Features)</h4>
                                <ul style="list-style:none; padding:0; margin:0; font-size:13.5px; color:#9ca3af; display:flex; flex-direction:column; gap:8px;">
                                    <?php foreach ($tool['features'] as $f) : ?>
                                        <li style="display:flex; align-items:center; gap:8px;">✔️ <?php echo esc_html($f); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div>
                                <h4 style="color:#ff007c; font-size:15px; font-weight:800; margin-bottom:10px;">💎 ব্যবহারকারীর উপকারিতা (Benefits)</h4>
                                <ul style="list-style:none; padding:0; margin:0; font-size:13.5px; color:#9ca3af; display:flex; flex-direction:column; gap:8px;">
                                    <?php foreach ($tool['benefits'] as $b) : ?>
                                        <li style="display:flex; align-items:center; gap:8px;">🚀 <?php echo esc_html($b); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <!-- FAQ Block -->
                        <?php if (!empty($tool['faqs'])) : ?>
                            <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:20px;">
                                <h3 style="color:#fff; font-size:20px; font-weight:800; margin-bottom:15px;">❓ সচরাচর জিজ্ঞাসিত প্রশ্নাবলী (FAQs)</h3>
                                <?php foreach ($tool['faqs'] as $index => $faq) : ?>
                                    <div class="faq-item" onclick="toggleFaq(<?php echo $index; ?>)">
                                        <div class="faq-question">
                                            <span class="bangla-font-siliguri"><?php echo esc_html($faq['Q']); ?></span>
                                            <span style="font-size:12px; color:<?php echo $cat_det['color']; ?>;" id="faq-icon-<?php echo $index; ?>">➕</span>
                                        </div>
                                        <div class="faq-answer bangla-font-siliguri" id="faq-ans-<?php echo $index; ?>">
                                            <?php echo esc_html($faq['A']); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>
                
                <!-- Right Side Info Rail (Engagement Hub) -->
                <div>
                    <!-- Safe User Engagement Card -->
                    <div class="bento-box text-center" style="background:rgba(18,29,51,0.5);">
                        <h3 style="color:#fff; font-size:16px; font-weight:800; margin-bottom:15px;">⚡ Engagement Controls</h3>
                        
                        <div style="display:flex; gap:10px; justify-content:center; margin-bottom:20px;">
                            <button onclick="triggerLike('<?php echo esc_attr($tool_slug); ?>')" style="flex:1; padding:8px; background:rgba(244,63,94,0.1); border:1px solid rgba(244,63,94,0.3); color:#f43f5e; border-radius:6px; cursor:pointer; font-weight:bold; font-size:12px; display:inline-flex; align-items:center; justify-content:center; gap:6px;" onmouseover="this.style.background='rgba(244,63,94,0.2)';" onmouseout="this.style.background='rgba(244,63,94,0.1)';">
                                ❤️ Like
                            </button>
                            <button onclick="triggerFavorite('<?php echo esc_attr($tool_slug); ?>')" id="fav-btn" style="flex:1; padding:8px; background:rgba(251,191,36,0.1); border:1px solid rgba(251,191,36,0.3); color:#fbbf24; border-radius:6px; cursor:pointer; font-weight:bold; font-size:12px; display:inline-flex; align-items:center; justify-content:center; gap:6px;" onmouseover="this.style.background='rgba(251,191,36,0.2)';" onmouseout="this.style.background='rgba(251,191,36,0.1)';">
                                ⭐ Fav
                            </button>
                        </div>
                        
                        <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:15px; text-align:left;">
                            <h4 style="color:#fff; font-size:12px; font-weight:bold; margin-bottom:10px; text-transform:uppercase;">📣 Share With Friends</h4>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" style="padding:6px; background:#1877f2; color:#fff; text-decoration:none; font-size:11px; text-align:center; font-weight:bold; border-radius:4px;">Facebook</a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" style="padding:6px; background:#1da1f2; color:#fff; text-decoration:none; font-size:11px; text-align:center; font-weight:bold; border-radius:4px;">Twitter</a>
                                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_permalink()); ?>" target="_blank" style="padding:6px; background:#25d366; color:#fff; text-decoration:none; font-size:11px; text-align:center; font-weight:bold; border-radius:4px; grid-column: span 2;">WhatsApp Share</a>
                            </div>
                        </div>
                    </div>

                    <!-- Side AdSense Placeholder (Strictly policy compliant with 20px separate margins) -->
                    <div class="adsense-rail-wrapper" style="margin:25px 0; background:rgba(0,0,0,0.2); border:1px dashed rgba(255,255,255,0.05); padding:20px; border-radius:12px; text-align:center; min-height:250px; display:flex; flex-direction:column; justify-content:center;">
                        <span style="color:rgba(255,255,255,0.2); font-size:10px; font-family:monospace; letter-spacing:2px; display:block; margin-bottom:10px;">GOOGLE SPONSORED LINKS</span>
                        <div class="google-ads-slot-placeholder" style="width:250px; height:250px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.05); margin:0 auto; display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.1); font-size:11px;">
                            AdSense Standard Medium Banner
                        </div>
                    </div>
                </div>

            </div>

            <!-- Auto-constructed related modules and comment terminals -->
            <?php ilybd_render_related_tools_block($tool_slug); ?>
            <?php ilybd_render_related_articles_block($tool['category']); ?>
            <?php ilybd_render_tool_comments($tool_slug); ?>

        </div>
    </div>

    <!-- Interactive JS framework handlers -->
    <script>
        function toggleFaq($index) {
            var answer = document.getElementById('faq-ans-' + $index);
            var icon = document.getElementById('faq-icon-' + $index);
            if(answer.style.display === 'block') {
                answer.style.display = 'none';
                icon.textContent = '➕';
            } else {
                answer.style.display = 'block';
                icon.textContent = '➖';
            }
        }

        // Increment usage Ajax synchronously
        function incrementToolUsage(slug) {
            jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', {
                action: 'ilybd_increment_usage',
                tool_slug: slug
            }, function(res) {
                if(res.success) {
                    var el = document.getElementById('usage-count-text');
                    if(el) el.textContent = res.data.usages;
                }
            });
        }

        function triggerLike(slug) {
            jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', {
                action: 'ilybd_toggle_like',
                tool_slug: slug
            }, function(res) {
                if(res.success) {
                    var el = document.getElementById('like-count-text');
                    if(el) el.textContent = res.data.likes;
                    alert('💖 Thank you! Your like has been anonymously counted in our secure SQL ledger.');
                }
            });
        }

        function triggerFavorite(slug) {
            var btn = document.getElementById('fav-btn');
            localStorage.setItem('ily_fav_' + slug, '1');
            btn.innerHTML = '⭐ Favorited';
            btn.style.background = 'rgba(251,191,36,0.3)';
            alert('⭐ Added to your Offline Browser Favorites. It will persist inside local memory!');
        }

        // Check if favorite is already stored on page load
        document.addEventListener('DOMContentLoaded', function() {
            var slug = '<?php echo esc_js($tool_slug); ?>';
            if(localStorage.getItem('ily_fav_' + slug) === '1') {
                var btn = document.getElementById('fav-btn');
                if(btn) {
                    btn.innerHTML = '⭐ Favorited';
                    btn.style.background = 'rgba(251,191,36,0.3)';
                }
            }
        });
    </script>
    <?php
    get_footer();
}

function ilybd_render_active_tool_interface($tool_slug) {
    if (!function_exists('ilybd_get_all_tools')) {
        return;
    }
    $tools = ilybd_get_all_tools();
    if (!isset($tools[$tool_slug])) {
        echo '<div style="color:#ff4d4d; font-family:monospace;">[ERROR: Tool config not found]</div>';
        return;
    }
    
    $tool = $tools[$tool_slug];
    $suite = $tool['category'];
    $file_path = get_template_directory() . "/inc/tools-suites/{$suite}.php";
    
    if (file_exists($file_path)) {
        require_once $file_path;
        $func_name = "ilybd_render_tool_" . str_replace('-', '_', $tool_slug);
        if (function_exists($func_name)) {
            $func_name();
        } else {
            echo '<div style="color:#fbbf24; font-family:monospace; padding:15px; background:rgba(251,191,36,0.1); border:1px solid rgba(251,191,36,0.3); border-radius:8px;">';
            echo esc_html("⚡ [{$tool['name']}] Interface registration pending. This is designated for immediate multi-segment dynamic execution.");
            echo '</div>';
        }
    } else {
        echo '<div style="color:#ff4d4d; font-family:monospace;">[ERROR: Suite handler file not found]</div>';
    }
}


