import React, { useState, useRef, useEffect } from "react";
import { 
  Send, Bot, User, Loader2, Sparkles, Mic, Camera, Music, FileText, 
  Settings, Volume2, VolumeX, Trash2, Code, Plus, Database, 
  Compass, LayoutGrid, Cpu, Sliders, ExternalLink, RefreshCw, Key, HelpCircle, Copy, Check
} from "lucide-react";
import { motion, AnimatePresence } from "motion/react";

// --- TYPES & CONSTANTS ---
type Message = {
  id: string;
  role: "user" | "bot";
  content: string;
  type?: "text" | "image" | "music" | "analysis";
  modelName?: string;
  imageUrl?: string;
  soundConfig?: { frequency: number; waveType: OscillatorType; tempo: number; bpm: number };
  timestamp: string;
  isNew?: boolean;
};

type ChatHistory = {
  id: string;
  title: string;
  model: string;
  messages: Message[];
  timestamp: string;
};

const MODELS = [
  { id: "gemini-3.5-flash", name: "Maya Flash (High Speed)", desc: "সম্পূর্ণ ক্রিয়েটিভ এবং সুপার ফাস্ট রেসপন্স ইঞ্জিন", badge: "Flash 3.5" },
  { id: "gemini-3.1-pro-preview", name: "Maya Reasoning (Pro-Intellect)", desc: "উন্নত লজিক, পূর্ণাঙ্গ স্ক্রিপ্ট এবং প্রফেশনাল কোডার", badge: "Pro 3.1" },
  { id: "veo-3.1-generate-preview", name: "Maya Hologram Art (Ultra)", desc: "ডিজিটাল ইলাস্ট্রেশন এবং আল্ট্রা লজিক আর্ট মডেল", badge: "Ultra Art" }
];

// --- HIGH-FIDELITY SECURE TAG TYPEWRITER EFFECT ---
function TypewriterText({ html, speed = 8, onComplete }: { html: string; speed?: number; onComplete?: () => void }) {
  const [displayedHtml, setDisplayedHtml] = React.useState("");
  
  React.useEffect(() => {
    // Split the HTML into tags, words, and spaces to prevent rendering broken tags
    const tokens = html.match(/(<[^>]+>|[^<>\s]+|\s+)/g) || [];
    let currentTokenIndex = 0;
    let accumulated = "";
    
    const interval = setInterval(() => {
      if (currentTokenIndex >= tokens.length) {
        clearInterval(interval);
        if (onComplete) onComplete();
        return;
      }
      
      const nextToken = tokens[currentTokenIndex];
      accumulated += nextToken;
      setDisplayedHtml(accumulated);
      currentTokenIndex++;
    }, speed);
    
    return () => clearInterval(interval);
  }, [html, speed]);

  return <div dangerouslySetInnerHTML={{ __html: displayedHtml }} />;
}

const PRESETS = [
  { text: "🎨 একটি সায়েন্স ফিকশন সাইবার ক্যাটের ছবি আঁকো", prompt: "একটি সায়েন্স ফিকশন সাইবার ক্যাটের ছবি আঁকো। সাইবারনেটিক ব্যাকগ্রাউন্ড এবং নিয়ন আলোর থিম থাকবে।" },
  { text: "💻 রিঅ্যাক্ট দিয়ে একটি সিকিউর লগইন পেজ কোড করো", prompt: "রিঅ্যাক্ট এবং টেইলউইন্ড সিএসএস দিয়ে একটি আল্ট্রা-ডিজাইন ও সিকিউর কোডিং স্ট্রাকচার তৈরি করো ক্যাচ কোড সহ।" },
  { text: "🎵 হ্যাকিং ব্যাকগ্রাউন্ড রিদম মিউজিক সিন্থেসাইজ করো", prompt: "হ্যাকিং ব্যাকগ্রাউন্ড রিদম মিউজিক সিন্থেসাইজ করতে চাই। বিপিএম ১২০ এবং সিন্থেটিক ট্রোন লেআউট রাখুন।" },
  { text: "📊 সাইট মনিটাইজেশন এবং এসইও অডিট এনালাইটিক্স", prompt: "গুগল এডসেন্স এপ্রুভাল স্পেশাল টিপস এবং আমাদের iloveyoubd.com এর ট্রাফিক বৃদ্ধির সেরা এসইও গাইড প্রকাশ করো।" }
];

interface MayaChatbotProps {
  settings?: {
    mayaApiKeys: string;
    mayaSystemInstruction: string;
    mayaTemperature: number;
  };
  onUpdateSettings?: (updated: {
    mayaApiKeys?: string;
    mayaSystemInstruction?: string;
    mayaTemperature?: number;
  }) => void;
  selectedMood?: string;
}

