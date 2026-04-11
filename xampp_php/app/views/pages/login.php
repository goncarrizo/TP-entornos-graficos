<div class="row justify-content-center">
  <section class="col-12 col-md-8 col-lg-6" aria-labelledby="login-title">
    <div class="card p-4 p-lg-5">
      <div class="mb-4">
        <p class="hero-kicker mb-2">Acceso seguro</p>
        <h1 id="login-title" class="h4 mb-2">Iniciar sesion</h1>
        <p class="text-muted mb-0">Entrá con tus credenciales para gestionar reservas, cuenta y paneles.</p>
      </div>
      <p class="form-help">Campos obligatorios. Si fallan tus datos, revisa email y clave.</p>
      <div class="mini-note mb-3">
        <strong>Datos demo:</strong> admin@tp.com / 123456, ceo@tp.com / 123456, cliente@tp.com / 123456
      </div>
      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=login" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="login">
        <div class="mb-3">
          <label for="login_email" class="form-label">Email</label>
          <input id="login_email" name="email" type="email" class="form-control" autocomplete="email" placeholder="tu@email.com" required>
          <div class="invalid-feedback">Ingresa un email valido.</div>
        </div>
        <div class="mb-3">
          <label for="login_password" class="form-label">Clave</label>
          <input id="login_password" name="password" type="password" class="form-control" autocomplete="current-password" minlength="6" placeholder="Tu clave" required>
          <small class="text-muted">Minimo 6 caracteres.</small>
          <div class="invalid-feedback">La clave es obligatoria.</div>
        </div>
        <button class="btn btn-primary w-100 btn-lg" type="submit">Ingresar</button>
      </form>

      <hr class="my-4">

      <p class="mb-2 text-center">No tenes cuenta?</p>
      <p class="text-center mb-0">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo BASE_URL; ?>/index.php?page=register">Registrarse</a>
      </p>

    </div>
  </section>
</div>
