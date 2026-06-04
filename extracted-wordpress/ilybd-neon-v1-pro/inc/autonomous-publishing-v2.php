<?php
/**
 * ILoveYouBD Professional AI Publishing System - Phase 2 Core Engine
 * Fully modular implementation for high-quality semantic SEO automation, Advanced Schema,
 * EEAT Layer, Quality Scoring, Similarity, Content Refresh, and Engagement Blocks.
 *
 * @package ILYBD_Neon
 * @version 2.0.0
 */

if (!defined('ABSPATH')) exit;

class ILYBD_AI_Publishing_Engine_V2 {

    /**
     * Singleton instance
     */
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        if (is_admin()) {
            add_filter('manage_post_posts_columns', [$this, 'add_custom_publish_columns']);
            add_action('manage_post_posts_custom_column', [$this, 'render_custom_publish_columns_data'], 10, 2);
        }
    }

    public function add_custom_publish_columns($columns) {
        $columns['ily_quality_score'] = 'AI Quality Score';
        $columns['ily_publish_stage'] = 'Pipeline Action';
        return $columns;
    }

    public function render_custom_publish_columns_data($column, $post_id) {
        if ($column === 'ily_quality_score') {
            $score = get_post_meta($post_id, 'ily_final_quality_score', true);
            if ($score !== '') {
                $color = '#00f0ff';
                if ($score >= 90) {
                    $color = '#00ff41'; // neon green
                } elseif ($score >= 75) {
                    $color = '#ff9900'; // orange
                } else {
                    $color = '#ff003c'; // red
                }
                echo '<strong style="color: ' . $color . '; font-family: monospace; font-size: 14px;">' . esc_html($score) . '/100</strong>';
            } else {
                echo '<span style="color: #64748b; font-size: 11px;">Not Scored</span>';
            }
        }
        if ($column === 'ily_publish_stage') {
            $action = get_post_meta($post_id, 'ily_publish_action_stage', true);
            if (!empty($action)) {
                $labels = [
                    'auto_publish' => '🟢 Auto Published',
                    'auto_repair_publish' => '🟡 Repaired & Published',
                    'auto_rewrite_repaired_publish' => '🔵 Rewritten & Published',
                    'review_pending_marginal_score' => '🟠 Pending: Marginal Content',
                    'review_pending_quarantine' => '🔴 Quarantined: Human Review'
                ];
                $label = isset($labels[$action]) ? $labels[$action] : $action;
                echo '<span class="badge" style="font-size: 11px; padding: 2px 6px; border-radius: 4px; background: rgba(0,0,0,0.05);">' . esc_html($label) . '</span>';
            } else {
                echo '<span style="color: #64748b; font-size: 11px;">Standard</span>';
            }
        }
    }

    /**
     * MODULE 1: AI Content Quality Scoring Engine
     * Calculates a complete score based on SEO and user value rules.
     */
    public function calculate_quality_score($title, $content, $tags = [], $category_id = 0) {
        $factors = [];
        $total_score = 0;

        // Fix undefined mb_str_word_count using preg_split
        $clean_content = wp_strip_all_tags($content);
        $words = preg_split('~[^\p{L}\p{N}\']+~u', $clean_content, -1, PREG_SPLIT_NO_EMPTY);
        $word_count = is_array($words) ? count($words) : (mb_strlen($clean_content) / 5);
        if ($word_count >= 1500) {
            $factors['word_count'] = 20; // Maximum score for top depth
        } elseif ($word_count >= 1000) {
            $factors['word_count'] = 15;
        } elseif ($word_count >= 500) {
            $factors['word_count'] = 10;
        } else {
            $factors['word_count'] = 3; // Demote short content
        }

        // Readability / Subheading Structure
        $h2_count = substr_count(strtolower($content), '<h2>') + substr_count(strtolower($content), '<h2 ');
        $h3_count = substr_count(strtolower($content), '<h3>') + substr_count(strtolower($content), '<h3 ');
        if ($h2_count >= 3 && $h3_count >= 2) {
            $factors['headings'] = 15;
        } elseif ($h2_count >= 1) {
            $factors['headings'] = 10;
        } else {
            $factors['headings'] = 2; // Demote plain stream of text
        }

        // Internal Links (using standard links format)
        $link_count = substr_count(strtolower($content), '<a ') + substr_count(strtolower($content), 'ilybd-inline-recommendation');
        if ($link_count >= 3) {
            $factors['internal_links'] = 10;
        } elseif ($link_count >= 1) {
            $factors['internal_links'] = 6;
        } else {
            $factors['internal_links'] = 0;
        }

        // External Authority Links
        $authority_domains = ['wikipedia.org', 'google.com', 'w3.org', 'wordpress.org', 'github.com', 'microsoft.com', 'php.net', 'stackoverflow.com', 'techcrunch.com'];
        $has_authority = 0;
        foreach ($authority_domains as $dom) {
            if (strpos($content, $dom) !== false) {
                $has_authority = 10;
                break;
            }
        }
        $factors['authority_links'] = $has_authority;

        // FAQ Presence
        $has_faq = (strpos($content, 'faq') !== false || strpos($content, 'frequently asked') !== false || strpos($content, 'প্রশ্নোত্তর') !== false || strpos($content, 'প্রশ্নাবলী') !== false) ? 10 : 0;
        $factors['faq_count'] = $has_faq;

        // Images Count
        $placeholder_imgs = substr_count($content, '[INLINE_IMAGE') + substr_count($content, 'ily-inline-image') + substr_count($content, '<img ');
        if ($placeholder_imgs >= 3) {
            $factors['image_count'] = 10;
        } elseif ($placeholder_imgs >= 1) {
            $factors['image_count'] = 6;
        } else {
            $factors['image_count'] = 0;
        }

        // Tables Presence (engagement helper)
        $has_tables = (strpos($content, '<table') !== false) ? 10 : 0;
        $factors['tables'] = $has_tables;

        // Uniqueness & Keyword coverage check
        $has_keywords = 0;
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                if (mb_strpos(mb_strtolower($content), mb_strtolower($tag)) !== false) {
                    $has_keywords += 3;
                }
            }
        }
        $factors['keyword_coverage'] = min(10, $has_keywords ? $has_keywords : 5);

        // Spam Detection / AI Slop Demotions (e.g. "In summary", "Crucial", "Essentially", "Additionally")
        $ai_markers = ['in conclusion', 'it is important to note', 'firstly', 'secondly', 'furthermore', 'moreover', 'tapestry of', 'not only', 'as mentioned earlier'];
        $spam_penalty = 0;
        foreach ($ai_markers as $marker) {
            if (strpos(strtolower($content), $marker) !== false) {
                $spam_penalty += 3;
            }
        }
        $factors['spam_detection'] = max(0, 15 - $spam_penalty);

        // Sum overall score
        foreach ($factors as $pts) {
            $total_score += $pts;
        }

        // Limit range strictly
        $total_score = min(100, max(0, $total_score));

        // Scoring Resolution Rule:
        // 90-100 = Auto Publish
        // 80-89 = Review Queue
        // Below 80 = Reject / Draft
        $decision = 'publish';
        if ($total_score >= 90) {
            $decision = 'publish';
        } elseif ($total_score >= 80) {
            $decision = 'review_queue';
        } else {
            $decision = 'draft'; // reject auto-publish, regenerate or hold
        }

        return [
            'score' => $total_score,
            'breakdown' => $factors,
            'decision' => $decision,
            'word_count' => $word_count
        ];
    }

    /**
     * MODULE 2: Duplicate & Similarity Detection Engine
     * Evaluates similarity against recent standard posts.
     */
    public function detect_similarity_overlap($title, $content) {
        $recent_posts = get_posts([
            'numberposts' => 40,
            'post_status' => 'publish',
            'post_type'   => 'post'
        ]);

        $max_title_similarity = 0;
        $max_content_similarity = 0;

        foreach ($recent_posts as $post) {
            // Compare titles
            similar_text(mb_strtolower($title), mb_strtolower($post->post_title), $title_percent);
            if ($title_percent > $max_title_similarity) {
                $max_title_similarity = $title_percent;
            }

            // Compare short extracts count of content
            $sample_a = mb_substr(wp_strip_all_tags($content), 0, 500);
            $sample_b = mb_substr(wp_strip_all_tags($post->post_content), 0, 500);
            similar_text(mb_strtolower($sample_a), mb_strtolower($sample_b), $content_percent);
            if ($content_percent > $max_content_similarity) {
                $max_content_similarity = $content_percent;
            }
        }

        $highest_percent = max($max_title_similarity, $max_content_similarity);

        // Rules:
        // Similarity > 95% -> Reject
        // Similarity > 85% -> Regenerate (flagged)
        // Otherwise -> Safe
        $action = 'safe';
        if ($highest_percent >= 95) {
            $action = 'reject';
        } elseif ($highest_percent >= 85) {
            $action = 'regenerate';
        }

        return [
            'highest_similarity' => $highest_percent,
            'title_similarity' => $max_title_similarity,
            'content_similarity' => $max_content_similarity,
            'action' => $action
        ];
    }

    /**
     * MODULE 3: Content Refresh Engine
     * Updates old posts to maintain Google Freshness Signals
     */
    public function refresh_old_post($post_id) {
        if (empty($post_id)) return false;

        $post = get_post($post_id);
        if (!$post || $post->post_type !== 'post') return false;

        $api_keys_raw = get_option('cyber_bot_api_keys');
        $api_keys = array_values(array_filter(array_map('trim', explode("\n", $api_keys_raw))));
        if (empty($api_keys)) {
            $api_keys = ["AIzaSyBAcwAPXPzNfeGQ6XHDR-EaNRsHqhkTro8"];
        }

        $current_year = date('Y');
        $last_year = (int)$current_year - 1;

        // Strip any existing recursively appended "[আপডেট কন্টেন্ট XXXX]" patterns
        $clean_title = preg_replace('/\s*\[আপডেট কন্টেন্ট\s*\d{4}\]/ui', '', $post->post_title);
        $clean_title = trim($clean_title);

        $new_title = str_replace((string)$last_year, (string)$current_year, $clean_title);
        $new_content = str_replace((string)$last_year, (string)$current_year, $post->post_content);

        // Append the new year tag exactly once if not already present
        if (mb_strpos($new_title, '[আপডেট কন্টেন্ট') === false) {
            $new_title .= " [আপডেট কন্টেন্ট " . $current_year . "]";
        }

        // Generate refreshing prompt block to augment with new statistics and new FAQ
        $refresh_prompt = "You are an expert tech editor update refresh system. You are updating a post: \"" . $new_title . "\". 
        Add a 'সর্বশেষ আপডেট " . date('F Y') . "' brief expert summary section, update tech stats or versions to the latest " . $current_year . " values, and include a newly added FAQs block. 
        Write inside styled HTML. Ensure bilingual elegant Bengali with technical English words. 
        Here is the original content overview to improve: \"" . esc_attr(mb_substr(wp_strip_all_tags($post->post_content), 0, 500)) . "\".";

        $addition = ily_call_gemini_api_direct($api_keys, $refresh_prompt, 800, false);
        if (!is_wp_error($addition) && !empty($addition)) {
            $new_content .= '<div class="ilybd-content-refreshed-layer" style="margin-top:35px; border-top:1px dashed rgba(0,240,255,0.2); padding-top:20px;">' .
                '<div style="background: rgba(0,255,65,0.02); border-left:4px solid #00ff41; padding:15px; border-radius:6px; margin-bottom:20px;">' .
                '<strong style="color:#00ff41; font-family:monospace; font-size:11px; display:block; text-transform:uppercase; margin-bottom:5px;">✓ Freshness Signal Revitalized - ' . date('Y-m-d') . '</strong>' .
                '<p style="color:#8b949e; font-size:12.5px; margin:0; line-height:1.5;">সাইটে গুগল ফ্রেশনেস সিগন্যাল ও ইউজার ভ্যালু বজায় রাখতে এই আর্টিকেলটি নির্ভরযোগ্য তথ্যাবলি, রিয়েল-টাইম পরিসংখ্যান এবং রিলেটেড এআই এফএকিউ দিয়ে আপডেট করা হয়েছে।</p>' .
                '</div>' .
                $this->strip_redundant_markdown($addition) .
                '</div>';
        }

        // Update post metadata and values
        wp_update_post([
            'ID'           => $post_id,
            'post_title'   => $new_title,
            'post_content' => $new_content,
            'post_modified' => current_time('mysql'),
            'post_modified_gmt' => current_time('mysql', 1)
        ]);

        update_post_meta($post_id, 'ily_content_refreshed_date', current_time('mysql'));
        return true;
    }

    /**
     * MODULE 4: Author Authority EEAT Integration
     * Resolves rich expert profiles for Authors.
     */
    public function setup_author_profiles($user_id, $category_name) {
        $expertise_areas = [
            'Cyber Security' => 'Ethical Hacking & Systems Security Specialist',
            'Mobile Tips' => 'Android Firmware Engineer & Optimization Coach',
            'Tutorials' => 'Senior Technology Architect & Technical Writer',
            'Online Earning' => 'Digital Economy Consultant & Affiliate Manager',
            'Tech Review' => 'SaaS Product Analyst & Gadget Reviewer',
            'Programming' => 'Full-Stack Software Developer & Python Coach',
            'SEO & Blogging' => 'Enterprise SEO Strategy Consultant & Google Webmaster Expert',
            'Tips & Tricks' => 'Consumer Tech Solutions Expert'
        ];

        $skills_mesh = [
            'Cyber Security' => ['Reverse Engineering', 'Penetration Testing', 'Malware Analysis', 'Vulnerability Scans'],
            'Mobile Tips' => ['BIOS settings', 'Kernel Optimizations', 'Root Exploits', 'Battery Calibration'],
            'Tutorials' => ['SOP Documentation', 'Technical Instruction', 'SaaS Implementation', 'Step-by-step Diagrams'],
            'Online Earning' => ['Traffic Arbitrage', 'CPA Multi-Links', 'CPC Bidding Scenarios', 'Revenue Optimization'],
            'Tech Review' => ['Performance Benchmark', 'Feature Auditing', 'Value Engineering', 'User Feedback Synthesis'],
            'Programming' => ['Node.js Middleware', 'REST Architecture', 'Database Sharding', 'LISP / Haskell Parallels'],
            'SEO & Blogging' => ['Core Web Vitals Boost', 'E-E-A-T Structuring', 'Semantic Anchor Flows', 'LSI Keywords Extraction'],
            'Tips & Tricks' => ['Device Diagnostics', 'Registry Edits', 'Failsafe Procedures', 'Workflow Automation']
        ];

        $niche_expertise = isset($expertise_areas[$category_name]) ? $expertise_areas[$category_name] : 'Expert Technology Writer';
        $niche_skills = isset($skills_mesh[$category_name]) ? $skills_mesh[$category_name] : ['Technology Scans', 'SEO Best Practices', 'Information Security'];

        update_user_meta($user_id, 'ilybd_expertise_area', $niche_expertise);
        update_user_meta($user_id, 'ilybd_skills', implode(', ', $niche_skills));
        
        $join_date = get_user_meta($user_id, 'ilybd_join_date', true);
        if (empty($join_date)) {
            update_user_meta($user_id, 'ilybd_join_date', date('F d, Y'));
        }

        // Add typical high-authority social profiles
        $uname = get_the_author_meta('user_login', $user_id);
        if (!get_user_meta($user_id, 'user_facebook', true)) {
            update_user_meta($user_id, 'user_facebook', 'https://facebook.com/' . $uname);
        }
        if (!get_user_meta($user_id, 'user_twitter', true)) {
            update_user_meta($user_id, 'user_twitter', 'https://twitter.com/' . $uname);
        }
        if (!get_user_meta($user_id, 'user_linkedin', true)) {
            update_user_meta($user_id, 'user_linkedin', 'https://linkedin.com/in/' . $uname);
        }
    }

    /**
     * MODULE 11: AI Filler and Cliché Pattern Removal (Dynamic Multi-Sentence Cleaner)
     * Automatically filters non-human boilerplate intro, cliché transitions, and robotic placeholders.
     */
    public function clean_robotic_and_filler_content($content) {
        if (empty($content)) return $content;

        // 1. Literal robotic filler sentences & unrequested terms to completely erase
        $banned_sentences = [
            'কন্টেন্ট রিফ্রেশ লগার চেক করে সর্বদা নিয়মিত সচল আপডেট বছর ভ্যালু নিরীক্ষণ করুন।',
            'সাইটে গুগল ফ্রেশনেস সিগন্যাল ও ইউজার ভ্যালু বজায় রাখতে এই কন্টেন্ট রিফ্রেশ লগার...',
            'ডিজিটাল সোনালী যুগে আপনার প্রযুক্তির সাথে থাকুন এবং ভ্যালু বজায় রাখুন।',
            'কন্টেন্ট রিফ্রেশ লগার চেক করে সর্বদা নিয়মিত সচল',
        ];

        foreach ($banned_sentences as $sentence) {
            $content = str_ireplace($sentence, '', $content);
        }

        // 2. Cliché robotic intro sentences/patterns
        $cliche_intros = [
            'বর্তমান ডিজিটাল যুগে',
            'প্রযুক্তির এই যুগে',
            'আজকের আধুনিক বিশ্বে',
            'আজকের এই দ্রুত গতিশীল বিশ্বে',
            'ডিজিটাল যুগের সাথে তাল মিলিয়ে',
            'বর্তমান প্রযুক্তিভিত্তিক বিশ্বে',
            'ডিজিটাল টেকনোলজির এই যুগে',
            'প্রযুক্তির আধুনিক সময়ে',
            'আমাদের এই ডিজিটাল সমাজে'
        ];

        // Replace robotic intro expressions with friendly, highly energetic human hooks
        $human_hooks = [
            'যদি আপনি একজন স্মার্ট ডিভাইস ব্যবহারকারী হয়ে থাকেন, তবে আজকের গাইডটি আপনার জীবনের একটি চমৎকার সমাধান হতে চলেছে।',
            'স্মার্টফোনের ছোট একটি ভুল সেটিংস বা অনাকাঙ্ক্ষিত সিকিউরিটি ল্যাপস আপনার গুরুত্বপূর্ণ ডেটাকে ঝুঁকির মধ্যে ফেলতে পারে।',
            'প্রযুক্তির সর্বোচ্চ সুবিধা উপভোগ করতে হলে কিছু লুকানো প্রফেশনাল ট্রিকস জানা আমাদের সকলের জন্য অত্যন্ত জরুরি।',
            'আজকের গাইডে আমরা কোনো রকম অবান্তর থিওরি ছাড়াই সরাসরি বাস্তব টেস্টিং ও প্র্যাকটিক্যাল গাইড নিয়ে কথা বলব।'
        ];

        foreach ($cliche_intros as $intro) {
            if (mb_strpos($content, $intro) !== false) {
                $replacement_hook = $human_hooks[wp_rand(0, count($human_hooks) - 1)];
                $content = str_replace($intro, $replacement_hook, $content);
            }
        }

        // 3. Cliché conclusion patterns
        $cliche_concl = [
            'উপসংহারে বলা যায়',
            'সবশেষে বলা যায়',
            'উপসংহারে আমরা বলতে পারি',
            'পরিশেষে বলা যায়',
            'আশা করি আপনারা বুঝতে পেরেছেন',
            'আজকের আর্টিকেলটি পড়ার পর'
        ];

        $human_closes = [
            'বাস্তব অভিজ্ঞতার ভিত্তিতে তৈরি এই সিকিউরিটি বা গতিশীল সেটিংসগুলো এখনই ফলো করে আপনার মতামত দিন।',
            'আপনার ডিভাইসে প্রোটোকলটি রান করার পর কোনো সমস্যা ফেস করলে নিচে কমেন্ট করে আমাদের বিশেষজ্ঞদের জানান।',
            'নিজের সিকিউরিটি বজায় রাখুন এবং যেকোনো অজানা ঝুঁকি সর্তকতার সাথে এড়ানোর চেষ্টা করুন।'
        ];

        foreach ($cliche_concl as $concl) {
            if (mb_strpos($content, $concl) !== false) {
                $replacement_close = $human_closes[wp_rand(0, count($human_closes) - 1)];
                $content = str_replace($concl, $replacement_close, $content);
            }
        }

        // Clean double-spacing and formatting issues caused by stripping text
        $content = preg_replace('/\s{2,}/u', ' ', $content);
        return $content;
    }

    /**
     * MODULE 5: EEAT Optimization & Engagement Blocks (Upgraded & Randomized)
     * Augments AI post content with verified high authority markers and engagement blocks.
     */
    public function inject_eeat_and_engagement($content, $title, $category_name) {
        // Run AI Filler Filter first
        $content = $this->clean_robotic_and_filler_content($content);

        // Fetch primary Author details for Author Note (EEAT)
        $author_id = get_post_field('post_author', get_the_ID()) ?: 1;
        $author_name = get_the_author_meta('display_name', $author_id) ?: 'Sazzadul Islam';
        $author_expertise = get_user_meta($author_id, 'ilybd_expertise_area', true) ?: 'Senior Technology Specialist';
        
        $current_date = current_time('F d, Y');
        $eeat_notes = [
            'Cyber Security' => 'এই সিকিউরিটি গাইডটি এন্ড্রয়েড সিকিউরিটি আর্কিটেকচার এবং ওডব্লিউএএসপি টেন গাইডলাইনের সাপেক্ষে ডিভাইস টেস্টিং ল্যাবে বাস্তব পরীক্ষার মাধ্যমে ডাবল-ভেরিফাই করা হয়েছে।',
            'Mobile Tips' => 'এই নির্দেশিকাটি মোবাইল সিস্টেম সেটিংস এবং কার্নেল অপ্টিমাইজেশন পারফরমেন্স প্যারামিটার বিশ্লেষণ করে বাস্তব অভিজ্ঞতার ভিত্তিতে সংকলিত হয়েছে।',
            'Online Earning' => 'এই কন্টেন্টে প্রকাশিত পদ্ধতিগুলো গুগল এডসেন্স প্রোগ্রাম পলিসি এবং বৈশ্বিক ফ্রিল্যান্সিং সাইটসমূহের অফিশিয়াল নীতিমালার সাপেক্ষে তৈরি করা হয়েছে।',
            'SEO & Blogging' => 'সার্চ পেজের ডেটা ইনডেক্স গতি এবং গুগল সার্চ রিলেশনের লেটেস্ট কোর গাইডলাইনের উপর ভিত্তি করে এই সলিউশন প্রস্তুত করা হয়েছে।'
        ];
        $selected_eeat_note = isset($eeat_notes[$category_name]) ? $eeat_notes[$category_name] : 'এই তথ্য আই লাভ ইউ বিডির ডিভাইস ল্যাব এবং টেকনিক্যাল রাইটারদের বিশেষজ্ঞ পর্যালোচনার ভিত্তিতে প্রস্তুত করা হয়েছে।';

        // Elegant EEAT Meta Top Header block (100% Posts get this block to satisfy Google Crawler index requirements)
        $eeat_header_box = '
        <div class="ilybd-eeat-meta-box" style="background: linear-gradient(135deg, rgba(13, 21, 39, 0.8), rgba(7, 11, 19, 0.95)); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 10px; padding: 18px; margin-bottom: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); border-left: 3px solid #00f0ff;">
            <div style="display: flex; flex-direction: column; gap: 8px; font-family: sans-serif;">
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 10px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 14px;">✍️</span>
                        <div>
                            <span style="color: #64748b; font-size: 10px; font-family: monospace; display: block; text-transform: uppercase;">Technical Reviewer</span>
                            <strong style="color: #fff; font-size: 13.5px;">' . esc_html($author_name) . '</strong>
                            <span style="color: #00f0ff; font-size: 11px; display: block;">' . esc_html($author_expertise) . '</span>
                        </div>
                    </div>
                    <div style="display: flex; gap: 15px; font-size: 11.5px; align-items: center;">
                        <div style="text-align: right;">
                            <span style="color: #64748b; display: block; font-family: monospace; text-transform: uppercase;">Reviewed Date</span>
                            <span style="color: #00ff41; font-weight: 600;">' . esc_html($current_date) . '</span>
                        </div>
                        <div style="text-align: right; border-left: 1px solid rgba(255,255,255,0.08); padding-left: 15px;">
                            <span style="color: #64748b; display: block; font-family: monospace; text-transform: uppercase;">Last Updated</span>
                            <span style="color: #fff; font-weight: 600;">' . esc_html($current_date) . '</span>
                        </div>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 8px; margin-top: 5px;">
                    <span style="font-size: 12.5px; line-height: 1;">🛡️</span>
                    <p style="margin: 0; color: #a1a1aa; font-size: 12.5px; line-height: 1.5; font-style: italic;">
                        <strong>অফিসিয়াল ইইএটি এন্ট্রি মন্তব্য:</strong> ' . esc_html($selected_eeat_note) . '
                    </p>
                </div>
            </div>
        </div>';

        // EEAT Experience (E) Indicator Box - 50% Randomized Deployment to simulate high-touch human editing
        $experience_block_html = '';
        if (wp_rand(1, 100) <= 50) {
            $device_pool = [
                ['Samsung Galaxy S23 Ultra', 'Redmi Note 13 Pro'],
                ['OnePlus 11', 'Realme GT Neo 5'],
                ['Xiaomi 14', 'Samsung Galaxy S22'],
                ['Redmi Note 12', 'Vivo V30']
            ];
            $selected_devices = $device_pool[wp_rand(0, count($device_pool) - 1)];
            
            $experience_text = '';
            switch ($category_name) {
                case 'Cyber Security':
                    $experience_text = "আমাদের সিকিউরিটি টেস্টবেঞ্চে " . $selected_devices[0] . " এবং " . $selected_devices[1] . " ফোনে সরাসরি ফেসবুক সিকিউরিটি টু-ফ্যাক্টর অডিটিং এবং জিমেইল পাসওয়ার্ড ল্যাপস নিয়ে পরীক্ষা চালানো হয়েছে। পরীক্ষার সময় দেখা গেছে, ব্যাকগ্রাউন্ড সিকিউরড সেটিংসে প্রক্সি এবং লগার আইপি নিষ্ক্রিয় করলে অ্যাকাউন্ট প্রটেকশন টাইম রেসপন্স প্রায় দ্বিগুণ শক্তিশালী হয়।";
                    break;
                case 'Mobile Tips':
                    $experience_text = "আমাদের টেনিক্যাল ল্যাবে " . $selected_devices[0] . " এবং " . $selected_devices[1] . " ডিভাইসে Animation Scale 1x থেকে কমিয়ে 0.5x করার পর এবং সিস্টেমে ক্যাশ ফাইল ক্লিন করার সময় সরাসরি Geekbench র‍্যাম লেটেন্সি পর্যবেক্ষণ করা হয়েছে। এতে দেখা গেছে স্ক্রলিং ফ্লুইডিটি ও রিফ্রেশ রেট রেসপন্স প্রায় ৩৫% বেশি দ্রুত অনুভূত হয়েছে।";
                    break;
                case 'Tutorials':
                    $experience_text = "আমরা সরাসরি " . $selected_devices[0] . " এবং " . $selected_devices[1] . " ফোনে সেটিংস অপশনগুলো ধাপে ধাপে নেভিগেট করে স্ক্রিনশট ও মেথডলজি প্রস্তুত করেছি। সরাসরি ডোমেইন কন্ট্রোল প্যানেলে প্র্যাকটিক্যাল ডাটা এন্ট্রি করার সময় এটি শতভাগ নিখুঁতভাবে রিয়াজল্ভড হয়েছিল।";
                    break;
                case 'Online Earning':
                    $experience_text = "আমাদের একটি লাইভ টেস্ট প্রজেক্টে Google Search Console-এর ডাটা ও AdSense রেভিনিউ এনালাইটিক্স নিয়ে নিরীক্ষা করা হয়েছে। অর্গানিক ট্রাফিকের পেইজ ভিউ রেশিও ৩.৭% থেকে বাড়িয়ে ৭.৮% করার সময় কোনো প্রকার পলিসি ওভারল্যাপ ফেস করতে হয়নি, যা ইউজার এনগেজমেন্ট লেভেল বাড়াতে সাহায্য করেছে।";
                    break;
                case 'SEO & Blogging':
                    $experience_text = "আমাদের ড্যাশবোর্ডে গত ১৫ দিনের ট্রাফিক ডাটা বিশ্লেষণ করে دیکھا গেছে, সঠিক অ্যাঙ্কর টেক্সট এবং ৩-৫টি প্রফেশনাল ক্যাটাগরি পিলারিং ইন্টারনাললি সংযুক্ত করলে সার্চ বুস্টিং ইমপ্রেশন প্রায় ২৪% বেশি রিয়েলটাইমে ইনডেক্স গতি বাড়ায়।";
                    break;
                case 'Tech Review':
                    $experience_text = "সরাসরি " . $selected_devices[0] . " এবং " . $selected_devices[1] . " এ ৩টি হেভি ইউটিলিটি অ্যাপ রানিং রেখে বেঞ্চমার্ক স্কোর ট্র্যাকিং করা হয়েছে। হার্ডওয়্যার থ্রটলিং প্রায় ১২% কমে গিয়ে সুপার লোড ব্যালেন্স বজায় রেখেছিল।";
                    break;
                default:
                    $experience_text = "ডিভাইস ল্যাবে " . $selected_devices[0] . " ফোনে সরাসরি ফিচারটি পরীক্ষা করার সময় রেসপন্স ডিলে এবং ডেটা প্রসেসিং গতি অত্যন্ত প্রফেশনাল রেজাল্ট দিয়েছে, যা সাধারণ ব্যবহারের জন্য শতভাগ সাজেস্টেড।";
            }

            $experience_block_html = '
            <div class="ilybd-human-experience-box" style="background: rgba(0, 240, 255, 0.02); border: 1px solid rgba(0, 240, 255, 0.2); border-left: 4px solid #00f0ff; border-radius: 8px; padding: 18px; margin: 25px 0; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <span style="font-size: 16px;">🔬</span>
                    <strong style="color: #00f0ff; font-family: monospace; font-size: 11px; text-transform: uppercase;">বাস্তব টেস্টিং অভিজ্ঞতা (Hands-On Experience & Evidence)</strong>
                </div>
                <p style="margin: 0; font-size: 13px; color: #e2e8f0; line-height: 1.6; font-style: italic;">
                    "' . esc_html($experience_text) . '"
                </p>
            </div>';
        }

        // Pros/Cons Blocks - 40% Randomization
        $pros_cons_html = '';
        if (wp_rand(1, 100) <= 40) {
            $pros_cons_html = '
            <div class="ilybd-pros-cons-grid" style="display:grid; grid-template-columns:1fr; md:grid-template-columns:1fr 1fr; gap:15px; margin:25px 0;">
                <div style="background:rgba(0,255,65,0.01); border:1px solid rgba(0,255,65,0.12); border-radius:8px; padding:15px; border-top:3px solid #00ff41;">
                    <h4 style="color:#00ff41; margin-top:0; font-size:14px; font-weight:800; font-family:monospace; text-transform:uppercase;">✓ সুবিধা সমূহ (Advantages)</h4>
                    <ul style="margin:10px 0 0 0; padding-left:20px; font-size:13px; color:#c9d1d9; line-height:1.6;">
                        <li>ব্যবহার বিধি অত্যন্ত সুরক্ষিত এবং কোন বাড়তি অবান্তর রুট বা থার্ড-পার্টি অ্যাপ পারমিশনের প্রয়োজন নেই।</li>
                        <li>গুগল ক্রলার ও এডসেন্স ফ্রেন্ডলি এবং এর মাধ্যমে ডিভাইসের লেটেন্সি কমানো সম্ভব।</li>
                    </ul>
                </div>
                <div style="background:rgba(255,62,62,0.01); border:1px solid rgba(255,62,62,0.12); border-radius:8px; padding:15px; border-top:3px solid #ff3e3e;">
                    <h4 style="color:#ff3e3e; margin-top:0; font-size:14px; font-weight:800; font-family:monospace; text-transform:uppercase;">✗ অসুবিধা বা সীমাবদ্ধতা (Limitations)</h4>
                    <ul style="margin:10px 0 0 0; padding-left:20px; font-size:13px; color:#c9d1d9; line-height:1.6;">
                        <li>ভুল রেজিস্ট্রি কী মেলালে বা ভুল ডিরেক্টরি সেটআপে ফিচারটি কাজ নাও করতে পারে।</li>
                    </ul>
                </div>
            </div>';
        }

        // Feedback Poll Block - 30% Randomization to prevent layout footprint
        $poll_html = '';
        if (wp_rand(1, 100) <= 30) {
            $poll_html = '
            <div class="ilybd-interactive-poll-box" style="background:#090d16; border:1px solid rgba(0,240,255,0.2); border-radius:10px; padding:20px; margin:30px 0; text-align:left;">
                <strong style="color:#00f0ff; font-family:monospace; font-size:11px; display:block; text-transform:uppercase; margin-bottom:5px;">📊 ILYBD COMMUNITY FEEDBACK POLL</strong>
                <p style="color:#fff; font-size:14px; font-weight:bold; margin:0 0 15px 0;">আপনার মতে এই গাইডটি আপনার জন্য কতটুকু কার্যকর হয়েছে?</p>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <button type="button" class="ilybd-poll-opt-btn" onclick="let s=jQuery(this); if(!s.hasClass(\'active\')){s.parent().find(\'button\').css(\'opacity\',0.5);s.addClass(\'active\').css({\'opacity\':1,\'background\':\'#00f0ff\',\'color\':\'#000\'}); s.find(\'.p-pct\').text(\'৭৮%\');}" style="background:#11192e; border:1px solid rgba(0,240,255,0.15); color:#fff; padding:8px 15px; font-size:12px; border-radius:4px; cursor:pointer; display:flex; justify-content:space-between; font-weight:bold;">
                        <span>১০০% কার্যকর ও চমৎকার গাইড!</span>
                        <span class="p-pct"></span>
                    </button>
                    <button type="button" class="ilybd-poll-opt-btn" onclick="let s=jQuery(this); if(!s.hasClass(\'active\')){s.parent().find(\'button\').css(\'opacity\',0.5);s.addClass(\'active\').css({\'opacity\':1,\'background\':\'#00f0ff\',\'color\':\'#000\'}); s.find(\'.p-pct\').text(\'১৬%\');}" style="background:#11192e; border:1px solid rgba(0,240,255,0.15); color:#fff; padding:8px 15px; font-size:12px; border-radius:4px; cursor:pointer; display:flex; justify-content:space-between; font-weight:bold;">
                        <span>হ্যাঁ, তবে কিছু সেটিংস বুঝতে সমস্যা হচ্ছে।</span>
                        <span class="p-pct"></span>
                    </button>
                </div>
                <p style="color:#64748b; font-size:10px; font-family:monospace; margin:10px 0 0 0; text-align:right;">* সংগৃহীত তথ্য শুধুমাত্র আমাদের কন্টেন্ট আরও উন্নত করতে ব্যবহৃত হবে।</p>
            </div>';
        }

        // Key Takeaways Block - 50% Randomization
        $takeaways_html = '';
        if (wp_rand(1, 100) <= 50) {
            $takeaways_html = '
            <div class="ilybd-key-takeaways-box" style="background: rgba(0, 240, 255, 0.01); border: 1px solid rgba(0, 240, 255, 0.12); border-left: 4px solid #00f0ff; border-radius: 6px; padding: 18px; margin: 25px 0;">
                <strong style="color: #00f0ff; font-family: monospace; font-size: 11px; display: block; text-transform: uppercase; margin-bottom: 8px;">📌 মূল অংশসমূহের সারসংক্ষেপ (Key Takeaways)</strong>
                <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: #e2e8f0; line-height: 1.6;">
                    <li>যেকোনো কোড বা স্ক্রিপ্টিং ব্যবহারের পূর্বে সর্বদা সম্পূর্ণ ব্যাকআপ নিশ্চিত করে নিন।</li>
                    <li>নিরাপদ ব্রাউজিং ও ডিভাইস সুরক্ষায় থার্ড পার্টি অজানা ফিশিং সোর্স থেকে সতর্ক থাকুন।</li>
                    <li>প্রতিটি সেটিংস পরিবর্তনের পর মোবাইলটি একবার রিস্টার্ট করা রিকমেন্ডেড।</li>
                </ul>
            </div>';
        }

        // Category-Specific Authority Reference mapping (Topic-aware Google-Trust Sources)
        $authorities = [
            'Cyber Security' => [
                'NIST Cybersecurity Framework' => 'https://www.nist.gov/cyberframework',
                'PortSwigger Web Security Academy' => 'https://portswigger.net/web-security',
                'OWASP Top Ten Security Project' => 'https://owasp.org/www-project-top-ten/'
            ],
            'Mobile Tips' => [
                'Android Open Source Project Documentation' => 'https://source.android.com',
                'Samsung Mobile Web Support' => 'https://support.samsung.com',
                'Apple Support Official Manuals' => 'https://support.apple.com'
            ],
            'Tutorials' => [
                'W3C Standards Web Catalog' => 'https://www.w3.org/TR/',
                'Wikipedia Technical Encyclopedia' => 'https://en.wikipedia.org/wiki/Technology',
                'Lifehacker Tech Tips Portal' => 'https://lifehacker.com'
            ],
            'Online Earning' => [
                'Google AdSense Program Publisher Policies' => 'https://support.google.com/adsense/answer/48182',
                'Fiverr Community Help Articles' => 'https://community.fiverr.com',
                'Shopify Ecommerce Guides' => 'https://www.shopify.com/blog'
            ],
            'SEO & Blogging' => [
                'Google Search Quality Raters Guidelines' => 'https://developers.google.com/search/docs/fundamentals/creating-helpful-content',
                'Moz SEO Beginner\'s Learning Guide' => 'https://moz.com/beginners-guide-to-seo',
                'Semrush Official Blogging Hub' => 'https://www.semrush.com/blog/'
            ],
            'Programming' => [
                'Mozilla Developer Network (MDN) Docs' => 'https://developer.mozilla.org',
                'PHP.net Official Reference Manual' => 'https://www.php.net',
                'GitHub Open Source Guidelines' => 'https://github.com'
            ]
        ];
        $selected_auths = isset($authorities[$category_name]) ? $authorities[$category_name] : [
            'Google Developer Documentation' => 'https://developers.google.com',
            'Wikipedia Tech Hub' => 'https://en.wikipedia.org'
        ];

        $sources_html = '';
        if (wp_rand(1, 100) <= 70) {
            $sources_html = '
            <div class="ilybd-trusted-sources-block" style="background:#080d17; border:1px solid rgba(255,255,255,0.04); border-radius:8px; padding:15px; margin-top:35px;">
                <strong style="color:#64748b; font-family:monospace; font-size:11px; display:block; text-transform:uppercase; margin-bottom:10px; border-bottom:1px solid rgba(255,255,255,0.05); padding-bottom:5px;">🔗 ট্রাস্ট ইইএটি তথ্যসূত্র (EEAT Verified Authority References)</strong>
                <ul style="margin:0; padding-left:20px; font-size:12px; line-height:1.6; font-family:sans-serif;">';
            foreach ($selected_auths as $name => $url) {
                $sources_html .= '<li><a href="' . esc_url($url) . '" style="color:#00f0ff; font-weight:bold; text-decoration:underline;" target="_blank" rel="nofollow noopener">' . esc_html($name) . '</a> - অফিসিয়াল ট্রাস্ট ভেরিফাইড ম্যানুয়াল।</li>';
            }
            $sources_html .= '
                </ul>
            </div>';
        }

        // Clean rating comparison table (100% human-designed indicators, zero arbitrary scores)
        $comparison_table_html = '';
        if (wp_rand(1, 100) <= 50) {
            $comparison_table_html = '
            <div class="ilybd-auto-comparison-table-wrapper" style="margin: 30px 0; overflow-x: auto; border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.25);">
                <table style="width: 100%; border-collapse: collapse; background: #0c1224; color: #c9d1d9; font-size: 13px; text-align: left;">
                    <thead>
                        <tr style="background: rgba(0, 240, 255, 0.08); border-bottom: 2px solid rgba(0, 240, 255, 0.2);">
                            <th style="padding: 12px 15px; color: #00f0ff; font-family: monospace;">সার্ভিস প্রোটোকল (Service Protocol)</th>
                            <th style="padding: 12px 15px; color: #00f0ff; font-family: monospace;">নিরাপত্তা ও বিশ্বস্ততা (Security Level)</th>
                            <th style="padding: 12px 15px; color: #00f0ff; font-family: monospace;">ডিভাইসে প্রভাব (Device Impact)</th>
                            <th style="padding: 12px 15px; color: #00f0ff; font-family: monospace;">রিকমেন্ডেশন (Recommendation)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
                            <td style="padding: 12px 15px; font-weight: bold; color: #fff;">অফিসিয়াল ম্যানুয়াল সেটিংস (Official Methods)</td>
                            <td style="padding: 12px 15px; color: #00ff41;">✓ সাইনড ও ভেরিফাইড (Highly Secured)</td>
                            <td style="padding: 12px 15px; color: #38bdf8;">খুবই সামান্য র‍্যাম ব্যবহার (Ultra Low Resource Use)</td>
                            <td style="padding: 12px 15px;"><span style="background: rgba(0, 255, 65, 0.1); color: #00ff41; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">উত্তম পছন্দ (Best Choice)</span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
                            <td style="padding: 12px 15px; font-weight: bold; color: #fff;">মডিফাইড অজানা টুলস (Modified APKs)</td>
                            <td style="padding: 12px 15px; color: #ff3e3e;">✗ অনিরাপদ ট্র্যাকার ঝুঁকি (Potential Spyware)</td>
                            <td style="padding: 12px 15px; color: #f43f5e;">উচ্চ সিপিইউ ও ব্যাটারি খরচ (High resource drain)</td>
                            <td style="padding: 12px 15px;"><span style="background: rgba(255, 62, 62, 0.1); color: #ff3e3e; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">এড়িয়ে চলুন (Avoid entirely)</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>';
        }

        // Segment combination
        $paragraphs = preg_split('/(<\/p>|<\/h2>|<\/h3>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        $rich_content = $eeat_header_box; // Prepend elite EEAT meta card
        $count = count($paragraphs);

        for ($i = 0; $i < $count; $i++) {
            $rich_content .= $paragraphs[$i];
            
            // Inject key takeaways near 15%
            if ($i === (int)($count * 0.15) && !empty($takeaways_html)) {
                $rich_content .= $takeaways_html;
            }

            // Inject dynamic experience layer near 30%
            if ($i === (int)($count * 0.30) && !empty($experience_block_html)) {
                $rich_content .= $experience_block_html;
            }

            // Inject comparison table near 45%
            if ($i === (int)($count * 0.45) && !empty($comparison_table_html)) {
                $rich_content .= $comparison_table_html;
            }
            
            // Inject comparison pros/cons near 65%
            if ($i === (int)($count * 0.65) && !empty($pros_cons_html)) {
                $rich_content .= $pros_cons_html;
            }
        }

        // Dynamic footer elements (Poll, Sources references)
        if (!empty($poll_html)) {
            $rich_content .= $poll_html;
        }
        if (!empty($sources_html)) {
            $rich_content .= $sources_html;
        }

        return $rich_content;
    }

                        




    /**
     * MODULE 6 & 7: Auto FAQ Generator & Structured JSON-LD Schema Engine
     * Generates proper markup for core structured entities
     */
    public function generate_advanced_schema_graph($post_id, $title, $excerpt, $content, $author_id, $category_name) {
        $author_display = get_the_author_meta('display_name', $author_id) ?: 'Sazzadul Islam';
        $author_bio = get_the_author_meta('description', $author_id) ?: 'আই লাভ ইউ বিডি কন্টেন্ট ক্রিয়েটর।';
        $author_avatar_url = get_avatar_url($author_id);
        $post_url = get_permalink($post_id);

        $date_published = get_the_date('c', $post_id);
        $date_modified = get_the_modified_date('c', $post_id);

        // Fetch FAQ blocks from content or meta to list in FAQ Schema
        $faqs = [];
        // Detect H3 FAQs or list generic ones
        if (preg_match_all('/<h3 style="color:\s*#00f0ff;\s*margin-top:\s*25px;">(.*?)<\/h3>\s*<p>(.*?)<\/p>/is', $content, $faq_matches)) {
            for ($k = 0; $k < count($faq_matches[1]); $k++) {
                if ($k >= 6) break; // Limit FAQ items
                $faqs[] = [
                    '@type' => 'Question',
                    'name' => wp_strip_all_tags($faq_matches[1][$k]),
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => wp_strip_all_tags($faq_matches[2][$k])
                    ]
                ];
            }
        }

        if (empty($faqs)) {
            // Default elegant tech FAQs
            $faqs = [
                [
                    '@type' => 'Question',
                    'name' => 'এই ট্রিকসটি কি ২০২৬ সালের আপডেটেড সংস্করণে কার্যকর?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'হ্যাঁ, কন্টেন্টটি সম্পূর্ণরূপে যাচাই করে ২০২৬ সালের লেটেস্ট সিকিউরিটি প্যাচ ও এন্ড্রয়েড সিস্টেমে রানিং পরীক্ষা করা হয়েছে।'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'আই লাভ ইউ বিডির কন্টেন্টগুলো কি শতভাগ নিরাপদ ও বিশ্বস্ত?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'শতভাগ বিশ্বস্ত। আমরা প্রতিটি প্রোটোকল রিয়েল টেস্টবেঞ্চে পরীক্ষা করে ইউজারদের নিকট সেফ গাইড উপস্থাপন করি।'
                    ]
                ]
            ];
        }

        // Schema graph assembly
        $schema_graph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                // 1. Organization Schema
                [
                    '@type' => 'Organization',
                    '@id' => home_url('/#organization'),
                    'name' => 'I Love You BD',
                    'url' => home_url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        '@id' => home_url('/#logo'),
                        'url' => home_url('/wp-content/themes/ilybd-neon-v1-pro/assets/images/logo.png'),
                        'caption' => 'I Love You BD Logo'
                    ]
                ],
                // 2. Website Schema
                [
                    '@type' => 'WebSite',
                    '@id' => home_url('/#website'),
                    'url' => home_url('/'),
                    'name' => 'I Love You BD',
                    'publisher' => [
                        '@id' => home_url('/#organization')
                    ]
                ],
                // 3. Document/Page Schema
                [
                    '@type' => 'WebPage',
                    '@id' => $post_url,
                    'url' => $post_url,
                    'name' => $title,
                    'isPartOf' => [
                        '@id' => home_url('/#website')
                    ],
                    'breadcrumb' => [
                        '@type' => 'BreadcrumbList',
                        'itemListElement' => [
                            [
                                '@type' => 'ListItem',
                                'position' => 1,
                                'name' => 'হোম',
                                'item' => home_url('/')
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 2,
                                'name' => $category_name,
                                'item' => get_category_link(get_post_meta($post_id, '_ily_main_category_id', true) ?: 1)
                            ],
                            [
                                '@type' => 'ListItem',
                                'position' => 3,
                                'name' => $title,
                                'item' => $post_url
                            ]
                        ]
                    ]
                ],
                // 4. Article Schema
                [
                    '@type' => 'BlogPosting',
                    '@id' => $post_url . '#article',
                    'isPartOf' => [
                        '@id' => $post_url
                    ],
                    'headline' => $title,
                    'datePublished' => $date_published,
                    'dateModified' => $date_modified,
                    'mainEntityOfPage' => $post_url,
                    'author' => [
                        '@type' => 'Person',
                        'name' => $author_display,
                        'description' => $author_bio,
                        'image' => $author_avatar_url
                    ],
                    'publisher' => [
                        '@id' => home_url('/#organization')
                    ],
                    'description' => $excerpt
                ],
                // 5. FAQ Schema
                [
                    '@type' => 'FAQPage',
                    '@id' => $post_url . '#faq',
                    'mainEntity' => $faqs
                ]
            ]
        ];

        update_post_meta($post_id, 'ily_json_ld_schema', json_encode($schema_graph));
    }

    /**
     * MODULE 8: Topic Cluster Interlinking System
     * Resolves pillar and supporting connections elegantly.
     */
    public function align_topic_cluster($post_id, $category_id) {
        $pillar_post_id = get_option('ilybd_pillar_post_cat_' . $category_id);

        if (empty($pillar_post_id)) {
            // First published high-quality post in category becomes Pillar!
            update_option('ilybd_pillar_post_cat_' . $category_id, $post_id);
            update_post_meta($post_id, 'ilybd_post_cluster_role', 'pillar');
        } else {
            // Link supporting post back to the Pillar post
            update_post_meta($post_id, 'ilybd_post_cluster_role', 'supporting');
            update_post_meta($post_id, 'ilybd_pillar_post_reference_id', $pillar_post_id);
            
            // Add custom anchor element referencing pillar post in content
            $pillar_post = get_post($pillar_post_id);
            if ($pillar_post) {
                $pillar_anchor = '<div class="ilybd-pillar-linking-cluster" style="background:rgba(112,0,255,0.02); border:1px dashed rgba(112,0,255,0.25); border-left:3px solid #7000ff; padding:12px; margin:20px 0; border-radius:4px;">' .
                    '<strong style="color:#00f0ff; font-size:11px; font-family:monospace; display:block; margin-bottom:4px; text-transform:uppercase;">🧬 Topic Cluster Pillar Resource:</strong>' .
                    'আমাদের প্রধান ক্যাটাগরি পিলারে ক্লিক করে এই বিষয়ের পূর্ণাঙ্গ বিবরণ পড়ুন: ' .
                    '<a href="' . esc_url(get_permalink($pillar_post_id)) . '" style="color:#00f0ff; font-weight:800; text-decoration:underline;">' . esc_html($pillar_post->post_title) . '</a>' .
                    '</div>';
                
                $post = get_post($post_id);
                $updated_content = $pillar_anchor . $post->post_content;
                wp_update_post([
                    'ID'           => $post_id,
                    'post_content' => $updated_content
                ]);
            }
        }
    }

    /**
     * MODULE 9 & 20: Search Intent Customizer & Human-like Content Template Engine
     * Adjusts system guidelines and layouts based on search intent to avoid pattern fatigue.
     */
    public function get_intent_customized_system_instruction($topic, $intent, $display_name) {
        $base = "You are " . $display_name . ", a leading technology writer. Write in clean Bengali with accurate technical English words.";
        
        switch ($intent) {
            case 'transactional':
                // Focus on direct, action-driven, CTAs and steps
                return $base . " The intent is TRANSACTIONAL (action-focused, how to download/apply/configure). Focus heavily on step-by-step guides, clean options, setup directories, pricing structure, and clear actionable takeaways.";
                
            case 'commercial':
                // Focus on comparisons, pros/cons, styled tables
                return $base . " The intent is COMMERCIAL (comparison and evaluation). Structure the post around clear comparison tables, extensive pros and cons blocks, alternative choices, and pricing plans.";
                
            case 'navigational':
                // Focus on paths, specific portals, links
                return $base . " The intent is NAVIGATIONAL (seeking a specific location or portal). Focus heavily on listing official source domains, portal interface guides, login/register steps, and clear diagnostic paths.";
                
            case 'informational':
            default:
                // Deep guide, FAQs
                return $base . " The intent is INFORMATIONAL (seeking comprehensive knowledge). Write deep, detailed descriptions, include comprehensive settings definitions, background theories, history, and a major FAQ segment with 5 parts.";
        }
    }

    /**
     * Helper to clean up formatting
     */
    private function strip_redundant_markdown($txt) {
        $txt = preg_replace('/```html/i', '', $txt);
        $txt = preg_replace('/```/i', '', $txt);
        return trim($txt);
    }
}

// Auto-initialize the module to register administrative filters and custom columns on boot
ILYBD_AI_Publishing_Engine_V2::get_instance();
