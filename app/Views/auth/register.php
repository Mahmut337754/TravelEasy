<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registratie - TravelEasy</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <h1>Registratie</h1>
    <form action="/register" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" required>
        <br>

        <label for="role">Rol:</label>
        <select name="role" id="role" required>
            <option value="Reisadviseur">Reisadviseur</option>
            <option value="Financieel">Financieel medewerker</option>
            <option value="Manager">Manager</option>
            <option value="Admin">Administrator</option>
        </select>
        <br>

        <button type="submit">Registreer</button>
    </form>

    <p>Al een account? <a href="/login">Login hier</a></p>
</body>

</html>