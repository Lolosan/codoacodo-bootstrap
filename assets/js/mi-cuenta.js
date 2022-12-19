//desactivar el alert al refrescar
if ( window.history.replaceState )
{
	window.history.replaceState( null, null, window.location.href );
}

let botones = document.querySelectorAll('.api');
let buscar = document.getElementById('buscar_usuario');

botones.forEach(boton => {
	boton.addEventListener( 'click', ejecutar_tarea, false );
});
buscar.addEventListener( 'submit', ejecutar_tarea, false );

function ejecutar_tarea( boton )
{
	boton.preventDefault();

	let tarea = boton.target.id.split('_');

	switch(tarea[0])
	{
		case 'editar':
		case 'eliminar':
			let fila_usuario = document.getElementById('usuario_' + tarea[1]);
			let nombre = fila_usuario.nextElementSibling;
			let apellido = nombre.nextElementSibling;
			let correo = apellido.nextElementSibling;
		
			let usuario = {
				accion: tarea[0],
				id: tarea[1],
				nombre: nombre.textContent,
				apellido: apellido.textContent,
				correo: correo.textContent
			}
	
			switch ( usuario.accion )
			{
				case 'eliminar':
					Swal.fire({
						title: 'Vas a eliminar al usuario: ',
						html: preparar_html_eliminar( usuario ),
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#0d6efd',
						cancelButtonColor: '#dc3545',
						cancelButtonText: 'Cancelar',
						confirmButtonText: 'Sí! Borrarlo'
					}).then((result) => {
						if (result.isConfirmed) {
							hacer_fetch( usuario );
						}
					})
				break;
			
				case 'editar':
					Swal.fire({
						title: 'Editá los datos acá: ',
						html: preparar_html_editar( usuario ),
						icon: 'info',
						showCancelButton: true,
						confirmButtonColor: '#198754',
						cancelButtonColor: '#dc3545',
						cancelButtonText: 'Cancelar',
						confirmButtonText: 'Guardar usuario',
						preConfirm: () => {
							let form = Swal.getPopup().querySelector('#form_editar');
		
							if (! form.checkValidity() )
							{
								//al editar, el resto puede estar vacío, solo validar correo bien escrito
								Swal.showValidationMessage(`Ingresá correctamente tu correo`)
							}
							
							form.classList.add('was-validated');
							
							// validar campos personalizado (solo si escribió algo, porque pueden quedar vacíos)
							// correo ya se valida solo con el anterior
							let nombre = Swal.getPopup().querySelector('#crear_nombre');
							let apellido = Swal.getPopup().querySelector('#crear_apellido');
							let password = Swal.getPopup().querySelector('#crear_password');

							if( nombre.value.length > 1 && nombre.value.length < 2 )
							{
								Swal.showValidationMessage('El nombre debe tener al menos dos letras');
							}else if( apellido.value.length > 1 && apellido.value.length < 2 )
							{
								Swal.showValidationMessage('El apellido debe tener al menos dos letras');
							} else if( password.value.length > 1 && password.value.length < 6 )
							{
								Swal.showValidationMessage('La contraseña debe tener al menos 6 caracteres');
							}

							return;
						}
					}).then((result) => {
						if (result.isConfirmed) {
							usuario.nuevos_datos = {
								nombre: Swal.getPopup().querySelector('#editar_nombre').value,
								apellido: Swal.getPopup().querySelector('#editar_apellido').value,
								correo: Swal.getPopup().querySelector('#editar_correo').value,
								password: Swal.getPopup().querySelector('#editar_password').value,
							}
							hacer_fetch( usuario );
						}
					})
				break;
			}
		break;
	
		case 'crear':
			Swal.fire({
				title: 'Ingresá el nuevo usuario acá:',
				html: preparar_html_crear(),
				icon: 'info',
				showCancelButton: true,
				confirmButtonColor: '#198754',
				cancelButtonColor: '#dc3545',
				cancelButtonText: 'Cancelar',
				confirmButtonText: 'Guardar usuario',
				preConfirm: () => {
					let form = Swal.getPopup().querySelector('#form_crear');

					//validar general (bootstrap)
					if (! form.checkValidity() )
					{
						Swal.showValidationMessage('Completá correctamente todos los campos');
					}
					
					form.classList.add('was-validated');

					// validar campos personalizado
					// correo ya se valida solo con el anterior
					let nombre = Swal.getPopup().querySelector('#crear_nombre');
					let apellido = Swal.getPopup().querySelector('#crear_apellido');
					let password = Swal.getPopup().querySelector('#crear_password');

					if( nombre.value.length < 2 )
					{
						Swal.showValidationMessage('El nombre debe tener al menos dos letras');
					}else if( apellido.value.length < 2 )
					{
						Swal.showValidationMessage('El apellido debe tener al menos dos letras');
					} else if( password.value.length < 6 )
					{
						Swal.showValidationMessage('La contraseña debe tener al menos 6 caracteres');
					}
					
					return;
				}
			}).then((result) => {
				if (result.isConfirmed) {
					let usuario = {
						accion: 'crear',
						nombre: Swal.getPopup().querySelector('#crear_nombre').value,
						apellido: Swal.getPopup().querySelector('#crear_apellido').value,
						correo: Swal.getPopup().querySelector('#crear_correo').value,
						password: Swal.getPopup().querySelector('#crear_password').value,
					}
					hacer_fetch( usuario );
				}
			})
		break;
		
		case 'buscar':
			let input = document.getElementById('input_buscar_usuario');

			if( input.value.length >= 2 )
			{
				let buscar = {
					accion: 'buscar',
					input: input.value,
				}
				hacer_fetch( buscar );
			}else
			{
				Swal.fire(
					'Ingresá al menos dos letras/números',
					'',
					'warning'
				);
			}

		break;
		default:
			//lanzar error
			Swal.fire(
				'Eso no se hace',
				'No existe esa acción',
				'error'
			)
	
			break;
	}




	return;
}


