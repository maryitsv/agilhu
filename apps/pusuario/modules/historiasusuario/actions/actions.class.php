<?php

/**
 * historiasusuario actions.
 *
 * @package    agilhu
 * @subpackage historiasusuario
 * @author     Luis Armando Nuñez
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class historiasusuarioActions extends sfActions
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
  * Executes crear action
  *
  * Esta action se encarga de mostrar el formulario para la creacion, 
  * edicion y versionado de las historias de usuario pertenecientes a un proyecto
  * 
  *@author Luis Armando Nuñez
  *@date 2010-03-3 
  */
  public function executeCrear()
  {
    
  }

  /*******************************//*************************************/
  /**
  *Este metodo maneja el proceso de creacion, actulizacion y versionado 
  *de una historia de usuario 
  * 
  *@author Luis Armando Nuñez
  *@date 2010-03-3 
  **/
  public function executeGuardar()
  {
    $task = $this->getRequest()->getParameter('task');
    switch($task)
    {
      case "Crear":
        $salida = $this->crearHistoriaUsuario();
        break;
        
      case "Actualizar":
        $salida = $this->actualizarHistoriaUsuario();
        break;
        
      case "Versionar":
        $salida = $this->versionarHistoriaUsuario();
        break;

      case "REGRESARALAVERSION":
        $salida = $this->regresarVersionAnterior();
        break;

      
      default:
        $salida =  "{failure:true}";
    }
    return $this->renderText($salida);
  }
  


  /**
  *Este metodo retorna el proximo identificador historia que puede ser utilizado en un proyecto
  *
  *@author maryit SV
  *@date 2010-04-27
  **/
  protected function getProximoIdentificadorHistoria($pro_id)
  {
    $proximo_identificador=0;    
    $conexion = new Criteria();
    $conexion->clearSelectColumns();
    $conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $conexion->addSelectColumn('MAX('.AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA.') AS HIS_IDENTIFICADOR_HISTORIA');
    $conexion->addGroupByColumn(AgilhuHistoriaUsuarioPeer::PRO_ID);

    $historias_identificador_maximo = AgilhuHistoriaUsuarioPeer::doSelectStmt($conexion);
    while ($valor = $historias_identificador_maximo->fetch(PDO::FETCH_NUM)) {
    $proximo_identificador=$valor[0];
 // echo($proximo_identificador);
    }

   return $proximo_identificador+1;
  }
  /**
  *Este metodo se encarga de crear el registro de una nueva historia de 
  *usuario al sistema, dado los paramatros de la peticion; proyecto
  *y modulo los cuales son identificadores numericos
  *
  *
  *@author Luis Armando Nuñez
  *@date 2010-03-3 
  **/
  protected function crearHistoriaUsuario()
  {
    //echo($this->getRequest()->getParameter('his_dependencias'));
    $autor_id = $this->getUser()->getAttribute('idUsuario');

    $pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');
  
    $nueva_hu = new AgilhuHistoriaUsuario();
    
    $nueva_hu->setProId($pro_id);//$this->getRequest()->getParameter('pro_id'));
    $nueva_hu->setModId($this->getRequest()->getParameter('mod_id'));
    $nueva_hu->setHisCreador($autor_id );
    $nueva_hu->setHisDependencias($this->getRequest()->getParameter('his_dependencias'));
    $nueva_hu->setHisNombre($this->getRequest()->getParameter('his_nombre'));
    $nueva_hu->setHisPrioridad($this->getRequest()->getParameter('his_prioridad'));
    $nueva_hu->setHisRiesgo($this->getRequest()->getParameter('his_riesgo'));
    $nueva_hu->setHisTiempoEstimado($this->getRequest()->getParameter('his_tiempo_estimado'));
    $nueva_hu->setHisTiempoReal($this->getRequest()->getParameter('his_tiempo_real'));
    $nueva_hu->setHisTipoActividad("Creacion"); //cambiar por creacion
    $nueva_hu->setHisDescripcion($this->getRequest()->getParameter('his_descripcion'));
    $nueva_hu->setHisIdentificadorHistoria($this->getProximoIdentificadorHistoria($pro_id));//$this->getRequest()->getParameter('his_identificador_historia'));
    $nueva_hu->setHisVersion('0');//$this->getRequest()->getParameter('his_version')
    $nueva_hu->setHisResponsable($this->getRequest()->getParameter('his_responsable'));
    $nueva_hu->setHisActor($this->getRequest()->getParameter('his_actor'));//cambio v 1.1
    $nueva_hu->setHisIteracion($this->getRequest()->getParameter('his_iteracion'));//cambio v 1.1

    $nueva_hu->setHisUnidadTiempo($this->getRequest()->getParameter('his_unidad_tiempo'));
    $nueva_hu->setHisObservaciones($this->getRequest()->getParameter('his_observaciones'));//cambio

    $nueva_hu->save();
   //hay 16 campos por no se guarda el his_id, created_at, updated_at , 
    $salida = "{success:true, msg: 'Se ha creado una nueva historia'}";
    return $salida;
  }
  
  
  /**
  * Este metodo se encarga de actualizar el registro de una historia
  * de usuario en la base de datos
  * 
  *@author Luis Armando Nuñez
  *@date 2010-03-5
  **/
  protected function actualizarHistoriaUsuario()
  {
    $his_id = $this->getRequest()->getParameter('his_id');
    
    //recupero el registro de la historia de usurio 
    $his_usuario = AgilhuHistoriaUsuarioPeer::retrieveByPK($his_id);
    
    //guardo los cambios echos a la historia de usuario
    if($his_usuario)
    {
      //solo se actualizan los campos editables de la historia
      $his_usuario->setHisNombre($this->getRequest()->getParameter('his_nombre'));
      //echo($this->getRequest()->getParameter('his_dependencias'));
      $his_usuario->setModId($this->getRequest()->getParameter('mod_id'));
   
      $his_usuario->setHisDependencias($this->getRequest()->getParameter('his_dependencias'));
      $his_usuario->setHisPrioridad($this->getRequest()->getParameter('his_prioridad'));
      
      $his_usuario->setHisRiesgo($this->getRequest()->getParameter('his_riesgo'));
      $his_usuario->setHisUnidadTiempo($this->getRequest()->getParameter('his_unidad_tiempo'));
      $his_usuario->setHisTiempoEstimado($this->getRequest()->getParameter('his_tiempo_estimado'));
      
      $his_usuario->setHisTiempoReal($this->getRequest()->getParameter('his_tiempo_real'));
      $his_usuario->setHisActor($this->getRequest()->getParameter('his_actor'));//cambio v 1.1
      $his_usuario->setHisIteracion($this->getRequest()->getParameter('his_iteracion'));//cambio v 1.1

      $his_usuario->setHisDescripcion($this->getRequest()->getParameter('his_descripcion'));//s
      
      $his_usuario->setHisIdentificadorHistoria($this->getRequest()->getParameter('his_identificador_historia'));//s
      $his_usuario->setHisVersion($this->getRequest()->getParameter('his_version'));
      $his_usuario->setHisResponsable($this->getRequest()->getParameter('his_responsable'));
      
      $his_usuario->setHisTipoActividad("Actualizacion");
      $his_usuario->setHisObservaciones($this->getRequest()->getParameter('his_observaciones'));//nuevo

      $his_usuario->save();//guarda cuando el objecto es modificado
      $salida = "{success:true, msg: 'Historia de usuario actualizada'}";
    }else{
      $salida = "{success:false, msg:'la historia de usuario no existe'}";
    }
    return $salida;
  }
  
  /**
  * Este metodo se encarga de crear un rejistro nuevo de historia de usuario
  * basado en un rejistro ya existente, crea una nueva version de una historia 
  * usuario si el cambio es pequeño se aumenta 0.1 si es grande se aumenta 1
  * 
  *@author Luis Armando Nuñez 
  *@author Maryit Sanchez Vivas
  *@date 2010-03-24
  **/
  protected function versionarHistoriaUsuario()
  {
    $his_id = $this->getRequest()->getParameter('his_id');
    $his_usuario = AgilhuHistoriaUsuarioPeer::retrieveByPK($his_id);
  //  $autor_id = $this->getUser()->getAttribute('usu_id');
  
    //manejo de version numerica
    $his_version_vieja=$this->getRequest()->getParameter('his_version');
    $his_tipo_cambio = $this->getRequest()->getParameter('tipo_cambio');
    $his_version_nueva;
    if($his_tipo_cambio =='grande'){
    $his_version_nueva=ceil($his_version_vieja);

	if($his_version_nueva==$his_version_vieja)//dado el caso de que la ver antigua no tenga decimales
	{    
	$his_version_nueva=$his_version_vieja+1;
	}
    }
    else{$his_version_nueva=$his_version_vieja+0.1;}

    $his_mensaje_version = $this->getRequest()->getParameter('mensaje');


    if($his_usuario)
    {
      $version_hu = new AgilhuHistoriaUsuario();
      $version_hu->setProId($this->getRequest()->getParameter('pro_id'));
      $version_hu->setModId($this->getRequest()->getParameter('mod_id'));
      $version_hu->setHisCreador( $his_usuario->getHisCreador());//el autor es el mismo
      $version_hu->setHisDependencias($this->getRequest()->getParameter('his_dependencias'));
      $version_hu->setHisNombre($this->getRequest()->getParameter('his_nombre'));
      $version_hu->setHisPrioridad($this->getRequest()->getParameter('his_prioridad'));
      $version_hu->setHisRiesgo($this->getRequest()->getParameter('his_riesgo'));
      $version_hu->setHisTiempoEstimado($this->getRequest()->getParameter('his_tiempo_estimado'));
      $version_hu->setHisTiempoReal($this->getRequest()->getParameter('his_tiempo_real'));
      $version_hu->setHisActor($this->getRequest()->getParameter('his_actor'));//cambio v 1.1
      $version_hu->setHisIteracion($this->getRequest()->getParameter('his_iteracion'));//cambio v 1.1

      $version_hu->setHisTipoActividad("Version");
      $version_hu->setHisDescripcion($this->getRequest()->getParameter('his_descripcion'));
      $version_hu->setHisIdentificadorHistoria($this->getRequest()->getParameter('his_identificador_historia'));
      $version_hu->setHisVersion($his_version_nueva);
      $version_hu->setHisResponsable($this->getRequest()->getParameter('his_responsable'));
      $version_hu->setHisUnidadTiempo($this->getRequest()->getParameter('his_unidad_tiempo'));
      $version_hu->setHisMensajeVersion($his_mensaje_version );
      $version_hu->setHisObservaciones($this->getRequest()->getParameter('his_observaciones'));//nuevo

      $version_hu->save();
      $salida = "{success:true, msg:'Se creo una nueva version de la historia de usuario'}";
      
    }else{
      $salida = "{success:false, msg:'No existe una version anterior'}";
    }
    return $salida;
  }
  
  
  
  /*
  * Ejecuta los diferenctes listados para el proceso de creacion , actualizacion y 
  * eliminacion de una historia de usuario. Para efectuar los procesos anteriores 
  * primero el usuario debe estar trabajando dentro de un proyecto.
  */
  public function executeListar()
  {
    $task = $this->getRequest()->getParameter('task');
    switch($task)
    {
      case "huxmod":
        $salida = $this->listarHuXMod();
        break;
        
      case "hispro":
        $salida = $this->listarHuXPro();
        break;

      case "HitorialVersiones":
        $salida = $this->listarHuVersiones();
        break;

      case "COMPARARVERSIONES":
        $salida = $this->compararVersiones();//agregar el nombre de la his y los numeros de las versiones que esta comparando
        break;

      case "IDENTIFICADORHU":
        $salida = $this->listarIdentificadoresHU();
        break;

      case "RESPONSABLESPROGRAMADORES":
        $salida = $this->listarParticipantesxRol('programador');
        break;

      case "LISTARMOD":
        $salida = $this->listarModulos();
        break;

      case "FILTROHIS":
        $salida = $this->listarFiltro();
        break;

      case "LISTAREVAL":
        $salida = $this->listarEvaluaciones();
        break;

      case "LISTARPROMEVAL":
        $salida = $this->listarPromEvaluaciones();
        break;

      default:
        $salida =  "{failure:true}";
    }
    
    return $this->renderText($salida);
  }
  
    /**
  *lista las diferentes opciones por las que se pueden fltrar las hu, es decir por modulo , participantes e hu, 
  *valiendose de los metodos ya existentes
  *@author Maryit sanchez
  *@date 2010-04-14 
  **/
  protected function listarFiltro(){
    $tipo = $this->getRequest()->getParameter('tipo');
     //Es necesario que los datos vengan codificados con el mismo nombre , e id por lo que vamos a agregar un parametro
     //en la peticion, filtro:'si' y se retornara en las funciones como se necesita
     //  fitro_valor, filtro_display
    switch($tipo)
    {
      case "Modulo":
        $salida = $this->listarModulos();
        break;
      case "Participante":
        $salida = $this->listarParticipantesxRol('');
        break;
      case "Dependencia":
        $salida = $this->listarIdentificadoresHU();
        break;

      default:
	 $salida ='({"total":"0", "results":""})';
     }

     return $salida;

  }
  
  /*******************************//*************************************/
  /**
  *Este metodo retorna la lista de los identificadores de las historias que pertenecen 
  *al  modulo de un proyecto dado por los parametros de la peticion (proyecto, modulo)
  *los que continen el identificador del proyecto y del modulo respectivamente
  *
  *@author Luis Armando Nuñez
  *@date 2010-03-3 
  **/
  protected function listarHuXMod()
  {
    $pro_id = $this->getRequest()->getParameter('proyecto');
    $mod_id = $this->getRequest()->getParameter('modulo');
    
    $c = new Criteria();
    $c->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $c->add(AgilhuHistoriaUsuarioPeer::MOD_ID, $mod_id);
    
    $historias = AgilhuHistoriaUsuarioPeer::doSelect($c);
    
    $fila=0;
    $datos;
    foreach($historias As $historia)
    {
      $datos[$fila]['his_id'] = $historia->getHisId();
      $datos[$fila]['his_identificador'] = $historia->getHisIdentificadorHistoria();
      $fila++;
    }
    
    $salida = "{success:true, huxmod:".json_encode($datos)."}";
    return $salida;
  }
  
  
  /*******************************//*************************************/
  /**
  *Este metodo retorna la lista  de las historias que pertenecen 
  *al proyecto dado por el parametro de la peticion (proyecto)
  *el que continen el identificador del proyecto
  *
  *@author Luis Armando Nuñez
  *@date 2010-03-3 
  **/
  protected function listarHuXPro1()
  {
    $pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');// $this->getRequest()->getParameter('proyecto');
    $c = new Criteria();
    $c->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);

    $historias = AgilhuHistoriaUsuarioPeer::doSelect($c);

    
    $fila=0;
    $datos; //o la configuracion del error hacer el manejo de error para el caso que el proyecto no tenga historias definidas
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
      $datos[$fila]['his_actor'] = $historia->getHisActor(); //cambio v1.1
      $datos[$fila]['his_iteracion'] = $historia->getHisIteracion(); //cambio v1.1


      $fila++;
    }
    
    $salida = "{success:true, hispro:".json_encode($datos)."}";
    return $salida;
  }

