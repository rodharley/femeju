<?php
include("configuraAjaxSemLogin.php");
$TPL = new Template("../templates/portal/associacao/main.html");
$assoc = new Associacao();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $assoc->pesquisarTotal($_REQUEST['nome'],"",1);
$configPaginacao = $assoc->paginar($totalPesquisa,$pagina);
$alist = $assoc->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],utf8_decode($_REQUEST['nome']),"",1);

if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->NOME = $n->nome;
	$TPL->DESCRICAO = $n->descricao;
    $TPL->CNPJ = $n->cnpj;
    $TPL->LOGOTIPO = $n->logomarca != "" ? $n->logomarca : "nologo.png";
        
    
    $TPL->ID_HASH = $assoc->md5_encrypt($n->id);
    $TPL->block("BLOCK_ITEM_LISTA");
    
}
}
$TPL->NOME_P = utf8_decode($_REQUEST['nome']);
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

