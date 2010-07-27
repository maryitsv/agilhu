<?php

/**
 * listaproyectos actions.
 *
 * @package    agilhu
 * @subpackage listaproyectos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class listaproyectosActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
  }


public function executeCargar(){
  		$task = '';
		$salida	='';

       	$task = $this->getRequest()->getParameter('task');

       	switch($task){
			
				
			case "LISTARPRO":
				$salida =$this->listarInvitacionProyecto();
				break;
			
			case "SELECIONPRO":
				$salida =$this->selecionarProyecto();
				break;
					
			default:
				
				$salida =  "{failure:true}";
				break;
		}

       	return $this->renderText($salida);
  }

protected function getNombreCreadorProyecto($idUsu)//-todavia no le he puesto lo del usuario-/
{
		$nombre='';
		$conexion = new Criteria();
		$conexion->add(AgilhuUsuarioPeer::USU_ID,$idUsu); 
		$creadorProyecto = AgilhuUsuarioPeer::doSelectOne($conexion);
		$nombre=$creadorProyecto->getUsuNombres();
		
		return $nombre;
}

protected function selecionarProyecto()
{
	$pro_id=$this->getRequestParameter('idproyecto');

	if($pro_id)
	{
	$this->getUser()->setAttribute('proyectoSeleccionado',$pro_id);
	$conexion = new Criteria();

	$conexion->addJoin(AgilhuParticipantePeer::ROP_ID,AgilhuRolProyectoPeer::ROP_ID); 
	$conexion->add(AgilhuParticipantePeer::USU_ID,$this->getUser()->getAttribute('idUsuario')); 
	$conexion->add(AgilhuParticipantePeer::ESTADO,'Aceptado'); 
	$conexion->add(AgilhuParticipantePeer::PRO_ID,$pro_id); 	
	$roles= AgilhuRolProyectoPeer::doSelect($conexion);
	
	$pos = 0;
	$nbrows=0;
	$datos;
		foreach ($roles As $rol)
		{
		
		$datos[$pos]=$rol->getRopNombre();

		$pos++;
		$nbrows++;
		}
		if($nbrows>0){
 
			$jsonresult = json_encode($datos);
			return '({success:true,data:'.$jsonresult.'})';
		}
		else {

			return '';
		} 
	
	}

return '';

}

protected function listarInvitacionProyecto()
  {
/*
select agilhu_proyecto.*,agilhu_participante.estado  from agilhu_participante, agilhu_proyecto  where agilhu_participante.usu_id=2 and agilhu_participante.pro_id=agilhu_proyecto.pro_id;
*/
		
		$conexion = new Criteria();
		
		$conexion->setDistinct();
		$conexion->add(AgilhuParticipantePeer::USU_ID,$this->getUser()->getAttribute('idUsuario')); 
		$conexion->add(AgilhuParticipantePeer::ESTADO,'Aceptado'); 
		$conexion->addJoin(AgilhuParticipantePeer::PRO_ID,AgilhuProyectoPeer::PRO_ID); 
		$invitaciones= AgilhuProyectoPeer::doSelect($conexion);
                        
  
		$pos = 0;
		$nbrows=0;
		$datos;
		foreach ($invitaciones As $invitacion)
		{
		
	       
		//$datos[$pos]['estadoinvitacion']=$invitacion->getEstado();
               
		$datos[$pos]['proid']=$invitacion->getProId();
		$datos[$pos]['pronom']=$invitacion->getProNombre();
		$datos[$pos]['prosigla']=$invitacion->getProNombreCorto();
		$datos[$pos]['proarea']=$invitacion->getProAreaAplicacion();
		$creador=$invitacion->getUsuId();
		$datos[$pos]['procreador']=$this->getNombreCreadorProyecto($creador);
		$datos[$pos]['profechaini']=$invitacion->getProFechaInicio();
		$datos[$pos]['profechafin']=$invitacion->getProFechaFinalizacion();
		$datos[$pos]['proestado']=$invitacion->getProEstado();
		$datos[$pos]['prologo']=$invitacion->getProLogo();
		$datos[$pos]['prodescripcion']=$invitacion->getProDescripcion();


		
		$pos++;
		$nbrows++;
		}
		if($nbrows>0){
 
			$jsonresult = json_encode($datos);
			return '({"total":"'.$cantidad_invitaciones.'","results":'.$jsonresult.'})';
		}
		else {

			return '({"total":"0", "results":""})';
		} 
	return '({"total":"0", "results":""})';
  }


}