/*******************************************************************AYUDA*****/
/**
  *Este metodo retorna el login de un usuario
  *@author maryit sanchez
  *@date 2010-03-25 
  **/
 protected function getUsuUsuario($usu_id)//cambio
  {
   try{
    $conexion = new Criteria();
    $conexion->add(AgilhuUsuarioPeer::USU_ID, $usu_id);
    $agilhu_usuario= AgilhuUsuarioPeer::doSelectOne($conexion);

	    if($agilhu_usuario)
	    {
	     return $agilhu_usuario->getUsuUsuario();
	    }
	    else{
	     return  'desconocido';
	    }
   }
   catch(Exception $e){
    return  'desconocido';
   }
  }

/**
  *Este metodo retorna nombre de un modulo
  *@author maryit sanchez
  *@date 2010-03-25 
  **/
 protected function getModNombre($mod_id)
  {
    try{
	    $conexion = new Criteria();
	    $conexion->add(AgilhuModuloPeer::MOD_ID, $mod_id);
	    
	    $agilhu_modulo= AgilhuModuloPeer::doSelectOne($conexion);

	    if($agilhu_modulo)
	    {
	     return $agilhu_modulo->getModNombre();
	    }
	    else{
	     return  'desconocido';
	    }
    }catch(Exception $e){
    return  'desconocido';
    }

  }

