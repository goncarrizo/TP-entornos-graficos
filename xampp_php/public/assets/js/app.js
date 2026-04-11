(function () {
  'use strict';

  const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Transiciones de entrada al hacer scroll para bloques principales.
  if (!prefersReducedMotion && 'IntersectionObserver' in window) {
    const revealItems = document.querySelectorAll('main section, .card, .alert');
    revealItems.forEach((item) => {
      item.classList.add('reveal-on-scroll');
    });

    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.12,
      rootMargin: '0px 0px -30px 0px',
    });

    revealItems.forEach((item) => revealObserver.observe(item));
  } else {
    const revealItems = document.querySelectorAll('.reveal-on-scroll');
    revealItems.forEach((item) => item.classList.add('is-visible'));
  }

  // Skeleton loaders: se ocultan al completar render inicial.
  window.setTimeout(() => {
    document.querySelectorAll('[data-skeleton-wrap]').forEach((skeletonWrap) => {
      skeletonWrap.classList.add('is-hidden');
      skeletonWrap.setAttribute('aria-hidden', 'true');
    });
  }, prefersReducedMotion ? 120 : 420);

  // Validacion cliente con Bootstrap en todos los formularios marcados.
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });

  // jQuery opcional: mejora visual de foco en campos.
  if (window.jQuery) {
    $('.form-control').on('focus', function () {
      $(this).closest('.card, form').addClass('shadow-sm');
    }).on('blur', function () {
      $(this).closest('.card, form').removeClass('shadow-sm');
    });

    $('.navbar .nav-link.active').attr('aria-current', 'page');
  }

  // Feedback visual inmediato para acciones clave.
  const feedbackToast = document.createElement('div');
  feedbackToast.className = 'action-feedback';
  feedbackToast.setAttribute('role', 'status');
  feedbackToast.setAttribute('aria-live', 'polite');
  document.body.appendChild(feedbackToast);

  const showFeedback = (message) => {
    if (!message) {
      return;
    }
    feedbackToast.textContent = message;
    feedbackToast.classList.add('show');
    window.setTimeout(() => {
      feedbackToast.classList.remove('show');
    }, 1450);
  };

  document.querySelectorAll('[data-feedback]').forEach((element) => {
    const eventName = element.tagName === 'FORM' ? 'submit' : 'click';
    element.addEventListener(eventName, () => {
      showFeedback(element.getAttribute('data-feedback'));
    });
  });

  // Validacion extra: confirmacion de clave en registro.
  const password = document.getElementById('reg_password');
  const passwordConfirm = document.getElementById('reg_password_confirm');

  if (password && passwordConfirm) {
    const syncPasswordMatch = () => {
      if (password.value !== passwordConfirm.value) {
        passwordConfirm.setCustomValidity('Las claves deben coincidir');
      } else {
        passwordConfirm.setCustomValidity('');
      }
    };

    password.addEventListener('input', syncPasswordMatch);
    passwordConfirm.addEventListener('input', syncPasswordMatch);
  }

  // Validacion extra: confirmacion de nueva clave en perfil.
  const newPassword = document.getElementById('new_password');
  const confirmPassword = document.getElementById('confirm_password');

  if (newPassword && confirmPassword) {
    const syncNewPasswordMatch = () => {
      if (newPassword.value !== confirmPassword.value) {
        confirmPassword.setCustomValidity('Las claves deben coincidir');
      } else {
        confirmPassword.setCustomValidity('');
      }
    };

    newPassword.addEventListener('input', syncNewPasswordMatch);
    confirmPassword.addEventListener('input', syncNewPasswordMatch);
  }
})();
