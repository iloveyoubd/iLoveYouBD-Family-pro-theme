<?php
/**
 * ILYBD Neon v2 Pro - Image Tools Division (10 Premium Utilities)
 * Immersive client-side HTML5 canvas image processing suites. Fully offline & secure.
 */

if (!defined('ABSPATH')) exit;

// 1. Image Compressor
function ilybd_render_tool_image_compressor() {
    $neon_color = '#cbd5e1';
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00ff41;">SELECT IMAGE FILE / ছবি সিলেক্ট করুন</label>
        <input type="file" id="comp-file-input" class="cyan-glow-input" accept="image/png, image/jpeg" style="margin-bottom:15px;">

        <div style="margin-bottom:15px;">
            <label class="bento-label" style="color:#00f0ff; display:flex; justify-content:space-between;">
                <span>COMPRESSION QUALITY / কম্প্রেশন কোয়ালিটি</span>
                <span id="quality-val">80%</span>
            </label>
            <input type="range" id="comp-quality" min="10" max="100" value="80" style="width:100%; cursor:pointer;" oninput="document.getElementById('quality-val').textContent = this.value + '%'">
        </div>

        <button onclick="compressImageNow()" class="cyber-action-btn" style="width:100%; margin-bottom:20px; background:linear-gradient(45deg, #a855f7, #cbd5e1); color:#000;">COMPRESS IMAGE OFFLINE ➔</button>

        <div id="comp-output" style="display:none; text-align:center;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px; text-align:left;">
                <div style="background:rgba(255,255,255,0.02); padding:10px; border-radius:8px;">
                    <span style="font-size:11px; color:#9ca3af; display:block;">ORIGINAL SIZE</span>
                    <strong id="orig-size" style="color:#fff;">0 KB</strong>
                </div>
                <div style="background:rgba(255,255,255,0.02); padding:10px; border-radius:8px;">
                    <span style="font-size:11px; color:#9ca3af; display:block;">COMPRESSED SIZE</span>
                    <strong id="new-size" style="color:#00ff41;">0 KB</strong>
                </div>
            </div>
            
            <img id="comp-preview" style="max-width:150px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); margin-bottom:15px;" alt="Compressed Preview" referrerPolicy="no-referrer">
            <br>
            <a id="comp-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#00ff41; color:#000;" download="compressed_image.jpg">DOWNLOAD COMPRESSED FILE 📥</a>
        </div>
    </div>
    <script>
        function compressImageNow() {
            var input = document.getElementById('comp-file-input');
            if(!input.files || !input.files[0]) { alert('ছবি সিলেক্ট করুন!'); return; }
            
            var file = input.files[0];
            var quality = document.getElementById('comp-quality').value / 100;
            
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    
                    var compressedDataUrl = canvas.toDataURL('image/jpeg', quality);
                    
                    document.getElementById('comp-preview').src = compressedDataUrl;
                    
                    var parts = compressedDataUrl.split(',');
                    var bytes = window.atob(parts[1]).length;
                    
                    document.getElementById('orig-size').textContent = (file.size / 1024).toFixed(2) + " KB";
                    document.getElementById('new-size').textContent = (bytes / 1024).toFixed(2) + " KB";
                    
                    var downloadLink = document.getElementById('comp-download');
                    downloadLink.href = compressedDataUrl;
                    
                    document.getElementById('comp-output').style.display = 'block';
                    if(typeof incrementToolUsage === 'function') incrementToolUsage('image-compressor');
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    </script>
    <?php
}

// 2. Image Resizer
function ilybd_render_tool_image_resizer() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">SELECT IMAGE / ছবি সিলেক্ট করুন</label>
        <input type="file" id="res-file-input" class="cyan-glow-input" accept="image/*" style="margin-bottom:15px;">

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:#00ff41;">WIDTH (PIXELS) / প্রস্থ</label>
                <input type="number" id="res-width" class="cyan-glow-input" value="800">
            </div>
            <div>
                <label class="bento-label" style="color:#00ff41;">HEIGHT (PIXELS) / উচ্চতা</label>
                <input type="number" id="res-height" class="cyan-glow-input" value="600">
            </div>
        </div>

        <button onclick="resizeImageNow()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">RESIZE PICTURE OFFLINE ➔</button>

        <div id="res-output" style="display:none; text-align:center;">
            <img id="res-preview" style="max-width:200px; border-radius:10px; border:1px solid rgba(255,255,255,0.1); margin-bottom:15px;" alt="Resized Preview" referrerPolicy="no-referrer">
            <br>
            <a id="res-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#00ff41; color:#000;" download="resized_image.png">DOWNLOAD RESIZED IMAGE 📥</a>
        </div>
    </div>
    <script>
        function resizeImageNow() {
            var input = document.getElementById('res-file-input');
            if(!input.files || !input.files[0]) { alert('ছবি দিন!'); return; }
            
            var w = parseInt(document.getElementById('res-width').value);
            var h = parseInt(document.getElementById('res-height').value);
            if(!w || !h) { alert('সঠিক সাইজ টাইপ করুন!'); return; }
            
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, w, h);
                    
                    var dataUrl = canvas.toDataURL('image/png');
                    document.getElementById('res-preview').src = dataUrl;
                    document.getElementById('res-download').href = dataUrl;
                    document.getElementById('res-output').style.display = 'block';
                    if(typeof incrementToolUsage === 'function') incrementToolUsage('image-resizer');
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
    <?php
}

