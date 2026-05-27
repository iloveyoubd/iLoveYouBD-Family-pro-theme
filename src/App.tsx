import React, { useState, useEffect, FormEvent } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  Terminal, ShieldCheck, HelpCircle, User, LogIn, Plus, 
  Wallet, Bell, Home, Layout, Cpu, RefreshCw, LogOut, CheckCircle, Search, Clock, Award, Tv
} from "lucide-react";

import type { Post, Question, NotificationItem, UserStats, AdminSettings } from "./types";
import RGBBorder from "./components/RGBBorder";
import PostContainer from "./components/PostContainer";
import CommunityQA from "./components/CommunityQA";
import NIDMaker from "./components/NIDMaker";
import AdminPanel from "./components/AdminPanel";
import AICrew from "./components/AICrew";
import LiveTV from "./components/LiveTV";
import MayaChatbot from "./components/MayaChatbot";

// Helper keys for localStorage
const LOCAL_POSTS_KEY = "iloveyoubd_posts_db";
const LOCAL_QUESTIONS_KEY = "iloveyoubd_questions_db";
const LOCAL_STATS_KEY = "iloveyoubd_stats_db";
const LOCAL_SETTINGS_KEY = "iloveyoubd_settings_db";
const LOCAL_NOTIFS_KEY = "iloveyoubd_notifs_db";
const LOCAL_WITHDRAW_KEY = "iloveyoubd_withdrawals_db";

