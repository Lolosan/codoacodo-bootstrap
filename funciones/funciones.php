<?php

/**
 * ----------------------------------------------------------------------------
 * Funciones sueltas
 * ----------------------------------------------------------------------------
**/

function mostrar_alertas()
{
	if( isset($_GET['tipo']) && isset($_GET['mensaje']) ) 
	{
		switch ( $_GET['tipo'] )
		{
			case 'error':
				?>
				<div class="alert alert-danger d-flex align-items-center gap-3" role="alert">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
						<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
					</svg>
  					<div><?php echo $_GET['mensaje']; ?></div>
				</div>
				<?php
				break;
			case 'success':
				?>
				<div class="alert alert-success d-flex align-items-center gap-3" role="alert">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
  						<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
					</svg>
  					<div><?php echo $_GET['mensaje']; ?></div>
				</div>
				<?php
				break;
			
			default:
				//sin usar, pero defaulteamos a info
				?>
				<div class="alert alert-primary d-flex align-items-center gap-3" role="alert">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
						<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
					</svg>
  					<div><?php echo $_GET['mensaje']; ?></div>
				</div>
				<?php
				break;
		}
	}
	return;
}


// mmensaje es un array tipo => mensaje
function volver_al_login( $mensaje )
{
	$url = "Location: ingresar.php";

	if( $mensaje != false )
	{
		$url .= '?tipo=' . $mensaje['tipo'] . '&mensaje=' . $mensaje['texto'];
	}
	
	header( $url );
	exit();
}

function destruir_cookies()
{
	setcookie(session_name(), '', -1, '/'); 
	setcookie('ingresado', '', -1, '/'); 
	session_destroy();

	return;
}

function url_pura()
{
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	{
		$protocolo = "https://";
	}else
	{
		$protocolo = "http://";
	}
	$dominio = $_SERVER['HTTP_HOST'];

	$uri = explode( '?', $_SERVER['REQUEST_URI'] );

	$uri_pura = $protocolo . $dominio . $uri[0];

	return $uri_pura;
}

