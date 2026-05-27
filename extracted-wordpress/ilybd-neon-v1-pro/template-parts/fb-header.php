<?php
/**
 * ILYBD Neon v1 Pro - FB Style Header Navigation (Clean Version)
 */

if (!defined('ABSPATH')) exit;

$current_url = home_url(add_query_arg([], $GLOBALS['wp']->request));
?>

<div class="fb-nav-container">

    <!-- HOME -->
    <a href="<?php echo home_url(); ?>"
       class="fb-icon-link <?php echo is_front_page() ? 'active' : ''; ?>"
       title="Home">
        <span class="dashicons dashicons-admin-home"></span>
    </a>

    <!-- VIDEO -->
    <a href="#"
       class="fb-icon-link"
       title="Video">
        <span class="dashicons dashicons-video-alt3"></span>
    </a>

    <!-- MARKETPLACE -->
    <a href="#"
       class="fb-icon-link"
       title="Marketplace">
        <span class="dashicons dashicons-cart"></span>
    </a>

    <!-- GROUPS -->
    <a href="#"
       class="fb-icon-link"
       title="Groups">
        <span class="dashicons dashicons-groups"></span>
    </a>

</div>