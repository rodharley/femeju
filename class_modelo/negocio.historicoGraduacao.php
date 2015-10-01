<?php
class HistoricoGraduacao extends Persistencia {
    var $data;
    var $atleta = NULL;
    var $graduacao =  NULL;
     
	function listaPorAtleta($idAtleta){
	return $this->getRows(0,999,array("data"=>"ASC"),array("atleta"=>"=".$idAtleta));
}

	function Incluir() {     
        $this -> data = $this->convdata($_REQUEST['dataH'],"ntm");
        $this -> atleta = new Atleta($_REQUEST['idAtleta']);
        $this->graduacao = new Graduacao($_REQUEST['graduacao']);
        $this->save();      
        
    }
    
	function Alterar() {
		$this-> getById($_REQUEST['id']);     
        $this -> data = $this->convdata($_REQUEST['dataH'],"ntm");
        $this -> atleta = new Atleta($_REQUEST['idAtleta']);
        $this->graduacao = new Graduacao($_REQUEST['graduacao']);
        $this->save();            
        
    }
	
	function Excluir($id) {
        $this -> delete($this -> md5_decrypt($id));
        
    }
}
?>