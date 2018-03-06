<?php
class Graduacao extends Persistencia {
    var $descricao;
    var $faixa;
    var $imagem;
    var $idadeMin;
    var $carenciaMin;  
	var $ordem;
	var $bitAtivo; 

function listaAtivas(){
	return $this->getRows(0,999,array("ordem"=>"ASC"),array("bitAtivo"=>"=1"));
}

function listaClasses(){
	$obj = new ClasseGraduacao();
	return $obj->getRows(0,999,array("classe"=>"ASC"),array("graduacao"=>"=".$this->id));
}
	function Incluir() {     
        $this -> descricao = $_REQUEST['descricao'];
        $this -> faixa = $_REQUEST['faixa'];
        $this->bitAtivo = $_REQUEST['ativo'];
        $this->imagem = $_REQUEST['cor'];
        $this->idadeMin = $_REQUEST['idadeMin'];
        $this->carenciaMin = $_REQUEST['carencia'];
        $this->ordem = $_REQUEST['ordem'];
        $id = $this->save();      
		if(isset($_REQUEST['classe'])){
			foreach ($_REQUEST['classe'] as $key => $value) {
				$this->insereClasse($value);				
			}
		}
        
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
		//apaga as categorias
        $this->deletaClasses($this->id);
        if(isset($_REQUEST['classe'])){
        foreach ($_REQUEST['classe'] as $key => $value) {
        $this->insereClasse($value);
        }
        }
        
    }
	
	function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
		$this->deletaClasses($this->id);
        if ($this -> delete($this -> id)){
            $_SESSION['fmj.mensagem'] = 49;
        }else
            $_SESSION['fmj.mensagem'] = 17;
        
    }
	
	function insereClasse($idClasse){
        $objClass = new ClasseGraduacao();
				$objClass->classe = new Classe($idClasse);
				$objClass->graduacao = $this;
				$objClass->save();
    } 
     
     
    function deletaClasses($id){
        $sql = "delete from ".ClasseGraduacao::TABELA." where id_competicao = ".$id;
        $this->DAO_ExecutarDelete($sql);
    }
}
?>