/**
  *Este metodo retorna la ruta de nombres de un modulo, esta es construida recorriendo los padre del modulo
  *@author maryit sanchez
  *@date 2010-06-30 
  **/
 protected function getModNombreRuta($mod_id)
  {
  $ruta='';
    try{
             $modulo=AgilhuModuloPeer::retrieveByPK($mod_id);

	    if($modulo)
	    {
               if($modulo->getModPadre()==null || $modulo->getModPadre()=='')
               {
               $ruta=$modulo->getModNombre();
	       return $ruta;
               }

               else{
               $ruta=$this->getModNombreRuta($modulo->getModPadre());
               $ruta.='->'.$modulo->getModNombre();
               return $ruta;
               }
	    }
	    else{
	     return  '';
	    }
    }catch(Exception $e){
    return  '';
    }
  }
  /*
Basado en la sgte consulta 
select  agilhu_historia_usuario.* from agilhu_historia_usuario, (select his_identificador_historia,max(his_version) as his_version  from agilhu_historia_usuario group by (his_identificador_historia)) as ult_ver where ult_ver.his_identificador_historia=agilhu_historia_usuario.his_identificador_historia  and ult_ver.his_version=agilhu_historia_usuario.his_version;

REALIZAR LO DE VOLVER A VERSIONACTUALIZANDO LA FECHA DE ACTUALIZACION
explicacion, primero sacamos las hu con id y ultimafechaactualizacion,
luego buscamos las historias completas donde el id y la update_at sean iguales a la consulta de arriba
REVISAR PORFAVOR NO ESTOY SEGURA
*/
/**
  *Este metodo retorna la lista de hu teniendo en cuenta la ultima actualizada de las hu
  *@author maryit sanchez
  *@date 2010-03-26  
  **/
 protected function listarHuXPro()
  {
    $pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');
    $cv = new Criteria();
    $cv->clearSelectColumns();
    $cv->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $cv->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
    $cv->addSelectColumn('MAX('.AgilhuHistoriaUsuarioPeer::HIS_VERSION.') AS HIS_VERSION');
    $cv->addGroupByColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);

    $historias_ultimamente_actualizadas = AgilhuHistoriaUsuarioPeer::doSelectStmt($cv);
    $datos;
    $fila_version=0;
    $fila=0;
    while ($historia = $historias_ultimamente_actualizadas->fetch(PDO::FETCH_NUM)) {

    $ch = new Criteria();
    $ch->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $ch->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA,$historia[0]);
    $ch->add(AgilhuHistoriaUsuarioPeer::HIS_VERSION,$historia[1]);
    $historias = AgilhuHistoriaUsuarioPeer::doSelect($ch);

	foreach($historias As $historia)
	    {
	      $datos[$fila]['his_id'] = $historia->getHisId();
	      $datos[$fila]['mod_id'] = $historia->getModId();//$this->getModNombre($historia->getModId());
	    //  $datos[$fila]['mod_nombre'] = $this->getModNombre($historia->getModId());

              $datos[$fila]['mod_nombre'] = $this->getModNombreRuta($historia->getModId());

	      $datos[$fila]['his_identificador_historia'] = $historia->getHisIdentificadorHistoria();
	      $datos[$fila]['his_nombre'] = $historia->getHisNombre();
	      $datos[$fila]['created_at'] = $historia->getCreatedAt(); //timestamp
	      $datos[$fila]['his_creador'] = $this->getUsuUsuario($historia->getHisCreador());
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
	      $datos[$fila]['his_actor'] = $historia->getHisActor(); //cambio v1.1
	      $datos[$fila]['his_iteracion'] = $historia->getHisIteracion(); //cambio v1.1

	      $fila++;
	    }
   } 
	$salida = '({"total":"'.$fila++.'","hispro":'.json_encode($datos).'})';
  //  $salida = "{success:true, hispro:".json_encode($datos)."}";
    return $salida;

  }


 protected function listarModulos()
  {

    	$pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');

	$conexion = new Criteria();
 	$conexion->add(AgilhuModuloPeer::PRO_ID, $pro_id);
   
	$cantidad_modulos = AgilhuModuloPeer::doCount($conexion);
	$modulos = AgilhuModuloPeer::doSelect($conexion);

	$pos = 0;
	$nbrows=0;
	$datos;
	if($modulos)	
	{	
		foreach ($modulos As $modulo)
		{
		    
		    if($this->getRequest()->getParameter('filtro')=='si')
		    {
		      $datos[$pos]['filtro_display']=$modulo->getModId();
		      $datos[$pos]['filtro_display']=$modulo->getModNombre();			    
		    }
		    else{
		      $datos[$pos]['modId']=$modulo->getModId();
		      $datos[$pos]['modNombre']=$modulo->getModNombre();			    
		    }
		    $pos++;
		    $nbrows++;
		}
		if($nbrows>0){
		  $jsonresult = json_encode($datos);
		  return '({"total":"'.$cantidad_modulos.'","results":'.$jsonresult.'})';
		}
	}
	else {
		return '({"total":"0", "results":""})';
	}
 
 }


  /**
  *Este metodo retorna la lista  todas las versiones de la historia de usuario seleccionada
  *ordenadas por fecha de creacion y fecha de actualizacion
  * ano mes dia
  *@author maryit sanchez
  *@date 2010-03-10  
  **/
  protected function listarHuVersiones()
  {
    $pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');
    $his_identificador = $this->getRequest()->getParameter('his_identificador');

    $conexion = new Criteria();
    $conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $conexion->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA, $his_identificador);
    $conexion->addDescendingOrderByColumn(AgilhuHistoriaUsuarioPeer::UPDATED_AT);
    $historias = AgilhuHistoriaUsuarioPeer::doSelect($conexion);
    //echo('descpues de la consulta');
    $fila=0;
    $datos; //o la configuracion del error hacer el manejo de error para el caso que el proyecto no tenga historias definidas
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
      $datos[$fila]['his_mensaje_version'] = $historia->getHisMensajeVersion();
      $datos[$fila]['his_actor'] = $historia->getHisActor(); //cambio v1.1
      $datos[$fila]['his_iteracion'] = $historia->getHisIteracion(); //cambio v1.1



      $fila++;
    }
    $salida = "{success:true, hispro:".json_encode($datos)."}";
	
    return $salida;
  }

