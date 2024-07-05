<?php 
    require_once('../TCPDF-main/tcpdf.php');
    $nombre_proyecto = 'C&M-Invoices';
    $id_venta = $_POST['campoOculto'];

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

    $cabeza .= "<tr><th>Reg</th>
                <th>ID Producto</th>
                <th>Producto</th>
                <th>Valor Unitario</th>
                <th>Cantidad</th>
                <th>Total</th></tr>
                </hr></thead></table>";

    $reg = 0;

    include '../includes/conexion.php';

    $query = mysqli_query($enlace, "select clientes.razon_social, productos.nombre_producto, 
                                    productos.id_producto, productos.valor_unitario, relacion_venta_producto.valor_total_producto, relacion_venta_producto.cantidad, ventas.total
                                    FROM clientes
                                    JOIN ventas ON clientes.id_cliente = ventas.id_cliente
                                    JOIN relacion_venta_producto ON ventas.id_venta = relacion_venta_producto.id_venta
                                    JOIN productos ON relacion_venta_producto.id_producto = productos.id_producto where ventas.id_venta = '$id_venta'") or
                                    die('Error al buscar la factura: ' . mysqli_error($enlace));
    while($factura = mysqli_fetch_array($query, MYSQLI_ASSOC)){
        $reg++;
        $cliente = $factura['razon_social'];
        $nombre_producto = $factura['nombre_producto'];
        $id_producto = $factura['id_producto'];
        $valor_unitario = $factura['valor_unitario'];
        $cantidad = $factura['cantidad'];
        $valor_total_producto = $factura['valor_total_producto'];
        $total = $factura['total'];
        $html .= "<tr><td>" . $reg . "</td><td>" . $id_producto . "</td><td>" . $nombre_producto . 
                "</td><td>$" . $valor_unitario . "</td><td>" . $cantidad . "</td><td>$" . $valor_total_producto . "</td></tr><hr>";
    }

    $fecha = date('d-m-Y');
    $html .= '<hr><tr><td colspan="4"></td><td>Total:</td><td>$' . $total . '</td></tr>';
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




?>