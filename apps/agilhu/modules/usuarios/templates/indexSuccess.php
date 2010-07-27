<?php use_helper('Javascript')  ?>

<?php 
	
echo javascript_tag("
		
Ext.onReady(function(){

Ext.QuickTips.init();
 
var cp = new Ext.state.CookieProvider({
   expires: new Date(new Date().getTime()+(1000*60*60*24*30)) //30 days
});
Ext.state.Manager.setProvider(cp);
var cook= Ext.state.Manager.getProvider();
cook.set('agUsu_usuario','asd');
      

var agFormAutenticacion=new Ext.FormPanel({
			url:'usuarios/cargar',
			layout: 'form',
			frame:true,
			title: 'Iniciar sesión',
			id:'agFormAutenticacion',
			monitorValid:true,
			stateId :'agFormAutenticacion-stateid',
           		stateful : true,
			labelWidth :130,
			defaults:{xtype: 'textfield',width:160,allowBlank:false},
			items: [
				{id:'agUsu_usuario',name:'agUsu_usuario',fieldLabel:'Nombre de usuario',allowBlank:false},
				{id:'agusu_clave',name:'agUsu_clave',fieldLabel:'Contraseña       ', inputType:'password',allowBlank:false},
				{xtype: 'checkbox',fieldLabel: 'Recordarme      ',name: 'chk-active',id: 'id-active'}  
				],
			buttons:[{text:'Acceder    ', formBind: true, handler:autenticar}]
			});


	var agContenedor = new Ext.Viewport({
	id: 'agContenedor',
	defaults:{collapsible:true,
		  split:true
		},
	layout: 'border',
	items: [ new Ext.BoxComponent({
                region: 'north',
                height: 110,
                autoEl: {
		    el: 'header',
                    tag: 'div'
                }
            }),{
		xtype: 'panel',
		region:'center',  
		title: '<h2>Descripcion de AGILHU</h2>',
		layout:'fit',	bodyStyle:'padding:15px',
		contentEl:'descripcion'
		},{
		 region:'east',
		 xtype: 'panel',
		 layout: 'column',
		 width: 360,
	         bodyStyle:'padding:15px',
		 height: 260,
		 items: [agFormAutenticacion,
			{
			xtype: 'panel',
			layout:'fit',
			border:false,
			bodyStyle:'padding:15px 40px 25px 40px',
			items: [{xtype:'button',text:'Registrarse',maxWidth:250,minWidth:250,height:53,minHeight:50, margins:{top:50,bottom:50},style: 'font-weight:bold;font-size:30pt; color:black;'},]
			}
			]
		}
		],
	renderTo:document.body
	});
   

function autenticar()
{
	Ext.Msg.alert('Aviso!', 'Authentication');

	agFormAutenticacion.getForm().submit({
	method: 'POST',
	params: {
	task: 'BUSCARUSUARIO'
	},
	waitTitle: 'Enviando',
	waitMsg: 'Enviando datos...',
	success: function(response, action)
	{
		obj = Ext.util.JSON.decode(action.response.responseText);
		Ext.Msg.show
		({title:'Alerta!',msg: obj.mensaje,buttons: Ext.Msg.OK,animEl: 'elId',icon: Ext.MessageBox.INFO});

	},
	failure: function(form, action, response)
	{
		if(action.failureType == 'server'){
			obj = Ext.util.JSON.decode(action.response.responseText); 
			Ext.Msg.show({title:'Error',msg: obj.errors.reason,buttons: Ext.Msg.OK,animEl: 'elId',con: Ext.MessageBox.ERROR});
		}
	} 
	});

}

});

//1E4179
");

?>
<html>
<body>
<div id="header"   style="height:'505 px';background:white repeat-x 0 0; ">
	<div id="title" style="background:white;font:normal 20px arial;color:white;margin:5px;">
<p><img src="../images/logo.jpg" alt="logo"/></p>
	
	</div>
<div id='titleMensaje' style="color:white;font:normal 20px;margin:5px;" >
</div>
</div>

<div id="formulario" width='360' ></div>

<div id="descripcion">
<p>Agilhu es una herramienta que permite la gestión de historias de usuario de forma facíl .
Te permite crear tus proyectos, modulos, e historias de usuario, controla de forma automatica las versiones de tus HU, puedes invitar a otros miembros de la comunidad a hacer parte de tu proyecto y puedes definir sus roles de forma clara.</p>
<p>A demas nos preocupaos por la calidad de tu documentaci´on y te damos una forma de evaluarlas antes de implementar. </p>
<p>actualmente es un proyecto desarrollado por estudiantes de la esic de la universidad del valle</p>
</div>

</body>
</html>
