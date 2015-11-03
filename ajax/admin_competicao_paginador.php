<?php
$menu = 37;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/competicao/itensCompeticao.html");
$obj = new Competicao();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$ativo = isset($_REQUEST['ativo']) ? $_REQUEST['ativo'] : 1;
$totalPesquisa = $obj->pesquisarTotal($ativo);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$ativo);

if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->TITULO = $n->titulo;
    $TPL->DESCRICAO = $n->descricao;
    $TPL->ATIVO = $n->ativo ? "Sim" : "Não";
    $TPL->COLOR_ATIVO = $n->ativo ? "success" : "danger";
    $TPL->INSCRICAO = $n->inscricaoAberta ? "Sim" : "Não";
    $TPL->COLOR_INSCRICAO = $n->inscricaoAberta ? "success" : "danger"; 
    $TPL->DATA = $obj->convdata($n->dataEvento,"mtn");
    $TPL->ID_HASH = $obj->md5_encrypt($n->id);
    $TPL->block("BLOCK_ITEM");
    
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

