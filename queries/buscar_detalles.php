<?php
    $id_venta = $_POST['venta'];
    $cuerpoDetalles = '';

    include '../includes/conexion.php';

    $query = mysqli_query($enlace, "select fecha, id_cliente, total
                                    from ventas  where id_venta = '$id_venta'") or 
                                    die("Problemas accediendo a ventas:" . msqly_error($enlace));

    if($id_ult_venta = mysqli_fetch_array($query)){
        $id_cliente = $id_ult_venta['id_cliente'];
        $ventaTotal = $id_ult_venta['total'];
        $fecha = $id_ult_venta['fecha'];
        $id_relacion = 0;
        $query = mysqli_query($enlace, "select razon_social from clientes where id_cliente = '$id_cliente'") or
                                        die("No se pudo encontrar el cliente: " . mysqli_error($enlace));

        $cliente_ult_venta = mysqli_fetch_array($query);
        $razon_social = $cliente_ult_venta['razon_social'];
        $cuerpoDetalles .= "<h7 style='float: left'>Fecha: " . $fecha . "</h7>";
        $cuerpoDetalles .= "<h6 style='text-align: right;'>Factura No.</h6>";
        $cuerpoDetalles .= "<h7 style='float: right'>" . $id_venta . "</h7>";
        $cuerpoDetalles .= "<h7 style='float: left'>Cliente: " . $razon_social . "</h7>|";

        $query = mysqli_query($enlace, "select id_producto, valor_unitario, cantidad, valor_total_producto
                                    from relacion_venta_producto where id_venta = '$id_venta'") or
                                    die("No se pudo traer la factura: " . msqly_error($enlace));                    
                                    
        while($productos = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $id_relacion++;
            $id_producto = $productos['id_producto'];
            $valorUnitario = $productos['valor_unitario'];
            $cantidad = $productos['cantidad'];
            $valorTotal = $productos['valor_total_producto'];
            $nombreProducto = mysqli_query($enlace, "select nombre_producto from productos where id_producto = '$id_producto'") or
                                                    die("No se pudo traer el nombre del producto: " . mysqli_error($enlace));
            $nombreP = mysqli_fetch_array($nombreProducto);
            $nombre_producto = $nombreP['nombre_producto'];  
            $cuerpoDetalles .= "<tr><td>" . $id_relacion . "</td>
                            <td>" . $id_producto . "</td>
                            <td>" . $nombre_producto . "</td>
                            <td>$" . $valorUnitario . "</td>
                            <td>" . $cantidad . "</td>
                            <td>$" . $valorTotal . "</td></tr>";
        }
        $cuerpoDetalles .= '<td colspan="5" class="text-right"><strong>Total:</strong>
            <td><strong>$' . $ventaTotal . '</strong></td>';
    }
    echo $cuerpoDetalles;

?>