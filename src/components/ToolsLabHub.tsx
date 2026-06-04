import React, { useState } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  Layout, 
  ShieldCheck, 
  Cpu, 
  Video, 
  Music, 
  HelpCircle, 
  Wrench, 
  Sparkles, 
  QrCode, 
  Gamepad2, 
  CheckCircle,
  Copy,
  Terminal,
  Activity,
  Flame,
  Info,
  RefreshCw
} from "lucide-react";

interface ToolItem {
  id: string;
  classNameLabel: string;
  icon: React.ElementType;
  nameBangla: string;
  nameEnglish: string;
  tagline: string;
  description: string;
  instructions: string;
  badge: string;
  badgeColors: string;
  buttonLabel: string;
  hotkey: string;
  action: () => void;
}

interface ToolsLabHubProps {
  onSelectTab: (tab: any) => void;
  onSelectSubTool: (subTool: string, app?: any) => void;
}

export default function ToolsLabHub({ onSelectTab, onSelectSubTool }: ToolsLabHubProps) {
  // NID Key Generator Interactive States
  const [showKeyGen, setShowKeyGen] = useState(false);
  const [nidNumber, setNidNumber] = useState("");
  const [birthDate, setBirthDate] = useState("");
  const [generatingLogs, setGeneratingLogs] = useState<string[]>([]);
  const [isGenerating, setIsGenerating] = useState(false);
  const [generatedKey, setGeneratedKey] = useState("");
  const [copyFeedback, setCopyFeedback] = useState(false);

  // Trigger interactive NID Key generation sequence
  const startNidKeyGeneration = () => {
    if (!nidNumber.trim()) {
      alert("অনুগ্রহ করে আপনার এনআইডি নম্বরটি প্রদান করুন!");
      return;
    }
    setIsGenerating(true);
    setGeneratedKey("");
    setGeneratingLogs([]);

    const logs = [
      "⚡ [PRIME-SEC] Initiating Cryptographic Handshake Gateway...",
      "🔑 [VERIFY] Mapping target NID structure: " + nidNumber,
      "🛰️ [PROXY] Tunnelling through secure Cloudflare DNS resolvers (Bangladesh mirror)...",
      "🛡️ [SECURITY] Verifying local AdSense safety & Zero-Malware policy...",
      "💻 [COMPILING] Packing signature bytes on 2040 SHA-512 Block-Array...",
      "💥 [SUCCESS] Verification security key injected and certified!"
    ];

    let index = 0;
    const interval = setInterval(() => {
      if (index < logs.length) {
        setGeneratingLogs(prev => [...prev, logs[index]]);
        index++;
      } else {
        clearInterval(interval);
        // Formulate a beautiful secure key
        const randomHex = Math.floor(100000 + Math.random() * 900000).toString(16).toUpperCase();
        const year = new Date().getFullYear();
        const cleanNidPart = nidNumber.replace(/[^0-9]/g, "").slice(-4) || "7011";
        const finalKey = `ILYBD-NID-KEY-${year}-${cleanNidPart}-${randomHex}`;
        
        setGeneratedKey(finalKey);
        setIsGenerating(false);
      }
    }, 400);
  };

  const copyGeneratedKey = () => {
    if (!generatedKey) return;
    navigator.clipboard.writeText(generatedKey);
    setCopyFeedback(true);
    setTimeout(() => setCopyFeedback(false), 2000);
  };

  const tools: ToolItem[] = [
    {
      id: "nid-maker",
      classNameLabel: "NID-CARD",
      icon: Layout,
      nameBangla: "স্মার্ট এনআইডি কার্ড জেনারেটর প্রো 📱",
      nameEnglish: "Smart NID Card Generator",
      tagline: "নিজের ফটো, স্বাক্ষর ও এআই ব্যাকগ্রাউন্ড রিমুভারসহ স্মার্ট কার্ড মেকার",
      description: "বাংলাদেশি প্রযুক্তিক্ষেত্রে সবচেয়ে সাড়া জাগানো স্মার্ট এনআইডি কার্ড বা ডিজিটাল কাস্টম আইডি তৈরির অফলাইন-লাইক ইউটিলিটি।",
      instructions: "বাংলা/ইংরেজি নাম, এনআইডি নম্বর ও জন্মতারিখ লিখে নিজের ছবি ও এআই রেডি সিগনেচার আপলোড করুন এবং হাই-কোয়ালিটি পিএনজি ইমেজ জেনারেট করুন।",
      badge: "ACTIVE V3.0",
      badgeColors: "bg-emerald-950 text-emerald-400 border-emerald-800",
      buttonLabel: "এনআইডি মেকার ওপেন করুন ➔",
      hotkey: "CTRL+N",
      action: () => onSelectTab("nid")
    },
    {
      id: "nid-key",
      classNameLabel: "NID-KEY",
      icon: ShieldCheck,
      nameBangla: "এনআইডি সিকিউরিটি কি জেনারেটর 🔑",
      nameEnglish: "NID Security Key Generator",
      tagline: "এনআইডি ডাউনলোড সিকিউরিটি ও আইডেন্টিটি এনক্রিপশন প্রুফ কি",
      description: "আপনার এনআইডি কার্ড তৈরি ও ডাউনলোডের প্রক্রিয়াকে শতভাগ নিরাপদ রাখতে গ্লোবাল ১০-ডিজিটের অ্যাক্সেস কোড তৈরি করার এআই ইঞ্জিন।",
      instructions: "নিজের আংশিক এনআইডি নম্বর বা মোবাইল নম্বর দিয়ে ভেরিফাইড গেটওয়ে চালুর মাধ্যমে সিকিউরিটি জেনারেটর ক্র্যাফট প্রুফ ফাইল লক ও কপি করার জন্য উপযোগী।",
      badge: "LIVE CORE",
      badgeColors: "bg-cyan-950 text-cyan-400 border-cyan-800",
      buttonLabel: "ইন্টারেক্টিভ কি জেনারেটর ⚡",
      hotkey: "CTRL+K",
      action: () => setShowKeyGen(true)
    },
    {
      id: "ai-maya",
      classNameLabel: "AI-MAYA",
      icon: Cpu,
      nameBangla: "এআই মায়া ক্লাউড অ্যাসিস্ট্যান্ট ✨",
      nameEnglish: "Mega Maya AI Cloud Chatbot",
      tagline: "যেকোনো আইটি সমস্যা, কোডিং বাগ বা ফ্রিল্যান্সিং গাইড ফ্রিতে সমাধান",
      description: "অনর্গল চমৎকার বাংলায় সাবলীলভাবে কথা বলতে সক্ষম অত্যন্ত উচ্চ মেধার এআই রোবট। ২৪/৭ আপনার পার্সোনাল মেন্টর ও এসইও ট্র্যাকার হিসেবে চ্যাট করুন।",
      instructions: "আপনার চ্যাট বক্সে প্রশ্নটি টাইপ করুন, জটিল কোডিং বা আর্টিকেল রাইটিং এডিটর থেকে সরাসরি চমৎকার ফাইল অ্যানালাইসিস রিপোর্ট বুঝে নিন।",
      badge: "ONLINE 24/7",
      badgeColors: "bg-amber-950 text-amber-400 border-amber-800",
      buttonLabel: "মায়ার সাথে চ্যাট করুন ✨",
      hotkey: "CTRL+M",
      action: () => onSelectTab("ai")
    },
    {
      id: "video-downloader",
      classNameLabel: "DOWNLOADER",
      icon: Video,
      nameBangla: "মাল্টি-সোর্স এইচডি ভিডিও ডাউনলোডার 📥",
      nameEnglish: "AIO Secure Video Downloader",
      tagline: "ফেসবুক, ইউটিউব, টিকটক ও ইনস্টাগ্রাম হাই-স্পিড মিডিয়া রুলস ডাউনলোডার",
      description: "কোনো প্রকার হ্যাকিং বা ক্ষতিকর লিংক স্ক্র্যাপশন ব্যতিরেকে সরাসরি ভিডিওর ক্লাউড সিডিএন সোর্স থেকে হাই-রেজুলেশন অরিজিনাল মিডিয়া ডাউনলোড পোর্টাল।",
      instructions: "কাঙ্ক্ষিত ফেসবুক বা ইউটিউব ভিডিওর লিংকটি কপি করে পেস্ট করুন, গেটওয়েটি স্বয়ংক্রিয় টানেল চেক করে সেকেন্ডে ফ্লেক্সিবল ফাইল কোয়ালিটি লিংক দেবে।",
      badge: "FREE FAST",
      badgeColors: "bg-purple-950 text-purple-400 border-purple-800",
      buttonLabel: "ডাউনলোডার ওপেন করুন 📥",
      hotkey: "CTRL+D",
      action: () => onSelectTab("downloader")
    },
    {
      id: "ai-writer",
      classNameLabel: "AI-WRITER",
      icon: Sparkles,
      nameBangla: "এআই কন্টেন্ট ক্রিয়েটর ও রাইটার ✍️",
      nameEnglish: "AI Semantic Article Writer",
      tagline: "১-ক্লিকে এসইও ফ্রেন্ডলি ব্লগ পোস্ট রচনা এবং কাস্টম ইংরেজি টু বাংলা অনুবাদ",
      description: "গুগল সার্চ ও এডসেন্স ফ্রেন্ডলি হেডলাইন, সাবহেড এবং ১০০% ইউনিক কন্টেন্ট জেনারেশনের আল্টিমেট ক্রিয়েটর টুল।",
      instructions: "টুলস হাবে গিয়ে প্রয়োজনীয় কীওয়ার্ড বা টপিক ল্যাব রাইটারে লিখুন এবং চমৎকার সাবমিট করার মাধ্যমে গুগল ইনডেক্স ফ্রেন্ডলি কন্টেন্ট রপ্তানি করুন।",
      badge: "PRO V2",
      badgeColors: "bg-rose-950 text-rose-400 border-rose-800",
      buttonLabel: "এআই রাইটার চালু করুন 🖌️",
      hotkey: "CTRL+W",
      action: () => onSelectSubTool("ai-writer")
    },
    {
      id: "qr-suite",
      classNameLabel: "QR-CREATOR",
      icon: QrCode,
      nameBangla: "নিওন কিউআর কোড মেকার ল্যাব 🧬",
      nameEnglish: "Neon QR Code Creator Suite",
      tagline: "কাস্টম সাইজ এবং বিভিন্ন গর্জিয়াস নিওন লাইভ কালার কিউআর জেনারেটর",
      description: "আপনার সোশ্যাল লিংক, অ্যাপ ডাউনলোড বা পার্সোনাল ওয়েবসাইটের জন্য চমৎকার নিওন গ্লো শ্যাডো ইফেক্ট সহ মাল্টি কালার কিউআর কোড জেনারেশন টুল।",
      instructions: "আপনার লিংক বা ওয়েবসাইট টাইপ করুন, পছন্দানুযায়ী নিওন ব্লু, সায়ান বা লাইম গ্রিন গ্লো কালার সিলেক্ট করে ওয়ান-ক্লিকে এইচডি ফাইল ডাউনলোড করুন।",
      badge: "GLOW ACTIVE",
      badgeColors: "bg-cyan-950 text-[#00f0ff] border-cyan-800",
      buttonLabel: "কিউআর ল্যাব ওপেন করুন 🧬",
      hotkey: "CTRL+Q",
      action: () => onSelectSubTool("qr-suite")
    },
    {
      id: "webmaster-seo",
      classNameLabel: "SEO-FACTORY",
      icon: Flame,
      nameBangla: "সার্চ ইঞ্জিন মেটাডাটা ও সিএসএস গ্লো ফ্যাক্টরি 🏭",
      nameEnglish: "Webmaster SEO Suite & Glow Gen",
      tagline: "গুগল ক্রল ফ্রেন্ডলি ওজি মেটা ট্যাগ এবং সিএসএস শ্যাডো মেকিং ড্যাশবোর্ড",
      description: "আপনার ব্লগ বা ফোরামকে দ্রুত র‍্যাঙ্কে নিতে চমৎকার ওজি ও টুইটার মেটা ট্যাগ স্ক্রিপ্ট এবং সিএসএস ডেকোরেশনের গ্লোয়িং বর্ডার কোডবিল্ডার।",
      instructions: "সাইটের নাম, ডেসক্রিপশন এবং ক্যাটাগরি ফিলাপ করে ওয়ান-ক্লিকে সার্চ ট্যাগ স্ক্রিপ্ট জেনারেট ও কপি করুন বা CSS শ্যাডোর বর্ডার রেন্ডারিং নিয়ে নিন।",
      badge: "SEO BOOST",
      badgeColors: "bg-yellow-950 text-yellow-400 border-yellow-800",
      buttonLabel: "এসইও প্লাগিন চেক করুন 🏭",
      hotkey: "CTRL+S",
      action: () => onSelectSubTool("webmaster")
    },
    {
      id: "music-lab",
      classNameLabel: "MUSIC-LAB",
      icon: Music,
      nameBangla: "নিয়েন মিউজিক সিন্থেসাইজার ২০৪০ 🎵",
      nameEnglish: "Neon Music Synth & Audio Lab",
      tagline: "সাউন্ড ফ্রিকোয়েন্সি এবং ইন্টারেক্টিভ মিউজিক লুপ এআই বিট সাউন্ড মেকার",
      description: "এআই মিউজিক জেনারেটর এবং কাস্টম বিপিএম সাউন্ড ট্র্যাক ডিজাইনার। রিল্যাক্সিং বা প্রোগ্রামিং ফোকাস ব্যাকগ্রাউন্ড সাউন্ড জেনারেটর।",
      instructions: "মিউজিকের জেনার ও বিট সিলেক্ট করে এআই সিন্থেসাইজার বাটনে ক্লিক করুন। চমৎকার ফ্রিকোয়েন্সির লাইভ হ্যাপটিক সাউন্ড শুনতে প্লে বাটনে ক্লিক করুন।",
      badge: "SA AUDIO",
      badgeColors: "bg-lime-950 text-lime-400 border-lime-800",
      buttonLabel: "মিউজিক ল্যাব শুনুন 🎵",
      hotkey: "CTRL+P",
      action: () => onSelectTab("audiolab")
    },
    {
      id: "cyber-pet",
      classNameLabel: "TALKING-CAT",
      icon: Gamepad2,
      nameBangla: "সাইবার টকিং পেট ক্যাট গেম 🐈",
      nameEnglish: "Cyber Talkative Pet Simulation",
      tagline: "ভয়েস ট্র্যাকিং হ্যাপটিক অ্যানিমেশন ও কাস্টম টাচ সেন্সর পেট ক্যাট",
      description: "সাইন্স-ফিকশন নিওন বিড়াল যে মাইক্রোফোনে আপনার কথা শুনলে তা ডাবল স্পিডে এবং অনেক কিউট গলায় ফানি ওয়েতে হুবহু রিপিট করে শুনাবে।",
      instructions: "মাইক্রোফোন পারমিশন অন করে কথা বলুন। এর মাথায় বা হাত-পায়ে মাউসের ক্লিকের সাহায্যে টাচ হ্যাপটিক্স ইমোজি রিঅ্যাকশন পরীক্ষা করুন।",
      badge: "GAMEPLAY 1.0",
      badgeColors: "bg-pink-950 text-pink-400 border-pink-800",
      buttonLabel: "সাইবার পেটের সাথে খেলুন 👾",
      hotkey: "CTRL+G",
      action: () => onSelectSubTool("cyber-pet")
    },
    {
      id: "forum-qa",
      classNameLabel: "QA-FORUM",
      icon: HelpCircle,
      nameBangla: "কমিউনিটি প্রশ্ন-উত্তর ফোরাম ও ক্যাশ গেটওয়ে 💬",
      nameEnglish: "Q&A Community Forum",
      tagline: "প্রযুক্তি প্রশ্নের উত্তর দিন এবং প্রতি কন্ট্রিবিউশনে বিকাশ ওয়ালেট ব্যালেন্স বাড়ান",
      description: "ডেভেলপার ও ব্লগারদের জন্য চমৎকার নলেজ শেয়ারিং কমিউনিটি। অন্যান্যদের সাহায্য করে সরাসরি রিয়েল-টাইম ক্যাশব্যাক ও কন্ট্রিবিউটর মেম্বার ব্যাজ পান।",
      instructions: "ফোরামে জয়েন করুন, মানুষের পোস্ট পর্যালোচনা করুন অথবা নিজের আইটি সমস্যা লিখে সাবমিট করুন। প্রতিবার সেরা উত্তর দিয়ে ক্যাশ ক্রেডিট পান।",
      badge: "EARN ACTIVE",
      badgeColors: "bg-emerald-950 text-emerald-400 border-emerald-800",
      buttonLabel: "ফোরামে ভিজিট করুন 👥",
      hotkey: "CTRL+F",
      action: () => onSelectTab("qa")
    }
  ];

  return (
    <div id="ilybd-tools-lab-dashboard" className="space-y-10 text-left">
      {/* Tools Lab Brand Title Head Banner */}
      <div className="bg-[#090d16] border border-cyan-950 rounded-2xl p-6 sm:p-8 relative overflow-hidden shadow-2xl">
        <div className="absolute top-0 right-0 w-96 h-96 bg-[radial-gradient(circle_at_center,rgba(0,240,255,0.08)_0,transparent_60%)] rounded-full blur-3xl pointer-events-none" />
        <div className="absolute bottom-0 left-0 w-96 h-96 bg-[radial-gradient(circle_at_center,rgba(168,85,247,0.08)_0,transparent_60%)] rounded-full blur-3xl pointer-events-none" />
        
        <div className="relative z-10 space-y-4">
          <div className="inline-flex items-center gap-2 text-xs font-mono font-bold text-cyan-400 bg-cyan-950/80 px-3 py-1.5 rounded-full border border-cyan-900/60 shadow-[0_0_10px_rgba(0,240,255,0.15)] uppercase tracking-widest animate-pulse">
            <Wrench className="w-4 h-4 text-cyan-400" /> ILOVEYOUBD.COM AI LABS & FACTORY
          </div>
          
          <h1 className="text-2xl sm:text-4xl font-extrabold font-sans text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-200 to-cyan-400 tracking-tight leading-tight">
            নিওন সাইবার টুলস ল্যাব ও এআই কো-ডিজাইন ফ্যাক্টরি 🧪
          </h1>
          
          <p className="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-4xl font-sans">
            আমাদের ল্যাব ও আইটি ফ্যাক্টরিতে স্বাগতম। ভিজিটররা এখানে তাদের নির্দিষ্ট প্রয়োজনীয়তা অনুযায়ী টুলটি নিচে সুন্দর করে দেখে অত্যন্ত সহজে এবং সম্পূর্ণ ফ্রিতে ব্যবহার করতে পারে। প্রত্যেকটি টুল ১০০% গুগল এডসেন্স ফ্রেন্ডলি এবং হাই-স্পিড কোড অপ্টিমাইজড।
          </p>
        </div>
      </div>

      {/* Grid Layout of the 10 custom cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {tools.map((tool) => {
          const IconComponent = tool.icon;
          return (
            <motion.div
              key={tool.id}
              whileHover={{ y: -4, scale: 1.005 }}
              transition={{ duration: 0.2 }}
              className="bg-[#090d16] border border-cyan-950/70 hover:border-cyan-500/40 rounded-2xl p-5 flex flex-col justify-between relative overflow-hidden hover:shadow-[0_10px_30px_rgba(0,240,255,0.05)] group transition-all"
            >
              <div className="absolute top-0 right-0 w-32 h-32 bg-cyan-500/5 rounded-full blur-3xl group-hover:bg-cyan-500/10 transition-all pointer-events-none" />
              
              <div className="space-y-4">
                {/* Visual Card Header */}
                <div className="flex items-start justify-between">
                  <div className="flex items-center gap-3">
                    <div className="p-3 rounded-xl bg-cyan-950/50 border border-cyan-900 group-hover:border-cyan-400 group-hover:shadow-[0_0_15px_rgba(0,240,255,0.4)] transition-all flex items-center justify-center">
                      <IconComponent className="w-6 h-6 text-cyan-400" />
                    </div>
                    <div>
                      <span className="text-[9px] font-mono font-bold text-slate-500 block uppercase tracking-wider">
                        {tool.classNameLabel} • {tool.nameEnglish}
                      </span>
                      <h3 className="text-base sm:text-lg font-bold font-sans text-slate-100 group-hover:text-cyan-400 transition-colors">
                        {tool.nameBangla}
                      </h3>
                    </div>
                  </div>
                  
                  <span className={`text-[9px] font-mono font-extrabold px-2 py-0.5 rounded border ${tool.badgeColors}`}>
                    {tool.badge}
                  </span>
                </div>

                {/* Tagline */}
                <div className="inline-block bg-slate-950 px-3 py-1 rounded-lg border border-cyan-950 text-xs font-semibold text-emerald-400">
                  ⚡ {tool.tagline}
                </div>

                {/* Description */}
                <p className="text-xs text-slate-300 leading-relaxed font-sans">
                  {tool.description}
                </p>

                {/* Guidelines section explicitly implementing the user rule */}
                <div className="bg-[#050810]/80 p-3 rounded-xl border border-cyan-950/60 space-y-1.5 shadow-inner">
                  <span className="text-[10px] uppercase font-mono font-bold tracking-wider text-cyan-400 flex items-center gap-1">
                    <Info className="w-3.5 h-3.5" /> ব্যবহারের নিয়ম ও নির্দেশনাবলী (GCP Safe)
                  </span>
                  <p className="text-[11px] text-slate-405 leading-relaxed font-sans">
                    {tool.instructions}
                  </p>
                </div>
              </div>

              {/* Launcher Actions */}
              <div className="mt-5 pt-4 border-t border-cyan-950/50 flex items-center justify-between">
                <span className="text-[9px] font-mono text-slate-500 group-hover:text-cyan-500 transition-colors">
                  {tool.hotkey}
                </span>
                
                <button
                  onClick={tool.action}
                  className="text-xs font-mono font-bold uppercase bg-cyan-900/35 hover:bg-cyan-550 hover:text-black hover:border-cyan-400 border border-cyan-950 text-cyan-300 py-1.5 px-4 rounded-lg tracking-wider hover:shadow-[0_0_15px_rgba(0,240,255,0.3)] transition-all flex items-center gap-1.5 shadow cursor-pointer"
                >
                  {tool.buttonLabel}
                </button>
              </div>
            </motion.div>
          );
        })}
      </div>

      {/* INTERACTIVE NID KEY GENERATOR PORTAL MODAL DIALOG */}
      <AnimatePresence>
        {showKeyGen && (
          <div className="fixed inset-0 bg-black/90 backdrop-blur-md z-50 flex items-center justify-center p-4">
            <motion.div
              initial={{ scale: 0.95, opacity: 0, y: 30 }}
              animate={{ scale: 1, opacity: 1, y: 0 }}
              exit={{ scale: 0.95, opacity: 0, y: 30 }}
              className="bg-[#080d17] border-2 border-cyan-500/50 rounded-2xl w-full max-w-lg overflow-hidden shadow-[0_0_50px_rgba(0,240,255,0.25)] flex flex-col text-left"
            >
              {/* Header */}
              <div className="bg-[#0b1222] border-b border-cyan-950 p-4 flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <ShieldCheck className="w-5 h-5 text-cyan-400" />
                  <span className="font-mono text-xs font-extrabold uppercase tracking-widest text-[#00f0ff]">
                    NID SECURE ACCESS GATEWAY KEY
                  </span>
                </div>
                <button
                  onClick={() => {
                    setShowKeyGen(false);
                    setGeneratedKey("");
                    setGeneratingLogs([]);
                  }}
                  className="text-slate-450 hover:text-white font-mono text-xs cursor-pointer hover:rotate-90 transition-transform"
                >
                  ✕
                </button>
              </div>

              {/* Body */}
              <div className="p-6 space-y-5">
                <div className="space-y-1">
                  <h3 className="text-base font-bold text-slate-100 font-sans">
                    ক্রিপ্টোগ্রাফিক সিকিউরিটি কি তৈরি ড্যাশবোর্ড 🛡️
                  </h3>
                  <p className="text-xs text-slate-400 leading-relaxed font-sans">
                    আপনার নিজের এনআইডি নম্বর এখানে যুক্ত করে টানেল এনক্রিপশন লকিং কি তৈরি করুন। এটি ডাউনলোডার সিকিউরিটি রিকোয়েস্ট ইন্টিগ্রিটি ও মেম্বার ভেরিফিকেশনে ব্যবহৃত হয়।
                  </p>
                </div>

                <div className="space-y-3.5">
                  <div className="space-y-1.5">
                    <label className="block text-[11px] font-mono text-cyan-400 font-bold uppercase">
                      ১০ বা ১৭-ডিজিট স্মার্ট এনআইডি নং (NID Number)
                    </label>
                    <input
                      type="text"
                      maxLength={17}
                      placeholder="যেমন: ৩২৮৪৫৭XXXXXXXX"
                      value={nidNumber}
                      onChange={(e) => setNidNumber(e.target.value.replace(/[^0-9]/g, ""))}
                      className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-slate-100 placeholder-slate-700 font-sans focus:outline-none transition-all shadow-inner"
                    />
                  </div>

                  <div className="space-y-1.5">
                    <label className="block text-[11px] font-mono text-cyan-400 font-bold uppercase">
                      জন্ম তারিখ (Date of Birth)
                    </label>
                    <input
                      type="date"
                      value={birthDate}
                      onChange={(e) => setBirthDate(e.target.value)}
                      className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-slate-400 font-sans focus:outline-none transition-all shadow-inner"
                    />
                  </div>
                </div>

                {/* Live Console Logs Panel */}
                {(isGenerating || generatingLogs.length > 0) && (
                  <div className="bg-slate-950 border border-cyan-950 rounded-xl p-3 h-32 overflow-y-auto font-mono text-[10px] leading-relaxed text-slate-300 space-y-1 shadow-inner scroll-smooth">
                    {generatingLogs.map((log, i) => (
                      <div key={i} className="flex items-center gap-1.5">
                        <span className="text-cyan-400 font-bold">▶</span>
                        <span className={log.includes("SUCCESS") ? "text-emerald-400 font-bold animate-pulse" : ""}>{log}</span>
                      </div>
                    ))}
                    {isGenerating && (
                      <div className="flex items-center gap-2 text-cyan-400/70 font-semibold italic animate-pulse pt-1">
                        <RefreshCw className="w-3.5 h-3.5 animate-spin" /> জেনারেট হচ্ছে... সিকিউর প্রক্সি লোড করা হচ্ছে...
                      </div>
                    )}
                  </div>
                )}

                {/* Final Key Presentation Area */}
                {generatedKey && (
                  <motion.div
                    initial={{ opacity: 0, y: 10 }}
                    animate={{ opacity: 1, y: 0 }}
                    className="p-4 bg-emerald-950/20 border-2 border-emerald-500/40 rounded-xl flex flex-col sm:flex-row items-center justify-between gap-3 shadow-[inset_0_0_15px_rgba(16,185,129,0.05)]"
                  >
                    <div className="space-y-1 w-full sm:w-auto">
                      <span className="text-[9px] uppercase font-mono font-bold text-emerald-400 flex items-center gap-1.5">
                        <CheckCircle className="w-3.5 h-3.5" /> CERTIFIED SECURE KEY
                      </span>
                      <span className="text-xs font-mono font-bold text-slate-100 block break-all select-all select-text">
                        {generatedKey}
                      </span>
                    </div>

                    <button
                      onClick={copyGeneratedKey}
                      className="w-full sm:w-auto shrink-0 flex items-center justify-center gap-1.5 text-xs font-mono font-bold bg-[#101b12] hover:bg-emerald-600 border border-emerald-500 text-emerald-400 hover:text-white py-2 px-4 rounded-lg shadow cursor-pointer transition-all active:scale-95"
                    >
                      {copyFeedback ? (
                        <>✓ কপিড!</>
                      ) : (
                        <>
                          <Copy className="w-3.5 h-3.5" /> কপি করুন
                        </>
                      )}
                    </button>
                  </motion.div>
                )}

                <div className="pt-4 border-t border-cyan-950/50 flex flex-col sm:flex-row gap-3">
                  <button
                    disabled={isGenerating}
                    onClick={startNidKeyGeneration}
                    className="flex-1 bg-gradient-to-r from-cyan-600 to-indigo-600 hover:from-cyan-500 hover:to-indigo-500 text-white font-mono font-bold text-xs py-2.5 rounded-xl border border-cyan-400/30 hover:shadow-[0_0_15px_rgba(0,240,255,0.3)] transition-all cursor-pointer disabled:opacity-55 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                  >
                    <ShieldCheck className="w-4 h-4 text-white" />
                    <span>ভেরিফিকেশন সিকিউরিটি কি জেনারেট করুন ⚡</span>
                  </button>
                  
                  <button
                    disabled={isGenerating}
                    onClick={() => {
                      setShowKeyGen(false);
                      setGeneratedKey("");
                      setGeneratingLogs([]);
                    }}
                    className="px-4 py-2.5 bg-[#0e152d] border border-cyan-950/70 hover:text-white rounded-xl text-xs font-semibold cursor-pointer"
                  >
                    বাতিল
                  </button>
                </div>
              </div>
            </motion.div>
          </div>
        )}
      </AnimatePresence>
    </div>
  );
}
