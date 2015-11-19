<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objAn = new Ano();
$objAssociacao = new Associacao();
$objA = new Atleta();
$objC = new Custa();
$objAn = new Anuidade();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/anuidade/anuidadeB.html");
$objAssociacao->getById($objAssociacao->md5_decrypt($_REQUEST['idAssociacaoHash']));
$rsCustas = $objC->getRows(0,999,array(),array("ativo"=>"=1","grupo"=>"=".GrupoCusta::ANUIDADE));
$TPL->NOME_ASSOCIACAO = $objAssociacao->nome;
$TPL->LOGO_ASSOCIACAO = $objAssociacao->logomarca;
$TPL->LABEL = "Anuidade";
$TPL->ID_ASSOCIACAO = $objAssociacao->id;
$TPL->ANO = $_REQUEST['ano'];

if(isset($_REQUEST['todos']))
$rsAtletas = $objA->listaPorAssociacaoInativo($objAssociacao->id);
else
$rsAtletas = $objA->listaPorArrayIds($_REQUEST['atleta']);
foreach ($rsAtletas as $key => $value) {
    $TPL->ATLETA = $value->pessoa->getNomeCompleto();
    $TPL->ID_ATLETA = $value->id;
    //custas
       foreach ($rsCustas as $key2 => $custa) {
            $TPL->ID_CUSTA = $custa->id;
            $TPL->LABEL_CUSTA = $custa->descricao;
            $TPL->block("BLOCK_CUSTA");
        }
    
    $TPL->block("BLOCK_ATLETAS");
}
 

$TPL->show();
?>