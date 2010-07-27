<?php

/**
 * pruebaexperto actions.
 *
 * @package    agilhu
 * @subpackage pruebaexperto
 * @author     Luis Armando Nuñez
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class pruebaexpertoActions extends sfActions
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


  /**
  * En esta accion se almacena la evaluacion echa por un tester a una historia 
  * de usuario
  *
  * @author Luis Armando Nuñez
  * @since 2010-3-10
  * @param his_id el identificador de la historia de usuario a evaluar
  */
  public function executeProbar()
  {
    $usu_registrado_id=$this->getUser()->getAttribute('idUsuario');
    //tambien hay que pasar el identificador del usuario que esta probando la historia 
    $prueba = new AgilhuPruebaExperto();
    $prueba->setPruFechaEvalucion(date("Y-m-d, H:m:s")); //especificar el timestamp en php mirar en symfony como lo hace continua Especificar una fecha valida
    $prueba->setHisIdAsociada($this->getRequest()->getParameter('his_id'));
    $prueba->setUsuEvaluadorId($usu_registrado_id);//este valor se toma de la seccion del usuario
    $prueba->setPruComentarios($this->getRequest()->getParameter('comentarios'));
    $prueba->setPruIndependiente($this->getRequest()->getParameter('independiente'));
    $prueba->setPruNegociable($this->getRequest()->getParameter('negociable'));
    $prueba->setPruValiosa($this->getRequest()->getParameter('valiosa'));
    $prueba->setPruEstimable($this->getRequest()->getParameter('estimable'));
    $prueba->setPruPequena($this->getRequest()->getParameter('pequena'));
    $prueba->setPruTesteable($this->getRequest()->getParameter('testeable'));
    //falta calcular el promedio de la prueba de con sus correspondiente ponderacion para cada
    //caracteristica de calida
    $prueba->save();
    
    $salida = "{success:false, msg: 'Prueba no realizada' }";
    if(isset($prueba))
    {
      
      $salida = "{success:true, msg: 'Prueba realizada' }";
    }
    return $this->renderText($salida);
  }
  
  
  
  /**
  * En esta accion se maneja los listados necesarios para la vista, 
  * los listados de todas las historias de usuario pertenecientes a un determinado 
  * proyecto.
  *
  * @author Luis Armando Nuñez
  * @since 2010-3-10
  * @param task la tarea a ejecutar
  */
  public function executeListar()
  {
    $task = $this->getRequest()->getParameter('task');
    switch($task)
    {  
      case "hispro":
        $salida = $this->listarHUxProyecto();
        break;
      
      default:
        $salida =  "{failure:true}";
    }
    
    return $this->renderText($salida);
  }
  
  /*actualizado por maryit sanchez el 16 abril 2010*/
  /**
  *Este metodo devuelve la lista de las historias de usuario que pertenecen a 
  *un proyecto determinado por el id pasado como parametro
  *
  *@author Luis Armando Nuñez
  *@since 2010-3-10
  *@param id identificador del proyecto
  *//*
  private function listarHUxProyecto()
  {
    //selecciono todos las historias de usuario que no han sido probadas
    $pro_id  = $this->getUser()->getAttribute('proyectoSeleccionado');
    $fila=0;
    $datos;
  
    $c = new Criteria();
    $c->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $c->addJoin(AgilhuHistoriaUsuarioPeer::HIS_ID, AgilhuPruebaExpertoPeer::HIS_ID_ASOCIADA,Criteria::LEFT_JOIN);
    
    $historias = AgilhuHistoriaUsuarioPeer::doSelect($c);
    foreach($historias As $historia)
    {
      $datos[$fila]['his_id'] = $historia->getHisId();
      $datos[$fila]['mod_id'] = $historia->getModId();
      $datos[$fila]['his_identificador_historia'] = $historia->getHisIdentificadorHistoria();
      $datos[$fila]['his_nombre'] = $historia->getHisNombre();
      $datos[$fila]['created_at'] = $historia->getCreatedAt(); //timestamp
      $datos[$fila]['his_creador'] = $historia->getHisCreador();
      $datos[$fila]['updated_at'] = $historia->getUpdatedAt(); //timestamp cambiar en la vista
      $datos[$fila]['his_prioridad'] = $historia->getHisPrioridad();
      $datos[$fila]['his_responsable'] = $historia->getHisResponsable();
      $datos[$fila]['pro_id'] = $historia->getProId();
      $datos[$fila]['his_dependencias'] = $historia->getHisDependencias();
      $datos[$fila]['his_riesgo'] = $historia->getHisRiesgo();
      $datos[$fila]['his_tiempo_estimado'] = $historia->getHisTiempoEstimado();
      $datos[$fila]['his_tiempo_real'] = $historia->getHisTiempoReal();
      $datos[$fila]['his_descripcion'] = $historia->getHisDescripcion();
      $datos[$fila]['his_version'] = $historia->getHisVersion();
      $datos[$fila]['his_unidad_tiempo'] = $historia->getHisUnidadTiempo();
      $datos[$fila]['his_tipo_actividad'] = $historia->getHisTipoActividad();
      $datos[$fila]['his_observaciones'] = $historia->getHisObservaciones();
      $datos[$fila]['his_probada'] = "NO";
      $fila++;
    }
  
    //seleccionar todas las historias de usuario que ya fueron probadas
    $c = new Criteria();
    $c->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $c->addJoin(AgilhuHistoriaUsuarioPeer::HIS_ID, AgilhuPruebaExpertoPeer::HIS_ID_ASOCIADA);
    $historias = AgilhuHistoriaUsuarioPeer::doSelect($c);
  
    foreach($historias As $historia)
    {
      $datos[$fila]['his_id'] = $historia->getHisId();
      $datos[$fila]['mod_id'] = $historia->getModId();
      $datos[$fila]['his_identificador_historia'] = $historia->getHisIdentificadorHistoria();
      $datos[$fila]['his_nombre'] = $historia->getHisNombre();
      $datos[$fila]['created_at'] = $historia->getCreatedAt(); //timestamp
      $datos[$fila]['his_creador'] = $historia->getHisCreador();
      $datos[$fila]['updated_at'] = $historia->getUpdatedAt(); //timestamp cambiar en la vista
      $datos[$fila]['his_prioridad'] = $historia->getHisPrioridad();
      $datos[$fila]['his_responsable'] = $historia->getHisResponsable();
      $datos[$fila]['pro_id'] = $historia->getProId();
      $datos[$fila]['his_dependencias'] = $historia->getHisDependencias();
      $datos[$fila]['his_riesgo'] = $historia->getHisRiesgo();
      $datos[$fila]['his_tiempo_estimado'] = $historia->getHisTiempoEstimado();
      $datos[$fila]['his_tiempo_real'] = $historia->getHisTiempoReal();
      $datos[$fila]['his_descripcion'] = $historia->getHisDescripcion();
      $datos[$fila]['his_version'] = $historia->getHisVersion();
      $datos[$fila]['his_unidad_tiempo'] = $historia->getHisUnidadTiempo();
      $datos[$fila]['his_tipo_actividad'] = $historia->getHisTipoActividad();
      $datos[$fila]['his_observaciones'] = $historia->getHisObservaciones();
      $datos[$fila]['his_probada'] = "SI";
      $fila++;
    
   }
    
    if(isset($datos))
    {
      $salida = "{success:true, hispro:".json_encode($datos)."}";
    }else{
      $salida = "{ success:true, hispro:{}}";
    }
    return $salida;
    
  }

*/

  private function listarHUxProyecto()
  {
    //selecciono todos las historias de usuario que no han sido probadas
    $pro_id  = $this->getUser()->getAttribute('proyectoSeleccionado');
    $filtro  = $this->getRequest()->getParameter('filtro');
    $tipo_version  = $this->getRequest()->getParameter('tipo_version');

    //el filtro es 
       //solo ultimas versiones
         //probadas
         //sin probadas
         //todas

      //todas las versiones
	 //probadas
         //sin probadas
         //todas
    $fila=0;
    $datos=array();
    //todas las versiones
    if($tipo_version=='todas'){

        if($filtro=='todas' ||  $filtro=='sinprobar'){
            //agregar a pureba_experto el id del proyecto para hacer mas rapido la funcion
            //consultamos todas las hu probadas
            $cpe = new Criteria();//cpe conexion pruebas experto
            $cpe->clearSelectColumns();
            $cpe->addSelectColumn(AgilhuPruebaExpertoPeer::HIS_ID_ASOCIADA);
            $huprobadas = AgilhuPruebaExpertoPeer::doSelectStmt($cpe);
            $arrayhuprobadas;
            while ($historia = $huprobadas->fetch(PDO::FETCH_NUM)) {
              $arrayhuprobadas[]=$historia[0];
            }
  
            $c = new Criteria();
            $c->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
            //-- $c->addJoin(AgilhuHistoriaUsuarioPeer::HIS_ID, AgilhuPruebaExpertoPeer::HIS_ID_ASOCIADA,Criteria::LEFT_JOIN);//trae todas las hu
            $c->add(AgilhuHistoriaUsuarioPeer::HIS_ID,$arrayhuprobadas, Criteria::NOT_IN);
            $historias = AgilhuHistoriaUsuarioPeer::doSelect($c);
            //  echo(count($datos));
            $datos=$this->hidratarHu($historias,$datos,count($datos),'NO');
        }
 
        if($filtro=='todas' ||  $filtro=='probadas')
        {
           //seleccionar todas las historias de usuario que ya fueron probadas
           $c = new Criteria();
           $c->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
           $c->addJoin(AgilhuHistoriaUsuarioPeer::HIS_ID, AgilhuPruebaExpertoPeer::HIS_ID_ASOCIADA);
           $historias = AgilhuHistoriaUsuarioPeer::doSelect($c);
           //echo(count($datos));
           $datos=$this->hidratarHu($historias,$datos,count($datos),'SI'); 
        }
    }
        //ultimas las versiones
    if($tipo_version=='ultimas'){
	       //sacamos las ultimas versiones de las hu del proyecto
	       $cuv = new Criteria();//conexion ultimas versiones
	       $cuv->clearSelectColumns();
	       $cuv->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
	       $cuv->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
	       $cuv->addSelectColumn('MAX('.AgilhuHistoriaUsuarioPeer::HIS_VERSION.') AS HIS_VERSION');
	       $cuv->addGroupByColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
		//end las ult ver
	       $historias_ultimas_versiones = AgilhuHistoriaUsuarioPeer::doSelectStmt($cuv);
		//sacamos las ult versiones y miramos y esta probada o no
	       while ($historia = $historias_ultimas_versiones->fetch(PDO::FETCH_NUM)) {

		    $ch = new Criteria();//conexion historias
		    $ch->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
		    $ch->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA,$historia[0]);
		    $ch->add(AgilhuHistoriaUsuarioPeer::HIS_VERSION,$historia[1]);
		    $historiaUltimaVersion = AgilhuHistoriaUsuarioPeer::doSelect($ch);
		    $probada=0;
		    foreach($historiaUltimaVersion as $hu)
	            {
                    $cpe = new Criteria();
		    $cpe->add(AgilhuPruebaExpertoPeer::HIS_ID_ASOCIADA,$hu->getHisId());
                    $probada=AgilhuPruebaExpertoPeer::doCount($cpe);
                    }

                           if(($filtro=='probadas' || $filtro=='todas') && $probada)
			  {
				$datos=$this->hidratarHu($historiaUltimaVersion,$datos,count($datos),'SI');
			  }
  			  if( ($filtro=='sinprobar' || $filtro=='todas') && $probada==0)
			  {
				$datos=$this->hidratarHu($historiaUltimaVersion,$datos,count($datos),'NO');
			  }
		}
    }
    if(isset($datos))
    {
      $salida = "{success:true, hispro:".json_encode($datos)."}";
    }else{
      $salida = "{ success:true, hispro:{}}";
    }
    return $salida;
    
  }


  //coji la funcion que tenias y la parti es varios pedasos
  public function hidratarHu($coleccionHU,$datos,$filaIndice,$probada='no'){

   foreach($coleccionHU As $historia)
    {
      $datos[$filaIndice]['his_id'] = $historia->getHisId();
      $datos[$filaIndice]['mod_id'] = $historia->getModId();
      $datos[$filaIndice]['his_identificador_historia'] = $historia->getHisIdentificadorHistoria();
      $datos[$filaIndice]['his_nombre'] = $historia->getHisNombre();
      $datos[$filaIndice]['created_at'] = $historia->getCreatedAt(); //timestamp
      $datos[$filaIndice]['his_creador'] = $historia->getHisCreador();
      $datos[$filaIndice]['updated_at'] = $historia->getUpdatedAt(); //timestamp cambiar en la vista
      $datos[$filaIndice]['his_prioridad'] = $historia->getHisPrioridad();
      $datos[$filaIndice]['his_responsable'] = $historia->getHisResponsable();
      $datos[$filaIndice]['pro_id'] = $historia->getProId();
      $datos[$filaIndice]['his_dependencias'] = $historia->getHisDependencias();
      $datos[$filaIndice]['his_riesgo'] = $historia->getHisRiesgo();
      $datos[$filaIndice]['his_tiempo_estimado'] = $historia->getHisTiempoEstimado();
      $datos[$filaIndice]['his_tiempo_real'] = $historia->getHisTiempoReal();
      $datos[$filaIndice]['his_descripcion'] = $historia->getHisDescripcion();
      $datos[$filaIndice]['his_version'] = $historia->getHisVersion();
      $datos[$filaIndice]['his_actor'] = $historia->getHisActor();//cambio v1.1
      $datos[$filaIndice]['his_unidad_tiempo'] = $historia->getHisUnidadTiempo();
      $datos[$filaIndice]['his_tipo_actividad'] = $historia->getHisTipoActividad();
      $datos[$filaIndice]['his_observaciones'] = $historia->getHisObservaciones();
      $datos[$filaIndice]['his_probada'] = $probada;
      $filaIndice++;
    }
    return $datos;
  }  
  

  

  

}
