<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

//requerimos la conexion a la base de datos
require('conexion.php');

if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
	//recuperamos los datos
	$nombre = trim(strip_tags($_POST['nombre']));
	$codigo = trim(strip_tags($_POST['codigo']));

	//esta variable se parsea u obliga a ser un entero
	$precio = (int) $_POST['precio'];

	if (!$nombre) {
		$mensaje = 'Ingrese el nombre del producto';
	}elseif (!$codigo) {
		$mensaje = 'Ingrese el código del producto';
	}else{
		//verificar que no haya otro producto con el mismo codigo
		$res = $con->prepare("SELECT id FROM productos WHERE codigo = ?");
		$res->bindParam(1, $codigo);
		$res->execute();
		$cons = $res->fetch();

		if ($cons) {
			$mensaje = 'El producto ingresado ya existe... intentelo nuevamente';
		}else{
			//enviar los datos a la base de datos
			// activo = 1 y no activo = 2
			$sql = $con->prepare("INSERT INTO productos VALUES(null, ?, ?, ?, 1, now(),now())");
			$sql->bindParam(1, $nombre);
			$sql->bindParam(2, $codigo);
			$sql->bindParam(3, $precio);
			$sql->execute();

			//numero de registros ingresados
			$row = $sql->rowCount();
			if ($row) {
				$_SESSION['success'] = 'El producto se ha registrado correctamente';
				header('Location: productos.php');
			}else{
				$mensaje = 'El producto no se ha registrado';
			}
		}
	}
}
if(isset($_SESSION['autenticado']) && ($_SESSION['rol'] == 1)):
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crear Producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('header.php'); ?>
		<div class="col-md-6 mt-3">
			<h3>Nuevo Producto</h3>

			<?php if(isset($mensaje)): ?>
				<p class="alert alert-danger"><?php echo $mensaje; ?></p>
			<?php endif; ?>

			<form action="" method="post">
				<div class="form-group">
					<label>Nombre producto</label>
					<input type="text" name="nombre" placeholder="Nombre del producto" class="form-control" value="<?php echo @($nombre); ?>">
				</div>
				<div class="form-group">
					<label>Código producto</label>
					<input type="text" name="codigo" placeholder="Código del producto" class="form-control" value="<?php echo @($codigo); ?>">
				</div>
				<div class="form-group">
					<label>Precio producto (CLP)</label>
					<input type="text" name="precio" placeholder="Precio del producto solo números" class="form-control" value="<?php echo @($precio); ?>">
				</div>
				<div class="form-group">
					<input type="hidden" name="enviar" value="si">
					<button type="submit" class="btn btn-success">Guardar</button>
					<a href="productos.php" class="btn btn-link">Volver</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
<?php
else:
	header('Location: galeriaProductos.php');
endif;
?>