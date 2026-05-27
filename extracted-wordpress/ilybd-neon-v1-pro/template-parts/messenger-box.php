<?php
/**
 * Template Part: Facebook Messenger-like floating dashboard and chat pop-up system.
 * Appears dynamically at the bottom-right segment of any page, providing a full communication channel.
 */

if (!is_user_logged_in()) return;

$current_user_id = get_current_user_id();
$current_user = wp_get_current_user();
$inbox_threads = ilybd_get_user_chat_threads($current_user_id);
?>

<!-- =====================================
     FLOATING MESSENGER TRIGGER BUBBLE (REMOVED AS PER REQUEST)
     ===================================== -->

<!-- =====================================
     MESSENGER MAIN INTERACTIVE PANEL
     ===================================== -->
<div class="cyber-messenger-sliding-panel" id="messenger-sliding-panel" style="display: none;">
    
    <!-- HEADER BAR -->
    <div class="messenger-panel-header">
        <div class="header-user-meta">
            <div class="mini-self-avatar">
                <?php echo get_avatar($current_user_id, 32); ?>
            </div>
            <h3>মেসেঞ্জার</h3>
        </div>
        <div class="header-action-tools">
            <button class="header-util-btn" onclick="toggleSearchBox()" title="নতুন চ্যাট শুরু করুন">🔍</button>
            <button class="header-util-btn close-panel-btn" onclick="toggleMessengerPanel(event)" title="বন্ধ করুন">&times;</button>
        </div>
    </div>

    <!-- DYNAMIC USER SEARCH SECTION -->
    <div class="messenger-search-bar-row" id="messenger-search-bar-row" style="display: none;">
        <input type="text" id="messenger-user-search-field" placeholder="ইউজার নেম দিয়ে খুঁজুন..." oninput="handleUserSearchInput(this)">
        <div class="search-results-floating-holder" id="search-results-holder">
            <!-- Filled dynamically -->
        </div>
    </div>

    <!-- MAIN BODY DIVISION WITH TWO STATES (Inbox or Conversation) -->
    <div class="messenger-panel-body">
        
        <!-- STATE A: INBOX STATE -->
        <div class="messenger-inbox-state" id="messenger-inbox-state">
            <div class="inbox-section-title">আমার চ্যাট সমূহ (Inbox)</div>
            <div class="inbox-threads-list-wrapper" id="inbox-threads-list">
                <?php if (empty($inbox_threads)): ?>
                    <div class="empty-inbox-helper-text">
                        🎈 এখনও কোনো চ্যাট বিবরণ নেই! উপরে সার্চ করে আপনার বন্ধুদের মেসেজ পাঠান।
                    </div>
                <?php else: ?>
                    <?php foreach ($inbox_threads as $thread): ?>
                        <div class="inbox-thread-row-item <?php echo $thread['unread'] ? 'unread-active' : ''; ?>" 
                             onclick="openChatBoxWithUser(<?php echo $thread['partner_id']; ?>, '<?php echo esc_js($thread['name']); ?>', '<?php echo esc_js($thread['avatar']); ?>')">
                            <div class="thread-avatar-wrapper">
                                <img src="<?php echo $thread['avatar']; ?>" class="thread-user-avatar">
                            </div>
                            <div class="thread-meta-desc">
                                <div class="thread-user-title"><?php echo esc_html($thread['name']); ?></div>
                                <div class="thread-message-snippet">
                                    <?php 
                                    if ($thread['sender'] == $current_user_id) {
                                        echo 'আপনি: ';
                                    }
                                    echo esc_html(wp_trim_words($thread['latest'], 6, '...')); 
                                    ?>
                                </div>
                            </div>
                            <div class="thread-action-indicator">
                                <?php if ($thread['unread']): ?>
                                    <span class="unread-blue-dot"></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- STATE B: CONVERSATION ACTIVE STATE -->
        <div class="messenger-conversation-state" id="messenger-conversation-state" style="display: none;">
            
            <!-- Conversation Sub-header with back button -->
            <div class="conv-sub-header">
                <button class="conv-back-btn" onclick="returnToInbox()">&larr; ইনবক্স</button>
                <div class="conv-partner-meta">
                    <img src="" id="conv-partner-avatar" class="mini-conv-avatar">
                    <span id="conv-partner-name">...</span>
                </div>
            </div>

            <!-- Scrollable chat items messages array -->
            <div class="chat-messages-scrollarea" id="chat-messages-scroller">
                <!-- Dynamically populated bubbles -->
            </div>

            <!-- Footer input deck -->
            <div class="chat-input-toolbar">
                <button class="smile-addon-btn" onclick="insertEmoji('😊')">😊</button>
                <button class="smile-addon-btn" onclick="insertEmoji('❤️')">❤️</button>
                <button class="smile-addon-btn" onclick="insertEmoji('👍')">👍</button>
                <input type="text" id="chat-composer-field" placeholder="মেসেজ লিখুন..." onkeypress="handleComposerKeyPress(event)">
                <button class="chat-send-btn" onclick="sendChatMessage()">পাঠান</button>
            </div>

        </div>

    </div>
