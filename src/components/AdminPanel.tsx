import { Settings, CheckCircle2, AlertTriangle, Monitor, Sparkles, Key, Sliders, Cpu, RefreshCw } from "lucide-react";
import type { AdminSettings } from "../types";

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
  onApproveWithdrawal
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

  return (
    <div className="bg-[#090d16] border border-cyan-900/40 rounded-xl p-6 shadow-2xl relative overflow-hidden">
      {/* Visual RGB line decorator */}
      <div className="absolute top-0 left-0 w-full h-[2.5px] bg-gradient-to-r from-red-500 via-yellow-400 via-cyan-400 to-indigo-500" />

      <div className="mb-6 relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
        <div>
          <h2 className="text-xl font-bold font-sans tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-500 flex items-center gap-2">
            <Settings className="w-5.5 h-5.5 text-yellow-400 animate-spin-slow" />
            iloveyoubd.com এডমিন হ্যাকার কন্ট্রোল সেন্টার
          </h2>
          <p className="text-xs text-slate-400 mt-1 font-mono">
            মনিটাইজেশন পেমেন্ট, এআই অটো-রানিং এবং কাস্টম থিম কন্ট্রোল প্যানেল
          </p>
        </div>
        <span className="text-[10px] font-mono bg-yellow-950/80 text-yellow-500 border border-yellow-800/40 px-2 py-1 rounded">
          OWNER LEVEL ACCESS
        </span>
      </div>

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
                <span className="text-xs text-slate-300 font-mono">আরজিবি (RGB) এনিমেশন বর্ডারস:</span>
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
                  <div key={req.id} className="bg-[#090d16] p-2 rounded.md border border-cyan-950/60 flex justify-between items-center text-xs">
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
                        className="bg-emerald-500/80 hover:bg-emerald-400 text-[#070b13] font-bold text-[10px] font-mono px-2 py-1 rounded"
                      >
                        অনুমোদন
                      </button>
                    ) : (
                      <span className="text-emerald-500 text-[10px] font-mono flex items-center gap-0.5">
                        <CheckCircle2 className="w-3 h-3 text-emerald-400" /> পেইড
                      </span>
                    )}
                  </div>
                ))
              )}
            </div>
          </div>
        </div>

      </div>

      {/* ৫. মায়া এআই (Maya AI) এক্সিকিউটিভ কন্ট্রোল ও ১০টি এপিআই কী রোটেশন পুল */}
      <div className="mt-6 pt-6 border-t border-cyan-950/50 relative z-10">
        <div className="bg-[#070b13] border border-cyan-500/20 rounded-xl p-5 shadow-inner">
          <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-2 border-b border-cyan-950 pb-3 mb-4">
            <div>
              <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-widest font-extrabold flex items-center gap-1.5">
                <Cpu className="w-4 h-4 text-cyan-400 animate-pulse" />
                ৫. মায়া এআই (Maya AI) এক্সিকিউটিভ কন্ট্রোল ও ১০টি ক্লাউড কী রোটেশন পোর্টাল
              </h3>
              <p className="text-[10px] text-slate-400 font-sans mt-0.5">
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
                className="w-full text-xs font-mono bg-[#050912] border border-cyan-950 focus:border-cyan-500/80 rounded-lg p-2 text-slate-200 focus:outline-none placeholder-slate-600 resize-none"
                placeholder="You are Maya, the expert AI of..."
              />
            </div>

            {/* Kreativ level selector */}
            <div className="space-y-1.5 text-left bg-[#090e1a] border border-cyan-950 rounded-lg p-3">
              <div className="flex justify-between items-center text-[10px] font-mono">
                <span className="text-cyan-400 uppercase font-semibold">ক্রিয়েটিভিটি লেভেল (Temperature)</span>
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

      <div className="mt-5 pt-3 border-t border-cyan-950 opacity-90 text-[11px] text-slate-400 font-mono flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
        <span className="flex items-center gap-1.5 text-emerald-400 text-xs">
          <Monitor className="w-4 h-4 text-emerald-400" />
          গুগল এডসেন্স স্ট্যাটাস: ২.৫% কোড ইনডেক্স ফ্রেন্ডলি
        </span>
        <button
          onClick={onGenerateAIPost}
          disabled={isGeneratingAIPost}
          className="bg-cyan-950 text-cyan-300 hover:bg-cyan-900 border border-cyan-400 font-mono font-bold text-xs px-3.5 py-1.5 rounded cursor-pointer disabled:opacity-50"
        >
          {isGeneratingAIPost ? "AI কন্টেন্ট তৈরি হচ্ছে..." : "AI কন্টেন্ট ক্রু ট্রিগার (অটো-পোস্ট)"}
        </button>
      </div>
    </div>
  );
}
