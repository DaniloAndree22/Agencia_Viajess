const travelPackages = [
    {
        id: 1,
        name: "Aventura en el Desierto",
        destination: "San Pedro de Atacama",
        price: 450000,
        availableDate: "2025-07-01",
        available: true,
        description: "Tour por el Valle de la Luna y géiseres del Tatio.",
        imageUrl: "https://images.pexels.com/photos/27878409/pexels-photo-27878409.jpeg",
        getSummary: function () {
            return this.name + " - " + this.destination + " por " + this.price.toLocaleString("es-CL") + " CLP";
        },
    },
    {
        id: 2,
        name: "Escapada Costera",
        destination: "Valparaíso",
        price: 200000,
        availableDate: "2025-06-30",
        available: true,
        description: "Paseo por cerros y playa en Viña del Mar.",
        imageUrl: "https://images.pexels.com/photos/28872169/pexels-photo-28872169.jpeg",
        getSummary: function () {
            return this.name + " - " + this.destination + " por " + this.price.toLocaleString("es-CL") + " CLP";
        },
    },
    {
        id: 3,
        name: "Lagos y Volcanes",
        destination: "Puerto Varas",
        price: 350000,
        availableDate: "2025-07-15",
        available: true,
        description: "Visita al Volcán Osorno y Saltos del Petrohué.",
        imageUrl: "https://images.pexels.com/photos/12375259/pexels-photo-12375259.jpeg",
        getSummary: function () {
            return this.name + " - " + this.destination + " por " + this.price.toLocaleString("es-CL") + " CLP";
        },
    },
    {
        id: 4,
        name: "Cultura Capitalina",
        destination: "Santiago",
        price: 150000,
        availableDate: "2025-06-25",
        available: true,
        description: "Tour por el centro histórico y cerro San Cristóbal.",
        imageUrl: "https://images.pexels.com/photos/2017747/pexels-photo-2017747.jpeg",
        getSummary: function () {
            return this.name + " - " + this.destination + " por " + this.price.toLocaleString("es-CL") + " CLP";
        },
    },
];

function search() {
    const destination = document.getElementById("destination");
    const travelDate = document.getElementById("travel-date");
    const maxPrice = document.getElementById("max-price");
    const resultsContainer = document.getElementById("results-container");

    if (!destination || !travelDate || !maxPrice || !resultsContainer) {
        console.error("Elementos del DOM no encontrados");
        return;
    }

    const destValue = destination.value;
    const dateValue = travelDate.value;
    const maxPriceValue = maxPrice.value ? parseInt(maxPrice.value) : Infinity;

    if (!destValue || !dateValue) {
        resultsContainer.innerHTML = "<p>Selecciona destino y fecha.</p>";
        return;
    }

    const filteredPackages = travelPackages.filter(
        (pkg) =>
            pkg.destination === destValue &&
            new Date(pkg.availableDate).toDateString() === new Date(dateValue).toDateString() &&
            pkg.price <= maxPriceValue &&
            pkg.available
    );

    resultsContainer.innerHTML = "";
    if (filteredPackages.length === 0) {
        resultsContainer.innerHTML = "<p>No hay paquetes disponibles.</p>";
        return;
    }

    filteredPackages.forEach((pkg) => {
        const card = document.createElement("div");
        card.className = "result-card";
        card.innerHTML = `
            <img src="${pkg.imageUrl}" alt="${pkg.name}" style="width: 100%; border-radius: 5px;">
            <h3>${pkg.name}</h3>
            <p>Destino: ${pkg.destination}</p>
            <p>Fecha: ${pkg.availableDate}</p>
            <p>Precio: ${pkg.price.toLocaleString("es-CL")} CLP</p>
            <p>${pkg.description}</p>
            <p>${pkg.available ? "Disponible" : "No disponible"}</p>
            <button onclick="reserve(${pkg.id})">Reservar</button>
        `;
        resultsContainer.appendChild(card);
    });
}

function reserve(packageId) {
    const pkg = travelPackages.find((p) => p.id === packageId);
    if (pkg && pkg.available) {
        if (confirm("¿Confirmar reserva para " + pkg.name + "?")) {
            pkg.available = false;
            reservations.push(pkg.name + " - " + pkg.availableDate);
            showNotification("Reserva confirmada para " + pkg.name);
            updateReservations();
            search();
        }
    } else {
        showNotification("Paquete no disponible");
    }
}

function showNotification(message) {
    const container = document.getElementById("notifications-container");
    if (!container) return;
    const notification = document.createElement("div");
    notification.className = "notification";
    notification.textContent = message;
    container.appendChild(notification);
    setTimeout(() => notification.remove(), 5000);
}

function updateReservations() {
    const container = document.getElementById("reservations-container");
    if (!container) return;
    container.innerHTML = "<h3>Reservas:</h3>" + (reservations.length ? reservations.join("<br>") : "Ninguna reserva.");
}

// Simulación de ofertas cada 10 segundos
setInterval(() => {
    const randomPackage = travelPackages[Math.floor(Math.random() * travelPackages.length)];
    if (randomPackage.available) {
        const discountedPrice = (randomPackage.price * 0.9).toLocaleString("es-CL");
        showNotification("Oferta: " + randomPackage.getSummary() + " por " + discountedPrice + " CLP");
    }
}, 10000);

// Simulación de cambio de disponibilidad cada 15 segundos
setInterval(() => {
    const randomPackage = travelPackages[Math.floor(Math.random() * travelPackages.length)];
    if (randomPackage.available) {
        randomPackage.available = false;
        showNotification("Aviso: " + randomPackage.name + " no disponible");
        search();
    }
}, 15000);

const destinationSelect = document.getElementById("destination");
if (destinationSelect) {
    destinationSelect.addEventListener("change", (e) => {
        if (e.target.value) {
            console.log("Buscando paquetes para " + e.target.value);
        }
    });
}

setInterval(() => {
    fetch("ping.php");
}, 600000); // cada 10 minutos