</div>

<style>
/* CYBERPUNK CHAT ELEMENT STYLINGS */
.cyber-messenger-floating-badge {
    position: fixed;
    bottom: 85px;
    right: 25px;
    width: 58px;
    height: 58px;
    background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
    border-radius: 50%;
    box-shadow: 0 0 20px rgba(168, 85, 247, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    cursor: pointer;
    z-index: 999999;
    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s, background 0.3s;
    border: 1.5px solid rgba(255,255,255,0.2);
}

.cyber-messenger-floating-badge:hover {
    transform: scale(1.1);
    box-shadow: 0 0 30px rgba(168, 85, 247, 0.85);
    background: linear-gradient(135deg, #00ff41 0%, #00e5ff 100%);
    color: #000;
}

.msg-icon-svg {
    filter: drop-shadow(0 2px 5px rgba(0,0,0,0.3));
}

.badge-pulsing-unread {
    position: absolute;
    top: -2px;
    right: -2px;
    width: 14px;
    height: 14px;
    background: #ff004c;
    border-radius: 50%;
    border: 2px solid #000;
    box-shadow: 0 0 8px #ff004c;
    animation: unreadPulse 1.5s infinite;
}

@keyframes unreadPulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.25); opacity: 0.85; }
    100% { transform: scale(1); opacity: 1; }
}

/* SLIDING INTERACTIVE CHAT PANEL CONTAINER */
.cyber-messenger-sliding-panel {
    position: fixed;
    bottom: 155px;
    right: 25px;
    width: 380px;
    height: 520px;
    background: #090d14;
    border: 2px solid #a855f7;
    box-shadow: 0 10px 40px rgba(0,0,0,0.95), 0 0 18px rgba(168, 85, 247, 0.15);
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    z-index: 1000000;
    overflow: hidden;
    font-family: 'Inter', system-ui, sans-serif;
    animation: panelPop 0.3s cubic-bezier(0.19, 1, 0.22, 1) forwards;
}

@keyframes panelPop {
    from { opacity: 0; transform: translateY(20px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

@media(max-width: 480px) {
    .cyber-messenger-sliding-panel {
        width: calc(100% - 30px);
        height: 80vh;
        right: 15px;
        bottom: 85px;
    }
}

.messenger-panel-header {
    background: #111622;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1.5px solid rgba(255,255,255,0.05);
}

.header-user-meta {
    display: flex;
    align-items: center;
    gap: 10px;
}

.mini-self-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    overflow: hidden;
    border: 1.5px solid #00ff41;
}

.mini-self-avatar img {
    width: 100%; height: 100%; object-fit: cover;
}

.header-user-meta h3 {
    margin: 0;
    font-size: 14.5px;
    font-weight: 900;
    text-transform: uppercase;
    background: linear-gradient(135deg, #00ff41 0%, #00e5ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.header-action-tools {
    display: flex;
    gap: 10px;
}

.header-util-btn {
    background: none;
    border: none;
    color: #a0aec0;
    font-size: 15px;
    cursor: pointer;
    line-height: 1;
    transition: color 0.2s;
}

.header-util-btn:hover {
    color: #fff;
}

.close-panel-btn {
    font-size: 20px;
}

/* User search input designs */
.messenger-search-bar-row {
    padding: 10px 15px;
    background: #141a27;
    position: relative;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.messenger-search-bar-row input {
    width: 100%;
    background: #0c0f16;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 12.5px;
    color: #fff;
}

.search-results-floating-holder {
    position: absolute;
    top: 100%; left: 0; width: 100%;
    background: #101520;
    border-top: 1px solid rgba(255,255,255,0.05);
    max-height: 200px;
    overflow-y: auto;
    z-index: 100;
}

.search-result-user-node {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 1px solid rgba(255,255,255,0.02);
}

.search-result-user-node:hover {
    background: rgba(0,255,65,0.08);
}

.search-result-user-node img {
    width: 32px; height: 32px; border-radius: 50%;
}

.search-result-user-node span {
    font-size: 12.5px; font-weight: bold; color: #fff;
}

.messenger-panel-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* STATE A: COMFORTABLE INBOX */
.messenger-inbox-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}

.inbox-section-title {
    font-size: 11px;
    color: #718096;
    padding: 12px 16px 6px 16px;
    text-transform: uppercase;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.inbox-threads-list-wrapper {
    display: flex;
    flex-direction: column;
}

.empty-inbox-helper-text {
    text-align: center;
    padding: 40px 25px;
    font-size: 12.5px;
    color: #a0aec0;
    line-height: 1.6;
}

.inbox-thread-row-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid rgba(255,255,255,0.02);
    transition: background 0.2s;
}

.inbox-thread-row-item:hover {
    background: rgba(255, 255, 255, 0.03);
}

.inbox-thread-row-item.unread-active {
    background: rgba(168, 85, 247, 0.04);
}

.inbox-thread-row-item.unread-active .thread-user-title {
    color: #fff;
    font-weight: 800;
}

.inbox-thread-row-item.unread-active .thread-message-snippet {
    color: #e2e8f0;
    font-weight: 700;
}

.thread-user-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
}

.thread-meta-desc {
    flex: 1;
}

.thread-user-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #e2e8f0;
    margin-bottom: 4px;
}

.thread-message-snippet {
    font-size: 11.5px;
    color: #718096;
}

.unread-blue-dot {
    width: 10px;
    height: 10px;
    background: #00f0ff;
    border-radius: 50%;
    display: block;
    box-shadow: 0 0 8px #00f0ff;
}

/* STATE B: CONVERSATION STYLES */
.messenger-conversation-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #080b0f;
}

