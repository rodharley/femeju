<?php
class Galeria extends Persistencia{
	var $titulo;
	var $data;
    
    function Incluir() {
        $this -> titulo = utf8_decode($_REQUEST['titulo']);
        $this -> data = $this->convdata($_REQUEST['data'],"ntm");
        $this -> save();
    }

    function Alterar() {
        $this -> getById($_REQUEST['id']);
        $this -> titulo = utf8_decode($_REQUEST['titulo']);
        $this -> data = $this->convdata($_REQUEST['data'],"ntm");
        $this -> save();
    }
    
    function Excluir($id) {
        $this -> getById($this -> md5_decrypt($id));
        
        $img = new GaleriaImagem();
        $rsimg = $img->getRows(0,999,array(),array("galeria"=>"=".$this->id));
        foreach ($rsimg as $key => $imagem) {
            $img->ExcluirImagem($imagem->id);
        }
        $this->delete($this->id);
         $_SESSION['fmj.mensagem'] = 32;
        header("Location:admin_galeria-main");
        
    }
    
    function listarArrayAnos(){
        $SQL = "select Year(data) as ano from fmj_galeria group by Year(data) order by ano desc";
        $rs = $this->DAO_ExecutarQuery($SQL);
        $arrayItens = array();
                if($this->DAO_NumeroLinhas($rs) > 0){
                    while($arrayItem = $this->DAO_GerarArray($rs)){
                        array_push($arrayItens,$arrayItem['ano']);
                    }
                }
         return $arrayItens;
    }
    
    function listar3PortalTotal($ano = ""){
        $sql = "select count(*) as total from fmj_galeria";
        if($ano == "")
            $ano = Date("Y");
        $sql .= " where Year(data) = ".$ano;
        
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }
    
    function listar3Portal($primeiro = 0, $quantidade = 9999,$ano = ""){
        $sql = "select * from fmj_galeria"; 
        if($ano == "")
            $ano = Date("Y");
        $sql .= " where Year(data) = ".$ano;
        
        $sql .= " order by data desc limit $primeiro, $quantidade";
        return $this->getSQL($sql);
    }
    
    
    
     function pesquisarTotal($titulo = "", $periodo = "") {
        $sql = "select count(id) as total from fmj_galeria where 1 = 1";

        if ($titulo != "")
            $sql .= " and titulo like '%$titulo%'";

        if ($periodo != "") {
            $arrayData = explode("-", str_replace(" ", "", $periodo));
            $sql .= " and data between '" . $this -> convdata($arrayData[0], "ntm") . " 00:00:00' and '" . $this -> convdata($arrayData[1], "ntm") . " 23:59:59' ";
        }
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $titulo = "", $periodo = "") {

        $sql = "select * from fmj_galeria where 1 = 1";

        if ($titulo != "")
            $sql .= " and titulo like '%$titulo%'";

        if ($periodo != "") {
            $arrayData = explode("-", str_replace(" ", "", $periodo));
            $sql .= " and data between '" . $this -> convdata($arrayData[0], "ntm") . " 00:00:00' and '" . $this -> convdata($arrayData[1], "ntm") . " 23:59:59' ";
        }

        $sql .= "  order by data desc limit $primeiro, $quantidade";
        return $this -> getSQL($sql);

    }
}
?>