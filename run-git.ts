import { execSync } from 'child_process';

try {
    console.log("Checking git status...");
    const status = execSync('git status', { encoding: 'utf8' });
    console.log(status);
    
    console.log("Restoring file via git checkout...");
    const checkout = execSync('git checkout -- extracted-wordpress/ilybd-neon-v1-pro/inc/ilybd-tools-engine.php', { encoding: 'utf8' });
    console.log("Git checkout result:", checkout);
} catch (error: any) {
    console.error("Error executing git command:", error.message);
    if (error.stdout) console.log("STDOUT:", error.stdout.toString());
    if (error.stderr) console.log("STDERR:", error.stderr.toString());
}
