<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//se requiere el codigo del archivo conexion.php
require('conexion.php');

// validar la presencia de la variable id que viene de productos.php
if (isset($_GET['id'])) {
	//parseo o conversion de una variable en un entero
	$id = (int) $_GET['id'];

	//consulta a la tabla roles, traeremos todos los campos y registros de la tabla roles asociados a un id
	$rol = $con->prepare("SELECT id,nombre FROM roles WHERE id = ?");
	$rol->bindParam(1, $id); //sanitizando la variable

	//ejecutar la consulta o traemos los datos efectivamente
	$rol->execute();

	//especificar que necesitamos todos los datos
	$res = $rol->fetch();


	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
		//recuperamos los datos
		$nombre = trim(strip_tags($_POST['nombre']));

		if (!$nombre) {
			$mensaje = 'Ingrese el nombre del rol';
		}else{
			//enviar los datos a la base de datos para actualizacion
			$sql = $con->prepare("UPDATE roles SET nombre = ?, updated_at = now() WHERE id = ?");
			$sql->bindParam(1, $nombre);
			$sql->bindParam(2, $id);
			$sql->execute();

			//numero de registros ingresados
			$row = $sql->rowCount();
			if ($row) {
				$msg = 'ok';
				header('Location: verRol.php?id=' . $id . '&m=' . $msg);
			}else{
				$mensaje = 'El rol no se ha modificado';
			}
		}
	}
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
		<div class="col-md-6 mt-3">
			<h3>Editar Rol <?php echo $res['nombre']; ?></h3>
			<?php if(isset($mensaje)): ?>
				<p class="alert alert-danger"><?php echo $mensaje; ?></p>
			<?php endif; ?>
			<form action="" method="post">
				<div class="form-group">
					<label>Nombre rol</label>
					<input type="text" name="nombre" placeholder="Nombre del rol" class="form-control" value="<?php echo $res['nombre']; ?>">
				</div>
				<div class="form-group">
					<input type="hidden" name="enviar" value="si">
					<button type="submit" class="btn btn-success">Modificar</button>
					<a href="roles.php" class="btn btn-link">Volver</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>