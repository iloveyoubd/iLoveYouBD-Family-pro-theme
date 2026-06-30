<?php
/**
 * ILYBD Dynamic Single SMS Card Image Generator
 * Generates an ultra-premium cyberpunk / neon style graphic for individual SMS cards.
 * Uses dynamic themes (Cyan, Violet, Emerald, Cosmic Amber) based on the SMS index.
 * Fully optimized for Google SEO Image Indexing, core web vitals, and social sharing.
 */

define('WP_USE_THEMES', false);
$wp_load_path = dirname(__FILE__) . '/../../../../wp-load.php';
if (file_exists($wp_load_path)) {
    require_once($wp_load_path);
} else {
    header('Content-Type: image/png');
    $im = imagecreatetruecolor(800, 450);
    $bg = imagecolorallocate($im, 7, 11, 19);
    imagefill($im, 0, 0, $bg);
    $text_col = imagecolorallocate($im, 255, 255, 255);
    imagestring($im, 5, 20, 20, "ILoveYouBD SMS Card Engine", $text_col);
    imagepng($im);
    imagedestroy($im);
    exit;
}

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$sms_index = isset($_GET['sms_index']) ? intval($_GET['sms_index']) : 1;

if (!$post_id) {
    render_card_placeholder("iLoveYouBD.com", "SMS Card Not Found", "Please specify a valid post.");
    exit;
}

$post = get_post($post_id);
if (!$post || $post->post_type !== 'ilybd_sms') {
    render_card_placeholder("iLoveYouBD.com", "Post Not Found", "The requested SMS list does not exist.");
    exit;
}

// Extract SMS text matching the specific index
$content = $post->post_content;
$bn_text = '';
$en_text = '';

// Attempt to parse content exactly like ilybd_parse_and_render_sms_content
$parts = explode('---', $content);
if (count($parts) <= 1) {
    $parts = preg_split('/(?=\d+\.\s*BN:|১\.\s*BN:)/iu', $content);
}

$intro = trim(array_shift($parts)); // discard intro
$found_sms = false;
$current_idx = 1;

foreach ($parts as $part) {
    $part = trim($part);
    if (empty($part)) continue;

    if ($current_idx === $sms_index) {
        // Extract Bengali and English lines using regex
        if (preg_match('/(?:BN:|বাংলা:)\s*(.*?)(?=\s*(?:EN:|ইংরেজি:|$))/ius', $part, $bn_match)) {
            $bn_text = trim($bn_match[1]);
        }
        if (preg_match('/(?:EN:|ইংরেজি:)\s*(.*?)$/ius', $part, $en_match)) {
            $en_text = trim($en_match[1]);
        }

        // Secondary fallback: split lines
        if (empty($bn_text)) {
            $lines = array_filter(array_map('trim', explode("\n", $part)));
            // Filter out purely numeric card label lines
            $lines = array_values(array_filter($lines, function($line) {
                return !preg_match('/^\d+\.?$/u', $line) && !preg_match('/^[১-৯]+\.?$/u', $line);
            }));
            if (count($lines) >= 2) {
                $bn_text = $lines[0];
                $en_text = $lines[1];
            } elseif (count($lines) == 1) {
                $bn_text = $lines[0];
            }
        }

        if (!empty($bn_text)) {
            $bn_text = preg_replace('/^\s*(?:\d+|[১-৯]+)\.?\s*/iu', '', $bn_text);
            $en_text = preg_replace('/^\s*(?:\d+|[১-৯]+)\.?\s*/iu', '', $en_text);
            $found_sms = true;
            break;
        }
    }
    $current_idx++;
}

if (!$found_sms || empty($bn_text)) {
    // If we didn't find the requested index, fallback to first part or title
    $bn_text = get_the_title($post_id);
    $en_text = "Beautiful status from iloveyoubd.com";
}

// Setup typography and font directory
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

// 1200x675 HD 16:9 aspect ratio resolution
$width = 1200;
$height = 675;
$im = imagecreatetruecolor($width, $height);

