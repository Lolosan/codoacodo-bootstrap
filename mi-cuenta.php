<?php
session_start();

include_once 'funciones/funciones.php';
include_once 'clases/db.php';

$usuario_valido = $db->validar_acceso_usuario();

if ( ! $usuario_valido )
{
	$mensaje = [
		'tipo'	=> 'error',
		'texto'	=> 'No existe ese usuario o clave en nuestros registros'
	];
	volver_al_login( $mensaje );
}


$usuarios_totales = $db->get_usuarios_totales();
$usuarios = $db->get_usuarios();

$limit = $db->limite_default();
$offset = $db->offset_default();
$pagina_actual = 1;
$paginas_totales = intval($usuarios_totales / $limit) + 1;

$url = $db->array_url();

if( isset($_GET['pagina']) )
{
	$pagina_actual = $db->limpiar_input( intval($_GET['pagina']) );
}
/*
if( isset( $_GET['limit'] ) )
{
	$limit = $db->limpiar_input( intval($_GET['limit']) );
}
if( isset( $_GET['offset'] ) )
{
	$offset = $db->limpiar_input( intval($_GET['offset']) );
}
*/

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi cuenta</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/sweetalert2.min.css" rel="stylesheet">
	<link href="assets/css/index.css" rel="stylesheet">
  </head>
  <body class="min-vh-100 d-flex flex-column justify-content-between">
    <header>
		<?php include 'modulos/nav.php'; ?>
	</header>

	<main class="container">
		<div class="row my-5">
			<div class="col text-center">
				<h1>Bienvenido al panel de administración de usuarios</h1>
			</div>
		</div>
		<div class="row align-items-center justify-content-center my-5">
			<div class="col-3">
				<button id="crear_usuario" type="button" class="api btn btn-primary w-100">Crear nuevo usuario</button>
			</div>
		</div>
		<div class="row align-items-center justify-content-center my-5">
			<div class="col-6">
				<form id="buscar_usuario" action="#" method="POST" class="input-group flex-nowrap">
					<span class="input-group-text" id="addon-wrapping">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  							<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
						</svg>
					</span>
					<input type="search" id="input_buscar_usuario" name="buscar_usuario" class="form-control" placeholder="Buscar usuario" aria-label="Buscar Usuario" aria-describedby="addon-wrapping">
					<button type="submit" class="btn btn-outline-primary">Buscar</button>
				</form>
			</div>
		</div>
		<div class="row align-items-center justify-content-center">
			<div class="col-8">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Nombre</th>
							<th scope="col">Apellido</th>
							<th scope="col">Correo</th>
							<th scope="col">Acciones</th>
						</tr>
					</thead>
					<tbody id="tbody">
				<?php
					while( $usuario = $usuarios->fetch_array(MYSQLI_ASSOC) )
					{
						?>
						<tr id="fila_<?php echo $usuario['id']; ?>">
							<th id="usuario_<?php echo $usuario['id']; ?>" scope="row"><?php echo $usuario['id']; ?></th>
							<td><?php echo $usuario['nombre']; ?></td>
							<td><?php echo $usuario['apellido']; ?></td>
							<td><?php echo $usuario['correo']; ?></td>
							<td><button id="editar_<?php echo $usuario['id']; ?>" type="button" class="api btn btn-warning">Editar</button></td>
							<td><button id="eliminar_<?php echo $usuario['id']; ?>" type="button" class="api btn btn-danger">Eliminar</button></td>
						</tr>
						<?php
					}

					?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-12 my-5">
				<nav id="paginacion" aria-label="Paginación">
					<ul class="pagination justify-content-center">
						<li class="page-item <?php if( $pagina_actual == 1 ){echo 'disabled';} ?>">
							<a class="page-link" href="<?php echo $url . '?pagina=1&limit=' . $limit . '&offset=0';?>">Primera</a>
						</li>
						<?php
						foreach( range(1, $paginas_totales) as $pagina )
						{
							if( $pagina_actual == $pagina )
							{
								$activa = 'active';
							}else
							{
								$activa = false;
							}

							$usaroffset = ( $offset - $limit ) + ( $limit * $pagina) ;

							$url_link = $url . '?pagina=' . $pagina . '&limit=' . $limit . '&offset=' . $usaroffset;


							?>
							<li class="page-item <?php echo $activa; ?>">
								<a class="page-link" href="<?php echo $url_link ?>"><?php echo $pagina; ?></a>
							</li>

							<?php
						}
						?>
						<li class="page-item <?php if( $pagina_actual == $paginas_totales ){echo 'disabled';} ?>">
							<a class="page-link" href="<?php echo $url . '?pagina=' . $paginas_totales . '&limit=' . $limit . '&offset=' . $usaroffset?>">Última</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</main>



	<footer class="mt-3 bg-dark bg-gradient text-light p-4">
		<?php include 'modulos/footer.php'; ?>
	</footer>

	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/sweetalert2.all.min.js"></script>
	<script src="assets/js/mi-cuenta.js"></script>
	
  </body>
</html>
