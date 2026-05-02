<section class="mb-4" aria-labelledby="ceo-title">
  <h1 id="ceo-title" class="h4">Panel CEO</h1>
  <p class="text-muted">ABMC de vuelos y promociones + reportes de ocupacion y ventas.</p>
</section>

<section class="panel-kpis mb-3" aria-label="Resumen rapido del panel CEO">
  <span class="status-badge info">Vuelos: <?php echo count($flights); ?></span>
  <span class="status-badge warning">Promociones: <?php echo count($promotions); ?></span>
  <span class="status-badge success">Aerolineas: <?php echo count($airlines); ?></span>
</section>

<div class="row g-4">
  <section class="col-lg-6" aria-labelledby="flight-ceo-title">
    <div class="card p-3">
      <h2 id="flight-ceo-title" class="h5">1) Crear vuelo</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="row g-2 needs-validation" novalidate>
        <input type="hidden" name="action" value="create_flight">
        <div class="col-md-6">
          <label class="form-label" for="flight_airline">Aerolinea</label>
          <select id="flight_airline" name="airline_id" class="form-select" required>
            <option value="">Seleccionar</option>
            <?php foreach ($airlines as $airline): ?>
              <option value="<?php echo (int) $airline['id']; ?>"><?php echo htmlspecialchars($airline['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6"><label class="form-label" for="flight_price">Precio</label><input id="flight_price" type="number" step="0.01" min="0" name="price" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label" for="flight_origin">Origen</label><input id="flight_origin" name="origin" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label" for="flight_destination">Destino</label><input id="flight_destination" name="destination" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label" for="flight_departure">Salida</label><input id="flight_departure" type="datetime-local" name="departure_time" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label" for="flight_arrival">Llegada</label><input id="flight_arrival" type="datetime-local" name="arrival_time" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label" for="flight_seats">Asientos</label><input id="flight_seats" type="number" min="1" name="total_seats" class="form-control" required></div>
        <div class="col-md-6 d-grid align-self-end"><button class="btn btn-primary" type="submit">Crear vuelo</button></div>
      </form>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="promo-ceo-title">
    <div class="card p-3">
      <h2 id="promo-ceo-title" class="h5">2) Crear promocion</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="create_promotion">
        <div class="mb-2">
          <label class="form-label" for="promo_airline">Aerolinea</label>
          <select id="promo_airline" name="airline_id" class="form-select" required>
            <option value="">Seleccionar</option>
            <?php foreach ($airlines as $airline): ?>
              <option value="<?php echo (int) $airline['id']; ?>"><?php echo htmlspecialchars($airline['name']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-2"><label class="form-label" for="promo_title">Titulo</label><input id="promo_title" name="title" class="form-control" required></div>
        <div class="mb-2"><label class="form-label" for="promo_desc">Descripcion</label><textarea id="promo_desc" name="description" class="form-control" rows="2"></textarea></div>
        <div class="mb-2"><label class="form-label" for="promo_discount">Descuento %</label><input id="promo_discount" type="number" step="0.01" min="1" max="100" name="discount_percent" class="form-control" required></div>
        <button class="btn btn-success" type="submit">Crear promocion</button>
      </form>
    </div>
  </section>

  <section class="col-lg-12" aria-labelledby="flights-list-ceo-title">
    <div class="card p-3">
      <h2 id="flights-list-ceo-title" class="h5">3) ABMC Vuelos</h2>
      <?php if (empty($flights)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay vuelos cargados.</p>
        </div>
      <?php else: ?>
        <?php foreach ($flights as $flight): ?>
          <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="row g-2 border rounded p-2 mb-2">
            <input type="hidden" name="flight_id" value="<?php echo (int) $flight['id']; ?>">
            <div class="col-md-3">
              <select name="airline_id" class="form-select" required>
                <?php foreach ($airlines as $airline): ?>
                  <option value="<?php echo (int) $airline['id']; ?>" <?php echo ((int) $airline['id'] === (int) $flight['airline_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($airline['name']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2"><input name="origin" class="form-control" value="<?php echo htmlspecialchars($flight['origin']); ?>" required></div>
            <div class="col-md-2"><input name="destination" class="form-control" value="<?php echo htmlspecialchars($flight['destination']); ?>" required></div>
            <div class="col-md-2"><input type="datetime-local" name="departure_time" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($flight['departure_time'])); ?>" required></div>
            <div class="col-md-2"><input type="datetime-local" name="arrival_time" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($flight['arrival_time'])); ?>" required></div>
            <div class="col-md-1"><input type="number" step="0.01" name="price" class="form-control" value="<?php echo (float) $flight['price']; ?>" required></div>
            <div class="col-md-2"><input type="number" min="1" name="total_seats" class="form-control" value="<?php echo (int) $flight['total_seats']; ?>" required></div>
            <div class="col-md-8"><small class="text-muted">Disponibles: <span class="status-badge info"><?php echo (int) $flight['available_seats']; ?></span></small></div>
            <div class="col-md-4 d-flex gap-2 justify-content-md-end">
              <button class="btn btn-sm btn-warning" name="action" value="update_flight" type="submit">Editar</button>
              <button class="btn btn-sm btn-danger" name="action" value="delete_flight" type="submit">Eliminar</button>
            </div>
          </form>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="promo-list-ceo-title">
    <div class="card p-3">
      <h2 id="promo-list-ceo-title" class="h5">4) ABMC Promociones</h2>
      <?php if (empty($promotions)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay promociones cargadas.</p>
        </div>
      <?php else: ?>
        <?php foreach ($promotions as $promotion): ?>
          <?php
            $statusClass = 'info';
            if ($promotion['status'] === 'approved') {
                $statusClass = 'success';
            } elseif ($promotion['status'] === 'denied') {
                $statusClass = 'danger';
            }
          ?>
          <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="border rounded p-2 mb-2">
            <input type="hidden" name="promotion_id" value="<?php echo (int) $promotion['id']; ?>">
            <div class="row g-2">
              <div class="col-md-4">
                <select name="airline_id" class="form-select" required>
                  <?php foreach ($airlines as $airline): ?>
                    <option value="<?php echo (int) $airline['id']; ?>" <?php echo ((int) $airline['id'] === (int) $promotion['airline_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($airline['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4"><input name="title" class="form-control" value="<?php echo htmlspecialchars($promotion['title']); ?>" required></div>
              <div class="col-md-2"><input type="number" step="0.01" min="1" max="100" name="discount_percent" class="form-control" value="<?php echo (float) $promotion['discount_percent']; ?>" required></div>
              <div class="col-md-2 form-check align-self-center">
                <input class="form-check-input" type="checkbox" name="is_active" id="active_<?php echo (int) $promotion['id']; ?>" <?php echo (int) $promotion['is_active'] === 1 ? 'checked' : ''; ?>>
                <label class="form-check-label" for="active_<?php echo (int) $promotion['id']; ?>">Activa</label>
              </div>
              <div class="col-12"><textarea name="description" class="form-control" rows="2"><?php echo htmlspecialchars($promotion['description'] ?? ''); ?></textarea></div>
              <div class="col-12 small text-muted">Estado admin: <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($promotion['status']); ?></span></div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-sm btn-warning" name="action" value="update_promotion" type="submit">Editar</button>
                <button class="btn btn-sm btn-danger" name="action" value="delete_promotion" type="submit">Eliminar</button>
              </div>
            </div>
          </form>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="reports-ceo-title">
    <div class="card p-3">
      <h2 id="reports-ceo-title" class="h5">5) Reportes</h2>
      <div class="d-flex flex-wrap gap-2 mb-3">
        <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo">
          <input type="hidden" name="action" value="export_sales_csv_ceo">
          <button class="btn btn-sm btn-outline-primary" type="submit">Exportar ventas CSV</button>
        </form>
        <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo">
          <input type="hidden" name="action" value="export_occupancy_csv_ceo">
          <button class="btn btn-sm btn-outline-primary" type="submit">Exportar ocupacion CSV</button>
        </form>
      </div>
      <h3 class="h6">Ventas por aerolinea</h3>
      <?php if (empty($sales)): ?>
        <div class="empty-state compact mb-3">
          <p class="mb-0">Sin datos de ventas por ahora.</p>
        </div>
      <?php else: ?>
        <ul>
          <?php foreach ($sales as $row): ?>
            <li><?php echo htmlspecialchars($row['airline']); ?>: $<?php echo number_format((float) $row['total_sales'], 2); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <h3 class="h6">Ocupacion por vuelo</h3>
      <?php if (empty($occupancy)): ?>
        <div class="empty-state compact">
          <p class="mb-0">Sin datos de ocupacion por vuelo.</p>
        </div>
      <?php else: ?>
        <ul>
          <?php foreach ($occupancy as $row): ?>
            <li>Vuelo <?php echo (int) $row['id']; ?>: <?php echo (float) $row['occupancy_percent']; ?>% (<?php echo (int) $row['occupied_seats']; ?>/<?php echo (int) $row['total_seats']; ?>)</li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </section>
</div>
