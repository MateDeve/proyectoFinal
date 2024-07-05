<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class ="container">
        <a class="navbar-brand" href="../pages/opciones.php"><img src="../images/logo-hover.png" alt="Logo" class="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="../index.php">Ventas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/historial_ventas.php?listado=Ventas"><input type="submit" value="Historial Ventas" name="btnDrop"></a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="../pages/productos.php">Productos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/listado.php?listado=Productos"><input type="submit" value="Lista de productos" name="btnDrop"></a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="../pages/usuarios.php">Usuarios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/listado.php?listado=Usuarios"><input type="submit" value="Lista de usuarios" name="btnDrop"></a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="../pages/clientes.php">Clientes</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/listado.php?listado=Clientes"><input type="submit" value="Lista de clientes" name="btnDrop"></a></li>
                    </ul>
                </li>
                <li class="nav-item">
                        <a href="../logout.php"><button type="button" class="btn btn-dark mb-3 btn-salir">Salir</button></a>
                </li>
            </ul>
        </div>
    </div>
</nav>