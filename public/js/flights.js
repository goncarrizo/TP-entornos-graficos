document.addEventListener('DOMContentLoaded', () => {
  const searchForm = document.getElementById('search-form');
  const flightList = document.getElementById('flight-list');

  async function loadFlights(query = '') {
    try {
      const flights = await apiRequest(`/flights${query}`);
      flightList.innerHTML = flights.length
        ? flights
            .map(
              (f) => `
              <div class="col-md-6">
                <div class="card p-3 h-100">
                  <h5>${f.origin} -> ${f.destination}</h5>
                  <p class="mb-1"><strong>Aerolinea:</strong> ${f.airline_name}</p>
                  <p class="mb-1"><strong>Salida:</strong> ${new Date(f.departure_time).toLocaleString()}</p>
                  <p class="mb-1"><strong>Precio:</strong> $${Number(f.price).toLocaleString()}</p>
                  <p class="mb-2"><strong>Asientos disponibles:</strong> ${f.available_seats}</p>
                  ${f.promo_title ? `<p class="text-success"><strong>Promo:</strong> ${f.promo_title} (${f.promo_discount}% OFF)</p>` : ''}
                  <button class="btn btn-outline-primary" onclick="reserveFlight(${f.id})">Reservar</button>
                </div>
              </div>
            `
            )
            .join('')
        : '<p>No se encontraron vuelos.</p>';
    } catch (error) {
      flightList.innerHTML = `<p class="text-danger">${error.message}</p>`;
    }
  }

  window.reserveFlight = async (flightId) => {
    const user = getCurrentUser();
    if (!user) {
      alert('Debes iniciar sesion para reservar.');
      window.location.href = '/login.html';
      return;
    }

    const seats = Number(prompt('Cantidad de asientos a reservar:', '1'));
    if (!seats || seats < 1) {
      return;
    }

    try {
      await apiRequest('/reservations', {
        method: 'POST',
        body: JSON.stringify({ flight_id: flightId, seats }),
      });
      alert('Reserva realizada con exito.');
      loadFlights();
    } catch (error) {
      alert(error.message);
    }
  };

  searchForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const fd = new FormData(searchForm);
    const origin = fd.get('origin');
    const destination = fd.get('destination');
    const date = fd.get('date');

    const params = new URLSearchParams();
    if (origin) params.append('origin', origin);
    if (destination) params.append('destination', destination);
    if (date) params.append('date', date);

    const query = params.toString() ? `?${params.toString()}` : '';
    loadFlights(query);
  });

  loadFlights();
});
