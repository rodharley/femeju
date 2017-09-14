<?php
class PagamentoItem extends Persistencia{
	const TABELA = "fmj_pagamento_item";    
	var $valor;
    var $atleta = null;
    var $custa = null;
    var $pagamento = null;
    var $descricaoItem;
	
	function atualizarValorItem($id,$valor){
		$this->getById($id);
		$this->valor= $this->money($valor,"bta");
		$this->save();
		
		$log = new Log();
		$log->gerarLog("Atualização de valor de item de pagamento ".$this->pagamento->nomeSacado.", Atleta: ".$this->descricaoItem);
	}
}
?>