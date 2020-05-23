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
	$producto = $con->prepare("SELECT id,nombre,codigo,precio,activo,created_at,updated_at FROM productos WHERE id = ?");
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
		<div class="row">
			<div class="col-md-6 mt-3">
				<?php if(isset($_GET['m'])): ?>
					<p class="alert alert-success">El producto se ha modificado correctamente</p>
				<?php endif; ?>
				<?php if(isset($_GET['img'])): ?>
					<p class="alert alert-success">La imagen se ha agregado correctamente</p>
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
					<tr>
						<th>Activo:</th>
						<td><?php if($res['activo'] == 1): ?> Si <?php else: ?> No <?php endif; ?></td>
					</tr>
					<tr>
						<th>Fecha de creación:</th>
						<td><?php echo $res['created_at']; ?></td>
					</tr>
					<tr>
						<th>Fecha de modificación:</th>
						<td><?php echo $res['updated_at'] ?></td>
					</tr>
				</table>
				<p>
					<a href="editProducto.php?id=<?php echo $res['id']; ?>" class="btn btn-link">Editar</a>
					<a href="productos.php" class="btn btn-link">Volver</a>
					<a href="#" class="btn btn-primary">Eliminar Producto</a>
					<a href="addImagen.php?id=<?php echo $res['id'];?>" class="btn btn-success">Agregar Imagen</a>
				</p>
			</div>
			<div class="col-md-6 mt-3">
				<?php
					//traer todas las imagenes de un producto
					$sql = $con->prepare("SELECT id, titulo, descripcion, nombre, created_at, updated_at FROM imagenes WHERE producto_id = ?");
					$sql->bindParam(1, $id);
					$sql->execute();

					$res = $sql->fetchAll();
					if (!$res):
				?>
					<p class="text-info">No hay imágenes disponibles... Agréguelas a este producto</p>

				<?php else:
					foreach ($res as $r):
				?>
					<div class="col-md-12">
						<h4><?php echo $r['titulo']; ?></h4>
						<p class="text-justify"><?php echo $r['descripcion']; ?></p>
						<img src="<?php echo BASE_IMG . $r['nombre']; ?>" class="img-responsive">
						<p class="text-info mt-5">
							Fecha de registro: <?php echo $r['created_at']; ?><br>
							Fecha de modificación: <?php echo $r['updated_at']; ?>
						</p>
					</div>
				<?php endforeach;endif; ?>
			</div>
		</div>
	</div>
</body>
</html>