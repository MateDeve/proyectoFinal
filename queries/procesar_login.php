<?php
// Verificar las credenciales en una página de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    function verificarCredenciales($username, $password){
        require_once("../includes/conexion.php");

        $usuarios = mysqli_query($enlace, "select id_usuario
                                    from usuarios where username like '$username' AND pass = '$password'") or 
                                    die("Problemas verificando el usuario:" . mysqli_error($enlace));
        if(mysqli_fetch_array($usuarios)){
            return true;
        }
        mysqli_close($enlace);
    }

    // Realizar la verificación de credenciales con la base de datos
    if (verificarCredenciales($username, $password)) {
        // Iniciar sesión
        session_start();
        $_SESSION["usuario"] = $username;
        header("Location: ../pages/opciones.php"); // Redirige a la página protegida
    } else {
        session_start();
        $_SESSION['invalido'] = "El usuario no existe";
        header("Location: ../login.php");
    }
}


?>