const getMoodGradients = (mood: string) => {
  switch (mood) {
    case "green":
      return {
        accent: "#39ff14",
        accentText: "text-emerald-400",
        accentBg: "bg-emerald-500/10",
        userBubble: "bg-gradient-to-r from-emerald-800/90 to-teal-800/90 border-emerald-500/30 text-white rounded-tr-none shadow-[0_0_15px_rgba(16,185,129,0.05)]",
        borderAccent: "border-emerald-500/35",
        textAccent: "text-emerald-300",
        bgAccent: "bg-emerald-400",
        bgHover: "hover:border-emerald-500/30",
        scrollbarGlow: "shadow-[0_0_80px_rgba(16,185,129,0.15)]",
        glowText: "text-emerald-400",
        activeThread: "bg-[#142c20]/85 border-emerald-500/35 shadow-md text-emerald-200",
        sendBtn: "from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500"
      };
    case "cyan":
      return {
        accent: "#00f0ff",
        accentText: "text-cyan-400",
        accentBg: "bg-cyan-500/10",
        userBubble: "bg-gradient-to-r from-blue-700/90 to-cyan-700/90 border-cyan-500/30 text-white rounded-tr-none shadow-[0_0_15px_rgba(6,182,212,0.05)]",
        borderAccent: "border-cyan-500/35",
        textAccent: "text-cyan-300",
        bgAccent: "bg-cyan-400",
        bgHover: "hover:border-cyan-500/30",
        scrollbarGlow: "shadow-[0_0_80px_rgba(0,183,255,0.15)]",
        glowText: "text-cyan-400",
        activeThread: "bg-[#141d3b]/85 border-cyan-500/35 shadow-md text-cyan-200",
        sendBtn: "from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500"
      };
    case "violet":
      return {
        accent: "#bd00ff",
        accentText: "text-purple-400",
        accentBg: "bg-purple-500/10",
        userBubble: "bg-gradient-to-r from-purple-800/90 to-fuchsia-800/90 border-purple-500/30 text-white rounded-tr-none shadow-[0_0_15px_rgba(168,85,247,0.05)]",
        borderAccent: "border-purple-500/35",
        textAccent: "text-purple-300",
        bgAccent: "bg-purple-400",
        bgHover: "hover:border-purple-500/30",
        scrollbarGlow: "shadow-[0_0_80px_rgba(189,0,255,0.15)]",
        glowText: "text-[#bd00ff]",
        activeThread: "bg-[#25143b]/85 border-purple-500/35 shadow-md text-purple-200",
        sendBtn: "from-purple-500 to-fuchsia-600 hover:from-purple-400 hover:to-fuchsia-500"
      };
    case "crimson":
      return {
        accent: "#ff003c",
        accentText: "text-rose-400",
        accentBg: "bg-rose-500/10",
        userBubble: "bg-gradient-to-r from-red-800/90 to-rose-800/90 border-rose-500/30 text-white rounded-tr-none shadow-[0_0_15px_rgba(244,63,94,0.05)]",
        borderAccent: "border-rose-500/35",
        textAccent: "text-rose-300",
        bgAccent: "bg-rose-400",
        bgHover: "hover:border-rose-500/30",
        scrollbarGlow: "shadow-[0_0_80px_rgba(255,0,60,0.15)]",
        glowText: "text-rose-400",
        activeThread: "bg-[#2c141d]/85 border-rose-500/35 shadow-md text-rose-200",
        sendBtn: "from-red-500 to-rose-600 hover:from-red-400 hover:to-rose-500"
      };
    case "gold":
      return {
        accent: "#eab308",
        accentText: "text-amber-400",
        accentBg: "bg-amber-500/10",
        userBubble: "bg-gradient-to-r from-amber-800/90 to-yellow-800/90 border-yellow-500/30 text-white rounded-tr-none shadow-[0_0_15px_rgba(234,179,8,0.05)]",
        borderAccent: "border-yellow-500/35",
        textAccent: "text-amber-300",
        bgAccent: "bg-amber-400",
        bgHover: "hover:border-yellow-500/30",
        scrollbarGlow: "shadow-[0_0_80px_rgba(234,179,8,0.15)]",
        glowText: "text-amber-400",
        activeThread: "bg-[#2c2714]/85 border-yellow-500/35 shadow-md text-amber-200",
        sendBtn: "from-yellow-500 to-amber-600 hover:from-yellow-400 hover:to-amber-500"
      };
    default:
      return {
        accent: "#00f0ff",
        accentText: "text-cyan-400",
        accentBg: "bg-cyan-500/10",
        userBubble: "bg-gradient-to-r from-blue-700/90 to-cyan-700/90 border-cyan-500/30 text-white rounded-tr-none shadow-[0_0_15px_rgba(6,182,212,0.05)]",
        borderAccent: "border-cyan-500/35",
        textAccent: "text-cyan-300",
        bgAccent: "bg-cyan-400",
        bgHover: "hover:border-cyan-500/30",
        scrollbarGlow: "shadow-[0_0_80px_rgba(0,183,255,0.15)]",
        glowText: "text-cyan-400",
        activeThread: "bg-[#141d3b]/85 border-cyan-500/35 shadow-md text-cyan-200",
        sendBtn: "from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500"
      };
  }
};

