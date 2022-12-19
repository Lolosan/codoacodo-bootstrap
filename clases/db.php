<?php

class db
{
	private $hostname;
	private $user;
	private $pass;
	private $db;
	private $conexion;
	private $limite_default;
	private $offset_default;

	public function __construct()
	{
		$this->hostname = 'localhost';

		if( $_SERVER['HTTP_HOST'] == 'codoacodo.test' )
		{
			//credenciales local
			$this->user = 'root';
			$this->pass = '';
			$this->db = 'tp_integrador';
		}else
		{
			//credenciales www.000webhost.com
			$this->user = 'id20019601_lolo';
			$this->pass = '9qg3U~e?zRPbLn(M';
			$this->db = 'id20019601_tp_integrador';
		}

		$this->limite_default = 10;
		$this->offset_default = 0;

		$this->conectarse();
	}

	public function conectarse()
	{
		$this->conexion = new mysqli($this->hostname, $this->user, $this->pass, $this->db);

		if($this->conexion->connect_errno){
			die("Error de conexión: (" . $this->conexion->connect_error . ")" . $this->conexion->connect_errno);

			$mensaje = 'Ups, hubo un error con la base de datos' . PHP_EOL;
			$mensaje =  "(" . $this->conexion->connect_error . ")" . $this->conexion->connect_errno . PHP_EOL;
			$mensaje .= 'Contactar a Leo!!!!';
			die( $mensaje );
		}
	}

	public function hacer_query( $query )
	{
		$resultado = $this->conexion->query($query);
		return $resultado;
	}

	public function guardar_id_sesion_en_db( $id_sesion, $usuario_id )
	{
		$query = "INSERT INTO sesiones (id_sesion, usuario_id) VALUES ('$id_sesion', '$usuario_id') ON DUPLICATE KEY UPDATE id_sesion = '$id_sesion'";
		$resultado = $this->hacer_query( $query );
	
		if( $resultado == true )
		{
			return true;
		}else
		{
			die('Acción no permitida');
		}
	}

	public function eliminar_id_sesion_en_db( $id_sesion, $usuario_id )
	{
		$query = "DELETE FROM sesiones WHERE id_sesion = '$id_sesion'";
		$resultado = $this->hacer_query( $query );
	
		if( $resultado == true )
		{
			return true;
		}else
		{
			//No debería, pero algo pudo haber fallado usando el id_sesion
			// en ese caso, antes de morir probar desloguearlo de todos lados

			$query = "DELETE FROM sesiones WHERE usuario_id = '$usuario_id'";
			$resultado = $this->hacer_query( $query );
		
			if( $resultado == true )
			{
				return true;
			}else
			{
				die('Acción no permitida');
			}
		}
	}

	public function crear_acceso_usuario()
	{
		if( isset($_POST['crear_nombre'], $_POST['crear_apellido'], $_POST['crear_email'], $_POST['crear_password']) )
		{
			if( mb_strlen($_POST['crear_nombre']) < 2 )
			{
				$mensaje = [
					'tipo'	=> 'error',
					'texto'	=> 'El nombre debe tener al menos dos letras'
				];
				volver_al_login( $mensaje );

			}else if( mb_strlen($_POST['crear_apellido']) < 2 )
			{
				$mensaje = [
					'tipo'	=> 'error',
					'texto'	=> 'El apellido debe tener al menos dos letras'
				];
				volver_al_login( $mensaje );

			}else if( mb_strlen($_POST['crear_password']) < 6 )
			{
				$mensaje = [
					'tipo'	=> 'error',
					'texto'	=> 'La contraseña debe tener al menos 6 caracteres'
				];
				volver_al_login( $mensaje );

			}

			//primero limpiar
			$nombre = $this->limpiar_input( $_POST['crear_nombre'] );
			$apellido = $this->limpiar_input( $_POST['crear_apellido'] );
			$mail = $this->limpiar_input( $_POST['crear_email'] );
			$password = $this->limpiar_input( $_POST['crear_password'] );

			//despues verificar que ya ese mail no exista
			$query = "SELECT * FROM usuarios WHERE correo = '$mail'";
			$yaExiste = $this->hacer_query( $query );

			if( $yaExiste->num_rows == 1 )
			{
				$mensaje = [
					'tipo'	=> 'error',
					'texto'	=> 'Ya existe un usuario con ese mail. Accedé con tus credenciales'
				];
			}else
			{
				$query = "INSERT INTO usuarios ( nombre, apellido, correo, password ) VALUES ( '$nombre', '$apellido', '$mail', '$password' )";
				$guardado = $this->hacer_query( $query );

				if( $guardado == true )
				{
					$mensaje = [
						'tipo'	=> 'success',
						'texto'	=> '¡Cuenta creada correctamente! Ahora accedé con tu clave'
					];
				}else
				{
					$mensaje = [
						'tipo'	=> 'error',
						'texto'	=> 'Algo ocurrió que no pudimos guardar tus datos. Volvé a intentarlo nuevamente'
					];
				}
			}

			volver_al_login( $mensaje );
		}else
		{
			$mensaje = [
				'tipo'	=> 'error',
				'texto'	=> 'Datos corruptos. Tu dirección IP <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> fue informada al FBI'
			];

			volver_al_login( $mensaje );
		}
	}

