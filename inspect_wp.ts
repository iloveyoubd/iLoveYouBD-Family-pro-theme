import fs from "fs";
import path from "path";

function findFiles(dir: string, ext: string, fileList: string[] = []): string[] {
  const files = fs.readdirSync(dir);
  for (const file of files) {
    const filePath = path.join(dir, file);
    const stat = fs.statSync(filePath);
    if (stat.isDirectory()) {
      findFiles(filePath, ext, fileList);
    } else if (file.endsWith(ext)) {
      fileList.push(filePath);
    }
  }
  return fileList;
}

const basePath = path.join(process.cwd(), "extracted-wordpress", "ilybd-neon-v1-pro");

try {
  const phpFiles = findFiles(basePath, ".php");
  console.log(`Found ${phpFiles.length} PHP files.`);

  // Search for keywords
  const keywords = ["point", "balance", "wallet", "payout", "author", "dashboard", "like_count", "comment_count", "pending", "bkas", "nogod"];
  const matches: Record<string, string[]> = {};

  for (const file of phpFiles) {
    const content = fs.readFileSync(file, "utf8");
    const relativePath = path.relative(basePath, file);
    
    for (const kw of keywords) {
      if (content.toLowerCase().includes(kw)) {
        if (!matches[kw]) matches[kw] = [];
        matches[kw].push(relativePath);
      }
    }
  }

  console.log("\n----- KEYWORD MATCHES -----");
  for (const [kw, files] of Object.entries(matches)) {
    console.log(`Keyword "${kw}" found in ${files.length} files:`);
    console.log(files.slice(0, 10).map(f => `  - ${f}`).join("\n"));
    if (files.length > 10) console.log(`  ... and ${files.length - 10} more files`);
  }

} catch (err: any) {
  console.error("Error inspecting:", err.message);
}
