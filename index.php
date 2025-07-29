<?php
session_start();

// Simulación de base de datos para paquetes turísticos
$travelPackages = [
    [
        'id' => 1,
        'name' => 'Aventura en el Desierto',
        'destination' => 'San Pedro de Atacama',
        'price' => 450000,
        'availableDate' => '2025-07-01',
        'available' => true,
        'description' => 'Tour por el Valle de la Luna y géiseres del Tatio.',
        'imageUrl' => 'https://images.pexels.com/photos/27878409/pexels-photo-27878409.jpeg',
    ],
    [
        'id' => 2,
        'name' => 'Escapada Costera',
        'destination' => 'Valparaíso',
        'price' => 200000,
        'availableDate' => '2025-06-30',
        'available' => true,
        'description' => 'Paseo por cerros y playa en Viña del Mar.',
        'imageUrl' => 'https://images.pexels.com/photos/28872169/pexels-photo-28872169.jpeg',
    ],
    [
        'id' => 3,
        'name' => 'Lagos y Volcanes',
        'destination' => 'Puerto Varas',
        'price' => 350000,
        'availableDate' => '2025-07-15',
        'available' => true,
        'description' => 'Visita al Volcán Osorno y Saltos del Petrohué.',
        'imageUrl' => 'https://images.pexels.com/photos/12375259/pexels-photo-12375259.jpeg',
    ],
    [
        'id' => 4,
        'name' => 'Cultura Capitalina',
        'destination' => 'Santiago',
        'price' => 150000,
        'availableDate' => '2025-06-25',
        'available' => true,
        'description' => 'Tour por el centro histórico y cerro San Cristóbal.',
        'imageUrl' => 'https://images.pexels.com/photos/2017747/pexels-photo-2017747.jpeg',
    ],
];

$_SESSION['travelPackages'] = $travelPackages;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Viajes - Chile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Explora Chile</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <a href="carrito.php">Carrito</a>
        </nav>
    </header>

    <?php
    function showSpecialOffers() {
        $offers = [
            ["message" => "¡Oferta Especial! Vuelos a Valparaíso desde $10,000 CLP", "link" => "#valparaiso"],
            ["message" => "Descuento del 20% en hoteles en San Pedro de Atacama", "link" => "#sanpedro"],
            ["message" => "Paquete turístico completo a Puerto Varas por $50,000 CLP", "link" => "#puertovaras"]
        ];
        echo '<div id="notifications-container">';
        foreach ($offers as $offer) {
            echo '<div class="notification">';
            echo '<p>' . htmlspecialchars($offer['message']) . '</p>';
            echo '<a href="' . htmlspecialchars($offer['link']) . '">Ver oferta</a>';
            echo '</div>';
        }
        echo '</div>';
    }
    showSpecialOffers();
    ?>

    <div class="search-container">
        <form action="process_travel.php" method="post" id="search-form">
            <select name="destination" id="destination" required>
                <option value="">Selecciona un destino</option>
                <option value="San Pedro de Atacama">San Pedro de Atacama</option>
                <option value="Valparaíso">Valparaíso</option>
                <option value="Puerto Varas">Puerto Varas</option>
                <option value="Santiago">Santiago</option>
            </select>
            <input type="date" name="travelDate" id="travel-date" min="<?php echo date('Y-m-d'); ?>" required>
            <input type="number" name="maxPrice" id="max-price" placeholder="Precio máximo (CLP)" min="0">
            <label for="hotelName">Nombre del Hotel:</label>
            <input type="text" name="hotelName" id="hotelName" required>
            <label for="city">Ciudad:</label>
            <input type="text" name="city" id="city" required>
            <label for="country">País:</label>
            <input type="text" name="country" id="country" required>
            <label for="duration">Duración (días):</label>
            <input type="number" name="duration" id="duration" min="1" required>
            <button type="submit">Buscar</button>
        </form>
    </div>

    <div id="results-container"></div>
    <div id="reservations-container"></div>

    <div style="text-align:center;">
        <form method="post" action="carrito.php">
            <input type="hidden" name="paquete" value="Puerto Varas">
            <button type="submit">Agregar “Puerto Varas” al carrito</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
