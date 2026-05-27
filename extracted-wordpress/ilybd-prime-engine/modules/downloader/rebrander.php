<?php
/**
 * Module: Meta Rebrander Engine
 * Description: Cleans original file metadata and injects iloveyoubd.com branding signature.
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_Rebrander_Engine {

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // এই ইঞ্জিনটি ডাউনলোডার মডিউল থেকে কল করা হবে
    }

    /**
     * মূল রিব্র্যান্ডিং ফাংশন
     * $file_path: সার্ভারে থাকা ভিডিও ফাইলের লোকাল পাথ
     */
    public function apply_branding( $file_path ) {
        if ( ! file_exists( $file_path ) ) return false;

        // ১. ফাইলের নাম পরিবর্তন করে ব্র্যান্ডিং যোগ করা
        $file_info = pathinfo( $file_path );
        $new_name = "ILOVEYOUBD_COM_" . time() . "." . $file_info['extension'];
        $new_path = $file_info['dirname'] . '/' . $new_name;

        // ২. ডিজিটাল সিগনেচার মেটাডাটা
        $brand_signature = array(
            'title'     => 'Downloaded from iloveyoubd.com',
            'artist'    => 'ILOVEYOUBD AI Engine',
            'comment'   => 'Visit iloveyoubd.com for more 4K tools',
            'copyright' => 'iloveyoubd.com 2024',
            'encoded_by'=> 'ILYBD Meta Cleaner'
        );

        /**
         * এখানে আমরা সার্ভারের FFmpeg কমান্ড ব্যবহার করবো মেটাডাটা ক্লিন করার জন্য।
         * এটি ভিডিওর ভেতর থেকে আগের সব ট্যাগ মুছে আপনার দেওয়া ট্যাগ বসিয়ে দেবে।
         */
        if ( $this->is_ffmpeg_installed() ) {
            $this->process_with_ffmpeg( $file_path, $new_path, $brand_signature );
            return $new_path;
        }

        // যদি FFmpeg না থাকে, তবে শুধু রিনেম করে রিটার্ন করবে
        rename( $file_path, $new_path );
        return $new_path;
    }

    /**
     * FFmpeg লজিক: মেটাডাটা রাইটিং
     */
    private function process_with_ffmpeg( $input, $output, $meta ) {
        $cmd = "ffmpeg -i " . escapeshellarg($input) . " ";
        $cmd .= "-metadata title=" . escapeshellarg($meta['title']) . " ";
        $cmd .= "-metadata artist=" . escapeshellarg($meta['artist']) . " ";
        $cmd .= "-metadata comment=" . escapeshellarg($meta['comment']) . " ";
        $cmd .= "-codec copy " . escapeshellarg($output) . " 2>&1";

        exec($cmd);
    }

    /**
     * সার্ভারে FFmpeg আছে কিনা চেক করা
     */
    private function is_ffmpeg_installed() {
        $output = shell_exec('which ffmpeg');
        return !empty($output);
    }
}

// গ্লোবাল অ্যাক্সেস
function ILYBD_Rebrander() {
    return ILYBD_Rebrander_Engine::get_instance();
}
