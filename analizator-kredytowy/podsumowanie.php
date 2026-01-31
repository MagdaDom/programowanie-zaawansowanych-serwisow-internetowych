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
    <form>
        <h3>Szczegóły</h3>
        <hr class="section-divider">
        <ul>
            <?php foreach ($minusy as $klucz => $tekst): ?>
                <li class = "fail"><?= htmlspecialchars($tekst) ?></li>
            <?php endforeach; ?>
        </ul>
    </form>
    <?php endif; ?>


    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
