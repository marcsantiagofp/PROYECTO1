<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icnoo -->
    <link rel="icon" type="image/x-icon" href="/PROYECTO1/images/d.svg">
</head>
<body>
    <?php if (!($view === 'views/carrito.php' || $view === 'views/inicioSession.php' || $view === 'views/datosUsuario.php' || $view === 'views/panelAdmin.php')): ?>
        <!-- Header -->
        <?php include_once 'header.php'; ?>
    <?php endif; ?>

    <!-- Vista -->
    <?php include_once $view; ?>

    <?php if (!($view === 'views/carrito.php' || $view === 'views/inicioSession.php' || $view === 'views/datosUsuario.php' || $view === 'views/panelAdmin.php')): ?>
        <!-- Footer -->
        <?php include_once 'footer.php'; ?>
    <?php endif; ?>

    <!-- SRIPT BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>