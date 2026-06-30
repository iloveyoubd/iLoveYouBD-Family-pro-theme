import fs from 'fs';

try {
    const stats = fs.statSync('wordpress-theme.zip');
    console.log(`File size: ${stats.size} bytes`);
    
    const fd = fs.openSync('wordpress-theme.zip', 'r');
    const buffer = Buffer.alloc(100);
    fs.readSync(fd, buffer, 0, 100, 0);
    fs.closeSync(fd);
    
    console.log("First 100 bytes (hex):", buffer.toString('hex'));
    console.log("First 100 bytes (utf8):", buffer.toString('utf8'));
} catch (error: any) {
    console.error("Error:", error.message);
}
