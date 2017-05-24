<?php

App::uses('AppHelper', 'View/Helper');

class CkeditorHelper extends AppHelper {
	
	public $caminhoCompleto;
	public $arquivo;
	public $caminho;
	
	function __construct() {
		$this->caminhoCompleto = explode("/", $_SERVER['PHP_SELF']);
		$this->arquivo = end($this->caminhoCompleto);
		$this->caminho = substr($_SERVER['PHP_SELF'] ,0 , -strlen($this->arquivo)) . 'js/ckfinder';
    }
	
	function escreveCodigo($toolbar = 'completo') {
		
		if ($toolbar == 'completo') {
			$script = '<script type="text/javascript">
				var editor = CKEDITOR.replace("textoEditor");
				CKFinder.setupCKEditor(editor, "'.$this->caminho.'");
			</script>';
		}
		
		else if ('basico') {
			$script = '<script type="text/javascript">
				CKEDITOR.replace(
					"textoEditor",
					{
						toolbar: [
							[ "Bold","Italic","Underline","Strike","-","Link","Unlink" ]
						],
					}
				);
			</script>';
		}
		
		else {
			$script = '';
		}
		
		return $script;
    }
	
}

?>