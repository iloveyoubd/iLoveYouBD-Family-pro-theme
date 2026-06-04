<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<!-- Google Web Fonts for premium Bengali rendering -->
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@500;700&display=swap" rel="stylesheet font-display='swap'">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.11.0"></script>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/body-pix@2.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<div class="nid-v2-wrapper" style="max-width: 950px; margin: 25px auto; background: #ffffff; padding: 30px; border-radius: 16px; box-shadow: 0 12px 40px rgba(0,0,0,0.12); font-family: 'Hind Siliguri', 'SolaimanLipi', sans-serif; color: #333333;">
    
    <div style="text-align: center; margin-bottom: 25px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px;">
        <h2 style="color: #006b3c; margin: 0; font-size: 26px; font-weight: 700;">Smart NID Card Generator PRO</h2>
        <p style="color: #4a5568; margin: 5px 0 0 0; font-size: 14px;">অরিজিনাল স্মার্ট কার্ডের মতো ১০০% সেম-টু-সেম কোয়ালিটি লেআউট জেনারেটর</p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-bottom: 25px;">
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">নাম (বাংলা):</label>
            <input type="text" id="bnName" value="মোঃ আশরাফুল ইসলাম" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:'Hind Siliguri', sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">Name (English):</label>
            <input type="text" id="enName" value="MD. ASRAFUL ISLAM" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:Arial, sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">পিতার নাম (বাংলা):</label>
            <input type="text" id="fName" value="আওলাদ হোসেন" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:'Hind Siliguri', sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">মাতার নাম (বাংলা):</label>
            <input type="text" id="mName" value="রেজিয়া বেগম" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:'Hind Siliguri', sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">জন্ম তারিখ (যেমন: 12 Feb 1999):</label>
            <input type="text" id="dob" value="12 Feb 1999" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:Arial, sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">NID নম্বর:</label>
            <input type="text" id="nidNo" value="330 418 9438" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:Arial, sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">গ্রাম/রাস্তা (বাংলা):</label>
            <input type="text" id="village" value="দক্ষিণ বনশ্রী" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:'Hind Siliguri', sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">ডাকঘর (বাংলা):</label>
            <input type="text" id="postOffice" value="খিলগাঁও-১২১৯" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:'Hind Siliguri', sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">উপজেলা (বাংলা):</label>
            <input type="text" id="upazila" value="খিলগাঁও" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:'Hind Siliguri', sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">জেলা (বাংলা):</label>
            <input type="text" id="district" value="ঢাকা" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:'Hind Siliguri', sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">রক্তের গ্রুপ (Blood Group):</label>
            <input type="text" id="blood" value="O+" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:Arial, sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">জন্ম স্থান (english pob):</label>
            <input type="text" id="pob" value="DHAKA" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:Arial, sans-serif;">
        </div>
        <div>
            <label style="display:block; font-size:12px; font-weight:700; color:#4a5568; margin-bottom:4px;">প্রদানের তারিখ (Issue Date):</label>
            <input type="text" id="issueDate" value="15 Aug 2023" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; font-family:Arial, sans-serif;">
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <div style="background: #f8fafc; padding: 18px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center;">
            <label style="font-weight:700; color:#334155; display:block; margin-bottom:10px;">👤 ১. আপনার ছবি আপলোড করুন</label>
            <input type="file" id="imageInput" accept="image/*" style="width: 100%;">
            <p style="font-size: 11px; color: #64748b; margin: 8px 0 0 0;">(স্বয়ংক্রিয়ভাবে ব্যাকগ্রাউন্ড রিমুভ হবেAI প্রযুক্তির মাধ্যমে)</p>
        </div>
        
        <div style="background: #f8fafc; padding: 18px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center;">
            <label style="font-weight:700; color:#334155; display:block; margin-bottom:10px;">✍️ ২. স্ক্রিনে ডিজিটাল স্বাক্ষর দিন</label>
            <canvas id="sig-canvas" width="350" height="90" style="background:#ffffff; border: 1px solid #cbd5e1; border-radius: 6px; touch-action: none; cursor: crosshair; display:block; margin:0 auto;"></canvas>
            <button onclick="signaturePad.clear()" style="background:#64748b; color:#fff; border:none; padding:5px 12px; border-radius:4px; font-size:11px; margin-top:8px; cursor:pointer; font-weight:700;">স্বাক্ষর মুছুন (Clear)</button>
        </div>
    </div>

    <div id="crop-container" style="display: none; margin: 20px 0; background: #0f172a; padding: 15px; border-radius: 12px; text-align: center;">
        <h4 style="color: #ffffff; margin-top:0; margin-bottom:10px;">✂️ ছবি ক্রপ করুন</h4>
        <div style="max-height: 400px; overflow: hidden; display:inline-block;"><img id="crop-image" style="max-height:350px; max-width: 100%;"></div>
        <br>
        <button onclick="applyCrop()" style="background: #0ea5e9; color: #fff; padding: 10px 25px; border: none; border-radius: 6px; margin-top: 12px; cursor: pointer; font-weight:700; font-size:14px;">ছবি ঠিক করুন (Crop Apply)</button>
    </div>

    <div id="status-text" style="font-weight: 700; color: #d97706; margin: 15px 0; text-align: center; font-size:15px; min-height:22px;"></div>
    
    <button id="genBtn" onclick="startNIDGenerationV2()" style="width: 100%; background: #006b3c; hover:background:#005c33; color: #ffffff; padding: 16px; border: none; border-radius: 10px; font-size: 18px; font-weight: bold; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 12px rgba(0, 107, 60, 0.2);">🎴 অরিজিনাল এইচডি আইডি কার্ড জেনারেট করুন</button>

    <div id="secure-gate" style="display:none; margin-top: 25px; text-align: center; background: #f0fdf4; padding: 22px; border-radius: 12px; border: 2px dashed #16a34a; box-shadow: 0 4px 15px rgba(22, 163, 74, 0.08);">
        <h3 style="color: #16a34a; margin-top: 0; font-size: 20px;">✅ আইডি কার্ড সফলভাবে তৈরি হয়েছে!</h3>
        <p style="color: #1e293b; font-size:13px; margin-bottom:15px;">ডাউনলোড আনলক করতে নিচে আপনার ভেরিফিকেশন সিকিউরিটি কি (Key) প্রবেশ করুন:</p>
        <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap; align-items:center;">
            <input type="text" id="v2KeyInput" placeholder="Security Key Here" style="padding: 11px 15px; border: 1px solid #16a34a; border-radius: 6px; width: 220px; text-align:center; font-weight:bold; font-size:16px;">
            <button onclick="unlockV2Download()" style="background: #16a34a; color: #fff; padding: 11px 25px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; font-size:14px; transition: background 0.2s;">ভেরিফাই এবং ডাউনলোড করুন</button>
        </div>
        <p style="margin-top:10px; font-size:12px; color:#64748b;">(আপনার কাছে ভেরিফিকেশন কি না থাকলে এডমিনের সাহায্য নিন)</p>
    </div>

    <div id="download-zone" style="display:none; margin-top: 25px; text-align: center; gap: 14px; justify-content: center; flex-wrap: wrap; background:#f8fafc; padding:20px; border-radius:12px; border:1px solid #e2e8f0;">
        <button onclick="downloadImage('frontCanvas', 'NID_Front_Scan')" style="background: #2563eb; color:#fff; border:none; padding:12px 25px; border-radius:6px; font-weight:bold; cursor:pointer; font-size:14px; box-shadow:0 2px 5px rgba(37,99,235,0.2);">📥 ডাউনলোড সামনের পার্ট (Front)</button>
        <button onclick="downloadImage('backCanvas', 'NID_Back_Scan')" style="background: #2563eb; color:#fff; border:none; padding:12px 25px; border-radius:6px; font-weight:bold; cursor:pointer; font-size:14px; box-shadow:0 2px 5px rgba(37,99,235,0.2);">📥 ডাউনলোড পিছনের পার্ট (Back)</button>
        <button onclick="downloadFullScan()" style="background: #ea580c; color:#fff; border:none; padding:12px 25px; border-radius:6px; font-weight:bold; cursor:pointer; font-size:14px; box-shadow:0 2px 5px rgba(234,88,12,0.2);">🖨️ ডাউনলোড ফুল স্ক্যান কপি (A4 Copy)</button>
    </div>
