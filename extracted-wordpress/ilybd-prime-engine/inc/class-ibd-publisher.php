<?php
class IBD_Publisher {

    public static function auto_publish($topic, $engine = 'gemini') {
        // Step 1: Initial Draft Generation by Creator Agent
        $content = ($engine == 'gemini') 
            ? IBD_Gemini_Engine::generate_rich_content($topic) 
            : IBD_OpenAI_Engine::generate_rich_content($topic);

        if (!$content) return false;

        // Ensure we assign to a general bot author for initial draft
        $authors = get_users(['role' => 'administrator', 'fields' => 'ID']);
        $random_author = $authors[array_rand($authors)];

        // We insert it as 'draft' so the AI Reviewer Manager can pick it up
        $post_id = wp_insert_post([
            'post_title'   => wp_strip_all_tags($topic),
            'post_content' => $content,
            'post_status'  => 'draft',
            'post_author'  => $random_author,
            'post_type'    => 'post',
        ]);

        if ($post_id) {
            update_post_meta($post_id, '_ilybd_ai_generation_stage', 'needs_expert_review');
            IBD_Key_Rotator::log_activity("DRAFT CREATED: Auto_publish generated draft ID $post_id for topic: $topic");
            
            // Trigger AI Review Immediately
            self::ai_expert_review($post_id);
            return $post_id;
        }
        return false;
    }

