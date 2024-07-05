<?php
    $valor = "%" . $_POST['valor'] . "%";
    
    include "../includes/conexion.php";

    $clientes = mysqli_query($enlace, "select razon_social
                                    from clientes where razon_social like '$valor'") or 
                                    die("Problemas verificando el usuario:" . mysqli_error($enlace));


    if($clientes){
        $nombreCompleto = '';
        while($cliente = mysqli_fetch_array($clientes, MYSQLI_ASSOC)){
            $nombre = $cliente["razon_social"];
            $nombreCompleto .= '<li data-name = "' . $nombre . '" class="list-group-item">' . $nombre . '</li>';
        }
    }
    echo $nombreCompleto;
    mysqli_close($enlace);
?>