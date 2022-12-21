<?php
$url_pura = url_pura();

$limit = $db->limite_default();
$offset = $db->offset_default();
$pagina_actual = 1;
$paginas_totales = intval($usuarios_totales / $limit) + 1;
$url_anterior = '#';
$url_siguiente = '#';

if( isset($_GET['pagina']) )
{
	$pagina_actual = $db->limpiar_input( intval($_GET['pagina']) );
}

$paginacion = array();

// primero armar array
foreach( range(1, $paginas_totales) as $pagina )
{
	$usaroffset = ( $offset - $limit ) + ( $limit * $pagina);

	$url_link = $url_pura . '?pagina=' . $pagina . '&limit=' . $limit . '&offset=' . $usaroffset;

	// desactivar el de pagina actual
	if( $pagina_actual == $pagina )
	{
		$activa = 'active';
	}else
	{
		$activa = false;
	}

	//la pagina anterior a la actual
	if( ($pagina_actual - 1 ) == $pagina )
	{
		$url_anterior = $url_link;
	}

	//la pagina siguiente a la actual
	if( ($pagina_actual + 1) == $pagina )
	{
		$url_siguiente = $url_link;
	}

	$paginacion[$pagina] = '<li class="page-item '. $activa .'">';
	$paginacion[$pagina] .= 	'<a class="page-link" href="'. $url_link .'">'. $pagina .'</a>';
	$paginacion[$pagina] .= '</li>';
}


?><nav id="paginacion" aria-label="Paginación">
	<ul class="pagination justify-content-center">
		<li class="page-item <?php if( $pagina_actual == 1 ){echo 'disabled';} ?>">
			<a class="page-link" href="<?php echo $url_anterior;?>">Anterior</a>
		</li>
		<?php
		foreach( $paginacion as $numero_paginacion )
		{
			echo $numero_paginacion;
		}
		?>
		<li class="page-item <?php if( $pagina_actual == $paginas_totales ){echo 'disabled';} ?>">
			<a class="page-link" href="<?php echo $url_siguiente;?>">Siguiente</a>
		</li>
	</ul>
</nav>