</div>

<!-- Hidden drawing surfaces to render high resolution NID properties -->
<canvas id="frontCanvas" width="1011" height="638" style="display:none; border:1px solid #cbd5e1; border-radius:10px; margin: 20px auto; max-width:100%;"></canvas>
<canvas id="backCanvas" width="1011" height="638" style="display:none; border:1px solid #cbd5e1; border-radius:10px; margin: 20px auto; max-width:100%;"></canvas>
<canvas id="fullCanvas" width="1050" height="1450" style="display:none;"></canvas>

<script>
let cropper;
let signaturePad;
let croppedBlob = null;

// Initialize components
window.addEventListener('load', () => {
    const canvas = document.getElementById('sig-canvas');
    if (canvas) {
        signaturePad = new SignaturePad(canvas, {
            penColor: 'rgb(0, 0, 150)',
            minWidth: 1.5,
            maxWidth: 4.0
        });
    }
    
    const fileInput = document.getElementById('imageInput');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (!e.target.files || e.target.files.length === 0) return;
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('crop-container').style.display = 'block';
                const img = document.getElementById('crop-image');
                img.src = event.target.result;
                if(cropper) cropper.destroy();
                cropper = new Cropper(img, { 
                    aspectRatio: 3/4, 
                    viewMode: 1,
                    autoCropArea: 0.9
                });
            };
            reader.readAsDataURL(e.target.files[0]);
        });
    }
});

