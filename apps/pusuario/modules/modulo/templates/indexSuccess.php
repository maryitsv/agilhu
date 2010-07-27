

<?php
        echo use_helper('Javascript');	
       
        echo javascript_tag("Ext.onReady(function(){
		var modulo=Modulo();
                modulo.render('formularioModuloDiv');
		});");
?>
<div id="formularioModuloDiv"></div>    
