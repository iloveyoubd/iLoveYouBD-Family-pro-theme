<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.11.0"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/body-pix@2.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<div class="nid-v2-wrapper" style="max-width: 900px; margin: 20px auto; background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); font-family: 'SolaimanLipi', sans-serif;">
    
    <h2 style="color: #006b3c; text-align: center;">Smart NID Generator (IBD Cyber Edition)</h2>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
        <input type="text" id="bnName" placeholder="নাম (বাংলা)" value="মোঃ আশরাফুল ইসলাম" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="enName" placeholder="Name (English)" value="MD. ASRAFUL ISLAM" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="fName" placeholder="পিতার নাম" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="mName" placeholder="মাতার নাম" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="dob" placeholder="জন্ম তারিখ (12 Feb 1999)" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="nidNo" placeholder="NID নম্বর" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="village" placeholder="গ্রাম/রাস্তা" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="postOffice" placeholder="ডাকঘর" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="upazila" placeholder="উপজেলা" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="district" placeholder="জেলা" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="blood" placeholder="রক্তের গ্রুপ" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
        <input type="text" id="issueDate" placeholder="প্রদানের তারিখ" style="padding:10px; border:1px solid #ccc; border-radius:8px;">
    </div>

    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #e9ecef; text-align: center;">
        <label>আপনার ছবি আপলোড করুন:</label><br>
        <input type="file" id="imageInput" accept="image/*">
    </div>

    <div id="crop-container" style="display: none; margin: 20px 0; background: #222; padding: 10px; border-radius: 10px; text-align: center;">
        <div style="max-height: 400px; overflow: hidden;"><img id="crop-image" style="max-width: 100%;"></div>
        <button onclick="applyCrop()" style="background: #3498db; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; margin-top: 10px; cursor: pointer;">ছবিটি ঠিক করুন (Crop)</button>
    </div>

    <div id="sig-box" style="border: 2px dashed #006b3c; padding: 15px; border-radius: 10px; margin: 20px 0; background: #fdfdfd; text-align: center;">
        <canvas id="sig-canvas" width="350" height="100" style="background:#fff; border: 1px solid #ddd; border-radius: 8px; touch-action: none; cursor: crosshair;"></canvas>
        <br>
        <button onclick="signaturePad.clear()" style="background:#6c757d; color:#fff; border:none; padding:5px 15px; border-radius:5px; font-size:12px; margin-top:5px; cursor:pointer;">স্বাক্ষর মুছুন</button>
    </div>

    <div id="status-text" style="font-weight: bold; color: #d35400; margin: 15px 0; text-align: center;"></div>
    
    <button id="genBtn" onclick="startNIDGenerationV2()" style="width: 100%; background: #006b3c; color: #fff; padding: 15px; border: none; border-radius: 10px; font-size: 18px; font-weight: bold; cursor: pointer;">আইডি কার্ড জেনারেট করুন</button>

    <div id="secure-gate" style="display:none; margin-top: 20px; text-align: center; background: #f0fdf4; padding: 20px; border-radius: 10px; border: 2px dashed #006b3c;">
        <h3 style="color: #006b3c;">✅ কার্ড তৈরি হয়েছে!</h3>
        <input type="text" id="v2KeyInput" placeholder="Security Key Here" style="padding: 10px; border: 1px solid #006b3c; border-radius: 5px; width: 200px;">
        <button onclick="unlockV2Download()" style="background: #006b3c; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Verify & Show Download</button>
    </div>

    <div id="download-zone" style="display:none; margin-top: 20px; text-align: center; gap: 10px; justify-content: center;">
        <button onclick="downloadImage('frontCanvas', 'NID_Front')" style="background: #2980b9; color:#fff; border:none; padding:12px 20px; border-radius:5px; font-weight:bold; cursor:pointer;">সামনের পার্ট</button>
        <button onclick="downloadImage('backCanvas', 'NID_Back')" style="background: #2980b9; color:#fff; border:none; padding:12px 20px; border-radius:5px; font-weight:bold; cursor:pointer;">পিছনের পার্ট</button>
    </div>
</div>

<canvas id="frontCanvas" width="1011" height="638" style="display:none;"></canvas>
<canvas id="backCanvas" width="1011" height="638" style="display:none;"></canvas>

<script>
let cropper;
let signaturePad;
let croppedBlob = null;

