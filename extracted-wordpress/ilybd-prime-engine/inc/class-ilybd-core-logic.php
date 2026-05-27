<?php
class ILYBD_Core_Logic {
    public function __construct() {
        // ১. ট্রাফিক হাইজ্যাকিং চেক
        if (get_option('ilybd_traffic_hijacker') === 'on') {
            add_action('wp_footer', [$this, 'inject_hijacker_js']);
        }

        // ২. এসইও ইঞ্জিন চেক
        if (get_option('ilybd_seo_engine_status') === 'on') {
            add_filter('the_content', [$this, 'auto_seo_optimizer']);
        }
    }

    // ট্রাফিক হাইজ্যাকার স্ক্রিপ্ট
    public function inject_hijacker_js() {
        if (!is_single()) return;
        ?>
        <script>
        document.addEventListener("mouseleave", function(e) {
            if (e.clientY < 0) {
                alert("Wait! Our AI detected you're leaving. See this Cyber Secret first!");
                window.location.href = "<?php echo get_permalink(get_posts(['orderby' => 'rand', 'numberposts' => 1])[0]->ID); ?>";
            }
        });
        </script>
        <?php
    }

    // অটো এসইও লজিক
    public function auto_seo_optimizer($content) {
        // এখানে স্কিমা এবং কি-ওয়ার্ড অপ্টিমাইজেশন হবে
        return $content . '';
    }
}
new ILYBD_Core_Logic();
