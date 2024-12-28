// Función para obtener usuarios de la API y mostrarlos en la tabla
async function fetchUsuarios() {
    const response = await fetch('?controller=api&action=obtenerUsuarios');
    const usuarios = await response.json();
    const tableBody = document.getElementById('section-table-body');
    const noDataMessage = document.getElementById('no-data-message');
    tableBody.innerHTML = '';  // Limpiar la tabla
    if (!Array.isArray(usuarios) || usuarios.length === 0) {
        noDataMessage.style.display = 'block';  // Mostrar mensaje de "No hay datos"
    } else {
        noDataMessage.style.display = 'none';  // Ocultar mensaje
        usuarios.forEach(usuario => {
            tableBody.innerHTML += `
                <tr>
                    <td>${usuario.id}</td>
                    <td>${usuario.nombre}</td>
                    <td>${usuario.email}</td>
                    <td>${usuario.telefono}</td>
                    <td>${usuario.rol}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarElemento('usuario', ${usuario.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    }
}

// Función para obtener productos de la API y mostrarlos en la tabla
async function fetchProductos() {
    const response = await fetch('?controller=api&action=obtenerProductos');
    const productos = await response.json();
    const tableBody = document.getElementById('section-table-body');
    const noDataMessage = document.getElementById('no-data-message');
    tableBody.innerHTML = '';  // Limpiar la tabla

    if (!Array.isArray(productos) || productos.length === 0) {
        noDataMessage.style.display = 'block';  // Mostrar mensaje de "No hay datos"
    } else {
        noDataMessage.style.display = 'none';  // Ocultar mensaje
        productos.forEach(producto => {
            tableBody.innerHTML += `
                <tr>
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.descripcion}</td>
                    <td>${producto.precio}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarElemento('producto', ${producto.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    }
}

// Función para obtener pedidos de la API y mostrarlos en la tabla
async function fetchPedidos() {
    const response = await fetch('?controller=api&action=obtenerPedidos');
    const pedidos = await response.json();
    const tableBody = document.getElementById('section-table-body');
    const noDataMessage = document.getElementById('no-data-message');
    tableBody.innerHTML = '';  // Limpiar la tabla
    if (!Array.isArray(pedidos) || pedidos.length === 0) {
        noDataMessage.style.display = 'block';  // Mostrar mensaje de "No hay datos"
    } else {
        noDataMessage.style.display = 'none';  // Ocultar mensaje
        pedidos.forEach(pedido => {
            tableBody.innerHTML += `
                <tr>
                    <td>${pedido.id}</td>
                    <td>${pedido.id_cliente}</td>
                    <td>${pedido.fecha_pedido}</td>
                    <td>${pedido.precio_total_pedidos}</td>
                    <td>${pedido.cantidad_productos}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">Ver</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarElemento('pedido', ${pedido.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    }
}

// Función para eliminar un elemento de la base de datos
async function eliminarElemento(tipo, id) {
    const response = await fetch(`?controller=api&action=eliminarElemento&tipo=${tipo}&id=${id}`, { method: 'GET' });
    const result = await response.json();
    
    if (result.success) {
        if (tipo === 'usuario') {
            fetchUsuarios();
        } else if (tipo === 'producto') {
            fetchProductos();
        } else if (tipo === 'pedido') {
            fetchPedidos();
        }
    } else {
        alert(result.error || "Hubo un error al eliminar el elemento.");
    }
}

// Función para mostrar la sección correspondiente
function showSection(section) {
    const tableBody = document.getElementById('section-table-body');
    const noDataMessage = document.getElementById('no-data-message');
    tableBody.innerHTML = '';  // Limpiar la tabla
    noDataMessage.style.display = 'none';  // Ocultar el mensaje de "No hay datos"

    document.getElementById('section-title').textContent = section.charAt(0).toUpperCase() + section.slice(1);

    const tableHeaders = document.getElementById('table-headers');
    let headers = '';
    
    if (section === 'usuarios') {
        headers = `
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Rol</th>
            <th>Acciones</th>
        `;
        fetchUsuarios();
    } else if (section === 'productos') {
        headers = `
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        `;
        fetchProductos();
    } else if (section === 'pedidos') {
        headers = `
            <th>ID</th>
            <th>Cliente ID</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Cantidad de Productos</th>
            <th>Acciones</th>
        `;
        fetchPedidos();
    }

    tableHeaders.innerHTML = headers;
}

// Iniciar con la sección de usuarios
document.addEventListener('DOMContentLoaded', () => {
    showSection('usuarios');
});