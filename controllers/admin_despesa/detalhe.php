<?php
$menu = 48;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Despesa
                        <small>Alterar Despesa</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pagamento"><i class="fa fa-money"> </i> Despesas</a></li>
                                         <li class="active">Alterar Despesa</li>
                                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/admin/despesa/detalhe.html");

$objGrupo = new DespesaGrupo();
$objDespesa = new Despesa();
$id = $objGrupo->md5_decrypt($_REQUEST['id']);
$objGrupo->getById($id);
$TPL->ID = $id;
$TPL->ID_HASH = $objGrupo->md5_encrypt($id);
$TPL->DESCRICAO = 	$objGrupo->descricao;
$TPL->VALOR = $objGrupo->money($objGrupo->valor, "atb");
$TPL->PARCELAS = $objGrupo->parcelas;
$TPL->DATA = $objGrupo->convdata($objGrupo->dataInicio,"mtn");
$rs = $objDespesa->getRows(0,999,array(),array("grupo"=>"=".$objGrupo->id));
foreach ($rs as $key => $parcela) {
	$TPL->ID_P = $parcela->id;
	$TPL->ID_HASH_P = $objDespesa->md5_encrypt($parcela->id);
	$TPL->PARCELA = $parcela->parcela;
	$TPL->DATA_P = $objDespesa->convdata($parcela->data,"mtn");
	$TPL->VALOR_P = $objDespesa->money($parcela->valor, "atb");
	$TPL->block("BLOCK_PARCELA");
	
}
$TPL->show();
?>