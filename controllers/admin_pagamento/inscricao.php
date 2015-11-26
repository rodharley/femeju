<?php
$menu = 39;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Competi��o</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pagamento"><i class="fa fa-credit-card"> </i> Pagamentos</a></li>
                                         <li class="active">Competi��o</li>
                                    </ol>
                </section>';


$objc = new Competicao();
$objGrupoCompeticao = new GrupoCompeticao();
$objGrad = new Graduacao();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/pagamento/inscricao.html");
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