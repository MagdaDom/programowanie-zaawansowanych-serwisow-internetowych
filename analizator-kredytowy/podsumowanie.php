<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';
session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    header('Location: login.php'); exit;
}
$session_id = session_id();
$user_id = $_SESSION['user_id'];

$minusy   = $_SESSION['minusy']   ?? [];
$plusy    = $_SESSION['plusy']    ?? [];
$zdolnosc = $_SESSION['zdolnosc'] ?? 0;
$rata     = $_SESSION['rata']     ?? 0;

echo "</br>".print_r($minusy);
echo "</br>".print_r($plusy);
echo "</br>".$zdolnosc;
echo "</br>".$rata;
echo "</br>";
$parametry = readParametersFromCsv("src/dodatkowe_parametry.csv"); //dodatkowe parametry wczytywane z pliku CSV
$avgSalaryNet = getKpiValue($parametry, 'średnia krajowa');
echo "</br>".print_r($parametry);
echo "</br>".$avgSalaryNet;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {        //zapisujemy ID do bazy
    //zacznij nową sesję (bez wylogowania) dla kolejnych obliczeń
    session_regenerate_id(false);
    unset($_SESSION['suma_dochodow']);
    unset($_SESSION['suma_wydatkow']);
    unset($_SESSION['min_wydatkow']);
    unset($_SESSION['suma_dlugu']);
    unset($_SESSION['minusy']);
    unset($_SESSION['plusy']);
    unset($_SESSION['zdolnosc']);
    unset($_SESSION['rata']);
    //przechodzimy do strony głównej w celu ponownego obliczenia zdolności kredytowej
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator zdolności kredytowej</title>
    <link rel="stylesheet" href="css/style.css?v=2" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="js/expenses.js" defer></script>
</head>
<body>
<div class="container-long">
    <div class="card-header">
        <h1>Kalkulator zdolności kredytowej</h1>
    </div>
    <?php if (!empty($_SESSION['user_email'])): ?>
        <div class="user-bar">
            Witaj, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_COMPAT, 'UTF-8'); ?> (<?php echo $_SESSION['user_id'] ?>)!
        </div>
    <?php endif; ?>
    <form method="POST">
    <?php if ($zdolnosc > 0): ?>
        <h1 class="success">Decyzja kredytowa: POZYTYWNA!</h1>
        <h2 class="success">Przyznano <?php $zdolnosc ?> kredytu z miesięczną ratą <?php $rata?> .</h2>

        <h3>Szczegóły</h3>
        <hr class="section-divider">
        <ul>
            <?php foreach ($minusy as $klucz => $tekst): ?>
                <li class = "fail"><?= htmlspecialchars($tekst) ?></li>
            <?php endforeach; ?>
        </ul>
        <ul>
            <?php foreach ($plusy as $klucz => $tekst): ?>
                <li class = "success"><?= htmlspecialchars($tekst) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <h1 class="fail">Decyzja kredytowa: NEGATYWNA!</h1>
    </br>
        <h3>Szczegóły</h3>
        <hr class="section-divider">
        <ul>
            <?php foreach ($minusy as $klucz => $tekst): ?>
                <li class = "fail"><?= htmlspecialchars($tekst) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
        <button type="submit">OBLICZ PONOWNIE</button>
    </form>


    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
