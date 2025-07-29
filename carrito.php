<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['paquete'])) {
    $paquete = filter_var($_POST['paquete'], FILTER_SANITIZE_STRING);
    if ($paquete) {
        $_SESSION['carrito'][] = $paquete;
    }
}

$travelPackages = $_SESSION['travelPackages'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
        <nav>
            <a href="index.php">Volver al Inicio</a>
        </nav>
    </header>

    <div class="search-container">
        <h2>Tu carrito de paquetes</h2>
        <?php if (!empty($_SESSION['carrito'])): ?>
            <ul>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['carrito'] as $item) {
                    $paquete = array_filter($travelPackages, fn($pkg) => $pkg['destination'] === $item);
                    $paquete = array_values($paquete)[0] ?? null;
                    if ($paquete) {
                        $totalPrice += $paquete['price'];
                        echo "<li>" . htmlspecialchars($item) . " - " . number_format($paquete['price'], 0, ',', '.') . " CLP</li>";
                    } else {
                        echo "<li>" . htmlspecialchars($item) . "</li>";
                    }
                }
                ?>
            </ul>
            <p><strong>Total: <?php echo number_format($totalPrice, 0, ',', '.'); ?> CLP</strong></p>
            <form method="post" action="finalizar.php">
                <button type="submit">Finalizar compra</button>
            </form>
        <?php else: ?>
            <p>El carrito está vacío.</p>
        <?php endif; ?>
    </div>
</body>
</html>
