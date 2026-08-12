<section class="mb-4" aria-labelledby="ceo-title">
  <h1 id="ceo-title" class="h4">Panel CEO</h1>
  <p class="text-muted">ABMC de vuelos y promociones + reportes de ocupacion y ventas.</p>
</section>

<section class="panel-kpis mb-3" aria-label="Resumen rapido del panel CEO">
  <span class="status-badge info">Vuelos: <?php echo count($flights); ?></span>
  <span class="status-badge warning">Promociones: <?php echo count($promotions); ?></span>
  <span class="status-badge success">Aerolineas: <?php echo count($airlines); ?></span>
  <span class="status-badge secondary">Propuestas: <?php echo count($pendingAirlineRequests); ?></span>
</section>

<div class="row g-4">
  <section class="col-lg-6" aria-labelledby="flight-ceo-title">
    <div class="card p-3">
      <h2 id="flight-ceo-title" class="h5">1) Solicitar nuevo vuelo</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="row g-2 needs-validation" novalidate data-allow-server-validation="1">
        <input type="hidden" name="action" value="create_flight">
        <div class="col-md-6">
          <label class="form-label" for="flight_airline">Aerolinea</label>
          <select id="flight_airline" name="airline_id" class="form-select<?php echo isset($flightErrors['airline_id']) ? ' is-invalid' : ''; ?>" required>
            <option value="">Seleccionar</option>
            <?php foreach ($airlines as $airline): ?>
              <option value="<?php echo (int) $airline['id']; ?>" <?php echo ((string) ($flightOld['airline_id'] ?? '') === (string) (int) $airline['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($airline['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <?php if (isset($flightErrors['airline_id'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightErrors['airline_id'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="flight_price">Precio</label>
          <input id="flight_price" type="number" step="0.01" min="0" name="price" class="form-control<?php echo isset($flightErrors['price']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars((string) ($flightOld['price'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($flightErrors['price'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightErrors['price'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="flight_origin">Origen</label>
          <input id="flight_origin" name="origin" class="form-control<?php echo isset($flightErrors['origin']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($flightOld['origin'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($flightErrors['origin'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightErrors['origin'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="flight_destination">Destino</label>
          <input id="flight_destination" name="destination" class="form-control<?php echo isset($flightErrors['destination']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($flightOld['destination'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($flightErrors['destination'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightErrors['destination'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="flight_departure">Salida</label>
          <input id="flight_departure" type="datetime-local" name="departure_time" class="form-control<?php echo isset($flightErrors['departure_time']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($flightOld['departure_time'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($flightErrors['departure_time'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightErrors['departure_time'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="flight_arrival">Llegada</label>
          <input id="flight_arrival" type="datetime-local" name="arrival_time" class="form-control<?php echo isset($flightErrors['arrival_time']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($flightOld['arrival_time'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($flightErrors['arrival_time'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightErrors['arrival_time'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="flight_seats">Asientos</label>
          <input id="flight_seats" type="number" min="1" name="total_seats" class="form-control<?php echo isset($flightErrors['total_seats']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars((string) ($flightOld['total_seats'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($flightErrors['total_seats'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightErrors['total_seats'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6 d-grid align-self-end"><button class="btn btn-primary" type="submit">Enviar solicitud</button></div>
      </form>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="flight-requests-ceo-title">
    <div class="card p-3">
      <h2 id="flight-requests-ceo-title" class="h5">2) Mis solicitudes de vuelo</h2>
      <?php if (empty($pendingFlightRequests)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No tenes solicitudes de vuelo pendientes.</p>
        </div>
      <?php else: ?>
        <?php foreach ($pendingFlightRequests as $request): ?>
          <?php
            $statusClass = 'info';
            if ($request['status'] === 'approved') {
                $statusClass = 'success';
            } elseif ($request['status'] === 'denied') {
                $statusClass = 'danger';
            }
          ?>
          <div class="border rounded p-2 mb-2">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div>
                <strong><?php echo htmlspecialchars($request['airline_name']); ?></strong>
                <div class="small text-muted"><?php echo htmlspecialchars($request['origin']); ?> → <?php echo htmlspecialchars($request['destination']); ?></div>
                <div class="small text-muted"><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($request['departure_time']))); ?> - <?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($request['arrival_time']))); ?></div>
              </div>
              <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($request['status']); ?></span>
            </div>
            <div class="small mt-2 text-muted">Asientos: <?php echo (int) $request['total_seats']; ?> | Precio: $<?php echo number_format((float) $request['price'], 2); ?></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="reservation-approvals-ceo-title">
    <div class="card p-3">
      <h2 id="reservation-approvals-ceo-title" class="h5">3) Reservas pendientes por aprobar</h2>
      <?php if (empty($pendingReservations)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay reservas pendientes para aprobar.</p>
        </div>
      <?php else: ?>
        <?php foreach ($pendingReservations as $reservation): ?>
          <div class="border rounded p-2 mb-2">
            <div class="row g-2 align-items-center">
              <div class="col-12 col-md-8">
                <strong><?php echo htmlspecialchars($reservation['user_name']); ?></strong>
                <div class="small text-muted">Reserva #<?php echo (int) $reservation['id']; ?> | <?php echo htmlspecialchars($reservation['origin']); ?> → <?php echo htmlspecialchars($reservation['destination']); ?></div>
                <div class="small text-muted">Salida: <?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($reservation['departure_time']))); ?> | Asientos: <?php echo (int) $reservation['seats']; ?></div>
                <div class="small text-muted">Total: $<?php echo number_format((float) $reservation['total_amount'], 2); ?></div>
              </div>
              <div class="col-12 col-md-4 d-flex gap-2 flex-wrap justify-content-md-end">
                <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="d-inline">
                  <input type="hidden" name="action" value="approve_reservation">
                  <input type="hidden" name="reservation_id" value="<?php echo (int) $reservation['id']; ?>">
                  <button class="btn btn-sm btn-success" type="submit">Aprobar</button>
                </form>
                <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="d-inline">
                  <input type="hidden" name="action" value="deny_reservation">
                  <input type="hidden" name="reservation_id" value="<?php echo (int) $reservation['id']; ?>">
                  <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('¿Estás seguro de que deseas denegar esta reserva? Esta acción no se puede deshacer.');">Denegar</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="promo-ceo-title">
    <div class="card p-3">
      <h2 id="promo-ceo-title" class="h5">2) Crear promocion</h2>
      <p class="small text-muted">Las promociones serán enviadas para revisión del administrador. La activación visible al público se efectúa únicamente cuando un administrador las aprueba.</p>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="needs-validation" novalidate data-allow-server-validation="1">
        <input type="hidden" name="action" value="create_promotion">
        <div class="mb-2">
          <label class="form-label" for="promo_airline">Aerolinea</label>
          <select id="promo_airline" name="airline_id" class="form-select<?php echo isset($promotionErrors['airline_id']) ? ' is-invalid' : ''; ?>" required>
            <option value="">Seleccionar</option>
            <?php foreach ($airlines as $airline): ?>
              <option value="<?php echo (int) $airline['id']; ?>" <?php echo ((string) ($promotionOld['airline_id'] ?? '') === (string) (int) $airline['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($airline['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <?php if (isset($promotionErrors['airline_id'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($promotionErrors['airline_id'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="mb-2">
          <label class="form-label" for="promo_title">Titulo</label>
          <input id="promo_title" name="title" class="form-control<?php echo isset($promotionErrors['title']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($promotionOld['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($promotionErrors['title'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($promotionErrors['title'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <div class="mb-2">
          <label class="form-label" for="promo_desc">Descripcion</label>
          <textarea id="promo_desc" name="description" class="form-control" rows="2"><?php echo htmlspecialchars($promotionOld['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="mb-2">
          <label class="form-label" for="promo_discount">Descuento %</label>
          <input id="promo_discount" type="number" step="0.01" min="1" max="100" name="discount_percent" class="form-control<?php echo isset($promotionErrors['discount_percent']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars((string) ($promotionOld['discount_percent'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($promotionErrors['discount_percent'])): ?>
            <div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($promotionErrors['discount_percent'], ENT_QUOTES, 'UTF-8'); ?></div>
          <?php endif; ?>
        </div>
        <button class="btn btn-success" type="submit">Crear promocion</button>
      </form>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="airline-requests-ceo-title">
    <div class="card p-3">
      <h2 id="airline-requests-ceo-title" class="h5">3) Propuestas de nueva aerolinea</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="row g-2 needs-validation" novalidate data-allow-server-validation="1">
        <input type="hidden" name="action" value="create_airline_request">
        <div class="col-md-4">
          <label class="form-label" for="request_airline_name">Nombre</label>
          <input id="request_airline_name" name="name" class="form-control<?php echo isset($airlineRequestErrors['name']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($airlineRequestOld['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($airlineRequestErrors['name'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($airlineRequestErrors['name'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
        </div>
        <div class="col-md-3">
          <label class="form-label" for="request_airline_code">Codigo</label>
          <input id="request_airline_code" name="code" class="form-control<?php echo isset($airlineRequestErrors['code']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($airlineRequestOld['code'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($airlineRequestErrors['code'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($airlineRequestErrors['code'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
        </div>
        <div class="col-md-3">
          <label class="form-label" for="request_airline_country">Pais</label>
          <input id="request_airline_country" name="country" class="form-control<?php echo isset($airlineRequestErrors['country']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($airlineRequestOld['country'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
          <?php if (isset($airlineRequestErrors['country'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($airlineRequestErrors['country'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
        </div>
        <div class="col-md-2 d-grid align-self-end"><button class="btn btn-primary" type="submit">Enviar</button></div>
      </form>

      <?php if (empty($pendingAirlineRequests)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No tenes propuestas de aerolinea pendientes.</p>
        </div>
      <?php else: ?>
        <?php foreach ($pendingAirlineRequests as $request): ?>
          <?php
            $statusClass = 'info';
            if ($request['status'] === 'approved') {
                $statusClass = 'success';
            } elseif ($request['status'] === 'denied') {
                $statusClass = 'danger';
            }
          ?>
          <div class="border rounded p-2 mb-2">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div>
                <strong><?php echo htmlspecialchars($request['name']); ?> (<?php echo htmlspecialchars($request['code']); ?>)</strong>
                <div class="small mt-1 text-muted"><?php echo htmlspecialchars($request['country']); ?></div>
              </div>
              <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($request['status']); ?></span>
            </div>
            <div class="small mt-2 text-muted">Propuesto el <?php echo htmlspecialchars(date('Y-m-d', strtotime($request['created_at']))); ?></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
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
          <?php $flightEditErrors = $flightUpdateErrors[(int) $flight['id']] ?? []; $flightEditOld = $flightUpdateOld[(int) $flight['id']] ?? []; ?>
          <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="row g-2 border rounded p-2 mb-2" data-allow-server-validation="1">
            <input type="hidden" name="flight_id" value="<?php echo (int) $flight['id']; ?>">
            <div class="col-md-3">
              <select name="airline_id" class="form-select<?php echo isset($flightEditErrors['airline_id']) ? ' is-invalid' : ''; ?>" required>
                <?php foreach ($airlines as $airline): ?>
                  <option value="<?php echo (int) $airline['id']; ?>" <?php echo ((string) ($flightEditOld['airline_id'] ?? $flight['airline_id']) === (string) (int) $airline['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($airline['name']); ?></option>
                <?php endforeach; ?>
              </select>
              <?php if (isset($flightEditErrors['airline_id'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightEditErrors['airline_id'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            </div>
            <div class="col-md-2">
              <input name="origin" class="form-control<?php echo isset($flightEditErrors['origin']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($flightEditOld['origin'] ?? $flight['origin'], ENT_QUOTES, 'UTF-8'); ?>" required>
              <?php if (isset($flightEditErrors['origin'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightEditErrors['origin'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            </div>
            <div class="col-md-2">
              <input name="destination" class="form-control<?php echo isset($flightEditErrors['destination']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($flightEditOld['destination'] ?? $flight['destination'], ENT_QUOTES, 'UTF-8'); ?>" required>
              <?php if (isset($flightEditErrors['destination'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightEditErrors['destination'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            </div>
            <div class="col-md-2">
              <input type="datetime-local" name="departure_time" class="form-control<?php echo isset($flightEditErrors['departure_time']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($flightEditOld['departure_time'] ?? date('Y-m-d\TH:i', strtotime($flight['departure_time'])), ENT_QUOTES, 'UTF-8'); ?>" required>
              <?php if (isset($flightEditErrors['departure_time'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightEditErrors['departure_time'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            </div>
            <div class="col-md-2">
              <input type="datetime-local" name="arrival_time" class="form-control<?php echo isset($flightEditErrors['arrival_time']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($flightEditOld['arrival_time'] ?? date('Y-m-d\TH:i', strtotime($flight['arrival_time'])), ENT_QUOTES, 'UTF-8'); ?>" required>
              <?php if (isset($flightEditErrors['arrival_time'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightEditErrors['arrival_time'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            </div>
            <div class="col-md-1">
              <input type="number" step="0.01" name="price" class="form-control<?php echo isset($flightEditErrors['price']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars((string) ($flightEditOld['price'] ?? $flight['price']), ENT_QUOTES, 'UTF-8'); ?>" required>
              <?php if (isset($flightEditErrors['price'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightEditErrors['price'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            </div>
            <div class="col-md-2">
              <input type="number" min="1" name="total_seats" class="form-control<?php echo isset($flightEditErrors['total_seats']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars((string) ($flightEditOld['total_seats'] ?? $flight['total_seats']), ENT_QUOTES, 'UTF-8'); ?>" required>
              <?php if (isset($flightEditErrors['total_seats'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($flightEditErrors['total_seats'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            </div>
            <div class="col-md-8"><small class="text-muted">Disponibles: <span class="status-badge info"><?php echo (int) $flight['available_seats']; ?></span></small></div>
            <div class="col-md-4 d-flex gap-2 justify-content-md-end">
              <button class="btn btn-sm btn-warning" name="action" value="update_flight" type="submit">Editar</button>
              <button class="btn btn-sm btn-danger" name="action" value="delete_flight" type="submit"onclick="return confirm('¿Estás seguro de que deseas eliminar este vuelo? Esta acción no se puede deshacer.');">Eliminar</button>
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
          <?php $promotionEditErrors = $promotionUpdateErrors[(int) $promotion['id']] ?? []; $promotionEditOld = $promotionUpdateOld[(int) $promotion['id']] ?? []; ?>
          <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=ceo" class="border rounded p-2 mb-2" novalidate data-allow-server-validation="1">
            <input type="hidden" name="promotion_id" value="<?php echo (int) $promotion['id']; ?>">
            <div class="row g-2">
              <div class="col-md-4">
                <select name="airline_id" class="form-select<?php echo isset($promotionEditErrors['airline_id']) ? ' is-invalid' : ''; ?>" required>
                  <?php foreach ($airlines as $airline): ?>
                    <option value="<?php echo (int) $airline['id']; ?>" <?php echo ((string) ($promotionEditOld['airline_id'] ?? $promotion['airline_id']) === (string) (int) $airline['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($airline['name']); ?></option>
                  <?php endforeach; ?>
                </select>
                <?php if (isset($promotionEditErrors['airline_id'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($promotionEditErrors['airline_id'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
              </div>
              <div class="col-md-4">
                <input name="title" class="form-control<?php echo isset($promotionEditErrors['title']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($promotionEditOld['title'] ?? $promotion['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($promotionEditErrors['title'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($promotionEditErrors['title'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
              </div>
              <div class="col-md-2">
                <input type="number" step="0.01" min="1" max="100" name="discount_percent" class="form-control<?php echo isset($promotionEditErrors['discount_percent']) ? ' is-invalid' : ''; ?>" value="<?php echo htmlspecialchars((string) ($promotionEditOld['discount_percent'] ?? $promotion['discount_percent']), ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($promotionEditErrors['discount_percent'])): ?><div class="text-danger small mt-1" style="display:block;"><?php echo htmlspecialchars($promotionEditErrors['discount_percent'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
              </div>
              <div class="col-md-2 align-self-center">
                <?php if ((int) $promotion['is_active'] === 1): ?>
                  <div class="small text-success">Activa (solo admin)</div>
                <?php else: ?>
                  <div class="small text-muted">No activa</div>
                <?php endif; ?>
                <div class="small text-muted">Activación requiere aprobación del administrador.</div>
              </div>
              <div class="col-12"><textarea name="description" class="form-control" rows="2"><?php echo htmlspecialchars($promotionEditOld['description'] ?? ($promotion['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea></div>
              <div class="col-12 small text-muted">Estado admin: <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($promotion['status']); ?></span></div>
              <div class="col-12 d-flex gap-2">
                <button class="btn btn-sm btn-warning" name="action" value="update_promotion" type="submit">Editar</button>
                <button class="btn btn-sm btn-danger" name="action" value="delete_promotion" type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta promoción? Esta acción no se puede deshacer.');">Eliminar</button>
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
