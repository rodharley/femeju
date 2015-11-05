<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objc = new Competicao();
$objAssociacao = new Associacao();
$rs = $objc->listaAtivasAbertas();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/servicos/competicao.html");
$objAssociacao->getById($objAssociacao->md5_decrypt($_REQUEST['associacao']));
$TPL->LABEL = "Escolha a competiчуo que deseja fazer a inscriчуo";
$TPL->ID_ASSOCIACAO = $objAssociacao->id;
$TPL->ID_ASSOCIACAO_HASH = $_REQUEST['associacao'];
foreach ($rs as $key => $value) {
    $TPL->ID_COMPETICAO = $obj->md5_encrypt($value->id);
	$TPL->TITULO = $value->titulo;
    $TPL->DESCRICAO = $value->descricao;
    $TPL->DATA = $objc->convdata($value->dataEvento,"mtn");
    if($value->tipo == TipoCampeonato::FECHADO)
        $TPL->CONTROLE = "inscricaof";
    else
        $TPL->CONTROLE = "inscricaoa";
    $TPL->block("BLOCK_COMP");
}
$TPL->show();
?>