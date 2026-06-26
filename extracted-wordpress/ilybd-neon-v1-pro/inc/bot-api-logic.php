<?php
/**
 * IBD CYBER BOT - ULTIMATE GEMINI ENGINE (MAYA AI MASTER LOGIC)
 * High-performance, highly secure connection class supporting key rotation, multi-models, custom instructions, and automatic illustration tag injectors.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. WordPress Admin Menu Layout
add_action('admin_menu', 'cyber_bot_integrated_menu');
function cyber_bot_integrated_menu() {
    add_menu_page('Cyber Bot Settings', 'Cyber Bot', 'manage_options', 'cyber-bot-settings', 'cyber_bot_render_settings', 'dashicons-rest-api');
}

function cyber_bot_render_settings() {
    ?>
    <div class="wrap" style="background: #060a15; color: #00f0ff; padding: 30px; border: 1px solid rgba(0, 240, 255, 0.25); border-radius: 16px; font-family: 'Inter', sans-serif;">
        <h1 style="color: #fff; font-weight: 800; border-bottom: 2px solid #00f0ff; padding-bottom: 12px; margin-bottom: 20px; font-family: 'Rajdhani', sans-serif; display: flex; align-items: center; gap: 10px;">
            <span style="background: #00f0ff; color: #000; width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold;">M</span>
            MAYA AI SYSTEM CONTROL CENTER
        </h1>
        <p style="color: #64748b; font-size: 13px;">iloveyoubd-neon-v1-pro-theme compatible AI framework powering Gemini and multi-user scaling quotas.</p>
        
        <form method="post" action="options.php" style="margin-top: 25px;">
            <?php
            settings_fields('cyber_bot_logic_group');
            $current_keys = get_option('cyber_bot_api_keys');
            if(empty($current_keys)) { $current_keys = "AIzaSyBAcwAPXPzNfeGQ6XHDR-EaNRsHqhkTro8"; }
            ?>
            <div style="background: #0c1224; border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 10px; color: #00f0ff; font-size: 14px;">ADMIN KEY ROTATION POOL (প্রতি লাইনে একটি করে চিল্ড এপিআই কি দিন):</label>
                <textarea name="cyber_bot_api_keys" rows="6" style="background: #040812; color: #fff; border: 1px solid rgba(0, 240, 255, 0.2); width: 100%; font-family: monospace; padding: 12px; border-radius: 8px; font-size: 12px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#00f0ff';"><?php echo esc_textarea($current_keys); ?></textarea>
                <span style="color: #475569; font-size: 11px; margin-top: 6px; display: block;">সিস্টেমের লিমিট এড়াতে একাধিক API Key দিতে পারেন। কোটা শেষ হলে মায়া স্বয়ংক্রিয়ভাবে পরবর্তী সচল কি-তে সুইচ করে প্রসেস করবে।</span>
            </div>
            
            <?php submit_button('SAVE ADMINISTRATIVE CONFIG', 'primary', 'submit', true, ['style' => 'background: linear-gradient(135deg, #00f0ff, #0072ff); color: #000; border: none; font-weight: bold; border-radius: 8px; padding: 10px 24px; cursor: pointer; box-shadow: 0 4px 15px rgba(0, 240, 255, 0.25);']); ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'cyber_bot_logic_register');
function cyber_bot_logic_register() {
    register_setting('cyber_bot_logic_group', 'cyber_bot_api_keys');
}

// 2. Chatbot Core Request Execution Gateway
add_action('wp_ajax_cyber_bot_request', 'handle_cyber_bot_request');
add_action('wp_ajax_nopriv_cyber_bot_request', 'handle_cyber_bot_request');

function handle_cyber_bot_request() {
    // ১. হাইজ্যাকিং রোধ (CORS ডোমেইন রেস্ট্রিকশন)
    if (function_exists('ilybd_is_api_request_hijacked') && ilybd_is_api_request_hijacked()) {
        wp_send_json_error(['message' => '> [SECURITY ALERT]: API request origin mismatch. Cross-domain hijacking is strictly prohibited by our Antihijacking Shields.']);
        return;
    }

    // ২. রেট লিমিট প্রটেকশন (প্রতি মিনিটে সর্বোচ্চ ৩০টি রিকোয়েস্ট)
    if (function_exists('ilybd_is_rate_limited') && ilybd_is_rate_limited('cyber_bot_api', 30, 60)) {
        if (function_exists('ilybd_trigger_intelligence_metric')) {
            ilybd_trigger_intelligence_metric('rate_limits_triggered');
        }
        wp_send_json_success("> [মায়া সিকিউরিটি সিগন্যাল]: আপনি খুব দ্রুত রিকোয়েস্ট পাঠাচ্ছেন। স্প্যাম এড়াতে অনুগ্রহ করে কিছুক্ষণ পর আবার চেষ্টা করুন (Rate Limited: 30 requests per minute).");
        return;
    }

    if ( !isset($_POST['user_query']) ) { 
        wp_send_json_error(['message' => 'Query not provided.']); 
    }
    
    $user_query = sanitize_text_field($_POST['user_query']);
    
    // Dynamic Grounding: Search local WordPress database for matching articles
    $grounded_knowledge = "";
    $search_results = new WP_Query([
        's'              => $user_query,
        'posts_per_page' => 3,
        'post_status'    => 'publish'
    ]);
    
    if ($search_results->have_posts()) {
        $articles = [];
        while ($search_results->have_posts()) {
            $search_results->the_post();
            $articles[] = "- [" . get_the_title() . "] (" . get_permalink() . "): " . wp_trim_words(strip_tags(get_the_excerpt()), 30, '...');
        }
        wp_reset_postdata();
        
        $grounded_knowledge .= "\n\niloveyoubd.com-এর প্রাসঙ্গিক রেফারেন্স লিঙ্ক (অনুরোধকৃত বিষয়ে আমাদের সাইটের আর্টিকেল পেইজ):\n" . implode("\n", $articles);
    }
    
    // Priority Youtube Channel Grounding
    if (preg_match('/(video|ভিডিও|টিউটোরিয়াল|ইউটিউব|youtube|চ্যানেল|শিখব|learn|how to)/i', $user_query)) {
        $grounded_knowledge .= "\n\niloveyoubd-এর অফিশিয়াল ইউটিউব চ্যানেল রেফারেন্স: https://www.youtube.com/@ilybd (যেখানে এই বিষয়ের প্রফেশনাল নিয়ন ভিডিও টিউটোরিয়াল রয়েছে। ব্যবহারকারীকে এই ভিডিও লিঙ্কটি দেখার জন্য উৎসাহিত করুন)।";
    }

    $modified_query = "User Query: " . $user_query;
    if (!empty($grounded_knowledge)) {
        $modified_query .= "\n\n[CONTEXT GROUNDING]:\n" . $grounded_knowledge . "\n\nঅনুগ্রহ করে উপরের প্রাসঙ্গিক লিঙ্ক এবং তথ্যগুলো আপনার উত্তরের ভেতরে অত্যন্ত চমৎকারভাবে যুক্ত করুন এবং রেফারেন্সসমূহ বাংলায় উপস্থাপন করুন।";
    }
    
    // Read optional model, system instruction, and temperature
    $target_model = isset($_POST['model']) ? sanitize_text_field($_POST['model']) : 'gemini-3.5-flash';
    $custom_sys = isset($_POST['system_instruction']) ? sanitize_text_field($_POST['system_instruction']) : 'You are Maya (মায়া), the highly professional, helpful, and extremamente competent assistant of iloveyoubd.com. Write in flawless Bangla.';
    $temperature = isset($_POST['temperature']) ? floatval($_POST['temperature']) : 0.7;

    // Check if prompt requests illustration drawing
    $is_draw_request = (preg_match('/(draw|paint|create|generate|ছবি|আঁকো|image|art|graphic|illustration)/i', $user_query));

    if ($is_draw_request) {
        // Automatically inject graphic illustration metadata inside success string
        wp_send_json_success("[GENERATE_IMAGE: " . $user_query . "]");
        return;
    }

    // Merge custom keys and admin options
    $admin_keys_raw = get_option('cyber_bot_api_keys', 'AIzaSyBAcwAPXPzNfeGQ6XHDR-EaNRsHqhkTro8');
    $client_keys_raw = isset($_POST['custom_keys']) ? sanitize_textarea_field($_POST['custom_keys']) : '';

    $combined_raw = $client_keys_raw . "\n" . $admin_keys_raw;
    $api_keys = array_values(array_filter(array_map('trim', explode("\n", $combined_raw))));

    if (empty($api_keys)) {
        wp_send_json_success("> [মায়া সিগন্যাল]: দুঃখিত, সিস্টেমে কোনো সচল Google API Key পাওয়া যাচ্ছে না। অনুগ্রহ করে সেটিংসে গিয়ে এপিআই কি দিন।");
        return;
    }

    // Map selected model names to Google Gemini REST endpoints
    $model_mapping_aliases = [
        'gemini-3.5-flash' => 'gemini-2.5-flash',
        'gemini-3.1-pro-preview' => 'gemini-2.5-pro',
        'maya-ultra' => 'gemini-2.5-pro'
    ];

    $resolved_model = isset($model_mapping_aliases[$target_model]) ? $model_mapping_aliases[$target_model] : 'gemini-2.0-flash';

    $successful_text_reply = null;
    $connection_errors = [];

    // Loop through the rotated keys database
    foreach ($api_keys as $idx => $key) {
        // Ordered list of models to try for this key to utilize separate quotas
        $model_candidates = [
            $resolved_model,
            'gemini-3.5-flash',
            'gemini-2.5-flash',
            'gemini-3.1-flash-lite',
            'gemini-2.5-flash-lite',
            'gemini-2.0-flash',
            'gemini-1.5-flash'
        ];
        // Remove duplicates while preserving preferred ordering
        $model_candidates = array_values(array_unique($model_candidates));

        foreach ($model_candidates as $model_name) {
            $api_endpoint = "https://generativelanguage.googleapis.com/v1beta/models/" . $model_name . ":generateContent?key=" . $key;

            $payload = [
                "contents" => [
                    [
                        "role" => "user",
                        "parts" => [
                            ["text" => $modified_query]
                        ]
                    ]
                ],
                "generationConfig" => [
                    "temperature" => $temperature,
                    "maxOutputTokens" => 1600
                ]
            ];

            if (!empty($custom_sys)) {
                $payload["system_instruction"] = [
                    "parts" => [
                        ["text" => $custom_sys]
                    ]
                ];
            }

            $response = wp_remote_post($api_endpoint, [
                'body'      => json_encode($payload),
                'headers'   => ['Content-Type' => 'application/json'],
                'method'    => 'POST',
                'timeout'   => 12,
                'sslverify' => false,
            ]);

            if (is_wp_error($response)) {
                $connection_errors[] = "Key #" . ($idx + 1) . " with " . $model_name . " (Network issue: " . $response->get_error_message() . ")";
                continue;
            }

            $status_code = wp_remote_retrieve_response_code($response);
            $result_body = json_decode(wp_remote_retrieve_body($response), true);

            if ($status_code !== 200) {
                $error_message = isset($result_body['error']['message']) ? $result_body['error']['message'] : "HTTP Status Code " . $status_code;
                $connection_errors[] = "Key #" . ($idx + 1) . " (" . $model_name . "): status " . $status_code . " - " . $error_message;
                
                // If key is totally invalid (400) or unauthorised (403), skip this key entirely
                if ($status_code === 400 || $status_code === 403) {
                    break;
                }
                continue; // Do NOT break on 429 so we can try other models on the same key!
            }

            if (isset($result_body['candidates'][0]['content']['parts'][0]['text'])) {
                $successful_text_reply = $result_body['candidates'][0]['content']['parts'][0]['text'];
                break 2; // Break both levels of loops
            } else {
                $connection_errors[] = "Key #" . ($idx + 1) . " (" . $model_name . "): Unexpected structure format";
                continue;
            }
        }
    }

    if ($successful_text_reply !== null) {
        wp_send_json_success($successful_text_reply);
    } else {
        $error_summary_report = implode(", ", $connection_errors);
        wp_send_json_success("> [মায়া কোয়ান্টাম সংযোগ ব্যাহত]: এপিআই কিগুলোর ডাটা লিমিট বা অ্যাক্সেস রিভোকেড হয়েছে।\n\nত্রুটির রিপোর্ট: " . $error_summary_report . "\n\nদয়া করে নতুন একটি সচল এপিআই কি (API Key) সিস্টেমে যোগ করুন।");
    }
}
