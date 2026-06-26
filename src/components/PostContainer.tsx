import React, { useState } from "react";
import { motion, AnimatePresence } from "motion/react";
import { ThumbsUp, Eye, MessageSquare, Send, Award, Clock, Heart, CornerDownRight } from "lucide-react";
import type { Post } from "../types";

export interface PostContainerProps {
  key?: string;
  post: Post;
  onLike: (postId: string) => void;
  onComment: (postId: string, text: string) => void;
  onMessageAuthor?: (authorName: string) => void;
}

export default function PostContainer({ post, onLike, onComment, onMessageAuthor }: PostContainerProps) {
  const [showComments, setShowComments] = useState(false);
  const [commentText, setCommentText] = useState("");
  const [isLiked, setIsLiked] = useState(false);

  const handlePostComment = (e: React.FormEvent) => {
    e.preventDefault();
    if (!commentText.trim()) return;
    onComment(post.id, commentText);
    setCommentText("");
  };

  const handleLikeClick = () => {
    setIsLiked(true);
    onLike(post.id);
    setTimeout(() => setIsLiked(false), 500); // Pulse effect state reset
  };

  return (
    <motion.article
      id={`post-card-${post.id}`}
      initial={{ opacity: 0, y: 25 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      transition={{ duration: 0.5, ease: "easeOut" }}
      whileHover={{ y: -6 }}
      className="bg-slate-950/70 border border-cyan-950/60 hover:border-cyan-400/50 rounded-2xl overflow-hidden shadow-2xl relative flex flex-col justify-between group transition-colors duration-300 backdrop-blur-md"
      style={{
        boxShadow: "inset 0 1px 1px 0 rgba(255, 255, 255, 0.05), 0 10px 30px -10px rgba(0, 0, 0, 0.7)"
      }}
    >
      {/* Decorative Neon Top Accent Line */}
      <div className="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-cyan-500 via-indigo-500 to-purple-500 opacity-70 group-hover:opacity-100 transition-opacity" />

      {/* Visual Thumbnail Segment */}
      <div className="relative aspect-[16/10] w-full overflow-hidden bg-slate-950/90 select-none">
        <img
          src={post.thumbnail}
          alt={post.title}
          className="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
          referrerPolicy="no-referrer"
        />
        
        {/* Neon Gradient Mask Overlay */}
        <div className="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent opacity-80" />

        {/* Floating Category and Featured Badges */}
        <div className="absolute top-4 left-4 flex flex-wrap gap-2">
          <span className="text-[10px] uppercase font-mono tracking-wider font-extrabold bg-[#0d1527]/90 text-cyan-400 border border-cyan-500/40 rounded-lg px-2.5 py-1 backdrop-blur-md shadow-lg">
            ⚡ {post.category}
          </span>
          {post.isFeatured && (
            <motion.span 
              animate={{ opacity: [1, 0.6, 1] }}
              transition={{ repeat: Infinity, duration: 2, ease: "easeInOut" }}
              className="text-[10px] uppercase font-mono tracking-wider font-extrabold bg-purple-950/90 text-purple-300 border border-purple-500/40 rounded-lg px-2.5 py-1 backdrop-blur-md shadow-lg"
            >
              ★ FEATURED
            </motion.span>
          )}
        </div>
      </div>

      {/* Contents and Metadata Segment */}
      <div className="p-5 flex-1 flex flex-col justify-between text-left">
        <div>
          {/* Elite Author Bio Section */}
          <div 
            onClick={() => onMessageAuthor && onMessageAuthor(post.author.name)}
            className={`flex items-center gap-3 mb-4 p-2 rounded-xl bg-cyan-950/10 border border-cyan-950/30 group-hover:bg-cyan-950/20 group-hover:border-cyan-500/20 transition-all duration-350 ${
              onMessageAuthor ? "cursor-pointer" : ""
            }`}
            title={onMessageAuthor ? "মেসেজ পাঠাতে অথবা প্রোফাইল দেখতে ক্লিক করুন" : undefined}
          >
            <div className="relative">
              <img
                src={post.author.avatar || `https://api.dicebear.com/7.x/bottts/svg?seed=${post.author.name}`}
                alt={post.author.name}
                className="w-9 h-9 rounded-full border-2 border-cyan-500/40 object-cover bg-slate-900"
              />
              <span className="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 border-2 border-slate-950 rounded-full animate-pulse" />
            </div>
            
            <div className="flex-1 min-w-0">
              <div className="text-xs font-bold text-slate-100 flex items-center gap-1.5">
                <span className="truncate group-hover:text-cyan-400 transition-colors">{post.author.name}</span>
                {post.author.isAI && (
                  <span className="bg-cyan-950 text-cyan-400 text-[8px] font-mono border border-cyan-500/30 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">AI</span>
                )}
              </div>
              <div className="text-[9px] text-[#bd00ff] font-mono leading-none mt-1 flex items-center gap-1 font-bold tracking-widest uppercase">
                <Award className="w-3 h-3 text-[#bd00ff]" />
                <span>{post.author.rank || "MEMBER"}</span>
              </div>
            </div>
          </div>

          {/* Title and Excerpt */}
          <h3 className="text-base font-bold tracking-tight text-white line-clamp-2 hover:text-cyan-400 leading-snug transition-colors duration-250 cursor-pointer">
            {post.title}
          </h3>
          <p className="text-xs text-slate-400 line-clamp-2 leading-relaxed mt-2 pl-0.5 border-l-2 border-cyan-950 group-hover:border-cyan-500/30 transition-colors">
            {post.excerpt}
          </p>
        </div>

        {/* Dynamic Action Metrics Toolbar */}
        <div className="mt-6 pt-4 border-t border-cyan-950/50 flex justify-between items-center text-xs font-mono select-none">
          <div className="flex items-center gap-4">
            {/* Dynamic Like Button */}
            <motion.button
              whileTap={{ scale: 0.85 }}
              onClick={handleLikeClick}
              className={`flex items-center gap-1.5 group/btn font-bold transition-all ${
                isLiked ? "text-pink-500" : "text-slate-400 hover:text-emerald-400"
              }`}
            >
              <Heart 
                className={`w-4 h-4 transition-transform ${
                  isLiked ? "fill-pink-500 stroke-pink-500 scale-125" : "text-emerald-500 group-hover/btn:scale-110"
                }`} 
              /> 
              <span className="text-[11px]">{post.likes}</span>
            </motion.button>

            {/* Views counter */}
            <span className="flex items-center gap-1.5 text-slate-400 group-hover:text-cyan-400 transition-colors">
              <Eye className="w-4 h-4 text-cyan-400" /> 
              <span className="text-[11px]">{post.views}</span>
            </span>

            {/* Comments Toggle */}
            <button
              onClick={() => setShowComments(!showComments)}
              className={`flex items-center gap-1.5 font-bold transition-all ${
                showComments ? "text-purple-400" : "text-slate-400 hover:text-purple-400"
              }`}
            >
              <MessageSquare className="w-4 h-4 text-purple-400 group-hover:scale-110 transition-transform" /> 
              <span className="text-[11px]">{post.comments.length}</span>
            </button>
          </div>

          {/* Read time */}
          <div className="flex items-center gap-1.5 text-[10px] text-slate-500 font-extrabold uppercase">
            <Clock className="w-3.5 h-3.5 text-slate-650" /> 
            <span>{post.readTime || "৩ মিনিট"}</span>
          </div>
        </div>
      </div>

      {/* Holographic Comments Drawer Component */}
      <AnimatePresence>
        {showComments && (
          <motion.div 
            initial={{ height: 0, opacity: 0 }}
            animate={{ height: "auto", opacity: 1 }}
            exit={{ height: 0, opacity: 0 }}
            transition={{ duration: 0.3 }}
            className="border-t border-cyan-950/80 bg-slate-950/95 overflow-hidden rounded-b-2xl"
          >
            <div className="p-4 text-left space-y-4">
              <div className="text-[10px] font-mono uppercase tracking-wider text-purple-400 font-bold flex items-center gap-1">
                <CornerDownRight className="w-3.5 h-3.5" />
                <span>মন্তব্যসমূহ ({post.comments.length})</span>
              </div>
              
              {/* Scrollable comment entries */}
              <div className="space-y-2.5 max-h-[160px] overflow-y-auto pr-1 flex flex-col gap-1.5 custom-scrollbar">
                {post.comments.length === 0 ? (
                  <div className="text-[10px] text-slate-500 italic font-mono pl-3 py-3 border border-slate-900 border-dashed rounded-lg bg-slate-950/40">
                    প্রথম মন্তব্যকারী হয়ে ৫ পয়েন্ট বোনাস নিন! 💬
                  </div>
                ) : (
                  post.comments.map((c) => (
                    <div key={c.id} className="bg-slate-900/40 p-2.5 rounded-xl border border-cyan-900/10 text-[11px] leading-relaxed relative hover:border-cyan-500/15 transition-all">
                      <div className="flex items-center gap-2 mb-1.5">
                        <img
                          src={c.authorAvatar || `https://api.dicebear.com/7.x/pixel-art/svg?seed=${c.authorName}`}
                          alt={c.authorName}
                          className="w-4 h-4 rounded-full border border-slate-700 bg-slate-950"
                        />
                        <span className="font-extrabold text-[#00f0ff]">{c.authorName}</span>
                        <span className="text-[8px] text-slate-500 ml-auto font-mono">{c.timestamp}</span>
                      </div>
                      <p className="text-slate-350 font-sans pl-1">{c.text}</p>
                    </div>
                  ))
                )}
              </div>

              {/* Comment submission form */}
              <form onSubmit={handlePostComment} className="flex gap-2 pt-2 border-t border-cyan-950/20">
                <input
                  type="text"
                  value={commentText}
                  onChange={(e) => setCommentText(e.target.value)}
                  placeholder="একটি গঠনমূলক বা সাইবার সিকিউরিটি রিসার্চ ভিত্তিক মন্তব্য লিখুন..."
                  className="flex-1 bg-slate-950/90 border border-cyan-950/80 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-cyan-400/60 font-sans transition-all shadow-inner"
                />
                <button
                  type="submit"
                  className="bg-cyan-500 hover:bg-cyan-400 text-slate-950 px-3.5 rounded-xl transition-all flex items-center justify-center shadow-lg active:scale-95"
                >
                  <Send className="w-3.5 h-3.5" />
                </button>
              </form>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </motion.article>
  );
}
