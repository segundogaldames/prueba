<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

//se requiere el codigo del archivo conexion.php
require('conexion.php');
//consulta a las tablas usuarios y roles para rescatar el nombre del rol de los usuarios
$usuarios = $con->prepare("SELECT u.id, u.nombre as usuario, u.activo, r.nombre as rol FROM usuarios u INNER JOIN roles r ON u.rol_id = r.id ORDER BY id DESC");

//ejecutar la consulta o traemos los datos efectivamente
$usuarios->execute();

//especificar que necesitamos todos los datos
$res = $usuarios->fetchAll();

//comprobar que los datos estan disponibles
//print_r($res);

//controlar acceso a la pagina usuarios.php
if(isset($_SESSION['autenticado']) && ($_SESSION['rol'] >= 1) && ($_SESSION['rol'] <= 3)):
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Usuarios</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<!--llamada a menu de navegacion-->
		<?php include('header.php') ?>
		<div class="col-md-8 mt-3">
			<?php if(isset($_GET['m'])): ?>
				<p class="alert alert-success">El usuario se ha registrado correctamente</p>
			<?php endif; ?>
			<?php if(isset($_GET['e'])): ?>
				<p class="alert alert-danger">El usuario no existe</p>
			<?php endif; ?>
			<?php if(isset($_GET['err'])): ?>
				<p class="alert alert-danger">El usuario no se ha eliminado</p>
			<?php endif; ?>
			<?php if(isset($_GET['del'])): ?>
				<p class="alert alert-success">El usuario se ha eliminado correctamente</p>
			<?php endif; ?>
			<?php if(isset($res) && count($res)): ?>

				<?php if(isset($_SESSION['autenticado'])): ?>
						<h3>Bienvenido(a) <?php echo $_SESSION['nombre']; ?></h3>
				<?php endif; ?>	

				<table class="table table-hover table-bordered">
					<!--Declaracion de las columnas de la tabla con sus nombres-->
					<tr>
						<thead class="thead-light text-center">
							<th>Nombre</th>
							<th>Activo</th>
							<th>Rol</th>
						</thead>
					</tr>
					<?php foreach($res as $r): ?>
						<tr>
							<td>
								<a href="verUsuario.php?id=<?php echo $r['id'];?>"><?php echo $r['usuario']; ?></a>
							</td>
							<td>
								<?php if($r['activo']==1): ?> Si <?php else: ?> No <?php endif; ?>
							</td>
							<td><?php echo $r['rol'] ?></td>
						</tr>
					<?php endforeach; ?>
				</table>
				<?php else: ?>
					<p class="text-info">No hay usuarios registrados</p>
				<?php endif; ?>
			<a href="crearUsuario.php" class="btn btn-success">Nuevo Usuario</a>
		</div>
	</div>
</body>
</html>
<?php 
	else:
		header('Location: galeriaProductos.php');
	endif;
?>