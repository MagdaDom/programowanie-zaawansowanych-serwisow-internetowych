<?php
/*
include('src/auth.php');
$users = getQuery("SELECT email, password from uzytkownicy");
session_start();
if ($_POST['login'] === 'admin' && $_POST['password'] === '1234') {
    $_SESSION['logged'] = true;
    $_SESSION['user'] = 'admin';
    header('Location: index.php'); //przekieruj do index.php po ppoprawnym zalogowaniu
    echo "Zalogowano poprawnie";
} else {
    echo "Błędne dane";
}*/
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator zdolności kredytowej</title>
    <link rel="stylesheet" href="css/style.css?v=2" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/login.js" defer></script>
</head>
<body>
<div class="container">
    <div class="card-header">
        <h1>Kalkulator zdolności kredytowej</h1>
    </div>

    <div class="auth-tabs">
        <a class="auth-tab is-active" href="login.php">Logowanie</a>
        <a class="auth-tab" href="register.php">Nowe konto</a>
    </div>
    <form method="GET">
        <label>Login:</label>
        <input type="email" id="email" name="login" placeholder="adres e-mail podany przy rejestracji"><br>
        <div id="emailHint" class="hint"></div>
        <label>Hasło:</label>
        <input type="password" id = "password" name="password" placeholder="min. 10 znaków, w tym cyfry i znaki specjalne"><br>
        <div id="passwordHint" class="hint"></div>
        <button type="submit">Zaloguj</button>
    </form>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
