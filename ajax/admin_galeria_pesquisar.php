<?php
$menu = 19;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/galeria/list.html");
$galeria = new Galeria();
$img = new GaleriaImagem();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $galeria->pesquisarTotal($_REQUEST['titulo'],$_REQUEST['periodo']);
$configPaginacao = $galeria->paginar($totalPesquisa,$pagina);
$alist = $galeria->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['titulo'],$_REQUEST['periodo']);

if (count($alist) > 0) {
foreach($alist as $key => $n){
    $objImg = $img->retornaUmaImagem($n->id);
    $TPL->foto = $objImg->imagem;    
    $TPL->titulo = $n->titulo;
    $TPL->data = $galeria->convdata($n->data,"mtnh");
    $TPL->ID_HASH = $galeria->md5_encrypt($n->id);
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

