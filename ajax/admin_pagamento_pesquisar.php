<?php
$menu = 32;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/pagamento/list.html");
$objPag = new Pagamento();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $objPag->pesquisarTotal($_REQUEST['tipo'],$_REQUEST['responsavel'],$objPag->convdata($_REQUEST['dataVencimento'],"ntm"));
$configPaginacao = $objPag->paginar($totalPesquisa,$pagina);
$alist = $objPag->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['tipo'],$_REQUEST['responsavel'],$_REQUEST['dataVencimento']);
if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->valor = $objPag->money($n->valorTotal,"atb");
    $TPL->situacao = $n->bitPago == 1 ? "Pago" : "Em aberto";
    $TPL->colorSituacao = $n->bitPago == 1 ? "success" : "danger";
    $TPL->responsavel = $n->responsavel->pessoa->nome;
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
