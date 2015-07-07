<?php
$objCat = new Categoria(Categoria::CALENDARIO);
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/post/main.html");
$obj = new Post();
$TPL->LOADING = $obj->carregando;
$TPL->PAGINA = 1; 
$TPL->CATEGORIA = $objCat->id;                           
$TPL->EXECUTA_PESQUISA = 'pesquisar();';
$TPL->show();
?>