function hacer_fetch( usuario )
{
	return fetch('api.php',
	{
		method: 'POST',
		body: JSON.stringify( usuario ),
		headers: {
        	'Content-Type': 'application/json'
		}
	})
	.then(function(response)
	{
		if(response.ok)
		{
			return response.text();
		}else
		{
			throw "Error en la llamada Ajax";
		}
	})
	.then(function(texto)
	{
		let respuesta = JSON.parse(texto);
		//console.log(respuesta);
		//algo que haya que hacer en la tabla
		if( respuesta.resultado == 'success' )
		{
			switch ( usuario.accion )
			{ 
				case 'editar':
					then_ok_editar( respuesta.usuario_actualizado );
					break;
				case 'eliminar':
					then_ok_eliminar( usuario );
					break;
				case 'crear':
					then_ok_crear( respuesta.nuevo_usuario );
					break;
				case 'buscar':
					then_ok_buscar( respuesta.usuarios_encontrados );
					break;
			
				default:
					//no hacer nada notificar error
					break;
			}
		}

		if( ! ( respuesta.resultado == 'success' && usuario.accion == 'buscar' ) )
		{
			Swal.fire(
				respuesta.titulo,
				respuesta.texto,
				respuesta.resultado
			)
		}

		return;
	})
	.catch(function(err)
	{
		console.log(err);
	});
}

function then_ok_buscar( usuarios )
{
	let tbody = document.getElementById('tbody');
	let paginacion = document.getElementById('paginacion');
	let usuarios_actuales = document.getElementById('usuarios_actuales');

	tbody.innerHTML = '';

	usuarios.forEach(usuario => {
		then_ok_crear( usuario );
	});

	usuarios_actuales.innerText = usuarios.length;

	paginacion.classList.add('d-none');
}

function then_ok_crear( usuario )
{
	let tbody = document.getElementById('tbody');
	let tr = document.createElement('tr');
	
	tr.id = 'fila_' + + usuario.id;

	tr.innerHTML = '<th id="usuario_'+ usuario.id +'" scope="row">'+ usuario.id +'</th>';
	tr.innerHTML += '<td scope="row">'+ usuario.nombre +'</th>';
	tr.innerHTML += '<td scope="row">'+ usuario.apellido +'</th>';
	tr.innerHTML += '<td scope="row">'+ usuario.correo +'</th>';
	tr.innerHTML += '<td><button id="editar_'+ usuario.id +'" type="button" class="api btn btn-warning">Editar</button></td>';
	tr.innerHTML += '<td><button id="eliminar_'+ usuario.id +'" type="button" class="api btn btn-danger">Eliminar</button></td>';

	tbody.appendChild(tr);

	//relanzar el addEventListener
	let botones = [
		document.getElementById( 'editar_'+ usuario.id ),
		document.getElementById( 'eliminar_'+ usuario.id )
	]

	botones.forEach(boton => {
		boton.addEventListener( 'click', ejecutar_tarea, false );
	});
	
	return;
}

