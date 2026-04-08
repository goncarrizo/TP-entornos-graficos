<section aria-labelledby="news-page-title">
  <h1 id="news-page-title" class="h4 mb-3">Novedades</h1>

  <?php foreach ($news as $item): ?>
    <article class="card p-3 mb-3">
      <h2 class="h6"><?php echo htmlspecialchars($item['title']); ?></h2>
      <p class="mb-1"><?php echo htmlspecialchars($item['content']); ?></p>
      <small class="text-muted"><?php echo htmlspecialchars($item['created_at']); ?></small>
    </article>
  <?php endforeach; ?>
</section>

<?php if (($pager['total_pages'] ?? 1) > 1): ?>
  <nav aria-label="Paginacion de novedades">
    <ul class="pagination">
      <?php for ($i = 1; $i <= $pager['total_pages']; $i++): ?>
        <li class="page-item <?php echo $i === $pager['current_page'] ? 'active' : ''; ?>">
          <a class="page-link" href="<?php echo BASE_URL; ?>/index.php?page=news&p=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
<?php endif; ?>
