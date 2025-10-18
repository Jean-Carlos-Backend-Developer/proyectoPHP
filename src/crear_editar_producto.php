<?php include_once("templates/header.php"); ?>
<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>

<?php

$productoId = isset($_GET["productoId"]) ? $_GET["productoId"] : "";
$productoObj = null;

foreach ($productos as $producto) {
    if ($producto["id"] == $productoId) {
        $productoObj = $producto;
        break;
    }
}


//Para mantener valores si hay POST
$clave = isset($_POST["clave"]) ? $_POST["clave"] : (isset($productoObj["id"]) ? $productoObj["id"] : "") ;
$titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : (isset($productoObj["nombre"]) ? $productoObj["nombre"] : "");
$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : (isset($productoObj["fecha"]) ? $productoObj["fecha"] : "");
$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : (isset($productoObj["descripcion"]) ? $productoObj["descripcion"] : "");
//$imagen = isset($_POST["imagen"]) ? $_POST["imagen"] : (isset($productoObj["imagen"]) ? $productoObj["imagen"] : "imagen no existe");
$imagen = isset($productoObj["imagen"]) && $productoObj["imagen"] != "" ? $productoObj["imagen"] : "El producto no tiene imagen.";

?>

<div class="container my-4">
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">

        <!-- Fila 1: Clave, Título y Fecha -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label for="claveID" class="form-label">Clave</label>
                <input type="text" name="clave" id="claveID" class="form-control" placeholder="Código"
                    value="<?= htmlspecialchars($clave) ?>" required>
            </div>
            <div class="col-md-5">
                <label for="tituloID" class="form-label">Título</label>
                <input type="text" name="titulo" id="tituloID" class="form-control" placeholder="Título"
                    value="<?= htmlspecialchars($titulo) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="fechaID" class="form-label">Fecha (DD/MM/YYYY)</label>
                <input type="text" name="fecha" id="fechaID" class="form-control" placeholder="DD/MM/YYYY"
                    value="<?= htmlspecialchars($fecha) ?>" required>
            </div>
        </div>

        <!-- Fila 2: Descripción -->
        <div class="row g-3 mb-3">
            <div class="col-12">
                <label for="descripcionID" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcionID" rows="5" class="form-control"
                    placeholder="Escriba la descripción" required><?= htmlspecialchars($descripcion) ?></textarea>
            </div>
        </div>

        <!-- Fila 3: Imagen existente + Subir imagen -->
        <div class="row g-3 mb-3 align-items-center">
            <div class="col-md-6">
                <?php if (!empty($productoObj["imagen"])): ?>
                    <label class="form-label">Imagen actual:</label>
                    <div class="border rounded p-2 bg-light">
                        <?= htmlspecialchars(basename($productoObj["imagen"])) ?>
                    </div>
                <?php else: ?>
                    <label class="form-label">Imagen actual:</label>
                    <div class="border rounded p-2 bg-light text-muted text-center">
                        No hay imagen.
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label for="imagenID" class="form-label">Subir nueva imagen</label>
                <input type="file" name="imagen" id="imagenID" class="form-control" accept="image/*">
            </div>
        </div>

        <!-- Fila 4: Botón enviar -->
        <div class="row mt-4">
            <div class="col-auto">
                <button type="submit" class="btn btn-success px-4">Enviar</button>
            </div>
        </div>

    </form>
</div>

<?php include("templates/footer.php"); ?>