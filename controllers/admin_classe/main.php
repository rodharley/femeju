<?php
$menu = 36;
include("includes/include.lock.php");
$TPL = NEW Template("templates/admin/main.html");
include("includes/include.montaMenu.php");

//INSTACIA CLASSES
$grad = new Classe();

include("includes/include.mensagem.php");
//CONFIGURA O BREADCRUMB
$TPL->BREADCRUMB = '<section class="content-header">
                    <h1>
                        Classe
                        <small>Lista de Classes</small>
                    </h1>
                   <ol class="breadcrumb">
                                        <li><a href="admin_home-home"><i class="fa fa-home"> </i> Home</a></li>
                                        <li><a href="admin_Classe-main"><i class="fa fa-trophy"> </i> Classe</a></li>
                                         <li class="active">Listar</li>
                                    </ol>
                </section>';


$TPL->addFile("CONTEUDO", "templates/admin/classe/list.html");



$alist = $grad->getRows(0,9999,array("descricao"=>"ASC"));
$TPL->QUANTIDADE = count($alist);
foreach($alist as $key => $gradario){
	$TPL->descricao = $gradario->descricao;
	$TPL->ativo = $gradario->ativo ? "Sim" : "Não";
	$TPL->colorSituacao = $gradario->ativo ? "success" : "danger";	
	$TPL->maximo = $gradario->maximo;
    $TPL->minimo = $gradario->minimo;
	$TPL->ID_HASH = $grad->md5_encrypt($gradario->id);
	$TPL->block("BLOCK_ITEM_LISTA");
}

$TPL->show();
?>