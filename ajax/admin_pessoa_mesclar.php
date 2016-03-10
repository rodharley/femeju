<?php
$menu = 27;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/pessoa/list.html");
$obj = new Pessoa();


//excecuta Mesclagem de usuario
$conn->connection->autocommit(false);
$obj->mesclar($_REQUEST['mescla'],$_REQUEST['mantem']);
$conn->connection->commit();

$TPL->block("BLOCK_MESCLADO");

$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $obj->pesquisarTotal($_REQUEST['nome']);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina);
$alist = $obj->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['nome']);

if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->FOTO = $n->foto != "" ? $n->foto : "pessoa.png";
    $TPL->NOME = $n->getNomeCompleto();
    $TPL->CPF = $obj->formataCPFCNPJ($n->cpf);
    $TPL->ID = $n->id;
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

