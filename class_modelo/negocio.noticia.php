<?php
class Noticia extends Persistencia{
	var $titulo;
	var $texto;
    var $foto;
    var $data;	
    
    
    function pesquisarTotal($titulo = "",$texto = "",$periodo ="") {
                $sql = "select count(id) as total from fmj_noticia where 1 = 1";
        
        if ($titulo != "")
            $sql .= " and titulo like '%$titulo%'";
        
        if ($texto != "")
            $sql .= " and texto like '%$texto%'";
        
        if($periodo != ""){
            $arrayData = explode("-", str_replace(" ", "",$periodo));
            $sql .= " and data between '".$this->convdata($arrayData[0],"ntm")." 00:00:00' and '".$this->convdata($arrayData[1],"ntm")." 23:59:59' ";
        }
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }
    
    function pesquisar($primeiro = 0, $quantidade = 9999, $titulo = "",$texto = "",$periodo ="") {

        $sql = "select * from fmj_noticia where 1 = 1";
        
        if ($titulo != "")
            $sql .= " and titulo like '%$titulo%'";
        
        if ($texto != "")
            $sql .= " and texto like '%$texto%'";
        
        if($periodo != ""){
            $arrayData = explode("-", str_replace(" ", "",$periodo));
            $sql .= " and data between '".$this->convdata($arrayData[0],"ntm")." 00:00:00' and '".$this->convdata($arrayData[1],"ntm")." 23:59:59' ";
        }
        
        $sql .= "  order by data limit $primeiro, $quantidade";
        return $this -> getSQL($sql);

    }
}
?>