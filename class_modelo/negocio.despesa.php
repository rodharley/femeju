<?php
class Despesa extends Persistencia{
	const TABELA = "fmj_despesa";    
        
	var $descricao;	
    var $data;
    var $valor;    
	var $parcela;
    var $grupo = null;
    
    
function alteraData($id,$data){
	$this->getById($id);
	$this->data = $this->convdata($data, "ntm");
	$this->save();
	
	}

function alteraValor($id,$valor){
	$this->getById($id);
	$this->valor = $this->money($valor, "bta");
	$this->save();
		
	}

function excluir($id){
	$this->delete($this->md5_decrypt($id));	
	}

function pesquisa($datai,$dataf){
	$sql = "select d.* from ".Despesa::TABELA." d where d.data between '$datai' and '$dataf'";	
	return $this->getSQL($sql);
}
}
?>