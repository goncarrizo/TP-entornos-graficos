<?php
$featuredNews = array_slice($news, 0, 3);
$statsFlights = 120;
$statsTravelers = 18500;
$statsPunctuality = 92;
$destinationImages = [
  'Bariloche' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?auto=format&fit=crop&w=1200&q=80',
  'Mendoza' => 'https://images.unsplash.com/photo-1602459651957-2f0580f2d0f3?auto=format&fit=crop&w=1200&q=80',
  'Cordoba' => 'https://images.unsplash.com/photo-1599571234909-29ed5d1321d6?auto=format&fit=crop&w=1200&q=80',
  'Rosario' => 'https://images.unsplash.com/photo-1569152811536-fb47aced8409?auto=format&fit=crop&w=1200&q=80',
];

$newsImages = [
  'https://images.unsplash.com/photo-1529074963764-98f45c47344b?auto=format&fit=crop&w=1200&q=80',
  'https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?auto=format&fit=crop&w=1200&q=80',
  'https://images.unsplash.com/photo-1530521954074-e64f6810b32d?auto=format&fit=crop&w=1200&q=80',
];
?>

<section class="hero p-4 p-lg-5 mb-4 rounded-4">
  <div class="row align-items-center g-4">
    <div class="col-lg-7">
      <?php if (!empty($user)): ?>
        <p class="hero-kicker mb-2">Bienvenido/a, <?php echo htmlspecialchars($user['name']); ?></p>
      <?php else: ?>
      <p class="hero-kicker mb-2">Compania aerea nacional</p>
      <?php endif; ?>
      <h1 class="display-6 fw-bold mb-3">Vuela mejor con AirARG</h1>
      <p class="lead mb-4">Descubri nuevas rutas, administra tus reservas en segundos y elegi la experiencia de viaje que mejor se adapta a vos.</p>
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-primary btn-with-icon" href="<?php echo BASE_URL; ?>/index.php?page=flights">
          <span class="icon-wrap" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M4 10.5h16M6 6h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm3 10h6"></path></svg></span>
          <span>Buscar vuelos</span>
        </a>
        <a class="btn btn-outline-primary btn-with-icon" href="<?php echo BASE_URL; ?>/index.php?page=login">
          <span class="icon-wrap" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-7 8a7 7 0 0 1 14 0"></path></svg></span>
          <span>Gestionar cuenta</span>
        </a>
      </div>
      <div class="mini-note mt-4">
        <strong>Busqueda rapida:</strong> usa el panel de la derecha para ir directo a resultados y reservar en menos pasos.
      </div>
    </div>
    <div class="col-lg-5">
      <div class="hero-panel card p-3 p-lg-4 h-100">
        <h2 class="h5 mb-2 page-title">Buscar vuelos</h2>
        <p class="text-muted mb-3 page-subtitle">Elegi origen, destino y fecha para encontrar tu vuelo en segundos.</p>
        <form method="get" action="<?php echo BASE_URL; ?>/index.php" class="search-panel needs-validation" novalidate>
          <input type="hidden" name="page" value="flights">
          <div class="mb-2">
            <label for="home_origin" class="form-label">Origen</label>
            <input id="home_origin" name="origin" type="text" class="form-control" placeholder="Ej: Buenos Aires" autocomplete="off">
          </div>
          <div class="mb-2">
            <label for="home_destination" class="form-label">Destino</label>
            <input id="home_destination" name="destination" type="text" class="form-control" placeholder="Ej: Bariloche" autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="home_date" class="form-label">Fecha</label>
            <input id="home_date" name="date" type="date" class="form-control">
          </div>
          <button class="btn btn-primary w-100 btn-with-icon" type="submit">
            <span class="icon-wrap" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"></path></svg></span>
            <span>Buscar ahora</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($user)): ?>
  <section class="mb-4" aria-labelledby="home-personalized-title">
    <h2 id="home-personalized-title" class="h4 section-title">Tu actividad reciente</h2>
    <div class="row g-3">
      <article class="col-lg-6">
        <div class="card p-3 h-100">
          <h3 class="h6 mb-2">Tus vuelos favoritos</h3>
          <?php if (empty($favorite_flights)): ?>
            <p class="text-muted mb-0">Todavia no agregaste vuelos a favoritos.</p>
          <?php else: ?>
            <ul class="mb-0">
              <?php foreach ($favorite_flights as $favorite): ?>
                <li><?php echo htmlspecialchars($favorite['origin']); ?> -> <?php echo htmlspecialchars($favorite['destination']); ?> (<?php echo htmlspecialchars($favorite['airline_name']); ?>)</li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </article>
      <article class="col-lg-6">
        <div class="card p-3 h-100">
          <h3 class="h6 mb-2">Tus ultimas reservas</h3>
          <?php if (empty($recent_reservations)): ?>
            <p class="text-muted mb-0">Aun no registras reservas.</p>
          <?php else: ?>
            <ul class="mb-0">
              <?php foreach ($recent_reservations as $reservation): ?>
                <li>
                  #<?php echo (int) $reservation['id']; ?> - <?php echo htmlspecialchars($reservation['origin']); ?> -> <?php echo htmlspecialchars($reservation['destination']); ?>
                  (<?php echo htmlspecialchars($reservation['status']); ?>)
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </article>
    </div>
  </section>
