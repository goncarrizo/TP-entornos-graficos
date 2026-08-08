<section class="mb-4" aria-labelledby="admin-title">
  <h1 id="admin-title" class="h4">Panel Administrador</h1>
  <p class="text-muted">Gestion de aerolineas, promociones, novedades y reportes.</p>
</section>

<section class="panel-kpis mb-3" aria-label="Resumen rapido de administracion">
  <span class="status-badge info">Aerolineas: <?php echo count($airlines); ?></span>
  <span class="status-badge warning">Promociones: <?php echo count($promotions); ?></span>
  <span class="status-badge success">Novedades: <?php echo count($news); ?></span>
    <span class="status-badge secondary">Propuestas de aerolinea: <?php echo count($pendingAirlineRequests); ?></span>
    <span class="status-badge secondary">Solicitudes de vuelo: <?php echo count($pendingFlightRequests); ?></span>
    <span class="status-badge secondary">CEOs pendientes: <?php echo count($pendingCEOs ?? []); ?></span>
    <div class="card p-3">
      <h2 id="airlines-admin-title" class="h5">1) ABMC Aerolineas</h2>
      <form class="row g-2 needs-validation mb-3" method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin" novalidate>
        <input type="hidden" name="action" value="create_airline">
        <div class="col-md-4"><label class="form-label" for="airline_name">Nombre</label><input id="airline_name" name="name" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label" for="airline_code">Codigo</label><input id="airline_code" name="code" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label" for="airline_country">Pais</label><input id="airline_country" name="country" class="form-control" required></div>
        <div class="col-md-2 d-grid align-self-end"><button class="btn btn-primary" type="submit">Crear</button></div>
      </form>

      <?php if (empty($airlines)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay aerolineas cargadas.</p>
        </div>
      <?php else: ?>
        <?php foreach ($airlines as $airline): ?>
          <form class="row g-2 border rounded p-2 mb-2" method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin">
            <input type="hidden" name="airline_id" value="<?php echo (int) $airline['id']; ?>">
            <div class="col-md-4"><input name="name" value="<?php echo htmlspecialchars($airline['name']); ?>" class="form-control" required></div>
            <div class="col-md-2"><input name="code" value="<?php echo htmlspecialchars($airline['code']); ?>" class="form-control" required></div>
            <div class="col-md-3"><input name="country" value="<?php echo htmlspecialchars($airline['country']); ?>" class="form-control" required></div>
            <div class="col-md-3 d-flex gap-2">
              <button class="btn btn-sm btn-warning" name="action" value="update_airline" type="submit">Editar</button>
              <button class="btn btn-sm btn-danger" name="action" value="delete_airline" type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta aerolínea? Esta acción no se puede deshacer.');">Eliminar</button>
            </div>
          </form>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="airline-requests-admin-title">
    <div class="card p-3">
      <h2 id="airline-requests-admin-title" class="h5">2) Propuestas de aerolineas</h2>
      <?php if (empty($pendingAirlineRequests)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay propuestas de aerolinea pendientes.</p>
        </div>
      <?php else: ?>
        <?php foreach ($pendingAirlineRequests as $request): ?>
          <form class="border rounded p-2 mb-2" method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin">
            <input type="hidden" name="airline_request_id" value="<?php echo (int) $request['id']; ?>">
            <div>
              <strong><?php echo htmlspecialchars($request['name']); ?> (<?php echo htmlspecialchars($request['code']); ?>)</strong>
              <div class="small text-muted"><?php echo htmlspecialchars($request['country']); ?> — propuesto por <?php echo htmlspecialchars($request['submitted_by_name']); ?></div>
            </div>
            <div class="d-flex gap-2 justify-content-end mt-3">
              <button class="btn btn-sm btn-success" name="action" value="approve_airline_request" type="submit">Aprobar</button>
              <button class="btn btn-sm btn-secondary" name="action" value="deny_airline_request" type="submit" onclick="return confirm('¿Estás seguro de que deseas denegar esta aerolinea? Esta acción no se puede deshacer.');">Denegar</button>
            </div>
          </form>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="pending-ceos-admin-title">
    <div class="card p-3">
      <h2 id="pending-ceos-admin-title" class="h5">CEOs Pendientes de Aprobación</h2>
      <?php if (empty($pendingCEOs)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay CEOs pendientes de aprobación.</p>
        </div>
      <?php else: ?>
        <?php foreach ($pendingCEOs as $ceo): ?>
          <div class="border rounded p-2 mb-2">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div>
                <strong><?php echo htmlspecialchars($ceo['name']); ?></strong>
                <div class="small text-muted"><?php echo htmlspecialchars($ceo['email']); ?></div>
                <div class="small text-muted">Aerolinea: <?php echo htmlspecialchars($ceo['airline_name'] ?? 'Sin asignar'); ?></div>
                <div class="small text-muted">Documento: <?php echo htmlspecialchars($ceo['document_number'] ?? 'No especificado'); ?></div>
                <div class="small text-muted">Solicitado: <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($ceo['created_at']))); ?></div>
              </div>
              <div class="d-flex gap-2 flex-column">
                <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin" style="margin: 0;">
                  <input type="hidden" name="action" value="approve_ceo">
                  <input type="hidden" name="ceo_id" value="<?php echo (int) $ceo['id']; ?>">
                  <button class="btn btn-sm btn-success w-100" type="submit">Aprobar</button>
                </form>
                <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin" style="margin: 0;">
                  <input type="hidden" name="action" value="reject_ceo">
                  <input type="hidden" name="ceo_id" value="<?php echo (int) $ceo['id']; ?>">
                  <button class="btn btn-sm btn-danger w-100" type="submit" onclick="return confirm('¿Estás seguro de que deseas rechazar este ceo? Esta acción no se puede deshacer.');">Rechazar</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="flight-requests-admin-title">
    <div class="card p-3">
      <h2 id="flight-requests-admin-title" class="h5">3) Solicitudes de nuevos vuelos</h2>
      <?php if (empty($pendingFlightRequests)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay solicitudes de vuelo pendientes.</p>
        </div>
      <?php else: ?>
        <?php foreach ($pendingFlightRequests as $request): ?>
          <form class="border rounded p-2 mb-2" method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin">
            <input type="hidden" name="flight_request_id" value="<?php echo (int) $request['id']; ?>">
            <div class="d-flex justify-content-between align-items-start gap-2">
              <div>
                <strong><?php echo htmlspecialchars($request['airline_name']); ?></strong>
                <div class="small text-muted"><?php echo htmlspecialchars($request['origin']); ?> → <?php echo htmlspecialchars($request['destination']); ?> | <?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($request['departure_time']))); ?> - <?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($request['arrival_time']))); ?></div>
                <div class="small text-muted">Asientos: <?php echo (int) $request['total_seats']; ?> | Precio: $<?php echo number_format((float) $request['price'], 2); ?></div>
                <div class="small text-muted">Propuesto por <?php echo htmlspecialchars($request['submitted_by_name']); ?></div>
              </div>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-success" name="action" value="approve_flight_request" type="submit">Aprobar</button>
                <button class="btn btn-sm btn-secondary" name="action" value="deny_flight_request" type="submit" onclick="return confirm('¿Estás seguro de que deseas denegar este vuelvo? Esta acción no se puede deshacer.');">Denegar</button>
              </div>
            </div>
          </form>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="promo-admin-title">
    <div class="card p-3">
      <h2 id="promo-admin-title" class="h5">2) Promociones pendientes</h2>
      <?php
        $pendingPromotions = array_values(array_filter(
            $promotions,
            static fn(array $promotion): bool => ($promotion['status'] ?? '') === 'pending'
        ));
      ?>
      <?php if (empty($pendingPromotions)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay promociones para revisar.</p>
        </div>
      <?php else: ?>
        <?php foreach ($pendingPromotions as $promotion): ?>
          <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center gap-2">
            <div>
              <strong><?php echo htmlspecialchars($promotion['airline_name']); ?></strong> - <?php echo htmlspecialchars($promotion['title']); ?>
              <div class="small mt-1">Estado: <span class="status-badge info"><?php echo htmlspecialchars($promotion['status']); ?></span></div>
            </div>
            <div class="d-flex gap-2">
              <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin">
                <input type="hidden" name="action" value="approve_promotion">
                <input type="hidden" name="promotion_id" value="<?php echo (int) $promotion['id']; ?>">
                <button class="btn btn-sm btn-success" type="submit">Aprobar</button>
              </form>
              <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin">
                <input type="hidden" name="action" value="deny_promotion">
                <input type="hidden" name="promotion_id" value="<?php echo (int) $promotion['id']; ?>">
                <button class="btn btn-sm btn-secondary" type="submit" onclick="return confirm('¿Estás seguro de que deseas denegar esta promocion? Esta acción no se puede deshacer.');">Denegar</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="news-admin-title">
    <div class="card p-3">
      <h2 id="news-admin-title" class="h5">3) ABMC Novedades</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin" class="mb-3 needs-validation" novalidate>
        <input type="hidden" name="action" value="create_news">
        <div class="mb-2"><label class="form-label" for="news_title">Titulo</label><input id="news_title" name="title" class="form-control" required></div>
        <div class="mb-2"><label class="form-label" for="news_content">Contenido</label><textarea id="news_content" name="content" class="form-control" rows="3" required></textarea></div>
        <div class="row g-2 mb-2">
          <div class="col-md-6"><label class="form-label" for="news_start">Fecha inicio</label><input id="news_start" name="start_date" type="date" class="form-control"></div>
          <div class="col-md-6"><label class="form-label" for="news_end">Fecha fin</label><input id="news_end" name="end_date" type="date" class="form-control"></div>
        </div>
        <button class="btn btn-primary" type="submit">Publicar</button>
      </form>

      <?php if (empty($news)): ?>
        <div class="empty-state compact">
          <p class="mb-0">No hay novedades cargadas.</p>
        </div>
      <?php else: ?>
        <?php foreach ($news as $item): ?>
          <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin" class="border rounded p-2 mb-2">
            <input type="hidden" name="news_id" value="<?php echo (int) $item['id']; ?>">
            <input name="title" class="form-control mb-2" value="<?php echo htmlspecialchars($item['title']); ?>" required>
            <textarea name="content" class="form-control mb-2" rows="3" required><?php echo htmlspecialchars($item['content']); ?></textarea>
            <div class="row g-2 mb-2">
              <div class="col-md-6"><label class="form-label" for="news_start_<?php echo (int) $item['id']; ?>">Fecha inicio</label><input id="news_start_<?php echo (int) $item['id']; ?>" name="start_date" type="date" class="form-control" value="<?php echo htmlspecialchars($item['start_date'] ?? ''); ?>"></div>
              <div class="col-md-6"><label class="form-label" for="news_end_<?php echo (int) $item['id']; ?>">Fecha fin</label><input id="news_end_<?php echo (int) $item['id']; ?>" name="end_date" type="date" class="form-control" value="<?php echo htmlspecialchars($item['end_date'] ?? ''); ?>"></div>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-warning" name="action" value="update_news" type="submit">Editar</button>
              <button class="btn btn-sm btn-danger" name="action" value="delete_news" type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta novedad? Esta acción no se puede deshacer.');">Eliminar</button>
            </div>
          </form>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>

  <section class="col-lg-6" aria-labelledby="report-admin-title">
    <div class="card p-3">
      <h2 id="report-admin-title" class="h5">4) Reportes del sistema</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=admin" class="mb-3">
        <input type="hidden" name="action" value="export_sales_csv_admin">
        <button class="btn btn-sm btn-outline-primary" type="submit">Exportar ventas CSV</button>
      </form>
      <p class="mb-1"><strong>Usuarios:</strong> <?php echo (int) $reports['users']; ?></p>
      <p class="mb-1"><strong>Vuelos:</strong> <?php echo (int) $reports['flights']; ?></p>
      <p class="mb-2"><strong>Reservas:</strong> <?php echo (int) $reports['reservations']; ?></p>
      <h3 class="h6">Ventas por aerolinea</h3>
      <?php if (empty($sales)): ?>
        <div class="empty-state compact">
          <p class="mb-0">Todavia no hay ventas registradas por aerolinea.</p>
        </div>
      <?php else: ?>
        <ul>
          <?php foreach ($sales as $row): ?>
            <li><?php echo htmlspecialchars($row['airline']); ?>: $<?php echo number_format((float) $row['total_sales'], 2); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </section>
</div>
