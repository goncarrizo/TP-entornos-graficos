<section class="row justify-content-center" aria-labelledby="account-edit-title">
  <div class="col-12 col-lg-8">
    <div class="card p-4 mb-4">
      <h1 id="account-edit-title" class="h4 mb-3">Editar datos de cuenta</h1>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=account_edit" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="update_profile">

        <div class="mb-3">
          <label for="edit_name" class="form-label">Nombre completo</label>
          <input id="edit_name" name="name" type="text" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
          <div class="invalid-feedback">El nombre es obligatorio.</div>
        </div>

        <div class="mb-3">
          <label for="edit_email" class="form-label">Email</label>
          <input id="edit_email" name="email" type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
          <div class="invalid-feedback">Ingresa un email valido.</div>
        </div>

        <button class="btn btn-primary" type="submit">Guardar datos</button>
      </form>
    </div>

    <div class="card p-4 mb-4">
      <h2 class="h5 mb-3">Elegir icono de usuario</h2>

      <?php
        $icons = [
          'plane' => 'Plane',
          'ticket' => 'Ticket',
          'map' => 'Map',
          'shield' => 'Shield',
          'star' => 'Star',
          'heart' => 'Heart',
          'user' => 'User',
          'globe' => 'Globe',
        ];
        $currentIcon = $user['user_icon'] ?? null;
      ?>

      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=account_edit" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="update_icon">

        <div class="mb-3">
          <div class="d-flex flex-wrap gap-2">
            <label class="icon-choice-label">
              <input type="radio" name="user_icon" value="" <?php echo ($currentIcon === null || $currentIcon === '') ? 'checked' : ''; ?> class="icon-choice-input">
              <span class="icon-choice icon-choice-empty">
                <span class="small fw-semibold">Sin icono</span>
              </span>
            </label>
          </div>
        </div>

        <div class="mb-3">
          <div class="row g-2">
            <?php foreach ($icons as $key => $label): ?>
              <div class="col-3 col-md-3">
                <label class="icon-choice-label">
                  <input type="radio" name="user_icon" value="<?php echo htmlspecialchars($key); ?>" class="icon-choice-input" <?php echo $currentIcon === $key ? 'checked' : ''; ?> />
                  <span class="icon-choice">
                    <div class="d-flex flex-column align-items-center">
                      <div class="account-avatar" style="width:48px;height:48px;">
                        <span aria-hidden="true" class="account-avatar-icon">
                          <?php
                            // SVG inline (sin depender de archivos en public/assets)
                            $svgMap = [
                              'plane' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M2.5 13.2c0-.7.5-1.3 1.2-1.5l6.1-1.6 4.8-6.1c.5-.6 1.2-1 2-1h1l-2 7.3 4.8-1.3 2.3-2.2c.3-.3.8-.5 1.2-.5h.8c.8 0 1.5.7 1.5 1.5 0 .5-.2 1-.6 1.3l-2.2 2 2.2 2c.4.3.6.8.6 1.3 0 .8-.7 1.5-1.5 1.5h-.8c-.5 0-.9-.2-1.2-.5l-2.3-2.2-4.8-1.3 2 7.3h-1c-.8 0-1.5-.4-2-1l-4.8-6.1-6.1-1.6c-.7-.2-1.2-.8-1.2-1.5Z"/></svg>',
                              'ticket' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M3 9V7.5C3 6.1 4.1 5 5.5 5H18.5C19.9 5 21 6.1 21 7.5V9a2 2 0 0 0 0 6v1.5c0 1.4-1.1 2.5-2.5 2.5H5.5C4.1 20 3 18.9 3 17.5V15a2 2 0 0 0 0-6Z"/><path d="M12 8v8"/><path d="M9 10h.01"/><path d="M15 14h.01"/></svg>',
                              'map' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M9 18l-6 3V6l6-3 6 3 6-3v15l-6 3-6-3Z"/><path d="M9 3v15"/><path d="M15 6v15"/></svg>',
                              'shield' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="M9.5 12l1.8 1.8 3.2-3.7"/></svg>',
                              'star' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 2l3.1 6.6 7.3 1.1-5.2 5.1 1.2 7.2L12 18.9 5.6 22 6.8 14.8 1.6 9.7 8.9 8.6 12 2Z"/></svg>',
                              'heart' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M20.8 8.6c0 6.3-8.8 11.7-8.8 11.7S3.2 14.9 3.2 8.6c0-2.5 2-4.5 4.5-4.5 1.6 0 3 .8 3.8 2 0.8-1.2 2.2-2 3.8-2 2.5 0 4.5 2 4.5 4.5Z"/></svg>',
                              'user' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><circle cx="12" cy="8" r="3.2"/><path d="M4.5 19.2c0-4 3.4-6.7 7.5-6.7s7.5 2.7 7.5 6.7"/></svg>',
                              'globe' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.6 3 14.4 0 18"/><path d="M12 3c-3 3.6-3 14.4 0 18"/></svg>'
                            ];
                            echo $svgMap[$key] ?? '';
                          ?>
                        </span>
                      </div>
                      <div class="small text-muted mt-2" style="text-transform:capitalize; font-weight:700;">
                        <?php echo htmlspecialchars(str_replace(['-','_'],' ', strtolower($key))); ?>
                      </div>
                    </div>
                  </span>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <button class="btn btn-primary" type="submit">Guardar icono</button>
      </form>
    </div>

    <div class="card p-4">
      <h2 class="h5 mb-3">Cambiar clave</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=account_edit" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="change_password">

        <div class="mb-3">
          <label for="edit_current_password" class="form-label">Clave actual</label>
          <input id="edit_current_password" name="current_password" type="password" class="form-control" minlength="6" required>
          <div class="invalid-feedback">Ingresa tu clave actual.</div>
        </div>

        <div class="mb-3">
          <label for="edit_new_password" class="form-label">Nueva clave</label>
          <input id="edit_new_password" name="new_password" type="password" class="form-control" minlength="6" required>
          <div class="invalid-feedback">La nueva clave debe tener al menos 6 caracteres.</div>
        </div>

        <div class="mb-3">
          <label for="edit_confirm_password" class="form-label">Confirmar nueva clave</label>
          <input id="edit_confirm_password" name="confirm_password" type="password" class="form-control" minlength="6" required>
          <div class="invalid-feedback">Las claves deben coincidir.</div>
        </div>

        <button class="btn btn-outline-primary" type="submit">Actualizar clave</button>
      </form>
    </div>
  </div>
</section>