function then_ok_eliminar( usuario )
{
	let fila = document.getElementById('fila_' + usuario.id);
	fila.remove();
	
	return;
}

function then_ok_editar( usuario )
{
	let fila_id = document.getElementById('usuario_' + usuario.id);
	let fila_nombre = fila_id.nextElementSibling;
	let fila_apellido = fila_nombre.nextElementSibling;
	let fila_correo = fila_apellido.nextElementSibling;
	
	fila_id.textContent = usuario.id;
	fila_nombre.textContent = usuario.nombre;
	fila_apellido.textContent = usuario.apellido;
	fila_correo.textContent = usuario.correo;

	return;	
}

function preparar_html_crear()
{
	let html = '<form id="form_crear" class="my-4 container needs-validation" novalidate>';
	html += 	'<div class="row gy-3">';
	html +=			'<div class="col-12">';
	html +=				'<input id="crear_nombre" name="crear_nombre" type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" required>';
	html +=			'</div>';
	html +=			'<div class="col-12">';
	html +=				'<input id="crear_apellido" name="crear_apellido" type="text" class="form-control" placeholder="Apellido" aria-label="Apellido" required>';
	html +=			'</div>';
	html +=			'<div class="col-12">';
	html +=				'<input id="crear_correo" name="crear_correo" type="email" class="form-control" placeholder="Correo" aria-label="Correo" required>';
	html +=			'</div>';
	html +=			'<div class="col-12">';
	html +=				'<input id="crear_password" name="crear_password" type="password" class="form-control" placeholder="Contraseña" aria-label="Nueva Contraseña" autocomplete="new-password" required>';
	html +=			'</div>';
	html += 	'</div>';
	html += '</form>';

	return html;

}

function preparar_html_eliminar( usuario )
{
	let html = '<div class="my-4">';
		html += 	'<div class="mt-4">';
		html += 		'<ul class="text-start list-unstyled border border-danger p-4 rounded">';
		html += 			'<li>ID: '+usuario.id+'</li>';
		html += 			'<li>Nombre: '+usuario.nombre+'</li>';
		html += 			'<li>Apellido: '+usuario.apellido+'</li>';
		html += 			'<li>Correo: '+usuario.correo+'</li>';
		html += 		'</ul>';
		html += 	'</div>';
		html += 	'<div class="mt-4">';
		html += 		'<div>¿Estás seguro de hacerlo?</div>';
		html += 		'<div><strong>Esta acción NO puede deshacerse</strong></div>';
		html += 	'</div>';
		html += '</div>';

	return html;
}

function preparar_html_editar( usuario )
{
	let html = '<form id="form_editar" class="my-4 container needs-validation" novalidate>';
		html += 	'<div class="row gy-3">';
		html +=			'<div class="col-12">';
		html +=				'<input id="editar_nombre" name="editar_nombre" type="text" class="form-control" placeholder="'+usuario.nombre+'" aria-label="Nombre">';
		html +=			'</div>';
		html +=			'<div class="col-12">';
		html +=				'<input id="editar_apellido" name="editar_apellido" type="text" class="form-control" placeholder="'+usuario.apellido+'" aria-label="Apellido">';
		html +=			'</div>';
		html +=			'<div class="col-12">';
		html +=				'<input id="editar_correo" name="editar_correo" type="email" class="form-control" placeholder="'+usuario.correo+'" aria-label="Correo">';
		html +=			'</div>';
		html +=			'<div class="col-12">';
		html +=				'<input id="editar_password" name="editar_password" type="password" class="form-control" placeholder="Ingresar nueva contraseña" aria-label="Nueva Contraseña" autocomplete="new-password">';
		html +=			'</div>';
		
		html += 	'</div>';
		html += 	'<div class="mt-4">';
		html += 		'<p><strong>Esta acción NO puede deshacerse</strong></p>';
		html += 	'</div>';
		html += '</form>';

	return html;
}

