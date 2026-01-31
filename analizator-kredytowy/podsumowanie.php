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
//wyniki obliczeń z poprzedniej sesji
$minusy   = $_SESSION['minusy']   ?? [];
$plusy    = $_SESSION['plusy']    ?? [];
$zdolnosc = $_SESSION['zdolnosc'] ?? 0;
$rata     = $_SESSION['rata']     ?? 0;
//do ładnego wyświetlania
$zs = number_format($zdolnosc, 0, ".", " ");
$rs = number_format($rata, 2, ".", " ");

//historia wyszukiwań
$query = "select u.imie, u.nazwisko, p.data_czas_dodania,  w.sesja, w.zdolnosc, w.rata, w.minusy, w.plusy 
, w.suma_dochodow, w.suma_dlugu, w.min_wydatkow*p.osoby as koszta_utrzymania
, p.wiek, p.osoby, p.okres, p.rodzaj_rata, p.rodzaj_prct, p.rrso 
from wyniki w 
left join uzytkownicy u on u.id = w.id_uzytkownika 
left join parametry p on w.sesja = p.sesja and p.id_uzytkownika = w.id_uzytkownika 
         WHERE w.id_uzytkownika = $user_id ORDER BY p.data_czas_dodania DESC";
$historia = getTableFromDb($query);

//śledzenie sesji do testów
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';

//po kliknięciu "Oblicz ponownie"
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
<div class="container-very-long">
    <div class="card-header">
        <h1>Kalkulator zdolności kredytowej</h1>
    </div>
    <?php if (!empty($_SESSION['user_email'])): ?>
        <div class="user-bar">
            Witaj, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_COMPAT, 'UTF-8'); ?> (<?php echo $session_id ?>)!
        </div>
    <?php endif; ?>
    <form method="POST">
    <?php if ($zdolnosc > 0): ?>
        <h1 class="success">Decyzja kredytowa: POZYTYWNA!</h1>    </br>
        <h2 class="success">Maksymalnie możesz otrzymać <?php echo $zs; ?> zł kredytu </br>
            (rata ok. <?php echo $rs?> zł/msc).</h2>    </br>

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

    </br>
    <label>Historia obliczeń:</label>
    <table>
        <thead>
        <tr>
            <th>Lp.</th>
            <th>Data i czas</th>
            <th>Zdolność</th>
            <th>Rata</th>
            <th>Osoby</th>
            <th>Okres</th>
            <th>RRSO</th>
            <th>Rodzaj oprocentowania</th>
            <th>Rodzaj raty</th>
            <th>Dochody</th>
            <th>Zobowiązania</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($historia as $index => $row): ?>
            <tr class="income-row" data-id="<?php echo $index; ?>">
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($row['data_czas_dodania']); ?></td>
                <td><?php echo number_format($row['zdolnosc'], 2, ',', ' '); ?></td>
                <td><?php echo number_format($row['rata'], 2, ',', ' '); ?></td>
                <td><?php echo $row['osoby']; ?></td>
                <td><?php echo $row['okres']; ?> lat</td>
                <td><?php echo $row['rrso']; ?>%</td>
                <td><?php echo $row['rodzaj_prct']; ?></td>
                <td><?php echo $row['rodzaj_rata']; ?></td>
                <td><?php echo number_format($row['suma_dochodow'], 0, ',', ' '); ?></td>
                <td><?php echo number_format($row['suma_dlugu'], 0, ',', ' '); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
