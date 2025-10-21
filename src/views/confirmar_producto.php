<?php
$productoId = isset($_GET["id"]) ? $_GET["id"] : "";
?>
<div class="container">
    <div class="alert alert-success mt-5">
    Producto añadido correctamente.
    </div>
    <div>
        <a class="btn btn-xs btn-info float-right" href="/?page=producto&id=<?= $productoId ?>"> Ir a ficha de producto </a>
    </div>
</div>