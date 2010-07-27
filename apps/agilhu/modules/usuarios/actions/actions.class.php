<?php

/**
 * usuarios actions.
 *
 * @package    agilhu
 * @subpackage usuarios
 * @author     maryit
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class usuariosActions extends sfActions
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

			default:
				$salida =  "({failure:true})";
				break;
		}

		return $this->renderText($salida);
	}

	protected function buscarUsuario()
	{

		$conexion = new Criteria();
	        $conexion->add(AgilhuUsuarioPeer::USU_ESTADO,true);
	        $conexion->add(AgilhuUsuarioPeer::USU_USUARIO,$this->getRequestParameter('agUsu_usuario'));
	        $conexion->add(AgilhuUsuarioPeer::USU_CLAVE,$this->getRequestParameter('agUsu_clave'));
		$usuario = AgilhuUsuarioPeer::doSelectOne($conexion);
		
		if(!$usuario){
			
			return '({"succes":"false", "mensaje":"el usuario o clave incorrectas"})';
		}
		else {
			$jsonresult = json_encode($usuario);
			return '({"succes":"true","mensaje":"administrador","datos":'.$jsonresult.'})';
		}
	}

}
