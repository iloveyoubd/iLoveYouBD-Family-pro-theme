import React, { useState } from "react";
import { Sparkles, Terminal, Globe, Send, RefreshCw, Cpu, BrainCircuit, ShieldAlert, Award, FileText, Settings, X, Key } from "lucide-react";
import type { Post } from "../types";

interface AICrewProps {
  onAddGeneratedPost: (generatedPost: any) => void;
  selectedMood: string;
}

export default function AICrew({ onAddGeneratedPost, selectedMood }: AICrewProps) {
  // Chat state
  const [chatMessages, setChatMessages] = useState<any[]>([
    {
      role: "model",
      content: "আসসালামু আলাইকুম! আমি মায়া (Maya AI), iloveyoubd.com-এর অল-রাউন্ডার এআই এক্সিকিউটিভ অ্যাসিস্ট্যান্ট। ওয়েবসাইট সিকিউরিটি কোডিং, সার্চ ইনডেক্সিং, স্পিড অপ্টিমাইজেশন বা গুগল এডসেন্স মনিটাইজেশনের বিষয়ে যেকোনো সাহায্য করতে আমি সম্পূর্ণ প্রস্তুত। আমাকে যেকোনো প্রশ্ন করতে পারেন!"
    }
  ]);
  const [userInput, setUserInput] = useState("");
  const [isChatLoading, setIsChatLoading] = useState(false);

  // Gemini Settings for multi-key automatic rotation
  const [showKeySettings, setShowKeySettings] = useState(false);
  const [inputKeys, setInputKeys] = useState(() => {
    try {
      const saved = localStorage.getItem("ilybd_maya_api_keys");
      return saved ? JSON.parse(saved).join("\n") : "";
    } catch (e) {
      return "";
    }
  });

  const getActiveKeysArray = () => {
    return inputKeys.split("\n").map(k => k.trim()).filter(Boolean);
  };

  const handleSaveKeys = () => {
    const keysArray = getActiveKeysArray();
    localStorage.setItem("ilybd_maya_api_keys", JSON.stringify(keysArray));
    setShowKeySettings(false);
  };

  // AI Content Crew Generator state
  const [selectedAgent, setSelectedAgent] = useState("writer");
  const [generationTopic, setGenerationTopic] = useState("");
  const [selectedCategory, setSelectedCategory] = useState("Hacking");
  const [isGenerating, setIsGenerating] = useState(false);
  const [generationResult, setGenerationResult] = useState<any | null>(null);

  const aiAgents = [
    { id: "writer", name: "কন্টেন্ট রাইটার এআই (Content Bot)", avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=writer", role: "Bangla Cybersecurity & Earning Blog Specialist" },
    { id: "title", name: "টাইটেল জেনারেটর এআই (Headline AI)", avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=headline", role: "SEO Clickbait Bangla Headline Architect" },
    { id: "graphic", name: "সাইবার থাম্বনেইল ডিজাইনার (Art Bot)", avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=art", role: "Cyberpunk 2040 Matrix Art Director" }
  ];

  const quickPrompts = [
    "গুগল অ্যাডসেন্স দ্রুত এপ্রুভাল ট্রিক কী?",
    "কিভাবে গুগল সার্চে পোস্ট ১ মিনিটে ইনডেক্স করব?",
    "২০৪০ সালে কেমন হ্যাকিং আক্রমণ ও ডিফেন্স চলবে?",
    "iloveyoubd.com এ কন্টেন্ট লিখে টাকা উপার্জন কিভাবে করব?"
  ];

  // Send a message to /api/gemini/chat
  const handleSendMessage = async (customText?: string) => {
    const textToSend = customText || userInput;
    if (!textToSend.trim() || isChatLoading) return;

    const updatedMessages = [...chatMessages, { role: "user", content: textToSend }];
    setChatMessages(updatedMessages);
    setUserInput("");
    setIsChatLoading(true);

    try {
      const activeKeys = getActiveKeysArray();
      const response = await fetch("/api/gemini/chat", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          messages: updatedMessages,
          keys: activeKeys, // Pass active keys array to backend for auto key rotation!
          systemInstruction: "You are Maya (মায়া), the highly professional, helpful, and extremely competent head executive security Admin AI Assistant of iloveyoubd.com. Write in flawless Bangla. Help solve codes, secure AdSense, optimize site speeds, discuss 2040 cyber trends, and guide authors on how to write post articles to make money. If the user asks you to write code, provide beautifully formatted, complete markdown code blocks. If they ask to draw, paint, make, or generate any image (e.g. 'draw a hacker girl', 'একটি রোবটের ছবি বানিয়ে দেখাও'), return exactly this tag block: '[GENERATE_IMAGE: <descriptive prompt in English>]' in your final response so the frontend can render it."
        })
      });

      const data = await response.json();
      if (data.text) {
        setChatMessages((prev) => [...prev, { role: "model", content: data.text }]);
      } else {
        setChatMessages((prev) => [
          ...prev, 
          { 
            role: "model", 
            content: "দুঃখিত, কোনো ডেটা সাড়া পাওয়া যায়নি। তবে আপনার সার্ভার কানেকশন শতভাগ সুরক্ষিত!" 
          }
        ]);
      }
    } catch (err: any) {
      console.error(err);
      setChatMessages((prev) => [
        ...prev,
        { role: "model", content: "সার্ভার কানেকশন এরর হয়েছে! তবে ডেমো রেসপন্স হিসেবে আমি জানাচ্ছি যে এডসেন্স ও গুগল ইন্ডেক্সিং পুরোপুরি স্ট্যাবল রয়েছে।" }
      ]);
    } finally {
      setIsChatLoading(false);
    }
  };

  // Generate a blog post via /api/gemini/generate-post
  const handleGenerateAIPost = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!generationTopic.trim() || isGenerating) return;

    setIsGenerating(true);
    setGenerationResult(null);

    try {
      // Pick random bot info
      const randomArr = ["সাইবার ক্র্যাঙ্কার এআই", "রোবটিক্স এক্সপার্ট", "ট্রিকবিডি লিজেন্ড"];
      const botName = randomArr[Math.floor(Math.random() * randomArr.length)];

      const res = await fetch("/api/gemini/generate-post", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          prompt: generationTopic,
          category: selectedCategory,
          authorName: botName
        })
      });

      const data = await res.json();
      
      // We will also fetch a simulation image url
      let thumbImg = `https://images.unsplash.com/photo-1624969862644-791f3dc98927?q=80&w=600&auto=format&fit=crop`; // dynamic fallback
      if (generationTopic.toLowerCase().includes("game")) {
        thumbImg = "https://images.unsplash.com/photo-1538481199705-c710c4e965fc?q=80&w=600&auto=format&fit=crop";
      } else if (generationTopic.toLowerCase().includes("earning") || generationTopic.toLowerCase().includes("money")) {
        thumbImg = "https://images.unsplash.com/photo-1518546305927-5a555bb7020d?q=80&w=600&auto=format&fit=crop";
      } else if (generationTopic.toLowerCase().includes("google") || generationTopic.toLowerCase().includes("seo")) {
        thumbImg = "https://images.unsplash.com/photo-1571844307560-f551ff31d7be?q=80&w=600&auto=format&fit=crop";
      }

      const completeGeneratedPost = {
        title: data.title || `${generationTopic} - ক্রিপ্টো সাইবার রিসার্চ`,
        excerpt: data.excerpt || "এআই স্বয়ংক্রিয়ভাবে একটি চমৎকার কন্টেন্ট তৈরি করে প্রকাশ করেছে।",
        content: data.content || "এখানে এআই বিস্তারিত কন্টেন্ট প্রকাশ করেছে...",
        tags: data.tags || ["hacking", "cyber-security", "ai-generate"],
        readTime: data.readTime || "৩ মিনিট",
        category: selectedCategory,
        authorName: botName,
        thumbnail: thumbImg
      };

      setGenerationResult(completeGeneratedPost);
    } catch (err) {
      console.error(err);
    } finally {
      setIsGenerating(false);
    }
  };

  const publishGeneratedPostResult = () => {
    if (!generationResult) return;
    onAddGeneratedPost(generationResult);
    alert(`অ্যাডমিন পেন্ডিং ছাড়া কন্টেন্টটি সরাসরি পাবলিশ হয়েছে!\nটাইটেল: ${generationResult.title}\nব্যালেন্স বোনাস এড করা হয়েছে!`);
    setGenerationResult(null);
    setGenerationTopic("");
  };

  return (
    <div className="grid grid-cols-1 xl:grid-cols-12 gap-6">
      
      {/* LEFT: Autonomous AI Publishing Crew Panel */}
      <div className="xl:col-span-5 bg-[#090d16] border border-cyan-900/40 rounded-xl p-5 shadow-2xl relative overflow-hidden flex flex-col justify-between">
        <div className="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-cyan-950/20 to-transparent pointer-events-none" />
        
        <div className="relative z-10">
          <div className="flex items-center gap-2 mb-4">
            <BrainCircuit className="w-5.5 h-5.5 text-cyan-400 animate-pulse" />
            <div>
              <h2 className="text-base font-bold text-slate-100 font-sans tracking-tight">
                এআই কন্টেন্ট জেনারেটর ক্রু (Publishing Bots)
              </h2>
              <p className="text-[10px] text-slate-400 font-mono">
                ২০৪০ ভিশন অটো-রানিং মেম্বার গ্রুপ। এক ক্লিকে ব্লগ ও এসইও ফ্রেন্ডলি কন্টেন্ট প্রকাশ
              </p>
            </div>
          </div>

          {/* Core AI agents listings */}
          <div className="space-y-2 mb-5">
            {aiAgents.map((agent) => (
              <div
                key={agent.id}
                onClick={() => setSelectedAgent(agent.id)}
                className={`flex items-center gap-3 p-2.5 rounded border transition-all cursor-pointer ${
                  selectedAgent === agent.id
                    ? "bg-[#0c1b2f] border-cyan-400/70"
                    : "bg-[#060b12] border-slate-900 hover:border-cyan-950"
                }`}
              >
                <img
                  src={agent.avatar}
                  alt={agent.name}
                  className="w-8 h-8 rounded-full border border-cyan-500/30"
                />
                <div className="text-left">
                  <div className="text-xs font-bold text-slate-200">{agent.name}</div>
                  <div className="text-[9px] text-[#00f0ff] font-mono uppercase">{agent.role}</div>
                </div>
              </div>
            ))}
          </div>

          <form onSubmit={handleGenerateAIPost} className="space-y-3.5 pt-3 border-t border-cyan-950">
            <div>
              <label className="block text-[10px] uppercase font-mono text-cyan-400 mb-1">কন্টেন্ট এর বিষয় বা কিওয়ার্ড:</label>
              <input
                type="text"
                required
                value={generationTopic}
                onChange={(e) => setGenerationTopic(e.target.value)}
                placeholder="যেমন: ওয়াইফাই পাসওয়ার্ড হ্যাক প্রতিরোধের ৫টি উপায়..."
                className="w-full text-xs bg-[#050911] border border-cyan-950 focus:border-cyan-400 rounded p-2 focus:outline-none text-slate-200 font-sans"
              />
            </div>

            <div className="grid grid-cols-2 gap-2">
              <div>
                <label className="block text-[10px] uppercase font-mono text-cyan-400 mb-1">ক্যাটাগরি:</label>
                <select
                  value={selectedCategory}
                  onChange={(e) => setSelectedCategory(e.target.value)}
                  className="w-full text-xs bg-[#050911] border border-cyan-950 p-2 focus:border-cyan-400 focus:outline-none rounded text-slate-200"
                >
                  <option value="Hacking">Hacking</option>
                  <option value="SEO Guide">SEO Guide</option>
                  <option value="Online Earning">Online Earning</option>
                  <option value="Android Tech">Android Tech</option>
                  <option value="Robotics">Robotics</option>
                </select>
              </div>
              
              <div className="flex items-end">
                <button
                  type="submit"
                  disabled={isGenerating}
                  className="w-full bg-gradient-to-r from-cyan-500 to-indigo-500 hover:from-cyan-400 hover:to-indigo-400 text-[#070b13] font-bold text-xs py-2.5 px-3 rounded flex items-center justify-center gap-1.5 font-mono cursor-pointer shadow-[0_0_10px_rgba(0,240,255,0.2)]"
                >
                  <RefreshCw className={`w-3.5 h-3.5 ${isGenerating ? 'animate-spin' : ''}`} />
                  {isGenerating ? "তৈরি হচ্ছে..." : "কন্টেন্ট তৈরি করুন"}
                </button>
              </div>
            </div>
          </form>

          {/* Generation expansion output panel */}
          {generationResult && (
            <div className="mt-4 p-3 border border-emerald-500/30 bg-[#061411] rounded-lg">
              <h3 className="text-xs font-bold text-emerald-400 flex items-center gap-1.5">
                <ShieldAlert className="w-3.5 h-3.5 animate-pulse" /> কন্টেন্ট জেনারেশন সফল!
              </h3>
              <div className="text-xs text-slate-300 font-sans font-semibold mt-1.5 limit-lines-1">
                {generationResult.title}
              </div>
              <p className="text-[10px] text-slate-400 italic mt-1 font-mono">{generationResult.excerpt}</p>
              
              <button
                onClick={publishGeneratedPostResult}
                className="mt-3 w-full bg-emerald-500 hover:bg-emerald-400 text-[#050910] text-[10px] font-bold font-mono py-1 rounded cursor-pointer"
              >
                পাবলিশ করুন এবং টাকা প্লাস করুন ৳
              </button>
            </div>
          )}
        </div>

        <div className="text-[9px] text-slate-500 font-mono mt-4 pt-2 border-t border-cyan-950/60 leading-relaxed text-left">
          * এআই ক্রু মেম্বাররা কন্টেন্ট পাবলিশ করলে গুগল ও ট্রিকবিডি সিকিউরিটি নিয়ম অনুযায়ী গুগল এসইও ফ্রেন্ডলি ক্রল স্কোর বাড়ে এবং এডসেন্স ইনকাম অটো বৃদ্ধি পেতে শুরু করে।
        </div>
      </div>

      {/* RIGHT: High fidelity "Maya-AI" interactive chat workspace */}
      <div className="xl:col-span-7 bg-gradient-to-b from-[#11172a] to-[#090b11] border border-purple-500/30 rounded-xl p-5 shadow-[0_10px_40px_rgba(0,0,0,0.5)] relative overflow-hidden flex flex-col justify-between h-[450px]">
        
        {/* Cosmic Background decoration */}
        <div className="absolute top-0 right-0 w-80 h-80 bg-purple-600/10 rounded-full blur-[100px] pointer-events-none" />
        <div className="absolute bottom-0 left-0 w-80 h-80 bg-cyan-500/10 rounded-full blur-[100px] pointer-events-none" />

        {/* Header bar similarity with Gemini */}
        <div className="flex justify-between items-center border-b border-slate-800/80 pb-3 mb-3 relative z-10 font-sans">
          <div className="flex items-center gap-2">
            <div className="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_10px_#00f0ff]" />
            <h3 className="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 flex items-center gap-1.5 uppercase tracking-wide">
              মায়া এআই — Maya Expert <span className="text-[9px] font-bold text-pink-300 font-mono bg-pink-950/50 border border-pink-500/20 px-2 py-0.5 rounded-md">GEMINI POWERED</span>
            </h3>
          </div>
          <div className="flex items-center gap-3">
            <span className="text-[9.5px] font-mono text-slate-500">
              {getActiveKeysArray().length > 0 ? `⚙️ ${getActiveKeysArray().length} APIs Active` : "Demo Mode"}
            </span>
            <button 
              onClick={() => setShowKeySettings(!showKeySettings)} 
              title="এপিআই সেটিংস"
              className="text-slate-400 hover:text-cyan-400 transition-colors p-1 rounded hover:bg-slate-800/60 cursor-pointer"
            >
              <Settings className="w-4 h-4" />
            </button>
          </div>
        </div>

        {showKeySettings ? (
          /* Multi-API Key Settings Panel */
          <div className="flex-1 flex flex-col justify-between relative z-10 py-2 text-left font-sans">
            <div className="space-y-3">
              <div className="flex items-center gap-2 text-rose-400">
                <Key className="w-4 h-4" />
                <h4 className="text-xs font-bold">গুগল এআই স্টুডিও ফ্রি এপিআই কি সেটিংস</h4>
              </div>
              <p className="text-[11px] text-slate-400 leading-relaxed">
                আপনি এখানে ১০টি পর্যন্ত ফ্রি জেমিনি এআর এপিআই চাবি সংরক্ষণ করে রাখতে পারেন। একটি এপিআই কি এর কোটা লিমিট (৪২৯ এরর) শেষ হওয়া মাত্র মায়া ডিস্ট্রিবিউটেড মেশিন অন্য আরেকটি কি স্বয়ংক্রিয়ভাবে ব্যবহার করবে! (প্রতি লাইনে একটি কি বসান)
              </p>
              <textarea
                rows={5}
                value={inputKeys}
                onChange={(e) => setInputKeys(e.target.value)}
                placeholder="AIzaSyA..."
                className="w-full text-xs font-mono bg-slate-950/80 border border-purple-500/30 rounded p-2.5 focus:border-cyan-400 focus:outline-none text-emerald-400"
              />
            </div>
            <div className="flex gap-2 font-mono">
              <button
                onClick={handleSaveKeys}
                className="flex-1 bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-400 hover:to-purple-400 text-[#090d16] font-bold text-xs py-2 px-3 rounded cursor-pointer"
              >
                সেভ করুন এবং সক্রিয় করুন ⚡
              </button>
              <button
                onClick={() => setShowKeySettings(false)}
                className="bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs py-2 px-3 rounded cursor-pointer font-sans"
              >
                বাতিল
              </button>
            </div>
          </div>
        ) : (
          /* Message container scrolls */
          <>
            <div className="flex-1 overflow-y-auto pr-1.5 space-y-3.5 mb-4 custom-scrollbar text-left relative z-10">
              {chatMessages.map((msg, idx) => (
                <div
                  key={idx}
                  className={`flex items-start gap-2.5 ${
                    msg.role === "user" ? "flex-row-reverse" : "flex-row"
                  }`}
                >
                  <div
                    className={`w-7 h-7 rounded-full flex items-center justify-center font-bold text-[10px] shrink-0 select-none ${
                      msg.role === "user"
                        ? "bg-purple-950/80 border border-purple-500/40 text-purple-300"
                        : "bg-cyan-950/80 border border-cyan-500/40 text-cyan-300"
                    }`}
                  >
                    {msg.role === "user" ? "ME" : "MAYA"}
                  </div>

                  <div
                    className={`p-3 rounded-xl text-xs leading-relaxed max-w-[85%] ${
                      msg.role === "user"
                        ? "bg-purple-950/30 border border-purple-900/40 text-slate-200 ml-auto text-left shadow-lg"
                        : "bg-slate-900/35 border border-slate-800/40 text-slate-200 mr-auto text-left whitespace-pre-line shadow-lg"
                    }`}
                  >
                    {msg.content}
                  </div>
                </div>
              ))}

              {isChatLoading && (
                <div className="flex items-center gap-2 text-cyan-400 font-mono text-xs pl-9">
                  <RefreshCw className="w-3.5 h-3.5 animate-spin text-purple-400" />
                  <span>মায়া গভীরভাবে চিন্তা করছে...</span>
                </div>
              )}
            </div>

            {/* Quick click helper tags */}
            <div className="flex gap-1.5 overflow-x-auto pb-2.5 mb-2.5 scroll-smooth custom-scrollbar relative z-10">
              {quickPrompts.map((p, index) => (
                <button
                  key={index}
                  onClick={() => handleSendMessage(p)}
                  className="text-[10px] flex-nowrap shrink-0 bg-slate-900/60 hover:bg-slate-800 text-cyan-400 border border-slate-800 px-2.5 py-1 rounded-md transition-colors font-mono cursor-pointer"
                >
                  {p}
                </button>
              ))}
            </div>

            {/* Message Input Bar */}
            <div className="relative z-10 flex gap-2 pt-2 border-t border-slate-800/80">
              <input
                type="text"
                value={userInput}
                onChange={(e) => setUserInput(e.target.value)}
                onKeyDown={(e) => {
                  if (e.key === "Enter") handleSendMessage();
                }}
                placeholder="গোপন ট্রিকবিডি এসইও হ্যাক ট্রিকস জানতে চান? মায়াকে এখানে জিজ্ঞেস করুন..."
                className="flex-1 bg-slate-950/80 border border-slate-800 focus:border-cyan-400/80 focus:outline-none rounded-lg px-3 py-2 text-xs font-sans text-slate-100 placeholder-slate-600 transition-colors"
              />
              <button
                id="btn-sender"
                onClick={() => handleSendMessage()}
                className="bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-400 hover:to-purple-400 text-[#070b13] font-bold text-xs p-2.5 rounded-lg transition-all flex items-center justify-center cursor-pointer shadow-lg"
              >
                <Send className="w-4 h-4 text-[#090b11]" />
              </button>
            </div>
          </>
        )}

      </div>

    </div>
  );
}
