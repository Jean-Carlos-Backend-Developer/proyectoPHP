<?php include_once("templates/header.php"); ?>
<?php include_once("datos.php"); ?>
<?php include_once("utiles.php"); ?>

<?php $nameErr = ""; 
$nameErr = valida_texto();

?>
<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <div class="mb-3 col-sm-6 p-0">
            <label for="nombreApellidosID" class="form-label">Nombre y apellidos</label>
            <input type="text" name="nombreApellidos" class="form-control" id="nombreApellidosID"
                placeholder="Su nombre y apellidos">
            <span class="text-danger"> <?php echo $nameErr ?> </span>
        </div>
        
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>

<?php include("templates/footer.php"); ?>