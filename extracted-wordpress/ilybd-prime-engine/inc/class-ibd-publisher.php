<?php
class IBD_Publisher {

    public static function publish_post($topic, $engine = 'gemini') {
        $content = ($engine == 'gemini') 
            ? IBD_Gemini_Engine::generate_rich_content($topic) 
            : IBD_OpenAI_Engine::generate_rich_content($topic);

        if (!$content) return false;

        // Author Rotation
        $authors = get_users(['role' => 'administrator', 'fields' => 'ID']);
        $random_author = $authors[array_rand($authors)];

        // Internal Linking logic
        $recent = get_posts(['numberposts' => 2]);
        if($recent) {
            $links = '<div class="ibd-read-more"><h4>Related Analysis:</h4><ul>';
            foreach($recent as $r) $links .= '<li><a href="'.get_permalink($r->ID).'">'.$r->post_title.'</a></li>';
            $links .= '</ul></div>';
            $content .= $links;
        }

        $post_id = wp_insert_post([
            'post_title'   => wp_strip_all_tags($topic),
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_author'  => $random_author,
            'post_type'    => 'post',
        ]);

        if ($post_id) {
            update_post_meta($post_id, '_yoast_wpseo_metadesc', substr(wp_strip_all_tags($content), 0, 160));
            IBD_Key_Rotator::log_activity("SUCCESS: Published post ID $post_id by Author ID $random_author");
            return $post_id;
        }
        return false;
    }
}
