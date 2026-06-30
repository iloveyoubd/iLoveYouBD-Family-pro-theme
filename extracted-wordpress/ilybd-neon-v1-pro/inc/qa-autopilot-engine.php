<?php
/**
 * AI Autopilot Q&A Engine (Next-Level Autonomous Generation)
 * This engine handles auto-creation of community questions and answers.
 * It simulates real users and publishes questions & answers organically for SEO value.
 */

if (!defined('ABSPATH')) exit;

class ILYBD_QA_Autopilot_Engine {

    public function __construct() {
        // Add custom cron schedules
        add_filter('cron_schedules', [$this, 'add_custom_cron_schedules']);
        
        // Setup cron logic on init
        add_action('init', [$this, 'setup_cron_schedules_from_settings']);
        
        // The cron action
        add_action('ilybd_ai_qa_autopilot_cron_hook', [$this, 'execute_autopilot_cycle']);
        
        // Manual trigger for Admin
        add_action('admin_post_trigger_qa_autopilot', [$this, 'manual_trigger_from_admin']);
    }

    public function add_custom_cron_schedules($schedules) {
        $schedules['every_4_hours'] = array('interval' => 14400, 'display' => 'Every 4 Hours');
        $schedules['every_6_hours'] = array('interval' => 21600, 'display' => 'Every 6 Hours');
        return $schedules;
    }

    public function setup_cron_schedules_from_settings() {
        $is_enabled = get_option('ily_enable_ai_qa_autopilot', 0);
        $frequency = get_option('ily_ai_qa_frequency', 'every_4_hours'); 
        $hook = 'ilybd_ai_qa_autopilot_cron_hook';
        
        // Clean up old hook if it exists
        $old_hook = 'ilybd_daily_autopilot_qa_cron';
        if (wp_next_scheduled($old_hook)) {
            wp_clear_scheduled_hook($old_hook);
        }

        if ($is_enabled == 1) {
            $scheduled_freq = wp_get_schedule($hook);
            if ($scheduled_freq !== $frequency) {
                wp_clear_scheduled_hook($hook);
                wp_schedule_event(time() + 60, $frequency, $hook); // start 1 min from now on change
            }
        } else {
            wp_clear_scheduled_hook($hook);
        }
    }

