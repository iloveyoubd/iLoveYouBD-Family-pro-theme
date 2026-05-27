<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div id="ibd-nid-pro-container" class="container">
    <h2 style="color: #006b3c;">Smart NID Generator (IBD Cyber Edition)</h2>
    
    <div class="input-grid">
        <input type="text" id="bnName" placeholder="নাম (বাংলা)" value="মোঃ আশরাফুল ইসলাম">
        <input type="text" id="enName" placeholder="Name (English)" value="MD. ASRAFUL ISLAM">
        <input type="text" id="fName" placeholder="পিতার নাম" value="আওলাদ হোসেন">
        <input type="text" id="mName" placeholder="মাতার নাম" value="রেজিয়া বেগম">
        <input type="text" id="dob" placeholder="জন্ম তারিখ (12 Feb 1999)" value="12 Feb 1999">
        <input type="text" id="nidNo" placeholder="NID No" value="330 418 9438">
        <input type="text" id="village" placeholder="গ্রাম/রাস্তা" value="দক্ষিণ বনশ্রী">
        <input type="text" id="postOffice" placeholder="ডাকঘর" value="খিলগাঁও-১২১৯">
        <input type="text" id="upazila" placeholder="উপজেলা" value="খিলগাঁও">
        <input type="text" id="district" placeholder="জেলা" value="ঢাকা">
        <input type="text" id="blood" placeholder="Blood Group" value="O+">
        <input type="text" id="pob" placeholder="Birth Place" value="DHAKA">
        <input type="text" id="issueDate" placeholder="Issue Date" value="15 Aug 2023">
    </div>

    <div class="image-upload-section" style="background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #e9ecef;">
        <label>আপনার ছবি আপলোড করুন:</label><br>
        <input type="file" id="imageInput" accept="image/*">
    </div>

    <div id="crop-container" style="display: none; margin: 20px 0; background: #222; padding: 10px; border-radius: 10px;">
        <div class="img-area" style="max-height: 400px; overflow: hidden;"><img id="crop-image"></div>
        <button onclick="applyCrop()" style="background: #3498db; width: 100%; color: #fff; padding: 10px; border: none; margin-top: 10px; border-radius: 5px; cursor: pointer;">ছবিটি ঠিক করুন (Crop)</button>
    </div>

    <div id="sig-box" style="border: 2px dashed #006b3c; padding: 15px; border-radius: 10px; margin: 20px 0; background: #fdfdfd;">
        <canvas id="sig-canvas" width="350" height="100" style="background:#fff; display:block; margin:auto; border: 1px solid #eee;"></canvas>
        <button onclick="signaturePad.clear()" style="width:auto; background:#6c757d; color: #fff; border: none; padding: 5px 10px; font-size:12px; margin-top:5px; border-radius: 3px; cursor: pointer;">স্বাক্ষর মুছুন</button>
    </div>

    <div class="status" id="status-text" style="font-weight: bold; color: #d35400; margin: 15px 0;"></div>
    <button id="genBtn" onclick="startNIDGeneration()" style="background: #006b3c; color: #fff; padding: 15px; width: 100%; border: none; border-radius: 10px; font-weight: bold; cursor: pointer;">আইডি কার্ড জেনারেট করুন</button>

    <div class="btn-group" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px;">
        <button class="download-btn" id="dBtnFront" style="display:none; background: #2980b9; color: #fff; padding: 10px; border: none; flex: 1; border-radius: 5px;" onclick="downloadImage('frontCanvas', 'NID_Front')">সামনের পার্ট</button>
        <button class="download-btn" id="dBtnBack" style="display:none; background: #2980b9; color: #fff; padding: 10px; border: none; flex: 1; border-radius: 5px;" onclick="downloadImage('backCanvas', 'NID_Back')">পিছনের পার্ট</button>
        <button class="download-btn" id="dBtnFull" style="display:none; background: #e67e22; color: #fff; padding: 10px; border: none; flex: 1; border-radius: 5px;" onclick="downloadFullScan()">একসাথে স্ক্যান কপি</button>
    </div>
</div>

<canvas id="frontCanvas" width="1011" height="638" style="display:none; margin: 20px auto;"></canvas>
<canvas id="backCanvas" width="1011" height="638" style="display:none; margin: 20px auto;"></canvas>
<canvas id="fullCanvas" width="1050" height="1450" style="display:none;"></canvas>

<script>
    const ibd_nid_assets = {
        templateFront: '<?php echo plugin_dir_url(__FILE__) . "template.png"; ?>',
        templateBack: '<?php echo plugin_dir_url(__FILE__) . "template-back.png"; ?>'
    };
</script>
