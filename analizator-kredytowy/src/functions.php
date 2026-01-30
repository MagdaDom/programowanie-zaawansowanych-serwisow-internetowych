<?php
function openDbConnection() {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // wyjątki [web:431]
    try {
        $db = new mysqli("127.0.0.1", "root", "", "kalkulatorkredytowy");
        $db->set_charset("utf8mb4"); // polskie znaki + pełne UTF-8 [web:346]
        return $db;
    } catch (mysqli_sql_exception $e) {
        // zapisywanie błędów do logów
        error_log("DB connection error: " . $e->getMessage()); // [web:493]
        // komunikat “dla usera”
        exit("Błąd połączenia z bazą danych. Spróbuj ponownie później.");
    }
}

function closeDbConnection($db) {
    mysqli_close($db);
}

function readCsvToTable($file) {
    $result = [];
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $result[$row[0]] = (float)str_replace(',', '.', $row[1]);
        }
        fclose($handle);
    }
    return $result;
}

?>
