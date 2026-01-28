<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_warning'] = 'Adres e-mail ma niepoprawny format.';
        header('Location: register.php');
        exit;
    }

    header('Location: register.php');
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
        <input type="text" name="imie" required><br>
        <label>Nazwisko:</label>
        <input type="text" name="nazwisko" required><br>
        <label>Adres e-mail:</label>
        <input id="email" type="email" name="email" required><br>
        <div id="emailHint" class="hint"></div>
        <?php
        if(isset($_SESSION['flash_warning'])) {
            $warning = $_SESSION['flash_warning'];
            unset($_SESSION['flash_warning']); // żeby nie wisiało po odświeżeniu
            echo '<div class="hint">' . htmlspecialchars($warning) . '</div>';
        }
        ?>
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
