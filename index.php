<!DOCTYPE html>
<html>
<head>
    <title>C & M Invoice$ | Compras</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="index-page">
    <?php include "includes/nav.php"?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Ventas</h2>
            <?php include "includes/sesion.php"?>
            <form id="forma">
                <div id="tabla-cliente"></div>
                <div class="form-group">
                    <label for="cliente">Cliente:</label>
                    <input type="text" id="cliente" name="cliente" class="form-control" onkeyup="buscarNombres()" required>
                    <ul id="sugerencias" class = 'list-group sugerencias'></ul>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="articulo">Artículo:</label>
                        <input type="text" id="articulo" name="articulo" class="form-control" onkeyup="buscarArticulos()" required>
                        <ul id="sugerenciasArt" class="list-group sugerencias"></ul>
                    </div>
        
                    <div class="col">
                        <label for="cantidad">Cantidad:</label>
                        <input class="form-control" type="number" name="cantidad" id="cantidad" min="1">
                    </div>

                </div>
                

                <div class="form-group">
                    <label for="valor-unitario">Valor Unitario:</label>
                    <input class="valor-unitario" id="valor-unitario" value='0' name='valor-unitario'>
                </div>
                <div class="form-group">
                    <label for="total">Total:</label>
                    <input class="total" id="total" value='0' name='total' readonly>
                </div>
                <input type="button" value="Agregar" class="btn btn-dark mb-3" id="btnAgregar" onclick="agregarVentas()">
                <a href="#btnImprimir"><input type="button" value="Terminar" class="btn btn-dark mb-3"></a>
                <a href="pages/carrito.php"><input type="button" value="Última Venta" class="btn btn-dark mb-3"></a>
                <a href="index.php"><input type="button" value="Nueva venta" class="btn btn-dark mb-3" style="float: right;"></a>
                <h6><strong id='campo-fallo'>
                    <?php
                        if(!empty($_GET['estado'])){
                            if($_GET['estado'] == 'sin_productos'){
                                echo "Agregue al menos un producto";
                            }
                            else{
                                echo "La cantidad de todos los productos, no puede ser cero. En ese caso, dar clic en el botón 'Nueva venta'.";
                            }
                        }
                    ?>
                </strong></h6>
                
            </form>
        </div>
        <div class="container mt-1">
            <form action="queries/agregar_venta.php" method="POST" target="_blank">
                <div class="form-group" id="productos">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Producto</th>
                                <th>Valor Unitario</th>
                                <th>Cantidad</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody id="ventas"></tbody>
                        <td colspan="4" class="text-right"><strong>Total:</strong>
                        <td><strong><input type="number" class="venta-total" value="0" name="venta-total" id="venta-total"readonly></strong></td>
                        <input type="hidden" value="0" name="cantidad-productos" id="cantidad-productos">
                    </table>
                    <input type="submit" value="Imprimir" name="btnImprimir" class="btn btn-dark mb-3" id="btnImprimir" onclick='cleanInput()'>
                    <div id="estado-venta"></div>
                </div>   
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function buscarNombres() {
            let input = document.getElementById("cliente");
            let valor = input.value;
            let sugerencias = document.getElementById("sugerencias");
            $.ajax({
                url: 'queries/buscar_clientes.php',
                type: 'POST',
                data: { valor: valor },
                success: function(response) {
                     sugerencias.innerHTML = response;
                 }
              });
        }
        let sugerenciasLista = document.getElementById("sugerencias");

        let campoCliente = document.getElementById("cliente");

        let campoCantidad = document.getElementById('cantidad');

        let sugerenciasListaArt = document.getElementById("sugerenciasArt");

        let campoArticulo = document.getElementById("articulo");

        let valorUnitario = document.getElementById('valor-unitario');

        let valorTotal = document.getElementById('total');

        let listaVentas = document.getElementById('ventas');

        let cantidadProductos = document.getElementById('cantidad-productos');

        let totalVenta = document.getElementById('venta-total');

        let campoFallo = document.getElementById('campo-fallo');

        let campoEstado = document.getElementById('estado-venta');

        valorUnitario.disabled = true;
        valorTotal.disabled = true;

        function cleanInput(){
            campoFallo.innerHTML = '';
            campoCliente.value = '';
            campoEstado.innerHTML = 'Esta venta ya se imprimió. (Da click en "Nueva Venta")';
        }

        sugerenciasLista.addEventListener("click", function(e) {
        // Verificar si el usuario hizo clic en un elemento de la lista
            if (e.target && e.target.nodeName == "LI") {
                let nombre = e.target.getAttribute("data-name");
                campoCliente.value = nombre;
                sugerenciasLista.style.display = "none";
            }
        });
        campoCliente.addEventListener("input", function() {
            if (campoCliente.value.trim() === "") {
                sugerenciasLista.style.display = "none";
            }
            else{
                sugerenciasLista.style.display = "block";  
            }
        }); 
        
        function buscarArticulos() {
            let input = document.getElementById("articulo");
            let valor = input.value;
            let sugerencias = document.getElementById("sugerenciasArt");
            $.ajax({
                url: '../queries/buscar_articulos.php',
                type: 'POST',
                data: { valor: valor },
                success: function(response) {
                     sugerenciasArt.innerHTML = response;
                 }
              });
        }

        sugerenciasListaArt.addEventListener("click", function(e) {
        // Verificar si el usuario hizo clic en un elemento de la lista
            if (e.target && e.target.nodeName == "LI") {
                let nombreArt = e.target.getAttribute("data-name");
                campoArticulo.value = nombreArt;
                sugerenciasListaArt.style.display = "none";
                $.ajax({
                url: '../queries/valor_unitario.php',
                type: 'POST',
                data: { valor: nombreArt },
                success: function(response) {
                     valorUnitario.value = response;
                 }
              });
            }
        });
        campoArticulo.addEventListener("input", function(){
            if (campoArticulo.value.trim() === "") {
                sugerenciasListaArt.style.display = "none";
                valorUnitario.value = 0;
            }
            else{

                sugerenciasListaArt.style.display = "block";  
            } 
        }); 
        campoCantidad.addEventListener('input', function(){
            let valorArticulo = parseInt(valorUnitario.value);
            valorTotal.value = valorArticulo * campoCantidad.value;

        });

        class Venta{
            constructor (cliente, producto, valorUnitario, cantidad, valorTotal){
                this._cliente = cliente;
                this._producto = producto;
                this._cantidad = cantidad;
                this._valorUnitario = valorUnitario;
                this._valorTotal = valorTotal;
            }
            get cliente(){
                return this._cliente;
            }
            set cliente(cliente){
                this._cliente = cliente;
            }
            get producto(){
                return this._producto;
            }
            set producto(producto){
                this._producto = producto;
            }
            get cantidad(){
                return this._cantidad;
            }
            set cantidad(cantidad){
                this._cantidad = cantidad;
            }
            get valorUnitario(){
                return this._valorUnitario;
            }
            set valorUnitario(valorUnitario){
                this._valorUnitario = valorUnitario;
            }
            get valorTotal(){
                return this._valorTotal;
            }
            set valorTotal(valorTotal){
                this._valorTotal = valorTotal;
            }
        }

        const ventas = [];

        function mostrarVentas(){
            let texto = '';
            let numProducto = 0;
            let ventaTotal = 0;
            for(let venta of ventas){
                numProducto++;
                texto += `<tr><td><input class="form-control" value="${venta.cliente}" name="cliente" readonly></td>
                              <td><input class="form-control" value="${venta.producto}" name="producto-${numProducto}" id="producto-${numProducto}" readonly></td>
                              <td><input class="form-control" value="${venta.valorUnitario}" name="valorUnitario-${numProducto}" id="valorUnitario-${numProducto}" readonly></td> 
                              <td><input class="form-control" value="${venta.cantidad}" name="cantidad-${numProducto}" data-name="${numProducto}" id="cantidad-${numProducto}"></td>
                              <td><input class="form-control" value="${venta.valorTotal}" name="valorTotal-${numProducto}" id="valorTotal-${numProducto}" readonly></td>
                              <td><input type="button" class="form-control" value="Quitar" name="btnQuitar" id="btnQuitar-${numProducto} class="btn btn-dark" style="background: #e5383b; color: #fff" onclick="quitarProducto(${numProducto})" readonly></td></tr>`;
                ventaTotal += parseInt(venta.valorTotal);
            }
            listaVentas.innerHTML = `${texto}`;
            return ventaTotal;
        }

        let ventaTotal = 0;

        function agregarVentas(){
            const forma = document.forms['forma'];
            const cliente = forma['cliente'];
            const producto = forma['articulo'];
            const valorUnitario = forma['valor-unitario'];
            const cantidad = forma['cantidad'];
            const total = forma['total'];
            if(cliente.value != '' && producto.value != '' && valorUnitario.value != '' && cantidad.value != '' && total.value != ''){
                if(cantidad.value != 0){
                    const venta = new Venta(cliente.value, producto.value, valorUnitario.value, cantidad.value, total.value);
                    ventas.push(venta);
                    ventaTotal = mostrarVentas();
                    totalVenta.value = ventaTotal;
                //cliente.value = '';
                    producto.value = '';
                    valorUnitario.value = '';
                    cantidad.value = '';
                    total.value = '';10000
                    cantidadProductos.value = parseInt(cantidadProductos.value) + 1;
                    campoFallo.innerHTML = ""; 
                }
                else{
                    campoFallo.innerHTML = "La cantidad no puede ser cero.";
                }  
            }
            else{
                campoFallo.innerHTML = "Llene todos los campos";
            }
        }

        listaVentas.addEventListener('click', function(e){
            if(e.target && e.target.nodeName == 'INPUT'){
                let numeroCampo = e.target.getAttribute('data-name');
                if(numeroCampo != null){
                    let campoCant = document.getElementById('cantidad-' + numeroCampo);
                    let campoT = document.getElementById('valorTotal-' + numeroCampo);
                    let campoUnit = document.getElementById('valorUnitario-' + numeroCampo);
                    
                    campoCant.addEventListener('input', function(){
                        let totalTotal = 0;
                        if(campoCant.value.trim() === ''){
                            campoT.value = 0;
                        }
                        else{
                            campoT.value = parseInt(campoCant.value) * parseInt(campoUnit.value);
                        }
                        for(let i = 1; i <= cantidadProductos.value; i++){
                            totalTotal += parseInt(document.getElementById('valorTotal-' + i).value);
                        }
                        totalVenta.value = totalTotal;
                    });
                    campoCant.addEventListener('change', function(){
                        let indice = numeroCampo - 1;
                        ventas[indice].cantidad = campoCant.value;
                    });
                }
                
            }
        });

        function quitarProducto(numeroProducto){
            cantidadProductos.value--;
            totalTotal = 0;
            let indice = numeroProducto - 1;
            ventas.splice(indice, 1);
            ventaTotal = mostrarVentas();
            console.log(ventas);
            totalVenta.value = ventaTotal;
        }
        
    </script> 
</body>
</html>

