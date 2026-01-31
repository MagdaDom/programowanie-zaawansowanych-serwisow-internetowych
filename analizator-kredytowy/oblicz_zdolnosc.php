<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';

session_start();
// when user not logged, redirect to the login page
if (empty($_SESSION['logged'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Użytkownik nie zalogowany.']);
    exit;
}

$session_id = session_id();
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Brak user_id w sesji']);
    exit;
}
//parametry przekazywane między sesjamy - zajrzyj do dochody.php i wydatki.php po szczegóły
$sumaDochodow = (isset($_SESSION['suma_dochodow'])) ? $_SESSION['suma_dochodow'] : null;
//$sumaWydatkow = (isset($_SESSION['suma_wydatkow'])) ? $_SESSION['suma_wydatkow'] : null; //nie potrzebujemy sumy realnych wydatków do liczenia zdolności, tylko zakładane przez bank średnie wydatki
$minWydatkow = (isset($_SESSION['min_wydatkow'])) ? $_SESSION['min_wydatkow'] : null;
$sumaDlugu = (isset($_SESSION['suma_dlugu'])) ? $_SESSION['suma_dlugu'] : null;
if ($sumaDochodow === null || $minWydatkow === null || $sumaDlugu === null) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Brak wymaganych danych w sesji (dochody / wydatki / długi)']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Nie użyto metody POST w formularzu']);
    exit;
}

//po wprowadzeniu przez użytkownika wszystkich parametrów i przesłania formularza zapisujemy dane do bazy i przełączamy widok
//zapisujemy wybrane na formularzu parametry do bazy
$id_user_dochody = getIdDochodu($session_id, $user_id);
$id_user_wydatki = getIdWydatku($session_id, $user_id);
$wiek      = (int)$_POST['age'] ?? null;
$osoby     = (int)$_POST['people'] ?? null;
$okres     = (int)$_POST['years'] ?? null;
$rodzaj_rata      = (float)$_POST['rodzaj_rata'] ?? null;
$rodzaj_prct = $_POST['rodzaj_prct'] ?? null;
$rrso      = (float)$_POST['rrso'] ?? null;

// walidacja, czy wszystkie pola są przekazane
if ($id_user_dochody===null || $id_user_wydatki===null || $wiek===null || $osoby===null || $okres===null || $rodzaj_rata===null || $rodzaj_prct===null || $rrso===null) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nie wszystkie pola formularza zostały przekazane']);
    exit;
}

try {
    saveParameters($session_id, $user_id, $id_user_dochody, $id_user_wydatki, $wiek, $osoby, $okres, $rodzaj_rata, $rodzaj_prct, $rrso);
    $wynik = calculateCreditworthiness($sumaDochodow, $minWydatkow, $sumaDlugu, $wiek, $osoby, $okres, $rodzaj_rata, $rodzaj_prct, $rrso);
    //zapisujemy wyniki do bazy
    saveCreditworthiness($session_id, $user_id, $sumaDochodow, $minWydatkow, $sumaDlugu, $wynik);

//zapisujemy wyniki do zmiennych sesji, by móc je potem wyświetlić w innym oknie (podsumowania)
    $_SESSION['minusy']   = $wynik['minusy'] ?? [];
    $_SESSION['plusy']    = $wynik['plusy'] ?? [];
    $_SESSION['zdolnosc'] = $wynik['zdolnosc'] ?? 0;
    $_SESSION['rata']     = $wynik['rata'] ?? 0.0;

//nowe session id dla kolejnych zapytań
//session_regenerate_id(false);
// po zakończeniu obliczeń zwróć sukces do AJAXa, gdzie nastąpi przekierowanie do strony z podsumowaniem
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Obliczenia zakończone pomyślnie',
        'data'    => $wynik
    ]);
    exit;
} catch (Exception $e) {
    // tu łapamy błędy funkcji (np. błędy w saveParameters / calculateCreditworthiness)
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Wewnętrzny błąd serwera: ' . $e->getMessage(),
    ]);
    exit;
}

// jeśli nic się nie wydarzyło (np. żądanie GET), też zwróć JSON
http_response_code(400);
echo json_encode(['success' => false]);