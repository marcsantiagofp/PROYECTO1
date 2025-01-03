//FUNCIONES PARA VER LAS TABLAS
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
        }
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
                    <button class="btn btn-secondary btn-sm" onclick="fetchUsuarios()">Cancelar</button>
                </td>
            </tr>
        `;
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
        }
        
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
                    <button class="btn btn-secondary btn-sm" onclick="fetchProductos()">Cancelar</button>
                </td>
            </tr>
        `;
    }

    // Función para obtener y mostrar los pedidos
    async function fetchPedidos() {
        const response = await fetch('?controller=api&action=obtenerPedidos');
        const pedidos = await response.json();
        const tableBody = document.getElementById('section-table-body');
        const noDataMessage = document.getElementById('no-data-message');
        tableBody.innerHTML = ''; // Limpiar la tabla

        // Siempre mostrar el botón de agregar pedido al final
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
                            <button class="btn btn-primary btn-sm" onclick="mostrarFormularioModificarPedido(${pedido.id})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarElemento('pedido', ${pedido.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
        }

        // Siempre agregar el botón de "Agregar Pedido" al final de la tabla
        tableBody.innerHTML += `
            <tr id="nuevo-pedido">
                <td colspan="6" class="text-center">
                    <button class="btn btn-success btn-sm" onclick="mostrarFormularioProductos()">Agregar Pedido</button>
                </td>
            </tr>
        `;
    }

//FUNCION PARA ELEMINAR LOS ELEMETOS
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

