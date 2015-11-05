<?php
class GrupoCompeticao extends Persistencia {
    var $graduacao = NULL;
    var $categoria =  NULL;
    var $classe = NULL;    
	var $competicao = NULL;
    var $valor;
    var $dobra;
  
     
      public function listar($idCompeticao,$idGraduacao ="",$idCategoria = "", $idClasse =""){
          $arrayFiltro = array();
          $arrayFiltro['competicao'] = "=".$idCompeticao;
          if($idGraduacao != "")
            $arrayFiltro['graduacao'] = "=".$idGraduacao;
         if($idCategoria != "")
            $arrayFiltro['categoria'] = "=".$idCategoria;
         if($idClasse != "")
            $arrayFiltro['classe'] = "=".$idClasse;
        return $this->getRows(0,999,array(),$arrayFiltro);
    }
     
     
}
?>