//eliminar los mensajes una vez mostrados
const urlParams = new URLSearchParams(window.location.search);
let tipo = urlParams.get('tipo');
let mensaje = urlParams.get('mensaje');

if( tipo )
{
	console.log(tipo);
	urlParams.delete('tipo');
}
if( mensaje )
{
	urlParams.delete('mensaje');
}
window.history.replaceState({}, '', `${location.pathname}?${urlParams}`);

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

	// solo al crear cuenta
	if(e.target.id == 'form_cuenta_crear' )
	{
		// validar campos personalizado
		// correo ya se valida solo con el anterior
		let nombre = document.getElementById('nombre');
		let apellido = document.getElementById('apellido');
		let password = document.getElementById('password');
		let cortar_envio = false;

		if( nombre.value.length < 2 )
		{
			nombre.classList.add('is-invalid');
			cortar_envio = true;

		}else if( apellido.value.length < 2 )
		{
			apellido.classList.add('is-invalid');
			cortar_envio = true;

		} else if( password.value.length < 6 )
		{
			password.classList.add('is-invalid');
			cortar_envio = true;
		}

		if( cortar_envio == true )
		{
			e.preventDefault();
			e.stopPropagation();
		}
	}

	if(e.target.id == 'form_cuenta_ingresar' )
	{
		// validar campos personalizado
		// correo ya se valida solo con el anterior
		let password = document.getElementById('password');
		let cortar_envio = false;

		if( password.value.length < 6 )
		{
			password.classList.add('is-invalid');
			e.preventDefault();
			e.stopPropagation();
		}
	}

	return;
}

