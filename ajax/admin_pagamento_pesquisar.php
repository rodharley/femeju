<?php
$menu = 32;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/pagamento/list.html");
$objPag = new Pagamento();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $objPag->pesquisarTotal($_REQUEST['tipo'],$_REQUEST['responsavel'],$objPag->convdata($_REQUEST['dataVencimento'],"ntm"),$_REQUEST['codigo'],$_REQUEST['status']);
$configPaginacao = $objPag->paginar($totalPesquisa,$pagina);
$alist = $objPag->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['tipo'],$_REQUEST['responsavel'],$objPag->convdata($_REQUEST['dataVencimento'],"ntm"),$_REQUEST['codigo'],$_REQUEST['status']);
if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->valor = $objPag->money($n->valorTotal,"atb");
    $TPL->situacao = $n->bitPago == 1 ? "Pago" : "Em aberto";
	$TPL->especial = $n->bitEspecial == 1 ? "Sim" : "Não";
	$TPL->colorEspecial = $n->bitEspecial == 1 ? $n->bitResolvido ? "success" : "danger" : "default";
    $TPL->colorSituacao = $n->bitPago == 1 ? "success" : "danger";
    $TPL->DISABLED = $n->bitPago == 1 ? "disabled" : "";
    $TPL->responsavel = $n->nomeSacado;
	$TPL->codigo = $n->numeroFebraban;
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

exit();
?>

