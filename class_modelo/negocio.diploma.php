<?php
class Diploma extends Persistencia{
	const TABELA = "fmj_diploma";    
        
	var $titulo;	
    var $layout;    
    
	
	function Incluir(){
		$this->titulo = $_REQUEST['titulo'];
		$this->layout = $_REQUEST['texto'];
		$this->save();
		$_SESSION['fmj.mensagem'] = 80;
	}
	
	function Alterar(){
		$this->getById($_REQUEST['id']);		
		$this->titulo = $_REQUEST['titulo'];
		$this->layout = $_REQUEST['texto'];
		$this->save();
		$_SESSION['fmj.mensagem'] = 81;
	}
	function Excluir($id){
		$this->delete($id);		
		$_SESSION['fmj.mensagem'] = 82;
	}
	
	function getDiplomas(){
		return $this->getRows();
	}
}
?>