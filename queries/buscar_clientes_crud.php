<?php
    $valor = $_POST['valor'];
    
    include "../includes/conexion.php";
    $resultados = '';
    $clientes = mysqli_query($enlace, "select razon_social, correo, direccion, telefono
                                    from clientes where id_cliente = '$valor'") or 
                                    die("Problemas verificando el cliente:" . mysqli_error($enlace));


    if($cliente = mysqli_fetch_array($clientes)){
        $resultados = $cliente['razon_social'] . "/" . $cliente['correo'] . "/" . $cliente['direccion'] . "/" . $cliente['telefono'];
    }
    echo $resultados;
    mysqli_close($enlace);
?>