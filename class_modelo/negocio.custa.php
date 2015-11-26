<?php
class Custa extends Persistencia{
    const TABELA = "fmj_custas";
    const ANUIDADE_PADRAO = "1";
	var $descricao;
    var $titulo;    
	var $valor;
    var $ativo;
	var $grupo = NULL;

	
	function pesquisarTotal($ativo = "") {
        $sql = "select count(id) as total from ".$this::TABELA." where 1 = 1 ";
        if($ativo != "")
            $sql .= " and bitAtivo = $ativo"; 
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

    function pesquisar($primeiro = 0, $quantidade = 9999, $ativo = "") {

        $sql = "select * from ".$this::TABELA." where 1 = 1 ";
        
        if($ativo != "")
            $sql .= " and bitAtivo = $ativo";
        
        $sql .= "  order by titulo, descricao limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
    function incluir(){
        $this->descricao = utf8_decode($_REQUEST['descricao']);
        $this->titulo = utf8_decode($_REQUEST['titulo']);
        $this->grupo = $_REQUEST['grupo'];
        $this->valor = $this->money($_REQUEST['valor'], "bta");
        $this->ativo = $_REQUEST['situacao'];
        $this->save();
    }
    function alterar(){
        $this->getById($_REQUEST['idCusta']);
        $this->descricao = utf8_decode($_REQUEST['descricao']);
        $this->titulo = utf8_decode($_REQUEST['titulo']);
        $this->grupo = $_REQUEST['grupo'];
        $this->valor = $this->money($_REQUEST['valor'], "bta");
        $this->ativo = $_REQUEST['situacao'];
        $this->save();
    }
    
    function excluir($id){
        $this->getById($this->md5_decrypt($id));
        if (!$this -> delete($this -> id)){
            echo "Não é possível excluir esse registro pois o mesmo contém dados no sistema que não podem ser excluídos.";
        }
            
    }
}
?>