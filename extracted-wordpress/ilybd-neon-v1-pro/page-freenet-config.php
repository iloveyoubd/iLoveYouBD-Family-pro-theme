<?php
/* Template Name: CyberX FreeNet Config Generator */

get_header();

// simple access control (optional future use)
$enabled = get_option('cyberx_freenet_enabled', 1);
if (!$enabled) {
    echo "<div style='text-align:center;padding:60px;color:red;'>🚫 FreeNet System Disabled</div>";
    get_footer();
    exit;
}
?>

<div style="background:#000;min-height:100vh;color:#fff;font-family:sans-serif;padding:40px 10px;text-align:center;">

    <div style="max-width:600px;margin:auto;border:1px solid #222;padding:30px;border-radius:20px;background:#0a0a0a;">

        <h1 style="color:#00ffcc;">CyberX FreeNet Hub</h1>
        <p style="color:#666;font-size:13px;">Demo config generator system</p>

        <!-- FORM -->
        <div style="margin-top:30px;">

            <select id="sim-type" style="width:100%;padding:12px;background:#111;border:1px solid #333;color:#fff;border-radius:8px;margin-bottom:20px;">
                <option value="gp">Grameenphone</option>
                <option value="robi">Robi</option>
            </select>

            <button id="genBtn" style="width:100%;background:#00ffcc;color:#000;border:none;padding:15px;border-radius:8px;font-weight:bold;cursor:pointer;">
                GENERATE CONFIG
            </button>

        </div>

        <!-- RESULT -->
        <div id="config-result" style="display:none;margin-top:25px;text-align:left;">

            <p style="color:#00ffcc;font-size:12px;">Copy config:</p>

            <textarea id="config-box" readonly 
            style="width:100%;height:120px;background:#000;border:1px solid #00ffcc33;color:#00ffcc;font-family:monospace;padding:10px;border-radius:8px;font-size:11px;"></textarea>

            <button id="copyBtn" style="margin-top:10px;background:#222;color:#fff;border:none;padding:8px 15px;border-radius:5px;cursor:pointer;">
                Copy
            </button>

        </div>

    </div>

</div>

<script>
document.getElementById("genBtn").addEventListener("click", function() {

    const sim = document.getElementById("sim-type").value;
    const resultDiv = document.getElementById("config-result");
    const configBox = document.getElementById("config-box");

    let vmess = "";

    // demo configs
    if(sim === "gp") {
        vmess = "vmess://GP_CONFIG_DEMO_123456";
    } else {
        vmess = "vmess://ROBI_CONFIG_DEMO_654321";
    }

    configBox.value = vmess;
    resultDiv.style.display = "block";
});

// copy safe method
document.getElementById("copyBtn").addEventListener("click", function() {

    const text = document.getElementById("config-box");

    navigator.clipboard.writeText(text.value).then(function() {
        alert("Copied সফল হয়েছে");
    });

});
</script>

<?php get_footer(); ?>