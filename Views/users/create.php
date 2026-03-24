<!DOCTYPE html>
<html>
<head>
    <title>Gebruiker toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Nieuwe gebruiker</h1>
    <?php if (isset($_SESSION['user_errors'])): ?>
        <div class="alert alert-danger"><ul><?php foreach ($_SESSION['user_errors'] as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul></div>
        <?php unset($_SESSION['user_errors']); ?>
    <?php endif; ?>
    <form method="POST" action="/users/create">
        <div class="mb-3"><label>Naam</label><input type="text" name="name" class="form-control" value="<?= $_SESSION['old_input']['name'] ?? '' ?>" required></div>
        <div class="mb-3"><label>E-mail</label><input type="email" name="email" class="form-control" value="<?= $_SESSION['old_input']['email'] ?? '' ?>" required></div>
        <div class="mb-3"><label>Wachtwoord</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-3"><label>Rol</label><select name="role_id" class="form-control" required>
            <option value="">Kies...</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>" <?= (isset($_SESSION['old_input']['role_id']) && $_SESSION['old_input']['role_id'] == $role['id']) ? 'selected' : '' ?>><?= htmlspecialchars($role['name']) ?></option>
            <?php endforeach; ?>
        </select></div>
        <button type="submit" class="btn btn-primary">Opslaan</button>
        <a href="/users" class="btn btn-secondary">Annuleren</a>
    </form>
    <?php unset($_SESSION['old_input']); ?>
</div>
</body>
</html>