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

      <?php
      $old = $_SESSION['register_old'] ?? [];
      if (!is_array($old)) {
          $old = [];
      }

      if ((empty($old) || (isset($_POST['action']) && $_POST['action'] === 'register')) && $_SERVER['REQUEST_METHOD'] === 'POST') {
          $old = [
              'name' => $_POST['name'] ?? ($old['name'] ?? ''),
              'lastname' => $_POST['lastname'] ?? ($old['lastname'] ?? ''),
              'email' => $_POST['email'] ?? ($old['email'] ?? ''),
              'phone' => $_POST['phone'] ?? ($old['phone'] ?? ''),
              'document' => $_POST['document'] ?? ($old['document'] ?? ''),
              'birthdate' => $_POST['birthdate'] ?? ($old['birthdate'] ?? ''),
              'role' => $_POST['role'] ?? ($old['role'] ?? 'customer'),
              'airline_id' => $_POST['airline_id'] ?? ($old['airline_id'] ?? ''),
          ];
      }

      $errors = $_SESSION['register_errors'] ?? [];
      if (!is_array($errors)) {
          $errors = [];
      }

      function register_old(string $field): string
      {
          global $old;
          return htmlspecialchars((string) ($old[$field] ?? ''), ENT_QUOTES, 'UTF-8');
      }

      function register_error(string $field, string $default): string
      {
          global $errors;

          if (!empty($errors[$field])) {
              return '<div class="invalid-feedback d-block">'
                  . htmlspecialchars($errors[$field], ENT_QUOTES, 'UTF-8')
                  . '</div>';
          }

          return '<div class="invalid-feedback">' . htmlspecialchars($default, ENT_QUOTES, 'UTF-8') . '</div>';
      }

      function register_invalid_class(string $field): string
      {
          global $errors, $old;
          $value = trim((string) ($old[$field] ?? ''));

          if (!empty($errors[$field])) {
              return ' is-invalid';
          }

          return ($value !== '') ? ' is-valid' : '';
      }

      function register_invalid_attr(string $field): string
      {
          global $errors;
          return !empty($errors[$field]) ? ' aria-invalid="true"' : ' aria-invalid="false"';
      }

      function register_selected(string $field, string $value): string
      {
          global $old;
          return ((string) ($old[$field] ?? '') === $value) ? ' selected' : '';
      }
      ?>
      
      <form id="register_form" method="post" action="<?php echo BASE_URL; ?>/index.php?page=register" class="needs-validation" novalidate data-allow-server-validation="1">
        <input type="hidden" name="action" value="register">

        <div class="row g-3">
            <div class="col-md-6">
              <label for="reg_name" class="form-label">Nombre</label>
              <input id="reg_name" name="name" type="text" class="form-control<?php echo register_invalid_class('name'); ?>" autocomplete="given-name" placeholder="Nombre" value="<?php echo register_old('name'); ?>" required>
              <?php echo register_error('name', 'Campo obligatorio.'); ?>
            </div>
          <div class="col-md-6">
            <label for="reg_lastname" class="form-label">Apellido</label>
            <input id="reg_lastname" name="lastname" type="text" class="form-control<?php echo register_invalid_class('lastname'); ?>" autocomplete="family-name" placeholder="Apellido" value="<?php echo register_old('lastname'); ?>" minlength="2" pattern="[A-Za-zÁÉÍÓÚÜáéíóúüÑñ\s'-]+" title="Solo se permiten letras, espacios y debe tener al menos 2 caracteres." required<?php echo register_invalid_attr('lastname'); ?>>
            <?php echo register_error('lastname', 'El apellido es obligatorio.'); ?>
          </div>
          <div class="col-md-6">
            <label for="reg_email" class="form-label">Email</label>
            <input id="reg_email" name="email" type="email" class="form-control<?php echo register_invalid_class('email'); ?>" autocomplete="email" placeholder="tu@email.com" value="<?php echo htmlspecialchars(register_old('email'), ENT_QUOTES, 'UTF-8'); ?>" pattern=".+@(gmail[.]com|outlook[.]com|outlook[.]com[.]ar)" required>
            <?php echo register_error('email', 'Ingresa un email valido.'); ?>
          </div>
          <div class="col-md-6">
            <label for="reg_phone" class="form-label">Telefono</label>
            <input id="reg_phone" name="phone" type="tel" class="form-control<?php echo register_invalid_class('phone'); ?>" autocomplete="tel" placeholder="+54 11 1234 5678" value="<?php echo register_old('phone'); ?>" pattern="[0-9+\-\s]{8,20}" required>
            <?php echo register_error('phone', 'Ingresa un telefono valido.'); ?>
          </div>
          <div class="col-md-6">
            <label for="reg_document" class="form-label">Documento</label>
            <input id="reg_document" name="document" type="text" class="form-control<?php echo register_invalid_class('document'); ?>" autocomplete="off" placeholder="Documento" value="<?php echo register_old('document'); ?>" pattern="[0-9]{7,10}" required>
            <?php echo register_error('document', 'Ingresa un documento valido (7 a 10 digitos).'); ?>
          </div>
          <div class="col-md-6">
            <label for="reg_birthdate" class="form-label">Fecha de nacimiento</label>
            <input id="reg_birthdate" name="birthdate" type="date" class="form-control<?php echo register_invalid_class('birthdate'); ?>" value="<?php echo register_old('birthdate'); ?>" max="<?php echo date('Y-m-d'); ?>" required>
            <?php echo register_error('birthdate', 'La fecha de nacimiento es obligatoria.'); ?>
          </div>
          <div class="col-md-6">
            <label for="reg_password" class="form-label">Clave (min 6)</label>
            <input id="reg_password" name="password" type="password" class="form-control<?php echo register_invalid_class('password'); ?>" autocomplete="new-password" placeholder="Crear clave" minlength="6" required>
            <?php echo register_error('password', 'La clave debe tener al menos 6 caracteres.'); ?>
          </div>
          <div class="col-md-6">
            <label for="reg_password_confirm" class="form-label">Confirmar clave</label>
            <input id="reg_password_confirm" name="password_confirm" type="password" class="form-control<?php echo register_invalid_class('password_confirm'); ?>" autocomplete="new-password" placeholder="Repetir clave" minlength="6" required>
            <?php echo register_error('password_confirm', 'Las claves deben coincidir.'); ?>
          </div>
          <div class="col-md-6">
            <label for="reg_role" class="form-label">¿Qué tipo de cuenta deseas crear?</label>
            <select id="reg_role" name="role" class="form-select<?php echo register_invalid_class('role'); ?>" required>
              <option value="customer"<?php echo register_selected('role', 'customer'); ?>>Pasajero</option>
              <option value="ceo"<?php echo register_selected('role', 'ceo'); ?>>CEO de Aerolínea</option>
            </select>
            <?php echo register_error('role', 'Selecciona un tipo de cuenta.'); ?>
          </div>
          <div class="col-md-6" id="airline_selector" style="display: none;">
            <label for="reg_airline_id" class="form-label">Selecciona tu aerolínea</label>
            <select id="reg_airline_id" name="airline_id" class="form-select<?php echo register_invalid_class('airline_id'); ?>">
              <option value="">-- Seleccionar aerolínea --</option>
              <?php 
              require_once __DIR__ . '/../../models/Airline.php';
              $airlines = Airline::all();
              foreach ($airlines as $airline): 
                  $selectedAirline = ((string) ($old['airline_id'] ?? '') === (string) $airline['id']) ? ' selected' : '';
              ?>
              <option value="<?php echo (int) $airline['id']; ?>"<?php echo $selectedAirline; ?>>
                <?php echo htmlspecialchars($airline['name'] . ' (' . $airline['code'] . ')'); ?>
              </option>
              <?php endforeach; ?>
            </select>
            <?php echo register_error('airline_id', 'Debes seleccionar una aerolínea.'); ?>
            <small class="text-muted d-block mt-2">⚠️ Tu solicitud será revisada por un administrador antes de poder acceder.</small>
          </div>
        </div>

        <button class="btn btn-success w-100 mt-4 btn-lg" type="submit">Crear cuenta</button>
      </form>

      <script>
        const roleSelect = document.getElementById('reg_role');
        const airlineSelector = document.getElementById('airline_selector');
        const airlineInput = document.getElementById('reg_airline_id');

        const syncAirlineSelector = () => {
          if (!roleSelect || !airlineSelector || !airlineInput) {
            return;
          }

          if (roleSelect.value === 'ceo') {
            airlineSelector.style.display = 'block';
            airlineInput.setAttribute('required', 'required');
          } else {
            airlineSelector.style.display = 'none';
            airlineInput.removeAttribute('required');
            airlineInput.value = '';
          }
        };

        syncAirlineSelector();
      </script>
