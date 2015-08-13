<?php
$menu = 0;
include("configuraAjax.php");
$TPL = new Template("../templates/admin/diretoria/list_post.html");
$post = new Post();
$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$diretoria = new Diretoria();
if(!$diretoria->getByResponsavel($_SESSION['fmj.userId'])){
    exit();
}


$pasta = "diretoria";
$TPL->PASTA = $pasta;
//$TPL->ID_CATEGORIA_HASH = $post->md5_encrypt($categoria);
$totalPesquisa = $post->pesquisarTotal($_REQUEST['titulo'],$_REQUEST['texto'],$_REQUEST['periodo'],$diretoria->id);
$configPaginacao = $post->paginar($totalPesquisa,$pagina);
$alist = $post->pesquisar($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$_REQUEST['titulo'],$_REQUEST['texto'],$_REQUEST['periodo'],$diretoria->id);




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
$TPL->block("BLOCK_PAGINACAO");
}
$TPL->show();

exit();
?>

