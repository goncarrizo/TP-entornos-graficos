<section aria-labelledby="reservations-title">
  <h1 id="reservations-title" class="h4 mb-3">Mis reservas e historial</h1>

  <?php if (empty($reservations)): ?>
    <div class="alert alert-info">No tenes reservas registradas.</div>
  <?php endif; ?>

  <?php foreach ($reservations as $reservation): ?>
    <article class="card p-3 mb-3">
      <h2 class="h6 mb-2"><?php echo htmlspecialchars($reservation['origin']); ?> -> <?php echo htmlspecialchars($reservation['destination']); ?></h2>
      <p class="mb-1"><strong>Aerolinea:</strong> <?php echo htmlspecialchars($reservation['airline_name']); ?></p>
      <p class="mb-1"><strong>Salida:</strong> <?php echo htmlspecialchars($reservation['departure_time']); ?></p>
      <p class="mb-1"><strong>Asientos:</strong> <?php echo (int) $reservation['seats']; ?></p>
      <p class="mb-1"><strong>Total:</strong> $<?php echo number_format((float) $reservation['total_amount'], 2); ?></p>
      <p class="mb-2"><strong>Estado:</strong> <?php echo htmlspecialchars($reservation['status']); ?></p>

      <?php if ($reservation['status'] !== 'cancelled'): ?>
        <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=reservations" onsubmit="return confirm('Deseas cancelar esta reserva?');">
          <input type="hidden" name="action" value="cancel_reservation">
          <input type="hidden" name="reservation_id" value="<?php echo (int) $reservation['id']; ?>">
          <button class="btn btn-sm btn-danger" type="submit">Cancelar (si faltan 72hs)</button>
        </form>
      <?php endif; ?>
    </article>
  <?php endforeach; ?>
</section>
