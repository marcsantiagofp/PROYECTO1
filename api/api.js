// Función para obtener pedidos de la API y mostrarlos en la tabla
function fetchPedidos() {
    console.log("Iniciando la solicitud para obtener los pedidos...");

    fetch('?controller=api&action=obtenerPedidos')
        .then(response => {
            console.log("Respuesta HTTP recibida:", response);
            if (!response.ok) {
                throw new Error(`Error en la solicitud: ${response.status} ${response.statusText}`);
            }
            return response.text();  // Obtener la respuesta como texto
        })
        .then(text => {
            try {
                const data = JSON.parse(text);  // Intentamos convertir el texto a JSON
                console.log("Datos obtenidos de la API:", data); // Mostrar los datos recibidos

                // Validar si los datos son un array y no están vacíos
                if (data && Array.isArray(data) && data.length > 0) {
                    console.log("Array de pedidos procesado correctamente:", data); // Mostrar el array completo
                    mostrarPedidosEnTabla(data); // Llamar a la función para mostrar los pedidos en la tabla
                } else {
                    console.warn("No hay pedidos disponibles o los datos no son válidos.");
                    mostrarMensajeNoHayPedidos(); // Mostrar mensaje en la tabla si no hay pedidos
                }
            } catch (error) {
                console.error('Error al parsear los datos JSON:', error);
                alert('Hubo un problema al procesar los datos de la API. Revisa la consola para más detalles.');
            }
        })
        .catch(error => {
            console.error('Error durante la obtención de los pedidos:', error);
            alert('Hubo un problema al cargar los pedidos. Revisa la consola para más detalles.');
        });
}

// Función para mostrar los pedidos en la tabla
function mostrarPedidosEnTabla(pedidos) {
    const tableBody = document.querySelector('#pedidosTable tbody');
    tableBody.innerHTML = ''; // Limpiar la tabla antes de llenarla

    pedidos.forEach(pedido => {
        console.log("Procesando pedido individual:", pedido); // Depuración de cada pedido

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${pedido.id}</td>
            <td>${pedido.id_cliente}</td>
            <td>${pedido.fecha_pedido}</td>
            <td>$${pedido.precio_total_pedidos}</td>
            <td>${pedido.cantidad_productos}</td>
        `;
        tableBody.appendChild(row);
    });
}

// Función para mostrar un mensaje si no hay pedidos
function mostrarMensajeNoHayPedidos() {
    const tableBody = document.querySelector('#pedidosTable tbody');
    tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No hay pedidos disponibles.</td></tr>';
}

// Cargar los pedidos cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    console.log("Cargando la página y solicitando los pedidos...");
    fetchPedidos(); // Llamar a la función para obtener y mostrar los pedidos
});