<?php endif; ?>

<section class="mb-4" aria-label="Metricas destacadas">
  <div class="row g-3">
    <div class="col-6 col-lg-3">
      <article class="metric-card card p-3 h-100">
        <span class="card-icon" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M3 17h18M5 14V7m5 7V5m5 9V9m4 5V4"></path></svg></span>
        <p class="metric-label mb-1">Vuelos semanales</p>
        <p class="metric-value mb-0"><?php echo number_format($statsFlights); ?></p>
      </article>
    </div>
    <div class="col-6 col-lg-3">
      <article class="metric-card card p-3 h-100">
        <span class="card-icon" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4ZM8 13a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm8 8a6 6 0 0 0-12 0m19 0a6 6 0 0 0-5-5.91"></path></svg></span>
        <p class="metric-label mb-1">Pasajeros por mes</p>
        <p class="metric-value mb-0"><?php echo number_format($statsTravelers); ?></p>
      </article>
    </div>
    <div class="col-6 col-lg-3">
      <article class="metric-card card p-3 h-100">
        <span class="card-icon" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M12 3v3m0 12v3m9-9h-3M6 12H3m15.36-6.36-2.12 2.12M7.76 16.24l-2.12 2.12m0-12.72 2.12 2.12m10.6 8.48 2.12 2.12"></path></svg></span>
        <p class="metric-label mb-1">Puntualidad</p>
        <p class="metric-value mb-0"><?php echo $statsPunctuality; ?>%</p>
      </article>
    </div>
    <div class="col-6 col-lg-3">
      <article class="metric-card card p-3 h-100">
        <span class="card-icon" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M3 7h18M3 12h18M3 17h18"></path></svg></span>
        <p class="metric-label mb-1">Aerolineas activas</p>
        <p class="metric-value mb-0"><?php echo count($airlines); ?></p>
      </article>
    </div>
  </div>
</section>

<section class="mb-4" aria-labelledby="airlines-title">
  <h2 id="airlines-title" class="h4 section-title">Aerolineas</h2>
  <div class="row g-3">
    <?php foreach ($airlines as $airline): ?>
      <article class="col-md-4">
        <div class="card h-100 p-3">
          <h3 class="h5 mb-1"><?php echo htmlspecialchars($airline['name']); ?></h3>
          <p class="mb-1"><strong>Codigo:</strong> <?php echo htmlspecialchars($airline['code']); ?></p>
          <p class="mb-0"><strong>Pais:</strong> <?php echo htmlspecialchars($airline['country']); ?></p>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="mb-4" aria-labelledby="destinations-title">
  <h2 id="destinations-title" class="h4 section-title">Destinos destacados</h2>
  <div class="row g-3">
    <article class="col-md-6 col-xl-3">
      <div class="destination-card p-3 h-100">
        <img class="news-cover" src="<?php echo htmlspecialchars($destinationImages['Bariloche']); ?>" alt="Paisaje de Bariloche" loading="lazy">
        <p class="destination-city mb-1">Bariloche</p>
        <p class="mb-0 text-muted">Naturaleza, lagos y rutas patagonicas.</p>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="destination-card p-3 h-100">
        <img class="news-cover" src="<?php echo htmlspecialchars($destinationImages['Mendoza']); ?>" alt="Paisaje de Mendoza" loading="lazy">
        <p class="destination-city mb-1">Mendoza</p>
        <p class="mb-0 text-muted">Montana, gastronomia y escapadas urbanas.</p>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="destination-card p-3 h-100">
        <img class="news-cover" src="<?php echo htmlspecialchars($destinationImages['Cordoba']); ?>" alt="Ciudad de Cordoba" loading="lazy">
        <p class="destination-city mb-1">Cordoba</p>
        <p class="mb-0 text-muted">Conectividad central para viajes de negocio.</p>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="destination-card p-3 h-100">
        <img class="news-cover" src="<?php echo htmlspecialchars($destinationImages['Rosario']); ?>" alt="Costanera de Rosario" loading="lazy">
        <p class="destination-city mb-1">Rosario</p>
        <p class="mb-0 text-muted">Salidas frecuentes con tiempos de embarque rapidos.</p>
      </div>
    </article>
  </div>
