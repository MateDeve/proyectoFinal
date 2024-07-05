<?php
    $valor = $_POST['valor'];
    $resultados = '';
    include "../includes/conexion.php";


    $usuarios = mysqli_query($enlace, "select username, correo, pass, cargo
                                    from usuarios where id_usuario = '$valor'") or 
                                    die("Problemas verificando el usuario:" . mysqli_error($enlace));


    if($usuario = mysqli_fetch_array($usuarios)){
        $resultados = $usuario['username'] . "/" . $usuario['correo'] . "/" . $usuario['pass'] . "/" . $usuario['cargo'];
    }
    echo $resultados;
    mysqli_close($enlace);
?>