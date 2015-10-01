<?php
class Graduacao extends Persistencia {
    var $descricao;
    var $faixa;
    var $imagem;
    var $idadeMin;
    var $carenciaMin;  
	var $ordem;
	var $bitAtivo; 


	function Incluir() {     
        $this -> descricao = $_REQUEST['descricao'];
        $this -> faixa = $_REQUEST['faixa'];
        $this->bitAtivo = $_REQUEST['ativo'];
        $this->imagem = $_REQUEST['cor'];
        $this->idadeMin = $_REQUEST['idadeMin'];
        $this->carenciaMin = $_REQUEST['carencia'];
        $this->ordem = $_REQUEST['ordem'];
        $this->save();      
        
    }
    
	function Alterar() {
		$this-> getById($_REQUEST['id']);     
        $this -> descricao = $_REQUEST['descricao'];
        $this -> faixa = $_REQUEST['faixa'];
        $this->bitAtivo = $_REQUEST['ativo'];
        $this->imagem = $_REQUEST['cor'];
        $this->idadeMin = $_REQUEST['idadeMin'];
        $this->carenciaMin = $_REQUEST['carencia'];
        $this->ordem = $_REQUEST['ordem'];
        $this->save();      
        
    }
	
	function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        if ($this -> delete($this -> id)){
            $_SESSION['fmj.mensagem'] = 49;
        }else
            $_SESSION['fmj.mensagem'] = 17;
        
    }
}
?>