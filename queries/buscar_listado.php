<?php 
    $valor = $_POST['valor'] . "%";
    $tipo_listado = $_POST['tipoListado'];
    $listadoContent = '';

    include "../includes/conexion.php";

    if($tipo_listado == 'Clientes'){
        $error = "No se encontró ningún cliente";
        $query = mysqli_query($enlace, "select * from clientes where razon_social like '$valor' OR id_cliente like '$valor' OR correo like '$valor'") or 
                                    die("Problemas buscando clientes:" . mysqli_error($enlace));


        while($listado = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $id_cliente = $listado['id_cliente'];
            $razonSocial = $listado['razon_social'];
            $correo = $listado['correo'];
            $direccion = $listado['direccion']; 
            $telefono = $listado['telefono'];
            $listadoContent .= "<tr><td>" . $id_cliente . "</td>
                                <td>" . $razonSocial . "</td>
                                <td>" . $correo . "</td>
                                <td>" . $direccion . "</td>
                                <td>" . $telefono . "</td></tr>";
        }
    }
    else if($tipo_listado == 'Usuarios'){
        $error = "No se encontró ningún usuario";
        $query = mysqli_query($enlace, "select * from usuarios where username like '$valor' OR id_usuario like '$valor'") or
                             die("Problemas buscando usuarios: " . msqly_error($enlace));   
        while($usuarios = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $id_usuario = $usuarios['id_usuario'];
            $username = $usuarios['username'];
            $correo = $usuarios['Correo'];
            $password = $usuarios['pass'];
            $password_oculta = str_repeat("*", strlen($password)); 
            $cargo = $usuarios['Cargo'];
            $listadoContent .= "<tr><td>" . $id_usuario . "</td>
                                <td>" . $username . "</td>
                                <td>" . $correo . "</td>
                                <td>" . $password_oculta . "</td>
                                <td>" . $cargo . "</td></tr>";
        }
    }
    else if($tipo_listado == 'Productos'){
        $error = "No se encontró ningún producto";
        $query = mysqli_query($enlace, "select * from productos where nombre_producto like '$valor' OR id_producto like '$valor'") or
                                        die("Problemas buscando productos: " . msqly_error($enlace));   
        while($productos = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $id_producto = $productos['id_producto'];
            $nombreProducto = $productos['nombre_producto'];
            $existencia = $productos['existencia'];
            $valorUnitario = $productos['valor_unitario']; 
            $listadoContent .= "<tr><td>" . $id_producto . "</td>
                                <td>" . $nombreProducto . "</td>
                                <td>" . $existencia . "</td>
                                <td>" . $valorUnitario . "</td></tr>";
        }
    }
    else if($tipo_listado == 'Ventas'){
        $error = "No se encontró ninguna venta";
        $query = mysqli_query($enlace, "select ventas.id_venta, ventas.fecha, clientes.razon_social, ventas.total from clientes
                                                                inner join ventas on clientes.id_cliente = ventas.id_cliente where clientes.razon_social like '$valor' 
                                                                OR ventas.id_venta like '$valor' 
                                                                OR ventas.fecha like '$valor' 
                                                                ORDER BY id_venta desc") or       
                                                                die("Error buscando las ventas: " . mysqli_error($enlace));
        while($ventas = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $contador++;
            $listadoContent .= "<tr><td style='padding-top: 20px;'>" . $ventas['id_venta'] . "</td>
                  <td style='padding-top: 20px;'>" . $ventas['fecha'] . "</td>
                  <td style='padding-top: 20px;'>" . $ventas['razon_social'] . "</td>
                  <td style='padding-top: 20px;'>" . $ventas['total'] . "</td>
                  <td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#miModal' id='mostrarModal' onclick='mostrarDetalles(" . $ventas['id_venta'] . ")'>
                  Ver Detalles
                  </button></td></tr>";
        }
    }

    if($listadoContent != null && $listadoContent != ''){
        echo $listadoContent;
    }
    else{
        echo $error;
    }
    mysqli_close($enlace);
?>