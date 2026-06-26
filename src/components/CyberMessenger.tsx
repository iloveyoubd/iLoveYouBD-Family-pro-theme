import React, { useState, useEffect, useRef } from "react";
import { motion, AnimatePresence } from "motion/react";
import { 
  MessageSquare, Send, Users, User, Shield, Gift, Copy, Check,
  Bot, Activity, Hash, ArrowLeft, Search, Phone, Wallet, Award,
  Sparkles, CheckCircle, Smartphone, Flame, Network, ShieldAlert
} from "lucide-react";
import type { UserStats, AdminSettings } from "../types";

interface Message {
  id: string;
  sender: "me" | "them";
  senderName: string;
  senderAvatar: string;
  text: string;
  timestamp: string;
  isAI?: boolean;
}

interface Member {
  name: string;
  avatar: string;
  rank: string;
  isAI: boolean;
  status: "online" | "offline" | "away";
  bio: string;
  skills: string;
  referrals: number;
  joined: string;
  phone?: string;
  bkash?: string;
  fbLink?: string;
}

interface CyberMessengerProps {
  userStats: UserStats;
  setUserStats: React.Dispatch<React.SetStateAction<UserStats>>;
  addSystemNotification: (text: string, type: 'like' | 'comment' | 'post' | 'earning' | 'system') => void;
  adminSettings: AdminSettings;
  isLoggedIn: boolean;
  selectedContactName?: string;
  setSelectedContactName?: (name: string | undefined) => void;
}

const COMMUNITY_MEMBERS: Member[] = [
  {
    name: "এআই অ্যাডমিন অ্যাসিস্ট্যান্ট",
    avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=admin",
    rank: "CHIEF OPERATIVE AI",
    isAI: true,
    status: "online",
    bio: "গুগল অ্যাডসেন্স ইন্টেলিজেন্স ও সার্চ ইঞ্জিন ইনডেক্স গতি অপটিমাইজার। ২৪ ঘণ্টা অন-গ্রিড লাইভ।",
    skills: "Wp-Engine, XML Sitemap, high-CPC Adsense Optimization",
    referrals: 142,
    joined: "২০৪০-০১-০১"
  },
  {
    name: "সাইবার রনি",
    avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=ronny",
    rank: "ELITE WHITEHAT",
    isAI: false,
    status: "online",
    bio: "ডার্ক সিকিউরিটি অ্যানালিস্ট এবং ক্রিপ্টো ওয়ালেট শিল্ড এক্সপার্ট। সাইবার স্প্যামারদের বিরুদ্ধে যুদ্ধ ঘোষণা আমার মিশন।",
    skills: "DNS Verification, SQL Injection defense, Security Auditing",
    referrals: 38,
    phone: "01784XXXXXX",
    bkash: "01784XXXXXX",
    fbLink: "https://facebook.com/cyber.ronny.pro",
    joined: "২০৪০-০২-১২"
  },
  {
    name: "রানা মির্জা",
    avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=rana",
    rank: "SENIOR CONTRIBUTOR",
    isAI: false,
    status: "away",
    bio: "বাংলা প্রিমিয়াম টেক রাইটার ও ফুলস্ট্যাক ব্লগার। প্রতিদিন নতুন কনটেন্ট লিখে ইনকামের সঠিক মেথডের ট্রেইনার।",
    skills: "Content Monetization, Seo friendly drafting, bKash Payout strategies",
    referrals: 29,
    phone: "01945XXXXXX",
    bkash: "01945XXXXXX",
    fbLink: "https://facebook.com/rana.mirza.official",
    joined: "২০৪০-০৩-১৯"
  },
  {
    name: "মায়া (Maya AI)",
    avatar: "https://api.dicebear.com/7.x/bottts/svg?seed=maya",
    rank: "SYSTEM EXECUTIVE AI",
    isAI: true,
    status: "online",
    bio: "iloveyoubd.com-এর অফিসিয়াল এআই মডারেটর। ইন্টারেক্টিভ কুইজ, প্রশ্নোত্তর এবং কমেন্ট রিঅ্যাকশনের জন্য সদা প্রস্তুত।",
    skills: "Natural Language Processing, Interactive UI, Prompt injection shields",
    referrals: 999,
    joined: "২০৪০-০১-০৫"
  },
  {
    name: "সাইবার বাপ্পি",
    avatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=bappi",
    rank: "WHITEHAT CODER",
    isAI: false,
    status: "offline",
    bio: "নতুন সাইবার অ্যাপ্রেন্টিস। এন্ড্রয়েড কোডিং ফ্রেমওয়ার্ক এবং অটো বুস্টিং প্লাগিন নিয়ে রিসার্চ করছি।",
    skills: "Bash, Termux simulation, Node.js",
    referrals: 4,
    phone: "01521XXXXXX",
    bkash: "01521XXXXXX",
    joined: "২০৪০-০৫-০১"
  }
];

