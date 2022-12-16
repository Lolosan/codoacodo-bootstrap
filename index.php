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
		<?php include 'modulos/banner.php'; ?>
	</header>

	<main id="oradores" class="container">
		<div class="row">
			<div class="col text-center m-3">
				<p class="mb-0">CONOCÉ A LOS</p>
				<h1>ORADORES</h1>
			</div>
		</div>
		<div class="row row-cols-1 row-cols-md-3 g-4">
			<div class="col">
				<div class="card h-100">
					<img src="assets/img/steve.jpg" class="card-img-top" alt="Steve Jobs">
					<div class="card-body">
						<span class="badge bg-warning text-dark">Javascript</span>
						<span class="badge bg-info">React</span>
						<h5 class="card-title mt-1">Steve Jobs</h5>
						<p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nesciunt, id optio perspiciatis culpa necessitatibus ut est nam sapiente voluptas nemo alias assumenda, voluptatibus error porro minima animi sit sequi odio.</p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card h-100">
					<img src="assets/img/bill.jpg" class="card-img-top" alt="Bill Gates">
					<div class="card-body">
						<span class="badge bg-warning text-dark">Javascript</span>
						<span class="badge bg-info">React</span>
						<h5 class="card-title mt-1">Bill Gates</h5>
						<p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo quod, excepturi repellendus quos quidem tempore eaque maxime aliquam laudantium facere rerum quia officiis voluptas quam ipsum. Qui sint deleniti soluta.</p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card h-100">
					<img src="assets/img/ada.jpeg" class="card-img-top" alt="Ada Lovelace">
					<div class="card-body">
						<span class="badge bg-secondary">Negocios</span>
						<span class="badge bg-danger">Startups</span>
						<h5 class="card-title mt-1">Ada Lovelace</h5>
						<p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dignissimos adipisci, esse ipsam, in quod mollitia officia impedit et perspiciatis provident vel minima repudiandae doloremque nemo, nobis hic harum perferendis sapiente.</p>
					</div>
				</div>
			</div>
		</div>
		
	</main>

	<section id="lugar">
		<div class="card my-3">
			<div class="row g-0">
				<div class="col-md-6">
					<img src="assets/img/honolulu.jpg" class="img-fluid" alt="Bs As Octubre">
				</div>
				<div class="col-md-6">
					<div class="card-body text-light bg-dark h-100">
						<h5 class="card-title">Bs As - Octubre</h5>
						<p class="card-text">Buenos Aires es la provincia y localidad más grande del estado de Argentina, en los Estados Unidos. Honolulu es la más sureña de entre las principales ciudades estadounidenses. Aunque el nombre de Honolulu se refiere al área urbana en la costa sureste de la isla de Oahu, la ciudad y el condado de Honolulu han formado una ciudad condado consolidada que cubre toda la ciudad (aproximadamente 600 km<sup>2</sup> de superficie).</p>
						<button type="button" class="btn btn-outline-light">Conocé más</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="sumate" class="container">
		<div class="row">
			<div class="col text-center mt-3">
				<p class="mb-0">CONVIÉRTETE EN UN</p>
				<h1>ORADOR</h1>
			</div>
		</div>
		<div class="row">
			<div class="col text-center">
				<p>Anótate como orador para dar una <u>charla ignite</u>. Cuéntanos de qué quieres hablar</p>
			</div>
		</div>

		<div class="row">
			<div class="col col-lg-10 col-xl-8 mx-auto">
				<form class="d-grid">
					<div class="row gy-2">
						<div class="col-12 col-md-6">
							<input type="text" class="form-control" placeholder="Nombre" aria-label="Nombre">
						</div>
						<div class="col-12 col-md-6">
							<input type="text" class="form-control" placeholder="Apellido" aria-label="Apellido">
						</div>
					</div>
					<div class="mt-3">
						<textarea class="form-control fs-4" placeholder="Sobre qué quieres hablar?" id="floatingTextarea2" rows="5" aria-describedby="ayudatextarea"></textarea>
						<div id="ayudatextarea" class="form-text">
							Recuerda incluir un título para tu charla
						</div>
					</div>
					<button type="submit" class="btn btn-success mt-3">Enviar</button>
				</form>
			</div>
		</div>
	</section>

	<footer class="mt-3 bg-dark bg-gradient text-light p-4">
		<?php include 'modulos/footer.php'; ?>
	</footer>

	<script src="assets/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
