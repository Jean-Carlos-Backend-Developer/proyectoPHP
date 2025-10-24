<?php
include_once("datos.php");
include_once("utils/utiles.php");

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
        $usuarios = json_decode(file_get_contents("mysql/usuarios.json"), true);
        if ($usuarios === null) { //Si falla al hacer el decode inicializamos el array a vacio 
            $usuarios = [];       //esto se hace para que no falle el programa.
        }
        
        //Variables para saber si encontró el usuario y la contraseña
        $usuarioEncontrado = false;
        $passCorrecta = false;
        
        //Recorro el array y si encuentra el usuario y la contraseña, sale del bucle
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
            Almaceno el email en una cookie de sesión. En header.php compruebo que la cookie existe y si es
            así muestro el menú de Administración y logout y si no solo muestro la opción de login.
            */ 
            $_SESSION['user_email'] = $email;
            /*UD 4.1.c
            En caso de que usuario y contraseña sean correctas inicia sesion correctamente y redirige a la página 
            de contacto_lista.php. 
            */ 
            header("Location:/?page=contacto_lista");
            exit;

            // echo "LOGUEADO CON ÉXITO";
            // echo '<script type="text/javascript">
            // window.location = "http://localhost/contacto_lista.php";
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