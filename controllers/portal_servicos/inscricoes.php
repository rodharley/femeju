<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objc = new Competicao();
$rs = $objc->listaAtivasAbertas();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/servicos/evento.html");
$TPL->LABEL = "Escolha o evento que deseja fazer a inscriчуo";
foreach ($rs as $key => $value) {
    $TPL->ID_COMPETICAO = $obj->md5_encrypt($value->id);
	$TPL->TITULO = $value->titulo;
    $TPL->DESCRICAO = $value->descricao;
    $TPL->DATA = $objc->convdata($value->dataEvento,"mtn");
    if($value->tipo == TipoCampeonato::ABERTO){
        if($value->competicao == 1)
            $TPL->CONTROLE = "inscricaoa";
        else
            $TPL->CONTROLE = "inscricaoaEvento";
    $TPL->block("BLOCK_COMP");
    }
}
$TPL->show();
?>