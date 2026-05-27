<?php
/**
 * ILYBD Neon Pro - Featured Post Engine v2 (Advanced Ranker)
 * Features: Drag & Drop Sorting + Neon UI
 */

if (!defined('ABSPATH')) exit;

/* =========================
   ADMIN MENU
========================= */
add_action('admin_menu', function () {
    add_submenu_page(
        'ilybd-master-panel',
        'Featured Ranker',
        'Featured Ranking',
        'manage_options',
        'ilybd-featured-settings',
        'ilybd_featured_page'
    );
});

/* =========================
   FEATURED PAGE UI
========================= */
function ilybd_featured_page() {
    $neon_main = esc_attr(get_option('ilybd_main_color', '#00ff41'));
    $saved = get_option('ilybd_featured_ids', '');
    $saved_ids = !empty($saved) ? explode(',', $saved) : array();

    // Fetch only the posts that are currently selected as featured
    $args = array(
        'post__in' => !empty($saved_ids) ? $saved_ids : array(0),
        'posts_per_page' => -1,
        'orderby' => 'post__in',
        'post_status' => 'publish'
    );
    $featured_posts = get_posts($args);
    ?>

    <style>
        .ilybd-ranker-wrap {
            background: #0d1117; color: #c9d1d9; padding: 30px;
            border-radius: 14px; border: 1px solid #30363d;
            max-width: 800px; margin-top: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .neon-text { color: <?php echo $neon_main; ?>; text-transform: uppercase; font-weight: 800; }
        
        .sortable-list { list-style: none; padding: 0; margin: 20px 0; }
        .sortable-item {
            background: #161b22; padding: 15px; margin-bottom: 10px;
            border: 1px solid #30363d; border-radius: 8px;
            display: flex; align-items: center; gap: 15px;
            cursor: grab; transition: 0.2s;
        }
        .sortable-item:active { cursor: grabbing; }
        .sortable-item:hover { border-color: <?php echo $neon_main; ?>; background: #1c2128; }
        
        .rank-number {
            background: <?php echo $neon_main; ?>; color: #000;
            width: 24px; height: 24px; display: flex; align-items: center;
            justify-content: center; border-radius: 50%; font-weight: bold; font-size: 12px;
        }
        
        .post-title-rank { flex: 1; font-weight: 600; color: #f0f6fc; }
        .drag-icon { color: #484f58; font-size: 20px; }

        .ilybd-btn-save {
            background: <?php echo $neon_main; ?> !important; color: #000 !important;
            border: none; padding: 12px 30px; border-radius: 8px;
            font-weight: 800; cursor: pointer; text-transform: uppercase;
            box-shadow: 0 4px 14px <?php echo $neon_main; ?>44;
        }
        .empty-msg { padding: 40px; text-align: center; color: #8b949e; border: 2px dashed #30363d; border-radius: 10px; }
    </style>

    <div class="wrap">
        <div class="ilybd-ranker-wrap">
            <h1 class="neon-text">↕️ Featured Post Ranker</h1>
            <p style="color:#8b949e;">ড্র্যাগ অ্যান্ড ড্রপ করে পজিশন পরিবর্তন করুন। তালিকার প্রথম পোস্টটি স্লাইডার বা গ্রিডে সবার আগে দেখাবে।</p>

            <?php if (!empty($featured_posts)) : ?>
                <ul id="sortable-featured" class="sortable-list">
                    <?php $count = 1; foreach($featured_posts as $p): ?>
                        <li class="sortable-item" data-id="<?php echo $p->ID; ?>">
                            <div class="drag-icon">⋮⋮</div>
                            <div class="rank-number"><?php echo $count++; ?></div>
                            <div class="post-title-rank"><?php echo esc_html($p->post_title); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <div style="margin-top: 25px; display: flex; align-items: center; gap: 15px;">
                    <button type="button" id="saveRank" class="ilybd-btn-save">Save New Ranking</button>
                    <span id="rankMsg" style="color:<?php echo $neon_main; ?>; font-weight: bold;"></span>
                </div>
            <?php else : ?>
                <div class="empty-msg">
                    <p>কোনো ফিচার্ড পোস্ট সিলেক্ট করা নেই।</p>
                    <a href="admin.php?page=ilybd-featured-select" style="color:<?php echo $neon_main; ?>; text-decoration: none;">কন্ট্রোল সেন্টার থেকে পোস্ট সিলেক্ট করুন →</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('sortable-featured');
        if(!el) return;

        // Initialize Sortable
        const sortable = new Sortable(el, {
            animation: 150,
            ghostClass: 'sortable-ghost'
        });

        // AJAX Save
        document.getElementById('saveRank').addEventListener('click', function() {
            const btn = this;
            const ids = Array.from(el.querySelectorAll('.sortable-item')).map(item => item.dataset.id);
            const msg = document.getElementById('rankMsg');

            btn.innerText = 'Ranking...';
            btn.style.opacity = '0.5';

            const params = new URLSearchParams();
            params.append('action', 'ilybd_save_featured'); // Using the same action for consistency
            ids.forEach(id => params.append('featured[]', id));

            fetch(ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: params
            })
            .then(res => res.json())
            .then(res => {
                msg.innerText = '✅ Ranking Saved!';
                btn.innerText = 'Save New Ranking';
                btn.style.opacity = '1';
                setTimeout(() => msg.innerText = '', 3000);
            });
        });
    });
    </script>
    <?php
}
