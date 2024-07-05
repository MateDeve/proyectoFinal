<?php
    $id_cliente = $_POST['clienteId'];
    $razonSocial = $_POST['razonSocial'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $btnPost = $_POST['btnCliente'];

    include "../includes/conexion.php";

    if($btnPost == 'Agregar'){
        $agregar = mysqli_query($enlace, "insert into clientes (razon_social, correo, direccion, telefono) 
                                    VALUES ('$razonSocial', '$correo' , '$direccion' ,'$telefono')") or
                                    die("Problemas verificando el cliente:" . mysqli_error($enlace));
        
        header('Location: ../pages/clientes.php?exitoInsert=true');
        
    }
    if($btnPost == 'Actualizar'){
        $actualizar = mysqli_query($enlace, "update clientes set id_cliente = '$id_cliente', 
                                        razon_social = '$razonSocial', correo = '$correo', direccion = '$direccion', telefono ='$telefono' WHERE id_cliente = $id_cliente") or
                                        die("Problemas verificando el cliente:" . mysqli_error($enlace));

        header('Location: ../pages/clientes.php?exitoUpdate=true');

    }
    if($btnPost == 'Eliminar'){
        $eliminar = mysqli_query($enlace, "delete from clientes where id_cliente = $id_cliente") or
                                    die("Problemas eliminando el usuario:" . mysqli_error($enlace));   


        header('Location: ../pages/clientes.php?exitoDelete=true');
    }


?>