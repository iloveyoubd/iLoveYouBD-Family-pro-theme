import React, { useState } from "react";
import { Play, Tv, ShieldAlert, Wifi, RefreshCw, Layers, Monitor, Sliders } from "lucide-react";

interface TVChannel {
  id: string;
  name: string;
  category: string;
  logo: string;
  embedId: string;
  status: "ONLINE" | "DOWN" | "BUFFERING";
  currentShow: string;
}

export default function LiveTV() {
  const channels: TVChannel[] = [
    {
      id: "deepto",
      name: "Deepto TV (দীপ্ত টিভি)",
      category: "Dramas & Entertainment",
      logo: "🔴",
      embedId: "6z_g8Bv0KSc", // Jamuna News/Deepto live fallback stream ID
      status: "ONLINE",
      currentShow: "দীপ্ত বাংলা বিশেষ মেগা ড্রামা"
    },
    {
      id: "ekushey",
      name: "Ekushey TV (একুশে টিভি)",
      category: "Regional & News",
      logo: "🟡",
      embedId: "QeS1PjZ3Y0g",
      status: "ONLINE",
      currentShow: "একুশের সকাল লাইভ খবর"
    },
    {
      id: "somoy",
      name: "Somoy News (সময় নিউজ)",
      category: "24/7 Bangla News",
      logo: "🟦",
      embedId: "N1S6p2y8k9A", // Jamuna News/Somoy live embed fallback representation
      status: "ONLINE",
      currentShow: "ঘণ্টা অনুযায়ী প্রধান সংবাদ"
    },
    {
      id: "deshbidesh",
      name: "Deshe Bideshe (দেশে বিদেশে)",
      category: "International Streaming Feed",
      logo: "🌐",
      embedId: "",
      status: "DOWN",
      currentShow: "Error: Deshe Bideshe (Link Down)"
    },
    {
      id: "musicbangla",
      name: "Music Bangla (মিউজিক বাংলা)",
      category: "Non-stop Bengali Hits",
      logo: "🎵",
      embedId: "fM66o08l84Y",
      status: "ONLINE",
      currentShow: "চিরসবুজ বাংলা গানের মেলা"
    }
  ];

  const [selectedChannel, setSelectedChannel] = useState<TVChannel>(channels[0]);
  const [streamQuality, setStreamQuality] = useState("1080p Ultra-HD");
  const [refreshKey, setRefreshKey] = useState(0);

  const handleRefreshStream = () => {
    setRefreshKey((prev) => prev + 1);
  };

  return (
    <div className="bg-[#090d16] border border-cyan-900/40 rounded-xl p-5 sm:p-7 shadow-2xl relative overflow-hidden">
      {/* Background neon style cyber grids */}
      <div className="absolute inset-0 bg-[radial-gradient(#14243b_1px,transparent_1px)] [background-size:20px_20px] opacity-10 pointer-events-none" />
      
      <div className="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6 border-b border-cyan-950 pb-4 relative z-10">
        <div>
          <h2 className="text-xl font-bold font-sans tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-cyan-400 to-indigo-400 flex items-center gap-2">
            <Tv className="w-5.5 h-5.5 text-emerald-400 animate-pulse" />
            লাইভ টিভি স্ট্রিমিং পোর্টাল (Live TV Hub)
          </h2>
          <p className="text-xs text-slate-400 mt-1 font-mono">
            বাংলাদেশের অগ্রগামী টিভি চ্যানেলসমূহের রিয়েল-টাইম লাইভ সম্প্রচার গেটওয়ে ২০৪০
          </p>
        </div>

        <div className="flex flex-wrap gap-2 text-xs font-mono">
          <div className="flex items-center gap-1.5 bg-[#071510] border border-emerald-950 px-3 py-1.5 rounded-lg text-emerald-400">
            <Wifi className="w-3.5 h-3.5 animate-pulse" />
            <span>ইন্টারনেট গতি: সুপার-অপ্টিমাইজড</span>
          </div>
          <button
            onClick={handleRefreshStream}
            className="flex items-center gap-1 bg-[#0f1b2f] hover:bg-[#1a2d48] border border-cyan-950 px-3 py-1.5 rounded-lg text-cyan-400 transition-all cursor-pointer"
          >
            <RefreshCw className="w-3 h-3" /> রিফ্রেশ স্ট্রিমিং
          </button>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 relative z-10">
        
        {/* Stream Player Area (Left) */}
        <div className="lg:col-span-8 space-y-4">
          <div className="relative aspect-[16/9] w-full bg-black rounded-xl overflow-hidden border-2 border-cyan-950/80 shadow-[0_0_20px_rgba(0,240,255,0.05)]">
            
            {/* If link is down */}
            {selectedChannel.status === "DOWN" ? (
              <div className="absolute inset-0 bg-slate-950 flex flex-col items-center justify-center text-center p-6 space-y-3 font-sans">
                <div className="p-3.5 rounded-full bg-red-950/40 border border-red-500/30 text-red-500 animate-bounce">
                  <ShieldAlert className="w-8 h-8" />
                </div>
                <h3 className="text-sm font-mono font-bold text-red-400 uppercase tracking-widest">
                  {selectedChannel.currentShow}
                </h3>
                <p className="text-xs text-slate-400 max-w-md">
                  দুঃখিত! এই স্ট্রিমিং সার্ভারটির স্যাটেলাইট সংযোগ ডাউন আছে। সাময়িক সমস্যার জন্য আমরা আন্তরিকভাবে দুঃখিত। দয়া করে অন্য চ্যানেল নির্বাচন করুন।
                </p>
              </div>
            ) : (
              /* Play standard YouTube Live Embed stream safely */
              <iframe
                key={`${selectedChannel.id}-${refreshKey}`}
                className="w-full h-full object-cover"
                src={`https://www.youtube.com/embed/${selectedChannel.embedId || "6z_g8Bv0KSc"}?autoplay=1&mute=0`}
                title={selectedChannel.name}
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerPolicy="no-referrer"
                allowFullScreen
              />
            )}

            {/* Glowing active state overlays */}
            <div className="absolute top-3 left-3 flex items-center gap-1.5 bg-black/85 backdrop-blur-sm p-1.5 px-3 rounded-full text-[10px] font-mono border border-cyan-900/60 shadow-lg">
              <span className={`w-2 h-2 rounded-full ${selectedChannel.status === "ONLINE" ? "bg-red-500 animate-pulse" : "bg-slate-500"}`} />
              <span className="text-slate-200 uppercase">{selectedChannel.status === "ONLINE" ? "🔴 LIVE" : "OFFLINE"}</span>
              <span className="text-slate-500">|</span>
              <span className="text-cyan-400 font-bold">{streamQuality}</span>
            </div>
          </div>

          {/* Dynamic player controller bar */}
          <div className="bg-[#050912]/80 border border-cyan-950 rounded-xl p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 text-left">
            <div>
              <span className="text-[10px] font-mono text-emerald-400 uppercase tracking-widest block font-bold">চলতি প্রোগ্রাম:</span>
              <h3 className="text-sm font-semibold text-slate-100">{selectedChannel.currentShow}</h3>
            </div>

            <div className="flex gap-2 text-[11px] font-mono shrink-0">
              <button
                onClick={() => setStreamQuality("720p HD Ready")}
                className={`px-2.5 py-1 rounded border ${streamQuality === "720p HD Ready" ? "border-emerald-500 bg-emerald-950/40 text-emerald-400" : "border-slate-800 text-slate-500"}`}
              >
                720p
              </button>
              <button
                onClick={() => setStreamQuality("1080p Ultra-HD")}
                className={`px-2.5 py-1 rounded border ${streamQuality === "1080p Ultra-HD" ? "border-emerald-500 bg-emerald-950/40 text-emerald-400" : "border-slate-800 text-slate-500"}`}
              >
                1080p
              </button>
            </div>
          </div>
        </div>

        {/* Channels Grid (Right) */}
        <div className="lg:col-span-4 space-y-4 text-left">
          <h3 className="text-xs uppercase font-mono tracking-wider text-cyan-400 border-b border-cyan-950 pb-2 flex items-center gap-1.5 font-bold">
            <Monitor className="w-4 h-4 text-cyan-500" /> উপলব্ধ ক্যাটাগরি ও টিভি চ্যানেল
          </h3>

          <div className="space-y-2.5 max-h-[380px] overflow-y-auto pr-1 custom-scrollbar">
            {channels.map((chan) => (
              <div
                key={chan.id}
                onClick={() => setSelectedChannel(chan)}
                className={`p-3.5 rounded-xl border transition-all duration-300 cursor-pointer flex items-center gap-3 relative overflow-hidden ${
                  selectedChannel.id === chan.id
                    ? "bg-[#0b172a] border-emerald-500/50 shadow-[0_0_15px_rgba(16,185,129,0.1)]"
                    : "bg-[#060a12]/85 border-cyan-950 hover:border-cyan-800/60 hover:bg-[#0a1120]"
                }`}
              >
                {/* Visual symbol placeholder */}
                <div className="w-9 h-9 rounded-lg bg-[#040811] border border-cyan-950 flex items-center justify-center text-base shrink-0">
                  {chan.logo}
                </div>

                <div className="flex-1 min-w-0">
                  <div className="text-xs font-bold text-slate-100 truncate">{chan.name}</div>
                  <div className="text-[10px] text-slate-400 font-mono mt-0.5">{chan.category}</div>
                </div>

                {/* Status indicator badge right */}
                <span className={`text-[9px] font-mono font-bold uppercase rounded p-1 px-2 border shrink-0 ${
                  chan.status === "ONLINE"
                    ? "bg-red-950/20 text-red-500 border-red-900/40"
                    : "bg-slate-950/30 text-amber-500 border-slate-850"
                }`}>
                  {chan.status}
                </span>
              </div>
            ))}
          </div>

          <div className="bg-[#0c101b] border border-cyan-950 rounded-xl p-3 text-[10px] text-slate-400 font-mono flex items-center gap-2">
            <Sliders className="w-4 h-4 text-cyan-400" />
            <span>লাইভ স্ট্রিমিং ক্যাবল প্রটোকল v2040 এপ্রুভড।</span>
          </div>
        </div>

      </div>
    </div>
  );
}
