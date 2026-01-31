<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';

session_start();
if (empty($_SESSION['logged'])) {
    http_response_code(403);
    exit('Brak dostępu');
}

//zwracamy JSON do AJAX (Asynchronous JS) by mógł on przetworzyć dynamicznie formularz po kliknięciu przycisku "usuń" z wybranego wiersza w tabeli wydatków
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    removeUserExpense($id);
    echo json_encode(['success' => true]); //niepotrzebne po przeładowaniu strony
    exit;
}

http_response_code(400);
echo json_encode(['success' => false]);

