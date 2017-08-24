<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objAn = new Ano();
$objAssociacao = new Associacao();
$ocomp = new Competicao();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/relatorio/inscritos.html");
$objAssociacao->getById($objAssociacao->md5_decrypt($_REQUEST['associacao']));
$TPL->NOME_ASSOCIACAO = $objAssociacao->nome;
$TPL->ID_ASSOCIACAO = $objAssociacao->id;
$rs = $ocomp->listaTodas();
foreach ($rs as $key => $value) {
	$TPL->TITULO = $value->titulo;
	$TPL->ID = $value->id;
	$TPL->block("BLOCK_EVENTO");
}


$TPL->show();
?>