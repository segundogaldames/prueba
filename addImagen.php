<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

//requerimos la conexion a la base de datos
require('conexion.php');
require('config.php');

//print_r($_GET);exit;

if (isset($_GET['id_img'])) {
	$id = (int) $_GET['id_img'];
	//print_r($id);exit;

	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
		//print_r($_POST);
		$titulo = trim(strip_tags($_POST['titulo']));
		$descripcion = trim(strip_tags($_POST['descripcion']));
		$portada = (int) $_POST['portada'];
		$nom_imagen = $_FILES['imagen']['name'];
		$tmp_name = $_FILES['imagen']['tmp_name'];

		//print_r($tmp_name);exit;
		if (!$titulo) {
			$mensaje = 'Ingrese el título de la imagen';
		}elseif(!$portada){
			$mensaje = 'Seleccione una opción de portada';
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
					$sql = $con->prepare("INSERT INTO imagenes VALUES(null, ?, ?, ?, ?, ?, now(), now())");
					$sql->bindParam(1, $titulo);
					$sql->bindParam(2, $descripcion);
					$sql->bindParam(3, $id);
					$sql->bindParam(4, $nom_imagen);
					$sql->bindParam(5, $portada);
					$sql->execute();

					$row = $sql->rowCount();

					if ($row) {
						$_SESSION['success'] = 'La imagen se ha registrado correctamente';
						header('Location: verProducto.php?id=' . $id);
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
if(isset($_SESSION['autenticado']) && ($_SESSION['rol'] == 1)):
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
					<label>Imagen de portada?</label>
					<select name="portada" class="form-control">
						<option value="">Seleccione...</option>
						<option value="1">Si</option>
						<option value="2">No</option>
					</select>
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
<?php
else:
	header('Location: galeriaProductos.php');
endif;
?>