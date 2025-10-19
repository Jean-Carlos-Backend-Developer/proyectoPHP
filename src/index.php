<?php include_once(__DIR__ . "/config/config.php"); ?>
<?php include_once(__DIR__ . "/datos.php"); ?>
<?php include_once(__DIR__ . "/templates/header.php"); ?>
<?php include_once(__DIR__ . "/utils/utiles.php"); ?>
<?php

//Recoger la variable page de la URL
$pagina = isset($_GET["page"]) ? $_GET["page"] : "";

//Redirigir a la página correspondiente
switch ($pagina) {
    case "sobreMi":
        include(__DIR__ . "/views/sobre_mi.php");
        break;
    case "contacto":
        include(__DIR__ . "/views/contacto.php");
        break;
    case "confirma_contacto":
        include(__DIR__ . "/views/confirma_contacto.php");
        break;
    case "contacto_lista":
        include(__DIR__ . "/views/contacto_lista.php");
        break;
    case "contacto_detalle":
        include(__DIR__ . "/views/contacto_detalle.php");
        break;
    case "login":
        include(__DIR__ . "/views/login.php");
        break;
    case "crear_editar":
        include(__DIR__ . "/views/crear_editar_producto.php");
        break;
    case "producto":
        include(__DIR__ . "/views/producto.php");
        break;
    case "home":
    case "":
        include(__DIR__ . "/views/productos.php"); // Página principal de productos
        break;
    default:
        echo "<h2>Página no encontrada.</h2>";
        break;
}
?>

<?php include(__DIR__ . "/templates/footer.php"); ?>