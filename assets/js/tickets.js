let btn_resumen = document.getElementById('btn_resumen');
let btn_borrar = document.getElementById('btn_borrar');
let formularioCompra = document.getElementById('formularioCompra');

formularioCompra.addEventListener('submit', calcularPrecio, false);
btn_borrar.addEventListener('click', borrarPrecioFinal, false);

function calcularPrecio(event)
{
	//validador bootstrap
	if (!event.target.checkValidity())
	{
		event.preventDefault();
		event.stopPropagation();
	}

	//validador bootstrap
	event.target.classList.add('was-validated');


	let inputCantidad = document.getElementById('cantidad');
	let cantidad = parseInt( inputCantidad.value );
	let inputCategoria = document.getElementById('categoria');
	let categoria = parseInt( inputCategoria.value );
	let precioFinal = 0;

	if( isNaN(cantidad) || cantidad < 1 )
	{
		mostrarPrecioFinal( 'Falta ingresar cuántas entradas' );
		return;
	}

	precioFinal = procesarPrecio( cantidad, categoria );
	if( precioFinal == false )
	{
		mostrarPrecioFinal( 'Tenés que elegir tu categoría' );
		return;
	}

	mostrarPrecioFinal( precioFinal );
	return;
}

function mostrarPrecioFinal( precioFinal )
{
	let totalPagar = document.getElementById('totalPagar');

	if( isNaN( precioFinal ) )
	{
		totalPagar.classList.replace('alert-primary', 'alert-danger');
		totalPagar.textContent = precioFinal;
	}else
	{
		totalPagar.classList.replace('alert-danger', 'alert-primary');
		totalPagar.textContent = 'Total a pagar: $' + Math.ceil( precioFinal );
	}
	
	totalPagar.classList.remove('d-none');
	return;
}

function procesarPrecio( cantidad, categoriaElegida )
{
	let valorTicket = 200;
	let descuentoCat1 = 80;
	let descuentoCat2 = 50;
	let descuentoCat3 = 15;
	let precioFinal = 0;

	switch(categoriaElegida)
	{
		case 1:
			precioFinal = (valorTicket * cantidad) * prepararPorcentaje(descuentoCat1);
			break;
		case 2:
			precioFinal = (valorTicket * cantidad) * prepararPorcentaje(descuentoCat2);
			break;
		case 3:
			precioFinal = (valorTicket * cantidad) * prepararPorcentaje(descuentoCat3);
			break;
		default:
			precioFinal = false;
			break;
	}

	return precioFinal;
}

function borrarPrecioFinal(e)
{
	let totalPagar = document.getElementById('totalPagar');
	totalPagar.textContent = '';
	totalPagar.classList.add('d-none');
}

function prepararPorcentaje(descuento)
{
	let descuentoDecimal = 1 - (descuento / 100);
	return descuentoDecimal;
}

function errorCantidad()
{
	let cantidad = document.getElementById('cantidad');

	cantidad.classList.add('error-cantidad');
}

