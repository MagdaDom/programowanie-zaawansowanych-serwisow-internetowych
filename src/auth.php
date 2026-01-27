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
function isHintValid($hint) {

}

function openDbConnection() {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //włącza wyrzucanie wyjątków zamiast cichych ostrzeżęń
    $conn = mysqli_connect("127.0.0.1", "root", "")
        or exit("Nieudane połączenie z serwerem");
    $baza = 'kalkulatorkredytowy';
    mysqli_select_db($conn, $baza)
        or exit("Nieudane połączenie z bazą");
    mysqli_set_charset($conn, "utf8");

    $db = new mysqli("127.0.0.1","root","","kalkulatorkredytowy");
    $db->set_charset("utf8mb4");
    return $db;
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