<?php
$categoriaId = isset($_GET["categoria"]) ? $_GET["categoria"] : null; //Coger categoria de la URL


$usuario = isset($_COOKIE["user_email"]) ? $_COOKIE["user_email"] : ""; //Recoger usuario de la cookie


/*
UD 4.1.f
//Recojo la variable que mandé antes por la URL y si es true borro la cookie, poniendo ésta 
a un valor negativo, esto hace que se oculte el menú de ADMINISTRACION y se muestre la opción
de LOGIN otra vez.
*/
$logout = isset($_GET["logout"]) ? $_GET["logout"] : null;
if ($logout == true) {
    setcookie("user_email", "", time() - 3600);
    header("Location: /");
    exit;
}
?>
<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>
<html>

<head>
    <title>Portfolio de proyectos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Optional theme -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css"
        integrity="sha384-qF/QmIAj5ZaYFAeQcrQ6bfVMAh4zZlrGwTPY7T/M+iTTLJqJBJjwwnsE5Y0mV7QK" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="static/css/estilos.css">

</head>
<!-- https://radu.link/make-footer-stay-bottom-page-bootstrap/ -->

<body class="d-flex flex-column min-vh-100">

    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-4">Portfolio <?= devuelve_anyo() ?></span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item">
                <?php
                /*UD 3.2.a
                Para hacer que cuando se haga click en el botón de inicio ir a la página de Inicio
                usamos la linea de href="/", además 
                */
                ?>
                <a href="/" <?php if ($_SERVER['SCRIPT_NAME'] == "/index.php" and empty($categoriaId)): ?>
                    class="nav-link active" <?php else: ?> class="nav-link" <?php endif ?>>INICIO
                </a>
            </li>
            <li class="nav-item">
                <?php
                /*UD 3.2.g
                Para hacer que cuando estemos filtrando por categorias se active el boton de categorias primero miro si se le pasa
                la categoría y si es así , si la categoría es > 0 cambiamos la clase a active.*/
                ?>
                <a href="/" class="nav-link dropdown-toggle <?= ($categoriaId) ? 'active' : '' ?> "
                    id="dropdownMenu1" data-bs-toggle="dropdown" aria-expanded="false">
                    CATEGORÍAS
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <?php
                    /*UD 3.3.e y UD 3.4.b
                    Completar la opción de categorias recorriendo el array de categorias y crea un dropdown con las 
                    categorias.
                    */
                    ?>
                    <?php foreach ($categorias as $id => $categoria): ?>
                        <li>
                            <a class="dropdown-item" href="/?categoria=<?= $id ?>">
                                <?= $categoria ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </li>
            <li class="nav-item">
                <?php
                /*UD 3.2.a
                Para hacer que cuando se haga click en el botón de inicio ir a la página de Inicio
                usamos la linea de href="/"
                */
                ?>
                <a href="sobreMi.php" <?php if ($_SERVER['SCRIPT_NAME'] == "/sobreMi.php"): ?> class="nav-link active"
                    <?php else: ?> class="nav-link" <?php endif ?>>SOBRE MÍ
                </a>
            </li>
            <li class="nav-item">
                <?php
                /*UD 3.2.b
                Para hacer que cuando se haga click en el botón de Contacto ir a la página de Contacto 
                usamos la linea de href="contacto.php"
                */
                ?>
                <a href="contacto.php" <?php if ($_SERVER['SCRIPT_NAME'] == "/contacto.php"): ?> class="nav-link active"
                    <?php else: ?> class="nav-link" <?php endif ?>>CONTACTO
                </a>
            </li>
            <?php
            /*UD 4.1.e
            Compruebo que la cookie existe y si es asi muestro el menú de Administración.
            */
            ?>
            <?php if ($usuario): ?>
                <li class="nav-item">
                    <a href="contacto_lista.php" <?php if ($_SERVER['SCRIPT_NAME'] == "/contacto_lista.php"): ?> class="nav-link active"
                        <?php else: ?> class="nav-link" <?php endif ?>>ADMINISTRACIÓN
                    </a>
                </li>
                <li class="nav-item">
                    <?php
                    /*
                UD 4.1.e
                //Mostrar nueva opción de logout si la cookie existe.
                */
                    ?>
                    <?php
                    /*
                    UD 4.1.f
                    //Al hacer click en logout le mando una variable por URL
                    */
                    ?>
                    <a href="?logout=true" class="nav-link">LOGOUT
                    </a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <?php
                    /*UD 4.1.a
                Nueva opción de login que lleva que lleva al formulario para iniciar sesión
                
                UD 4.1.e
                //Ocultar la opción de login si la cookie existe.
                */
                    ?>
                    <a href="login.php" <?php if ($_SERVER['SCRIPT_NAME'] == "/login.php"): ?> class="nav-link active"
                        <?php else: ?> class="nav-link" <?php endif ?>>LOGIN
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </header>