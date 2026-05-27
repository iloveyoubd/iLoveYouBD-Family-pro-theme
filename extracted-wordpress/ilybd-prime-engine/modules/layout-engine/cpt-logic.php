<?php
/**
 * Module: Layout Engine & Custom Post Types
 * Description: Registers 'Tools' post type and handles custom templates for iloveyoubd.com
 * Project: ILOVEYOUBD.COM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ILYBD_Layout_Engine {

    private static $instance = null;

    public static function get_instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // ১. 'Tools' এবং 'Questions' নামে কাস্টম পোস্ট টাইপ রেজিস্টার করা
        add_action( 'init', array( $this, 'register_tools_post_type' ) );
        add_action( 'init', array( $this, 'register_questions_post_type' ) );
        
        // ২. টুলস এবং কোশ্চেন পেজের জন্য কাস্টম টেমপ্লেট ডিটেকশন
        add_filter( 'template_include', array( $this, 'load_tool_template' ) );
        
        // ৩. ড্যাশবোর্ড ও দরকারি পেজ অটো-ক্রিয়েশন (যদি না থাকে)
        add_action( 'admin_init', array( $this, 'create_essential_pages' ) );
        
        // ৪. Q&A শর্টকোড রেজিস্ট্রেশন
        add_shortcode( 'recent_questions', array( $this, 'recent_questions_shortcode' ) );
        add_shortcode( 'ilybd_ask_question_form', array( $this, 'ask_question_form_shortcode' ) );

        // ৫. ভোটিং AJAX অ্যাকশন রেজিস্ট্রেশন
        add_action( 'wp_ajax_ilybd_vote_question', array( $this, 'ajax_handle_voting' ) );
        add_action( 'wp_ajax_nopriv_ilybd_vote_question', array( $this, 'ajax_handle_voting' ) );
    }

    /**
     * ILYBD টুলস রেজিস্টার করা
     */
    public function register_tools_post_type() {
        $labels = array(
            'name'               => 'ILYBD Tools',
            'singular_name'      => 'Tool',
            'add_new'            => 'Add New Tool',
            'add_new_item'       => 'Add New AI Tool',
            'edit_item'          => 'Edit Tool',
            'all_items'          => 'All Tools',
            'search_items'       => 'Search Tools',
            'not_found'          => 'No tools found in iloveyoubd.com',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'menu_icon'          => 'dashicons-admin-tools',
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
            'rewrite'            => array( 'slug' => 'tool' ),
            'show_in_rest'       => true,
        );

        register_post_type( 'ilybd_tools', $args );

        // অটোমেটিক পার্মালিংক ফ্লাশ যাতে 'Post not found' বা 404 এরর চিরতরে দূর হয়
        if ( ! get_option( 'ilybd_re_flush_tools_v4' ) ) {
            flush_rewrite_rules( false );
            update_option( 'ilybd_re_flush_tools_v4', 1 );
        }
    }

    /**
     * Q&A ফোরামের জন্য 'ilybd_question' পোস্ট টাইপ রেজিস্টার করা
     */
    public function register_questions_post_type() {
        $labels = array(
            'name'               => 'ILYBD Questions',
            'singular_name'      => 'Question',
            'add_new'            => 'Add New Question',
            'add_new_item'       => 'Add New Question',
            'edit_item'          => 'Edit Question',
            'all_items'          => 'All Questions',
            'search_items'       => 'Search Questions',
            'not_found'          => 'No questions found in Q&A Hub',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'menu_icon'          => 'dashicons-editor-help',
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'rewrite'            => array( 'slug' => 'question' ),
            'show_in_rest'       => true,
        );

        register_post_type( 'ilybd_question', $args );

        // অটোমেটিক পার্মালিংক ফ্লাশ যাতে 'Post not found' বা 404 এরর চিরতরে দূর হয়
        if ( ! get_option( 'ilybd_re_flush_questions_v4' ) ) {
            flush_rewrite_rules( false );
            update_option( 'ilybd_re_flush_questions_v4', 1 );
        }
    }

    /**
     * টুলস পেজের জন্য থিমের ভেতর থেকে স্পেশাল ডিজাইন লোড করা
     */
    public function load_tool_template( $template ) {
        if ( is_singular( 'ilybd_tools' ) ) {
            $new_template = locate_template( array( 'single-tool.php' ) );
            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }
        if ( is_singular( 'ilybd_question' ) ) {
            $new_template = locate_template( array( 'single-ilybd_question.php' ) );
            if ( ! empty( $new_template ) ) {
                return $new_template;
            }
        }
        return $template;
    }

    /**
     * সাইট সেটআপের সময় অটোমেটিক ড্যাশবোর্ড পেজ তৈরি
     */
    public function create_essential_pages() {
        if ( get_option( 'ilybd_pages_created_v2' ) ) return;

        $pages = array(
            'Dashboard'     => '[ilybd_user_dashboard]',
            'Wallet'        => '[ilybd_wallet_ui]',
            'AI Chat'       => '[ilybd_ai_chat_full]',
            'Ask Question'  => '[ilybd_ask_question_form]'
        );

        foreach ( $pages as $title => $content ) {
            if ( ! get_page_by_title( $title ) ) {
                wp_insert_post( array(
                    'post_title'   => $title,
                    'post_content' => $content,
                    'post_status'  => 'publish',
                    'post_type'    => 'page',
                ));
            }
        }
        update_option( 'ilybd_pages_created_v2', true );
    }

    /**
     * AJAX দিয়ে প্রশ্ন ভোট হ্যান্ডেল করার লজিক
     */
    public function ajax_handle_voting() {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $type = isset($_POST['vote_type']) ? sanitize_text_field($_POST['vote_type']) : 'up';

        if ( $post_id && get_post_type($post_id) === 'ilybd_question' ) {
            $current_votes = intval( get_post_meta( $post_id, 'qa_votes', true ) ?: 0 );
            if ( $type === 'up' || $type === 'upvote' ) {
                $new_votes = $current_votes + 1;
            } else {
                $new_votes = $current_votes - 1;
            }
            update_post_meta( $post_id, 'qa_votes', $new_votes );
            wp_send_json_success( $new_votes );
        } else {
            wp_send_json_error( 'Invalid Question ID' );
        }
    }

    /**
     * [recent_questions] শর্টকোড হ্যান্ডলার
     */
    public function recent_questions_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'count' => 5,
        ), $atts, 'recent_questions' );

        $args = array(
            'post_type'      => 'ilybd_question',
            'posts_per_page' => intval( $atts['count'] ),
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC'
        );

        $q_query = new WP_Query( $args );
        $output = '';

        if ( $q_query->have_posts() ) {
            $output .= '<div class="qna-list-container" style="display:flex; flex-direction:column; gap:12px;">';
            while ( $q_query->have_posts() ) {
                $q_query->the_post();
                $q_id = get_the_ID();
                $votes = get_post_meta( $q_id, 'qa_votes', true ) ?: 0;
                $views = get_post_meta( $q_id, 'qa_views_count', true ) ?: 0;
                $answers_count = get_comments_number( $q_id );
                $author_name = get_the_author();
                $author_url = get_author_posts_url( get_the_author_meta('ID') );
                $time_diff = human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' আগে';
                $neon = get_option('ilybd_main_color', '#00ff41');

                $output .= '<div class="qna-item-box">';
                
                // বাম দিক: ভোট এবং সংখ্যা
                $output .= '  <div class="qna-stats-left">';
                $output .= '    <div class="qna-stat-item votes-item"><b>' . esc_html($votes) . '</b>ভোট</div>';
                $output .= '    <div class="qna-stat-item answers-item"><b>' . esc_html($answers_count) . '</b>উত্তর</div>';
                $output .= '    <div class="qna-stat-item views-item"><b>' . esc_html($views) . '</b>ভিউস</div>';
                $output .= '  </div>';

                // মাঝের কন্টেন্ট
                $output .= '  <div class="qna-details-mid">';
                $output .= '    <h4 class="qna-q-title"><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h4>';
                $output .= '    <div class="qna-q-meta">Asked by <a href="' . esc_url($author_url) . '"><b>' . esc_html($author_name) . '</b></a> - ' . esc_html($time_diff) . '</div>';
                $output .= '  </div>';

                // ডান দিকের বাটন
                $output .= '  <div class="qna-action-right">';
                $output .= '    <a href="' . esc_url(get_permalink()) . '">সমাধান দেখুন</a>';
                $output .= '  </div>';

                $output .= '</div>';
            }
            $output .= '</div>';
            wp_reset_postdata();
        } else {
            $output .= '<div class="no-qa-found" style="color:#555; text-align:center; padding:20px;">নতুন কোনো প্রশ্ন পাওয়া যায়নি। প্রথম প্রশ্নটি আপনি করুন!</div>';
        }

        return $output;
    }

    /**
     * [ilybd_ask_question_form] শর্টকোড হ্যান্ডলার
     */
    public function ask_question_form_shortcode() {
        if ( ! is_user_logged_in() ) {
            return '<div class="qa-login-alert" style="background:#0d1117; border:1px dashed #30363d; padding:30px; border-radius:12px; text-align:center;">
                <h4 style="color:#ff003c; margin-bottom:15px;">প্রশ্ন করার জন্য অবশ্যই লগইন থাকতে হবে</h4>
                <a href="' . esc_url(wp_login_url(get_permalink())) . '" class="login-to-comment-btn" style="background:linear-gradient(45deg, #00ff41, #008000); color:#000; padding:10px 20px; font-weight:bold; border-radius:6px; text-decoration:none; display:inline-block;">লগইন করুন</a>
            </div>';
        }

        $success_msg = '';

        // ফর্ম সাবমিশন লজিক
        if ( isset($_POST['ilybd_submit_qna']) && wp_verify_nonce($_POST['ilybd_qna_nonce'], 'ilybd_submit_qna_action') ) {
            $q_title = sanitize_text_field($_POST['question_title']);
            $q_content = wp_kses_post($_POST['question_content']);

            if ( !empty($q_title) && !empty($q_content) ) {
                $new_post = array(
                    'post_title'   => $q_title,
                    'post_content' => $q_content,
                    'post_status'  => 'publish',
                    'post_type'    => 'ilybd_question',
                    'post_author'  => get_current_user_id()
                );

                $post_id = wp_insert_post( $new_post );

                if ( $post_id ) {
                    update_post_meta( $post_id, 'qa_votes', 0 );
                    update_post_meta( $post_id, 'qa_views_count', 0 );
                    
                    // রিওয়ার্ড পয়েন্ট অ্যাড করা (প্রশ্ন করার জন্য বোনাস ২০ পয়েন্ট!)
                    if ( function_exists('ilybd_add_user_balance_or_points') ) {
                        ilybd_add_user_balance_or_points(get_current_user_id(), 0, 20, "Community Q&A Question bonus");
                    }

                    $success_msg = '<div class="qa-success" style="background:#0d1117; border:1px solid #00ff41; color:#00ff41; padding:20px; border-radius:10px; text-align:center; margin-bottom:20px;">
                        🎯 অভিনন্দন! আপনার প্রশ্নটি সফলভাবে প্রকাশ করা হয়েছে এবং ২০ পয়েন্ট যুক্ত হয়েছে। <br><br>
                        <a href="' . esc_url(get_permalink($post_id)) . '" style="color:#fff; font-weight:bold; text-decoration:underline;">আপনার প্রশ্নটি এখানে দেখুন</a>
                    </div>';
                }
            } else {
                $success_msg = '<p style="color:#ff003c; text-align:center; font-weight:bold; background:#0d1117; padding:12px; border-radius:8px;">দয়া করে শিরোনাম এবং বিবরণ পূরণ করুন!</p>';
            }
        }

        $neon = get_option('ilybd_main_color', '#00ff41');

        ob_start();
        echo $success_msg;
        ?>
        <form action="" method="POST" style="background:#0d1117; border:1px solid rgba(255,255,255,0.08); padding:30px; border-radius:15px; max-width:800px; margin:20px auto;">
            <?php wp_nonce_field('ilybd_submit_qna_action', 'ilybd_qna_nonce'); ?>
            
            <h3 style="color:#fff; border-bottom:1px solid <?php echo esc_attr($neon); ?>33; padding-bottom:12px; margin-top:0; margin-bottom:25px; font-weight:700; letter-spacing:1px; color:<?php echo esc_attr($neon); ?>;"><i class="fa-solid fa-circle-question"></i> নতুন প্রশ্ন জিজ্ঞাসা করুন</h3>
            
            <div style="margin-bottom:20px; text-align:left;">
                <label style="color:#fff; display:block; margin-bottom:8px; font-weight:600;">আপনার প্রশ্নের সংক্ষিপ্ত শিরোনাম (Title)</label>
                <input type="text" name="question_title" required placeholder="যেমন: উবুন্টু ওএস-এ Swiper.js কীভাবে সচল করব?" style="width:100%; padding:12px; background:#070a0f; border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; font-family:\'Rajdhani\', sans-serif; outline:none; transition:0.3s;" onfocus="this.style.borderColor='<?php echo esc_attr($neon); ?>'">
            </div>

            <div style="margin-bottom:25px; text-align:left;">
                <label style="color:#fff; display:block; margin-bottom:8px; font-weight:600;">detailed বিবরণ (Details)</label>
                <textarea name="question_content" required rows="6" placeholder="আপনার সমস্যাটি বিস্তারিত বুঝিয়ে বলুন। প্রয়োজনে কোড স্নিপেট বা ইনফরমেশন যুক্ত করতে পারেন..." style="width:100%; padding:15px; background:#070a0f; border:1px solid rgba(255,255,255,0.1); border-radius:8px; color:#fff; font-family:\'Rajdhani\', sans-serif; outline:none; transition:0.3s; line-height:1.6;" onfocus="this.style.borderColor='<?php echo esc_attr($neon); ?>'"></textarea>
            </div>

            <input type="submit" name="ilybd_submit_qna" value="🚀 প্রশ্ন প্রকাশ করুন" style="background:<?php echo esc_attr($neon); ?>; color:#000; font-family:\'Rajdhani\', sans-serif; border:none; padding:12px 30px; border-radius:6px; font-weight:bold; font-size:15px; cursor:pointer; width:100%; transition:0.3s; text-shadow:none; letter-spacing:1px;" onmouseover="this.style.background=\'#fff\'" onmouseout="this.style.background=\'<?php echo esc_attr($neon); ?>\'">
        </form>
        <?php
        return ob_get_clean();
    }
}

// ইঞ্জিন স্টার্ট
ILYBD_Layout_Engine::get_instance();
