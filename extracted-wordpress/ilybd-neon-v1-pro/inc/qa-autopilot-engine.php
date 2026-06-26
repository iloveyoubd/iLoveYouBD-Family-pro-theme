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

        // Generate a random user profile or pick an existing simulated user
        $asker_id = $this->get_or_create_simulated_user('asker');
        $responder_id = $this->get_or_create_simulated_user('responder');
        
        // Generate Question & Answer using Gemini API (or robust offline fallback)
        $content = $this->generate_ai_qa_content();
        
        if (!$content) return;

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

            // 3. Publish the Answer as a Comment
            $responder = get_userdata($responder_id);
            $comment_data = array(
                'comment_post_ID'      => $question_id,
                'comment_author'       => $responder->display_name,
                'comment_author_email' => $responder->user_email,
                'comment_content'      => wp_kses_post($content['answer_body']),
                'comment_type'         => 'comment',
                'user_id'              => $responder_id,
                'comment_approved'     => 1,
            );
            $comment_id = wp_insert_comment($comment_data);
            
            // Update answer count meta
            update_post_meta($question_id, 'answers_count', 1);
            if ($comment_id) {
                update_comment_meta($comment_id, 'votes_count', rand(2, 25));
                // Mark as accepted solution randomly
                if (rand(1, 100) > 30) {
                    update_post_meta($question_id, 'accepted_answer_id', $comment_id);
                }
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
                $prompt = "You are an elite Tech Q&A Community manager. Generate an extremely engaging, realistic, and highly SEO-optimized technology question and expert answer for a popular Bangladeshi Tech Forum.\n\n" .
                          "The question should be asked by a typical Bangladeshi user in conversational, polite Bengali (e.g., asking about mobile problems, internet, freelancing, AdSense approval, coding, secure hacking defense, or online earnings).\n" .
                          "The answer should be from an expert/moderator, giving precise step-by-step instructions in clear, readable Bengali with high-value technical advice.\n\n" .
                          "Choose a category and 3-5 tags relevant to the question. The category must be a short, clean name (e.g., 'SEO Guide', 'Android', 'Hacking', 'Online Earning', 'Web Development', 'Ai').\n\n" .
                          "YOU MUST RESPOND ONLY WITH A JSON OBJECT containing the following fields:\n" .
                          "{\n" .
                          "  \"question_title\": \"(A short, catchy, clickable question in Bengali. E.g. 'বিকাশে পেমেন্ট নেওয়ার সময় অটোমেটিক চার্জ কাটার কারণ কী?')\",\n" .
                          "  \"question_body\": \"(Detailed question text in Bengali, explaining the issue clearly with context)\",\n" .
                          "  \"answer_body\": \"(Expert, highly detailed step-by-step solution in Bengali, nicely formatted with HTML lists or sub-headings)\",\n" .
                          "  \"category\": \"(A suitable single category name in English or Bengali, e.g. 'Online Earning' or 'SEO Guide' or 'Hacking')\",\n" .
                          "  \"tags\": [\"tag1\", \"tag2\", \"tag3\"]\n" .
                          "}\n\n" .
                          "Do NOT use markdown code blocks (```json ... ```), print the clean JSON text directly.";

                $json_res = ily_call_gemini_api_direct($api_keys, $prompt, 2000, true, "You are a professional JSON generator.");
                
                if (!is_wp_error($json_res) && !empty($json_res)) {
                    // Strip any leading/trailing backticks or wrappers if present
                    $json_res_clean = preg_replace('/^```[a-z]*\s*/i', '', trim($json_res));
                    $json_res_clean = preg_replace('/\s*```$/', '', $json_res_clean);
                    
                    $data = json_decode($json_res_clean, true);
                    if (json_last_error() === JSON_ERROR_NONE && !empty($data['question_title'])) {
                        return [
                            'question_title' => $data['question_title'],
                            'question_body'  => $data['question_body'],
                            'answer_body'    => $data['answer_body'],
                            'category'       => $data['category'],
                            'tags'           => $data['tags']
                        ];
                    }
                }
            }
        }

        // Fallback robust AI Content Simulator specifically for BD Tech Niche
        $topics = [
            [
                'q_title' => 'কিভাবে ওয়েবসাইটে ফ্রি SSL Certificate সেটআপ করবো?',
                'q_body'  => 'আমি নতুন একটি ওয়েবসাইট বানিয়েছি কিন্তু ব্রাউজারে Not Secure দেখাচ্ছে। কিভাবে বিনামূল্যে লাইফটাইম SSL এড করা যায়? বিস্তারিত জানাবেন।',
                'a_body'  => 'Cloudflare ব্যবহার করে খুব সহজেই ফ্রি SSL সেটআপ করতে পারেন। প্রথমে Cloudflare এ একাউন্ট খুলে আপনার ডোমেইনটি এড করুন এবং Namecheap বা আপনার ডোমেইন প্যানেল থেকে Nameserver পরিবর্তন করে Cloudflare এরটা দিন। এরপর SSL/TLS অপশন থেকে "Flexible" বা "Full" সিলেক্ট করুন। সাথে সাথে আপনার সাইটে https:// চালু হয়ে যাবে।',
                'category' => 'Web Development',
                'tags' => ['SSL Certificate', 'Cloudflare', 'Free SSL', 'Web Security']
            ],
            [
                'q_title' => 'ল্যাপটপ অতিরিক্ত গরম হয়ে যাচ্ছে, কী করণীয়?',
                'q_body'  => 'কয়েকদিন ধরে আমার উইন্ডোজ ল্যাপটপ অনেক গরম হয়ে যাচ্ছে এবং স্লো কাজ করছে। এর সমাধান কি?',
                'a_body'  => 'ল্যাপটপ গরম হওয়ার মূল কারণ সাধারণত ধুলাবালি এবং থার্মাল পেস্ট শুকিয়ে যাওয়া। প্রথমে ল্যাপটপের পেছনের ফ্যান বা এয়ার ভেন্ট পরিষ্কার করুন। সম্ভব হলে ভালো মানের থার্মাল পেস্ট (যেমন Arctic MX-4) লাগিয়ে নিন। এছাড়া Task Manager চেক করে দেখুন কোনো অপ্রয়োজনীয় সফটওয়্যার ব্যাকগ্রাউন্ডে CPU ব্যবহার করছে কিনা।',
                'category' => 'Android',
                'tags' => ['Laptop Heating', 'Windows 10', 'Laptop Overheating', 'Tech Guide']
            ],
            [
                'q_title' => 'গুগল এডসেন্স এপ্রুভাল পাওয়ার সহজ উপায় কী?',
                'q_body'  => 'আমার একটি নতুন ব্লগ সাইট আছে। কতগুলো পোস্ট লিখলে এবং কি কি নিয়ম মানলে দ্রুত এডসেন্স পাওয়া যায়?',
                'a_body'  => 'এডসেন্স পাওয়ার জন্য সবচেয়ে গুরুত্বপূর্ণ হলো ১০০% ইউনিক এবং ভ্যালুয়েবল কন্টেন্ট। কমপক্ষে ২০-২৫টি ভালো মানের (১০০০+ শব্দের) আর্টিকেল লিখুন। ওয়েবসাইটে About Us, Contact Us, Privacy Policy, এবং Terms & Conditions পেজগুলো অবশ্যই রাখবেন। সাইটের নেভিগেশন সিম্পল রাখুন এবং কোনো কপি কন্টেন্ট ব্যবহার করবেন না।',
                'category' => 'SEO Guide',
                'tags' => ['Google AdSense', 'Blog Approval', 'Make Money Online', 'SEO Guide']
            ],
            [
                'q_title' => 'কিভাবে মোবাইল দিয়ে ঘরে বসে অনলাইন আর্নিং করা যায়?',
                'q_body'  => 'আমি একজন ছাত্র। পড়ালেখার পাশাপাশি মোবাইল দিয়ে ছোটখাটো কাজ করে কিভাবে বিকাশ বা নগদে পেমেন্ট নিয়ে টাকা ইনকাম করা যায়?',
                'a_body'  => 'মোবাইল দিয়ে আয়ের জন্য আপনি ট্রাস্টেড পিটিসি সাইট, মাইক্রোজব সাইট (যেমন SproutGigs, MicroWorkers) অথবা কন্টেন্ট রাইটিং করতে পারেন। এছাড়া ফেসবুক পেজ বা ইউটিউবে শর্টস ভিডিও বানিয়ে মনিটাইজেশনের মাধ্যমে এবং বিকাশ/নগদ এ সরাসরি উইথড্র নেওয়া যায়। তবে কোনো ইনভেস্টমেন্ট সাইটে টাকা দিয়ে প্রতারিত হবেন না।',
                'category' => 'Online Earning',
                'tags' => ['Online Earning', 'Mobile Earning', 'Freelancing', 'Bkash Payment']
            ],
            [
                'q_title' => 'ফেসবুক একাউন্ট হ্যাকিং থেকে সুরক্ষিত রাখার নিয়ম কী?',
                'q_body'  => 'আমার ফেসবুক প্রোফাইল নিরাপদ রাখতে কী কী সিকিউরিটি সেটিংস অন করতে হবে? হ্যাকারদের হাত থেকে বাঁচার উপায় জানাবেন।',
                'a_body'  => 'ফেসবুক আইডি সুরক্ষিত রাখতে প্রথমে Two-Factor Authentication (2FA) অন করুন। গুগল অথেনটিকেটর অ্যাপ ব্যবহার করা সবচেয়ে নিরাপদ। এছাড়া কখনো অপরিচিত লিংকে ক্লিক করবেন না বা কোথাও পাসওয়ার্ড টাইপ করবেন না। ফেসবুকের সেটিংস থেকে "Alerts about unrecognized logins" অন করে রাখুন যাতে কেউ লগইন করার চেষ্টা করলেই মেসেজ আসে।',
                'category' => 'Hacking',
                'tags' => ['Facebook Security', 'Cyber Security', 'Two Factor Authentication', 'Hacking Defense']
            ]
        ];
        
        $choice = $topics[array_rand($topics)];
        
        return [
            'question_title' => $choice['q_title'],
            'question_body'  => $choice['q_body'],
            'answer_body'    => $choice['a_body'],
            'category'       => $choice['category'],
            'tags'           => $choice['tags']
        ];
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
