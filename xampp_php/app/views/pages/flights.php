<section aria-labelledby="flight-search-title" class="mb-4">
  <nav class="breadcrumb-air" aria-label="Breadcrumb">
    <a href="<?php echo BASE_URL; ?>/index.php?page=home">Home</a>
    <span>/</span>
    <span aria-current="page">Vuelos</span>
  </nav>
  <h1 id="flight-search-title" class="h4">Busqueda de vuelos</h1>
  <form method="get" action="<?php echo BASE_URL; ?>/index.php" class="card search-filter-card p-3">
    <input type="hidden" name="page" value="flights">
    <div class="row g-2 align-items-end">
      <div class="col-md-3">
        <label for="origin" class="form-label">Origen</label>
        <input id="origin" name="origin" type="text" class="form-control" value="<?php echo htmlspecialchars($origin); ?>">
      </div>
      <div class="col-md-3">
        <label for="destination" class="form-label">Destino</label>
        <input id="destination" name="destination" type="text" class="form-control" value="<?php echo htmlspecialchars($destination); ?>">
      </div>
      <div class="col-md-2">
        <label for="date" class="form-label">Fecha</label>
        <input id="date" name="date" type="date" class="form-control" value="<?php echo htmlspecialchars($date); ?>">
      </div>
      <div class="col-md-2">
        <label for="airline_id" class="form-label">Aerolinea</label>
        <select id="airline_id" name="airline_id" class="form-select">
          <option value="">Todas</option>
          <?php foreach ($airlines as $airline): ?>
            <option value="<?php echo (int) $airline['id']; ?>" <?php echo ((int) ($airline_id ?? 0) === (int) $airline['id']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($airline['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 d-grid">
        <button class="btn btn-primary btn-with-icon" type="submit">
          <span class="icon-wrap" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"></path></svg></span>
          <span>Buscar</span>
        </button>
      </div>
    </div>

    <div class="row g-2 align-items-end mt-1">
      <div class="col-md-3">
        <label for="min_price" class="form-label">Precio minimo</label>
        <input id="min_price" name="min_price" type="number" min="0" step="0.01" class="form-control" value="<?php echo htmlspecialchars((string) ($min_price ?? '')); ?>">
      </div>
      <div class="col-md-3">
        <label for="max_price" class="form-label">Precio maximo</label>
        <input id="max_price" name="max_price" type="number" min="0" step="0.01" class="form-control" value="<?php echo htmlspecialchars((string) ($max_price ?? '')); ?>">
      </div>
      <div class="col-md-2">
        <label for="min_seats" class="form-label">Asientos min.</label>
        <input id="min_seats" name="min_seats" type="number" min="1" class="form-control" value="<?php echo htmlspecialchars((string) ($min_seats ?? '')); ?>">
      </div>
      <div class="col-md-2">
        <label for="max_duration" class="form-label">Duracion max. (min)</label>
        <input id="max_duration" name="max_duration" type="number" min="30" step="10" class="form-control" value="<?php echo htmlspecialchars((string) ($max_duration ?? '')); ?>">
      </div>
      <div class="col-md-2">
        <label for="sort" class="form-label">Orden</label>
        <select id="sort" name="sort" class="form-select">
          <option value="departure_asc" <?php echo ($sort ?? '') === 'departure_asc' ? 'selected' : ''; ?>>Salida mas cercana</option>
          <option value="departure_desc" <?php echo ($sort ?? '') === 'departure_desc' ? 'selected' : ''; ?>>Salida mas lejana</option>
          <option value="price_asc" <?php echo ($sort ?? '') === 'price_asc' ? 'selected' : ''; ?>>Menor precio</option>
          <option value="price_desc" <?php echo ($sort ?? '') === 'price_desc' ? 'selected' : ''; ?>>Mayor precio</option>
          <option value="duration_asc" <?php echo ($sort ?? '') === 'duration_asc' ? 'selected' : ''; ?>>Menor duracion</option>
          <option value="seats_desc" <?php echo ($sort ?? '') === 'seats_desc' ? 'selected' : ''; ?>>Mas asientos</option>
        </select>
      </div>
      <div class="col-md-12 d-grid d-md-block mt-2">
        <a class="btn btn-outline-secondary" href="<?php echo BASE_URL; ?>/index.php?page=flights">Limpiar</a>
      </div>
    </div>
  </form>
</section>

<?php
$destinationImages = [
  'bariloche' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?auto=format&fit=crop&w=1200&q=80',
  'mendoza' => 'https://images.unsplash.com/photo-1602459651957-2f0580f2d0f3?auto=format&fit=crop&w=1200&q=80',
  'cordoba' => 'https://images.unsplash.com/photo-1599571234909-29ed5d1321d6?auto=format&fit=crop&w=1200&q=80',
  'rosario' => 'https://images.unsplash.com/photo-1569152811536-fb47aced8409?auto=format&fit=crop&w=1200&q=80',
  'salta' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=1200&q=80',
  'buenos aires' => 'https://images.unsplash.com/photo-1612294037637-ec328d0e075e?auto=format&fit=crop&w=1200&q=80',
];
?>

<section class="mb-4" aria-labelledby="flight-results-title">
  <h2 id="flight-results-title" class="h5">Resultados</h2>

  <?php if (empty($flights)): ?>
    <div class="empty-state">
      <span class="empty-state-illustration" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false"><path d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"></path></svg>
      </span>
      <h3 class="h6 mb-2">No encontramos vuelos para esos filtros</h3>
      <p class="mb-3">Proba ampliar la fecha, quitar el limite de precio o buscar otra ruta.</p>
      <a class="btn btn-outline-primary" href="<?php echo BASE_URL; ?>/index.php?page=flights">Ver todos los vuelos</a>
    </div>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($flights as $flight): ?>
        <?php
          $destinationKey = strtolower((string) ($flight['destination'] ?? ''));
          $originKey = strtolower((string) ($flight['origin'] ?? ''));
          $flightImage = $destinationImages[$destinationKey] ?? ($destinationImages[$originKey] ?? 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=1200&q=80');
        ?>
        <article class="col-md-6">
          <div class="card flight-card h-100 p-3">
            <div class="flight-card-media" style="background-image: url('<?php echo htmlspecialchars($flightImage); ?>');"></div>
            <div class="chip-row">
              <span class="chip">Vuelo #<?php echo (int) $flight['id']; ?></span>
              <span class="chip"><?php echo (int) round((strtotime($flight['arrival_time']) - strtotime($flight['departure_time'])) / 60); ?> min</span>
            </div>
            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
              <h3 class="h5 mb-0"><?php echo htmlspecialchars($flight['origin']); ?> -> <?php echo htmlspecialchars($flight['destination']); ?></h3>
              <span class="status-badge info"><?php echo (int) $flight['available_seats']; ?> disp.</span>
            </div>
            <p class="mb-1"><strong>Aerolinea:</strong> <?php echo htmlspecialchars($flight['airline_name']); ?></p>
            <p class="mb-1"><strong>Salida:</strong> <?php echo htmlspecialchars($flight['departure_time']); ?></p>
            <p class="mb-2"><span class="price-tag">$<?php echo number_format((float) $flight['price'], 2); ?></span></p>
            <?php if (!empty($flight['promo_title'])): ?>
              <p class="text-success mb-2"><strong>Promo:</strong> <?php echo htmlspecialchars($flight['promo_title']); ?> (<?php echo (float) $flight['discount_percent']; ?>% OFF)</p>
            <?php endif; ?>

            <?php if (is_logged_in()): ?>
              <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=flights" class="mb-2" data-feedback="Actualizando favoritos...">
                <input type="hidden" name="action" value="toggle_favorite">
                <input type="hidden" name="flight_id" value="<?php echo (int) $flight['id']; ?>">
                <?php $isFavorite = in_array((int) $flight['id'], $favorite_ids ?? [], true); ?>
                <button class="btn btn-sm <?php echo $isFavorite ? 'btn-warning' : 'btn-outline-warning'; ?>" type="submit">
                  <?php echo $isFavorite ? 'Quitar favorito' : 'Agregar a favoritos'; ?>
                </button>
              </form>

              <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=flights" class="row g-2 needs-validation" novalidate data-feedback="Procesando reserva...">
                <input type="hidden" name="action" value="reserve">
                <input type="hidden" name="flight_id" value="<?php echo (int) $flight['id']; ?>">
                <div class="col-8">
                  <label for="seats_<?php echo (int) $flight['id']; ?>" class="form-label visually-hidden">Asientos</label>
                  <input id="seats_<?php echo (int) $flight['id']; ?>" type="number" min="1" name="seats" class="form-control" placeholder="Cantidad de asientos" required>
                  <div class="invalid-feedback">Ingresa cantidad valida.</div>
                </div>
                <div class="col-4 d-grid">
                  <button class="btn btn-outline-primary btn-with-icon" type="submit" aria-label="Reservar vuelo <?php echo (int) $flight['id']; ?>">
                    <span class="icon-wrap" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M4 10.5h16M6 6h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm3 10h6"></path></svg></span>
                    <span>Reservar</span>
                  </button>
                </div>
              </form>
            <?php else: ?>
              <a class="btn btn-outline-secondary" href="<?php echo BASE_URL; ?>/index.php?page=login">Inicia sesion para reservar</a>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php if (($pager['total_pages'] ?? 1) > 1): ?>
  <nav aria-label="Paginacion de vuelos" class="pager-nav">
    <div class="pager-summary">Pagina <?php echo (int) $pager['current_page']; ?> de <?php echo (int) $pager['total_pages']; ?></div>
    <ul class="pagination pagination-responsive">
      <li class="page-item <?php echo ($pager['current_page'] <= 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="<?php echo BASE_URL; ?>/index.php?page=flights&p=<?php echo max(1, (int) $pager['current_page'] - 1); ?>&origin=<?php echo urlencode($origin); ?>&destination=<?php echo urlencode($destination); ?>&date=<?php echo urlencode($date); ?>&airline_id=<?php echo urlencode((string) ($airline_id ?? '')); ?>&min_price=<?php echo urlencode((string) ($min_price ?? '')); ?>&max_price=<?php echo urlencode((string) ($max_price ?? '')); ?>&min_seats=<?php echo urlencode((string) ($min_seats ?? '')); ?>&max_duration=<?php echo urlencode((string) ($max_duration ?? '')); ?>&sort=<?php echo urlencode((string) ($sort ?? '')); ?>" aria-label="Pagina anterior">Anterior</a>
      </li>
      <?php for ($i = 1; $i <= $pager['total_pages']; $i++): ?>
        <li class="page-item <?php echo $i === $pager['current_page'] ? 'active' : ''; ?>">
          <a class="page-link" href="<?php echo BASE_URL; ?>/index.php?page=flights&p=<?php echo $i; ?>&origin=<?php echo urlencode($origin); ?>&destination=<?php echo urlencode($destination); ?>&date=<?php echo urlencode($date); ?>&airline_id=<?php echo urlencode((string) ($airline_id ?? '')); ?>&min_price=<?php echo urlencode((string) ($min_price ?? '')); ?>&max_price=<?php echo urlencode((string) ($max_price ?? '')); ?>&min_seats=<?php echo urlencode((string) ($min_seats ?? '')); ?>&max_duration=<?php echo urlencode((string) ($max_duration ?? '')); ?>&sort=<?php echo urlencode((string) ($sort ?? '')); ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item <?php echo ($pager['current_page'] >= $pager['total_pages']) ? 'disabled' : ''; ?>">
        <a class="page-link" href="<?php echo BASE_URL; ?>/index.php?page=flights&p=<?php echo min((int) $pager['total_pages'], (int) $pager['current_page'] + 1); ?>&origin=<?php echo urlencode($origin); ?>&destination=<?php echo urlencode($destination); ?>&date=<?php echo urlencode($date); ?>&airline_id=<?php echo urlencode((string) ($airline_id ?? '')); ?>&min_price=<?php echo urlencode((string) ($min_price ?? '')); ?>&max_price=<?php echo urlencode((string) ($max_price ?? '')); ?>&min_seats=<?php echo urlencode((string) ($min_seats ?? '')); ?>&max_duration=<?php echo urlencode((string) ($max_duration ?? '')); ?>&sort=<?php echo urlencode((string) ($sort ?? '')); ?>" aria-label="Pagina siguiente">Siguiente</a>
      </li>
    </ul>
  </nav>
<?php endif; ?>
