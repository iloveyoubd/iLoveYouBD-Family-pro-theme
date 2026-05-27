<?php
/**
 * Template Part: Dynamic Facebook-style Stories & Messenger active uplinks row.
 * Placed professionally above homepage search section.
 */

if (!is_user_logged_in()) {
    // Hidden as per user request to clean UI before login
    return;
}

$current_user_id = get_current_user_id();
$current_user = wp_get_current_user();
$neon_color = get_option('ilybd_main_color', '#00ff41');

// Fetch active stories
$all_active_stories = ilybd_get_active_stories();

// Group stories by user_id
$user_stories = [];
foreach ($all_active_stories as $story) {
    $uid = $story['user_id'];
    if (!isset($user_stories[$uid])) {
        $user_stories[$uid] = [];
    }
    $user_stories[$uid][] = $story;
}

// Fetch active/online uplinks to populate circles (recently active in last 12 hours)
$active_threshold = time() - 43200; // 12 hours
$active_users = get_users([
    'meta_query' => array(
        array(
            'key'     => 'ilybd_last_active',
            'value'   => $active_threshold,
            'compare' => '>=',
            'type'    => 'NUMERIC'
        )
    ),
    'number'   => 20,
    'exclude'  => [$current_user_id]
]);

// If we need more fallback users to fill up the messenger bar
if (count($active_users) < 8) {
    $extra_users = get_users([
        'number'  => 12,
        'exclude' => array_merge([$current_user_id], wp_list_pluck($active_users, 'ID'))
    ]);
    $active_users = array_merge($active_users, $extra_users);
}

// Setup self stories
$self_has_stories = isset($user_stories[$current_user_id]);
$self_stories_json = $self_has_stories ? json_encode($user_stories[$current_user_id]) : '[]';
?>

<div class="messenger-stories-container">
    <div class="stories-scroll-box" id="stories-scroll-box">
        
        <!-- SELF NODE: CREATE / VIEW SELF STORY -->
        <div class="story-circle-item self-node <?php echo $self_has_stories ? 'has-unviewed' : ''; ?>" id="self-story-node" onclick="handleSelfStoryClick(event)">
            <div class="avatar-ring-wrapper">
                <div class="story-avatar">
                    <?php echo get_avatar($current_user_id, 56); ?>
                </div>
                <!-- Mini Create plus badge -->
                <div class="create-story-plus" title="স্টোরি দিন">+</div>
            </div>
            <span class="story-username">আমার স্টোরি</span>
        </div>

        <!-- OTHER DYNAMIC USER STORIES & ACTIVE NODES -->
        <?php foreach ($active_users as $user): 
            $u_id = $user->ID;
            $has_stories = isset($user_stories[$u_id]);
            
            $status = ilybd_get_user_active_status($u_id);
            $is_online = $status['is_online'];
            
            // Unviewed check: Has user viewed all stories in this pack?
            $has_unviewed = false;
            if ($has_stories) {
                foreach ($user_stories[$u_id] as $st) {
                    if (!in_array($current_user_id, $st['views'])) {
                        $has_unviewed = true;
                        break;
                    }
                }
            }
            
            $stories_json = $has_stories ? json_encode($user_stories[$u_id]) : '[]';
            // Custom coloring structure depending on unviewed status and roles
            $ring_class = '';
            if ($has_stories) {
                $ring_class = $has_unviewed ? 'has-unviewed' : 'has-viewed';
            }
        ?>
            <div class="story-circle-item <?php echo $ring_class; ?>" 
                 data-user-id="<?php echo $u_id; ?>"
                 data-user-name="<?php echo esc_attr($user->display_name); ?>"
                 data-stories='<?php echo esc_attr($stories_json); ?>'
                 title="<?php echo esc_attr($status['text']); ?>"
                 onclick="handleUserCircleClick(this, event)">
                
                <div class="avatar-ring-wrapper" style="border: 2px solid <?php echo esc_attr($status['dot_color']); ?>;">
                    <div class="story-avatar">
                        <?php echo get_avatar($u_id, 56); ?>
                    </div>
                    <span class="active-pulse-dot" style="background: <?php echo esc_attr($status['dot_color']); ?>; box-shadow: 0 0 8px <?php echo esc_attr($status['dot_color']); ?>;" title="<?php echo esc_attr($status['text']); ?>"></span>
                </div>
                <span class="story-username"><?php echo esc_html(wp_trim_words($user->display_name, 2, '')); ?></span>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<!-- =====================================
     IMMERSIVE STORY VIEWER MODAL (POPUP)
     ===================================== -->
