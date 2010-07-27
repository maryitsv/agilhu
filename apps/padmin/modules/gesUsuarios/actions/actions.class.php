<?php

/**
 * gesUsuarios actions.
 *
 * @package    agilhu
 * @subpackage gesUsuarios
 * @author     maryit
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class gesUsuariosActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  
  }
 public function executeCargar()
	{
		$task = '';
		$salida	='';
//getRequest()->
		$task = $this->getRequestParameter('task');

		switch($task){
			case "LISTING":
				$salida = $this->listarUsuarios();
				break;

			case "LISTINGROL":
				$salida = $this->listarRol();
				break;

			case "UPDATEUSU":
				$salida = $this->updateUsuario();
				break;

			case "CREATEUSU":
				$salida = $this->crearUsuario();
				break;

			case "DELETEUSU":
				$salida = $this->eliminarUsuario();
				break;
			default:
				$salida =  "({failure:true})";
				break;
		}

	
		return $this->renderText($salida);
	}



	protected function crearUsuario()
	{
	
		$usuUsuario = $this->getRequestParameter('usuUsuario');
		$conexion=new Criteria();
		$conexion->add(AgilhuUsuarioPeer::USU_USUARIO, $usuUsuario);
		$usuario=AgilhuUsuarioPeer::doSelectOne($conexion);
		$salida	='';
		if(!$usuario)
		{
			  $usuario = new AgilhuUsuario();			  
			  $usuario->setUsuNombres($this->getRequestParameter('usuNombres'));
			  $usuario->setUsuApellidos($this->getRequestParameter('usuApellidos'));
			  $usuario->setUsuCorreo($this->getRequestParameter('usuCorreo'));
			  $usuario->setUsuEstado(''.true);//($this->getRequestParameter('usuEstado'));
			  $usuario->setRolId($this->getRequestParameter('Tipo_usuario'));
			  $usuario->setUsuUsuario($this->getRequestParameter('usuUsuario'));
			  $usuario->setUsuClave(base64_encode($this->getRequestParameter('usuClave')));
	          try
	          {
	          	$usuario->save();
	          }
	          catch (Exception $excepcionUsuario)
	          {
	           // $exeptionErrorUsuario = substr_count($excepcionUsuario->getMessage(), 'llave duplicada viola restricción de unicidad «apis_usuario_login_unique»');
	           //if($exeptionErrorUsuario > 0)
	           //{
	             $salida = "({success: false, errors: { reason: 'Ya existe un usuario con el nombre de usuario igual a: ".$this->getRequestParameter('usuUsuario')."'}})";
	             return $salida;
	           //}
	          }
			  $salida = "({success: true, mensaje:'El usuario fue creado exitosamente'})";
		  } 
		  else {$salida = "({success: false, errors: { reason: 'Ya existe una persona con ese mismo usuario,cambielo e intente denuevo'}})";}
		  return $salida;
	}

	protected function updateUsuario()
	{
	
		$usuId = $this->getRequestParameter('usuId');
		$conexion = new Criteria();
		$conexion->add(AgilhuUsuarioPeer::USU_ID, $usuId);
		$usuario = AgilhuUsuarioPeer::doSelectOne($conexion);
		$salida = '';

		if($usuario)
		{
				$usuario->setUsuNombres($this->getRequestParameter('usuNombres'));
				$usuario->setUsuApellidos($this->getRequestParameter('usuApellidos')); 
				$usuario->setUsuCorreo($this->getRequestParameter('usuCorreo'));
			//  $usuario->setRolId($this->getRequestParameter('rolId'));
			//	$usuario->setUsuUsuario($this->getRequestParameter('usuUsuario'));//no se actualiza por que debe ser unico
				$usuario->setUsuClave(base64_encode($this->getRequestParameter('usuClave')));
				$usuario->setUsuEstado($this->getRequestParameter('usuEstado'));
		      	try
		      	{
		        	$usuario->save();
		      	}
		      	catch (Exception $excepcionUsuario)
		      	{
		       // $exeptionErrorUsuario = substr_count($excepcionUsuario->getMessage(), 'llave duplicada viola restricción de unicidad «apis_usuario_login_unique»');
		        //	if($exeptionErrorUsuario > 0)
		        //	{
		          	$salida = "({success: false, errors: { reason: 'Ya existe un usuario con el nombre de usuario igual a: ".$this->getRequestParameter('Login')."'}})";
		          	return $salida;
		        	//}
		      	}
				$salida = "({success: true, mensaje:'El usuario fue actualizado exitosamente'})";
		} else {
			$salida = "({success: false, errors: { reason: 'No se a actualizado el usuario corecctamente'}})";
		}
	
		return $salida;
	}

	protected function eliminarUsuario()
	{
		$ids = $this->getRequestParameter('idusuario');
		$id_Parcial = json_decode($ids);
		foreach ($id_Parcial as $identificador)
		{
			$idDefinitivo = $identificador;
		}

		$conexion = new Criteria();
		$conexion->add(AgilhuUsuarioPeer::USU_ID, $idDefinitivo);
		if($conexion)
		{
			$delUsuario = AgilhuUsuarioPeer::doSelect($conexion);
			foreach ($delUsuario as $elemento)
			{
				$elemento->delete();
			}
			$salida = "({success: true, mensaje:'El usuario fue eliminado exitosamente'})";
		}
		else
		{
			$salida = "({success: false, errors: { reason: 'No se pudo eliminar el usuario'}})";
		}

		return $salida;
	}


	protected function listarUsuarios()
	{
		
		$conexion = new Criteria();
		$numero_Usuarios = AgilhuUsuarioPeer::doCount($conexion);
	        $conexion->setLimit($this->getRequestParameter('limit'));
		$conexion->setOffset($this->getRequestParameter('start'));
		$usuarios = AgilhuUsuarioPeer::doSelect($conexion);
		$pos = 0;
		$nbrows=0;
		$datos;
		
		foreach ($usuarios As $temporal)
		{
			$datos[$pos]['usuId']=$temporal->getUsuId();
			$datos[$pos]['usuNombres']=$temporal->getUsuNombres();
			$datos[$pos]['usuApellidos']=$temporal->getUsuApellidos();
			$datos[$pos]['usuCorreo']=$temporal->getUsuCorreo();
			$datos[$pos]['usuRolId']=$temporal->getRolId();

			$datos[$pos]['usuRolNombre']=$this->getNombreRol($temporal->getRolId());
 			$datos[$pos]['usuEstado']=$temporal->getUsuEstado();
			$datos[$pos]['usuUsuario']=$temporal->getUsuUsuario();
 			$datos[$pos]['usuClave']=$temporal->getUsuClave();
			$pos++;
			$nbrows++;
		}
		
		if($nbrows>0){
			$jsonresult = json_encode($datos);
			return '({"total":"'.$numero_Usuarios.'","results":'.$jsonresult.'})';
		}
		else {
			return '({"total":"0", "results":""})';
		}
	}


	protected function getNombreRol($idRol)
	{
		$conexion = new Criteria();
		$conexion->add(AgilhuRolPeer::ROL_ID,$idRol); //esto es un where
		$roles = AgilhuRolPeer::doSelect($conexion);
		$nombreRol='';
		foreach ($roles As $temporal)
		{
			$nombreRol=$temporal->getRolNombre();
		
		}

		return $nombreRol;
	}




	protected function listarRol()
	{
		
		$conexion = new Criteria();
		$roles = AgilhuRolPeer::doSelect($conexion);
		$pos = 0;
		$nbrows=0;
		$datos;
		foreach ($roles As $temporal)
		{

			$datos[$pos]['rolId']=''.$temporal->getRolId();
			$datos[$pos]['rolNombre']=$temporal->getRolNombre();
			$pos++;
			$nbrows++;
		}

		if($nbrows>0){
			$jsonresult = json_encode($datos);
			return '({"total":"0","results":'.$jsonresult.'})';
		}
		else {
			return '({"total":"0", "results":""})';
		}
		
	}

}

