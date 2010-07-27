<?php  echo use_helper('Javascript') ?>

<?php  echo javascript_tag("Ext.onReady(function(){
		var aggestionusuarios=agGestionUsuario();
                aggestionusuarios.render('formularioUsuario');
		});");
  // echo javascript_tag("Ext.onReady(agGestionUsuario.init, agGestionUsuario);")

?>


<div id="formularioUsuario"></div>
