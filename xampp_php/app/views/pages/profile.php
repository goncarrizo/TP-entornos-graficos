<div class="row g-4">
  <section class="col-lg-7" aria-labelledby="account-title">
    <div class="card p-4">
      <h1 id="account-title" class="h4 mb-3">Gestionar tu cuenta</h1>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=profile" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="update_profile">

        <div class="mb-3">
          <label for="account_name" class="form-label">Nombre completo</label>
          <input id="account_name" name="name" type="text" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
          <div class="invalid-feedback">El nombre es obligatorio.</div>
        </div>

        <div class="mb-3">
          <label for="account_email" class="form-label">Email</label>
          <input id="account_email" name="email" type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
          <div class="invalid-feedback">Ingresa un email valido.</div>
        </div>

        <div class="mb-3">
          <label class="form-label">Rol</label>
          <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['role']); ?>" disabled>
        </div>

        <button class="btn btn-primary" type="submit">Guardar cambios</button>
      </form>
    </div>
  </section>

  <section class="col-lg-5" aria-labelledby="password-title">
    <div class="card p-4">
      <h2 id="password-title" class="h5 mb-3">Cambiar clave</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=profile" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="change_password">

        <div class="mb-3">
          <label for="current_password" class="form-label">Clave actual</label>
          <input id="current_password" name="current_password" type="password" class="form-control" minlength="6" required>
          <div class="invalid-feedback">Ingresa tu clave actual.</div>
        </div>

        <div class="mb-3">
          <label for="new_password" class="form-label">Nueva clave</label>
          <input id="new_password" name="new_password" type="password" class="form-control" minlength="6" required>
          <div class="invalid-feedback">La nueva clave debe tener al menos 6 caracteres.</div>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirmar nueva clave</label>
          <input id="confirm_password" name="confirm_password" type="password" class="form-control" minlength="6" required>
          <div class="invalid-feedback">Las claves deben coincidir.</div>
        </div>

        <button class="btn btn-outline-primary w-100" type="submit">Actualizar clave</button>
      </form>
    </div>
  </section>
</div>
