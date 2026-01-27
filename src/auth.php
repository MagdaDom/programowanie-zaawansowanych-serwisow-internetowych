<?php
function isEmailValid($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function userEmailExists($email) {
    $db=openDbConnection();
    $stmt = $db->prepare("SELECT id FROM uzytkownicy WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $flag = $stmt->get_result()->num_rows > 0;
    $stmt->close();
    closeDbConnection($db);
    return $flag;
}

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

function getTable($query) {
    $db = openDbConnection();
    $result = $db->query($query);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
    closeDbConnection($db);
    return $rows;
}