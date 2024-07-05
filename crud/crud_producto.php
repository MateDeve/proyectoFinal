<?php
    $id_producto = $_POST['productoId'];
    $nombreProducto = $_POST['nombre_producto'];
    $existencia = $_POST['existencia'];
    $valorUnitario = $_POST['valor_unitario'];
    $btnPost = $_POST['btnProducto'];

    include "../includes/conexion.php";

    if($btnPost == 'Agregar'){
        $agregar = mysqli_query($enlace, "insert into productos (nombre_producto, existencia, valor_unitario) 
                                    VALUES ('$nombreProducto', '$existencia' , '$valorUnitario')") or
                                    die("Problemas verificando el cliente:" . mysqli_error($enlace));
        
        header('Location: ../pages/productos.php?exitoInsert=true');
        
    }
    if($btnPost == 'Actualizar'){
        $actualizar = mysqli_query($enlace, "update productos set id_producto = '$id_producto', 
                                        nombre_producto = '$nombreProducto', existencia ='$existencia', valor_unitario ='$valorUnitario' WHERE id_producto = $id_producto") or
                                        die("Problemas verificando el cliente:" . mysqli_error($enlace));

        header('Location: ../pages/productos.php?exitoUpdate=true');

    }
    if($btnPost == 'Eliminar'){
        $eliminar = mysqli_query($enlace, "delete from productos where id_producto = $id_producto") or
                                    die("Problemas verificando el usuario:" . mysqli_error($enlace));   


        header('Location: ../pages/productos.php?exitoDelete=true');
    }


?>