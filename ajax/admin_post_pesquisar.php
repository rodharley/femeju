<?php
$menu = 0;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/post/list.html");
$post = new Post();
$objCat = new Categoria();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$categoria = isset($_REQUEST['categoria']) ? $_REQUEST['categoria'] : 1;

$pasta = $objCat->retornaPasta($categoria);
$TPL->PASTA = $pasta;
$TPL->ID_CATEGORIA_HASH = $post->md5_encrypt($categoria);
$totalPesquisa = $post->pesquisarTotal($_REQUEST['titulo'],$_REQUEST['texto'],$_REQUEST['periodo'],$categoria);
$configPaginacao = $post->paginar($totalPesquisa,$pagina);
$alist = $post->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['titulo'],$_REQUEST['texto'],$_REQUEST['periodo'],$categoria);




if (count($alist) > 0) {
foreach($alist as $key => $n){
    $TPL->foto = $n->imagem != "" ? $n->imagem : 'thumb_post.png';
    $TPL->titulo = $n->titulo;
    $TPL->data = $post->convdata($n->data,"mtnh");
    $TPL->ID_HASH = $post->md5_encrypt($n->id);
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

