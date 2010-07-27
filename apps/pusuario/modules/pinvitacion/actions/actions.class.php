<?php

/**
 * pinvitacion actions.
 *
 * @package    pusuario
 * @subpackage pinvitacion
 * @author     maryitsv
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
/*Falta acerle pruebas, integrar con usuario logueado y otras cositas*/
class pinvitacionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
 
  }
/**
 *A esta funcion se realizan todas las peticiones, y luego esta la dirige a la funcion correspondiente a lo que se pide
 */ 
  public function executeCargar(){
  		$task = '';
		$salida	='';

       	$task = $this->getRequest()->getParameter('task');

       	switch($task){
			
				
			case "LISTARINV":
				$salida =$this->listarInvitacionProyecto();
				break;
			
			case "DEFINIRESTADOINV":
				$salida =$this->definirInvitacionProyecto();
				break;
					
			default:
				
				$salida =  "{failure:true}";
				break;
		}

       	return $this->renderText($salida);
  }
/**
*Define si el usuario acepta o rechaza la invitación que se le realizo al proyecto 
*en caso de rechazar se elimina la invitacion
*/
protected function definirInvitacionProyecto(){
	  
	  $idPro = $this->getRequestParameter('idProyecto');
	  $idRop = $this->getRequestParameter('idRolProyecto');//usuario invitado
	  $estadoinvitacion = $this->getRequestParameter('estadoinvitacion');//usuario invitado
	

	  $conexion = new Criteria();
	  $conexion->add(AgilhuParticipantePeer::PRO_ID,$idPro); 
	  $conexion->add(AgilhuParticipantePeer::USU_ID,$this->getUser()->getAttribute('idUsuario')); 
	  $conexion->add(AgilhuParticipantePeer::ROP_ID,$idRop); 
	 // $conexion->add(AgilhuParticipantePeer::ESTADO,'por definir'); 
	  $participacion=AgilhuParticipantePeer::doSelectOne($conexion);//debe haber una y solo una invitacion con pro,usu,rop y cualquier estado
	  
	if($participacion)
	  {
	   
	      if($estadoinvitacion=='Aceptado')
	      {
		$participacion->setEstado($estadoinvitacion);
		try
		{
		  $participacion->save();
		}
		catch (Exception $excepcionUsuario)
		{
		  $exeptionErrorInvitacion = substr_count($excepcionAgilhuParticipacion->getMessage(), 'llave duplicada viola restricción de unicidad');
		  if($exeptionErrorUsuario > 0)
		  {
		    $salida = "({success: false, errors: {reason: 'No se logro'}})";
		    return $salida;
		  }
		}
		$salida = "({success: true, mensaje:'La invitacion fue aceptada '})";
	      }

	      if($estadoinvitacion=='Rechazado')
	      {
		$participacion->setEstado($estadoinvitacion);
		$participacion->save();
	          // $participacion->delete();
		 $salida = "({success: true, mensaje:'La invitacion no fue aceptada '})";
	      }
	  }
	  else{
	    $salida = "({success: true, mensaje:'La invitacion no ha sido procesada'})";
	  }

return $salida;	   
}

/**
*Con este metodo obtenemos el nombre asociado a un rol de proyecto apartir de un numero identificador, no se definen casos por fuera de lo esperado
*por que se supone que el rol debe definirse siempre para enviar una invitacion
*/
protected function getNombreRolProyecto($idRop)//-todavia no le he puesto lo del usuario-/
{
	  $conexion = new Criteria();
	  $conexion->add(AgilhuRolProyectoPeer::ROP_ID,$idRop); 
	  $rolProyecto = AgilhuRolProyectoPeer::doSelectOne($conexion);
	  
	  $nombre=$rolProyecto->getRopNombre();
	  return $nombre;
}

/**
*Con este metodo obtenemos el nombre del creador del proyecto apartir de un numero identificador
*/
protected function getNombreCreadorProyecto($idUsu)//-todavia no le he puesto lo del usuario-/
{
		$nombre='';
		$conexion = new Criteria();
		$conexion->add(AgilhuUsuarioPeer::USU_ID,$idUsu); 
		$creadorProyecto = AgilhuUsuarioPeer::doSelectOne($conexion);
		$nombre=$creadorProyecto->getUsuNombres();
		
		return $nombre;
}
/**
*Es esta funcion obtenemos un listado de las invitaciones a los proyectos en los que puede participar el usuario logueado, 
*por defecto se listan las nuevas invitaciones
*/
protected function listarInvitacionProyecto()
  {

		$estadoInvitacion= '';		
		if($this->getRequestParameter('estado')!='')
		{
		$estadoInvitacion= $this->getRequestParameter('estado');		
		}
		//consultamos a la bd
		$conexion = new Criteria();
		$conexion->add(AgilhuParticipantePeer::USU_ID,$this->getUser()->getAttribute('idUsuario')); 
		if($estadoInvitacion!='')
		{
		$conexion->add(AgilhuParticipantePeer::ESTADO,$estadoInvitacion); 
		}

		$cantidad_invitaciones= AgilhuParticipantePeer::doCount($conexion);
		$conexion->setLimit($this->getRequestParameter('limit'));
		$conexion->setOffset($this->getRequestParameter('start'));
		$invitaciones= AgilhuParticipantePeer::doSelectJoinAgilhuProyecto($conexion);		
		
		$pos = 0;
		$datos;
		foreach ($invitaciones As $invitacion)
		{
		//datos de invitacion y rol
	        $datos[$pos]['usuinvitado']=''.$invitacion->getUsuId();
		$datos[$pos]['estadoinvitacion']=$invitacion->getEstado();
		$datos[$pos]['rolproyectoinvitado']=$this->getNombreRolProyecto($invitacion->getRopId());		
		$datos[$pos]['ropid']=$invitacion->getRopId();
                $datos[$pos]['proid']=$invitacion->getProId();
                $datos[$pos]['invcreated']=$invitacion->getCreatedAt();
                //datos del proyecto
		$datos[$pos]['pronom']=$invitacion->getAgilhuProyecto()->getProNombre();
		$datos[$pos]['prosigla']=$invitacion->getAgilhuProyecto()->getProNombreCorto();
		$datos[$pos]['proarea']=$invitacion->getAgilhuProyecto()->getProAreaAplicacion();
		$creador=$invitacion->getAgilhuProyecto()->getUsuId();
		$datos[$pos]['procreador']=$this->getNombreCreadorProyecto($creador);
		$datos[$pos]['profechaini']=$invitacion->getAgilhuProyecto()->getProFechaInicio();
		$datos[$pos]['profechafin']=$invitacion->getAgilhuProyecto()->getProFechaFinalizacion();
		$datos[$pos]['proestado']=$invitacion->getAgilhuProyecto()->getProEstado();
		$datos[$pos]['prodescripcion']=$invitacion->getAgilhuProyecto()->getProDescripcion();
		$datos[$pos]['prologo']=$invitacion->getAgilhuProyecto()->getProLogo();
		
		$pos++;
		}
		if($pos>0){
 
			$jsonresult = json_encode($datos);
			return '({"total":"'.$cantidad_invitaciones.'","results":'.$jsonresult.'})';
		}
		else {

			return '({"total":"0", "results":""})';
		} 
	return '({"total":"0", "results":""})';
  }

}

