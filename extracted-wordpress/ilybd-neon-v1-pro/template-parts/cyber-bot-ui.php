<?php
/**
 * IBD Cyber Bot UI Template (MAYA ULTIMATE GEMINI VERSION)
 * High-precision professional design and complete feature suite mirroring Google Gemini App.
 */
?>
<div id="cyber-bot-wrapper" class="cyber-gemini-wrapper">
    <!-- Sliding Sidebar for Chat Threads & Recent logs -->
    <div class="cyber-gemini-sidebar collapsed" id="cyber-gemini-sidebar">
        <div class="sidebar-header">
            <span class="sidebar-title">ARCHIVED THREADS</span>
            <button id="wp-new-chat-btn" class="wp-accent-btn" title="নতুন চ্যাট থ্রেড">+</button>
        </div>
        <div class="sidebar-threads-list" id="sidebar-threads-list">
            <!-- Threads populated dynamically by JS from localStorage -->
            <div class="sidebar-item active">প্রধান সহকারী চ্যাট</div>
        </div>
        <div class="sidebar-footer">
            <div class="footer-status-tag">
                <span class="status-marker neon-green"></span>
                <span>SECURE CLIENT DATA</span>
            </div>
        </div>
    </div>

    <!-- Main Live Workspace Window -->
    <div class="cyber-chat-window active-window-grid" id="cyber-chat-window">
        <!-- Professional Gemini Gradient Header -->
        <div class="chat-header">
            <div class="header-main-left">
                <!-- Sidebar Toggle button -->
                <button id="sidebar-toggle-trigger" class="custom-icon-btn" title="আর্কাইভ টগল">=</button>
                
                <div class="bot-info-meta">
                    <span class="header-title" style="display: flex; align-items: center; gap: 6px;">
                        <?php if (get_option('ilybd_enable_cyber_shield', 'yes') === 'yes'): ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icon-cyber-shield.svg'); ?>" alt="Cyber Shield" style="width: 20px; height: 20px; filter: drop-shadow(0 0 8px #00f0ff); flex-shrink: 0;" referrerPolicy="no-referrer">
                        <?php else: ?>
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" class="sparkle-anim-svg" style="flex-shrink:0;">
                                <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                            </svg>
                        <?php endif; ?>
                        মায়া (Maya AI)
                    </span>
                    <span class="header-status-badge">GEMINI ENGINE READY</span>
                    <span class="header-status-badge" id="cyber-power-badge" style="margin-left:8px; background:rgba(0,255,65,0.08); border:1px solid #00ff41; color:#00ff41; font-weight:bold; font-size:10px;">POWER: GUEST (1X SPEED)</span>
                </div>
            </div>

            <!-- Header interactions: Selector & settings button -->
            <div class="header-main-right">
                <select id="wp-model-select" class="custom-wp-select" aria-label="Select AI Model">
                    <option value="gemini-3.5-flash">Maya Flash (Fast)</option>
                    <option value="gemini-3.1-pro-preview">Maya Pro (Logic)</option>
                    <option value="maya-ultra">Maya Ultra (Reasoning)</option>
                </select>

                <!-- Shadow Terminal Toggle -->
                <button id="terminal-mode-btn" class="custom-icon-btn" title="শ্যাডো টার্মিনাল মোড টগল" style="color:#00ff41;">
                    <i class="fa-solid fa-terminal"></i>
                </button>

                <!-- Simplified / Senior mode Toggle -->
                <button id="simplified-mode-btn" class="custom-icon-btn" title="সহজ মোড (Zero-Tech) টগল" style="color:#ffb700;">
                    <i class="fa-solid fa-eye-low-vision"></i>
                </button>
                
                <button id="wp-settings-trigger-btn" class="custom-icon-btn" title="এআই সেটিংসপ্যানেল">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </button>

                <button id="close-chat" onclick="jQuery('#cyber-chat-window').removeClass('active');" title="উইন্ডো বন্ধ করুন">&times;</button>
            </div>
        </div>
        
        <!-- Conversation Thread -->
        <div class="chat-body" id="chat-content">
            <!-- Dynamic welcome banner shown when starting a fresh discussion -->
            <div id="wp-welcome-banner" class="welcome-preset-center">
                <div class="welcome-orb">
                    <svg viewBox="0 0 24 24" width="36" height="36" fill="currentColor" style="color: #00f0ff;">
                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14.5h-2v-2h2zm0-3.5h-2V7h2z"/>
                    </svg>
                </div>
                <h3>আসসালামু আলাইকুম! আমি মায়া এআই</h3>
                <p>আমি iloveyoubd.com-এর প্রফেশনাল জেমিনি এআই রিয়েলটাইম অ্যাসিস্ট্যান্ট। কীভাবে আপনাকে সাহায্য করতে পারি?</p>
                
                <!-- Quick Suggestion Cards -->
                <div class="welcome-grid-presets">
                    <div class="preset-card" data-prompt="একটি সায়েন্স ফিকশন সাইবার ক্যাটের ছবি আঁকো।">
                        <h5>🎨 সাইবার ক্যাট ছবি</h5>
                        <p>একটি নিয়ন ফিউচারিস্টিক বিড়ালের ছবি আঁকো।</p>
                    </div>
                    <div class="preset-card" data-prompt="পিএইচপি এবং রিঅ্যাক্ট ওয়েবসাইট ট্রাফিক বৃদ্ধির দারুণ এসইও কোড দাও">
                        <h5>💻 কোডিং ও এসইও</h5>
                        <p>এসইও উন্নত করার সুন্দর পিএইচপি স্ট্রাকচার দেখুন।</p>
                    </div>
                    <div class="preset-card" data-prompt="একটি ডার্ক ড্রাম এন্ড বেস হ্যাকিং মেলোডি বিট তৈরি করো">
                        <h5>🎵 মিউজিক জেনারেটর</h5>
                        <p>কোয়ান্টাম মেলোডিক বিট ও সিন্থ প্লে করুন।</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Float Visualizer for synthesizers -->
        <div id="wp-synth-indicator" class="synth-indicator-strip" style="display: none;">
            <span class="indicator-inner">🎵 মায়া সিন্থেসাইজার মেলোডি প্যাটার্ন প্রস্তুত করছে...</span>
            <div class="waveform-anim-mini">
                <span></span><span></span><span></span><span></span>
            </div>
        </div>

        <!-- Input Box Area with multiple actions -->
        <div class="chat-footer">
            <!-- Attachment/Interactivities quick controls bar -->
            <div id="wp-footer-actions" class="footer-actions-row">
                <button class="footer-action-btn" id="action-voice-dict" title="ভয়েস ডিকটেশন"><span class="icon-label">🎤 Voice Talk</span></button>
                <button class="preset-action-btn" id="action-draw-image" title="ছবি জেনারেট করুন"><span class="icon-label">🎨 Create Image</span></button>
                <button class="preset-action-btn" id="action-compose-music" title="মিউজিক সিন্থেসাইজ"><span class="icon-label">🎵 Synth Music</span></button>
            </div>

            <!-- Real Input Row -->
            <div class="input-container-row">
                <input type="text" id="user-input" placeholder="মায়াকে কিছু বলুন বা যেকোনো প্রশ্ন টাইপ করুন..." autocomplete="off">
                <button id="send-btn" aria-label="Send message">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Modals Panel (WP Theme Side Administration & Config Settings) -->
    <div id="wp-gemini-settings-modal" class="gemini-modal-scaffold" style="display: none;">
        <div class="modal-card-container">
            <div class="modal-card-header">
                <h4>🔑 মায়া এআই কনফিগারেশন প্যানেল</h4>
                <button id="close-wp-settings" class="close-modal-x">&times;</button>
            </div>
            <div class="modal-card-body">
                <div class="form-group-item">
                    <label>CUSTOMER KEYS ROTATION POOL (একটির কোটা শেষ হলে আরেকটি কাজ করবে):</label>
                    <textarea id="wp-custom-keys-pool" placeholder="প্রতি লাইনে একটি করে এপিআই কি দিন..." rows="3"></textarea>
                </div>
                
                <div class="form-group-item">
                    <label>SYSTEM INSTRUCTION TUNER (মায়াকে আপনার পছন্দমত ব্যক্তিত্ব দিন):</label>
                    <input type="text" id="wp-system-prompt" value="You are Maya (মায়া), the highly professional, helpful, and extremely competent executive AI assistant of iloveyoubd.com. Write in flawless Bangla.">
                </div>

                <div class="setting-grid-halves">
                    <div class="form-group-item bg-dark-card border-c">
                        <label>CREATIVE TEMP (0.1 - 1.0)</label>
                        <input type="range" id="wp-temp-range" min="0.1" max="1.0" step="0.1" value="0.7">
                        <span id="temp-display-val" style="color: #00f0ff; font-weight: bold;">0.7</span>
                    </div>

                    <div class="form-group-item bg-dark-card border-c flex-align-between">
                        <label>CLIENT EFFECTS / SOUND</label>
                        <button id="wp-sound-toggle-btn" class="sys-btn active">SOUNDS EFFECT ON</button>
                    </div>
                </div>

                <div class="action-destruct-panel">
                    <div class="destruct-meta">
                        <h5>সম্পূর্ণ চ্যাট আর্কাইভ রিসেট করুন</h5>
                        <p>আপনার ব্রাউজারে সংরক্ষিত সমস্ত বিগত আলোচনা ডিলিট হয়ে যাবে।</p>
                    </div>
                    <button id="wp-reset-chats-btn" class="destruct-btn">RESET ARCHIVE</button>
                </div>
            </div>
            <div class="modal-card-footer">
                <button id="wp-cancel-settings-btn" class="dismiss-btn-alt">CANCEL</button>
                <button id="wp-save-settings-btn" class="wp-accent-save-btn">SAVE & COMBINE KEYS</button>
            </div>
        </div>
    </div>
</div>
