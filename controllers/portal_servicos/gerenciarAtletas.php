<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$atleta = new Atleta();
$associacao = new Associacao();

$uf = new Uf();

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/atleta/gerenciarAtletas.html");
$idAssociacao = $atleta->md5_decrypt($_REQUEST['associacao']);
$rsAtletas = $atleta->listaPorAssociacao($idAssociacao);
$associacao->getById($idAssociacao);
$TPL->ASSOCIACAO = $associacao->nome;
$TPL->ID_ASS_RASH = $_REQUEST['associacao'];
foreach ($rsAtletas as $key => $a) {
	$TPL->NOME_ATLETA = $a->pessoa->getNomeCompleto();    
    if($a->graduacao != null){
    $TPL->FAIXA = $a->graduacao->faixa;
	}else{
	$TPL->FAIXA = 'não cadastrada';	
	}
    $TPL->ID_RASH = $associacao->md5_encrypt($a->id);
    $TPL->block("BLOCK_ATLETA");
}

$TPL->show();
?>