<div class="story-viewer-modal" id="story-viewer-modal" style="display: none;">
    <div class="viewer-overlay" onclick="closeStoryViewer()"></div>
    
    <div class="viewer-content">
        <!-- Close bar -->
        <button class="close-viewer-btn" onclick="closeStoryViewer()">&times;</button>
        
        <!-- Story Progress Lines -->
        <div class="viewer-progress-header" id="viewer-progress-bars">
            <!-- Dynamically generated progress tracks -->
        </div>

        <!-- Sender / Creator User details -->
        <div class="viewer-author-meta">
            <div class="author-avatar-img" id="viewer-author-avatar"></div>
            <div class="author-info">
                <h4 id="viewer-author-name"></h4>
                <span id="viewer-story-time" class="font-mono"></span>
            </div>
            <div class="viewer-count-tag font-mono">
                👁️ <span id="viewer-views-count">0</span> views
            </div>
        </div>

        <!-- Render Media body -->
        <div class="viewer-main-body" id="viewer-media-canvas" onclick="nextStorySegment()">
            <!-- Loaded dynamically (Image, Video player, GIF, or Custom styled text with gradient) -->
        </div>

        <!-- Caption layer if exists -->
        <div class="viewer-caption-box" id="viewer-caption-box"></div>

        <!-- Interactive Reacts panel & Instant Comm input -->
        <div class="viewer-interactions-dock">
            <div class="reactions-flyout-container">
                <button class="react-trigger-btn" onclick="toggleReactionsMenu()">❤️ রিঅ্যাক্ট</button>
                <div class="reactions-popover" id="reactions-popover">
                    <span class="react-em" data-type="like" onclick="submitStoryReaction('like')">👍</span>
                    <span class="react-em" data-type="heart" onclick="submitStoryReaction('heart')">❤️</span>
                    <span class="react-em" data-type="care" onclick="submitStoryReaction('care')">🥰</span>
                    <span class="react-em" data-type="haha" onclick="submitStoryReaction('haha')">😆</span>
                    <span class="react-em" data-type="wow" onclick="submitStoryReaction('wow')">😮</span>
                    <span class="react-em" data-type="sad" onclick="submitStoryReaction('sad')">😢</span>
                    <span class="react-em" data-type="angry" onclick="submitStoryReaction('angry')">😡</span>
                </div>
            </div>

            <!-- Comment Input -->
            <div class="comment-input-row">
                <input type="text" id="story-comment-field" placeholder="মন্তব্য লিখুন..." onkeypress="handleStoryCommentSubmit(event)">
                <button class="story-send-comment-btn" onclick="submitStoryComment()">পাঠান</button>
            </div>

            <button class="direct-chat-trigger-btn" onclick="triggerDirectChatFromStory()">💬 চ্যাট</button>
        </div>

        <!-- Live comments overlay panel -->
        <div class="viewer-comments-panel">
            <h5 class="comments-panel-title">মন্তব্যসমূহ (<span id="viewer-comments-count">0</span>)</h5>
            <div class="comments-scrollable-area" id="viewer-comments-list">
                <!-- Dynamically filled comment bubbles -->
            </div>
        </div>
    </div>
</div>

<!-- =====================================
     CREATE STORY DIALOG (UPLOADER MODAL)
     ===================================== -->
