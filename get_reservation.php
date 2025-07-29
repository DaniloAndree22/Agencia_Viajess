<?php
session_start();
header('Content-Type: application/json');
echo json_encode(['reservations' => $_SESSION['reservations'] ?? []]);
?>
