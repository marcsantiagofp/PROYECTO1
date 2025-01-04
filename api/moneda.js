const apiKey = 'fca_live_y1OJ8shzvaB7Bm0r8w6DalLIodXOyZFLBN6sHA6f'; // Clave de la API par monedas

//Decalranos variables default
let tasasDeCambio = {}; // Objeto para almacenar las tasas de cambio
let monedaSeleccionada = 'EUR'; // Moneda predeterminada (Euro)

// Definición de símbolos de monedas
const simbolosMoneda = {
    'AUD': 'A$',  // Dólar australiano
    'BGN': 'лв',  // Lev búlgaro
    'BRL': 'R$',  // Real brasileño
    'CAD': 'C$',  // Dólar canadiense
    'CHF': 'CHF', // Franco suizo
    'CNY': '¥',   // Yuan chino
    'CZK': 'Kč',  // Corona checa
    'DKK': 'kr',  // Corona danesa
    'EUR': '€',   // Euro
    'GBP': '£',   // Libra esterlina
    'HKD': 'HK$', // Dólar de Hong Kong
    'HRK': 'kn',  // Kuna croata
    'HUF': 'Ft',  // Forinto húngaro
    'IDR': 'Rp',  // Rupia indonesia
    'ILS': '₪',   // Nuevo shekel israelí
    'INR': '₹',   // Rupia india
    'ISK': 'kr',  // Corona islandesa
    'JPY': '¥',   // Yen japonés
    'KRW': '₩',   // Won surcoreano
    'MXN': '$',   // Peso mexicano
    'MYR': 'RM',  // Ringgit malasio
    'NOK': 'kr',  // Corona noruega
    'NZD': 'NZ$', // Dólar neozelandés
    'PHP': '₱',   // Peso filipino
    'PLN': 'zł',  // Zloty polaco
    'RON': 'lei', // Leu rumano
    'RUB': '₽',   // Rublo ruso
    'SEK': 'kr',  // Corona sueca
    'SGD': '$',   // Dólar de Singapur
    'THB': '฿',   // Baht tailandés
    'TRY': '₺',   // Lira turca
    'USD': '$',   // Dólar estadounidense
    'ZAR': 'R',   // Rand sudafricano
};

// Función para obtener las tasas de cambio de la API
function obtenerTasasDeCambio() {
    fetch(`https://api.freecurrencyapi.com/v1/latest?apikey=${apiKey}`)
        .then(response => response.json())
        .then(data => {
            tasasDeCambio = data.data;
            console.log('Tasas de cambio:', tasasDeCambio); // Mostramos las tasas de cambio
            actualizarSelectorMoneda(); // Actualizar selectores de moneda
            actualizarPrecios(); // Refrescar los precios al obtener las tasas
        })
        .catch(error => console.error('Error al obtener las tasas de cambio:', error));
}

// Función para actualizar los selectores de moneda en la interfaz
function actualizarSelectorMoneda() {
    const selectoresMoneda = document.querySelectorAll('#selectorDeMonedaPedidos');
    
    selectoresMoneda.forEach(selector => {
        selector.innerHTML = ''; // Limpiar las opciones del selector
        
        // Llenar el selector con las monedas disponibles
        for (const moneda in tasasDeCambio) {
            const option = document.createElement('option');
            option.value = moneda;
            option.text = `${moneda} (${simbolosMoneda[moneda] || moneda})`;
            selector.appendChild(option); // Añadir la opción al selector
        }

        // Establecer la moneda seleccionada o la predeterminada
        selector.value = monedaSeleccionada;
    });
}

// Función para convertir el precio según la moneda seleccionada
function convertirPrecio(precio, moneda) {
    if (moneda === 'EUR') return `${precio} €`; // Si la moneda es EUR, mostramos el símbolo del Euro
    const tasaCambio = tasasDeCambio[moneda]; // Obtener la tasa de cambio
    const simbolo = simbolosMoneda[moneda] || moneda; // Obtener el símbolo de la moneda
    return `${(precio * tasaCambio).toFixed(2)} ${simbolo}`; // Calcular el precio convertido y mostrarlo
}

// Evento para manejar el cambio de moneda en los selectores
document.querySelectorAll('#selectorDeMonedaPedidos').forEach(selector => {
    selector.addEventListener('change', function() {
        monedaSeleccionada = this.value; // Actualizar la moneda seleccionada
        actualizarPrecios(); // Actualizar los precios según la nueva moneda
    });
});

// Función para actualizar todos los precios en la página
function actualizarPrecios() {
    // Actualizar precios en la tabla de pedidos
    document.querySelectorAll('#pedidosTable tbody tr').forEach(row => {
        const cellTotal = row.querySelector('td:nth-child(4)');
        const total = parseFloat(cellTotal.dataset.originalPrice); // Obtener el precio original
        cellTotal.textContent = convertirPrecio(total, monedaSeleccionada); // Convertir y mostrar el precio
    });

    // Actualizar precios en la tabla de productos
    document.querySelectorAll('#productosTable tbody tr').forEach(row => {
        const cellPrice = row.querySelector('td:nth-child(4)');
        const price = parseFloat(cellPrice.dataset.originalPrice); // Obtener el precio original
        cellPrice.textContent = convertirPrecio(price, monedaSeleccionada); // Convertir y mostrar el precio
    });
}

// Llamar a la función de obtener tasas de cambio al cargar la página
obtenerTasasDeCambio();