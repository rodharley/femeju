<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$atleta = new Atleta();
$associacao = new Associacao();

$uf = new Uf();

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/servicos/selecionaAssociacao.html");

$rsacademias = $associacao->listaPorResponsavelAtivas($_SESSION['fmj.userId']);
$TPL->SERVICO = $_REQUEST['serv'];
foreach ($rsacademias as $key => $acad) {
	$TPL->NOME_ASSOCIACAO = $acad->nome;
    $TPL->ID_RASH = $associacao->md5_encrypt($acad->id);
    $TPL->block("BLOCK_ASSOCIACAO");
}


$TPL->show();
?>