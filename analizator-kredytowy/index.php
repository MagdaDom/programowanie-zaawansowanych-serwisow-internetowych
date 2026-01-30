<?php
require_once __DIR__ . '/../config.php';
session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    header('Location: login.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator zdolności kredytowej</title>
    <link rel="stylesheet" href="css/style.css?v=2" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container">
    <div class="card-header">
        <h1>Kalkulator zdolności kredytowej</h1>
    </div>
    <?php if (!empty($_SESSION['user_email'])): ?>
        <div class="user-bar">
            Witaj, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_COMPAT, 'UTF-8'); ?>!
        </div>
    <?php endif; ?>

    <form method="GET">
        <!--<label>Data urodzenia kredytobiorcy:</label>
        <input type="number" name="income" id="age" required>
        <p>W przypadku kilku współkredytobiorców, podaj datę urodzenia najstarszego/najstarszej z nich.</p>-->
        <label>Łączne dochody:</label>
        <input type="number" name="income" id="income" required disabled>
        <button class = "add-button" type="dochody">Dodaj dochody</button>
        <label>Łączne wydatki:</label>
        <button class="button-add" type="wydatki">Dodaj wydatki</button>
        <input type="number" name="debt" id="debt" required disabled>
        <label>Wiek kredytobiorcy:</label>
        <input type="number" name="age" id="age" min="18" max="65" step = 1 required>
        <button class="btn-add" type="wydatki">Dodaj wydatki</button>
        <p class="hint">W przypadku kilku współkredytobiorców, podaj datę urodzenia najstarszego/najstarszej z nich.</p>
        <label>Liczba osób w gospodarstwie domowym:</label>
        <input type="number" name="people" id="people" min = 1 max = 20 step = 1 required>
        <p class="hint">Osoby zamieszkujące razem i wspólnie się utrzymujące.</p>
        <label>Okres kredytowania:</label>
        <input type="number" name="years" id="years" value="15" min="1" max="40" step="1" required>
        <label>Oprocentowanie kredytu (RRSO):</label>
        <input type="number" name="rrso" id="rrso" required>
        <label>Rodzaj oprocentowania:</label>
        <select name="rate" id="rate" required>
            <option value="" disabled selected hidden>wybierz...</option>
            <option value="5">zmienne</option>
            <option value="0">stałe</option>
            <option value="2.5">okresowo stałe</option>
        </select>
        <label>Rodzaj raty:</label>
        <select name="installment" id="installment" required>
            <option value="" disabled selected hidden>wybierz...</option>
            <option value="fixed">stała</option>
            <option value="declining">malejąca</option>
        </select>
        <button type="submit">OBLICZ ZDOLNOŚĆ KREDYTOWĄ</button>
    </form>
    <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['rrso'])):
        $txt = $_GET['rrso'];

    endif; ?>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