const INITIAL_POSTS: Post[] = [
  {
    id: "post-1",
    title: "গুগল এআই ক্রলার বুস্ট করার ট্রিকস এবং দ্রুত ইনডেক্সিং গাইড ২০৪০",
    excerpt: "গুগল সার্চ ইঞ্জিনের সাথে বন্ধুত্ব করতে চাইলে ক্রলার ইমেট্রি ঠিক করা অপরিহার্য। ২০৪০ ভিশন অনুযায়ী সার্চ ইঞ্জিন ইনডেক্স ফ্রেন্ডলি করার গোপন গাইড।",
    content: "গুগল সার্চ ইঞ্জিনে আপনার কন্টেন্ট এক মিনিটের মধ্যে ইনডেক্স করতে সাইটম্যাপে রিঅ্যাক্টিভ আরএসএস যুক্ত করুন...",
    thumbnail: "https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=600&auto=format&fit=crop",
    category: "SEO Guide",
    tags: ["google", "indexing", "seo", "cyber"],
    readTime: "৪ মিনিট",
    author: {
      name: "এআই অ্যাডমিন অ্যাসিস্ট্যান্ট",
      avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=admin",
      isAI: true,
      rank: "CHIEF OPERATIVE"
    },
    likes: 12,
    views: 134,
    comments: [
      {
        id: "c-1",
        authorName: "সাইবার টিম বিডি",
        authorAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=team",
        text: "অসাধারণ হ্যাক ট্রিকস ভাই! অনেক হেল্প হলো গুগল অ্যাডসেন্স এপ্রুভালে।",
        timestamp: "১ ঘণ্টা আগে"
      }
    ],
    isFeatured: true,
    timestamp: "২ ঘণ্টা আগে"
  },
  {
    id: "post-2",
    title: "একাউন্ট হ্যাকিং এবং ২০৪০ সালের উন্নত ফিশিং প্রতিরোধ ব্যবস্থা",
    excerpt: "ডার্ক হান্টারদের কবল থেকে সোশ্যাল একাউন্ট এবং ক্রিপ্টো ওয়ালেট কীভাবে শতভাগ নিরাপদ রাখবেন? বাস্তবমুখী সিকিউরিটি টুলস গাইড।",
    content: "ফিশিং লিংক শনাক্ত করতে ডোমেইনের লাইভ ডিএনএস মেটা ভেরিফিকেশন স্ক্যান করা উচিত...",
    thumbnail: "https://images.unsplash.com/photo-1614064641938-3bbee52942c7?q=80&w=600&auto=format&fit=crop",
    category: "Hacking",
    tags: ["hacking", "phishing", "cyber-shield"],
    readTime: "৫ মিনিট",
    author: {
      name: "সাইবার রনি",
      avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=ronny",
      isAI: false,
      rank: "ELITE WHATEHAT"
    },
    likes: 8,
    views: 95,
    comments: [],
    timestamp: "৪ ঘণ্টা আগে"
  },
  {
    id: "post-3",
    title: "কন্টেন্ট লিখে প্রতিদিন ৩০০ টাকা পর্যন্ত উপার্জনের সঠিক টেকনিক",
    excerpt: "আমাদের সাইটের লাইভ মনিটাইজেশন সিস্টেম অনুযায়ী পোস্ট ভিউ এবং লাইক বাড়িয়ে কীভাবে সরাসরি বিকাশ/নগদে নিবেন, তার ট্রিকস।",
    content: "iloveyoubd.com এ মানসম্মত পোস্ট লিখলে প্রতি লাইক এবং ভিউয়ের মেম্বার ফিডব্যাক থেকে আপনার ব্যালেন্স সরাসরি যুক্ত হয়...",
    thumbnail: "https://images.unsplash.com/photo-1518546305927-5a555bb7020d?q=80&w=600&auto=format&fit=crop",
    category: "Online Earning",
    tags: ["earning", "monetize", "bkash", "trickbd"],
    readTime: "৩ মিনিট",
    author: {
      name: "রানা মির্জা",
      avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=rana",
      isAI: false,
      rank: "SENIOR CONTRIBUTOR"
    },
    likes: 24,
    views: 412,
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
  postsPending: 1
};

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
  enableGoogleAds: true,
  advertisementSnippet: `<div class="bg-cyan-950/20 border border-cyan-800/40 border-dashed rounded-lg p-3 text-center text-xs font-mono text-cyan-400">⚡ Google ADS: Active & High-CPC Optimized Banner Place</div>`,
  mayaApiKeys: "AlzaSyBAcwAPXPzNfeGQ6XHDR-EaNRsHqhkTro8",
  mayaSystemInstruction: "You are Maya (মায়া), the highly professional, helpful, and extremely competent executive AI assistant of iloveyoubd.com. Write in flawless Bangla. Answer users with high intelligence, deep reasoning, and immense professionalism.",
  mayaTemperature: 0.7
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

export default function App() {
  // Navigation active tab
  const [activeTab, setActiveTab] = useState<"home" | "add" | "profile" | "dashboard" | "ai" | "qa" | "nid" | "admin">("home");
  const [selectedCategory, setSelectedCategory] = useState("All");

  // Single post viewing state
  const [selectedPostId, setSelectedPostId] = useState<string | null>(null);

  // Selected question highlight state in Q&A Forum
  const [selectedQuestionId, setSelectedQuestionId] = useState<string | null>(null);

  // Search dropdown overlay state
  const [showSearchDropdown, setShowSearchDropdown] = useState(false);

  // Profile completion reward claimed toggle
  const [isProfileRewardClaimed, setIsProfileRewardClaimed] = useState<boolean>(() => {
    return localStorage.getItem("ilybd_profile_reward_claimed") === "true";
  });

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

  const [adminSettings, setAdminSettings] = useState<AdminSettings>(() => {
    const local = localStorage.getItem(LOCAL_SETTINGS_KEY);
    return local ? JSON.parse(local) : DEFAULT_SETTINGS;
  });

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

  // Search filter
  const [postSearchQuery, setPostSearchQuery] = useState("");

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
    localStorage.setItem(LOCAL_QUESTIONS_KEY, JSON.stringify(questions));
  }, [questions]);

  useEffect(() => {
    localStorage.setItem(LOCAL_STATS_KEY, JSON.stringify(userStats));
  }, [userStats]);

  useEffect(() => {
    localStorage.setItem(LOCAL_SETTINGS_KEY, JSON.stringify(adminSettings));
  }, [adminSettings]);

  useEffect(() => {
    localStorage.setItem(LOCAL_NOTIFS_KEY, JSON.stringify(notifs));
  }, [notifs]);

  useEffect(() => {
    localStorage.setItem(LOCAL_WITHDRAW_KEY, JSON.stringify(withdrawalRequests));
  }, [withdrawalRequests]);

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
            setUserStats((prev) => ({
              ...prev,
              balance: Number((prev.balance + (adminSettings.payoutPerView * 0.5)).toFixed(2)),
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
          setTotalWithdrawn((v) => v + r.amount);
          return { ...r, status: "paid" };
        }
        return r;
      })
    );
  };

  // System AI Crew Trigger
  const handleAdminTriggerAIPost = async () => {
    setIsGeneratingAIPost(true);
    try {
      const concepts = [
        "অ্যাডসেন্স লোডিং সিক্রেট ২০৪০",
        "ডিপিএল প্যাকেট ফিল্টারিং হ্যাকস",
        "২০৪০ সালে এআই কোডিং রোবট ডেভেলপমেন্ট"
      ];
      const keyword = concepts[Math.floor(Math.random() * concepts.length)];
      const res = await fetch("/api/gemini/generate-post", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          prompt: keyword,
          category: "SEO Guide",
          authorName: "মেগা ক্রু এআই"
        })
      });

      const data = await res.json();
      handleAddGeneratedPost(data);
    } catch (err) {
      console.error(err);
      // fallback publisher
      handleAddGeneratedPost({
        title: "সাইবার গার্ড ইমেট্রি ২০৪০ এপ্রুভাল গাইড",
        excerpt: "সার্ভার স্পিড ফিক্স করার সিকিউরিটি গাইড সম্পর্কে এআই অ্যাসিস্ট্যান্ট পোস্ট তৈরি করেছে।",
        content: "সিস্টেম কোড সল্ভার সক্রিয় করতে ডোমেইন ভেরিফাই করুন...",
        category: "Hacking",
        tags: ["ai", "hacker-security"],
        readTime: "৩ মিনিট",
        authorName: "মেগা ক্রউ এআই"
      });
    } finally {
      setIsGeneratingAIPost(false);
    }
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

  return (
    <div className="min-h-screen bg-[#060a12] text-slate-100 font-sans transition-colors duration-500 relative pb-16">
      
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
              id="menu-tab-qa"
              onClick={() => setActiveTab("qa")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "qa"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <HelpCircle className="w-3.5 h-3.5 text-cyan-500" /> কমিউনিটি Q&A
            </button>
            <button
              id="menu-tab-nid"
              onClick={() => setActiveTab("nid")}
              className={`flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer ${
                activeTab === "nid"
                  ? `bg-[#0c1624] border ${styleProfile.borderAccent} text-slate-100 shadow-[0_0_8px_rgba(0,240,255,0.15)]`
                  : "text-slate-400 hover:text-slate-100"
              }`}
            >
              <Layout className="w-3.5 h-3.5 text-emerald-400" /> এনআইডি মেকার
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
              href="/api/wordpress/download-fixed-theme"
              download="ilybd-neon-v1-pro-fixed.zip"
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer bg-emerald-950/80 border border-emerald-500 text-emerald-300 hover:bg-emerald-900 shadow-[0_0_10px_rgba(16,185,129,0.3)] font-semibold"
            >
              <ShieldCheck className="w-3.5 h-3.5 text-emerald-400" /> Theme (Theme Zip) 📥
            </a>
            <a
              id="menu-tab-download-plugin"
              href="/api/wordpress/download-fixed-plugin"
              download="ilybd-prime-engine-fixed.zip"
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center gap-1.5 text-xs font-mono px-3.5 py-1.5 rounded transition-all cursor-pointer bg-blue-950/80 border border-blue-500 text-blue-300 hover:bg-blue-900 shadow-[0_0_10px_rgba(59,130,246,0.3)] font-semibold animate-pulse"
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
      {activeTab === "home" && (
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

      {/* WordPress Theme & Plugin optimization status widget */}
      {activeTab === "home" && (
        <section className="bg-slate-950 py-4 border-b border-cyan-950/20">
          <div className="max-w-7xl mx-auto px-4 sm:px-6">
            <div className="bg-slate-900/45 border-2 border-emerald-500/20 rounded-2xl p-5 sm:p-7 relative overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.05)]">
              {/* Pulsing decoration dot */}
              <div className="absolute top-4 right-4 flex items-center gap-2">
                <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" />
                <span className="text-[9px] font-mono font-bold text-emerald-400 tracking-wider">SYSTEM SECURE & PATCHED</span>
              </div>

              <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                <div className="space-y-3 flex-1">
                  <div className="inline-flex items-center gap-2 text-xs font-mono font-bold text-emerald-400 bg-emerald-950/80 px-2.5 py-1 rounded border border-emerald-900/50">
                    <ShieldCheck className="w-4 h-4 text-emerald-400" /> কাস্টম থিম ও প্লাগিন সমাধান রিপোর্ট (PRO)
                  </div>
                  <h2 className="text-lg sm:text-2xl font-bold font-sans text-slate-100 tracking-tight leading-tight">
                    আপনার ওয়ার্ডপ্রেস থিম এবং প্লাগিন (ILYBD Prime Engine) এর সব বাগ ও মেমরিন ক্র্যাশ সফলভাবে ঠিক করা হয়েছে!
                  </h2>
                  <p className="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-4xl font-sans">
                    আমরা আপনার দেওয়া থিম এবং <strong>ILYBD Prime Engine</strong> প্লাগিন উভয় ফাইল নিখুঁতভাবে চেক করেছি। প্লাগিনটির ডাটাবেজ টেবিলে অনুপস্থিত ভ্যালু ও কলাম যেমন <code>user_level</code> ও <code>total_earned</code> ইন্টিগ্রেট করা হয়েছে (যা আগে কুয়েরি ক্র্যাশ ঘটাত)। এছাড়াও পয়েন্ট ও ব্যালেন্স রিওয়ার্ড ইঞ্জেকশন এখন ব্যাকএন্ড ডাটাবেজ এবং ওয়ার্ডপ্রেস ইউজার মেটা ও নোটিফিকেশনের সাথে ১০০% রিয়েল-টাইমে মেলানো থাকবে!
                  </p>
                  
                  {/* Grid of fixes list */}
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 pt-2 text-xs font-mono text-slate-300">
                    <div className="flex items-center gap-2">
                      <span className="text-emerald-400 font-bold">✔</span>
                      <span>পয়েন্ট এবং ব্যালেন্স ডাটাবেস টেবিল ও ইউজার মেটা ইন্টিগ্রেশন।</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="text-emerald-400 font-bold">✔</span>
                      <span>প্লাগিন ডাটাবেস ক্র্যাশ বাগ সংশোধন (user_level এবং total_earned কলাম যুক্তকরণ)।</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="text-emerald-400 font-bold">✔</span>
                      <span>পোস্ট ক্রিয়েশন এবং আপডেট এডিটর নোটিফিকেশন সিস্টেম।</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="text-emerald-400 font-bold">✔</span>
                      <span>বিকাশ ও নগদ ক্যাশআউট রিকোয়েস্ট এবং মেটা সিংক্রোনাইজেশন।</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="text-emerald-400 font-bold">✔</span>
                      <span>লাইভ ক্যাটাগরি লোডিং, ভিউ বোনাস এবং লাইক কমিশন সিস্টেম।</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="text-emerald-400 font-bold">✔</span>
                      <span>লগইন বোনাস এবং স্পেশাল অফার ট্র্যাকিং মডিউল সামঞ্জস্যকরণ।</span>
                    </div>
                  </div>
                </div>

                {/* Two side-by-side or stacked download boxes for Theme and Plugin */}
                <div className="shrink-0 flex flex-col gap-4 w-full lg:w-80">
                  <div className="flex flex-col md:flex-row lg:flex-col items-stretch gap-4 bg-slate-950/80 p-5 border border-cyan-950 rounded-xl shadow-inner">
                    <div className="flex-1 flex flex-col items-center text-center space-y-2 border-b md:border-b-0 md:border-r lg:border-r-0 lg:border-b border-cyan-950/50 pb-4 md:pb-0 md:pr-4 lg:pr-0 lg:pb-4">
                      <span className="text-[9px] font-mono text-emerald-400 tracking-wider font-bold uppercase">1. THEME PACKAGE (ZIP)</span>
                      <a
                        href="/api/wordpress/download-fixed-theme"
                        download="ilybd-neon-v1-pro-fixed.zip"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="w-full flex items-center justify-center gap-2 text-xs font-mono font-bold uppercase bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white py-2 px-4 rounded border border-emerald-500 shadow-lg hover:scale-[1.01] transition-all cursor-pointer"
                      >
                        🚀 কাস্টম থিম ডাউনলোড করুন
                      </a>
                      <span className="text-[9px] font-mono text-slate-400">ilybd-neon-v1-pro-fixed.zip (~7.8 MB)</span>
                    </div>

                    <div className="flex-1 flex flex-col items-center text-center space-y-2 pt-2 md:pt-0 md:pl-4 lg:pl-0 lg:pt-2">
                      <span className="text-[9px] font-mono text-blue-400 tracking-wider font-bold uppercase">2. PLUGIN ENGINE (ZIP)</span>
                      <a
                        href="/api/wordpress/download-fixed-plugin"
                        download="ilybd-prime-engine-fixed.zip"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="w-full flex items-center justify-center gap-2 text-xs font-mono font-bold uppercase bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white py-2 px-4 rounded border border-blue-500 shadow-lg hover:scale-[1.01] transition-all cursor-pointer animate-pulse"
                      >
                        🔌 প্লাগিন ডাউনলোড করুন
                      </a>
                      <span className="text-[9px] font-mono text-slate-400">ilybd-prime-engine-fixed.zip (~3.7 MB)</span>
                    </div>
                  </div>

                  {/* Browser sandbox warning notice */}
                  <div className="bg-[#1c0f0f] border border-red-900/50 p-4 rounded-xl text-[11px] leading-relaxed text-red-200 shadow-md">
                    <span className="font-bold text-red-400 block mb-1">⚠️ ডাউনলোড কাজ না করলে করণীয়:</span>
                    গুগল এআই স্টুডিও-র বিল্ট-ইন আইফ্রেম প্রিভিউ মোডে ব্রাউজার সিকিউরিটি (Sandbox Policy) এর কারণে ফাইল ডাউনলোড ব্লক হতে পারে। ডাউনলোড করতে চাইলে দয়া করে ব্রাউজার উইন্ডোর একেবারে উপরে ডানদিকের ক্রোম আইকন বা <strong className="text-amber-305">"Open in a New Tab" (শেয়ার লিঙ্কের পাশে)</strong>-এ ক্লিক করে নতুন ট্যাবে ওয়েবসাইটটি ওপেন করুন, অথবা চ্যাট বক্সে দেওয়া ডিরেক্ট লিংকগুলো ক্লিক করুন!
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      )}

      {/* CORE DISPLAY PAGES CONTAINER */}
      <main className="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <AnimatePresence mode="wait">
          
          {/* Tab 1: Home dashboard standard list */}
          {activeTab === "home" && (
            <motion.div
              key="home"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="space-y-10"
            >
              <div className="flex flex-col lg:flex-row gap-6 items-start">
                
                {/* Left side column: list and search filter */}
                <div className="lg:col-span-8 flex-1 w-full space-y-6">
                  
                  {/* Category select filter and search bar portal */}
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

                    <div className="relative w-full sm:w-80 md:w-96" id="global-search-container">
                      <Search className="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-cyan-400 animate-pulse" />
                      <input
                        type="text"
                        value={postSearchQuery}
                        onChange={(e) => {
                          setPostSearchQuery(e.target.value);
                          setShowSearchDropdown(true);
                        }}
                        onFocus={() => setShowSearchDropdown(true)}
                        placeholder="কন্টেন্ট বা ফোরাম প্রশ্ন খুঁজুন..."
                        className="w-full text-xs font-mono bg-slate-950 border border-cyan-950 rounded-lg pl-10 pr-10 py-2.5 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-500/30 text-slate-100 placeholder-slate-500 transition-all duration-300 shadow-[inset_0_2px_10px_rgba(0,0,0,0.8)]"
                      />
                      {postSearchQuery && (
                        <button
                          onClick={() => {
                            setPostSearchQuery("");
                            setShowSearchDropdown(false);
                          }}
                          className="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 text-xs font-mono hover:scale-110 transition-transform cursor-pointer"
                        >
                          ✕
                        </button>
                      )}

                      {/* STUNNING REAL-TIME SEARCH RESULTS OVERLAY PANEL */}
                      <AnimatePresence>
                        {showSearchDropdown && postSearchQuery.trim().length > 0 && (
                          <motion.div
                            initial={{ opacity: 0, y: 10 }}
                            animate={{ opacity: 1, y: 0 }}
                            exit={{ opacity: 0, y: 10 }}
                            className="absolute top-full left-0 right-0 mt-2 bg-[#080d17] border border-cyan-500/35 rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.95)] z-50 overflow-hidden backdrop-blur-xl max-h-[420px] overflow-y-auto custom-scrollbar flex flex-col divide-y divide-cyan-950/60"
                          >
                            {/* Search statistics header */}
                            <div className="bg-[#0b1222] px-4 py-2 flex justify-between items-center text-[10px] text-slate-450 font-mono">
                              <span>খোঁজা হচ্ছে: <strong className="text-cyan-400">"{postSearchQuery}"</strong></span>
                              <span>
                                {(() => {
                                  let pCount = posts.filter(p => p.title.toLowerCase().includes(postSearchQuery.toLowerCase()) || p.excerpt.toLowerCase().includes(postSearchQuery.toLowerCase())).length;
                                  let qCount = questions.filter(q => q.title.toLowerCase().includes(postSearchQuery.toLowerCase())).length;
                                  return `${pCount + qCount} টি ফলাফল`;
                                })()}
                              </span>
                            </div>

                            {/* RESULTS CONTENT AREA */}
                            <div className="p-2 space-y-4">
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
                                let pCount = posts.filter(p => p.title.toLowerCase().includes(postSearchQuery.toLowerCase()) || p.excerpt.toLowerCase().includes(postSearchQuery.toLowerCase())).length;
                                let qCount = questions.filter(q => q.title.toLowerCase().includes(postSearchQuery.toLowerCase())).length;
                                if (pCount === 0 && qCount === 0) {
                                  return (
                                    <div className="p-8 text-center space-y-2">
                                      <div className="text-amber-500 text-base font-bold font-mono">⚠️ দুঃখিত! কোশ্চেন বা পোস্ট পাওয়া যায়নি</div>
                                      <p className="text-[11px] text-slate-400 font-sans">
                                        আপনার দেওয়া কী-ওয়ার্ড <strong className="text-cyan-400 font-mono">"{postSearchQuery}"</strong> দিয়ে কোনো পোস্ট বা প্রশ্ন সমাধান পাওয়া যায়নি।
                                      </p>
                                      <p className="text-[9px] text-slate-550 font-mono italic">
                                        বিকল্প কিছু ট্রাই করুন (যেমন 'গুগল', 'সাইবার', 'এআই' বা 'ইনডেক্স')
                                      </p>
                                    </div>
                                  );
                                }
                                return null;
                              })()}
                            </div>
                            
                            {/* Tips Footer */}
                            <div className="bg-[#050911] px-4 py-2 text-center text-[9px] font-mono text-slate-500">
                              💡 ফলাফলে সরাসরি ক্লিক করলেই কাঙ্ক্ষিত সমাধান পেজে নিয়ে যাবে।
                            </div>
                          </motion.div>
                        )}
                      </AnimatePresence>
                    </div>
                  </div>

                  {/* Blog feed rendering grids */}
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {filteredPostsList.length === 0 ? (
                      <div className="col-span-full text-center py-12 bg-slate-950 border border-dashed border-slate-900 rounded-xl font-mono text-slate-500">
                        এই ক্যাটাগরিতে কোনো টিউটোরিয়াল পোস্ট পাওয়া যায়নি।
                      </div>
                    ) : (
                      filteredPostsList.map((post) => (
                        <PostContainer
                          key={post.id}
                          post={post}
                          onLike={handleLikePost}
                          onComment={handleCommentPost}
                        />
                      ))
                    )}
                  </div>
                </div>

                {/* Right side widgets column */}
                <div className="w-full lg:w-80 space-y-6 shrink-0 text-left">
                  
                  {/* Cyber User Profile/Points stats */}
                  <div className="bg-[#090d16] border border-cyan-950 rounded-xl p-4 relative overflow-hidden">
                    <div className="absolute -top-10 -left-10 w-24 h-24 bg-cyan-500/5 rounded-full blur-2xl" />
                    <h3 className="text-xs font-mono text-cyan-400 uppercase tracking-widest mb-3 font-bold border-b border-cyan-950 pb-1 flex items-center gap-1.5">
                      <User className="w-4 h-4 text-cyan-400" /> সাইবার ফোরাম স্ট্যাটস
                    </h3>
                    
                    <div className="space-y-3">
                      <div className="flex justify-between items-center text-xs">
                        <span className="text-slate-400 font-mono">ওয়ালেট ব্যালেন্স:</span>
                        <span className="font-bold text-emerald-400">{userStats.balance} ৳</span>
                      </div>
                      <div className="flex justify-between items-center text-xs">
                        <span className="text-slate-400 font-mono">ফোরাম পয়েন্ট:</span>
                        <span className="font-semibold text-cyan-300">{userStats.points} XP</span>
                      </div>
                      <div className="flex justify-between items-center text-xs">
                        <span className="text-slate-400 font-mono">পাবলিশ করা পোস্ট:</span>
                        <span className="font-semibold text-white">{userStats.postsPublished} টি</span>
                      </div>
                      <div className="flex justify-between items-center text-xs">
                        <span className="text-slate-400 font-mono">পেন্ডিং কন্টেন্ট:</span>
                        <span className="font-semibold text-yellow-500">{userStats.postsPending} টি</span>
                      </div>

                      <div className="pt-3 border-t border-cyan-950 flex flex-col gap-2">
                        <button
                          onClick={handleApplyWithdrawal}
                          className="w-full bg-cyan-950 hover:bg-cyan-900 border border-cyan-400/80 text-cyan-300 font-bold font-mono text-[10px] py-1.5 tracking-wider rounded text-center cursor-pointer"
                        >
                          💸 ক্যাশআউট বিকাশ/নগদ
                        </button>
                      </div>
                    </div>
                  </div>

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
                    <label className="block text-xs font-mono text-slate-300"> can বিস্তারিত কন্টেন্ট আর্টিকেল (Markdown Supported)</label>
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

          {/* Tab 6: Smart NID Maker */}
          {activeTab === "nid" && (
            <motion.div
              key="nid"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
            >
              <NIDMaker />
            </motion.div>
          )}

          {/* Tab 8: Profile customization & Reward Claiming Portal */}
          {activeTab === "profile" && (
            <motion.div
              key="profile"
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: -15 }}
              className="max-w-3xl mx-auto text-left"
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
                      <span className="text-slate-300">অ্যাকাউন্ট নাম ও সিড</span>
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
                      <span className={profileBkash ? "text-slate-300" : "text-slate-500"}>বিকাশ/নগদ নম্বর</span>
                    </div>
                    <div className="flex items-center gap-1.5 text-[10px] font-mono">
                      <span className={profileSkills ? "text-[#39ff14] font-bold" : "text-slate-600"}>
                        {profileSkills ? "✔" : "○"}
                      </span>
                      <span className={profileSkills ? "text-slate-300" : "text-slate-500"}>পারদর্শিতা ও স্কিলস</span>
                    </div>
                    <div className="flex items-center gap-1.5 text-[10px] font-mono">
                      <span className={profileFbLink ? "text-[#39ff14] font-bold" : "text-slate-600"}>
                        {profileFbLink ? "✔" : "○"}
                      </span>
                      <span className={profileFbLink ? "text-slate-300" : "text-slate-500"}>সামাজিক ওয়েবসাইট লিংক</span>
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
              <div className="bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl relative overflow-hidden flex flex-col md:flex-row gap-6 items-center">
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
                
                {/* Column Left (Col-sp-7): Styled Line-By-Line List */}
                <div className="lg:col-span-7 bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl space-y-5">
                  <h3 className="text-sm font-bold font-sans uppercase tracking-widest text-[#00f0ff] border-b border-cyan-950 pb-2 flex items-center gap-1.5">
                    <User className="w-4 h-4 text-cyan-500" /> প্রোফাইলের বিস্তারিত বিবরণী (লাইন বাই লাইন)
                  </h3>
                  
                  <div className="space-y-1">
                    
                    <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                      <span className="text-slate-400">১. ইউজারনেম (Username):</span>
                      <span className="text-slate-100 font-bold font-sans">{userStats.name}</span>
                    </div>

                    <div className="flex justify-between items-center py-3 border-b border-cyan-950/40 font-mono text-xs">
                      <span className="text-slate-400">২. ফোরাম পদবি / রোল:</span>
                      <span className={`font-semibold ${styleProfile.textAccent}`}>{userStats.rank}</span>
                    </div>
                  </div>
                </div>

                {/* Column Left Stats Subcontainer */}
                <div className="lg:col-span-7 bg-[#090d16] border border-cyan-950 rounded-2xl p-6 shadow-2xl space-y-5">
                  <h3 className="text-sm font-bold font-sans uppercase tracking-widest text-[#00f0ff] border-b border-cyan-950 pb-2 flex items-center gap-1.5">
                    <User className="w-4 h-4 text-cyan-500" /> আপনার পরিসংখ্যান (Stats)
                  </h3>
                  
                  <div className="space-y-1">
                    {/* HIDDEN INLINE ENVELOPE */}
                    <div className="hidden">
              iloveyoubd.com হল বাংলাদেশের একমাত্র বিশেষায়িত প্রযুক্তি বিষয়ক অনলাইন হ্যাকিং ফোরাম ও মাল্টি-অটোর ডিস্ট্রিবিউটেড ব্লগিং পোর্টাল। আমরা সাইবার সিকিউরিটি রিসার্চ এবং উচ্চ-মানের কন্টেন্ট রাইটিংকে ত্বরان্বিত ও নিরাপদ করতে সর্বদা প্রতিশ্রুতিবদ্ধ।
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
                      <span className="text-slate-400">৮. ফোরাম মেম্বারশিপ অ্যাকাউন্ট টাইপ:</span>
                      <span className="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-500 font-bold uppercase">PRO CREATIVE</span>
                    </div>

                  </div>
                </div>

                {/* Column Right (Col-sp-5): Wallet Retract Controls & Gateway rules */}
                <div className="lg:col-span-5 space-y-6">
                  
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
              />
            </motion.div>
          )}

        </AnimatePresence>
      </main>

      {/* COMPREHENSIVE CYBER MULTI-COLUMN FOOTER */}
      <footer className="border-t border-cyan-950/50 bg-[#040811] py-10 mt-16 relative">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-12 gap-8 text-left">
          
          {/* Col 1: About the portal */}
          <div className="md:col-span-5 space-y-3">
            <div className="flex items-center gap-2">
              <Terminal className={`w-5 h-5 ${styleProfile.textAccent}`} />
              <span className="font-bold text-sm tracking-widest uppercase">
                iloveyoubd.com <span className={styleProfile.textAccent}>SYSTEMS</span>
              </span>
            </div>
            
            <p className="text-xs text-slate-400 font-sans leading-relaxed">
              iloveyoubd.com হল বাংলাদেশের একমাত্র প্রযুক্তি বিষয়ক হ্যাকিং ও মাল্টি-অটোর ডিস্ট্রিবিউটেড ব্লগিং পোর্টাল। এখানে সিক্লিউড অ্যাডসেন্স কোডিং এপিআই মেম্বারদের সরাসরি আরজিবি লাইটিং বর্ডার ব্যালেন্স মনিটাইজেশন ড্যাশবোর্ডে সাপোর্ট দিয়ে থাকে।
            </p>

            <div className="flex items-center gap-3 pt-2">
              <span className="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse" />
              <span className="text-[10px] font-mono text-emerald-400">Server Coords: Node-3000 // Active Tunnel Online</span>
            </div>
          </div>

          {/* Col 2: Fast index links */}
          <div className="md:col-span-3 space-y-3">
            <h4 className="text-xs uppercase font-mono tracking-widest text-[#00f0ff] font-bold">পেজ সূচক (Sitemaps)</h4>
            <ul className="space-y-2 text-sm text-slate-300 font-medium font-sans">
              <li>
                <button 
                  onClick={() => { setActiveTab("home"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-xs">➔</span> হোম ফিড ও ট্রিকস
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("ai"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-xs">➔</span> গেমিনি এআই ডাস্টবোট
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("add"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-xs">➔</span> নতুন কন্টেন্ট আর্নিং পোর্টাল
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("qa"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-xs">➔</span> কমুনিটি প্রশ্ন-উত্তর ফোরাম
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("nid"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#00f0ff] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#39ff14] text-xs">➔</span> স্মার্ট এনআইডি কার্ড জেনারেটর
                </button>
              </li>
              <li>
                <button 
                  onClick={() => { setActiveTab("profile"); setSelectedPostId(null); }} 
                  className="flex items-center gap-1.5 hover:text-[#ffae00] transition-all duration-300 transform hover:translate-x-1 cursor-pointer leading-relaxed text-left"
                >
                  <span className="text-[#ffae00] text-xs">★</span> প্রোফাইল সম্পাদন (১৫০XP বোনাস)
                </button>
              </li>
            </ul>
          </div>

          {/* Col 3: Legal cyber indices */}
          <div className="md:col-span-4 space-y-3">
            <h4 className="text-xs uppercase font-mono tracking-widest text-[#00f0ff] font-bold">সিকিউরিটি অ্যান্ড ইনডেক্সিং</h4>
            <div className="bg-[#070c14] border border-cyan-950 p-3 rounded text-[11px] font-sans leading-relaxed text-slate-400 space-y-1">
              <div className="flex justify-between">
                <span>সার্চ ইঞ্জিন ইন্ডেক্সার:</span>
                <span className="text-emerald-400 font-mono">১০০% ভেরিফাইড</span>
              </div>
              <div className="flex justify-between">
                <span>কোড সিকিউরিটি স্কোর:</span>
                <span className="text-cyan-400 font-mono">A+ Rating</span>
              </div>
              <div className="flex justify-between">
                <span>ডিজিটাল ট্র্যাকিং পেমেন্টস:</span>
                <span className="text-emerald-400 font-mono">২-ঘণ্টা বিকাশ পরিশোধ</span>
              </div>
            </div>

            {/* Dynamic Realtime Clock Portal */}
            <div className="text-[10px] text-slate-500 font-mono flex items-center gap-1.5 justify-end pt-1">
              <Clock className="w-3.5 h-3.5" />
              <span>মুহূর্তের সময়: 2026-05-21 • Dhaka UTC</span>
            </div>
          </div>

        </div>

        <div className="max-w-7xl mx-auto px-4 mt-8 pt-4 border-t border-cyan-950 flex flex-col sm:flex-row justify-between items-center gap-2 text-[11px] text-slate-500 font-mono">
          <span>© 2026-2040 ILOVEYOUBD.COM ALL RIGHTS RESERVED.</span>
          <span>CRAFTED IN THE Cyber-Native Bangladesh 2040</span>
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

                      if (regName && regName.trim()) {
                        const newAvatar = `https://api.dicebear.com/7.x/pixel-art/svg?seed=${avatarSeed}`;
                        setUserStats({
                          name: regName.trim(),
                          avatar: newAvatar,
                          balance: 10.00, // starting gift bonus
                          points: 100, // starting gift points
                          rank: regRole,
                          postsPublished: 0,
                          postsPending: 0
                        });
                        setIsLoggedIn(true);
                        setShowAuthModal(false);
                        addSystemNotification(`অভিনন্দন ${regName}! আপনার রেজিস্ট্রেশন সফল হয়েছে এবং ১০ টাকা বোনাস ওয়ালেটে যুক্ত হয়েছে।`, "system");
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

                    <div className="bg-[#050911] p-3 rounded border border-cyan-950 text-[10px] leading-relaxed text-slate-400 font-mono">
                      🔒 আপনার রেজিস্ট্রেশন সরাসরি ব্রাউজারে সুরক্ষিত মেমোরিতে সেভ থাকবে। রেজিস্ট্রেশন করলে ১০ টাকা ও ১০০ ফোরাম পয়েন্ট বোনাস পাবেন!
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
            setActiveTab("qa");
            setSelectedPostId(null);
          }}
          className={`flex flex-col items-center justify-center gap-1 text-[11.5px] font-bold font-sans cursor-pointer transition-all duration-300 transform active:scale-95 ${
            activeTab === "qa" ? "text-purple-400 scale-110 shadow-[0_0_15px_rgba(168,85,247,0.1)] font-bold" : "text-slate-400 hover:text-white"
          }`}
        >
          <HelpCircle className={`w-5.5 h-5.5 transition-transform duration-300 ${activeTab === "qa" ? "stroke-[2.5px]" : ""}`} />
          <span>কমিউনিটি Q&A</span>
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

    </div>
  );
}
