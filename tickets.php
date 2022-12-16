<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap: Trabajo práctico integrador</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link  rel="stylesheet" href="assets/css/index.css">
  </head>
  <body>
    <header>
		<?php include 'modulos/nav.php'; ?>
	</header>

	<main id="info_tickets" class="container">
		<div class="row">
			<div class="col col-7 mx-auto">
				<div class="row my-4">
					<div class="col">
						<div class="card h-100 border-primary">
							<div class="card-body text-center py-4">
								<h3 class="card-title">Estudiante</h3>
								<p class="card-text fs-5">Tienen un descuento</p>
								<p class="card-text"><strong>80%</strong></p>
								<p class="card-text"><small class="text-muted">* Presentar documentación</small></p>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100 border-success">
							<div class="card-body text-center py-4">
								<h3 class="card-title">Trainee</h3>
								<p class="card-text fs-5">Tienen un descuento</p>
								<p class="card-text"><strong>50%</strong></p>
								<p class="card-text"><small class="text-muted">* Presentar documentación</small></p>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card h-100 border-warning">
							<div class="card-body text-center py-4">
								<h3 class="card-title">Junior</h3>
								<p class="card-text fs-5">Tienen un descuento</p>
								<p class="card-text"><strong>15%</strong></p>
								<p class="card-text"><small class="text-muted">* Presentar documentación</small></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col text-uppercase text-center">
				<p class="mb-0">venta</p>
				<h2>Valor de Ticket: $200</h2>
			</div>
		</div>
	</main>

	<section id="comprar" class="container mt-3">
		<div class="row">
			<div class="col col-lg-7 mx-auto">
				<form id="formularioCompra" class="d-grid needs-validation" novalidate>
					<div class="row gy-2">
						<div class="col-12 col-md-6">
							<input id="nombre" type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" required>
							<div class="invalid-feedback">Ingresá tu nombre</div>
						</div>
						<div class="col-12 col-md-6">
							<input id="apellido" type="text" class="form-control" placeholder="Apellido" aria-label="Apellido" required>
							<div class="invalid-feedback">Ingresá tu apellido</div>
						</div>
						<div class="col-12">
							<input id="email" type="email" class="form-control" placeholder="Correo" aria-label="Correo" required>
							<div class="invalid-feedback">Ingresá tu e-mail</div>
						</div>
					</div>
					<div class="row gy-2 mt-2">
						<div class="col-12 col-md-6">
							<label for="cantidad" class="form-label">Cantidad de entradas</label>
							<input type="text" inputmode="numeric" pattern="[0-9]" class="form-control" id="cantidad" placeholder="Cantidad" required>
							<div class="invalid-feedback">Ingresá la cantidad de entradas requeridas</div>
						</div>
						<div class="col-12 col-md-6">
							<label for="categoria" class="form-label">Categoría</label>
							<select id="categoria" class="form-select" aria-label="Default select example" required>
								<option selected disabled value="">Elegí tu categoría</option>
								<option value="1">Estudiante</option>
								<option value="2">Trainee</option>
								<option value="3">Junior</option>
							</select>
							<div class="invalid-feedback">Elegí tu categoría</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-12">
							<div id="totalPagar" class="alert alert-primary mb-0 d-none" role="alert">Total a pagar: $</div>
						</div>
					</div>
	
					<div class="row mt-4">
						<div class="col-6">
							<button id="btn_borrar" type="reset" class="btn btn-success w-100">Borrar</button>
						</div>
						<div class="col-6">
							<button id="btn_resumen" type="submit" class="btn btn-success w-100">Resumen</button>
						</div>
					</div>
					
					
				</form>
			</div>
		</div>
	</section>

	<footer class="mt-3 bg-dark bg-gradient text-light p-4">
		<?php include 'modulos/footer.php'; ?>
	</footer>

	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/tickets.js"></script>

  </body>
</html>
