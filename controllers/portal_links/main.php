<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/links/main.html");
$obj = new Noticia();
$TPL->show();
?>