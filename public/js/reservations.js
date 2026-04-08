document.addEventListener('DOMContentLoaded', () => {
  const list = document.getElementById('reservation-list');

  async function loadReservations() {
    const user = getCurrentUser();
    if (!user) {
      list.innerHTML = '<p>Debes iniciar sesion para ver tus reservas.</p>';
      return;
    }

    try {
      const reservations = await apiRequest('/reservations/mine');
      list.innerHTML = reservations.length
        ? reservations
            .map(
              (r) => `
                <div class="card p-3 mb-3">
                  <h5>${r.origin} -> ${r.destination}</h5>
                  <p class="mb-1"><strong>Aerolinea:</strong> ${r.airline_name}</p>
                  <p class="mb-1"><strong>Salida:</strong> ${new Date(r.departure_time).toLocaleString()}</p>
                  <p class="mb-1"><strong>Asientos:</strong> ${r.seats}</p>
                  <p class="mb-1"><strong>Total:</strong> $${Number(r.total_amount).toLocaleString()}</p>
                  <p class="mb-2"><strong>Estado:</strong> ${r.status}</p>
                  ${
                    r.status !== 'cancelled'
                      ? `<button class="btn btn-sm btn-danger" onclick="cancelReservation(${r.id})">Cancelar</button>`
                      : ''
                  }
                </div>
              `
            )
            .join('')
        : '<p>No tenes reservas aun.</p>';
    } catch (error) {
      list.innerHTML = `<p class="text-danger">${error.message}</p>`;
    }
  }

  window.cancelReservation = async (id) => {
    if (!confirm('Seguro que queres cancelar la reserva?')) return;
    try {
      await apiRequest(`/reservations/${id}/cancel`, { method: 'PATCH' });
      alert('Reserva cancelada.');
      loadReservations();
    } catch (error) {
      alert(error.message);
    }
  };

  loadReservations();
});
