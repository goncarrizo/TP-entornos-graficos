document.addEventListener('DOMContentLoaded', () => {
  const registerForm = document.getElementById('register-form');
  const loginForm = document.getElementById('login-form');
  const profileBox = document.getElementById('profile-box');

  if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(registerForm);

      try {
        await apiRequest('/auth/register', {
          method: 'POST',
          body: JSON.stringify({
            name: formData.get('name'),
            email: formData.get('email'),
            password: formData.get('password'),
          }),
        });
        alert('Registro exitoso. Ahora inicia sesion.');
        window.location.href = '/login.html';
      } catch (error) {
        alert(error.message);
      }
    });
  }

  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(loginForm);

      try {
        const data = await apiRequest('/auth/login', {
          method: 'POST',
          body: JSON.stringify({
            email: formData.get('email'),
            password: formData.get('password'),
          }),
        });

        setSession(data.token, data.user);
        window.location.href = '/index.html';
      } catch (error) {
        alert(error.message);
      }
    });
  }

  if (profileBox) {
    const user = getCurrentUser();
    if (!user) {
      profileBox.innerHTML = '<p>Debes iniciar sesion para ver tu perfil.</p>';
      return;
    }

    profileBox.innerHTML = `
      <ul class="list-group">
        <li class="list-group-item"><strong>Nombre:</strong> ${user.name}</li>
        <li class="list-group-item"><strong>Email:</strong> ${user.email}</li>
        <li class="list-group-item"><strong>Rol:</strong> ${user.role}</li>
      </ul>
    `;
  }
});
