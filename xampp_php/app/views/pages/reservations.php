<section aria-labelledby="reservations-title">
  <nav class="breadcrumb-air" aria-label="Breadcrumb">
    <a href="<?php echo BASE_URL; ?>/index.php?page=home">Home</a>
    <span>/</span>
    <span aria-current="page">Mis reservas</span>
  </nav>
  <h1 id="reservations-title" class="h4 mb-3">Mis reservas e historial</h1>

  <?php if (empty($reservations)): ?>
    <div class="empty-state">
      <span class="empty-state-illustration" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false"><path d="M4 7h16M4 12h16M4 17h10"></path></svg>
      </span>
      <h2 class="h6 mb-2">Todavia no tenes reservas</h2>
      <p class="mb-3">Cuando confirmes tu primer vuelo, lo vas a ver aca con su estado y acciones disponibles.</p>
      <a class="btn btn-outline-primary" href="<?php echo BASE_URL; ?>/index.php?page=flights">Buscar vuelos</a>
    </div>
  <?php endif; ?>

  <?php foreach ($reservations as $reservation): ?>
    <?php
      $statusClass = 'info';
      if ($reservation['status'] === 'confirmed') {
          $statusClass = 'success';
      } elseif ($reservation['status'] === 'cancelled') {
          $statusClass = 'danger';
      }
    ?>
    <article class="card reservation-card p-3 mb-3">
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
        <h2 class="h6 mb-0"><?php echo htmlspecialchars($reservation['origin']); ?> -> <?php echo htmlspecialchars($reservation['destination']); ?></h2>
        <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($reservation['status']); ?></span>
      </div>

      <ul class="reservation-timeline" aria-label="Estado de la reserva">
        <li class="<?php echo in_array($reservation['status'], ['pending', 'confirmed'], true) ? 'active' : ''; ?>">Pendiente</li>
        <li class="<?php echo $reservation['status'] === 'confirmed' ? 'active' : ''; ?>">Confirmada</li>
        <li class="<?php echo $reservation['status'] === 'cancelled' ? 'cancelled' : ''; ?>">Cancelada</li>
      </ul>

      <div class="row g-2 reservation-meta mb-2">
        <div class="col-md-6"><strong>Aerolinea:</strong> <?php echo htmlspecialchars($reservation['airline_name']); ?></div>
        <div class="col-md-6"><strong>Salida:</strong> <?php echo htmlspecialchars($reservation['departure_time']); ?></div>
        <div class="col-md-4"><strong>Asientos:</strong> <?php echo (int) $reservation['seats']; ?></div>
        <div class="col-md-4"><strong>Total:</strong> $<?php echo number_format((float) $reservation['total_amount'], 2); ?></div>
        <div class="col-md-4"><strong>Reserva #</strong> <?php echo (int) $reservation['id']; ?></div>
      </div>

      <?php if ($reservation['status'] !== 'cancelled'): ?>
        <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=reservations" onsubmit="return confirm('Deseas cancelar esta reserva?');" class="reservation-actions" data-feedback="Enviando cancelacion...">
          <input type="hidden" name="action" value="cancel_reservation">
          <input type="hidden" name="reservation_id" value="<?php echo (int) $reservation['id']; ?>">
          <button class="btn btn-sm btn-danger btn-with-icon" type="submit" aria-label="Cancelar reserva <?php echo (int) $reservation['id']; ?>">
            <span class="icon-wrap" aria-hidden="true"><svg viewBox="0 0 24 24" focusable="false"><path d="M6 6 18 18M18 6 6 18"></path></svg></span>
            <span>Cancelar reserva (si faltan 72hs)</span>
          </button>
        </form>
      <?php else: ?>
        <p class="small text-muted mb-0">Esta reserva ya esta cancelada y no requiere ninguna accion adicional.</p>
      <?php endif; ?>

      <?php $changes = $history_by_reservation[(int) $reservation['id']] ?? []; ?>
      <?php if (!empty($changes)): ?>
        <div class="mt-3 pt-2 border-top">
          <h3 class="h6 mb-2">Historial de cambios</h3>
          <ul class="small mb-0">
            <?php foreach ($changes as $change): ?>
              <li>
                <?php echo htmlspecialchars($change['changed_at']); ?>:
                <?php echo htmlspecialchars((string) ($change['from_status'] ?? 'inicio')); ?> -> <?php echo htmlspecialchars($change['to_status']); ?>
                (<?php echo htmlspecialchars($change['changed_by_name'] ?: 'sistema'); ?>)
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </article>
  <?php endforeach; ?>
</section>
