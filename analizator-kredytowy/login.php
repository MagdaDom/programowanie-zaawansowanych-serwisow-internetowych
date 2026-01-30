<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/auth.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['email'])) {
    $password  = $_POST['password'];
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_warning'] = 'Adres e-mail ma niepoprawny format!';
        header('Location: login.php');
        exit;
    }

    if (!userEmailExists($email)) {
        $_SESSION['flash_warning'] = 'Nie ma takiego użytkownika! Użyj opcji "Nowe konto".';
        header('Location: login.php');
        exit;
    }

    if (!credentialsExists($email, $password)) {
        $_SESSION['flash_warning'] = 'Niepoprawne hasło!';
        header('Location: login.php');
        exit;
    }

    $_SESSION['logged'] = true;
    $_SESSION['user_email'] = $email;
    $user = getUserByEmail($email);
    $_SESSION['user_name'] = $user['imie'] . ' ' . $user['nazwisko'];
    $_SESSION['user_id'] = $user['id'];
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator zdolności kredytowej</title>
    <link rel="stylesheet" href="css/style.css?v=4" type="text/css">
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
    <form method="POST">
        <label>Login:</label>
        <input type="email" name="email" placeholder="adres e-mail podany przy rejestracji" required><br>
        <label>Hasło:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Zaloguj</button>
    </form>

    <?php
    if(isset($_SESSION['flash_warning'])) {
        $warning = $_SESSION['flash_warning'];
        unset($_SESSION['flash_warning']); // żeby nie wisiało po odświeżeniu
        echo '<div class="fail"><h4>' . htmlspecialchars($warning) . '</h4></div>';
    }
    if(isset($_SESSION['flash_success'])) {
        $msg = $_SESSION['flash_success'];
        unset($_SESSION['flash_success']); // żeby nie wisiało po odświeżeniu
        echo '<div class="success"><h4>' . htmlspecialchars($msg) . '</h4></div>';
    }
    ?>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
