<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Inicio de Sesión</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="queries/procesar_login.php" method="post">
            <div class="form-group">
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Ingresar</button>
            </div>
        </form>
    </div>
    <?php
    session_start();
    if (!empty($_SESSION["usuario"])) {

        header("Location: pages/opciones.php");
        // Redirige a la página de inicio de sesión si el usuario no ha iniciado sesión
    }
    if(!empty($_SESSION['invalido'])){
        echo "<h5>" . $_SESSION['invalido'] . "</h5>";
    }
    ?>
</body>
</html>