<?php
$menu = 19;
include("configuraAjax.php");
$TPL = NEW Template("../templates/admin/galeria/imagens.html");
$obj = new Galeria();
$objImg = new GaleriaImagem();
$rsimg = $objImg->getRows(0,999,array(),array("galeria"=>"=".$_POST['id']));
foreach ($rsimg as $key => $imagem) {
	$TPL->IMAGEM = $imagem->imagem;
    $TPL->ID_IMG_HASH = $obj->md5_encrypt($imagem->id);
    if(strtolower(substr($imagem->imagem,strlen($imagem->imagem)-3)) == "mp4"){
    	$TPL->block("BLOCK_VIDEO");
    }else{
    	$TPL->block("BLOCK_IMG");
    }
    $TPL->block("BLOCK_IMAGEM");
}
$TPL->show();
exit();
?>