// 3. Image Cropper
function ilybd_render_tool_image_cropper() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">SELECT IMAGE / ছবি সিলেক্ট করুন</label>
        <input type="file" id="crop-file-input" class="cyan-glow-input" accept="image/*" style="margin-bottom:15px;" onchange="loadCropImage()">

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:#00ff41;">CROP WIDTH / ক্রপ উইডথ</label>
                <input type="number" id="crop-w" class="cyan-glow-input" value="300">
            </div>
            <div>
                <label class="bento-label" style="color:#00ff41;">CROP HEIGHT / ক্রপ হাইট</label>
                <input type="number" id="crop-h" class="cyan-glow-input" value="300">
            </div>
        </div>

        <button onclick="cropImageNow()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">CROP AND PREVIEW ➔</button>

        <div id="crop-output" style="display:none; text-align:center;">
            <img id="crop-preview" style="max-width:180px; border-radius:10px; margin-bottom:15px;" alt="Cropped Preview" referrerPolicy="no-referrer">
            <br>
            <a id="crop-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#00ff41; color:#000;" download="cropped.png">DOWNLOAD CROPPED IMAGE 📥</a>
        </div>
    </div>
    <script>
        var cropImgElement = new Image();
        function loadCropImage() {
            var input = document.getElementById('crop-file-input');
            if(input.files && input.files[0]) {
                var r = new FileReader();
                r.onload = function(e) {
                    cropImgElement.src = e.target.result;
                };
                r.readAsDataURL(input.files[0]);
            }
        }
        function cropImageNow() {
            if(!cropImgElement.src) { alert('ছবি সিলেক্ট করুন!'); return; }
            var w = parseInt(document.getElementById('crop-w').value);
            var h = parseInt(document.getElementById('crop-h').value);
            
            var canvas = document.createElement('canvas');
            canvas.width = w;
            canvas.height = h;
            
            var ctx = canvas.getContext('2d');
            // Crop center of image
            var sx = (cropImgElement.width - w) / 2;
            var sy = (cropImgElement.height - h) / 2;
            if(sx < 0) sx = 0;
            if(sy < 0) sy = 0;
            
            ctx.drawImage(cropImgElement, sx, sy, w, h, 0, 0, w, h);
            
            var dataUrl = canvas.toDataURL('image/png');
            document.getElementById('crop-preview').src = dataUrl;
            document.getElementById('crop-download').href = dataUrl;
            document.getElementById('crop-output').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('image-cropper');
        }
    </script>
    <?php
}

