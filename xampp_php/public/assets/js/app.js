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
