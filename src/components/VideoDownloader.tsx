import { useState } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  Video, 
  Download, 
  Search, 
  AlertCircle, 
  CheckCircle, 
  Globe, 
  Music, 
  RefreshCw, 
  FileVideo, 
  Copy, 
  Cpu, 
  ShieldCheck, 
  Flame 
} from "lucide-react";

interface PlayableLink {
  quality: string;
  url: string;
  size?: string;
  format: string;
}

interface ExtractionResult {
  title: string;
  description?: string;
  thumbnail: string;
  platform: "tiktok" | "facebook" | "instagram" | "twitter" | "youtube" | "generic";
  links: PlayableLink[];
  audio?: string;
  author?: string;
}

export default function VideoDownloader() {
  const [inputUrl, setInputUrl] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [result, setResult] = useState<ExtractionResult | null>(null);
  const [currentStep, setCurrentStep] = useState(0);
  const [steps, setSteps] = useState<string[]>([]);

  // Simulation steps to keep a highly engaging cyberpunk feeling
  const runExtractionProgress = async (platform: string) => {
    const defaultSteps = [
      `[SYS] iloveyoubd.com ডাউনলোড সার্ভার পোর্টের সাথে যুক্ত হচ্ছে...`,
      `[SYS] আপনার লিঙ্কটি সনাক্ত করা হয়েছে: [${platform.toUpperCase()}]`,
      `[SYS] মেগা ক্রু এআই ডিক্রিপশন মোড সক্রিয় করছে...`,
      `[SYS] মিডিয়া স্ট্রিম সোর্স ইউআরএল এবং ফাইল হেডার সফলভাবে রিট্রিভ করা হয়েছে!`,
    ];
    setSteps([]);
    for (let i = 0; i < defaultSteps.length; i++) {
      setCurrentStep(i);
      setSteps(prev => [...prev, defaultSteps[i]]);
      await new Promise(resolve => setTimeout(resolve, 350));
    }
  };

  const handlePaste = async () => {
    try {
      const text = await navigator.clipboard.readText();
      if (text) {
        setInputUrl(text);
      }
    } catch {
      // Browser permissions error fallback
    }
  };

  const detectPlatform = (url: string): string => {
    const l = url.toLowerCase();
    if (l.includes("tiktok.com")) return "tiktok";
    if (l.includes("facebook.com") || l.includes("fb.watch") || l.includes("fb.com")) return "facebook";
    if (l.includes("instagram.com")) return "instagram";
    if (l.includes("twitter.com") || l.includes("x.com")) return "twitter";
    if (l.includes("youtube.com") || l.includes("youtu.be")) return "youtube";
    return "generic";
  };

  const handleExtract = async () => {
    if (!inputUrl.trim()) {
      setError("অনুগ্রহ করে একটি সঠিক ভিডিও লিংক পেস্ট করুন!");
      return;
    }

    setIsLoading(true);
    setError(null);
    setResult(null);

    const platform = detectPlatform(inputUrl);
    await runExtractionProgress(platform);

    try {
      const res = await fetch("/api/downloader/extract", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ url: inputUrl })
      });

      const data = await res.json();

      if (res.ok && data.success) {
        setResult(data.data);
      } else {
        setError(data.error || "মিডিয়া ডাউনলোডার সার্ভার থেকে সঠিক উত্তর পাওয়া যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন!");
      }
    } catch (err: any) {
      console.error(err);
      setError("ডাউনলোডার প্রক্সি ওভারলোড বা নেটওয়ার্ক সংযোগ বিঘ্নিত হয়েছে। আবার চেষ্টা করুন!");
    } finally {
      setIsLoading(false);
    }
  };

  const triggerDirectDownload = (mediaUrl: string, titleStr: string, ext: string = "mp4", isAudio: boolean = false) => {
    // Generate clean file name matching our brand
    const cleanTitle = (titleStr || "video")
      .slice(0, 25)
      .replace(/[^a-zA-Z0-9_\-\u0980-\u09FF]/g, "_");
    
    const prefix = isAudio ? "iloveyoubd_com_audio_" : "iloveyoubd_com_video_";
    const filename = `${prefix}${cleanTitle}.${ext}`;

    // Point to our secure server proxy. This guarantees they stay ON our site entirely!
    const downloadProxyUrl = `/api/downloader/proxy?url=${encodeURIComponent(mediaUrl)}&filename=${encodeURIComponent(filename)}`;
    
    // Trigger download trigger via dynamic high-performance element binding
    const a = document.createElement("a");
    a.href = downloadProxyUrl;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  };

  return (
    <div id="iloveyoubd-aio-downloader" className="bg-[#090d16] border border-cyan-900/40 rounded-xl p-6 shadow-2xl relative overflow-hidden">
      {/* Background decorations */}
      <div className="absolute inset-0 bg-[#0d1624]/20 opacity-30 pointer-events-none" />
      <div className="absolute -top-12 -right-12 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl" />
      <div className="absolute -bottom-12 -left-12 w-32 h-32 bg-cyan-500/10 rounded-full blur-3xl" />

      {/* Header Panel */}
      <div className="mb-6 relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-cyan-950/40 pb-4">
        <div>
          <h2 className="text-xl font-bold font-sans tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-indigo-400 to-purple-400 flex items-center gap-2">
            <Video className="w-5.5 h-5.5 text-cyan-400 animate-pulse" />
            আই লাভ ইউ বিডি (AIO) অল-ইন-ওয়ান ভিডিও ডাউনলোডার
          </h2>
          <p className="text-xs text-slate-400 mt-1 font-mono">
            কোনো প্রকার বিরূপ বিজ্ঞাপন ছাড়াই TikTok, Facebook, Instagram এবং Twitter এর যেকোনো ভিডিও হাই-স্পিডে ডাউনলোড করুন সম্পূর্ণ ফ্রিতে!
          </p>
        </div>
        <div className="flex items-center gap-2 bg-[#050911]/80 px-3 py-1.5 rounded-lg border border-cyan-950 text-[11px] font-mono text-cyan-400">
          <ShieldCheck className="w-4 h-4 text-emerald-400 animate-pulse" />
          <span>১০০% নিরাপদ ও বিজ্ঞাপন মুক্ত</span>
        </div>
      </div>

      {/* Input Form Area */}
      <div className="relative z-10 mb-8 max-w-3xl mx-auto">
        <label className="block text-[11px] font-mono text-cyan-400 uppercase tracking-widest mb-1.5">ভিডিও লিংক পেস্ট করুন (Enter Video Link):</label>
        <div className="flex flex-col sm:flex-row items-stretch gap-2 bg-[#060a12] p-2 rounded-xl border border-cyan-950/80 focus-within:border-cyan-400/60 shadow-inner">
          <div className="flex-1 flex items-center gap-2 px-2">
            <Search className="w-4 h-4 text-slate-500 shrink-0" />
            <input
              type="text"
              placeholder="যেমন: https://www.tiktok.com/@user/video/..."
              value={inputUrl}
              onChange={(e) => setInputUrl(e.target.value)}
              className="w-full text-xs bg-transparent focus:outline-none text-slate-100 placeholder-slate-600 font-mono py-2"
            />
          </div>
          <div className="flex items-center gap-1.5 shrink-0">
            <button
              onClick={handlePaste}
              className="text-[11px] cursor-pointer bg-[#0e1626] font-mono hover:bg-slate-800 text-slate-300 px-3 py-2 rounded-lg border border-slate-800 transition"
              title="ক্লিপবোর্ড থেকে পেস্ট করুন"
            >
              <Copy className="w-3.5 h-3.5 inline mr-1" /> পেস্ট (Paste)
            </button>
            <button
              onClick={handleExtract}
              disabled={isLoading}
              className="bg-gradient-to-r cursor-pointer from-cyan-500 to-indigo-500 hover:from-cyan-400 hover:to-indigo-400 text-[#070b13] font-bold text-xs px-5 py-2 rounded-lg flex items-center gap-1.5 transition shadow-[0_0_15px_rgba(6,182,212,0.3)] disabled:opacity-50"
            >
              {isLoading ? (
                <RefreshCw className="w-3.5 h-3.5 animate-spin" />
              ) : (
                <Download className="w-3.5 h-3.5" />
              )}
              {isLoading ? "বিশ্লেষণ হচ্ছে..." : "লিঙ্ক ঠিক করুন (Download)"}
            </button>
          </div>
        </div>

        {/* Support status line */}
        <div className="mt-3 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-[11px] font-mono text-slate-500">
          <span className="flex items-center gap-1"><span className="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span> TikTok (No Watermark)</span>
          <span className="flex items-center gap-1"><span className="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> Facebook (HD/SD)</span>
          <span className="flex items-center gap-1"><span className="w-1.5 h-1.5 rounded-full bg-pink-500 animate-pulse"></span> Instagram (Video/Reels)</span>
          <span className="flex items-center gap-1"><span className="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span> Twitter / X</span>
          <span className="flex items-center gap-1"><span className="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Generic Links</span>
        </div>
      </div>

      {/* State Renderers */}
      <div className="relative z-10 max-w-3xl mx-auto">
        <AnimatePresence mode="wait">
          {/* Loading steps logs */}
          {isLoading && (
            <motion.div
              key="loader-steps"
              initial={{ opacity: 0, y: 10 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -10 }}
              className="bg-[#050911] border border-cyan-950 p-4 rounded-lg font-mono text-[11px] text-cyan-400 space-y-1.5 shadow-lg"
            >
              <div className="flex items-center gap-2 border-b border-cyan-950/60 pb-2 mb-2 text-slate-400">
                <Cpu className="w-4 h-4 text-cyan-400 animate-spin" />
                <span>মেগা ক্রু ডাউনলোড ইঞ্জিন সক্রিয় (মেম্বারশিপ ভেরিফাইড)</span>
              </div>
              {steps.map((step, idx) => (
                <div key={idx} className="flex items-start gap-1">
                  <span className="text-cyan-500 select-none">&gt;</span>
                  <span className={idx === currentStep ? "text-cyan-300 font-bold" : "text-cyan-600"}>{step}</span>
                </div>
              ))}
              <div className="pt-2 animate-pulse text-indigo-400 text-right text-[10px]">
                সার্ভার ডিক্রিপশন প্রসেসিং চলছে...
              </div>
            </motion.div>
          )}

          {/* Error Message */}
          {error && (
            <motion.div
              key="error-box"
              initial={{ opacity: 0, scale: 0.95 }}
              animate={{ opacity: 1, scale: 1 }}
              exit={{ opacity: 0 }}
              className="bg-red-500/10 border border-red-500/30 p-4 rounded-lg text-xs leading-relaxed text-red-400 flex items-start gap-2.5 shadow-lg"
            >
              <AlertCircle className="w-4 h-4 shrink-0 mt-0.5" />
              <div>
                <p className="font-bold">ডাউনলোড জটিলতা!</p>
                <p className="mt-1 text-slate-350">{error}</p>
                <div className="mt-2 text-[10px] text-slate-500">
                  💡 পরামর্শ: লিংকটি কি সঠিক? নিশ্চিত করুন যে ভিডিওটি পাবলিক এবং প্রোফাইলটি লক করা নেই।
                </div>
              </div>
            </motion.div>
          )}

          {/* Result Block */}
          {result && !isLoading && (
            <motion.div
              key="result-display"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="bg-[#0b1222] border border-cyan-900/30 rounded-xl p-5 shadow-xl grid grid-cols-1 md:grid-cols-12 gap-5"
            >
              {/* Media Thumbnail/Cover */}
              <div className="md:col-span-4 relative group rounded-lg overflow-hidden border border-cyan-950 bg-black min-h-[160px] flex items-center justify-center">
                {result.thumbnail ? (
                  <img
                    referrerPolicy="no-referrer"
                    src={result.thumbnail}
                    alt="cover"
                    className="w-full h-full object-cover max-h-[220px]"
                  />
                ) : (
                  <FileVideo className="w-12 h-12 text-slate-700 animate-pulse" />
                )}
                {/* Platform Badge overlays */}
                <div className={`absolute top-2 left-2 px-2.5 py-1 rounded text-[10px] font-mono font-bold uppercase tracking-wider text-slate-900 shadow-md ${
                  result.platform === "tiktok" ? "bg-cyan-400" :
                  result.platform === "facebook" ? "bg-blue-500 text-white" :
                  result.platform === "instagram" ? "bg-pink-500 text-white" :
                  result.platform === "twitter" ? "bg-sky-400 text-white" : "bg-[#ffae00]"
                }`}>
                  {result.platform}
                </div>
              </div>

              {/* Media Info Content */}
              <div className="md:col-span-8 flex flex-col justify-between space-y-4">
                <div>
                  <h3 className="text-sm font-bold text-slate-100 line-clamp-2 leading-relaxed">
                    {result.title || "ক্যাপশন বিহীন মিডিয়া কন্টেন্ট"}
                  </h3>
                  {result.author && (
                    <p className="text-xs text-slate-400 font-mono mt-1.5">
                      👤 নির্মাতা: <span className="text-cyan-400">{result.author}</span>
                    </p>
                  )}
                  {result.description && (
                    <p className="text-xs text-slate-500 mt-2 line-clamp-3 leading-normal">
                      {result.description}
                    </p>
                  )}
                </div>

                {/* Direct Download Buttons */}
                <div className="space-y-2 bg-[#050911]/60 p-3 rounded-lg border border-cyan-950">
                  <p className="text-[10px] font-mono text-cyan-400 uppercase tracking-widest">ডাউনলোডের বিকল্পসমূহ (Download Links):</p>
                  
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                    {result.links.map((link, idx) => (
                      <button
                        key={idx}
                        onClick={() => triggerDirectDownload(link.url, result.title, link.format, false)}
                        className="bg-cyan-500/10 hover:bg-cyan-500/20 border border-cyan-400/30 hover:border-cyan-400 text-cyan-300 font-mono text-xs py-2 px-3.5 rounded flex items-center justify-between transition cursor-pointer group"
                      >
                        <span className="flex items-center gap-1.5">
                          <FileVideo className="w-3.5 h-3.5 text-cyan-400 group-hover:scale-110 transition" />
                          <span>{link.quality}</span>
                        </span>
                        <span className="text-[9px] text-slate-400 bg-[#050911] px-1.5 py-0.5 rounded border border-cyan-950">
                          {link.size ? link.size : "Direct"}
                        </span>
                      </button>
                    ))}

                    {/* MP3 Audio option */}
                    {result.audio && (
                      <button
                        onClick={() => triggerDirectDownload(result.audio!, result.title, "mp3", true)}
                        className="bg-purple-500/10 hover:bg-purple-500/20 border border-purple-500/30 hover:border-purple-400 text-purple-300 font-mono text-xs py-2 px-3.5 rounded flex items-center justify-between transition cursor-pointer group sm:col-span-2"
                      >
                        <span className="flex items-center gap-1.5">
                          <Music className="w-3.5 h-3.5 text-purple-400 group-hover:scale-110 transition" />
                          <span>ব্যাকগ্রাউন্ড অডিও (Background MP3)</span>
                        </span>
                        <span className="text-[9px] text-[#ffae00] font-sans font-bold">
                          128Kbps
                        </span>
                      </button>
                    )}
                  </div>
                </div>

                {/* Secure warning badge */}
                <div className="text-[10px] text-slate-500 flex items-center gap-1">
                  <CheckCircle className="w-3.5 h-3.5 text-emerald-500" />
                  <span>মিডিয়া ফাইলটি সরাসরি <b>iloveyoubd.com</b> এর নিরাপদ প্রক্সি চ্যানেল দিয়ে ডাউনলোড হচ্ছে</span>
                </div>
              </div>
            </motion.div>
          )}
        </AnimatePresence>
      </div>

      {/* Safe Download Info Board */}
      <div className="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 relative z-10">
        <div className="bg-[#050911]/50 border border-cyan-950/40 p-4 rounded-lg">
          <h4 className="text-xs font-bold text-cyan-400 mb-1 flex items-center gap-1">
            <Flame className="w-4 h-4 text-orange-400" /> ১. অন্য কোথাও রিডাইরেক্ট করে না
          </h4>
          <p className="text-[11px] text-slate-400 leading-normal">
            অন্যান্য সাইটের মতো কোনো থার্ড-পার্টি অ্যাডাল্ট অ্যাড বা রিডাইরেক্ট স্প্যাম লিঙ্ক আমাদের এখানে নেই। আপনার ফাইল ক্লিক করার সাথে সাথে সরাসরি ডাউনলোড শুরু হয়ে যায়।
          </p>
        </div>
        <div className="bg-[#050911]/50 border border-cyan-950/40 p-4 rounded-lg">
          <h4 className="text-xs font-bold text-cyan-400 mb-1 flex items-center gap-1">
            <ShieldCheck className="w-4 h-4 text-emerald-400" /> ২. ১০০% ফাইল প্রাইভেসি প্রটেকশন
          </h4>
          <p className="text-[11px] text-slate-400 leading-normal">
            আমাদের সিকিউর কানেকশন প্রক্সির মাধ্যমে আপনার ডাউনলোড করা প্রতিটি ফাইল সরাসরি নিরাপদ পাইপে পরিবাহিত হয়। কোন সাইট থেকে কি ডাউনলোড করছেন তা ট্র্যাকিং মুক্ত থাকে।
          </p>
        </div>
        <div className="bg-[#050911]/50 border border-cyan-950/40 p-4 rounded-lg">
          <h4 className="text-xs font-bold text-cyan-400 mb-1 flex items-center gap-1">
            <Globe className="w-4 h-4 text-blue-400" /> ৩. কোনো জটিলতা ছাড়া ওয়ান-ক্লিক
          </h4>
          <p className="text-[11px] text-slate-400 leading-normal">
            শুধু লিংক পেস্ট করে ক্লিক করুন এবং আপনার পছন্দের ফাইলটি মেগা ক্রু সার্ভার ও মায়া এআই এর স্বয়ংক্রিয় প্রসেসিং এর মাধ্যমে সেকেন্ডে ডাউনলোড করে নিন।
          </p>
        </div>
      </div>
    </div>
  );
}
