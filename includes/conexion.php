<?php
    $enlace = mysqli_connect("localhost", "root","1234","proyectoventas");

    if(!$enlace){
        die("no pudo conectarse a la base de datos ". mysqli_error());
    }

?>