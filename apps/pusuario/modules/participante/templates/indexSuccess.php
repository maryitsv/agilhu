<?php
 echo use_helper('Javascript');
	
 echo javascript_tag("Ext.onReady(function(){
		var agparticipante=Participante();
                agparticipante.render('formularioParticipante');
		});");
?>
<div id="formularioParticipante"></div>    
