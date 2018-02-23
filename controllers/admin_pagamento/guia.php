<?php
$menu = 31;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Pagamento();
$obItem = new PagamentoItem();
$grupo = new GrupoCusta();
$objA = new Atleta();
$objC = new Custa();
$objAn = new Anuidade();
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Guia</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pagamento"><i class="fa fa-credit-card"> </i> Pagamento</a></li>
                                         <li class="active">Guia de Pagamento</li>
                                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/admin/pagamento/guia.html");
$obj->getById($obj->md5_decrypt($_REQUEST['id']));
$TPL->ID_HASH = $obj->md5_encrypt($obj->id);
$TPL->TIPO_CUSTA = $grupo->getDescricao($obj->grupo);
$TPL->RESPONSAVEL = $obj->nomeSacado;
$TPL->VALOR_TOTAL = "R$ ".$obj->money($obj->valorTotal,"atb");
$TPL->DATA_VENC = $obj->convdata($obj->dataVencimento, "mtn");
$TPL->IMG_TIPO = $obj->tipo->imagem;
$TPL->DESC_TIPO = $obj->tipo->descricao;
$TPL->DATA_PAGAMENTO = $obj->convdata($obj->dataPagamento, "mtn");
$TPL->DESCRICAO = $obj->descricao; 
$TPL->SITUACAO = $obj->bitPago == 1 ? "Pago" : "Em aberto";
$TPL->COLOR_SITUACAO = $obj->bitPago == 1 ? "success" : "danger";
$TPL->FORMA = $obj->forma;
//boleto
$TPL->TIPO_PAG_ARQUIVO = $obj->tipo->arquivo;

$rsItens = $obItem->getRows(0,9999,array(),array("pagamento"=>"=".$obj->id));    

foreach ($rsItens as $key => $item) {
	$TPL->DESC_ITEM = $item->descricaoItem;
    $TPL->CUSTA_ITEM = $item->custa->titulo;
    $TPL->VALOR_ITEM = $obj->money($item->valor,"atb");
    $TPL->block("BLOCK_ITEM");
}

$armenus = explode(",",$_SESSION['fmj.menu']);
if(in_array(41, $armenus) && $obj->bitPago == 0){
    $TPL->block("BLOCK_BAIXA");
}
if($obj->bitPago == 0){
 $TPL->block("BLOCK_PAGAR");   
}else{
$TPL->block("BLOCK_BOLETO");   	
}

$TPL->show();
?>