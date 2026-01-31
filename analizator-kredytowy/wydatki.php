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
$is_edit = false;
$edit_id = 0;
$edit_data = null;

if (isset($_GET['edit'])) {
    $edit_id = (int) $_GET['edit'];
    if ($edit_id > 0) {
        $is_edit = true;
        $query = "SELECT ud.id, d.rodzaj, ud.id_wydatku, ud.nazwa, ud.wysokosc
                  FROM uzytkownik_wydatki ud
                  LEFT JOIN dochody d ON d.id = ud.id_wydatku
                  WHERE ud.id = $edit_id AND ud.id_uzytkownika = $user_id";
        $edit_data = getTableFromDb($query)[0]; //będziemy używać tylko pierwszego wiersza o indeksie 0
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_wydatku = (int) ($_POST['rodzaj']);
    $wysokosc   = (float) ($_POST['wysokosc']);
    $nazwa      = trim($_POST['nazwa']);
    $id = $edit_data["id"];
    if($is_edit) {
        updateUserExpenseToDb($id_wydatku, $wysokosc, $nazwa, $id, $user_id);
    } else {
        saveUserExpenseToDb($session_id, $user_id, $id_wydatku, $wysokosc, $nazwa);
    }
    // po zapisie przeładowujemy stronę, żeby nowy rekord się pojawił w tabeli
    header('Location: dochody.php');
    exit;
}

$wydatki = getTableFromDb("SELECT * FROM wydatki");
$query = "SELECT uw.id, w.rodzaj, uw.wysokosc, uw.nazwa FROM uzytkownik_wydatki uw
         LEFT JOIN wydatki w on w.id = uw.id_wydatku
         WHERE uw.id_uzytkownika = $user_id";
$wydatkiUzytkownika = getTableFromDb($query);

$sumaWydatkow= 0.0;
foreach ($wydatkiUzytkownika as $dochod) {
    $sumaWydatkow += (float) $dochod['wysokosc'];
}
$_SESSION['suma_wydatkow'] = $sumaWydatkow;
//echo print_r($wydatki);
//echo print_r($edit_data);
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
        <h3><?php echo $is_edit ? 'EDYTUJ WYDATKI '.$edit_id.'.' : 'DODAJ WYDATKI'; ?></h3>
        <hr class="section-divider">

        <label>Źródło dochodu:</label>
        <select name="rodzaj" id="rodzaj" required>
            <option value="" disabled selected>Wybierz...</option>
            <?php foreach ($wydatki as $row): ?>
                <option value="<?php echo $row['id'] ?>"
                        <?php echo ($edit_data && $edit_data['id_wydatku'] == $row['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row['rodzaj']); ?>
                </option>
            <?php endforeach; ?>
        </select>


        <label>Nazwa:</label>
        <!--<input type="text" id="nazwa" name="nazwa" required>-->
        <input type="text" id="nazwa" name="nazwa"
               value="<?php echo htmlspecialchars($edit_data['nazwa'] ?? ''); ?>" required>

        <label>Wysokość w zł/msc:</label>
        <div class="inline-input">
            <input class="add-input" type="number" id="wysokosc" name="wysokosc"
                   value="<?php echo $edit_data['wysokosc'] ?? '0.00'; ?>"
                   min="0.00" step="100.00" required>
            <button class="add-button <?php echo $is_edit ? 'edit-btn' : ''; ?>" type="submit" id="submit-btn">
                <?php echo $is_edit ? 'Edytuj' : 'Dodaj'; ?>
                <i class="bi <?php echo $is_edit ? 'bi-pencil-fill' : 'bi-plus'; ?>"></i>
                <i class="bi <?php echo $is_edit ? '' : 'bi-currency-exchange'; ?>"></i>
            </button>
            <?php if ($is_edit): ?>
                <button type="button" class="cancel-btn" onclick="window.location.href='dochody.php'">Anuluj</button>
            <?php endif; ?>

        </div>
    </form>

    <h3>PODSUMOWANIE</h3>
    <hr class="section-divider">
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
                <th>Opcje</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($wydatkiUzytkownika as $index => $wydatek): ?>
                <tr class="expenses-row" data-id="<?php echo $index; ?>">
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($wydatek['rodzaj']); ?></td>
                    <td><?php echo htmlspecialchars($wydatek['nazwa']); ?></td>
                    <td><?php echo number_format($wydatek['wysokosc'], 2, ',', ' '); ?></td>
                    <td class="actions" style="display: none;">
                        <button type="button" class="table-btn edit-btn" onclick="location.href='wydatki.php?edit=<?php echo $wydatek['id']; ?>'">Edytuj <i class="bi bi-pencil-fill"></i></button>
                        <button type="button" class="table-btn delete-btn" data-id="<?php echo $wydatek['id'];?>">Usuń <i class="bi bi-trash2-fill"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </br>
    <label class="hint">Wybierz wiersz kliknięciem w celu edycji lub usunięcia danych.</label>

    </br>
    <label>Razem:</label>
    <div class="inline-input">
        <input class="add-input" type="number" name="expenses-total" step="0.01"
               value="<?php echo number_format($sumaWydatkow, 2, '.', ''); ?>" disabled readonly>
        <button class="end-button" id="koniec" onclick="window.location.href='index.php'">ZAKOŃCZ <i class="bi bi-box-arrow-left"></i></button>
    </div>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
