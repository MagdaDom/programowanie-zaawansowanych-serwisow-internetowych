<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';

session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    header('Location: login.php'); exit;
}

$session_id = session_id();
$user_id = $_SESSION['user_id'] ?? null;
//parametry przekazywane między sesjamy - zajrzyj do dochody.php i wydatki.php po szczegóły
$sumaDochodow = (isset($_SESSION['suma_dochodow'])) ? $_SESSION['suma_dochodow'] : null;
//$sumaWydatkow = (isset($_SESSION['suma_wydatkow'])) ? $_SESSION['suma_wydatkow'] : null; //nie potrzebujemy sumy realnych wydatków do liczenia zdolności, tylko zakładane przez bank średnie wydatki
$minWydatkow = (isset($_SESSION['min_wydatkow'])) ? $_SESSION['min_wydatkow'] : null;
$sumaDlugu = (isset($_SESSION['suma_dlugu'])) ? $_SESSION['suma_dlugu'] : null;

//po wprowadzeniu przez użytkownika wszystkich parametrów i przesłania formularza zapisujemy dane do bazy i przełączamy widok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['oblicz'])) {
    if ($_POST['oblicz']) {
        //zapisujemy wybrane na formularzu parametry do bazy
        $session_id = session_id();
        $user_id = $_SESSION['user_id'];
        $id_user_dochody = getIdDochodu($session_id, $user_id);
        $id_user_wydatki = getIdWydatku($session_id, $user_id);
        $wiek      = (int)$_POST['wiek'];
        $osoby     = (int)$_POST['osoby'];
        $okres     = (int)$_POST['okres'];
        $rata      = (float)$_POST['rata'];
        $rodzaj_prct = $_POST['rodzaj_prct'];
        $rrso      = (float)$_POST['rrso'];

        saveParameters($session_id, $user_id, $id_user_dochody, $id_user_wydatki, $wiek, $osoby, $okres, $rata, $rodzaj_prct, $rrso);
        $wynik = calculateCreditworthiness($sumaDochodow, $minWydatkow, $sumaDlugu, $wiek, $osoby, $okres, $rata, $rodzaj_prct, $rrso);

        //zapisujemy wyniki do zmiennych sesji, by móc je potem wyświetlić w innym oknie (podsumoania)
        $_SESSION['minusy']   = $wynik['minusy'];
        $_SESSION['plusy']    = $wynik['plusy'];
        $_SESSION['zdolnosc'] = $wynik['zdolnosc'];
        $_SESSION['rata']     = $wynik['rata'];
        //nowe session id dla kolejnych zapytań
        //session_regenerate_id(false);
        // po zakończeniu obliczeń zwróć sukces do AJAXa, gdzie nastąpi przekierowanie do strony z podsumowaniem
        echo json_encode(['success' => true]);
        exit;
    }
}
// jeśli coś pójdzie nie tak, zwróć false
echo json_encode(['success' => false]);