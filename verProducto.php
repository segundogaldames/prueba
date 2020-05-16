<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//se requiere el codigo del archivo conexion.php
require('conexion.php');

// validar la presencia de la variable id que viene de productos.php
if (isset($_GET['id'])) {
	//parseo o conversion de una variable en un entero
	$id = (int) $_GET['id'];

	//consulta a la tabla productos, traeremos todos los campos y registros de la tabla productos asociados a un id
	$producto = $con->prepare("SELECT id,nombre,codigo,precio FROM productos WHERE id = ?");
	$producto->bindParam(1, $id); //sanitizando la variable

	//ejecutar la consulta o traemos los datos efectivamente
	$producto->execute();

	//especificar que necesitamos todos los datos
	$res = $producto->fetch();
}


//comprobar que los datos estan disponibles
//print_r($res);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Productos</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('header.php'); ?>
		<div class="col-md-6 mt-3">
			<?php if(isset($_GET['m'])): ?>
				<p class="alert alert-success">El producto se ha modificado correctamente</p>
			<?php endif; ?>
			<h3>Ver Producto <?php echo $res['nombre']; ?></h3>
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
					<th>Código:</th>
					<td><?php echo $res['codigo']; ?></td>
				</tr>
				<tr>
					<th>Precio $:</th>
					<td><?php echo number_format($res['precio'],0,',','.'); ?></td>
				</tr>
			</table>
			<p>
				<a href="editProducto.php?id=<?php echo $res['id']; ?>" class="btn btn-link">Editar</a>
				<a href="productos.php" class="btn btn-link">Volver</a>
				<a href="eliminarProducto.php?id=<?php echo $res['id']; ?>" class="btn btn-primary">Eliminar Producto</a>
			</p>
		</div>
	</div>
</body>
</html>