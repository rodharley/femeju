<?php

class Mensagem extends Persistencia

{
		var $id = NULL;
	var $mensagem;
	var $tipo;
	
	

	
	
	function getMensagem($id){
	$xml = simplexml_load_file($this->URI."/xml/mensagem.xml");
		foreach ($xml->children() as $elemento){			
			
			if($elemento['id'] == $id){			
				$this->id = $id;
				$this->tipo = $elemento['type'];
				$strmsg = $elemento[0];
				if(isset($_SESSION['grc.param1'])){
					$strmsg = str_replace("{param1}",$_SESSION['grc.param1'],$strmsg);
					unset($_SESSION['grc.param1']);
				}
				if(isset($_SESSION['grc.param2'])){
					$strmsg = str_replace("{param2}",$_SESSION['grc.param2'],$strmsg);
					unset($_SESSION['grc.param2']);
				}
				if(isset($_SESSION['grc.param3'])){
					$strmsg = str_replace("{param3}",$_SESSION['grc.param3'],$strmsg);
					unset($_SESSION['grc.param3']);
				}
				$this->mensagem = utf8_decode($strmsg);
			}
		}
	}
	
	function echoMensagem(){
	$this->getMensagem($_SESSION['grc.mensagem']);
	$strReturn = "";
	$tipo = $this->tipo;
	
	switch($tipo){
		case 'success':
		$strReturn =  '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Sucesso!</b> '.$this->mensagem.'</div>';
		break;
		case 'danger':
		$strReturn =  '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Erro!</b> '.$this->mensagem.'</div>';
		break;
		case 'warning':
		$strReturn =  '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-warning"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Aviso!</b> '.$this->mensagem.'</div>';
		break;
		default :
		$strReturn =  '<div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>informação!</b> '.$this->mensagem.'</div>';
		break;
	}
	
	return $strReturn;
	}
	
                                    
                                    
                                    

}
?>