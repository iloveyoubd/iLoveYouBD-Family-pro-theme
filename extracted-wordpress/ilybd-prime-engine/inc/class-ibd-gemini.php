<?php
class IBD_Gemini_Engine {

    public static function generate_rich_content($topic) {
        $api_key = IBD_Key_Rotator::get_active_key('gemini');
        if (!$api_key) return false;

        // Auto-assign specific expert personas based on keywords
        $persona = "Elite Bengali Ethical Hacker and Full-Stack Developer";
        if (strpos(strtolower($topic), 'seo') !== false || strpos(strtolower($topic), 'blogging') !== false) {
            $persona = "Elite Digital Marketer and Senior SEO Strategist";
        } elseif (strpos(strtolower($topic), 'finance') !== false || strpos(strtolower($topic), 'earn') !== false) {
            $persona = "Experienced Financial Analyst and Digital Income Consultant";
        } elseif (strpos(strtolower($topic), 'health') !== false || strpos(strtolower($topic), 'স্বাস্থ্য') !== false) {
            $persona = "Verified Healthcare Professional and Wellness Expert";
        }

        $prompt = "You are an {$persona} writing for iloveyoubd.com.
Task: Write an incredibly detailed, valuable, 100% human-like article in pristine Bengali about: '{$topic}'

Requirements for Top 10 Google Ranking & AdSense policy alignment (STRICTLY ENFORCED):
1. **Length & Depth**: MUST BE EXTREMELY LONG. Minimum 2000 to 4500 words. Go into extreme depth, covering advanced insights, step-by-step guides, and historical context if needed. Expand every point extensively.
2. **Human Tone & Hook**: Start directly with an emotional, real-life problem story (Human Emotion Touch).
CRITICAL: NEVER write 'Reviewer:', 'Pillar Content:', 'Here is the article', or any robotic greeting. Start the story immediately. Write like a real human sharing a personal experience.
3. **Structure**: 
   - Minimum 6 to 8 main sections using proper H2 (<h2 style='color:#00f0ff;'>) and H3 tags.
   - Include a 'Real Device Testing Block' or detailed practical 'Source Guideline' section with real-world scenarios.
4. **Interactive Table**: Include an interactive & clean HTML comparison table.
5. **FAQ Section**: Include EXACTLY 5 important FAQs to target Google PAA (People Also Ask). Use H3 for questions.
6. **Trusted References**: Include 2-3 outbound reference links to highly trusted sources (e.g. Wikipedia, Microsoft, Google Developers, WHO).

Output MUST ONLY be the HTML content. Do NOT wrap it in markdown codeblocks (```html). Write completely in beautiful, grammatically perfect Bengali except for necessary English technical terms.";

        // Use multi-model fallback to ensure high success rates
        $model_candidates = [
            'gemini-3.5-flash',
            'gemini-2.5-flash',
            'gemini-3.1-flash-lite',
            'gemini-2.5-flash-lite',
            'gemini-2.0-flash',
            'gemini-1.5-flash'
        ];
        
        $data = [
            "contents" => [["parts" => [["text" => $prompt]]]],
            "generationConfig" => [
                "temperature" => 0.7,
                "maxOutputTokens" => 8000 // Guarantee large outputs
            ]
        ];

        $response = null;
        $success = false;
        
        foreach ($model_candidates as $model_name) {
            $api_url = "https://generativelanguage.googleapis.com/v1beta/models/" . $model_name . ":generateContent?key=" . $api_key;
            
            $response = wp_remote_post($api_url, [
                'body'      => json_encode($data),
                'headers'   => ['Content-Type' => 'application/json'],
                'timeout'   => 45, // Extended timeout for long generations
                'sslverify' => false
            ]);

            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                $body = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                    $success = true;
                    break;
                }
            }
        }

        if (!$success) {
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
        $content = preg_replace('/```html\s*([\s\S]*?)\s*```/', '$1', $content);
        $content = preg_replace('/```\s*([\s\S]*?)\s*```/', '$1', $content);
        
        // Remove known AI hallucination artifacts
        $content = str_replace(['Reviewer:', 'Pillar Content:', 'Sure, here is the article:', 'Here is the comprehensive article'], '', $content);

        return "<div class='ibd-rich-post-container'>" . trim($content) . "</div>";
    }
}
