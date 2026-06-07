<?php
header('Content-Type: application/xml; charset=utf-8');
require __DIR__ . '/../app/bootstrap.php';

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base = $scheme . '://' . $host . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php';

// Static pages
$static = [
  ['loc' => $base . '?page=home', 'priority' => '1.0'],
  ['loc' => $base . '?page=contact', 'priority' => '0.6'],
  ['loc' => $base . '?page=login', 'priority' => '0.3'],
  ['loc' => $base . '?page=register', 'priority' => '0.3'],
];

// News pagination
$newsPerPage = 5;
$newsTotal = News::countAll();
$newsPages = (int) ceil($newsTotal / $newsPerPage);

// Flights pagination (no filters)
$flightsPerPage = 6;
$flightsTotal = Flight::countFiltered();
$flightsPages = (int) ceil($flightsTotal / $flightsPerPage);

echo '<?xml version="1.0" encoding="UTF-8"?>\n';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php foreach ($static as $s): ?>
  <url>
    <loc><?php echo htmlspecialchars($s['loc']); ?></loc>
    <lastmod><?php echo date('c'); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority><?php echo $s['priority']; ?></priority>
  </url>
  <?php endforeach; ?>

  <?php for ($p = 1; $p <= max(1, $newsPages); $p++): ?>
  <url>
    <loc><?php echo htmlspecialchars($base . '?page=news' . ($p > 1 ? '&p=' . $p : '')); ?></loc>
    <lastmod><?php echo date('c'); ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
  <?php endfor; ?>

  <?php for ($p = 1; $p <= max(1, $flightsPages); $p++): ?>
  <url>
    <loc><?php echo htmlspecialchars($base . '?page=flights' . ($p > 1 ? '&p=' . $p : '')); ?></loc>
    <lastmod><?php echo date('c'); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.7</priority>
  </url>
  <?php endfor; ?>

</urlset>
