<?php
$menu = 43;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$obj = new Associacao();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Carteiras
                        <small>Impressão de Carteiras</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_atleta-main"><i class="fa fa-child"> </i> Carteiras</a></li>
                                         <li class="active">Pesquisar</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/carteira/pesquisa.html");
$TPL->LOADING = CARREGANDO;

$rs = $obj->getRows();
foreach ($rs as $key => $value) {
	$TPL->ID_ASS = $value->id;
	$TPL->LB_ASS = $value->nome;
	$TPL->block("BLOCK_ASSOCIACAO");
}

$TPL->show();
?>