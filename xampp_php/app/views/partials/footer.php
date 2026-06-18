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
    const hero = document.querySelector('.hero');
    const supportsHeroParallax = Boolean(hero && window.matchMedia('(min-width: 992px) and (prefers-reduced-motion: no-preference)').matches);

    const buildPlaceholder = (label) => {
      const safeLabel = String(label || 'Imagen no disponible')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');

      return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 450" role="img" aria-label="${safeLabel}">
          <defs>
            <linearGradient id="g" x1="0" x2="1" y1="0" y2="1">
              <stop offset="0%" stop-color="#0b3d91" />
              <stop offset="100%" stop-color="#12365f" />
            </linearGradient>
          </defs>
          <rect width="800" height="450" rx="28" fill="url(#g)" />
          <circle cx="640" cy="102" r="110" fill="#ffffff" fill-opacity="0.08" />
          <circle cx="128" cy="354" r="136" fill="#d7192d" fill-opacity="0.12" />
          <path d="M110 298h580" stroke="#ffffff" stroke-opacity="0.14" stroke-width="6" stroke-linecap="round" />
          <path d="M182 252l174-64 116-104h38l-58 104 118 12 74-34h30c18 0 32 14 32 32 0 11-6 21-15 27l-53 37 53 37c9 6 15 16 15 27 0 18-14 32-32 32h-30l-74-34-118 12 58 104h-38L356 274l-174-64z" fill="#ffffff" fill-opacity="0.9" />
          <text x="50%" y="392" text-anchor="middle" fill="#f4f8ff" font-family="Barlow, Segoe UI, sans-serif" font-size="28" font-weight="700">${safeLabel}</text>
        </svg>
      `);
    };

    const applyHeroParallax = () => {
      if (!supportsHeroParallax) {
        return;
      }

      const offset = Math.max(-28, Math.min(28, window.scrollY * 0.12));
      hero.style.setProperty('--hero-parallax', `${offset}px`);
    };

    const wireImagePlaceholders = () => {
      document.querySelectorAll('img[data-placeholder]').forEach((img) => {
        if (img.dataset.placeholderBound === '1') {
          return;
        }

        img.dataset.placeholderBound = '1';
        img.addEventListener('error', () => {
          img.src = buildPlaceholder(img.dataset.placeholderLabel || img.alt || 'Imagen no disponible');
          img.classList.add('is-placeholder');
        }, { once: true });
      });
    };

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

    wireImagePlaceholders();
    applyHeroParallax();

    // Inject CSRF token into all POST forms that don't already include it
    const injectCsrfToForms = () => {
      const meta = document.querySelector('meta[name="csrf-token"]');
      if (!meta) return;
      const token = meta.getAttribute('content');
      if (!token) return;

      document.querySelectorAll('form[method="post"], form[method="POST"]').forEach((form) => {
        if (form.querySelector('input[name="csrf_token"]')) return;
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'csrf_token';
        input.value = token;
        form.appendChild(input);
      });
    };

    injectCsrfToForms();

    if (supportsHeroParallax) {
      let scheduled = false;

      const onScroll = () => {
        if (scheduled) {
          return;
        }

        scheduled = true;
        window.requestAnimationFrame(() => {
          applyHeroParallax();
          scheduled = false;
        });
      };

      window.addEventListener('scroll', onScroll, { passive: true });
      window.addEventListener('resize', applyHeroParallax, { passive: true });
    }
  })();
</script>
</body>
</html>
