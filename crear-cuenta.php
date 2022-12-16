<?php

include_once 'funciones/funciones.php';
include_once 'clases/db.php';

$usuario_creado = $db->crear_acceso_usuario();

exit();
if ( ! $usuario_valido )
{
	$mensaje = [
		'tipo'	=> 'error',
		'texto'	=> 'No existe ese usuario o clave en nuestros registros'
	];
	volver_al_login( $mensaje );
}


?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi cuenta</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link  rel="stylesheet" href="assets/css/index.css">
  </head>
  <body class="min-vh-100 d-flex flex-column justify-content-between">
    <header>
		<?php include 'modulos/nav.php'; ?>
	</header>

	<main class="container">
		<div class="row my-5">
			<div class="col">
				<h1>Bienvenido al panel de administración de usuarios</h1>
			</div>
		</div>
		<div class="row align-items-center justify-content-center">
			<div class="col-6">
				<table class="table table-striped">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Nombre</th>
							<th scope="col">Apellido</th>
							<th scope="col">Correo</th>
						</tr>
					</thead>
					<tbody>
				<?php
					//while( $usuario = mysqli_fetch_array($consulta) )
					$usuarios = $db->get_usuarios();
					while( $usuario = $usuarios->fetch_array(MYSQLI_ASSOC) )
					{
						?>
						<tr>
							<th scope="row"><?php echo $usuario['id']; ?></th>
							<td><?php echo $usuario['nombre']; ?></td>
							<td><?php echo $usuario['apellido']; ?></td>
							<td><?php echo $usuario['correo']; ?></td>
						</tr>
						<?php
					}

					?>
					</tbody>
				</table>
			</div>
		</div>
	</main>



	<footer class="mt-3 bg-dark bg-gradient text-light p-4">
		<?php include 'modulos/footer.php'; ?>
	</footer>

	<script src="assets/js/bootstrap.bundle.min.js"></script>
	
  </body>
</html>
