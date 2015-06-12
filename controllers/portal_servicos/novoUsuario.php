<?php
$TPL = NEW Template("templates/portal/index.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/servicos/novoUsuario.html");
$TPL->ACAO = "incluir";
$TPL->id = "0";
$TPL->show();
?>