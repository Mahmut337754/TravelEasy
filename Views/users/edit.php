<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker bewerken - TravelEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">TravelEasy</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Welkom, <?= $_SESSION['user_name'] ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Uitloggen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Gebruiker bewerken</h1>
        <?php if (isset($_SESSION['user_errors'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['user_errors'] as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['user_errors']); ?>
        <?php endif; ?>
        <form method="POST" action="/users/update/<?= $user['id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Naam</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($_SESSION['old_input']['name'] ?? $user['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mailadres</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['old_input']['email'] ?? $user['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Wachtwoord (laat leeg om niet te wijzigen)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Rol</label>
                <select class="form-select" id="role_id" name="role_id" required>
                    <option value="">Kies een rol</option>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role['id'] ?>" <?= (isset($_SESSION['old_input']['role_id']) ? $_SESSION['old_input']['role_id'] : $user['role_id']) == $role['id'] ? 'selected' : '' ?>><?= htmlspecialchars($role['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Bijwerken</button>
            <a href="/users" class="btn btn-secondary">Annuleren</a>
        </form>
        <?php unset($_SESSION['old_input']); ?>
    </div>
</body>

</html>