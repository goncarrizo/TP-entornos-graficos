(function () {
  'use strict';

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
  }
})();
