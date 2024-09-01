// Define los precios por tipo de habitación y dispositivo
const roomPrices = {
    single: { mobile: 60, desktop: 80 },  // Precio por noche para habitación sencilla
    double: { mobile: 80, desktop: 100 }, // Precio por noche para habitación doble
    suite: { mobile: 120, desktop: 150 }  // Precio por noche para suite
};

// Función para detectar si el usuario está en un dispositivo móvil
function isMobile() {
    return /Mobi|Android/i.test(navigator.userAgent);
}

// Función para calcular el precio total
function calculatePrice() {
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;
    const roomType = document.getElementById('room').value;

    if (checkin && checkout) {
        const checkinDate = new Date(checkin);
        const checkoutDate = new Date(checkout);
        const timeDifference = checkoutDate - checkinDate;
        const nightCount = timeDifference / (1000 * 3600 * 24);

        if (nightCount > 0) {
            const deviceType = isMobile() ? 'mobile' : 'desktop';
            const pricePerNight = roomPrices[roomType][deviceType];
            const totalPrice = nightCount * pricePerNight;

            document.getElementById('price').textContent = `Precio Total: $${totalPrice.toFixed(2)}`;
        } else {
            document.getElementById('price').textContent = 'Por favor, ingresa fechas válidas.';
        }
    }
}

// Configura los eventos para actualizar el precio al cambiar las fechas o el tipo de habitación
document.getElementById('checkin').addEventListener('change', calculatePrice);
document.getElementById('checkout').addEventListener('change', calculatePrice);
document.getElementById('room').addEventListener('change', calculatePrice);

// Actualiza el precio al cargar la página si ya hay fechas seleccionadas
window.addEventListener('load', calculatePrice);