<div class="create-story-modal-overlay" id="create-story-modal" style="display: none;">
    <div class="create-story-box">
        <div class="create-story-header">
            <h3>📝 নতুন স্টোরি যোগ করুন</h3>
            <button class="close-create-btn" onclick="closeCreateStoryModal()">&times;</button>
        </div>

        <!-- Creation Tabs -->
        <div class="create-tabs">
            <button class="story-tab-btn active" onclick="switchStoryTab('text')">🎨 টেক্সট স্টোরি</button>
            <button class="story-tab-btn" onclick="switchStoryTab('media')">🖼️ ফাইল ও লিঙ্ক</button>
        </div>

        <form id="cyber-story-form" onsubmit="handleStoryUploadForm(event)">
            <!-- Tab 1 contents: Text story with neon backgrounds -->
            <div class="tab-pane active" id="tab-pane-text">
                <div class="story-form-group">
                    <textarea id="story-text-content" placeholder="আপনার স্টোরির বার্তা বা টেক্সট এখানে লিখুন..." style="background: #111a24; color: #fff; width:100%; min-height:100px; border: 1px solid rgba(255,255,255,0.08); border-radius:8px; padding:12px; font-size:14px; resize:none;"></textarea>
                </div>
                
                <div class="story-form-group">
                    <label style="display:block; font-size:12px; color:#a0aec0; margin-bottom:8px; font-weight:700;">ব্যাকগ্রাউন্ড কালার গ্রেডিয়েন্ট সিলেক্ট করুন:</label>
                    <div class="bg-grad-selector-grid">
                        <div class="grad-node grad-1 active" data-grad="linear-gradient(45deg, #ff0055, #000c24)" onclick="selectGradient(this)"></div>
                        <div class="grad-node grad-2" data-grad="linear-gradient(45deg, #02b3e4, #020024)" onclick="selectGradient(this)"></div>
                        <div class="grad-node grad-3" data-grad="linear-gradient(45deg, #11ffbd, #0a192f)" onclick="selectGradient(this)"></div>
                        <div class="grad-node grad-4" data-grad="linear-gradient(45deg, #f12711, #f5af19)" onclick="selectGradient(this)"></div>
                        <div class="grad-node grad-5" data-grad="linear-gradient(45deg, #8a2be2, #41006f)" onclick="selectGradient(this)"></div>
                    </div>
                </div>
            </div>

            <!-- Tab 2 contents: Upload file or URL -->
            <div class="tab-pane" id="tab-pane-media">
                <div class="story-form-group">
                    <label style="display:block; font-size:12.5px; color:#cbd5e0; margin-bottom:8px; font-weight:700;">১. সরাসরি ছবি বা ফাইল আপলোড করুন:</label>
                    <div class="story-file-uploader-zone" onclick="document.getElementById('story_file_input').click()">
                        <p id="upload-zone-text">📂 ফাইল নির্বাচন করতে এখানে ক্লিক করুন (ইমেজ, গিফ বা ভিডিও)</p>
                        <input type="file" id="story_file_input" name="story_file" style="display:none;" onchange="handleFileSelected(this)">
                    </div>
                </div>
                
                <div style="text-align:center; padding: 5px 0; color:#4a5568; font-weight:bold; font-size:11px;">অথবা</div>

                <div class="story-form-group">
                    <label style="display:block; font-size:12.5px; color:#cbd5e0; margin-bottom:6px; font-weight:700;">২. সরাসরি ইমেজ, GIF বা ভিডিও লিঙ্ক দিন:</label>
                    <input type="text" id="story-media-url-field" placeholder="https://example.com/image.jpg" style="background:#111a24; border:1.5px solid rgba(255,255,255,0.06); width:100%; border-radius:6px; padding:10px; font-size:13px; color:#fff;">
                </div>
            </div>

            <div class="story-form-group" style="margin-top:20px;">
                <label style="display:block; font-size:12.5px; color:#cbd5e0; margin-bottom:6px; font-weight:700;">ক্যাপশন লিখুন (সব ক্যাটাগরির জন্য প্রযোজ্য):</label>
                <input type="text" id="story-caption-field" placeholder="ক্যাপশন দিন..." style="background:#111a24; border:1.5px solid rgba(255,255,255,0.06); width:100%; border-radius:6px; padding:10px; font-size:13px; color:#fff;">
            </div>

            <div class="story-footer-actions">
                <button type="submit" id="submit-story-btn" class="submit-cyber-story-btn">🚀 পাবলিশ করুন (অর্জন করুন +৫ XP)</button>
            </div>
        </form>
    </div>
</div>

<style>
/* STYLINGS FOR MESSENGER STORIES COMPONENT */
.messenger-stories-container {
    background: #0d121b;
    border: 1.5px solid rgba(255, 255, 255, 0.04);
    box-shadow: 0 10px 40px rgba(0,0,0,0.85);
    border-radius: 16px;
    padding: 10px 12px;
    max-width: 650px;
    margin: 10px auto 5px auto;
    position: relative;
    overflow: hidden;
}

.stories-scroll-box {
    display: flex;
    overflow-x: auto;
    gap: 12px;
    padding-bottom: 5px;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.08) transparent;
}

.stories-scroll-box::-webkit-scrollbar {
    height: 3px;
}
.stories-scroll-box::-webkit-scrollbar-track {
    background: transparent;
}
.stories-scroll-box::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.12);
    border-radius: 10px;
}

