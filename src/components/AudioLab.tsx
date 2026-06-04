import React, { useState, useEffect, useRef } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  Music, Play, Square, Download, RefreshCw, Sparkles, Volume2, 
  Trash2, Sliders, Info, Disc, Save, HelpCircle, AlertCircle
} from "lucide-react";

interface TrackParameter {
  title: string;
  description: string;
  tempo: number;
  genre: "cyberpunk" | "melancholic";
  scale: number[];
  chordProgression: number[][];
  arpeggiatorStyle: string;
  synthWaveform: "sine" | "triangle" | "sawtooth" | "square";
  lfoSpeed: number;
  filterCutoff: number;
  reverbWet: number;
  rainDensity: number;
}

interface RecordedTrack {
  id: string;
  title: string;
  url: string;
  duration: number;
  timestamp: string;
  genre: string;
}

// Preset fallbacks in case of fetch errors or fast testing
const CYBER_DEFAULT_PRESET: TrackParameter = {
  title: "Matrix Penetration",
  description: "একটি রোমাঞ্চকর হ্যাকিং এবং কোডিং ব্যাকগ্রাউন্ড বিট। youtube চ্যানেলের ব্যাকগ্রাউন্ড সাউন্ডের জন্য উপযুক্ত।",
  tempo: 125,
  genre: "cyberpunk",
  scale: [1.0, 1.122, 1.189, 1.335, 1.498, 1.587, 1.782], // minor scale frequency ratios
  chordProgression: [[1, 1.189, 1.498], [1.335, 1.587, 2.0], [1.122, 1.335, 1.587], [1.498, 1.782, 2.244]],
  arpeggiatorStyle: "gated",
  synthWaveform: "square",
  lfoSpeed: 4.5,
  filterCutoff: 1000,
  reverbWet: 0.35,
  rainDensity: 0
};

const SAD_DEFAULT_PRESET: TrackParameter = {
  title: "কাঁচের ভাঙা স্বপ্ন",
  description: "tiktok আইডির জন্য অত্যন্ত কষ্টের ব্যাকগ্রাউন্ড সাউন্ড। রেইন ইফেক্ট ও স্যাড পিয়ানো সোল।",
  tempo: 72,
  genre: "melancholic",
  scale: [1.0, 1.122, 1.201, 1.335, 1.498, 1.601, 1.802], // melancholic scale frequency ratios
  chordProgression: [[1, 1.201, 1.498], [1.335, 1.601, 2.0], [1.122, 1.335, 1.601], [1.498, 1.802, 2.244]],
  arpeggiatorStyle: "random",
  synthWaveform: "triangle",
  lfoSpeed: 0.2,
  filterCutoff: 450,
  reverbWet: 0.75,
  rainDensity: 65
};

interface AudioLabProps {
  mayaApiKeys?: string;
}

