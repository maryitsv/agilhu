<?php

/**
 * documentos actions.
 *
 * @package    pusuario
 * @subpackage documentos
 * @author     maryitsv
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class documentosActions extends sfActions
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
  
  
  
    public function executeCargar(){
  		$task = '';
		$salida	='';

       	$task = $this->getRequest()->getParameter('task');
        $pro_id=$this->getUser()->getAttribute('proyectoSeleccionado');

       	switch($task){
			case "CREATEDOC": 
				$salida = $this->crearDocumento();
				break;
				
			case "LISTARDOCS":
				$salida = $this->listarDocumento();
				break;
				
			case "DESCARGAR":
				$salida = $this->dercargarDocumento();
				break;
				
			case "LISTARMOD":
				$salida = $this->listarModulos($pro_id);
				break;

			case "LISTARHU":
				$salida = $this->listarHU($pro_id);
				break;

			case "ELIMINARDOC":
				$salida = $this->eliminarDocumento();
				break;

			default:
				$salida =  "{failure:true}";
				break;
		}

       	return $this->renderText($salida);
  }



  protected function listarModulos($pro_id)
  {
     $conexion = new Criteria();
     $conexion->add(AgilhuModuloPeer::PRO_ID,$pro_id);
     $cantidad_modulos = AgilhuModuloPeer::doCount($conexion);
     $modulos = AgilhuModuloPeer::doSelect($conexion);

		
     $pos = 0;
     $datos;

     if($modulos)	
     {	
          foreach ($modulos As $modulo)
          {
                $datos[$pos]['modId']=$modulo->getModId();
                $datos[$pos]['modNombre']=$modulo->getModNombre();			    
                $pos++;
          }
          if($pos>0){
                $jsonresult = json_encode($datos);
                return '({"total":"'.$cantidad_modulos.'","results":'.$jsonresult.'})';
          }
     }
     else {
          return '({"total":"0", "results":""})';
     }
  }

/*
 protected function listarHU($pro_id)
  {
  		$conexion = new Criteria();
		$cantidad_historias = AgilhuHistoriaUsuarioPeer::doCount($conexion);
		$conexion ->add(AgilhuHistoriaUsuarioPeer::PRO_ID,$pro_id);
		//$conexion->clearSelectColumns();
		//$conexion->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
		//$conexion->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_NOMBRE);
		$conexion->setDistinct();

		$historias = AgilhuHistoriaUsuarioPeer::doSelect($conexion);
		
		$pos = 0;
		$nbrows=0;
		$datos;
		if($historias)	
		{	
			foreach ($historias As $historia)
			{
			    $datos[$pos]['hisId']=$historia->getHisId();
			    $datos[$pos]['hisNombre']=$historia->getHisNombre();			    
			    $pos++;
			    $nbrows++;
			}
			if($nbrows>0){
			$jsonresult = json_encode($datos);
			return '({"total":"'.$cantidad_historias.'","results":'.$jsonresult.'})';
			}
		}
		else {
			return '({"total":"0", "results":""})';
		}
  }
*/


/**
  *Este metodo retorna la lista de hu teniendo en cuenta la ultima actualizada de las hu
  *@author maryit sanchez
  *@date 2010-03-26  
  **/
 protected function listarHU($pro_id)
  {
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
	     // $datos[$fila]['his_id'] = $historia->getHisId(); his_identificador_historia
	      $datos[$fila]['hisIdentificador'] = $historia->getHisIdentificadorHistoria();
	      $datos[$fila]['hisNombre'] = $historia->getHisNombre();

	      $fila++;
	    }
   } 
	$salida = '({"total":"'.$fila++.'","results":'.json_encode($datos).'})';
    return $salida;
  }


protected function getNombreModulo($modId)
  {
  		$conexion = new Criteria();
		$conexion->add(AgilhuModuloPeer::MOD_ID,$modId);
		
		$modulo = AgilhuModuloPeer::doSelectOne($conexion);
		
		if($modulo)
		{
		return $modulo->getModNombre();
		}
	return '';
  }