if (function_exists('imagealphablending')) {
    imagealphablending($im, true);
}
if (function_exists('imagesavealpha')) {
    imagesavealpha($im, true);
}

// Dynamic Premium Cyber Themes based on SMS index (4 variants)
$theme_selection = $sms_index % 4;
switch ($theme_selection) {
    case 1:
        // Theme 1: Neon Cyan (Electric Slate Vibe)
        $primary_rgb = [0, 240, 255];   // Cyan
        $accent_rgb = [0, 255, 102];    // Green
        $bg_start = [8, 19, 31];
        $bg_end = [3, 6, 12];
        $theme_label = "CYBER NEON SERIES";
        break;
    case 2:
        // Theme 2: Cyber Violet (Fuchsia / Purple Dream Vibe)
        $primary_rgb = [217, 70, 239];  // Fuchsia
        $accent_rgb = [0, 240, 255];    // Cyan
        $bg_start = [21, 9, 31];
        $bg_end = [6, 3, 12];
        $theme_label = "COSMIC VIOLET SERIES";
        break;
    case 3:
        // Theme 3: Emerald Matrix (Digital Green Grid Vibe)
        $primary_rgb = [0, 255, 102];   // Emerald Green
        $accent_rgb = [255, 183, 3];    // Amber Gold
        $bg_start = [7, 26, 17];
        $bg_end = [3, 10, 7];
        $theme_label = "EMERALD MATRIX SERIES";
        break;
    case 0:
    default:
        // Theme 4: Cosmic Amber (Warm Neon Solar Flares Vibe)
        $primary_rgb = [255, 75, 43];   // Sunset Red/Orange
        $accent_rgb = [255, 215, 0];    // Bright Gold
        $bg_start = [27, 13, 10];
        $bg_end = [10, 5, 4];
        $theme_label = "COSMIC AMBER SERIES";
        break;
}

// Colors Allocation
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$primary_col = imagecolorallocate($im, $primary_rgb[0], $primary_rgb[1], $primary_rgb[2]);
$accent_col = imagecolorallocate($im, $accent_rgb[0], $accent_rgb[1], $accent_rgb[2]);
$gray = imagecolorallocate($im, 140, 160, 175);
$card_bg = imagecolorallocatealpha($im, 6, 12, 22, 22); // semi-transparent

// 1. Draw Gradient Background
for ($y = 0; $y < $height; $y++) {
    $ratio = $y / $height;
    $r = $bg_start[0] * (1 - $ratio) + $bg_end[0] * $ratio;
    $g = $bg_start[1] * (1 - $ratio) + $bg_end[1] * $ratio;
    $b = $bg_start[2] * (1 - $ratio) + $bg_end[2] * $ratio;
    $color = imagecolorallocate($im, $r, $g, $b);
    imageline($im, 0, $y, $width, $y, $color);
}

// 2. Draw Subtle cyber nodes or grids
for ($i = 0; $i < $width; $i += 60) {
    $col = imagecolorallocatealpha($im, $primary_rgb[0], $primary_rgb[1], $primary_rgb[2], 122);
    imageline($im, $i, 0, $i, $height, $col);
}
for ($j = 0; $j < $height; $j += 60) {
    $col = imagecolorallocatealpha($im, $primary_rgb[0], $primary_rgb[1], $primary_rgb[2], 122);
    imageline($im, 0, $j, $width, $j, $col);
}

// Dim overlay for high contrast
$overlay = imagecreatetruecolor($width, $height);
$overlay_color = imagecolorallocate($overlay, 7, 11, 19);
imagefill($overlay, 0, 0, $overlay_color);
imagecopymerge($im, $overlay, 0, 0, 0, 0, $width, $height, 45);
imagedestroy($overlay);

// 3. Central Glassmorphism Card Coordinates
$box_x1 = 120;
$box_y1 = 80;
$box_x2 = 1080;
$box_y2 = 595;

imagefilledrectangle($im, $box_x1, $box_y1, $box_x2, $box_y2, $card_bg);