	public function validar_acceso_usuario()
	{
		//si entra con cookie
		if( isset($_COOKIE['ingresado']) )
		{
			$cookie = unserialize( $_COOKIE['ingresado'] );
			$id_sesion = $this->conexion->real_escape_string( $cookie['id_sesion'] );
			
			$query = "SELECT id, nombre FROM usuarios WHERE id = (SELECT usuario_id FROM sesiones WHERE id_sesion = '$id_sesion')"; 

			// si entra desde formulario
		}else
		{
			//para el caso donde entra sin cookie, pero directo al enlace
			if( isset( $_POST['ingresar_email'], $_POST['ingresar_password'] ) )
			{
				$correo = $this->conexion->real_escape_string( $_POST['ingresar_email'] );
				$password = $this->conexion->real_escape_string( $_POST['ingresar_password'] );
	
				$query = "SELECT id, nombre, correo, password FROM usuarios WHERE password = '$password' AND correo = '$correo'";
			}else
			{
				volver_al_login( false );
			}

		}

		$consulta = $this->hacer_query( $query );

		//si el usuario existe
		if( $consulta->num_rows == 1 )
		{
			$usuario = $consulta->fetch_assoc();

			$nombre = 'ingresado';

			$cookie['id_sesion'] = session_id();
			$cookie['usuario_id'] = $usuario['id'];
			$cookie['nombre'] = $usuario['nombre'];
			$valor = serialize( $cookie );

			//para poder mostrar el nombre en el momento sin esperar un 2do refresh
			$_COOKIE['ingresado'] = serialize( $cookie );

			if( isset($_POST['recordarme']))
			{
				$tiempo = time() + (60*60*24*365*10);
			}else
			{
				$tiempo = -1;
			}

			setcookie($nombre, $valor, $tiempo, '/');
			$this->guardar_id_sesion_en_db( $cookie['id_sesion'], $usuario['id']);

			return true;

		}else
		{
			return false;
		}
	}

	public function eliminar_usuario( $usuario )
	{
		// primero verificar que el usuario existe y que todos los datos sean correctos
		// esto para que no me cambien los datos en el js
		$existe = $this->verificar_que_existe( $usuario );
		
		//si el usuario existe y esta todo bien, ahora si borrarlo
		if( $existe == true )
		{
			$query = "DELETE FROM usuarios WHERE id = '$usuario->id'";
			$consulta = $this->hacer_query($query);

			if( $consulta != false )
			{
				$resultado = [
					'resultado'	=> 'success',
					'titulo'	=> '¡Eliminado!',
					'texto'		=> 'El usuario fue eliminado correctamente'
				];
			}else
			{
				$resultado = [
					'resultado'	=> 'warning',
					'titulo'	=> 'Algo falló al eliminar el usuario',
					'texto'		=> 'Probá nuevamente luego, o informá al administrador del sitio'
				];
			}
		}else
		{
			$resultado = [
				'resultado'	=> 'error',
				'titulo'	=> 'Eso no se hace',
				'texto' => 'No existe esa acción. Tu dirección IP <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> fue informada al FBI'
			];
		}

		return $resultado;
	}

