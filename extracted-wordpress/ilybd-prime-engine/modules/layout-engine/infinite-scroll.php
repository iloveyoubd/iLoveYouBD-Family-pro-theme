<?php
/**
 * ⚡ IBD NEXT-GEN INFINITE CONTENT MATRIX ⚡
 * Description: Infinite scroll for articles. Loads the next relevant post seamlessly 
 * when reaching the end of the current article, mimicking Bloomberg/Forbes.
 */
if (!defined('ABSPATH')) exit;

function ilybd_infinite_scroll_assets() {
    if (!is_single()) return;
    
    // We only enable this for standard posts for AdSense compliance
    if (get_post_type() !== 'post') return;

    $next_post = get_adjacent_post(false, '', true);
    if (!$next_post) return;
    
    $next_url = get_permalink($next_post->ID);
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        let isLoading = false;
        let nextUrl = "<?php echo esc_url($next_url); ?>";
        let mainContainer = document.querySelector('main') || document.querySelector('#primary') || document.querySelector('.post-content');
        if (!mainContainer) return;

        window.addEventListener('scroll', function() {
            if (isLoading || !nextUrl) return;

            let scrollHeight = document.documentElement.scrollHeight;
            let scrollTop = window.scrollY;
            let clientHeight = window.innerHeight;

            // Load when user is within 1000px of bottom
            if (scrollHeight - scrollTop - clientHeight < 1000) {
                isLoading = true;
                
                // Show loading indicator
                let loader = document.createElement('div');
                loader.innerHTML = '<div style="text-align:center; padding: 40px; color:#00f0ff; font-family:\'Space Grotesk\', sans-serif;"><i class="fa-solid fa-microchip fa-spin"></i> L O A D I N G   N E X T   M A T R I X...</div>';
                mainContainer.appendChild(loader);

                fetch(nextUrl)
                    .then(response => response.text())
                    .then(html => {
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, 'text/html');
                        
                        // Extract next article content
                        let nextContent = doc.querySelector('article') || doc.querySelector('.post-content');
                        let newTitle = doc.title;
                        
                        // Remove loader
                        loader.remove();

                        if (nextContent) {
                            // Add a visual separator
                            let separator = document.createElement('div');
                            separator.innerHTML = '<hr style="border: 0; border-top: 2px dashed #00f0ff; margin: 60px 0; opacity: 0.3;">';
                            mainContainer.appendChild(separator);
                            
                            // Append content
                            mainContainer.appendChild(nextContent);
                            
                            // Update URL without refreshing (triggers Analytics)
                            window.history.pushState({"html":html,"pageTitle":newTitle}, "", nextUrl);
                            document.title = newTitle;

                            // Google Analytics Virtual Pageview trigger (for AdSense impressions/SEO)
                            if (typeof gtag === 'function') {
                                gtag('config', 'GA_MEASUREMENT_ID', {
                                    'page_path': new URL(nextUrl).pathname,
                                    'page_title': newTitle
                                });
                            }
                            
                            // Reload Ads inside the new content
                            try {
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            } catch (e) {}

                            // Setup for the next post after this one
                            let metaNext = doc.querySelector('link[rel="next"]');
                            if (metaNext) {
                                nextUrl = metaNext.href;
                                isLoading = false;
                            } else {
                                nextUrl = null;
                            }
                        }
                    })
                    .catch(err => {
                        loader.remove();
                        isLoading = false;
                    });
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'ilybd_infinite_scroll_assets', 100);
