<?php
session_start();
include_once 'funciones/funciones.php';
include_once 'clases/db.php';


$cookie = unserialize( $_COOKIE['ingresado']);

//borrar el registro de la db
$db->eliminar_id_sesion_en_db( $cookie['id_sesion'], $cookie['usuario_id'] );

//destruir sesion y cookies
destruir_cookies();

//volver al login
$mensaje = [
	'tipo'	=> 'success',
	'texto'	=> 'Saliste de tu cuenta!'
];
volver_al_login( $mensaje );