	public function editar_usuario( $usuario )
	{
		// primero verificar que el usuario existe y que todos los datos sean correctos
		// esto para que no me cambien los datos en el js
		$existe = $this->verificar_que_existe( $usuario );
		
		//si el usuario existe y esta todo bien, ahora si borrarlo
		if( $existe == true )
		{
			//verificar si hay datos nuevos
			if( isset( $usuario->nuevos_datos ) )
			{
				$nuevo_usuario = $this->actualizar_estas_columnas( $usuario );

				if( $nuevo_usuario != false )
				{
					$query = "UPDATE usuarios SET ";

					$query .= implode(', ', get_object_vars( $nuevo_usuario->nuevos_datos) );

					$query .= " WHERE id = '$nuevo_usuario->id'";

					$consulta = $this->hacer_query($query);
		
					if( $consulta != false )
					{
						$resultado = [
							'resultado'	=> 'success',
							'titulo'	=> '¡Usuario guardado!',
							'texto'		=> 'El usuario fue correctamente actualizado',
							'usuario_actualizado'	=> $usuario
						];
					}else
					{
						$resultado = [
							'resultado'	=> 'warning',
							'titulo'	=> 'Algo falló al guardar el usuario',
							'texto'		=> 'Probá nuevamente luego, o informá al administrador del sitio',
						];
					}
	
				}else
				{
					$resultado = [
						'resultado'	=> 'question',
						'titulo'	=> 'No enviaste datos',
						'texto'		=> 'No había nada nuevo para guardar'
					];
				}

			}else
			{
				$resultado = [
					'resultado'	=> 'warning',
					'titulo'	=> 'Algo falló al guardar el usuario',
					'texto'		=> 'Probá nuevamente luego, o informá al administrador del sitio'
				];
			}

		}else
		{
			$resultado = [
				'resultado'	=> 'error',
				'titulo'	=> 'Eso no se hace',
				'texto' => 'No existe esa acción. Tu dirección IP <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> fue informada al FBI'
			];
		}

		return $resultado;
	}

	public function crear_usuario( $usuario )
	{
		if( isset( $usuario->nombre, $usuario->apellido, $usuario->correo, $usuario->password )
			&& ! empty( $usuario->nombre )
			&& ! empty( $usuario->apellido )
			&& ! empty( $usuario->correo )
			&& ! empty( $usuario->password )
		){
			//primero limpiar
			$nombre = $this->limpiar_input( $usuario->nombre );
			$apellido = $this->limpiar_input( $usuario->apellido );
			$mail = $this->limpiar_input( $usuario->correo );
			$password = $this->limpiar_input( $usuario->password );

			//despues verificar que ya ese mail no exista
			$query = "SELECT * FROM usuarios WHERE correo = '$mail'";
			$yaExiste = $this->hacer_query( $query );

			if( $yaExiste->num_rows == 1 )
			{
				$resultado = [
					'resultado'	=> 'error',
					'titulo'	=> 'Ya existe',
					'texto' => 'El correo del usuario que estás creando ya existe. Tiene que entrar con sus credenciales'
				];
			}else
			{
				$query = "INSERT INTO usuarios ( nombre, apellido, correo, password ) VALUES ( '$nombre', '$apellido', '$mail', '$password' )";
				$guardado = $this->hacer_query( $query );

				if( $guardado == true )
				{
					$usuario->id = $this->conexion->insert_id;
					
					$resultado = [
						'resultado'	=> 'success',
						'titulo'	=> '¡Usuario creado!',
						'texto'		=> 'El usuario fue correctamente creado',
						'nuevo_usuario'	=> $usuario
					];
				}else
				{
					$resultado = [
						'resultado'	=> 'error',
						'titulo'	=> 'Algo falló al guardar el usuario',
						'texto'		=> 'Probá nuevamente luego, o informá al administrador del sitio'
					];
				}
			}
		}else
		{
			$resultado = [
				'resultado'	=> 'error',
				'titulo'	=> 'Eso no se hace',
				'texto' => 'Datos corruptos. Tu dirección IP <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> fue informada al FBI'
			];
		}

		return $resultado;
	}


	public function buscar_usuario( $buscar )
	{
		if( isset( $buscar->input ) && ! empty( $buscar->input ) )
		{
			$termino = $this->limpiar_input( $buscar->input );

			if( $termino == 'limpiar_busqueda' )
			{
				$resultados = $this->get_usuarios();
			}else
			{
				$query = "SELECT id, nombre, apellido, correo FROM usuarios WHERE ";
				$query .= "id LIKE '%$termino%'";
				$query .= " OR nombre LIKE '%$termino%'";
				$query .= " OR apellido LIKE '%$termino%'";
				$query .= " OR correo LIKE '%$termino%'";
	
				$resultados = $this->hacer_query( $query );
			}

			if( $resultados->num_rows >= 1 )
			{
				$usuarios_encontrados = array();
				while( $usuario = $resultados->fetch_array(MYSQLI_ASSOC) )
				{
					$usuarios_encontrados[] = $usuario;
				}

				$resultado = [
					'resultado'	=> 'success',
					//'titulo'	=> 'No encontrado',
					//'texto' => 'No encontramos a nadie con esos datos'
					'usuarios_encontrados' => $usuarios_encontrados
				];

			}else
			{
				$resultado = [
					'resultado'	=> 'info',
					'titulo'	=> 'No encontrado',
					'texto' => 'No encontramos a nadie con esos datos'
				];
			}
		}else
		{
			$resultado = [
				'resultado'	=> 'error',
				'titulo'	=> 'Eso no se hace',
				'texto' => 'No existe esa acción. Tu dirección IP <strong>' . $_SERVER['REMOTE_ADDR'] . '</strong> fue informada al FBI'
			];
		}

		return $resultado;
	}


