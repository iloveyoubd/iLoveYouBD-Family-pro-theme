<?php
class IBD_Gemini_Engine {

    public static function generate_rich_content($topic) {
        $api_key = IBD_Key_Rotator::get_active_key('gemini');
        if (!$api_key) return false;

        $prompt = "Write a comprehensive, SEO-friendly article about '{$topic}'. 
                   Requirements: Min 1200 words, HTML format (h2, h3, p), 
                   Cyber-style div boxes, Pros/Cons table, and FAQ Schema.";

        $api_url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $api_key;
        $data = ["contents" => [["parts" => [["text" => $prompt]]]]];

        $response = wp_remote_post($api_url, [
            'body'      => json_encode($data),
            'headers'   => ['Content-Type' => 'application/json'],
            'timeout'   => 10,
            'sslverify' => false
        ]);

        if (is_wp_error($response)) {
            IBD_Key_Rotator::switch_to_next_key('gemini');
            return self::generate_rich_content($topic);
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        $content = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';

        if (empty($content)) {
            IBD_Key_Rotator::switch_to_next_key('gemini');
            return false;
        }

        // Apply Polishing
        $content = self::apply_polishing($content);
        return $content;
    }

    private static function apply_polishing($content) {
        // Humanizing
        $phrases = ["In my professional view, ", "Interestingly, ", "Actually, ", "From a security perspective, "];
        $content = '<p>' . $phrases[array_rand($phrases)] . ltrim($content, '<p>');
        
        // Wrap in Container
        return "<div class='ibd-rich-post-container'>{$content}</div>";
    }
}
