<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>C & M Invoice$ | Opciones</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class = 'opciones'>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="../pages/opciones.php"><img src="../images/logo-hover.png" alt="Logo" class="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="../logout.php"><button type="button" class="btn btn-dark mb-3 btn-salir">Salir</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php include "../sesion.php"?>
    <h2>Elige una opción</h2>
    <div class="div-opciones">
        <div class = 'container'>  

            <a href="../index.php"><button type="button" class="btn btn-dark mb-3 btn-opciones">Ventas</button></a>
            <a href="../pages/productos.php"><button type="button" class="btn btn-dark mb-3 btn-opciones">Productos</button></a>
            <a href="../pages/usuarios.php"><button type="button" class="btn btn-dark mb-3 btn-opciones">Usuarios</button></a>
            <a href="../pages/clientes.php"><button type="button" class="btn btn-dark mb-3 btn-opciones">Clientes</button></a>
        </div>
    </div>

</body>
</html>