<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>C & M Invoice$ | Usuarios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="usuarios-page">
    <?php include "../includes/nav.php"?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Usuarios</h2>
            <?php include "../includes/sesion.php"?>
            <form action='../crud/crud_usuario.php' method='POST'>
                <button type="button" class="btn btn-primary mb-3" onclick="agregarUsuario()">Agregar Usuario</button>
                <button type="button" class="btn btn-primary mb-3" onclick="consultarUsuario()">Consultar Usuario</button>
                <div class="row mb-5">
                    <div class="col userId" id="userIdCampo">
                        <label for="userId">ID Usuario</label>
                        <input type="text" class="form-control" id="userId" name="userId" onkeyup="buscarUsuarios()">
                    </div>
                    <div class="col">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="col">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col">
                        <label for="cargo">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" required>
                    </div>
                </div>
                <div class="btns-consultar" id="btns-consultar">
                    <input type="submit" class="btn btn-primary mb-3 btn-eliminar" id="btn-eliminar" value='Eliminar' name='btnUsuario'>
                    <input type="submit" class="btn btn-primary mb-3 btn-actualizar" id="btn-actualizar" value='Actualizar' name='btnUsuario'>
                </div>        
                <input type="submit" class="btn btn-primary mb-3 btn-agregar" id="btn-agregar" value='Agregar' name="btnUsuario">
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let campoUserId = document.getElementById('userIdCampo');
        let btnEliminar = document.getElementById('btn-eliminar');
        let btnAgregar = document.getElementById('btn-agregar');
        let btnActualizar = document.getElementById('btn-actualizar');
        let btnsConsultar = document.getElementById('btns-consultar');
        let userName = document.getElementById("username");
        let userMail = document.getElementById("correo");
        let password = document.getElementById("password");
        let userCargo = document.getElementById("cargo");

        
        function consultarUsuario(){
            campoUserId.style.display = "block";
            btnsConsultar.style.display = 'block';
            btnAgregar.style.display = "none";
            let userId = document.getElementById("userId");
            userName.value = "";
            userMail.value = "";
            password.value = "";
            userCargo.value = "";
            userId.value = "";
            userName.disabled = true;
            userMail.disabled = true;
            password.disabled = true;
            userCargo.disabled = true;
            userId.addEventListener('input', function(){
                if(userId.value.trim() === ""){
                    userName.disabled = true;
                    userMail.disabled = true;
                    password.disabled = true;
                    userCargo.disabled = true;
                }
                else{
                    userName.disabled = false;
                    userMail.disabled = false;
                    password.disabled = false;
                    userCargo.disabled = false;
                }
            });

        }
        function agregarUsuario(){
            userName.disabled = false;
            userMail.disabled = false;
            password.disabled = false;
            userCargo.disabled = false;
            userName.value = "";
            userMail.value = "";
            password.value = "";
            userCargo.value = "";
            if(campoUserId.style.display == "block"){
                campoUserId.style.display = "none";
                btnsConsultar.style.display = 'none';
                btnAgregar.style.display = "block";
            }
        }
        function buscarUsuarios() {
            let input = document.getElementById("userId");
            let valor = input.value;
            let resultados = "";
            let resultadosArr = [];
            $.ajax({
                url: '../queries/buscar_usuarios.php',
                type: 'POST',
                data: { valor: valor },
                success: function(response) {
                    resultados = response;
                    if(resultados != ''){
                        resultadosArr = resultados.split("/");
                        userName.value = resultadosArr[0];
                        userMail.value = resultadosArr[1];
                        password.value = resultadosArr[2];
                        userCargo.value = resultadosArr[3];
                    }
                    else {
                        userName.value = '';
                        userMail.value = '';
                        password.value = '';
                        userCargo.value = '';
                    }
                 }
            });
            
        }
    </script>
</body>
</html>