<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//se requiere el codigo del archivo conexion.php
require('conexion.php');
//consulta a la tabla productos, traeremos todos los campos y registros de la tabla productos
$productos = $con->prepare("SELECT id,nombre,codigo,precio FROM productos ORDER BY id DESC");

//ejecutar la consulta o traemos los datos efectivamente
$productos->execute();

//especificar que necesitamos todos los datos
$res = $productos->fetchAll();

//comprobar que los datos estan disponibles
//print_r($res);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Productos</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="col-md-8 mt-3">
			<?php if(isset($_GET['m'])): ?>
				<p class="alert alert-success">El producto se ha registrado correctamente</p>
			<?php endif; ?>
			<table class="table table-hover table-bordered">
				<!--Declaracion de las columnas de la tabla con sus nombres-->
				<tr>
					<thead class="thead-dark text-center">
						<th>Id</th>
						<th>Producto</th>
						<th>Código</th>
						<th>Precio ($)</th>
					</thead>
				</tr>
				<?php foreach($res as $r): ?>
					<tr>
						<td><?php echo $r['id']; ?></td>
						<td><?php echo $r['nombre']; ?></td>
						<td><?php echo $r['codigo']; ?></td>
						<td class="text-right"><?php echo number_format($r['precio'],0,',','.'); ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
			<a href="crearProducto.php" class="btn btn-success">Nuevo Producto</a>
		</div>
	</div>
</body>
</html>