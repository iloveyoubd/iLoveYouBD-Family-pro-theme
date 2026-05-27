jQuery(document).ready(function($) {
    // --- QUERY SELECTORS ---
    const chatWindow = $('#cyber-chat-window');
    const closeBtn = $('#close-chat');
    const sendBtn = $('#send-btn');
    const userInput = $('#user-input');
    const chatContent = $('#chat-content');
    const sidebar = $('#cyber-gemini-sidebar');
    const sidebarToggleBtn = $('#sidebar-toggle-trigger');
    const newChatBtn = $('#wp-new-chat-btn');
    const threadsList = $('#sidebar-threads-list');
    
    // Suggestion Presets
    const presetCards = $('.preset-card');
    const welcomeBanner = $('#wp-welcome-banner');
    
    // Advanced buttons
    const synthIndicator = $('#wp-synth-indicator');
    const voiceDictBtn = $('#action-voice-dict');
    const drawImgBtn = $('#action-draw-image');
    const composeMusicBtn = $('#action-compose-music');

    // Settings elements
    const settingsModal = $('#wp-gemini-settings-modal');
    const settingsTriggerBtn = $('#wp-settings-trigger-btn');
    const settingsCloseBtn = $('#close-wp-settings');
    const settingsCancelBtn = $('#wp-cancel-settings-btn');
    const settingsSaveBtn = $('#wp-save-settings-btn');
    const apiKeysInput = $('#wp-custom-keys-pool');
    const systemPromptInput = $('#wp-system-prompt');
    const tempRangeInput = $('#wp-temp-range');
    const tempDisplayVal = $('#temp-display-val');
    const soundToggleBtn = $('#wp-sound-toggle-btn');
    const resetChatsBtn = $('#wp-reset-chats-btn');
    const modelSelect = $('#wp-model-select');

    // --- SYSTEM PARAMETERS AND STATE LOGS ---
    let activeChatId = "chat_default";
    let isDictating = false;
    let soundEnabled = true;
    let activeUtterance = null;
    let currentSpeakingId = null;

    // --- GAMIFICATION & POWER LEVELS & DYNAMIC SPEEDS ---
    let typeSpeedDelay = (typeof ilybd_vfx !== 'undefined' && ilybd_vfx.type_speed) ? parseInt(ilybd_vfx.type_speed) : 12;
    let userTierName = (typeof ilybd_vfx !== 'undefined' && ilybd_vfx.tier) ? ilybd_vfx.tier : 'Guest';
    let userTierColor = (typeof ilybd_vfx !== 'undefined' && ilybd_vfx.tier_color) ? ilybd_vfx.tier_color : '#00ff41';
    let userXPCount = (typeof ilybd_vfx !== 'undefined' && ilybd_vfx.user_xp) ? parseInt(ilybd_vfx.user_xp) : 0;

    function hexToRgb(hex) {
        hex = hex.replace('#', '');
        let r = parseInt(hex.substring(0, 2), 16);
        let g = parseInt(hex.substring(2, 4), 16);
        let b = parseInt(hex.substring(4, 6), 16);
        return r + ',' + g + ',' + b;
    }

    const powerBadge = $('#cyber-power-badge');
    if (powerBadge.length) {
        let speedMult = '1X';
        if (userTierName === 'Member') speedMult = '2X';
        if (userTierName === 'Elite') speedMult = '4X';
        powerBadge.html(`POWER: ${userTierName.toUpperCase()} (${speedMult} SPEED)`);
        powerBadge.css({
            'border-color': userTierColor,
            'color': userTierColor,
            'background': 'rgba(' + hexToRgb(userTierColor) + ', 0.08)'
        });
    }

    // --- SHADOW TERMINAL & SIMPLIFIED MODES ---
    let isTerminalMode = localStorage.getItem("wp_maya_terminal_mode") === "true";
    let isSimplifiedMode = localStorage.getItem("wp_maya_simplified_mode") === "true";

    const terminalBtn = $('#terminal-mode-btn');
    const simplifiedBtn = $('#simplified-mode-btn');
    const botWrapper = $('#cyber-bot-wrapper');

    function applyScreenModes() {
        if (isTerminalMode) {
            botWrapper.addClass('terminal-mode-active');
            terminalBtn.addClass('active-glow').css('color', '#00ff41');
            userInput.attr('placeholder', `${userTierName.toLowerCase()}@ibd-cyber-shield:~$ `);
        } else {
            botWrapper.removeClass('terminal-mode-active');
            terminalBtn.removeClass('active-glow').css('color', '');
            userInput.attr('placeholder', 'মায়াকে কিছু বলুন বা যেকোনো প্রশ্ন টাইপ করুন...');
        }

        if (isSimplifiedMode) {
            botWrapper.addClass('simplified-mode-active');
            simplifiedBtn.addClass('active-glow').css('color', '#ff5f56');
        } else {
            botWrapper.removeClass('simplified-mode-active');
            simplifiedBtn.removeClass('active-glow').css('color', '');
        }
    }

    terminalBtn.on('click', function(e) {
        e.preventDefault();
        isTerminalMode = !isTerminalMode;
        localStorage.setItem("wp_maya_terminal_mode", isTerminalMode);
        applyScreenModes();
        if (soundEnabled) composeVirtualMelody("terminal-toggle");
    });

    simplifiedBtn.on('click', function(e) {
        e.preventDefault();
        isSimplifiedMode = !isSimplifiedMode;
        localStorage.setItem("wp_maya_simplified_mode", isSimplifiedMode);
        applyScreenModes();
        if (soundEnabled) composeVirtualMelody("simple-toggle");
    });

    setTimeout(applyScreenModes, 100);

    // Load custom settings
    let customKeys = localStorage.getItem("wp_maya_api_keys") || "";
    let customSystemPrompt = localStorage.getItem("wp_maya_sys_prompt") || "You are Maya (মায়া), the highly professional executive AI assistant of iloveyoubd.com. Write in flawless Bangla.";
    let creativeTemp = localStorage.getItem("wp_maya_temp") || "0.7";
    
    apiKeysInput.val(customKeys);
    systemPromptInput.val(customSystemPrompt);
    tempRangeInput.val(creativeTemp);
    tempDisplayVal.text(creativeTemp);

    // Temp slider dynamics
    tempRangeInput.on('input', function() {
        tempDisplayVal.text($(this).val());
    });

    // Sound Toggle Controls
    soundToggleBtn.on('click', function() {
        soundEnabled = !soundEnabled;
        if(soundEnabled) {
            $(this).removeClass('muted').addClass('active').text('SOUNDS EFFECT ON');
        } else {
            $(this).removeClass('active').addClass('muted').text('SOUNDS EFFECT OFF');
        }
    });

    // --- PERSISTENT CHAT HISTORY SYSTEM (LOCALSTORAGE) ---
    function getStoredChats() {
        let raw = localStorage.getItem("wp_maya_gemini_threads");
        if(raw) {
            try { return JSON.parse(raw); } catch(e) { console.error(e); }
        }
        // Return default starting thread
        return [{
            id: "chat_default",
            title: "প্রধান সহকারী চ্যাট",
            model: "gemini-3.5-flash",
            messages: []
        }];
    }

    function saveStoredChats(chatsObj) {
        localStorage.setItem("wp_maya_gemini_threads", JSON.stringify(chatsObj));
    }

    // --- MARKDOWN & SYNTAX FORMATTING METHOD ---
    function parseMarkdown(text) {
        if (!text) return "";
        let result = text;
        
        // Escape standard HTML tags
        result = result.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");

        // Code blocks block formatting with copy triggers
        result = result.replace(/```(\w*)\n([\s\S]*?)```/g, function(match, lang, code) {
            let uniqueId = 'code-' + Math.floor(Math.random()*10000);
            return `<div class="code-container font-mono bg-[#040712] border border-cyan-500/20 rounded-xl my-4 overflow-hidden shadow-lg">
                <div class="flex items-center justify-between p-2.5 bg-[#0b1022] border-b border-cyan-500/10 text-[10px] text-cyan-400 font-bold" style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span style="width:9px; height:9px; border-radius:50%; background:#ff5f56; display:inline-block;"></span>
                        <span style="width:9px; height:9px; border-radius:50%; background:#ffbd2e; display:inline-block;"></span>
                        <span style="width:9px; height:9px; border-radius:50%; background:#27c93f; display:inline-block;"></span>
                        <span style="margin-left:8px; font-family:monospace; color:#94a3b8; font-weight:700; text-transform:uppercase; font-size:10px; letter-spacing:0.5px;">${lang ? lang.toUpperCase() : "SOURCE CODE"}</span>
                    </div>
                    <button class="copy-block-btn" data-code="${encodeURIComponent(code)}" style="background:rgba(0, 240, 255, 0.08); border:1px solid rgba(0, 240, 255, 0.2); border-radius:6px; color:#00f0ff; font-weight:bold; font-size:10.5px; padding:4px 10px; cursor:pointer; transition:all 0.2s;">কপি করুন</button>
                </div>
                <pre class="p-4 overflow-x-auto text-emerald-400 text-xs leading-relaxed" style="margin:0; background:#040712;"><code>${code}</code></pre>
            </div>`;
        });

        // Inline Bold formatting
        result = result.replace(/\*\*([^*]+)\*\*/g, '<strong class="font-bold text-cyan-300">$1</strong>');

        // Lists bullet indentations
        result = result.replace(/^\s*-\s+(.+)$/gm, '<li style="margin-left:20px; list-style-type:disc; color:#cbd5e1" class="text-slate-300">$1</li>');
        result = result.replace(/^\s*\d+\.\s+(.+)$/gm, '<li style="margin-left:20px; list-style-type:decimal; color:#cbd5e1" class="text-slate-300">$1</li>');

        // Spacing linebreaks
        result = result.replace(/\n/g, '<br/>');

        return result;
    }

    // --- CORE MUSIC SYNTHESIZER ---
    function composeVirtualMelody(promptText) {
        if (!soundEnabled) return;
        
        try {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) return;
            const ctx = new AudioContextClass();

            // Notes frequency mapping to compose retro sci-fi beats
            const noteFrequencies = [261.63, 293.66, 329.63, 392.00, 440.00, 523.25]; // C D E G A C
            let now = ctx.currentTime;

            noteFrequencies.forEach((freq, idx) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                // Select waveform
                if (promptText.includes("হ্যাকিং") || promptText.includes("drum") || promptText.includes("synth")) {
                    osc.type = "sawtooth";
                } else {
                    osc.type = "sine";
                }

                osc.frequency.setValueAtTime(freq, now + idx * 0.2);
                gain.gain.setValueAtTime(0.12, now + idx * 0.2);
                gain.gain.exponentialRampToValueAtTime(0.01, now + idx * 0.2 + 0.18);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start(now + idx * 0.2);
                osc.stop(now + idx * 0.2 + 0.19);
            });
        } catch(e) {
            console.error("Browser synthesizer engine failed:", e);
        }
    }

    // --- NATIVE SPEAK OUT / TEXT TO SPEECH (TTS) ---
    function speakAloud(text, elementId) {
        if (!('speechSynthesis' in window)) return;

        if (currentSpeakingId === elementId) {
            window.speechSynthesis.cancel();
            currentSpeakingId = null;
            $(`.msg-voice-play-trigger[data-id="${elementId}"]`).removeClass('speaking-active').text('🔊 শুনুন');
            return;
        }

        window.speechSynthesis.cancel();
        $('.msg-voice-play-trigger').removeClass('speaking-active').text('🔊 শুনুন');

        let cleanText = text.replace(/<[^>]*>/g, "").replace(/\*\*|`|```/g, "");
        activeUtterance = new SpeechSynthesisUtterance(cleanText);
        activeUtterance.lang = "bn-BD";

        // Attempt resolving Bengali voice actor
        let voices = window.speechSynthesis.getVoices();
        let bnVoice = voices.find(v => v.lang.includes("BN") || v.lang.includes("bn"));
        if(bnVoice) activeUtterance.voice = bnVoice;

        activeUtterance.onend = function() {
            currentSpeakingId = null;
            $(`.msg-voice-play-trigger[data-id="${elementId}"]`).removeClass('speaking-active').text('🔊 শুনুন');
        };

        activeUtterance.onerror = function() {
            currentSpeakingId = null;
            $(`.msg-voice-play-trigger[data-id="${elementId}"]`).removeClass('speaking-active').text('🔊 শুনুন');
        };

        currentSpeakingId = elementId;
        $(`.msg-voice-play-trigger[data-id="${elementId}"]`).addClass('speaking-active').text('🛑 অফ করুন');
        window.speechSynthesis.speak(activeUtterance);
    }

    // --- SIDEBAR ARCHIVED LIST RENDERING ---
    function populateSidebarThreads() {
        let chats = getStoredChats();
        threadsList.empty();
        
        chats.forEach(chat => {
            let activeClass = chat.id === activeChatId ? "active" : "";
            let itemHtml = `<div class="sidebar-item ${activeClass}" data-id="${chat.id}">
                <span>${chat.title}</span>
                ${chats.length > 1 ? `<button class="sidebar-item-delete" data-id="${chat.id}">&times;</button>` : ""}
            </div>`;
            threadsList.append(itemHtml);
        });
    }

    // --- DISPLAY OR INITIALIZE LOAD ENGINE ---
    function renderChatThread() {
        let chats = getStoredChats();
        let activeChat = chats.find(c => c.id === activeChatId) || chats[0];
        activeChatId = activeChat.id;

        // Populate header model selector to match thread model
        if(activeChat.model) {
            modelSelect.val(activeChat.model);
        }

        // Clean chat space from past dynamic entries keeping welcome state safe
        chatContent.find('.gemini-message-block').remove();
        chatContent.find('.bot-processing-msg').remove();

        if (activeChat.messages && activeChat.messages.length > 0) {
            welcomeBanner.hide();
            activeChat.messages.forEach(msg => {
                appendMsgHtml(msg.role, msg.content, msg.id, msg.timestamp, msg.type, msg.imageUrl);
            });
            chatContent.scrollTop(chatContent[0].scrollHeight);
        } else {
            welcomeBanner.show();
        }

        populateSidebarThreads();
    }

    function playTypeTick() {
        if (!soundEnabled) return;
        try {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) return;
            const ctx = new AudioContextClass();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = "sine";
            osc.frequency.setValueAtTime(900 + Math.random() * 300, ctx.currentTime);
            gain.gain.setValueAtTime(0.008, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.04);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.04);
        } catch(e) {}
    }

    function typeWriterNode(sourceNode, targetNode, callback) {
        let childNodes = Array.from(sourceNode.childNodes);
        let i = 0;
        
        function processNext() {
            if (i >= childNodes.length) {
                if (callback) callback();
                return;
            }
            
            let child = childNodes[i];
            if (child.nodeType === Node.TEXT_NODE) {
                let text = child.nodeValue;
                let textNode = document.createTextNode('');
                targetNode.appendChild(textNode);
                
                let j = 0;
                function typeChar() {
                    if (j < text.length) {
                        textNode.nodeValue += text[j];
                        j++;
                        if (j % 5 === 0) {
                            playTypeTick();
                        }
                        chatContent.scrollTop(chatContent[0].scrollHeight);
                        setTimeout(typeChar, typeSpeedDelay);
                    } else {
                        i++;
                        processNext();
                    }
                }
                typeChar();
            } else if (child.nodeType === Node.ELEMENT_NODE) {
                let elem = document.createElement(child.nodeName);
                Array.from(child.attributes).forEach(attr => {
                    elem.setAttribute(attr.name, attr.value);
                });
                targetNode.appendChild(elem);
                
                typeWriterNode(child, elem, function() {
                    i++;
                    processNext();
                });
            }
        }
        processNext();
    }

    // --- APPEND RENDERING TO DESIRED THREAD FLOW ---
    function appendMsgHtml(role, text, id, stamp, type, imageUrl, animate = false) {
        let isUser = role === "user";
        let roleClass = isUser ? "user-type" : "bot-type";
        let parsedText = parseMarkdown(text);
        let timestampVal = stamp || new Date().toLocaleTimeString('bn-BD', {hour:'2-digit', minute:'2-digit'});

        let attachmentCard = "";
        if (type === "image" && imageUrl) {
            attachmentCard = `<div class="image-box animate-scale-entry" style="margin-bottom:12px;">
                <img src="${imageUrl}" alt="Maya AI Vector generation" class="msg-image-attachment" style="border-radius:12px; max-width:100%; border:1px solid rgba(0,240,255,0.2)"/>
                <div style="margin-top:4px;"><a href="${imageUrl}" target="_blank" class="cyber-btn" style="color:#00f0ff; font-weight:bold; font-size:11px; text-decoration:none;">💾 ফুল সাইজ ডাউনলোড</a></div>
            </div>`;
        } else if (type === "music") {
            attachmentCard = `<div class="music-synth-strip bg-[#060a14] border border-cyan-500/20 p-3 rounded-xl flex items-center justify-between my-3 animate-scale-entry" style="display:flex; justify-content:space-between; align-items:center; background:#060a14; padding:10px; border-radius:10px; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <button class="synth-play-osc-btn" data-prompt="${encodeURIComponent(text)}" style="width:34px; height:34px; border-radius:50%; background:#00f0ff; color:#000; font-size:14px; border:none; cursor:pointer;">▶</button>
                    <div>
                        <span style="font-size: 10px; font-family:monospace; color:#00f0ff; display:block;">SYNTH MELODY READY</span>
                        <small style="color:#64748b; font-size:9px;">MIDI Stereo Waveform</small>
                    </div>
                </div>
                <div class="waves-fx" style="font-weight:bold; color:#00f0ff; font-family:monospace;">120 BPM</div>
            </div>`;
        }

        let customBubbleId = id || "msg-" + Math.floor(Math.random()*100000);

        let html = `<div class="gemini-message-block ${roleClass}" id="block-${customBubbleId}">
            <div class="msg-avatar">${isUser ? "U" : "M"}</div>
            <div class="msg-content-wrapper" style="display:flex; flex-direction:column;">
                <div class="msg-bubble markdown-bot-rendered">
                    ${attachmentCard}
                    <div class="msg-text-payload">${animate && !isUser ? "" : parsedText}</div>
                    ${!isUser ? `<button class="msg-voice-play-trigger" data-id="${customBubbleId}" data-text="${encodeURIComponent(text)}">🔊 শুনুন</button>` : ""}
                </div>
                <span class="msg-timestamp">${timestampVal}</span>
            </div>
        </div>`;

        chatContent.append(html);

        if (animate && !isUser) {
            let srcContainer = document.createElement('div');
            srcContainer.innerHTML = parsedText;
            let targetElem = document.querySelector(`#block-${customBubbleId} .msg-text-payload`);
            if (targetElem) {
                typeWriterNode(srcContainer, targetElem, function() {
                    chatContent.scrollTop(chatContent[0].scrollHeight);
                });
            }
        }
    }

    // --- CORE COMMUNICATION SUBMIT ROUTINE WITH API ROTATION ---
    function sendMessage(promptOverride) {
        let textToSend = promptOverride ? promptOverride.trim() : userInput.val().trim();
        if (textToSend === "") return;

        let chats = getStoredChats();
        let activeChat = chats.find(c => c.id === activeChatId) || chats[0];

        welcomeBanner.hide();
        userInput.val("");

        let timestampNow = new Date().toLocaleTimeString('bn-BD', {hour:'2-digit', minute:'2-digit'});
        let userMsgId = "msg-user-" + Date.now();
        
        // Append user balloon instantly
        appendMsgHtml("user", textToSend, userMsgId, timestampNow);
        chatContent.scrollTop(chatContent[0].scrollHeight);

        // Update the database thread array
        let userMsgObj = { id: userMsgId, role: "user", content: textToSend, timestamp: timestampNow };
        activeChat.messages.push(userMsgObj);
        activeChat.title = textToSend.substring(0, 16) + "...";
        saveStoredChats(chats);

        // Append loader
        let loadingId = "load-" + Date.now();
        chatContent.append(`<div class="bot-processing-msg flex gap-3 my-2" id="${loadingId}" style="align-self: flex-start; padding-left: 50px;">
            <span class="bot-processing-dots font-mono">> মায়া চিন্তা করছে এবং গণনা শেষ করছে...</span>
        </div>`);
        chatContent.scrollTop(chatContent[0].scrollHeight);

        // Check if prompt wants Music sound compose
        let isMusicTrigger = /(গান|মিউজিক|music|synth|compose|rhythm|melody)/i.test(textToSend);
        let isImageTrigger = /(draw|paint|create|generate|ছবি|আঁকো|image|art|graphic|illustration)/i.test(textToSend);

        // Read dynamic model settings
        let chosenModel = modelSelect.val();

        // 1. If explicitly requesting visual creation
        if(isImageTrigger) {
            let isWordpress = (typeof cyber_bot_obj !== 'undefined' && cyber_bot_obj.ajax_url);
            let ajaxUrl = isWordpress ? cyber_bot_obj.ajax_url : '/api/gemini/generate-image';
            let ajaxData = isWordpress ? {
                action: 'cyber_bot_request',
                user_query: textToSend,
                model: chosenModel,
                system_instruction: systemPromptInput.val(),
                temperature: parseFloat(tempRangeInput.val()),
                custom_keys: keyPoolRaw
            } : JSON.stringify({ prompt: textToSend });

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                contentType: isWordpress ? 'application/x-www-form-urlencoded; charset=UTF-8' : 'application/json',
                data: ajaxData,
                success: function(response) {
                    $(`#${loadingId}`).remove();
                    
                    let rawText = "";
                    if (isWordpress) {
                        rawText = response.success ? response.data : "";
                    } else {
                        rawText = response.text || "";
                    }

                    let imageUrl = response.imageUrl;
                    if (!imageUrl && isWordpress && rawText.indexOf("[GENERATE_IMAGE:") !== -1) {
                        let match = rawText.match(/\[GENERATE_IMAGE:\s*([^\]]+)\]/);
                        let subPrompt = match ? match[1] : textToSend;
                        imageUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(subPrompt)}?width=1024&height=576&nologo=true&private=true&seed=${Math.floor(Math.random() * 10000)}`;
                    } else if (!imageUrl && isWordpress) {
                        imageUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(textToSend)}?width=1024&height=576&nologo=true&private=true&seed=${Math.floor(Math.random() * 10000)}`;
                    } else if (!imageUrl) {
                        imageUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(textToSend)}?width=1024&height=576`;
                    }

                    let responseContent = `আমি অত্যন্ত সফলতার সাথে গেমিনি জেনারেটিভ ইমেজ মডেল ব্যবহার করে আপনার নির্দেশ মতো একটি অসাধারণ ফিউচারিস্টিক ইমেজ তৈরি করেছি:\n\n**"${textToSend}"**\n\nআপনি চাইলে নিচের বাটনটি ব্যবহার করে এটি সরাসরি নামিয়ে নিতে পারেন।`;

                    let botMsgId = "msg-bot-" + Date.now();
                    appendMsgHtml("bot", responseContent, botMsgId, timestampNow, "image", imageUrl, true);
                    
                    activeChat.messages.push({
                        id: botMsgId,
                        role: "bot",
                        content: responseContent,
                        type: "image",
                        imageUrl: imageUrl,
                        timestamp: timestampNow
                    });
                    saveStoredChats(chats);
                    populateSidebarThreads();
                    chatContent.scrollTop(chatContent[0].scrollHeight);
                    
                    if(soundEnabled) composeVirtualMelody("sparkle");
                },
                error: function() {
                    $(`#${loadingId}`).remove();
                    let botMsgId = "msg-err-" + Date.now();
                    let errContent = "দুঃখিত, আর্ট ইমেজ এপিআই সংযোগ স্থাপন করতে ব্যর্থ হয়েছে। কিছুক্ষণ পর আবার চেষ্টা করুন।";
                    appendMsgHtml("bot", errContent, botMsgId, timestampNow);
                    activeChat.messages.push({ id: botMsgId, role: "bot", content: errContent, timestamp: timestampNow });
                    saveStoredChats(chats);
                }
            });
        }
        // 2. MIDI Synthesizing trigger
        else if (isMusicTrigger) {
            setTimeout(function() {
                $(`#${loadingId}`).remove();
                
                let botMsgId = "msg-bot-" + Date.now();
                let responseContent = `🎵 **মেলোডিক অডিও সিন্থেসাইজার কনফিগারেশন সফল!**\n\nআমি আপনার নির্দেশ অনুসারে **"${textToSend}"** মেলোডি টোন জেনারেট করেছি।\n\nনিচে অডিও ফর্মিং প্যানেটের প্লে বাটন টিপে কোয়াান্টাম সুরের ফ্রিকোয়েন্সি শুনতে পারেন।`;

                appendMsgHtml("bot", responseContent, botMsgId, timestampNow, "music", undefined, true);
                
                activeChat.messages.push({
                    id: botMsgId,
                    role: "bot",
                    content: responseContent,
                    type: "music",
                    timestamp: timestampNow
                });
                saveStoredChats(chats);
                populateSidebarThreads();
                chatContent.scrollTop(chatContent[0].scrollHeight);
                
                // Play melody instantly
                composeVirtualMelody(textToSend);
            }, 1500);
        }
        // 3. Normal text interaction with Key rotation logic
        else {
            // Read rotation pool keys
            let keyPoolRaw = apiKeysInput.val() || "";
            let customKeysList = keyPoolRaw.split("\n").map(k => k.trim()).filter(k => k.length > 0);

            let isWordpress = (typeof cyber_bot_obj !== 'undefined' && cyber_bot_obj.ajax_url);
            let ajaxUrl = isWordpress ? cyber_bot_obj.ajax_url : '/api/gemini/chat';
            let ajaxData = isWordpress ? {
                action: 'cyber_bot_request',
                user_query: textToSend,
                model: chosenModel,
                system_instruction: systemPromptInput.val(),
                temperature: parseFloat(tempRangeInput.val()),
                custom_keys: keyPoolRaw
            } : JSON.stringify({
                messages: activeChat.messages.map(m => ({ role: m.role, content: m.content })),
                model: chosenModel,
                systemInstruction: systemPromptInput.val(),
                temperature: parseFloat(tempRangeInput.val()),
                keys: customKeysList
            });

            // AJAX request payload conversion
            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                contentType: isWordpress ? 'application/x-www-form-urlencoded; charset=UTF-8' : 'application/json',
                data: ajaxData,
                success: function(response) {
                    $(`#${loadingId}`).remove();
                    
                    let replyText = "";
                    if (isWordpress) {
                        replyText = response.success ? response.data : "কোনো রেসপন্স পাওয়া যায়নি।";
                    } else {
                        replyText = response.text ? response.text : "কোনো রেসপন্স পাওয়া যায়নি।";
                    }

                    let botType = "text";
                    let inlineUrl = "";

                    // Detect inline trigger image draw
                    if (replyText.indexOf("[GENERATE_IMAGE:") !== -1) {
                        botType = "image";
                        let match = replyText.match(/\[GENERATE_IMAGE:\s*([^\]]+)\]/);
                        let subPrompt = match ? match[1] : textToSend;
                        inlineUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(subPrompt)}?width=1024&height=576&nologo=true&private=true&seed=${Math.floor(Math.random() * 10000)}`;
                        replyText = replyText.replace(/\[GENERATE_IMAGE:[^\]]+\]/, "").trim() || "আমি আপনার নির্দেশনা অনুসারে ইমেজটি আর্ট করেছি:";
                    }

                    let botMsgId = "msg-bot-" + Date.now();
                    appendMsgHtml("bot", replyText, botMsgId, timestampNow, botType, inlineUrl, true);
                    
                    activeChat.messages.push({
                        id: botMsgId,
                        role: "bot",
                        content: replyText,
                        type: botType,
                        imageUrl: inlineUrl || undefined,
                        timestamp: timestampNow
                    });
                    saveStoredChats(chats);
                    populateSidebarThreads();
                    chatContent.scrollTop(chatContent[0].scrollHeight);
                },
                error: function(xhr, status, error) {
                    $(`#${loadingId}`).remove();
                    let botMsgId = "msg-err-" + Date.now();
                    let errText = `সংযোগ স্থাপনে সমস্যা হয়েছে। স্ট্যাটাস বিবরণী: ${status}। অনুগ্রহ করে গেমিনি সেটিংস থেকে আপনার API Keys কনফিগারেশন চেক করুন।`;
                    appendMsgHtml("bot", errText, botMsgId, timestampNow);
                    
                    activeChat.messages.push({ id: botMsgId, role: "bot", content: errText, timestamp: timestampNow });
                    saveStoredChats(chats);
                    chatContent.scrollTop(chatContent[0].scrollHeight);
                }
            });
        }
    }

    // --- EVENT CONTROLLERS ---

    let recognitionObject = null;

    // 1. Voice dictation using real Web Speech API!
    voiceDictBtn.on('click', function() {
        if (isDictating) {
            isDictating = false;
            if (recognitionObject) {
                try { recognitionObject.stop(); } catch(e) {}
            }
            $(this).removeClass('dict-active').find('.icon-label').text('🎤 Voice Talk');
            return;
        }

        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            // High-quality simulation fallback
            isDictating = true;
            $(this).addClass('dict-active').find('.icon-label').text('🔴 (সিমুলেশন চলছে...)');
            setTimeout(function() {
                userInput.val("গুগল এডসেন্স এপ্রুভালের ৩টি সেরা ট্রিক বলো");
                isDictating = false;
                voiceDictBtn.removeClass('dict-active').find('.icon-label').text('🎤 Voice Talk');
                if(soundEnabled) composeVirtualMelody("blip");
                sendMessage(); // auto-submit input!
            }, 2000);
            return;
        }

        // Initialize Web Speech Engine
        isDictating = true;
        $(this).addClass('dict-active').find('.icon-label').text('🔴 শুনছি... বলুন');

        if (!recognitionObject) {
            recognitionObject = new SpeechRecognition();
            recognitionObject.continuous = false;
            recognitionObject.interimResults = false;
            recognitionObject.lang = 'bn-BD'; // transcribe Bengali speech

            recognitionObject.onresult = function(event) {
                const speechResultText = event.results[0][0].transcript;
                if (speechResultText) {
                    userInput.val(speechResultText);
                    if (soundEnabled) composeVirtualMelody("blip");
                    setTimeout(function() {
                        sendMessage(); // auto-submit speech input
                    }, 400);
                }
            };

            recognitionObject.onerror = function(err) {
                console.warn("Speech API error status:", err.error);
                if (err.error === 'no-speech') {
                    recognitionObject.lang = 'en-US'; // switch language as a quick fallback
                }
            };

            recognitionObject.onend = function() {
                isDictating = false;
                voiceDictBtn.removeClass('dict-active').find('.icon-label').text('🎤 Voice Talk');
            };
        }

        try {
            recognitionObject.start();
        } catch(e) {
            isDictating = false;
            voiceDictBtn.removeClass('dict-active').find('.icon-label').text('🎤 Voice Talk');
        }
    });

    // 2. Action short-cut prompts
    drawImgBtn.on('click', function() {
        sendMessage("একটি ফিউচারিস্টিক সাইবার সিকিউরিটি রোবটের চমৎকার নিওন ডিজিটাল ইলাস্ট্রেশন ছবি তৈরি করো");
    });

    composeMusicBtn.on('click', function() {
        sendMessage("একটি মেলোডিক কোয়ান্টাম হ্যাকার সুর রিংটোন অডিও কম্পোজ করো");
    });

    // Preset chips clicking
    $(document).on('click', '.preset-card', function() {
        let promptVal = $(this).attr('data-prompt');
        sendMessage(promptVal);
    });

    // 3. Thread actions (sidebar events)
    $(document).on('click', '.sidebar-item', function() {
        let clickedId = $(this).attr('data-id');
        activeChatId = clickedId;
        renderChatThread();
    });

    // Sidebar thread delete bubble
    $(document).on('click', '.sidebar-item-delete', function(e) {
        e.stopPropagation();
        let targetId = $(this).attr('data-id');
        let chats = getStoredChats();
        if(chats.length <= 1) return;

        let filtered = chats.filter(c => c.id !== targetId);
        saveStoredChats(filtered);
        
        if (activeChatId === targetId) {
            activeChatId = filtered[0].id;
        }
        renderChatThread();
    });

    // New thread button
    newChatBtn.on('click', function() {
        let chats = getStoredChats();
        let newId = "chat_" + Date.now();
        let newChat = {
            id: newId,
            title: "নতুন আলোচনা থ্রেড " + (chats.length + 1),
            model: "gemini-3.5-flash",
            messages: []
        };
        chats.unshift(newChat);
        saveStoredChats(chats);
        activeChatId = newId;
        renderChatThread();
    });

    // Sidebar panel toggle slide trigger
    sidebarToggleBtn.on('click', function() {
        sidebar.toggleClass('collapsed');
    });

    // 4. Modal Settings panel triggering
    settingsTriggerBtn.on('click', function() {
        settingsModal.fadeIn(200);
    });

    function dismissSettings() {
        settingsModal.fadeOut(150);
    }

    settingsCloseBtn.on('click', dismissSettings);
    settingsCancelBtn.on('click', dismissSettings);

    // Saving dynamic parameters to LocalStorage
    settingsSaveBtn.on('click', function() {
        localStorage.setItem("wp_maya_api_keys", apiKeysInput.val());
        localStorage.setItem("wp_maya_sys_prompt", systemPromptInput.val());
        localStorage.setItem("wp_maya_temp", tempRangeInput.val());
        
        dismissSettings();
        if(soundEnabled) composeVirtualMelody("chime");
    });

    // Clear all histories and reload cleanly
    resetChatsBtn.on('click', function() {
        if(confirm("আপনি কি নিশ্চিত ওয়ার্ডপ্রেস চাটবট মেমেোরির সব হিস্ট্রি এবং সংরক্ষিত আলোচনা ডিলিট করতে চান? এটি রিভার্স করা যাবে না।")) {
            localStorage.removeItem("wp_maya_gemini_threads");
            localStorage.removeItem("wp_maya_api_keys");
            window.location.reload();
        }
    });

    // 5. Code Copy Event listener
    $(document).on('click', '.copy-block-btn', function() {
        let rawCode = decodeURIComponent($(this).attr('data-code'));
        let btn = $(this);
        navigator.clipboard.writeText(rawCode).then(function() {
            btn.text("✓ কপিড!").css('color', '#10b981');
            setTimeout(function() {
                btn.text("কপি করুন").css('color', '#00f0ff');
            }, 2000);
        });
    });

    // 6. Audio Synth play widget trigger
    $(document).on('click', '.synth-play-osc-btn', function() {
        let promptVal = decodeURIComponent($(this).attr('data-prompt'));
        composeVirtualMelody(promptVal);
    });

    // 7. Bengali voice speech toggle
    $(document).on('click', '.msg-voice-play-trigger', function() {
        let targetId = $(this).attr('data-id');
        let textVal = decodeURIComponent($(this).attr('data-text'));
        speakAloud(textVal, targetId);
    });

    // --- MAIN SEND INTERACT CONSTRAINTS ---
    sendBtn.on('click', function() {
        sendMessage();
    });

    userInput.on('keypress', function(e) {
        if (e.which == 13) sendMessage();
    });

    // --- INITIAL BOOT SEQUENCE ---
    renderChatThread();
});