/* INDIVIDUAL STORIES AVATAR ELEMENTS */
.story-circle-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    flex-shrink: 0;
    width: 52px;
    transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.story-circle-item:hover {
    transform: scale(1.05);
}

.avatar-ring-wrapper {
    position: relative;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
}

/* Glowing Border for Unvisited Stories (Exactly like Messenger) */
.story-circle-item.has-unviewed .avatar-ring-wrapper {
    background: linear-gradient(135deg, #00ff41 0%, #00e5ff 50%, #ff0055 100%);
    padding: 2.5px;
    box-shadow: 0 0 10px rgba(0, 255, 65, 0.25);
}

/* Viewed Stories Gray Border */
.story-circle-item.has-viewed .avatar-ring-wrapper {
    background: rgba(255, 255, 255, 0.12);
    padding: 2px;
}

.story-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    overflow: hidden;
    background: #000;
    border: 1.5px solid #0d121b;
}

.story-avatar img,
.story-avatar .avatar {
    width: 100% !important;
    height: 100% !important;
    border-radius: 50% !important;
    object-fit: cover !important;
    display: block !important;
}

/* Online status dot */
.active-pulse-dot {
    position: absolute;
    bottom: -1px;
    right: -1px;
    width: 11px;
    height: 11px;
    border-radius: 50%;
    background: #00ff41;
    border: 2px solid #0d121b;
}

/* Create story plus design */
.create-story-plus {
    position: absolute;
    bottom: -2px;
    right: -2px;
    background: #00ff41;
    color: #000;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 900;
    border: 1.5px solid #0d121b;
    box-shadow: 0 0 5px #00ff41;
}

.story-username {
    font-size: 9px;
    color: #cbd5e0;
    font-weight: 700;
    text-align: center;
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* =====================================
   IMMERSIVE STORY POPUP WINDOW (STORY VIEWPORT)
   ===================================== */
.story-viewer-modal {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    z-index: 1000000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.viewer-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.94);
    backdrop-filter: blur(8px);
}

.viewer-content {
    position: relative;
    width: 100%;
    max-width: 440px;
    height: 100%;
    max-height: 80vh;
    background: #000;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 15px 50px rgba(0,0,0,0.9);
    border: 1.5px solid rgba(255,255,255,0.04);
}

@media(max-width:480px) {
    .viewer-content {
        max-height: 100vh;
        border-radius: 0;
    }
}

.close-viewer-btn {
    position: absolute;
    top: 15px; right: 15px;
    background: rgba(0,0,0,0.5);
    border: none; color: #fff;
    width: 32px; height: 32px;
    border-radius: 50%; font-size: 20px;
    line-height:1; cursor: pointer; z-index: 10;
}

/* Progress trackers style at top of stories */
.viewer-progress-header {
    display: flex;
    gap: 4px;
    padding: 10px 15px;
    position: absolute;
    top: 0; left: 0; width: 100%;
    z-index: 9;
}

.prog-track {
    height: 3px;
    flex: 1;
    background: rgba(255,255,255,0.25);
    border-radius: 2px;
    overflow: hidden;
}

.prog-fill {
    height: 100%;
    width: 0%;
    background: #00ff41;
}

/* Author block */
.viewer-author-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    position: absolute;
    top: 18px; left: 15px;
    z-index: 8;
    background: linear-gradient(180deg, rgba(0,0,0,0.6) 0%, transparent 100%);
    width: calc(100% - 30px);
}

.author-avatar-img {
    width: 36px; height: 36px;
    border-radius: 50%; border: 1.5px solid #00ff41;
    overflow: hidden;
}

.author-avatar-img img {
    width: 100%; height: 100%; object-fit: cover;
}

.author-info h4 {
    margin: 0; font-size: 13.5px; font-weight: 800; color: #fff;
}

.author-info span {
    font-size: 9.5px; color: #a0aec0;
}

.viewer-count-tag {
    margin-left: auto;
    background: rgba(0,0,0,0.6);
    padding: 4px 10px; border-radius: 12px;
    font-size: 10px; color: #fff; border: 0.5px solid rgba(255,255,255,0.1);
}

/* Body canvas */
.viewer-main-body {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #05070a;
}

.viewer-main-body img,
.viewer-main-body video {
    max-width: 100%; max-height: 100%; object-fit: contain;
}

