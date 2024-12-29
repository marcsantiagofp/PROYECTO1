// Función para obtener usuarios de la API y mostrarlos en la tabla
async function fetchUsuarios() {
    const response = await fetch('?controller=api&action=obtenerUsuarios');
    const usuarios = await response.json();
    const tableBody = document.getElementById('section-table-body');
    const noDataMessage = document.getElementById('no-data-message');
    tableBody.innerHTML = ''; // Limpiar la tabla

    if (!Array.isArray(usuarios) || usuarios.length === 0) {
        noDataMessage.style.display = 'block'; // Mostrar mensaje de "No hay datos"
    } else {
        noDataMessage.style.display = 'none'; // Ocultar mensaje
        usuarios.forEach(usuario => {
            // Mostrar solo los primeros 8 caracteres de la contraseña
            const contrasenaVisible = usuario.contraseña ? usuario.contraseña.substring(0, 8) : '';

            tableBody.innerHTML += `
                <tr>
                    <td>${usuario.id}</td>
                    <td>${usuario.nombre}</td>
                    <td>${contrasenaVisible}...</td> <!-- Muestra solo los primeros 8 caracteres -->
                    <td>${usuario.email}</td>
                    <td>${usuario.direccion}</td> <!-- Dirección añadida -->
                    <td>${usuario.rol}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarElemento('usuario', ${usuario.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });

        // Añadir fila para nuevo usuario
        tableBody.innerHTML += `
            <tr id="nuevo-usuario">
                <td></td> <!-- La ID no debe tener campo ya que es automática -->
                <td><input type="text" id="nuevo-nombre" placeholder="Nombre" /></td>
                <td><input type="text" id="nuevo-contrasena" placeholder="Contraseña" /></td>
                <td><input type="email" id="nuevo-email" placeholder="Email" /></td>
                <td><input type="text" id="nuevo-direccion" placeholder="Dirección" /></td> <!-- Nuevo campo para dirección -->
                <td><input type="text" id="nuevo-rol" placeholder="Rol" /></td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="guardarUsuario()">Guardar</button>
                    <button class="btn btn-secondary btn-sm" onclick="cancelarCreacion()">Cancelar</button>
                </td>
            </tr>
        `;
    }
}



// Función para obtener productos de la API y mostrarlos en la tabla
async function fetchProductos() {
    const response = await fetch('?controller=api&action=obtenerProductos');
    const productos = await response.json();
    const tableBody = document.getElementById('section-table-body');
    const noDataMessage = document.getElementById('no-data-message');
    tableBody.innerHTML = ''; // Limpiar la tabla

    if (!Array.isArray(productos) || productos.length === 0) {
        noDataMessage.style.display = 'block'; // Mostrar mensaje de "No hay datos"
    } else {
        noDataMessage.style.display = 'none'; // Ocultar mensaje
        productos.forEach(producto => {
            tableBody.innerHTML += `
                <tr>
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.descripcion}</td>
                    <td>${producto.precio}</td>
                    <td>${producto.id_categoria}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarElemento('producto', ${producto.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });

        // Añadir fila para nuevo producto
        tableBody.innerHTML += `
            <tr id="nuevo-producto">
                <td></td> <!-- La ID no debe tener campo ya que es automática -->
                <td><input type="text" id="nuevo-nombre" placeholder="Nombre" /></td>
                <td><input type="text" id="nuevo-descripcion" placeholder="Descripción" /></td>
                <td><input type="number" id="nuevo-precio" placeholder="Precio" style="width: 100px;" /></td>
                <td><input type="number" id="nuevo-idcategoria" placeholder="Id Categoría" style="width: 100px;" /></td>
                <td>
                    <div style="display: flex; justify-content: space-between; gap: 5px;">
                        <button class="btn btn-success btn-sm" onclick="guardarProducto()">Guardar</button>
                        <button class="btn btn-secondary btn-sm" onclick="cancelarCreacion()">Cancelar</button>
                    </div>
                </td>
            </tr>
        `;
    }
}

// Función para obtener pedidos de la API y mostrarlos en la tabla
async function fetchPedidos() {
    const response = await fetch('?controller=api&action=obtenerPedidos');
    const pedidos = await response.json();
    const tableBody = document.getElementById('section-table-body');
    const noDataMessage = document.getElementById('no-data-message');
    tableBody.innerHTML = ''; // Limpiar la tabla

    if (!Array.isArray(pedidos) || pedidos.length === 0) {
        noDataMessage.style.display = 'block'; // Mostrar mensaje de "No hay datos"
    } else {
        noDataMessage.style.display = 'none'; // Ocultar mensaje
        pedidos.forEach(pedido => {
            tableBody.innerHTML += `
                <tr>
                    <td>${pedido.id}</td>
                    <td>${pedido.id_cliente}</td>
                    <td>${pedido.fecha_pedido}</td>
                    <td>${pedido.precio_total_pedidos}</td>
                    <td>${pedido.cantidad_productos}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarElemento('pedido', ${pedido.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });

        // Añadir fila para nuevo pedido
        tableBody.innerHTML += `
            <tr id="nuevo-pedido">
                <td></td> <!-- La ID no debe tener campo ya que es automática -->
                <td><input type="number" id="nuevo-cliente-id" placeholder="Cliente ID" /></td>
                <td><input type="text" id="nuevo-fecha-pedido" placeholder="Fecha Pedido" /></td>
                <td><input type="number" id="nuevo-precio-total" placeholder="Precio Total" /></td>
                <td><input type="number" id="nuevo-cantidad-productos" placeholder="Cantidad Productos" /></td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="guardarPedido()">Guardar</button>
                    <button class="btn btn-secondary btn-sm" onclick="cancelarCreacion()">Cancelar</button>
                </td>
            </tr>
        `;
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
    tableBody.innerHTML = ''; // Limpiar la tabla
    noDataMessage.style.display = 'none'; // Ocultar el mensaje de "No hay datos"

    document.getElementById('section-title').textContent = section.charAt(0).toUpperCase() + section.slice(1);

    const tableHeaders = document.getElementById('table-headers');
    let headers = '';

    if (section === 'usuarios') {
        headers = `
            <th>ID</th>
            <th>Nombre</th>
            <th>Contraseña</th>
            <th>Email</th>
            <th>Direccion</th>
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
            <th>Id Categoría</th>
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

// Función para guardar un nuevo usuario
async function guardarUsuario() {
    const nombre = document.getElementById('nuevo-nombre').value;
    const contrasena = document.getElementById('nuevo-contrasena').value;
    const email = document.getElementById('nuevo-email').value;
    const direccion = document.getElementById('nuevo-direccion').value;
    const rol = document.getElementById('nuevo-rol').value;

    if (!nombre || !contrasena || !email || !direccion || !rol) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    const response = await fetch('?controller=api&action=agregarElemento&tipo=usuario', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ nombre, contraseña: contrasena, email, direccion, rol }) // Enviar JSON
    });
    const result = await response.json();

    if (result.success) {
        fetchUsuarios(); // Actualizar la lista de usuarios
    } else {
        alert("Error al guardar el usuario");
    }
}

// Función para guardar un nuevo producto
async function guardarProducto() {
    const nombre = document.getElementById('nuevo-nombre').value;
    const descripcion = document.getElementById('nuevo-descripcion').value;
    const precio = document.getElementById('nuevo-precio').value;
    const idCategoria = document.getElementById('nuevo-idcategoria').value;

    if (!nombre || !descripcion || !precio || !idCategoria) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    const response = await fetch('?controller=api&action=agregarElemento&tipo=producto', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ nombre, descripcion, precio, id_categoria: idCategoria }) // Enviar JSON
    });
    const result = await response.json();

    if (result.success) {
        fetchProductos(); // Actualizar la lista de productos
    } else {
        alert("Error al guardar el producto");
    }
}

// Función para cancelar la creación de un nuevo usuario, producto o pedido
function cancelarCreacion() {
    const elementos = ['nuevo-usuario', 'nuevo-producto', 'nuevo-pedido'];
    
    elementos.forEach(id => {
        const row = document.getElementById(id);
        if (row) {
            // Limpiar los inputs dentro de la fila sin eliminar la fila
            const inputs = row.getElementsByTagName('input');
            for (let input of inputs) {
                input.value = ''; // Limpiar el valor de cada input
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    showSection('usuarios'); // Mostrar la sección de usuarios por defecto
});