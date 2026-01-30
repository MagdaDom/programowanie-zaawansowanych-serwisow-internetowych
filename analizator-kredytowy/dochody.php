<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';
session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    header('Location: login.php'); exit;
}

$dochody = getTableFromDb("dochody");
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
            Witaj, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_COMPAT, 'UTF-8'); ?>!
        </div>
    <?php endif; ?>

    <form method="POST">
        <h3>DOCHODY</h3>
        <hr class="section-divider">

        <label>Źródło dochodu:</label>
        <select name="rodzaj" id="category" required>
            <option value="" disabled selected>Wybierz...</option>
            <?php foreach ($dochody as $row): ?>
                <option value="<?php echo $row['id'] ?>">
                    <?php echo htmlspecialchars($row['rodzaj']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Wysokość dochodu w zł/msc:</label>
        <div class="inline-input">
            <input class="add-input" type="number" id="income" value="0.00" min=1.00 step=100.00 required>
            <button class="add-button">Dodaj <i class="bi bi-plus"></i><i class="bi bi-currency-exchange"></i></button>
        </div>

        </br>
        <label>Dochody łącznie:</label>
        <input type="number" name="income-total" value="" disabled readonly>
        <button type="submit">ZAPISZ DOCHODY  <i class="bi bi-floppy-fill"></i></button>
    </form>

    <div class="card-footer">
        Wykonała: Magdalena Domaszczyńska
    </div>
</div>
</body>
</html>
