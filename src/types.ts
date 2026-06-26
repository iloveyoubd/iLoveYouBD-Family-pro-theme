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
  rgbStyle?: string;
  glowSinglePost?: boolean;
  glowSinglePostColor?: string;
  glowComments?: boolean;
  glowCommentsColor?: string;
  glowUserProfile?: boolean;
  glowUserProfileColor?: string;
  glowChatbot?: boolean;
  glowChatbotColor?: string;
  glowQa?: boolean;
  glowQaColor?: string;
  glowStories?: boolean;
  glowStoriesColor?: string;
  glowWallet?: boolean;
  glowWalletColor?: string;
  glowSearchIndex?: boolean;
  glowSearchIndexColor?: string;
  defaultThemePreset?: 'cyber_dark' | 'emerald_glow' | 'light_clean' | 'electric_sunset_dark' | 'classic_midnight';
  allowUserCustomizer?: 'yes_logged_in' | 'yes_everyone' | 'no_admin_only';
  respectDeviceDefaultTheme?: boolean;
  enableAdSenseSafeMode?: boolean;
  enableRgbLoopShift?: boolean;
  enableFooterRgb?: boolean;
  enableGoogleAds: boolean;
  enableStories?: boolean;
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

export interface LedgerEntry {
  id: string;
  username: string;
  amount: number; // Added or deducted value
  currency: "BDT" | "XP";
  reason: string; // "আর্টিকেল লিখে বোনাস", "রেফারেল সাকসেসফুল", etc.
  linkId?: string; // post ID or element details
  linkType?: "post" | "comment" | "referral" | "forum" | "admin" | "other";
  timestamp: string; // ISO standard/human timestamp
}

export interface StoryItem {
  id: string;
  username: string;
  userAvatar: string;
  mediaType: "image" | "text";
  mediaUrl?: string;
  textContent?: string;
  timestamp: string;
  viewsCount: number;
  likesCount: number;
  caption?: string;
}

