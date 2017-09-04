<?php
class DespesaGrupo extends Persistencia{
	const TABELA = "fmj_despesa_grupo";    
        
	var $descricao;	
    var $dataInicio;
	var $parcelas;
    var $valor;    
    var $usuario = null;
    
    
function pesquisarTotal($descricao = "",$responsavel = "",$dataVencimento = "") {
        $sql = "select DISTINCT p.id from ".$this::TABELA." p inner join ".Pessoa::TABELA." u on u.id = p.idUsuario inner join ".Despesa::TABELA." d on d.idGrupo = p.id where 1 = 1 ";
        if ($descricao != "")
            $sql .= " and ( p.descricao like '%$descricao%')"; 
        if ($responsavel != "")
            $sql .= " and concat(u.nome,' ', u.nomeMeio,' ', u.sobrenome) like '%$responsavel%'";
        if ($dataVencimento != "")
            $sql .= " and ('$dataVencimento' = d.data)";

        $rs = $this -> DAO_ExecutarQuery($sql);
        return $this -> DAO_NumeroLinhas($rs);
    }

function pesquisar($primeiro = 0, $quantidade = 9999, $descricao = "",$responsavel = "",$dataVencimento = "") {

        $sql = "select DISTINCT p.* from ".$this::TABELA." p inner join ".Pessoa::TABELA." u on u.id = p.idUsuario inner join ".Despesa::TABELA." d on d.idGrupo = p.id where 1 = 1 ";
        
        if ($descricao != "")
            $sql .= " and ( p.descricao like '%$descricao%')"; 
        if ($responsavel != "")
            $sql .= " and concat(u.nome,' ', u.nomeMeio,' ', u.sobrenome) like '%$responsavel%'";
        if ($dataVencimento != "")
            $sql .= " and ('$dataVencimento' = d.data)";
        $sql .= "  order by p.id desc limit $primeiro, $quantidade"; 
             
        return $this -> getSQL($sql);

    }
    
    function excluir($id){
    	$this->delete($id);
		$_SESSION['fmj.mensagem'] = 79;
    }
    
  function lancar(){
  	$this->descricao = $_REQUEST['descricao'];
	$this->valor = $this->money($_REQUEST['valor'], "bta");
	$this->dataInicio = $this->convdata($_REQUEST['dataInicio'], "ntm");
	$this->parcelas = $this->limpaDigitos($_REQUEST['parcelas']);
	$user =new Usuario();
	$user->id = $_SESSION['fmj.userId'];
	$this->usuario = $user;
	$idGrupo = $this->save();
	
	//registrar os lancamentos mes a mes
	for($i = 0;$i<$this->parcelas;$i++){
		$desp = new Despesa();
		$desp->descricao = $this->descricao;
		$desp->valor = $this->valor;
		$date = new DateTime($this->dataInicio);
		if($i > 0){
		$interval = new DateInterval('P'.$i.'M');
		$date->add($interval);
		}
		$desp->data = $date->format('Y-m-d');
		$desp->parcela = $i+1;
		$desp->grupo = $this;
		$desp->save();		
	}
	$_SESSION['fmj.mensagem'] = 77;
  }
  
  function alterar(){
  	$this->delete($_REQUEST['id']);
  	
  	$this->descricao = $_REQUEST['descricao'];
	$this->valor = $this->money($_REQUEST['valor'], "bta");
	$this->dataInicio = $this->convdata($_REQUEST['dataInicio'], "ntm");
	$this->parcelas = $this->limpaDigitos($_REQUEST['parcelas']);
	$user =new Usuario();
	$user->id = $_SESSION['fmj.userId'];
	$this->usuario = $user;
	$idGrupo = $this->save();
	
	//registrar os lancamentos mes a mes
	for($i = 0;$i<$this->parcelas;$i++){
		$desp = new Despesa();
		$desp->descricao = $this->descricao;
		$desp->valor = $this->valor;
		$date = new DateTime($this->dataInicio);
		if($i > 0){
		$interval = new DateInterval('P'.$i.'M');
		$date->add($interval);
		}
		$desp->data = $date->format('Y-m-d');
		$desp->parcela = $i+1;
		$desp->grupo = $this;
		$desp->save();		
	}
	$_SESSION['fmj.mensagem'] = 78;
  }
}
?>