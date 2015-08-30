<?php
class Pagina extends Persistencia{
    const LINKS = 2;
    const AFEMEJU = 3;
    const CONTATO = 4;		
	var $conteudo;
    var $nome;
    var $titulo;
	
	
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