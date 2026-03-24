<!DOCTYPE html>
<html>
<head>
    <title>Gebruikersbeheer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Gebruikers</h1>
    <?php if (isset($_SESSION['user_success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['user_success'] ?></div>
        <?php unset($_SESSION['user_success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['user_errors'])): ?>
        <div class="alert alert-danger"><ul><?php foreach ($_SESSION['user_errors'] as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul></div>
        <?php unset($_SESSION['user_errors']); ?>
    <?php endif; ?>
    <a href="/users/create" class="btn btn-primary mb-3">Nieuwe gebruiker</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Naam</th><th>E-mail</th><th>Rol</th><th>Acties</th></tr></thead>
        <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role_name']) ?></td>
            <td>
                <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning">Bewerken</a>
                <form method="POST" action="/users/delete/<?= $user['id'] ?>" style="display:inline;">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Weet u het zeker?')">Verwijder</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>