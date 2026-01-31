<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/src/functions.php';

session_start();
if (empty($_SESSION['logged'])) {
    http_response_code(403);
    exit('Brak dostępu');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    removeUserIncome($id);
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(400);
echo json_encode(['success' => false]);

