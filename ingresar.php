<?php
include_once 'funciones/funciones.php';

?><!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingresá a tu cuenta</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link  rel="stylesheet" href="assets/css/index.css">
  </head>
  <body class="vh-100 d-flex flex-column justify-content-between">
    <header>
		<?php include 'modulos/nav.php'; ?>
	</header>

	<main class="container my-3">
		
		<blockquote class="row my-4">
			<div class="col-6 mx-auto"><?php mostrar_alertas(); ?></div>
		</blockquote>

		<div class="row align-items-center justify-content-center gap-5">
			<div class="col-3">
				<img class="img-fluid" src="assets/img/login.jpg" alt="Ingresá a tu cuenta">
			</div>
			<div class="col-5">
				<form action="crear-cuenta.php" method="POST" id="form_cuenta_crear" class="needs-validation d-none" novalidate>
					<div class="row gy-3">
						<div class="col-12 col-md-6">
							<input id="nombre" name="crear_nombre" type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" required>
							<div class="invalid-feedback">Ingresá tu nombre</div>
						</div>
						<div class="col-12 col-md-6">
							<input id="apellido" name="crear_apellido" type="text" class="form-control" placeholder="Apellido" aria-label="Apellido" required>
							<div class="invalid-feedback">Ingresá tu apellido</div>
						</div>
						<div class="col-12">
							<input id="email" name="crear_email" type="email" class="form-control" placeholder="Correo" aria-label="Correo" required>
							<div class="invalid-feedback">Ingresá tu e-mail</div>
						</div>
						<div class="col-12">
							<input id="password" name="crear_password" type="password" class="form-control" placeholder="Password" aria-label="Password" required>
							<div class="invalid-feedback">Ingresá tu password</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col">
							<button id="btn_submit_crear" type="submit" class="btn btn-primary w-100">Crear Cuenta</button>
						</div>
						<div class="col">
							<button id="btn_volver" type="button" class="btn btn-outline-info w-100">Volver</button>
						</div>
					</div>
				</form>

				<form action="mi-cuenta.php" method="POST" id="form_cuenta_ingresar" class="d-grid needs-validation" novalidate>
					<div class="row gy-3">
						<div class="col-12">
							<input id="email" name="ingresar_email" type="email" class="form-control" placeholder="Correo" aria-label="Correo" required>
							<div class="invalid-feedback">Ingresá tu e-mail</div>
						</div>
						<div class="col-12">
							<input id="password" name="ingresar_password" type="password" class="form-control" placeholder="Password" aria-label="Password" required>
							<div class="invalid-feedback">Ingresá tu password</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col">
							<button id="btn_ingresar" type="submit" class="btn btn-primary w-100">Ingresar</button>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-6">
							<div class="form-check d-flex align-items-center justify-content-center gap-1">
								<input name="recordarme" class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
								<label class="form-check-label" for="flexCheckChecked">
									Recordarme
								</label>
							</div>
						</div>
						<div class="col-6">
							<button id="btn_crear" type="button" class="btn btn-outline-info w-100">¿No tenés cuenta? Crear</button>
						</div>

					</div>
				</form>

			</div>
		</div>
	</main>

	<footer class="mt-3 bg-dark bg-gradient text-light p-4">
		<?php include 'modulos/footer.php'; ?>
	</footer>

	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/login.js"></script>
  </body>
</html>
