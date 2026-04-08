<section aria-labelledby="profile-title">
  <h1 id="profile-title" class="h4 mb-3">Perfil de usuario</h1>
  <div class="card p-4">
    <ul class="list-group">
      <li class="list-group-item"><strong>ID:</strong> <?php echo (int) $user['id']; ?></li>
      <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($user['name']); ?></li>
      <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
      <li class="list-group-item"><strong>Rol:</strong> <?php echo htmlspecialchars($user['role']); ?></li>
    </ul>
  </div>
</section>
