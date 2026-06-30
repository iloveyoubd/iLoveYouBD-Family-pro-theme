<?php
/**
 * ILYBD Dynamic Gadget & Phone Review Thumbnail Image Generator
 * Generates an ultra-premium cyberpunk / neon style featured image specifically for reviews
 * with the post's title dynamically drawn onto the image canvas.
 * Fully compatible with Google AdSense, SEO Image Indexers, and Open Graph standards.
 */

define('WP_USE_THEMES', false);
$wp_load_path = dirname(__FILE__) . '/../../../../wp-load.php';
if (file_exists($wp_load_path)) {
    require_once($wp_load_path);
} else {
    header('Content-Type: image/png');
    $im = imagecreatetruecolor(800, 420);
    $bg = imagecolorallocate($im, 7, 11, 19);
    imagefill($im, 0, 0, $bg);
    $text_col = imagecolorallocate($im, 255, 255, 255);
    imagestring($im, 5, 20, 20, "ILoveYouBD Device Engine", $text_col);
    imagepng($im);
    imagedestroy($im);
    exit;
}

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
if (!$post_id) {
    render_default_placeholder("iLoveYouBD.com", "Device Review Labs");
    exit;
}

$post = get_post($post_id);
if (!$post || $post->post_type !== 'ilybd_phone_review') {
    render_default_placeholder("iLoveYouBD.com", "Review Not Found");
    exit;
}

$title = get_the_title($post_id);
$title = strip_tags(html_entity_decode($title, ENT_QUOTES, 'UTF-8'));

$fonts_dir = dirname(__FILE__) . '/../assets/fonts';
if (!file_exists($fonts_dir)) {
    mkdir($fonts_dir, 0755, true);
}
$font_path = $fonts_dir . '/HindSiliguri-Bold.ttf';

if (!file_exists($font_path)) {
    $font_url = 'https://raw.githubusercontent.com/google/fonts/main/ofl/hindsiliguri/HindSiliguri-Bold.ttf';
    $font_data = @file_get_contents($font_url, false, stream_context_create([
        'http' => [
            'timeout' => 15,
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.0.0 Safari/537.36'
        ]
    ]));
    if ($font_data) {
        file_put_contents($font_path, $font_data);
    }
}

$width = 1200;
$height = 630;
$im = imagecreatetruecolor($width, $height);

if (function_exists('imagealphablending')) {
    imagealphablending($im, true);
}
if (function_exists('imagesavealpha')) {
    imagesavealpha($im, true);
}

// Emerald Green and Yellow cyberpunk theme
$theme = [
    'primary' => [0, 255, 102],     // Neon Emerald Green
    'accent' => [255, 230, 0],      // Neon Yellow
    'bg' => [6, 25, 18],            // Dark deep green slate
    'bg_gradient' => [3, 11, 8],    // Dark shadow green
    'badge' => 'DEVICE REVIEW LAB'
];

$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$primary_col = imagecolorallocate($im, $theme['primary'][0], $theme['primary'][1], $theme['primary'][2]);
$accent_col = imagecolorallocate($im, $theme['accent'][0], $theme['accent'][1], $theme['accent'][2]);
$gray = imagecolorallocate($im, 120, 155, 135);
$card_bg = imagecolorallocatealpha($im, 4, 15, 10, 25); 

// Background setup
$bg_loaded = false;
if (has_post_thumbnail($post_id)) {
    $orig_url = get_the_post_thumbnail_url($post_id, 'large');
    $image_content = @file_get_contents($orig_url);
    if ($image_content) {
        $bg_img = @imagecreatefromstring($image_content);
        if ($bg_img) {
            $bg_w = imagesx($bg_img);
            $bg_h = imagesy($bg_img);
            $scale = max($width / $bg_w, $height / $bg_h);
            $new_w = ceil($bg_w * $scale);
            $new_h = ceil($bg_h * $scale);
            $dst_x = ceil(($width - $new_w) / 2);
            $dst_y = ceil(($height - $new_h) / 2);
            imagecopyresampled($im, $bg_img, $dst_x, $dst_y, 0, 0, $new_w, $new_h, $bg_w, $bg_h);
            imagedestroy($bg_img);
            $bg_loaded = true;
        }
    }
}

