<section aria-labelledby="news-page-title">
  <nav class="breadcrumb-air" aria-label="Breadcrumb">
    <a href="<?php echo BASE_URL; ?>/index.php?page=home">Home</a>
    <span>/</span>
    <span aria-current="page">Novedades</span>
  </nav>
  <h1 id="news-page-title" class="h4 mb-3">Novedades</h1>

  <?php
  $newsImages = [
    'https://images.unsplash.com/photo-1529074963764-98f45c47344b?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1530521954074-e64f6810b32d?auto=format&fit=crop&w=1200&q=80',
    'https://images.unsplash.com/photo-1570710891163-6d3b5c47248b?auto=format&fit=crop&w=1200&q=80',
  ];
  ?>

  <?php if (empty($news)): ?>
    <div class="empty-state">
      <span class="empty-state-illustration" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false"><path d="M4 6h16v12H4zM8 10h8M8 14h5"></path></svg>
      </span>
      <h2 class="h6 mb-2">No hay novedades por el momento</h2>
      <p class="mb-0">En breve vas a ver anuncios, promociones y actualizaciones de vuelos.</p>
    </div>
  <?php else: ?>
    <?php foreach ($news as $index => $item): ?>
      <article class="card p-3 mb-3">
        <img class="news-cover" src="<?php echo htmlspecialchars($newsImages[$index % count($newsImages)]); ?>" alt="Imagen de referencia para novedad de vuelos" loading="lazy">
        <h2 class="h6 news-card-title"><?php echo htmlspecialchars($item['title']); ?></h2>
        <p class="mb-1 news-card-text"><?php echo htmlspecialchars($item['content']); ?></p>
        <small class="text-muted"><?php echo htmlspecialchars($item['created_at']); ?></small>
      </article>
    <?php endforeach; ?>
  <?php endif; ?>
</section>

<?php if (($pager['total_pages'] ?? 1) > 1): ?>
  <nav aria-label="Paginacion de novedades" class="pager-nav">
    <div class="pager-summary">Pagina <?php echo (int) $pager['current_page']; ?> de <?php echo (int) $pager['total_pages']; ?></div>
    <ul class="pagination pagination-responsive">
      <li class="page-item <?php echo ($pager['current_page'] <= 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="<?php echo BASE_URL; ?>/index.php?page=news&p=<?php echo max(1, (int) $pager['current_page'] - 1); ?>">Anterior</a>
      </li>
      <?php for ($i = 1; $i <= $pager['total_pages']; $i++): ?>
        <li class="page-item <?php echo $i === $pager['current_page'] ? 'active' : ''; ?>">
          <a class="page-link" href="<?php echo BASE_URL; ?>/index.php?page=news&p=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item <?php echo ($pager['current_page'] >= $pager['total_pages']) ? 'disabled' : ''; ?>">
        <a class="page-link" href="<?php echo BASE_URL; ?>/index.php?page=news&p=<?php echo min((int) $pager['total_pages'], (int) $pager['current_page'] + 1); ?>">Siguiente</a>
      </li>
    </ul>
  </nav>
<?php endif; ?>
