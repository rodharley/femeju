<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout_inscricao.html");

include("includes/include.mensagem.php");

$objc = new Competicao();
$objGrupoCompeticao = new GrupoCompeticao();
$objGrad = new Graduacao();
$associacao = new Associacao();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/inscricao/inscricaoa_evento.html");
$objc->getById($objc->md5_decrypt($_REQUEST['idEvento']));
$rs = $objGrad->listaAtivas();
$rsacademias = $associacao->listaPorResponsavelAtivas($_SESSION['fmj.userId']);
$idsAssoc = "0";
foreach ($rsacademias as $key => $acad) {
    $idsAssoc .= ",".$acad->id;
}
$TPL->IDS_ASSOCIACAO = $idsAssoc;
foreach ($rs as $key => $value) {
	$TPL->ID_GRA = $value->id;
    $TPL->DESC_GRA = $value->descricao;
    $TPL->block("BLOCK_GRA");
}

$TPL->VALOR = $objc->custa->valor;

//PAGAMENTOS
$objTP = new PagamentoTipo();
$rspag = $objTP->getRows();
$TPL->CHECKED = "checked='checked'";
foreach ($rspag as $key => $value) {
    $TPL->ID_PAG = $value->id;
    $TPL->IMG_PAG = $value->imagem;
    $TPL->NOME_PAG = $value->descricao;
    $TPL->block("BLOCK_TIPO_PAG");
    $TPL->CHECKED = "";
} 



$TPL->LABEL = "preencha os dados dos atletas que deseja realizar a inscri��o";
$TPL->ID_COMPETICAO = $objc->id;
$TPL->TITULO_COMP = $objc->titulo;
$TPL->DATA_COMP = $objc->convdata($objc->dataEvento, "mtn");
$TPL->show();
?>