<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="galeriaProductos.php">Galería</a>
      </li>
      <?php if(isset($_SESSION['autenticado'])): ?>
        <?php if($_SESSION['rol'] >= 1 && $_SESSION['rol'] <= 3): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Administración
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="cotizaciones.php">Cotizaciones</a>
              <a class="dropdown-item" href="productos.php">Productos</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="usuarios.php">Usuarios</a>
              <a class="dropdown-item" href="roles.php">Roles</a>
            </div>
          </li>
        <?php endif; ?>
      <?php endif; ?>

      <?php if(!isset($_SESSION['autenticado'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Iniciar Session</a>
        </li>
        <!--registro de clientes-->
        <li class="nav-item">
          <a class="nav-link" href="registro.php">Regístrate</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="cerrar.php">Cerrar Session</a>
        </li>
      <?php endif; ?>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>