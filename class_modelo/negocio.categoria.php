<?php
class CategoriaPeso extends Persistencia {
    var $descricao;
    var $maximo;
    var $minimo;
    var $ativo; 
    var $classe;
	var $genero;

function listaAtivasPorClasse($idClasse){
	return $this->getRows(0,999,array("descricao"=>"ASC"),array("ativo"=>"=1","classe"=>"=".$idClasse));
}
function listaAtivasPorClasseGenero($idClasse,$genero){
	return $this->getRows(0,999,array("descricao"=>"ASC"),array("genero"=>"='".$genero."'", "ativo"=>"=1","classe"=>"=".$idClasse));
}
	function Incluir() {     
        $this -> descricao = $_REQUEST['descricao'];
        $this -> maximo = $this->limpaDigitos($_REQUEST['pesomax']);
        $this -> minimo = $this->limpaDigitos($_REQUEST['pesomin']);
		$this -> genero = $_REQUEST['genero'];
        $this->ativo = $_REQUEST['ativo'];
        $this->classe = new Classe($_REQUEST['idClasse']);
        $this->save();      
        
    }
    
	function Alterar() {
		$this-> getById($_REQUEST['id']);     
        $this -> descricao = $_REQUEST['descricao'];
		$this -> genero = $_REQUEST['genero'];
        $this -> maximo = $this->limpaDigitos($_REQUEST['pesomax']);
        $this -> minimo = $this->limpaDigitos($_REQUEST['pesomin']);
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