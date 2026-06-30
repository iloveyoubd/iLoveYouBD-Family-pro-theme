import React, { useState, useEffect } from "react";
import { 
  Newspaper, 
  Search, 
  Calendar, 
  User, 
  Tag as TagIcon, 
  Share2, 
  MessageSquare, 
  Flame, 
  AlertCircle, 
  CheckCircle2, 
  Sparkles, 
  Clock, 
  X, 
  TrendingUp, 
  Award,
  ChevronRight,
  Database,
  Cpu,
  RefreshCw,
  Eye,
  Bookmark
} from "lucide-react";
import { motion, AnimatePresence } from "motion/react";

export interface NewsComment {
  id: string;
  author: string;
  avatar: string;
  content: string;
  time: string;
}

export interface NewsVersion {
  timestamp: string;
  title: string;
  content: string;
  reason: string;
  version: number;
}

export interface NewsPost {
  id: string;
  title: string;
  summary: string;
  content: string;
  image: string;
  category: string;
  tags: string[];
  reporter: string;
  publishTime: string;
  updatedTime: string;
  readTime: number;
  views: number;
  comments: NewsComment[];
  isEditorsPick?: boolean;
  isTrending?: boolean;
  isBreaking?: boolean;
  sourceAttribution?: string;
  sourceName?: string;
  verificationScore?: number;
  
  // Enterprise 2.0 specs
  qualityScore?: number;
  qualityBreakdown?: {
    source: number;
    readability: number;
    linking: number;
    seo: number;
  };
  versionHistory?: NewsVersion[];
  clusterId?: string;
  clusterUpdates?: { timestamp: string; title: string; content: string }[];
  currentVersion?: number;
}

const CATEGORIES = [
  "Bangladesh",
  "International",
  "Technology",
  "AI",
  "Cyber Security",
  "Business",
  "Sports",
  "Entertainment",
  "Politics",
  "Science",
  "Health",
  "Education",
  "Lifestyle",
  "Environment",
  "Others"
];

// Initial pre-loaded premium futuristic articles
const INITIAL_NEWS: NewsPost[] = [
  {
    id: "news-1",
    title: "বাংলাদেশ সাইবার ক্রাইসিস রেসপন্স টিম দ্বারা ২0৪০ সালের নতুন গ্লোবাল ফায়ারওয়াল অ্যাক্টিভেশন",
    summary: "বাংলাদেশ সরকারের সাইবার টিম আন্তর্জাতিক থ্রেট ইন্টেলিজেন্সের সাথে মিলে পরবর্তী প্রজন্মের কোয়ান্টাম ফায়ারওয়াল নেটওয়ার্ক সক্রিয় করেছে যা ১০০% দেশীয় এআই নোড দ্বারা চালিত।",
    content: `গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের বিশেষ তথ্যপ্রযুক্তি বিভাগ এবং আন্তর্জাতিক সাইবার প্রতিরক্ষা এগ্রিমেন্টের সম্মিলিত উদ্যোগে দেশজুড়ে সক্রিয় করা হয়েছে 'আইবিডি নেক্সট-জেন কোয়ান্টাম ফায়ারওয়াল ২.০'। এটি সম্পূর্ণরূপে ১০০% দেশীয় এআই নোড এবং কোয়ান্টাম এনক্রিপশন প্রোটোকল দ্বারা পরিচালিত।

কর্তৃপক্ষ জানিয়েছে, এই নতুন সিস্টেমটি সেকেন্ডে প্রায় ৫ বিলিয়ন ক্ষতিকারক রিকোয়েস্ট বা ডিডস (DDoS) হামলা সনাক্ত এবং নিষ্ক্রিয় করতে সক্ষম। বিশেষ করে আর্থিক খাত ও সরকারি তথ্যভাণ্ডার সুরক্ষায় এটি এক যুগান্তকারী পদক্ষেপ।

প্রধান প্রযুক্তিবিদদের মতে, "এটি শুধুমাত্র একটি ফায়ারওয়াল নয়, এটি একটি লার্নিং ব্রেইন যা প্রতি সেকেন্ডে নতুন থ্রেট প্যাটার্নগুলো শিখে নিজেকে আপডেট করে।" গ্লোবাল সিকিউরিটি ইনডেক্সে বাংলাদেশের অবস্থান এই উদ্যোগের পর আরও ১২ ধাপ এগিয়ে যাবে বলে আশা করা হচ্ছে।`,
    image: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=80",
    category: "Cyber Security",
    tags: ["CyberDefense", "QuantumSafety", "BangladeshTech", "AI_Security"],
    reporter: "তারেক রহমান, সিনিয়র সাইবার রিপোর্টার",
    publishTime: "2026-06-29T08:30:00",
    updatedTime: "2026-06-29T10:15:00",
    readTime: 3,
    views: 1240,
    isBreaking: true,
    isEditorsPick: true,
    isTrending: true,
    sourceAttribution: "https://cyberdefense.gov.bd",
    sourceName: "National Cyber Security Center",
    verificationScore: 98,
    comments: [
      { id: "c1", author: "সাইবার_লাভার", avatar: "🤖", content: "অসাধারণ নিউজ! এই কোয়ান্টাম সিকিউরিটি যুগের সাথে আমাদের এগিয়ে রাখবে।", time: "২ ঘণ্টা আগে" }
    ]
  },
  {
    id: "news-2",
    title: "সুপারকম্পিউটিং যুগে বাংলাদেশ: এআই-রিসার্চ হাবে নতুন সুপারক্লাস্টার উদ্বোধন",
    summary: "ঢাকার পূর্বাচল টেক-সিটিতে দেশের বৃহত্তম সুপারকম্পিউটিং রিসার্চ হাবের উদ্বোধন করা হয়েছে। আইবিডি এআই রিসার্চ ফাউন্ডেশন এই ক্লাস্টার স্থাপন করেছে।",
    content: `বাংলাদেশ সুপারকম্পিউটিং যুগে পদার্পণ করেছে। ঢাকার পূর্বাচল আইসিটি সিটিতে আনুষ্ঠানিকভাবে চালু হয়েছে বাংলাদেশের সবচেয়ে শক্তিশালী এআই রিসার্চ সুপারকম্পিউটার ক্লাস্টার 'আইবিডি মেটাব্রেইন-১'।

এটি দেশীয় উদ্যোগে তৈরি এবং স্থানীয় এআই নেটওয়ার্ক গবেষণার জন্য উন্মুক্ত রাখা হবে। গবেষকরা আশা করছেন এর মাধ্যমে বাংলা ল্যাঙ্গুয়েজ প্রসেসিং এবং আবহাওয়া পূর্বাভাসের মতো জটিল এআই মডেলগুলো সেকেন্ডে প্রসেস করা সম্ভব হবে。`,
    image: "https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80",
    category: "Technology",
    tags: ["Supercomputing", "MetaBrain", "ResearchHub", "DhakaTech"],
    reporter: "আহসান হাবিব, প্রযুক্তি বিশ্লেষক",
    publishTime: "2026-06-28T14:30:00",
    updatedTime: "2026-06-28T15:45:00",
    readTime: 3,
    views: 980,
    isEditorsPick: true,
    verificationScore: 97,
    comments: []
  },
  {
    id: "news-4",
    title: "আন্তর্জাতিক রোবটিক্স অলিম্পিয়াড ২0২৬: প্রথম স্থান অর্জন করলো বাংলাদেশী দল",
    summary: "বিশ্ব রোবটিক্স প্রতিযোগিতায় প্রথম বারের মতো স্বর্ণপদক জয় করেছে বাংলাদেশের তরুণ গবেষকদের তৈরি স্বায়ত্তশাসিত রেসকিউ রোবট 'দুরন্ত-৬'।",
    content: `সিঙ্গাপুরে অনুষ্ঠিত আন্তর্জাতিক রোবটিক্স অলিম্পিয়াড ২0২৬-এ বিশ্বের ৮০টি দেশকে পেছনে ফেলে শীর্ষস্থান দখল করেছে বাংলাদেশ দল। তরুণ বাংলাদেশী প্রকৌশলীদের দল 'টিম আইবিডি সায়েন্স' এর তৈরি স্বায়ত্তশাসিত উদ্ধারকারী রোবট 'দুরন্ত-৬' এই বিরল সম্মাননা এনে দিয়েছে।

দুরন্ত-৬ রোবটটি মূলত জটিল প্রাকৃতিক দুর্যোগ ও ধ্বংসস্তূপে প্রবেশ করে থার্মাল ইমেজিং এবং এআই রিয়েল-টাইম থ্রিডি ম্যাপিংয়ের মাধ্যমে অতি দ্রুত আটকে পড়া মানুষদের অবস্থান সনাক্ত করতে পারে।

পুরো অলিম্পিয়াড জুড়েই বিশ্ব টেক জায়ান্ট ও নাসা গবেষকরা এই প্রজেক্টের ভূয়সী প্রশংসা করেছেন এবং বেশ কয়েকটি আন্তর্জাতিক সংস্থা ইতিমধ্যেই দুরন্ত-৬ এর কমার্শিয়াল উৎপাদনের জন্য অফার দিয়েছে।`,
    image: "https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80",
    category: "International",
    tags: ["RoboticsOlympiad", "TeamBangladesh", "AI_Rescue", "Duronto6"],
    reporter: "নাফিসা বিনতে তৌহিদ, যুব ও বিজ্ঞান প্রতিনিধি",
    publishTime: "2026-06-26T11:00:00",
    updatedTime: "2026-06-26T12:30:00",
    readTime: 4,
    views: 2050,
    isTrending: true,
    verificationScore: 99,
    comments: []
  },
  {
    id: "news-5",
    title: "কোয়ান্টাম ক্লাউড ফিন্যান্সিং ও স্মার্ট এন্টারপ্রাইজ মনিটাইজেশনের ভবিষ্যৎ রূপরেখা",
    summary: "আধুনিক ডিজিটাল উদ্যোক্তাদের জন্য ব্যাংকিং খাতের বাইরে কোয়ান্টাম ক্লাউড ট্রাস্ট নেটওয়ার্ক ব্যবহারের খসড়া নীতিমালা তৈরি করেছে বাংলাদেশ ব্যাংক।",
    content: `ডিজিটাল ইকোনমির গতি বৃদ্ধিতে এবং ফ্রিল্যান্সার ও মাইক্রো-উদ্যোক্তাদের আন্তর্জাতিক পেমেন্ট জটলা কমাতে এক যুগান্তকারী পদক্ষেপ নিতে যাচ্ছে বাংলাদেশ ব্যাংক। কোয়ান্টাম ক্লাউড ট্রাস্ট নেটওয়ার্কের মাধ্যমে সরাসরি পিয়ার-টু-পিয়ার ফিন্যান্সিং অনুমোদন করার খসড়া রূপরেখা প্রকাশ করা হয়েছে।

নতুন এই ট্রাস্ট ফিন্যান্স মডেলে কোনো ঐতিহ্যবাহী থার্ড পার্টি ফি বা দীর্ঘস্থায়ী প্রসেসিং সময় থাকবে না। সম্পূর্ণ লেনদেন এআই স্মার্ট ডিস্ট্রিবিউটেড লেজার এবং নিরাপদ বায়োমেট্রিক আইডি দ্বারা ভেরিফাইড হবে।

এই সিস্টেম কার্যকর হলে বাংলাদেশ থেকে গ্লোবাল রেভিনিউ কালেকশন বা ই-কমার্স পেমেন্ট রিসিভ করার ক্ষেত্রে আর কোনো বাধা থাকবে না।`,
    image: "https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=1200&q=80",
    category: "Business",
    tags: ["SmartFinancing", "BangladeshBank", "PeerToPeer", "QuantumWeb"],
    reporter: "আবদুল্লাহ আল মামুন, ব্যাংকিং ও অর্থনীতি প্রতিবেদক",
    publishTime: "2026-06-25T16:45:00",
    updatedTime: "2026-06-25T18:00:00",
    readTime: 3,
    views: 1120,
    verificationScore: 96,
    comments: []
  }
];

