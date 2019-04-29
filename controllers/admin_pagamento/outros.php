<?php
$menu = 40;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");
include("includes/include.mensagem.php");
$uf = new Uf();
$cidade = new Cidade();
$listaUf = $uf->getRows();
$objC = new Custa();
$rsCustas = $objC->getRows(0,999,array("descricao"=>"ASC"),array("ativo"=>"=1","grupo"=>"=".GrupoCusta::OUTROS));
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Competição</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_pagamento"><i class="fa fa-credit-card"> </i> Pagamentos</a></li>
                                         <li class="active">Outros</li>
                                    </ol>
                </section>';




//TRATA O CONTEUDO------------------------------------------------------------------------------------------------------------
$TPL->addFile("CONTEUDO", "templates/admin/pagamento/outros.html");



//PAGAMENTOS
$objTP = new PagamentoTipo();
$rspag = $objTP->getRows(0,10,array(),array("ativo"=>"=1"));
$TPL->CHECKED = "checked='checked'";
foreach ($rspag as $key => $value) {
    $TPL->ID_PAG = $value->id;
    $TPL->IMG_PAG = $value->imagem;
    $TPL->NOME_PAG = $value->descricao;
    $TPL->block("BLOCK_TIPO_PAG");
    $TPL->CHECKED = "";
} 
 foreach ($listaUf as $key => $value) {
      $TPL->uf = $value->uf;
      $TPL->id_uf = $value->id;      
      $TPL->block("BLOCK_UF");
      
  }  
//custas
       foreach ($rsCustas as $key2 => $custa) {
            $TPL->ID_CUSTA = $custa->id;
            $TPL->VALOR = $custa->valor;
            $TPL->LABEL_CUSTA = $custa->descricao."- R$ ".$objC->money($custa->valor,"atb");
            $TPL->block("BLOCK_CUSTA");
        }

$TPL->LABEL = "Preencha os dados do pagamento e do Sacado";
$TPL->show();
?>