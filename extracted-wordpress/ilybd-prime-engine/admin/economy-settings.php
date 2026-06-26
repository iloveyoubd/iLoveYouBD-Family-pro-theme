<?php
/**
 * Admin subpage: Ecosystem & User Rewards settings
 * Path: admin/economy-settings.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Native Settings Form Saving Handler
$saved = false;
if (isset($_POST['ilybd_save_economy_submit'])) {
    check_admin_referer('ilybd_economy_nonce_action', 'ilybd_economy_nonce_action');
    
    $fields = array(
        'ilybd_eco_post_points' => 'intval',
        'ilybd_eco_post_cash' => 'floatval',
        'ilybd_eco_view_points' => 'intval',
        'ilybd_eco_view_cash' => 'floatval',
        'ilybd_eco_comment_points' => 'intval',
        'ilybd_eco_comment_cash' => 'floatval',
        'ilybd_eco_reply_points' => 'intval',
        'ilybd_eco_reply_cash' => 'floatval',
        'ilybd_eco_question_points' => 'intval',
        'ilybd_eco_question_cash' => 'floatval',
        'ilybd_eco_answer_points' => 'intval',
        'ilybd_eco_answer_cash' => 'floatval',
        'ilybd_ref_points_referrer' => 'intval',
        'ilybd_ref_cash_referrer' => 'floatval',
        'ilybd_ref_points_referee' => 'intval',
        'ilybd_ref_cash_referee' => 'floatval'
    );
    
    foreach ($fields as $field => $cast) {
        if (isset($_POST[$field])) {
            $val = sanitize_text_field($_POST[$field]);
            if ($cast === 'intval') {
                update_option($field, intval($val));
            } else {
                update_option($field, floatval($val));
            }
        }
    }
    $saved = true;
}

// Retrieve general values
$post_pt = get_option('ilybd_eco_post_points', '25');
$post_ch = get_option('ilybd_eco_post_cash', '5.50');
$view_pt = get_option('ilybd_eco_view_points', '1');
$view_ch = get_option('ilybd_eco_view_cash', '0.050');
$comm_pt = get_option('ilybd_eco_comment_points', '5');
$comm_ch = get_option('ilybd_eco_comment_cash', '0.50');
$repl_pt = get_option('ilybd_eco_reply_points', '5');
$repl_ch = get_option('ilybd_eco_reply_cash', '0.50');
$ques_pt = get_option('ilybd_eco_question_points', '20');
$ques_ch = get_option('ilybd_eco_question_cash', '0.00');
$answ_pt = get_option('ilybd_eco_answer_points', '15');
$answ_ch = get_option('ilybd_eco_answer_cash', '1.50');

$ref_pt_r = get_option('ilybd_ref_points_referrer', '50');
$ref_ch_r = get_option('ilybd_ref_cash_referrer', '0.50');
$ref_pt_e = get_option('ilybd_ref_points_referee', '100');
$ref_ch_e = get_option('ilybd_ref_cash_referee', '1.00');
?>

<div class="ilybd-cyber-wrapper">
    <h1 class="ilybd-cyber-h1">
        <span class="dashicons dashicons-money-alt" style="font-size:32px; width:32px; height:32px; color:#00f0ff;"></span>
        Ecosystem & User Rewards Panel
    </h1>
    <p class="ilybd-cyber-subtitle">গ্লোবাল ওয়ালেট ডিস্ট্রিবিউশন, এক্সপি বোনাস এবং ইউজার ইন্টারেকশন রেট সেটিংস সেন্টার।</p>

    <?php $this->ilybd_render_tabs('economy'); ?>

    <?php if ($saved): ?>
        <div class="notice notice-success is-dismissible" style="background:#13231c; color:#39ff14; border:1px solid #33a152; padding:15px; margin-bottom:25px; border-radius:6px; font-weight:bold; box-shadow:0 0 10px rgba(57, 255, 20, 0.15);">
            ⚡ ইকোসিস্টেম রিওয়ার্ড সেটিংস সফলভাবে সেভ হয়েছে!
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <?php wp_nonce_field('ilybd_economy_nonce_action', 'ilybd_economy_nonce_action'); ?>
        
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px;">
            
            <!-- Forms section -->
            <div style="display:flex; flex-direction:column; gap:20px;">
                
                <!-- Section: Publication Reward -->
                <div class="ilybd-cyber-panel" style="margin-bottom:0;">
                    <div class="ilybd-panel-title"><span class="dashicons dashicons-welcome-write-blog"></span> পোস্ট পাবলিশ রিওয়ার্ডস (Content Publish Rewards)</div>
                    <table class="ilybd-cyber-form-table">
                        <tr>
                            <th>📝 Post Publish Reward</th>
                            <td>
                                <div style="display:flex; gap:15px; align-items:center;">
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">XP Points</span>
                                        <input type="number" name="ilybd_eco_post_points" value="<?php echo esc_attr($post_pt); ?>" class="ilybd-cyber-input" style="width:90px;" />
                                    </div>
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">Cash (৳ BDT)</span>
                                        <input type="number" step="0.01" name="ilybd_eco_post_cash" value="<?php echo esc_attr($post_ch); ?>" class="ilybd-cyber-input" style="width:120px;" />
                                    </div>
                                </div>
                                <p class="ilybd-desc-text">প্রতিটি পোস্ট প্রকাশ করার জন্য পোস্টের লেখক তাৎক্ষণিক এই বোনাসটি তার ওয়ালেটে পাবেন।</p>
                            </td>
                        </tr>
                        <tr>
                            <th>👀 View / Visit Reward</th>
                            <td>
                                <div style="display:flex; gap:15px; align-items:center;">
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">XP Points</span>
                                        <input type="number" name="ilybd_eco_view_points" value="<?php echo esc_attr($view_pt); ?>" class="ilybd-cyber-input" style="width:90px;" />
                                    </div>
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">Cash (৳ BDT)</span>
                                        <input type="number" step="0.001" name="ilybd_eco_view_cash" value="<?php echo esc_attr($view_ch); ?>" class="ilybd-cyber-input" style="width:120px;" />
                                    </div>
                                </div>
                                <p class="ilybd-desc-text">ভিজিটররা পোস্ট দেখে গেলে বা ইউনিক ভিউ হলে লেখকের প্রধান ব্যালেন্সে কত পয়েন্ট ও টাকা ক্রেডিট হবে।</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Section: Comment & Feedback Reward -->
                <div class="ilybd-cyber-panel" style="margin-bottom:0;">
                    <div class="ilybd-panel-title"><span class="dashicons dashicons-admin-comments"></span> মন্তব্য ফিডব্যাক রিওয়ার্ডস (Community Engagement)</div>
                    <table class="ilybd-cyber-form-table">
                        <tr>
                            <th>💬 Comment Reward</th>
                            <td>
                                <div style="display:flex; gap:15px; align-items:center;">
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">XP Points Modifier</span>
                                        <input type="number" name="ilybd_eco_comment_points" value="<?php echo esc_attr($comm_pt); ?>" class="ilybd-cyber-input" style="width:90px;" />
                                    </div>
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">Cash (৳ BDT) Option</span>
                                        <input type="number" step="0.01" name="ilybd_eco_comment_cash" value="<?php echo esc_attr($comm_ch); ?>" class="ilybd-cyber-input" style="width:120px;" />
                                    </div>
                                </div>
                                <p class="ilybd-desc-text">সাধারণ আর্টিকেলে যেকোনো গঠনমূলক মন্তব্য (Comment) করার জন্য মন্তব্যকারী এই রিওয়ার্ডটি পাবেন।</p>
                            </td>
                        </tr>
                        <tr>
                            <th>🗣️ Comment Reply Reward</th>
                            <td>
                                <div style="display:flex; gap:15px; align-items:center;">
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">XP Points</span>
                                        <input type="number" name="ilybd_eco_reply_points" value="<?php echo esc_attr($repl_pt); ?>" class="ilybd-cyber-input" style="width:90px;" />
                                    </div>
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">Cash (৳ BDT)</span>
                                        <input type="number" step="0.01" name="ilybd_eco_reply_cash" value="<?php echo esc_attr($repl_ch); ?>" class="ilybd-cyber-input" style="width:120px;" />
                                    </div>
                                </div>
                                <p class="ilybd-desc-text">অন্য ইউজারের করা মন্তব্যের রিপ্লাই দিয়ে আলোচনার পরিবেশ তৈরি করার জন্য রিপ্লাইকারীকে এই বোনাস দেয়া হবে।</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Section: Q&A Forums Reward -->
                <div class="ilybd-cyber-panel" style="margin-bottom:0;">
                    <div class="ilybd-panel-title"><span class="dashicons dashicons-editor-help"></span> প্রশ্ন-উত্তর ফোরাম রিওয়ার্ডস (Q&A Forum Rewards)</div>
                    <table class="ilybd-cyber-form-table">
                        <tr>
                            <th>❓ Ask Question Reward</th>
                            <td>
                                <div style="display:flex; gap:15px; align-items:center;">
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">XP Points</span>
                                        <input type="number" name="ilybd_eco_question_points" value="<?php echo esc_attr($ques_pt); ?>" class="ilybd-cyber-input" style="width:90px;" />
                                    </div>
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">Cash (৳ BDT)</span>
                                        <input type="number" step="0.01" name="ilybd_eco_question_cash" value="<?php echo esc_attr($ques_ch); ?>" class="ilybd-cyber-input" style="width:120px;" />
                                    </div>
                                </div>
                                <p class="ilybd-desc-text">ফোরামে তথ্যবহুল বা আইটি সমাধান বিষয়ক কোনো নতুন প্রশ্ন জিজ্ঞাসাকারী কত রিওয়ার্ড পাবেন।</p>
                            </td>
                        </tr>
                        <tr>
                            <th>💡 Answer Question Reward</th>
                            <td>
                                <div style="display:flex; gap:15px; align-items:center;">
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">XP Points</span>
                                        <input type="number" name="ilybd_eco_answer_points" value="<?php echo esc_attr($answ_pt); ?>" class="ilybd-cyber-input" style="width:90px;" />
                                    </div>
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">Cash (৳ BDT)</span>
                                        <input type="number" step="0.01" name="ilybd_eco_answer_cash" value="<?php echo esc_attr($answ_ch); ?>" class="ilybd-cyber-input" style="width:120px;" />
                                    </div>
                                </div>
                                <p class="ilybd-desc-text">ফোরামে অন্যের সমাধানহীন প্রশ্নের গাইডলাইন বা সঠিক দিকনির্দেশনা ও উত্তর প্রদানকারী মূলত কত বোনাস পাবেন।</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Section: Viral Invite Loop -->
                <div class="ilybd-cyber-panel" style="margin-bottom:0;">
                    <div class="ilybd-panel-title"><span class="dashicons dashicons-groups"></span> রেফারেল ও অরগানিক শেয়ার লুপ (Referral Viral Loop)</div>
                    <table class="ilybd-cyber-form-table">
                        <tr>
                            <th>🔗 Referrer Reward (লিংক দাতা)</th>
                            <td>
                                <div style="display:flex; gap:15px; align-items:center;">
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">XP Points</span>
                                        <input type="number" name="ilybd_ref_points_referrer" value="<?php echo esc_attr($ref_pt_r); ?>" class="ilybd-cyber-input" style="width:90px;" />
                                    </div>
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">Cash (৳ BDT)</span>
                                        <input type="number" step="0.01" name="ilybd_ref_cash_referrer" value="<?php echo esc_attr($ref_ch_r); ?>" class="ilybd-cyber-input" style="width:120px;" />
                                    </div>
                                </div>
                                <p class="ilybd-desc-text">ইউজারের ইউনিক লিঙ্কের মাধ্যমে কেউ রেজিস্ট্রেশন করলে মূল রেফারেল দাতা কত পাবেন।</p>
                            </td>
                        </tr>
                        <tr>
                            <th>🎓 Referee Reward (নতুন ইউজার)</th>
                            <td>
                                <div style="display:flex; gap:15px; align-items:center;">
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">XP Points</span>
                                        <input type="number" name="ilybd_ref_points_referee" value="<?php echo esc_attr($ref_pt_e); ?>" class="ilybd-cyber-input" style="width:90px;" />
                                    </div>
                                    <div>
                                        <span style="font-size:11px; color:#94a3b8; display:block;">Cash (৳ BDT)</span>
                                        <input type="number" step="0.01" name="ilybd_ref_cash_referee" value="<?php echo esc_attr($ref_ch_e); ?>" class="ilybd-cyber-input" style="width:120px;" />
                                    </div>
                                </div>
                                <p class="ilybd-desc-text">নতুন ইউজার রেফার লিঙ্কে জয়েন হওয়ার সাথে সাথে রেজিস্ট্রেশন গিফট হিসেবে কত পাবেন।</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="margin-top:10px;">
                    <button type="submit" name="ilybd_save_economy_submit" class="ilybd-cyber-btn">
                        <span class="dashicons dashicons-saved" style="font-size:16px; width:16px; height:16px; margin:0 5px 0 0; color:#070b13;"></span>
                        Save Rewards Configuration
                    </button>
                </div>
            </div>

            <!-- Simulation model side panel -->
            <div>
                <div class="ilybd-cyber-panel" style="border-color:#bd00ff; position:sticky; top:20px;">
                    <div class="ilybd-panel-title" style="color:#bd00ff; border-color:rgba(189, 0, 255, 0.25);"><span class="dashicons dashicons-calculator" style="color:#bd00ff;"></span> খরচ সিমুলেটর (Simulator)</div>
                    <p style="font-size:12.5px; color:#94a3b8; line-height:1.5; margin-bottom:15px;">আপনার নির্ধারিত রিওয়ার্ড রেট অনুযায়ী প্রতি মাসে নমুনা খরচের ধারণা নিচে দেখুন:</p>
                    
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <div>
                            <label style="font-size:11px; font-weight:bold; color:#fff;">অনুমিত মাসিক পোস্ট ভিউ:</label>
                            <input type="number" id="sim-views" value="10000" class="ilybd-cyber-input" style="width:100%; margin-top:4px;" />
                        </div>
                        <div>
                            <label style="font-size:11px; font-weight:bold; color:#fff;">অনুমিত মাসিক প্রকাশিত পোস্ট:</label>
                            <input type="number" id="sim-posts" value="100" class="ilybd-cyber-input" style="width:100%; margin-top:4px;" />
                        </div>
                        <div>
                            <label style="font-size:11px; font-weight:bold; color:#fff;">অনুমিত মাসিক মোট কমেন্ট:</label>
                            <input type="number" id="sim-comments" value="500" class="ilybd-cyber-input" style="width:100%; margin-top:4px;" />
                        </div>
                    </div>
                    
                    <div style="background:rgba(189,0,255,0.07); border:1px solid rgba(189,0,255,0.25); border-radius:6px; padding:15px; margin-top:20px; text-align:center;">
                        <span style="font-size:10px; color:#94a3b8; font-weight:bold; display:block; letter-spacing:1px; text-transform:uppercase;">TOTAL ESTIMATED PAYOUTS</span>
                        <span style="font-size:26px; font-weight:800; color:#00f0ff; font-family:'JetBrains Mono', monospace;" id="sim-total-cash">৳ 0.00</span>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    var viewRate = parseFloat("<?php echo $view_ch; ?>");
    var postRate = parseFloat("<?php echo $post_ch; ?>");
    var commentRate = parseFloat("<?php echo $comm_ch; ?>");

    function updateSimulation() {
        var views = parseInt($('#sim-views').val()) || 0;
        var posts = parseInt($('#sim-posts').val()) || 0;
        var comments = parseInt($('#sim-comments').val()) || 0;

        var total = (views * viewRate) + (posts * postRate) + (comments * commentRate);
        $('#sim-total-cash').text('৳ ' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }

    // Bind interaction inputs
    $('#sim-views, #sim-posts, #sim-comments').on('input change', function() {
        updateSimulation();
    });

    updateSimulation();
});
</script>
