<?php
require_once __DIR__ . '/src/functions.php';

function userEmailExists($email) {
    $db=openDbConnection();
    try {
        $stmt = $db->prepare("SELECT id FROM uzytkownicy WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $flag = $stmt->get_result()->num_rows > 0;

        $stmt->close();
        closeDbConnection($db);
        return $flag;

    } catch (mysqli_sql_exception $e) {
        error_log("DB error in userEmailExists: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($db);
        //exit("Nie udało się sprawdzić email");
        return false; // albo: throw; jeśli chcesz obsłużyć wyżej
    }
}

function credentialsExists($email, $password) {
    $db=openDbConnection();
    try {
        $stmt = $db->prepare("SELECT id, password FROM uzytkownicy WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result ? $result->fetch_assoc() : null; // associative array [web:169]

        $stmt->close();
        closeDbConnection($db);
        return $user && password_verify($password, $user['password']);
    } catch (mysqli_sql_exception $e) {
        error_log("DB error in userEmailExists: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($db);
        //exit("Nie udało się pobrać credentials?");
        return false; // albo: throw; jeśli chcesz obsłużyć wyżej
    }
}

function addUser($imie, $nazwisko, $email, $password) {
    $db=openDbConnection();
    try {
        $stmt = $db->prepare("INSERT INTO uzytkownicy VALUES(NULL, ?, ?, ?, ?)");
        $stmt->bind_param("ssss", $imie, $nazwisko, $email, $password);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($db);
    } catch (mysqli_sql_exception $e) {
        error_log("DB error in addUser: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($db);
    }
}

function getUserByEmail($email) {
    $db=openDbConnection();
    try {
        $stmt = $db->prepare("SELECT imie, nazwisko FROM uzytkownicy WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result ? $result->fetch_assoc() : null; // associative array [web:169]

        $stmt->close();
        closeDbConnection($db);
        return $user;
    } catch (mysqli_sql_exception $e) {
        error_log("DB error in userEmailExists: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($db);
        //exit("Nie udało się pobrać credentials?");
        return false; // albo: throw; jeśli chcesz obsłużyć wyżej
    }
}