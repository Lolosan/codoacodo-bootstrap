<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a class="navbar-brand" href="index.php">
			<img src="assets/img/codoacodo.png" alt="Codo a Codo" width="105" height="60" class="d-inline-block align-text-middle">
			Conf Bs As
		</a>
		
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="index.php#carouselExampleCaptions">La conferencia</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php#oradores">Los oradores</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php#lugar">El lugar y la fecha</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php#sumate">Conviértete en orador</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-success" href="tickets.php">Comprar tickets</a>
				</li>
				<?php 
				if( isset( $_COOKIE['ingresado'] ) )
				{
					$cookie = unserialize( $_COOKIE['ingresado'] );
					
					?>
					<li class="nav-item">
						<a class="nav-link text-primary" href="mi-cuenta.php">Hola <?php echo $cookie['nombre']; ?>!</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-warning" href="cerrar-sesion.php">Cerrar sesión</a>
					</li>

					<?php
				}else
				{
					?>
					<li class="nav-item">
						<a class="nav-link text-primary" href="ingresar.php">Ingresar / Registrarte</a>
					</li>
					<?php
				}

				?>
			</ul>
		</div>
	</div>
</nav>
