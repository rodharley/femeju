<?php
$menu = 27;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/atleta/list.html");
$obj = new Atleta();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $obj->pesquisarTotal($_REQUEST['nome'],$_REQUEST['sigla']);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['nome'],$_REQUEST['sigla']);

if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->FOTO = $n->pessoa->foto != "" ? $n->pessoa->foto : "pessoa.png";
    $TPL->NOME = $n->pessoa->nome." ".$n->pessoa->sobrenome;
    $TPL->SITUACAO = $n->ativo == 1 ? "Ativo" : "Inativo";
    $TPL->COLOR_SITUACAO = $n->ativo == 1 ? "success" : "danger";
    $TPL->ASSOCIACAO = $n->associacao->nome;
    $TPL->ID_HASH = $obj->md5_encrypt($n->id);
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
