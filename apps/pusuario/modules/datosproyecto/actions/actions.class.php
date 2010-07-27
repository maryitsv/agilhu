<?php

/**
 * datosproyecto actions.
 *
 * @package    agilhu
 * @subpackage datosproyecto
 * @author     maryit sanchez
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class datosproyectoActions extends sfActions
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
 *@author Maryit Sanchez
 *@date 2010-04-18 
 */ 
  public function executeCargar(){
        $task = '';
        $salida	='';

        $task = $this->getRequest()->getParameter('task');
        $pro_id=$this->getUser()->getAttribute('proyectoSeleccionado');

       	switch($task){
				
            case "LISTARPROYECTO":
                 $salida = $this->obtenerProyecto($pro_id);
                 break;
				
            case "DIAGRAMAHISxMODULO":
                 $salida = $this->diagramaHisxModulo($pro_id);
                 break;
				
            case "DIAGRAMAHISxPARTICIPANTE":
                 $salida = $this->diagramaHisxParticipante($pro_id);
                 break;
											
            default:
                 $salida =  "{failure:true}";
                 break;
       }

       	return $this->renderText($salida);
  }

  
 /**
 *Es esta funcion obtenemos los nombre del usuario que lo creo
 *@author Maryit Sanchez
 *@date 2010-04-18 
 */
 protected function getNombreUsuario($usu_id)
 {
        $nombreCompleto='';
        try{
        $conexion = new Criteria();
        $conexion->add(AgilhuUsuarioPeer::USU_ID,$usu_id); 
        $creadorProyecto = AgilhuUsuarioPeer::doSelectOne($conexion);
        $nombreCompleto=$creadorProyecto->getUsuNombres();
        $nombreCompleto.=' '.$creadorProyecto->getUsuApellidos();
        }
        catch(Exception $e){
        echo('no encuentro el usuario');
        }

        return $nombreCompleto;
 }

 /**
 *Es esta funcion obtenemos los datos del proyecto seleccionado
 *@author Maryit Sanchez
 *@date 2010-04-18 
 */
 protected function obtenerProyecto($pro_id)
  {
        $conexion = new Criteria();
        $conexion->add(AgilhuProyectoPeer::PRO_ID,$pro_id);
        $proyecto = AgilhuProyectoPeer::doSelectOne($conexion);
		
        $pos = 0;
        $datos;
        if($proyecto){
            //datos no editables
            $datos[$pos]['proid']=$proyecto->getProId();
            $datos[$pos]['procreador']=$this->getNombreUsuario($proyecto->getUsuId());
            $datos[$pos]['procreatedat']=$proyecto->getCreatedAt();
            $datos[$pos]['proupdatedat']=$proyecto->getUpdatedAt();		
            //datos editables
            $datos[$pos]['prosigla']=$proyecto->getProNombreCorto();
            $datos[$pos]['pronom']=$proyecto->getProNombre();
            $datos[$pos]['proareaaplicacion']=$proyecto->getProAreaAplicacion();
            $datos[$pos]['prodescripcion']=$proyecto->getProDescripcion();
            $datos[$pos]['profechaini']=$proyecto->getProFechaInicio();
            $datos[$pos]['profechafin']=$proyecto->getProFechaFinalizacion();
            $datos[$pos]['proestado']=$proyecto->getProEstado();
            $datos[$pos]['prologo']=$proyecto->getProLogo();
            $pos++;
        }
        if($pos>0){
              $jsonresult = json_encode($datos);
              return '({"total":"1","results":'.$jsonresult.'})';
        }
        else {
              return '({"total":"0", "results":""})';
        }
  }
  
 /**
 *Es esta funcion obtenemos datos estadisticos que describen la cantidad de historias por modulo
 *@author Maryit Sanchez
 *@date 2010-04-18 
 */
 protected function diagramaHisxModulo($pro_id)
  {
        $conexion = new Criteria();
        $conexion->add(AgilhuModuloPeer::PRO_ID,$pro_id);
        $modulos = AgilhuModuloPeer::doSelect($conexion);
        $pos = 0;
        $datos;
        foreach ($modulos As $modulo)
        {
               $datos[$pos]['modNombre']=$modulo->getModNombre();		
               $datos[$pos]['cantHu']=$this->getCantHuxModulo($pro_id,$modulo->getModId());
              $pos++;
        }
        if($pos>0){
           $jsonresult = json_encode($datos);
           return '({"total":"'.$pos.'","results":'.$jsonresult.'})';
        }
        else {
            return '({"total":"0", "results":""})';
        }
  }
  
  
   /**
 *Esta funcion retorna la cantidad de hu de un modulo y un proyecto,
 *teniendo en cuenta solo los identificadores distintos de las historias de usuario
 *@author Maryit Sanchez
 *@date 2010-04-18 
 */
 protected function getCantHuxModulo($pro_id,$mod_id)
 {
	$conexion = new Criteria();
	$conexion->clearSelectColumns();
	$conexion->setDistinct();
	$conexion->add(AgilhuHistoriaUsuarioPeer::MOD_ID, $mod_id);
	$conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
	$conexion->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
	
	$historias = AgilhuHistoriaUsuarioPeer::doSelectStmt($conexion);
	$cant=0;
	while ($historia = $historias->fetch(PDO::FETCH_NUM)) {
	 $cant++;//contamos las hu distintas
	} 
    return $cant;
 }
 
 /**
 *Es esta funcion obtenemos datos estadisticos que describen la cantidad de historias por participante
 *Ya sea por creacion o por responsabilidad
 *@author Maryit Sanchez
 *@date 2010-04-18 
 */
 protected function diagramaHisxParticipante($pro_id)
  {
      /* $conexion = new Criteria();
       $conexion->add(AgilhuParticipantePeer::PRO_ID,$pro_id);
       $participantes = AgilhuParticipantePeer::doSelect($conexion);*/
       $pos = 0;
       $datos;
      $conexion = new Criteria();
      $conexion->clearSelectColumns();
      $conexion->setDistinct();
      $conexion->add(AgilhuParticipantePeer::PRO_ID,$pro_id);
      $conexion->addSelectColumn(AgilhuParticipantePeer::USU_ID);
	
      $participantes = AgilhuParticipantePeer::doSelectStmt($conexion);
      $cant=0;
      while ($participante = $participantes->fetch(PDO::FETCH_NUM)) {
        $datos[$pos]['usuNombre']=$this->getNombreUsuario($participante[0]);		
        $datos[$pos]['cantHuCreadas']=$this->getCantHuxParticipanteCreador($pro_id,$participante[0]);//his_creador int
        $datos[$pos]['cantHuResponsable']=$this->getCantHuxParticipanteResponsable($pro_id,$participante[0]);//his_responsable string login
   //++ $datos[$pos]['cantHuTesteadas']=$this->getCantHuxParticipanteTesteadas($pro_id,$participante->getUsuId());//usu_evaluador_id int
        $pos++;
      } 
      if($pos>0){
          $jsonresult = json_encode($datos);
          return '({"total":"'.$pos.'","results":'.$jsonresult.'})';
      }
      else {
          return '({"total":"0", "results":""})';
      }
  } 
  
  
 /**
 *Esta funcion retorna la cantidad de hu que un participante ha creado en un proyecto,
 *teniendo en cuenta solo los identificadores distintos de las historias de usuario
 *@author Maryit Sanchez
 *@date 2010-04-19 /
 */
 protected function getCantHuxParticipanteCreador($pro_id,$par_id)
 {
      $conexion = new Criteria();
      $conexion->clearSelectColumns();
      $conexion->setDistinct();
      $conexion->add(AgilhuHistoriaUsuarioPeer::HIS_CREADOR, $par_id);
      $conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
      $conexion->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
      
      $historias = AgilhuHistoriaUsuarioPeer::doSelectStmt($conexion);
      $cant=0;
      while ($historia = $historias->fetch(PDO::FETCH_NUM)) {
         $cant++;//contamos las hu distintas
      } 
    return $cant;
 }

 /**
 *Esta funcion retorna la cantidad de hu que un participante es responsable en un proyecto,
 *teniendo en cuenta solo los identificadores distintos de las historias de usuario
 *@author Maryit Sanchez
 *@date 2010-04-19 /
 */
 protected function getCantHuxParticipanteResponsable($pro_id,$par_id)
 {
      $cant=0;
       //treamos el login del usuario porque es asi como lo viculamos con el responsable de la hu
      $conexionusuario = new Criteria();
      $conexionusuario->add(AgilhuUsuarioPeer::USU_ID, $par_id);
      $usuario = AgilhuUsuarioPeer::doSelectOne($conexionusuario);
        
      $usu_usuario=$usuario->getUsuUsuario();

      //consulta la cant
      $conexion = new Criteria();
      $conexion->clearSelectColumns();
      $conexion->setDistinct();
      $conexion->add(AgilhuHistoriaUsuarioPeer::HIS_RESPONSABLE, '%'.$usu_usuario.'%',Criteria::LIKE);
      $conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
      $conexion->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
	
      $historias = AgilhuHistoriaUsuarioPeer::doSelectStmt($conexion);
	
      while ($historia = $historias->fetch(PDO::FETCH_NUM)) {
        $cant++;//contamos las hu distintas
      } 
    return $cant;
 }
}