    public function execute_autopilot_cycle() {
        // Enforce daily limit
        $daily_limit = intval(get_option('ily_ai_qa_daily_limit', 5));
        $today_date = date('Y-m-d');
        $qa_count_today = get_option('ily_ai_qa_count_' . $today_date, 0);
        
        if ($qa_count_today >= $daily_limit) {
            return; // Skip if limit reached
        }

        // Generate Question & Answers using Gemini API (or robust offline fallback)
        $content = $this->generate_ai_qa_content();
        
        if (!$content) return;

        // Generate a random user profile or pick an existing simulated user for asker
        $asker_id = $this->get_or_create_simulated_user('asker');

        // 1. Publish the Question
        $question_data = array(
            'post_title'    => sanitize_text_field($content['question_title']),
            'post_content'  => wp_kses_post($content['question_body']),
            'post_status'   => 'publish',
            'post_type'     => 'ilybd_question',
            'post_author'   => $asker_id,
            'meta_input'    => array(
                'qa_views_count' => rand(25, 250), // Matches single-ilybd_question.php name
                'qa_votes'       => rand(1, 15),   // Matches single-ilybd_question.php name
            )
        );
        $question_id = wp_insert_post($question_data);

        // 2. Set Category and Tags for SEO
        if ($question_id && !is_wp_error($question_id)) {
            // Category set
            $cat_name = !empty($content['category']) ? sanitize_text_field($content['category']) : 'Ai';
            $cat_id = wp_create_category($cat_name);
            if ($cat_id) {
                wp_set_post_terms($question_id, array($cat_id), 'category');
            }

            // Tags set
            $tags = !empty($content['tags']) && is_array($content['tags']) ? $content['tags'] : array('Tech Q&A', 'কমিউনিটি ফোরাম', 'এআই টিপস');
            $clean_tags = array_map('sanitize_text_field', $tags);
            wp_set_post_terms($question_id, $clean_tags, 'post_tag');

            // 3. Publish Multiple Answers as Comments (Simulating active community interaction)
            $answers_list = !empty($content['answers']) && is_array($content['answers']) ? $content['answers'] : [];
            
            if (empty($answers_list)) {
                $answers_list = [
                    [
                        'author_name' => 'cyber_expert_bd',
                        'answer_body' => !empty($content['answer_body']) ? $content['answer_body'] : 'ধন্যবাদ এই গাইডলাইনের জন্য।'
                    ]
                ];
            }

            // DYNAMICALLY RANDOMIZE ANSWER VOLUME: Each question gets a completely random number of replies (e.g. 1, 2, 3, 4, 5, 6, 7 or 8 replies)
            // This is perfect to make it look organic, and mimics a thriving human forum center!
            $target_answers_count = rand(1, 8);
            
            if (count($answers_list) > $target_answers_count) {
                // If generated too many answers, slice down to the target to maintain random diversity
                $answers_list = array_slice($answers_list, 0, $target_answers_count);
            } elseif (count($answers_list) < $target_answers_count) {
                // If we need more answers to reach the target count, dynamically append organic comments
                $organic_pool = [
                    'ধন্যবাদ ভাই! এই প্রবলেমটা নিয়ে অনেক দিন ধরে টেনশনে ছিলাম, চমৎকার গাইডলাইন।',
                    'This is extremely helpful! Highly detailed and easy-to-follow solution.',
                    'খুব সুন্দর এবং বিস্তারিত সমাধান। ধন্যবাদ আইটি টিম!',
                    'আমিও এই সমস্যায় পড়েছিলাম, ট্রাই করে দেখলাম কাজ করেছে! থ্যাংক ইউ!',
                    'Great insights. The step-by-step instructions are highly professional.',
                    'ধন্যবাদ ভাইয়া, বুকমার্ক করে রাখলাম। ভবিষ্যতে কাজে লাগবে।',
                    'Wonderful guide! Exactly what I was searching for on Google.',
                    'এই ফোরাম সেন্টারটি আসলেও অসাধারণ। সরাসরি নির্ভুল সমাধান পাওয়া যায়।',
                    'Is there any additional server settings required or this basic configuration is enough?',
                    'Highly appreciated! Thanks for taking the time to write this step-by-step guide.',
                    'চমৎকার সমাধান! এটি আমার সাইটের স্পিড ও সিকিউরিটি উভয়ই উন্নত করেছে।',
                    'Really happy to find this authentic solution. Thanks for sharing!'
                ];
                $users_pool = ['tech_seeker_bd', 'rakib_freelancer', 'tasnim_ahmed', 'muna_cyber', 'niloy_is_online', 'digital_sabbir', 'blogger_farhan', 'shakil_dev', 'cyber_warrior', 'wp_lover_bd'];
                
                $needed_count = $target_answers_count - count($answers_list);
                for ($i = 0; $i < $needed_count; $i++) {
                    $random_comment = $organic_pool[array_rand($organic_pool)];
                    $random_user_slug = $users_pool[array_rand($users_pool)] . rand(10, 999);
                    $answers_list[] = [
                        'author_name' => $random_user_slug,
                        'answer_body' => $random_comment
                    ];
                }
            }

            $answers_count = 0;
            $accepted_answer_id = 0;

            foreach ($answers_list as $index => $ans) {
                $responder_id = $this->get_or_create_simulated_user_by_name($ans['author_name']);
                $responder = get_userdata($responder_id);
                
                $comment_data = array(
                    'comment_post_ID'      => $question_id,
                    'comment_author'       => $responder->display_name,
                    'comment_author_email' => $responder->user_email,
                    'comment_content'      => wp_kses_post($ans['answer_body']),
                    'comment_type'         => 'comment',
                    'user_id'              => $responder_id,
                    'comment_approved'     => 1,
                    'comment_date'         => date('Y-m-d H:i:s', current_time('timestamp') - rand(600, 3600) + ($index * rand(300, 900))),
                );
                $comment_id = wp_insert_comment($comment_data);
                
                if ($comment_id) {
                    $answers_count++;
                    update_comment_meta($comment_id, 'votes_count', rand(2, 25));
                    
                    // Mark randomly as accepted solution
                    if ($index === 0 || ($index === 1 && rand(1, 100) > 50)) {
                        $accepted_answer_id = $comment_id;
                    }
                }
            }
            
            // Update answer count meta
            update_post_meta($question_id, 'answers_count', $answers_count);
            if ($accepted_answer_id) {
                update_post_meta($question_id, 'accepted_answer_id', $accepted_answer_id);
            }
            
            // Increment daily count
            update_option('ily_ai_qa_count_' . $today_date, $qa_count_today + 1);

            // Flush rewrite rules dynamically
            flush_rewrite_rules(false);
        }
    }

