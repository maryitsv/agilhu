<?php
 echo use_helper( 'Javascript' );

 echo javascript_tag("Ext.onReady(function(){
		var agpruebahistoria=PruebaHistoria();
                agpruebahistoria.render('pruebaForm');
		});");
?>
<div id="gridhuprueba"></div>
<div id="pruebaForm"></div>
