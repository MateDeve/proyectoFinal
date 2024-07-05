<?php
    $valor = $_POST['valor'];
    $resultados = '';
    include "../includes/conexion.php";

    $productos = mysqli_query($enlace, "select nombre_producto, existencia, valor_unitario
                                    from productos where id_producto = '$valor'") or 
                                    die("Problemas verificando el cliente:" . mysqli_error($enlace));


    if($producto = mysqli_fetch_array($productos)){
        $resultados = $producto['nombre_producto'] . "/" . $producto['existencia'] . "/" . $producto['valor_unitario'];
    }
    echo $resultados;
    mysqli_close($enlace);
?>