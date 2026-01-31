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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dochodu = (int) ($_POST['rodzaj']);
    $wysokosc   = (float) ($_POST['wysokosc']);
    $nazwa      = trim($_POST['nazwa']);
    saveUserIncomeToDb($session_id, $user_id, $id_dochodu, $wysokosc, $nazwa);
    // po zapisie przeładowujemy stronę, żeby nowy rekord się pojawił w tabeli
    header('Location: dochody.php');
    exit;
}

$dochody = getTableFromDb("SELECT * FROM dochody");
$query = "SELECT d.rodzaj, ud.wysokosc, ud.nazwa FROM uzytkownik_dochody ud 
         LEFT JOIN dochody d on d.id = ud.id_dochodu
         WHERE ud.id_uzytkownika = $user_id";
$dochodyUzytkownika = getTableFromDb($query);
//echo print_r($dochody);
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
            Witaj, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_COMPAT, 'UTF-8'); ?> (<?php echo $_SESSION['user_id'] ?>)!
        </div>
    <?php endif; ?>

    <form method="POST">
        <h3>DODAJ DOCHÓD</h3>
        <hr class="section-divider">

        <label>Źródło dochodu:</label>
        <select name="rodzaj" id="rodzaj" required>
            <option value="" disabled selected>Wybierz...</option>
            <?php foreach ($dochody as $row): ?>
                <option value="<?php echo $row['id'] ?>">
                    <?php echo htmlspecialchars($row['rodzaj']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Nazwa:</label>
        <input type="text" id="nazwa" name="nazwa" required>

        <label>Wysokość w zł/msc:</label>
        <div class="inline-input">
            <input class="add-input" type="number" id="wysokosc" name="wysokosc" value="0.00" min="0.00" step="100.00" required>
            <button class="add-button" type="submit">Dodaj <i class="bi bi-plus"></i><i class="bi bi-currency-exchange"></i></button>
        </div>
    </form>

    <h3>PODSUMOWANIE</h3>
    <hr class="section-divider">
    <!--if (!empty($dochodyUzytkownika)):-->
    <?php
    if (true): ?>
        <label>Twoje dochody:</label>
        <table>
            <thead>
            <tr>
                <th>Lp.</th>
                <th>Rodzaj</th>
                <th>Nazwa</th>
                <th>Wysokość [zł/msc]</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dochodyUzytkownika as $index => $dochod): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($dochod['rodzaj']); ?></td>
                    <td><?php echo number_format($dochod['wysokosc'], 2, ',', ' '); ?> zł</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    </br>
    <label>Razem:</label>
    <div class="inline-input">
        <input class="add-input" type="number" name="income-total" value="" disabled readonly>
        <button class="end-button" id="koniec" onclick="window.location.href='index.php'">ZAKOŃCZ <i class="bi bi-box-arrow-left"></i></button>
    </div>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
