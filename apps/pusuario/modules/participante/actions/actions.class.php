<?php

/**
 * participante actions.
 *
 * @package    agilhu
 * @subpackage participante
 * @author     maryit
 * @version    SVN: $Id: actions.class.php 12479 2010-10-31 10:54:40Z fabien $
 */
class participanteActions extends sfActions
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
	$task = $this->getRequestParameter('task');

	switch($task){
		case "LISTARPARTICIPANTES":
			$salida = $this->listarParticipante();
			break;

		case "LISTARROP":
			$salida = $this->listarRol();
			break;
		
		case "ELIMINARPARTICPANTE":
			$salida = $this->eliminarParticpante();
			break;
		
		case "ELIMINARINVITACIONROL":
			$salida = $this->eliminarInvitacionRol();
			break;
		
		case "INVITAR":
			$salida = $this->invitarUsuarios();
			break;
		
		
		default:
			$salida =  "({failure:true})";
			break;
	}


	return $this->renderText($salida);
  }

public function enviarMail()
  {
   
// mail("maryitsv@gmail.com,maryitsv@hotmail.com","asuntillo","Este es el cuerpo del mensaje");
    
  }

protected function getIdUsuario($usuusuario)
{
	//este no es el nombre como tan del usurio sino su usuario_del sistema ej:juanita10we
	$conexion = new Criteria();
	$conexion->add(AgilhuUsuarioPeer::USU_USUARIO, $usuusuario);
	$usuario = AgilhuUsuarioPeer::doSelectOne($conexion);
	
     	if($usuario)
	{ 
	return $usuario->getUsuId();}
	else
	{ return 0;}

}

protected function invitarUsuario($ropnombre,$usuusuario,$proId)
{
	$ropid=$this->getIdRolProyecto($ropnombre);
	$usuid=$this->getIdUsuario($usuusuario);
	$estado='Nuevo';
	
	if(($ropid!==0) && ($usuid!==0))
	{	

		try{    	
			$participante = new AgilhuParticipante();
			$participante->setUsuId($usuid);
			$participante->setProId($proId);
			$participante->setRopId($ropid);
			$participante->setEstado($estado);
	
	
			$participante->save();

	       	$salida = true;	
		}
		catch (Exception $excepcion)
		{
		$salida = false;
		
		}
	}
	else {
	$salida = false;
	}		
return  $salida;
}

protected function verificarInvitacion($ropnombre,$usuusuario,$proId)
{
	$ropid=$this->getIdRolProyecto($ropnombre);
	$usuid=$this->getIdUsuario($usuusuario);

	
	if(($ropid!==0) && ($usuid!==0))
	{	

		$conexion = new Criteria();
		$conexion->add(AgilhuParticipantePeer::USU_ID, $usuid);
		$conexion->add(AgilhuParticipantePeer::PRO_ID, $proId);
		$conexion->add(AgilhuParticipantePeer::ROP_ID, $ropid);

		$cantidad_participantes=AgilhuParticipantePeer::doCount($conexion);

		//echo($cantidad_participantes);
		if($cantidad_participantes==0)
		{
			$salida = true;
		}
		else{
			//echo('si tsba');

			$salida = false;
		}
	}
	else {
	$salida = false;
	}		
return  $salida;
}


