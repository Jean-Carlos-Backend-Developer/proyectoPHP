<?php include_once(__DIR__ . "/../utils/utiles.php"); ?>
<?php include_once(__DIR__ . "/../config/config.php"); ?>

<?php
/*UD 4.1.a
Nueva página de login con dos campos de usuario y contraseña y botón de login que al 
pulsarlo ejecuta las validacioes necesarias.
*/ 
?>
<div class="container">
    <form action="/?page=login" method="POST">

        <div class="mb-3 col-sm-6 p-0">
            <label for="correoId" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" id="correoId" placeholder="Su correo electrónico"
                value="<?= isset($_POST["email"]) ? htmlspecialchars($email) : ''; ?>">
            <span class="text-danger"> <?= $emailErr ?> </span>

        </div>
        <div class="mb-3 col-sm-6 p-0">
            <label for="contrasenyaId" class="form-label">Contraseña</label>
            <input type="password" name="contrasenya" class="form-control" id="contrasenyaId" placeholder="Su contraseña"
                value="<?= isset($_POST["contrasenya"]) ? htmlspecialchars($_POST["contrasenya"]) : ''; ?>">
            <span class="text-danger"> <?= $passErr ?> </span>
        </div>

        <button type="submit" class="btn btn-success">Login</button>
    </form>
</div>