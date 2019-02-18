<?php
$menu = 0;
include("includes/include.lock.php");
$TPL = NEW Template("templates/portal/layout_inscricao.html");

$pagamento = new Pagamento();
$obItem = new PagamentoItem();
$pagamento->getById($pagamento->md5_decrypt($_REQUEST['id']));
$descricaoPagamento = $pagamento->descricao."<br/>";
$grupo = new GrupoCusta();
	$TPL->addFile("CONTEUDO", "templates/portal/pagamento/guiaFemeju.html");
	

	if($pagamento->bitPago == 1){
		$TPL->TIPO = "Recibo";
		$TPL->block("BLOCK_RECEBEMOS");
		}else{
		$TPL->TIPO = "Guia";
		}
		
	
		$TPL->CONTROLE = $pagamento->controle;
		$TPL->DESCRICAO = $descricaoPagamento;
		$TPL->TIPO_CUSTA = $grupo->getDescricao($pagamento->grupo);
		$TPL->RESPONSAVEL = $pagamento->nomeSacado;
		$TPL->RECEBEMOS = $pagamento->nomeSacado;
		$TPL->DATA_VENC = $pagamento->convdata($pagamento->dataVencimento, "mtn");
		$TPL->VALOR_TOTAL = "R$ ".$pagamento->money($pagamento->valorTotal,"atb");
		$rsItens = $obItem->getRows(0,9999,array(),array("pagamento"=>"=".$pagamento->id));    
		foreach ($rsItens as $key => $item) {    
	   $TPL->DESC_ITEM = $item->descricaoItem;
		$TPL->CUSTA_ITEM = $item->custa->titulo;
		$TPL->VALOR_ITEM = "R$ ".$pagamento->money($item->valor,"atb");
		$TPL->block("BLOCK_ITEM");	
		}
	


	
	
$TPL->show();