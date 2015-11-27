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
    var $grupo;
    var $descricao;
    var $nomeSacado;
    var $cpfSacado;
    var $enderecoSacado;
    var $bairroSacado;
    var $cidadeSacado;
    var $ufSacado;
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
    
    public function gerarPagamento($grupo,$tipoPagamento,$dataVencimento,$arrayResponsavel,$descricao, $itensPagamento){
        $total = 0;
        foreach ($itensPagamento as $key => $item) {
            $total += $item->valor;
        }    
        $this->valorTotal = $total;
        $this->dataVencimento = $dataVencimento;
        
        if($total <= 0){
            $this->bitPago = 1;
            $this->dataPagamento = date("Y-m-d");
        }else{
            $this->bitPago = 0;
            $this->dataPagamento = NULL;
        }
        $this->grupo = $grupo;
        $this->descricao = $descricao;
        $this->nomeSacado = $arrayResponsavel['nome'];
        $this->cpfSacado = $arrayResponsavel['cpf'];
        $this->enderecoSacado = $arrayResponsavel['endereco'];
        $this->bairroSacado = $arrayResponsavel['bairro'];
        $this->cidadeSacado = $arrayResponsavel['cidade'];
        $this->ufSacado = $arrayResponsavel['uf'];        
        $this->tipo = new PagamentoTipo($tipoPagamento);
        $this->save();
        
        foreach ($itensPagamento as $key => $item) {
         $item->pagamento = $this;
         $item->save();
             
        }
        return $this->id;
    }
    
    function pesquisarTotal($grupo = "",$responsavel = "",$dataVencimento = "") {
        $sql = "select count(p.id) as total from ".$this::TABELA." p  where 1 = 1 ";
        if($grupo != "")
            $sql .= " and p.idGrupo = $grupo"; 
        if ($responsavel != "")
            $sql .= " and ( p.nomeSacado like '%$responsavel%')";
        if ($dataVencimento != "")
            $sql .= " and ( p.dataVencimento =  '%$dataVencimento%')";
        
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

 function pesquisarPortalTotal($idResponsavel) {
        $sql = "select count(p.id) as total from ".$this::TABELA." p inner join ".Pessoa::TABELA." pe on pe.cpf = p.cpfSacadp where pe.id = $idResponsavel";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
        
    }
 
 function pesquisarPortal($primeiro = 0, $quantidade = 9999, $idResponsavel) {
        $sql = "select p.* from ".$this::TABELA." p inner join ".Pessoa::TABELA." pe on pe.cpf = p.cpfSacadp where pe.id = $idResponsavel";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> getSQL($sql);
    }
    function pesquisar($primeiro = 0, $quantidade = 9999, $grupo = "",$responsavel = "",$dataVencimento = "") {

        $sql = "select p.* from ".$this::TABELA." p where 1 = 1 ";
        
        if($grupo != "")
            $sql .= " and idGrupo = $grupo"; 
        if ($responsavel != "")
            $sql .= " and ( p.nomeSacado like '%$responsavel%')";
        if ($dataVencimento != "")
            $sql .= " and ( p.dataVencimento =  '%$dataVencimento%')";
        
        
        $sql .= "  order by p.id desc limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
}
?>