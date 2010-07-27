<?php

/**
 * proyecto actions.
 *
 * @package    pusuario
 * @subpackage proyecto
 * @author     maryit
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class proyectoActions extends sfActions
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
			case "CREATEPROY":
				$salida = $this->crearProyecto();
				break;
				
			case "LISTARPROY":
				$salida = $this->listarProyecto();
				break;
				
			case "UPDATEPROY":
				$salida = $this->actualizarProyecto();
				break;
			
			case "DELETEPROY":
				$salida = $this->eliminarProyecto();
				break;
				
			case "CONTACTOS":
				$salida = $this->getConocidos();
				break;
			
				
			default:
				$salida =  "{failure:true}";
				break;
		}

       	return $this->renderText($salida);
  }




/**
*Es esta funcion obtenemos un listado de todos los proyectos en los que puede participar el usuario logueado
*/
protected function listarProyecto()//-todavia no le he puesto lo del usuario-/
  {
  		$conexion = new Criteria();
		$cantidad_Proyectos = AgilhuProyectoPeer::doCount($conexion);
	        $conexion->add(AgilhuProyectoPeer::USU_ID, $this->getUser()->getAttribute('idUsuario'));//donde el usuario registrado es el creador
		$conexion->setLimit($this->getRequestParameter('limit'));
		$conexion->setOffset($this->getRequestParameter('start'));
		
	
		//aqui agregar los if necesarios, para suplir todas las peticiones de este mismo tipo, terminados, nuevos,en proceso.etc
	
		$proyectos = AgilhuProyectoPeer::doSelect($conexion);
		
		$pos = 0;
		$nbrows=0;
		$datos;
		foreach ($proyectos As $proyecto)
		{
			$datos[$pos]['proid']=$proyecto->getProId();
            
            $datos[$pos]['prosigla']=$proyecto->getProNombreCorto();
            $datos[$pos]['pronom']=$proyecto->getProNombre();
            $datos[$pos]['proareaaplicacion']=$proyecto->getProAreaAplicacion();
            $datos[$pos]['prodescripcion']=$proyecto->getProDescripcion();
	    $datos[$pos]['profechaini']=$proyecto->getProFechaInicio();
            $datos[$pos]['profechafin']=$proyecto->getProFechaFinalizacion();
            $datos[$pos]['proestado']=$proyecto->getProEstado();
            $datos[$pos]['prologo']=$proyecto->getProLogo();
            
            $pos++;
            $nbrows++;
		}
		if($nbrows>0){
			$jsonresult = json_encode($datos);
			return '({"total":"'.$cantidad_Proyectos.'","results":'.$jsonresult.'})';
		}
		else {
			return '({"total":"0", "results":""})';
		}
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

protected function getIdRolProyecto($ropnombre)
{
	$conexion = new Criteria();
	$conexion->add(AgilhuRolProyectoPeer::ROP_NOMBRE, $ropnombre);
	$rop = AgilhuRolProyectoPeer::doSelectOne($conexion);

	if($rop)
	{return $rop->getRopId();}
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
			
		}
		catch (Exception $excepcion)
		{
		$salida = false;
		echo('hubo un error al tratar de salvar un participante');
		}
		$salida = true;
	}
	else {
	$salida = false;
	//echo('el usuario o el rol no existen en el sistema'.$ropnombre.' : '.$usuusuario);
	}		
return  $salida;
}

protected function invitarUsuarioCreador($ropnombre,$usuusuario,$proId)
{
	$ropid=$this->getIdRolProyecto($ropnombre);
	$usuid=$this->getIdUsuario($usuusuario);
	$estado='Aceptado';
	
	if(($ropid!==0) && ($usuid!==0))
	{	
		try{    	
		
			$participante = new AgilhuParticipante();
		
			$participante->setUsuId($usuid);
			$participante->setProId($proId);
			$participante->setRopId($ropid);
			$participante->setEstado($estado);
		
			$participante->save();
			
		}
		catch (Exception $excepcion)
		{
		$salida = false;
		echo('hubo un error al tratar de salvar un participante');
		}
		$salida = true;
	}
	else {
	$salida = false;
	//echo('el usuario o el rol no existen en el sistema'.$ropnombre.' : '.$usuusuario);
	}		
return  $salida;
}

public function enviarMail()
  {
echo('enviando mail ');
 
  }
