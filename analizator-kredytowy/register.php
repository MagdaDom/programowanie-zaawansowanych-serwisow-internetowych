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
    <form method="GET">
        <label>Imię:</label>
        <input type="text" name="imie"><br>
        <label>Nazwisko:</label>
        <input type="text" name="nazwisko"><br>
        <label>Adres e-mail:</label>
        <input id="email" type="email" name="email"><br>
        <div id="emailHint" class="hint"></div>
        <label>Hasło:</label>
        <input id="password" type="password" name="password" placeholder="min. 10 znaków, w tym cyfry i znaki specjalne"><br>
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
