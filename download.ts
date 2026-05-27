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

  // Check if it's returning empty or error text
  const arrayBuffer = await response.arrayBuffer();
  const buffer = Buffer.from(arrayBuffer);
  
  // If it's a small HTML page instead of a zip file, print it
  if (buffer.length < 5000 && buffer.toString().includes("<!DOCTYPE html>")) {
    console.log("Warning: Downloaded content appears to be an HTML page. Preview:");
    console.log(buffer.toString().substring(0, 1000));
  } else {
    console.log(`Downloaded ${buffer.length} bytes.`);
  }

  await fs.promises.writeFile(dest, buffer);
}

async function main() {
  const fileId = "1vy0DvKGYVRDVxh-8HZoGFFZVU68JNawM";
  // Attempt with direct usercontent download link first
  const url1 = `https://drive.usercontent.google.com/download?id=${fileId}&export=download&confirm=t`;
  const url2 = `https://docs.google.com/uc?export=download&id=${fileId}`;
  
  const zipPath = path.join(process.cwd(), "wordpress-theme.zip");
  const extractPath = path.join(process.cwd(), "extracted-wordpress");

  try {
    await downloadFile(url1, zipPath);
    console.log("Extraction initiated...");
    const zip = new AdmZip(zipPath);
    zip.extractAllTo(extractPath, true);
    console.log("Successfully extracted to:", extractPath);
    
    // List top level folders
    const files = await fs.promises.readdir(extractPath);
    console.log("Top-level files/directories extracted:", files);
  } catch (error: any) {
    console.error("Error in download or extract:", error.message);
    
    // Retry with second url if first fails or extracts invalid zip
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