if (!$bg_loaded) {
    // Gradient Background
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = $theme['bg'][0] * (1 - $ratio) + $theme['bg_gradient'][0] * $ratio;
        $g = $theme['bg'][1] * (1 - $ratio) + $theme['bg_gradient'][1] * $ratio;
        $b = $theme['bg'][2] * (1 - $ratio) + $theme['bg_gradient'][2] * $ratio;
        $color = imagecolorallocate($im, $r, $g, $b);
        imageline($im, 0, $y, $width, $y, $color);
    }
    
    // Abstract digital web nodes
    for ($i = 0; $i < $width; $i += 45) {
        $col = imagecolorallocatealpha($im, $theme['primary'][0], $theme['primary'][1], $theme['primary'][2], 120);
        imageline($im, $i, 0, $i, $height, $col);
    }
    for ($j = 0; $j < $height; $j += 45) {
        $col = imagecolorallocatealpha($im, $theme['primary'][0], $theme['primary'][1], $theme['primary'][2], 120);
        imageline($im, 0, $j, $width, $j, $col);
    }
}

// Dim overlay
$overlay = imagecreatetruecolor($width, $height);
$overlay_color = imagecolorallocate($overlay, 3, 11, 8);
imagefill($overlay, 0, 0, $overlay_color);
imagecopymerge($im, $overlay, 0, 0, 0, 0, $width, $height, 42);
imagedestroy($overlay);

// 7. Glass box
$box_x1 = 190;
$box_y1 = 80;
$box_x2 = 1010;
$box_y2 = 550;

imagefilledrectangle($im, $box_x1, $box_y1, $box_x2, $box_y2, $card_bg);

// Brackets
$bracket_len = 35;
$bracket_thickness = 4;
if (function_exists('imagesetthickness')) {
    imagesetthickness($im, $bracket_thickness);
}
imageline($im, $box_x1, $box_y1, $box_x1 + $bracket_len, $box_y1, $primary_col);
imageline($im, $box_x1, $box_y1, $box_x1, $box_y1 + $bracket_len, $primary_col);
imageline($im, $box_x2, $box_y1, $box_x2 - $bracket_len, $box_y1, $primary_col);
imageline($im, $box_x2, $box_y1, $box_x2, $box_y1 + $bracket_len, $primary_col);
imageline($im, $box_x1, $box_y2, $box_x1 + $bracket_len, $box_y2, $primary_col);
imageline($im, $box_x1, $box_y2, $box_x1, $box_y2 - $bracket_len, $primary_col);
imageline($im, $box_x2, $box_y2, $box_x2 - $bracket_len, $box_y2, $primary_col);
imageline($im, $box_x2, $box_y2, $box_x2, $box_y2 - $bracket_len, $primary_col);

if (function_exists('imagesetthickness')) {
    imagesetthickness($im, 1);
}

// Outer boundary line
imagerectangle($im, $box_x1, $box_y1, $box_x2, $box_y2, imagecolorallocatealpha($im, $theme['primary'][0], $theme['primary'][1], $theme['primary'][2], 100));

// Subtle grid scanline detail specifically for the gadget labs
for ($y = $box_y1 + 4; $y < $box_y2; $y += 6) {
    $scan_col = imagecolorallocatealpha($im, $theme['primary'][0], $theme['primary'][1], $theme['primary'][2], 124);
    imageline($im, $box_x1 + 4, $y, $box_x2 - 4, $y, $scan_col);
}

// 8. Texts
$badge_text = strtoupper($theme['badge']);
if (file_exists($font_path)) {
    $badge_box = imagettfbbox(13, 0, $font_path, "⚡ " . $badge_text . " ⚡");
    $badge_w = abs($badge_box[4] - $badge_box[0]);
    $badge_x = ($width - $badge_w) / 2;
    imagettftext($im, 13, 0, $badge_x, 140, $accent_col, $font_path, "⚡ " . $badge_text . " ⚡");
} else {
    $badge_x = ($width - (strlen($badge_text) * 8)) / 2;
    imagestring($im, 4, $badge_x, 125, "[ " . $badge_text . " ]", $accent_col);
}

// Title
$max_text_width = 740;
$title_font_size = 36;

