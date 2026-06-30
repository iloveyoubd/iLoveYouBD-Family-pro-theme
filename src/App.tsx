import React, { useState, useEffect, FormEvent } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  Terminal, ShieldCheck, HelpCircle, User, LogIn, Plus, 
  Wallet, Bell, Home, Layout, Cpu, RefreshCw, LogOut, CheckCircle, Search, Clock, Award, Tv,
  Music, Video, Wrench, Sparkles, QrCode, Gamepad2, Mic, MicOff, ThumbsUp, Eye,
  Gift, Copy, Share2, TrendingUp, MessageSquare, Volume2, Square
} from "lucide-react";

import type { Post, Question, NotificationItem, UserStats, AdminSettings, LedgerEntry, StoryItem } from "./types";
import RGBBorder from "./components/RGBBorder";
import PostContainer from "./components/PostContainer";
import CommunityQA from "./components/CommunityQA";
import AdminPanel from "./components/AdminPanel";
import AICrew from "./components/AICrew";
import LiveTV from "./components/LiveTV";
import MayaChatbot from "./components/MayaChatbot";
import AudioLab from "./components/AudioLab";
import VideoDownloader from "./components/VideoDownloader";
import UnifiedTools from "./components/UnifiedTools";
import ToolsLabHub from "./components/ToolsLabHub";
import CyberMessenger from "./components/CyberMessenger";
import LegalCenter from "./components/LegalCenter";
import NewsCenter from "./components/NewsCenter";

// Helper keys for localStorage
const LOCAL_POSTS_KEY = "iloveyoubd_posts_db";
const LOCAL_QUESTIONS_KEY = "iloveyoubd_questions_db";
const LOCAL_STATS_KEY = "iloveyoubd_stats_db";
const LOCAL_SETTINGS_KEY = "iloveyoubd_settings_db";
const LOCAL_NOTIFS_KEY = "iloveyoubd_notifs_db";
const LOCAL_WITHDRAW_KEY = "iloveyoubd_withdrawals_db";
const LOCAL_STORIES_KEY = "iloveyoubd_stories_db";

const INITIAL_POSTS: Post[] = [
  {
    id: "post-1",
    title: "গুগল এআই ক্রলার বুস্ট করার ট্রিকস এবং দ্রুত ইনডেক্সিং গাইড ২০৪০",
    excerpt: "গুগল সার্চ ইঞ্জিনের সাথে বন্ধুত্ব করতে চাইলে ক্রলার ইমেট্রি ঠিক করা অপরিহার্য। ২০৪০ ভিশন অনুযায়ী সার্চ ইঞ্জিন ইনডেক্স ফ্রেন্ডলি করার গোপন গাইড।",
    content: `গুগল সার্চ ইঞ্জিনে আপনার কন্টেন্ট দ্রুত ইনডেক্স করার জন্য বেশ কিছু অত্যাধুনিক এসইও (SEO) কৌশল প্রয়োগ করা অপরিহার্য। বর্তমান সময়ে, গুগল ক্রলার বা গুগলবট (Googlebot) অত্যন্ত স্মার্ট এবং এটি মূলত কনটেন্টের কোয়ালিটি, লোডিং স্পিড এবং ইউজার এক্সপেরিয়েন্সের ওপর ভিত্তি করে ইনডেক্সিং করে।

প্রথমত, আপনার ওয়েবসাইটের কোর ওয়েব ভাইটালস (Core Web Vitals) অপ্টিমাইজ করতে হবে। এর মধ্যে রয়েছে LCP (Largest Contentful Paint), FID (First Input Delay), এবং CLS (Cumulative Layout Shift)। আপনার ওয়েবসাইটের সার্ভার রেসপন্স টাইম কমানোর জন্য ভালো মানের হোস্টিং ব্যবহার করুন এবং ইমেজগুলোকে WebP বা AVIF ফরম্যাটে রূপান্তর করুন।

দ্বিতীয়ত, XML সাইটম্যাপ (Sitemap) আপডেট রাখুন এবং নিয়মিত Google Search Console-এ সাবমিট করুন। যখনই নতুন কোনো আর্টিকেল পাবলিশ করবেন, চেষ্টা করবেন সেটি যেন দ্রুত সাইটম্যাপে যুক্ত হয়। পাশাপাশি, ইন্টারনাল লিংকিং (Internal Linking) এর দিকে নজর দিন। আপনার ওয়েবসাইটের পুরনো এবং হাই-অথরিটি পেজগুলো থেকে নতুন পেজে লিংক প্রদান করলে ক্রলার খুব সহজেই নতুন পেজটি খুঁজে পায়।

তৃতীয়ত, মানসম্মত এবং ইন-ডেপথ কনটেন্ট (In-depth Content) তৈরি করুন। গুগল সবসময় সেই কনটেন্টগুলোকে প্রাধান্য দেয় যা ব্যবহারকারীর প্রশ্নের সঠিক এবং বিস্তারিত উত্তর প্রদান করে। "Thin Content" বা অল্প শব্দের কনটেন্ট এড়িয়ে চলুন। প্রতিটি আর্টিকেলে প্রাসঙ্গিক হেডিং (H1, H2, H3) ব্যবহার করুন এবং প্যারাগ্রাফগুলোকে ছোট রাখুন যাতে পড়তে সুবিধা হয়। 

সর্বোপরি, স্কিমা মার্কআপ (Schema Markup) ব্যবহার করতে ভুলবেন না। এটি সার্চ ইঞ্জিনকে আপনার কনটেন্টের ধরন বুঝতে সাহায্য করে, যার ফলে সার্চ রেজাল্টে রিচ স্নিপেট (Rich Snippets) হিসেবে আপনার ওয়েবসাইট প্রদর্শিত হতে পারে। এই নিয়মগুলো সঠিকভাবে মেনে চললে আপনার ওয়েবসাইটের ইনডেক্সিং স্পিড বহুগুণ বেড়ে যাবে।`,
    thumbnail: "https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=600&auto=format&fit=crop",
    category: "SEO Guide",
    tags: ["google", "indexing", "seo", "optimization"],
    readTime: "৫ মিনিট",
    author: {
      name: "এআই অ্যাডমিন অ্যাসিস্ট্যান্ট",
      avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=admin",
      isAI: true,
      rank: "CHIEF OPERATIVE"
    },
    likes: 145,
    views: 1204,
    comments: [
      {
        id: "c-1",
        authorName: "সাইবার টিম বিডি",
        authorAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=team",
        text: "অসাধারণ এসইও গাইড! অনেক হেল্প হলো গুগল অ্যাডসেন্স এপ্রুভালে।",
        timestamp: "১ ঘণ্টা আগে"
      }
    ],
    isFeatured: true,
    timestamp: "২ ঘণ্টা আগে"
  },
  {
    id: "post-2",
    title: "উন্নত সাইবার নিরাপত্তা: ফিশিং প্রতিরোধ এবং ডাটা সুরক্ষার কমপ্লিট গাইড",
    excerpt: "ডার্ক ওয়েবের হুমকি থেকে সোশ্যাল একাউন্ট এবং ডিজিটাল অ্যাসেট কীভাবে শতভাগ নিরাপদ রাখবেন? বাস্তবমুখী সিকিউরিটি টুলস এবং সুরক্ষার গাইড।",
    content: `বর্তমান ডিজিটাল যুগে সাইবার নিরাপত্তা (Cyber Security) বা তথ্য সুরক্ষা একটি অত্যন্ত গুরুত্বপূর্ণ বিষয় হয়ে দাঁড়িয়েছে। প্রতিদিন নতুন নতুন ফিশিং (Phishing) আক্রমণ এবং ডাটা ব্রিচের (Data Breach) খবর পাওয়া যাচ্ছে। নিজের ব্যক্তিগত তথ্য এবং ডিজিটাল অ্যাসেট সুরক্ষিত রাখার জন্য কিছু বেসিক কিন্তু অত্যন্ত কার্যকরী পদক্ষেপ গ্রহণ করা জরুরি।

ফিশিং আক্রমণ থেকে বাঁচার প্রধান উপায় হলো সতর্কতা। ফিশিং মূলত এমন একটি পদ্ধতি যেখানে হ্যাকাররা বিশ্বস্ত কোনো প্রতিষ্ঠান বা ব্যক্তির ছদ্মবেশে ইমেইল বা মেসেজ পাঠায় এবং ব্যবহারকারীকে ক্ষতিকর লিংকে ক্লিক করতে বা সংবেদনশীল তথ্য (যেমন- পাসওয়ার্ড, ক্রেডিট কার্ড নাম্বার) প্রদান করতে প্ররোচিত করে। এই ধরনের আক্রমণ থেকে রক্ষা পেতে কখনোই অচেনা বা সন্দেহজনক ইমেইলের লিংকে ক্লিক করবেন না। লিংকে ক্লিক করার আগে ডোমেইন নেমটি (Domain Name) ভালোভাবে চেক করে নিন। অনেক সময় আসল ওয়েবসাইটের নামের সাথে একটি বা দুটি অক্ষরের পরিবর্তন করে ফিশিং সাইট তৈরি করা হয় (যেমন- facebook.com এর জায়গায় facebo0k.com)।

দ্বিতীয়ত, সব সময় টু-ফ্যাক্টর অথেনটিকেশন (Two-Factor Authentication - 2FA) ব্যবহার করুন। এটি আপনার অ্যাকাউন্টের জন্য একটি অতিরিক্ত সুরক্ষা স্তর যুক্ত করে। যদি কোনো কারণে আপনার পাসওয়ার্ড অন্য কারো হাতে চলেও যায়, তবুও 2FA কোড ছাড়া সে আপনার অ্যাকাউন্টে প্রবেশ করতে পারবে না। 2FA এর জন্য SMS এর পরিবর্তে Google Authenticator বা Authy এর মতো অ্যাপ ব্যবহার করা বেশি নিরাপদ।

পাসওয়ার্ড ম্যানেজমেন্টও অত্যন্ত জরুরি। প্রতিটি অ্যাকাউন্টের জন্য আলাদা এবং শক্তিশালী পাসওয়ার্ড ব্যবহার করুন। একটি শক্তিশালী পাসওয়ার্ডে ক্যাপিটাল লেটার, স্মল লেটার, নাম্বার এবং স্পেশাল ক্যারেক্টার থাকা উচিত। এতগুলো পাসওয়ার্ড মনে রাখা কষ্টকর হতে পারে, তাই একটি বিশ্বস্ত পাসওয়ার্ড ম্যানেজার (Password Manager) যেমন- Bitwarden বা 1Password ব্যবহার করতে পারেন।

এছাড়াও, আপনার ডিভাইস এবং সফটওয়্যারগুলো সব সময় আপ-টু-ডেট রাখুন। সফটওয়্যার আপডেটগুলোতে সাধারণত নতুন আবিষ্কৃত সিকিউরিটি দুর্বলতাগুলোর (Vulnerabilities) প্যাচ (Patch) থাকে। অ্যান্টিভাইরাস বা অ্যান্টি-ম্যালওয়্যার প্রোগ্রাম ব্যবহার করা এবং নিয়মিত স্ক্যান করাও আপনাকে বিভিন্ন ক্ষতিকর সফটওয়্যার থেকে সুরক্ষিত রাখবে। সাইবার জগতে নিরাপদ থাকার মূল চাবিকাঠি হলো সচেতনতা।`,
    thumbnail: "https://images.unsplash.com/photo-1614064641938-3bbee52942c7?q=80&w=600&auto=format&fit=crop",
    category: "Cyber Security",
    tags: ["security", "phishing", "cyber-shield", "safety"],
    readTime: "৭ মিনিট",
    author: {
      name: "সাইবার রনি",
      avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=ronny",
      isAI: false,
      rank: "SECURITY RESEARCHER"
    },
    likes: 89,
    views: 950,
    comments: [],
    timestamp: "৪ ঘণ্টা আগে"
  },
  {
    id: "post-3",
    title: "ওয়েব পারফরম্যান্স অপ্টিমাইজেশন: ওয়েবসাইট ফাস্ট করার ১০টি প্রো টিপস",
    excerpt: "একটি স্লো ওয়েবসাইট শুধুমাত্র ইউজার এক্সপেরিয়েন্সই নষ্ট করে না, বরং এসইও রেংকিংও কমিয়ে দেয়। জানুন ওয়েবসাইট দ্রুত করার উপায়।",
    content: `ইন্টারনেটের এই দ্রুতগতির যুগে কেউ ধীর গতির ওয়েবসাইট পছন্দ করে না। গুগলসহ অন্যান্য সার্চ ইঞ্জিনগুলোও দ্রুত লোড হওয়া ওয়েবসাইটগুলোকে রেংকিংয়ে অগ্রাধিকার দেয়। তাই আপনার ওয়েবসাইটের স্পিড অপ্টিমাইজ করা অত্যন্ত জরুরি। এখানে ওয়েবসাইট ফাস্ট করার কিছু কার্যকরী টিপস আলোচনা করা হলো:

১. ইমেজ অপ্টিমাইজেশন (Image Optimization): ওয়েবসাইটের পেজ সাইজ বড় হওয়ার প্রধান কারণ হলো ভারী ইমেজ। ছবিগুলো আপলোড করার আগে অবশ্যই কম্প্রেস (Compress) করে নিন। TinyPNG বা Squoosh এর মতো টুল ব্যবহার করতে পারেন। এছাড়া Next-gen ফরম্যাট যেমন WebP বা AVIF ব্যবহার করুন, যা কোয়ালিটি ঠিক রেখে সাইজ অনেক কমিয়ে দেয়।

২. ব্রাউজার ক্যাশিং (Browser Caching): ব্রাউজার ক্যাশিং চালু থাকলে একজন ইউজার যখন প্রথমবার আপনার সাইটে ভিজিট করে, তখন কিছু স্ট্যাটিক ফাইল (যেমন- CSS, JavaScript, Logo) তার ব্রাউজারে সেভ হয়ে যায়। ফলে পরবর্তীতে সে যখন আবার সাইটে আসে, তখন ওই ফাইলগুলো সার্ভার থেকে লোড না হয়ে সরাসরি ব্রাউজার থেকে লোড হয়। এতে ওয়েবসাইটের লোডিং স্পিড বহুগুণ বেড়ে যায়।

৩. মিনিফিকেশন (Minification): আপনার ওয়েবসাইটের HTML, CSS এবং JavaScript ফাইলগুলো থেকে অপ্রয়োজনীয় স্পেস, কমা, এবং কমেন্ট রিমুভ করার প্রক্রিয়াকে মিনিফিকেশন বলা হয়। এটি ফাইলের সাইজ ছোট করে এবং ব্রাউজারকে দ্রুত কোড রিড করতে সাহায্য করে।

৪. কন্টেন্ট ডেলিভারি নেটওয়ার্ক (CDN): একটি CDN হলো বিশ্বব্যাপী ছড়িয়ে থাকা সার্ভারের একটি নেটওয়ার্ক। যখন কেউ আপনার ওয়েবসাইটে ভিজিট করে, তখন CDN তার সবচেয়ে কাছের সার্ভার থেকে ওয়েবসাইটের স্ট্যাটিক ফাইলগুলো ডেলিভার করে। Cloudflare একটি জনপ্রিয় এবং ফ্রি CDN সার্ভিস যা আপনি সহজেই ব্যবহার করতে পারেন।

৫. অকেজো প্লাগিন রিমুভ করা: আপনি যদি ওয়ার্ডপ্রেস ব্যবহার করেন, তবে অপ্রয়োজনীয় বা অকেজো প্লাগিনগুলো ডিঅ্যাক্টিভ করে ডিলিট করে দিন। অতিরিক্ত প্লাগিন ওয়েবসাইটের সার্ভারে বাড়তি চাপ সৃষ্টি করে এবং স্পিড কমিয়ে দেয়।

এই বেসিক বিষয়গুলো নিশ্চিত করলে আপনার ওয়েবসাইটের স্পিড উল্লেখযোগ্যভাবে বৃদ্ধি পাবে, যা ইউজার এক্সপেরিয়েন্স এবং এসইও উভয় ক্ষেত্রেই ইতিবাচক প্রভাব ফেলবে।`,
    thumbnail: "https://images.unsplash.com/photo-1518546305927-5a555bb7020d?q=80&w=600&auto=format&fit=crop",
    category: "Web Performance",
    tags: ["performance", "speed", "optimization", "web"],
    readTime: "৬ মিনিট",
    author: {
      name: "রানা মির্জা",
      avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=rana",
      isAI: false,
      rank: "PERFORMANCE ENGINEER"
    },
    likes: 245,
    views: 4120,
    comments: [],
    timestamp: "৬ ঘণ্টা আগে"
  }
];

const INITIAL_QUESTIONS: Question[] = [
  {
    id: "q-1",
    title: "২০৪০ সালের সাইবার ফিল্টারিং এড়াতে এবং গুগল ইনডেক্স দ্রুত করতে স্পিডআপ প্লাগিন কোনটা বেস্ট?",
    author: "হ্যাকার_বিডি",
    category: "SEO & Web-Indexing",
    votes: 7,
    answers: [
      {
        id: "ans-1",
        author: "এআই অ্যাসিস্ট্যান্ট",
        text: "আমাদের এডমিন এআই টুল জেনারেটর কোড সল্ভার মডিউল ব্যবহার করতে পারেন। এটি সাইটের রুট এপিআই স্পিড প্রায় ২০০% বাড়াতে সাহায্য করে।",
        timestamp: "৩০ মিনিট আগে"
      }
    ],
    timestamp: "১ ঘণ্টা আগে"
  },
  {
    id: "q-2",
    title: "পেইন্ডিং পোস্ট কখন পাবলিশ হয়? এবং ক্যাশআউটের বিকাশ রিকোয়েস্ট করতে কি র্যাংক থাকা লাগে?",
    author: "সাইবার_পাবলিশার",
    category: "Earning Systems",
    votes: 3,
    answers: [],
    timestamp: "৩ ঘণ্টা আগে"
  }
];

const INITIAL_STATS: UserStats = {
  name: "তারেক রহমান",
  avatar: "https://api.dicebear.com/7.x/bottts/svg?seed=tester",
  balance: 35.50, // in Taka
  points: 420,
  rank: "WHITE HAT CODER",
  postsPublished: 3,
  postsPending: 1,
  referralCode: "REF-TAREK420",
  referredBy: undefined,
  referredUsers: ["সাইবার বাপ্পি", "শাওন আহমেদ"],
  referralEarnings: 20.00
};

const INITIAL_USERS: UserStats[] = [
  INITIAL_STATS,
  {
    name: "সাইবার রনি",
    avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=ronny",
    balance: 145.00,
    points: 1250,
    rank: "ELITE WHITEHAT",
    postsPublished: 12,
    postsPending: 0,
    referralCode: "REF-RONNY777",
    referredUsers: [],
    referralEarnings: 0
  },
  {
    name: "রানা মির্জা",
    avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=rana",
    balance: 85.50,
    points: 980,
    rank: "SENIOR CONTRIBUTOR",
    postsPublished: 8,
    postsPending: 2,
    referralCode: "REF-MIRZA55",
    referredUsers: [],
    referralEarnings: 0
  },
  {
    name: "সাইবার বাপ্পি",
    avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=bappi",
    balance: 30.00,
    points: 250,
    rank: "WHITEHAT CODER",
    postsPublished: 1,
    postsPending: 1,
    referralCode: "REF-BAPPI007",
    referredUsers: [],
    referralEarnings: 0
  }
];

const DEFAULT_SETTINGS: AdminSettings = {
  revenueSharePercent: 15,
  payoutPerView: 0.15,
  payoutPerLike: 0.60,
  payoutPerPublish: 8.50,
  autoAIPosting: true,
  rgbEffectSpeed: "medium",
  enableInteractiveNotice: true,
  googleAdSenseStatus: "active",
  enableRgbEffects: true,
  rgbStyle: "classic_neo",
  glowSinglePost: true,
  glowSinglePostColor: "#00f0ff",
  glowComments: true,
  glowCommentsColor: "#ff003c",
  glowUserProfile: true,
  glowUserProfileColor: "#bd00ff",
  glowChatbot: true,
  glowChatbotColor: "#00f0ff",
  glowQa: true,
  glowQaColor: "#39ff14",
  glowStories: true,
  glowStoriesColor: "#bd00ff",
  glowWallet: true,
  glowWalletColor: "#39ff14",
  glowSearchIndex: true,
  glowSearchIndexColor: "#eab308",
  defaultThemePreset: "cyber_dark",
  allowUserCustomizer: "yes_logged_in",
  respectDeviceDefaultTheme: false,
  enableAdSenseSafeMode: false,
  enableRgbLoopShift: false,
  enableFooterRgb: true,
  enableGoogleAds: true,
  enableStories: true,
  advertisementSnippet: `<div class="bg-cyan-950/20 border border-cyan-800/40 border-dashed rounded-lg p-3 text-center text-xs font-mono text-cyan-400">⚡ Google ADS: Active & High-CPC Optimized Banner Place</div>`,
  mayaApiKeys: "AlzaSyBAcwAPXPzNfeGQ6XHDR-EaNRsHqhkTro8",
  mayaSystemInstruction: "You are Maya (মায়া), the highly professional, helpful, and extremely competent executive AI assistant of iloveyoubd.com. Write in flawless Bangla. Answer users with high intelligence, deep reasoning, and immense professionalism.",
  mayaTemperature: 0.7,
  autopilotInterval: "custom_smart",
  autopilotCategories: "SEO Guide,Hacking,Online Earning",
  autopilotKeywords: "গুগল অ্যাডসেন্স এপ্রুভাল স্পেশাল টিপস ২০৪০\nকোডিং ক্রাশ ২০৪০ এআই ট্রিক্স\nঅ্যান্ড্রয়েড সিকিউর হ্যাকিং ডিফেন্স\nঅনলাইন আর্নিং বিকাশ রিকোয়েস্ট ট্রিকস\nগুগল সার্চ কনসোল দ্রুত ইনডেক্সিং ২০৪০",
  referralBonusTaka: 10,
  referralXpReward: 50,
  refereeBonusTaka: 10,
  refereeXpReward: 100,
  enableNewsSection: true,
  showNewsModule: true,
  newsDisplayType: "latest",
  newsDisplayCount: 5,
  newsShowThumbnail: true,
  newsShowPublishTime: true,
  newsShowCategory: true,
  newsShowSummary: true,
  newsShowReadMore: true,
  newsButtonText: "নিউজ সেন্টার (News Center)"
};

const INITIAL_NOTIFS: NotificationItem[] = [
  {
    id: "n-1",
    text: "আসসালামু আলাইকুম! iloveyoubd.com এ আপনাকে স্বাগতম।",
    type: "system",
    timestamp: "৫ মিনিট আগে",
    read: false
  },
  {
    id: "n-2",
    text: "আপনার নতুন কন্টেন্ট পাবলিশের জন্য ওয়ালেট ব্যালেন্স ৮.৫ টাকা বাড়ানো হয়েছে।",
    type: "earning",
    timestamp: "১০ মিনিট আগে",
    read: false
  }
];

const INITIAL_WITHDRAWALS = [
  { id: "w-1", author: "রানা মির্জা", wallet: "01754875241 (বিকাশ)", amount: 150, status: "pending" },
  { id: "w-2", author: "সাইবার রনি", wallet: "01941258745 (নগদ)", amount: 80, status: "pending" }
];

const INITIAL_STORIES: StoryItem[] = [
  {
    id: "story-1",
    username: "Abc",
    userAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=abc",
    mediaType: "text",
    textContent: "আজকে গুগল এডসেন্স থেকে পেমেন্ট রিসিভ করলাম! আলহামদুলিল্লাহ!",
    timestamp: "২ ঘণ্টা আগে",
    viewsCount: 154,
    likesCount: 32,
    caption: "আলহামদুলিল্লাহ!"
  },
  {
    id: "story-2",
    username: "Abrar Ahmed",
    userAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=abrar",
    mediaType: "image",
    mediaUrl: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=600&auto=format&fit=crop",
    timestamp: "৩ ঘণ্টা আগে",
    viewsCount: 210,
    likesCount: 65,
    caption: "Cyber Shield 2040 Setup Active 👾"
  },
  {
    id: "story-3",
    username: "Abrar Ahmed",
    userAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=ahmed",
    mediaType: "text",
    textContent: "যারা নতুন ব্লগিং শুরু করতে চান, তারা অবশ্যই ইউনিক কন্টেন্ট নিয়ে কাজ করবেন। কপি পেস্ট বর্জন করুন!",
    timestamp: "৪ ঘণ্টা আগে",
    viewsCount: 98,
    likesCount: 12,
    caption: "নতুনদের জন্য টিপস 💡"
  },
  {
    id: "story-4",
    username: "Abrar Fahim",
    userAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=fahim",
    mediaType: "image",
    mediaUrl: "https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=600&auto=format&fit=crop",
    timestamp: "৫ ঘণ্টা আগে",
    viewsCount: 345,
    likesCount: 120,
    caption: "লিপ-সিঙ্ক প্লাগিন ট্রায়াল বুস্টিং কমপ্লিট 🎯"
  },
  {
    id: "story-5",
    username: "Abrar Fahim",
    userAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=abrarfahim",
    mediaType: "text",
    textContent: "রেফারেল দিয়ে ইতিমধ্যে ৫০০ টাকা ব্যালেন্স আর্ন করেছি! আপনারা কে কত ইনকাম করলেন?",
    timestamp: "৬ ঘণ্টা আগে",
    viewsCount: 520,
    likesCount: 180,
    caption: "Earning Loop Active ৳"
  }
];

const INITIAL_LEDGER: LedgerEntry[] = [
  {
    id: "tx-1",
    username: "তারেক রহমান",
    amount: 8.50,
    currency: "BDT",
    reason: "আর্টিকেল লিখে বোনাস (গুগল এআই ক্রলার বুস্ট করার ট্রিকস...)",
    linkId: "post-1",
    linkType: "post",
    timestamp: "2026-06-05T12:00:00Z"
  },
  {
    id: "tx-2",
    username: "তারেক রহমান",
    amount: 10.00,
    currency: "BDT",
    reason: "রেফারেল বোনাস - সাইবার বাপ্পি",
    linkId: "user-bappi",
    linkType: "referral",
    timestamp: "2026-06-05T10:15:00Z"
  },
  {
    id: "tx-3",
    username: "তারেক রহমান",
    amount: 10.00,
    currency: "BDT",
    reason: "রেফারেল বোনাস - শাওন আহমেদ",
    linkType: "referral",
    timestamp: "2026-06-04T15:20:00Z"
  },
  {
    id: "tx-4",
    username: "তারেক রহমান",
    amount: 50,
    currency: "XP",
    reason: "রেফারেল বোনাস - সাইবার বাপ্পি",
    linkId: "user-bappi",
    linkType: "referral",
    timestamp: "2026-06-05T10:15:00Z"
  },
  {
    id: "tx-5",
    username: "সাইবার রনি",
    amount: 8.50,
    currency: "BDT",
    reason: "আর্টিকেল লিখে বোনাস (একাউন্ট হ্যাকিং এবং ২০৪০ সালের...)",
    linkId: "post-2",
    linkType: "post",
    timestamp: "2026-06-05T09:30:00Z"
  },
  {
    id: "tx-6",
    username: "সাইবার রনি",
    amount: 100,
    currency: "XP",
    reason: "কমিউনিটি সাদা টুপি কন্ট্রিবিউটর অ্যাক্টিভিটি বুস্ট",
    linkType: "admin",
    timestamp: "2026-06-05T08:00:00Z"
  },
  {
    id: "tx-7",
    username: "রানা মির্জা",
    amount: 5.50,
    currency: "BDT",
    reason: "আর্টিকেলে লাইক অর্জিত অ্যাডসেন্স শেয়ার শেয়ার",
    linkId: "post-2",
    linkType: "post",
    timestamp: "2026-06-04T11:45:00Z"
  },
  {
    id: "tx-8",
    username: "সাইবার বাপ্পি",
    amount: 10.00,
    currency: "BDT",
    reason: "রেজিস্ট্রেশন সাইন আপ রেফারেল বোনাস",
    linkType: "referral",
    timestamp: "2026-06-05T10:15:00Z"
  },
  {
    id: "tx-9",
    username: "তারেক রহমান",
    amount: 1.50,
    currency: "BDT",
    reason: "ফোরামের প্রশ্নের উত্তর দিয়ে ক্যাশব্যাক",
    linkId: "forum-ans-1",
    linkType: "forum",
    timestamp: "2026-06-05T14:30:00Z"
  },
  {
    id: "tx-10",
    username: "সাইবার রনি",
    amount: 50.00,
    currency: "BDT",
    reason: "আর্টেলাইট স্পেশাল পারফরম্যান্স কুপন বোনাস",
    linkType: "admin",
    timestamp: "2026-06-03T18:00:00Z"
  }
];