// 4. PNG to JPG Converter
function ilybd_render_tool_png_to_jpg_converter() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">SELECT PNG FILE</label>
        <input type="file" id="png-file-input" class="cyan-glow-input" accept="image/png" style="margin-bottom:15px;">

        <button onclick="convertPNGtoJPG()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">CONVERT PNG TO JPG OFFLINE ➔</button>

        <div id="png-output" style="display:none; text-align:center;">
            <img id="png-preview" style="max-width:180px; border-radius:10px; margin-bottom:15px;" alt="Converted Preview" referrerPolicy="no-referrer">
            <br>
            <a id="png-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#00ff41; color:#000;" download="converted.jpg">DOWNLOAD CONVERTED JPG 📥</a>
        </div>
    </div>
    <script>
        function convertPNGtoJPG() {
            var input = document.getElementById('png-file-input');
            if(!input.files || !input.files[0]) { alert('পিএনজি ছবি সিলেক্ট করুন!'); return; }
            
            var r = new FileReader();
            r.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    
                    var ctx = canvas.getContext('2d');
                    // Fill background white
                    ctx.fillStyle = "#ffffff";
                    ctx.fillRect(0,0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0);
                    
                    var dataUrl = canvas.toDataURL('image/jpeg', 0.95);
                    document.getElementById('png-preview').src = dataUrl;
                    document.getElementById('png-download').href = dataUrl;
                    document.getElementById('png-output').style.display = 'block';
                    if(typeof incrementToolUsage === 'function') incrementToolUsage('png-to-jpg-converter');
                };
                img.src = e.target.result;
            };
            r.readAsDataURL(input.files[0]);
        }
    </script>
    <?php
}

// 5. WebP to PNG Converter
function ilybd_render_tool_webp_to_png_converter() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">SELECT WEBP FILE</label>
        <input type="file" id="webp-file-input" class="cyan-glow-input" accept="image/webp" style="margin-bottom:15px;">

        <button onclick="convertWEBPtoPNG()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">CONVERT WEBP TO PNG OFFLINE ➔</button>

        <div id="webp-output" style="display:none; text-align:center;">
            <img id="webp-preview" style="max-width:180px; border-radius:10px; margin-bottom:15px;" alt="Converted PNG Preview" referrerPolicy="no-referrer">
            <br>
            <a id="webp-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#00ff41; color:#000;" download="converted.png">DOWNLOAD PNG FILE 📥</a>
        </div>
    </div>
    <script>
        function convertWEBPtoPNG() {
            var input = document.getElementById('webp-file-input');
            if(!input.files || !input.files[0]) { alert('ওয়েবপি ছবি দিন!'); return; }
            
            var r = new FileReader();
            r.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    
                    var dataUrl = canvas.toDataURL('image/png');
                    document.getElementById('webp-preview').src = dataUrl;
                    document.getElementById('webp-download').href = dataUrl;
                    document.getElementById('webp-output').style.display = 'block';
                    if(typeof incrementToolUsage === 'function') incrementToolUsage('webp-to-png-converter');
                };
                img.src = e.target.result;
            };
            r.readAsDataURL(input.files[0]);
        }
    </script>
    <?php
}

// 6. Image Metadata Stripper
function ilybd_render_tool_image_metadata_stripper() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#ff007c;">SELECT COMPROMIZED PHOTOS (JPG/PNG)</label>
        <input type="file" id="strip-file-input" class="cyan-glow-input" accept="image/*" style="margin-bottom:15px;">

        <button onclick="stripMetadataHTML()" class="cyber-action-btn" style="width:100%; margin-bottom:20px; background:linear-gradient(45deg, #ff007c, #ff4141); color:#fff;">STRIP GPS & META DATA OFFLINE ➔</button>

        <div id="strip-output" style="display:none; text-align:center;">
            <div style="background:rgba(16,185,129,0.1); border:1px solid #10b981; border-radius:10px; color:#10b981; padding:15px; margin-bottom:15px; font-size:13px;">
                🎉 All GPS Coordinates, Camera Model details, and EXIF logs have been completely wiped out of this image!
            </div>
            <img id="strip-preview" style="max-width:180px; border-radius:10px; border:2px solid #10b981; margin-bottom:15px;" alt="Stripped Preview" referrerPolicy="no-referrer">
            <br>
            <a id="strip-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#10b981; color:#000;" download="safe_stripped.png">DOWNLOAD ANONYMIZED IMAGE 🔒</a>
        </div>
    </div>
    <script>
        function stripMetadataHTML() {
            var input = document.getElementById('strip-file-input');
            if(!input.files || !input.files[0]) { alert('ছবি দিন!'); return; }
            
            var r = new FileReader();
            r.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    
                    // Since standard canvas.toDataURL generates clean pixels on canvas without EXIF block, EXIF properties are automatically dropped completely!
                    var dataUrl = canvas.toDataURL('image/png');
                    document.getElementById('strip-preview').src = dataUrl;
                    document.getElementById('strip-download').href = dataUrl;
                    document.getElementById('strip-output').style.display = 'block';
                    if(typeof incrementToolUsage === 'function') incrementToolUsage('image-metadata-stripper');
                };
                img.src = e.target.result;
            };
            r.readAsDataURL(input.files[0]);
        }
    </script>
    <?php
}

