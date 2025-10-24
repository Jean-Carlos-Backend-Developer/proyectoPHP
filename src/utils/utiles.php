<?php
function ordenaPorNombreAsc($productos)
{
    usort($productos, function ($a, $b) {
        return strtoupper($a['nombre']) <=> strtoupper($b['nombre']);
    });
    return $productos;
}

function ordenaPorNombreDesc($productos)
{
    usort($productos, function ($a, $b) {
        return strtoupper($b['nombre']) <=> strtoupper($a['nombre']);
    });
    return $productos;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Función para validar email que luego uso en el ejercicio UD 4.1.a
function validar_email()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        if (empty($_POST["email"])) {
            $err = "Porfavor, introduzca un email";
        } else {
            $email = test_input($_POST["email"]); //Limpiamos el email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //Validamos el email
                $err = "Formato del email no válido";
            } else {
                $err = "";
            }
        }
    }
    return $err;
}

function validar_telefono()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        if (empty($_POST["telefono"])) {
            $err = "Porfavor, introduzca un teléfono";
        } else {
            $telefono = test_input($_POST["telefono"]); //Limpiamos el teléfono
            if (!preg_match("/^[98]\d{8}$/", $telefono)) { //Validamos el teléfono
                $err = "Formato del teléfono no válido";
            } else {
                $err = "";
            }
        }
    }
    return $err;
}

function validar_texto()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nombreApellidos"])) {
            $err = "Por favor, introduzca nombre y apellidos";
        } else {
            $name = test_input($_POST["nombreApellidos"]); //Limpiamos el texto
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ' -]*$/u", $name)) {
                $err = "Solo se permiten letras y espacios.";
            } else {
                $err = "";
            }
        }
    }
    return $err;
}

function validar_clave($productos, $productoActualId = null)
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["clave"])) {
            $err = "Por favor, introduzca una clave";
        } else {
            $clave = test_input($_POST["clave"]);
            if (preg_match('/\s/', $clave)) {
                $err = "Solo se permiten letras y espacios.";
            }
        }
    }
    return $err;
}


function validar_titulo()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["titulo"])) {
            $err = "Por favor, introduzca el título";
        } else {
            $titulo = test_input($_POST["titulo"]);
            if (strlen($titulo) > 100) { //Límite de 100 caracteres
                $err = "El título no puede superar los 100 caracteres.";
            }
        }
    }
    return $err;
}

function validar_fecha()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["fecha"])) {
            $fecha = test_input($_POST["fecha"]);
            $valores = explode("/", $fecha);
            if (count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
                $err = "";
            } else {
                $err = "El formato de la fecha es incorrecto. (DD/MM/YYYY).";
            }
        }
    }
    return $err;
}

//Función para validar contraseña que luego uso en el ejercicio UD 4.1.a
function validar_contrasenya()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["contrasenya"])) {
            $err = "Por favor, introduzca una contraseña";
        } else {
            if (strlen($_POST["contrasenya"]) < 6) {
                $err = "La contraseña debe tener al menos 6 caracteres.";
            } else {
                $err = "";
            }
        }
    }
    return $err;
}

function validar_tipo()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["tipo"])) {
            $err = "Por favor, introduzca el tipo de consulta";
        }
    }
    return $err;
}

function validar_mensaje()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["mensaje"])) {
            $mensaje = test_input($_POST["mensaje"]);
            if (strlen($mensaje) > 500) {
                $err = "El mensaje no puede superar los 500 caracteres.";
            }
        }
    }
    return $err;
}

function validar_descripcion()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["descripcion"])) {
            $err = "El campo descripción es obligatorio.";
        } else {
            $mensaje = test_input($_POST["mensaje"]);
            if (strlen($mensaje) > 500) {
                $err = "El mensaje no puede superar los 500 caracteres.";
            }
        }
    }
    return $err;
}

function validar_imagen()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $nombreArchivo = $_FILES["imagen"]["name"];
            $partes = explode(".", $nombreArchivo); //Como split de java
            $extension = strtolower(end($partes)); //Coge el último elemento del array
            $extensiones = ["png", "jpg", "jpeg", "webp"];
            if (!in_array($extension, $extensiones)) {
                $err = "El archivo debe ser una imagen.";
            }
        }
    }
    return $err;
}

function validar_nombre_dosApellidos()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nombreApellidos"])) {
            $err = "Por favor, introduzca nombre y dos apellidos";
        } else {
            $name = test_input($_POST["nombreApellidos"]); //Limpiamos el texto
            $pattern = "/^([A-Za-zÁÉÍÓÚáéíóúÑñ]+)(\s[A-Za-zÁÉÍÓÚáéíóúÑñ]+)?\s[A-Za-zÁÉÍÓÚáéíóúÑñ]+\s[A-Za-zÁÉÍÓÚáéíóúÑñ]+$/";
            if (!preg_match($pattern, $name)) {
                $err = "Por favor, introduzca nombre y dos apellidos.";
            } else {
                $err = "";
            }
        }
    }
    return $err;
}

function validar_dni()
{
    $err = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["dni"])) {
            $err = "Por favor, introduzca un DNI";
        } else {
            $dni = test_input($_POST["dni"]); //Limpiamos el texto
            $pattern = "/^\d{8}[A-Z]$/";
            if (!preg_match($pattern, $dni)) {
                $err = "El formato del DNI no es válido.";
            } else {
                $err = "";
            }
        }
    }
    return $err;
}


/* UD 3.5a 
Creación de función que devuelve el año actual para luego ponerla en el header junto a 
la palabra "Portfolio".
 */
function devuelve_anyo()
{
    return date('Y');
}

/* UD 3.5b
Creación de función que tomará el array de proyectos y los sobreescribirá con productos cuyo atributo sea 
de tipo fecha y no un String 
*/

function devuelve_array_fecha($productos)
{
    $productosConvertidos = [];
    foreach ($productos as $producto) {
        //Pimero creamos un array que contiene cada parte de la fecha separada por '/'
        $fechaPartes = explode('/', $producto['fecha']);
        //Después concatenamos la nueva fecha, para que sea legible para la función strtotime
        $fechaCorrecta = $fechaPartes[2] . '-' . $fechaPartes[1] . '-' . $fechaPartes[0];
        //Por úmtimo convertimos la fecha a timestamp
        $producto['fecha'] = strtotime($fechaCorrecta);
        $productosConvertidos[] = $producto;
    }
    return $productosConvertidos; //Devolvemos un array con la fecha convertida de string a timestamp
}

/* UD 3.5c
Creación de función ordena el array de productos según la fecha asc o desc, depués en index.php
creo otros dos botones para ordenar por fecha.
*/

function ordenaPorFechaAsc($productos)
{
    usort($productos, function ($a, $b) {
        return ($a['fecha']) <=> ($b['fecha']);
    });
    return $productos;
}

function ordenaPorFechaDesc($productos)
{
    usort($productos, function ($a, $b) {
        return ($b['fecha']) <=> ($a['fecha']);
    });
    return $productos;
}