/*dados dos textos los compara y retorna la diferencia entre estos dos*/
protected function compararVersiones()
{
 $versionNueva = $this->getRequest()->getParameter('versionNueva');
 $versionVieja = $this->getRequest()->getParameter('versionVieja');
 
 $patron = "/\n/"; // "/<(.+?)>/";
 $versionVieja= preg_replace($patron,"",$versionVieja);
 $versionNueva= preg_replace($patron,"",$versionNueva);
//echo($versionVieja);

 $a=explode(' ',$versionNueva);
 $b=explode(' ',$versionVieja);
 $numeroVersionNueva=$this->getRequest()->getParameter('versionNumeroNueva');
 $numeroVersionVieja=$this->getRequest()->getParameter('versionNumeroVieja');
  
$diff=$this->diff($a,$b);

foreach($diff as $k){
                if(is_array($k))
                        $ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').
                                (!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
                else $ret .= $k . ' ';
        }
 
return "{success:true, mensaje:'<html><body>"."Comparación de descripción de las versiones ".$numeroVersionNueva." y ". $numeroVersionVieja."<br>".$ret."</body></html>'}";
}

/*dado un arreglo de palabras las compara */
protected function diff($old, $new){
        foreach($old as $oindex => $ovalue){
                $nkeys = array_keys($new, $ovalue);
                foreach($nkeys as $nindex){
                        $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                                $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
                        if($matrix[$oindex][$nindex] > $maxlen){
                                $maxlen = $matrix[$oindex][$nindex];
                                $omax = $oindex + 1 - $maxlen;
                                $nmax = $nindex + 1 - $maxlen;
			
                        }
                }       
        }
        if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
        return array_merge(
                $this->diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
                array_slice($new, $nmax, $maxlen),
                $this->diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
}

/**
  *Obtener la mayor version de una hu partiendo de que en un proyectoel identificaddor de una historia es unico para cada historia
  *@author Maryit SV 
  *@date 2010-04-05
  **/
protected function getMaximaVersionHU($pro_id,$his_identificador)
	{
		$conexion = new Criteria();
		$conexion ->clearSelectColumns();
		$conexion->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA, $his_identificador);
		$conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
                $conexion->addSelectColumn('MAX('.AgilhuHistoriaUsuarioPeer::HIS_VERSION.') AS HIS_VERSION');
  		//$conexion->addGroupByColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);

		$historias = AgilhuRolProyectoPeer::doSelectStmt($conexion);
		$maximaVersion=0.0;

		    while ($historia = $historias->fetch(PDO::FETCH_NUM)) {

		      $maximaVersion = $historia[0];
		     
		   } 
		   
	      return $maximaVersion;
	}

 /**
  *Permite regresar a una version anterior de las historias de usuario cambiando la fecha de estos , y creando un nuevo registro en la bd
  *@author Maryit SV //modificado por mm
  *@date 2010-03-25
  **/
  protected function regresarVersionAnterior()
  {
//echo(1);
   $salida='';
   $pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');
  
   $his_identificador = $this->getRequest()->getParameter('his_identificador');
   $his_id = $this->getRequest()->getParameter('his_id');
   $his_version = $this->getRequest()->getParameter('his_version_regresa');


    $conexion = new Criteria();
    $conexion->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA, $his_identificador );
    $conexion->add(AgilhuHistoriaUsuarioPeer::HIS_VERSION, $his_version);
    $conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);//cambio 2

    $conexion->add(AgilhuHistoriaUsuarioPeer::HIS_ID, $his_id);
    $cantidad=AgilhuHistoriaUsuarioPeer::doCount($conexion);
