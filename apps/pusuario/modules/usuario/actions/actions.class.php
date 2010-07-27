<?php

/**
 * usuario actions.
 *
 * @package    agilhu
 * @subpackage usuario
 * @author     maryit
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class usuarioActions extends sfActions
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



 /**
 *A esta funcion se realizan todas las peticiones, y luego esta la dirige a la funcion correspondiente a lo que se pide
 *@author Maryit Sanchez
 *@date 2010-05-20 
 */ 
  public function executeCargar(){
        $task = '';
        $salida	='';

        $task = $this->getRequest()->getParameter('task');
        $usu_id=$this->getUser()->getAttribute('idUsuario');

       	switch($task){
				
            case "OBTENERDATOSUSUARIO":
                 $salida = $this->obtenerUsuario($usu_id);
                 break;
				
            case "CAMBIARCLAVE":
                 $salida = $this->cambiarClaveUsuario();
                 break;
				
            case "CAMBIARDATOS":
                 $salida = $this->cambiarDatosUsuario();
                 break;
											
            default:
                 $salida =  "{failure:true}";
                 break;
       }

       	return $this->renderText($salida);
  }

  
 /**
 *Es esta funcion obtenemos los datos basico de usuario tales como nombre, epellidos, mail,usuario y id
 *@author Maryit Sanchez
 *@date 2010-05-20
 */
 protected function obtenerUsuario($usu_id)
 {
      $datosUsuario = AgilhuUsuarioPeer::retrieveByPK($usu_id);
      $salida='';
      $pos=0;
      $datos;
     if($datosUsuario){
       $datos[$pos]['usu_id']=$datosUsuario->getUsuId();
       $datos[$pos]['usu_nombres']=$datosUsuario->getUsuNombres();
       $datos[$pos]['usu_apellidos']=$datosUsuario->getUsuApellidos();
       $datos[$pos]['usu_usuario']=$datosUsuario->getUsuUsuario();
       $datos[$pos]['usu_correo']=$datosUsuario->getUsuCorreo();

           
       $salida = '({"total":"1","results":'.json_encode($datos).'})';
      }

       return $salida;
 }


 /**
 *Es esta funcion actualizamos los datos de usuario tales como nombres, apellidos, correo 
 *@author Maryit Sanchez
 *@date 2010-05-20
 */
 protected function cambiarDatosUsuario()
 {
      $usu_nombres = $this->getRequest()->getParameter('usu_nombres');
      $usu_apellidos = $this->getRequest()->getParameter('usu_apellidos');
      $usu_correo = $this->getRequest()->getParameter('usu_correo');
      $usu_id = $this->getRequest()->getParameter('usu_id');
      $usu_usuario = $this->getRequest()->getParameter('usu_usuario');

      $salida;

      try{       
      $usuario = AgilhuUsuarioPeer::retrieveByPK($usu_id);
      $usuario->setUsuNombres($usu_nombres);
      $usuario->setUsuApellidos($usu_apellidos);
      $usuario->setUsuCorreo($usu_correo);
      $usuario->save();
      $salida = "({success: true, mensaje:'El usuario fue actualizado exitosamente'})";
      }
      catch (Exception $excepcionModulo)
      {
       $salida = "({success: false, errors: { reason: 'Hubo un problema actualizando el usuario ".$usu_usuario."'}})";
      }
       

    return $salida;
 }

 /**
 *Es esta funcion cambiamos la clave del usuario por otra
 *@author Maryit Sanchez
 *@date 2010-05-20
 */
 protected function cambiarClaveUsuario()
 {
      $usu_clave = base64_encode($this->getRequestParameter('usu_clave'));
      $usu_nueva_clave = $this->getRequest()->getParameter('usu_nueva_clave');
      $usu_re_nueva_clave = $this->getRequest()->getParameter('usu_re_nueva_clave');
      $usu_id = $this->getRequest()->getParameter('usu_id');
      $usu_usuario = $this->getRequest()->getParameter('usu_usuario');

      $salida;

      try{       
      $usuario = AgilhuUsuarioPeer::retrieveByPK($usu_id);

        if($usu_clave==$usuario->getUsuClave())
        {
        $usuario->setUsuClave(base64_encode($usu_nueva_clave));
        $usuario->save();
        $salida = "({success: true, mensaje:'La clave del usuario fue actualizada exitosamente'})";
        }
        else{
        $salida = "({success: false, errors: { reason: 'La clave anterior del usuario ".$usu_usuario." no es correcta'}})";
        }
      }
      catch (Exception $excepcionModulo)
      {
       $salida = "({success: false, errors: { reason: 'Hubo un problema actualizando la clave del usuario ".$usu_usuario."'}})";
      }
      

    return $salida;
 }


}