const PLAY_STORE_APPS_LIST = [
  {
    packageId: "com.whatsapp",
    title: "WhatsApp Messenger",
    developer: "WhatsApp LLC",
    category: "Communication / মেসেঞ্জার",
    rating: "4.3",
    size: "৪৮ MB",
    downloads: "5B+",
    icon: "https://play-lh.googleusercontent.com/bYtqbV8Zg6pIi66S7oYm686B6fN6Yg00f0ff",
    description: "সহজ, নিরাপদ ও ব্যক্তিগত মেসেজিং এবং ভয়েস কলার গ্লোবাল সমাধান।"
  },
  {
    packageId: "com.bKash.customerapp",
    title: "bKash - বিকাশ অ্যাপ",
    developer: "bKash Limited",
    category: "Finance / মোবাইল ব্যাংকিং",
    rating: "4.6",
    size: "৫৬ MB",
    downloads: "50M+",
    icon: "https://play-lh.googleusercontent.com/w9ZgY3pI9e7q7snv3qfN6Yg",
    description: "বাংলাদেশে দ্রুত, সুরক্ষিত ও সবচেয়ে বড় উপায়ে টাকা লেনদেন এবং বিল পেমেন্ট।"
  },
  {
    packageId: "com.konasl.nagad",
    title: "Nagad - নকদ অ্যাপ",
    developer: "Nagad Limited",
    category: "Finance / মোবাইল ওয়ালেট",
    rating: "4.5",
    size: "৪৫ MB",
    downloads: "50M+",
    icon: "https://play-lh.googleusercontent.com/8_Q9itYV396Eul6HSf78In969hsnv3qfN6Yg",
    description: "ডাক বিভাগের নির্ভরযোগ্য ওয়ালেট ও ক্যাশ আউট সুবিধা।"
  },
  {
    packageId: "com.zhiliaoapp.musically",
    title: "TikTok - ভিডিও কন্টেন্ট",
    developer: "TikTok Pte. Ltd.",
    category: "Social / এন্টারটেইনমেন্ট",
    rating: "4.4",
    size: "৮২ MB",
    downloads: "1B+",
    icon: "https://play-lh.googleusercontent.com/ccWneaY7Zf380Zg6pIi66S7oYm686B6fN6Yg",
    description: "রিলস ও ছোট ভিডিও ক্লিপের মাধ্যমে মেকার রিঅ্যাকশন এবং লাইভ এন্টারটেইনমেন্ট।"
  },
  {
    packageId: "com.facebook.orca",
    title: "Messenger - মেসেঞ্জার",
    developer: "Meta Platforms, Inc.",
    category: "Communication / চ্যাটিং",
    rating: "4.1",
    size: "৫২ MB",
    downloads: "5B+",
    icon: "https://play-lh.googleusercontent.com/LDY30_zSu9gKn6S6YVvCuasv3QfH4v9V39_e-vL_0Q",
    description: "ফেসবুক বন্ধুদের সাথে সেকেন্ডে ভয়েস কল, মেসেজিং ও লাইভ চ্যাটিং করার গেটওয়ে।"
  },
  {
    packageId: "org.telegram.messenger",
    title: "Telegram - টেলিগ্রাম",
    developer: "Telegram FZ-LLC",
    category: "Communication / সিকিউর চ্যাট",
    rating: "4.3",
    size: "৬৩ MB",
    downloads: "1B+",
    icon: "https://play-lh.googleusercontent.com/61ZSU-XSnA80pxM_3Z-qYn6R9oV39_f-YV_1Q",
    description: "ক্লাউড স্টোরেজ সুবিধাসহ দ্রুত এবং অত্যন্ত নিরাপদ মেসেজিং সার্ভিস।"
  },
  {
    packageId: "com.gpro.capcut",
    title: "CapCut - ভিডিও এডিটর",
    developer: "Bytedance Pte. Ltd.",
    category: "Video Players & Editors",
    rating: "4.5",
    size: "১৩৫ MB",
    downloads: "500M+",
    icon: "https://play-lh.googleusercontent.com/R_W_SNSu9YRn6S6YVvCuasv3QfH4v9V39_e-vL_0Q",
    description: "সহজ এডিটিং টুলস, টেক্সট অ্যানিমেশন ও নিওন ফিল্টার টেমপ্লেটসহ আল্টিমেট ভিডিও এডিটর।"
  },
  {
    packageId: "com.lenovo.anyshare.gps",
    title: "SHAREit - ফাইল শেয়ারিং",
    developer: "Smart Media4U",
    category: "Tools / হাই-স্পিড শেয়ার",
    rating: "4.4",
    size: "৩৯ MB",
    downloads: "1B+",
    icon: "https://play-lh.googleusercontent.com/uR1CSNSu9YRn6S6YVvCuasv3QfH4v9V39_e-vL_0Q",
    description: "কোনো ইন্টারনেট বা ডাটা ছাড়াই সেকেন্ডে বড় বড় মুভি ও কন্টেন্ট ফাইল শেয়ার গেটওয়ে।"
  },
  {
    packageId: "com.google.android.youtube",
    title: "YouTube - ইউটিউব",
    developer: "Google LLC",
    category: "Entertainment",
    rating: "4.5",
    size: "৪৬ MB",
    downloads: "10B+",
    icon: "https://play-lh.googleusercontent.com/lM_CSNSu9YRn6S6YVvCuasv3QfH4v9V39_e-vL_0Q",
    description: "বিশ্বের সর্ববৃহৎ ভিডিও শেয়ারিং প্লাটফর্ম এবং ক্রিয়েটর মনিটাইজেশন হাফ।"
  },
  {
    packageId: "com.truecaller",
    title: "Truecaller - কলার আইডি",
    developer: "Truecaller",
    category: "Tools / স্প্যাম প্রটেকশন",
    rating: "4.5",
    size: "৪৮ MB",
    downloads: "1B+",
    icon: "https://play-lh.googleusercontent.com/E_R_SNSu9YRn6S6YVvCuasv3QfH4v9V39_e-vL_0Q",
    description: "অপরিচিত কলারের নাম এবং স্প্যাম কল স্বয়ংক্রিয়ভাবে ব্লক করার ড্যাশবোর্ড।"
  }
];

