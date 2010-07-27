<?php
        echo use_helper('Javascript');
	
        echo javascript_tag("Ext.onReady(function(){
		var proyectodiv=Proyecto();
                proyectodiv.render('formularioPro');
		});");
?>



<div id="formularioPro"></div>    
