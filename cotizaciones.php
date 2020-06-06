<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

//se requiere el codigo del archivo conexion.php
require('conexion.php');
//consulta a la tabla productos, traeremos todos los campos y registros de la tabla productos
$cotizaciones = $con->query("SELECT c.id, p.nombre as producto, c.cantidad, c.created_at, u.nombre as usuario FROM cotizaciones c INNER JOIN productos p ON c.producto_id = p.id INNER JOIN usuarios u ON c.usuario_id = u.id ORDER BY c.created_at DESC");

//especificar que necesitamos todos los datos
$res = $cotizaciones->fetchAll();

//print_r($res);exit;

//comprobar que los datos estan disponibles
//print_r($res);

if(isset($_SESSION['autenticado']) && ($_SESSION['rol'] <= 2)):
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
		<!--llamada a menu de navegacion-->
		<?php include('header.php') ?>
		<div class="col-md-8 mt-3">
			<table class="table table-hover table-bordered">
				<!--Declaracion de las columnas de la tabla con sus nombres-->
				<tr>
					<thead class="thead-light text-center">
						<th>Id</th>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Cliente</th>
						<th>Fecha</th>
					</thead>
				</tr>
				<?php foreach($res as $r): ?>
					<tr>
						<td><?php echo $r['id']; ?></td>
						<td>
							<?php echo $r['producto']; ?></a>
						</td>
						<td><?php echo $r['cantidad']; ?></td>
						<td><?php echo $r['usuario']; ?></td>
						<td>
							<?php
								$fecha = new DateTime($r['created_at']);
								echo $fecha->format('d-m-Y H:i:s');
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</body>
</html>
<?php
	else:
		header('Location: galeriaProductos.php');

	endif;
?>