    private function generate_ai_qa_content() {
        if (function_exists('ily_get_all_rotated_api_keys') && function_exists('ily_call_gemini_api_direct')) {
            $api_keys = ily_get_all_rotated_api_keys();
            if (!empty($api_keys)) {
                // Fetch published tools to suggest dynamically
                $tools = get_posts([
                    'post_type' => 'ilybd_tools',
                    'posts_per_page' => 12,
                    'post_status' => 'publish'
                ]);
                $tools_list_str = "";
                if (!empty($tools)) {
                    foreach ($tools as $t) {
                        $tools_list_str .= "- " . $t->post_title . " (URL: " . get_permalink($t->ID) . ")\n";
                    }
                } else {
                    $tools_list_str = "- Free IP Lookup, Free Website Speed Test, Password Generator, QR Code Generator, Word Counter, DNS Checker, Port Scanner.";
                }

                $prompt = "You are an elite, world-class Tech Q&A and SEO Growth Architect. Your goal is to generate an extremely engaging, realistic, and ultra-high-value technical question and multiple expert replies for a leading Tech Forum.\n\n" .
                          "CRITICAL LANGUAGE & VARIETY DIRECTIVE:\n" .
                          "- Do NOT restrict yourself to only Bengali! Real users search in a mix of languages. Dynamically rotate between:\n" .
                          "  1. 35% Pure English: Highly technical, search-friendly developer/blogger queries (e.g., 'How to fix ChatGPT network error on long code blocks', 'Fix Facebook 2-Factor Authentication code not receiving in Bangladesh', 'How to configure custom domain in Hostinger with Cloudflare').\n" .
                          "  2. 35% Bilingual/Banglish Mix: Conversational tech talk common in Bangladesh (e.g., 'bKash Merchant Account খোলার নিয়ম ও চার্জ কত?', 'WordPress-এ elementor pro nulled ইউজ করলে কি সিকিউরিটি রিস্ক আছে?', 'Google AdSense Identity Verification করার সময় পিন না পাওয়ার সমাধান').\n" .
                          "  3. 30% Grammatically Pristine Bengali: Pure high-intent queries (e.g., 'ক্যানভা প্রিমিয়াম ফ্রিতে পাওয়ার উপায় কী?', 'ইউটিউব মনিটাইজেশন পলিসি ২০২৬-এর নতুন নিয়মাবলী').\n\n" .
                          "STRICT MANDATE (NO HALLUCINATIONS): You must keep the Q&A strictly logical, fully factual, and highly relevant. Do not include random facts or hallucinate features that don't exist. Keep replies highly on-topic.\n\n" .
                          "CRITICAL BRAND HIGH-JACKING & SEO DRIFT:\n" .
                          "- You MUST target high-volume search queries and issues containing names of major global/local websites, competitor brands, and digital tools. Examples of brands to target include: Google AdSense, Facebook Ads, YouTube Monetization, WordPress, ChatGPT, Hostinger, Namecheap, Cloudflare, bKash, Nagad, Canva, CapCut, TikTok, Github, Firebase, or Google Search Console.\n" .
                          "- Frame the question title exactly like high-intent search queries that users type in Google when they are desperate for solutions to problems on these sites.\n\n" .
                          "CRITICAL EXPERT ANSWERS DIRECTIVE:\n" .
                          "- Generate a completely dynamic number of replies (anywhere from 1 to 6 distinct replies; choose a different number of replies for each run to ensure maximum structural variety, e.g., some runs get 1 or 2 replies, some get 3, some get 5 or 6).\n" .
                          "- The replies must match the language of the question (e.g., if the question is in English, replies must be in English or natural bilingual Tech English; if the question is in Bengali/Bilingual, replies should be in natural Bengali/Bilingual).\n" .
                          "- Provide extremely detailed, high-value, and accurate step-by-step solutions (including lists, sub-headings, and code snippets or configuration steps).\n" .
                          "- One of the replies MUST organically recommend and suggest using one of our actual tools listed below, linking to its URL using a standard HTML anchor tag (e.g., <a href='URL' target='_blank'>Tool Name</a>) with engaging, natural text around it:\n" .
                          $tools_list_str . "\n\n" .
                          "Choose a category and 3-5 highly optimized, search-friendly tags/keywords relevant to the question in lowercase English (e.g. 'chatgpt-fix', 'adsense-pin-verification', 'facebook-security-bypass', 'bkash-charge'). These tags must represent actual search terms containing brand names or high-intent topics. The category must be a short, clean name (e.g., 'SEO Guide', 'Android', 'Cyber Security', 'Online Earning', 'Web Development', 'Ai').\n\n" .
                          "YOU MUST RESPOND ONLY WITH A JSON OBJECT containing the following fields:\n" .
                          "{\n" .
                          "  \"question_title\": \"(A short, clickable, search-friendly title mirroring actual Google searches in the appropriate language format)\",\n" .
                          "  \"question_body\": \"(Detailed question body explaining the technical problem or brand issue with full context, errors faced, etc.)\",\n" .
                          "  \"category\": \"(A suitable single category name, e.g. 'Cyber Security' or 'SEO Guide')\",\n" .
                          "  \"tags\": [\"brandname-problem\", \"tag2\", \"tag3\"],\n" .
                          "  \"answers\": [\n" .
                          "    {\n" .
                          "      \"author_name\": \"(A simulated username slug, e.g., 'wp_architect' or 'freelancer_rakib')\",\n" .
                          "      \"answer_body\": \"(First response: Detailed step-by-step solution, beautifully formatted with HTML lists or sub-headings)\"\n" .
                          "    },\n" .
                          "    {\n" .
                          "      \"author_name\": \"(A different simulated username slug, e.g., 'cyber_shield_agent')\",\n" .
                          "      \"answer_body\": \"(Second response: Alternating/complementary advice, organically containing the HTML link to our tool if appropriate)\"\n" .
                          "    },\n" .
                          "    {\n" .
                          "      \"author_name\": \"(Third simulated username slug, e.g., 'noc_engineer')\",\n" .
                          "      \"answer_body\": \"(Third response: Final tips or optimization instructions)\"\n" .
                          "    }\n" .
                          "  ]\n" .
                          "}\n\n" .
                          "Do NOT use markdown code blocks (```json ... ```), print the clean JSON text directly.";

                $json_res = ily_call_gemini_api_direct($api_keys, $prompt, 2500, true, "You are a professional JSON generator.");
                
                if (!is_wp_error($json_res) && !empty($json_res)) {
                    // Strip any leading/trailing backticks or wrappers if present
                    $json_res_clean = preg_replace('/^```[a-z]*\s*/i', '', trim($json_res));
                    $json_res_clean = preg_replace('/\s*```$/', '', $json_res_clean);
                    
                    $data = json_decode($json_res_clean, true);
                    if (json_last_error() === JSON_ERROR_NONE && !empty($data['question_title'])) {
                        return [
                            'question_title' => $data['question_title'],
                            'question_body'  => $data['question_body'],
                            'category'       => $data['category'],
                            'tags'           => $data['tags'],
                            'answers'        => $data['answers']
                        ];
                    }
                }
            }
        }

        // Fallback robust AI Content Simulator specifically for BD Tech Niche (Highly Bilingual & Brand Targeted)
        $topics = [
            [
                'q_title' => 'How to fix WordPress mixed content error after Cloudflare SSL activation?',
                'q_body' => 'I recently activated free SSL on my WordPress blog through Cloudflare. But my browser says "parts of this page are not secure" and some images are broken. How can I resolve this mixed content issue permanently?',
                'a_body' => 'This is a very common issue! To fix this on WordPress, you should do two things:<br>1. Install the <b>Really Simple SSL</b> plugin or add the following code to your <code>wp-config.php</code> file:<br><code>define(\'FORCE_SSL_ADMIN\', true);</code><br>2. Go to your Cloudflare dashboard under <b>SSL/TLS -> Edge Certificates</b> and turn ON <b>"Always Use HTTPS"</b> and <b>"Automatic HTTPS Rewrites"</b>. This will automatically force all http requests to load securely over https.',
                'category' => 'Web Development',
                'tags' => ['cloudflare-ssl', 'wordpress-ssl-fix', 'mixed-content-error', 'cloudflare-setup']
            ],
            [
                'q_title' => 'Google AdSense Approval-এর জন্য \'Low Value Content\' সমস্যার স্থায়ী সমাধান কী?',
                'q_body' => 'আমি একটি টেক ব্লগ সাইট খুলেছি এবং প্রায় ১৫টি পোস্ট লিখেছি। কিন্তু গুগল এডসেন্স-এ আবেদন করার পর প্রতিবারই "Low Value Content" এরর দিয়ে রিজেক্ট করে দিচ্ছে। এই পলিসি ভায়োলেশন থেকে বাঁচার এবং দ্রুত এডসেন্স এপ্রুভাল পাওয়ার উপায় কী?',
                'a_body' => 'গুগল এডসেন্স (Google AdSense) এপ্রুভালের জন্য "Low Value Content" খুবই কমন একটি সমস্যা। এটি সমাধান করার প্রফেশনাল উপায় নিচে দেওয়া হলো:<br>
                1. <b>পোস্টের শব্দ সংখ্যা বৃদ্ধি করুন:</b> প্রতিটি আর্টিকেল কমপক্ষে ১০০০-১৫০০ শব্দের হওয়া উচিত। কোনো এআই টুল দিয়ে জেনারেট করা ডাইরেক্ট কপি-পেস্ট কন্টেন্ট দেওয়া যাবে না।<br>
                2. <b>অর্গানিক ট্রাফিক ও সার্চ কনসোল:</b> আপনার পোস্টগুলো যেন Google Search Console-এ সঠিকভাবে ইনডেক্স থাকে তা নিশ্চিত করুন। ডিরেক্ট বা সোশ্যাল ট্রাফিকের চেয়ে সার্চ ট্রাফিক বেশি থাকলে এপ্রুভাল দ্রুত আসে।<br>
                3. <b>প্রয়োজনীয় পেজ তৈরি করুন:</b> Privacy Policy, Disclaimer, About Us এবং Contact Us পেজ অবশ্যই ফুটার মেনুতে যুক্ত করুন।<br>
                সাইটের স্পিড ও অন-পেজ এসইও ঠিক রাখতে আমাদের <a href="/free-tools/" target="_blank">Free SEO & Speed Optimization Tools</a> ব্যবহার করে একবার অডিট করে নিতে পারেন।',
                'category' => 'SEO Guide',
                'tags' => ['adsense-approval-tips', 'adsense-low-value-content', 'google-adsense-policy', 'online-earning']
            ],
            [
                'q_title' => 'Facebook Profile Locked: How to submit Identity Card to bypass security check?',
                'q_body' => 'My personal Facebook account has been locked due to suspicious activity. Facebook is asking me to upload my national ID card or passport to verify my identity. But whenever I submit, it says upload failed or rejection email comes. Is there any trick to get back my locked Facebook profile easily?',
                'a_body' => 'Recovering a locked Facebook profile requires strict compliance with their system guidelines:<br>
                1. <b>Image Quality:</b> Take the photo of your NID card on a dark, flat surface with plenty of ambient light. Do not use flash as it creates glare which automated AI checkers reject.<br>
                2. <b>Match Profile Details:</b> The full name and date of birth on your submitted ID MUST exactly match the name and DOB on your Facebook profile. If they differ, submit a request to update those details first if the system allows.<br>
                3. <b>Browser Cache:</b> Try uploading from a desktop browser or use a clean incognito window. Often, the Facebook mobile application fails to process high-resolution uploads.',
                'category' => 'Cyber Security',
                'tags' => ['facebook-lock-recovery', 'facebook-security-check', 'hack-protection', 'nid-verification']
            ],
            [
                'q_title' => 'bKash personal retail vs commercial merchant account: চার্জ ও দৈনিক লিমিটের পার্থক্য কী?',
                'q_body' => 'আমি একটি নতুন ই-কমার্স ফেসবুক পেইজ ও ওয়েবসাইট শুরু করেছি। কাস্টমারদের কাছ থেকে পেমেন্ট নেওয়ার জন্য বিকাশ পার্সোনাল রিটেইল অ্যাকাউন্ট (bKash Personal Retail Account) নাকি কমার্শিয়াল মার্চেন্ট অ্যাকাউন্ট (bKash Commercial Merchant Account) ভালো হবে? এই দুইটির চার্জ এবং দৈনিক লেনদেনের লিমিট সম্পর্কে বিস্তারিত জানতে চাই।',
                'a_body' => 'আপনার নতুন ই-কমার্স ব্যবসার জন্য কোনটি উপযুক্ত হবে তা নিচে বিস্তারিত বিশ্লেষণ করা হলো:<br><br>
                <b>১. বিকাশ পার্সোনাল রিটেইল অ্যাকাউন্ট (PR Account):</b><br>
                - এটি মূলত ক্ষুদ্র ও মাঝারি উদ্যোক্তাদের জন্য (যেমন ফেসবুক শপ)।<br>
                - <b>সুবিধা:</b> ট্রেড লাইসেন্স ছাড়া শুধুমাত্র জাতীয় পরিচয়পত্র (NID) এবং নিজের নামে নিবন্ধিত মোবাইল সিম দিয়ে এই অ্যাকাউন্ট খোলা যায়।<br>
                - <b>চার্জ:</b> কাস্টমার পেমেন্ট করলে আপনার কোনো পেমেন্ট রিসিভ চার্জ কাটে না (সম্পূর্ণ ফ্রি)। কিন্তু ক্যাশ আউট করতে প্রতি হাজারে ২০ টাকা পর্যন্ত কাটে।<br>
                - <b>লিমিট:</b> দৈনিক সর্বোচ্চ ৩০,০০০ টাকা এবং মাসিক সর্বোচ্চ ২,০০,০০০ টাকা পেমেন্ট নেওয়া যায়।<br><br>
                <b>২. বিকাশ কমার্শিয়াল মার্চেন্ট অ্যাকাউন্ট (Merchant Account):</b><br>
                - এটি বৃহৎ ব্যবসা বা ওয়েবসাইটের পেমেন্ট গেটওয়ে ইন্টিগ্রেশনের জন্য উপযুক্ত।<br>
                - <b>সুবিধা:</b> দৈনিক ও মাসিক আনলিমিটেড পেমেন্ট নেওয়া যায়। ওয়েবসাইটের সাথে API প্লাগইন যুক্ত করা যায়।<br>
                - <b>যোগ্যতা:</b> এটি খুলতে ট্রেড লাইসেন্স (Trade License), ব্যাংক অ্যাকাউন্ট এবং টিন সার্টিফিকেট (TIN) অবশ্যই লাগবে।<br>
                - <b>চার্জ:</b> প্রতি ট্রানজেকশনে সাধারণত ১.২% থেকে ১.৮% মার্চেন্ট কমিশন চার্জ কাটে।',
                'category' => 'Online Earning',
                'tags' => ['bkash-merchant-account', 'bkash-retail-charge', 'online-payment-gateway', 'bangladesh-fintech']
            ],
            [
                'q_title' => 'How to fix ChatGPT API quota limit exceeded or 429 Too Many Requests error?',
                'q_body' => 'I am integrating the OpenAI Gemini or ChatGPT API into my custom PHP web application. Although I just registered my account, I am getting a "429 Too Many Requests: You exceeded your current quota, please check your plan and billing details" error. How can I increase my rate limits?',
                'a_body' => 'The ChatGPT/OpenAI API 429 Error typically occurs due to billing or tier status:<br>
                1. <b>Add Payment Method:</b> Free trial credits ($5 or $18) often expire after 3 months. Go to your OpenAI developer console -> Billing and deposit a minimum of $5 to transition your account to Tier 1.<br>
                2. <b>Rate Limiting (RPM/TPM):</b> Check your current tier limits. If you are blasting concurrent requests, implement a delay/exponential backoff algorithm in your code.<br>
                3. <b>Alternative Solution:</b> You can switch to the Google Gemini API which provides a highly generous free tier. Check our platform\'s tools and code blueprints for easy integration scripts.',
                'category' => 'Ai',
                'tags' => ['chatgpt-api-error', 'openai-429-limit', 'gemini-api-setup', 'api-quota-exceeded']
            ]
        ];
        
        $choice = $topics[array_rand($topics)];
        
        $answers = [
            [
                'author_name' => 'cyber_expert_bd',
                'answer_body' => $choice['a_body']
            ],
            [
                'author_name' => 'tech_guru_99',
                'answer_body' => 'আমিও এটার সম্মুখীন হয়েছিলাম। উপরে সাইবার এক্সপার্ট ভাই যেভাবে বলেছেন, ঐভাবে ট্রাই করলে ১০০% কাজ করবে। এছাড়া আমাদের ড্যাশবোর্ড বা ফ্রি টুলসগুলো ব্যবহার করে চেক করে নিতে পারেন।'
            ],
            [
                'author_name' => 'dev_milon',
                'answer_body' => 'ধন্যবাদ সুন্দর সমাধানের জন্য! আমার মনে হয় সাইট অপ্টিমাইজেশন ও সিকিউরিটি রক্ষার্থে এই গাইডলাইন অত্যন্ত দরকারী।'
            ]
        ];
        
        return [
            'question_title' => $choice['q_title'],
            'question_body'  => $choice['q_body'],
            'category'       => $choice['category'],
            'tags'           => $choice['tags'],
            'answers'        => $answers
        ];
    }

