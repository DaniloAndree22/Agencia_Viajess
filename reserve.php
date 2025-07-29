<?php
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$packageId = filter_var($input['packageId'] ?? 0, FILTER_VALIDATE_INT);

if (!$packageId || !isset($_SESSION['travelPackages'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

$package = array_filter($_SESSION['travelPackages'], fn($pkg) => $pkg['id'] === $packageId);
$package = array_values($package)[0] ?? null;

if (!$package || !$package['available']) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Paquete no disponible']);
    exit;
}

$_SESSION['travelPackages'] = array_map(function ($pkg) use ($packageId) {
    if ($pkg['id'] === $packageId) {
        $pkg['available'] = false;
    }
    return $pkg;
}, $_SESSION['travelPackages']);

$_SESSION['reservations'] = $_SESSION['reservations'] ?? [];
$_SESSION['reservations'][] = $package['name'] . ' - ' . $package['availableDate'];

echo json_encode(['success' => true, 'packageName' => $package['name']]);
?>
