<?php
//obsługa połączenia z bazą
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

function getTableFromDb($query) {
    $conn = openDbConnection();
    $result = mysqli_query($conn, $query);
    $tablica = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tablica[] = $row;
    }
    closeDbConnection($conn);
    return $tablica;
}

//funkcje do osbługi CRUD i sesji
function saveUserIncomeToDb($session_id, $user_id, $id_dochodu, $wysokosc, $nazwa) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("INSERT INTO uzytkownik_dochody VALUES (NULL, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siids", $session_id, $user_id, $id_dochodu, $wysokosc, $nazwa);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in saveUserIncomeToDb: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}

function updateUserIncomeToDb($id_dochodu, $wysokosc, $nazwa, $id, $user_id) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("UPDATE uzytkownik_dochody SET id_dochodu = ?, wysokosc = ?, nazwa = ? WHERE id = ? AND id_uzytkownika = ?");
        $stmt->bind_param("idsii", $id_dochodu, $wysokosc, $nazwa, $id, $user_id);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in saveUserIncomeToDb: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}

function removeUserIncome($id) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("DELETE FROM uzytkownik_dochody WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in removeUserIncome: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}

function saveUserExpensesToDb($session_id, $user_id, $id_wydatku, $wysokosc, $nazwa) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("INSERT INTO uzytkownik_wydatki VALUES (NULL, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siids", $session_id, $user_id, $id_wydatku, $wysokosc, $nazwa);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in saveUserExpensesToDb: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}

function updateUserExpensesToDb($id_wydatku, $wysokosc, $nazwa, $id, $user_id) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("UPDATE uzytkownik_wydatki SET id_wydatku = ?, wysokosc = ?, nazwa = ? WHERE id = ? AND id_uzytkownika = ?");
        $stmt->bind_param("idsii", $id_wydatku, $wysokosc, $nazwa, $id, $user_id);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in saveUserExpensesToDb: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}

function removeUserExpense($id) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("DELETE FROM uzytkownik_wydatki WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in removeUserExpense: " . $e->getMessage()); // zapis do pliku ustawionego w error_log
        closeDbConnection($conn);
    }
}

function getIdDochodu($session_id, $user_id) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("SELECT id_dochodu FROM uzytkownik_dochody WHERE sesja = ? AND id_uzytkownika = ?");
        $stmt->bind_param("si", $session_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        closeDbConnection($conn);
        return $rows[0]["id_dochodu"];
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in getIdDochodu: " . $e->getMessage());
        closeDbConnection($conn);
        return null;
    }
}

function getIdWydatku($session_id, $user_id) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("SELECT id_wydatku FROM uzytkownik_wydatki WHERE sesja = ? AND id_uzytkownika = ?");
        $stmt->bind_param("si", $session_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        closeDbConnection($conn);
        return $rows[0]["id_dochodu"];
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in getIdDochodu: " . $e->getMessage());
        closeDbConnection($conn);
        return null;
    }
}

//zapisuje wybrane przez użytkownika parametry do kredytu
function saveParameters($session_id, $user_id, $id_user_dochody, $id_user_wydatki, $wiek, $osoby, $okres, $rata, $rodzaj_prct, $rrso) {
    $conn = openDbConnection();
    try {
        date_default_timezone_set('Europe/Warsaw');
        $now = date('Y-m-d H:i:s');  // np. 2026-01-31 13:02:00
        $stmt = $conn->prepare("INSERT INTO parametry VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiiiissfs", $session_id, $user_id, $id_user_dochody, $id_user_wydatki, $wiek, $osoby, $okres, $rata, $rodzaj_prct, $rrso, $now);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in saveParameters: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}

//zapisuje wartości obliczone na bazie wybranych przez użytkownika parametrów
function saveCreditworthiness($session_id, $user_id, $id_parametrow, $sumaDochodow, $sumaWydatkow, $sumaDlugu, $zdolnosc, $rata) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("INSERT INTO wyniki VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siifffif", $session_id, $user_id, $id_parametrow, $sumaDochodow, $sumaWydatkow, $sumaDlugu, $zdolnosc, $rata);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in saveCreditworthiness: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}
?>