function applyCrop() {
    if (!cropper) return;
    croppedBlob = cropper.getCroppedCanvas({ width: 450, height: 600 }).toDataURL('image/jpeg', 0.95);
    document.getElementById('crop-container').style.display = 'none';
    document.getElementById('status-text').innerText = "ছবি ক্রপ করা হয়েছে! এবার জেনারেট বাটনে ক্লিক করুন।";
}

function loadImage(src) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = "anonymous";
        img.onload = () => resolve(img);
        img.onerror = (e) => reject(e);
        img.src = src;
    });
}

async function startNIDGenerationV2() {
    if(!croppedBlob) { 
        alert("প্রথমে আপনার ছবি আপলোড করে ক্রপ করুন!"); 
        return; 
    }
    
    const statusText = document.getElementById('status-text');
    const genBtn = document.getElementById('genBtn');
    
    statusText.style.color = "#d97706";
    statusText.innerText = "প্রসেসিং হচ্ছে... AI ব্যাকগ্রাউন্ড রিমুভ ও লকিং সিস্টেম একটিভেট করা হচ্ছে।";
    genBtn.disabled = true;
    
    try {
        // Load background templates directly from the same self-contained folder
        const templateFrontUrl = '<?php echo plugin_dir_url( __FILE__ ) . "template.png"; ?>';
        const templateBackUrl = '<?php echo plugin_dir_url( __FILE__ ) . "template-back.png"; ?>';
        
        const templateFront = await loadImage(templateFrontUrl);
        const templateBack = await loadImage(templateBackUrl);
        const userImg = await loadImage(croppedBlob);

        // 1. AI Background Removal (BodyPix)
        statusText.innerText = "এআই প্রযুক্তির মাধ্যমে ব্যাকগ্রাউন্ড মুছে ফেলা হচ্ছে...";
        const net = await bodyPix.load();
        const segmentation = await net.segmentPerson(userImg);
        
        const photoCanvas = document.createElement('canvas');
        photoCanvas.width = userImg.width; 
        photoCanvas.height = userImg.height;
        const pCtx = photoCanvas.getContext('2d');
        pCtx.drawImage(userImg, 0, 0);
        
        const imgData = pCtx.getImageData(0,0,photoCanvas.width,photoCanvas.height);
        for(let i=0; i<segmentation.data.length; i++) {
            if(segmentation.data[i]===0) {
                imgData.data[i*4+3]=0; // Make background transparent
            }
        }
        pCtx.putImageData(imgData,0,0);

        statusText.innerText = "এইচডি কোয়ালিটি লেআউটে কার্ড रেন্ডার করা হচ্ছে...";

        // 2. Draw Front Side Card
        const fCanvas = document.getElementById('frontCanvas');
        const fCtx = fCanvas.getContext('2d');
        fCtx.clearRect(0, 0, 1011, 638);
        fCtx.drawImage(templateFront, 0, 0, 1011, 638);
        
        // Draw user photo
        fCtx.save();
        fCtx.globalAlpha = 0.96;
        fCtx.drawImage(photoCanvas, 57, 210, 225, 265); 
        fCtx.restore();

        // Draw Front micro-watermark
        fCtx.save();
        fCtx.globalAlpha = 0.16;
        fCtx.drawImage(photoCanvas, 810, 64, 110, 130);
        fCtx.restore();

        // Draw fields with precise positioning
        fCtx.fillStyle = "#111111";
        
        // Name (Bengali)
        fCtx.font = "bold 44px 'Hind Siliguri', 'SolaimanLipi', Arial";
        fCtx.fillText(document.getElementById('bnName').value, 328, 244);
        
        // Name (English)
        fCtx.font = "bold 31px Arial";
        fCtx.fillText(document.getElementById('enName').value.toUpperCase(), 328, 304);
        
        // Father Name (Bengali)
        fCtx.font = "bold 31px 'Hind Siliguri', 'SolaimanLipi', Arial";
        fCtx.fillText("পিতা: " + document.getElementById('fName').value, 328, 381);
        
        // Mother Name (Bengali)
        fCtx.font = "bold 31px 'Hind Siliguri', 'SolaimanLipi', Arial";
        fCtx.fillText("মাতা: " + document.getElementById('mName').value, 328, 457);
        
        // Date of Birth
        fCtx.font = "bold 31px Arial";
        fCtx.fillText(document.getElementById('dob').value, 485, 519);

        // NID No (Highly visible bold block)
        fCtx.fillStyle = "#000000"; 
        fCtx.font = "900 44px Arial";
        fCtx.fillText(document.getElementById('nidNo').value, 465, 585);

        // Signature
        if (signaturePad && !signaturePad.isEmpty()) {
            const sigImg = await loadImage(signaturePad.toDataURL());
            fCtx.drawImage(sigImg, 55, 515, 185, 65);
        }

        // 3. Draw Back Side Card
        const bCanvas = document.getElementById('backCanvas');
        const bCtx = bCanvas.getContext('2d');
        bCtx.clearRect(0, 0, 1011, 638);
        bCtx.drawImage(templateBack, 0, 0, 1011, 638);

        bCtx.fillStyle = "#1e293b";
        bCtx.font = "bold 18px 'Hind Siliguri', 'SolaimanLipi', Arial";
        
        // Address text composite fields
        const addr = "ঠিকানা: গ্রাম/রাস্তা: " + document.getElementById('village').value + ", ডাকঘর: " + document.getElementById('postOffice').value;
        bCtx.fillText(addr, 45, 175);
        bCtx.fillText(document.getElementById('upazila').value + ", " + document.getElementById('district').value, 45, 205);

        bCtx.font = "bold 16px Arial";
        bCtx.fillText("Blood Group: " + document.getElementById('blood').value, 110, 298); 
        bCtx.fillText(document.getElementById('pob').value, 350, 298);
        bCtx.fillText("Issue Date: " + document.getElementById('issueDate').value, 740, 330); 

        // Back ghost photo watermark
        bCtx.save();
        bCtx.globalAlpha = 0.26;
        bCtx.drawImage(photoCanvas, 865, 170, 110, 130); 
        bCtx.restore();

        // Machine-Readable Zone (MRZ) encoding block - Looks exactly original
        bCtx.fillStyle = "#111111";
        bCtx.font = "bold 35px 'Courier New', monospace";
        const cleanNID = document.getElementById('nidNo').value.replace(/\s/g,'');
        bCtx.fillText(`I<BGD${cleanNID}<<<<<<<<<<<<<<<<`, 50, 490);
        bCtx.fillText(`9902129M3304020BGD<<<<<<<<<<<<<<2`, 50, 540);
        bCtx.fillText(`${document.getElementById('enName').value.toUpperCase().replace(/\s/g,'<')}<<<<<<<<<<<<<<<<<<`, 50, 590);

        statusText.style.color = "#16a34a";
        statusText.innerText = "অভিনন্দন! শতভাগ নিখুঁতভাবে আপনার এইচডি কার্ড জেনারেট সম্পন্ন হয়েছে।";
        
        // Make canvases visually previewed
        fCanvas.style.display = "block";
        bCanvas.style.display = "block";
        
        // Activate verification gate
        document.getElementById('secure-gate').style.display = 'block';
        document.getElementById('download-zone').style.display = 'none';

    } catch (e) {
        statusText.style.color = "#dc2626";
        statusText.innerText = "Error: ভুল হয়েছে! প্রসেসিং সম্পন্ন করতে ব্যর্থ হয়েছে।";
        console.error(e);
    } finally {
        genBtn.disabled = false;
    }
}

