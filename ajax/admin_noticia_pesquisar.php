<?php
$menu = 1;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/noticia/list.html");
$noticia = new Noticia();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $noticia->pesquisarTotal($_REQUEST['titulo'],$_REQUEST['texto'],$_REQUEST['periodo']);
$configPaginacao = $noticia->paginar($totalPesquisa,$pagina);
$alist = $noticia->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['titulo'],$_REQUEST['texto'],$_REQUEST['periodo']);

if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->foto = $n->foto != "" ? $n->foto : 'thumb_noticia.png';
    $TPL->titulo = $n->titulo;
    $TPL->data = $noticia->convdata($n->data,"mtnh");
    $TPL->ID_HASH = $noticia->md5_encrypt($n->id);
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

