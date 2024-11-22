<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    
<main class="container">
<!-- SECCION 1 -->
<div class="container px-6 text-center">
    <div class="col">
        <div class="primeraSeccion">
            <img src="/PROYECTO1/images/SECCION1HOME.svg" class="img-fluid imagenPrimeraSeccion"> 
            <a href="?controller=producto&action=ofertas"><button type="button" class="etiquetaOferta">Ver ofertas</button></a>
        </div>
    </div>
<!-- SECCION 2 -->
<h2 style="margin-top: 30px; margin-bottom: 20px;">Productos recomendados</h2>
<div class="row gx-2">
    <?php include_once 'assets/cardRecomendado.php' ?>
</div>

<!-- SECCION 3 -->
<div class="container text-center">
    <h2 style="margin-top: 30px; margin-bottom: 20px;">Categorías Favoritas</h2>
    <div class="row align-items-center">
        <?php include_once 'assets/cardSeccionCategorias.php' ?>
    </div>
</div>           
<!-- SECCION 4 -->
<div class="col">
    <div class="quartaSeccion">
        <div class="etiquetaRecomendamos">Te Recomendamos</div>
        <img src="/PROYECTO1/images/SECCION4HOME.svg" class="img-fluid imagenQuartaSeccion"> 
        <button type="button" class="etiquetaComprar">Comprar</button>
    </div>
</div>

<!-- SECCIION 5 -->
<div class="container text-center">
    <div class="row me-12">
        <!-- Columna de bebidas con margen a la derecha -->
        <div class="col-6">
            <?php include_once 'assets/cardBebidas.php' ?>
        </div>

        <!-- Columna de imagen grande a la derecha -->
        <div class="col-6 d-flex align-items-center">
            <div class="col-12 position-relative quintaSeccion">
                <img src="/PROYECTO1/images/SECCION5HOME.svg" width="62%" class="img-fluid">
                <a href="?controller=producto&action=bebidas" class="etiquetaComprarBebidas">Ver Productos</a>
            </div>
        </div>             
    </div>
</div>
</main>

</body>
</html>