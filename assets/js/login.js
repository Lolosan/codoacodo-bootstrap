let btn_crear = document.getElementById('btn_crear');
let btn_volver = document.getElementById('btn_volver');
let formularios = document.querySelectorAll('.needs-validation');

btn_crear.addEventListener('click', cambiar_form, false);
btn_volver.addEventListener('click', cambiar_form, false);

Array.from(formularios).forEach(formulario => {
	formulario.addEventListener('submit', validar_campos, false);
});


/**
 * ----------------------------------------------------------------------------
 * Funciones
 * ----------------------------------------------------------------------------
**/

function cambiar_form(e)
{
	e.preventDefault();

	let form_crear = document.getElementById('form_cuenta_crear');
	let form_ingresar = document.getElementById('form_cuenta_ingresar');

	if( form_crear.classList.contains('d-none') )
	{
		form_crear.classList.replace('d-none', 'd-grid');
		form_ingresar.classList.replace('d-grid', 'd-none');
	}else
	{
		form_crear.classList.replace('d-grid', 'd-none');
		form_ingresar.classList.replace('d-none', 'd-grid');
	}

	return;
}

function validar_campos(e)
{
	//validador bootstrap
	if (!e.target.checkValidity())
	{
		e.preventDefault();
		e.stopPropagation();
	}

	//validador bootstrap
	e.target.classList.add('was-validated');

	return;
}

