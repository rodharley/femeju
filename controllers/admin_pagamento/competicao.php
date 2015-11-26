<?php
$menu = 39;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Associacao();
$grupo = new GrupoCusta();
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Competição</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pagamento"><i class="fa fa-credit-card"> </i> Pagamentos</a></li>
                                         <li class="active">Competição</li>
                                    </ol>
                </section>';
$objc = new Competicao();
$rs = $objc->listaAtivasAbertas();
//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/pagamento/competicao.html");

foreach ($rs as $key => $value) {
    $TPL->ID_COMPETICAO = $obj->md5_encrypt($value->id);
	$TPL->TITULO = $value->titulo;
    $TPL->DESCRICAO = $value->descricao;
    $TPL->DATA = $objc->convdata($value->dataEvento,"mtn");    
    $TPL->block("BLOCK_COMP");
}
$TPL->show();
?>