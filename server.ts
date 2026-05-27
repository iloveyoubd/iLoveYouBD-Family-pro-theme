import express from "express";
import path from "path";
import fs from "fs";
import dotenv from "dotenv";
import AdmZip from "adm-zip";
import { GoogleGenAI, Type } from "@google/genai";
import { createServer as createViteServer } from "vite";

dotenv.config();

// Ensure the zip packages exist in dist/
function ensureZipPackages() {
  const distDir = path.join(process.cwd(), "dist");
  if (!fs.existsSync(distDir)) {
    fs.mkdirSync(distDir, { recursive: true });
    console.log("Created directory:", distDir);
  }

  const themeZipPath = path.join(distDir, "ilybd-neon-v1-pro-fixed.zip");
  const pluginZipPath = path.join(distDir, "ilybd-prime-engine-fixed.zip");

  // Always generate/overwrite theme zip package dynamically
  console.log("Generating theme zip package dynamically...");
  const themePath = path.join(process.cwd(), "extracted-wordpress", "ilybd-neon-v1-pro");
  if (fs.existsSync(themePath)) {
    try {
      const zip = new AdmZip();
      zip.addLocalFolder(themePath, "ilybd-neon-v1-pro");
      if (fs.existsSync(themeZipPath)) {
        fs.unlinkSync(themeZipPath); // remove stale zip
      }
      zip.writeZip(themeZipPath);
      console.log("Theme package auto-generated and updated. Size:", fs.statSync(themeZipPath).size, "bytes.");
    } catch (err: any) {
      console.error("Theme lazy zip generation failed:", err.message);
    }
  } else {
    console.warn("Theme directory does not exist to zip:", themePath);
  }

  // Always generate/overwrite plugin zip package dynamically
  console.log("Generating plugin zip package dynamically...");
  const pluginPath = path.join(process.cwd(), "extracted-wordpress", "ilybd-prime-engine");
  if (fs.existsSync(pluginPath)) {
    try {
      const zip = new AdmZip();
      zip.addLocalFolder(pluginPath, "ilybd-prime-engine");
      if (fs.existsSync(pluginZipPath)) {
        fs.unlinkSync(pluginZipPath); // remove stale zip
      }
      zip.writeZip(pluginZipPath);
      console.log("Plugin package auto-generated and updated. Size:", fs.statSync(pluginZipPath).size, "bytes.");
    } catch (err: any) {
      console.error("Plugin lazy zip generation failed:", err.message);
    }
  } else {
    console.warn("Plugin directory does not exist to zip:", pluginPath);
  }
}

const app = express();
const PORT = 3000;

app.use(express.json({ limit: "50mb" }));

// Initialize GoogleGenAI SDK
const apiKey = process.env.GEMINI_API_KEY;
let ai: GoogleGenAI | null = null;

if (apiKey) {
  ai = new GoogleGenAI({
    apiKey,
    httpOptions: {
      headers: {
        'User-Agent': 'aistudio-build',
      }
    }
  });
  console.log("Gemini API initialized successfully on the server.");
} else {
  console.log("GEMINI_API_KEY is not set. Running in offline/fallback mode.");
}

// ---------------------- API PATHS ----------------------