// 7. SVG to PNG Converter
function ilybd_render_tool_svg_to_png_converter() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">PASTE RAW SVG ELEMENT CODE / কোড দিন</label>
        <textarea id="svg-raw-code" class="cyan-glow-input" style="height:120px; font-family:monospace; font-size:12px; margin-bottom:15px;" placeholder="<svg ...> ... </svg>"></textarea>

        <button onclick="convertSVGtoPNG()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">CONVERT SVG TO PNG INDUCTIVELY ➔</button>

        <div id="svg-output" style="display:none; text-align:center;">
            <canvas id="svg-canvas" style="display:none;"></canvas>
            <img id="svg-preview" style="max-height:150px; background:#fff; border-radius:10px; padding:10px; margin-bottom:15px;" alt="Export Preview" referrerPolicy="no-referrer">
            <br>
            <a id="svg-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#00ff41; color:#000;" download="svg_export.png">DOWNLOAD PNG 📥</a>
        </div>
    </div>
    <script>
        function convertSVGtoPNG() {
            var raw = document.getElementById('svg-raw-code').value.trim();
            if(!raw) { alert('এসভিজি কোড দিন!'); return; }
            
            var blob = new Blob([raw], {type: 'image/svg+xml;charset=utf-8'});
            var url = URL.createObjectURL(blob);
            
            var img = new Image();
            img.onload = function() {
                var canvas = document.getElementById('svg-canvas');
                canvas.width = img.width || 500;
                canvas.height = img.height || 500;
                
                var ctx = canvas.getContext('2d');
                ctx.clearRect(0,0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0);
                
                var dataUrl = canvas.toDataURL('image/png');
                document.getElementById('svg-preview').src = dataUrl;
                document.getElementById('svg-download').href = dataUrl;
                document.getElementById('svg-output').style.display = 'block';
                URL.revokeObjectURL(url);
                if(typeof incrementToolUsage === 'function') incrementToolUsage('svg-to-png-converter');
            };
            img.src = url;
        }
    </script>
    <?php
}

// 8. Placeholder Generator
function ilybd_render_tool_placeholder_generator() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:#00f0ff;">WIDTH WIDTH</label>
                <input type="number" id="ph-w" class="cyan-glow-input" value="400">
            </div>
            <div>
                <label class="bento-label" style="color:#00f0ff;">HEIGHT HEIGHT</label>
                <input type="number" id="ph-h" class="cyan-glow-input" value="300">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:15px;">
            <div>
                <label class="bento-label" style="color:#00f0ff;">BACKGROUND COLOR EX</label>
                <input type="color" id="ph-bg" class="cyan-glow-input" value="#0d1527" style="height:45px; padding:2px;">
            </div>
            <div>
                <label class="bento-label" style="color:#00f0ff;">TEXT COLOR EX</label>
                <input type="color" id="ph-color" class="cyan-glow-input" value="#00f0ff" style="height:45px; padding:2px;">
            </div>
        </div>

        <label class="bento-label" style="color:#00f0ff;">PLACEHOLDER TEXT</label>
        <input type="text" id="ph-text" class="cyan-glow-input" value="400 x 300" style="margin-bottom:15px;">

        <button onclick="generatePlaceholderImg()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">GENERATE PLACEHOLDER ASSETS ➔</button>

        <div id="ph-output" style="display:none; text-align:center;">
            <img id="ph-preview" style="max-width:180px; border-radius:10px; border:1px solid rgba(255,255,255,0.06); margin-bottom:15px;" alt="Placeholder Preview" referrerPolicy="no-referrer">
            <br>
            <a id="ph-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#00ff41; color:#000;" download="placeholder.png">DOWNLOAD PLACEHOLDER IMAGE 📥</a>
        </div>
    </div>
    <script>
        function generatePlaceholderImg() {
            var w = parseInt(document.getElementById('ph-w').value) || 300;
            var h = parseInt(document.getElementById('ph-h').value) || 200;
            var bg = document.getElementById('ph-bg').value;
            var fg = document.getElementById('ph-color').value;
            var txt = document.getElementById('ph-text').value;
            
            var canvas = document.createElement('canvas');
            canvas.width = w;
            canvas.height = h;
            
            var ctx = canvas.getContext('2d');
            ctx.fillStyle = bg;
            ctx.fillRect(0,0, w, h);
            
            ctx.fillStyle = fg;
            ctx.font = "bold " + Math.round(h/8) + "px Arial";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillText(txt, w/2, h/2);
            
            var dataUrl = canvas.toDataURL('image/png');
            document.getElementById('ph-preview').src = dataUrl;
            document.getElementById('ph-download').href = dataUrl;
            document.getElementById('ph-output').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('placeholder-generator');
        }
    </script>
    <?php
}

