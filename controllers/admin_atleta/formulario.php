<?php
$menu = 28;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/impressao.html");
include("includes/include.relatorioAdmin.php");
$objAtleta = new Atleta();
$uf = new Uf();
$cidade = new Cidade();
$objAssociacao = new Associacao();
$objGrad = new Graduacao;

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/atleta/formulario.html");




$TPL->show();
?>