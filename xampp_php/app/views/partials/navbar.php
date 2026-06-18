<?php
$user = current_user();
$activePage = $_GET['page'] ?? 'home';
?>
<div class="brand-strip" aria-hidden="true"></div>
<a class="skip-link" href="#contenido-principal">Saltar al contenido principal</a>
<nav class="navbar navbar-expand-lg navbar-light app-navbar" aria-label="Barra principal de navegacion">
  <div class="container">
    <a class="navbar-brand brand-with-plane" href="<?php echo BASE_URL; ?>/index.php?page=home">
      <span class="brand-plane" aria-hidden="true">
        <svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false">
          <path d="M2.5 13.2c0-.7.5-1.3 1.2-1.5l6.1-1.6 4.8-6.1c.5-.6 1.2-1 2-1h1l-2 7.3 4.8-1.3 2.3-2.2c.3-.3.8-.5 1.2-.5h.8c.8 0 1.5.7 1.5 1.5 0 .5-.2 1-.6 1.3l-2.2 2 2.2 2c.4.3.6.8.6 1.3 0 .8-.7 1.5-1.5 1.5h-.8c-.5 0-.9-.2-1.2-.5l-2.3-2.2-4.8-1.3 2 7.3h-1c-.8 0-1.5-.4-2-1l-4.8-6.1-6.1-1.6c-.7-.2-1.2-.8-1.2-1.5Z"></path>
        </svg>
      </span>
      <span>AirARG</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Alternar navegacion">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link <?php echo $activePage === 'home' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/index.php?page=home">Home</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $activePage === 'flights' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/index.php?page=flights">Vuelos</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $activePage === 'news' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/index.php?page=news">Novedades</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $activePage === 'faq' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/index.php?page=faq">Ayuda</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $activePage === 'contact' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/index.php?page=contact">Contacto</a></li>
        <?php if ($user): ?>
          <li class="nav-item"><a class="nav-link <?php echo $activePage === 'reservations' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>/index.php?page=reservations">Mis reservas</a></li>
        <?php endif; ?>
      </ul>
      <div class="d-flex gap-2 align-items-center">
        <?php if ($user): ?>
          <div class="dropdown account-dropdown">
            <button class="btn btn-light dropdown-toggle pill-user account-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Abrir menu de cuenta de <?php echo htmlspecialchars($user['name']); ?>">
              <span class="account-avatar account-avatar-icon" aria-hidden="true">
                <?php
                  $userIcon = $user['user_icon'] ?? null;
                  $userName = (string) ($user['name'] ?? '');
                  $initials = trim(preg_replace('/\s+/', ' ', $userName));
                  $initialsParts = $initials !== '' ? explode(' ', $initials) : [];
                  $initials = $initialsParts
                    ? strtoupper(substr($initialsParts[0] ?? '', 0, 1) . substr($initialsParts[1] ?? '', 0, 1))
                    : '';

                  $svgMap = [
                    'plane' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M2.5 13.2c0-.7.5-1.3 1.2-1.5l6.1-1.6 4.8-6.1c.5-.6 1.2-1 2-1h1l-2 7.3 4.8-1.3 2.3-2.2c.3-.3.8-.5 1.2-.5h.8c.8 0 1.5.7 1.5 1.5 0 .5-.2 1-.6 1.3l-2.2 2 2.2 2c.4.3.6.8.6 1.3 0 .8-.7 1.5-1.5 1.5h-.8c-.5 0-.9-.2-1.2-.5l-2.3-2.2-4.8-1.3 2 7.3h-1c-.8 0-1.5-.4-2-1l-4.8-6.1-6.1-1.6c-.7-.2-1.2-.8-1.2-1.5Z"/></svg>',
                    'ticket' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M3 9V7.5C3 6.1 4.1 5 5.5 5H18.5C19.9 5 21 6.1 21 7.5V9a2 2 0 0 0 0 6v1.5c0 1.4-1.1 2.5-2.5 2.5H5.5C4.1 20 3 18.9 3 17.5V15a2 2 0 0 0 0-6Z"/><path d="M12 8v8"/><path d="M9 10h.01"/><path d="M15 14h.01"/></svg>',
                    'map' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M9 18l-6 3V6l6-3 6 3 6-3v15l-6 3-6-3Z"/><path d="M9 3v15"/><path d="M15 6v15"/></svg>',
                    'shield' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="M9.5 12l1.8 1.8 3.2-3.7"/></svg>',
                    'star' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M12 2l3.1 6.6 7.3 1.1-5.2 5.1 1.2 7.2L12 18.9 5.6 22 6.8 14.8 1.6 9.7 8.9 8.6 12 2Z"/></svg>',
                    'heart' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><path d="M20.8 8.6c0 6.3-8.8 11.7-8.8 11.7S3.2 14.9 3.2 8.6c0-2.5 2-4.5 4.5-4.5 1.6 0 3 .8 3.8 2 0.8-1.2 2.2-2 3.8-2 2.5 0 4.5 2 4.5 4.5Z"/></svg>',
                    'user' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><circle cx="12" cy="8" r="3.2"/><path d="M4.5 19.2c0-4 3.4-6.7 7.5-6.7s7.5 2.7 7.5 6.7"/></svg>',
                    'globe' => '<svg viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.6 3 14.4 0 18"/><path d="M12 3c-3 3.6-3 14.4 0 18"/></svg>'
                  ];

                  // Si no hay icono válido, mostrar iniciales
                  if (!is_string($userIcon) || $userIcon === '' || !array_key_exists($userIcon, $svgMap)) {
                    echo htmlspecialchars($initials !== '' ? $initials : 'AR', ENT_QUOTES, 'UTF-8');
                  } else {
                    echo $svgMap[$userIcon];
                  }
                ?>
              </span>
              <span class="account-copy">
                <span class="account-name"><?php echo htmlspecialchars($user['name']); ?></span>
              </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animated shadow-sm">
              <li><h6 class="dropdown-header">Cuenta</h6></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=profile">Resumen de cuenta</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=account_edit">Editar datos</a></li>
              <li><hr class="dropdown-divider"></li>
              <?php if ($user['role'] === 'admin'): ?>
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=admin">Panel Admin</a></li>
                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=system_status">Estado del sistema</a></li>
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
<main id="contenido-principal" class="container py-4" tabindex="-1">
  <?php $ok = flash('ok'); ?>
  <?php if (is_string($ok) && trim($ok) !== ''): ?>
    <div class="alert alert-success flash-inline" role="status">
      <span class="flash-badge ok" aria-hidden="true">✓</span>
      <div class="flash-content">
        <strong>Listo</strong>
        <span><?php echo htmlspecialchars($ok); ?></span>
      </div>
    </div>
  <?php endif; ?>

  <?php $error = flash('error'); ?>
  <?php if (is_string($error) && trim($error) !== ''): ?>
    <div class="alert alert-danger flash-inline" role="alert" aria-live="assertive">
      <span class="flash-badge error" aria-hidden="true">!</span>
      <div class="flash-content">
        <strong>Atencion</strong>
        <span><?php echo htmlspecialchars($error); ?></span>
      </div>
    </div>
  <?php endif; ?>
