<?php
 echo use_helper('Javascript');
 echo javascript_tag("Ext.onReady(function(){
		var agdocumento=Documento();
                agdocumento.render('formularioDocumentos');
		});");

?>
<div id="formularioDocumentos"></div>    
