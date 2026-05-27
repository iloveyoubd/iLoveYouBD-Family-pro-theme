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
const phpFiles = findFiles(basePath, ".php");

console.log("Analyzing update_user_meta, get_user_meta patterns...");

const patterns = [
  "user_balance",
  "user_points",
  "ilybd_total_points",
  "points",
  "balance",
  "update_user_meta"
];

const results: Array<{file: string, line: number, text: string}> = [];

for (const file of phpFiles) {
  const content = fs.readFileSync(file, "utf8");
  const lines = content.split("\n");
  const relPath = path.relative(basePath, file);
  
  lines.forEach((line, index) => {
    if (line.includes("user_balance") || line.includes("user_points") || line.includes("ilybd_total_points")) {
      results.push({
        file: relPath,
        line: index + 1,
        text: line.trim()
      });
    }
  });
}

console.log(`Found ${results.length} occurrences:`);
results.forEach(r => {
  console.log(`[${r.file}:${r.line}] ${r.text}`);
});
