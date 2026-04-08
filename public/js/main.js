function renderNavbar() {
  const container = document.getElementById('navbar-placeholder');
  if (!container) return;

  const user = getCurrentUser();

  container.innerHTML = `
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand brand-strong" href="/index.html">Aero TP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="/flights.html">Vuelos</a></li>
            <li class="nav-item"><a class="nav-link" href="/novedades.html">Novedades</a></li>
            ${user ? '<li class="nav-item"><a class="nav-link" href="/reservations.html">Reservas</a></li>' : ''}
            ${user && user.role === 'admin' ? '<li class="nav-item"><a class="nav-link" href="/admin.html">Panel Admin</a></li>' : ''}
            ${user && user.role === 'ceo' ? '<li class="nav-item"><a class="nav-link" href="/ceo.html">Panel CEO</a></li>' : ''}
          </ul>
          <div class="d-flex align-items-center gap-2">
            ${user ? `<span class="text-white small">${user.name} (${user.role})</span>` : ''}
            ${
              user
                ? '<button id="btn-logout" class="btn btn-sm btn-light">Salir</button>'
                : '<a class="btn btn-sm btn-light" href="/login.html">Ingresar</a>'
            }
          </div>
        </div>
      </div>
    </nav>
  `;

  const logoutBtn = document.getElementById('btn-logout');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
      clearSession();
      window.location.href = '/index.html';
    });
  }
}

function renderFooter() {
  const container = document.getElementById('footer-placeholder');
  if (!container) return;

  container.innerHTML = `
    <footer>
      <div class="container d-flex flex-column flex-md-row justify-content-between align-items-start gap-2">
        <div>
          <strong>TP Entornos Graficos - Plataforma de Vuelos</strong>
          <div class="small">Mapa del sitio</div>
        </div>
        <div class="footer-map">
          <a href="/index.html">Home</a>
          <a href="/login.html">Login/Registro</a>
          <a href="/profile.html">Perfil</a>
          <a href="/flights.html">Busqueda de vuelos</a>
          <a href="/reservations.html">Reservas</a>
          <a href="/admin.html">Panel Admin</a>
          <a href="/ceo.html">Panel CEO</a>
          <a href="/novedades.html">Novedades</a>
        </div>
      </div>
    </footer>
  `;
}

document.addEventListener('DOMContentLoaded', () => {
  renderNavbar();
  renderFooter();
});
