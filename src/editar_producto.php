<?php include_once("templates/header.php"); ?>
<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>

<?php
//Para mantener valores si hay POST
$clave = isset($_POST["clave"]) ? $_POST["clave"] : "";
$titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "";
$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
$imagenExistente = isset($pathImagen) ? $pathImagen : ""; //Puedes definir $pathImagen si ya existe
?>

<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <!-- Clave -->
            <div class="col-sm-6 p-0 mb-3">
                <label for="claveID" class="form-label">Clave</label>
                <input type="text" name="clave" id="claveID" class="form-control" placeholder="Ingrese código"
                    value="<?= htmlspecialchars($clave) ?>" required>
            </div>

            <!-- Título -->
            <div class="col-sm-6 p-0 mb-3">
                <label for="tituloID" class="form-label">Título</label>
                <input type="text" name="titulo" id="tituloID" class="form-control" placeholder="Ingrese título"
                    value="<?= htmlspecialchars($titulo) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <!-- Fecha -->
            <div class="col-sm-6 p-0 mb-3">
                <label for="fechaID" class="form-label">Fecha (DD/MM/YYYY)</label>
                <input type="text" name="fecha" id="fechaID" class="form-control" placeholder="DD/MM/YYYY"
                    value="<?= htmlspecialchars($fecha) ?>" required>
            </div>

            <!-- Imagen existente -->
            <?php if (!empty($imagenExistente)) : ?>
            <div class="col-sm-6 p-0 mb-3">
                <label class="form-label">Imagen actual:</label>
                <p><?= basename($imagenExistente) ?></p>
            </div>
            <?php endif; ?>
        </div>

        <div class="row mb-3">
            <!-- Descripción -->
            <div class="col-12 p-0 mb-3">
                <label for="descripcionID" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcionID" rows="4" class="form-control"
                    placeholder="Escriba la descripción" required><?= htmlspecialchars($descripcion) ?></textarea>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Subida de imagen -->
            <div class="col-12 p-0 mb-3">
                <label for="imagenID" class="form-label">Subir imagen</label>
                <input type="file" name="imagen" id="imagenID" class="form-control" accept="image/*">
                <small class="text-muted">Puede subir una nueva imagen o reemplazar la existente.</small>
            </div>
        </div>

        <!-- Botón enviar -->
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>

<?php include("templates/footer.php"); ?>
