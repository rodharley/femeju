<?php
class Competicao extends Persistencia {
     const TABELA = "fmj_competicao";
    var $descricao;
    var $titulo;
    var $dataEvento;    
	var $inscricaoAberta;
    var $ativo;
    var $tipo;
    
    public function Incluir(){
        $this->descricao = $_REQUEST['descricao'];
        $this->tipo = $_REQUEST['tipo'];
        $this->titulo = $_REQUEST['titulo'];
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->inscricaoAberta = 0;
        return $this->save();
        
    }
    
     public function Alterar(){
         $this->getById($_REQUEST['id']);
        $this->descricao = $_REQUEST['descricao'];
        $this->tipo = $_REQUEST['tipo'];
        $this->titulo = $_REQUEST['titulo'];
        $this->dataEvento = $this->convdata($_REQUEST['dataEvento'], "ntm");
        $this->inscricaoAberta = $_REQUEST['inscricao'];
        $this->ativo = $_REQUEST['ativo'];
        return $this->save();
        
    }
     
     public function IncluirCategoria(){
         $grupo = new GrupoCompeticao();
         $grupo->competicao = new Competicao($_REQUEST['idCompeticao']);
         $grupo->classe = new Classe($_REQUEST['classe']);
         $grupo->graduacao = new Graduacao($_REQUEST['graduacao']);
         $grupo->categoria = new Classe($_REQUEST['categoria']);
         $grupo->valor = $this->money($_REQUEST['valor'], "bta");
         $grupo->save();
         
     }
     public function AlterarCategoria(){
         $grupo = new GrupoCompeticao();
         $grupo->getById($_REQUEST['idGrupo']);
         $grupo->competicao = new Competicao($_REQUEST['idCompeticao']);
         $grupo->classe = new Classe($_REQUEST['classe']);
         $grupo->graduacao = new Graduacao($_REQUEST['graduacao']);
         $grupo->categoria = new Classe($_REQUEST['categoria']);
         $grupo->valor = $this->money($_REQUEST['valor'], "bta");
         $grupo->save();
         
     }
     
     public function ExcluirCategoria(){
         $grupo = new GrupoCompeticao();
         if(!$grupo->delete($this->md5_decrypt($_REQUEST['id'])))
            echo "Não é possível excluir esse registro pois o mesmo contém dados no sistema que não podem ser excluídos.";
         
     }
    
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
}
?>