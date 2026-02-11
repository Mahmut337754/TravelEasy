<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - TravelEasy</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <h1>Login</h1>
    <form action="/login" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <br>

        <button type="submit">Login</button>
    </form>

    <p>Nog geen account? <a href="/register">Registreer hier</a></p>
</body>

</html>