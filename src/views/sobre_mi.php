<div class="container">
    <h2 class="mb-5">Sobre mí</h2>
    <div class="row">
        <div class="col-md">
            <img src="../static/images/businessman.jpg" class="img-fluid rounded">
        </div>
        <div class="col-md">
            <?php
            /*UD 3.2.c
            Aqui es donde pongo el include para poder usar la variable que está en la pagina de datos.php
            y la uso en el h3 usando echo*/
            ?>
            <h3><?php echo $nombre['name'] . " " . $nombre['surname']?></h3>
            <p>Ciclo Superior DAW.</p>
            <p>Apasionado del mundo de la programación en general, y de las tecnologías web en particular.</p>
            <p>Si tienes cualquier tipo de pregunta, contacta conmigo por favor.</p>
            <p>Teléfono: 87654321</p>
        </div>
    </div>
</div>