export default function CyberMessenger({
  userStats,
  setUserStats,
  addSystemNotification,
  adminSettings,
  isLoggedIn,
  selectedContactName,
  setSelectedContactName
}: CyberMessengerProps) {
  const [activeChannel, setActiveChannel] = useState<"dm" | "group">("dm");
  const [selectedContact, setSelectedContact] = useState<Member>(COMMUNITY_MEMBERS[0]);
  const [activeGroup, setActiveGroup] = useState<"#general-cyber" | "#earning-tips">("#general-cyber");
  const [messageInput, setMessageInput] = useState("");
  const [typingStatus, setTypingStatus] = useState<string | null>(null);
  const [memberSearch, setMemberSearch] = useState("");
  const [showMemberBioModal, setShowMemberBioModal] = useState<Member | null>(null);

  // Referral states within messenger
  const [inputReferralCode, setInputReferralCode] = useState("");
  const [referralMessage, setReferralMessage] = useState<string | null>(null);
  const [referralStatus, setReferralStatus] = useState<"success" | "error" | null>(null);

  // Message databases stored in local state
  const [dmThreads, setDmThreads] = useState<Record<string, Message[]>>(() => {
    const saved = localStorage.getItem("ilybd_messenger_dms");
    if (saved) return JSON.parse(saved);

    // Initial conversations
    return {
      "এআই অ্যাডমিন অ্যাসিস্ট্যান্ট": [
        {
          id: "init-1",
          sender: "them",
          senderName: "এআই অ্যাডমিন অ্যাসিস্ট্যান্ট",
          senderAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=admin",
          text: "আসসালামু আলাইকুম! আমি এআই অ্যাডমিন। আপনার সাইটের গুগল সার্চ ইনডেক্সিং এবং অ্যাডসেন্স রিভিনিউ বৃদ্ধি সংক্রান্ত যেকোনো বিষয়ে প্রশ্ন করতে পারেন।",
          timestamp: "১০:৩০ AM",
          isAI: true
        }
      ],
      "সাইবার রনি": [
        {
          id: "init-2",
          sender: "them",
          senderName: "সাইবার রনি",
          senderAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=ronny",
          text: "হে কোডার! কেমন চলছে রিসার্চ? ডার্ক ওয়েবের ফিশিং লিংক প্রতিরোধ নিয়ে নতুন আর্টিকেল লিখেছি, পারলে দেখে নিও।",
          timestamp: "১১:১৫ AM"
        }
      ],
      "রানা মির্জা": [
        {
          id: "init-3",
          sender: "them",
          senderName: "রানা মির্জা",
          senderAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=rana",
          text: "ইনকাম নিয়ে কোনো চিন্তা করবেন না ভাই। আমাদের ট্রিকবিডি ক্যাটাগরিতে ৫টি পোস্ট লিখে ফেলুন, এডমিন রিভিউ করে সরাসরি ৮.৫০ টাকা প্রতি পোস্ট বোনাস রিলিজ করে দেবে!",
          timestamp: "গতকাল"
        }
      ],
      "মায়া (Maya AI)": [
        {
          id: "init-4",
          sender: "them",
          senderName: "মায়া (Maya AI)",
          senderAvatar: "https://api.dicebear.com/7.x/bottts/svg?seed=maya",
          text: "হ্যালো সোনা বন্ধু! আমি মায়া, আপনার ২৪ ঘণ্টার চ্যাট অপারেটর। কোনো কিছু বুঝতে সমস্যা হচ্ছে? আমাকে বলুন, আমি বুঝিয়ে দিচ্ছি।",
          timestamp: "১২:৪০ PM",
          isAI: true
        }
      ]
    };
  });

  const [groupMessages, setGroupMessages] = useState<Record<string, Message[]>>(() => {
    const saved = localStorage.getItem("ilybd_messenger_groups");
    if (saved) return JSON.parse(saved);

    return {
      "#general-cyber": [
        {
          id: "g1-1",
          sender: "them",
          senderName: "সাইবার রনি",
          senderAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=ronny",
          text: "বন্ধুরা! গুগল সার্চ কনসোলে ইনডেক্সিং স্পিড বাড়ানোর নতুন কোড আমাদের 'মেগা টুলস হাব'-এ যুক্ত করা হয়েছে। টেস্ট করে জানাও!",
          timestamp: "১০:১৫ AM"
        },
        {
          id: "g1-2",
          sender: "them",
          senderName: "এআই অ্যাডমিন অ্যাসিস্ট্যান্ট",
          senderAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=admin",
          text: "হ্যাঁ, নতুন এপিআই সেশন ১০০% স্মুথলি কাজ করছে। কন্টেন্ট মনিটাইজেশন ট্রাফিক ভালোই কনভার্ট হচ্ছে।",
          timestamp: "১০:১৬ AM",
          isAI: true
        }
      ],
      "#earning-tips": [
        {
          id: "g2-1",
          sender: "them",
          senderName: "রানা মির্জা",
          senderAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=rana",
          text: "সবাই চেষ্টা করুন ইউনিক হেডার এবং তুলনা করার টেবিল যুক্ত পোস্ট আর্ট করতে। এআই স্কোর ৯০+ হলে বিকাশ পেমেন্ট ইনস্ট্যান্ট অ্যাপ্রুভড হয়!",
          timestamp: "০৯:০৫ AM"
        },
        {
          id: "g2-2",
          sender: "them",
          senderName: "সাইবার বাপ্পি",
          senderAvatar: "https://api.dicebear.com/7.x/pixel-art/svg?seed=bappi",
          text: "মির্জা ভাই, আমি ইতিমধ্যে আমার ৩ জন বন্ধুকে রেফার করেছি। আমার ওয়ালেটে ৩০ টাকা রেফার ব্যালেন্স এড হয়ে গেছে!",
          timestamp: "০৯:১২ AM"
        }
      ]
    };
  });

  const chatEndRef = useRef<HTMLDivElement>(null);

  // Sync to outer deeply linked selectedContactName
  useEffect(() => {
    if (selectedContactName) {
      const match = COMMUNITY_MEMBERS.find(m => m.name.toLowerCase().includes(selectedContactName.toLowerCase()));
      if (match) {
        setSelectedContact(match);
        setActiveChannel("dm");
      }
      if (setSelectedContactName) {
        setSelectedContactName(undefined); // Clear after applying
      }
    }
  }, [selectedContactName, setSelectedContactName]);

  // Keep scroll at bottom
  useEffect(() => {
    chatEndRef.current?.scrollIntoView({ behavior: "smooth" });
  }, [dmThreads, groupMessages, selectedContact, activeGroup, typingStatus, activeChannel]);

  // Save changes
  useEffect(() => {
    localStorage.setItem("ilybd_messenger_dms", JSON.stringify(dmThreads));
  }, [dmThreads]);

  useEffect(() => {
    localStorage.setItem("ilybd_messenger_groups", JSON.stringify(groupMessages));
  }, [groupMessages]);

  // Handle send message logic
  const handleSendMessage = () => {
    if (!messageInput.trim()) return;

    const currentTime = new Date().toLocaleTimeString("bn-BD", { 
      hour: "2-digit", 
      minute: "2-digit" 
    });

    const newMsg: Message = {
      id: `msg-${Date.now()}`,
      sender: "me",
      senderName: isLoggedIn ? userStats.name : "ভিজিটর ফাইটার",
      senderAvatar: userStats.avatar || "https://api.dicebear.com/7.x/bottts/svg?seed=tester",
      text: messageInput.trim(),
      timestamp: currentTime
    };

    if (activeChannel === "dm") {
      const contactName = selectedContact.name;
      // Add message to DM Thread
      setDmThreads(prev => {
        const currentThread = prev[contactName] || [];
        return {
          ...prev,
          [contactName]: [...currentThread, newMsg]
        };
      });

      setMessageInput("");

      // Trigger automatic AI/Persona reply simulation
      simulatePersonaReply(contactName, messageInput.trim());
    } else {
      // Add message to Group Channel
      setGroupMessages(prev => {
        const currentGroupMsgs = prev[activeGroup] || [];
        return {
          ...prev,
          [activeGroup]: [...currentGroupMsgs, newMsg]
        };
      });

      setMessageInput("");

      // Trigger standard group discussion replies
      simulateGroupDiscussion(activeGroup);
    }
  };

  // Simulate Member responses styled natively
  const simulatePersonaReply = (contactName: string, userText: string) => {
    setTypingStatus(`${contactName} টাইপ করছেন...`);

    const replyDelayMs = 1500 + Math.random() * 1500;

    setTimeout(() => {
      setTypingStatus(null);
      let replyText = "";

      // Smart decision logic based on who the user messaged
      if (contactName.includes("অ্যাডমিন")) {
        const triggers = ["adsense", "এডসেন্স", "ইনডেক্স", "index", "পেমেন্ট", "টাকা", "payment"];
        const hasTrigger = triggers.some(t => userText.toLowerCase().includes(t));

        if (hasTrigger) {
          replyText = "গুগল অ্যাডসেন্স পেমেন্ট ভেরিফিকেশন সিস্টেম সাকসেসফুলি কাজ করছে সোনা বন্ধু। আপনার ওয়ালেট ব্যালেন্স ৫০ টাকা পুশ করলেই উইথড্রয়াল বিকাশ রিকোয়েস্ট করতে পারবেন। কোনো চিন্তা ছাড়া মানসম্পন্ন কন্টেন্ট ট্রিকবিডি ক্যাটাগরিতে সাবমিট করুন।";
        } else {
          replyText = "চমৎকার প্রশ্ন! আমাদের সার্ভার এআই সকেটে গুগল ইনডেক্সিং স্ক্রিপ্ট ইন্টিগ্রেট করা আছে। আপনি 'টুলস ল্যাব' অংশে গিয়ে গুগল মেটা কনসোল বুস্টার টুলটি রান করতে পারেন। এটি মাত্র ৫ মিনিটে সাইটম্যাপ রেন্ডার করবে!";
        }
      } else if (contactName.includes("রনি")) {
        const phrases = ["vpn", "hack", "হ্যাকিং", "সিকিউরিটি", "security"];
        const hasTrigger = phrases.some(p => userText.toLowerCase().includes(p));

        if (hasTrigger) {
          replyText = "নিরাপত্তা হচ্ছে সাইবার ওয়ার্ল্ডের মূল ঢাল। যেকোনো ফিশিং ইমেইল বা ফেসবুক লিংক ভেরিফাই করুন। আর কোনো পাসওয়ার্ড ৩টি সংখ্যার কম দিয়েন না। আমাদের প্ল্যাটফর্ম সম্পূর্ণ সিকিউরড মেথডে ডেটা স্টোর করে।";
        } else {
          replyText = "ধন্যবাদ নক করার জন্য। আমি আমার ডার্ক মডিউল নিয়ে কাজ করছি। সাইটের মেগা সিকিউরিটি টিপস দেখে নিও, ওগুলো প্রতি সপ্তাহে আপডেট করা হয়। কোনো হেল্প লাগলে সরাসরি আমাকে বলতে পারো।";
        }
      } else if (contactName.includes("রানা")) {
        replyText = "আরে ভাই! কনটেন্ট লিখে ইনকাম করা এখন সবচেয়ে ইজি। আপনি জাস্ট ট্রিকবিডি ক্যাটাগরিতে ক্লিক করবেন, একটা প্রো-টুলস এর আর্টিকেল লিখবেন আর শেয়ার করবেন। প্রতি ইউনিক পোস্টের জন্য সাথে সাথে ৮.৫০ BDT ট্যাপ ক্রেডিট পাওয়া যাবে।";
      } else if (contactName.includes("মায়া") || contactName.includes("Maya")) {
        replyText = `আপনার মনের সব প্রশ্নের উত্তর নিয়ে আমি তৈরি! আপনি লিখেছেন: "${userText}"। এটি দারুণ কথা প্রিয় কোডার। আমাদের এই ফোরামে রেফারেল ও মেসেজিং সিস্টেম এখন শতভাগ অ্যাক্টিভ। আপনার বন্ধুদের সাথে রেফার করুন আর বোনাস ট্যাপ করুন!`;
      } else {
        replyText = "আসসালামু আলাইকুম। আমি আপনার মেসেজটি পেয়েছি। একটু ব্যস্ত থাকায় উত্তর দিতে দেরি হতে পারে। ফোরামে একটি প্রশ্ন করুন, দ্রুত সমাধান দেওয়ার ট্রাই করব ভাই। ধন্যবাদ!";
      }

      const currentTime = new Date().toLocaleTimeString("bn-BD", { 
        hour: "2-digit", 
        minute: "2-digit" 
      });

      const reactionMsg: Message = {
        id: `reply-${Date.now()}`,
        sender: "them",
        senderName: contactName,
        senderAvatar: COMMUNITY_MEMBERS.find(m => m.name === contactName)?.avatar || "https://api.dicebear.com/7.x/pixel-art/svg?seed=user",
        text: replyText,
        timestamp: currentTime,
        isAI: contactName.includes("অ্যাডমিন") || contactName.includes("মায়া")
      };

      setDmThreads(prev => {
        const currentThread = prev[contactName] || [];
        return {
          ...prev,
          [contactName]: [...currentThread, reactionMsg]
        };
      });

      // Show system push notification for receipt
      addSystemNotification(`💬 মেসেজ এসেছে: ${contactName} আপনাকে একটি ডিরেক্ট রিপ্লাই পাঠিয়েছেন।`, "comment");

    }, replyDelayMs);
  };

  // Simulate group answers to make it active and alive
  const simulateGroupDiscussion = (group: string) => {
    const randomMember = COMMUNITY_MEMBERS[Math.floor(Math.random() * COMMUNITY_MEMBERS.length)];
    if (randomMember.name === (isLoggedIn ? userStats.name : "ভিজিটর ফাইটার")) return;

    setTypingStatus(`${randomMember.name} গ্রুপে লিখছেন...`);

    setTimeout(() => {
      setTypingStatus(null);
      let gReplyText = "";

      if (group === "#general-cyber") {
        const lines = [
          "হ্যাঁ, সঠিক বলেছ! ২০৪০ সালের সিকিউরিটি প্রোটোকল আমাদের আইডেন্টিটি এনক্রিপ্ট রাখতে সক্ষম।",
          "আমি আজকে গুগল অ্যাডসেন্স থেকে আরেকটি পেমেন্ট উইথড্র করলাম। ফোরাম লিডারদের অভিনন্দন!",
          "ভিডিও ডাউনলোডার মডিউলটি দিয়ে কটক নো-ওয়াটারমার্ক ভিডিও ডিরেক্ট স্পিডে ডাউনলোড হচ্ছে। জোস!",
          "টুলস ল্যাব এর এনআইডি কার্ড সিস্টেম দিয়ে ডেমো ট্র্যাকিং অনেক সুন্দর হচ্ছে।"
        ];
        gReplyText = lines[Math.floor(Math.random() * lines.length)];
      } else {
        const lines = [
          "আমার রেফারেল কোড কপি করে বন্ধুদের দিয়েছি, ৩ জন ইনস্ট্যান্ট জয়েন করাতে ব্যালেন্স বেড়েছে!",
          "পোস্টে লাইক ও ভিউ বাড়ানোর ট্রিকস হচ্ছে ইউনিক থাম্বনেইল আপলোড করা, এআই জেনারেটেড ইমেজ জোস কাজ করে।",
          "আমাদের বিকাশ ওয়ালেটে খুব কম সময়ে উইথড্রয়াল প্রসেসিং রিকোয়েস্ট কমপ্লিট হচ্ছে। এটি খুব ভালো সার্ভিস!",
          "প্রতিদিন মাত্র ৩০ মিনিট কন্টেন্ট লিখলেই অনায়াসে ৩০০ টাকা আর্ন করা পসিবল হচ্ছে ভাই।"
        ];
        gReplyText = lines[Math.floor(Math.random() * lines.length)];
      }

      const currentTime = new Date().toLocaleTimeString("bn-BD", { 
        hour: "2-digit", 
        minute: "2-digit" 
      });

      const responseMsg: Message = {
        id: `gReply-${Date.now()}`,
        sender: "them",
        senderName: randomMember.name,
        senderAvatar: randomMember.avatar,
        text: gReplyText,
        timestamp: currentTime,
        isAI: randomMember.isAI
      };

      setGroupMessages(prev => {
        const currentGroupMsgs = prev[group] || [];
        return {
          ...prev,
          [group]: [...currentGroupMsgs, responseMsg]
        };
      });

    }, 3000 + Math.random() * 2000);
  };

  // Profile referral validation and submission
  const handleApplyReferral = (e: React.FormEvent) => {
    e.preventDefault();
    setReferralMessage(null);

    const code = inputReferralCode.trim().toUpperCase();
    if (!code) return;

    if (userStats.referredBy) {
      setReferralStatus("error");
      setReferralMessage("❌ আপনি ইতিমধ্যে অন্য কোডার দ্বারা রেফার হয়েছেন!");
      return;
    }

    if (code === userStats.referralCode || code.includes(userStats.name.replace(/\s+/g, "").toUpperCase().substring(0, 5))) {
      setReferralStatus("error");
      setReferralMessage("❌ দুঃখিত! আপনি নিজের রেফারেল কোড নিজে ব্যবহার করতে পারবেন না!");
      return;
    }

    // Process valid referal
    const bonusTaka = adminSettings.refereeBonusTaka !== undefined ? adminSettings.refereeBonusTaka : 10;
    const bonusXp = adminSettings.refereeXpReward !== undefined ? adminSettings.refereeXpReward : 100;

    setUserStats(prev => ({
      ...prev,
      referredBy: code,
      balance: Number((prev.balance + bonusTaka).toFixed(2)),
      points: prev.points + bonusXp
    }));

    setReferralStatus("success");
    setReferralMessage(`🎉 অভিনন্দন! রেফারেল সাকসেসফুল! আপনার ওয়ালেটে +${bonusTaka} ৳ বিকাশ ব্যালেন্স এবং +${bonusXp} XP যোগ করা হয়েছে!`);
    addSystemNotification(`🎯 রেফার কোড ${code} প্রয়োগ করা হয়েছে! +${bonusTaka} TK ও +${bonusXp} XP বোনাস ক্রেডিটেড।`, "earning");
    setInputReferralCode("");
  };

  // Filtered members for sidebar search
  const filteredMembers = COMMUNITY_MEMBERS.filter(m => 
    m.name.toLowerCase().includes(memberSearch.toLowerCase()) ||
    m.rank.toLowerCase().includes(memberSearch.toLowerCase())
  );

  return (
    <div className="bg-[#090d16] border border-cyan-950 rounded-2xl shadow-2xl relative overflow-hidden h-[630px] flex flex-col font-sans">
      <div className="absolute inset-0 bg-gradient-to-tr from-cyan-950/20 via-transparent to-purple-950/25 pointer-events-none" />

      {/* Grid containing Sidebar and Conversational Panel */}
      <div className="flex-1 flex overflow-hidden">
        
        {/* Left Column Navigation - 30% width */}
        <div className="w-full md:w-80 border-r border-cyan-950 bg-slate-950/80 flex flex-col shrink-0">
          
          {/* Header search / selectors */}
          <div className="p-4 border-b border-cyan-950 space-y-3">
            <div className="flex items-center justify-between">
              <span className="text-xs font-mono font-black text-cyan-400 uppercase tracking-widest flex items-center gap-1.5">
                <Activity className="w-4 h-4 text-cyan-400 animate-pulse" /> সাইবার সকেট মেসেঞ্জার
              </span>
              <span className="bg-cyan-950/80 border border-cyan-800 text-cyan-300 px-1.5 py-0.5 rounded text-[8.5px] font-mono leading-none font-bold uppercase tracking-widest">
                2040 V3
              </span>
            </div>

            {/* Segment controller */}
            <div className="grid grid-cols-2 gap-1.5 bg-slate-900/90 p-1 rounded-lg border border-cyan-950">
              <button
                onClick={() => setActiveChannel("dm")}
                className={`py-1.5 rounded text-xs font-mono font-bold flex items-center justify-center gap-1 transition-all cursor-pointer ${
                  activeChannel === "dm" 
                    ? "bg-cyan-950 text-cyan-300 border border-cyan-900 shadow-sm" 
                    : "text-slate-400 hover:text-white"
                }`}
              >
                <User className="w-3.5 h-3.5" /> ডিরেক্ট মেসেজ
              </button>
              <button
                onClick={() => setActiveChannel("group")}
                className={`py-1.5 rounded text-xs font-mono font-bold flex items-center justify-center gap-1 transition-all cursor-pointer ${
                  activeChannel === "group" 
                    ? "bg-purple-950 text-purple-300 border border-purple-900 shadow-sm" 
                    : "text-slate-400 hover:text-white"
                }`}
              >
                <Users className="w-3.5 h-3.5" /> চ্যাটরুমস
              </button>
            </div>
          </div>

          {/* List display based on selected mode */}
          <div className="flex-1 overflow-y-auto p-2 space-y-1 scrollbar-thin">
            
            {activeChannel === "dm" ? (
              <>
                {/* Search members */}
                <div className="mb-2 px-1 relative">
                  <input
                    type="text"
                    placeholder="মেম্বার খুঁজুন..."
                    value={memberSearch}
                    onChange={(e) => setMemberSearch(e.target.value)}
                    className="w-full bg-slate-900/80 border border-cyan-950/60 rounded-lg p-2 text-xs font-sans text-slate-100 placeholder-slate-500 outline-none focus:border-cyan-500/50 transition-all font-sans"
                  />
                  <Search className="w-3.5 h-3.5 text-slate-500 absolute right-3 top-2.5" />
                </div>

                {filteredMembers.map((member) => (
                  <div
                    key={member.name}
                    onClick={() => setSelectedContact(member)}
                    className={`p-3 rounded-xl flex items-center gap-3 cursor-pointer transition-all border ${
                      selectedContact.name === member.name
                        ? "bg-[#0b172a] border-cyan-950/90 shadow-[0_0_12px_rgba(0,240,255,0.03)]"
                        : "bg-transparent border-transparent hover:bg-slate-900/60"
                    }`}
                  >
                    <div className="relative">
                      <div className="w-10 h-10 rounded-full border border-cyan-950/55 overflow-hidden bg-slate-950 p-0.5">
                        <img src={member.avatar} alt={member.name} className="w-full h-full rounded-full object-cover" />
                      </div>
                      
                      {/* Active green spot */}
                      <span className={`absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-slate-950 ${
                        member.status === "online" ? "bg-emerald-500 animate-pulse" : member.status === "away" ? "bg-amber-500" : "bg-slate-600"
                      }`} />
                    </div>

                    <div className="flex-1 min-w-0 text-left">
                      <div className="flex justify-between items-center">
                        <span className="text-xs sm:text-[12.5px] font-semibold text-slate-200 block truncate leading-none">
                          {member.name}
                        </span>
                        {member.isAI && (
                          <span className="text-[7.5px] font-mono text-purple-400 bg-purple-950/70 border border-purple-800 px-1 rounded">
                            এআই
                          </span>
                        )}
                      </div>
                      
                      {/* Rank badge */}
                      <span className="text-[10px] font-mono text-[#00f0ff] uppercase block truncate mt-1">
                        {member.rank}
                      </span>
                    </div>
                  </div>
                ))}
              </>
            ) : (
              // Group Chat channels selection
              <div className="space-y-1">
                {[
                  { id: "#general-cyber", title: "ফোরাম মেইন চ্যাট (General)", desc: "সকল সিকিউরিটি কোডারদের উন্মুক্ত আড্ডা", color: "text-cyan-400" },
                  { id: "#earning-tips", title: "অনলাইন আর্নিং টিপস (Earning)", desc: "বিকাশ আয় ও কন্টেন্ট ক্যাশআউট সাপোর্ট", color: "text-purple-400" }
                ].map((gr) => (
                  <div
                    key={gr.id}
                    onClick={() => setActiveGroup(gr.id as any)}
                    className={`p-3.5 rounded-xl cursor-pointer transition-all border text-left ${
                      activeGroup === gr.id
                        ? "bg-[#0b172a] border-cyan-950/90 shadow-[0_0_12px_rgba(0,240,255,0.03)]"
                        : "bg-transparent border-transparent hover:bg-slate-900/60"
                    }`}
                  >
                    <div className="flex items-center gap-2">
                      <Hash className={`w-4.5 h-4.5 ${gr.color} animate-pulse`} />
                      <span className="text-xs sm:text-[12.5px] font-bold text-slate-200">
                        {gr.title}
                      </span>
                    </div>
                    <span className="text-[10px] text-slate-400 font-sans block mt-1 leading-relaxed">
                      {gr.desc}
                    </span>
                  </div>
                ))}
              </div>
            )}
          </div>

          {/* User Stats/Short Profile at footer of sidebar */}
          <div className="p-3 bg-slate-950 border-t border-cyan-950 flex items-center justify-between gap-1">
            <div className="flex items-center gap-2 min-w-0">
              <div className="w-8 h-8 rounded-full border border-cyan-900 overflow-hidden shrink-0 bg-slate-900 p-0.5">
                <img src={userStats.avatar} alt="User" className="w-full h-full rounded-full object-cover" />
              </div>
              <div className="text-left min-w-0">
                <span className="text-[11px] font-semibold text-slate-300 block truncate">{userStats.name}</span>
                <span className="text-[9px] font-mono text-emerald-400 block">{userStats.balance.toFixed(2)} ৳ BDT</span>
              </div>
            </div>
            
            {/* View Bio link */}
            <button
              onClick={() => {
                const myMember: Member = {
                  name: userStats.name,
                  avatar: userStats.avatar,
                  rank: userStats.rank || "MEMBER CODER",
                  isAI: false,
                  status: "online",
                  bio: localStorage.getItem("ilybd_profile_bio") || "কোনো বায়ো এখনো সেট করা হয়নি। প্রোফাইল অপশনে গিয়ে তা লিখুন!",
                  skills: localStorage.getItem("ilybd_profile_skills") || "HTML, Cyber Security",
                  phone: localStorage.getItem("ilybd_profile_phone") || "সেট করা হয়নি",
                  bkash: localStorage.getItem("ilybd_profile_bkash") || "সেট করা হয়নি",
                  fbLink: localStorage.getItem("ilybd_profile_fblink") || "সেট করা হয়নি",
                  referrals: userStats.referredUsers?.length || 0,
                  joined: "আজ এইমাত্র"
                };
                setShowMemberBioModal(myMember);
              }}
              className="text-[9px] font-mono text-cyan-400 hover:text-white px-2 py-1 bg-cyan-950/50 hover:bg-cyan-950 border border-cyan-900/50 rounded transition-all cursor-pointer"
            >
              প্রোফাইল কার্ড
            </button>
          </div>
        </div>

        {/* Right Column Conversation window - 70% width */}
        <div className="flex-1 flex flex-col bg-[#050911]/90 relative overflow-hidden">
          
          {/* Active Header bar of selected Chat */}
          <div className="p-4 bg-slate-950/80 border-b border-cyan-950 flex items-center justify-between">
            <div className="flex items-center gap-3">
              <div className="relative">
                <div className="w-10 h-10 rounded-full border border-cyan-900 overflow-hidden bg-slate-900 p-0.5">
                  <img 
                    src={activeChannel === "dm" ? selectedContact.avatar : "https://api.dicebear.com/7.x/pixel-art/svg?seed=chat"} 
                    alt="Active Header"
                    className="w-full h-full rounded-full object-cover"
                  />
                </div>
                {activeChannel === "dm" && (
                  <span className={`absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full border-2 border-slate-950 ${
                    selectedContact.status === "online" ? "bg-emerald-500 animate-pulse" : selectedContact.status === "away" ? "bg-amber-500" : "bg-slate-600"
                  }`} />
                )}
              </div>

              <div className="text-left">
                <h4 className="text-xs sm:text-[13px] font-extrabold text-white font-sans flex items-center gap-1.5 leading-none">
                  {activeChannel === "dm" ? selectedContact.name : activeGroup}
                  {activeChannel === "dm" && selectedContact.isAI && (
                    <span className="text-[7.5px] font-mono text-purple-400 bg-purple-950/70 border border-purple-800 px-1 rounded">
                      এআই
                    </span>
                  )}
                </h4>
                
                <span className="text-[10px] font-mono text-slate-400 block mt-1">
                  {activeChannel === "dm" ? selectedContact.rank : "পাবলিক ফোরাম গ্রুপ চ্যাট নোডসমূহ"}
                </span>
              </div>
            </div>

            {/* Profile info button of targeted chat contact */}
            {activeChannel === "dm" && (
              <button
                onClick={() => setShowMemberBioModal(selectedContact)}
                className="text-[10px] sm:text-xs text-slate-300 bg-[#0c1a2d] hover:bg-cyan-950 border border-cyan-900 px-3 py-1.5 rounded-lg flex items-center gap-1 font-mono transition-all cursor-pointer"
              >
                <User className="w-3.5 h-3.5 text-cyan-400" /> প্রোফাইল কার্ড
              </button>
            )}
          </div>

          {/* Chat Window Message Stream Scrollable list */}
          <div className="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar">
            
            {/* Direct DM list */}
            {((activeChannel === "dm" ? dmThreads[selectedContact.name] : groupMessages[activeGroup]) || []).map((msg, i) => {
              const isMe = msg.sender === "me";
              return (
                <div key={msg.id || i} className={`flex gap-3 max-w-[85%] ${isMe ? "ml-auto flex-row-reverse" : "mr-auto"}`}>
                  
                  {/* Sender Profile Avatar icon */}
                  {!isMe && (
                    <div 
                      onClick={() => {
                        const matched = COMMUNITY_MEMBERS.find(m => m.name === msg.senderName);
                        if (matched) setShowMemberBioModal(matched);
                      }}
                      className="w-8.5 h-8.5 rounded-full border border-cyan-950 shrink-0 overflow-hidden bg-slate-950 p-0.5 cursor-pointer"
                    >
                      <img src={msg.senderAvatar} alt={msg.senderName} className="w-full h-full rounded-full object-cover" />
                    </div>
                  )}

                  <div className="space-y-1">
                    {/* Authors name header */}
                    <div className="flex items-center gap-1.5 text-[10px] font-mono text-slate-400">
                      <span>{isMe ? "আপনি" : msg.senderName}</span>
                      <span>•</span>
                      <span>{msg.timestamp}</span>
                    </div>

                    {/* Chat Text Bubble containing style details */}
                    <div className={`p-3 rounded-2xl text-[12px] sm:text-[13px] font-sans leading-relaxed text-left border ${
                      isMe 
                        ? "bg-gradient-to-br from-cyan-950/90 to-blue-950/80 border-cyan-500/35 text-white rounded-tr-none" 
                        : "bg-[#0c1224] border-cyan-950/60 text-slate-200 rounded-tl-none"
                    }`}>
                      {msg.text}
                    </div>
                  </div>
                </div>
              );
            })}

            {/* Simulated typing indicator */}
            {typingStatus && (
              <div className="flex gap-2 mr-auto items-center">
                <span className="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-bounce" />
                <span className="w-2.5 h-2.5 rounded-full bg-purple-400 animate-bounce [animation-delay:0.2s]" />
                <span className="text-[10px] font-mono text-cyan-400/80 animate-pulse">{typingStatus}</span>
              </div>
            )}

            <div ref={chatEndRef} />
          </div>

          {/* Bottom Referral application panel for missing rewards */}
          {activeChannel === "dm" && selectedContact.name.includes("অ্যাডমিন") && !userStats.referredBy && (
            <div className="p-3 bg-amber-950/15 border-t border-dashed border-amber-900/40 text-left">
              <form onSubmit={handleApplyReferral} className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                <div className="flex items-start gap-1.5">
                  <Gift className="w-4.5 h-4.5 text-amber-500 shrink-0 mt-0.5 animate-pulse" />
                  <div>
                    <span className="block text-[11px] font-bold text-slate-100 leading-none">কারো রেফারেলের কোড প্রয়োগ করুন?</span>
                    <span className="text-[9.5px] font-mono text-slate-400">ব্যালেন্সে ইনস্ট্যান্ট +১০ ৳ এবং +১০০ XP বোনাস অর্জন করতে অ্যাডমিনকে রেফারাল কোড দিন</span>
                  </div>
                </div>

                <div className="flex w-full sm:w-auto items-center gap-1.5 shrink-0">
                  <input
                    type="text"
                    placeholder="যেমন- REF-ADMIN78"
                    value={inputReferralCode}
                    onChange={(e) => setInputReferralCode(e.target.value)}
                    className="bg-slate-950 border border-amber-500/30 rounded px-2.5 py-1 text-[10.5px] font-mono text-amber-400 outline-none w-full sm:w-36 placeholder-amber-950"
                  />
                  <button
                    type="submit"
                    className="bg-amber-600 hover:bg-amber-500 hover:text-slate-950 text-slate-200 text-[10px] font-mono px-3 py-1.5 rounded font-bold cursor-pointer transition-all border border-amber-700 uppercase"
                  >
                    প্রয়োগ করুন
                  </button>
                </div>
              </form>

              {referralMessage && (
                <div className={`mt-1.5 text-[10px] font-mono ${referralStatus === "success" ? "text-emerald-400" : "text-amber-400"}`}>
                  {referralMessage}
                </div>
              )}
            </div>
          )}

          {/* Form write input container */}
          <div className="p-3 bg-slate-950 border-t border-cyan-950 flex items-center gap-2">
            <input
              type="text"
              placeholder={activeChannel === "dm" ? `${selectedContact.name} কে মেসেজ পাঠান...` : "চ্যাটরুমে কিছু লিখুন..."}
              value={messageInput}
              onChange={(e) => setMessageInput(e.target.value)}
              onKeyDown={(e) => e.key === "Enter" && handleSendMessage()}
              className="flex-1 bg-slate-900 border border-cyan-950 rounded-xl px-4 py-2.5 text-xs sm:text-[13px] font-sans text-slate-100 placeholder-slate-500 outline-none focus:border-cyan-500/40 transition-all font-sans"
            />
            
            <button
              onClick={handleSendMessage}
              className="bg-cyan-500 hover:bg-cyan-400 text-slate-950 p-2.5 rounded-xl transition-all cursor-pointer shrink-0 border border-cyan-400 shadow-[0_0_10px_rgba(6,182,212,0.15)] flex items-center justify-center"
            >
              <Send className="w-4 h-4 text-black" />
            </button>
          </div>

        </div>

      </div>

      {/* Member Details Bio Modal Dialog */}
      <AnimatePresence>
        {showMemberBioModal && (
          <div className="absolute inset-0 bg-[#060a12]/92 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <motion.div
              initial={{ scale: 0.95, opacity: 0 }}
              animate={{ scale: 1, opacity: 1 }}
              exit={{ scale: 0.95, opacity: 0 }}
              className="w-full max-w-md bg-[#090e17] border border-cyan-950 rounded-2xl shadow-2xl p-5 text-left relative overflow-hidden"
            >
              {/* Concentric neon glow design */}
              <div className="absolute -top-12 -right-12 w-32 h-32 bg-cyan-500/10 blur-2xl rounded-full" />
              <div className="absolute -bottom-12 -left-12 w-32 h-32 bg-purple-500/5 blur-2xl rounded-full" />

              {/* Header profile details */}
              <div className="flex items-start justify-between border-b border-cyan-950 pb-4 mb-4">
                <div className="flex gap-3">
                  <div className="w-14 h-14 rounded-full border-2 border-cyan-500/60 overflow-hidden bg-slate-950 p-0.5">
                    <img src={showMemberBioModal.avatar} alt={showMemberBioModal.name} className="w-full h-full rounded-full object-cover" />
                  </div>
                  <div>
                    <h3 className="text-sm font-semibold font-sans text-slate-100 flex items-center gap-1.5">
                      {showMemberBioModal.name}
                      {showMemberBioModal.isAI && (
                        <span className="text-[7px] font-mono text-purple-400 bg-purple-950/70 border border-purple-800 px-1 rounded uppercase">AI</span>
                      )}
                    </h3>
                    <span className="text-[10px] font-mono text-[#00f0ff] uppercase block mt-1">{showMemberBioModal.rank}</span>
                    <span className="text-[9px] font-mono text-slate-400 block mt-0.5">যোগদান: {showMemberBioModal.joined}</span>
                  </div>
                </div>

                <button
                  onClick={() => setShowMemberBioModal(null)}
                  className="p-1 px-2.5 rounded hover:bg-slate-900 border border-cyan-950/40 text-[10px] font-mono text-slate-400 hover:text-white"
                >
                  বন্ধ করুন ✕
                </button>
              </div>

              {/* Bio & Information Grid */}
              <div className="space-y-4 text-xs">
                <div>
                  <label className="text-[9.5px] font-mono text-slate-500 uppercase block mb-1">কোডার পরিচয় / Bio:</label>
                  <p className="font-sans leading-relaxed text-slate-300 bg-[#050a12]/50 p-3 rounded-lg border border-cyan-950/40">
                    {showMemberBioModal.bio}
                  </p>
                </div>

                <div className="grid grid-cols-2 gap-3.5">
                  <div>
                    <label className="text-[9.5px] font-mono text-slate-500 uppercase block mb-0.5">অভিজ্ঞ স্কিলসমূহ:</label>
                    <span className="font-mono text-[10.5px] text-[#39ff14] block">{showMemberBioModal.skills}</span>
                  </div>
                  <div>
                    <label className="text-[9.5px] font-mono text-slate-500 uppercase block mb-0.5">সফল রেফারেলস:</label>
                    <span className="font-mono text-[11px] text-[#ffae00] block">{showMemberBioModal.referrals} জন কোডার</span>
                  </div>
                </div>

                {/* Secure Contact Details if available */}
                {(showMemberBioModal.phone || showMemberBioModal.bkash || showMemberBioModal.fbLink) && (
                  <div className="bg-[#040810]/80 p-3 rounded-lg border border-cyan-950/50 space-y-2">
                    <span className="text-[9.5px] font-mono text-slate-400 uppercase tracking-wider block border-b border-cyan-950 pb-1 mb-1">🔐 যোগাযোগ সংবেদনশীল তথ্য (মেম্বার)</span>
                    
                    {showMemberBioModal.phone && (
                      <div className="flex justify-between items-center text-[10.5px]">
                        <span className="text-slate-500 font-mono flex items-center gap-1">
                          <Smartphone className="w-3.5 h-3.5 text-cyan-400" /> মোবাইল নম্বর:
                        </span>
                        <span className="font-mono text-slate-300">{showMemberBioModal.phone}</span>
                      </div>
                    )}

                    {showMemberBioModal.bkash && (
                      <div className="flex justify-between items-center text-[10.5px]">
                        <span className="text-slate-500 font-mono flex items-center gap-1">
                          <Wallet className="w-3.5 h-3.5 text-purple-400" /> বিকাশ ওয়ালেট:
                        </span>
                        <span className="font-mono text-slate-300">{showMemberBioModal.bkash}</span>
                      </div>
                    )}

                    {showMemberBioModal.fbLink && (
                      <div className="flex justify-between items-center text-[10.5px]">
                        <span className="text-slate-500 font-mono">🔗 সোশ্যাল প্রোফাইল:</span>
                        <a 
                          href={showMemberBioModal.fbLink} 
                          target="_blank" 
                          rel="noopener noreferrer" 
                          className="font-mono text-cyan-400 underline hover:text-[#00f0ff]"
                        >
                          Facebook profile
                        </a>
                      </div>
                    )}
                  </div>
                )}
              </div>

              {/* Bottom Quick Messaging triggers */}
              {showMemberBioModal.name !== userStats.name && (
                <div className="mt-5 pt-3.5 border-t border-cyan-950 flex gap-2">
                  <button
                    onClick={() => {
                      setSelectedContact(showMemberBioModal);
                      setActiveChannel("dm");
                      setShowMemberBioModal(null);
                    }}
                    className="w-full bg-gradient-to-r from-cyan-600 to-cyan-500 hover:from-cyan-500 hover:to-cyan-400 text-slate-950 font-bold py-2 rounded-xl text-xs flex items-center justify-center gap-1 transition-all cursor-pointer shadow-[0_0_15px_rgba(0,240,255,0.15)]"
                  >
                    <MessageSquare className="w-4 h-4 text-black" /> সরাসরি মেসেজ পাঠান
                  </button>
                </div>
              )}
            </motion.div>
          </div>
        )}
      </AnimatePresence>

    </div>
  );
}