    public static function ai_expert_review($post_id) {
        $post = get_post($post_id);
        if (!$post || $post->post_status !== 'draft') return false;

        $api_key = IBD_Key_Rotator::get_valid_gemini_key();
        if (!$api_key) return false;

        $raw_content = $post->post_content;
        $title = $post->post_title;

        // Auto-assign specific expert personas based on keywords
        $persona = "Elite Review Manager and Senior Editor";
        $design_style = "Style A (Neon Cyberpunk: Dark blue, glowing cyan)";
        $colors = ['bg' => '#050a11', 'accent' => '#00f0ff', 'text' => '#e6edf3'];
        
        if (strpos(strtolower($title), 'seo') !== false || strpos(strtolower($title), 'blogging') !== false) {
            $persona = "Elite Digital Marketer and SEO Review Specialist";
            $design_style = "Style B (Clean Modern Tech: Deep graphite, bright violet)";
            $colors = ['bg' => '#101014', 'accent' => '#b142ff', 'text' => '#e0e0e0'];
        } elseif (strpos(strtolower($title), 'finance') !== false || strpos(strtolower($title), 'earn') !== false) {
            $persona = "Experienced Financial Editor and Quality Assurance Expert";
            $design_style = "Style C (Luxury Finance: Slate gray, emerald green)";
            $colors = ['bg' => '#111518', 'accent' => '#00ff41', 'text' => '#dcdcdc'];
        }

        // PROMPT FOR THE AI REVIEW MANAGER
        $prompt = "You are an {$persona} for iloveyoubd.com.
Task: Review and fix the following draft article titled '$title'.
Rules:
1. Completely remove ALL robotic AI intro elements like 'Reviewer:', 'Pillar Content:', 'Sure, here is the article', etc.
2. Fix any fact-checking errors or mismatched topics.
3. Ensure human-like natural Bengali tone (Human Emotion Touch) in the intro.
4. Verify there are at least 3-4 properly structured sections with HTML semantic tags.
5. Provide a completely UNIQUE inline-styled aesthetic wrap for this article. Use {$design_style}. Wrap the main content in a <div style='background:{$colors['bg']}; color:{$colors['text']}; ...'> block. Use {$colors['accent']} for H2 and H3 tags.
6. Return ONLY the finalized, pristine, error-free HTML content. Do NOT include markdown code blocks.

Draft Content to Review:
$raw_content";

        $model_candidates = [
            'gemini-3.5-flash',
            'gemini-2.5-flash',
            'gemini-3.1-flash-lite',
            'gemini-2.5-flash-lite',
            'gemini-2.0-flash',
            'gemini-1.5-flash'
        ];

        $data = ["contents" => [["parts" => [["text" => $prompt]]]]];
        $response = null;
        $success = false;

        foreach ($model_candidates as $model_name) {
            $api_url = "https://generativelanguage.googleapis.com/v1beta/models/" . $model_name . ":generateContent?key=" . $api_key;
            
            $response = wp_remote_post($api_url, [
                'body'      => json_encode($data),
                'headers'   => ['Content-Type' => 'application/json'],
                'timeout'   => 45, // Extended timeout for rigorous review
                'sslverify' => false
            ]);

            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                $body_arr = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($body_arr['candidates'][0]['content']['parts'][0]['text'])) {
                    $success = true;
                    break;
                }
            }
        }

        if (!$success) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $reviewed_content = $result['candidates'][0]['content']['parts'][0]['text'];
            
            // Strip markdown formatting if AI added it
            $reviewed_content = preg_replace('/```html\s*([\s\S]*?)\s*```/', '$1', $reviewed_content);
            $reviewed_content = preg_replace('/```\s*([\s\S]*?)\s*```/', '$1', $reviewed_content);

            // Internal Linking logic added cleanly at the end
            $recent = get_posts(['numberposts' => 3, 'post_status' => 'publish']);
            if($recent) {
                $links = '<div class="ibd-read-more" style="background:#0d1117; border-left:4px solid '.$colors['accent'].'; padding:15px; margin:20px 0;">';
                $links .= '<h4 style="color:#fff; margin-top:0;">🔗 Related Exclusive Insights:</h4><ul style="color:#58a6ff;">';
                foreach($recent as $r) {
                    $links .= '<li><a href="'.get_permalink($r->ID).'" style="color:#58a6ff; text-decoration:none;">'.$r->post_title.'</a></li>';
                }
                $links .= '</ul></div>';
                $reviewed_content .= $links;
            }

            // NEXT LEVEL AI THUMBNAIL GENERATION WITH DYNAMIC GEMINI ENHANCEMENT
            $thumbnail_prompt = self::generate_dynamic_thumbnail_prompt_with_gemini($post_id, $title, $reviewed_content);
            self::generate_and_attach_thumbnail($post_id, $thumbnail_prompt, $title);

            // Move to Publish directly via the AI Editor
            wp_update_post([
                'ID'           => $post_id,
                'post_content' => trim($reviewed_content),
                'post_status'  => 'publish'
            ]);

            update_post_meta($post_id, '_ilybd_ai_generation_stage', 'published_by_ai_editor');
            IBD_Key_Rotator::log_activity("REVIEW SUCCESS: AI Editor perfectly reviewed and published ID $post_id with unique {$design_style} template and High-CTR custom Thumbnail.");
            return true;
        }
        return false;
    }

    public static function generate_dynamic_thumbnail_prompt_with_gemini($post_id, $title, $content) {
        $api_key = IBD_Key_Rotator::get_valid_gemini_key();
        if (!$api_key) {
            return "beautiful futuristic horizontal graphic design, topic: " . esc_attr($title) . ", cyber blue, black background, modern tech theme";
        }

        // Gather categories and tags
        $category_names = [];
        $categories = get_the_category($post_id);
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $cat) {
                $category_names[] = $cat->name;
            }
        }
        $tag_names = [];
        $tags = get_the_tags($post_id);
        if (!empty($tags) && !is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $tag_names[] = $tag->name;
            }
        }

        $cats_str = implode(', ', $category_names);
        $tags_str = implode(', ', $tag_names);
        // Extract plain text representing the content to avoid HTML formatting noise during analysis
        $excerpt = wp_strip_all_tags(substr($content, 0, 1500)); 

        $system_prompt = "You are an AI Expert Visual Prompt Engineer for premium high-CTR technology blog thumbnails.
Analyze the following article details to design an absolute masterpiece featured image thumbnail:
Title: {$title}
Categories: {$cats_str}
Tags: {$tags_str}
Excerpt: {$excerpt}