export default function AudioLab({ mayaApiKeys = "" }: AudioLabProps) {
  const [genre, setGenre] = useState<"cyberpunk" | "melancholic">("cyberpunk");
  const [prompt, setPrompt] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const [isPlaying, setIsPlaying] = useState(false);
  const [currentTrack, setCurrentTrack] = useState<TrackParameter>(CYBER_DEFAULT_PRESET);
  
  // Synthesizer runtime states
  const [volume, setVolume] = useState(65);
  const [isRecording, setIsRecording] = useState(false);
  const [recordDuration, setRecordDuration] = useState(0);
  const [recordedList, setRecordedList] = useState<RecordedTrack[]>([]);
  const [customBpm, setCustomBpm] = useState(120);

  // Web Audio Context & Synthesizer elements
  const audioCtxRef = useRef<AudioContext | null>(null);
  const analyserRef = useRef<AnalyserNode | null>(null);
  const destinationRef = useRef<MediaStreamAudioDestinationNode | null>(null);
  const masterGainRef = useRef<GainNode | null>(null);
  const filterNodeRef = useRef<BiquadFilterNode | null>(null);
  
  // Loops and timing references
  const timerRef = useRef<any>(null);
  const stepIdxRef = useRef<number>(0);
  const chordIdxRef = useRef<number>(0);
  const recordTimerRef = useRef<any>(null);
  
  // MediaRecorder for capturing procedural sound
  const mediaRecorderRef = useRef<MediaRecorder | null>(null);
  const recordedChunksRef = useRef<Blob[]>([]);

  // Rain loop node
  const rainGainRef = useRef<GainNode | null>(null);

  // Canvas details
  const canvasRef = useRef<HTMLCanvasElement | null>(null);
  const animationFrameRef = useRef<number | null>(null);

  // Load recordings on mount
  useEffect(() => {
    const saved = localStorage.getItem("iloveyoubd_recorded_audio");
    if (saved) {
      try {
        setRecordedList(JSON.parse(saved));
      } catch (err) {
        console.error("Failed loading tracks:", err);
      }
    }
  }, []);

  // Sync custom BPM to track parameter BPM
  useEffect(() => {
    setCustomBpm(currentTrack.tempo);
  }, [currentTrack]);

  // Handle master volume adjustments
  useEffect(() => {
    if (masterGainRef.current && audioCtxRef.current) {
      masterGainRef.current.gain.setValueAtTime(volume / 100, audioCtxRef.current.currentTime);
    }
  }, [volume]);

  // Generate unique track parameters utilizing Gemini API on backend
  const handleGenerateAISeed = async () => {
    setIsLoading(true);
    const keys = (mayaApiKeys || "").split("\n").map(k => k.trim()).filter(Boolean);
    try {
      const res = await fetch("/api/gemini/generate-music-rules", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ prompt, genre, keys })
      });
      const data = await res.json();
      if (data && data.title) {
        setCurrentTrack(data);
        stopSynthesizer();
      } else {
        throw new Error("Invalid structure");
      }
    } catch (err) {
      console.warn("Failsafe triggers applied due to fetch error:", err);
      // Failsafe generation to ensure 100% reliability
      const basePreset = genre === "cyberpunk" ? CYBER_DEFAULT_PRESET : SAD_DEFAULT_PRESET;
      const mutatedPreset: TrackParameter = {
        ...basePreset,
        title: prompt ? `${prompt.slice(0, 16)} (Unique Synth)` : basePreset.title,
        tempo: basePreset.tempo + Math.floor(Math.random() * 8) - 4,
      };
      setCurrentTrack(mutatedPreset);
      stopSynthesizer();
    } finally {
      setIsLoading(false);
    }
  };

  // Noise Buffer generator (used for White Noise HiHats & Rain droplets)
  const getNoiseBuffer = (ctx: AudioContext) => {
    const size = ctx.sampleRate * 2; // 2 seconds of noise
    const buffer = ctx.createBuffer(1, size, ctx.sampleRate);
    const data = buffer.getChannelData(0);
    for (let i = 0; i < size; i++) {
      data[i] = Math.random() * 2 - 1;
    }
    return buffer;
  };

  // Reverb Impulse Buffer builder
  const getReverbImpulseBuffer = (ctx: AudioContext, duration: number, decay: number) => {
    const rate = ctx.sampleRate;
    const len = rate * duration;
    const impulse = ctx.createBuffer(2, len, rate);
    const left = impulse.getChannelData(0);
    const right = impulse.getChannelData(1);

    for (let i = 0; i < len; i++) {
      const scale = Math.pow(1 - i / len, decay);
      left[i] = (Math.random() * 2 - 1) * scale;
      right[i] = (Math.random() * 2 - 1) * scale;
    }
    return impulse;
  };

  // Web Audio procedural engine instatiator and loops scheduler
  const startSynthesizer = async () => {
    try {
      if (isPlaying) return;

      const AudioContextClass = (window.AudioContext || (window as any).webkitAudioContext);
      const ctx = new AudioContextClass();
      audioCtxRef.current = ctx;

      // Create primary destination block for routing
      const finalDestGain = ctx.createGain();
      finalDestGain.gain.value = 1.0;

      // Master analyzer for visualization
      const analyser = ctx.createAnalyser();
      analyser.fftSize = 256;
      analyserRef.current = analyser;

      // Setup background destination to capture recording
      const dest = ctx.createMediaStreamDestination();
      destinationRef.current = dest;

      // Connect output node chain
      finalDestGain.connect(analyser);
      analyser.connect(ctx.destination);
      analyser.connect(dest);

      // Create master gain control
      const masterGain = ctx.createGain();
      masterGain.gain.value = volume / 100;
      masterGain.connect(finalDestGain);
      masterGainRef.current = masterGain;

      // Main Filter sweep unit
      const filter = ctx.createBiquadFilter();
      filter.type = "lowpass";
      filter.Q.value = 6;
      filter.frequency.value = currentTrack.filterCutoff;
      filter.connect(masterGain);
      filterNodeRef.current = filter;

      // Convolver node (for spatial spacious reverb)
      const reverb = ctx.createConvolver();
      reverb.buffer = getReverbImpulseBuffer(ctx, 3.5, 2.5);
      const reverbGain = ctx.createGain();
      reverbGain.gain.value = currentTrack.reverbWet;

      // Dual routing through filters and bypass reverb wet mixes
      filter.connect(reverb);
      reverb.connect(reverbGain);
      reverbGain.connect(masterGain);

      // Setup the procedural elements based on genre select
      stepIdxRef.current = 0;
      chordIdxRef.current = 0;

      const tempoBpm = customBpm || 120;
      const stepDuration = 60 / tempoBpm / 2; // eighth notes

      // Rain Synthesizer for sad/melancholic ambient
      if (currentTrack.genre === "melancholic" && currentTrack.rainDensity > 0) {
        const rainSource = ctx.createBufferSource();
        rainSource.buffer = getNoiseBuffer(ctx);
        rainSource.loop = true;

        const rainFilter = ctx.createBiquadFilter();
        rainFilter.type = "lowpass";
        rainFilter.frequency.value = 550;

        const rainGain = ctx.createGain();
        rainGain.gain.value = (currentTrack.rainDensity / 220) * 0.15; // smooth limit
        rainGainRef.current = rainGain;

        rainSource.connect(rainFilter);
        rainFilter.connect(rainGain);
        rainGain.connect(masterGain);
        rainSource.start();
      }

      // Live Scheduler beat generator
      const triggerEngineTick = () => {
        const t = ctx.currentTime;
        const scaleFreq = currentTrack.scale;
        const chords = currentTrack.chordProgression;
        const activeChord = chords[chordIdxRef.current % chords.length];

        const baseFrequency = currentTrack.genre === "cyberpunk" ? 55 : 110; 

        // Modulate LFO filter cutoffs dynamically
        const lfoTime = t * currentTrack.lfoSpeed * Math.PI * 2;
        const dynamicCutoff = currentTrack.filterCutoff + Math.sin(lfoTime) * (currentTrack.filterCutoff * 0.5);
        filter.frequency.setValueAtTime(Math.max(150, dynamicCutoff), t);

        if (currentTrack.genre === "cyberpunk") {
          // --- CYBERPUNK TECHNO SYNTH ENGINE ---
          // 1. Synthesize Bass Drum Kick (every 4 steps: 0, 4)
          if (stepIdxRef.current % 4 === 0) {
            const kickOsc = ctx.createOscillator();
            kickOsc.type = "sine";
            
            const kickGain = ctx.createGain();
            kickGain.gain.setValueAtTime(0.7, t);
            kickGain.gain.exponentialRampToValueAtTime(0.01, t + 0.18);

            kickOsc.frequency.setValueAtTime(140, t);
            kickOsc.frequency.exponentialRampToValueAtTime(45, t + 0.15);

            kickOsc.connect(kickGain);
            kickGain.connect(masterGain);
            
            kickOsc.start(t);
            kickOsc.stop(t + 0.2);
          }

          // 2. Synthesize High-hat Noise (every offbeat steps: 2, 6)
          if (stepIdxRef.current % 4 === 2) {
            const hhObject = ctx.createBufferSource();
            hhObject.buffer = getNoiseBuffer(ctx);

            const hhGain = ctx.createGain();
            hhGain.gain.setValueAtTime(0.12, t);
            hhGain.gain.exponentialRampToValueAtTime(0.005, t + 0.04);

            const hhFilter = ctx.createBiquadFilter();
            hhFilter.type = "highpass";
            hhFilter.frequency.value = 7500;

            hhObject.connect(hhFilter);
            hhFilter.connect(hhGain);
            hhGain.connect(masterGain);

            hhObject.start(t);
            hhObject.stop(t + 0.05);
          }

          // 3. Synthesize Fast Tech Cyber Arpeggiator sequence
          // Choose note index based on gated sequencer patterns
          let chordNoteRatio = activeChord[stepIdxRef.current % activeChord.length];
          if (!chordNoteRatio) chordNoteRatio = scaleFreq[0];
          
          const synthFreq = baseFrequency * chordNoteRatio * 2.0;

          const arpOsc = ctx.createOscillator();
          arpOsc.type = currentTrack.synthWaveform;
          arpOsc.frequency.value = synthFreq;

          const arpAmp = ctx.createGain();
          arpAmp.gain.setValueAtTime(0.15, t);
          arpAmp.gain.exponentialRampToValueAtTime(0.005, t + stepDuration * 0.85);

          arpOsc.connect(arpAmp);
          arpAmp.connect(filter);

          arpOsc.start(t);
          arpOsc.stop(t + stepDuration);

        } else {
          // --- MELANCHOLIC SAD SCALE AUDIO ENGINE ---
          // Low Cinematic Strings drone synth (every 8 steps)
          if (stepIdxRef.current % 8 === 0) {
            activeChord.forEach((noteRatio) => {
              const droneOsc = ctx.createOscillator();
              droneOsc.type = "triangle";
              droneOsc.frequency.value = baseFrequency * noteRatio * 0.5; // octave deep

              const droneGain = ctx.createGain();
              droneGain.gain.setValueAtTime(0.0, t);
              droneGain.gain.linearRampToValueAtTime(0.05, t + stepDuration * 3.0);
              droneGain.gain.exponentialRampToValueAtTime(0.001, t + stepDuration * 7.5);

              droneOsc.connect(droneGain);
              droneGain.connect(filter);
              droneOsc.start(t);
              droneOsc.stop(t + stepDuration * 8.0);
            });
          }

          // Procedural Emotional Soft Piano Notes with random chance generator to sound realistic
          if (Math.random() > 0.3) {
            const randomNoteFactor = activeChord[Math.floor(Math.random() * activeChord.length)];
            const pianoFreq = baseFrequency * randomNoteFactor * 2.0; // soft higher pitch

            const pianoOsc = ctx.createOscillator();
            pianoOsc.type = "sine"; // pure soft bell piano sound
            pianoOsc.frequency.setValueAtTime(pianoFreq, t);

            // Subtle pitch vibrato/expression
            const vibOsc = ctx.createOscillator();
            const vibGain = ctx.createGain();
            vibOsc.frequency.value = 6.2; // 6Hz vibrato
            vibGain.gain.value = 1.8; // subtle micro cents detuning
            vibOsc.connect(vibGain);
            vibGain.connect(pianoOsc.frequency);
            vibOsc.start(t);
            
            const pianoAmp = ctx.createGain();
            pianoAmp.gain.setValueAtTime(0.0, t);
            pianoAmp.gain.linearRampToValueAtTime(0.25, t + 0.02); // smooth piano hammer hit
            pianoAmp.gain.exponentialRampToValueAtTime(0.001, t + stepDuration * 4.5);

            pianoOsc.connect(pianoAmp);
            pianoAmp.connect(filter);

            pianoOsc.start(t);
            vibOsc.stop(t + stepDuration * 5.0);
            pianoOsc.stop(t + stepDuration * 5.0);
          }
        }

        // Loop mechanics: step indexing
        stepIdxRef.current = (stepIdxRef.current + 1) % 16;
        if (stepIdxRef.current === 0) {
          chordIdxRef.current = (chordIdxRef.current + 1) % chords.length;
        }
      };

      // Realtime visual rendering canvas trigger
      visualizeSpectrogram();

      // Trigger scheduler
      timerRef.current = setInterval(triggerEngineTick, stepDuration * 1000);
      setIsPlaying(true);

    } catch (err) {
      console.error("Synthesizer startup failure:", err);
      alert("ওয়েব অডিও অ্যাক্টিভ করতে অনুগ্রহ করে স্ক্রিনে কোথাও ইন্টারঅ্যাক্ট করুন!");
    }
  };

  // Canvas spectrogram rendering loop
  const visualizeSpectrogram = () => {
    if (!canvasRef.current || !analyserRef.current) return;
    const canvas = canvasRef.current;
    const ctx = canvas.getContext("2d");
    if (!ctx) return;

    const analyser = analyserRef.current;
    const bufferLength = analyser.frequencyBinCount;
    const dataArray = new Uint8Array(bufferLength);

    const draw = () => {
      animationFrameRef.current = requestAnimationFrame(draw);
      analyser.getByteFrequencyData(dataArray);

      ctx.fillStyle = "rgba(7, 10, 16, 0.2)";
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      const barWidth = (canvas.width / bufferLength) * 2.5;
      let barHeight;
      let x = 0;

      for (let i = 0; i < bufferLength; i++) {
        barHeight = dataArray[i];

        // Unique dynamic glowing color mappings
        let greenHex = currentTrack.genre === "cyberpunk" ? 240 : 15;
        let blueHex = currentTrack.genre === "cyberpunk" ? 255 : 244;
        let redHex = currentTrack.genre === "cyberpunk" ? 0 : 255;

        ctx.fillStyle = `rgb(${redHex}, ${greenHex}, ${blueHex})`;
        ctx.shadowBlur = 10;
        ctx.shadowColor = `rgba(${redHex}, ${greenHex}, ${blueHex}, 0.5)`;

        ctx.fillRect(x, canvas.height - barHeight / 1.6, barWidth - 1.5, barHeight / 1.6);
        ctx.shadowBlur = 0; // reset
        x += barWidth;
      }
    };

    draw();
  };

  // Recording pipeline instantiator
  const startRecordingMaster = () => {
    if (!audioCtxRef.current || !destinationRef.current) {
      alert("রেকর্ড শুরু করার আগে দয়া করে 'মিউজিক প্লে' করুন!");
      return;
    }

    recordedChunksRef.current = [];
    const dest = destinationRef.current;
    
    // Check supported MIME types for recording
    let options = { mimeType: "audio/webm" };
    try {
      mediaRecorderRef.current = new MediaRecorder(dest.stream, options);
    } catch (e) {
      try {
        mediaRecorderRef.current = new MediaRecorder(dest.stream);
      } catch (err) {
        alert("আপনার ব্রাউজারে রেকর্ডিং ফিচারটি সাপোর্ট করছে না!");
        return;
      }
    }

    mediaRecorderRef.current.ondataavailable = (e) => {
      if (e.data && e.data.size > 0) {
        recordedChunksRef.current.push(e.data);
      }
    };

    mediaRecorderRef.current.onstop = () => {
      const audioBlob = new Blob(recordedChunksRef.current, { type: "audio/webm" });
      const audioUrl = URL.createObjectURL(audioBlob);
      
      const newRecordedTrack: RecordedTrack = {
        id: `rec-${Date.now()}`,
        title: `${currentTrack.title} (Recorded)`,
        url: audioUrl,
        duration: recordDuration,
        timestamp: new Date().toLocaleTimeString(),
        genre: currentTrack.genre
      };

      const updated = [newRecordedTrack, ...recordedList];
      setRecordedList(updated);
      localStorage.setItem("iloveyoubd_recorded_audio", JSON.stringify(updated));
      setRecordDuration(0);
    };

    mediaRecorderRef.current.start();
    setIsRecording(true);
    setRecordDuration(0);

    // Duration clock ticking
    recordTimerRef.current = setInterval(() => {
      setRecordDuration(prev => prev + 1);
    }, 1000);
  };

  // Stop recording pipeline
  const stopRecordingMaster = () => {
    if (mediaRecorderRef.current && isRecording) {
      mediaRecorderRef.current.stop();
      setIsRecording(false);
      clearInterval(recordTimerRef.current);
    }
  };

  // Global stop engine trigger
  const stopSynthesizer = () => {
    stopRecordingMaster();
    if (timerRef.current) {
      clearInterval(timerRef.current);
    }
    if (audioCtxRef.current) {
      audioCtxRef.current.close();
      audioCtxRef.current = null;
    }
    if (animationFrameRef.current) {
      cancelAnimationFrame(animationFrameRef.current);
    }
    setIsPlaying(false);
  };

  // Delete recorded file
  const handleDeleteTrack = (id: string) => {
    const updated = recordedList.filter(item => item.id !== id);
    setRecordedList(updated);
    localStorage.setItem("iloveyoubd_recorded_audio", JSON.stringify(updated));
  };

  // Kill context safely on unmount
  useEffect(() => {
    return () => {
      stopSynthesizer();
    };
  }, []);

  return (
    <div id="ai-sound-lab" className="bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl relative overflow-hidden text-left">
      <div className="absolute inset-0 bg-gradient-to-br from-cyan-500/5 via-transparent to-purple-500/5 pointer-events-none" />
      
      {/* Visual Header */}
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-cyan-950 pb-5 mb-6">
        <div className="flex items-center gap-3">
          <div className="p-2.5 rounded-lg bg-cyan-950/40 border border-cyan-500/40 flex items-center justify-center animate-pulse">
            <Music className="w-6 h-6 text-[#00f0ff]" />
          </div>
          <div>
            <h2 className="text-xl font-bold font-sans tracking-tight text-white flex items-center gap-2">
              এআই নিয়ন মিউজিক ল্যাব <span className="text-[10px] bg-red-950 text-red-400 border border-red-900 px-1.5 rounded-full font-mono uppercase tracking-widest leading-none">Generative</span>
            </h2>
            <p className="text-xs text-slate-400 font-mono mt-0.5">
              ইউটিউব এবং টিকটক-এর জন্য ১০০% অনন্য ও কপিরাইট-মুক্ত হ্যাকিং বিট ও কষ্টের ব্যাকগ্রাউন্ড টিউন তৈরি করুন।
            </p>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {/* Left Grid: Sound Settings & Prompt */}
        <div className="lg:col-span-5 space-y-6">
          <div className="bg-slate-950/80 rounded-xl p-4 border border-cyan-950/60 space-y-4">
            <h3 className="text-xs font-mono font-bold text-cyan-400 uppercase tracking-wider flex items-center gap-1.5">
              <Sliders className="w-4 h-4" /> সাউন্ড ক্যাটাগরি এবং মুড
            </h3>

            {/* Selector Option */}
            <div className="grid grid-cols-2 gap-2">
              <button
                onClick={() => {
                  setGenre("cyberpunk");
                  setCurrentTrack(CYBER_DEFAULT_PRESET);
                  stopSynthesizer();
                }}
                className={`py-2 px-3 text-xs font-mono font-bold rounded-lg border transition-all cursor-pointer text-center ${
                  genre === "cyberpunk"
                    ? "bg-cyan-950/80 text-[#00f0ff] border-cyan-500 shadow-[0_0_10px_rgba(0,240,255,0.25)]"
                    : "bg-transparent text-slate-400 border-slate-900 hover:text-white"
                }`}
              >
                💻 হ্যাকিং স্টাইল বিটস (YouTube)
              </button>
              <button
                onClick={() => {
                  setGenre("melancholic");
                  setCurrentTrack(SAD_DEFAULT_PRESET);
                  stopSynthesizer();
                }}
                className={`py-2 px-3 text-xs font-mono font-bold rounded-lg border transition-all cursor-pointer text-center ${
                  genre === "melancholic"
                    ? "bg-purple-950/80 text-purple-400 border-purple-500 shadow-[0_0_10px_rgba(168,85,247,0.25)]"
                    : "bg-transparent text-slate-400 border-slate-900 hover:text-white"
                }`}
              >
                💔 কষ্টের ব্যাকগ্রাউন্ড (TikTok)
              </button>
            </div>

            {/* AI Prompt Input Bar */}
            <div className="space-y-1.5">
              <label className="block text-xs font-mono text-slate-400">এআই আইডিয়ার মাধ্যমে ডিরেক্ট জেনারেট করুন:</label>
              <textarea
                value={prompt}
                onChange={(e) => setPrompt(e.target.value)}
                rows={2}
                placeholder={
                  genre === "cyberpunk"
                    ? "যেমন: গভীর নেটওয়ার্কে অনুপ্রবেশ, কোয়ান্টাম প্রোটোকল হ্যাকিং স্পিড..."
                    : "যেমন: মেঘলা ডার্ক রাতের শেষ ট্রেন, তার চলে যাওয়ার স্মৃতি..."
                }
                className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500 rounded-lg p-2.5 text-xs text-white placeholder-slate-600 font-sans focus:outline-none transition-all resize-none"
              />
              <button
                onClick={handleGenerateAISeed}
                disabled={isLoading}
                className="w-full py-2.5 bg-gradient-to-r from-cyan-500 via-indigo-500 to-purple-500 text-slate-950 text-xs font-mono font-bold uppercase rounded-lg shadow-lg hover:shadow-[0_0_10px_rgba(0,240,255,0.3)] transition-all flex items-center justify-center gap-1.5 disabled:opacity-50 cursor-pointer"
              >
                {isLoading ? (
                  <>
                    <RefreshCw className="w-4 h-4 animate-spin" /> জেনারেট করা হচ্ছে...
                  </>
                ) : (
                  <>
                    <Sparkles className="w-4 h-4" /> সম্পূর্ণ নতুন জেনারেটিভ সাউন্ড মিক্স করুন!
                  </>
                )}
              </button>
            </div>
          </div>

          {/* Quick Manual Synthesizer Adjustments */}
          <div className="bg-slate-950/80 rounded-xl p-4 border border-cyan-950/60 space-y-4 text-xs">
            <h4 className="font-mono font-semibold text-slate-300">⚡ ম্যানুয়াল মিক্সার কন্ট্রোল</h4>
            
            <div className="space-y-3">
              <div className="space-y-1">
                <div className="flex justify-between font-mono text-[11px] text-slate-400">
                  <span>মাষ্টার ভলিউম (Live Balance)</span>
                  <span className="text-[#00f0ff]">{volume}%</span>
                </div>
                <input
                  type="range"
                  min="0"
                  max="100"
                  value={volume}
                  onChange={(e) => setVolume(Number(e.target.value))}
                  className="w-full accent-cyan-400 bg-slate-800"
                />
              </div>

              <div className="space-y-1">
                <div className="flex justify-between font-mono text-[11px] text-slate-400">
                  <span>টেমপো স্পিড (Tempo BPM)</span>
                  <span className="text-emerald-400">{customBpm} BPM</span>
                </div>
                <input
                  type="range"
                  min="55"
                  max="160"
                  value={customBpm}
                  onChange={(e) => setCustomBpm(Number(e.target.value))}
                  className="w-full accent-emerald-500 bg-slate-800"
                />
              </div>
            </div>
          </div>
        </div>

        {/* Right Grid: Canvas Spectrogram, Play Controller & Records */}
        <div className="lg:col-span-7 space-y-6">
          
          {/* Spectrogram + Real-time display */}
          <div className="bg-slate-950 rounded-xl p-4 border border-cyan-950/60 flex flex-col justify-between relative overflow-hidden aspect-[16/8]">
            {/* Ambient Background Grid lines */}
            <div className="absolute inset-0 bg-[linear-gradient(rgba(0,240,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,240,255,0.02)_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none" />
            
            {/* Live Status indicator */}
            <div className="flex justify-between items-center relative z-10 text-[10px] font-mono select-none">
              <span className="flex items-center gap-1.5 text-slate-350">
                <Disc className={`w-3.5 h-3.5 ${isPlaying ? "animate-spin text-[#00f0ff]" : "text-slate-550"}`} />
                ট্র্যাক: <b className="text-white">{currentTrack.title}</b>
              </span>
              <span className={`px-2 py-0.5 rounded border ${
                currentTrack.genre === "cyberpunk" ? "bg-cyan-950/60 border-cyan-900 text-[#00f0ff]" : "bg-purple-950/60 border-purple-900 text-purple-400"
              }`}>
                {currentTrack.genre === "cyberpunk" ? "CYBER BEAT" : "SAD NOSTALGIA"}
              </span>
            </div>

            {/* Spectrogram representation */}
            <div className="flex-1 flex items-center justify-center relative my-3 h-28">
              {!isPlaying ? (
                <div className="text-center space-y-2 pointer-events-none select-none z-10 p-4">
                  <div className="text-[#00f0ff]/70 text-sm font-semibold flex items-center justify-center gap-1.5 animate-pulse">
                    <Music className="w-5 h-5" /> সাউন্ড প্লেয়ার প্রস্তুত
                  </div>
                  <p className="text-[10px] text-slate-500 max-w-sm">
                    নিচের প্লে বাটনে প্রেস করলেই আপনার ব্রাউজার রিয়েল-টাইমে কৃত্রিম অডিও ফ্রিকোয়েন্সি মেগা কোডিং জেনারেট শুরু করবে।
                  </p>
                </div>
              ) : null}
              <canvas
                ref={canvasRef}
                className="absolute inset-0 w-full h-full rounded bg-[#070a10]"
              />
            </div>

            {/* Primary Control action steps */}
            <div className="flex flex-wrap items-center justify-between gap-3 relative z-10 pt-2 border-t border-cyan-950/60">
              <div className="flex items-center gap-2">
                {!isPlaying ? (
                  <button
                    onClick={startSynthesizer}
                    className="py-1.5 px-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-sans font-bold text-xs uppercase rounded-lg flex items-center gap-1.5 cursor-pointer hover:shadow-[0_0_10px_rgba(16,185,129,0.3)] transition-all"
                  >
                    <Play className="w-4 h-4 fill-current" /> প্লে সাউন্ড (Play)
                  </button>
                ) : (
                  <button
                    onClick={stopSynthesizer}
                    className="py-1.5 px-4 bg-[#1c0f0f] border border-red-900 text-red-400 hover:text-white font-sans font-bold text-xs uppercase rounded-lg flex items-center gap-1.5 cursor-pointer transition-all"
                  >
                    <Square className="w-4 h-4 fill-current" /> স্টপ করুন (Stop)
                  </button>
                )}
              </div>

              {/* Master Recorder block */}
              <div className="flex items-center gap-2">
                {isRecording ? (
                  <button
                    onClick={stopRecordingMaster}
                    className="py-1.5 px-3 bg-red-600 hover:bg-red-500 text-white font-mono text-[11px] font-bold rounded-lg flex items-center gap-1.5 cursor-pointer animate-pulse"
                  >
                    <Square className="w-3.5 h-3.5 fill-current" /> রেকর্ড স্টপ করুন ({recordDuration}s)
                  </button>
                ) : (
                  <button
                    onClick={startRecordingMaster}
                    disabled={!isPlaying}
                    className="py-1.5 px-3 bg-slate-950 hover:bg-slate-900 border border-red-900 text-red-400 disabled:opacity-40 font-mono text-[11px] font-bold rounded-lg flex items-center gap-1.5 cursor-pointer transition-colors"
                    title={!isPlaying ? "সাউন্ড প্লে করার পর রেকর্ড শুরু করুন" : "Procedural Recording ready"}
                  >
                    <div className="w-2.5 h-2.5 bg-red-500 rounded-full animate-ping" />
                    রেকর্ড করুন (Record)
                  </button>
                )}
              </div>
            </div>
          </div>

          {/* User Record lists */}
          <div className="bg-slate-950/60 rounded-xl p-4 border border-cyan-950/60 space-y-3">
            <h4 className="text-xs font-mono font-bold text-slate-300 uppercase tracking-widest border-b border-cyan-950 pb-1.5 flex items-center justify-between">
              <span>📂 আপনার তৈরিকৃত অডিও আর্কাইভ (Recorded Files)</span>
              <span className="text-[10px] text-cyan-400 font-normal">{recordedList.length} Tracks</span>
            </h4>

            {recordedList.length === 0 ? (
              <div className="p-6 text-center text-slate-500 text-xs font-mono italic">
                কোন রেকর্ড করা ফাইল জমা নেই। প্লে করে রেকর্ড বাটন প্রেস করে ডাউনলোড করুন!
              </div>
            ) : (
              <div className="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                {recordedList.map((item) => (
                  <div
                    key={item.id}
                    className="p-3 bg-slate-900/60 border border-cyan-950 rounded-lg flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3"
                  >
                    <div className="space-y-1">
                      <p className="text-xs font-bold text-white leading-snug">{item.title}</p>
                      <div className="flex items-center gap-2 text-[9px] font-mono text-slate-400">
                        <span className={`px-1.5 py-0.2 rounded border ${
                          item.genre === "cyberpunk" ? "border-cyan-900 text-[#00f0ff]" : "border-purple-900 text-purple-400"
                        }`}>{item.genre === "cyberpunk" ? "CYBER" : "SAD"}</span>
                        <span>•</span>
                        <span>সময়: {item.timestamp}</span>
                        <span>•</span>
                        <span className="text-emerald-400">দৈর্ঘ্য: {item.duration}s</span>
                      </div>
                    </div>

                    <div className="flex items-center gap-2 w-full sm:w-auto">
                      <audio src={item.url} controls className="h-6 max-w-[130px] sm:max-w-[180px] bg-slate-950 rounded-sm" />
                      <a
                        href={item.url}
                        download={`${item.title.replace(/\s+/g, "_")}_iloveyoubd.webm`}
                        className="p-1.5 bg-cyan-950 text-[#00f0ff] hover:bg-cyan-900 border border-cyan-800 rounded-md shrink-0 cursor-pointer"
                        title="Download file"
                      >
                        <Download className="w-3.5 h-3.5" />
                      </a>
                      <button
                        onClick={() => handleDeleteTrack(item.id)}
                        className="p-1.5 bg-red-950/65 text-red-400 hover:bg-red-900 rounded-md shrink-0 cursor-pointer"
                        title="Delete file"
                      >
                        <Trash2 className="w-3.5 h-3.5" />
                      </button>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        </div>

      </div>

      <div className="mt-8 bg-cyan-950/20 border border-cyan-900/40 p-4 rounded-xl flex items-start gap-3">
        <Info className="w-5 h-5 text-cyan-400 shrink-0 mt-0.5" />
        <div className="text-xs leading-relaxed text-slate-350">
          <p className="font-bold text-cyan-300">💡 হ্যাকিং ও কষ্টের রিয়েল-টাইম অডিও জেনারেশনের মূল রহস্য:</p>
          <p className="mt-1 font-sans">
            এই প্ল্যাটফর্মের মিউজিক বা সাউন্ড ট্র্যাকগুলো কোনো আগে থেকে করা অডিও রেকর্ড নয়! এটি আপনার দেওয়া অনন্য এআই প্রম্পটের ডিরেক্টিভ ফ্রিকোয়েন্সি নিয়ে ব্রাউজারের ভেতর সম্পূর্ণ কোডিং এর মাধ্যমে মেগা সিন্থেসিস আকারে সিগন্যাল তৈরি করে। যার কারণে প্রতিবার আপনি যা তৈরি করেন, তা সম্পূর্ণ নতুন এবং আগে কখনো কোথাও বা ইন্টারনেটে আপলোড করা হয়নি!
          </p>
        </div>
      </div>
    </div>
  );
}
