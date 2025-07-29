<?php
session_start();
header('Content-Type: application/json');

$packages = $_SESSION['travelPackages'] ?? [];
if (empty($packages)) {
    echo json_encode(['offer' => null]);
    exit;
}

$randomPackage = $packages[array_rand($packages)];
if ($randomPackage['available']) {
    $discountedPrice = number_format($randomPackage['price'] * 0.9, 0, ',', '.');
    $offer = "Oferta: {$randomPackage['name']} - {$randomPackage['destination']} por {$discountedPrice} CLP";
    echo json_encode(['offer' => $offer]);
} else {
    echo json_encode(['offer' => null]);
}
?>