// পেজ লোড হলে লাইব্রেরিগুলো ইনিশিয়ালাইজ করা
window.onload = () => {
    const canvas = document.getElementById('sig-canvas');
    signaturePad = new SignaturePad(canvas);
    
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('crop-container').style.display = 'block';
            const img = document.getElementById('crop-image');
            img.src = event.target.result;
            if(cropper) cropper.destroy();
            cropper = new Cropper(img, { aspectRatio: 3/4, viewMode: 1 });
        };
        reader.readAsDataURL(e.target.files[0]);
    });
};

function applyCrop() {
    croppedBlob = cropper.getCroppedCanvas({ width: 400, height: 533 }).toDataURL('image/jpeg', 0.9);
    document.getElementById('crop-container').style.display = 'none';
    document.getElementById('status-text').innerText = "ছবি ক্রপ করা হয়েছে!";
}

async function startNIDGenerationV2() {
    if(!croppedBlob) { alert("প্রথমে ছবি আপলোড ও ক্রপ করুন!"); return; }
    document.getElementById('status-text').innerText = "প্রসেসিং হচ্ছে... দয়া করে অপেক্ষা করুন।";
    
    try {
        // আপনার আপলোড করা টেম্পলেট পাথ অনুযায়ী
        const templateFront = await loadImage('<?php echo plugin_dir_url( dirname(__FILE__) ) . "nid-pro/template.png"; ?>');
        const templateBack = await loadImage('<?php echo plugin_dir_url( dirname(__FILE__) ) . "nid-pro/template-back.png"; ?>');
        const userImg = await loadImage(croppedBlob);

        // বডি পিক্স ব্যবহার করে ব্যাকগ্রাউন্ড রিমুভ (আপনার লজিক)
        const net = await bodyPix.load();
        const segmentation = await net.segmentPerson(userImg);
        const photoCanvas = document.createElement('canvas');
        photoCanvas.width = userImg.width; photoCanvas.height = userImg.height;
        const pCtx = photoCanvas.getContext('2d');
        pCtx.drawImage(userImg, 0, 0);
        const imgData = pCtx.getImageData(0,0,photoCanvas.width,photoCanvas.height);
        for(let i=0; i<segmentation.data.length; i++) if(segmentation.data[i]===0) imgData.data[i*4+3]=0;
        pCtx.putImageData(imgData,0,0);

        // কার্ড ড্রয়িং লজিক (সামনের পার্ট)
        const fCanvas = document.getElementById('frontCanvas');
        const fCtx = fCanvas.getContext('2d');
        fCtx.drawImage(templateFront, 0, 0, 1011, 638);
        fCtx.drawImage(photoCanvas, 57, 210, 225, 265); 
        
        // লেখাগুলো যোগ করা
        fCtx.fillStyle = "#1a1a1a";
        fCtx.font = "bold 32px Arial";
        fCtx.fillText(document.getElementById('bnName').value, 328, 244);
        fCtx.fillText(document.getElementById('enName').value.toUpperCase(), 328, 304);
        fCtx.fillText(document.getElementById('nidNo').value, 465, 585);

        // সিগনেচার যোগ করা
        if(!signaturePad.isEmpty()) {
            const sigImg = await loadImage(signaturePad.toDataURL());
            fCtx.drawImage(sigImg, 55, 515, 185, 65);
        }

        // কার্ড ড্রয়িং লজিক (পিছনের পার্ট)
        const bCanvas = document.getElementById('backCanvas');
        const bCtx = bCanvas.getContext('2d');
        bCtx.drawImage(templateBack, 0, 0, 1011, 638);
        
        const addr = "ঠিকানা: " + document.getElementById('village').value + ", " + document.getElementById('postOffice').value;
        bCtx.font = "bold 18px Arial";
        bCtx.fillText(addr, 45, 175);

        document.getElementById('status-text').innerText = "কার্ড তৈরি সম্পন্ন!";
        document.getElementById('secure-gate').style.display = 'block';

    } catch (e) {
        document.getElementById('status-text').innerText = "Error: প্রসেসিং ব্যর্থ হয়েছে।";
        console.error(e);
    }
}

function unlockV2Download() {
    const key = document.getElementById('v2KeyInput').value;
    const masterKey = "<?php echo get_option('ibd_nid_unlock_key', 'IBD71'); ?>";
    if(key === masterKey) {
        document.getElementById('secure-gate').style.display = 'none';
        document.getElementById('download-zone').style.display = 'flex';
    } else { alert("ভুল কি!"); }
}

function loadImage(src) { return new Promise(res => { const img = new Image(); img.crossOrigin = "anonymous"; img.onload = () => res(img); img.src = src; }); }

function downloadImage(id, name) {
    const canvas = document.getElementById(id);
    const link = document.createElement('a');
    link.download = name + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}
</script>
