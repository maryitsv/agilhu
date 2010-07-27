<?php

/**
 * principal actions.
 *
 * @package    pusuario
 * @subpackage principal
 * @author     maryit
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class principalActions extends sfActions
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

 public function executeCargar()
  {
  
  		$arbol="[{leaf: true,id : 'pusuario.php/datosproyecto',text: 'Datos Proyecto',iconCls: 'proyecto'},";
		       
		$conexion = new Criteria();
		$conexion->add(AgilhuModuloPeer::PRO_ID,$this->getUser()->getAttribute('proyectoSeleccionado'));          
		$modulos = AgilhuModuloPeer::doSelect($conexion);
				      
		$pos = 0;
		$nbrows=0;
		$datos;
		/*if($modulos)
		{
			$arbol.= "{id : 'pusuario.php/modulo',text: 'Modulos',iconCls: 'modulo', children:[";
		
			foreach ($modulos As $modulo)
			{
				$arbol.="{leaf: true,id : '".$modulo->getModId()."',text: '".$modulo->getModNombre()."',iconCls: 'modulo'},";
	            // ".."
	            $pos++;
	            $nbrows++;
			}
			$arbol.="]},";
		}
		else {
		$arbol.= "{leaf: true,id : 'pusuario.php/modulo',text: 'Modulo',iconCls: 'modulo'},";
		}*/
		$arbol.= "{leaf: true,id : 'pusuario.php/modulo',text: 'Modulo',iconCls: 'modulo'},";
 		$arbol.= "{leaf: true,id : 'pusuario.php/historiasusuario/crear',text: 'Historias de usuario',iconCls: 'historias'},
		            {leaf: true,id : 'pusuario.php/pruebaexperto/index',text: 'Pruebas',iconCls: 'prueba'},
		            {leaf: true,id : 'pusuario.php/documentos',text: 'Documentos',iconCls: 'docs'},
		            {leaf: true,id : 'pusuario.php/participante',text: 'Participantes',iconCls: 'participantes'},
			
	            ]";
	    //    {leaf: true,id : 'pusuario.php/mensajes',text: 'Mensajes',iconCls: 'participantes'}
		            
    return $this->renderText($arbol);
  }


  /**
  * Este metodo se encarga de sacar al usuario del sistema y regresarlo a la pantalla de autenticacion
  */  
  public function executeSalir()
  {
    

    if($this->getUser()->isAuthenticated())
    {
      $this->getUser()->setAuthenticated(false);
      $this->getUser()->getAttributeHolder()->clear();
    }     //http://vmlabs04.eisc.univalle.edu.co/~maryitsv/Dropbox/agilhu/web
   
   /*$urlApp=$this->getParameter('urlApp'); 
    if($urlApp!='')
    {
       return $this->redirect($urlApp.'index.php/autenticacion');
    }*/
    
    return $this->redirect('http://vmlabs04.eisc.univalle.edu.co/~maryitsv/agilhu-v2/web/index.php/autenticacion');

  }

}


