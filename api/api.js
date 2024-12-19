// Función para obtener pedidos de la API y mostrarlos en la tabla
function fetchPedidos() {
    console.log("Cargando los pedidos..."); // Mensaje de debug para verificar que la función se ejecuta

    fetch('controllers/apicontroller.php?action=obtenerPedidos')
        .then(response => {
            console.log("Respuesta recibida del servidor:", response);  // Verificar respuesta del servidor
            return response.json();
        })
        .then(data => {
            console.log("Datos de pedidos recibidos:", data);  // Mensaje de debug con los datos de los pedidos

            const tableBody = document.querySelector('#pedidosTable tbody');
            tableBody.innerHTML = '';  // Limpiar la tabla antes de agregar los nuevos pedidos

            // Verificar si hay pedidos y agregarlos a la tabla
            if (data && Array.isArray(data) && data.length > 0) {
                console.log("Pedidos encontrados:", data);  // Mostrar los pedidos si se encuentran

                data.forEach(pedido => {
                    console.log("Procesando pedido:", pedido);  // Verificar cada pedido que se está procesando

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
            } else {
                // Si no hay pedidos, mostrar un mensaje
                console.log("No se encontraron pedidos o están vacíos.");
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No hay pedidos disponibles.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error al obtener pedidos:', error);  // Mensaje de error en la consola
            alert('Hubo un problema al cargar los pedidos.');
        });
}

// Cargar los pedidos cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    console.log("Cargando la página y los pedidos..."); // Mensaje para confirmar que la página se está cargando
    fetchPedidos();
});