/*
protected function getNombreHU($hisId)
  {
  		$conexion = new Criteria();
		$conexion->add(AgilhuHistoriaUsuarioPeer::HIS_ID,$hisId);
		
		$historia = AgilhuHistoriaUsuarioPeer::doSelectOne($conexion);
		
		if($historia)
		{
		return $historia->getHisNombre();
		}
	return '';
  }
*/


protected function getNombreHU($pro_id,$his_identificador)
  {

    $his_nombre='';
     if($his_identificador!=0){
  
        try{
         //  echo($his_identificador);
	  $cv = new Criteria();
	  $cv->clearSelectColumns();
	  $cv->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
	  $cv->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA, $his_identificador);
	//  $cv->addSelectColumn(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA);
	  $cv->addSelectColumn('MAX('.AgilhuHistoriaUsuarioPeer::HIS_VERSION.') AS HIS_VERSION');

	  $historias_ultima_version = AgilhuHistoriaUsuarioPeer::doSelectStmt($cv);

	      while ($historiauv = $historias_ultima_version->fetch(PDO::FETCH_NUM)) {
              //echo('uu');
	      $ch = new Criteria();
	      $ch->add(AgilhuHistoriaUsuarioPeer::PRO_ID, $pro_id);
	      $ch->add(AgilhuHistoriaUsuarioPeer::HIS_IDENTIFICADOR_HISTORIA,$his_identificador);
	      $ch->add(AgilhuHistoriaUsuarioPeer::HIS_VERSION,$historiauv[0]);
	      $historias = AgilhuHistoriaUsuarioPeer::doSelect($ch);

		  foreach($historias As $historia)
		      {
			$his_nombre=  $historia->getHisNombre();
               //          echo('hip');
                  //       echo($historia->getHisNombre());
		      }
	      } 

	}
	catch(Exception $e){
	}
    }
	return $his_nombre;
  }

protected function getNombreUsuario($usuId)
  {
  		$conexion = new Criteria();
		$conexion->add(AgilhuUsuarioPeer::USU_ID,$usuId);
		
		$usuario = AgilhuUsuarioPeer::doSelectOne($conexion);
		
		if($usuario)
		{
		$nombreCompleto=$usuario->getUsuNombres().' '.$usuario->getUsuApellidos();
		return $nombreCompleto;
		}
	return 'ninguno';
  }

