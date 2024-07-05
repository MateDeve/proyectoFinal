<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>C & M Invoice$ | Facturas</title>
</head>
<body class="carrito-page">
    <?php include "../includes/nav.php"?>
    <div class="main-content">
        <div class="container mt-5">
        <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-lg-custom" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalles de Factura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">
                        <div id="datos-factura"></div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Registro</th>
                                    <th>ID Producto</th>
                                    <th>Nombre Producto</th>
                                    <th>Valor Unitario</th>
                                    <th>Cantidad</th>
                                    <th>Valor Total</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-detalles"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="../queries/historial_facturas.php" target="_blank">
                            <input type="submit" class="btn btn-secundary" id="imp-detalles" value="Imprimir" style="color: #fff;">
                            <input type="hidden" id="campoOculto" name="campoOculto">
                        </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
            <?php include "../includes/sesion.php"?>
            <h2 class="mb-3">Historial Ventas</h2>
                <div class="from-group">
                    <div class="row mb-3" style="float: right;">
                        <div class="col">
                            <input type="text" placeholder="Buscar Factura" id="buscar-barra" class="form-control" onkeyup="buscarListado()">
                            <span class="mensaje-busqueda" id="mensaje-busqueda">Ingresa fecha, ID venta o cliente</span>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Venta</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Factura</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo-listado">
                            <?php 
                                include "../includes/conexion.php";
                                $contador = 0;
                                $query = mysqli_query($enlace, "select ventas.id_venta, ventas.fecha, clientes.razon_social, ventas.total from clientes
                                                                inner join ventas on clientes.id_cliente = ventas.id_cliente ORDER BY id_venta desc") or       
                                                                die("Error buscando las ventas: " . mysqli_error($enlace));
                                while($ventas = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                                    $contador++;
                                    echo "<tr><td style='padding-top: 20px;'>" . $ventas['id_venta'] . "</td>
                                          <td style='padding-top: 20px;'>" . $ventas['fecha'] . "</td>
                                          <td style='padding-top: 20px;'>" . $ventas['razon_social'] . "</td>
                                          <td style='padding-top: 20px;'>" . $ventas['total'] . "</td>
                                          <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#miModal' id='mostrarModal' onclick='mostrarDetalles(" . $ventas['id_venta'] . ")'>
                                          Ver Detalles
                                          </button></td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let campoBusqueda = document.getElementById('buscar-barra');
        function buscarListado(){
            let valor = campoBusqueda.value;
            let resultado = '';
            let listado = document.getElementById('cuerpo-listado');
            let queryString = window.location.search;
            let params = new URLSearchParams(queryString);
            let tipoListado = params.get('listado');
            $.ajax({
                url: '../queries/buscar_listado.php',
                type: 'POST',
                data: { valor: valor, 
                        tipoListado: tipoListado
                },
                success: function(response) {
                    listado.innerHTML = response;
                }
            });
        }
        let mensajeBusqueda = document.getElementById('mensaje-busqueda');
        campoBusqueda.addEventListener('click', function(){
            mensajeBusqueda.style.display = 'block';
        });
        function mostrarDetalles(idVenta){
            let campoOculto = document.getElementById('campoOculto');
            campoOculto.setAttribute('value', idVenta);
            let tablaDetalles = document.getElementById('tabla-detalles');
            let datosFactura = document.getElementById('datos-factura');
            let detallesArr = [];
            $.ajax({
                url: '../queries/buscar_detalles.php',
                type: 'POST',
                data: {
                    venta: idVenta
                },
                success: function(response) {
                    detallesArr = response.split('|');
                    datosFactura.innerHTML = detallesArr[0];
                    tablaDetalles.innerHTML = detallesArr[1];
                }
            });
        }
    </script>
    
</body>
</html>