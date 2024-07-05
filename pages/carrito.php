<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Facturas</title>
</head>
<body class="carrito-page">
    <?php include "../includes/nav.php"?>
    <div class="main-content">
        <div class="container mt-5">
        <?php include "../sesion.php"?>
            <h2>Factura</h2>
                <div class="from-group">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Registro</th>
                                <th>ID Producto</th>
                                <th>Nombre del Producto</th>
                                <th>Valor Unitario</th>
                                <th>Cantidad</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                
                                include "../includes/conexion.php";
                                $query = mysqli_query($enlace, "select id_venta, id_cliente, total
                                                    from ventas  where id_venta = (select max(id_venta) from ventas)") or 
                                                    die("Problemas accediendo a ventas:" . msqly_error($enlace));

                                if($id_ult_venta = mysqli_fetch_array($query)){
                                    $id_venta = $id_ult_venta['id_venta'];
                                    $id_cliente = $id_ult_venta['id_cliente'];
                                    $ventaTotal = $id_ult_venta['total'];
                                    $id_relacion = 0;
                                    $query = mysqli_query($enlace, "select razon_social from clientes where id_cliente = '$id_cliente'") or
                                                                die("No se pudo encontrar el cliente: " . mysqli_error($enlace));
                                    $cliente_ult_venta = mysqli_fetch_array($query);
                                    $razon_social = $cliente_ult_venta['razon_social'];
                                    echo "<h5 style='text-align: right;'>Factura No.</h5>";
                                    echo "<h5 style='float: right'>" . $id_venta . "</h5>";
                                    echo "<h5 style='float: left'>Cliente: " . $razon_social . "</h5>";

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
                                        echo "<tr><td>" . $id_relacion . "</td>
                                                <td>" . $id_producto . "</td>
                                                <td>" . $nombre_producto . "</td>
                                                <td>$" . $valorUnitario . "</td>
                                                <td>" . $cantidad . "</td>
                                                <td>$" . $valorTotal . "</td></tr>";
                                    }
                                    echo '<td colspan="5" class="text-right"><strong>Total:</strong>
                                    <td><strong>$' . $ventaTotal . '</strong></td>';
                                }
                            ?>
                        </tbody>
                    </table>
                    <div class="btnRegresar">
                        <a href="../index.php"><input type="button" value="Regresar" name="btnRegresar" class="btn btn-dark mb-3" ></a>
                        <div class="btnHistorial" style="float: right;">
                            <a href="../pages/historial_ventas.php?listado=Ventas"><input type="button" value="Ver Historial de Ventas" name="btnRegresar" class="btn btn-dark mb-3" ></a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>