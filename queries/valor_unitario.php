<?php

    $valor = $_POST['valor'];

    include "../includes/conexion.php";

    $valor_unitario = mysqli_query($enlace, "select valor_unitario
                                            from productos where nombre_producto = '$valor'") or 
                                            die("Problemas verificando el usuario:" . mysqli_error($enlace));

    if($valor_unitario){
        $precio_unitario = mysqli_fetch_array($valor_unitario);
    }
    echo $precio_unitario['valor_unitario'];

?>