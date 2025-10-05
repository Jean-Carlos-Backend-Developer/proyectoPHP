<?php
function ordenaPorNombreAsc(&$productos)//con el & modifica directamente el array
{
    usort($productos, function ($a, $b) {
        return strtoupper($a['nombre']) <=> strtoupper($b['nombre']);
    });
    //Si no pongo el & tengo que devolver el array con la línea de abajo
    //return $productos; // devolvemos el array ordenado
}

function ordenaPorNombreDesc(&$productos)
{
    usort($productos, function ($a, $b) {
        return strtoupper($b['nombre']) <=> strtoupper($a['nombre']);
    });
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

?>