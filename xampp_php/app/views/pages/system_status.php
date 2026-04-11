<section aria-labelledby="status-title" class="page-shell">
  <header>
    <p class="hero-kicker mb-2">Administracion interna</p>
    <h1 id="status-title" class="h4 page-title">Estado del sistema</h1>
    <p class="page-subtitle mb-0">Chequeo rapido de salud del entorno local en XAMPP.</p>
  </header>

  <div class="row g-3" role="list" aria-label="Resumen de salud del sistema">
    <article class="col-md-6 col-xl-3" role="listitem">
      <div class="card p-3 h-100">
        <p class="metric-label mb-1">PHP</p>
        <p class="metric-value mb-0"><?php echo htmlspecialchars($status['php_version']); ?></p>
      </div>
    </article>

    <article class="col-md-6 col-xl-3" role="listitem">
      <div class="card p-3 h-100">
        <p class="metric-label mb-1">Base de datos</p>
        <p class="mb-1">
          <span class="status-badge <?php echo $status['db_ok'] ? 'success' : 'danger'; ?>">
            <?php echo $status['db_ok'] ? 'OK' : 'FALLO'; ?>
          </span>
        </p>
        <p class="small text-muted mb-0"><?php echo htmlspecialchars($status['db_message']); ?></p>
      </div>
    </article>

    <article class="col-md-6 col-xl-3" role="listitem">
      <div class="card p-3 h-100">
        <p class="metric-label mb-1">Mail fallback</p>
        <p class="mb-1">
          <span class="status-badge <?php echo $status['mail_log_exists'] ? 'success' : 'warning'; ?>">
            <?php echo $status['mail_log_exists'] ? 'Disponible' : 'Sin registros'; ?>
          </span>
        </p>
        <p class="small text-muted mb-0"><?php echo htmlspecialchars($status['mail_log_path']); ?></p>
      </div>
    </article>

    <article class="col-md-6 col-xl-3" role="listitem">
      <div class="card p-3 h-100">
        <p class="metric-label mb-1">Hora servidor</p>
        <p class="metric-value mb-0"><?php echo htmlspecialchars($status['server_time']); ?></p>
      </div>
    </article>
  </div>
</section>
