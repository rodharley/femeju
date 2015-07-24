<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/pagina/main.html");
$obj = new Pagina();
$obj->getById($_REQUEST['id']);                            
$TPL->texto = $obj->conteudo;
$TPL->titulo = $obj->titulo;
$TPL->data = date("d/m/Y H:i:s");
$TPL->show();
?>