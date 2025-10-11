<?php include_once("templates/header.php"); ?>
<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>

<?php
$emailErr = validar_email();
$nameErr = validar_texto();
$telefErr = validar_telefono();


?>
<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="row">
            <div class="mb-3 col-sm-6 p-0">
                <label for="nombreApellidosID" class="form-label">Nombre y apellidos</label>
                <input type="text" name="nombreApellidos" class="form-control" id="nombreApellidosID"
                    placeholder="Su nombre y apellidos"
                    value="<?= isset($_POST["nombreApellidos"]) ? htmlspecialchars($_POST["nombreApellidos"]) : ''; ?>">
                <span class="text-danger"> <?php echo $nameErr ?> </span>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-sm-6 p-0">
                <label for="emailID" class="form-label">Correo</label>
                <input type="text" name="email" class="form-control" id="emailID" placeholder="Su correo electrónico"
                    value="<?= isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>">
                <span class="text-danger"> <?php echo $emailErr ?> </span>
            </div>
            <div class="mb-3 pl-2 col-sm-6 p-0">
                <label for="telefonoID" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="telefonoID" placeholder="Su teléfono"
                    value="<?= isset($_POST["telefono"]) ? htmlspecialchars($_POST["telefono"]) : ''; ?>">
                <span class="text-danger"> <?php echo $telefErr ?> </span>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>

<?php include("templates/footer.php"); ?>