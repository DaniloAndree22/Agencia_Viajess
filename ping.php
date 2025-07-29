<?php
session_start();
$_SESSION['ultimo_acceso'] = time();
header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?>