	private function verificar_que_existe( $usuario )
	{
		$query = "SELECT * FROM usuarios WHERE id = '$usuario->id' AND nombre = '$usuario->nombre' AND apellido = '$usuario->apellido' AND correo = '$usuario->correo'";
		$consulta = $this->hacer_query( $query );

		//si el usuario existe y esta todo bien
		if( $consulta->num_rows == 1 )
		{
			return true;
		}else
		{
			return false;
		}
	}

	private function actualizar_estas_columnas( $usuario )
	{
		//valido que exista y no esté vacío
		// actualizo el nombre para que actualice el front
		// actualizo el nuevos datos para que actualice la base de datos

		//$nuevos_datos = array();

		if( isset( $usuario->nuevos_datos->nombre ) && ! empty( $usuario->nuevos_datos->nombre ) )
		{
			$nombre_limpio = $this->limpiar_input( $usuario->nuevos_datos->nombre );
			
			$usuario->nombre = $nombre_limpio;
			//$nuevos_datos[] = "nombre = '" . $nombre_limpio . "'";
			$usuario->nuevos_datos->nombre = "nombre = '" . $nombre_limpio . "'";
		}else
		{
			unset( $usuario->nuevos_datos->nombre );
		}

		if( isset( $usuario->nuevos_datos->apellido ) && ! empty( $usuario->nuevos_datos->apellido ) )
		{
			$apellido_limpio = $this->limpiar_input( $usuario->nuevos_datos->apellido );

			$usuario->apellido = $apellido_limpio;
			//$nuevos_datos[] = "apellido = '" . $apellido_limpio . "'";
			$usuario->nuevos_datos->apellido = "apellido = '" . $apellido_limpio . "'";
		}else
		{
			unset( $usuario->nuevos_datos->apellido );
		}

		if( isset( $usuario->nuevos_datos->correo ) && ! empty( $usuario->nuevos_datos->correo ) )
		{
			$correo_limpio = $this->limpiar_input( $usuario->nuevos_datos->correo );

			$usuario->correo = $correo_limpio;
			$usuario->nuevos_datos->correo = "correo = '" . $correo_limpio . "'";
		}else
		{
			unset( $usuario->nuevos_datos->correo );
		}

		if( isset( $usuario->nuevos_datos->password ) && ! empty( $usuario->nuevos_datos->password ) )
		{
			$password_limpio = $this->limpiar_input( $usuario->nuevos_datos->password );

			$usuario->password = $password_limpio;
			$usuario->nuevos_datos->password = "password = '" . $password_limpio . "'";
		}else
		{
			unset( $usuario->nuevos_datos->password );
		}

		//hay que usar esta funcion para contar las propiedades de este tipo de objetos
		if( count( get_object_vars($usuario->nuevos_datos) ) < 1 )
		{
			return false;
		}

		return $usuario;
	}

	public function limpiar_input( $input )
	{
		//primer limpieza
		$primer_pasada = htmlspecialchars( $input, ENT_QUOTES, 'UTF-8');

		//2da limpieza
		$segunda_pasada = $this->conexion->real_escape_string( $primer_pasada );

		return $segunda_pasada;
	}

	public function get_usuarios()
	{
		$limit = $this->limite_default();
		$offset = $this->offset_default();

		//como son numeros puedo usar intval como una capa extra
		if( isset( $_GET['limit'] ) )
		{
			$limit = $this->limpiar_input( intval($_GET['limit']) );
		}
		if( isset( $_GET['offset'] ) )
		{
			$offset = $this->limpiar_input( intval($_GET['offset']) );
		}

		$query = "SELECT id, nombre, apellido, correo FROM usuarios LIMIT $limit OFFSET $offset";

		$resultado = $this->hacer_query( $query );
		
		return $resultado;
	}

	public function get_usuarios_totales()
	{
		$query = "SELECT count(id) FROM usuarios";
		$resultado = $this->hacer_query( $query );
		$fila = $resultado->fetch_row();

		return $fila[0];
	}

	public function limite_default()
	{
		return $this->limite_default;
	}
	public function offset_default()
	{
		return $this->offset_default;
	}
}

$db = new db();