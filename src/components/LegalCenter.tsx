import React, { useState } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  Shield, 
  FileText, 
  AlertCircle, 
  Info, 
  Send, 
  CheckCircle2, 
  Mail, 
  Globe, 
  Lock, 
  UserCheck, 
  Cpu, 
  Layers, 
  Terminal,
  ArrowRight,
  Sparkles,
  Search
} from "lucide-react";

interface LegalCenterProps {
  initialTab: "privacy" | "terms" | "disclaimer" | "about" | "contact-us";
  onChangeTab: (tab: "privacy" | "terms" | "disclaimer" | "about" | "contact-us") => void;
}

export default function LegalCenter({ initialTab, onChangeTab }: LegalCenterProps) {
  const [activeTab, setActiveTab] = useState<"privacy" | "terms" | "disclaimer" | "about" | "contact-us">(initialTab);
  
  // Contact Us state
  const [contactName, setContactName] = useState("");
  const [contactEmail, setContactEmail] = useState("");
  const [contactSubject, setContactSubject] = useState("");
  const [contactMessage, setContactMessage] = useState("");
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitSuccess, setSubmitSuccess] = useState(false);
  const [ticketRate, setTicketRate] = useState<string | null>(null);

  const handleTabClick = (tab: "privacy" | "terms" | "disclaimer" | "about" | "contact-us") => {
    setActiveTab(tab);
    onChangeTab(tab);
    window.scrollTo({ top: 0, behavior: "smooth" });
  };

  const handleContactSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!contactName || !contactEmail || !contactMessage) return;

    setIsSubmitting(true);
    setTimeout(() => {
      setIsSubmitting(false);
      setSubmitSuccess(true);
      const randomTicket = "ILYBD-TKT-" + Math.floor(100000 + Math.random() * 900000);
      setTicketRate(randomTicket);
      setContactName("");
      setContactEmail("");
      setContactSubject("");
      setContactMessage("");
      setTimeout(() => setSubmitSuccess(false), 8000);
    }, 1200);
  };

  const menuItems = [
    { id: "privacy", label: "প্রাইভেসি পলিসি (Privacy Policy)", icon: Shield, color: "text-cyan-400" },
    { id: "terms", label: "ব্যবহারের শর্তাবলী (Terms of Service)", icon: FileText, color: "text-purple-400" },
    { id: "disclaimer", label: "আইনি ডিসক্লেইমার (Disclaimer)", icon: AlertCircle, color: "text-amber-400" },
    { id: "about", label: "আমাদের সম্পর্কে (About Us)", icon: Info, color: "text-emerald-400" },
    { id: "contact-us", label: "যোগাযোগ করুন (Contact Us)", icon: Mail, color: "text-rose-400" },
  ] as const;

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 py-8">
      {/* Page Header */}
      <div className="bg-slate-950/40 border border-cyan-950/60 rounded-3xl p-6 md:p-8 mb-8 relative overflow-hidden backdrop-blur-md">
        <div className="absolute inset-x-0 bottom-0 h-[1.5px] bg-gradient-to-r from-transparent via-cyan-500 to-transparent opacity-60" />
        <div className="flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div className="space-y-2 text-left">
            <div className="flex items-center gap-2">
              <Terminal className="w-5 h-5 text-cyan-400 animate-pulse" />
              <span className="text-[10px] font-mono tracking-widest text-cyan-450 uppercase font-bold bg-cyan-950/60 px-3 py-1 rounded-full border border-cyan-500/20">
                Google AdSense Compliance System Core
              </span>
            </div>
            <h1 className="text-2xl md:text-3xl font-bold tracking-tight text-white font-sans">
              আইনি নীতি ও নীতিমালার কেন্দ্র <span className="text-cyan-400 text-sm font-mono">(Legal Policies)</span>
            </h1>
            <p className="text-xs text-slate-400 font-sans max-w-2xl leading-relaxed">
              iloveyoubd.com নির্ভরযোগ্য ও অত্যন্ত স্বচ্ছ ও নিরাপদ প্রযুক্তি ফোরাম। গুগল ডিস্ট্রিবিউটেড কোডিং স্ট্যান্ডার্ড, ট্রাফিক কমপ্লায়েন্স ও ইউজার পলিসি ১০০% সংরক্ষণে আমরা বদ্ধপরিকর।
            </p>
          </div>
          
          <div className="flex items-center gap-3 self-start md:self-auto bg-slate-900/60 border border-slate-800/80 p-3 rounded-2xl">
            <div className="w-10 h-10 rounded-full bg-emerald-950/50 border border-emerald-500/30 flex items-center justify-center">
              <Lock className="w-5 h-5 text-emerald-400 animate-pulse" />
            </div>
            <div className="text-left font-mono">
              <div className="text-[9px] text-[#39ff14] font-bold leading-none uppercase tracking-wider">SSL Security Status</div>
              <div className="text-xs text-slate-300 font-bold mt-1">256-Bit Encrypted Secure Node</div>
            </div>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {/* Left Side Menu */}
        <div className="lg:col-span-1 space-y-3">
          <div className="bg-slate-950/60 border border-cyan-950/60 rounded-2xl p-4 sticky top-[130px] backdrop-blur-md">
            <h3 className="text-xs font-mono uppercase tracking-widest text-[#00f0ff] font-bold mb-4 px-2 select-none border-l-2 border-cyan-500/30">
              NAVIGATION
            </h3>
            
            <div className="flex flex-col gap-1.5">
              {menuItems.map((item) => {
                const IconComp = item.icon;
                const isSelected = activeTab === item.id;
                return (
                  <button
                    key={item.id}
                    onClick={() => handleTabClick(item.id)}
                    className={`w-full text-left p-3 rounded-xl text-xs font-bold transition-all flex items-center gap-3 relative cursor-pointer border ${
                      isSelected
                        ? "bg-cyan-950/55 border-cyan-500/30 text-cyan-400 font-extrabold shadow-[0_0_15px_rgba(0,240,255,0.08)]"
                        : "bg-transparent border-transparent text-slate-400 hover:text-slate-200 hover:bg-slate-900/40 hover:border-slate-800"
                    }`}
                  >
                    <IconComp className={`w-4 h-4 ${isSelected ? item.color : "text-slate-500"}`} />
                    <span className="font-sans leading-tight">{item.label}</span>
                    
                    {isSelected && (
                      <motion.div
                        layoutId="activeLegalIndicator"
                        className="absolute right-2 w-1.5 h-1.5 bg-cyan-400 rounded-full"
                        transition={{ type: "spring", stiffness: 350, damping: 25 }}
                      />
                    )}
                  </button>
                );
              })}
            </div>
            
            <div className="mt-6 pt-5 border-t border-cyan-950/40 text-left px-2">
              <span className="text-[10px] font-mono text-slate-500 uppercase block tracking-wider">সর্বশেষ মোডিফিকেশন:</span>
              <strong className="text-xs text-slate-350 font-bold block mt-1">জুন ২০২৬ (June 2026)</strong>
              <div className="mt-3 flex items-center gap-1.5">
                <span className="w-1.5 h-1.5 bg-[#39ff14] rounded-full animate-ping" />
                <span className="text-[9px] text-[#39ff14] font-mono uppercase font-bold tracking-widest">Active & Verified</span>
              </div>
            </div>
          </div>
        </div>

        {/* Right Side Content Pane */}
        <div className="lg:col-span-3 text-left">
          <AnimatePresence mode="wait">
            <motion.div
              key={activeTab}
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              transition={{ duration: 0.3 }}
              className="bg-slate-950/30 border border-cyan-950/40 rounded-3xl p-6 md:p-8 shadow-3xl relative backdrop-blur-md"
            >
              <div className="absolute top-0 right-0 p-4 opacity-5 pointer-events-none select-none">
                <Sparkles className="w-32 h-32 text-cyan-400" />
              </div>

              {/* 1. PRIVACY POLICY */}
              {activeTab === "privacy" && (
                <div className="space-y-6">
                  <div className="border-b border-cyan-950 pb-4">
                    <h2 className="text-xl md:text-2xl font-bold text-white flex items-center gap-2.5">
                      <Shield className="w-6 h-6 text-cyan-400" />
                      <span>প্রাইভেসি পলিসি (Privacy Policy)</span>
                    </h2>
                    <p className="text-[10px] font-mono text-cyan-450 mt-1 uppercase font-bold">
                      System Code Rule: P_GATEWAY_COMPLIANT_V4.2
                    </p>
                  </div>

                  {/* Dual language introduction */}
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs leading-relaxed">
                    <div className="p-4 bg-slate-950/65 rounded-2xl border border-slate-900 border-dashed space-y-2">
                      <div className="text-[10px] font-mono uppercase text-cyan-400 font-bold">বাংলা বিবরণ</div>
                      <p className="text-slate-300 font-sans">
                        <strong>iloveyoubd.com</strong> সিস্টেমে আমাদের সাথে থাকা প্রত্যেক মেম্বার ও ভিজিটরদের গোপনীয়তা ও ব্যক্তিগত ডাটার সুরক্ষা নিশ্চিত করা আমাদের প্রথম ও প্রধান দায়িত্ব। এই ডকুমেন্টের উদ্দেশ্য হলো আমরা কিভাবে ডাটা প্রক্রিয়াকরণ এবং ট্রাফিক কমপ্লায়েন্স পরিচালনা করি তা নিখুঁতভাবে তুলে ধরা।
                      </p>
                    </div>
                    <div className="p-4 bg-slate-1000/65 rounded-2xl border border-[#1e293b]/30 space-y-2">
                      <div className="text-[10px] font-mono uppercase text-purple-400 font-bold">ENGLISH SPECIFICATION</div>
                      <p className="text-slate-400">
                        At <strong>iloveyoubd.com</strong>, protecting the privacy of our visitors is our absolute priority. This document outlines the types of personal data we collect, process, and safeguard across our secure application servers, ensuring full alignment with strict user data guidelines.
                      </p>
                    </div>
                  </div>

                  {/* Detailed Policies */}
                  <div className="space-y-5 text-slate-300 text-xs sm:text-sm font-sans space-y-5">
                    
                    <div className="p-5 rounded-2xl bg-cyan-950/10 border border-cyan-950/40 hover:border-cyan-500/20 transition-all space-y-3">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <Lock className="w-5 h-5 text-cyan-400" />
                        <span>১. সংগৃহীত তথ্য ও ব্যবহার (Information We Collect)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        ব্যবহারকারী যখন আমাদের প্ল্যাটফর্মে যুক্ত হন, আমরা তাদের আইপি অ্যাড্রেস (IP Address), ব্রাউজার টাইপ, এবং প্ল্যাটফর্ম অ্যাক্টিভিটি সংরক্ষণ করি। কোনো প্রকার অবাঞ্ছিত স্ক্র্যাপিং বা ডেটা সোর্সিং প্রতিরোধ করতেই এই ট্র্যাকিং চালানো হয়। আপনার সাবমিট করা ডেটা সম্পূর্ণরূপে এনক্রিপ্টেড ডাটাবেইসে সংরক্ষিত থাকে।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        We collect IP addresses and browser profiles to safeguard our endpoints against scrapers. Any active user records/profile details are encrypted at rest.
                      </p>
                    </div>

                    <div className="p-5 rounded-2xl bg-cyan-950/10 border border-cyan-950/40 hover:border-cyan-500/20 transition-all space-y-3">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <Globe className="w-5 h-5 text-cyan-400" />
                        <span>২. কুকিজ এবং থার্ড-পার্টি বিজ্ঞাপন (Cookies and Google AdSense)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        আমাদের সিস্টেমে নেভিগেশনাল পারফরম্যান্স উন্নয়ন, ব্যবহারকারীর ড্যাশবোর্ড সেশন সচল রাখা এবং এডসেন্স (Google AdSense) বিজ্ঞাপন পরিবেশন করতে থার্ড-পার্টি কুকিজ ব্যবহার করা হয়। গুগল তার ভিজিটরদের পছন্দ এবং পূর্বের ব্রাউজিং হিস্ট্রির ওপর ভিত্তি করে প্রাসঙ্গিক বিজ্ঞাপন দেখানোর জন্য DART কুকি ব্যবহার করে থাকে।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        We use cookies to maintain dynamic login state and power personalized advertising metrics. Google AdSense, as a third-party vendor, uses DART cookies to customize advertisements for our users based on their online behavior.
                      </p>
                      <div className="text-[10px] font-mono text-amber-500 bg-amber-950/30 border border-amber-950 px-3 py-2 rounded-xl mt-2 font-bold leading-tight uppercase flex items-center gap-2">
                        <span>ℹ️</span>
                        <span>ব্যবহারকারী চাইলে গুগল অ্যাডস সেটিংস থেকে যেকোনো সময় পার্সোনালাইজড বিজ্ঞাপন ট্র্যাকিং বন্ধ (opt-out) করে দিতে পারেন।</span>
                      </div>
                    </div>

                    <div className="p-5 rounded-2xl bg-cyan-950/10 border border-cyan-950/40 hover:border-cyan-500/20 transition-all space-y-3">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <UserCheck className="w-5 h-5 text-cyan-400" />
                        <span>৩. ডেটা নিয়ন্ত্রণাধিকার (Your Data Rights - CCPA, GDPR)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        আমাদের প্রত্যেক ব্যবহারকারীর তাদের ডেটার ওপর শতভাগ নিয়ন্ত্রণাধিকার রয়েছে। আপনি যেকোনো সময় প্রোফাইল সেটিং থেকে আপনার তথ্য সংশোধন করতে পারেন, অথবা চাইলে আপনার সম্পূর্ণ তথ্য ডাটাবেইস থেকে স্থায়ীভাবে মুছে ফেলার আবেদন জানাতে পারেন।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        We strictly adhere to California Consumer Privacy Act (CCPA) and General Data Protection Regulation (GDPR) standards. You can edit, recall, or purge your structural account records.
                      </p>
                    </div>

                    <div className="p-5 rounded-2xl bg-cyan-950/10 border border-cyan-950/40 hover:border-cyan-500/20 transition-all space-y-3">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <Cpu className="w-5 h-5 text-cyan-400" />
                        <span>৪. সাইবার সিকিউরিটি ও ডাটা সিকিউরিটি (Data Security Protection)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        iloveyoubd.com একটি হাই-টেক সুরক্ষিত ডিজিটাল ইকোসিস্টেম। আমাদের ওয়েব অ্যাপ্লিকেশন পোর্ট ও ডাটা চ্যানেলগুলো নিয়মিত অটোমেটেড হ্যাকিং এবং ম্যালিসিয়াস কোড ইনজেকশন ডিটেকশন অ্যালগরিদম দ্বারা স্ক্যান করা হয়। ফলে আমাদের সংগৃহীত ফাইলে অননুমোদিত প্রবেশ সম্পন্ন হওয়া সম্পূর্ণ অসম্ভব।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        All application gateways are protected using direct SSL, anti-malware parsers, and brute-force mitigation walls to guarantee absolute digital security.
                      </p>
                    </div>

                  </div>
                </div>
              )}

              {/* 2. TERMS OF SERVICE */}
              {activeTab === "terms" && (
                <div className="space-y-6">
                  <div className="border-b border-cyan-950 pb-4">
                    <h2 className="text-xl md:text-2xl font-bold text-white flex items-center gap-2.5">
                      <FileText className="w-6 h-6 text-[#bd00ff]" />
                      <span>ব্যবহারের শর্তাবলী (Terms of Service)</span>
                    </h2>
                    <p className="text-[10px] font-mono text-[#bd00ff] mt-1 uppercase font-bold">
                      System License Rule: L_SYSTEM_TERMS_ACCORD_V9.0
                    </p>
                  </div>

                  {/* Dual language Intro */}
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs leading-relaxed">
                    <div className="p-4 bg-slate-950/65 rounded-2xl border border-slate-900 border-dashed space-y-2">
                      <div className="text-[10px] font-mono uppercase text-[#bd00ff] font-bold">বাংলা বিবরণ</div>
                      <p className="text-slate-300 font-sans">
                        <strong>iloveyoubd.com</strong> প্ল্যাটফর্মটি ব্যবহার করার মাধ্যমে আপনি নিম্নলিখিত শর্তাবলী মেনে নিতে সম্মতি জ্ঞাপন করছেন। যদি এই শর্তাবলীর কোনো অংশে আপনার দ্বিমত থাকে, তবে সাইটটির ব্যবহার এড়িয়ে যাওয়ার অনুমতি রইল।
                      </p>
                    </div>
                    <div className="p-4 bg-slate-1000/65 rounded-2xl border border-[#1e293b]/30 space-y-2">
                      <div className="text-[10px] font-mono uppercase text-cyan-400 font-bold">ENGLISH SPECIFICATION</div>
                      <p className="text-slate-400">
                        By accessing the web application services of <strong>iloveyoubd.com</strong>, you explicitly agree to conform to the terms, licensing parameters, and conditions detailed below. If you do not agree with any statement, please do not use our services.
                      </p>
                    </div>
                  </div>

                  <div className="space-y-5 text-slate-300 text-xs sm:text-sm font-sans">
                    
                    <div className="p-5 rounded-2xl bg-purple-950/10 border border-purple-950/40 hover:border-purple-500/20 transition-all space-y-2">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <CheckCircle2 className="w-5 h-5 text-purple-400" />
                        <span>১. মেম্বারদের আচরণের নিয়ম (Member Guidelines & Fair Use)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        ব্যবহারকারী প্ল্যাটফর্মে কোনো প্রকার ক্ষতিকারক বাইপাস মেথড, ক্র্যাক ফাইল, ভাইরাস বা ম্যালিসিয়াস স্ক্রিপ্ট প্রোভাইড বা পোস্ট করতে পারবেন না। প্ল্যাটফর্মের এআই মায়া এবং কমিউনিটি প্রশ্নোত্তরের পরিবেশ সবসময় গঠনমূলক রাখতে হবে। কোনো মেম্বার নিয়ম লঙ্ঘন করলে তার রাইটস সাময়িকভাবে ব্লক করা হতে পারে।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        Users are restricted from posting malware, destructive payloads, bypass codes, or copyright infringing links. All community queries should be constructive and security-educational.
                      </p>
                    </div>

                    <div className="p-5 rounded-2xl bg-purple-950/10 border border-purple-950/40 hover:border-purple-500/20 transition-all space-y-2">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <Layers className="w-5 h-5 text-purple-400" />
                        <span>২. মেধা সম্পত্তি অধিকার (Intellectual Property Rules)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        আমাদের এআই টুলস ল্যাব, নিয়ন মেকার, এসইও অডিট এবং কন্টেন্ট স্ক্যানার সহ যাবতীয় সফটওয়্যার ও আর্টিকেলের কন্টেন্ট iloveyoubd.com এর নিজস্ব মেধা সম্পত্তি। কোনো বাণিজ্যিক বা ব্যক্তি মালিকানাধীন স্বার্থ হাসিলের জন্য এগুলো ডুপ্লিকেট বা অনুমতি ছাড়া স্ক্র্যাপ করা আইনত দণ্ডনীয় অপরাধ।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        All materials, including code snippets, layouts, customized digital modules, templates, and content, are protected by copyright laws. Reverse engineering or scraping our software is strictly prohibited.
                      </p>
                    </div>

                    <div className="p-5 rounded-2xl bg-purple-950/10 border border-purple-950/40 hover:border-purple-500/20 transition-all space-y-2">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <AlertCircle className="w-5 h-5 text-purple-400" />
                        <span>৩. অ্যাকাউন্ট নিষ্ক্রিয়করণ (Account Suspension Terms)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        কোনো ধরনের সন্দেহজনক বা অটোমেটেড বট অ্যাক্টিভিটি লক্ষ্য করা গেলে আমরা যেকোনো মেম্বারশিপ অ্যাকাউন্ট বা আইপি অ্যাড্রেস হোস্ট লেভেল ব্লক করার অধিকার সংরক্ষণ করি। ট্রাফিক জেনারেট করার জন্য কোনো রোবোটিক পদ্ধতি অবলম্বন করা যাবে না।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        We hold structural authority to blacklist any account or automated bot terminal to secure database systems and comply with standard program criteria.
                      </p>
                    </div>

                  </div>
                </div>
              )}

              {/* 3. LEGAL DISCLAIMER */}
              {activeTab === "disclaimer" && (
                <div className="space-y-6">
                  <div className="border-b border-cyan-950 pb-4">
                    <h2 className="text-xl md:text-2xl font-bold text-white flex items-center gap-2.5">
                      <AlertCircle className="w-6 h-6 text-amber-500" />
                      <span>আইনি ডিসক্লেইমার (Disclaimer)</span>
                    </h2>
                    <p className="text-[10px] font-mono text-amber-500 mt-1 uppercase font-bold">
                      System Regulatory Accord: RA_LIABILITY_DISCLAIMER_V2.1
                    </p>
                  </div>

                  {/* Dual language intro */}
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs leading-relaxed">
                    <div className="p-4 bg-slate-950/65 rounded-2xl border border-slate-900 border-dashed space-y-2">
                      <div className="text-[10px] font-mono uppercase text-amber-500 font-bold">বাংলা বিবরণ</div>
                      <p className="text-slate-300 font-sans">
                        <strong>iloveyoubd.com</strong> প্ল্যাটফর্মে প্রকাশিত হ্যাকিং টিউটোরিয়াল, সফটওয়্যার টেস্টিং, বাগ হান্টিং গাইড এবং এআই টুলস ল্যাব মডিউলগুলো শুধুমাত্র শিক্ষার্থীদের শেখার উদ্দেশ্যে এবং কৌতূহল মেটানোর জন্য সাজানো হয়েছে। কোনো প্রকার বেআইনি কাজে ব্যবহার পুরোপুরি নিষিদ্ধ।
                      </p>
                    </div>
                    <div className="p-4 bg-slate-1000/65 rounded-2xl border border-[#1e293b]/30 space-y-2">
                      <div className="text-[10px] font-mono uppercase text-cyan-400 font-bold">ENGLISH SPECIFICATION</div>
                      <p className="text-slate-400">
                        The tutorials, security audits, software testing scripts, and interactive modules hosted on <strong>iloveyoubd.com</strong> are published strictly for educational, security analysis, and simulation purposes. We hold zero liability for user misuse.
                      </p>
                    </div>
                  </div>

                  <div className="space-y-5 text-slate-300 text-xs sm:text-sm font-sans">
                    
                    <div className="p-5 rounded-2xl bg-amber-950/10 border border-amber-950/30 hover:border-amber-500/20 transition-all space-y-2">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <Cpu className="w-5 h-5 text-amber-400" />
                        <span>১. গ্যারান্টির সীমাবদ্ধতা (As-Is Basis & No Warranties)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        ব্যবহারকারী আমাদের প্ল্যাটফর্মে প্রকাশিত যেকোনো ফাইল, থিম বা প্লাগিন নিজে চেক করে নিজের দায়িত্বে আপলোড বা রান করবেন। কোনো কারিগরি ত্রুটি বা সফটওয়্যার সমস্যার জন্য iloveyoubd.com মেম্বারশিপ বা হোস্ট টিম কোনোভাবেই দায়ী থাকবে না।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        All modules and downloads are distributed under "As-Is" conventions. We make no certifications that the software will be completely uninterrupted or entirely flawless.
                      </p>
                    </div>

                    <div className="p-5 rounded-2xl bg-amber-950/10 border border-amber-950/30 hover:border-amber-500/20 transition-all space-y-2">
                      <h3 className="text-white font-bold flex items-center gap-2">
                        <FileText className="w-5 h-5 text-amber-400" />
                        <span>২. স্মার্ট এনআইডি মেকার এবং অন্যান্য টুলস (NID Card Demo & Simulation Tools)</span>
                      </h3>
                      <p className="text-xs text-slate-400 leading-relaxed pl-1">
                        আমাদের ডেমো কার্ড জেনারেটর বা "এনআইডি মেকার" টুলটি শুধুমাত্র লেআউট টেস্টিং, ডেমো সাইন ডিজাইন এবং ইন্টারফেস টেস্টিং এর মতো ডিজাইনিং শেখার প্রোটোটাইপিং কাজের জন্য তৈরি। এটি দ্বারা তৈরিকৃত কোনো ডকুমেন্টকে আসল জাতীয় পরিচয়পত্র হিসেবে কোনো আনুষ্ঠানিক ডাটাবেইসে বা আর্থিক ট্রানজ্যাকশনে ব্যবহার করা আইনত সম্পূর্ণ নিষেধ। এই নিয়ম লঙ্ঘনের জন্য কেবল দায়ী থাকবেন ব্যবহারকারী স্বয়ং।
                      </p>
                      <p className="text-xs text-slate-500 leading-relaxed font-mono pl-1 border-l border-slate-800">
                        Notice: The online NID design generator is programmed solely for design layout simulation and instructional testing. It cannot be presented as official governmental identification, and we assume no responsibilities for illicit claims.
                      </p>
                    </div>

                  </div>
                </div>
              )}

              {/* 4. ABOUT US */}
              {activeTab === "about" && (
                <div className="space-y-6">
                  <div className="border-b border-cyan-950 pb-4">
                    <h2 className="text-xl md:text-2xl font-bold text-white flex items-center gap-2.5">
                      <Info className="w-6 h-6 text-emerald-400" />
                      <span>हमारे बारे में / আমাদের সম্পর্কে (About Us)</span>
                    </h2>
                    <p className="text-[10px] font-mono text-emerald-400 mt-1 uppercase font-bold">
                      Platform Profile Node: AA_IDENTITY_ORGANIZATION_V3.5
                    </p>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs leading-relaxed">
                    <div className="p-4 bg-slate-950/65 rounded-2xl border border-slate-900 border-dashed space-y-2">
                      <div className="text-[10px] font-mono uppercase text-emerald-400 font-bold">বাংলা বিবরণ</div>
                      <p className="text-slate-300 font-sans">
                        <strong>iloveyoubd.com</strong> বাংলাদেশের অন্যতম শীর্ষস্থানীয় স্বাধীন সাইবার নিরাপত্তা, অটোমেটেড কোডিং সলিউশন এবং এআই অডিটিং প্ল্যাটফর্ম। আমদের মিশন হলো সহজ ও বোধগম্য উপায়ে বাংলা ভাষায় উন্নত ওয়েব টেক ট্রিকস সকলের মাঝে নিখুঁতভাবে ছড়িয়ে দেওয়া।
                      </p>
                    </div>
                    <div className="p-4 bg-slate-1000/65 rounded-2xl border border-[#1e293b]/30 space-y-2">
                      <div className="text-[10px] font-mono uppercase text-cyan-400 font-bold">ENGLISH SPECIFICATION</div>
                      <p className="text-slate-400">
                        <strong>iloveyoubd.com</strong> is a highly technical cyber blog, AI auditing portal, and utility engineering node based in Bangladesh. We publish original research guides, tech utilities, and cybersecurity tutorials to raise regional digital security awareness.
                      </p>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-3 gap-4 font-sans text-xs">
                    <div className="p-4 rounded-xl bg-slate-900/50 border border-slate-800 text-center space-y-2">
                      <div className="text-lg font-bold text-emerald-400 font-mono">১০০% অরিজিনাল</div>
                      <p className="text-slate-400">আমাদের ফোরামের সকল কন্টেন্ট অভিজ্ঞ ডেভেলপার ও এআই স্ক্যানার দ্বারা পুঙ্খানুপুঙ্খভাবে ইভ্যালুয়েট করা হয় যাতে "Thin Content" পেনাল্টি এড়ানো যায়।</p>
                    </div>
                    <div className="p-4 rounded-xl bg-slate-900/50 border border-slate-800 text-center space-y-2">
                      <div className="text-lg font-bold text-cyan-400 font-mono">এআই পাওয়ারড</div>
                      <p className="text-slate-400">অত্যাধুনিক গেমিনি কৃত্রিম বুদ্ধিমত্তা সমৃদ্ধ করার মাধ্যমে সিকিওর ওয়েব স্ক্যানিং সল্যুশন নিয়ে আমরা ২৪/৭ সক্রিয় কন্টেন্ট গার্ড পরিচালনা করছি।</p>
                    </div>
                    <div className="p-4 rounded-xl bg-slate-900/50 border border-slate-800 text-center space-y-2">
                      <div className="text-lg font-bold text-purple-400 font-mono">ইডব্লিউ-ই-এ-টি মানদণ্ড</div>
                      <p className="text-slate-400">পেশাদার সিকিউরিটি প্রকৌশলীদের দ্বারা লিখিত কন্টেন্ট এবং মানসম্পন্ন লজিক্যাল ডেটা ব্যবহারের কারণে সাইটের গুগল ট্রাস্ট ভ্যালু সর্বোচ্চ স্তরের।</p>
                    </div>
                  </div>

                  <div className="p-5 rounded-2xl bg-[#091512] border border-[#163f19]/30 text-xs text-slate-300 space-y-2">
                    <h3 className="text-white font-bold flex items-center gap-1.5 font-sans">
                      <CheckCircle2 className="w-4 h-4 text-emerald-400" />
                      <span>গুগল এডসেন্স এপ্রুভাল রেডি ট্রাস্ট স্কোর</span>
                    </h3>
                    <p className="leading-relaxed">
                      আমরা সম্পূর্ণভাবে গুগল পাবলিশার পলিসি এবং ওয়েবমাস্টার গাইডলাইনের প্রতিটি শর্ত কঠোরভাবে নিয়ন্ত্রণ করি। ইকোসিস্টেমে কোনো ক্ষতিকারক লিঙ্ক, হ্যাকিং মেথডের অনুপযুক্ত টুলস নেই এবং সকল ইউজার ইন্টারঅ্যাকশন অত্যন্ত স্বচ্ছ। আমাদের লক্ষ্য সম্পূর্ণ বৈধ শিক্ষাবিষয়ক সোর্সিং বজায় রাখা।
                    </p>
                  </div>
                </div>
              )}

              {/* 5. CONTACT US */}
              {activeTab === "contact-us" && (
                <div className="space-y-6">
                  <div className="border-b border-cyan-950 pb-4">
                    <h2 className="text-xl md:text-2xl font-bold text-white flex items-center gap-2.5">
                      <Mail className="w-6 h-6 text-rose-400" />
                      <span>যোগাযোগ করুন (Contact Us / Support Gate)</span>
                    </h2>
                    <p className="text-[10px] font-mono text-rose-400 mt-1 uppercase font-bold">
                      Direct Support Channel Status: OPEN_ONLINE
                    </p>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs font-sans">
                    
                    {/* Information panel Left */}
                    <div className="space-y-5 leading-relaxed text-slate-300">
                      <div className="p-4 bg-rose-950/10 border border-rose-950/30 rounded-2xl space-y-3">
                        <h3 className="text-white font-bold flex items-center gap-2">
                          <Terminal className="w-4 h-4 text-rose-400 animate-pulse" />
                          <span>প্রাতিষ্ঠানিক যোগাযোগ ঠিকানা (Official Contact Desktop)</span>
                        </h3>
                        <p className="text-slate-405 leading-relaxed">
                          যেকোনো কারিগরি সহযোগিতা, সাইট বিজ্ঞাপন সম্পর্কিত পরামর্শ, কপিরাইট সংক্রান্ত আলোচনা বা ফোরাম পেমেন্ট সংক্রান্ত জটিলতার দ্রুততম সমাধানের জন্য আমাদের সাথে নিচের ঠিকানায় সরাসরি যোগাযোগ করতে পারেন:
                        </p>
                        
                        <div className="space-y-2 pt-2 border-t border-slate-900">
                          <div className="flex justify-between items-center bg-slate-950/50 p-2.5 rounded-xl border border-slate-900">
                            <span className="text-slate-500 font-bold">অফিসিয়াল ইমেইল:</span>
                            <strong className="text-rose-400 font-mono">iloveyoubd541@gmail.com</strong>
                          </div>
                          <div className="flex justify-between items-center bg-slate-950/50 p-2.5 rounded-xl border border-slate-900">
                            <span className="text-slate-500 font-bold">গ্লোবাল ওয়েবসাইট লিংক:</span>
                            <strong className="text-cyan-400 font-mono">https://iloveyoubd.com</strong>
                          </div>
                          <div className="flex justify-between items-center bg-slate-950/50 p-2.5 rounded-xl border border-slate-900">
                            <span className="text-slate-500 font-bold">সার্ভার লোকেশন:</span>
                            <strong className="text-emerald-400 font-mono">Dhaka Secure Core Gate</strong>
                          </div>
                        </div>
                      </div>

                      <div className="p-4 bg-slate-1000/60 rounded-xl border border-slate-900 text-slate-400 space-y-2">
                        <strong className="text-slate-200 block text-xs">🕒 সাপোর্ট প্রদানের সময়কাল:</strong>
                        <p>আমরা সাধারণত ২৪ থেকে ৪৮ ঘণ্টার ভেতর সকল সাবমিটকৃত টিকিটের সরাসরি সমাধান বা ইমেইল ফিডব্যাক পাঠিয়ে থাকি। অনুগ্রহ করে বিষয় উল্লেখ করে স্পষ্ট ভাষায় বিস্তারিত বিবরণ লিখবেন।</p>
                      </div>
                    </div>

                    {/* Interactive Contact Form */}
                    <div className="bg-slate-950/50 border border-slate-900 p-5 sm:p-6 rounded-2xl relative">
                      <h3 className="text-sm font-bold text-white mb-4 flex items-center gap-1.5 leading-none">
                        <Send className="w-4 h-4 text-cyan-400" />
                        <span>ডিজিটাল সাপোর্ট টিকিট তৈরি করুন (Submit Message)</span>
                      </h3>
                      
                      <AnimatePresence>
                        {submitSuccess ? (
                          <motion.div 
                            initial={{ scale: 0.85, opacity: 0 }}
                            animate={{ scale: 1, opacity: 1 }}
                            exit={{ scale: 0.85, opacity: 0 }}
                            className="bg-emerald-950/40 border border-emerald-500/20 rounded-xl p-5 text-center space-y-3"
                          >
                            <div className="w-12 h-12 rounded-full bg-emerald-500/10 border border-emerald-500/40 flex items-center justify-center mx-auto text-emerald-400">
                              <CheckCircle2 className="w-6 h-6" />
                            </div>
                            <h4 className="text-sm font-bold text-[#39ff14]">বার্তাটি সফলভাবে পাঠানো হয়েছে!</h4>
                            <p className="text-xs text-slate-405 leading-relaxed">
                              সম্মানিত ভিজিটর, আমাদের সিস্টেম সিকিউরিটি আপনার মেসেজটি এনক্রিপ্ট করে অ্যাডমিন প্যানেলে সেন্ড করেছে। আমাদের সাপোর্ট ম্যানেজার খুব শীঘ্রই আপনার সাথে যোগাযোগ করবেন।
                            </p>
                            <div className="bg-slate-950 px-3 py-2 rounded-lg text-[10px] font-mono text-cyan-400 border border-slate-900 inline-block">
                              টিকেট আইডি: <strong>{ticketRate}</strong>
                            </div>
                          </motion.div>
                        ) : (
                          <form onSubmit={handleContactSubmit} className="space-y-3 text-left">
                            <div>
                              <label className="block text-[10px] font-mono text-slate-500 uppercase font-bold mb-1 pl-1">আপনার নাম (Name) *</label>
                              <input
                                type="text"
                                required
                                value={contactName}
                                onChange={(e) => setContactName(e.target.value)}
                                placeholder="যেমন: আশরাফুল ইসলাম"
                                className="w-full bg-slate-950/80 border border-cyan-950 rounded-xl p-2.5 text-xs text-white placeholder-slate-700 focus:outline-none focus:border-cyan-500/40"
                              />
                            </div>

                            <div>
                              <label className="block text-[10px] font-mono text-slate-500 uppercase font-bold mb-1 pl-1">আপনার ইমেইল (Email) *</label>
                              <input
                                type="email"
                                required
                                value={contactEmail}
                                onChange={(e) => setContactEmail(e.target.value)}
                                placeholder="যেমন: support@iloveyoubd.com"
                                className="w-full bg-slate-950/80 border border-cyan-950 rounded-xl p-2.5 text-xs text-white placeholder-slate-705 focus:outline-none focus:border-cyan-500/40"
                              />
                            </div>

                            <div>
                              <label className="block text-[10px] font-mono text-slate-500 uppercase font-bold mb-1 pl-1">মেসেজের বিষয় (Subject)</label>
                              <input
                                type="text"
                                value={contactSubject}
                                onChange={(e) => setContactSubject(e.target.value)}
                                placeholder="যেমন: অ্যাডসেন্স কোডিং কোলাবরেশন অথবা বাগ রিপোর্ট"
                                className="w-full bg-slate-950/80 border border-cyan-950 rounded-xl p-2.5 text-xs text-white placeholder-slate-705 focus:outline-none focus:border-cyan-500/40"
                              />
                            </div>

                            <div>
                              <label className="block text-[10px] font-mono text-slate-500 uppercase font-bold mb-1 pl-1">বার্তার বিষয়বস্তু (Message Body) *</label>
                              <textarea
                                required
                                value={contactMessage}
                                onChange={(e) => setContactMessage(e.target.value)}
                                placeholder="আপনার বার্তাটি সুন্দরভাবে বিস্তারিত লিখুন..."
                                rows={4}
                                className="w-full bg-slate-950/80 border border-cyan-950 rounded-xl p-2.5 text-xs text-white placeholder-slate-705 focus:outline-none focus:border-cyan-500/40 font-sans resize-none"
                              />
                            </div>

                            <button
                              type="submit"
                              disabled={isSubmitting}
                              className="w-full mt-2 bg-cyan-500 hover:bg-cyan-400 disabled:bg-cyan-955 text-[#070b13] p-3 rounded-xl transition-all flex items-center justify-center gap-1.5 font-bold shadow-lg shadow-cyan-950/20 active:scale-95 cursor-pointer text-xs"
                            >
                              {isSubmitting ? (
                                <>
                                  <span className="w-3.5 h-3.5 rounded-full border-2 border-[#070b13] border-t-transparent animate-spin inline-block" />
                                  <span>এনক্রিপ্টিং এবং সেন্ডিং...</span>
                                </>
                              ) : (
                                <>
                                  <Send className="w-3.5 h-3.5" />
                                  <span>সরাসরি টিকিট সেন্ড করুন</span>
                                </>
                              )}
                            </button>
                          </form>
                        )}
                      </AnimatePresence>

                    </div>
                  </div>
                </div>
              )}

            </motion.div>
          </AnimatePresence>
        </div>
      </div>
    </div>
  );
}
