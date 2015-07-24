<?php
class Pagina extends Persistencia{
	const PRESIDENCIA = 1;
	const DIRETORIA = 2;		
	var $conteudo;
    var $nome;
	
	
	public function Alterar(){
		$this->getById($_POST['id']);
		$this->conteudo = $_POST['texto'];
		$this->save();		
		$_SESSION['fmj.mensagem'] = 29;
		header("Location:admin_pagina-".$this->nome);
		exit();
	}
	
    
}
?>