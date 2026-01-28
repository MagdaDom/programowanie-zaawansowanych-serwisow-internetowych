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
        <input type="email" name="email" placeholder="adres e-mail podany przy rejestracji" required><br>
        <label>Hasło:</label>
        <input type="password" required><br>
        <button type="submit">Zaloguj</button>
    </form>

    <?php
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['password'], $_GET['email'])) {
        $password  = $_GET['password'];
        $email = $_GET['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<div class="result fail"><h4>Adres e-mail ma niepoprawny format!</h4></div>';
        } else {
            $isEmailValid = userEmailExists($email);
            if(!$isEmailValid) {
                echo "<div class=\"result fail\"><h4>Nie ma takiego użytkownika!</h4></div>";
            } else {
                $isUserValid = credentialsExists($email, $password);
                if(!$isUserValid) {
                    echo "<div class=\"result fail\"><h4>Niepoprawne hasło!</h4></div>";
                } else {
                    header('Location: index.php');
                    exit;
                }
            }
        }
    }
    ?>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
