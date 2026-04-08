document.addEventListener('DOMContentLoaded', async () => {
  const newsList = document.getElementById('news-list');
  if (!newsList) return;

  try {
    const news = await apiRequest('/news');
    newsList.innerHTML = news.length
      ? news
          .map(
            (n) => `
            <div class="card p-3 mb-3">
              <h5>${n.title}</h5>
              <p class="mb-1">${n.content}</p>
              <small class="text-muted">${new Date(n.created_at).toLocaleString()}</small>
            </div>
          `
          )
          .join('')
      : '<p>No hay novedades publicadas.</p>';
  } catch (error) {
    newsList.innerHTML = `<p class="text-danger">${error.message}</p>`;
  }
});
