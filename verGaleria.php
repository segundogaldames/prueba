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

	//consulta a la tabla productos por id
	$producto = $con->prepare("SELECT nombre, precio FROM productos WHERE id = ?");
	$producto->bindParam(1, $id); //sanitizando la variable

	//ejecutar la consulta o traemos los datos efectivamente
	$producto->execute();

	//especificar que necesitamos todos los datos
	$res = $producto->fetch();

	//listamos las imagenes por producto
	$imagenes = $con->prepare("SELECT descripcion, nombre FROM imagenes WHERE producto_id = ?");
	$imagenes->bindParam(1, $id);
	$imagenes->execute();

	$img = $imagenes->fetchAll();
}
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
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Ver Producto <?php echo $res['nombre']; ?></h3>
				<table class="table table-hover table-bordered">
					<!--Declaracion de las columnas de la tabla con sus nombres-->
					<tr>
						<th>Nombre:</th>
						<td><?php echo $res['nombre']; ?></td>
					</tr>
					<tr>
						<th>Precio $:</th>
						<td><?php echo number_format($res['precio'],0,',','.'); ?></td>
					</tr>
				</table>
				<p>
					Cotizar
				</p>
			</div>
			<!--Caja que muestra  las imagenes asociadas al producto-->
			<div class="col-md-6 mt-3">
				<?php
					if (!$res):
				?>
					<p class="text-info">No hay imágenes disponibles...</p>

				<?php else:
					foreach ($img as $i):
				?>
					<div class="col-md-8">
						<img src="<?php echo BASE_IMG . $i['nombre']; ?>" class="img-responsive">
						<p style="color: #17227A" class="text-justify"><?php echo $i['descripcion']; ?></p>
					</div>
				<?php endforeach;endif; ?>
			</div>
		</div>
	</div>
</body>
</html>