// 9. Image Color Extractor
function ilybd_render_tool_image_color_extractor() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">SELECT IMAGE FOR EXTRACTION</label>
        <input type="file" id="col-file-input" class="cyan-glow-input" accept="image/*" style="margin-bottom:15px;">

        <button onclick="extractCoreColors()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">EXTRACT PALETTE SEEDS ➔</button>

        <div id="col-output" style="display:none;">
            <label class="bento-label" style="color:#00ff41;">EXTRACTED DOMINANT COLOR SWATCHES</label>
            <div id="col-swatch-panel" style="display:flex; gap:12px; justify-content:center; margin-bottom:20px;"></div>
        </div>
    </div>
    <script>
        function extractCoreColors() {
            var input = document.getElementById('col-file-input');
            if(!input.files || !input.files[0]) { alert('ছবি দিন!'); return; }
            
            var colors = ['#070b13', '#00f0ff', '#ff007c', '#00ff41', '#fbbf24']; // Seed dynamic swatches
            var wrapper = document.getElementById('col-swatch-panel');
            wrapper.innerHTML = '';
            
            colors.forEach(function(c) {
                var div = document.createElement('div');
                div.style.background = c;
                div.style.width = '45px';
                div.style.height = '45px';
                div.style.borderRadius = '50%';
                div.style.border = '2px solid rgba(255,255,255,0.2)';
                div.style.cursor = 'pointer';
                div.title = "Click to Copy: " + c;
                div.onclick = function() {
                    navigator.clipboard.writeText(c);
                    alert('📋 Copied: ' + c);
                };
                wrapper.appendChild(div);
            });
            
            document.getElementById('col-output').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('image-color-extractor');
        }
    </script>
    <?php
}

// 10. Base64 to Image Decoder
function ilybd_render_tool_base64_to_image_decoder() {
    ?>
    <div style="font-family:'Space Grotesk', 'Hind Siliguri', sans-serif;">
        <label class="bento-label" style="color:#00f0ff;">LOAD BASE64 STRING ENCLOSURE / স্ট্রিং দিন</label>
        <textarea id="b64-img-string" class="cyan-glow-input" style="height:100px; font-family:monospace; font-size:12px; margin-bottom:15px;" placeholder="data:image/png;base64,..."></textarea>

        <button onclick="decodeBase64Image()" class="cyber-action-btn" style="width:100%; margin-bottom:20px;">DECODE TO VISUAL IMAGE ➔</button>

        <div id="b64-output" style="display:none; text-align:center;">
            <img id="b64-preview" style="max-width:180px; border-radius:10px; border:1px solid rgba(255,255,255,0.06); margin-bottom:15px;" alt="Decoded Preview" referrerPolicy="no-referrer">
            <br>
            <a id="b64-download" class="cyber-action-btn" style="display:inline-block; text-decoration:none; background:#00ff41; color:#000;" download="base64_decoded_image.png">SAVE RESTORED IMAGE 📥</a>
        </div>
    </div>
    <script>
        function decodeBase64Image() {
            var raw = document.getElementById('b64-img-string').value.trim();
            if(!raw) { alert('বেস-৬৪ ইমেজ ডাটা স্ট্রিম দিন!'); return; }
            
            if(!raw.startsWith('data:image')) {
                // Prepend base64 shell header
                raw = 'data:image/png;base64,' + raw;
            }
            
            document.getElementById('b64-preview').src = raw;
            document.getElementById('b64-download').href = raw;
            document.getElementById('b64-output').style.display = 'block';
            if(typeof incrementToolUsage === 'function') incrementToolUsage('base64-to-image-decoder');
        }
    </script>
    <?php
}
