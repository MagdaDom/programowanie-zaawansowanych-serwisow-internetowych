<?php
/*session_start();
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
</head>
<body>
<div class="container">
    <div class="card-header">
        <h1>Kalkulator zdolności kredytowej</h1>
        <h3>Wykonała: Magdalena Domaszczyńska</h3>
    </div>

    <div class="auth-tabs">
        <a class="auth-tab is-active" href="login.php">Logowanie</a>
        <a class="auth-tab" href="register.php">Nowe konto</a>
    </div>
    <form method="GET">
        <label>Login:</label>
        <input type="text" name="login" placeholder="adres e-mail podany przy rejestracji"><br>
        <label>Hasło:</label>
        <input type="password" name="password" placeholder="min. 10 znaków, w tym cyfry i znaki specjalne"><br>
        <button type="submit">Zaloguj</button>
    </form>
</div>
</body>
</html>
