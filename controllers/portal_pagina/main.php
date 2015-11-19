<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/pagina/main.html");
$obj = new Pagina();
$obj->getById($_REQUEST['id']);                            
$TPL->texto = $obj->conteudo;
$TPL->titulo = $obj->titulo;
$TPL->LOADING = CARREGANDO;
if($obj->id == Pagina::CONTATO)
	$TPL->block("BLOCK_EMAIL");
$TPL->show();
?>