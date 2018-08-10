<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout_inscricao.html");
include("includes/include.mensagem.php");

$obj = new Pagamento();
$obItem = new PagamentoItem();
$grupo = new GrupoCusta();
$objA = new Atleta();
$objC = new Custa();
$objAn = new Anuidade();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/pagamento/guia.html");
$obj->getById($obj->md5_decrypt($_REQUEST['id']));
//$TPL->ID_HASH = $obj->md5_encrypt($obj->id);
$TPL->TIPO_CUSTA = $grupo->getDescricao($obj->grupo);
$TPL->RESPONSAVEL = $obj->nomeSacado;
$TPL->VALOR_TOTAL = "R$ ".$obj->money($obj->valorTotal,"atb");
$TPL->DATA_VENC = $obj->convdata($obj->dataVencimento, "mtn");
$TPL->IMG_TIPO = $obj->tipo->imagem;
$TPL->DESC_TIPO = $obj->tipo->descricao;
$TPL->DESCRICAO = $obj->descricao; 
$TPL->DATA_PAGAMENTO = $obj->convdata($obj->dataPagamento, "mtn");
$TPL->CONTROLE = $obj->controle;
if($obj->bitPago == 1 ) { 
    $TPL->SITUACAO = "Pago";
	$TPL->COLOR_SITUACAO = "success";
	if($obj->tipo->id < 3){
	$TPL->block("BLOCK_RECIBO");
	}
	}else if ($obj->bitPago == 0){
	$TPL->SITUACAO = "Em aberto";
	$TPL->COLOR_SITUACAO = "warning";
	if($obj->bitResolvido == 1){
 		$TPL->block("BLOCK_PAGAR");
	}else{
		$TPL->block("BLOCK_AGUARDE");
	}   
	
	}else {
	$TPL->SITUACAO = "Cancelado";
	$TPL->COLOR_SITUACAO = "danger";
	} 

if($obj->tipo->id == 3){
	$TPL->URL_PAGAMENTO = 'admin_pagamento-'.$obj->tipo->arquivo.'?id='.$obj->md5_encrypt($obj->id);
	$TPL->PAYPAL_TRANSACTION_ID = $obj->numeroFebraban;
	$status = explode("-", $obj->codigo);
	if(count($status) > 1){
	$TPL->PAYPAL_STATUS = $status[0];
	$TPL->PAY_PAL_DESCRICAO = $status[1];
	}
	$TPL->block('BLOCK_PAYPAL');
	} else if($obj->tipo->id == 2){
		$TPL->URL_PAGAMENTO = 'admin_pagamento-'.$obj->tipo->arquivo.'?id='.$obj->md5_encrypt($obj->id);
		$TPL->INFO_AD = $obj->numeroFebraban;
		$TPL->block("BLOCK_INFO_AD");
	}else{
		$TPL->URL_PAGAMENTO = $obj->gnUrlBoleto;
	}




$rsItens = $obItem->getRows(0,9999,array(),array("pagamento"=>"=".$obj->id));    

foreach ($rsItens as $key => $item) {
    $TPL->DESC_ITEM = $item->descricaoItem;
    $TPL->CUSTA_ITEM = $item->custa->titulo;
    $TPL->VALOR_ITEM = "R$ ".$obj->money($item->valor,"atb");
    $TPL->block("BLOCK_ITEM");
}


$TPL->show();
?>