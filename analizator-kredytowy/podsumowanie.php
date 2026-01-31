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

echo "</br>".$minusy;
echo "</br>".$plusy;
echo "</br>".$zdolnosc;
echo "</br>".$rata;

/*

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_wydatku = (int) ($_POST['rodzaj']);
    $wysokosc   = (float) ($_POST['wysokosc']);
    $nazwa      = trim($_POST['nazwa']);
    $id = $edit_data["id"];
    if($is_edit) {
        updateUserExpensesToDb($id_wydatku, $wysokosc, $nazwa, $id, $user_id);
    } else {
        saveUserExpensesToDb($session_id, $user_id, $id_wydatku, $wysokosc, $nazwa);
    }
    // po zapisie przeładowujemy stronę, żeby nowy rekord się pojawił w tabeli
    header('Location: wydatki.php');
    exit;
}

$wydatki = getTableFromDb("SELECT * FROM wydatki");
$query = "SELECT uw.id, w.rodzaj, uw.wysokosc, uw.nazwa, w.dti_prct, w.jest_wydatkiem FROM uzytkownik_wydatki uw
         LEFT JOIN wydatki w on w.id = uw.id_wydatku
         WHERE uw.id_uzytkownika = $user_id";
$wydatkiUzytkownika = getTableFromDb($query);

$sumaWydatkow = 0.0;
foreach ($wydatkiUzytkownika as $wydatek) {
    if($wydatek["jest_wydatkiem"]) {
        $sumaWydatkow += (float) $wydatek['wysokosc'];
    }
}
$_SESSION['suma_wydatkow'] = $sumaWydatkow;

$sumaDlugu = 0.0;
foreach ($wydatkiUzytkownika as $wydatek) {
    $sumaDlugu += (float) $wydatek['wysokosc'] * (float) $wydatek['dti_prct']/100.0;
}
$_SESSION['suma_dlugu'] = $sumaDlugu;
//echo print_r($wydatkiUzytkownika);
echo print_r($sumaWydatkow);
echo $_SESSION['suma_wydatkow'];*/
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
    <label>Podsumowanie</label>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
