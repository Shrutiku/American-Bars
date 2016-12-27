/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#666666';
	
	  // Define changes to default configuration here. For example:
   // config.language = 'fr';
   // config.uiColor = '#AADC6E';
   // config.filebrowserBrowseUrl='http://192.168.1.25/sanjay/2014/pokatalk/admin/ckfinder/ckfinder.html';
   // config.filebrowserImageBrowseUrl='hhttp://192.168.1.25/sanjay/2014/pokatalk/admin/ckfinder/ckfinder.html?Type=Images';
   // config.filebrowserFlashBrowseUrl='http://192.168.1.25/sanjay/2014/pokatalk/admin/ckfinder/ckfinder.html?Type=Flash';
   // config.filebrowserUploadUrl= 'http://192.168.1.25/sanjay/2014/pokatalk/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
   // config.filebrowserImageUploadUrl='http://192.168.1.25/sanjay/2014/pokatalk/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
   // config.filebrowserFlashUploadUrl='http://192.168.1.25/sanjay/2014/pokatalk/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
   // config.height='500';
   // config.width='600';
   
  // config.removeDialogTabs = 'image:advanced;image:Link;link:advanced;link:upload';
  
  config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		//{ name: 'styles' },
		//{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';
	config.removePlugins = 'elementspath,save,font';
	config.pasteFromWordRemoveFontStyles = false;
	config.allowedContent=true;
};