/*dado un arreglo de usuarios realiza invitaciones a cada uno en un rol especifico y un proyecto*/
protected function invitarUsuariosAuxiliar($rol,$grupopersonas,$proId)
{
$personalnoencontrado="";
	if(count($grupopersonas)>0)
	{
		foreach ($grupopersonas as $persona)
		{
			
			if($this->invitarUsuario($rol,$persona,$proId))
			{}
			else
			{
			$personalnoencontrado.=$persona;
			}
		}
	}
return $personalnoencontrado;
}
/*captura los loins de los usuarios que han sido invitados, los preprocesa y los manda a invitar*/
protected function invitarUsuarios($proId)
{

	$programadores=split(',',$this->getRequestParameter('agPro_programador'));
	$administradores=split(',',$this->getRequestParameter('agPro_administrador'));
	$testers=split(',',$this->getRequestParameter('agPro_tester'));
	$clientes=split(',',$this->getRequestParameter('agPro_cliente'));
	$personalnoencontrado="";
	
	$personalnoencontrado.=$this->invitarUsuariosAuxiliar('programador',$programadores,$proId);
	$personalnoencontrado.=$this->invitarUsuariosAuxiliar('administrador',$administradores,$proId);
	$personalnoencontrado.=$this->invitarUsuariosAuxiliar('tester',$testers,$proId);
	$personalnoencontrado.=$this->invitarUsuariosAuxiliar('cliente',$clientes,$proId);
	

	return $personalnoencontrado;
}

/*esta funcion guarda el logo del proyecto en la base de datos, basicamente se guarda como un documento en la base de datos y se vincula el id del documento al proyecto*/
protected function guardarLogo($sigla,$idpro)
{
	$tamano = $_FILES['agPro_logo']['size'];
	$tipo = $_FILES['agPro_logo']['type'];
	$temporal = $_FILES['agPro_logo']['tmp_name'];

	if($sigla!='' && ($tipo=='image/png' || $tipo=='image/jpeg' || $tipo=='image/gif') )
	{
	$doc = new AgilhuDocumento();
	$doc->setDocNombre($sigla);
	$doc->setDocDescripcion('no cambie ni elimine');
	$doc->setDocIdPro($idpro);
	$doc->setDocIdRemitente($this->getUser()->getAttribute('idUsuario'));
	$doc->setDocIdMod(0);
	$doc->setDocIdHis(0);
	$doc->setDocVisibilidad('privada');

	sleep(1);
	$fp = fopen($temporal, "rb");
	$contenido = fread($fp, $tamano);
	fclose($fp); 
	$doc->setDocTamano(''.$tamano);
	$doc->setDocTipo(''.$tipo);
	$doc->setDocContenido(''.$contenido);
	$doc->save();
        return $doc->getDocId();
	
	}
return 0;
}



 /**
 *Aqui se crea un proyecto y se invita aus creador
 */ 
  protected function crearProyecto()
  {
   $salida	="({success: true, mensaje:'El proyecto fue creado exitosamente'})";
   $personalNoencontrado="";		
      try{    	
		
	$proyecto = new AgilhuProyecto();
	$proyecto->setUsuId($this->getUser()->getAttribute('idUsuario'));
	$proyecto->setProNombreCorto($this->getRequestParameter('agPro_nomcorto'));
	$proyecto->setProNombre($this->getRequestParameter('agPro_nombre'));
	$proyecto->setProAreaAplicacion($this->getRequestParameter('agPro_areapli'));
	$proyecto->setProDescripcion($this->getRequestParameter('agPro_descripcion'));
	$proyecto->setProFechaInicio($this->getRequestParameter('agPro_fecini'));
	$proyecto->setProFechaFinalizacion($this->getRequestParameter('agPro_fecfin'));
	$proyecto->setProEstado('creado');//por defecto este es el estado de un proyecto
	$proyecto->save();			
	//guardamos el logo
	$logo=$this->guardarLogo($proyecto->getProNombreCorto(),$proyecto->getProId());
	$proyecto->setProLogo($logo);
	$proyecto->save();
	//una vez creamos el proyecto damos una invitacion al creador
	$persona=$this->getUser()->getAttribute('usuUsuario');
	$this->invitarUsuarioCreador('administrador',$persona,$proyecto->getProId());

	//invitamos a las personas que el usuario haya indicado
	$personalNoencontrado=$this->invitarUsuarios($proyecto->getProId());
	
	}
	catch (Exception $excepcion)
	{
	$salida = "({success: false, errors: { reason: 'Error al crear el proyecto'}})";
	return $salida;
	}
	if($personalNoencontrado=="")
	{$salida = "({success: true, mensaje:'El proyecto fue creado exitosamente'})";}
	else
	{$salida = "({success: true, mensaje:'El proyecto fue creado exitosamente, pero los sgts usuarios no se han invitado $personalNoencontrado'})";}
	
	
   return $salida;
   }
  
  /*se actualizan los daots del proyecto*/
	protected function actualizarProyecto()
	{
	
		$progId = $this->getRequestParameter('proid');
		$conexion = new Criteria();
		$conexion->add(AgilhuProyectoPeer::PRO_ID, $progId);
		$proyecto = AgilhuProyectoPeer::doSelectOne($conexion);
		$salida = '';

		if($proyecto)
		{
				$proyecto->setProNombreCorto($this->getRequestParameter('prosigla'));
				$proyecto->setProNombre($this->getRequestParameter('pronom'));
				$proyecto->setProDescripcion($this->getRequestParameter('prodescripcion')); 
				
				$proyecto->setProAreaAplicacion($this->getRequestParameter('proareaaplicacion'));
			        $proyecto->setProEstado($this->getRequestParameter('proestado'));
				$proyecto->setProFechaInicio($this->getRequestParameter('profechafin'));
			        $proyecto->setProFechaFinalizacion($this->getRequestParameter('profechafin'));
			
			  	try
		      	{
		        	$proyecto->save();
		      	}
		      	catch (Exception $excepcionModulo)
		      	{
		          	$salida = "({success: false, errors: { reason: 'Problemas al actualizar el proyecto: ".$this->getRequestParameter('prognombre')."'}})";
		          	return $salida;
		        
		      	}
				$salida = "({success: true, mensaje:'El proyecto fue actualizado exitosamente'})";
		} else {
			$salida = "({success: false, errors: { reason: 'No se a actualizado el proyecto corecctamente'}})";
		}
	
		return $salida;
	}

