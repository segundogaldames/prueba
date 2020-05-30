<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//se requiere el codigo del archivo conexion.php
require('conexion.php');
require('config.php');

// validar la presencia de la variable id que viene de productos.php
if (isset($_GET['id'])) {
	//parseo o conversion de una variable en un entero
	$id = (int) $_GET['id'];

	//consulta a la tabla productos, traeremos todos los campos y registros de la tabla productos asociados a un id
	$usuario = $con->prepare("SELECT u.id, u.nombre, u.email, u.activo, u.created_at, u.updated_at, r.nombre as rol FROM usuarios u INNER JOIN roles r ON u.rol_id = r.id WHERE u.id = ?");
	$usuario->bindParam(1, $id); //sanitizando la variable

	//ejecutar la consulta o traemos los datos efectivamente
	$usuario->execute();

	//especificar que necesitamos todos los datos
	$res = $usuario->fetch();

	//print_r($res);exit;
}


//comprobar que los datos estan disponibles
//print_r($res);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Ver Usuario <?php echo $res['nombre']; ?></h3>
				
				<?php if(isset($_GET['m'])): ?>
					<p class="alert alert-success">El usuario se ha modificado correctamente</p>
				<?php endif; ?>

				<?php if($res): ?>
					<table class="table table-hover table-bordered">
						<!--Declaracion de las columnas de la tabla con sus nombres-->
						<tr>
							<th>Id:</th>
							<td><?php echo $res['id']; ?></td>
						</tr>
						<tr>
							<th>Nombre:</th>
							<td><?php echo $res['nombre']; ?></td>
						</tr>
						<tr>
							<th>Email:</th>
							<td><?php echo $res['email']; ?></td>
						</tr>
						<tr>
							<th>Rol $:</th>
							<td><?php echo $res['rol']; ?></td>
						</tr>
						<tr>
							<th>Activo:</th>
							<td><?php if($res['activo'] == 1): ?> Si <?php else: ?> No <?php endif; ?></td>
						</tr>
						<tr>
							<th>Fecha de creación:</th>
							<td>
								<?php 
									$fecha_reg = new DateTime($res['created_at']);
									echo $fecha_reg->format('d-m-Y H:i:s'); 
								?>
									
							</td>
						</tr>
						<tr>
							<th>Fecha de modificación:</th>
							<td><?php
								 	$fecha_mod = new DateTime($res['updated_at']);
									echo $fecha_mod->format('d-m-Y H:i:s'); 
								 ?>
							 	
							 </td>
						</tr>
					</table>
					<p>
						<a href="editUsuario.php?id=<?php echo $res['id']; ?>" class="btn btn-link">Editar</a>
						<a href="usuarios.php" class="btn btn-link">Volver</a>
						<a href="#" class="btn btn-primary">Cambiar Password </a>
					</p>
				<?php else: ?>
					<p class="text-info">El usuario no existe</p>
					<a href="usuarios.php" class="btn btn-link">Volver</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</body>
</html>