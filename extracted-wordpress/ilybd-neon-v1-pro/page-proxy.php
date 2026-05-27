<?php
/* Template Name: CyberX Free Net Proxy */

get_header();

// 🔒 Proxy ON/OFF Control
$proxy_enabled = get_option('cyberx_proxy_enabled', 0);

if (!$proxy_enabled) {
    echo "<div style='text-align:center;padding:60px;color:red;font-size:20px;'>
    🚫 Proxy System বর্তমানে বন্ধ আছে (Admin Panel থেকে চালু করুন)
    </div>";
    get_footer();
    exit;
}

// ===============================
// PROXY ENGINE
// ===============================
$proxy_content = '';
$error = '';
$target_url = '';

if (isset($_POST['url'])) {

    $target_url = trim($_POST['url']);

    // URL sanitize
    $target_url = filter_var($target_url, FILTER_SANITIZE_URL);

    // protocol add if missing
    if (!preg_match("~^(?:f|ht)tps?://~i", $target_url)) {
        $target_url = "https://" . $target_url;
    }

    // validate URL
    if (!filter_var($target_url, FILTER_VALIDATE_URL)) {
        $error = "❌ Invalid URL!";
    } else {

        // cURL request
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $target_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (CyberX Proxy)',
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = "⚠️ Connection Error!";
        } else {
            // ⚠️ basic sanitize (script remove)
            $proxy_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $response);
        }

        curl_close($ch);
    }
}
?>

<div style="background:#000; min-height:100vh; color:#fff; padding:30px 10px; font-family:sans-serif;">

    <div style="max-width:1000px;margin:auto;">

        <!-- HEADER -->
        <div style="background:#111;border:1px solid #222;padding:25px;border-radius:12px;text-align:center;margin-bottom:20px;">
            <h2 style="color:#00ffcc;">CYBERX FREE PROXY</h2>
            <p style="color:#666;font-size:12px;">Secure browsing system</p>

            <form method="post" style="display:flex;gap:10px;margin-top:15px;flex-wrap:wrap;">
                <input 
                    type="text" 
                    name="url" 
                    placeholder="Enter URL (example.com)" 
                    required
                    value="<?php echo esc_attr($target_url); ?>"
                    style="flex:1;padding:12px;background:#000;border:1px solid #333;color:#00ffcc;border-radius:6px;"
                >

                <button type="submit" style="padding:12px 20px;background:#00ffcc;color:#000;border:none;border-radius:6px;font-weight:bold;">
                    GO
                </button>
            </form>
        </div>

        <!-- ERROR -->
        <?php if (!empty($error)): ?>
            <div style="background:#300;color:#fff;padding:15px;border-radius:8px;margin-bottom:15px;">
                <?php echo esc_html($error); ?>
            </div>
        <?php endif; ?>

        <!-- OUTPUT -->
        <div style="background:#fff;color:#000;border-radius:10px;overflow:hidden;min-height:500px;">

            <?php if (!empty($proxy_content)): ?>

                <div style="padding:10px;">
                    <?php echo $proxy_content; ?>
                </div>

            <?php else: ?>

                <div style="height:500px;display:flex;align-items:center;justify-content:center;color:#888;text-align:center;">
                    🌐 URL লিখে GO চাপুন
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<style>
    iframe, img { max-width:100%; }
    a { pointer-events:none; } /* security */
</style>

<?php get_footer(); ?>