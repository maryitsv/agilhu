<?php
 echo use_helper('Javascript');
	
 echo javascript_tag("
                Ext.chart.Chart.CHART_URL = '../js/extjs/resources/charts.swf';
                Ext.onReady(function(){
                var agdatosPro=DatosProyecto();
                agdatosPro.render('formularioDatosProyecto');
		});");
?>
<div id="formularioDatosProyecto"></div>    