/*Elimina un proyecto pero no pueden haber llaves foraneas a este*/
	protected function eliminarProyecto()
	{
		try{
			$ids = $this->getRequestParameter('idproyecto');
			$id_Parcial = json_decode($ids);
			$idDefinitivo;
			foreach ($id_Parcial as $identificador)
			{
				$idDefinitivo = $identificador;
			}

			$conexion = new Criteria();
			$conexion->add(AgilhuProyectoPeer::PRO_ID, $idDefinitivo);
			if($conexion)
			{
				$delProyecto = AgilhuProyectoPeer::doSelect($conexion);
				foreach ($delProyecto as $elemento)
				{
					$elemento->delete();
				}
				$salida = "({success: true, mensaje:'El Proyecto fue eliminado exitosamente'})";
			}
			else
			{
				$salida = "({success: false, errors: { reason: 'No se pudo eliminar el Proyecto'}})";
			}
		}catch(Exception $e){
			$salida = "({success: false, errors: { reason: 'Problemas con claves primarias'}})";
		}

		return $salida;
	}


  	
  /*@author Maryit Sanchez
  *@date 2010-04-28
  *Retorna una lista de todas las personas con las que he compartido proyectos
  *esto pensando en que yo soy el creador del proyecto, e invitar a las personas que usualmente invito*/
	protected function getConocidos()
	{
	    $salida = '';
		$datos;
	    $usu_id= $this->getUser()->getAttribute('idUsuario'); //usuario logueado
		
	    try{
			//para recuperar los proyectos que he creado
			$conexion = new Criteria();
			$conexion->add(AgilhuProyectoPeer::USU_ID, $usu_id);//CREADOR
			$proyectos = AgilhuProyectoPeer::doSelect($conexion);

			$proyectoCreadosPorUsuario;
			foreach($proyectos As $proyecto)
			{
			$proyectoCreadosPorUsuario[]=$proyecto->getProId();
			//echo($proyecto->getProId());
			}
			 //para recuperar a mis companeros
			$conexionParticipante = new Criteria();
			
			$conexionParticipante->clearSelectColumns();
			$conexionParticipante->setDistinct();
			$conexionParticipante->addSelectColumn(AgilhuUsuarioPeer::USU_USUARIO);

			$conexionParticipante->addJoin(AgilhuParticipantePeer::USU_ID,AgilhuUsuarioPeer::USU_ID);
            $conexionParticipante->add(AgilhuParticipantePeer::PRO_ID,$proyectoCreadosPorUsuario, Criteria::IN);
			
			$participantes = AgilhuHistoriaUsuarioPeer::doSelectStmt($conexionParticipante);
			$fila=0;
			while ($participante = $participantes->fetch(PDO::FETCH_NUM)) {
				$datos[$fila]['usu_usuario']=$participante[0];//usu_usuario
				$fila++;
			}
        }
		catch (Exception $excepcionModulo)
		{
			$salida = "({success: false, errors: { reason: 'Problemas al actualizar el proyecto: '}})";		
		}
		
		if((count($datos))>0){
			$jsonresult = json_encode($datos);
			return '({"total":"'.count($datos).'","results":'.$jsonresult.'})';
		}
		else {
			return '({"total":"0", "results":""})';
		}
	
		return $salida;
	}

  
}
