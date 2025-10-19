<?php include("templates/header.php"); ?>

<?php
if ($nameErr === "" && $emailErr === "" && $telefErr === "" && $tipoErr === ""){
    $contacto = [
        "name" => $name,
        "email" => $email,
        "telefono" => $phone,
        "tipo" => $tipo,
        "mensaje" => $mensaje,
        "file" => $pathArchivo,

    ];
    //https://stackoverflow.com/questions/7895335/append-data-to-a-json-file-with-php
    $tempArray = json_decode(file_get_contents('mysql/contactos.json'));
    if ($tempArray === NULL){
        $tempArray = [];
    }
    array_push($tempArray, $contacto);
    $contactos_json = json_encode($tempArray);
    file_put_contents('mysql/contactos.json', $contactos_json);
    ?>

    <script type="text/javascript">
        window.location = "http://localhost/confirma_contacto.php";
    </script>     

    <?php
}
?>
<div class="container">
    <div class="alert alert-success mt-5">
    Ha contactado con nosotros satisfactoriamente. En breve nos pondremos en
    contacto con usted
    </div>
    <div>
        <a class="btn btn-xs btn-info float-right" href="/"> Volver al inicio </a>
    </div>
</div>

<?php include("templates/footer.php"); ?>