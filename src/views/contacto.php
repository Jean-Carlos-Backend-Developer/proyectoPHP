<?php include_once("datos.php"); ?>
<?php include_once("utils/utiles.php"); ?>

<?php

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : ""; //Para que guarde el tipo si falla al enviar algo por post

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Obtener los datos del formulario
    $nombreApellidos = isset($_POST["nombreApellidos"]) ? $_POST["nombreApellidos"] : "";
    $correo = isset($_POST["email"]) ? $_POST["email"] : "";
    $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : "";
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $mensaje = isset($_POST["mensaje"]) ? $_POST["mensaje"] : "";
    $fichero = isset($_FILES["archivo"]) ? $_FILES["archivo"] : ""; //Los ficheros se envian por $_FILES

    //Validar el formato
    $nameErr = validar_texto();
    $emailErr = validar_email();
    $telefErr = validar_telefono();
    $tipoErr = validar_tipo();
    $mensajeErr = validar_mensaje();
    if (!empty($fichero)) {
        $nombreArchivo = $_FILES['archivo']['name'];
        move_uploaded_file($_FILES['archivo']['tmp_name'], "/var/www/html/uploads/{$nombreArchivo}");
        if ($nombreArchivo) {
            $pathArchivo = "uploads/{$nombreArchivo}";
        }
    }

    //Si no hay errores decodifico el json
    if ($nameErr === "" && $emailErr === "" && $telefErr === "" && $tipoErr === "" && $mensajeErr === "") {
        $producto = [
            "name" => $nombreApellidos,
            "email" => $email,
            "phone" => $telefono,
            "tipo" => $tipo,
            "mensaje" => $mensaje,
            "file" => $pathArchivo,
        ];

        $ficheroContactos = "mysql/contactos.json";

        //Comprueba si el fichero no existe
        if (!file_exists($ficheroContactos)) {
            file_put_contents($ficheroContactos, json_encode([]));
        }

        //Lee el fichero y lo decodifica
        $tempArray = json_decode(file_get_contents($ficheroContactos), true);
        if ($tempArray === NULL) {
            $tempArray = [];
        }

        $contacto["id"] = count($tempArray) + 1; //Añadir un id a cada contacto.

        array_push($tempArray, $contacto); //Añado al array temporal el nuevo contacto
        $contactos_json = json_encode($tempArray, JSON_PRETTY_PRINT); //Codifico el array y lo guardo en json
        file_put_contents($ficheroContactos, $contactos_json); //Escribo el fichero json

        echo '
            <script type="text/javascript">
                window.location.href = "/?page=confirma_contacto";
            </script> ';
        exit;
    }
}


?>

<div class="container">
    <div class="row">
        <div class="mb-3">
            <h1>Rellene el formulario para contactarnos</h1>
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
                    value="<?= isset($_POST["nombreApellidos"]) ? htmlspecialchars($_POST["nombreApellidos"]) : ''; ?>">
                <span class="text-danger"> <?= $nameErr ?> </span>
            </div>
        </div>
        <div class="row">
            <!-- Correo -->
            <div class="mb-3 col-sm-6 p-0">
                <label for="emailID" class="form-label">Correo</label>
                <input type="text" name="email" class="form-control" id="emailID" placeholder="Su correo electrónico"
                    value="<?= isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>">
                <span class="text-danger"> <?= $emailErr ?> </span>
            </div>
            <!-- Teléfono -->
            <div class="mb-3 pl-2 col-sm-6 p-0">
                <label for="telefonoID" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="telefonoID" placeholder="Su teléfono"
                    value="<?= isset($_POST["telefono"]) ? htmlspecialchars($_POST["telefono"]) : ''; ?>">
                <span class="text-danger"> <?= $telefErr ?> </span>
            </div>
        </div>
        <!-- Tipo -->
        <div class="row mb-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipo" id="particularID" value="particular"
                    <?php if (isset($tipo) && $tipo == "particular")
                        echo "checked"; ?>>
                <label class="form-check-label" for="particularID"> Particular </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipo" id="empresaID" value="empresa"
                    <?php if (isset($tipo) && $tipo == "empresa")
                        echo "checked"; ?>>
                <label class="form-check-label" for="empresaID"> Empresa </label>
            </div>
            <span class="text-danger"> <?= $tipoErr ?> </span>
        </div>
        <!-- Mensaje -->
        <div class="row mb-4">
            <textarea class="form-control" name="mensaje" id="areaTexto" rows="3"
                placeholder="Escriba su mensaje..."><?php print $mensaje; ?></textarea>
            <label for="areaTexto" class="form-label">Mensaje</label>
        </div>
        <span class="text-danger"> <?= $mensajeErr ?> </span>
        <br>
        <!-- Subida de archivos -->
        <div class="row mb-4">
            <label for="archivoID" class="form-label">Adjuntar archivo</label>
            <input class="form-control" type="file" id="archivoID" name="archivo">
        </div>
        <span class="text-danger"> <?= $archivoErr ?> </span>
        <br>
        <!-- Botón enviar -->
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>