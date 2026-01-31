<?php //formularz do dodawania dochodów (z CRUDem)
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';
session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    header('Location: login.php'); exit;
}
$session_id = session_id();
$user_id = $_SESSION['user_id'];
//obsługa edytowania - jest ono realizowane na tym samym formularzu co dodawanie, więc trzeba było zrealizować przełączanie widoku i logiki biznesowej
$is_edit = false;
$edit_id = 0;
$edit_data = null;

if (isset($_GET['edit'])) {
    $edit_id = (int) $_GET['edit'];
    if ($edit_id > 0) {
        $is_edit = true;
        $query = "SELECT ud.id, d.rodzaj, ud.id_dochodu, ud.nazwa, ud.wysokosc
                  FROM uzytkownik_dochody ud
                  LEFT JOIN dochody d ON d.id = ud.id_dochodu
                  WHERE ud.id = $edit_id AND ud.id_uzytkownika = $user_id";
        $edit_data = getTableFromDb($query)[0]; //będziemy używać tylko pierwszego wiersza o indeksie 0
    }
}

//po wysłaniu formularza (przycisk Dodaj dochód) dane są zapisywane, a widok odświeżany
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dochodu = (int) ($_POST['rodzaj']);
    $wysokosc   = (float) ($_POST['wysokosc']);
    $nazwa      = trim($_POST['nazwa']);
    $id = $edit_data["id"];
    if($is_edit) {
        updateUserIncomeToDb($id_dochodu, $wysokosc, $nazwa, $id, $user_id);
    } else {
        saveUserIncomeToDb($session_id, $user_id, $id_dochodu, $wysokosc, $nazwa);
    }
    // po zapisie przeładowujemy stronę, żeby nowy rekord się pojawił w tabeli
    header('Location: dochody.php');
    exit;
}

//dodawane przez użytkownika dochody są wyświetlane, by umożliwić ich edycję i kasowanie
$dochody = getTableFromDb("SELECT * FROM dochody");
$query = "SELECT ud.id, d.rodzaj, ud.wysokosc, ud.nazwa FROM uzytkownik_dochody ud 
         LEFT JOIN dochody d on d.id = ud.id_dochodu
         WHERE ud.id_uzytkownika = $user_id";
$dochodyUzytkownika = getTableFromDb($query);

//utworzona tutaj suma dochodów przenoszona będzie pomiędzy widokami z użyciem mechanizmu sesji
$sumaDochodow = 0.0;
foreach ($dochodyUzytkownika as $dochod) {
    $sumaDochodow += (float) $dochod['wysokosc'];
}
$_SESSION['suma_dochodow'] = $sumaDochodow;

//tu liczymy szacowane średnie wydatki na życie gospodarstwa domowego na osobę na bazie źródła uzyskiwania dochodu oraz danych z GUS
$queryWydatki = "with presummary as (
SELECT ud.id, d.rodzaj, ud.wysokosc, ud.nazwa, d.wydatki_msc 
, (ud.wysokosc/SUM(ud.wysokosc) OVER (PARTITION BY ud.id_uzytkownika))*d.wydatki_msc as wydatki_weighted
FROM uzytkownik_dochody ud 
LEFT JOIN dochody d on d.id = ud.id_dochodu
where ud.id_uzytkownika = $user_id
)
select ROUND(SUM(wydatki_weighted),2) as min_wydatki from presummary";
$minWydatkow = 0.0;
$minSocjalne = getTableFromDb($queryWydatki);
if (!empty($minSocjalne) && isset($minSocjalne[0]["min_wydatki"])) {
    $minWydatkow = $minSocjalne[0]["min_wydatki"];
}
$_SESSION["min_wydatkow"] = $minWydatkow;

//echo $minWydatkow;
//echo "</br>".print_r($minSocjalne);
//echo "</br>".$_SESSION["min_wydatkow"];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator zdolności kredytowej</title>
    <link rel="stylesheet" href="css/style.css?v=2" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="js/income.js" defer></script>
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
        <h3><?php echo $is_edit ? 'EDYTUJ DOCHÓD '.$edit_id.'.' : 'DODAJ DOCHÓD'; ?></h3>
        <hr class="section-divider">

        <label>Źródło dochodu:</label>
        <select name="rodzaj" id="rodzaj" required>
            <option value="" disabled selected>Wybierz...</option>
            <?php foreach ($dochody as $row): ?>
                <option value="<?php echo $row['id'] ?>"
                        <?php echo ($edit_data && $edit_data['id_dochodu'] == $row['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row['rodzaj']); ?>
                </option>
            <?php endforeach; ?>
        </select>


        <label>Dodatkowe informacje:</label>
        <!--<input type="text" id="nazwa" name="nazwa" required>-->
        <input type="text" id="nazwa" name="nazwa"
               value="<?php echo htmlspecialchars($edit_data['nazwa'] ?? ''); ?>" required>

        <label>Wysokość w zł/msc (netto):</label>
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
    <!--if (!empty($dochodyUzytkownika)):-->
    <?php
    if (true): ?>
        <label>Twoje dochody:</label>
        <table>
            <thead>
            <tr>
                <th>Lp.</th>
                <th>Rodzaj</th>
                <th>Informacje</th>
                <th>Wysokość [zł/msc]</th>
                <th>Opcje</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dochodyUzytkownika as $index => $dochod): ?>
                <tr class="income-row" data-id="<?php echo $index; ?>">
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($dochod['rodzaj']); ?></td>
                    <td><?php echo htmlspecialchars($dochod['nazwa']); ?></td>
                    <td><?php echo number_format($dochod['wysokosc'], 2, ',', ' '); ?></td>
                    <td class="actions" style="display: none;">
                        <button type="button" class="table-btn edit-btn" onclick="location.href='dochody.php?edit=<?php echo $dochod['id']; ?>'">Edytuj <i class="bi bi-pencil-fill"></i></button>
                        <button type="button" class="table-btn delete-btn" data-id="<?php echo $dochod['id'];?>">Usuń <i class="bi bi-trash2-fill"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </br>
    <label class="hint">Wybierz wiersz kliknięciem w celu edycji lub usunięcia danych.</label>

    </br>
    <div class="form-row">
        <div class="field">
            <label class="debt-label">Dochody razem:</label>
            <input class="add-input" type="number" name="income-total" step="0.01"
                   value="<?php echo number_format($sumaDochodow, 2, '.', ''); ?>" disabled readonly>
            <p class="hint"> suma</p>
        </div>

        <div class="field">
            <label class="debt-label">Szacowane wydatki (msc/osoba):</label>
            <input class="add-input" type="number" name="min-spendings" step="0.01"
                   value="<?php echo number_format($minWydatkow, 2, '.', ''); ?>" disabled readonly>
            <p class="hint">w zależności od źródła dochodu</p>
        </div>

        <div class="actions-col">
            <button class="end-button" id="koniec" onclick="window.location.href='index.php'">ZAKOŃCZ <i class="bi bi-box-arrow-left"></i></button>
        </div>
    </div>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
