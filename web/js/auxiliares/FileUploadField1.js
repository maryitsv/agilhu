// vim: ts=4:sw=4:nu:fdc=4:nospell
/**
 * Search plugin for Ext.grid.GridPanel, Ext.grid.EditorGrid ver. 2.x or subclasses of them
 *
 * @author    Ing. Jozef Sakalos
 * @copyright (c) 2008, by Ing. Jozef Sakalos
 * @date      17. January 2008
 * @version   $Id: Ext.ux.grid.Search.js 220 2008-04-29 21:46:51Z jozo $
 *
 * @license Ext.ux.grid.Search is licensed under the terms of
 * the Open Source LGPL 3.0 license.  Commercial use is permitted to the extent
 * that the code/component(s) do NOT become part of another Open Source or Commercially
 * licensed development library or toolkit without explicit permission.
 * 
 * License details: http://www.gnu.org/licenses/lgpl.html
 */

/*global Ext */
//La idea es ponerlo en un combobox o algo asi
Ext.ns('Ext.ux.grid');

/**
 * @class Ext.ux.grid.Search
 * @extends Ext.util.Observable
 * @param {Object} config configuration object
 * @constructor
 */
Ext.ux.grid.Search = function(config) {
	Ext.apply(this, config);
	Ext.ux.grid.Search.superclass.constructor.call(this);
}; // eo constructor

Ext.extend(Ext.ux.grid.Search, Ext.util.Observable, {
	 searchText:'Search'

	,searchTipText:'Type a text to search and press Enter'

	,selectAllText:'Select All'

	,position:'bottom'

	,iconCls:'icon-magnifier'

	,checkIndexes:'all'

	,disableIndexes:[]

	,dateFormat:undefined

	,showSelectAll:true

	,menuStyle:'checkbox'

	,minCharsTipText:'Type at least {0} characters'

	,width:400

	,xtype:'gridsearch'

	,shortcutKey:'r'

	,shortcutModifier:'alt'


	,init:function(grid) {
		this.grid = grid;

		// setup toolbar container if id was given
		if('string' === typeof this.toolbarContainer) {
			this.toolbarContainer = Ext.getCmp(this.toolbarContainer);
		}

		grid.onRender = grid.onRender.createSequence(this.onRender, this);
		grid.reconfigure = grid.reconfigure.createSequence(this.reconfigure, this);
	} // eo function init

	,onRender:function() {
		var panel = this.toolbarContainer || this.grid;
		var tb = 'bottom' === this.position ? panel.bottomToolbar : panel.topToolbar;

		// add menu
		this.menu = new Ext.menu.Menu();

		// handle position
		if('right' === this.align) {
			tb.addFill();
		}
		else {
			if(0 < tb.items.getCount()) {
				tb.addSeparator();
			}
		}

		// add menu button
		tb.add({
			 text:this.searchText
			,menu:this.menu
			,iconCls:this.iconCls
		});

		// add input field (TwinTriggerField in fact)
		this.field = new Ext.form.TwinTriggerField({
			 width:this.width
			,selectOnFocus:undefined === this.selectOnFocus ? true : this.selectOnFocus
			,trigger1Class:'x-form-clear-trigger'
			,trigger2Class:this.minChars ? 'x-hidden' : 'x-form-search-trigger'
			,onTrigger1Click:this.minChars ? Ext.emptyFn : this.onTriggerClear.createDelegate(this)
			,onTrigger2Click:this.onTriggerSearch.createDelegate(this)
			,minLength:this.minLength
		});

		// install event handlers on input field
		this.field.on('render', function() {
			this.field.el.dom.qtip = this.minChars ? String.format(this.minCharsTipText, this.minChars) : this.searchTipText;

			if(this.minChars) {
				this.field.el.on({scope:this, buffer:300, keyup:this.onKeyUp});
			}

			// install key map
			var map = new Ext.KeyMap(this.field.el, [{
				 key:Ext.EventObject.ENTER
				,scope:this
				,fn:this.onTriggerSearch
			},{
				 key:Ext.EventObject.ESC
				,scope:this
				,fn:this.onTriggerClear
			}]);
			map.stopEvent = true;
		}, this, {single:true});

		tb.add(this.field);

		// reconfigure
		this.reconfigure();

		// keyMap
		if(this.shortcutKey && this.shortcutModifier) {
			var shortcutEl = this.grid.getEl();
			var shortcutCfg = [{
				 key:this.shortcutKey
				,scope:this
				,stopEvent:true
				,fn:function() {
					this.field.focus();
				}
			}];
			shortcutCfg[0][this.shortcutModifier] = true;
			this.keymap = new Ext.KeyMap(shortcutEl, shortcutCfg);
		}

		if(true === this.autoFocus) {
			this.grid.store.on({scope:this, load:function(){this.field.focus();}});
		}
	} 
	,onKeyUp:function() {
		var length = this.field.getValue().toString().length;
		if(0 === length || this.minChars <= length) {
			this.onTriggerSearch();
		}
	} 
	,onTriggerClear:function() {
		if(this.field.getValue()) {
			this.field.setValue('');
			this.field.focus();
			this.onTriggerSearch();
		}
	} // eo function onTriggerClear
	// }}}
	// {{{
	/**
	 * private Search Trigger click handler (executes the search, local or remote)
	 */
	,onTriggerSearch:function() {
	var menu = this.menu;
	menu.removeAll();

	var store = this.grid.store;
	var group = undefined;
	if('radio' === this.menuStyle) {
		group = 'g' + (new Date).getTime();	
	}
     var field=this.field;
       // alert(store.getCount());
	 var i=0;
		store.data.each(function(row) {
			var disable = false;

				if(!disable) {
					menu.add(new Ext.menu.CheckItem({
						 text:row.data.modNombre
						,hideOnClick:false
						,group:group
						,checked:'all' === this.checkIndexes
						,dataIndex:row.data.modNombre
                        ,handler:function(){
                        field.setValue(this.text);
						//field.setText(this.text);
						}
					}));
			i++;
				}
			
		});

	} 
	,setDisabled:function() {
		this.field.setDisabled.apply(this.field, arguments);
	} // eo function setDisabled
	// }}}
	// {{{
	/**
	 * Enable search (TwinTriggerField)
	 */
	,enable:function() {
		this.setDisabled(false);
	} // eo function enable
	
	,disable:function() {
		this.setDisabled(true);
	} // eo function disable
	
	,reconfigure:function() {

		

	} // eo function reconfigure
	// }}}

}); // eo extend

// eof
