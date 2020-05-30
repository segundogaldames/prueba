<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//requerimos la conexion a la base de datos
require('conexion.php');
require('config.php');

//echo BASE_IMG;exit;
//
//print_r($_GET);exit;

if (isset($_GET['id_img'])) {
	
	$id = (int) $_GET['id_img'];

	$sql = $con->prepare("SELECT i.id, i.titulo, i.descripcion, i.producto_id, i.nombre as imagen, i.portada, p.nombre as producto FROM imagenes as i INNER JOIN productos p ON i.producto_id = p.id WHERE i.id = ?");
	$sql->bindParam(1, $id);
	$sql->execute();

	$img = $sql->fetch();
	//print_r($img);exit;


	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
	
		$titulo = trim(strip_tags($_POST['titulo']));
		$descripcion = trim(strip_tags($_POST['descripcion']));
		$producto = (int) $_POST['producto'];
		$portada = (int) $_POST['portada'];
		$nom_imagen = $_FILES['imagen']['name'];
		$tmp_name = $_FILES['imagen']['tmp_name'];

		//print_r($_POST);

		//print_r($tmp_name);exit;
		if (!$titulo) {
			$mensaje = 'Ingrese el título de la imagen';
		}elseif (!$producto) {
			$mensaje = 'Seleccione el producto de la imagen';
		}elseif(!$portada){
			$mensaje = 'Seleccione una opción de portada';
		}else{
			//verificamos que la imagen no exista previamente
			
			//guardar la imagen en el directorio escogido
			$upload = $_SERVER['DOCUMENT_ROOT'] . '/prueba/img/';
			$fichero_subido = $upload . basename($_FILES['imagen']['name']);
			//print_r($fichero_subido);exit;
			//
			
			if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
					//guardar los datos en la base de datos

				$sql = $con->prepare("UPDATE imagenes SET titulo = ?, descripcion = ?, producto_id = ?, nombre = ?, portada = ?, updated_at = now() WHERE id = ?");
				$sql->bindParam(1, $titulo);
				$sql->bindParam(2, $descripcion);
				$sql->bindParam(3, $producto);
				$sql->bindParam(4, $nom_imagen);
				$sql->bindParam(5, $portada);
				$sql->bindParam(6, $id);
				$sql->execute();

				$row = $sql->rowCount();
				
				if ($row) {
					$msg = 'ok';
					header('Location: verProducto.php?id=' . $producto . '&img=' . $msg );
				}else{
					$mensaje = 'La imagen no se ha podido modificar';
					}
			}else{
				$mensaje = 'La imagen no se ha podido subir';
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
			<h3>Editar Imagen</h3>

			<?php if(isset($mensaje)): ?>
				<p class="alert alert-danger"><?php echo $mensaje; ?></p>
			<?php endif; ?>

			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Titulo</label>
					<input type="text" name="titulo" placeholder="Título de la imagen" class="form-control" value="<?php echo $img['titulo']; ?>">
				</div>
				<div class="form-group">
					<label>Descripción</label>
					<textarea name="descripcion" class="form-control" placeholder="Descripción de la imagen" cols="4" style="resize: none;">
						<?php echo $img['descripcion']; ?>
					</textarea>
				</div>
				<div class="form-group">
					<label>Producto</label>
					<select name="producto" class="form-control">
						<option value="<?php echo $img['producto_id'] ?>"><?php echo $img['producto'] ?></option>
						<?php 
							$cons = $con->query("SELECT id, nombre FROM productos ORDER BY nombre");
							$productos = $cons->fetchAll();

							foreach($productos as $producto):
						?>
							<option value="<?php echo $producto['id'] ?>"><?php echo $producto['nombre'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label>Imagen de portada?</label>
					<select name="portada" class="form-control">
						<option value="<?php echo $img['portada'] ?>">
							<?php if($img['portada']==1): ?> Si <?php else: ?> No <?php endif; ?>						
						</option>
						<option value="1">Si</option>
						<option value="2">No</option>
					</select>
				</div>
				<div class="form-group">
					<label>Imagen:
						<img src="<?php echo BASE_IMG . $img['imagen']; ?>" width="100">	
					</label>
				</div>
				<div class="form-group">
					<label>Imagen</label>
					<input type="file" name="imagen" placeholder="Seleccione Imagen" class="form-control">
				</div>
				<div class="form-group">
					<input type="hidden" name="enviar" value="si">
					<button type="submit" class="btn btn-success">Editar</button>
					<a href="verProducto.php?id.php" class="btn btn-link">Volver</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>