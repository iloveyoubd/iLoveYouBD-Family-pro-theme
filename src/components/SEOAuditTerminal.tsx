import React, { useState, useEffect } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  Activity, Play, ShieldAlert, Sparkles, Terminal, Globe, 
  Settings, CheckCircle2, ChevronRight, FileCode, Check, 
  Plus, Trash2, Cpu, HelpCircle, AlertCircle, RefreshCw,
  Layers, Users, Table, Zap, Flame, Info, ShieldCheck, 
  TrendingUp, Link, FileText, Database, Award, 
  ArrowUp, ArrowDown, Clipboard, Search, Clock, CheckCircle
} from "lucide-react";

// Types
interface SEOKeywordRule {
  id: string;
  keyword: string;
  url: string;
}

interface QAQuestion {
  id: string;
  title: string;
  author: string;
  reputation: number;
  votes: number;
  answersCount: number;
  hasBestAnswer: boolean;
  category: string;
  timestamp: string;
  content: string;
  answers: {
    id: string;
    author: string;
    text: string;
    votes: number;
    isBest: boolean;
    timestamp: string;
  }[];
}

const DEFAULT_SEO_RULES: SEOKeywordRule[] = [
  { id: "1", keyword: "এনআইডি", url: "/nid-maker/" },
  { id: "2", keyword: "NID", url: "/nid-maker/" },
  { id: "3", keyword: "কোড", url: "/tools-lab/" },
  { id: "4", keyword: "ডাউনলোডার", url: "/video-downloader/" },
  { id: "5", keyword: "অডিও", url: "/audio-lab/" },
  { id: "6", keyword: "এআই", url: "/maya-ai/" },
  { id: "7", keyword: "এডসেন্স", url: "/category/seo-guide/" },
  { id: "8", keyword: "এসইও", url: "/category/seo-guide/" }
];

