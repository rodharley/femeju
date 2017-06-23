<?php
$menu = 25;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/associacao/list.html");
$objAssociacao = new Associacao();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $objAssociacao->pesquisarTotal($_REQUEST['nome'],$_REQUEST['sigla']);
$configPaginacao = $objAssociacao->paginar($totalPesquisa,$pagina);
$alist = $objAssociacao->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['nome'],$_REQUEST['sigla']);

if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->logo = $n->logomarca != "" ? $n->logomarca : "nologo.png";
    $TPL->nome = $n->nome;
    $TPL->situacao = $n->ativo == 1 ? "Ativo" : "Inativo";
    $TPL->colorSituacao = $n->ativo == 1 ? "success" : "danger";
    $TPL->responsavel = $n->responsavel->pessoa->nome;
    $TPL->ID_HASH = $objAssociacao->md5_encrypt($n->id);
    $TPL->block("BLOCK_ITEM_LISTA");
    
}
}

$TPL->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$TPL->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$TPL->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$TPL->PAGINA = $pagina;
if($configPaginacao['totalPaginas'] > 1){
$TPL->block("BLOCK_PAGINACAO2");	
$TPL->block("BLOCK_PAGINACAO");
}
$TPL->show();

exit();
?>

