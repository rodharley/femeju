<?php
$menu = 37;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES


include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Relatórios
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                     <li><a href="#"><i class="fa fa-files-o"> </i> Relatórios</a></li>
                        <li class="active"><a href="#"><i class="fa fa-money"> </i> Financeiro</a></li>
                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/relatorio/financeiro.html");
$oEmpresa = new Empresa();
$TPL->LOADING = $oEmpresa->carregando;
$list = $oEmpresa->listarPorPerfil();
foreach ($list as $key => $empresa) {
	$TPL->VALUE_EMPRESA = $empresa->id;
    $TPL->LABEL_EMPRESA = $empresa->nomeFantasia;
    $TPL->block("BLOCK_ITEM_EMPRESA");
}

$TPL->show();
?>