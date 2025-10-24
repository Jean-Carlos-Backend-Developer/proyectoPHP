<?php include_once("datos.php"); ?>
<?php include_once("utils/utiles.php"); ?>
<?php

//Obtener el correo de la sesión
$correo = $_SESSION["user_email"];

//Cargar usuarios del JSON
$ficheroUsuarios = "mysql/usuarios.json";
$usuarios = [];

//Decodifico el json
if (file_exists($ficheroUsuarios)) {
    $usuarios = json_decode(file_get_contents($ficheroUsuarios), true) ?? [];
}

//Busco el usuario en el JSON usando el correo de sesión
$indiceEncontrado = null;
$usuarioExistente = null;

foreach ($usuarios as $index => $user) {
    if ($user["email"] == $correo) {
        $indiceEncontrado = $index;
        $usuarioExistente = $user;
        break;
    }
}

//Para coger los valores si se llega con un correo existente
$email = $usuarioExistente["email"];
$pass = $usuarioExistente["pass"];
$dni = $usuarioExistente["dni"];
$nombreApellidos = $usuarioExistente["nombre"];

//Procesar POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del formulario
    $nombreApellidos = $_POST["nombreApellidos"] ?? "";
    $email = $_POST["email"] ?? "";
    $dni = $_POST["dni"] ?? "";
    $password = $_POST["contrasenya"] ?? "";

    //Validaciones
    $nameErr = validar_nombre_dosApellidos();
    $emailErr = validar_email();
    $dniErr = validar_dni();

    //Comprobar que el email es único (excepto el propio usuario)
    foreach ($usuarios as $index => $user) {
        if ($user["email"] === $email && $index !== $indiceEncontrado) {
            $emailErr = "Este correo ya está registrado por otro usuario.";
            break;
        }
    }

    //Mantener la contraseña antigua si no se cambia (asi no falla al mandar POST sin cambiarla)
    //ya que el campo password puede quedar vacío, y en ese caso se mantiene la antigua
    if (empty($password)) {
        $password = $usuarioExistente["pass"];
        $_POST["contrasenya"] = $password; //
    }
    $passErr = validar_contrasenya();

    //Si no hay errores actualizo el usuario
    if ($nameErr === "" && $emailErr === "" && $dniErr === "" && $passErr === "") {

        //Actualizar usuario en el array
        $usuarios[$indiceEncontrado] = [
            "email" => $email,
            "pass" => $password,
            "dni" => $dni,
            "nombre" => $nombreApellidos,
        ];

        //Actualizar el correo en la sesión
        $_SESSION["user_email"] = $email;
        // Guardar el JSON actualizado
        file_put_contents($ficheroUsuarios, json_encode($usuarios, JSON_PRETTY_PRINT));

        // Redirigir a página de confirmación
        echo '<script type="text/javascript">
                window.location.href = "/?page=confirma_usuario";
              </script>';
        exit;
    }
}

?>


<div class="container">
    <div class="row">
        <div class="mb-3">
            <h1>Modificar usuario</h1>
        </div>
    </div>
</div>

<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <!-- Nombre y Apellido -->
        <div class="row">
            <div class="mb-3 col-sm-6 p-0">
                <label for="nombreApellidosID" class="form-label">Nombre y apellidos</label>
                <input type="text" name="nombreApellidos" class="form-control" id="nombreApellidosID"
                    placeholder="Su nombre y apellidos"
                    value="<?= isset($_POST["nombreApellidos"]) ? htmlspecialchars($_POST["nombreApellidos"]) : htmlspecialchars($nombreApellidos); ?>">
                <span class="text-danger"><?= $nameErr ?></span>
            </div>

            <!-- DNI -->
            <div class="mb-3 pl-2 col-sm-6 p-0">
                <label for="dniID" class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" id="dniID" placeholder="Su DNI"
                    value="<?= isset($_POST["dni"]) ? htmlspecialchars($_POST["dni"]) : htmlspecialchars($dni); ?>">
                <span class="text-danger"><?= $dniErr ?></span>
            </div>
        </div>

        <div class="row">
            <!-- Correo -->
            <div class="mb-3 col-sm-6 p-0">
                <label for="emailID" class="form-label">Correo</label>
                <input type="text" name="email" class="form-control" id="emailID" placeholder="Su correo electrónico"
                    value="<?= isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : htmlspecialchars($email); ?>">
                <span class="text-danger"><?= $emailErr ?></span>
            </div>

            <!-- Input oculto para guardar el correo original -->
            <input type="hidden" name="email_original" value="<?= htmlspecialchars($usuarioExistente["email"] ?? $email); ?>">

            <!-- Contraseña -->
            <div class="mb-3 pl-2 col-sm-6 p-0">
                <label for="contrasenyaId" class="form-label">Contraseña</label>
                <!-- La contraseña se mantiene si el usuario no la cambia -->
                <input type="password" name="contrasenya" class="form-control" id="contrasenyaId" placeholder="Su contraseña" value="">
                <span class="text-danger"><?= $passErr ?></span>
            </div>
        </div>

        <div class="row">
            <div class="col text-center">
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
        </div>
        <!-- Botón enviar -->
    </form>
</div>