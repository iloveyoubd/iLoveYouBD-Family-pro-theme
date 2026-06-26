import React, { useState } from "react";
import { Settings, CheckCircle2, AlertTriangle, Monitor, Sparkles, Key, Sliders, Cpu, RefreshCw, BookOpen, Trash2, Edit3, Eye, ThumbsUp, Terminal as TermIcon, FileText, Check, Lock, Users, Coins, BarChart2, Calendar, Link as LinkIcon, ArrowUpRight, ArrowDownRight, DollarSign, ShieldCheck } from "lucide-react";
import type { AdminSettings, Post, UserStats, LedgerEntry } from "../types";
import SEOAuditTerminal from "./SEOAuditTerminal";
import AutopilotHub from "./AutopilotHub";

interface AdminPanelProps {
  settings: AdminSettings;
  onUpdateSettings: (updated: Partial<AdminSettings>) => void;
  selectedMood: string;
  onMoodChange: (mood: string) => void;
  onGenerateAIPost: () => void;
  isGeneratingAIPost: boolean;
  totalWithdrawn: number;
  withdrawalRequests: any[];
  onApproveWithdrawal: (id: string) => void;
  onTriggerInstantAutopilot: (prompt: string, category: string) => Promise<any>;
  posts: Post[];
  setPosts: React.Dispatch<React.SetStateAction<Post[]>>;
  currentUser: UserStats;
  addNotification: (msg: string, type: 'like' | 'comment' | 'post' | 'earning' | 'system') => void;
  allUsers: UserStats[];
  onUpdateUserStats: (username: string, updated: Partial<UserStats>) => void;
  ledger: LedgerEntry[];
  setLedger: React.Dispatch<React.SetStateAction<LedgerEntry[]>>;
  onAddLedgerTransaction: (username: string, amount: number, currency: "BDT" | "XP", reason: string, linkId?: string, linkType?: "post" | "comment" | "referral" | "forum" | "admin" | "other") => void;
}

