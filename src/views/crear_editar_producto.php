<?php include_once(__DIR__ . "/../datos.php"); ?>
<?php include_once(__DIR__ . "/../utils/utiles.php"); ?>
<?php

//Si me llega un id estoy editando.
$productoId = isset($_GET["productoId"]) ? (int)$_GET["productoId"] : null;

//Busco el producto
$encontrado = false;
$productoExistente = null;
foreach ($productos as $producto) {
    if ($producto["id"] == $productoId) {
        $encontrado = true;
        $productoExistente = $producto;
        break;
    }
}

//Para coger los valor si se llega con un id de producto
$clave =  isset($productoExistente["clave"]) ? $productoExistente["clave"] : "";
$titulo = isset($productoExistente["nombre"]) ? $productoExistente["nombre"] : "";
$fecha = isset($productoExistente["fecha"]) ? $productoExistente["fecha"] : "";
$descripcion = isset($productoExistente["descripcion"]) ? $productoExistente["descripcion"] : "";
$imagen = isset($productoExistente["imagen"]) && $productoExistente["imagen"] != "" ? $productoExistente["imagen"] : "El producto no tiene imagen.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Si se hace POST se sustituye los valores por los del POST
    $clave = isset($_POST["clave"]) ? $_POST["clave"] : "";
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
    $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
    $fichero = isset($_FILES["imagen"]) ? $_FILES["imagen"] : ""; //Los ficheros se envian por $_FILES

    //Validar el formato
    $claveErr = validar_clave($productos, $productoId);
    $tituloErr = validar_titulo();
    $fechaErr = validar_fecha();
    $descErr = validar_descripcion();
    $imgErr = validar_imagen();

    //Gestionar subida de la imagen
    if (!empty($fichero)) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaDestino = "static/images/{$nombreArchivo}";
        //Borrar la imagen si la existente es diferete a la imagen nueva
        if ($fichero != $rutaDestino && !$encontrado) {
            unlink($imagen);
        }
        //Mover el archivo subido a la carpeta destino
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $imagen = $rutaDestino; //Guardo la ruta en la variable
        }
    }

    //Si no hay errores decodifico el json
    if ($claveErr === "" && $tituloErr === "" && $fechaErr === "" && $descErr === "" && $imgErr === "") {
        $ficheroProductos = "mysql/productos.json";

        //Leer productos existentes
        if (file_exists($ficheroProductos)) {
            $productos = json_decode(file_get_contents($ficheroProductos), true);
        }

        if ($encontrado) {
            //Solo modifico los campos permitidos
            $productoNuevo = [
                "id" => $productoExistente["id"],
                "clave" => $clave,
                "nombre" => $titulo,
                "descripcion" => $descripcion,
                "imagen" => $imagen,
                "precio" => $productoExistente["precio"],
                "fecha" =>  $fecha,
                "categorias" => $productoExistente["categorias"],
            ];
            //Reemplazar el producto existente en el array
            foreach ($productos as $i => $p) {
                if ($p["id"] == $productoExistente["id"]) {
                    $productos[$i] = $productoNuevo;
                    break;
                }
            }
        } else {
            $nuevoId = count($productos) + 1;
            $productoNuevo = [
                "id" => $nuevoId,
                "clave" => $clave,
                "nombre" => $titulo,
                "descripcion" => $descripcion,
                "imagen" => $imagen,
                "precio" => 0,
                "fecha" => $fecha,
                "categorias" => [6],
            ];
            //Añadir nuevo producto al array
            $productos[] = $productoNuevo;
            $productoId = $nuevoId;
        }

        //Guardar JSON actualizado
        file_put_contents($ficheroProductos, json_encode($productos, JSON_PRETTY_PRINT));

        echo '
            <script type="text/javascript">
                window.location.href = "/?page=confirmar_producto&id=' . $productoId . '";
            </script> ';
        exit;
    }
}

?>

<div class="container my-5">
    <h3 class="text-center mb-4"> <?= ($productoId) ? "Editar producto" : "Crear producto"; ?> </h3>
    <!-- Enviar el id en el action para que no se pierda al hacer post -->
    <form action="?page=crear_editar&productoId=<?= $productoId ?>" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 800px;">

        <!-- Fila 1: Clave, Título y Fecha -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label for="claveID" class="form-label">Clave</label>
                <input type="text" name="clave" id="claveID" class="form-control" placeholder="Código"
                    value="<?= htmlspecialchars($clave) ?>">
                <span class="text-danger"> <?= $claveErr ?> </span>
            </div>
            <div class="col-md-5">
                <label for="tituloID" class="form-label">Título</label>
                <input type="text" name="titulo" id="tituloID" class="form-control" placeholder="Título"
                    value="<?= htmlspecialchars($titulo) ?>">
                <span class="text-danger"> <?= $tituloErr ?> </span>

            </div>
            <div class="col-md-4">
                <label for="fechaID" class="form-label">Fecha (DD/MM/YYYY)</label>
                <input type="text" name="fecha" id="fechaID" class="form-control" placeholder="DD/MM/YYYY"
                    value="<?= htmlspecialchars($fecha) ?>">
                <span class="text-danger"> <?= $fechaErr ?> </span>

            </div>
        </div>

        <!-- Fila 2: Descripción -->
        <div class="row g-3 mb-3">
            <div class="col-12">
                <label for="descripcionID" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcionID" rows="5" class="form-control"
                    placeholder="Escriba la descripción"><?= htmlspecialchars($descripcion) ?></textarea>
                <span class="text-danger"> <?= $descErr ?> </span>

            </div>
        </div>

        <!-- Fila 3: Imagen existente + Subir imagen -->
        <div class="row g-3 mb-3 align-items-center">
            <div class="col-md-6">
                <label class="form-label">Imagen actual:</label>
                <?php if (!empty($productoExistente["imagen"])): ?>
                    <div class="border rounded p-2 bg-light text-truncate">
                        <?= htmlspecialchars(basename($productoExistente["imagen"])) //basename solo coge el nombre del fichero
                        ?>
                    </div>
                <?php else: ?>
                    <div class="border rounded p-2 bg-light text-muted text-center">
                        No hay imagen.
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label for="imagenID" class="form-label">Subir nueva imagen</label>
                <input type="file" name="imagen" id="imagenID" class="form-control" accept="image/*">
                <span class="text-danger"> <?= $imgErr ?> </span>
            </div>
        </div>
</div>

<!-- Fila 4: Botón enviar -->
<div class="row mt-1">
    <div class="col d-flex justify-content-center">
        <button type="submit" class="btn btn-success px-5">Enviar</button>
    </div>
</div>

</form>
</div>