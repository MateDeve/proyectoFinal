<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>C & M Invoice$ | Clientes</title>
</head>
<body class="clientes-page">
    <?php include "../includes/nav.php"?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Clientes</h2>
            <?php include "../includes/sesion.php"?>
            <form action="../crud/crud_cliente.php" method="post">
                <button type="button" class="btn btn-primary mb-3" onclick="agregarCliente()">Agregar Cliente</button>
                <button type="button" class="btn btn-primary mb-3" onclick="consultarCliente()">Consultar Cliente</button>
                <div class="row mb-5"> 
                    <div class="col clienteId" id="clienteIdCampo">
                        <label for="clienteId">ID cliente</label>
                        <input type="text" class="form-control" id="clienteId" name="clienteId" onkeyup="buscarClientes()">
                    </div>
                    <div class="col">
                        <label for="razon_social">Razón Social</label>
                        <input type="text" class="form-control" id="razon_social" name="razonSocial" required>
                    </div>
                    <div class="col">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                </div>
                <div class = "row mb-5">
                    <div class = "col">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div> 
                    <div class = "col">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                </div>
                <div class="btns-consultar" id="btns-consultar">
                    <input type="submit" class="btn btn-primary mb-3 btn-eliminar" id="btn-eliminar" value='Eliminar' name='btnCliente'>
                    <input type="submit" class="btn btn-primary mb-3 btn-actualizar" id="btn-actualizar" value='Actualizar' name='btnCliente'>
                </div>   
                <input type="submit" class="btn btn-primary mb-3 btn-agregar" id="btn-agregar" value='Agregar' name="btnCliente">
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let campoClienteId = document.getElementById('clienteIdCampo');
        let btnEliminar = document.getElementById('btn-eliminar');
        let btnAgregar = document.getElementById('btn-agregar');
        let btnActualizar = document.getElementById('btn-actualizar');
        let btnsConsultar = document.getElementById('btns-consultar');
        let razonSocial = document.getElementById("razon_social");
        let clienteCorreo = document.getElementById("correo");
        let clienteDirec = document.getElementById("direccion");
        let clienteTel = document.getElementById("telefono");

        
        function consultarCliente(){
            campoClienteId.style.display = "block";
            btnsConsultar.style.display = 'block';
            btnAgregar.style.display = "none";
            let clienteId = document.getElementById("clienteId");
            clienteId.value = "";
            razonSocial.value = "";
            clienteCorreo.value = "";
            clienteDirec.value = "";
            clienteTel.value = "";
            razonSocial.disabled = true;
            clienteCorreo.disabled = true;
            clienteDirec.disabled = true;
            clienteTel.disabled = true;
            clienteId.addEventListener('input', function(){
                if(clienteId.value.trim() === ""){
                    razonSocial.disabled = true;
                    clienteCorreo.disabled = true;
                    clienteDirec.disabled = true;
                    clienteTel.disabled = true;
                }
                else{
                    razonSocial.disabled = false;
                    clienteCorreo.disabled = false;
                    clienteDirec.disabled = false;
                    clienteTel.disabled = false;
                }
            });

        }
        function agregarCliente(){
            razonSocial.disabled = false;
            clienteCorreo.disabled = false;
            clienteDirec.disabled = false;
            clienteTel.disabled = false;
            razonSocial.value = "";
            clienteCorreo.value = "";
            clienteDirec.value = "";
            clienteTel.value = "";
            if(campoClienteId.style.display == "block"){
                campoClienteId.style.display = "none";
                btnsConsultar.style.display = 'none';
                btnAgregar.style.display = "block";
            }
        }
        function buscarClientes() {
            let input = document.getElementById("clienteId");
            let valor = input.value;
            let resultados = "";
            let resultadosArr = [];
            $.ajax({
                url: '../queries/buscar_clientes_crud.php',
                type: 'POST',
                data: { valor: valor },
                success: function(response) {
                    resultados = response;
                    if(resultados != ''){
                        resultadosArr = resultados.split("/");
                        razonSocial.value = resultadosArr[0];
                        clienteCorreo.value = resultadosArr[1];
                        clienteDirec.value = resultadosArr[2];
                        clienteTel.value = resultadosArr[3];
                    }
                    else {
                        razonSocial.value = '';
                        clienteCorreo.value = '';
                        clienteDirec.value = '';
                        clienteTel.value = ''; 
                    }
                 }
            });
        }
    </script>
</body>
</html>