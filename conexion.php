<?php
//para conectar una base de datos en mysql
//ayuda a validar que un proceso se realiza correctamente
try{
	//crear un objeto de la clase PDO
	$con = new PDO('mysql:host=localhost;dbname=prueba', 'root', 'root');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//print_r($con);
}catch(PDOException $e){
    echo "ERROR: " . $e->getMessage();
}
