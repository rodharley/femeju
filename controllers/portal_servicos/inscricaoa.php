<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout.html");
include("includes/include.montaMenuPortal.php");
include("includes/include.mensagem.php");

$objc = new Competicao();
$objGrupoCompeticao = new GrupoCompeticao();
$objGrad = new Graduacao();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/inscricao/inscricaoa.html");
$objc->getById($objc->md5_decrypt($_REQUEST['idComp']));
$rs = $objGrad->listaAtivas();
$rsClasses = $objc->listaClasses();
foreach ($rs as $key => $value) {
	$TPL->ID_GRA = $value->id;
    $TPL->DESC_GRA = $value->descricao;
    $TPL->block("BLOCK_GRA");
}
foreach ($rsClasses as $key => $value) {
    $TPL->ID_CLA = $value->classe->id;
    $TPL->DESC_CLA = $value->classe->descricao;
    $TPL->block("BLOCK_CLA");
}
$TPL->VALOR = $objc->custa->valor;
$TPL->DOBRA_1 = $objc->dobra1;
$TPL->DOBRA_2 = $objc->dobra2;
$TPL->DOBRA_3 = $objc->dobra3;

//PAGAMENTOS
$objTP = new PagamentoTipo();
$rspag = $objTP->getRows();
foreach ($rspag as $key => $value) {
    $TPL->ID_PAG = $value->id;
    $TPL->IMG_PAG = $value->imagem;
    $TPL->NOME_PAG = $value->descricao;
    $TPL->block("BLOCK_TIPO_PAG");
} 



$TPL->LABEL = "preencha os dados dos atletas que deseja realizar a inscri��o";
$TPL->ID_COMPETICAO = $objc->id;
$TPL->TITULO_COMP = $objc->titulo;
$TPL->DATA_COMP = $objc->convdata($objc->dataEvento, "mtn");
$TPL->show();
?>