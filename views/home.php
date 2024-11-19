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
            <button type="button" class="etiquetaOferta">Ver ofertas</button>
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
        
        <div class="col-6 col-md-3 col-lg">
            <a href="URL_TERNERA" class="nombre-categorias">
                <img src="/PROYECTO1/images/PRODUCTOS/Ternara.svg" class="img-fluid">
                <p>Ternera</p>
            </a>
        </div>
        <div class="col-6 col-md-3 col-lg">
            <a href="URL_VEGETAL" class="nombre-categorias">
                <img src="/PROYECTO1/images/PRODUCTOS/Vegetal.svg" class="img-fluid">
                <p>Vegetal</p>
            </a>
        </div>
        <div class="col-6 col-md-3 col-lg">
            <a href="URL_BEBIDAS" class="nombre-categorias">
                <img src="/PROYECTO1/images/PRODUCTOS/AquariusLimon.svg" class="img-fluid">
                <p>Bebidas</p>
            </a>
        </div>
        <div class="col-6 col-md-3 col-lg">
            <a href="URL_SALSAS" class="nombre-categorias">
                <img src="/PROYECTO1/images/PRODUCTOS/SalsaBarbacoa.svg" class="img-fluid">
                <p>Salsas</p>
            </a>
        </div>
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
            <div class="row mb-4">
                <a href="URL_COCACOLA" class="col-6 position-relative quintaSeccion d-block">
                    <img src="/PROYECTO1/images/PRODUCTOS/COCACOLA.svg" alt="Coca Cola" class="img-fluid">
                    <p class="etiquetaPrecioBebidas">2,99€</p>
                    <p class="nombreBebidas">COCA COLA</p>
                </a>
                <a href="URL_FANTA" class="col-6 position-relative quintaSeccion d-block">
                    <img src="/PROYECTO1/images/PRODUCTOS/FANTA.svg" alt="Fanta" class="img-fluid">
                    <p class="etiquetaPrecioBebidas">2,99€</p>
                    <p class="nombreBebidas">FANTA</p>
                </a>
            </div>
            <div class="row">
                <a href="URL_MONSTER" class="col-6 position-relative quintaSeccion d-block">
                    <img src="/PROYECTO1/images/PRODUCTOS/MONSTER.svg" alt="Monster" class="img-fluid">
                    <p class="etiquetaPrecioBebidas">3,50€</p>
                    <p class="nombreBebidas">MONSTER</p>
                </a>
                <a href="URL_FUSETEA" class="col-6 position-relative quintaSeccion d-block">
                    <img src="/PROYECTO1/images/PRODUCTOS/FUSETEA.svg" alt="Fuze Tea" class="img-fluid">
                    <p class="etiquetaPrecioBebidas">2,99€</p>
                    <p class="nombreBebidas">FUZE TEA</p>
                </a>
            </div>
        </div>

        <!-- Columna de imagen grande a la derecha -->
        <div class="col-6 d-flex align-items-center">
            <div class="col-12 position-relative quintaSeccion">
                <img src="/PROYECTO1/images/SECCION5HOME.svg" width="62%" class="img-fluid">
                <a href="URL_VER_PRODUCTOS" class="etiquetaComprarBebidas">Ver Productos</a>
            </div>
        </div>             
    </div>
</div>
</main>

</body>
</html>