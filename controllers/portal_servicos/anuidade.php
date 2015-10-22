<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objAn = new Ano();
$objAssociacao = new Associacao();

//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/servicos/anuidade.html");
$objAssociacao->getById($objAssociacao->md5_decrypt($_REQUEST['associacao']));
$TPL->NOME_ASSOCIACAO = $objAssociacao->nome;
$TPL->LOGO_ASSOCIACAO = $objAssociacao->logomarca;
$TPL->LABEL = "Anuidade";
$TPL->ID_ASSOCIACAO = $objAssociacao->id;
$TPL->ID_ASSOCIACAO_HASH = $_REQUEST['associacao'];

//anuidade
$rsAnos = $objAn -> listaAnuidades();
foreach ($rsAnos as $key3 => $anuidade) {
    $TPL -> ID_ANO = $anuidade -> anoReferencia;
    $TPL -> LABEL_ANO = $anuidade -> anoReferencia;
    $TPL -> block("BLOCK_ANO");

}

 

$TPL->show();
?>