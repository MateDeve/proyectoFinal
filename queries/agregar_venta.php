<?php
    require_once('../TCPDF-main/tcpdf.php');
    $nombre_proyecto = 'C&M-Invoices';


    if($_SERVER["REQUEST_METHOD"] == "POST" ){

        $cantidadProductos = $_POST['cantidad-productos'];

        if($cantidadProductos > 0){
            $cliente = $_POST['cliente'];
            $ventas_array = [];
            $valorTotalVenta = $_POST['venta-total'];
            $total_productos = 0;
            $fecha = date("Y-m-d");
            for($i = 1; $i <= $cantidadProductos; $i++){
                if($_POST['cantidad-' . $i] != 0){
                    $ventas_array['producto-' . $i] = $_POST['producto-' . $i];
                    $ventas_array['valorUnitario-' . $i] = $_POST['valorUnitario-' . $i];
                    $ventas_array['cantidad-' . $i] = $_POST['cantidad-' . $i];
                    $ventas_array['valorTotal-' . $i] = $_POST['valorTotal-' . $i];
                    $total_productos++;
                }
            }

            class PDF extends TCPDF {
                // Método para personalizar el encabezado
                public function Header() {
                    // Establecer el título del documento (opcional)
                    $this->SetTitle('C & M Invoice$');

                    $imageFile = '../images/logo.jpg';  // Ruta de la imagen del logo
                    $this->Image($imageFile, 5, 5, 45, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);     
            
                    // Agregar contenido al encabezado
                    $this->SetFont('helvetica', 'B', 12);
                    $this->Cell(0, 50, 'C & M Invoice$', 0, 0, 'C');
                }
            }
        
            $pdf = new PDF();
            
            $pdf->AddPage();
            $html = "<table>";
            $raya= "<hr>";
            $cabeza = "<table><thead>";
            $cabeza .= "<tr><th>Reg</th><th>ID Producto</th><th>Producto</th><th>Valor Unitario</th><th>Cantidad</th><th>Total</th></tr></hr></thead></table>";
            
            include "../includes/conexion.php";


            $id_clientes = mysqli_query($enlace, "select id_cliente
                                                    from clientes where razon_social = '$cliente'") or 
                                                    die("Problemas verificando el usuario:" . mysqli_error($enlace));
                        
            if($id_clientes){
                $id_cliente = mysqli_fetch_array($id_clientes);
                $id = $id_cliente['id_cliente'];

            }
            if(!empty($ventas_array)){
                $query = mysqli_query($enlace, "insert into ventas 
                                                (fecha, id_cliente, cantidad_productos, total) values ('$fecha', '$id', '$total_productos', '$valorTotalVenta')") or
                                                die('Imposible ingresar la venta: ' . mysqli_error($enlace));
                $reg = 0;
                for($i = 1; $i <= $cantidadProductos; $i++){
                    if(!empty($ventas_array['producto-' . $i])){
                        $reg++;
                        $producto = $ventas_array['producto-' . $i];
                        $id_productos = mysqli_query($enlace, "select id_producto, existencia
                                                        from productos where nombre_producto = '$producto'") or 
                                                        die("Problemas verificando el usuario:" . mysqli_error($enlace));
                        if($id_productos){
                            $id_producto = mysqli_fetch_array($id_productos);
                            $id_prod = $id_producto['id_producto'];
                            $existencia = $id_producto['existencia'] - $ventas_array['cantidad-' . $i];
                        }
                        $query = mysqli_query($enlace, "update productos set existencia = '$existencia' where id_producto = '$id_prod'") or
                                                    die("No se pudo actualizar la existencia: " . mysqli_error($enalce));
                        
                        $query = mysqli_query($enlace, "select id_venta
                                                    from ventas  where id_venta = (select max(id_venta) from ventas)") or 
                                                    die("Problemas accediendo a ventas:" . msqly_error($enlace));

                        $id_ult_venta = mysqli_fetch_array($query);
                        $id_venta = $id_ult_venta['id_venta'];

                        $valorUnitario = $ventas_array['valorUnitario-' . $i];
                        $cantidad = $ventas_array['cantidad-' . $i];
                        $total = $ventas_array['valorTotal-' . $i];

                        $agregar_ventas = mysqli_query($enlace, "insert into relacion_venta_producto
                                                            (id_venta, id_producto, valor_unitario, cantidad, valor_total_producto)
                                                            values ('$id_venta', '$id_prod', '$valorUnitario', '$cantidad','$total')") or
                                                            die("Problemas ingresando el artículo:" . mysqli_error($enlace));
                        
                        $html .= "<tr><td>" . $reg . "</td><td>" . $id_prod . "</td><td>" . $producto . 
                                "</td><td>$" . $valorUnitario . "</td><td>" . $cantidad . "</td><td>$" . $total . "</td></tr>";
                    }
                }

                mysqli_close($enlace);

                $fecha = date('d-m-Y');
                $html .= '<hr><tr><td colspan="4"></td><td>Total:</td><td>$' . $valorTotalVenta . '</td></tr>';
                $html .= '</table>';

                $pdf->writeHTML($raya, true, false, true, false, '');
                $pdf->Cell(0, 55, 'Factura No. ' . $id_venta . '                                        Fecha: ' . $fecha, 0, 1);
                $pdf->Cell(0, 0, 'Cliente: ' . $cliente, 0, 1);
                $pdf->writeHTML($raya, true, false, true, false, '');
                $pdf->writeHTML($cabeza, true, false, true, false, '');
                $pdf->writeHTML($raya, true, false, true, false, '');
                $pdf->writeHTML($html, true, false, true, false, '');
                ob_end_clean();
                $pdf->Output('factura-' . $nombre_proyecto . '-' . $cliente . '-' . $fecha . '.pdf', 'I');
            }
            else{
                header('Location: ../index.php?estado=cantidad_cero');
            }
            
        }
        else{
            header('Location: ../index.php?estado=sin_productos');
        }
    }
?>