<?php
$ficheroProductos = "mysql/productos.json";
$productos = [];

if (file_exists($ficheroProductos)) {
    $contenidoJson = file_get_contents($ficheroProductos);
    $productos = json_decode($contenidoJson, true);
}

//Primero uso la función que sobreescribe el array de productos
$productos = devuelve_array_fecha($productos);

$usuario = isset($_SESSION["user_email"]) ? $_SESSION["user_email"] : "";

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

$productosPagina = !empty($categoriaId) ? $productosFiltrados : $productos; //Si no hay categoría usamos todos los productos
/*==========================================================================================================================================*/
//Ordenación por nombre o por fecha
/*UD 3.2.f
Creo la variable $orden para capturar el valor que viene por la URL y en caso de que no venga
le asigno null, luego uso un condicional para evaluar si el valor de la variable es "asc" o "desc" y 
en función de eso ordeno el array $productos usando la función usort() y una función anónima que compara 
los nombres de los productos en mayúsculas para evitar problemas de ordenación por mayúsculas y minúsculas.*/
$orden = isset($_GET["orden"]) ? $_GET["orden"] : null; //$orden = $_GET['orden'] ?? null;
if ($orden === "asc"):
    $productosPagina = ordenaPorNombreAsc($productosPagina);
elseif ($orden === 'desc'):
    $productosPagina = ordenaPorNombreDesc($productosPagina);
endif;

$sort_date = isset($_GET['sort_date']) ? $_GET['sort_date'] : null;
if ($sort_date == 1):
    $productosPagina = ordenaPorFechaAsc($productosPagina);
elseif ($sort_date == -1):
    $productosPagina = ordenaPorFechaDesc($productosPagina);
endif;

/*==========================================================================================================================================*/
//Paginación
$elemPagina = 4; //Es la cantidad de elementos que queremos mostrar por página.

//Obtenemos la página actual con $_GET, si no viene por la URL, asumimos que es la página 1.
$paginaActual = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;

$inicio = ($paginaActual - 1) * $elemPagina; //Calcular el índice de inicio según la página
/*==========================================================================================================================================
$inicio es el índice del primer elemento de nuestro array ($productos) para la página actual. Se calcula así:
Se resta 1 a $paginaActual porque los índices del array empiezan en 0.
Ejemplo:
Página 3 → (3 - 1) * 4 = 8 → empieza desde el elemento 8 hasta el 11.
==========================================================================================================================================*/

$totalProductos = count($productosPagina); //Guardar total de productos

$productosPagina = array_slice($productosPagina, $inicio, $elemPagina); //Aplicar paginación
/*==========================================================================================================================================
array_slice($productosFiltrados, $inicio, $elemPagina) crea un nuevo array llamado $productosPagina, 
que contiene solo los elementos de la página actual. Luego podemos recorrer $productosPagina con un foreach para mostrar los productos.
==========================================================================================================================================*/

$haySiguiente = $inicio + $elemPagina < $totalProductos; //Verificar si hay más productos para la siguiente página
/*==========================================================================================================================================
El código sirve para calcular si hay más productos disponibles para mostrar en una página siguiente.
Ejemplo:
Si estás en página 2 ($inicio=4) y ($elemPagina=4) --> 4 + 4 = 8
Si count($productos) = 10 --> 8 < 10 --> sí hay siguiente página.
Si estás en página 3 --> 8 + 4 = 12 → 12 < 10 --> falso, no hay siguiente página.
==========================================================================================================================================*/

$totalPaginas = ceil($totalProductos / $elemPagina); //Ceil redondea a entero la operación para saber cuántas páginas hay

/*==========================================================================================================================================*/
//Borrado de productos
//UD 3.3.h Borrar el último elemento del array, ademas de un pequeño añadido que crea un mensaje de éxito al borrar producto
if (isset($_GET["delete"]) && $_GET["delete"] === "true"): //Si existe delete y si ésta es igual a "true" borramos 
    //No borro del JSON solo del array que muestro, luego con base de datos si borrare de la base de datos
    array_pop($productosPagina);

    echo '
        <div class="position-fixed end-0 p-3" style="z-index: 11; top: 60px;">
        <div id="toastBorrar" class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
            <div class="toast-body">
                Producto borrado correctamente
            </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        </div>
            <script>
                //Ocultar el toast despues de 3 segundos
                var toastEl = document.getElementById("toastBorrar");
                setTimeout(() => { toastEl.classList.remove("show"); }, 3000);
            </script>';
endif;

//echo var_dump($productosPagina); //Sirve para imprimir el array y comprobar que en efecto a borrado el último producto del array, 
//ya que al no haber persistencia de datos cada vez que se accede a datos.php se reconstruye el array de productos

?>

