<?php
$menu = 31;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Associacao();
$objA = new Atleta();
$objC = new Custa();
$objAn = new Anuidade();
include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Pagamento
                        <small>Anuidade</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade"><i class="fa fa-credit-card"> </i> Anuidade</a></li>
                                         <li class="active">Gerar Guia de Pagamento</li>
                                    </ol>
                </section>';

$TPL->addFile("CONTEUDO", "templates/admin/anuidade/pagamento.html");
$obj->getById($_REQUEST['associacao']);
$rsCustas = $objC->getRows(0,999,array(),array("ativo"=>"=1","grupo"=>"=".GrupoCusta::ANUIDADE));

$TPL->ANO = $_REQUEST['ano'];



if(isset($_REQUEST['todos']))
$rsAtletas = $objA->listaPorAssociacaoInativo($obj->id);
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

//PAGAMENTOS
$objTP = new TipoPagamento();
$rspag = $objTP->getRows();
foreach ($rspag as $key => $value) {
    $TPL->ID_PAG = $value->id;
    $TPL->IMG_PAG = $value->imagem;
    $TPL->NOME_PAG = $value->descricao;
    $TPL->block("BLOCK_TIPO_PAG");
} 
$TPL->show();
?>