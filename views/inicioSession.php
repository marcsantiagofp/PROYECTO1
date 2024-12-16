<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio Sesión</title>
  <!-- Enlace a Bootstrap desde CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Enlace a Font Awesome para los iconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- CSS -->
  <link rel="stylesheet" href="/PROYECTO1/css/styles.css">
</head>
<body class="bg-light">

  <!-- Header con el logo y el enlace "Volver atrás" -->
  <header class="bg-white py-3 fixed-top w-100 headerSession">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Botón para volver atrás con el icono -->
      <a href="?controller=producto&action=home" class="btn btn-link text-dark text-decoration-none">
        <i class="fas fa-home"></i> Volver atrás
      </a>
      <!-- Logo de Decathlon centrado -->
      <a href="?controller=producto&action=home" class="mx-auto">
        <img src="/PROYECTO1/images/logoPrincipal.svg" alt="Decathlon Logo" width="170">
      </a>
    </div>
  </header>

  <!-- Contenedor principal que usa la grid de Bootstrap -->
  <div class="container-fluid vh-100 d-flex p-0">
    <!-- Imagen en el lado izquierdo -->
    <div class="col-12 col-md-6 d-flex align-items-center justify-content-center p-0">
      <img src="/PROYECTO1/images/Repartidor-Puerta.webp" alt="Repartidor en la puerta" class="img-fluid">
    </div>

    <!-- Formulario en el lado derecho -->
    <div class="col-12 col-md-6 d-flex flex-column justify-content-center p-4">
      <!-- Sección de inicio de sesión -->
      <div id="inicioSesion" class="formulario">
        <div class="text-start mt-2">
          <h2 class="h3 mb-4">Bienvenido Decathloner!!</h2>

          <!-- Mensaje de error -->
          <?php
            if (isset($_SESSION['error'])):
              ?>
              <div class="alert alert-danger text-center">
                  <?php
                  // Comparar el valor exacto almacenado en la sesión
                  if ($_SESSION['error'] === 'El correo electrónico ya está registrado.') {
                      echo $_SESSION['error'];  // Muestra el mensaje de error
                  } elseif ($_SESSION['error'] === 'usuario_no_encontrado') {
                      echo 'Usuario no encontrado. Por favor, verifica tu correo.';
                  } elseif ($_SESSION['error'] === 'credenciales_invalidas') {
                      echo 'Contraseña incorrecta. Inténtalo nuevamente.';
                  }
                  unset($_SESSION['error']);  // Elimina el mensaje después de mostrarlo
                  ?>
              </div>
          <?php endif; ?>

          <form action="?controller=usuario&action=iniciarSesion" method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="introducirDatosFormulario w-100" placeholder="Introduce tu correo electrónico" required>
                <input type="password" name="contraseña" class="introducirDatosFormulario w-100" placeholder="Introduce tu contraseña" required>
                <button type="submit" class="botonIniciarSession">Iniciar sesión</button>
            </div>
        </form>

          <div class="mt-3" style="margin-top: 0;">
            <p style="margin-bottom: 0; font-weight: bold;">¿Aún no tienes Cuenta Decathloneats?</p>
            <a href="#" style="color: #000000; text-decoration: underline;" onclick="cambiarARegistrar()">Crear una cuenta</a>
          </div>
        </div>
      </div>

      <!-- Sección de registro -->
      <div id="registro" class="formulario" style="display: none;">
        <div class="text-start mt-2">
          <h2 class="h3 mb-4" style="margin-top: 100px;">Registrarse</h2>
          
          <!-- Mostrar mensaje de error si existe -->
          <?php
          if (isset($_SESSION['error'])):
          ?>
              <div class="alert alert-danger text-center">
                  <?php
                  if ($_SESSION['error'] === 'El correo electrónico ya está registrado.') {
                      echo $_SESSION['error'];  // Muestra el mensaje de error
                  }
                  unset($_SESSION['error']);  // Elimina el mensaje de error de la sesión después de mostrarlo
                  ?>
              </div>
          <?php endif; ?>
        
          <form action="?controller=usuario&action=registrar" method="POST">
            <div class="mb-3">
                <!-- Nombre -->
                <input type="text" name="nombre" class="introducirDatosFormulario w-100" placeholder="Introduce tu nombre" required>
                <!-- Email -->
                <input type="email" name="email" class="introducirDatosFormulario w-100" placeholder="Introduce tu correo electrónico" required>
                <!-- Contraseña -->
                <input type="password" name="contraseña" class="introducirDatosFormulario w-100" placeholder="Introduce tu contraseña" required>
                <!-- Dirección -->
                <input type="text" name="direccion" class="introducirDatosFormulario w-100" placeholder="Introduce tu dirección" required>
                <!-- Teléfono -->
                <input type="tel" name="telefono" class="introducirDatosFormulario w-100" placeholder="Introduce tu teléfono (opcional)" pattern="[0-9]{9}">
                <button type="submit" class="botonIniciarSession">Registrarse</button>
            </div>
          </form>
          <div class="mt-3" style="margin-top: 0;">
            <p style="margin-bottom: 0; font-weight: bold;">¿Ya tienes una Cuenta Decathloneats?</p>
            <a href="#" style="color: #000000; text-decoration: underline;" onclick="cambiarAIniciarSesion()">Iniciar sesión</a>
          </div>
        </div>
      </div>

      <!-- Ventajas Exclusivas para miembros Decathlon al final -->
      <div class="ventajas-titulo" style="font-weight: bold; margin-top: 20px;">
        <p>Ventajas exclusivas por ser miembro Decathloneats</p>
      </div>

      <ul class="list-unstyled">
        <li>✔ Devoluciones gratis durante 60 días</li>
        <li>✔ Acumula puntos y consigue cheques descuento</li>
        <li>✔ Accede a servicios exclusivos</li>
      </ul>

    </div>
  </div>

  <!-- Enlace a los scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Función para cambiar a la vista de registro
    function cambiarARegistrar() {
      document.getElementById('inicioSesion').style.display = 'none'; // Oculta la vista de inicio de sesión
      document.getElementById('registro').style.display = 'block'; // Muestra la vista de registro
    }

    // Función para cambiar a la vista de inicio de sesión
    function cambiarAIniciarSesion() {
      document.getElementById('registro').style.display = 'none'; // Oculta la vista de registro
      document.getElementById('inicioSesion').style.display = 'block'; // Muestra la vista de inicio de sesión
    }
  </script>
</body>
</html>