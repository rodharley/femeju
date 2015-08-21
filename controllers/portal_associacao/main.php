<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/associacao/main.html");
$obj = new Associacao;
$TPL->EXECUTA_PESQUISA = "pesquisar();";
$TPL->LOADING = $obj->carregando;
$TPL->show();
?>