document.addEventListener('DOMContentLoaded', () => {
  const user = getCurrentUser();
  const msg = document.getElementById('admin-message');
  const airlinesBox = document.getElementById('admin-airlines');
  const promosBox = document.getElementById('admin-promos');
  const newsForm = document.getElementById('news-form');
  const reportBox = document.getElementById('admin-reports');

  if (!user || user.role !== 'admin') {
    msg.textContent = 'Acceso solo para administradores.';
    return;
  }
  msg.textContent = `Bienvenido/a ${user.name}`;

  async function loadAirlines() {
    const data = await apiRequest('/airlines');
    airlinesBox.innerHTML = data.map((a) => `<li class="list-group-item">${a.name} (${a.code}) - ${a.country}</li>`).join('');
  }

  async function loadPromotions() {
    const data = await apiRequest('/promotions');
    promosBox.innerHTML = data
      .map(
        (p) => `<li class="list-group-item d-flex justify-content-between align-items-center">
          <span>${p.airline_name} - ${p.title} (${p.discount_percent}%): ${p.status}</span>
          <span>
            <button class="btn btn-sm btn-success" onclick="approvePromo(${p.id})">Aprobar</button>
            <button class="btn btn-sm btn-warning" onclick="denyPromo(${p.id})">Denegar</button>
          </span>
        </li>`
      )
      .join('');
  }

  async function loadReports() {
    const [general, sales] = await Promise.all([
      apiRequest('/reports/general'),
      apiRequest('/reports/sales'),
    ]);

    reportBox.innerHTML = `
      <div class="card p-3 mb-3">
        <h6>Resumen general</h6>
        <p>Usuarios: ${general.total_users}</p>
        <p>Vuelos: ${general.total_flights}</p>
        <p>Reservas: ${general.total_reservations}</p>
      </div>
      <div class="card p-3">
        <h6>Ventas por aerolinea</h6>
        <ul>
          ${sales.map((s) => `<li>${s.airline}: $${Number(s.total_sales).toLocaleString()}</li>`).join('')}
        </ul>
      </div>
    `;
  }

  window.approvePromo = async (id) => {
    await apiRequest(`/promotions/${id}/approve`, { method: 'PATCH' });
    loadPromotions();
  };

  window.denyPromo = async (id) => {
    await apiRequest(`/promotions/${id}/deny`, { method: 'PATCH' });
    loadPromotions();
  };

  newsForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(newsForm);
    try {
      await apiRequest('/news', {
        method: 'POST',
        body: JSON.stringify({
          title: fd.get('title'),
          content: fd.get('content'),
        }),
      });
      alert('Novedad creada');
      newsForm.reset();
    } catch (error) {
      alert(error.message);
    }
  });

  loadAirlines();
  loadPromotions();
  loadReports();
});
