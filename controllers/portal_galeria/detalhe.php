<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/galeria/detalhe.html");
$obj = new Galeria();
$objImg = new GaleriaImagem();
$obj->getById($obj->md5_decrypt($_REQUEST['id']));
$rsimg = $objImg->listaFotos($obj->id);
foreach ($rsimg as $key => $value) {
	$TPL->IMAGEM = $value->imagem;
    if(strtolower(substr($value->imagem,strlen($value->imagem)-3)) == "mp4"){
    	$TPL->block("BLOCK_VIDEO");
	}else
    	$TPL->block("BLOCK_IMG");
    
	$TPL->block("BLOCK_ITEM");
    
}

$TPL->show();
?>