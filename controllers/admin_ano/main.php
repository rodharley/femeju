<?php
$menu = 38;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$grad = new Ano();

include("includes/include.mensagem.php");

//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Anuidade
                        <small>Lista de Anos</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_anuidade-main"><i class="fa fa-trophy"> </i> Anuidades</a></li>
                                         <li class="active">Lista</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/ano/list.html");



$alist = $grad->getRows();
$TPL->QUANTIDADE = count($alist);
foreach($alist as $key => $gradario){
        $TPL->ano = $gradario->anoReferencia;
        $TPL->data= $grad->convdata($gradario->dataVencimento,"mtn");
    	$TPL->ID_HASH = $grad->md5_encrypt($gradario->id);
	$TPL->block("BLOCK_ITEM_LISTA");
}
$TPL->show();
?>