    private function get_or_create_simulated_user_by_name($name_slug) {
        $first_names = ['Rahim', 'Karim', 'Sajid', 'Tanvir', 'Hasan', 'Arafat', 'Fahim', 'Nafis', 'Sharif', 'Monir', 'Sabina', 'Nadia', 'Rashed'];
        $last_names = ['Islam', 'Ahmed', 'Hossain', 'Rahman', 'Chowdhury', 'Mahmud', 'Khan', 'Siddique'];
        
        $username = sanitize_key(str_replace(' ', '_', strtolower($name_slug)));
        if (strlen($username) < 4) {
            $username .= rand(100, 999);
        }
        $email = $username . '@example.com';
        
        $user_id = username_exists($username);
        
        if (!$user_id) {
            $random_password = wp_generate_password(12, false);
            $user_id = wp_create_user($username, $random_password, $email);
            
            if (!is_wp_error($user_id)) {
                $fname = $first_names[array_rand($first_names)];
                $lname = $last_names[array_rand($last_names)];
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => $fname . ' ' . $lname,
                    'first_name' => $fname,
                    'last_name' => $lname
                ]);
            } else {
                return 1; // Fallback to admin if creation fails
            }
        }
        return $user_id;
    }

    private function get_or_create_simulated_user($role_type) {
        $usernames = ['cyber_expert_bd', 'tech_master99', 'pro_developer', 'seo_ninja', 'network_guru', 'ai_enthusiast_2040'];
        $first_names = ['Rahim', 'Karim', 'Sajid', 'Tanvir', 'Hasan', 'Arafat', 'Fahim', 'Nafis'];
        $last_names = ['Islam', 'Ahmed', 'Hossain', 'Rahman', 'Chowdhury', 'Mahmud'];
        
        $username = $usernames[array_rand($usernames)] . rand(100, 999);
        $email = $username . '@example.com';
        
        $user_id = username_exists($username);
        
        if (!$user_id) {
            $random_password = wp_generate_password(12, false);
            $user_id = wp_create_user($username, $random_password, $email);
            
            if (!is_wp_error($user_id)) {
                $fname = $first_names[array_rand($first_names)];
                $lname = $last_names[array_rand($last_names)];
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => $fname . ' ' . $lname,
                    'first_name' => $fname,
                    'last_name' => $lname
                ]);
            } else {
                // Fallback to admin if creation fails
                return 1; 
            }
        }
        return $user_id;
    }

    public function manual_trigger_from_admin() {
        if (!current_user_can('manage_options')) return;
        $this->execute_autopilot_cycle();
        wp_redirect(admin_url('admin.php?page=ilybd-nextgen-autopilot&autopilot_fired=true'));
        exit;
    }
}

new ILYBD_QA_Autopilot_Engine();