interface NewsCenterProps {
  onBackToHome: () => void;
  homepageNewsConfig?: {
    enabled: boolean;
    showModule: boolean;
    displayType: string;
    displayCount: number;
    showThumbnail: boolean;
    showPublishTime: boolean;
    showCategory: boolean;
    showSummary: boolean;
    showReadMore: boolean;
    buttonText: string;
  };
}

export default function NewsCenter({ onBackToHome, homepageNewsConfig }: NewsCenterProps) {
  const [news, setNews] = useState<NewsPost[]>(() => {
    const saved = localStorage.getItem("ilybd_news_posts_db");
    const parsed = saved ? JSON.parse(saved) : INITIAL_NEWS;
    return parsed.map((item: any) => {
      const qScore = item.qualityScore || Math.floor(Math.random() * 12) + 88; // 88 to 99
      return {
        ...item,
        qualityScore: qScore,
        currentVersion: item.currentVersion || 1,
        qualityBreakdown: item.qualityBreakdown || {
          source: Math.floor(Math.random() * 10) + 90,
          readability: Math.floor(Math.random() * 8) + 92,
          linking: Math.floor(Math.random() * 15) + 85,
          seo: Math.floor(Math.random() * 8) + 93,
        },
        clusterId: item.clusterId || (item.category === "Cyber Security" ? "cluster-cyber-2040" : `cluster-random-${Math.floor(Math.random() * 100)}`),
        versionHistory: item.versionHistory || [
          {
            timestamp: item.publishTime,
            title: item.title,
            content: item.content,
            reason: "প্রথম খসড়া প্রকাশ (Initial AI Release)",
            version: 1
          }
        ]
      };
    });
  });

  const [selectedNewsId, setSelectedNewsId] = useState<string | null>(null);
  const [activeCategory, setActiveCategory] = useState<string>("All");
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedTag, setSelectedTag] = useState<string | null>(null);

  // Sovereignty & AI Config State (2040 Admin Tuning)
  const [minQualityThreshold, setMinQualityThreshold] = useState<number>(90);
  const [smartClustering, setSmartClustering] = useState<boolean>(true);
  const [autoRefreshEnabled, setAutoRefreshEnabled] = useState<boolean>(true);
  const [contentGatingOn, setContentGatingOn] = useState<boolean>(true);
  const [powerUserLevel, setPowerUserLevel] = useState<string>("Expert"); // Adaptable persona: Beginner, Professional, Expert
  const [loadedVersions, setLoadedVersions] = useState<Record<string, number>>({});
  
  // Simulated Pipeline state
  const [pipelineLogs, setPipelineLogs] = useState<string[]>([
    "🤖 Pipeline Standby: Waiting for news triggers...",
    "📡 Scheduled Source Crawlers Active [Trusted Partners Checked]"
  ]);
  const [isPipelineRunning, setIsPipelineRunning] = useState(false);
  
  // Comments input
  const [commentName, setCommentName] = useState("");
  const [commentText, setCommentText] = useState("");

  // Archive date state
  const [archiveDate, setArchiveDate] = useState("");

  useEffect(() => {
    localStorage.setItem("ilybd_news_posts_db", JSON.stringify(news));
  }, [news]);

  // Autopilot Daily Auto-Seeding Engine (2040 Intelligent Indexing)
  useEffect(() => {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const todayPrefix = `${year}-${month}-${day}`;

    // Check if there is any news article from today in our database
    const hasTodayNews = news.some(item => item.publishTime.startsWith(todayPrefix));

    if (!hasTodayNews) {
      const seededTodayNews: NewsPost[] = [
        {
          id: `today-news-1`,
          title: "আইবিডি সুপারক্লাস্টার-২: বাংলাদেশের প্রথম কোয়ান্টাম এআই ক্লাউড গ্রিড সফলভাবে চালু",
          summary: "সম্পূর্ণ দেশীয় প্রযুক্তিতে আইবিডি ফিনটেক ল্যাব ও তথ্যপ্রযুক্তি মন্ত্রণালয়ের যৌথ উদ্যোগে আজ সকালে দেশের দ্বিতীয় কোয়ান্টাম ক্লাউড সার্ভার গ্রিড সচল করা হয়েছে।",
          content: `বিজ্ঞান ও তথ্যপ্রযুক্তি খাতে বাংলাদেশ আরও এক ধাপ এগিয়ে গেল। ঢাকার কালিয়াকৈর হাই-টেক পার্কে আনুষ্ঠানিকভাবে চালু করা হয়েছে দেশের দ্বিতীয় এবং সবচেয়ে শক্তিশালী কোয়ান্টাম ক্লাউড গ্রিড 'আইবিডি সুপারক্লাস্টার-২'।\n\nআজ সকালে এক উচ্চপর্যায়ের ভার্চুয়াল মিটিংয়ে এই উদ্বোধন ঘোষণা করা হয়। এই গ্রিডটি সেকেন্ডে প্রায় ১০ কোয়াড্রিলিয়ন ডাটা প্রসেস করতে সক্ষম এবং এটি সম্পূর্ণ সুরক্ষিত বায়ো-মেট্রিক এনক্রিপশন নোড দ্বারা বেষ্টিত।\n\nপ্রকৌশলীরা জানিয়েছেন, এর মাধ্যমে দেশের রিয়েল-টাইম ট্রাফিক সিকিউরিটি, bank ট্রানজ্যাকশন লোড এবং আইবিডি কন্টেন্ট সেফটি গার্ড শতভাগ নিরবচ্ছিন্ন থাকবে। এটি গুগল অ্যাডসেন্স কমপ্লায়েন্ট ক্রলার ফিডের জন্য বিশেষ হাই-স্পিড অপ্টিমাইজেশন প্রদান করে।`,
          image: "https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80",
          category: "Technology",
          tags: ["QuantumGrid", "SuperCluster", "BangladeshTech", "Cloud2040"],
          reporter: "শাফিন আহমেদ, ক্লাউড আর্কিটেকচার প্রতিনিধি",
          publishTime: `${todayPrefix}T08:30:00`,
          updatedTime: `${todayPrefix}T09:15:00`,
          readTime: 3,
          views: 1450,
          isBreaking: true,
          isEditorsPick: true,
          isTrending: true,
          verificationScore: 99,
          comments: [],
          qualityScore: 99,
          qualityBreakdown: {
            source: 99,
            readability: 98,
            linking: 99,
            seo: 100
          },
          currentVersion: 1,
          versionHistory: [
            {
              timestamp: `${todayPrefix}T08:30:00`,
              title: "আইবিডি সুপারক্লাস্টার-২: বাংলাদেশের প্রথম কোয়ান্টাম এআই ক্লাউড গ্রিড সফলভাবে চালু",
              content: "বিজ্ঞান ও তথ্যপ্রযুক্তি খাতে বাংলাদেশ আরও এক ধাপ এগিয়ে গেল। ঢাকার কালিয়াকৈর হাই-টেক পার্কে আনুষ্ঠানিকভাবে চালু করা হয়েছে দেশের দ্বিতীয় এবং সবচেয়ে শক্তিশালী কোয়ান্টাম ক্লাউড গ্রিড 'আইবিডি সুপারক্লাস্টার-২'।",
              reason: "প্রথম খসড়া প্রকাশ (Autonomous AI Release)",
              version: 1
            }
          ]
        },
        {
          id: `today-news-2`,
          title: "জাতীয় গেটওয়েতে ট্রাফিক হাইজ্যাকিং প্রতিহত: আইবিডি ডিফেন্স নোড সক্রিয়",
          summary: "আজ দুপুরে আন্তর্জাতিক আন্ডারসি ক্যাবল গেটওয়েতে হ্যাকারদের একটি জটিল ট্রাফিক ডাইভারশন ও হাইজ্যাকিং স্ক্রিপ্ট সফলভাবে রুখে দিয়েছে আইবিডি সাইবার ডিফেন্স নোড পোর্টাল।",
          content: `বাংলাদেশের সাইবার স্পেসকে নিরাপদ রাখতে আবারও অভাবনীয় সাফল্য দেখিয়েছে আইবিডি এর স্বয়ংক্রিয় ডিফেন্স ক্লাস্টার। আজ দুপুরে আন্তর্জাতিক গেটওয়ে নোডগুলোতে হ্যাকারদের একটি সঙ্ঘবদ্ধ দল ক্ষতিকারক ট্রাফিক ডাইভারশন স্ক্রিপ্ট রান করার চেষ্টা করে, যার লক্ষ্য ছিল দেশের প্রধান নিউজ পোর্টালগুলো থেকে ট্রাফিক ডাইরেক্ট করা।\n\nআইবিডি থ্রেট ইন্টেলিজেন্স তাৎক্ষণিকভাবে বিষয়টি শনাক্ত করে এবং এর এআই-পাওয়ার্ড 'জিরো-ডে প্রোটেক্টর' সক্রিয় করে হ্যাকিং স্ক্রিপ্টটি নিষ্ক্রিয় করে দেয়।\n\nবাংলাদেশ সাইবার রেসপন্স টিম এই সফল ডিফেন্স অপারেশনের জন্য আইবিডি এআই নোডকে অভিনন্দন জানিয়েছে। এর ফলে কোনো সাইটের ভিজিটর ক্ষতিগ্রস্ত হয়নি এবং অ্যাডসেন্স ট্রাস্ট স্কোরে কোনো প্রভাব পড়েনি।`,
          image: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=80",
          category: "Cyber Security",
          tags: ["CyberDefense", "TrafficGuard", "SecurityNode", "ZeroDayBD"],
          reporter: "রিয়াদ হাসান, থ্রেট ইন্টেলিজেন্স বিশ্লেষক",
          publishTime: `${todayPrefix}T12:45:00`,
          updatedTime: `${todayPrefix}T13:00:00`,
          readTime: 4,
          views: 1890,
          isBreaking: false,
          isEditorsPick: false,
          isTrending: true,
          verificationScore: 97,
          comments: [],
          qualityScore: 97,
          qualityBreakdown: {
            source: 96,
            readability: 97,
            linking: 95,
            seo: 98
          },
          currentVersion: 1,
          versionHistory: [
            {
              timestamp: `${todayPrefix}T12:45:00`,
              title: "জাতীয় গেটওয়েতে ট্রাফিক হাইজ্যাকিং প্রতিহত: আইবিডি ডিফেন্স নোড সক্রিয়",
              content: "বাংলাদেশের সাইবার স্পেসকে নিরাপদ রাখতে আবারও অভাবনীয় সাফল্য দেখিয়েছে আইবিডি এর স্বয়ংক্রিয় ডিফেন্স ক্লাস্টার।",
              reason: "প্রথম খসড়া প্রকাশ (Autonomous AI Release)",
              version: 1
            }
          ]
        },
        {
          id: `today-news-3`,
          title: "বাংলা ল্যাঙ্গুয়েজ প্রসেসিংয়ে আইবিডি 'মায়া আল্ট্রা ৩.২' এর অভাবনীয় সাফল্য",
          summary: "বাংলা ভাষার জটিল বাক্য গঠন ও আবেগ বিশ্লেষণ করতে সক্ষম বিশ্বের সবচেয়ে অ্যাডভান্সড এআই মডেল 'মায়া ৩.২' আজ বিকেলে উন্মোচন করেছে আইবিডি রিসার্চ ল্যাব।",
          content: `কৃত্রিম বুদ্ধিমত্তা গবেষণায় নতুন মাইলফলক স্পর্শ করেছে বাংলাদেশ। আইবিডি এআই রিসার্চ ফাউন্ডেশনের প্রধান গবেষক দল আজ বিকেলে প্রকাশ করেছে বাংলা ল্যাঙ্গুয়েজ প্রসেসিং এআই মডেল 'মায়া আল্ট্রা ৩.২'।\n\nএই এআই মডেলটি বাংলা উপভাষা, প্রবাদ এবং প্রযুক্তিগত পরিভাষাগুলোর নিখুঁত অনুবাদ ও কন্টেন্ট বিশ্লেষণ করতে পারে ৯৯.৬% নির্ভুলতার সাথে। এটি ব্যবহারকারীকে একদম মানুষের মতো ন্যাচারাল বাংলা উত্তর দিতে সক্ষম।\n\nবিশেষজ্ঞরা মনে করছেন, মায়া ৩.২ আসার ফলে স্থানীয় কন্টেন্ট ক্রিয়েটররা খুব সহজেই গুগল অ্যাডসেন্স ও এসইও ফ্রেন্ডলি কন্টেন্ট তৈরি করতে পারবেন যা আন্তর্জাতিক বাজারে দেশের ভাবমূর্তি উজ্জ্বল করবে।`,
          image: "https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80",
          category: "AI",
          tags: ["MayaUltra", "NLP_Bangla", "AISafety", "FutureCode"],
          reporter: "তাসনিম জেরিন, এআই ল্যাঙ্গুয়েজ ল্যাব প্রধান",
          publishTime: `${todayPrefix}T16:15:00`,
          updatedTime: `${todayPrefix}T16:30:00`,
          readTime: 3,
          views: 940,
          isBreaking: false,
          isEditorsPick: true,
          isTrending: false,
          verificationScore: 98,
          comments: [],
          qualityScore: 98,
          qualityBreakdown: {
            source: 98,
            readability: 99,
            linking: 96,
            seo: 99
          },
          currentVersion: 1,
          versionHistory: [
            {
              timestamp: `${todayPrefix}T16:15:00`,
              title: "বাংলা ল্যাঙ্গুয়েজ প্রসেসিংয়ে আইবিডি 'মায়া আল্ট্রা ৩.২' এর অভাবনীয় সাফল্য",
              content: "কৃত্রিম বুদ্ধিমত্তা গবেষণায় নতুন মাইলফলক স্পর্শ করেছে বাংলাদেশ। আইবিডি এআই রিসার্চ ফাউন্ডেশনের প্রধান গবেষক দল আজ বিকেলে প্রকাশ করেছে বাংলা ল্যাঙ্গুয়েজ প্রসেসিং এআই মডেল 'মায়া আল্ট্রা ৩.২'।",
              reason: "প্রথম খসড়া প্রকাশ (Autonomous AI Release)",
              version: 1
            }
          ]
        }
      ];

      setNews(prev => {
        const filtered = prev.filter(item => !item.id.startsWith("today-news-"));
        return [...seededTodayNews, ...filtered];
      });

      setPipelineLogs(prev => [
        ...prev,
        `📡 [SYSTEM ACTIVE] Checked publish log index for ${todayPrefix}...`,
        "⚠️ [ALERT] 0 active posts detected for the current calendar day.",
        `🚀 [AUTOPILOT TRIGGERED] Auto-seeded 3 premium, SEO-optimized, AdSense-safe articles for today!`,
        "💡 [SUCCESS] Today's news index has been fully synchronized with IBD Hub."
      ]);
    }
  }, []);

  // Autonomous background schedule listener when Auto News Refresh is active
  useEffect(() => {
    if (!autoRefreshEnabled) return;

    // Run background autopilot scan and publish cycle every 120 seconds
    const timerId = setInterval(() => {
      setPipelineLogs(prev => [
        ...prev,
        `📡 [AUTOPILOT - ${new Date().toLocaleTimeString()}] Running periodic cyber scanning...`,
        "🔍 [AUTOPILOT] Bypassing duplicate event clusters to secure AdSense standing...",
        "⚡ [AUTOPILOT] Initializing deep content builder..."
      ]);
      runAIPipelineSimulation();
    }, 120000);

    return () => clearInterval(timerId);
  }, [autoRefreshEnabled, minQualityThreshold, smartClustering, powerUserLevel]);

  const runAIPipelineSimulation = () => {
    if (isPipelineRunning) return;
    setIsPipelineRunning(true);
    setPipelineLogs([]);

    // Determine random quality score
    const generatedQuality = Math.floor(Math.random() * 15) + 85; // 85 - 99%
    const isRejected = generatedQuality < minQualityThreshold;

    const baseSteps = [
      "📡 [STEP 1] Crawling Global tech feeds, TechCrunch, and government cyber alerts...",
      `🔍 [STEP 2] Context-Aware Engine configured for user level: [${powerUserLevel}]. Analyzing source quality...`,
      `🛡️ [STEP 3] Running Quality Check... [Generated Score: ${generatedQuality}% | Threshold: ${minQualityThreshold}%].`,
    ];

    let finalSteps: string[] = [];
    if (isRejected) {
      finalSteps = [
        ...baseSteps,
        `❌ [REJECTED] Quality Score (${generatedQuality}%) is below the requested Sovereignty Threshold (${minQualityThreshold}%).`,
        "⚠️ [ABORTED] Content rejected to protect SEO and prevent Google AdSense 'Thin Content' penalty!"
      ];
    } else {
      if (smartClustering) {
        finalSteps = [
          ...baseSteps,
          "✂️ [STEP 4] Running smart duplicate & overlap detection...",
          "🧬 [CLUSTER ALERT] Overlap with existing event cluster [cluster-cyber-2040] (86% similarity matches).",
          "🔄 [EVENT CLUSTERING] Instead of a duplicate article, appending live updates to original post 'বাংলাদেশ সাইবার ক্রাইসিস রেসপন্স টিম'...",
          `🚀 [STEP 5] Post successfully upgraded to Version V${(news.find(n => n.id === "news-1")?.currentVersion || 2) + 1} with live event stream!`
        ];
      } else {
        finalSteps = [
          ...baseSteps,
          "✂️ [STEP 4] Duplication check bypassed. Designing brand new post...",
          "📝 [STEP 5] Structuring original, value-driven Bengali & English content translations...",
          "🎨 [STEP 6] Generating SEO Optimized Headings, custom Tag sets, and rich structural schema.",
          `🚀 [STEP 7] Pipeline successfully generated New News Article with Quality Score: ${generatedQuality}%!`
        ];
      }
    }

    finalSteps.forEach((step, index) => {
      setTimeout(() => {
        setPipelineLogs(prev => [...prev, step]);
        if (index === finalSteps.length - 1) {
          setIsPipelineRunning(false);
          
          if (!isRejected) {
            if (smartClustering) {
              // Update existing news-1 with a new version
              setNews(prev => prev.map(item => {
                if (item.id === "news-1") {
                  const nextVer = (item.currentVersion || 2) + 1;
                  const newTimestamp = new Date().toISOString();
                  const additionalContent = `\n\n[লাইভ আপডেট - ${new Date().toLocaleTimeString()}]: গ্লোবাল ইন্টেলিজেন্স ফিড থেকে প্রাপ্ত নতুন তথ্যানুযায়ী, আইবিডি নেক্সট-জেন কোয়ান্টাম ফায়ারওয়ালের কার্যকারিতা নিশ্চিত করতে সাইবার প্রতিরক্ষা নোডগুলোতে স্বয়ংক্রিয় এআই সিকিউরিটি লেয়ার বুস্ট করা হয়েছে। এর মাধ্যমে ট্রাফিক এনক্রিপশন রেট আরও বৃদ্ধি পেয়ে ১০০% এ উন্নীত হয়েছে।`;
                  const newVerEntry = {
                    timestamp: newTimestamp,
                    title: item.title,
                    content: item.content + additionalContent,
                    reason: `রিয়েল-টাইম থ্রেট ইন্টেলিজেন্স আপডেট (Event Cluster Continuation Paragraph) - V${nextVer}`,
                    version: nextVer
                  };
                  return {
                    ...item,
                    content: item.content + additionalContent,
                    currentVersion: nextVer,
                    updatedTime: newTimestamp,
                    versionHistory: [...(item.versionHistory || []), newVerEntry]
                  };
                }
                return item;
              }));
            } else {
              // Generate standard new post
              const newArticle: NewsPost = {
                id: `news-${Date.now()}`,
                title: `আইবিডি সুপার ক্লাউড দ্বারা পরিচালিত ২0৪০ সালের নতুন সাইবার ফায়ারওয়াল টেকনোলজি`,
                summary: `আজ বাংলাদেশের আইবিডি কোয়ান্টাম রিসার্চ টিম গ্লোবাল ইন্টারনেট গেটওয়ের উপর এক অভূতপূর্ব এআই-এনক্রিপ্টেড প্রোটোকল প্রয়োগের ঘোষণা দিয়েছে যা ১০০% সাকসেস রেট দেয়।`,
                content: `আইবিডি রিসার্চ সেন্টারের তরুণ বিজ্ঞানীদের দল কোয়ান্টাম এনক্রিপশনের এক নতুন রেকর্ড গড়েছে। তারা এমন এক প্রোটোকল উদ্ভাবন করেছে যা যেকোনো ধরনের আধুনিক সাইবার অ্যাটাক নিমেষেই শনাক্ত ও ধ্বংস করতে সক্ষম।

এই প্রযুক্তিটি ব্যবহারের ফলে আইবিডি ইকোসিস্টেমের ব্যবহারকারীরা সর্বোচ্চ স্তরের ডাটা সিকিউরিটি উপভোগ করতে পারবেন। এই সিস্টেমটি অতি দ্রুত স্থানীয় বাংলা ভাষার কমান্ড বুঝতে পারে এবং ভয়েস কন্ভোল পরিবর্তনের সুযোগ দিবে।`,
                image: "https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80",
                category: "Cyber Security",
                tags: ["SecurityHub", "CloudData", "CyberNext", "Automation"],
                reporter: "এআই নিউজ অটো-জেন জিপিটি",
                publishTime: new Date().toISOString(),
                updatedTime: new Date().toISOString(),
                readTime: 3,
                views: 120,
                verificationScore: generatedQuality,
                comments: [],
                qualityScore: generatedQuality,
                qualityBreakdown: {
                  source: generatedQuality,
                  readability: Math.floor(Math.random() * 5) + 93,
                  linking: Math.floor(Math.random() * 10) + 88,
                  seo: Math.floor(Math.random() * 5) + 95,
                },
                currentVersion: 1,
                versionHistory: [
                  {
                    timestamp: new Date().toISOString(),
                    title: `আইবিডি সুপার ক্লাউড দ্বারা পরিচালিত ২0৪০ সালের নতুন সাইবার ফায়ারওয়াল টেকনোলজি`,
                    content: `আইবিডি রিসার্চ সেন্টারের তরুণ বিজ্ঞানীদের দল কোয়ান্টাম এনক্রিপশনের এক নতুন রেকর্ড গড়েছে। তারা এমন এক প্রোটোকল উদ্ভাবন করেছে যা যেকোনো ধরনের আধুনিক সাইবার অ্যাটাক নিমেষেই শনাক্ত ও ধ্বংস করতে সক্ষম।`,
                    reason: "প্রথম খসড়া প্রকাশ (Initial Release)",
                    version: 1
                  }
                ]
              };
              setNews(prev => [newArticle, ...prev]);
            }
          }
        }
      }, (index + 1) * 700);
    });
  };

  const handleAddComment = (e: React.FormEvent) => {
    e.preventDefault();
    if (!commentName.trim() || !commentText.trim() || !selectedNewsId) return;

    setNews(prev => prev.map(item => {
      if (item.id === selectedNewsId) {
        return {
          ...item,
          comments: [
            ...item.comments,
            {
              id: `c-${Date.now()}`,
              author: commentName,
              avatar: "👤",
              content: commentText,
              time: "এইমাত্র"
            }
          ]
        };
      }
      return item;
    }));

    setCommentName("");
    setCommentText("");
  };

  const selectedPost = news.find(p => p.id === selectedNewsId);
  const currentPostVersion = selectedNewsId ? (loadedVersions[selectedNewsId] || selectedPost?.currentVersion || 1) : 1;
  const historicalVersion = selectedPost?.versionHistory?.find(v => v.version === currentPostVersion);

  const displayTitle = historicalVersion?.title || selectedPost?.title || "";
  const displayContent = historicalVersion?.content || selectedPost?.content || "";

  // Filter logic
  const filteredNews = news.filter(item => {
    if (activeCategory !== "All" && item.category !== activeCategory) return false;
    if (selectedTag && !item.tags.includes(selectedTag)) return false;
    if (archiveDate) {
      const itemDate = item.publishTime.split("T")[0];
      if (itemDate !== archiveDate) return false;
    }
    if (searchQuery) {
      const q = searchQuery.toLowerCase();
      return (
        item.title.toLowerCase().includes(q) ||
        item.summary.toLowerCase().includes(q) ||
        item.content.toLowerCase().includes(q)
      );
    }
    return true;
  });

  const breakingNews = news.filter(p => p.isBreaking);
  const trendingNews = news.filter(p => p.isTrending);
  const editorsPicks = news.filter(p => p.isEditorsPick);

  return (
    <div className="min-height-screen bg-[#070b13] text-slate-100 font-sans pb-24">
      {/* HEADER SECTION */}
      <div className="border-b border-slate-800/60 bg-[#0d1527]/90 sticky top-0 z-30 backdrop-blur-md">
        <div className="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
          <div className="flex items-center gap-3">
            <div className="bg-gradient-to-tr from-cyan-500 to-indigo-600 p-2.5 rounded-xl shadow-[0_0_15px_rgba(6,182,212,0.35)] border border-cyan-400/30">
              <Newspaper className="w-6 h-6 text-cyan-200" />
            </div>
            <div>
              <div className="flex items-center gap-2">
                <h1 className="text-xl font-black tracking-tight text-white font-sans">
                  IBD <span className="text-[#00f0ff] font-mono">NEWS CENTER</span>
                </h1>
                <span className="text-[9px] bg-cyan-950 text-cyan-400 font-mono px-2 py-0.5 rounded-full border border-cyan-500/30">
                  AI_PORTAL_V2.0
                </span>
              </div>
              <p className="text-[10px] text-slate-400 font-mono tracking-wider">SECURE AD-COMPLIANT DIGITAL FEED</p>
            </div>
          </div>

          <div className="flex items-center gap-2">
            <button 
              onClick={onBackToHome}
              className="text-xs font-bold font-mono px-4 py-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-cyan-500 transition-all cursor-pointer"
            >
              ⬅ BACK TO PORTAL
            </button>
          </div>
        </div>
      </div>

      <div className="max-w-7xl mx-auto px-4 mt-6">
        {/* BREAKING NEWS TICKER */}
        <div className="bg-red-950/20 border border-red-500/25 rounded-xl p-3 flex items-center gap-3 overflow-hidden shadow-[0_0_15px_rgba(239,68,68,0.05)]">
          <div className="bg-red-600 text-white font-bold font-mono text-[10px] uppercase px-2.5 py-1 rounded-md tracking-wider shadow-[0_0_10px_rgba(220,38,38,0.4)] animate-pulse shrink-0">
            🔴 Breaking News
          </div>
          <div className="relative flex-1 overflow-hidden h-5">
            <div className="absolute whitespace-nowrap animate-marquee flex items-center gap-8 text-xs font-semibold text-slate-200 hover:pause">
              {breakingNews.length > 0 ? (
                breakingNews.map((n, i) => (
                  <span key={i} className="cursor-pointer hover:text-cyan-400" onClick={() => setSelectedNewsId(n.id)}>
                    {n.title} • <span className="text-red-400 font-mono text-[10px]">{new Date(n.publishTime).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                  </span>
                ))
              ) : (
                <span className="text-slate-400 font-mono">আইবিডি এআই নিউজ পাইপলাইন ২৪/৭ সক্রিয় রয়েছে • রিয়েল-টাইম কন্টেন্ট ডি-ডুপ্লিকেশন চেক সাকসেসফুল</span>
              )}
            </div>
          </div>
        </div>

        {/* GOOGLE ADSENSE SPACING ZONE */}
        <div className="mt-6 mb-6 p-4 rounded-xl bg-[#0d1527]/40 border border-dashed border-cyan-500/20 text-center flex flex-col items-center justify-center gap-1 select-none">
          <span className="text-[10px] font-mono tracking-wider text-slate-400 font-bold">SPONSOR AD CONTAINER (GOOGLE ADSENSE SAFE PORTAL)</span>
          <p className="text-[9px] text-slate-500 font-mono">Separated by 20px+ from navigation and inputs to ensure perfect policy friendship</p>
        </div>

        {!selectedNewsId ? (
          /* NEWS INDEX VIEW */
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-6">
            
            {/* LEFT MAIN COL (NEWS GRID) */}
            <div className="lg:col-span-8 flex flex-col gap-6">
              
              {/* SEARCH & CALENDAR FILTER BAR */}
              <div className="bg-[#0d1527]/55 border border-slate-800/80 p-4 rounded-2xl flex flex-col sm:flex-row gap-3 items-center">
                <div className="relative w-full">
                  <Search className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                  <input 
                    type="text" 
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    placeholder="অনুসন্ধান করুন (Search news by keyword, reporter)..."
                    className="w-full bg-[#070b13] border border-slate-800 focus:border-cyan-500/50 rounded-xl pl-10 pr-4 py-2.5 text-xs text-white placeholder-slate-500 focus:outline-none transition-all"
                  />
                  {searchQuery && (
                    <button onClick={() => setSearchQuery("")} className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white">
                      <X className="w-4 h-4" />
                    </button>
                  )}
                </div>

                <div className="flex items-center gap-2 w-full sm:w-auto shrink-0">
                  <Calendar className="w-4 h-4 text-cyan-400" />
                  <input 
                    type="date" 
                    value={archiveDate}
                    onChange={(e) => setArchiveDate(e.target.value)}
                    className="bg-[#070b13] border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-300 focus:outline-none focus:border-cyan-500/50"
                  />
                  {archiveDate && (
                    <button onClick={() => setArchiveDate("")} className="text-[10px] font-mono bg-red-950/40 text-red-400 px-2 py-1 rounded border border-red-500/20">
                      CLEAR
                    </button>
                  )}
                </div>
              </div>

              {/* QUICK CATEGORIES BAR */}
              <div className="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                <button
                  onClick={() => { setActiveCategory("All"); setSelectedTag(null); }}
                  className={`text-xs font-bold font-mono px-4 py-2 rounded-xl border shrink-0 transition-all cursor-pointer ${activeCategory === "All" ? "bg-cyan-500/10 text-[#00f0ff] border-cyan-500/30 shadow-[0_0_15px_rgba(6,182,212,0.15)]" : "bg-slate-900 border-slate-800/80 text-slate-400 hover:text-white"}`}
                >
                  ⚡ All News
                </button>
                {CATEGORIES.map((cat, i) => (
                  <button
                    key={i}
                    onClick={() => { setActiveCategory(cat); setSelectedTag(null); }}
                    className={`text-xs font-bold font-mono px-4 py-2 rounded-xl border shrink-0 transition-all cursor-pointer ${activeCategory === cat ? "bg-cyan-500/10 text-[#00f0ff] border-cyan-500/30 shadow-[0_0_15px_rgba(6,182,212,0.15)]" : "bg-slate-900 border-slate-800/80 text-slate-400 hover:text-white"}`}
                  >
                    {cat}
                  </button>
                ))}
              </div>

              {/* FILTERING HEADER */}
              {(selectedTag || activeCategory !== "All" || archiveDate) && (
                <div className="flex items-center gap-2 bg-slate-900/40 border border-slate-800 p-3 rounded-xl text-xs">
                  <span className="text-slate-400 font-mono">Active Filter:</span>
                  {activeCategory !== "All" && (
                    <span className="bg-cyan-950 text-cyan-400 px-2 py-0.5 rounded border border-cyan-500/20">{activeCategory}</span>
                  )}
                  {selectedTag && (
                    <span className="bg-indigo-950 text-indigo-400 px-2 py-0.5 rounded border border-indigo-500/20">#{selectedTag}</span>
                  )}
                  {archiveDate && (
                    <span className="bg-amber-950 text-amber-400 px-2 py-0.5 rounded border border-amber-500/20">{archiveDate}</span>
                  )}
                  <button 
                    onClick={() => { setActiveCategory("All"); setSelectedTag(null); setArchiveDate(""); }}
                    className="ml-auto text-xs font-bold text-red-400 hover:text-white transition-all font-mono"
                  >
                    RESET ALL
                  </button>
                </div>
              )}

              {/* NEWS LIST CARDS (Bento Grid Style) */}
              <div className="flex flex-col gap-5">
                {filteredNews.length > 0 ? (
                  filteredNews.map((item) => (
                    <div 
                      key={item.id}
                      onClick={() => setSelectedNewsId(item.id)}
                      className="group bg-[#0d1527]/40 border border-slate-800/80 rounded-2xl p-5 hover:border-cyan-500/30 transition-all duration-300 cursor-pointer flex flex-col md:flex-row gap-5 relative overflow-hidden"
                    >
                      {/* Hover subtle grid effect */}
                      <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(0,240,255,0.02),transparent)] pointer-events-none"></div>

                      <div className="w-full md:w-56 shrink-0 aspect-[16/10] rounded-xl overflow-hidden bg-slate-950 border border-slate-800 relative">
                        <img 
                          src={item.image} 
                          alt={item.title} 
                          referrerPolicy="no-referrer"
                          className="w-full h-full object-fit-cover group-hover:scale-105 transition-transform duration-500" 
                          loading="lazy"
                        />
                        <div className="absolute top-2 left-2 bg-[#070b13]/85 text-[#00f0ff] font-mono text-[9px] px-2 py-0.5 rounded-md border border-cyan-500/20 uppercase">
                          {item.category}
                        </div>
                      </div>

                      <div className="flex flex-col justify-between flex-1">
                        <div>
                          <div className="flex items-center gap-3 text-[10px] text-slate-400 font-mono mb-2">
                            <span className="flex items-center gap-1"><Clock className="w-3 h-3 text-cyan-400" /> {new Date(item.publishTime).toLocaleDateString()}</span>
                            <span>•</span>
                            <span>⏱ {item.readTime} Min Read</span>
                            <span>•</span>
                            <span className="text-[#00ff66] font-semibold bg-[#00ff66]/5 px-2 py-0.5 rounded border border-[#00ff66]/10">✓ VERIFIED BY IBD AI</span>
                          </div>

                          <h3 className="text-sm font-bold text-white group-hover:text-[#00f0ff] transition-colors leading-snug mb-2 font-sans">
                            {item.title}
                          </h3>

                          <p className="text-xs text-slate-400 line-clamp-2 leading-relaxed">
                            {item.summary}
                          </p>
                        </div>

                        <div className="flex items-center justify-between border-t border-slate-800/40 pt-4 mt-4 text-[10px]">
                          <span className="text-slate-500 font-mono">{item.reporter}</span>
                          <span className="text-[#00f0ff] font-bold font-mono flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            সম্পূর্ণ খবর ➡
                          </span>
                        </div>
                      </div>
                    </div>
                  ))
                ) : (
                  <div className="text-center py-16 bg-slate-900/20 border border-dashed border-slate-800 rounded-2xl">
                    <div className="text-4xl mb-3">🔍</div>
                    <p className="text-sm font-bold text-slate-300">কোনো খবর পাওয়া যায়নি!</p>
                    <p className="text-xs text-slate-500 mt-1">অনুগ্রহ করে ভিন্ন কোনো কীওয়ার্ড ব্যবহার করে অনুসন্ধান করুন।</p>
                  </div>
                )}
              </div>
            </div>

            {/* RIGHT SIDEBAR PANEL */}
            <div className="lg:col-span-4 flex flex-col gap-6">

              {/* AI SOVEREIGNTY TUNING PANEL (Next-Gen Admin Dashboard) */}
              <div className="bg-[#0d1527]/75 border border-cyan-500/20 rounded-2xl p-5 relative overflow-hidden shadow-[0_0_20px_rgba(6,182,212,0.05)]">
                <div className="absolute top-0 right-0 w-32 h-32 bg-cyan-500/5 filter blur-3xl rounded-full"></div>
                <div className="absolute -bottom-10 -left-10 w-24 h-24 bg-indigo-500/5 filter blur-2xl rounded-full"></div>
                
                <h3 className="text-xs font-bold text-white font-mono tracking-wider flex items-center gap-2 border-b border-slate-800/80 pb-3 mb-4 uppercase">
                  <Database className="w-4 h-4 text-[#00f0ff]" /> এআই সভারেনটি কন্ট্রোল (Sovereignty Dashboard)
                </h3>

                <div className="space-y-4">
                  {/* Adaptive Persona */}
                  <div>
                    <label className="text-[10px] text-slate-400 font-mono tracking-wide uppercase flex justify-between mb-1">
                      <span>Adaptive AI Persona</span>
                      <span className="text-[#00f0ff] font-bold">{powerUserLevel}</span>
                    </label>
                    <div className="grid grid-cols-3 gap-1 bg-[#070b13] p-1 rounded-lg border border-slate-800">
                      {["Beginner", "Professional", "Expert"].map((level) => (
                        <button
                          key={level}
                          type="button"
                          onClick={() => setPowerUserLevel(level)}
                          className={`text-[9px] font-mono font-bold py-1 px-1.5 rounded-md transition-all cursor-pointer ${
                            powerUserLevel === level
                              ? "bg-cyan-500 text-[#070b13] shadow-sm font-black"
                              : "text-slate-400 hover:text-white"
                          }`}
                        >
                          {level}
                        </button>
                      ))}
                    </div>
                  </div>

                  {/* Quality Gate Slider */}
                  <div>
                    <div className="flex justify-between items-center text-[10px] text-slate-400 font-mono tracking-wide mb-1 uppercase">
                      <span>Quality Score Gate</span>
                      <span className="text-cyan-400 font-bold">{minQualityThreshold}% Min</span>
                    </div>
                    <input
                      type="range"
                      min="80"
                      max="98"
                      value={minQualityThreshold}
                      onChange={(e) => setMinQualityThreshold(parseInt(e.target.value))}
                      className="w-full accent-[#00f0ff] cursor-pointer h-1 bg-slate-800 rounded-lg appearance-none"
                    />
                    <p className="text-[8px] text-slate-500 font-mono mt-1 leading-normal">
                      Below this score, drafts are auto-rejected to prevent Google AdSense "Thin Content" penalties.
                    </p>
                  </div>

                  {/* Toggles */}
                  <div className="space-y-2.5 pt-3 border-t border-slate-800/60">
                    <label className="flex items-center justify-between cursor-pointer group">
                      <div className="flex flex-col">
                        <span className="text-[10px] font-bold text-slate-200 font-sans group-hover:text-white transition-colors">Event Clustering Engine</span>
                        <span className="text-[8px] text-slate-500 font-mono">Merges related updates safely</span>
                      </div>
                      <input
                        type="checkbox"
                        checked={smartClustering}
                        onChange={(e) => setSmartClustering(e.target.checked)}
                        className="rounded bg-slate-900 border-slate-800 text-cyan-500 focus:ring-0 cursor-pointer h-3.5 w-3.5"
                      />
                    </label>

                    <label className="flex items-center justify-between cursor-pointer group">
                      <div className="flex flex-col">
                        <span className="text-[10px] font-bold text-slate-200 font-sans group-hover:text-white transition-colors">Auto News Refresh</span>
                        <span className="text-[8px] text-slate-500 font-mono">Syncs real-time API additions</span>
                      </div>
                      <input
                        type="checkbox"
                        checked={autoRefreshEnabled}
                        onChange={(e) => setAutoRefreshEnabled(e.target.checked)}
                        className="rounded bg-slate-900 border-slate-800 text-cyan-500 focus:ring-0 cursor-pointer h-3.5 w-3.5"
                      />
                    </label>

                    <label className="flex items-center justify-between cursor-pointer group">
                      <div className="flex flex-col">
                        <span className="text-[10px] font-bold text-slate-200 font-sans group-hover:text-white transition-colors">Smart Content Gate</span>
                        <span className="text-[8px] text-slate-500 font-mono">Bypasses search crawlers for SEO</span>
                      </div>
                      <input
                        type="checkbox"
                        checked={contentGatingOn}
                        onChange={(e) => setContentGatingOn(e.target.checked)}
                        className="rounded bg-slate-900 border-slate-800 text-cyan-500 focus:ring-0 cursor-pointer h-3.5 w-3.5"
                      />
                    </label>
                  </div>
                </div>
              </div>
              
              {/* AI PIPELINE CONTROLLER BOX (Cyber style) */}
              <div className="bg-[#0d1527]/55 border border-slate-800/80 rounded-2xl p-5 relative overflow-hidden">
                <div className="absolute top-0 right-0 w-24 h-24 bg-cyan-500/5 filter blur-xl rounded-full"></div>
                
                <h3 className="text-xs font-bold text-white font-mono tracking-wider flex items-center gap-2 border-b border-slate-800 pb-3 mb-4 uppercase">
                  <Cpu className="w-4 h-4 text-cyan-400" /> IBD AI NEWS PIPELINE
                </h3>

                <p className="text-xs text-slate-400 leading-relaxed mb-4">
                  রিয়েল-টাইম এআই নিউজ প্রোটোকল সিমুলেটর। ক্লিক করে ট্রাস্টেড এপিআই স্ক্যানিং, কন্টেন্ট মার্জিং এবং ডুপ্লিকেট রিমুভাল চেক সচল করুন।
                </p>

                <button
                  onClick={runAIPipelineSimulation}
                  disabled={isPipelineRunning}
                  className="w-full bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 disabled:from-slate-800 disabled:to-slate-800 text-white font-bold font-mono text-xs py-2.5 px-4 rounded-xl shadow-lg shadow-cyan-500/10 border border-cyan-400/30 flex items-center justify-center gap-2 cursor-pointer transition-all"
                >
                  {isPipelineRunning ? (
                    <>
                      <RefreshCw className="w-3.5 h-3.5 animate-spin text-cyan-200" /> PIPELINE ACTIVE...
                    </>
                  ) : (
                    <>
                      <Sparkles className="w-3.5 h-3.5 text-cyan-200" /> RUN AI GENERATION
                    </>
                  )}
                </button>

                {/* Pipeline logs stream */}
                <div className="mt-4 bg-[#070b13] border border-slate-800/80 rounded-xl p-3 h-40 overflow-y-auto font-mono text-[9px] text-slate-400 flex flex-col gap-2">
                  {pipelineLogs.map((log, index) => (
                    <div key={index} className={log.includes("Quality Score") ? "text-emerald-400" : log.includes("Error") ? "text-red-400" : ""}>
                      {log}
                    </div>
                  ))}
                </div>
              </div>

              {/* EDITOR'S PICKS */}
              <div className="bg-[#0d1527]/40 border border-slate-800/80 rounded-2xl p-5">
                <h3 className="text-xs font-bold text-white font-mono tracking-wider flex items-center gap-2 border-b border-slate-800 pb-3 mb-4 uppercase">
                  <Award className="w-4 h-4 text-indigo-400" /> EDITOR'S PICKS (সেরা খবর)
                </h3>
                <div className="flex flex-col gap-3">
                  {editorsPicks.slice(0, 4).map(item => (
                    <div 
                      key={item.id}
                      onClick={() => setSelectedNewsId(item.id)}
                      className="group cursor-pointer border-b border-slate-800/50 pb-3 last:border-0 last:pb-0"
                    >
                      <span className="text-[9px] font-mono text-cyan-400 bg-cyan-950 px-1.5 py-0.5 rounded border border-cyan-500/15">{item.category}</span>
                      <h4 className="text-xs font-bold text-slate-200 group-hover:text-cyan-400 transition-colors mt-2 leading-snug">
                        {item.title}
                      </h4>
                    </div>
                  ))}
                </div>
              </div>

              {/* TRENDING / MOST READ MODULE */}
              <div className="bg-[#0d1527]/40 border border-slate-800/80 rounded-2xl p-5">
                <h3 className="text-xs font-bold text-white font-mono tracking-wider flex items-center gap-2 border-b border-slate-800 pb-3 mb-4 uppercase">
                  <TrendingUp className="w-4 h-4 text-emerald-400" /> MOST READ (জনপ্রিয় খবর)
                </h3>
                <div className="flex flex-col gap-4">
                  {trendingNews.slice(0, 5).map((item, idx) => (
                    <div 
                      key={item.id}
                      onClick={() => setSelectedNewsId(item.id)}
                      className="flex gap-3 items-start cursor-pointer group"
                    >
                      <div className="text-sm font-bold font-mono text-cyan-500/45 group-hover:text-cyan-400 shrink-0 min-w-4">
                        #{idx + 1}
                      </div>
                      <h4 className="text-xs font-semibold text-slate-300 group-hover:text-[#00f0ff] transition-colors leading-snug">
                        {item.title}
                      </h4>
                    </div>
                  ))}
                </div>
              </div>

              {/* ADSENSE SIDEBAR BANNER SPACING */}
              {homepageNewsConfig?.showModule !== false && (
                <div className="p-4 rounded-xl bg-[#0d1527]/40 border border-dashed border-cyan-500/15 text-center flex flex-col gap-1.5 py-6 select-none">
                  <span className="text-[9px] font-mono tracking-wider text-[#00f0ff] font-bold">PROMOTED AD SPACE</span>
                  <p className="text-[8px] text-slate-500 font-mono">AD-ZONE 300x250 • Policy Complaint Layout</p>
                </div>
              )}

            </div>
          </div>
        ) : (
          /* DETAILED NEWS VIEW */
          <div className="max-w-4xl mx-auto mt-6 bg-[#0d1527]/45 border border-slate-800/80 rounded-2xl p-6 sm:p-8 relative">
            <button 
              onClick={() => setSelectedNewsId(null)}
              className="absolute -top-3 -right-3 p-2 bg-slate-900 border border-slate-800 hover:border-cyan-500 text-slate-400 hover:text-white rounded-full transition-all cursor-pointer shadow-lg"
            >
              <X className="w-4 h-4" />
            </button>

            {/* Post meta details */}
            <div className="flex flex-wrap items-center gap-3 text-xs font-mono text-slate-400 mb-4">
              <span className="bg-cyan-950 text-[#00f0ff] border border-cyan-500/20 px-2 py-0.5 rounded-md uppercase font-bold text-[10px]">
                {selectedPost?.category}
              </span>
              <span>•</span>
              <span className="flex items-center gap-1"><Clock className="w-3.5 h-3.5 text-cyan-400" /> {selectedPost ? new Date(selectedPost.publishTime).toLocaleString() : ""}</span>
              <span>•</span>
              <span className="text-emerald-400 flex items-center gap-0.5">👁 {selectedPost?.views} Views</span>
            </div>

            {/* Version Revision Warning Banner */}
            {selectedPost && currentPostVersion !== (selectedPost.currentVersion || 1) && (
              <div className="bg-amber-500/10 border border-amber-500/30 rounded-xl p-4 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-[0_0_15px_rgba(245,158,11,0.05)]">
                <div className="flex gap-2">
                  <span className="text-amber-400 font-mono text-base">⚠️</span>
                  <div>
                    <h4 className="text-xs font-bold text-white font-sans">আপনি এই আর্টিকেলের একটি পুরাতন সংস্করণ পড়ছেন (সংস্করণ V{currentPostVersion})</h4>
                    <p className="text-[10px] text-slate-400 font-mono mt-0.5">রিয়েল-টাইম এআই ডেক দ্বারা সংরক্ষিত ঐতিহাসিক আর্কাইভ সংস্করণ।</p>
                  </div>
                </div>
                <div className="flex gap-2">
                  <button
                    type="button"
                    onClick={() => {
                      if (!selectedPost) return;
                      // Restore this version as current
                      setNews(prev => prev.map(item => {
                        if (item.id === selectedPost.id) {
                          const nextVer = (item.currentVersion || 1) + 1;
                          const newTimestamp = new Date().toISOString();
                          const restoreVerEntry = {
                            timestamp: newTimestamp,
                            title: displayTitle,
                            content: displayContent,
                            reason: `সংস্করণ V${currentPostVersion} রিস্টোর ও রি-রিলিজ করা হয়েছে।`,
                            version: nextVer
                          };
                          return {
                            ...item,
                            title: displayTitle,
                            content: displayContent,
                            currentVersion: nextVer,
                            updatedTime: newTimestamp,
                            versionHistory: [...(item.versionHistory || []), restoreVerEntry]
                          };
                        }
                        return item;
                      }));
                      setLoadedVersions(prev => ({ ...prev, [selectedPost.id]: (selectedPost.currentVersion || 1) + 1 }));
                      alert(`সংস্করণ V${currentPostVersion} সফলভাবে রিস্টোর ও লাইভ করা হয়েছে!`);
                    }}
                    className="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold font-sans text-[10px] px-3 py-1 rounded transition-colors cursor-pointer"
                  >
                    রিস্টোর করুন (Restore)
                  </button>
                  <button
                    type="button"
                    onClick={() => {
                      if (selectedPost) {
                        setLoadedVersions(prev => ({ ...prev, [selectedPost.id]: selectedPost.currentVersion || 1 }));
                      }
                    }}
                    className="border border-slate-700 hover:border-slate-500 text-slate-300 font-bold font-sans text-[10px] px-3 py-1 rounded transition-colors cursor-pointer"
                  >
                    মূল সংস্করণে ফিরুন
                  </button>
                </div>
              </div>
            )}

            {/* Headline */}
            <h2 className="text-lg sm:text-2xl font-black text-white leading-snug mb-5 font-sans">
              {displayTitle}
            </h2>

            {/* Quality Score Dashboard Card (Bento Style) */}
            <div className="bg-[#0d1527]/70 border border-slate-800/80 rounded-2xl p-4 sm:p-5 mb-6 relative overflow-hidden">
              <div className="absolute top-0 right-0 w-32 h-32 bg-[#00ff66]/5 filter blur-3xl rounded-full"></div>
              
              <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-800/60 pb-4 mb-4">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 rounded-xl bg-emerald-950/40 border border-emerald-500/20 flex items-center justify-center">
                    <CheckCircle2 className="w-5 h-5 text-[#00ff66]" />
                  </div>
                  <div>
                    <h4 className="text-xs font-bold text-white font-sans flex items-center gap-1.5">
                      এআই কোয়ালিটি স্কোর এবং নীতি উত্তীর্ণ <span className="text-[9px] font-mono bg-[#00ff66]/10 text-[#00ff66] px-1.5 py-0.5 rounded uppercase font-bold">AdSense Safe</span>
                    </h4>
                    <p className="text-[10px] text-slate-400 font-mono mt-0.5">গুলপ পাবলিশার পলিসি এবং এসইও (SEO) অপ্টিমাইজড আর্কিটেকচার ভেরিফাইড।</p>
                  </div>
                </div>
                <div className="text-right flex sm:flex-col items-center sm:items-end gap-2 shrink-0">
                  <span className="text-[11px] font-mono text-slate-400 uppercase tracking-wider">TOTAL SCORE</span>
                  <span className="text-lg font-mono font-black text-[#00ff66] bg-[#00ff66]/5 border border-[#00ff66]/20 px-3 py-0.5 rounded-lg">
                    {selectedPost?.qualityScore || selectedPost?.verificationScore || 95}%
                  </span>
                </div>
              </div>

              {/* Grid of Micro-Metrics */}
              <div className="grid grid-cols-2 md:grid-cols-4 gap-4 text-[10px]">
                <div className="bg-[#070b13]/60 p-2.5 rounded-xl border border-slate-800/80">
                  <div className="flex justify-between text-slate-400 font-mono mb-1">
                    <span>উৎস বিশ্বস্ততা (Source)</span>
                    <span className="text-emerald-400 font-bold">{selectedPost?.qualityBreakdown?.source || 94}%</span>
                  </div>
                  <div className="w-full bg-slate-900 h-1 rounded-full overflow-hidden">
                    <div className="bg-emerald-500 h-full" style={{ width: `${selectedPost?.qualityBreakdown?.source || 94}%` }}></div>
                  </div>
                </div>

                <div className="bg-[#070b13]/60 p-2.5 rounded-xl border border-slate-800/80">
                  <div className="flex justify-between text-slate-400 font-mono mb-1">
                    <span>পঠনযোগ্যতা (Readability)</span>
                    <span className="text-cyan-400 font-bold">{selectedPost?.qualityBreakdown?.readability || 96}%</span>
                  </div>
                  <div className="w-full bg-slate-900 h-1 rounded-full overflow-hidden">
                    <div className="bg-cyan-500 h-full" style={{ width: `${selectedPost?.qualityBreakdown?.readability || 96}%` }}></div>
                  </div>
                </div>

                <div className="bg-[#070b13]/60 p-2.5 rounded-xl border border-slate-800/80">
                  <div className="flex justify-between text-slate-400 font-mono mb-1">
                    <span>লিঙ্ক অপ্টিমাইজড (Linking)</span>
                    <span className="text-indigo-400 font-bold">{selectedPost?.qualityBreakdown?.linking || 88}%</span>
                  </div>
                  <div className="w-full bg-slate-900 h-1 rounded-full overflow-hidden">
                    <div className="bg-indigo-500 h-full" style={{ width: `${selectedPost?.qualityBreakdown?.linking || 88}%` }}></div>
                  </div>
                </div>

                <div className="bg-[#070b13]/60 p-2.5 rounded-xl border border-slate-800/80">
                  <div className="flex justify-between text-slate-400 font-mono mb-1">
                    <span>সার্চ ইঞ্জিন এসইও (SEO)</span>
                    <span className="text-pink-400 font-bold">{selectedPost?.qualityBreakdown?.seo || 95}%</span>
                  </div>
                  <div className="w-full bg-slate-900 h-1 rounded-full overflow-hidden">
                    <div className="bg-pink-500 h-full" style={{ width: `${selectedPost?.qualityBreakdown?.seo || 95}%` }}></div>
                  </div>
                </div>
              </div>
            </div>

            {/* Image */}
            <div className="aspect-[16/9] w-full rounded-2xl overflow-hidden bg-slate-950 border border-slate-800 mb-6 shadow-xl relative">
              <img src={selectedPost?.image} alt={displayTitle} className="w-full h-full object-fit-cover" referrerPolicy="no-referrer" />
            </div>

            {/* ADSENSE MID-POST INTEGRATION */}
            <div className="mb-6 p-4 rounded-xl bg-[#0d1527]/40 border border-dashed border-cyan-500/15 text-center flex flex-col gap-1 select-none">
              <span className="text-[9px] font-mono tracking-wider text-slate-500 font-bold">GOOGLE ADSENSE REVENUE ZONE</span>
              <p className="text-[8px] text-slate-500 font-mono">Perfect safety margin maintained</p>
            </div>

            {/* Brief Excerpt */}
            <p className="text-sm font-bold text-[#00f0ff] bg-cyan-950/20 border-l-4 border-[#00f0ff] p-4 rounded-r-xl mb-6 leading-relaxed italic">
              {selectedPost?.summary}
            </p>

            {/* Content Body */}
            <div className="text-sm text-slate-300 leading-relaxed space-y-4 border-b border-slate-800 pb-6 mb-6 font-sans relative">
              {displayContent.split("\n\n").map((para, i) => (
                <p key={i}>{para}</p>
              ))}

              {/* Content Locking Gate (Premium lock if enabled) */}
              {contentGatingOn && (
                <div className="mt-8 bg-gradient-to-r from-cyan-950/40 to-slate-900/60 border border-cyan-500/15 rounded-xl p-4 flex items-center justify-between">
                  <div className="flex items-center gap-2.5">
                    <span className="text-cyan-400 text-sm">🔒</span>
                    <div>
                      <h5 className="text-xs font-bold text-slate-200">আইবিডি এআই গেটেড কন্টেন্ট (SEO Crawl-Indexed)</h5>
                      <p className="text-[10px] text-slate-400 font-mono">গুগল বট ইনডেক্সিং সুরক্ষিত। সাধারণ ভিজিটরদের ট্রাফিক হাইজ্যাক প্রতিরক্ষা সক্রিয়।</p>
                    </div>
                  </div>
                  <span className="text-[9px] font-mono font-bold text-[#00ff66] bg-[#00ff66]/10 px-2.5 py-0.5 rounded border border-[#00ff66]/25 uppercase animate-pulse">
                    ACTIVE
                  </span>
                </div>
              )}
            </div>

            {/* Sources & Reporters */}
            <div className="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between bg-slate-900/40 border border-slate-800 p-4 rounded-xl mb-8">
              <div className="flex items-center gap-2.5">
                <User className="w-4 h-4 text-cyan-400" />
                <span className="text-xs text-slate-400">রিপোর্টার: <span className="text-slate-100 font-bold">{selectedPost?.reporter}</span></span>
              </div>
              {selectedPost?.sourceAttribution && (
                <a 
                  href={selectedPost.sourceAttribution} 
                  target="_blank" 
                  rel="nofollow noopener"
                  className="text-xs font-mono text-[#00f0ff] hover:underline flex items-center gap-1 border border-[#00f0ff]/20 bg-cyan-950/30 px-3 py-1 rounded"
                >
                  🔗 Source: {selectedPost.sourceName || "Official Resource"}
                </a>
              )}
            </div>

            {/* Related Tags */}
            <div className="flex flex-wrap gap-2 items-center mb-8">
              <TagIcon className="w-3.5 h-3.5 text-slate-500" />
              <span className="text-[10px] font-mono text-slate-500 uppercase mr-1">TAGS:</span>
              {selectedPost?.tags.map((tag, i) => (
                <span key={i} className="text-[10px] font-mono bg-slate-900 border border-slate-800 text-slate-400 px-2 py-1 rounded-md">
                  #{tag}
                </span>
              ))}
            </div>

            {/* Intelligent Related Topic Engine */}
            {selectedPost && (
              <div className="bg-[#0d1527]/30 border border-slate-800/60 rounded-2xl p-5 mb-8">
                <h4 className="text-xs font-bold text-white font-mono tracking-wider mb-4 uppercase flex items-center gap-2">
                  <Sparkles className="w-4 h-4 text-cyan-400" /> আইবিডি এআই স্মার্ট রিলেটেড টপিকস
                </h4>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  {news
                    .filter(item => item.id !== selectedPost.id && (item.category === selectedPost.category || item.tags.some(t => selectedPost.tags.includes(t))))
                    .slice(0, 2)
                    .map(item => (
                      <div 
                        key={item.id}
                        onClick={() => {
                          setSelectedNewsId(item.id);
                          window.scrollTo({ top: 0, behavior: 'smooth' });
                        }}
                        className="bg-[#070b13]/60 border border-slate-800/80 hover:border-cyan-500/30 p-4 rounded-xl cursor-pointer group transition-all duration-300"
                      >
                        <span className="text-[9px] font-mono text-cyan-400 bg-cyan-950 px-1.5 py-0.5 rounded border border-cyan-500/10 uppercase">{item.category}</span>
                        <h5 className="text-xs font-bold text-slate-200 group-hover:text-cyan-400 transition-colors mt-2 leading-snug line-clamp-2">
                          {item.title}
                        </h5>
                        <p className="text-[10px] text-slate-400 font-mono mt-2 flex items-center gap-1">সম্পূর্ণ খবর পড়ুন ➡</p>
                      </div>
                    ))}
                </div>
              </div>
            )}

            {/* News Version History Timeline */}
            {selectedPost && selectedPost.versionHistory && selectedPost.versionHistory.length > 0 && (
              <div className="bg-[#0d1527]/30 border border-slate-800/60 rounded-2xl p-5 mb-8">
                <h4 className="text-xs font-bold text-white font-mono tracking-wider mb-4 uppercase flex items-center gap-2">
                  <Clock className="w-4 h-4 text-indigo-400" /> সংবাদের সংস্করণ ইতিহাস (Version Revision History)
                </h4>
                <div className="relative pl-6 border-l border-slate-800 space-y-5">
                  {selectedPost.versionHistory.map((ver) => {
                    const isActive = ver.version === currentPostVersion;
                    const isLatest = ver.version === (selectedPost.currentVersion || 1);
                    return (
                      <div key={ver.version} className="relative group">
                        {/* Dot indicator */}
                        <div className={`absolute -left-[31px] top-1.5 w-2.5 h-2.5 rounded-full border transition-all ${
                          isActive 
                            ? "bg-cyan-400 border-cyan-400 shadow-[0_0_8px_rgba(34,211,238,0.5)] scale-125" 
                            : "bg-slate-950 border-slate-700"
                        }`} />
                        
                        <div className={`p-3 rounded-xl border transition-all ${
                          isActive 
                            ? "bg-cyan-950/20 border-cyan-500/30" 
                            : "bg-[#070b13]/40 border-slate-800/80 hover:border-slate-700"
                        }`}>
                          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-1.5">
                            <div className="flex items-center gap-2">
                              <span className="text-[10px] font-mono bg-slate-900 text-slate-300 px-2 py-0.5 rounded border border-slate-800 font-bold">
                                Version V{ver.version}
                              </span>
                              {isLatest && (
                                <span className="text-[9px] font-mono bg-emerald-950 text-[#00ff66] px-1.5 py-0.5 rounded border border-[#00ff66]/25 font-bold uppercase">
                                  LATEST
                                </span>
                              )}
                              {isActive && (
                                <span className="text-[9px] font-mono bg-cyan-950 text-[#00f0ff] px-1.5 py-0.5 rounded border border-cyan-500/20 font-bold uppercase">
                                  CURRENT VIEW
                                </span>
                              )}
                            </div>
                            <span className="text-[9px] font-mono text-slate-500">{new Date(ver.timestamp).toLocaleString()}</span>
                          </div>
                          
                          <p className="text-xs font-semibold text-slate-200 mb-1">{ver.title}</p>
                          <p className="text-[10px] text-slate-400 bg-slate-950/40 p-1.5 rounded border border-slate-900/60 font-mono mt-1">
                            🔧 পরিবর্তন টীকা: <span className="text-slate-300">{ver.reason}</span>
                          </p>
                          
                          {!isActive && (
                            <button
                              type="button"
                              onClick={() => {
                                setLoadedVersions(prev => ({ ...prev, [selectedPost.id]: ver.version }));
                                window.scrollTo({ top: 0, behavior: "smooth" });
                              }}
                              className="text-[9px] font-mono text-cyan-400 hover:text-white mt-2 flex items-center gap-0.5 hover:underline cursor-pointer"
                            >
                              সংস্করণটি পড়ুন (Switch to V{ver.version}) ➡
                            </button>
                          )}
                        </div>
                      </div>
                    );
                  })}
                </div>
              </div>
            )}

            {/* VIRAL SHARE BUTTONS */}
            <div className="bg-[#0d1527]/60 border border-slate-800 p-5 rounded-2xl text-center mb-8">
              <h3 className="text-xs font-bold text-white font-mono tracking-wider mb-3 uppercase flex items-center justify-center gap-2">
                <Share2 className="w-4 h-4 text-cyan-400" /> VIRAL LOOP MODULE - SHARE WITH FRIENDS
              </h3>
              <div className="flex flex-wrap justify-center gap-3">
                <button 
                  onClick={() => alert("লিঙ্কটি সফলভাবে কপি করা হয়েছে! আপনার বন্ধুদের সাথে শেয়ার করুন।")}
                  className="bg-[#1877f2] text-white font-bold text-xs px-4 py-2 rounded-lg cursor-pointer hover:opacity-90 transition-all"
                >
                  Facebook Share
                </button>
                <button 
                  onClick={() => alert("লিঙ্কটি সফলভাবে কপি করা হয়েছে! আপনার টুইটার ফিডে শেয়ার করুন।")}
                  className="bg-[#1da1f2] text-white font-bold text-xs px-4 py-2 rounded-lg cursor-pointer hover:opacity-90 transition-all"
                >
                  Twitter Share
                </button>
                <button 
                  onClick={() => alert("লিঙ্কটি সফলভাবে কপি করা হয়েছে! আপনার হোয়াটসঅ্যাপ গ্রুপে শেয়ার করুন।")}
                  className="bg-[#25d366] text-white font-bold text-xs px-4 py-2 rounded-lg cursor-pointer hover:opacity-90 transition-all"
                >
                  WhatsApp Share
                </button>
              </div>
            </div>

            {/* COMMENTS SECTION */}
            <div className="border-t border-slate-800/80 pt-6">
              <h3 className="text-sm font-bold text-white flex items-center gap-2 mb-4 font-sans">
                <MessageSquare className="w-4 h-4 text-cyan-400" /> মন্তব্য করুন ({selectedPost?.comments.length || 0})
              </h3>

              {/* List Comments */}
              <div className="space-y-4 mb-6">
                {selectedPost?.comments && selectedPost.comments.length > 0 ? (
                  selectedPost.comments.map((comm) => (
                    <div key={comm.id} className="bg-slate-900/50 border border-slate-800/80 p-4 rounded-xl flex gap-3">
                      <div className="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-sm">
                        {comm.avatar}
                      </div>
                      <div>
                        <div className="flex items-center gap-2 mb-1">
                          <span className="text-xs font-bold text-white">{comm.author}</span>
                          <span className="text-[9px] text-slate-500 font-mono">{comm.time}</span>
                        </div>
                        <p className="text-xs text-slate-300 leading-relaxed">{comm.content}</p>
                      </div>
                    </div>
                  ))
                ) : (
                  <p className="text-xs text-slate-500 font-mono">কোনো মন্তব্য পাওয়া যায়নি। প্রথম মন্তব্যকারী হোন!</p>
                )}
              </div>

              {/* Add Comment Form */}
              <form onSubmit={handleAddComment} className="space-y-3">
                <input 
                  type="text" 
                  value={commentName}
                  onChange={(e) => setCommentName(e.target.value)}
                  placeholder="আপনার নাম..."
                  required
                  className="w-full bg-[#070b13] border border-slate-800 focus:border-cyan-500/50 rounded-xl px-4 py-2 text-xs text-white placeholder-slate-500 focus:outline-none"
                />
                <textarea 
                  value={commentText}
                  onChange={(e) => setCommentText(e.target.value)}
                  placeholder="মন্তব্য লিখুন..."
                  required
                  rows={3}
                  className="w-full bg-[#070b13] border border-slate-800 focus:border-cyan-500/50 rounded-xl px-4 py-2 text-xs text-white placeholder-slate-500 focus:outline-none"
                ></textarea>
                <button 
                  type="submit"
                  className="bg-cyan-500 text-[#070b13] font-bold text-xs px-4 py-2 rounded-xl cursor-pointer hover:bg-cyan-400 transition-all font-mono"
                >
                  ADD COMMENT
                </button>
              </form>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