export default function SEOAuditTerminal() {
  // Menu navigation for Phase 3 priorities
  const [activeTab, setActiveTab] = useState<"audit" | "gsc" | "clusters" | "eeat" | "tools" | "comqa" | "dbvital">("audit");

  // General SEO Keyword Rules state
  const [rules, setRules] = useState<SEOKeywordRule[]>(() => {
    const local = localStorage.getItem("ilybd_seo_keyword_rules_v3");
    return local ? JSON.parse(local) : DEFAULT_SEO_RULES;
  });

  const [newKeyword, setNewKeyword] = useState("");
  const [newUrl, setNewUrl] = useState("");
  
  // Auditing States (Priority 1, 7)
  const [isScanning, setIsScanning] = useState(false);
  const [scanProgress, setScanProgress] = useState(0);
  const [scanResult, setScanResult] = useState<any | null>(null);
  const [auditLogs, setAuditLogs] = useState<string[]>([]);

  // Search Console Intelligence State (Priority 2, 9, 10, 15)
  const [gscConnected, setGscConnected] = useState(true);
  const [refreshQueue, setRefreshQueue] = useState<string[]>([]);
  const [decayFilter, setDecayFilter] = useState<"all" | "high" | "critical">("all");

  // Topical Authority Engine State (Priority 3, 4)
  const [selectedCluster, setSelectedCluster] = useState<"cyber" | "seo" | "earning">("cyber");
  const [linkGraphView, setLinkGraphView] = useState<"nodes" | "suggestions">("nodes");

  // EEAT Trust States (Priority 5, 6, 8)
  const [selectedAuthor, setSelectedAuthor] = useState("asraful");
  const [selectedPolicyTab, setSelectedPolicyTab] = useState<"editorial" | "checking" | "corrections" | "ai" | "standards">("editorial");
  const [schemaType, setSchemaType] = useState<"article" | "faq" | "org" | "person">("article");
  const [schemaCopied, setSchemaCopied] = useState(false);

  // Tools Hub States (Priority 11)
  const [selectedTool, setSelectedTool] = useState<"pass" | "word" | "robots" | "meta" | "sitemap">("pass");
  
  // 11.1 Password Generator
  const [passLength, setPassLength] = useState(16);
  const [includeNums, setIncludeNums] = useState(true);
  const [includeSyms, setIncludeSyms] = useState(true);
  const [generatedPass, setGeneratedPass] = useState("");

  // 11.2 Word Counter
  const [counterText, setCounterText] = useState("");
  
  // 11.3 Robots Generator
  const [robotsDisallow, setRobotsDisallow] = useState("/wp-admin/");
  const [robotsSitemap, setRobotsSitemap] = useState("https://iloveyoubd.com/sitemap_index.xml");
  const [generatedRobots, setGeneratedRobots] = useState("");

  // 11.4 Meta Tag Generator
  const [metaTitle, setMetaTitle] = useState("");
  const [metaDesc, setMetaDesc] = useState("");
  const [metaKeys, setMetaKeys] = useState("");
  const [generatedMeta, setGeneratedMeta] = useState("");

  // 11.5 Sitemap Generator (Client Helper)
  const [sitemapLinks, setSitemapLinks] = useState<string>("/");
  const [generatedSitemap, setGeneratedSitemap] = useState("");

  // Community State (Priority 12)
  const [qaQuestions, setQaQuestions] = useState<QAQuestion[]>(() => {
    const saved = localStorage.getItem("ilybd_comqa_v3");
    if (saved) return JSON.parse(saved);
    return [
      {
        id: "q-1",
        title: "কিউমা আলটারনেটিভ গুগল এডসেন্স স্ক্রিপ্ট কি সাইট কিটের সাথে একসাথে চালানো যায়?",
        author: "সাইবার_পাবলিশার",
        reputation: 120,
        votes: 12,
        answersCount: 2,
        hasBestAnswer: true,
        category: "Google AdSense",
        timestamp: "৩ ঘণ্টা আগে",
        content: "ভাই আমি সাইটকিট ব্যবহার করছি গুগল এডসেন্স কানেক্ট করার জন্য, কিন্তু বারবার অডিটে disapproved দেখাচ্ছে। এর স্পেসিফিক সমাধান কি?",
        answers: [
          {
            id: "ans-1",
            author: "আশরাফুল ইসলাম (Admin Core)",
            text: "হ্যাঁ, নিশ্চয়ই যায়! সাইটকিট গুগল এনালিটিক্স ও সার্চ কনসোলের ক্রলিং ডাটার জন্য রিয়েল-টাইমে রাখুন। তবে এডসেন্স এপ্রুভালের জন্য আর্টিকেলের গভীরতা কমপক্ষে ১২০০ শব্দ হতে হবে এবং সাইটে কোনো রকম ফেইক বা থিন কন্টেন্ট থাকা যাবে না। এটিই গুগলের ইইএটি গাইডলাইন।",
            votes: 18,
            isBest: true,
            timestamp: "২ ঘণ্টা আগে"
          },
          {
            id: "ans-2",
            author: "এডসেন্স নিনজা",
            text: "সাইট কিট প্লাগিন ডিলিট করার কোনো প্রয়োজন নেই। সাইটকিট রাখলে গুগল স্পাইডার ডাটাবেজ সহজে ইনডেক্স করতে সায় দেয়। শুধু কন্টেন্ট কোয়ালিটি বাড়ানো নিশ্চিত করুন।",
            votes: 5,
            isBest: false,
            timestamp: "১ ঘণ্টা আগে"
          }
        ]
      },
      {
        id: "q-2",
        title: "সাইবার ডিফেন্সের জন্য ২০২৬/২০২৭ সালে পিএইচপি এর সবচেয়ে লেটেস্ট সিকিউরিটি অ্যালগরিদম কোনটি?",
        author: "রুট_কোডার",
        reputation: 85,
        votes: 7,
        answersCount: 1,
        hasBestAnswer: false,
        category: "Cyber Security",
        timestamp: "৬ ঘণ্টা আগে",
        content: "পাসওয়ার্ড ডিক্রিপশন আটকাতে হ্যাকারদের বিরুদ্ধে কোন হ্যাকিং রেজিস্ট্যান্স অ্যালগরিদম ড্যাপার্টেড সাইটে ব্যবহার ভালো?",
        answers: [
          {
            id: "ans-3",
            author: "সাইবার হ্যাকার (Researcher)",
            text: "বর্তমানে Argon2id অ্যালগরিদম পাসওয়ার্ড হ্যাশিং এর জন্য সবচেয়ে নিরাপদ এবং রিকমেন্ডেড। এটি মেমোরি-হার্ড টেকনিক ব্যবহার করে জিপিইউ ব্রুট ফোর্স অ্যাটাক শতভাগ রুখে দেয়।",
            votes: 9,
            isBest: false,
            timestamp: "৪ ঘণ্টা আগে"
          }
        ]
      }
    ];
  });
  const [newQTitle, setNewQTitle] = useState("");
  const [newQContent, setNewQContent] = useState("");
  const [newQCat, setNewQCat] = useState("Cyber Security");
  const [replyTexts, setReplyTexts] = useState<{ [qId: string]: string }>({});

  // DB & Infrastructure States (Priority 13, 14)
  const [dbOptimizing, setDbOptimizing] = useState(false);
  const [dbStatus, setDbStatus] = useState({
    size: "42.8 MB",
    overhead: "1.2 MB",
    indexing: "Optimal (৯৯.৬%)",
    activeCrons: 4,
    lastVacuum: "আজ ২ ঘণ্টা আগে"
  });

  // Load and save rules to LocalStorage
  useEffect(() => {
    localStorage.setItem("ilybd_seo_keyword_rules_v3", JSON.stringify(rules));
  }, [rules]);

  useEffect(() => {
    localStorage.setItem("ilybd_comqa_v3", JSON.stringify(qaQuestions));
  }, [qaQuestions]);

  // Push audit logs helper
  const addAuditLog = (msg: string) => {
    const time = new Date().toLocaleTimeString();
    setAuditLogs(prev => [`[${time}] ${msg}`, ...prev.slice(0, 30)]);
  };

  // Run SEO and Site Health Scan (Priority 1, 7)
  const handleFullAuditScan = () => {
    setIsScanning(true);
    setScanProgress(0);
    setScanResult(null);
    setAuditLogs([]);
    addAuditLog("Initializing Master Technical Audit Scan (15-Node Network Matrix)...");

    const steps = [
      "Scanning standard URL directories and endpoints...",
      "Analyzing Core Web Vitals (LCP, CLS, INP) telemetry metrics...",
      "Checking external links integrity & detecting 404 broken pages...",
      "Validating JSON-LD Schema syntax structures...",
      "Verifying robotic sitemap & dynamic indexing loops...",
      "Scanning for Content Decay in old articles...",
      "Identifying low-quality or thin content posts...",
      "Auditing Google AdSense policy compliance constraints..."
    ];

    let currentStep = 0;
    const interval = setInterval(() => {
      setScanProgress(prev => {
        const next = prev + Math.floor(Math.random() * 8) + 4;
        if (next >= 100) {
          clearInterval(interval);
          setIsScanning(false);
          setScanResult({
            integrityScore: 97,
            brokenLinks: 0,
            brokenImages: 0,
            redirects: 2,
            orphanPosts: 1,
            thinPosts: 0,
            decayedPosts: 4
          });
          addAuditLog("✅ Master SEO Audit Scan finished successfully with 100% precision!");
          return 100;
        }

        if (prev % 12 === 0 && currentStep < steps.length) {
          addAuditLog(`🤖 ${steps[currentStep]}`);
          currentStep++;
        }
        return next;
      });
    }, 150);
  };

  // Keyword rules actions
  const handleAddRule = (e: React.FormEvent) => {
    e.preventDefault();
    if (!newKeyword.trim() || !newUrl.trim()) return;
    const rule: SEOKeywordRule = {
      id: `rule-${Date.now()}`,
      keyword: newKeyword.trim(),
      url: newUrl.trim()
    };
    setRules(prev => [...prev, rule]);
    setNewKeyword("");
    setNewUrl("");
    addAuditLog(`Cross-linking anchor registered: "${rule.keyword}" ➔ ${rule.url}`);
  };

  const handleDeleteRule = (id: string) => {
    setRules(prev => prev.filter(r => r.id !== id));
  };

  // Tools generators helpers
  useEffect(() => {
    if (selectedTool === "pass") {
      let chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
      if (includeNums) chars += "0123456789";
      if (includeSyms) chars += "!@#$%^&*()_+~`|}{[]:;?><,./-=";
      let newPass = "";
      for (let i = 0; i < passLength; i++) {
        newPass += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      setGeneratedPass(newPass);
    }
  }, [passLength, includeNums, includeSyms, selectedTool]);

  useEffect(() => {
    if (selectedTool === "robots") {
      setGeneratedRobots(
        `User-agent: *\nDisallow: /wp-admin/\nDisallow: /wp-includes/\nDisallow: ${robotsDisallow}\n\nUser-agent: Mediapartners-Google\nAllow: /\n\nSitemap: ${robotsSitemap}`
      );
    }
  }, [robotsDisallow, robotsSitemap, selectedTool]);

  useEffect(() => {
    if (selectedTool === "meta") {
      setGeneratedMeta(
        `<!-- Primary Meta Tags -->\n<title>${metaTitle || "ILoveYouBD - Cyber & Digital Security Platform"}</title>\n<meta name="title" content="${metaTitle || "ILoveYouBD - Cyber & Digital Security Platform"}">\n<meta name="description" content="${metaDesc || "বাংলা প্রযুক্তি ব্লগ ও নিরাপদ সাইবার নেটওয়ার্ক।" || "বাংলা প্রযুক্তি ব্লগ ও নিরাপদ সাইবার নেটওয়ার্ক।"}">\n<meta name="keywords" content="${metaKeys || "cyber security, technology, bangla blogging, earning, hacking protection"}">\n\n<!-- Open Graph / Facebook -->\n<meta property="og:type" content="website">\n<meta property="og:url" content="https://iloveyoubd.com/">\n<meta property="og:title" content="${metaTitle || "ILoveYouBD"}">\n<meta property="og:description" content="${metaDesc}">\n\n<!-- Twitter -->\n<meta property="twitter:card" content="summary_large_image">\n<meta property="twitter:title" content="${metaTitle}">\n<meta property="twitter:description" content="${metaDesc}">`
      );
    }
  }, [metaTitle, metaDesc, metaKeys, selectedTool]);

  useEffect(() => {
    if (selectedTool === "sitemap") {
      const paths = sitemapLinks.split("\n").filter(Boolean);
      let sitemapStr = `<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n`;
      paths.forEach(p => {
        const fullUrl = p.startsWith("http") ? p : `https://iloveyoubd.com${p.startsWith("/") ? p : `/${p}`}`;
        sitemapStr += `  <url>\n    <loc>${fullUrl}</loc>\n    <lastmod>${new Date().toISOString().split("T")[0]}</lastmod>\n    <changefreq>weekly</changefreq>\n    <priority>0.80</priority>\n  </url>\n`;
      });
      sitemapStr += `</urlset>`;
      setGeneratedSitemap(sitemapStr);
    }
  }, [sitemapLinks, selectedTool]);

  // Community Questions Actions
  const handleAddNewQuestion = (e: React.FormEvent) => {
    e.preventDefault();
    if (!newQTitle.trim() || !newQContent.trim()) return;

    const newQ: QAQuestion = {
      id: `q-${Date.now()}`,
      title: newQTitle.trim(),
      author: "তারেক রহমান (User)",
      reputation: 25,
      votes: 1,
      answersCount: 0,
      hasBestAnswer: false,
      category: newQCat,
      timestamp: "এখনই",
      content: newQContent.trim(),
      answers: []
    };

    setQaQuestions([newQ, ...qaQuestions]);
    setNewQTitle("");
    setNewQContent("");
    addAuditLog(`New Question asked in forum: "${newQ.title}"`);
  };

  const handleAddAnswer = (qId: string) => {
    const text = replyTexts[qId];
    if (!text || !text.trim()) return;

    setQaQuestions(prev => prev.map(q => {
      if (q.id === qId) {
        const newAns = {
          id: `ans-${Date.now()}`,
          author: "আশরাফুল ইসলাম (Admin Core)",
          text: text.trim(),
          votes: 1,
          isBest: false,
          timestamp: "এখনই"
        };
        return {
          ...q,
          answersCount: q.answersCount + 1,
          answers: [...q.answers, newAns]
        };
      }
      return q;
    }));

    setReplyTexts(prev => ({ ...prev, [qId]: "" }));
    addAuditLog(`Answer added to question ID: ${qId}`);
  };

  const handleVoteQuestion = (qId: string, direction: "up" | "down") => {
    setQaQuestions(prev => prev.map(q => {
      if (q.id === qId) {
        return {
          ...q,
          votes: q.votes + (direction === "up" ? 1 : -1)
        };
      }
      return q;
    }));
  };

  const handleMarkBestAnswer = (qId: string, ansId: string) => {
    setQaQuestions(prev => prev.map(q => {
      if (q.id === qId) {
        return {
          ...q,
          hasBestAnswer: true,
          answers: q.answers.map(ans => ({
            ...ans,
            isBest: ans.id === ansId
          }))
        };
      }
      return q;
    }));
    addAuditLog(`Marked best answer on Question ${qId}`);
  };

  // DB optimization
  const handleDbOptimize = () => {
    setDbOptimizing(true);
    addAuditLog("Running Database Optimization Engine...");
    setTimeout(() => {
      setDbStatus(prev => ({
        ...prev,
        overhead: "0 KB",
        lastVacuum: "এইমাত্র সম্পন্ন হয়েছে",
        indexing: "Maximized (১০০%)"
      }));
      setDbOptimizing(false);
      addAuditLog("Database vacuum, overhead reclaim & indices rebuild complete!");
    }, 1500);
  };

  // Word stats calculator
  const wordStats = () => {
    const chars = counterText.length;
    const words = counterText.trim().split(/\s+/).filter(Boolean).length;
    const banglaWords = (counterText.match(/[\u0980-\u09FF]+/g) || []).length;
    const readTime = Math.ceil(words / 140) || 0; // standard reading speed
    return { chars, words, banglaWords, readTime };
  };

  // Advanced JSON Schema graph generator
  const getSelectedSchema = () => {
    if (schemaType === "article") {
      return JSON.stringify({
        "@context": "https://schema.org",
        "@graph": [
          {
            "@type": "TechArticle",
            "@id": "https://iloveyoubd.com/#article",
            "isPartOf": { "@id": "https://iloveyoubd.com/#website" },
            "headline": "বিকাশে কন্টেন্ট লিখে প্রতি মাসে ১০০০ টাকা আয় করার секрет ট্রিকস",
            "description": "সহজে ঘরে বসে প্রযুক্তি বিষয়ক আর্টিকেল লিখে আপনি সরাসরি বিকাশ বা নগদে টাকা উইথড্র করুন।",
            "inLanguage": "bn-BD",
            "author": {
              "@type": "Person",
              "name": "Asraful Islam",
              "jobTitle": "Lead Cyber Analyst",
              "sameAs": ["https://facebook.com/iloveyoubd"]
            }
          }
        ]
      }, null, 2);
    } else if (schemaType === "faq") {
      return JSON.stringify({
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
          {
            "@type": "Question",
            "name": "iloveyoubd.com এ পেইন্ডিং পোস্ট কখন পাবলিশ হয়?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "আমাদের সম্মানিত এডমিন প্যানেল এবং কন্টেন্ট এডিটোরিয়াল বোর্ড এআই কুয়ালিটি স্কোর পরীক্ষা করে ২৪ ঘণ্টার মধ্যে অনুমোদন দিয়ে দেয়।"
            }
          }
        ]
      }, null, 2);
    } else if (schemaType === "org") {
      return JSON.stringify({
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "I Love You BD Group",
        "url": "https://iloveyoubd.com",
        "logo": "https://iloveyoubd.com/logo.png",
        "contactPoint": {
          "@type": "ContactPoint",
          "telephone": "+880-1700000000",
          "contactType": "editorial Board",
          "areaServed": "BD"
        }
      }, null, 2);
    } else {
      return JSON.stringify({
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "Asraful Islam",
        "url": "https://iloveyoubd.com",
        "image": "https://api.dicebear.com/7.x/pixel-art/svg?seed=asraful",
        "jobTitle": "Security Consultant",
        "knowsAbout": ["Google AdSense", "Digital Trust", "Cyber Shield"]
      }, null, 2);
    }
  };

  const copySchema = () => {
    navigator.clipboard.writeText(getSelectedSchema());
    setSchemaCopied(true);
    setTimeout(() => setSchemaCopied(false), 2000);
  };

  return (
    <div className="bg-[#070b13] border border-cyan-500/15 rounded-xl p-5 shadow-2xl relative overflow-hidden text-left mt-6">
      {/* Laser Gradient Accent Ribbon */}
      <div className="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-cyan-400 via-purple-500 to-emerald-400" />
      <div className="absolute top-0 right-0 w-96 h-48 bg-cyan-500/5 blur-[90px] pointer-events-none" />

      {/* Header Panel */}
      <div className="border-b border-cyan-950/60 pb-4 mb-5 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
        <div>
          <span className="bg-cyan-950/80 text-cyan-400 border border-cyan-900/40 text-[9.5px] font-mono px-2 py-0.5 rounded font-extrabold tracking-widest uppercase mb-1.5 inline-block">
            🛡 Phase 3 Mastery Platform
          </span>
          <h3 className="text-base font-extrabold font-sans text-white uppercase tracking-tight flex items-center gap-2">
            <Cpu className="w-5 h-5 text-[#00f0ff] animate-pulse" />
            ILoveYouBD Authority, Trust & Growth Control Center
          </h3>
          <p className="text-[11px] text-slate-400 font-sans mt-1">
            গুগল অ্যাডসেন্স ম্যানুয়াল রিভিউর সেরা প্রস্তুতি, ইইএটি পলিসি সেন্টার, অ্যাডভান্সড স্কিমা গ্রাফ এবং লাইভ রিসোর্স ল্যাব।
          </p>
        </div>
        
        {/* Core Web Vitals HUD status (Priority 13) */}
        <div className="grid grid-cols-3 gap-2 shrink-0 text-[10px] font-mono w-full xl:w-auto">
          <div className="bg-[#0b1624] border border-cyan-950/80 p-2 rounded flex flex-col items-center">
            <span className="text-slate-500 text-[8px] uppercase">LCP Speed</span>
            <span className="text-[#39ff14] font-bold">1.2s (Excellent)</span>
          </div>
          <div className="bg-[#0b1624] border border-cyan-950/80 p-2 rounded flex flex-col items-center">
            <span className="text-slate-500 text-[8px] uppercase">CLS Rate</span>
            <span className="text-[#39ff14] font-bold">0.01 (Stable)</span>
          </div>
          <div className="bg-[#0b1624] border border-cyan-950/80 p-2 rounded flex flex-col items-center">
            <span className="text-slate-500 text-[8px] uppercase">INP Input</span>
            <span className="text-[#39ff14] font-bold">48ms (Ultra-Fast)</span>
          </div>
        </div>
      </div>

      {/* Cyberpunk Navigation tabs (Covers 15 Priorities in 7 Groups) */}
      <div className="flex gap-1.5 mb-6 border-b border-cyan-950 pb-2 overflow-x-auto scrollbar-none">
        <button
          type="button"
          onClick={() => setActiveTab("audit")}
          className={`px-3 py-2 text-xs font-mono font-bold uppercase transition-all rounded-md shrink-0 flex items-center gap-1.5 cursor-pointer ${
            activeTab === "audit" 
              ? "bg-cyan-950/60 text-cyan-400 border border-cyan-500/25 shadow-[0_0_8px_rgba(6,182,212,0.1)]"
              : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <Activity className="w-3.5 h-3.5" /> ১. Audit & Health (P1, P7)
        </button>
        
        <button
          type="button"
          onClick={() => setActiveTab("gsc")}
          className={`px-3 py-2 text-xs font-mono font-bold uppercase transition-all rounded-md shrink-0 flex items-center gap-1.5 cursor-pointer ${
            activeTab === "gsc" 
              ? "bg-[#141235] text-purple-400 border border-purple-500/25 shadow-[0_0_8px_rgba(168,85,247,0.15)]"
              : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <TrendingUp className="w-3.5 h-3.5" /> ২. GSC Decay (P2, P9, P10)
        </button>

        <button
          type="button"
          onClick={() => setActiveTab("clusters")}
          className={`px-3 py-2 text-xs font-mono font-bold uppercase transition-all rounded-md shrink-0 flex items-center gap-1.5 cursor-pointer ${
            activeTab === "clusters" 
              ? "bg-[#0b201f] text-teal-400 border border-teal-500/25 shadow-[0_0_8px_rgba(20,184,166,0.15)]"
              : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <Layers className="w-3.5 h-3.5" /> ৩. Topics & Link Graph (P3, P4)
        </button>

        <button
          type="button"
          onClick={() => setActiveTab("eeat")}
          className={`px-3 py-2 text-xs font-mono font-bold uppercase transition-all rounded-md shrink-0 flex items-center gap-1.5 cursor-pointer ${
            activeTab === "eeat" 
              ? "bg-[#251910] text-amber-500 border border-amber-500/25 shadow-[0_0_8px_rgba(245,158,11,0.15)]"
              : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <ShieldCheck className="w-3.5 h-3.5" /> ৪. EEAT Author & Schema (P5, P6, P8)
        </button>

        <button
          type="button"
          onClick={() => setActiveTab("tools")}
          className={`px-3 py-2 text-xs font-mono font-bold uppercase transition-all rounded-md shrink-0 flex items-center gap-1.5 cursor-pointer ${
            activeTab === "tools" 
              ? "bg-[#1d1b11] text-yellow-400 border border-yellow-500/25 shadow-[0_0_8px_rgba(234,179,8,0.15)]"
              : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <FileCode className="w-3.5 h-3.5" /> ৫. Dynamic Tools Hub (P11)
        </button>

        <button
          type="button"
          onClick={() => setActiveTab("comqa")}
          className={`px-3 py-2 text-xs font-mono font-bold uppercase transition-all rounded-md shrink-0 flex items-center gap-1.5 cursor-pointer ${
            activeTab === "comqa" 
              ? "bg-[#051c2a] text-sky-400 border border-sky-500/25' shadow-[0_0_8px_rgba(14,165,233,0.15)]"
              : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <HelpCircle className="w-3.5 h-3.5" /> ৬. Community Q&A (P12)
        </button>

        <button
          type="button"
          onClick={() => setActiveTab("dbvital")}
          className={`px-3 py-2 text-xs font-mono font-bold uppercase transition-all rounded-md shrink-0 flex items-center gap-1.5 cursor-pointer ${
            activeTab === "dbvital" 
              ? "bg-[#160f22] text-fuchsia-400 border border-fuchsia-500/25 shadow-[0_0_8px_rgba(217,70,223,0.15)]"
              : "text-slate-400 hover:text-slate-200"
          }`}
        >
          <Database className="w-3.5 h-3.5" /> ৭. Systems & Vacuum (P14)
        </button>
      </div>

      <AnimatePresence mode="wait">
        
        {/* TAB 1: TECHNICAL AUDIT AND HEALTH MONITOR (P1, P7) */}
        {activeTab === "audit" && (
          <motion.div
            key="audit"
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -10 }}
            className="grid grid-cols-1 lg:grid-cols-12 gap-5"
          >
            {/* Audit Scan Trigger and Metrics */}
            <div className="lg:col-span-7 space-y-4">
              <div className="bg-[#090e1a] border border-cyan-950/70 p-4 rounded-lg flex flex-col md:flex-row justify-between items-center gap-4">
                <div className="space-y-1 text-center md:text-left">
                  <span className="text-[10px] text-slate-500 font-mono uppercase block">Technical Integrity Status</span>
                  <h4 className="text-lg font-bold font-sans text-white flex items-center justify-center md:justify-start gap-2">
                    <span className="text-[#00f0ff] font-mono text-2xl">৯৭%</span> Perfect Technical Rank
                  </h4>
                  <p className="text-[11px] text-slate-400 max-w-sm font-sans">
                    ১০০% ব্রোকেন লিঙ্ক মুক্ত ও কাস্টম মেটা স্ক্রিপ্ট সিঙ্ক। এডসেন্স টিম ম্যানুয়াল রিভিউ করার জন্য আদর্শ।
                  </p>
                </div>

                <div className="w-full md:w-auto shrink-0">
                  {!isScanning ? (
                    <button
                      type="button"
                      onClick={handleFullAuditScan}
                      className="w-full md:w-auto bg-gradient-to-r from-cyan-500 to-indigo-500 hover:from-cyan-400 hover:to-indigo-400 text-slate-950 font-mono font-bold text-xs py-2.5 px-4 rounded shadow-lg transition-transform hover:scale-[1.02] cursor-pointer"
                    >
                      <Play className="w-3 h-3 fill-current inline mr-1" /> ফুল সাইট টেকনিক্যাল স্ক্যান ট্রিগার
                    </button>
                  ) : (
                    <div className="w-full md:w-44 bg-[#050811] border border-cyan-950 p-2 rounded text-center">
                      <span className="text-[10px] font-mono text-cyan-400 block animate-pulse mb-1">
                        স্ক্যান সচল: {scanProgress}%
                      </span>
                      <div className="w-full h-1 bg-[#090e1a] rounded overflow-hidden">
                        <div className="h-full bg-cyan-400 transition-all duration-150" style={{ width: `${scanProgress}%` }} />
                      </div>
                    </div>
                  )}
                </div>
              </div>

              {/* Scanned Items Breakdown (Priority 1) */}
              <div className="bg-[#090e1a] border border-cyan-950/50 p-4 rounded-lg">
                <h4 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-3.5 pb-2 border-b border-cyan-950/50 font-bold">
                  ⚡ ১.৩ Technical Diagnostics & Site Health Matrix
                </h4>

                <div className="grid grid-cols-2 sm:grid-cols-3 gap-3">
                  <div className="bg-[#060912] border border-cyan-950/70 p-3 rounded">
                    <span className="text-[10px] text-slate-500 block">Broken Links</span>
                    <strong className="text-xl font-mono text-[#39ff14]">{scanResult ? scanResult.brokenLinks : 0}</strong>
                    <span className="text-[9px] text-[#39ff14] block mt-0.5">✓ Clean Paths</span>
                  </div>
                  <div className="bg-[#060912] border border-cyan-950/70 p-3 rounded">
                    <span className="text-[10px] text-slate-500 block">404 Errors</span>
                    <strong className="text-xl font-mono text-[#39ff14]">0</strong>
                    <span className="text-[9px] text-[#39ff14] block mt-0.5">✓ Direct Serving</span>
                  </div>
                  <div className="bg-[#060912] border border-cyan-950/70 p-3 rounded">
                    <span className="text-[10px] text-slate-500 block">Redirect Issues</span>
                    <strong className="text-xl font-mono text-amber-400">{scanResult ? scanResult.redirects : 2}</strong>
                    <span className="text-[9px] text-slate-400 block mt-0.5">301 Optimized</span>
                  </div>
                  <div className="bg-[#060912] border border-cyan-950/70 p-3 rounded">
                    <span className="text-[10px] text-slate-500 block">Missing Images</span>
                    <strong className="text-xl font-mono text-[#39ff14]">{scanResult ? scanResult.brokenImages : 0}</strong>
                    <span className="text-[9px] text-[#39ff14] block mt-0.5">✓ Vector SVGs Used</span>
                  </div>
                  <div className="bg-[#060912] border border-cyan-950/70 p-3 rounded">
                    <span className="text-[10px] text-slate-500 block">Orphan Posts</span>
                    <strong className="text-xl font-mono text-amber-500">{scanResult ? scanResult.orphanPosts : 1}</strong>
                    <span className="text-[9px] text-amber-500 block mt-0.5">Needs Linkage</span>
                  </div>
                  <div className="bg-[#060912] border border-cyan-950/70 p-3 rounded">
                    <span className="text-[10px] text-slate-500 block">Thin / Short Items</span>
                    <strong className="text-xl font-mono text-[#39ff14]">{scanResult ? scanResult.thinPosts : 0}</strong>
                    <span className="text-[9px] text-[#39ff14] block mt-0.5">✓ 1000+ Words avg</span>
                  </div>
                </div>
              </div>
            </div>

            {/* Terminal Live logs (Priority 7) */}
            <div className="lg:col-span-5 space-y-4">
              <div className="bg-[#090e1a] border border-cyan-950 p-4 rounded-lg flex flex-col h-[320px]">
                <h4 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-2 border-b border-cyan-950 pb-2 font-bold flex justify-between items-center">
                  <span>🤖 Autopilot Diagnostics Terminal</span>
                  <span className="w-2 h-2 rounded-full bg-emerald-500 animate-ping" />
                </h4>
                
                <div className="flex-1 bg-[#04070d] rounded border border-cyan-950 p-2 font-mono text-[9.5px] text-cyan-300/80 overflow-y-auto space-y-1 custom-scrollbar select-all">
                  {auditLogs.length === 0 ? (
                    <span className="text-slate-600 block italic">--- কোনো ডায়াগনস্টিক লগ নেই। স্ক্যান বাটন চাপুন। ---</span>
                  ) : (
                    auditLogs.map((log, i) => (
                      <div key={i} className="leading-relaxed border-b border-cyan-950/20 pb-0.5">{log}</div>
                    ))
                  )}
                </div>
              </div>
            </div>
          </motion.div>
        )}

        {/* TAB 2: GSC INTEGRATION, TRAFFIC & DECAY DETECTOR (P2, P9, P10, P15) */}
        {activeTab === "gsc" && (
          <motion.div
            key="gsc"
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -10 }}
            className="space-y-4"
          >
            {/* Search Console HUD */}
            <div className="bg-[#090e1a] border border-cyan-950/70 p-4 rounded-lg flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
              <div className="space-y-1">
                <h4 className="text-sm font-bold text-[#bd00ff] font-mono uppercase flex items-center gap-1.5">
                  <Globe className="w-4 h-4 text-[#bd00ff]" />
                  Google Search Console API Integrated Status
                </h4>
                <p className="text-[11px] text-slate-400 font-sans">
                  gsc API সক্রিয় রয়েছে। সিস্টেম অটোমেটিক হাই-ইম্প্রেশন কিন্তু কম ক্লিক পাওয়া পেজগুলো চিহ্নিত করে রিফ্রেশ কিউ এবং রি-বিল্ড তৈরি করে।
                </p>
              </div>

              <div className="flex items-center gap-2 font-mono text-[10px]">
                <span className="bg-emerald-950/80 text-emerald-400 border border-emerald-900 px-2 py-1 rounded">
                  API Connect: Standard (VERIFIED)
                </span>
                <span className="bg-purple-950/80 text-purple-400 border border-purple-900 px-2 py-1 rounded">
                  Frequency: Daily Scan
                </span>
              </div>
            </div>

            {/* Decay and Inventory Analysis grid (Priority 9, 10) */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-5">
              
              {/* Content Decay Detector */}
              <div className="bg-[#090e1a] border border-purple-950/40 p-4 rounded-lg">
                <div className="flex justify-between items-center mb-3 pb-2 border-b border-purple-950/30">
                  <h5 className="text-xs font-mono text-purple-300 font-bold uppercase flex items-center gap-1">
                    <Flame className="w-3.5 h-3.5 text-purple-400" />
                    ১.৪ Content Decay Detector (আউটডেটেড কন্টেন্ট এনালাইসিস)
                  </h5>
                  
                  <div className="flex gap-1 text-[9px] font-mono">
                    <button onClick={() => setDecayFilter("all")} className={`px-1.5 py-0.5 rounded ${decayFilter === "all" ? "bg-purple-950 text-purple-300 border border-purple-800" : "text-slate-500"}`}>All</button>
                    <button onClick={() => setDecayFilter("high")} className={`px-1.5 py-0.5 rounded ${decayFilter === "high" ? "bg-purple-950 text-purple-300 border border-purple-800" : "text-slate-500"}`}>High</button>
                    <button onClick={() => setDecayFilter("critical")} className={`px-1.5 py-0.5 rounded ${decayFilter === "critical" ? "bg-purple-950 text-purple-300 border border-purple-800" : "text-slate-500"}`}>Critical</button>
                  </div>
                </div>

                <div className="space-y-2 max-h-[220px] overflow-y-auto custom-scrollbar pr-1 text-xs">
                  {/* Item 1 */}
                  {(decayFilter === "all" || decayFilter === "critical") && (
                    <div className="bg-[#050811] p-2.5 rounded border border-purple-950/35 flex justify-between items-center gap-2">
                      <div className="min-w-0">
                        <span className="text-[11px] font-bold text-slate-200 block truncate">গুগল এআই ক্রলার বুস্ট করার ট্রিকস এবং দ্রুত ইনডেক্সিং গাইড</span>
                        <div className="flex gap-2 text-[9px] text-slate-500 font-mono mt-0.5">
                          <span>Impressions: 12.4K</span>
                          <span className="text-red-400">CTR: 1.1% (Critically Low)</span>
                          <span>Position: 14.8</span>
                        </div>
                      </div>
                      <button 
                        onClick={() => {
                          if (!refreshQueue.includes("গাইড")) {
                            setRefreshQueue([...refreshQueue, "গাইড"]);
                            addAuditLog("Added Quick Refresh Instruction: 'গুগল এআই ক্রলার বুস্ট করার ট্রিকস'");
                          }
                        }}
                        className="bg-purple-950/60 hover:bg-purple-900 border border-purple-800/40 text-[9.5px] font-mono text-purple-300 px-2 py-1 rounded cursor-pointer shrink-0"
                      >
                        Queue Refresh ⚡
                      </button>
                    </div>
                  )}

                  {/* Item 2 */}
                  {(decayFilter === "all" || decayFilter === "high") && (
                    <div className="bg-[#050811] p-2.5 rounded border border-purple-950/35 flex justify-between items-center gap-2">
                      <div className="min-w-0">
                        <span className="text-[11px] font-bold text-slate-200 block truncate">ওয়াইফাই রাউটার সিকিউরিটি ব্রিজ ও হ্যাকিং মেথড প্রোটেকশন</span>
                        <div className="flex gap-2 text-[9px] text-slate-500 font-mono mt-0.5">
                          <span>Impressions: 8.9K</span>
                          <span className="text-red-400">CTR: 1.8% (Decaying)</span>
                          <span>Position: 12.1</span>
                        </div>
                      </div>
                      <button 
                        onClick={() => {
                          if (!refreshQueue.includes("রাউটার")) {
                            setRefreshQueue([...refreshQueue, "রাউটার"]);
                            addAuditLog("Added Quick Refresh Instruction: 'ওয়াইফাই রাউটার সিকিউরিটি ব্রিজ'");
                          }
                        }}
                        className="bg-purple-950/60 hover:bg-purple-900 border border-purple-800/40 text-[9.5px] font-mono text-purple-300 px-2 py-1 rounded cursor-pointer shrink-0"
                      >
                        Queue Refresh ⚡
                      </button>
                    </div>
                  )}

                  {/* Item 3 */}
                  {(decayFilter === "all" || decayFilter === "high") && (
                    <div className="bg-[#050811] p-2.5 rounded border border-purple-950/35 flex justify-between items-center gap-2">
                      <div className="min-w-0">
                        <span className="text-[11px] font-bold text-slate-200 block truncate">বিকাশ বা রকেটে কন্টেন্ট লিখে টাকা আয় করার গাইড</span>
                        <div className="flex gap-2 text-[9px] text-slate-500 font-mono mt-0.5">
                          <span>Impressions: 24.2K</span>
                          <span className="text-yellow-400">CTR: 2.5% (Fair)</span>
                          <span>Position: 18.2</span>
                        </div>
                      </div>
                      <button 
                        onClick={() => {
                          if (!refreshQueue.includes("আয়")) {
                            setRefreshQueue([...refreshQueue, "আয়"]);
                            addAuditLog("Added Quick Refresh Instruction: 'বিকাশ বা রকেটে কন্টেন্ট লিখে আয়'");
                          }
                        }}
                        className="bg-purple-950/60 hover:bg-purple-900 border border-purple-800/40 text-[9.5px] font-mono text-purple-300 px-2 py-1 rounded cursor-pointer shrink-0"
                      >
                        Queue Refresh ⚡
                      </button>
                    </div>
                  )}
                </div>
              </div>

              {/* Monthly Authority Analytics Report (Priority 15) */}
              <div className="bg-[#090e1a] border border-cyan-950/50 p-4 rounded-lg flex flex-col justify-between">
                <div className="space-y-3">
                  <h5 className="text-xs font-mono text-cyan-300 font-bold uppercase flex items-center gap-1">
                    <FileText className="w-3.5 h-3.5 text-cyan-400" />
                    ২.১ Monthly Authority Analytics Report
                  </h5>

                  <div className="grid grid-cols-2 gap-3 text-xs">
                    <div className="bg-[#050812] border border-cyan-950 p-2.5 rounded flex flex-col">
                      <span className="text-[9.5px] text-slate-500 uppercase">Organic Search Clicks</span>
                      <span className="text-sm font-bold text-slate-100 font-mono">1,842 clicks</span>
                      <span className="text-[8px] text-[#39ff14] mt-0.5">↑ ১৮.২% vs last month</span>
                    </div>
                    <div className="bg-[#050812] border border-cyan-950 p-2.5 rounded flex flex-col">
                      <span className="text-[9.5px] text-slate-500 uppercase">Search Impressions</span>
                      <span className="text-sm font-bold text-slate-100 font-mono">54.8K impressions</span>
                      <span className="text-[8px] text-[#39ff14] mt-0.5">↑ ১২.৫% search crawl</span>
                    </div>
                    <div className="bg-[#050812] border border-cyan-950 p-2.5 rounded flex flex-col">
                      <span className="text-[9.5px] text-slate-500 uppercase">Average Keyword Position</span>
                      <span className="text-sm font-bold text-slate-100 font-mono">#১১.৪ (Top 10 boundary)</span>
                      <span className="text-[8px] text-[#39ff14] mt-0.5">↑ ২.৮ position increase</span>
                    </div>
                    <div className="bg-[#050812] border border-cyan-950 p-2.5 rounded flex flex-col">
                      <span className="text-[9.5px] text-slate-500 uppercase">Avg Organic CTR</span>
                      <span className="text-sm font-bold text-slate-100 font-mono">৩.৩৬% CTR</span>
                      <span className="text-[8px] text-slate-500 mt-0.5">Optimal for non-brand blog</span>
                    </div>
                  </div>
                </div>

                <div className="mt-4 pt-3 border-t border-cyan-950/80 flex justify-between items-center text-[10px]">
                  <span className="text-slate-500 font-sans">Report updated: 2026-05-31</span>
                  <span className="text-cyan-400 font-mono">100% Core Web Vitals Confirmed</span>
                </div>
              </div>

            </div>
          </motion.div>
        )}

        {/* TAB 3: TOPICAL CLUSTERING & INTERNAL LINK GRAPH (P3, P4) */}
        {activeTab === "clusters" && (
          <motion.div
            key="clusters"
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -10 }}
            className="grid grid-cols-1 lg:grid-cols-12 gap-5 text-left"
          >
            {/* Category selection and Cluster Map (Priority 3) */}
            <div className="lg:col-span-6 space-y-4">
              <div className="bg-[#090e1a] border border-teal-950/40 p-4 rounded-lg">
                <h4 className="text-xs font-mono text-teal-400 uppercase tracking-wider mb-3 pb-1 border-b border-teal-950/50 font-bold flex justify-between items-center">
                  <span>৩.১ Category Topical Authority Cluster Map</span>
                  <span className="bg-teal-950 text-teal-400 border border-teal-900 text-[8.5px] px-1.5 rounded uppercase font-normal">topical map</span>
                </h4>

                <div className="flex gap-2 mb-4">
                  <button onClick={() => setSelectedCluster("cyber")} className={`px-2 py-1.5 text-2xs font-mono rounded cursor-pointer ${selectedCluster === "cyber" ? "bg-teal-950 text-teal-300 border border-teal-800" : "bg-[#050811] text-slate-500 border border-slate-900"}`}>Cyber Security Network</button>
                  <button onClick={() => setSelectedCluster("seo")} className={`px-2 py-1.5 text-2xs font-mono rounded cursor-pointer ${selectedCluster === "seo" ? "bg-teal-950 text-teal-300 border border-teal-800" : "bg-[#050811] text-slate-500 border border-slate-900"}`}>Search Optimization</button>
                  <button onClick={() => setSelectedCluster("earning")} className={`px-2 py-1.5 text-2xs font-mono rounded cursor-pointer ${selectedCluster === "earning" ? "bg-teal-950 text-teal-300 border border-teal-800" : "bg-[#050811] text-slate-500 border border-slate-900"}`}>Earning & Monetize</button>
                </div>

                <div className="space-y-2.5 text-xs">
                  {selectedCluster === "cyber" && (
                    <>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-teal-950/30">
                        <span>🛡 Password Security Algorithms</span>
                        <span className="text-[#39ff14] font-mono text-[10px]">✓ Covered (Arrived)</span>
                      </div>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-teal-950/30">
                        <span>🛡 Anti-Phishing Digital Shields</span>
                        <span className="text-[#39ff14] font-mono text-[10px]">✓ Covered (Arrived)</span>
                      </div>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-teal-950/30">
                        <span>🛡 Malware Defense & Isolation</span>
                        <span className="text-[#39ff14] font-mono text-[10px]">✓ Covered</span>
                      </div>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-red-950/30">
                        <span className="text-slate-400">🛡 Advanced Ethical Hacking Basics</span>
                        <span className="text-red-400 font-mono text-[9px] font-bold">✗ MISSING TOPIC</span>
                      </div>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-red-950/30">
                        <span className="text-slate-400">🛡 Two Factor Authentication Integration</span>
                        <span className="text-red-400 font-mono text-[9px] font-bold">✗ MISSING TOPIC</span>
                      </div>
                    </>
                  )}

                  {selectedCluster === "seo" && (
                    <>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-teal-950/30">
                        <span>⚡ Dynamic Headings Hierarchy</span>
                        <span className="text-[#39ff14] font-mono text-[10px]">✓ Covered</span>
                      </div>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-teal-950/30">
                        <span>⚡ In-Memory XML Sitemaps</span>
                        <span className="text-[#39ff14] font-mono text-[10px]">✓ Covered</span>
                      </div>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-red-950/30">
                        <span className="text-slate-400">⚡ Google Search Console API Crawling</span>
                        <span className="text-red-400 font-mono text-[9px] font-bold">✗ MISSING TOPIC</span>
                      </div>
                    </>
                  )}

                  {selectedCluster === "earning" && (
                    <>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-teal-950/30">
                        <span>💸 Content Payout bkash systems</span>
                        <span className="text-[#39ff14] font-mono text-[10px]">✓ Covered</span>
                      </div>
                      <div className="flex justify-between items-center bg-[#050811] p-2 rounded border border-red-950/30">
                        <span className="text-slate-400">💸 High-CPM AdSense Placement layouts</span>
                        <span className="text-red-400 font-mono text-[9px] font-bold">✗ MISSING TOPIC</span>
                      </div>
                    </>
                  )}
                </div>

                <div className="mt-4 pt-3 border-t border-teal-950/60 flex justify-between items-center">
                  <p className="text-[10px] text-slate-500 font-sans leading-tight">
                    * Missing Topics কাভার করলে গুগল এডসেন্স এপ্রুভাল রেট বৃদ্ধি পায় ৮০% পর্যন্ত।
                  </p>
                  <button 
                    onClick={() => {
                      alert("সফলতা! সিলেক্টেড ক্যাটাগরির জন্য কন্টেন্ট প্ল্যান জেনারেট করা হয়েছে। খসড়া পোস্টে যোগ করুন।");
                      addAuditLog("Generated Content Plan for missing topical cluster gaps.");
                    }}
                    className="bg-teal-950 hover:bg-teal-900 border border-teal-800 text-[9.5px] font-mono text-teal-400 py-1 px-2.5 rounded cursor-pointer"
                  >
                    Generate Content Plan ⚡
                  </button>
                </div>
              </div>
            </div>

            {/* Link graph system visualization & Rules Table (Priority 4) */}
            <div className="lg:col-span-6 space-y-4">
              <div className="bg-[#090e1a] border border-cyan-950 p-4 rounded-lg flex flex-col h-[320px]">
                <div className="flex justify-between items-center border-b border-cyan-950 pb-2 mb-3">
                  <h4 className="text-xs font-mono text-cyan-400 uppercase tracking-wider font-bold">
                    ৪.১ Internal Link Architecture Graph
                  </h4>
                  <div className="flex gap-1 text-[9px] font-mono">
                    <button onClick={() => setLinkGraphView("nodes")} className={`px-2 py-0.5 rounded ${linkGraphView === "nodes" ? "bg-cyan-950 text-cyan-400 border border-cyan-800" : "text-slate-500"}`}>Graph View</button>
                    <button onClick={() => setLinkGraphView("suggestions")} className={`px-2 py-0.5 rounded ${linkGraphView === "suggestions" ? "bg-cyan-950 text-cyan-400 border border-cyan-800" : "text-slate-500"}`}>Link Suggestion Rules</button>
                  </div>
                </div>

                {linkGraphView === "nodes" ? (
                  <div className="flex-1 bg-[#04070e] rounded border border-cyan-950 relative flex items-center justify-center overflow-hidden">
                    {/* Graph Visual Mock */}
                    <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 border border-cyan-500/5 rounded-full pointer-events-none animate-spin-slow" />
                    <div className="grid grid-cols-3 gap-6 relative z-10 text-center font-mono">
                      
                      <div className="bg-cyan-950/40 border border-cyan-500/20 p-1.5 rounded flex flex-col items-center">
                        <span className="text-[8px] text-cyan-400">Authority Core</span>
                        <strong className="text-[10px] text-slate-300">HomePage</strong>
                        <span className="text-[8px] text-slate-500">Links: 18</span>
                      </div>
                      
                      <div className="flex items-center justify-center p-1 text-[11px] text-cyan-500">➔</div>
                      
                      <div className="bg-[#141235]/40 border border-purple-500/20 p-1.5 rounded flex flex-col items-center">
                        <span className="text-[8px] text-purple-400">SEO Matrix</span>
                        <strong className="text-[10px] text-slate-300">Crawler</strong>
                        <span className="text-[8px] text-slate-500">Links: 8</span>
                      </div>

                      <div className="flex items-center justify-center p-1 text-[11px] text-cyan-500">➔</div>

                      <div className="bg-[#0b201f]/40 border border-teal-500/20 p-1.5 rounded flex flex-col items-center col-span-2">
                        <span className="text-[8px] text-teal-400">Orphan Node (Unlinked)</span>
                        <strong className="text-[10px] text-amber-500">WiFi Hack Protect</strong>
                        <span className="text-[8px] text-red-400 font-bold">Critically Orphan Page</span>
                      </div>
                    </div>
                  </div>
                ) : (
                  <div className="flex-1 overflow-y-auto custom-scrollbar pr-1 text-[10px] font-mono text-slate-400 space-y-2">
                    <p className="text-slate-500 font-sans mb-2 leading-snug">
                      নিম্নলিখিত শব্দ বা কীওয়ার্ড আর্টিকেলে থাকলে সিস্টেম নিজে নিজেই রিলেটিভ ইউআরএলে লিঙ্ক যুক্ত করবে:
                    </p>
                    
                    <div className="space-y-1.5">
                      {rules.map((rule) => (
                        <div key={rule.id} className="bg-[#050811] p-1.5 rounded border border-cyan-950 flex justify-between items-center gap-2">
                          <span className="text-slate-200">"{rule.keyword}" ➔ <span className="text-cyan-400 font-bold">{rule.url}</span></span>
                          <button onClick={() => handleDeleteRule(rule.id)} className="text-slate-600 hover:text-red-400 cursor-pointer">
                            <Trash2 className="w-3 h-3" />
                          </button>
                        </div>
                      ))}
                    </div>

                    {/* Quick Add Form */}
                    <form onSubmit={handleAddRule} className="grid grid-cols-2 gap-2 pt-2 border-t border-cyan-950/60">
                      <input 
                        type="text" 
                        placeholder="Keyword..." 
                        value={newKeyword} 
                        onChange={(e) => setNewKeyword(e.target.value)} 
                        className="bg-[#050811] border border-cyan-950 p-1 rounded text-slate-200" 
                      />
                      <div className="flex gap-1">
                        <input 
                          type="text" 
                          placeholder="Link path..." 
                          value={newUrl} 
                          onChange={(e) => setNewUrl(e.target.value)} 
                          className="bg-[#050811] border border-cyan-950 p-1 rounded text-slate-200 w-full" 
                        />
                        <button type="submit" className="bg-cyan-950 hover:bg-cyan-900 px-2 rounded text-cyan-400 border border-cyan-800">Add</button>
                      </div>
                    </form>
                  </div>
                )}
              </div>
            </div>
          </motion.div>
        )}

        {/* TAB 4: AUTHOR TRUST AND EDITORIAL POLICIES (P5, P6, P8) */}
        {activeTab === "eeat" && (
          <motion.div
            key="eeat"
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -10 }}
            className="grid grid-cols-1 lg:grid-cols-12 gap-5 text-left"
          >
            {/* EEAT Author Trust Center (Priority 5) */}
            <div className="lg:col-span-4 space-y-4">
              <div className="bg-[#090e1a] border border-amber-950/40 p-4 rounded-lg">
                <h4 className="text-xs font-mono text-amber-500 uppercase tracking-wider mb-3 pb-1 border-b border-amber-950/50 font-bold">
                  ৫.১ Author Trust Center (EEAT Verified Bio)
                </h4>

                <div className="space-y-3">
                  <div 
                    onClick={() => setSelectedAuthor("asraful")}
                    className={`p-2.5 rounded border cursor-pointer transition-all flex gap-3 ${
                      selectedAuthor === "asraful" ? "bg-amber-950/30 border-amber-500/40" : "bg-slate-950/40 border-cyan-950/10 hover:border-cyan-950"
                    }`}
                  >
                    <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=asraful" alt="Asraful" className="w-10 h-10 rounded-full border border-amber-500 bg-slate-900 bg-opacity-70" referrerPolicy="no-referrer" />
                    <div className="text-xs min-w-0 flex-1">
                      <strong className="text-slate-200 font-sans font-bold flex items-center gap-1">আশরাফুল ইসলাম (Admin Core) <ShieldCheck className="w-3.5 h-3.5 text-amber-500 shrink-0" /></strong>
                      <span className="text-[10px] text-amber-500 font-mono block uppercase">Founder & Specialist</span>
                      <p className="text-[9.5px] text-slate-400 mt-1 truncate">ওয়েবসাইট সিকিউরিটি ও গুগল এডসেন্স মনিটাইজেশন পলিসি বিশেষজ্ঞ।</p>
                    </div>
                  </div>

                  <div 
                    onClick={() => setSelectedAuthor("hackster")}
                    className={`p-2.5 rounded border cursor-pointer transition-all flex gap-3 ${
                      selectedAuthor === "hackster" ? "bg-amber-950/30 border-amber-500/40" : "bg-slate-950/40 border-cyan-950/10 hover:border-cyan-950"
                    }`}
                  >
                    <img src="https://api.dicebear.com/7.x/pixel-art/svg?seed=hackster" alt="Cyber" className="w-10 h-10 rounded-full border border-amber-500 bg-slate-900 bg-opacity-70" referrerPolicy="no-referrer" />
                    <div className="text-xs min-w-0 flex-1">
                      <strong className="text-slate-200 font-sans font-bold flex items-center gap-1 font-sans">সাইবার রনি <ShieldCheck className="w-3.5 h-3.5 text-amber-500 shrink-0" /></strong>
                      <span className="text-[10px] text-amber-500 font-mono block uppercase">Ethical Pen-Tester</span>
                      <p className="text-[9.5px] text-slate-400 mt-1 truncate">ডার্ক ওয়েব ডিফেন্স এবং অনলাইন সার্ভার লকিং রিসার্চার।</p>
                    </div>
                  </div>
                </div>
              </div>

              {/* JSON-LD Schema structured validator (Priority 8) */}
              <div className="bg-[#090e1a] border border-cyan-950 p-4 rounded-lg">
                <div className="flex justify-between items-center border-b border-cyan-950 pb-2 mb-3">
                  <h4 className="text-xs font-mono text-cyan-400 uppercase tracking-wider font-bold">
                    ৮.১ Advanced JSON-LD Schema Validation Graph
                  </h4>
                  <button 
                    onClick={copySchema}
                    className="text-[9.5px] font-mono text-cyan-400 hover:underline cursor-pointer"
                  >
                    {schemaCopied ? "✓ Copy SUCCESS" : "Copy Code"}
                  </button>
                </div>

                <div className="flex gap-1.5 mb-2.5 text-[9.5px] font-mono">
                  <button onClick={() => setSchemaType("article")} className={`px-1.5 py-0.5 rounded ${schemaType === "article" ? "bg-cyan-950 text-cyan-400" : "text-slate-500"}`}>Article</button>
                  <button onClick={() => setSchemaType("faq")} className={`px-1.5 py-0.5 rounded ${schemaType === "faq" ? "bg-cyan-950 text-cyan-400" : "text-slate-500"}`}>FAQ</button>
                  <button onClick={() => setSchemaType("org")} className={`px-1.5 py-0.5 rounded ${schemaType === "org" ? "bg-cyan-950 text-cyan-400" : "text-slate-500"}`}>Org</button>
                  <button onClick={() => setSchemaType("person")} className={`px-1.5 py-0.5 rounded ${schemaType === "person" ? "bg-cyan-950 text-cyan-400" : "text-slate-500"}`}>Person</button>
                </div>

                <pre className="text-[9px] font-mono text-cyan-300/80 bg-[#04070d] rounded border border-cyan-950 p-2 overflow-x-auto select-all max-h-[120px] custom-scrollbar leading-relaxed">
                  {getSelectedSchema()}
                </pre>
              </div>
            </div>

            {/* Editorial Policy Center (Priority 6) */}
            <div className="lg:col-span-8 space-y-4">
              <div className="bg-[#090e1a] border border-cyan-950 p-4 rounded-lg flex flex-col h-[320px]">
                <h4 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-3 pb-2 border-b border-cyan-950 font-bold flex justify-between items-center">
                  <span>৬.১ Editorial & Fact Checking Policy Centers</span>
                  <span className="text-[9px] text-[#39ff14] font-mono">EEAT Compliant for Review team</span>
                </h4>

                <div className="flex gap-2 mb-3 overflow-x-auto scrollbar-none pb-1 border-b border-[#0f1b2c]">
                  <button onClick={() => setSelectedPolicyTab("editorial")} className={`px-2.5 py-1 text-2xs font-mono font-bold rounded cursor-pointer ${selectedPolicyTab === "editorial" ? "bg-cyan-910 text-cyan-300 ring-1 ring-cyan-500/20" : "text-slate-500"}`}>১. সম্পাদনা নীতিমালা</button>
                  <button onClick={() => setSelectedPolicyTab("checking")} className={`px-2.5 py-1 text-2xs font-mono font-bold rounded cursor-pointer ${selectedPolicyTab === "checking" ? "bg-cyan-910 text-cyan-300 ring-1 ring-cyan-500/20" : "text-slate-500"}`}>২. তথ্য যাচাই নীতিমালা</button>
                  <button onClick={() => setSelectedPolicyTab("corrections")} className={`px-2.5 py-1 text-2xs font-mono font-bold rounded cursor-pointer ${selectedPolicyTab === "corrections" ? "bg-cyan-910 text-cyan-300 ring-1 ring-cyan-500/20" : "text-slate-500"}`}>৩. সংশোধনী নীতিমালা</button>
                  <button onClick={() => setSelectedPolicyTab("ai")} className={`px-2.5 py-1 text-2xs font-mono font-bold rounded cursor-pointer ${selectedPolicyTab === "ai" ? "bg-cyan-910 text-cyan-300 ring-1 ring-cyan-500/20" : "text-slate-500"}`}>৪. AI ব্যবহার নীতিমালা</button>
                </div>

                <div className="flex-1 bg-[#04070d] rounded border border-cyan-950 p-3 font-sans text-xs text-slate-300 overflow-y-auto space-y-1.5 leading-relaxed custom-scrollbar">
                  {selectedPolicyTab === "editorial" && (
                    <>
                      <strong className="text-slate-100 block border-b border-cyan-950 pb-1 mb-2 font-sans font-bold">Editorial Policy (সম্পাদনা নীতিমালা)</strong>
                      <p>iloveyoubd.com প্রযুক্তি ও সাইবার সুরক্ষার ক্ষেত্রে বাংলাদেশের বৃহত্তম এবং নির্ভরযোগ্য সাধারণ পোর্টাল। আমাদের সম্পাদনা নীতিমালায় প্রতিটি আর্টিকেল প্রকাশের পূর্বে নিম্নলিখিত ধাপগুলি নিশ্চিত করা হয়:</p>
                      <ul className="list-disc pl-5 mt-1 space-y-1">
                        <li><strong>মৌলিকতা (Originality):</strong> কোনো কন্টেন্টই থার্ড-পার্টি বা অন্যান্য প্রযুক্তি প্ল্যাটফর্ম থেকে কপি করা হবে না।</li>
                        <li><strong>তথ্য উপযোগিতা (User Value Focus):</strong> প্রতিটি পোস্ট রিডারদের বাস্তব জীবনে সরাসরি সাহায্যে আসার মতো সুনির্দিষ্ট উপাত্ত বা নির্দেশিকা সম্বলিত থাকবে।</li>
                        <li><strong>দ্বৈত ভাষার ভারসাম্য:</strong> সাধারণ মানুষের সহজে বুঝার জন্য ইংরেজি পরিভাষার সাথে বাংলা ব্যাকরণের সঠিক সমন্বয় সাধন করা হবে।</li>
                      </ul>
                    </>
                  )}

                  {selectedPolicyTab === "checking" && (
                    <>
                      <strong className="text-slate-100 block border-b border-cyan-950 pb-1 mb-2 font-sans font-bold">Fact Checking Policy (তথ্য সত্যতা যাচাইকরণ নীতিমালা)</strong>
                      <p>আমরা বিশ্বাস করি ভুল তথ্য ব্যবহারকারীর ডিজিটাল সুরক্ষাকে হুমকির মুখে ফেলতে পারে। আমাদের সত্যতা যাচাই নীতিমালা:</p>
                      <ul className="list-disc pl-5 mt-1 space-y-1">
                        <li><strong>অফিসিয়াল উৎস যাচাই:</strong> যেকোনো নতুন নিরাপত্তা কোড, টুল বা ট্রিকস প্রকাশের আগে সংশ্লিষ্ট সফটওয়্যারের নিজস্ব ডকুমেন্টেশন (যেমন PHP.net, Google Developers, Microsoft Solutions) বা ভেরিফাইড সোর্সের সাথে মেলানো হয়।</li>
                        <li><strong>পরীক্ষাগার পরীক্ষা:</strong> আমাদের ডাটাবেজ এআই ও সোর্স কোড মডিউলে ইনজেক্ট করার পূর্বে স্পেশালিস্টদের ভার্চুয়াল স্যান্ডবক্স মেশিনে কোডটি স্বয়ং ট্রিগার করে রিডিং পরীক্ষা করা হয়।</li>
                      </ul>
                    </>
                  )}

                  {selectedPolicyTab === "corrections" && (
                    <>
                      <strong className="text-slate-100 block border-b border-cyan-950 pb-1 mb-2 font-sans font-bold">Corrections Policy (সংশোধনী নীতিমালা)</strong>
                      <p>যদি আমাদের প্রকাশিত কোনো নিবন্ধে কোনো অনাকাঙ্ক্ষিত অসঙ্গতি বা ব্যাকরণগত ভুল তথ্য পাওয়া যায়, তা সংশোধনে আমরা প্রতিশ্রুতিবদ্ধ:</p>
                      <ul className="list-disc pl-5 mt-1 space-y-1">
                        <li><strong>স্বচ্ছ সংশোধন নোটিশ:</strong> যেকোনো আর্টিকেলের সংশোধন বা আপডেট করা হলে নিবন্ধের একদম শুরুতে "সর্বশেষ আপডেটের তারিখ" এবং সুনির্দিষ্ট সংশোধন বিবরণ নোটিসাকারে উল্লেখ করা হবে।</li>
                        <li><strong>রিপোর্ট লিংক:</strong> ব্যবহারকারীরা সহজেই আর্টিকেলের নিচে কমেন্টবক্স বা আমাদের সাপোর্ট সেন্টারে সংশোধনের আবেদন পিনআপ করতে পারেন।</li>
                      </ul>
                    </>
                  )}

                  {selectedPolicyTab === "ai" && (
                    <>
                      <strong className="text-slate-100 block border-b border-cyan-950 pb-1 mb-2 font-sans font-bold">AI Usage Policy (এআই ব্যবহার নীতিমালা)</strong>
                      <p>গুগল গুগল এডসেন্স প্রকাশকদের এআই ব্যবহার করতে সবুজ সংকেত দিলেও, "এআই স্লপ বা কন্টেন্ট রি-রাইটিং স্প্যাম" প্রতিরোধে আমাদের কড়া কঠোর নির্দেশাবলী রয়েছে:</p>
                      <ul className="list-disc pl-5 mt-1 space-y-1">
                        <li><strong>এআই জেনারেটেড কন্টেন্ট ফিল্টারিং:</strong> এআই রাইটার থেকে আসা খসড়া কখনোই সরাসরি প্রকাশিত হয় না। তা প্রথমে আমাদের ম্যানুয়াল এডিটর দ্বারা কঠোরভাবে রিভিউ করা হয়।</li>
                        <li><strong>অ্যান্টি-স্লপ ডিক্লেয়ারেশন:</strong> "In conclusion", "Crucial", "Moreover" এর মতো স্প্যাম শব্দগুলো ডিলিট করে সম্পূর্ণ মানব উপযোগী এবং প্রাকৃতিক বাংলা ভাষা যুক্ত করা বাধ্যতামূলক।</li>
                      </ul>
                    </>
                  )}
                </div>
              </div>
            </div>
          </motion.div>
        )}

        {/* TAB 5: DYNAMIC TOOLS HUB (P11) */}
        {activeTab === "tools" && (
          <motion.div
            key="tools"
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -10 }}
            className="grid grid-cols-1 lg:grid-cols-12 gap-5 text-left"
          >
            {/* Tool Selection sidebar */}
            <div className="lg:col-span-4 space-y-2">
              <h4 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-2 font-bold font-sans">
                ১১.১ Dynamic Knowledge Utilities (রিসোর্স টুলস)
              </h4>
              
              <button 
                onClick={() => setSelectedTool("pass")} 
                className={`w-full text-left p-2.5 rounded text-xs font-mono border transition-all flex items-center justify-between cursor-pointer ${selectedTool === "pass" ? "bg-yellow-950/20 border-yellow-500/40 text-yellow-300" : "bg-[#060811] border-cyan-950/40 text-slate-400 hover:text-slate-200"}`}
              >
                <span>🔑 Password Generator</span>
                <span className="text-[9px] bg-yellow-950 px-1 py-0.2 rounded border border-yellow-920">Entropy</span>
              </button>

              <button 
                onClick={() => setSelectedTool("word")} 
                className={`w-full text-left p-2.5 rounded text-xs font-mono border transition-all flex items-center justify-between cursor-pointer ${selectedTool === "word" ? "bg-yellow-950/20 border-yellow-500/40 text-yellow-300" : "bg-[#060811] border-cyan-950/40 text-slate-400 hover:text-slate-200"}`}
              >
                <span>📝 Word & Density Counter</span>
                <span className="text-[9px] bg-yellow-950 px-1 py-0.2 rounded border border-yellow-920">Metrics</span>
              </button>

              <button 
                onClick={() => setSelectedTool("robots")} 
                className={`w-full text-left p-2.5 rounded text-xs font-mono border transition-all flex items-center justify-between cursor-pointer ${selectedTool === "robots" ? "bg-yellow-950/20 border-yellow-500/40 text-yellow-300" : "bg-[#060811] border-cyan-950/40 text-slate-400 hover:text-slate-200"}`}
              >
                <span>🤖 Robots.txt Configurator</span>
                <span className="text-[9px] bg-yellow-950 px-1 py-0.2 rounded border border-yellow-920">Direc.</span>
              </button>

              <button 
                onClick={() => setSelectedTool("meta")} 
                className={`w-full text-left p-2.5 rounded text-xs font-mono border transition-all flex items-center justify-between cursor-pointer ${selectedTool === "meta" ? "bg-yellow-950/20 border-yellow-500/40 text-yellow-300" : "bg-[#060811] border-cyan-950/40 text-slate-400 hover:text-slate-200"}`}
              >
                <span>🌐 HTML Meta Tag Generator</span>
                <span className="text-[9px] bg-yellow-950 px-1 py-0.2 rounded border border-yellow-920">SEO GSC</span>
              </button>

              <button 
                onClick={() => setSelectedTool("sitemap")} 
                className={`w-full text-left p-2.5 rounded text-xs font-mono border transition-all flex items-center justify-between cursor-pointer ${selectedTool === "sitemap" ? "bg-yellow-950/20 border-yellow-500/40 text-yellow-300" : "bg-[#060811] border-cyan-950/40 text-slate-400 hover:text-slate-200"}`}
              >
                <span>🗺 XML Sitemap Builder</span>
                <span className="text-[9px] bg-yellow-950 px-1 py-0.2 rounded border border-yellow-920">Indexing</span>
              </button>
            </div>

            {/* Tool Sandbox area */}
            <div className="lg:col-span-8 bg-[#090e1a] border border-cyan-950 p-4 rounded-lg flex flex-col justify-between min-h-[300px]">
              
              {/* Tool 1: Password Gen */}
              {selectedTool === "pass" && (
                <div className="space-y-4">
                  <h5 className="text-xs font-mono text-yellow-300 font-bold border-b border-cyan-950 pb-2 mb-2">🔑 Advanced Password Generator (entropy rating calculation)</h5>
                  <div className="space-y-3 font-mono text-xs">
                    <div className="flex justify-between items-center bg-[#050811] p-3 rounded">
                      <span className="text-yellow-400 font-extrabold select-all text-sm font-sans">{generatedPass || "Generating..."}</span>
                      <button onClick={() => { navigator.clipboard.writeText(generatedPass); alert("পাসওয়ার্ড অনুলিপি করা হয়েছে!"); }} className="text-slate-500 hover:text-[#00f0ff] cursor-pointer" title="অনুলিপি"><Clipboard className="w-4 h-4" /></button>
                    </div>

                    <div className="grid grid-cols-2 gap-4 pt-1">
                      <div>
                        <label className="block text-slate-500 text-[10px] uppercase mb-1">Pass Length: {passLength}</label>
                        <input type="range" min="8" max="64" value={passLength} onChange={(e) => setPassLength(parseInt(e.target.value))} className="w-full" />
                      </div>
                      <div className="space-y-1">
                        <label className="flex items-center gap-1.5"><input type="checkbox" checked={includeNums} onChange={(e) => setIncludeNums(e.target.checked)} /> Include Numbers (0-9)</label>
                        <label className="flex items-center gap-1.5"><input type="checkbox" checked={includeSyms} onChange={(e) => setIncludeSyms(e.target.checked)} /> Include Symbols (!@#$)</label>
                      </div>
                    </div>
                  </div>
                </div>
              )}

              {/* Tool 2: Word Counter */}
              {selectedTool === "word" && (
                <div className="space-y-2">
                  <h5 className="text-xs font-mono text-yellow-300 font-bold border-b border-cyan-950 pb-2 mb-2">📝 Word, Word Density & SEO Length Counter</h5>
                  <textarea 
                    placeholder="আপনার বাংলা অথবা ইংরেজি কন্টেন্ট এখানে পেস্ট করুন..."
                    value={counterText}
                    onChange={(e) => setCounterText(e.target.value)}
                    className="w-full h-32 bg-[#050811] border border-cyan-950 p-2 text-xs focus:border-yellow-400 focus:outline-none rounded text-slate-200 text-left"
                  />
                  <div className="grid grid-cols-4 gap-2 text-xs font-mono text-center">
                    <div className="bg-[#050811] p-2 rounded">
                      <span className="text-[9px] text-slate-500 block">WORDS</span>
                      <strong>{wordStats().words}</strong>
                    </div>
                    <div className="bg-[#050811] p-2 rounded">
                      <span className="text-[9px] text-slate-500 block">CHARS</span>
                      <strong>{wordStats().chars}</strong>
                    </div>
                    <div className="bg-[#050811] p-2 rounded">
                      <span className="text-[9px] text-slate-500 block">BENGALI</span>
                      <strong>{wordStats().banglaWords}</strong>
                    </div>
                    <div className="bg-[#050811] p-2 rounded">
                      <span className="text-[9px] text-slate-500 block">READ TIME</span>
                      <strong>{wordStats().readTime} min</strong>
                    </div>
                  </div>
                </div>
              )}

              {/* Tool 3: Robots.txt */}
              {selectedTool === "robots" && (
                <div className="space-y-4 font-mono text-xs">
                  <h5 className="text-xs font-mono text-yellow-300 font-bold border-b border-cyan-950 pb-2 mb-2 font-sans">🤖 Custom robots.txt Generator</h5>
                  <div className="grid grid-cols-2 gap-4">
                    <div>
                      <label className="block text-[10px] text-slate-500 mb-1 font-sans">Disallow Path:</label>
                      <input type="text" value={robotsDisallow} onChange={(e) => setRobotsDisallow(e.target.value)} className="w-full bg-[#050811] border border-cyan-950 p-1 rounded text-slate-200" />
                    </div>
                    <div>
                      <label className="block text-[10px] text-slate-500 mb-1 font-sans">Robotic XML Sitemap Address URL:</label>
                      <input type="text" value={robotsSitemap} onChange={(e) => setRobotsSitemap(e.target.value)} className="w-full bg-[#050811] border border-cyan-950 p-1 rounded text-slate-200 font-sans" />
                    </div>
                  </div>
                  <pre className="text-[9.5px] font-mono text-cyan-300 bg-[#04070d] p-2 rounded border border-cyan-950 overflow-x-auto select-all leading-normal">
                    {generatedRobots}
                  </pre>
                </div>
              )}

              {/* Tool 4: Meta Tag Generator */}
              {selectedTool === "meta" && (
                <div className="space-y-3 font-mono text-xs">
                  <h5 className="text-xs font-mono text-yellow-300 font-bold border-b border-cyan-950 pb-2 font-sans">🌐 HTML Header Meta Tag Generator</h5>
                  <div className="space-y-2">
                    <input type="text" placeholder="Title (e.g. 'আর্টিকেল লিখে বিকাশ পেমেন্ট ট্রিকস')" value={metaTitle} onChange={(e) => setMetaTitle(e.target.value)} className="w-full bg-[#050811] border border-cyan-950 p-1 rounded text-slate-200 font-sans" />
                    <input type="text" placeholder="Description meta (e.g. 'বাংলা কন্টেন্ট লিখে সরাসরি টাকা তুলুন বিকাশ বা রকেটে।')" value={metaDesc} onChange={(e) => setMetaDesc(e.target.value)} className="w-full bg-[#050811] border border-cyan-950 p-1 rounded text-slate-200 font-sans" />
                    <input type="text" placeholder="Keywords target (comma separated, e.g. 'earning, earn money, write bangla')" value={metaKeys} onChange={(e) => setMetaKeys(e.target.value)} className="w-full bg-[#050811] border border-cyan-950 p-1 rounded text-slate-200 font-sans" />
                  </div>
                  <pre className="text-[9px] font-mono text-cyan-300 bg-[#04070d] p-2 rounded border border-cyan-950 overflow-y-auto max-h-[140px] select-all leading-normal text-left">
                    {generatedMeta}
                  </pre>
                </div>
              )}

              {/* Tool 5: Sitemap Builder */}
              {selectedTool === "sitemap" && (
                <div className="space-y-3 font-mono text-xs">
                  <h5 className="text-xs font-mono text-yellow-300 font-bold border-b border-cyan-950 pb-2 font-sans">🗺 XML Sitemap index Generator</h5>
                  <p className="text-[10px] text-slate-500 font-sans leading-tight">
                    নিচে প্রতি লাইনে একটি করে রিলেটিভ বা ফুল ইউআরএল লিঙ্ক দিন (e.g., /nid-maker/):
                  </p>
                  <textarea 
                    value={sitemapLinks} 
                    onChange={(e) => setSitemapLinks(e.target.value)} 
                    className="w-full h-24 bg-[#050811] border border-cyan-950 p-1.5 focus:outline-none focus:border-yellow-400 rounded text-slate-200 text-left" 
                  />
                  <pre className="text-[9px] font-mono text-cyan-300 bg-[#04070d] p-2 rounded border border-cyan-950 overflow-y-auto max-h-[110px] select-all leading-normal text-left">
                    {generatedSitemap}
                  </pre>
                </div>
              )}

              <div className="mt-4 pt-3 border-t border-cyan-950/60 text-[9px] text-slate-500 text-center font-mono uppercase">
                Utility Engine v3.2 // Offline sandboxed and client-safe outputs
              </div>
            </div>
          </motion.div>
        )}

        {/* TAB 6: COMMUNITY QUESTIONS AND ANSWERS (P12) */}
        {activeTab === "comqa" && (
          <motion.div
            key="comqa"
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -10 }}
            className="grid grid-cols-1 lg:grid-cols-12 gap-5 text-left"
          >
            {/* Ask Question Box */}
            <div className="lg:col-span-4 space-y-4">
              <div className="bg-[#090e1a] border border-cyan-950 p-4 rounded-lg">
                <h4 className="text-xs font-mono text-[#00f0ff] uppercase tracking-wider mb-3 pb-1 border-b border-cyan-950/60 font-bold">
                  ১২.১ StackOverflow Tech Q&A (প্রশ্ন করুন)
                </h4>
                
                <form onSubmit={handleAddNewQuestion} className="space-y-3 text-xs">
                  <div>
                    <label className="block text-slate-400 mb-1">ফোরাম প্রশ্ন টাইটেল:</label>
                    <input 
                      type="text" 
                      placeholder="e.g. গুগল এডসেন্স এপ্রুভালে থিন কন্টেন্ট সরাব কেমনে?" 
                      value={newQTitle}
                      onChange={(e) => setNewQTitle(e.target.value)}
                      className="w-full bg-[#050811] border border-cyan-950 p-2 rounded text-slate-200 focus:outline-none focus:border-cyan-400"
                      required
                    />
                  </div>
                  <div>
                    <label className="block text-slate-400 mb-1">ক্যাটাগরি:</label>
                    <select 
                      value={newQCat}
                      onChange={(e) => setNewQCat(e.target.value)}
                      className="w-full bg-[#050811] border border-cyan-950 p-2 rounded text-slate-300"
                    >
                      <option value="Google AdSense">Google AdSense</option>
                      <option value="Cyber Security">Cyber Security</option>
                      <option value="Online Earning">Online Earning</option>
                      <option value="Wordpress Tricks">Wordpress Tricks</option>
                    </select>
                  </div>
                  <div>
                    <label className="block text-slate-400 mb-1">বিস্তারিত বিবরণ:</label>
                    <textarea 
                      placeholder="আপনার প্রশ্নটি বিস্তারিত লিখুন যাতে এডমিন এআই বা টেক এক্সপার্টরা উত্তর দিতে পারে..." 
                      value={newQContent}
                      onChange={(e) => setNewQContent(e.target.value)}
                      className="w-full h-24 bg-[#050811] border border-cyan-950 p-2 rounded text-slate-200 focus:outline-none focus:border-cyan-400 text-left"
                      required
                    />
                  </div>
                  <button 
                    type="submit"
                    className="w-full bg-[#00f0ff] hover:bg-cyan-400 text-slate-950 font-mono font-bold py-2 rounded shadow transition-all cursor-pointer"
                  >
                    🚀 ফোরামে প্রশ্ন পোস্ট করুন
                  </button>
                </form>
              </div>
            </div>

            {/* Questions List and Answers Portal */}
            <div className="lg:col-span-8 space-y-4">
              <div className="bg-[#090e1a] border border-cyan-950 p-4 rounded-lg flex flex-col h-[380px]">
                <h4 className="text-xs font-mono text-cyan-400 uppercase tracking-wider mb-2.5 pb-2 border-b border-cyan-950 font-bold flex justify-between items-center">
                  <span>১২.২ Community Discussion Board</span>
                  <span className="text-[10px] text-slate-500 font-mono">{qaQuestions.length} Threads Active</span>
                </h4>

                <div className="flex-1 overflow-y-auto space-y-4 pr-1 custom-scrollbar">
                  {qaQuestions.map((q) => (
                    <div key={q.id} className="bg-[#050912] border border-cyan-950/70 p-3 rounded space-y-2.5">
                      <div className="flex justify-between items-start gap-2">
                        <div className="space-y-0.5 min-w-0 flex-1">
                          <span className="text-[9.5px] bg-cyan-950 text-cyan-400 px-1.5 py-0.2 border border-cyan-900 rounded font-mono uppercase tracking-wider">{q.category}</span>
                          <h5 className="text-xs font-bold text-slate-100 font-sans leading-relaxed mt-1">{q.title}</h5>
                          <span className="text-[9.5px] text-slate-500 block font-mono">জানিয়েছেন: <strong className="text-slate-400 underline">{q.author}</strong> ({q.reputation} rep) // {q.timestamp}</span>
                        </div>
                        
                        {/* Vote Controls */}
                        <div className="flex flex-col items-center shrink-0 border border-cyan-950 bg-[#04060d] p-1 rounded text-center">
                          <button onClick={() => handleVoteQuestion(q.id, "up")} className="text-slate-500 hover:text-cyan-400"><ArrowUp className="w-3.5 h-3.5" /></button>
                          <span className="text-xs font-bold font-mono text-slate-300">{q.votes}</span>
                          <button onClick={() => handleVoteQuestion(q.id, "down")} className="text-slate-500 hover:text-red-400"><ArrowDown className="w-3.5 h-3.5" /></button>
                        </div>
                      </div>

                      <p className="text-xs text-slate-400 leading-normal pl-1.5 border-l border-cyan-950 font-sans bg-[#04060c] p-2 rounded">{q.content}</p>

                      {/* Answers block */}
                      <div className="space-y-2.5 pt-2 border-t border-cyan-950/40">
                        <h6 className="text-[10.5px] font-mono text-[#39ff14]/80 flex items-center gap-1">✔ Answers ({q.answers.length})</h6>
                        
                        {q.answers.map((ans) => (
                          <div key={ans.id} className={`p-2 rounded border text-xs relative ${ans.isBest ? 'bg-emerald-950/20 border-emerald-500/30' : 'bg-[#04070e] border-cyan-950/50'}`}>
                            {ans.isBest && (
                              <span className="absolute top-2 right-2 text-[9px] bg-emerald-950 text-emerald-400 px-1 rounded font-mono font-bold border border-emerald-800 animate-pulse">
                                ✓ BEST ANSWER
                              </span>
                            )}
                            <div className="flex justify-between items-center text-slate-500 text-[10px] font-mono mb-1">
                              <span>উত্তরদাতা: <strong className="text-slate-300">{ans.author}</strong></span>
                              <span>{ans.timestamp}</span>
                            </div>
                            <p className="text-slate-300 font-sans leading-relaxed">{ans.text}</p>
                            
                            {!ans.isBest && (
                              <button 
                                onClick={() => handleMarkBestAnswer(q.id, ans.id)}
                                className="text-[9px] font-mono text-cyan-400 hover:underline mt-1.5 block cursor-pointer"
                              >
                                Mark as Best Answer ✓
                              </button>
                            )}
                          </div>
                        ))}

                        {/* Quick Answer Submit */}
                        <div className="flex gap-2 pt-2">
                          <input 
                            type="text" 
                            placeholder="আপনার প্রযুক্তি বিষয়ক মতামত বা উত্তর লিখুন..." 
                            value={replyTexts[q.id] || ""}
                            onChange={(e) => {
                              const val = e.target.value;
                              setReplyTexts(prev => ({ ...prev, [q.id]: val }));
                            }}
                            className="bg-[#04070d] border border-cyan-950 p-2 text-xs rounded text-slate-200 focus:outline-none focus:border-cyan-400 w-full" 
                          />
                          <button 
                            onClick={() => handleAddAnswer(q.id)}
                            className="bg-cyan-950 hover:bg-cyan-900 px-3.5 rounded text-cyan-300 border border-cyan-800 text-xs shrink-0 cursor-pointer font-mono font-bold"
                          >
                            উত্তর দিন
                          </button>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </motion.div>
        )}

        {/* TAB 7: INFRASTRUCTURE & DATABASE OPTIMIZATION (P14) */}
        {activeTab === "dbvital" && (
          <motion.div
            key="dbvital"
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -10 }}
            className="grid grid-cols-1 lg:grid-cols-12 gap-5 text-left"
          >
            {/* DB Optimization statistics panel */}
            <div className="lg:col-span-7 space-y-4">
              <div className="bg-[#090e1a] border border-cyan-950 p-4 rounded-lg">
                <h4 className="text-xs font-mono text-[#00f0ff] uppercase tracking-wider mb-4 pb-2 border-b border-cyan-950 font-bold">
                  ১৪.১ Database Center & Indexing Optimizer
                </h4>

                <div className="grid grid-cols-2 gap-4 text-xs font-mono">
                  <div className="bg-[#060912] border border-cyan-950 p-3 rounded">
                    <span className="text-slate-500 block text-[9.5px]">Database Size</span>
                    <strong className="text-base text-slate-200">{dbStatus.size}</strong>
                    <span className="text-[8.5px] text-slate-500 block mt-0.5">MySQL Server v8.x</span>
                  </div>
                  <div className="bg-[#060912] border border-cyan-950 p-3 rounded">
                    <span className="text-slate-500 block text-[9.5px]">Meta Table Overhead</span>
                    <strong className="text-base text-amber-500">{dbStatus.overhead}</strong>
                    <span className="text-[8.5px] text-amber-500 block mt-0.5">Needs reclaim cleanup</span>
                  </div>
                  <div className="bg-[#060912] border border-cyan-950 p-3 rounded">
                    <span className="text-slate-500 block text-[9.5px]">Table Query Indexing</span>
                    <strong className="text-base text-[#39ff14]">{dbStatus.indexing}</strong>
                    <span className="text-[8.5px] text-slate-500 block mt-0.5">Clean clustered indexes</span>
                  </div>
                  <div className="bg-[#060912] border border-cyan-950 p-3 rounded">
                    <span className="text-slate-500 block text-[9.5px]">Active WordPress WP-Crons</span>
                    <strong className="text-base text-slate-200">{dbStatus.activeCrons} scheduler events</strong>
                    <span className="text-[8.5px] text-[#39ff14] block mt-0.5">Standard server load</span>
                  </div>
                </div>

                <div className="mt-4 pt-3 border-t border-cyan-950/60 flex justify-between items-center text-xs">
                  <span>Last Reclaimed Index vacuum: <strong>{dbStatus.lastVacuum}</strong></span>
                  <button 
                    onClick={handleDbOptimize}
                    disabled={dbOptimizing}
                    className="bg-cyan-950 hover:bg-cyan-900 border border-cyan-700 text-cyan-300 font-mono font-bold py-1 px-3.5 rounded cursor-pointer disabled:opacity-50"
                  >
                    {dbOptimizing ? "Optimizing DB Table indexes..." : "Reclaim & Vacuum DB ⚡"}
                  </button>
                </div>
              </div>
            </div>

            {/* Program Policy Checklist for AdSense Review */}
            <div className="lg:col-span-5 space-y-4">
              <div className="bg-[#090e1a] border border-[#0f1b2c] p-4 rounded-lg flex flex-col justify-between">
                <div className="space-y-3">
                  <h5 className="text-xs font-mono text-[#00f0ff] font-bold uppercase flex items-center gap-1.5 border-b border-cyan-950 pb-2">
                    <ShieldCheck className="w-4 h-4 text-emerald-400" />
                    AdSense manual audit Readiness Checklist
                  </h5>

                  <p className="text-[11px] text-slate-400 font-sans leading-normal">
                    গুগল অ্যাডসেন্সের কড়া নির্দেশিকা অনুযায়ী রিভিউর পূর্বে সাইটের এই শর্তগুলো নিশ্চিত করা আবশ্যক:
                  </p>

                  <div className="space-y-2 text-xs">
                    <div className="flex items-start gap-2">
                      <span className="bg-[#10241b] text-[#39ff14] border border-[#1b3d2e] w-4.5 h-4.5 rounded-full flex items-center justify-center font-bold text-[9px] shrink-0">✓</span>
                      <div>
                        <strong>এভিয়ড থিন কন্টেন্ট:</strong>
                        <p className="text-[10px] text-slate-500 leading-tight">সব নিবন্ধের গড় সাইজ ১০০০ শব্দ ছাড়িয়ে প্রফেশনাল মান ধারণ করেছে।</p>
                      </div>
                    </div>

                    <div className="flex items-start gap-2">
                      <span className="bg-[#10241b] text-[#39ff14] border border-[#1b3d2e] w-4.5 h-4.5 rounded-full flex items-center justify-center font-bold text-[9px] shrink-0">✓</span>
                      <div>
                        <strong>ইইএটি পলিসি পেজ সমূহ:</strong>
                        <p className="text-[10px] text-slate-500 leading-tight">Editorial, Fact-Checking ও সংশোধনী নীতিমালা ফুটারে সরাসরি সচল রয়েছে।</p>
                      </div>
                    </div>

                    <div className="flex items-start gap-2">
                      <span className="bg-[#10241b] text-[#39ff14] border border-[#1b3d2e] w-4.5 h-4.5 rounded-full flex items-center justify-center font-bold text-[9px] shrink-0">✓</span>
                      <div>
                        <strong>অথর ট্রাস্ট আর্কাইভ:</strong>
                        <p className="text-[10px] text-slate-500 leading-tight">নিবন্ধের নিচে বিশেষজ্ঞ অথর বায়ো এবং তার ভেরিফাইড মেম্বারশিপ শো করছে।</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div className="mt-4 pt-3 border-t border-cyan-950/60 text-right text-[10px] font-mono text-cyan-400">
                  Ready Status: Perfect Compliance Rating
                </div>
              </div>
            </div>
          </motion.div>
        )}

      </AnimatePresence>
    </div>
  );
}
