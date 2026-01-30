<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';
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
        <h3>Podaj swoje źródła dochodów</h3>
        <hr class="section-divider">
        <!--<select name="rodzaj">
            <?php foreach ($oprocentowanie as $rodzaj => $rrso): ?>
                <option value="<?php echo $rodzaj; ?>">
                    <?php echo $rodzaj; ?> (<?php echo $rrso; ?>%)
                </option>
            <?php endforeach; ?>
        </select>-->
        <label>Łączne dochody:</label>
        <div class="inline-input">
            <input class="add-input" type="number" id="income-display" value="" required
                   style="pointer-events: none;" onkeydown="return false" onfocus="this.blur()" >
            <button class = "add-button" type="dochody" onclick="window.location.href='dochody.php'">
                Dodaj <i class="bi bi-plus"></i><i class="bi bi-currency-exchange"></i></button>
        </div>
        <input type="text" name="income-source" placeholder="Użyj przycisku Dodaj+ by dodać dochody" disabled readonly>
        <label>Łączne wydatki:</label>
        <div class="inline-input">
            <input class="add-input" type="number" id="debt-display" value="" required
                   style="pointer-events: none;" onkeydown="return false" onfocus="this.blur()">
            <button class="add-button" type="wydatki">Dodaj <i class="bi bi-plus"></i><i class="bi bi-credit-card"></i></button>
        </div>
        <input type="text" name="debt-source" placeholder="Użyj przycisku Dodaj+ by dodać wydatki" disabled readonly>
        <button type="submit">OBLICZ ZDOLNOŚĆ KREDYTOWĄ</button>
    </form>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
