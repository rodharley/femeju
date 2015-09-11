<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/noticia/main.html");
$obj = new Noticia();

$TPL->LOADING = $obj->carregando;
$TPL->PAGINA = 1;                            
$TPL->EXECUTA_PESQUISA = 'pesquisar();';
$TPL->show();
?>