<?php
$TPL = NEW Template("templates/admin/index.html");
$TPL->addFile("CONTEUDO", "templates/admin/usuario/recuperarSenha.html");
$TPL->show();
?>