.text-story-canvas {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    padding: 30px; text-align: center;
    font-weight: 800; font-size: 20px; line-height: 1.6;
    color: #fff;
}

.viewer-caption-box {
    position: absolute;
    bottom: 120px; left: 15px; width: calc(100% - 30px);
    background: rgba(0,0,0,0.6);
    padding: 8px 12px; border-radius: 8px;
    font-size: 12.5px; color: #e2e8f0;
    border-left: 2px solid #00ff41;
    z-index: 8;
}

/* Comments overlay panel */
.viewer-comments-panel {
    background: #0a0e14;
    border-top: 1px solid rgba(255,255,255,0.06);
    padding: 12px;
    max-height: 150px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}

.comments-panel-title {
    font-size: 11px; margin: 0 0 8px 0; color: #a0aec0; text-transform: uppercase; font-weight: 800;
}

.comments-scrollable-area {
    display: flex; flex-direction: column; gap: 8px;
}

.story-comment-bubble {
    display: flex; gap: 8px; font-size: 12px;
}

.story-comment-bubble img {
    width: 24px; height: 24px; border-radius: 50%;
}

.comment-bubble-text {
    background: #1e293b; padding: 6px 10px; border-radius: 8px; color: #f1f5f9; flex: 1;
}

.comment-bubble-text b { color: #00ff41; font-weight: bold; margin-right: 4px; }

/* Interactive footer row */
.viewer-interactions-dock {
    display: flex; gap: 8px; align-items: center;
    padding: 12px 15px; background: #070a0e;
    border-top: 1.5px solid rgba(255,255,255,0.03);
}

.react-trigger-btn {
    background: rgba(255, 0, 85, 0.1); border: 1px solid rgba(255, 0, 85, 0.25);
    color: #ff3b79; padding: 10px 14px; border-radius: 8px; font-size: 12px; font-weight: 800; cursor: pointer;
}

.reactions-flyout-container {
    position: relative;
}

.reactions-popover {
    display: none; position: absolute; bottom: 100%; left: 0;
    background: #0f172a; border: 1.5px solid rgba(255,255,255,0.1);
    border-radius: 30px; padding: 6px 12px; gap: 10px; margin-bottom: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.8);
    z-index: 99;
}

.react-em {
    font-size: 20px; cursor: pointer; transition: transform 0.2s;
}
.react-em:hover {
    transform: scale(1.3);
}

.comment-input-row {
    flex: 1; display: flex; gap: 6px;
}

.comment-input-row input {
    flex: 1; background: #111a24; border: 1px solid rgba(255,255,255,0.08);
    border-radius: 6px; padding: 8px 10px; font-size: 12px; color: #fff;
}

.story-send-comment-btn {
    background: #00ff41; color: #000; border: none; font-weight: bold;
    font-size: 11px; padding: 0 12px; border-radius: 6px; cursor: pointer;
}

.direct-chat-trigger-btn {
    background: rgba(0, 240, 255, 0.15); border: 1px solid rgba(0, 240, 255, 0.3);
    color: #00f0ff; padding: 8px 12px; border-radius: 6px; font-size: 11px; font-weight: bold; cursor: pointer;
}

/* =====================================
   CREATE STORY MODALLY STYLINGS
   ===================================== */
.create-story-modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.8); backdrop-filter: blur(5px);
    z-index: 1000000; display: flex; align-items: center; justify-content: center;
}

.create-story-box {
    background: #090d16; border: 2px solid #00ff41;
    box-shadow: 0 15px 45px rgba(0, 255, 65, 0.15);
    border-radius: 16px; padding: 25px; width: 100%; max-width: 460px;
    font-family: 'Inter', system-ui, sans-serif;
}

.create-story-header {
    display: flex; justify-content: space-between; align-items: center;
    border-bottom: 1.5px solid rgba(255,255,255,0.05); padding-bottom: 10px; margin-bottom: 15px;
}

.create-story-header h3 {
    margin: 0; font-size: 16px; font-weight: 800; color: #fff;
}

