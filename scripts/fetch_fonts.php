<?php
// Descarga woff2 de Google Fonts CSS y guarda localmente en xampp_php/public/assets/fonts/
// Uso: php scripts/fetch_fonts.php
$families = [
    'Barlow:wght@500;600;700;800',
    'Fraunces:ital,wght@0,600;0,700',
];
$outDir = __DIR__ . '/../xampp_php/public/assets/fonts/';
if (!is_dir($outDir)) mkdir($outDir, 0755, true);
$ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36';
foreach ($families as $family) {
    $cssUrl = 'https://fonts.googleapis.com/css2?family=' . urlencode($family) . '&display=swap';
    echo "Fetching CSS: $cssUrl\n";
    $opts = ['http' => ['header' => "User-Agent: $ua\r\n", 'timeout' => 15]];
    $css = @file_get_contents($cssUrl, false, stream_context_create($opts));
    if (!$css) { echo "Failed to fetch CSS for $family\n"; continue; }
    // Extract woff2 URLs
    if (preg_match_all('/url\((https:\/\/[^)]+\.woff2)\)/i', $css, $m)) {
        foreach (array_unique($m[1]) as $url) {
            $parts = parse_url($url);
            $basename = basename($parts['path']);
            $outPath = $outDir . $basename;
            if (file_exists($outPath)) { echo "$basename already exists, skipping\n"; continue; }
            echo "Downloading font $url -> $basename\n";
            $data = @file_get_contents($url, false, stream_context_create($opts));
            if ($data) {
                file_put_contents($outPath, $data);
                echo "Saved $outPath\n";
            } else {
                echo "Failed to download $url\n";
            }
        }
    } else {
        echo "No woff2 URLs found in CSS for $family\n";
    }
}
echo "Done.\n";
