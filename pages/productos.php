<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>C & M Invoice$ | Productos</title>
</head>
<body class="productos-page">
    <?php include "../includes/nav.php"?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Productos</h2>
            <?php include "../includes/sesion.php"?>
            <form action="../crud/crud_producto.php" method="post">
                <button type="button" class="btn btn-primary mb-3" onclick="agregarProducto()">Agregar Producto</button>
                <button type="button" class="btn btn-primary mb-3" onclick="consultarProducto()">Consultar Producto</button>
                <div id="mensaje-exito" style="float: right;">
                    <?php if(!empty($_GET['exitoInsert'])){
                                echo "<h5>Producto agregado exitosamente<h5>";
                        }
                    ?>
                </div>
                <div class="row mb-5">
                    <div class="col productoId" id="productoIdCampo">
                        <label for="productoId">ID producto</label>
                        <input type="text" class="form-control" id="productoId" name="productoId" onkeyup="buscarProductos()">
                    </div>
                    <div class="col">
                        <label for="nombre_producto">Nombre del producto</label>
                        <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
                    </div>
                </div>  
                <div class="row mb-5">
                    <div class="col">
                        <label for="existencia">Existencia</label>
                        <input type="number" class="form-control" id="existencia" name="existencia" required>
                    </div> 
                    <div class="col">   
                        <label for="valor_unitario">Valor Unitario</label>
                        <input type="number" class="form-control" id="valor_unitario" name="valor_unitario" required>
                    </div>
                </div>
                <div class="btns-consultar" id="btns-consultar">
                    <input type="submit" class="btn btn-primary mb-3 btn-eliminar" id="btn-eliminar" value='Eliminar' name='btnProducto'>
                    <input type="submit" class="btn btn-primary mb-3 btn-actualizar" id="btn-actualizar" value='Actualizar' name='btnProducto'>
                </div>  
                <input type="submit" class="btn btn-primary mb-3 btn-agregar" id="btn-agregar" value='Agregar' name="btnProducto">
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let productoIdCampo = document.getElementById('productoIdCampo');
        let btnEliminar = document.getElementById('btn-eliminar');
        let btnAgregar = document.getElementById('btn-agregar');
        let btnActualizar = document.getElementById('btn-actualizar');
        let btnsConsultar = document.getElementById('btns-consultar');
        let nombreProducto = document.getElementById("nombre_producto");
        let existencia = document.getElementById("existencia");
        let valorUnitario = document.getElementById("valor_unitario");
        let campoExito = document.getElementById('mensaje-exito');
        
        function consultarProducto(){
            campoExito.innerHTML = '';
            productoIdCampo.style.display = "block";
            btnsConsultar.style.display = 'block';
            btnAgregar.style.display = "none";
            let productoId = document.getElementById("productoId");
            nombreProducto.value = "";
            existencia.value = "";
            valorUnitario.value = "";
            productoId.value = "";
            nombreProducto.disabled = true;
            existencia.disabled = true;
            valorUnitario.disabled = true;
            valorUnitario.disabled = false;
            productoId.addEventListener('input', function(){
                if(productoId.value.trim() === ""){
                    nombreProducto.disabled = true;
                    existencia.disabled = true;
                    valorUnitario.disabled = true;
                }
                else{
                    nombreProducto.disabled = false;
                    existencia.disabled = false;
                    valorUnitario.disabled = false;
                }
            });

        }
        function agregarProducto(){
            nombreProducto.disabled = false;
            existencia.disabled = false;
            valorUnitario.disabled = false;
            nombreProducto.value = "";
            existencia.value = "";
            valorUnitario.value = "";
            if(productoIdCampo.style.display == "block"){
                productoIdCampo.style.display = "none";
                btnsConsultar.style.display = 'none';
                btnAgregar.style.display = "block";
            }
        }
        function buscarProductos() {
            let input = document.getElementById("productoId");
            let valor = input.value;
            let resultados = "";
            let resultadosArr = [];
            $.ajax({
                url: '../queries/buscar_productos_crud.php',
                type: 'POST',
                data: { valor: valor },
                success: function(response) {
                    resultados = response;
                    if(resultados != ''){
                        resultadosArr = resultados.split("/");
                        nombreProducto.value = resultadosArr[0];
                        existencia.value = resultadosArr[1];
                        valorUnitario.value = resultadosArr[2];
                    }
                    else {
                        nombreProducto.value = '';
                        existencia.value = '';
                        valorUnitario.value = '';
                    }
                 }
            });
            
        }
    </script>
</body>
</html>