// Draw Glowing corners/brackets
$bracket_len = 40;
$bracket_thickness = 5;
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

// Subtle border line around the glassmorphic card
imagerectangle($im, $box_x1, $box_y1, $box_x2, $box_y2, imagecolorallocatealpha($im, $primary_rgb[0], $primary_rgb[1], $primary_rgb[2], 90));

// Decorative target tracker symbol on the side
$cross_col = imagecolorallocatealpha($im, $accent_rgb[0], $accent_rgb[1], $accent_rgb[2], 80);
imageline($im, $box_x1 + 25, $box_y1 + 25, $box_x1 + 45, $box_y1 + 25, $cross_col);
imageline($im, $box_x1 + 35, $box_y1 + 15, $box_x1 + 35, $box_y1 + 35, $cross_col);

// 4. Badge Header (Theme Series Name)
$badge_text = "✉ " . $theme_label . "  |  CARD #" . sprintf('%02d', $sms_index) . " ✉";
if (file_exists($font_path)) {
    $badge_box = imagettfbbox(12, 0, $font_path, $badge_text);
    $badge_w = abs($badge_box[4] - $badge_box[0]);
    $badge_x = ($width - $badge_w) / 2;
    imagettftext($im, 12, 0, $badge_x, 135, $accent_col, $font_path, $badge_text);
} else {
    $badge_x = ($width - (strlen($badge_text) * 8)) / 2;
    imagestring($im, 4, $badge_x, 120, $badge_text, $accent_col);
}

// 5. Draw SMS Texts (Adaptive, Auto-scaling size based on text length)
$max_text_width = 860;
$clean_bn = strip_tags(html_entity_decode($bn_text, ENT_QUOTES, 'UTF-8'));
$clean_en = !empty($en_text) ? strip_tags(html_entity_decode($en_text, ENT_QUOTES, 'UTF-8')) : '';

// Calculate total length
$tot_len = mb_strlen($clean_bn, 'UTF-8') + mb_strlen($clean_en, 'UTF-8');

// Determine appropriate font sizes
if ($tot_len < 100) {
    $bn_font_size = 28;
    $en_font_size = 20;
    $gap = 35;
} elseif ($tot_len < 220) {
    $bn_font_size = 23;
    $en_font_size = 17;
    $gap = 25;
} else {
    $bn_font_size = 18;
    $en_font_size = 14;
    $gap = 18;
}

if (file_exists($font_path)) {
    // Wrap Bengali lines
    $bn_lines = wrap_card_text($bn_font_size, 0, $font_path, $clean_bn, $max_text_width);
    $bn_line_height = $bn_font_size * 1.5;
    $bn_total_h = count($bn_lines) * $bn_line_height;

    // Wrap English lines if present
    $en_lines = [];
    $en_total_h = 0;
    if (!empty($clean_en)) {
        $en_lines = wrap_card_text($en_font_size, 0, $font_path, $clean_en, $max_text_width);
        $en_line_height = $en_font_size * 1.5;
        $en_total_h = count($en_lines) * $en_line_height;
    }

    // Centering calculations
    $total_content_height = $bn_total_h + ($en_total_h ? ($en_total_h + $gap) : 0);
    $current_y = 330 - ($total_content_height / 2);

    // Draw Bengali Lines (Glow/Shadow + Solid Text)
    foreach ($bn_lines as $line) {
        $line_box = imagettfbbox($bn_font_size, 0, $font_path, $line);
        $line_w = abs($line_box[4] - $line_box[0]);
        $line_x = ($width - $line_w) / 2;

        // Soft Bengali shadow
        $shadow_col = imagecolorallocatealpha($im, 0, 0, 0, 15);
        for ($sx = -2; $sx <= 2; $sx += 2) {
            for ($sy = -2; $sy <= 2; $sy += 2) {
                imagettftext($im, $bn_font_size, 0, $line_x + $sx, $current_y + $sy, $shadow_col, $font_path, $line);
            }
        }
        imagettftext($im, $bn_font_size, 0, $line_x, $current_y, $white, $font_path, $line);
        $current_y += $bn_line_height;
    }

    // Draw Divider Line if both Bengali and English are present
    if (!empty($en_lines)) {
        $current_y += $gap - 5;
        $div_y = $current_y - ($gap / 2);
        $div_color = imagecolorallocatealpha($im, 255, 255, 255, 115);
        imageline($im, $box_x1 + 150, $div_y, $box_x2 - 150, $div_y, $div_color);

        // Draw English Lines (Dim gray color)
        foreach ($en_lines as $line) {
            $line_box = imagettfbbox($en_font_size, 0, $font_path, $line);
            $line_w = abs($line_box[4] - $line_box[0]);
            $line_x = ($width - $line_w) / 2;
            imagettftext($im, $en_font_size, 0, $line_x, $current_y, $gray, $font_path, $line);
            $current_y += $en_line_height;
        }
    }
} else {
    // Fallback if TrueType Font is missing
    $fallback_bn = wordwrap($clean_bn, 50, "\n");
    $lines = explode("\n", $fallback_bn);
    $start_y = 220;
    foreach ($lines as $line) {
        $line_x = ($width - (strlen($line) * 9)) / 2;
        imagestring($im, 5, $line_x, $start_y, $line, $white);
        $start_y += 28;
    }
}