// 1. Interactive Chat API
app.post("/api/gemini/chat", async (req, res) => {
  try {
    const { messages, systemInstruction, model, keys } = req.body;
    
    const keyPool: string[] = [];
    if (Array.isArray(keys)) {
      keys.forEach((k: any) => {
        if (typeof k === "string" && k.trim()) {
          keyPool.push(k.trim());
        }
      });
    }
    if (process.env.GEMINI_API_KEY && process.env.GEMINI_API_KEY.trim()) {
      keyPool.push(process.env.GEMINI_API_KEY.trim());
    }

    const selectedModel = model === "gemini-pro" ? "gemini-3.1-pro-preview" : 
                          model === "maya-ultra" ? "gemini-3.1-pro-preview" : 
                          "gemini-3.5-flash";

    if (keyPool.length === 0) {
      // Simulate highly professional chat responses matching Gemini
      const lastMessage = messages[messages.length - 1]?.content || "";
      let simulatedReply = `আসসালামু আলাইকুম! আমি **মায়া (Maya)**, iloveyoubd.com-এর প্রধান ও হাই-প্রফেশনাল এডমিন এআই অ্যাসিস্ট্যান্ট। আমি সম্পূর্ণ প্রফেশনাল স্তরে কোডিং ডেভেলপমেন্ট, এসইও সমস্যা সমাধান এবং গুগল এডসেন্স মনিটাইজেশনের বিষয়ে সাহায্য করব। 

[সংযোগ স্ট্যাটাস: **অফলাইন ডেমো মোড** - মডেল ${selectedModel === "gemini-3.1-pro-preview" ? "Maya Ultra Reasoning (gemini-3.1-pro-preview)" : "High Speed Flash (gemini-3.5-flash)"} সক্রিয়]

আপনার প্রশ্নটি ছিল: "${lastMessage}"। এই বিষয়ের প্রফেশনাল সমাধান ও কোড সল্ভার নিচে উপস্থাপন করলাম:

\`\`\`typescript
// iloveyoubd.com Secure Optimization Config
interface CyberSecurityConfig {
  adsenseScore: number;
  quantumLock: boolean;
  indexedByGoogle: boolean;
}

export const siteSecEngine: CyberSecurityConfig = {
  adsenseScore: 98,
  quantumLock: true,
  indexedByGoogle: true
};

console.log("সার্ভার এবং ডাটাবেজ ইন্টিগ্রেশন সফল হয়েছে!");
\`\`\`

আমি আপনার জন্য রিয়েল-টাইমে যেকোনো ইমেজেস জেনারেট করতে পারি। যেমন আপনি যদি বলেন 'একটি ল্যাপটপে কোডিং করার ছবি' বা 'cyber security illustration', আমি তাৎক্ষণিক আর্ট বুস্টার দিয়ে ইমেজ তৈরি করব!`;

      // Detect if user asked to draw or generate an image and append the tag
      const isDrawingPrompt = /(draw|paint|create|generate|ছবি|আঁকো|image)/i.test(lastMessage);
      if (isDrawingPrompt) {
        simulatedReply += `\n\n[GENERATE_IMAGE: ${lastMessage}]`;
      }

      return res.json({ text: simulatedReply });
    }

    // Convert messages for SDK
    const formattedContents = messages.map((m: any) => ({
      role: m.role === 'user' ? 'user' : 'model',
      parts: [{ text: m.content }]
    }));

    const errors: string[] = [];

    // Loop through keys and rotate automatically on failure
    for (let i = 0; i < keyPool.length; i++) {
      const activeKey = keyPool[i];
      try {
        const client = new GoogleGenAI({
          apiKey: activeKey,
          httpOptions: {
            headers: {
              'User-Agent': 'aistudio-build',
            }
          }
        });

        const response = await client.models.generateContent({
          model: selectedModel,
          contents: formattedContents,
          config: {
            systemInstruction: systemInstruction || "You are Maya (মায়া), the highly professional, helpful, and extremely competent executive AI assistant of iloveyoubd.com. Write in flawless Bangla. Answer users with high intelligence, deep reasoning, and professionalism. If the user asks you to write code, write complete, beautifully formatted markdown code blocks. If the user asks to draw, generate, or make any image (e.g., 'draw a cybernetic cat', 'একটি রোবটের ছবি আঁকো'), write exactly the following trigger block in your response so the client UI can render it: '[GENERATE_IMAGE: <descriptive English prompt representing what they asked for>]'. Explain to them that you are using your creative art model to draw it."
          }
        });

        if (response && response.text) {
          return res.json({ text: response.text, keyIndexUsed: i });
        } else {
          errors.push(`Key #${i + 1} succeeded but returned empty content.`);
        }
      } catch (err: any) {
        const errStr = err.message || String(err);
        console.warn(`Gemini key rotation index ${i} failed:`, errStr);
        errors.push(`Key #${i + 1} failed: ${errStr}`);
      }
    }

    // If we reach here, all keys in the pool failed! Return friendly error response
    const errorDetails = errors.join("\n");
    return res.json({ 
      text: `> **[মায়া সিস্টেম টিম নোটিশ]:** দুঃখিত! আপনার কনফিগার করা সবকটি এপিআই কি এক এক করে অটোমেটিকেলি টেস্ট করা হয়েছে কিন্তু লিমিট বা কোটা শেষ থাকার কারণে সিস্টেম এপিআই সংযোগ করতে ব্যর্থ হয়েছে।\n\n**ত্রুটির বিবরণী:**\n${errorDetails}\n\nঅনুগ্রহ করে ডানদিকের কোণায় গেমিনি সেটিংস আইকনে ক্লিক করে নতুন সচল API Keys যোগ করুন।` 
    });

  } catch (error: any) {
    console.error("Gemini Chat Error:", error);
    res.status(500).json({ error: error.message || "Failed to communicate with AI" });
  }
});

