<?php
$featuredNews = array_slice($news, 0, 3);
$statsFlights = 120;
$statsTravelers = 18500;
$statsPunctuality = 92;
?>

<section class="hero p-4 p-lg-5 mb-4 rounded-4">
  <div class="row align-items-center g-4">
    <div class="col-lg-7">
      <p class="hero-kicker mb-2">Compania aerea nacional</p>
      <h1 class="display-6 fw-bold mb-3">Vuela mejor con AirARG</h1>
      <p class="lead mb-4">Descubri nuevas rutas, administra tus reservas en segundos y elegi la experiencia de viaje que mejor se adapta a vos.</p>
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-primary" href="<?php echo BASE_URL; ?>/index.php?page=flights">Buscar vuelos</a>
        <a class="btn btn-outline-primary" href="<?php echo BASE_URL; ?>/index.php?page=login">Gestionar cuenta</a>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="hero-panel card p-3 p-lg-4 h-100">
        <h2 class="h5 mb-3">Tu proximo viaje empieza aca</h2>
        <ul class="list-unstyled mb-0 d-grid gap-2">
          <li><strong>Check-in agil:</strong> accede a tu informacion de vuelo de forma rapida.</li>
          <li><strong>Reservas claras:</strong> visualiza estado, fecha y monto total en un solo lugar.</li>
          <li><strong>Gestion por rol:</strong> paneles para clientes, CEO y administracion.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="mb-4" aria-label="Metricas destacadas">
  <div class="row g-3">
    <div class="col-6 col-lg-3">
      <article class="metric-card card p-3 h-100">
        <p class="metric-label mb-1">Vuelos semanales</p>
        <p class="metric-value mb-0"><?php echo number_format($statsFlights); ?></p>
      </article>
    </div>
    <div class="col-6 col-lg-3">
      <article class="metric-card card p-3 h-100">
        <p class="metric-label mb-1">Pasajeros por mes</p>
        <p class="metric-value mb-0"><?php echo number_format($statsTravelers); ?></p>
      </article>
    </div>
    <div class="col-6 col-lg-3">
      <article class="metric-card card p-3 h-100">
        <p class="metric-label mb-1">Puntualidad</p>
        <p class="metric-value mb-0"><?php echo $statsPunctuality; ?>%</p>
      </article>
    </div>
    <div class="col-6 col-lg-3">
      <article class="metric-card card p-3 h-100">
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
        <p class="destination-city mb-1">Bariloche</p>
        <p class="mb-0 text-muted">Naturaleza, lagos y rutas patagonicas.</p>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="destination-card p-3 h-100">
        <p class="destination-city mb-1">Mendoza</p>
        <p class="mb-0 text-muted">Montana, gastronomia y escapadas urbanas.</p>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="destination-card p-3 h-100">
        <p class="destination-city mb-1">Cordoba</p>
        <p class="mb-0 text-muted">Conectividad central para viajes de negocio.</p>
      </div>
    </article>
    <article class="col-md-6 col-xl-3">
      <div class="destination-card p-3 h-100">
        <p class="destination-city mb-1">Rosario</p>
        <p class="mb-0 text-muted">Salidas frecuentes con tiempos de embarque rapidos.</p>
      </div>
    </article>
  </div>
</section>

<section aria-labelledby="news-title">
  <h2 id="news-title" class="h4 section-title">Ultimas novedades</h2>
  <div class="row g-3">
    <?php foreach ($featuredNews as $item): ?>
      <article class="col-md-4">
        <div class="card h-100 p-3">
          <h3 class="h6"><?php echo htmlspecialchars($item['title']); ?></h3>
          <p><?php echo htmlspecialchars($item['content']); ?></p>
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
