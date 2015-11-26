<?php
$menu = 33;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/pagamento/itensCusta.html");
$obj = new Custa();
$grupo = new GrupoCusta();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$ativo = isset($_REQUEST['ativo']) ? $_REQUEST['ativo'] : 1;
$totalPesquisa = $obj->pesquisarTotal($ativo);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$ativo);

if (count($alist) > 0) {
$json = "";

foreach($alist as $key => $n){
    $TPL->disabled = "";
    $TPL->GRUPO = $grupo->getDescricao($n->grupo);
    $TPL->TITULO = $n->titulo;
    $TPL->DESCRICAO = $n->descricao;
    if($n->id == Custa::ANUIDADE_PADRAO)
        $TPL->disabled = "disabled";
    $TPL->VALOR = "R$ ".$obj->money($n->valor,"atb");
    $json .= json_encode($obj->objectToArray($n)).",";
    $TPL->ID_HASH = $obj->md5_encrypt($n->id);
    $TPL->KEY = $key;
    $TPL->block("BLOCK_ITEM");
    
}
 $TPL->JSON = substr($json, 0,strlen($json)-1);
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

