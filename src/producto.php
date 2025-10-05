<?php include("templates/header.php"); ?>
<?php include("datos.php"); ?>

<?php $idProducto = isset($_GET['id']) ? $_GET['id'] : null; ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <!-- //Buscar el producto que coincide con el id -->
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

                        <p class="card-text"><strong>Fecha:</strong> <?= $producto['fecha'] ?></p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>


<?php include("templates/footer.php"); ?>