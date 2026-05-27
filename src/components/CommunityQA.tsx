import React, { useState } from "react";
import { MessageSquare, Plus, Send, Search, CheckCircle, HelpCircle, Award } from "lucide-react";
import type { Question } from "../types";

interface CommunityQAProps {
  questions: Question[];
  onAddQuestion: (title: string, category: string) => void;
  onAddAnswer: (questionId: string, answerText: string) => void;
  activeQuestionId?: string | null;
  setActiveQuestionId?: (id: string | null) => void;
}

export default function CommunityQA({ 
  questions, 
  onAddQuestion, 
  onAddAnswer,
  activeQuestionId: externalActiveId,
  setActiveQuestionId: setExternalActiveId
}: CommunityQAProps) {
  const [searchTerm, setSearchTerm] = useState("");
  const [showAddForm, setShowAddForm] = useState(false);
  const [newTitle, setNewTitle] = useState("");
  const [newCategory, setNewCategory] = useState("Cybersecurity");
  const [newAnswers, setNewAnswers] = useState<{ [qId: string]: string }>({});
  const [localActiveQuestionId, setLocalActiveQuestionId] = useState<string | null>(null);

  const activeQuestionId = externalActiveId !== undefined ? externalActiveId : localActiveQuestionId;
  const setActiveQuestionId = setExternalActiveId !== undefined ? setExternalActiveId : setLocalActiveQuestionId;

  const categories = [
    "Cybersecurity",
    "AdSense Approval",
    "SEO & Web-Indexing",
    "Ethical Hacking",
    "Earning Systems",
    "AI Tech"
  ];

  const handleCreateQuestion = (e: React.FormEvent) => {
    e.preventDefault();
    if (!newTitle.trim()) return;
    onAddQuestion(newTitle, newCategory);
    setNewTitle("");
    setShowAddForm(false);
  };

  const handlePostAnswer = (qId: string) => {
    const text = newAnswers[qId];
    if (!text || !text.trim()) return;
    onAddAnswer(qId, text);
    setNewAnswers((prev) => ({ ...prev, [qId]: "" }));
  };

  const filteredQuestions = questions.filter(
    (q) =>
      q.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
      q.category.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div className="bg-[#090d16] border border-cyan-900/40 rounded-xl p-6 shadow-2xl relative overflow-hidden">
      {/* Background cyber grid lines decoration */}
      <div className="absolute inset-0 bg-[radial-gradient(#14243b_1px,transparent_1px)] [background-size:16px_16px] opacity-10 pointer-events-none" />

      <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 relative z-10">
        <div>
          <h2 id="qa-forum-title" className="text-xl font-bold font-sans tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-emerald-400 flex items-center gap-2">
            <HelpCircle className="w-5 h-5 text-cyan-400 animate-pulse" />
            কমিউনিটি Q&A ফোরাম (Community Discussion)
          </h2>
          <p className="text-xs text-slate-400 mt-1 font-mono">
            প্রশ্ন করুন, সঠিক উত্তর দিয়ে ব্যালেন্স ও সাইট পয়েন্ট বৃদ্ধি করুন
          </p>
        </div>

        <button
          id="btn-ask-question"
          onClick={() => setShowAddForm(!showAddForm)}
          className="flex items-center gap-2 text-xs font-mono font-semibold uppercase bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-400 hover:to-emerald-400 text-[#070b12] py-2 px-4 rounded shadow-[0_0_15px_rgba(0,240,255,0.3)] transition-all cursor-pointer"
        >
          <Plus className="w-4 h-4" /> নতুন প্রশ্ন করুন
        </button>
      </div>

      {/* Add Question Expandable Form */}
      {showAddForm && (
        <form onSubmit={handleCreateQuestion} className="mb-6 p-4 border border-cyan-500/30 rounded-lg bg-[#0e1624] relative z-10">
          <h3 className="text-sm font-semibold text-cyan-300 mb-3 flex items-center gap-2">
            নতুন ফোরাম প্রশ্ন এড করুন
          </h3>
          <div className="space-y-3">
            <div>
              <label className="block text-xs text-slate-400 mb-1 font-mono">আপনার টেকনিক্যাল প্রশ্ন লিখুন (যেমন: গুগল ইন্ডেক্স স্পিড কীভাবে বাড়াবো?):</label>
              <input
                type="text"
                value={newTitle}
                onChange={(e) => setNewTitle(e.target.value)}
                placeholder="প্রশ্নটি পরিষ্কার করে লিখুন..."
                className="w-full text-sm bg-[#090d16] border border-cyan-800 focus:border-cyan-400 focus:outline-none rounded p-2 text-slate-100 placeholder-slate-600 font-sans"
              />
            </div>
            <div>
              <label className="block text-xs text-slate-400 mb-1 font-mono">ক্যাটাগরি নির্বাচন করুন:</label>
              <div className="flex flex-wrap gap-2">
                {categories.map((cat) => (
                  <button
                    key={cat}
                    type="button"
                    onClick={() => setNewCategory(cat)}
                    className={`text-xs px-3 py-1.5 rounded transition-all font-mono border ${
                      newCategory === cat
                        ? "bg-cyan-950/80 border-cyan-400 text-cyan-300 shadow-[0_0_8px_rgba(0,240,255,0.2)]"
                        : "bg-[#090d16] border-slate-800 text-slate-400 hover:border-cyan-800"
                    }`}
                  >
                    {cat}
                  </button>
                ))}
              </div>
            </div>
            <div className="flex justify-end gap-2 pt-2">
              <button
                type="button"
                onClick={() => setShowAddForm(false)}
                className="text-xs font-mono text-slate-400 hover:text-slate-100 px-3 py-1.5"
              >
                বাতিল করুন
              </button>
              <button
                type="submit"
                className="bg-cyan-500 hover:bg-cyan-400 text-[#070b12] text-xs font-bold font-mono px-4 py-1.5 rounded"
              >
                প্রকাশ করুন
              </button>
            </div>
          </div>
        </form>
      )}

      {/* Search Bar */}
      <div className="relative mb-6 z-10">
        <span className="absolute left-3 top-1/2 -translate-y-1/2 text-cyan-500/60">
          <Search className="w-4 h-4" />
        </span>
        <input
          id="forum-search-box"
          type="text"
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
          placeholder="ফোরাম কোশ্চেন বা টপিক সার্চ করুন..."
          className="w-full text-xs font-mono pl-10 pr-4 py-2.5 bg-[#0b111d] border border-cyan-950 rounded-lg text-slate-200 placeholder-cyan-900 focus:outline-none focus:border-cyan-500/50 shadow-inner"
        />
      </div>

      {/* Questions Stack */}
      <div className="space-y-4 relative z-10 max-h-[480px] overflow-y-auto pr-2 custom-scrollbar">
        {filteredQuestions.length === 0 ? (
          <div className="text-center py-8 border border-dashed border-slate-800 rounded-lg text-slate-500 text-sm font-mono">
            কোনো কোশ্চেন পাওয়া যায়নি। নতুন একটি প্রশ্ন করুন!
          </div>
        ) : (
          filteredQuestions.map((q) => (
            <div
              key={q.id}
              className={`border rounded-lg p-4 transition-all duration-300 ${
                activeQuestionId === q.id
                  ? "bg-[#0e1625] border-cyan-500/50 shadow-[0_0_15px_rgba(0,240,255,0.1)]"
                  : "bg-[#0b111e]/90 border-cyan-950 hover:border-cyan-800/60 hover:bg-[#0c1421]"
              }`}
            >
              <div className="flex items-start justify-between gap-3">
                <div className="cursor-pointer flex-1" onClick={() => setActiveQuestionId(activeQuestionId === q.id ? null : q.id)}>
                  <span className="inline-block text-[10px] font-mono font-semibold tracking-wider text-cyan-400 uppercase bg-cyan-950/80 px-2 py-0.5 rounded border border-cyan-900/40 mb-2">
                    {q.category}
                  </span>
                  <h4 className="text-sm font-semibold text-slate-200 hover:text-cyan-300 transition-colors">
                    {q.title}
                  </h4>
                  <div className="flex items-center gap-4 mt-2 text-[11px] text-slate-500 font-mono">
                    <span>কর্তা: <span className="text-slate-300">{q.author}</span></span>
                    <span>•</span>
                    <span className="flex items-center gap-1">
                      <MessageSquare className="w-3.5 h-3.5 text-cyan-500" /> {q.answers.length} টি উত্তর
                    </span>
                  </div>
                </div>

                <div className="text-right">
                  <div className="text-[10px] text-slate-400 font-mono">{q.timestamp}</div>
                </div>
              </div>

              {/* Answers Expandable Drawer */}
              {activeQuestionId === q.id && (
                <div className="mt-4 pt-4 border-t border-cyan-950/60 space-y-3">
                  <div className="text-xs font-mono text-cyan-400 font-bold mb-2">উত্তরসমূহ:</div>
                  
                  {q.answers.length === 0 ? (
                    <div className="text-[11px] text-slate-500 font-mono italic pl-2 py-1">
                      এখনো কোনো উত্তর দেওয়া হয়নি। প্রথম উত্তরদাতা হিসেবে রিওয়ার্ড পান!
                    </div>
                  ) : (
                    <div className="space-y-2.5">
                      {q.answers.map((ans) => (
                        <div key={ans.id} className="bg-[#090d16] p-3 rounded border border-slate-900 text-xs">
                          <div className="flex justify-between items-center mb-1 text-[10px] text-slate-400 font-mono">
                            <span className="text-emerald-400 font-semibold flex items-center gap-1">
                              <Award className="w-3 h-3 text-emerald-400" /> {ans.author}
                            </span>
                            <span>{ans.timestamp}</span>
                          </div>
                          <p className="text-slate-300 leading-relaxed font-sans">{ans.text}</p>
                        </div>
                      ))}
                    </div>
                  )}

                  {/* Submit an Answer */}
                  <div className="flex gap-2 mt-4 pt-2">
                    <input
                      type="text"
                      value={newAnswers[q.id] || ""}
                      onChange={(e) =>
                        setNewAnswers((prev) => ({ ...prev, [q.id]: e.target.value }))
                      }
                      placeholder="এই প্রশ্নের উত্তর প্রদান করুন..."
                      className="flex-1 bg-[#090d16] border border-cyan-950 rounded p-2 text-xs focus:outline-none focus:border-cyan-500 font-sans text-slate-200"
                    />
                    <button
                      id={`btn-post-answer-${q.id}`}
                      onClick={() => handlePostAnswer(q.id)}
                      className="bg-cyan-500/80 hover:bg-cyan-400 text-[#070b12] font-semibold text-xs px-3.5 py-1.5 rounded flex items-center gap-1 font-mono transition-colors"
                    >
                      <Send className="w-3 h-3" /> পোস্ট
                    </button>
                  </div>
                </div>
              )}
            </div>
          ))
        )}
      </div>
    </div>
  );
}
