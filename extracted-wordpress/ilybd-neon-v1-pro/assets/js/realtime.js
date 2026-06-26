jQuery(document).ready(function($){

    let lastCount = 0;

    /* =========================
       POLLING ENGINE
    ========================= */
    function checkNotifications(){

        $.post(ilybd_ajax.ajaxurl, {
            action: 'ilybd_get_notifications'
        }, function(res){

            if(!res.success) return;

            let data = res.data;

            if(!data || !data.count) return;

            /* FIRST LOAD (no sound) */
            if(lastCount === 0){
                lastCount = data.count;
                return;
            }

            /* NEW NOTIFICATION DETECTED */
            if(data.count > lastCount){
                let newItems = data.items;
                let shownNotifications = JSON.parse(localStorage.getItem('ilybd_shown_notifs') || '[]');
                let playedNew = false;

                newItems.forEach(function(n){
                    if (!n.read && !shownNotifications.includes(n.id)) {
                        showRealtimeNotification(n.text || n.message, n.link);
                        shownNotifications.push(n.id);
                        playedNew = true;
                    }
                });

                localStorage.setItem('ilybd_shown_notifs', JSON.stringify(shownNotifications));

                if (playedNew) {
                    playNotiSound();
                }
            }

            // Sync badges across the page
            let badgeEl = $('.nav-link .badge, .badge');
            if (data.count > 0) {
                badgeEl.text(data.count).show();
                let tabBadge = $('#db-notif-badge');
                if (tabBadge.length) {
                    tabBadge.text(data.count).show();
                }
            } else {
                badgeEl.hide();
                $('#db-notif-badge').hide();
            }

            lastCount = data.count;

        });

    }

    /* =========================
       RUN EVERY 5s
    ========================= */
    setInterval(checkNotifications, 5000);


    /* =========================
       UI NOTIFICATION
    ========================= */
    function showRealtimeNotification(msg, link){

        let box = $('#noti-box');
        if(!box.length) return;

        let cursorStyle = link ? 'cursor:pointer;' : '';
        let item = $(`
            <div class="noti-item" style="
                background: #090e1a;
                color: #00ff99;
                padding: 12px 18px;
                margin-top: 8px;
                border: 1.5px solid #00f0ff;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0,240,255,0.3);
                font-size: 13px;
                font-family: sans-serif;
                font-weight: bold;
                line-height: 1.4;
                transition: transform 0.2s;
                ${cursorStyle}
            " onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                🔔 ${msg}
                ${link ? '<div style="font-size:11px; color:#00f0ff; margin-top:5px; text-decoration:underline; font-weight: normal;"><i class="fa-solid fa-arrow-up-right-from-square"></i> নির্দিষ্ট পেজে যেতে ক্লিক করুন (View Content)</div>' : ''}
            </div>
        `);

        if (link) {
            item.on('click', function() {
                window.location.href = link;
            });
        }

        box.append(item);

        setTimeout(function(){
            item.fadeOut(400, function(){
                $(this).remove();
            });
        }, 6000);
    }

    /* =========================
       🔔 FUTURISTIC CYBER BELL SOUND WITH AUTO-UNLOCK
       ========================= */
    let globalAudioCtx = null;
    function initGlobalAudioContext() {
        if (!globalAudioCtx) {
            var AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (AudioContextClass) {
                globalAudioCtx = new AudioContextClass();
            }
        }
        if (globalAudioCtx && globalAudioCtx.state === 'suspended') {
            globalAudioCtx.resume();
        }
    }

    // Auto-unlock AudioContext on first user interaction
    $(document).on('click touchstart keydown mousemove', function() {
        initGlobalAudioContext();
    });

    window.playNotiSound = function() {
        try {
            initGlobalAudioContext();
            var ctx = globalAudioCtx;
            if (!ctx) {
                var AudioContextClass = window.AudioContext || window.webkitAudioContext;
                ctx = new AudioContextClass();
            }
            if (ctx.state === 'suspended') {
                ctx.resume();
            }
            
            // Double-chime futuristic sci-fi synth bell
            var playTone = function(freq, delay, duration, gainVal) {
                var osc = ctx.createOscillator();
                var gain = ctx.createGain();
                
                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, ctx.currentTime + delay);
                
                // Exponential decay for frequency & gain to simulate real physical resonance/cyber delay
                osc.frequency.exponentialRampToValueAtTime(freq * 0.5, ctx.currentTime + delay + duration);
                
                gain.gain.setValueAtTime(0, ctx.currentTime + delay);
                gain.gain.linearRampToValueAtTime(gainVal, ctx.currentTime + delay + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + delay + duration);
                
                osc.connect(gain);
                gain.connect(ctx.destination);
                
                osc.start(ctx.currentTime + delay);
                osc.stop(ctx.currentTime + delay + duration);
            };
            
            // Neon star chimes: high pitch double-strike (C6, then E6 slightly after)
            playTone(1046.50, 0, 0.4, 0.25);
            playTone(1318.51, 0.08, 0.5, 0.2);
        } catch(e) {
            console.log("Audio play error (requires user interaction first): ", e);
        }
    };

});