/**
*Es esta funcion obtenemos un listado de todos los proyectos en los que puede participar el usuario logueado
*/
protected function listarDocumento()
  {
                $pro_id=$this->getUser()->getAttribute('proyectoSeleccionado');

  		$conexion = new Criteria();
		$cantidad_documentos = AgilhuDocumentoPeer::doCount($conexion);
	        
		if($this->getRequestParameter('modId'))
		{$conexion->add(AgilhuDocumentoPeer::DOC_ID_MOD,$this->getRequestParameter('modId'));}		
		
		$conexion->add(AgilhuDocumentoPeer::DOC_ID_PRO,$pro_id);
		$conexion->setLimit($this->getRequestParameter('limit'));
		$conexion->setOffset($this->getRequestParameter('start'));
		
		//aqui agregar los if necesarios, para suplir todas las peticiones de este mismo tipo, terminados, nuevos,en proceso.etc
	
		$documentos = AgilhuDocumentoPeer::doSelect($conexion);
		
		$pos = 0;
		$nbrows=0;
		$datos;
		if($documentos)	{	
			foreach ($documentos As $documento)
			{

		    $datos[$pos]['idDocumento']=$documento->getDocId();
		    $datos[$pos]['nombre']=$documento->getDocNombre();
		    $datos[$pos]['tamano']=$documento->getDocTamano();
		    $datos[$pos]['tipo']=$documento->getDocTipo();
		    $datos[$pos]['moduloNombre']=$this->getNombreModulo($documento->getDocIdMod());
		    $datos[$pos]['modulo']=$documento->getDocIdMod();

		    $datos[$pos]['historia']= $documento->getDocIdHis();
		    $datos[$pos]['historiaNombre']=$this->getNombreHU($pro_id , $documento->getDocIdHis());//identificador his

		    $datos[$pos]['subidoPor']=$this->getNombreUsuario($documento->getDocIdRemitente());
		    $datos[$pos]['fechasubido']=$documento->getCreatedAt();
		    $datos[$pos]['descripcion']=$documento->getDocDescripcion();
		    
		    
		    $pos++;
		    $nbrows++;
			}
			if($nbrows>0){
				$jsonresult = json_encode($datos);
				return '({"total":"'.$cantidad_documentos.'","results":'.$jsonresult.'})';
		}
		}
		else {
			return '({"total":"0", "results":""})';
		}
  }
  
 /**
 *Aqui se crea un doc
 */ 
  protected function crearDocumento()
  {
        $salida	='';

       		try{    	
       		        $doc = new AgilhuDocumento();
			
			$doc->setDocNombre($this->getRequestParameter('nombre'));
			
			$doc->setDocDescripcion($this->getRequestParameter('descripcion'));
			$doc->setDocIdHis($this->getRequestParameter('historia'));//identificador historia
			$doc->setDocIdMod($this->getRequestParameter('modulo'));
			$doc->setDocIdPro($this->getUser()->getAttribute('proyectoSeleccionado'));//del proyecto que tenga seleccionado hasta el momento
			
			$doc->setDocIdRemitente($this->getUser()->getAttribute('idUsuario'));
			
			sleep(1);
			$tamano = $_FILES['archivo']['size'];
			$tipo = $_FILES['archivo']['type'];
			$temporal = $_FILES['archivo']['tmp_name'];
				
			$fp = fopen($temporal, "rb");
			$contenido = fread($fp, $tamano);
			fclose($fp); 
			
			$doc->setDocTamano(''.$tamano);
			$doc->setDocTipo(''.$tipo);
			
			$doc->setDocContenido(''.$contenido);
					
			$doc->save();
			
			}
			catch (Exception $excepcion)
			{
			$salida = "({success: false, errors: { reason: 'Ya'}})";
			return $salida;
			}
			$salida = "({success: true, mensaje:'El proyecto fue creado exitosamente'})";
	 		
  return $salida;
  }
  

   protected function dercargarDocumento()
   {
	
  		$conexion = new Criteria();
		$conexion->add(AgilhuDocumentoPeer::DOC_ID,$this->getRequestParameter('Identificador'));
                $documento = AgilhuDocumentoPeer::doSelectOne($conexion);
	
		$tipo=$documento->getDocTipo();
	
                $bin = $documento->getDocContenido(); 	
		$this->getResponse()->clearHttpHeaders();
	   
     	        $this->getResponse()->clearHttpHeaders();
	  	$this->getResponse()->setHttpHeader("Content-Type", $tipo);
     	        $this->getResponse()->setHttpHeader("Content-Length",$documento->getDocTamano(), true);
	  
		$dato1 = fread($bin, $documento->getDocTamano());
		$this->getResponse()->setContent($dato1);

   }

 protected function eliminarDocumento()
  {
        $salida	='';

       		try{    	
		$conexion = new Criteria();
		$conexion->add(AgilhuDocumentoPeer::DOC_ID,$this->getRequestParameter('Identificador'));
		//$conexion->add(AgilhuDocumentoPeer::DOC_NOMBRE,$this->getRequestParameter('nombre'));
		$conexion->add(AgilhuDocumentoPeer::DOC_ID_PRO,$this->getUser()->getAttribute('proyectoSeleccionado'));

                $documento = AgilhuDocumentoPeer::doSelectOne($conexion);

		if($documento)				
		{$documento->delete();}

			}
			catch (Exception $excepcion)
			{
			$salida = "({success: false, errors: { reason: 'No se pudo eliminar el documento'}})";
			return $salida;
			}
			$salida = "({success: true, mensaje:'El documento fue eliminado con exito'})";
	 		
  return $salida;
  }
  
}
