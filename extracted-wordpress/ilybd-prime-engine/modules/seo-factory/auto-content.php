<?php
/**
 * Module: Ultra SEO Factory & AI Content Master
 * Path: modules/seo-factory/Auto-content.php
 * Description: Generates 2000+ words SEO articles with Gemini AI, High-CPC Keywords & Meta Optimization.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class ILYBD_SEO_Factory {

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // পোস্ট সেভ বা পাবলিশ করার সময় এআই কন্টেন্ট ট্রিগার করা
        add_action( 'save_post', array( $this, 'trigger_auto_content' ), 10, 3 );
    }

    /**
     * অটো কন্টেন্ট জেনারেশন ট্রিগার লজিক
     */
    public function trigger_auto_content( $post_id, $post, $update ) {
        // অটোসেভ বা রিভিশন হলে কাজ করবে না
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        
        // শুধু যখন নতুন পোস্ট পাবলিশ হবে তখনই কাজ করবে (যাতে বারবার এপিআই খরচ না হয়)
        if ( $post->post_status != 'publish' || $update ) return;
        
        // আপনার কাস্টম টুলস পোস্ট টাইপ বা সাধারণ পোস্ট চেক
        $allowed_types = array( 'post', 'ilybd_tools' ); 
        if ( ! in_array( $post->post_type, $allowed_types ) ) return;

        // যদি কন্টেন্ট অলরেডি থাকে তবে জেনারেট করবে না
        if ( ! empty( $post->post_content ) && strlen($post->post_content) > 100 ) return;

        $this->generate_massive_article( $post_id, $post->post_title );
    }

    /**
     * এআই ব্যবহার করে ২০০০ শব্দের হাই-সিপিসি আর্টিকেল তৈরি
     */
    private function generate_massive_article( $post_id, $title ) {
        // হাই-সিপিসি কি-ওয়ার্ড ট্র্যাপ (অ্যাডসেন্স রেভিনিউ বাড়ানোর জন্য)
        $high_cpc_keywords = "Insurance, Loans, Mortgage, Attorney, Credit, Lawyer, Donate, Hosting, Claim, 4K Video Downloader";

        $prompt = "Act as an Expert SEO Content Writer. Write a 2000-word comprehensive blog post about '{$title}'.
                  Structure: 
                  1. Catchy Introduction.
                  2. Detailed Features of this Tool.
                  3. Step-by-Step Guide to use on iloveyoubd.com.
                  4. Why iloveyoubd.com is the best for $title.
                  5. High-Value Benefits and Technical Specifications.
                  6. 10 Frequently Asked Questions (FAQs) with Schema.org style.
                  7. Professional Conclusion.
                  
                  Language: Bengali (Keep technical terms in English).
                  Keywords to target (High CPC): {$high_cpc_keywords}.
                  Website Focus: iloveyoubd.com.
                  Formatting: Use H2, H3 tags and Bullet points.";

        // মাস্টার এপিআই ব্যালেন্সার চেক করা
        if ( class_exists( 'ILYBD_API_Balancer' ) ) {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent";
            $post_data = array(
                'contents' => array(
                    array(
                        'parts' => array(
                            array( 'text' => $prompt )
                        )
                    )
                )
            );

            // এপিআই কল (আপনার মাস্টার ইঞ্জিনের ব্যালেন্সার হয়ে যাবে)
            $api_engine = new ILYBD_API_Balancer(); 
            $ai_response = $api_engine->call_api_rotation( $endpoint, $post_data );

            if ( isset( $ai_response['candidates'][0]['content']['parts'][0]['text'] ) ) {
                $content = $ai_response['candidates'][0]['content']['parts'][0]['text'];
                
                // ১. পোস্ট বডি আপডেট
                // ২. অটোমেটিক এসইও মেটা ডেসক্রিপশন জেনারেশন
                $meta_desc = wp_trim_words($content, 30, '...');

                $updated_post = array(
                    'ID'           => $post_id,
                    'post_content' => $content,
                    'post_excerpt' => $meta_desc, // মেটা ডেসক্রিপশনেও এআই ডাটা সেট হবে
                );
                
                // ইনফিনিট লুপ এড়াতে অ্যাকশন সাময়িকভাবে রিমুভ করা
                remove_action( 'save_post', array( $this, 'trigger_auto_content' ) );
                wp_update_post( $updated_post );
                update_post_meta( $post_id, '_ilybd_ai_generated', '1' ); // মার্ক করে রাখা
                add_action( 'save_post', array( $this, 'trigger_auto_content' ), 10, 3 );
            }
        }
    }
}

// গ্লোবাল অবজেক্ট হিসেবে রান করা
function ILYBD_SEO() {
    return ILYBD_SEO_Factory::get_instance();
}
ILYBD_SEO();
