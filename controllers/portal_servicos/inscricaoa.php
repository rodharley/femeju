<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objc = new Competicao();
$objGrupoCompeticao = new GrupoCompeticao();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/inscricao/inscricaoa.html");
$objc->getById($objc->md5_decrypt($_REQUEST['idComp']));
$rs = $objGrupoCompeticao->listar($objc->id);
foreach ($rs as $key => $value) {
	$TPL->ID_GRA = $value->graduacao->id;
    $TPL->DESC_GRA = $value->graduacao->descricao;
    $TPL->block("BLOCK_GRA");
}

$TPL->LABEL = "preencha os dados dos atletas que deseja realizar a inscriчуo";
$TPL->ID_COMPETICAO = $objc->id;
$TPL->TITULO_COMP = $objc->titulo;
$TPL->DATA_COMP = $objc->convdata($objc->dataEvento, "mtn");
$TPL->show();
?>