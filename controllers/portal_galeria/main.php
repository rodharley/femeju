<?php
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");
$TPL->addFile("CONTEUDO", "templates/portal/galeria/main.html");
$obj = new Galeria();
$ano = isset($_REQUEST['ano']) ? $_REQUEST['ano'] : Date("Y");
$TPL->LOADING = $obj->carregando;
$TPL->PAGINA = 1; 
$TPL->ANO = $ano;
$TPL->EXECUTA_PESQUISA = 'pesquisar();';
$TPL->show();
?>