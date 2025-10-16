<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    //Obtener los datos del formulario
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pass = isset($_POST['contrasenya']) ? $_POST['contrasenya'] : '';
    
    //Validar el formato
    $emailErr = validar_email();
    $passErr = validar_contrasenya();
    
    //Si no hay errores de formato decodifico el JSON
    if (empty($emailErr) && empty($passErr)) {
        
        /*UD 4.1.b
        Leo el fichero JSON de usuarios y lo decodifico, luego compruebo mas abajo si el usuario 
        y contraseña introducidos existen en el array decodificado.
        */
        $usuarios = json_decode(file_get_contents("usuarios.json"), true);
        if ($usuarios === null) { //Si falla al hacer el decode inicializamos el array a vacio 
            $usuarios = [];       //esto se hace para que no falle el programa.
        }
        
        //Variables para saber si encontró el usuario y la contraseña
        $usuarioEncontrado = false;
        $passCorrecta = false;
        
        //Recorro el array y si encuetra el usuario y la contraseña, sale del bucle
        foreach ($usuarios as $user) {
            if ($user["email"] == $email) {
                $usuarioEncontrado = true;
                if ($user["pass"] == $pass) {
                    $passCorrecta = true;
                }
                break;
            }
        }
        
        //Si usuario y contraseña son TRUE crea la cookie 
        if ($usuarioEncontrado && $passCorrecta) {
            /*UD 4.1.e
            Almaceno el email en una cookie. En header.php compruebo que la cookie existe y si es
            asi muestro el menú de Administración. En header.php también hago lo de ocultar la opción de login
            si la cookie existe o mostrar logout si la cookie ya existe.
            */ 
            $cookie_name = "user_email";
            $cookie_value = $email;
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            /*UD 4.1.c
            En caso de que usuario y contraseña sean correctas inicia sesion correctamente y redirige a la página 
            de contacto_lista.php. 
            */ 
            header("Location:contacto_lista.php");
            exit;

            // echo "LOGUEADO CON ÉXITO";
            // echo '<script type="text/javascript">
            // window.location = "http://localhost:8090/contacto_lista.php";
            // </script>'; //SCRIPT para usar mas adelante

            /*UD 4.1.d
            Si el email introducido no se encuentra en el fichero de usuarios muestro error en usuario y 
            si el usuario existe pero la contraseña no es correcta muestro el mensaje de error.
            */ 
        } elseif (!$usuarioEncontrado) { 
            $emailErr = "Usuario no encontrado";
        } elseif ($usuarioEncontrado && !$passCorrecta) { 
            $passErr = "Contraseña incorrecta";       
        }
    }
}

include_once("templates/header.php");
?>

<?php
/*UD 4.1.a
Nueva página de login con dos campos de usuario y contraseña y botón de login que al 
pulsarlo ejecuta las validacioes necesarias.
*/ 
?>
<div class="container">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <div class="mb-3 col-sm-6 p-0">
            <label for="correoId" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" id="correoId" placeholder="Su correo electrónico"
                value="<?= isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>">
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

<?php include("templates/footer.php"); ?>