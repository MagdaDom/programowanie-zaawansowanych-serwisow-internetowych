<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';
session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    header('Location: login.php'); exit;
}
//$oprocentowanie = readCsvToTable("src/oprocentowanie.csv");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oblicz'])) {
    if ($_POST['oblicz']) {
        $session_id = session_id();

        // 3. Zapisz
        //$stmt = $pdo->prepare("INSERT INTO wyniki (wynik_id, session_id, user_email, zdolnosc, created_at) VALUES (?, ?, ?, ?, NOW())");
        //$stmt->execute([$wynik_id, $session_id, $_SESSION['user_email'], $zdolnosc]);
        //nowe id dla nowego wyniku
        session_regenerate_id(false);
    }
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

    <form method="POST">
        <h3>Informacje o kredytobiorcy</h3>
        <hr class="section-divider">
        <label>Łączne dochody:</label>
        <div class="inline-input">
            <input class="add-input" type="number" id="income-display" value="" required
                   style="pointer-events: none;" onkeydown="return false" onfocus="this.blur()" >
            <button class = "add-button" id="dochody" onclick="window.location.href='dochody.php'">
                Dodaj <i class="bi bi-plus"></i><i class="bi bi-currency-exchange"></i></button>
        </div>
        <input type="text" name="income-source" placeholder="Użyj przycisku Dodaj+ by dodać dochody" disabled readonly>
        <label>Łączne wydatki:</label>
        <div class="inline-input">
            <input class="add-input" type="number" id="debt-display" value="" required
                   style="pointer-events: none;" onkeydown="return false" onfocus="this.blur()">
            <button class="add-button" id="wydatki" onclick="window.location.href='wydatki.php'">
                Dodaj <i class="bi bi-plus"></i><i class="bi bi-credit-card"></i></button>
        </div>
        <input type="text" name="debt-source" placeholder="Użyj przycisku Dodaj+ by dodać wydatki" disabled readonly>

        <label>Wiek kredytobiorcy:</label>
        <input type="number" name="age" id="age" min="18" max="65" step = 1 required>
        <p class="hint">W przypadku kilku współkredytobiorców, podaj datę urodzenia najstarszego/najstarszej z nich.</p>
        <label>Liczba osób w gospodarstwie domowym:</label>
        <input type="number" name="people" id="people" min = 1 max = 20 step = 1 required>
        <p class="hint">Osoby zamieszkujące razem i wspólnie się utrzymujące.</p>

        </br>
        <h3>Parametry kredytu</h3>
        <hr class="section-divider">
        <label>Okres kredytowania:</label>
        <input type="number" name="years" id="years" value="15" min="1" max="40" step="1" required>
        <label>Rodzaj raty:</label>
        <select name="installment" id="installment" required>
            <option value="" disabled selected hidden>wybierz...</option>
            <option value="fixed">stała</option>
            <option value="declining">malejąca</option>
        </select>
        <label>Rodzaj oprocentowania:</label>
        <select name="rate" id="rate" required>
            <option value="" disabled selected hidden>wybierz...</option>
            <option value="5">zmienne</option>
            <option value="0">stałe</option>
            <option value="2.5">okresowo stałe</option>
        </select>
        <label>Oprocentowanie kredytu (RRSO):</label>
        <input type="number" name="rrso" id="rrso" value = 7.13 min = 1 max = 25 step = 0.01 required>
        <button type="submit">OBLICZ ZDOLNOŚĆ KREDYTOWĄ</button>
    </form>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
