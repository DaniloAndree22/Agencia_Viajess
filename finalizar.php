<?php
session_start();
$travelPackages = $_SESSION['travelPackages'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Resumen de Compra</h1>
        <nav>
            <a href="index.php">Volver al Inicio</a>
        </nav>
    </header>

    <div class="search-container">
        <h2>Resumen de compra</h2>
        <?php
        if (!empty($_SESSION['carrito'])) {
            $totalPrice = 0;
            echo "<ul>";
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
            echo "</ul>";
            echo "<p><strong>Total: " . number_format($totalPrice, 0, ',', '.') . " CLP</strong></p>";
            echo "<p>¡Gracias por confiar en nuestra agencia!</p>";
            session_destroy();
        } else {
            echo "<p>No hay paquetes seleccionados.</p>";
        }
        ?>
    </div>
</body>
</html>
