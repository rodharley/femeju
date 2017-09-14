<?php
$menu = 37;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
$uf = new Uf();
$cidade = new Cidade();
$listaUf = $uf->getRows();
$objC = new Custa();
$rsCustas = $objC->getRows(0,999,array(),array("ativo"=>"=1","grupo"=>"=".GrupoCusta::OUTROS));
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Eventos
                        <small>Editar Inscrição </small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pagamento"><i class="fa fa-credit-card"> </i> Eventos</a></li>
                                         <li class="active">Editar Inscrição</li>
                                    </ol>
                </section>';




//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/inscricao/editar.html");

$objPag = new Pagamento();

$objPag->getById($objPag->md5_decrypt($_REQUEST['idPag']));
$objInscr = new Inscricao();
$rs = $objInscr->getInscricoes(0,$objPag->id);

$TPL->ID_PAGAMENTO = $objPag->md5_decrypt($_REQUEST['idPag']);
foreach ($rs as $key => $inscricao) {
	
	$TPL->ID_INSCRICAO = $inscricao->id;
	$TPL->ATLETA = $inscricao->nomeAtleta;
	$TPL->CLASSE = $inscricao->classe != null ? $inscricao->classe->descricao : "Não se aplica";
	$TPL->CATEGORIA = $inscricao->categoria != null ? $inscricao->categoria->descricao : "Não se aplica";
	$TPL->VALOR = $objPag->money($inscricao->valor,"atb");
	
	$TPL->DESCRICAO_DOBRA1 = $inscricao->dobra1 != null ? $inscricao->dobra1->descricao : "Não Selecionada";
	$TPL->VALOR_DOBRA1 = $objPag->money($inscricao->valorDobra1,"atb");
	$TPL->disabled1 = $inscricao->dobra1 == null ? "disabled" : "";
	
	$TPL->DESCRICAO_DOBRA2 = $inscricao->dobra2 != null ? $inscricao->dobra2->descricao : "Não Selecionada";
	$TPL->VALOR_DOBRA2 = $objPag->money($inscricao->valorDobra2,"atb");
	$TPL->disabled2 = $inscricao->dobra2 == null ? "disabled" : "";
	$TPL->DESCRICAO_DOBRA3 = $inscricao->dobra3 != null ? $inscricao->dobra3->descricao : "Não Selecionada";
	$TPL->VALOR_DOBRA3 = $objPag->money($inscricao->valorDobra3,"atb");
	$TPL->disabled3 = $inscricao->dobra3 == null ? "disabled" : "";
	$TPL->block("BLOCK_ATLETAS");
}

$TPL->show();
?>