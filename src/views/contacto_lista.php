<?php
$ficheroContactos = 'mysql/contactos.json';

if (!file_exists($ficheroContactos)) {
    //Si no existe, lo creamos vacío
    file_put_contents($ficheroContactos, json_encode([], JSON_PRETTY_PRINT));
}

$contactosLista = json_decode(file_get_contents($ficheroContactos), true);
if ($contactosLista === NULL) {
    $contactosLista = [];
}

?>

<div class="container mb-5">
    <h1>Lista de contactos</h1>
    <?php if (empty($contactosLista)) { ?>
        <div class="alert alert-info mt-5">
            Aún no ha sido contactado
        </div>
    <?php } else { ?>
        <div class="list-group">
            <?php foreach ($contactosLista as $contacto): ?>
                <a href="/?page=contacto_detalle&id= <?= $contacto["id"] ?>" class="list-group-item list-group-item-action"><?php echo $contacto['email'] ?> - <?php echo $contacto['phone'] ?></a>
            <?php endforeach; ?>
        </div>
    <?php } ?>

</div>