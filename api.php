<?php
if( $_SERVER['CONTENT_TYPE'] != 'application/json' )
{
	die;
}

header('Content-Type: application/json; charset=utf-8');
include_once 'funciones/funciones.php';
include_once 'clases/db.php';

$json = file_get_contents('php://input');
$usuario = json_decode( $json, false );

switch( $usuario->accion )
{
	case 'eliminar':
		$resultado = $db->eliminar_usuario( $usuario );
		break;
	case 'editar':
		$resultado = $db->editar_usuario( $usuario );
		break;
	case 'crear':
		$resultado = $db->crear_usuario( $usuario );
		break;
	case 'buscar':
		$resultado = $db->buscar_usuario( $usuario );
		break;
	default:
		$resultado = [
			'resultado'	=> 'error',
			'titulo'	=> 'Eso no se hace',
			'texto' => 'No existe esa acción. Tu dirección IP <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> fue informada al FBI'
		];
		break;

}

echo json_encode( $resultado );
exit();
//die();