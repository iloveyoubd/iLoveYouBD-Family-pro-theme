document.addEventListener('DOMContentLoaded', function() {
    const displayPro = document.getElementById('cat-display-pro');
    const startOverlay = document.getElementById('start-overlay');
    const initBtn = document.getElementById('init-btn');
    const powerBtn = document.getElementById('power-btn');
    const indicator = document.getElementById('voice-indicator');

    // থিম পাথ অটোমেটিক সেট করা
    const themePath = (typeof cyberGameData !== 'undefined') ? cyberGameData.theme_url : '';
    const sfxPath = themePath + '/assets/cyber-game/sounds/';

    let audioCtx, analyser, microphone, scriptProcessor, mediaRecorder, stream;
    let chunks = [];
    let silenceStart = Date.now();
    let isRecording = false;
    let isSystemActive = false;
    let isInteractionPlaying = false;

    // সাউন্ড লোড করার স্মার্ট ফাংশন
    function playSFX(file) {
        try {
            const audio = new Audio(sfxPath + file);
            audio.play().catch(e => console.log("Sound file missing: " + file));
        } catch (e) { console.log("Audio Error"); }
    }

    initBtn.addEventListener('click', startSystem);
    powerBtn.addEventListener('click', stopSystem);

    async function startSystem() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            initAudioEngine(stream);
            isSystemActive = true;
            startOverlay.style.display = 'none';
            setCatState('idle');
            console.log("System Started");
        } catch (err) {
            alert("মাইক্রোফোন পারমিশন দিন নাহলে গেমটি চলবে না!");
        }
    }

    function initAudioEngine(stream) {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        analyser = audioCtx.createAnalyser();
        microphone = audioCtx.createMediaStreamSource(stream);
        scriptProcessor = audioCtx.createScriptProcessor(2048, 1, 1);
        analyser.fftSize = 256;
        microphone.connect(analyser);
        analyser.connect(scriptProcessor);
        scriptProcessor.connect(audioCtx.destination);

        mediaRecorder = new MediaRecorder(stream);
        mediaRecorder.ondataavailable = e => chunks.push(e.data);
        mediaRecorder.onstop = processAndSpeak;
        scriptProcessor.onaudioprocess = monitorVoice;
    }

    function monitorVoice() {
        if (!isSystemActive || isInteractionPlaying) return;
        const array = new Uint8Array(analyser.frequencyBinCount);
        analyser.getByteFrequencyData(array);
        let vol = array.reduce((a, b) => a + b) / array.length;

        if (vol > 10) { 
            indicator.style.opacity = "1";
            if (!isRecording) {
                isRecording = true;
                chunks = [];
                mediaRecorder.start();
                setCatState('talking');
            }
            silenceStart = Date.now();
        } else {
            indicator.style.opacity = "0";
            if (isRecording && (Date.now() - silenceStart > 1300)) {
                isRecording = false;
                mediaRecorder.stop();
            }
        }
    }

    async function processAndSpeak() {
        if (chunks.length === 0) { setCatState('idle'); return; }
        const blob = new Blob(chunks, { type: 'audio/ogg; codecs=opus' });
        const url = window.URL.createObjectURL(blob);
        const audio = new Audio(url);
        audio.playbackRate = 1.7; 
        audio.preservesPitch = false;
        
        audio.onplay = () => setCatState('talking');
        audio.onended = () => { setCatState('idle'); chunks = []; };
        audio.play();
    }

    function stopSystem() {
        isSystemActive = false;
        if (stream) stream.getTracks().forEach(track => track.stop());
        if (audioCtx) audioCtx.close();
        startOverlay.style.display = 'flex';
        setCatState('idle');
    }

    // টাচ ইন্টারঅ্যাকশন
    displayPro.addEventListener('click', function(e) {
        if (!isSystemActive || isInteractionPlaying) return;
        
        const rect = displayPro.getBoundingClientRect();
        const y = (e.clientY - rect.top) / rect.height;

        isInteractionPlaying = true;
        if (y < 0.3) {
            setCatState('hit');
            playSFX('hit.mp3');
        } else if (y > 0.7) {
            setCatState('faint');
            playSFX('faint.mp3');
        } else {
            setCatState('laughing');
            playSFX('tickle.mp3');
        }

        setTimeout(() => {
            setCatState('idle');
            isInteractionPlaying = false;
        }, 2000);
    });

    function setCatState(state) {
        displayPro.className = 'state-' + state;
    }
});
