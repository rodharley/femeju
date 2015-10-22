<?php
class Ano extends Persistencia{
	var $anoReferencia;
	var $dataVencimento;
    
    function listaAnuidades(){
        return $this->getRows(0,999,array("anoReferencia"=>"desc"));
    }
    
    function getByAno($ano){
        return $this->getRow(array("anoReferencia"=>"= $ano"));
    }
    
}
?>