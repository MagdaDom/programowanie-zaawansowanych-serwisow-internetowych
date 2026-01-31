<?php
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8'); //polskie znaki obsługa
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

function updateUserIncomeToDb($id_dochodu, $wysokosc, $nazwa, $id, $user_id, $session_id) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("UPDATE uzytkownik_dochody SET id_dochodu = ?, wysokosc = ?, nazwa = ? WHERE id = ? AND id_uzytkownika = ? and sesja = ?");
        $stmt->bind_param("idsiis", $id_dochodu, $wysokosc, $nazwa, $id, $user_id, $session_id);
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

function updateUserExpensesToDb($id_wydatku, $wysokosc, $nazwa, $id, $user_id, $session_id) {
    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("UPDATE uzytkownik_wydatki SET id_wydatku = ?, wysokosc = ?, nazwa = ? WHERE id = ? AND id_uzytkownika = ? and sesja = $session_id");
        $stmt->bind_param("idsiis", $id_wydatku, $wysokosc, $nazwa, $id, $user_id, $session_id);
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
        return $rows[0]["id_dochodu"] ?? null;
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
        return $rows[0]["id_wydatku"] ?? null;
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in getIdWydatku: " . $e->getMessage());
        closeDbConnection($conn);
        return null;
    }
}

//zapisuje wybrane przez użytkownika parametry do kredytu
function saveParameters($session_id, $user_id, $id_user_dochody, $id_user_wydatki, $wiek, $osoby, $okres, $rodzaj_rata, $rodzaj_prct, $rrso) {
    $conn = openDbConnection();
    try {
        date_default_timezone_set('Europe/Warsaw');
        $now = date('Y-m-d H:i:s');  // np. 2026-01-31 13:02:00
        $stmt = $conn->prepare("INSERT INTO parametry VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiiiissds", $session_id, $user_id, $id_user_dochody, $id_user_wydatki, $wiek, $osoby, $okres, $rodzaj_rata, $rodzaj_prct, $rrso, $now);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in saveParameters: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}

//wczytywanie dodatkowych parametrów z pliku CSV
function readParametersFromCsv($filepath) {
    $data = [];

    if (($handle = fopen($filepath, 'r')) !== false) {
        // BOM (Byte Order Mark) dla UTF-8 – pomiń 3 pierwsze bajty jeśli istnieją
        $bom = fread($handle, 3);
        if ($bom != pack("CCC", 0xef, 0xbb, 0xbf)) {
            rewind($handle); // cofnij jeśli nie ma BOM
        }

        fgetcsv($handle, 1000, ';'); // odczytaj pierwszy wiersz "na pusto" by pominąć nagłówki

        while (($row = fgetcsv($handle, 1000, ';')) !== false) {
            $data[] = [
                'kpi' => trim($row[0] ?? ''),  // polskie znaki OK
                'wartosc' => (float) str_replace(',', '.', trim($row[1] ?? '0'))
            ];
        }
        fclose($handle);
    }
    return $data;
}

function getKpiValue($results, $kpiName) {
    foreach ($results as $item) {
        if ($item['kpi'] == $kpiName) {
            return $item['wartosc'];
        }
    }
    return null; // domyślna wartość
}

//oblicza zdolność kredytową na bazie wybranych przez użytkownika parametrów
function calculateCreditworthiness($sumaDochodow, $minWydatkow, $sumaDlugu, $wiek, $osoby, $okres, $rodzaj_rata, $rodzaj_prct, $rrso) {

    $parametry = readParametersFromCsv("src/dodatkowe_parametry.csv"); //dodatkowe parametry wczytywane z pliku CSV
    //tu powody podjęcia danej decyzji kredytowej
    $negatives = [];
    $positives = [];
    //przy braku zdolności będzie 0, w przypadku błędu zapisu prawdopodobnie null
    $zdolnosc = 0;
    $rata = 0.0;

    //odmowa z powodu nieodpowiedniego wieku kredytobiorcy
    $maxAge = getKpiValue($parametry, 'maksymalny wiek kredytobiorcy');
    $minAge = getKpiValue($parametry, 'minimalny wiek kredytobiorcy');
    if($wiek>$maxAge) {
        $negatives[] = "Banki nie udzielają kredytu ludziom po 75. roku życia - zbyt wysokie ryzyko śmierci przed spłatą.";
        return [
            'minusy'    => $negatives,
            'plusy'     => $positives,
            'zdolnosc'  => $zdolnosc,
            'rata'      => $rata,
        ];
    } else if($wiek<$minAge) {
        $negatives[] = "Kredytobiorca musi być pełnoletni.";
        return [
            'minusy'    => $negatives,
            'plusy'     => $positives,
            'zdolnosc'  => $zdolnosc,
            'rata'      => $rata,
        ];
    }

    //skrócenie okresu kredytowania z powodu wieku kredytobiorcy
    if($okres+$wiek>$maxAge) {
        $negatives[] = "Okres kredytowania musiał zostać skrócony do ". ($maxAge-$wiek) . " lat - spłata kredytu musi się zakończyć przed 75 rokiem życia kredytobiorcy.";
        //procedujemy dalej, no return
    }
    $okres = ($okres+$wiek>$maxAge) ? $maxAge-$wiek : $okres;

    //liczymy bufor do estymacji RRSO w zależności od rodzaju oprocentowania kredytu
    $highRiskBuffer = getKpiValue($parametry, 'bufor stopa zmienna');
    $moderateRiskBuffer = getKpiValue($parametry, 'bufor stopa okresowo zmienna');
    $bufor = 0;
    switch($rodzaj_prct) {
        case "zmienne":
            $bufor = 5; //największe ryzyko zmiany stopy procentowej
            break;
        case "okresowo stałe":
            $bufor = 2.5; //umiarkowane ryzyko
            break;
        default:
            $bufor = 0; //przy stopie stałej przez cały okres kredytowania - brak ryzyka
            break;
    }
    $estimatedRRSO = $rrso+$bufor;
    if($estimatedRRSO>$rrso) {
        $negatives[] = "Z powodu ryzyka zmiennej stopy procentowej estymacja RRSO musiała zostać zwiększona.";
        //procedujemy dalej, no return
    }

    //dopuszczalne DTI zależy od dochodu
    $avgSalaryNet = getKpiValue($parametry, 'średnia krajowa');
    $dtiReg = getKpiValue($parametry, 'DTI regularne');
    $dtiHigh = getKpiValue($parametry, 'DTI powyżej średniej');
    $dti = ($sumaDochodow>$avgSalaryNet) ? $dtiHigh/100.0 : $dtiReg/100.0;
    if($sumaDochodow>$avgSalaryNet) {
        $positives[] = "Z powodu zarobków powyżej średniej krajowej zastosowano podwyższony DTI (Debt To Income ratio: ".$dtiHigh. "%) do kalkulacji zdolności.";
    }
    $maxMonthlyDebt = $dti*$sumaDochodow;
    if($sumaDlugu>$maxMonthlyDebt || ($maxMonthlyDebt-$sumaDlugu-$minWydatkow)<0) {
        $negatives[] = "Z powodu zbyt dużej ilości długu nie można udzielić kolejnego kredytu.";
        return [
            'minusy'    => $negatives,
            'plusy'     => $positives,
            'zdolnosc'  => $zdolnosc,
            'rata'      => $rata,
        ];
    }

    $maxRata = $maxMonthlyDebt-$sumaDlugu-$minWydatkow*$osoby;
    $maxTotalDebt = $okres*12.0*$maxRata;
    $minMortgage = getKpiValue($parametry, 'minimalna wysokość kredytu');
    if($maxTotalDebt<$minMortgage) {
        $negatives[] = "Zbyt mała zdolność kredytowa";
        return [
            'minusy'    => $negatives,
            'plusy'     => $positives,
            'zdolnosc'  => $zdolnosc,
            'rata'      => $rata,
        ];
    }

    //liczymy maksymalną kwotę kredytu do udzielenia z odwróconych wzorów na ratę annuitetową i malejącą
    $n=$okres*12; //liczba rat
    $r=$estimatedRRSO/100.0/12.0; //miesięczna stopa procentowa
    if($rodzaj_rata == "stała") {
        $zdolnosc = $maxRata*((1+$r)**$n-1) / ($r*(1+$r)**$n);
        //$zdolnosc = $maxRata*((1+$r)^$n-1) / ($r*(1+$r)^$n); //matematycznie
    } else {
        $zdolnosc = $maxRata / (1/$n + $r);
    }

    //ponownie sprawdzamy czy jest minimalna zdolność, bo wcześniej liczyliśmy ile klient może spłacić z odsetkami, a teraz policzyliśmy ile kapitału bez odsetek może dostać
    if($zdolnosc<$minMortgage) {
        $negatives[] = "Zbyt mała zdolność kredytowa.";
        return [
            'minusy'    => $negatives,
            'plusy'     => $positives,
            'zdolnosc'  => 0,
            'rata'      => $rata,
        ];
    }

    $positives[] = "Zdolność kredytowa wystarczająca do wzięcia kredytu hipotecznego!";
    if($rodzaj_rata == "stała") {
        $rata = $maxRata;
    } else {
        $rata = $zdolnosc*$estimatedRRSO/100.0/12.0+$zdolnosc/$n; //rata odsetkowa + rata kapitałowa od pierwszej raty
    }

    return [
        'minusy'    => $negatives,
        'plusy'     => $positives,
        'zdolnosc'  => round($zdolnosc,-3, PHP_ROUND_HALF_EVEN),
        'rata'      => round($rata,2, PHP_ROUND_HALF_EVEN),
    ];
}

//zapisuje wartości obliczone na bazie wybranych przez użytkownika parametrów
function saveCreditworthiness($session_id, $user_id, $sumaDochodow, $minWydatkow, $sumaDlugu, $wynik) {

    //$id_parametrow = getParametryId($session_id, $user_id) ?? null;
    $minusy     = implode(";", $wynik['minusy']) ?? [];
    $plusy      = implode(";", $wynik['plusy']) ?? [];
    $zdolnosc   = $wynik['zdolnosc'] ?? 0;
    $rata       = $wynik['rata'] ?? 0.0;

    $conn = openDbConnection();
    try {
        $stmt = $conn->prepare("INSERT INTO wyniki VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sidddidss", $session_id, $user_id, $sumaDochodow, $minWydatkow, $sumaDlugu, $zdolnosc, $rata, $minusy, $plusy);
        $stmt->execute();
        $stmt->close();
        closeDbConnection($conn);
    }  catch (mysqli_sql_exception $e) {
        error_log("DB error in saveCreditworthiness: " . $e->getMessage()); // zapis do pliku ustawionego w error_log [web:123]
        closeDbConnection($conn);
    }
}
?>
