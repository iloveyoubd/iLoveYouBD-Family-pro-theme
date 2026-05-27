<?php
class IBD_OpenAI_Engine {

    public static function generate_rich_content($topic) {
        $api_key = IBD_Key_Rotator::get_active_key('openai');
        
        if (!$api_key) {
            IBD_Key_Rotator::log_activity("Error: No OpenAI API Key found!");
            return false;
        }

        $api_url = "https://api.openai.com/v1/chat/completions";

        $data = [
            "model" => "gpt-4-turbo-preview", // অথবা আপনার পছন্দমতো মডেল
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a Cyber Security Expert and Professional Content Writer. Write 1000+ words in HTML format with hacker-style UI elements."
                ],
                [
                    "role" => "user",
                    "content" => "Write a professional, SEO-friendly article on: '{$topic}'. Include HTML boxes, tables, and FAQ."
                ]
            ],
            "max_tokens" => 3000
        ];

        $response = wp_remote_post($api_url, [
            'body'    => json_encode($data),
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $api_key
            ],
            'timeout' => 90
        ]);

        if (is_wp_error($response)) {
            IBD_Key_Rotator::switch_to_next_key('openai');
            return self::generate_rich_content($topic);
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        $content = $body['choices'][0]['message']['content'] ?? '';

        if (empty($content)) {
            IBD_Key_Rotator::switch_to_next_key('openai');
            return false;
        }

        IBD_Key_Rotator::log_activity("OpenAI successfully generated content for: " . $topic);
        return $content;
    }
}
