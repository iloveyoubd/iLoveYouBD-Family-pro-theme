import React, { useState } from "react";
import { Settings, CheckCircle2, AlertTriangle, Monitor, Sparkles, Key, Sliders, Cpu, RefreshCw, BookOpen, Trash2, Edit3, Eye, ThumbsUp, Terminal as TermIcon, FileText, Check, Lock } from "lucide-react";
import type { AdminSettings, Post, UserStats } from "../types";
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
  addNotification
}: AdminPanelProps) {
  const keysArray = (settings.mayaApiKeys || "").split("\n").map(k => k.trim());
  const slots = Array.from({ length: 10 }, (_, i) => keysArray[i] || "");

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

  return (
    <div className="space-y-6">
      
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
      <div className="bg-[#090d16] border border-cyan-900/40 rounded-xl p-6 shadow-2xl relative overflow-hidden">
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

        {/* Main owner toggles wrapper: if not Tarik, display a visual lock gate with toggle options */}
        {!isMasterAdmin ? (
          <div className="bg-[#050912]/80 border border-cyan-950 rounded-xl p-6 text-center space-y-3">
            <Lock className="w-8 h-8 text-yellow-500 mx-auto animate-pulse" />
            <h3 className="text-sm font-bold text-slate-200">🔒 এডমিন ভিউ সুরক্ষিত (Secured owner control)</h3>
            <p className="text-xs text-slate-500 font-sans max-w-md mx-auto leading-relaxed">
              হ্যালো {currentUser.name}! আপনার অ্যাকাউন্ট টাইপটি ক্রিয়েটর পোর্টালে নিবন্ধিত। গুগল অ্যাডসেন্স কোডিং এপিআই মেম্বার এপিআই সেটিং, ক্লাউড কী রোটেশন টুল এবং টাকা উইথড্র রেজিস্ট্রি শুধুমাত্র মেইন পার্সোনাল অ্যাডমিনের জন্য এক্সক্লুসিভভাবে ডেডিকেটেড।
            </p>
            <p className="text-[11px] text-[#00f0ff] font-mono">
              আপনার প্রকাশিত কন্টেন্ট বা রেফারেল মাইলস্টোনগুলো সম্পূর্ণ অ্যাক্সেসযোগ্য রয়েছে।
            </p>
          </div>
        ) : (
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 relative z-10">
            
            {/* Left column: AdSense revenue share & payment adjustments */}
            <div className="space-y-4">
              <div className="bg-[#070b13] border border-cyan-950 rounded-lg p-4">
                <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-4 border-b border-cyan-950/60 pb-1.5 font-bold">
                  ১. গুগল এডসেন্স মনিটাইজেশন এবং রেভেনিউ স্প্লিট
                </h3>
                
                <div className="space-y-4">
                  <div>
                    <div className="flex justify-between items-center text-xs text-slate-300 font-mono mb-1">
                      <span>এডসেন্স রেভিনিউ শেয়ার ৫% থেকে ৮০% সেট করুন:</span>
                      <span className="text-yellow-400 font-bold text-sm bg-yellow-950 px-2 py-0.5 rounded border border-yellow-800/30">
                        {settings.revenueSharePercent}% Author Share
                      </span>
                    </div>
                    <input
                      type="range"
                      min="5"
                      max="80"
                      step="5"
                      value={settings.revenueSharePercent}
                      onChange={(e) => onUpdateSettings({ revenueSharePercent: parseInt(e.target.value) })}
                      className="w-full accent-cyan-400 bg-slate-800"
                    />
                    <p className="text-[10px] text-slate-500 font-mono mt-1">
                      * এডসেন্স অ্যাড থেকে আপনার ৩০০০ টাকা ইনকাম হলে ইউজাররা {settings.revenueSharePercent}% ({3000 * (settings.revenueSharePercent / 100)} টাকা) কন্টেন্ট বোনাস হিসেবে পাবে।
                    </p>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-3 gap-2 pt-2 border-t border-cyan-950/40">
                    <div>
                      <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1">Payout Per post View</label>
                      <div className="flex items-center gap-1.5">
                        <input
                          type="number"
                          step="0.01"
                          min="0.01"
                          value={settings.payoutPerView}
                          onChange={(e) => onUpdateSettings({ payoutPerView: parseFloat(e.target.value) })}
                          className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-cyan-400 focus:outline-none rounded text-slate-200"
                        />
                        <span className="text-xs font-mono text-slate-400">৳</span>
                      </div>
                    </div>

                    <div>
                      <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1">Payout per post Like</label>
                      <div className="flex items-center gap-1.5">
                        <input
                          type="number"
                          step="0.05"
                          min="0.1"
                          value={settings.payoutPerLike}
                          onChange={(e) => onUpdateSettings({ payoutPerLike: parseFloat(e.target.value) })}
                          className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-cyan-400 focus:outline-none rounded text-slate-200"
                        />
                        <span className="text-xs font-mono text-slate-400">৳</span>
                      </div>
                    </div>

                    <div>
                      <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1">Payout On Publish</label>
                      <div className="flex items-center gap-1.5">
                        <input
                          type="number"
                          step="0.5"
                          min="1.0"
                          value={settings.payoutPerPublish}
                          onChange={(e) => onUpdateSettings({ payoutPerPublish: parseFloat(e.target.value) })}
                          className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-cyan-400 focus:outline-none rounded text-slate-200"
                        />
                        <span className="text-xs font-mono text-slate-400">৳</span>
                      </div>
                    </div>
                  </div>

                  {/* 2040 Style Referral Configurations */}
                  <div className="mt-4 pt-4 border-t border-cyan-950/45 space-y-3.5">
                    <span className="text-[10px] font-mono font-bold text-emerald-400 uppercase tracking-widest block">
                      ৩. রেফারেল কমিশন ও জয়েনিং প্রাইজ কনফিগারেশন
                    </span>
                    
                    <div className="grid grid-cols-1 sm:grid-cols-4 gap-2.5">
                      <div>
                        <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1" title="রেফারার পাবে (টাকা)">Referrer Reward Taka</label>
                        <div className="flex items-center gap-1.5">
                          <input
                            type="number"
                            step="1"
                            min="0"
                            value={settings.referralBonusTaka !== undefined ? settings.referralBonusTaka : 10}
                            onChange={(e) => onUpdateSettings({ referralBonusTaka: parseFloat(e.target.value) })}
                            className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-[#39ff14] focus:outline-none rounded text-slate-200"
                          />
                          <span className="text-xs font-mono text-[#39ff14]">৳</span>
                        </div>
                      </div>

                      <div>
                        <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1" title="রেফারার পাবে (পয়েন্ট)">Referrer Reward XP</label>
                        <div className="flex items-center gap-1.5">
                          <input
                            type="number"
                            step="5"
                            min="0"
                            value={settings.referralXpReward !== undefined ? settings.referralXpReward : 50}
                            onChange={(e) => onUpdateSettings({ referralXpReward: parseInt(e.target.value) })}
                            className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 p-1.5 focus:border-[#39ff14] focus:outline-none rounded text-slate-200"
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
                        <label className="block text-[9px] font-mono text-slate-400 uppercase mb-1" title="নতুন জয়েনকারী পাবে (পয়েন্ট)">Referee Register XP</label>
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

                  <div className="flex justify-between items-center bg-[#090d16] p-2 border border-cyan-950 rounded">
                    <span className="text-xs text-slate-300 font-mono">গুগল এডসেন্স ব্যানার বিজ্ঞাপন:</span>
                    <input
                      type="checkbox"
                      checked={settings.enableGoogleAds}
                      onChange={(e) => onUpdateSettings({ enableGoogleAds: e.target.checked })}
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