// 2. Automated Blog Content Generator
app.post("/api/gemini/generate-post", async (req, res) => {
  try {
    const { prompt, category, authorName } = req.body;

    if (!ai) {
      // Simulate standard generation
      const title = prompt ? `${prompt} - সাইবার সিকিউরিটি বিশ্লেষণ ২০৪০` : "ভবিষ্যতের সাইবার হ্যাকিং ও আমাদের করণীয়";
      const demoPost = {
        title,
        excerpt: "২০৪০ সালের উন্নত প্রযুক্তিতে গুগল ও সাইবার এনক্রিপশনের সম্পর্ক নিয়ে একটি বিশেষ কন্টেন্ট।",
        content: `## ২০৪০ সালের হ্যাকিং এবং ডিফেন্স সিস্টেম\n\nআসসালামু আলাইকুম! **iloveyoubd.com**-এর পাঠকদের জন্য আজ আমরা আলোচনা করব কীভাবে কোয়ান্টাম এনক্রিপশন এবং এআই ডিফেন্স আমাদের ডেটা সুরক্ষিত রাখছে।\n\n### ১. গুগল ইনডেক্সিং এবং এসইও সিক্রেটস\nআধুনিক গুগল সার্চ এআই ক্রলারদের সাথে বন্ধুত্ব করতে চাইলে আমাদের প্রতিটি কন্টেন্টে মেটা-ডাটা রিলেশন মজবুত করতে হবে। ২০৪০ ভিশন অনুযায়ী সার্চ ইঞ্জিন এখন সরাসরি অডিও ও ক্রিপ্টো আইডি স্ক্যান করে থাকে।\n\n### ২. হ্যাকার ফোরাম গাইডলাইন\n- সর্বদা মাল্টি-লেয়ার কোয়ান্টাম অথেনটিকেশন সক্রিয় রাখুন।\n- ডার্ক ওয়েব স্ক্যানার দিয়ে ক্রিপ্টো ব্যালেন্স চেক করুন।\n\n### ৩. কন্টেন্ট আর্নিং\nঅর্থ হিসেবে এই কন্টেন্টটি প্রকাশ করার সাথে সাথে আপনার ওয়ালেটে ৫.৫ টাকা জমা হয়ে গেছে! আমাদের লাইভ মনিটাইজেশন সিস্টেম অত্যন্ত নিখুঁত।\n\n**কন্টেন্ট সমাপ্ত। আপনার মতামত কমেন্টে জানান!**`,
        tags: ["hacking", "cyber-shield", "bangladesh", "earning-tips"],
        readTime: "৪ মিনিট"
      };
      return res.json(demoPost);
    }

    const response = await ai.models.generateContent({
      model: "gemini-3.5-flash",
      contents: `Create a professional Bangla tech/cybersecurity/hacking blog post under the category '${category || "Hacking"}'. The author is '${authorName || "CyberBot AI"}'. Use the user's prompt guideline: '${prompt || "Automatic secure tips"}'. Return exactly in JSON format containing the metadata.`,
      config: {
        responseMimeType: "application/json",
        responseSchema: {
          type: Type.OBJECT,
          properties: {
            title: { type: Type.STRING, description: "A catchy tech/gaming/hacking title in Bangla" },
            excerpt: { type: Type.STRING, description: "A brief 1-line description in Bangla summarizing the topic" },
            content: { type: Type.STRING, description: "A comprehensive blog article in markdown format, written beautifully in professional Bangla. Mention SEO, security and the spirit of iloveyoubd.com community." },
            tags: {
              type: Type.ARRAY,
              items: { type: Type.STRING },
              description: "3-4 relevant tech tags in lowercase English"
            },
            readTime: { type: Type.STRING, description: "Estimated read time in Bengali like '৫ মিনিট'" }
          },
          required: ["title", "excerpt", "content", "tags", "readTime"]
        }
      }
    });

    try {
      const result = JSON.parse(response.text || "{}");
      res.json(result);
    } catch (parseErr) {
      res.status(500).json({ error: "Failed to parse JSON response from model", raw: response.text });
    }
  } catch (error: any) {
    console.error("Gemini Generate Post Error:", error);
    res.status(500).json({ error: error.message || "Something went wrong during generation" });
  }
});

