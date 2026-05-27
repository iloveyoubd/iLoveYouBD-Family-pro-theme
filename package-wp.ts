import fs from "fs";
import path from "path";
import AdmZip from "adm-zip";

async function main() {
  const distDir = path.join(process.cwd(), "dist");
  if (!fs.existsSync(distDir)) {
    fs.mkdirSync(distDir, { recursive: true });
    console.log("Created directory:", distDir);
  }

  // ==== 1. PACK THEME ====
  const themePath = path.join(process.cwd(), "extracted-wordpress", "ilybd-neon-v1-pro");
  const destThemeZip = path.join(process.cwd(), "dist", "ilybd-neon-v1-pro-fixed.zip");
  
  console.log("Starting zipping of WordPress Theme:", themePath);
  try {
    const zip = new AdmZip();
    zip.addLocalFolder(themePath, "ilybd-neon-v1-pro");
    zip.writeZip(destThemeZip);
    console.log("Theme package completed successfully. Size:", fs.statSync(destThemeZip).size, "bytes.");
  } catch (error: any) {
    console.error("Theme zipping failed:", error.message);
  }

  // ==== 2. PACK PLUGIN ====
  const pluginPath = path.join(process.cwd(), "extracted-wordpress", "ilybd-prime-engine");
  const destPluginZip = path.join(process.cwd(), "dist", "ilybd-prime-engine-fixed.zip");
  
  console.log("Starting zipping of WordPress Plugin:", pluginPath);
  try {
    const zip = new AdmZip();
    zip.addLocalFolder(pluginPath, "ilybd-prime-engine");
    zip.writeZip(destPluginZip);
    console.log("Plugin package completed successfully. Size:", fs.statSync(destPluginZip).size, "bytes.");
  } catch (error: any) {
    console.error("Plugin zipping failed:", error.message);
  }
}

main();