//FUNCION PARA MOSTAR LAS CABECERAS CORRESPONDIENTES A CADA SECCION DEPENDE DONDE SE LE DE CLICK
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
    /////////////////////////////////////////////
    // Función para agregar un nuevo usuario
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
    ///////////////////////////////////////////////
    // Función para agregar un nuevo producto
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

    /////////////////////////////////
    //FUNCIONES PARA AGREGAR PEDIDOS
    // Mostrar el formulario de selección de productos
    async function mostrarFormularioProductos() {
        const noDataMessage = document.getElementById('no-data-message');
        if (noDataMessage) {
            noDataMessage.style.display = 'none'; // Ocultar el mensaje "No hay datos"
        }
    
        const response = await fetch('?controller=api&action=obtenerProductos');
        const productos = await response.json();
        const tableBody = document.getElementById('section-table-body');
    
        let productoRows = productos.map(producto => ` 
            <tr id="row-${producto.id}">
                <td>${producto.id}</td>
                <td>${producto.nombre}</td>
                <td>${producto.precio}</td>
                <td>
                    <input type="number" id="cantidad-${producto.id}" min="1" value="1" style="width: 60px;" />
                </td>
                <td>
                    <button class="btn btn-primary btn-sm" id="btn-seleccionar-${producto.id}" onclick="agregarProductoPedido(${producto.id}, '${producto.nombre}', ${producto.precio})">
                        Seleccionar
                    </button>
                    <button class="btn btn-secondary btn-sm" id="btn-cancelar-${producto.id}" onclick="cancelarProductoPedido(${producto.id})" style="display: none;">
                        Cancelar
                    </button>
                </td>
            </tr>
        `).join('');
    
        tableBody.innerHTML = `
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            ${productoRows}
            <tr>
                <td colspan="5" class="text-center">
                    <button class="btn btn-success btn-sm" onclick="confirmarPedido()">Confirmar Pedido</button>
                    <button class="btn btn-secondary btn-sm" onclick="fetchPedidos()">Cancelar</button>
                </td>
            </tr>
        `;
    }

    //variable para seleccionar los productos
    let productosSeleccionados = [];

    // Agregar producto al pedido y marcarlo como seleccionado //lo usaremos para los metodos de agregar y editar pedidos
    function agregarProductoPedido(id, nombre, precio) {
        const cantidadInput = document.getElementById(`cantidad-${id}`);
        const cantidad = parseInt(cantidadInput.value);
        const botonSeleccionar = document.getElementById(`btn-seleccionar-${id}`);
        const botonCancelar = document.getElementById(`btn-cancelar-${id}`);
    
        if (isNaN(cantidad) || cantidad <= 0) {
            alert("Por favor, ingrese una cantidad válida.");
            return;
        }
    
        // Verificar si el producto ya fue agregado
        if (productosSeleccionados.find(prod => prod.id === id)) {
            alert("Este producto ya ha sido agregado al pedido.");
            return;
        }
    
        // Agregar el producto a la lista de seleccionados
        productosSeleccionados.push({ id, nombre, precio, cantidad });
    
        // Actualizar visualmente
        botonSeleccionar.style.display = 'none';
        botonCancelar.style.display = 'inline-block';
        cantidadInput.disabled = true;
    }


    // Cancelar la selección de un producto //lo usaremos para los metodos de agregar y editar pedidos
    function cancelarProductoPedido(id) {
        const cantidadInput = document.getElementById(`cantidad-${id}`);
        const botonSeleccionar = document.getElementById(`btn-seleccionar-${id}`);
        const botonCancelar = document.getElementById(`btn-cancelar-${id}`);

        // Quitar el producto de la lista de seleccionados
        productosSeleccionados = productosSeleccionados.filter(prod => prod.id !== id);

        // Actualizar visualmente
        botonSeleccionar.style.display = 'inline-block';
        botonCancelar.style.display = 'none';
        cantidadInput.disabled = false;
        cantidadInput.value = 1; // Restablecer la cantidad a 1
    }

    // Obtener la fecha actual en formato correcto
    function obtenerFechaCorrecta() {
        const fecha = new Date();
        const año = fecha.getFullYear();
        const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // Mes entre 01 y 12
        const dia = String(fecha.getDate()).padStart(2, '0'); // Día entre 01 y 31
        const horas = String(fecha.getHours()).padStart(2, '0'); // Horas entre 00 y 23
        const minutos = String(fecha.getMinutes()).padStart(2, '0'); // Minutos entre 00 y 59
        const segundos = String(fecha.getSeconds()).padStart(2, '0'); // Segundos entre 00 y 59

        return `${año}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;
    }

    async function confirmarPedido() {
        if (productosSeleccionados.length === 0) {
            alert("No has seleccionado ningún producto.");
            return;
        }

        const clienteId = prompt("Ingrese el ID del cliente para este pedido:");
        if (!clienteId || isNaN(clienteId)) {
            alert("ID de cliente no válido.");
            return;
        }

        // Obtener la fecha actual con el formato adecuado para MySQL
        const fechaPedido = obtenerFechaCorrecta();  // Formato: '2024-12-31 20:58:10'
        
        const precioTotal = productosSeleccionados.reduce((sum, prod) => sum + prod.precio * prod.cantidad, 0);
        const cantidadTotal = productosSeleccionados.reduce((sum, prod) => sum + prod.cantidad, 0);

        // Verificar los productos seleccionados antes de enviar
        console.log("Productos seleccionados:", productosSeleccionados);
        
        const pedidoData = {
            fecha_pedido: fechaPedido,
            precio_total_pedidos: precioTotal,
            cantidad_productos: cantidadTotal,
            id_cliente: clienteId,
            productos: productosSeleccionados  // Incluir los productos seleccionados aquí
        };

        console.log("Datos del pedido:", pedidoData); // Verificar los datos antes de enviarlos

        // Crear el pedido
        const pedidoResponse = await fetch('?controller=api&action=agregarElemento&tipo=pedido', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(pedidoData)
        });

        const pedidoResult = await pedidoResponse.json();

        // Verificar si la creación del pedido fue exitosa
        if (!pedidoResult || !pedidoResult.success) {
            alert(`Error al crear el pedido: ${pedidoResult.error || "Datos incompletos para el pedido"}`);
            console.error("Respuesta del servidor:", pedidoResult); // Mostrar más detalles del error
            return;
        }

        const numeroPedido = pedidoResult.id_pedido; // ID del pedido creado
        console.log("Pedido creado con éxito. ID del pedido:", numeroPedido);

        // Insertar líneas de pedido
        for (const producto of productosSeleccionados) {
            const lineaData = {
                cantidad_productos: producto.cantidad,
                precio_productos: producto.precio * producto.cantidad, // Precio total por línea
                id_producto: producto.id,
                id_descuento: null, // Manejar descuentos si es necesario
                numero_pedido: numeroPedido
            };

            console.log("Datos de la línea de pedido:", lineaData); // Verificar los datos antes de enviarlos
        }

        // alert("Pedido creado con éxito.");
        productosSeleccionados = []; // Limpiar selección
        fetchPedidos(); // Recargar la tabla de pedidos
    }


//FUNCIONES PARA ACTUALIZAR/MODIFICAR 

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

    // función para actualizar un producto
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

    //FUNCIONES PARA MODIFICAR PEDIDOS

    //funcion para mostrar el formulario con los productos del pedido seleccionados
    async function mostrarFormularioModificarPedido(pedidoId) {
        const responsePedido = await fetch(`?controller=api&action=obtenerPedidoPorId&id=${pedidoId}`);
        if (!responsePedido.ok) {
            alert("Error al obtener los detalles del pedido.");
            return;
        }
        const pedido = await responsePedido.json();

        const responseProductos = await fetch('?controller=api&action=obtenerProductos');
        if (!responseProductos.ok) {
            alert("Error al obtener los productos.");
            return;
        }
        const productos = await responseProductos.json();

        // Inicializar productosSeleccionados con los productos del pedido
        productosSeleccionados = pedido.productos.map(prod => ({
            id: prod.id,
            nombre: prod.nombre,
            precio: parseFloat(Number(prod.precio).toFixed(2)) || 0.0,
            cantidad: prod.cantidad,
            delPedido: true, // Identificar productos del pedido original
            cancelado: false, // Por defecto no cancelados
        }));

        console.log("Productos seleccionados al cargar el pedido:", productosSeleccionados);

        const tableBody = document.getElementById('section-table-body');

        let productoRows = productos.map(producto => {
            const productoEnPedido = pedido.productos.find(prod => prod.id === producto.id);
            const productoSeleccionado = productoEnPedido ? 'inline-block' : 'none';
            const productoDesactivado = productoEnPedido ? 'disabled' : '';

            const cantidadSeleccionada = productoEnPedido ? productoEnPedido.cantidad : 1;

            return `
                <tr id="row-${producto.id}">
                    <td>${producto.id}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.precio}</td>
                    <td>
                        <input type="number" id="cantidad-${producto.id}" min="1" value="${cantidadSeleccionada}" style="width: 60px;" ${productoDesactivado} />
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" id="btn-seleccionar-${producto.id}" onclick="agregarProductoPedido(${producto.id}, '${producto.nombre}', ${producto.precio})" style="display:${productoEnPedido ? 'none' : 'inline-block'};">
                            Seleccionar
                        </button>
                        <button class="btn btn-secondary btn-sm" id="btn-cancelar-${producto.id}" onclick="cancelarProductoPedidoModificar(${producto.id})" style="display:${productoSeleccionado};">
                            Cancelar
                        </button>
                    </td>
                </tr>
            `;
        }).join('');

        tableBody.innerHTML = `
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            ${productoRows}
            <tr>
                <td colspan="5" class="text-center">
                    <button class="btn btn-success btn-sm" onclick="confirmarModificacionPedido(${pedidoId})">Confirmar Modificación</button>
                    <button class="btn btn-secondary btn-sm" onclick="fetchPedidos()">Cancelar</button>
                </td>
            </tr>
        `;
    }

    //funcion para modificar los pedidos del usuario guardando los productos ya seleccionados
    async function confirmarModificacionPedido(pedidoId) {
        // Obtener el pedido original
        const responsePedido = await fetch(`?controller=api&action=obtenerPedidoPorId&id=${pedidoId}`);
        if (!responsePedido.ok) {
            throw new Error("Error al obtener los detalles del pedido.");
        }
        const pedido = await responsePedido.json();

        // Procesar los productos seleccionados
        const productosFinales = productosSeleccionados.filter(prod => !prod.cancelado);

        console.log("Productos finales (después de gestionar cancelaciones):", productosFinales);

        // Calcular el precio total y la cantidad total
        let precioTotal = 0;
        let cantidadTotal = 0;

        productosFinales.forEach(prod => {
            precioTotal += prod.precio * prod.cantidad;
            cantidadTotal += prod.cantidad;
        });

        // Estructurar los datos del pedido
        const pedidoData = {
            id_pedido: pedidoId,
            precio_total_pedidos: parseFloat(precioTotal.toFixed(2)),
            cantidad_productos: cantidadTotal,
            productos: productosFinales.map(prod => ({
                id: prod.id,
                cantidad: prod.cantidad,
                precio: parseFloat(Number(prod.precio).toFixed(2)) || 0.0,
            })),
        };

        console.log("Datos del pedido a enviar al servidor:", pedidoData);

        // Realizar la petición al servidor
        const response = await fetch('?controller=api&action=actualizarElemento&tipo=pedido', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(pedidoData),
        });

        if (!response.ok) {
            throw new Error("Error al actualizar el pedido.");
        }

        console.log("Pedido actualizado correctamente.");

        // Recargar la lista de pedidos
        fetchPedidos();

        // Limpiar la selección de productos
        productosSeleccionados = [];
    }


    //funcion nueva de cancelar productos modifcados para la edicion de pedidos usando delPedido y cancelado para la eliminacion de estos
    function cancelarProductoPedidoModificar(id) {
        const producto = productosSeleccionados.find(prod => prod.id === id);

        if (producto) {
            if (producto.delPedido) {
                // Si el producto pertenece al pedido original, lo marcamos como cancelado
                producto.cancelado = true;
                console.log(`Producto con ID ${id} del pedido original marcado como cancelado.`);
            } else {
                // Si es un producto nuevo, lo eliminamos de la selección
                productosSeleccionados = productosSeleccionados.filter(prod => prod.id !== id);
                console.log(`Producto con ID ${id} eliminado de la selección.`);
            }
        } else {
            console.warn(`Producto con ID ${id} no encontrado en la lista de seleccionados.`);
        }

        // Actualizar visualmente
        const cantidadInput = document.getElementById(`cantidad-${id}`);
        const botonSeleccionar = document.getElementById(`btn-seleccionar-${id}`);
        const botonCancelar = document.getElementById(`btn-cancelar-${id}`);

        if (cantidadInput && botonSeleccionar && botonCancelar) {
            botonSeleccionar.style.display = 'inline-block';
            botonCancelar.style.display = 'none';
            cantidadInput.disabled = false;
            cantidadInput.value = 1; // Restablecer la cantidad a 1
        }
    }


//FUNCION CARGAR USUARIOS COMO PRIMERA PAGINA
document.addEventListener('DOMContentLoaded', function() {
    showSection('pedidos'); // Mostrar la sección de usuarios por defecto
});