//echo($cantidad);
    $historiaARecuperar = AgilhuHistoriaUsuarioPeer::doSelectOne($conexion);

    if($cantidad==1)
    {

      $nuevaVersion=$this->getMaximaVersionHU($historiaARecuperar->getProId(),$historiaARecuperar->getHisIdentificadorHistoria())+0.1;
      $version_hu = new AgilhuHistoriaUsuario();


      $version_hu->setProId($historiaARecuperar->getProId());
      $version_hu->setModId($historiaARecuperar->getModId());
      $version_hu->setHisCreador($historiaARecuperar->getHisCreador());
      $version_hu->setHisDependencias($historiaARecuperar->getHisDependencias());
      $version_hu->setHisNombre($historiaARecuperar->getHisNombre());
      $version_hu->setHisPrioridad($historiaARecuperar->getHisPrioridad());
      $version_hu->setHisRiesgo($historiaARecuperar->getHisRiesgo());
      $version_hu->setHisTiempoEstimado($historiaARecuperar->getHisTiempoEstimado());
      $version_hu->setHisTiempoReal($historiaARecuperar->getHisTiempoReal());
      $version_hu->setHisTipoActividad('Regresar a version');
      $version_hu->setHisDescripcion($historiaARecuperar->getHisDescripcion());
      $version_hu->setHisIdentificadorHistoria($historiaARecuperar->getHisIdentificadorHistoria());
      $version_hu->setHisVersion($nuevaVersion);//la mayor version + 0.1 es un acmbio pequeno por que se regresa a algo que ya existe
      $version_hu->setHisResponsable($historiaARecuperar->getHisResponsable());
      $version_hu->setHisUnidadTiempo($historiaARecuperar->getHisUnidadTiempo());
      $version_hu->setHisMensajeVersion($historiaARecuperar->getHisMensajeVersion());
      $version_hu->setHisObservaciones($historiaARecuperar->getHisObservaciones());
      $version_hu->setHisActor($historiaARecuperar->getHisActor()); //cambio v 1.1
      $version_hu->setHisIteracion($historiaARecuperar->getHisIteracion()); //cambio v 1.1


 
      $version_hu->save();
      $salida = "({success:true, mensaje:'Se creo una nueva version de la historia de usuario con un contenido viejo'})";
     
    }
    else{
      $salida = "({success:false, errors:{reason:'No existe una version anterior'}})";
    }
    return $salida;

  }


/**
  *Lista los identificadores de las historias de usuario de un proyecto seleccionado
  *@author Maryit SV 
  *@date 2010-03-26
  **/
  protected function listarIdentificadoresHU()
  {
 
    $pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');
    $conexion = new Criteria();
    $conexion->clearSelectColumns();
    $conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $conexion->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
    $conexion->addSelectColumn('MAX('.AgilhuHistoriaUsuarioPeer::HIS_VERSION.') AS HIS_VERSION');
    $conexion->addGroupByColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);

    $historias_ultimas_versiones = AgilhuHistoriaUsuarioPeer::doSelectStmt($conexion);
    $datos;
    
    $fila=0;
    while ($historia = $historias_ultimas_versiones->fetch(PDO::FETCH_NUM)) {
      $conexionhis = new Criteria();
      $conexionhis->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
      $conexionhis->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA,$historia[0]);
      $conexionhis->add(AgilhuHistoriaUsuarioPeer::HIS_VERSION,$historia[1]);
      $historias = AgilhuHistoriaUsuarioPeer::doSelect($conexionhis);

	foreach($historias As $historia)
	    {    
                 if($this->getRequest()->getParameter('filtro')=='si')
                 {
                 $datos[$fila]['filtro_valor'] = $historia->getHisIdentificadorHistoria();
	         $datos[$fila]['filtro_display'] = $historia->getHisNombre();
	      
                 }
                 else{
                  $datos[$fila]['his_identificador_historia'] = $historia->getHisIdentificadorHistoria();
                 // $datos[$fila]['his_nombre'] = $historia->getHisNombre();

                 }
	      $fila++;
	    }
     } 
   if($fila>0){
	$jsonresult = json_encode($datos);
	return '({"total":"'.$fila.'","results":'.$jsonresult.'})';
   }
   else {
	return '({"total":"0", "results":""})';
   }
    return $salida;
  }

