<!DOCTYPE html>
<html lang="en">
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
  <!-- icnoo -->
  <link rel="icon" type="image/x-icon" href="/PROYECTO1/images/d.svg">
</head>
<body class="bg-light">
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

    <div class="container py-5">
        <div class="card mx-auto rounded-0" style="max-width: 500px;">
            <div class="card-header text-center">
                <h2>Datos del Usuario</h2>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> <?php echo $usuario->getNombre(); ?></p>
                <p><strong>Teléfono:</strong> <?php echo $usuario->getTelefono(); ?></p>
                <p><strong>Dirección:</strong> <?php echo $usuario->getDireccion(); ?></p>
                <p><strong>Correo:</strong> <?php echo $usuario->getEmail(); ?></p>
                <a href="?controller=usuario&action=cerrarSesion" class="botonCerrarSession w-100">Cerrar Sesión</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>