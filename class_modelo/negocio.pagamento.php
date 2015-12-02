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
        if($this->bitPago == 0){
        if ($this -> delete($this -> id)){
            $log = new Log();
            $log->gerarLog("Exclusão de Pagamento");
            $_SESSION['fmj.mensagem'] = 53;            
        }else
            $_SESSION['fmj.mensagem'] = 17;
        }else{
            $_SESSION['fmj.mensagem'] = 17;
        }
        
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
    
    function pesquisarTotal($grupo = "",$responsavel = "",$dataVencimento = "",$codigo="") {
        $sql = "select count(p.id) as total from ".$this::TABELA." p  where 1 = 1 ";
        if($grupo != "")
            $sql .= " and p.idGrupo = $grupo"; 
        if ($responsavel != "")
            $sql .= " and ( p.nomeSacado like '%$responsavel%')";
        if ($dataVencimento != "")
            $sql .= " and ( p.dataVencimento =  '$dataVencimento')";
        if ($codigo != "")
            $sql .= " and ( p.numeroFebraban =  '$codigo' or p.codigo = '$codigo')";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
    }

 function pesquisarPortalTotal($idResponsavel) {
        $sql = "select count(p.id) as total from ".$this::TABELA." p inner join ".Pessoa::TABELA." pe on pe.cpf = p.cpfSacado where pe.id = $idResponsavel";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_Result($rs, "total", 0);
        
    }
 
 function pesquisarPortal($primeiro = 0, $quantidade = 9999, $idResponsavel) {
        $sql = "select p.* from ".$this::TABELA." p inner join ".Pessoa::TABELA." pe on pe.cpf = p.cpfSacado where pe.id = $idResponsavel";
        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> getSQL($sql);
    }
    function pesquisar($primeiro = 0, $quantidade = 9999, $grupo = "",$responsavel = "",$dataVencimento = "",$codigo="") {

        $sql = "select p.* from ".$this::TABELA." p where 1 = 1 ";
        
        if($grupo != "")
            $sql .= " and idGrupo = $grupo"; 
        if ($responsavel != "")
            $sql .= " and ( p.nomeSacado like '%$responsavel%')";
        if ($dataVencimento != "")
            $sql .= " and ( p.dataVencimento =  '$dataVencimento')";
        if ($codigo != "")
            $sql .= " and ( p.numeroFebraban =  '$codigo' or p.codigo = '$codigo')";
        
        $sql .= "  order by p.id desc limit $primeiro, $quantidade";        
        return $this -> getSQL($sql);

    }
	
	public function gerarPagamentoOutros($itens)
   {
            
            $grupoC = new GrupoCompeticao();
            $pag = new Pagamento();
            $itensPagamento = array();
            $custa = new Custa();
            $cidade = new Cidade();
            $cidade->getById($_REQUEST['cidade']);
			$dataPag = $this->convdata($_REQUEST['data'], "ntm");
			
             foreach ($itens as $key => $i) {                
                //gera o item de pagamento
                $item = new PagamentoItem();  
                $item->atleta = NULL;
                //soma o valor total
                $custa->getById($i['custa']);
                $total = $custa->valor;
                $item->valor = $total; 
                $item->custa = $custa;
                $item->descricaoItem = utf8_decode($i['descricao']);   
                array_push($itensPagamento,$item);        
                }
				$arrayResp = array();
	            $arrayResp['nome'] = $_REQUEST['nomeSacado'];
	            $arrayResp['cpf'] = $this->limpaDigitos($_REQUEST['cpfcnpj']);
	            $arrayResp['endereco'] = $_REQUEST['endereco'];
	            $arrayResp['bairro'] = $_REQUEST['bairro'];
	            $arrayResp['cidade'] = $cidade->nome;
	            $arrayResp['uf'] = $cidade->uf->uf;                
 
                $idPagamento = $pag->gerarPagamento(GrupoCusta::OUTROS,$_REQUEST['tipoPagamento'],$dataPag,$arrayResp,$_REQUEST['descricao'],$itensPagamento);
                return $idPagamento;
                 }

                function baixaPagamento($idPagamento){
                    $this->getById($idPagamento);
                    $this->dataPagamento = $this->convdata($_REQUEST['dataPagamento'], "ntm");
                    $this->bitPago = 1;
                    $this->save();
                    switch ($this->grupo) {
                        case GrupoCusta::COMPETICAO:
                            $isncr = new Inscricao();
                            $isncr->atualizarInscricoes($this->id);
                            break;
                        case GrupoCusta::ANUIDADE:
                            $anu = new Anuidade();
                            $anu->atualizarAnuidadePorPagamento($this->id);
                            break;
                        default:
                            
                            break;
                    }
                    
                    //grava a log
                    $log = new Log();
                    $log->gerarLog("Baixa no pagamento de número : ".$this->codigo);
                    
                }
}
?>