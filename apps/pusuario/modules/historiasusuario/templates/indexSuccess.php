<?php
 echo use_helper( 'Javascript' );
 echo javascript_tag("Ext.onReady(function(){
		var aghistoria=HistoriaUsuario();
                aghistoria.render('historia_usuario');
		});");
       
?>
<div id="gridhu"></div>
<div id="historia_usuario"></div>
