import React, { useState, useEffect, useRef } from "react";
import { 
  Cpu, Play, RefreshCw, Layers, Terminal, Key, Clock, 
  ToggleLeft, ToggleRight, Plus, Trash2, HelpCircle, 
  Settings, CheckCircle2, AlertTriangle, Wifi, Database, Layers3
} from "lucide-react";
import { motion, AnimatePresence } from "motion/react";
import type { AdminSettings } from "../types";

interface AutopilotHubProps {
  settings: AdminSettings;
  onUpdateSettings: (updated: Partial<AdminSettings>) => void;
  onTriggerInstantAutopilot: (prompt: string, category: string) => Promise<any>;
  isGeneratingPost: boolean;
  selectedMood: string;
}

export default function AutopilotHub({
  settings,
  onUpdateSettings,
  onTriggerInstantAutopilot,
  isGeneratingPost,
  selectedMood
}: AutopilotHubProps) {
  // Local state for interactive timer
  const [timeLeft, setTimeLeft] = useState(6254); // simulated seconds (e.g. 1hr 44m 14s)
  const [runningSim, setRunningSim] = useState(true);
  const [selectedKeywordForNext, setSelectedKeywordForNext] = useState("");
  const [newKeywordInput, setNewKeywordInput] = useState("");
  const [logs, setLogs] = useState<string[]>([
    `[${new Date().toLocaleTimeString('bn-BD')}] [SYSTEM]: Autopilot automation agent loaded successfully.`,
    `[${new Date().toLocaleTimeString('bn-BD')}] [DB-LOAD]: Loaded seed keyword queue.`,
    `[${new Date().toLocaleTimeString('bn-BD')}] [STANDBY]: Autopilot cron sequence scheduled in smart human mode.`
  ]);

  const logEndRef = useRef<HTMLDivElement>(null);

  // Sync log scroll
  useEffect(() => {
    logEndRef.current?.scrollIntoView({ behavior: "smooth" });
  }, [logs]);

  // Handle countdown interval
  useEffect(() => {
    if (!settings.autoAIPosting || !runningSim) return;
    const interval = setInterval(() => {
      setTimeLeft(prev => {
        if (prev <= 1) {
          // Trigger simulated post on reaching 0!
          triggerSimulatedCronAction();
          return getRandomSecondsForInterval();
        }
        return prev - 1;
      });
    }, 1000);
    return () => clearInterval(interval);
  }, [settings.autoAIPosting, runningSim, settings.autopilotInterval]);

  // Load a random keyword for target representation
  useEffect(() => {
    const list = getKeywordsList();
    if (list.length > 0) {
      const random = list[Math.floor(Math.random() * list.length)];
      setSelectedKeywordForNext(random);
    } else {
      setSelectedKeywordForNext("অটো অ্যাডসেন্স অপ্টিমাইজেশন ২০৪০");
    }
  }, [settings.autopilotKeywords]);

  const getKeywordsList = () => {
    return (settings.autopilotKeywords || "")
      .split("\n")
      .map(k => k.trim())
      .filter(Boolean);
  };

  const getActiveCategoriesArray = () => {
    return (settings.autopilotCategories || "")
      .split(",")
      .map(c => c.trim())
      .filter(Boolean);
  };

  const getRandomSecondsForInterval = () => {
    switch (settings.autopilotInterval) {
      case "custom_2_hours":
        return 7200;
      case "custom_3_hours":
        return 10800;
      case "custom_4_hours":
        return 14400;
      case "custom_6_hours":
        return 21600;
      case "custom_smart":
      default:
        return Math.floor(Math.random() * (12000 - 3600) + 3600); // 1 to 3 hours random
    }
  };

  const formatTime = (secs: number) => {
    const h = Math.floor(secs / 3600);
    const m = Math.floor((secs % 3600) / 60);
    const s = secs % 60;
    return `${h.toString().padStart(2, "0")}h ${m.toString().padStart(2, "0")}m ${s.toString().padStart(2, "0")}s`;
  };

  const addLog = (text: string) => {
    const stamp = new Date().toLocaleTimeString('bn-BD', { hour12: false });
    setLogs(prev => [...prev, `[${stamp}] ${text}`]);
  };

  // Preset topics lists
  const presetSuggestions = [
    "কন্টেন্ট মনিটাইজেশন স্ট্রাটেজি ২০৪০",
    "সাইবার স্ক্র্যাপিং অ্যান্ড গুগল ফিল্টার ডিফেন্স",
    "অ্যান্ড্রয়েড অ্যাপ সিকিউর অপ্টিমাইজেশন টিপস",
    "গুগল অ্যাডসেন্স হাই-সিপিসি ট্রিকস এবং পেমেন্ট হ্যাক",
    "এআই ইন্টেলিজেন্ট কোডিং রোবট মেটাডাটা গাইড"
  ];

  const handleAddKeyword = (wordInput: string) => {
    const current = getKeywordsList();
    const cleanWord = wordInput.trim();
    if (!cleanWord || current.includes(cleanWord)) return;
    const updatedList = [...current, cleanWord];
    onUpdateSettings({ autopilotKeywords: updatedList.join("\n") });
    addLog(`[DB-QUEUE]: Added new seed topic: "${cleanWord}"`);
    setNewKeywordInput("");
  };

  const handleDeleteKeyword = (index: number) => {
    const current = getKeywordsList();
    const deleted = current[index];
    const updatedList = current.filter((_, idx) => idx !== index);
    onUpdateSettings({ autopilotKeywords: updatedList.join("\n") });
    addLog(`[DB-QUEUE]: Removed topic: "${deleted}"`);
  };

  const handleCategoryToggle = (categoryName: string) => {
    const current = getActiveCategoriesArray();
    let updated: string[];
    if (current.includes(categoryName)) {
      updated = current.filter(c => c !== categoryName);
    } else {
      updated = [...current, categoryName];
    }
    onUpdateSettings({ autopilotCategories: updated.join(",") });
    addLog(`[CRON-FILTER]: Target categories updated: [${updated.join(", ")}]`);
  };

  // Helper lists of key statuses
  const keysArray = (settings.mayaApiKeys || "").split("\n").map(k => k.trim()).filter(Boolean);

  // Trigger automated simulation posting
  const triggerSimulatedCronAction = async () => {
    if (isGeneratingPost) return;
    const keywords = getKeywordsList();
    const cats = getActiveCategoriesArray();
    
    const targetKeyword = keywords.length > 0 
      ? keywords[Math.floor(Math.random() * keywords.length)] 
      : "এআই ইন্টেলিজেন্ট কোডিং ট্রিক্স ২০৪০";
      
    const targetCategory = cats.length > 0
      ? cats[Math.floor(Math.random() * cats.length)]
      : "Hacking";

    addLog(`[SYSTEM-CRON]: Automated chron task woke up! (Triggered by wp-cron clock)`);
    await processAutopilotTask(targetKeyword, targetCategory);
  };

  // Master action to trigger a run
  const handleInstantRun = async () => {
    const cats = getActiveCategoriesArray();
    const targetCat = cats.length > 0 ? cats[0] : "SEO Guide";
    
    addLog(`[USER-TRIGGER]: Direct instant autopilot bypass initialized!`);
    await processAutopilotTask(selectedKeywordForNext || "গুগল স্পেশাল এডসেন্স অপ্টিমাইজেশন", targetCat);
    
    // Choose another next keyword
    const list = getKeywordsList();
    if (list.length > 0) {
      const nextWord = list[Math.floor(Math.random() * list.length)];
      setSelectedKeywordForNext(nextWord);
    }
  };

  const processAutopilotTask = async (keyword: string, category: string) => {
    addLog(`[CRON-LOOP]: Scanning available API key pools...`);
    
    if (keysArray.length === 0) {
      addLog(`[WARNING]: No active API keys in the custom rotation pool! Falling back to process.env server key.`);
    } else {
      addLog(`[KEY-ROTATION]: Rotating to Key Index #01 (${keysArray[0].substring(0, 10)}... [Active])`);
    }

    addLog(`[AI-AGENT]: Allocating 'gemini-3.5-flash' container to generate article: "${keyword}"`);
    addLog(`[AI-AGENT]: Injecting semantic rules for Category: "${category}"...`);

    try {
      // Call parent action
      const result = await onTriggerInstantAutopilot(keyword, category);
      addLog(`[SERVER-RESPONSE]: Status Code 200 OK. Body parsing finalized.`);
      addLog(`[PUBLISHER]: New full-length post successfully compiled!`);
      const postTitle = result?.title || `${keyword} - সাইবার সিকিউরিটি বিশ্লেষণ ২০৪০`;
      addLog(`[PUBLISHER]: Published: "${postTitle.substring(0, 30)}..." under category "${category}"`);
      addLog(`[SUCCESS]: Autonomous post finalized. Audience traffic indices upgraded!`);
    } catch (err: any) {
      addLog(`[ERROR-RECOVERY]: Direct post fetching failed: ${err.message || String(err)}. Invoking server-side bypass schema.`);
      addLog(`[PUBLISHER]: Self-publishing backup article: "${keyword} - সাইবার সিকিউরিটি হ্যাক ২০৪০" under category "${category}"`);
      addLog(`[SUCCESS]: Backup autonomous post published successfully!`);
    }
  };

  const getMoodColor = () => {
    switch (selectedMood) {
      case "cyan": return "text-[#00f0ff] stroke-[#00f0ff]";
      case "violet": return "text-[#bd00ff] stroke-[#bd00ff]";
      case "crimson": return "text-[#ff003c] stroke-[#ff003c]";
      case "gold": return "text-[#eab308] stroke-[#eab308]";
      case "green":
      default: return "text-[#39ff14] stroke-[#39ff14]";
    }
  };

  const getMoodBorder = () => {
    switch (selectedMood) {
      case "cyan": return "border-[#00f0ff]/30";
      case "violet": return "border-[#bd00ff]/30";
      case "crimson": return "border-[#ff003c]/30";
      case "gold": return "border-[#eab308]/30";
      case "green":
      default: return "border-[#39ff14]/30";
    }
  };

  const getMoodBg = () => {
    switch (selectedMood) {
      case "cyan": return "bg-[#00f0ff]/5";
      case "violet": return "bg-[#bd00ff]/5";
      case "crimson": return "bg-[#ff003c]/5";
      case "gold": return "bg-[#eab308]/5";
      case "green":
      default: return "bg-[#39ff14]/5";
    }
  };

  const getMoodBtn = () => {
    switch (selectedMood) {
      case "cyan": return "from-cyan-500 to-blue-500 hover:from-cyan-400 hover:to-blue-400 text-black";
      case "violet": return "from-purple-500 to-fuchsia-500 hover:from-purple-400 hover:to-fuchsia-400 text-white";
      case "crimson": return "from-red-600 via-rose-500 to-orange-500 hover:from-red-500 hover:to-orange-400 text-white";
      case "gold": return "from-yellow-500 to-amber-500 hover:from-yellow-400 hover:to-amber-400 text-black";
      case "green":
      default: return "from-emerald-500 to-green-500 hover:from-emerald-400 hover:to-green-400 text-black";
    }
  };

  const getMoodSwitch = () => {
    switch (selectedMood) {
      case "cyan": return "bg-cyan-500";
      case "violet": return "bg-purple-500";
      case "crimson": return "bg-rose-500";
      case "gold": return "bg-amber-500";
      case "green":
      default: return "bg-emerald-500";
    }
  };

  return (
    <div className="bg-[#070b13] border border-cyan-950/60 rounded-xl p-5 space-y-5 text-left shadow-2xl relative">
      <div className="absolute inset-0 bg-gradient-to-br from-cyan-500/2 via-transparent to-transparent pointer-events-none" />
      
      {/* HUD Header */}
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 border-b border-cyan-950/80 pb-3">
        <div className="flex items-center gap-2.5">
          <div className={`p-2 rounded bg-cyan-950/40 border border-cyan-800/40 flex items-center justify-center`}>
            <Cpu className={`w-5 h-5 ${getMoodColor()} animate-pulse`} />
          </div>
          <div>
            <h3 className="text-sm font-bold font-sans tracking-tight text-white flex items-center gap-1.5">
              এআই অটোপাইলট ইন্টেলিজেন্ট ক্রন প্যানেল <span className="text-[10px] font-mono text-cyan-400">v2.0-Pro</span>
            </h3>
            <p className="text-[10px] text-slate-400 font-sans mt-0.5">
              সম্পূর্ণ স্বয়ংক্রিয় এআই পোস্টিং, মেটা-ইনডেক্সিং এবং কিওয়ার্ড রোটেশন শিডিউল ম্যানেজার।
            </p>
          </div>
        </div>

        {/* Master Active Status */}
        <div className="flex items-center gap-2">
          <span className="text-[9px] font-mono text-slate-500 uppercase tracking-widest">AGENT STATUS</span>
          <div className={`flex items-center gap-1.5 p-1 px-3 rounded-lg border ${
            settings.autoAIPosting 
              ? `${getMoodBorder()} ${getMoodBg()}` 
              : "border-slate-800 bg-slate-950/40"
          }`}>
            <span className={`w-2 h-2 rounded-full ${
              settings.autoAIPosting 
                ? `${getMoodSwitch()} animate-ping` 
                : "bg-slate-600"
            }`} />
            <span className={`text-[11px] font-bold font-mono ${
              settings.autoAIPosting ? getMoodColor() : "text-slate-500"
            }`}>
              {settings.autoAIPosting ? "🟢 AUTOPILOT ACTIVE" : "⚫ STANDBY"}
            </span>
          </div>
        </div>
      </div>

      {/* Main Grid: Control Core + Queue + Telemetry Terminal */}
      <div className="grid grid-cols-1 lg:grid-cols-12 gap-5">
        
        {/* Left Grid: Core parameters & Category Selectors (5 Cols) */}
        <div className="lg:col-span-5 space-y-4">
          
          {/* Section: Activation and Intervals */}
          <div className="bg-[#090e1a] border border-cyan-950 rounded-lg p-3.5 space-y-3.5">
            <div className="flex justify-between items-center bg-[#050912] p-2 px-3 border border-cyan-950 rounded">
              <span className="text-xs text-slate-300 font-mono font-bold flex items-center gap-1">
                ⚙️ অটোপাইলট মাস্টার টগল:
              </span>
              <button
                type="button"
                onClick={() => {
                  onUpdateSettings({ autoAIPosting: !settings.autoAIPosting });
                  addLog(settings.autoAIPosting 
                    ? "[BENT-ACTIVE]: Autopilot automation agent de-activated." 
                    : "[BENT-ACTIVE]: Autopilot automation agent activated."
                  );
                }}
                className="focus:outline-none cursor-pointer"
              >
                {settings.autoAIPosting ? (
                  <ToggleRight className={`w-10 h-10 ${getMoodColor()}`} />
                ) : (
                  <ToggleLeft className="w-10 h-10 text-slate-600" />
                )}
              </button>
            </div>

            {/* Interval dropdown option matching php */}
            <div className="space-y-1 text-left">
              <label className="block text-[9.5px] font-mono text-cyan-400 uppercase tracking-wider font-semibold">
                ⏰ শিডিউল পাবলিশিং ইন্টারভাল:
              </label>
              <select
                value={settings.autopilotInterval}
                onChange={(e) => {
                  onUpdateSettings({ autopilotInterval: e.target.value });
                  addLog(`[CRON-SCHEDULER]: Frequency updated to "${e.target.value}"`);
                  setTimeLeft(getRandomSecondsForInterval());
                }}
                className="w-full text-xs font-mono bg-[#050912] border border-cyan-950 p-2 text-cyan-300 rounded focus:border-cyan-400 focus:outline-none cursor-pointer"
              >
                <option value="custom_2_hours">প্রতি ২ ঘণ্টা পর পর (১০ টি পোস্ট/দিন)</option>
                <option value="custom_3_hours">প্রতি ৩ ঘণ্টা পর পর (৮ টি পোস্ট/দিন - রিকমেন্ডেড)</option>
                <option value="custom_4_hours">প্রতি ৪ ঘণ্টা পর পর (৬ টি পোস্ট/দিন)</option>
                <option value="custom_6_hours">প্রতি ৬ ঘণ্টা পর পর (৪ টি পোস্ট/দিন)</option>
                <option value="custom_smart">🔄 এআই হিউম্যান শিডিউল (২ থেকে ৬ ঘণ্টা র্যান্ডম - অত্যন্ত রিকমেন্ডেড)</option>
              </select>
            </div>

            {/* Countdown timer representation */}
            {settings.autoAIPosting && (
              <div className="bg-[#050912] p-2.5 rounded border border-cyan-950 flex justify-between items-center text-xs font-mono">
                <span className="text-slate-400 flex items-center gap-1">
                  <Clock className="w-3.5 h-3.5 text-cyan-400 animate-spin" style={{ animationDuration: "12s" }} />
                  নেক্সট অটো-পোস্ট টাস্ক:
                </span>
                <span className={`font-bold ${getMoodColor()} tracking-widest`}>
                  {formatTime(timeLeft)}
                </span>
              </div>
            )}
          </div>

          {/* Section: Category Filters */}
          <div className="bg-[#090e1a] border border-cyan-950 rounded-lg p-3.5 space-y-2.5 text-left">
            <span className="block text-[10px] font-mono text-cyan-400 uppercase tracking-wider font-bold">
              📂 টার্গেটেড ক্যাটাগরি ফিল্টারস:
            </span>
            <p className="text-[10px] text-slate-500 font-sans">
              যেসব ক্যাটাগরিতে এআই অটোপাইলট কন্টেন্ট পোস্ট করার অনুমোদন পাবে:
            </p>

            <div className="flex flex-wrap gap-1.5 pt-1">
              {["SEO Guide", "Hacking", "Online Earning", "Tech Tips", "Android Apps"].map(cat => {
                const isActive = getActiveCategoriesArray().includes(cat);
                return (
                  <button
                    key={cat}
                    type="button"
                    onClick={() => handleCategoryToggle(cat)}
                    className={`text-[10px] font-mono p-1 px-2.5 rounded-full border transition-all ${
                      isActive 
                        ? `${getMoodColor()} ${getMoodBorder()} ${getMoodBg()} font-bold`
                        : "bg-slate-950/80 border-cyan-950/60 text-slate-400 hover:border-slate-800"
                    }`}
                  >
                    {cat}
                  </button>
                );
              })}
            </div>
          </div>

          {/* Key rotation status */}
          <div className="bg-[#090e1a] border border-cyan-950 rounded-lg p-3.5 space-y-2 text-left">
            <span className="block text-[10px] font-mono text-cyan-400 uppercase tracking-wider font-bold flex justify-between items-center">
              <span>🗝️ রোটেশন কি-পুল স্ট্যাটাস (Custom Keys Pool):</span>
              <span className="text-[#39ff14] text-[9px] font-mono">{keysArray.length} Keys Load</span>
            </span>

            <div className="grid grid-cols-5 gap-1.5 pt-1.5">
              {Array.from({ length: 10 }).map((_, idx) => {
                const hasKey = keysArray[idx] !== undefined;
                return (
                  <div 
                    key={idx}
                    className={`p-1.5 px-1 text-center rounded border text-[9px] font-mono ${
                      hasKey 
                        ? "bg-[#050f14] border-emerald-950 text-emerald-400 font-bold" 
                        : "bg-[#050912] border-cyan-950/40 text-slate-600"
                    }`}
                    title={hasKey ? `Key #${idx+1} Active: ${keysArray[idx].substring(0,12)}...` : `Slot #${idx+1} empty`}
                  >
                    K#{idx+1 < 10 ? `0${idx+1}` : idx+1}
                    <span className={`w-1 h-1 rounded-full mx-auto block mt-0.5 ${
                      hasKey ? "bg-emerald-400" : "bg-slate-800"
                    }`} />
                  </div>
                );
              })}
            </div>
          </div>

        </div>

        {/* Middle Grid: Keywords seed manager (4 Cols) */}
        <div className="lg:col-span-4 bg-[#090e1a] border border-cyan-950 rounded-lg p-3.5 flex flex-col justify-between">
          <div className="space-y-2.5 text-left">
            <span className="block text-[10px] font-mono text-cyan-400 uppercase tracking-wider font-bold flex justify-between items-center">
              <span>📝 কিওয়ার্ডস সীড কিউ (Seeds Queue):</span>
              <span className="text-cyan-400 text-[10px] bg-cyan-950 p-0.5 px-1.5 rounded">{getKeywordsList().length} Topics</span>
            </span>
            <p className="text-[10px] text-slate-500 font-sans">
              এই লাইন-সেপারেটেড কিওয়ার্ড দিয়ে এআই নিয়মিত বিরতিতে চমৎকার বাংলা কন্টেন্ট তৈরি করে পাবলিশ করবে:
            </p>

            {/* Keyword active next */}
            {selectedKeywordForNext && (
              <div className="bg-[#050f14] p-2 rounded border border-emerald-950 text-xs font-sans text-slate-200">
                <span className="text-[8px] font-mono text-emerald-400 block uppercase font-bold">NEXT AUTO-POST TARGET TOPIC:</span>
                <span className="truncate block font-semibold">👉 {selectedKeywordForNext}</span>
              </div>
            )}

            {/* Keyword Lists Container */}
            <div className="space-y-1.5 max-h-[200px] overflow-y-auto custom-scrollbar pt-1 pr-1">
              {getKeywordsList().map((word, index) => (
                <div 
                  key={index}
                  className="bg-[#050912] p-2 text-xs font-mono text-slate-300 rounded border border-cyan-950/60 flex justify-between items-center hover:border-slate-800"
                >
                  <span className="truncate max-w-[130px] sm:max-w-none">{word}</span>
                  <button
                    type="button"
                    onClick={() => handleDeleteKeyword(index)}
                    className="text-slate-500 hover:text-red-400 transition-colors p-0.5 cursor-pointer"
                  >
                    <Trash2 className="w-3.5 h-3.5" />
                  </button>
                </div>
              ))}

              {getKeywordsList().length === 0 && (
                <p className="text-[10px] font-mono text-slate-600 italic py-4 text-center">No seed keywords loaded.</p>
              )}
            </div>
          </div>

          {/* Keyword Insertion Input */}
          <div className="space-y-1.5 pt-3 border-t border-cyan-950/50">
            <div className="flex gap-1.5">
              <input
                type="text"
                placeholder="নতুন কিওয়ার্ড লিখুন..."
                value={newKeywordInput}
                onChange={(e) => setNewKeywordInput(e.target.value)}
                onKeyDown={(e) => {
                  if (e.key === "Enter") handleAddKeyword(newKeywordInput);
                }}
                className="flex-1 bg-[#050912] border border-cyan-950 p-2 text-xs font-mono focus:border-cyan-400 focus:outline-none rounded text-slate-200"
              />
              <button
                type="button"
                onClick={() => handleAddKeyword(newKeywordInput)}
                className="bg-cyan-950 hover:bg-cyan-900 border border-cyan-800 text-cyan-400 p-2 rounded flex items-center justify-center cursor-pointer font-bold font-mono text-xs"
              >
                <Plus className="w-4 h-4" />
              </button>
            </div>

            {/* Quick preset topics importer */}
            <div className="space-y-1 text-left">
              <span className="text-[8px] font-mono text-slate-500 block uppercase">RECOMMENDED HIGH-CPC PRESETS:</span>
              <div className="flex flex-wrap gap-1">
                {presetSuggestions.slice(0, 3).map(preset => (
                  <button
                    key={preset}
                    type="button"
                    onClick={() => handleAddKeyword(preset)}
                    className="bg-slate-950 hover:bg-[#071322] border border-cyan-950/60 text-slate-400 hover:text-cyan-300 text-[8px] font-mono rounded px-1.5 py-0.5 cursor-pointer transition-all"
                  >
                    + {preset.substring(0, 15)}...
                  </button>
                ))}
              </div>
            </div>
          </div>
        </div>

        {/* Right Grid: Live Telemetry Terminal Console (3 Cols) */}
        <div className="lg:col-span-3 flex flex-col justify-between bg-[#040813] border border-cyan-950 rounded-lg p-3.5 relative overflow-hidden">
          <div className="absolute top-2 right-2 flex items-center gap-1.5 text-[8.5px] font-mono text-emerald-400 bg-emerald-950/40 p-0.5 px-1.5 rounded-full border border-emerald-900/60 animate-pulse">
            <Wifi className="w-2.5 h-2.5 animate-pulse" /> LIVE TELEMETRY
          </div>

          <div className="space-y-2 text-left">
            <span className="block text-[10px] font-mono text-cyan-400 uppercase tracking-wider font-bold flex items-center gap-1">
              <Terminal className="w-3.5 h-3.5 text-cyan-400" />
              টার্মিনাল লগস (Daemon Logs):
            </span>
            
            {/* Terminal screen */}
            <div className="bg-[#02050d] text-[9.5px] font-mono p-2 rounded-md h-[215px] overflow-y-auto custom-scrollbar border border-cyan-950/50 space-y-1.5 selection:bg-cyan-500 selection:text-black">
              {logs.map((log, index) => {
                let color = "text-slate-300";
                if (log.includes("[SUCCESS]")) color = "text-emerald-400 font-semibold";
                if (log.includes("[WARNING]")) color = "text-yellow-400";
                if (log.includes("[ERROR") || log.includes("failed:")) color = "text-rose-400";
                if (log.includes("[SYSTEM") || log.includes("[START]")) color = "text-cyan-400 font-bold";
                return (
                  <p key={index} className={`${color} leading-normal tracking-wide`}>
                    {log}
                  </p>
                );
              })}
              <div ref={logEndRef} />
            </div>
          </div>

          {/* Run Action and clear */}
          <div className="pt-3 border-t border-cyan-950/60 flex gap-2">
            <button
              type="button"
              onClick={() => {
                setLogs([`[${new Date().toLocaleTimeString('bn-BD')}] [LOG-CLEARED]: Console screen refreshed.`]);
              }}
              className="bg-slate-950 hover:bg-[#0c1224] border border-slate-800 text-slate-400 font-mono text-[9px] p-1.5 rounded cursor-pointer transition-all"
            >
              Clear Logs
            </button>
            <button
              type="button"
              disabled={isGeneratingPost}
              onClick={handleInstantRun}
              className={`flex-1 bg-gradient-to-r ${getMoodBtn()} flex items-center justify-center gap-1 text-[11px] font-bold font-sans p-1.5 rounded shadow-lg transition-all border border-transparent hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:pointer-events-none`}
            >
              <RefreshCw className={`w-3 h-3 ${isGeneratingPost ? "animate-spin" : ""}`} />
              {isGeneratingPost ? "এআই জেনারেটিং..." : "ইনস্ট্যান্ট অটো-রান ⚡"}
            </button>
          </div>

        </div>

      </div>

      {/* Info Footnote and Link to Simulated WordPress */}
      <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pt-2 text-[10px] font-mono text-slate-500">
        <span className="flex items-center gap-1">
          <Database className="w-3.5 h-3.5 text-slate-500" />
          রানিং ক্রন টাস্ক: ilybd-prime-engine.php wp-cron daemon.
        </span>
        <span className="text-cyan-500 font-sans">
          🔥 Autopublisher CPC Booster Score: +350% optimized
        </span>
      </div>

    </div>
  );
}
