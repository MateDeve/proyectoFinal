<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <title>C & M Invoice$ | Listado</title>
    </head>
    <body class="carrito-page">
        <?php include "../includes/nav.php"?>
        <div class="main-content">
            <div class="container mt-5">
                <h2>Listado de <?php if($_GET['listado']){
                    echo $_GET['listado'];
                }?></h2>
                <?php include "../includes/sesion.php";?>
                    <div class="from-group">
                        <div class="row mb-3" style="float: right;">
                            <div class="col">
                                <input type="text" placeholder="Buscar <?php if($_GET['listado']){ echo $_GET['listado']; }?>" id="buscar-barra" class="form-control" onkeyup="buscarListado()">
                            </div>
                        </div>
                        <table class="table table-striped table-bordered">
                            <?php
                                if($_GET['listado']){
                                    $listado = $_GET['listado'];
                                    include '../includes/conexion.php';
                                
                                    if($listado == 'Productos'){
                                        echo "<thead>
                                                <tr>
                                                    <th>ID producto</th>
                                                    <th>Nombre producto</th>
                                                    <th>Existencia</th>
                                                    <th>Valor unitario</th>
                                                </tr>
                                            </thead>";    
                                        
                                        echo "<tbody id='cuerpo-listado'>";
                                        $query = mysqli_query($enlace, "select * from productos") or
                                                                die("No se pudo traer la factura: " . msqly_error($enlace));   
                                        while($productos = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                                                $id_producto = $productos['id_producto'];
                                                $nombreProducto = $productos['nombre_producto'];
                                                $existencia = $productos['existencia'];
                                                $valorUnitario = $productos['valor_unitario']; 
                                                echo "<tr><td>" . $id_producto . "</td>
                                                        <td>" . $nombreProducto . "</td>
                                                        <td>" . $existencia . "</td>
                                                        <td>" . $valorUnitario . "</td></tr>";
                                        }
                                        echo "</tbody>"; 
                                    }
                                    if($listado == 'Usuarios'){
                                        echo "<thead>
                                                <tr>
                                                    <th>ID usuario</th>
                                                    <th>Username</th>
                                                    <th>Correo</th>
                                                    <th>Password</th>
                                                    <th>Cargo</th>
                                                </tr>
                                            </thead>";    
                                        
                                        echo "<tbody id='cuerpo-listado'>";
                                        $query = mysqli_query($enlace, "select * from usuarios") or
                                                                die("No se pudo traer la factura: " . msqly_error($enlace));   
                                        while($usuarios = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                                                $id_usuario = $usuarios['id_usuario'];
                                                $username = $usuarios['username'];
                                                $correo = $usuarios['Correo'];
                                                $password = $usuarios['pass'];
                                                $password_oculta = str_repeat("*", strlen($password)); 
                                                $cargo = $usuarios['Cargo'];
                                                echo "<tr><td>" . $id_usuario . "</td>
                                                        <td>" . $username . "</td>
                                                        <td>" . $correo . "</td>
                                                        <td>" . $password_oculta . "</td>
                                                        <td>" . $cargo . "</td></tr>";
                                        }           
                                        echo "</tbody>"; 
                                    }
                                    if($listado == 'Clientes'){
                                        echo "<thead>
                                                <tr>
                                                    <th>ID cliente</th>
                                                    <th>Razón social</th>
                                                    <th>Correo</th>
                                                    <th>Dirección</th>
                                                    <th>Teléfono</th>
                                                </tr>
                                            </thead>";    
                                        echo "<tbody id='cuerpo-listado'>";
                                        $query = mysqli_query($enlace, "select * from clientes") or
                                                                die("No se pudo traer la factura: " . msqly_error($enlace));   
                                        while($usuarios = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                                                $id_cliente = $usuarios['id_cliente'];
                                                $razonSocial = $usuarios['razon_social'];
                                                $correo = $usuarios['correo'];
                                                $direccion = $usuarios['direccion']; 
                                                $telefono = $usuarios['telefono'];
                                                echo "<tr><td>" . $id_cliente . "</td>
                                                        <td>" . $razonSocial . "</td>
                                                        <td>" . $correo . "</td>
                                                        <td>" . $direccion . "</td>
                                                        <td>" . $telefono . "</td></tr>";
                                        }           
                                        echo "</tbody>"; 
                                    }
                                }else{
                                    echo "Error en la página del listado";
                                }  
                            ?>
                        </table>
                    </div>
            </div>    
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function buscarListado(){
                let input = document.getElementById('buscar-barra');
                let valor = input.value;
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
        </script>
    </body>
</html>