<div class="row g-4">
  <section class="col-lg-4" aria-labelledby="account-title">
    <div class="card p-4 text-center">
      <?php
        function initials(string $name): string {
          $parts = preg_split('/\s+/', trim($name));
          $letters = array_map(function($p){ return mb_strtoupper(mb_substr($p,0,1)); }, array_slice($parts,0,2));
          return implode('', $letters);
        }
        $displayName = $user['name'] ?? 'Usuario';
      ?>
      <div class="avatar avatar-lg mb-3" aria-hidden="true"><?php echo htmlspecialchars(initials($displayName)); ?></div>
      <h1 id="account-title" class="h5 mb-1"><?php echo htmlspecialchars($displayName); ?></h1>
      <p class="text-muted mb-2"><?php echo htmlspecialchars($user['email']); ?>
        <?php if (empty($user['email_verified'])): ?>
          <span class="badge bg-warning text-dark ms-2">Email no verificado</span>
        <?php else: ?>
          <span class="badge bg-success ms-2">Verificado</span>
        <?php endif; ?>
      </p>

      <div class="d-grid gap-2">
        <a class="btn btn-outline-secondary" href="<?php echo BASE_URL; ?>/index.php?page=account_edit">Editar perfil</a>
        <a class="btn btn-outline-primary" href="<?php echo BASE_URL; ?>/index.php?page=reservations">Ver mis reservas</a>
        <form method="post" action="<?php echo BASE_URL; ?>/index.php" class="m-0">
          <input type="hidden" name="action" value="logout">
          <button class="btn btn-light text-danger" type="submit">Cerrar sesión</button>
        </form>
      </div>
    </div>

    <div class="card p-3 mt-3" aria-labelledby="activity-title">
      <h2 id="activity-title" class="h6 mb-3">Resumen rápido</h2>
      <?php
        $total = (int) ($summary['total'] ?? 0);
        $confirmed = (int) ($summary['confirmed'] ?? 0);
        $cancelled = (int) ($summary['cancelled'] ?? 0);
        $spent = number_format((float) ($summary['total_spent'] ?? 0), 2);
        $confirmedPct = $total > 0 ? (int) round($confirmed / $total * 100) : 0;
      ?>
      <div class="mb-2 small text-muted">Reservas totales: <strong><?php echo $total; ?></strong></div>
      <div class="mb-2">
        <div class="progress" style="height:10px;">
          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $confirmedPct; ?>%;" aria-valuenow="<?php echo $confirmedPct; ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="d-flex justify-content-between small mt-1"><span>Confirmadas <?php echo $confirmed; ?></span><span><?php echo $confirmedPct; ?>%</span></div>
      </div>
      <div class="mb-2 small">Canceladas: <strong><?php echo $cancelled; ?></strong></div>
      <div class="mb-0 small">Total gastado: <strong>$<?php echo $spent; ?></strong></div>
    </div>
  </section>

  <section class="col-lg-8" aria-labelledby="details-title">
    <div class="card p-4">
      <h2 id="details-title" class="h5 mb-3">Detalles de cuenta</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=profile" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="update_profile">

        <div class="row g-3">
          <div class="col-md-6">
            <label for="account_name" class="form-label">Nombre completo</label>
            <input id="account_name" name="name" type="text" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <div class="invalid-feedback">El nombre es obligatorio.</div>
          </div>
          <div class="col-md-6">
            <label for="account_email" class="form-label">Email</label>
            <input id="account_email" name="email" type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <div class="invalid-feedback">Ingresa un email valido.</div>
          </div>
        </div>

        <div class="mt-3 d-flex gap-2">
          <button class="btn btn-primary" type="submit">Guardar cambios</button>
          <a class="btn btn-outline-secondary" href="<?php echo BASE_URL; ?>/index.php?page=account_edit">Editar en pantalla dedicada</a>
        </div>
      </form>

      <hr class="my-4">

      <h3 class="h6 mb-3">Cambiar contraseña</h3>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=profile" id="change-pass-form" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="change_password">

        <div class="row g-3">
          <div class="col-md-4">
            <label for="current_password" class="form-label">Clave actual</label>
            <input id="current_password" name="current_password" type="password" class="form-control" minlength="6" required>
            <div class="invalid-feedback">Ingresa tu clave actual.</div>
          </div>
          <div class="col-md-4">
            <label for="new_password" class="form-label">Nueva clave</label>
            <input id="new_password" name="new_password" type="password" class="form-control" minlength="8" required>
            <div class="form-text">Mínimo 8 caracteres. Usa una mezcla de letras y números.</div>
            <div class="invalid-feedback">La nueva clave debe tener al menos 8 caracteres.</div>
          </div>
          <div class="col-md-4">
            <label for="confirm_password" class="form-label">Confirmar nueva clave</label>
            <input id="confirm_password" name="confirm_password" type="password" class="form-control" minlength="8" required>
            <div class="invalid-feedback">Las claves deben coincidir.</div>
          </div>
        </div>

        <div class="mt-3 d-flex gap-2">
          <button class="btn btn-outline-primary" type="submit">Actualizar clave</button>
          <a class="btn btn-link text-muted" href="<?php echo BASE_URL; ?>/index.php?page=help#password">¿Necesitas ayuda con la contraseña?</a>
        </div>
      </form>

      <div class="mt-4">
        <h3 class="h6 mb-2">Ultimas reservas</h3>
        <?php if (empty($recent_reservations)): ?>
          <div class="empty-state compact"><p class="mb-0">Aun no registras reservas.</p></div>
        <?php else: ?>
          <ul class="list-unstyled">
            <?php foreach ($recent_reservations as $reservation): ?>
              <?php
                $status = $reservation['status'] ?? 'unknown';
                $statusClass = $status === 'cancelled' || $status === 'denied' ? 'danger' : ($status === 'confirmed' ? 'success' : 'secondary');
                $when = $reservation['departure_time'] ? date('d/m/Y H:i', strtotime($reservation['departure_time'])) : '';
                $amount = isset($reservation['total_amount']) ? '$' . number_format((float)$reservation['total_amount'], 2) : '';
              ?>
              <li class="reservation-item d-flex justify-content-between align-items-start py-2 border-bottom">
                <div>
                  <div class="fw-semibold"><?php echo htmlspecialchars($reservation['origin']); ?> → <?php echo htmlspecialchars($reservation['destination']); ?></div>
                  <div class="small text-muted"><?php echo $when; ?> • <?php echo (int)($reservation['seats'] ?? 1); ?> asiento(s)</div>
                </div>
                <div class="text-end">
                  <div class="small mb-1"><?php echo $amount; ?></div>
                  <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars(ucfirst($status)); ?></span>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>

<script>
  // Client-side: validate password confirmation before submit
  (function(){
    var form = document.getElementById('change-pass-form');
    if (!form) return;
    var newPass = document.getElementById('new_password');
    var conf = document.getElementById('confirm_password');
    function validateMatch(){
      if (!newPass || !conf) return true;
      if (conf.value !== newPass.value) {
        conf.setCustomValidity('Las claves no coinciden');
      } else {
        conf.setCustomValidity('');
      }
    }
    newPass && newPass.addEventListener('input', validateMatch);
    conf && conf.addEventListener('input', validateMatch);
    form.addEventListener('submit', function(e){
      validateMatch();
      if (!form.checkValidity()) {
        e.preventDefault();
        form.classList.add('was-validated');
      }
    });
  })();
</script>
