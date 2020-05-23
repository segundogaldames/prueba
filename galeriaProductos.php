<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//requerimos la conexion a la base de datos
require('conexion.php');
require('config.php');

//listar las imagenes con los productos asociados que esten en condicion de activo (activo =1)
$sql = $con->query("SELECT p.id, img.nombre as imagen, p.nombre as producto, p.precio FROM imagenes as img INNER JOIN productos as p ON p.id = img.producto_id WHERE p.activo = 1");

$res = $sql->fetchAll();
/*
echo '<pre>';
print_r($res);exit;
echo '</pre>';
*/
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
		<div class="col-md-12 mt-3">
			<h3 class="text-center">Lista de Productos</h3>
			<div class="row">
				<?php foreach($res as $r): ?>
					<div class="col-md-3">
						<a href="verGaleria.php?id=<?php echo $r['id']; ?>">
							<img src="<?php echo BASE_IMG . $r['imagen']; ?>" class="img-responsive" height="245">
						</a>
						<h3 class="text-center" style="color: #17227A">$<?php echo number_format($r['precio'],0,',','.'); ?></h3>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</body>
</html>