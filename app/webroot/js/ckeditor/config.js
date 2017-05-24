/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.language = 'pt-BR';
	config.toolbar = [
		["Bold","Italic","Underline","-","Undo","Redo","-","Cut","Copy","Paste","PasteText","PasteFromWord","Find","-","Outdent","Indent","NumberedList","BulletedList"],
		["-","JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock"],
		["Image","Table","-","Link","TextColor","FontSize"],
		["Source"]
	];
};
