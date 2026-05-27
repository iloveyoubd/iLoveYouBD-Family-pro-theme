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
}
