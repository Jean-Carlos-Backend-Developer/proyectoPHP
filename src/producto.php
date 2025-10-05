<?php include_once("templates/header.php"); ?>
<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>

<?php
//Primero uso la función que sobreescribe el array de productos
$productos = devuelve_array_fecha($productos);

$idProducto = isset($_GET['id']) ? $_GET['id'] : null; //Compruebo que me llega el id del producto por la URL
?>
<div class="container mb-5">
    <div class="row justify-content-center">
        <!-- //Buscar el producto que coincide con el id -->
        <?php var_dump($productos) ?>
        <?php foreach ($productos as $producto): ?>
            <?php if ($producto['id'] == $idProducto): ?>
                <div class="card" style="width: 18rem;">
                    <?php
                    //Imagen del producto o imagen por defecto
                    $imagen = file_exists($producto['imagen']) ? $producto['imagen'] : "static/images/noImage.jpg";
                    ?>
                    <img src="<?= $imagen ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                        <p class="card-text"><?= number_format($producto['precio'], 2, ',', '.') ?> €</p>
                        <p class="card-text"><?= nl2br($producto['descripcion']) ?></p>
                        <?php
                        //Mostrar categorías
                        $nombresCategorias = [];
                        foreach ($producto['categorias'] as $categoriaClave) {
                            if (array_key_exists($categoriaClave, $categorias)) {
                                $nombresCategorias[] = $categorias[$categoriaClave];
                            }
                        }
                        ?>
                        <p class="card-text"><strong>Categorías:</strong> <?= implode(", ", $nombresCategorias) ?></p>

                        <!-- Uso la funcion date para imprimir corectamente el timestamp que me da la funcion -->
                        <p class="card-text"><strong>Fecha:</strong> <?= date('d/m/Y', $producto['fecha']) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Botón borrar producto PROXIMAMENTE OPERATIVO -->
        <div class="col text-center">
            <?php
            /*==========================================================================================================================================
            Botón “Siguiente”: solo se muestra si $haySiguiente es true. Si no hay más elementos, el botón aparece deshabilitado.
            IMPORTANTE: al generar el enlace usamos también &orden=$orden. 
            Esto garantiza que, aunque cambiemos de página, se mantenga el criterio de orden actual (asc o desc) 
            y no se pierda al navegar entre páginas.
            ==========================================================================================================================================*/
            ?>
            <?php if ($haySiguiente): ?>
                <a href="?pagina=<?= $paginaActual + 1 ?>&orden=<?= $orden ?>&categoria=<?= $categoriaId ?>"
                    class="btn btn-secondary">Siguiente →</a> <?php else: ?>
                <button class="btn btn-secondary" disabled>No hay más</button>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php include("templates/footer.php"); ?>