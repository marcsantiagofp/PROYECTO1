// Función para obtener usuarios de la API y mostrarlos en la tabla
async function fetchUsuarios() {
    const response = await fetch('?controller=api&action=obtenerUsuarios');
    usuarios = await response.json(); // Almacenar los usuarios en la variable global
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
                <tr id="usuario-${usuario.id}">
                    <td>${usuario.id}</td>
                    <td>${usuario.nombre}</td>
                    <td>${contrasenaVisible}...</td> <!-- Muestra solo los primeros 8 caracteres -->
                    <td>${usuario.email}</td>
                    <td>${usuario.direccion}</td> <!-- Dirección añadida -->
                    <td>${usuario.rol}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="habilitarEdicionUsuario(${usuario.id})">Editar</button>
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
    productos = await response.json(); // Almacenar los productos en la variable global
    const tableBody = document.getElementById('section-table-body');
    const noDataMessage = document.getElementById('no-data-message');
    tableBody.innerHTML = ''; // Limpiar la tabla

    if (!Array.isArray(productos) || productos.length === 0) {
        noDataMessage.style.display = 'block'; // Mostrar mensaje de "No hay datos"
    } else {
        noDataMessage.style.display = 'none'; // Ocultar mensaje
        productos.forEach(producto => {
            tableBody.innerHTML += `
                <tr id="producto-${producto.id}">
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.descripcion}</td>
                    <td>${producto.precio}</td>
                    <td>${producto.id_categoria}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="habilitarEdicionProducto(${producto.id})">Editar</button>
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
                    <button class="btn btn-success btn-sm" onclick="guardarProducto()">Guardar</button>
                    <button class="btn btn-secondary btn-sm" onclick="cancelarCreacion()">Cancelar</button>
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

//FUNCIONES PARA AGREGAR
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

//FUNCIONES PARA MODIFICAR USUARIOS
let filasOriginalesUsuario = {}; // Objeto para almacenar el HTML original de las filas

// Esta función siempre obtiene los datos más actualizados del usuario desde el servidor
async function habilitarEdicionUsuario(usuarioId) {
    const fila = document.getElementById(`usuario-${usuarioId}`);
    if (!fila) return;

    // Guardamos el HTML original de la fila antes de modificarla
    filasOriginalesUsuario[usuarioId] = fila.innerHTML;

    // Realizamos una solicitud al servidor para obtener los datos más actualizados del usuario
    const response = await fetch(`?controller=api&action=obtenerUsuarioPorId&id=${usuarioId}`);
    const usuario = await response.json();

    if (!usuario || !usuario.id) {
        alert("Hubo un error al obtener los datos del usuario.");
        return;
    }

    // Reemplazamos la fila con los inputs para edición
    fila.innerHTML = `
        <td>${usuario.id}</td>
        <td><input type="text" id="editar-nombre-${usuario.id}" value="${usuario.nombre}" /></td>
        <td><input type="text" id="editar-contrasena-${usuario.id}" value="${usuario.contraseña}" /></td>
        <td><input type="email" id="editar-email-${usuario.id}" value="${usuario.email}" /></td>
        <td><input type="text" id="editar-direccion-${usuario.id}" value="${usuario.direccion}" /></td>
        <td><input type="text" id="editar-rol-${usuario.id}" value="${usuario.rol}" /></td>
        <td>
            <button class="btn btn-success btn-sm" onclick="actualizarUsuario(${usuario.id})">Guardar</button>
            <button class="btn btn-secondary btn-sm" onclick="acabarEdicion(${usuario.id})">Acabar</button>
        </td>
    `;
}


// Función para actualizar un usuario
async function actualizarUsuario(usuarioId) {
    const nombre = document.getElementById(`editar-nombre-${usuarioId}`).value;
    const contrasena = document.getElementById(`editar-contrasena-${usuarioId}`).value;
    const email = document.getElementById(`editar-email-${usuarioId}`).value;
    const direccion = document.getElementById(`editar-direccion-${usuarioId}`).value;
    const rol = document.getElementById(`editar-rol-${usuarioId}`).value;

    if (!nombre || !contrasena || !email || !direccion || !rol) {
        alert("Por favor, complete todos los campos.");
        return;
    }

    const response = await fetch('?controller=api&action=actualizarElemento&tipo=usuario', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: usuarioId, nombre, contraseña: contrasena, email, direccion, rol }),
    });

    const result = await response.json();
    if (result.success) {
        fetchUsuarios(); // Actualizar la lista de usuarios
    } else {
        alert(result.error || "Error al actualizar el usuario.");
    }
}

async function acabarEdicion(usuarioId) {
    const fila = document.getElementById(`usuario-${usuarioId}`);
    if (!fila) return;

    // Realizar una solicitud para obtener el usuario actualizado desde el servidor
    const response = await fetch(`?controller=api&action=obtenerUsuarioPorId&id=${usuarioId}`);
    const usuarioActualizado = await response.json();

    if (!usuarioActualizado || !usuarioActualizado.id) {
        alert("Hubo un error al obtener los datos actualizados del usuario.");
        return;
    }

    // Restaurar la fila con los nuevos datos del usuario
    fila.innerHTML = `
        <td>${usuarioActualizado.id}</td>
        <td>${usuarioActualizado.nombre}</td>
        <td>${usuarioActualizado.contraseña.substring(0, 8)}...</td> <!-- Mostrar solo los primeros 8 caracteres -->
        <td>${usuarioActualizado.email}</td>
        <td>${usuarioActualizado.direccion}</td>
        <td>${usuarioActualizado.rol}</td>
        <td>
            <button class="btn btn-primary btn-sm" onclick="habilitarEdicionUsuario(${usuarioActualizado.id})">Editar</button>
            <button class="btn btn-danger btn-sm" onclick="eliminarElemento('usuario', ${usuarioActualizado.id})">Eliminar</button>
        </td>
    `;
}

//FUNCIONES PARA MODIFICAR PRODUCTOS
let filasOriginalesProductos = {}; // Objeto para almacenar el HTML original de las filas de productos

// Esta función obtiene los datos más actualizados del producto desde el servidor
async function habilitarEdicionProducto(productoId) {
    const fila = document.getElementById(`producto-${productoId}`);
    if (!fila) return;

    // Guardamos el HTML original de la fila antes de modificarla
    filasOriginalesProductos[productoId] = fila.innerHTML;

    // Realizamos una solicitud al servidor para obtener los datos más actualizados del producto
    const response = await fetch(`?controller=api&action=obtenerProductoPorId&id=${productoId}`);
    const producto = await response.json();

    if (!producto || !producto.id) {
        alert("Hubo un error al obtener los datos del producto.");
        return;
    }

    // Reemplazamos la fila con los inputs para edición
    fila.innerHTML = `
        <td>${producto.id}</td>
        <td><input type="text" id="editar-nombre-${producto.id}" value="${producto.nombre}" /></td>
        <td><textarea id="editar-descripcion-${producto.id}">${producto.descripcion}</textarea></td>
        <td><input type="number" step="0.01" id="editar-precio-${producto.id}" value="${producto.precio}" /></td>
        <td><input type="number" id="editar-id-categoria-${producto.id}" value="${producto.id_categoria}" /></td>
        <td>
            <button class="btn btn-success btn-sm" onclick="actualizarProducto(${producto.id})">Guardar</button>
            <button class="btn btn-secondary btn-sm" onclick="acabarEdicionProducto(${producto.id})">Acabar</button>
        </td>
    `;
}

// Función para actualizar un producto
async function actualizarProducto(productoId) {
    const nombre = document.getElementById(`editar-nombre-${productoId}`).value;
    const descripcion = document.getElementById(`editar-descripcion-${productoId}`).value;
    const precio = parseFloat(document.getElementById(`editar-precio-${productoId}`).value);
    const id_categoria = parseInt(document.getElementById(`editar-id-categoria-${productoId}`).value);

    if (!nombre || !descripcion || isNaN(precio) || isNaN(id_categoria)) {
        alert("Por favor, complete todos los campos obligatorios.");
        return;
    }

    // Realizar la solicitud al servidor para actualizar el producto
    const response = await fetch('?controller=api&action=actualizarElemento&tipo=producto', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: productoId, nombre, descripcion, precio, id_categoria }),
    });

    // Verificar la respuesta del servidor
    const result = await response.json();
    if (result.success) {
        // Actualizar la lista de productos o realizar cualquier acción posterior
        fetchProductos(); // Actualizar la lista de productos
    } else {
        alert(result.error || "Error al actualizar el producto.");
    }
}

// Función para cancelar la edición de un producto
async function acabarEdicionProducto(productoId) {
    const fila = document.getElementById(`producto-${productoId}`);
    if (!fila) return;

    // Realizar una solicitud para obtener el producto actualizado desde el servidor
    const response = await fetch(`?controller=api&action=obtenerProductoPorId&id=${productoId}`);
    const productoActualizado = await response.json();

    if (!productoActualizado || !productoActualizado.id) {
        alert("Hubo un error al obtener los datos actualizados del producto.");
        return;
    }

    // Restaurar la fila con los nuevos datos del producto
    fila.innerHTML = `
        <td>${productoActualizado.id}</td>
        <td>${productoActualizado.nombre}</td>
        <td>${productoActualizado.descripcion}</td>
        <td>${productoActualizado.precio}</td>
        <td>${productoActualizado.id_categoria}</td>
        <td>
            <button class="btn btn-primary btn-sm" onclick="habilitarEdicionProducto(${productoActualizado.id})">Editar</button>
            <button class="btn btn-danger btn-sm" onclick="eliminarElemento('producto', ${productoActualizado.id})">Eliminar</button>
        </td>
    `;
}

//FUNCION CARGAR USUARIOS COMO PRIMERA PAGINA
document.addEventListener('DOMContentLoaded', function() {
    showSection('productos'); // Mostrar la sección de usuarios por defecto
});