// 6. Watermark Branding Footers
$brand_watermark = "ILOVEYOUBD.COM  |  PREMIUM CYBER CONTENT GATEWAY";
$brand_sub = "AdSense Compliant  •  SEO Optimized  •  High-Speed Digital Distribution";

if (file_exists($font_path)) {
    $wm_box = imagettfbbox(11, 0, $font_path, $brand_watermark);
    $wm_w = abs($wm_box[4] - $wm_box[0]);
    $wm_x = ($width - $wm_w) / 2;
    imagettftext($im, 11, 0, $wm_x, 530, $primary_col, $font_path, $brand_watermark);

    $sub_box = imagettfbbox(9, 0, $font_path, $brand_sub);
    $sub_w = abs($sub_box[4] - $sub_box[0]);
    $sub_x = ($width - $sub_w) / 2;
    imagettftext($im, 9, 0, $sub_x, 555, $gray, $font_path, $brand_sub);
} else {
    $wm_x = ($width - (strlen($brand_watermark) * 7)) / 2;
    imagestring($im, 3, $wm_x, 520, $brand_watermark, $primary_col);
}

// 7. Outer glowing neon frame
$outer_glow = imagecolorallocatealpha($im, $primary_rgb[0], $primary_rgb[1], $primary_rgb[2], 115);
if (function_exists('imagesetthickness')) {
    imagesetthickness($im, 12);
}
imagerectangle($im, 0, 0, $width, $height, $outer_glow);
if (function_exists('imagesetthickness')) {
    imagesetthickness($im, 1);
}

header('Content-Type: image/jpeg');
header('Cache-Control: public, max-age=31536000, must-revalidate');
header('Pragma: public');
imagejpeg($im, null, 95);
imagedestroy($im);

/**
 * Custom text wrapping helper for Bengali Unicode characters.
 */
function wrap_card_text($fontSize, $angle, $fontFace, $string, $maxWidth) {
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

function render_card_placeholder($title, $header, $subtitle) {
    $w = 1200; $h = 675;
    $im = imagecreatetruecolor($w, $h);
    $bg = imagecolorallocate($im, 7, 11, 19);
    imagefill($im, 0, 0, $bg);
    $primary = imagecolorallocate($im, 0, 240, 255);
    $white = imagecolorallocate($im, 255, 255, 255);
    imagestring($im, 5, 100, 200, $title, $primary);
    imagestring($im, 5, 100, 240, $header, $white);
    imagestring($im, 4, 100, 280, $subtitle, $white);
    header('Content-Type: image/jpeg');
    imagejpeg($im);
    imagedestroy($im);
}
