<?php
class Classe extends Persistencia {
    var $descricao;
    var $maximo;
    var $minimo;
    var $ativo; 

function listaAtivas(){
	return $this->getRows(0,999,array("descricao"=>"ASC"),array("ativo"=>"=1"));
}
	function Incluir() {     
        $this -> descricao = $_REQUEST['descricao'];
        $this -> maximo = $this->limpaDigitos($_REQUEST['idademax']);
        $this -> minimo = $this->limpaDigitos($_REQUEST['idademin']);
        $this->ativo = $_REQUEST['ativo'];
        $this->save();      
        
    }
    
	function Alterar() {
		$this-> getById($_REQUEST['id']);     
        $this -> descricao = $_REQUEST['descricao'];
        $this -> maximo = $this->limpaDigitos($_REQUEST['idademax']);
        $this -> minimo = $this->limpaDigitos($_REQUEST['idademin']);
        $this->ativo = $_REQUEST['ativo'];
        $this->save();
              
        
    }
	
	function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        if ($this -> delete($this -> id)){
            $_SESSION['fmj.mensagem'] = 59;
        }else
            $_SESSION['fmj.mensagem'] = 17;
        
    }
}
?>