Your response must be a valid, raw JSON object (strictly no markdown formatting block wraps, no text prefix/suffix, just raw json) containing search analytics-backed fields:
1. \"thumbnail_text\": A short, extremely punchy high-energy English text of 2 to 4 words (strictly maximum 4 words) suitable to display in a massive bold glowing cyber-font. Use uppercase. Example: \"SPEED UP WORDPRESS\", \"SECURE YOUR PC\", \"BEST AI TOOLS\".
2. \"enhanced_subject\": A highly descriptive, cinematic English scenery description (20 to 30 words) for the focal image. Incorporate the topic's essence.
   - If category contains 'Cyber Security' or 'Security', include: 'cyber security environment, digital protection, security shield, network defense, advanced technology effects'.
   - If AI, Neural, or Robot, include: 'artificial intelligence, futuristic robot, neural network, modern AI technology'.
   - If WordPress, Web, or Code, include: 'WordPress dashboard, website interface, performance charts, modern web development'.
   - If SEO, Traffic, Page, or Google, include: 'Google search ranking, SEO analytics, growth chart, website traffic increase'.
3. \"is_person_related\": Boolean (true if the post focuses on an individual, personal interview, human expert, or human expression where a face/portrait dramatically boosts CTR; false otherwise).

Example response format:
{
  \"thumbnail_text\": \"BOOST SEO TRAFFIC\",
  \"enhanced_subject\": \"A glowing futuristic holograph of Google search ranking growth charts over a dark metallic server room deck, SEO analytics and website traffic increase neon effects\",
  \"is_person_related\": false
}";

        $data = ["contents" => [["parts" => [["text" => $system_prompt]]]]];
        $model_candidates = [
            'gemini-2.5-flash',
            'gemini-3.5-flash',
            'gemini-3.1-flash-lite',
            'gemini-2.5-flash-lite',
            'gemini-2.0-flash'
        ];

        $response = null;
        $success = false;
        $json_text = '';

        foreach ($model_candidates as $model_name) {
            $api_url = "https://generativelanguage.googleapis.com/v1beta/models/" . $model_name . ":generateContent?key=" . $api_key;
            
            $response = wp_remote_post($api_url, [
                'body'      => json_encode($data),
                'headers'   => ['Content-Type' => 'application/json'],
                'timeout'   => 15,
                'sslverify' => false
            ]);

            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                $body_arr = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($body_arr['candidates'][0]['content']['parts'][0]['text'])) {
                    $json_text = $body_arr['candidates'][0]['content']['parts'][0]['text'];
                    $success = true;
                    break;
                }
            }
        }

        // Set default fallbacks in case of external API issues
        $fallback_text = "CYBER NEXT GEN";
        $fallback_subject = "An advanced holographic command terminal glowing with cybernetic patterns and virtual interface visuals";
        $fallback_person = false;

        // Custom default heuristics based on title keywords if API fails
        if (!$success) {
            $title_lower = strtolower($title);
            if (strpos($title_lower, 'wordpress') !== false || strpos($title_lower, 'speed') !== false) {
                $fallback_text = "SPEED UP WP";
                $fallback_subject = "A high-tech glowing WordPress dashboard interface showing blazing speed boost indicators and performance charts";
            } elseif (strpos($title_lower, 'security') !== false || strpos($title_lower, 'cyber') !== false) {
                $fallback_text = "SECURE NETWORK";
                $fallback_subject = "A neon-glowing cyber defense shield hovering over futuristic servers with active terminal streams";
            } elseif (strpos($title_lower, 'ai') !== false || strpos($title_lower, 'chatgpt') !== false) {
                $fallback_text = "ADVANCED AI";
                $fallback_subject = "An ultra modern neural network stream connecting to a glowing cybernetic humanoid robot interface";
            } elseif (strpos($title_lower, 'seo') !== false || strpos($title_lower, 'traffic') !== false) {
                $fallback_text = "GROW TRAFFIC";
                $fallback_subject = "A dynamic 3D virtual SEO analytics chart shooting upwards into a digital infinite sky of Google database metrics";
            }
        } else {
            // Clean markdown block wraps if AI is stubborn
            $json_text = preg_replace('/```json\s*([\s\S]*?)\s*```/', '$1', $json_text);
            $json_text = preg_replace('/```\s*([\s\S]*?)\s*```/', '$1', $json_text);
            $json_text = trim($json_text);
            
            $parsed = json_decode($json_text, true);
            if (isset($parsed['thumbnail_text']) && isset($parsed['enhanced_subject'])) {
                $fallback_text = trim($parsed['thumbnail_text']);
                $fallback_subject = trim($parsed['enhanced_subject']);
                $fallback_person = isset($parsed['is_person_related']) ? (bool)$parsed['is_person_related'] : false;
            }
        }

        // Construct high-yield CTR Prompt following the 2040 Global Template
        $prompt_parts = [];
        $prompt_parts[] = "An ultra professional, high-CTR premium blog featured image thumbnail, 16:9 ratio";
        
        // Large Typography Rules for Overlay in image generator
        $prompt_parts[] = "featuring massive bold glowing 3D futuristic cybernetic neon typography text reading: \"" . strtoupper($fallback_text) . "\" centered cleanly";
        
        // Dynamic enhanced subject from AI
        $prompt_parts[] = "Subject: " . $fallback_subject;
        
        // Dynamic person CTR logic
        if ($fallback_person) {
            $prompt_parts[] = "including a striking hyper-realistic human character with deep expressive emotion, a professional portrait shot with dramatic studio lighting";
        }

        // Color and Theme guidelines (2040 cyber/dark style)
        $prompt_parts[] = "Brand Style: deep cyber blue and charcoal cosmic slate background (#050a11), vibrant high-contrast glowing neon cyan (#00f0ff) details, white highlights, sleek modern technology atmosphere";
        
        // Cinematic/Render properties
        $prompt_parts[] = "perfect design, high-CTR magazine cover, realistic elements, strong focal point, mobile friendly, cinematic epic look, sharp details, Ultra HD, 4K resolution";
        
        // Negative / safety guidance
        $prompt_parts[] = "no watermark, no blurry background, no low-quality graphics, no cartoonish look, no ugly interfaces";

        return implode(", ", $prompt_parts);
    }

    private static function generate_and_attach_thumbnail($post_id, $prompt, $title) {
        $seed = rand(10000, 99999);
        $encoded_prompt = urlencode(trim($prompt));
        $image_url = "https://image.pollinations.ai/prompt/{$encoded_prompt}?width=1200&height=630&seed={$seed}&nologo=true&enhance=true";
        
        $image_data = wp_remote_get($image_url, array('timeout' => 25, 'sslverify' => false));
        if (!is_wp_error($image_data)) {
            $upload_dir = wp_upload_dir();
            $filename = 'ai-thumb-' . $post_id . '-' . $seed . '.jpg';
            if (wp_mkdir_p($upload_dir['path'])) {
                $file = $upload_dir['path'] . '/' . $filename;
            } else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }
            
            file_put_contents($file, wp_remote_retrieve_body($image_data));
            $wp_filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => sanitize_file_name($title),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            
            $attach_id = wp_insert_attachment($attachment, $file, $post_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);
            wp_update_attachment_metadata($attach_id, $attach_data);
            set_post_thumbnail($post_id, $attach_id);
        }
    }

    public static function create_review_expert_roles() {
        if (!get_role('ilybd_review_manager')) {
            add_role('ilybd_review_manager', 'Review & Repair Manager (Expert)', [
                'read' => true,
                'edit_posts' => true,
                'edit_others_posts' => true,
                'publish_posts' => true,
                'read_private_posts' => true,
                'edit_private_posts' => true,
                'edit_published_posts' => true,
                'upload_files' => true,
            ]);
        }
    }
}
// Run role creation on init
add_action('init', ['IBD_Publisher', 'create_review_expert_roles']);

