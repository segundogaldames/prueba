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

	//consulta a la tabla roles, traeremos todos los campos y registros de la tabla roles asociados a un id
	$rol = $con->prepare("SELECT id,nombre,created_at,updated_at FROM roles WHERE id = ?");
	$rol->bindParam(1, $id); //sanitizando la variable

	//ejecutar la consulta o traemos los datos efectivamente
	$rol->execute();

	//especificar que necesitamos todos los datos
	$res = $rol->fetch();
	//print_r($res);exit;
}

//comprobar que los datos estan disponibles
//print_r($res);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Roles</title>
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
				<?php if(isset($_GET['m'])): ?>
					<p class="alert alert-success">El producto se ha modificado correctamente</p>
				<?php endif; ?>
				<?php if(isset($_GET['img'])): ?>
					<p class="alert alert-success">La imagen se ha agregado correctamente</p>
				<?php endif; ?>
				<h3>Ver Rol <?php echo $res['nombre']; ?></h3>
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
							<td>
								<?php 
									$fecha_mod = new DateTime($res['updated_at']);
									echo $fecha_mod->format('d-m-Y H:i:s'); 
								?>
									
							</td>
						</tr>
					</table>
					<p>
						<a href="editRol.php?id=<?php echo $res['id']; ?>" class="btn btn-link">Editar</a>
						<a href="roles.php" class="btn btn-link">Volver</a>
						<a href="#" class="btn btn-primary">Eliminar Producto</a>
					</p>
				<?php else: ?>
					<p class="text-info">El rol no existe</p>
					<a href="roles.php" class="btn btn-link">Volver</a>
				<?php endif; ?>
			</div>	
		</div>
	</div>
</body>
</html>