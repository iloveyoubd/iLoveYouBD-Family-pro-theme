import AdmZip from 'adm-zip';
import path from 'path';
import fs from 'fs';

const zipPath = path.resolve('wordpress-theme.zip');
console.log(`Loading ${zipPath}...`);
const zip = new AdmZip(zipPath);

// Find the target entry: "ilybd-neon-v1-pro/inc/ilybd-tools-engine.php"
const zipEntries = zip.getEntries();
const entryName = 'ilybd-neon-v1-pro/inc/ilybd-tools-engine.php';
const entry = zipEntries.find(e => e.entryName.endsWith(entryName));

if (entry) {
    console.log(`Found entry: ${entry.entryName}`);
    const destDir = path.resolve('extracted-wordpress/ilybd-neon-v1-pro/inc');
    const destPath = path.join(destDir, 'ilybd-tools-engine.php');
    
    // Ensure destination directory exists
    fs.mkdirSync(destDir, { recursive: true });
    
    // Extract file content
    const content = zip.readAsText(entry);
    fs.writeFileSync(destPath, content, 'utf8');
    console.log(`Successfully restored ${destPath}!`);
} else {
    console.error(`Could not find entry ending with ${entryName} in zip file!`);
    console.log("Entries available:");
    zipEntries.slice(0, 10).forEach(e => console.log(` - ${e.entryName}`));
}
