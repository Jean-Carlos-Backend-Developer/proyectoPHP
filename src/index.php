<?php include_once("config/config.php"); ?>
<?php include_once("datos.php"); ?>
<?php include_once("templates/header.php"); ?>
<?php include_once("utils/utiles.php"); ?>
<?php

//Recoger la variable page de la URL
$pagina = isset($_GET["page"]) ? $_GET["page"] : "home";

//Redirigir a la página correspondiente
switch ($pagina) {
    case "sobreMi":
        include("views/sobre_mi.php");
        break;
    case "contacto":
        include("views/contacto.php");
        break;
    case "confirma_contacto":
        include("views/confirma_contacto.php");
        break;
    case "contacto_lista":
        include("views/contacto_lista.php");
        break;
    case "contacto_detalle":
        include("views/contacto_detalle.php");
        break;
    case "login":
        include("views/login.php");
        break;
    case "crear_editar":
        include("views/crear_editar_producto.php");
        break;
    case "producto":
        include("views/producto.php");
        break;
    case "confirmar_producto":
        include("views/confirmar_producto.php");
        break;
    case "usuario":
        include("views/usuario.php");
        break;
    case "confirma_usuario":
        include("views/confirmar_usuario.php");
        break;
    case "home":
    case "":
        include("views/productos.php"); // Página principal de productos
        break;
    default:
        echo "<h2>Página no encontrada.</h2>";
        break;
}
?>

<?php include("templates/footer.php"); ?>