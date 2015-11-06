<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objc = new Competicao();
$rs = $objc->listaAtivasAbertas();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/servicos/competicao.html");
$TPL->LABEL = "Escolha a competiчуo que deseja fazer a inscriчуo";
foreach ($rs as $key => $value) {
    $TPL->ID_COMPETICAO = $obj->md5_encrypt($value->id);
	$TPL->TITULO = $value->titulo;
    $TPL->DESCRICAO = $value->descricao;
    $TPL->DATA = $objc->convdata($value->dataEvento,"mtn");
    if($value->tipo == TipoCampeonato::ABERTO){
        $TPL->CONTROLE = "inscricaoa";
    $TPL->block("BLOCK_COMP");
    }
}
$TPL->show();
?>