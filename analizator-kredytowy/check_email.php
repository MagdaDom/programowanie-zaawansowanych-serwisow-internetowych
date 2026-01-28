<?php
header('Content-Type: application/json; charset=utf-8');
include('src/auth.php');

$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$email = trim($email);

if ($email === '') {
    echo json_encode(['ok' => false, 'exists' => false]);
    exit;
}
$exists = userEmailExists($email);

echo json_encode(['ok' => true, 'exists' => $exists]);