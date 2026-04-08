<div class="row g-4">
  <section class="col-md-6" aria-labelledby="login-title">
    <div class="card p-4">
      <h1 id="login-title" class="h4">Iniciar sesion</h1>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=login" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="login">
        <div class="mb-3">
          <label for="login_email" class="form-label">Email</label>
          <input id="login_email" name="email" type="email" class="form-control" required>
          <div class="invalid-feedback">Ingresa un email valido.</div>
        </div>
        <div class="mb-3">
          <label for="login_password" class="form-label">Clave</label>
          <input id="login_password" name="password" type="password" class="form-control" minlength="6" required>
          <div class="invalid-feedback">La clave es obligatoria.</div>
        </div>
        <button class="btn btn-primary w-100" type="submit">Ingresar</button>
      </form>
      <small class="text-muted mt-3 d-block">Demo: admin@tp.com / 123456 | ceo@tp.com / 123456 | cliente@tp.com / 123456</small>
    </div>
  </section>

  <section class="col-md-6" aria-labelledby="register-title">
    <div class="card p-4">
      <h2 id="register-title" class="h4">Registrarse</h2>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=login" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="register">
        <div class="mb-3">
          <label for="reg_name" class="form-label">Nombre completo</label>
          <input id="reg_name" name="name" type="text" class="form-control" required>
          <div class="invalid-feedback">El nombre es obligatorio.</div>
        </div>
        <div class="mb-3">
          <label for="reg_email" class="form-label">Email</label>
          <input id="reg_email" name="email" type="email" class="form-control" required>
          <div class="invalid-feedback">Ingresa un email valido.</div>
        </div>
        <div class="mb-3">
          <label for="reg_password" class="form-label">Clave (min 6)</label>
          <input id="reg_password" name="password" type="password" class="form-control" minlength="6" required>
          <div class="invalid-feedback">La clave debe tener al menos 6 caracteres.</div>
        </div>
        <button class="btn btn-success w-100" type="submit">Crear cuenta</button>
      </form>
    </div>
  </section>
</div>
