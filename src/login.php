<?php include_once("templates/header.php"); ?>
<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>

<?php
$nameErr1 = validar_email();
$nameErr2 = validar_contrasenya();

?>
<div class="container">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <div class="mb-3 col-sm-6 p-0">
            <label for="correoId" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" id="correoId" placeholder="Su correo electrónico"
                value="<?= isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>">
            <span class="text-danger"> <?= $nameErr1 ?> </span>

        </div>
        <div class="mb-3 col-sm-6 p-0"> 
            <label for="contrasenyaId" class="form-label">Contraseña</label>
            <input type="password" name="contrasenya" class="form-control" id="contrasenyaId"
                placeholder="Su contraseña">
            <span class="text-danger"> <?= $nameErr2 ?> </span>
        </div>

        <button type="submit" class="btn btn-success">Login</button>
    </form>
</div>

<?php include("templates/footer.php"); ?>