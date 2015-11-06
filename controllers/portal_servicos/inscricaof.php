<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objc = new Competicao();
$objAssociacao = new Associacao();
$objGrupoCompeticao = new GrupoCompeticao();
$objA = new Atleta();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/inscricao/inscricaof.html");
$objAssociacao->getById($objAssociacao->md5_decrypt($_REQUEST['idAssoc']));
$objc->getById($objc->md5_decrypt($_REQUEST['idComp']));

$TPL->LABEL = "Escolha os atletas que deseja realizar a inscriчуo";
$TPL->ID_ASSOCIACAO = $objAssociacao->id;
$TPL->ID_COMPETICAO = $objc->id;
$TPL->TITULO_COMP = $objc->titulo;
$TPL->DATA_COMP = $objc->convdata($objc->dataEvento, "mtn");
$rsAtletas = $objA->listaPorAssociacaoAtivos($objAssociacao->id);

foreach ($rsAtletas as $key => $value) {
    if($value->graduacao != null){
    $TPL->ATLETA = $value->pessoa->getNomeCompleto();
    $TPL->ID_ATLETA = $value->id;
    
    $TPL->block("BLOCK_ATLETAS");
    
    }
}

$TPL->show();
?>