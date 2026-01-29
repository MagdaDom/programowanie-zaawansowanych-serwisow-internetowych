<?php
header('Content-Type: application/json; charset=utf-8');
include('src/auth.php');

$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$email = trim($email);

if ($email === '') {
    echo json_encode(['ok' => false, 'message' => 'Podaj adres e-mail!']);
    //echo json_encode(['ok' => false, 'exists' => false]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'message' => 'Adres e-mail ma niepoprawny format.']);
    exit;
}

$exists = userEmailExists($email);
if ($exists) {
    echo json_encode(['ok' => true, 'message' => 'Adres e-mail jest dostępny.']);
    //echo json_encode(['ok' => false, 'exists' => false]);
    exit;
} else {
    echo json_encode(['ok' => false, 'message' => 'Taki e-mail już istnieje!']);
    //echo json_encode(['ok' => false, 'exists' => false]);
    exit;
}

//echo json_encode(['ok' => true, 'message' => '']);