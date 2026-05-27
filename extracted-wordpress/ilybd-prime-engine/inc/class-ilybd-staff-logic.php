<?php
class ILYBD_AI_Staff {
    
    // এসইও এক্সপার্টের কাজ: অটোমেটিক কি-ওয়ার্ড ট্যাগ দেওয়া
    public static function seo_expert_optimize($post_id) {
        $title = get_the_title($post_id);
        update_post_meta($post_id, '_yoast_wpseo_focuskw', $title);
        IBD_Key_Rotator::log_activity("AI SEO: Keywords optimized for Post ID: $post_id");
    }

    // অ্যাডসেন্স গার্ডের কাজ: ঝুঁকিপূর্ণ কন্টেন্ট চেক
    public static function adsense_guard_scan($content) {
        $restricted_words = ['illegal', 'crack', 'hack password', 'free money'];
        foreach ($restricted_words as $word) {
            if (stripos($content, $word) !== false) {
                return false; // ঝুঁকিপূর্ণ কন্টেন্ট ধরা পড়েছে
            }
        }
        return true;
    }
}
