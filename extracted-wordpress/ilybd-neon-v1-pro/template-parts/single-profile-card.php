<?php
/**
 * Premium Final Pixel Perfect - single-profile-card.php
 * Sequence: Thumbnail -> Category Pills -> Title -> Author -> Stats Row
 * Fixed: Anchor links added for View, Comment, and Like sections
 */
$auth_id = get_the_author_meta('ID');
$author_link = get_author_posts_url($auth_id);
$post_date = get_the_date('j F, Y');
$comment_count = get_comments_number();

// আপনার মূল মেটা কি এর সাথে মিলিয়ে আপডেট করা হয়েছে
$view_count = get_post_meta(get_the_ID(), 'ilybd_post_views_count', true) ?: '0';
$like_count = get_post_meta(get_the_ID(), '_likes', true) ?: '0';
?>

<div class="tbd-vibrant-card" style="background: linear-gradient(135deg, #6e00ff 0%, #ff4b2b 100%); border-radius: 12px; overflow: hidden; margin-bottom: 25px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">

    <?php if (has_post_thumbnail()) : ?>
        <div style="padding: 15px 15px 0 15px;">
            <div style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                <?php the_post_thumbnail('medium_large', [
                    'class' => 'tbd-header-thumb',
                    'style' => 'width:100%; object-fit:cover; display:block; border-radius:8px;'
                ]); ?>
            </div>
        </div>
        <style>
            .tbd-header-thumb {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 16/9 !important;
                max-height: 280px !important;
                object-fit: cover !important;
            }
            @media (max-width: 600px) {
                .tbd-header-thumb {
                    max-height: 180px !important;
                    aspect-ratio: 16/9 !important;
                }
            }
        </style>
    <?php endif; ?>

    <div style="padding: 20px;">
        
        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 15px;">
            <?php
            $categories = get_the_category();
            if (!empty($categories)) :
                foreach ($categories as $category) : ?>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 50px; text-decoration: none; text-transform: uppercase; border: 1px solid rgba(255, 255, 255, 0.2); display: flex; align-items: center; gap: 5px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach;
            endif; ?>
        </div>

        <h1 style="margin: 0 0 18px; font-size: 24px; color: #ffffff; line-height: 1.3; font-weight: 800; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            <?php the_title(); ?>
        </h1>

        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.4); overflow: hidden; background: #fff;">
                <?php echo get_avatar($auth_id, 45, '', '', array('style' => 'width:100%; height:100%; object-fit:cover; display:block;')); ?>
            </div>
            <a href="<?php echo esc_url($author_link); ?>" style="color: #ffffff; text-decoration: none; font-weight: 700; font-size: 16px;">
                <?php the_author(); ?>
            </a>
        </div>

        <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 12px;">
            
            <div style="background: rgba(255, 255, 255, 0.15); color: #fff; padding: 5px 10px; border-radius: 6px; font-size: 12px; display: flex; align-items: center; gap: 6px; border: 1px solid rgba(255,255,255,0.1);">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <?php echo $post_date; ?>
            </div>

            <a href="#comments" style="background: rgba(255, 255, 255, 0.15); color: #fff; padding: 5px 10px; border-radius: 6px; font-size: 12px; display: flex; align-items: center; gap: 6px; border: 1px solid rgba(255,255,255,0.1); text-decoration: none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <?php echo $comment_count; ?>
            </a>

            <a href="#" style="background: rgba(255, 255, 255, 0.15); color: #fff; padding: 5px 10px; border-radius: 6px; font-size: 12px; display: flex; align-items: center; gap: 6px; border: 1px solid rgba(255,255,255,0.1); text-decoration: none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <?php echo $view_count; ?>
            </a>

            <a href="#like-section" style="background: rgba(255, 255, 255, 0.15); color: #fff; padding: 5px 10px; border-radius: 6px; font-size: 12px; display: flex; align-items: center; gap: 6px; border: 1px solid rgba(255,255,255,0.1); text-decoration: none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                <?php echo $like_count; ?>
            </a>

        </div>
    </div>
</div>
