<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$atleta = new Atleta();
$associacao = new Associacao();

$uf = new Uf();

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/pagamento/meuspagamentos.html");
$objPag = new Pagamento();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $objPag->pesquisarPortalTotal($_SESSION['fmj.userId']);
$configPaginacao = $objPag->paginar($totalPesquisa,$pagina);
$alist = $objPag->pesquisarPortal($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_SESSION['fmj.userId']);
if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->valor = $objPag->money($n->valorTotal,"atb");
    if($n->bitPago == 1)  
    $TPL->situacao = "Pago";
	else if ($n->bitPago == 0)
	$TPL->situacao = "Em aberto";
	else {
	$TPL->situacao = "Cancelado";
	} 
	if($n->bitPago == 1)  
    $TPL->colorSituacao = "success";
	else if ($n->bitPago == 0)
	$TPL->colorSituacao = "warning";
	else {
	$TPL->colorSituacao = "danger";
	} 
    $TPL->DATA_VENC = $objPag->convdata($n->dataVencimento, "mtn");
    $TPL->ID_HASH = $objPag->md5_encrypt($n->id);
    $TPL->block("BLOCK_ITEM_LISTA");
    
}
}

$TPL->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$TPL->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$TPL->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$TPL->PAGINA = $pagina;
if($configPaginacao['totalPaginas'] > 1){
$TPL->block("BLOCK_PAGINACAO");
}
$TPL->show();
?>