export default function AdminPanel({
  settings,
  onUpdateSettings,
  selectedMood,
  onMoodChange,
  onGenerateAIPost,
  isGeneratingAIPost,
  totalWithdrawn,
  withdrawalRequests,
  onApproveWithdrawal,
  onTriggerInstantAutopilot,
  posts,
  setPosts,
  currentUser,
  addNotification,
  allUsers,
  onUpdateUserStats,
  ledger,
  setLedger,
  onAddLedgerTransaction
}: AdminPanelProps) {
  const keysArray = (settings.mayaApiKeys || "").split("\n").map(k => k.trim());
  const slots = Array.from({ length: 10 }, (_, i) => keysArray[i] || "");

  // States for User Points & Money Management Option
  const [searchUserQuery, setSearchUserQuery] = useState("");
  const [selectedUserToEdit, setSelectedUserToEdit] = useState<UserStats | null>(null);
  const [adjustmentTaka, setAdjustmentTaka] = useState("");
  const [adjustmentPoints, setAdjustmentPoints] = useState("");
  const [absoluteTaka, setAbsoluteTaka] = useState("");
  const [absolutePoints, setAbsolutePoints] = useState("");

  // Master Admin Dashboard Ledger & Monthly Analytics States
  const [ledgerSearch, setLedgerSearch] = useState("");
  const [ledgerFilterUser, setLedgerFilterUser] = useState("all");
  const [ledgerFilterType, setLedgerFilterType] = useState("all");
  const [ledgerFilterCurrency, setLedgerFilterCurrency] = useState("all");
  const [selectedLedgerEntry, setSelectedLedgerEntry] = useState<LedgerEntry | null>(null);
  const [showMonthDetail, setShowMonthDetail] = useState<string | null>(null);

  const updateKeySlot = (index: number, val: string) => {
    const newSlots = [...slots];
    newSlots[index] = val.trim();
    const cleaned = newSlots.filter(Boolean);
    onUpdateSettings({ mayaApiKeys: cleaned.join("\n") });
  };

  const clearKeySlot = (index: number) => {
    const newSlots = [...slots];
    newSlots[index] = "";
    const cleaned = newSlots.filter(Boolean);
    onUpdateSettings({ mayaApiKeys: cleaned.join("\n") });
  };

  const moodSkins = [
    { id: "green", name: "Classic Carbon Green (হ্যাকার বাইনারি)", accent: "#39ff14", bgClass: "from-[#050b07] to-[#010302]" },
    { id: "cyan", name: "Deep Ocean Cyan (কোয়ান্টাম সাইবার)", accent: "#00f0ff", bgClass: "from-[#030a16] to-[#01040a]" },
    { id: "violet", name: "Phantom Purple (ডার্ক ফ্যান্টম)", accent: "#bd00ff", bgClass: "from-[#0a0316] to-[#03010a]" },
    { id: "crimson", name: "Crimson Red (ম্যালওয়্যার ওয়ার্নিং)", accent: "#ff003c", bgClass: "from-[#160307] to-[#0a0104]" },
    { id: "gold", name: "Solar Gold (ভিআইপি এলিট ট্রিকবিডি)", accent: "#eab308", bgClass: "from-[#0f0e03] to-[#070601]" }
  ];

  const isMasterAdmin = currentUser.name === "তারেক রহমান";
  const [masterView, setMasterView] = useState(false);
  const [editingPost, setEditingPost] = useState<Post | null>(null);

  // Filter posts so that users ONLY see their own, except if master admin toggles masterView
  const myPosts = posts.filter(p => {
    if (isMasterAdmin && masterView) return true;
    return p.author.name === currentUser.name;
  });

  const handleSaveEdit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!editingPost) return;

    setPosts(prev => prev.map(p => p.id === editingPost.id ? editingPost : p));
    addNotification(`আর্টিকেলটি সফলভাবে সংরক্ষণ করা হয়েছে!`, "system");
    setEditingPost(null);
  };

  const handleDeletePost = (postId: string) => {
    const postToDelete = posts.find(p => p.id === postId);
    if (!postToDelete) return;
    if (confirm(`আপনি কি নিশ্চিতভাবে এই টিউটোরিয়ালটি ডিলিট করতে চান?\n"${postToDelete.title}"`)) {
      setPosts(prev => prev.filter(p => p.id !== postId));
      addNotification("আপনার কন্টেন্টটি সফলভাবে ডিলিট করা হয়েছে।", "system");
    }
  };

  // Calculate earnings for a post
  const getPostEarnings = (post: Post) => {
    const viewsEarn = post.views * (settings.payoutPerView || 0.15);
    const likesEarn = post.likes * (settings.payoutPerLike || 0.50);
    const basePublish = settings.payoutPerPublish || 8.50;
    return (viewsEarn + likesEarn + basePublish).toFixed(2);
  };

  // 1. Total network balance
  const totalUserBalance = allUsers?.reduce((sum, u) => sum + (u.balance || 0), 0) || 0;
  
  // 2. Total points allocated
  const totalPointsAllocated = allUsers?.reduce((sum, u) => sum + (u.points || 0), 0) || 0;

  // 3. Approved cashouts (total payouts completed)
  const completedPayoutsTotal = withdrawalRequests?.filter(r => r.status === "paid")?.reduce((sum, r) => sum + (r.amount || 0), 0) || 0;
  const pendingPayoutsTotal = withdrawalRequests?.filter(r => r.status === "pending")?.reduce((sum, r) => sum + (r.amount || 0), 0) || 0;

  // 4. Daily total user earnings (within last 24 hours BDT)
  const todayStr = new Date().toISOString().split('T')[0];
  const todayBDTEarnings = ledger
    ?.filter(entry => entry.currency === "BDT" && entry.amount > 0 && entry.timestamp.startsWith(todayStr))
    ?.reduce((sum, entry) => sum + entry.amount, 0) || 0;

  // 5. Monthly user earnings aggregate
  const monthlyEarningsMap: Record<string, number> = {};
  ledger?.forEach(entry => {
    if (entry.currency === "BDT" && entry.amount > 0) {
      const monthKey = entry.timestamp.substring(0, 7); // e.g., "2026-06"
      monthlyEarningsMap[monthKey] = (monthlyEarningsMap[monthKey] || 0) + entry.amount;
    }
  });

  const currentMonthKey = new Date().toISOString().substring(0, 7); // e.g., "2026-06"
  const currentMonthBDTEarnings = monthlyEarningsMap[currentMonthKey] || 0;

  // Filtered Ledger entries based on search and selected options
  const filteredLedger = ledger?.filter(entry => {
    const matchesSearch = entry.reason.toLowerCase().includes(ledgerSearch.toLowerCase()) || 
                          entry.username.toLowerCase().includes(ledgerSearch.toLowerCase()) ||
                          (entry.id || "").toLowerCase().includes(ledgerSearch.toLowerCase());
    const matchesUser = ledgerFilterUser === "all" || entry.username === ledgerFilterUser;
    const matchesType = ledgerFilterType === "all" || entry.linkType === ledgerFilterType;
    const matchesCurrency = ledgerFilterCurrency === "all" || entry.currency === ledgerFilterCurrency;
    
    // If showMonthDetail is set, filter to match that specific month
    const matchesMonth = !showMonthDetail || entry.timestamp.substring(0, 7) === showMonthDetail;
    
    return matchesSearch && matchesUser && matchesType && matchesCurrency && matchesMonth;
  }) || [];

  return (
    <div className="space-y-6">

      {/* 🔌 WordPress Theme & Plugin Fix (PRO) */}
      <div className="bg-slate-900/40 border border-emerald-500/30 rounded-2xl p-5 sm:p-7 relative overflow-hidden shadow-xl text-left space-y-4">
        {/* Pulsing decoration dot */}
        <div className="absolute top-4 right-4 flex items-center gap-2">
          <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" />
          <span className="text-[9px] font-mono font-bold text-emerald-400 tracking-wider">SYSTEM SECURE & PATCHED</span>
        </div>

        <div className="space-y-2 relative z-10">
          <div className="inline-flex items-center gap-2 text-xs font-mono font-bold text-emerald-400 bg-emerald-950/80 px-2.5 py-1 rounded border border-emerald-950">
            <ShieldCheck className="w-4 h-4 text-emerald-400" /> কাস্টম থিম ও প্লাগিন সমাধান রিপোর্ট (PRO)
          </div>
          <h2 className="text-base sm:text-xl font-bold font-sans text-slate-100 tracking-tight leading-tight">
            আপনার ওয়ার্ডপ্রেস থিম এবং প্লাগিন (ILYBD Prime Engine) এর সব বাগ ও মেমরিন ক্র্যাশ সফলভাবে ঠিক করা হয়েছে!
          </h2>
          <p className="text-xs sm:text-sm text-slate-300 leading-relaxed font-sans">
            আমরা আপনার দেওয়া থিম এবং <strong>ILYBD Prime Engine</strong> প্লাগিন উভয় ফাইল নিখুঁতভাবে চেক করেছি। প্লাগিনটির ডাটাবেজ টেবিলে অনুপস্থিত ভ্যালু ও কলাম যেমন <code className="text-emerald-400 font-mono">user_level</code> ও <code className="text-emerald-400 font-mono">total_earned</code> ইন্টিগ্রেট করা হয়েছে (যা আগে কুয়েরি ক্র্যাশ ঘটাত)। এছাড়াও পয়েন্ট ও ব্যালেন্স রিওয়ার্ড ইঞ্জেকশন এখন ব্যাকএন্ড ডাটাবেজ এবং ওয়ার্ডপ্রেস ইউজার মেটা ও নোটিফিকেশনের সাথে ১০০% রিয়েল-টাইমে মেলানো থাকবে!
          </p>
        </div>

        {/* Two side-by-side direct download buttons without pop-up blocking onClick */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 bg-[#070b13]/80 p-4 rounded-xl border border-cyan-950/40">
          <div className="flex flex-col items-center text-center space-y-2 border-b md:border-b-0 md:border-r border-cyan-950/40 pb-4 md:pb-0 md:pr-4">
            <span className="text-[9.5px] font-mono text-emerald-400 tracking-wider font-bold uppercase">1. THEME PACKAGE (ZIP)</span>
            <a
              href="/api/wordpress/download-fixed-theme"
              download="ilybd-neon-v1-pro-fixed.zip"
              className="w-full flex items-center justify-center gap-2 text-xs font-mono font-bold uppercase bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white py-2.5 px-4 rounded border border-emerald-500 shadow-md transition-all active:scale-95 cursor-pointer"
            >
              🚀 কাস্টম থিম ডাউনলোড করুন
            </a>
            <span className="text-[9px] font-mono text-slate-450">ilybd-neon-v1-pro-fixed.zip (~7.8 MB)</span>
          </div>

          <div className="flex flex-col items-center text-center space-y-2 pt-2 md:pt-0 md:pl-4">
            <span className="text-[9.5px] font-mono text-blue-400 tracking-wider font-bold uppercase">2. PLUGIN ENGINE (ZIP)</span>
            <a
              href="/api/wordpress/download-fixed-plugin"
              download="ilybd-prime-engine-fixed.zip"
              className="w-full flex items-center justify-center gap-2 text-xs font-mono font-bold uppercase bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white py-2.5 px-4 rounded border border-blue-500 shadow-md transition-all active:scale-95 cursor-pointer"
            >
              🔌 প্লাগিন ডাউনলোড করুন
            </a>
            <span className="text-[9px] font-mono text-slate-450">ilybd-prime-engine-fixed.zip (~3.7 MB)</span>
          </div>
        </div>

        {/* List of fixes */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-1.5 text-[11px] font-mono text-slate-400 pl-1">
          <div className="flex items-center gap-1.5">
            <span className="text-emerald-400 font-bold">✔</span>
            <span>পয়েন্ট এবং ব্যালেন্স ডাটাবেস টেবিল ও ইউজার মেটার ১০০% ইন্টিগ্রেশন।</span>
          </div>
          <div className="flex items-center gap-1.5">
            <span className="text-emerald-400 font-bold">✔</span>
            <span>ডাটাবেস ক্র্যাশ বাগ সংশোধন (user_level এবং total_earned কলাম স্বয়ংক্রিয় যুক্তকরণ)।</span>
          </div>
          <div className="flex items-center gap-1.5">
            <span className="text-emerald-400 font-bold">✔</span>
            <span>পোস্ট ক্রিয়েশন এবং আপডেট এডিটর নোটিফিকেশন সিঙ্ক সিস্টেম।</span>
          </div>
          <div className="flex items-center gap-1.5">
            <span className="text-emerald-400 font-bold">✔</span>
            <span>উইথড্রয়াল রিকোয়েস্ট এবং মেটা ডেটা সিঙ্ক্রোনাইজেশন।</span>
          </div>
        </div>
      </div>

      {/* ==================== CYBERNETIC CO-MONETIZATION MASTER REVENUE ENGINE DASHBOARD ==================== */}
      {isMasterAdmin && (
        <div className="bg-[#070b13] border border-cyan-500/20 rounded-2xl p-6 shadow-2xl relative overflow-hidden text-left space-y-6">
          <div className="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-cyan-400 via-purple-500 to-yellow-400 animate-pulse" />
          
          {/* Header section with status banner */}
          <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-4 border-b border-cyan-950">
            <div>
              <div className="flex items-center gap-2">
                <span className="p-1 px-2.5 rounded bg-yellow-400/10 text-yellow-500 text-[9px] font-mono border border-yellow-500/20 animate-pulse uppercase">
                  MASTER CONTROLLING STATUS: ON-CHAIN ACTIVE
                </span>
              </div>
              <h1 className="text-xl font-bold font-sans tracking-tight text-white mt-1 flex items-center gap-2">
                <BarChart2 className="w-6 h-6 text-cyan-400" />
                রিয়েল-টাইম রেভিনিউ ড্যাশবোর্ড ও লিংকিং লেজার সিস্টেম (২০৪০)
              </h1>
              <p className="text-xs text-slate-400 mt-1 font-sans">
                রজিস্টার্ড ইউজারদের প্রাত্যহিক এবং মাসিক আর্নিং ইন্সাইটস, ট্রানজেকশন ট্র্যাকিং এবং লিংকেড লেজার রেকর্ডস মনিটরিং কনসোল।
              </p>
            </div>
            
            <div className="flex items-center gap-2 text-xs font-mono">
              <span className="text-slate-500">চলতি তারিখ:</span>
              <span className="bg-[#0e1627] text-white border border-cyan-950 px-3 py-1.5 rounded-lg flex items-center gap-1.5">
                <Calendar className="w-4 h-4 text-[#00f0ff]" /> {todayStr} (UTC)
              </span>
            </div>
          </div>

          {/* Bento Grid Stats Cards */}
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            {/* Card 1: Total Master User Balance BDT */}
            <div className="bg-[#101726]/40 border border-cyan-950 rounded-xl p-4.5 space-y-2.5 hover:border-cyan-500/30 transition-all group">
              <div className="flex justify-between items-center">
                <span className="text-[10px] font-mono text-cyan-400 uppercase tracking-widest font-extrabold">মোট মেম্বার ব্যালেন্স</span>
                <div className="w-8 h-8 rounded-lg bg-pink-500/10 flex items-center justify-center border border-pink-500/20">
                  <Coins className="w-4.5 h-4.5 text-pink-400" />
                </div>
              </div>
              <div>
                <div className="text-2xl font-black font-mono text-white group-hover:text-pink-400 transition-colors">
                  {totalUserBalance.toFixed(2)} ৳
                </div>
                <div className="text-[10px] text-slate-400 font-mono mt-0.5">
                  রেজিস্টার্ড মেম্বারদের মোট জমা টাকা
                </div>
              </div>
            </div>

            {/* Card 2: Today's Dynamic User Earnings BDT */}
            <div className="bg-[#101726]/40 border border-cyan-950 rounded-xl p-4.5 space-y-2.5 hover:border-yellow-455/30 transition-all group">
              <div className="flex justify-between items-center">
                <span className="text-[10px] font-mono text-yellow-500 uppercase tracking-widest font-bold">আজকের মোট আর্নিং (Daily)</span>
                <div className="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center border border-yellow-500/20">
                  <Cpu className="w-4.5 h-4.5 text-yellow-400 animate-pulse" />
                </div>
              </div>
              <div>
                <div className="text-2xl font-black font-mono text-[#39ff14] group-hover:text-yellow-400 transition-colors">
                  {todayBDTEarnings.toFixed(2)} ৳
                </div>
                <div className="text-[10px] text-slate-400 font-mono mt-0.5">
                  আজকের ২৫ ঘণ্টার ক্যাশ অ্যাক্টিভিটি
                </div>
              </div>
            </div>

            {/* Card 3: Monthly Cumulative BDT Earnings (CLICKABLE DRILLDOWN) */}
            <button
              onClick={() => {
                setShowMonthDetail(showMonthDetail === currentMonthKey ? null : currentMonthKey);
                setLedgerFilterCurrency("all");
                setLedgerFilterType("all");
                addNotification(`চলতি মাস (${currentMonthKey}) এর বিস্তারিত লেজার ফিল্টার সক্রিয় করা হয়েছে!`, "system");
              }}
              className="bg-[#101726]/40 border border-cyan-950 rounded-xl p-4.5 space-y-2.5 hover:border-[#00f0ff] hover:bg-[#070b13] transition-all group text-left cursor-pointer focus:outline-none"
            >
              <div className="flex justify-between items-center">
                <span className="text-[10px] font-mono text-[#00f0ff] uppercase tracking-widest font-bold flex items-center gap-1">
                  চলতি মাসের আর্নিং ⚡ <span className="text-[8px] bg-cyan-950 font-mono px-1 rounded text-cyan-400 animate-pulse">ক্লিক করুন</span>
                </span>
                <div className="w-8 h-8 rounded-lg bg-cyan-500/10 flex items-center justify-center border border-cyan-500/20 group-hover:scale-105 transition-transform">
                  <Calendar className="w-4.5 h-4.5 text-cyan-400" />
                </div>
              </div>
              <div>
                <div className="text-2xl font-black font-mono text-[#00f0ff] group-hover:underline">
                  {currentMonthBDTEarnings.toFixed(2)} ৳
                </div>
                <div className="text-[10px] text-slate-400 font-mono mt-0.5">
                  {currentMonthKey} সালের মোট আর্নিং বোনাস
                </div>
              </div>
            </button>

            {/* Card 4: Payouts/Withdraws Cash Completed */}
            <div className="bg-[#101726]/40 border border-cyan-950 rounded-xl p-4.5 space-y-2.5 hover:border-emerald-520/30 transition-all group">
              <div className="flex justify-between items-center">
                <span className="text-[10px] font-mono text-emerald-400 uppercase tracking-widest font-bold">সফল পরিশোধিত পে-আউট</span>
                <div className="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20">
                  <Coins className="w-4.5 h-4.5 text-emerald-400" />
                </div>
              </div>
              <div>
                <div className="text-2xl font-black font-mono text-emerald-400">
                  {completedPayoutsTotal.toFixed(2)} ৳
                </div>
                <div className="text-[10px] text-slate-400 font-mono mt-0.5 flex justify-between items-center">
                  <span>পে-আউট উইথড্র মেটানো হয়েছে</span>
                  {pendingPayoutsTotal > 0 && (
                    <span className="text-amber-500 font-bold font-mono animate-bounce text-[8px] bg-amber-950/70 border border-amber-900 px-1 py-0.2 rounded">
                      পেন্ডিং: {pendingPayoutsTotal} ৳
                    </span>
                  )}
                </div>
              </div>
            </div>

          </div>

          {/* Drilldown Month Details and Historical Month Links */}
          <div className="bg-[#050a12] border border-cyan-950/60 rounded-xl p-4.5 space-y-3.5">
            <h3 className="text-xs font-mono font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
              <Calendar className="w-4 h-4 text-cyan-400" />
              মান্থলি রেভিনিউ চ্যানেল ট্র্যাকিং ও দ্রুত লিংকস (Clickable Earning Months)
            </h3>
            <p className="text-[11px] text-slate-400">
              নিচের লিংকে ক্লিক করে প্রতি মাসের মোট ইনকামের উৎস এবং কোন ইউজার কি কারণে কত টাকা পেমেন্ট পেয়েছে তার প্রতিটি ট্রানজেকশন নিচের লেজার টেবিলে স্বয়ংক্রিয় ফিল্টার ডাউনে দেখতে পাবেন:
            </p>
            
            <div className="flex flex-wrap gap-2.5 pt-1.5">
              {Object.keys(monthlyEarningsMap).length === 0 ? (
                <span className="text-[11px] font-mono text-slate-500 italic">কোনো ট্রানজেকশন রেকর্ড পাওয়া যায়নি...</span>
              ) : (
                Object.entries(monthlyEarningsMap).map(([month, amount]) => {
                  const isActive = showMonthDetail === month;
                  return (
                    <button
                      key={month}
                      onClick={() => {
                        setShowMonthDetail(isActive ? null : month);
                        addNotification(isActive ? "মাসিক ফিল্টারটি নিষ্ক্রিয় করা হয়েছে।" : `মাস (${month}) এর বিস্তারিত রিপোর্ট লোড করা হলো!`, "system");
                      }}
                      className={`px-3 py-2 bg-slate-950 border text-xs font-mono rounded-lg transition-all flex items-center gap-2 cursor-pointer ${
                        isActive 
                          ? "border-[#00f0ff] text-[#00f0ff] bg-cyan-950/40 shadow-[0_0_10px_rgba(0,240,255,0.15)]" 
                          : "border-cyan-950 text-slate-300 hover:border-cyan-800 hover:text-white"
                      }`}
                    >
                      <LinkIcon className={`w-3 h-3 ${isActive ? "text-[#00f0ff]" : "text-slate-500"}`} />
                      <span>{month} :</span>
                      <span className="text-emerald-400 font-bold">{amount.toFixed(2)} ৳ BDT</span>
                      {isActive && (
                        <span className="text-[8px] bg-[#00f0ff] text-slate-950 font-black px-1.5 py-0.2 rounded uppercase animate-pulse">
                          ফিল্টারড
                        </span>
                      )}
                    </button>
                  );
                })
              )}
            </div>
          </div>

          {/* Two Column Grid: 1. User wise total earning summary, 2. Ledger Filters and Audit */}
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
            
            {/* Left: User-wise Earnings & Points Index */}
            <div className="lg:col-span-4 bg-[#090d16] border border-cyan-950 rounded-xl p-4.5 space-y-4">
              <div className="border-b border-cyan-950 pb-2 flex justify-between items-center">
                <h3 className="text-xs font-mono font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
                  <Users className="w-4 h-4 text-[#00f0ff]" />
                  মেম্বারদের ব্যালেন্স ও এক্সপি
                </h3>
                <span className="text-[9px] font-mono text-slate-500 bg-slate-950 px-2 py-0.5 rounded border border-cyan-950/60 uppercase">
                  ACTIVE USERS: {allUsers?.length || 0}
                </span>
              </div>

              {/* Minimal beautiful bento list of users */}
              <div className="space-y-2.5 max-h-[380px] overflow-y-auto pr-1">
                {allUsers?.map((user) => {
                  return (
                    <div 
                      key={user.name} 
                      className="bg-slate-950/60 border border-cyan-950/40 rounded-lg p-3 space-y-1.5 hover:border-cyan-900 transition-all flex flex-col text-[11px]"
                    >
                      <div className="flex justify-between items-center">
                        <div className="flex items-center gap-2">
                          <img 
                            src={user.avatar} 
                            alt={user.name} 
                            className="w-5.5 h-5.5 rounded-full border border-cyan-950"
                            referrerPolicy="no-referrer"
                          />
                          <span className="font-semibold text-slate-200 truncate max-w-[100px] font-sans">{user.name}</span>
                        </div>
                        <span className="text-[9px] font-mono text-yellow-500 font-bold bg-[#140f09] px-1 rounded uppercase border border-yellow-950/40">
                          {user.rank}
                        </span>
                      </div>
                      
                      <div className="grid grid-cols-2 gap-2 text-left font-mono text-[10px] pt-1">
                        <div className="bg-[#0b1220] p-1.5 rounded flex flex-col">
                          <span className="text-[8px] text-slate-500 uppercase">ব্যালেন্স</span>
                          <span className="text-emerald-400 font-bold text-[11.5px]">{user.balance.toFixed(2)} ৳</span>
                        </div>
                        <div className="bg-[#0b1220] p-1.5 rounded flex flex-col">
                          <span className="text-[8px] text-slate-500 uppercase">পয়েন্ট</span>
                          <span className="text-cyan-400 font-bold text-[11.5px]">{user.points} XP</span>
                        </div>
                      </div>

                      {/* Small action trigger shortcut */}
                      <button
                        onClick={() => {
                          setSelectedUserToEdit(user);
                          const element = document.getElementById("advanced-wallet-editor-target");
                          if(element) element.scrollIntoView({ behavior: 'smooth' });
                        }}
                        className="w-full text-center py-1 bg-cyan-950/50 hover:bg-cyan-950 border border-cyan-950 text-[9px] font-mono text-cyan-400 hover:text-white rounded transition-colors uppercase"
                      >
                        সরাসরি সমন্বয় করুন →
                      </button>
                    </div>
                  );
                })}
              </div>
            </div>

            {/* Right: Consolidated Real-time Ledger Log and Search/Filter section */}
            <div className="lg:col-span-8 bg-[#090d16] border border-cyan-950 rounded-xl p-4.5 space-y-4">
              
              {/* Log Header with filter buttons */}
              <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-b border-cyan-950 pb-3">
                <div>
                  <h3 className="text-xs font-mono font-bold text-white uppercase tracking-wider flex items-center gap-1.5">
                    <TermIcon className="w-4 h-4 text-[#39ff14]" />
                    রেভিনিউ ক্যাশ ও এক্সপি লিংকেড লেজার রেজিস্ট্রি (Transactions Log)
                  </h3>
                  <p className="text-[10px] text-slate-400 mt-0.5">
                    রিয়েল-টাইমে সংঘটিত প্রতিটি ব্যালেন্স বা পয়েন্ট লেনদেনের ডিজিটাল সিগনেচার ট্র্যাকিং বুক।
                  </p>
                </div>
                
                {showMonthDetail && (
                  <button
                    onClick={() => setShowMonthDetail(null)}
                    className="text-[9px] font-mono font-black bg-cyan-950 hover:bg-cyan-900 text-red-400 px-2.5 py-1 rounded border border-red-950 flex items-center gap-1"
                  >
                    ✕ রিমুভ মাস ফিল্টার ({showMonthDetail})
                  </button>
                )}
              </div>

              {/* Filters Toolbox panel */}
              <div className="grid grid-cols-1 sm:grid-cols-4 gap-2.5 bg-[#050912] border border-cyan-950/80 p-3 rounded-xl">
                
                {/* Search query box */}
                <div className="space-y-1">
                  <label className="block text-[8px] font-mono text-slate-500 uppercase">লেনদেন সার্চ:</label>
                  <input
                    type="text"
                    placeholder="খুঁজুন (যেমন: রেফারেল)..."
                    value={ledgerSearch}
                    onChange={(e) => setLedgerSearch(e.target.value)}
                    className="w-full text-[10px] font-mono bg-[#090d16] border border-cyan-950/80 rounded p-1.5 focus:border-[#00f0ff] focus:outline-none text-white"
                  />
                </div>

                {/* Filter by User */}
                <div className="space-y-1">
                  <label className="block text-[8px] font-mono text-slate-500 uppercase">ব্যবহারকারী ফিল্টার:</label>
                  <select
                    value={ledgerFilterUser}
                    onChange={(e) => setLedgerFilterUser(e.target.value)}
                    className="w-full text-[10px] font-mono bg-[#090d16] border border-cyan-950/80 rounded p-1.5 text-white cursor-pointer focus:outline-none"
                  >
                    <option value="all">সব সদস্য (All)</option>
                    {allUsers?.map(u => (
                      <option key={u.name} value={u.name}>{u.name}</option>
                    ))}
                  </select>
                </div>

                {/* Filter by Currency BDT vs XP */}
                <div className="space-y-1">
                  <label className="block text-[8px] font-mono text-slate-500 uppercase">কারেন্সি ফিল্টার:</label>
                  <select
                    value={ledgerFilterCurrency}
                    onChange={(e) => setLedgerFilterCurrency(e.target.value)}
                    className="w-full text-[10px] font-mono bg-[#090d16] border border-cyan-950/80 rounded p-1.5 text-white cursor-pointer focus:outline-none"
                  >
                    <option value="all">সব কারেন্সি</option>
                    <option value="BDT">শুধুমাত্র BDT টাকা ৳</option>
                    <option value="XP">শুধুমাত্র XP পয়েন্ট ⚡</option>
                  </select>
                </div>

                {/* Filter by Channel Type */}
                <div className="space-y-1">
                  <label className="block text-[8px] font-mono text-slate-500 uppercase">চ্যানেল/উৎস ফিল্টার:</label>
                  <select
                    value={ledgerFilterType}
                    onChange={(e) => setLedgerFilterType(e.target.value)}
                    className="w-full text-[10px] font-mono bg-[#090d16] border border-cyan-950/80 rounded p-1.5 text-white cursor-pointer focus:outline-none"
                  >
                    <option value="all">সব ক্যাটাগরি</option>
                    <option value="post">টিউটোরিয়াল বোনাস (Post)</option>
                    <option value="comment">পোস্ট ফিডব্যাক (Comment)</option>
                    <option value="referral">আমন্ত্রণ বোনাস (Referral)</option>
                    <option value="forum">কমিউনিটি ফোরাম (Forum)</option>
                    <option value="admin">অ্যাডমিন ক্রেডিট (Admin Hand)</option>
                    <option value="other">অন্যান্য (Other)</option>
                  </select>
                </div>

              </div>

              {/* Transactions log explorer table */}
              <div className="bg-slate-950 border border-cyan-950 rounded-xl overflow-hidden font-mono text-[11px] relative">
                
                <div className="max-h-[300px] overflow-y-auto divide-y divide-cyan-950/40">
                  <table className="w-full text-left table-fixed">
                    <thead>
                      <tr className="bg-[#0a0e17] border-b border-cyan-950 text-slate-400 font-bold uppercase tracking-wider text-[9px]">
                        <th className="py-2.5 px-3 w-[25%]">মেম্বার</th>
                        <th className="py-2.5 px-3 w-[45%]">লেনদেনের কারণ ও রেকর্ড বুক</th>
                        <th className="py-2.5 px-3 w-[15%] text-right">পরিমাণ</th>
                        <th className="py-2.5 px-3 w-[15%] text-right">লিংক</th>
                      </tr>
                    </thead>
                    <tbody className="divide-y divide-cyan-950/30">
                      {filteredLedger.length === 0 ? (
                        <tr>
                          <td colSpan={4} className="py-8 text-center text-slate-500 italic text-[11px]">
                            কোনো লেজার রেকর্ড ফিল্টারের সাথে মেলেনি। ফিল্টার রিসেট করুন।
                          </td>
                        </tr>
                      ) : (
                        filteredLedger.map((tx) => {
                          const isPositive = tx.amount >= 0;
                          const isBDT = tx.currency === "BDT";
                          
                          return (
                            <tr 
                              key={tx.id} 
                              className="hover:bg-[#070d18]/60 transition-colors border-b border-cyan-950/20 group text-[10px]"
                            >
                              <td className="py-2.5 px-3 text-left">
                                <div className="flex items-center gap-1.5">
                                  <div className="w-1.5 h-1.5 rounded-full bg-cyan-400" />
                                  <span className="text-white font-sans font-semibold truncate block" title={tx.username}>
                                    {tx.username}
                                  </span>
                                </div>
                                <span className="text-[8px] text-slate-500 block uppercase font-mono tracking-tight">
                                  {tx.timestamp.split('T')[0]}
                                </span>
                              </td>
                              <td className="py-2.5 px-3 text-slate-300 truncate" title={tx.reason}>
                                <div className="font-semibold text-slate-200 truncate">{tx.reason}</div>
                                <div className="text-[8px] text-slate-500 font-mono">ID: {tx.id} • Type: {tx.linkType || "other"}</div>
                              </td>
                              <td className="py-2.5 px-3 text-right">
                                <span className={`font-bold font-mono text-[11px] ${
                                  isBDT 
                                    ? isPositive ? "text-emerald-400" : "text-rose-400"
                                    : isPositive ? "text-[#00f0ff]" : "text-purple-400"
                                }`}>
                                  {isPositive ? "+" : ""}{tx.amount} {isBDT ? "৳" : "XP"}
                                </span>
                              </td>
                              <td className="py-2.5 px-3 text-right">
                                <button
                                  onClick={() => {
                                    setSelectedLedgerEntry(tx);
                                    addNotification(`লেনদেন আইডি (${tx.id}) এর ডাটা ট্র্যাকিং ওপেন করা হয়েছে।`, "system");
                                  }}
                                  className="text-[9.5px] font-black text-[#00f0ff] hover:underline bg-cyan-950/80 border border-cyan-900 px-1.5 py-0.5 rounded cursor-pointer leading-tight font-mono tracking-wide"
                                >
                                  DETAILS
                                </button>
                              </td>
                            </tr>
                          );
                        })
                      )}
                    </tbody>
                  </table>
                </div>

                {/* Micro summary of listed result */}
                <div className="bg-[#040811] border-t border-cyan-950 px-3 py-2 text-slate-500 flex justify-between text-[9px] font-mono">
                  <span>ফিল্টার্ড লেনদেন: {filteredLedger.length} টি</span>
                  <span>মোট ডাটা রেকর্ড বুক: {ledger.length} টি</span>
                </div>
              </div>

            </div>

          </div>

          {/* Detailed Earning Links drill-down Information overlay panel */}
          {selectedLedgerEntry && (
            <div className="bg-[#0b1321] border-2 border-cyan-500/30 rounded-xl p-5 space-y-4 animate-fadeIn relative text-[11.5px]">
              <div className="absolute top-0 right-0 p-3">
                <button
                  onClick={() => setSelectedLedgerEntry(null)}
                  className="p-1 px-2.5 bg-slate-950 text-slate-300 hover:text-white rounded border border-cyan-950 text-xs font-mono font-bold cursor-pointer"
                >
                  ✕ বন্ধ করুন
                </button>
              </div>

              <div className="border-b border-cyan-950 pb-2.5 pr-20">
                <h4 className="text-xs font-mono font-bold text-yellow-400 uppercase tracking-widest flex items-center gap-1.5">
                  🔍 লেজার ডাটা ট্র্যাকার ডিটেইলস (Ledger Link Drilldown Engine)
                </h4>
                <p className="text-[10px] text-slate-400 font-sans mt-0.5">
                  নিচের স্পেসিফিকেশন থেকে ক্লিক করা ট্রানজেকশনের সম্পূর্ণ কারণ, উৎস চ্যানেল এবং মেম্বার আইডেন্টিটি রুট ম্যাপ নিশ্চিত করুন।
                </p>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-3 gap-4 font-mono text-[11px]">
                
                <div className="bg-slate-950 p-3 rounded-lg border border-cyan-950 space-y-1">
                  <span className="text-[8.5px] text-slate-500 uppercase">ট্রানজেকশন আইডি:</span>
                  <div className="text-white font-bold font-mono text-xs">{selectedLedgerEntry.id}</div>
                  <span className="text-[8px] text-cyan-400/70 block uppercase">SECURE DIGITAL WRAPPED SIGNATURE</span>
                </div>

                <div className="bg-slate-950 p-3 rounded-lg border border-cyan-950 space-y-1">
                  <span className="text-[8.5px] text-slate-500 uppercase">বেনেফিসিয়ারি নাম (মেম্বার):</span>
                  <div className="text-emerald-400 font-bold font-sans text-xs">{selectedLedgerEntry.username}</div>
                  <span className="text-[8px] font-mono text-slate-400">কমিউনিটি রেজিস্টার্ড সদস্য বা এআই কন্ট্রিবিউটর</span>
                </div>

                <div className="bg-slate-950 p-3 rounded-lg border border-cyan-950 space-y-1">
                  <span className="text-[8.5px] text-slate-500 uppercase">লেনদেনের পরিমান (BDT/XP):</span>
                  <div className={`text-sm font-black ${selectedLedgerEntry.amount >= 0 ? 'text-emerald-400' : 'text-rose-400'}`}>
                    {selectedLedgerEntry.amount} {selectedLedgerEntry.currency}
                  </div>
                  <span className="text-[8px] text-slate-400">ব্যালেন্স পরিশোধ বা পয়েন্ট স্কোর এলাইনমেন্ট</span>
                </div>

              </div>

              <div className="p-4 bg-slate-950/80 border border-cyan-950 rounded-lg space-y-3 font-sans">
                <div className="text-xs text-slate-400">
                  <span className="font-mono text-[9px] block text-cyan-400 mb-0.5 font-bold uppercase">লেনদেনের বিস্তারিত ব্যাখ্যা (Reason & Method):</span>
                  <p className="text-slate-200 text-xs leading-relaxed">
                     {selectedLedgerEntry.reason}
                  </p>
                </div>

                <div className="text-[11px] font-mono flex flex-col sm:flex-row justify-between gap-2.5 pt-2 border-t border-cyan-950/60 text-slate-400">
                  <span>উৎস চ্যানেল: <strong className="text-white uppercase font-sans">{selectedLedgerEntry.linkType || "system"} Panel</strong></span>
                  <span>সময়কাল: <strong className="text-white">{selectedLedgerEntry.timestamp} (লাইভ ট্র্যাকার)</strong></span>
                  
                  {selectedLedgerEntry.linkId && (
                    <span>আইডি লিংক রেফারেন্স: 
                      <span className="bg-[#0c1627] text-[#00f0ff] border border-cyan-900 px-1.5 py-0.5 rounded ml-1 text-[10px] font-bold">
                        {selectedLedgerEntry.linkId}
                      </span>
                    </span>
                  )}
                </div>

                <div className="flex justify-end gap-2 pt-2.5 text-xs font-mono">
                  {selectedLedgerEntry.linkType === "post" && selectedLedgerEntry.linkId && (
                    <span className="text-cyan-400 bg-cyan-950/50 border border-cyan-900 px-3 py-1 rounded text-[10px]">
                      🔗 কন্টেন্ট লিংক সোর্স সাকসেসফুলি অ্যাসোসিয়েটেড
                    </span>
                  )}
                  {selectedLedgerEntry.linkType === "referral" && (
                    <span className="text-yellow-400 bg-yellow-950/50 border border-yellow-900/50 px-3 py-1 rounded text-[10px]">
                      👥 ৫-জেনারেশন মেম্বার রেফারেল নেটওয়ার্ক সিঙ্কড
                    </span>
                  )}
                  <button
                    onClick={() => setSelectedLedgerEntry(null)}
                    className="bg-[#00f0ff] hover:bg-cyan-400 text-slate-950 font-bold px-4 py-1 rounded text-[10.5px] cursor-pointer"
                  >
                    বিবরণ বন্ধ করুন
                  </button>
                </div>
              </div>

            </div>
          )}

        </div>
      )}
      {/* ====================================================================================================== */}

      {/* 1. CREATOR CONTENT STUDIO & PERSONAL POSTS MANAGER */}
      <div className="bg-[#090d16] border border-cyan-500/20 rounded-2xl p-6 shadow-2xl relative overflow-hidden text-left">
        {/* Neon Cyber Glow Accent */}
        <div className="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-[#00f0ff] via-purple-500 to-[#39ff14]" />
        
        <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-5 pb-4 border-b border-cyan-950/80">
          <div>
            <h2 className="text-lg font-bold font-sans tracking-tight text-white flex items-center gap-2">
              <BookOpen className="w-5.5 h-5.5 text-cyan-400" />
              আমার কন্টেন্ট ও টিউটোরিয়াল পাবলিশিং ম্যানেজার
            </h2>
            <p className="text-xs text-slate-400 mt-1 font-mono">
              {isMasterAdmin && masterView 
                ? "সিস্টেম মাস্টার মোড: সমস্ত কন্টেন্ট ও আর্টিফিশিয়াল ইন্টেলিজেন্স পোস্ট লোড করা হয়েছে।"
                : "আপনার সাবমিটকৃত কন্টেন্টগুলোর লাইভ রিডারশিপ মনিটাইজেশন ও আর্নিং ট্র্যাক করুন।"}
            </p>
          </div>

          {/* Master View toggle only for Tarik Rahman */}
          {isMasterAdmin && (
            <div className="flex items-center gap-2 bg-[#050912] border border-cyan-950 px-3.5 py-1.5 rounded-xl">
              <label htmlFor="master-view-checkbox" className="text-[10px] font-mono text-yellow-500 cursor-pointer uppercase select-none">
                ⚙️ মাস্টার ওভাররাইড ভিউ (সব পোস্ট):
              </label>
              <input
                id="master-view-checkbox"
                type="checkbox"
                checked={masterView}
                onChange={(e) => setMasterView(e.target.checked)}
                className="w-3.5 h-3.5 accent-yellow-500 cursor-pointer"
              />
            </div>
          )}
        </div>

        {/* Live editing segment */}
        {editingPost && (
          <form onSubmit={handleSaveEdit} className="bg-[#050912] border border-cyan-500/30 rounded-xl p-5 mb-6 space-y-4">
            <h3 className="text-xs font-mono font-bold text-[#00f0ff] uppercase flex items-center gap-1.5">
              <Edit3 className="w-4 h-4" /> টিউটোরিয়াল সম্পাদন মোড (Advanced Editor)
            </h3>

            <div className="space-y-3 font-sans text-xs">
              <div>
                <label className="block text-[10px] font-mono text-slate-400 uppercase mb-1">আর্টিকেল শিরোনাম:</label>
                <input
                  type="text"
                  required
                  value={editingPost.title}
                  onChange={(e) => setEditingPost({ ...editingPost, title: e.target.value })}
                  className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500 p-2 text-slate-100 rounded-lg outline-none"
                />
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                  <label className="block text-[10px] font-mono text-slate-400 uppercase mb-1">ক্যাটাগরি:</label>
                  <select
                    value={editingPost.category}
                    onChange={(e) => setEditingPost({ ...editingPost, category: e.target.value })}
                    className="w-full bg-slate-950 border border-cyan-950 p-2 text-slate-200 rounded-lg outline-none"
                  >
                    <option value="Hacking">Hacking</option>
                    <option value="SEO Guide">SEO Guide</option>
                    <option value="Online Earning">Online Earning</option>
                    <option value="Android Tech">Android Tech</option>
                  </select>
                </div>
                <div>
                  <label className="block text-[10px] font-mono text-slate-400 uppercase mb-1">ট্যাগস (কমা দিন):</label>
                  <input
                    type="text"
                    value={editingPost.tags?.join(", ") || ""}
                    onChange={(e) => setEditingPost({ ...editingPost, tags: e.target.value.split(",").map(t => t.trim()) })}
                    className="w-full bg-slate-950 border border-cyan-950 p-2 text-slate-200 rounded-lg outline-none"
                  />
                </div>
              </div>

              <div>
                <label className="block text-[10px] font-mono text-slate-400 uppercase mb-1">সংক্ষিপ্ত ভূমিকা (Excerpt):</label>
                <input
                  type="text"
                  required
                  value={editingPost.excerpt}
                  onChange={(e) => setEditingPost({ ...editingPost, excerpt: e.target.value })}
                  className="w-full bg-slate-950 border border-cyan-950 p-2 text-slate-100 rounded-lg outline-none"
                />
              </div>

              <div>
                <label className="block text-[10px] font-mono text-slate-400 uppercase mb-1">বিস্তারিত কনটেন্ট (Markdown Supported):</label>
                <textarea
                  required
                  rows={6}
                  value={editingPost.content}
                  onChange={(e) => setEditingPost({ ...editingPost, content: e.target.value })}
                  className="w-full bg-slate-950 border border-cyan-950 p-2 text-slate-100 rounded-lg outline-none resize-none"
                />
              </div>
            </div>

            <div className="flex justify-end gap-2.5 pt-2">
              <button
                type="button"
                onClick={() => setEditingPost(null)}
                className="bg-slate-950 border border-cyan-950 hover:bg-slate-900 text-slate-400 hover:text-slate-200 text-xs font-mono font-bold px-4 py-2 rounded-lg cursor-pointer"
              >
                বাতিল করুন
              </button>
              <button
                type="submit"
                className="bg-[#00f0ff] hover:bg-cyan-400 text-slate-950 text-xs font-sans font-bold px-4 py-2 rounded-lg cursor-pointer shadow-[0_0_10px_rgba(0,240,255,0.2)]"
              >
                ✓ পরিবর্তন সংরক্ষণ করুন
              </button>
            </div>
          </form>
        )}

        {/* Personal list data view */}
        {myPosts.length === 0 ? (
          <div className="text-center py-8 bg-[#050912] border border-cyan-950 rounded-xl space-y-2">
            <p className="text-xs font-mono text-slate-500">আপনার এখনো কোনো প্রকাশিত কন্টেন্ট আর্টিকেল ড্যাশবোর্ডে যোগ করা নেই।</p>
            <p className="text-[11px] text-slate-400 font-sans">"এড নিউ পোস্ট" ট্যাব থেকে চমৎকার একটি টিউটোরিয়াল লিখে পাবলিশ করুন এবং মনিটাইজেশন ইনকাম শুরু করুন!</p>
          </div>
        ) : (
          <div className="overflow-x-auto custom-scrollbar">
            <table className="w-full text-xs font-mono border-collapse">
              <thead>
                <tr className="border-b border-cyan-950/80 text-slate-500">
                  <th className="text-left py-3 px-2 uppercase font-extrabold text-[10px]">টাইটেল ও ক্যাটাগরি</th>
                  <th className="text-center py-3 px-2 uppercase font-extrabold text-[10px]">পারফরম্যান্স</th>
                  <th className="text-right py-3 px-2 uppercase font-extrabold text-[10px]">উপাজিত ব্যালেন্স</th>
                  <th className="text-center py-3 px-2 uppercase font-extrabold text-[10px]">অ্যাকশন</th>
                </tr>
              </thead>
              <tbody>
                {myPosts.map((post) => (
                  <tr key={post.id} className="border-b border-cyan-950/30 hover:bg-cyan-950/10 transition-colors">
                    <td className="py-3 px-2 text-left">
                      <span className="font-sans font-bold text-slate-200 hover:text-[#00f0ff] block leading-relaxed max-w-[220px] md:max-w-md truncate">
                        {post.title}
                      </span>
                      <div className="flex items-center gap-1.5 mt-1 text-[9px] text-slate-500">
                        <span className="bg-cyan-950/80 text-cyan-400 border border-cyan-900/40 px-1.5 py-0.2 rounded uppercase">
                          {post.category}
                        </span>
                        <span>•</span>
                        <span>{post.timestamp}</span>
                      </div>
                    </td>
                    <td className="py-3 px-2 text-center">
                      <div className="flex items-center justify-center gap-3">
                        <span className="flex items-center gap-1 text-slate-300">
                          <Eye className="w-3.5 h-3.5 text-cyan-500" /> {post.views}
                        </span>
                        <span className="flex items-center gap-1 text-slate-300">
                          <ThumbsUp className="w-3.5 h-3.5 text-emerald-500" /> {post.likes}
                        </span>
                      </div>
                    </td>
                    <td className="py-3 px-2 text-right">
                      <span className="text-emerald-400 font-bold font-mono block">
                        {getPostEarnings(post)} ৳
                      </span>
                      <span className="text-[8px] text-slate-500 font-sans mt-0.5 block">এডসেন্স রেভিনিউ</span>
                    </td>
                    <td className="py-3 px-2 text-center">
                      <div className="flex items-center justify-center gap-2">
                        <button
                          type="button"
                          onClick={() => setEditingPost({ ...post })}
                          className="bg-cyan-950 hover:bg-cyan-900 text-cyan-400 p-1.5 rounded border border-cyan-900/40 cursor-pointer"
                          title="এডিট করুন"
                        >
                          <Edit3 className="w-3.5 h-3.5" />
                        </button>
                        <button
                          type="button"
                          onClick={() => handleDeletePost(post.id)}
                          className="bg-rose-950/60 hover:bg-rose-900 text-rose-300 p-1.5 rounded border border-rose-900/40 cursor-pointer"
                          title="ডিলিট করুন"
                        >
                          <Trash2 className="w-3.5 h-3.5" />
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>

      {/* 2. MAIN COGNITIVE OWNER LEVEL CONTROLS PANEL */}
      <div className="bg-[#090d16] border border-cyan-900/40 rounded-xl p-6 shadow-2xl relative overflow-hidden mt-6">
        {/* Visual RGB line decorator */}
        <div className="absolute top-0 left-0 w-full h-[2.5px] bg-gradient-to-r from-red-500 via-yellow-400 via-cyan-400 to-indigo-500" />

        <div className="mb-6 relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
          <div>
            <h2 className="text-xl font-bold font-sans tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-500 flex items-center gap-2">
              <Settings className="w-5.5 h-5.5 text-yellow-400 animate-spin-slow" />
              iloveyoubd.com এডমিন সিস্টেম সেটিং
            </h2>
            <p className="text-xs text-slate-400 mt-1 font-mono">
              মনিটাইজেশন পেমেন্ট, এআই অটো-রানিং এবং কাস্টম থিম কন্ট্রোল প্যানেল
            </p>
          </div>
          <span className="text-[10px] font-mono bg-yellow-950/80 text-yellow-500 border border-yellow-800/40 px-2 py-1 rounded">
            OWNER LEVEL SECURED
          </span>
        </div>

        {!isMasterAdmin ? (
          <div className="bg-[#050912]/80 border border-cyan-950 rounded-xl p-6 text-center space-y-3">
            <Lock className="w-8 h-8 text-yellow-500 mx-auto animate-pulse" />
            <h3 className="text-sm font-bold text-slate-200">🔒 এডমিন ভিউ সুরক্ষিত (Secured owner control)</h3>
            <p className="text-xs text-slate-400 max-w-md mx-auto leading-relaxed">
              হ্যালো {currentUser.name}! আপনার অ্যাকাউন্ট টাইপটি ক্রিয়েটর পোর্টালে নিবন্ধিত। গুগল অ্যাডসেন্স কোডিং এপিআই মেম্বার এপিআই সেটিং, ক্লায়েন্ট রুলস ও বিশেষ সেটিংস শুধুমাত্র তারেক রহমান পরিবর্তন করতে পারবেন।
            </p>
          </div>
        ) : (
          <div className="space-y-4 relative z-10">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              
              {/* Left Column: Economy and Glow Toggles */}
              <div className="space-y-4">
                
                {/* 1. Economy & Referral Bonus Control */}
                <div className="bg-[#070b13] border border-cyan-950 rounded-lg p-4">
                  <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-2 border-b border-cyan-950/60 pb-1.5 font-bold flex justify-between items-center">
                    <span>১. রেফারাল ও সাইনআপ বোনাস কন্ট্রোল</span>
                    <span className="text-[9px] text-[#00f0ff] animate-pulse">ECONOMY ENGINE</span>
                  </h3>
                  
                  <div className="grid grid-cols-2 gap-3 pt-1.5">
                    <div>
                      <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1" title="রেফারার পাবে (টাকা)">Referrer Reward Taka</label>
                      <div className="flex items-center gap-1.5">
                        <input
                          type="number"
                          step="1"
                          min="0"
                          value={settings.referralBonusTaka !== undefined ? settings.referralBonusTaka : 10}
                          onChange={(e) => onUpdateSettings({ referralBonusTaka: parseFloat(e.target.value) })}
                          className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-[#00f0ff] focus:outline-none rounded text-slate-200"
                        />
                        <span className="text-xs font-mono text-[#00f0ff]">৳</span>
                      </div>
                    </div>

                    <div>
                      <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1" title="রেফারার পাবে (পয়েন্ট/XP)">Referrer Reward XP</label>
                      <div className="flex items-center gap-1.5">
                        <input
                          type="number"
                          step="10"
                          min="0"
                          value={settings.referralXpReward !== undefined ? settings.referralXpReward : 50}
                          onChange={(e) => onUpdateSettings({ referralXpReward: parseInt(e.target.value) })}
                          className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-[#00f0ff] focus:outline-none rounded text-slate-200"
                        />
                        <span className="text-xs font-mono text-slate-500">XP</span>
                      </div>
                    </div>

                    <div>
                      <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1" title="নতুন জয়েনকারী পাবে (টাকা)">Referee Register BDT</label>
                      <div className="flex items-center gap-1.5">
                        <input
                          type="number"
                          step="1"
                          min="0"
                          value={settings.refereeBonusTaka !== undefined ? settings.refereeBonusTaka : 10}
                          onChange={(e) => onUpdateSettings({ refereeBonusTaka: parseFloat(e.target.value) })}
                          className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-[#00f0ff] focus:outline-none rounded text-slate-200"
                        />
                        <span className="text-xs font-mono text-[#00f0ff]">৳</span>
                      </div>
                    </div>

                    <div>
                      <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1" title="নতুন জয়েনকারী পাবে (পয়েন্ট/XP)">Referee Register XP</label>
                      <div className="flex items-center gap-1.5">
                        <input
                          type="number"
                          step="10"
                          min="0"
                          value={settings.refereeXpReward !== undefined ? settings.refereeXpReward : 100}
                          onChange={(e) => onUpdateSettings({ refereeXpReward: parseInt(e.target.value) })}
                          className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-[#00f0ff] focus:outline-none rounded text-slate-200"
                        />
                        <span className="text-xs font-mono text-slate-500">XP</span>
                      </div>
                    </div>
                  </div>
                </div>

                {/* 1.1 Special Glows and Real-Time Neon Toggles */}
                <div className="bg-[#070b13] border border-cyan-950 rounded-lg p-4">
                  <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-2 border-b border-cyan-950/60 pb-1.5 font-bold flex justify-between items-center">
                    <span>১.১. স্পেশাল গ্লো ও আরজিবি থিম সেটিংস</span>
                    <span className="text-[9px] text-[#00f0ff] animate-pulse">LIVE CONTROL</span>
                  </h3>
                  
                  {/* Macro One-click Action Buttons */}
                  <div className="grid grid-cols-2 gap-2 mb-3">
                    <button
                      type="button"
                      onClick={() => onUpdateSettings({
                        glowSinglePost: true,
                        glowComments: true,
                        glowUserProfile: true,
                        glowChatbot: true,
                        glowQa: true,
                        glowStories: true,
                        glowWallet: true,
                        glowSearchIndex: true,
                        enableFooterRgb: true,
                        enableRgbEffects: true
                      })}
                      className="bg-cyan-950/80 hover:bg-cyan-900 border border-cyan-800 text-[10px] font-sans font-bold py-1.5 px-2 rounded text-cyan-400 text-center cursor-pointer transition-all active:scale-95"
                    >
                      💡 সকল প্রভাব চালু (All Glows ON)
                    </button>
                    <button
                      type="button"
                      onClick={() => onUpdateSettings({
                        glowSinglePost: false,
                        glowComments: false,
                        glowUserProfile: false,
                        glowChatbot: false,
                        glowQa: false,
                        glowStories: false,
                        glowWallet: false,
                        glowSearchIndex: false,
                        enableFooterRgb: false,
                        enableRgbEffects: false
                      })}
                      className="bg-red-950/40 hover:bg-red-900/40 border border-red-950 text-[10px] font-sans font-bold py-1.5 px-2 rounded text-red-400 text-center cursor-pointer transition-all active:scale-95"
                    >
                      🚫 সকল প্রভাব বন্ধ (All Glows OFF)
                    </button>
                  </div>

                  <div className="grid grid-cols-2 gap-2 text-[10px] font-mono mb-3">
                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400">
                      <input
                        type="checkbox"
                        checked={settings.glowSinglePost !== false}
                        onChange={(e) => onUpdateSettings({ glowSinglePost: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      সিঙ্গেল কন্টেন্ট কার্ড গ্লো
                    </label>

                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400">
                      <input
                        type="checkbox"
                        checked={settings.glowComments !== false}
                        onChange={(e) => onUpdateSettings({ glowComments: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      কমেন্ট বক্স গ্লো ফ্রেম
                    </label>

                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400">
                      <input
                        type="checkbox"
                        checked={settings.glowUserProfile !== false}
                        onChange={(e) => onUpdateSettings({ glowUserProfile: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      ইউজার প্রোফাইল কার্ড গ্লো
                    </label>

                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400">
                      <input
                        type="checkbox"
                        checked={settings.glowChatbot !== false}
                        onChange={(e) => onUpdateSettings({ glowChatbot: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      মায়া চ্যাটবোর্ড বর্ডার গ্লো
                    </label>

                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400">
                      <input
                        type="checkbox"
                        checked={settings.glowQa !== false}
                        onChange={(e) => onUpdateSettings({ glowQa: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      প্রশ্ন-উত্তর ফোরাম গ্লো
                    </label>

                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400">
                      <input
                        type="checkbox"
                        checked={settings.glowStories !== false}
                        onChange={(e) => onUpdateSettings({ glowStories: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      স্টোরি শেলফ আরজিবি বর্ডার
                    </label>

                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400">
                      <input
                        type="checkbox"
                        checked={settings.glowWallet !== false}
                        onChange={(e) => onUpdateSettings({ glowWallet: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      ওয়ালেট ব্যালেন্স ফ্রেম গ্লো
                    </label>

                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400">
                      <input
                        type="checkbox"
                        checked={settings.glowSearchIndex !== false}
                        onChange={(e) => onUpdateSettings({ glowSearchIndex: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      সার্চ ইনডেক্স বর্ডার গ্লো
                    </label>

                    <label className="flex items-center gap-1.5 text-slate-400 cursor-pointer hover:text-cyan-400 col-span-2">
                      <input
                        type="checkbox"
                        checked={settings.enableFooterRgb !== false}
                        onChange={(e) => onUpdateSettings({ enableFooterRgb: e.target.checked })}
                        className="accent-cyan-500 w-3 h-3 cursor-pointer"
                      />
                      ফুটার আরজিবি লাইটিং লাইন (Footer Neon Border)
                    </label>
                  </div>

                  {/* Location specific customizable color picks */}
                  <div className="border-t border-cyan-950/40 pt-2.5 mt-2 text-left">
                    <span className="text-[10px] font-mono text-[#00f0ff] uppercase tracking-widest block font-bold mb-2">
                      🎯 প্রতিটি খাতের জন্য নির্দিষ্ট কালার এডিট করুন (Specific Glow Colors):
                    </span>
                    <div className="grid grid-cols-2 gap-2 text-[10px] font-mono bg-[#05080e]/50 p-2.5 border border-cyan-950/60 rounded mb-2">
                      {settings.glowSinglePost !== false && (
                        <div className="flex justify-between items-center bg-[#090d16] p-1.5 border border-cyan-950 rounded">
                          <span className="text-slate-400">পোস্ট কার্ড:</span>
                          <input 
                            type="color" 
                            value={settings.glowSinglePostColor || "#00f0ff"} 
                            onChange={(e) => onUpdateSettings({ glowSinglePostColor: e.target.value })} 
                            className="bg-transparent h-5 w-8 cursor-pointer outline-none border-none p-0"
                            title="পোস্ট কার্ড গ্লো কালার"
                          />
                        </div>
                      )}
                      {settings.glowComments !== false && (
                        <div className="flex justify-between items-center bg-[#090d16] p-1.5 border border-cyan-950 rounded">
                          <span className="text-slate-400">কমেন্ট বক্স:</span>
                          <input 
                            type="color" 
                            value={settings.glowCommentsColor || "#ff003c"} 
                            onChange={(e) => onUpdateSettings({ glowCommentsColor: e.target.value })} 
                            className="bg-transparent h-5 w-8 cursor-pointer outline-none border-none p-0"
                            title="কমেন্ট বক্স গ্লো কালার"
                          />
                        </div>
                      )}
                      {settings.glowUserProfile !== false && (
                        <div className="flex justify-between items-center bg-[#090d16] p-1.5 border border-cyan-950 rounded">
                          <span className="text-slate-400">প্রোফাইল কার্ড:</span>
                          <input 
                            type="color" 
                            value={settings.glowUserProfileColor || "#bd00ff"} 
                            onChange={(e) => onUpdateSettings({ glowUserProfileColor: e.target.value })} 
                            className="bg-transparent h-5 w-8 cursor-pointer outline-none border-none p-0"
                            title="প্রোফাইল কার্ড গ্লো কালার"
                          />
                        </div>
                      )}
                      {settings.glowChatbot !== false && (
                        <div className="flex justify-between items-center bg-[#090d16] p-1.5 border border-cyan-950 rounded">
                          <span className="text-slate-400">মায়া চ্যাটবট:</span>
                          <input 
                            type="color" 
                            value={settings.glowChatbotColor || "#00f0ff"} 
                            onChange={(e) => onUpdateSettings({ glowChatbotColor: e.target.value })} 
                            className="bg-transparent h-5 w-8 cursor-pointer outline-none border-none p-0"
                            title="মায়া চ্যাটবট গ্লো কালার"
                          />
                        </div>
                      )}
                      {settings.glowQa !== false && (
                        <div className="flex justify-between items-center bg-[#090d16] p-1.5 border border-cyan-950 rounded">
                          <span className="text-slate-400">প্রশ্ন ফোরাম:</span>
                          <input 
                            type="color" 
                            value={settings.glowQaColor || "#39ff14"} 
                            onChange={(e) => onUpdateSettings({ glowQaColor: e.target.value })} 
                            className="bg-transparent h-5 w-8 cursor-pointer outline-none border-none p-0"
                            title="প্রশ্ন ফোরাম গ্লো কালার"
                          />
                        </div>
                      )}
                      {settings.glowStories !== false && (
                        <div className="flex justify-between items-center bg-[#090d16] p-1.5 border border-cyan-950 rounded">
                          <span className="text-slate-400">স্টোরি শেলফ:</span>
                          <input 
                            type="color" 
                            value={settings.glowStoriesColor || "#bd00ff"} 
                            onChange={(e) => onUpdateSettings({ glowStoriesColor: e.target.value })} 
                            className="bg-transparent h-5 w-8 cursor-pointer outline-none border-none p-0"
                            title="স্টোরি শেলফ গ্লো কালার"
                          />
                        </div>
                      )}
                      {settings.glowWallet !== false && (
                        <div className="flex justify-between items-center bg-[#090d16] p-1.5 border border-cyan-950 rounded">
                          <span className="text-slate-400">ওয়ালেট ব্যালেন্স:</span>
                          <input 
                            type="color" 
                            value={settings.glowWalletColor || "#39ff14"} 
                            onChange={(e) => onUpdateSettings({ glowWalletColor: e.target.value })} 
                            className="bg-transparent h-5 w-8 cursor-pointer outline-none border-none p-0"
                            title="ওয়ালেট ফ্রেম গ্লো কালার"
                          />
                        </div>
                      )}
                      {settings.glowSearchIndex !== false && (
                        <div className="flex justify-between items-center bg-[#090d16] p-1.5 border border-cyan-950 rounded">
                          <span className="text-slate-400">সার্চ ইনডেক্স:</span>
                          <input 
                            type="color" 
                            value={settings.glowSearchIndexColor || "#eab308"} 
                            onChange={(e) => onUpdateSettings({ glowSearchIndexColor: e.target.value })} 
                            className="bg-transparent h-5 w-8 cursor-pointer outline-none border-none p-0"
                            title="সার্চ ইনডেক্স গ্লো কালার"
                          />
                        </div>
                      )}
                    </div>
                  </div>

                  {/* Default Theme & User customizable permission triggers */}
                  <div className="border-t border-cyan-950/40 pt-2.5 mt-2.5 space-y-2 text-left">
                    <span className="text-[9px] font-mono text-cyan-500 uppercase tracking-widest block font-bold mb-1">
                      থিম ও ভিজিটর কালার সেটিংস (Themes & Visitors):
                    </span>
                    
                    <div className="space-y-1.5">
                      <div className="flex justify-between items-center text-[10px] font-mono">
                        <span className="text-slate-400">ডিফল্ট থিম স্টাইল:</span>
                        <select
                          value={settings.defaultThemePreset || "cyber_dark"}
                          onChange={(e) => onUpdateSettings({ defaultThemePreset: e.target.value as any })}
                          className="bg-[#05080e] text-cyan-400 border border-cyan-950 rounded px-1.5 py-0.5 outline-none cursor-pointer focus:border-cyan-500"
                        >
                          <option value="cyber_dark">Cyberpunk Neon Dark</option>
                          <option value="emerald_glow">Cosmic Emerald Glow</option>
                          <option value="light_clean">Elegant Light Mode</option>
                          <option value="electric_sunset_dark">Sunset Violet Dark</option>
                          <option value="classic_midnight">Midnight Navy Classic</option>
                        </select>
                      </div>

                      <div className="flex justify-between items-center text-[10px] font-mono">
                        <span className="text-slate-400">ইউজারদের থিম কাস্টমাইজার এক্সেস:</span>
                        <select
                          value={settings.allowUserCustomizer || "yes_logged_in"}
                          onChange={(e) => onUpdateSettings({ allowUserCustomizer: e.target.value as any })}
                          className="bg-[#05080e] text-cyan-400 border border-cyan-950 rounded px-1.5 py-0.5 outline-none cursor-pointer focus:border-cyan-500"
                        >
                          <option value="yes_logged_in">সদস্যরাই পারবে (Logged Members)</option>
                          <option value="yes_everyone">সবাই পারবে (All Visitors)</option>
                          <option value="no_admin_only">ফিজড/এডমিন সিদ্ধান্ত (Admin Only)</option>
                        </select>
                      </div>

                      {/* Respect Mobile Theme Match Preferred Mode */}
                      <div className="flex justify-between items-center text-[10px] font-mono border-t border-cyan-950/40 pt-2">
                        <span className="text-slate-400">মোবাইল/ব্রাউজার ডিফল্ট মোড সিঙ্ক:</span>
                        <select
                          value={settings.respectDeviceDefaultTheme ? "yes" : "no"}
                          onChange={(e) => onUpdateSettings({ respectDeviceDefaultTheme: e.target.value === "yes" })}
                          className="bg-[#05080e] text-cyan-400 border border-cyan-950 rounded px-1.5 py-0.5 outline-none cursor-pointer focus:border-cyan-500"
                        >
                          <option value="yes">চালু (Auto Device Dark/Light)</option>
                          <option value="no">বন্ধ (Strict Admin Preset)</option>
                        </select>
                      </div>

                      {/* Continuous Color Loop Shifter Flow */}
                      <div className="flex justify-between items-center text-[10px] font-mono border-t border-cyan-950/40 pt-2">
                        <span className="text-slate-400">ঘূর্ণায়মান আরজিবি কালার লুপ (Rgb Loop):</span>
                        <button
                          type="button"
                          onClick={() => onUpdateSettings({ enableRgbLoopShift: !settings.enableRgbLoopShift })}
                          className={`text-[9px] font-mono py-0.5 px-2 rounded cursor-pointer transition-all ${
                            settings.enableRgbLoopShift 
                              ? "bg-cyan-950 text-[#00f0ff] border border-cyan-500 font-bold" 
                              : "bg-slate-950 text-slate-500 border border-cyan-950/30"
                          }`}
                        >
                          {settings.enableRgbLoopShift ? "● রানিং (ACTIVE ROTATION)" : "○ বন্ধ (STATIC)"}
                        </button>
                      </div>

                      {/* AdSense Approval Booster Mode Toggle */}
                      <div className="flex justify-between items-center text-[10px] font-mono border-t border-cyan-950/40 pt-2">
                        <div className="flex flex-col text-left">
                          <span className="text-emerald-400 font-bold flex items-center gap-1">
                            🛡️ অ্যাডসেন্স রিভিউয়ার স্পেশাল মুড:
                          </span>
                          <span className="text-[8px] text-slate-400">Safe, clean layout, no aggressive shifting</span>
                        </div>
                        <button
                          type="button"
                          onClick={() => onUpdateSettings({ 
                            enableAdSenseSafeMode: !settings.enableAdSenseSafeMode,
                            enableRgbEffects: settings.enableAdSenseSafeMode ? true : false, // automatically dial down glows to respect reviewer
                            rgbStyle: settings.enableAdSenseSafeMode ? "classic_neo" : "adsense_safe"
                          })}
                          className={`text-[9px] font-mono py-1 px-2 rounded cursor-pointer transition-all ${
                            settings.enableAdSenseSafeMode 
                              ? "bg-emerald-950 text-emerald-400 border border-emerald-500 font-bold" 
                              : "bg-slate-950 text-slate-500 border border-cyan-950/40"
                          }`}
                        >
                          {settings.enableAdSenseSafeMode ? "● চালু (ADSENSE COMFECT)" : "○ বন্ধ (CYBER MOD)"}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
{/* Feature toggles */}
              <div className="bg-[#070b13] border border-cyan-950 rounded-lg p-4">
                <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-2 border-b border-cyan-950/60 pb-1.5 font-bold">
                  ২. সাইট মডিউলস অন / অফ করুন
                </h3>
                
                <div className="space-y-2 pt-1.5">
                  <div className="flex justify-between items-center bg-[#090d16] p-2 border border-cyan-950 rounded">
                    <span className="text-xs text-slate-300 font-mono">গ্লোবাল এআই অটো-পোস্টিং কোবল:</span>
                    <input
                      type="checkbox"
                      checked={settings.autoAIPosting}
                      onChange={(e) => onUpdateSettings({ autoAIPosting: e.target.checked })}
                      className="w-4 h-4 text-cyan-500 accent-cyan-400 border-none outline-none cursor-pointer"
                    />
                  </div>

                  <div className="flex justify-between items-center bg-[#090d16] p-2 border border-cyan-950 rounded">
                    <span className="text-xs text-slate-300 font-mono">ট্রেন্ডিং লাইভ নোটিশ ব্যানার:</span>
                    <input
                      type="checkbox"
                      checked={settings.enableInteractiveNotice}
                      onChange={(e) => onUpdateSettings({ enableInteractiveNotice: e.target.checked })}
                      className="w-4 h-4 text-cyan-500 accent-cyan-400 border-none outline-none cursor-pointer"
                    />
                  </div>

                  <div className="flex justify-between items-center bg-[#090d16] p-2 border border-cyan-950 rounded">
                    <span className="text-xs text-slate-300 font-mono">आरजीবি (RGB) এনিমেশন বর্ডারস:</span>
                    <input
                      type="checkbox"
                      checked={settings.enableRgbEffects}
                      onChange={(e) => onUpdateSettings({ enableRgbEffects: e.target.checked })}
                      className="w-4 h-4 text-cyan-500 accent-cyan-400 border-none outline-none cursor-pointer"
                    />
                  </div>

                  {settings.enableRgbEffects && (
                    <div className="bg-[#090d16] p-2 border border-cyan-950 rounded space-y-2">
                      <div className="flex justify-between items-center">
                        <span className="text-xs text-slate-300 font-mono">লাইভ আরজিবি ডিজাইন প্রেসেট:</span>
                        <select
                          value={settings.rgbStyle || "classic_neo"}
                          onChange={(e) => onUpdateSettings({ rgbStyle: e.target.value })}
                          className="bg-[#05080e] text-cyan-400 font-mono text-[11px] border border-cyan-900 rounded px-2 py-1 outline-none cursor-pointer focus:border-cyan-500"
                        >
                          <option value="classic_neo">Classic Neon Multi-Color</option>
                          <option value="aurora_glow">Cosmic Cyber Aurora</option>
                          <option value="toxic_matrix">Toxic Matrix Neon</option>
                          <option value="electric_sunset">Electric Sunset Glow</option>
                          <option value="cyber_amber">Golden Amber Core</option>
                          <option value="neon_blue_mono">Mono Neon Ice Blue</option>
                        </select>
                      </div>
                      <span className="text-[10px] text-slate-500 block font-mono">
                        💡 এটি সাইটের মূল লেআউটের চারপাশে থাকা আরজিবি থিম ও গ্লো পালস ডিজাইন পরিবর্তন করবে।
                      </span>
                    </div>
                  )}

                  <div className="flex justify-between items-center bg-[#090d16] p-2 border border-cyan-950 rounded">
                    <span className="text-xs text-slate-300 font-mono">গুগল এডসেন্স ব্যানার বিজ্ঞাপন:</span>
                    <input
                      type="checkbox"
                      checked={settings.enableGoogleAds}
                      onChange={(e) => onUpdateSettings({ enableGoogleAds: e.target.checked })}
                      className="w-4 h-4 text-cyan-500 accent-cyan-400 border-none outline-none cursor-pointer"
                    />
                  </div>

                  <div className="flex justify-between items-center bg-[#090d16] p-2 border border-cyan-950 rounded">
                    <span className="text-xs text-slate-300 font-mono">লাইভ স্টোরি ফিচার (Stories Option):</span>
                    <input
                      type="checkbox"
                      checked={settings.enableStories !== false}
                      onChange={(e) => onUpdateSettings({ enableStories: e.target.checked })}
                      className="w-4 h-4 text-cyan-500 accent-cyan-400 border-none outline-none cursor-pointer"
                    />
                  </div>

                  {settings.enableGoogleAds && (
                    <div className="mt-2 text-left">
                      <label className="block text-[9px] font-mono text-cyan-500 uppercase tracking-wider mb-1">কাস্টম এডসেন্স এম্বেড কোড (Ad Code Slot):</label>
                      <textarea
                        rows={2}
                        value={settings.advertisementSnippet}
                        onChange={(e) => onUpdateSettings({ advertisementSnippet: e.target.value })}
                        className="w-full text-[10px] font-mono bg-[#050911] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded p-2 text-slate-300"
                      />
                    </div>
                  )}

                  <div className="flex justify-between items-center bg-[#090d16] p-2 border border-cyan-950 rounded">
                    <span className="text-xs text-slate-300 font-mono">RGB অ্যানিমেশন স্পিড:</span>
                    <select
                      value={settings.rgbEffectSpeed}
                      onChange={(e) => onUpdateSettings({ rgbEffectSpeed: e.target.value as any })}
                      className="text-xs font-mono bg-[#0b121e] border border-cyan-950 rounded p-1 text-cyan-400"
                    >
                      <option value="slow">স্লো মোশন</option>
                      <option value="medium">স্ট্যান্ডার্ড</option>
                      <option value="fast">র‌্যাপিড ট্রেইল</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            {/* Right column: TrickBD mood style theme & withdrawal requests approve */}
            <div className="space-y-4">
              <div className="bg-[#070b13] border border-[#ffaa00]/10 rounded-lg p-4">
                <div className="flex justify-between items-center border-b border-cyan-950/60 pb-1.5 mb-2.5">
                  <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-wider font-bold flex items-center gap-1">
                    <Sparkles className="w-4 h-4 text-[#ffae00]" />
                    ৩. ট্রিকবিডি স্টাইল: অডিয়েন্স মনোভাব বা মুড থিম
                  </h3>
                </div>
                <p className="text-[11px] text-slate-400 mb-2 font-mono">
                  ইউজার ও ভিজিটরদের মনোভাব ও সাইবার কালার প্যালেট পরিবর্তন করুন:
                </p>

                <div className="space-y-1.5">
                  {moodSkins.map((ms) => (
                    <button
                      key={ms.id}
                      onClick={() => onMoodChange(ms.id)}
                      className={`w-full text-left font-mono text-xs p-2 rounded relative flex items-center justify-between transition-all ${
                        selectedMood === ms.id
                          ? "bg-[#091d17] border border-cyan-400 text-white shadow-[0_0_8px_rgba(0,189,255,0.2)]"
                          : "bg-[#090d16] border border-cyan-950 text-slate-400 hover:border-slate-800"
                      }`}
                    >
                      <span>{ms.name}</span>
                      <div className="w-3.5 h-3.5 rounded-full border border-slate-700" style={{ backgroundColor: ms.accent }} />
                    </button>
                  ))}
                </div>
              </div>

              <div className="bg-[#070b13] border border-cyan-950 rounded-lg p-4">
                <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-2 border-b border-cyan-950/60 pb-1.5 font-bold flex items-center justify-between">
                  <span>৪. টাকা উইথড্র রেজিস্ট্রি (পেন্ডিং পেমেন্ট)</span>
                  <span className="text-[10px] text-slate-400">Total Approved: {totalWithdrawn} ৳</span>
                </h3>

                <div className="space-y-2 max-h-[145px] overflow-y-auto custom-scrollbar">
                  {withdrawalRequests.length === 0 ? (
                    <div className="text-[10px] font-mono text-slate-500 py-3 text-center">
                      কোন উইথড্রা পেন্ডিং রিকোয়েস্ট নেই।
                    </div>
                  ) : (
                    withdrawalRequests.map((req) => (
                      <div key={req.id} className="bg-[#090d16] p-2 rounded-md border border-cyan-950/60 flex justify-between items-center text-xs">
                        <div>
                          <div className="font-semibold text-slate-200 font-sans">{req.author}</div>
                          <div className="text-[9px] text-slate-500 font-mono flex items-center gap-1.5">
                            <span>বিকাশ/নগদ: {req.wallet}</span>
                            <span>•</span>
                            <span className="text-yellow-500">{req.amount} ৳</span>
                          </div>
                        </div>
                        {req.status === 'pending' ? (
                          <button
                            onClick={() => onApproveWithdrawal(req.id)}
                            className="bg-emerald-500/80 hover:bg-emerald-400 text-[#070b13] font-bold text-[10px] font-mono px-2 py-1 rounded cursor-pointer"
                          >
                            অনুমোদন
                          </button>
                        ) : (
                          <span className="text-emerald-500 text-[10px] font-mono flex items-center gap-0.5">
                            <Check className="w-3 h-3 text-emerald-400" /> পেইড
                          </span>
                        )}
                      </div>
                    ))
                  )}
                </div>
              </div>
            </div>
          </div>
        )}

        {/* AI Autopilot Panel (Always preserved for master admins) */}
        {isMasterAdmin && (
          <div className="mt-6 pt-6 border-t border-cyan-950/50 relative z-10">
            <AutopilotHub
              settings={settings}
              onUpdateSettings={onUpdateSettings}
              onTriggerInstantAutopilot={onTriggerInstantAutopilot}
              isGeneratingPost={isGeneratingAIPost}
              selectedMood={selectedMood}
            />
          </div>
        )}

        {/* Maya API Pool Rotation Manager */}
        {isMasterAdmin && (
          <div className="mt-6 pt-6 border-t border-cyan-950/50 relative z-10">
            <div className="bg-[#070b13] border border-cyan-500/20 rounded-xl p-5 shadow-inner">
              <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-2 border-b border-cyan-950 pb-3 mb-4">
                <div>
                  <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-widest font-extrabold flex items-center gap-1.5">
                    <Cpu className="w-4 h-4 text-cyan-400 animate-pulse" />
                    ৫. মায়া এআই (Maya AI) এক্সিকিউティブ কন্ট্রোল ও ১০টি ক্লাউড কী রোটেশন পোর্টাল
                  </h3>
                  <p className="text-[10px] text-slate-400 font-sans mt-0.5 font-sans leading-relaxed">
                    গুগল ক্লাউড জেমিনি কোটা সীমা এড়াতে একসাথে ১০টি API Key সেভ রাখুন। কোনো কি নিষ্ক্রিয় বা রেইট লিমিটেড হলে সিস্টেম অটোমেটিক পরবর্তী সচল কি ডিস্ট্রিবিউট করবে।
                  </p>
                </div>
                <span className="text-[9px] font-mono bg-cyan-950 text-cyan-400 px-2 py-0.5 rounded border border-cyan-800/40">
                  ACTIVE KEYS: {slots.filter(Boolean).length}/10
                </span>
              </div>

              {/* 10 Key Input Grid */}
              <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
                {slots.map((keyVal, idx) => (
                  <div
                    key={idx}
                    className={`p-2.5 rounded-lg border transition-all ${
                      keyVal 
                        ? "bg-[#050f14] border-emerald-950 hover:border-emerald-500/30" 
                        : "bg-[#050912] border-cyan-950/60 hover:border-cyan-500/10"
                    }`}
                  >
                    <div className="flex justify-between items-center mb-1 text-[9px] font-mono">
                      <span className={`${keyVal ? "text-emerald-400 font-bold" : "text-cyan-500"} flex items-center gap-0.5`}>
                        <Key className="w-2.5 h-2.5" /> কী #{idx + 1 < 10 ? `0${idx + 1}` : idx + 1}
                      </span>
                      {keyVal ? (
                        <span className="text-emerald-400 bg-emerald-950/40 px-1 py-0.2 rounded font-sans text-[8px] flex items-center gap-0.5">
                          ✓ সচল
                        </span>
                      ) : (
                        <span className="text-slate-600 bg-slate-900 px-1 py-0.2 rounded font-sans text-[8px]">
                          ফাঁকা
                        </span>
                      )}
                    </div>
                    
                    <div className="flex items-center gap-1 bg-[#090e1a]/90 rounded border border-cyan-950/70 p-1">
                      <input
                        type="password"
                        value={keyVal}
                        placeholder="AI Key..."
                        onChange={(e) => updateKeySlot(idx, e.target.value)}
                        className="bg-transparent text-slate-200 text-[10px] font-mono px-1 py-0.5 focus:outline-none flex-1 min-w-0"
                      />
                      {keyVal && (
                        <button
                          type="button"
                          onClick={() => clearKeySlot(idx)}
                          className="text-slate-500 hover:text-rose-400 text-xs font-mono font-bold px-1 cursor-pointer"
                          title="মুছে ফেলুন"
                        >
                          &times;
                        </button>
                      )}
                    </div>
                  </div>
                ))}
              </div>

              {/* Advanced Model Instructions and temperature parameter section */}
              <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-5 pt-4 border-t border-cyan-950/40">
                {/* System behavior instructions */}
                <div className="lg:col-span-2 space-y-1.5 text-left">
                  <label className="block text-[10px] font-mono text-cyan-400 uppercase tracking-wider font-semibold">
                    মায়া ক্যারেক্টার বিহেভিয়ার নির্দেশাবলী (System Behavior Instructions)
                  </label>
                  <textarea
                    rows={2}
                    value={settings.mayaSystemInstruction}
                    onChange={(e) => onUpdateSettings({ mayaSystemInstruction: e.target.value })}
                    className="w-full text-xs font-mono bg-[#050912] border border-cyan-950 focus:border-cyan-500/80 rounded-lg p-2 text-slate-200 focus:outline-none placeholder-slate-600 resize-none font-mono"
                    placeholder="You are Maya, the expert AI of..."
                  />
                </div>

                {/* Kreativ level selector */}
                <div className="space-y-1.5 text-left bg-[#090e1a] border border-cyan-950 rounded-lg p-3">
                  <div className="flex justify-between items-center text-[10px] font-mono">
                    <span className="text-cyan-400 uppercase font-semibold">ক্রিয়েশন মেকানিজম (Temperature)</span>
                    <span className="text-yellow-400 font-bold bg-yellow-950/80 px-2 py-0.5 rounded border border-yellow-850/40">
                      {settings.mayaTemperature} Temp
                    </span>
                  </div>
                  
                  <input
                    type="range"
                    min="0.1"
                    max="1.0"
                    step="0.1"
                    value={settings.mayaTemperature}
                    onChange={(e) => onUpdateSettings({ mayaTemperature: parseFloat(e.target.value) })}
                    className="w-full accent-cyan-400 bg-cyan-950/60 h-1.5 rounded-lg mt-2 cursor-pointer"
                  />
                  <div className="flex justify-between text-[8px] text-slate-500 font-mono mt-1">
                    <span>লজিক্যাল (0.1)</span>
                    <span>স্ট্যান্ডার্ড (0.7)</span>
                    <span>আর্টিস্টিক (1.0)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        )}

        {/* 6. ADVANCED USER WALLET BALANCE & XP POINTS DELEGATED MANIPULATION PANEL */}
        {isMasterAdmin && (
          <div id="advanced-wallet-editor-target" className="mt-6 pt-6 border-t border-cyan-950/50 relative z-10 text-left scroll-mt-6">
            <div className="bg-[#070b13] border border-cyan-500/20 rounded-xl p-5 shadow-inner">
              <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-2 border-b border-cyan-950 pb-3 mb-4">
                <div>
                  <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-widest font-extrabold flex items-center gap-1.5">
                    <Users className="w-4 h-4 text-[#00f0ff] animate-pulse" />
                    ৬. ইউজার অ্যাকাউন্ট ও ব্যালেন্স/পয়েন্ট অ্যাডমিনিস্ট্রেশন (User Management & Wallets)
                  </h3>
                  <p className="text-[10px] text-slate-400 font-sans mt-0.5 leading-relaxed">
                    iloveyoubd.com এর যেকোনো রেজিস্টার্ড ইউজারের একাউন্ট ব্যালেন্স (টাকা) এবং এক্সপি (XP) পয়েন্ট সরাসরি অ্যাড করতে বা কেটে নিয়ে কমাতে পারেন।
                  </p>
                </div>
                <span className="text-[9px] font-mono bg-cyan-950 text-cyan-400 px-2 py-0.5 rounded border border-cyan-800/40">
                  TOTAL MEMBERS: {allUsers?.length || 0}
                </span>
              </div>

              {/* Selected User Editor Panel */}
              {selectedUserToEdit && (
                <div className="bg-[#0c1624] border-2 border-[#00f0ff]/40 rounded-xl p-5 mb-5 space-y-4">
                  <div className="flex justify-between items-center border-b border-cyan-900/40 pb-2">
                    <div className="flex items-center gap-2.5">
                      <img
                        src={selectedUserToEdit.avatar}
                        alt={selectedUserToEdit.name}
                        className="w-8 h-8 rounded-full border border-cyan-400"
                        referrerPolicy="no-referrer"
                      />
                      <div>
                        <h4 className="text-sm font-bold text-white font-sans">{selectedUserToEdit.name}</h4>
                        <span className="text-[9px] font-mono text-cyan-400 bg-cyan-950 px-1.5 rounded uppercase">{selectedUserToEdit.rank}</span>
                      </div>
                    </div>
                    <button
                      type="button"
                      onClick={() => {
                        setSelectedUserToEdit(null);
                        setAdjustmentTaka("");
                        setAdjustmentPoints("");
                        setAbsoluteTaka("");
                        setAbsolutePoints("");
                      }}
                      className="text-slate-400 hover:text-white text-xs font-mono font-bold cursor-pointer bg-slate-950 px-2.5 py-1 rounded border border-cyan-950"
                    >
                      ✕ বন্ধ করুন
                    </button>
                  </div>

                  {/* Editing grid */}
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {/* Wallet Balance (Taka) Editing Form */}
                    <div className="bg-[#060b13] border border-cyan-950/60 rounded-xl p-4 space-y-3">
                      <div className="flex items-center gap-1.5 text-emerald-400 text-xs font-mono font-bold uppercase">
                        <Coins className="w-4 h-4" /> ওয়ালেট ব্যালেন্স (টাকা BDT)
                      </div>
                      
                      <div className="text-[11px] font-mono text-slate-400 flex justify-between">
                        <span>বর্তমান ব্যালেন্স:</span>
                        <span className="text-white font-bold">{selectedUserToEdit.balance.toFixed(2)} ৳ BDT</span>
                      </div>

                      {/* Sub-tabs or options */}
                      <div className="space-y-2.5 pt-1">
                        <div>
                          <label className="block text-[9.5px] font-mono text-slate-400 uppercase mb-1">অপশন ১: ব্যালেন্স যোগ/বিয়োগ করুন (+/- টাকা BDT):</label>
                          <div className="flex items-center gap-1.5">
                            <input
                              type="text"
                              placeholder="যেমন: ৫০ অথবা -৩০"
                              value={adjustmentTaka}
                              onChange={(e) => {
                                setAdjustmentTaka(e.target.value);
                                setAbsoluteTaka(""); // clear direct input to avoid confusion
                              }}
                              className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-2 focus:border-cyan-400 focus:outline-none rounded text-white"
                            />
                            <span className="text-xs font-mono text-slate-400">৳</span>
                          </div>
                        </div>

                        {/* Instants buttons */}
                        <div className="flex flex-wrap gap-1.5">
                          {["+10", "+50", "+100", "-10", "-50", "-100"].map((val) => (
                            <button
                              key={val}
                              type="button"
                              onClick={() => {
                                setAdjustmentTaka(val);
                                setAbsoluteTaka("");
                              }}
                              className="text-[9px] font-mono px-1.5 py-1 bg-slate-950 hover:bg-cyan-950 border border-cyan-950 text-cyan-400 hover:text-white rounded cursor-pointer transition-colors"
                            >
                              {val} ৳
                            </button>
                          ))}
                        </div>

                        <div className="relative flex py-1 items-center">
                          <div className="flex-grow border-t border-cyan-950/40"></div>
                          <span className="flex-shrink mx-2 text-[8.5px] font-mono text-slate-600 uppercase">অথবা সরাসরি সেট করুন</span>
                          <div className="flex-grow border-t border-cyan-950/40"></div>
                        </div>

                        <div>
                          <label className="block text-[9.5px] font-mono text-slate-400 uppercase mb-1">অপশন ২: সরাসরি নির্দিষ্ট মোট টাকা লিখুন (Absolute BDT):</label>
                          <input
                            type="number"
                            min="0"
                            step="0.01"
                            placeholder="যেমন: ২৫০"
                            value={absoluteTaka}
                            onChange={(e) => {
                              setAbsoluteTaka(e.target.value);
                              setAdjustmentTaka(""); // clear delta to avoid confusion
                            }}
                            className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-2 focus:border-cyan-400 focus:outline-none rounded text-white"
                          />
                        </div>
                      </div>
                    </div>

                    {/* XP Points Editing Form */}
                    <div className="bg-[#060b13] border border-cyan-950/60 rounded-xl p-4 space-y-3">
                      <div className="flex items-center gap-1.5 text-cyan-400 text-xs font-mono font-bold uppercase">
                        <Sparkles className="w-4 h-4 text-cyan-400 animate-pulse" /> এক্সপি পয়েন্ট (XP Points)
                      </div>
                      
                      <div className="text-[11px] font-mono text-slate-400 flex justify-between">
                        <span>বর্তমান পয়েন্ট:</span>
                        <span className="text-white font-bold">{selectedUserToEdit.points} XP</span>
                      </div>

                      {/* Sub-tabs or options */}
                      <div className="space-y-2.5 pt-1">
                        <div>
                          <label className="block text-[9.5px] font-mono text-slate-400 uppercase mb-1">অপশন ১: পয়েন্ট যোগ/বিয়োগ করুন (+/- XP):</label>
                          <div className="flex items-center gap-1.5">
                            <input
                              type="text"
                              placeholder="যেমন: ১০০ অথবা -৫০"
                              value={adjustmentPoints}
                              onChange={(e) => {
                                setAdjustmentPoints(e.target.value);
                                setAbsolutePoints(""); // clear direct
                              }}
                              className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-2 focus:border-cyan-400 focus:outline-none rounded text-white"
                            />
                            <span className="text-xs font-mono text-slate-400">XP</span>
                          </div>
                        </div>

                        {/* Instants buttons */}
                        <div className="flex flex-wrap gap-1.5">
                          {["+50", "+100", "+500", "-50", "-100", "-500"].map((val) => (
                            <button
                              key={val}
                              type="button"
                              onClick={() => {
                                setAdjustmentPoints(val);
                                setAbsolutePoints("");
                              }}
                              className="text-[9px] font-mono px-1.5 py-1 bg-slate-950 hover:bg-cyan-950 border border-cyan-950 text-cyan-400 hover:text-white rounded cursor-pointer transition-colors"
                            >
                              {val} XP
                            </button>
                          ))}
                        </div>

                        <div className="relative flex py-1 items-center">
                          <div className="flex-grow border-t border-cyan-950/40"></div>
                          <span className="flex-shrink mx-2 text-[8.5px] font-mono text-slate-600 uppercase">অথবা সরাসরি সেট করুন</span>
                          <div className="flex-grow border-t border-cyan-950/40"></div>
                        </div>

                        <div>
                          <label className="block text-[9.5px] font-mono text-slate-400 uppercase mb-1">অপশন ২: সরাসরি নির্দিষ্ট মোট পয়েন্ট লিখুন (Absolute XP):</label>
                          <input
                            type="number"
                            min="0"
                            placeholder="যেমন: ১০০০"
                            value={absolutePoints}
                            onChange={(e) => {
                              setAbsolutePoints(e.target.value);
                              setAdjustmentPoints(""); // clear delta
                            }}
                            className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-2 focus:border-cyan-400 focus:outline-none rounded text-white"
                          />
                        </div>
                      </div>
                    </div>
                  </div>

                  {/* Apply panel action */}
                  <div className="flex justify-end gap-3 pt-2 border-t border-cyan-900/35">
                    <button
                      type="button"
                      onClick={() => {
                        setSelectedUserToEdit(null);
                        setAdjustmentTaka("");
                        setAdjustmentPoints("");
                        setAbsoluteTaka("");
                        setAbsolutePoints("");
                      }}
                      className="bg-slate-950 border border-cyan-950 text-slate-400 hover:text-white px-4 py-2 rounded-lg text-xs font-mono cursor-pointer transition-colors"
                    >
                      বাতিল করুন
                    </button>

                    <button
                      type="button"
                      onClick={() => {
                        // Perform calculations
                        let newTaka = selectedUserToEdit.balance;
                        let newPoints = selectedUserToEdit.points;

                        // 1. Calculate Taka
                        if (adjustmentTaka) {
                          const parsed = parseFloat(adjustmentTaka);
                          if (!isNaN(parsed)) {
                            newTaka += parsed;
                          }
                        } else if (absoluteTaka) {
                          const parsed = parseFloat(absoluteTaka);
                          if (!isNaN(parsed)) {
                            newTaka = parsed;
                          }
                        }

                        // 2. Calculate Points
                        if (adjustmentPoints) {
                          const parsed = parseInt(adjustmentPoints);
                          if (!isNaN(parsed)) {
                            newPoints += parsed;
                          }
                        } else if (absolutePoints) {
                          const parsed = parseInt(absolutePoints);
                          if (!isNaN(parsed)) {
                            newPoints = parsed;
                          }
                        }

                        // Force floor at 0
                        if (newTaka < 0) newTaka = 0;
                        if (newPoints < 0) newPoints = 0;

                        const diffTaka = newTaka - selectedUserToEdit.balance;
                        const diffPoints = newPoints - selectedUserToEdit.points;

                        if (Math.abs(diffTaka) > 0.001) {
                          onAddLedgerTransaction(
                            selectedUserToEdit.name,
                            parseFloat(diffTaka.toFixed(2)),
                            "BDT",
                            `অ্যাডমিন প্যানেল থেকে ব্যালেন্স সমন্বয় (${diffTaka > 0 ? '+' : ''}${diffTaka.toFixed(2)} BDT)`,
                            "admin_adjust",
                            "admin"
                          );
                        }

                        if (diffPoints !== 0) {
                          onAddLedgerTransaction(
                            selectedUserToEdit.name,
                            diffPoints,
                            "XP",
                            `অ্যাডমিন প্যানেল থেকে পয়েন্ট সমন্বয় (${diffPoints > 0 ? '+' : ''}${diffPoints} XP)`,
                            "admin_adjust",
                            "admin"
                          );
                        }

                        // Update handler
                        onUpdateUserStats(selectedUserToEdit.name, {
                          balance: parseFloat(newTaka.toFixed(2)),
                          points: Math.max(0, newPoints)
                        });

                        // Add notification
                        addNotification(`সফলভাবে অ্যাকাউন্ট আপডেট করা হয়েছে! ইউজার: ${selectedUserToEdit.name}, ব্যালেন্স: ${newTaka.toFixed(2)} ৳, পয়েন্ট: ${newPoints} XP.`, "system");

                        // Reset edit panel
                        setSelectedUserToEdit(null);
                        setAdjustmentTaka("");
                        setAdjustmentPoints("");
                        setAbsoluteTaka("");
                        setAbsolutePoints("");
                      }}
                      className="bg-[#00f0ff] hover:bg-cyan-400 text-slate-950 font-bold px-5 py-2 rounded-lg text-xs font-sans cursor-pointer transition-all shadow-[0_0_15px_rgba(0,240,255,0.3)] flex items-center gap-1.5"
                    >
                      ✓ পরিবর্তন সম্পূর্ণ করুন (Apply)
                    </button>
                  </div>
                </div>
              )}

              {/* Search header & Filter */}
              <div className="flex gap-2.5 mb-4">
                <input
                  type="text"
                  placeholder="ইউজার অনুসন্ধান করুন (ইউজারনেম বা নাম)..."
                  value={searchUserQuery}
                  onChange={(e) => setSearchUserQuery(e.target.value)}
                  className="w-full text-xs font-mono bg-slate-950 border border-cyan-950/80 focus:border-[#00f0ff] focus:outline-none rounded-lg p-2.5 text-white"
                />
                {searchUserQuery && (
                  <button
                    onClick={() => setSearchUserQuery("")}
                    className="px-3 bg-cyan-950/40 hover:bg-cyan-950 border border-cyan-950 text-xs font-mono text-slate-400 rounded-lg cursor-pointer"
                  >
                    Clear
                  </button>
                )}
              </div>

              {/* Users table */}
              <div className="overflow-x-auto custom-scrollbar">
                <table className="w-full text-xs font-mono border-collapse">
                  <thead>
                    <tr className="border-b border-cyan-950 text-slate-500 uppercase font-extrabold text-[9px] tracking-wider">
                      <th className="text-left py-2.5 px-2">ইউজার প্রোফাইল ও পদবি</th>
                      <th className="text-center py-2.5 px-2">ওয়ালেট ব্যালেন্স</th>
                      <th className="text-center py-2.5 px-2">পয়েন্ট ও কন্টেন্ট</th>
                      <th className="text-right py-2.5 px-2">অ্যাকশন</th>
                    </tr>
                  </thead>
                  <tbody>
                    {(allUsers || [])
                      .filter(u => u.name.toLowerCase().includes(searchUserQuery.toLowerCase()))
                      .map((user) => (
                        <tr key={user.name} className="border-b border-cyan-950/30 hover:bg-[#0c1624]/20 transition-all">
                          <td className="py-2.5 px-2 text-left">
                            <div className="flex items-center gap-2">
                              <img
                                src={user.avatar}
                                alt={user.name}
                                className="w-6.5 h-6.5 rounded-full border border-cyan-950"
                                referrerPolicy="no-referrer"
                              />
                              <div>
                                <span className="font-sans font-bold text-slate-200 block text-[11.5px] leading-tight">
                                  {user.name}
                                </span>
                                <span className="text-[8px] font-mono text-cyan-400 font-bold uppercase leading-none block mt-0.5">
                                  {user.rank}
                                </span>
                              </div>
                            </div>
                          </td>
                          <td className="py-2.5 px-2 text-center">
                            <span className="text-emerald-400 font-extrabold text-[12px] font-mono block">
                              {(user.balance || 0).toFixed(2)} ৳
                            </span>
                          </td>
                          <td className="py-2.5 px-2 text-center">
                            <div className="flex flex-col items-center">
                              <span className="text-yellow-500 font-bold text-[10.5px]">
                                {user.points || 0} XP
                              </span>
                              <span className="text-[8px] text-slate-500 mt-0.5">
                                {user.postsPublished || 0} Posts • {user.referredUsers?.length || 0} Refs
                              </span>
                            </div>
                          </td>
                          <td className="py-2.5 px-2 text-right">
                            <button
                              type="button"
                              onClick={() => {
                                setSelectedUserToEdit(user);
                              }}
                              className="bg-cyan-950/70 hover:bg-cyan-950 text-[#00f0ff] hover:text-white border border-cyan-900 px-2.5 py-1 rounded text-[10px] cursor-pointer transition-all"
                            >
                              সমন্বয় করুন ⚙️
                            </button>
                          </td>
                        </tr>
                      ))}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        )}
      </div>

      {/* Modern Custom SEO-First Access Framework Audit Terminal overlay */}
      <SEOAuditTerminal />

      {/* Footer trigger bar */}
      <div className="bg-[#090d16] border border-cyan-950 rounded-xl p-4 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs font-mono text-slate-400 text-left">
        <span className="flex items-center gap-1.5 text-emerald-400 font-semibold">
          <Monitor className="w-4 h-4 text-emerald-400" />
          গুগল এডসেন্স এলাইনমেন্ট: ১-ইনস্ট্যান্ট ইন্ডেক্সিং ফ্রেন্ডলি
        </span>
        <button
          onClick={onGenerateAIPost}
          disabled={isGeneratingAIPost}
          className="bg-cyan-950 text-cyan-300 hover:bg-cyan-900 border border-cyan-400 font-mono font-bold text-xs px-4 py-2 rounded-xl cursor-pointer disabled:opacity-50 transition-colors"
        >
          {isGeneratingAIPost ? "AI কন্টেন্ট তৈরি হচ্ছে..." : "AI কন্টেন্ট ক্রু ট্রিগার (অটো-পোস্ট)"}
        </button>
      </div>

    </div>
  );
}
