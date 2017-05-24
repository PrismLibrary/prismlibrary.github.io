<?php 

class UploadHelper extends AppHelper {
	
	public $helpers = array('Html');
	
	public function cadastrar() {
		
		$webroot = Router::url("/") . "ajax_multi_upload";
		
		$str = '<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/base/jquery-ui.css" id="theme">';
		$str .= '<link rel="stylesheet" href="'.$webroot.'/css/jquery.fileupload-ui.css">';
		$str .= '<table id="files"></table>';
		$str .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>';
		$str .= '<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>';
		$str .= '<script src="'.$webroot.'/js/jquery.fileupload.js"></script>';
		$str .= '<script src="'.$webroot.'/js/jquery.fileupload-ui.js"></script>';
		$str .= '
			<script>
			$(document).ready(function() {
				/*global $ */
				$(function () {
					$("#file_upload").fileUploadUI({
						uploadTable: $("#files"),
						downloadTable: $("#files"),
						buildUploadRow: function (files, index) {
							return $("<tr><td>" + files[index].name + "<\/td>" +
							"<td class=\'file_upload_progress\'><div><\/div><\/td>" +
							"<td class=\'file_upload_cancel\'>" +
							"<button class=\'ui-state-default ui-corner-all\' title=\'Cancelar\'>" +
							"<span class=\'ui-icon ui-icon-cancel\'>Cancelar<\/span>" +
							"<\/button><\/td><\/tr>");
						},
						buildDownloadRow: function (file) {
						return $("<tr><td><img src=\"'.$this->webroot.'files/galeria/" + file.dir + "/mini/" + file.name + "\" width=\"50\" \/> Ok<\/td><\/tr>");
						}
					});
				});
			});
			</script>
		';
		
		return $str;
	}
}
