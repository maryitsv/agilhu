<?php
        echo use_helper('Javascript');
	
//        echo javascript_tag("Ext.onReady(PrincipalAdmin.init, PrincipalAdmin);");

       echo javascript_tag("Ext.onReady(function(){
		var principalAdmin=PrincipalAdmin();              
		});");

?>
<div id="header" style="background:white;">
	<div id="agtitleizq" style="font:normal 20px arial;color:black;margin:5px;float:left;width:380px;background-color:white;">
          <img src="../images/agilhu.png"/>
	</div>
	<div id="agbarrader" style="font:normal 20px arial;color:black;margin:5px;float:right;width:400px;">		
	</div>
</div>