function unlockV2Download() {
    const key = document.getElementById('v2KeyInput').value;
    const masterKey = "<?php echo get_option('ibd_nid_unlock_key', 'IBD71'); ?>";
    if(key === masterKey) {
        document.getElementById('secure-gate').style.display = 'none';
        document.getElementById('download-zone').style.display = 'flex';
        alert("সফল হয়েছে! ভেরিফিকেশন সফল হয়েছে এবং ডাউনলোড লিংক আনলক করা হয়েছে।");
    } else { 
        alert("ভুল নিরাপত্তা কি (Security Key)! সঠিক কী প্রবেশ করান।"); 
    }
}

function downloadImage(canvasId, fileName) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const link = document.createElement('a');
    link.download = fileName + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}

async function downloadFullScan() {
    const fCanvas = document.getElementById('frontCanvas');
    const bCanvas = document.getElementById('backCanvas');
    const fullCanvas = document.getElementById('fullCanvas');
    if (!fCanvas || !bCanvas || !fullCanvas) return;
    
    const ctx = fullCanvas.getContext('2d');
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, fullCanvas.width, fullCanvas.height);
    
    ctx.drawImage(fCanvas, 20, 50, 1011, 638);
    ctx.drawImage(bCanvas, 20, 750, 1011, 638);
    
    const link = document.createElement('a');
    link.download = 'NID_Full_Scan_HD.png';
    link.href = fullCanvas.toDataURL('image/png');
    link.click();
}
</script>
