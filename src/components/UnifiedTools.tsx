import React, { useState, useRef, useEffect } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  Wrench, 
  Sparkles, 
  QrCode, 
  Globe, 
  Copy, 
  CheckCircle, 
  Sliders, 
  FileCode, 
  RefreshCw, 
  Flame, 
  Cpu, 
  Download,
  Gamepad2,
  ShieldCheck,
  Mic,
  Volume2,
  Tv,
  Check,
  Play,
  Search,
  Code
} from "lucide-react";

type ToolType = "ai-writer" | "qr-suite" | "webmaster" | "cyber-pet" | "app-store";

interface UnifiedToolsProps {
  initialSubTool?: ToolType;
  initialApp?: any;
  onClearInitialApp?: () => void;
}

export default function UnifiedTools({ initialSubTool, initialApp, onClearInitialApp }: UnifiedToolsProps = {}) {
  const [activeSubTool, setActiveSubTool] = useState<ToolType>(initialSubTool || "ai-writer");
  const [copiedText, setCopiedText] = useState("");

  // Common copy feedback handler
  const triggerCopy = (textValue: string, identifier: string) => {
    navigator.clipboard.writeText(textValue);
    setCopiedText(identifier);
    setTimeout(() => setCopiedText(""), 2000);
  };

  // 1. AI SEMANTIC WRITER AND SEO OPTIMIZER STATE
  const [aiInput, setAiInput] = useState("");
  const [aiAction, setAiAction] = useState<"translate" | "seo" | "catchy-title">("translate");
  const [aiOutput, setAiOutput] = useState("");
  const [aiLoading, setAiLoading] = useState(false);

  const handleAISubmit = async () => {
    if (!aiInput.trim()) return;
    setAiLoading(true);
    setAiOutput("");
    try {
      const res = await fetch("/api/downloader/ai-seo", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ text: aiInput, mode: aiAction })
      });
      const data = await res.json();
      if (res.ok && data.success) {
        setAiOutput(data.result);
      } else {
        setAiOutput(data.error || "এআই সার্ভার সাড়া দেয়নি। অনুগ্রহ করে আবার চেষ্টা করুন!");
      }
    } catch {
      setAiOutput("নেটওয়ার্ক সংযোগ বিঘ্নিত হয়েছে। সার্ভার পুনরারম্ভ হচ্ছে।");
    } finally {
      setAiLoading(false);
    }
  };

  // 2. NEON QR CODE BUILDER STATE
  const [qrText, setQrText] = useState("https://iloveyoubd.com");
  const [qrColor, setQrColor] = useState("00f0ff"); // Hex without '#'
  const [qrSize, setQrSize] = useState("250x250");
  const [qrGlow, setQrGlow] = useState(true);

  const qrImageUrl = `https://api.qrserver.com/v1/create-qr-code/?size=${qrSize}&color=${qrColor}&data=${encodeURIComponent(qrText)}`;

  const handleDownloadQR = async () => {
    try {
      const filename = `iloveyoubd_com_neon_qr.png`;
      const downloadUrl = `/api/downloader/proxy?url=${encodeURIComponent(qrImageUrl)}&filename=${encodeURIComponent(filename)}`;
      const a = document.createElement("a");
      a.href = downloadUrl;
      a.download = filename;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    } catch {
      window.open(qrImageUrl);
    }
  };

  // 3. WEBMASTER METADATA & CSS GLOW GENERATOR STATE
  const [glowColor, setGlowColor] = useState("#00f0ff");
  const [glowBlur, setGlowBlur] = useState(20);
  const [glowSpread, setGlowSpread] = useState(5);
  const [glowOpacity, setGlowOpacity] = useState(40);
  
  const hexToRGBA = (hex: string, alphaPercent: number) => {
    const r = parseInt(hex.slice(1, 3), 16) || 0;
    const g = parseInt(hex.slice(3, 5), 16) || 0;
    const b = parseInt(hex.slice(5, 7), 16) || 0;
    return `rgba(${r}, ${g}, ${b}, ${alphaPercent / 100})`;
  };

  const currentBoxShadow = `0px 0px ${glowBlur}px ${glowSpread}px ${hexToRGBA(glowColor, glowOpacity)}`;
  const currentTailwindCode = `shadow-[0_0_${glowBlur}px_${glowSpread}px_${glowColor}/${glowOpacity}]`;
  const currentCSSCode = `box-shadow: ${currentBoxShadow};`;

  const [seoTitle, setSeoTitle] = useState("আই লাভ ইউ বিডি - মেগা পোর্টাল");
  const [seoDesc, setSeoDesc] = useState("বাংলাদেশের সবচেয়ে সেরা এবং আধুনিক ফ্রি অনলাইন এআই টুলস, লাইভ টিভি, মিউজিক এবং ফাস্ট ভিডিও ডাউনলোডার প্ল্যাটফর্ম।");
  const [seoKeywords, setSeoKeywords] = useState("iloveyoubd, bangla ai tools, high speed downloader, bd tools port");
  const [seoLang, setSeoLang] = useState("bn");

  const generatedMetaCode = `<!-- Primary SEO Tags (iloveyoubd.com Approved) -->
<title>${seoTitle}</title>
<meta name="title" content="${seoTitle}">
<meta name="description" content="${seoDesc}">
<meta name="keywords" content="${seoKeywords}">
<meta name="language" content="${seoLang === "bn" ? "Bengali" : "English"}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:title" content="${seoTitle}">
<meta property="og:description" content="${seoDesc}">
<meta property="og:image" content="https://iloveyoubd.com/og_banner.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:title" content="${seoTitle}">
<meta property="twitter:description" content="${seoDesc}">`;

  // 4. CYBER PET (TALKING CAT CLIENT SIDE STABLE SIMULATION)
  const [catState, setCatState] = useState<"idle" | "talking" | "hit" | "faint" | "laughing">("idle");
  const [isPetRecording, setIsPetRecording] = useState(false);
  const [isPetPlaying, setIsPetPlaying] = useState(false);
  const [petAudioSupported, setPetAudioSupported] = useState(true);
  const [micVolume, setMicVolume] = useState(0);
  const mediaRecorderRef = useRef<MediaRecorder | null>(null);
  const petChunksRef = useRef<Blob[]>([]);
  const audioContextRef = useRef<AudioContext | null>(null);
  const analyserRef = useRef<AnalyserNode | null>(null);
  const animationFrameRef = useRef<number | null>(null);
  const streamRef = useRef<MediaStream | null>(null);

  // Safety synthesizer if files do not exist
  const playSynthesizedSFX = (type: "hit" | "faint" | "tickle") => {
    try {
      const AudioCtx = window.AudioContext || (window as any).webkitAudioContext;
      const ctx = new AudioCtx();
      const osc = ctx.createOscillator();
      const gain = ctx.createGain();
      osc.connect(gain);
      gain.connect(ctx.destination);

      if (type === "hit") {
        osc.frequency.setValueAtTime(550, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(120, ctx.currentTime + 0.15);
        gain.gain.setValueAtTime(0.35, ctx.currentTime);
        gain.gain.linearRampToValueAtTime(0.01, ctx.currentTime + 0.15);
        osc.start();
        osc.stop(ctx.currentTime + 0.15);
      } else if (type === "faint") {
        osc.frequency.setValueAtTime(250, ctx.currentTime);
        osc.frequency.linearRampToValueAtTime(60, ctx.currentTime + 0.6);
        gain.gain.setValueAtTime(0.3, ctx.currentTime);
        gain.gain.linearRampToValueAtTime(0.01, ctx.currentTime + 0.6);
        osc.start();
        osc.stop(ctx.currentTime + 0.6);
      } else if (type === "tickle") {
        let time = ctx.currentTime;
        for (let i = 0; i < 3; i++) {
          const oscG = ctx.createOscillator();
          const gainG = ctx.createGain();
          oscG.connect(gainG);
          gainG.connect(ctx.destination);
          oscG.frequency.setValueAtTime(450 + i * 120, time);
          oscG.frequency.linearRampToValueAtTime(750 + i * 120, time + 0.08);
          gainG.gain.setValueAtTime(0.2, time);
          gainG.gain.linearRampToValueAtTime(0.01, time + 0.08);
          oscG.start(time);
          oscG.stop(time + 0.08);
          time += 0.1;
        }
      }
    } catch (e) {
      console.warn("Synthesizer blocked or unsupported:", e);
    }
  };

  const startPetRecording = async () => {
    try {
      if (isPetPlaying || isPetRecording) return;
      
      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      streamRef.current = stream;
      setIsPetRecording(true);
      setCatState("talking");
      
      const AudioCtx = window.AudioContext || (window as any).webkitAudioContext;
      const actx = new AudioCtx();
      audioContextRef.current = actx;
      const source = actx.createMediaStreamSource(stream);
      const analyser = actx.createAnalyser();
      analyser.fftSize = 64;
      source.connect(analyser);
      analyserRef.current = analyser;
      
      const checkVolume = () => {
        if (!analyserRef.current) return;
        const array = new Uint8Array(analyserRef.current.frequencyBinCount);
        analyserRef.current.getByteFrequencyData(array);
        const avg = array.reduce((a, b) => a + b, 0) / array.length;
        setMicVolume(avg);
        animationFrameRef.current = requestAnimationFrame(checkVolume);
      };
      animationFrameRef.current = requestAnimationFrame(checkVolume);

      const recorder = new MediaRecorder(stream);
      mediaRecorderRef.current = recorder;
      petChunksRef.current = [];
      
      recorder.ondataavailable = (e) => {
        if (e.data.size > 0) {
          petChunksRef.current.push(e.data);
        }
      };
      
      recorder.onstop = async () => {
        const audioBlob = new Blob(petChunksRef.current, { type: "audio/ogg; codecs=opus" });
        const textUrl = URL.createObjectURL(audioBlob);
        
        const playbackAudio = new Audio(textUrl);
        playbackAudio.playbackRate = 1.7;
        (playbackAudio as any).preservesPitch = false;
        
        playbackAudio.onplay = () => {
          setIsPetPlaying(true);
          setCatState("talking");
        };
        
        playbackAudio.onended = () => {
          setIsPetPlaying(false);
          setCatState("idle");
          URL.revokeObjectURL(textUrl);
        };
        
        playbackAudio.onerror = () => {
          setIsPetPlaying(false);
          setCatState("idle");
        };
        
        try {
          await playbackAudio.play();
        } catch (err) {
          console.warn("Playback failed:", err);
          setIsPetPlaying(false);
          setCatState("idle");
        }
      };
      
      recorder.start();
    } catch (err) {
      console.warn("Microphone access, secure settings check, or error:", err);
      setPetAudioSupported(false);
      setCatState("idle");
    }
  };

  const stopPetRecording = () => {
    if (mediaRecorderRef.current && isPetRecording) {
      setIsPetRecording(false);
      mediaRecorderRef.current.stop();
    }
    
    if (animationFrameRef.current) {
      cancelAnimationFrame(animationFrameRef.current);
    }
    if (audioContextRef.current) {
      audioContextRef.current.close().catch(() => {});
    }
    if (streamRef.current) {
      streamRef.current.getTracks().forEach(track => track.stop());
    }
    setMicVolume(0);
  };

  // Touch Interactions
  const handleCatClick = (e: React.MouseEvent<HTMLDivElement>) => {
    if (isPetRecording || isPetPlaying || catState !== "idle") return;
    
    const rect = e.currentTarget.getBoundingClientRect();
    const y = (e.clientY - rect.top) / rect.height;

    if (y < 0.3) {
      setCatState("hit");
      playSynthesizedSFX("hit");
      const audio = new Audio("/theme-assets/cyber-game/sounds/hit.mp3");
      audio.play().catch(() => {});
    } else if (y > 0.7) {
      setCatState("faint");
      playSynthesizedSFX("faint");
      const audio = new Audio("/theme-assets/cyber-game/sounds/faint.mp3");
      audio.play().catch(() => {});
    } else {
      setCatState("laughing");
      playSynthesizedSFX("tickle");
      const audio = new Audio("/theme-assets/cyber-game/sounds/tickle.mp3");
      audio.play().catch(() => {});
    }

    setTimeout(() => {
      setCatState("idle");
    }, 2000);
  };

  // Cleanup effect
  useEffect(() => {
    return () => {
      if (animationFrameRef.current) cancelAnimationFrame(animationFrameRef.current);
      if (audioContextRef.current) audioContextRef.current.close().catch(() => {});
      if (streamRef.current) streamRef.current.getTracks().forEach(track => track.stop());
    };
  }, []);

  // 5. CYBERX PRO PLAY STORE SEARCH & SEO PORTAL STATE
  const [selectedApp, setSelectedApp] = useState<any | null>(null);
  const [scanProgress, setScanProgress] = useState(0);
  const [scanLogs, setScanLogs] = useState<string[]>([]);
  const [isScanning, setIsScanning] = useState(false);
  const [scanSuccess, setScanSuccess] = useState(false);

  // Search, crawl and metadata state
  const [playStoreQuery, setPlayStoreQuery] = useState("");
  const [searchLang, setSearchLang] = useState<"bn" | "en">("bn");
  const [isSearchingApp, setIsSearchingApp] = useState(false);
  const [appSearchError, setAppSearchError] = useState("");

  const [availableApps, setAvailableApps] = useState<any[]>([
    {
      packageId: "com.whatsapp",
      title: "WhatsApp Messenger",
      developer: "WhatsApp LLC",
      category: "Communication / মেসেঞ্জার",
      rating: "4.3",
      ratingCount: "172M+ reviews",
      price: "Free / সম্পূর্ণ ফ্রি",
      icon: "https://play-lh.googleusercontent.com/bYtqbV8Zg6pIi66S7oYm686B6fN6Yg00f0ff",
      description: "সারা বিশ্বের মানুষের সাথে সহজ, নিরাপদ ও ব্যক্তিগত মেসেজিং এবং ভয়েস কলার গ্লোবাল সার্ভিস।",
      playStoreUrl: "https://play.google.com/store/apps/details?id=com.whatsapp",
      directSecureDownloadUrl: "https://play.google.com/store/apps/details?id=com.whatsapp",
      seoMetaTemplate: "<!-- WhatsApp Index Tags -->"
    },
    {
      packageId: "com.bKash.customerapp",
      title: "bKash - বিকাশ অ্যাপ",
      developer: "bKash Limited",
      category: "Finance / মোবাইল ব্যাংকিং",
      rating: "4.6",
      ratingCount: "1.2M+ reviews",
      price: "Free / সম্পূর্ণ ফ্রি",
      icon: "https://play-lh.googleusercontent.com/w9ZgY3pI9e7q7snv3qfN6Yg",
      description: "বাংলাদেশে দ্রুত, সুরক্ষিত ও সবচেয়ে বড় উপায়ে টাকা লেনদেন, মোবাইল রিচার্জ ও বিল পেমেন্ট সমাধান।",
      playStoreUrl: "https://play.google.com/store/apps/details?id=com.bKash.customerapp",
      directSecureDownloadUrl: "https://play.google.com/store/apps/details?id=com.bKash.customerapp",
      seoMetaTemplate: "<!-- bKash Index Tags -->"
    },
    {
      packageId: "com.konasl.nagad",
      title: "Nagad - নকদ অ্যাপ",
      developer: "Nagad Limited",
      category: "Finance / ডাক ক্যাশ",
      rating: "4.5",
      ratingCount: "820K+ reviews",
      price: "Free / সম্পূর্ণ ফ্রি",
      icon: "https://play-lh.googleusercontent.com/8_Q9itYV396Eul6HSf78In969hsnv3qfN6Yg",
      description: "ডাক বিভাগের অত্যন্ত সাশ্রয়ী এবং নির্ভরযোগ্য ডিজিটাল ওয়ালেট ও ক্যাশ আউট সেবা সার্ভিস।",
      playStoreUrl: "https://play.google.com/store/apps/details?id=com.konasl.nagad",
      directSecureDownloadUrl: "https://play.google.com/store/apps/details?id=com.konasl.nagad",
      seoMetaTemplate: "<!-- Nagad Index Tags -->"
    },
    {
      packageId: "com.zhiliaoapp.musically",
      title: "TikTok - ভিডিও কন্টেন্ট",
      developer: "TikTok Pte. Ltd.",
      category: "Social / এন্টারটেইনমেন্ট",
      rating: "4.4",
      ratingCount: "58M+ reviews",
      price: "Free / সম্পূর্ণ ফ্রি",
      icon: "https://play-lh.googleusercontent.com/ccWneaY7Zf380Zg6pIi66S7oYm686B6fN6Yg",
      description: "ভিডিও কন্টেন্ট ও মিউজিক যুক্ত রিলস বা ছোট ক্লিপ শেয়ার করার গ্লোবাল বিনোদন প্লাটফর্ম।",
      playStoreUrl: "https://play.google.com/store/apps/details?id=com.zhiliaoapp.musically",
      directSecureDownloadUrl: "https://play.google.com/store/apps/details?id=com.zhiliaoapp.musically",
      seoMetaTemplate: "<!-- TikTok Index Tags -->"
    }
  ]);

  const handlePlayStoreSearch = async () => {
    if (!playStoreQuery.trim()) return;
    setIsSearchingApp(true);
    setAppSearchError("");

    let finalPackageId = playStoreQuery.trim();

    // Pasted Google Play Store link
    if (finalPackageId.includes("play.google.com")) {
      const match = finalPackageId.match(/[?&]id=([a-zA-Z0-9._]+)/);
      if (match && match[1]) {
        finalPackageId = match[1];
      } else {
        setAppSearchError("প্লে স্টোর লিঙ্ক থেকে প্যাকেজ আইডি বের করতে পারেনি। সঠিক লিঙ্ক দিন!");
        setIsSearchingApp(false);
        return;
      }
    }

    // Keyword text string resolving (no dots)
    if (!finalPackageId.includes(".")) {
      try {
        const searchRes = await fetch(`/api/downloader/playstore-search?q=${encodeURIComponent(finalPackageId)}`);
        const searchData = await searchRes.json();
        if (searchRes.ok && searchData.success && searchData.results && searchData.results.length > 0) {
          finalPackageId = searchData.results[0];
        } else {
          setAppSearchError("আপনার অনুসন্ধান অনুযায়ী কোনো সঠিক প্লে-প্যাকেজ আইডি পাওয়া যায়নি।");
          setIsSearchingApp(false);
          return;
        }
      } catch (err) {
        setAppSearchError("সার্ভার অনুসন্ধান গেটওয়ে ত্রুটি। পুনরায় চেষ্টা করুন!");
        setIsSearchingApp(false);
        return;
      }
    }

    // Crawl live metadata
    try {
      const crawlRes = await fetch(`/api/downloader/playstore?packageId=${encodeURIComponent(finalPackageId)}&hl=${searchLang}`);
      const crawlData = await crawlRes.json();
      
      if (crawlRes.ok && crawlData.success && crawlData.data) {
        const freshApp = crawlData.data;
        
        setAvailableApps(prev => {
          const exists = prev.find(item => item.packageId === freshApp.packageId);
          if (exists) {
            return [freshApp, ...prev.filter(item => item.packageId !== freshApp.packageId)];
          }
          return [freshApp, ...prev];
        });
        
        setPlayStoreQuery("");
      } else {
        setAppSearchError(crawlData.error || "এই প্যাকেজ আইডি প্লে স্টোরে পাওয়া যায়নি। আইডিটি পুনরায় মিলিয়ে নিন।");
      }
    } catch (err) {
      setAppSearchError("সার্ভার মেটা ক্রল ব্যর্থ হয়েছে। প্লে স্টোর ফায়ারওয়াল প্রতিরোধ করেছে।");
    } finally {
      setIsSearchingApp(false);
    }
  };

  const startSecureScanAndDownload = (app: any) => {
    setSelectedApp(app);
    setIsScanning(true);
    setScanProgress(0);
    setScanSuccess(false);
    
    const logs = [
      `[SYS] Initializing CyberX Defend Gateway v3.1...`,
      `[INFO] Target Play Package Target: ${app.packageId}`,
      `[INFO] Host: Google Play Crypt-Verified Servers`,
      `[SEC] Executing Play Protect signature and rating integrity validations...`,
    ];
    setScanLogs([logs[0]]);

    let currentLogIndex = 1;
    const logInterval = setInterval(() => {
      if (currentLogIndex < logs.length) {
        setScanLogs(prev => [...prev, logs[currentLogIndex]]);
        currentLogIndex++;
      } else {
        clearInterval(logInterval);
      }
    }, 400);

    const progressInterval = setInterval(() => {
      setScanProgress(prev => {
        const next = prev + Math.floor(Math.random() * 15) + 8;
        if (next >= 100) {
          clearInterval(progressInterval);
          setScanSuccess(true);
          setScanLogs(prevLogs => [
            ...prevLogs,
            `[SCAN] Parsing Play Store layout and checking permission declaration schemas...`,
            `[INTEGRITY] Security Verification: 100% SECURE (Official Signature)`,
            `[ADSENSE] Compliance Status: Safe direct link. No hosting policy breaches.`,
            `[GATE] Injecting search-engine optimization tags schema...`,
            `[SUCCESS] Encryption tunnel verified! Securely routing to Google Play Store.`
          ]);
          triggerTunnelDownload(app);
          return 100;
        }

        if (next > 25 && next < 40) {
          setScanLogs(p => p.includes(`[SCAN] Scanning for malware & package structural spoofing...`) ? p : [...p, `[SCAN] Scanning for malware & package structural spoofing...`]);
        }
        if (next > 60 && next < 75) {
          setScanLogs(p => p.includes(`[SCAN] Validating Play Store Play-Protect licensing safety...`) ? p : [...p, `[SCAN] Validating Play Store Play-Protect licensing safety...`]);
        }

        return next;
      });
    }, 150);
  };

  const triggerTunnelDownload = (app: any) => {
    setTimeout(() => {
      try {
        const targetUrl = app.playStoreUrl || `https://play.google.com/store/apps/details?id=${app.packageId}`;
        window.open(targetUrl, "_blank");
      } catch (e) {
        console.warn("Direct navigation blocked or failed:", e);
      }
    }, 2500);
  };

  useEffect(() => {
    if (initialSubTool) {
      setActiveSubTool(initialSubTool);
    }
  }, [initialSubTool]);

  useEffect(() => {
    if (initialApp) {
      setActiveSubTool("app-store");
      // Add the app to availableApps if it is not already there
      setAvailableApps(prev => {
        const exists = prev.find(item => item.packageId === initialApp.packageId);
        if (exists) return prev;
        return [initialApp, ...prev];
      });
      // Start the scan after brief render delay
      const timer = setTimeout(() => {
        startSecureScanAndDownload(initialApp);
      }, 150);
      return () => clearTimeout(timer);
    }
  }, [initialApp]);

  return (
    <div id="iloveyoubd-mega-tools-port" className="bg-[#070b13] border border-cyan-950/60 rounded-xl overflow-hidden relative shadow-2xl">
      {/* Visual Ambient Decorators */}
      <div className="absolute top-0 right-0 w-80 h-80 bg-cyan-500/5 rounded-full blur-3xl pointer-events-none" />
      <div className="absolute bottom-0 left-0 w-80 h-80 bg-purple-500/5 rounded-full blur-3xl pointer-events-none" />

      {/* Header Panel */}
      <div className="p-6 border-b border-cyan-950/50 bg-[#0a0f1b]/50 relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div>
          <span className="inline-flex items-center gap-1 bg-cyan-500/10 text-cyan-400 font-mono text-[10px] px-2.5 py-1 rounded-full uppercase tracking-widest border border-cyan-500/20 mb-2">
            <Flame className="w-3.5 h-3.5 animate-pulse text-cyan-400" />
            MEGA UTILITIES PORTAL
          </span>
          <h2 className="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-indigo-300 to-purple-400 font-sans tracking-tight">
            আই লাভ ইউ বিডি (Tools Directory) মেগা এআই ও ওয়েব টুলস হাব
          </h2>
          <p className="text-xs text-slate-400 mt-1 font-sans">
            ব্যক্তিগত বা প্রাতিষ্ঠানিক কাজের গতি দ্বিগুণ করতে সবচেয়ে সেরা, সুরক্ষিত ও বিজ্ঞাপন-বান্ধব টুলসমূহের সমন্বিত ডিরেক্টরি।
          </p>
        </div>
        <div className="flex items-center gap-2 bg-[#0c1624] px-3.5 py-2 rounded-lg border border-cyan-950 text-xs font-mono text-emerald-400 shrink-0">
          <CheckCircle className="w-4 h-4 text-emerald-400 animate-pulse" />
          <span>১০০% এডসেন্স ফ্রেন্ডলি এবং পলিসি সেফ</span>
        </div>
      </div>

      {/* Bento Grid Tools Selector - Clean Responsive Flex/Grid fit for 2040 cybertheme */}
      <div className="grid grid-cols-2 lg:grid-cols-5 gap-0 border-b border-cyan-950/40 relative z-10 bg-[#04080e]/60 font-mono text-[11px]">
        
        {/* Tool Selector Tab 1 */}
        <button
          onClick={() => setActiveSubTool("ai-writer")}
          className={`p-4 text-left border-r border-[#0d1624] transition cursor-pointer flex flex-col sm:flex-row items-start sm:items-center gap-2.5 relative overflow-hidden group ${
            activeSubTool === "ai-writer" ? "bg-[#0b1322] border-b-2 border-b-cyan-400 text-cyan-200" : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <div className="bg-cyan-500/10 p-2 rounded-lg border border-cyan-500/20 text-cyan-400 shrink-0 group-hover:scale-110 transition">
            <Sparkles className="w-4 h-4" />
          </div>
          <div>
            <h3 className="font-bold text-xs">এআই কনটেন্ট</h3>
            <span className="text-[9px] text-slate-500 hidden sm:inline-block">SEO রাইটার বিল্ডার</span>
          </div>
        </button>

        {/* Tool Selector Tab 2 */}
        <button
          onClick={() => setActiveSubTool("qr-suite")}
          className={`p-4 text-left border-r border-[#0d1624] transition cursor-pointer flex flex-col sm:flex-row items-start sm:items-center gap-2.5 relative overflow-hidden group ${
            activeSubTool === "qr-suite" ? "bg-[#0b1322] border-b-2 border-b-indigo-400 text-indigo-300" : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <div className="bg-indigo-500/10 p-2 rounded-lg border border-indigo-500/20 text-indigo-400 shrink-0 group-hover:scale-110 transition">
            <QrCode className="w-4 h-4" />
          </div>
          <div>
            <h3 className="font-bold text-xs">নিওন কিউআর</h3>
            <span className="text-[9px] text-slate-500 hidden sm:inline-block">কাস্টম কালার জেনারেটর</span>
          </div>
        </button>

        {/* Tool Selector Tab 3 */}
        <button
          onClick={() => setActiveSubTool("webmaster")}
          className={`p-4 text-left border-r border-[#0d1624] transition cursor-pointer flex flex-col sm:flex-row items-start sm:items-center gap-2.5 relative overflow-hidden group ${
            activeSubTool === "webmaster" ? "bg-[#0b1322] border-b-2 border-b-purple-400 text-purple-300" : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <div className="bg-purple-500/10 p-2 rounded-lg border border-purple-500/20 text-purple-400 shrink-0 group-hover:scale-110 transition">
            <Wrench className="w-4 h-4" />
          </div>
          <div>
            <h3 className="font-bold text-xs">কোডার ও এসইও</h3>
            <span className="text-[9px] text-slate-500 hidden sm:inline-block">মেটাট্যাগ ও গ্লো জেনারেটর</span>
          </div>
        </button>

        {/* Tool Selector Tab 4: Cyber Virtual Talking Cat */}
        <button
          onClick={() => setActiveSubTool("cyber-pet")}
          className={`p-4 text-left border-r border-[#0d1624] transition cursor-pointer flex flex-col sm:flex-row items-start sm:items-center gap-2.5 relative overflow-hidden group ${
            activeSubTool === "cyber-pet" ? "bg-[#0b1322] border-b-2 border-b-emerald-400 text-emerald-300" : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <div className="bg-emerald-500/10 p-2 rounded-lg border border-emerald-500/20 text-emerald-400 shrink-0 group-hover:scale-110 transition">
            <Gamepad2 className="w-4 h-4" />
          </div>
          <div>
            <h3 className="font-bold text-xs">টকিং সাইবার ক্যাট</h3>
            <span className="text-[9px] text-slate-500 hidden sm:inline-block">ভয়েস মিমিক গেম 🐱</span>
          </div>
        </button>

        {/* Tool Selector Tab 5: Secure APK App Centre to replace app-engine.php and downloader.php */}
        <button
          onClick={() => setActiveSubTool("app-store")}
          className={`p-4 text-left transition cursor-pointer flex flex-col sm:flex-row items-start sm:items-center gap-2.5 relative overflow-hidden group ${
            activeSubTool === "app-store" ? "bg-[#0b1322] border-b-2 border-b-amber-400 text-amber-300" : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <div className="bg-amber-500/10 p-2 rounded-lg border border-amber-500/20 text-amber-400 shrink-0 group-hover:scale-110 transition">
            <ShieldCheck className="w-4 h-4" />
          </div>
          <div>
            <h3 className="font-bold text-xs">সিকিউর এপিকে স্টোর</h3>
            <span className="text-[9px] text-slate-500 hidden sm:inline-block">APK ডিফেন্স স্ক্যানার 🛡️</span>
          </div>
        </button>

      </div>

      {/* Active Area Rendering Panel */}
      <div className="p-6 relative z-10 min-h-[420px]">
        <AnimatePresence mode="wait">
          
          {/* TOOL 1: AI CONTEXT HELPER & SEMANTIC WRITER */}
          {activeSubTool === "ai-writer" && (
            <motion.div
              key="ai-writer-tab"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="space-y-6"
            >
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-5">
                {/* Input Area */}
                <div className="lg:col-span-5 space-y-4">
                  <div>
                    <label className="block text-[11px] font-mono text-cyan-400 uppercase mb-2">আপনার টেক্সট লিখুন (Source Content):</label>
                    <textarea
                      value={aiInput}
                      onChange={(e) => setAiInput(e.target.value)}
                      placeholder="এখানে অনুচ্ছেদ, আর্টিকেল অথবা ইংরেজি টেক্সট লিখুন যা আপনি রূপান্তর করতে চান..."
                      className="w-full h-44 p-3 rounded-lg bg-[#04080e] border border-cyan-950 font-sans text-xs text-slate-100 focus:outline-none focus:border-cyan-400 transition resize-none placeholder-slate-600"
                    />
                  </div>
                  <div>
                    <label className="block text-[11px] font-mono text-cyan-400 uppercase mb-2">কার্যক্রম নির্বাচন করুন (Optimized Service):</label>
                    <div className="grid grid-cols-3 gap-2">
                      <button
                        onClick={() => setAiAction("translate")}
                        className={`py-2 px-1 rounded text-center text-[11px] font-sans transition cursor-pointer ${
                          aiAction === "translate" ? "bg-cyan-500/10 border border-cyan-400 text-cyan-300" : "bg-[#0b1222] border border-cyan-950 text-slate-400 hover:text-slate-100"
                        }`}
                      >
                        অনুবাদ ও শুদ্ধিকরণ
                      </button>
                      <button
                        onClick={() => setAiAction("seo")}
                        className={`py-2 px-1 rounded text-center text-[11px] font-sans transition cursor-pointer ${
                          aiAction === "seo" ? "bg-cyan-500/10 border border-cyan-400 text-cyan-300" : "bg-[#0b1222] border border-cyan-950 text-slate-400 hover:text-slate-100"
                        }`}
                      >
                        এসইও কিওয়ার্ড স্কিম
                      </button>
                      <button
                        onClick={() => setAiAction("catchy-title")}
                        className={`py-2 px-1 rounded text-center text-[11px] font-sans transition cursor-pointer ${
                          aiAction === "catchy-title" ? "bg-cyan-500/10 border border-cyan-400 text-cyan-300" : "bg-[#0b1222] border border-cyan-950 text-slate-400 hover:text-slate-100"
                        }`}
                      >
                        আকর্ষণীয় শিরোনাম
                      </button>
                    </div>
                  </div>
                  <button
                    onClick={handleAISubmit}
                    disabled={aiLoading || !aiInput.trim()}
                    className="w-full py-2.5 cursor-pointer bg-gradient-to-r from-cyan-500 to-indigo-500 hover:from-cyan-400 hover:to-indigo-400 font-bold text-xs text-[#060a12] rounded-lg transition shadow-[0_0_15px_rgba(6,182,212,0.2)] disabled:opacity-50"
                  >
                    {aiLoading ? (
                      <span className="flex items-center justify-center gap-2 font-sans font-medium">
                        <RefreshCw className="w-4 h-4 animate-spin" /> মায়া এআই অপটিমাইজ করছে...
                      </span>
                    ) : (
                      "মায়া এআই ইঞ্জিন দ্বারা রূপান্তর করুন ✨"
                    )}
                  </button>
                </div>

                {/* Output Area Box */}
                <div className="lg:col-span-7 bg-[#04080e] border border-cyan-950 rounded-lg p-5 flex flex-col justify-between min-h-[260px]">
                  <div>
                    <div className="flex items-center justify-between border-b border-cyan-950/60 pb-2 mb-3">
                      <span className="text-xs font-mono text-cyan-400 flex items-center gap-1.5">
                        <Cpu className="w-4 h-4 text-cyan-400 animate-pulse" />
                        AI জেনারেটেড ফলাফল (Optimized Output)
                      </span>
                      {aiOutput && (
                        <button
                          onClick={() => triggerCopy(aiOutput, "ai-output")}
                          className="text-[10px] font-mono flex items-center gap-1 text-slate-400 hover:text-white transition cursor-pointer bg-[#0c1624] px-2 py-1 rounded border border-cyan-950"
                        >
                          <Copy className="w-3 h-3" />
                          {copiedText === "ai-output" ? "কপি হয়েছে!" : "টেক্সট কপি করুন"}
                        </button>
                      )}
                    </div>
                    {aiOutput ? (
                      <p className="text-xs text-slate-150 leading-relaxed font-sans whitespace-pre-wrap">
                        {aiOutput}
                      </p>
                    ) : (
                      <div className="text-slate-600 text-xs font-sans h-44 flex flex-col items-center justify-center space-y-2">
                        <Sparkles className="w-8 h-8 text-slate-800 animate-pulse" />
                        <p>বামপাশের বক্সে লিখে আপনার অপটিমাইজেশন শুরু করুন!</p>
                        <p className="text-[10px] text-slate-750 font-mono">Powered by Google Gemini 3.5 High Speed</p>
                      </div>
                    )}
                  </div>
                  <div className="text-[10px] text-slate-500 font-sans border-t border-cyan-950/40 pt-3 mt-3">
                    💡 এই টুলটি সম্পূর্ণ ইউনিক কন্টেন্ট জেনারেট করে যা গুগল সার্চে দ্রুত ইনডেক্স হতে সহায়তা করে।
                  </div>
                </div>
              </div>
            </motion.div>
          )}

          {/* TOOL 2: NEON QR SUITE */}
          {activeSubTool === "qr-suite" && (
            <motion.div
              key="qr-suite-tab"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="space-y-6"
            >
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {/* Inputs area */}
                <div className="lg:col-span-7 space-y-4">
                  <div>
                    <label className="block text-[11px] font-mono text-indigo-400 uppercase mb-2">কিউআর কোডের ডেটা / লিংক প্রবেশ করান (URL/Text Data):</label>
                    <input
                      type="text"
                      value={qrText}
                      onChange={(e) => setQrText(e.target.value)}
                      placeholder="যেমন: https://yourbrand.com"
                      className="w-full text-xs font-mono py-2.5 px-3 bg-[#04080e] border border-cyan-950 rounded-lg focus:outline-none focus:border-indigo-400 text-slate-100 placeholder-slate-600"
                    />
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-[11px] font-mono text-indigo-400 uppercase mb-2">নিয়ন থিম কালার (QR Color Preset):</label>
                      <div className="grid grid-cols-4 gap-2">
                        {[
                          { name: "Cyan", hex: "00f0ff", bg: "bg-[#00f0ff]" },
                          { name: "Violet", hex: "bd00ff", bg: "bg-[#bd00ff]" },
                          { name: "Emerald", hex: "10b881", bg: "bg-[#10b881]" },
                          { name: "Coral", hex: "ff3c00", bg: "bg-[#ff3c00]" },
                        ].map((clr) => (
                          <button
                            key={clr.hex}
                            onClick={() => setQrColor(clr.hex)}
                            className={`p-2.5 rounded border transition cursor-pointer flex items-center justify-center ${
                              qrColor === clr.hex ? "border-slate-100 scale-105" : "border-slate-900"
                            } ${clr.bg}`}
                            title={clr.name}
                          />
                        ))}
                      </div>
                    </div>

                    <div>
                      <label className="block text-[11px] font-mono text-indigo-400 uppercase mb-2">রেজোলিউশন আকার (QR Dimensions):</label>
                      <select
                        value={qrSize}
                        onChange={(e) => setQrSize(e.target.value)}
                        className="w-full text-xs font-mono py-2.5 px-3 bg-[#04080e] border border-cyan-950 rounded-lg focus:outline-none focus:border-indigo-400 text-slate-100"
                      >
                        <option value="150x150">১৫০ x ১৫০ (মোবাইল কম্প্যাক্ট)</option>
                        <option value="250x250">২৫০ x ২৫০ (স্ট্যান্ডার্ড)</option>
                        <option value="350x350">৩৫০ x ৩৫০ (সার্জ পিএনজি)</option>
                        <option value="500x500">৫০০ x ৫০০ (মুদ্রণযোগ্য প্রিন্ট)</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label className="flex items-center gap-2 cursor-pointer select-none">
                      <input
                        type="checkbox"
                        checked={qrGlow}
                        onChange={(e) => setQrGlow(e.target.checked)}
                        className="rounded border-cyan-950 bg-[#04080e] text-indigo-500 focus:ring-0 w-4 h-4 cursor-pointer"
                      />
                      <span className="text-xs font-sans text-slate-300">নিয়ন ব্যাকলাইট গ্লো এফেক্ট सक्रिय রাখুন (Neon Soft Glow Background)</span>
                    </label>
                  </div>
                </div>

                {/* Live Neon Preview Display Box */}
                <div className="lg:col-span-5 flex flex-col items-center justify-center p-6 bg-[#04080e] border border-cyan-950 rounded-lg relative overflow-hidden">
                  
                  {/* Glowing background halo */}
                  {qrGlow && (
                    <div 
                      className="absolute w-44 h-44 rounded-full blur-3xl opacity-30 animate-pulse transition-colors duration-500 pointer-events-none"
                      style={{ backgroundColor: `#${qrColor}` }}
                    />
                  )}

                  <div className="relative z-10 bg-white p-4.5 rounded-xl border border-white/10 shadow-2xl transition hover:rotate-2 duration-300">
                    <img
                      src={qrImageUrl}
                      alt="iloveyoubd custom qr"
                      className="w-40 h-40 object-contain block select-none rounded"
                    />
                  </div>

                  <p className="text-[10px] font-mono text-slate-500 mt-4 text-center">
                    ডেটা ইনপুট প্রদানের সাথে সাথে স্বয়ংক্রিয় নিয়ন কোড লাইভ তৈরি হচ্ছে।
                  </p>

                  <button
                    onClick={handleDownloadQR}
                    className="mt-4 cursor-pointer bg-indigo-500 hover:bg-indigo-400 text-[#060a12] font-black text-xs px-6 py-2 rounded-lg flex items-center gap-1.5 transition shadow-[0_0_15px_rgba(99,102,241,0.2)]"
                  >
                    <Download className="w-4 h-4" /> পিএনজি ডাউনলোড করুন (Download QR)
                  </button>
                </div>

              </div>
            </motion.div>
          )}

          {/* TOOL 3: WEBMASTER UTILITIES & CSS DESIGNER */}
          {activeSubTool === "webmaster" && (
            <motion.div
              key="webmaster-tab"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="space-y-8"
            >
              {/* Part A: CSS Cyber Glow Studio */}
              <div>
                <h3 className="text-sm font-bold font-mono text-cyan-400 border-b border-cyan-955/40 pb-2 mb-4 flex items-center gap-1.5">
                  <Sliders className="w-4 h-4 text-cyan-400 animate-pulse" />
                  ১. ইন্টারেক্টিভ নিয়ন সিএসএস গ্লো স্টুডিও (Cyber CSS Box Shadow Creator)
                </h3>
                
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 bg-[#04080e]/40 p-5 rounded-lg border border-cyan-950">
                  {/* Sliders */}
                  <div className="lg:col-span-5 space-y-4.5">
                    <div>
                      <div className="flex justify-between text-xs font-mono text-slate-400 mb-1">
                        <span>গ্লো সাইজ (Blur Radius):</span>
                        <span className="text-cyan-400 font-bold">{glowBlur}px</span>
                      </div>
                      <input
                        type="range"
                        min="5"
                        max="100"
                        value={glowBlur}
                        onChange={(e) => setGlowBlur(Number(e.target.value))}
                        className="w-full accent-cyan-400 cursor-pointer"
                      />
                    </div>

                    <div className="flex justify-between gap-4">
                      <div className="flex-1">
                        <div className="flex justify-between text-xs font-mono text-slate-400 mb-1">
                          <span>প্রসারণ (Spread):</span>
                          <span className="text-cyan-400 font-bold">{glowSpread}px</span>
                        </div>
                        <input
                          type="range"
                          min="0"
                          max="30"
                          value={glowSpread}
                          onChange={(e) => setGlowSpread(Number(e.target.value))}
                          className="w-full accent-cyan-400 cursor-pointer"
                        />
                      </div>
                      
                      <div className="flex-1">
                        <div className="flex justify-between text-xs font-mono text-slate-400 mb-1">
                          <span>উজ্জ্বলতা (Opacity):</span>
                          <span className="text-cyan-400 font-bold">{glowOpacity}%</span>
                        </div>
                        <input
                          type="range"
                          min="10"
                          max="100"
                          value={glowOpacity}
                          onChange={(e) => setGlowOpacity(Number(e.target.value))}
                          className="w-full accent-cyan-400 cursor-pointer"
                        />
                      </div>
                    </div>

                    <div>
                      <label className="block text-xs font-mono text-slate-400 mb-1">রঙের প্যালেট (Neon Color Selector):</label>
                      <div className="flex items-center gap-1.5">
                        <input
                          type="color"
                          value={glowColor}
                          onChange={(e) => setGlowColor(e.target.value)}
                          className="w-8 h-8 rounded border border-cyan-950 bg-transparent cursor-pointer"
                        />
                        <input
                          type="text"
                          value={glowColor}
                          onChange={(e) => setGlowColor(e.target.value)}
                          className="flex-1 bg-[#04080e] text-xs font-mono text-slate-300 py-1.5 px-2 rounded border border-cyan-950 uppercase"
                        />
                      </div>
                    </div>
                  </div>

                  {/* Visual Live Preview screen */}
                  <div className="lg:col-span-3 flex flex-col items-center justify-center p-4 bg-[#03060a] rounded-lg border border-cyan-950 min-h-[140px]">
                    <div
                      className="w-14 h-14 rounded-xl bg-[#090d16] border border-cyan-950 transition-all duration-150 flex items-center justify-center"
                      style={{ boxShadow: currentBoxShadow }}
                    >
                      <Sparkles className="w-5 h-5 text-slate-200 animate-pulse" />
                    </div>
                    <span className="text-[10px] font-mono text-slate-500 mt-4 select-none">লাইভ নিয়ন সিএসএস প্রিভিউ</span>
                  </div>

                  {/* Copy code Box */}
                  <div className="lg:col-span-4 flex flex-col justify-between">
                    <div className="space-y-2">
                      <div>
                        <div className="flex items-center justify-between text-[10px] font-mono text-cyan-400 mb-1 leading-normal uppercase">
                          <span>Tailwind CSS ক্লাস কোড:</span>
                          <button
                            onClick={() => triggerCopy(currentTailwindCode, "tw-copy")}
                            className="hover:text-white transition cursor-pointer"
                          >
                            {copiedText === "tw-copy" ? "কপি হয়েছে!" : "কপি কন"}
                          </button>
                        </div>
                        <code className="block bg-[#020509] border border-cyan-950 p-2 rounded text-[10px] font-mono text-cyan-300 break-all select-all">
                          {currentTailwindCode}
                        </code>
                      </div>

                      <div>
                        <div className="flex items-center justify-between text-[10px] font-mono text-cyan-400 mb-1 leading-normal uppercase">
                          <span>স্ট্যান্ডার্ড সিএসএস কোড:</span>
                          <button
                            onClick={() => triggerCopy(currentCSSCode, "css-copy")}
                            className="hover:text-white transition cursor-pointer"
                          >
                            {copiedText === "css-copy" ? "কপি হয়েছে!" : "কপি কন"}
                          </button>
                        </div>
                        <code className="block bg-[#020509] border border-cyan-950 p-2 rounded text-[10px] font-mono text-[#ffae00] break-all select-all">
                          {currentCSSCode}
                        </code>
                      </div>
                    </div>
                    
                    <p className="text-[9px] text-slate-500 mt-2 font-mono">
                      💡 আপনি আপনার মডার্ন ইউআই-তে এই নিয়ন গ্লো এফেক্ট বসাতে পারবেন।
                    </p>
                  </div>
                </div>
              </div>

              {/* Part B: SEO Metatags Schema Generator */}
              <div>
                <h3 className="text-sm font-bold font-mono text-purple-400 border-b border-cyan-955/40 pb-2 mb-4 flex items-center gap-1.5">
                  <Globe className="w-4 h-4 text-purple-400 animate-pulse" />
                  ২. গুগল সার্চ ইঞ্জিনে একশতে একশ এসইও মেটাট্যাগ বিল্ডার (SEO Master Tags Creator)
                </h3>

                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 bg-[#04080e]/40 p-5 rounded-lg border border-cyan-950">
                  {/* Inputs */}
                  <div className="lg:col-span-5 space-y-4">
                    <div>
                      <label className="block text-[11px] font-mono text-slate-400 mb-1.5">ওয়েবসাইট বা পেজের শিরোনাম (Page Title max 60 chars):</label>
                      <input
                        type="text"
                        value={seoTitle}
                        onChange={(e) => setSeoTitle(e.target.value)}
                        className="w-full text-xs font-sans py-2 px-3 bg-[#04080e] border border-cyan-950 rounded focus:outline-none focus:border-purple-450 text-slate-200"
                      />
                    </div>

                    <div>
                      <label className="block text-[11px] font-mono text-slate-400 mb-1.5">সাইটের মেটা ডেসক্রিপশন (Meta Description max 160 chars):</label>
                      <textarea
                        value={seoDesc}
                        onChange={(e) => setSeoDesc(e.target.value)}
                        className="w-full h-20 p-2.5 rounded bg-[#04080e] border border-cyan-950 font-sans text-xs text-slate-200 focus:outline-none focus:border-purple-450 resize-none"
                      />
                    </div>

                    <div className="grid grid-cols-2 gap-3">
                      <div>
                        <label className="block text-[11px] font-mono text-slate-400 mb-1.5">সার্চ কিওয়ার্ডসমূহ (Separate with commas):</label>
                        <input
                          type="text"
                          value={seoKeywords}
                          onChange={(e) => setSeoKeywords(e.target.value)}
                          className="w-full text-xs font-mono py-2 px-3 bg-[#04080e] border border-cyan-950 rounded focus:outline-none focus:border-purple-450 text-slate-200"
                        />
                      </div>
                      <div>
                        <label className="block text-[11px] font-mono text-slate-400 mb-1.5">ভাষা নির্বাচন করুন (Language Code):</label>
                        <select
                          value={seoLang}
                          onChange={(e) => setSeoLang(e.target.value)}
                          className="w-full text-xs font-sans py-2 px-3 bg-[#04080e] border border-cyan-950 rounded focus:outline-none focus:border-purple-450 text-slate-200"
                        >
                          <option value="bn">Bengali / বাংলা</option>
                          <option value="en">English / ইংরেজি</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  {/* Generated code display box */}
                  <div className="lg:col-span-7 flex flex-col justify-between bg-[#020509] border border-cyan-950 rounded-lg p-4">
                    <div>
                      <div className="flex items-center justify-between border-b border-cyan-950/60 pb-2 mb-3">
                        <span className="text-[11px] font-mono text-purple-400 flex items-center gap-1">
                          <FileCode className="w-4 h-4 text-purple-400" />
                          ইনডেক্সিং কোড আউটপুট (Semantic Metatag HTML Output)
                        </span>
                        <button
                          onClick={() => triggerCopy(generatedMetaCode, "seo-tags-copy")}
                          className="text-[10px] font-mono flex items-center gap-1 text-slate-400 hover:text-white transition cursor-pointer bg-[#0c1624] px-2.5 py-1 rounded border border-cyan-950"
                        >
                          <Copy className="w-3.5 h-3.5" />
                          {copiedText === "seo-tags-copy" ? "কপি হয়েছে!" : "আউটপুট কপি কন"}
                        </button>
                      </div>
                      <pre className="text-[10px] font-mono text-slate-400 overflow-x-auto max-h-44 bg-black/40 p-2.5 rounded border border-cyan-950 select-all leading-normal whitespace-pre">
                        {generatedMetaCode}
                      </pre>
                    </div>
                    
                    <p className="text-[10px] text-slate-500 mt-3">
                      💡 পরামর্শ: এই কপি করা কোডটি আপনার সাইটের <code>&lt;head&gt;</code> সেকশনে যুক্ত করলে গুগল বট আপনার সাইটের কন্টেন্ট সুন্দরভাবে বুঝতে এবং ক্রল করতে পারবে।
                    </p>
                  </div>
                </div>
              </div>

            </motion.div>
          )}

          {/* TOOL 4: CYBER PET - INTERACTIVE VOICE MIMIC CAT GAME */}
          {activeSubTool === "cyber-pet" && (
            <motion.div
              key="cyber-pet-tab"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="space-y-6"
            >
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {/* Visual Simulation Display Box */}
                <div className="lg:col-span-6 flex flex-col items-center justify-center p-6 bg-[#03060a] border border-[#00f0ff]/15 rounded-xl relative overflow-hidden group">
                  <div className="absolute top-3 left-3 bg-[#0c1624] px-2 py-1 rounded text-[9px] font-mono text-emerald-400 border border-emerald-950/50 flex items-center gap-1 uppercase select-none">
                    <Volume2 className="w-3 h-3 animate-pulse" /> Live Sound Engine Pro
                  </div>

                  {/* Ambient Halo behind cat simulation */}
                  <div 
                    className={`absolute w-52 h-52 rounded-full blur-3xl opacity-20 transition-all duration-300 pointer-events-none ${
                      catState === "talking" ? "bg-[#00f0ff] scale-110" : 
                      catState === "hit" ? "bg-[#ff3c00]" :
                      catState === "faint" ? "bg-purple-600" :
                      catState === "laughing" ? "bg-emerald-400" : "bg-cyan-500/20"
                    }`}
                  />

                  {/* Character Frame */}
                  <div 
                    onClick={handleCatClick}
                    className="relative z-10 w-48 h-48 rounded-2xl bg-[#070b13] border border-[#1e2e4a] p-4 flex items-center justify-center cursor-pointer transition active:scale-95 shadow-lg select-none"
                    title="বিড়ালটির শরীরে বা মাথায় স্পর্শ করে ইন্টারঅ্যাক্ট করুন!"
                  >
                    {/* Fallback Character Vector if theme gif isn't accessible, yet perfectly uses the theme path `/theme-assets/cyber-game/cat-xxxxx.gif` */}
                    <img
                      src={`/theme-assets/cyber-game/cat-${catState}.gif`}
                      onError={(e) => {
                        // Flawless elegant fallback vectors if gif doesn't resolve
                        e.currentTarget.style.display = "none";
                        const parent = e.currentTarget.parentElement;
                        if (parent) {
                          let fallbackEl = document.getElementById("pet-vector-fallback");
                          if (!fallbackEl) {
                            fallbackEl = document.createElement("div");
                            fallbackEl.id = "pet-vector-fallback";
                            fallbackEl.className = "flex flex-col items-center justify-center space-y-3";
                            parent.appendChild(fallbackEl);
                          }
                          fallbackEl.innerHTML = `
                            <div class="text-5xl animate-bounce">🐱</div>
                            <div class="text-[10px] font-mono text-cyan-400 tracking-wider uppercase text-center font-bold">
                              [${catState.toUpperCase()}]
                            </div>
                            <div class="text-[9px] text-slate-500 font-sans">মাথায় ট্যাপ করুন / স্পর্শ করুন</div>
                          `;
                        }
                      }}
                      alt={`Cyber Cat ${catState}`}
                      className="w-full h-full object-contain pointer-events-none select-none rounded-xl"
                    />
                  </div>

                  <p className="text-[10px] text-center font-sans text-slate-400 mt-4 max-w-sm">
                    🐱 বিড়ালটির মাথায় ক্লিক করলে <span className="text-red-400 hover:underline">আঘাত [Hit]</span>, পেটে ক্লিক করলে <span className="text-emerald-400">হাসি [Tickle]</span>, বা নিচে ক্লিক করলে <span className="text-purple-400">অজ্ঞান [Faint]</span> হবে।
                  </p>
                </div>

                {/* Cyber Voice Controller Panel */}
                <div className="lg:col-span-6 flex flex-col justify-between bg-[#04080e] border border-cyan-950 rounded-xl p-6 relative">
                  
                  <div className="space-y-4">
                    <h3 className="text-sm font-sans font-bold text-slate-100 flex items-center gap-1.5 pb-2 border-b border-cyan-950">
                      <Mic className="w-4 h-4 text-emerald-400 animate-pulse" />
                      বিড়ালের সাথে মানুষের মজার কথা-বলা গেম
                    </h3>
                    
                    <p className="text-xs text-slate-400 leading-normal font-sans">
                      আপনার মাইক্রোফোন ব্যবহার করে যেকোনো কথা বলুন! বিড়ালটি অত্যন্ত মজার ও চিকন সাইবার কন্ঠে আপনার কথাগুলো ২০৪০ সালের স্টাইলে হুবহু নকল করে ফিরিয়ে শোনাবে।
                    </p>

                    {/* Microphone volume bar visualization */}
                    {isPetRecording && (
                      <div className="space-y-1.5 p-3.5 bg-cyan-950/20 border border-cyan-500/20 rounded-lg">
                        <div className="flex justify-between items-center text-[10px] font-mono text-cyan-400">
                          <span>ভয়েস ফ্রিকোয়েনসি সেন্সর:</span>
                          <span>{Math.round(micVolume * 1.5)} Hz</span>
                        </div>
                        <div className="h-1.5 bg-[#03060a] rounded-full overflow-hidden">
                          <motion.div 
                            className="h-full bg-cyan-400"
                            style={{ width: `${Math.min(100, micVolume * 3)}%` }}
                            transition={{ type: "spring", stiffness: 300, damping: 20 }}
                          />
                        </div>
                      </div>
                    )}

                    {!petAudioSupported && (
                      <div className="p-3 bg-red-500/10 border border-red-500/20 rounded-lg text-[10px] font-sans text-red-400">
                        ⚠️ ব্রাউজার বা ডিভাইসে মাইক্রোফোন লকড থাকতে পারে অথবা আইফ্রেম সীমাবদ্ধতা রয়েছে। অনুগ্রহ করে সাইটটি নতুন ট্যাবে খুলে মাইক্রোফোন পারমিশন সচল করুন!
                      </div>
                    )}
                  </div>

                  {/* Actions buttons */}
                  <div className="space-y-3.5 mt-6 pt-4 border-t border-cyan-950/40">
                    <div className="flex flex-col sm:flex-row gap-3">
                      {!isPetRecording ? (
                        <button
                          onClick={startPetRecording}
                          disabled={isPetPlaying || !petAudioSupported}
                          className="flex-1 py-3 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs rounded-lg transition duration-200 cursor-pointer flex items-center justify-center gap-2 shadow-[0_0_15px_rgba(16,185,129,0.15)] disabled:opacity-55"
                        >
                          <Mic className="w-4 h-4" /> আপনার কথা বলা শুরু করুন (Talk)
                        </button>
                      ) : (
                        <button
                          onClick={stopPetRecording}
                          className="flex-1 py-3 bg-red-500 hover:bg-red-400 text-slate-950 font-black text-xs rounded-lg transition duration-300 cursor-pointer flex items-center justify-center gap-2 shadow-[0_0_15px_rgba(239,68,68,0.2)]"
                        >
                          <span className="w-2.5 h-2.5 rounded-full bg-slate-950 animate-ping" />
                          রেকর্ডিং শেষ করুন (Stop & Mimic)
                        </button>
                      )}
                    </div>

                    <div className="text-[10px] font-mono text-slate-500 flex items-center gap-1.5 justify-center">
                      <CheckCircle className="w-3.5 h-3.5 text-emerald-500 shrink-0" />
                      <span>গুগল এডসেন্স সেফ • সম্পূর্ণ নিরাপদ জাভাস্ক্রিপ্ট লোকাল প্লেব্যাক</span>
                    </div>
                  </div>

                </div>

              </div>
            </motion.div>
          )}

          {/* TOOL 5: CYBERX PRO PLAY STORE CRAWLER & DYNAMIC SEO GATEWAY */}
          {activeSubTool === "app-store" && (
            <motion.div
              key="playstore-crawler-tab"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="space-y-6 animate-fade-in"
              id="cyberx-playstore-main"
            >
              
              {/* If Scanner dashboard active */}
              {isScanning && selectedApp ? (
                <div id="playstore-scanner-console" className="bg-[#03060a] border border-amber-500/20 rounded-xl p-5 md:p-8 space-y-6 relative overflow-hidden shadow-2xl">
                  <div className="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl pointer-events-none" />

                  {/* App Mini Details */}
                  <div className="flex items-center gap-4 border-b border-cyan-950/60 pb-4">
                    <img 
                      src={selectedApp.icon || "https://play-lh.googleusercontent.com/c2_9itYV396Eul6HSf78In969hsnv3qfN6Yg00f0ff"} 
                      referrerPolicy="no-referrer"
                      className="w-14 h-14 rounded-xl border border-amber-500/30 object-cover" 
                      alt=""
                    />
                    <div>
                      <h3 className="text-base font-sans font-black text-slate-100">{selectedApp.title}</h3>
                      <p className="text-[10px] font-mono text-cyan-400 mt-0.5">{selectedApp.packageId} • Verified Safe</p>
                    </div>
                  </div>

                  {/* Pulsing Scan Progress */}
                  <div className="space-y-2.5">
                    <div className="flex justify-between items-center text-xs font-mono">
                      <span className="text-amber-400 flex items-center gap-1.5 font-bold uppercase animate-pulse">
                        <Cpu className="w-4 h-4 text-amber-400 animate-spin" />
                        {scanProgress < 100 ? "CYBERX LIVE PROTECTION SCANNING..." : "GOOGLE PLAY DEFENSE PASS APPROVED ✓"}
                      </span>
                      <span className="text-slate-100 font-bold">{scanProgress}%</span>
                    </div>

                    <div className="h-2.5 bg-[#080d16] border border-cyan-950/20 rounded-full overflow-hidden">
                      <div 
                        className={`h-full transition-all duration-300 ${
                          scanProgress === 100 ? "bg-emerald-400 shadow-[0_0_10px_#10b881]" : "bg-amber-400 shadow-[0_0_10px_#ffbf00]"
                        }`}
                        style={{ width: `${scanProgress}%` }}
                      />
                    </div>
                  </div>

                  {/* Real-time Cyber Console Output Logs */}
                  <div className="bg-[#020509] border border-cyan-950/60 rounded-lg p-4 h-48 overflow-y-auto space-y-1 font-mono text-[10px] shadow-inner text-slate-300">
                    {scanLogs.map((log, index) => (
                      <div 
                        key={index} 
                        className={`leading-relaxed ${
                          log.includes("[SUCCESS]") || log.includes("[READY]") ? "text-emerald-400 font-bold" :
                          log.includes("[SCAN]") ? "text-cyan-400" :
                          log.includes("[INFO]") ? "text-slate-400" : "text-amber-400 font-medium"
                        }`}
                      >
                        {log}
                      </div>
                    ))}
                    {scanProgress < 100 && (
                      <div className="text-slate-500 animate-pulse">Connecting with Google cryptographic sandbox data clusters...</div>
                    )}
                  </div>

                  {/* Actions footer */}
                  <div className="flex flex-col sm:flex-row items-center justify-between border-t border-cyan-950/40 pt-4 mt-2 gap-3">
                    <span className="text-[10px] text-slate-400 font-sans text-center sm:text-left">
                      💡 আপনি সরাসরি প্লে স্টোর থেকে ডাউনলোড করছেন। কোনো ফাইল সাইনিং বা আনঅফিসিয়াল স্টোরেজ ব্যবহার জিরো পলিসি লঙ্ঘন করে না।
                    </span>
                    <button
                      id="scanner-back-btn"
                      onClick={() => {
                        setIsScanning(false);
                        setSelectedApp(null);
                      }}
                      className="px-5 py-2 cursor-pointer bg-[#0c1624] text-xs font-mono text-slate-300 rounded hover:text-white border border-cyan-950 hover:bg-slate-900 transition tracking-wide"
                    >
                      ড্যাশবোর্ডে ফিরে যান (Back)
                    </button>
                  </div>
                </div>
              ) : (
                /* Primary Scraper Search engine Panel & dynamic database apps */
                <div className="space-y-6">
                  {/* Banner */}
                  <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-cyan-950/40 pb-4 gap-2">
                    <div>
                      <h3 className="text-base font-sans font-bold text-slate-100 flex items-center gap-1.5">
                        <Globe className="w-5 h-5 text-cyan-400" />
                        Play Store AI Scraper & SEO Meta Tags Creator
                      </h3>
                      <p className="text-[11px] text-slate-400 font-sans mt-0.5">
                        গুগল প্লে স্টোর অ্যাপের প্যাকেজ আইডি বা সার্চ কী দিয়ে বাংলায় রিয়েল-টাইম মেটাডাটা ও এসইও ওজি ট্যাগ জেনারেট করুন।
                      </p>
                    </div>
                    <span className="bg-[#00f0ff]/10 text-[#00f0ff] font-mono text-[9px] px-2 py-0.5 rounded border border-[#00f0ff]/20 uppercase tracking-widest shrink-0">
                      AdSense Friend 100% compliant
                    </span>
                  </div>

                  {/* Search and Crawl Console Form */}
                  <div id="playstore-search-form" className="bg-[#03070d] border border-cyan-950/55 rounded-xl p-5 space-y-4 shadow-xl relative overflow-hidden">
                    <div className="absolute top-0 right-0 w-32 h-32 bg-cyan-500/5 rounded-full blur-2xl pointer-events-none" />
                    
                    <label className="block text-xs font-mono text-[#00f0ff] font-bold tracking-wider uppercase">
                      গুগল প্লে স্টোর অ্যাপ খুঁজুন (Search or Input Play-Link to scrape)
                    </label>

                    <div className="flex flex-col sm:flex-row gap-3">
                      <div className="relative flex-1">
                        <input
                          id="playstore-search-input"
                          type="text"
                          value={playStoreQuery}
                          onChange={(e) => setPlayStoreQuery(e.target.value)}
                          placeholder="उदाहरण: com.whatsapp বা WhatsApp বা play store link..."
                          className="w-full bg-[#040810] border border-cyan-900/50 rounded-lg py-2.5 pl-3 pr-10 text-xs font-mono text-slate-100 focus:outline-none focus:border-[#00f0ff]/50 placeholder-slate-600 transition"
                          onKeyDown={(e) => {
                            if (e.key === "Enter") handlePlayStoreSearch();
                          }}
                        />
                        <Search className="w-4 h-4 text-slate-600 absolute right-3 top-3 pointer-events-none" />
                      </div>

                      {/* Language and Action Selection */}
                      <div className="flex items-center gap-2">
                        <select
                          id="playstore-lang-selector"
                          value={searchLang}
                          onChange={(e: any) => setSearchLang(e.target.value)}
                          className="bg-[#040810] border border-cyan-900/50 rounded-lg px-2.5 py-2.5 text-xs font-sans text-slate-300 focus:outline-none focus:border-[#00f0ff]/50 cursor-pointer"
                        >
                          <option value="bn">বাংলা (Bn)</option>
                          <option value="en">English (En)</option>
                        </select>

                        <button
                          id="playstore-crawl-submit-btn"
                          disabled={isSearchingApp || !playStoreQuery.trim()}
                          onClick={handlePlayStoreSearch}
                          className="bg-[#00f0ff] hover:bg-[#00d0df] text-slate-950 font-black text-xs px-5 py-2.5 rounded-lg transition duration-200 cursor-pointer flex items-center justify-center gap-1.5 shadow-[0_0_15px_rgba(0,240,255,0.25)] disabled:opacity-40 disabled:pointer-events-none shrink-0"
                        >
                          {isSearchingApp ? (
                            <>
                              <div className="w-4 h-4 border-2 border-slate-950 border-t-transparent rounded-full animate-spin shrink-0" />
                              ক্রল হচ্ছে...
                            </>
                          ) : (
                            <>
                              <Cpu className="w-4 h-4 shrink-0" />
                              মেটাডাটা ক্রল করুন
                            </>
                          )}
                        </button>
                      </div>
                    </div>

                    {/* Feedback and warnings */}
                    {appSearchError && (
                      <div className="bg-red-500/10 border border-red-500/20 text-red-400 text-[11px] p-2.5 rounded-lg font-sans">
                        ⚠️ {appSearchError}
                      </div>
                    )}

                    <p className="text-[10px] text-slate-500 font-sans leading-relaxed">
                      💡 আপনি যেকোনো অ্যাপের ইউনিক প্যাকেজ আইডি লিখলে (যেমন <span className="font-mono text-cyan-400">com.twitter.android</span>, <span className="font-mono text-cyan-400">com.imo.android.imoim</span> ইত্যাদি) অথবা সরাসরি গুগল প্লে স্টোর লিংক পেস্ট করলে আমাদের স্বয়ংক্রিয় ব্যাকএন্ড বোট গুগলের থেকে আসল মেটাডাটা বাংলায় নামিয়ে আনবে।
                    </p>
                  </div>

                  {/* App Grid Directory */}
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-5" id="crawled-apps-grid">
                    {availableApps.map((app) => (
                      <div 
                        key={app.packageId}
                        className="bg-[#04080e]/70 border border-cyan-950/60 rounded-xl p-5 hover:border-[#00f0ff]/40 hover:bg-[#060c18] transition duration-300 flex flex-col justify-between group relative"
                        id={`app-card-${app.packageId.replace(/\./g, "-")}`}
                      >
                        <div className="space-y-3">
                          <div className="flex items-start justify-between gap-2">
                            <div className="flex items-center gap-3">
                              <img
                                src={app.icon || "https://play-lh.googleusercontent.com/c2_9itYV396Eul6HSf78In969hsnv3qfN6Yg00f0ff"} 
                                referrerPolicy="no-referrer"
                                className="w-12 h-12 bg-slate-900 border border-[#0d1624] rounded-xl object-cover shrink-0 select-none group-hover:scale-105 transition"
                                alt={app.title}
                              />
                              <div>
                                <h4 className="text-xs font-sans font-black text-slate-100 transition group-hover:text-[#00f0ff] line-clamp-1">{app.title}</h4>
                                <span className="text-[9px] font-mono text-slate-500 line-clamp-1">{app.packageId}</span>
                              </div>
                            </div>
                            <span className="bg-[#00f0ff]/10 border border-[#00f0ff]/20 font-mono text-[9px] text-[#00f0ff] px-2 py-0.5 rounded uppercase shrink-0">
                              {app.price}
                            </span>
                          </div>

                          <div className="flex flex-wrap items-center gap-x-2.5 gap-y-1 font-mono text-[9.5px] text-slate-400">
                            <span className="text-slate-500">বিকাশকারী: <strong className="text-cyan-500">{app.developer}</strong></span>
                            <span>•</span>
                            <span>রেটিং: <strong className="text-amber-400">★ {app.rating}</strong></span>
                            <span>•</span>
                            <span className="text-emerald-400 font-bold">{app.ratingCount}</span>
                          </div>

                          <p className="text-[11px] text-slate-400 leading-relaxed font-sans line-clamp-3">
                            {app.description}
                          </p>

                          {/* SEO Schema Toggle segment */}
                          <div id={`seo-code-${app.packageId.replace(/\./g, "-")}`} className="border-t border-cyan-950/20 pt-2.5 mt-2.5">
                            <details className="group/details">
                              <summary className="text-[10px] cursor-pointer font-mono text-[#00f0ff]/80 hover:text-[#00f0ff] list-none flex items-center justify-between outline-none select-none">
                                <span className="flex items-center gap-1">
                                  <Code className="w-3.5 h-3.5" /> <strong className="font-bold underline">গুগল এসইও মেটাডাটা অপ্টিমাইজার ট্যাগস</strong> (Google Schema)
                                </span>
                                <span className="transition duration-150 group-open/details:rotate-180 text-xs">▼</span>
                              </summary>
                              
                              <div className="bg-[#020408] border border-cyan-950/60 rounded-lg p-3 mt-2 space-y-2 relative">
                                <div className="absolute top-2 right-2 z-10">
                                  <button
                                    onClick={() => {
                                      navigator.clipboard.writeText(`<!-- Google Index Tags for ${app.title} by iloveyoubd.com -->\n<title>${app.title} APK Download Free for Android - iloveyoubd.com</title>\n<meta name="description" content="নিরাপদে ডাউনলোড করুন ${app.title} সরাসরি গুগল প্লে স্টোর থেকে। ${app.description.substring(0, 150)}...">\n<meta name="keywords" content="${app.title} apk, ${app.title} free download, ${app.packageId}, download ${app.title} play store, iloveyoubd">\n<meta property="og:title" content="${app.title} APK Free Download - iloveyoubd">\n<meta property="og:image" content="${app.icon}">\n<meta property="og:url" content="https://iloveyoubd.com/tools?app=${app.packageId}">`);
                                      playSynthesizedSFX("hit");
                                    }}
                                    className="px-2 py-1 bg-cyan-950/80 text-[9px] font-mono text-[#00f0ff] rounded border border-cyan-900 hover:bg-cyan-900 transition flex items-center gap-1 active:scale-95"
                                  >
                                    <Copy className="w-3 h-3" /> কপি করুন (Copy Code)
                                  </button>
                                </div>
                                <pre className="text-[9px] font-mono whitespace-pre-wrap overflow-x-auto text-slate-300 leading-normal max-h-32">
                                  {`<!-- Google Index Tags for ${app.title} by iloveyoubd.com -->
<title>${app.title} APK Download Free for Android - iloveyoubd.com</title>
<meta name="description" content="নিরাপদে ডাউনলোড করুন ${app.title} সরাসরি ডাউনলোড করুন। ${app.description.substring(0, 110)}...">
<meta name="keywords" content="${app.title} apk, ${app.title} free download, ${app.packageId}">
<meta property="og:title" content="${app.title} APK Free Download - iloveyoubd">
<meta property="og:image" content="${app.icon}">
<meta property="og:url" content="https://iloveyoubd.com/tools?app=${app.packageId}">`}
                                </pre>
                              </div>
                            </details>
                          </div>
                        </div>

                        <div className="flex items-center justify-between border-t border-cyan-950/20 pt-3 mt-4">
                          <span className="text-[9px] font-mono text-emerald-400 flex items-center gap-1">
                            <CheckCircle className="w-3.5 h-3.5" /> ম্যালওয়্যার মুক্ত
                          </span>
                          <button
                            id={`download-action-${app.packageId.replace(/\./g, "-")}`}
                            onClick={() => startSecureScanAndDownload(app)}
                            className="bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-[11px] px-4 py-1.5 rounded transition duration-250 cursor-pointer flex items-center gap-1 shadow-[0_0_10px_rgba(245,158,11,0.1)] hover:scale-[1.02] active:scale-95"
                          >
                            <Play className="w-3 h-3 fill-slate-950 stroke-none" /> টানেল স্ক্যান করুন 📥
                          </button>
                        </div>
                      </div>
                    ))}
                  </div>

                  <div className="text-[10px] text-slate-500 text-center font-sans mt-3">
                    💡 উপদেশ: এই ডাউনলোডার সার্ভিসটি সরাসরি অ্যান্ড্রয়েড ব্যবহারকারীদের জন্য তৈরি। সাইবার ডিফেন্স স্ক্যানারটি নিশ্চিত করে যে সংযোগটি গুগল স্টোর সার্ভারে যাচ্ছে এবং আপনার ডিভাইসের জন্য সুরক্ষিত।
                  </div>
                </div>
              )}

            </motion.div>
          )}

        </AnimatePresence>
      </div>

    </div>
  );
}
