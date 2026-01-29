<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) walidacja + zapis do bazy
    // 2) ustaw flash, jeśli chcesz
    $_SESSION['flash_success'] = 'Konto utworzone! Zaloguj się.';
    header('Location: login.php'); // albo register_success.php
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator zdolności kredytowej</title>
    <link rel="stylesheet" href="css/style.css?v=2" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="js/auth_validation.js" defer></script>
</head>
<body>
<div class="container">
    <div class="card-header">
        <h1>Kalkulator zdolności kredytowej</h1>
    </div>

    <div class="auth-tabs">
        <a class="auth-tab" href="login.php">Logowanie</a>
        <a class="auth-tab is-active" href="register.php">Nowe konto</a>
    </div>
    <form method="POST">
        <label>Imię:</label>
        <input type="text" name="imie" pattern="[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż]+([ '-][A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż]+)" required><br>
        <label>Nazwisko:</label>
        <input type="text" name="nazwisko" pattern="[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż]+([ '-][A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż]+)" required><br>
        <label>Adres e-mail:</label>
        <input id="email" type="email" name="email" required><br>
        <div id="emailHint" class="hint"></div>
        <label>Hasło:</label>
        <input id="password" type="password" name="password" placeholder="min. 10 znaków, w tym cyfry i znaki specjalne" required><br>
        <div id="passwordHint" class="hint"></div>
        <button type="submit">Zarejestruj się</button>
        <p class="terms">Rejestrując się potwierdzasz, że akceptujesz
            <a href="docs/regulamin.pdf" download="Regulamin.pdf">Regulamin</a>.</p>
    </form>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
