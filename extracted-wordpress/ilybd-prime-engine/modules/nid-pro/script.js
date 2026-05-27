let signaturePad;

// পেজ লোড হওয়ার পর সিগনেচার প্যাড ইনিশিয়েট করা
window.addEventListener('load', () => {
    const sigCanvas = document.getElementById('sig-canvas');
    if (sigCanvas) {
        signaturePad = new SignaturePad(sigCanvas);
    }
});

// ইমেজ লোড করার হেল্পার ফাংশন
function loadImage(src) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = "anonymous";
        img.onload = () => resolve(img);
        img.onerror = (e) => reject(e);
        img.src = src;
    });
}

async function startNIDGeneration() {
    // index.php থেকে ক্রপ করা ইমেজের ডাটা চেক করা
    if (typeof croppedBlob === 'undefined' || !croppedBlob) {
        alert("প্রথমে আপনার ছবি আপলোড ও ক্রপ করুন!");
        return;
    }

    const status = document.getElementById('status-text');
    const genBtn = document.getElementById('genBtn');
    
    status.innerText = "এআই প্রসেসিং হচ্ছে... দয়া করে অপেক্ষা করুন।";
    genBtn.disabled = true;

    try {
        // index.php থেকে ডাইনামিক পাথ নেওয়া
        const templateFrontUrl = ibd_nid_assets.templateFront;
        const templateBackUrl = ibd_nid_assets.templateBack;

        const templateFront = await loadImage(templateFrontUrl);
        const templateBack = await loadImage(templateBackUrl);
        const userImg = await loadImage(croppedBlob);

        // ১. এআই ব্যাকগ্রাউন্ড রিমুভাল (BodyPix)
        const net = await bodyPix.load();
        const segmentation = await net.segmentPerson(userImg);
        
        const photoCanvas = document.createElement('canvas');
        photoCanvas.width = userImg.width;
        photoCanvas.height = userImg.height;
        const pCtx = photoCanvas.getContext('2d');
        pCtx.drawImage(userImg, 0, 0);
        
        const imgData = pCtx.getImageData(0, 0, photoCanvas.width, photoCanvas.height);
        for (let i = 0; i < segmentation.data.length; i++) {
            if (segmentation.data[i] === 0) {
                imgData.data[i * 4 + 3] = 0; // ব্যাকগ্রাউন্ড ট্রান্সপারেন্ট করা
            }
        }
        pCtx.putImageData(imgData, 0, 0);

        // ২. ফ্রন্ট সাইড রেন্ডারিং
        const fCanvas = document.getElementById('frontCanvas');
        const fCtx = fCanvas.getContext('2d');
        fCtx.clearRect(0, 0, 1011, 638);
        fCtx.drawImage(templateFront, 0, 0, 1011, 638);
        
        // মূল ছবি প্লেসমেন্ট
        fCtx.save();
        fCtx.globalAlpha = 0.95;
        fCtx.drawImage(photoCanvas, 57, 210, 225, 265); 
        fCtx.restore();

        // জলছাপ (Watermark)
        fCtx.save();
        fCtx.globalAlpha = 0.15;
        fCtx.drawImage(photoCanvas, 810, 64, 110, 130);
        fCtx.restore();

        // তথ্য লেখা (বাংলা ও ইংরেজি)
        fCtx.fillStyle = "#1a1a1a";
        fCtx.font = "bold 43px 'Hind Siliguri'";
        fCtx.fillText(document.getElementById('bnName').value, 328, 244);
        
        fCtx.font = "bold 31px Arial";
        fCtx.fillText(document.getElementById('enName').value.toUpperCase(), 328, 304);
        
        fCtx.font = "bold 31px 'Hind Siliguri'";
        fCtx.fillText("পিতা: " + document.getElementById('fName').value, 328, 381);
        fCtx.fillText("মাতা: " + document.getElementById('mName').value, 328, 457);
        
        fCtx.font = "bold 31px Arial";
        fCtx.fillText(document.getElementById('dob').value, 485, 519);

        fCtx.fillStyle = "#000"; 
        fCtx.font = "900 44px Arial";
        fCtx.fillText(document.getElementById('nidNo').value, 465, 585);

        // স্বাক্ষর যুক্ত করা
        if (!signaturePad.isEmpty()) {
            const sigImg = await loadImage(signaturePad.toDataURL());
            fCtx.drawImage(sigImg, 55, 515, 185, 65);
        }

        // ৩. ব্যাক সাইড রেন্ডারিং
        const bCanvas = document.getElementById('backCanvas');
        const bCtx = bCanvas.getContext('2d');
        bCtx.clearRect(0, 0, 1011, 638);
        bCtx.drawImage(templateBack, 0, 0, 1011, 638);

        bCtx.fillStyle = "#1a1a1a";
        bCtx.font = "bold 18px 'Hind Siliguri'";
        const addr = "ঠিকানা: গ্রাম/রাস্তা: " + document.getElementById('village').value + ", ডাকঘর: " + document.getElementById('postOffice').value;
        bCtx.fillText(addr, 45, 175);
        bCtx.fillText(document.getElementById('upazila').value + ", " + document.getElementById('district').value, 45, 205);

        bCtx.font = "bold 16px Arial";
        bCtx.fillText("Blood Group " + document.getElementById('blood').value, 110, 298); 
        bCtx.fillText(document.getElementById('pob').value, 350, 298);
        bCtx.fillText("Issue Date: " + document.getElementById('issueDate').value, 740, 330); 

        // ব্যাক সাইডে ঘোস্ট ফটো
        bCtx.save();
        bCtx.globalAlpha = 0.25;
        bCtx.drawImage(photoCanvas, 865, 170, 110, 130); 
        bCtx.restore();

        // MRZ লজিক (অটোমেটিক টেক্সট জেনারেশন)
        bCtx.font = "bold 35px 'Courier New', monospace";
        const cleanNID = document.getElementById('nidNo').value.replace(/\s/g,'');
        bCtx.fillText(`I<BGD${cleanNID}<<<<<<<<<<<<<<<<`, 50, 490);
        bCtx.fillText(`9902129M3304020BGD<<<<<<<<<<<<<<2`, 50, 540);
        bCtx.fillText(`${document.getElementById('enName').value.toUpperCase().replace(/\s/g,'<')}<<<<<<<<<<<<<<<<<<`, 50, 590);

        status.innerText = "অভিনন্দন! কার্ড তৈরি সম্পন্ন হয়েছে।";
        fCanvas.style.display = "block";
        bCanvas.style.display = "block";
        document.querySelectorAll('.download-btn').forEach(btn => btn.style.display = 'block');

    } catch (error) {
        status.innerText = "এরর: প্রসেসিং ব্যর্থ হয়েছে!";
        console.error(error);
    } finally {
        genBtn.disabled = false;
    }
}

// ডাউনলোড ফাংশন
function downloadImage(canvasId, fileName) {
    const canvas = document.getElementById(canvasId);
    const link = document.createElement('a');
    link.download = fileName + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}

async function downloadFullScan() {
    const fCanvas = document.getElementById('frontCanvas');
    const bCanvas = document.getElementById('backCanvas');
    const fullCanvas = document.getElementById('fullCanvas');
    const ctx = fullCanvas.getContext('2d');
    
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, fullCanvas.width, fullCanvas.height);
    
    ctx.drawImage(fCanvas, 20, 50, 1011, 638);
    ctx.drawImage(bCanvas, 20, 750, 1011, 638);
    
    const link = document.createElement('a');
    link.download = 'NID_Full_Scan.png';
    link.href = fullCanvas.toDataURL('image/png');
    link.click();
}
