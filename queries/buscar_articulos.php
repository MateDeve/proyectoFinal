<?php
    $valor = "%" . $_POST['valor'] . "%";
    
    include "../includes/conexion.php";

    $articulos = mysqli_query($enlace, "select nombre_producto, existencia
                                    from productos where nombre_producto like '$valor'") or 
                                    die("Problemas verificando el usuario:" . mysqli_error($enlace));


    if($articulos){
        $nombreArticulo = '';
        while($articulo = mysqli_fetch_array($articulos, MYSQLI_ASSOC)){
            $nombre = $articulo["nombre_producto"];
            $existencia = $articulo['existencia'];
            if($existencia > 0){
                $nombreArticulo .= '<li data-name = "' . $nombre . '" class = "list-group-item">' . $nombre . '</li>';
            }
        }
    }
    echo $nombreArticulo;
    mysqli_close($enlace);
?>