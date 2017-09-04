<?php
$menu = 47;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/despesa/list.html");
$obj = new DespesaGrupo();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $obj->pesquisarTotal($_REQUEST['descricao'],$_REQUEST['responsavel'],$obj->convdata($_REQUEST['dataVencimento'],"ntm"));
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['descricao'],$_REQUEST['responsavel'],$obj->convdata($_REQUEST['dataVencimento'],"ntm"));
if (count($alist) > 0) {
foreach($alist as $key => $n){
	$TPL->ID_HASH = $obj->md5_encrypt($n->id);
	$TPL->descricao = $n->descricao;
	$TPL->valor = "R$ ".$obj->money($n->valor,"atb");
	$TPL->data = $obj->convdata($n->dataInicio,"mtn");
	$TPL->parcelas = $n->parcelas;  
	$TPL->responsavel = $n->usuario->pessoa->nome." ".$n->usuario->pessoa->nomeMeio." ".$n->usuario->pessoa->sobrenome;
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

