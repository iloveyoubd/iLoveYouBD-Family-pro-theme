import React, { useState } from "react";
import { ThumbsUp, Eye, MessageSquare, Send, Award, Clock } from "lucide-react";
import type { Post } from "../types";

export interface PostContainerProps {
  key?: string;
  post: Post;
  onLike: (postId: string) => void;
  onComment: (postId: string, text: string) => void;
}

export default function PostContainer({ post, onLike, onComment }: PostContainerProps) {
  const [showComments, setShowComments] = useState(false);
  const [commentText, setCommentText] = useState("");

  const handlePostComment = (e: React.FormEvent) => {
    e.preventDefault();
    if (!commentText.trim()) return;
    onComment(post.id, commentText);
    setCommentText("");
  };

  return (
    <article
      id={`post-card-${post.id}`}
      className="bg-[#090d16]/90 border border-cyan-950 hover:border-cyan-400/50 rounded-xl overflow-hidden shadow-xl hover:shadow-[0_0_20px_rgba(0,240,255,0.08)] transition-all duration-300 flex flex-col justify-between"
    >
      {/* Absolute category tag badge */}
      <div className="relative aspect-[16/9] w-full overflow-hidden bg-slate-950/80">
        <img
          src={post.thumbnail}
          alt={post.title}
          className="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
          referrerPolicy="no-referrer"
        />
        <div className="absolute top-3 left-3 flex gap-1.5">
          <span className="text-[9px] uppercase font-mono tracking-wider font-bold bg-[#070b13]/85 text-[#00f0ff] border border-cyan-800 rounded px-2.5 py-1 backdrop-blur-md">
            {post.category}
          </span>
          {post.isFeatured && (
            <span className="text-[9px] uppercase font-mono tracking-wider font-bold bg-amber-950/85 text-yellow-400 border border-yellow-800 rounded px-2.5 py-1 backdrop-blur-md animate-pulse">
              FEATURED
            </span>
          )}
        </div>
        
        <div className="absolute bottom-0 inset-x-0 h-10 bg-gradient-to-t from-[#090d16] to-transparent" />
      </div>

      <div className="p-4 flex-1 flex flex-col justify-between text-left">
        <div>
          {/* Author line with round avatar, name & badge */}
          <div className="flex items-center gap-2.5 mb-3">
            <img
              src={post.author.avatar}
              alt={post.author.name}
              className="w-7 h-7 rounded-full border border-cyan-600/30 object-cover"
            />
            <div>
              <div className="text-[11px] font-bold text-slate-100 flex items-center gap-1">
                <span>{post.author.name}</span>
                {post.author.isAI && (
                  <span className="bg-cyan-950 text-cyan-400 text-[8px] border border-cyan-800 px-1 rounded-sm scale-90">AI</span>
                )}
              </div>
              <div className="text-[9px] text-[#00f0ff] font-mono leading-none mt-0.5 flex items-center gap-1 uppercase">
                <Award className="w-2.5 h-2.5" />
                <span>{post.author.rank}</span>
              </div>
            </div>
          </div>

          <h3 className="text-sm font-semibold tracking-tight text-slate-100 line-clamp-2 hover:text-[#00f0ff] transition-colors leading-snug">
            {post.title}
          </h3>
          <p className="text-xs text-slate-400 line-clamp-2 leading-relaxed mt-1.5">
            {post.excerpt}
          </p>
        </div>

        {/* Dynamic bottom counters / like comments views */}
        <div className="mt-4 pt-3 border-t border-cyan-950 flex justify-between items-center text-[11px] font-mono text-slate-400">
          <div className="flex items-center gap-3">
            <button
              onClick={() => onLike(post.id)}
              className="flex items-center gap-1 text-slate-400 hover:text-emerald-400 font-bold transition-all hover:scale-105"
            >
              <ThumbsUp className="w-3.5 h-3.5 text-emerald-500" /> {post.likes}
            </button>
            <span className="flex items-center gap-1">
              <Eye className="w-3.5 h-3.5 text-cyan-500" /> {post.views}
            </span>
            <button
              onClick={() => setShowComments(!showComments)}
              className="flex items-center gap-1 hover:text-cyan-400 transition-all font-semibold"
            >
              <MessageSquare className="w-3.5 h-3.5 text-cyan-500" /> {post.comments.length}
            </button>
          </div>

          <div className="flex items-center gap-1 text-[10px] text-slate-500">
            <Clock className="w-3 h-3 text-slate-500" /> {post.readTime}
          </div>
        </div>
      </div>

      {/* Expandable comments component drawer */}
      {showComments && (
        <div className="border-t border-cyan-950 bg-[#070b13]/80 p-3 text-left">
          <div className="text-[10px] font-mono uppercase tracking-wider text-cyan-400 mb-2">মন্তব্যসমূহ ({post.comments.length}):</div>
          
          <div className="space-y-2 max-h-[140px] overflow-y-auto pr-1.5 custom-scrollbar mb-3">
            {post.comments.length === 0 ? (
              <div className="text-[10px] text-slate-500 italic font-mono pl-1 py-1">
                প্রথম মন্তব্যকারী হয়ে ৫ পয়েন্ট বোনাস নিন!
              </div>
            ) : (
              post.comments.map((c) => (
                <div key={c.id} className="bg-[#090d16] p-2 rounded border border-cyan-950/40 text-[11px]">
                  <div className="flex items-center gap-1.5 mb-1">
                    <img
                      src={c.authorAvatar}
                      alt={c.authorName}
                      className="w-4 h-4 rounded-full border border-slate-700"
                    />
                    <span className="font-bold text-[#00f0ff]">{c.authorName}</span>
                    <span className="text-[8px] text-slate-500 ml-auto">{c.timestamp}</span>
                  </div>
                  <p className="text-slate-300 font-sans tracking-wide leading-tight">{c.text}</p>
                </div>
              ))
            )}
          </div>

          <form onSubmit={handlePostComment} className="flex gap-1.5 mt-2">
            <input
              type="text"
              value={commentText}
              onChange={(e) => setCommentText(e.target.value)}
              placeholder="একটি অর্থপূর্ণ মন্তব্য লিখুন..."
              className="flex-1 bg-[#050911] border border-cyan-950 rounded p-1.5 text-xs text-slate-200 focus:outline-none focus:border-cyan-400"
            />
            <button
              type="submit"
              className="bg-cyan-500/80 hover:bg-cyan-400 text-[#070b13] p-1.5 rounded transition-colors"
            >
              <Send className="w-3.5 h-3.5" />
            </button>
          </form>
        </div>
      )}
    </article>
  );
}