.close-create-btn {
    background: none; border: none; color: #718096; font-size: 24px; cursor: pointer;
}
.close-create-btn:hover { color: #fff; }

.create-tabs {
    display: flex; gap: 8px; margin-bottom: 15px;
}

.story-tab-btn {
    flex: 1; padding: 10px; font-size: 12px; font-weight: bold;
    background: rgba(255,255,255,0.02); color: #a0aec0; border: 1px solid rgba(255,255,255,0.05);
    border-radius: 8px; cursor: pointer; transition: 0.2s;
}

.story-tab-btn.active {
    background: rgba(0, 255, 65, 0.08); color: #00ff41; border-color: #00ff41;
}

.tab-pane { display: none; }
.tab-pane.active { display: block; }

.story-form-group { margin-bottom: 15px; }

.story-file-uploader-zone {
    border: 2px dashed rgba(0, 255, 65, 0.3); background: rgba(0, 255, 65, 0.01);
    border-radius: 8px; padding: 25px; text-align: center; cursor: pointer;
    transition: 0.2s;
}
.story-file-uploader-zone:hover {
    border-color: #00ff41; background: rgba(0, 255, 65, 0.04);
}
.story-file-uploader-zone p {
    margin: 0; font-size: 13px; color: #cbd5e0;
}

/* Gradients nodes selector */
.bg-grad-selector-grid {
    display: flex; gap: 8px;
}

.grad-node {
    width: 32px; height: 32px; border-radius: 4px; cursor: pointer; border: 2.5px solid transparent;
}
.grad-node.active { border-color: #fff; box-shadow: 0 0 8px rgba(255,255,255,0.5); }

.grad-1 { background: linear-gradient(45deg, #ff0055, #000c24); }
.grad-2 { background: linear-gradient(45deg, #02b3e4, #020024); }
.grad-3 { background: linear-gradient(45deg, #11ffbd, #0a192f); }
.grad-4 { background: linear-gradient(45deg, #f12711, #f5af19); }
.grad-5 { background: linear-gradient(45deg, #8a2be2, #41006f); }

.submit-cyber-story-btn {
    width: 100%; background: linear-gradient(90deg, #00ff41 0%, #00e5ff 100%);
    color: #000; border: none; font-weight: 950; font-size: 14px; padding: 12px;
    border-radius: 8px; cursor: pointer; box-shadow: 0 4px 15px rgba(0,255,65,0.3);
}

.submit-cyber-story-btn:hover {
    transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,255,65,0.45);
}
</style>

<script>
// DYNAMIC STORY SEQUENCE PLAYBACK CORE
let currentActiveStoryPack = [];
let currentStoryIndex = 0;
let storyProgressTimer = null;
let currentGradBg = "linear-gradient(45deg, #ff0055, #000c24)";
let uploadStoryMediaType = 'text';

function selectGradient(el) {
    document.querySelectorAll('.grad-node').forEach(node => node.classList.remove('active'));
    el.classList.add('active');
    currentGradBg = el.getAttribute('data-grad');
}

function switchStoryTab(tab) {
    document.querySelectorAll('.story-tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    
    if (tab === 'text') {
        uploadStoryMediaType = 'text';
        document.querySelector('[onclick="switchStoryTab(\'text\')"]').classList.add('active');
        document.getElementById('tab-pane-text').classList.add('active');
    } else {
        uploadStoryMediaType = 'image'; // fallback starting media
        document.querySelector('[onclick="switchStoryTab(\'media\')"]').classList.add('active');
        document.getElementById('tab-pane-media').classList.add('active');
    }
}

function handleFileSelected(input) {
    const file = input.files[0];
    if (file) {
        // Detect media type
        if (file.type.match('video.*')) {
            uploadStoryMediaType = 'video';
        } else if (file.type.match('image/gif')) {
            uploadStoryMediaType = 'gif';
        } else {
            uploadStoryMediaType = 'image';
        }
        document.getElementById('upload-zone-text').innerHTML = '✅ ফাইল সিলেক্ট হয়েছে: <b>' + file.name + '</b>';
    }
}

function handleSelfStoryClick(e) {
    e.preventDefault();
    const selfStories = <?php echo $self_stories_json; ?>;
    
    if (selfStories && selfStories.length > 0) {
        // Play self story!
        openStoryViewerPack(selfStories, '<?php echo esc_js($current_user->display_name); ?>', '<?php echo get_avatar_url($current_user_id); ?>');
    } else {
        // Open create modal
        document.getElementById('create-story-modal').style.display = 'flex';
    }
}

function handleUserCircleClick(el, e) {
    e.preventDefault();
    const stories = JSON.parse(el.getAttribute('data-stories') || '[]');
    const name = el.getAttribute('data-user-name');
    const uId = el.getAttribute('data-user-id');
    const avatarImg = el.querySelector('.story-avatar img');
    const avatarUrl = avatarImg ? avatarImg.src : '';
    
    if (stories && stories.length > 0) {
        openStoryViewerPack(stories, name, avatarUrl);
    } else {
        // Directly trigger standard live Chat box with this user!
        if (typeof openChatBoxWithUser === 'function') {
            openChatBoxWithUser(uId, name, avatarUrl);
        } else {
            alert('চ্যাট সিস্টেম ইনস্টালাইজ হচ্ছে! দয়া করে ড্যাশবোর্ড থেকে চ্যাট করুন।');
        }
    }
}

function closeCreateStoryModal() {
    document.getElementById('create-story-modal').style.display = 'none';
}

function openStoryViewerPack(stories, userName, avatarUrl) {
    currentActiveStoryPack = stories;
    currentStoryIndex = 0;
    
    document.getElementById('viewer-author-name').innerText = userName;
    document.getElementById('viewer-author-avatar').innerHTML = '<img src="' + avatarUrl + '">';
    document.getElementById('story-viewer-modal').style.display = 'flex';
    
    playStorySegment();
}

function playStorySegment() {
    clearTimeout(storyProgressTimer);
    
    if (currentStoryIndex >= currentActiveStoryPack.length) {
        closeStoryViewer();
        return;
    }
    
    const story = currentActiveStoryPack[currentStoryIndex];
    
    // Track view in background via ajax
    jQuery.post('/wp-admin/admin-ajax.php', {
        action: 'ilybd_view_story',
        story_id: story.id
    });
    
    // Setup views count
    const viewsCount = story.views ? story.views.length : 0;
    document.getElementById('viewer-views-count').innerText = viewsCount;
    
    // Setup time
    const sDate = new Date(story.created_at * 1000);
    document.getElementById('viewer-story-time').innerText = sDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    // Build story aspect bar tracks
    const barWrap = document.getElementById('viewer-progress-bars');
    barWrap.innerHTML = '';
    currentActiveStoryPack.forEach((item, index) => {
        const track = document.createElement('div');
        track.className = 'prog-track';
        const fill = document.createElement('div');
        fill.className = 'prog-fill';
        if (index < currentStoryIndex) fill.style.width = '100%';
        track.appendChild(fill);
        barWrap.appendChild(track);
    });
    
    // Fill content canvas
    const canvas = document.getElementById('viewer-media-canvas');
    canvas.innerHTML = '';
    
    if (story.media_type === 'text') {
        const txt = document.createElement('div');
        txt.className = 'text-story-canvas';
        txt.style.background = story.bg_gradient || 'linear-gradient(45deg, #ff0055, #000c24)';
        txt.innerText = story.caption || story.content || '';
        canvas.appendChild(txt);
        document.getElementById('viewer-caption-box').style.display = 'none';
    } else if (story.media_type === 'video') {
        const video = document.createElement('video');
        video.src = story.media_url;
        video.autoplay = true;
        video.loop = false;
        video.controls = false;
        video.onended = nextStorySegment;
        canvas.appendChild(video);
        
        // Handle caption
        if (story.caption) {
            document.getElementById('viewer-caption-box').innerText = story.caption;
            document.getElementById('viewer-caption-box').style.display = 'block';
        } else {
            document.getElementById('viewer-caption-box').style.display = 'none';
        }
    } else {
        // Image or GIF
        const img = document.createElement('img');
        img.src = story.media_url;
        canvas.appendChild(img);
        
        // Handle caption
        if (story.caption) {
            document.getElementById('viewer-caption-box').innerText = story.caption;
            document.getElementById('viewer-caption-box').style.display = 'block';
        } else {
            document.getElementById('viewer-caption-box').style.display = 'none';
        }
    }
    
    // Setup Comments counts and items list
    document.getElementById('viewer-comments-count').innerText = story.comments ? story.comments.length : 0;
    renderCommentsPanel(story.comments || []);
    
    // Animate progress of active segment
    const activeFill = barWrap.children[currentStoryIndex].querySelector('.prog-fill');
    let start = null;
    const duration = story.media_type === 'text' ? 5000 : 7000; // 5 or 7 sec duration
    
    function step(timestamp) {
        if (!start) start = timestamp;
        const progress = timestamp - start;
        const pct = Math.min(100, (progress / duration) * 100);
        if (activeFill) activeFill.style.width = pct + '%';
        
        if (progress < duration) {
            storyProgressTimer = requestAnimationFrame(step);
        } else {
            nextStorySegment();
        }
    }
    
    storyProgressTimer = requestAnimationFrame(step);
}

function nextStorySegment() {
    cancelAnimationFrame(storyProgressTimer);
    currentStoryIndex++;
    playStorySegment();
}

function renderCommentsPanel(comments) {
    const list = document.getElementById('viewer-comments-list');
    list.innerHTML = '';
    if (comments.length === 0) {
        list.innerHTML = '<div style="font-size:11px; color:#4a5568; text-align:center; padding:10px;">কোন মন্তব্য নেই। প্রথম মন্তব্যটি করুন!</div>';
        return;
    }
    comments.forEach(c => {
        const html = `
            <div class="story-comment-bubble">
                <img src="${c.user_avatar}">
                <div class="comment-bubble-text">
                    <b>${c.user_name}</b> ${c.text}
                </div>
            </div>
        `;
        list.insertAdjacentHTML('beforeend', html);
    });
}

function closeStoryViewer() {
    cancelAnimationFrame(storyProgressTimer);
    document.getElementById('story-viewer-modal').style.display = 'none';
}

function toggleReactionsMenu() {
    const pop = document.getElementById('reactions-popover');
    pop.style.display = pop.style.display === 'flex' ? 'none' : 'flex';
}

function submitStoryReaction(type) {
    const story = currentActiveStoryPack[currentStoryIndex];
    document.getElementById('reactions-popover').style.display = 'none';
    
    jQuery.post('/wp-admin/admin-ajax.php', {
        action: 'ilybd_react_story',
        story_id: story.id,
        react_type: type
    }, function(res) {
        if (res.success) {
            alert('The reaction has been recorded successfully!');
        }
    });
}

function submitStoryComment() {
    const story = currentActiveStoryPack[currentStoryIndex];
    const field = document.getElementById('story-comment-field');
    const val = field.value.trim();
    if (!val) return;
    
    jQuery.post('/wp-admin/admin-ajax.php', {
        action: 'ilybd_comment_story',
        story_id: story.id,
        comment_text: val
    }, function(res) {
        if (res.success) {
            field.value = '';
            story.comments = res.data.comments;
            document.getElementById('viewer-comments-count').innerText = story.comments.length;
            renderCommentsPanel(story.comments);
        }
    });
}

function handleStoryCommentSubmit(e) {
    if (e.key === 'Enter') {
        submitStoryComment();
    }
}

function triggerDirectChatFromStory() {
    const story = currentActiveStoryPack[currentStoryIndex];
    const name = document.getElementById('viewer-author-name').innerText;
    const avatar = document.getElementById('viewer-author-avatar').querySelector('img').src;
    
    closeStoryViewer();
    if (typeof openChatBoxWithUser === 'function') {
        openChatBoxWithUser(story.user_id, name, avatar);
    }
}

// UPLOAD FORM FLOW
function handleStoryUploadForm(e) {
    e.preventDefault();
    const btn = document.getElementById('submit-story-btn');
    btn.disabled = true;
    btn.innerText = 'পাবলিশ হচ্ছে... দয়া করে অপেক্ষা করুন।';
    
    const formData = new FormData();
    formData.append('action', 'ilybd_upload_story');
    formData.append('media_type', uploadStoryMediaType);
    formData.append('caption', document.getElementById('story-caption-field').value);
    
    if (uploadStoryMediaType === 'text') {
        formData.append('caption', document.getElementById('story-text-content').value);
        formData.append('bg_gradient', currentGradBg);
    } else {
        const fileInput = document.getElementById('story_file_input');
        if (fileInput.files.length > 0) {
            formData.append('story_file', fileInput.files[0]);
        }
        formData.append('media_url', document.getElementById('story-media-url-field').value);
    }
    
    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if (res.success) {
                alert(res.data.message);
                location.reload();
            } else {
                alert(res.data.message);
                btn.disabled = false;
                btn.innerText = '🚀 পাবলিশ করুন (অর্জন করুন +৫ XP)';
            }
        },
        error: function() {
            alert('কোনো একটি ত্রুটি ঘটেছে! আবার চেষ্টা করুন।');
            btn.disabled = false;
            btn.innerText = '🚀 পাবলিশ করুন (অর্জন করুন +৫ XP)';
        }
    });
}
</script>
