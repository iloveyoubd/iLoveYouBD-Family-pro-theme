import fs from 'fs';
import path from 'path';

function findFiles(dir: string, pattern: string) {
    try {
        const files = fs.readdirSync(dir);
        for (const file of files) {
            const fullPath = path.join(dir, file);
            let stat;
            try {
                stat = fs.statSync(fullPath);
            } catch (e) {
                continue;
            }
            if (stat.isDirectory()) {
                findFiles(fullPath, pattern);
            } else if (file.includes(pattern)) {
                console.log(`Found: ${fullPath} (${stat.size} bytes)`);
            }
        }
    } catch (e) {
        // ignore
    }
}

console.log("Searching for transcripts or logs...");
findFiles('.', 'transcript');
findFiles('.', 'log');
findFiles('/aistudio', 'transcript');
findFiles('/aistudio', 'log');
findFiles('/.aistudio', 'transcript');
findFiles('/.aistudio', 'log');
findFiles('/tmp', 'transcript');
findFiles('/tmp', 'log');
