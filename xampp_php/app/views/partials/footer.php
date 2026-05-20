</main>
<footer class="site-footer mt-4">
  <div class="container py-3 d-flex flex-column flex-md-row justify-content-between gap-2">
    <div>
      <strong>AirARG</strong>
      <div class="small">Reservas, rutas y gestion operativa</div>
    </div>
    <div class="d-flex flex-wrap gap-3 small">
      <a href="<?php echo BASE_URL; ?>/index.php?page=home">Home</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=flights">Vuelos</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=news">Novedades</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=faq">Ayuda</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=contact">Contacto</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=login">Ingresar</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=register">Registrarse</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=profile">Cuenta</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=reservations">Reservas</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=admin">Panel Admin</a>
      <a href="<?php echo BASE_URL; ?>/index.php?page=ceo">Panel CEO</a>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  (() => {
    'use strict';

    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach((form) => {
      form.addEventListener('submit', (event) => {
        const passwordInput = form.querySelector('input[name="password"]');
        const passwordConfirmInput = form.querySelector('input[name="password_confirm"]');

        if (passwordInput && passwordConfirmInput) {
          if (passwordInput.value !== passwordConfirmInput.value) {
            passwordConfirmInput.setCustomValidity('Las claves deben coincidir.');
          } else {
            passwordConfirmInput.setCustomValidity('');
          }
        }

        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>
</body>
</html>