.conv-sub-header {
    display: flex;
    align-items: center;
    padding: 10px 14px;
    background: #11151e;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}

.conv-back-btn {
    background: none;
    border: none;
    color: #00ff41;
    font-size: 12.5px;
    font-weight: 800;
    cursor: pointer;
    padding-right: 10px;
}

.conv-partner-meta {
    display: flex;
    align-items: center;
    gap: 10px;
}

.mini-conv-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
}

#conv-partner-name {
    font-size: 12.5px;
    font-weight: 800;
    color: #fff;
}

/* Messages bubbles scroller box */
.chat-messages-scrollarea {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.chat-bubble-container {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    max-width: 82%;
}

/* If sender is self, align right */
.chat-bubble-container.sender-self {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.bubble-avatar {
    width: 26px; height: 26px; border-radius: 50%;
}

.bubble-text-and-meta {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.bubble-body-text {
    padding: 8px 12px;
    border-radius: 12px;
    font-size: 12.5px;
    line-height: 1.5;
    word-break: break-word;
}

.chat-bubble-container.sender-self .bubble-body-text {
    background: #a855f7;
    color: #fff;
    border-bottom-right-radius: 2px;
}

.chat-bubble-container.sender-partner .bubble-body-text {
    background: #1e293b;
    color: #f1f5f9;
    border-bottom-left-radius: 2px;
}

.bubble-timestamp {
    font-size: 8.5px;
    color: #4a5568;
    align-self: flex-start;
}

.chat-bubble-container.sender-self .bubble-timestamp {
    align-self: flex-end;
}

/* Input text Composer */
.chat-input-toolbar {
    background: #11151e;
    padding: 10px;
    display: flex;
    gap: 6px;
    align-items: center;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.smile-addon-btn {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
}

.chat-input-toolbar input {
    flex: 1;
    background: #090c12;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 6px;
    padding: 8px 10px;
    font-size: 12.5px;
    color: #fff;
}

.chat-send-btn {
    background: #a855f7;
    color: #fff;
    border: none;
    font-weight: 800;
    font-size: 11px;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
}
</style>

<script>
let currentChatActivePartnerId = null;
let chatPoolingTimer = null;

function toggleMessengerPanel(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    const panel = document.getElementById('messenger-sliding-panel');
    if (panel.style.display === 'none') {
        panel.style.display = 'flex';
        // Reload inbox on open
        refreshInboxUI();
    } else {
        panel.style.display = 'none';
        stopChatPooling();
    }
}

function toggleSearchBox() {
    const box = document.getElementById('messenger-search-bar-row');
    box.style.display = box.style.display === 'none' ? 'block' : 'none';
    if (box.style.display === 'block') {
        document.getElementById('messenger-user-search-field').focus();
    }
}

function handleUserSearchInput(input) {
    const val = input.value.trim();
    const holder = document.getElementById('search-results-holder');
    
    if (val.length < 2) {
        holder.innerHTML = '';
        return;
    }
    
    jQuery.post('/wp-admin/admin-ajax.php', {
        action: 'ilybd_search_users',
        search: val
    }, function(res) {
        if (res.success && res.data.users) {
            holder.innerHTML = '';
            res.data.users.forEach(u => {
                const node = `
                    <div class="search-result-user-node" onclick="openChatBoxWithUser(${u.id}, '${escapeJSVal(u.name)}', '${u.avatar}')">
                        <img src="${u.avatar}">
                        <span>${u.name}</span>
                    </div>
                `;
                holder.insertAdjacentHTML('beforeend', node);
            });
        }
    });
}

function escapeJSVal(str) {
    return str.replace(/'/g, "\\'");
}

function openChatBoxWithUser(partnerId, name, avatar) {
    currentChatActivePartnerId = partnerId;
    
    // Hide Search display
    document.getElementById('messenger-search-bar-row').style.display = 'none';
    document.getElementById('messenger-user-search-field').value = '';
    document.getElementById('search-results-holder').innerHTML = '';
    
    // Switch Views
    document.getElementById('messenger-inbox-state').style.display = 'none';
    document.getElementById('messenger-conversation-state').style.display = 'flex';
    
    // Apply header details
    document.getElementById('conv-partner-name').innerText = name;
    document.getElementById('conv-partner-avatar').src = avatar;
    
    // Switch sliding panel active if closed
    const panel = document.getElementById('messenger-sliding-panel');
    if (panel.style.display === 'none') {
        panel.style.display = 'flex';
    }
    
    // Load existing messages
    fetchThreadMessages();
    
    // Start live pulling
    startChatPooling();
}

function returnToInbox() {
    stopChatPooling();
    currentChatActivePartnerId = null;
    document.getElementById('messenger-conversation-state').style.display = 'none';
    document.getElementById('messenger-inbox-state').style.display = 'flex';
    refreshInboxUI();
}

function fetchThreadMessages() {
    if (!currentChatActivePartnerId) return;
    
    jQuery.post('/wp-admin/admin-ajax.php', {
        action: 'ilybd_get_messages',
        partner_id: currentChatActivePartnerId
    }, function(res) {
        if (res.success && res.data.messages) {
            renderChatBubbles(res.data.messages, res.data.partner.avatar);
        }
    });
}

function renderChatBubbles(messages, partnerAvatar) {
    const scroller = document.getElementById('chat-messages-scroller');
    const oldHeight = scroller.scrollHeight;
    
    scroller.innerHTML = '';
    if (messages.length === 0) {
        scroller.innerHTML = '<div style="font-size:11px; padding:40px 10px; color:#4a5568; text-align:center;">👋 হাই বলুন! চ্যাট শুরু করতে নিচের বক্সে মেসেজ লিখুন।</div>';
        return;
    }
    
    messages.forEach(m => {
        const isSelf = m.sender_id === <?php echo $current_user_id; ?>;
        const avatar = isSelf ? '' : `<img src="${partnerAvatar}" class="bubble-avatar">`;
        const wrapClass = isSelf ? 'sender-self' : 'sender-partner';
        
        const bubble = `
            <div class="chat-bubble-container ${wrapClass}">
                ${avatar}
                <div class="bubble-text-and-meta">
                    <div class="bubble-body-text">${m.message}</div>
                    <span class="bubble-timestamp font-mono">${m.time}</span>
                </div>
            </div>
        `;
        scroller.insertAdjacentHTML('beforeend', bubble);
    });
    
    // Auto Scroll to bottom
    if (scroller.scrollHeight > oldHeight) {
        scroller.scrollTop = scroller.scrollHeight;
    }
}

function insertEmoji(emoji) {
    const field = document.getElementById('chat-composer-field');
    field.value += emoji;
    field.focus();
}

function handleComposerKeyPress(e) {
    if (e.key === 'Enter') {
        sendChatMessage();
    }
}

function sendChatMessage() {
    const field = document.getElementById('chat-composer-field');
    const val = field.value.trim();
    if (!val || !currentChatActivePartnerId) return;
    
    field.value = '';
    
    jQuery.post('/wp-admin/admin-ajax.php', {
        action: 'ilybd_send_message',
        partner_id: currentChatActivePartnerId,
        message: val
    }, function(res) {
        if (res.success) {
            fetchThreadMessages();
        } else {
            alert(res.data.message || 'মেসেজ পাঠাতে সমস্যা হচ্ছে!');
        }
    });
}

function startChatPooling() {
    stopChatPooling();
    chatPoolingTimer = setInterval(function() {
        fetchThreadMessages();
    }, 3500); // Poll every 3.5 seconds
}

function stopChatPooling() {
    if (chatPoolingTimer) {
        clearInterval(chatPoolingTimer);
    }
}

function refreshInboxUI() {
    // We can run an AJAX request to dynamically load the latest raw inbox records for absolute freshness
    jQuery.post('/wp-admin/admin-ajax.php', {
        action: 'ilybd_get_messages', // Use proxy or just reload box structure
        partner_id: -1 // Custom trigger just to return inbox is also option, but a simpler local DOM loader works. Let's do a direct page scan trigger for ultimate performance
    }, function() {
        // Option to reload Inbox thread entries dynamically
    });
}
</script>
