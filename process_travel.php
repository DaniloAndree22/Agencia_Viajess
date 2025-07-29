<?php
session_start();
require_once 'travelfilter.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Reemplazo de FILTER_SANITIZE_STRING con FILTER_SANITIZE_FULL_SPECIAL_CHARS
    $hotelName = filter_input(INPUT_POST, 'hotelName', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
    $destination = filter_input(INPUT_POST, 'destination', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Mantenemos los demás filtros
    $travelDate = filter_input(INPUT_POST, 'travelDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Puedes considerar usar FILTER_SANITIZE_FULL_SPECIAL_CHARS también
    $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);
    $maxPrice = filter_input(INPUT_POST, 'maxPrice', FILTER_VALIDATE_INT);

    if (!$destination || !$travelDate || $duration < 1 || (!is_numeric($maxPrice) && $maxPrice !== null)) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan datos obligatorios o son inválidos']);
        exit;
    }

    $packages = array_filter($_SESSION['travelPackages'] ?? [], function ($pkg) use ($destination, $travelDate, $maxPrice) {
        return $pkg['destination'] === $destination &&
               $pkg['availableDate'] === $travelDate &&
               $pkg['price'] <= $maxPrice &&
               $pkg['available'] === 1;
    });

    header('Content-Type: application/json');
    echo json_encode(['packages' => array_values($packages)]);
}
