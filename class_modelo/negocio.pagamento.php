<?php
class Pagamento extends Persistencia{
	const TABELA = "fmj_pagamento";    
        
	var $valorTotal;	
    var $dataVencimento;
    var $dataPagamento;
    var $bitPago;  
    var $codigo; 
    var $numeroFebraban;       
    var $tipo = NULL;
    var $responsavel = NULL;
    var $grupo;
    var $itens = array();
    public function excluir($id){
        $this->getById($this->md5_decrypt($id));        
        if ($this -> delete($this -> id)){
            $log = new Log();
            $log->gerarLog("Exclusão de Pagamento");
            $_SESSION['fmj.mensagem'] = 53;            
        }else
            $_SESSION['fmj.mensagem'] = 17;
        
    }
    
    public function gerarPagamento($grupo,$tipoPagamento,$dataVencimento,$usuarioResponsavel,$itensPagamento){
        $total = 0;
        foreach ($itensPagamento as $key => $item) {
            $total += $item->valor;
        }    
        $this->valorTotal = $total;
        $this->dataVencimento = $dataVencimento;
        $this->dataPagamento = NULL;
        $this->bitPago = 0;
        $this->grupo = $grupo;
        $this->responsavel = new Usuario($usuarioResponsavel);
        $this->tipo = new PagamentoTipo($tipoPagamento);
        $this->save();
        
        foreach ($itensPagamento as $key => $item) {
         $item->pagamento = $this;
         $item->save();
             
        }
        return $this->id;
    }
    
    function pesquisarTotal($grupo = "",$responsavel = "",$dataVencimento = "") {
        $sql = "select count(p.id) as total from ".$this::TABELA." p inner join fmj_usuario u on u.id = p.idResponsavel  inner join fmj_pessoa pe on pe.id = u.idPessoa where 1 = 1 ";
        if($grupo != "")
            $sql .= " and idGrupo = $grupo"; 
        if ($responsavel != "")
            $sql .= " and ( pe.nome like '%$responsavel%' or pe.sobrenome like '%$responsavel%' or pe.nomeMeio like '%$responsavel%')";
        if ($dataVencimento != "")
            $sql .= " and ( p.dataVencimento =  '%$dataVencimento%')";
        
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

 function pesquisarPortalTotal($idResponsavel) {
        $sql = "select count(p.id) as total from ".$this::TABELA." p where p.idResponsavel = $idResponsavel";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
        
    }
 
 function pesquisarPortal($primeiro = 0, $quantidade = 9999, $idResponsavel) {
        $sql = "select p.* from ".$this::TABELA." p where p.idResponsavel = $idResponsavel";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> getSQL($sql);
    }
    function pesquisar($primeiro = 0, $quantidade = 9999, $grupo = "",$responsavel = "",$dataVencimento = "") {

        $sql = "select p.* from ".$this::TABELA." p inner join fmj_usuario u on u.id = p.idResponsavel  inner join fmj_pessoa pe on pe.id = u.idPessoa where 1 = 1 ";
        
        if($grupo != "")
            $sql .= " and idGrupo = $grupo"; 
        if ($responsavel != "")
            $sql .= " and ( pe.nome like '%$responsavel%' or pe.sobrenome like '%$responsavel%' or pe.nomeMeio like '%$responsavel%')";
        if ($dataVencimento != "")
            $sql .= " and ( p.dataVencimento =  '%$dataVencimento%')";
        
        $sql .= "  order by pe.nome limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
}
?>