<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//requerimos la conexion a la base de datos
require('conexion.php');
require('config.php');

//echo BASE_IMG;exit;

if (isset($_GET['id'])) {
	$id = (int) $_GET['id'];

	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
		$titulo = trim(strip_tags($_POST['titulo']));
		$descripcion = trim(strip_tags($_POST['descripcion']));
		$nom_imagen = $_FILES['imagen']['name'];
		$tmp_name = $_FILES['imagen']['tmp_name'];

		//print_r($tmp_name);exit;
		if (!$titulo) {
			$mensaje = 'Ingrese el título de la imagen';
		}elseif (!$nom_imagen) {
			$mensaje = 'Seleccione una imagen';
		}else{
			//verificamos que la imagen no exista previamente
			$sql = $con->prepare("SELECT id FROM imagenes WHERE nombre = ?");
			$sql->bindParam(1, $nom_imagen);
			$sql->execute();

			$res = $sql->fetch();

			if ($res) {
				$mensaje = 'La imagen seleccionada ya existe';
			}else{
				//guardar la imagen en el directorio escogido
				$upload = $_SERVER['DOCUMENT_ROOT'] . '/prueba/img/';
				$fichero_subido = $upload . basename($_FILES['imagen']['name']);
				//print_r($fichero_subido);exit;
				if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
					//guardar los datos en la base de datos
					$sql = $con->prepare("INSERT INTO imagenes VALUES(null, ?, ?, ?, ?, now(), now())");
					$sql->bindParam(1, $titulo);
					$sql->bindParam(2, $descripcion);
					$sql->bindParam(3, $id);
					$sql->bindParam(4, $nom_imagen);
					$sql->execute();

					$row = $sql->rowCount();

					if ($row) {
						$msg = 'ok';
						header('Location: verProducto.php?id=' . $id . '&img=' . $msg );
					}else{
						$mensaje = 'La imagen no se ha podido registrar';
					}
				}else{
					$mensaje = 'La imagen no se ha podido subir';
				}
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Agregar Imagen</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('header.php'); ?>
		<div class="col-md-6 mt-3">
			<h3>Nueva Imagen</h3>

			<?php if(isset($mensaje)): ?>
				<p class="alert alert-danger"><?php echo $mensaje; ?></p>
			<?php endif; ?>

			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Titulo</label>
					<input type="text" name="titulo" placeholder="Título de la imagen" class="form-control" value="<?php echo @($titulo); ?>">
				</div>
				<div class="form-group">
					<label>Descripción</label>
					<textarea name="descripcion" class="form-control" placeholder="Descripción de la imagen" cols="4" style="resize: none;">
						<?php echo @($descripcion); ?>
					</textarea>
				</div>
				<div class="form-group">
					<label>Imagen</label>
					<input type="file" name="imagen" placeholder="Seleccione Imagen" class="form-control">
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