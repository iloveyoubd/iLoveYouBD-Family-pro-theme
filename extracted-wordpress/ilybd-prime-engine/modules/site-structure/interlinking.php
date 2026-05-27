<?php
/**
 * Module: Site Structure - Auto Interlinking
 * Path: modules/site-structure/interlinking.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class ILYBD_Interlinker {
    public function __construct() {
        add_filter('the_content', array($this, 'ilybd_auto_insert_links'));
    }

    public function ilybd_auto_insert_links($content) {
        if ( is_singular('ilybd_tools') ) {
            $related_tools = get_posts(array(
                'post_type' => 'ilybd_tools',
                'numberposts' => 3,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand'
            ));

            if ($related_tools) {
                $link_html = '<div class="ilybd-auto-links" style="margin-top:20px; border-top:1px solid #00f3ff; padding-top:10px;">';
                $link_html .= '<h4 class="neon-glow">You May Also Like:</h4><ul>';
                foreach ($related_tools as $tool) {
                    $link_html .= '<li><a href="' . get_permalink($tool->ID) . '" style="color:#fff;">' . get_the_title($tool->ID) . '</a></li>';
                }
                $link_html .= '</ul></div>';
                $content .= $link_html;
            }
        }
        return $content;
    }
}
new ILYBD_Interlinker();
