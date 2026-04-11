<section aria-labelledby="contact-title" class="page-shell">
  <header>
    <p class="hero-kicker mb-2">Soporte AirARG</p>
    <h1 id="contact-title" class="h4 page-title">Contacto</h1>
    <p class="page-subtitle mb-0">Envianos tu consulta y te respondemos lo antes posible.</p>
  </header>

  <div class="row g-4">
    <section class="col-lg-7" aria-labelledby="contact-form-title">
      <div class="card p-4">
        <h2 id="contact-form-title" class="h5 mb-3">Formulario de contacto</h2>
        <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=contact" class="needs-validation" novalidate>
          <input type="hidden" name="action" value="contact_submit">

          <div class="mb-3">
            <label for="contact_name" class="form-label">Nombre</label>
            <input id="contact_name" name="name" type="text" class="form-control" autocomplete="name" required>
            <div class="invalid-feedback">Ingresa tu nombre.</div>
          </div>

          <div class="mb-3">
            <label for="contact_email" class="form-label">Email</label>
            <input id="contact_email" name="email" type="email" class="form-control" autocomplete="email" required>
            <div class="invalid-feedback">Ingresa un email valido.</div>
          </div>

          <div class="mb-3">
            <label for="contact_subject" class="form-label">Asunto</label>
            <input id="contact_subject" name="subject" type="text" class="form-control" minlength="4" maxlength="120" required>
            <div class="invalid-feedback">El asunto debe tener al menos 4 caracteres.</div>
          </div>

          <div class="mb-3">
            <label for="contact_message" class="form-label">Mensaje</label>
            <textarea id="contact_message" name="message" class="form-control" rows="5" minlength="10" maxlength="1000" required></textarea>
            <div class="invalid-feedback">Describe tu consulta (minimo 10 caracteres).</div>
          </div>

          <button class="btn btn-primary btn-with-icon" type="submit" aria-label="Enviar formulario de contacto">
            <span class="icon-wrap" aria-hidden="true">
              <svg viewBox="0 0 24 24" focusable="false"><path d="M3 12 21 3 14 21 11 13 3 12Z"></path></svg>
            </span>
            <span>Enviar consulta</span>
          </button>
        </form>
      </div>
    </section>

    <aside class="col-lg-5" aria-label="Informacion de contacto">
      <div class="card p-4 h-100">
        <h2 class="h5 mb-3">Canales de ayuda</h2>
        <p class="mb-2"><strong>Email:</strong> soporte@airarg.local</p>
        <p class="mb-2"><strong>Horario:</strong> Lunes a Viernes de 9:00 a 18:00</p>
        <p class="mb-0 text-muted">Para temas de reservas urgentes, inclui codigo de reserva y fecha del vuelo.</p>
      </div>
    </aside>
  </div>
</section>
