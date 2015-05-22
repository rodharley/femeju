<?php
include("configuraAjaxSemLogin.php");
$TPL = new Template("../templates/portal/noticia/main.html");
$obj = new Noticia();

$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$totalPesquisa = $obj->listar3PortalTotal();
$configPaginacao = $obj->paginar($totalPesquisa,$pagina,3);
$rsnot = $obj->listar3Portal($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina']);
foreach ($rsnot as $key => $noticia) {
    $TPL->imagem = $noticia->foto;
    $TPL->titulo = $noticia->titulo;
    $TPL->data = $obj->convdata($noticia->data,"mtnh");
    $TPL->idhash = $obj->md5_encrypt($noticia->id);
    $TPL->block("BLOCK_NOTICIA");
}

//$TPL->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$TPL->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$TPL->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$TPL->PAGINA = $pagina;
if($configPaginacao['totalPaginas'] > 1){
$TPL->block("BLOCK_PAGINACAO");
    if($pagina == 1)
    $TPL->DISABLEL = "disabled";
    
    if($pagina == $configPaginacao['totalPaginas'])
    $TPL->DISABLER = "disabled";
}
$TPL->show();

exit();
?>

