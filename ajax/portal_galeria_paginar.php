<?php
include("configuraAjaxSemLogin.php");
$TPL = new Template("../templates/portal/galeria/main.html");

$pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : Date("Y");

$obj = new Galeria();
$img = new GaleriaImagem();
$totalPesquisa = $obj->listar3PortalTotal($ano);
$configPaginacao = $obj->paginar($totalPesquisa,$pagina,$obj->PAGINACAO);
$rspost = $obj->listar3Portal($configPaginacao['primeiroRegistro'],$configPaginacao['quantidadePorPagina'],$ano);
$ARRano = $obj->listarArrayAnos();
foreach ($rspost as $key => $post) {
    $img = $img->retornaUmaImagem($post->id);
    $TPL->post_data = $obj->convdata($post->data,"mtn");
	$TPL->post_titulo = $post->titulo;
    
    if(strtolower(substr($img->imagem,strlen($img->imagem)-3)) == "mp4"){
    	$TPL->IMAGEM = "video.png";
    }else{
    	$TPL->IMAGEM = $img->imagem;
    }
    	
    $TPL->ID_HASH = $obj->md5_encrypt($post->id);
    $TPL->block("BLOCK_POST");
    
}

//$TPL->TOTAL_PAGINAS = $configPaginacao['totalPaginas'];
$TPL->PAGINA_ANTERIOR = $configPaginacao['paginaAnterior'];
$TPL->PROXIMA_PAGINA = $configPaginacao['proximaPagina'];
$TPL->PAGINA = $pagina;
$TPL->ANO = $ano;
foreach ($ARRano as $key => $ano) {
        $TPL->ANO_V = $ano;
        $TPL->block("BLOCK_ANO");
}
    if($pagina == 1)
    $TPL->DISABLEL = "disabled";
    
    if($pagina == $configPaginacao['totalPaginas'])
    $TPL->DISABLER = "disabled";

$TPL->show();

exit();
?>

