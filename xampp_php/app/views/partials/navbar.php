<?php
$user = current_user();
?>
<div class="brand-strip" aria-hidden="true"></div>
<nav class="navbar navbar-expand-lg navbar-light app-navbar" aria-label="Barra principal de navegacion">
  <div class="container">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php?page=home">AirARG</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Alternar navegacion">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=flights">Vuelos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php?page=news">Novedades</a></li>
      </ul>
      <div class="d-flex gap-2 align-items-center">
        <?php if ($user): ?>
          <div class="dropdown account-dropdown">
            <button class="btn btn-light dropdown-toggle pill-user account-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="account-avatar account-avatar-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false">
                  <circle cx="12" cy="8" r="3.2"></circle>
                  <path d="M4.5 19.2c0-4 3.4-6.7 7.5-6.7s7.5 2.7 7.5 6.7" fill="none"></path>
                </svg>
              </span>
              <span class="account-copy">
                <span class="account-name"><?php echo htmlspecialchars($user['name']); ?></span>
                <span class="account-role"><?php echo htmlspecialchars($user['role']); ?></span>
              </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animated shadow-sm">
              <li><h6 class="dropdown-header">Cuenta</h6></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=profile">Gestionar cuenta</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=reservations">Mis reservas</a></li>
              <li><hr class="dropdown-divider"></li>
              <?php if ($user['role'] === 'admin'): ?>
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=admin">Panel Admin</a></li>
              <?php endif; ?>
              <?php if ($user['role'] === 'ceo'): ?>
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=ceo">Panel CEO</a></li>
              <?php endif; ?>
              <li>
                <form method="post" action="<?php echo BASE_URL; ?>/index.php?page=home" class="m-0">
                  <input type="hidden" name="action" value="logout">
                  <button class="dropdown-item text-danger" type="submit">Cerrar sesion</button>
                </form>
              </li>
            </ul>
          </div>
        <?php else: ?>
          <a class="btn btn-sm btn-primary" href="<?php echo BASE_URL; ?>/index.php?page=login">Ingresar</a>
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
