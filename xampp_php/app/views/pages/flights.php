<section aria-labelledby="flight-search-title" class="mb-4">
  <h1 id="flight-search-title" class="h4">Busqueda de vuelos</h1>
  <form method="get" action="<?php echo BASE_URL; ?>/index.php" class="card p-3">
    <input type="hidden" name="page" value="flights">
    <div class="row g-2 align-items-end">
      <div class="col-md-4">
        <label for="origin" class="form-label">Origen</label>
        <input id="origin" name="origin" type="text" class="form-control" value="<?php echo htmlspecialchars($origin); ?>">
      </div>
      <div class="col-md-4">
        <label for="destination" class="form-label">Destino</label>
        <input id="destination" name="destination" type="text" class="form-control" value="<?php echo htmlspecialchars($destination); ?>">
      </div>
      <div class="col-md-3">
        <label for="date" class="form-label">Fecha</label>
        <input id="date" name="date" type="date" class="form-control" value="<?php echo htmlspecialchars($date); ?>">
      </div>
      <div class="col-md-1 d-grid">
        <button class="btn btn-primary" type="submit">Ir</button>
      </div>
    </div>
  </form>
</section>

<section class="mb-4" aria-labelledby="flight-results-title">
  <h2 id="flight-results-title" class="h5">Resultados</h2>
  <div class="row g-3">
    <?php foreach ($flights as $flight): ?>
      <article class="col-md-6">
        <div class="card h-100 p-3">
          <h3 class="h5"><?php echo htmlspecialchars($flight['origin']); ?> -> <?php echo htmlspecialchars($flight['destination']); ?></h3>
          <p class="mb-1"><strong>Aerolinea:</strong> <?php echo htmlspecialchars($flight['airline_name']); ?></p>
          <p class="mb-1"><strong>Salida:</strong> <?php echo htmlspecialchars($flight['departure_time']); ?></p>
          <p class="mb-1"><strong>Precio:</strong> $<?php echo number_format((float) $flight['price'], 2); ?></p>
          <p class="mb-2"><strong>Asientos:</strong> <?php echo (int) $flight['available_seats']; ?></p>
          <?php if (!empty($flight['promo_title'])): ?>
            <p class="text-success mb-2"><strong>Promo:</strong> <?php echo htmlspecialchars($flight['promo_title']); ?> (<?php echo (float) $flight['discount_percent']; ?>% OFF)</p>
          <?php endif; ?>

          <?php if (is_logged_in()): ?>
            <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=flights" class="row g-2 needs-validation" novalidate>
              <input type="hidden" name="action" value="reserve">
              <input type="hidden" name="flight_id" value="<?php echo (int) $flight['id']; ?>">
              <div class="col-8">
                <label for="seats_<?php echo (int) $flight['id']; ?>" class="form-label visually-hidden">Asientos</label>
                <input id="seats_<?php echo (int) $flight['id']; ?>" type="number" min="1" name="seats" class="form-control" placeholder="Cantidad de asientos" required>
                <div class="invalid-feedback">Ingresa cantidad valida.</div>
              </div>
              <div class="col-4 d-grid">
                <button class="btn btn-outline-primary" type="submit">Reservar</button>
              </div>
            </form>
          <?php else: ?>
            <a class="btn btn-outline-secondary" href="<?php echo BASE_URL; ?>/index.php?page=login">Inicia sesion para reservar</a>
          <?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<?php if (($pager['total_pages'] ?? 1) > 1): ?>
  <nav aria-label="Paginacion de vuelos">
    <ul class="pagination">
      <?php for ($i = 1; $i <= $pager['total_pages']; $i++): ?>
        <li class="page-item <?php echo $i === $pager['current_page'] ? 'active' : ''; ?>">
          <a class="page-link" href="<?php echo BASE_URL; ?>/index.php?page=flights&p=<?php echo $i; ?>&origin=<?php echo urlencode($origin); ?>&destination=<?php echo urlencode($destination); ?>&date=<?php echo urlencode($date); ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
<?php endif; ?>