export default function App() {
  // Navigation active tab
  const [activeTab, setActiveTab] = useState<
    "home" | "add" | "profile" | "dashboard" | "ai" | "qa" | "admin" | "tools" | "downloader" | "audiolab" | "tools-lab" | "messages" | "privacy" | "terms" | "disclaimer" | "about" | "contact-us" | "tv" | "news"
  >("home");
  const [selectedContactName, setSelectedContactName] = useState<string | undefined>(undefined);
  const [selectedCategory, setSelectedCategory] = useState("All");
  const [feedViewTab, setFeedViewTab] = useState<"all" | "popular">("all");

  // State sync and redirection triggers for Tools Lab & App Scan
  const [initialSubTool, setInitialSubTool] = useState<string | undefined>(undefined);
  const [initialAppForScan, setInitialAppForScan] = useState<any | undefined>(undefined);

  // Single post viewing state
  const [selectedPostId, setSelectedPostId] = useState<string | null>(null);
  const [postFontSize, setPostFontSize] = useState<"text-xs" | "text-sm" | "text-base" | "text-lg">("text-[#00f0ff]");
  const [activeFontSizeClass, setActiveFontSizeClass] = useState<"text-xs" | "text-sm" | "text-base" | "text-lg">("text-sm");
  const [isSpeakingPost, setIsSpeakingPost] = useState(false);

  // Selected question highlight state in Q&A Forum
  const [selectedQuestionId, setSelectedQuestionId] = useState<string | null>(null);

  // Search dropdown overlay state
  const [showSearchDropdown, setShowSearchDropdown] = useState(false);

  // Profile completion reward claimed toggle
  const [isProfileRewardClaimed, setIsProfileRewardClaimed] = useState<boolean>(() => {
    return localStorage.getItem("ilybd_profile_reward_claimed") === "true";
  });

  // Claimed referral milestones state
  const [claimedMilestones, setClaimedMilestones] = useState<number[]>(() => {
    const local = localStorage.getItem("ilybd_claimed_referrals_db");
    return local ? JSON.parse(local) : [];
  });

  // Hacker terminal simulation for referrals
  const [isRefSimulating, setIsRefSimulating] = useState(false);
  const [refTermLogs, setRefTermLogs] = useState<string[]>([]);

  // Dynamic state database loading
  const [posts, setPosts] = useState<Post[]>(() => {
    const local = localStorage.getItem(LOCAL_POSTS_KEY);
    return local ? JSON.parse(local) : INITIAL_POSTS;
  });

  const [questions, setQuestions] = useState<Question[]>(() => {
    const local = localStorage.getItem(LOCAL_QUESTIONS_KEY);
    return local ? JSON.parse(local) : INITIAL_QUESTIONS;
  });

  const [userStats, setUserStats] = useState<UserStats>(() => {
    const local = localStorage.getItem(LOCAL_STATS_KEY);
    return local ? JSON.parse(local) : INITIAL_STATS;
  });

  const [allUsers, setAllUsers] = useState<UserStats[]>(() => {
    const local = localStorage.getItem("iloveyoubd_users_db");
    return local ? JSON.parse(local) : INITIAL_USERS;
  });

  const [adminSettings, setAdminSettings] = useState<AdminSettings>(() => {
    const local = localStorage.getItem(LOCAL_SETTINGS_KEY);
    return local ? JSON.parse(local) : DEFAULT_SETTINGS;
  });

  const [stories, setStories] = useState<StoryItem[]>(() => {
    const local = localStorage.getItem(LOCAL_STORIES_KEY);
    return local ? JSON.parse(local) : INITIAL_STORIES;
  });

  const [activeStoryViewer, setActiveStoryViewer] = useState<StoryItem | null>(null);
  const [showUploadStoryModal, setShowUploadStoryModal] = useState(false);
  const [uploadStoryMediaType, setUploadStoryMediaType] = useState<"text" | "image">("text");
  const [uploadStoryText, setUploadStoryText] = useState("");
  const [uploadStoryUrl, setUploadStoryUrl] = useState("");
  const [uploadStoryCaption, setUploadStoryCaption] = useState("");

  const [notifs, setNotifs] = useState<NotificationItem[]>(() => {
    const local = localStorage.getItem(LOCAL_NOTIFS_KEY);
    const rawNotifs: NotificationItem[] = local ? JSON.parse(local) : INITIAL_NOTIFS;
    const seen = new Set<string>();
    return rawNotifs.filter((item) => {
      if (!item.id || seen.has(item.id)) {
        return false;
      }
      seen.add(item.id);
      return true;
    });
  });

  const [withdrawalRequests, setWithdrawalRequests] = useState<any[]>(() => {
    const local = localStorage.getItem(LOCAL_WITHDRAW_KEY);
    return local ? JSON.parse(local) : INITIAL_WITHDRAWALS;
  });

  const [ledger, setLedger] = useState<LedgerEntry[]>(() => {
    const local = localStorage.getItem("iloveyoubd_ledger_db");
    return local ? JSON.parse(local) : INITIAL_LEDGER;
  });

  const [totalWithdrawn, setTotalWithdrawn] = useState(0);

  // Dynamic user session configuration state
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [loginUsername, setLoginUsername] = useState("তারেক রহমান");
  const [showLoginModal, setShowLoginModal] = useState(false);
  const [showAuthModal, setShowAuthModal] = useState(false);
  const [authModalTab, setAuthModalTab] = useState<"login" | "register">("register");

  // Post Submission modal inputs state
  const [newPostTitle, setNewPostTitle] = useState("");
  const [newPostExcerpt, setNewPostExcerpt] = useState("");
  const [newPostContent, setNewPostContent] = useState("");
  const [newPostCat, setNewPostCat] = useState("Hacking");
  const [newPostTags, setNewPostTags] = useState("");

  // Notification panel views toggles
  const [showNotifDropdown, setShowNotifDropdown] = useState(false);

  // Silding featured posts carousel states
  const [currentSlideIdx, setCurrentSlideIdx] = useState(0);

  // Dynamic system theme mood sync state (Classic hacker green, Ocean Cyan, Violet, malware crimson, gold)
  const [selectedMood, setSelectedMood] = useState("green");

  // Dynamic device theme detection for "Mobile Default Color" representation
  const [systemThemeMode, setSystemThemeMode] = useState<"dark" | "light">("dark");

  useEffect(() => {
    if (typeof window !== "undefined" && window.matchMedia) {
      const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
      setSystemThemeMode(mediaQuery.matches ? "dark" : "light");
      
      const listener = (e: MediaQueryListEvent) => {
        setSystemThemeMode(e.matches ? "dark" : "light");
      };
      mediaQuery.addEventListener("change", listener);
      return () => mediaQuery.removeEventListener("change", listener);
    }
  }, []);

  // 1-Click Rotating RGB Dynamic Sequence Theme Loop
  useEffect(() => {
    if (!adminSettings?.enableRgbLoopShift) return;
    
    const colors = ["green", "cyan", "violet", "crimson", "gold"];
    const interval = setInterval(() => {
      setSelectedMood((prev) => {
        const nextIndex = (colors.indexOf(prev) + 1) % colors.length;
        return colors[nextIndex];
      });
    }, 4000); // Transitions colors gracefully every 4 seconds
    
    return () => clearInterval(interval);
  }, [adminSettings?.enableRgbLoopShift]);

  // Search filter
  const [postSearchQuery, setPostSearchQuery] = useState("");

  // Voice search engine state for header search box
  const [isSearchVoiceActive, setIsSearchVoiceActive] = useState(false);
  const [searchVoiceStatus, setSearchVoiceStatus] = useState("");

  const startSearchVoiceInput = () => {
    const SpeechRecognition = (window as any).SpeechRecognition || (window as any).webkitSpeechRecognition;
    if (!SpeechRecognition) {
      alert("দুঃখিত! আপনার ব্রাউজার ভয়েস সার্চ সমর্থন করে না। অনুগ্রহ করে ক্রোম (Chrome) ব্যবহার করুন।");
      return;
    }

    try {
      const recognition = new SpeechRecognition();
      recognition.continuous = false;
      recognition.interimResults = false;
      recognition.lang = "bn-BD"; // Listen to Bengali

      recognition.onstart = () => {
        setIsSearchVoiceActive(true);
        setSearchVoiceStatus("শুনছি... বলুন");
      };

      recognition.onerror = (e: any) => {
        console.warn("Speech recognition error in Header Search:", e);
        setIsSearchVoiceActive(false);
        setSearchVoiceStatus("");
      };

      recognition.onend = () => {
        setIsSearchVoiceActive(false);
        setSearchVoiceStatus("");
      };

      recognition.onresult = (event: any) => {
        const transcript = event.results[0]?.[0]?.transcript;
        if (transcript) {
          setPostSearchQuery(transcript);
          setShowSearchDropdown(true);
        }
      };

      recognition.start();
    } catch (err) {
      console.error(err);
      setIsSearchVoiceActive(false);
    }
  };

  // URL Hash Deep Link Router (Direct Mapping for #maya-ai and #search-focus)
  useEffect(() => {
    const handleLocationHashChange = () => {
      const hash = window.location.hash;
      if (hash === "#maya-ai" || hash === "#ai" || hash === "#mayachathub" || hash === "#maya") {
        setActiveTab("ai");
      } else if (hash === "#tools" || hash === "#tools-lab" || hash === "#hub") {
        setActiveTab("tools-lab");
      } else if (hash.startsWith("#post-")) {
        const id = hash.replace("#post-", "");
        setSelectedPostId(id);
        setActiveTab("home");
        window.scrollTo({ top: 0, behavior: "smooth" });
      } else if (hash.startsWith("#qa-post-")) {
        const id = hash.replace("#qa-post-", "");
        setSelectedQuestionId(id);
        setActiveTab("qa");
        window.scrollTo({ top: 0, behavior: "smooth" });
      } else if (hash === "#search-focus" || hash === "#search") {
        const container = document.getElementById("global-search-container");
        if (container) {
          container.scrollIntoView({ behavior: "smooth" });
          container.querySelector("input")?.focus();
        }
      }
    };

    handleLocationHashChange();
    window.addEventListener("hashchange", handleLocationHashChange);
    return () => window.removeEventListener("hashchange", handleLocationHashChange);
  }, []);

  // Profiling details state loaders
  const [profilePhone, setProfilePhone] = useState(() => localStorage.getItem("ilybd_profile_phone") || "");
  const [profileBkash, setProfileBkash] = useState(() => localStorage.getItem("ilybd_profile_bkash") || "");
  const [profileBio, setProfileBio] = useState(() => localStorage.getItem("ilybd_profile_bio") || "");
  const [profileSkills, setProfileSkills] = useState(() => localStorage.getItem("ilybd_profile_skills") || "");
  const [profileFbLink, setProfileFbLink] = useState(() => localStorage.getItem("ilybd_profile_fblink") || "");

  // AI loading indicator for admin tool
  const [isGeneratingAIPost, setIsGeneratingAIPost] = useState(false);

  // Sync to database
  useEffect(() => {
    localStorage.setItem(LOCAL_POSTS_KEY, JSON.stringify(posts));
  }, [posts]);

  useEffect(() => {
    localStorage.setItem(LOCAL_STORIES_KEY, JSON.stringify(stories));
  }, [stories]);

  useEffect(() => {
    localStorage.setItem(LOCAL_QUESTIONS_KEY, JSON.stringify(questions));
  }, [questions]);

  useEffect(() => {
    localStorage.setItem(LOCAL_STATS_KEY, JSON.stringify(userStats));
  }, [userStats]);

  useEffect(() => {
    localStorage.setItem(LOCAL_SETTINGS_KEY, JSON.stringify(adminSettings));
  }, [adminSettings]);

  useEffect(() => {
    localStorage.setItem("iloveyoubd_users_db", JSON.stringify(allUsers));
  }, [allUsers]);

  // Sync logged-in user changes back to the master allUsers DB
  useEffect(() => {
    setAllUsers(prev => {
      const exists = prev.some(u => u.name === userStats.name);
      if (exists) {
        return prev.map(u => u.name === userStats.name ? { ...u, ...userStats } : u);
      } else {
        return [...prev, userStats];
      }
    });
  }, [userStats]);

  const handleUpdateUserStats = (username: string, updated: Partial<UserStats>) => {
    setAllUsers(prev => prev.map(u => u.name === username ? { ...u, ...updated } : u));
    if (userStats.name === username) {
      setUserStats(prev => ({ ...prev, ...updated }));
    }
  };

  useEffect(() => {
    localStorage.setItem(LOCAL_NOTIFS_KEY, JSON.stringify(notifs));
  }, [notifs]);

  useEffect(() => {
    localStorage.setItem(LOCAL_WITHDRAW_KEY, JSON.stringify(withdrawalRequests));
  }, [withdrawalRequests]);

  useEffect(() => {
    localStorage.setItem("iloveyoubd_ledger_db", JSON.stringify(ledger));
  }, [ledger]);

  const addLedgerTransaction = (
    username: string, 
    amount: number, 
    currency: "BDT" | "XP", 
    reason: string, 
    linkId?: string, 
    linkType?: "post" | "comment" | "referral" | "forum" | "admin" | "other"
  ) => {
    const newEntry: LedgerEntry = {
      id: `tx-${Date.now()}-${Math.random().toString(36).substring(2, 9)}`,
      username,
      amount,
      currency,
      reason,
      linkId,
      linkType: linkType || "other",
      timestamp: new Date().toISOString()
    };
    setLedger(prev => [newEntry, ...prev]);
  };

  useEffect(() => {
    localStorage.setItem("ilybd_claimed_referrals_db", JSON.stringify(claimedMilestones));
  }, [claimedMilestones]);

  useEffect(() => {
    localStorage.setItem("ilybd_profile_reward_claimed", String(isProfileRewardClaimed));
  }, [isProfileRewardClaimed]);

  useEffect(() => {
    const handleClickOutside = (e: MouseEvent) => {
      const container = document.getElementById("global-search-container");
      if (container && !container.contains(e.target as Node)) {
        setShowSearchDropdown(false);
      }
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, []);

  useEffect(() => {
    localStorage.setItem("ilybd_profile_phone", profilePhone);
    localStorage.setItem("ilybd_profile_bkash", profileBkash);
    localStorage.setItem("ilybd_profile_bio", profileBio);
    localStorage.setItem("ilybd_profile_skills", profileSkills);
    localStorage.setItem("ilybd_profile_fblink", profileFbLink);
  }, [profilePhone, profileBkash, profileBio, profileSkills, profileFbLink]);

  const handleSimulateReferral = () => {
    if (isRefSimulating) return;

    setIsRefSimulating(true);
    setRefTermLogs([]);

    const logMessages = [
      "📡 ৫ই-জেনারেশন প্রক্সি সকেট ইনিশিয়ালাইজেশন শুরু...",
      "🔒 ক্লাউড ফ্লেয়ার ওয়েবশিল্ড বাইপাস সকেট ট্যাপ ভ্যালিডেটিং...",
      "🔍 আপনার ইউনিক রেফারেল সোর্স আইডি স্ক্যান করা হচ্ছে...",
      "⚡ টার্গেট ইউজার আইডেন্টিটি রিকভারি হ্যান্ডশেক সম্পূর্ণ...",
      "⚙️ মেম্বার সোর্স ফোর্সিং... রেভিনিউ মেটাফ্লো এলাইনমেন্ট..."
    ];

    let currentLogIndex = 0;
    setRefTermLogs([logMessages[0]]);
    currentLogIndex++;

    const logInterval = setInterval(() => {
      if (currentLogIndex < logMessages.length) {
        setRefTermLogs(prev => [...prev, logMessages[currentLogIndex]]);
        currentLogIndex++;
      } else {
        clearInterval(logInterval);
        
        const names = ["নিলয় হাসান", "সাইবার সাকিব", "ইমরান নাজির", "ফয়সাল মাহমুদ", "আরিফ বিল্লাহ", "সাকিবুল ইসলাম", "তাহমিদ চৌধুরী", "মেহেদী হাসান", "রকিবুল ইসলাম", "ফারিয়া সুলতানা"];
        const randomName = names[Math.floor(Math.random() * names.length)];
        
        if (userStats.referredUsers?.includes(randomName)) {
          setRefTermLogs(prev => [
            ...prev,
            `❌ সিকিউরিটি ওয়ার্নিং: (${randomName}) ইতিমধ্যে আপনার সিস্টেমে রেফার করা আছে!`
          ]);
          setIsRefSimulating(false);
          addSystemNotification(`হ্যাকিং ওয়াচডগ: (${randomName}) ইতিমধ্যে আপনার রেফারাল বোনাসে যোগ দিয়েছেন।`, "system");
          return;
        }

        const tBonus = adminSettings.referralBonusTaka !== undefined ? adminSettings.referralBonusTaka : 10;
        const pBonus = adminSettings.referralXpReward !== undefined ? adminSettings.referralXpReward : 50;

        setUserStats(prev => {
          const currentReferred = prev.referredUsers || [];
          addLedgerTransaction(prev.name, tBonus, "BDT", `রেফারেল বোনাস - ${randomName}`, `user-${randomName.replace(/\s+/g, '').toLowerCase()}`, "referral");
          addLedgerTransaction(prev.name, pBonus, "XP", `রেফারেল বোনাস - ${randomName}`, `user-${randomName.replace(/\s+/g, '').toLowerCase()}`, "referral");
          return {
            ...prev,
            balance: Number((prev.balance + tBonus).toFixed(2)),
            points: prev.points + pBonus,
            referredUsers: [...currentReferred, randomName],
            referralEarnings: (prev.referralEarnings || 0) + tBonus
          };
        });

        setRefTermLogs(prev => [
          ...prev,
          `✓ সাকসেসফুল! ইউজার (${randomName}) সফলভাবে জয়েন করেছেন।`,
          `🔥 বোনাস রিসিভড: +${tBonus}.০০ BDT এবং +${pBonus} XP আপনার অ্যাকাউন্টে পুশ করা হয়েছে!`
        ]);
        setIsRefSimulating(false);

        addSystemNotification(`🎉 রেফারেল সফল! আপনার দেওয়া কোড ব্যবহার করে (${randomName}) জয়েন করেছে। আপনার ওয়ালেটে +${tBonus} ৳ এবং +${pBonus} XP যুক্ত হয়েছে!`, "earning");
      }
    }, 500);
  };

  const handleClaimMilestone = (milestoneCount: number, rewardTaka: number, milestoneName: string) => {
    if (claimedMilestones.includes(milestoneCount)) {
      addSystemNotification(`ইতিমধ্যে আপনি ‘${milestoneName}’ বোনাস ক্লেইম করেছেন!`, "system");
      return;
    }
    const referredCount = userStats.referredUsers?.length || 0;
    if (referredCount < milestoneCount) {
      addSystemNotification(`লিমিট অসম্পূর্ণ! বোনাস পেতে কমপক্ষে ${milestoneCount} জন সফল রেফারেল প্রয়োজন।`, "system");
      return;
    }

    addLedgerTransaction(userStats.name, rewardTaka, "BDT", `মাইলস্টোন ক্লেইম - ${milestoneName}`, `milestone-${milestoneCount}`, "other");
    addLedgerTransaction(userStats.name, milestoneCount * 10, "XP", `মাইলস্টোন ক্লেইম - ${milestoneName}`, `milestone-${milestoneCount}`, "other");

    setUserStats(prev => ({
      ...prev,
      balance: Number((prev.balance + rewardTaka).toFixed(2)),
      points: prev.points + milestoneCount * 10
    }));

    setClaimedMilestones(prev => [...prev, milestoneCount]);
    addSystemNotification(`🔥 অভিনন্দন! আপনি সফলভাবে ‘${milestoneName}’ ক্লেইম করে +${rewardTaka} ৳ বোনাস অর্জন করেছেন!`, "earning");
  };

  // Automated slider rotation
  useEffect(() => {
    const timer = setInterval(() => {
      setCurrentSlideIdx((prev) => (prev + 1) % posts.length);
    }, 8000);
    return () => clearInterval(timer);
  }, [posts]);

  // Handle post Likes monetization reward flow
  const handleLikePost = (postId: string) => {
    setPosts((prevPosts) =>
      prevPosts.map((post) => {
        if (post.id === postId) {
          // Add payouts to this post owner profile. If it belongs to logged in user, pay out there instantly!
          if (isLoggedIn && post.author.name === userStats.name) {
            addLedgerTransaction(userStats.name, adminSettings.payoutPerLike, "BDT", `পোস্টে লাইক পাওয়ার বোনাস (পোস্ট আইডি: ${postId})`, postId, "post");
            addLedgerTransaction(userStats.name, 2, "XP", `পোস্টে লাইক পাওয়ার বোনাস (পোস্ট আইডি: ${postId})`, postId, "post");
            setUserStats((prev) => ({
              ...prev,
              balance: Number((prev.balance + adminSettings.payoutPerLike).toFixed(2)),
              points: prev.points + 2
            }));
          }

          // Add feedback logs
          addSystemNotification(`আপনার '${post.title.substring(0, 18)}...' কন্টেন্টে লাইক আসায় এবং এডসেন্স শেয়ার শেয়ার থেকে ওয়ালেট ব্যালেন্স যুক্ত হয়েছে।`, "earning");

          return { ...post, likes: post.likes + 1 };
        }
        return post;
      })
    );
  };

  // Handle comment submission
  const handleCommentPost = (postId: string, commentText: string) => {
    const newComment = {
      id: `comment-${Date.now()}`,
      authorName: isLoggedIn ? userStats.name : "ভিজিটর ফাইটার",
      authorAvatar: isLoggedIn ? userStats.avatar : "https://api.dicebear.com/7.x/pixel-art/svg?seed=visitor",
      text: commentText,
      timestamp: "১ সেকেন্ড আগে"
    };

    setPosts((prevPosts) =>
      prevPosts.map((post) => {
        if (post.id === postId) {
          if (isLoggedIn && post.author.name === userStats.name) {
            const rewardAm = Number((adminSettings.payoutPerView * 0.5).toFixed(2));
            addLedgerTransaction(userStats.name, rewardAm, "BDT", `কন্টেন্ট ফিডব্যাক মন্তব্য পাওয়ার ক্যাশব্যাক (পোস্ট আইডি: ${postId})`, postId, "comment");
            addLedgerTransaction(userStats.name, 1, "XP", `কন্টেন্ট ফিডব্যাক মন্তব্য পাওয়ার বোনাস (পোস্ট আইডি: ${postId})`, postId, "comment");
            setUserStats((prev) => ({
              ...prev,
              balance: Number((prev.balance + rewardAm).toFixed(2)),
              points: prev.points + 1
            }));
          }
          addSystemNotification(`আপনার পোস্টে একটি কন্টেন্ট ফিডব্যাক মন্তব্য এসে জমা হয়েছে।`, "comment");
          return { ...post, comments: [...post.comments, newComment] };
        }
        return post;
      })
    );
  };

  // Add forum question
  const handleAddForumQuestion = (title: string, category: string) => {
    const newQuestion: Question = {
      id: `question-${Date.now()}`,
      title,
      author: isLoggedIn ? userStats.name : "হ্যাকার_গেস্ট",
      category,
      votes: 1,
      answers: [],
      timestamp: "এইমাত্র"
    };

    setQuestions((prev) => [newQuestion, ...prev]);
    if (isLoggedIn) {
      addLedgerTransaction(userStats.name, 10, "XP", `ফোরামে প্রশ্ন করার রিওয়ার্ড (${title.substring(0, 18)}...)`, newQuestion.id, "forum");
      setUserStats((prev) => ({
        ...prev,
        points: prev.points + 10
      }));
      addSystemNotification("কমিউনিটি ফোরামে প্রশ্ন করার জন্য আপনাকে ১০ পয়েন্ট দেওয়া হয়েছে।", "system");
    }
  };

  // Add forum answer
  const handleAddAnswer = (questionId: string, answerText: string) => {
    setQuestions((prevQuestions) =>
      prevQuestions.map((q) => {
        if (q.id === questionId) {
          const newAns = {
            id: `ans-${Date.now()}`,
            author: isLoggedIn ? userStats.name : "সাইবার_পাবলিক",
            text: answerText,
            timestamp: "এইমাত্র"
          };
          if (isLoggedIn) {
            addLedgerTransaction(userStats.name, 1.50, "BDT", `ফোরামে সঠিক উত্তর দানের প্রাইজ`, questionId, "forum");
            addLedgerTransaction(userStats.name, 15, "XP", `ফোরামে সঠিক উত্তর দানের প্রাইজ`, questionId, "forum");
            setUserStats((prev) => ({
              ...prev,
              balance: prev.balance + 1.50, // bonus reward
              points: prev.points + 15
            }));
            addSystemNotification("প্রশ্নের উত্তর দেওয়ায় আপনার ব্যালেন্সে ১.৫০ টাকা ক্যাশব্যাক করা হয়েছে।", "earning");
          }
          return { ...q, answers: [...q.answers, newAns] };
        }
        return q;
      })
    );
  };

  // Add fresh Post from AI bot generator
  const handleAddGeneratedPost = (generatedPost: any) => {
    const authorRandomImg = `https://api.dicebear.com/7.x/pixel-art/svg?seed=${generatedPost.authorName}`;
    const newPost: Post = {
      id: `post-${Date.now()}`,
      title: generatedPost.title || "Untitled Intelligence Data",
      excerpt: generatedPost.excerpt || "",
      content: generatedPost.content || "",
      thumbnail: generatedPost.thumbnail || "https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=600&auto=format&fit=crop",
      category: generatedPost.category || "Hacking",
      tags: generatedPost.tags || ["ai", "hacker"],
      readTime: generatedPost.readTime || "৩ মিনিট",
      author: {
        name: generatedPost.authorName || "CyberBot AI",
        avatar: authorRandomImg,
        isAI: true,
        rank: "VIP GPT BOT"
      },
      likes: 2,
      views: 12,
      comments: [],
      timestamp: "এইমাত্র"
    };

    setPosts((prev) => [newPost, ...prev]);
    addSystemNotification(`এআই রোবট "${newPost.author.name}" স্বয়ংক্রিয়ভাবে নতুন একটি কন্টেন্ট পাবলিশ করেছে।`, "post");
  };

  // User adds new post manually
  const handleUserAddPost = (e: FormEvent) => {
    e.preventDefault();
    if (!newPostTitle.trim() || !newPostContent.trim()) return;

    const tagsArr = newPostTags ? newPostTags.split(",").map((s) => s.trim()) : ["cyber", "bangladesh"];

    // Pre-calculated template placeholder image matching the category
    let customImg = "https://images.unsplash.com/photo-1510511459019-5dda7724fd87?q=80&w=600&auto=format&fit=crop";
    if (newPostCat === "SEO Guide") {
      customImg = "https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600&auto=format&fit=crop";
    } else if (newPostCat === "Online Earning") {
      customImg = "https://images.unsplash.com/photo-1559526324-4b87b5e36e44?q=80&w=600&auto=format&fit=crop";
    }

    const createdPost: Post = {
      id: `post-${Date.now()}`,
      title: newPostTitle,
      excerpt: newPostExcerpt || "ব্যবহারকারী ট্রিকবিডি স্টাইলে একটি বিশেষ কন্টেন্ট শেয়ার করেছেন।",
      content: newPostContent,
      thumbnail: customImg,
      category: newPostCat,
      tags: tagsArr,
      readTime: "৪ মিনিট",
      author: {
        name: userStats.name,
        avatar: userStats.avatar,
        isAI: false,
        rank: userStats.rank
      },
      likes: 1,
      views: 10,
      comments: [],
      timestamp: "এইমাত্র"
    };

    setPosts((prev) => [createdPost, ...prev]);
    // Reward Publisher
    addLedgerTransaction(userStats.name, adminSettings.payoutPerPublish, "BDT", `নতুন কন্টেন্ট পাবলিশ বোনাস: ${createdPost.title.substring(0, 20)}...`, createdPost.id, "post");
    addLedgerTransaction(userStats.name, 25, "XP", `নতুন কন্টেন্ট পাবলিশ বোনাস: ${createdPost.title.substring(0, 20)}...`, createdPost.id, "post");
    setUserStats((prev) => ({
      ...prev,
      balance: Number((prev.balance + adminSettings.payoutPerPublish).toFixed(2)),
      points: prev.points + 25,
      postsPublished: prev.postsPublished + 1
    }));

    addSystemNotification(`কন্টেন্ট পাবলিশ সফল! আপনার ওয়ালেট ব্যালেন্সে বোনাস ৮.৫০ টাকা পরিশোধ করা হয়েছে।`, "earning");

    // Reset inputs
    setNewPostTitle("");
    setNewPostExcerpt("");
    setNewPostContent("");
    setNewPostTags("");
    setActiveTab("home");
  };

  // Notification engine helpers
  const addSystemNotification = (text: string, type: any) => {
    const uniqueSuffix = Math.random().toString(36).substring(2, 11);
    const keyIn = {
      id: `notif-${Date.now()}-${uniqueSuffix}`,
      text,
      type,
      timestamp: "এইমাত্র",
      read: false
    };
    setNotifs((prev) => [keyIn, ...prev]);
  };

  const handleClearNotifIdx = (id: string) => {
    setNotifs((prev) => prev.filter((item) => item.id !== id));
  };

  // Cashout withdrawals
  const handleApplyWithdrawal = () => {
    if (userStats.balance < 50) {
      alert("দুঃখিত! উইথড্র করার জন্য আপনার ওয়ালেটে ন্যূনতম ৫০ টাকা ব্যালেন্স থাকা আবশ্যক।");
      return;
    }

    const valueAmount = Math.floor(userStats.balance);
    const orderWithdraw = {
      id: `w-${Date.now()}`,
      author: userStats.name,
      wallet: "017XXXXXXXX (বিকাশ)",
      amount: valueAmount,
      status: "pending"
    };

    addLedgerTransaction(userStats.name, -valueAmount, "BDT", `উইথড্রল ক্যাশআউট রিকোয়েস্ট`, orderWithdraw.id, "admin");
    setWithdrawalRequests((prev) => [orderWithdraw, ...prev]);
    setUserStats((prev) => ({
      ...prev,
      balance: Number((prev.balance - valueAmount).toFixed(2))
    }));
    addSystemNotification(`বিকাশ ওয়ালেটে ${valueAmount} টাকার উইথড্র রিকোয়েস্ট অ্যাডমিনের কাছে পাঠানো হয়েছে।`, "system");
    alert(`সফল হয়েছে!\nআপনার ${valueAmount} ৳ উত্তোলনের রিকোয়েস্ট উইথড্রাল রেজিস্ট্রিতে যোগ করা হয়েছে।`);
  };

  const handleApproveWithdrawal = (id: string) => {
    setWithdrawalRequests((prev) =>
      prev.map((r) => {
        if (r.id === id) {
          addLedgerTransaction(r.author, r.amount, "BDT", `উইথড্রল রিকোয়েস্ট সফলভাবে পেইড/অনুমোদনের নিশ্চয়তা`, r.id, "admin");
          setTotalWithdrawn((v) => v + r.amount);
          return { ...r, status: "paid" };
        }
        return r;
      })
    );
  };

  // System AI Crew Trigger
  const handleTriggerAutopilotPost = async (prompt: string, category: string) => {
    setIsGeneratingAIPost(true);
    try {
      const res = await fetch("/api/gemini/generate-post", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          prompt: prompt,
          category: category,
          authorName: "মেগা ক্রু এআই",
          keys: adminSettings.mayaApiKeys.split("\n").map(k => k.trim()).filter(Boolean)
        })
      });

      const data = await res.json();
      handleAddGeneratedPost(data);
      return data;
    } catch (err) {
      console.error(err);
      const fallback = {
        title: `${prompt} - সাইবার সিকিউরিটি বিশ্লেষণ ২০৪০`,
        excerpt: "সার্ভার স্পিড ফিক্স করার সিকিউরিটি গাইড সম্পর্কে এআই অ্যাসিস্ট্যান্ট পোস্ট তৈরি করেছে।",
        content: `## ২০৪০ সালের হ্যাকিং এবং ডিফেন্স সিস্টেম\n\nআসসালামু আলাইকুম! **iloveyoubd.com**-এর পাঠকদের জন্য আজ আমরা আলোচনা করব কীভাবে কোয়ান্টাম এনক্রিপশন এবং এআই ডিফেন্স আমাদের ডেটা সুরক্ষিত রাখছে।\n\n### ১. গুগল ইনডেক্সিং এবং এসইও সিক্রেটস\nআধুনিক গুগল সার্চ এআই ক্রলারদের সাথে বন্ধুত্ব করতে চাইলে আমাদের প্রতিটি কন্টেন্টে মেটা-ডাটা রিলেশন মজবুত করতে হবে। ২০৪০ ভিশন অনুযায়ী সার্চ ইঞ্জিন এখন সরাসরি অডিও ও ক্রিপ্টো আইডি স্ক্যান করে থাকে।\n\n**কন্টেন্ট সমাপ্ত। আপনার মতামত কমেন্টে জানান!**`,
        category: category,
        tags: ["ai", "hacker-security"],
        readTime: "৩ মিনিট",
        authorName: "মেগা ক্রু এআই"
      };
      handleAddGeneratedPost(fallback);
      return fallback;
    } finally {
      setIsGeneratingAIPost(false);
    }
  };

  const handleAdminTriggerAIPost = async () => {
    const concepts = [
      "অ্যাডসেন্স লোডিং সিক্রেট ২০৪০",
      "ডিপিএল প্যাকেট ফিল্টারিং হ্যাকস",
      "২০৪০ সালে এআই কোডিং রোবট ডেভেলপমেন্ট"
    ];
    const keyword = concepts[Math.floor(Math.random() * concepts.length)];
    await handleTriggerAutopilotPost(keyword, "SEO Guide");
  };

  // Filter posts
  const filteredPostsList = posts.filter((p) => {
    const matchCategory = selectedCategory === "All" || p.category === selectedCategory;
    const matchSearch = p.title.toLowerCase().includes(postSearchQuery.toLowerCase()) || 
                        p.excerpt.toLowerCase().includes(postSearchQuery.toLowerCase()) ||
                        p.category.toLowerCase().includes(postSearchQuery.toLowerCase());
    return matchCategory && matchSearch;
  });

  // Mood accent lookups
  const getMoodColorClasses = () => {
    switch (selectedMood) {
      case "cyan":
        return {
          glowColor: "shadow-[0_0_15px_rgba(0,240,255,0.45)]",
          textAccent: "text-[#00f0ff]",
          borderAccent: "border-[#00f0ff]/50",
          bgGlow: "bg-[#00f0ff]/5",
          btnGradient: "from-cyan-500 to-teal-500",
          overallSkin: "theme-cyan"
        };
      case "violet":
        return {
          glowColor: "shadow-[0_0_15px_rgba(189,0,255,0.45)]",
          textAccent: "text-[#bd00ff]",
          borderAccent: "border-[#bd00ff]/50",
          bgGlow: "bg-[#bd00ff]/5",
          btnGradient: "from-purple-500 via-fuchsia-500 to-pink-500",
          overallSkin: "theme-violet"
        };
      case "crimson":
        return {
          glowColor: "shadow-[0_0_15px_rgba(255,0,60,0.45)]",
          textAccent: "text-[#ff003c]",
          borderAccent: "border-[#ff003c]/50",
          bgGlow: "bg-[#ff003c]/5",
          btnGradient: "from-red-600 via-rose-500 to-orange-500",
          overallSkin: "theme-crimson"
        };
      case "gold":
        return {
          glowColor: "shadow-[0_0_15px_rgba(234,179,8,0.45)]",
          textAccent: "text-[#eab308]",
          borderAccent: "border-[#eab308]/50",
          bgGlow: "bg-[#eab308]/5",
          btnGradient: "from-yellow-500 to-amber-500",
          overallSkin: "theme-gold"
        };
      case "green":
      default:
        return {
          glowColor: "shadow-[0_0_15px_rgba(57,255,20,0.45)]",
          textAccent: "text-[#39ff14]",
          borderAccent: "border-[#39ff14]/50",
          bgGlow: "bg-[#39ff14]/5",
          btnGradient: "from-emerald-500 to-green-500",
          overallSkin: "theme-[#39ff14]"
        };
    }
  };

  const styleProfile = getMoodColorClasses();

  const isLightMode = adminSettings?.respectDeviceDefaultTheme 
    ? (systemThemeMode === "light") 
    : (adminSettings?.defaultThemePreset === "light_clean");

  const isAdSenseSafe = adminSettings?.enableAdSenseSafeMode;

  return (
    <div className={`min-h-screen font-sans transition-all duration-500 relative pb-16 ${
      isLightMode 
        ? "light-mode-active bg-slate-50 text-slate-900" 
        : isAdSenseSafe 
          ? "bg-[#080d19] text-slate-100" 
          : "bg-[#060a12] text-slate-100"
    }`}>
      
      {/* 2040 Global RGB/Neon Simulation Frame Overlays */}
      {adminSettings.enableRgbEffects && !isAdSenseSafe && (
        <div className={`cyber-rgb-frame ${adminSettings.rgbStyle || "classic_neo"}`} />
      )}
      
      {/* Background neon ambient aura nodes */}
      <div className="absolute top-24 left-10 w-96 h-96 rounded-full opacity-3 blur-3xl pointer-events-none" style={{ backgroundColor: styleProfile.textAccent }} />
      <div className="absolute top-2/3 right-10 w-96 h-96 rounded-full opacity-3 blur-3xl pointer-events-none" style={{ backgroundColor: styleProfile.textAccent }} />

      {/* Cyber Ticker Notice Board */}
      {adminSettings.enableInteractiveNotice && (
        <div className="bg-[#050911] border-b border-cyan-950/40 text-center py-2 relative overflow-hidden text-xs">
          <div className="max-w-7xl mx-auto px-4 flex items-center justify-between gap-4">
            <span className="flex items-center gap-1.5 font-mono text-emerald-400 shrink-0 font-bold">
              <span className="w-1.5 h-1.5 bg-red-500 rounded-full animate-ping" />
              লাইভ নোটিশ:
            </span>
            <div className="overflow-hidden flex-1 relative h-4">
              <div className="absolute top-0 animate-[marquee_18s_linear_infinite] whitespace-nowrap text-[11px] font-mono text-slate-300">
                🚀 নতুন এআই রাইটার চালু হয়েছে! কন্টেন্ট প্রকাশে ব্যালেন্স বোনাস ৮.৫০ টাকা এবং প্রতি ভিউয়ে ০.১৫ টাকা করে ওয়ালেটে সরাসরি যুক্ত হচ্ছে। ক্যাশআউট করুন যেকোনো সময় বিকাশ ও নগদে।
              </div>
            </div>
            <span className="text-[10px] text-cyan-400 font-mono hidden md:inline shrink-0">
              ⚡ Google-AdSense Approve Score: ৯৮%
            </span>
          </div>
        </div>
      )}

      {/* HEADER SECTION */}
      <header className="bg-[#080d17]/85 backdrop-blur-md border-b border-cyan-950/50 sticky top-0 z-40">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex justify-between items-center gap-4">
          
          {/* Logo element left side */}
          <div className="flex items-center gap-4">
            <div className="flex items-center gap-2">
              <div className={`p-0.5 rounded-lg bg-[#0c1523] border ${styleProfile.borderAccent} flex items-center justify-center overflow-hidden`}>
                <img src="/icon.png" alt="Neon Pro Logo" className="w-8 h-8 rounded-md object-cover" referrerPolicy="no-referrer" />
              </div>
              <div className="text-left">
                <h1 id="app-logo" className="text-xl font-bold tracking-tight text-white leading-none font-sans">
                  iloveyoubd<span className={styleProfile.textAccent}>.com</span>
                </h1>
                <span className="text-[8.5px] font-mono tracking-wider text-slate-400 uppercase leading-none block mt-1">
                  2040 Futuristic Blogging & Earning Hub
                </span>
              </div>
            </div>

            {/* Quick Registration Button - Next to logo */}
            {!isLoggedIn && (
              <button
                id="header-reg-btn"
                onClick={() => {
                  setAuthModalTab("register");
                  setShowAuthModal(true);
                }}
                className="hidden md:flex items-center gap-1.5 text-[10px] font-bold font-mono uppercase bg-emerald-950/60 hover:bg-emerald-900 text-emerald-400 py-1.5 px-3 rounded border border-emerald-800/55 shadow-[0_0_8px_rgba(16,185,129,0.15)] transition-all cursor-pointer hover:border-emerald-400 animate-pulse"
              >
                <span>➕ রেজিস্ট্রেশন করুন</span>
              </button>
            )}
          </div>

          {/* User Status center element or Login buttons */}
          <div className="flex items-center gap-3">
            {isLoggedIn ? (
              <div className={`p-1 px-3 sm:px-4 rounded-xl bg-slate-950/80 border ${styleProfile.borderAccent} shadow-sm flex items-center gap-3 animate-fade-in`}>
                <div className="text-right hidden sm:block">
                  <div className="text-[11px] font-mono text-slate-400">আসসালামু আলাইকুম,</div>
                  <div className="text-xs font-bold text-slate-100 flex items-center gap-1 leading-snug">
                    {userStats.name}
                    <span className="text-[9px] font-mono text-cyan-400 bg-cyan-950 px-1 rounded-sm tracking-widest">{userStats.rank}</span>
                  </div>
                </div>
                <img
                  src={userStats.avatar}
                  alt={userStats.name}
                  onClick={() => {
                    const customName = prompt("আপনার ইউজারনেম পরিবর্তন করুন:", userStats.name);
                    if (customName && customName.trim()) {
                      setUserStats((v) => ({ ...v, name: customName.trim() }));
                    }
                  }}
                  className="w-8 h-8 rounded-full border border-slate-700 object-cover cursor-pointer hover:border-cyan-400"
                  title="Click to edit name"
                />
                <button
                  onClick={() => setIsLoggedIn(false)}
                  className="p-1 text-slate-500 hover:text-red-400 transition-colors cursor-pointer"
                  title="লগআউট করুন"
                >
                  <LogOut className="w-4 h-4" />
                </button>
              </div>
            ) : (
              <div className="flex items-center gap-2">
                {/* On mobile, show registrations button here */}
                <button
                  onClick={() => {
                    setAuthModalTab("register");
                    setShowAuthModal(true);
                  }}
                  className="md:hidden flex items-center gap-1 text-[11px] font-bold font-mono bg-emerald-950/60 hover:bg-emerald-900 border border-emerald-800/60 text-emerald-400 py-1.5 px-2.5 rounded cursor-pointer"
                >
                  রেজিস্ট্রেশন
                </button>
                <button
                  onClick={() => {
                    setAuthModalTab("login");
                    setShowAuthModal(true);
                  }}
                  className="flex items-center gap-1.5 text-xs font-mono font-bold uppercase bg-gradient-to-r from-cyan-600 to-indigo-600 hover:from-cyan-500 hover:to-indigo-500 text-slate-100 py-1.5 px-3.5 rounded border border-cyan-800 shadow-[0_0_10px_rgba(0,189,255,0.2)] cursor-pointer"
                >
                  <LogIn className="w-4 h-4" /> লগইন করুন
                </button>
              </div>
            )}
          </div>

        </div>
      </header>

      {/* CUSTOM RGB Separtor line */}
      <RGBBorder 
        height="h-[2.5px]" 
        disabled={!adminSettings.enableRgbEffects} 
        stylePreset={adminSettings.rgbStyle}
        speed={adminSettings.rgbEffectSpeed}
        activeColor={
          selectedMood === "green" ? "#39ff14" :
          selectedMood === "cyan" ? "#00f0ff" :
          selectedMood === "violet" ? "#bd00ff" :
          selectedMood === "crimson" ? "#ff003c" : "#eab308"
        } 
      />

      {/* SECONDARY NAVIGATION MENU AND LIVE STATS INDICATOR */}
      <menu className="bg-[#070b13] border-b border-cyan-950/40 sticky top-[57px] z-30 shadow-md">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 py-2.5 flex flex-col md:flex-row justify-between items-center gap-4">
          
          {/* Nav links left side */}
          <div className="flex flex-wrap items-center justify-center gap-1.5 sm:gap-2">
            <button
              id="menu-tab-home"
              onClick={() => setActiveTab("home")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "home"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Home className="w-3.5 h-3.5 text-cyan-500" /> হোম পেজ
            </button>
            <button
              id="menu-tab-add"
              onClick={() => setActiveTab("add")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "add"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Plus className="w-3.5 h-3.5 text-cyan-400" /> এড নিউ পোস্ট
            </button>
            <button
              id="menu-tab-tv"
              onClick={() => setActiveTab("tv")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "tv"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Tv className="w-3.5 h-3.5 text-emerald-400" /> লাইভ টিভি 📺
            </button>
            <button
              id="menu-tab-ai"
              onClick={() => setActiveTab("ai")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "ai"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Cpu className="w-3.5 h-3.5 text-amber-400 animate-pulse" /> এআই মায়া ✨
            </button>
            <button
              id="menu-tab-audiolab"
              onClick={() => setActiveTab("audiolab")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "audiolab"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Music className="w-3.5 h-3.5 text-violet-450 animate-pulse" /> নিয়েন মিউজিক ল্যাব 🎵
            </button>
            <button
              id="menu-tab-tools-lab"
              onClick={() => setActiveTab("tools-lab")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "tools-lab"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Wrench className="w-3.5 h-3.5 text-cyan-400 animate-pulse" />  টুলস ল্যাব 🧪
            </button>
            <button
              id="menu-tab-downloader"
              onClick={() => setActiveTab("downloader")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "downloader"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Video className="w-3.5 h-3.5 text-purple-400 animate-pulse" /> ভিডিও ডাউনলোডার 📥
            </button>
            {adminSettings.enableNewsSection !== false && (
              <button
                id="menu-tab-news"
                onClick={() => setActiveTab("news")}
                className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                  activeTab === "news"
                    ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                    : "text-emerald-400 hover:text-white"
                }`}
              >
                📰 এআই নিউজ সেন্টার
              </button>
            )}
            <button
              id="menu-tab-tools"
              onClick={() => setActiveTab("tools")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "tools"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Wrench className="w-3.5 h-3.5 text-cyan-400 animate-pulse" /> মেগা টুলস হাব 🛠️
            </button>
            <button
              id="menu-tab-dashboard"
              onClick={() => setActiveTab("dashboard")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "dashboard"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <User className="w-3.5 h-3.5 text-cyan-400" /> ড্যাশবোর্ড
            </button>
            <button
              id="menu-tab-profile"
              onClick={() => setActiveTab("profile")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "profile"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-[#ffae00] hover:text-white"
              }`}
            >
              <Award className="w-3.5 h-3.5 text-[#ffae00] animate-pulse" /> প্রোফাইল সম্পাদন (১৫০XP বোনাস)
            </button>
            <button
              id="menu-tab-messages"
              onClick={() => setActiveTab("messages")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "messages"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-cyan-400 hover:text-white"
              }`}
            >
              <MessageSquare className="w-3.5 h-3.5 text-cyan-400 animate-pulse" /> মেসেঞ্জার চ্যাট 💬
            </button>
            <button
              id="menu-tab-admin"
              onClick={() => setActiveTab("admin")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "admin"
                  ? "bg-[#1c1204] border border-amber-500 text-slate-100"
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              🔧 এডমিন সেটিং
            </button>
            <a
              id="menu-tab-download-theme"
              href={`${window.location.origin}/api/wordpress/download-fixed-theme`}
              onClick={(e) => {
                e.preventDefault();
                window.open(`${window.location.origin}/api/wordpress/download-fixed-theme`, '_blank');
              }}
              download="ilybd-neon-v1-pro-fixed.zip"
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer bg-emerald-950/80 border border-emerald-500 text-emerald-300 hover:bg-emerald-900 shadow-[0_0_10px_rgba(16,185,129,0.3)] font-semibold"
            >
              <ShieldCheck className="w-3.5 h-3.5 text-emerald-400" /> Theme (Theme Zip) 📥
            </a>
            <a
              id="menu-tab-download-plugin"
              href={`${window.location.origin}/api/wordpress/download-fixed-plugin`}
              onClick={(e) => {
                e.preventDefault();
                window.open(`${window.location.origin}/api/wordpress/download-fixed-plugin`, '_blank');
              }}
              download="ilybd-prime-engine-fixed.zip"
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer bg-blue-950/80 border border-blue-500 text-blue-300 hover:bg-blue-900 shadow-[0_0_10px_rgba(59,130,246,0.3)] font-semibold"
            >
              <Cpu className="w-3.5 h-3.5 text-blue-450" /> Plugin (Engine Zip) 🔌
            </a>
          </div>

          {/* Wallet Balance, Notification icon right side */}
          <div className="flex items-center gap-4 shrink-0">
            <div className="flex items-center gap-2 text-xs font-mono bg-slate-950 border border-cyan-950 py-1.5 px-3.5 rounded-lg">
              <Wallet className="w-4 h-4 text-emerald-400 animate-pulse" />
              <span>ব্যালেন্স:</span>
              <span className={`font-bold ${styleProfile.textAccent}`}>{userStats.balance} ৳</span>
              <span className="text-slate-500 font-normal">|</span>
              <span className="text-slate-400">{userStats.points} Points</span>
            </div>

             {/* Notification button dropdown */}
            <div className="relative">
              <button
                id="btn-notif-dropdown"
                onClick={() => {
                  setShowNotifDropdown(!showNotifDropdown);
                  // Mark all notifications as read upon opening
                  if (!showNotifDropdown) {
                    setNotifs((prev) => prev.map((n) => ({ ...n, read: true })));
                  }
                }}
                className="relative p-2 rounded-lg bg-[#0c1320] border border-cyan-950 hover:border-cyan-500 transition-colors cursor-pointer"
              >
                <Bell className="w-4 h-4 text-cyan-400" />
                {notifs.filter((n) => !n.read).length > 0 && (
                  <span className="absolute -top-1.5 -right-1.5 bg-red-500 text-white font-mono text-[9px] font-bold h-4 w-4 rounded-full flex items-center justify-center animate-pulse border border-slate-900">
                    {notifs.filter((n) => !n.read).length}
                  </span>
                )}
              </button>

              {/* Expandable Notification Portal */}
              <AnimatePresence>
                {showNotifDropdown && (
                  <motion.div
                    className="absolute right-0 mt-2 w-80 bg-[#070b14] border border-cyan-500/30 rounded-xl shadow-2xl p-4 z-50 text-left overflow-hidden"
                    initial={{ opacity: 0, y: 15 }}
                    animate={{ opacity: 1, y: 0 }}
                    exit={{ opacity: 0, y: 15 }}
                  >
                    <div className="flex justify-between items-center border-b border-cyan-950 pb-2 mb-2 font-mono text-xs text-slate-300">
                      <span className="font-bold uppercase tracking-wider">রিয়েল-টাইম নোটিফিকেশন</span>
                      <button
                        onClick={() => setNotifs([])}
                        className="text-[10px] text-red-400 hover:text-red-300"
                      >
                        ক্লিয়ার
                      </button>
                    </div>

                    <div className="space-y-2.5 max-h-56 overflow-y-auto custom-scrollbar">
                      {notifs.length === 0 ? (
                        <div className="p-4 text-center text-[10px] text-slate-500 font-mono italic">
                          কোন আপডেট নোটিফিকেশন নেই।
                        </div>
                      ) : (
                        notifs.map((item) => (
                          <div
                            key={item.id}
                            className="p-2 rounded bg-[#0b121f] border border-cyan-950/40 text-[11px] leading-relaxed relative group"
                          >
                            <span className="block text-[8px] text-cyan-500 font-mono pb-0.5">{item.timestamp}</span>
                            <p className="text-slate-200 font-sans">{item.text}</p>
                            <button
                              onClick={() => handleClearNotifIdx(item.id)}
                              className="absolute right-1 top-1 text-[9px] text-slate-600 hover:text-red-400"
                            >
                              ✕
                            </button>
                          </div>
                        ))
                      )}
                    </div>
                  </motion.div>
                )}
              </AnimatePresence>
            </div>
          </div>

        </div>
      </menu>

      {/* CORE HERO CAROUSEL: TRENDING SLIDESHOW OPTIONS (হোম পেজ এ থাকলে শো করবে) */}
      {activeTab === "home" && !selectedPostId && (
        <section className="bg-slate-950 py-7 border-b border-cyan-950/40 relative overflow-hidden">
          {/* Neon digital gridlines decorations */}
          <div className="absolute inset-0 bg-[radial-gradient(#081729_1fr,transparent_1fr)] [background-size:24px_24px] opacity-10" />
          
          <div className="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div className="border border-cyan-500/30 p-1 rounded-2xl bg-[#090d16]/75 shadow-2xl overflow-hidden relative">
              
              {/* Prev and Next chevron floating buttons for sliding navigation */}
              <button
                onClick={() => setCurrentSlideIdx(prev => (prev - 1 + posts.length) % posts.length)}
                className="absolute left-2.5 top-1/2 -translate-y-1/2 z-20 bg-slate-950/80 hover:bg-cyan-900 border border-cyan-800 text-cyan-400 h-8 w-8 rounded-full flex items-center justify-center transition-all cursor-pointer shadow-[0_0_8px_rgba(0,240,255,0.4)]"
                title="পূর্ববর্তী পোস্ট"
              >
                ◀
              </button>
              <button
                onClick={() => setCurrentSlideIdx(prev => (prev + 1) % posts.length)}
                className="absolute right-2.5 top-1/2 -translate-y-1/2 z-20 bg-slate-950/80 hover:bg-cyan-900 border border-cyan-800 text-cyan-400 h-8 w-8 rounded-full flex items-center justify-center transition-all cursor-pointer shadow-[0_0_8px_rgba(0,240,255,0.4)]"
                title="পরবর্তী পোস্ট"
              >
                ▶
              </button>

              <AnimatePresence mode="wait">
                <motion.div
                  key={currentSlideIdx}
                  initial={{ opacity: 0, x: 50 }}
                  animate={{ opacity: 1, x: 0 }}
                  exit={{ opacity: 0, x: -50 }}
                  transition={{ duration: 0.3 }}
                  className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center px-4 md:px-12 py-3"
                >
                  {/* Visual slide thumbnail left */}
                  <div className="lg:col-span-6 relative aspect-[16/10] overflow-hidden rounded-xl">
                    <img
                      src={posts[currentSlideIdx].thumbnail}
                      alt={posts[currentSlideIdx].title}
                      className="w-full h-full object-cover transition-all hover:scale-105 duration-750"
                      referrerPolicy="no-referrer"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent" />
                    <div className="absolute bottom-4 left-4">
                      <span className="text-[9px] uppercase font-mono tracking-widest bg-yellow-400 text-slate-900 border border-yellow-500 font-bold px-2 py-0.5 rounded shadow">
                        ★ TRENDING POST
                      </span>
                    </div>
                  </div>

                  {/* Typography and metrics info slide right */}
                  <div className="lg:col-span-6 text-left p-4 sm:p-6">
                    <span className="text-[10px] font-mono uppercase tracking-wider text-cyan-400 inline-block bg-cyan-950/80 px-2 py-0.5 rounded border border-cyan-900">
                      {posts[currentSlideIdx].category}
                    </span>
                    
                    <h2 className="text-lg sm:text-2xl font-bold font-sans tracking-tight text-white mt-3 leading-snug">
                      {posts[currentSlideIdx].title}
                    </h2>
                    <p className="text-xs sm:text-sm text-slate-300 mt-2 line-clamp-3 leading-relaxed font-sans">
                      {posts[currentSlideIdx].excerpt}
                    </p>

                    <div className="mt-5 flex flex-wrap items-center gap-4 text-xs font-mono text-slate-400">
                      <span className="flex items-center gap-2">
                        <img
                          src={posts[currentSlideIdx].author.avatar}
                          alt="author"
                          className="w-5 h-5 rounded-full border border-slate-700"
                        />
                        <span className="text-slate-100 font-semibold">{posts[currentSlideIdx].author.name}</span>
                      </span>
                      <span>•</span>
                      <span>{posts[currentSlideIdx].views} ভিউস</span>
                      <span>•</span>
                      <span>{posts[currentSlideIdx].likes} লাইকস</span>
                    </div>
                    
                    <div className="mt-6 flex justify-between items-center">
                      <div className="flex gap-1.5">
                        {posts.map((_, i) => (
                          <button
                            key={i}
                            onClick={() => setCurrentSlideIdx(i)}
                            className={`h-1.5 rounded transition-all ${i === currentSlideIdx ? "w-6 bg-cyan-400" : "w-1.5 bg-slate-800"}`}
                          />
                        ))}
                      </div>
                      
                      <button
                        id="btn-discover-slider"
                        onClick={() => {
                          setSelectedPostId(posts[currentSlideIdx].id);
                          document.getElementById("main-feed-header")?.scrollIntoView({ behavior: "smooth" });
                        }}
                        className={`text-xs font-mono py-1.5 px-4 bg-gradient-to-r ${styleProfile.btnGradient} text-[#070b13] font-bold rounded shadow cursor-pointer hover:opacity-90`}
                      >
                        কন্টেন্টটি পড়ুন
                      </button>
                    </div>
                  </div>
                </motion.div>
              </AnimatePresence>

            </div>
          </div>
        </section>
      )}

      {/* CORE DISPLAY PAGES CONTAINER */}
      <main className="max-w-7xl mx-auto px-4 sm:px-6 py-4 md:py-8">
        <AnimatePresence mode="wait">
          
          {/* Tab 1: Home dashboard standard list */}
          {activeTab === "home" && (
            <motion.div
              key="home"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="space-y-6 md:space-y-10"
            >
              <div className="flex flex-col lg:flex-row gap-6 items-start">
                
                {/* Left side column: list and search filter */}
                <div className="lg:col-span-8 flex-1 w-full space-y-6">

                  {/* STORIES CAROUSEL SHELF */}
                  {adminSettings.enableStories !== false && !selectedPostId && (
                    <div id="stories-shelf-container" className="bg-[#090d16] border border-cyan-950/80 p-4 rounded-2xl relative overflow-hidden shadow-xl">
                      <div className="absolute inset-0 bg-gradient-to-r from-cyan-950/10 via-transparent to-pink-950/5 pointer-events-none" />
                      
                      <div className="flex items-center gap-4 overflow-x-auto pb-1.5 scrollbar-none custom-scrollbar select-none">
                        
                        {/* Current User Story (আমার স্টোরী) */}
                        <div className="flex flex-col items-center gap-1.5 cursor-pointer group shrink-0 relative">
                          <div 
                            onClick={() => {
                              const myStory = stories.find(s => s.username === userStats.name);
                              if (myStory) {
                                setActiveStoryViewer(myStory);
                              } else {
                                setShowUploadStoryModal(true);
                              }
                            }}
                            className="relative w-16 h-16 sm:w-18 sm:h-18 rounded-full p-[3px] bg-gradient-to-tr from-cyan-500 via-indigo-500 to-purple-600 group-hover:scale-105 transition-all duration-300 shadow-[0_0_15px_rgba(0,240,255,0.15)] flex items-center justify-center overflow-visible"
                          >
                            <div className="w-full h-full rounded-full border border-slate-950 overflow-hidden bg-slate-900">
                              <img 
                                src={userStats.avatar} 
                                alt="My Avatar" 
                                className="w-full h-full object-cover rounded-full"
                              />
                            </div>
                            
                            {/* Green plus badge */}
                            <div 
                              onClick={(e) => {
                                e.stopPropagation();
                                setShowUploadStoryModal(true);
                              }}
                              className="absolute bottom-1 right-1 bg-emerald-500 text-slate-950 border-2 border-slate-900 w-5 h-5 rounded-full flex items-center justify-center font-black text-xs hover:bg-emerald-400 cursor-pointer shadow-md"
                              title="স্টোরী আপলোড করুন"
                            >
                              +
                            </div>
                          </div>
                          <span className="text-[10px] sm:text-xs font-semibold text-slate-300 font-sans tracking-tight">আমার স্টোরী</span>
                        </div>

                        {/* Subsequent Community Stories */}
                        {stories.map((story) => (
                          <div 
                            key={story.id}
                            onClick={() => setActiveStoryViewer(story)}
                            className="flex flex-col items-center gap-1.5 cursor-pointer group shrink-0"
                          >
                            <div className="relative w-16 h-16 sm:w-18 sm:h-18 rounded-full p-[3px] bg-[#070b13] border-2 border-cyan-500/20 group-hover:border-cyan-400 group-hover:scale-105 transition-all duration-300 flex items-center justify-center shadow-[0_0_8px_rgba(0,0,0,0.5)]">
                              {/* Glowing unread indicator rings */}
                              <div className="absolute inset-0.5 rounded-full border border-dashed border-cyan-400 animate-spin-slow pointer-events-none opacity-40 group-hover:opacity-80" />
                              <div className="w-[calc(100%-8px)] h-[calc(100%-8px)] rounded-full overflow-hidden bg-slate-950 border border-slate-900">
                                <img 
                                  src={story.userAvatar} 
                                  alt={story.username} 
                                  className="w-full h-full object-cover rounded-full bg-slate-900"
                                />
                              </div>
                            </div>
                            <span className="text-[10px] sm:text-xs font-semibold text-slate-300 font-sans tracking-tight truncate max-w-16 sm:max-w-[72px] text-center">{story.username}</span>
                          </div>
                        ))}

                      </div>
                    </div>
                  )}
                  
                  {/* Category select filter and search bar portal */}
                  {!selectedPostId && (
                    <div id="main-feed-header" className="bg-[#090d16] border border-cyan-950 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div className="flex items-center gap-1.5 overflow-x-auto w-full sm:w-auto pb-2 sm:pb-0 custom-scrollbar">
                      {["All", "Hacking", "SEO Guide", "Online Earning", "Android Tech"].map((cat) => (
                        <button
                          key={cat}
                          onClick={() => setSelectedCategory(cat)}
                          className={`text-xs font-mono px-3 py-1.5 rounded transition-all shrink-0 cursor-pointer ${
                            selectedCategory === cat
                              ? "bg-cyan-950 text-[#00f0ff] border border-cyan-800/60 shadow"
                              : "text-slate-400 hover:text-slate-100"
                          }`}
                        >
                          {cat}
                        </button>
                      ))}
                    </div>

                    <div className="relative w-full sm:w-85 md:w-[420px]" id="global-search-container">
                      <Search className="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-cyan-400 animate-pulse" />
                      <input
                        type="text"
                        value={postSearchQuery}
                        onChange={(e) => {
                          setPostSearchQuery(e.target.value);
                          setShowSearchDropdown(true);
                        }}
                        onFocus={() => setShowSearchDropdown(true)}
                        placeholder={isSearchVoiceActive ? "শুনছি... বলুন..." : "কন্টেন্ট বা ফোরাম প্রশ্ন খুঁজুন..."}
                        className={`w-full text-xs font-mono bg-slate-950 border rounded-lg pl-10 pr-16 py-2.5 focus:outline-none text-slate-100 placeholder-slate-500 transition-all duration-300 shadow-[inset_0_2px_10px_rgba(0,0,0,0.8)] ${
                          isSearchVoiceActive 
                            ? "border-[#00f0ff] ring-2 ring-cyan-500/30 animate-pulse bg-cyan-950/20" 
                            : "border-cyan-950 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-500/30"
                        }`}
                      />
                      
                      {/* Active Actions inside search bar */}
                      <div className="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1.5 z-10">
                        {postSearchQuery && (
                          <button
                            onClick={() => {
                              setPostSearchQuery("");
                              setShowSearchDropdown(false);
                            }}
                            className="text-slate-500 hover:text-slate-300 text-xs font-mono hover:scale-110 transition-transform cursor-pointer p-1"
                          >
                            ✕
                          </button>
                        )}
                        
                        <button
                          type="button"
                          onClick={startSearchVoiceInput}
                          className={`p-1.5 rounded-md border flex items-center justify-center transition-all cursor-pointer ${
                            isSearchVoiceActive
                              ? "bg-red-500/20 border-red-500 text-red-400 animate-pulse"
                              : "bg-cyan-950/40 border-cyan-800/30 text-cyan-400 hover:bg-cyan-500/10 hover:border-cyan-400/50"
                          }`}
                          title="ভয়েস দিয়ে সার্চ করুন (বাংলা/English)"
                        >
                          <Mic className="w-3.5 h-3.5" />
                        </button>
                      </div>

                      {/* STUNNING REAL-TIME SEARCH RESULTS OVERLAY PANEL */}
                      <AnimatePresence>
                        {showSearchDropdown && (
                          <motion.div
                            initial={{ opacity: 0, y: 10 }}
                            animate={{ opacity: 1, y: 0 }}
                            exit={{ opacity: 0, y: 10 }}
                            className="absolute top-full left-0 right-0 mt-2 bg-[#080d17] border border-cyan-500/35 rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.95)] z-50 overflow-hidden backdrop-blur-xl max-h-[460px] overflow-y-auto custom-scrollbar flex flex-col divide-y divide-cyan-950/60"
                          >
                            {postSearchQuery.trim().length === 0 ? (
                              /* SPOTLIGHT PORTAL SHORTCUTS & SUGGESTIONS */
                              <div className="p-3 text-left space-y-4">
                                <div className="space-y-1.5">
                                  <div className="text-[9.5px] font-mono tracking-widest text-[#00f0ff] uppercase px-1.5 font-bold flex items-center gap-1">
                                    <span className="w-1.5 h-1.5 bg-[#00f0ff] rounded-full animate-ping" />
                                    ⚡ ওয়ান-ক্লিক কুইক মডিউল রাউটার
                                  </div>
                                  <div className="grid grid-cols-2 gap-1.5">
                                    <button
                                      type="button"
                                      onClick={() => { setActiveTab("home"); setShowSearchDropdown(false); }}
                                      className="flex items-center gap-2 p-2 bg-slate-950/60 border border-cyan-900/15 hover:border-[#00f0ff] rounded-lg text-[11px] font-sans hover:bg-cyan-950/15 text-slate-300 hover:text-[#00f0ff] transition-all text-left"
                                    >
                                      <span>📖</span> হোম কন্টেন্ট পোর্টাল
                                    </button>
                                    <button
                                      type="button"
                                      onClick={() => { setActiveTab("ai"); setShowSearchDropdown(false); }}
                                      className="flex items-center gap-2 p-2 bg-slate-950/60 border border-cyan-900/15 hover:border-[#39ff14] rounded-lg text-[11px] font-sans hover:bg-emerald-950/15 text-slate-300 hover:text-[#39ff14] transition-all text-left"
                                    >
                                      <span>🧪</span> এআই রাইডার ও মায়া চ্যাট
                                    </button>
                                    <button
                                      type="button"
                                      onClick={() => { setActiveTab("qa"); setShowSearchDropdown(false); }}
                                      className="flex items-center gap-2 p-2 bg-slate-950/60 border border-cyan-900/15 hover:border-purple-500 rounded-lg text-[11px] font-sans hover:bg-purple-950/15 text-slate-300 hover:text-purple-400 transition-all text-left"
                                    >
                                      <span>💬</span> ফোরাম সিকিউরিটি ক্যোয়ারী
                                    </button>
                                    <button
                                      type="button"
                                      onClick={() => { setActiveTab("nid"); setShowSearchDropdown(false); }}
                                      className="flex items-center gap-2 p-2 bg-slate-950/60 border border-cyan-900/15 hover:border-[#39ff14] rounded-lg text-[11px] font-sans hover:bg-emerald-950/15 text-slate-300 hover:text-[#39ff14] transition-all text-left"
                                    >
                                      <span>🎴</span> এনআইডি কার্ড জেনারেটর
                                    </button>
                                    <button
                                      type="button"
                                      onClick={() => { setActiveTab("dashboard"); setShowSearchDropdown(false); }}
                                      className="flex items-center gap-2 p-2 bg-slate-950/60 border border-cyan-900/15 hover:border-yellow-500 rounded-lg text-[11px] font-sans hover:bg-yellow-950/15 text-slate-300 hover:text-yellow-400 transition-all text-left"
                                    >
                                      <span>💳</span> বিকাশ আর্নিং ড্যাশবোর্ড
                                    </button>
                                    <button
                                      type="button"
                                      onClick={() => { setActiveTab("downloader"); setShowSearchDropdown(false); }}
                                      className="flex items-center gap-2 p-2 bg-slate-950/60 border border-cyan-900/15 hover:border-rose-500 rounded-lg text-[11px] font-sans hover:bg-rose-950/15 text-slate-300 hover:text-rose-400 transition-all text-left"
                                    >
                                      <span>🎬</span> ইউটিউব ভিডিও ডাউনলোডার
                                    </button>
                                    <button
                                      type="button"
                                      onClick={() => { setActiveTab("audiolab"); setShowSearchDropdown(false); }}
                                      className="flex items-center gap-2 p-2 bg-slate-950/60 border border-cyan-900/15 hover:border-cyan-500 rounded-lg text-[11px] font-sans hover:bg-cyan-950/15 text-slate-300 hover:text-cyan-400 transition-all text-left"
                                    >
                                      <span>🎧</span> কোয়ান্টাম অডিও ল্যাব
                                    </button>
                                    <button
                                      type="button"
                                      onClick={() => { setActiveTab("tools-lab"); setShowSearchDropdown(false); }}
                                      className="flex items-center gap-2 p-2 bg-slate-950/60 border border-cyan-900/15 hover:border-[#00f0ff] rounded-lg text-[11px] font-sans hover:bg-[#00f0ff]/10 text-slate-300 hover:text-[#00f0ff] transition-all text-left"
                                    >
                                      <span>🛠️</span> ইউনিক অ্যাডভান্সড টুলস
                                    </button>
                                  </div>
                                </div>

                                <div className="space-y-2 pt-2 border-t border-cyan-950/40">
                                  <div className="text-[9.5px] font-mono tracking-widest text-[#39ff14] uppercase px-1.5 font-bold">
                                    🔥 জনপ্রিয় সার্চ কী-ওয়ার্ডসমূহ
                                  </div>
                                  <div className="flex flex-wrap gap-1.5 px-1">
                                    {[
                                      { l: "গুগল এডসেন্স", k: "এডসেন্স" },
                                      { l: "হ্যাকিং ডিফেন্স গাইড", k: "হ্যাকিং" },
                                      { l: "বিকাশ মানি আর্নিং", k: "আর্নিং" },
                                      { l: "ফ্রি ভিডিও ডাউনলোডার", k: "ডাউনলোডার" },
                                      { l: "মায়া চ্যাট সহায়ক ও এআই", k: "মায়া" },
                                      { l: "এসইও র‍্যাংকিং অডিট", k: "এসইও" }
                                    ].map((tagObj, idx) => (
                                      <button
                                        key={idx}
                                        type="button"
                                        onClick={() => {
                                          setPostSearchQuery(tagObj.k);
                                        }}
                                        className="text-[10.5px] bg-[#0c1222] border border-cyan-950 text-slate-300 hover:text-[#00f0ff] hover:border-cyan-500/30 px-2.5 py-1.5 rounded-lg font-sans transition-all cursor-pointer"
                                      >
                                        🔍 {tagObj.l}
                                      </button>
                                    ))}
                                  </div>
                                </div>
                              </div>
                            ) : (
                              /* ACTIVE SEARCH RESULTS SEGMENTS WITH DIRECT TOOL ROUTING */
                              <>
                                {/* Search statistics header */}
                                <div className="bg-[#0b1222] px-4 py-2 flex justify-between items-center text-[10px] text-slate-450 font-mono">
                                  <span>খোঁজা হচ্ছে: <strong className="text-cyan-400">"{postSearchQuery}"</strong></span>
                                  <span>
                                    {(() => {
                                      let pCount = posts.filter(p => p.title.toLowerCase().includes(postSearchQuery.toLowerCase()) || p.excerpt.toLowerCase().includes(postSearchQuery.toLowerCase())).length;
                                      let qCount = questions.filter(q => q.title.toLowerCase().includes(postSearchQuery.toLowerCase())).length;
                                      let tMatches = 0;
                                      const qLow = postSearchQuery.toLowerCase();
                                      if (qLow.includes("video") || qLow.includes("downloader") || qLow.includes("ইউটিউব") || qLow.includes("ভিডিও") || qLow.includes("ডাউনলোড")) tMatches++;
                                      if (qLow.includes("nid") || qLow.includes("এনআইডি") || qLow.includes("কার্ড") || qLow.includes("স্মার্ট")) tMatches++;
                                      if (qLow.includes("audio") || qLow.includes("অডিও") || qLow.includes("গান") || qLow.includes("মেলোডি") || qLow.includes("সিন্থ")) tMatches++;
                                      if (qLow.includes("ai") || qLow.includes("জেমিনি") || qLow.includes("মায়া") || qLow.includes("চ্যাট")) tMatches++;
                                      return `${pCount + qCount + tMatches} টি ফলাফল`;
                                    })()}
                                  </span>
                                </div>

                                <div className="p-2 space-y-4">
                                  {/* --- DYNAMIC MATCHING: CYBER PORTAL TOOLS ROUTER --- */}
                                  {(() => {
                                    const tList: { id: string; name: string; desc: string; tab: string; emoji: string }[] = [];
                                    const qLow = postSearchQuery.toLowerCase();
                                    
                                    if (qLow.includes("video") || qLow.includes("downloader") || qLow.includes("ইউটিউব") || qLow.includes("ভিডিও") || qLow.includes("ডাউনলোড")) {
                                      tList.push({ id: "t-1", name: "ইউটিউব ও ফেসবুক ভিডিও ডাউনলোডার", desc: "হাই-স্পিড ভিডিও ও রিলেটেড মাল্টিমিডিয়া সরাসরি ডাউনলোড করার সুপার হাব!", tab: "downloader", emoji: "🎬" });
                                    }
                                    if (qLow.includes("audio") || qLow.includes("অডিও") || qLow.includes("গান") || qLow.includes("মেলোডি") || qLow.includes("সিন্থ")) {
                                      tList.push({ id: "t-3", name: "কোয়ান্টাম অডিও ল্যাব সিন্থেসাইজার", desc: "প্রফেশনাল সাইবার সাউন্ড মেলোডি এবং ব্যাকগ্রাউন্ড রিদম জেনারেটর।", tab: "audiolab", emoji: "🎧" });
                                    }
                                    if (qLow.includes("ai") || qLow.includes("জেমিনি") || qLow.includes("মায়া") || qLow.includes("চ্যাট")) {
                                      tList.push({ id: "t-4", name: "মায়া এআই চ্যাট অ্যাসিস্ট্যান্ট (Gemini)", desc: "উন্নত জেমিনি মডেলের হাই-ব্রেইন এআই কন্টেন্ট ক্রিয়েটর ও চ্যাট রাইটার!", tab: "ai", emoji: "🧪" });
                                    }

                                    return (
                                      tList.length > 0 && (
                                        <div className="space-y-1.5">
                                          <div className="text-[9.5px] font-mono tracking-wider text-[#39ff14] uppercase px-2 font-bold flex items-center gap-1.5">
                                            <span className="w-1.5 h-1.5 bg-[#39ff14] rounded-full animate-ping" />
                                            🛠️ সিস্টেম ইন্টিগ্রেটেড সাইবার টুলস ({tList.length})
                                          </div>
                                          <div className="space-y-1">
                                            {tList.map(t => (
                                              <div
                                                key={t.id}
                                                onClick={() => {
                                                  setActiveTab(t.tab as any);
                                                  setShowSearchDropdown(false);
                                                }}
                                                className="p-2.5 rounded-lg bg-emerald-950/30 hover:bg-[#39ff14]/15 border border-[#163f19] hover:border-[#39ff14]/40 cursor-pointer transition-all duration-200 text-left"
                                              >
                                                <div className="flex justify-between items-start gap-2">
                                                  <h5 className="text-[12px] font-semibold text-slate-100 hover:text-[#39ff14] font-sans line-clamp-1">
                                                    {t.emoji} {t.name}
                                                  </h5>
                                                  <span className="text-[8px] font-mono font-medium text-[#39ff14] bg-emerald-950/70 border border-[#215a25] px-1.5 py-0.5 rounded shrink-0">
                                                    ACTIVE TOOL
                                                  </span>
                                                </div>
                                                <p className="text-[10px] text-slate-400 font-sans line-clamp-1 mt-0.5">
                                                  {t.desc}
                                                </p>
                                              </div>
                                            ))}
                                          </div>
                                        </div>
                                      )
                                    );
                                  })()}

                                  {/* --- CATEGORY A: TUTORIAL POSTS --- */}
                                  {(() => {
                                    const matchingPosts = posts.filter(p => 
                                      p.title.toLowerCase().includes(postSearchQuery.toLowerCase()) || 
                                      p.excerpt.toLowerCase().includes(postSearchQuery.toLowerCase()) ||
                                      p.category.toLowerCase().includes(postSearchQuery.toLowerCase())
                                    );

                                    return (
                                      matchingPosts.length > 0 && (
                                        <div className="space-y-1.5">
                                          <div className="text-[9.5px] font-mono tracking-wider text-cyan-400 uppercase px-2 font-bold flex items-center gap-1.5">
                                            <span className="w-1.5 h-1.5 bg-cyan-400 rounded-full animate-ping" />
                                            📖 ব্লগ পোস্ট ও টিউটোরিয়ালস ({matchingPosts.length})
                                          </div>
                                          <div className="space-y-1">
                                            {matchingPosts.slice(0, 5).map(post => (
                                              <div
                                                key={post.id}
                                                onClick={() => {
                                                  setSelectedPostId(post.id);
                                                  setActiveTab("home");
                                                  setShowSearchDropdown(false);
                                                }}
                                                className="p-2.5 rounded-lg bg-slate-950/60 hover:bg-cyan-950/45 border border-transparent hover:border-cyan-900/30 cursor-pointer transition-all duration-200 text-left"
                                              >
                                                <div className="flex justify-between items-start gap-2">
                                                  <h5 className="text-[12px] font-semibold text-slate-100 hover:text-cyan-400 font-sans line-clamp-1">
                                                    {post.title}
                                                  </h5>
                                                  <span className="text-[8px] font-mono font-medium text-emerald-400 bg-emerald-950/70 border border-emerald-900/40 px-1.5 py-0.5 rounded shrink-0">
                                                    {post.category}
                                                  </span>
                                                </div>
                                                <p className="text-[10px] text-slate-400 font-sans line-clamp-1 mt-0.5">
                                                  {post.excerpt}
                                                </p>
                                              </div>
                                            ))}
                                          </div>
                                        </div>
                                      )
                                    );
                                  })()}

                                  {/* --- CATEGORY B: COMMUNITY Q&A QUESTIONS --- */}
                                  {(() => {
                                    const matchingQuestions = questions.filter(q => 
                                      q.title.toLowerCase().includes(postSearchQuery.toLowerCase()) || 
                                      q.category.toLowerCase().includes(postSearchQuery.toLowerCase()) ||
                                      q.answers.some(ans => ans.text.toLowerCase().includes(postSearchQuery.toLowerCase()))
                                    );

                                    return (
                                      matchingQuestions.length > 0 && (
                                        <div className="space-y-1.5 pt-2">
                                          <div className="text-[9.5px] font-mono tracking-wider text-purple-400 uppercase px-2 font-bold flex items-center gap-1.5">
                                            <span className="w-1.5 h-1.5 bg-purple-500 rounded-full animate-ping" />
                                            💬 ফোরাম প্রশ্নোত্তর ({matchingQuestions.length})
                                          </div>
                                          <div className="space-y-1">
                                            {matchingQuestions.slice(0, 5).map(q => (
                                              <div
                                                key={q.id}
                                                onClick={() => {
                                                  setSelectedQuestionId(q.id);
                                                  setActiveTab("qa");
                                                  setShowSearchDropdown(false);
                                                }}
                                                className="p-2.5 rounded-lg bg-slate-950/60 hover:bg-purple-950/30 border border-transparent hover:border-purple-900/30 cursor-pointer transition-all duration-200 text-left"
                                              >
                                                <div className="flex justify-between items-start gap-2">
                                                  <h5 className="text-[12px] font-semibold text-slate-100 hover:text-purple-300 font-sans line-clamp-1">
                                                    {q.title}
                                                  </h5>
                                                  <span className="text-[8px] font-mono font-medium text-purple-400 bg-purple-950/60 border border-purple-900/40 px-1.5 py-0.5 rounded shrink-0">
                                                    {q.category}
                                                  </span>
                                                </div>
                                                <div className="flex items-center gap-3 mt-1.5 text-[9px] text-slate-500 font-mono">
                                                  <span>প্রশ্নকারী: <b className="text-slate-400">{q.author}</b></span>
                                                  <span>•</span>
                                                  <span className="text-purple-450 font-semibold">{q.votes}টি ভোট</span>
                                                  <span>•</span>
                                                  <span className="text-cyan-455 font-semibold">{q.answers.length}টি সমাধান</span>
                                                </div>
                                              </div>
                                            ))}
                                          </div>
                                        </div>
                                      )
                                    );
                                  })()}

                                  {/* --- ZERO RESULTS FALLBACK --- */}
                                  {(() => {
                                    let pCount = posts.filter(p => p.title.toLowerCase().includes(postSearchQuery.toLowerCase() || p.excerpt.toLowerCase().includes(postSearchQuery.toLowerCase()))).length;
                                    let qCount = questions.filter(q => q.title.toLowerCase().includes(postSearchQuery.toLowerCase())).length;
                                    
                                    let tMatches = 0;
                                    const qLow = postSearchQuery.toLowerCase();
                                    if (qLow.includes("video") || qLow.includes("downloader") || qLow.includes("ইউটিউব") || qLow.includes("ভিডিও") || qLow.includes("ডাউনলোড")) tMatches++;
                                    if (qLow.includes("audio") || qLow.includes("অডিও") || qLow.includes("গান") || qLow.includes("মেলোডি") || qLow.includes("সিন্থ")) tMatches++;
                                    if (qLow.includes("ai") || qLow.includes("জেমিনি") || qLow.includes("মায়া") || qLow.includes("চ্যাট")) tMatches++;

                                    if (pCount === 0 && qCount === 0 && tMatches === 0) {
                                      return (
                                        <div className="p-8 text-center space-y-2">
                                          <div className="text-amber-500 text-base font-bold font-mono">⚠️ দুঃখিত! কোশ্চেন বা পোস্ট পাওয়া যায়নি</div>
                                          <p className="text-[11px] text-slate-400 font-sans">
                                            আপনার দেওয়া কী-ওয়ার্ড <strong className="text-cyan-400 font-mono">"{postSearchQuery}"</strong> দিয়ে কোনো কন্টেন্ট বা ওয়ান-টাচ ফোরাম প্রশ্নোত্তর পাওয়া যায়নি।
                                          </p>
                                        </div>
                                      );
                                    }
                                    return null;
                                  })()}
                                </div>
                              </>
                            )}
                          </motion.div>
                        )}
                      </AnimatePresence>
                    </div>
                  </div>
                  )}

                  {/* TIMELINE TIMELINE ARTICLES FEED SHIELD */}
                  {selectedPostId ? (
                    (() => {
                      const post = posts.find((p) => p.id === selectedPostId);
                      if (!post) return null;
                      return (
                        <motion.div
                          initial={{ opacity: 0, y: 15 }}
                          animate={{ opacity: 1, y: 0 }}
                          className="bg-[#090d16]/90 border border-cyan-950 rounded-2xl p-6 shadow-2xl relative overflow-hidden text-left space-y-6"
                        >
                          {/* Back Button */}
                          <div className="flex justify-between items-center border-b border-cyan-950 pb-4">
                            <button
                              onClick={() => setSelectedPostId(null)}
                              className="text-xs font-mono font-bold bg-slate-950 hover:bg-cyan-950 text-cyan-450 px-4 py-2 rounded-xl border border-cyan-950 cursor-pointer transition-all flex items-center gap-2"
                            >
                              ← ফিরে যান
                            </button>
                            <span className="text-xs font-mono text-slate-500">{post.timestamp}</span>
                          </div>

                          <div className="space-y-4">
                            <div className="relative aspect-[21/9] rounded-xl overflow-hidden bg-slate-950 border border-cyan-950">
                              <img
                                src={post.thumbnail}
                                alt={post.title}
                                className="w-full h-full object-cover"
                                referrerPolicy="no-referrer"
                              />
                              <span className="absolute top-3 left-3 text-[10px] uppercase font-mono font-bold bg-[#070b13]/85 text-[#00f0ff] border border-cyan-800 rounded px-2.5 py-1 backdrop-blur-md">
                                {post.category}
                              </span>
                            </div>

                            {/* Author & Reader Font Size toolbar */}
                            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-[#050912]/80 border border-cyan-950/60 p-3 rounded-xl">
                              <div className="flex items-center gap-3">
                                <img
                                  src={post.author.avatar}
                                  alt={post.author.name}
                                  className="w-10 h-10 rounded-full border border-cyan-600/30 object-cover cursor-pointer"
                                />
                                <div className="text-left">
                                  <div className="text-xs font-bold text-slate-100 flex items-center gap-1.5">
                                    <span>{post.author.name}</span>
                                    {post.author.isAI && (
                                      <span className="bg-cyan-950 text-cyan-400 text-[9px] border border-cyan-800 px-1.5 rounded">AI Writer</span>
                                    )}
                                  </div>
                                  <span className={`text-[10px] ${styleProfile.textAccent} font-mono uppercase`}>{post.author.rank}</span>
                                </div>
                              </div>

                              {/* Reader Control Buttons */}
                              <div className="flex items-center gap-2 font-mono text-[10px] font-bold text-slate-400 uppercase">
                                <button
                                  onClick={() => {
                                    if (isSpeakingPost) {
                                      window.speechSynthesis.cancel();
                                      setIsSpeakingPost(false);
                                    } else {
                                      const utterance = new SpeechSynthesisUtterance(`${post.title}. ${post.content}`);
                                      utterance.lang = "bn-BD";
                                      utterance.onend = () => setIsSpeakingPost(false);
                                      window.speechSynthesis.speak(utterance);
                                      setIsSpeakingPost(true);
                                    }
                                  }}
                                  className={`flex items-center gap-1 px-3 py-1.5 rounded-lg border transition-all cursor-pointer ${
                                    isSpeakingPost
                                      ? "bg-cyan-950 border-cyan-400 text-[#00f0ff] animate-pulse"
                                      : "bg-slate-950 border-cyan-950 hover:bg-cyan-950/40 text-slate-300"
                                  }`}
                                  title={isSpeakingPost ? "থামুন" : "শুনুন (Text-to-Speech)"}
                                >
                                  {isSpeakingPost ? <Square className="w-3.5 h-3.5" fill="currentColor" /> : <Volume2 className="w-3.5 h-3.5" />}
                                  {isSpeakingPost ? "শুনছেন..." : "শুনুন"}
                                </button>
                                
                                <span className="ml-2">টেক্সট ফন্ট সাইজ:</span>
                                <div className="flex bg-slate-950 border border-cyan-950 rounded-lg p-0.5">
                                  {(["text-xs", "text-sm", "text-base", "text-lg"] as const).map((sz) => (
                                    <button
                                      key={sz}
                                      type="button"
                                      onClick={() => setActiveFontSizeClass(sz)}
                                      className={`px-2.5 py-1 rounded cursor-pointer ${
                                        activeFontSizeClass === sz
                                          ? "bg-cyan-900/60 text-[#00f0ff] border border-cyan-800/40"
                                          : "hover:text-white"
                                      }`}
                                    >
                                      {sz === "text-xs" ? "A-" : sz === "text-sm" ? "A" : sz === "text-base" ? "A+" : "A++"}
                                    </button>
                                  ))}
                                </div>
                              </div>
                            </div>

                            {/* ADSENSE UNIT SLOT 1: Header Banner (Compliance Safety >20px) */}
                            {adminSettings.enableGoogleAds && (
                              <div className="my-6 p-4 bg-slate-950/90 border-t border-b border-dashed border-cyan-500/10 rounded-lg text-center space-y-1 select-none">
                                <span className="text-[8px] font-mono text-slate-600 uppercase tracking-widest block font-bold">
                                  — ADVERTISEMENT - গুগল এডসেন্স স্পন্সরড ব্যানার বিজ্ঞাপন —
                                </span>
                                <div className="text-[11px] font-mono text-cyan-500/70 p-2 italic leading-relaxed">
                                  {adminSettings.advertisementSnippet || "Google AdSense Responsive Unit - 728x90 Auto Safe"}
                                </div>
                              </div>
                            )}

                            {/* Table of Contents Indexing Box */}
                            <div className="bg-[#040811] border border-cyan-950/60 rounded-xl p-4 space-y-2.5 text-left font-sans">
                              <h4 className="text-xs font-bold font-mono text-cyan-400 uppercase tracking-wider flex items-center gap-1.5 border-b border-cyan-950/60 pb-1.5">
                                📋 কন্টেন্ট সূচিপত্র ও দ্রুত রিডার ন্যাভিগেশন
                              </h4>
                              <ul className="text-[11px] text-slate-400 space-y-1.5 pl-3 list-decimal leading-relaxed">
                                <li>
                                  <span className="hover:text-[#00f0ff] cursor-pointer transition-colors block">
                                    ভূমিকা ও প্রযুক্তি পরিচিতি (Brief Introduction to {post.category})
                                  </span>
                                </li>
                                <li>
                                  <span className="hover:text-[#00f0ff] cursor-pointer transition-colors block">
                                    এই কন্টেন্টের মূল আকর্ষণসমূহ (Target Key Highlights)
                                  </span>
                                </li>
                                <li>
                                  <span className="hover:text-[#00f0ff] cursor-pointer transition-colors block">
                                    গভীর বিশ্লেষণ ও সিকিউরিটি নির্দেশনা (Implementation Methodology)
                                  </span>
                                </li>
                                <li>
                                  <span className="hover:text-[#00f0ff] cursor-pointer transition-colors block">
                                    মন্তব্যসমূহ ও ক্রিয়েশন ফিডব্যাক (Community Panel)
                                  </span>
                                </li>
                              </ul>
                            </div>

                            {/* Key Highlights box */}
                            <div className="bg-[#051114] border border-cyan-500/20 border-l-[3px] border-l-[#00f0ff] p-4 rounded-r-xl text-left space-y-1.5">
                              <span className="text-[10px] font-mono font-bold text-[#00f0ff] uppercase tracking-widest block font-sans">
                                ✨ কন্টেন্টের মূল আকর্ষণসমূহ (Cheat Sheets)
                              </span>
                              <div className="text-xs text-slate-300 font-sans leading-relaxed space-y-1">
                                <p>• ১০০% জেনুইন বাংলাদেশি কন্টেন্ট পাবলিশার গাইডলাইন অনুসরণ করে রচিত।</p>
                                <p>• গুগল সার্ভিস ক্রল ফ্রেন্ডলি ও ইনস্ট্যান্ট ডমিন মেটাবক্স ইনডেক্সিং ভেরিফাইড।</p>
                                <p>• ফোরাম মনিটাইজেশন স্কিম অনুযায়ী কন্টেন্ট রাইটাররা বোনাস ব্যালেন্স ডিস্ট্রিবিউট পাবেন।</p>
                              </div>
                            </div>

                            <h1 className="text-xl md:text-2xl font-bold font-sans text-white leading-snug tracking-tight text-left">
                              {post.title}
                            </h1>

                            {/* Main Body */}
                            <div className={`${activeFontSizeClass} text-slate-300 leading-relaxed font-sans space-y-4 pt-2 whitespace-pre-line text-left`}>
                              {post.content}
                            </div>

                            {/* ADSENSE UNIT SLOT 2: Mid-point content block (Compliance Safety >20px) */}
                            {adminSettings.enableGoogleAds && (
                              <div className="my-6 p-4 bg-slate-950/90 border border-cyan-950/40 rounded-xl text-center space-y-1 select-none">
                                <span className="text-[8px] font-mono text-slate-600 uppercase tracking-widest block font-bold">
                                  — ADVERTISEMENT - এডসেন্স ইন-আর্টিকেল ডাইনামিক বিজ্ঞাপন বোতাম —
                                </span>
                                <div className="text-[11px] font-mono text-cyan-500/70 p-2 italic">
                                  {adminSettings.advertisementSnippet || "Google AdSense In-Article Ad Slot - Native Responsive Box"}
                                </div>
                              </div>
                            )}

                          </div>

                          {/* Monetization details at bottom of reading post */}
                          <div className="bg-[#050913] border border-cyan-950 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-left">
                            <div className="flex items-center gap-3">
                              <button
                                onClick={() => handleLikePost(post.id)}
                                className="flex items-center gap-1.5 text-slate-300 hover:text-emerald-400 font-bold transition-all"
                              >
                                <ThumbsUp className="w-4 h-4 text-emerald-500 animate-bounce" /> {post.likes} লাইকস
                              </button>
                              <span className="text-slate-500">|</span>
                              <span className="text-slate-300 flex items-center gap-1">
                                <Eye className="w-4 h-4 text-cyan-500" /> {post.views} ভিউস
                              </span>
                            </div>
                            <span className="text-[#39ff14] text-[11px] font-bold">✓ আপনি এই কন্টেন্ট পড়ে ফোরাম ক্রিয়েটরকে সাহায্য করছেন।</span>
                          </div>

                          {/* Dynamic Creator Post Earnings Widget */}
                          <div className="bg-[#070e1a] border border-cyan-500/10 rounded-xl p-4 text-left space-y-2 font-mono">
                            <div className="flex justify-between items-center text-xs">
                              <span className="text-slate-400 text-[11px] uppercase">রিয়েল-টাইম কন্টেন্ট লভ্যাংশ মিটার:</span>
                              <span className="text-emerald-400 font-bold bg-emerald-950/60 border border-emerald-900/40 px-2 py-0.5 rounded text-[10px] select-none uppercase">
                                Active Earning Share
                              </span>
                            </div>
                            <div className="grid grid-cols-3 gap-2 text-center text-[10px] pt-1">
                              <div className="bg-slate-950 p-2 rounded border border-cyan-950">
                                <span className="text-slate-500 block">ভিউ বোনাস (৳)</span>
                                <span className="text-cyan-400 font-bold block mt-0.5">{(post.views * (adminSettings.payoutPerView || 0.15)).toFixed(2)} ৳</span>
                              </div>
                              <div className="bg-slate-950 p-2 rounded border border-cyan-950">
                                <span className="text-slate-500 block">লাইক বোনাস (৳)</span>
                                <span className="text-cyan-400 font-bold block mt-0.5 font-sans">{(post.likes * (adminSettings.payoutPerLike || 0.50)).toFixed(2)} ৳</span>
                              </div>
                              <div className="bg-slate-950 p-2 rounded border border-cyan-950">
                                <span className="text-slate-500 block">পাবলিশ ফান্ড (৳)</span>
                                <span className="text-[#39ff14] font-bold block mt-0.5 font-sans">{(adminSettings.payoutPerPublish || 8.50).toFixed(2)} ৳</span>
                              </div>
                            </div>
                            <div className="flex justify-between items-center bg-[#050912] p-2.5 rounded border border-cyan-950/60 text-xs">
                              <span className="text-slate-300 font-bold">সর্বমোট কন্টেন্ট রিওয়ার্ড লভ্যাংশ:</span>
                              <span className="text-[#39ff14] font-black text-sm">
                                {(
                                  post.views * (adminSettings.payoutPerView || 0.15) +
                                  post.likes * (adminSettings.payoutPerLike || 0.50) +
                                  (adminSettings.payoutPerPublish || 8.50)
                                ).toFixed(2)}{" "}
                                ৳ BDT
                              </span>
                            </div>
                          </div>

                          {/* Related Posts Carousel */}
                          {(() => {
                            const related = posts.filter(p => p.category === post.category && p.id !== post.id).slice(0, 2);
                            if (related.length === 0) return null;
                            return (
                              <div className="border-t border-cyan-950/60 pt-5 space-y-3.5 text-left">
                                <h4 className="text-xs font-bold font-mono text-[#00f0ff] uppercase tracking-wider">
                                  🔗 অনুরূপ ট্রিকস ও কন্টেন্ট যা আপনার পড়া উচিত
                                </h4>
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                  {related.map((rp) => (
                                    <div
                                      key={rp.id}
                                      onClick={() => setSelectedPostId(rp.id)}
                                      className="bg-slate-950/80 border border-cyan-950 rounded-xl p-3 hover:border-cyan-500 transition-colors cursor-pointer flex gap-3 text-left items-start"
                                    >
                                      <img
                                        src={rp.thumbnail}
                                        alt={rp.title}
                                        className="w-14 h-14 rounded-lg object-cover border border-cyan-950 select-none"
                                        referrerPolicy="no-referrer"
                                      />
                                      <div className="flex-1 min-w-0 text-left">
                                        <span className="text-[11px] font-sans font-bold text-slate-200 hover:text-[#00f0ff] leading-relaxed block truncate">
                                          {rp.title}
                                        </span>
                                        <span className="text-[9px] font-mono text-slate-500 block mt-1 uppercase">
                                          {rp.category} • {rp.timestamp}
                                        </span>
                                      </div>
                                    </div>
                                  ))}
                                </div>
                              </div>
                            );
                          })()}

                          {/* ADSENSE UNIT SLOT 3: Comments Preloader Banner (Compliance Safety >20px) */}
                          {adminSettings.enableGoogleAds && (
                            <div className="my-6 p-4 bg-slate-950/90 border-t border-b border-dashed border-cyan-500/10 rounded-lg text-center space-y-1 select-none">
                              <span className="text-[8px] font-mono text-slate-600 uppercase tracking-widest block font-bold">
                                — ADVERTISEMENT - গুগল এডসেন্স রেসপনসিভ ফুটার এড ব্লক —
                              </span>
                              <div className="text-[11px] font-mono text-cyan-500/70 p-2 italic">
                                {adminSettings.advertisementSnippet || "Google AdSense Footer Match Banner Ads Unit"}
                              </div>
                            </div>
                          )}

                          {/* Section Comments */}
                          <div className="border-t border-cyan-950 pt-5 space-y-4">
                            <h3 className="text-sm font-bold font-mono text-[#00f0ff] uppercase tracking-wider">মন্তব্যসমূহ ({post.comments.length})</h3>
                            <div className="space-y-3.5 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">
                              {post.comments.length === 0 ? (
                                <div className="text-xs text-slate-500 italic pl-1">কোনো মন্তব্য নেই, প্রথম মন্তব্য করে ৫ পয়েন্ট আর্ন করুন!</div>
                              ) : (
                                post.comments.map((comment) => (
                                  <div key={comment.id} className="bg-slate-950/60 p-3 rounded-xl border border-cyan-950/40 text-xs">
                                    <div className="flex items-center gap-2 mb-1.5">
                                      <img
                                        src={comment.authorAvatar}
                                        alt={comment.authorName}
                                        className="w-5 h-5 rounded-full border border-slate-700"
                                      />
                                      <span className="font-bold text-[#00f0ff]">{comment.authorName}</span>
                                      <span className="text-[9px] text-[#4d5b7c] ml-auto">{comment.timestamp}</span>
                                    </div>
                                    <p className="text-slate-200 pl-1 leading-relaxed font-sans">{comment.text}</p>
                                  </div>
                                ))
                              )}
                            </div>

                            {/* Comment Input */}
                            <form
                              onSubmit={(e) => {
                                e.preventDefault();
                                const form = e.currentTarget;
                                const input = form.elements.namedItem("commentInput") as HTMLInputElement;
                                if (input && input.value.trim()) {
                                  handleCommentPost(post.id, input.value);
                                  input.value = "";
                                }
                              }}
                              className="flex gap-2"
                            >
                              <input
                                name="commentInput"
                                type="text"
                                placeholder="একটি গঠনমূলক বা সাইবার সিকিউরিটি রিসার্চ ভিত্তিক মন্তব্য লিখুন..."
                                className="flex-1 bg-slate-950 border border-cyan-950 focus:border-cyan-500 rounded-xl px-4 py-2.5 text-xs text-slate-200 focus:outline-none placeholder-slate-600 font-sans"
                              />
                              <button
                                type="submit"
                                className="bg-gradient-to-r from-cyan-500 to-teal-500 text-[#070b13] px-5 py-2.5 rounded-xl font-bold font-sans text-xs uppercase"
                              >
                                পোস্ট
                              </button>
                            </form>
                          </div>
                        </motion.div>
                      );
                    })()
                  ) : (
                    (() => {
                      const displayedPosts = feedViewTab === "popular"
                        ? [...filteredPostsList].sort((a, b) => b.views - a.views)
                        : filteredPostsList;

                      return (
                        <div className="space-y-6">
                          {/* High-Contrast Interactive Neon Tab Switcher */}
                          <div className="flex items-center justify-between border-b border-cyan-950/60 pb-3 flex-wrap gap-4 text-left">
                            <div className="flex items-center gap-2">
                              <button
                                onClick={() => setFeedViewTab("all")}
                                className={`px-4 py-2 rounded-xl text-xs font-bold font-sans tracking-wide transition-all relative flex items-center gap-1.5 cursor-pointer ${
                                  feedViewTab === "all"
                                    ? "bg-cyan-950/80 text-cyan-400 border border-cyan-500/30 shadow-[0_0_15px_rgba(6,182,212,0.15)]"
                                    : "text-slate-400 hover:text-slate-250"
                                }`}
                              >
                                <span>⚡</span> সর্বমোট কন্টেন্ট ({filteredPostsList.length})
                                {feedViewTab === "all" && (
                                  <motion.div
                                    layoutId="feedTabIndicator"
                                    className="absolute -bottom-[13px] left-0 right-0 h-[2px] bg-cyan-400"
                                    transition={{ type: "spring", stiffness: 380, damping: 30 }}
                                  />
                                )}
                              </button>

                              <button
                                onClick={() => setFeedViewTab("popular")}
                                className={`px-4 py-2 rounded-xl text-xs font-bold font-sans tracking-wide transition-all relative flex items-center gap-1.5 cursor-pointer ${
                                  feedViewTab === "popular"
                                    ? "bg-purple-950/80 text-purple-300 border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.15)]"
                                    : "text-slate-400 hover:text-slate-250"
                                }`}
                              >
                                <span>🔥</span> জনপ্রিয় হট পোস্ট ({filteredPostsList.length})
                                {feedViewTab === "popular" && (
                                  <motion.div
                                    layoutId="feedTabIndicator"
                                    className="absolute -bottom-[13px] left-0 right-0 h-[2px] bg-[#bd00ff]"
                                    transition={{ type: "spring", stiffness: 380, damping: 30 }}
                                  />
                                )}
                              </button>
                            </div>

                            {/* High tech label */}
                            <div className="text-[10px] font-mono text-[#39ff14] bg-emerald-950/40 border border-[#163f19]/80 px-2.5 py-1 rounded-lg flex items-center gap-1.5 font-bold uppercase tracking-widest leading-none">
                              <span className="w-1.5 h-1.5 bg-[#39ff14] rounded-full animate-pulse" />
                              <span>Ecosystem Feed</span>
                            </div>
                          </div>

                          {/* NEWS MODULE HOMEPAGE PREVIEW (GOOGLE POLICY COMPLIANT) */}
                          {adminSettings.enableNewsSection !== false && adminSettings.showNewsModule !== false && (
                            <div className="mb-8 bg-[#0d1527]/55 border border-cyan-500/20 rounded-2xl p-5 relative overflow-hidden">
                              <div className="absolute top-0 right-0 w-24 h-24 bg-cyan-500/5 filter blur-xl rounded-full"></div>
                              
                              <div className="flex justify-between items-center border-b border-cyan-950 pb-3 mb-4">
                                <div className="flex items-center gap-2">
                                  <span className="text-xs font-bold text-white font-mono uppercase tracking-wider flex items-center gap-1">
                                    <span className="w-2 h-2 bg-[#00f0ff] rounded-full animate-pulse" />
                                    📰 এআই নিউজ বুলেটিন (AI News Portal)
                                  </span>
                                  <span className="text-[9px] font-mono bg-cyan-950 text-cyan-400 px-1.5 py-0.2 rounded border border-cyan-500/15">
                                    {adminSettings.newsDisplayType?.toUpperCase() || "LATEST"}
                                  </span>
                                </div>
                                <button 
                                  onClick={() => setActiveTab("news")}
                                  className="text-[10px] font-bold font-mono text-cyan-400 hover:text-white transition-all cursor-pointer"
                                >
                                  VIEW ALL ➡
                                </button>
                              </div>

                              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {(() => {
                                  const savedNews = localStorage.getItem("ilybd_news_posts_db");
                                  let rawList = savedNews ? JSON.parse(savedNews) : [];
                                  if (rawList.length === 0) {
                                    // Fallback to initial set if localDB is empty
                                    rawList = [
                                      {
                                        id: "news-1",
                                        title: "বাংলাদেশ সাইবার ক্রাইসিস রেসপন্স টিম দ্বারা ২0৪০ সালের নতুন গ্লোবাল ফায়ারওয়াল অ্যাক্টিভেশন",
                                        summary: "বাংলাদেশ সরকারের সাইবার টিম আন্তর্জাতিক থ্রেট ইন্টেলিজেন্সের সাথে মিলে পরবর্তী প্রজন্মের কোয়ান্টাম ফায়ারওয়াল নেটওয়ার্ক সক্রিয় করেছে যা ১০০% দেশীয় এআই নোড দ্বারা চালিত।",
                                        image: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=600&q=80",
                                        category: "Cyber Security",
                                        publishTime: "2026-06-29T08:30:00",
                                        readTime: 3,
                                        isBreaking: true,
                                        isTrending: true,
                                        isEditorsPick: true
                                      },
                                      {
                                        id: "news-2",
                                        title: "সুপারকম্পিউটিং যুগে বাংলাদেশ: এআই-রিসার্চ হাবে নতুন সুপারক্লাস্টার উদ্বোধন",
                                        summary: "ঢাকার পূর্বাচল টেক-সিটিতে দেশের বৃহত্তম সুপারকম্পিউটিং রিসার্চ হাবের উদ্বোধন করা হয়েছে। আইবিডি এআই রিসার্চ ফাউন্ডেশন এই ক্লাস্টার স্থাপন করেছে।",
                                        image: "https://images.unsplash.com/photo-1544383835-bda2bc66a55d?auto=format&fit=crop&w=600&q=80",
                                        category: "AI",
                                        publishTime: "2026-06-28T14:20:00",
                                        readTime: 4,
                                        isEditorsPick: true
                                      }
                                    ];
                                  }
                                  let filtered = [...rawList];
                                  if (adminSettings.newsDisplayType === "trending") {
                                    filtered = filtered.filter((n: any) => n.isTrending);
                                  } else if (adminSettings.newsDisplayType === "breaking") {
                                    filtered = filtered.filter((n: any) => n.isBreaking);
                                  } else if (adminSettings.newsDisplayType === "manual") {
                                    filtered = filtered.filter((n: any) => n.isEditorsPick);
                                  }
                                  
                                  const displayLimit = adminSettings.newsDisplayCount || 3;
                                  const finalShow = filtered.slice(0, displayLimit);
                                  
                                  if (finalShow.length === 0) {
                                    return <p className="text-[10px] text-slate-500 font-mono col-span-full">No matching news items found on this filter.</p>;
                                  }

                                  return finalShow.map((n: any) => (
                                    <div 
                                      key={n.id}
                                      onClick={() => { setActiveTab("news"); }}
                                      className="group bg-[#070b13]/60 border border-slate-900 hover:border-cyan-500/30 rounded-xl p-3.5 transition-all cursor-pointer flex flex-col justify-between"
                                    >
                                      <div>
                                        {adminSettings.newsShowThumbnail !== false && n.image && (
                                          <div className="aspect-[16/10] w-full rounded-lg overflow-hidden bg-slate-950 border border-slate-800/60 mb-2.5">
                                            <img src={n.image} alt={n.title} className="w-full h-full object-fit-cover group-hover:scale-103 transition-transform duration-300" referrerPolicy="no-referrer" />
                                          </div>
                                        )}

                                        <div className="flex items-center justify-between gap-2 mb-1.5">
                                          {adminSettings.newsShowCategory !== false && (
                                            <span className="text-[8px] font-mono font-bold text-[#00f0ff] uppercase bg-cyan-950/40 border border-cyan-500/15 px-1.5 py-0.2 rounded">
                                              {n.category}
                                            </span>
                                          )}
                                          {adminSettings.newsShowPublishTime !== false && (
                                            <span className="text-[8px] font-mono text-slate-500">
                                              {new Date(n.publishTime).toLocaleDateString()}
                                            </span>
                                          )}
                                        </div>

                                        <h4 className="text-[11px] font-bold text-slate-100 group-hover:text-cyan-400 transition-colors leading-snug line-clamp-2 mb-1.5">
                                          {n.title}
                                        </h4>

                                        {adminSettings.newsShowSummary !== false && (
                                          <p className="text-[10px] text-slate-400 leading-normal line-clamp-2">
                                            {n.summary}
                                          </p>
                                        )}
                                      </div>

                                      {adminSettings.newsShowReadMore !== false && (
                                        <div className="mt-3 pt-2 border-t border-slate-900 text-right">
                                          <span className="text-[9px] font-mono text-cyan-400 font-bold">
                                            {adminSettings.newsButtonText || "নিউজ সেন্টার (News Center)"} ➡
                                          </span>
                                        </div>
                                      )}
                                    </div>
                                  ));
                                })()}
                              </div>
                            </div>
                          )}

                          {/* Dynamic Content Columns Grid */}
                          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {displayedPosts.length === 0 ? (
                              <div className="md:col-span-2 text-center py-16 bg-[#090d16]/30 border border-cyan-950 rounded-2xl relative shadow-2xl">
                                <span className="text-slate-400 font-mono text-xs">দুঃখিত! এই ফিল্টারে কোনো ফোরাম আর্টিকেল পাওয়া যায়নি।</span>
                              </div>
                            ) : (
                              displayedPosts.map((post) => (
                                <PostContainer
                                  key={post.id}
                                  post={post}
                                  onLike={handleLikePost}
                                  onComment={handleCommentPost}
                                  onMessageAuthor={(authorName) => {
                                    setSelectedContactName(authorName);
                                    setActiveTab("messages");
                                    window.scrollTo({ top: 0, behavior: "smooth" });
                                  }}
                                />
                              ))
                            )}
                          </div>
                        </div>
                      );
                    })()
                  )}

                </div>

                {/* Right side column: sidebar trackers */}
                <div className="lg:col-span-4 w-full lg:w-80 space-y-6 shrink-0 text-left">
                  
                  {/* AI Auto posting monitoring status */}
                  <div className="bg-[#090d16] border border-cyan-950 rounded-xl p-4">
                    <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-widest mb-3 font-bold border-b border-cyan-950 pb-1 flex items-center justify-between">
                      <span>এআই কন্টেন্ট ক্রু ট্র্যাকার</span>
                      <span className="text-[9px] bg-red-950 text-red-400 px-1 rounded animate-pulse">LIVE</span>
                    </h3>
                    <div className="space-y-2 text-xs font-mono">
                      <div className="flex justify-between text-slate-400">
                        <span>অটো পোস্টিং:</span>
                        <span className="text-emerald-400">সক্রিয়</span>
                      </div>
                      <div className="flex justify-between text-slate-400">
                        <span>ক্রু এডিটরস:</span>
                        <span className="text-cyan-400">৩ জন অনলাইন</span>
                      </div>
                      <div className="flex justify-between text-slate-400">
                        <span>গুগল বট ফ্রেন্ডলি:</span>
                        <span className="text-emerald-400">১০০% ওয়ান</span>
                      </div>
                    </div>
                  </div>

                  {/* AdSense Approval Stats Portal */}
                  <div className="bg-gradient-to-br from-[#101905] to-[#040c03] border border-emerald-950/60 rounded-xl p-4 space-y-3 relative overflow-hidden text-left">
                    <h3 className="text-xs font-mono text-emerald-400 uppercase tracking-widest font-bold border-b border-emerald-950/60 pb-1.5 flex items-center gap-1.5">
                      📶 এডসেন্স এপ্রুভাল স্কোর
                    </h3>
                    <div className="space-y-2 text-xs font-mono">
                      <div className="flex justify-between text-slate-400">
                        <span>সাইট হেলথ:</span>
                        <span className="text-emerald-400 font-bold">১০% ডিরেক্ট</span>
                      </div>
                      <div className="flex justify-between text-slate-400">
                        <span>এপ্রুভাল রেট:</span>
                        <span className="text-yellow-400 font-bold">৯৮% পসিবিলিটি</span>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </motion.div>
          )}

          {/* Tab 2: Manual Post Submission */}
          {activeTab === "add" && (
            <motion.div
              key="add"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="max-w-3xl mx-auto text-left"
            >
              <form onSubmit={handleUserAddPost} className="bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl relative overflow-hidden space-y-6">
                <div className="absolute inset-0 bg-gradient-to-br from-cyan-500/5 via-transparent to-[#39ff14]/5 pointer-events-none" />
                
                <div className="flex items-center gap-2.5 border-b border-cyan-950 pb-4">
                  <div className="p-2 rounded bg-cyan-950/40 border border-cyan-500/50 flex items-center justify-center">
                    <Plus className="w-6 h-6 text-cyan-400" />
                  </div>
                  <div>
                    <h2 className="text-xl font-bold font-sans tracking-tight text-white">নতুন কন্টেন্ট আর্নিং পোর্টাল</h2>
                    <p className="text-xs text-slate-400 font-mono mt-0.5">সাইবার ফোরামে আপনার প্রযুক্তিগত টিউটোরিয়াল শেয়ার করুন এবং সরাসরি বোনাস ইনকাম ক্রেডিট করুন।</p>
                  </div>
                </div>

                <div className="space-y-4">
                  <div className="space-y-1.5">
                    <label className="block text-xs font-mono text-slate-300">টিউটোরিয়াল শিরোনাম (Title)</label>
                    <input
                      type="text"
                      required
                      placeholder="যেমন: ওয়ার্ডপ্রেস স্পিড অপ্টিমাইজেশন ২০৪০ সিক্রেট গাইড"
                      value={newPostTitle}
                      onChange={(e) => setNewPostTitle(e.target.value)}
                      className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-sans focus:outline-none transition-all"
                    />
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="space-y-1.5">
                      <label className="block text-xs font-mono text-slate-300">ক্যাটাগরি (Category)</label>
                      <select
                        value={newPostCat}
                        onChange={(e) => setNewPostCat(e.target.value)}
                        className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none transition-all"
                      >
                        <option value="Hacking">Hacking</option>
                        <option value="SEO Guide">SEO Guide</option>
                        <option value="Online Earning">Online Earning</option>
                        <option value="Android Tech">Android Tech</option>
                      </select>
                    </div>

                    <div className="space-y-1.5">
                      <label className="block text-xs font-mono text-slate-300">কি-ওয়ার্ড বা ট্যাগস (কমা দিন)</label>
                      <input
                        type="text"
                        placeholder="hacking, seo, earnings"
                        value={newPostTags}
                        onChange={(e) => setNewPostTags(e.target.value)}
                        className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-sans focus:outline-none transition-all"
                      />
                    </div>
                  </div>

                  <div className="space-y-1.5">
                    <label className="block text-xs font-mono text-slate-300">সংক্ষিপ্ত ভূমিকা (Excerpt)</label>
                    <input
                      type="text"
                      placeholder="কন্টেন্ট এর ১ লাইনের আকর্ষণীয় ভূমিকা এখানে লিখুন..."
                      value={newPostExcerpt}
                      onChange={(e) => setNewPostExcerpt(e.target.value)}
                      className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-sans focus:outline-none transition-all"
                    />
                  </div>

                  <div className="space-y-1.5">
                    <label className="block text-xs font-mono text-slate-300">বিস্তারিত কন্টেন্ট আর্টিকেল (Markdown Supported)</label>
                    <textarea
                      required
                      rows={8}
                      placeholder="আপনার প্রযুক্তি বিষয়ক কন্টেন্টটির বিস্তারিত বিবরণ এখানে শেয়ার করুন..."
                      value={newPostContent}
                      onChange={(e) => setNewPostContent(e.target.value)}
                      className="w-full bg-slate-950 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-sans focus:outline-none transition-all resize-none"
                    />
                  </div>
                </div>

                <div className="pt-4 border-t border-cyan-950/40 flex items-center justify-between gap-4">
                  <span className="text-[10px] font-mono text-[#39ff14]">★ প্রতিটি ইউনিক পোস্ট পাবলিশে ২৫XP এবং ৮.৫০৳ এড হবে!</span>
                  <button
                    type="submit"
                    className="px-6 py-2.5 bg-gradient-to-r from-cyan-500 to-emerald-500 text-slate-950 font-bold font-sans rounded-xl text-xs uppercase hover:shadow-[0_0_15px_rgba(34,211,238,0.4)] transition-all"
                  >
                    🚀 কন্টেন্ট পাবলিশ করুন
                  </button>
                </div>
              </form>
            </motion.div>
          )}

          {/* Tab 3: Live TV Portal */}
          {activeTab === "tv" && (
            <motion.div
              key="tv"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <LiveTV />
            </motion.div>
          )}

          {/* Tab 4: AI Maya Assistant */}
          {activeTab === "ai" && (
            <motion.div
              key="ai"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <MayaChatbot 
                settings={adminSettings} 
                onUpdateSettings={(updated) => setAdminSettings((prev) => ({ ...prev, ...updated }))} 
                selectedMood={selectedMood}
                userStats={userStats}
                isLoggedIn={isLoggedIn}
                posts={posts}
                questions={questions}
              />
            </motion.div>
          )}

          {/* Tab 4.5: Neon Generative Music Lab */}
          {activeTab === "audiolab" && (
            <motion.div
              key="audiolab"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <AudioLab mayaApiKeys={adminSettings.mayaApiKeys} />
            </motion.div>
          )}

          {/* Tab: Dedicated Tools Lab Directory */}
          {activeTab === "tools-lab" && (
            <motion.div
              key="tools-lab"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <ToolsLabHub 
                onSelectTab={(tab) => {
                  setActiveTab(tab);
                  setSelectedPostId(null);
                }}
                onSelectSubTool={(subTool, app) => {
                  setInitialSubTool(subTool);
                  if (app) {
                    setInitialAppForScan(app);
                  } else {
                    setInitialAppForScan(undefined);
                  }
                  setActiveTab("tools");
                  setSelectedPostId(null);
                }}
              />
            </motion.div>
          )}

          {/* Tab 5: Community Q&A Panel */}
          {activeTab === "qa" && (
            <motion.div
              key="qa"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <CommunityQA 
                questions={questions}
                onAddQuestion={handleAddForumQuestion}
                onAddAnswer={handleAddAnswer}
                activeQuestionId={selectedQuestionId}
                setActiveQuestionId={setSelectedQuestionId}
              />
            </motion.div>
          )}

          {/* Tab: AIO Secure Video Downloader */}
          {activeTab === "downloader" && (
            <motion.div
              key="downloader"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <VideoDownloader />
            </motion.div>
          )}

          {/* Tab: Independent AI News Center */}
          {activeTab === "news" && (
            <motion.div
              key="news"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <NewsCenter 
                onBackToHome={() => setActiveTab("home")}
                homepageNewsConfig={{
                  enabled: adminSettings.enableNewsSection !== false,
                  showModule: adminSettings.showNewsModule !== false,
                  displayType: adminSettings.newsDisplayType || "latest",
                  displayCount: adminSettings.newsDisplayCount || 5,
                  showThumbnail: adminSettings.newsShowThumbnail !== false,
                  showPublishTime: adminSettings.newsShowPublishTime !== false,
                  showCategory: adminSettings.newsShowCategory !== false,
                  showSummary: adminSettings.newsShowSummary !== false,
                  showReadMore: adminSettings.newsShowReadMore !== false,
                  buttonText: adminSettings.newsButtonText || "নিউজ সেন্টার (News Center)"
                }}
              />
            </motion.div>
          )}

          {/* Tab: Mega Unified Tools Hub */}
          {activeTab === "tools" && (
            <motion.div
              key="tools"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <UnifiedTools 
                initialSubTool={initialSubTool as any}
                initialApp={initialAppForScan}
                onClearInitialApp={() => {
                  setInitialAppForScan(undefined);
                  setInitialSubTool(undefined);
                }}
              />
            </motion.div>
          )}

          {/* Tab 8: Profile customization & Reward Claiming Portal */}
          {activeTab === "profile" && (
            <motion.div
              key="profile"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="max-w-4xl mx-auto space-y-6 text-left"
            >
              <div className="bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl relative overflow-hidden space-y-6">
                <div className="absolute inset-0 bg-gradient-to-br from-cyan-500/5 via-transparent to-[#ffae00]/5 pointer-events-none" />
                
                {/* Header title */}
                <div className="flex items-center gap-2.5 border-b border-cyan-950 pb-4">
                  <div className="p-2 rounded bg-amber-950/40 border border-amber-500/50 flex items-center justify-center animate-pulse">
                    <Award className="w-6 h-6 text-[#ffae00]" />
                  </div>
                  <div>
                    <h2 className="text-xl font-bold font-sans tracking-tight text-white flex items-center gap-2">
                      কোডার প্রোফাইল সম্পাদন ও ১৫০XP বোনাস
                    </h2>
                    <p className="text-xs text-slate-400 font-mono mt-0.5">
                      আপনার প্রোফাইল তথ্য প্রদান করে বাংলাদেশের সেরা সাইবার ফোরাম মেম্বার লিস্টের স্বীকৃতি এবং ১৫০XP বোনাস ক্রেডিট করুন।
                    </p>
                  </div>
                </div>

                {/* Profile progress bar meter */}
                <div className="bg-slate-950/80 rounded-xl p-4 border border-cyan-950 space-y-2.5">
                  <div className="flex justify-between items-center text-xs font-mono">
                    <span className="text-slate-400 font-sans">প্রোফাইল তথ্য সম্পন্ন করার আপডেট মিটার:</span>
                    <span className={`font-bold font-sans ${
                      (profilePhone && profileBkash && profileBio && profileSkills && profileFbLink) 
                      ? "text-[#39ff14]" : "text-amber-400"
                    }`}>
                      {(() => {
                        let score = 20; // Starts with username/avatar loaded
                        if (profilePhone) score += 15;
                        if (profileBkash) score += 15;
                        if (profileBio) score += 20;
                        if (profileSkills) score += 15;
                        if (profileFbLink) score += 15;
                        return score;
                      })()}% সম্পন্ন
                    </span>
                  </div>
                  
                  {/* Visual progress bar */}
                  <div className="w-full bg-slate-900 rounded-full h-2.5 overflow-hidden border border-cyan-950">
                    <div 
                      className="bg-gradient-to-r from-amber-500 via-yellow-400 to-[#39ff14] h-2.5 rounded-full transition-all duration-500"
                      style={{ 
                        width: `${(() => {
                          let score = 20;
                          if (profilePhone) score += 15;
                          if (profileBkash) score += 15;
                          if (profileBio) score += 20;
                          if (profileSkills) score += 15;
                          if (profileFbLink) score += 15;
                          return score;
                        })()}%` 
                      }}
                    />
                  </div>

                  {/* Requirements checklist section */}
                  <div className="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-1">
                    <div className="flex items-center gap-1.5 text-[10px] font-mono">
                      <span className="text-[#39ff14] font-bold">✔</span>
                      <span className="text-slate-300">অ্যাকাউন্টের নাম ও সিড</span>
                    </div>
                    <div className="flex items-center gap-1.5 text-[10px] font-mono">
                      <span className={profileBio ? "text-[#39ff14] font-bold" : "text-slate-600"}>
                        {profileBio ? "✔" : "○"}
                      </span>
                      <span className={profileBio ? "text-slate-300" : "text-slate-500"}>মেম্বার বায়ো (Bio)</span>
                    </div>
                    <div className="flex items-center gap-1.5 text-[10px] font-mono">
                      <span className={profilePhone ? "text-[#39ff14] font-bold" : "text-slate-600"}>
                        {profilePhone ? "✔" : "○"}
                      </span>
                      <span className={profilePhone ? "text-slate-300" : "text-slate-500"}>মোবাইল নম্বর</span>
                    </div>
                    <div className="flex items-center gap-1.5 text-[10px] font-mono">
                      <span className={profileBkash ? "text-[#39ff14] font-bold" : "text-slate-600"}>
                        {profileBkash ? "✔" : "○"}
                      </span>
                      <span className={profileBkash ? "text-slate-300" : "text-slate-400"}>বিকাশের নম্বর</span>
                    </div>
                    <div className="flex items-center gap-1.5 text-[10px] font-mono">
                      <span className={profileSkills ? "text-[#39ff14] font-bold" : "text-slate-600"}>
                        {profileSkills ? "✔" : "○"}
                      </span>
                      <span className={profileSkills ? "text-slate-300" : "text-slate-400"}>দক্ষতা ও স্কিলস</span>
                    </div>
                    <div className="flex items-center gap-1.5 text-[10px] font-mono">
                      <span className={profileFbLink ? "text-[#39ff14] font-bold" : "text-slate-600"}>
                        {profileFbLink ? "✔" : "○"}
                      </span>
                      <span className={profileFbLink ? "text-slate-300" : "text-slate-400"}>ফেসবুক লিংক</span>
                    </div>
                  </div>
                </div>

                {/* Form fields */}
                <div className="space-y-4 pt-2">
                  <h3 className="text-sm font-bold font-mono text-[#00f0ff] uppercase tracking-wider flex items-center gap-2">
                    <User className="w-4 h-4 text-cyan-400" /> প্রোফাইলের তথ্য আপডেট ফর্ম
                  </h3>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {/* Phone field */}
                    <div className="space-y-1.5">
                      <label className="block text-xs font-mono text-slate-400">মোবাইল নম্বর (Phone Number)</label>
                      <input
                        type="text"
                        placeholder="017xxxxxxxx"
                        value={profilePhone}
                        onChange={(e) => setProfilePhone(e.target.value)}
                        className="w-full bg-slate-950/60 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-mono focus:outline-none transition-all"
                      />
                    </div>

                    {/* bKash field */}
                    <div className="space-y-1.5">
                      <label className="block text-xs font-mono text-slate-400">বিকাশ বা নগদ নম্বর (bKash/Nagad Number)</label>
                      <input
                        type="text"
                        placeholder="018xxxxxxxx [ব্যক্তিগত উইথড্র পেমেন্টের জন্য]"
                        value={profileBkash}
                        onChange={(e) => setProfileBkash(e.target.value)}
                        className="w-full bg-slate-950/60 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-mono focus:outline-none transition-all"
                      />
                    </div>

                    {/* Skills field */}
                    <div className="space-y-1.5">
                      <label className="block text-xs font-mono text-slate-400">পারদর্শিতা ও কী স্কিলস (Skills / Experience)</label>
                      <input
                        type="text"
                        placeholder="React, CSS, Node.js, Cyber Security"
                        value={profileSkills}
                        onChange={(e) => setProfileSkills(e.target.value)}
                        className="w-full bg-slate-950/60 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-sans focus:outline-none transition-all"
                      />
                    </div>

                    {/* Social Link field */}
                    <div className="space-y-1.5">
                      <label className="block text-xs font-mono text-slate-400">সামাজিক ওয়েবসাইট/ফেসবুক লিংক</label>
                      <input
                        type="text"
                        placeholder="https://facebook.com/username"
                        value={profileFbLink}
                        onChange={(e) => setProfileFbLink(e.target.value)}
                        className="w-full bg-slate-950/60 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-sans focus:outline-none transition-all"
                      />
                    </div>
                  </div>

                  {/* Bio Field */}
                  <div className="space-y-1.5">
                    <label className="block text-xs font-mono text-slate-400">আপনার মেম্বার বায়ো (Detailed Biography)</label>
                    <textarea
                      rows={3}
                      placeholder="আপনার সংক্ষিপ্ত কোডিং বায়ো বা সাইবার সিকিউরিটি রিসার্চ কাজের বিবরণী এখানে লিখুন..."
                      value={profileBio}
                      onChange={(e) => setProfileBio(e.target.value)}
                      className="w-full bg-slate-950/60 border border-cyan-950 focus:border-cyan-500/80 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-600 font-sans focus:outline-none transition-all resize-none"
                    />
                  </div>

                  {/* Saving/Claiming Actions */}
                  <div className="pt-4 border-t border-cyan-950/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <p className="text-[11px] text-slate-400 max-w-md leading-relaxed font-sans">
                      * সমস্ত তথ্য পূরণ করার পর ক্লেইম বাটনে টিপুন। এটি আপনার আইডিতে সরাসরি ১৫০ ক্যাশ-আউট পয়েন্ট (XP) যুক্ত করবে যা দিয়ে বিকাশ পেমেন্ট তোলা সহজ হবে।
                    </p>
                    
                    <button
                      type="button"
                      onClick={() => {
                        if (isProfileRewardClaimed) {
                          addSystemNotification("আপনি ইতিমধ্যে প্রোফাইল রিওয়ার্ড ক্লেইম করেছেন!", "error");
                        } else if (profilePhone && profileBkash && profileBio && profileSkills && profileFbLink) {
                          setIsProfileRewardClaimed(true);
                          setUserStats(prev => ({
                            ...prev,
                            points: prev.points + 150
                          }));
                          addSystemNotification("অভিনন্দন! আপনি সফলভাবে প্রোফাইল সম্পাদন বাবদ ১৫০XP বোনাস ক্লেইম করেছেন।", "system");
                        } else {
                          addSystemNotification("দয়া করে ক্লেইম করার পূর্বে সমস্ত ফিল্ড সঠিকভাবে লিখুন!", "error");
                        }
                      }}
                      className={`px-6 py-3 rounded-xl font-mono text-xs font-bold uppercase transition-all duration-300 flex items-center gap-1.5 ${
                        isProfileRewardClaimed
                          ? "bg-slate-950 border border-emerald-950 text-emerald-500 cursor-not-allowed"
                          : (profilePhone && profileBkash && profileBio && profileSkills && profileFbLink)
                            ? "bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-400 hover:to-yellow-400 text-slate-950 shadow-lg cursor-pointer transform hover:-translate-y-0.5"
                            : "bg-slate-900 border border-cyan-950/40 text-slate-500 cursor-not-allowed"
                      }`}
                    >
                      {isProfileRewardClaimed ? "✓ রিওয়ার্ড ক্লেইমড" : "★ ১৫০XP রিওয়ার্ড ক্লেইম করুন"}
                    </button>
                  </div>
                </div>
              </div>

              {/* Grid 2-columns (Left: Beautiful Line-by-Line List, Right: Wallet Balance & Payout Control) */}
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {/* Column Left (Col-sp-7): Styled Line-By-Line List & Referrals Card */}
                <div className="lg:col-span-7 space-y-5 text-left">
                  <div className="bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl space-y-5">
                    <h3 className="text-sm font-bold font-sans uppercase tracking-widest text-[#00f0ff] border-b border-cyan-950 pb-2 flex items-center gap-1.5">
                      <User className="w-4 h-4 text-cyan-500" /> প্রোফাইলের বিস্তারিত বিবরণী (লাইন বাই লাইন)
                    </h3>
                    
                    <div className="space-y-1 font-sans">
                      <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                        <span className="text-slate-400">১. ইউজারনেম (Username):</span>
                        <span className="text-slate-100 font-bold">{userStats.name}</span>
                      </div>

                      <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                        <span className="text-slate-400">২. ফোরাম পদবি / রোল:</span>
                        <span className={`font-semibold ${styleProfile.textAccent}`}>{userStats.rank}</span>
                      </div>

                      <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                        <span className="text-slate-400">৩. ওয়ালেট ব্যালেন্স (৳):</span>
                        <span className="text-emerald-400 font-bold">{userStats.balance} ৳ BDT</span>
                      </div>

                      <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                        <span className="text-slate-400">৪. ফোরাম রিওয়ার্ড পয়েন্ট (XP):</span>
                        <span className="text-cyan-300 font-bold">{userStats.points} Point</span>
                      </div>

                      <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                        <span className="text-slate-400">৫. প্রকাশিত কন্টেন্ট সংখ্যা:</span>
                        <span className="text-white font-bold">{userStats.postsPublished} টি আর্টিকেল</span>
                      </div>

                      <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                        <span className="text-slate-400">৬. যাচাইাধীন (পেন্ডিং) পোস্ট:</span>
                        <span className="text-yellow-500 font-bold">{userStats.postsPending} টি পেন্ডিং</span>
                      </div>

                      <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                        <span className="text-slate-400">৭. গুগল এডসেন্স আরপিএম আরনিং:</span>
                        <span className="text-emerald-400 font-bold">১০.৪৫ ৳ এভারেজ</span>
                      </div>

                      <div className="flex justify-between items-center py-3 font-mono text-xs">
                        <span className="text-slate-400">৮. ফোরাম অ্যাকাউন্ট টাইপ:</span>
                        <span className="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-500 font-bold uppercase">PRO CREATIVE</span>
                      </div>
                    </div>
                  </div>
                </div>

                {/* Column Right (Col-sp-5): Wallet Balance & Cashout Controls */}
                <div className="lg:col-span-12 xl:col-span-5 space-y-6">
                
                  {/* Wallet Balance retract widget */}
                  <div className="bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl relative overflow-hidden text-left">
                    <h3 className="text-sm font-bold font-mono text-emerald-400 uppercase tracking-wide mb-4 flex items-center gap-1.5">
                      <Wallet className="w-5 h-5 text-emerald-400 animate-pulse" /> বিকাশ/নগদ ক্যাশআউট গেটওয়ে
                    </h3>

                    <div className="bg-slate-950/80 p-4 border border-cyan-950 rounded-xl mb-4 text-center">
                      <span className="text-[10px] text-slate-400 font-mono block uppercase">মোট বকেয়া ব্যালেন্স</span>
                      <span className="text-2xl font-bold text-emerald-400 font-mono block mt-1">{userStats.balance} ৳</span>
                      <span className="text-[9px] font-mono text-slate-500 mt-1 block">মিনিমাম প্রত্যাহার সীমা: ৫০ ৳ BDT</span>
                    </div>

                    <div className="bg-[#0c1813] border border-emerald-900/30 p-3.5 rounded-xl text-xs text-emerald-300 space-y-1.5 leading-relaxed font-sans mb-5">
                      <span className="font-bold text-emerald-400 block mb-1">📋 উত্তোলন গাইডলাইন:</span>
                      <p>১. আপনার ড্যাশবোর্ডে ৫০ টাকা বা তার বেশি ব্যালেন্স পূর্ণ হলে উত্তোলন করতে পারবেন।</p>
                      <p>২. প্রতিটি উইথড্র রিকোয়েস্ট ২ ঘণ্টার মধ্যে সম্পূর্ণ অটোমেটিক গেটওয়ে রিওয়ার্ড পেমেন্টে পরিশোধ হয়ে যাবে।</p>
                    </div>

                    <button
                      type="button"
                      onClick={handleApplyWithdrawal}
                      className="w-full flex items-center justify-center gap-2 text-xs font-mono font-bold uppercase bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-slate-950 py-3 rounded-xl shadow-lg cursor-pointer transform hover:scale-[1.01] transition-all"
                    >
                      💸 ৫০ ৳ সরাসরি উইথড্র করুন
                    </button>
                  </div>

                  {/* Notification portal link card widget */}
                  <div className="bg-gradient-to-br from-[#0c111e] to-[#050811] border border-cyan-950 rounded-2xl p-5 text-xs text-slate-400 text-left">
                    <h4 className="text-slate-200 font-bold font-sans text-xs mb-1.5">পেমেন্ট হিস্ট্রি ও মেসেজ ট্র্যাকার</h4>
                    <p className="text-[11.5px] text-slate-400 leading-relaxed font-sans">
                      আপনার যেকোনো ব্যালেন্স বোনাস এড বা টাকা উত্তোলনের রিকোয়েস্ট সরাসরি আপনার রিয়েল-টাইম বেল নোটিফিকেশনে পুশ মেসেজে চলে যাবে!
                    </p>
                  </div>

                </div>

              </div>
            </motion.div>
          )}

          {/* Tab: Cyber Socket Messenger */}
          {activeTab === "messages" && (
            <motion.div
              key="messages"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="max-w-6xl mx-auto space-y-6"
            >
              <CyberMessenger
                userStats={userStats}
                setUserStats={setUserStats}
                addSystemNotification={addSystemNotification}
                adminSettings={adminSettings}
                isLoggedIn={isLoggedIn}
                selectedContactName={selectedContactName}
                setSelectedContactName={setSelectedContactName}
              />
            </motion.div>
          )}

          {/* Tab 6: Core User Wallet Balance & Dashboard stats details */}
          {activeTab === "dashboard" && (
            <motion.div
              key="dashboard"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="max-w-4xl mx-auto space-y-6 text-left"
            >
              {/* Profile Card at Top of Dashboard */}
              <div 
                className="bg-[#090d16] border rounded-2xl p-6 relative overflow-hidden flex flex-col md:flex-row gap-6 items-center transition-all duration-300"
                style={adminSettings.glowUserProfile ? {
                  boxShadow: `0 0 35px ${adminSettings.glowUserProfileColor || "#bd00ff"}15`,
                  borderColor: `${adminSettings.glowUserProfileColor || "#bd00ff"}45`
                } : {
                  borderColor: "rgba(8, 145, 178, 0.25)",
                  boxShadow: "none"
                }}
              >
                <div className="absolute inset-0 bg-gradient-to-r from-cyan-500/5 to-transparent pointer-events-none" />
                
                {/* Avatar with dynamic mood border and glowing badge */}
                <div className="relative shrink-0 flex flex-col items-center">
                  <div className={`w-24 h-24 rounded-full border-2 ${styleProfile.borderAccent} p-1 ${styleProfile.glowColor} overflow-hidden bg-slate-950`}>
                    <img
                      src={userStats.avatar}
                      alt={userStats.name}
                      className="w-full h-full rounded-full object-cover"
                    />
                  </div>
                  <span className={`absolute -bottom-2 text-[9px] font-mono font-bold uppercase ${styleProfile.textAccent} bg-slate-950 px-2.5 py-0.5 rounded-full border ${styleProfile.borderAccent} tracking-wider`}>
                    {userStats.rank}
                  </span>
                </div>

                {/* Main profile text details */}
                <div className="flex-1 text-center md:text-left space-y-2">
                  <div className="flex flex-col md:flex-row md:items-center gap-2">
                    <h2 className="text-xl sm:text-2xl font-bold font-sans tracking-tight text-white">{userStats.name}</h2>
                    <span className="text-[10px] font-mono text-cyan-400 bg-cyan-950/80 px-2 py-0.5 rounded border border-cyan-900 self-center uppercase tracking-widest">
                      {isLoggedIn ? "সক্রিয় মেম্বার অ্যাকাউন্ট" : "গেস্ট রিভিউ"}
                    </span>
                  </div>
                  <p className="text-xs text-slate-400 font-sans max-w-lg leading-relaxed">
                    বাংলাদেশি কন্টেন্ট রাইটার ও কোডার ফোরামের অফিসিয়াল মেম্বার আইডি। আপনার কন্টেন্ট থেকে উপার্জিত মোট পয়েন্ট ও বিকাশ ওয়ালেট ব্যালেন্স নিচে পরিষ্কারভাবে লাইন বাই লাইন তালিকাভুক্ত করা হলো।
                  </p>
                  
                  {/* Inline profile edit buttons */}
                  <div className="flex flex-wrap items-center justify-center md:justify-start gap-2 pt-1.5">
                    <button
                      type="button"
                      onClick={() => {
                        const customName = prompt("আপনার নতুন ইউজারনেম লিখুন:", userStats.name);
                        if (customName && customName.trim()) {
                          setUserStats((v) => ({ ...v, name: customName.trim() }));
                          addSystemNotification("আপনার প্রোফাইল নাম সফলভাবে পরিবর্তন করা হয়েছে।", "system");
                        }
                      }}
                      className="text-[10px] font-mono px-3 py-1.5 bg-slate-950 hover:bg-[#0c1322] border border-cyan-950 hover:border-cyan-500 rounded text-cyan-400 hover:text-white transition-all cursor-pointer"
                    >
                      ✐ নাম পরিবর্তন
                    </button>
                    <button
                      type="button"
                      onClick={() => {
                        const seed = prompt("পছন্দের অ্যাভাটার সিড লিখুন (যেমন: coder-shohan):", "tester");
                        if (seed && seed.trim()) {
                          const newAv = `https://api.dicebear.com/7.x/pixel-art/svg?seed=${seed.trim()}`;
                          setUserStats((v) => ({ ...v, avatar: newAv }));
                          addSystemNotification("আপনার প্রোফাইল অ্যাভাটার আপডেট করা হয়েছে।", "system");
                        }
                      }}
                      className="text-[10px] font-mono px-3 py-1.5 bg-slate-950 hover:bg-[#0c1322] border border-cyan-950 hover:border-cyan-500 rounded text-cyan-400 hover:text-white transition-all cursor-pointer"
                    >
                      👤 অ্যাভাটার পরিবর্তন
                    </button>
                    <button
                      type="button"
                      onClick={() => {
                        const rk = prompt("ক্রু রোল পদবি লিখুন (যেমন: CONTRIBUTOR / ELITE CODER):", userStats.rank);
                        if (rk && rk.trim()) {
                          setUserStats((v) => ({ ...v, rank: rk.trim().toUpperCase() }));
                          addSystemNotification(`আপনার ফোরাম কুয়েরি পদবি সফলভাবে ‘${rk}’ এ আপডেট করা হয়েছে।`, "system");
                        }
                      }}
                      className="text-[10px] font-mono px-3 py-1.5 bg-slate-[#090d16] hover:bg-[#0c1322] border border-cyan-950 hover:border-cyan-500 rounded text-[#00f0ff] hover:text-white transition-all cursor-pointer"
                    >
                      ⚙️ পদবি পরিবর্তন
                    </button>
                  </div>
                </div>
              </div>

              {/* Grid 2-columns (Left: Beautiful Line-by-Line List, Right: Wallet Balance & Payout Control) */}
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                {/* Column Left (Col-sp-7): Supercharged Cyber Referral & Milestones Center */}
                <div className="lg:col-span-7 bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl relative overflow-hidden text-left space-y-6">
                  {/* Decorative element */}
                  <div className="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-500/10 to-transparent blur-2xl rounded-full pointer-events-none" />

                  <div className="border-b border-cyan-950 pb-4 flex justify-between items-center">
                    <div>
                      <h3 className="text-base font-bold font-sans tracking-tight text-white flex items-center gap-2">
                        <Gift className="w-5.5 h-5.5 text-[#00f0ff] animate-pulse" />
                        আনলিমিটেড আর্নিং রেফারেল পোর্টাল (২০৪০ এলিট)
                      </h3>
                      <p className="text-[11px] text-slate-400 font-mono mt-0.5 uppercase">
                        ✓ প্রতি সফল রেফারে ১০ ৳ + ৫০XP বোনাস এবং আকর্ষণীয় মাইলস্টোন ক্যাশ প্রাইজ!
                      </p>
                    </div>
                  </div>

                  {/* Referral Code & Copy Segment */}
                  <div className="bg-slate-950/70 border border-cyan-950 p-4.5 rounded-xl space-y-3.5">
                    <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2.5">
                      <div>
                        <span className="text-[10px] font-mono text-cyan-500 uppercase tracking-wider block">আপনার কাস্টম রেফারেল কোড:</span>
                        <div className="flex items-center gap-2.5 mt-1">
                          <code className="text-base font-mono font-black text-transparent bg-clip-text bg-gradient-to-r from-[#00f0ff] to-[#39ff14] select-all">
                            {userStats.referralCode || `REF-${userStats.name.replace(/\s+/g, "").toUpperCase().substring(0, 7)}420`}
                          </code>
                          <button
                            type="button"
                            onClick={() => {
                              const code = userStats.referralCode || `REF-${userStats.name.replace(/\s+/g, "").toUpperCase().substring(0, 7)}420`;
                              navigator.clipboard.writeText(code);
                              addSystemNotification("রেফারেল কোড সফলভাবে কপি করা হয়েছে!", "system");
                            }}
                            className="bg-[#0c1a2d] hover:bg-cyan-950 text-cyan-400 p-1.5 rounded-lg border border-cyan-900 cursor-pointer text-[10px] uppercase font-mono px-2.5 py-1.5 flex items-center gap-1 transition-all"
                          >
                            <Copy className="w-3.5 h-3.5" /> কপি করুন
                          </button>
                        </div>
                      </div>

                      {/* Simulation Button */}
                      <div className="w-full sm:w-auto">
                        <button
                          type="button"
                          onClick={handleSimulateReferral}
                          disabled={isRefSimulating}
                          className="w-full bg-gradient-to-r from-cyan-600 via-teal-600 to-emerald-600 hover:from-cyan-500 hover:to-emerald-500 text-slate-950 font-bold font-sans text-xs px-4 py-2.5 rounded-xl transition-all shadow-[0_0_15px_rgba(0,240,255,0.15)] disabled:opacity-50 flex items-center justify-center gap-1.5 cursor-pointer animate-pulse-slow"
                        >
                          <Terminal className="w-4 h-4" /> 
                          {isRefSimulating ? "সিকিউর টার্নেল লোড হচ্ছে..." : "🚀 নতুন রেফারেল সিমুলেট (টেস্ট)"}
                        </button>
                      </div>
                    </div>

                    {/* Simulation Terminal Log Window */}
                    {(isRefSimulating || refTermLogs.length > 0) && (
                      <div className="bg-[#030610] border border-cyan-950 rounded-lg p-3.5 font-mono text-[10.5px] text-[#39ff14] space-y-1 max-h-[140px] overflow-y-auto custom-scrollbar shadow-inner text-left">
                        <div className="flex items-center justify-between border-b border-cyan-950 pb-1.5 mb-1.5 text-slate-500 text-[9px] uppercase font-bold">
                          <span>SYSTEM PORTAL SHELL</span>
                          <span className="animate-pulse">● TRANSACTING</span>
                        </div>
                        {refTermLogs.map((log, i) => (
                          <div key={i} className="leading-relaxed">
                            <span className="text-cyan-500">guest@iloveyoubd:~$</span> {log}
                          </div>
                        ))}
                      </div>
                    )}
                  </div>

                  {/* Milestone Checkpoints Timeline */}
                  <div className="space-y-3.5 text-left">
                    <h4 className="text-xs font-bold font-mono text-[#00f0ff] uppercase tracking-widest flex items-center gap-1">
                      <Award className="w-4.5 h-4.5 text-yellow-500" /> রেফারেল মাইলস্টোন ও বোনাস লেভেলস
                    </h4>

                    {/* Progress status */}
                    <div className="bg-[#050a14] border border-cyan-950 p-4.5 rounded-xl space-y-4">
                      <div className="flex justify-between items-center text-xs font-mono">
                        <span className="text-slate-400">আপনার মোট সফল রেফারেলস:</span>
                        <span className="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-500 font-black text-sm bg-yellow-950/40 px-2.5 py-0.5 rounded border border-yellow-900/30">
                          {userStats.referredUsers?.length || 0} টি রেফারেলস
                        </span>
                      </div>

                      {/* Interactive Visual Progress Bar */}
                      <div className="relative pt-1 font-mono">
                        <div className="overflow-hidden h-2.5 text-xs flex rounded bg-slate-900 border border-cyan-950">
                          <div
                            style={{ width: `${Math.min(((userStats.referredUsers?.length || 0) / 50) * 100, 100)}%` }}
                            className="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-cyan-500 to-emerald-500 transition-all duration-500"
                          />
                        </div>
                        {/* Milestone indicators along progress bar */}
                        <div className="flex justify-between text-[8px] text-slate-400 mt-2">
                          <span className="font-extrabold text-[#00f0ff]">০</span>
                          <span>৫ (Rookie)</span>
                          <span>১০ (Elite)</span>
                          <span>২৫ (Titan)</span>
                          <span className="font-extrabold text-yellow-500">৫০ (Overlord)</span>
                        </div>
                      </div>

                      {/* Milestones claims list */}
                      <div className="grid grid-cols-1 md:grid-cols-2 gap-2.5 pt-1">
                        {[
                          { count: 1, reward: 10, name: "মাইলস্টোন ০১" },
                          { count: 5, reward: 50, name: "রেফারেল এলিট ক্রু" },
                          { count: 10, reward: 150, name: "নেটওয়ার্ক টাইটান" },
                          { count: 25, reward: 500, name: "ইনফ্লুয়েন্সার কিং" },
                          { count: 50, reward: 1500, name: "রেফারেল ওভারলর্ড সিল" }
                        ].map((m) => {
                          const isClaimed = claimedMilestones.includes(m.count);
                          const userRefLength = userStats.referredUsers?.length || 0;
                          const isQualified = userRefLength >= m.count;

                          return (
                            <div
                              key={m.count}
                              className={`p-3 rounded-lg border flex justify-between items-center text-xs font-sans relative overflow-hidden ${
                                isClaimed
                                  ? "bg-[#061511] border-emerald-950/40 text-emerald-300"
                                  : isQualified
                                  ? "bg-[#091a24] border-cyan-500 text-slate-100 shadow-[0_0_10px_rgba(0,240,255,0.05)] cursor-pointer"
                                  : "bg-[#050811] border-cyan-950/60 text-slate-400"
                              }`}
                            >
                              <div>
                                <span className="block font-bold text-[11.5px]">{m.name}</span>
                                <span className={`text-[9.5px] font-mono uppercase block mt-0.5 ${isClaimed ? "text-emerald-500" : isQualified ? "text-cyan-400 font-bold" : "text-slate-500"}`}>
                                  {m.count} রেফারেল বোনাস 
                                </span>
                              </div>
                              
                              <div className="flex flex-col items-end gap-1 font-mono">
                                <span className="text-[11.5px] font-black text-yellow-400 block">+{m.reward} ৳ BDT</span>
                                
                                {isClaimed ? (
                                  <span className="text-[8.5px] font-mono text-emerald-400 border border-emerald-950 bg-emerald-950 px-1.5 py-0.2 rounded uppercase flex items-center gap-0.5">
                                    ✓ ক্লেইমড
                                  </span>
                                ) : isQualified ? (
                                  <button
                                    type="button"
                                    onClick={() => handleClaimMilestone(m.count, m.reward, m.name)}
                                    className="bg-gradient-to-r from-yellow-400 to-amber-500 hover:from-yellow-300 hover:to-amber-400 text-slate-950 text-[9px] font-mono font-bold px-2 py-0.5 rounded cursor-pointer animate-pulse uppercase tracking-wider shadow"
                                  >
                                    ক্লেইম করুন
                                  </button>
                                ) : (
                                  <span className="text-[8.5px] font-mono text-slate-600 bg-slate-950 px-1.5 py-0.2 rounded uppercase border border-cyan-950/40">
                                    🔒 লকড
                                  </span>
                                )}
                              </div>
                            </div>
                          );
                        })}
                      </div>
                    </div>
                  </div>

                  {/* Viral facebook/telegram copy templates section */}
                  <div className="space-y-3.5 text-left text-xs">
                    <h4 className="font-bold font-mono text-[#00f0ff] uppercase tracking-widest flex items-center gap-1">
                      <Share2 className="w-4.5 h-4.5 text-cyan-400" /> প্রচার বুস্ট প্যাক: কাস্টম ভাইরাল কপি কন্টেন্ট
                    </h4>
                    
                    <div className="p-4 bg-[#050a14] border border-cyan-950 rounded-xl space-y-3 font-sans text-slate-300">
                      <p className="text-[10.5px] text-slate-400 leading-relaxed font-sans">
                        নিচের রেডিমেড প্রমোশনাল টেমপ্লেটটি কপি করে ফেসবুক কুয়েরি গ্রুপ, টেলিগ্রাম বা হোয়াটসঅ্যাপে পোস্ট করে বেশি মেম্বার রেফার করুন ও পেমেন্ট বিকাশ ওয়ালেটে ক্যাশআউট করুন:
                      </p>

                      <div className="bg-slate-950 border border-cyan-950/60 rounded-lg p-3 relative font-sans leading-relaxed text-slate-200 pr-12 text-[11px]">
                        "🔥 iloveyoubd.com-এ সাইবার সিকিউরিটি রিসার্চ ও কন্টেন্ট লিখে প্রতি মাসে আনলিমিটেড টাকা ইনকাম করুন! আমার রেফারেল কোড: <span className="text-yellow-400 uppercase font-mono">{userStats.referralCode || `REF-${userStats.name.replace(/\s+/g, "").toUpperCase().substring(0, 7)}420`}</span>। পেমেন্ট সরাসরি বিকাশ এবং নগদে!"
                        <button
                          type="button"
                          onClick={() => {
                            const code = userStats.referralCode || `REF-${userStats.name.replace(/\s+/g, "").toUpperCase().substring(0, 7)}420`;
                            const template = `🔥 iloveyoubd.com-এ সাইবার সিকিউরিটি রিসার্চ ও কন্টেন্ট লিখে প্রতি মাসে আনলিমিটেড টাকা ইনকাম করুন! আমার রেফারেল কোড: ${code}। পেমেন্ট সরাসরি বিকাশ এবং নগদে!`;
                            navigator.clipboard.writeText(template);
                            addSystemNotification("প্রমোশনাল টেমপ্লেট কপি করা হয়েছে!", "system");
                          }}
                          className="absolute right-2 top-2 bg-slate-900 border border-cyan-950 hover:bg-cyan-950 text-cyan-400 p-1.5 rounded cursor-pointer"
                          title="কপি টেমপ্লেট"
                        >
                          <Copy className="w-3.5 h-3.5" />
                        </button>
                      </div>
                    </div>
                  </div>

                  {/* Referred Users list badges */}
                  {userStats.referredUsers && userStats.referredUsers.length > 0 && (
                    <div className="space-y-3.5 text-left text-xs">
                      <h4 className="font-bold font-mono text-emerald-400 uppercase tracking-widest">
                        👥 আপনার আমন্ত্রিত ইউজারগণ ({userStats.referredUsers.length} জন)
                      </h4>
                      <div className="flex flex-wrap gap-1.5 bg-slate-950 p-3 rounded-xl border border-cyan-950/40">
                        {userStats.referredUsers.map((name, i) => (
                          <span key={i} className="text-[10px] font-mono text-slate-300 bg-[#09151c] border border-cyan-950 px-2.5 py-1 rounded">
                            👤 {name}
                          </span>
                        ))}
                      </div>
                    </div>
                  )}

                  {/* Local Competitive Leaderboard */}
                  <div className="space-y-3.5 text-left text-xs">
                    <h4 className="font-bold font-mono text-[#00f0ff] uppercase tracking-widest flex items-center gap-1">
                      <TrendingUp className="w-4.5 h-4.5 text-cyan-400" /> শীর্ষ রেফারার মেম্বারবোর্ড (বাংলাদেশী কিলারবোর্ড)
                    </h4>
                    
                    <div className="bg-[#050a14] border border-cyan-950 rounded-xl overflow-hidden font-mono text-[11px]">
                      <div className="grid grid-cols-12 bg-slate-950/60 p-2.5 border-b border-cyan-950 text-slate-500 font-bold uppercase tracking-wider text-[9px]">
                        <span className="col-span-3 text-left">মর্যাদা / র‌্যাঙ্ক</span>
                        <span className="col-span-6 text-left">আমন্ত্রণকারী মেম্বার</span>
                        <span className="col-span-3 text-right">ইনভাইট ইনকাম</span>
                      </div>
                      
                      <div className="divide-y divide-cyan-950/30">
                        <div className="grid grid-cols-12 p-2.5 items-center bg-yellow-950/10">
                          <span className="col-span-3 text-left font-black text-yellow-400 text-xs">👑 ১ম প্লেস</span>
                          <span className="col-span-6 text-left font-sans text-slate-250 font-bold">রেজোওয়ানুল সানি (৪৩ জন)</span>
                          <span className="col-span-3 text-right text-emerald-400 font-bold">৬০৫ ৳ BDT</span>
                        </div>
                        <div className="grid grid-cols-12 p-2.5 items-center">
                          <span className="col-span-3 text-left font-bold text-slate-300">🥈 ২য় প্লেস</span>
                          <span className="col-span-6 text-left font-sans text-slate-300">সাইবার জিম হ্যাকার (২৮ জন)</span>
                          <span className="col-span-3 text-right text-emerald-400 font-bold">৩৯০ ৳ BDT</span>
                        </div>
                        <div className="grid grid-cols-12 p-2.5 items-center bg-[#090d16]/40">
                          <span className="col-span-3 text-left font-bold text-amber-600">🥉 ৩য় প্লেস</span>
                          <span className="col-span-6 text-left font-sans text-slate-300 font-bold">আপনি ({userStats.name}) ({userStats.referredUsers?.length || 0} জন)</span>
                          <span className="col-span-3 text-right text-emerald-400 font-bold">{(userStats.referralEarnings || 0).toFixed(2)} ৳ BDT</span>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                {/* Column Right (Col-sp-5): Wallet Balance & Cashout Controls */}
                <div className="lg:col-span-12 xl:col-span-5 space-y-6">
                  
                  {/* Wallet Balance retract widget */}
                  <div 
                    className="bg-[#090d16] border rounded-2xl p-6 relative overflow-hidden text-left transition-all duration-300"
                    style={adminSettings.glowWallet ? {
                      boxShadow: `0 0 35px ${adminSettings.glowWalletColor || "#39ff14"}15`,
                      borderColor: `${adminSettings.glowWalletColor || "#39ff14"}45`
                    } : {
                      borderColor: "rgba(8, 145, 178, 0.25)",
                      boxShadow: "none"
                    }}
                  >
                    <h3 className="text-sm font-bold font-mono text-emerald-400 uppercase tracking-wide mb-4 flex items-center gap-1.5">
                      <Wallet className="w-5 h-5 text-emerald-400 animate-pulse" /> বিকাশ/নগদ ক্যাশআউট গেটওয়ে
                    </h3>

                    <div className="bg-slate-950/80 p-4 border border-cyan-950 rounded-xl mb-4 text-center">
                      <span className="text-[10px] text-slate-400 font-mono block uppercase">মোট বকেয়া ব্যালেন্স</span>
                      <span className="text-2xl font-bold text-emerald-400 font-mono block mt-1">{userStats.balance} ৳</span>
                      <span className="text-[9px] font-mono text-slate-500 mt-1 block">মিনিমাম প্রত্যাহার সীমা: ৫০ ৳ BDT</span>
                    </div>

                    <div className="bg-[#0c1813] border border-emerald-900/30 p-3.5 rounded-xl text-xs text-emerald-300 space-y-1.5 leading-relaxed font-sans mb-5">
                      <span className="font-bold text-emerald-400 block mb-1">📋 উত্তোলন গাইডলাইন:</span>
                      <p>১. আপনার ড্যাশবোর্ডে ৫০ টাকা বা তার বেশি ব্যালেন্স পূর্ণ হলে উত্তোলন করতে পারবেন।</p>
                      <p>২. প্রতিটি উইথড্র রিকোয়েস্ট ২ ঘণ্টার মধ্যে সম্পূর্ণ অটোমেটিক গেটওয়ে রিওয়ার্ড পেমেন্টে পরিশোধ হয়ে যাবে।</p>
                    </div>

                    <button
                      onClick={handleApplyWithdrawal}
                      className="w-full flex items-center justify-center gap-2 text-xs font-mono font-bold uppercase bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-slate-950 py-3 rounded-xl shadow-lg cursor-pointer transform hover:scale-[1.01] transition-all"
                    >
                      💸 ৫০ ৳ সরাসরি উইথড্র করুন
                    </button>
                  </div>

                  {/* Notification portal link card widget */}
                  <div className="bg-gradient-to-br from-[#0c111e] to-[#050811] border border-cyan-950 rounded-2xl p-5 text-xs text-slate-400 text-left">
                    <h4 className="text-slate-200 font-bold font-sans text-xs mb-1.5">পেমেন্ট হিস্ট্রি ও মেসেজ ট্র্যাকার</h4>
                    <p className="text-[11.5px] text-slate-400 leading-relaxed font-sans">
                      আপনার যেকোনো ব্যালেন্স বোনাস এড বা টাকা উত্তোলনের রিকোয়েস্ট সরাসরি আপনার রিয়েল-টাইম বেল নোটিফিকেশনে পুশ মেসেজে চলে যাবে!
                    </p>
                  </div>

                </div>

              </div>
            </motion.div>
          )}

          {/* Tab 7: Admin Control Settings panel */}
          {activeTab === "admin" && (
            <motion.div
              key="admin"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <AdminPanel
                settings={adminSettings}
                onUpdateSettings={(updated) => setAdminSettings((prev) => ({ ...prev, ...updated }))}
                selectedMood={selectedMood}
                onMoodChange={(m) => setSelectedMood(m)}
                onGenerateAIPost={handleAdminTriggerAIPost}
                isGeneratingAIPost={isGeneratingAIPost}
                totalWithdrawn={totalWithdrawn}
                withdrawalRequests={withdrawalRequests}
                onApproveWithdrawal={handleApproveWithdrawal}
                onTriggerInstantAutopilot={handleTriggerAutopilotPost}
                posts={posts}
                setPosts={setPosts}
                currentUser={userStats}
                addNotification={addSystemNotification}
                allUsers={allUsers}
                onUpdateUserStats={handleUpdateUserStats}
                ledger={ledger}
                setLedger={setLedger}
                onAddLedgerTransaction={addLedgerTransaction}
              />
            </motion.div>
          )}

          {/* Tab 8: Legal Policy & Compliance Center */}
          {["privacy", "terms", "disclaimer", "about", "contact-us"].includes(activeTab) && (
            <motion.div
              key="legal-center"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <LegalCenter
                initialTab={activeTab as "privacy" | "terms" | "disclaimer" | "about" | "contact-us"}
                onChangeTab={(tab) => {
                  setActiveTab(tab);
                  setSelectedPostId(null);
                }}
              />
            </motion.div>
          )}

        </AnimatePresence>
      </main>

      {/* COMPREHENSIVE CYBER MULTI-COLUMN FOOTER */}
      {adminSettings.enableFooterRgb !== false && (
        <RGBBorder 
          height="h-[3px]" 
          disabled={!adminSettings.enableRgbEffects} 
          stylePreset={adminSettings.rgbStyle || "classic_neo"}
          speed={adminSettings.rgbEffectSpeed || "medium"}
          activeColor={
            selectedMood === "green" ? "#39ff14" :
            selectedMood === "cyan" ? "#00f0ff" :
            selectedMood === "violet" ? "#bd00ff" :
            selectedMood === "crimson" ? "#ff003c" : "#eab308"
          } 
        />
      )}
      <footer className="border-t border-cyan-950/50 bg-[#040811] py-10 mt-16 relative">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-12 gap-8 text-left">
          
          {/* Col 1: About the portal */}
          <div className="md:col-span-4 space-y-3">
            <div className="flex items-center gap-2">
              <Terminal className={`w-5 h-5 ${styleProfile.textAccent}`} />
              <span className="font-bold text-sm tracking-widest uppercase">
                iloveyoubd.com <span className={styleProfile.textAccent}>SYSTEMS</span>
              </span>
            </div>
            
            <p className="text-xs text-slate-400 font-sans leading-relaxed">
              iloveyoubd.com হল বাংলাদেশের বিখ্যাত প্রযুক্তি বিষয়ক হ্যাকিং ও মাল্টি-অটোর ডিস্ট্রিবিউটেড ব্লগিং পোর্টাল। এখানে সিক্লিউড অ্যাডসেন্স কোডিং এপিআই মেম্বারদের সরাসরি আরজিবি লাইটিং মনিটাইজেশন ড্যাশবোর্ডে সাপোর্ট দেওয়া হয়।
            </p>

            <div className="flex items-center gap-2 pt-2 text-slate-500 font-medium text-[11px] font-sans">
              <ShieldCheck className="w-4 h-4 text-[#39ff14]" />
              <span>নিরাপদ এসইও এবং গুগল এডসেন্স ফ্রেন্ডলি কোড ভেরিফাইড</span>
            </div>
          </div>

          {/* Col 2: Fast index links */}
          <div className="md:col-span-3 space-y-3">
            <h4 className="text-xs uppercase font-mono tracking-widest text-[#00f0ff] font-bold">পেজ সূচক (Sitemaps)</h4>
            <ul className="space-y-2 text-xs text-slate-300 font-medium font-sans font-sans">
              <li>
                <button 
                  onClick={() => { setActiveTab("home"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-[10px]">➔</span> হোম ফিড ও ট্রিকস
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("ai"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-[10px]">➔</span> গেমিনি এআই ডাস্টবোট
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("add"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-[10px]">➔</span> কন্টেন্ট আর্নিং পোর্টাল
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("tools-lab"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-cyan-405 text-[10px]">➔</span> এআই টুলস ল্যাব 🧪
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("nid"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-[10px]">➔</span> এনআইডি কার্ড জেনারেটর
                </button>
              </li>
            </ul>
          </div>

          {/* Col 3: AdSense Policy & Legal Pages */}
          <div className="md:col-span-3 space-y-3">
            <h4 className="text-xs uppercase font-mono tracking-widest text-[#39ff14] font-bold">আইনি ও এডসেন্স নীতি (Legal Rules)</h4>
            <ul className="space-y-2 text-xs text-slate-300 font-medium font-sans">
              <li>
                <button 
                  onClick={() => { setActiveTab("privacy"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-cyan-400 transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-cyan-400 text-[10px]">🛡️</span> প্রাইভেসি পলিসি (Privacy Policy)
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("terms"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-purple-400 transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-purple-300 text-[10px]">📜</span> ব্যবহারের শর্তাবলী (Terms)
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("disclaimer"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-amber-400 transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-amber-405 text-[10px]">⚠️</span> ডিসক্লেইমার (Disclaimer)
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("about"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-emerald-400 transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-emerald-400 text-[10px]">ℹ️</span> আমাদের সম্পর্কে (About Us)
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("contact-us"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-rose-400 transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-rose-400 text-[10px]">📧</span> যোগাযোগ করুন (Contact Us)
                </button>
              </li>
            </ul>
          </div>

          {/* Col 4: Legal cyber indices */}
          <div className="md:col-span-2 space-y-3">
            <h4 className="text-xs uppercase font-mono tracking-widest text-[#bd00ff] font-bold">সিকিউরিটি ও ট্রাস্ট</h4>
            <div className="bg-[#070c14] border border-cyan-950 p-2.5 rounded text-[10px] font-sans leading-relaxed text-slate-400 space-y-1">
              <div className="flex justify-between">
                <span>ইনডেক্সার:</span>
                <span className="text-emerald-400 font-mono">১০০% ওকে</span>
              </div>
              <div className="flex justify-between">
                <span>সিকিউরিটি স্কোর:</span>
                <span className="text-cyan-400 font-mono font-bold">A+ Superb</span>
              </div>
              <div className="flex justify-between">
                <span>গুগল এডসেন্স:</span>
                <span className="text-[#39ff14] font-mono">Verified</span>
              </div>
            </div>

            {/* Dynamic Realtime Clock Portal */}
            <div className="text-[9px] text-slate-500 font-mono flex items-center gap-1.5 justify-end pt-1">
              <Clock className="w-3 h-3" />
              <span>Dhaka UTC • Active</span>
            </div>
          </div>

        </div>

        <div className="max-w-7xl mx-auto px-4 mt-8 pt-4 border-t border-cyan-950 flex flex-col sm:flex-row justify-between items-center gap-2 text-[11px] text-slate-500 font-mono">
          <span>© 2026-2040 ILOVEYOUBD.COM ALL RIGHTS RESERVED.</span>
          <span>সর্বোচ্চ সুরক্ষায় হোস্টকৃত এবং গুগল সার্টিফাইড</span>
        </div>
      </footer>

      {/* Dynamic Cyber Authentication Modal (Login / Registration) */}
      <AnimatePresence>
        {showAuthModal && (
          <div className="fixed inset-0 bg-black/85 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <motion.div
              initial={{ scale: 0.9, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              exit={{ scale: 0.9, opacity: 0 }}
              className="bg-[#090d16] border border-cyan-500/40 rounded-2xl w-full max-w-md overflow-hidden relative shadow-[0_0_50px_rgba(0,240,255,0.15)] text-left"
            >
              {/* RGB border at top of modal */}
              <div className="h-[2px] bg-gradient-to-r from-cyan-400 via-pink-500 to-yellow-400" />
              
              <div className="p-6 relative">
                {/* Close Button */}
                <button
                  onClick={() => setShowAuthModal(false)}
                  className="absolute top-4 right-4 text-slate-400 hover:text-white text-sm font-mono cursor-pointer"
                >
                  ✕
                </button>

                {/* Tabs */}
                <div className="flex gap-4 border-b border-cyan-950 pb-3 mb-5">
                  <button
                    onClick={() => setAuthModalTab("register")}
                    className={`font-sans text-sm font-bold pb-2 transition-all cursor-pointer ${
                      authModalTab === "register"
                        ? "text-[#00f0ff] border-b-2 border-[#00f0ff]"
                        : "text-slate-400 hover:text-slate-200"
                    }`}
                  >
                    নতুন রেজিস্ট্রেশন
                  </button>
                  <button
                    onClick={() => setAuthModalTab("login")}
                    className={`font-sans text-sm font-bold pb-2 transition-all cursor-pointer ${
                      authModalTab === "login"
                        ? "text-[#00f0ff] border-b-2 border-[#00f0ff]"
                        : "text-slate-400 hover:text-slate-200"
                    }`}
                  >
                    সরাসরি লগইন
                  </button>
                </div>

                {authModalTab === "register" ? (
                  /* REGISTRATION FORM */
                  <form
                    onSubmit={(e) => {
                      e.preventDefault();
                      const formData = new FormData(e.currentTarget);
                      const regName = formData.get("username") as string;
                      const regRole = formData.get("userrole") as string;
                      const avatarSeed = formData.get("avatarSeed") as string || "tester";
                      const referralCode = (formData.get("referral") as string || "").trim();

                      if (regName && regName.trim()) {
                        const newAvatar = `https://api.dicebear.com/7.x/pixel-art/svg?seed=${avatarSeed}`;
                        
                        // Default starting gifts
                        let startBalance = 10.00;
                        let startPoints = 100;
                        let noticeMessage = `অভিনন্দন ${regName}! আপনার রেজিস্ট্রেশন সফল হয়েছে এবং ১০ টাকা বোনাস ওয়ালেটে যুক্ত হয়েছে।`;

                        // If referral code is applied
                        if (referralCode) {
                          const refereeTaka = adminSettings.refereeBonusTaka !== undefined ? adminSettings.refereeBonusTaka : 10;
                          const refereeXp = adminSettings.refereeXpReward !== undefined ? adminSettings.refereeXpReward : 100;
                          
                          startBalance += refereeTaka;
                          startPoints += refereeXp;
                          
                          noticeMessage = `🎯 রেফারেল কোড (${referralCode}) সফলভাবে প্রয়োগ করা হয়েছে! অভিনন্দন ${regName}, আপনার বিশেষ স্পেশাল জয়েনিং বোনাস ওয়ালেটে যুক্ত হয়েছে: +${refereeTaka} BDT এবং +${refereeXp} XP!`;
                        }

                        setUserStats({
                          name: regName.trim(),
                          avatar: newAvatar,
                          balance: startBalance, 
                          points: startPoints, 
                          rank: regRole,
                          postsPublished: 0,
                          postsPending: 0,
                          referralCode: `REF-${regName.replace(/\s+/g, "").toUpperCase().substring(0, 7)}420`,
                          referredBy: referralCode || undefined,
                          referredUsers: [],
                          referralEarnings: 0
                        });

                        setIsLoggedIn(true);
                        setShowAuthModal(false);
                        addSystemNotification(noticeMessage, "system");
                      }
                    }}
                    className="space-y-4"
                  >
                    <div>
                      <label className="block text-xs font-mono text-slate-400 uppercase mb-1">ইউজারনেম (Username):</label>
                      <input
                        type="text"
                        name="username"
                        required
                        placeholder="যেমন: তারেক রানা"
                        className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded-lg p-2.5 text-slate-100"
                      />
                    </div>

                    <div>
                      <label className="block text-xs font-mono text-slate-400 uppercase mb-1">ইউজার রোল / পদবি (Rank Title):</label>
                      <select
                        name="userrole"
                        className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded-lg p-2.5 text-slate-200 font-mono"
                      >
                        <option value="WHITE HAT CODER">WHITE HAT CODER</option>
                        <option value="CYBER SECURITY EXPERT">CYBER SECURITY EXPERT</option>
                        <option value="ELITE BLOGGER">ELITE BLOGGER</option>
                        <option value="CONTRIBUTOR">CONTRIBUTOR</option>
                        <option value="VISITOR FIGHTER">VISITOR FIGHTER</option>
                      </select>
                    </div>

                    <div>
                      <label className="block text-xs font-mono text-slate-400 uppercase mb-1">অ্যাভাটার সিড (Avatar Seed):</label>
                      <input
                        type="text"
                        name="avatarSeed"
                        placeholder="যেকোনো নাম বা নম্বর লিখুন যেমন: hackpro"
                        className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded-lg p-2.5 text-slate-100"
                      />
                    </div>

                    <div>
                      <label className="block text-xs font-mono text-[#00f0ff] uppercase mb-1 flex items-center justify-between">
                        <span>রেফারেল কোড (Optional Referral Code):</span>
                        <span className="text-[9px] text-[#39ff14] font-normal lowercase font-sans">কমিশন বোনাস অ্যাক্টিভেট করুন</span>
                      </label>
                      <input
                        type="text"
                        name="referral"
                        placeholder="যেমন: REF-TAREK420"
                        className="w-full text-xs bg-[#070b13] border border-emerald-950/80 focus:border-[#39ff14] focus:outline-none rounded-lg p-2.5 text-[#39ff14] font-mono tracking-wider uppercase placeholder:text-slate-700"
                      />
                    </div>

                    <div className="bg-[#050911] p-3 rounded border border-cyan-950 text-[10px] leading-relaxed text-slate-400 font-mono space-y-1">
                      <div>🔒 আপনার রেজিস্ট্রেশন সরাসরি ব্রাউজারে নিরাপদ মেমোরিতে সুরক্ষিত থাকবে।</div>
                      <div className="text-slate-500 font-sans">
                        * সাধারণ জয়েনিং ফি: <span className="text-slate-300 font-mono">১০ টাকা + ১০০ XP</span>
                      </div>
                      <div className="text-emerald-400/90 font-sans">
                        * রেফারেল কোড ব্যবহারে বোনাস: <span className="text-[#39ff14] font-mono">+{adminSettings.refereeBonusTaka || 10} টাকা + {adminSettings.refereeXpReward || 100} XP অতিরিক্ত স্পেশাল গিফট!</span>
                      </div>
                    </div>

                    <button
                      type="submit"
                      className={`w-full bg-gradient-to-r ${styleProfile.btnGradient} text-[#070b13] font-bold text-xs py-2.5 rounded-lg cursor-pointer font-mono text-center uppercase tracking-wider`}
                    >
                      রেজিস্ট্রেশন সম্পূর্ণ করুন 🚀
                    </button>
                  </form>
                ) : (
                  /* LOGIN FORM */
                  <form
                    onSubmit={(e) => {
                      e.preventDefault();
                      const formData = new FormData(e.currentTarget);
                      const username = formData.get("loginname") as string;
                      if (username && username.trim()) {
                        setUserStats((prev) => ({
                          ...prev,
                          name: username.trim()
                        }));
                        setIsLoggedIn(true);
                        setShowAuthModal(false);
                        addSystemNotification(`স্বাগতম ব্যাক, ${username.trim()}! সফলভাবে সাইটে লগইন করা হয়েছে।`, "system");
                      }
                    }}
                    className="space-y-4"
                  >
                    <div>
                      <label className="block text-xs font-mono text-slate-400 uppercase mb-1">আপনার রেজিস্টার্ড ইউজারনেম:</label>
                      <input
                        type="text"
                        name="loginname"
                        required
                        placeholder="যেমন: তারেক রহমান"
                        className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded-lg p-2.5 text-slate-100"
                      />
                    </div>

                    <div className="bg-[#050911] p-3 rounded border border-cyan-950 text-[10px] leading-relaxed text-slate-400 font-mono font-sans">
                      💡 আপনার আগের ডেটা ফিরে পেতে সঠিক ইউজারনেম দিয়ে লগইন করুন। যেকোনো নাম লিখলেও নতুন কোডার অ্যাকাউন্ট অ্যাক্টিভ হবে।
                    </div>

                    <button
                      type="submit"
                      className={`w-full bg-gradient-to-r ${styleProfile.btnGradient} text-[#070b13] font-bold text-xs py-2.5 rounded-lg cursor-pointer font-mono text-center`}
                    >
                      লগইন করুন 🔓
                    </button>
                  </form>
                )}
              </div>
            </motion.div>
          </div>
        )}
      </AnimatePresence>

      {/* TRICKBD STYLE MOBILE STICKY BOTTOM NAVIGATION BAR */}
      <nav id="mobile-sticky-bottom-nav" className="md:hidden fixed bottom-0 left-0 right-0 bg-gradient-to-b from-[#0e1422] to-[#070b13] backdrop-blur-lg border-t-2 border-purple-500/30 py-3 px-4 z-45 flex justify-around items-center shadow-[0_-10px_30px_rgba(0,0,0,0.8)]">
        <button
          onClick={() => {
            setActiveTab("home");
            setSelectedPostId(null);
          }}
          className={`flex flex-col items-center justify-center gap-1 text-[11.5px] font-bold font-sans cursor-pointer transition-all duration-300 transform active:scale-95 ${
            activeTab === "home" ? "text-cyan-400 scale-110 shadow-[0_0_15px_rgba(34,211,238,0.1)] font-bold" : "text-slate-400 hover:text-white"
          }`}
        >
          <Home className={`w-5.5 h-5.5 transition-transform duration-300 ${activeTab === "home" ? "stroke-[2.5px]" : ""}`} />
          <span>হোম</span>
        </button>
        
        <button
          onClick={() => {
            setActiveTab("tv");
            setSelectedPostId(null);
          }}
          className={`flex flex-col items-center justify-center gap-1 text-[11.5px] font-bold font-sans cursor-pointer transition-all duration-300 transform active:scale-95 ${
            activeTab === "tv" ? "text-emerald-400 scale-110 shadow-[0_0_15px_rgba(16,185,129,0.1)] font-bold" : "text-slate-400 hover:text-white"
          }`}
        >
          <Tv className={`w-5.5 h-5.5 transition-transform duration-300 ${activeTab === "tv" ? "stroke-[2.5px]" : ""}`} />
          <span>লাইভ টিভি</span>
        </button>

        {/* CENTER FLOATING CONCENTRIC CIRCLE MAYA AI BUTTON */}
        <div className="relative -mt-8">
          <div className="absolute -inset-1.5 rounded-full bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-500 blur opacity-75 animate-pulse" />
          <button
            onClick={() => {
              setActiveTab("ai");
              setSelectedPostId(null);
            }}
            className={`relative w-13 h-13 rounded-full flex flex-col items-center justify-center bg-[#0d0f17] border-2 transition-all duration-300 transform active:scale-90 ${
              activeTab === "ai" ? "border-cyan-400 shadow-[0_0_20px_#00f0ff] text-cyan-400 scale-115" : "border-slate-700 text-slate-200 hover:border-cyan-500"
            } cursor-pointer`}
          >
            <Cpu className="w-6 h-6 text-cyan-400 animate-pulse" />
            <span className="text-[10px] font-sans font-extrabold leading-none mt-0.5">মায়া</span>
          </button>
        </div>

        <button
          onClick={() => {
            setActiveTab("tools-lab");
            setSelectedPostId(null);
          }}
          className={`flex flex-col items-center justify-center gap-1 text-[11.5px] font-bold font-sans cursor-pointer transition-all duration-300 transform active:scale-95 ${
            activeTab === "tools-lab" ? "text-[#00f0ff] scale-110 shadow-[0_0_15px_rgba(0,240,255,0.15)] font-bold" : "text-slate-400 hover:text-white"
          }`}
        >
          <Wrench className={`w-5.5 h-5.5 transition-transform duration-300 ${activeTab === "tools-lab" ? "text-cyan-400 stroke-[2.5px]" : ""}`} />
          <span>টুলস ল্যাব 🧪</span>
        </button>

        <button
          onClick={() => {
            setActiveTab("profile");
            setSelectedPostId(null);
          }}
          className={`flex flex-col items-center justify-center gap-1 text-[11.5px] font-bold font-sans cursor-pointer transition-all duration-300 transform active:scale-95 ${
            activeTab === "profile" ? "text-amber-400 scale-110 shadow-[0_0_15px_rgba(245,158,11,0.1)] font-bold" : "text-slate-400 hover:text-white"
          }`}
        >
          <Award className={`w-5.5 h-5.5 transition-transform duration-300 ${activeTab === "profile" ? "stroke-[2.5px]" : ""}`} />
          <span>প্রোফাইল</span>
        </button>
      </nav>

      {/* PERSISTENT NEON FLOATING CHAT FAB */}
      <div className="fixed bottom-24 md:bottom-8 right-6 z-40">
        <button
          onClick={() => {
            setActiveTab("messages");
            setSelectedPostId(null);
          }}
          className="group relative w-14 h-14 rounded-full flex items-center justify-center bg-gradient-to-tr from-cyan-950/90 to-blue-900/90 border border-cyan-400 hover:border-[#39ff14]/70 shadow-[0_0_20px_rgba(0,240,255,0.3)] hover:shadow-[0_0_25px_rgba(57,255,20,0.4)] transition-all duration-300 transform hover:scale-110 active:scale-95 cursor-pointer"
        >
          {/* Pulsing indicator ring */}
          <span className="absolute -inset-1.5 rounded-full border border-cyan-400/30 animate-ping pointer-events-none" />
          
          {/* Unread message badge indicator */}
          <span className="absolute -top-1 -right-1 bg-red-500 border border-slate-950 text-white font-extrabold text-[9px] w-5 h-5 rounded-full flex items-center justify-center shadow-lg font-mono tracking-tighter">
            ৩
          </span>

          <MessageSquare className="w-6.5 h-6.5 text-[#00f0ff] group-hover:text-[#39ff14] transition-colors" />

          {/* Hover tooltip */}
          <div className="absolute right-16 bg-[#040810] border border-cyan-950 p-2 rounded-lg text-[10.5px] font-semibold text-cyan-300 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-150 shadow-xl pointer-events-none font-mono">
            💬 সাইবার মেসেঞ্জার চ্যাট
          </div>
        </button>
      </div>

      {/* Dynamic Cyber Story Lightbox Viewer */}
      <AnimatePresence>
        {activeStoryViewer && (
          <div className="fixed inset-0 bg-black/95 backdrop-blur-md z-50 flex items-center justify-center p-4">
            <motion.div
              initial={{ scale: 0.95, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              exit={{ scale: 0.95, opacity: 0 }}
              className="bg-[#050911] border border-cyan-500/20 rounded-2xl w-full max-w-lg overflow-hidden relative shadow-[0_0_60px_rgba(0,240,255,0.25)] flex flex-col text-left"
            >
              {/* Header profile */}
              <div className="p-4 bg-[#080d16] border-b border-cyan-950 flex justify-between items-center">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 rounded-full p-[2px] bg-gradient-to-tr from-cyan-400 to-indigo-500 overflow-hidden flex items-center justify-center">
                    <img 
                      src={activeStoryViewer.userAvatar} 
                      alt={activeStoryViewer.username} 
                      className="w-full h-full object-cover rounded-full bg-slate-900"
                    />
                  </div>
                  <div>
                    <h3 className="text-xs sm:text-sm font-bold text-white tracking-tight leading-none">{activeStoryViewer.username}</h3>
                    <span className="text-[9px] font-mono text-cyan-400 mt-1 block">{activeStoryViewer.timestamp}</span>
                  </div>
                </div>

                <button
                  onClick={() => setActiveStoryViewer(null)}
                  className="p-1 px-3 text-slate-400 hover:text-white bg-slate-900 border border-slate-800 rounded-lg hover:bg-slate-850 cursor-pointer text-xs font-mono"
                >
                  বন্ধ করুন ×
                </button>
              </div>

              {/* Story content area */}
              <div className="flex-1 min-h-[300px] flex items-center justify-center p-6 relative overflow-hidden bg-[#02050b]">
                <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(0,240,255,0.08),transparent)] pointer-events-none" />

                {activeStoryViewer.mediaType === "text" ? (
                  <div className="text-center max-w-md relative z-10 px-4 space-y-4">
                    <div className="inline-block text-[#00f0ff] font-mono text-xl animate-bounce">❝</div>
                    <p className="text-sm sm:text-base md:text-lg font-semibold text-slate-100 tracking-wide leading-relaxed font-sans">
                      {activeStoryViewer.textContent}
                    </p>
                    <div className="inline-block text-[#00f0ff] font-mono text-xl rotate-180">❝</div>
                  </div>
                ) : (
                  <div className="h-full w-full max-h-[350px] relative z-10 flex flex-col justify-center items-center">
                    <img 
                      src={activeStoryViewer.mediaUrl} 
                      alt="Story Media" 
                      className="max-h-[300px] object-contain rounded-lg border border-cyan-950/40 shadow-xl"
                    />
                    {activeStoryViewer.caption && (
                      <p className="text-xs font-sans font-medium text-[#00f0ff] bg-slate-950/90 border border-cyan-950 px-3 py-1.5 rounded-md mt-4 text-center max-w-sm tracking-wider">
                        {activeStoryViewer.caption}
                      </p>
                    )}
                  </div>
                )}
              </div>

              {/* Engagement statistics bar */}
              <div className="p-4 bg-[#080d16] border-t border-cyan-950 flex items-center justify-between gap-4">
                <div className="flex items-center gap-3 text-[11px] font-mono text-slate-400">
                  <span className="flex items-center gap-1">
                    👁 {activeStoryViewer.viewsCount} ভিউস
                  </span>
                  <span className="flex items-center gap-1 text-pink-500">
                    ♥ {activeStoryViewer.likesCount} লাইকস
                  </span>
                </div>

                <div className="flex items-center gap-2">
                  <button
                    onClick={() => {
                      setStories(prev => prev.map(s => {
                        if (s.id === activeStoryViewer.id) {
                          const updated = { ...s, likesCount: s.likesCount + 1 };
                          setActiveStoryViewer(updated);
                          return updated;
                        }
                        return s;
                      }));
                      addSystemNotification(`${activeStoryViewer.username}-এর স্টোরীতে আপনি রিয়েক্ট করেছেন!`, "like");
                    }}
                    className="flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded bg-pink-950/60 hover:bg-pink-900/80 text-pink-400 border border-pink-800/40 hover:border-pink-500 transition-all cursor-pointer"
                  >
                    🚀 লাভ রিয়েক্ট!
                  </button>
                  <button
                    onClick={() => {
                      const currentIdx = stories.findIndex(s => s.id === activeStoryViewer.id);
                      if (currentIdx !== -1 && currentIdx < stories.length - 1) {
                        setActiveStoryViewer(stories[currentIdx + 1]);
                      } else {
                        setActiveStoryViewer(stories[0]);
                      }
                    }}
                    className="flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded bg-cyan-950/60 hover:bg-cyan-900/80 text-cyan-400 border border-cyan-800/45 hover:border-cyan-400 transition-all cursor-pointer"
                  >
                    পরবর্তী →
                  </button>
                </div>
              </div>

              {/* High-CPC ads container (Safe spacing index layout) */}
              {adminSettings.enableGoogleAds && (
                <div className="p-2 bg-[#02050b] text-center border-t border-cyan-950/30">
                  <div className="text-[8px] tracking-[0.2em] uppercase font-mono text-slate-600 mb-1">স্পন্সরড স্লট (Safe Container Policy)</div>
                  <div dangerouslySetInnerHTML={{ __html: adminSettings.advertisementSnippet || '' }} />
                </div>
              )}
            </motion.div>
          </div>
        )}
      </AnimatePresence>

      {/* Dynamic Cyber Story Upload Form modal */}
      <AnimatePresence>
        {showUploadStoryModal && (
          <div className="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <motion.div
              initial={{ scale: 0.95, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              exit={{ scale: 0.95, opacity: 0 }}
              className="bg-[#090d16] border border-cyan-500/40 rounded-2xl w-full max-w-md overflow-hidden relative shadow-[0_0_50px_rgba(0,240,255,0.2)] text-left"
            >
              <div className="h-[2px] bg-gradient-to-r from-cyan-400 via-indigo-500 to-[#39ff14]" />
              
              <div className="p-6">
                <div className="flex justify-between items-center mb-4">
                  <h3 className="text-sm sm:text-base font-bold font-sans tracking-tight text-white flex items-center gap-2">
                    ⚡ আমার নতুন স্টোরী শেয়ার করুন
                  </h3>
                  <button
                    onClick={() => {
                      setShowUploadStoryModal(false);
                      setUploadStoryText("");
                      setUploadStoryUrl("");
                      setUploadStoryCaption("");
                    }}
                    className="p-1 px-2.5 text-slate-400 hover:text-white bg-slate-950 border border-cyan-950/60 hover:border-cyan-500 rounded text-xs font-mono cursor-pointer"
                  >
                    বন্ধ করুন ×
                  </button>
                </div>

                <form
                  onSubmit={(e) => {
                    e.preventDefault();
                    if (uploadStoryMediaType === "text" && !uploadStoryText.trim()) {
                      alert("অনুগ্রহ করে আপনার স্টোরী কন্টেন্ট লিখুন!");
                      return;
                    }
                    if (uploadStoryMediaType === "image" && !uploadStoryUrl.trim()) {
                      alert("অনুগ্রহ করে একটি ইমেজ ইউআরএল (Image URL) প্রদান করুন!");
                      return;
                    }

                    const newStory: StoryItem = {
                      id: `story-custom-${Date.now()}`,
                      username: userStats.name,
                      userAvatar: userStats.avatar,
                      mediaType: uploadStoryMediaType,
                      textContent: uploadStoryMediaType === "text" ? uploadStoryText : undefined,
                      mediaUrl: uploadStoryMediaType === "image" ? uploadStoryUrl : undefined,
                      caption: uploadStoryCaption.trim() || undefined,
                      timestamp: "এইমাত্র",
                      viewsCount: 1,
                      likesCount: 0
                    };

                    setStories(prev => [newStory, ...prev]);

                    setUserStats(prev => {
                      const updated = {
                        ...prev,
                        balance: Number((prev.balance + 1.50).toFixed(2)),
                        points: prev.points + 15
                      };
                      return updated;
                    });

                    addSystemNotification(`অভিনন্দন! আপনার স্টোরী সফলভাবে পাবলিশ হয়েছে। আপনার ব্যালেন্স ও XP বৃদ্ধি করা হয়েছে! ✨`, "earning");

                    setShowUploadStoryModal(false);
                    setUploadStoryText("");
                    setUploadStoryUrl("");
                    setUploadStoryCaption("");
                  }}
                  className="space-y-4"
                >
                  <div className="flex border-b border-cyan-950 pb-2 mb-2 gap-4">
                    <button
                      type="button"
                      onClick={() => setUploadStoryMediaType("text")}
                      className={`text-xs font-mono px-3 py-1.5 rounded transition-all cursor-pointer ${
                        uploadStoryMediaType === "text"
                          ? "bg-cyan-950 text-[#00f0ff] border border-cyan-800"
                          : "text-slate-400 hover:text-white"
                      }`}
                    >
                      ⌨ টেক্সট স্টোরী
                    </button>
                    <button
                      type="button"
                      onClick={() => setUploadStoryMediaType("image")}
                      className={`text-xs font-mono px-3 py-1.5 rounded transition-all cursor-pointer ${
                        uploadStoryMediaType === "image"
                          ? "bg-cyan-950 text-[#00f0ff] border border-cyan-800"
                          : "text-slate-400 hover:text-white"
                      }`}
                    >
                      🖼 ইমেজ স্টোরী
                    </button>
                  </div>

                  {uploadStoryMediaType === "text" ? (
                    <div>
                      <label className="block text-xs font-mono text-slate-400 mb-1">স্টোরী টেক্সট (বাংলায় লিখুন):</label>
                      <textarea
                        required
                        rows={3}
                        value={uploadStoryText}
                        onChange={(e) => setUploadStoryText(e.target.value)}
                        placeholder="আজকের বিশেষ টিপস বা গুরুত্বপূর্ণ বার্তাটি শেয়ার করুন..."
                        className="w-full text-xs font-sans bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded-lg p-3 text-slate-100 placeholder-slate-500"
                      />
                    </div>
                  ) : (
                    <div>
                      <label className="block text-xs font-mono text-slate-400 mb-1">ইমেজ ছবির লিংক (URL):</label>
                      <input
                        required
                        type="url"
                        value={uploadStoryUrl}
                        onChange={(e) => setUploadStoryUrl(e.target.value)}
                        placeholder="https://images.unsplash.com/photo-..."
                        className="w-full text-xs font-mono bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded-lg p-3 text-slate-100 placeholder-slate-500"
                      />
                      <span className="text-[9px] font-mono text-slate-500 mt-1 block">💡 Unsplash বা যেকোনো ফ্রি ইমেজ ছবির URL হোস্ট পেস্ট করতে পারেন।</span>
                    </div>
                  )}

                  <div>
                    <label className="block text-xs font-mono text-slate-400 mb-1">স্টোরী ক্যাপশন (Caption):</label>
                    <input
                      type="text"
                      value={uploadStoryCaption}
                      onChange={(e) => setUploadStoryCaption(e.target.value)}
                      placeholder="যেমন: আলহামদুলিল্লাহ বা Cyber Update"
                      className="w-full text-xs bg-[#0b121e] border border-cyan-950 focus:border-cyan-400 focus:outline-none rounded-lg p-2.5 text-slate-100"
                    />
                  </div>

                  <div className="bg-slate-950/80 p-3 rounded border border-cyan-950/60 text-[10.5px] leading-relaxed text-[#39ff14] font-mono">
                    💰 স্টোরী পাবলিশ বোনাস: ১.৫০ ৳ ব্যালেন্স এবং ১৫ XP ইনস্ট্যান্ট যুক্ত করা হবে!
                  </div>

                  <button
                    type="submit"
                    className="w-full bg-gradient-to-r from-cyan-400 to-[#39ff14] hover:opacity-90 text-[#070b13] font-bold text-xs py-2.5 rounded-lg cursor-pointer font-sans text-center transition-opacity"
                  >
                    স্টোরী পাবলিশ করুন 🚀
                  </button>
                </form>
              </div>
            </motion.div>
          </div>
        )}
      </AnimatePresence>

      {/* Floating Scroll to Top Button */}
      <button
        onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
        className="fixed bottom-6 right-6 w-12 h-12 bg-cyan-950 border border-cyan-400 text-cyan-400 rounded-full flex items-center justify-center shadow-[0_0_15px_rgba(0,240,255,0.3)] hover:scale-110 hover:bg-cyan-900 transition-all z-[999] cursor-pointer group"
        title="উপরে যান (Scroll to Top)"
      >
        <span className="text-xl group-hover:-translate-y-1 transition-transform">↑</span>
      </button>

    </div>
  );
}
