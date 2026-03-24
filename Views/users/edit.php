<!DOCTYPE html>
<html>
<head>
    <title>Gebruiker bewerken</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Gebruiker bewerken</h1>
    <?php if (isset($_SESSION['user_errors'])): ?>
        <div class="alert alert-danger"><ul><?php foreach ($_SESSION['user_errors'] as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul></div>
        <?php unset($_SESSION['user_errors']); ?>
    <?php endif; ?>
    <form method="POST" action="/users/edit/<?= $user['id'] ?>">
        <div class="mb-3"><label>Naam</label><input type="text" name="name" class="form-control" value="<?= $_SESSION['old_input']['name'] ?? $user['name'] ?>" required></div>
        <div class="mb-3"><label>E-mail</label><input type="email" name="email" class="form-control" value="<?= $_SESSION['old_input']['email'] ?? $user['email'] ?>" required></div>
        <div class="mb-3"><label>Nieuw wachtwoord (laat leeg om te behouden)</label><input type="password" name="password" class="form-control"></div>
        <div class="mb-3"><label>Rol</label><select name="role_id" class="form-control" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>" <?= ($role['id'] == $user['role_id']) ? 'selected' : '' ?>><?= htmlspecialchars($role['name']) ?></option>
            <?php endforeach; ?>
        </select></div>
        <button type="submit" class="btn btn-primary">Bijwerken</button>
        <a href="/users" class="btn btn-secondary">Annuleren</a>
    </form>
    <?php unset($_SESSION['old_input']); ?>
</div>
</body>
</html>