if (file_exists($font_path)) {
    $title_lines = wrap_gadget_text($title_font_size, 0, $font_path, $title, $max_text_width);
    
    if (count($title_lines) > 3) {
        $title_font_size = 28;
        $title_lines = wrap_gadget_text($title_font_size, 0, $font_path, $title, $max_text_width);
    }
    if (count($title_lines) > 4) {
        $title_font_size = 22;
        $title_lines = wrap_gadget_text($title_font_size, 0, $font_path, $title, $max_text_width);
    }

    $line_height = $title_font_size * 1.55;
    $total_block_h = (count($title_lines) - 1) * $line_height + $title_font_size;
    $start_y = 310 - ($total_block_h / 2) + $title_font_size;
    
    foreach ($title_lines as $index => $line) {
        $line_y = $start_y + ($index * $line_height);
        
        $line_box = imagettfbbox($title_font_size, 0, $font_path, $line);
        $line_w = abs($line_box[4] - $line_box[0]);
        $line_x = ($width - $line_w) / 2;
        
        $shadow_col = imagecolorallocatealpha($im, 0, 0, 0, 15);
        for ($sx = -3; $sx <= 3; $sx += 2) {
            for ($sy = -3; $sy <= 3; $sy += 2) {
                imagettftext($im, $title_font_size, 0, $line_x + $sx, $line_y + $sy, $shadow_col, $font_path, $line);
            }
        }
        
        imagettftext($im, $title_font_size, 0, $line_x, $line_y, $white, $font_path, $line);
    }
} else {
    $fallback_lines = explode("\n", wordwrap($title, 40, "\n"));
    $start_y = 250;
    foreach ($fallback_lines as $index => $line) {
        $line_y = $start_y + ($index * 25);
        $line_x = ($width - (strlen($line) * 9)) / 2;
        imagestring($im, 5, $line_x, $line_y, $line, $white);
    }
}

$watermark_text = "ILOVEYOUBD.COM  |  NEXT-GEN HARDWARE LAB";
$sub_watermark = "Verified Performance Benchmark Report Card for Secure Global Indexing";

if (file_exists($font_path)) {
    $wm_box = imagettfbbox(11, 0, $font_path, $watermark_text);
    $wm_w = abs($wm_box[4] - $wm_box[0]);
    $wm_x = ($width - $wm_w) / 2;
    imagettftext($im, 11, 0, $wm_x, 490, $primary_col, $font_path, $watermark_text);
    
    $sub_box = imagettfbbox(9, 0, $font_path, $sub_watermark);
    $sub_w = abs($sub_box[4] - $sub_box[0]);
    $sub_x = ($width - $sub_w) / 2;
    imagettftext($im, 9, 0, $sub_x, 515, $gray, $font_path, $sub_watermark);
} else {
    $wm_x = ($width - (strlen($watermark_text) * 7)) / 2;
    imagestring($im, 3, $wm_x, 480, $watermark_text, $primary_col);
}

// 9. Outer glow frame
$outer_glow = imagecolorallocatealpha($im, $theme['primary'][0], $theme['primary'][1], $theme['primary'][2], 118);
if (function_exists('imagesetthickness')) {
    imagesetthickness($im, 10);
}
imagerectangle($im, 0, 0, $width, $height, $outer_glow);
if (function_exists('imagesetthickness')) {
    imagesetthickness($im, 1);
}

header('Content-Type: image/jpeg');
header('Cache-Control: public, max-age=31536000, must-revalidate');
header('Pragma: public');
imagejpeg($im, null, 94);
imagedestroy($im);

function wrap_gadget_text($fontSize, $angle, $fontFace, $string, $maxWidth) {
    $lines = [];
    $words = explode(" ", $string);
    $currentLine = "";
    
    foreach ($words as $word) {
        $testLine = $currentLine === "" ? $word : $currentLine . " " . $word;
        $testBox = imagettfbbox($fontSize, $angle, $fontFace, $testLine);
        $lineWidth = abs($testBox[4] - $testBox[0]);
        
        if ($lineWidth > $maxWidth && $currentLine !== "") {
            $lines[] = $currentLine;
            $currentLine = $word;
        } else {
            $currentLine = $testLine;
        }
    }
    if ($currentLine !== "") {
        $lines[] = $currentLine;
    }
    return $lines;
}

function render_default_placeholder($title, $subtitle) {
    $w = 1200; $h = 630;
    $im = imagecreatetruecolor($w, $h);
    $bg = imagecolorallocate($im, 7, 11, 19);
    imagefill($im, 0, 0, $bg);
    $primary = imagecolorallocate($im, 0, 255, 102);
    $white = imagecolorallocate($im, 255, 255, 255);
    imagestring($im, 5, 100, 200, $title, $primary);
    imagestring($im, 4, 100, 240, $subtitle, $white);
    header('Content-Type: image/jpeg');
    imagejpeg($im);
    imagedestroy($im);
}
