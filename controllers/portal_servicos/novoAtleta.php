<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.mensagem.php");

$atleta = new Atleta();
$academia = new Academia();

$uf = new Uf();

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/servicos/novoFiliacao.html");

$rsufs = $uf->getrows();
foreach ($rsufs as $key => $uf) {
	$TPL->idUf = $uf->id;
    $TPL->lblUf = $uf->uf;
    $TPL->block("BLOCK_UF1");
    $TPL->block("BLOCK_UF2");
    $TPL->block("BLOCK_UF3");   
}

$rsacademias = $academia->getRows();
foreach ($rsacademias as $key => $acad) {
	$TPL->NOMEACADEMIA = $acad->nome;
    //$TPL->IDACADEMIA = $acad->id;
    $TPL->block("BLOCK_ACADEMIAS");
}

$rsi = $rsInstrutores = $atleta->listaTodosInstrutores();
foreach ($rsi as $key => $inst) {
    $TPL->NOME_INSTRUTOR = $inst->nome;
    $TPL->ID_INSTRUTOR = $inst->id;
    $TPL->block("BLOCK_INSTRUTOR");
}

$TPL->show();
?>