<?php
// Script CLI: descarga imágenes remotas y genera WebP si GD está disponible.
// Uso: php scripts/fetch_and_convert_images.php
$images = [
  'bariloche' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?auto=format&fit=crop&w=1200&q=80',
  'mendoza' => 'https://images.unsplash.com/photo-1602459651957-2f0580f2d0f3?auto=format&fit=crop&w=1200&q=80',
  'cordoba' => 'https://images.unsplash.com/photo-1599571234909-29ed5d1321d6?auto=format&fit=crop&w=1200&q=80',
  'rosario' => 'https://images.unsplash.com/photo-1569152811536-fb47aced8409?auto=format&fit=crop&w=1200&q=80',
  'salta' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=1200&q=80',
  'buenos_aires' => 'https://images.unsplash.com/photo-1612294037637-ec328d0e075e?auto=format&fit=crop&w=1200&q=80',
  'news1' => 'https://images.unsplash.com/photo-1529074963764-98f45c47344b?auto=format&fit=crop&w=1200&q=80',
  'news2' => 'https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?auto=format&fit=crop&w=1200&q=80',
  'news3' => 'https://images.unsplash.com/photo-1530521954074-e64f6810b32d?auto=format&fit=crop&w=1200&q=80',
];
$outDir = __DIR__ . '/../xampp_php/public/assets/images/';
if (!is_dir($outDir)) mkdir($outDir, 0755, true);
$timeout = 15;
foreach ($images as $name => $url) {
    $filenameJpg = $outDir . $name . '.jpg';
    $filenameWebp = $outDir . $name . '.webp';
    echo "Downloading $url ...\n";
    $opts = [
        'http' => [
            'method' => 'GET',
            'timeout' => $timeout,
            'header' => "User-Agent: AirARGBot/1.0\r\n"
        ],
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
        ],
    ];
    $context = stream_context_create($opts);
    $data = @file_get_contents($url, false, $context);
    if ($data === false) {
        echo "Failed to download $url\n";
        continue;
    }
    file_put_contents($filenameJpg, $data);
    echo "Saved $filenameJpg\n";
    // Try convert to WebP and AVIF using GD if available
    if (function_exists('imagecreatefromstring')) {
        $im = @imagecreatefromstring($data);
        if ($im !== false) {
            if (function_exists('imagewebp')) {
                imagewebp($im, $filenameWebp, 80);
                echo "Generated $filenameWebp\n";
            } else {
                echo "imagewebp not available\n";
            }
            if (function_exists('imageavif')) {
                $filenameAvif = $outDir . $name . '.avif';
                @imageavif($im, $filenameAvif, 50);
                echo "Generated $filenameAvif\n";
            } else {
                echo "imageavif not available\n";
            }
            if (function_exists('imagedestroy')) imagedestroy($im);
        } else {
            echo "GD could not create image from data for $name\n";
        }
    } else {
        echo "GD not available; skip conversions for $name\n";
    }
}
echo "Done.\n";
