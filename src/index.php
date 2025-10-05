<?php include("templates/header.php"); ?>
<?php include("datos.php"); ?>
<?php include("utiles.php"); ?>
<?php


/*==========================================================================================================================================*/
//Ordenación
/*UD 3.2.f
Creo la variable $orden para capturar el valor que viene por la URL y en caso de que no venga
le asigno null, luego uso un condicional para evaluar si el valor de la variable es "asc" o "desc" y 
en función de eso ordeno el array $productos usando la función usort() y una función anónima que compara 
los nombres de los productos en mayúsculas para evitar problemas de ordenación por mayúsculas y minúsculas.*/
$orden = isset($_GET["orden"]) ? $_GET["orden"] : null; //$orden = $_GET['orden'] ?? null;

if ($orden === "asc"):
    ordenaPorNombreAsc($productos);
elseif ($orden === 'desc'):
    ordenaPorNombreDesc($productos);
endif;

/*==========================================================================================================================================*/
//Filtro por categoria 
/*UD 3.3.f 
Filtro por categoría que primero lee el parámetro que le paso de categoría y que crea un nuevo array de productosFiltrados
que luego uso para imprimir los productos filtrados solo por categorias.*/
$categoriaId = isset($_GET["categoria"]) ? (int) $_GET["categoria"] : null;
$productosFiltrados = (array_filter($productos, function ($producto) use ($categoriaId) {
    //Comprueba si el id de la categoría está dentro del array de categorías del producto
    return in_array($categoriaId, $producto["categorias"]);
}));

/*==========================================================================================================================================*/
//Paginación
$elemPagina = 4; //Es la cantidad de elementos que queremos mostrar por página.

//Obtenemos la página actual con $_GET, si no viene por la URL, asumimos que es la página 1.
$paginaActual = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;

$inicio = ($paginaActual - 1) * $elemPagina;
/*==========================================================================================================================================
$inicio es el índice del primer elemento de nuestro array ($productos) para la página actual. Se calcula así:
$inicio = ($paginaActual - 1) * $elemPagina;
Se resta 1 a $paginaActual porque los índices del array empiezan en 0.
Ejemplo:
Página 1 → (1 - 1) * 4 = 0 → empieza desde el elemento 0 hasta el 3.
Página 3 → (3 - 1) * 4 = 8 → empieza desde el elemento 8 hasta el 11.
==========================================================================================================================================*/
if (!empty($categoriaId)) {
    $productosPagina = array_slice($productosFiltrados, $inicio, $elemPagina);
    /*==========================================================================================================================================
    array_slice($productosFiltrados, $inicio, $elemPagina) crea un nuevo array llamado $productosPagina, 
    que contiene solo los elementos de la página actual. Luego podemos recorrer $productosPagina con un foreach para mostrar los productos.
    ==========================================================================================================================================*/
    $totalProductos = count($productosFiltrados); //Saber el total de productos
    $haySiguiente = $inicio + $elemPagina < count($productosFiltrados); // Verificar si hay más productos para la siguiente página
    /*==========================================================================================================================================
    El código sirve para calcular si hay más productos disponibles para mostrar en una página siguiente.
    Ejemplo:
    Si estás en página 2 ($inicio=4) y ($elemPagina=4) --> 4 + 4 = 8
    Si count($productos) = 10 --> 8 < 10 --> sí hay siguiente página.
    Si estás en página 3 --> 8 + 4 = 12 → 12 < 10 --> falso, no hay siguiente página.
    ==========================================================================================================================================*/
} else {
    $productosPagina = array_slice($productos, $inicio, $elemPagina);
    $totalProductos = count($productos); //Saber el total de productos
    $haySiguiente = $inicio + $elemPagina < count($productos); // Verificar si hay más productos para la siguiente página
}

$totalPaginas = ceil($totalProductos / $elemPagina); //Ceil redondea a entero la operación para saber cuántas páginas hay

?>

<div class="container mb-5">
    <div class="row">
        <div class="col-12 d-flex justify-content-center my-3 gap-2">
            <a href="/?categoria=<?= $categoriaId ?>&orden=asc" <?php
              //Código mio adicional para cambiar la clase del botón según el orden seleccionado 
              //y que el botón activo se vea diferente al inactivo
              ?>
                class="btn <?= ($orden == 'asc') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Ordenar A-Z
            </a>
            <a href="/?categoria=<?= $categoriaId ?>&orden=desc" <?php
              //Código mio adicional para cambiar la clase del botón según el orden seleccionado 
              //y que el botón activo se vea diferente al inactivo
              ?>
                class="btn <?= ($orden == 'desc') ? 'btn-primary' : 'btn-outline-secondary'; ?>">
                Ordenar Z-A
            </a>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <?php foreach ($productosPagina as $producto): ?>
            <div class="col-sm-3">
                <?php
                /*UD 3.3.d 
                Completar el atributo href del elemento <a con una URL que apunte a la ficha del producto para después
                recuperar el id del producto y mostrarlo en una card en producto.php.
                */
                ?>
                <a href="producto.php?id=<?= $producto["id"] ?>" class="p-5">
                    <div class="card">
                        <?php
                        /*UD 3.2.d
                        Uso del operador ternario para evaluar si la imagen existe o no, en caso de que no exista
                        poner una por defecto*/
                        ?>
                        <img class="card-img-top"
                            src="<?= file_exists($producto['imagen']) ? $producto['imagen'] : "static/images/noImage.jpg" ?>"
                            alt="<?= $producto['nombre'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= number_format($producto['precio'], 2, ',', '.') . " €"; ?>
                            </h5>
                            <p class="card-text"><?= $producto['nombre']; ?></p>
                            <p class="card-text"><?= $producto['descripcion']; ?></p>
                            <?php
                            /*UD 3.3.c
                            Dentro del bucle en el que imprimo los productos, hago un segundo bucle
                            para recorrer el array de IDs de categorías de cada producto.
                            Por cada ID, compruebo si existe en el array $categorias usando array_key_exists.
                            Si existe, añado el nombre de la categoría al array $nombresCategorias.
                            Al final, con implode() uno todas las categorías separadas por comas
                            y las muestro dentro de la etiqueta <p> .*/
                            ?>
                            <p class="card-text">
                                <?php
                                $nombresCategorias = [];
                                foreach ($producto['categorias'] as $categoriaClave) {
                                    if (array_key_exists($categoriaClave, $categorias)) {
                                        $nombresCategorias[] = $categorias[$categoriaClave];
                                    }
                                }
                                echo implode(", ", $nombresCategorias);
                                ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <div class="col text-start">
            <?php
            /*==========================================================================================================================================
            Botón “Anterior”: solo se muestra si $paginaActual > 1. Si estamos en la primera página, muestra un botón de “Volver” que lleva a inicio.
            IMPORTANTE: al generar el enlace usamos también &orden=$orden. 
            Esto garantiza que, aunque cambiemos de página, se mantenga el criterio de orden actual (asc o desc) 
            y no se pierda al navegar entre páginas.
            ==========================================================================================================================================*/
            ?>
            <?php if ($paginaActual > 1): ?>
                <a href="?pagina=<?= $paginaActual - 1 ?>&orden=<?= $orden ?>&categoria=<?= $categoriaId ?>"
                    class="btn btn-secondary">← Anterior</a> <?php else: ?>
                <button class="btn btn-secondary" disabled>No hay más</button>
            <?php endif; ?>
        </div>

        <!-- Texto central con página actual -->
        <div class="col text-center">
            Página <?= $paginaActual ?> de <?= $totalPaginas ?>
        </div>

        <div class="col text-end">
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