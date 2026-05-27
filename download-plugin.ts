import fs from "fs";
import path from "path";
import AdmZip from "adm-zip";

async function downloadFile(url: string, dest: string): Promise<void> {
  console.log(`Downloading from ${url} to ${dest}...`);
  const response = await fetch(url, {
    headers: {
      "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36"
    }
  });

  if (!response.ok) {
    throw new Error(`Failed to download: ${response.statusText}`);
  }

  const arrayBuffer = await response.arrayBuffer();
  const buffer = Buffer.from(arrayBuffer);
  
  if (buffer.length < 5000 && buffer.toString().includes("<!DOCTYPE html>")) {
    console.log("Warning: Downloaded content appears to be an HTML page. Preview:");
    console.log(buffer.toString().substring(0, 1000));
  } else {
    console.log(`Downloaded ${buffer.length} bytes.`);
  }

  await fs.promises.writeFile(dest, buffer);
}

async function main() {
  const fileId = "1DWD4To767KtXykhN1Uealj4AUJQnN8uh";
  const url1 = `https://drive.usercontent.google.com/download?id=${fileId}&export=download&confirm=t`;
  const url2 = `https://docs.google.com/uc?export=download&id=${fileId}`;
  
  const zipPath = path.join(process.cwd(), "wordpress-plugin.zip");
  const extractPath = path.join(process.cwd(), "extracted-wordpress");

  try {
    await downloadFile(url1, zipPath);
    console.log("Extraction initiated...");
    const zip = new AdmZip(zipPath);
    zip.extractAllTo(extractPath, true);
    console.log("Successfully extracted to:", extractPath);
    
    const files = await fs.promises.readdir(extractPath);
    console.log("Top-level files/directories extracted:", files);
  } catch (error: any) {
    console.error("Error in download or extract:", error.message);
    
    try {
      console.log("Retrying with fallback Google Drive URL...");
      await downloadFile(url2, zipPath);
      console.log("Extraction initiated...");
      const zip = new AdmZip(zipPath);
      zip.extractAllTo(extractPath, true);
      console.log("Successfully extracted to:", extractPath);
      
      const files = await fs.promises.readdir(extractPath);
      console.log("Top-level files/directories extracted:", files);
    } catch (err2: any) {
      console.error("Fallback route also failed:", err2.message);
    }
  }
}

main();
