<section class="hero p-4 mb-4 rounded-4">
  <h1 class="display-6 fw-bold">Sistema de reservas de vuelos</h1>
  <p class="lead">Plataforma academica profesional para gestionar vuelos, promociones y reservas.</p>
  <a class="btn btn-primary" href="<?php echo BASE_URL; ?>/index.php?page=flights">Explorar vuelos</a>
</section>

<section class="mb-4" aria-labelledby="airlines-title">
  <h2 id="airlines-title" class="h4">Aerolineas</h2>
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

<section aria-labelledby="news-title">
  <h2 id="news-title" class="h4">Ultimas novedades</h2>
  <div class="row g-3">
    <?php foreach (array_slice($news, 0, 3) as $item): ?>
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
