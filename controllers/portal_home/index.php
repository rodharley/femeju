<?php
$TPL = NEW Template("templates/portal/layout.html");
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

if($objNoticia->recuperaNoticiaPrincipal(3)){
    $TPL->IDNOTICIA3 = $objNoticia->md5_encrypt($objNoticia->id);
    $TPL->TITULO3 = $objNoticia->titulo;
    $TPL->block("BLOCK_NOTICIA3");      
}
if($objNoticia->recuperaNoticiaPrincipal(4)){
    $TPL->IDNOTICIA4 = $objNoticia->md5_encrypt($objNoticia->id);
    $TPL->TITULO4 = $objNoticia->titulo;
    $TPL->block("BLOCK_NOTICIA4");      
}
if($objNoticia->recuperaNoticiaPrincipal(5)){
    $TPL->IDNOTICIA5 = $objNoticia->md5_encrypt($objNoticia->id);
    $TPL->TITULO5 = $objNoticia->titulo;
    $TPL->block("BLOCK_NOTICIA5");      
}
if($objNoticia->recuperaNoticiaPrincipal(6)){
    $TPL->IDNOTICIA6 = $objNoticia->md5_encrypt($objNoticia->id);
    $TPL->TITULO6 = $objNoticia->titulo;
    $TPL->block("BLOCK_NOTICIA6");      
}
if($objNoticia->recuperaNoticiaPrincipal(7)){
    $TPL->IDNOTICIA7 = $objNoticia->md5_encrypt($objNoticia->id);
    $TPL->TITULO7 = $objNoticia->titulo;
    $TPL->block("BLOCK_NOTICIA7");      
}


$TPL->show();
?>
