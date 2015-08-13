<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/galeria/detalhe.html");
$obj = new Galeria();
$objImg = new GaleriaImagem();
$obj->getById($obj->md5_decrypt($_REQUEST['id']));
$rsimg = $objImg->listaFotos($obj->id);
foreach ($rsimg as $key => $value) {
    
    $TPL->IMAGEM = $value->imagem;
    
	$TPL->block("BLOCK_ITEM");
    
}

$TPL->show();
?>