</section>

<section class="mb-4" aria-labelledby="destinations-gallery-title">
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
    <h2 id="destinations-gallery-title" class="h4 section-title mb-0">Galeria de destinos</h2>
    <a class="btn btn-outline-primary btn-sm" href="<?php echo BASE_URL; ?>/index.php?page=flights">Ver vuelos a todos los destinos</a>
  </div>
  <div class="row g-3">
    <article class="col-md-6 col-xl-3">
      <div class="dest-gallery-card h-100">
        <img src="<?php echo htmlspecialchars($destinationImages['Bariloche']); ?>" alt="Lago y montanas de Bariloche" loading="lazy">
        <div class="dest-gallery-copy">
          <p class="destination-city mb-1">Bariloche</p>
          <p class="mb-2 text-muted">Ideal para escapadas de invierno y turismo aventura.</p>
          <a class="btn btn-sm btn-primary" href="<?php echo BASE_URL; ?>/index.php?page=flights&destination=Bariloche">Buscar ruta</a>
        </div>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="dest-gallery-card h-100">
        <img src="<?php echo htmlspecialchars($destinationImages['Mendoza']); ?>" alt="Vinedos y montana de Mendoza" loading="lazy">
        <div class="dest-gallery-copy">
          <p class="destination-city mb-1">Mendoza</p>
          <p class="mb-2 text-muted">Rutas para turismo enologico y viajes de relax.</p>
          <a class="btn btn-sm btn-primary" href="<?php echo BASE_URL; ?>/index.php?page=flights&destination=Mendoza">Buscar ruta</a>
        </div>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="dest-gallery-card h-100">
        <img src="<?php echo htmlspecialchars($destinationImages['Cordoba']); ?>" alt="Vista urbana de Cordoba" loading="lazy">
        <div class="dest-gallery-copy">
          <p class="destination-city mb-1">Cordoba</p>
          <p class="mb-2 text-muted">Conexion central para viajes corporativos y eventos.</p>
          <a class="btn btn-sm btn-primary" href="<?php echo BASE_URL; ?>/index.php?page=flights&destination=Cordoba">Buscar ruta</a>
        </div>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="dest-gallery-card h-100">
        <img src="<?php echo htmlspecialchars($destinationImages['Rosario']); ?>" alt="Costa urbana de Rosario" loading="lazy">
        <div class="dest-gallery-copy">
          <p class="destination-city mb-1">Rosario</p>
          <p class="mb-2 text-muted">Salidas frecuentes para viajes cortos y fin de semana.</p>
          <a class="btn btn-sm btn-primary" href="<?php echo BASE_URL; ?>/index.php?page=flights&destination=Rosario">Buscar ruta</a>
        </div>
      </div>
    </article>
  </div>
</section>

<section aria-labelledby="news-title">
  <h2 id="news-title" class="h4 section-title">Ultimas novedades</h2>
  <div class="row g-3">
    <?php foreach ($featuredNews as $index => $item): ?>
      <article class="col-md-4">
        <div class="card h-100 p-3">
          <img class="news-cover" src="<?php echo htmlspecialchars($newsImages[$index % count($newsImages)]); ?>" alt="Imagen relacionada con novedades de vuelos" loading="lazy">
          <h3 class="h6 news-card-title"><?php echo htmlspecialchars($item['title']); ?></h3>
          <p class="news-card-text"><?php echo htmlspecialchars($item['content']); ?></p>
          <small class="text-muted"><?php echo htmlspecialchars($item['created_at']); ?></small>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="cta-banner mt-4 p-4 rounded-4" aria-label="Llamado a la accion final">
  <div class="row g-3 align-items-center">
    <div class="col-lg-8">
      <h2 class="h4 mb-2">Listo para reservar tu proximo vuelo?</h2>
      <p class="mb-0">Ingresa con tu cuenta para ver disponibilidad, confirmar asientos y hacer seguimiento de tus reservas.</p>
    </div>
    <div class="col-lg-4 text-lg-end">
      <a class="btn btn-light fw-semibold" href="<?php echo BASE_URL; ?>/index.php?page=login">Iniciar sesion</a>
    </div>
  </div>
</section>
