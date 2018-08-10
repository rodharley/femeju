<?php
include("includes/include.lockPortal.php");
$TPL = NEW Template("templates/portal/layout_inscricao.html");

include("includes/include.mensagem.php");

$objc = new Competicao();
$objGrupoCompeticao = new GrupoCompeticao();
$objGrad = new Graduacao();
$associacao = new Associacao();
$objConf = new Configuracoes();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/portal/inscricao/inscricaoa.html");
$objc->getById($objc->md5_decrypt($_REQUEST['idEvento']));
$rs = $objGrad->listaAtivas();
$rsacademias = $associacao->listaPorResponsavelAtivas($_SESSION['fmj.userId']);
$idsAssoc = $objc->md5_decrypt($_REQUEST['idAssoc']);
/*foreach ($rsacademias as $key => $acad) {
    $idsAssoc .= ",".$acad->id;
}*/
$TPL->IDS_ASSOCIACAO = $idsAssoc;
$taxas = $objConf->recuperaConfiguracoesTaxa();
$TPL->TAXA_PP = $taxas[13];
$TPL->TAXA_GN = $taxas[12];


//$rsClasses = $objc->listaClasses();
foreach ($rs as $key => $value) {
	$TPL->ID_GRA = $value->id;
    $TPL->DESC_GRA = $value->descricao;
    $TPL->block("BLOCK_GRA");
}
/*
foreach ($rsClasses as $key => $value) {
    $TPL->ID_CLA = $value->classe->id.";".$value->classe->maximo.";".$value->classe->minimo;
    $TPL->DESC_CLA = $value->classe->descricao." - de ".$value->classe->minimo." У  ".$value->classe->maximo." anos";
    $TPL->block("BLOCK_CLA");    
	$categoria = new CategoriaPeso();
	$rsCategs = $categoria->listaAtivasPorClasse($value->classe->id);
	foreach ($rsCategs as $key2 => $value2) {
		$TPL->ID_CAT = $value2->id.";".$value->classe->maximo.";".$value->classe->minimo;
		$TPL->DESC_CAT = $value2->descricao;
		$TPL->block("BLOCK_DOBRA1_CAT");
		$TPL->block("BLOCK_DOBRA2_CAT");
		$TPL->block("BLOCK_DOBRA3_CAT");
	}
	$TPL->block("BLOCK_DOBRA1_CL");
    $TPL->block("BLOCK_DOBRA2_CL");
    $TPL->block("BLOCK_DOBRA3_CL");
}*/

$TPL->VALOR = $objc->custa->valor;
$TPL->DOBRA_1 = $objc->dobra1;
$TPL->DOBRA_2 = $objc->dobra2;
$TPL->DOBRA_3 = $objc->dobra3;

//PAGAMENTOS
$objTP = new PagamentoTipo();
$rspag = $objTP->getRows(0,10,array(),array("ativo"=>"=1"));
//$TPL->CHECKED = "checked='checked'";
foreach ($rspag as $key => $value) {
    $TPL->ID_PAG = $value->id;
    $TPL->IMG_PAG = $value->imagem;
    $TPL->NOME_PAG = $value->descricao;
    $TPL->block("BLOCK_TIPO_PAG");
    $TPL->CHECKED = "";
} 

if($objc->percentDesconto > 0){
	$TPL->PERCENT = $objc->percentDesconto;
	$TPL->DATA_DESCONTO = $objc -> convdata($objc -> dataDesconto, "mtn");
	$TPL->block("BLOCK_DESCONTO");
}

$TPL->LABEL = "preencha os dados dos atletas que deseja realizar a inscriчуo";
$TPL->ID_COMPETICAO = $objc->id;
$TPL->TITULO_COMP = $objc->titulo;
$TPL->DATA_COMP = $objc->convdata($objc->dataEvento, "mtn");
$TPL->show();
?>