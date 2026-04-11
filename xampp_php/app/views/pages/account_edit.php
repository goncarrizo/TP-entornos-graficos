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
