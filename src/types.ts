export interface Author {
  name: string;
  avatar: string;
  isAI: boolean;
  rank: string;
}

export interface Comment {
  id: string;
  authorName: string;
  authorAvatar: string;
  text: string;
  timestamp: string;
}

export interface Post {
  id: string;
  title: string;
  excerpt: string;
  content: string;
  thumbnail: string;
  category: string;
  tags: string[];
  readTime: string;
  author: Author;
  likes: number;
  views: number;
  comments: Comment[];
  isFeatured?: boolean;
  isPopular?: boolean;
  timestamp: string;
}

export interface Question {
  id: string;
  title: string;
  author: string;
  category: string;
  votes: number;
  answers: {
    id: string;
    author: string;
    text: string;
    timestamp: string;
  }[];
  timestamp: string;
}

export interface NotificationItem {
  id: string;
  text: string;
  type: 'like' | 'comment' | 'post' | 'earning' | 'system';
  timestamp: string;
  read: boolean;
}

export interface UserStats {
  name: string;
  avatar: string;
  balance: number; // In Taka
  points: number;
  rank: string;
  postsPublished: number;
  postsPending: number;
  referralCode?: string;
  referredBy?: string;
  referredUsers?: string[]; // Array of names referred by this user
  referralEarnings?: number; // Taka earned from referrals
}

export interface AdminSettings {
  revenueSharePercent: number; // e.g., 10%, 50%
  payoutPerView: number; // e.g., 0.10 Taka
  payoutPerLike: number; // e.g., 0.50 Taka
  payoutPerPublish: number; // e.g., 5.00 Taka
  autoAIPosting: boolean;
  rgbEffectSpeed: 'slow' | 'medium' | 'fast';
  enableInteractiveNotice: boolean;
  googleAdSenseStatus: 'active' | 'pending' | 'restricted';
  enableRgbEffects: boolean;
  enableGoogleAds: boolean;
  advertisementSnippet: string;
  mayaApiKeys: string;
  mayaSystemInstruction: string;
  mayaTemperature: number;
  autopilotInterval: string;
  autopilotCategories: string;
  autopilotKeywords: string;
  referralBonusTaka?: number;  // Bonus Taka for referrer (e.g. 10 TK)
  referralXpReward?: number;   // XP points for both referrer and referee (e.g. 50 XP)
  refereeBonusTaka?: number;   // Bonus Taka for registered user (referee)
  refereeXpReward?: number;    // XP points for registered user (referee)
}
