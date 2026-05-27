import { useState, useRef } from "react";
import { CreditCard, Download, ShieldCheck, RefreshCw, Cpu, Award } from "lucide-react";

export default function NIDMaker() {
  const [name, setName] = useState("সাইবার ফাইটার");
  const [englishName, setEnglishName] = useState("CYBER FIGHTER");
  const [dob, setDob] = useState("2004-05-12");
  const [nidNo, setNidNo] = useState("985 412 8752");
  const [cyberRank, setCyberRank] = useState("ELITE CRACKER EX");
  const [nidSignature, setNidSignature] = useState("CyberFighter_xx");
  const [avatarSeed, setAvatarSeed] = useState("hacker-matrix");
  const cardRef = useRef<HTMLDivElement>(null);

  const generateRandomNID = () => {
    let nid = "";
    for (let i = 0; i < 10; i++) {
      if (i === 3 || i === 6) nid += " ";
      nid += Math.floor(Math.random() * 10).toString();
    }
    setNidNo(nid);
  };

  const currentAvatarUrl = `https://api.dicebear.com/7.x/bottts/svg?seed=${avatarSeed}&backgroundColor=0d1117`;

  return (
    <div className="bg-[#090d16] border border-cyan-900/40 rounded-xl p-6 shadow-2xl relative overflow-hidden">
      <div className="absolute inset-0 bg-[#0d1624]/20 opacity-30 pointer-events-none" />
      <div className="absolute -top-12 -right-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-3xl" />

      <div className="mb-6 relative z-10">
        <h2 className="text-xl font-bold font-sans tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-indigo-400 flex items-center gap-2">
          <CreditCard className="w-5 h-5 text-cyan-400" />
          বাংলাদেশ স্মার্ট এনআইডি কার্ড জেনারেটর (2040 Cyber-ID Maker)
        </h2>
        <p className="text-xs text-slate-400 mt-1 font-mono">
          আপনার হ্যাকিং ও ফোরাম অ্যাক্টিভিটির জন্য একটি সিকিউর ২০৪০ ডিজিটাল সাইবার এনআইডি জেনারেট করুন
        </p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 relative z-10">
        {/* Left Side Inputs Form */}
        <div className="lg:col-span-5 space-y-4">
          <div className="bg-[#070b13] border border-cyan-950 rounded-lg p-4 space-y-3">
            <div>
              <label className="block text-[11px] font-mono text-cyan-400 uppercase tracking-widest mb-1">নাম (বাংলা):</label>
              <input
                type="text"
                value={name}
                onChange={(e) => setName(e.target.value)}
                className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded p-2 text-slate-100 font-sans"
              />
            </div>

            <div>
              <label className="block text-[11px] font-mono text-cyan-400 uppercase tracking-widest mb-1">Name (English):</label>
              <input
                type="text"
                value={englishName}
                onChange={(e) => setEnglishName(e.target.value)}
                className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded p-2 text-slate-100"
              />
            </div>

            <div className="grid grid-cols-2 gap-2">
              <div>
                <label className="block text-[11px] font-mono text-cyan-400 uppercase tracking-widest mb-1">Date of Birth:</label>
                <input
                  type="date"
                  value={dob}
                  onChange={(e) => setDob(e.target.value)}
                  className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded p-1.5 text-slate-100 font-mono"
                />
              </div>

              <div>
                <label className="block text-[11px] font-mono text-cyan-400 uppercase tracking-widest mb-1">ক্লেভ বা র্যাংক:</label>
                <select
                  value={cyberRank}
                  onChange={(e) => setCyberRank(e.target.value)}
                  className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded p-1.5 text-slate-100 font-mono"
                >
                  <option value="ROOT ADMINISTRATOR">ROOT ADMIN</option>
                  <option value="ELITE CRACKER EX">ELITE CRACKER</option>
                  <option value="CYBER SECURITY EXPERT">CYBER SEC</option>
                  <option value="WHITE HAT CODER">WHITE HAT</option>
                  <option value="JUNIOR PENTESTER">PENTESTER</option>
                </select>
              </div>
            </div>

            <div>
              <div className="flex justify-between items-center mb-1">
                <label className="text-[11px] font-mono text-cyan-400 uppercase tracking-widest">NID Number:</label>
                <button
                  type="button"
                  onClick={generateRandomNID}
                  className="text-[9px] font-mono text-emerald-400 hover:text-emerald-300 flex items-center gap-1"
                >
                  <RefreshCw className="w-2.5 h-2.5" /> র্যান্ডমাইজ
                </button>
              </div>
              <input
                type="text"
                value={nidNo}
                onChange={(e) => setNidNo(e.target.value)}
                className="w-full text-xs font-mono tracking-widest bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded p-2 text-slate-100"
              />
            </div>

            <div>
              <label className="block text-[11px] font-mono text-cyan-400 uppercase tracking-widest mb-1">ডিজিটাল সিগনেচার:</label>
              <input
                type="text"
                value={nidSignature}
                onChange={(e) => setNidSignature(e.target.value)}
                className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded p-2 text-emerald-400 font-mono"
              />
            </div>

            <div>
              <label className="block text-[11px] font-mono text-cyan-400 uppercase tracking-widest mb-1">AI মেগা-ডিভাইস অবতার বীজ (Seed):</label>
              <input
                type="text"
                value={avatarSeed}
                onChange={(e) => setAvatarSeed(e.target.value)}
                placeholder="Type and Avatar dynamic shifts..."
                className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 dark:border-cyan-900 rounded p-2 text-slate-100"
              />
            </div>
          </div>
        </div>

        {/* Right Side Holo NID Render Card */}
        <div className="lg:col-span-7 flex flex-col justify-center items-center">
          <div
            id="smart-nid-card"
            ref={cardRef}
            className="w-full max-w-[420px] aspect-[1.58/1] rounded-2xl bg-gradient-to-br from-[#0b192e] to-[#040810] border-2 border-cyan-400/80 p-4 shadow-[0_0_30px_rgba(0,240,255,0.25)] relative overflow-hidden transition-all duration-300 hover:border-emerald-400"
          >
            {/* Hologram pattern lines overlay */}
            <div className="absolute inset-0 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] bg-[size:100%_4px,3px_100%] pointer-events-none" />
            <div className="absolute -inset-full bg-gradient-to-tr from-transparent via-cyan-400/5 to-transparent rotate-45 animate-pulse pointer-events-none" />

            {/* Republic of Cyber Bangladesh Header */}
            <div className="flex justify-between items-start border-b border-cyan-500/30 pb-2 mb-2 relative">
              <div className="flex items-center gap-1.5">
                <ShieldCheck className="w-5 h-5 text-emerald-400 drop-shadow-[0_0_8px_rgba(52,211,153,0.5)]" />
                <div>
                  <div className="text-[10px] font-bold text-slate-200 uppercase tracking-tight font-sans">গণপ্রজাতন্ত্রী বাংলাদেশ</div>
                  <div className="text-[7.5px] font-bold text-cyan-400 uppercase tracking-wider font-mono">Republic of Cyber Bangladesh</div>
                </div>
              </div>
              <div className="text-right">
                <span className="text-[7px] font-mono bg-cyan-950/80 text-cyan-300 border border-cyan-900 px-1 py-0.5 rounded">
                  SMART NID CARD
                </span>
                <span className="block text-[6px] font-mono text-emerald-400 font-bold mt-0.5">VISION 2040 APPROVED</span>
              </div>
            </div>

            {/* Middle specs */}
            <div className="grid grid-cols-12 gap-2 mt-3 relative">
              {/* Photo Area with scan border */}
              <div className="col-span-4 flex flex-col items-center">
                <div className="w-16 h-16 rounded border border-cyan-500 bg-[#070b13] p-1 relative overflow-hidden group">
                  <img
                    src={currentAvatarUrl}
                    alt="Cyber Avatar Photo"
                    className="w-full h-full object-contain filter hue-rotate-15 contrast-125 saturate-125"
                    referrerPolicy="no-referrer"
                  />
                  {/* Sweep scan bar overlay */}
                  <div className="absolute top-0 left-0 w-full h-[1.5px] bg-red-500 shadow-[0_0_8px_#ef4444] animate-[bounce_2s_infinite]" />
                </div>
                
                {/* Signature area */}
                <div className="mt-1 border-t border-dashed border-cyan-500/40 w-full text-center py-0.5">
                  <div className="text-[8px] font-mono text-emerald-300/80 italic tracking-wider truncate">
                    {nidSignature}
                  </div>
                  <div className="text-[5px] text-slate-400 font-mono scale-[0.85] uppercase">Signature</div>
                </div>
              </div>

              {/* Text metadata values */}
              <div className="col-span-8 flex flex-col justify-between text-left h-[95px]">
                <div className="space-y-[3px]">
                  <div>
                    <span className="text-[6.5px] text-slate-400 font-mono uppercase block leading-none">নাম / Name</span>
                    <span className="text-[9px] font-bold text-white font-sans">{name}</span>
                  </div>
                  <div>
                    <span className="text-[6.5px] text-slate-400 font-mono uppercase block leading-none">English Name</span>
                    <span className="text-[9.5px] font-bold text-cyan-300 font-mono uppercase">{englishName}</span>
                  </div>
                  <div className="grid grid-cols-2 gap-1.5">
                    <div>
                      <span className="text-[6.5px] text-slate-400 font-mono uppercase block leading-none">Date of Birth</span>
                      <span className="text-[8px] font-bold text-white font-mono">{dob}</span>
                    </div>
                    <div>
                      <span className="text-[6.5px] text-slate-400 font-mono block leading-none">CYBER COGNIZANT</span>
                      <span className="text-[8px] font-bold text-emerald-400 font-mono flex items-center gap-0.5">
                        <Award className="w-2.5 h-2.5" /> VIP
                      </span>
                    </div>
                  </div>
                </div>

                {/* Bottom NID Number */}
                <div className="border-t border-cyan-950 pt-1.5">
                  <span className="text-[6px] text-slate-400 block font-mono">NID NO:</span>
                  <span className="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-white to-red-400 tracking-widest font-mono">
                    {nidNo}
                  </span>
                </div>
              </div>
            </div>

            {/* Holographic Chip Symbolism */}
            <div className="absolute bottom-3 left-4 flex items-center gap-1 opacity-70">
              <Cpu className="w-4 h-4 text-cyan-400 animate-pulse" />
              <span className="text-[5px] font-mono text-cyan-500">2040 CRYPTO-SECURED</span>
            </div>

            {/* Back Barcode Sim */}
            <div className="absolute bottom-3 right-4 flex flex-col items-end opacity-65">
              <div className="flex gap-[1.5px] h-3 items-end">
                {[...Array(24)].map((_, i) => (
                  <div
                    key={i}
                    className={`bg-slate-300 ${i % 3 === 0 ? "w-[2px]" : "w-[0.5px]"} h-full`}
                  />
                ))}
              </div>
              <span className="text-[5.5px] font-mono text-[#00f0ff] mt-0.5 scale-[0.8]">{cyberRank}</span>
            </div>
          </div>

          <div className="mt-4 flex gap-2">
            <button
              id="btn-download-id"
              onClick={() => alert(`ID কার্ড জেনারেশন সম্পন্ন হয়েছে!\nনাম: ${englishName}\nপদবী: ${cyberRank}\nএনআইডি নং: ${nidNo}`)}
              className="text-xs font-mono bg-cyan-950 border border-cyan-400 text-cyan-300 hover:bg-cyan-900 font-semibold py-1.5 px-4 rounded flex items-center gap-2 transition-all cursor-pointer"
            >
              <Download className="w-4 h-4" /> ডাউনলোড আইডি মেটাডাটা
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
