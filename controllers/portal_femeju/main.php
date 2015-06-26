<?php
$TPL = NEW Template("templates/portal/index.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/femeju/main.html");
$obj = new Noticia();
$TPL->show();
?>