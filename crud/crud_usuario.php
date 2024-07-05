<?php
    $id_usuario = $_POST['userId'];
    $username = $_POST['username'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $cargo = $_POST['cargo'];
    $btnPost = $_POST['btnUsuario'];

    include "../includes/conexion.php";


    if($btnPost == 'Agregar'){
        $agregar = mysqli_query($enlace, "insert into usuarios (username, Correo, pass, Cargo) 
                                    VALUES ('$username', '$correo' , '$password' ,'$cargo')") or
                                    die("Problemas verificando el usuario:" . mysqli_error($enlace));
        
        header('Location: ../pages/usuarios.php?exitoInsert=true');
        
    }
    if($btnPost == 'Actualizar'){
        $actualizar = mysqli_query($enlace, "update usuarios set id_usuario = '$id_usuario', username = '$username', Correo ='$correo',
                                         pass='$password', Cargo ='$cargo' WHERE id_usuario = $id_usuario") or
                                        die("Problemas verificando el usuario:" . mysqli_error($enlace));

        header('Location: ../pages/usuarios.php?exitoUpdate=true');

    }
    if($btnPost == 'Eliminar'){
        $eliminar = mysqli_query($enlace, "delete from usuarios where id_usuario = $id_usuario") or
                                     die("Problemas verificando el usuario:" . mysqli_error($enlace));   


        header('Location: ../pages/usuarios.php?exitoDelete=true');
    }

?>