<?php
include("configuraAjaxSemLogin.php");
$TPL = new Template("../templates/portal/noticia/main.html");
$obj = new Noticia();

$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : "";
$totalPesquisa = $obj->listar3PortalTotal($ano);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina,3);
$rsnot = $obj->listar3Portal($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$ano);
$ARRano = $obj->listarArrayAnos();
foreach ($rsnot as $key => $noticia) {
    $TPL->imagem = $noticia->foto;
    $TPL->titulo = $noticia->titulo;
    $TPL->sumario = $noticia->sumario;
    $TPL->data = $obj->convdata($noticia->data,"mtnh");
    $TPL->idhash = $obj->md5_encrypt($noticia->id);
    if($noticia->foto != "")
    $TPL->block("BLOCK_NOTICIA_P1");
    else
    $TPL->block("BLOCK_NOTICIA_P2");
}

//$TPL->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$TPL->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$TPL->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$TPL->PAGINA = $pagina;
$TPL->ANO = $ano;

if($configPaginacao['totalPaginas'] > 1){
    foreach ($ARRano as $key => $ano) {
        $TPL->ANO_V = $ano;
        $TPL->block("BLOCK_ANO");
    }
$TPL->block("BLOCK_PAGINACAO");
    if($pagina == 1)
    $TPL->DISABLEL = "disabled";
    
    if($pagina == $configPaginacao['totalPaginas'])
    $TPL->DISABLER = "disabled";
}
$TPL->show();

exit();
?>

