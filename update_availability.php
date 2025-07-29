<?php
session_start();
header('Content-Type: application/json');

$packages = $_SESSION['travelPackages'] ?? [];
if (empty($packages)) {
    echo json_encode(['message' => null]);
    exit;
}

$randomIndex = array_rand($packages);
$randomPackage = &$packages[$randomIndex];

if ($randomPackage['available']) {
    $randomPackage['available'] = false;
    $_SESSION['travelPackages'] = $packages;
    $message = "Aviso: {$randomPackage['name']} no disponible";
    echo json_encode(['message' => $message]);
} else {
    echo json_encode(['message' => null]);
}
?>
