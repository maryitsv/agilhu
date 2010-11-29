<?php

/**
 * usuarios actions.
 *
 * @package    agilhu
 * @subpackage autenticacion
 * @author     maryit
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class autenticacionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
   // $this->forward('default', 'module');

  }


  public function executeCargar()
	{

		$task = '';
		$salida	='';

		$task = $this->getRequest()->getParameter('task');

		switch($task){
			case "BUSCARUSUARIO":
				$salida = $this->buscarUsuario();
				break;

			case "CREATEUSUARIO":
				$salida = $this->autoCrearUsuario();
				break;
				
			default:
				$salida =  "({failure:true})";
				break;
		}

		return $this->renderText($salida);
	}

	protected function buscarUsuario()
	{
		$conexion = new Criteria();
	      //$conexion->add(AgilhuUsuarioPeer::USU_ESTADO,true);
                $conexion->add(AgilhuUsuarioPeer::USU_ESTADO,'habilitado');
	        $conexion->add(AgilhuUsuarioPeer::USU_USUARIO,$this->getRequestParameter('agUsu_usuario'));
	        $conexion->add(AgilhuUsuarioPeer::USU_CLAVE,base64_encode($this->getRequestParameter('agUsu_clave')));
		$usuario = AgilhuUsuarioPeer::doSelectOne($conexion);
		
		if(!$usuario){			
	
			return "{success: false, errors: { reason: 'El usuario o clave incorrectas o <br/> puede que el usuario este deshabilitado' }}";
			}
		else {
						
			$this->getUser()->setAttribute('idUsuario', $usuario->getUsuId());
			$this->getUser()->setAttribute('usuUsuario', $usuario->getUsuUsuario());
			$this->getUser()->setAttribute('usuNombres', $usuario->getUsuNombres());
			$this->getUser()->setAttribute('usuApellidos', $usuario->getUsuApellidos());
			$this->getUser()->setAttribute('usuCorreo', $usuario->getUsuCorreo());
			$this->getUser()->setAttribute('idRol', $usuario->getRolId());
			$this->getUser()->setAuthenticated(true);
					
			return "{success: true, mensaje: '".$this->getNombreRol($usuario->getRolId())."' }";
		}
	}

	protected function getNombreRol($idRol)
	{
		$conexion = new Criteria();
		$conexion->add(AgilhuRolPeer::ROL_ID,$idRol); 
		$roles = AgilhuRolPeer::doSelect($conexion);
		$nombreRol='';
		foreach ($roles As $temporal)
		{
			$nombreRol=$temporal->getRolNombre();
		
		}

		return $nombreRol;
	}


	protected function getIdRol($nombreRol)
	{
		$conexion = new Criteria();
		$conexion->add(AgilhuRolPeer::ROL_NOMBRE,$nombreRol); //esto es un where
		$rol = AgilhuRolPeer::doSelectOne($conexion);
		$nombreRol='';

		$nombreRol=$rol->getRolId();

		return $nombreRol;
	}

	public function autoCrearUsuario()
	{
		$usuUsuario = $this->getRequestParameter('usuario');
		$conexion   =   new Criteria();
		$conexion->add(AgilhuUsuarioPeer::USU_USUARIO, $usuUsuario);
		$listaUsuario = AgilhuUsuarioPeer::doSelectOne($conexion);
		$salida	='';
		
		if(!$listaUsuario)
		{
			  $usuario = new AgilhuUsuario();
			  
			  $usuario->setUsuNombres($this->getRequestParameter('nombres'));
			  $usuario->setUsuApellidos($this->getRequestParameter('apellidos'));
			  $usuario->setUsuCorreo($this->getRequestParameter('correo'));
			  $usuario->setUsuUsuario($this->getRequestParameter('usuario'));
			  $usuario->setUsuClave(base64_encode($this->getRequestParameter('clave')));
			  $usuario->setUsuEstado('habilitado');
			  $usuario->setRolId($this->getIdRol('usuario'));

			 
	        try
	        {
	          $usuario->save();
	        }
	          
	        catch (Exception $excepcionUsuario)
	        {
	         // $exeptionErrorUsuario = substr_count($excepcionUsuario->getMessage(), 'llave duplicada viola restricción de unicidad «apis_usuario_login_unique»');
	          //if($exeptionErrorUsuario > 0)
	          //{
	            $salida = "({success: false, errors: { reason: 'Ya existe un usuario con el nombre de usuario igual a: ".$this->getRequestParameter('Login')."'}})";
	            return $salida;
	          //}
	        }
				  $salida = "({success: true, mensaje:'El usuario fue creado exitosamente'})";
		  } else {
			  $salida = "({success: false, errors: { reason: 'Ya existe un usuario con ese mismo login".$this->getRequestParameter('Login')." '}})";
		  }
		  return $salida;
	}
	
 public function executeImagen()
	{
		      // Mostrar el formulario*/
			function generateCode() {
			/* list all possible characters, similar looking characters and vowels have been removed */
			$possible = '23456789bcdfghjkmnpqrstvwxyz';
			$code = '';
			$i = 0;
			while ($i < 5) { 
				$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
				$i++;
			}
			return $code;
			}
		      $strindCaptcha = generateCode();
	// 	      $this->getUser()->setAttribute('captcha', $strindCaptcha);
		      return $this->renderText($strindCaptcha);
	//               return sfView::NONE;
	}

}
