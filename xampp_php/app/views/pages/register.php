<div class="row justify-content-center">
  <section class="col-12 col-lg-8" aria-labelledby="register-title">
    <div class="card p-4 p-lg-5">
      <div class="mb-4">
        <p class="hero-kicker mb-2">Nuevo pasajero</p>
        <h1 id="register-title" class="h4 mb-2">Crear cuenta</h1>
        <p class="text-muted mb-0">Completá tus datos para habilitar reservas, historial y acceso a tu perfil.</p>
      </div>
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <a class="btn btn-outline-primary btn-sm" href="<?php echo BASE_URL; ?>/index.php?page=login">Ya tengo cuenta</a>
      </div>
      <div class="mini-note mb-4">
        <strong>Tip:</strong> completá los datos exactamente como figuran en tu documento para evitar errores al validar tu cuenta.
      </div>
      <p class="form-help">Todos los campos son obligatorios para crear tu perfil de pasajero.</p>

      <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=register" class="needs-validation" novalidate>
        <input type="hidden" name="action" value="register">

        <div class="row g-3">
          <div class="col-md-6">
            <label for="reg_name" class="form-label">Nombre</label>
            <input id="reg_name" name="name" type="text" class="form-control" autocomplete="given-name" placeholder="Nombre" required>
            <div class="invalid-feedback">El nombre es obligatorio.</div>
          </div>
          <div class="col-md-6">
            <label for="reg_lastname" class="form-label">Apellido</label>
            <input id="reg_lastname" name="lastname" type="text" class="form-control" autocomplete="family-name" placeholder="Apellido" required>
            <div class="invalid-feedback">El apellido es obligatorio.</div>
          </div>
          <div class="col-md-6">
            <label for="reg_email" class="form-label">Email</label>
            <input id="reg_email" name="email" type="email" class="form-control" autocomplete="email" placeholder="tu@email.com" required>
            <div class="invalid-feedback">Ingresa un email valido.</div>
          </div>
          <div class="col-md-6">
            <label for="reg_phone" class="form-label">Telefono</label>
            <input id="reg_phone" name="phone" type="tel" class="form-control" autocomplete="tel" placeholder="+54 11 1234 5678" pattern="[0-9+\-\s]{8,20}" required>
            <div class="invalid-feedback">Ingresa un telefono valido.</div>
          </div>
          <div class="col-md-6">
            <label for="reg_document" class="form-label">Documento</label>
            <input id="reg_document" name="document" type="text" class="form-control" autocomplete="off" placeholder="Documento" pattern="[0-9]{7,10}" required>
            <div class="invalid-feedback">Ingresa un documento valido (7 a 10 digitos).</div>
          </div>
          <div class="col-md-6">
            <label for="reg_birthdate" class="form-label">Fecha de nacimiento</label>
            <input id="reg_birthdate" name="birthdate" type="date" class="form-control" required>
            <div class="invalid-feedback">La fecha de nacimiento es obligatoria.</div>
          </div>
          <div class="col-md-6">
            <label for="reg_password" class="form-label">Clave (min 6)</label>
            <input id="reg_password" name="password" type="password" class="form-control" autocomplete="new-password" placeholder="Crear clave" minlength="6" required>
            <div class="invalid-feedback">La clave debe tener al menos 6 caracteres.</div>
          </div>
          <div class="col-md-6">
            <label for="reg_password_confirm" class="form-label">Confirmar clave</label>
            <input id="reg_password_confirm" name="password_confirm" type="password" class="form-control" autocomplete="new-password" placeholder="Repetir clave" minlength="6" required>
            <div class="invalid-feedback">Las claves deben coincidir.</div>
          </div>
        </div>

        <button class="btn btn-success w-100 mt-4 btn-lg" type="submit">Crear cuenta</button>
      </form>
    </div>
  </section>
</div>