/**
  *Obtener el id de un rol de proyecto apartir del nombre del rol
  *@author Maryit SV 
  *@date 2010-03-30
  **/
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

  /**
  *Lista los participantes con rol programador
  *@author Maryit SV 
  *@date 2010-03-30
  **/
  protected function listarParticipantesxRol($rop_nombre)
  {
 
    $pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');
    $rop_id=$this->getIdRolProyecto($rop_nombre);

        $conexion = new Criteria();
        $conexion->setDistinct();
        $conexion->add(AgilhuParticipantePeer::PRO_ID,$pro_id);
        $conexion->addJoin(AgilhuParticipantePeer::USU_ID,AgilhuUsuarioPeer::USU_ID);
        
        if($rop_id!==0)
        {
           $conexion->add(AgilhuParticipantePeer::ROP_ID,$rop_id);
        }
        $conexion->add(AgilhuParticipantePeer::ESTADO,'Aceptado');
        $numero_participantes = AgilhuParticipantePeer::doCount($conexion);
        $participantes = AgilhuUsuarioPeer::doSelect($conexion);
        
        $pos = 0;
        $datos;
        
        foreach ($participantes As $participante)
        {
           if($this->getRequest()->getParameter('filtro')=='si')
           {
           $datos[$pos]['filtro_valor']=$participante->getUsuUsuario();
           $datos[$pos]['filtro_display']=$participante->getUsuUsuario();
           }
           else{
           $datos[$pos]['usu_usuario']=$participante->getUsuUsuario();
           }
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

  
  /**
  *Este metodo se encarga de generar el formato XMI para una historia de usuario y ya que una historia de usuario
  *pertenece a un modulo que a su vez esta dentro de un proyecto las informacion de esto tambien estara en el formato
  *XMI junto con su jerarquia (proyecto -> modulo -> historia de usuario)
  * 
  *
  *@author Luis Armando Nuñez
  *@param his_id Identificar unico de la historia de usuario
  *@date 2010-17-4 
  **/
  public function executeExportarXMI()
  {
    $xml  = '<?xml version="1.0"?>';
    //definicion del xmi y namespace AGILHU este permite que se pueda anteponer AGILHU a todos los tag del modelo
    $xml  .= '<XMI xmi.version="1.2" xmlns:AGILHU="agilhu.com/AGILHU/1.0">';
    //cabecera del documento xmi
    $xml  .= '<XMI.header>'; 
    $xml  .= '<XMI.documentation>';
    $xml  .= '<XMI.generated>AGILHU</XMI.generated>';
    $xml  .= '<XMI.metamodel xmi.name="AGILHU" xmi.version="1.0"/> ';
    $xml  .= '</XMI.documentation>';
    $xml  .= '</XMI.header>';  
    //fin de la cabecera
    
    //contenido del documento xmi
    $xml  .= '<XMI.content>';  
    
    //obtener el parametro de la peticion del usuario
    $his_id = $this->getRequest()->getParameter('his_id');
    if(isset($his_id))
    {
      $xml .= $this->exportarHistoria($his_id);
    }

    //cierre de las etiquetas contenido y xmi
    $xml  .= '</XMI.content>';
    $xml  .= '</XMI>'; 
	
    //configuracion de envio para el archivo 
    $this->getRequest()->setRequestFormat('xml');
    $response = $this->getResponse();
    $response->setContentType('text/xml');
    $response->setHttpHeader('Content-length', strlen($xml), true);
    
    //todo el codigo xml(i)
    return $this->rendertext($xml);
  }
  

  /**
  *Este metodo se encarga de generar el formato XMI para una historia de usuario y ya que una historia de usuario
  *pertenece a un modulo que a su vez esta dentro de un proyecto las informacion de esto tambien estara en el formato
  *XMI junto con su jerarquia (proyecto -> modulo -> historia de usuario)
  * 
  *
  *@author Luis Armando Nuñez
  *@param his_id Identificar unico de la historia de usuario
  *@date 2010-07-04  
  **/
  protected function exportarHistoria($his_id)
  {
    //codigo para exportar una historia de usuario a xmi
    $hu = AgilhuHistoriaUsuarioPeer::retrieveByPK($his_id);
    $xmi = "";
    if(isset($hu))
    {
      $pro_id = $hu->getProId();
      $mod_id = $hu->getModId();
      $xmi    = $this->exportarProyectoXMI($pro_id, $mod_id, $his_id);
    }
    return $xmi;
  }
  
  
  /**
  * Este metodo se encarga de generar el xmi de un proyecto identificado por el 
  * parametro pro_id
  * 
  *
  *@author Luis Armando Nuñez
  *@param pro_id Identificador unico de un proyecto
  *@param mod_id Identificador unico de un modulo
  *@param his_id Identificar unico de la historia de usuario
  *@return string xmi del proyecto
  *@date 2010-17-04 
  **/
  protected function exportarProyectoXMI($pro_id, $mod_id, $his_id)
  {
    //agrego la definicion del proyecto al modelo
    $salida  = '<AGILHU:Model xmi.id="M.1" name="ProyectoXP">';
    $salida .= '<AGILHU:Proyecto xmi.id="PHU.'.$pro_id.'">';
    
    $proyecto = AgilhuProyectoPeer::retrieveByPK($pro_id);
    if(isset($proyecto))
    {
      $usuario = AgilhuUsuarioPeer::retrieveByPK($proyecto->getUsuId());
      $nombreUsuario = "";
      
      if(isset($usuario))
      {
        $nombreUsuario = $usuario->getUsuNombres()." ".$usuario->getUsuApellidos();
      }
      $patron = "/<(.+?)>/";
      $descripcion = preg_replace($patron,"",$proyecto->getProDescripcion());
      $descripcion = preg_replace("/&nbsp/","",$descripcion);
      $descripcion = preg_replace("/&/","amp",$descripcion);
      $descripcion = preg_replace("/'/","apos",$descripcion);
      $descripcion = preg_replace('/"/',"quot",$descripcion);
      //remplazo todas las entidades html por las entidades xml correspondientes
      
      $salida .= '<AGILHU:Proyecto.Attribute>'; // atributos del proyecto
      $salida .= '<AGILHU:Attribute name="pro_id" value="'.$pro_id.'"/>';
      $salida .= '<AGILHU:Attribute name="pro_nombre_corto" value="'.$proyecto->getProNombreCorto().'"/>';
      $salida .= '<AGILHU:Attribute name="pro_nombre" value="'.$proyecto->getProNombre().'"/>';
      $salida .= '<AGILHU:Attribute name="pro_area_aplicacion" value="'.$proyecto->getProAreaAplicacion().'"/>';
      $salida .= '<AGILHU:Attribute name="pro_descripcion" value="'.$descripcion.'"/>';
      $salida .= '<AGILHU:Attribute name="usu_creador_id" value="'.$proyecto->getUsuId().'"/>';
      $salida .= '<AGILHU:Attribute name="usu_creador_usuario" value="'.$nombreUsuario.'"/>';
      $salida .= '<AGILHU:Attribute name="pro_fecha_inicio" value="'.$proyecto->getProFechaInicio().'"/>';
      $salida .= '<AGILHU:Attribute name="pro_fecha_finalizacion" value="'.$proyecto->getProFechaFinalizacion().'"/>';
      $salida .= '<AGILHU:Attribute name="pro_estado" value="'.$proyecto->getProEstado().'"/>';
      $salida .= '<AGILHU:Attribute name="pro_fecha_creado" value="'.$proyecto->getCreatedAt().'"/>';
      $salida .= '<AGILHU:Attribute name="pro_ultima_modificacion" value="'.$proyecto->getUpdatedAt().'"/>';
      $salida .= '</AGILHU:Proyecto.Attribute>'; //cierre de los atributos
	  
      $salida .= '<AGILHU:Proyecto.Modules>';
      $salida .= $this->exportarModulosXMI($pro_id,$mod_id,$his_id);
      $salida .= '</AGILHU:Proyecto.Modules>';
    }
  
    $salida .= '</AGILHU:Proyecto>'; //etiqueta de cierre del proyecto
    $salida .= '</AGILHU:Model>'; //cierre del modelo

    return $salida;
  }
  
  
  /**
  * Este metodo se encarga de generar el xmi de un modulo identificado por el 
  * parametro mod_id
  * 
  *
  *@author Luis Armando Nuñez
  *@param pro_id Identificador unico de un proyecto
  *@param mod_id Identificador unico de un modulo
  *@param his_id Identificar unico de la historia de usuario
  *@return string xmi del modulo 
  *@date 2010-07-04 
  **/
  protected function exportarModulosXMI($pro_id , $mod_id, $his_id)
  {
    $salida   = '<AGILHU:Module xmi="MHU.'.$mod_id.'">'; //se abre la etiqueta de un modulo
    $modulo = AgilhuModuloPeer::retrieveByPK($mod_id);
    if(isset($modulo))
    {
      $salida .= '<AGILHU:Module.Attribute>';
      $salida .= '<AGILHU:Attribute name="mod_id" value="'.$mod_id.'"/>';
      $salida .= '<AGILHU:Attribute name="mod_nombre" value="'.$modulo->getModNombre().'"/>';
      $salida .= '<AGILHU:Attribute name="mod_estado" value="'.$modulo->getModEstado().'"/>';
      
      $patron = "/<(.+?)>/";//patron para eliminar  <*> 
      $descripcion = preg_replace($patron,"",$modulo->getModDescripcion());
      $descripcion = preg_replace("/&nbsp/","",$descripcion);
      $descripcion = preg_replace("/&/","amp",$descripcion);
      $descripcion = preg_replace("/'/","apos",$descripcion);
      $descripcion = preg_replace('/"/',"quot",$descripcion);
      
      $salida .= '<AGILHU:Attribute name="mod_descripcion" value="'.$descripcion.'"/>';
      $salida .= '<AGILHU:Attribute name="mod_fecha_creado" value="'.$modulo->getCreatedAt().'"/>';
      $salida .= '<AGILHU:Attribute name="mod_ultima_modificacion" value="'.$modulo->getUpdatedAt().'"/>';
      $salida .= '</AGILHU:Module.Attribute>';
	  
      $salida .= '<AGILHU:Module.UsersHistory>';
      $salida .= $this->exportarHistoriaXMI($his_id); //establecer las etiquetas xmi para las historias de usuario
      $salida .= '</AGILHU:Module.UsersHistory>';
      
    }
    $salida  .= '</AGILHU:Module>';//cierre del modulo
	
    return $salida;
  }
  
  
  /**
  * Este metodo se encarga de generar el xmi de una historia de usuario identificada por el 
  * parametro his_id
  * 
  *
  *@author Luis Armando Nuñez
  *@param his_id Identificar unico de la historia de usuario
  *@return string xmi de la historia de usuario
  *@date 2010-07-04 
  **/
  protected function exportarHistoriaXMI($his_id)
  {
    $salida = '<AGILHU:UserHistory xmi.id="HU.'.$his_id.'">';
    $hu = AgilhuHistoriaUsuarioPeer::retrieveByPK($his_id);
    if(isset($hu))
    {
	
      $salida .= '<AGILHU:UserHistory.Attribute>';
      $salida .= '<AGILHU:Attribute name="his_id" value="'.$his_id.'" />';
      $salida .= '<AGILHU:Attribute name="his_nombre" value="'.$hu->getHisNombre().'" />';
      $salida .= '<AGILHU:Attribute name="his_dependencias" value="'.$hu->getHisDependencias().'" />';
      $salida .= '<AGILHU:Attribute name="his_prioridad" value="'.$hu->getHisPrioridad().'" />';
      $salida .= '<AGILHU:Attribute name="his_riesgo" value="'.$hu->getHisRiesgo().'" />';
      $salida .= '<AGILHU:Attribute name="his_tiempo_estimado" value="'.$hu->getHisTiempoEstimado().'" />';
      $salida .= '<AGILHU:Attribute name="his_tiempo_real" value="'.$hu->getHisTiempoReal().'" />';
      $salida .= '<AGILHU:Attribute name="his_tipo_actividad" value="'.$hu->getHisTipoActividad().'" />';
      $salida .= '<AGILHU:Attribute name="his_actor" value="'.$hu->getHisActor().'" />';//cambio v1.1
      $salida .= '<AGILHU:Attribute name="his_iteracion" value="'.$hu->getHisIteracion().'" />';//cambio v1.1


      $patron = "/<(.+?)>/";
      $descripcion   = preg_replace($patron,"",$hu->getHisDescripcion());
      $observaciones = preg_replace($patron,"",$hu->getHisObservaciones());
      //remplaza todas las ocurrencias de &nbsp en la cadena por basio
      $descripcion   = preg_replace("/&nbsp/","",$descripcion); 
      $descripcion = preg_replace("/&/","amp",$descripcion);
      $descripcion = preg_replace("/'/","apos",$descripcion);
      $descripcion = preg_replace('/"/',"quot",$descripcion);
      $observaciones = preg_replace("/&nbsp/","",$observaciones);
      $observaciones = preg_replace("/&/","amp",$observaciones);
      $observaciones = preg_replace("/'/","apos",$observaciones);
      $observaciones = preg_replace('/"/',"quot",$observaciones);
      
      
      $salida .= '<AGILHU:Attribute name="his_descripcion" value="'.$descripcion.'" />';
      $salida .= '<AGILHU:Attribute name="his_observaciones" value="'.$observaciones.'" />';
      $salida .= '<AGILHU:Attribute name="his_fecha_creado" value="'.$hu->getCreatedAt().'" />';
      $salida .= '<AGILHU:Attribute name="his_ultima_modificacion" value="'.$hu->getUpdatedAt().'" />';
      $salida .= '<AGILHU:Attribute name="his_creador" value="'.$hu->getHisCreador().'" />';
      $salida .= '<AGILHU:Attribute name="his_identificador_historia" value="'.$hu->getHisIdentificadorHistoria().'" />';
      $salida .= '<AGILHU:Attribute name="his_version" value="'.$hu->getHisVersion().'" />';
      $salida .= '<AGILHU:Attribute name="his_responsable" value="'.$hu->getHisResponsable().'" />';
      $salida .= '<AGILHU:Attribute name="his_unidad_tiempo" value="'.$hu->getHisUnidadTiempo().'" />';
      $salida .= '<AGILHU:Attribute name="his_mensaje_version" value="'.$hu->getHisMensajeVersion().'" />';
      $salida .= '</AGILHU:UserHistory.Attribute>';
    }
	$salida .= '</AGILHU:UserHistory>';
    return $salida;
  }

    /**
  * Aqui se validan el riesgo y las dependencias de una hu antes de ser creada
  *Casos:
   *Riesgo una hu tiene un riesgo mayor o igual que el de las hu de las cuales depende
   *Dependencias no existen ciclos entre las dependencias de las hu, 
   *ejemplo:A depende de B , B depende de A. Este caso no se debe presentar, 
  *esta funcion devuelve un mensaje en caso de error, si no devuelve ''
  *@author Maryit Sanchez
  *@date 2010-04-23
  **/
  protected function validadHU($his_identificador_historia,$his_prioridad,$his_dependencias)// esta validacion se realiza si se esta actualizando o versionando
  {
//es decir existen hu que dependen de estas y asu vez esta tiene hu de las que depende
  /*
  dependencias
  recuperar todas las dependencias y tratar de ordenarlas si pasado un numero de iteracion n*n
  riesgo compara con lo de los papas y los hijos
  */
 /*   $pro_id = $this->getUser()->getAttribute('proyectoSeleccionado');

    $conexion = new Criteria();
    $conexion->clearSelectColumns();
    $conexion->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $conexion->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
    $conexion->addSelectColumn('MAX('.AgilhuHistoriaUsuarioPeer::HIS_VERSION.') AS HIS_VERSION');
    $conexion->addGroupByColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);

    $historias_ultimas_versiones = AgilhuHistoriaUsuarioPeer::doSelectStmt($conexion);
    $datos;
    $fila=0;
    while ($historia = $historias_ultimas_versiones->fetch(PDO::FETCH_NUM)) {

    $ch = new Criteria();
    $ch->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
    $ch->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA,$historia[0]);
    $ch->add(AgilhuHistoriaUsuarioPeer::HIS_VERSION,$historia[1]);
    $historias = AgilhuHistoriaUsuarioPeer::doSelect($ch);

	foreach($historias As $historia)
	    {
              $clave=$historia->getHisIdentificadorHistoria(); //para aceder directamente a cada hu
	      $datos[$clave]['his_identificador_historia'] = $historia->getHisIdentificadorHistoria();
	      $datos[$clave]['his_prioridad'] = $historia->getHisPrioridad();
	      $datos[$clave]['his_dependencias'] = $historia->getHisDependencias();
	//      $datos[$fila]['his_riesgo'] = $historia->getHisRiesgo();
	      $fila++;
	    }
   } 
   if($fila>0)
   {
   $datos[$his_identificador_historia]['his_prioridad']=$his_prioridad;
   $datos[$his_identificador_historia]['his_dependencias']=$his_dependencias;

   //ahora si con estos datos empezar a verificar
   }
   
    return $salida;*/
  }

  /**
  * lista los resultados de las direrentes evaluaciones
  *@author Maryit Sanchez
  *@date 2010-05-25
  **/
  protected function listarEvaluaciones()
  {
    $his_evaluada_id = $this->getRequest()->getParameter('his_id');
    
    $conexion = new Criteria();
    $conexion->add(AgilhuPruebaExpertoPeer::HIS_ID_ASOCIADA, $his_evaluada_id);
    
    $evaluaciones = AgilhuPruebaExpertoPeer::doSelect($conexion);
    
    $fila=0;
    $datos;
    foreach($evaluaciones As $evaluacion)
    {
      $datos[$fila]['his_evaluada'] = $evaluacion->getHisIdAsociada();
      $datos[$fila]['usu_evaluador'] = $this->getUsuUsuario($evaluacion->getUsuEvaluadorId());
      $datos[$fila]['pru_comentarios'] = $evaluacion->getPruComentarios();
      $datos[$fila]['pru_independiente'] = $evaluacion->getPruIndependiente();
      $datos[$fila]['pru_negociable'] = $evaluacion->getPruNegociable();
      $datos[$fila]['pru_valiosa'] = $evaluacion->getPruValiosa();
      $datos[$fila]['pru_estimable'] = $evaluacion->getPruEstimable();
      $datos[$fila]['pru_pequena'] = $evaluacion->getPruPequena();
      $datos[$fila]['pru_testeable'] = $evaluacion->getPruTesteable();
      $datos[$fila]['pru_fecha_evaluacion'] = $evaluacion->getPruFechaEvalucion();

      $fila++;
    }
    if($fila>0)
    {
    $salida = '({"total":"'.$fila++.'","results":'.json_encode($datos).'})';
    }
    else
    {
    $salida = '({"total":"0","results":""})';
    }
    return $salida;
  }

 /**
  * lista el promedio de los resultados de las direrentes evaluaciones de una hu
  *@author Maryit Sanchez
  *@date 2010-05-25
  **/
  protected function listarPromEvaluaciones()
  {
    $his_evaluada_id = $this->getRequest()->getParameter('his_id');
    $his_nombre=$this->getRequest()->getParameter('his_nombre');
    
    $conexion = new Criteria();
    $conexion->add(AgilhuPruebaExpertoPeer::HIS_ID_ASOCIADA, $his_evaluada_id);
    $evaluaciones = AgilhuPruebaExpertoPeer::doSelect($conexion);

    $fila=0;
    $datos;
//variables
      $independiente=0.0;
      $negociable=0.0;
      $valiosa=0.0;
      $estimable=0.0;
      $testeable=0.0;
      $pequena=0.0;

    foreach($evaluaciones As $evaluacion)
    {
     
      $independiente+=$evaluacion->getPruIndependiente();
      $negociable+=$evaluacion->getPruNegociable();
      $valiosa+=$evaluacion->getPruValiosa();
      $estimable+=$evaluacion->getPruEstimable();
      $testeable+=$evaluacion->getPruTesteable();
      $pequena+=$evaluacion->getPruPequena();

      $fila++;
      $datos[0]['his_nombre'] =$his_nombre ;
      $datos[0]['pru_independiente'] = $independiente/$fila;
      $datos[0]['pru_negociable'] = $negociable/$fila;
      $datos[0]['pru_valiosa'] = $valiosa/$fila;
      $datos[0]['pru_estimable'] =$estimable/$fila;
      $datos[0]['pru_pequena'] = $pequena/$fila;
      $datos[0]['pru_testeable'] = $testeable/$fila;
    }
 
    if($fila>0)
    {
    $salida = '({"total":"'.$fila++.'","results":'.json_encode($datos).'})';
    }
    else
    {
    $salida = '({"total":"0","results":""})';
    }
    return $salida;
  }

  
}