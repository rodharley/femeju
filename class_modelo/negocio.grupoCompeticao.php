<?php
class GrupoCompeticao extends Persistencia {
    const TABELA = "fmj_grupo_competicao";
    var $graduacao = NULL;
    var $categoria =  NULL;
    var $classe = NULL;    
	var $competicao = NULL;
    var $valor;
    var $dobra;
  
     
      public function listar($idCompeticao,$idGraduacao ="",$idCategoria = "", $idClasse =""){
          $sql = "select * from ".$this::TABELA." where idCompeticao=".$idCompeticao;
          $group = " group by idGraduacao";
          if($idGraduacao != ""){
            $sql .= " and idGraduacao = ".$idGraduacao;
            $group .= " ,idCategoria ";
          }  
         if($idCategoria != ""){
            $sql .= " and idCategoria = ".$idCategoria;
            $group .= " ,idClasse";
         }
         if($idClasse != ""){
            $sql .= " and idClasse = ".$idClasse;
            
         }
         $sql = $sql.$group;
         return $this->getSQL($sql);
    }
     
     
}
?>