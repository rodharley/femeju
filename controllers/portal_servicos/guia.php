<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
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
$TPL->ID_HASH = $obj->md5_encrypt($obj->id);
$TPL->TIPO_CUSTA = $grupo->getDescricao($obj->grupo);
$TPL->RESPONSAVEL = $obj->nomeSacado;
$TPL->VALOR_TOTAL = "R$ ".$obj->money($obj->valorTotal,"atb");
$TPL->DATA_VENC = $obj->convdata($obj->dataVencimento, "mtn");
$TPL->IMG_TIPO = $obj->tipo->imagem;
$TPL->DESC_TIPO = $obj->tipo->descricao;
$TPL->DATA_PAGAMENTO = $obj->convdata($obj->dataPagamento, "mtn");
$TPL->SITUACAO = $obj->bitPago == 1 ? "Pago" : "Em aberto";
$TPL->COLOR_SITUACAO = $obj->bitPago == 1 ? "success" : "danger";

//boleto
$TPL->TIPO_PAG_ARQUIVO = $obj->tipo->arquivo;

$rsItens = $obItem->getRows(0,9999,array(),array("pagamento"=>"=".$obj->id));    

foreach ($rsItens as $key => $item) {
    $TPL->DESC_ITEM = $item->descricaoItem;
    $TPL->CUSTA_ITEM = $item->custa->descricao;
    $TPL->VALOR_ITEM = "R$ ".$obj->money($item->valor,"atb");
    $TPL->block("BLOCK_ITEM");
}
if($obj->bitPago == 0){
 $TPL->block("BLOCK_PAGAR");   
}

$TPL->show();
?>