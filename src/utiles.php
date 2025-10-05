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

function valida_texto()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nombreApellidos"])) {
            $nameErr = "Por favor, introduzca nombre y apellidos";
        } else {
            $name = test_input($_POST["nombreApellidos"]);
            if (test_input($name)) {
                $nameErr = "Solo se permiten letras y espacios.";
            }
        }
    }
    return $nameErr;
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

function devuelve_array_fecha($productos) {
    $productosConvertidos =  [];
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
?>