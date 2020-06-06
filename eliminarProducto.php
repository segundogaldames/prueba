<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//se requiere el codigo del archivo conexion.php
require('conexion.php');

if (isset($_GET['id'])) {
	$id = (int) $_GET['id'];

	//consultamos por la existencia del producto
	$sql = $con->prepare("SELECT id FROM productos WHERE id = ?");
	$sql->bindParam(1, $id);
	$sql->execute();

	$res = $sql->fetch();

	if($res){
		//procedemos a eliminar el dato
		$cons = $con->prepare("DELETE FROM productos WHERE id = ?");
		$cons->bindParam(1, $id);
		$cons->execute();

		$row = $cons->rowCount();

		if ($row) {
			$_SESSION['success'] = 'El producto se ha eliminado correctamente';
			header('Location: productos.php');
		}else{
			$_SESSION['danger'] = 'El producto no se ha eliminado';
			header('Location: productos.php');
		}
	}else{
		//alerta de que el dato no existe
		$_SESSION['danger'] = 'El producto no existe';
		header('Location: productos.php');
	}
}