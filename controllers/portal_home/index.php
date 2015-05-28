<?php
$TPL = NEW Template("templates/portal/index.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/home/main.html");

//##### CARREGA NOTICIAS PRINCIPAIS #####
$objNoticia = new Noticia();
if($objNoticia->recuperaNoticiaPrincipal(1)){
    $TPL->idNoticia= $objNoticia->md5_encrypt($objNoticia->id);
    $TPL->imagem = $objNoticia->foto;
    $TPL->titulo = $objNoticia->titulo;
    $TPL->block("BLOCK_NOTICIA"); 
}
if($objNoticia->recuperaNoticiaPrincipal(2)){
    $TPL->idNoticia= $objNoticia->md5_encrypt($objNoticia->id);
    $TPL->imagem = $objNoticia->foto;
    $TPL->titulo = $objNoticia->titulo;
    $TPL->block("BLOCK_NOTICIA"); 
}



$TPL->show();
?>
