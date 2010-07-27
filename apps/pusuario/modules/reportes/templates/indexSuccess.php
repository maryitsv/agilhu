<?php
        echo use_helper('Javascript');	
       
        echo javascript_tag("Ext.onReady(function(){
		var reporte=Reportes();
                reporte.render('formularioReporteDiv');
		});");
?>
<div id="formularioReporteDiv"></div>    