<div class="container mb-5">
    <div class="row">
        <div class="col-12 d-flex justify-content-center my-3 gap-2">
            <a href="/?categoria=<?= $categoriaId ?>&orden=asc"
                <?php //Cambiar la clase del botón según el orden seleccionado 
                ?>
                class="btn <?= ($orden == 'asc') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Ordenar A-Z
            </a>
            <a href="/?categoria=<?= $categoriaId ?>&orden=desc"
                <?php //Cambiar la clase del botón según el orden seleccionado 
                ?>
                class="btn <?= ($orden == 'desc') ? 'btn-primary' : 'btn-outline-secondary'; ?>">
                Ordenar Z-A
            </a>
            <?php
            //UD 3.3.h
            //Botón que borra el último de los elementos del array de productos usando array_pop,
            //Más adelante pondré esta funcionalidad en la pantalla de producto, para borrar un producto seleccionado 
            //por id y no el último. 
            ?>
            <a href="/?delete=true&pagina=<?= $paginaActual ?>&orden=<?= $orden ?>&sort_date=<?= $sort_date ?>"
                class="btn btn-danger" <?= (!empty($categoriaId)) ? 'hidden' : ""; ?>>
                Borrar último producto
            </a>
        </div>
    </div>
    <div class="row">
        <?php
        /* UD 3.5c
        Botones que me sirven para ordenaro por fecha asc o desc.
        */ ?>
        <div class="col-12 d-flex justify-content-center my-3 gap-2">
            <a href="/?categoria=<?= $categoriaId ?>&sort_date=1"
                class="btn <?= ($sort_date == 1) ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Fecha ↑
            </a>
            <a href="/?categoria=<?= $categoriaId ?>&sort_date=-1"
                class="btn <?= ($sort_date == -1) ? 'btn-primary' : 'btn-outline-secondary'; ?>">
                Fecha ↓
            </a>
            <a href="/?page=crear_editar"
                class="btn btn-success" <?= (!empty($categoriaId)) ? 'hidden' : ""; ?>>
                Crear producto
            </a>
        </div>
    </div>
</div>

<div class="container mb-5">
    
    <?php if (!empty($categoriaId) && array_key_exists($categoriaId, $categorias)) : ?>
        <h1 class="text-center"><?= $categorias[$categoriaId] ?></h1>
    <?php endif ; ?>

    <div class="row">
        <?php foreach ($productosPagina as $producto): ?>
            <div class="col-sm-3">
                <?php
                /*UD 3.3.d 
                Completar el atributo href del elemento <a con una URL que apunte a la ficha del producto para después
                recuperar el id del producto y mostrarlo en una card en producto.php.
                */
                ?>
                <a href="<?= (!$usuario) ? "/?page=producto&id=" . $producto["id"] : "/?page=crear_editar&productoId=" . $producto["id"] ; ?>" class="p-5">
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
                            /*UD 3.3.c y UD 3.4.a
                            Dentro del bucle en el que imprimo los productos, hago un segundo bucle
                            para recorrer el array de IDs de categorías de cada producto.
                            Por cada ID, compruebo si existe en el array $categorias usando array_key_exists.
                            Si existe, añado el nombre de la categoría al array $nombresCategorias.
                            Al final, con implode() uno todas las categorías separadas por comas
                            y las muestro dentro de la etiqueta <p> .*/

                            //Mostrar categorías
                            $nombresCategorias = [];
                            foreach ($producto['categorias'] as $categoriaClave) {
                                if (array_key_exists($categoriaClave, $categorias)) {
                                    $nombresCategorias[] = $categorias[$categoriaClave];
                                }
                            }
                            ?>
                            <p class="card-text"><?= implode(", ", $nombresCategorias) ?></p>
                            <!-- Uso la funcion date para imprimir corectamente el timestamp que me da la funcion -->
                            <p class="card-text"><strong>Fecha:</strong> <?= date('d/m/Y', $producto['fecha']) ?></p>
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
            Botón “Anterior”: solo se muestra si $paginaActual > 1. Si estamos en la primera página el botón se oculta.
            Al generar el enlace pasamos todos los parametros para que aunque cambiemos de página, se mantenga el 
            criterio de orden actual (asc o desc), (fecha asc desc) categoria, y página y no se pierda al navegar entre páginas.
            ==========================================================================================================================================*/
            ?>
            <?php if ($paginaActual > 1): ?>
                <a href="?pagina=<?= $paginaActual - 1 ?>&orden=<?= $orden ?>&categoria=<?= $categoriaId ?>&sort_date=<?= $sort_date ?>"
                    class="btn btn-secondary">← Anterior</a> <?php else: ?>
                <button class="btn btn-secondary" hidden>No hay más</button>
            <?php endif; ?>
        </div>

        <!-- Texto central con página actual -->
        <div class="col text-center">
            Página <?= $paginaActual ?> de <?= $totalPaginas ?>
        </div>

        <div class="col text-end">
            <?php
            /*==========================================================================================================================================
            Botón “Siguiente”: solo se muestra si $haySiguiente es true. Si no hay más elementos, el botón se oculta
            Al generar el enlace pasamos todos los parametros para que aunque cambiemos de página, se mantenga el 
            criterio de orden actual (asc o desc), (fecha asc desc) categoria, y página y no se pierda al navegar entre páginas.
            ==========================================================================================================================================*/
            ?>
            <?php if ($haySiguiente): ?>
                <a href="?pagina=<?= $paginaActual + 1 ?>&orden=<?= $orden ?>&categoria=<?= $categoriaId ?>&sort_date=<?= $sort_date ?>"
                    class="btn btn-secondary">Siguiente →</a> <?php else: ?>
                <button class="btn btn-secondary" hidden>No hay más</button>
            <?php endif; ?>
        </div>
    </div>
</div>