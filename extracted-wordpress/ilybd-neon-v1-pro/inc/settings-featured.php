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
        'ilybd-settings',
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

    // Save Settings Handler
    if (isset($_POST['ilybd_featured_save_settings'])) {
        $featured_enabled = isset($_POST['ily_enable_featured_posts']) ? 1 : 0;
        update_option('ily_enable_featured_posts', $featured_enabled);
        update_option('featured_source', sanitize_text_field($_POST['featured_source']));
        update_option('featured_category', sanitize_text_field($_POST['featured_category']));
        update_option('ilybd_featured_count', (int)$_POST['ilybd_featured_count']);
        
        echo '<div class="notice notice-success is-dismissible" style="border-left-color:'.$neon_main.'; background:#161b22; color:#fff;"><p><b>Featured Engine settings updated!</b></p></div>';
    }

    $saved = get_option('ilybd_featured_ids', '');
    $saved_ids = !empty($saved) ? explode(',', $saved) : array();
    $f_enabled = get_option('ily_enable_featured_posts', 1);
    $f_source = get_option('featured_source', 'manual');
    $f_cat = get_option('featured_category', '');
    $f_count = get_option('ilybd_featured_count', 4);

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
        .form-table th { color: #f0f6fc; font-weight: 600; width: 220px; }
        
        .ilybd-input {
            background: #010409 !important; color: <?php echo $neon_main; ?> !important;
            border: 1px solid #30363d !important; border-radius: 6px !important;
            padding: 8px 12px !important; outline: none; transition: 0.3s;
        }
        .ilybd-input:focus { border-color: <?php echo $neon_main; ?> !important; box-shadow: 0 0 10px <?php echo $neon_main; ?>44; }
        .hint { color: #8b949e; font-size: 12px; display: block; margin-top: 5px; }
    </style>

    <div class="wrap">
        <!-- 🚀 Core Preferences Card -->
        <div class="ilybd-ranker-wrap" style="margin-bottom: 25px;">
            <h1 class="neon-text">⭐ Featured Showcase Configuration</h1>
            <p style="color:#8b949e;">এখানে আপনার ফিউচার্ড পোস্ট মডিউলের অন/অফ স্ট্যাটাস এবং ডাটা সোর্স কন্ট্রোল করুন।</p>
            
            <form method="post" style="margin-top: 20px;">
                <table class="form-table">
                    <tr>
                        <th>Enable Featured Section</th>
                        <td>
                            <input type="checkbox" name="ily_enable_featured_posts" value="1" <?php checked($f_enabled, 1); ?> style="accent-color:<?php echo $neon_main; ?>; transform: scale(1.3);" />
                            <b style="color: #fff; margin-left: 10px;">হোমপেজে ফিউচার্ড পোস্ট মডিউল চালু রাখুন (Enable Featured Section)</b>
                        </td>
                    </tr>
                    
                    <tr>
                        <th>Data Selection Source</th>
                        <td>
                            <select name="featured_source" id="featured_source" class="ilybd-input" style="width: 250px;">
                                <option value="manual" <?php selected($f_source, 'manual'); ?>>⭐ Manual Selected & Custom Ranked</option>
                                <option value="views" <?php selected($f_source, 'views'); ?>>🔥 Most Popular (Most Viewed Cumulative)</option>
                                <option value="likes" <?php selected($f_source, 'likes'); ?>>❤️ Most Liked (High Rating Trend)</option>
                                <option value="category" <?php selected($f_source, 'category'); ?>>📂 Specific Category Showcase</option>
                            </select>
                            <span class="hint">কোন অ্যালগরিদম ব্যবহার করে ফিউচার্ড সেকশনটির কন্টেন্ট সিলেক্ট করা হবে তা নির্বাচন করুন।</span>
                        </td>
                    </tr>

                    <tr id="featured_category_row" style="<?php echo ($f_source === 'category') ? '' : 'display:none;'; ?>">
                        <th>Target Category</th>
                        <td>
                            <select name="featured_category" class="ilybd-input" style="width: 250px;">
                                <option value="">Select Category...</option>
                                <?php
                                $categories = get_categories();
                                foreach ($categories as $category) {
                                    echo '<option value="' . esc_attr($category->term_id) . '" ' . selected($f_cat, $category->term_id, false) . '>' . esc_html($category->name) . ' (' . $category->count . ')</option>';
                                }
                                ?>
                            </select>
                            <span class="hint">নির্ধারিত ক্যাটাগরির লেটেস্ট পোস্টগুলো ফিউচার্ড লিস্টে শো করবে।</span>
                        </td>
                    </tr>

                    <tr>
                        <th>Total Posts limits</th>
                        <td>
                            <input type="number" name="ilybd_featured_count" value="<?php echo esc_attr($f_count); ?>" min="1" max="25" class="ilybd-input" style="width:100px;" />
                            <span class="hint">হোমপেজের ফিউচার্ড সেকশনে কয়টি কার্ড শো করবে (১-২৫)।</span>
                        </td>
                    </tr>
                </table>
                
                <div style="margin-top: 20px;">
                    <button type="submit" name="ilybd_featured_save_settings" class="ilybd-btn-save">Save Core Settings</button>
                </div>
            </form>
        </div>

        <!-- 🤝 Manual Ranking Card (Visible if source is set to Manual) -->
        <div class="ilybd-ranker-wrap" id="manual-ranking-panel" style="<?php echo ($f_source === 'manual') ? '' : 'display:none;'; ?>">
            <h2 class="neon-text">↕️ Featured Post Order Selection</h2>
            <p style="color:#8b949e;">ড্র্যাগ অ্যান্ড ড্রপ করে পজিশন পরিবর্তন করুন। প্রথম পোস্টটি ফ্রন্টপেজে সর্বপ্রথমে ভেসে উঠবে।</p>

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
                    <button type="button" id="saveRank" class="ilybd-btn-save">Save New Ranking Order</button>
                    <span id="rankMsg" style="color:<?php echo $neon_main; ?>; font-weight: bold;"></span>
                </div>
            <?php else : ?>
                <div class="empty-msg">
                    <p>কোনো ম্যানুয়াল ফিউচার্ড পোস্ট আপাতত লিস্টে এড করা নেই।</p>
                    <a href="admin.php?page=featured-control-panel" style="color:<?php echo $neon_main; ?>; text-decoration: none; font-weight:bold;">কন্ট্রোল সেন্টার থেকে পোস্ট সিলেক্ট বা কাস্টমাইজ করুন →</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle options visibility based on source select
        const sourceSelect = document.getElementById('featured_source');
        if (sourceSelect) {
            sourceSelect.addEventListener('change', function() {
                const catRow = document.getElementById('featured_category_row');
                const rankPanel = document.getElementById('manual-ranking-panel');
                
                if (this.value === 'category') {
                    if (catRow) catRow.style.display = '';
                } else {
                    if (catRow) catRow.style.display = 'none';
                }
                
                if (this.value === 'manual') {
                    if (rankPanel) rankPanel.style.display = '';
                } else {
                    if (rankPanel) rankPanel.style.display = 'none';
                }
            });
        }

        const el = document.getElementById('sortable-featured');
        if(!el) return;

        // Initialize Sortable
        const sortable = new Sortable(el, {
            animation: 150,
            ghostClass: 'sortable-ghost'
        });

        // AJAX Save Rank
        const saveBtn = document.getElementById('saveRank');
        if (saveBtn) {
            saveBtn.addEventListener('click', function() {
                const btn = this;
                const ids = Array.from(el.querySelectorAll('.sortable-item')).map(item => item.dataset.id);
                const msg = document.getElementById('rankMsg');

                btn.innerText = 'Ranking...';
                btn.style.opacity = '0.5';

                const params = new URLSearchParams();
                params.append('action', 'ilybd_save_featured');
                ids.forEach(id => params.append('featured[]', id));

                fetch(ajaxurl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: params
                })
                .then(res => res.json())
                .then(res => {
                    msg.innerText = '✅ Ranking Saved Successfully!';
                    btn.innerText = 'Save New Ranking Order';
                    btn.style.opacity = '1';
                    setTimeout(() => msg.innerText = '', 3000);
                });
            });
        }
    });
    </script>
    <?php
}
