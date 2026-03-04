<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen - TravelEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Inloggen</h2>
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['login_error'] ?></div>
                    <?php unset($_SESSION['login_error']); ?>
                <?php endif; ?>
                <form method="POST" action="/login">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mailadres</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Wachtwoord</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Inloggen</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>