protected function invitarUsuarios()
{	
	$proId=$this->getUser()->getAttribute('proyectoSeleccionado');
	$invitados=split(',',$this->getRequestParameter('nuevosInvitados'));
	$ropNombre=$this->getRequestParameter('ropNombre');
	$personalnoencontrado='';
	$personalyainvitado='';


	foreach ($invitados as $invitado)
	{
		if($this->verificarInvitacion($ropNombre,$invitado,$proId))	
		{	
			if($this->invitarUsuario($ropNombre,$invitado,$proId))
			{}
			else
			{
			$personalnoencontrado.=$invitado;
			}
		}
		else
		{
		$personalyainvitado.=$invitado;
		}
	}//casos que se pueden presentar
	if($personalnoencontrado!=='')
	{
	return $salida = "({success: true, mensaje:'Los sgts usuarios no han sido invitados ".$personalnoencontrado." , <br/> personal que ya estaba invitado".$personalyainvitado."'})";
	}
    	else
 	{
		if($personalyainvitado!=='')
		{
		return $salida = "({success: true, mensaje:'Los sgts usuarios ya estaban invitados ".$personalyainvitado."'})";
		}

		else
		{
	   	return $salida = "({success: true, mensaje:'Todos han sido invitados de forma satisfactoria'})";
		}
	}    
}


	protected function eliminarParticpante()
	{
		try{
			$ids_usu = json_decode($this->getRequestParameter('ids_usu'));
			$pro_id=$this->getUser()->getAttribute('proyectoSeleccionado');

			foreach ($ids_usu as $usu_id)
			{

			$conexion = new Criteria();
			$conexion->add(AgilhuParticipantePeer::USU_ID, $usu_id);
			$conexion->add(AgilhuParticipantePeer::PRO_ID, $pro_id);

			$participantes = AgilhuParticipantePeer::doSelect($conexion);

				foreach ($participantes as $elemento)
				{
					$elemento->delete();
				}
				$salida = "({success: true, mensaje:'La invitacion fue eliminada exitosamente'})";
				
			}
		}
		catch(Exception $excepcion){
			$salida = "({success: false, errors: { reason: 'No se pudo eliminar la invitacion'}})";
		}

		return $salida;
	}
	
	protected function eliminarInvitacionRol()
	{
		$temp=$this->getRequestParameter('roles');
		$ids_rop = json_decode($temp);
		$usu_id = $this->getRequestParameter('usuID');
		$pro_id=$this->getUser()->getAttribute('proyectoSeleccionado');
	
		$cant_inv_eliminadas=0;
		$cant_total=0;
		foreach ($ids_rop as $rop_id)
		{
		
		$conexion = new Criteria();
		$conexion->add(AgilhuParticipantePeer::ROP_ID, $rop_id);
		$conexion->add(AgilhuParticipantePeer::USU_ID, $usu_id);
		$conexion->add(AgilhuParticipantePeer::PRO_ID, $pro_id);		
		$invitaciones = AgilhuParticipantePeer::doSelect($conexion);
		
		$cant_total++;
		foreach ($invitaciones as $invitacion)
		{
			$invitacion->delete();
			$cant_inv_eliminadas++;
		}
		
		if($cant_inv_eliminadas==$cant_total)
		{
		$salida = "({success: true, mensaje:'La invitacion fue eliminada exitosamente'})";
		}
		else{
		$salida = "({success: false, errors: { reason: 'No se pudo eliminar la invitacion'}})";
		}
		}

		return $salida;
	}
	
	
		
	protected function getIdRolProyecto($ropnombre)
	{
		$conexion = new Criteria();
		$conexion->setIgnoreCase(true);
		$conexion->add(AgilhuRolProyectoPeer::ROP_NOMBRE, $ropnombre);
		$rop = AgilhuRolProyectoPeer::doSelectOne($conexion);
	
		if($rop)
		{	
		return $rop->getRopId();}
		else
		{
		 return 0;
		}
	}


	protected function getRolesParticipantes($usuId,$proId)
	{
		$conexion = new Criteria();
		$conexion->addJoin(AgilhuParticipantePeer::ROP_ID,AgilhuRolProyectoPeer::ROP_ID);
		                
		$conexion->add(AgilhuParticipantePeer::PRO_ID,$proId);
                $conexion->add(AgilhuParticipantePeer::USU_ID,$usuId);
		$conexion->add(AgilhuParticipantePeer::ESTADO,'Aceptado');
		
		$roles = AgilhuRolProyectoPeer::doSelect($conexion);
		
		$pos = 0;
		$dataroles;
		
		foreach ($roles As $rol)
		{

			$dataroles[$pos]['ropId']=$rol->getRopId();
			$dataroles[$pos]['ropNombre']=ucfirst($rol->getRopNombre());

		$pos++;
		}
		
		return $dataroles;
		
	}

	protected function listarParticipante()
	{
		/*Los Participante debe estar asociado a el proyecto seleccionado y un rol*/
	    $proId=$this->getUser()->getAttribute('proyectoSeleccionado');
	    $ropNombre=$this->getRequestParameter('ropNombre');
	    $ropId=$this->getIdRolProyecto($ropNombre);
	    
		$conexion = new Criteria();
                $conexion->setDistinct();
	    	$conexion->add(AgilhuParticipantePeer::PRO_ID,$proId);
		$conexion->addJoin(AgilhuParticipantePeer::USU_ID,AgilhuUsuarioPeer::USU_ID);
		if($ropId!==0)
		{
		$conexion->add(AgilhuParticipantePeer::ROP_ID,$ropId);
		}
		$conexion->add(AgilhuParticipantePeer::ESTADO,'Aceptado');
		
		$numero_participantes = AgilhuUsuarioPeer::doCount($conexion);//cambio correccion paginador

	    	$conexion->setLimit($this->getRequestParameter('limit'));
		$conexion->setOffset($this->getRequestParameter('start'));
		$participantes = AgilhuUsuarioPeer::doSelect($conexion);
		
		$pos = 0;
		$nbrows=0;
		$datos;
		
		foreach ($participantes As $participante)
		{

			$datos[$pos]['parUsuId']=$participante->getUsuId();
			$datos[$pos]['parUsuario']=$participante->getUsuUsuario();
			$datos[$pos]['parNombres']=$participante->getUsuNombres();
			$datos[$pos]['parApellidos']=$participante->getUsuApellidos();
			$datos[$pos]['parCorreo']=$participante->getUsuCorreo();
                        $datos[$pos]['roles']=json_encode($this->getRolesParticipantes($participante->getUsuId(),$proId));
			
		$pos++;
		$nbrows++;	
		}
		
		if($nbrows>0){
			$jsonresult = json_encode($datos);
			return '({"total":"'.$numero_participantes.'","results":'.$jsonresult.'})';
		}
		else {
			return '({"total":"0", "results":""})';
		}
	}


	protected function listarRol()
	{
		$conexion = new Criteria();	    
		$numero_participantes = AgilhuRolProyectoPeer::doCount($conexion);		
		$roles = AgilhuRolProyectoPeer::doSelect($conexion);
		
		$pos = 0;
		$datos;
		foreach ($roles As $rol)
		{

			$datos[$pos]['ropId']=$rol->getRopId();
			$datos[$pos]['ropNombre']=ucfirst($rol->getRopNombre());
			
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
