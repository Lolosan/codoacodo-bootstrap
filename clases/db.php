<?php

class db
{
	private $hostname;
	private $user;
	private $pass;
	private $db;
	private $conexion;

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
			//primer limpieza
			$nombre = htmlspecialchars($_POST['crear_nombre'], ENT_QUOTES, 'UTF-8');
			$apellido = htmlentities($_POST['crear_apellido'], ENT_QUOTES, "UTF-8");
			$mail = htmlentities($_POST['crear_email'], ENT_QUOTES, "UTF-8");
			$password = htmlentities($_POST['crear_password'], ENT_QUOTES, "UTF-8");

			//2da limpieza
			$nombre = $this->conexion->real_escape_string( $nombre );
			$apellido = $this->conexion->real_escape_string( $apellido );
			$mail = $this->conexion->real_escape_string( $mail );
			$password = $this->conexion->real_escape_string( $password );

			//primero verificar que ya ese mail no exista
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
			$correo = $this->conexion->real_escape_string( $_POST['ingresar_email'] );
			$password = $this->conexion->real_escape_string( $_POST['ingresar_password'] );

			$query = "SELECT id, nombre, correo, password FROM usuarios WHERE password = '$password' AND correo = '$correo'";
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


	public function get_usuarios()
	{
		$query = 'SELECT id, nombre, apellido, correo FROM usuarios';
		$resultado = $this->hacer_query( $query );
		
		return $resultado;
	}
}

$db = new db();