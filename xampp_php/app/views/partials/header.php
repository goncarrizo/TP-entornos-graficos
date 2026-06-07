<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo APP_NAME; ?> - Reservas y gestion de vuelos</title>
  <meta name="description" content="Plataforma de reservas y gestion de vuelos con paneles por rol y busqueda de rutas.">
  <meta name="csrf-token" content="<?php echo htmlspecialchars(csrf_token()); ?>">
  <?php
    $pageParam = $_GET['page'] ?? 'home';
    $canonical = BASE_URL . '/index.php?page=' . $pageParam;
    $ogTitle = APP_NAME . ' - ' . ucfirst($pageParam);
    $ogDescription = 'Plataforma de reservas y gestion de vuelos con paneles por rol y busqueda de rutas.';
    $ogImage = BASE_URL . '/assets/favicon.svg';
  ?>
  <link rel="canonical" href="<?php echo htmlspecialchars($canonical); ?>">
  <meta property="og:site_name" content="<?php echo htmlspecialchars(APP_NAME); ?>">
  <meta property="og:title" content="<?php echo htmlspecialchars($ogTitle); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($ogDescription); ?>">
  <meta property="og:url" content="<?php echo htmlspecialchars($canonical); ?>">
  <meta property="og:image" content="<?php echo htmlspecialchars($ogImage); ?>">
  <link rel="icon" type="image/svg+xml" href="<?php echo BASE_URL; ?>/assets/favicon.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700;800&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" as="style" onload="this.rel='stylesheet'">
  <noscript>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700;800&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
  </noscript>
  <?php
    // Preload local font files when present to improve LCP
    $fontDir = __DIR__ . '/../../public/assets/fonts';
    if (is_dir($fontDir)) {
      $files = scandir($fontDir);
      foreach ($files as $f) {
        if (stripos($f, 'barlow') !== false || stripos($f, 'fraunces') !== false) {
          if (preg_match('/\.woff2$/i', $f)) {
            echo '<link rel="preload" href="' . htmlspecialchars(BASE_URL . '/assets/fonts/' . $f) . '" as="font" type="font/woff2" crossorigin>' . PHP_EOL;
          }
        }
      }
    }
  ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php
    $stylePath = __DIR__ . '/../../../public/assets/css/styles.css';
    $styleVersion = is_file($stylePath) ? (string) filemtime($stylePath) : '1';
  ?>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/styles.css?v=<?php echo htmlspecialchars($styleVersion); ?>">
</head>
<body data-page="<?php echo htmlspecialchars($_GET['page'] ?? 'home'); ?>">
