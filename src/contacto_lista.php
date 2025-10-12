<?php include_once("templates/header.php"); ?>
<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>

<?php
$nameErr = validar_texto();
$emailErr = validar_email();
$telefErr = validar_telefono();
$tipoErr = validar_tipo();

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : ""; //Para que guarde el tipo si falla al enviar algo por post

if (!empty($_POST["mensaje"])) {
    $mensaje = test_input($_POST["mensaje"]);
}

if (!empty($_FILES['archivo'])) {
    $nombreArchivo = $_FILES['archivo']['name'];
    move_uploaded_file($_FILES['archivo']['tmp_name'], "/var/www/html/uploads/{$nombreArchivo}");
    if ($nombreArchivo){
        $pathArchivo = "uploads/{$nombreArchivo}";
    }
}

?>
<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Nombre y Apellido -->
            <div class="mb-3 col-sm-6 p-0">
                <label for="nombreApellidosID" class="form-label">Nombre y apellidos</label>
                <input type="text" name="nombreApellidos" class="form-control" id="nombreApellidosID"
                    placeholder="Su nombre y apellidos"
                    value="<?= isset($_POST["nombreApellidos"]) ? htmlspecialchars($_POST["nombreApellidos"]) : ''; ?>">
                <span class="text-danger"> <?php echo $nameErr ?> </span>
            </div>
        </div>
        <div class="row">
            <!-- Correo -->
            <div class="mb-3 col-sm-6 p-0">
                <label for="emailID" class="form-label">Correo</label>
                <input type="text" name="email" class="form-control" id="emailID" placeholder="Su correo electrónico"
                    value="<?= isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>">
                <span class="text-danger"> <?php echo $emailErr ?> </span>
            </div>
            <!-- Teléfono -->
            <div class="mb-3 pl-2 col-sm-6 p-0">
                <label for="telefonoID" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="telefonoID" placeholder="Su teléfono"
                    value="<?= isset($_POST["telefono"]) ? htmlspecialchars($_POST["telefono"]) : ''; ?>">
                <span class="text-danger"> <?php echo $telefErr ?> </span>
            </div>
        </div>
        <div class="row mb-4">
            <!-- Tipo -->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipo" id="particularID" value="particular" <?php if (isset($tipo) && $tipo == "particular")
                    echo "checked"; ?>>
                <label class="form-check-label" for="particularID"> Particular </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipo" id="empresaID" value="empresa" <?php if (isset($tipo) && $tipo == "empresa")
                    echo "checked"; ?>>
                <label class="form-check-label" for="empresaID"> Empresa </label>
            </div>
            <span class="text-danger"> <?php echo $tipoErr ?> </span>
        </div>
        <div class="row mb-4">
            <!-- Mensaje -->
            <textarea class="form-control" name="mensaje" id="areaTexto" rows="3"
                placeholder="Escriba su mensaje..."><?php print $mensaje; ?></textarea>
            <label for="areaTexto" class="form-label">Mensaje</label>
        </div>
        <div class="row mb-4">
            <!-- Subida de archivos -->
            <label for="archivoID" class="form-label">Adjuntar archivo</label>
            <input class="form-control" type="file" id="archivoID" name="archivo">
        </div>
        <span class="text-danger"> <?php echo $archivoErr ?> </span>
        <br>
        <!-- Botón enviar -->
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>

<?php include("templates/footer.php"); ?>