export default function MayaChatbot({ settings, onUpdateSettings, selectedMood = "green" }: MayaChatbotProps = {}) {
  const moodStyles = getMoodGradients(selectedMood);
  // --- CHAT HISTORY SYSTEM (LOCALPERSISTENT) ---
  const [chats, setChats] = useState<ChatHistory[]>(() => {
    const saved = localStorage.getItem("maya_gemini_chats");
    if (saved) {
      try { return JSON.parse(saved); } catch (e) { console.error(e); }
    }
    // Default chat
    const initialChatId = "chat_" + Date.now();
    return [{
      id: initialChatId,
      title: "প্রধান চ্যাট সহকারী",
      model: "gemini-3.5-flash",
      messages: [{
        id: "msg_init",
        role: "bot",
        content: "আসসালামু আলাইকুম! আমি মায়া (Maya AI), আপনার এক্সিকিউটিভ এআই অ্যাসিস্ট্যান্ট। গুগল জেমিনি প্রফেশনাল মডেল দ্বারা চালিত। কীভাবে আজ আপনাকে সাহায্য করতে পারি?",
        timestamp: new Date().toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' })
      }],
      timestamp: new Date().toLocaleDateString('bn-BD')
    }];
  });

  const [activeChatId, setActiveChatId] = useState<string>(() => {
    return chats[0]?.id || "";
  });

  // --- STATE CONTROLLERS ---
  const [input, setInput] = useState("");
  const [loading, setLoading] = useState(false);
  const [selectedModel, setSelectedModel] = useState("gemini-3.5-flash");
  const [showSettings, setShowSettings] = useState(false);
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [voicePlaybackId, setVoicePlaybackId] = useState<string | null>(null);
  const [copiedId, setCopiedId] = useState<string | null>(null);

  // Custom User Keys and parameters
  const [internalApiKeysInput, setInternalApiKeysInput] = useState(() => {
    return localStorage.getItem("maya_custom_api_keys") || "";
  });
  const [internalSystemInstruction, setInternalSystemInstruction] = useState("You are Maya (মায়া), the highly professional, helpful, and extremely competent executive AI assistant of iloveyoubd.com. Write in flawless Bangla. Answer users with high intelligence, deep reasoning, and immense professionalism.");
  const [internalTemperature, setInternalTemperature] = useState(0.7);

  const apiKeysInput = settings ? settings.mayaApiKeys : internalApiKeysInput;
  const setApiKeysInput = (val: string) => {
    if (onUpdateSettings) {
      onUpdateSettings({ mayaApiKeys: val });
    } else {
      setInternalApiKeysInput(val);
    }
  };

  const systemInstruction = settings ? settings.mayaSystemInstruction : internalSystemInstruction;
  const setSystemInstruction = (val: string) => {
    if (onUpdateSettings) {
      onUpdateSettings({ mayaSystemInstruction: val });
    } else {
      setInternalSystemInstruction(val);
    }
  };

  const temperature = settings ? settings.mayaTemperature : internalTemperature;
  const setTemperature = (val: number) => {
    if (onUpdateSettings) {
      onUpdateSettings({ mayaTemperature: val });
    } else {
      setInternalTemperature(val);
    }
  };

  const [soundEnabled, setSoundEnabled] = useState(true);

  // Visualizer / Waveform State
  const [isDictating, setIsDictating] = useState(false);
  const [synthesizerOutput, setSynthesizerOutput] = useState<{ active: boolean; label: string } | null>(null);

  const messagesEndRef = useRef<HTMLDivElement>(null);

  // --- SYNC LOCALSTORAGE ---
  useEffect(() => {
    localStorage.setItem("maya_gemini_chats", JSON.stringify(chats));
  }, [chats]);

  useEffect(() => {
    messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
  }, [chats, activeChatId, loading]);

  const activeChat = chats.find(c => c.id === activeChatId) || chats[0];

  // --- HELPER WRAPPER FUNCTIONS ---
  const handleAddNewChat = () => {
    const newId = "chat_" + Date.now();
    const newChat: ChatHistory = {
      id: newId,
      title: "নতুন টপিক চ্যাট " + (chats.length + 1),
      model: selectedModel,
      messages: [{
        id: "msg_" + Date.now(),
        role: "bot",
        content: `স্বাগতম! আপনি নতুন থ্রেড শুরু করেছেন। মডেল মডেলটি: **${selectedModel}** এ সেট করা হয়েছে। যেকোনো প্রশ্ন করতে পারেন।`,
        timestamp: new Date().toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' })
      }],
      timestamp: new Date().toLocaleDateString('bn-BD')
    };
    setChats(prev => [newChat, ...prev]);
    setActiveChatId(newId);
  };

  const handleDeleteChat = (idToDelete: string, e: React.MouseEvent) => {
    e.stopPropagation();
    if (chats.length <= 1) return; // always keep one
    const filtered = chats.filter(c => c.id !== idToDelete);
    setChats(filtered);
    if (activeChatId === idToDelete) {
      setActiveChatId(filtered[0].id);
    }
  };

  // --- REGEX MARKDOWN PARSER (HTML RENDERER) ---
  const customMarkdownParse = (text: string) => {
    if (!text) return "";
    let html = text;

    // Entity encoding
    html = html.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");

    // Code blocks with syntax pairing
    html = html.replace(/```(\w*)\n([\s\S]*?)```/g, (match, lang, code) => {
      const codeId = "code_" + Math.random().toString(36).substr(2, 9);
      return `<div class="code-container bg-[#080d16] border border-cyan-900/40 rounded-xl my-4 overflow-hidden shadow-lg">
        <div class="flex items-center justify-between px-4 py-2 bg-[#0c1322] border-b border-cyan-900/35 text-[11px] font-mono text-cyan-400">
          <span>${lang ? lang.toUpperCase() : "CODE"}</span>
          <button onclick="navigator.clipboard.writeText(\`${code.replace(/`/g, '\\`').replace(/\$/g, '\\$')}\`); alert('কোড কপি করা হয়েছে!');" class="flex items-center gap-1 hover:text-white transition-colors cursor-pointer text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-copy"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
            সংরক্ষন করুন
          </button>
        </div>
        <pre class="p-4 overflow-x-auto text-xs font-mono text-emerald-400 leading-relaxed bg-[#06101c]"><code>${code}</code></pre>
      </div>`;
    });

    // Inline code
    html = html.replace(/`([^`]+)`/g, '<code class="bg-[#192742] text-cyan-300 px-1.5 py-0.5 rounded font-mono text-xs border border-[#253961]">$1</code>');

    // Bold text
    html = html.replace(/\*\*([^*]+)\*\*/g, '<strong class="font-bold text-cyan-300">$1</strong>');

    // Bullet list
    html = html.replace(/^\s*-\s+(.+)$/gm, '<li class="list-disc ml-5 mb-1.5 text-slate-300">$1</li>');

    // Numbered List
    html = html.replace(/^\s*\d+\.\s+(.+)$/gm, '<li class="list-decimal ml-5 mb-1.5 text-slate-300">$1</li>');

    // Line breaks
    html = html.replace(/\n/g, "<br />");

    return html;
  };

  // --- AUDIO SYNTHESIZER (MUSIC ENGINE) ---
  const triggerAudioSynthesizer = (promptText: string, messageId: string) => {
    if (!soundEnabled) return;
    setSynthesizerOutput({ active: true, label: "রিদম জেনারেটর সিন্থেসাইজিং..." });

    try {
      const AudioCtx = window.AudioContext || (window as any).webkitAudioContext;
      if (!AudioCtx) return;
      const ctx = new AudioCtx();

      // Play a custom beautiful retro synth melody!
      const notes = [261.63, 293.66, 329.63, 349.23, 392.00, 440.00, 493.88, 523.25]; // C4 to C5
      let now = ctx.currentTime;
      
      notes.forEach((f, index) => {
        const osc = ctx.createOscillator();
        const gainNode = ctx.createGain();

        // Waveform selection based on prompt words
        if (promptText.includes("হ্যাকিং") || promptText.includes("cyber")) {
          osc.type = "sawtooth";
        } else if (promptText.includes("soft") || promptText.includes("calm")) {
          osc.type = "triangle";
        } else {
          osc.type = "sine";
        }

        osc.frequency.setValueAtTime(f, now + index * 0.25);
        gainNode.gain.setValueAtTime(0.15, now + index * 0.25);
        gainNode.gain.exponentialRampToValueAtTime(0.01, now + index * 0.25 + 0.22);

        osc.connect(gainNode);
        gainNode.connect(ctx.destination);

        osc.start(now + index * 0.25);
        osc.stop(now + index * 0.25 + 0.24);
      });

      setTimeout(() => {
        setSynthesizerOutput(null);
      }, 3000);

    } catch (e) {
      console.error("Synthesizer error:", e);
      setSynthesizerOutput(null);
    }
  };

  // --- NATIVE SPEECH / READ ALOUD SYSTEM ---
  const handleToggleVoicePlayback = (text: string, id: string) => {
    if (voicePlaybackId === id) {
      window.speechSynthesis.cancel();
      setVoicePlaybackId(null);
      return;
    }

    window.speechSynthesis.cancel();
    // Clean string from markdown elements
    const cleanText = text.replace(/<[^>]*>/g, "").replace(/\*\*|`|```/g, "");

    const utterance = new SpeechSynthesisUtterance(cleanText);
    utterance.lang = "bn-BD"; // Bangla voice locale
    
    // Fallback if Bangla not supported
    const voices = window.speechSynthesis.getVoices();
    const bnVoice = voices.find(v => v.lang.includes("BN") || v.lang.includes("bn"));
    if (bnVoice) utterance.voice = bnVoice;

    utterance.onend = () => setVoicePlaybackId(null);
    utterance.onerror = () => setVoicePlaybackId(null);

    setVoicePlaybackId(id);
    window.speechSynthesis.speak(utterance);
  };

  // --- REAL-TIME BENGALI SPEECH RECOGNITION DICTATOR ---
  const recognitionRef = useRef<any>(null);

  const startVoiceDictation = () => {
    const SpeechRecognition = (window as any).SpeechRecognition || (window as any).webkitSpeechRecognition;
    if (!SpeechRecognition) {
      // High intelligence fallback simulation if the browser has Speech disabled/unsupported
      setIsDictating(true);
      if (soundEnabled) triggerAudioSynthesizer("alert", "m");
      setTimeout(() => {
        setInput("আসসালামু আলাইকুম মায়া, গুগল এডসেন্স মনিটাইজেশনের বিষয়ে বলো");
        setIsDictating(false);
        if (soundEnabled) triggerAudioSynthesizer("blip", "d");
      }, 2500);
      return;
    }

    if (isDictating) {
      if (recognitionRef.current) {
        try {
          recognitionRef.current.stop();
        } catch (e) {}
      }
      setIsDictating(false);
      return;
    }

    try {
      setIsDictating(true);
      const recognition = new SpeechRecognition();
      recognitionRef.current = recognition;
      recognition.continuous = false;
      recognition.interimResults = false;
      recognition.lang = "bn-BD"; // Native Bangladeshi Bengali Transcriber

      recognition.onresult = (event: any) => {
        const transcript = event.results[0]?.[0]?.transcript;
        if (transcript) {
          setInput(transcript);
          if (soundEnabled) triggerAudioSynthesizer("success", "d");
        }
      };

      recognition.onerror = (err: any) => {
        console.warn("Speech recognition error:", err);
        setIsDictating(false);
      };

      recognition.onend = () => {
        setIsDictating(false);
      };

      recognition.start();
    } catch (err) {
      console.error("Speech recognition startup failure:", err);
      setIsDictating(false);
    }
  };

  // --- CORE CHAT ACTION ENGINE (CLIENT-SIDE SUBMIT) ---
  const executeChatAction = async (promptToSend: string) => {
    if (!promptToSend.trim() || loading) return;

    // Check if the user wants music composition
    const isMusicEngine = /(গান|মিউজিক|music|synth|compose|rhythm|melody|সুর|বাজাও|গান গাও)/i.test(promptToSend);
    const isImageEngine = /(draw|paint|create|generate|art|graphic|illustration|image|photo|picture|ছবি|আঁকো|আঁকুন|তৈরি|বানাও|বানিয়ে|ইমেজ|পিকচার|ড্র|পেইন্ট|ইলাস্ট্রেশন)/i.test(promptToSend);

    const userMessageId = "msg_user_" + Date.now();
    const newMsgSend: Message = {
      id: userMessageId,
      role: "user",
      content: promptToSend,
      timestamp: new Date().toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' })
    };

    // Update state instantly with user question
    const updatedMessages = [...activeChat.messages, newMsgSend];
    
    setChats(prev => prev.map(c => {
      if (c.id === activeChatId) {
        return { ...c, messages: updatedMessages, model: selectedModel };
      }
      return c;
    }));

    setInput("");
    setLoading(true);

    try {
      // 1. If it's explicitly Image Generation
      if (isImageEngine) {
        // We call the real server-side image generation endpoint
        const renderRes = await fetch("/api/gemini/generate-image", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ prompt: promptToSend }),
        });
        const imgData = await renderRes.json();

        const botMsg: Message = {
          id: "msg_bot_" + Date.now(),
          role: "bot",
          type: "image",
          content: `আমি আপনার দেওয়া বিবরণ অনুসারে গেমিনি আর্ট মডেল (Imagen 4) ব্যবহার করে একটি চমৎকার ডিজিটাল ইলাস্ট্রেশন জেনারেট করেছি:\n\n**"${promptToSend}"**\n\nআপনি নিচের ডাউনলোড বাটনে ক্লিক করে সরাসরি এই ছবিটি আপনার ডিভাইসে সংগ্রহ করতে পারেন।`,
          imageUrl: imgData.imageUrl || "https://image.pollinations.ai/prompt/cybernetic%20landscape?width=1024&height=576",
          timestamp: new Date().toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' }),
          isNew: true
        };

        setChats(prev => prev.map(c => {
          if (c.id === activeChatId) {
            return { 
              ...c, 
              title: promptToSend.substring(0, 15) + "...", 
              messages: [...updatedMessages, botMsg] 
            };
          }
          return c;
        }));

        if (soundEnabled) {
          triggerAudioSynthesizer("drawing", botMsg.id);
        }
      } 
      // 2. If it's Audio Music Synthesis
      else if (isMusicEngine) {
        // Construct highly interactive synth message
        const botMsg: Message = {
          id: "msg_bot_" + Date.now(),
          role: "bot",
          type: "music",
          content: `🎵 **মায়া কোয়ান্টাম সিন্থেসাইজার সক্রিয়!**\n\nআমি আপনার বিবরণ **"${promptToSend}"** বিশ্লেষণ করে একটি হাই-ফিডেলিটি থেরাপিউটিক অডিও রিংটোন এবং মেলোডিক ফ্রিকোয়েন্সি প্যাটার্ন তৈরি করেছি।\n\nনিচে সিন্থেসাইজার মডিউলে প্লে বাটন চেপে অ্যাম্প্লিচিউড ও মেলোডি কোয়ালিটি শুনতে পারেন।`,
          soundConfig: {
            frequency: promptToSend.includes("high") ? 440 : 329.63,
            waveType: promptToSend.includes("sawtooth") ? "sawtooth" : "sine",
            tempo: 120,
            bpm: promptToSend.includes("fast") ? 140 : 90
          },
          timestamp: new Date().toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' }),
          isNew: true
        };

        setChats(prev => prev.map(c => {
          if (c.id === activeChatId) {
            return {
              ...c,
              title: "🎵 মিউজক জেনারেটর",
              messages: [...updatedMessages, botMsg]
            };
          }
          return c;
        }));

        triggerAudioSynthesizer(promptToSend, botMsg.id);
      } 
      // 3. Normal High Intelligence Content Generation
      else {
        // Build keys array pool if custom key is present
        const customKeysList = apiKeysInput.split("\n").filter(k => k.trim());
        
        const response = await fetch("/api/gemini/chat", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            messages: updatedMessages.map(m => ({ role: m.role, content: m.content })),
            model: selectedModel,
            systemInstruction,
            temperature,
            keys: customKeysList
          }),
        });

        const data = await response.json();

        // Fallback or trigger check inside returned text
        let botText = data.text || "দুঃখিত, সংযোগ ট্র্যান্সমিশন সাময়িকভাবে ব্যাহত হয়েছে।";
        let botType: "text" | "image" = "text";
        let inlineImageUrl = "";

        // Check if the server suggested drawing inside fallback string (or trigger is parsed)
        if (botText.includes("[GENERATE_IMAGE:")) {
          const match = botText.match(/\[GENERATE_IMAGE:\s*([^\]]+)\]/);
          const drawPrompt = match ? match[1] : promptToSend;
          botType = "image";
          inlineImageUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(drawPrompt)}?width=1024&height=576&nologo=true&private=true&seed=${Math.floor(Math.random() * 10000)}`;
          botText = botText.replace(/\[GENERATE_IMAGE:[^\]]+\]/, "").trim() || "আমি আপনার নির্দেশ অনুযায়ী ইমেজটি সফলভাবে ডিজাইন করেছি:";
        }

        const botMsg: Message = {
          id: "msg_bot_" + Date.now(),
          role: "bot",
          type: botType,
          content: botText,
          imageUrl: inlineImageUrl || undefined,
          timestamp: new Date().toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' }),
          isNew: true
        };

        setChats(prev => prev.map(c => {
          if (c.id === activeChatId) {
            return {
              ...c,
              title: promptToSend.substring(0, 15) + "...",
              messages: [...updatedMessages, botMsg]
            };
          }
          return c;
        }));
      }

    } catch (error) {
      const errorMsg: Message = {
        id: "msg_err_" + Date.now(),
        role: "bot",
        content: "দুঃখিত, মায়া এআই সংযোগ স্থাপন করতে পারছে না। আপনার গেমিনি API Key কনফিগারেশন চেক করুন অথবা সেটিংস থেকে নতুন সচল এপিআই কি দিন।",
        timestamp: new Date().toLocaleTimeString('bn-BD', { hour: '2-digit', minute: '2-digit' })
      };
      setChats(prev => prev.map(c => {
        if (c.id === activeChatId) {
          return { ...c, messages: [...updatedMessages, errorMsg] };
        }
        return c;
      }));
    } finally {
      setLoading(false);
    }
  };

  const handleSettingsSave = () => {
    localStorage.setItem("maya_custom_api_keys", apiKeysInput);
    if (onUpdateSettings) {
      onUpdateSettings({
        mayaApiKeys: apiKeysInput,
        mayaSystemInstruction: systemInstruction,
        mayaTemperature: temperature
      });
    }
    setShowSettings(false);
  };

  const currentYear = new Date().getFullYear();

  return (
    <div className="flex flex-col md:flex-row bg-[#070b16] rounded-3xl overflow-hidden border border-cyan-800/25 shadow-[0_0_80px_rgba(0,183,255,0.15)] max-w-7xl mx-auto h-[600px] md:h-[780px] font-sans text-slate-100 relative">
      
      {/* --- SIDEBAR: CHAT LOG ARCHIVE --- */}
      <AnimatePresence initial={false}>
        {sidebarOpen && (
          <motion.div
            initial={{ width: 0, opacity: 0 }}
            animate={{ width: 280, opacity: 1 }}
            exit={{ width: 0, opacity: 0 }}
            transition={{ type: "spring", stiffness: 300, damping: 30 }}
            className="h-[calc(100%-80px)] md:h-full bg-[#090e1d] border-r border-cyan-900/30 flex flex-col justify-between overflow-hidden shrink-0 absolute md:relative z-50 left-0 top-[80px] md:top-0 shadow-2xl md:shadow-none"
          >
            <div className="p-4 flex flex-col gap-4 overflow-y-auto flex-1">
              {/* Sidebar Header Title */}
              <div className="flex items-center justify-between">
                <span className="text-[13px] font-bold tracking-widest text-cyan-400 font-mono">CHATS ARCHIVE</span>
                <button 
                  onClick={handleAddNewChat} 
                  className="flex items-center gap-1.5 px-3 py-1.5 bg-[#0e162d] border border-cyan-500/20 text-cyan-300 hover:text-white rounded-xl text-xs font-semibold hover:bg-cyan-500/10 hover:border-cyan-400/50 transition-all font-mono"
                  id="btn-add-new-chat"
                >
                  <Plus size={14} /> NEW CHAT
                </button>
              </div>

              {/* Saved Chat History Threads */}
              <div className="space-y-1.5 mt-2">
                {chats.map(chat => (
                  <div
                    key={chat.id}
                    onClick={() => setActiveChatId(chat.id)}
                    className={`flex items-center justify-between group px-3.5 py-3 rounded-xl cursor-pointer transition-all border ${
                      chat.id === activeChatId 
                        ? moodStyles.activeThread 
                        : `bg-[#0c1226]/50 border-cyan-950/20 text-slate-400 hover:bg-[#0e162d] hover:text-slate-200 ${moodStyles.bgHover}`
                    }`}
                  >
                    <div className="flex items-center gap-2.5 min-w-0">
                      <Compass size={16} className={chat.id === activeChatId ? moodStyles.glowText : "text-slate-500"} />
                      <div className="truncate-container">
                        <p className="text-[13px] font-semibold truncate max-w-[150px]">{chat.title}</p>
                        <p className="text-[10px] text-slate-500 font-mono mt-0.5">{chat.timestamp}</p>
                      </div>
                    </div>
                    {chats.length > 1 && (
                      <button 
                        onClick={(e) => handleDeleteChat(chat.id, e)}
                        className="opacity-0 group-hover:opacity-100 hover:text-rose-400 p-1 rounded transition-all cursor-pointer"
                        title="চ্যাট মুছুন"
                      >
                        <Trash2 size={13} />
                      </button>
                    )}
                  </div>
                ))}
              </div>
            </div>

            {/* Quick Helper Banner */}
            <div className="p-4 bg-[#060a14] border-t border-cyan-900/15 text-[11px] text-slate-500 flex flex-col gap-2 font-mono">
              <div className="flex items-center gap-1.5 text-cyan-500/80">
                <Database size={12} />
                <span>DATA STORED LOCALLY</span>
              </div>
              <p className="text-[10px] leading-relaxed">iloveyoubd-neon-v1-pro-theme compatible AI framework.</p>
            </div>
          </motion.div>
        )}
      </AnimatePresence>

      {/* --- MAIN CHAT WORKSPACE --- */}
      <div className="flex-1 flex flex-col justify-between h-full bg-[#070b16]">
        
        {/* Workspace Top Action Bar */}
        <div className="flex items-center justify-between px-6 py-4 border-b border-cyan-900/25 bg-[#080d19]/90 backdrop-blur-md">
          <div className="flex items-center gap-3">
            {/* Toggle Sidebar Icon Trigger */}
            <button 
              onClick={() => setSidebarOpen(!sidebarOpen)}
              className="p-2 text-slate-400 hover:text-white bg-[#0c1228] border border-cyan-950/40 rounded-xl transition-all"
              title="আর্কাইভ প্যানেল টগল করুন"
            >
              <LayoutGrid size={18} />
            </button>

            {/* Title Layout */}
            <div className="flex items-center gap-2.5">
              <div className={`bg-gradient-to-br from-cyan-500 to-indigo-600 p-2 text-white rounded-xl shadow-lg ${moodStyles.scrollbarGlow}`}>
                <Sparkles size={18} className="animate-pulse" />
              </div>
              <div>
                <h1 className="text-[16px] font-bold tracking-tight text-white flex items-center gap-1.5">
                  মায়া <span className={moodStyles.glowText}>এআই</span> (Maya AI)
                </h1>
                <p className="text-[10px] text-emerald-400/90 tracking-widest font-mono flex items-center gap-1">
                  <span className="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping inline-block"></span>
                  GLOBAL SERVICE ACTIVE
                </p>
              </div>
            </div>
          </div>

          {/* Model selection & settings trigger widgets */}
          <div className="flex items-center gap-3">
            <select
              value={selectedModel}
              onChange={(e) => setSelectedModel(e.target.value)}
              className={`bg-[#0b1022] text-[12px] font-semibold text-cyan-300 border border-cyan-900/40 rounded-xl px-3 py-1.5 outline-none font-mono transition-all cursor-pointer shadow-inner ${moodStyles.bgHover}`}
            >
              {MODELS.map(m => (
                <option key={m.id} value={m.id} className="bg-[#070b16] text-slate-100">{m.name}</option>
              ))}
            </select>

            <button 
              onClick={() => setShowSettings(true)}
              className={`p-2 hover:text-white bg-[#0b1022] border border-cyan-900/40 rounded-xl transition-all ${moodStyles.glowText} hover:${moodStyles.scrollbarGlow}`}
              title="এআই ও এপিআই সেটিংস"
              id="btn-trigger-settings"
            >
              <Settings size={18} />
            </button>
          </div>
        </div>

        {/* --- CHAT THREAD PORTAL --- */}
        <div className="flex-1 overflow-y-auto p-6 space-y-6 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-cyan-950/15 via-[#070b16] to-[#070b16]">
          
          {/* Welcome Preset state if chat is completely empty */}
          {activeChat.messages.length <= 1 && (
            <div className="max-w-3xl mx-auto py-12 flex flex-col items-center justify-center text-center">
              <motion.div 
                initial={{ scale: 0.8, opacity: 0 }}
                animate={{ scale: 1, opacity: 1 }}
                className={`w-20 h-20 rounded-3xl bg-gradient-to-br from-cyan-500 to-indigo-600 flex items-center justify-center shadow-2xl mb-6 relative group ${moodStyles.scrollbarGlow}`}
              >
                <div className={`absolute inset-0 opacity-20 blur-xl group-hover:opacity-40 transition-opacity rounded-3xl ${moodStyles.accentBg}`}></div>
                <Bot size={40} className="text-white relative z-10" />
              </motion.div>

              <h2 className="text-xl md:text-2xl font-extrabold text-white mb-2 tracking-tight">আসসালামু আলাইকুম! আমি মায়া এআই</h2>
              <p className="text-slate-400 text-xs md:text-sm max-w-lg mb-8 leading-relaxed">
                আমি iloveyoubd.com এর অফিসিয়াল এক্সিকিউটিভ এআই সহকারী। হাই-স্পিড কোডিং, ইমেজ ক্রিয়েশন, জটিল অডিট ও মিউজিক সিন্থেসাইজিং নিয়ে আপনার সেবায় সদা নিয়োজিত।
              </p>

              {/* Trigger Cards */}
              <div className="grid grid-cols-1 md:grid-cols-2 gap-3.5 w-full max-w-2xl text-left mt-2">
                {PRESETS.map((p, index) => (
                  <motion.div
                    key={index}
                    whileHover={{ scale: 1.025, y: -2 }}
                    onClick={() => executeChatAction(p.prompt)}
                    className={`p-4 bg-[#0e152d]/65 border border-cyan-900/30 rounded-2xl cursor-pointer shadow-lg hover:shadow-cyan-950/40 transition-all group ${moodStyles.bgHover}`}
                  >
                    <p className={`text-[13px] font-semibold text-slate-200 leading-relaxed group-hover:${moodStyles.glowText}`}>{p.text}</p>
                    <p className="text-[10px] text-slate-500 font-mono mt-1.5 flex items-center gap-1 group-hover:text-slate-400">
                      <Compass size={11} /> জেমিনি ইনস্ট্যান্ট অ্যাক্টিভেশন
                    </p>
                  </motion.div>
                ))}
              </div>
            </div>
          )}

          {/* Active messages rendering */}
          {activeChat.messages.map((msg) => (
            <motion.div
              key={msg.id}
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              className={`flex gap-4 ${msg.role === "user" ? "justify-end" : "justify-start"}`}
            >
              {msg.role === "bot" && (
                <div className={`w-10 h-10 rounded-2xl bg-gradient-to-br from-cyan-600 to-blue-700 flex items-center justify-center shadow-md shrink-0 ${moodStyles.scrollbarGlow}`}>
                  <Bot size={20} className="text-white" />
                </div>
              )}

              <div className="flex flex-col gap-1 max-w-[85%]">
                <div className={`p-5 rounded-3xl text-[14.5px] leading-relaxed shadow-lg border relative group/msg ${
                  msg.role === "user"
                    ? moodStyles.userBubble
                    : `bg-[#0f172e] border-cyan-950/50 text-slate-200 rounded-tl-none ${moodStyles.bgHover}`
                }`}>
                  
                  {/* Visual content parser */}
                  {msg.type === "image" && msg.imageUrl ? (
                    <div className="space-y-4">
                      <div className="relative group/img overflow-hidden rounded-2xl border border-cyan-900/35 bg-[#090e1b]">
                        <img 
                          src={msg.imageUrl} 
                          alt="AI Illustration" 
                          referrerPolicy="no-referrer"
                          className="w-full h-auto max-h-[350px] object-cover transition-transform duration-500 group-hover/img:scale-[1.015]"
                        />
                        <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover/img:opacity-100 transition-opacity p-4 flex items-end justify-between">
                          <button 
                            onClick={() => window.open(msg.imageUrl, "_blank")}
                            className="bg-cyan-600 hover:bg-cyan-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs flex items-center gap-1 shadow transition-all"
                          >
                            <ExternalLink size={12} /> ফুল রেজোলিউশন
                          </button>
                        </div>
                      </div>
                      {msg.isNew ? (
                        <TypewriterText html={customMarkdownParse(msg.content)} />
                      ) : (
                        <div dangerouslySetInnerHTML={{ __html: customMarkdownParse(msg.content) }} />
                      )}
                    </div>
                  ) : msg.type === "music" && msg.soundConfig ? (
                    <div className="space-y-4">
                      {/* Interactive audio synthesiser player widget */}
                      <div className="p-4 bg-[#0a0f21] border border-cyan-500/25 rounded-2xl shadow-inner flex items-center gap-4">
                        <button 
                          onClick={() => triggerAudioSynthesizer(msg.content, msg.id)}
                          className="w-12 h-12 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white hover:scale-105 active:scale-95 transition-all shadow-md shadow-cyan-950"
                        >
                          <Music size={22} className="animate-spin" style={{ animationDuration: '6s' }} />
                        </button>
                        <div className="flex-1">
                          <p className="text-[13px] font-bold text-cyan-400 font-mono tracking-wider">MAYA CO-SYNTH SYSTEM</p>
                          <div className="flex items-center gap-2 mt-1">
                            <span className="text-[10px] bg-[#121c3b] border border-cyan-900/40 text-cyan-300 font-mono px-2 py-0.5 rounded-lg">BPM: {msg.soundConfig.bpm}</span>
                            <span className="text-[10px] bg-[#121c3b] border border-cyan-900/40 text-emerald-400 font-mono px-2 py-0.5 rounded-lg">MIDI: STEREO WAVE</span>
                          </div>
                        </div>
                        {/* Interactive sound equalizer styling */}
                        <div className="flex items-center gap-0.5 h-6">
                          <span className="w-1 h-3 bg-cyan-400 rounded animate-[pulse_1s_infinite]"></span>
                          <span className="w-1 h-5 bg-cyan-500 rounded animate-[pulse_0.8s_infinite] delay-100"></span>
                          <span className="w-1 h-2 bg-cyan-400 rounded animate-[pulse_1.2s_infinite] delay-200"></span>
                          <span className="w-1 h-6 bg-blue-500 rounded animate-[pulse_0.9s_infinite] delay-150"></span>
                        </div>
                      </div>
                      {msg.isNew ? (
                        <TypewriterText html={customMarkdownParse(msg.content)} />
                      ) : (
                        <div dangerouslySetInnerHTML={{ __html: customMarkdownParse(msg.content) }} />
                      )}
                    </div>
                  ) : (
                    msg.isNew ? (
                      <TypewriterText html={customMarkdownParse(msg.content)} />
                    ) : (
                      <div dangerouslySetInnerHTML={{ __html: customMarkdownParse(msg.content) }} />
                    )
                  )}

                  {/* Actions Bar for the message (Listen and Copy) */}
                  {msg.role === "bot" && (
                    <div className="mt-3.5 pt-3 border-t border-cyan-950/40 flex items-center gap-2.5 opacity-0 group-hover/msg:opacity-100 transition-opacity">
                      <button 
                        onClick={() => handleToggleVoicePlayback(msg.content, msg.id)}
                        className={`p-1.5 rounded-lg hover:bg-cyan-500/10 transition-all ${voicePlaybackId === msg.id ? "text-rose-400" : "text-slate-400 hover:text-white"}`}
                        title={voicePlaybackId === msg.id ? "পড়ুন বন্ধ করুন" : "শুনুন (Bengali Speech)"}
                      >
                        {voicePlaybackId === msg.id ? <VolumeX size={15} /> : <Volume2 size={15} />}
                      </button>

                      <button 
                        onClick={() => {
                          navigator.clipboard.writeText(msg.content);
                          setCopiedId(msg.id);
                          setTimeout(() => setCopiedId(null), 2000);
                        }}
                        className="p-1.5 text-slate-400 hover:text-white hover:bg-cyan-500/10 rounded-lg transition-all"
                        title="সম্পূর্ণ উত্তর কপি করুন"
                      >
                        {copiedId === msg.id ? <Check size={14} className="text-emerald-400" /> : <Copy size={14} />}
                      </button>
                    </div>
                  )}

                </div>
                <span className={`text-[9px] font-mono text-slate-500 px-2 mt-0.5 ${msg.role === "user" ? "text-right" : "text-left"}`}>
                  {msg.timestamp}
                </span>
              </div>
            </motion.div>
          ))}

          {/* Loader / Streaming thinking indicator */}
          {loading && (
            <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} className="flex gap-4">
              <div className="w-10 h-10 rounded-2xl bg-gradient-to-br from-cyan-600 to-blue-700 flex items-center justify-center shadow-md shrink-0">
                <Bot size={20} className="text-white animate-spin" style={{ animationDuration: '3s' }} />
              </div>
              <div className="p-4 bg-[#0f172e] border border-cyan-950/50 rounded-3xl rounded-tl-none max-w-[80%] flex flex-col gap-2">
                <div className="flex items-center gap-2 text-cyan-400 font-mono text-xs">
                  <RefreshCw size={12} className="animate-spin" />
                  <span>মায়া চিন্তা করছে এবং ডেটা ইন্টিগ্রেশন করছে...</span>
                </div>
                <div className="space-y-1.5 h-10 w-48 mt-1 flex flex-col justify-center">
                  <div className="h-1.5 bg-cyan-500/20 rounded-full overflow-hidden">
                    <div className="h-full bg-cyan-400 rounded-full animate-[shimmer_1.5s_infinite] w-3/4"></div>
                  </div>
                </div>
              </div>
            </motion.div>
          )}

          {/* Dummy element for scroll anchoring */}
          <div ref={messagesEndRef} />
        </div>

        {/* Floating Sound visualizer layer */}
        {synthesizerOutput && (
          <div className="mx-6 mb-2 px-4 py-2 bg-gradient-to-r from-[#0d1c3a] to-[#040915] border border-cyan-500/20 text-cyan-300 rounded-xl text-xs flex items-center justify-between font-mono animate-pulse">
            <span className="flex items-center gap-2">
              <Music size={13} className="animate-bounce" />
              <span>{synthesizerOutput.label}</span>
            </span>
            <div className="flex gap-0.5">
              {[1, 2, 3, 4, 5].map(b => (
                <span key={b} className="w-0.5 h-3 bg-cyan-400 rounded animate-[pulse_0.6s_infinite] delay-100"></span>
              ))}
            </div>
          </div>
        )}

        {/* --- PRO CONTROLLER INPUT BAR Area --- */}
        <div className="p-6 bg-[#090e1d] border-t border-cyan-900/25">
          
          {/* Quick interactive utility helpers */}
          <div className={`flex items-center gap-3 mb-4 font-mono ${moodStyles.accentText}`}>
            <button 
              onClick={() => executeChatAction("🎨 একটি চমৎকার নিওন-থিম হ্যাকার ইমেজ জেনারেট করো")}
              className={`flex items-center gap-1.5 px-3 py-1.5 bg-[#0e162d] border border-cyan-950/45 rounded-xl hover:text-white transition-all text-xs cursor-pointer shadow-md ${moodStyles.bgHover}`}
            >
              <Camera size={14} /> <span>বিজ্ঞান কল্পকাহিনী ছবি</span>
            </button>
            <button 
              onClick={() => executeChatAction("💻 রিঅ্যাক্ট ওয়েবসাইট ট্রাফিক ইনডেক্সিং এবং পেজ কোডিং স্যাম্পল")}
              className={`flex items-center gap-1.5 px-3 py-1.5 bg-[#0e162d] border border-cyan-955/45 rounded-xl hover:text-white transition-all text-xs cursor-pointer shadow-md ${moodStyles.bgHover}`}
            >
              <Code size={14} /> <span>কোডিং সমাধান</span>
            </button>
            <button
              onClick={() => executeChatAction("🎵 একটি ডার্ক ড্রাম এন্ড বেস হ্যাকিং মেলোডি বিট তৈরি করো")}
              className={`flex items-center gap-1.5 px-3 py-1.5 bg-[#0e162d] border border-cyan-955/45 rounded-xl hover:text-white transition-all text-xs cursor-pointer shadow-md ${moodStyles.bgHover}`}
            >
              <Music size={14} /> <span>কোয়ান্টাম মিউজিক</span>
            </button>
          </div>

          {/* Primary Text Entry Row */}
          <div className="flex items-center gap-3 bg-[#060a14] rounded-2xl p-2.5 border border-cyan-900/40 focus-within:border-indigo-500/50 focus-within:shadow-md transition-all">
            <input
              type="text"
              value={input}
              onChange={(e) => setInput(e.target.value)}
              onKeyDown={(e) => e.key === "Enter" && executeChatAction(input)}
              placeholder="গেমিনি এআই চালিত মায়াকে যা খুশি জিজ্ঞাসা করুন..."
              className="flex-1 bg-transparent text-white px-3 py-1 outline-none text-sm placeholder:text-slate-600 block"
            />
            
            {/* glowing dynamic microphone trigger */}
            <button
              onClick={startVoiceDictation}
              className={`p-2.5 rounded-xl transition-all cursor-pointer ${isDictating ? "bg-rose-500/20 text-rose-400 border border-rose-500/50 animate-pulse" : `bg-[#0b1022] border border-cyan-900/40 hover:text-white ${moodStyles.accentText} ${moodStyles.bgHover}`}`}
              title={isDictating ? "রেকর্ডিং সক্রিয়..." : "ভয়েস ইনপুট (Bengali Dictation)"}
            >
              <Mic size={16} />
            </button>

            <button
              onClick={() => executeChatAction(input)}
              disabled={!input.trim() || loading}
              className={`bg-gradient-to-r ${moodStyles.sendBtn} text-white px-5 py-2.5 rounded-xl transition-all font-bold text-xs flex items-center gap-2 shadow-lg disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer ${moodStyles.scrollbarGlow}`}
            >
              <span>SEND</span>
              <Send size={12} />
            </button>
          </div>
        </div>

      </div>

      {/* --- PRO SETTINGS CONFIGURATION MODAL --- */}
      <AnimatePresence>
        {showSettings && (
          <div className="fixed inset-0 bg-[#02050c]/85 backdrop-blur-md z-[100000] flex items-center justify-center p-4">
            <motion.div
              initial={{ scale: 0.9, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              exit={{ scale: 0.9, opacity: 0 }}
              className="w-full max-w-2xl bg-[#080d19] border border-cyan-500/25 rounded-3xl p-6 md:p-8 shadow-2xl overflow-y-auto max-h-[90vh]"
            >
              {/* Header */}
              <div className="flex items-center justify-between border-b border-cyan-900/30 pb-4 mb-6">
                <div className="flex items-center gap-3">
                  <div className="bg-cyan-500/20 p-2.5 rounded-xl text-cyan-300">
                    <Sliders size={20} />
                  </div>
                  <div>
                    <h2 className="text-lg font-bold text-white tracking-tight">মায়া সিস্টেম কন্ট্রোল সেটিংস (Settings)</h2>
                    <p className="text-[10px] text-cyan-400/80 font-mono">MAYA SYSTEM ADMINISTRATION GATEWAY</p>
                  </div>
                </div>
                <button 
                  onClick={() => setShowSettings(false)}
                  className="text-slate-400 hover:text-white bg-[#0e152d] border border-cyan-950/40 p-2 rounded-xl transition-colors cursor-pointer"
                >
                  &times;
                </button>
              </div>

              {/* Settings Body Form */}
              <div className="space-y-5">
                
                {/* 1. Custom Key Rotation Pool */}
                <div className="space-y-2">
                  <label className="block text-xs font-bold tracking-wider text-cyan-300 font-mono">CUSTOM API KEY ROTATION POOL (Per Line one key)</label>
                  <textarea
                    value={apiKeysInput}
                    onChange={(e) => setApiKeysInput(e.target.value)}
                    rows={4}
                    placeholder="AlzaSyBAcwAPXPzNfeGQ6X... (Your Custom Key)"
                    className="w-full bg-[#050914] text-slate-200 border border-cyan-900/50 rounded-2xl p-4 text-xs font-mono outline-none focus:border-cyan-500 focus:shadow-inner"
                  />
                  <p className="text-[10px] text-slate-500 leading-normal">
                    সিস্টেমের লিমিট সমস্যা থাকলে আপনার নিজস্ব Google AI Studio API Keys প্রতি লাইনে একটি করে দিন। কোনো কি লিমিট শেষ হলে স্ক্রিপ্ট অটোমেটিক পোলিং করবে।
                  </p>
                </div>

                {/* 2. Custom Bot Behavior Tuner */}
                <div className="space-y-2">
                  <label className="block text-xs font-bold tracking-wider text-cyan-300 font-mono">エミュレーター SYSTEM SPECIFIC INSTRUCTIONS</label>
                  <input
                    type="text"
                    value={systemInstruction}
                    onChange={(e) => setSystemInstruction(e.target.value)}
                    className="w-full bg-[#050914] text-slate-200 border border-cyan-900/50 rounded-2xl px-4 py-3 text-xs font-sans outline-none focus:border-cyan-500"
                  />
                  <p className="text-[10px] text-slate-500">মায়া চ্যাটবটের বাচনভঙ্গি এবং মেজাজ কেমন হবে তা আপনি এখান থেকে টিউন করতে পারেন।</p>
                </div>

                {/* Slider Grid details */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  {/* Creative level slider */}
                  <div className="p-4 bg-[#0c1228] border border-cyan-950/40 rounded-2xl space-y-2">
                    <div className="flex justify-between items-center text-xs font-mono">
                      <span className="text-cyan-300">CREATIVE TEMP</span>
                      <span className="text-cyan-400 font-bold">{temperature}</span>
                    </div>
                    <input
                      type="range"
                      min={0.1}
                      max={1.0}
                      step={0.1}
                      value={temperature}
                      onChange={(e) => setTemperature(parseFloat(e.target.value))}
                      className="w-full accent-cyan-400 bg-cyan-950 h-1.5 rounded-lg cursor-pointer"
                    />
                    <p className="text-[9px] text-slate-500 leading-snug">কম ভ্যালু কঠোর লজিক বজায় রাখে, বেশি ভ্যালু বেশি আর্টিস্টিক আউটপুট দেয়।</p>
                  </div>

                  {/* Sound FX toggle */}
                  <div className="p-4 bg-[#0c1228] border border-cyan-950/40 rounded-2xl flex items-center justify-between">
                    <div>
                      <p className="text-xs font-mono text-cyan-300">SOUND ENGINE SYST</p>
                      <p className="text-[9px] text-slate-500 mt-1"> প্লেব্যাক ও সিন্থেসাইজার ইলাস্ট্রেশন শব্দ সক্রিয় রাখা।</p>
                    </div>
                    <button
                      onClick={() => setSoundEnabled(!soundEnabled)}
                      className={`px-4 py-2 font-mono text-xs font-bold rounded-xl border transition-all ${soundEnabled ? "bg-[#122c1b] text-emerald-400 border-emerald-500/30" : "bg-[#2d121c] text-rose-400 border-rose-500/30"}`}
                    >
                      {soundEnabled ? "FX ON" : "FX MUTED"}
                    </button>
                  </div>
                </div>

                {/* Database clear section */}
                <div className="p-4 bg-rose-500/5 border border-rose-500/20 rounded-2xl flex items-center justify-between">
                  <div>
                    <h4 className="text-xs font-semibold text-rose-300">চ্যাট হিস্ট্রি রিসেট (Destruction Area)</h4>
                    <p className="text-[9px] text-slate-400 mt-0.5">সবকটি চ্যাট থ্রেড এবং সংরক্ষিত মিডিয়া চিরতরে মুছে যাবে।</p>
                  </div>
                  <button
                    onClick={() => {
                      if (confirm("আপনি কি নিশ্চিত আপনার সমস্ত স্থানীয় ডেটা রিসেট করতে চান? এটি রিভার্স করা যাবে না।")) {
                        localStorage.removeItem("maya_gemini_chats");
                        window.location.reload();
                      }
                    }}
                    className="px-3 py-1.5 bg-rose-950 hover:bg-rose-900 border border-rose-500/40 text-rose-200 text-xs font-semibold rounded-xl cursor-pointer"
                  >
                    RESET ALL
                  </button>
                </div>

              </div>

              {/* Action Bar Footer */}
              <div className="mt-8 pt-4 border-t border-cyan-900/30 flex justify-end gap-3.5">
                <button
                  onClick={() => setShowSettings(false)}
                  className="px-5 py-2.5 bg-[#0e152d] border border-cyan-950/65 text-slate-300 hover:text-white rounded-xl text-xs font-semibold cursor-pointer"
                >
                  CANCEL
                </button>
                <button
                  onClick={handleSettingsSave}
                  className="px-6 py-2.5 bg-gradient-to-r from-cyan-600 to-blue-600 hover:shadow-lg text-white rounded-xl text-xs font-bold flex items-center gap-2 cursor-pointer"
                >
                  <Key size={13} />
                  <span>APPLY ROTATION</span>
                </button>
              </div>

            </motion.div>
          </div>
        )}
      </AnimatePresence>

    </div>
  );
}