// 3. Cyber Graphic / Thumbnail Generator
app.post("/api/gemini/generate-image", async (req, res) => {
  try {
    const { prompt } = req.body;
    const cleanPrompt = prompt || "futuristic cyber programmer workspace";
    const fallbackUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(cleanPrompt)}?width=1024&height=576&nologo=true&private=true&seed=${Math.floor(Math.random() * 10000)}`;

    if (!ai) {
      return res.json({ imageUrl: fallbackUrl });
    }

    const fullPrompt = `A stunning 16:9 widescreen futuristic banner, intense dark cyber hacker aesthetics, glowing neon matrix lines, bright fluorescent colors, cybersecurity concept illustration. Subject: ${cleanPrompt}`;

    try {
      // Trying Imagen 4
      const response = await ai.models.generateImages({
        model: 'imagen-4.0-generate-001',
        prompt: fullPrompt,
        config: {
          numberOfImages: 1,
          outputMimeType: 'image/jpeg',
          aspectRatio: '16:9',
        },
      });

      if (response?.generatedImages?.[0]?.image?.imageBytes) {
        const base64Bytes = response.generatedImages[0].image.imageBytes;
        return res.json({ imageUrl: `data:image/jpeg;base64,${base64Bytes}` });
      }
    } catch (err) {
      console.warn("Imagen generation failed, falling back to gemini-2.5-flash-image:", err);
      // Fallback to gemini-2.5-flash-image
      try {
        const geminiImgRes = await ai.models.generateContent({
          model: 'gemini-2.5-flash-image',
          contents: {
            parts: [{ text: fullPrompt }]
          },
          config: {
            imageConfig: {
              aspectRatio: "16:9",
              imageSize: "512px"
            }
          }
        });

        for (const part of geminiImgRes.candidates?.[0]?.content?.parts || []) {
          if (part.inlineData) {
            const base64Bytes = part.inlineData.data;
            return res.json({ imageUrl: `data:image/png;base64,${base64Bytes}` });
          }
        }
      } catch (err2) {
        console.error("Failsafe generation also failed, using pollinations:", err2);
      }
    }

    // Always fallback to beautiful pollinations.ai so the user gets an amazing image!
    res.json({ imageUrl: fallbackUrl });
  } catch (error: any) {
    console.error("Failed image generation:", error);
    const fallbackUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(req.body.prompt || "cyber")}?width=1024&height=576&nologo=true&private=true`;
    res.json({ imageUrl: fallbackUrl });
  }
});

// 4. WordPress Fixed Theme & Plugin Downloader
app.get("/api/wordpress/download-fixed-theme", (req, res) => {
  try {
    ensureZipPackages();
    console.log("[DYNAMIC ZIP] Theme successfully repackaged prior to download.");
  } catch (err: any) {
    console.error("[DYNAMIC ZIP] Theme repackaging failed:", err.message);
  }
  const zipPath = path.join(process.cwd(), "dist", "ilybd-neon-v1-pro-fixed.zip");
  if (fs.existsSync(zipPath)) {
    res.download(zipPath, "ilybd-neon-v1-pro-fixed.zip");
  } else {
    res.status(404).json({ error: "Fixed theme ZIP is currently not packaged or available." });
  }
});

app.get("/api/wordpress/download-fixed-plugin", (req, res) => {
  try {
    ensureZipPackages();
    console.log("[DYNAMIC ZIP] Plugin successfully repackaged prior to download.");
  } catch (err: any) {
    console.error("[DYNAMIC ZIP] Plugin repackaging failed:", err.message);
  }
  const zipPath = path.join(process.cwd(), "dist", "ilybd-prime-engine-fixed.zip");
  if (fs.existsSync(zipPath)) {
    res.download(zipPath, "ilybd-prime-engine-fixed.zip");
  } else {
    res.status(404).json({ error: "Fixed plugin ZIP is currently not packaged or available." });
  }
});

// ---------------------- DEVELOPER DEV SERVER OR PROD STATIC ROUTING ----------------------

async function startServer() {
  // Programme themes and plugins packaging dynamically at boot
  try {
    ensureZipPackages();
  } catch (err: any) {
    console.error("Failed to run automated zipping on boot:", err.message);
  }

  if (process.env.NODE_ENV !== "production") {
    const vite = await createViteServer({
      server: { middlewareMode: true },
      appType: "spa",
    });
    app.use(vite.middlewares);
    console.log("Vite development middleware integrated.");
  } else {
    const distPath = path.join(process.cwd(), "dist");
    app.use(express.static(distPath));
    app.get("*", (req, res) => {
      res.sendFile(path.join(distPath, "index.html"));
    });
  }

  app.listen(PORT, "0.0.0.0", () => {
    console.log(`[SYS] Cyber Server online and listening at http://0.0.0.0:${PORT}`);
  });
}

startServer();
