<?php

/**
 * mensajes actions.
 *
 * @package    agilhu
 * @subpackage mensajes
 * @author     maryit
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mensajesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
 //   $this->forward('default', 'module');
  }
  
  
  public function executeCargar()
  {
	$task = '';
	$salida	='';
	$task = $this->getRequestParameter('task');
	//captura de variables de sesion
	$usu_id=$this->getUser()->getAttribute('idUsuario'); 
	$pro_id=$this->getUser()->getAttribute('proyectoSeleccionado');
	
		
	switch($task){
		case "LISTARMENSAJES"://por defecto los recibidos
			$usu_usuario=$this->getUser()->getAttribute('usuUsuario'); 
			$salida = $this->listarMensajes($pro_id,$usu_usuario);
			break;

		case "ELIMINARMENSAJE":
			$salida = $this->eliminarMensaje($pro_id,$usu_id);
			break;
		
		case "CREARMENSAJE":
			$salida = $this->crearMensaje($pro_id,$usu_id);
			break;
		
		case "BUSCARMENSAJE":
			$usu_usuario=$this->getUser()->getAttribute('usuUsuario'); 
			//echo($usu_usuario);
			$salida = $this->buscarMensajes($pro_id,$usu_usuario);
			break;

		case "LISTARCONTACTOS":
			$salida = $this->listarContactos($pro_id);
			break;

		default:
			$salida =  "({failure:true})";
			break;
	}


	return $this->renderText($salida);
  }




  protected function crearMensaje($pro_id,$usu_id)
  {	
  }


  protected function eliminarMensaje($pro_id,$usu_id)
  {
	$ids_mensajes = json_decode($this->getRequestParameter('ids_mensajes'));
	$tipo_mensaje =$this->getRequestParameter('tipo_mensaje');
	$salida ="";
	if($tipo_mensaje=='Enviados')
	{
		try{
			foreach ($ids_mensajes as $id_men)
			{
				$conexion = new Criteria();
				$conexion->add(AgilhuMensajeEnviadoPeer::MEN_ID, $id_men);
		
				$mensajes = AgilhuMensajeEnviadoPeer::doSelect($conexion);
				foreach ($mensajes as $elemento)
				{
					$elemento->delete();
				}
				$salida = "({success: true, mensaje:'El mensaje enviado fue eliminado  exitosamente'})";			
			}
		}catch(Exception $e){
			$salida = "({success: false, errors: { reason: 'No se pudo eliminar el mensaje enviado'}})";
		}
	}
	if($tipo_mensaje=='Recibidos')
	{
		try{
			foreach ($ids_mensajes as $id_men)
			{
				$conexion = new Criteria();
				$conexion->add(AgilhuMensajeRecibidoPeer::MEN_ID, $id_men);
		
				$mensajes = AgilhuMensajeRecibidoPeer::doSelect($conexion);
				foreach ($mensajes as $elemento)
				{
					$elemento->delete();
				}
				$salida = "({success: true, mensaje:'El mensaje recibido fue eliminado  exitosamente'})";			
			}
		}catch(Exception $e){
			$salida = "({success: false, errors: { reason: 'No se pudo eliminar el mensaje recibido'}})";
		}
	}
	return $salida;
  }


  protected function buscarMensajes($pro_id,$usu_usuario)
  {		
	$tipoMensaje=strtolower($this->getRequestParameter('tipoMensaje'));
	
        $conexion = new Criteria();
	$conexion->setLimit($this->getRequestParameter('limit'));
	$conexion->setOffset($this->getRequestParameter('start'));
	$mensajes;
	switch($tipoMensaje){
	case "recibidos":
		$conexion->add(AgilhuMensajeRecibidoPeer::MEN_PARA,$usu_usuario);
		$conexion->add(AgilhuMensajeRecibidoPeer::MEN_PRO_ID,$pro_id);		
		$numero_mensajes = AgilhuMensajeRecibidoPeer::doCount($conexion);
		$mensajes = AgilhuMensajeRecibidoPeer::doSelect($conexion);
		break;

	case "enviados":
		$conexion->add(AgilhuMensajeEnviadoPeer::MEN_DE,$usu_usuario);
		$conexion->add(AgilhuMensajeEnviadoPeer::MEN_PRO_ID,$pro_id);
		$numero_mensajes = AgilhuMensajeEnviadoPeer::doCount($conexion);
		$mensajes = AgilhuMensajeEnviadoPeer::doSelect($conexion);		
		break;

	default:break;
	}

	$pos = 0;
	$datos;
	
	foreach ($mensajes As $mensaje)
	{

		$datos[$pos]['menId']=$mensaje->getMenId();
		$datos[$pos]['menDe']=$mensaje->getMenDe();
		$datos[$pos]['menPara']=$mensaje->getMenPara();
		$datos[$pos]['menAsunto']=$mensaje->getMenAsunto();
		$datos[$pos]['menFecha']=$mensaje->getCreatedAt();
		$datos[$pos]['menMensaje']=$mensaje->getMenMensaje();

		switch($tipoMensaje){
		case "recibidos":
			$datos[$pos]['menTipo']='<-';
		      break;
		case "enviados":
			$datos[$pos]['menTipo']='->';
			break;
		default:break;
		}

	$pos++;	
	}
	
	if($pos>0){
		$jsonresult = json_encode($datos);
		return '({"total":"'.$numero_mensajes.'","results":'.$jsonresult.'})';
	}
	else {
		return '({"total":"0", "results":""})';
	}
  }

   protected function listarMensajes($pro_id,$usu_usuario)
  {
	$conexion = new Criteria();
	$conexion->setLimit($this->getRequestParameter('limit'));
	$conexion->setOffset($this->getRequestParameter('start'));
	$conexion->add(AgilhuMensajeRecibidoPeer::MEN_PARA,$usu_usuario);
	$conexion->add(AgilhuMensajeRecibidoPeer::MEN_PRO_ID,$pro_id);
		
	$numero_mensajes = AgilhuMensajeRecibidoPeer::doCount($conexion);
	$mensajes = AgilhuMensajeRecibidoPeer::doSelect($conexion);

	$pos = 0;
	$datos;
	foreach ($mensajes As $mensaje)
	{

		$datos[$pos]['menId']=$mensaje->getMenId();
		$datos[$pos]['menDe']=$mensaje->getMenDe();
		$datos[$pos]['menPara']=$mensaje->getMenPara();
		$datos[$pos]['menAsunto']=$mensaje->getMenAsunto();

		$datos[$pos]['menFecha']=$mensaje->getCreatedAt();
		$datos[$pos]['menMensaje']=$mensaje->getMenMensaje();
		$datos[$pos]['menTipo']='<-';

		
	$pos++;	
	}
	if($pos>0){
		$jsonresult = json_encode($datos);
		return '({"total":"'.$numero_mensajes.'","results":'.$jsonresult.'})';
	}
	else {
		return '({"total":"0", "results":""})';
	}
   }


  protected function listarContactos($pro_id)
  {
	/*Los Participante debe estar asociado a el proyecto seleccionado y un rol*/

	$conexion = new Criteria();
        $conexion->setDistinct();
    	$conexion->add(AgilhuParticipantePeer::PRO_ID,$pro_id);
	$conexion->addJoin(AgilhuParticipantePeer::USU_ID,AgilhuUsuarioPeer::USU_ID);
	$conexion->add(AgilhuParticipantePeer::ESTADO,'Aceptado');
	$numero_participantes = AgilhuParticipantePeer::doCount($conexion);
    	$participantes = AgilhuUsuarioPeer::doSelect($conexion);
	
	$pos = 0;
	$datos;
	foreach ($participantes As $participante)
	{
		$datos[$pos]['usuUsuario']=$participante->getUsuUsuario();	
	$pos++;	
	}
	
	if($pos>0){
		$jsonresult = json_encode($datos);
		return '({"total":"'.$numero_participantes.'","results":'.$jsonresult.'})';
	}
	else {
		return '({"total":"0", "results":""})';
	}
  }



}
