<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikersbeheer - TravelEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">TravelEasy</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Welkom, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
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
        <h1>Gebruikersbeheer</h1>
        <?php if (isset($_SESSION['user_success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['user_success'] ?></div>
            <?php unset($_SESSION['user_success']); ?>
        <?php endif; ?>
        <a href="/users/create" class="btn btn-success mb-3">Nieuwe gebruiker</a>

        <?php if (empty($users)): ?>
            <p class="alert alert-warning">Er zijn geen actieve gebruikers.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>E-mail</th>
                        <th>Rol</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role_name']) ?></td>
                            <td>
                                <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-primary">Bewerken</a>
                                <form method="POST" action="/users/delete/<?= $user['id'] ?>" style="display:inline;">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>