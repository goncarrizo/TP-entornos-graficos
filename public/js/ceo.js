document.addEventListener('DOMContentLoaded', () => {
  const user = getCurrentUser();
  const msg = document.getElementById('ceo-message');
  const flightsBox = document.getElementById('ceo-flights');
  const flightForm = document.getElementById('flight-form');
  const promoForm = document.getElementById('promo-form');
  const reportBox = document.getElementById('ceo-reports');

  if (!user || user.role !== 'ceo') {
    msg.textContent = 'Acceso solo para CEO.';
    return;
  }

  msg.textContent = `Bienvenido/a ${user.name}`;

  async function loadFlights() {
    const data = await apiRequest('/flights');
    flightsBox.innerHTML = data
      .map((f) => `<li class="list-group-item">#${f.id} ${f.origin} -> ${f.destination} | ${f.airline_name} | $${Number(f.price).toLocaleString()}</li>`)
      .join('');
  }

  async function loadReports() {
    const [sales, occupancy] = await Promise.all([
      apiRequest('/reports/sales'),
      apiRequest('/reports/occupancy'),
    ]);

    reportBox.innerHTML = `
      <div class="card p-3 mb-3">
        <h6>Ventas por aerolinea</h6>
        <ul>${sales.map((s) => `<li>${s.airline}: $${Number(s.total_sales).toLocaleString()}</li>`).join('')}</ul>
      </div>
      <div class="card p-3">
        <h6>Ocupacion por vuelo</h6>
        <ul>${occupancy.map((o) => `<li>Vuelo ${o.id}: ${o.occupancy_percent}% (${o.occupied_seats}/${o.total_seats})</li>`).join('')}</ul>
      </div>
    `;
  }

  flightForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(flightForm);

    try {
      await apiRequest('/flights', {
        method: 'POST',
        body: JSON.stringify({
          airline_id: Number(fd.get('airline_id')),
          origin: fd.get('origin'),
          destination: fd.get('destination'),
          departure_time: fd.get('departure_time'),
          arrival_time: fd.get('arrival_time'),
          price: Number(fd.get('price')),
          total_seats: Number(fd.get('total_seats')),
        }),
      });
      alert('Vuelo creado');
      flightForm.reset();
      loadFlights();
    } catch (error) {
      alert(error.message);
    }
  });

  promoForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData(promoForm);

    try {
      await apiRequest('/promotions', {
        method: 'POST',
        body: JSON.stringify({
          airline_id: Number(fd.get('airline_id')),
          title: fd.get('title'),
          description: fd.get('description'),
          discount_percent: Number(fd.get('discount_percent')),
          is_active: 1,
        }),
      });
      alert('Promocion creada y enviada a aprobacion');
      promoForm.reset();
    } catch (error) {
      alert(error.message);
    }
  });

  loadFlights();
  loadReports();
});
