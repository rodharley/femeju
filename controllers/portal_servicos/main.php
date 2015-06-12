<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/index.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/servicos/main.html");
$TPL->show();
?>