<?php $user = current_user(); ?>
<nav class="navbar navbar-expand-lg navbar-dark app-navbar" aria-label="Barra principal de navegacion">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>/index.php?page=home">AeroUTN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Alternar navegacion">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=flights">Vuelos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=news">Novedades</a></li>
        <?php if ($user): ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=profile">Perfil</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=reservations">Reservas</a></li>
        <?php endif; ?>
        <?php if ($user && $user['role'] === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=admin">Panel Admin</a></li>
        <?php endif; ?>
        <?php if ($user && $user['role'] === 'ceo'): ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=ceo">Panel CEO</a></li>
        <?php endif; ?>
      </ul>
      <div class="d-flex gap-2 align-items-center">
        <?php if ($user): ?>
          <span class="badge text-bg-light"><?php echo htmlspecialchars($user['name']); ?> (<?php echo htmlspecialchars($user['role']); ?>)</span>
          <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=home" class="m-0">
            <input type="hidden" name="action" value="logout">
            <button class="btn btn-sm btn-light" type="submit">Salir</button>
          </form>
        <?php else: ?>
          <a class="btn btn-sm btn-light" href="<?php echo BASE_URL; ?>/index.php?page=login">Ingresar</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<main class="container py-4">
  <?php if ($ok = flash('ok')): ?>
    <div class="alert alert-success" role="status"><?php echo htmlspecialchars($ok); ?></div>
  <?php endif; ?>
  <?php if ($error = flash('error')): ?>
    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
