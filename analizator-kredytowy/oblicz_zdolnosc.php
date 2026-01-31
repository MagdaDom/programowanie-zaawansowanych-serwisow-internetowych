<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';

session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    header('Location: login.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Only POST allowed']);
    exit;
}

$session_id = session_id();
$user_id = $_SESSION['user_id'] ?? null;


//parametry przekazywane między sesjamy - zajrzyj do dochody.php i wydatki.php po szczegóły
$sumaDochodow = (isset($_SESSION['suma_dochodow'])) ? $_SESSION['suma_dochodow'] : null;
$sumaWydatkow = (isset($_SESSION['suma_wydatkow'])) ? $_SESSION['suma_wydatkow'] : null;
$sumaDlugu = (isset($_SESSION['suma_dlugu'])) ? $_SESSION['suma_dlugu'] : null;

//po wprowadzeniu przez użytkownika wszystkich parametrów i przesłania formularza zapisujemy dane do bazy i przełączamy widok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oblicz'])) {
    if ($_POST['oblicz']) {
        //zapisujemy ID do bazy
        $session_id = session_id();
        $user_id = $_SESSION['user_id'];
        $id_user_dochody = getIdDochodu($session_id, $user_id);
        $id_user_wydatki = getIdWydatku($session_id, $user_id);
        $wiek = $_POST['wiek'];
        $osoby = $_POST['osoby'];
        $okres = $_POST['okres'];
        $rata = $_POST['rata'];
        $rodzaj_prct = $_POST['rodzaj_prct'];
        $rrso = $_POST['rrso'];

        saveParameters($session_id, $user_id, $id_user_dochody, $id_user_wydatki, $wiek, $osoby, $okres, $rata, $rodzaj_prct, $rrso);
        calculateCreditworthiness($sumaDochodow, $sumaWydatkow, $sumaDlugu, $wiek, $osoby, $okres, $rata, $rodzaj_prct, $rrso);
        //nowe session id dla kolejnych zapytań
        //session_regenerate_id(false);
        //przechodzimy do strony z wynikiem
        header('Location: podsumowanie.php');
        exit;
    }
}

// pobierz dane z POST
$wiek      = (int)$_POST['wiek'];
$osoby     = (int)$_POST['osoby'];
$okres     = (int)$_POST['okres'];
$rata      = (float)$_POST['rata'];
$rodzaj_prct = $_POST['rodzaj_prct'];
$rrso      = (float)$_POST['rrso'];

// pobierz ID dochodów/wydatków (przykład – dostosuj do swoich funkcji)
$id_user_dochody = getIdDochodu($session_id, $user_id);
$id_user_wydatki = getIdWydatku($session_id, $user_id);

// tu możesz dodać pobranie sum dochodów/wydatków
$sumaDochodow = getSumDochody($session_id, $user_id);   // przykładowa funkcja
$sumaWydatkow = getSumWydatki($session_id, $user_id);   // przykładowa funkcja
$sumaDlugu    = getSumDlugu($session_id, $user_id);     // przykładowa funkcja

// zapis parametrów do bazy
saveParameters($session_id, $user_id, $id_user_dochody, $id_user_wydatki, $wiek, $osoby, $okres, $rata, $rodzaj_prct, $rrso);

// czasochłonna funkcja – teraz jest w AJAX‑ie, więc użytkownik widzi spinner
calculateCreditworthiness($sumaDochodow, $sumaWydatkow, $sumaDlugu, $wiek, $osoby, $okres, $rata, $rodzaj_prct, $rrso);

// po zakończeniu obliczeń zwróć sukces
echo json_encode(['success' => true]);
exit;
