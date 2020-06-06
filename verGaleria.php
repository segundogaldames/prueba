<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

//se requiere el codigo del archivo conexion.php
require('conexion.php');
require('config.php');

// validar la presencia de la variable id que viene de productos.php
if (isset($_GET['id'])) {
	//parseo o conversion de una variable en un entero
	$id = (int) $_GET['id'];

	//consulta a la tabla productos por id
	$producto = $con->prepare("SELECT id, nombre, precio FROM productos WHERE id = ?");
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

	if(isset($_POST['enviar']) && $_POST['enviar'] == 'si'){
		$cantidad = (int) $_POST['cantidad'];
		$prod = (int) $_POST['producto'];

		//print_r($_POST);exit;
		
		if(!$cantidad){
			$mensaje = 'Seleccione una cantidad';
		}elseif(!$prod){
			$mensaje = 'El producto no ha sido recuperado';
		}else{
			//verificar que el producto exista
			$sql = $con->prepare("SELECT id FROM productos WHERE id = ?");
			$sql->bindParam(1, $prod);
			$sql->execute();

			$product = $sql->fetch();

			if($product){
			//proceso de registro de cotizacion
				$sql = $con->prepare("INSERT INTO cotizaciones VALUES(null, ?, ?, ?, now(), now())");
				$sql->bindParam(1, $prod);
				$sql->bindParam(2, $cantidad);
				$sql->bindParam(3, $_SESSION['id']);
				$sql->execute();

				$row = $sql->rowCount();

				if($row){
					$msg = 'ok';
					//header redirecciona a otro sitio
					header('Location: galeriaProductos.php?m=' . $msg);
				}else{
					$mensaje = 'Su cotización no ha podido ser registrada... intente mas tarde';
				}
			//notificamos el proceso
			}else{
				$mensaje = 'El producto no ha sido recuperado';
			}
		}
	}
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
				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>
				
				<?php if(isset($_SESSION['autenticado'])): ?>
					<p>
						<form action="" method="post" class="form-inline" role="form">
							<div class="form-group mb-2 col-6">
								<select name="cantidad" class="form-control-plaintext">
									<option value="">Cantidad...</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</div>
							<div class="form-group col-6">
								<input type="hidden" name="producto" value="<?php echo $res['id']; ?>">
								<input type="hidden" name="enviar" value="si">
								<button type="submit" class="btn btn-primary">Cotizar</button>
							</div>
						</form>
					</p>
				<?php else: ?>
					<p class="text-info">
						Debe iniciar session o registrarse para cotizar este producto
						<a href="login.php" class="btn btn-link">Iniciar Session</a> o 
						<a href="#" class="btn btn-link">Registrarse</a>
					</p>
				<?php endif; ?>
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